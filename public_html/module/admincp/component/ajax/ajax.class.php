<?php
/**
 * Class User_Component_Ajax_Ajax.
 */
class admincp_component_ajax_ajax extends AIN_Ajax
{

    public function fileUploadCkEditor()
    {
        if( isset($_FILES['upload']['tmp_name']) )
        {
            // var_dump($_FILES); die();
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");

            $fileName = date('Y-m')."/{$_FILES['upload']['name']}";
            $dd['file_dir'] = $fileName;
            $dd = AIN::getLib('cdn')->put($_FILES['upload']['tmp_name'], $fileName);
            if( isset($dd['status']) and $dd['status'] == 'success')
            {
                http_response_code(200);
                $url = $dd['data']['down_url'];
                $CKEditorFuncNum = $_GET['CKEditorFuncNum'];
//                $msg =  ' successfully uploaded: \\n- Size: '. number_format($_FILES['upload']['size']/1024, 2, '.', '') .' KB';
                $msg = '';
                header('Content-type: text/html; charset=utf-8');
                echo  "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            }
            else
            {
                header('Content-type: text/html; charset=utf-8');
                http_response_code(301);
                echo implode(',', $dd['messages']);
            }
        }
    }


    public function searchArticleTags()
    {
        $page = $_GET['page'];
        $opt = ['page' => $page, 'limit'=>10];
        $return = ['results' => [], 'pagination' => ['more' => false]];
        if(isset($_GET['search']))
            $opt['searchQuery'] = $_GET['search'];
        $data = AIN::getService('homdom.core')->homdom_get_article_tag($opt);
        if (isset($data['status']) and $data['status'] == 'success'){
            $count = $data['data']['count'];
            $rows = $data['data']['rows'];
            $more = false;
            if ($count > $page*10)
                $more = true;
            $names = array_column($rows,'phrase');
            $ids = array_column($rows,'id');
            $items = [];
            for ($i=0;$i<10;$i++){
                if (isset($ids[$i]))
                    $items[] = ['id'=>$ids[$i], 'text'=> $names[$i]];
            }
            $data = ['results' => $items, 'pagination' => ['more' => $more]];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }
        else{
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($return);
        }
    }


    public function massSettings()
    {
        return AIN::getBlock('admincp.massPage');

    }


}
