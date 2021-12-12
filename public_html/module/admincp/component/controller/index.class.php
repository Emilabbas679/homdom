<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Index extends AIN_Component
{
	
	private $_sController = 'index';
	private $_sModule;
	
	public function process()
	{
		// Istifadəçi girişi 
		if( ! AIN::isUser() ) return AIN_Module::instance()->setController('admincp.login');
				
		$this->_sModule = (($sReq1 = $this->request()->get('req1')) ? strtolower($sReq1) : AIN::getParam('admincp.admin_cp'));

		if ($this->_sModule == 'logout')
		{
			$this->_sController = $this->_sModule;
			$this->_sModule = 'admincp';
		}
		else
		{
			$this->_sController = (($sReq2 = $this->request()->get('req2')) ? $sReq2 : $this->_sController);
		}		
		
		if ($sReq3 = $this->request()->get('req3'))
		{
			$sReq3 = str_replace(' ', '', strtolower(str_replace('-', ' ', $sReq3)));
		}
		$sReq4 = $this->request()->get('req4');

		$bPass = false;
		if (file_exists(AIN_DIR_MODULE . $this->_sModule . AIN_DS . AIN_DIR_MODULE_COMPONENT . AIN_DS . 'controller' . AIN_DS . 'admincp' . AIN_DS . $this->_sController . '.class.php'))
		{
			$this->_sController = 'admincp.' . $this->_sController;
			$bPass = true;
		}

		if (!$bPass && $sReq4 && file_exists(AIN_DIR_MODULE . $this->_sModule . AIN_DS . AIN_DIR_MODULE_COMPONENT . AIN_DS . 'controller' . AIN_DS . 'admincp' . AIN_DS . $this->_sController . AIN_DS . $sReq3 . AIN_DS . $sReq4 . '.class.php'))
		{
			$this->_sController = 'admincp.' . $this->_sController . '.' . $sReq3 . '.' . $sReq4;
			$bPass = true;
		}

		if (!$bPass && $sReq3 && file_exists(AIN_DIR_MODULE . $this->_sModule . AIN_DS . AIN_DIR_MODULE_COMPONENT . AIN_DS . 'controller' . AIN_DS . 'admincp' . AIN_DS . $this->_sController . AIN_DS . $sReq3 . '.class.php'))
		{
			$this->_sController = 'admincp.' . $this->_sController . '.' . $sReq3;
			$bPass = true;
		}

		if (!$bPass && file_exists(AIN_DIR_MODULE . $this->_sModule . AIN_DS . AIN_DIR_MODULE_COMPONENT . AIN_DS . 'controller' . AIN_DS . 'admincp' . AIN_DS . $this->_sController . AIN_DS . $this->_sController . '.class.php'))
		{
			$this->_sController = 'admincp.' . $this->_sController . '.' . $this->_sController;
			$bPass = true;
		}

		if (!$bPass && $sReq3 && file_exists(AIN_DIR_MODULE . $this->_sModule . AIN_DS . AIN_DIR_MODULE_COMPONENT . AIN_DS . 'controller' . AIN_DS . 'admincp' . AIN_DS . $this->_sController . AIN_DS . $sReq3 . '.class.php'))
		{
			$this->_sController = 'admincp.' . $this->_sController . '.' . $sReq3;
			$bPass = true;
		}

		if (!$bPass && $sReq3 && file_exists(AIN_DIR_MODULE . $this->_sModule . AIN_DS . AIN_DIR_MODULE_COMPONENT . AIN_DS . 'controller' . AIN_DS . 'admincp' . AIN_DS . $this->_sController . AIN_DS . $sReq3 . AIN_DS . 'index.class.php'))
		{
			$this->_sController = 'admincp.' . $this->_sController . '.' . $sReq3 . '.index';
			$bPass = true;
		}

		if (!$bPass && file_exists(AIN_DIR_MODULE . $this->_sModule . AIN_DS . AIN_DIR_MODULE_COMPONENT . AIN_DS . 'controller' . AIN_DS . 'admincp' . AIN_DS . $this->_sController . AIN_DS . 'index.class.php'))
		{
			$this->_sController = 'admincp.' . $this->_sController . '.index';
			$bPass = true;
		}

		if (!$bPass && file_exists(AIN_DIR_MODULE . 'admincp' . AIN_DS . AIN_DIR_MODULE_COMPONENT . AIN_DS . 'controller' . AIN_DS . $this->_sModule . AIN_DS . $this->_sController . '.class.php'))
		{
			$this->_sController = $this->_sModule . '.' . $this->_sController;
			$this->_sModule = 'admincp';
			$bPass = true;
		}

		if (!$bPass && $sReq3 && file_exists(AIN_DIR_MODULE . 'admincp' . AIN_DS . AIN_DIR_MODULE_COMPONENT . AIN_DS . 'controller' . AIN_DS . $this->_sModule . AIN_DS . $this->_sController . AIN_DS . $sReq3 . '.class.php'))
		{
			$this->_sController = $this->_sModule . '.' . $this->_sController . '.' . $sReq3;
			$this->_sModule = 'admincp';
			$bPass = true;
		}

		if (!$bPass && AIN::getParam('admincp.admin_cp') != 'admincp' && file_exists(AIN_DIR_MODULE . $this->_sModule . AIN_DS . AIN_DIR_MODULE_COMPONENT . AIN_DS . 'controller' . AIN_DS . $this->_sController . '.class.php'))
		{
			$bPass = true;
		}
		if ($bPass)
		{
			AIN_Module::instance()->setController($this->_sModule . '.' . $this->_sController);			
		}
		
		$aUser = AIN::getUserBy();
		
		$aMenus = array();
		
		///Admincp Home
		$aMenus[AIN::getPhrase('admincp.dashboard')] = AIN::getLib('url')->makeUrl('');			
		
		$this->template()->assign( array(
			'aUserDetails' => $aUser,
			'aAdminMenus' => $aMenus,
			'sAINVersion' => AIN::getVersion(),
			'sSiteTitle' => AIN::getParam('core.site_title')
		) );
	}
}
?>