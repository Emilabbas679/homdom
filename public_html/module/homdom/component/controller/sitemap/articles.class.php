<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_sitemap_articles extends AIN_Component
{

    public function process()
    {
        ob_clean();
        header("Content-type: text/xml");
        $articles = AIN::sendApi('homdom_get_article', ['status_id' => 11, 'limit' => 1000]);
        $rows = [];
        if (isset($articles['data']) and isset($articles['data']['rows']))
            $rows = $articles['data']['rows'];

        $xml = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($rows as $row) {
            $xml .= '<url>';
            $xml .= '<loc>'.AIN::getLib('url')->makeUrl('journal-in', $row['slug']).'</loc>';
            $xml .= '<lastmod>'.date('Y-m-d', strtotime($row['intime'])).'</lastmod>';
            $xml .= '<changefreq>yearly</changefreq>';
            $xml .= '</url>';
        }
        $xml .= "</urlset>";
        echo $xml;
        exit();
    }


}
