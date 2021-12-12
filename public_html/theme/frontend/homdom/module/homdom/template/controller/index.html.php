<main class="main">

    <div class="section_wrap wrap_main">

        <div class="section_body">
            <div class="main_center">
                <div class="section_headers">
                  <h1 class="address_h">{{ phrase var='homdom.search_what_you_want'}} </h1>
                </div>
                <div class="header_bg">
                  <div class="search-container" data-lotriver-header="">
                     {{ template file='homdom.block.advanced_search' }}
                  </div>
                  <!-- <div class="search-filters__bg" id="js-search-filters-bg"></div> -->
                </div>

                <div class="section_wrap wrap_announce">
                    <div class="main_center">
                        <div class="announce_header">
                            <div class="title_announce">
                                VIP elanlar
                            </div>
                            <div class="all_announce_link">
                                <a href="/offers">
                                    Bütün 257 təklifə baxmaq
                                </a>
                            </div>
                        </div>
                        <div class="wrap_body">
                            <div class="wrap_owl">
                                <div class="announce_items">
                                    <a href="" class="announce_items_link">
                                        <div class="announce_img">
                                            <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="/theme/frontend/homdom/style/img/news_3.jpg" >
                                            <div class="announce_catg">450,000 ₼ </div>
                                        </div>
                                        <div class="announce_info">
                                            <div class="announce_adrs"><span class="vip_btn"></span> Nizami r. </div>
                                            <div class="announce_text">Satılır 4 otaqlı yeni tikili 186 m² </div>
                                            <div class="announce_date">999,000,000 ₼ </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="announce_items">
                                    <a href="" class="announce_items_link">
                                        <div class="announce_img">
                                            <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="/theme/frontend/homdom/style/img/news_1.jpg" >
                                            <div class="announce_catg">450,000 ₼ </div>
                                        </div>
                                        <div class="announce_info">
                                            <div class="announce_adrs"><span class="vip_btn"></span> Suraxanı r. </div>
                                            <div class="announce_text">Satılır 4 otaqlı yeni tikili 186 m² </div>
                                            <div class="announce_date">999,000,000 ₼ </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="announce_items">
                                    <a href="" class="announce_items_link">
                                        <div class="announce_img">
                                            <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="/theme/frontend/homdom/style/img/news_5.jpg" >
                                            <div class="announce_catg">450,000 ₼ </div>
                                        </div>
                                        <div class="announce_info">
                                            <div class="announce_adrs"><span class="vip_btn"></span> Nərimanov r. </div>
                                            <div class="announce_text">Satılır 4 otaqlı yeni tikili 186 m² </div>
                                            <div class="announce_date">999,000,000 ₼ </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="announce_items">
                                    <a href="" class="announce_items_link">
                                        <div class="announce_img">
                                            <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="/theme/frontend/homdom/style/img/news_4.jpg" >
                                            <div class="announce_catg">450,000 ₼ </div>
                                        </div>
                                        <div class="announce_info">
                                            <div class="announce_adrs"><span class="vip_btn"></span> Sabunçu r. </div>
                                            <div class="announce_text">Satılır 4 otaqlı yeni tikili 186 m² </div>
                                            <div class="announce_date">999,000,000 ₼ </div>
                                        </div>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="resident_complex_container">
                    <div class="announce_header">
                        <div class="title_announce">
                            {{phrase var='homdom.complexes'}}
                        </div>
                        <div class="all_announce_link">
                            <a href="{{ url link='complex'}}">
                                {{ phrase var='homdom.see_all_offers' }}
                            </a>
                        </div>
                    </div>
                    <div class="wrap_body">
                        <div class="wrap_owl">

                            <div class="res_row">
                                <?php foreach ($this->_aVars['complexes'] as $item) { ?>
                                <div class="res_items">
                                    <a href="/complex/<?=$item['slug']?>" class="res_items_link">
                                        <div class="res_img">
                                            <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="<?=$item['cover_photo']?>" alt="<?=$item['name']?>">
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

                <div class="table_house_info interest_tb">
                    <div class="announce_header">
                        <div class="title_announce">
                            {{phrase var='homdom.menzil_almaq_ucun'}}
                        </div>
                    </div>
                    <ul class="ag_table_list">
                        <?php for ($i=1; $i<=6; $i++) { ?>
                        <li>
                            <a href="/offers?offer_type=1&room_count%5B%5D=<?=$i?>" class="item_name"><?=AIN::getPhrase('homdom.room_count_'.$i)?></a>
                        </li>
                        <?php } ?>

                    </ul>

                </div>

                <div class="section_wrap wrap_announce">
                    <div class="main_center">
                        <div class="announce_header">
                            <div class="announce_header">
                                <div class="title_announce">
                                    {{ phrase var='homdom.last_offers' }}
                                </div>
                                <div class="all_announce_link">
                                    <a href="/offers?offer_type=1">
                                        {{ phrase var='homdom.see_all_offers' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="wrap_body">
                            <div class="wrap_owl">
                                <?php foreach ($this->_aVars['last_offers'] as $item) { ?>
                                    <div class="announce_items">
                                        <a href="/offer/<?=$item['id']?>" class="announce_items_link">
                                            <div class="announce_img">
                                                <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="<?=(count($item['image'])>0 and isset($item['image'][0])) ? AIN::getService('homdom.helpers')->imageResize($item['image'][0], 600, 340) : '/theme/frontend/homdom/style/img/news_3.jpg' ?>">
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
                    </div>
                </div>
                <div class="section_wrap wrap_clikes">
                    <div class="main_center">
                        <div class="wrap_body">
                            <div class="wrap_owl">
                                <div class="one_click_items">
                                    <a href="" class="one_click_add">
                                        <div class="one_clk_icon icon_src"></div>
                                        <div class="one_clk_content">
                                            <div class="one_clk_name">Elan yerləşdir </div>
                                            <div class="one_clk_info">
                                                Yeni təqdimat forması, reklamınızı tez və rahat yerləşdirməyinizə imkan verəcək
                                            </div>
                                            <div class="one_clk_button">
                                                <span class="one_clk_btn">1 kliklə </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="one_click_items">
                                    <a href="" class="one_click_add">
                                        <div class="one_clk_icon icon_src"></div>
                                        <div class="one_clk_content">
                                            <div class="one_clk_name">Lorem ipsum </div>
                                            <div class="one_clk_info">
                                                Yeni təqdimat forması, reklamınızı tez və rahat yerləşdirməyinizə imkan verəcək
                                            </div>
                                            <div class="one_clk_button">
                                                <span class="one_clk_btn">1 kliklə </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section_wrap wrap_announce anc_item_two">
                    <div class="main_center">
                        <div class="announce_header">
                            <div class="announce_header">
                                <div class="title_announce">
                                    İrəli çəkilənlər
                                </div>
                                <div class="all_announce_link">
                                    <a href="/offers">
                                        Bütün 257 təklifə baxmaq
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="wrap_body">
                            <div class="wrap_owl">
                                <div class="announce_items">
                                    <a href="" class="announce_items_link">
                                        <div class="announce_img">
                                            <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="/theme/frontend/homdom/style/img/news_3.jpg" >
                                            <div class="announce_catg">450,000 ₼ </div>
                                        </div>
                                        <div class="announce_info">
                                            <div class="announce_adrs">Nizami r. </div>
                                            <div class="announce_text">Satılır 4 otaqlı yeni tikili 186 m² </div>
                                            <div class="announce_date">999,000,000 ₼ </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="announce_items">
                                    <a href="" class="announce_items_link">
                                        <div class="announce_img">
                                            <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="/theme/frontend/homdom/style/img/news_1.jpg" >
                                            <div class="announce_catg">450,000 ₼ </div>
                                        </div>
                                        <div class="announce_info">
                                            <div class="announce_adrs">Nizami r. </div>
                                            <div class="announce_text">Satılır 4 otaqlı yeni tikili 186 m² </div>
                                            <div class="announce_date">999,000,000 ₼ </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section_wrap wrap_announce">
                    <div class="main_center">
                        <div class="announce_header">
                            <div class="announce_header">
                                <div class="title_announce">
                                    {{ phrase var='homdom.rent_offers' }}
                                </div>
                                <div class="all_announce_link">
                                    <a href="/offers?offer_type=2">
                                        {{ phrase var='homdom.see_all_offers' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="wrap_body">
                            <div class="wrap_owl">
                                <?php foreach ($this->_aVars['rent_offers'] as $item) { ?>
                                    <div class="announce_items">
                                        <a href="/offer/<?=$item['id']?>" class="announce_items_link">
                                            <div class="announce_img">
                                                <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="<?=(count($item['image'])>0 and isset($item['image'][0])) ? AIN::getService('homdom.helpers')->imageResize($item['image'][0], 600, 340) : '/theme/frontend/homdom/style/img/news_3.jpg' ?>">
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
                    </div>
                </div>

                <div class="table_house_info interest_tb" style="display: none">

                    <ul class="ag_table_list">
                        <li>
                            <div class="title_announce">
                                Mənzil kirayələmək üçün
                            </div>
                            <ul class="interest_list">
                                <li>
                                    <a href="javascript:void(0);" class="item_name">1 otaqlı</a> <span class="item_name">6985</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">2 otaqlı</a> <span class="item_name">6081</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">3 otaqlı</a> <span class="item_name">6985</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">Villa / Bağ</a> <span class="item_name">6081</span>
                                </li>
                                <!-- <li>
                                <a href="javascript:void(0);" class="item_name"></a> <span class="item_name"></span>
                                </li> -->
                            </ul>
                        </li>
                        <li>
                            <div class="title_announce">
                                Kommersiya obyekti
                            </div>
                            <ul class="interest_list">
                                <li>
                                    <a href="javascript:void(0);" class="item_name">Ofis</a> <span class="item_name">6985</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">Mağaza</a> <span class="item_name">6081</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">Biznes mərkəzi</a> <span class="item_name">6985</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">Ticarət mərkəzi</a> <span class="item_name">6081</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">Obyekt</a> <span class="item_name">6081</span>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <div class="title_announce">
                                Mənzil kirayələmək üçün
                            </div>
                            <ul class="interest_list">
                                <li>
                                    <a href="javascript:void(0);" class="item_name">1 otaqlı</a> <span class="item_name">6985</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">2 otaqlı</a> <span class="item_name">6081</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">3 otaqlı</a> <span class="item_name">6985</span>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="item_name">Villa / Bağ</a> <span class="item_name">6081</span>
                                </li>
                                <!-- <li>
                                <a href="javascript:void(0);" class="item_name"></a> <span class="item_name"></span>
                                </li> -->
                            </ul>
                        </li>
                    </ul>
                </div>
                
                <div class="section_wrap wrap_announce">
                    <div class="main_center">
                        <div class="announce_header">
                            <div class="announce_header">
                                <div class="title_announce">
                                    {{ phrase var='homdom.offer_property_type_id_2' }}
                                </div>
                                <div class="all_announce_link">
                                    <a href="/offers?property_type_id=2">
                                        {{phrase var='homdom.see_all_offers'}}
                                    </a>
                                </div>
                            </div>
                        </div>						

                        <div class="wrap_body">
                            <div class="wrap_owl">
                                <?php foreach ($this->_aVars['house_offers'] as $item) { ?>
                                    <div class="announce_items">
                                        <a href="/offer/<?=$item['id']?>" class="announce_items_link">
                                            <div class="announce_img">
                                                <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="<?=(count($item['image'])>0 and isset($item['image'][0])) ? AIN::getService('homdom.helpers')->imageResize($item['image'][0], 600, 340) : '/theme/frontend/homdom/style/img/news_3.jpg' ?>">
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
                    </div>
                </div>

                <div class="section_wrap popular_search_blocks">
                    <div class="section_headers">
                        <h1 class="address_h">POPULYAR AXTARIŞLAR </h1>
                    </div>
                    <ul class="popular_blist">
						<li><a href="">ev alqi satqisi bakida </a> </li>
						<li><a href="">nərimanov rayonu ev alqi satqisi bakida </a> </li>
						<li><a href="">nizami rayonu ev alqi satqisi bakida </a> </li>
						<li><a href="">ev alqi satqisi yasamal rayonu </a> </li>
						<li><a href="">ev alqı satqısı bakıda </a> </li>
						<li><a href="">ev alqi satqisi bakida </a> </li>
						<li><a href="">nərimanov rayonu ev alqi satqisi bakida </a> </li>
						<li><a href="">nizami rayonu ev alqi satqisi bakida </a> </li>
						<li><a href="">ev alqi satqisi yasamal rayonu </a> </li>
						<li><a href="">ev alqı satqısı bakıda </a> </li>
						<li><a href="">ev alqi satqisi bakida </a> </li>
						<li><a href="">nərimanov rayonu ev alqi satqisi bakida </a> </li>
						<li><a href="">nizami rayonu ev alqi satqisi bakida </a> </li>
						<li><a href="">ev alqi satqisi yasamal rayonu </a> </li>
						<li><a href="">ev alqı satqısı bakıda </a> </li>
                    </ul>
                </div>

                <div class="section_wrap metro_blocks">
                    <div class="section_headers">
                        <h1 class="address_h">Abşeron rayonu </h1>
                    </div>
                    <ul class="metro_blist">
						<li><a href="">Abşeron </a> </li>
						<li><a href="">Nəsimi </a> </li>
						<li><a href="">Sabunçu </a> </li>
						<li><a href="">Səbail </a> </li>
						<li><a href="">Xətai </a> </li>
						<li><a href="">Qaradağ </a> </li>
						<li><a href="">Xəzər </a> </li>
						<li><a href="">Suraxanı </a> </li>
						<li><a href="">Binəqədi </a> </li>
						<li><a href="">Nizami </a> </li>
						<li><a href="">Yasamal </a> </li>
						<li><a href="">Nərimanov </a> </li>
                    </ul>
                </div>
                <div class="section_wrap metro_blocks">
                    <div class="section_headers">
                        <h1 class="address_h">{{ phrase var='homdom.list_of_metros'}} </h1>
                    </div>
                    <?php $metros = AIN::getService('homdom.helpers')->redisMetros();  ?>
                    <ul class="metro_blist">
                        <?php foreach ($metros as $keys) {
                            foreach ($keys as $id=>$val) {?>
                            <li><a href="/offers?metros%5B%5D=<?=$id?>"><?=AIN::getPhrase('homdom.'.$val)?></a> </li>
                        <?php }} ?>

                    </ul>
                </div>



            </div>
        </div>
    </div>

</main>

@section('js')

<script src="/theme/frontend/homdom/style/js/datepicker.min.js"></script>
<!-- <script src="/theme/frontend/homdom/style/js/chart.js"></script> -->
<script type="text/javascript">
  $(".phone").inputmask({
    "mask": "+(999) 99 999 99 99",
  });
  $(".currency").inputmask({
    alias: "currency",
    inputFormat: "999,999.12"
  });
  $(".decimal").inputmask({
    alias: "decimal",
    "placeholder": "",
  });
  $(".integer_num").inputmask({
    alias: "integer",
  });
</script>

<script>
//Date
$('[data-toggle="datepicker"]').datepicker({
  autoHide: true,
  format: 'dd.mm.yyyy',
  minDate: '-1m'
});

</script>
<script>
$(document).ready(function() {
    $(".js-example-basic-single").select2({
        minimumResultsForSearch: Infinity
    });
});
</script>

<script type="text/javascript">
  $(document).ready(function() {
  
      function matchCustom(params, data) {
        // If there are no search terms, return all of the data
        if ($.trim(params.term) === '') {
          return data;
        }
    
        // Do not display the item if there is no 'text' property
        if (typeof data.text === 'undefined') {
          return null;
        }
    
        // `params.term` should be the term that is used for searching
        // `data.text` is the text that is displayed for the data object
        if (data.text.indexOf(params.term) > -1) {
          var modifiedData = $.extend({}, data, true);
          //modifiedData.text += ' (matched)';
    
          // You can return modified objects from here
          // This includes matching the `children` how you want in nested data sets
          return modifiedData;
        }
    
        // Return `null` if the term should not be displayed
        return null;
      }
      
      $(".js-example-matcher").select2({
        matcher: matchCustom
      });
  });
</script>

<script>
  $(document).ready(function() {
  
    $('select.select_tags').select2({
        tags: true,
        maximumInputLength: 5,
        placeholder: "Otaq sayı",
        createTag: function (params) {
        var term = $.trim(params.term);
  
        if (term === '') {
          return null;
        }
  
        return {
          id: term,
          text: term,
          newTag: false // add additional parameters
        }
      }
    });
  });
</script>
<script>
    $('body').on('click', '.search_targets', function (e) {
        let attrId = $(this).attr('data-id');
        if ($(this).hasClass('active')) {
            $("input#target_"+attrId).remove()
        }
        else{
            $("#ads_search_targets").append("<input name='targets[]' id='target_"+attrId+"' value='"+attrId+"'>")
        }
    });
    $('body').on('click', '.js-search-locations-reset-filters', function (e) {
        $("#ads_search_targets").html('')
    });

    $( document ).ready(function() {
        $(".targets_add_button").click();
        $("#ads_search_localities").html('')
        $("#ads_search_metros").html('')

    });


    $('body').on('click', '.search_localities', function (e) {
        let attrId = $(this).attr('data-id');
        if ($(this).hasClass('active')) {
            $("input#locality_"+attrId).remove()
        }
        else{
            $("#ads_search_localities").append("<input name='localities[]' id='locality_"+attrId+"' value='"+attrId+"'>")
        }
    });

    $('body').on('click', '.search_metros', function (e) {
        let attrId = $(this).attr('data-id');
        if ($(this).hasClass('active')) {
            $("input#metro_"+attrId).remove()
        }
        else{
            $("#ads_search_metros").append("<input name='metros[]' id='metro_"+attrId+"' value='"+attrId+"'>")
        }
    });




    let propertyTypeId = $("#property_type_id").val();
    filterSettings(propertyTypeId);

    $("#property_type_id").change(function (){
        let propertyTypeId = $("#property_type_id").val();
        filterSettings($("#property_type_id").val());
        // oneCheckedSibling();
    })
    $(".search-row__cell--category.select_city_data").change(function (){
        $("#filterloading").show();
    })
    function filterSettings(page=1)
    {
        console.log(page)
        $("#filterloading").show();
        $(".filter_divs").hide();
        $(".filter_divs").html('');
        $.ajax({
            url: "/_ajax?core[ajax]=true&core[call]=homdom.FilterChangeForm",
            data: {'page_id': page,'url': window.location.href},
            success: function (data) {
                $("#filterloading").hide();
                $(".filter_div_"+page).html(data);
                $(".filter_div_"+page).show();

                oneCheckedSibling();
                if (page == 1) {
                    $("#filterloading").hide();
                    select2Buildings();
                }
                else if(page == 2) {
                    $('.js-example-basic-single').select2();
                    $("#filterloading").hide();
                }
            }
        });
    }


    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,
            function (m, key, value) {
                vars[key] = value;
            });
        return vars;
    }


    function select2Buildings(){
        $('#buildings').select2({
            placeholder: "<?=AIN::getPhrase('homdom.select_building')?>",
            language: {
                searching: function() {
                    return "<?=AIN::getPhrase('homdom.searching')?>";
                },
                noResults: function(){
                    return "<?=AIN::getPhrase('homdom.not_found')?>"
                }
            },

            ajax: {
                url: "/_ajax?core[ajax]=true&core[call]=homdom.searchBuilding",
                data: function(params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }
                    return query;
                },
                delay: 600,
                cache: true
            }
        });
    }
    function oneCheckedSibling(){
        // $('body').on('click','oneChecked input[type=checkbox]', function(){
        $('.oneChecked input[type=checkbox]').click(function(){
            // e.preventDefault();
            console.log("click chbox");
            if ($(this).is(":checked")){
                $(this).parents(".oneChecked").siblings().find("input").prop('checked',false);
            }
            else {
                $(this).parents(".oneChecked").siblings().find("input").prop('checked',);
            }
        });
        $(".integer_num").inputmask({
            alias: "integer",
        });
    }
    oneCheckedSibling();
</script>

<script type="text/javascript">
    $(document).ready(function() {
        function matchCustom(params, data) {
            // If there are no search terms, return all of the data
            if ($.trim(params.term) === '') {
                return data;
            }

            // Do not display the item if there is no 'text' property
            if (typeof data.text === 'undefined') {
                return null;
            }

            // `params.term` should be the term that is used for searching
            // `data.text` is the text that is displayed for the data object
            if (data.text.indexOf(params.term) > -1) {
                var modifiedData = $.extend({}, data, true);
                //modifiedData.text += ' (matched)';

                // You can return modified objects from here
                // This includes matching the `children` how you want in nested data sets
                return modifiedData;
            }

            // Return `null` if the term should not be displayed
            return null;
        }

        $(".js-example-matcher").select2({
            matcher: matchCustom
        });
    });
</script>
<script>
    $(document).ready(function() {

        $('select.select_tags').select2({
            tags: true,
            maximumInputLength: 5,
            placeholder: "Otaq sayı",
            createTag: function (params) {
                var term = $.trim(params.term);

                if (term === '') {
                    return null;
                }

                return {
                    id: term,
                    text: term,
                    newTag: false // add additional parameters
                }
            }
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
<script>
    const observer = lozad();
    observer.observe();
</script>


@endsection