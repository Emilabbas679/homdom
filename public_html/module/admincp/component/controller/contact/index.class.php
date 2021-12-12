<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Contact_Index extends AIN_Component
{
    public function process()
    {
        $where = [];
        $table = AIN::getService('homdom.func.table');
        $iPage = $this->request()->getInt('page');
        $iPageSize = 10;
        if ($iPage < 0) {
            $iPage = 0;
        }
        $where['page'] = $iPage;
        if ($aVals = $this->request()->getArray('val')) {
            if (isset($aVals['searchQuery']) and strlen($aVals['searchQuery']) > 0)
                $where['searchQuery'] = $aVals['searchQuery'];
        }


        $this->template()->assign(['aForms' => $where]);
        $aRows = AIN::getService('homdom.core')->homdom_get_contact($where);

        if ('failed' == $aRows['status'])
            AIN_ERROR::set(implode('<br/>', $aRows['messages']));
        $iCnt = 0;
        if (isset($aRows['data']['count']))
            $iCnt = $aRows['data']['count'];
        $aData = [];
        if (isset($aRows['data']['rows']))
            $aData = $aRows['data']['rows'];
        foreach ($aData as $iKey => $aRow)
        {
            $display = [];
            $display[AIN::getPhrase('homdom.id')] = $aRow['id'];
            $display[AIN::getPhrase('homdom.full_name')] = $aRow['full_name'];
            $display[AIN::getPhrase('homdom.email')] = $aRow['email'];
            $display[AIN::getPhrase('homdom.phone')] =  $aRow['phone'];
            $display[AIN::getPhrase('homdom.content')] = $aRow['content'];
            $display[AIN::getPhrase('homdom.date')] = date('d.m.Y', strtotime($aRow['intime']));

            $table->add($display);
        }
        $this->template()->assign(['aTables' => $table->execute()]);
        AIN::getLib('pager')->set(['page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt]);


    }
}
