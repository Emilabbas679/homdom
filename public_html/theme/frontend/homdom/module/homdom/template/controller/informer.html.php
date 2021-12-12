<main class="main">
    <div class="section_wrap wrap_agency">
        <div class="section_body">
            <div class="main_center">
                <div class="informer_page">
                    <div class="left_inform">
                        <?php $search = $this->_aVars['searchForm']; ?>
                        <form class="simple_form search-form js-search-form " id="new_q"  action="" method="get">
                            
                            <div class="header_bg">
                                <div class="search-container" data-lotriver-header="">
                                    <!-- {{template file='homdom.block.advanced_search'}} -->
                                    <div class="search">
                                            <div id="ads_search_targets" style="display: none">
                                                <?php if (isset($search['targets'])){
                                                    foreach ($search['targets'] as $id) {  ?>
                                                        <input name='targets[]' id='target_<?=$id?>' value='<?=$id?>'>
                                                <?php } }  ?>
                                            </div>
                                            <div id="ads_search_localities" style="display: none">
                                                <?php if (isset($search['localities'])){
                                                    foreach ($search['localities'] as $id) {  ?>
                                                        <input name='localities[]' id='locality_<?=$id?>' value='<?=$id?>'>
                                                    <?php } }  ?>
                                            </div>
                                            <div id="ads_search_metros" style="display: none">
                                                <?php if (isset($search['metros'])){
                                                    foreach ($search['metros'] as $id) {  ?>
                                                        <input name='metros[]' id='metro_<?=$id?>' value='<?=$id?>'>
                                                    <?php } }  ?>
                                            </div>
                                            <div class="search-row d_block">
                                                <div class="add_row">
                                                    <div class="add_col col_2 ">
                                                        <div class="add_col  p_10">
                                                            <div class="add_col col_2 select_city_data  p_0">
                                                                <select class="js-example-basic-single " name="offer_type" >
                                                                    <option  value="0" <?=AIN::getService('homdom.helpers')->selected_exist($search, 'offer_type', '0')?> >{{phrase var='homdom.all'}}</option>
                                                                    <option  value="2" <?=AIN::getService('homdom.helpers')->selected_exist($search, 'offer_type', '2')?>>{{phrase var='homdom.rent_offers'}}</option>
                                                                    <option  value="1" <?=AIN::getService('homdom.helpers')->selected_exist($search, 'offer_type', '1')?>>{{phrase var='homdom.sale_offers'}}</option>
                                                                </select>
                                                            </div>
                                                            <div class="add_col col_2 ">
                                                                <div class="search-row__cell search-row__cell--category select_city_data">
                                                                    <select class="js-example-basic-single filter_select_items" id="property_type_id" name="property_type_id" >
                                                                        <option value="1" data-item="1" <?=AIN::getService('homdom.helpers')->selected_exist($search, 'property_type_id', '1')?>>{{ phrase var='homdom.offer_property_type_id_1' }}</option>
                                                                        <option value="2" data-item="2" <?=AIN::getService('homdom.helpers')->selected_exist($search, 'property_type_id', '2')?>>{{ phrase var='homdom.offer_property_type_id_2' }}</option>
                                                                        <option value="3" data-item="3" <?=AIN::getService('homdom.helpers')->selected_exist($search, 'property_type_id', '3')?>>{{ phrase var='homdom.offer_property_type_id_3' }}</option>
                                                                        <option value="4" data-item="4" <?=AIN::getService('homdom.helpers')->selected_exist($search, 'property_type_id', '4')?>>{{ phrase var='homdom.offer_property_type_id_4' }}</option>
                                                                        <option value="5" data-item="5" <?=AIN::getService('homdom.helpers')->selected_exist($search, 'property_type_id', '5')?>>{{ phrase var='homdom.offer_property_type_id_5' }}</option>
                                                                        <option value="6" data-item="6" <?=AIN::getService('homdom.helpers')->selected_exist($search, 'property_type_id', '6')?>>{{ phrase var='homdom.offer_property_type_id_6' }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="add_col col_2 p_0">
                                                        <div class="add_col col_2">
                                                            <div class="search-row__cell search-row__cell--rooms flex_romms p_10">
                                                                <div class="count_room_sect">
                                                                    <?php $s_room_count =  (isset($search['room_count']) and count($search['room_count'])) ? implode(',', $search['room_count']) : ""; ?>
                                                                    <input type="text" class="count_room_text" placeholder="{{ phrase var='homdom.room_count' }}" value="<?=$s_room_count?>" >
                                                                </div>
                                                                <div class="room_dropdown">
                                                                    <ul class="count_room_list">
                                                                        <?php for ($i=1; $i<=6; $i ++){ ?>
                                                                            <li>
                                                                                <label class="check_rm">
                                                                                    <input type="checkbox" name="room_count[]" value="<?=$i?>" class="ch_list" <?=AIN::getService('homdom.helpers')->checkedIfInArray($search, 'room_count', $i)?>>
                                                                                    <span><?php if ($i != 6) echo $i; else echo $i.'+'?> </span>
                                                                                </label>
                                                                            </li>
                                                                        <?php } ?>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="add_col col_2">
                                                            <div class="all_filter_min_max">
                                                                <div class="filter_name add_col col_3 p_0">{{ phrase var='homdom.area' }}</div>
                                                                <div class="filter_m_inpt add_col col_5 p_0">
                                                                    <div class="add_inp_number">
                                                                        <input type="text" name="min_area" value="<?=AIN::getService('homdom.helpers')->getValueOfInput($search, 'min_area')?>" placeholder="{{phrase var='homdom.min'}}" class="decimal" maxlength="12">
                                                                        <span class="clear_inp_val"></span>
                                                                    </div>
                                                                    <div class="add_inp_number">
                                                                        <input type="text" name="max_area" value="<?=AIN::getService('homdom.helpers')->getValueOfInput($search, 'max_area')?>" placeholder="{{phrase var='homdom.max'}}" class="decimal" maxlength="12">
                                                                        <span class="clear_inp_val"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="add_row">
                                                    <div class="add_col col_2 ">
                                                        <div class="add_col p_0">
                                                            <div class="all_filter_min_max">
                                                                <div class="filter_name add_col col_3 p_0">{{ phrase var='homdom.price' }}</div>
                                                                <div class="filter_m_inpt add_col col_5 p_0">
                                                                    <div class="add_inp_number">
                                                                        <input type="text" name="min_price"  value="<?=AIN::getService('homdom.helpers')->getValueOfInput($search, 'min_price')?>" placeholder="{{ phrase var='homdom.min' }}" class="decimal" maxlength="12">
                                                                        <span class="clear_inp_val"></span>
                                                                    </div>
                                                                    <div class="add_inp_number">
                                                                        <input type="text" name="max_price"  value="<?=AIN::getService('homdom.helpers')->getValueOfInput($search, 'max_price')?>" placeholder="{{ phrase var='homdom.max' }}" class="decimal" maxlength="12" >
                                                                        <span class="clear_inp_val"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="add_col col_2 p_0">
                                                        <div class="add_col col_2 ">
                                                            <div class="search-row__cell search-row__cell--city select_city_data p_10">
                                                                <select class="advanced_search_districts " name="district_id" id="q_city_id">
                                                                    <?php if (isset($search['district_id'])){
                                                                        $searchDistrict = AIN::getService('homdom.helpers')->getDistrictById($search['district_id']);
                                                                        if ($searchDistrict != null) { ?>
                                                                            <option value="<?=$searchDistrict['id']?>" selected><?=AIN::getPhrase('homdom.'.$searchDistrict['phrase'])?></option>
                                                                    <?php } }?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="add_col col_2 ">
                                                            <div class="search-filters__row search-filters__row--locations" id="js-search-filters-row-locations">
                                                                <div class="search-filters__locations p_10">
                                                                    <a data-reveal-id="js-search-locations" data-locations-tab="metro" data-animation="fade" class="search-filters__location js-search-filters-location" href="">
                                                                        <span class="name">{{phrase var='homdom.metro'}}</span>
                                                                        <span class="count"></span>
                                                                    </a>
                                                                    <a data-reveal-id="js-search-locations" data-locations-tab="landmark" data-animation="fade" class="search-filters__location js-search-filters-location" href="" >
                                                                        <span class="name">{{phrase var='homdom.target'}}</span>
                                                                        <span class="count"></span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="search-filters__container opened">
                                                <div class="search-filters" id="js-search-filters" style="display: block">
                                                    <div class="search-filters__body">
                                                        <div class="add_row item_lbl_child filter_div_1 filter_divs" data-item="1"></div>
                                                        <div class="add_row item_lbl_child filter_div_2 filter_divs" data-item="2"></div>
                                                        <div class="add_row item_lbl_child filter_div_3 filter_divs" data-item="3"></div>
                                                        <div class="add_row item_lbl_child filter_div_4 filter_divs" data-item="4"></div>
                                                        <div class="add_row item_lbl_child filter_div_5 filter_divs" data-item="5"></div>
                                                        <div class="add_row item_lbl_child filter_div_6 filter_divs" data-item="6"></div>

                                                        <div id="filterloading">
                                                            <img src="/theme/frontend/homdom/style/img/loading.gif" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="search-locations reveal-modal" id="js-search-locations">
                                                <div class="reveal-modal-popup">
                                                    <div class="search-locations__city-wrap js-search-locations-city-wrap show" data-city-id="1">
                                                        <div class="reveal-header">
                                                            <div class="search-locations__city">{{phrase var='homdom.baku'}}</div>
                                                            <div class="search-locations__tabs js-locations-tabs">
                                                                <div class="search-locations__tabs_tab" data-locations-tab="region">{{phrase var='homdom.localities'}}</div>
                                                                <div class="search-locations__tabs_tab" data-locations-tab="metro">{{phrase var='homdom.metros'}}</div>
                                                                <div class="search-locations__tabs_tab" data-locations-tab="landmark">{{phrase var='homdom.targets'}}</div>
                                                            </div>
                                                            <span class="close-reveal-modal"></span>
                                                        </div>
                                                        <div class="reveal-content">
                                                            <div class="search-locations__list-wrap js-search-locations-list-wrap">
                                                                <div class="location_group location_group__region" data-locations-items="region">
                                                                    <ul class="search-locations__list">
                                                                        <?php $searchLocalities = AIN::getService('homdom.helpers')->redisLocalities(); ?>
                                                                        <?php foreach ($searchLocalities as $key=>$arr) {?>
                                                                            <li class="search-locations__list_item-wrap">
                                                                                <span class="search-locations__title js-location-item-parent"><?=AIN::getPhrase('homdom.'.$key)?></span>
                                                                                <?php foreach ($arr as $id=>$value) { ?>
                                                                                    <span class="search-locations__list_item js-location-item js-location-item-township search_localities <?=AIN::getService('homdom.helpers')->activeInArray($search, 'localities', $id )?>" data-id="<?=$id?>"><?=AIN::getPhrase('homdom.'.$value)?></span>
                                                                                <?php } ?>
                                                                            </li>
                                                                        <?php } ?>

                                                                    </ul>
                                                                </div>
                                                                <div class="location_group active location_group__metro" data-locations-items="metro">
                                                                    <ul class="search-locations__list">
                                                                        <?php $searchMetros = AIN::getService('homdom.helpers')->redisMetros(); ?>

                                                                        <?php foreach ($searchMetros as $letter=>$arr) {?>
                                                                            <li>
                                                                                <span class="search-locations__title"><?=$letter?></span>
                                                                                <?php foreach ($arr as $k=>$v) { ?>
                                                                                    <span class="search-locations__list_station js-location-item search_metros <?=AIN::getService('homdom.helpers')->activeInArray($search, 'metros', $k )?>" data-id="<?=$k?>"><?=AIN::getPhrase('homdom.'.$v)?><span class="search-locations__list_branch"></span></span>
                                                                                <?php } ?>
                                                                            </li>
                                                                        <?php } ?>
                                                                    </ul>
                                                                </div>
                                                                <div class="location_group location_group__landmark" data-locations-items="landmark">
                                                                    <ul class="search-locations__list">
                                                                        <?php $searchTargets = AIN::getService('homdom.helpers')->redisTargets(); ?>
                                                                        <?php foreach ($searchTargets as $letter=>$arr) {?>
                                                                            <li class="search-locations__list_item-wrap">
                                                                                <span class="search-locations__title"><?=$letter?></span>
                                                                                <?php foreach ($arr as $id=>$value) { ?>
                                                                                    <span class="search-locations__list_item js-location-item search_targets <?=AIN::getService('homdom.helpers')->activeInArray($search, 'targets', $id )?>" data-id="<?=$id?>"><?=AIN::getPhrase('homdom.'.$value)?></span>
                                                                                <?php } ?>
                                                                            </li>
                                                                        <?php } ?>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="search-locations__search-wrap">
                                                                <div class="location_group__region" data-locations-items="region">
                                                                    <input class="search-locations__search-input js-search-locations-search-input hide" placeholder="Rayon və qəsəbə axtarışı" type="text" />
                                                                    <div class="search-locations__search-reset"></div>
                                                                    <div class="search-locations__search-dropdown js-location-dropdown hide">
                                                                        <div class="search-locations__search-dropdown_group" data-group-name="region">
                                                                            <?php foreach ($searchLocalities as $key=>$arr) {?>
                                                                                <li class="search-locations__list_item-wrap">
                                                                                    <span class="search-locations__search-dropdown_item js-location-item-parent"><?=AIN::getPhrase('homdom.'.$key)?></span>
                                                                                    <?php foreach ($arr as $id=>$value) { ?>
                                                                                        <span class="search-locations__search-dropdown_item js-location-item js-location-item-township search_localities" data-id="<?=$id?>"><?=AIN::getPhrase('homdom.'.$value)?></span>
                                                                                    <?php } ?>
                                                                                </li>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="location_group__metro" data-locations-items="metro">
                                                                    <input class="search-locations__search-input js-search-locations-search-input hide" placeholder="Stansiya axtarışı" type="text" />
                                                                    <div class="search-locations__search-reset"></div>
                                                                    <div class="search-locations__search-dropdown js-location-dropdown hide">
                                                                        <div class="search-locations__search-dropdown_group" data-group-name="metro">
                                                                            <?php $searchMetros = AIN::getService('homdom.helpers')->redisMetros(); ?>
                                                                            <?php foreach ($searchMetros as $letter=>$arr) {?>
                                                                                <?php foreach ($arr as $k=>$v) { ?>
                                                                                    <span class="search-locations__search-dropdown_item search-locations__list_station js-location-item search_metros" data-id="<?=$k?>"><?=AIN::getPhrase('homdom.'.$v)?><span class="search-locations__list_branch"></span></span>
                                                                                <?php } ?>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="location_group__landmark" data-locations-items="landmark">
                                                                    <input class="search-locations__search-input js-search-locations-search-input hide" placeholder="Nişangahlar axtarış" type="text" />
                                                                    <div class="search-locations__search-reset"></div>
                                                                    <div class="search-locations__search-dropdown js-location-dropdown hide">
                                                                        <div class="search-locations__search-dropdown_group" data-group-name="landmark">
                                                                            <?php foreach ($searchTargets as $letter=>$arr) {?>
                                                                                    <?php foreach ($arr as $id=>$value) { ?>
                                                                                    <span class="search-locations__search-dropdown_item js-location-item search_targets" data-id="<?=$id?>"><?=AIN::getPhrase('homdom.'.$value)?></span>
                                                                                    <?php } ?>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="search-locations__chosen js-chosen-locations-wrap">
                                                                    <?php if (isset($search['targets'])){
                                                                        foreach ($search['targets'] as $id) {
                                                                            $tget = AIN::getService('homdom.helpers')->getTargetById($id);
                                                                            if ($tget != false) { ?>
                                                                                <span class="search-locations__list_item js-location-item-township search_targets active" data-id="<?=$id?>"><?=AIN::getPhrase('homdom.'.$tget['phrase'])?></span>
                                                                            <?php } } } ?>


                                                                    <?php if (isset($search['localities'])){
                                                                        foreach ($search['localities'] as $id) {
                                                                            $tloc = AIN::getService('homdom.helpers')->getLocalityById($id);
                                                                            if ($tloc != false) { ?>
                                                                                <span class="search-locations__list_item js-location-item search_localities active" data-id="<?=$id?>"><?=AIN::getPhrase('homdom.'.$tloc['phrase'])?></span>
                                                                            <?php } } } ?>

                                                                    <?php if (isset($search['metros'])){
                                                                        foreach ($search['metros'] as $id) {
                                                                            $met = AIN::getService('homdom.helpers')->getMetroById($id);
                                                                            if ($met != false) { ?>
                                                                                <span class="search-locations__list_station js-location-item search_metros active" data-id="<?=$id?>"><?=AIN::getPhrase('homdom.'.$met['phrase'])?></span>
                                                                            <?php } } } ?>
                                                                </div>
                                                                <div class="search-locations__button js-search-locations-button targets_add_button">Axtarışa əlavə et</div>
                                                                <div class="search-locations__reset-filters js-search-locations-reset-filters">Yerləşməni sıfırla</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    </div>
                                </div>
                            </div>
                            <div class="inform_widget_style">
                                <div class="add_col col_1">
                                    <div class="add_col col_2">
                                        <div class="items-widget">
                                            <h3>Blok başlığı </h3>
                                            <input type="text" name="block_title" value="<?=AIN::getService('homdom.helpers')->getValueOfInput($search, 'block_title')?>" style="" placeholder="Blokun başlığını yazın">
                                        </div>
                                    </div>
                                    <div class="add_col col_2">
                                        <div class="items-widget">
                                            <h3>Elan sayı </h3>
                                            <input type="number" name="offer_count" value="<?=AIN::getService('homdom.helpers')->getValueOfInput($search, 'offer_count')?>" style="" placeholder="Elan sayini yazin">
                                        </div>
                                    </div>
                                    <!-- <div class="add_col col_2">
                                        <div class="items-widget">
                                            <h3>İnformer block position </h3>
                                            <select class="informer_position">
                                                <option value="horizontal">Horizontal</option>
                                                <option value="vertical">Vertical</option>
                                            </select>
                                        </div>
                                    </div> -->

                                    <div class="add_col col_2">
                                        <div class="items-widget">
                                            <h3>Blok başlığının rəngi </h3>
                                            <input type="color" name="title_color" value="<?=AIN::getService('homdom.helpers')->getValueOfInput($search, 'title_color')?>" style="" placeholder="Blokun başlığını yazın">
                                        </div>
                                    </div>
                                    <div class="add_col col_2">
                                        <div class="items-widget">
                                            <h3>Blok başlığının fon rəngi </h3>
                                            <input type="color" name="title_bg_color" value="<?=AIN::getService('homdom.helpers')->getValueOfInput($search, 'title_bg_color')?>" style="" placeholder="Blokun başlığını yazın">
                                        </div>
                                    </div>

                                    <div class="add_col col_2">
                                        <div class="items-widget">
                                            <h3>Elan başlığının rəngi </h3>
                                            <input type="color" name="offer_title_color" value="<?=AIN::getService('homdom.helpers')->getValueOfInput($search, 'offer_title_color')?>" style="" placeholder="Blokun başlığını yazın">
                                        </div>
                                    </div>
                                    <div class="add_col col_2">
                                        <div class="items-widget">
                                            <h3>Elan başlığının fon rəngi </h3>
                                            <input type="color" name="offer_title_bg_color" value="<?=AIN::getService('homdom.helpers')->getValueOfInput($search, 'offer_title_bg_color')?>" style="" placeholder="Blokun başlığını yazın">
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="add_col col_1">
                                    <div class="add_col col_2">
                                        <div class="items-widget">
                                            <button type="submit" class="btn_inform">Kodu generasiya et</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="right_inform">
                        <div id="informer_blade">
                            <iframe src="<?=$this->_aVars['iframe']?>" style="height: 410px; width:100%"></iframe>
    
                        </div>
                        <div class="informer_code_sect">
                            <textarea name=""  id="informer_blade_code"  cols="20" rows="3"><iframe style="height: 300px; width:100%" src='<?=$this->_aVars['iframe']?>'></iframe></textarea>
                        </div>
                        <button id="button1" class="button ripple-effect" style="float: right" onclick="CopyToClipboard('informer_blade_code')">Copy</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>



@section('js')
<script src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>

<script>
    // $(".informer_position").change(function() {
    //     if($(this).val() == 0) {
    //         $(".inform_in_block").addClass("horizontal");
    //         $(".inform_in_block").removeClass("vertical");
    //     } else {
    //         $(".inform_in_block").addClass("vertical");
    //         $(".inform_in_block").removeClass("horizontal");
    //     }
        
    // });
    function CopyToClipboard(containeridcontainerid) {
        $('textarea#informer_blade_code').select()
        document.execCommand('copy');
    }

</script>

<script>
    setHeights = function() {
        var $list = $('.section_wrap').not('.a-height');
        $list.each(function() {
            $items = $(this).find('.announce_text');
            $items.css('height', 'auto');
            var perRow = Math.floor($(this).width() / $items.width());
            if (perRow == null || perRow < 2) return true;
            for (var i = 0, j = $items.length; i < j; i += perRow) {
                var maxHeight = 0,
                    $row = $items.slice(i, i + perRow);
                $row.each(function() {
                    var itemHeight = parseInt($(this).outerHeight());
                    if (itemHeight > maxHeight) maxHeight = itemHeight;
                });
                $row.css('height', maxHeight);
            }
        });
    };


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
    });
    $(".search-row__cell--category.select_city_data").change(function (){
        $("#filterloading").show();
    })

    function filterSettings(page=1)
    {
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
                    select2Buildings();
                    $("#filterloading").hide();
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


    let url =window.location.href;
    url = url.replace("offer_type=0&", "");
    url = url.replace("property_type_id=0&", "");
    url = url.replace("property_type_id=0", "");
    url = url.replace("min_area=&", "");
    url = url.replace("max_area=&", "");
    url = url.replace("max_area=", "");
    url = url.replace("built_year_max=&", "");
    url = url.replace("built_year_max=", "");
    url = url.replace("built_year_min=&", "");
    url = url.replace("built_year_min=", "");
    url = url.replace("floors_total_max=&", "");
    url = url.replace("floors_total_max=", "");
    url = url.replace("floors_total_min=&", "");
    url = url.replace("floors_total_min=", "");
    url = url.replace("min_price=&", "");
    url = url.replace("min_price=", "");
    url = url.replace("max_price=&", "");
    url = url.replace("max_price=", "");
    url = url.replace("flat_floor%5Bmin%5D=&", "");
    url = url.replace("flat_floor%5Bmin%5D=", "");
    url = url.replace("flat_floor%5Bmax%5D=&", "");
    url = url.replace("flat_floor%5Bmax%5D=", "");
    window.history.pushState('', 'title', url);

</script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
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
    const observer = lozad();
    observer.observe();
</script>

<script type="text/javascript">
    var pageNum = 1;
    var check = 0;

    $(window).on("scroll", function() {
        var scrollHeight = $(document).height();
        var scrollPosition = $(window).height() +600+ $(window).scrollTop();
        if ((scrollHeight - scrollPosition) / scrollHeight < 0) {

            if (check == 0) {
                pageNum++;
                $('#loading').show();
                loadMoreData(pageNum);
            }
        }
    });


    function loadMoreData(pageNum){
        check = 1;
        $.ajax(
            {
                url: "/_ajax?core[ajax]=true&core[call]=homdom.offersPageInfinity",
                data: {'page': pageNum,'url': window.location.href},
                beforeSend: function()
                {
                    $('#loading').show();
                }
            })
            .done(function(data)
            {
                if(data == " "){
                    $('#loading').html("<?=AIN::getPhrase('homdom.no_more_records')?>");
                }
                else{
                    $('#loading').hide();
                    $(".offers_div").append(data);

                    check = 0;
                    const observer = lozad();
                    observer.observe();
                    // tabChange();
                    // carousel();
                    setHeights();
                    // showNumber();
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                // alert('server not responding...');
            });
    }
</script>


<script>
    (function($){
        $.fn.getFormData = function(){
            var data = {};
            var dataArray = $(this).serializeArray();
            for(var i=0;i<dataArray.length;i++){
                data[dataArray[i].name] = dataArray[i].value;
            }
            return data;
        }
    })(jQuery);

    var myData = $("#new_q").getFormData();
    console.log(myData)


    $( document ).ready(function() {
        $('body').on('change', 'input', function (e) {
            myData = $("#new_q").getFormData();
            console.log(myData)
        })

        $('body').on('change', 'select', function (e) {
            myData = $("#new_q").getFormData();
            console.log(myData)

        })
    })


</script>
@endsection