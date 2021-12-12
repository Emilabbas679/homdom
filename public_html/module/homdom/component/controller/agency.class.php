<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_agency extends AIN_Component
{

    public function process()
    {
        $iPage = $this->request()->getInt('page');
        $aVals = [];
        $iPageSize = 10;
        if ($iPage < 0) $iPage = 0;
        $where = ['status_id' => 11, 'page' => $iPage, 'limit' => 10];
        if ($aVals = $this->request()->getArray('val')) {
            if (isset($aVals['searchQuery']) and strlen($aVals['searchQuery']) > 0)
                $where['searchQuery'] = $aVals['searchQuery'];
            if (isset($aVals['agency_type']) and $aVals['agency_type'] != '0')
                $where['agency_type'] = $aVals['agency_type'];
        }


        $aRows = AIN::getService('homdom.core')->homdom_get_agency($where);
        $iCnt = 0;
        $data = [];


        if (isset($aRows['data']) and $aRows['status'] == 'success') {
            if (isset($aRows['data']['count']))
                $iCnt = $aRows['data']['count'];
            if (isset($aRows['data']['rows']))
                $data = $aRows['data']['rows'];
        }

        $this->template()->assign(['agencies' => $data]);
        $this->template()->assign(['aForms' => $aVals]);

        $meta['title'] = AIN::getPhrase('homdom.agencies') .' | '.$_SERVER['SERVER_NAME'];
        $this->template()->setTitle($meta['title']);
        $meta['description'] = AIN::getPhrase('homdom.agencies_page_meta_description');
        $this->template()->assign(['meta'=> $meta]);


        AIN::getLib('pager')->set(['page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt]);






    }


}
