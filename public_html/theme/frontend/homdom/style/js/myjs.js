//TAB ------>>
$(document).ready(function () {
  $("#tabs_sec>div").hide(); // Initially hide all content
  $("#ch-prf_tabs_btns li:first").attr("id", "current_in"); // Activate first tab
  $("#tabs_sec>div:first").fadeIn(); // Show first tab content
  $('#ch-prf_tabs_btns li a').click(function (e) {
      e.preventDefault();
      if ($(this).attr("id") == "current_in") { //detection for current tab
          return
      } else {
          $("#tabs_sec>div").hide(); //Hide all content
          $("#ch-prf_tabs_btns li").attr("id", ""); //Reset id's
          $(this).parent().attr("id", "current_in"); // Activate this
          $($(this).attr('href')).fadeIn(); // Show content for current tab
      }

      // reinitializeSwiper(swiper);

  });
});

$(document).ready(function () {
  $("#tabs_sec_2>div").hide(); // Initially hide all content
  $("#ch-prf_tabs_btns_2 li:first").attr("id", "current_in"); // Activate first tab
  $("#tabs_sec_2>div:first").fadeIn(); // Show first tab content
  $('#ch-prf_tabs_btns_2 li a').click(function (e) {
      e.preventDefault();
      if ($(this).attr("id") == "current_in") { //detection for current tab
          return
      } else {
          $("#tabs_sec_2>div").hide(); //Hide all content
          $("#ch-prf_tabs_btns_2 li").attr("id", ""); //Reset id's
          $(this).parent().attr("id", "current_in"); // Activate this
          $($(this).attr('href')).fadeIn(); // Show content for current tab
      }

      // reinitializeSwiper(swiper);

  });
  
});

// $(document).ready(function () {
//   $('.click_tab').each(function () {
//
//     let tb_link_id = $(this).data('id');
//
//     $(this).click(function (e) {
//       e.preventDefault();
//
//       $(this).addClass("current_in");
//       $(this).siblings().removeClass("current_in");
//
//       $(".offers_div .tab_div_link[data-id=" + tb_link_id + "]").addClass("current_in");
//       $(".offers_div .tab_div_link[data-id=" + tb_link_id + "]").siblings().removeClass("current_in");
//
//       $(".offers_div .tab_div_link").hide();
//       $(".offers_div .tab_div_link.current_in").show();
//
//     });
//
//   });
//
// });


// function make_button_active(tab) {
//   //Get item siblings
//   var siblings = tab.siblings();

//   //Remove active class on all buttons
//   siblings.each(function(){
//       $(this).attr("id","");
//   })

//   //Add the clicked button class
//   tab.attr("id", "current_in");
//   // console.log(tab.attr("id", "current_in")+"fffff");
//   // tab.attr('href').fadeIn();
// }
// function make_sect_active(tab) {
//   //Get item siblings
//   var siblings = tab.siblings();

//   //Remove active class on all buttons
//   siblings.each(function(){
//       $(this).fadeOut();
//   })

//   //Add the each
//   tab.fadeIn();
//   // console.log(tab.attr("id", "current_in")+"fffff");
//   // tab.attr('href').fadeIn();
// }

// //Attach events to menu
// $(document).ready(function(){
    
//   if (localStorage) { 
//       var ind = localStorage['tab'];       
//       // var ind2 = localStorage['tab2'];       
//       make_button_active($('#ch-prf_tabs_btns li').eq(ind));
//       // make_sect_active($('#tabs_sec>div').eq(ind));
//   }
      
//   $("#ch-prf_tabs_btns li a").click(function () {
//       if(localStorage){ 
//           localStorage['tab'] = $(this).parents("li").index();
//           // localStorage['tab'] = $("#tabs_sec>div").index();
//       }
//       make_button_active($(this).parents("li"));
//       // make_sect_active("#tabs_sec>div");
//   });
//   // $("#tabs_sec>div").each(function () {
//   //     if(localStorage){ 
//   //         localStorage['tab'] = $(this).index();
//   //     }
//   //     make_sect_active($(this));
//   // });

// });


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

  var $list2 = $('.section_wrap');
  $list2.each(function() {
      $items2 = $(this).find('.announce_adrs');
      $items2.css('height', 'auto');
      var perRow = Math.floor($(this).width() / $items2.width());
      if (perRow == null || perRow < 2) return true;
      for (var i = 0, j = $items2.length; i < j; i += perRow) {
          var maxHeight = 0,
              $row = $items2.slice(i, i + perRow);
          $row.each(function() {
              var itemHeight = parseInt($(this).outerHeight());
              if (itemHeight > maxHeight) maxHeight = itemHeight;
          });
          $row.css('height', maxHeight);
      }
  });
  var $list3 = $('.resident_complex_container');
  $list3.each(function() {
      $items3 = $(this).find('.res_info');
      $items3.css('height', 'auto');
      var perRow = Math.floor($(this).width() / $items3.width());
      if (perRow == null || perRow < 2) return true;
      for (var i = 0, j = $items3.length; i < j; i += perRow) {
          var maxHeight = 0,
              $row = $items3.slice(i, i + perRow);
          $row.each(function() {
              var itemHeight = parseInt($(this).outerHeight());
              if (itemHeight > maxHeight) maxHeight = itemHeight;
          });
          $row.css('height', maxHeight);
      }
  });


};
setHeights();

$(document).ready(function(){setTimeout(function(){ 
  setHeights();
}, 1) });

$(window).on('resize', function() {
  setTimeout(function() {
      setHeights()
  }, 1)
});

// TAB ------>>



