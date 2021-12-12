<?php
/**
 * [PHPFOX_HEADER]
 */

defined('AIN') or exit('NO DICE!');

class homdom_component_block_searchForm6 extends AIN_Component
{
    public function process()
    {
        $url = $_GET['url'];
        $url = parse_url($url);
        $search = [];
        if (isset($url['query']))
            parse_str($url['query'], $search);
        $cTypes = AIN::getService('homdom.helpers')->redisCommercialTypes();
        $this->template()->assign(['search' => $search,'cTypes' => $cTypes]);
    }
}

?>