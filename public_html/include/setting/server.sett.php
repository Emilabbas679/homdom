<?php

defined('AIN') or exit('NO DICE!');

$bIsHTTPS = false;

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    $bIsHTTPS= true;
} elseif (isset($_SERVER['SERVER_PORT']) and $_SERVER['SERVER_PORT'] == 443) {
    $bIsHTTPS = true;
} elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) and $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
    $bIsHTTPS = true;
} elseif (isset($_SERVER['HTTP_CF_VISITOR']) and strpos($_SERVER['HTTP_CF_VISITOR'], 'https')) {
    $bIsHTTPS = true;
}

$this->_aParams['db']['driver'] = 'DATABASE_DRIVER';
$this->_aParams['db']['host'] = 'localhost';


$this->_aParams['db']['prefix'] = 'ain_';
$this->_aParams['db']['port'] = '';

$this->_aParams['db']['slave'] = false;
$this->_aParams['db']['slave_servers'] = array();

$this->_aParams['balancer']['enabled'] = false;
$this->_aParams['balancer']['servers'] = array();



$this->_aParams['core']['host'] = $_SERVER['HTTP_HOST'];
$this->_aParams['core']['folder'] = '/';
$this->_aParams['core']['url_rewrite'] = '1';



$this->_aParams['admincp']['admin_cp'] = 'admincp';






//Template configure
$this->_aParams['core']['module_core'] = 'homdom';
$this->_aParams['core']['theme_folder_name'] = 'homdom.az';
$this->_aParams['core']['style_folder_name'] = 'default';
$this->_aParams['core']['admin_host'] = 'homdom.az';








//Global
/*
	Global Module olaraq hələlik
*/

$this->_aParams['core']['module_core'] = 'homdom';
$this->_aParams['core']['theme_folder_name'] = 'homdom';
$this->_aParams['core']['style_folder_name'] = 'default';

$this->_aParams['core']['cookie_path'] = '/';
$this->_aParams['core']['cookie_domain'] = '.homdom.az';




$this->_aParams['core']['display_required'] = false;




$this->_aParams['core']['cdn_service'] = 's3';
$this->_aParams['core']['amazon_access_key'] = 'AKIAJ4J6VYDUEEEHPXIQ';
$this->_aParams['core']['amazon_secret_key'] = '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';
$this->_aParams['core']['amazon_bucket'] = 'oxustatic';
$this->_aParams['core']['amazon_region'] = 'us-east-2';
$this->_aParams['core']['enable_amazon_expire_urls'] = false;




$this->_aParams['core']['cdn_service'] = 'ain';





//Core configure
$this->_aParams['core']['session_prefix'] = 'ain_';
$this->_aParams['core']['ip_check'] = 0;
$this->_aParams['core']['id_hash_salt'] = 'ain';

$this->_aParams['core']['force_secure_site'] = 0;
$this->_aParams['core']['use_custom_hash_salt'] = false;
$this->_aParams['core']['custom_hash_salt'] = 'ain';

$this->_aParams['core']['include_ip_sub_id_hash'] = 'ain';
$this->_aParams['core']['store_only_users_in_session'] = false;
$this->_aParams['core']['http'] = 'https://';
$this->_aParams['core']['https'] = 'http://';


$this->_aParams['core']['ajax_path'] = ($bIsHTTPS ? 'https' : 'http') . '://'. $this->_aParams['core']['host'] . $this->_aParams['core']['folder']."_ajax";
//$this->_aParams['core']['ajax_path'] = ($bIsHTTPS ? 'https' : 'http') . '://api.smartbee.az'."/_ajax";

$this->_aParams['core']['path'] = ($bIsHTTPS ? 'https' : 'http') . '://'. $this->_aParams['core']['host'] . $this->_aParams['core']['folder'];
$this->_aParams['core']['path_file'] = ($bIsHTTPS ? 'https' : 'http') . '://' . $this->_aParams['core']['host'] . $this->_aParams['core']['folder'];


/* /file/ directories */
$this->_aParams['core']['dir_file'] = AIN_DIR . 'file' . AIN_DS;
$this->_aParams['core']['url_file'] = $this->_aParams['core']['path_file'] . 'file/';
$this->_aParams['core']['dir_cache'] = $this->_aParams['core']['dir_file'] . 'cache' . AIN_DS;
$this->_aParams['core']['url_module'] = $this->_aParams['core']['path'] . 'module/';

