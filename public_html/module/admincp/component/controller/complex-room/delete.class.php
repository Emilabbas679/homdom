<?php

defined('AIN') or exit('NO DICE!');

class admincp_component_controller_complex_room_delete extends AIN_Component
{
    public function process()
    {
        if (isset($_GET['id'])) {
            $data = AIN::getService('homdom.core')->homdom_delete_complex_room(['id' => $_GET['id']]);
        }
        $this->url()->send('complex-room.index', [], AIN::getPhrase('homdom.successfully_deleted'));
    }
}
