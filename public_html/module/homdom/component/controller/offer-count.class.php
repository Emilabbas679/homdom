<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_offer_count extends AIN_Component
{

    public function process()
    {

        $offer = AIN::getService('homdom.core')->homdom_get_offer_count();
        echo "<p clas='count'>Count:".$offer['data']['count']." </p>";
        echo "<p clas='last_id'>LastId:".$offer['data']['last']['source_id']." </p>";
        die();
    }


}
