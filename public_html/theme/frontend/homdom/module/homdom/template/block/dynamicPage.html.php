<?php if (count($this->_aVars['offers']) >0) { ?>
    <div class="ch-pr_tab_area lnk1 tab_div_link" data-id="1">
        <div class="section_wrap wrap_announce">
            <div class="main_center">
                <div class="wrap_body">
                    <div class="wrap_owl">
                        <?php foreach ($this->_aVars['offers'] as $item) { ?>
                            <div class="announce_items">
                                <a href="/offer/<?=$item['id']?>" class="announce_items_link">
                                    <div class="announce_img">
                                        <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="<?=(count($item['image'])>0) ? AIN::getService('homdom.helpers')->imageResize($item['image'][0], 600, 340) : '/theme/frontend/homdom/style/img/news_3.jpg' ?>">
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
    </div>
    <div class="ch-pr_tab_area lnk2 tab_div_link" data-id="2">
        <div class="section_wrap wrap_my_annouce">
            <div class="main_center">
                <div class="wrap_body">
                    <div class="my_anc_items" >
                        <?php foreach ($this->_aVars['offers'] as $item) { ?>
                            <div class="my_anc_slide_info_item ">
                                <div class="my_left">
                                    <div class="my_anc_img_slider">
                                        <div class="owl-carousel owl-theme">
                                            <?php foreach ($item['image'] as $img) { ?>
                                                <div class="item">
                                                    <a href="/offer/<?=$item['id']?>">
                                                        <div class="my_anc_img">
                                                            <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="<?=AIN::getService('homdom.helpers')->imageResize($img, 730, 480)?>">
                                                        </div>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="my_anc_info click_vip">
                                        <div class="my_anc_row">
                                            <div class="my_anc_adrs"><?=AIN::getService('homdom.helpers')->getOfferTitle($item)?> </div>
                                        </div>
                                        <div class="my_anc_row">
                                            <div class="my_anc_text"><?=(AIN::getService('homdom.helpers')->getOfferDistrict($item) != '') ? AIN::getService('homdom.helpers')->getOfferDistrict($item) : "" ?> </div>
                                        </div>
                                        <div class="my_anc_row">
                                            <div class="my_anc_price">
                                                <?=html_entity_decode(substr(strip_tags($item['description']), 0, 300));?> ...
                                            </div>
                                        </div>
                                        <div class="my_anc_row">
                                            <div class="show_number">
                                                <div class="current_show_num">{{phrase var='homdom.show_number' }}</div>
                                                <div class="current_show_num_info">
                                                    <a href="tel:+<?php if ($item['phone'] != null){ echo "+".$item['phone'];} else echo "+".$item['user_phone']?>" class="currnt_num"><?php if ($item['phone'] != null){ echo "+".$item['phone'];} else echo "+".$item['user_phone']?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="my_right">
                                    <div class="my_anc_row">
                                        <div class="my_h_price"><?=$item['price']?> ₼</div>
                                    </div>
                                    <!--<div class="my_anc_row">-->
                                    <!--<div class="my_h_info">1750 ₼ / m² </div>-->
                                    <!--</div>-->
                                    <!--<div class="my_anc_row">-->
                                    <!--<div class="my_h_info">Kupçalı </div>-->
                                    <!--</div>-->
                                    <!--<div class="my_anc_row">-->
                                    <!--<div class="my_h_info">12/18 mərtəbə </div>-->
                                    <!--</div>-->
                                    <div class="my_anc_row">
                                        <div class="my_h_recomd">{{phrase var='homdom.tovsiye_edirik'}} </div>
                                    </div>
                                    <div class="my_anc_row">
                                        <div class="my_h_date"> <?=AIN::getService('homdom.helpers')->getOfferAnounceDate($item['modified_date'])?> </div>
                                    </div>
                                </div>

                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>