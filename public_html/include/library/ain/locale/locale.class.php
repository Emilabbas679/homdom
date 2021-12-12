<?php

defined('AIN') or exit('NO DICE!');

class AIN_Locale
{
	private $_aPhrases = array();
	private $_aLanguage = array();
	private $_aLanguages = array();
	private $_sOverride = '';
	
	public function __construct()
	{
		$oCache = AIN::getLib('cache');
    
		$sLangAllId = $oCache->set(array('locale', 'language'));
		
		if (!($this->_aLanguages = $oCache->get($sLangAllId)))
		{
			$aRows = AIN::sendApi('get_langauage', [])['data'];			
			foreach ($aRows as $aRow)
			{
				$this->_aLanguages[$aRow['language_id']] = true;
			}
			
			$oCache->save($sLangAllId, $this->_aLanguages);
		}		
		$sLangId = $oCache->set(array('locale', 'language_' . $this->getLangId()));		
		if (!($this->_aLanguage = $oCache->get($sLangId)))
		{			
			$this->_aLanguage = AIN::sendApi('get_langauage', ['language_id' => $this->getLangId() ])['data'];			
			$oCache->save($sLangId, $this->_aLanguage);			
		}		
		$oCache->close($sLangId);			
		
		define('AIN_LOCALE_LOADED', true);    
    }

	public static function instance()
	{
		return AIN::getLib('locale');
	}
	public function getLang()
	{		
		return $this->_aLanguage;
	}
	public function getLangBy($sVar)
	{
		return (isset($this->_aLanguage[$sVar]) ? $this->_aLanguage[$sVar] : '');
	}
	/**
	 * Checks if a phrase exists in the language package or not
	 *
	 * @param string $sParam Phrase to check if it exists
	 * @return bool TRUE if it exists, FALSE if it does not
	 */
	public function isPhrase($sParam)
	{
		if (strpos($sParam, '.') === false)
		{
			return '';
		}		
		if (strpos($sParam, ' '))
		{
			return false;
		}
		list($sModule, $sVar) = explode('.', $sParam);		
		
		if (!isset($this->_aPhrases[$sModule]))
		{
			$this->_getModuleLanguage($sModule);
		}		
		
		return (isset($this->_aPhrases[$sModule][$sVar]) ? true : false);
	}
	private function _getModuleLanguage($sModule, $bForce = false)
	{
		if (!$bForce && isset($this->_aPhrases[$sModule]))
		{			
			return $this->_aPhrases[$sModule];
		}
		
		
		$oCache = AIN::getLib('cache');
		$sId = $oCache->set(array('locale', 'language_' . $this->getLangId() . '_phrase_' . $sModule));
		
		if (!is_array($this->_aPhrases))
		{
			$this->_aPhrases = array();
		} 
		if (!$bForce && ($this->_aPhrases[$sModule] = $oCache->get($sId)))
		{

		}
		else
		{
			if (!($this->_aPhrases[$sModule] = $oCache->get($sId)))
			{
				$aRows = AIN::sendApi('get_langauage_phrase', ['language_id' => $this->getLangId(), 'module_id' => $sModule, 'size' => 10000 ])['data']['rows'];			
								
				foreach ($aRows as $aRow)
				{
					$this->_aPhrases[$sModule][$aRow['var_name']] = $aRow['text'];	
				}

				$oCache->save($sId, $this->_aPhrases[$sModule]);
			}			
		}
	}

	
	
	public function getPhrase($sParam, $aParams = array())
	{
		if( isset($this->_aCache[$sParam]) ) return $this->_aCache[$sParam];
		
		if (strpos($sParam, '.') === false)
		{
			return '';
		}
		
		list($sModule, $sVar) = explode('.', $sParam);	
					
		if (!isset($this->_aPhrases[$sModule]))
		{
			$this->_getModuleLanguage($sModule);			
		}
		
		$sPhrase = isset($this->_aPhrases[$sModule][$sVar]) ? $this->_aPhrases[$sModule][$sVar] : 'phrase_var_'.$sModule.'.'.$sVar ;	

		if ($aParams)
		{
			$aFind = array();
			$aReplace = array();
			foreach ($aParams as $sKey => $sValue)
			{
				if (is_array($sValue))
				{
					continue;
				}
				$aFind[] = '{' . $sKey . '}';				
				$aReplace[] = '' . $sValue . '';		
			}		
			
			$sPhrase = str_replace($aFind, $aReplace, $sPhrase);
		}	
		
		if (isset($aParams['ain_squote']))
		{
			$sPhrase = str_replace("'", "\\'", $sPhrase);
		}
				
		//$sPhrase .= '<a href=""> Edit </a>';		
		$this->_aCache[$sParam] = $sPhrase;		
		
		return $this->_aCache[$sParam];
	}
	

