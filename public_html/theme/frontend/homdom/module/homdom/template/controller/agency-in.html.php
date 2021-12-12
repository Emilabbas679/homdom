<?php $agency = $this->_aVars['agency'];

if ($agency['work_days'] == null) {
    $work_days = '';
}
else{
    $a_work_days = (array) json_decode($agency['work_days']);
    sort($a_work_days);
    if ([1,2,3,4,5] == $a_work_days) {
        $work_days = AIN::getPhrase('homdom.five_days_in_week');
    }
    elseif ([1,2,3,4,5,6] == $a_work_days){
        $work_days = AIN::getPhrase('homdom.six_days_in_week');
    }
    elseif ([1,2,3,4,5,6,7] == $a_work_days) {
        $work_days = AIN::getPhrase('homdom.every_day');
    }
    else{
        $loop = 1;
        foreach ($a_work_days as $d) {
            if ($loop == 1) {
                $work_days = AIN::getPhrase('homdom.weekday_'.$d);
            }
            else{
                $work_days = $work_days.' , '. AIN::getPhrase('homdom.weekday_'.$d);
            }
            $loop++;
        }
    }
}

if ($agency['work_start_at'] != null) {
    $start = explode(':', $agency['work_start_at']);
    $agency['work_start_at'] = $start[0].':'.$start[1];
}
if ($agency['work_end_at'] != null) {
    $end = explode(':', $agency['work_end_at']);
    $agency['work_end_at'] = $end[0].':'.$end[1];
}