// SHOW HIDE PASSWORD
$(document).ready(function() {
// function resBlockHover() {
//   $(".res_items_link").hover(function(){
//     // $(this).find(".res_adrs_info").fadeToggle();
//     setHeights();
//   });
// }
// resBlockHover();
// !Room count dropdown

// benefit tabs
function benefitTabs() {
  $(".clicked_tab_btn").each(function(index) {
    if($(this).hasClass("active")){
      $(".bf_tb_content").find(".bf_tb_items[data-id="+ index +"]").addClass("active");
    }

    $(this).click(function() {
      $(this).toggleClass("active");
      $(this).siblings().removeClass("active");

      if($(this).hasClass("active")) {
        $(".bf_tb_content").find(".bf_tb_items[data-id=" + index + "]").addClass("active");
        $(".bf_tb_content").find(".bf_tb_items[data-id=" + index + "]").siblings().removeClass("active");
      }
      
    });
  });
}
benefitTabs();
// benefit tabs

function checkRooms() {
  let clickDl = $(".count_room_text");
  clickDl.attr("readonly", true);

  clickDl.click(function(e) {
    e.stopPropagation();
    $(this).parents(".count_room_sect").siblings(".room_dropdown").slideToggle();
    $(this).parents(".count_room_sect").toggleClass("drop_active");
  });
  $(".room_dropdown").click(function(e) {e.stopPropagation()});
  $("body").click(function() {
    $(".count_room_sect").siblings(".room_dropdown").slideUp();
    $(".count_room_sect").removeClass("drop_active");
  });

  var sList = [];
  $('input.ch_list').each(function () {
    if($(this).is(":checked")) {
      sList.push($(this).val());
      sList.sort();
      $(clickDl).val(sList+" otaq");
    }
    $(this).click(function () {
      if($(this).is(":checked")) {
        sList.push($(this).val());
        sList.sort();
        $(clickDl).val(sList+" otaq");
      } else {
        for( var i = 0; i < sList.length; i++){
          if ( sList[i] === $(this).val()) {
              sList.splice(i, 1);
              sList.sort();
              if(sList == "") {
                $(clickDl).val("");
              } else {
                $(clickDl).val(sList+" otaq");
              }
          }
        }
      }
    });
  });
}
checkRooms();
// !Room count dropdown

// !ipoteka calculatro
function detailsMortgage() {
  $(".mrtg_more").click(function () {
    $(".mortgage_details").slideToggle();
    $(".mortgage_details").toggleClass("active_details");
  });
}
detailsMortgage();


function rangeChange () {
  $(".range_slider").each(function() {
    let min = Number($(this).attr("min"));
    let max = Number($(this).attr("max"));
    let inp_val = Number($(this).val());
    let range_bg = Number((inp_val - min) * 100 / (max - min));

    // $(this).siblings(".row_rg_input").find(".range_val").val($(this).val());

    if($(this).val() === ""){
      $(this).css("background-size","0% 100%");
    } else {
      $(this).css("background-size",range_bg + "% 100%");
    }

    $(this).on('input', function() {

      let inp_val = $(this).val();
      let range_bg = (inp_val - min) * 100 / (max - min);

      $(this).siblings(".row_rg_input").find(".range_val").val($(this).val());
      $(this).css("background-size",range_bg + "% 100%");
      // mortgageCalc();
    });
  });
  // $(".range_val").change(function() {  
  //   let min = parseInt($(this).attr('min'));
  //   let max = parseInt($(this).attr('max'));
  //   let inp_val = $(this).val();
  //   let range_bg = (inp_val - min) * 100 / (max - min);
    
  //   $(this).parents(".row_rg_input").siblings(".range_slider").val($(this).val());
  //   // mortgageCalc();
  //   // if ($(this).val() >= max)
  //   // {
  //   //     $(this).val(max);
  //   // }
  //   // else if ($(this).val() <= min )
  //   // {
  //   //   if($(this).val() === "")
  //   //   {
  //   //     $(this).val();
  //   //   } else {
  //   //     $(this).val(min);
  //   //   }
  //   // } else {
  //   //   $(this).val();
  //   // }

  //   if($(this).val() === "" || $(this).val() === 0 || $(this).val() === null){
  //     $(this).parents(".row_rg_input").siblings(".range_slider").css("background-size","0% 100%");
  //   } else {
  //     $(this).parents(".row_rg_input").siblings(".range_slider").css("background-size",range_bg + "% 100%");
  //   }
    
    
  // });
  // $(".range_val").keyup(function() {      
  //   let min = Number($(this).attr("min"));
  //   let max = Number($(this).attr("max"));
  //   let inp_val = Number($(this).val());
  //   let range_bg = Number((inp_val - min) * 100 / (max - min));

  //   $(this).parents(".row_rg_input").siblings(".range_slider").val($(this).val());
  //   // mortgageCalc();
  //   // console.log($(this).val());
  //   // if (inp_val >= max)
  //   // {
  //   //   inp_val = $(this).val(max);
  //   //     console.log(inp_val);
  //   // }
  //   // if (inp_val <= min)
  //   // {
  //   //   inp_val = $(this).val(max);
  //   //     console.log(inp_val);
  //   // }
  //   // else if (inp_val <= min )
  //   // {
  //   //   if(inp_val === "")
  //   //   {
  //   //     inp_val = $(this).val();
  //   //   } else {
  //   //     inp_val = $(this).val(min);
  //   //   }
  //   // } else {
  //   //   inp_val = $(this).val();
  //   // }

  //   if($(this).val() === "" || $(this).val() === 0 || $(this).val() === null){
  //     $(this).parents(".row_rg_input").siblings(".range_slider").css("background-size","0% 100%");
  //   } else {
  //     $(this).parents(".row_rg_input").siblings(".range_slider").css("background-size",range_bg + "% 100%");
  //   }

  // });
  // function mortgageCalc() {
  //   let property_val = $(".property_val").val();
  //   $(".monthly_payment").html(property_val);
  // }

  // $(".mrt_reset_btn").click(function () {
  //   let min = Number($(".range_val").attr("min"));
  //   $(".range_val").val(min);
  //   $(".range_slider").val(min);
  //   mortgageCalc();
  // });

}
rangeChange ();


$('#_type').on('change', function () {

  if ($(this).val() === false) {
    $('#_paymentPercentage').val(4.0).parents(".row_rg_input").siblings('input').attr('min', 4.0).attr('max', 8).val(4.0);
    $('#_creditPeriod').parents(".row_rg_input").siblings('input').attr('max', 300);
    // if (Number($('#_creditPeriod').val()) > 300) $('#_creditPeriod').val(300);      
  }
  else {
    $('#_paymentPercentage').val(1.0).parents(".row_rg_input").siblings('input').attr('min', 1.0).attr('max', 4).val(1.0);
    $('#_creditPeriod').parents(".row_rg_input").siblings('input').attr('max', 360);
  }

});

$('#_houseValue').on('input click change', function (e) {
  var val = (Number($('#_houseValue').val()) * 20 / 100).toFixed(2);
  var max = (Number($('#_houseValue').attr("max"))).toFixed(2);
  $('#_initialPayment').val(val);
  $('#_initialPayment').parents(".row_rg_input").siblings('input[type=range]').attr('min', val).attr('max', max).val(val);
  rangeChange ();
});
$('#_houseValue').parents(".row_rg_input").siblings('input[type=range]').on('input click change', function (e) {
  var val = (Number($('#_houseValue').val()) * 20 / 100).toFixed(2);
  var max = (Number($('#_houseValue').attr("max"))).toFixed(2);
  $('#_initialPayment').val(val);
  $('#_initialPayment').parents(".row_rg_input").siblings('input[type=range]').attr('min', val).attr('max', max).val(val);
  rangeChange ();
});

$('#_calculator').find('input').on('input change', function () {
  if ($(this).parents(".row_rg_input").siblings('input[type=range]').length) {
      if (Number($(this).val()) > Number($(this).parents(".row_rg_input").siblings('input[type=range]').attr('max'))) {
          $(this).val(Number($(this).parents(".row_rg_input").siblings('input[type=range]').attr('max')));
      }
  }
  let min = Number($(this).attr("min"));
  let max = Number($(this).attr("max"));
  let inp_val = Number($(this).val());
  let range_bg = Number((inp_val - min) * 100 / (max - min));
  
  if($(this).val() === "" || $(this).val() === 0 || $(this).val() === null){
    $(this).parents(".row_rg_input").siblings(".range_slider").css("background-size","0% 100%");
  } else {
    $(this).parents(".row_rg_input").siblings(".range_slider").css("background-size",range_bg + "% 100%");
  }
  rangeChange ();
});


function mortgageCalc() {
  var mortgagePercentage = Number($('#_paymentPercentage').val()) / 100;
  var guarantee = 0;
  var houseValue = Number($('#_houseValue').val());
  var creditPeriod = Number($('#_creditPeriod').val());
  var initialPayment = Number($('#_initialPayment').val());
  var monthlyIncome = Number($('#_monthlyIncome').val());
  var familyComposition = Number($('#_familyComposition').val());
  var otherLiab = Number($('#_otherLiab').val());
  var ipp = 0.20;
  var livingMin = 173;
  var insuranceDeg = 0.0003;

  var _credit = houseValue - initialPayment;
  var _livingExpense = familyComposition * livingMin;
  var _creditPeriod = creditPeriod;
  var _totalProfit = monthlyIncome - otherLiab;

  var _y1 = initialPayment / ipp;

  if (houseValue > _y1) credit = _y1 - initialPayment;


  var _monthlyPayment = (_credit * (mortgagePercentage / 12)) / (1 - 1 / Math.pow(1 + (mortgagePercentage / 12), +_creditPeriod));

  var _guaranteePayment = _credit * insuranceDeg;
  if (guarantee == 0) _guaranteePayment = 0;

  var _maxMonthlyPayment = monthlyIncome * 0.7;


  if ((_monthlyPayment + _guaranteePayment) > _maxMonthlyPayment) {
      _monthlyPayment = _maxMonthlyPayment - _guaranteePayment;
      _credit = (_maxMonthlyPayment) / ((mortgagePercentage / 12) / (1 - 1 / Math.pow(1 + (mortgagePercentage / 12), _creditPeriod)));

  }


  var _insurancePayment = _credit * 0.0007;


  if ((_monthlyPayment + _guaranteePayment + _insurancePayment + _livingExpense) > _totalProfit) {

      _credit = (_totalProfit - _livingExpense - _guaranteePayment) / ((mortgagePercentage / 12) / (1 - 1 / Math.pow(1 + (mortgagePercentage / 12), _creditPeriod)));

      _insurancePayment = _credit * 0.0007;

      _credit = (_totalProfit - _livingExpense - _guaranteePayment - _insurancePayment) / ((mortgagePercentage / 12) / (1 - 1 / Math.pow(1 + (mortgagePercentage / 12), _creditPeriod)));

      _monthlyPayment = (_credit * (mortgagePercentage / 12)) / (1 - 1 / Math.pow(1 + (mortgagePercentage / 12), _creditPeriod));

      // console.log('***** Monthly Payment test2: ', _monthlyPayment.toFixed(2));
      var _insurancePayment = _credit * 0.0007;

      var _guaranteePayment = _credit * insuranceDeg;
      if (guarantee == 0) _guaranteePayment = 0;
  }

  if (_credit < 3000) {
      _credit = 0;
      _monthlyPayment = 0;
      _insurancePayment = 0;
      _guaranteePayment = 0;
  }


  $('#_result').find('#_creditAmount').text(_credit.toFixed(2));
  $('#_result').find('#_monthlyPayment').html(_monthlyPayment.toFixed(2));
  $('#_result').find('#_guaranteePayment').text(_guaranteePayment.toFixed(2));
  $('#_result').find('#_insurancePayment').text(_insurancePayment.toFixed(2));
  $('#_result').find('#_creditPeriodRes').text(_creditPeriod);
  // if (Number(_creditPeriod) < 36 || Number(_monthlyPayment) <= 0 || Number(_credit) < 3000 || Number(_insurancePayment) <= 0) $('#_result').find('.col-md-6').css('color', 'red');
  $('#_result').find('#_creditRange').text(creditPeriod);
  $('#_result').slideDown();


}


  $('#mrt_reset_btn').on('click', function () {
    $('#_calculator').find('input').each(function () {
      let min = Number($(this).attr("min"));
      $(this).val(0);
      $("#_birthDate").val("");
      mortgageCalc();
      rangeChange ();
    });
  });
  $('#_calculator').find('input[type=number]').on('input change keyup', function () {
      var val = $(this).val();
      $(this).parents(".row_rg_input").siblings('input[type=range]').val(val);

      let min = Number($(this).attr("min"));
      let max = Number($(this).attr("max"));
      let inp_val = Number($(this).val());
      let range_bg = Number((inp_val - min) * 100 / (max - min));
      
      if($(this).val() === "" || $(this).val() === 0 || $(this).val() === null){
        $(this).parents(".row_rg_input").siblings(".range_slider").css("background-size","0% 100%");
      } else {
        $(this).parents(".row_rg_input").siblings(".range_slider").css("background-size",range_bg + "% 100%");
      }

      mortgageCalc();
      rangeChange ();
  });

  $('#_calculator').find('#_birthDate').on('input change keyup', function () {
      var fullAge = $('#_birthDate').val();
      // console.log(fullAge);
      var creditRange = 65 * 12 - Number(fullAge[0]) * 12 - Number(fullAge[1]);
      // console.log(fullAge);
      // console.log(creditRange);

      var _limitMax = 360;

      if (creditRange < 360) _limitMax = creditRange;

      if (creditRange < 36) {
          $('#_creditPeriod').prop('disabled', true).parents(".row_rg_input").siblings('input').prop('disabled', true);
          $('#_result').find('#_error').show();
      }
      else {
          $('#_creditPeriod').prop('disabled', false).parents(".row_rg_input").siblings('input').prop('disabled', false);
          $('#_result').find('#_error').hide();
      }

      $('#_creditPeriod').val(_limitMax);
      $('#_creditPeriod').parents(".row_rg_input").siblings('input').attr('max', _limitMax).val(_limitMax);
      // console.error(_limitMax);
      mortgageCalc();
      rangeChange ();
  });

  $('#_calculator').find('#_monthlyIncome').parents(".row_rg_input").siblings('[type=range]').on('input change keyup', function () {
      var val = Number($(this).val());
      var otherLiab = Number($('#_calculator').find('#_otherLiab').val());
      $('#_otherLiab').attr('max', val);
      $('#_otherLiab').parents(".row_rg_input").siblings('input').attr('max', val);
      if (otherLiab > val) $('#_otherLiab').val(val).parents(".row_rg_input").siblings('input').val(val);
      mortgageCalc();
      rangeChange ();
  });

  $('#_calculator').find('input[type=range]').on('input', function () {
      if (Number($('#_initialPayment').val()) > Number($('#_houseValue').val())) {
          swal({
              title: "İlkin ödəniş məbləği alınacaq evin dəyərindən artıq ola bilməz!",
              confirmButtonColor: "#00695D",
              confirmButtonText: "Bağla",
              type: "warning"
          });
          $('#_initialPayment').val(Number($('#_houseVal').val()));
          return false;
      }
      $(this).parent().find('input[type=number]').val($(this).val());
      mortgageCalc();
      rangeChange ();
  });




// !ipoteka calculatro

  $(".show-password, .hide-password").on('click', function() {

    var passwordId = $(this).parents('.lg_input').find('input');

    if ($(this).hasClass('show-password')) {
      $(passwordId).attr("type", "text");
      $(this).parent().find(".show-password").hide();
      $(this).parent().find(".hide-password").show();
    } else {
      $(passwordId).attr("type", "password");
      $(this).parent().find(".hide-password").hide();
      $(this).parent().find(".show-password").show();
    }
  });


// Modal show and login
// $(".btn_registr_clk").click(function(e){
//   e.stopPropagation();
//   // e.preventDefault();

//   $(this).parents(".sg_col").slideUp();
//   $(".sg_col.registration").slideDown();
// });
// $(".btn_login_clk").click(function(e){
//   e.stopPropagation();
//   e.preventDefault();

//   $(this).parents(".sg_col").slideUp();
//   $(".sg_col.login").slideDown();
// });

// $(".btn_change_clk").click(function(e){
//   e.stopPropagation();
//   e.preventDefault();

//   $(this).parents(".sg_col").slideUp();
//   $(".sg_col.change_password").slideDown();
// });

// // Modal sign_jn and registration part
// $(".sign_in").click(function(e){
//   // btn_for_modal
//   e.preventDefault();
//   $(".sign_in_modal").fadeIn("linear");
// });

$(".pop_close").click(function(){
  $(this).parents(".modal").fadeOut("linear");
});

// // Modal change password part
$(".change_password_btn").click(function(e){
  e.preventDefault();
  $(".change_password_modal").fadeIn("linear");
});

// // Modal our suggestion part
$(".our_suggest_btn").each(function(index){
  $(this).click(function (e) {
    e.preventDefault();
    $(".our_suggest_modal[data-id="+ index +"]").fadeIn("linear");
  });
});


// Show more content
$(".show_more").click(function(e){
  e.stopPropagation();

  $(this).toggleClass("active");
  $(this).parents().siblings(".filter_body").slideToggle(300);

});


// !FILTER all js
// $(".filter_btn_cnt").click(function(){
//   $(".search-container").toggleClass("show");
// });
$(".filter_btn_cnt_hide").click(function(){
  $(".search-container").removeClass("show");
});
$(".filter_btn_cnt").click(function(e) {
  e.stopPropagation();
  $(".search-container").toggleClass("show");
  $('.search-filters__container').toggleClass("opened");
  $('.filter_footer_flx').toggleClass("fixed");
  $('.search-filters').slideToggle();
  $(this).toggleClass("active");

  setTimeout(function() { 
    scrollTopFilter();
  }, 500);
  
  $(".header_bg select").change(function() {
    setTimeout(function() { 
      scrollTopFilter();
      // console.log("hhhh");
    }, 0);
    
  });
});

function scrollTopFilter() {
  let scrollContainer = $(".header_bg").outerHeight() + 150;
  let windowHeight = $(window).height();

  // console.log(scrollContainer);

  if (scrollContainer > windowHeight) {
    $('.filter_footer_flx').addClass("fixed");

  } else {
    $('.filter_footer_flx').removeClass("fixed");
  }

  $(window).scroll(function() {
    // declare variable
    let scrollContainer = $(".header_bg").outerHeight() - 720;
    let topPos = $(this).scrollTop();

    // console.log(scrollContainer + "content");
    // console.log(topPos + "scroll");


    // if user scrolls down - show scroll to top button
    if (topPos >= scrollContainer) {
      $('.filter_footer_flx').removeClass("fixed");

    } else {
      $('.filter_footer_flx').addClass("fixed");
    }

  }); // scroll END
  
}
// scrollTopFilter();
// declare variable
// var scrollTop = $(".scrollTop");





$(".q_category_id").click(function(){
  $(".search-container").removeClass("show");
});

$(".selectric").click(function(){
  $(".search-container").removeClass("show");
  $(".search-filters__container").removeClass("opened");
});
$(".js-search-row-input-label").click(function(){
  $(".search-container").removeClass("show");
  $(".search-filters__container").removeClass("opened");
});
$(".js-search-filters-reset").click(function(){
  $(".search-container input").val("");
  $(".search-container input").prop('checked', false);
  $(".clear_inp_val").removeClass("active");

  // let clickDl = $(".count_room_text");
  // var sList = [];
  // $(".count_room_text").val(sList);
  
  // $('input.ch_list').each(function () {
  //   $(this).attr('checked', false);
  //   $(this).click(function () {
  //     if($(this).is(":checked")) {
  //       sList.push($(this).val());
  //       sList.sort();
  //       $(clickDl).val(sList+" otaq");
  //     } else {
  //       for( var i = 0; i < sList.length; i++){
  //         if ( sList[i] === $(this).val()) {
  //             sList.splice(i, 1);
  //             sList.sort();
  //             if(sList == "") {
  //               $(clickDl).val("");
  //             } else {
  //               $(clickDl).val(sList+" otaq");
  //             }
  //         }
  //       }
  //     }
  //   });
  // });
  
});


$(".filter_select_items").change(function() {


  var select_data = $(this).find(':selected').data('item');
  
  // console.log(select_data);
  // if(select_data){

    // $(".item_lbl_child_1").data('item');
    $(".item_lbl_child[data-item=" + select_data + "]").show();
    $(".item_lbl_child[data-item=" + select_data + "]").siblings().hide();
    // console.log(select_data);

  // }
  
});

$('.clear_inp_val').click(function(){
  // e.preventDefault();
  $(this).siblings("input").val("");
  $(this).removeClass("active");
  $(".valid_slct_1").empty();
  
});

$('.error_message').click(function(){
  // e.preventDefault();
  $(this).slideUp("");
});
// !FILTER all js


// $(".phone").inputmask({"mask": "+(999) 99 999 99 99"});
// Modal show and login


// !VIP and MOVE to top clicked addclass 'click_vip, click_move'
$(".do_vip").click(function(e){
  e.stopPropagation();
  // e.preventDefault();

  $(this).toggleClass("active");

  $(this).parents(".my_anc_info").toggleClass("click_vip");
});

$(".move_top").hover(function(e){
  e.stopPropagation();
  // e.preventDefault();

  $(this).toggleClass("active");

  $(this).parents(".my_anc_info").toggleClass("click_move");
});

$('.selected_togle').click(function(e){
  e.preventDefault();
  $(this).toggleClass("active"); //you can list several class names

  // $(this).text($(this).text() == 'Seçilib' ? 'Seçilmiş et' : 'Seçilib');
  
});

// $('.selected_togle').hover(function(e){
//   e.preventDefault();
//   // $(this).toggleClass("active"); //you can list several class names

//   $(this).text($(this).text() == 'Seçilmişdən çıxart' ? 'Seçilib' : 'Seçilmiş et');
  
// });

// !VIP and MOVE to top clicked addclass 'click_vip, click_move'

//? CLear span siblings input value

$('.btn_tooltip').click(function(){
  $(this).toggleClass("actv");
  $(this).siblings(".mrt_tooltip").fadeToggle();
});
function oneCheckedSibling(){
  $('body').on('click','oneChecked input[type=checkbox]', function(){
  // $('.oneChecked input[type=checkbox]').click(function(){
    // e.preventDefault();
    console.log("click chbox");
    if ($(this).is(":checked")){
      $(this).parents(".oneChecked").siblings().find("input").prop('checked',false);
    } 
    else {
      $(this).parents(".oneChecked").siblings().find("input").prop('checked',);
    }
  });
}
oneCheckedSibling();

$('.add_inp_number input').keyup(function(){
  // e.preventDefault();
  v = $(this).val();
  
  if( v == "") {
    $(this).siblings(".clear_inp_val").removeClass("active");
  } else {
    $(this).siblings(".clear_inp_val").addClass("active");
  }
  
});

$('.add_inp_number input').each(function(){
  // e.preventDefault();
  v = $(this).val();
  if( v == "") {
    $(this).siblings(".clear_inp_val").removeClass("active");
  } else {
    $(this).siblings(".clear_inp_val").addClass("active");
  }
});

$('.item_lbl_child_1 .check_lift input').click(function(){
  // e.preventDefault();
  if ($(this).is(":checked")){
    $(this).parents(".add_check_items").siblings(".check_lift_same").find("input").prop('checked',true);
    $(this).siblings("span").removeClass("inp_null");
    $(this).parents(".add_check_items").siblings().find("input").siblings("span").removeClass("inp_null");
  } 
  else {
    $(this).parents(".add_check_items").siblings(".check_lift_same").find("input").prop('checked',false);
  }
});
$('.item_lbl_child_1 .check_lift_same').find("input").click(function(){
  // e.preventDefault();
  if ($(this).is(":checked") || $(this).parents(".add_check_items").siblings().find(".check_lift_same").find("input").is(":checked")){
    $(this).parents(".add_check_items.static").siblings().find(".check_lift").find("input").prop('checked',true);
  } 
  else {
    $(this).parents(".add_check_items.static").siblings().find(".check_lift").find("input").prop('checked',true);
  }
});
// $('.item_lbl_child_1 .check_lift_same').find("input").each(function(){
//   // e.preventDefault();
//   if ($(this).is(":checked")){
//     $(this).parents(".add_check_items.static").siblings().find(".check_lift").find("input").prop('checked',true);
//   } 
//   else {
//     $(this).parents(".add_check_items.static").siblings().find(".check_lift").find("input").prop('checked',true);
//   }
// });

$(".room_count_change").each(function(index) {
  
  $(this).click(function() {
      var cnt = index;
      var cnt_end = cnt + 1;
      $(".room_change_1").children(".room_input_element").each(function(index) {
        let ind = index + 1;
        if(ind > cnt_end) {
          $(this).removeClass("show");
        } else {
          $(this).addClass("show");
        }
      });
      
      // eachCreateElements(cnt_end);
    // } 
  });
  if($(this).is(":checked")) {
      var cnt = index;
      var cnt_end = cnt + 1;
      $(".room_change_1").children(".room_input_element").each(function(index) {
        let ind = index + 1;
        if(ind > cnt_end) {
          $(this).removeClass("show");
        } else {
          $(this).addClass("show");
        }
      });
  };
  
});
$(".room_count_change_2").each(function(index) {
  
  $(this).click(function() {
      var cnt = index;
      var cnt_end = cnt + 1;
      $(".room_change_2").children(".room_input_element").each(function(index) {
        let ind = index + 1;
        if(ind > cnt_end) {
          $(this).removeClass("show");
        } else {
          $(this).addClass("show");
        }
      });
  });
  if($(this).is(":checked")) {
      var cnt = index;
      var cnt_end = cnt + 1;
      $(".room_change_2").children(".room_input_element").each(function(index) {
        let ind = index + 1;
        if(ind > cnt_end) {
          $(this).removeClass("show");
        } else {
          $(this).addClass("show");
        }
      });
  };
  
});


//? CLear span siblings input value

//! label item clicked all col_1 add "item_lbl_child_"
$('button.hide_error').click(function(){
  $(this).parent(".alert").removeClass("show");
});


  $('body').on('click','.item_lbl_1',function(){
  // e.preventDefault();
  $(".item_lbl_child_1").removeClass("hide");

  $(".item_lbl_child_2").removeClass("active");
  $(".item_lbl_child_3").removeClass("active");
  $(".item_lbl_child_4").removeClass("active");
  $(".item_lbl_child_5").removeClass("active");
  $(".item_lbl_child_6").removeClass("active");
  
});
$('.item_lbl_1').each(function(){
  if($(this).is(":checked")){
    $(".item_lbl_child_1").removeClass("hide");

    $(".item_lbl_child_2").removeClass("active");
    $(".item_lbl_child_3").removeClass("active");
    $(".item_lbl_child_4").removeClass("active");
    $(".item_lbl_child_5").removeClass("active");
    $(".item_lbl_child_6").removeClass("active");
  }
});
$('body').on('click', '.item_lbl_2', function () {
  // e.preventDefault();
  $(".item_lbl_child_1").addClass("hide");

  $(".item_lbl_child_2").addClass("active");

  $(".item_lbl_child_3").removeClass("active");
  $(".item_lbl_child_4").removeClass("active");
  $(".item_lbl_child_5").removeClass("active");
  $(".item_lbl_child_6").removeClass("active");
  
});
$('.item_lbl_2').each(function(){
  // e.preventDefault();
  if($(this).is(":checked")){
    $(".item_lbl_child_1").addClass("hide");

    $(".item_lbl_child_2").addClass("active");

    $(".item_lbl_child_3").removeClass("active");
    $(".item_lbl_child_4").removeClass("active");
    $(".item_lbl_child_5").removeClass("active");
    $(".item_lbl_child_6").removeClass("active");
  }
  
});
$('body').on('click', '.item_lbl_3', function () {
  // e.preventDefault();
  $(".item_lbl_child_1").addClass("hide");

  $(".item_lbl_child_3").addClass("active");

  $(".item_lbl_child_2").removeClass("active");
  $(".item_lbl_child_4").removeClass("active");
  $(".item_lbl_child_5").removeClass("active");
  $(".item_lbl_child_6").removeClass("active");
  
});
$('.item_lbl_3').each(function(){
  // e.preventDefault();
  if($(this).is(":checked")){
    $(".item_lbl_child_1").addClass("hide");

    $(".item_lbl_child_3").addClass("active");

    $(".item_lbl_child_2").removeClass("active");
    $(".item_lbl_child_4").removeClass("active");
    $(".item_lbl_child_5").removeClass("active");
    $(".item_lbl_child_6").removeClass("active");
  }
  
});
$('body').on('click', '.item_lbl_4', function () {
  // e.preventDefault();
  $(".item_lbl_child_1").addClass("hide");

  $(".item_lbl_child_4").addClass("active");

  $(".item_lbl_child_2").removeClass("active");
  $(".item_lbl_child_3").removeClass("active");
  $(".item_lbl_child_5").removeClass("active");
  $(".item_lbl_child_6").removeClass("active");
  
});
$('.item_lbl_4').each(function(){
  // e.preventDefault();
  if($(this).is(":checked")){
    $(".item_lbl_child_1").addClass("hide");

    $(".item_lbl_child_4").addClass("active");

    $(".item_lbl_child_2").removeClass("active");
    $(".item_lbl_child_3").removeClass("active");
    $(".item_lbl_child_5").removeClass("active");
    $(".item_lbl_child_6").removeClass("active");
  }
  
});

$('body').on('click', '.item_lbl_5', function () {
  // e.preventDefault();
  $(".item_lbl_child_1").addClass("hide");

  $(".item_lbl_child_5").addClass("active");

  $(".item_lbl_child_2").removeClass("active");
  $(".item_lbl_child_3").removeClass("active");
  $(".item_lbl_child_4").removeClass("active");
  $(".item_lbl_child_6").removeClass("active");
  
});
$('.item_lbl_5').each(function(){
  // e.preventDefault();
  if($(this).is(":checked")){
    $(".item_lbl_child_1").addClass("hide");

    $(".item_lbl_child_5").addClass("active");

    $(".item_lbl_child_2").removeClass("active");
    $(".item_lbl_child_3").removeClass("active");
    $(".item_lbl_child_4").removeClass("active");
    $(".item_lbl_child_6").removeClass("active");
  }
  
});

$('body').on('click', '.item_lbl_6', function () {
  // e.preventDefault();
  $(".item_lbl_child_1").addClass("hide");

  $(".item_lbl_child_6").addClass("active");

  $(".item_lbl_child_2").removeClass("active");
  $(".item_lbl_child_3").removeClass("active");
  $(".item_lbl_child_4").removeClass("active");
  $(".item_lbl_child_5").removeClass("active");
  
});
$('.item_lbl_6').each(function(){
  // e.preventDefault();
  if($(this).is(":checked")){
    $(".item_lbl_child_1").addClass("hide");

    $(".item_lbl_child_6").addClass("active");

    $(".item_lbl_child_2").removeClass("active");
    $(".item_lbl_child_3").removeClass("active");
    $(".item_lbl_child_4").removeClass("active");
    $(".item_lbl_child_5").removeClass("active");
  }
  
});

//! label item clicked all col_1 add "item_lbl_child_"

});
// SHOW HIDE PASSWORD


