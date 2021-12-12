<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Translation_Index extends AIN_Component
{
    public function process()
    {
        if ($aVals = $this->request()->getArray('val')) {
            foreach ($aVals as $k=>$updateVal) {
                $updateVal['phrase_id'] = $k;
                AIN::getService('homdom.core')->update_phrase_one_language($updateVal);
            }
        }

        
        $where = [];
        $iPage = $this->request()->getInt('page');
        $iPageSize = 10;
        if ($iPage < 0) {
            $iPage = 0;
        }
        $where['page'] = $iPage;
        $where['module_id'] = 'homdom';
        $where['size'] = $iPageSize;

        if ($searchs = $this->request()->getArray('search')) {
            if (isset($searchs['searchQuery']) and strlen($searchs['searchQuery']) > 0)
                $where['searchQuery'] = $searchs['searchQuery'];
            if (isset($searchs['language_id']) and strlen($searchs['language_id']) > 0 and $searchs['language_id'] != "0")
                $where['language_id'] = $searchs['language_id'];

        }



        $this->template()->assign(['aForms' => $where]);
        $aRows = AIN::getService('homdom.core')->get_langauage_phrase($where);


        if ('failed' == $aRows['status'])
            AIN_ERROR::set(implode('<br/>', $aRows['messages']));
        $iCnt = 0;
        if (isset($aRows['data']['count']))
            $iCnt = $aRows['data']['count'];
        $aData = [];
        if (isset($aRows['data']['rows']))
            $aData = $aRows['data']['rows'];


        $this->template()->assign(['rows' => $aData]);
        AIN::getLib('pager')->set(['page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt]);


    }
}
