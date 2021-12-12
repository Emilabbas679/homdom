<?php
/**
 * [PHPFOX_HEADER]
 */

defined('AIN') or exit('NO DICE!');

class admincp_component_block_massPage extends AIN_Component
{
    public function process()
    {
        $massType = $_GET['massType'];
        $this->template()->assign(['massType' => $massType]);
    }
}

?>