/* /file/ directories */
$this->_aParams['core']['dir_pic'] = $this->_aParams['core']['dir_file'] . 'pic' . AIN_DS;
$this->_aParams['core']['url_pic'] = $this->_aParams['core']['url_file'] . 'pic/';
$this->_aParams['core']['build_file_dir'] = true;
$this->_aParams['core']['build_format'] = '';
$this->_aParams['core']['disable_ie_warning'] = true;

$this->_aParams['core']['salt'] = 'default';

$this->_aParams['core']['use_gzip'] = false;
$this->_aParams['core']['gzip_level'] = 9;
$this->_aParams['core']['gzip_encodings'] = array( 'x-gzip' );

$this->_aParams['core']['cache_skip'] = false;

$this->_aParams['core']['cache_add_salt'] = false;
$this->_aParams['core']['cache_suffix'] = '.cache.php';

$this->_aParams['core']['allow_cdn'] = false;
$this->_aParams['core']['cache_storage'] = 'file';
$this->_aParams['core']['force_https_secure_pages'] = 'file';

$this->_aParams['core']['method'] = 'smtp';
$this->_aParams['core']['email_from_email'] = 'no-reply@beemail.az';
$this->_aParams['core']['mail_smtp_username'] = 'no-reply@beemail.az';
$this->_aParams['core']['mail_smtp_password'] = 'q0sjs7ByPDYFsEmh';
$this->_aParams['core']['mailsmtphost'] = 'mail.beemail.az';
$this->_aParams['core']['mail_smtp_port'] = 465;

$this->_aParams['core']['mail_from_name'] = 'Adsgarden.com';
$this->_aParams['core']['site_title'] = 'SmartBee Reklam platforması';
$this->_aParams['core']['mail_smtp_authentication'] = true;

$this->_aParams['core']['super_cache_system'] = false;
$this->_aParams['core']['conver_time_to_string'] = 'd F Y';
$this->_aParams['core']['global_update_time'] = 'F j, Y H:i';
$this->_aParams['core']['default_time_zone_offset'] = '0';

$this->_aParams['core']['title_delim'] = '&raquo;';
$this->_aParams['core']['include_site_title_all_pages'] = true;
$this->_aParams['core']['global_site_title'] = 'homdom.az';



$this->_aParams['user']['verify_email_timeout'] = 120;
$this->_aParams['user']['max_length_for_username'] = 5;
$this->_aParams['user']['min_length_for_username'] = 5;
$this->_aParams['user']['active_session'] = 10;

$this->_aParams['language']['no_string_restriction'] = 5;

$this->_aParams['articles']['allowed_extensions'] = array("gif", "jpg", "png", "jpe", "jpeg" );

$this->_aParams['core']['pic_path'] = ($bIsHTTPS ? 'https' : 'http') .'://cdn.homdom.az/';

$bIsJSON= false;

if (isset($_SERVER['HTTP_ACCEPT']) && $_SERVER['HTTP_ACCEPT'] == 'application/json') {
    $bIsJSON= true;
}
$this->_aParams['core']['json'] = $bIsJSON;

$this->_aParams['apanel']['cdn_url'] = "//cdn.homdom.az/";

$this->_aParams['adnetwork']['unit_cost_max'] = 0.2;
$this->_aParams['adnetwork']['unit_cost_min'] = 0.2;

$this->_aParams['adnetwork']['currency_id'] = array('AZN', 'EUR');
$this->_aParams['adnetwork']['gender'] = array( 1 => 'Kişi', 2 => 'Qadın');

$this->_aParams['adnetwork']['bank_of_baku'] = array(
    'openKey' => 'UIuvhP5csJ2q1jKM192JwE95D5Uwam',
    'privateKey' => 'OVV8g3Oc56LYmD7XfZW8ziDye7tYuu',
    'payUrl' => 'https://epos.az/api/pay2me/pay/?',
    'statusUrl' => 'https://epos.az/api/pay2me/status/?',
);

$this->_aParams['adnetwork']['channel_id'] = 0;
$this->_aParams['adnetwork']['ssp_id'] = 0;
$this->_aParams['adnetwork']['site_url'] = 'https://homdom.az';



$this->_aParams['core']['admin_host'] = 'admin.homdom.az';

if($this->_aParams['core']['host'] == 'admin.homdom.az')
{
    $this->_aParams['core']['module_core'] = 'admincp';
    $this->_aParams['core']['theme_folder_name'] = 'admincp';
    $this->_aParams['core']['style_folder_name'] = 'default';
}
