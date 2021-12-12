<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_mortgage extends AIN_Component
{

    public function process()
    {

        $meta['title'] = AIN::getPhrase('homdom.mortgage_calculator') .' | '.$_SERVER['SERVER_NAME'];
        $this->template()->setTitle($meta['title']);
        $meta['description'] = AIN::getPhrase('homdom.mortgage_calculator_page_meta_description');
        $this->template()->assign(['meta'=> $meta]);

    }


}
