<?php

defined('AIN') or exit('NO DICE!');

require_once(AIN_DIR_LIB . 'amazons3/vendor/autoload.php');
use Aws\S3\S3Client;


class AIN_Cdn_Module_S3 extends AIN_Cdn_Abstract
{
	/**
	 * Object for the amazon s3 class
	 *
	 * @var object
	 */
	private $_oObject = null;
	
	/**
	 * Name of the bucket we plan to store all the uploaded data
	 *
	 * @var string
	 */
	private $_sBucket = null;
	
	/**
	 * Bool value if the bucket has already been created or not.
	 *
	 * @var bool
	 */
	private $_bHasBucket = false;
	
	/**
	 * Bool value if we were able to upload the file or not.
	 *
	 * @var false
	 */
	private $_bIsUploaded = false;
	
	/**
	 * Loads the amazons3 library developed by another group.
	 *
	 */
	public function __construct()
	{
		$this->_sBucket = AIN::getParam('core.amazon_bucket');	

 
		$this->_oObject = new S3Client([
			'version' => 'latest',
			'region' => AIN::getParam('core.amazon_region'),
			'credentials' => [
				'key'    => AIN::getParam('core.amazon_access_key'),
				'secret' => AIN::getParam('core.amazon_secret_key')
			]
		]);
	}

	public function put($sFile, $sName = null)
	{		
		if (empty($sName))
		{
			$sName = str_replace("\\", '/', str_replace(AIN_DIR, '', $sFile));
		}

		try {
			$result = $this->_oObject->putObject([
				'Bucket' => $this->_sBucket,
				'Key'    => $sName,
				'Body'   => fopen($sFile, 'r'),
				'ACL'    => 'public-read',
			]);
			return true;
		} catch (Aws\S3\Exception\S3Exception $e) {
			return false;
		}
		return false;
	}
	public function getUrl($sFile)
	{
		$sName = str_replace("\\", '/', str_replace(AIN_DIR, '', $sFile));
		return $this->_oObject->getObjectUrl($this->_sBucket, $sName);
	}
	
}
?>