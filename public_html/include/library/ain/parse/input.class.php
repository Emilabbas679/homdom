<?php

defined('AIN') or exit('NO DICE!');

class AIN_Parse_Input
{
	
	/**
	 * Parse and clean a title of an item and convert it into a URL title string.
	 * Example if you had:
	 * <code>
	 *  this is a TEST string!!!
	 * </code>
	 * It would convert it to:
	 * <code>
	 * this-is-a-test-string
	 * </code>
	 * Which, we would then use in a URL:
	 * <code>
	 * http://www.yoursite.com/this-is-a-test-string/
	 * </code>
	 *
	 * @param string $sUrls String to convert into a URL.
	 * @return string Converted URL.
	 */
	public function cleanTitle($sUrls)
	{
		$sUrls = trim(strip_tags($sUrls));
		$sUrls = $this->_utf8ToUnicode($sUrls, true);		
		$sUrls = preg_replace("/ +/", "-", $sUrls);		
		$sUrls = rawurlencode($sUrls);		
		$sUrls = str_replace(array('"', "'"), '', $sUrls);
		$sUrls = str_replace(' ', '-', $sUrls);
		$sUrls = str_replace(array('-----', '----', '---', '--'), '-', $sUrls);
		$sUrls = rtrim($sUrls, '-');
		$sUrls = ltrim($sUrls, '-');
		
		if (empty($sUrls))
		{
			$sUrls = AIN_TIME;
		}
		
		$sUrls = strtolower($sUrls);

		return $sUrls;
	}

    /**
     * Converts a string with non-latin characters into UNICODE. We convert all strings
     * before we enter them into the database so clients do not have to worry about database
     * collations and website encoding as all common browsers have no problems displaying UNICODE.
     *
     * @see self::_unicodeToEntitiesPreservingAscii()
     * @param string $str String we need to parse.
     * @param bool $bForUrl TRUE for URL strings, FALSE for general usage.
     * @return string Returns string that has been converted.
     */
    private function _utf8ToUnicode($str, $bForUrl = false)
    {
        $unicode = array();
        $values = array();
        $lookingFor = 1;
        
        if(defined('AIN_UNICODE_JSON') && AIN_UNICODE_JSON === true)
        {
            $aUnicodes = preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
            foreach($aUnicodes as $char)
            {
                $thisValue = ord($char);
                if ($thisValue < 128)
                {
                    $unicode[] = $thisValue;
                }
                else
                {
                    $unicode[] = hexdec(trim(trim(json_encode($char), '"'), '\u'));
                }
            }
        }
        else
        {
            for ($i = 0; $i < strlen( $str ); $i++ )
            {
                $thisValue = ord( $str[ $i ] );

                if ( $thisValue < 128 )
                {
                    $unicode[] = $thisValue;
                }
                else
                {
                    if ( count( $values ) == 0 ) $lookingFor = ( $thisValue < 224 ) ? 2 : 3;

                    $values[] = $thisValue;

                    if ( count( $values ) == $lookingFor ) 
                    {
                        $number = ( $lookingFor == 3 ) ?
                            ( ( $values[0] % 16 ) * 4096 ) + ( ( $values[1] % 64 ) * 64 ) + ( $values[2] % 64 ):
                            ( ( $values[0] % 32 ) * 64 ) + ( $values[1] % 64 );

                        $unicode[] = $number;
                        $values = array();
                        $lookingFor = 1;
                    }
                }
            }
        }

        return $this->_unicodeToEntitiesPreservingAscii($unicode, $bForUrl);
    }

    /**
     * Converts a string with non-latin characters into UNICODE. This method is used with the method _utf8ToUnicode().
     *
     * @see self::_utf8ToUnicode()
     * @param array $unicode ARRAY of unicode values.
     * @param bool $bForUrl TRUE for URL strings, FALSE for general usage.
     * @return string Returns string that has been converted.
     */
    private function _unicodeToEntitiesPreservingAscii($unicode, $bForUrl = false)
    {
        $entities = '';
        foreach( $unicode as $value )
        {
        	if ($bForUrl === true)
        	{
        		if ($value == 42 || $value > 127)
        		{
        			$sCacheValue = '&#' . $value . ';';
        		
        			$entities .= (preg_match('/[^a-zA-Z]+/', $sCacheValue) ? '-' . $value : $sCacheValue);   			
        		}
        		else 
        		{
        			$entities .= (preg_match('/[^0-9a-zA-Z]+/', chr($value)) ? ' ' : chr($value));
        		}        		
        	}
        	else 
        	{
        		$entities .= ($value == 42 ? '&#' . $value . ';' : ( $value > 127 ) ? '&#' . $value . ';' : chr($value));
        	}
        }
		$entities = str_replace("'", '&#039;', $entities);
        return $entities;
    }
	public function clean($sTxt, $iShorten = null)
	{
		if (!defined('AIN_INSTALLER') && AIN::getParam('language.no_string_restriction'))
		{
			$iShorten = null;
		}

		$sTxt = AIN::getLib('parse.output')->htmlspecialchars($sTxt);

		if ($iShorten !== null)
		{			
			$sTxt = $this->_shorten($sTxt, $iShorten);
		}	
		
		return $sTxt;
	}
	/**
	 * Prepare text strings. Used to prepare all data that can contain HTML. Not only does
	 * it protect against harmful HTML and CSS, it also has support for BBCode conversion.
	 *
	 * @param string $sTxt Text to parse.
	 * @return string Parsed string.
	 */
	public function prepare($sTxt, $bNoClean = true, $extra = [])
	{
		(($sPlugin = AIN_Plugin::get('parse_input_prepare')) ? eval($sPlugin) : null);

		if (isset($override) && is_callable($override)) {
			return call_user_func($override, $sTxt);
		}

		if ($bNoClean) return $sTxt;
		return AIN_Parse_Output::instance()->htmlspecialchars($sTxt);
	}
	
	
	
	public function convert($sTxt)
	{
		return $sTxt;
		return $this->_utf8ToUnicode($sTxt);
	}
	
	
	
}
?>