setHeights = function() {

  // var $list = $('.grid_content').not('.a-height');
  // $list.each(function() {
  //     $items = $(this).find('.gr_news_content');
  //     $items.css('height', 'auto');
  //     var perRow = Math.floor($(this).width() / $items.width());
  //     if (perRow == null || perRow < 2) return true;
  //     for (var i = 0, j = $items.length; i < j; i += perRow) {
  //         var maxHeight = 0,
  //             $row = $items.slice(i, i + perRow);
  //         $row.each(function() {
  //             var itemHeight = parseInt($(this).outerHeight());
  //             if (itemHeight > maxHeight) maxHeight = itemHeight;
  //         });
  //         $row.css('height', maxHeight);
  //     }
  // });

  var $list2 = $('.section_company').not('.a-height');
  $list2.each(function() {
      $items2 = $(this).find('.compny_items');
      $items2.css('height', 'auto');
      var perRow = Math.floor($(this).width() / $items2.width());
      if (perRow == null || perRow < 2) return true;
      for (var i = 0, j = $items2.length; i < j; i += perRow) {
          var maxHeight = 0,
              $row = $items2.slice(i, i + perRow);
          $row.each(function() {
              var itemHeight = parseInt($(this).outerHeight());
              if (itemHeight > maxHeight) maxHeight = itemHeight;
          });
          $row.css('height', maxHeight);
      }
  });


};
setHeights();

