<?php

defined('AIN') or exit('NO DICE!');

class AIN_Service
{	
	/**
	 * Holds the default database table we are working with in this service.
	 *
	 * @var string
	 */
	protected $_sTable;
	    
	/**
	 * Extends the database object.
	 *
	 * @see AIN_Database
	 * @return object
	 */
    protected function database()
    {
    	return AIN::getLib('database');
    }    
    /**
     * Extends the cache object
     *
     * @see AIN_Cache
     * @return object
     */
    protected function cache()
    {
    	return AIN::getLib('cache');
    }    
    /**
     * Extends the pre-parsing object.
     *
     * @see AIN_Parse_Input
     * @return object
     */
    protected function preParse()
    {
    	return AIN::getLib('parse.input');
    }    
    /**
     * Extends the validation/sanity check object.
     *
     * @see AIN_Validator
     * @return object
     */
    protected function validator()
    {
    	return AIN::getLib('validator');
    }    
    /**
     * Extends the search check object.
     *
     * @see AIN_Search
     * @return object
     */    
    protected function search()
    {
    	return AIN::getLib('search');
    }    
	/**
	 * Extends the request class and returns its class object.
	 *
	 * @see AIN_Request
	 * @return object
	 */
	protected function request()
	{
		return AIN::getLib('request');	
	}	    
}

?>