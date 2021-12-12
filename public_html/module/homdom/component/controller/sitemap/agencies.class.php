<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_sitemap_agencies extends AIN_Component
{

    public function process()
    {
        ob_clean();
        header("Content-type: text/xml");
        $items = AIN::sendApi('homdom_get_agency', ['status_id' => 11, 'limit' => 1000]);
        $rows = [];
        if (isset($items['data']) and isset($items['data']['rows']))
            $rows = $items['data']['rows'];

        $xml = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($rows as $row) {
            $xml .= '<url>';
            $xml .= '<loc>'.AIN::getLib('url')->makeUrl('agency-in', $row['slug']).'</loc>';
            $xml .= '<lastmod>'.date('Y-m-d', strtotime($row['intime'])).'</lastmod>';
            $xml .= '<changefreq>yearly</changefreq>';
            $xml .= '</url>';
        }
        $xml .= "</urlset>";
        echo $xml;
        exit();
    }


}
