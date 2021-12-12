<?php

defined('AIN') or exit('NO DICE!');

AIN::getLibClass('ain.mail.interface');

/**
 * Email Driver Layer
 * Our email loads a 3rd party email class that usually has support for both sendmail and smtp.
 * 
 * Example:
 * <code>
 * AIN::getLib('mail')->to('foo@bar.com')
 * 		->subject('Test Subject')
 * 		->message('Test Message')
 * 		->send();
 * </code>
 */
class ain_mail
{
	/**
	 * Object of the 3rd party library we are using to send the actual image.
	 *
	 * @var object
	 */
	private $_oMail = null;
	/**
	 * STRING or ARRAY of emails or users to send the emai to.
	 *
	 * @var mixed
	 */
	private $_mTo = null;

	/**
	 * The email of the person sending the email.
	 *
	 * @var string
	 */
	private $_sFromEmail = null;
	
	
	/**
	 * ARRAY if loading a phrase or STRING if we are passing a subject.
	 *
	 * @var mixed
	 */
	private $_aSubject = null;
	
	/**
	 * The name of the person sending the email.
	 *
	 * @var string
	 */
	private $_sFromName = null;
	
	
	/**
	 * Class constructor that loads a specific method of sending emails (sendmail or smtp)
	 *
	 * @param string $sMethod Method to send an email (sendmail or smtp)
	 */
	public function __construct($sMethod = null)
    {    
    	$this->_oMail = AIN::getLib('mail.driver.phpmailer.' . ($sMethod === null ? AIN::getParam('core.method') : $sMethod));
		$this->_sArray = 'array("site_name" => "'.str_replace('"', '&quot;',AIN::getParam('core.site_title')).'","site_email" => "'.AIN::getParam('core.email_from_email').'")';
    }
	/**
	 * @return AIN_Mail
	 */
	public static function instance() {
		return AIN::getLib('mail');
	}
    /**
     * Identify who this email will be sent to. Can be an actual email or a user ID or an array of 
     * emails or user IDs.
     *
     * @param mixed $mTo ARRAY of emails/users or STRING of email/user
     * @return AIN_Mail
     */
    public function to($mTo)
    {    	
    	$this->_mTo = $mTo;
    	
    	return $this;
    }
    
