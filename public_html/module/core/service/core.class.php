<?php

defined('AIN') or exit('NO DICE!');

class Core_service_Core extends AIN_Service
{	
    /**
     * @var array
     */
    private $timezones;
   
	/**
     * @param bool $getAll
     * @return array|bool|mixed
     */
    public function getTimeZones($getAll = false)
    {
        if (!$this->timezones) {
            $sPathFile = AIN_DIR_SETTINGS . 'timezones.sett.php';
            
			if (file_exists($sPathFile)) {
                $this->timezones = require($sPathFile);
            }

            if (empty($this->timezones)) {
                $this->timezones = $this->generateTimeZones(true);
            }
        }
        $timezones = $this->timezones;
		
		/*
        $disableTimezones = AIN::getService('core')->getDisabledTimezones();
        if (!$getAll && !empty($disableTimezones)) {
            foreach ($disableTimezones as $key => $disableTimezone) {
                if ($disableTimezone) {
                    unset($timezones[$key]);
                }
            }
        }
		*/
		
        return $timezones;
    }
    /**
     * @param bool $bReturnArray
     * @param bool $bForceGenerate
     *
     * @return array|bool
     */
    public function generateTimeZones($bReturnArray = false, $bForceGenerate = false)
    {
        $sPathFile = AIN_DIR_SETTINGS . 'timezones.sett.php';
		
        if (file_exists($sPathFile) && !$bForceGenerate) {
            return ($bReturnArray ? $this->getTimeZones(true) : true);
        }
        if (AIN_USE_DATE_TIME) {
            $aTimeZones = DateTimeZone::listIdentifiers();
            sort($aTimeZones);
            foreach ($aTimeZones as $iKey => $sTimeZone) {
                $aTimeZones['z' . $iKey] = $sTimeZone;
                unset($aTimeZones[$iKey]);
            }
        } else {
            $aTimeZones = [
                '-12' => '(GMT -12:00) Eniwetok, Kwajalein',
                '-11' => '(GMT -11:00) Midway Island, Samoa',
                '-10' => '(GMT -10:00) Hawaii',
                '-9' => '(GMT -9:00) Alaska',
                '-8' => '(GMT -8:00) Pacific Time (US &amp; Canada)',
                '-7' => '(GMT -7:00) Mountain Time (US &amp; Canada)',
                '-6' => '(GMT -6:00) Central Time (US &amp; Canada), Mexico City',
                '-5' => '(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima',
                '-4.5' => '(GMT -4:30) Caracas',
                '-4' => '(GMT -4:00) Atlantic Time (Canada), La Paz, Santiago',
                '-3.5' => '(GMT -3:30) Newfoundland',
                '-3' => '(GMT -3:00) Brazil, Buenos Aires, Georgetown',
                '-2' => '(GMT -2:00) Mid-Atlantic',
                '-1' => '(GMT -1:00 hour) Azores, Cape Verde Islands',
                '0' => '(GMT) Western Europe Time, London, Lisbon, Casablanca',
                '1' => '(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris',
                '2' => '(GMT +2:00) Kaliningrad, South Africa',
                '3' => '(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg',
                '3.5' => '(GMT +3:30) Tehran',
                '4' => '(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi',
                '4.5' => '(GMT +4:30) Kabul',
                '5' => '(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent',
                '5.5' => '(GMT +5:30) Bombay, Calcutta, Madras, New Delhi',
                '5.75' => '(GMT +5:45) Kathmandu',
                '6' => '(GMT +6:00) Almaty, Dhaka, Colombo',
                '6.5' => '(GMT +6:30) Yangon, Cocos Islands',
                '7' => '(GMT +7:00) Bangkok, Hanoi, Jakarta',
                '8' => '(GMT +8:00) Beijing, Perth, Singapore, Hong Kong',
                '9' => '(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk',
                '9.5' => '(GMT +9:30) Adelaide, Darwin',
                '10' => '(GMT +10:00) Eastern Australia, Guam, Vladivostok',
                '11' => '(GMT +11:00) Magadan, Solomon Islands, New Caledonia',
                '12' => '(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka'
            ];
        }

        file_put_contents($sPathFile, "<?php\n return " . var_export($aTimeZones, true) . ";\n");

        return ($bReturnArray ? $aTimeZones : true);
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function getRewrite($sUrls)
	{
		return AIN::getLib('database')->select('cr.rewrite_id')->from(AIN::getT('core_rewrite'), 'cr')->where('cr.url = ".$sUrls."')->execute('getRow');
	}
	
	
	
	
	
	public function getGenders($bReturnPhrase = false)
	{
		$aGenders = array();

		$aGenders[1] = 'Kişi';
		$aGenders[2] = 'Qadın';
			
		return $aGenders;
	}
	
	
	
	
	
	
	
	
	
	
	
    /**
     * If a call is made to an unknown method attempt to connect
     * it to a specific plug-in with the same name thus allowing
     * plug-in developers the ability to extend classes.
     *
     * @param string $sMethod is the name of the method
     * @param array $aArguments is the array of arguments of being passed
     *
     * @return null
     */
    public function __call($sMethod, $aArguments)
    {
        /**
         * No method or plug-in found we must throw a error.
         */
        AIN_Error::trigger('Call to undefined method ' . __CLASS__ . '::' . $sMethod . '()', E_USER_ERROR);
    }
	
}
?>