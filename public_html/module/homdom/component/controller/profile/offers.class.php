<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_profile_offers extends AIN_Component
{

    public function process()
    {
        if( ! AIN::isUser() ) return AIN_Module::instance()->setController('homdom.auth.login');
        $meta['title'] = AIN::getPhrase('homdom.offers').' | '.AIN::getPhrase('homdom.profile') .' | '.$_SERVER['SERVER_NAME'];
        $this->template()->setTitle($meta['title']);
        $meta['description'] = AIN::getPhrase('homdom.profile_offers_meta_description');
        $this->template()->assign(['meta'=> $meta]);

        $this->template()->setTitle(AIN::getPhrase('homdom.my_offers'));
        $iPage = $this->request()->getInt('page');
        $iPageSize = 10;
        if ($iPage < 0) $iPage = 0;
        $status_id = $this->request()->get('req3');
        if ($status_id == null) $status_id = 'active';

        if ($aVals = $this->request()->getArray('val')){
            if (isset($aVals['status_id']) and $aVals['status_id'] != '' and $aVals['status_id'] != '0')
                $status_id = $aVals['status_id'];
        }
        $status_ids = [9 => 'expired',10 => 'deactivated',11 => 'active',12=>'pending'];
        $iCnt = 0;$data = [];
        if (in_array($status_id,$status_ids)) {
            $status_id = array_search($status_id, $status_ids);
            $where = ['status_id' =>$status_id, 'page' => $iPage, 'limit' => 10, 'user_id' => getUserBy('user_id') ];
            $aRows = AIN::getService('homdom.core')->homdom_get_offer($where);

            if (isset($aRows['data']) and $aRows['status'] == 'success') {
                if (isset($aRows['data']['count']))
                    $iCnt = $aRows['data']['count'];
                if (isset($aRows['data']['rows'])){
                    foreach ($aRows['data']['rows'] as $row) {
                        $data[] =AIN::getService('homdom.helpers')->offerToArray($row);
                    }
                }


            }
        }

//        print_r($data); die();
        $this->template()->assign(['offers' => $data]);
        $this->template()->assign(['status_id' => $status_id]);
        AIN::getLib('pager')->set(['page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt]);
    }


}
