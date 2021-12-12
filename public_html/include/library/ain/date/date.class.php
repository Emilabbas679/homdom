<?php
/**
 * [Nulled by DarkGoth - NCP TEAM] - 2016
 */

defined('AIN') or exit('NO DICE!');

/**
 * Handles all time/date related logic for AIN.
 * 
 * Example to get a current users timezone they are in:
 * <code>
 * AIN::getLib('date')->getTimeZone();
 * </code>
 * 
 * Example of our usage of mktime:
 * <code>
 * AIN::getLib('date')->mktime(1, 1, 1, 6, 22, 1982);
 * </code>
 * 
 * @copyright		[AIN_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		AIN
 * @version 		$Id: date.class.php 6109 2013-06-21 11:48:16Z Raymond_Benc $
 */
class AIN_Date
{
	/**
	 * Array of all the last days for each of the months starting with January
	 *
	 * @var array
	 */
	private $_aMonthTable = array(
		31, 
		28, 
		31, 
		30, 
		31, 
		30, 
		31, 
		31, 
		30, 
		31, 
		30, 
		31
	);		
	

	/**
	 * Converts a time stamp into a human readable phrase.
	 *
	 * @param int $iTime Time stamp to convert
	 * @param string $sDefault Default phrase to use with the display of the time stamp
	 * @return string Returns the readable phrase with the time stamp included.
	 */
	public function convertTime($iTime, $sDefault = null)
	{
		$iSeconds = (int) round(abs(AIN_TIME - $iTime));
		$iMinutes = (int) round($iSeconds / 60);		

		if ($iMinutes < 1)
		{
			if ($iSeconds === 0 || $iSeconds === 1)
			{
				return AIN::getPhrase('core.1_second_ago');
			}
			return AIN::getPhrase('core.total_seconds_ago', array('total' => $iSeconds));
		}
		
		if ($iMinutes < 60)
		{
			if ($iMinutes === 0 || $iMinutes === 1)
			{
				return AIN::getPhrase('core.1_minute_ago');
			}
			return AIN::getPhrase('core.total_minutes_ago', array('total' => $iMinutes));
		}
		
		$iHours = (int) round(floatval($iMinutes) / 60.0);
		
		if ($iHours < 24)
		{
			if ($iHours === 0 || $iHours === 1)
			{
				return AIN::getPhrase('core.1_hour_ago');
			}
			
			return AIN::getPhrase('core.total_hours_ago', array('total' => $iHours));
		}		
		
		if ($iHours < 48 && ((int) date('d', AIN_TIME) - 1) == date('d', $iTime))
		{
			return AIN::getPhrase('core.yesterday') . ', ' . AIN::getTime(AIN::getParam('core.conver_time_to_string'), $iTime);
		}	
		
		return AIN::getTime(AIN::getParam(($sDefault === null ? 'core.global_update_time' : $sDefault)), $iTime);
	}
	public static function getTimeZone($bDst = false)
	{
		static $sUserOffSet = null;
		if (AIN_USE_DATE_TIME)
		{
			$bDst = false;
		}
		
		if ($bDst === false)
		{
			$sUserOffSet = AIN::getUserBy('time_zone');		
			
			if (empty($sUserOffSet))
			{
				$sUserOffSet = AIN::getParam('core.default_time_zone_offset');
			}			
			
			if (substr($sUserOffSet,0,1) == 'z' && AIN_USE_DATE_TIME)
			{
				$aTZ = AIN::getService('core')->getTimeZones();

				$oGmt = new DateTimeZone('GMT');
				$mTimeNow = new DateTime(null, $oGmt);
				$oTZ = new DateTimeZone($aTZ[$sUserOffSet]);
				$oDateTime = new DateTime(null, $oTZ);			

				$sUserOffSet = ($oTZ->getOffset($mTimeNow) / 3600);
			}
			
			return $sUserOffSet;		
		}
		
		if ($sUserOffSet === null)
		{
			$sUserOffSet = AIN::getUserBy('time_zone');		
			if (empty($sUserOffSet))
			{
				$sUserOffSet = AIN::getParam('core.default_time_zone_offset');
			}
		
			if (self::_isDst() === true && $bDst === true)
			{
				$sUserOffSet = ($sUserOffSet + 1);
			}			
		}	
		
		return $sUserOffSet;	
	}	

