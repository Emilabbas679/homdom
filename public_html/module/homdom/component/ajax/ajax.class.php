<?php
/**
 * Class User_Component_Ajax_Ajax.
 */
class homdom_component_ajax_ajax extends AIN_Ajax
{
    public function Ad_DataTable()
    {
        AIN_Module::instance()->setController('video.ad.adset.index');

        $table = AIN::getService('video.func.table');
        $execute = $table->execute();
        $data = array();
        if (isset($execute['tbody'])) {
            foreach ($execute['tbody'] as $key => $row) {
                foreach ($row as $key2 => $row2) {
                    $data[$key][] = $row2;
                }
            }
        }
        echo json_encode(
            array(
                'draw' => 1,
                'recordsTotal' => 10,
                'recordsFiltered' => 10,
                'data' => $data,
            ),
            JSON_PRETTY_PRINT
        );

        //print_r($data);
    }

//    public function upload()
//    {
//        $this->error(false);
//
//        $uploader = AIN::getService('video.upload');
//
//        $uploader->FileUploader();
//
//        $result = $uploader->FileUpload();
//
//        echo json_encode($result);
//    }

    public function info()
    {
        phpinfo();
    }
//    public function delete()
//    {
//        $id = $this->get('id');
//        AIN::getService('video.upload')->deleteFile($id);
//        echo json_encode(array('status', true));
//    }


    public function userSearchList()
    {
        AIN::isUser(true);
        $aVals = $this->get('val');
        $where = array();
        $results = array();
        $where['size'] = 10;
        $where['page'] = 1;
        $where['search_name'] = $aVals['searchQuery'];
        $get_user_list = AIN::getService('video')->get_user_list($where);

        if (isset($get_user_list['data']) and count($get_user_list['data'])) {
            foreach ($get_user_list['data']['rows'] as $key => $aRow) {
                $results[] = array(
                    'label' => "{$aRow['user_name']} / {$aRow['email']}",
                    'user_id' => $aRow['user_id'],
                    'firstname' => explode(' ',$aRow['full_name'])[0],
                    'lastname' => explode(' ',$aRow['full_name'])[1],
                    'email' => $aRow['email'],
                    'user_group_id' => $aRow['user_group_id']
                );
            }
        }
        echo json_encode($results);
    }

    public function userSearchQuery()
    {
        AIN::isUser(true);
        $aVals = $this->get('val');
        $where = array();
        $results = array();
        $where['size'] = 10;
        $where['page'] = 1;
        $where['search_name'] = $aVals['searchQuery'];
        $get_user_list = AIN::getService('video')->get_user_list($where);

        if (isset($get_user_list['data']) and count($get_user_list['data'])) {
            foreach ($get_user_list['data']['rows'] as $key => $aRow) {
                $results[] = array(
                    'label' => "{$aRow['user_name']} / {$aRow['email']}",
                    'user_id' => $aRow['user_id'],
                    'user_group_id' => $aRow['user_group_id']
                );
            }
        }
        echo json_encode($results);
    }

    public function siteSearchQuery()
    {
        $aVals = $this->get('val');
        $where = array();
        $results = array();

        $where['size'] = 10;
        $where['page'] = 1;

        $where['searchQuery'] = $aVals['searchQuery'];
        $where['status_id'] = 11;

		/*
		if ( ! getGroupParam('adnetwork.can_manage_publisher_website') )
		{
            $where['user_id'] = getUserBy('user_id');
        }
		*/	
		
        if (isset($aVals['format_type_id'])) {
            $where['format_type_id'] = $aVals['format_type_id'];
        }

        if (isset($aVals['dimension_id'])) {
            $where['dimension_id'] = $aVals['dimension_id'];
        }
		
		
        $getSites = AIN::getService('video')->get_slot_site($where);

        if (isset($getSites['data']) and count($getSites['data'])) {
            foreach ($getSites['data']['rows'] as $key => $aRow) {
                $label = "{$aRow['domain']}";

                $results[] = array(
                    'label' => $label,
                    'domain' => $aRow['domain'],
                    'site_id' => $aRow['site_id'],
                    'spend_cpm' => $aRow['spend_cpm'],
                    'spend_cpc' => $aRow['spend_cpc'],
                    'slot_count' => $aRow['slot_count'],
                );
            }
        }

        echo json_encode($results);
    }










