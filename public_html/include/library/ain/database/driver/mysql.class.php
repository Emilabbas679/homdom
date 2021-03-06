<?php

defined('AIN') or exit('NO DICE!');

class AIN_Database_Driver_Mysql extends AIN_Database_Dba
{
	public $sSlaveServer;

	protected $_hMaster = null;

	protected $_hSlave = null;

	protected $_bIsSlave = false;

	protected $_aCmd = [
		'mysql_query'              => 'mysql_query',
		'mysql_connect'            => 'mysql_connect',
		'mysql_pconnect'           => 'mysql_pconnect',
		'mysql_select_db'          => 'mysql_select_db',
		'mysql_num_rows'           => 'mysql_num_rows',
		'mysql_fetch_array'        => 'mysql_fetch_array',
		'mysql_real_escape_string' => 'mysql_real_escape_string',
		'mysql_insert_id'          => 'mysql_insert_id',
		'mysql_fetch_assoc'        => 'mysql_fetch_assoc',
		'mysql_free_result'        => 'mysql_free_result',
		'mysql_error'              => 'mysql_error',
		'mysql_affected_rows'      => 'mysql_affected_rows',
		'mysql_get_server_info'    => 'mysql_get_server_info',
		'mysql_close'              => 'mysql_close',
	];

	public function connect($sHost, $sUser, $sPass, $sName, $sPort = false, $sPersistent = false)
	{
		// Connect to master db
		$this->_hMaster = $this->_connect($sHost, $sUser, $sPass, $sPort, $sPersistent);

		// Unable to connect to master
		if (!$this->_hMaster) {
			// Cannot connect to the database
			return AIN_Error::set('Cannot connect to the database: ' . $this->_sqlError());
		}

		// Check if we have any slave servers
		if (AIN::getParam(['db', 'slave'])) {
			// Get the slave array
			$aServers = AIN::getParam(['db', 'slave_servers']);

			// Get a random slave to use if there is more then one slave
			$iSlave = (count($aServers) > 1 ? rand(0, (count($aServers) - 1)) : 0);

			if (AIN_DEBUG) {
				$this->sSlaveServer = $aServers[ $iSlave ][0];
			}

			// Connect to slave
			$this->_hSlave = $this->_connect($aServers[ $iSlave ]['host'], $aServers[ $iSlave ]['user'], $aServers[ $iSlave ]['pass'], $aServers[ $iSlave ]['port'], $sPersistent);

			// Check if we were able to connect to the slave
			if ($this->_hSlave) {
				if (!@($this->_aCmd['mysql_select_db'] == 'mysqli_select_db' ? $this->_aCmd['mysql_select_db']($this->_hSlave, $sName) : $this->_aCmd['mysql_select_db']($sName, $this->_hSlave))) {
					$this->_hSlave = null;
				}
			}
		}
		// If unable to connect to a slave or if no slave is called lets copy the master 
		if (!$this->_hSlave) {
			$this->_hSlave =& $this->_hMaster;
		}

		// Attempt to connect to master table
		if (!@($this->_aCmd['mysql_select_db'] == 'mysqli_select_db' ? $this->_aCmd['mysql_select_db']($this->_hMaster, $sName) : $this->_aCmd['mysql_select_db']($sName, $this->_hMaster))) {
			return AIN_Error::set('Cannot connect to the database: ' . $this->_sqlError());
		}
		
		if(!defined('COLLATE'))
		{ 
			define ("COLLATE", "utf8mb4");
		}
		
		$this->_aCmd['mysql_query']($this->_hMaster, "/*!40101 SET NAMES '" . COLLATE . "' */");	

		return true;
	}

	/**
	 * Returns the MySQL version
	 *
	 * @return string
	 */
	public function getVersion()
	{
		return @$this->_aCmd['mysql_get_server_info']($this->_hMaster);
	}

	/**
	 * Returns MySQL server information. Here we only identify that it is MySQL and the version being used.
	 *
	 * @return string
	 */
	public function getServerInfo()
	{
		return 'MySQL ' . $this->getVersion();
	}

