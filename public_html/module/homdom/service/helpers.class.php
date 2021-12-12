<?php

defined('AIN') or exit('NO DICE!');

class homdom_service_helpers extends AIN_Service
{
    private $aMenus = [];

    public function __construct()
    {
		$this->redis = AIN::getLib('redis');
    }

    public function getDefaultEntryCount()
    {
        $count = AIN::getLib('redis')->get('entry:count:user:'.AIN::getService('homdom.user')->getUserBy('user_id'));
        if(!$count)
            return 10;
        return $count;
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
        $select[78] = AIN::getPhrase("homdom.ad_static_name_78");
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
            $return = AIN::getPhrase("homdom.ad_static_name_78");
        return $return;
    }

    public function getStatuses()
    {
        $select = [];
        $select[9] = AIN::getPhrase("homdom.status_id_9");
        $select[10] = AIN::getPhrase("homdom.status_id_10");
        $select[11] = AIN::getPhrase("homdom.status_id_11");
        $select[12] = AIN::getPhrase("homdom.status_id_12");
//        $select[17] = AIN::getPhrase("homdom.ad_static_status_17");
//        $select[27] = AIN::getPhrase("homdom.ad_static_status_27");
//        $select[40] = AIN::getPhrase("homdom.ad_static_status_40");
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
        $select['get_spent_ad'] = AIN::getPhrase("homdom.get_spent_ad");
        $select['get_spent_site'] = AIN::getPhrase("homdom.get_spent_site");
        $select['get_spent_daily'] = AIN::getPhrase("homdom.get_spent_daily");
        $select['get_revenue_site'] = AIN::getPhrase("homdom.get_revenue_site");
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
        $loginUrl = $helper->getLoginUrl(AIN::getParam('homdom.site_url').'/'.$locale.'/facebook', $permissions);
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
        return AIN::getParam('homdom.site_url').'/theme/frontend/afm/style/images/no-avatar.svg';

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
            if($item['required'] == true and $item['type'] != 'array'){
                if (!isset($data[$item['field']]) or ( isset($data[$item['field']]) and strlen($data[$item['field']]) == 0))
                    $return[$item['field']][] = AIN::getPhrase("homdom.required_error_".$item['field']);
            }
            elseif($item['required'] == true and $item['type'] == 'array') {
                if (!isset($data[$item['field']]) or ( isset($data[$item['field']]) and count($data[$item['field']]) == 0))
                    $return[$item['field']][] = AIN::getPhrase("homdom.required_error_".$item['field']);
            }

            if (isset($data[$item['field']])){

                if (isset($item['type'])) {
                    if (gettype($data[$item['field']]) != $item['type'])
                        $return[$item['field']][] = AIN::getPhrase("homdom.type_error_".$item['field']);
                }

                if (isset($item['min'])) {
                    if (strlen($data[$item['field']]) < $item['min'])
                        $return[$item['field']][] = AIN::getPhrase("homdom.min_error_".$item['field']);
                }
                if (isset($item['max'])) {
                    if (strlen($data[$item['field']]) > $item['max'])
                        $return[$item['field']][] = AIN::getPhrase("homdom.max_error_".$item['field']);
                }
                if (isset($item['not_equal'])){
                    if ($data[$item['field']] == $item['not_equal'])
                        $return[$item['field']][] = AIN::getPhrase("homdom.error_".$item['field']);

                }
            }
        }
        return $return;
    }


    public function slugify($text, string $divider = '-')
    {
        $replace = [
            '&lt;' => '', '&gt;' => '', '&#039;' => '', '&amp;' => '',
            '&quot;' => '', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'Ae',
            '&Auml;' => 'A', 'Å' => 'A', 'Ā' => 'A', 'Ą' => 'A', 'Ă' => 'A', 'Æ' => 'Ae',
            'Ç' => 'C', 'Ć' => 'C', 'Č' => 'C', 'Ĉ' => 'C', 'Ċ' => 'C', 'Ď' => 'D', 'Đ' => 'D',
            'Ð' => 'D', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ē' => 'E',
            'Ę' => 'E', 'Ě' => 'E', 'Ĕ' => 'E', 'Ė' => 'E', 'Ĝ' => 'G', 'Ğ' => 'G',
            'Ġ' => 'G', 'Ģ' => 'G', 'Ĥ' => 'H', 'Ħ' => 'H', 'Ì' => 'I', 'Í' => 'I',
            'Î' => 'I', 'Ï' => 'I', 'Ī' => 'I', 'Ĩ' => 'I', 'Ĭ' => 'I', 'Į' => 'I',
            'İ' => 'I', 'Ĳ' => 'IJ', 'Ĵ' => 'J', 'Ķ' => 'K', 'Ł' => 'K', 'Ľ' => 'K',
            'Ĺ' => 'K', 'Ļ' => 'K', 'Ŀ' => 'K', 'Ñ' => 'N', 'Ń' => 'N', 'Ň' => 'N',
            'Ņ' => 'N', 'Ŋ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O',
            'Ö' => 'Oe', '&Ouml;' => 'Oe', 'Ø' => 'O', 'Ō' => 'O', 'Ő' => 'O', 'Ŏ' => 'O',
            'Œ' => 'OE', 'Ŕ' => 'R', 'Ř' => 'R', 'Ŗ' => 'R', 'Ś' => 'S', 'Š' => 'S',
            'ş' => 'S', 'Ŝ' => 'S', 'Ș' => 'S', 'Ť' => 'T', 'Ţ' => 'T', 'Ŧ' => 'T',
            'Ț' => 'T', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'Ue', 'Ū' => 'U',
            '&Uuml;' => 'Ue', 'Ů' => 'U', 'Ű' => 'U', 'Ŭ' => 'U', 'Ũ' => 'U', 'Ų' => 'U',
            'Ŵ' => 'W', 'Ý' => 'Y', 'Ŷ' => 'Y', 'Ÿ' => 'Y', 'Ź' => 'Z', 'Ž' => 'Z',
            'Ż' => 'Z', 'Þ' => 'T', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a',
            'ä' => 'ae', '&auml;' => 'ae', 'å' => 'a', 'ā' => 'a', 'ą' => 'a', 'ă' => 'a',
            'æ' => 'ae', 'ç' => 'c', 'ə' => 'e', 'Ə' => 'E', 'ć' => 'c', 'č' => 'c', 'ĉ' => 'c', 'ċ' => 'c',
            'ď' => 'd', 'đ' => 'd', 'ð' => 'd', 'è' => 'e', 'é' => 'e', 'ê' => 'e',
            'ë' => 'e', 'ē' => 'e', 'ę' => 'e', 'ě' => 'e', 'ĕ' => 'e', 'ė' => 'e',
            'ƒ' => 'f', 'ĝ' => 'g', 'ğ' => 'g', 'ġ' => 'g', 'ģ' => 'g', 'ĥ' => 'h',
            'ħ' => 'h', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ī' => 'i',
            'ĩ' => 'i', 'ĭ' => 'i', 'į' => 'i', 'ı' => 'i', 'ĳ' => 'ij', 'ĵ' => 'j',
            'ķ' => 'k', 'ĸ' => 'k', 'ł' => 'l', 'ľ' => 'l', 'ĺ' => 'l', 'ļ' => 'l',
            'ŀ' => 'l', 'ñ' => 'n', 'ń' => 'n', 'ň' => 'n', 'ņ' => 'n', 'ŉ' => 'n',
            'ŋ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'oe',
            '&ouml;' => 'oe', 'ø' => 'o', 'ō' => 'o', 'ő' => 'o', 'ŏ' => 'o', 'œ' => 'oe',
            'ŕ' => 'r', 'ř' => 'r', 'ŗ' => 'r', 'š' => 's', 'ù' => 'u', 'ú' => 'u',
            'û' => 'u', 'ü' => 'u', 'ū' => 'u', '&uuml;' => 'u', 'ů' => 'u', 'ű' => 'u',
            'ŭ' => 'u', 'ũ' => 'u', 'ų' => 'u', 'ŵ' => 'w', 'ý' => 'y', 'ÿ' => 'y',
            'ŷ' => 'y', 'ž' => 'z', 'ż' => 'z', 'ź' => 'z', 'þ' => 't', 'ß' => 'ss',
            'ſ' => 'ss', 'ый' => 'iy', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G',
            'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I',
            'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F',
            'Х' => 'H', 'Ц' => 'C', 'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SCH', 'Ъ' => '',
            'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA', 'а' => 'a',
            'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
            'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l',
            'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's',
            'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e',
            'ю' => 'yu', 'я' => 'ya'
        ];
        $text = str_replace(array_keys($replace), $replace, $text);
        
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


    public function checkedIfExist($aForms, $key, $value) {
        if(isset($aForms[$key]) and $aForms[$key] == $value) {
            return "checked";
        }
        return '';
    }


    public function checkedIfInArray($aForms, $key, $value) {
        if(isset($aForms[$key]) and in_array($value,$aForms[$key])) {
            return "checked";
        }
        return '';
    }

    public function getValueOfInput($aForms, $key) {
        if(isset($aForms[$key])) {
            return $aForms[$key];
        }
        return '';
    }


    public function getValueOfArray($aForms, $arr, $key) {
        if (is_array($aForms) and isset($aForms[$arr]) and isset($aForms[$arr][$key])) {
            return $aForms[$arr][$key];
        }
        return '';
    }


    public function checkedIfInExistValue($aForms, $arr, $key, $value) {
        if(is_array($aForms) and isset($aForms[$arr]) and isset($aForms[$arr][$key]) and $aForms[$arr][$key] == $value) {
            return "checked";
        }
        return '';
    }


    public function imageUploadS3($key)
    {
        if( isset($_FILES[$key]['tmp_name']) )
        {
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");

            $fileName = date('Y/m/d')."/{$_FILES[$key]['name']}";
            $dd['file_dir'] = $fileName;
            $dd = AIN::getLib('cdn')->put($_FILES[$key]['tmp_name'], $fileName);
            if( isset($dd['status']) and $dd['status'] == 'success')
            {
                http_response_code(200);
                $url = $dd['data']['down_url'];
//                $CKEditorFuncNum = $_GET['CKEditorFuncNum'];
//                $msg =  ' successfully uploaded: \\n- Size: '. number_format($_FILES['upload']['size']/1024, 2, '.', '') .' KB';
//                $msg = '';
                return $url;
//                header('Content-type: text/html; charset=utf-8');
//                echo  "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            }
            else
            {
                header('Content-type: text/html; charset=utf-8');
                http_response_code(301);
//                echo implode(',', $dd['messages']);
                return '';
            }
        }

    }


    public function CalculateDate($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
        $string = array(
            'y' => 'il',
            'm' => 'ay',
            'w' => 'həftə',
            'd' => 'gün',
            'h' => 'saat',
            'i' => 'dəqiqə',
            // 's' => 'saniyə',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' əvvəl' : 'İndicə';
    }


    public function offerToArray($offer){
        if ($offer['room_space'] == null)
            $offer['room_space'] = [];
        else
            $offer['room_space'] = (array) json_decode($offer['room_space']);

        if ($offer['image'] == null)
            $offer['image'] = [];
        else
            $offer['image'] = (array) json_decode($offer['image']);

        if ($offer['targets'] == null)
            $offer['targets'] = [];
        else
            $offer['targets'] = (array) json_decode($offer['targets']);

        if ($offer['video'] == null)
            $offer['video'] = [];
        else
            $offer['video'] = (array) json_decode($offer['video']);

        if ($offer['structure_images'] == null)
            $offer['structure_images'] = [];
        else
            $offer['structure_images'] =  (array) json_decode($offer['structure_images']);

        if ($offer['utilities'] == null)
            $offer['utilities'] = [];
        else
            $offer['utilities'] = (array)  json_decode($offer['utilities']);

        if ($offer['lift'] == null)
            $offer['lift'] = [];
        else
            $offer['lift'] = (array)  json_decode($offer['lift']);
        if ($offer['window_view'] == null)
            $offer['window_view'] = [];
        else
            $offer['window_view'] = (array)  json_decode($offer['window_view']);


        $images = [];
        foreach ($offer['image'] as $img) {
            if (str_contains($img, 'cdn.homdom.az')) {
                $images[] = $img;
            }
        }
        $offer['image'] = $images;

        return $offer;
    }

    public function offerPageTitle($offer)
    {
        if ($offer['offer_type'] == 1)
            $offer['offer_type'] = 'sale';
        else
            $offer['offer_type'] = 'rent';

        $title = '';
        if ($offer['property_type_id'] == 1) {
            $title = $offer['offer_type'].'_rooms_'.$offer['building_type'];
        }
        else if ($offer['property_type_id'] == 2) {
            $title = 'home_'.$offer['offer_type'].'_rooms';
        }
        else if ($offer['property_type_id'] == 3) {
            $title = 'land_'.$offer['offer_type'];
        }
        else if ($offer['property_type_id'] == 5) {
            $title = 'office_'.$offer['offer_type'];
        }
        else if ($offer['property_type_id'] == 6) {
            $title = 'object_'.$offer['offer_type'];
        }
        else if ($offer['property_type_id'] == 4) {
            $title = 'garage_'.$offer['offer_type'];
        }

        return $title;
    }

    public function getOfferDistrict($offer)
    {
        if ($offer['metro_id'] > 0) {
            return AIN::getPhrase('homdom.'.$offer['metro_title']);
        }
        if ($offer['locality_id'] > 0) {
            return AIN::getPhrase('homdom.'.$offer['locality_title']);
        }
        if($offer['district_id'] > 0) {
            return AIN::getPhrase('homdom.'.$offer['district_title']);
        }
        return '';
    }

    public function getOfferTitle($aRow){
        $title = '';
        $district = AIN::getService('homdom.helpers')->getOfferDistrict($aRow);
        if ($district == '')
            $concat = '';
        else
            $concat = ", ".$district;

        if ($aRow['property_type_id'] == 1)
            $title = sprintf(AIN::getPhrase('homdom.'.AIN::getService('homdom.helpers')->offerPageTitle($aRow)), $aRow['room_count']).$concat;
        elseif ($aRow['property_type_id'] == 2)
            $title = sprintf(AIN::getPhrase('homdom.'.AIN::getService('homdom.helpers')->offerPageTitle($aRow)), $aRow['room_count']).$concat;
        elseif ($aRow['property_type_id'] == 3)
            $title = sprintf(AIN::getPhrase('homdom.'.AIN::getService('homdom.helpers')->offerPageTitle($aRow)), $aRow['area']).$concat;
        elseif ($aRow['property_type_id'] == 5)
            $title = sprintf(AIN::getPhrase('homdom.'.AIN::getService('homdom.helpers')->offerPageTitle($aRow)), $aRow['area']).$concat;
        elseif ($aRow['property_type_id'] == 6)
            $title = sprintf(AIN::getPhrase('homdom.'.AIN::getService('homdom.helpers')->offerPageTitle($aRow)), $aRow['area']).$concat;
        elseif ($aRow['property_type_id'] == 4)
            $title = sprintf(AIN::getPhrase('homdom.'.AIN::getService('homdom.helpers')->offerPageTitle($aRow)), $aRow['area']).$concat;
        return $title;
    }

    public function getOfferAnounceDate($date){
        $date = explode(' ', $date);
        $date = explode('-', $date[0]);
        return $date[2].'.'.$date[1].'.'.$date[0];
    }



    public function isFavorityOffer($offer_id){
        if( ! AIN::isUser() )
            return '';
        else {
            $user_id = getUserBy('user_id');
            $fav = AIN::getService('homdom.core')->homdom_get_favority(['user_id' => $user_id, 'offer_id' => $offer_id]);
            if (isset($fav['status']) and $fav['status'] == 'success' and $fav['data']['count'] == 1){
                return 'active';
            }
            return '';
        }
    }


    public function siteLanguages()
    {
        return ['az', 'en', 'ru'];
    }

    public function getPhraseTranslation($phrase)
    {
        $translations = ['az'=>'', 'en' => '', 'ru' => ''];
        if ($phrase != null) {
            $aRows = AIN::getService('homdom.core')->get_langauage_phrase(['var_name' => $phrase]);
            if ('success' == $aRows['status'] and $aRows['data']['count'] > 0) {
                foreach ($aRows['data']['rows'] as $row) {
                    if ($row['language_id'] == 'ru')
                        $translations['ru'] = $row['text'];
                    elseif ($row['language_id'] == 'az')
                        $translations['az'] = $row['text'];
                    elseif ($row['language_id'] == 'en')
                        $translations['en'] = $row['text'];
                }
            }
        }
        return $translations;
    }


    public function redisTargets()
    {
        $targets = AIN::getLib('redis')->hgetall("targets");
        if (!$targets) {
            $targetRows = AIN::getService('homdom.core')->homdom_get_target(['limit'=>400, 'status_id' => 11]);
            $targetRows = $targetRows['data']['rows'];
            $targets = [];
            foreach ($targetRows as $val) {
                $letter = strtoupper(substr($val['phrase'], 0, 1));
                $letter = utf8_encode($letter);
                if ($letter == "Å")
                    $letter = "Ş";
                elseif($letter == 'Ä')
                    $letter = 'İ';
                if (!isset($targets[$letter]))
                    $targets[$letter] = [];
                $targets[$letter][$val['id']] = $val['phrase'];
            }
            foreach ($targets as $key=>$val) {
                $targets[$key] = json_encode($val);
            }
            AIN::getLib('redis')->hmset("targets", $targets);
        }

        foreach ($targets as $key=>$val){
            $targets[$key] = json_decode($val, true);
        }
        ksort($targets);

        return $targets;
    }

    public function redisMetros()
    {
        $metros = AIN::getLib('redis')->hgetall("metros");
        if (!$metros) {
            $metroRows = AIN::getService('homdom.core')->homdom_get_metro(['limit'=>400, 'status_id' => 11]);
            $metroRows = $metroRows['data']['rows'];
            $metros = [];
            foreach ($metroRows as $val) {
                $letter = strtoupper(substr($val['phrase'], 0, 1));
                $letter = utf8_encode($letter);
                if ($letter == "Å")
                    $letter = "Ş";
                elseif($letter == 'Ä')
                    $letter = 'İ';
                if (!isset($metros[$letter]))
                    $metros[$letter] = [];
                $metros[$letter][$val['id']] = $val['phrase'];
            }
            foreach ($metros as $key=>$val)
                $metros[$key] = json_encode($val);
            AIN::getLib('redis')->hmset("metros", $metros);
        }
        foreach ($metros as $key=>$val)
            $metros[$key] = json_decode($val, true);
        unset($metros[8]);
        ksort($metros);
        $ms = [];
        $ms[2] = $metros[2];
        foreach ($metros as $k=>$m)
            $ms[$k] = $m;

        return $ms;
    }

    public function sortByAlphabet($items)
    {
        $response = [];
        foreach ($items as $val) {
            $letter = strtoupper(substr($val['phrase'], 0, 1));
            $letter = utf8_encode($letter);
            if ($letter == "Å")
                $letter = "Ş";
            elseif($letter == 'Ä')
                $letter = 'İ';
            if (!isset($response[$letter]))
                $response[$letter] = [];
            $response[$letter][$val['id']] = $val['phrase'];
        }
        ksort($response);

        return $response;
    }


    public function redisLocalities()
    {
        $localities = AIN::getLib('redis')->hgetall("localities");
        if (!$localities) {
            $localityRows = AIN::getService('homdom.core')->homdom_get_locality(['limit'=>400, 'status_id' => 11]);
            $localityRows = $localityRows['data']['rows'];
            $localities = [];
            foreach ($localityRows as $val) {
                $key = $val['district_name'];
                if (!isset($localities[$key]))
                    $localities[$key] = [];
                $localities[$key][$val['id']] = $val['phrase'];
            }
            foreach ($localities as $key=>$val) {
                $localities[$key] = json_encode($val);
            }
            AIN::getLib('redis')->hmset("localities", $localities);
        }

        foreach ($localities as $key=>$val){
            $localities[$key] = json_decode($val, true);
        }
        ksort($localities);
        return $localities;
    }

    public function redisCommercialTypes()
    {
        $items = AIN::getLib('redis')->hgetall("commercial_types");
        $items = false;
        if (!$items) {
            $itemRows = AIN::getService('homdom.core')->homdom_get_offer_type(['limit'=>400, 'status_id' => 11]);
            $itemRows = $itemRows['data']['rows'];
            $items = [];
            foreach ($itemRows as $i) {
                $items[] = json_encode($i);
            }
            AIN::getLib('redis')->hmset("commercial_types", $items);
        }
        return $items;
    }


    public function activeInArray($array,$key, $value)
    {
        if (isset($array[$key]) and in_array($value, $array[$key]))
            return 'active';
        return '';
    }


    public function getTargetById($id)
    {
        $target = AIN::getLib('redis')->hgetall("target:id:$id");
        if ($target == null) {
            $targetRow = AIN::getService('homdom.core')->homdom_get_target(['id'=>$id, 'status_id' => 11]);
            if (isset($targetRow['status']) and $targetRow['status'] == 'success' and count($targetRow['data']['rows']) == 1) {
                $target = $targetRow['data']['rows'][0];
                AIN::getLib('redis')->hmset("target:id:$id", $target);
            }
            else
                return false;
        }
        return $target;
    }


    public function getLocalityById($id)
    {
        $locality = AIN::getLib('redis')->hgetall("locality:id:$id");
        if ($locality == null) {
            $localityRow = AIN::getService('homdom.core')->homdom_get_locality(['id'=>$id, 'status_id' => 11]);
            if (isset($localityRow['status']) and $localityRow['status'] == 'success' and count($localityRow['data']['rows']) == 1) {
                $locality = $localityRow['data']['rows'][0];
                AIN::getLib('redis')->hmset("lcoality:id:$id", $locality);
            }
            else
                return false;
        }
        return $locality;
    }

    public function getDistrictById($id)
    {
        if ($id == 0)
            return false;
        $district = AIN::getLib('redis')->hgetall("district:id:$id");
        if ($district == null) {
            $districtRow = AIN::getService('homdom.core')->homdom_get_district(['id'=>$id, 'status_id' => 11]);
            if (isset($districtRow['status']) and $districtRow['status'] == 'success' and count($districtRow['data']['rows']) == 1) {
                $district = $districtRow['data']['rows'][0];
                AIN::getLib('redis')->hmset("district:id:$id", $district);
            }
            else
                return false;
        }
        return $district;
    }

    public function getComplexById($id)
    {
        $complex = AIN::getLib('redis')->hgetall("complex:id:$id");
        if ($complex == null) {
            $complexRow = AIN::getService('homdom.core')->homdom_get_complex(['id'=>$id, 'status_id' => 11]);
            if (isset($complexRow['status']) and $complexRow['status'] == 'success' and count($complexRow['data']['rows']) == 1) {
                $complex = $complexRow['data']['rows'][0];
                AIN::getLib('redis')->hmset("complex:id:$id", $complex);
                AIN::getLib('redis')->expire("complex:id:$id", '7200');
            }
            else
                return false;
        }
        return $complex;
    }


    public function getOfferById($id)
    {
        $offer = AIN::getLib('redis')->hgetall("offer:id:$id");
        if ($offer == null) {
            $offerRow = AIN::getService('homdom.core')->homdom_get_offer(['id'=>$id, 'status_id' => 11]);
            if (isset($offerRow['status']) and $offerRow['status'] == 'success' and count($offerRow['data']['rows']) == 1) {
                $offer = $offerRow['data']['rows'][0];
                AIN::getLib('redis')->hmset("offer:id:$id", $offer);
            }
            else
                return false;
        }
        $offer = $this->offerToArray($offer);
        return $offer;
    }


    public function getMetroById($id)
    {
        $metro = AIN::getLib('redis')->hgetall("metro:id:$id");
        if ($metro == null) {
            $metroRow = AIN::getService('homdom.core')->homdom_get_metro(['id'=>$id, 'status_id' => 11]);
            if (isset($metroRow['status']) and $metroRow['status'] == 'success' and count($metroRow['data']['rows']) == 1) {
                $metro = $metroRow['data']['rows'][0];
                AIN::getLib('redis')->hmset("metro:id:$id", $metro);
            }
            else
                return false;
        }
        return $metro;
    }

    public function getBuildingById($id)
    {
        $item = AIN::getLib('redis')->hgetall("building:id:$id");
        if ($item == null) {
            $itemRow = AIN::getService('homdom.core')->homdom_get_building(['id'=>$id, 'status_id' => 11]);
            if (isset($itemRow['status']) and $itemRow['status'] == 'success' and count($itemRow['data']['rows']) == 1) {
                $item = $itemRow['data']['rows'][0];
                AIN::getLib('redis')->hmset("building:id:$id", $item);
            }
            else
                return false;
        }
        return $item;
    }




    public function headerMenu()
    {
        $menus = AIN::getLib('redis')->hgetall('menus:header');
        if (!$menus) {
            $menuRows = AIN::sendApi('get_menu', ['status_id' => 11, 'type' => 0, 'limit' => 100]);
            if (isset($menuRows['data']) and $menuRows['data']['rows']){
                $menus = $menuRows['data']['rows'];
                $n_menus = [];
                $locale = AIN::getLib('locale')->getLang()[0]['language_id'];
                foreach ($menus as $menu) {
                    $menu['title'] = (array) json_decode($menu['title']);
                    $menu['title'] = $menu['title'][$locale];
                    $n_menus[$menu['id']] = json_encode(['link' => $menu['link'], 'title' => $menu['title']]);
                }
                $menus = $n_menus;
                AIN::getLib('redis')->del('menus:header');
                AIN::getLib('redis')->hmset('menus:header', $menus);
            }
            else{
                $menus = [];
            }
        }
        ksort($menus);
        $r_menus = [];
        foreach ($menus as $menu) {
            $r_menus[] = (array) json_decode($menu);
        }

        return $r_menus;
    }


    public function footerMenu()
    {
        $menus = AIN::getLib('redis')->hgetall('menus:footer');
//        $menus = false;
        if (!$menus) {
            $locale = AIN::getLib('locale')->getLang()[0]['language_id'];
            $parents = AIN::sendApi('get_menu', ['status_id' => 11, 'type' => 1,'menu_id' => 0,  'limit' => 100]);
            if (isset($parents['data']) and isset($parents['data']['rows'])) {
                $parentMenus = $parents['data']['rows'];

                foreach ($parentMenus as $parent) {
                    $parent['title'] = (array) json_decode($parent['title']);
                    $parent['title'] = $parent['title'][$locale];
                    $items = [];
                    $p = [
                        'title' => $parent['title'],
                        'link'  => $parent['link'],
                    ];

                    $itemRows = AIN::sendApi('get_menu', ['status_id' => 11, 'type' => 1,'menu_id' => $parent['id'],  'limit' => 100]);
                    if (isset($itemRows['data']) and isset($itemRows['data']['rows'])) {
                        foreach ($itemRows['data']['rows'] as $menu) {
                            $menu['title'] = (array) json_decode($menu['title']);
                            $menu['title'] = $menu['title'][$locale];
                            $items[] = json_encode(['link' => $menu['link'], 'title' => $menu['title']]);
                        }
                    }
                    if (count($items) > 0) {
                        $p['items'] = json_encode($items);
                    }
                    $menus[] = $p;
                }
            }

        }
        $n_menus = [];
        foreach ($menus as $menu) {
            if (isset($menu['items'])){
                $menu['items'] = (array) json_decode($menu['items']);
                $items = [];
                foreach ($menu['items'] as $i)
                    $items[] = (array) json_decode($i);
                $menu['items'] = $items;
            }
            else{
                $menu['items'] = [];
            }
            $n_menus[] = $menu;
        }
        return $n_menus;
    }



    public function build_main_map()
    {
        $map = "<sitemapindex xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\n";
        //$map .= $this->getCategorys();
        $map .= $this->getMainMapMenu();
        $map .= "</sitemapindex>";

        return $map;
    }



    
    public function getMainMapMenu()
    {
        $menus = [
          'offers', 'articles','pages', 'complexes', 'agencies'
        ];

        $xml = '';
        foreach ($menus as $menu) {
            $xml .= "\t<sitemap>\n";
            $xml .= "\t\t<loc>https://homdom.az/sitemap/$menu.xml</loc>\n";
            $xml .= "\t\t<lastmod>".date('Y-m-d')."</lastmod>\n";
            $xml .= "\t\t<changefreq>never</changefreq>\n";
            $xml .= "\t\t<priority>1</priority>\n";
            $xml .= "\t</sitemap>\n";
        }

        return $xml;

    }


    public function buildMap($method = 'homdom_get_article', $year=2020, $month=1, $day=1)
    {
        $map = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $map.= $this->siteMap($method, $year, $month, $day);
        $map .= '</urlset>';
        return $map;
    }


    public function siteMap($method, $year, $month, $day)
    {

    }


    public function userProfilePhoto()
    {
        if (!auth())
            return $this->defaultProfilePhoto();
        if (getUserBy('image') != null)
            return getUserBy('image');
        else
            return $this->defaultProfilePhoto();
    }


    public function defaultProfilePhoto()
    {
        return '/theme/frontend/homdom/style/img/default.png';
    }

    

    public function imageResize($image, $width=600, $height=340)
    {
        if (str_contains($image, 'cdn.homdom')) {
            $image = stripslashes($image);
            $image = explode('/', $image);
            $image = array_reverse($image);
            $filename = $image[3].'/'.$image[2].'/'.$image[1].'/'.$image[0];
            $filename = "/media/".$width.'x'.$height.'/'.$filename;
            return $filename;
        }
        else{
            return $image;
        }
    }
	
	
	
	public function index( $params = array() )
	{
		$cacheSet = "homdom:index";
		if( ( $aRows = $this->redis->get($cacheSet)) and ! isset($params['nocache'])  )
		{
			$data = json_decode($aRows, true);
			return $data;
		}
		else 
		{
			$data = array();
			
			$last_offers = AIN::getService('homdom.core')->homdom_get_offer(['status_id' =>11, 'limit' => 4])['data']['rows'];
			$rent_offer_raws = AIN::getService('homdom.core')->homdom_get_offer(['status_id' =>11, 'limit' => 4, 'offer_type' => 2]);
			$rent_offers = [];
			if (isset($rent_offer_raws['data']['rows']))
				$rent_offers = $rent_offer_raws['data']['rows'];
			$house_offers = [];
			$house_offer_raws = AIN::getService('homdom.core')->homdom_get_offer(['status_id' =>11, 'limit' => 4, 'property_type_id' => 2]);
			if (isset($house_offer_raws['data']['rows']))
				$house_offers = $house_offer_raws['data']['rows'];

			for ($i=0; $i<=3; $i++){
				if (isset($last_offers[$i]))
					$last_offers[$i] = $offer = AIN::getService('homdom.helpers')->offerToArray($last_offers[$i]);
				if (isset($rent_offers[$i]))
					$rent_offers[$i] = $offer = AIN::getService('homdom.helpers')->offerToArray($rent_offers[$i]);
				if (isset($house_offers[$i]))
					$house_offers[$i] = $offer = AIN::getService('homdom.helpers')->offerToArray($house_offers[$i]);
			}

			$complex_rows = AIN::getService('homdom.core')->homdom_get_complex(['status_id' => 11, 'limit' => 3]);
			$complexes = [];
			if ($complex_rows['status'] == 'success' and isset($complex_rows['data']) and isset($complex_rows['data']['rows']))
				$complexes = $complex_rows['data']['rows'];
			
			$data = [
				'last_offers' => $last_offers,
				'complexes' => $complexes,
				'rent_offers' => $rent_offers,
				'house_offers' => $house_offers
			];		

			$this->redis->set($cacheSet, json_encode($data));			
			$this->redis->expire($cacheSet, 7200 );				
			
			$this->redis->sadd('homdom_cache', $cacheSet);	
		}	
		
		return $data;
	}



    public function getSitemapPage($req1, $req2)
    {
        if ($req1 == 'sitemap.xml')
            return AIN::getLib('module')->setController('homdom.sitemap.index');

       $sitemapMenu = ['offers.xml', 'articles.xml', 'pages.xml', 'complexes.xml', 'agencies.xml'];


        if ($req1 = 'sitemap' and in_array($req2, $sitemapMenu)) {
            $req2 = explode('.', $req2)[0];
            return AIN::getLib('module')->setController('homdom.sitemap.'.$req2);
        }

        return false;
    }
}
