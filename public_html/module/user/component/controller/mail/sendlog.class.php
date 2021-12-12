<?php
/**
 * [Nulled by DarkGoth - NCP TEAM] - 2016
 */

defined('AIN') or exit('NO DICE!');

class User_Component_Controller_Mail_Sendlog extends AIN_Component 
{
	/**
	 * Process the controller
	 *
	 */
	public function process()
	{
		$where = array();
		$iPage = $this->request()->getInt('page');
		$iPageSize = 15;		
		
		
		if( isset($where) and count($where) > 0 )
		{
			$where = implode(" AND ", $where);
		}
		
		$iCnt = AIN::getLib('database')->select('count(*) as count')->from(AIN::getT('user_mail_sendlog'), 'user_mail_sendlog')->where($where)->execute('getField');
		
		$user_mail_sendlog = AIN::getLib('database')
				->select('user_mail_sendlog.*')
				->from(AIN::getT('user_mail_sendlog'), 'user_mail_sendlog')
				->order('user_mail_sendlog.logdate desc')
				->where($where)
				->limit($iPage, $iPageSize, $iCnt)
				->execute('getRows');
		
		
		AIN::getLib('pager')->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt ));
		
		
		$this->template()->setTitle(AIN::getPhrase('user.mail_sendlog'))->assign(array( 'user_mail_sendlog' => $user_mail_sendlog ));			
	}
}

?>