	public function query($sSql, &$hLink = '')
	{
		if (!$hLink) {
			$hLink =& $this->_hMaster;
		}

		(AIN_DEBUG ? AIN_Debug::start('sql') : '');

		$hRes = @($this->_aCmd['mysql_query'] == 'mysqli_query' ? $this->_aCmd['mysql_query']($hLink, $sSql) : $this->_aCmd['mysql_query']($sSql, $hLink));

		if (defined('AIN_LOG_SQL') && AIN::getLib('file')->isWritable(AIN_DIR_FILE . 'log' . AIN_DS)) {
			$log = AIN_DIR_FILE . 'log' . AIN_DS . 'ain_query_' . date('d.m.y', AIN_TIME) . '_' . md5(AIN::getVersion()) . '.php';
			file_put_contents($log, "##\n{$sSql}##\n\n", FILE_APPEND);
		}

		if (!$hRes) {
			AIN_Error::trigger('Query Error:' . $this->_sqlError() . ' [' . $sSql . ']', (AIN_DEBUG ? E_USER_ERROR : E_USER_WARNING));
		}

		(AIN_DEBUG ? AIN_Debug::end('sql', ['sql' => $sSql, 'slave' => $this->_bIsSlave, 'rows' => (is_bool($hRes) ? '-' : @$this->_aCmd['mysql_num_rows']($hRes))]) : '');

		$this->_bIsSlave = false;
		
		return $hRes;
	}

	/**
	 * Prepares string to store in db (performs  addslashes() )
	 *
	 * @param mixed $mParam string or array of string need to be escaped
	 *
	 * @return mixed escaped string or array of escaped strings
	 */
	public function escape($mParam)
	{
		if (is_array($mParam)) {
			return array_map([&$this, 'escape'], $mParam);
		}

		$mParam = @($this->_aCmd['mysql_real_escape_string'] == 'mysqli_real_escape_string' ? $this->_aCmd['mysql_real_escape_string']($this->_hMaster, $mParam) : $this->_aCmd['mysql_real_escape_string']($mParam));

		return $mParam;
	}

	/**
	 * Returns row id from last executed query
	 *
	 * @return int id of last INSERT operation
	 */
	public function getLastId()
	{
		return @$this->_aCmd['mysql_insert_id']($this->_hMaster);
	}

	/**
	 * Frees the MySQL results
	 *
	 */
	public function freeResult()
	{
		if (is_resource($this->rQuery)) {
			@$this->_aCmd['mysql_free_result']($this->rQuery);
		}
	}

	/**
	 * Returns the affected rows.
	 *
	 * @return array
	 */
	public function affectedRows()
	{
		return @$this->_aCmd['mysql_affected_rows']($this->_hMaster);
	}

	/**
	 * MySQL has special search functions, so we try to use that here.
	 *
	 * @param string $sType   Type of search we plan on doing.
	 * @param mixed  $mFields Array of fields to search
	 * @param string $sSearch Value to search for.
	 *
	 * @return string MySQL query to use when performing the search
	 */
	public function search($sType, $mFields, $sSearch)
	{
		switch ($sType) {
			case 'full':
				return "AND MATCH(" . implode(',', $mFields) . ") AGAINST ('+" . $this->escape($sSearch) . "' IN BOOLEAN MODE)";
				break;
			case 'like%':
				$sSql = '';
				foreach ($mFields as $sField) {
					$sSql .= "OR " . $sField . " LIKE '%" . $this->escape($sSearch) . "%' ";
				}

				return 'AND (' . trim(ltrim(trim($sSql), 'OR')) . ')';
				break;
		}
	}

