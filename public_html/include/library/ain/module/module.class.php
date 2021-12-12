<?php

defined('AIN') or exit('NO DICE!');

class AIN_Module
{
	public $_aModules = array();
	
	private $_sController = 'index';
	
	private $_sModule = AIN_MODULE_CORE;

	private $_aServices = array();

	private $_aFrames = array(
	//	'attachment-frame',
	//	'photo-frame'
	);

	private $_bNoTemplate = false;	
	
	
	public function getService($sClass, $aParams = array())
	{
		(($sPlugin = AIN_Plugin::get('get_service_1')) ? eval($sPlugin) : false);
		
		if (isset($this->_aServices[$sClass]))
		{
			return $this->_aServices[$sClass];	
		}		
	
		if (preg_match('/\./', $sClass) && ($aParts = explode('.', $sClass)) && isset($aParts[1]))
		{
			$sModule = $aParts[0];
			$sService = $aParts[1];			
		}
		else 
		{
			$sModule = $sClass;
			$sService = $sClass;
		}
		
		$sFile = AIN_DIR_MODULE . $sModule . AIN_DS . AIN_DIR_MODULE_SERVICE . AIN_DS . $sService . '.class.php';
		
		if (!file_exists($sFile))
		{			
			if (isset($aParts[2]))
			{
				$sFile = AIN_DIR_MODULE . $sModule . AIN_DS . AIN_DIR_MODULE_SERVICE . AIN_DS . $sService . AIN_DS . $aParts[2] . '.class.php';
				
				if (!file_exists($sFile))
				{
					if (isset($aParts[3]) && file_exists(AIN_DIR_MODULE . $sModule . AIN_DS . AIN_DIR_MODULE_SERVICE . AIN_DS . $sService . AIN_DS . $aParts[2] . AIN_DS . $aParts[3] . '.class.php'))
					{
						$sFile = AIN_DIR_MODULE . $sModule . AIN_DS . AIN_DIR_MODULE_SERVICE . AIN_DS . $sService . AIN_DS . $aParts[2] . AIN_DS . $aParts[3] . '.class.php';				
						$sService .= '_' . $aParts[2] . '_' . $aParts[3];
					}
					else 
					{					
						$sFile = AIN_DIR_MODULE . $sModule . AIN_DS . AIN_DIR_MODULE_SERVICE . AIN_DS . $sService . AIN_DS . $aParts[2] . AIN_DS . $aParts[2] . '.class.php';				
						$sService .= '_' . $aParts[2] . '_' . $aParts[2];
					}
				}
				else 
				{
					$sService .= '_' . $aParts[2];
				}
			}
			else 
			{
				$sFile = AIN_DIR_MODULE . $sModule . AIN_DS . AIN_DIR_MODULE_SERVICE . AIN_DS . $sService . AIN_DS . $sService . '.class.php';	
				$sService .= '_' . $sService;
			}
		}			
		if (!file_exists($sFile))
		{            
			AIN_Error::trigger('Unable to load service class: ' . $sFile, E_USER_ERROR);
		}

		require_once($sFile);
		
		$this->_aServices[$sClass] = AIN::getObject($sModule . '_service_' . $sService);		
	
		return $this->_aServices[$sClass];
	}
	
