<?php

defined('AIN') or exit('NO DICE!');

class admincp_component_controller_complex_block_delete extends AIN_Component
{
    public function process()
    {
        if (isset($_GET['id'])) {
            $data = AIN::getService('homdom.core')->delete_complex_block(['id' => $_GET['id']]);
        }
        $this->url()->send('complex.block.index', [], AIN::getPhrase('homdom.successfully_deleted'));
    }
}
