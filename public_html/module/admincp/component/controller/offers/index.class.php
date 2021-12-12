<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Offers_Index extends AIN_Component
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
            if (isset($aVals['status_id']) and $aVals['status_id'] != '0')
                $where['status_id'] = $aVals['status_id'];
        }

        $where['limit'] = AIN::getService('homdom.helpers')->getDefaultEntryCount();

        $this->template()->assign(['aForms' => $where]);
        $aRows = AIN::getService('homdom.core')->homdom_get_offer($where);

        $iCnt = 0;
        if (isset($aRows['data']['count']))
            $iCnt = $aRows['data']['count'];
        $aData = [];
        if (isset($aRows['data']['rows']))
            $aData = $aRows['data']['rows'];
        foreach ($aData as $iKey => $aRow)
        {
            $display = [];
            $tools = [];

            $title = AIN::getService('homdom.helpers')->getOfferTitle($aRow);
            $tools[] = $table->buildMenu(AIN::getLib('url')->makeUrl('offers.edit', ['id' => $aRow['id']]), AIN::getPhrase('homdom.edit'), 'icon-pencil3 text-primary-600');
            $display[AIN::getPhrase('homdom.id')] = $aRow['id'];
            $display[AIN::getPhrase('homdom.tools')] = $tools;
            $display[AIN::getPhrase('homdom.seller_name')] = ($aRow['user_name'] != '') ? $aRow['user_name'] : $aRow['seller_name'] ;
            $display[AIN::getPhrase('homdom.phone')] = ($aRow['user_phone'] != '') ? "+".$aRow['user_phone'] : '+'.$aRow['phone'] ;
            $display[AIN::getPhrase('homdom.title')] = $title ;
            $display[AIN::getPhrase('homdom.status')] =  AIN::getPhrase('homdom.status_id_'.$aRow['status_id']);
            $display[AIN::getPhrase('homdom.validity_date')] = $aRow['validity_date'] ;

            $table->add($display);
        }
        $this->template()->assign(['aTables' => $table->execute()]);
        AIN::getLib('pager')->set(['page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt]);


    }
}
