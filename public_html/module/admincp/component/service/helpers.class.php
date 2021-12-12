<?php

defined('AIN') or exit('NO DICE!');

class admincp_service_helpers extends AIN_Service
{
    private $aMenus = [];

    public function __construct()
    {

    }


    public function selected_exist( $variable, $key, $val )
    {
        if (isset($variable) and isset($variable[$key]) and $variable[$key] == $val)
            return 'selected';
        else
            return '';
    }


    public function selected($v1, $v2)
    {
        if ($v1 == $v2)
            return 'selected';
        else
            return '';
    }

    public function getDimensions()
    {
        $select = [];
        $select[44] = "288x192";
        return $select;
    }
    public function getFormatTypes()
    {
        $select = [];
        $select[78] = AIN::getPhrase("adnetwork.ad_static_name_78");
        return $select;
    }

    public function getDimensionById($id)
    {
        $return = '';
        if ($id == 44)
            $return = "288x192";
        return $return;
    }
    public function getFormatTypeById($id)
    {
        $return = '';
        if ($id == 78)
            $return = AIN::getPhrase("adnetwork.ad_static_name_78");
        return $return;
    }

    public function getStatuses()
    {
        $select = [];
        $select[10] = AIN::getPhrase("adnetwork.ad_static_adset_status_10");
        $select[11] = AIN::getPhrase("adnetwork.ad_static_adset_status_11");
        $select[12] = AIN::getPhrase("adnetwork.ad_static_adset_status_12");
        $select[17] = AIN::getPhrase("adnetwork.ad_static_adset_status_17");
        $select[27] = AIN::getPhrase("adnetwork.ad_static_adset_status_27");
        $select[40] = AIN::getPhrase("adnetwork.ad_static_adset_status_40");
        return $select;
    }


    public function checkActiveRoute($route = null)
    {
        $request = $_SERVER['REQUEST_URI'];
        if ($route != null and str_contains($request, $route))
            return 'active';
        return '';
    }


    public function statsTypes()
    {
        $select = [];
        $select['get_spent_ad'] = AIN::getPhrase("adnetwork.get_spent_ad");
        $select['get_spent_site'] = AIN::getPhrase("adnetwork.get_spent_site");
        $select['get_spent_daily'] = AIN::getPhrase("adnetwork.get_spent_daily");
        $select['get_revenue_site'] = AIN::getPhrase("adnetwork.get_revenue_site");
        return $select;
    }



    public function file_url($file)
    {
        return "https://beta.azerforum.com/theme/frontend/afm/style/$file";
    }


    public function facebookData()
    {
        $fb = new \Facebook\Facebook([
            "app_id"                => "126108928148726",
            "app_secret"            => "25ba2dc16b67e7fddc82a1151fe70e17",
        ]);
        return $fb;
    }

    public function facebookLoginUrl()
    {
        $locale = AIN::getLib('locale')->getLang()[0]['language_id'];
        $fb = $this->facebookData();
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email']; // optional
        $loginUrl = $helper->getLoginUrl(AIN::getParam('adnetwork.site_url').'/'.$locale.'/facebook', $permissions);
        return $loginUrl;
    }


    public function user_image()
    {
        $img = getUserBy('image');
        if ($img) {
            $img = json_decode($img, true);
            if (isset($img['down_url']))
                return $img['down_url'];
        }
        return AIN::getParam('adnetwork.site_url').'/theme/frontend/afm/style/images/no-avatar.svg';

    }


    public function recaptcha_verify( $aVals )
    {
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_response = $aVals['recaptcha_response'];
        $recaptcha_secret = "6LfpZoEaAAAAAKoz0bnOhY4aO3i4DOG24a-HlYvv";
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);
        if ($recaptcha->success==true && isset($recaptcha->score) && $recaptcha->score >= 0.5)
            return true;
        return false;
    }


    public function customValidator($data, $fields)
    {
        $return = [];
        foreach ($fields as $item) {
            if($item['required'] == true){
                if (!isset($data[$item['field']]) or ( isset($data[$item['field']]) and strlen($data[$item['field']]) == 0))
                    $return[$item['field']][] = AIN::getPhrase("validation.required_error_".$item['field']);
            }

            if (isset($data[$item['field']])){
                if (isset($item['type'])) {
                    if (gettype($data[$item['field']]) != $item['type'])
                        $return[$item['field']][] = AIN::getPhrase("validation.type_error_".$item['field']);
                }

                if (isset($item['min'])) {
                    if (strlen($data[$item['field']]) < $item['min'])
                        $return[$item['field']][] = AIN::getPhrase("validation.min_error_".$item['field']);
                }
                if (isset($item['max'])) {
                    if (strlen($data[$item['field']]) > $item['max'])
                        $return[$item['field']][] = AIN::getPhrase("validation.max_error_".$item['field']);
                }
            }
        }
        return $return;
    }


    public function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public function imageUploadS3()
    {
        if( isset($_FILES['val']['tmp_name']) )
        {
            // var_dump($_FILES); die();
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");

            $fileName = date('Y-m')."/{$_FILES['val']['name']}";
            $dd['file_dir'] = $fileName;
            $dd = AIN::getLib('cdn')->put($_FILES['val']['tmp_name'], $fileName);
            if( isset($dd['status']) and $dd['status'] == 'success')
            {
                http_response_code(200);
                $url = $dd['data']['down_url'];
                $CKEditorFuncNum = $_GET['CKEditorFuncNum'];
//                $msg =  ' successfully uploaded: \\n- Size: '. number_format($_FILES['upload']['size']/1024, 2, '.', '') .' KB';
                $msg = '';
                return $dd['data'];
//                header('Content-type: text/html; charset=utf-8');
//                echo  "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            }
            else
            {
                header('Content-type: text/html; charset=utf-8');
                http_response_code(301);
                echo implode(',', $dd['messages']);
            }
        }

    }

}
