<?php
/**
 * [PHPFOX_HEADER]
 */

defined('AIN') or exit('NO DICE!');

class apanel_component_block_AjaxSiteList extends AIN_Component
{
	public function process()
	{	
		$aVals = AIN::getLib('request')->get('val');		
		$where = array(); 
		$results = array();
			
		$where['limit'] = 2000;
		$where['page'] = 1; 
		
		$where['status_id'] = 11;
		
		if( isset($aVals['format_type_id']) )
			$where['format_type_id'] = $aVals['format_type_id'];
			
		if( isset($aVals['dimension_id']) )
			$where['dimension_id'] = $aVals['dimension_id'];			
			

		$SiteList = array();
		
		if ($aApi = AIN::getService('video')->get_slot_site($where)) {
			if (isset($aApi['data']['rows'])) {
				$SiteList = $aApi['data']['rows'];
			}
		}
		
		//print_r($SiteList);
		
		$this->template()->assign(array('SiteList' => $SiteList));	

	}
}

?>