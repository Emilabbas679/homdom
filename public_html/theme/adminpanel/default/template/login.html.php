
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Homdom Admin Area</title>
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
    <link media="screen" href="/theme/adminpanel/default/style/default/login/css/style.css?v=2" type="text/css" rel="stylesheet" />


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

</head>
<body>
<div class="xsayt">
    <div class="lgn-a">
        <div class="centered">
            <div class="lgn">
                <div class="lgn-wrap">
                    <div class="logo">
                        <a href="https://homdom.az/" target="_blank"></a>
                    </div>
                    <h2 class="lg-t">{{phrase var='user.login'}}</h2>
                    <form method="post" action="{{url link='login'}}">
                        {{ error }}
                        <div class="lg-form">
                            <div class="lg-input">
                                <input type="text"  class=""  placeholder="{{phrase var='user.email'}}" id="username" name="val[login]" value="">
                            </div>
                            <div class="lg-input">
                                <input type="password" class="" placeholder="{{phrase var='user.password'}}" id="password" name="val[password]" >

                            </div>


                            <div class="lg-button">
                                <button type="submit">{{ phrase var='user.login' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

<script>

    function myFunction() {
        var x = document.getElementById("pass");
        var z = document.getElementsByClassName("show-pass")[0]
        if (x.type === "password") {
            x.type = "text";
            z.classList.add("showed");
        }
        else{

            x.type = "password";
            z.classList.remove("showed");
        }
    }


</script>
</html>