<?php

defined('AIN') or exit('NO DICE!');

class apanel_service_func_static extends AIN_Service {

	private $get_static_status = array();


	public function __construct()
	{
		$get_static = AIN::getService('video')->get_static( );
		if($get_static['status'] == 'success' )
		{
			foreach($get_static['data'] as $key => $row )
			{
				$this->get_static_data[$row['id']] = $row['name'];

			}
		}
	}
	public function get()
	{
		return $this->get_static_data;
	}


	public function get_static($where)
	{
		$get_static = AIN::getService('video')->get_static( $where );
		if($get_static['status'] == 'success' )
		{
			return $get_static['data'];
		}
		return array();
	}
	public function get_static_dimension($where)
	{
		$get_static_dimension = AIN::getService('video')->get_static_dimension( $where );
		if($get_static_dimension['status'] == 'success' )
		{
			return $get_static_dimension['data'];
		}
		return array();
	}


	private $_size = array(

		1 => array(
			3, // 728 x 90
			4, // 336 x 280
			5, // 320 x 100
			17, // 160 x 600
			7, // 300 x 250
			16, // 240 x 400
			22, // 250 x 250
			18, // 120 x 600


		),

		2 => array(
			3, // 728 x 90
			5, // 320 x 100
			8, // 980 x 120
			9, // 970 x 250
			10, // 970 x 90
			11, // 930 x 180
			12, // 468 x 60
			13, // 320 x 50
			31, // 300 x 50
			14, // 234 x 60
			6, // 300 x 600
		),

		3 => array(
			6, // 300 x 600
			15, // 300 x 1050
			16, // 240 x 400
			17, // 160 x 600
			18, // 120 x 600
			19, // 120 x 240
		),

		4 => array(
			4, // 336 x 280
			7, // 300 x 250
			20, // 580 x 400
			21, // 250 x 360
			22, // 250 x 250
			23, // 200 x 200
			24, // 180 x 150
			25, // 125 x 125
			33, // 230x345
			34, // 590x400
		),

		5 => array(
			30, // Responsive
		),

		6 => array(
			7, // 300 x 250
			5, // 320 x 100
			13, // 320 x 50
			22, // 250 x 250
		),

	);
	function getShowingSize($showing = null)
	{
		return isset( $this->_size[$showing] ) ? $this->_size[$showing] : $this->_size;
	}





}

?>
