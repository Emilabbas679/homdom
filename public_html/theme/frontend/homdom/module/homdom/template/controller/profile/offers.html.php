<?php $offers = $this->_aVars['offers'] ?>
<main class="main">
    <div class="section_wrap wrap_my_annouce">
        <div class="my_anc_menu">
            {{template file='homdom.block.profile_header'}}
        </div>
        <div class="section_body">
            <div class="main_center">
                <div class="section_headers">

                    <div class="agency_check_catg">
                        <form action="" method="get" id="form">
                            <div class="ag_check_items">
                                <label class="ag_check">
                                    <a href="{{ url link='profile.offers.active' }}" class="status_input <?php if ($this->_aVars['status_id'] == 11) echo 'active'?>">{{phrase var='homdom.status_id_11'}}</a>
                                </label>
                            </div>
                            <div class="ag_check_items">
                                <label class="ag_check">
                                    <a href="{{ url link='profile.offers.expired' }}" class="status_input <?php if ($this->_aVars['status_id'] == 9) echo 'active'?>">{{phrase var='homdom.status_id_9'}}</a>
                                </label>
                            </div>
                            <div class="ag_check_items">
                                <label class="ag_check">
                                    <a href="{{ url link='profile.offers.pending' }}" class="status_input <?php if ($this->_aVars['status_id'] == 12) echo 'active'?>">{{phrase var='homdom.status_id_12'}}</a>
                                </label>
                            </div>
                            <div class="ag_check_items">
                                <label class="ag_check">
                                    <a href="{{ url link='profile.offers.deactivated' }}" class="status_input <?php if ($this->_aVars['status_id'] == 10) echo 'active'?>">{{phrase var='homdom.status_id_10'}}</a>
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="my_anc_items">
                    <?php $i=1; ?>
                    <?php foreach ($offers as $item) { ?>
                    <div class="my_anc_slide_info_item ">
                        <div class="my_left">
                            <div class="my_anc_img_slider">
                                <div class="owl-carousel owl-theme">
                                    <?php foreach ($item['image'] as $img) { ?>
                                    <div class="item">
                                        <a href="<?=$img?>">
                                            <div class="my_anc_img">
                                                <img src="<?=$img?>" alt="">
                                            </div>
                                        </a>
                                    </div>
                                    <?php  } ?>
                                </div>

                            </div>
                            <div class="my_anc_info click_vip">
                                <div class="my_anc_row">
                                    <div class="my_anc_adrs">
                                        <a href="/offer/<?=$item['id']?>" style="color: black">
                                            <?php
                                            if ($item['property_type_id'] == 1)
                                                echo sprintf(AIN::getPhrase('homdom.'.AIN::getService('homdom.helpers')->offerPageTitle($item)), $item['room_count']).' , '.AIN::getService('homdom.helpers')->getOfferDistrict($item);
                                            elseif ($item['property_type_id'] == 2)
                                                echo sprintf(AIN::getPhrase('homdom.'.AIN::getService('homdom.helpers')->offerPageTitle($item)), $item['room_count']).' , '.AIN::getService('homdom.helpers')->getOfferDistrict($item);
                                            elseif ($item['property_type_id'] == 3)
                                                echo sprintf(AIN::getPhrase('homdom.'.AIN::getService('homdom.helpers')->offerPageTitle($item)), $item['area']).' , '.AIN::getService('homdom.helpers')->getOfferDistrict($item);
                                            elseif ($item['property_type_id'] == 5)
                                                echo sprintf(AIN::getPhrase('homdom.'.AIN::getService('homdom.helpers')->offerPageTitle($item)), $item['area']).' , '.AIN::getService('homdom.helpers')->getOfferDistrict($item);
                                            elseif ($item['property_type_id'] == 6)
                                                echo sprintf(AIN::getPhrase('homdom.'.AIN::getService('homdom.helpers')->offerPageTitle($item)), $item['area']).' , '.AIN::getService('homdom.helpers')->getOfferDistrict($item);
                                            elseif ($item['property_type_id'] == 4)
                                                echo sprintf(AIN::getPhrase('homdom.'.AIN::getService('homdom.helpers')->offerPageTitle($item)), $item['area']).' , '.AIN::getService('homdom.helpers')->getOfferDistrict($item);
                                            ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="my_anc_row">
                                    <div class="my_anc_text"><?=$item['address_detail']?> </div>
                                </div>
                                <div class="my_anc_row">
                                    <div class="my_anc_price">
                                        <?=$item['description']?>
                                    </div>
                                </div>
                                <div class="my_anc_row">
                                    <a href="#" class="move_top">İrəli çək</a>
                                    <a href="#" class="do_vip active">VIP et </a>
                                </div>
                            </div>
                        </div>
                        <div class="my_right">
                            <div class="my_anc_row">
                                <div class="my_h_price"><?=$item['price']?> ₼</div>
                            </div>
                            <div class="my_anc_row">
                                <div class="my_h_info"><?=$item['area']?>
                                    <?php if ($item['property_type_id'] != 4) { ?>
                                    m²
                                    <?php }else{echo AIN::getPhrase('homdom.sot');}?>
                                </div>
                            </div>
                            <?php if ($item['property_type_id'] == 1) { ?>
                            <div class="my_anc_row">
                                <div class="my_h_info"><?=AIN::getPhrase('homdom.bill_of_sale_'.$item['bill_of_sale'])?> </div>
                            </div>
                            <div class="my_anc_row">
                                <div class="my_h_info"><?=$item['flat_floor']?>/<?=$item['floors_total']?> <?=AIN::getPhrase('homdom.floor')?> </div>
                            </div>

                            <?php } ?>

                            <div class="my_anc_row" style="display: none">
                                <div class="my_h_recomd">Tövsiyə edirik! </div>
                            </div>

                            <div class="my_anc_row">
                                <div class="my_h_date"><?=AIN::getService('homdom.helpers')->CalculateDate($item['intime'])?> </div>
                            </div>
                        </div>
                    </div>
                        <?php if ($i % 3 == 0) { ?>
                        <div class="banner1024_120">
                            <a href="javascript:void(0)">
                                <div class="banner1024_120_image">
                                    <img src="/theme/frontend/homdom/style/img/banner1024.png" alt="">
                                </div>
                            </a>
                        </div>
                    <?php } $i++; } ?>


                </div>
                {{ pager }}

            </div>
        </div>
    </div>


</main>

@section('js')
<script>
    $(".status_input").change(function (){
        console.log($(this).val())
        // $("#form").submit()
    })
</script>

@endsection