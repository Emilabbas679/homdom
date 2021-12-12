<?php defined('AIN') or exit('NO DICE!'); ?>
<?php /* Cached: December 12, 2021, 5:29 pm */ ?>
<main class="main">

    <div class="section_wrap wrap_main">

        <div class="section_body">
            <div class="main_center">
                <div class="section_headers">
                  <h1 class="address_h"><?php echo AIN::getPhrase('homdom.search_what_you_want'); ?> </h1>
                </div>
                <div class="header_bg">
                  <div class="search-container" data-lotriver-header="">
                     <?php
						AIN::getLib('template')->getBuiltFile('homdom.block.advanced_search');
						?>
                  </div>
                  <!-- <div class="search-filters__bg" id="js-search-filters-bg"></div> -->
                </div>

                <div class="section_wrap wrap_announce">
                    <div class="main_center">
                        <div class="announce_header">
                            <div class="title_announce">
                                VIP elanlar
                            </div>
                            <div class="all_announce_link">
                                <a href="/offers">
                                    Bütün 257 təklifə baxmaq
                                </a>
                            </div>
                        </div>
                        <div class="wrap_body">
                            <div class="wrap_owl">
                                <div class="announce_items">
                                    <a href="" class="announce_items_link">
                                        <div class="announce_img">
                                            <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="/theme/frontend/homdom/style/img/news_3.jpg" >
                                            <div class="announce_catg">450,000 ₼ </div>
                                        </div>
                                        <div class="announce_info">
                                            <div class="announce_adrs"><span class="vip_btn"></span> Nizami r. </div>
                                            <div class="announce_text">Satılır 4 otaqlı yeni tikili 186 m² </div>
                                            <div class="announce_date">999,000,000 ₼ </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="announce_items">
                                    <a href="" class="announce_items_link">
                                        <div class="announce_img">
                                            <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="/theme/frontend/homdom/style/img/news_1.jpg" >
                                            <div class="announce_catg">450,000 ₼ </div>
                                        </div>
                                        <div class="announce_info">
                                            <div class="announce_adrs"><span class="vip_btn"></span> Suraxanı r. </div>
                                            <div class="announce_text">Satılır 4 otaqlı yeni tikili 186 m² </div>
                                            <div class="announce_date">999,000,000 ₼ </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="announce_items">
                                    <a href="" class="announce_items_link">
                                        <div class="announce_img">
                                            <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="/theme/frontend/homdom/style/img/news_5.jpg" >
                                            <div class="announce_catg">450,000 ₼ </div>
                                        </div>
                                        <div class="announce_info">
                                            <div class="announce_adrs"><span class="vip_btn"></span> Nərimanov r. </div>
                                            <div class="announce_text">Satılır 4 otaqlı yeni tikili 186 m² </div>
                                            <div class="announce_date">999,000,000 ₼ </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="announce_items">
                                    <a href="" class="announce_items_link">
                                        <div class="announce_img">
                                            <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="/theme/frontend/homdom/style/img/news_4.jpg" >
                                            <div class="announce_catg">450,000 ₼ </div>
                                        </div>
                                        <div class="announce_info">
                                            <div class="announce_adrs"><span class="vip_btn"></span> Sabunçu r. </div>
                                            <div class="announce_text">Satılır 4 otaqlı yeni tikili 186 m² </div>
                                            <div class="announce_date">999,000,000 ₼ </div>
                                        </div>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="resident_complex_container">
                    <div class="announce_header">
                        <div class="title_announce">
<?php echo AIN::getPhrase('homdom.complexes'); ?>
                        </div>
                        <div class="all_announce_link">
                            <a href="<?php echo AIN::getLib('url')->makeUrl('complex'); ?>">
<?php echo AIN::getPhrase('homdom.see_all_offers'); ?>
                            </a>
                        </div>
                    </div>
                    <div class="wrap_body">
                        <div class="wrap_owl">

                            <div class="res_row">
