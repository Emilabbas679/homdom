<?php defined('AIN') or exit('NO DICE!'); ?>
<?php /* Cached: December 12, 2021, 5:29 pm */ ?>
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