	/**
	 * During development you may need to check how your queries are being executed and how long they are taking. This
	 * routine uses MySQL's EXPLAIN to return useful information.
	 *
	 * @param string $sQuery MySQL query to check.
	 *
	 * @return string HTML output of the information we have found about the query.
	 */
	public function sqlReport($sQuery)
	{
		$sHtml = '';
		$sExplainQuery = $sQuery;
		if (preg_match('/UPDATE ([a-z0-9_]+).*?WHERE(.*)/s', $sQuery, $m)) {
			$sExplainQuery = 'SELECT * FROM ' . $m[1] . ' WHERE ' . $m[2];
		} elseif (preg_match('/DELETE FROM ([a-z0-9_]+).*?WHERE(.*)/s', $sQuery, $m)) {
			$sExplainQuery = 'SELECT * FROM ' . $m[1] . ' WHERE ' . $m[2];
		}

		$sExplainQuery = trim($sExplainQuery);


		//if (preg_match('/SELECT/se', $sExplainQuery) || preg_match('/^\(SELECT/', $sExplainQuery)) 
		if (preg_match('/SELECT/i', $sExplainQuery) || preg_match('/^\(SELECT/', $sExplainQuery)) 
		{
			
			//die($sExplainQuery);
			$bTable = false;

			if ($hResult = @($this->_aCmd['mysql_query'] == 'mysqli_query' ? $this->_aCmd['mysql_query']($this->_hMaster, "EXPLAIN $sExplainQuery") : $this->_aCmd['mysql_query']("EXPLAIN $sExplainQuery", $this->_hMaster))) {
				while ($aRow = @$this->_aCmd['mysql_fetch_assoc']($hResult)) {
					list($bTable, $sData) = AIN_Debug::addRow($bTable, $aRow);

					$sHtml .= $sData;
				}
			}
			@$this->_aCmd['mysql_free_result']($hResult);

			if ($bTable) {
				$sHtml .= '</table>';
			}
		}

		return $sHtml;
	}

	/**
	 * Check if a field in the database is set to null
	 *
	 * @param string $sField The field we plan to check
	 *
	 * @return string Returns MySQL IS NULL usage
	 */
	public function isNull($sField)
	{
		return '' . $sField . ' IS NULL';
	}

	/**
	 * Check if a field in the database is set not null
	 *
	 * @param string $sField The field we plan to check
	 *
	 * @return string Returns MySQL IS NOT NULL usage
	 */
	public function isNotNull($sField)
	{
		return '' . $sField . ' IS NOT NULL';
	}

	/**
	 * Adds an index to a table.
	 *
	 * @param string $sTable Database table.
	 * @param string $sField List of indexes to add.
	 * @param string $sName
	 * @return resource Returns the MySQL resource from mysql_query()
	 */
	public function addIndex($sTable, $sField, $sName =  null)
	{
	    if($sName) ;

		$sSql = 'ALTER TABLE ' . $sTable . ' ADD INDEX (' . $sField . ')';

		return $this->query($sSql);
	}

    /**
     * Drop an index from a table
     *
     * @param string $sTable
     * @param null $sName
     *
     * @return resource
     */
    public function dropIndex($sTable, $sName = null)
    {
        $sSql = 'ALTER TABLE ' . $sTable . ' DROP INDEX ' . $sName;

        return $this->query($sSql);
	}

	/**
	 * Adds fields to a database table.
	 *
	 * @param array $aParams Array of fields and what type each field is.
	 *
	 * @return resource Returns the MySQL resource from mysql_query()
	 */
	public function addField($aParams)
	{
        $type = AIN::getLib('database.export')->getType('mysql', $aParams['type']);
		$sSql = 'ALTER TABLE ' . $aParams['table'] . ' ADD ' . $aParams['field'] . ' ' . $type;
		if (isset($aParams['attribute'])) {
			$sSql .= ' ' . $aParams['attribute'] . ' ';
		}
		if (isset($aParams['null'])) {
			$sSql .= ' ' . ($aParams['null'] ? 'NULL' : 'NOT NULL') . ' ';
		}
		if (isset($aParams['default'])) {
			$sSql .= ' DEFAULT ' . $aParams['default'] . ' ';
		}

        if (isset($aParams['after'])) {
            $sSql .= ' AFTER ' . $aParams['after'] . ' ';
        }
        else if (isset($aParams['first'])) {
            $sSql .= ' FIRST ';
        }
		return $this->query($sSql);
	}

	/**
	 * Drops a specific field from a table.
	 *
	 * @param string $sTable Database table
	 * @param string $sField Name of the field to drop
	 *
	 * @return resource Returns the MySQL resource from mysql_query()
	 */
	public function dropField($sTable, $sField)
	{
		return $this->query('ALTER TABLE ' . $sTable . ' DROP ' . $sField);
	}

	/**
	 * Checks if a field already exists or not.
	 *
	 * @param string $sTable Database table to check
	 * @param string $sField Name of the field to check
	 *
	 * @return bool If the field exists we return true, if not we return false.
	 */
	public function isField($sTable, $sField)
	{
		$aRows = $this->getRows("SHOW COLUMNS FROM {$sTable}");
		foreach ($aRows as $aRow) {
			if (strtolower($aRow['Field']) == strtolower($sField)) {
				return true;
			}
		}

		return false;
	}

