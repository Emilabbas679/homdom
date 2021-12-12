<?php

defined('AIN') or exit('NO DICE!');

class apanel_service_func_price extends AIN_Service {

	private $get_static_status = array();
	
	
	public function __construct()
	{	
		
	}
	public function convert( $amount, $dd = 2 )
	{
		return number_format( (double) $amount, $dd);
	}
	


}

?>