$(document).ready(function(){setTimeout(function(){ 
  setHeights();
}, 1) });

$(window).on('resize', function() {
  setTimeout(function() {
      setHeights()
  }, 1)
});



$(document).ready(function(){


  // !Input change show title start

  $('.lg_inputs').change(function () {

    if ($(this).val() === "") {
  
        $(this).siblings(".lg_inp_bl").css("display", "none");
        $(this).css("padding", "14px 0px 13px 0px");
  
    } else {
        
      $(this).siblings(".lg_inp_bl").css("display", "block");
      $(this).css({"padding": "17px 0px 10px 0px", "background-color": "transparent"});
  
    }
  });
  
  $( ".lg_inputs" ).each(function() {
  
    if ($(this).val() === "") {
        $(this).siblings(".lg_inp_bl").css("display", "none");
        $(this).css("padding", "14px 0px 13px 0px");
    } else {
      $(this).siblings(".lg_inp_bl").css("display", "block");
      $(this).css({"padding": "17px 0px 10px 0px", "background-color": "transparent"});
    }
  
  });
  // !Input change show title end

// ! SHOW NUMBER
$(".show_number").click(function(e){
  $(this).addClass("show_number_clicked");
});
// ! SHOW NUMBER

// ! SHOW HIDE FULL TABLE

$(".title_btn").click(function(e){
  e.stopPropagation();

  $(this).toggleClass("clicked");
  $(this).parents(".house_title").siblings().slideToggle("linear");
});



$(".s_table_1 ul.ag_table_list").each(function() {
	let lng = $(this).find("li").length;
	// console.log(lng);
	if(lng <= 9) {
		$(this).parents(".s_table_1").siblings(".show_hide_btn").addClass("hide_elm");
	} else {
		$(this).parents(".s_table_1").siblings(".show_hide_btn").removeClass("hide_elm");
	}
});
$(".s_table_2 table.ag_table_list").each(function() {
	let lng = $(this).find("tr").length;
	// console.log(lng);
	if(lng <= 6) {
		$(this).parents(".s_table_2").siblings(".show_hide_btn").addClass("hide_elm");
	} else {
		$(this).parents(".s_table_2").siblings(".show_hide_btn").removeClass("hide_elm");
	}
});

$(".show_table_full").click(function(e){
  e.stopPropagation();

  var table_height = $(this).parents().siblings('.table_show_hide').children(".ag_table_list").height();

  $(this).parents(".show_hide_btn").siblings('.table_show_hide').css("max-height", +table_height);
  // $(this).parents(".show_hide_btn").siblings('.table_show_hide').addClass("show");

  $(this).addClass("hide_btn");
  $(this).siblings().addClass("hide_btn");
});
$(".hide_table_full").click(function(e){
  e.stopPropagation();

  var table_min_height = $(this).parents().siblings('.table_show_hide').children(".ag_table_list").height();
  // $(this).parents(".show_hide_btn").siblings('.table_show_hide').removeClass("show");
  $(this).parents(".show_hide_btn").siblings('.s_table_1').css("max-height","118px");
  $(this).parents(".show_hide_btn").siblings('.s_table_2').css("max-height","228px");
  
  $(this).removeClass("hide_btn");
  $(this).siblings().removeClass("hide_btn");
});

  // ! SHOW HIDE FULL TABLE
  // !Three dots button
  $( ".dots_content" ).each(function( index ){

    $(this).children(".three_dots").click(function(e){
        e.stopPropagation();

        $(this).next('.tools-list').slideToggle("linear");
        $(this).next('.tools-list').addClass("nothideee");

        $(this).parents().siblings().find('.tools-list').hide("linear");

    });

  });

  // search show hide
  
  $(".search_opn").click(function(e) {
    e.stopPropagation();
    // $(".menu-btn").removeClass("mobile_show");//click search button hide mobile menu
    $(this).toggleClass("sch-close");

    $(".search-are").slideToggle("200");
    // $(".mobile_hd_bottom").removeClass("nav_desk_toogle"); //click search button hide mobile menu
    $(".mobile_hd_bottom").toggleClass("mbl_btm_p"); //click search button menu padding

  });

  $(".btn-clear").click(function() {
    $('.src-input').val('');
  });

  // Menu click show start

  $(".menu_toggle").click(function() {
    $(".hd_bottom").toggleClass("nav_desk_toogle");
  })
  
  // Menu click show start
  $(".menu-btn").click(function() {
    // $(this).toggleClass("mobile_show");
    // $(".search_opn").removeClass("sch-close");//click menu button hide search area

    $("body").addClass("mm_noscroll");
    $(".mobile_menu").addClass("active");
    // $(".search-are").slideUp("200"); //click menu button hide search area
  })
  $(".close_menu").click(function() {
    // $(this).toggleClass("mobile_show");
    // $(".search_opn").removeClass("sch-close");//click menu button hide search area

    $("body").removeClass("mm_noscroll");
    $(".mobile_menu").removeClass("active");
    // $(".search-are").slideUp("200"); //click menu button hide search area
  })
  
  // Menu click show end

  // $( ".hdr_menu a" ).each(function() {
  //   if ($(this).next().hasClass('dropdown')) {
  //     $(this).addClass('arw_m');
  //     $( ".hdr_menu a.arw_m" ).click(function(e) {
  //       e.preventDefault();
  //       // $(this).toggleClass("arw_m_rotate");
  //       // $(this).parents().siblings().find(".arw_m").removeClass("arw_m_rotate");
  //     });
  //   }
  // });
  // $( ".hdr_menu a.arw_m" ).click(function(e) {
  //   e.preventDefault();
  //   $(this).toggleClass("arw_m_rotate");
  //   $(this).parents().siblings().find(".arw_m").removeClass("arw_m_rotate");
  // });


  function menu_drop() {
    let w_width = $( window ).width();
    if (w_width < 768) {
      $( ".hdr_menu a.arw_m" ).click(function(e) {
        e.preventDefault();
        $(this).next(".dropdown").slideToggle("300");
        $(this).parents().siblings().find(".dropdown").slideUp("300");
      });
    }
  }
  menu_drop();
  // $( window ).resize(function() {
  //   menu_drop();
  // });
  

 
  function accordion_links() {

    $("#myAcrd_title").click(function(){
      $(".accord_menu_responsive .accordion_container").slideToggle("300");
    });

    
  }
  accordion_links();

  // Accordion 
  // Collapse tabs
  // $('.collapse_btn').click(function(e) {
  //   e.preventDefault();
  //     $(this).toggleClass("clp_clicked");
  //     $(this).siblings(".collapse_content").slideToggle("linear");

  //     $(this).parents(".collapse_row").siblings().find(".collapse_btn").removeClass("clp_clicked");
  //     $(this).parents(".collapse_row").siblings().find(".collapse_content").slideUp("linear");
  // });
// Collapse tabs

// Collapse tabs
function collapse() {
  $('.collapse_btn').each(function() {
    if($(this).hasClass("clp_clicked")){
      $(this).siblings(".collapse_content").addClass("active");
      $(this).siblings(".collapse_content.active").slideDown();
    }
  });
  $('.collapse_btn').click(function(e) {
    e.preventDefault();
      $(this).toggleClass("clp_clicked");
      $(this).siblings(".collapse_content").slideToggle("linear");
      $(this).siblings(".collapse_content").addClass("active");

      $(this).parents(".collapse_row").siblings().find(".collapse_btn").removeClass("clp_clicked");

      $(this).parents(".collapse_row").siblings().find(".collapse_content").removeClass("active");
      $(this).parents(".collapse_row").siblings().find(".collapse_content").slideUp("linear");
  });
}
collapse();

// Collapse tabs


  // Accordion 
  // Tags show hide
  $(".other_tags").click(function(e) {
    e.stopPropagation();
    $('.tags').toggleClass("tags_auto");

  });
 
  
 
  // search show hide



});