    /**
     * Change field.
     *
     * @param string $sTable Database table to check
     * @param string $sField Name of the field to check
     * @param array $aParams new params for the field
     *
     * @return resource Returns the MySQL resource from mysql_query()
     */
    public function changeField($sTable, $sField, $aParams)
    {
        $sSql = 'ALTER TABLE ' . $sTable . ' CHANGE ' . $sField . ' ' . $sField . ' ';
        if (isset($aParams['type']))
        {
            $type = AIN::getLib('database.export')->getType('mysql', $aParams['type']);
            $sSql .= $type;
        }
        if (isset($aParams['null']))
        {
            $sSql .= ' ' . ($aParams['null'] ? 'NULL' : 'NOT NULL');
        }
        if (isset($aParams['default']))
        {
            $sSql .= ' DEFAULT ' . $this->escape($aParams['default']);
        }
        return $this->query($sSql);
    }

	/**
	 * Checks if an index already exists or not.
	 *
	 * @param string $sTable Database table to check
	 * @param string $sIndex Name of the index to check
	 *
	 * @return bool If the index exists we return true, if not we return false.
	 */
	public function isIndex($sTable, $sIndex)
	{
		$aRows = $this->getRows("SHOW INDEX FROM {$sTable}");
		foreach ($aRows as $aRow) {
			if (strtolower($aRow['Key_name']) == strtolower($sIndex)) {
				return true;
			}
		}

		return false;
	}

    /**
     * Add primary key for table.
     *
     * @param string $sTable Database table
     * @param string $sField Name of the field
     *
     * @return resource Returns the MySQL resource from mysql_query()
     */
	public function addPrimaryKey($sTable, $sField)
    {
        return $this->query('ALTER TABLE ' . $sTable . ' ADD PRIMARY KEY (`' . $sField . '`)');
    }

    /**
     * truncate table
     *
     * @param $sTable
     *
     * @return resource
     */
    public function truncateTable($sTable)
    {
        return $this->query('TRUNCATE ' . $this->table($sTable));
    }

    /**
     * drop table
     *
     * @param $sTable
     *
     * @return resource
     */
    public function dropTable($sTable)
    {
        return $this->query('DROP TABLE ' . $this->table($sTable));
    }

    public function getColumns($sTable)
    {
        return $this->getRows("SHOW COLUMNS FROM {$sTable}");
    }

    /**
	 * Returns the status of the table.
	 *
	 * @return array Returns information about the table in an array.
	 */
	public function getTableStatus()
	{
		return $this->_getRows('SHOW TABLE STATUS', true, $this->_hMaster);
	}