	public function mktime($iHour, $iMinute, $iSecond, $iMonth, $iDay, $iYear)
	{
	    $iDay   = intval($iDay);
	    $iMonth = intval($iMonth);
	    $iYear  = intval($iYear);

	    if ($iDay === 0)
	    {
		    $iDay = 1;
	    }

	    if ($iMonth === 0)
	    {
		    $iMonth = 1;
	    }

	    if ($iYear === 0)
	    {
		    $iYear = 1982;
	    }

	    if ((1901 < $iYear) and ($iYear < 2038))
	    {
	    	return mktime($iHour, $iMinute, $iSecond, $iMonth, $iDay, $iYear);
	    }

	    if ($iMonth > 12)
	    {
			$iOverlap = floor($iMonth / 12);
			$iYear   += $iOverlap;
			$iMonth  -= $iOverlap * 12;
	    }
	    else
	    {
			$iOverlap = ceil((1 - $iMonth) / 12);
			$iYear   -= $iOverlap;
			$iMonth  += $iOverlap * 12;
	    }

	    $iDate = 0;
	    // safety check
	    if ($iYear > 2070)
	    {
			$iYear = 2070;
	    }
	    
	    if ($iYear >= 1970)
	    {
			for ($iCount = 1970; $iCount <= $iYear; $iCount++)
			{
			    $bLeapYear = $this->isLeapYear($iCount);
			    if ($iCount < $iYear)
			    {
					$iDate += 365;
					if ($bLeapYear === true)
					{
					    $iDate++;
					}
			    }
			    else
			    {
					for ($iCount = 0; $iCount < ($iMonth - 1); $iCount++)
					{
					    $iDate += $this->_aMonthTable[$iCount];
					    if (($bLeapYear === true) and ($iCount == 1))
					    {
							$iDate++;
					    }
					}
			    }
			}

			$iDate += $iDay - 1;
			$iDate = (($iDate * 86400) + ($iHour * 3600) + ($iMinute * 60) + $iSecond);
	    }
	    else
	    {
			for ($iCount = 1969; $iCount >= $iYear; $iCount--)
			{
			    $bLeapYear = $this->isLeapYear($iCount);
			    if ($iCount > $iYear)
			    {
					$iDate += 365;
					if ($bLeapYear === true)
					{
					    $iDate++;
					}
			    }
			    else
			    {
					for ($iCount = 11; $iCount > ($iMonth - 1); $iCount--)
					{
					    $iDate += $this->_aMonthTable[$iCount];
					    if (($bLeapYear === true) and ($iCount == 1))
					    {
						$iDate++;
					    }
					}
			    }
			}

			$iDate += ($this->_aMonthTable[$iMonth - 1] - $iDay);
			$iDate = -(($iDate * 86400) + (86400 - (($iHour * 3600) + ($iMinute * 60) + $iSecond)));
	
			if ($iDate < -12220185600)
			{
			    $iDate += 864000;
			}
			elseif ($iDate < -12219321600)
			{
			    $iDate  = -12219321600;
			}
	    }

		return $iDate;
    }

    public function getWeekDay($day)
    {
        switch ((int)$day) {
            case 1:
                return _p('core.monday');
                break;
            case 2:
                return _p('core.tuesday');
                break;
            case 3:
                return _p('core.wednesday');
                break;
            case 4:
                return _p('core.thursday');
                break;
            case 5:
                return _p('core.friday');
                break;
            case 6:
                return _p('core.saturday');
                break;
            case 7:
                return _p('core.sunday');
                break;           
            default:
                return '';
                break;
        }
    }
}

?>