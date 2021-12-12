<?php $offer = $this->_aVars['offer'] ?>
<main class="main">

    <div class="section_wrap wrap_appartment">

        <div class="section_body">
            <div class="main_center">
                <div class="main_left">
                    <div class="section_headers">
                        <h1 class="address_h">
                            <?=$this->_aVars['title']?>

                        </h1>
                        <div class="address_more">
                            <div class="adrss_text"><?=$offer['address_detail']?></div>
                        </div>
                        <div class="hash_scroll">
                            <!-- Swiper -->
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <?php foreach ($offer['targets'] as $item) { ?>
                                    <div class="swiper-slide"><a href="/offers?targets%5B%5D=<?=$item['id']?>" class="adress_hashtag"><?=AIN::getPhrase('homdom.'.$item['phrase'])?></a></div>
                                    <?php } ?>

                                    <?php if ($offer['district_id'] != 0) {
                                        $t_district = AIN::getService('homdom.helpers')->getDistrictById($offer['district_id']);
                                        if ($t_district != false) { ?>
                                            <div class="swiper-slide"><a href="/offers?district_id=<?=$offer['district_id']?>" class="adress_hashtag"><?=AIN::getPhrase('homdom.'.$t_district['phrase'])?></a></div>
                                        <?php }}?>
                                    <?php if ($offer['metro_id'] != 0) {
                                        $t_metro = AIN::getService('homdom.helpers')->getMetroById($offer['metro_id']);
                                        if ($t_metro != false) { ?>
                                            <div class="swiper-slide"><a href="/offers?metro_id%5B%5D=<?=$offer['metro_id']?>" class="adress_hashtag"><?=AIN::getPhrase('homdom.'.$t_metro['phrase'])?></a></div>
                                        <?php }}?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php  if (date('Y-m-d h:i:s') > $offer['validity_date'])  { ?>
                    <div class="expired_alert">
                        <p>{{ phrase var='homdom.expired_offer' }}</p>
                    </div>
                    <?php } ?>

                    <div class="manshet_appartment">
                        <div class="swiper-container gallery-top">
                            <div class="swiper-wrapper">
                                <?php foreach ($offer['image'] as $image) { ?>
                                    <div class="swiper-slide">
                                        <div class="sld_img  ">
                                            <img src="<?=AIN::getService('homdom.helpers')->imageResize($image, 710, 400)?>" alt="" >
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php foreach ($offer['video'] as $video) { ?>
                                    <div class="swiper-slide">
                                        <div class="sld_img  ">
                                            <video controls>
                                                <source src="<?=$video?>" type="video/mp4">
                                                <source src="<?=$video?>" type="video/ogg">
                                            </video>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next swiper-button-white"></div>
                            <div class="swiper-button-prev swiper-button-white"></div>
                        </div>
                        <div class="swiper-container gallery-thumbs">
                            <div class="swiper-wrapper">

                                <?php foreach ($offer['image'] as $image) { ?>
                                    <div class="swiper-slide">
                                        <div class="sld_thumb_img">
                                            <img src="<?=AIN::getService('homdom.helpers')->imageResize($image, 600, 340)?>" alt="" class="thumb_img">
                                        </div>
                                    </div>
                                <?php } ?>


                                <?php foreach ($offer['video'] as $video) { ?>
                                    <div class="swiper-slide">
                                        <div class="sld_thumb_img">
                                            <video  class="thumb_img">
                                                <source src="<?=$video?>" type="video/mp4">
                                                <source src="<?=$video?>" type="video/ogg">
                                            </video>
                                        </div>
                                    </div>
                                <?php } ?>


                            </div>
                        </div>

                    </div>

                    
                </div>
                <div class="main_right">
                    <div class="sticker_owner">
                        <div class="sticker_date_view">
                            <div class="st_row">
                                <div class="st_col">
                                    <div class="stick_info">{{phrase var='homdom.date'}}: <?=AIN::getService('homdom.helpers')->CalculateDate($offer['modified_date'])?></div>
                                </div>
                                <div class="st_col">
                                    <div class="stick_info">{{phrase var='homdom.hits'}}: <?=$offer['hits']?> </div>
                                </div>
                            </div>
                            <div class="st_row">
                                <div class="house_price"><?=$offer['price']?> ₼</div>
                                <div class="house_icons">
                                    <button type="button" class="selected_togle favority <?=AIN::getService('homdom.helpers')->isFavorityOffer($offer['id'])?>" data-offer-id="<?=$offer['id']?>"></button>
                                    <a href="" class="notification_link"></a>

                                    <div class="dots_content" style="display: none">
                                        <button type="button" class="three_dots"></button>
                                        <div class="tools-list">
                                            <ul>
                                                <li class="post-edit">
                                                    <a href="" target="_blank" rel="noopener noreferrer">
                                                        Redaktə et
                                                    </a>
                                                </li>
                                                <li class="post-remove">
                                                    <a href="" target="_blank" rel="noopener noreferrer">
                                                        Ləğv et
                                                    </a>
                                                </li>
                                                <li class="post-comp">
                                                    <a href="javascript:void(0);" rel="noopener noreferrer" class="btn_for_popup">
                                                        Şikayət et
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php  if (date('Y-m-d h:i:s') <= $offer['validity_date'])  { ?>

                        <div class="owner_info">
                            <div class="own_name"><?=$offer['user_name']?> </div>
                            <div class="st_row">
                                <?php if ($offer['agency_id'] != 0) { ?>
                                <div class="st_col">
                                    <span class="stick_info">{{phrase var='homdom.agency'}}:</span>
                                </div>
                                <div class="st_col">
                                    <span class="own_special_value"><?=$offer['agency_title']?></span>
                                </div>
                                <?php } ?>
                            </div>


                            <div class="st_row">
                                <div class="st_col">
                                    <span class="stick_info">
                                        <?php if ($offer['user_email'] != null) {?>
                                        {{phrase var='homdom.email'}}:
                                         <?php } else  ?>
                                        {{phrase var='homdom.seller_name'}}:
                                    </span>

                                </div>
                                <div class="st_col">
                                    <span class="own_special_value">
                                        <?php if ($offer['user_email'] != null) { echo  $offer['user_email'];} else echo $offer['seller_name'] ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="show_number">
                            <div class="current_show_num">{{phrase var='homdom.show_number' }}</div>
                            <div class="current_show_num_info">
                                <a target="_blank" href="tel:+<?=($offer['phone'] != null) ? $offer['phone'] : $offer['user_phone'] ?>" class="currnt_num"><?php if ($offer['phone'] != null){ echo "+".$offer['phone'];} else echo "+".$offer['user_phone']?></a>
                                <div class="currnt_info">{{phrase var='homdom.sale_info_phone'}}</div>
                            </div>
                        </div>

                        <?php } ?>

                        <div class="banner_300">
                            <a href="">
                                <div class="banner_img">
                                    <img src="/theme/frontend/homdom/style/img/news_5.jpg" alt="">
                                    <div class="ban_catg">REKLAM</div>
                                </div>
                                <div class="banner_info">
                                    <div class="banner_adrs">Gənclik m. </div>
                                    <div class="banner_text">Satılır 4 otaqlı yeni tikili 186 m² </div>
                                    <div class="banner_price">999,000,000 ₼ </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="main_center">
                <div class="main_left">
                    <div class="tables_container">
                        <div class="table_house_info">

                            <div class="table_show_hide s_table_1">
                            <ul class="ag_table_list">
                                {{ if $offer.room_count != 0 }}
                                <li><span class="item_value"><?=$offer['room_count']?></span> <span class="item_name">- {{phrase var='homdom.room_count'}} </span> </li>
                                {{ /if }}
                                {{ if $offer.flat_floor != 0 }}
                                <li><span class="item_value"><?=$offer['flat_floor'].'/'.$offer['floors_total']?></span> <span class="item_name">- {{phrase var='homdom.floor'}} </span> </li>
                                {{ /if }}
                                {{ if $offer.built_year != 0 and $offer.built_year != null }}
                                <li><span class="item_value"><?=$offer['built_year']?></span> <span class="item_name">- {{phrase var='homdom.built_year'}} </span> </li>
                                {{ /if }}
                                {{ if $offer.ceiling_height != 0 }}
                                <li><span class="item_value"><?=$offer['ceiling_height']?> m </span> <span class="item_name">- {{phrase var='homdom.ceiling_height'}} </span> </li>
                                {{ /if }}

                                {{ if $offer.area != 0 }}
                                <li><span class="item_value"><?=$offer['area']?>  <?php if ($offer['property_type_id'] != 3) { ?> m<sup>2</sup> <?php } else { echo AIN::getPhrase("homdom.ar");}?> </span> <span class="item_name">- {{phrase var='homdom.area'}} </span> </li>
                                {{ /if }}

                                <?php if(isset($offer['room_space']['living'])) { ?>
                                    <li><span class="item_value"><?=$offer['room_space']['living']?> m<sup>2</sup></span> <span class="item_name">- {{phrase var='homdom.living'}} </span> </li>
                                <?php } ?>

                                <?php if(isset($offer['room_space']['kitchen'])) { ?>
                                    <li><span class="item_value"><?=$offer['room_space']['kitchen']?> m<sup>2</sup></span> <span class="item_name">- {{phrase var='homdom.kitchen'}} </span> </li>
                                <?php } ?>

                                <?php
                                for ($i=1; $i<=7; $i++) {
                                if(isset($offer['room_space']['room_'.$i]) and $offer['room_space']['room_'.$i] != '' and $offer['room_space']['room_'.$i] != 0) { ?>
                                    <li><span class="item_value"><?=$offer['room_space']['room_'.$i]?> m<sup>2</sup></span> <span class="item_name">- <?=AIN::getPhrase('homdom.room_'.$i)?> </span> </li>

                                <?php }} ?>

                                <?php if(isset($offer['room_space']['balcony']) and $offer['room_space']['balcony'] != '' and $offer['room_space']['balcony'] != 0) { ?>
                                    <li><span class="item_value"><?=$offer['room_space']['balcony']?> m<sup>2</sup></span> <span class="item_name">- {{phrase var='homdom.balcony'}} </span> </li>
                                <?php } ?>
                            </ul>
                            </div>
                            <div class="show_hide_btn">
                                <div class="show_table_full">{{ phrase var='homdom.more' }}</div>
                                <div class="hide_table_full">{{ phrase var='homdom.redo' }}</div>
                            </div>

                        </div>
                        <div class="table_house_info">

                            <div class="table_show_hide s_table_2">
                                <table class="ag_table_list">
                                    {{ if ($offer.property_type_id == 1 or $offer.property_type_id == 2) and $offer.offer_type ==1  }}
                                        <tr>
                                            <td><span class="item_value">{{phrase var='homdom.bill_of_sale'}} </span> </td>
                                            <td><span class="item_name">- <?=AIN::getPhrase('homdom.bill_of_sale_'.$offer['bill_of_sale'])?> </span></td>
                                        </tr>
                                    {{ /if }}

                                    {{ if $offer.haggle == 1 }}
                                    <tr>
                                        <td><span class="item_value">{{phrase var='homdom.haggle'}} </span> </td>
                                        <td><span class="item_name">- <?=AIN::getPhrase('homdom.haggle_'.$offer['haggle'])?> </span></td>
                                    </tr>
                                    {{ /if }}
                                    {{ if $offer.mortgage == 1 }}
                                    <tr>
                                        <td><span class="item_value">{{phrase var='homdom.mortgage'}} </span> </td>
                                        <td><span class="item_name">- <?=AIN::getPhrase('homdom.mortgage_'.$offer['mortgage'])?> </span></td>
                                    </tr>
                                    {{ /if }}

                                    {{ if $offer.property_type_id == 2 or $offer.property_type_id == 4 }}
                                    {{ if $offer.material != null and $offer.material != 0 }}
                                    <tr>
                                        <td><span class="item_value">{{ phrase var='homdom.material' }} </span> </td>
                                        <td>
                                            <span class="item_name">- <?=AIN::getPhrase('homdom.material_'.$offer['material'])?></span>
                                        </td>
                                    </tr>
                                    {{ /if }}
                                    {{ /if }}


                                    {{ if $offer.property_type_id == 3 }}
                                    <tr>
                                        <td><span class="item_value">{{phrase var='homdom.field_type'}} </span> </td>
                                        <td>
                                            <span class="item_name">-<?=AIN::getPhrase('homdom.field_type_'.$offer['field_type'])?></span>
                                        </td>
                                    </tr>
                                    {{ /if }}
                                    {{ if $offer.property_type_id == 5 }}
                                    <tr>
                                        <td><span class="item_value">{{phrase var='homdom.building_exit'}} </span> </td>
                                        <td>
                                            <span class="item_name">-<?=AIN::getPhrase('homdom.building_exit_'.$offer['building_exit'])?></span>
                                        </td>
                                    </tr>
                                    {{ /if }}
                                    {{ if $offer.property_type_id == 6 }}
                                    <tr>
                                        <td><span class="item_value">{{phrase var='homdom.building_entrance'}} </span> </td>
                                        <td>
                                            <span class="item_name">-<?=AIN::getPhrase('homdom.building_entrance_'.$offer['building_entrance'])?></span>
                                        </td>
                                    </tr>
                                    {{ /if }}
                                    {{ if $offer.property_type_id == 6 }}
                                    <tr>
                                        <td><span class="item_value">{{phrase var='homdom.commercial_type'}} </span> </td>
                                        <td>
                                            <span class="item_name">-<?=AIN::getPhrase('homdom.'.$offer['commercial_type'])?></span>
                                        </td>
                                    </tr>
                                    {{ /if }}

                                    {{ if $offer.property_type_id == 4 }}
                                        {{ if $offer.building_name != null }}
                                        <tr>
                                            <td><span class="item_value">{{phrase var='homdom.building_name'}} </span> </td>
                                            <td>
                                                <span class="item_name">-<?=$offer['building_name']?></span>
                                            </td>
                                        </tr>
                                        {{/if}}
                                    {{ /if }}
                                    {{ if $offer.property_type_id == 4 }}
                                    <tr>
                                        <td><span class="item_value">{{phrase var='homdom.garage_type'}} </span> </td>
                                        <td>
                                            <span class="item_name">-<?=AIN::getPhrase('homdom.garage_type_'.$offer['garage_type'])?></span>
                                        </td>
                                    </tr>
                                    {{ /if }}
                                    {{ if $offer.property_type_id == 4 }}
                                    <tr>
                                        <td><span class="item_value">{{phrase var='homdom.garage_status'}} </span> </td>
                                        <td>
                                            <span class="item_name">-<?=AIN::getPhrase('homdom.garage_status_'.$offer['garage_status'])?></span>
                                        </td>
                                    </tr>
                                    {{ /if }}



                                    {{ if $offer.property_type_id == 1 }}
                                        {{ if $offer.building_name != null }}
                                        <tr>
                                            <td><span class="item_value">{{phrase var='homdom.building'}} </span> </td>
                                            <td>
                                                <span class="item_name">-
                                                    {{ if $offer.building_id == 0 }}
                                                        {{ $offer.building_name }}
                                                    {{ else }}
                                                        {{ $offer.b_name }}
                                                    {{ /if }}
                                                </span>
                                            </td>
                                        </tr>
                                        {{ /if }}
                                    {{ /if }}

                                    {{ if $offer.property_type_id == 1 or $offer.property_type_id == 2 }}
                                        {{ if $offer.parking != 0 }}
                                            <tr>
                                                <td><span class="item_value">{{ phrase var='homdom.parking' }} </span> </td>
                                                <td><span class="item_name">- <?=AIN::getPhrase('homdom.parking_'.$offer['parking'])?> </span></td>
                                            </tr>
                                        {{ /if }}
                                    {{ /if }}

                                    {{ if $offer.property_type_id != 3 and $offer.property_type_id != 4 and $offer.property_type_id != 6 }}
                                        {{ if $offer.source_id == null }}
                                            <tr>
                                                <td><span class="item_value">{{phrase var='homdom.quality'}} </span> </td>
                                                <td><span class="item_name">- <?=AIN::getPhrase('homdom.quality_'.$offer['quality'])?>  </span></td>
                                            </tr>
                                        {{ /if }}
                                    {{ /if }}

                                    {{ if $offer.property_type_id == 1 or $offer.property_type_id == 2 }}
                                    {{ if count($offer.window_view) > 0 }}
                                    <tr>
                                        <td><span class="item_value">{{ phrase var='homdom.window_view' }} </span> </td>
                                        <td>
                                            <span class="item_name">-
                                                <?php $i=1; foreach ($offer['window_view'] as $v) {?>
                                                    <?=AIN::getPhrase('homdom.window_view_'.$v)?>
                                                    <?php if (count($offer['window_view']) != $i ) { echo ','; }?>
                                                <?php $i++; } ?>
                                            </span>
                                        </td>
                                    </tr>
                                    {{ /if }}
                                    {{ /if }}

                                    {{ if $offer.property_type_id == 1 }}
                                    {{ if count($offer.lift) > 0 }}

                                    <tr>
                                        <td><span class="item_value">{{ phrase var='homdom.lift' }} </span> </td>
                                        <td>
                                            <span class="item_name">-
                                                <?php $i=1; foreach ($offer['lift'] as $v) {?>
                                                    <?=AIN::getPhrase('homdom.lift_'.$v)?>
                                                    <?php if (count($offer['lift']) != $i ) { echo ','; }?>
                                                    <?php $i++; } ?>
                                            </span>
                                        </td>
                                    </tr>
                                    {{ /if }}
                                    {{ /if }}

                                    {{ if $offer.property_type_id == 1 or $offer.property_type_id == 2 }}
                                        {{ if $offer.sanitary != null }}
                                        <tr>
                                            <td><span class="item_value">{{ phrase var='homdom.sanitary' }} </span> </td>
                                            <td>
                                                <span class="item_name">- <?=AIN::getPhrase('homdom.sanitary_'.$offer['sanitary'])?></span>
                                            </td>
                                        </tr>
                                        {{ /if }}
                                    {{ /if }}



                                </table>
                            </div>
                            <div class="show_hide_btn">
                                <div class="show_table_full">{{ phrase var='homdom.more' }}</div>
                                <div class="hide_table_full">{{ phrase var='homdom.redo' }}</div>
                            </div>

                        </div>
                        <?php $utilities = $this->_aVars['utilities'];

                            if (count($utilities) > 0) {
                        ?>
                        <div class="table_house_info">
                            <div class="table_show_hide s_table_3">
                            <ul class="ag_table_list">
                                <?php foreach ($utilities as $u) { ?>
                                <li><span class="item_name"> <?=AIN::getPhrase('homdom.'.$u['phrase'])?> </span></li>
                                <?php } ?>
                            </ul>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="table_house_info">
                            <div class="appartment_details">
                                <?=$offer['description']?>

                            </div>
                        </div>
                        <div class="table_house_info">
                            <div class="map_house">
                                <iframe src = "https://maps.google.com/maps?q=<?=$offer['latitude']?>,<?=$offer['longitude']?>&hl=es;z=14&amp;output=embed" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>


                            </div>
                        </div>

                        <div class="table_house_info">
                            <div class="house_title">
                                <div class="title_inner">
                                    Maraqlı təkliflərimiz
                                </div>
                                <div class="title_btn"></div>
                            </div>
                            <div class="offer_appart">
                                <div class="offer_content">
                                    <div class="offer_items">
                                        <a href="" class="offer_items_link our_suggest_btn">
                                            <div class="offr_text">
                                                <span class="offer_h">Daxili kredit </span>
                                                <span class="offer_inf">Daha çox öyrən</span>
                                            </div>
                                            <span class="offr_icon">
                                                <img src="/theme/frontend/homdom/style/img/gift-box-1.svg" alt="">
                                            </span>
                                        </a>
                                    </div>
                                    <div class="offer_items">
                                        <a href="" class="offer_items_link our_suggest_btn">
                                            <div class="offr_text">
                                                <span class="offer_h">Ipoteka şərtləri </span>
                                                <span class="offer_inf">Daha çox öyrən</span>
                                            </div>
                                            <span class="offr_icon">
                                                <img src="/theme/frontend/homdom/style/img/gift-box-2.svg" alt="">
                                            </span>
                                        </a>
                                    </div>
                                    <div class="offer_items">
                                        <a href="" class="offer_items_link our_suggest_btn">
                                            <div class="offr_text">
                                                <span class="offer_h">Ev alana qaraj hədiyyə </span>
                                                <span class="offer_inf">Daha çox öyrən</span>
                                            </div>
                                            <span class="offr_icon">
                                                <img src="/theme/frontend/homdom/style/img/gift-box-3.svg" alt="">
                                            </span>
                                        </a>
                                    </div>
                                    <div class="offer_items">
                                        <a href="" class="offer_items_link our_suggest_btn">
                                            <div class="offr_text">
                                                <span class="offer_h">10000 AZN ilkin ödəniş </span>
                                                <span class="offer_inf">Daha çox öyrən</span>
                                            </div>
                                            <span class="offr_icon">
                                                <img src="/theme/frontend/homdom/style/img/gift-box-4.svg" alt="">
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{ if $offer.building_id != 0 }}
                        <div class="table_house_info">
                            <div class="house_title">
                                <div class="title_inner">
                                    Bu binadan digər elanlar
                                </div>
                                <div class="title_btn"></div>
                            </div>
                            <div class="sect_like_announce">
                                <span class="offer_inf">10 mənzil satılır </span>
                                <div class="table_show_hide like_tb">
                                <ul class="ag_table_list">
                                    <li><span class="item_value">1 otaqlı 80.6 m<sup>2</sup> -dən </span></li>
                                    <li><span class="item_name"> 40.39 - 52.18 m </span> </li>
                                    <li><a href="" class="item_name">7 mənzil </a> </li>
                                </ul>
                                    <table>
                                        <tr>
                                            <td><span class="item_value">1 otaqlı 80.6 m<sup>2</sup> -dən </span> </td>
                                            <td><span class="item_name"> 40.39 - 52.18 m </span></td>
                                            <td><a href="" class="item_name">7 mənzil </a></td>
                                        </tr>
                                        <tr>
                                            <td><span class="item_value">2 otaqlı 80.6 m<sup>2</sup> -dən </span> </td>
                                            <td><span class="item_name"> 40.39 - 52.18 m </span></td>
                                            <td><a href="" class="item_name">3 mənzil </a></td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        </div>
                        {{ /if }}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section_wrap wrap_announce">
        <div class="main_center">
            <div class="announce_header">
                <div class="title_announce">
                    {{phrase var='homdom.similar_offers'}}
                </div>
            </div>
            <div class="wrap_body">
                <div class="wrap_owl">
                    <?php foreach ($this->_aVars['similar_offers'] as $item) { ?>
                        <div class="announce_items">
                            <a href="/offer/<?=$item['id']?>" class="announce_items_link">
                                <div class="announce_img">
                                    <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="<?=(count($item['image'])>0) ? $item['image'][0] : '/theme/frontend/homdom/style/img/news_3.jpg' ?>">
                                    <div class="announce_catg"><?=$item['price']?> ₼ </div>
                                </div>
                                <div class="announce_info">
                                    <div class="announce_adrs"><?=(AIN::getService('homdom.helpers')->getOfferDistrict($item) != '') ? AIN::getService('homdom.helpers')->getOfferDistrict($item) : "" ?></div>
                                    <div class="announce_text"><?=AIN::getService('homdom.helpers')->getOfferTitle($item)?> </div>
                                    <div class="announce_date"> <?=AIN::getService('homdom.helpers')->getOfferAnounceDate($item['modified_date'])?> </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="section_wrap wrap_interest">
        <div class="main_center">
            <div class="setcion_interset">
                <div class="house_title">
                    <div class="title_inner">
                        {{phrase var='homdom.interesting_offers_for_you'}}
                    </div>
                </div>
                <div class="sect_like_announce">
                    <div class="table_show_hide interest_tb">
                        <table>
                            <?php if ($offer['property_type_id'] == 2) {?>
                                <?php if($offer['district_id'] != 0 and $t_district != false) {?>
                                    <tr>
                                        <td>
                                            <a href="/offers?property_type_id=2&district_id=<?=$offer['district_id']?>" class="item_name">
                                                <?=sprintf(AIN::getPhrase('homdom.property_2_offers_in_district'),AIN::getPhrase('homdom.'.$t_district['phrase']))?>
                                            </a>
                                        </td>
                                        <?php if($offer['room_count'] != null and $offer['room_count'] != 0) {?>
                                            <td>
                                                <a href="/offers?property_type_id=2&district_id=<?=$offer['district_id']?>&room_count%5B%5D=<?=$offer['room_count']?>" class="item_name">
                                                    <?=sprintf(AIN::getPhrase('homdom.property_2_offers_in_district_with_room_count'),AIN::getPhrase('homdom.'.$t_district['phrase']), $offer['room_count'])?>
                                                </a>
                                            </td>

                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($offer['property_type_id'] == 3) {?>
                                <?php if($offer['district_id'] != 0 and $t_district != false) {?>
                                    <tr>
                                        <td>
                                            <a href="/offers?property_type_id=3&district_id=<?=$offer['district_id']?>" class="item_name">
                                                <?=sprintf(AIN::getPhrase('homdom.property_3_offers_in_district'),AIN::getPhrase('homdom.'.$t_district['phrase']))?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($offer['property_type_id'] == 5) {?>
                                <?php if($offer['district_id'] != 0 and $t_district != false) {?>
                                    <tr>
                                        <td>
                                            <a href="/offers?property_type_id=5&district_id=<?=$offer['district_id']?>" class="item_name">
                                                <?=sprintf(AIN::getPhrase('homdom.property_5_offers_in_district'),AIN::getPhrase('homdom.'.$t_district['phrase']))?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>


                            <?php if ($offer['offer_type'] == 2 and $offer['property_type_id'] == 1) {?>
                                <?php if($offer['district_id'] != 0 and $t_district != false) {?>
                                    <tr>
                                        <td>
                                            <a href="/offers?offer_type=2&property_type_id=1&district_id=<?=$offer['district_id']?>" class="item_name">
                                                <?=sprintf(AIN::getPhrase('homdom.rent_offers_in_district'),AIN::getPhrase('homdom.'.$t_district['phrase']))?>
                                            </a>
                                        </td>
                                        <?php if($offer['room_count'] != null and $offer['room_count'] != 0) {?>
                                            <td>
                                                <a href="/offers?offer_type=2&property_type_id=1&district_id=<?=$offer['district_id']?>&room_count%5B%5D=<?=$offer['room_count']?>" class="item_name">
                                                    <?=sprintf(AIN::getPhrase('homdom.rent_offers_in_district_with_room_count'),AIN::getPhrase('homdom.'.$t_district['phrase']), $offer['room_count'])?>
                                                </a>
                                            </td>

                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                                <?php if($offer['metro_id'] != 0 and $t_metro != false) { ?>
                                    <tr>
                                        <td>
                                            <a href="/offers?offer_type=2&property_type_id=1&metros%5B%5D=<?=$offer['metro_id']?>" class="item_name">
                                                <?=sprintf(AIN::getPhrase('homdom.rent_offers_in_metro'),AIN::getPhrase('homdom.'.$t_metro['phrase']))?>
                                            </a>
                                        </td>
                                        <?php if($offer['room_count'] != null and $offer['room_count'] != 0) {?>
                                            <td>
                                                <a href="/offers?offer_type=2&property_type_id=1&metros%5B%5D=<?=$offer['metro_id']?>&room_count%5B%5D=<?=$offer['room_count']?>" class="item_name">
                                                    <?=sprintf(AIN::getPhrase('homdom.rent_offers_in_metro_with_room_count'),AIN::getPhrase('homdom.'.$t_metro['phrase']), $offer['room_count'])?>
                                                </a>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($offer['offer_type'] == 1 and $offer['property_type_id'] == 1) {?>
                                <?php if($offer['district_id'] != 0 and $t_district != false) {?>
                                    <tr>
                                        <td>
                                            <a href="/offers?offer_type=2&property_type_id=1&district_id=<?=$offer['district_id']?>" class="item_name">
                                                <?=sprintf(AIN::getPhrase('homdom.sale_offers_in_district'),AIN::getPhrase('homdom.'.$t_district['phrase']))?>
                                            </a>
                                        </td>
                                        <?php if($offer['room_count'] != null and $offer['room_count'] != 0) {?>
                                            <td>
                                                <a href="/offers?offer_type=2&property_type_id=1&district_id=<?=$offer['district_id']?>&room_count%5B%5D=<?=$offer['room_count']?>" class="item_name">
                                                    <?=sprintf(AIN::getPhrase('homdom.sale_offers_in_district_with_room_count'),AIN::getPhrase('homdom.'.$t_district['phrase']), $offer['room_count'])?>
                                                </a>
                                            </td>

                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                                <?php if($offer['metro_id'] != 0 and $t_metro != false) { ?>
                                    <tr>
                                        <td>
                                            <a href="/offers?offer_type=1&property_type_id=1&metros%5B%5D=<?=$offer['metro_id']?>" class="item_name">
                                                <?=sprintf(AIN::getPhrase('homdom.sale_offers_in_metro'),AIN::getPhrase('homdom.'.$t_metro['phrase']))?>
                                            </a>
                                        </td>
                                        <?php if($offer['room_count'] != null and $offer['room_count'] != 0) {?>
                                            <td>
                                                <a href="/offers?offer_type=1&property_type_id=1&metros%5B%5D=<?=$offer['metro_id']?>&room_count%5B%5D=<?=$offer['room_count']?>" class="item_name">
                                                    <?=sprintf(AIN::getPhrase('homdom.sale_offers_in_metro_with_room_count'),AIN::getPhrase('homdom.'.$t_metro['phrase']), $offer['room_count'])?>
                                                </a>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="section_wrap wrap_banner_320">
        <div class="main_center">
            <!-- <div class="announce_header">
              <div class="title_announce">
                Oxşar elanlar
              </div>
            </div> -->
            <div class="wrap_body">
                <div class="wrap_owl">

                    <div class="banner320_items">
                        <a href="" class="">
                            <div class="banner320_img">
                                <img src="/theme/frontend/homdom/style/img/news_4.jpg" alt="">
                            </div>
                            <div class="banner320_info">
                                <div class="banner320_catg">REKLAM</div>
                                <div class="banner320_adrs">Nizami r. </div>
                                <div class="banner320_text">Satılır 4 otaqlı yeni tikili 186 m² </div>
                                <div class="banner320_price">999,000,000 ₼ </div>
                            </div>
                        </a>
                    </div>
                    <div class="banner320_items">
                        <a href="" class="">
                            <div class="banner320_img">
                                <img src="/theme/frontend/homdom/style/img/news_5.jpg" alt="">
                            </div>
                            <div class="banner320_info">
                                <div class="banner320_catg">REKLAM</div>
                                <div class="banner320_adrs">Nizami r. </div>
                                <div class="banner320_text">Satılır 4 otaqlı yeni tikili 186 m² </div>
                                <div class="banner320_price">999,000,000 ₼ </div>
                            </div>
                        </a>
                    </div>
                    <div class="banner320_items">
                        <a href="" class="">
                            <div class="banner320_img">
                                <img src="/theme/frontend/homdom/style/img/news_3.jpg" alt="">
                            </div>
                            <div class="banner320_info">
                                <div class="banner320_catg">REKLAM</div>
                                <div class="banner320_adrs">Nizami r. </div>
                                <div class="banner320_text">Satılır 4 otaqlı yeni tikili 186 m² </div>
                                <div class="banner320_price">999,000,000 ₼ </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
<div class="modal our_suggest_modal" data-id="0">
    <div class="modal_inner">
        <div class="popup_container">
            <div class="popup_header">
                <span class="pop_close"></span>
            </div>
            <div class="popup_body">
                <div class="our_suggest_body">
                    <div class="pr_row">
                        <div class="our_head">Ananın paytaxtı </div>
                        <div class="our_litl_info">
                            Analıq kapitalından alınan vəsaitlər bu yaşayış massivində 
                            ipoteka üçün ilkin ödəniş kimi hesablana bilər. Aksiya aşağıdakı 
                            banklarda ipoteka qeydiyyatı şərtilə mümkündür:
                        </div>
                        <div class="our_sug_footer">
                            <a href="tel:+994508664443" class="our_sug_item">+994508664443</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
<div class="modal our_suggest_modal" data-id="1">
    <div class="modal_inner">
        <div class="popup_container">
            <div class="popup_header">
                <span class="pop_close"></span>
            </div>
            <div class="popup_body">
                <div class="our_suggest_body">
                    <div class="pr_row">
                        <div class="our_head">Ananın paytaxtı 1</div>
                        <div class="our_litl_info">
                            Analıq kapitalından alınan vəsaitlər bu yaşayış massivində 
                            ipoteka üçün ilkin ödəniş kimi hesablana bilər. Aksiya aşağıdakı 
                            banklarda ipoteka qeydiyyatı şərtilə mümkündür:
                        </div>               
                        <div class="our_sug_footer">
                            <a href="tel:+994508664443" class="our_sug_item">+994508664443</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
<div class="modal our_suggest_modal" data-id="2">
    <div class="modal_inner">
        <div class="popup_container">
            <div class="popup_header">
                <span class="pop_close"></span>
            </div>
            <div class="popup_body">
                <div class="our_suggest_body">
                    <div class="pr_row">
                        <div class="our_head">Ananın paytaxtı 2</div>
                        <div class="our_litl_info">
                            Analıq kapitalından alınan vəsaitlər bu yaşayış massivində 
                            ipoteka üçün ilkin ödəniş kimi hesablana bilər. Aksiya aşağıdakı 
                            banklarda ipoteka qeydiyyatı şərtilə mümkündür:
                        </div>
                        <div class="our_sug_footer">
                            <a href="tel:+994508664443" class="our_sug_item">+994508664443</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
<div class="modal our_suggest_modal" data-id="3">
    <div class="modal_inner">
        <div class="popup_container">
            <div class="popup_header">
                <span class="pop_close"></span>
            </div>
            <div class="popup_body">
                <div class="our_suggest_body">
                    <div class="pr_row">
                        <div class="our_head">Ananın paytaxtı 3</div>
                        <div class="our_litl_info">
                            Analıq kapitalından alınan vəsaitlər bu yaşayış massivində 
                            ipoteka üçün ilkin ödəniş kimi hesablana bilər. Aksiya aşağıdakı 
                            banklarda ipoteka qeydiyyatı şərtilə mümkündür:
                        </div>
                        <div class="our_sug_footer">
                            <a href="tel:+994508664443" class="our_sug_item">+994508664443</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</main>

@section('js')
<script>
    $(".favority").click(function (){
        let type = 'delete';
        let offerId = $(this).attr('data-offer-id');
       if ($(this).hasClass('active')){
           type = 'delete';
       }
       else {
           type = 'add'
       }
        $.ajax({
            type: "POST",
            data: {
                'type' : type,
                'offer_id' : offerId
            },
            url: '/_ajax?core[ajax]=true&core[call]=homdom.userFavority',
            success: function (response) {
                console.log(response)
            }
        });

       console.log(type)
       console.log(offerId)
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
<script>
    const observer = lozad();
    observer.observe();
</script>

@endsection
