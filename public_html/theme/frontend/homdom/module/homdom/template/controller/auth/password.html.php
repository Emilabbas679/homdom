<main class="main">
    <div class="main_center">
        <div class="sing_content">
            <div class="sg_col change_password"  style="display: block;">
                <div class="col_in">
                    <div class="sign_header">
                        <div class="sg_head">
                            {{ phrase var='user.resetpasswd' }}
<!--                            Şifrəni bərpa <b> et </b>-->
                        </div>
                    </div>
                    <div class="sg_change_body">
                        <form action="{{ url link='auth.password' }}" method="POST" class="form_login">
                            <?php $aForms = $this->_aVars['aForms']; ?>

                            {{ error }}
                            <div class="lg_input">
                                <div class="lg_inp_bl">{{ phrase var='user.email'}} </div>
                                <input type="text" name="val[email]" placeholder="{{ phrase var='user.email'}}"   <?php if (isset($aForms['email'])) { ?> value="<?=$aForms['email']?>" <?php } ?> class="lg_inputs">
                            </div>
                            <div class="login_submit">
                                <button type="submit" class="login-btn advert">{{ phrase var='user.request_new_password' }} </button>
                            </div>
                        </form>
                        <!-- <a href="" class="account_quest">
                          Daxil olun
                        </a>   -->
                        <!-- <div class="account_quest">
                          Qeydiyyatınız yoxdursa
                        </div>   -->
                        <a href="{{url link='auth.login'}}" class="click_regstr btn_login_clk">{{ phrase var='user.login' }} </a>

                    </div>

                </div>
            </div>
        </div>

    </div>

</main>