<?php foreach ($this->_aVars['complexes'] as $item) { ?>
                                <div class="res_items">
                                    <a href="/complex/<?=$item['slug']?>" class="res_items_link">
                                        <div class="res_img">
                                            <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="<?=$item['cover_photo']?>" alt="<?=$item['name']?>">
                                        </div>
                                        <div class="res_info">
                                            <div class="res_adrs"><?=$item['name']?></div>
                                            <div class="res_text"><?=($district = AIN::getService('homdom.helpers')->getDistrictById($item['district_id'])) ? AIN::getPhrase('homdom'.$district['phrase']) : '' ;?> </div>
                                            <div class="res_text"><?=$item['price']?> ₼ / <?php echo AIN::getPhrase('homdom.kv_m_den'); ?> </div>
                                            <div class="res_text"><?=$item['built_year']?> </div>
                                        </div>
                                    </a>
                                </div>
<?php } ?>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="table_house_info interest_tb">
                    <div class="announce_header">
                        <div class="title_announce">
<?php echo AIN::getPhrase('homdom.menzil_almaq_ucun'); ?>
                        </div>
                    </div>
                    <ul class="ag_table_list">
<?php for ($i=1; $i<=6; $i++) { ?>
                        <li>
                            <a href="/offers?offer_type=1&room_count%5B%5D=<?=$i?>" class="item_name"><?=AIN::getPhrase('homdom.room_count_'.$i)?></a>
                        </li>
<?php } ?>

                    </ul>

                </div>

                <div class="section_wrap wrap_announce">
                    <div class="main_center">
                        <div class="announce_header">
                            <div class="announce_header">
                                <div class="title_announce">
<?php echo AIN::getPhrase('homdom.last_offers'); ?>
                                </div>
                                <div class="all_announce_link">
                                    <a href="/offers?offer_type=1">
