<?php

defined('AIN') or exit('NO DICE!');

class apanel_service_advert_advert extends AIN_Service {

    public function __construct() 
	{


    }	
	public function get_user_campaign_select( $user_id = 1)
	{		
		$where = array();
		$where['user_id'] = $user_id;
		$return = array();
		$aRows = AIN::getService('video')->get_user_campaign($where);
		if( isset($aRows['data']['rows']) )
		foreach($aRows['data']['rows'] as $key => $aRow )
		{
			$return[$aRow['campaign_id']] = $aRow['name'];
		}	
		return $return;
	}
	public function get_user_campaign_adset( $campaign_id = 1)
	{		
		$where = array();
		$where['campaign_id'] = $campaign_id;
		return AIN::getService('video')->get_adset($where);
	}
	public function getForEdit( $ad_id = 0 )
	{
		$return = AIN::getService('video')->get_one_ad( array( 'ad_id' => (int) $ad_id ) );
		
		if( $return['status'] = 'success' )
			return $return['data'];
		else
			return AIN_ERROR::set($return['messages']);
	}


	public function getAd( $ad_id = 0 )
	{
		$cacheSet = "adset_adId:$ad_id";
		if( ( $aRows = AIN::getLib('redis')->get($cacheSet)) )
		{
			return json_decode($aRows, true);
		}
		else
		{		
			$return = AIN::getService('video')->get_one_ad( array( 'ad_id' => (int) $ad_id ) );

			AIN::getLib('redis')->set($cacheSet, json_encode($return['data']) );
			AIN::getLib('redis')->expire($cacheSet, 6000 );	
			//echo "$cacheSet <br/>";			
			return $return['data'];
		}
	}
	
	


}

?>
