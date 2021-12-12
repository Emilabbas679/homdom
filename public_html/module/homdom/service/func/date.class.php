<?php

defined('AIN') or exit('NO DICE!');

class apanel_service_func_date extends AIN_Service {

	private $get_static_status = array();
	
	
	public function __construct()
	{	
		
	}
	public function dateSelect()
	{
		$dateSelect = array(
			//'7' => AIN::getPhrase('adnetwork.dateselect_7'), //'Son 24 saat',
			'1' => AIN::getPhrase('adnetwork.dateselect_1', array( 'date' =>  date('d F') ) ), //'Today: May 25',
			'2' => AIN::getPhrase('adnetwork.dateselect_2', array( 'date' =>  date('d F', AIN_TIME - 60*60*24) ) ),
			'3' => AIN::getPhrase('adnetwork.dateselect_3'),
			'4' => AIN::getPhrase('adnetwork.dateselect_4'),
			'5' => AIN::getPhrase('adnetwork.dateselect_5', array( 'date' =>  date('F') ) ),
			'6' => AIN::getPhrase('adnetwork.dateselect_6', array( 'date' =>  date('F', mktime(0, 0, 0, date("m")-1, 01,   date("Y"))) ) ),
			'0' => AIN::getPhrase('adnetwork.choose_date_range'),
		);	
			
	 return $dateSelect;
	}
	
	
	public function between( $date_select = 5 )
	{
		$aVals = array();
		
		switch( $date_select )
		{
				case 1: // 'Today: May 25'
					$aVals['start_date'] = $aVals['end_date'] = date('d.m.Y');					
				break;
				case 2: // 'Yesterday: May 24'
					$aVals['start_date'] = $aVals['end_date'] = date('d.m.Y', AIN_TIME - 60*60*24);					
				break;	
				case 3: // 'Last 7 days',
					$aVals['start_date'] = date('d.m.Y', AIN_TIME - 60*60*24*7);					
					$aVals['end_date'] = date('d.m.Y', AIN_TIME);
				break;	
				case 4: // 'Last 30 days',
					$aVals['start_date'] = date('d.m.Y', AIN_TIME - 60*60*24*30);					
					$aVals['end_date'] = date('d.m.Y', AIN_TIME);
				break;
				case 5: // 'This month: May',
					$aVals['start_date'] = date('d.m.Y', mktime(0, 0, 0, date("m"), 01,   date("Y")));					
					$aVals['end_date'] = date('d.m.Y', AIN_TIME);
				break;	
				case 6: // 'Last month: April',
					$aVals['start_date'] = date('d.m.Y', mktime(0, 0, 0, date("m")-1, 01,   date("Y")));					
					$aVals['end_date'] = date('d.m.Y',  strtotime("last day of this month", mktime(0, 0, 0, date("m")-1, 01,   date("Y"))));
				break;
				
				case 7: // 'Last 24 hours',
					$aVals['start_date'] = date('d.m.Y', (AIN_TIME - 86400));					
					$aVals['end_date'] = date('d.m.Y', AIN_TIME);
					
					$aVals['start_hour'] = date('H', (AIN_TIME - 86400));					
					$aVals['end_hour'] = date('H', AIN_TIME);	
					
				break;
		}
		return $aVals;
	}
    public function getArray($sAge)
    {
		if(strlen($sAge) < 8 ) $sAge = "0{$sAge}"; 
		
        return [
            'month' => (substr($sAge, 2, 2)),
            'day' => (substr($sAge, 0, 2)),
            'year' => (substr($sAge, 4)),
        ];
    }
	

	public function betweenTime( $date_select = 5 )
	{
		$aVals = array();
		switch( $date_select )
		{
			case 1: // 'Today: May 25'
				$aVals['start_date'] = mktime(0, 0, 0, date('m'), date('d'), date('Y'));					
				$aVals['end_date'] = mktime(23, 59, 59, date('m'), date('d'), date('Y'));					
			break;
		}
	}

}

?>