    /**
     * Subject of the email.
     *
     * @param mixed $aSubject ARRAY if loading a phrase or STRING if we are passing a subject.
     * @return AIN_Mail
     */
    public function subject($aSubject)
    {
		$this->_aSubject = $aSubject;
		
		return $this;
    }
    /**
     * Message of the email.
     *
     * @param mixed $aMessage ARRAY of loading a phrase or STRING of we are passing the message directly.
     * @return AIN_Mail
     */
    public function message($aMessage)
    {
		$this->_aMessage = $aMessage;

    	return $this;    	
    }
	/**
	 * Email address validator based on http://www.linuxjournal.com/article/9585 and RFC 2821
	 * Uses recursion for arrays
	 * 
	 * @param mixed $mEmail array|string
	 * @return boolean true if all valid
	 */
	public function checkEmail($mEmail)
	{
		if (is_array($mEmail))
		{			
			foreach($mEmail as $sEmail)
			{
				if (!$this->_checkEmail($sEmail, AIN::getParam('core.use_dnscheck')))
				{
					// return here before keep going					
					return false;
				}
			}
			return true;
		}
		return $this->_checkEmail($mEmail);		
	}
    /**
     * Run a test if we are able to send out an email using the default method being loaded.
     *
     * @param array $aVals ARRAY of values to test.
     * @return AIN_Mail
     */
    public function test($aVals)
    {
    	$this->_oMail->test($aVals);
    	
    	return $this;
    }
    /**
     * The name of the person sending out the email.
     *
     * @param string $sFromName Persons name.
     * @return AIN_Mail
     */
    public function fromName($sFromName)
    {
    	$this->_sFromName = $sFromName;
    	
    	return $this;
    }
    /**
     * Email of the person sending out this email.
     *
     * @param string $sFromEmail Email.
     * @return AIN_Mail
     */
    public function fromEmail($sFromEmail)
    {
    	$this->_sFromEmail = $sFromEmail;
    	
    	return $this;
    }
	/**
	 * We load users information in our send() method, however you can also load users by passing
	 * an array of their information with this method.
	 *
	 * @param array $aUser ARRAY of users information.
	 * @return AIN_Mail
	 */
	public function aUser($aUser)
	{
		$this->_aUsers[] = ($aUser);

		return $this;
	}
    /**
     * Method to send out the email.
     * Checks: 
     * 		(message || to) === null -> return false;
     * 		(sFromName || sFromEmail) === null -> getParam(core.
     * 		(Notification) assumes to is an array of integers, otherwise return false
	 *
	 * @example AIN::getLib('mail')->to('user@email.com')->subject('Test Subject')->message('This is a test message')->send();
     * @example AIN::getLib('mail')->to(array('user1@email.com', 'user2@email.com', 'user3@email.com')->subject('Test Subject')->message('This is a test message')->send()
     * @return boolean
     */
    public function send($bDoCheck = false)
    {
		if (defined('AIN_SKIP_MAIL'))
		{
			return true;
		}
    	// turn into an array
    	if (!is_array($this->_mTo))
    	{
    		$this->_mTo = array($this->_mTo);
    	}
		// check if the mail(s) are valid
		if ($bDoCheck && $this->checkEmail($this->_mTo) == false)
		{			
			return false;
		}
    	if ($this->_aMessage === null || $this->_mTo === null)
    	{
    		return false;
    	}
		
    	if ($this->_sFromName === null)
		{
			$this->_sFromName = AIN::getParam('core.mail_from_name');
		}
		
		if ($this->_sFromEmail === null)
		{
			$this->_sFromEmail = AIN::getParam('core.email_from_email');
		}
		
		$this->_sFromName = html_entity_decode($this->_sFromName, null, 'UTF-8');

		$sIds = '';
		$sEmails = '';
        //in some case variable $aUser is not defined
        $aUser = null;
		if (!empty($this->_aUsers))
		{
			foreach ($this->_aUsers as $aUser)
			{
				if (isset($aUser['user_id']) && !empty($aUser['user_id']))
				{
					$sIds .= (int) $aUser['user_id'] . ',';
				}
			}
		}
		else
		{
			foreach ($this->_mTo as $mTo)
			{
				if (strpos($mTo, '@'))
				{
					$sEmails .= $mTo . ',';
				}
				else
				{
					$sIds .= (int) $mTo . ',';
				}
			}			
		}
		$sIds = rtrim($sIds, ',');
		$sEmails = rtrim($sEmails, ',');
		
		$bIsSent = true;
		if (!empty($sEmails))
		{
			$aEmails = explode(',', $sEmails);
			foreach ($aEmails as $sEmail)
			{
				$sEmail = trim($sEmail);				
				$sMessage = $this->_aMessage;				
				$sSubject = $this->_aSubject;

                if (isset($aUser)){
                    $sEmailSig = $this->_getSignature($aUser);
                } else {
                    $sEmailSig = $this->_getSignature();
                }
                $sEmailSig = $this->_getTranslatePhrase($sEmailSig, $aUser['language_id']);
				
				// Load HTML text template
				$sTextHtml = AIN::getLib('template')->assign(array(
						'sMessage' => $sMessage,	
						'bHtml' => true,		
						'sEmailSig' => $sEmailSig,
					)
				)->getLayout('email', true);	
				
				$sTextPlain = '';				
				
				//$bIsSent = (defined('AIN_CACHE_MAIL') ? $this->_cache($sEmail, $sSubject, $sTextPlain, $sTextHtml, $this->_sFromName, $this->_sFromEmail) : $this->_oMail->send($sEmail, $sSubject, $sTextPlain, $sTextHtml, $this->_sFromName, $this->_sFromEmail));
			
				$bIsSent = $this->_oMail->send($sEmail, $sSubject, $sTextPlain, $sTextHtml, $this->_sFromName, $this->_sFromEmail);
			
				$this->_cache($sEmail, $sSubject, $sTextPlain, $sTextHtml, $this->_sFromName, $this->_sFromEmail, $bIsSent);
			}	
		}		
		return $bIsSent;
	}	
	private function _checkEmail($sEmail, $bDoDnsCheck = false)
	{		
		$iAtIndex = strrpos($sEmail, "@");
		
		if ($iAtIndex === false)
		{ // there is no @ symbol
		   return false;
		}

		$sDomain = substr($sEmail, $iAtIndex+1);
		$sLocal = substr($sEmail, 0, $iAtIndex);

		$iDomainLen = strlen($sDomain);
		$iLocalLen = strlen($sLocal);

		
		if ( ($iLocalLen < 1) || ($iLocalLen > 64) || ($iDomainLen < 1) || ($iDomainLen > 255))
		{ // either the user or the domain are not within valid values
			return false;
		}
		
		if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$sLocal)))
		{
		   // character not valid in local part unless
		   // local part is quoted
		   if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$sLocal)))
		   {
			  return false;
		   }
		}

		// check for dots according to RFC 2822 3.2.4
		if ($sLocal[0] == '.' || $sLocal[$iLocalLen-1] == '.' || preg_match('/\\.\\./', $sLocal))
		{
		   // local starts or ends with a dot or has 2 consecutive dots
		   return false;
		}
		// validate domain
		if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $sDomain) || (preg_match('/\\.\\./', $sDomain)))
		{
		   // Domain has 2 consecutive dots or invalid characters
		   return false;
		}
		elseif ($bDoDnsCheck == true && function_exists('checkdnsrr')
			&& !(checkdnsrr($sDomain,"MX") || checkdnsrr($sDomain, "A")))
		{
		   // domain not found in DNS
		   return false;
		}

		return true;
	}  
    private function _cache($sEmail, $sSubject, $sTexPlain, $sTextHtml, $sFromName, $sFromEmail, $bIsSent = 0)
    {    	
		$logfile = 'email_' . md5(str_replace(' ', '_', $sSubject) . AIN_TIME . uniqid()) . '.html';
		
    	AIN::getLib('file')->write(AIN_DIR_FILE . 'log' . AIN_DS . $logfile, "<b>Email:</b> {$sEmail}<br />\n<b>Subject:</b> {$sSubject}\n<br /><b>Text Plan:</b>{$sTexPlain}\n<br /><b>Text HTML:</b> {$sTextHtml}\n<br /><b>From Name:</b> {$sFromName}\n<br /><b>From Email:</b> {$sFromEmail}");
    	
		AIN::getLib('database')->insert(AIN::getT('user_mail_sendlog'), array(
			'isSend' => $bIsSent,
			'email' => $sEmail,
			'subject' => $sSubject,
			'texthtml' => $sTextHtml,
			'logfile' => $logfile,			
		) );	
		
    	return true;
    }
	
	
	
	
    private function _getTranslatePhrase($text, $sLanguageId = 'en'){
        $aReplacements =  [
            'site_name'=> AIN::getParam('core.site_title'),
            'site_email'=> AIN::getParam('core.email_from_email')
        ];
        $return = preg_replace_callback('/\{phrase var=\'(.*)\'\}/is', function ($matches) use($aReplacements, $sLanguageId){
            return AIN::getLib('locale')->getPhrase($matches[1],$aReplacements, false, null, $sLanguageId);
        }, $return);
        return $return;
    }
	private function _getSignature($aUser = null){
		  if (!isset($aUser)){
			  $aUser['language_id'] = AIN::getLib('locale')->getLangId();
		  }
		  $sSignature = AIN::getParam('core.mail_signature');
		  if (AIN::getLib('locale')->isPhrase($sSignature)){
			  return AIN::getPhrase($sSignature,  array(), false, null, $aUser['language_id']);
		  } else {
			  return $this->_getTranslatePhrase($sSignature, $aUser['language_id']);
		  }
	}
}

?>