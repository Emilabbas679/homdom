<?php

defined('AIN') or exit('NO DICE!');

class AIN_Image_Library_Gd extends AIN_Image_Abstract
{	

	public $thumbLargeThenPic = false;

	private $_hImg;	
	
	public function __construct()
	{	
	
	}
	public function cropImage($sImage, $sDestination, $iWidth, $iHeight, $iStartWidth, $iStartHeight, $iScale)
	{
		if (!$this->_load($sImage))
		{
			return false;
		}		
		
		$iScale = ($iScale / $iWidth);
		
		$iNewImageWidth = ceil($iWidth * $iScale);
		$iNewImageHeight = ceil($iHeight * $iScale);
		
        switch ($this->_aInfo[2])
        {
            case 1:
                $hFrm = @imageCreateFromGif($this->sPath);
                break;
            case 3:
                $hFrm = @imageCreateFromPng($this->sPath);
                break;
            default:
                $hFrm = @imageCreateFromJpeg($this->sPath);               
				break;
        }		
		
		$hTo = imagecreatetruecolor($iNewImageWidth, $iNewImageHeight);
		
		switch($this->sType)
		{
			case 'gif':
				$iBlack = imagecolorallocate($hTo, 0, 0, 0);
				imagecolortransparent($hTo, $iBlack);
				break;		
			case 'jpeg':
			case 'jpg':
			case 'jpe':
				imagealphablending($hTo, true);
			break;			
			case 'png':
				imagealphablending($hTo, false);
				imagesavealpha($hTo, true);
			break;
		}			
		
		imageCopyResampled($hTo, $hFrm, 0, 0, $iStartWidth, $iStartHeight, $iNewImageWidth, $iNewImageHeight, $iWidth, $iHeight);	
		
		switch ($this->sType)
        {
        	case 'gif':
	            if(!$hTo)
	            {
	            	@copy($this->sPath, $sDestination);
	            }
	            else
	            {
					@imagegif($hTo, $sDestination);
				}
			break;
            case 'png':
            	@imagepng($hTo, $sDestination);
				imagealphablending($hTo, false);
				imagesavealpha($hTo, true);               	
			break;
            default:
            	@imagejpeg($hTo, $sDestination);
            	break;
		}		
		
		@imageDestroy($hTo);		
        @imageDestroy($hFrm);
        
		if (AIN::getParam('core.allow_cdn'))
		{
			AIN::getLib('cdn')->put($sDestination);
		}        
	}

