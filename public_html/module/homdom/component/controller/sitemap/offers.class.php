<?php

defined('AIN') or exit('NO DICE!');

class homdom_component_controller_sitemap_offers extends AIN_Component
{

    public function process()
    {
        $xml = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('/', $url);
        if (count($url) == 6) {
            $day   = explode('.',$url[5])[0];
            $month = $url[4];
            $year  = $url[3];
            $from  = $year.'-'.$month.'-'.$day;
            $to    = date('Y-m-d', strtotime($from. ' + 1 days'));

            $items = AIN::sendApi('homdom_get_offer', ['modified_interval' => ['from' => $from, 'to' => $to] , 'status_id' => 11, 'limit' => 1000 ]);
            $rows = [];
            if (isset($items['data']) and isset($items['data']['rows']))
                $rows = $items['data']['rows'];

            foreach ($rows as $row) {
                $xml .= '<url>';
                $xml .= '<loc>'.AIN::getLib('url')->makeUrl('offer', $row['id']).'</loc>';
                $xml .= '<lastmod>'.date('Y-m-d', strtotime($row['modified_date'])).'</lastmod>';
                $xml .= '<changefreq>yearly</changefreq>';
                $xml .= '</url>';
            }
        }
        elseif (count($url) == 5) {
            $month   = explode('.',$url[4])[0];
            $year    = $url[3];
            $days = cal_days_in_month(CAL_GREGORIAN,$month,$year);
            for ($i=1; $i<=$days; $i++) {
                $xml .= '<url>';
                $xml .= '<loc>https://homdom.az/sitemap/offers/'.$year.'/'.$month.'/'.$i.'.xml</loc>';
                $xml .= '<changefreq>yearly</changefreq>';
                $xml .= '<priority>yearly</priority>';
                $xml .= '</url>';
            }
        }
        elseif (count($url) == 4) {
            $year   = explode('.',$url[3])[0];
            for ($i=1; $i<=12; $i++) {
                $xml .= '<url>';
                $xml .= '<loc>https://homdom.az/sitemap/offers/'.$year.'/'.$i.'.xml</loc>';
                $xml .= '<changefreq>yearly</changefreq>';
                $xml .= '<priority>yearly</priority>';
                $xml .= '</url>';
            }

        }
        else{
            $end = date('Y');
            for ($i=2012; $i<=$end; $i++) {
                $xml .= '<url>';
                $xml .= '<loc>https://homdom.az/sitemap/offers/'.$i.'.xml</loc>';
                $xml .= '<changefreq>yearly</changefreq>';
                $xml .= '<priority>yearly</priority>';
                $xml .= '</url>';
            }
        }
        $xml .= "</urlset>";
        ob_clean();
        header("Content-type: text/xml");
        echo $xml;
        exit();
    }


}
