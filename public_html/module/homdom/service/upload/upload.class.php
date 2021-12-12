<?php

defined('AIN') or exit('NO DICE!');


class apanel_service_upload_upload  extends AIN_Service
{
	private $_path = 'cdn';

	public function __construct()
	{

	}
    public function FileUploader ()
	{
		if (! defined('FOLDER_PREFIX'))
		{
			if (@ini_get( 'safe_mode' ) == 1)
				define( 'FOLDER_PREFIX', "" );
			else
				define( 'FOLDER_PREFIX', date( "Y-m" ) );
		}
	}
	public function directory_copy($src, $dst) {  
	  
		// open the source directory 
		$dir = opendir($src);  
	  
		// Make the destination directory if not exist 
		@mkdir($dst);  
	  
		// Loop through the files in source directory 
		while( $file = readdir($dir) ) {  	  
			if (( $file != '.' ) && ( $file != '..' )) {  
				if ( is_dir($src . '/' . $file) )  
				{  
					$this->directory_copy($src . '/' . $file, $dst . '/' . $file);  
				}  
				else 
				{  
					copy($src . '/' . $file, $dst . '/' . $file);  
				}  
			}  
		}  	  
		closedir($dir); 
	}
	
	
	public function FileUpload()
	{
		$save = array(); $out = array();
		
		$save['dimension_id'] = AIN::getLib('request')->get('dimension_id');
		
		$save['ad_id'] = AIN::getLib('request')->get('ad_id');
		
		$save['user_id'] = getUserBy('user_id');

		$aRows = $this->getFile( $save );

		if( isset($aRows) and count($aRows['data']) > 0  )
		{
			foreach($aRows['data'] as $key => $aRow )
			{
				$this->deleteFile( $aRow['id'] );
			}
		}
		
		if( !is_dir( AIN_DIR_FILE . $this->_path . AIN_DS . FOLDER_PREFIX ) )
		{
			@mkdir( AIN_DIR_FILE . $this->_path . AIN_DS . FOLDER_PREFIX, 0777 );
			@chmod( AIN_DIR_FILE . $this->_path. AIN_DS . FOLDER_PREFIX, 0777 );
		}
		
		if( !is_dir( AIN_DIR_FILE . $this->_path . AIN_DS . FOLDER_PREFIX ) ) {
			return $this->msg_error( 'Error' );
		}
	
	
		///return $this->msg_error( 'aaaa' . time() );
		
		
		$save['dir_path'] = $this->_path . AIN_DS . FOLDER_PREFIX;

		if ( !empty($_FILES['qqfile']['name'])) {			
	
			$aFiles = AIN::getLib('file')->load('qqfile', array('jfif','jpg', 'gif', 'png', 'mp4', 'zip'));
			
			if( ! AIN_Error::isPassed() )
			{				
				return $this->msg_error( AIN_Error::get() );
			}			
			if ($aFiles === false) {
				
                return $this->msg_error( 'adnetwork.error_file_type' );
            }

			$sFileName = (AIN_TIME . uniqid());
			
			$config = array();			
			$iKey = 0;
			$config[$iKey]['version'] = 2;
			$config[$iKey]['caption'] = $sFileName;
			$config[$iKey]['key'] = AIN_TIME;			
			$config[$iKey]['filename'] = $sFileName;
			 
			 
			if ($sFileName = AIN::getLib('file')->upload('qqfile', AIN_DIR_FILE.$save['dir_path'], $sFileName, false))
			{
				$save['name_path'] = $sFileName;
				$save['format'] = $aFiles['ext'];
				$save['size'] = $aFiles['size'];				
				$save['down_url'] = AIN::getParam('video.cdn_url').FOLDER_PREFIX.$sFileName;
				
                if($aFiles['ext'] == 'zip')
                {
					$sDest = $advert_file = AIN::getLib('file')->getDestFile();
					$zipDir = str_replace('.zip','',$sDest);
					
					AIN::getLib('file')->delete_directory($zipDir);
					
					if( AIN::getLib('archive', 'zip')->extract($sDest, $zipDir) )
					{
						$getFiles = AIN::getLib('file')->getFiles($zipDir, true);
						
						if( count($getFiles) == 1 )
						{
							if( is_dir("$zipDir/{$getFiles[0]}") )
							{
								$this->directory_copy("$zipDir/{$getFiles[0]}", $zipDir);
								
								AIN::getLib('file')->delete_directory("$zipDir/{$getFiles[0]}");
								
								$getFiles = AIN::getLib('file')->getFiles($zipDir, true);
							}
						}									
			
						
						$file_ext_l = array();
						foreach($getFiles as $key => $aRow )
						{	
							$file_ext = AIN::getLib('file')->getFileExt($aRow);
							$file_ext_l[] = $file_ext;
							
							
							if(in_array($file_ext, array('php', 'sh')))
							{
								AIN::getLib('file')->unlink($aRow);
							}							
							if( $file_ext == 'html')
							{
								$type = $file_ext;
								$save['dir_url'] = str_replace(AIN_DIR_FILE.$this->_path.AIN_DS , AIN::getParam('video.cdn_url'),$zipDir).AIN_DS.$aRow;
								$config[$iKey]['type'] = $save['type'] = $type;						
							}							
						}	
						$out[$iKey]['file_ext'] = json_encode($file_ext_l);					
					}						
					$config[$iKey]['size'] = $save['size'];
					$config[$iKey]['downloadUrl'] = $save['down_url'];
                } 
				elseif( $aFiles['ext'] == 'mp4')
                {		
					$config[$iKey]['size'] = $save['size'];	
					$config[$iKey]['downloadUrl'] = $save['dir_url'] = $save['down_url'];
					$config[$iKey]['type'] = $save['type'] = 'video';
					$config[$iKey]['filetype'] = "video/mp4";			
                } 				
				else 
				{			
					$config[$iKey]['size'] = $save['size'];
					$config[$iKey]['downloadUrl'] = $save['dir_url'] = $save['down_url'];
					$config[$iKey]['type'] = $save['type'] = 'image';
					$config[$iKey]['filetype'] = 'image/'.$file_ext;
					
					//if ( ! getGroupParam('adnetwork.can_manage_root') ) 
					{				
					//	$iMaxSize = 250;
						//if ($save['size'] > $iMaxSize ) 
						//return $this->msg_error( array(AIN::getPhrase('adnetwork.max_file_size', [ 'size' => $iMaxSize ] )) );
					}
                }	
				
				$save['id'] = AIN::getLib('database')->insert(AIN::getT('ad_files'), $save);		
				$config[$iKey]['key'] = $save['id'];
				
				$out['cdn'] = json_encode($save);
				
				$out['initialPreviewAsData'] = true;
				$out['initialPreviewConfig'] = $config;			
				
				if( $save['type'] == 'html' )
					$out['initialPreview'] =  "<div class='text-center'><iframe src='{$save['dir_url']}' width='100%' height='600' frameborder='0' marginwidth='0' marginheight='0' vspace='0' hspace='0' scrolling='no' allowtransparency='true' allowfullscreen='true'></iframe></div>";
				else
					$out['initialPreview'] =  $save['dir_url'];
			
				return 	$out;
			}
		}
		
		$data = array();		
		$data['result'] = json_encode($save);
		$data['success'] = true;
		
		return $data;
	}
	
	
	
