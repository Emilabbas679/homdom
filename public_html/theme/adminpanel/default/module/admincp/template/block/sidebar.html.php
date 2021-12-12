<!-- Main sidebar start -->
<div class="main-sidebar">
    <div class="logo">
        <a href="{{url link='dashboard.index'}}"></a>
        <div class="m-close"></div>
    </div>
    <div class="side-menu">
        <ul class="scrl">


            <li class="side-a pt-30">{{phrase var='homdom.home'}}</li>
            <li class="side-b main <?= AIN::getService('homdom.helpers')->checkActiveRoute('dashboard')?> "><a href="{{url link='dashboard.index'}}"><i></i>{{phrase var='homdom.home'}}</a></li>



            <li class="side-a pt-30">{{phrase var='homdom.blog'}}</li>

            <li class="side-b has-sub blog">
                <a href="#"><i></i><span>{{phrase var='homdom.blog'}}</span></a>
                <ul class="sub-menu" style="display: none;">
                    <li><a href="{{url link='journal.tag.index'}}">{{phrase var='homdom.tags'}}</a></li>
                    <li><a href="{{url link='journal.category.index'}}">{{phrase var='homdom.categories'}}</a></li>
                    <li><a href="{{url link='journal.article.index'}}">{{phrase var='homdom.articles'}}</a></li>
                </ul>
            </li>



            <li class="side-a">{{phrase var='homdom.offer'}}</li>
            <li class="side-b utilities <?= AIN::getService('homdom.helpers')->checkActiveRoute('offers')?>"><a href="{{url link='offers.index'}}"><i></i><span>{{phrase var='homdom.offers'}}</span></a></li>
            <li class="side-b utilities <?= AIN::getService('homdom.helpers')->checkActiveRoute('offer/utility')?>"><a href="{{url link='offer.utility.index'}}"><i></i><span>{{phrase var='homdom.utilities'}}</span></a></li>
            <li class="side-b categories <?= AIN::getService('homdom.helpers')->checkActiveRoute('offer/category')?>"><a href="{{url link='offer.category.index'}}"><i></i><span>{{phrase var='homdom.categories'}}</span></a></li>
            <li class="side-b purposes <?= AIN::getService('homdom.helpers')->checkActiveRoute('offer/purpose')?>"><a href="{{url link='offer.purpose.index'}}"><i></i><span>{{phrase var='homdom.purposes'}}</span></a></li>
            <li class="side-b purposes <?= AIN::getService('homdom.helpers')->checkActiveRoute('offer/type')?>"><a href="{{url link='offer.type.index'}}"><i></i><span>{{phrase var='homdom.types'}}</span></a></li>


            <li class="side-a">{{phrase var='homdom.location'}}</li>
            <li class="side-b metros <?= AIN::getService('homdom.helpers')->checkActiveRoute('location/metro')?>"><a href="{{url link='location.metro.index'}}"><i></i><span>{{phrase var='homdom.metros'}}</span></a></li>
            <li class="side-b regions <?= AIN::getService('homdom.helpers')->checkActiveRoute('location/region')?>"><a href="{{url link='location.region.index'}}"><i></i><span>{{phrase var='homdom.regions'}}</span></a></li>
            <li class="side-b districts <?= AIN::getService('homdom.helpers')->checkActiveRoute('location/district')?>"><a href="{{url link='location.district.index'}}"><i></i><span>{{phrase var='homdom.districts'}}</span></a></li>
            <li class="side-b localities <?= AIN::getService('homdom.helpers')->checkActiveRoute('location/locality')?>"><a href="{{url link='location.locality.index'}}"><i></i><span>{{phrase var='homdom.localities'}}</span></a></li>
            <li class="side-b targets <?= AIN::getService('homdom.helpers')->checkActiveRoute('location/target')?>"><a href="{{url link='location.target.index'}}"><i></i><span>{{phrase var='homdom.targets'}}</span></a></li>



            <li class="side-a">{{phrase var='homdom.other'}}</li>


            <li class="side-b has-sub blog">
                <a href="#"><i></i><span>{{phrase var='homdom.complex'}}</span></a>
                <ul class="sub-menu" style="display: none;">
                    <li><a href="{{url link='complex.index'}}">{{phrase var='homdom.complexes'}}</a></li>
                    <li><a href="{{url link='complex-room.index'}}">{{phrase var='homdom.complex_rooms'}}</a></li>
                    <li><a href="{{url link='complex.reviews.index'}}">{{phrase var='homdom.reviews'}}</a></li>
                    <li><a href="{{url link='complex.block.index'}}">{{phrase var='homdom.blocks'}}</a></li>
                </ul>
            </li>




            <li class="side-b has-sub blog">
                <a href="#"><i></i><span>{{phrase var='homdom.pages'}}</span></a>
                <ul class="sub-menu" style="display: none;">
                    <li><a href="{{url link='page.index'}}">{{phrase var='homdom.dynamic'}}</a></li>
                    <li><a href="{{url link='static_page.index'}}">{{phrase var='homdom.static'}}</a></li>
                </ul>
            </li>




            <li class="side-b contact <?= AIN::getService('homdom.helpers')->checkActiveRoute('menu')?>"><a href="{{url link='menu.index'}}"><i></i><span>{{phrase var='homdom.menu'}}</span></a></li>
            <li class="side-b contact <?= AIN::getService('homdom.helpers')->checkActiveRoute('contact')?>"><a href="{{url link='contact.index'}}"><i></i><span>{{phrase var='homdom.contacts'}}</span></a></li>
            <li class="side-b buildings <?= AIN::getService('homdom.helpers')->checkActiveRoute('building')?>"><a href="{{url link='building.index'}}"><i></i><span>{{phrase var='homdom.buildings'}}</span></a></li>
            <li class="side-b agencies <?= AIN::getService('homdom.helpers')->checkActiveRoute('agency')?>"><a href="{{url link='agency.index'}}"><i></i><span>{{phrase var='homdom.agencies'}}</span></a></li>
            <li class="side-b translations <?= AIN::getService('homdom.helpers')->checkActiveRoute('translation')?>"><a href="{{url link='translation.index'}}"><i></i><span>{{phrase var='homdom.translations'}}</span></a></li>


            <li class="side-b has-sub blog">
                <a href="#"><i></i><span>{{phrase var='homdom.faq'}}</span></a>
                <ul class="sub-menu" style="display: none;">
                    <li><a href="{{url link='faq.category.index'}}">{{phrase var='homdom.faq_categories'}}</a></li>
                    <li><a href="{{url link='faq.faq.index'}}">{{phrase var='homdom.faq'}}</a></li>
                    <li><a href="{{url link='faq.complex.index'}}">{{phrase var='homdom.complex_faq'}}</a></li>
                </ul>
            </li>


        </ul>
    </div>
</div>
<!-- Main sidebar end -->

