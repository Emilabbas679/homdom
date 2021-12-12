<?php

defined('AIN') or exit('NO DICE!');

class Admincp_Component_Controller_Complex_reviews_index extends AIN_Component
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
        $where['entity_type'] = 1;
        $this->template()->assign(['aForms' => $where]);
        $aRows = AIN::getService('homdom.core')->get_reviews($where);
        if ('failed' == $aRows['status'])
            AIN_ERROR::set(implode('<br/>', $aRows['messages']));

        $iCnt = 0;
        if (isset($aRows['data']['count']))
            $iCnt = $aRows['data']['count'];
        $aData = [];
        if (isset($aRows['data']) and isset($aRows['data']['rows']))
            $aData = $aRows['data']['rows'];
        foreach ($aData as $iKey => $aRow)
        {
            $display = [];
            $tools = [];
            if ($aRow['status_id'] != 11)
                $tools[] = $table->buildMenu(AIN::getLib('url')->makeUrl('complex.reviews.status', ['id' => $aRow['id'], 'status_id' => 11]), AIN::getPhrase('homdom.status_id_11'), 'icon-pencil3 text-primary-600');
            if ($aRow['status_id'] != 12)
                $tools[] = $table->buildMenu(AIN::getLib('url')->makeUrl('complex.reviews.status', ['id' => $aRow['id'], 'status_id' => 12]), AIN::getPhrase('homdom.status_id_12'), 'icon-pencil3 text-primary-600');
            $tools[] = $table->buildMenu(AIN::getLib('url')->makeUrl('complex.reviews.delete', ['id' => $aRow['id']]), AIN::getPhrase('homdom.delete'), 'icon-pencil3 text-primary-600');
            $display[AIN::getPhrase('homdom.id')] = $aRow['id'];
            $display[AIN::getPhrase('homdom.tools')] = $tools;
            $user = '';
            if ($aRow['user_fullname'])
                $user = $aRow['user_fullname'];
            elseif($aRow['full_name'])
                $user = $aRow['full_name'];
            $display[AIN::getPhrase('homdom.user_id')] = $user;
            $display[AIN::getPhrase('homdom.content')] = $aRow['content'];
            $display[AIN::getPhrase('homdom.complex')] = $aRow['complex_name'];

            $display[AIN::getPhrase('homdom.status')] =  AIN::getPhrase('homdom.status_id_'.$aRow['status_id']);
            $table->add($display);
        }
        $this->template()->assign(['aTables' => $table->execute()]);


        AIN::getLib('pager')->set(['page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt]);


    }
}
