<?php

defined('AIN') or exit('NO DICE!');

class homdom_service_func_table extends AIN_Service
{
    private $_table = array();
    private $_tFoot = false;
    private $_aParams = array();

    public function add($data = [])
    {
        $this->_table[] = $data;

        return $this;
    }

    public function execute()
    {
        if (count($this->_table) > 0) {
            $thead = array_keys(current($this->_table));
        }
        else{
            $thead = [];
        }

        $thead_c = current($this->_table);

        $return = array();
        $return['thead'] = $thead;

        if ($this->_tFoot == true) {
            $return['tbody'] = array_slice($this->_table, 0, count($this->_table) - 1);
            $last = array_key_last($this->_table);
            $return['tfoot'] = $this->_table[$last];
        } else {
            $return['tbody'] = array_slice($this->_table, 0, count($this->_table));
        }

        return $return;
    }

    public function tfoot()
    {
        $this->_tFoot = true;

        return $this;
    }

    public function setParam($key, $value)
    {
        $this->_aParams[$key] = $value;

        return $this;
    }

    public function buildMenu($link, $title, $icon = '', $onclick = '', $liclass = '')
    {
        return "<li class='{$liclass}'><a class=\"dropdown-item\" href='{$link}' ".(!empty($onclick) ? 'onclick="'.$onclick.'"' : '')."><i class='{$icon}'></i> {$title}</a></li>";
    }

    public function datatables()
    {
        $data = array();
        $data['paging'] = false;
        $data['searching'] = false;
        $data['info'] = false;
        $data['order'] = array(
            array(
                0, 'desc',
            ),
        );
        $data['bStateSave'] = true;

        $data['select'] = true;

        ///return json_encode($data);

        return json_encode($data, JSON_FORCE_OBJECT);
    }
}
