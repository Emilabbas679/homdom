<?php

defined('AIN') or exit('NO DICE!');

AIN::getLibClass('ain.image.interface');

interface AIN_Image_Interface
{
	public function createThumbnail($sImage, $sDestination, $nMaxW, $nMaxH);	
}

?>