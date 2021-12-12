<?php
/**
 * [AIN_HEADER]
 */

defined('AIN') or exit('NO DICE!');

AIN::getLibClass('ain.cdn.abstract');

/**
 * We use this class to store data on CDN services like Amazon S3. This can be items from
 * photos, videos, songs, CSS files etc...
 * 
 * Example of storing a file:
 * <code>
 * AIN::getLib('cdn')->put('/var/www/file/sample.jpg');
 * </code>
 * 
 * Displaying an uploaded file:
 * <code>
 * <img src="<?php echo AIN::getLib('cdn')->getUrl('/var/www/file/sample.jpg'); ?>" />
 * </code>
 * 
 */
class AIN_Cdn
{
	/**
	 * Object of the CDN module.
	 *
	 * @var object
	 */
	private $_oObject = null;
	
	/**
	 * Based on what CDN module is selected here is where we load the CDN class and initiat the object.
	 *
	 * @param array $aParams Array of any special params to pass to the module CDN class
	 */
	public function __construct($aParams = array())
	{
		if (!$this->_oObject)
		{
			$sCdn = (AIN::getParam('core.cdn_service') == '' ? 's3' : AIN::getParam('core.cdn_service'));
			
			$this->_oObject = AIN::getLib('cdn.module.' . $sCdn, $aParams);
		}
	}
	
	/**
	 * Return the object of the CDN module object.
	 *
	 * @return object Object provided by the module class we loaded earlier.
	 */		
	public function &getInstance()
	{
		return $this->_oObject;
	}		
}

?>