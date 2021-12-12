<?php defined('AIN') or exit('NO DICE!'); ?>
<?php /* Cached: December 12, 2021, 5:29 pm */ ?>
<!-- Main sidebar start -->
<div class="main-sidebar">
    <div class="logo">
        <a href="<?php echo AIN::getLib('url')->makeUrl('dashboard.index'); ?>"></a>
        <div class="m-close"></div>
    </div>
    <div class="side-menu">
        <ul class="scrl">


            <li class="side-a pt-30"><?php echo AIN::getPhrase('homdom.home'); ?></li>
            <li class="side-b main <?= AIN::getService('homdom.helpers')->checkActiveRoute('dashboard')?> "><a href="<?php echo AIN::getLib('url')->makeUrl('dashboard.index'); ?>"><i></i><?php echo AIN::getPhrase('homdom.home'); ?></a></li>



            <li class="side-a pt-30"><?php echo AIN::getPhrase('homdom.blog'); ?></li>

            <li class="side-b has-sub blog">
                <a href="#"><i></i><span><?php echo AIN::getPhrase('homdom.blog'); ?></span></a>
                <ul class="sub-menu" style="display: none;">
                    <li><a href="<?php echo AIN::getLib('url')->makeUrl('journal.tag.index'); ?>"><?php echo AIN::getPhrase('homdom.tags'); ?></a></li>
                    <li><a href="<?php echo AIN::getLib('url')->makeUrl('journal.category.index'); ?>"><?php echo AIN::getPhrase('homdom.categories'); ?></a></li>
                    <li><a href="<?php echo AIN::getLib('url')->makeUrl('journal.article.index'); ?>"><?php echo AIN::getPhrase('homdom.articles'); ?></a></li>
                </ul>
            </li>



            <li class="side-a"><?php echo AIN::getPhrase('homdom.offer'); ?></li>
            <li class="side-b utilities <?= AIN::getService('homdom.helpers')->checkActiveRoute('offers')?>"><a href="<?php echo AIN::getLib('url')->makeUrl('offers.index'); ?>"><i></i><span><?php echo AIN::getPhrase('homdom.offers'); ?></span></a></li>
            <li class="side-b utilities <?= AIN::getService('homdom.helpers')->checkActiveRoute('offer/utility')?>"><a href="<?php echo AIN::getLib('url')->makeUrl('offer.utility.index'); ?>"><i></i><span><?php echo AIN::getPhrase('homdom.utilities'); ?></span></a></li>
            <li class="side-b categories <?= AIN::getService('homdom.helpers')->checkActiveRoute('offer/category')?>"><a href="<?php echo AIN::getLib('url')->makeUrl('offer.category.index'); ?>"><i></i><span><?php echo AIN::getPhrase('homdom.categories'); ?></span></a></li>
            <li class="side-b purposes <?= AIN::getService('homdom.helpers')->checkActiveRoute('offer/purpose')?>"><a href="<?php echo AIN::getLib('url')->makeUrl('offer.purpose.index'); ?>"><i></i><span><?php echo AIN::getPhrase('homdom.purposes'); ?></span></a></li>
            <li class="side-b purposes <?= AIN::getService('homdom.helpers')->checkActiveRoute('offer/type')?>"><a href="<?php echo AIN::getLib('url')->makeUrl('offer.type.index'); ?>"><i></i><span><?php echo AIN::getPhrase('homdom.types'); ?></span></a></li>


            <li class="side-a"><?php echo AIN::getPhrase('homdom.location'); ?></li>
            <li class="side-b metros <?= AIN::getService('homdom.helpers')->checkActiveRoute('location/metro')?>"><a href="<?php echo AIN::getLib('url')->makeUrl('location.metro.index'); ?>"><i></i><span><?php echo AIN::getPhrase('homdom.metros'); ?></span></a></li>
            <li class="side-b regions <?= AIN::getService('homdom.helpers')->checkActiveRoute('location/region')?>"><a href="<?php echo AIN::getLib('url')->makeUrl('location.region.index'); ?>"><i></i><span><?php echo AIN::getPhrase('homdom.regions'); ?></span></a></li>
            <li class="side-b districts <?= AIN::getService('homdom.helpers')->checkActiveRoute('location/district')?>"><a href="<?php echo AIN::getLib('url')->makeUrl('location.district.index'); ?>"><i></i><span><?php echo AIN::getPhrase('homdom.districts'); ?></span></a></li>
            <li class="side-b localities <?= AIN::getService('homdom.helpers')->checkActiveRoute('location/locality')?>"><a href="<?php echo AIN::getLib('url')->makeUrl('location.locality.index'); ?>"><i></i><span><?php echo AIN::getPhrase('homdom.localities'); ?></span></a></li>
            <li class="side-b targets <?= AIN::getService('homdom.helpers')->checkActiveRoute('location/target')?>"><a href="<?php echo AIN::getLib('url')->makeUrl('location.target.index'); ?>"><i></i><span><?php echo AIN::getPhrase('homdom.targets'); ?></span></a></li>



            <li class="side-a"><?php echo AIN::getPhrase('homdom.other'); ?></li>


            <li class="side-b has-sub blog">
                <a href="#"><i></i><span><?php echo AIN::getPhrase('homdom.complex'); ?></span></a>
                <ul class="sub-menu" style="display: none;">
                    <li><a href="<?php echo AIN::getLib('url')->makeUrl('complex.index'); ?>"><?php echo AIN::getPhrase('homdom.complexes'); ?></a></li>
                    <li><a href="<?php echo AIN::getLib('url')->makeUrl('complex-room.index'); ?>"><?php echo AIN::getPhrase('homdom.complex_rooms'); ?></a></li>
                    <li><a href="<?php echo AIN::getLib('url')->makeUrl('complex.reviews.index'); ?>"><?php echo AIN::getPhrase('homdom.reviews'); ?></a></li>
                    <li><a href="<?php echo AIN::getLib('url')->makeUrl('complex.block.index'); ?>"><?php echo AIN::getPhrase('homdom.blocks'); ?></a></li>
                </ul>
            </li>




            <li class="side-b has-sub blog">
                <a href="#"><i></i><span><?php echo AIN::getPhrase('homdom.pages'); ?></span></a>
                <ul class="sub-menu" style="display: none;">
                    <li><a href="<?php echo AIN::getLib('url')->makeUrl('page.index'); ?>"><?php echo AIN::getPhrase('homdom.dynamic'); ?></a></li>
                    <li><a href="<?php echo AIN::getLib('url')->makeUrl('static_page.index'); ?>"><?php echo AIN::getPhrase('homdom.static'); ?></a></li>
                </ul>
            </li>




            <li class="side-b contact <?= AIN::getService('homdom.helpers')->checkActiveRoute('menu')?>"><a href="<?php echo AIN::getLib('url')->makeUrl('menu.index'); ?>"><i></i><span><?php echo AIN::getPhrase('homdom.menu'); ?></span></a></li>
            <li class="side-b contact <?= AIN::getService('homdom.helpers')->checkActiveRoute('contact')?>"><a href="<?php echo AIN::getLib('url')->makeUrl('contact.index'); ?>"><i></i><span><?php echo AIN::getPhrase('homdom.contacts'); ?></span></a></li>
            <li class="side-b buildings <?= AIN::getService('homdom.helpers')->checkActiveRoute('building')?>"><a href="<?php echo AIN::getLib('url')->makeUrl('building.index'); ?>"><i></i><span><?php echo AIN::getPhrase('homdom.buildings'); ?></span></a></li>
            <li class="side-b agencies <?= AIN::getService('homdom.helpers')->checkActiveRoute('agency')?>"><a href="<?php echo AIN::getLib('url')->makeUrl('agency.index'); ?>"><i></i><span><?php echo AIN::getPhrase('homdom.agencies'); ?></span></a></li>
            <li class="side-b translations <?= AIN::getService('homdom.helpers')->checkActiveRoute('translation')?>"><a href="<?php echo AIN::getLib('url')->makeUrl('translation.index'); ?>"><i></i><span><?php echo AIN::getPhrase('homdom.translations'); ?></span></a></li>


            <li class="side-b has-sub blog">
                <a href="#"><i></i><span><?php echo AIN::getPhrase('homdom.faq'); ?></span></a>
                <ul class="sub-menu" style="display: none;">
                    <li><a href="<?php echo AIN::getLib('url')->makeUrl('faq.category.index'); ?>"><?php echo AIN::getPhrase('homdom.faq_categories'); ?></a></li>
                    <li><a href="<?php echo AIN::getLib('url')->makeUrl('faq.faq.index'); ?>"><?php echo AIN::getPhrase('homdom.faq'); ?></a></li>
                    <li><a href="<?php echo AIN::getLib('url')->makeUrl('faq.complex.index'); ?>"><?php echo AIN::getPhrase('homdom.complex_faq'); ?></a></li>
                </ul>
            </li>


        </ul>
    </div>
</div>
<!-- Main sidebar end -->


