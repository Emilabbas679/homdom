<?php

defined('AIN') or exit('NO DICE!');

class AIN_Template
{
	protected $sReservedVarname = 'AIN';
	public $sDisplayLayout = 'template';
	protected $sLeftDelim = '{{';
	protected $sRightDelim = '}}';
	//Sectionlar
    public $_aSections = array(
		'template' => 'start'
	);
	



	private $_sThemeFolder;
	private $_sThemeLayout;
	private $_sStyleFolder;

	private $_aTitles = array();
	private $_aVars = array('bUseFullSite' => false);


    /**
     * @var string
     */
    private $_sAddScripts = '';
	
	

	/**
	 * Check to see if we are displaying a sample page.
	 *
	 * @var bool
	 */
	public $bIsSample = false;
	private $_bIsAdminCp = false;
	private $_sFooter = '';	
	private $oTranslations = array();

	public function __construct()
	{
		if (AIN::getParam('core.module_core') == AIN::getParam('admincp.admin_cp'))
		{
			$this->_bIsAdminCp = true;
			$this->_sThemeLayout = 'adminpanel';
		}
		else
		{
			$this->_sThemeLayout = 'frontend';
		}		
		$this->_sThemeFolder = AIN::getParam('core.theme_folder_name');
		$this->_sStyleFolder = AIN::getParam('core.style_folder_name');		
	}
	
    public function getThemeLayout()
    {
        return $this->_sThemeLayout;
    }
    public function getThemeFolder()
    {
        return $this->_sThemeFolder;
    }
	public function getLayout($sName, $bReturn = false)
	{
		$this->_getFromCache($this->getLayoutFile($sName));

		if ($bReturn)
		{
			return $this->_returnLayout();
		}
	}
	private function _returnLayout()
	{
		$sContent = ob_get_contents();

		ob_clean();

		return $sContent;
	}
	private function _requireFile($sFile)
	{
		require($this->_getCachedName($sFile));
	}
	
	public function _getCachedName($sName)
	{
		if (!defined('AIN_TMP_DIR'))
		{
			if (!is_dir(AIN_DIR_CACHE . 'template' . AIN_DS))
			{
				mkdir(AIN_DIR_CACHE . 'template' . AIN_DS);
				chmod(AIN_DIR_CACHE . 'template' . AIN_DS, 0777);
			}
		}
		return (defined('AIN_TMP_DIR') ? AIN_TMP_DIR : AIN_DIR_CACHE) . ((defined('AIN_TMP_DIR') || AIN_SAFE_MODE) ? 'template_' : 'template/') . str_replace(array(AIN_DIR_THEME, AIN_DIR_MODULE, AIN_DS), array('', '', '_'), $sName) . (AIN::isAdminPanel() ? '_admincp' : '') . (AIN_IS_AJAX ? '_ajax' : '') . '.php';
	}

	private function _isCached($sName)
	{
		if (defined('AIN_NO_TEMPLATE_CACHE'))
		{
			return false;
		}
		if (! file_exists($this->_getCachedName($sName)) )
		{
			return false;
		}		
		if (file_exists($sName))
		{
			if( filemtime($this->_getCachedName($sName)) < filemtime($sName)  )	
			{
				return false;
			}
		}
		return true;
	}
	private function _getFromCache($sFile)
	{
		if (!$this->_isCached($sFile))
		{
			$oTplCache = AIN::getLib('template.cache');

			$sContent = (file_exists($sFile) ? file_get_contents($sFile) : null);

			$mData = $oTplCache->compile($this->_getCachedName($sFile), $sContent);
		}

		// No cache directory so we must
		if (defined('AIN_INSTALLER_NO_TMP'))
		{
			eval(' ?>' . $mData . '<?php ');
			exit;
		}
		(AIN_DEBUG ? AIN_Debug::start('template') : false);

		$this->_requireFile($sFile);

		(AIN_DEBUG ? AIN_Debug::end('template', array('name' => $sFile)) : false);
	}
	public function getLayoutFile($sName)
	{
		$sFile = AIN_DIR_THEME . $this->_sThemeLayout . AIN_DS . $this->_sThemeFolder . AIN_DS . 'template' . AIN_DS . $sName . AIN_TPL_SUFFIX;

		if (!file_exists($sFile))
		{
			$sFile = AIN_DIR_THEME . $this->_sThemeLayout . AIN_DS . 'default' . AIN_DS . 'template' . AIN_DS . $sName . AIN_TPL_SUFFIX;
		}

		if ($this->_sThemeLayout == 'mobile' && !file_exists($sFile))
		{
			$sFile = AIN_DIR_THEME . 'frontend' . AIN_DS . 'default' . AIN_DS . 'template' . AIN_DS . $sName . AIN_TPL_SUFFIX;
		}
		return $sFile;
	}

