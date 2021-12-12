@section('css')
<script src="https://www.google.com/recaptcha/api.js?render=6LfpZoEaAAAAAAvddE93YljQ1NmtqpmqtFiG8Ezl"></script>
<script>
    grecaptcha.ready(function () {
        grecaptcha.execute('6LfpZoEaAAAAAAvddE93YljQ1NmtqpmqtFiG8Ezl', { action: 'contact' }).then(function (token) {
            var recaptchaResponse = document.getElementById('recaptchaResponse');
            recaptchaResponse.value = token;
        });
    });
</script>
<style>
    #g-recaptcha-response {
        display: block !important;
        position: absolute;
        margin: -78px 0 0 0 !important;
        width: 302px !important;
        height: 76px !important;
        z-index: -999999;
        opacity: 0;
    }
    .grecaptcha-badge{
        display: none;
    }
</style>
@endsection

<main class="main">
    <div class="main_center">
        <div class="sing_content">
            <div class="sg_col login">
                <div class="col_in">
                    <div class="sign_header">
                        <div class="sg_head">
                            {{phrase var='user.login'}}
                            <!--                            Daxil  <b> ol </b>-->
                        </div>
                    </div>
                    <div class="sg_change_body">
                        <form action="{{url link='auth.login'}}" method="POST" class="form_login" onsubmit="return loginValidateForm()">
                            {{ error }}
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                <span>Istifadəçi adı və ya parol səhvdir</span>
                            </div>
                            <div class="lg_input">
                                <div class="lg_inp_bl">{{phrase var='user.phone'}} </div>
                                <input type="text" autocomplete="new-phone" name="val[phone]" placeholder="{{phrase var='user.phone'}}" id="phone-login" value="" class="lg_inputs phone">
                            </div>
                            <div class="lg_input">
                                <div class="lg_inp_bl">{{phrase var='user.password'}}</div>
                                <input type="password" name="val[password]" placeholder="{{phrase var='user.password'}}" id="password-login" class="lg_inputs" >
                                <div class="pass_eye " id="togglePassword_2">
                                 <span class="password-showhide">
                                    <div class="show-password"> </div>
                                    <div class="hide-password"> </div>
                                 </span>
                                </div>
                            </div>
                            <!-- <div class="user_terms">
                              <div class="terms_info">
                                Qeydiyyatdan keçməklə <a href="" target="_blank" rel="noopener noreferrer"> Every.az-ın İstifadəçi razılaşması </a>ilə razı olduğunuzu təsdiq edirsiniz.
                              </div>
                            </div> -->
                            <input type="hidden" name="val[recaptcha_response]" id="recaptchaResponse">
                            <div class="login_submit">
                                <button type="submit" class="login-btn advert">{{phrase var='user.login'}}</button>
                            </div>
                        </form>
                        <a href="{{ url link='auth.password' }}" class="account_quest btn_change_clk">
                            {{ phrase var='user.forgetpassword' }}
                        </a>
                        <div class="account_quest">
                            {{phrase var='user.not_register'}}
                        </div>
                        <a href="{{ url link='auth.register' }}" class="click_regstr btn_registr_clk">{{phrase var='user.registr'}} </a>

                    </div>

                </div>
            </div>
        </div>

    </div>

</main>