    public function siteSearchAdserving()
    {
		
		$where = array();
		$where['site_id'] = $this->get('site_id');
		$where['status_id'] = 11;
		$aRows = AIN::getService('video')->get_slot($where);
		$slots = $aRows['data']['rows'];
		$html = '';


		foreach($slots as $key => $data )
		   $html .=  "
			<div class=\"form-check\">
				<label class=\"form-check-label\"> 
					<input type=\"checkbox\" class=\"form-check-input\" name=\"val[slot_id][{$data['slot_id']}]\" value=\"{$data['slot_id']}\">
					{$data['domain']} => {$data['name']}
				</label>
			</div>
		   "; 	
		
		
        $this->prepend('#adserving', $html);
    }
	
	
	
	
    public function SiteList()
    {
        AIN::getBlock('video.AjaxSiteList', array());
    }

    public function setCampaignId()
    {
        $aForms = $this->get('val');
        $get_user_campaign_adset = AIN::getService('video.advert')->get_user_campaign_adset($aForms['campaign_id']);

        $select = "<option value='0'>".AIN::getPhrase('adnetwork.select').'</option>';
        $select .= "<option value='-1'>".AIN::getPhrase('adnetwork.adset_add').'</option>';

        if (count($get_user_campaign_adset['data']['rows']) > 0) {
            $select .= "<optgroup label='".AIN::getPhrase('adnetwork.adset_existing_list')."'>";
            foreach ($get_user_campaign_adset['data']['rows'] as $aOptionsR) {
                $select .= "<option value='{$aOptionsR['set_id']}'>{$aOptionsR['name']}</option>";
            }
            $select .= '</optgroup>';
        }

        $this->html("#{$aForms['jsId']}", $select);
    }

    public function delete_user_group_setting()
    {
        $aForms = $this->get('val');

        AIN::getService('video')->delete_user_group_setting(array('name' => $aForms['name'], 'module_id' => $aForms['module_id']));

        $this->set('module_id', $aForms['module_id']);

        $this->getSettings();
    }

    public function getSettings()
    {
        AIN::getBlock('video.group-setting');
        $this->html('#js_module_title', $this->get('module_id'));
        $this->html('#js_setting_block', $this->getContent(false));
        $this->show('#content_editor_text');
        $this->addClass('.table_clear', 'table_hover_action');
        $this->call('$Core.loadInit();');
    }

    public function payBank()
    {
        $aForms = $this->get('val');

        if (isset($aForms['pay_token'])) {
            $pay_token = $aForms['pay_token'];
            $pay_token = AIN::getLib('url')->decode($pay_token);
            $result = AIN::getService('video.payment')->pay($pay_token);
            if ($result['result'] == 'success') {
                return $this->send($result['paymentUrl']);
            } else {
                return $this->send(AIN::getLib('url')->makeUrl('error.404', array('message' => $result['info'])));
            }
        }
        return $this->send(AIN::getLib('url')->makeUrl('error.404'));
    }

    public function reports()
    {
        AIN::isUser(true);
        AIN::getBlock('video.reports');
        $this->html('#js_reports', $this->getContent(false));
    }

    public function FinanceAdd()
    {
        AIN::isUser(true);
        AIN::getLib('module')->getComponent('video.finance.add', array(), 'controller');
    }


    public function CampaignInfo()
    {
        AIN::isUser(true);
        AIN::getLib('module')->getComponent('video.ad.campaign.info', array(), 'controller');
    }

