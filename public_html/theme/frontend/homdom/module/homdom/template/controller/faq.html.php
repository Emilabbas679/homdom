<main class="main">
    <div class="section_wrap wrap_agency faq_pg">
        <div class="section_body">
            <div class="main_center">
                <div class="sect_left_tab">
                    <div class="accord_menu_responsive">
                        <div class="accordion_container clearfix">
                            <ul id="ch-prf_tabs_btns_2" class="sect_tab_list accord_tabs">
                                <div class="tab_mobile_toogle">
                                    <span class="tabs_icon">
                                        <img src="" alt="">
                                    </span> 
                                    <span class="tab_name">İpoteka. Mənzilin sifariş verilməsi, əməliyyatların xüsusiyyətləri </span>
                                </div>
                                <div class="tab_row">
                                    <?php $i = 1; $categories = $this->_aVars['categories'] ?>
                                    <?php foreach ($categories as $row) { ?>
                                    <li class=" " id="<?php if ($i==1) echo 'current_in'?>">
                                          <span class="tabs_icon">
                                            <img src="<?=$row['image']?>" alt="">
                                          </span>
                                        <a href="#content_<?=$i?>" role="tab">
                                            <span class="tab_name">
                                              <?=$row['title']?>
                                            </span>
                                        </a>
                                    </li>
                                    <?php $i++; } ?>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="sect_right_content">
                    <div id="tabs_sec_2" class="">
                        <?php $i = 1; ?>
                        <?php foreach ($categories as $row) { ?>
                        <div id="content_<?=$i?>" class="">
                            <div class="agency_items">
                                <div class="abt_collapse">
                                    <div class="abt_clp_head"><?=$row['title']?></div>
                                    <div class="abt_clp_body">
                                        <?php $j=1; ?>
                                        <?php foreach ($row['faqs'] as $faq) { ?>
                                        <div class="collapse_row">
                                            <a href="#" class="collapse_btn <?php if ($j==1) echo 'clp_clicked'?> ">
                                                <?=$faq['title']?>
                                            </a>
                                            <div class="collapse_content">
                                                <?=$faq['content']?>
                                            </div>
                                        </div>
                                        <?php $j++; } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $i++; } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>


<footer class="footer">
    <div class="ftr_city">
        <div class="footer_center">
            <div class="bk_region">
                <h4 class="bk_title">{{phrase var='homdom.localities_in_baku'}}</h4>
                <ul class="bk_region_items">
                    <?php $localities = $this->_aVars['localities']; $districts = $this->_aVars['districts']; ?>
                    <?php foreach ($localities as $loc) { ?>
                    <li><a href=""><?=AIN::getPhrase('homdom.'.$loc['phrase'])?></a></li>
                    <?php  } ?>
                </ul>
            </div>
            <div class="country_region">
                <h4 class="bk_title">{{phrase var='homdom.all_azerbaijan'}}</h4>
                <ul class="country_region_items">
                    <?php foreach ($districts as $row) { ?>
                    <li><a href=""><?=AIN::getPhrase('homdom.'.$row['phrase'])?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