	public function getBuiltFile($sFile)
	{
		$sCacheName = $this->_sThemeFolder.'_block_' . $sFile;
		
		if (!$this->_isCached($sCacheName))
		{
			$mContent = AIN_Template::instance()->getTemplateFile($sFile, true);
			
			if (is_array($mContent))
			{
				$mContent = $mContent[0];
			}
			else
			{
				$mContent = file_get_contents($mContent);
			}

			$oTplCache = AIN::getLib('template.cache');
			
			$oTplCache->compile($this->_getCachedName($sCacheName), $mContent, true);
		}

		require($this->_getCachedName($sCacheName));
	}

	/**
	 * All data placed between the HTML tags <head></head> can be added with this method.
	 * Since we rely on custom templates we need the header data to be custom as well. Current
	 * support is for: css & JavaScript
	 * All HTML added here is coded under XHTML standards.
	 *
	 * @access public
	 * @param array $mHeaders
	 * @return $this
	 */
	public function setHeader($mHeaders, $mValue = null)
	{
		if ($mHeaders == 'cache')
		{
			if (AIN::getParam('core.cache_js_css') && !AIN_IS_AJAX )
			{
				foreach ($mValue as $sKey => $mNewValue)
				{
					$this->_aCacheHeaders[$sKey][$mNewValue] = true;
				}
			}

			$this->_aHeaders[] = $mValue;
		}
		else
		{
			if ($mValue !== null)
			{
				if ($mHeaders == 'head')
				{
					$mHeaders = array($mValue);
				}
				else
				{
					$mHeaders = array($mHeaders => $mValue);
				}
			}

			$this->_aHeaders[] = $mHeaders;
		}

		return $this;
	}
	/**
	 * Gets a 32 string character of the version of the static files
	 * on the site.
	 *
	 * @return string 32 character MD5 sum
	 */
	public function getStaticVersion()
	{
		$sVersion = md5($this->_sThemeFolder . '-' . $this->_sStyleFolder);

		return $sVersion;
	}
	/**
	 * Gets any data we plan to place within the HTML tags <head></head>.
	 * This method also groups the data to give the template a nice clean look.
	 *
	 * @return string|array $sData Returns the HTML data to be placed within <head></head>
	 */
	public function getHeader($bReturnArray = false)
	{
		$sData = $sJs = '';
		$iVersion = $this->getStaticVersion();

		if ( ! AIN_IS_AJAX_PAGE )
		{
			$aJsVars = array
			(
				'sBaseURL' => AIN::getParam('core.path'),
				'sJsHome' => AIN::getParam('core.path_file'),
				'sJsHostname' => isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'localhost',
				'sVersion' => AIN::getId(),
				'sController' => AIN_Module::instance()->getFullControllerName(),
				'sGetMethod' => AIN_GET_METHOD,
				'sGlobalTokenName' => AIN::getTokenName(),
				'sJsAjax' => AIN::getParam('core.ajax_path'),
				'security_token' => AIN::getLib('request')->getIdHash(),
				'sStaticVersion' => $iVersion,
				AIN_GET_LANGUAGE => AIN::getLib('locale')->getLangId(),
			);
			$sJs .= "\t\tvar oParams = ".json_encode($aJsVars).";\n";

			$aLocaleVars = array(
				'core.are_you_sure',
                'adnetwork.colvis',
                'general.print',
                'general.printall',
                'general.printselected'
			);
			
			
			//Kenardan elave lazım olan translate qoshmaq ucun;
			$aLocaleVars = array_merge($aLocaleVars, $this->oTranslations);
			$sJs .= "\t\tvar oTranslations = {";
			$iCnt = 0;
			foreach ($aLocaleVars as $sValue)
			{
				$iCnt++;
				if ($iCnt != 1)
				{
					$sJs .= ",";
				}

				$sJs .= "'{$sValue}': '" . html_entity_decode(str_replace("'", "\'", AIN::getPhrase($sValue)), null, 'UTF-8') . "'";
			}
			$sJs .= "};\n";
		}


		$sCacheData = '';
		$sCacheData .= "\t<script>\n";
		$sCacheData .= $sJs;
		$sCacheData .= "\t\tvar \$Behavior = {};\n";
		$sCacheData .= "\t\tvar \$Core = {};\n";
		$sCacheData .= "\t</script>";


		if (!empty($sCacheData))
		{
			$sData = $sCacheData;
		}
		if ($bReturnArray)
		{
			$sData = '';
		}


		$this->_aHeaders = array();
		$this->_aMeta = array();

		return $sData;
	}



