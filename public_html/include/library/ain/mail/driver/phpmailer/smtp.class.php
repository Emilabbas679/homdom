<?php
/**
 * [Nulled by DarkGoth - NCP TEAM] - 2016
 */

defined('AIN') or exit('NO DICE!');

/**
 * PHPMailer SMTP
 *
 * @copyright		[AIN_COPYRIGHT]
 * @author			Raymond Benc
 * @package 		AIN
 * @version 		$Id: smtp.class.php 1666 2010-07-07 08:17:00Z Raymond_Benc $
 */
class AIN_Mail_Driver_Phpmailer_Smtp implements AIN_Mail_Interface
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
        require_once(AIN_DIR_LIB . 'phpmailer' . AIN_DS . 'PHPMailerAutoload.php');


        $this->_oMail = new PHPMailer;
        $this->_oMail->From = (AIN::getParam('core.email_from_email') ? AIN::getParam('core.email_from_email') : 'server@localhost');
        $this->_oMail->FromName = (AIN::getParam('core.mail_from_name') ? AIN::getParam('core.mail_from_name') : AIN::getParam('core.site_title'));
        if (AIN::getParam('core.mail_smtp_authentication')) {
            $this->_oMail->SMTPAuth = true;
            $this->_oMail->Username = AIN::getParam('core.mail_smtp_username');
            $this->_oMail->Password = AIN::getParam('core.mail_smtp_password');
            $this->_oMail->SMTPSecure = true;
            $this->_oMail->sign(
                '/home/coreapi/public_html/file/ssls/cert.pem',
                '/home/coreapi/public_html/file/ssls/key.pem',
                'ZUR8tR5tg1Bu',
                '/home/coreapi/public_html/file/ssls/ca.pem',
            );
        }

        $this->_oMail->Port = AIN::getParam('core.mail_smtp_port');
        $this->_oMail->Host = AIN::getParam('core.mailsmtphost');
        $this->_oMail->Mailer = "smtp";
        $this->_oMail->WordWrap = 75;
        $this->_oMail->CharSet = 'utf-8';


        $this->_oMail->isSMTP();

        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $this->_oMail->SMTPDebug = 0;

        //Ask for HTML-friendly debug output
        $this->_oMail->Debugoutput = 'html';
    }

    /**
     * Run a test to make sure the admin provides the correct SMTP information.
     *
     * @param array $aVals ARRAY of values to connect to an SMTP server.
     */
    public function test($aVals)
    {
        $this->_oMail = new PHPMailer;
        $this->_oMail->From = $aVals['email_from_email'];
        $this->_oMail->FromName = $aVals['mail_from_name'];
        if ($aVals['mail_smtp_authentication']) {
            $this->_oMail->SMTPAuth = true;
            $this->_oMail->Username = $aVals['mail_smtp_username'];
            $this->_oMail->Password = $aVals['mail_smtp_password'];
        }

        $this->_oMail->Port = $aVals['mail_smtp_port'];
        $this->_oMail->Host = $aVals['mailsmtphost'];
        $this->_oMail->Mailer = "smtp";
        $this->_oMail->WordWrap = 75;
        $this->_oMail->CharSet = 'utf-8';
        $this->_oMail->SMTPDebug = 2;
    }

    /**
     * Sends out an email.
     *
     * @param mixed $mTo Can either be a persons email (STRING) or an ARRAY of emails.
     * @param string $sSubject Subject message of the email.
     * @param string $sTextPlain Plain text of the message.
     * @param string $sTextHtml HTML version of the message.
     * @param string $sFromName Name the email is from.
     * @param string $sFromEmail Email the email is from.
     * @return bool TRUE on success, FALSE on failure.
     */
    public function send($mTo, $sSubject, $sTextPlain, $sTextHtml, $sFromName = null, $sFromEmail = null)
    {
        if (defined('AIN_DEFAULT_OUT_EMAIL')) {
            $mTo = AIN_DEFAULT_OUT_EMAIL;
        }
        $this->_oMail->AddAddress($mTo);
        $this->_oMail->Subject = $sSubject;
        //$this->_oMail->Body = $sTextHtml;
        $this->_oMail->MsgHTML($sTextHtml);
        $this->_oMail->AltBody = $sTextPlain;

        if ($sFromName !== null) {
            $this->_oMail->FromName = $sFromName;
        }

        if ($sFromEmail !== null) {
            $this->_oMail->From = $sFromEmail;
        }

        if (!$this->_oMail->Send()) {
            $this->_oMail->ClearAddresses();
            return AIN_Error::set($this->_oMail->ErrorInfo);
        }

        $this->_oMail->ClearAddresses();

        return true;
    }
}