    public function adsetInfo()
    {
        AIN::isUser(true);
        AIN::getLib('module')->getComponent('video.ad.adset.info', array(), 'controller');
    }

    public function advertInfo()
    {
        AIN::isUser(true);
        AIN::getLib('module')->getComponent('video.ad.advert.info', array(), 'controller');
    }

    public function get_user_notifications()
    {
        AIN::isUser(true);
        $uid = getUserBy();
        $notifications = AIN::getService('video')->get_user_notifications(['is_seen' => 0, 'user_id' => $uid['user_id']]);
        echo json_encode($notifications);
    }

    public function seen_notification()
    {
        AIN::isUser(true);
        $aVals = (array) $this->get('val');
        $notifications = AIN::getService('video')->seen_notification(['id' => $aVals['id']]);
        echo json_encode($notifications);
    }

    public function FinanceBrandForm()
    {
        $aVals = (array) $this->get('val');
        AIN::getLib('database')->update(AIN::getT('finance_ad'), $aVals, "id='{$aVals['id']}'");
        //$this->reload();
        $this->html('#finance_id_'.$aVals['id'], 'Yadda saxlanıldı');
        $this->call('tb_remove();');

        //print_r($aVals);
    }

    public function PreviousPayments()
    {
        AIN::isUser(true);
        AIN::getLib('module')->getComponent('video.ad.wallet.previous', array(), 'controller');
    }

    public function walletbyUser()
    {
        AIN::isUser(true);
        AIN::getLib('module')->getComponent('video.ad.wallet.userwallet', array(), 'controller');
    }


    public function getPayChecks()
    {
        AIN::isUser(true);
        AIN::getLib('module')->getComponent('video.ad.wallet.paychecks', array(), 'controller');
    }

    public function getAdPayChecks()
    {
        AIN::isUser(true);
        AIN::getLib('module')->getComponent('video.ad.wallet.adpaychecks', array(), 'controller');
    }

    public function FinanceBrand()
    {
        AIN::isUser(true);

        $aRows = db()->select('*')->from(AIN::getT('finance_brand'))->execute('getRows');

        $select = '';
        $select .= "<option value='0'>Seç</option>";

        foreach ($aRows as $key => $aRow) {
            $ss = '';
            if ($this->get('brand_id') == $aRow['brand_id']) {
                $ss = 'selected="selected"';
            }
            $select .= "<option value='{$aRow['brand_id']}' {$ss}>{$aRow['name']}</option>";
        }
        $tpl = '<form action="'.AIN::getLib('url')->makeUrl('finance.ad').'" method="POST" onsubmit="$(this).ajaxCall(\'video.FinanceBrandForm\'); return false;">
                    <fieldset>
					<input type="hidden" name="val[id]" value="'.$this->get('id').'">
					<div class="form-group row" id="adJsaction_id">
						<label class="col-form-label col-lg-2">Brand</label>
						<div class="col-lg-10">
							<select class="form-control" name="val[brand_id]" id="brand_id">
								'.$select.'
							</select>
						</div>
					</div>

					</fieldset>
					<div class="text-right">
						<button type="submit" class="btn btn-primary">YADDA SAXLA</button>
					</div>
           </form>';

        echo $tpl;
    }


    public function MemberInviteRecordAndSendMail()
    {
        $aForms = $this->get('val');
        AIN::isUser(true);
        $resu = AIN::getLib('module')->getComponent('video.user.members.invite', [], 'controller');
        echo $resu;
    }









