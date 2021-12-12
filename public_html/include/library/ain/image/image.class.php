<?php

defined('AIN') or exit('NO DICE!');

AIN::getLibClass('ain.image.abstract');

class AIN_Image
{
	/**
	 * Object for the image library
	 *
	 * @var object
	 */
	private static $_oObject = null;

	/**
	 * Class constructor. We load the image library the admin decided to use on their site.
	 *
	 */
	public function __construct()
	{
		if (!self::$_oObject)
		{			
			$sDriver = 'image.library.gd';

			self::$_oObject = AIN::getLib($sDriver);
		}
	}	
	
	/**
	 * Returns the object of the image library we are using
	 *
	 * @return AIN_Image_Library_Gd
	 */
	public function &getInstance()
	{
		return self::$_oObject;
	}

	/**
	 * @return AIN_Image_Library_Gd
	 */
	public static function instance() {
		if (!self::$_oObject) {
			new self();
		}

		return self::$_oObject;
	}
}