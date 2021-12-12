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
							<a href="https://seyr.az"><span>{phrase var='adnetwork.ana_s_hif_y_qay_t'}</span></a>
						</div>
					</div>
					<div class="lp-content">
						<div class="lp-col">
							<div class="lp-left">
								<div class="lp-symb symb-1 w-1"></div>
								<div class="lp-a">{phrase var='adnetwork.welcome'}</div>
								<div class="lp-b">
									{phrase var='adnetwork.advertiser_welcome'}
								</div>
							</div>
						</div>
						<div class="lp-col">
							<div class="lp-right">
								<h2 class="lp-a">{phrase var='adnetwork.advertiser_title'}</h2>
								<div class="lp-b"><?=AIN::getParam('core.site_title')?></div>
								<div class="lp-form">
									{error}
									{if $isPost == true}
										<div class="success_message">{phrase var='user.password_request_successfully_sent_check_your_email_to_verify_your_request'}</div>
									{else}
									<form method="post" action="{url link='password'}">
										<div class="lp-input mail">
											<input type="text" placeholder="{phrase var='user.email'}" id="email" name="val[email]" value="{value type='input' id='email'}">
										</div>
                                        <input type="hidden" name="val[recaptcha_response]" id="recaptchaResponse">

                                        <div class="lp-button">
											<button type="submit">{phrase var='user.request_new_password'}</button>
										</div>
									</form>
									{/if}
								</div>
								<div class="lp-bt">
									<div class="lp-block">
										<div class="lp-l">{phrase var='adnetwork.hesab_n_yoxdur'}</div>
										<div class="lp-r"><a href="{url link='advertiser.register'}">{phrase var='user.register'}</a></div>
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

<script>

function myFunction() {l}
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
