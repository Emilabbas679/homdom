<?php

defined('AIN') or exit('NO DICE!');

class admincp_component_controller_location_locality_mass extends AIN_Component
{
    public function process()
    {
        if ($aVals = $this->request()->getArray('val')) {
            if (!isset($aVals['ids']))
                return AIN_Module::instance()->setController('admincp.location.locality.index');

            if ($aVals['district_id'] == '' or $aVals['district_id'] == 0)
                return AIN_Module::instance()->setController('admincp.location.locality.index');
            $ids = [];
            foreach ($aVals['ids'] as $id) {
                $ids[(string) $id] = $id;
            }
            $options['ids'] = json_encode($ids);
            $options['district_id'] = $aVals['district_id'];
            $data = AIN::getService('homdom.core')->homdom_mass_locality($options);
            if ('success' == $data['status'])
                $this->url()->send('location.locality.index', [], AIN::getPhrase('homdom.successfully_updated'));
            else
                AIN_ERROR::set(implode('<br/>', $data['messages']));


        }
        else{
            $ids = [];
            if(isset($_GET['ids']))
                $ids = $_GET['ids'];
            if (count($ids) == 0)
                return AIN_Module::instance()->setController('admincp.location.locality.index');
            $aForms = [];
            $aForms['ids'] = $ids;
            $this->template()->assign(['aForms' => $aForms]);
        }



    }
}