	/**
	 * Checks if a database table exists.
	 *
	 * @param string $sTable Table we are looking for.
	 *
	 * @return bool If the table exists we return true, if not we return false.
	 */
	public function tableExists($sTable)
	{
		$aTables = $this->getTableStatus();

		foreach ($aTables as $aTable) {
			if ($aTable['Name'] == $sTable) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Optimizes a table
	 *
	 * @param string $sTable Table to optimize
	 *
	 * @return resource Returns the MySQL resource from mysql_query()
	 */
	public function optimizeTable($sTable)
	{
		return $this->query('OPTIMIZE TABLE ' . $this->escape($sTable));
	}

	/**
	 * Repairs a table
	 *
	 * @param string $sTable Table to repair
	 *
	 * @return resource Returns the MySQL resource from mysql_query()
	 */
	public function repairTable($sTable)
	{
		return $this->query('REPAIR TABLE ' . $this->escape($sTable));
	}

	/**
	 * Checks if we can backup the database or not. This depends on the server itself.
	 * We currently only support unix based servers.
	 *
	 * @return bool Returns true if we can backup or false if we can't
	 */
	public function canBackup()
	{
		return ((function_exists("exec") AND $checkDump = @str_replace("mysqldump:", "", exec("whereis mysqldump")) AND !empty($checkDump)) ? true : false);
	}

	/**
	 * Performs a backup of the database and places the backup in a specific area on the server
	 * based on what the admins decide.
	 *
	 * @param string $sPath Full path to where to place the backup.
	 *
	 * @return string Full path to where the backup is located including the file name.
	 */
	public function backup($sPath)
	{
		if (!is_dir($sPath)) {
			return AIN_Error::set(_p('the_path_you_provided_is_not_a_valid_directory'));
		}

		if (!AIN_File::instance()->isWritable($sPath, true)) {
			return AIN_Error::set(_p('the_path_you_provided_is_not_a_valid_directory'));
		}

		$sPath = rtrim($sPath, AIN_DS) . AIN_DS;
		$sFileName = uniqid() . '.sql';
		$sZipName = 'sql-backup-' . date('Y-d-m', AIN_TIME) . '-' . uniqid() . '.tar.gz';

		shell_exec("mysqldump --skip-add-locks --disable-keys --skip-comments -h" . AIN::getParam(['db', 'host']) . " -u" . AIN::getParam(['db', 'user']) . " -p" . AIN::getParam(['db', 'pass']) . " " . AIN::getParam(['db', 'name']) . " > " . $sPath . $sFileName . "");
		chdir($sPath);
		shell_exec("tar -czf " . $sZipName . " " . $sFileName . "");
		chdir(AIN_DIR);
		unlink($sPath . $sFileName);

		return $sPath . $sZipName;
	}

	/**
	 * Close the SQL connection
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function close()
	{
		return @$this->_aCmd['mysql_close']($this->_hMaster);
	}


	/**
	 * Returns exactly one row as array. If there is number of rows
	 * satisfying the condition then the first one will be returned.
	 *
	 * @param string $sSql   select query
	 * @param string $bAssoc type of returned rows array
	 *
	 * @return array exact one row (first if multiply row selected): or false on error
	 */
	protected function _getRow($sSql, $bAssoc, &$hLink)
	{
		// Run the query
		$hRes = $this->query($sSql, $hLink);

		// Get the array
		$aRes = $this->_aCmd['mysql_fetch_array']($hRes, ($bAssoc ? MYSQL_ASSOC : MYSQL_NUM));

		return $aRes ? $aRes : [];
	}

	/**
	 * Gets data returned by sql query
	 *
	 * @param string $sSql   select query
	 * @param bool $bAssoc type of returned rows array
	 *
	 * @return array selected rows (each row is array of specified type) or empty array on error
	 */
	protected function _getRows($sSql, $bAssoc = true, &$hLink)
	{
		$aRows = [];
		$bAssoc = ($bAssoc ? MYSQL_ASSOC : MYSQL_NUM);

		// Run the query
		$this->rQuery = $this->query($sSql, $hLink);

		// Put it into a while look
		while ($aRow = $this->_aCmd['mysql_fetch_array']($this->rQuery, $bAssoc)) {
			// Create an array for the data
			$aRows[] = $aRow;
		}

		return $aRows; //empty array on error
	}

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
		if ($sPort) {
			$sHost = $sHost . ':' . $sPort;
		}

		if ($hLink = ($sPersistent ? @$this->_aCmd['mysql_pconnect']($sHost, $sUser, $sPass) : @$this->_aCmd['mysql_connect']($sHost, $sUser, $sPass))) {
			return $hLink;
		}

		return false;
	}

	/**
	 * Returns any SQL errors.
	 *
	 * @return string String of error message in case something failed.
	 */
	private function _sqlError()
	{
		return ($this->_aCmd['mysql_error'] == 'mysqli_error' ? @$this->_aCmd['mysql_error']($this->_hMaster) : @$this->_aCmd['mysql_error']());
	}

	/**
	 * Begin transaction
	 *
	 * @return mixed
	 */
	public function beginTransaction()
	{
		mysql_query("START TRANSACTION", $this->_hMaster);
	}

	/**
	 * Rollback a transaction
	 */
	public function rollback()
	{
		return mysql_query('ROLLBACK', $this->_hMaster);
	}

	/**
	 * Commit a transaction
	 */
	public function commit()
	{
		return mysql_query('COMMIT', $this->_hMaster);
	}

	/**
	 * @inheritdoc
	 */
	public function forUpdate()
	{
		$this->_aQuery['for_update'] = true;
		return $this;
	}
}
?>