	/**
	 * Set the page title in a public array so we can get it later
	 * and display within the template.
	 *
	 * @see getTitle()
	 * @param string $sTitle Title to display on a specific page
	 * @return $this
	 */
	public function setTitle($sTitle)
	{
		$this->_aTitles[] = $sTitle;


		return $this;
	}
	public function getTitle()
	{
		$oFilterOutput = AIN::getLib('parse.output');

		$sData = '';
		foreach ($this->_aTitles as $sTitle)
		{
			$sData .= $oFilterOutput->clean($sTitle) . ' ' . AIN::getParam('core.title_delim') . ' ';
		}

		if (! AIN::getParam('core.include_site_title_all_pages') )
		{
			$sData .= (defined('AIN_INSTALLER') ? AIN::getParam('core.global_site_title') : AIN::getLib('locale')->convert(AIN::getParam('core.global_site_title')));
		}
		else
		{
			$sData = trim(rtrim(trim($sData), AIN::getParam('core.title_delim')));
			if (empty($sData))
			{
				$sData = (defined('AIN_INSTALLER') ? AIN::getParam('core.global_site_title') : AIN::getLib('locale')->convert(AIN::getParam('core.global_site_title')));
			}
		}
		return $sData;
	}
	public function setBreadCrumb($sPhrase, $sLink = '', $bIsTitle = false)
	{
		return $this;
	}

	/**
	 * Assign a variable so we can use it within an HTML template.
	 *
	 * PHP assign:
	 * <code>
	 * AIN_Template::instance()->assign('foo', 'bar');
	 * </code>
	 *
	 * HTML usage:
	 * <code>
	 * {$foo}
	 * // Above will output: bar
	 * </code>
	 *
	 * @param mixed $mVars STRING variable name or ARRAY of variables to assign with both keys and values.
	 * @param string $sValue Variable value, only if the 1st argument is a STRING.
	 * @return $this
	 */
	public function assign($mVars, $sValue = '')
	{
		if (!is_array($mVars))
		{
			$mVars = array($mVars => $sValue);
		}

		foreach ($mVars as $sVar => $sValue)
		{
			if (is_array($sValue) && count($sValue)) {
				if (isset($sValue[0])) {
					$first = $sValue[0];
					if (is_object($first) && method_exists($first, '__toArray')) {
						$sValue = array_map(function($val) {

							return (array) $val;
						}, $sValue);
					}
				}
			}
			if (is_object($sValue) && method_exists($sValue, '__toArray')) {
				$sValue = (array) $sValue;
			}

			$this->_aVars[$sVar] = $sValue;
		}

		return $this;
	}
	/**
	 * Force the page to use its full width and not display anything within the sidepanel.
	 *
	 * @return $this
	 */
	public function setFullSite()
	{

		return $this;
	}




