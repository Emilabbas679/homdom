<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_complex extends AIN_Component
{

    public function process()
    {
//        if( ! AIN::isUser() ) return AIN_Module::instance()->setController('homdom.auth.login');

        if( $this->request()->get('req2') > 0 )
            return AIN::getLib('module')->setController('homdom.complex-in');

        $iPage = $this->request()->getInt('page');
        $aVals = [];
        $iPageSize = 18;
        if ($iPage < 0) $iPage = 0;
        $where = ['status_id' => 11, 'page' => $iPage, 'limit' => 18];
        if ($aVals = $_GET) {
            if (isset($aVals['searchQuery']) and strlen($aVals['searchQuery']) > 0)
                $where['searchQuery'] = $aVals['searchQuery'];
            if (isset($aVals['min_price']) and $aVals['min_price'] != '')
                $where['min_price'] = $aVals['min_price'];
            if (isset($aVals['max_price']) and $aVals['max_price'] != '')
                $where['max_price'] = $aVals['max_price'];
            if (isset($aVals['district_id']) and $aVals['district_id'] != '')
                $where['district_id'] = $aVals['district_id'];
        }


        $aRows = AIN::getService('homdom.core')->homdom_get_complex($where);
        $iCnt = 0;
        $data = [];


        if (isset($aRows['data']) and $aRows['status'] == 'success') {
            if (isset($aRows['data']['count']))
                $iCnt = $aRows['data']['count'];
            if (isset($aRows['data']['rows']))
                $data = $aRows['data']['rows'];
        }

        $this->template()->assign(['complexes' => $data]);
        $this->template()->assign(['aForms' => $aVals]);
        $this->template()->setTitle(AIN::getPhrase('homdom.complexes'));

        AIN::getLib('pager')->set(['page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt]);






    }


}
