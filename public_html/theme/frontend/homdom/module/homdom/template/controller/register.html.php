<main class=" ">
    <div class="login-sect-bg">
        <div class="left_bg_img"></div>
        <div class="right_bg_img"></div>
        <div class="login_sect">
            <div class="login_area">
                <div class="login_items">
                    <h2 class="login_head">{{phrase var='user.registr'}}</h2>
                    <div class="login_content">
                        <form action="{{url link='register'}}" method="POST" enctype="multipart/form-data">
                            <div class="lg_row_item">
                                <div class="lg_input">
                                    <div class="lg_inp_bl">{{phrase var='user.firstname'}}</div>
                                    <input type="text"  name="val[firstname]" value="{{value type='input' id='firstname'}}" placeholder="{{phrase var='user.firstname'}}" id="" class="lg_inputs">
                                </div>
                            </div>
                            <div class="lg_row_item">
                                <div class="lg_input">
                                    <div class="lg_inp_bl">{{phrase var='user.lastname'}}</div>
                                    <input type="text" name="val[lastname]" value="{{value type='input' id='lastname'}}" placeholder="{{phrase var='user.lastname'}}" id="" class="lg_inputs">
                                </div>
                            </div>
                            <div class="lg_row_item">
                                <div class="lg_input">
                                    <div class="custom_select clearfix">
                                        <div class="lg_inp_bl">{{phrase var='user.gender'}}</div>
                                        <select name="val[gender]" id="" class="select-regist">
                                            <option value="" disabled>{{phrase var='user.gender'}}</option>
                                            <option value="1">{{phrase var='user.man'}}</option>
                                            <option value="2">{{phrase var='user.wooman'}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="lg_row_item">
                                <div class="lg_input">
                                    <div class="lg_inp_bl tel_title">{{phrase var='user.phone'}}</div>
                                    <input type="tel" name="val[phone]" value="{{value type='input' id='phone'}}" placeholder="{{phrase var='user.phone'}}" id="phone" class="lg_inputs tel_inpt_iti">
                                </div>
                            </div>
                            <div class="lg_row_item">
                                <div class="lg_input">
                                    <div class="lg_inp_bl">{{phrase var='user.birthday'}}</div>
                                    <input type="text" name="val[birthday]" value="{{value type='input' id='birthday'}}" data-toggle="datepicker" placeholder="{{phrase var='user.birthday'}}" id="" class="lg_inputs" autocomplete="off">
                                    <span class="dtpick_input"></span>
                                </div>
                            </div>
                            <div class="lg_row_item">
                                <div class="lg_input">
                                    <div class="lg_inp_bl">{{phrase var='user.email'}}</div>
                                    <input type="text" name="val[email]" value="{{value type='input' id='email'}}" placeholder="{{phrase var='user.email'}}" id="" class="lg_inputs">
                                </div>
                            </div>
                            <div class="lg_row_item">
                                <div class="lg_input">
                                    <div class="lg_inp_bl">{{phrase var='user.password'}}</div>
                                    <input type="password" name="val[password]" value="{{value type='input' id='password'}}" placeholder="{{phrase var='user.password'}}" id="ShowPassword" class="lg_inputs">
                                    <div class="pass_eye " id="togglePassword"></div>
                                </div>
                            </div>
                            <div class="lg_row_item">
                                <div class="user_terms">
                                    <input type="checkbox" name="" id="">
                                    <a href="" target="_blank" rel="noopener noreferrer">İstifadəçi şərtlərini </a> oxudum və razıyam
                                </div>
                            </div>
                            <div class="lg_row_item">
                                <div class="login_submit">
                                    <button type="submit" class="login-btn">{{phrase var='user.registr'}}</button>
                                </div>
                            </div>
                            <div class="lg_row_item">
                                <div class="login_fb">
                                    <a href="" target="_self" rel="noopener noreferrer" class="lg_fb_link">
                                        <span class="lg_fb_icon"></span>
                                        <span class="lg_fb_info">{{phrase var='user.fb_login'}}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="lg_row_item">
                                <div class="have_account">
                                    {{phrase var='user.have_account'}}
                                </div>
                            </div>
                            <div class="lg_row_item">
                                <div class="sign_submit">
                                    <a href="{{url link='login'}}" target="_self" rel="noopener noreferrer" class="sign-btn">{{phrase var='user.login'}}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>