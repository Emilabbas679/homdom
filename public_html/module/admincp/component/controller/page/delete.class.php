<?php

defined('AIN') or exit('NO DICE!');

class admincp_component_controller_page_delete extends AIN_Component
{
    public function process()
    {
        if (isset($_GET['id'])) {
            $data = AIN::getService('homdom.core')->delete_page(['id' => $_GET['id']]);
        }
        $this->url()->send('page.index', [], AIN::getPhrase('homdom.successfully_deleted'));
    }
}
