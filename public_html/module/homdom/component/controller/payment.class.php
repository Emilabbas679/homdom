<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_payment extends AIN_Component
{

    public function process()
    {
        $data = AIN::getLib('payment.azericard')->auth(1,1);
        die($data);
        die($data);

        var_dump('aa'); die();
    }


}
