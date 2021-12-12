<?php
ob_start();

define('AIN', true);

define('AIN_DEBUG', true);

define('AIN_DS', DIRECTORY_SEPARATOR);

define('AIN_DIR', dirname(__FILE__) . AIN_DS);

define('AIN_START_TIME', array_sum(explode(' ', microtime())));

require_once(AIN_DIR . 'include' . AIN_DS . 'init.inc.php');

require_once(AIN_DIR . 'include' . AIN_DS . 'library'. AIN_DS . 'upload' . AIN_DS . 'class.upload.php');

$size = isset($_GET['size']) ? $_GET['size'] : 'orginal';
$file = isset($_GET['file']) ? $_GET['file'] : '';	



function get_image_mime_type($image_path)
{
	$mimes  = array(
		IMAGETYPE_GIF => "image/gif",
		IMAGETYPE_JPEG => "image/jpg",
		IMAGETYPE_PNG => "image/png",
		IMAGETYPE_SWF => "image/swf",
		IMAGETYPE_PSD => "image/psd",
		IMAGETYPE_BMP => "image/bmp",
		IMAGETYPE_TIFF_II => "image/tiff",
		IMAGETYPE_TIFF_MM => "image/tiff",
		IMAGETYPE_JPC => "image/jpc",
		IMAGETYPE_JP2 => "image/jp2",
		IMAGETYPE_JPX => "image/jpx",
		IMAGETYPE_JB2 => "image/jb2",
		IMAGETYPE_SWC => "image/swc",
		IMAGETYPE_IFF => "image/iff",
		IMAGETYPE_WBMP => "image/wbmp",
		IMAGETYPE_XBM => "image/xbm",
		IMAGETYPE_ICO => "image/ico");

	if (($image_type = exif_imagetype($image_path))
		&& (array_key_exists($image_type ,$mimes)))
	{
		return $mimes[$image_type];
	}
	else
	{
		return FALSE;
	}
}
function getDataURI($url) {
	return 'data:' . get_image_mime_type($url) . ';base64,' . base64_encode(file_get_contents($url));
}

function cache_file() {
	global $file;
	$cache_key = $file;
	$cache_key = str_replace('/','_',$cache_key);		
	$cache_dir = AIN_DIR.'/file/cache/image/';		
	if( !is_dir($cache_dir) )
	{
		mkdir($cache_dir);
		chmod($cache_dir, 0777); 
	}			
	
	$date_dir = date('Ym');
	$cache_dir = $cache_dir . '/' . $date_dir;
	
	if( !is_dir($cache_dir) )
	{
		mkdir($cache_dir);
		chmod($cache_dir, 0777); 
	}	
	
	$date_dir = $_GET['size'];
	$cache_dir = $cache_dir . '/' . $date_dir;
	
	if( !is_dir($cache_dir) )
	{
		mkdir($cache_dir);
		chmod($cache_dir, 0777); 
	}	
			
	return $cache_dir . '/' . $cache_key;
}
if( is_file( $cache_file = cache_file() ) ) {
	header('Content-type: image/jpeg');
	readfile( $cache_file );
	exit;
}
ob_start( 'cache_output' );

function cache_output( $content ) {
	file_put_contents( cache_file(), $content );
	return $content;
}	



$handle = new \Verot\Upload\Upload("data:".getDataURI("http://cdn.homdom.az/{$file}")); 
if( $size  == 'orginal' )
{
	
}
elseif( stripos($size, 'x') )
{
	$handle->image_resize         = true;
	$size = explode('x', $size);
	$handle->image_x              = $size[0];
	$handle->image_y              = $size[1];
	$handle->image_ratio_crop     = true;
	$handle->image_opacity        = 100;		
}	
else
{
	$handle->image_resize         = true;
	$handle->image_max_width      = $size;
	$handle->image_ratio_crop     = true;
	$handle->image_opacity        = 100;		
}
header('Content-type: ' . $handle->file_src_mime);
echo $handle->process();
ob_end_flush();
?>
