<main class="main">
    <div class="section_wrap wrap_announce_filter">
        <div class="section_body">
            <div class="main_center">
                <div class="section_headers">
                    <h1 class="address_h">Mənzil alın </h1>
                    <?php $search = $this->_aVars['searchForm'] ?>

                </div>
                <div class="header_bg">
                    <div class="search-container" data-lotriver-header="">
                        {{template file='homdom.block.advanced_search'}}
                    </div>
                </div>
                <div class="wrap_filter_icons">
                    <form action="{{ url link='offers' }}">
                        <div class="wr_flt_right">

                            <ul id="" class="ch-pr_tab_head">
                                <li class=" click_tab current_in" data-id="1"><a href="javascript:void(0)" role="tab"><button type="button" class="itms_btn_change grid_btn"></button> </a></li>
                                <li class=" click_tab" data-id="2"><a href="javascript:void(0)" role="tab"><button type="button" class="itms_btn_change line_btn"></button> </a></li>
                            </ul>
                            <div class="items_select_date">
                                <div class="custom_select">
                                    <select name="select" id="" class="select-regist">
                                        <option value="" disabled>Tarix üzrə </option>
                                        <option value="">1 gün</option>
                                        <option value="">3 gün</option>
                                        <option value="">1 həftə</option>
                                        <option value="">1 ay</option>
                                        <option value="">1 il</option>
                                        <option value="">hamısı</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="" class="ch-prf_tabs offers_div">
                    {{template file='homdom.block.offersPage'}}
                </div>

                <div  style="text-align: center; display: none" id="loading">
                    <img src="/theme/frontend/homdom/style/img/loading.gif" alt="">
                </div>

            </div>
        </div>
    </div>


</main>

@section('js')
<script src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>

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

    function tabChange(currentTab = $('li.click_tab.current_in').attr('data-id'))
    {
        if (currentTab == 1) {
            $('body div.tab_div_link[data-id=1]').show()
            $('body div.tab_div_link[data-id=2]').hide();
        }
        else{
            $('body div.tab_div_link[data-id=2]').show()
            $('body div.tab_div_link[data-id=1]').hide()
        }
    }


    function carousel()
    {
        $('.wrap_my_annouce .owl-carousel').owlCarousel({
            items: 1,
            loop: false,
            margin: 10,
            autoplay: false,
            autoplayTimeout: 3000,
            autoplaySpeed: 1500,
            autoplayHoverPause: true,
            smartSpeed: 1500,
            nav: true,
            responsive:{
                0:{
                    // loop: true,
                    // autoplay: true,
                    // margin: 17,
                    items:1
                },
                480:{
                    // margin: 20,
                    items:1
                },
                700:{
                    // margin: 20,
                    items:1
                },
                1000:{
                    // margin: 30,
                    items:1
                }
            }
        });
    }
    function showNumber()
    {
        // ! SHOW NUMBER
        $(".show_number").click(function(e){
            $(this).addClass("show_number_clicked");
        });
        // ! SHOW NUMBER
    }
</script>

<script>
    tabChange()
    carousel()
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
                url: "/_ajax?core[ajax]=true&core[call]=homdom.dynamicPageInfinity",
                data: {'page': pageNum,'slug':"{{$page.slug}}"},
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
                    tabChange();
                    carousel();
                    setHeights();
                    showNumber();
                }
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                // alert('server not responding...');
            });
    }
</script>

<script>
    $(".click_tab").click(function (){
        let tabId = $(this).attr('data-id');
        $(".click_tab").removeClass('current_in')
        $(".click_tab[data-id='"+tabId+"']").addClass('current_in')
        tabChange(tabId)
    });

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