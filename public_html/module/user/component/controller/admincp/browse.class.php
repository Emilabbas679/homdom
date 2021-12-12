<?php

defined('AIN') or exit('NO DICE!');


class user_component_controller_admincp_browse extends AIN_Component
{
	public function process()
	{
		$oUrl = AIN::getLib('url');
		$iPage = $this->request()->getInt('page');
		$iPageSize = 50;

		
		
		$this->template()->setTitle(AIN::getPhrase('user.menu_browse'));
		$aUsers = array(); 		
		$where = array();
		$aForms = array();
		$order = 'user.last_login desc';
		
		$aIds = $this->request()->getArray('id');	
		if (($aIds = $this->request()->getArray('id')) && count((array) $aIds))
		{
			if ($this->request()->get('delete'))
			{
				foreach ($aIds as $iId)
				{
					if (AIN::getService('user')->isAdminUser($iId))
					{
							$this->url()->send('current', null, AIN::getPhrase('user.you_are_unable_to_delete_a_site_administrator'));
					}					
					AIN::getService('user.auth')->setUserId($iId);
					AIN::massCallback('onDeleteUser', $iId);
					AIN::getService('user.auth')->setUserId(null);				
				}
			}	
		}
		if ($aVals = $this->request()->getArray('val'))	
		{			
			$aForms = $aVals;
			if( isset($aVals['gender']) and $aVals['gender'] > 0  )
			{
				$where[] = 'user.gender = "'.$aVals['gender'].'"';
				$oUrl->setParam('val[gender]', $aVals['gender']);
			}
			if( isset($aVals['user_group_id']) and $aVals['user_group_id'] > 0  )
			{
				$where[] = 'user.user_group_id = "'.$aVals['user_group_id'].'"';
				$oUrl->setParam('val[user_group_id]', $aVals['user_group_id']);
			}			
			if( isset($aVals['searchQuery']) and strlen($aVals['searchQuery']) > 1  )
			{
				$where[] = 'user.user_name LIKE "%'.$aVals['searchQuery'].'%" or user.full_name LIKE "%'.$aVals['searchQuery'].'%" or user.email LIKE "%'.$aVals['searchQuery'].'%" or user.user_id LIKE "%'.$aVals['searchQuery'].'%" or user.phone LIKE "%'.$aVals['searchQuery'].'%"';
				$oUrl->setParam('val[searchQuery]', $aVals['searchQuery']);
			}			
			
			if( isset($aVals['user_order_id']) and strlen($aVals['user_order_id']) > 1  )
			{
				switch($aVals['user_order_id'])
				{
					case 'asc':
					$order = 'user.last_login asc';
					break;
					case 'desc':
					$order = 'user.last_login desc';
					break;
				}
				$oUrl->setParam('val[user_order_id]', $aVals['user_order_id']);
			}
			
			
			


			
		}
		
		if( isset($where) and count($where) > 0 )
		{
			$where = implode(" AND ", $where);
		}
		
		$iCnt = AIN::getLib('database')->select('count(*) as count')->from(AIN::getT('user'), 'user')->where($where)->execute('getField');
		
		$aUsers = AIN::getLib('database')
				->select('user.*')
				->from(AIN::getT('user'), 'user')
				->leftJoin(AIN::getT('user_group'), 'user_group', 'user.user_group_id = user_group.user_group_id')->select(', user_group.title as user_group_title')
				->order($order)
				->where($where)
				->limit($iPage, $iPageSize, $iCnt)
				->execute('getRows');
				
				
		$iActiveSession = AIN_TIME - (AIN::getParam('user.active_session') * 60);
		
		foreach($aUsers as $key => $aRow )
		{
			if( $aRow['last_login'] > $iActiveSession)
				$aUsers[$key]['status'] =  'online';
			else
				$aUsers[$key]['status'] = 'offline';
		}		
		AIN::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt ));

		
		
		$this->template()->assign( array(
				'aUsers' => $aUsers,
				'aUserCount' => $iCnt,
				'aForms' => $aForms,
				'user_group' =>AIN::getService('user.group')->get(),
				'user_order' => array(
					'desc' => 'DESC',
					'asc' => 'ASC',
				),				
				'user_gender' => array(
					'1' => 'Kişi',
					'2' => 'Qadın',
				),
			)
		);
		
		
		
	}
	public function clean()
	{

	}
}

?>