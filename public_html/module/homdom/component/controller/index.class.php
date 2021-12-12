<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_index extends AIN_Component
{


    public function process()
    {

        $req1 = $this->request()->get('req1');
        $req2 = $this->request()->get('req2');
        
        $sitemap = AIN::getService('homdom.helpers')->getSitemapPage($req1, $req2);





        $meta['title'] = AIN::getPhrase('homdom.home') .' | '.$_SERVER['SERVER_NAME'];
        $this->template()->setTitle($meta['title']);
        $meta['description'] = AIN::getPhrase('homdom.home_page_meta_description');
        $this->template()->assign(['meta'=> $meta]);



		
		$data = AIN::getService('homdom.helpers')->index();
        $this->template()->assign(['last_offers' => $data['last_offers'] ]);
        $this->template()->assign(['complexes' => $data['complexes']]);
        $this->template()->assign(['rent_offers' => $data['rent_offers']]);
        $this->template()->assign(['house_offers' => $data['house_offers']]);
        $this->template()->assign(['searchForm' => []]);

    }
}
