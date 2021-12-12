<?php

defined('AIN') or exit('NO DICE!');

class AIN_Error
{

	static private $aErrors = array();

	static private $_bDisplay = true;

	static private $_bSkipError = false;

	public static function display($sMsg, $iErrCode = null)
	{
		if (AIN_IS_AJAX)
		{
			echo $sMsg;
		}
		else
		{
			AIN::getLib('module')->setController('core.error-display');

			AIN::getLib('template')->assign(array(
					'sErrorMessage' => $sMsg
				)
			);
		}
		if ($iErrCode !== null)
		{
			$oUrl = AIN::getLib('url');
			header($oUrl->getHeaderCode($iErrCode));
		}
		return false;
	}
	public static function trigger($sMsg, $sErrorCode = E_USER_WARNING)
	{
		trigger_error(strip_tags($sMsg), $sErrorCode);

		if ($sErrorCode == E_USER_ERROR)
		{
			exit;
		}

		return false;
	}
	public static function set($sMsg)
	{
		self::$aErrors[] = $sMsg;

		return false;
	}
	public static function get()
	{
		return self::$aErrors;
	}
	public static function setDisplay($bDisplay)
	{
		self::$_bDisplay = $bDisplay;
	}
	public static function getDisplay()
	{
		return self::$_bDisplay;
	}
	public static function isPassed()
	{
		return (!count(self::$aErrors) ? true : false);
	}
	public static function reset()
	{
		self::$aErrors = array();
	}
	public static function skip($bSkipError)
	{
		if ($bSkipError === true)
		{
			error_reporting(0);
		}
		else
		{
			error_reporting((AIN_DEBUG ? E_ALL | E_STRICT : 0));
		}
		self::$_bSkipError = $bSkipError;
	}
	public static function errorHandler($nErrNo, $sErrMsg, $sFileName, $nLinenum, $aVars = array())
	{
		/* @Todo Purefan fix all 65 preg_replace calls that use /e */
		if (strpos($sErrMsg, '/e modifier is deprecated') !== false)
		{
			return;
		}
		if (defined('AIN_IS_API'))
		{
			echo serialize(array(
					'error' => 'fatal',
					'error_message' => $sErrMsg,
					'return' => false
				)
			);

			exit;
		}

		if (self::$_bSkipError)
		{
			return false;
		}

		if ((defined('AIN_LOG_ERROR') && AIN_LOG_ERROR))
		{
			self::log($sErrMsg, $sFileName, $nLinenum);
		}

		if (!AIN_DEBUG && !error_reporting())
	    {
	    	return false;
	    }

		$aTypes = array(
	        1   =>  "Error",
	        2   =>  "Warning",
	        4   =>  "Parsing Error",
	        8   =>  "Notice",
	        16  =>  "Core Error",
	        32  =>  "Core Warning",
	        64  =>  "Compile Error",
	        128 =>  "Compile Warning",
	        256 =>  "User Error",
	        512 =>  "User Warning",
	        1024=>  "User Notice",
	        2048=>  "PHP 5"
	    );

    	$aColors = array(
    	    1   =>  "#FF9999",
    	    2   =>  "#00FFFF",
    	    4   =>  "#FF9999",
    	    8   =>  "#99FF99",
    	    16  =>  "#FF9999",
    	    32  =>  "#00FFFF",
    	    64  =>  "#FF9999",
    	    128 =>  "#00FFFF",
    	    256 =>  "#FF9999",
    	    512 =>  "#00FFFF",
    	    1024=>  "#FF9999",
    	    2048=>  "#FF9999"
    	);

    	if (substr(PHP_VERSION, 0, 1) < 5)
	    {
	        $iStart = 1;
	    }
	    else
	    {
	        $iStart = 0;
	    }

	    $bNoHtml = false;
	    if ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') || (PHP_SAPI == 'cli'))
	    {
	    	$bNoHtml = true;
	    }

    	$sErrMsg = str_replace(AIN_DIR, '', $sErrMsg);
    	if ($bNoHtml)
    	{
    		$sErr = "\n{$aTypes[$nErrNo]}: {$sErrMsg}\n";
    	}
    	else
    	{
			if (!isset($aColors[$nErrNo]) || !isset($aTypes[$nErrNo]))
			{
				$nErrNo = 1;
			}
			$sErr = '<!-- AIN Error Message --><br />
			<table border="0" cellspacing="0" cellpadding="2" style="font-family:Verdana;font-size:12px; border-color: #000000; border: 1px solid black; background:#fff;">
	        <tr>
	        	<td colspan="10" align="left" valig="top" style="background-color: ' . $aColors[$nErrNo] . '"><b>' . $aTypes[$nErrNo] . ':&nbsp;' . $sErrMsg  .  ' </b></td></tr>';
    	}

   		$aFiles = debug_backtrace();

   		if (preg_match('/mysql_connect\(\)/i', $sErrMsg) && !defined('AIN_INSTALLER'))
   		{
			exit($sErrMsg);
			// cant connect to database : too many connections
			// display the no DB error page
			$sFile = file_get_contents(AIN_DIR . 'static' . AIN_DS . 'nodb.html');
			ob_clean();
			die($sFile);

   			$aFiles = array();
   		}

    	for ($i=$iStart, $n=sizeof($aFiles); $i<$n; ++$i)
    	{
        	if (!isset($aFiles[$i]['file']))
        	{
        		continue;
        	}

        	if ($aFiles[$i]['function'] == 'trigger_error' || $aFiles[$i]['function'] == 'trigger')
        	{
        		// continue;
        	}

			if (isset($aFiles[$i]['class']) && $aFiles[$i]['class'] == 'AIN_Error')
			{
				// continue;
			}

			if (in_array(strip_tags(str_replace(AIN_DIR, '', $aFiles[$i]['file'])), array(
						'include/library/ain/error/error.class.php',
						'include/library/ain/database/driver/mysql.class.php',
						'include/library/ain/database/dba.class.php'
					)
				)
			)
			{
				// continue;
			}

    		$sArgs = '';
        	if (isset($aFiles[$i]['args']))
        	{
            	$aArgs = array();
            	$aArgs = array_merge($aFiles[$i]['args'], array());
            	if ($aArgs and is_array($aArgs))
            	{
                	foreach ($aArgs as $k=>$v)
                	{
                    	if (is_numeric($v))
                    	{
                    	    $aArgs[$k] = '<span style="color:#7700AA">'.$v.'</span>';
                    	}
                    	elseif(is_bool($v))
                    	{
                    	    $aArgs[$k] = '<span style="color:#222288;">'.($v ? 'TRUE' : 'FALSE').'</span>';
                    	}
                    	elseif(is_null($v))
                    	{
                    	    $aArgs[$k] = '<span style="color:#222288;">NULL</span>';
                    	}
                    	elseif(is_array($v))
                    	{
                    	    $aArgs[$k] = 'Array('.count($v).')';
                    	}
    	                elseif (is_string($v) && ! (('"' == substr($v,0,1)) && ('"' == substr($v,-1))))
	                    {
	                        $aArgs[$k] = '<span style="color:#0000FF">"'.$v.'"</span>';
	                    }
	                    elseif(is_object($v))
	                    {
	                        unset($aArgs[$k]);
	                        $aArgs[$k] = '{' . ucfirst(get_class($v)) . '}';
	                    }
	                }
	            }
	            $sArgs = implode(', ', $aArgs);
	        }

        	$sFuncName = (isset($aFiles[$i]['class'])?$aFiles[$i]['class']:'').
                     (isset($aFiles[$i]['type'])?$aFiles[$i]['type']:'').
                     $aFiles[$i]['function'].'('.$sArgs.')';
        	if ($iStart == $i)
        	{
        	    $sFuncName = '<b>' . $sFuncName . '</b>';
        	}
        	$sFile = str_replace(AIN_DIR, '', $aFiles[$i]['file']);

        	if ($bNoHtml)
    		{
    			$sErr .= "{$i}\t{$sFile}\t" . (isset($aFiles[$i]['line']) ? $aFiles[$i]['line'] : '') . "\t" . strip_tags(str_replace(AIN_DIR, '', $sFuncName)) . "\n";
    		}
    		else
    		{
        		$sErr .= '<tr><td bgcolor="#DDEEFF" align="right">'.$i.'&nbsp;</td>'.
                 '<td style="border-bottom:1px #000 solid;">' . $sFile . '&nbsp;:&nbsp;<b>'.(isset($aFiles[$i]['line']) ? $aFiles[$i]['line'] : '').'</b>&nbsp;&nbsp; </td>'.
                 '<td style="border-bottom:1px #000 solid; border-left:1px #000 solid;">' . str_replace(AIN_DIR, '', $sFuncName) . '</td></tr>';
    		}
    	}

    	if (!$bNoHtml)
    	{
	    	$sErr .= '</table>';
    	}

	    echo $sErr;

	    if (AIN_DEBUG && defined('AIN_DEBUG_EXIT'))
	    {
	    	exit;
	    }
	}
	public static function log($sMessage, $sFile, $iLine)
	{
		$aCallbacks = debug_backtrace();
		$aBacktrace = array();
		foreach ($aCallbacks as $aCallback)
		{
			if (isset($aCallback['class']) && $aCallback['class'] == 'AIN_Error')
			{
				continue;
			}

			if (!isset($aCallback['file']) || !isset($aCallback['line']))
			{
				continue;
			}

			$aBacktrace[] = array(
				'file' => $aCallback['file'],
				'line' => $aCallback['line']
			);
		}
		$sErrorLog = serialize(array(
				'message' => self::_escapeCdata($sMessage),
				'backtrace' => var_export($aBacktrace, true),
				'request' => var_export($_REQUEST, true),
				'ip' => AIN::getLib('request')->getServer('REMOTE_ADDR') // $_SERVER['REMOTE_ADDR']
			)
		);

		$hFile = fopen(AIN_DIR . 'file' . AIN_DS . 'log' . AIN_DS . 'AIN_error_log_' . date('d_m_y', time()) . '_' . md5(AIN::getVersion()) . '.php', 'a');
    	fwrite($hFile, '<?php defined(\'AIN\') or exit(\'NO DICE!\');  ?>' . "##\n{$sErrorLog}##\n");
    	fclose($hFile);
	}

