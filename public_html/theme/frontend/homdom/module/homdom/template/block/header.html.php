<header class="header">

    <div class="hd_top  ">
        <div class="header_center  ">
            <div class="top_icons  ">
                <div class="menu-btn"></div>  
                <a href="/" class="logo">
                    <img src="/theme/frontend/homdom/style/img/logo.svg" alt="">
                </a>

                <div class="icons_sect  ">
                    <!-- <a href="" class="choose_link"></a>
                    <a href="" class="notification_link"></a> -->
                    <a href="{{url link='announce.add'}}" class="add_announce_link"><span class="link_btn_img">+</span> <span class="link_btn_name">{{phrase var='homdom.anounce_add'}} </span> </a>
                    {{ if auth() }}

                    <div class="profile_item">
                        <a href="javascript:void(0);" target="" rel="noopener noreferrer" class="notif_btn_link">
                            <span class="profile_name"><?=AIN::getService('homdom.user')->getUserBy('full_name')?></span>
                            <span class="profile_img">
                                <img src="<?=AIN::getService('homdom.helpers')->userProfilePhoto()?>" alt="">
                            </span>
                        </a>
                        <div class="notifications-section">
                            <div class="tooltip_prf-links">
                                <a href="{{ url link='profile.favorites' }}" target="_self" rel="noopener noreferrer" class="">
                                    <span class="tooltp_icons "><img src="/theme/frontend/homdom/style/img/heart_title.svg" alt=""> </span>
                                    <span class="prf_earn_nm">{{phrase var='homdom.favorites'}} </span>
                                </a>
                                <a href="{{ url link='profile.history' }}" target="_self" rel="noopener noreferrer" class="">
                                    <span class="tooltp_icons "><img src="/theme/frontend/homdom/style/img/clock.svg" alt=""> </span>
                                    <span class="prf_earn_nm">{{phrase var='homdom.history'}} </span>
                                </a>
                                <a href="{{ url link='profile.parameters' }}" target="_self" rel="noopener noreferrer" class="">
                                    <span class="tooltp_icons "><img src="/theme/frontend/homdom/style/img/paramter.svg" alt=""> </span>
                                    <span class="prf_earn_nm">{{phrase var='homdom.parameters'}} </span>
                                </a>
                                <a href="{{ url link='auth.logout' }}" target="_self" rel="noopener noreferrer" class="">
                                    <span class="tooltp_icons "><img src="/theme/frontend/homdom/style/img/exit.svg?v1" alt=""> </span>
                                    <span class="prf_earn_nm prf-exit">{{ phrase var='homdom.logout' }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{ else }}
                    <a href="{{url link='auth.login'}}" class="sign_in"> <span class="link_btn_img user"> </span><span class="link_btn_name"> {{ phrase var = 'user.login' }} </span>  </a>
                    {{ /if }}

                </div>
            </div>
        </div>

    </div>
    <div id="mySearch" class="search-are  ">
        <div class="header_center  ">
            <form class="" action="index.html" method="post">

                <input type="text" name="" value="" placeholder="Axtar..." class="sch-text">
                <button type="submit" class="sch-btn"> </button>
            </form>
        </div>

    </div>
    <div class="hd_bottom mobile_menu">

        <div class="header_center">

            <nav class="nav_desk">
                <ul class="hdr_menu">
                    <?php $headerMenus = AIN::getService('homdom.helpers')->headerMenu();
                    foreach ($headerMenus as $arr) { ?>
                        <li> <a href="<?=$arr['link']?>"><?=$arr['title']?> </a> </li>
                    <?php } ?>

                </ul>
                <div class="mobile_social">
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
<!--                <ul class="desk_little_menu">-->
<!--                    <li><a href="#" class="">Haqqımızda </a> </li>-->
<!--                    <li><a href="{{ url link='contact' }}" class="">{{phrase var='homdom.contact'}} </a> </li>-->
<!--                </ul>-->
            </nav>
        </div>
        <span class="close_menu"></span>
    </div>
    <!-- Mobile Menu start -->
    <div class="mobile_hd_bottom  ">
        <div class="menu_category_body  ">
            <div class="menu_category  ">
                <div class="mn_ctg_name  ">
                    <div class="catg_toggle mn_catg_icon">Kateqoriyalar</div>
                </div>
                <nav class="nav_desk  ">
                    <ul class="hdr_menu  ">
                        <li> <a href="#" class="menu_active">Əsas  </a> </li>
                        <li> <a href="#" class="">Ölkə  </a> </li>
                        <li> <a href="#" class="">Hadisə  </a> </li>
                        <li> <a href="#" class="">İqtisadiyyat  </a> </li>
                        <li> <a href="#" class="">İdman  </a> </li>
                        <li> <a href="#" class="">Texno  </a> </li>
                        <li> <a href="#" class="">Sənət  </a> </li>
                        <li> <a href="#" class="">Maqazin  </a> </li>
                        <li> <a href="#" class="">Seriallar  </a>
                            <ul class="dropdown">
                                <li> <a href="#" class="">Azərbaycan  </a>
                                <li> <a href="#" class="">Türk  </a>
                                <li> <a href="#" class="">Rus  </a>
                                <li> <a href="#" class="">Dünya  </a>
                            </ul>
                        </li>
                        <li> <a href="#" class="">Kliplər  </a> </li>
                        <li> <a href="#" class="">Dünya  </a> </li>
                    </ul>
                </nav>
            </div>
            <div class="menu_category  ">
                <div class="mn_ctg_name  ">
                    <div class="catg_toggle mn_broad_icon">Verlişlər</div>
                </div>
                <nav class="nav_desk  ">
                    <ul class="hdr_menu  ">
                        <li> <a href="#" class="menu_active">İdman xəbərləri  </a> </li>
                        <li> <a href="#" class="">Belə-belə işlər  </a> </li>
                        <li> <a href="#" class="">Musiqi dəqiqələri  </a> </li>
                    </ul>
                </nav>
            </div>
            <div class="menu_category  ">
                <div class="mn_ctg_name  ">
                    <div class="catg_toggle mn_more_icon">Digər</div>
                </div>
                <nav class="nav_desk  ">
                    <ul class="hdr_menu  ">
                        <li> <a href="#" class="menu_active">Haqqımızda </a> </li>
                        <li> <a href="#" class="">Əlaqə  </a> </li>
                    </ul>
                </nav>
            </div>

        </div>
    </div>
</header>