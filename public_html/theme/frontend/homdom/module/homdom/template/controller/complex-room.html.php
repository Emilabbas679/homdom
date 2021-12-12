<?php
    $complex = $this->_aVars['complex'];
    $rooms   = $this->_aVars['rooms'];

?>
<main class="main">

    <div class="section_wrap wrap_my_profile_balance">

        <div class="my_anc_menu">
            <div class="main_center">
                <div class="bread_cumbs">
                    <a href="/complex" class="cums_links">{{ phrase var='homdom.complexes' }}</a>
                    <a href="/complex/{{$complex.slug}}" class="cums_links">{{$complex.name}}</a>
                    <a href="javascript:void(0)" class="cums_links">{{ phrase var='homdom.room_designs' }}</a>
                </div>

            </div>
        </div>

        <?php $type = $this->_aVars['type']?>


        <div class="section_body">
            <div class="main_center">
                <div class="section_headers">
                    <h1 class="address_h"><?=AIN::getPhrase('homdom.all_projects')?> </h1>


                    <div class="agency_check_catg">
                        <div class="ag_check_items">
                            <a href="?type=all" class="residence_room_link  <?php if ($type == 'all') echo 'active';?> ">{{phrase var='homdom.all'}}</a>
                        </div>
                        <?php foreach ($rooms as $room_count => $room) { ?>
                        <div class="ag_check_items">
                            <a href="?type=<?=$room_count?>-otaq" class="residence_room_link <?php if ($type == $room_count) echo 'active';?>"> <?=AIN::getPhrase('homdom.room_'.$room_count)?></a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="resident_room_container">

                    <?php foreach ($rooms as $room_count => $room) { ?>
                        <div class="res_row rooms room_<?=$room_count?>" <?php if ($type != 'all' and $type != $room_count) { ?> style="display: none" <?php } ?>  >
                            <div class="announce_header">
                                <div class="title_announce">
                                    <?=AIN::getPhrase('homdom.room_count_'.$room_count)?>
                                </div>
                            </div>
                            <div class="wrap_body">

                                <div class="wrap_owl">
                                    <?php foreach ($room as $item) { ?>
                                    <div class="announce_items">
                                        <a href="javascript:void(0)" class="announce_items_link">
                                            <div class="announce_img">
                                                <img src="<?=$item['image']?>" alt="">
                                            </div>
                                            <div class="announce_info">
                                                <div class="rs_room_inf">
                                                    <div class="my_anc_row">
                                                        <div class="announce_adrs">{{ phrase var='homdom.price' }} </div>
                                                        <div class="announce_text"><?=$item['price']?> AZN {{phrase var='homdom.from'}} </div>
                                                    </div>
                                                    <div class="my_anc_row">
                                                        <div class="announce_adrs">{{ phrase var='homdom.area' }}  </div>
                                                        <div class="announce_text"><?=$item['area']?> m² </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <?php } ?>
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
<script>
    $(".room_filter").change(function (){
        let roomId = $(this).val();
        if (roomId == 'all') {
            $(".rooms").show();
        }
        else {
            $(".rooms").hide();
            $(".room_"+roomId).show();

        }
    })
</script>

@endsection