	private static function _escapeCdata($sXml)
	{
		$sXml = preg_replace('#[\\x00-\\x08\\x0B\\x0C\\x0E-\\x1F]#', '', $sXml);

		return str_replace(array('<![CDATA[', ']]>'), array('�![CDATA[', ']]�'), $sXml);
	}
}

function d($mInfo, $bVarDump = false)
{
	$bCliOrAjax = (PHP_SAPI == 'cli');
	(!$bCliOrAjax ? print '<pre style="text-align:left; padding-left:15px;">' : false);
	($bVarDump ? var_dump($mInfo) : print_r($mInfo));
	(!$bCliOrAjax ? print '</pre>' : false);
}

function p()
{
	$aArgs = func_get_args();
	$bCliOrAjax = (PHP_SAPI == 'cli');
	foreach($aArgs as $sStr)
	{
		print ($bCliOrAjax ? '' : '<pre>') . "{$sStr}" . ($bCliOrAjax ? "\n" : '</pre><br />');
	}
}

function e()
{
	$bCliOrAjax = ((PHP_SAPI == 'cli' || (defined('AIN_IS_AJAX') && AIN_IS_AJAX)));
	ob_clean();
	if (!$bCliOrAjax)
	{
		echo '<link rel="stylesheet" type="text/css" href="/theme/adminpanel/default/style/default/css/debug.css?v=' . AIN_TIME . '" />';
	}
	define('AIN_MEM_END', memory_get_usage());
	 
	
	echo AIN_Debug::getDetails();
	exit;
}

?>