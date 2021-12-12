<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Faq_Complex_Index extends AIN_Component
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
            if (isset($aVals['complex_id']) and $aVals['complex_id'] != '0')
                $where['complex_id'] = $aVals['complex_id'];
        }


        $this->template()->assign(['aForms' => $where]);
        $aRows = AIN::getService('homdom.core')->get_complex_faq($where);

        if ('failed' == $aRows['status'])
            AIN_ERROR::set(implode('<br/>', $aRows['messages']));
        $iCnt = 0;
        if (isset($aRows['data']['count']))
            $iCnt = $aRows['data']['count'];
        $aData = [];
        if (isset($aRows['data']) and isset($aRows['data']['rows']))
            $aData = $aRows['data']['rows'];

        $locale = AIN::getLib('locale')->getLang()[0]['language_id'];

        foreach ($aData as $iKey => $aRow)
        {
            $title = (array) json_decode($aRow['title']);
            $display = [];
            $tools = [];
            $tools[] = $table->buildMenu(AIN::getLib('url')->makeUrl('faq.complex.edit', ['id' => $aRow['id']]), AIN::getPhrase('homdom.edit'), 'icon-pencil3 text-primary-600');
            $display[AIN::getPhrase('homdom.id')] = $aRow['id'];
            $display[AIN::getPhrase('homdom.tools')] = $tools;
            $display[AIN::getPhrase('homdom.title')] = (isset($title[$locale])) ? $title[$locale] : "";
            $display[AIN::getPhrase('homdom.complex')] = $aRow['complex_name'];
            $display[AIN::getPhrase('homdom.status')] =  AIN::getPhrase('homdom.status_id_'.$aRow['status_id']);
            $table->add($display);
        }
        $this->template()->assign(['aTables' => $table->execute()]);


        AIN::getLib('pager')->set(['page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt]);


    }
}
