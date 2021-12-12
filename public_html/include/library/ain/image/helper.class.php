<?php

defined('AIN') or exit('NO DICE!');

class AIN_Image_Helper
{
	/**
	 * @return AIN_Image_Helper
	 */
	public static function instance() {
		return AIN::getLib('image.helper');
	}

	public function getNewSize($sImage = null, $iMaxHeight, $iMaxWidth, $iWidth = 0, $iHeight = 0)
	{
		if (is_array($sImage))
		{
			if(AIN::getParam('core.allow_cdn') && !AIN::getParam('core.keep_files_in_server') && isset($sImage[1]) && isset($sImage[2]))
			{
				$iWidth = $sImage[1];
				$iHeight = $sImage[2];
			}
			$sImage = $sImage[0];
		}
		else
		{
			if ($sImage !== null && (!file_exists($sImage) || filesize($sImage) < 1))
			{
				return array(0, 0);
			}
		}
			
	    if (!$iWidth && !$iHeight)
	    {
            if (file_exists($sImage)){
                list($iWidth, $iHeight) = getimagesize($sImage);
            } else {
                $iWidth = 0;
                $iHeight = 0;
            }
	    }
	    
	    $k = "";		
	    //get scaling factor
	    if ($iMaxWidth && $iMaxHeight && $iWidth && $iHeight)
	    {
	        $kX = $iMaxWidth / $iWidth;
	        $kY = $iMaxHeight / $iHeight;
	        $k = min($kX, $kY);
	    }
	    elseif ($iMaxHeight && $iHeight)
	    {
	        $k = $iMaxHeight / $iHeight;
	    }
	    elseif ($iMaxWidth && $iWidth)
	    {
	        $k = $iMaxWidth / $iWidth;
	    }
	
	    //correct scaling factor
	    if (((0 >= $k) || ($k > 1)))
	    {
	        $k = 1;
	    }
	
	    $iHeight *= $k;
	    $iWidth *= $k;	    

		if ($iHeight < 1)
		{
			$iHeight = 1;
		}
		if ($iWidth < 1)
		{
			$iWidth = 1;
		}
	    return array(round($iHeight), round($iWidth));
	}
	
	/**
	 * Displays an image on the site based on params passed
	 *
	 * @param array $aParams Holds an ARRAY of params about the image
	 * @return string Returns the HTML <image> or the full path to the image based on the params passed with the 1st argument
	 */
	public function display($aParams, $bIsLoop = false)
	{
		static $aImages = array();
		
		$aParams['fv'] = 4;
		//$aParams['date'] = date('Ymd');

		// Create hash for cache
		$sHash = md5(serialize($aParams));
		
		// Return cached image
		if (isset($aImages[$sHash]))
		{
			return $aImages[$sHash];
		}			
		
		/*
		if( isset($_GET['db']) )
			$sImage = AIN::getParam('video.url_pic').AIN::getLib('url')->encode($aParams).'/cdn.jpg';
		else		
		$sImage = '//baku.tv/file/video/pic/'.$aParams['file'];
		*/
	
		$sImage = AIN::getParam('video.url_pic').AIN::getLib('url')->encode($aParams).'/cdn.jpg';

		
		$aImages[$sHash] = $sImage;
		
		return $sImage;
	}

    /**
     * @param string $path
     * @param string $file
     * @param string $suffix
     *
     * @return bool
     */
    private function autoCreateThumbnail($module, $file, $suffix){
        if (empty($suffix)){
            return true;
        }
		

		$dirPath = AIN_DIR . AIN::getParam("video.url_pic") . sprintf($file, '');
		$originalDirFile = AIN_DIR . AIN::getParam("$module.pic") . sprintf($file, '');
		
		
		
		//$oImage = AIN_Image::instance();
		
		//$oImage->createThumbnail($originalDirFile, $dirPath, $size, $size);
		
		
		print_r($dirPath);
		
		
		
		
		die();
		
        return true;
    }
	
	/**
	 * Runs a check on two variables if they are equal, less then or greater then
	 *
	 * @param string $a Variable 1 to check against variable 2
	 * @param string $b Variable 2 to check against variable 1
	 * @return int Returns an INT based on the output
	 */
	private function _cmp($a, $b) 
	{
	    if ($a == $b) 
	    {
	        return 0;
	    }
	    return ($a < $b) ? -1 : 1;
	}	
}

?>