function resizeMenu () {
  let w_width = $( window ).width();
  if (w_width < 768) {
    $(".tab_mobile_toogle").click(function(){
      $(this).siblings(".tab_row").slideToggle();
    });
    $(".tab_row").children("li").click(function(){
      let this_icon = $(this).find(".tabs_icon > img").attr('src');
      let this_title = $(this).find(".tab_name").text();
      $(this).parent(".tab_row").slideUp();
      $(".tab_mobile_toogle").find(".tabs_icon > img").attr('src', this_icon);
      $(".tab_mobile_toogle").find(".tab_name").text(this_title);
    });
    $(".tab_row").children("li#current_in").each(function(){
      let this_icon = $(this).find(".tabs_icon > img").attr('src');
      let this_title = $(this).find(".tab_name").text();
      $(this).parent(".tab_row").slideUp();
      $(".tab_mobile_toogle").find(".tabs_icon > img").attr('src', this_icon);
      $(".tab_mobile_toogle").find(".tab_name").text(this_title);
    });

  } 
}
// resizeMenu ();
$(document).ready(function(){setTimeout(function(){ 
  resizeMenu ();
}, 1) });

$( window ).resize(function() {
  resizeMenu ();
});

// News like or unlike

$(document).ready(function(){
var $affectedElements = $("div.news-in-top *");
$affectedElements.each(function() {
    var $this = $(this);
    $this.data("orig-size", $this.css("font-size"));
});

$("#btn-increase").click(function() {
    changeFontSize(1);
})

$("#btn-decrease").click(function() {
    changeFontSize(-1);
})

$("#btn-orig").click(function() {
    $affectedElements.each(function() {
        var $this = $(this);
        $this.css("font-size", $this.data("orig-size"));
    });
})

function changeFontSize(direction) {
    $affectedElements.each(function() {
        var $this = $(this);
        $this.css("font-size", parseInt($this.css("font-size")) + direction);
    });
}

});


