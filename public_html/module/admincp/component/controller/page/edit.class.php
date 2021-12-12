<?php

defined('AIN') or exit('NO DICE!');

class admincp_component_controller_page_edit extends AIN_Component
{
    public function process()
    {
        return AIN_Module::instance()->setController('admincp.page.add');
    }
}
