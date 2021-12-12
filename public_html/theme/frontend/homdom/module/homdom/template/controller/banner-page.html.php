<!DOCTYPE html>
<html lang="en">
<head>
    <?php $sections = $this->_aVars['sections'] ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informer Inner</title>
    <!-- Owl Stylesheets -->
	<link rel="stylesheet" href="https://homdom.az/theme/frontend/homdom/style/css/owl.carousel.min.css">
	<link rel="stylesheet" href="https://homdom.az/theme/frontend/homdom/style/css/owl.theme.default.min.css">

    <script src="https://homdom.az/theme/frontend/homdom/style/js/jquery-3.4.1.min.js"></script>
    <style>
        * {box-sizing: border-box;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;}
        a{text-decoration: none;}

        li{display: inline-block; margin-right: 14px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}
        h5.infomr_title{
           height: 45px; margin: 10px 0px;padding: 10px 10px 10px 0px;text-align: left;font-size: 24px;line-height: 1.1;font-family: 'Montserrat', Arial;
           color:<?=$sections['title_color']?>; background-color: <?=$sections['title_bg_color']?>;
        }
        h3.inform_in_title {
            background-color: <?=$sections['offer_title_bg_color']?>; padding: 10px;  position: relative;
            font-size: 15px; color: <?=$sections['offer_title_color']?>; line-height: 20px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        }

        ul{ list-style: none; padding: 0; margin: 0; color: #000000;}
        ul li{ list-style: none;}
        .inform_in_block { display: block;width: 100%;}
        .inform_in_block.horizontal{float: none; width: 100%;}
        .inform_in_block.vertical {width: 250px;float: left;}
        .inform_in_title_full {flex: 1;position: relative;}
        .inform_in_list { width: 100%; padding: 5px 5px; background-color: #f0c1c1; }
        .announce_items {display: block; width: 100%; padding: 0 0px 0px 0px; }

        .announce_items_link {display: block;  width: 100%;  padding: 0 0px 17px 0px;  border-bottom: 1px solid #DADCE0;  transition: all 0.3s ease-in-out;}
        .announce_items_link:hover .announce_img img {transform: scale(1.03);}
        .announce_items_link:hover {box-shadow: inset 0px 0px 7px 7px #2196f325;-webkit-box-shadow: inset 0px 0px 7px 7px #2196f325;border-color: #2196f3;}
        .announce_items_link:hover .announce_img::after {visibility: visible; opacity: 1;}
        .announce_img::after {content: "";display: block;visibility: hidden;width: 100%;height: 100%;position: absolute;top: 0;left: 0;background-color: #0e101336;z-index: 0;opacity: 0;transition: all 0.3s ease;}
        .announce_img::before {content: "";display: block;width: 100%;padding-top: 56%;position: relative;}
        .announce_img {display: block;width: 100%;position: relative;overflow: hidden;}
        .announce_img img {display: block;width: 100%;height: 100%;position: absolute;top: 0;bottom: 0;left: 0;right: 0;object-fit: cover;transition: all 0.3s ease-in-out;}
        .announce_info {display: block;width: 100%;padding: 10px 0 0 0;transition: all 0.3s ease-in-out;}
        .announce_adrs {display: block;width: 100%;padding-bottom: 4px;text-align: left;font-family: 'Montserrat';font-size: 16px;font-weight: 600;line-height: 19px;letter-spacing: 0px;color: #0E1013;opacity: 1;word-break: break-all;}
        .announce_text {display: block;width: 100%;text-align: left;font-family: 'Montserrat';font-size: 14px;font-weight: normal;line-height: 18px;letter-spacing: 0px;color: #5F6368;opacity: 1;word-break: break-word;overflow: hidden;text-overflow: ellipsis;-webkit-box-orient: vertical;display: -webkit-box;-webkit-line-clamp: 3;}
        .announce_text sup {position: relative;top: -3px;font-family: 'Montserrat';font-size: 10px;font-weight: normal;line-height: 12px;}
        .announce_date {display: block;width: 100%;padding-top: 10px;text-align: left;font-family: 'Montserrat';font-size: 12px;font-weight: normal;line-height: 15px;letter-spacing: 0px;color: #9AA0A6;opacity: 1;}

        .announce_catg{display: inline-flex;justify-content: center;align-items: center;padding: 6px 10px;background-color: #2196F3;border-top-right-radius: 5px;text-align: center;font-family: 'Montserrat';font-size: 14px;font-weight: 600;line-height: 18px;letter-spacing: 0px;color: #ffffff;opacity: 1;position:absolute;bottom: 0;left: 0;z-index: 1;}
        .owl-theme .owl-dots {display: none;}
        .owl-nav button span {display: none !important;}

        .owl-theme .owl-nav {margin-top: 0px;position: absolute;width: 100%;top: -50px;right: 0;}
        .owl-theme .owl-nav .disabled { opacity: 0.7;cursor: default;}
        .owl-nav button.owl-prev {width: 24px !important;height: 24px !important;background-color: #2096f3 !important;background-image: url("https://homdom.az/theme/frontend/homdom/style/img/pagin_prev.svg") !important;background-repeat: no-repeat !important;background-size: 10px 10px !important;background-position: center !important;margin-right: 5px !important;border-radius: 50% !important;position: absolute;left: auto;right: 30px;z-index: 1;}

        .owl-nav button.owl-next {width: 24px !important;height: 24px !important;background-color: #2096f3 !important;background-image: url("https://homdom.az/theme/frontend/homdom/style/img/pagin_next.svg") !important;background-repeat: no-repeat !important;background-size: 10px 10px !important;background-position: center !important;border-radius: 50% !important;position: absolute;right: 0px;transition: all 0.3s ease;z-index: 1;}
        .owl-nav button.owl-prev:hover, .owl-nav button.owl-next:hover {background-color: #0c74c7 !important;}
    </style>
</head>
<body>
<div class="tasks-list-container">
    <?php if (isset($sections['block_title'])) { ?>
        <h5 class="infomr_title"><?=$sections['block_title']?></h5>
    <?php } ?>
    <div class="owl-carousel owl-theme">
        <?php foreach ($this->_aVars['offers'] as $item) { ?>
            <div class="item">
                <div class="announce_items">
                    <a href="https://homdom.az/offer/<?=$item['id']?>" target="_blank" class="announce_items_link">
                        <div class="announce_img">
                            <img src="<?=(count($item['image'])>0 and isset($item['image'][0])) ? $item['image'][0] : '/theme/frontend/homdom/style/img/news_3.jpg' ?>">
                            <div class="announce_catg"><?=$item['price']?> ₼ </div>
                        </div>
                        <div class="announce_info">
                            <div class="announce_adrs"><?=(AIN::getService('homdom.helpers')->getOfferDistrict($item) != '') ? AIN::getService('homdom.helpers')->getOfferDistrict($item) : "" ?></div>
                            <div class="announce_text"><?=AIN::getService('homdom.helpers')->getOfferTitle($item)?> </div>
                            <div class="announce_date"> <?=AIN::getService('homdom.helpers')->getOfferAnounceDate($item['modified_date'])?> </div>
                        </div>
                    </a>
                </div>
            </div>
        <? } ?>
    </div>
</div>
<script src="https://homdom.az/theme/frontend/homdom/style/js/owl.carousel.min.js"></script>
<script src="https://homdom.az/theme/frontend/homdom/style/js/jquery.matchHeight-min.js"></script>
<script>
    $('.owl-carousel').owlCarousel({
        items: 4,
        loop: false,
        margin: 10,
        autoplay: false,
        autoplayTimeout: 3000,
        autoplaySpeed: 1500,
        autoplayHoverPause: false,
        smartSpeed: 1500,
        nav: true,
        responsive:{
            0:{
                items:1
            },
            480:{
                items:2
            },
            700:{
                // margin: 20,
                items:3
            },
            1000:{
                // margin: 30,
                items:4
            }
        }
        // equalHeight();
    });
    
    equalHeight();
    function equalHeight(event) {
        $('.announce_info').matchHeight({ property: 'min-height' });
    }

</script>
</body>
</html>