	/**
	 * This function controls if we should load `content` delayed. It is called from the template.cache library
	 */
	public function shouldLoadDelayed($sController)
	{

	}



	/**
	 * Gets the full path of a file based on the current style being used.
	 *
	 * @param string $sType Type of file we are working with.
	 * @param string $sValue File name.
	 * @param string $sModule Module name. Only if its part of a module.
	 * @return string Returns the full path to the item.
	 */
	public function getStyle($sType = 'css', $sValue = null, $sModule = null)
	{
		if ($sModule !== null)
		{
			die('yazilmayib');
		}

		if ($sType == 'static_script')
		{
			$sPath = AIN::getParam('core.url_static_script') . $sValue;
		}
		else
		{
			$sPath = (defined('AIN_INSTALLER') ? AIN_Installer::getHostPath() : AIN_DIR) . 'theme/' . $this->_sThemeLayout . '/' . $this->_sThemeFolder . '/style/' . $this->_sStyleFolder . '/' . $sType . '/';

			if ($sValue !== null)
			{
				$bPass = false;

				if (isset($this->_aTheme['style_parent_id']) && $this->_aTheme['style_parent_id'] > 0)
				{
					$bPass = false;
					if (file_exists(AIN_DIR . 'theme' . AIN_DS . $this->_sThemeLayout . AIN_DS . $this->_sThemeFolder . AIN_DS . 'style' . AIN_DS . $this->_sStyleFolder . AIN_DS . $sType . AIN_DS . $sValue))
					{
						$bPass = true;
						$sPath = AIN::getParam('core.path_file') . 'theme' . '/' . $this->_sThemeLayout . '/' . $this->_sThemeFolder . '/' . 'style' . '/' . $this->_sStyleFolder . '/' . $sType . '/' . $sValue;
					}

					if (isset($this->_aTheme['parent_theme_folder']))
					{
						if ($bPass === false && file_exists(AIN_DIR . 'theme' . AIN_DS . $this->_sThemeLayout . AIN_DS . $this->_aTheme['parent_theme_folder'] . AIN_DS . 'style' . AIN_DS . $this->_aTheme['parent_style_folder'] . AIN_DS . $sType . AIN_DS . $sValue))
						{
							$bPass = true;
							$sPath = AIN::getParam('core.path_file') . 'theme' . '/' . $this->_sThemeLayout . '/' . $this->_aTheme['parent_theme_folder'] . '/' . 'style' . '/' . $this->_aTheme['parent_style_folder'] . '/' . $sType . '/' . $sValue;
						}
					}
					else
					{
						if ($bPass === false && file_exists(AIN_DIR . 'theme' . AIN_DS . $this->_sThemeLayout . AIN_DS . $this->_sThemeFolder . AIN_DS . 'style' . AIN_DS . $this->_aTheme['parent_style_folder'] . AIN_DS . $sType . AIN_DS . $sValue))
						{
							$bPass = true;
							$sPath = AIN::getParam('core.path_file') . 'theme' . '/' . $this->_sThemeLayout . '/' . $this->_sThemeFolder . '/' . 'style' . '/' . $this->_aTheme['parent_style_folder'] . '/' . $sType . '/' . $sValue;
						}
					}
				}
				else
				{
					if (!defined('AIN_INSTALLER'))
					{
						if (file_exists(AIN_DIR . 'theme' . AIN_DS . $this->_sThemeLayout . AIN_DS . $this->_sThemeFolder . AIN_DS . 'style' . AIN_DS . $this->_sStyleFolder . AIN_DS . $sType . AIN_DS . $sValue))
						{
							$bPass = true;
							$sPath = ($sType == 'php' ?  AIN_DIR : AIN::getParam('core.path_file') )  . 'theme' . '/' . $this->_sThemeLayout . '/' . $this->_sThemeFolder . '/' . 'style' . '/' . $this->_sStyleFolder . '/' . $sType . '/' . $sValue;
						}
					}
				}

				if ($bPass === false)
				{
					if (defined('AIN_INSTALLER'))
					{
						$sPath = (defined('AIN_INSTALLER') ? AIN_Installer::getHostPath() : AIN::getParam('core.path_file')) . 'theme' . '/' . $this->_sThemeLayout . '/' . 'default' . '/' . 'style' . '/' . 'default' . '/' . $sType . '/' . $sValue;
					}
					else
					{
						if (file_exists(AIN_DIR . 'theme' . '/' . $this->_sThemeLayout . '/' . 'default' . '/' . 'style' . '/' . 'default' . '/' . $sType . '/' . $sValue))
						{
							$sPath = AIN::getParam('core.path_file') . 'theme' . '/' . $this->_sThemeLayout . '/' . 'default' . '/' . 'style' . '/' . 'default' . '/' . $sType . '/' . $sValue;
						}
						else
						{
							if (file_exists(AIN_DIR . 'theme' . '/frontend/' . $this->_sThemeFolder . '/' . 'style' . '/' . $this->_sStyleFolder . '/' . $sType . '/' . $sValue))
							{
								$sPath = AIN::getParam('core.path_file') . 'theme' . '/frontend/' . $this->_sThemeFolder . '/' . 'style' . '/' . $this->_sStyleFolder . '/' . $sType . '/' . $sValue;
							}
							else
							{
								$sPath = AIN::getParam('core.path_file') . 'theme' . '/frontend/' . 'default' . '/' . 'style' . '/' . 'default' . '/' . $sType . '/' . $sValue;
							}
						}
					}
				}
			}
		}

		return $sPath;
	}