// !Notification button
$(".notif_btn_link").click(function(e){
  e.stopPropagation();
  $(this).next('.notifications-section').slideToggle("linear");
  // $(this).children('.ricn_img_arw').toggleClass("rarw_transform");
  // $(this).parents('.ricons').siblings().children('.notifications-section').hide("linear");

  // $(this).parents('.ricons').siblings().children(".notif_btn_link").children("span.ricn_img_arw").removeClass("rarw_transform");

  // $(this).parents('.ricons').siblings().click(function(){
  //   $('span.ricn_img_arw').removeClass("rarw_transform");
  // });
});
$('body').on('click', function() {
  $(".notifications-section").slideUp("linear");
  // $(".notif_btn_link").children('span.ricn_img_arw').removeClass("rarw_transform");
});


// masonary 

jQuery(document).ready(function() {
  
	 var $masBlog = jQuery('.grid_content');
	 $masBlog.imagesLoaded(function(){
	 	$masBlog.masonry({
	 		itemSelector : '.grid-item',
	 		columnWidth: '.grid-item'
	 	});
	 });
  
    
});


// masonary 
var swiper = new Swiper('.hash_scroll .swiper-container', {
  slidesPerView: 'auto',
  spaceBetween: 10,
  freeMode: true,
  loop: false,
  freeModeSticky: true,
  // speed: 300,
  // autoplay: {
  //   delay: 200,
  //   slideSpeed: 300,
  //   disableOnInteraction: false,
  // },
  // loopedSlides: 5,
  // pagination: {
  //   el: '.swiper-pagination',
  //   clickable: true,
  // },
});