?>
<main class="main">
    <div class="section_wrap wrap_agency_inner">
        <div class="section_body">
            <div class="main_center">
                <div class="agency_in_top">
                    <div class="ag_in_info_item">
                        <div class="agency_items">
                            <div class="ag_link">
                                <div class="ag_img">
                                    <img src="<?=$agency['image']?>" alt="">
                                </div>
                                <div class="ag_info">
                                    <div class="ag_row">
                                        <div class="ag_head">
                                            <div class="ag_adrs"><?=$agency['title']?></div>
                                            <div class="ag_text"></div>
                                        </div>
                                        <!-- <div class="ag_catg">4727 obyekt</div> -->
                                    </div>
                                    <div class="ag_row">
                                        <div class="ag_price">
                                            <?=$agency['description']?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ag_in_table">
                        <table>
                            <tbody>
                            <tr>
                                <td><span class="item_value">{{ phrase var='homdom.phone' }} </span> </td>
                                <td>
                                    <span class="item_name">
                                        <div class="show_number">
                                        <div class="current_show_num">{{phrase var='homdom.show_number'}}</div>
                                        <div class="current_show_num_info">
                                            <a href="tel:+<?=$agency['phone']?>" class="currnt_num">+<?=$agency['phone']?></a>
                                        </div>
                                        </div>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="item_value">{{phrase var='homdom.address'}} </span> </td>
                                <td><span class="item_name"><?=$agency['address']?></span></td>
                            </tr>
                            <tr>
                                <td><span class="item_value">{{phrase var='homdom.views'}} </span> </td>
                                <td><span class="item_name"><?=$agency['views']?></span></td>
                            </tr>
                            <tr>
                                <td><span class="item_value">{{ phrase var='homdom.work_days' }}</span>
                                <td><span class="item_name"><?=$work_days?></span></td></td>
                            </tr>

                            <tr>
                                <td><span class="item_value">{{ phrase var='homdom.work_hours' }}</span> </td>
                                <td><span class="item_name"><?=$agency['work_start_at']?> – <?=$agency['work_end_at']?> </span></td>
                            </tr>

                            <tr>
                                <td><span class="item_value"> {{ phrase var='homdom.website' }} </span> </td>
                                <td><a href="<?=$agency['website']?>" target="_blank" class="item_name"> <?=$agency['website']?> </a></td>
                            </tr>
                            <tr>
                                <td><span class="item_value"> {{ phrase var='homdom.email' }} </span> </td>
                                <td><span class="item_name"><?=$agency['email']?> </span></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="agency_check_catg">
                    <form action="/offers" method="get" id="searchForm">
                        <input type="hidden" name="agency_id" value="<?=$agency['id']?>">
                        <div class="ag_check_items">
                            <label class="ag_check">
                                <input type="radio" name="agency_id" value="<?=$agency['id']?>">
                                <span>{{ phrase var='homdom.all'}} </span>
                            </label>
                        </div>

                        <div class="ag_check_items">
                            <label class="ag_check">
                                <input type="radio" name="offer_type" value="2">
                                <span>{{ phrase var='homdom.rent'}} </span>
                            </label>
                        </div>
                        <div class="ag_check_items">
                            <label class="ag_check">
                                <input type="radio" name="offer_type" value="1">
                                <span>{{ phrase var='homdom.sale'}}</span>
                            </label>
                        </div>
                        <div class="ag_check_items">
                            <label class="ag_check">
                                <input type="radio" name="building_type" value="1">
                                <span>{{ phrase var='homdom.building_type_1'}}</span>
                            </label>
                        </div>
                        <div class="ag_check_items">
                            <label class="ag_check">
                                <input type="radio" name="property_type_id" value="2">
                                <span>{{ phrase var='homdom.offer_property_type_id_2'}}</span>
                            </label>
                        </div>
                        <div class="ag_check_items">
                            <label class="ag_check">
                                <input type="radio" name="property_type_id" value="6">
                                <span>{{ phrase var='homdom.offer_property_type_id_6'}} </span>
                            </label>
                        </div>
                    </form>
                </div>
                <div class="agency_in_container">
                    <?php $agencyRentOffers = AIN::getService('homdom.core')->homdom_get_offer(['agency_id' => $agency['id'], 'status_id' => 11, 'offer_type' => 2,'limit' => 4]); ?>

                    <?php if ($agencyRentOffers['status'] == 'success' and count($agencyRentOffers['data']['rows']) > 0) { ?>
                    <div class="section_wrap wrap_announce">
                        <div class="main_center">
                            <div class="announce_header">
                                <div class="title_announce">
                                    {{phrase var='homdom.rent'}}
                                </div>
                            </div>
                            <div class="wrap_body">
                                <div class="wrap_owl">
                                    <?php foreach ($agencyRentOffers['data']['rows'] as $item) {
                                        $item = AIN::getService('homdom.helpers')->offerToArray($item); ?>
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
                            <div class="all_announce_link">
                                <a href="/offers?offer_type=2&agency_id=<?=$agency['id']?>">
                                    {{ phrase var='homdom.see_all_offers' }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <?php $agencyNewBOffers = AIN::getService('homdom.core')->homdom_get_offer(['agency_id' => $agency['id'], 'status_id' => 11, 'building_type' => 1,'limit' => 4]); ?>

                    <?php if ($agencyNewBOffers['status'] == 'success' and count($agencyNewBOffers['data']['rows']) > 0) { ?>

                        <div class="section_wrap wrap_announce">
                            <div class="main_center">
                                <div class="announce_header">
                                    <div class="title_announce">
                                        {{phrase var='homdom.building_type_1'}}
                                    </div>
                                </div>
                                <div class="wrap_body">
                                    <div class="wrap_owl">
                                        <?php foreach ($agencyNewBOffers['data']['rows'] as $item) {
                                            $item = AIN::getService('homdom.helpers')->offerToArray($item); ?>
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
                                <div class="all_announce_link">
                                    <a href="/offers?building_type=1&agency_id=<?=$agency['id']?>">
                                        {{ phrase var='homdom.see_all_offers' }}
                                    </a>
                                </div>
                            </div>
                        </div>

                    <?php } ?>
                    <?php $agencyOldBOffers = AIN::getService('homdom.core')->homdom_get_offer(['agency_id' => $agency['id'], 'status_id' => 11, 'building_type' => 0,'limit' => 4]); ?>

                    <?php if ($agencyOldBOffers['status'] == 'success' and count($agencyOldBOffers['data']['rows']) > 0) { ?>

                        <div class="section_wrap wrap_announce">
                            <div class="main_center">
                                <div class="announce_header">
                                    <div class="title_announce">
                                        {{phrase var='homdom.building_type_0'}}
                                    </div>
                                </div>
                                <div class="wrap_body">
                                    <div class="wrap_owl">
                                        <?php foreach ($agencyOldBOffers['data']['rows'] as $item) {
                                            $item = AIN::getService('homdom.helpers')->offerToArray($item); ?>
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
                                <div class="all_announce_link">
                                    <a href="/offers?building_type=0&agency_id=<?=$agency['id']?>">
                                        {{ phrase var='homdom.see_all_offers' }}
                                    </a>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                </div>



            </div>
        </div>
    </div>


</main>

@section('js')

<script src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
<script>
    const observer = lozad();
    observer.observe();
</script>
<script>
    $('input[type=radio]').change(function() {
        $("#searchForm").submit()
    });
</script>

@endsection