	/**
	 * Get the full path to the modular template file we are loading.
	 *
	 * @param string $sTemplate Name of the file.
	 * @param bool $bCheckDb TRUE to check the database if the file exists there.
	 * @return string Full path to the file we are loading.
	 */
	public function getTemplateFile($sTemplate)
	{
		$aParts = explode('.', $sTemplate);

		$sModule = $aParts[0];

		unset($aParts[0]);

		$sName = implode('.', $aParts);

		if( $this->_bIsAdminCp )
		$sName = str_replace('admincp.', '', $sName);

		$sName = str_replace('.', AIN_DS, $sName);

		if (file_exists(AIN_DIR_THEME . $this->_sThemeLayout . AIN_DS . $this->_sThemeFolder . AIN_DS . 'module' . AIN_DS . $sModule . AIN_DS . 'template' .  AIN_DS . $sName . AIN_TPL_SUFFIX))
		{
			$sFile = AIN_DIR_THEME . $this->_sThemeLayout . AIN_DS . $this->_sThemeFolder . AIN_DS . 'module' . AIN_DS . $sModule . AIN_DS . 'template' .  AIN_DS . $sName . AIN_TPL_SUFFIX;
		}

		if (!isset($sFile))
		{
			$sFile = AIN_DIR_THEME . $this->_sThemeLayout . AIN_DS . 'default' . AIN_DS . 'module' . AIN_DS . $sModule . AIN_DS . 'template' .  AIN_DS . $sName . AIN_TPL_SUFFIX;
		}
		if (!file_exists($sFile))
		{
			AIN_Error::trigger("$this->_sThemeFolder template içərisində $sModule modulu üçün $sName fayılı tapılmadı", E_USER_ERROR);
		}

		return $sFile;
	}
	/**
	 * Get the current template data.
	 *
	 * @param string $sTemplate Template name.
	 * @param bool $bReturn TRUE to return its content or FALSE to just echo it.
	 * @return mixed STRING content only if the 2nd argument is TRUE.
	 */
	public function getTemplate($sTemplate, $bReturn = false)
	{
		if( $this->_bIsAdminCp ) $sTemplate = str_replace('admincp/','', $sTemplate);

		$sFile = $this->getTemplateFile($sTemplate);

		$this->_getFromCache($sFile, $sTemplate);

		if ($bReturn)
		{
			$sOriginalContent = ob_get_contents();

			ob_clean();
		}
		if ($bReturn)
		{
			$sReturn = $this->_returnLayout();
			
			echo isset($sOriginalContent) ? $sOriginalContent : '';
			
			return $sReturn;
		}
        return null;
	}
	/**
	 * @return AIN_Template
	 */
	public static function instance()
	{
		return AIN::getLib('template');
	}
	/**
	 * Get the template header file if it exists.
	 *
	 * @return mixed File path if it exists, otherwise FALSE.
	 */
	public function getHeaderFile()
	{
		$sFile = $this->getStyle('php', 'header.php');

		if (file_exists($sFile))
		{
			return $sFile;
		}

		return false;
	}
	public function setTemplate($sLayout)
	{
		$this->sDisplayLayout = $sLayout;

		return $this;
	}






