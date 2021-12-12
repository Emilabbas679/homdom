<?php


defined('AIN') or exit('NO DICE!');


class AIN_Mail_Driver_Phpmailer_Mail implements AIN_Mail_Interface
{
	/**
	 * PHPMailer Object
	 *
	 * @var unknown_type
	 */
	private $_oMail = null;

	/**
	 * Class constructor that loads PHPMailer class and sets all the needed variables.
	 *
	 * @return mixed FALSE if we cannot load PHPMailer, or NULL if we were.
	 */
	public function __construct()
    {
	   	require_once(AIN_DIR_LIB . 'phpmailer' . AIN_DS . 'class.phpmailer.php');

	    $this->_oMail = new PHPMailer;
	    $this->_oMail->From = (AIN::getParam('core.email_from_email') ? AIN::getParam('core.email_from_email') : 'server@localhost.com');
	    $this->_oMail->FromName = (AIN::getParam('core.mail_from_name') === null ? AIN::getParam('core.site_title') : AIN::getParam('core.mail_from_name'));
	    $this->_oMail->WordWrap = 75;
	    $this->_oMail->CharSet = 'utf-8';
    }
    public function send($mTo, $sSubject, $sTextPlain, $sTextHtml, $sFromName = null, $sFromEmail = null)
    {
      if (defined('AIN_DEFAULT_OUT_EMAIL')){
        $mTo = AIN_DEFAULT_OUT_EMAIL;
      }
    	$this->_oMail->AddAddress($mTo);
		$this->_oMail->Subject = $sSubject;
		//$this->_oMail->Body = $sTextHtml;
		$this->_oMail->MsgHTML($sTextHtml);
		$this->_oMail->AltBody = $sTextPlain;

		if ($sFromName !== null)
		{
			$this->_oMail->FromName = $sFromName;
		}

		if ($sFromEmail !== null)
		{
			$this->_oMail->From = $sFromEmail;
		}

		if(!$this->_oMail->Send())
		{
			$this->_oMail->ClearAddresses();
			return AIN_Error::set($this->_oMail->ErrorInfo);
		}

		$this->_oMail->ClearAddresses();

		return true;
    }
}

?>