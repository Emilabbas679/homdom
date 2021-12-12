<?php
/**
 * [PHPFOX_HEADER]
 */

defined('AIN') or exit('NO DICE!');

class homdom_component_block_reviews extends AIN_Component
{
    public function process()
    {
        $where = [
          'status_id' => 11,
          'entity_id' => $_GET['entity_id'],
          'entity_type' => $_GET['entity_type'],
          'page' => $_GET['page'],
          'limit' => $_GET['limit'],
        ];
        $reviews = [];
        $aRows = AIN::sendApi('get_reviews', $where);

        if (isset($aRows['data']) and isset($aRows['data']['rows']) and count($aRows['data']['rows']) > 0)
            $reviews = $aRows['data']['rows'];
        $this->template()->assign(array('reviews' => $reviews));
    }
}

?>