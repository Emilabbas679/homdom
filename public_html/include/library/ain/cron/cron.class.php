<?php

defined('AIN') or exit('NO DICE!');

class AIN_Cron
{
    /**
     * @return array
     */
    public function getReadyJobs()
    {
        $aRows = [];
        try {
			AIN::getLib('database')->beginTransaction();
            $aRows = AIN::getLib('database')->select('cron.*')
                ->from(AIN::getT('cron'), 'cron')
                ->where('cron.is_active = 1')
                ->where('next_run < ' . time())
                ->forUpdate()
                ->execute('getRows');
            foreach ($aRows as $aRow) {
                AIN::getLib('database')->update(AIN::getT('cron'), [
                    'last_run' => time(),
                    'next_run' => $this->_getNextRun($aRow['type_id'], $aRow['every']),
                ], 'cron_id=' . $aRow['cron_id']);
            }
            AIN::getLib('database')->commit();
        } catch (\Exception $ex) {
            AIN::getLib('database')->rollback();
            echo 'cron errors:  ', $ex->getMessage();
            exit;
        }
        return array_map(function ($aRow) {
            return $aRow['php_code'];
        }, $aRows);
    }
    private function _getNextRun($iType, $iEvery)
    {
        switch ($iType) {
            case 1: // Minute
                $iAddTime = ($iEvery * CRON_ONE_MINUTE);
                break;
            case 2: // Hour
                $iAddTime = ($iEvery * CRON_ONE_HOUR);
                break;
            case 3: // Day
                $iAddTime = ($iEvery * CRON_ONE_DAY);
                break;
            case 4: // Month
                break;
            case 5: // Year, Doubt we will use this

                break;
        }
        if (isset($iAddTime)) {
            return ($iAddTime + AIN_TIME);
        } else {
            return false;
        }
    }
}
