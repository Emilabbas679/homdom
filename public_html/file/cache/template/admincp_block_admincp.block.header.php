<?php defined('AIN') or exit('NO DICE!'); ?>
<?php /* Cached: December 12, 2021, 5:29 pm */ ?>
<!-- Header start -->
<div class="header">
    <div class="mob-h">
        <div class="m-menu"></div>
        <div class="m-logo">
            <a href="<?php echo AIN::getLib('url')->makeUrl('dashboard.index'); ?>"></a>
        </div>
    </div>
    <div class="h-right">
        <div class="h-links">
            <ul>
                <li class="hlp"><a href="https://smartbee.az/az/contact" target="_blank"><?php echo AIN::getPhrase('user.support'); ?></a></li>
                <li class="faq"><a href="https://smartbee.az/az/faq_Advetisers" target="_blank"><?php echo AIN::getPhrase('user.faq'); ?></a></li>
            </ul>
        </div>
        <div class="notifications"><span>6</span></div>
        <div class="my-profile"><img src="/theme/frontend/smart/style/images/profile_def.png"></div>
        <div class="profile-block">
            <div class="pr-top">

            </div>
            <div class="pr-menu">
                <ul>
                    <li class="p-profile"><a href=""><?php echo AIN::getPhrase('user.my_profile'); ?></a></li>
                    <li class="p-settings"><a href="<?php echo AIN::getLib('url')->makeUrl('profiles/index'); ?>"><?php echo AIN::getPhrase('user.settings'); ?></a></li>

                    <li class="p-logout"><a href="<?php echo AIN::getLib('url')->makeUrl('logout'); ?>"><?php echo AIN::getPhrase("user.logout"); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Header end -->