    public function upload()
    {

        AIN::isUser(true);
        if( isset($_FILES['image']['tmp_name']) or isset($_FILES['file']['tmp_name']) )
        {
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");

            if (isset($_FILES['image']['tmp_name'])) {
                $file = $_FILES['image'];
            }
            else
                $file = $_FILES['file'];

            $fileName = date('Y-m')."/{$file['name']}";
            $dd = AIN::getLib('cdn')->put($file['tmp_name'], $fileName);

            if( isset($dd['status']) and $dd['status'] == 'success')
            {
                http_response_code(200);
                echo json_encode($dd['data']);
            }
            else
            {
                http_response_code(301);
                echo implode(',', $dd['messages']);
            }
        }

        if( isset($_FILES['video']['tmp_name']) )
        {
           // var_dump($_FILES); die();
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");

            $fileName = date('Y-m')."/{$_FILES['video']['name']}";
            $dd = AIN::getLib('cdn')->put($_FILES['video']['tmp_name'], $fileName);
            if( isset($dd['status']) and $dd['status'] == 'success')
            {
                http_response_code(200);
                echo json_encode($dd['data']);
            }
            else
            {
                http_response_code(301);
                echo implode(',', $dd['messages']);
            }
        }
    }


    public function deleteFile()
    {
        AIN::isUser(true);
        if (isset($_POST['filename'])) {
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");
            $dd = AIN::getLib('cdn')->remove($_POST['filename']);
            if ($dd) {
                http_response_code(200);
                echo json_encode($dd['data']);
            }
            else{
                http_response_code(301);
                echo 'Error';
            }
        }
    }



    public function advertStatusChange()
    {
        AIN::isUser(true);
        AIN::getLib('module')->getComponent('video.ad.advert.statuschange', array(), 'controller');
    }
    public function sendAdvertMail()
    {
        AIN::isUser(true);
        AIN::getLib('module')->getComponent('video.mail.advert', array(), 'controller');
    }





    public function advertStatus()
    {
        AIN::isUser(true);
        AIN::getLib('module')->getComponent('video.ad.advert.status', array(), 'controller');
    }
    public function CancelAd()
    {
        AIN::isUser(true);
        AIN::getLib('module')->getComponent('video.ad.advert.status', array(), 'controller');
    }

    public function FinancePayablesAdd()
    {
        AIN::isUser(true);
        AIN::getLib('module')->getComponent('video.finance.payables.add', array(), 'controller');
    }



    public function searchBuilding()
    {
        $page = $_GET['page'];
        $opt = ['page' => $page, 'limit'=>10, 'status_id' => 11];
        $return = ['results' => [], 'pagination' => ['more' => false]];
        if(isset($_GET['search']))
            $opt['searchQuery'] = $_GET['search'];

        if (isset($_GET['search']) and $_GET['search'] !='' and strlen($_GET['search'] > 0) ) {
            $opt['searchQuery'] = $_GET['search'];
            $data = AIN::getService('homdom.core')->homdom_get_building($opt);
            if (isset($data['status']) and $data['status'] == 'success'){
                $count = $data['data']['count'];
                $rows = $data['data']['rows'];
                $more = false;
                if ($count > $page*10)
                    $more = true;
                $names = array_column($rows,'building_name');
                $ids = array_column($rows,'id');
                $items = [];
                for ($i=0;$i<10;$i++){
                    if (isset($ids[$i]))
                        $items[] = ['id'=>$ids[$i], 'text'=> $names[$i] ];
                }
                $data = ['results' => $items, 'pagination' => ['more' => $more]];
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($data);
            }
            else{
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($return);
            }
        }
        else{
            $data = ['results' => [], 'pagination' => ['more' => false]];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }



    }

