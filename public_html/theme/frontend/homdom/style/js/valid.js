
function home_buy_sell() {

    function item_radio_control() {
        $(".home_check_buy_sell input").each(function (index) {
            let elem_this = $(this);
            home_buy(elem_this);
        });
    }
    item_radio_control();
    function home_buy(elem_this) {
        if(elem_this.is(":checked") || elem_this.parents(".home_check_buy_sell").siblings().find("input").is(":checked")) {
            elem_this.siblings(".ch_hm_validate").removeClass("inp_null");
            elem_this.parents(".home_check_buy_sell").siblings().find("input").siblings(".ch_hm_validate").removeClass("inp_null");
            return true;
        } else {
            elem_this.siblings(".ch_hm_validate").addClass("inp_null");
            event.preventDefault();
        }
        elem_this.click(function () {
            if(elem_this.is(":checked")) {
                elem_this.siblings(".ch_hm_validate").removeClass("inp_null");
                elem_this.parents(".home_check_buy_sell").siblings().find("input").siblings(".ch_hm_validate").removeClass("inp_null");
                return true;
            } else {
                elem_this.siblings(".ch_hm_validate").addClass("inp_null");
            }
        });
    }


}

function item_AllVideo() {
    $(".added_video .add_search input").each(function (index) {
        if($(this).val() === "") {
            $(this).addClass("inp_null");
            $(this).parents(".add_col").find(".alert").addClass("show");
            event.preventDefault();
        } else {
            $(this).removeClass("inp_null");
            $(this).parents(".add_col").find(".alert").removeClass("show");
            return true;
        }
        $(this).keyup(function () {
            if($(this).val() === "") {
                $(this).addClass("inp_null");
            } else {
                $(this).removeClass("inp_null");
                $(this).parents(".add_col").find(".alert").removeClass("show");
            }
        });
    });
}

