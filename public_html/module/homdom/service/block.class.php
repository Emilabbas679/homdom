<?php

defined('AIN') or exit('NO DICE!');

class video_service_block extends AIN_Service
{

    private $_aCache = array();

    public function __construct($aParams = array())
    {

    }

    public function category_list()
    {
        $where = [];
        $where['status_id'] = 11;
        $aRows = AIN::getService('video')->get_articles_category($where);
        if ('failed' == $aRows['status']) {
            return $aRows = null;
        }
        return $aRows['data']['rows'];
    }

    public function channel_list()
    {
        $where = [];
        $where['status_id'] = 11;
        $aRows = AIN::getService('video')->get_channel($where);
        if ('failed' == $aRows['status']) {
            return $aRows = null;
        }
        return $aRows['data'][0]['rows'];
    }

    public function get_popular_video()
    {
        $where = [];
        $where['status_id'] = 11;
        $where['limit'] = 8;
        $aRows = AIN::getService('video')->get_video($where);
        if ('failed' == $aRows['status']) {
            return $aRows = null;
        }
        return $aRows['data']['rows'];
    }

    public function get_all_video($cat_id=null, $channel_id=null, $limit=10)
    {
        $where = [];
        $where['status_id'] = 11;
        $where['cat_id'] = $cat_id;
        $where['channel_id'] = $channel_id;
        $where['limit'] = $limit;
        $aRows = AIN::getService('video')->get_video($where);
        if ('failed' == $aRows['status']) {
            return $aRows = null;
        }
        return $aRows['data']['rows'];
    }


    public function get_videobycat($cat)
    {
        $where = [];
        $where['status_id'] = 11;
        $where['limit'] = 10;
        $where['cat_id'] = $cat;
        $aRows = AIN::getService('video')->get_video($where);
        if ('failed' == $aRows['status']) {
            return $aRows = null;
        }
        return $aRows['data']['rows'];
    }
    public function get_other_video()
    {
        $where = [];
        $where['noslug'] = ''.str_replace('/','', $_GET['v']);
        $where['status_id'] = 11;
        $where['limit'] = 10;
        $aRows = AIN::getService('video')->get_video($where);
        if ('failed' == $aRows['status']) {
            return $aRows = null;
        }
        return $aRows['data']['rows'];
    }

    public function get_recommended_video()
    {
        $where = [];
        $where['status_id'] = 11;
        $where['limit'] = 16;
        $aRows = AIN::getService('video')->get_video($where);
        if ('failed' == $aRows['status']) {
            return $aRows = null;
        }
        return $aRows['data']['rows'];
    }

    public function get_films()
    {
        $where = [];
        $where['status_id'] = 11;
        $where['cat_id'] = 19;
        $aRows = AIN::getService('video')->get_video($where);
        if ('failed' == $aRows['status']) {
            return $aRows = null;
        }
        return $aRows['data']['rows'];
    }

    public function popular_channels()
    {
        $where = [];
        $where['status_id'] = 11;
        $aRows = AIN::getService('video')->get_channel($where);
        if ('failed' == $aRows['status']) {
            return $aRows = null;
        }
        return $aRows['data'][0]['rows'];
    }

}
