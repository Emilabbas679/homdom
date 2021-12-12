<?php

defined('AIN') or exit('NO DICE!');

class admincp_component_controller_location_locality_delete extends AIN_Component
{
    public function process()
    {
        if (isset($_GET['id'])) {
            $data = AIN::getService('homdom.core')->homdom_delete_locality(['id' => $_GET['id']]);
        }
        $this->url()->send('location.locality.index', [], AIN::getPhrase('homdom.successfully_deleted'));
    }
}