function item_AllPrice() {
    $(".appart_price_row .add_search input").each(function (index) {
        if($(this).val() === "") {
            $(this).addClass("inp_null");
            $(this).parents(".add_col").find(".alert").addClass("show");
            event.preventDefault();
        } else {
            $(this).removeClass("inp_null");
            $(this).parents(".add_col").find(".alert").removeClass("show");
            return true;
        }
        $(this).keyup(function () {
            if($(this).val() === "") {
                $(this).addClass("inp_null");
            } else {
                $(this).removeClass("inp_null");
                $(this).parents(".add_col").find(".alert").removeClass("show");
            }
        });


    });
    $(".appart_price_row .add_inp_number input").each(function (index) {
        if($(this).val() === "") {
            $(this).addClass("inp_null");
            $(this).parents(".add_col").find(".alert").addClass("show");
            event.preventDefault();
            item_radio_control();
        } else {
            $(this).removeClass("inp_null");
            $(this).parents(".add_col").find(".alert").removeClass("show");
            item_radio_control();
        }
        $(this).keyup(function () {
            if($(this).val() === "") {
                $(this).addClass("inp_null");
            } else {
                $(this).removeClass("inp_null");
                $(this).parents(".add_col").find(".alert").removeClass("show");
            }
        });
    });

    function item_radio_control() {
        $(".appart_price_row .add_check_items.static.ck_build_mortgage input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
        $(".appart_price_row .add_check_items.static.ck_build_haggle input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
    }


}
function item_AllContact() {
    $(".contact_row .add_search input").each(function (index) {
        if($(this).val() === "") {
            $(this).addClass("inp_null");
            $(this).parents(".add_col").find(".alert").addClass("show");
            event.preventDefault();
        } else {
            $(this).removeClass("inp_null");
            $(this).parents(".add_col").find(".alert").removeClass("show");
            return true;
        }
        $(this).keyup(function () {
            if($(this).val() === "") {
                $(this).addClass("inp_null");
            } else {
                $(this).removeClass("inp_null");
                $(this).parents(".add_col").find(".alert").removeClass("show");
            }
        });
    });
    $(".contact_row .add_inp_number input").each(function (index) {
        if($(this).val() === "") {
            $(this).addClass("inp_null");
            $(this).parents(".add_col").find(".alert").addClass("show");
            event.preventDefault();
        } else {
            $(this).removeClass("inp_null");
            return true;
        }
        $(this).keyup(function () {
            if($(this).val() === "") {
                $(this).addClass("inp_null");
            } else {
                $(this).removeClass("inp_null");
            }
        });
    });
}
// Checkbox element validation
function items_checked(elem_this) {
    if(elem_this.is(":checked") || elem_this.parents(".add_check_items").siblings().find("input").is(":checked")) {
        elem_this.siblings("span").removeClass("inp_null");
        elem_this.parents(".add_check_items").siblings().find("input").siblings("span").removeClass("inp_null");
        return true;
    } else {
        elem_this.siblings("span").addClass("inp_null");
        // console.log("secilmiyibbbbb");
        event.preventDefault();
    }
    elem_this.click(function () {
        if(elem_this.is(":checked")) {
            elem_this.siblings("span").removeClass("inp_null");
            elem_this.parents(".add_check_items").siblings().find("input").siblings("span").removeClass("inp_null");
            return true;
        } else {
            elem_this.siblings("span").removeClass("inp_null");
        }
    });
}
// Checkbox element validation

function item_1() {
    $(".item_lbl_child_1 .add_search input").each(function (index) {
        if($(this).val() === "") {
            $(this).addClass("inp_null");
            $(this).parents(".add_col").find(".alert").addClass("show");
            event.preventDefault();
        } else {
            $(this).removeClass("inp_null");
            $(this).parents(".add_col").find(".alert").removeClass("show");
            return true;
        }

        $(this).keyup(function () {
            if($(this).val() === "") {
                $(this).addClass("inp_null");
            } else {
                $(this).removeClass("inp_null");
                $(this).parents(".add_col").find(".alert").removeClass("show");
            }
        });
    });

    $(".item_lbl_child_1 .add_inp_number.static input").each(function (index) {
        if($(this).val() === "") {
            $(this).addClass("inp_null");
            $(this).parents(".add_col").find(".alert").addClass("show");
            event.preventDefault();
            item_radio_control();
        } else {
            $(this).removeClass("inp_null");
            $(this).parents(".add_col").find(".alert").removeClass("show");
            item_1_1();
            item_radio_control();
        }
        $(this).keyup(function () {
            if($(this).val() === "") {
                $(this).addClass("inp_null");
            } else {
                $(this).removeClass("inp_null");
                $(this).parents(".add_col").find(".alert").removeClass("show");
            }
        });
    });
    // function select_valid() {

    $(".item_lbl_child_1 .valid_slct_1").each(function (index) {
        // console.log($(this).val());
        if($(this).val() === null || $(this).val() === "") {
            // console.log("bossdurr");
            $(this).siblings(".select2").find(".selection").addClass("inp_null");
            event.preventDefault();
        }
        else {
            console.log("doludur");
            $(this).siblings(".select2").find(".selection").removeClass("inp_null");
            return true;
            // return true;
            // $(this).removeClass("inp_null");
        }

    });
    $(".item_lbl_child_1 .valid_slct_1").on("change", function () {
        $('.clear_inp_val').addClass("active");
        console.log($(this).val());
        if($(this).val() === "" || $(this).val() === null) {
            $(this).siblings(".select2").children(".selection").addClass("inp_null");
            event.preventDefault();
        } else {
            $(this).siblings(".select2").children(".selection").removeClass("inp_null");
        }
    });

    // }
    // select_valid();


    function item_1_1() {

        $(".item_lbl_child_1 .add_inp_number.change input").each(function (index) {
            if($(this).parents(".room_input_element.show").find("input").val() == "") {
                $(this).addClass("inp_null");
                $(this).parents(".add_col").find(".alert").addClass("show");
                event.preventDefault();
            } else {
                $(this).removeClass("inp_null");
                $(this).parents(".add_col").find(".alert").removeClass("show");
                return true;
            }
            $(this).keyup(function () {
                if($(this).val() === "") {
                    $(this).addClass("inp_null");
                } else {
                    $(this).removeClass("inp_null");
                    $(this).parents(".add_col").find(".alert").removeClass("show");
                }
            });
        });
    }

    function item_radio_control() {
        $(".item_lbl_child_1 .add_check_items.static.ck_build_type input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
        $(".item_lbl_child_1 .add_check_items.static.ck_parking_type input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
        $(".item_lbl_child_1 .add_check_items.static.ck_lift_type input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
        $(".item_lbl_child_1 .add_check_items.static.ck_build_sanitary input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
        $(".item_lbl_child_1 .add_check_items.static.ck_build_balcony input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
        $(".item_lbl_child_1 .add_check_items.static.ck_build_quality input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
        $(".item_lbl_child_1 .add_check_items.static.ck_build_window_view input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
        $(".item_lbl_child_1 .add_check_items.static.ck_build_bill_of_sale input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
    }

}
function item_2() {
    $(".item_lbl_child_2 .add_search input").each(function (index) {
        if($(this).val() === "") {
            $(this).addClass("inp_null");
            $(this).parents(".add_col").find(".alert").addClass("show");
            event.preventDefault();
        } else {
            $(this).removeClass("inp_null");
            //return true;
        }
        $(this).keyup(function () {
            if($(this).val() === "") {
                $(this).addClass("inp_null");
            } else {
                $(this).removeClass("inp_null");
            }
        });
    });
    $(".item_lbl_child_2 .add_inp_number.static input").each(function (index) {
        if($(this).val() === "") {
            $(this).addClass("inp_null");
            $(this).parents(".add_col").find(".alert").addClass("show");
            event.preventDefault();
            item_radio_control();
        } else {
            $(this).removeClass("inp_null");
            $(this).parents(".add_col").find(".alert").removeClass("show");
            item_1_1();
            item_radio_control();
        }
        $(this).keyup(function () {
            if($(this).val() === "") {
                $(this).addClass("inp_null");
            } else {
                $(this).removeClass("inp_null");
                $(this).parents(".add_col").find(".alert").removeClass("show");
            }
        });
    });
    function item_1_1() {
        $(".item_lbl_child_2 .add_inp_number.change input").each(function (index) {
            if($(this).parents(".room_input_element.show").find("input").val() == "") {
                $(this).addClass("inp_null");
                $(this).parents(".add_col").find(".alert").addClass("show");
                event.preventDefault();
            } else {
                $(this).removeClass("inp_null");
                $(this).parents(".add_col").find(".alert").removeClass("show");
                return true;
            }
            $(this).keyup(function () {
                if($(this).val() === "") {
                    $(this).addClass("inp_null");
                } else {
                    $(this).removeClass("inp_null");
                    $(this).parents(".add_col").find(".alert").removeClass("show");
                }
            });
        });
    }

    function item_radio_control() {
        $(".item_lbl_child_2 .add_check_items.static.ck_parking_type input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
        $(".item_lbl_child_2 .add_check_items.static.ck_build_sanitary input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
        $(".item_lbl_child_2 .add_check_items.static.ck_build_balcony input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
        $(".item_lbl_child_2 .add_check_items.static.ck_build_quality input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
        $(".item_lbl_child_2 .add_check_items.static.ck_build_window_view input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
        $(".item_lbl_child_2 .add_check_items.static.ck_build_bill_of_sale input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
        $(".item_lbl_child_2 .add_check_items.static.ck_build_material input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
    }

}
function item_3() {
    $(".item_lbl_child_3 .add_search input").each(function (index) {
        if($(this).val() === "") {
            $(this).addClass("inp_null");
            $(this).parents(".add_col").find(".alert").addClass("show");
            event.preventDefault();
        } else {
            $(this).removeClass("inp_null");
            $(this).parents(".add_col").find(".alert").removeClass("show");
        }
        $(this).keyup(function () {
            if($(this).val() === "") {
                $(this).addClass("inp_null");
            } else {
                $(this).removeClass("inp_null");
                $(this).parents(".add_col").find(".alert").removeClass("show");
            }
        });
    });
    $(".item_lbl_child_3 .add_inp_number input").each(function (index) {
        if($(this).val() === "") {
            $(this).addClass("inp_null");
            $(this).parents(".add_col").find(".alert").addClass("show");
            event.preventDefault();
            item_radio_control();
        } else {
            $(this).removeClass("inp_null");
            item_radio_control();
        }
        $(this).keyup(function () {
            if($(this).val() === "") {
                $(this).addClass("inp_null");
                event.preventDefault();
            } else {
                $(this).removeClass("inp_null");
            }
        });
    });

    function item_radio_control() {
        $(".item_lbl_child_3 .add_check_items.static.ck_home_field_type input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
    }

}
function item_4() {
    $(".item_lbl_child_4 .add_search input").each(function (index) {
        if($(this).val() === "") {
            $(this).addClass("inp_null");
            $(this).parents(".add_col").find(".alert").addClass("show");
            event.preventDefault();
        } else {
            $(this).removeClass("inp_null");
            $(this).parents(".add_col").find(".alert").removeClass("show");
        }
        $(this).keyup(function () {
            if($(this).val() === "") {
                $(this).addClass("inp_null");
            } else {
                $(this).removeClass("inp_null");
                $(this).parents(".add_col").find(".alert").removeClass("show");
            }
        });
    });
    $(".item_lbl_child_4 .add_inp_number input").each(function (index) {
        if($(this).val() === "") {
            $(this).addClass("inp_null");
            $(this).parents(".add_col").find(".alert").addClass("show");
            event.preventDefault();
            item_radio_control();
        } else {
            $(this).removeClass("inp_null");
            $(this).parents(".add_col").find(".alert").removeClass("show");
            item_radio_control();
        }
        $(this).keyup(function () {
            if($(this).val() === "") {
                $(this).addClass("inp_null");
                event.preventDefault();
            } else {
                $(this).removeClass("inp_null");
                $(this).parents(".add_col").find(".alert").removeClass("show");
            }
        });
    });

    function item_radio_control() {
        $(".item_lbl_child_4 .add_check_items.static.ck_home_garage_type input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
        $(".item_lbl_child_4 .add_check_items.static.ck_build_material input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
        $(".item_lbl_child_4 .add_check_items.static.ck_build_garage_status input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
    }


}
function item_5() {
    $(".item_lbl_child_5 .add_search input").each(function (index) {
        if($(this).val() === "") {
            $(this).addClass("inp_null");
            $(this).parents(".add_col").find(".alert").addClass("show");
            event.preventDefault();
        } else {
            $(this).removeClass("inp_null");
            $(this).parents(".add_col").find(".alert").removeClass("show");
        }
        $(this).keyup(function () {
            if($(this).val() === "") {
                $(this).addClass("inp_null");
                event.preventDefault();
            } else {
                $(this).removeClass("inp_null");
                $(this).parents(".add_col").find(".alert").removeClass("show");
            }
        });
    });
    $(".item_lbl_child_5 .add_inp_number input").each(function (index) {
        if($(this).val() === "") {
            $(this).addClass("inp_null");
            $(this).parents(".add_col").find(".alert").addClass("show");
            event.preventDefault();
            item_radio_control();
        } else {
            $(this).removeClass("inp_null");
            $(this).parents(".add_col").find(".alert").removeClass("show");
            item_radio_control();
        }
        $(this).keyup(function () {
            if($(this).val() === "") {
                $(this).addClass("inp_null");
                event.preventDefault();
            } else {
                $(this).removeClass("inp_null");
                $(this).parents(".add_col").find(".alert").removeClass("show");
            }
        });
    });

    function item_radio_control() {
        $(".item_lbl_child_5 .add_check_items.static.ck_build_quality input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
        $(".item_lbl_child_5 .add_check_items.static.ck_build_exit input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
    }

}
function item_6() {
    $(".item_lbl_child_6 .add_search input").each(function (index) {
        if($(this).val() === "") {
            $(this).addClass("inp_null");
            $(this).parents(".add_col").find(".alert").addClass("show");
            event.preventDefault();
        } else {
            $(this).removeClass("inp_null");
            $(this).parents(".add_col").find(".alert").removeClass("show");
        }
        $(this).keyup(function () {
            if($(this).val() === "") {
                $(this).addClass("inp_null");
                event.preventDefault();
            } else {
                $(this).removeClass("inp_null");
                $(this).parents(".add_col").find(".alert").removeClass("show");
            }
        });
    });
    $(".item_lbl_child_6 .add_inp_number input").each(function (index) {
        if($(this).val() === "") {
            $(this).addClass("inp_null");
            $(this).parents(".add_col").find(".alert").addClass("show");
            event.preventDefault();
        } else {
            $(this).removeClass("inp_null");
            $(this).parents(".add_col").find(".alert").removeClass("show");
            item_radio_control();
        }
        $(this).keyup(function () {
            if($(this).val() === "") {
                $(this).addClass("inp_null");
                event.preventDefault();
            } else {
                $(this).removeClass("inp_null");
                $(this).parents(".add_col").find(".alert").removeClass("show");
            }
        });
    });

    function item_radio_control() {
        $(".item_lbl_child_6 .add_check_items.static.ck_build_quality input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
        $(".item_lbl_child_6 .add_check_items.static.ck_build_exit input").each(function (index) {
            let elem_this = $(this);
            items_checked(elem_this);
        });
    }

}

// Input replace value 
$(".rpl_input_val").keyup(function () {
    let val = $(this).val();
    val = val.replace(".", "");

    let newVal = "";
    let first = 0;
    if(val.length != 0) {
        first = val[0];
    }
    for(let i = 0; i < val.length; i++) {
        if(i != 0) {
            newVal += val[i];
        }
    }
    if(val.length > 1) {
        $(".rpl_input_val").val(first + "." + newVal)
    }
    else {
        $(".rpl_input_val").val(val)
    }
});