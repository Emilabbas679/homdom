<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ title }}</title>
		{{ header }}
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
    <link media="screen" href="/theme/frontend/smart/style/login/css/style.css" type="text/css" rel="stylesheet" />
    <link media="screen" href="/theme/frontend/smart/style/login/css/intl-tel.css" type="text/css" rel="stylesheet" />

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
    {{ content }}
</div>

</body>





<script src="/theme/frontend/smart/style/login/js/jquery.js?v=1"></script>

<script src="/static/min/?g=core&charset=utf-8&v=2"></script>
<script>$Core.loadInit();</script>






<script src="/theme/frontend/smart/style/login/js/intlmin.js?v=1"></script>
<script src="/theme/frontend/smart/style/login/js/utils.js?v=1"></script>
<script>

    $("#phone-register").intlTelInput({
        preferredCountries: [ "az", "gb" ],
    });
    $("#rgst").click(function (){
        var intlNumber = $("#phone-register").intlTelInput("getNumber"); // get full number eg +17024181234
        intlNumber = intlNumber.replace('+', '')
        $("#phone").val(intlNumber)
    })

</script>

</html>