	/**
	 * Get a variable we assigned with the method assign().
	 *
	 * @see self::assign()
	 * @param string $sName Variable name.
	 * @return string Variable value.
	 */
	public function getVar($sName = null)
	{
		if ($sName === null) {
			return $this->_aVars;
		}

		if (isset($this->_aVars[$sName]) && is_object($this->_aVars[$sName])) {
			$this->_aVars[$sName] = (array) $this->_aVars[$sName];
		}

		return (isset($this->_aVars[$sName]) ? $this->_aVars[$sName] : '');
	}

	/**
	 * Clean all or a specific variable from memory.
	 *
	 * @param mixed $mName Variable name to destroy, or leave blank to destory all variables or pass an ARRAY of variables to destroy.
	 */
	public function clean($mName = '')
	{
		if ($mName)
		{
			if (!is_array($mName))
			{
				$mName = array($mName);
			}

			foreach ($mName as $sName)
			{
				unset($this->_aVars[$sName]);
			}

			return;
		}

		unset($this->_aVars);
	}
	
	
	public function setPhrase( $data = array() )
	{
		foreach( $data as $value ) $this->oTranslations[] = $value;
	}
	
	
	
	
    private function _register($sType, $sFunction, $sImplementation)
	{
		$this->_aPlugins[$sType][$sFunction] = $sImplementation;
	}



    public function addScript($key, $value, $bReturnString = false)
    {	
	
		echo $key;
	
		switch ($value) 
		{
            case 'style_script':
                if ($bReturnString) 
				{
                    //return '<script src="' . $this->getStyle('jscript', $key) . '"></script>';
                }
                $this->_sAddScripts .= '<script src="' . $this->getStyle('jscript', $key) . '"></script>';
                break;
		
		}		
	}
	
	
	
	public function getBuiltSectionFile($sectionName)
	{
		$sCacheName = $this->_sThemeFolder.'_section_' . AIN_Module::instance()->getFullControllerName() . '_' . $sectionName[1];
		
		$oTplCache = AIN::getLib('template.cache');
		
		$oTplCache->compile($this->_getCachedName($sCacheName), trim($sectionName[2]), true);
		
		return;
	}	
	private function _yield( $sectionName )
	{
	    if (is_file($this->_getCachedName($this->_sThemeFolder.'_section_' . AIN_Module::instance()->getFullControllerName() . '_' . $sectionName)))
		    require($this->_getCachedName($this->_sThemeFolder.'_section_' . AIN_Module::instance()->getFullControllerName() . '_' . $sectionName));
	}	
	
	
}
?>