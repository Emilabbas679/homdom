<?php

defined('AIN') or exit('NO DICE!');

class homdom_service_cron extends AIN_Service
{
    public function __construct()
    {


    }
	public function index()
	{
		AIN::getService('homdom.helpers')->index( ['nocache' => true ] );
	}
    public function __call($method, $args)
    {
        return $this->send($method, $args[0] ?? []);
    }
}
