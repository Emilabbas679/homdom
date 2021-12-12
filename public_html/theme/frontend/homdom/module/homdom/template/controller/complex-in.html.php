<?php $complex = $this->_aVars['complex'];
    if ($complex['image'])
        $complex['image'] = (array) json_decode($complex['image']);
    else
        $complex['image'] = [];

    $rooms = $this->_aVars['rooms'];

    $apartment_details = [
            'min_price' => 0,
            'max_price' => 0,
            'min_area' => 0,
            'max_area' => 0,
    ];

    if (count($rooms) > 0) {
        $prices = [];
        $areas = [];
        foreach ($rooms as $r) {
            foreach ($r as $item) {
                $prices[] = $item['price'];
                $areas[] = $item['area'];
            }
        }

        $apartment_details = [
            'min_price' => min($prices),
            'max_price' => max($prices),
            'min_area' =>  min($areas),
            'max_area' =>  max($areas),
        ];
    }
    $blocks = $this->_aVars['blocks'];
?>
<main class="main">
    <div class="section_wrap wrap_resident_in">
        <div class="section_body">
            <div class="main_center">
                <div class="resident_slider">
                    <div class="main_left">
                        <div class="manshet_appartment">
                            <div class="swiper-container gallery-top">
                                <div class="swiper-wrapper">
                                    <?php foreach ($complex['image'] as $img) { ?>
                                    <div class="swiper-slide">
                                        <div class="sld_img">
                                            <img src="<?=AIN::getService('homdom.helpers')->imageResize($img, 700, 400)?>"/>
                                        </div>
                                    </div>
                                    <?php } ?>

                                </div>
                                <!-- Add Arrows -->
                                <div class="swiper-button-next swiper-button-white"></div>
                                <div class="swiper-button-prev swiper-button-white"></div>
                            </div>
                            <div class="swiper-container gallery-thumbs">
                                <div class="swiper-wrapper">
                                    <?php foreach ($complex['image'] as $img) { ?>

                                    <div class="swiper-slide">
                                        <a href="">
                                            <div class="sld_thumb_img">
                                                <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="<?=AIN::getService('homdom.helpers')->imageResize($img, 60, 60)?>" class="thumb_img"/>
                                            </div>
                                        </a>
                                    </div>
                                    <?php } ?>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main_right">
                        <div class="sticker_owner">
                            <div class="sticker_date_view">
                                <div class="st_row">
                                    <ul class="res_pr_menu">
                                        <li><a href="/complex">{{ phrase var ='homdom_all_complexes'}}</a></li>
                                    </ul>
                                </div>
                                <div class="st_row">
                                    <div class="house_price"><?=$complex['name']?></div>
      
                                </div>
                            </div>
                            <div class="owner_info">

                                <?php if ($apartment_details['min_area'] != 0) {?>
                                <div class="st_row">
                                    <div class="st_col">
                                        <span class="stick_info">{{ phrase var='homdom.apartment_area' }}:</span>
                                    </div>
                                    <div class="st_col">
                                        <span class="own_special_value"><?=$apartment_details['min_area']?> m² - <?=$apartment_details['max_area']?> m²</span>
                                    </div>
                                </div>
                                <?php } ?>


                                <div class="st_row">
                                    <?php if ($apartment_details['min_price'] != 0) {?>

                                    <div class="st_col">
                                        <span class="stick_info">{{phrase var='homdom.price'}}:</span>
                                    </div>
                                    <div class="st_col">
                                        <span class="own_special_value" ><?=$apartment_details['min_price']?> AZN - <?=$apartment_details['max_price']?> AZN</span>
                                    </div>
                                    <?php } ?>
                                </div>


                                <div class="st_row">
                                    <div class="st_col">
                                        <span class="stick_info">{{ phrase var='homdom.delivery' }}: </span>
                                    </div>
                                    <div class="st_col">
                                        <span class="own_special_value"><?=$complex['built_year']?> </span>
                                    </div>
                                </div>
                                <div class="st_row">
                                    <div class="st_col">
                                        <span class="stick_info">{{phrase var='homdom.address'}}: </span>
                                    </div>
                                    <div class="st_col">
                                        <span class="own_special_value"><?=$complex['address']?></span>
                                    </div>
                                </div>
                                <div class="st_row">
                                    <div class="st_col">
                                        <span class="stick_info">{{phrase var='homdom.email'}}:</span>
                                    </div>
                                    <div class="st_col">
                                        <a href="mailto:<?=$complex['email']?>" class="own_special_value"><?=$complex['email']?></a>
                                    </div>
                                </div>
                                <div class="st_row">
                                    <div class="st_col">
                                        <span class="stick_info">{{phrase var='homdom.url'}}:</span>
                                    </div>
                                    <div class="st_col">
                                        <a href="<?=$complex['url']?>" class="own_special_value" ><?=$complex['url']?></a >
                                    </div>
                                </div>
                            </div>
                            <div class="show_number">
                                <div class="current_show_num">
                                    {{phrase var='homdom.show_number'}}
                                </div>
                                <div class="current_show_num_info">
                                    <a href="tel:+<?=$complex['phone']?>" class="currnt_num" >+<?=$complex['phone']?></a >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (count($rooms) > 0) { ?>
                <div class="resident_project_price">
                    <div class="res_pr_row">
                        <div class="section_headers">
                            <h2 class="address_h">
                                <?=sprintf(AIN::getPhrase('homdom.complex_rooms_and_prices'),$complex['name'])?>
                            </h2>
                        </div>
                    </div>

                    <?php foreach ($rooms as $room_count => $room)  {?>

                        <div class="res_pr_row">
                            <a href="/complex-room/<?=$complex['slug']?>?type=<?=$room_count?>-otaq" class="res_pr_link">
                                <div class="res_pr_col">
                                    <span class="res_pr_info"><?=AIN::getPhrase('homdom.room_count_'.$room_count)?> </span>
                                </div>

                                <?php $min_area = 0 ; $price_m = 0; $min_price = 0; $areas = []; $price_ms = []; $prices = [];?>
                                <?php foreach ($room as $items) {
                                    $areas[] = $items['area'];
                                    $price_ms[] = number_format(($items['price'] / $items['area']), 2);
                                    $prices[] = $items['price'];
                                }?>
                                <div class="res_pr_col">
                                    <span class="res_pr_info"><?=min($areas)?> m² </span>
                                </div>
                                <div class="res_pr_col">
                                    <span class="res_pr_info"><?=min($price_ms)?> AZN/m² {{phrase var='homdom.from'}}  </span>
                                </div>
                                <div class="res_pr_col">
                                    <span class="res_pr_info"><?=min($prices)?> AZN {{phrase var='homdom.from'}} </span>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>

                <?php } ?>
                <div class="about">
                    <?=$complex['description']?>
                </div>

                <?php if (count($blocks) > 0) { ?>
                <div class="table_house_info">
                    <div class="house_title">
                        <div class="title_inner">
                            {{phrase var='homdom.interesting_offers'}}
                        </div>
                        <div class="title_btn"></div>
                    </div>
                    <div class="offer_appart">
                        <div class="offer_content">

                            <?php foreach ($blocks as $block) { ?>
                            <div class="offer_items">
                                <a href="" class="offer_items_link our_suggest_btn">
                                    <div class="offr_text">
                                        <span class="offer_h"><?=$block['title']?></span>
                                        <span class="offer_inf">{{phrase var='homdom.read_more'}}</span>
                                    </div>
                                    <span class="offr_icon">
                                        <img src="<?=($block['image']) ? $block['image'] : "/theme/frontend/homdom/style/img/gift-box-1.svg"?>">
                                    </span>
                                </a>
                            </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

                <?php } ?>

                <div class="resident_project_media">
                    <div class="main_left">
                        <div class="res_pr_row">
                            <div class="section_headers">
                                <h2 class="address_h">{{phrase var='homdom.address_in_map'}}</h2>

                                <div class="adrss_text">
                                    <?=$complex['address_detail']?>
                                </div>
                            </div>
                        </div>
                        <div class="res_pr_row">
                            <div class="res_pr_map_video">
                                <iframe src="https://maps.google.com/maps?q=<?=$complex['latitude']?>,<?=$complex['longitude']?>&amp;hl=es;z=14&amp;output=embed" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>
                    </div>
                </div>


                <?php if (count($this->_aVars['faqs']) >0 ) {?>

                <div class="resident_project_faq">

                    <div class="res_pr_row">
                        <div class="section_headers">
                            <h2 class="address_h">
                                {{ phrase var='homdom.faq' }}
                            </h2>
                        </div>
                    </div>
                    <div class="res_pr_row">
                        <div class="abt_collapse">
                            <div class="abt_clp_body">
                                <?php $loop=1; foreach ($this->_aVars['faqs'] as $faq) { ?>
                                <div class="collapse_row">
                                    <a href="#" class="collapse_btn <?=($loop == 1) ? 'clp_clicked' : ''?>">
                                        <?=$faq['title']?>
                                    </a>
                                    <div class="collapse_content">
                                        <?=$faq['content']?>
                                    </div>
                                </div>
                                <?php $loop++; } ?>
                            </div>

                        </div>
                    </div>
                </div>
                <?php } ?>


                <!-- Comments part start -->
                <div class="resident_comment_section">

                    <div class="your_write_comnt_section clearfix">
                        <h2 class="all_comnt_count_head">{{ phrase var='homdom.reviews'}} </h2>
                        <form action="{{ url link='complex.review.add'}}" method="POST">
                            {{ error }}
                            <input type="hidden" id="complex_id" name="val[complex_id]" value="<?=$complex['id']?>">
                            <div class="your_profile">
                                <div class="yr_pr_img">
                                    <img src="<?=AIN::getService('homdom.helpers')->userProfilePhoto()?>" alt="">
                                </div>
                                <!-- <div class="yr_cmt_title">Your comment </div> -->
                                <input type="text" class="yr_cmt_title" name="val[full_name]" {{ if auth() }} disabled value="<?=AIN::getUserBy('full_name')?>"   {{ /if }} placeholder="{{ phrase var='homdom.name_placeholder' }}" >
                            </div>
                            <div class="yr_comnt_area clearfix">
                                <textarea name="val[content]"  placeholder="{{ phrase var='homdom.write_here'}}" class="your_comt_textare"></textarea>
                                <div class="your_cmnt_send">
                                    <div class="yr_cmnt_bnts">
                                        <div class="lp-check">
                                            <label>
                                                <input type="checkbox" value="1" name="val[is_anonym]" class="agree">
                                                <span>{{ phrase var='homdom.send_anonym'}}</span>
                                            </label>
                                        </div>
                                        <button type="submit" class="send_your_cmnt">{{ phrase var='homdom.submit'}} </button>
                                    </div>
                                </div>
                            </div>
                        </form>


                        <div class="comment_full_container">
                            <ul class="users_comment_list clearfix" id="reviews">

                            </ul>
                            <div  style="text-align: center;" id="loading">
                                <img src="/theme/frontend/homdom/style/img/loading.gif" alt="">
                            </div>


                            <div class="show_more_comment" data-id="2" id="more_btn" style="display: none">
                                <button type="button" class="sh_more_cmt_btn">
                                    <span>Daha çox göstər </span>
                                </button>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- Comments part finish -->

                <div class="resident_project_others">

                    <div class="res_pr_row">
                        <div class="section_headers">
                            <h2 class="address_h">
                                {{phrase var='homdom.other_complexes'}}
                            </h2>
                        </div>
                    </div>

                    <div class="res_pr_row">
                        <div id="tabs_sec" class="ch-prf_tabs">
                            <div class="owl-carousel owl-theme">
                                <?php foreach ($this->_aVars['other_complexes'] as $item) { ?>
                                <div class="item">
                                    <a href="/complex/<?=$item['slug']?>" class="res_items_link">
                                        <div class="res_img">
                                            <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="<?=AIN::getService('homdom.helpers')->imageResize($item['cover_photo'], 430, 300)?>" alt="<?=$item['name']?>">
                                        </div>
                                        <div class="res_info">
                                            <div class="res_adrs"><?=$item['name']?></div>
                                            <div class="res_text"><?=($district = AIN::getService('homdom.helpers')->getDistrictById($item['district_id'])) ? AIN::getPhrase('homdom'.$district['phrase']) : '' ;?> </div>
                                            <div class="res_text"><?=$item['price']?> ₼ / {{ phrase var='homdom.kv_m_den' }} </div>
                                            <div class="res_text"><?=$item['built_year']?> </div>
                                        </div>
                                    </a>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>




                </div>


            </div>
        </div>
    </div>


    <?php $index=0; foreach ($blocks as $block) { ?>

        <div class="modal our_suggest_modal" data-id="<?=$index?>">
            <div class="modal_inner">
                <div class="popup_container">
                    <div class="popup_header">
                        <span class="pop_close"></span>
                    </div>
                    <div class="popup_body">
                        <div class="our_suggest_body">
                            <div class="pr_row">
                                <div class="our_head"><?=$block['title']?> </div>
                                <div class="our_litl_info"><?=$block['content']?></div>
                                <div class="our_sug_footer">
                                    <a href="javascript:void(0);" class="our_sug_item"><?=$block['contact']?></a>
                                </div>

<!--                                $block['contact']-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php $index++; } ?>
</main>


@section('js')
<script src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
<script>
    const observer = lozad();
    observer.observe();
</script>


<script>
    

function validComments() {
  $(".send_your_cmnt").each(function(event) {
      $(this).click(function(event) {
            let this_val = $(this).parents(".yr_comnt_area").find("textarea");
            if(this_val.val() == "") {
            event.preventDefault();
        }
      })
    
  });
}
validComments();

function checkAnonime() {
  $("input.agree").each(function(){
    $(this).click(function() {
      if($(this).prop("checked") == true){
        $(this).parents(".yr_comnt_area").siblings(".your_profile").addClass("hide_name");
      } else{
        $(this).parents(".yr_comnt_area").siblings(".your_profile").removeClass("hide_name");
      }
    });
    
  });
}
checkAnonime();

function showAllCommentInfo() {
  $(".report_icon").each(function() {
    $(this).click(function() {
      $(this).parents(".vd_commt_row").siblings().find(".reply_comnt_sect").slideToggle();

      $(this).parents(".users_comment_list li").siblings().find(".reply_comnt_sect").slideUp();
    });
  });
}
showAllCommentInfo();
</script>

<script>
    var entity_id = $('#complex_id').val()
    function getReviews(entity_id,entity_type, page=1, limit=5) {
        $("#loading").show();
        $("#more_btn").hide();

        $.ajax({
            url: "/_ajax?core[ajax]=true&core[call]=homdom.getReviews",
            data: {'page': page,'entity_id': entity_id, 'entity_type' : entity_type, 'limit':limit},
            success: function (data) {
                $("#loading").hide();
                if (data == " ") {
                    $("#more_btn").hide();
                }
                else{
                    $("#more_btn").show();

                    $("#reviews").append(data)
                }
                validComments();
                checkAnonime();
                showAllCommentInfo();
            }
        });
    }
    getReviews(entity_id, 1 ,1);


    $("#more_btn").click(function () {
        let page = $(this).attr('data-id');
        page = parseInt(page);
        getReviews(entity_id ,1 ,page);
        page = page+1;
        $(this).attr('data-id', page)
    });

</script>
@endsection