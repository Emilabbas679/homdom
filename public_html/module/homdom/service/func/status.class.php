<?php

defined('AIN') or exit('NO DICE!');

class homdom_service_func_status extends AIN_Service {

	private $get_static_status = array();
	
	
	public function __construct()
	{
		$sCacheId = $this->cache()->set(array('adnetwork', 'get_static_status_'. AIN::getLib('locale')->getLangId() ));
		if (!($this->get_static_status = $this->cache()->get($sCacheId)))
		{
			$this->get_static_status = AIN::getService('video')->get_static_status(array());
			
			$this->cache()->save($sCacheId, $this->get_static_status);
		}
		

	}


	public function getStatusName( $aRow = [] )
	{
		if( $aRow['campaign_status_id'] !== 11 )
		{
			return AIN::getPhrase("adnetwork.ad_static_campaign_status_{$aRow['campaign_status_id']}");
		}
		else
		{
			return $this->getStatus($aRow['status_id']);
		}
	}

	public function getStatusAdsetName( $aRow = [] )
	{
			return $this->getStatus($aRow['status_id']);
	}
	
	public function getStatusAdvertName( $aRow = [] )
	{
		
		if( $aRow['campaign_status_id'] !== 11 )
		{
			return AIN::getPhrase("adnetwork.ad_static_campaign_status_{$aRow['campaign_status_id']}");
		}
		elseif( $aRow['set_status_id'] !== 11 )
		{
			return AIN::getPhrase("adnetwork.ad_static_set_status_{$aRow['set_status_id']}");
		}
		else
		{
			return $this->getStatus($aRow['status_id']);
		}
	}
	
	
	
	
	function getStatus($status_id = null)
	{		
		$select = array();			
		if( isset($this->get_static_status['data']) )
		{
			foreach($this->get_static_status['data'] as $key => $aRow )
			{
				switch($aRow['status_id'])
				{					
					case 10:
					$select[$aRow['status_id']] = "<span class='badge badge-danger'>{$aRow['name']}</span>";
					break;						
					case 11:
					$select[$aRow['status_id']] = "<span class='badge badge-success'>{$aRow['name']}</span>";
					break;		
					case 12:
					$select[$aRow['status_id']] = "<span class='badge bg-purple'>{$aRow['name']}</span>";
					break;	
					case 13:
					$select[$aRow['status_id']] = "<span class='badge badge-success'>{$aRow['name']}</span>";
					break;
					case 15:
					$select[$aRow['status_id']] = "<span class='badge badge-warning'>{$aRow['name']}</span>";
					break;
					case 17:
					$select[$aRow['status_id']] = "<span class='badge badge-warning'>{$aRow['name']}</span>";
					break;
					case 23:
					$select[$aRow['status_id']] = "<span class='badge badge-dark'>{$aRow['name']}</span>";
					break;	
					case 27:
					$select[$aRow['status_id']] = "<span class='badge badge-danger'>{$aRow['name']}</span>";
					break;					
					case 40:
					$select[$aRow['status_id']] = "<span class='badge badge-warning'>{$aRow['name']}</span>";
					break;
					default:
					//$select[$aRow['status_id']] = $aRow['name'] . ' ' . $aRow['status_id'];
					$select[$aRow['status_id']] = $aRow['name'];
					break;
				}				
			}
		}
		if ($status_id !== null)
			return isset($select[$status_id]) ? $select[$status_id] : null;
		else
			return $select;
	}






	public function get_transactions()
	{
		$aOptions = array();
		$aOptions[50] = $this->getStatus(50);
		$aOptions[51] = $this->getStatus(15);
		$aOptions[52] = $this->getStatus(52);
		$aOptions[53] = $this->getStatus(53);
		$aOptions[54] = $this->getStatus(54);
		$aOptions[55] = $this->getStatus(55);
		$aOptions[56] = $this->getStatus(56);
		$aOptions[57] = $this->getStatus(57);
		$aOptions[58] = $this->getStatus(58);
		$aOptions[59] = $this->getStatus(59);		
		return $aOptions;
	}
}

?>