	public function setController($sController = '')
	{
		if ($sController)
		{
			$aParts = explode('.', $sController);			
			$this->_sModule = $aParts[0];
			$this->_sController = substr_replace($sController, '', 0, strlen($this->_sModule . '_'));			
			$this->getController();			
			
			return null;
		}		
		
		$oReq = AIN::getLib('request');	
		
		$this->_sModule = (($sReq1 = $oReq->get('req1')) ? strtolower($sReq1) : AIN::getParam('core.module_core'));				
		
		$sDir = AIN_DIR_MODULE . $this->_sModule . AIN_DS;

		if (AIN::getParam('core.module_core') == AIN::getParam('admincp.admin_cp'))
		{
			$this->_sModule = strtolower(AIN::getParam('core.module_core'));			
			
			if ($oReq->get('req1') && file_exists(AIN_DIR_MODULE . $this->_sModule . AIN_DS . AIN_DIR_MODULE_COMPONENT . AIN_DS . 'controller' . AIN_DS . strtolower($oReq->get('req1')) . '.class.php'))
			{
				$this->_sController = strtolower($oReq->get('req1'));
			}
			else
			{
				$this->_sController = 'index';
			}			
		}		
		elseif (AIN::getParam('core.module_core') == AIN_MODULE_CORE )
		{
			$this->_sModule = strtolower(AIN::getParam('core.module_core'));			
			
			if ($oReq->get('req1') && file_exists(AIN_DIR_MODULE . $this->_sModule . AIN_DS . AIN_DIR_MODULE_COMPONENT . AIN_DS . 'controller' . AIN_DS . strtolower($oReq->get('req1')) . '.class.php'))
			{
				$this->_sController = strtolower($oReq->get('req1'));
			}
			else
			{
				$this->_sController = 'index';
			}			
		}
		elseif ( $oReq->get('req3') && file_exists($sDir . AIN_DIR_MODULE_COMPONENT . AIN_DS . 'controller' . AIN_DS . strtolower($oReq->get('req2')) . AIN_DS . strtolower($oReq->get('req3')) . '.class.php'))
		{
			$this->_sController = strtolower($oReq->get('req2') . '.' . $oReq->get('req3'));			
		}
		elseif ($oReq->get('req2') && file_exists($sDir . AIN_DIR_MODULE_COMPONENT . AIN_DS . 'controller' . AIN_DS . strtolower($oReq->get('req2')) . '.class.php'))
		{
			$this->_sController = strtolower($oReq->get('req2'));
		}
		elseif ( $oReq->get('req2') && file_exists($sDir . AIN_DIR_MODULE_COMPONENT . AIN_DS . 'controller' . AIN_DS . strtolower($oReq->get('req2')) . AIN_DS . 'index.class.php'))
		{			
			$this->_sController = strtolower($oReq->get('req2')) . '.index';			
		}	
		elseif ($oReq->get('req3') && file_exists(AIN_DIR_MODULE . AIN::getParam('core.module_core') . AIN_DS . AIN_DIR_MODULE_COMPONENT . AIN_DS . 'controller' . AIN_DS . strtolower($oReq->get('req1')) . AIN_DS. strtolower($oReq->get('req2')) . AIN_DS . strtolower($oReq->get('req3')) . '.class.php'))
		{
			$this->_sModule = strtolower(AIN::getParam('core.module_core'));
			$this->_sController = strtolower($oReq->get('req1') . '.' . $oReq->get('req2') . '.' . $oReq->get('req3') );
		}
		elseif ($oReq->get('req2') && file_exists(AIN_DIR_MODULE . AIN::getParam('core.module_core') . AIN_DS . AIN_DIR_MODULE_COMPONENT . AIN_DS . 'controller' . AIN_DS . strtolower($oReq->get('req1')) . AIN_DS. strtolower($oReq->get('req2')). '.class.php'))
		{
			$this->_sModule = strtolower(AIN::getParam('core.module_core'));
			$this->_sController = strtolower($oReq->get('req1') . '.' . $oReq->get('req2'));			
		}
		elseif ($oReq->get('req1') && file_exists(AIN_DIR_MODULE . AIN::getParam('core.module_core') . AIN_DS . AIN_DIR_MODULE_COMPONENT . AIN_DS . 'controller' . AIN_DS . strtolower($oReq->get('req1')) . '.class.php'))
		{
			$this->_sModule = strtolower(AIN::getParam('core.module_core'));
			$this->_sController = strtolower($oReq->get('req1'));
		}
		else 
		{		
			$this->_sModule = strtolower(AIN::getParam('core.module_core'));		
		}		
	}
	public function getController()
	{		
		// Get the component
		$this->_oController = $this->getComponent($this->_sModule . '.' . $this->_sController, array('bNoTemplate' => true), 'controller');
	}
	public function getComponent($sClass, $aParams = array(), $sType = 'block', $bTemplateParams = false)
	{
        if ($sType == 'ajax' && strpos($sClass, '.') === false) {
            $sClass = $sClass . '.ajax';
        }
		
		$aParts = explode('.', $sClass);
		$sModule = $aParts[0];		
		$sComponent = $sType . AIN_DS . substr_replace(str_replace('.', AIN_DS, $sClass), '', 0, strlen($sModule . AIN_DS));		
		
		if ($sType == 'controller')
		{
			$this->_sModule = $sModule;
			$this->_sController = substr_replace(str_replace('.', AIN_DS, $sClass), '', 0, strlen($sModule . AIN_DS));
		}
		
		$sMethod = $sModule . '_component_' . str_replace(AIN_DS, '_', $sComponent) . '_process';			
		
		$sHash = md5($sClass . $sType);			

		if (isset($this->_aComponent[$sHash]))
		{	
			$this->_aComponent[$sHash]->__construct(array('sModule' => $sModule, 'sComponent' => $sComponent, 'aParams' => $aParams));
		}
		else 
		{
			$sClassFile = AIN_DIR_MODULE . $sModule . AIN_DIR_MODULE_COMPONENT . AIN_DS . $sComponent . '.class.php';	
			
			if (!file_exists($sClassFile) && isset($aParts[1]))
			{
				$sClassFile = AIN_DIR_MODULE . $sModule . AIN_DIR_MODULE_COMPONENT . AIN_DS . $sComponent . AIN_DS . $aParts[1] . '.class.php';				
			}	
			
			if (!file_exists($sClassFile))
			{
				AIN_Error::trigger('Failed to load component: ' . $sClassFile, E_USER_ERROR);
			}
			// Require the component
			require($sClassFile);					

			// Get the object			
			$this->_aComponent[$sHash] = AIN::getObject($sModule . '_component_' . str_replace(AIN_DS, '_', $sComponent), array('sModule' => $sModule, 'sComponent' => $sComponent, 'aParams' => $aParams));
		}
		
		$mReturn = 'blank';
		
		if ($sType != 'ajax')
		{	
			$mReturn = $this->_aComponent[$sHash]->process();
		}
		
		$this->_aReturn[$sClass] = $mReturn;
		
		// If we return the component as 'false' then there is no need to display it.
		if ((is_bool($mReturn) && !$mReturn) || $this->_bNoTemplate)
		{
			if ($this->_bNoTemplate)
			{
				$this->_bNoTemplate = false;
			}

			return $this->_aComponent[$sHash];
		}	

		/* Should we pass the params to the template? */
		if ($bTemplateParams)
		{
			AIN_Template::instance()->assign($aParams);
		}			
		// Check if we don't want to display a template
		if (!isset($aParams['bNoTemplate']) && $mReturn != 'blank')
		{
			if (!is_array($mReturn))
			{
				$sComponentTemplate = $sModule . '.' . str_replace(AIN_DS, '.', $sComponent);

				AIN::getLib('template')->getTemplate($sComponentTemplate);
			}				
			// Check if the component we have loaded has the clean() method
			if (is_object($this->_aComponent[$sHash]) && method_exists($this->_aComponent[$sHash], 'clean'))
			{
				// This method is used to clean out any garbage we don't need later on in the script. In most cases Template assigns.
				$this->_aComponent[$sHash]->clean();
			}
		}			
		return $this->_aComponent[$sHash];
	}	
	/**
	 * Gets the controllers template. We do this automatically since each controller has a specific template that it loads to
	 * output data to the site.
	 *
	 * @return mixed NULL if we were able to load a template and FALSE if such a template does not exist.
	 */
	public function getControllerTemplate()
	{
		$sClass = $this->_sModule . '.controller.' . $this->_sController;
		
		if (isset($this->_aReturn[$sClass]) && $this->_aReturn[$sClass] === false)
		{
			return false;
		}		

		// Get the template and display its content for the specific controller component
		AIN_Template::instance()->getTemplate($sClass);
		
		// Check if the component we have loaded has the clean() method
		if (is_object($this->_oController) && method_exists($this->_oController, 'clean'))
		{
			// This method is used to clean out any garbage we don't need later on in the script. In most cases Template assigns.
			$this->_oController->clean();
		}
	}	

	
	
