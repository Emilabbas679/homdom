<?php


defined('AIN') or exit('NO DICE!');

$this->_aDefaults = array(
	'username' => array(
		'pattern' => '/^[a-zA-Z0-9\- ]{' . AIN::getParam('user.min_length_for_username') . ',' . AIN::getParam('user.max_length_for_username') . '}$/',
		'title' => (defined('AIN_INSTALLER') ? '' : AIN::getPhrase('user.provide_a_valid_user_name', array('min' => AIN::getParam('user.min_length_for_username'), 'max' => AIN::getParam('user.max_length_for_username'))))
		
	),
    'email' => array(
        'pattern' => '/^[0-9a-zA-Z]([\-+.\w]*[0-9a-zA-Z]?)*@([0-9a-zA-Z\-.\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,}$/',
        'maxlen' => 100,
        'title' => (defined('AIN_INSTALLER') ? '' : AIN::getPhrase('user.provide_a_valid_email_address'))
    ),    
    'password' => array(
    	'minlen' => 4,
    	'maxlen' => 30,
    	'title' => (defined('AIN_INSTALLER') ? '' : AIN::getPhrase('user.not_a_valid_password'))
    ),
    'url' => array(
       'pattern' => '/^(?:(ftp|http|https):)?(?:\/\/(?:((?:%[0-9a-f]{2}|[\-a-z0-9_.!~*\'\(\);:&=\+\$,])+)@)?(?:((?:[a-z0-9](?:[\-a-z0-9]*[a-z0-9])?\.)*[a-z](?:[\-a-z0-9]*[a-z0-9])?)|([0-9]{1,3}(?:\.[0-9]{1,3}){3}))(?::([0-9]*))?)?((?:\/(?:%[0-9a-f]{2}|[\-a-z0-9_.!~*\'\(\):@&=\+\$,;])+)+)?\/?(?:\?.*)?$/i',
       'maxlen'=> 255,
       'minlen'=> 11,
       'title' => (defined('AIN_INSTALLER') ? '' : AIN::getPhrase('core.invalid_url'))
    ),
	'int' => array(
       'pattern' => '/^[0-9]$/',
       'title' => (defined('AIN_INSTALLER') ? '' : AIN::getPhrase('core.provide_a_numerical_value'))
    ),
    'money' => array(
        'pattern'=>'/[0-9.,]$/',
        'title' => (defined('AIN_INSTALLER') ? '' : AIN::getPhrase('core.provide_a_valid_price'))
    ),
    'year' => array(
    	'pattern' => '/^[0-9]{4}$/',
    	'title' => (defined('AIN_INSTALLER') ? '' : AIN::getPhrase('core.provide_a_valid_year_eg_1982'))
    ),
    'zip'  => array(
        'pattern'=>'/^[a-zA-Z\d\-\s]{0,20}$/'
    )
);

?>
