<?php

defined('AIN') or exit('NO DICE!');

class apanel_service_advert_process extends AIN_Service {

    public function __construct() 
	{
		$this->adnetwork = AIN::getService('video');
    }	
	
	public function update($aVals, $ad_id = NULL)
	{
		return $this->add($aVals, $ad_id);
	}
	public function add($aVals, $ad_id = NULL)
	{
		
		//$aVals['start_time'] = strtotime("$aVals[start_date] $aVals[start_date_time]");
		//$aVals['end_time'] = strtotime("$aVals[end_date] $aVals[end_date_time]");
		
		$targeting = array();

		if( isset($aVals['site']) and count($aVals['site']) > 0  ) 
		{
			$targeting['site'] = $this->multiple($aVals['site']);
			unset($aVals['site']);
		}
		
		if( isset($aVals['excluded_site']) and count($aVals['excluded_site']) > 0  ) 
		{
			$targeting['excluded_site'] = $this->multiple($aVals['excluded_site']);
			unset($aVals['excluded_site']);
		}			
		$targeting['frequency'] = isset($aVals['frequency']) ? $aVals['frequency'] : 0;
		unset($aVals['frequency']);		
		
		$targeting['frequency_capping'] = isset($aVals['frequency_capping']) ? $aVals['frequency_capping'] : 0;
		unset($aVals['frequency_capping']);

		$targeting['frequency_period'] = isset($aVals['frequency_period']) ? $aVals['frequency_period'] : 'day';
		unset($aVals['frequency_period']);		
		
		$targeting['week_day_hours'] = isset($aVals['week_day_hours']) ? $this->multiple($aVals['week_day_hours']) : null;
		unset($aVals['week_day_hours']);
		
		
		
		$aVals['targeting'] = $targeting;
		
		
		if( $ad_id !== NULL )
		{
			$save['ad_id'] = $ad_id;
			
			$oReturn = AIN::getService('video')->update_ad($aVals);
		}
		else
		{			
			$oReturn = $this->adnetwork->create_ad($aVals);			
		}	
		
		//print_r($aVals); die();


		return $oReturn;
	}
	
	
	
	
	function multiple($data)
	{
		return json_encode($data);	
		
		
		
		$category = ( isset($data) ? $data : array() );
		if( !count( $category ) ) {
			$category = array ();
		}		
		$category_list = array();
		foreach ( $category as $value ) {
			$category_list[] = intval($value);
		}
		$category_value = implode( ',', $category_list );
		
		return $category_value;		
	}
	
	
	public function old_add($aVals)
	{
		
		$save = array();	

		if( isset($aVals['country_id']) and $aVals['country_id'] > 0  ) $save['countryId'] = $aVals['country_id'];
		$save['adTypeId'] =  4;
		$save['name'] = AIN::getLib('parse.input')->clean($aVals['name']);
		$save['adUrl'] = $aVals['ad_url'];
		
		if ( isset($aVals['format_type_id']) and $aVals['format_type_id'] > 0)
		{
			$save['contentTypeId'] = $aVals['format_type_id'] ;
		}	
		if ( isset($aVals['text']) and strlen($aVals['text']) > 0)
		{
			$save['text'] = $aVals['text'] ;
		}	
		else
		{
			$save['text'] = null;
		}
		$save['sizeId'] = isset( $aVals['dimension_id'] ) ? intval( $aVals['dimension_id'] ) : 0;
		$save['adModelId'] = isset( $aVals['model_id'] ) ? intval( $aVals['model_id'] ) : 0;


		$save['fileData'] = isset($aVals['fileData']) ? AIN::getLib('url')->decode($aVals['fileData']) : '';					


				//Başlanğıc tarixi
		$aVals['start_date'] = strtotime("$aVals[start_date] $aVals[start_date_time]");
		$aVals['end_date'] = strtotime("$aVals[end_date] $aVals[end_date_time]");
	
		$save['startDate'] = date('d.m.Y H:i', $aVals['start_date']);	
		$save['endDate'] = date('d.m.Y H:i', $aVals['end_date']);	
		
		if( isset($aVals['hours']) and count($aVals['hours']) > 0 )	
		{
			$hours = '';
			for ($i = 0; $i <= 23; $i++)
			{
				$hours .= ( (isset($aVals['hours'][$i])) ? '1' : '0' );
			}
			$save['hours'] = $hours;	
		}
		else	
		{
			$save['hours'] = '';
		}
		$save['budgetAmount'] = 1;		
		$save['budgetType'] = 'total';				
		$save['requestSource'] = 4;	
		
		$save['userId'] = $aVals['user_id'];
		
		$return = AIN::getService('video.adnetwork')->create_advert($save);
		
		$this->old_delete($return['adId']);
		
		return $return;
	}
	public function old_delete( $adId)
	{
		$where = array();
		$where['itemId'] = $adId;	
		$where['itemType'] = 'advert';			
		$data = AIN::getService('video.adnetwork')->delete($where);
		return true;
	}
	
	
	
	
	
	
	
	/*Approve OK*/
	public function active( $aVals)
	{
		$oReturn = AIN::getService('video')->approve_ad($aVals);
		
		
		

		if( $oReturn['status'] == 'failed' )
		{
			foreach($oReturn['messages'] as $key => $err)
			AIN_ERROR::set($err);
			return false;
		}
		if( $oReturn['status'] == 'success' )
			return $oReturn['data'];
		
		
		
		
		return true;		
	}
	
	
	/*Approve OK*/
	public function deactive( $aVals)
	{
		$oReturn = AIN::getService('video')->reject_advert($aVals);

		//print_r($aVals);



		if( $oReturn['status'] == 'failed' )
			return AIN_ERROR::set($oReturn['messages']);

		if( $oReturn['status'] == 'success' )
			return $oReturn['data'];
		
		
		
		
		return false;		
	}
	
	
	
	
	
}

?>
