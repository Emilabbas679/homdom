<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_sitemap_index extends AIN_Component
{

    public function process()
    {
        ob_clean();
        header("Content-type: text/xml");
        echo AIN::getService('homdom.helpers')->build_main_map();
        exit();
    }


}