    public function getBuilding()
    {
        $id = $_GET['id'];
        $data = AIN::getService('homdom.core')->homdom_get_building(['id' => $id]);
        $response = [];
        if(isset($data['status']) and $data['status'] == 'success' and $data['data']['count'] == 1){
            $response = $data['data']['rows'][0];
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
    }



    public function searchRegion()
    {
        $page = $_GET['page'];
        $opt = ['page' => $page, 'limit'=>10, 'status_id' => 11];
        $return = ['results' => [], 'pagination' => ['more' => false]];
        if(isset($_GET['search']))
            $opt['searchQuery'] = $_GET['search'];
        $data = AIN::getService('homdom.core')->homdom_get_region($opt);
        if (isset($data['status']) and $data['status'] == 'success'){
            $count = $data['data']['count'];
            $rows = $data['data']['rows'];
            $more = false;
            if ($count > $page*10)
                $more = true;
            $names = array_column($rows,'phrase');
            $ids = array_column($rows,'id');
            $items = [];
            for ($i=0;$i<10;$i++){
                if (isset($ids[$i]))
                    $items[] = ['id'=>$ids[$i], 'text'=> AIN::getPhrase('homdom.'.$names[$i])];
            }
            $data = ['results' => $items, 'pagination' => ['more' => $more]];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }
        else{
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($return);
        }
    }


    public function searchDistrict()
    {
        $page = $_GET['page'];
        $opt = ['page' => $page, 'limit'=>10, 'status_id' => 11];
        $return = ['results' => [], 'pagination' => ['more' => false]];
        if(isset($_GET['search']))
            $opt['searchQuery'] = $_GET['search'];

        $data = AIN::getService('homdom.core')->homdom_get_district($opt);
        if (isset($data['status']) and $data['status'] == 'success'){
            $count = $data['data']['count'];
            $rows = $data['data']['rows'];
            $more = false;
            if ($count > $page*10)
                $more = true;
            $names = array_column($rows,'phrase');
            $ids = array_column($rows,'id');
            $items = [];
            for ($i=0;$i<10;$i++){
                if (isset($ids[$i]))
                    $items[] = ['id'=>$ids[$i], 'text'=> AIN::getPhrase('homdom.'.$names[$i])];
            }
            $data = ['results' => $items, 'pagination' => ['more' => $more]];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }
        else{
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($return);
        }
    }
    public function searchComplex()
    {
        $page = $_GET['page'];
        $opt = ['page' => $page, 'limit'=>10, 'status_id' => 11];
        $return = ['results' => [], 'pagination' => ['more' => false]];
        if(isset($_GET['search']))
            $opt['searchQuery'] = $_GET['search'];

        $data = AIN::getService('homdom.core')->homdom_get_complex($opt);
        if (isset($data['status']) and $data['status'] == 'success'){
            $count = $data['data']['count'];
            $rows = $data['data']['rows'];
            $more = false;
            if ($count > $page*10)
                $more = true;
            $names = array_column($rows,'name');
            $ids = array_column($rows,'id');
            $items = [];
            $items[] = ['id' => 0, 'text' => AIN::getPhrase('homdom.all')];
            for ($i=0;$i<10;$i++){
                if (isset($ids[$i]))
                    $items[] = ['id'=>$ids[$i], 'text'=> $names[$i]];
            }
            $data = ['results' => $items, 'pagination' => ['more' => $more]];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }
        else{
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($return);
        }
    }

    public function searchLocality()
    {
        $page = $_GET['page'];
        $opt = ['page' => $page, 'limit'=>10, 'status_id' => 11];
        if (isset($_GET['districtId']))
            $opt['district_id'] = $_GET['districtId'];
        $return = ['results' => [], 'pagination' => ['more' => false]];
        if(isset($_GET['search']))
            $opt['searchQuery'] = $_GET['search'];

        $data = AIN::getService('homdom.core')->homdom_get_locality($opt);
        if (isset($data['status']) and $data['status'] == 'success'){
            $count = $data['data']['count'];
            $rows = $data['data']['rows'];
            $more = false;
            if ($count > $page*10)
                $more = true;
            $names = array_column($rows,'phrase');
            $ids = array_column($rows,'id');
            $items = [];
            for ($i=0;$i<10;$i++){
                if (isset($ids[$i]))
                    $items[] = ['id'=>$ids[$i], 'text'=> AIN::getPhrase('homdom.'.$names[$i])];
            }
            $data = ['results' => $items, 'pagination' => ['more' => $more]];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }
        else{
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($return);
        }
    }



    public function searchMetro()
    {
        $page = $_GET['page'];
        $opt = ['page' => $page, 'limit'=>10, 'status_id' => 11];
        $return = ['results' => [], 'pagination' => ['more' => false]];
        if(isset($_GET['search']))
            $opt['searchQuery'] = $_GET['search'];
        $data = AIN::getService('homdom.core')->homdom_get_metro($opt);
        if (isset($data['status']) and $data['status'] == 'success'){
            $count = $data['data']['count'];
            $rows = $data['data']['rows'];
            $more = false;
            if ($count > $page*10)
                $more = true;
            $names = array_column($rows,'phrase');
            $ids = array_column($rows,'id');
            $items = [];
            for ($i=0;$i<10;$i++){
                if (isset($ids[$i]))
                    $items[] = ['id'=>$ids[$i], 'text'=> AIN::getPhrase('homdom.'.$names[$i])];
            }
            $data = ['results' => $items, 'pagination' => ['more' => $more]];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }
        else{
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($return);
        }
    }


    public function searchTarget()
    {
        $page = $_GET['page'];
        $opt = ['page' => $page, 'limit'=>10, 'status_id' => 11];
        $return = ['results' => [], 'pagination' => ['more' => false]];
        if(isset($_GET['search']))
            $opt['searchQuery'] = $_GET['search'];
        $data = AIN::getService('homdom.core')->homdom_get_target($opt);
        if (isset($data['status']) and $data['status'] == 'success'){
            $count = $data['data']['count'];
            $rows = $data['data']['rows'];
            $more = false;
            if ($count > $page*10)
                $more = true;
            $names = array_column($rows,'phrase');
            $ids = array_column($rows,'id');
            $items = [];
            for ($i=0;$i<10;$i++){
                if (isset($ids[$i]))
                    $items[] = ['id'=>$ids[$i], 'text'=> AIN::getPhrase('homdom.'.$names[$i])];
            }
            $data = ['results' => $items, 'pagination' => ['more' => $more]];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }
        else{
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($return);
        }
    }



    public function userFavority()
    {

        if( ! AIN::isUser() )
            echo '';
        else{
            $offer_id   = $_POST['offer_id'];
            $type       = $_POST['type'];
            $user_id    = getUserBy('user_id');
            $opt = ['user_id' => $user_id, 'offer_id' => $offer_id];
            $data = [];
            if ($type == 'add')
                $data = AIN::getService('homdom.core')->homdom_create_favority($opt);
            elseif ($type == 'delete')
                $data = AIN::getService('homdom.core')->homdom_delete_favority($opt);
            print_r($data); die();
        }

    }


    public function SetDefaultEntryCount()
    {
        $entries = $_GET['entry_id'];
        $user_id = $_GET['user_id'];
        AIN::getLib('redis')->set("entry:count:user:$user_id", $entries);
        die(1);
    }



    public function FilterChangeForm()
    {
        $page_id = $_GET['page_id'];
        switch ($page_id) {
            case 1:
                AIN::getBlock('homdom.searchForm1');
                break;
            case 2:
                AIN::getBlock('homdom.searchForm2');
                break;
            case 3:
                AIN::getBlock('homdom.searchForm3');
                break;
            case 4:
                AIN::getBlock('homdom.searchForm4');
                break;
            case 5:
                AIN::getBlock('homdom.searchForm5');
                break;
            case 6:
                AIN::getBlock('homdom.searchForm6');
                break;
            default:
                AIN::getBlock('homdom.searchForm1');
        }
    }


    public function offersPageInfinity()
    {
        return AIN::getBlock('homdom.offersPage');
    }

    public function dynamicPageInfinity()
    {
        return AIN::getBlock('homdom.dynamicPage');
    }


    public function getReviews()
    {
        AIN::getBlock('homdom.reviews');
    }

}
