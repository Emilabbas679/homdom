<?php

defined('AIN') or exit('NO DICE!');

AIN::getLibClass('ain.database.driver.mysql');

class AIN_Database_Driver_Mysqli extends AIN_Database_Driver_Mysql
{
	/**
	 * Resource for the MySQLi master server
	 *
	 * @var \mysqli
	 */
	protected $_hMaster = null;

	/**
	 * Resource for the MySQLi salve server
	 *
	 * @var \mysqli
	 */
	protected $_hSlave = null;

	/**
	 * Array of all the MySQLi functions we use. This
	 * variable overwrites the parent MySQL variable.
	 *
	 * @see parent::$_aCmd
	 * @var array
	 */
	protected $_aCmd = [
		'mysql_query'              => 'mysqli_query',
		'mysql_connect'            => 'mysqli_connect',
		'mysql_pconnect'           => 'mysqli_connect',
		'mysql_select_db'          => 'mysqli_select_db',
		'mysql_num_rows'           => 'mysqli_num_rows',
		'mysql_fetch_array'        => 'mysqli_fetch_array',
		'mysql_real_escape_string' => 'mysqli_real_escape_string',
		'mysql_insert_id'          => 'mysqli_insert_id',
		'mysql_fetch_assoc'        => 'mysqli_fetch_assoc',
		'mysql_free_result'        => 'mysqli_free_result',
		'mysql_error'              => 'mysqli_error',
		'mysql_affected_rows'      => 'mysqli_affected_rows',
		'mysql_get_server_info'    => 'mysqli_get_server_info',
		'mysql_close'              => 'mysqli_close',
	];

	/**
	 * Makes a connection to the MySQL database
	 *
	 * @param string $sHost       Hostname or IP
	 * @param string $sUser       User used to log into MySQL server
	 * @param string $sPass       Password used to log into MySQL server. This can be blank.
	 * @param mixed  $sPort       Port number (int) or false by default since we do not need to define a port.
	 * @param bool   $sPersistent False by default but if you need a persistent connection set this to true.
	 *
	 * @return bool If we were able to connect we return true, however if it failed we return false and a error message
	 *              why.
	 */
	protected function _connect($sHost, $sUser, $sPass, $sPort = false, $sPersistent = false)
	{
		if(AIN_DEBUG)
			$start = microtime(true);

		if (!$sPort) {
			$sPort = 3306;
		}

		$name = AIN::getParam(['db', 'name']);

		$hLink = @mysqli_connect($sHost, $sUser, $sPass, $name, intval($sPort));

		if(AIN_DEBUG)
			AIN_Debug::$connectionTime = (microtime(true)- $start);

		if (!$hLink)
			return false;

		return $hLink;
	}

	/**
	 * Begin transaction
	 *
	 * @return mixed
	 */
	public function beginTransaction()
	{
		return $this->query('START TRANSACTION', $this->_hMaster);
	}

	/**
	 * Rollback a transaction
	 */
	public function rollback()
	{
		return $this->query('ROLLBACK', $this->_hMaster);
	}

	/**
	 * Commit a transaction
	 */
	public function commit()
	{
		return $this->query('COMMIT', $this->_hMaster);
	}
}
?>