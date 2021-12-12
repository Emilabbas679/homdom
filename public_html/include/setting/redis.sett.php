<?php 

$settings = array(
    'enabled' => true,
    'host' => '127.0.0.1',
    'port' => 6379,
    'database' => 1,
    //'password' => '2046244',
);

$multiple_servers = array(
    array(
       'host' => '148.251.153.47',
       'port' => 6379,
       'database' => 15,
       'alias' => 'first',
	   'password' => '2046244',
    ),
    array(
       'host' => '5.9.87.83',
       'port' => 6379,
       'database' => 15,
       'alias' => 'second',
	   'password' => '2046244',
    ),
);



?>