// $('.hash_scroll .owl-carousel').owlCarousel({
//   margin:10,
//   loop:true,
//   autoWidth:true,
//   items:4
// })

$(document).ready(function() {

// var swiper = new Swiper('.slider_1 .swiper-container', {
//   slidesPerView: 1,
//   spaceBetween: 20,
//   loop: true,
//   // autoHeight: true,
//   allowTouchMove: true,
//   speed: 3500,
//   autoplay: {
//     delay: 2700,
//     slideSpeed: 3500,
//     disableOnInteraction: false,
//   },
//   navigation: {
//       nextEl: '.slider_1 .swiper-button-next',
//       prevEl: '.slider_1 .swiper-button-prev',
//   },
//   pagination: {
//     el: '.slider_1 .swiper-pagination',
//     clickable: true,
//   },
//   observer: true,
//   observeParents: true,
//   // breakpoints: {
//   //     480: {
//   //       slidesPerView: 1,
//   //       spaceBetween: 10,
//   //     },
//   //     600: {
//   //       slidesPerView: 1,
//   //       spaceBetween: 15,
//   //     },
//   //     768: {
//   //       slidesPerView: 1,
//   //       spaceBetween: 15,
//   //     },
//   //     1024: {
//   //       slidesPerView: 1,
//   //       spaceBetween: 20,
//   //     },
//   //   }

// });


$('.owl_sld_1 .owl-carousel').owlCarousel({
  items: 3,
  loop:true,
  margin:30,
  autoplay:true,
  autoplayTimeout:4000,
  autoplaySpeed: 1800,
  autoplayHoverPause:true,
  smartSpeed: 1800,
  nav:true,
  responsive:{
      0:{
          items:1
      },
      480:{
          items:2
      },
      600:{
          items:3
      },
      1000:{
          items:3
      }
  }
});

$('.owl_sld_2 .owl-carousel').owlCarousel({
  items: 4,
  loop:true,
  margin:40,
  autoplay:true,
  autoplayTimeout:4000,
  autoplaySpeed: 1800,
  autoplayHoverPause:true,
  smartSpeed: 1800,
  nav:true,
  responsive:{
      0:{
          items:1
      },
      480:{
          items:2
      },
      600:{
          items:3
      },
      1000:{
          items:4
      }
  }
});

$('.owl_sld_3 .owl-carousel').owlCarousel({
  items: 6,
  loop: true,
  margin: 30,
  autoplay: true,
  autoplayTimeout: 4000,
  autoplaySpeed: 1800,
  autoplayHoverPause: true,
  smartSpeed: 1800,
  nav: true,
  responsive:{
      0:{
          margin: 17,
          items:2
      },
      480:{
          items:3
      },
      600:{
          items:4
      },
      1000:{
          items:6
      }
  }
});

// selected items slider

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

$('.resident_project_others .owl-carousel').owlCarousel({
  items: 4,
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
          items:1
      },
      480:{
          items:2
      },
      700:{
          // margin: 20,
          items:3
      },
      1000:{
          // margin: 30,
          items:4
      }
  }
});