	public function createThumbnail($sImage, $sDestination, $nMaxW, $nMaxH, $bRatio = true, $bSkipCdn = false)
	{	
		if (!$this->_load($sImage))
		{
			return false;
		}

		if (defined('AIN_IS_HOSTED_SCRIPT'))
		{
			$sImage = str_replace(AIN_DIR, rtrim(AIN::getParam('core.rackspace_url'), '/') . '/', $sImage);
		}
		
		if ($bRatio)
		{
			list($nNewW, $nNewH) = $this->_calcSize($nMaxW, $nMaxH);	
		}
		else 
		{
			return $this->createSquareThumbnail($sImage, $sDestination, $nMaxW, $nMaxH, $bSkipCdn);	
		}
		
		if ($this->nW < $nNewW ||  $this->nH < $nNewH || ($this->nW == $nNewW && $this->nH == $nNewH))
		{
			@copy($this->sPath, $sDestination);
			
			if (AIN::getParam('core.allow_cdn'))
			{
				if (($bSkipCdn === true && $nNewW > 150 || $bSkipCdn === 'force_skip'))
				{
					
				}
				else 
				{
					AIN::getLib('cdn')->put($sDestination);
				}
			}			
			
			return true;	
		}
		
		// if (function_exists('memory_get_usage') && ($sMemoryLimit = @ini_get('memory_limit')) && $sMemoryLimit != -1)
		if (!AIN_SAFE_MODE)
		{
			@ini_set('memory_limit', '500M');
		}		
		
        switch ($this->_aInfo[2])
        {
            case 1:
                $hFrm = imageCreateFromGif($this->sPath);
                break;
            case 3:
                $hFrm = imageCreateFromPng($this->sPath);
                break;
            default:				
                $hFrm = imageCreateFromJpeg($this->sPath);               
				break;
        }
        
        if ((int) $nNewH === 0)
        {
        	$nNewH = 1;
        }
        
        if ((int) $nNewW === 0)
        {
        	$nNewW = 1;
        }

		$hTo = imagecreatetruecolor($nNewW, $nNewH);
		
		switch($this->sType)
		{
			case 'gif':
				$iBlack = imagecolorallocate($hTo, 0, 0, 0);
				imagecolortransparent($hTo, $iBlack);
				break;			
			case 'jpeg':
			case 'jpg':
			case 'jpe':
				imagealphablending($hTo, true);
			break;			
			case 'png':
				imagealphablending($hTo, false);
				imagesavealpha($hTo, true);
			break;
		}		

		if ($this->thumbLargeThenPic === false && $this->nH <= $nNewH && $this->nW <= $nNewW)
		{
			$hTo = $hFrm;
		}
		else
		{
			if($hFrm)
			{
				imageCopyResampled($hTo, $hFrm, 0, 0, 0, 0, $nNewW, $nNewH, $this->nW, $this->nH);				
			}
		}
		switch ($this->sType)
        {
        	case 'gif':
	            if(!$hTo)
	            {
	            	@copy($this->sPath, $sDestination);
	            }
	            else
	            {
					@imagegif($hTo, $sDestination);
				}
			break;
            case 'png':
            	imagepng($hTo, $sDestination);
				imagealphablending($hTo, false);
				imagesavealpha($hTo, true);
			break;
            default:
            	@imagejpeg($hTo, $sDestination);
            	break;
		}		
		
		@imageDestroy($hTo);		
        @imageDestroy($hFrm);

		if (($this->sType == 'jpg' || $this->sType == 'jpeg') && function_exists('exif_read_data'))
		{
			@getimagesize($sImage, $aInfo);
			if(isset($aInfo['APP1']) && preg_match('/exif/i', $aInfo['APP1']))
			{
				$exif = @exif_read_data($sImage);
				if(!empty($exif['Orientation']))
				{
					switch($exif['Orientation'])
					{
						case 1:
						case 2:
							break;
						case 3:
						case 4:
							// 90 degrees
							$this->rotate($sDestination, 'right');
							// 180 degrees
							$this->rotate($sDestination, 'right');
							break;
						case 5:
						case 6:
							// 90 degrees right
							$this->rotate($sDestination, 'right');
							break;
						case 7:
						case 8:
							// 90 degrees left
							$this->rotate($sDestination, 'left');
							break;
						default:
							break;
					}
				}
			}
		}
		
        
		if (AIN::getParam('core.allow_cdn'))
		{
			if (($bSkipCdn === true && $nNewW > 150 || $bSkipCdn === 'force_skip'))
			{
	
			}
			else 
			{
				AIN::getLib('cdn')->put($sDestination);
			}
		}
	}
	
