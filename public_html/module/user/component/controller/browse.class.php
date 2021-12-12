<?php

defined('AIN') or exit('NO DICE!');

class User_Component_Controller_Browse extends AIN_Component
{
    /**
     * Controller
     */
    public function process()
    {
		
		$oUrl = AIN::getLib('url');
		$iPage = $this->request()->getInt('page');
		$iPageSize = 15;	
		$iActiveSession = AIN_TIME - (AIN::getParam('user.active_session') * 60);
		
		
		$this->template()->setTitle(AIN::getPhrase('user.menu_browse'));
		$aUsers = array(); 		
		$where = array();
		$aForms = array();
		$order = 'user.last_login desc';
		

		
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
				//$where[] = 'user.email LIKE "%'.$aVals['searchQuery'].'%"';
				$where[] = 'user.user_name LIKE "%'.$aVals['searchQuery'].'%" or user.full_name LIKE "%'.$aVals['searchQuery'].'%" or user.email LIKE "%'.$aVals['searchQuery'].'%" or user.user_id LIKE "%'.$aVals['searchQuery'].'%" or user.phone LIKE "%'.$aVals['searchQuery'].'%"';
				$oUrl->setParam('val[searchQuery]', $aVals['searchQuery']);
			}			
			
			if( isset($aVals['user_order_id']) and strlen($aVals['user_order_id']) > 1  )
			{
				switch($aVals['user_order_id'])
				{
					case 'online':
					$where[] = 'user.last_login >= "'.$iActiveSession.'"';
					break;
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
				
				
	
		
		
		$userIds = array();
		foreach($aUsers as $key => $aRow )
		{
			$userIds[] = $aRow['user_id'];
		}
		$get_wallet = AIN::getService('ad')->get_wallet( array( 'userIds' => $userIds ) );
		$get_bonus = AIN::getService('ad')->get_bonus( array( 'userIds' => $userIds ) );
		$get_payment = AIN::getService('ad')->get_payment( array( 'userIds' => $userIds ) );

		//print_r($get_bonus);
		
		$tableRows = array(); $tkey = 0; $total = array();
		
		foreach($aUsers as $key => $aRow )
		{
			if( $aRow['last_login'] > $iActiveSession)
				$status =  "<u style='color:#04710a;'>online</u>";
			else
				$status = "<u style='color:#9f1915;'>offline</u>";			
			
			$tkey++;	
			//$tableRows[$tkey][''] = '';
			$tableRows[$tkey]['id'] = $aRow['user_id'];	
			
			$tableRows[$tkey]['info'] = "<em> <b>İstifadəçi:</b> $aRow[user_name] ($status) <br/>";	
			
			$tableRows[$tkey]['info'] .= "<b>E-mail:</b> $aRow[email] <br/>";	
			
			if( isset($aRow['phone']) and strlen($aRow['phone']) > 0 )
			$tableRows[$tkey]['info'] .= "<b>Phone:</b> $aRow[phone] <br/>";	
			
			
			if( $aRow['user_group_id'] == 1 )
			$tableRows[$tkey]['info'] .= "<b>Status:</b> <u style='color:red;'>$aRow[user_group_title]</u> <br/>";	
			else
			$tableRows[$tkey]['info'] .= "<b>Status:</b> <u style='color:green;'>$aRow[user_group_title]</u> <br/>";	
			
			if( $aRow['gender'] == 1 )
			$tableRows[$tkey]['info'] .= "<b>Cins:</b> <u style='color:red;'>Kişi</u> <br/>";	
			elseif( $aRow['gender'] == 2 )
			$tableRows[$tkey]['info'] .= "<b>Cins:</b> <u style='color:green;'>Qadın</u> <br/>";	
			
			
			$tableRows[$tkey]['info'] .= "<b>SonGiriş:</b> ".date('d.m.y H:i', $aRow['last_login'])." <br/>";	
			
			
			$tableRows[$tkey]['info'] .= '</em>';	
			
			
			
			$tableRows[$tkey]['Reklamçı'] = "<em>";	
			$tableRows[$tkey]['Reklamçı'] .= "<b>Balans:</b> ".AIN::getService('ad')->price($get_wallet[$aRow['user_id']]['walletAmount'])." AZN <br/>";	
			$tableRows[$tkey]['Reklamçı'] .= "<b>Yatırım</b> ".AIN::getService('ad')->price($get_wallet[$aRow['user_id']]['investedAmount'])." AZN <br/>";	
			$tableRows[$tkey]['Reklamçı'] .= "<b>Bonus:</b> ".AIN::getService('ad')->price($get_bonus[$aRow['user_id']]['amount'])." AZN <br/>";	
			$tableRows[$tkey]['Reklamçı'] .= "<b>YatırımBonus:</b> ".AIN::getService('ad')->price($get_bonus[$aRow['user_id']]['investedAmount'])." AZN <br/>";	
			$tableRows[$tkey]['Reklamçı'] .= '</em>';	
			$tableRows[$tkey]['Reklamçı'] .= '<div class="btn-group m-b-5"><button type="button" data-toggle="dropdown" class="btn dropdown-toggle ">Balans işləmləri <span class="caret"></span> </button> <ul role="menu" class="dropdown-menu"> <li><a href="#" onclick="tb_show(\'Balans işləmləri\', $.ajaxBox(\'ad.wallet_form\', \'height=240&width=450&userId='.$aRow['user_id'].'\')); return false;">Balans artır</a></li>   </ul> </div>';	
			
			
			
			$tableRows[$tkey]['Yayınçı'] = "<em>";	
			$tableRows[$tkey]['Yayınçı'] .= "<b>Qazanc:</b> ".AIN::getService('ad')->price($get_payment[$aRow['user_id']][0]['payableAmount']+$get_payment[$aRow['user_id']][1]['payableAmount'])." AZN <br/>";	
			$tableRows[$tkey]['Yayınçı'] .= "<b>ÖdənişGözlən:</b> ".AIN::getService('ad')->price($get_payment[$aRow['user_id']][0]['pendingAmount']+$get_payment[$aRow['user_id']][1]['pendingAmount'])." AZN <br/>";	
			$tableRows[$tkey]['Yayınçı'] .= "<b>SonÖdəniş:</b> ".AIN::getService('ad')->price($get_payment[$aRow['user_id']][0]['paidAmount']+$get_payment[$aRow['user_id']][1]['paidAmount'])." AZN <br/>";	
			$tableRows[$tkey]['Yayınçı'] .= '</em>';	
			$tableRows[$tkey]['Yayınçı'] .= '<div class="btn-group m-b-5"><button type="button" data-toggle="dropdown" class="btn dropdown-toggle ">Qazanc işləmləri <span class="caret"></span> </button> <ul role="menu" class="dropdown-menu"> <li><a href="#">Ödəniş et</a></li>   </ul> </div>';	

			//$tableRows[$tkey][AIN::getPhrase('user.last_login')] = date('d.m.Y H:i', $aRow['last_login']);	
			
			
		
		}		
		
		
		
		
		
		$aEditForm = array();
		$aEditForm['title'] = AIN::getPhrase('user.browse');
		$aEditForm['info'] = AIN::getPhrase('user.browse_info');
		$aEditForm['icon'] = 'fa fa-user-plus';
		$aEditForm['action'] = AIN::getLib('url')->makeUrl('current');		
		$this->template()->assign(	array('aEditForm' => $aEditForm));
		
		if(count($tableRows) > 0 ) $tableTitle = array_keys(current($tableRows));	
		
		$this->template()->assign(array(
			'tableTitle' => $tableTitle,
			'tableRows' => $tableRows,
			//'tableRows' => array_slice($tableRows,0,count($tableRows)-1),
			//'tableFooter' => array(end($tableRows)),
			'tableFooter' => array(),
			'aForms' => $aForms,
		));
		
		AIN::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt ));
	}
}
?>