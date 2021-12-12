
<main class="main">
    <div class="section_wrap wrap_contact">
        <div class="section_body">
            <div class="main_center">
                <div class="section_headers">
                    <h1 class="address_h">{{ phrase var='homdom.contact_us' }}</h1>
                    <div class="cnt_short_info">
                        {{ phrase var='homdom.contact_us_detail' }}
                    </div>
                </div>
				<div class="contact_items_sect clearfix">
                    <div class="contact_item clearfix">
                        <div class="cnt_itm_left">
                            <div class="cnt_itm_img phone"></div>
                        </div>
                        <div class="cnt_itm_right clearfix">
                            <div class="row_cnt">
                                <div class="contact_itm_title">Telefon </div>
                            </div>
                            <div class="row_cnt">
                                <div class="contact_text">+994-99-999-99-99 </div>
                            </div>
                            <div class="row_cnt">
                                <div class="contact_adrs">İş saatları: 10.00-21.00</div>
                            </div>
                            <div class="row_cnt">
                                <div class="contact_adrs">İstirahət günü: şənbə, bazar</div>
                            </div>
                        </div>
                    </div>
                    <div class="contact_item clearfix">
                        <div class="cnt_itm_left">
                            <div class="cnt_itm_img mail"></div>
                        </div>
                        <div class="cnt_itm_right clearfix">
                            <div class="row_cnt">
                                <div class="contact_itm_title">E-mail</div>
                            </div>
                            <div class="row_cnt">
                                <div class="contact_text">support@homdom.az</div>
                            </div>
                            <div class="row_cnt">
                                <div class="contact_adrs">Reklam üçün: corporate@homdom.az</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my_profil_container">
                    <div class="cnt_left">
                        <div class="row_cnt">
                            <div class="contact_text">
                                {{ phrase var='homdom.contact_phone' }}
                                <br/>
                                {{ phrase var='homdom.contact_mail' }}
                            </div>
                        </div>
                        <div class="row_cnt">
                            <div class="contact_adrs">
                                {{ phrase var='homdom.contact_address' }}
                            </div>
                        </div>
                        <div class="row_cnt">
                            <div class="cnt_share clearfix">
                                <div class="cnt_share_icon">
                                    <a href="" class="cnt_share_link">
                                        <img src="/theme/frontend/homdom/style/img/cnt_facebook.svg" alt="">
                                    </a>
                                </div>
                                <div class="cnt_share_icon">
                                    <a href="" class="cnt_share_link">
                                        <img src="/theme/frontend/homdom/style/img/twitter.svg" alt="">
                                    </a>
                                </div>
                                <div class="cnt_share_icon">
                                    <a href="" class="cnt_share_link">
                                        <img src="/theme/frontend/homdom/style/img/cnt_instagram.svg" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cnt_right">
                        <form action="" method="POST">
                            {{ error }}
                            <?php $form = $this->_aVars['aForms']; ?>
                            <div class="lg_input">
                                <div class="lg_inp_bl">{{ phrase var='homdom.name_surname' }}</div>
                                <input type="text" name="val[full_name]" placeholder="{{ phrase var='homdom.name_surname' }}" id="full_name" <?php if (isset($form['full_name'])) { ?> value="<?=$form['full_name']?>" <?php } ?>  class="lg_inputs">
                            </div>
                            <div class="lg_input">
                                <div class="lg_inp_bl">{{ phrase var='homdom.email' }}</div>
                                <input type="text" name="val[email]" placeholder="{{ phrase var='homdom.email' }}" id="email-register" <?php if (isset($form['email'])) { ?> value="<?=$form['email']?>" <?php } ?> class="lg_inputs">
                            </div>
                            <div class="lg_input">
                                <div class="lg_inp_bl">{{ phrase var='homdom.phone' }} </div>
                                <input type="text" name="val[phone]" placeholder="{{ phrase var='homdom.phone' }}" id="phone-register" <?php if (isset($form['phone'])) { ?> value="<?=$form['phone']?>" <?php } ?> class="lg_inputs phone" inputmode="text" >
                            </div>
                            <div class="row_cnt">
                                <textarea class="prof_inf_inpt" name="val[content]" cols="0" rows="0" placeholder="{{ phrase var='homdom.write_us' }}"><?php if (isset($form['email'])) echo $form['email']?></textarea>
                            </div>

                            <div class="row_cnt">
                                <button type="submit" class="prof_inf_submit">{{ phrase var='homdom.save' }} </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>