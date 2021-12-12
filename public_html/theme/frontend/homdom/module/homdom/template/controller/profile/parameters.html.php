
<main class="main">

    <div class="section_wrap wrap_my_profile">

        <div class="my_anc_menu">
            {{ template file='homdom.block.profile_header' }}
        </div>

        <div class="section_body">
            <div class="main_center">
                <div class="section_headers">
                    <h1 class="address_h">{{ phrase var='homdom.profile_settings' }} </h1>
                </div>
                <div class="my_profil_container">
                    <form action="{{ url link='profile.parameters' }}" method="post" enctype="multipart/form-data">
                        {{ error }}
                        <div class="pr_row">
                            <div class="pr_col_3">
                                <div class="prof_inf_lb">{{ phrase var='homdom.full_name'}} </div>
                            </div>
                            <div class="pr_col_7">
                                <input type="text" name="val[full_name]"  value="<?=AIN::getUserBy('full_name')?>" class="prof_inf_inpt">
                            </div>
                        </div>
<!--                        <div class="pr_row">-->
<!--                            <div class="pr_col_3">-->
<!--                                <div class="prof_inf_lb">Şirkət adı </div>-->
<!--                            </div>-->
<!--                            <div class="pr_col_7">-->
<!--                                <input type="text" name=""  value="Hovsan Əmlak" class="prof_inf_inpt" disabled>-->
<!--                            </div>-->
<!--                        </div>-->

                        <div class="pr_row">
                            <div class="pr_col_3">
                                <div class="prof_inf_lb">{{ phrase var='homdom.email'}} </div>
                            </div>
                            <div class="pr_col_7">
                                <input type="text"  value="<?=AIN::getUserBy('email')?>" class="prof_inf_inpt" disabled>
                            </div>
                        </div>
                        <div class="pr_row">
                            <div class="pr_col_3">
                                <div class="prof_inf_lb">{{ phrase var='homdom.phone'}} </div>
                            </div>
                            <div class="pr_col_7">
                                <input type="text" name="val[phone]"  value="<?=AIN::getUserBy('phone')?>" class="prof_inf_inpt phone" >
                            </div>
                        </div>
<!--                        <div class="pr_row">-->
<!--                            <div class="pr_col_3">-->
<!--                                <div class="prof_inf_lb">Telefon2 </div>-->
<!--                            </div>-->
<!--                            <div class="pr_col_7">-->
<!--                                <input type="text" name=""  value="" class="prof_inf_inpt phone" >-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="pr_row">
                            <div class="pr_col_3">
                                <div class="prof_inf_lb">{{ phrase var='homdom.password'}} </div>
                            </div>
                            <div class="pr_col_7">
                                <input type="password" name="val[password]"  value="" class="prof_inf_inpt change_password_btn ch_psw_val" >
                            </div>
                        </div>
                        <div class="pr_row">
                            <div class="pr_col_3">
                                <div class="prof_inf_lb">{{ phrase var='homdom.image'}} </div>
                            </div>
                            <div class="pr_col_7">
                                <!-- <label class="prof_inf_lb_file">
                                    + Logo yüklə
                                    <input type="file" name="" >
                                </label> -->
                                <input type="hidden" id="new_profile" name="val[new_image]">
                                <div class="setting_profile_photo clearfix">
                                    <div class="photo_change">
                                        <div class="ph_row">
                                            <input type="file" id="change_photo">
                                            <label for="change_photo" class="ch_photo_lable prof_inf_lb_file"> {{ phrase var='homdom.change_image'}} </label>
                                        </div>
                                    </div>
                                    <div class="setting_photo">
                                        <img src="<?=AIN::getService('homdom.helpers')->userProfilePhoto()?>" id="profilePhoto" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pr_row">
                            <div class="pr_col_3">
                                <div class="prof_inf_lb">{{ phrase var='homdom.bio'}} </div>
                            </div>
                            <div class="pr_col_7">
                                <textarea class="prof_inf_inpt" name="val[bio]"  cols="0" rows="0" placeholder="{{ phrase var='homdom.about_bio'}}"><?=AIN::getUserBy('bio')?></textarea>
                            </div>
                        </div>
                        <div class="pr_row">
                            <div class="pr_col_3">
                                <!-- <div class="prof_inf_lb">Şifrə </div> -->
                            </div>
                            <div class="pr_col_7">
                                <button type="submit" class="prof_inf_submit">{{ phrase var='homdom.submit'}} </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</main>

<!-- Modal change password  -->
<div class="modal change_password_modal">
    <div class="modal_inner">
        <div class="popup_container">
            <div class="popup_header">
                <div class="ch_pass_head">
                    {{ phrase var='homdom.change_pass' }}
                </div>
                <span class="pop_close"></span>
            </div>
            <div class="popup_body">
                <div class="ch_pass_body">
                    <!-- <div class="pr_row"> -->
                        <div class=" error_message">{{ phrase var='homdom.pass_change_error'}} </div>
                    <!-- </div> -->
                    <div class="pr_row">
                        <label class="ch_inf_lb">{{ phrase var='homdom.new_pass' }} </label>
                        <input type="password" name=""  value="" class="ch_inf_inpt ch_password1">
                    </div>
                    <div class="pr_row">
                        <label class="ch_inf_lb"> {{ phrase var='homdom.confirm_new_pass' }} </label>
                        <input type="password" name=""  value="" class="ch_inf_inpt ch_password2">
                    </div>
                    <div class="pr_row">
                        <button type="button" class="prof_inf_submit change_psw">{{ phrase var='homdom.change_pass' }} </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal change password  -->

@section('js')
<script>
    $(".change_psw").click(function(e) {
        let ch_psw1 = $(".ch_password1");
        let ch_psw2 = $(".ch_password2");
        if((ch_psw1.val() === ch_psw2.val()) && ch_psw1.val().length >= 5 && ch_psw2.val().length >= 5) {
            let valP = ch_psw1.val();
            $(".ch_psw_val").val(valP);
            $(this).parents(".modal").fadeOut("linear");

        } else {
            $(".error_message").fadeIn();
            e.stopPropagation();
            e.preventDefault();
        }
    });

    $("#change_photo").change(function (event){
        $("#profilePhoto").attr('src', '/theme/frontend/homdom/style/img/loading.gif');
        var file_data = $('#change_photo').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        event.preventDefault();
        $.ajax({
            type: "post",
            url: '/_ajax?core[ajax]=true&core[call]=homdom.upload',
            data: form_data,
            processData: false,
            contentType: false,
            cache: false,
            success: function (res) {
                console.log(res)
                $("#profilePhoto").attr('src', res.down_url)
                $("#new_profile").val(res.down_url)

            }
        });
    });
</script>
@endsection