<?php echo AIN::getPhrase('homdom.see_all_offers'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="wrap_body">
                            <div class="wrap_owl">
<?php foreach ($this->_aVars['last_offers'] as $item) { ?>
                                    <div class="announce_items">
                                        <a href="/offer/<?=$item['id']?>" class="announce_items_link">
                                            <div class="announce_img">
                                                <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="<?=(count($item['image'])>0 and isset($item['image'][0])) ? AIN::getService('homdom.helpers')->imageResize($item['image'][0], 600, 340) : '/theme/frontend/homdom/style/img/news_3.jpg' ?>">
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
                <div class="section_wrap wrap_clikes">
                    <div class="main_center">
                        <div class="wrap_body">
                            <div class="wrap_owl">
                                <div class="one_click_items">
                                    <a href="" class="one_click_add">
                                        <div class="one_clk_icon icon_src"></div>
                                        <div class="one_clk_content">
                                            <div class="one_clk_name">Elan yerləşdir </div>
                                            <div class="one_clk_info">
                                                Yeni təqdimat forması, reklamınızı tez və rahat yerləşdirməyinizə imkan verəcək
                                            </div>
                                            <div class="one_clk_button">
                                                <span class="one_clk_btn">1 kliklə </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="one_click_items">
                                    <a href="" class="one_click_add">
                                        <div class="one_clk_icon icon_src"></div>
                                        <div class="one_clk_content">
                                            <div class="one_clk_name">Lorem ipsum </div>
                                            <div class="one_clk_info">
                                                Yeni təqdimat forması, reklamınızı tez və rahat yerləşdirməyinizə imkan verəcək
                                            </div>
                                            <div class="one_clk_button">
                                                <span class="one_clk_btn">1 kliklə </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section_wrap wrap_announce anc_item_two">
                    <div class="main_center">
                        <div class="announce_header">
                            <div class="announce_header">
                                <div class="title_announce">
                                    İrəli çəkilənlər
                                </div>
                                <div class="all_announce_link">
                                    <a href="/offers">
                                        Bütün 257 təklifə baxmaq
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="wrap_body">
                            <div class="wrap_owl">
                                <div class="announce_items">
                                    <a href="" class="announce_items_link">
                                        <div class="announce_img">
                                            <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="/theme/frontend/homdom/style/img/news_3.jpg" >
                                            <div class="announce_catg">450,000 ₼ </div>
                                        </div>
                                        <div class="announce_info">
                                            <div class="announce_adrs">Nizami r. </div>
                                            <div class="announce_text">Satılır 4 otaqlı yeni tikili 186 m² </div>
                                            <div class="announce_date">999,000,000 ₼ </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="announce_items">
                                    <a href="" class="announce_items_link">
                                        <div class="announce_img">
                                            <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="/theme/frontend/homdom/style/img/news_1.jpg" >
                                            <div class="announce_catg">450,000 ₼ </div>
                                        </div>
                                        <div class="announce_info">
                                            <div class="announce_adrs">Nizami r. </div>
                                            <div class="announce_text">Satılır 4 otaqlı yeni tikili 186 m² </div>
                                            <div class="announce_date">999,000,000 ₼ </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section_wrap wrap_announce">
                    <div class="main_center">
                        <div class="announce_header">
                            <div class="announce_header">
                                <div class="title_announce">
<?php echo AIN::getPhrase('homdom.rent_offers'); ?>
                                </div>
                                <div class="all_announce_link">
                                    <a href="/offers?offer_type=2">
<?php echo AIN::getPhrase('homdom.see_all_offers'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="wrap_body">
                            <div class="wrap_owl">
<?php foreach ($this->_aVars['rent_offers'] as $item) { ?>
                                    <div class="announce_items">
                                        <a href="/offer/<?=$item['id']?>" class="announce_items_link">
                                            <div class="announce_img">
                                                <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="<?=(count($item['image'])>0 and isset($item['image'][0])) ? AIN::getService('homdom.helpers')->imageResize($item['image'][0], 600, 340) : '/theme/frontend/homdom/style/img/news_3.jpg' ?>">
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

                <div class="table_house_info interest_tb" style="display: none">

                    <ul class="ag_table_list">
                        <li>
                            <div class="title_announce">
                                Mənzil kirayələmək üçün
                            </div>
                            <ul class="interest_list">
                                <li>
                                    <a href="javascript:void(0);" class="item_name">1 otaqlı</a> <span class="item_name">6985</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">2 otaqlı</a> <span class="item_name">6081</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">3 otaqlı</a> <span class="item_name">6985</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">Villa / Bağ</a> <span class="item_name">6081</span>
                                </li>
                                <!-- <li>
                                <a href="javascript:void(0);" class="item_name"></a> <span class="item_name"></span>
                                </li> -->
                            </ul>
                        </li>
                        <li>
                            <div class="title_announce">
                                Kommersiya obyekti
                            </div>
                            <ul class="interest_list">
                                <li>
                                    <a href="javascript:void(0);" class="item_name">Ofis</a> <span class="item_name">6985</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">Mağaza</a> <span class="item_name">6081</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">Biznes mərkəzi</a> <span class="item_name">6985</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">Ticarət mərkəzi</a> <span class="item_name">6081</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">Obyekt</a> <span class="item_name">6081</span>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <div class="title_announce">
                                Mənzil kirayələmək üçün
                            </div>
                            <ul class="interest_list">
                                <li>
                                    <a href="javascript:void(0);" class="item_name">1 otaqlı</a> <span class="item_name">6985</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">2 otaqlı</a> <span class="item_name">6081</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">3 otaqlı</a> <span class="item_name">6985</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">Villa / Bağ</a> <span class="item_name">6081</span>
                                </li>
                                <!-- <li>
                                <a href="javascript:void(0);" class="item_name"></a> <span class="item_name"></span>
                                </li> -->
                            </ul>
                        </li>
                    </ul>
                </div>
                
                <div class="section_wrap wrap_announce">
                    <div class="main_center">
                        <div class="announce_header">
                            <div class="announce_header">
                                <div class="title_announce">
<?php echo AIN::getPhrase('homdom.offer_property_type_id_2'); ?>
                                </div>
                                <div class="all_announce_link">
                                    <a href="/offers?property_type_id=2">
<?php echo AIN::getPhrase('homdom.see_all_offers'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>						

                        <div class="wrap_body">
                            <div class="wrap_owl">
<?php foreach ($this->_aVars['house_offers'] as $item) { ?>
                                    <div class="announce_items">
                                        <a href="/offer/<?=$item['id']?>" class="announce_items_link">
                                            <div class="announce_img">
                                                <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="<?=(count($item['image'])>0 and isset($item['image'][0])) ? AIN::getService('homdom.helpers')->imageResize($item['image'][0], 600, 340) : '/theme/frontend/homdom/style/img/news_3.jpg' ?>">
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

                <div class="section_wrap popular_search_blocks">
                    <div class="section_headers">
                        <h1 class="address_h">POPULYAR AXTARIŞLAR </h1>
                    </div>
                    <ul class="popular_blist">
						<li><a href="">ev alqi satqisi bakida </a> </li>
						<li><a href="">nərimanov rayonu ev alqi satqisi bakida </a> </li>
						<li><a href="">nizami rayonu ev alqi satqisi bakida </a> </li>
						<li><a href="">ev alqi satqisi yasamal rayonu </a> </li>
						<li><a href="">ev alqı satqısı bakıda </a> </li>
						<li><a href="">ev alqi satqisi bakida </a> </li>
						<li><a href="">nərimanov rayonu ev alqi satqisi bakida </a> </li>
						<li><a href="">nizami rayonu ev alqi satqisi bakida </a> </li>
						<li><a href="">ev alqi satqisi yasamal rayonu </a> </li>
						<li><a href="">ev alqı satqısı bakıda </a> </li>
						<li><a href="">ev alqi satqisi bakida </a> </li>
						<li><a href="">nərimanov rayonu ev alqi satqisi bakida </a> </li>
						<li><a href="">nizami rayonu ev alqi satqisi bakida </a> </li>
						<li><a href="">ev alqi satqisi yasamal rayonu </a> </li>
						<li><a href="">ev alqı satqısı bakıda </a> </li>
                    </ul>
                </div>

                <div class="section_wrap metro_blocks">
                    <div class="section_headers">
                        <h1 class="address_h">Abşeron rayonu </h1>
                    </div>
                    <ul class="metro_blist">
						<li><a href="">Abşeron </a> </li>
						<li><a href="">Nəsimi </a> </li>
						<li><a href="">Sabunçu </a> </li>
						<li><a href="">Səbail </a> </li>
						<li><a href="">Xətai </a> </li>
						<li><a href="">Qaradağ </a> </li>
						<li><a href="">Xəzər </a> </li>
						<li><a href="">Suraxanı </a> </li>
						<li><a href="">Binəqədi </a> </li>
						<li><a href="">Nizami </a> </li>
						<li><a href="">Yasamal </a> </li>
						<li><a href="">Nərimanov </a> </li>
                    </ul>
                </div>
                <div class="section_wrap metro_blocks">
                    <div class="section_headers">
                        <h1 class="address_h"><?php echo AIN::getPhrase('homdom.list_of_metros'); ?> </h1>
                    </div>
<?php $metros = AIN::getService('homdom.helpers')->redisMetros();  ?>
                    <ul class="metro_blist">
                        <?php foreach ($metros as $keys) {
                            foreach ($keys as $id=>$val) {?>
                            <li><a href="/offers?metros%5B%5D=<?=$id?>"><?=AIN::getPhrase('homdom.'.$val)?></a> </li>
<?php }} ?>

                    </ul>
                </div>



            </div>
        </div>
    </div>

</main>


