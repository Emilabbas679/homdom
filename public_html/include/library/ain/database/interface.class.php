<?php
/**
 * [AIN_HEADER]
 */

defined('AIN') or exit('NO DICE!');

interface AIN_Database_Interface
{
    public function connect($sHost, $sUser, $sPass, $sName, $sPort = false, $sPersistent = false);

    public function getVersion();

    public function getServerInfo();

    public function query($sSql, &$hLink = '');

    public function beginTransaction();

    public function rollback();

    public function commit();

    public function forUpdate();

    public function addIndex($sTable, $sField, $sName = null);

    public function dropIndex($sTable, $sName = null);

    public function dropField($sTable, $sField);

    public function addField($aParams);

    public function changeField($sTable, $sField, $aParams);

    public function addPrimaryKey($sTable, $sField);

    public function truncateTable($sTable);

    public function dropTable($sTable);

    public function getColumns($sTable);
}