	private function msg_error($message, $code = 500)
	{
		return array(
			'success' => false,
			'error' => implode('<br/>', $message)
		);
	}
	public function getFile( $where = array() )
	{
		if( isset( $where['ad_id'] )  and $where['ad_id'] > 0 )
		{
			AIN::getLib('database')->where('ad_files.ad_id = "'.$where['ad_id'].'"');
		}
		elseif( isset( $where['id'] )  and $where['id'] > 0 )
		{
			AIN::getLib('database')->where('ad_files.id = "'.$where['id'].'"');
		}
		else
		{
			AIN::getLib('database')->where('ad_files.user_id = "'.$where['user_id'].'" and ad_files.ad_id = "0"');
		}

		$aRows = AIN::getLib('database')->select('ad_files.*')->from(AIN::getT('ad_files'), 'ad_files')->execute('getRows');

		return array( 'version' => '2', 'format' => $aRows['format'], 'data' => $aRows );
	}
	public function deleteFile( $id = null)
	{
        $id = $this->request()->get('key');
		AIN::getLib('database')->where('ad_files.id = "'.$id.'"');

		$aRow = AIN::getLib('database')->select('ad_files.*')->from(AIN::getT('ad_files'), 'ad_files')->execute('getRow');

		AIN::getlib('file')->unlink( AIN_DIR_FILE . $aRow['dir_path'] . $aRow['name_path'] );

		return AIN::getLib('database')->delete(AIN::getT('ad_files'), 'id = "'.$aRow['id'].'"');
	}









}
?>
