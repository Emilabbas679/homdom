<?php defined('AIN') or exit('NO DICE!'); ?>
<?php /* Cached: December 12, 2021, 5:29 pm */ ?>
<footer class="footer">
    <div class="ftr_top">
        <div class="footer_center">

            <div class="footer_menu">

                <div class="ftr_row">
                    <ul class="ftr_menu">

                        <?php $footerMenus = AIN::getService('homdom.helpers')->footerMenu();
                            foreach ($footerMenus as $menu) { ?>
                                <li>
                                    <a href="javascript:void(0)" class="ftm_title"><?=$menu['title']?> </a>
                                    <ul class="ftr_drop_menu">
<?php  foreach ($menu['items'] as $item) { ?>
                                            <li> <a href="<?=$item['link']?>" class="">- <?=$item['title']?>  </a> </li>
<?php } ?>
                                    </ul>
                                </li>
<?php } ?>

                        
                    </ul>
                </div>
                <div class="ftr_row">
                    <div class="ft_icons">
                        <ul class="social_icons_list">
                            <li><a href="#" class="social_icons icon_fb"> </a> </li>
                            <li><a href="#" class="social_icons icon_insta"> </a> </li>
                            <li><a href="#" class="social_icons icon_tg"> </a> </li>
                            <li><a href="#" class="social_icons icon_ytb"> </a> </li>
                            <li><a href="#" class="social_icons icon_wp"> </a> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ftr_bottom">
        <div class="footer_center">
            <div class="copyrite"> Copyright © 2010-2021 Every.az . Bütün hüquqlar qorunur. </div>
        </div>
    </div>

</footer>