	public function createSquareThumbnail($sSrc, $sDestination, $iNewWIdth = 0, $iNewHeight = 0, $bSkipCdn = false, $iZoom = 1, $iQuality = 100)
	{				
		if (defined('AIN_IS_HOSTED_SCRIPT'))
		{
			$sSrc = str_replace(AIN_DIR, rtrim(AIN::getParam('core.rackspace_url'), '/') . '/', $sSrc);
		}
		
		if ($iNewWIdth == 0 && $iNewHeight == 0) 
		{
		    $iNewWIdth = 100;
		    $iNewHeight = 100;
		}
		
		switch ($this->sType) 
		{
			case 'jpg':
				$hImage = imagecreatefromjpeg($sSrc);
				break;	
			case 'png':
				$hImage = imagecreatefrompng($sSrc);
				break;	
			case 'gif':
				$hImage = imagecreatefromgif($sSrc);
				break;
		}
		
	    $iWidth = imagesx($hImage);
	    $iHeight = imagesy($hImage);
		$origin_x = 0;
		$origin_y = 0;
	
	    if ($iNewWIdth && !$iNewHeight) 
	    {
	        $iNewHeight = floor ($iHeight * ($iNewWIdth / $iWidth));
	    } 
	    elseif ($iNewHeight && !$iNewWIdth) 
	    {
	        $iNewWIdth = floor ($iWidth * ($iNewHeight / $iHeight));
	    }
	
		if ($iZoom == 3) 
		{	
			$final_height = $iHeight * ($iNewWIdth / $iWidth);
	
			if ($final_height > $iNewHeight) 
			{
				$iNewWIdth = $iWidth * ($iNewHeight / $iHeight);
			} 
			else 
			{
				$iNewHeight = $final_height;
			}
		}
	
		$hNewImage = imagecreatetruecolor($iNewWIdth, $iNewHeight);
		imagealphablending($hNewImage, false);
	
		$color = imagecolorallocatealpha($hNewImage, 0, 0, 0, 127);
	
		imagefill($hNewImage, 0, 0, $color);
	
		if ($iZoom == 2) 
		{	
			$final_height = $iHeight * ($iNewWIdth / $iWidth);
			
			if ($final_height > $iNewHeight) 
			{				
				$origin_x = $iNewWIdth / 2;
				$iNewWIdth = $iWidth * ($iNewHeight / $iHeight);
				$origin_x = round($origin_x - ($iNewWIdth / 2));	
			} 
			else 
			{	
				$origin_y = $iNewHeight / 2;
				$iNewHeight = $final_height;
				$origin_y = round($origin_y - ($iNewHeight / 2));
			}	
		}
	
		imagesavealpha($hNewImage, true);
	
		if ($iZoom > 0) 
		{	
			$sSrc_x = $sSrc_y = 0;
			$sSrc_w = $iWidth;
			$sSrc_h = $iHeight;
	
			$cmp_x = $iWidth / $iNewWIdth;
			$cmp_y = $iHeight / $iNewHeight;
	
			if ($cmp_x > $cmp_y) 
			{	
				$sSrc_w = round($iWidth / $cmp_x * $cmp_y);
				$sSrc_x = round(($iWidth - ($iWidth / $cmp_x * $cmp_y)) / 2);
	
			} 
			elseif ($cmp_y > $cmp_x) 
			{	
				$sSrc_h = round($iHeight / $cmp_y * $cmp_x);
				$sSrc_y = round(($iHeight - ($iHeight / $cmp_y * $cmp_x)) / 2);	
			}	
	
			imagecopyresampled($hNewImage, $hImage, $origin_x, $origin_y, $sSrc_x, $sSrc_y, $iNewWIdth, $iNewHeight, $sSrc_w, $sSrc_h);
	
	    } 
	    else 
	    {	
	        imagecopyresampled($hNewImage, $hImage, 0, 0, 0, 0, $iNewWIdth, $iNewHeight, $iWidth, $iHeight);	
	    }		
	    if (file_exists($sDestination))
		{
			if (@unlink($sDestination) != true)
			{
				@rename($sDestination, $sDestination . '_' . rand(10,99));
			}
		}

		switch ($this->sType)
        {
        	case 'gif':
	            if(!$hNewImage)
	            {
	            	@copy($this->sPath, $sDestination);
	            }
	            else
	            {
					@imagegif($hNewImage, $sDestination);
				}
			break;
            case 'png':
            	imagepng($hNewImage, $sDestination);
				imagealphablending($hNewImage, false);
				imagesavealpha($hNewImage, true);
			break;
            default:
            	@imagejpeg($hNewImage, $sDestination);
            	break;
		}
		
		if (($this->sType == 'jpg' || $this->sType == 'jpeg') && function_exists('exif_read_data'))
		{
			$exif = exif_read_data($sSrc);//d($exif);die();
			if(!empty($exif['Orientation']))
			{
				switch($exif['Orientation'])
				{
					case 1:
					case 2:
						break;
					case 3:
					case 4:
						// 90 degrees
						$this->rotate($sDestination, 'right');
						// 180 degrees
						$this->rotate($sDestination, 'right');
						break;
					case 5:
					case 6:
						// 90 degrees right
						$this->rotate($sDestination, 'right');
						break;
					case 7:
					case 8:
						// 90 degrees left
						$this->rotate($sDestination, 'left');
						break;
					default:
						break;
				}
			}
		}
		
		@imageDestroy($hNewImage);		
        @imageDestroy($hImage);		    
        
		if (AIN::getParam('core.allow_cdn'))
		{
			if (($bSkipCdn === true && $iNewWIdth > 150 || $bSkipCdn === 'force_skip'))
			{
	
			}
			else 
			{
				AIN::getLib('cdn')->put($sDestination);
			}
		}        
	}			
	public function rotate($sImage, $sCmd, $sActualFile = null)
	{
		if (!$this->_load($sImage))
		{
			return false;
		}	        

		switch ($this->_aInfo[2])
        {
            case 1:
                $hFrm = @imageCreateFromGif($this->sPath);
                break;
            case 3:
                $hFrm = @imageCreateFromPng($this->sPath);
                break;
            default:
                $hFrm = @imageCreateFromJpeg($this->sPath);               
				break;
        }		

		if (substr($this->sPath, 0, 7) != 'http://')
		{
        	@unlink($this->sPath);
		}
        
		if (function_exists('imagerotate'))
		{
			if ($sCmd == 'left')
			{
				$im2 = imagerotate($hFrm, 90,0);
			}
			else
			{
				$im2 = imagerotate($hFrm, 270,0);
			}
		}
		else
		{
			$wid = imagesx($hFrm);
			$hei = imagesy($hFrm);
			$im2 = imagecreatetruecolor($hei,$wid);

			switch($this->sType)
			{		
				case 'jpeg':
				case 'jpg':
				case 'jpe':
					imagealphablending($im2, true);
					break;			
				case 'png':
					//imagealphablending($im2, false);
					//imagesavealpha($im2, true);
			break;
			}			 

			for($i = 0;$i < $wid; $i++)
			{
				for($j = 0;$j < $hei; $j++)
				{
					$ref = imagecolorat($hFrm,$i,$j);
					if ($sCmd == 'right')
					{
						imagesetpixel($im2,($hei - 1) - $j,$i,$ref);
					}
					else 
					{
						imagesetpixel($im2,$j, $wid - $i,$ref);
					}
				}
			}
		}
		
		switch ($this->sType)
        {
        	case 'gif':
	            @imagegif($im2, $this->sPath);
			break;
            case 'png':
            	imagealphablending($im2, false);
            	imagesavealpha($im2, true);
            	@imagepng($im2, $this->sPath);				            	
			break;
            default:
            	@imagejpeg($im2, $this->sPath);
            	break;
		}       
		
		imagedestroy($hFrm); 
		imagedestroy($im2);

		if (AIN::getParam('core.allow_cdn'))
		{
			AIN::getLib('cdn')->put($this->sPath, $sActualFile);
		}		
	}
	public function addMark($sImage)
	{
		return (AIN::getParam('core.watermark_option') == 'none' ? false : (AIN::getParam('core.watermark_option') == 'image' ? $this->addWatermark($sImage) : $this->addText($sImage)));
	}
	public function addText($sImage)
	{
		if (!$this->_load($sImage))
		{
			return false;
		}
		
		if ($this->nW <= 150)
		{
			return false;
		}
		
        switch ($this->_aInfo[2])
        {
            case 1:
                $hImg = imagecreatefromgif($this->sPath);
                break;
            case 3:
                $hImg = imagecreatefrompng($this->sPath);
                break;
            default:
                $hImg = imagecreatefromjpeg($this->sPath);               
				break;
        }
        
        $sTextColor = AIN::getParam('core.image_text_hex');
        $sText = AIN::getParam('core.image_text');
 		$iFontSize = imagefontwidth(3);	 	
	 	$aLines = explode("\n", $sText);
	 	
	 	$sPosition = AIN::getParam('core.watermark_image_position');
	 	switch ($sPosition)
	 	{
	 		case 'top_left':	 			
				$iLocateX = 6;
	 			$iLocateY = ($iFontSize * count($aLines)) - 8;
	 			break;
	 		case 'top_right':
				$iLocateX = $this->nW - ($iFontSize * strlen($sText)) - 6;
	 			$iLocateY = 0;
	 			break;	 			
	 		case 'bottom_left':
				$iLocateX = 6;
	 			$iLocateY = $this->nH - ($iFontSize * count($aLines)) - 8;
	 			break;
	 		default:
				$iLocateX = $this->nW - ($iFontSize * strlen($sText)) - 6;
	 			$iLocateY = $this->nH - ($iFontSize * count($aLines)) - 8;
	 			break;
	 	}	 	

        list($iRed, $iBlue, $iGreen) = $this->_hex2RGB($sTextColor);
        
        $sTextColor = imagecolorallocate($hImg, $iRed, $iGreen, $iBlue);
        
        imagestring($hImg, 3, $iLocateX, $iLocateY, $sText, $sTextColor);
        
		switch ($this->sType)
        {
        	case 'gif':
	            @imagegif($hImg, $this->sPath);
			break;
            case 'png':
				@imagealphablending($hImg, false);
				@imagesavealpha($hImg, true);            	
            	@imagepng($hImg, $this->sPath);
			break;
            default:
            	@imagejpeg($hImg, $this->sPath);
            	break;
		}
        
        imagedestroy($hImg);	
        
		if (AIN::getParam('core.allow_cdn'))
		{
			AIN::getLib('cdn')->put($this->sPath);
		}	        	
		
		return true;
	}
	public function addWatermark($sImage)
	{
		$sPath = AIN::getParam('core.dir_watermark') . sprintf(AIN::getParam('core.watermark_image'), '');
		if(AIN::getParam('core.allow_cdn'))
		{
			$sPath = AIN::getLib('cdn')->getUrl(str_replace(AIN_DIR, '', $sPath));
		}
		
		$sType = strtolower(pathinfo(basename($sPath), PATHINFO_EXTENSION));
		
		if (!$this->_load($sImage))
		{
			return false;
		}		
		
		$iOpacity = AIN::getParam('core.watermark_opacity');
		$aImgInfo = @getimagesize($sPath);
		
		// http://www.AIN.com/tracker/view/14952/
		$iWatermarkImageSize = 0;
		$bHorizontal = true;
		$iOriginalImageSize = 0;
		// Watermark is rectangular? Get the small side
		if($aImgInfo[0] <= $aImgInfo[1])
		{
			$iWatermarkImageSize = $aImgInfo[0];
		}
		else
		{
			$iWatermarkImageSize = $aImgInfo[1];
			$bHorizontal = false;
		}
		// Original image is rectangular? Get the larger side
		if($this->nW >= $this->nH)
		{
			$iOriginalImageSize = $this->nW;
		}
		else
		{
			$iOriginalImageSize = $this->nH;
		}
		// END

		$iResizeWatermarkW = null;
		$iResizeWatermarkH = null;
		$iResizeWatermark = null;
		if ($iOriginalImageSize <= 20)
		{
			return false;
		}
		elseif ($iOriginalImageSize <= 75 && $iWatermarkImageSize > 10)
		{
			if($bHorizontal)
			{
				$iResizeWatermarkW = 10;
				$iResizeWatermarkH = round(($aImgInfo[1] * $iResizeWatermarkW)/$aImgInfo[0]);
			}
			else
			{
				$iResizeWatermarkH = 10;
				$iResizeWatermarkW = round(($aImgInfo[0] * $iResizeWatermarkH)/$aImgInfo[1]);
			}
			$iResizeWatermark = 10;
		}			
		elseif ($iOriginalImageSize <= 100 && $iWatermarkImageSize > 15)
		{
			if($bHorizontal)
			{
				$iResizeWatermarkW = 15;
				$iResizeWatermarkH = round(($aImgInfo[1] * $iResizeWatermarkW)/$aImgInfo[0]);
			}
			else
			{
				$iResizeWatermarkH = 15;
				$iResizeWatermarkW = round(($aImgInfo[0] * $iResizeWatermarkH)/$aImgInfo[1]);
			}
			$iResizeWatermark = 15;
		}			
		elseif ($iOriginalImageSize <= 150 && $iWatermarkImageSize > 20)
		{
			if($bHorizontal)
			{
				$iResizeWatermarkW = 20;
				$iResizeWatermarkH = round(($aImgInfo[1] * $iResizeWatermarkW)/$aImgInfo[0]);
			}
			else
			{
				$iResizeWatermarkH = 20;
				$iResizeWatermarkW = round(($aImgInfo[0] * $iResizeWatermarkH)/$aImgInfo[1]);
			}
			$iResizeWatermark = 20;
		}
		elseif ($iOriginalImageSize <= 200 && $iWatermarkImageSize > 30)
		{
			if($bHorizontal)
			{
				$iResizeWatermarkW = 30;
				$iResizeWatermarkH = round(($aImgInfo[1] * $iResizeWatermarkW)/$aImgInfo[0]);
			}
			else
			{
				$iResizeWatermarkH = 30;
				$iResizeWatermarkW = round(($aImgInfo[0] * $iResizeWatermarkH)/$aImgInfo[1]);
			}
			$iResizeWatermark = 30;
		}
		elseif ($iOriginalImageSize <= 250 && $iWatermarkImageSize > 40)
		{
			if($bHorizontal)
			{
				$iResizeWatermarkW = 30;
				$iResizeWatermarkH = round(($aImgInfo[1] * $iResizeWatermarkW)/$aImgInfo[0]);
			}
			else
			{
				$iResizeWatermarkH = 30;
				$iResizeWatermarkW = round(($aImgInfo[0] * $iResizeWatermarkH)/$aImgInfo[1]);
			}
			$iResizeWatermark = 30;
		}	
		elseif ($iOriginalImageSize <= 500 && $iWatermarkImageSize > 40)
		{
			if($bHorizontal)
			{
				$iResizeWatermarkW = 40;
				$iResizeWatermarkH = round(($aImgInfo[1] * $iResizeWatermarkW)/$aImgInfo[0]);
			}
			else
			{
				$iResizeWatermarkH = 40;
				$iResizeWatermarkW = round(($aImgInfo[0] * $iResizeWatermarkH)/$aImgInfo[1]);
			}
			$iResizeWatermark = 40;
		}
		
		if ($iResizeWatermark !== null)
		{
			$sNewPath = AIN::getParam('core.dir_watermark') . sprintf(AIN::getParam('core.watermark_image'), '_' . $iResizeWatermark);
			if (!file_exists($sNewPath))
			{
				$this->_destroy();
				$this->createThumbnail($sPath, $sNewPath, $iResizeWatermarkW, $iResizeWatermarkH);
				$this->_destroy();
				$this->_load($sImage);
			}
			
			$sPath = $sNewPath;
			$aImgInfo = @getimagesize($sPath);
		}		
		
		switch($sType)
		{
			case 'gif':
				$hMark = imagecreatefromgif($sPath);
				break;			
			case 'jpeg':
			case 'jpg':
			case 'jpe':
				$hMark = imagecreatefromjpeg($sPath);
				break;			
			case 'png':
				$hMark = imagecreatefrompng($sPath);
				break;
		}
		
		if(!$hMark)
		{
		 	return AIN_Error::set(AIN::getPhrase('core.unable_to_create_a_watermark_resource'));
	 	}
	 	
        switch ($this->_aInfo[2])
        {
            case 1:
                $hFrm = imagecreatefromgif($this->sPath);
                break;
            case 3:
                $hFrm = imagecreatefrompng($this->sPath);
                break;
            default:
                $hFrm = imagecreatefromjpeg($this->sPath);               
				break;
        }	 	
	 	
		switch($this->sType)
		{		
			case 'jpeg':
			case 'jpg':
			case 'jpe':
			case 'png':
				@imagealphablending($hFrm, true);
			break;
		}	 	
	 	
	 	$sPosition = AIN::getParam('core.watermark_image_position');
	 	switch ($sPosition)
	 	{
	 		case 'top_left':
				$iLocateX = (($this->nW - $aImgInfo[0]) - $this->nW + $aImgInfo[0]);
	 			$iLocateY = (($this->nH - $aImgInfo[1]) - $this->nH + $aImgInfo[1]);
	 			break;
	 		case 'top_right':
				$iLocateX = $this->nW - $aImgInfo[0];
	 			$iLocateY = (($this->nH - $aImgInfo[1]) - $this->nH + $aImgInfo[1]);
	 			break;	 			
	 		case 'bottom_left':
				$iLocateX = (($this->nW - $aImgInfo[0]) - $this->nW + $aImgInfo[0]);
	 			$iLocateY = $this->nH - $aImgInfo[1];
	 			break;
	 		default:
				$iLocateX = $this->nW - $aImgInfo[0];
	 			$iLocateY = $this->nH - $aImgInfo[1];	 				 			
	 			break;
	 	}	 	
	 	
	 	if($sType == 'png')
 		{
	 		@imagecopy($hFrm, $hMark, $iLocateX, $iLocateY, 0, 0, $aImgInfo[0], $aImgInfo[1]);
 		}
 		else
		{
			@imagecopymerge($hFrm, $hMark, $iLocateX, $iLocateY, 0, 0, $aImgInfo[0], $aImgInfo[1], $iOpacity);
		}
				
		switch ($this->sType)
        {
        	case 'gif':
	            @imagegif($hFrm, $this->sPath);
			break;
            case 'png':
				@imagealphablending($hFrm, false);
				@imagesavealpha($hFrm, true);            	
            	@imagepng($hFrm, $this->sPath);
			break;
            default:
            	@imagejpeg($hFrm, $this->sPath);
            	break;
		}
	 	
	 	imagedestroy($hMark);
	 	
		if (AIN::getParam('core.allow_cdn'))
		{
			AIN::getLib('cdn')->put($this->sPath);
		}	 	
	 	
	 	return true;
	}
}
?>