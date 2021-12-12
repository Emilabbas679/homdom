<?php
/**
 * [AIN_HEADER]
 */

defined('AIN') or exit('NO DICE!');

AIN::getLibClass('ain.database.dba');

/**
 * Database layer for AIN. All interactions with a database is done via this class.
 * @method AIN_Database_Driver_Mysql select($select)
 * @method AIN_Database_Driver_Mysql update($table, $fields, $where)
 * @method AIN_Database_Driver_Mysql insert($table, $fields)
 * @method AIN_Database_Driver_Mysql delete($table, $where)
 */
class AIN_Database
{
	/**
	 * Holds the drivers object
	 *
	 * @var AIN_Database_Driver_Mysql
	 */
	private static $_oObject = null;

	/**
	 * Loads and initiates the SQL driver that we need to use.
	 *
	 */
	public function __construct()
	{
		if (!self::$_oObject)
		{
            if ($sDriver = AIN::getParam(array('db', 'driver'), false))
            {
                $sDriver = 'database.driver.' . strtolower(preg_replace("/\W/i", "", $sDriver));
            }
            else {
                $sDriver = 'database.driver.mysqli';
            }
			self::$_oObject = AIN::getLib($sDriver);
			self::$_oObject->connect(AIN::getParam(array('db', 'host')), AIN::getParam(array('db', 'user')), AIN::getParam(array('db', 'pass')), AIN::getParam(array('db', 'name')), AIN::getParam(array('db', 'port')));
		}
	}	
	
	/**
	 * Return the object of the storage object.
	 *
	 * @return object Object provided by the storage class we loaded earlier.
	 */	
	public function &getInstance()
	{
		return self::$_oObject;
	}

    public function factory()
    {
        return self::$_oObject;
	}

	/**
	 * @return AIN_Database_Driver_Mysql
	 */
	public static function instance() {
		if (!self::$_oObject) {
			new self();
		}

		return self::$_oObject;
	}

	public function __call($method, $args) {		
		return call_user_func_array([self::$_oObject, $method], $args);
	}
}