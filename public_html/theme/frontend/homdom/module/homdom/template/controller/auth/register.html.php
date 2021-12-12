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
            <div class="sg_col registration"  style="display: block;">
                <div class="col_in">

                    <?php $aForms = $this->_aVars['aForms']; ?>
                    <div class="sign_header">
                        <div class="sg_head">
                            {{ phrase var='user.registr' }}
<!--                            Qeydiyyatdan <b> keç </b>-->
                        </div>
                    </div>
                    <div class="sg_change_body">
                        <form action="{{ url link='auth.register' }}" method="POST" class="form_login" onsubmit="return registerValidateForm()">
                            {{ error }}
                            <div class="lg_input">
                                <div class="lg_inp_bl">{{phrase var='user.full_name'}}</div>
                                <input type="text" name="val[full_name]" placeholder="{{phrase var='user.full_name'}}" id="full_name" <?php if (isset($aForms['full_name'])) { ?> value="<?=$aForms['full_name']?>" <?php } ?>  class="lg_inputs">
                            </div>
<!--                            <div class="lg_input">-->
<!--                                <div class="lg_inp_bl">Soyad</div>-->
<!--                                <input type="text" name="" placeholder="Soyad" id="full_surname" value="" class="lg_inputs">-->
<!--                            </div>-->
                            <div class="lg_input">
                                <div class="lg_inp_bl">{{phrase var='user.phone'}}</div>
                                <input type="text" name="val[phone]" placeholder="{{phrase var='user.phone'}}" id="phone-register" <?php if (isset($aForms['phone'])) { ?> value="<?=$aForms['phone']?>" <?php } ?> class="lg_inputs phone">
                            </div>
                            <div class="lg_input">
                                <div class="lg_inp_bl">{{phrase var='user.email'}}</div>
                                <input autocomplete="new-email" type="text" name="val[email]" placeholder="{{phrase var='user.email'}}" id="email-register" <?php if (isset($aForms['email'])) { ?> value="<?=$aForms['email']?>" <?php } ?> class="lg_inputs">
                            </div>
                            <div class="lg_input">
                                <div class="lg_inp_bl">{{phrase var='user.password'}}</div>
                                <input autocomplete="new-password" type="password" name="val[password]" placeholder="{{phrase var='user.password'}}" id="password-register" class="lg_inputs">
                                <div class="pass_eye " id="togglePassword_2">
                             <span class="password-showhide">
                                <div class="show-password"> </div>
                                <div class="hide-password"> </div>
                             </span>
                                </div>
                            </div>

                            <div class="user_terms">
                                <div class="terms_info">
                                    {{phrase var='homdom.qeydiyyatdan_kecmekle'}} <a href="" target="_blank" rel="noopener noreferrer"> {{phrase var='homdom.istifadeci_razilasmasi'}} </a> {{phrase var='homdom.razi_oldugunuz_tesdiq_edirsiz'}}
                                </div>
                            </div>
                            <input type="hidden" name="val[recaptcha_response]" id="recaptchaResponse">

                            <div class="login_submit">
                                <button type="submit" class="login-btn advert"> {{ phrase var='user.registr' }}</button>
                            </div>
                        </form>
                        <div class="account_quest">
                            {{phrase var='user.have_account'}}
                        </div>
                        <a href="{{url link='auth.login'}}" class="click_regstr btn_login_clk">Daxil olun </a>

                    </div>

                </div>
            </div>
        </div>

    </div>

</main>