<?php

defined('AIN') or exit('NO DICE!');


class apanel_service_deletefile_delete extends AIN_Service
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
	public function FileUpload()
	{
		$save = array();
		$save['ad_id'] = AIN::getLib('request')->get('ad_id');
		$save['user_id'] = getUserBy('user_id');

		$aRows = AIN::getService('video.upload')->getFile( $save );

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

		$save['dir_path'] = $this->_path . AIN_DS . FOLDER_PREFIX;

		if ( !empty($_FILES['qqfile']['name'])) {

			$aFiles = AIN::getLib('file')->load('qqfile', array('jpg', 'gif', 'png', 'mp4', 'zip'));

			if ($aFiles === false) {
                return $this->msg_error( 'adnetwork.error_file_type' );
            }

			$sFileName = (AIN_TIME . uniqid());

			if ($sFileName = AIN::getLib('file')->upload('qqfile', AIN_DIR_FILE.$save['dir_path'], $sFileName, false))
			{
				$save['image_path'] = $sFileName;
				$save['format'] = $aFiles['ext'];
				$save['size'] = $aFiles['size'];
				$save['cdn_url'] = AIN::getParam('video.cdn_url').FOLDER_PREFIX.$sFileName;
				$save['id'] = AIN::getLib('database')->insert(AIN::getT('ad_files'), $save);
				$save['result'] = json_encode($save);
				$save['success'] = true;
                $config[] = [
                    'key' => $save['id'],
                    'caption' => "{$save['ad_id']} - {$save['image_path']}",
                    'size' => $save['size'],
                    'downloadUrl' => $save['cdn_url'], // the url to download the file
                    //'url' => AIN::getLib('url')->makeUrl('delete', array( "id" => $save['id'] ) ), // server api to delete the file based on key
                    'url' => "/_ajax/?core[ajax]=true&core[call]=video.delete&id={$save['ad_id']}", // server api to delete the file based on key


					'type' => 'video',
					"filetype" => "video/mp4",
                ];
				$out = ['initialPreview' => $save['cdn_url'], 'initialPreviewConfig' => $config, 'initialPreviewAsData' => true];
				return 	$out;
			}
		}

		return $save;
	}
	private function msg_error($message, $code = 500)
	{
		return array(
			'success' => false,
			'error' => $message
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
			//AIN::getLib('database')->where('ad_files.user_id = "'.$where['user_id'].'" and ad_files.ad_id = "0"');
		}

		$aRows = AIN::getLib('database')->select('ad_files.*')->from(AIN::getT('ad_files'), 'ad_files')->execute('getRows');

		return array( 'version' => '2', 'format' => $aRow['format'], 'data' => $aRows );
	}
	public function deleteFile( $id )
	{
		AIN::getLib('database')->where('ad_files.id = "'.$id.'"');

		$aRow = AIN::getLib('database')->select('ad_files.*')->from(AIN::getT('ad_files'), 'ad_files')->execute('getRow');

		AIN::getlib('file')->unlink( AIN_DIR_FILE . $aRow['dir_path'] . $aRow['image_path'] );

		AIN::getLib('database')->delete(AIN::getT('ad_files'), 'id = "'.$aRow['id'].'"');

		return true;
	}









}
?>