	public function getLangId()
	{
		$sLanguageId = AIN_GET_LANGUAGE_VALUE;
		
		if ($this->_sOverride != '')
		{
			return $this->_sOverride;
		} 	
		
 		if ( $sLanguageId = AIN::getLib('request')->get(AIN_GET_LANGUAGE) )
		{
		
		}  		
        if (!isset($this->_aLanguages[$sLanguageId])) 
		{
            $sLanguageId = AIN_GET_LANGUAGE_VALUE;
        }
		
		return $sLanguageId;
	}
	
	
   	/**
	 * Parses a phrase to convert ASCII rules.
	 *
	 * @see self::_parse()
	 * @param string $sTxt Phrase to parse.
	 * @return string Returns the newly parsed string.
	 */
	public function parse($sTxt)
	{		
		return $sTxt;
	}
	public function convert($sPhrase)
	{
		if (preg_match('/\{_p var=(.*)\}/i', $sPhrase, $aMatches))
		{
			$sPhrase = ' ' . $sPhrase . ' ';
			$sPhrase = preg_replace_callback('/ {_p var=(.*?)} /is', array($this, '_convert'), $sPhrase);
			return trim($sPhrase);
        }
        //Support legacy data from old version
        if (preg_match('/\{phrase var=(.*)\}/i', $sPhrase, $aMatches)) {
            $sPhrase = ' ' . $sPhrase . ' ';
            $sPhrase = preg_replace_callback('/ {phrase var=(.*?)} /is', [$this, '_convert'], $sPhrase);
            return trim($sPhrase);
        }
        
        return $sPhrase;
	}	
    public function totranslit($var, $lower = true, $punkt = true)
	{
        	
        	if ( is_array($var) ) return "";        
             
        		$langtranslit = array(
        		'c' => 'c', 'g' => 'g', 'i' => 'i',
        		'o' => 'o', 'ş' => 's', 'u' => 'u',
                'ə' => 'e', 'ü' => 'u', 'ç' => 'c',
				'ı' => 'i',
				 'а' => 'a', 'б' => 'b', 'в' => 'v',
				'г' => 'g', 'д' => 'd', 'е' => 'e',
				'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
				'и' => 'i', 'й' => 'y', 'к' => 'k',
				'л' => 'l', 'м' => 'm', 'н' => 'n',
				'о' => 'o', 'п' => 'p', 'р' => 'r',
				'с' => 's', 'т' => 't', 'у' => 'u',
				'ф' => 'f', 'х' => 'h', 'ц' => 'c',
				'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
				'ь' => '', 'ы' => 'y', 'ъ' => '',
				'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
				"ї" => "yi", "є" => "ye",

       		
        		'C' => 'C', 'G' => 'G', 'I' => 'I',
        		'O' => 'O', 'Ş' => 'S', 'U' => 'U',
                'Ə' => 'E', 'İ' => 'I', 
				'А' => 'A', 'Б' => 'B', 'В' => 'V',
				'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
				'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
				'И' => 'I', 'Й' => 'Y', 'К' => 'K',
				'Л' => 'L', 'М' => 'M', 'Н' => 'N',
				'О' => 'O', 'П' => 'P', 'Р' => 'R',
				'С' => 'S', 'Т' => 'T', 'У' => 'U',
				'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
				'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
				'Ь' => '', 'Ы' => 'Y', 'Ъ' => '',
				'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
				"Ї" => "yi", "Є" => "ye",				
        		);
              
        	
        	$var = trim( strip_tags( $var ) );
        	$var = preg_replace( "/\s+/ms", "-", $var );
        	$var = str_replace( "/", "-", $var );
        
        	$var = strtr($var, $langtranslit);
        	
        	if ( $punkt ) $var = preg_replace( "/[^a-z0-9\_\-.]+/mi", "", $var );
        	else $var = preg_replace( "/[^a-z0-9\_\-]+/mi", "", $var );
        
        	$var = preg_replace( '#[\-]+#i', '-', $var );
        
        	if ( $lower ) $var = strtolower( $var );
        
        	$var = str_ireplace( ".php", "", $var );
        	$var = str_ireplace( ".php", ".ppp", $var );
        	
        	if( strlen( $var ) > 200 ) {
        		
        		$var = substr( $var, 0, 200 );
        		
        		if( ($temp_max = strrpos( $var, '-' )) ) $var = substr( $var, 0, $temp_max );
        	
        	}        	
        	return $var;
    } 
	
}
?>