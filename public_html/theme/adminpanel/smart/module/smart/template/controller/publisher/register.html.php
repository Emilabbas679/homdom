{literal}
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

{/literal}


<div class="reg">
	<div class="ct-a">
		<div class="ct-b">
			<!-- Login panel start -->
			<section class="login-panel">
				<div class="login-panel-wrap">
					<div class="lp-top">
						<div class="logo">
							<a href="{url link='login'}"></a>
						</div>
						<div class="return">
							<a href="https://smartbee.az"><span>{phrase var='adnetwork.ana_s_hif_y_qay_t'}</span></a>
						</div>
					</div>
					<div class="lp-content">
						<div class="lp-col">
							<div class="lp-left">
								<div class="lp-symb symb-2 w-2"></div>
								<div class="lp-a">{phrase var='adnetwork.publisher_title'}.</div>
								<div class="lp-b">
									{phrase var='adnetwork.advertiser_welcome'}
								</div>
							</div>
						</div>
						<div class="lp-col">
							<div class="lp-right for-reg">
								<h2 class="lp-a">{phrase var='user.register'}</h2>
								<div class="lp-b"><?=AIN::getParam('core.site_title')?></div>
								<div class="lp-form">
									{if $isSendMail }
										<h1>{phrase var='user.5978ef609981d'}</h1>
										<div style="color: white; background-color: #f3611e; border-color: #50ab20; border: 2px solid transparent; border-radius: 5px; padding-right: 35px; padding: 15px; margin-bottom: 20px;">
											{phrase var='user.issendmail'}
										</div>
									{else}
									<form action="{url link='publisher.register'}" id="register-form" METHOD="POST">

										{error}

										<div class="lp-input mail">
											<input id="email" type="text" placeholder="{phrase var='user.user_mail'}" name="val[email]" value="{value type='input' id='email'}">
										</div>


										<div class="lp-input phone-register">
											<input id="phone-register" type="text" name="phone-register" value="{value type='input' id='phone'}">
										</div>
										<input type="hidden" name="val[phone]" id="phone">

										<div class="lp-input pass">
											<input id="pass" type="password" placeholder="{phrase var='user.password'}" name="val[password]" value="{value type='input' id='password'}">
											<div class="show-pass" onclick="showp()"></div>
										</div>

                                        <input type="hidden" name="val[recaptcha_response]" id="recaptchaResponse">


										<div class="lp-button">
											<button type="submit" id="rgst"  >{phrase var='user.register'}</button>
										</div>
									</form>
									{/if}
								</div>
								<div class="lp-bt">
									<div class="lp-block">
										<div class="lp-l">{phrase var='user.m_vcud_hesab_n_var'}</div>
										<div class="lp-r"><a href="{url link='publisher.login'}">{phrase var='adnetwork.login'}</a></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- Login panel end -->
		</div>
	</div>
</div>

<script src="https://www.google.com/recaptcha/api.js"></script>
<script>

function showp() {l}
  var x = document.getElementById("pass");
  var z = document.getElementsByClassName("show-pass")[0]
  if (x.type === "password") {l}
    x.type = "text";
	z.classList.add("showed");
  {r} else {l}
	 x.type = "password";
    z.classList.remove("showed");
  {r}
{r}
</script>

{literal}
<script>
   function onSubmit(token) {
     document.getElementById("register-form").submit();

   }

   $(document).ready(function(){
		$("#phone-register").intlTelInput({
			preferredCountries: [ "az", "gb" ],
		});
		$("#rgst").click(function (){
			var intlNumber = $("#phone-register").intlTelInput("getNumber"); // get full number eg +17024181234
			$("#phone").val(intlNumber)
		});
	});
</script>

{/literal}

</body>