/// manshet slider ///
var galleryThumbs = new Swiper('div.manshet_appartment .gallery-thumbs', {
  spaceBetween: 16,
  slidesPerView: 8,
  loop: false,
  allowTouchMove: false,
  freeMode: false,
  loopedSlides: 40, //looped slides should be the same
  watchSlidesVisibility: true,
  watchSlidesProgress: true,
  //speed: 2000,
  autoplay: {
    delay: 3000,
    slideSpeed: 3000,
    disableOnInteraction: false,
  },
});
var galleryTop = new Swiper('div.manshet_appartment .gallery-top', {
  spaceBetween: 16,
  loop: true,
  loopedSlides: 40, //looped slides should be the same
  navigation: {
      nextEl: 'div.manshet_appartment .swiper-button-next',
      prevEl: 'div.manshet_appartment .swiper-button-prev',
  },
  thumbs: {
      swiper: galleryThumbs,
  },
  //speed: 1500,
  effect: 'fade',
  autoplay: {
      // slideSpeed: 2000,
      delay: 3000,
      disableOnInteraction: false,
  },
});
$('div.manshet_appartment .swiper-slide').on('click', function(e) {
	e.preventDefault();
  galleryTop.slideTo($(this).index());
})
/// end manshet slider ///

  // Equal height
  equalHeight();
  function equalHeight(event) {
    $('.pck_itm_short_inf').matchHeight({ property: 'min-height' });
    $('.tp_cmt_items').matchHeight({ property: 'min-height' });
    $('.rgst_items').matchHeight({ property: 'min-height' });
    $('.pr_offr_info').matchHeight({ property: 'min-height' });
    $('.pr_itm_col').matchHeight({ property: 'min-height' });
    
  }
// Equal height
});