	/**
	 * Gets the full name of the controller we are using including the module prefix.
	 *
	 * @return string
	 */
	public function getFullControllerName()
	{
		return $this->_sModule . '.' . str_replace('\\', '/', $this->_sController);
	}
	/**
	 * @return $this
	 */
	public static function instance() {
		return AIN::getLib('module');
	}
	
	
	
	
	
	
	
	
	
	
	

	public function getModules()
	{
		if ( empty($this->_aModules) && file_exists(AIN_DIR_FILE . 'log' . AIN_DS . 'installer_modules.php'))
		{
			require(AIN_DIR_FILE . 'log' . AIN_DS . 'installer_modules.php');
			if (isset($aModules)) {
				$this->_aModules = $aModules;
			}
		}	
		return $this->_aModules;
	}
	public function massCallback($sMethod, $aParams = array())
	{
		$aReturn = array();
		$aModules = array();
		$oCache = AIN::getLib('cache');

		$sCacheId = $oCache->set('module_masscall_' . $sMethod);
		if (!($aModules = $oCache->get($sCacheId)))
		{
			foreach (AIN_Module::instance()->getModules() as $sModule)
			{
				$sCallBack = AIN_DIR_MODULE . $sModule . AIN_DS . AIN_DIR_MODULE_SERVICE . AIN_DS . 'callback.class.php';
				if (file_exists($sCallBack))
				{
					$oService = $this->getService($sModule . '.callback');
					if (is_object($oService) && method_exists($oService, $sMethod))
					{
						$aModules[] = $sModule;
					}
				}				
			}
			$oCache->save($sCacheId, $aModules);
		}
		
		if (!is_array($aModules))
		{
			return array();
		}
		foreach ($aModules as $sModule)
		{
			$oService = $this->getService($sModule . '.callback');
			// Do we have any args. to pass?
			if (count($aParams) && isset($aParams[1]))
			{
				// Prepare the args.
				$sEval = '$aReturn[$sModule] = $oService->$sMethod(';
				for ($i = 1; $i < count($aParams); $i++)
				{
					$sEval .= var_export($aParams[$i], true) . ',';
				}
				$sEval = rtrim($sEval, ',') . ');';

				eval($sEval);
			}
			else
			{
				eval('$aReturn[$sModule] = $oService->$sMethod();');
			}
		}		
		return $aReturn;
	}	
}
?>