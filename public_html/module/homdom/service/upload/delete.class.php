<?php

defined('AIN') or exit('NO DICE!');


class apanel_service_delete_delete extends AIN_Service
{
	private $_path = 'cdn';

	public function __construct()
	{
        $id = $this->request()->get('key');
		AIN::getLib('database')->where('ad_files.id = "'.$id.'"');

		$aRow = AIN::getLib('database')->select('ad_files.*')->from(AIN::getT('ad_files'), 'ad_files')->execute('getRow');

		AIN::getlib('file')->unlink( AIN_DIR_FILE . $aRow['dir_path'] . $aRow['image_path'] );

		AIN::getLib('database')->delete(AIN::getT('ad_files'), 'id = "'.$aRow['id'].'"');

        echo json_encode(array('status',true));

	}









}
?>