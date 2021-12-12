<!DOCTYPE html>
<html lang="az" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (isset($this->_aVars['meta'])){
    foreach ($this->_aVars['meta'] as $key => $value) { ?>

    <meta name="<?=$key?>" content="<?=$value?>">
    <?php } } ?>
    <title>{{title}}</title>


    <link rel="stylesheet" href="/theme/frontend/homdom/style/css/reset.css">
	<!-- Link Swiper's CSS -->
	<link rel="stylesheet" href="/theme/frontend/homdom/style/css/swiper.min.css">
	<link rel="stylesheet" href="/theme/frontend/homdom/style/css/swiper-bundle.min.css">

	<!-- Owl Stylesheets -->
	<link rel="stylesheet" href="/theme/frontend/homdom/style/css/owl.carousel.min.css">
	<link rel="stylesheet" href="/theme/frontend/homdom/style/css/owl.theme.default.min.css">

	<link rel="stylesheet" href="/theme/frontend/homdom/style/css/jquery.dataTables.min.css">

	<link rel="stylesheet" href="/theme/frontend/homdom/style/css/jquery.fancybox.css" />

	<link rel="stylesheet" href="/theme/frontend/homdom/style/css/googlemap.css">
    <link rel="stylesheet" media="screen" href="/theme/frontend/homdom/style/css/aplication_example.css?v8" />

    <link href="/theme/frontend/homdom/style/css/select2.min.css" rel="stylesheet" />
<!--    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />-->

    <link rel="stylesheet" href="/theme/frontend/homdom/style/css/style.css?v<?=AIN::gettime()?>">
	<link rel="stylesheet" href="/theme/frontend/homdom/style/css/responsive.css?v<?=AIN::gettime()?>">

	<!-- Jquery part -->
	<script src="/theme/frontend/homdom/style/js/jquery-3.4.1.min.js"></script>
	<script src="/theme/frontend/homdom/style/js/select2.min.js"></script>
   <script src="/theme/frontend/homdom/style/js/apl_js.js?v5"></script>

    <!--    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>-->

	<script src="/theme/frontend/homdom/style/js/masonry.pkgd.min.js"></script>
	<script src="/theme/frontend/homdom/style/js/imagesloaded.pkgd.min.js"></script>
    <script src="/theme/frontend/homdom/style/js/jquery.fancybox.min.js" ></script>
	<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <style>
        .filepond--drop-label {
            color: #4c4e53;
        }

        .filepond--label-action {
            text-decoration-color: #babdc0;
        }

        .filepond--panel-root {
            border-radius: 2em;
            background-color: #edf0f4;
            height: 1em;
        }

        .filepond--item-panel {
            background-color: #595e68;
        }

        .filepond--drip-blob {
            background-color: #7f8a9a;
        }
    </style>

    @yield('css')

</head>
<body>
<div class="page">
    {{template file='homdom.block.header'}}
    {{content}}
    {{template file='homdom.block.footer'}}
    <!-- POPUP modal  -->
    {{template file='homdom.block.popup'}}
    <!-- POPUP modal  -->
</div>

</body>

<!-- Swiper JS -->
<script src="/theme/frontend/homdom/style/js/swiper.min.js"></script>
<script src="/theme/frontend/homdom/style/js/owl.carousel.min.js"></script>
<script src="/theme/frontend/homdom/style/js/select.js"></script>
<script src="/theme/frontend/homdom/style/js/jquery.dataTables.min.js"></script>
<script src="/theme/frontend/homdom/style/js/jquery.inputmask.min.js"></script>
<script src="/theme/frontend/homdom/style/js/jquery.matchHeight-min.js"></script>
<script src="/theme/frontend/homdom/style/js/myjs.js?v<?=AIN::gettime()?>"></script>

<script>
  $(".phone").inputmask({
    "mask": "+(999) 99 999 99 99",
  });
  $(".currency").inputmask({
    alias: "currency",
    inputFormat: "999,999.12"
  });
  $(".decimal").inputmask({
    alias: "decimal",
    "placeholder": "",
  });
  $(".integer_num").inputmask({
    alias: "integer",
  });
</script>

<script>
    $('#balance').DataTable( {
        searching: false, paging: true, info: false, ordering: true,
        language: {
            paginate: {
                previous: '‹',
                next:     '›'
            },
            aria: {
                paginate: {
                    previous: 'Previous',
                    next:     'Next'
                }
            }
        }
        //scrollX: true,
    });
</script>

<script>
    function loginValidateForm()
    {
        let phone = $("#phone-login").val();
        let pass = $("#password-login").val();
        if (phone == '') {
            $("#phone-login").css('border-bottom', '1px solid red')
        }
        else{
            $("#phone-login").css('border-bottom', '1px solid #E1E1E1')
        }
        if (pass == '') {
            $("#password-login").css('border-bottom', '1px solid red')
        }
        else{
            $("#password-login").css('border-bottom', '1px solid #E1E1E1')
        }
        if (phone == '' || pass ==''){
            $(".alert").addClass("show");
            return false;
        }
        else{
            return true;
        }
    }


    function registerValidateForm()
    {
        let email = $("#email-register").val();
        let pass = $("#password-register").val();
        let name = $("#full_name").val();
        let phone = $("#phone-register").val();

        if (email == '') {
            $("#email-register").css('border-bottom', '1px solid red')
        }
        else{
            $("#email-register").css('border-bottom', '1px solid #9AA0A6')
        }
        if (phone == '') {
            $("#phone-register").css('border-bottom', '1px solid red')
        }
        else{
            $("#phone-register").css('border-bottom', '1px solid #9AA0A6')
        }
        /*console.log(gender)
        if (gender == '' || gender == "0" || gender == 0) {
            console.log('akjsj')
            $("#gender-register-div").css('border', '1px solid red')
        }
        else{
            $("#gender-register-div").css('border', '1px solid #9AA0A6')
        }*/

        if (name == '') {
            $("#full_name").css('border-bottom', '1px solid red')
        }
        else{
            $("#full_name").css('border-bottom', '1px solid #9AA0A6')
        }

        if (pass == '') {
            $("#password-register").css('border-bottom', '1px solid red')
        }
        else{
            $("#password-register").css('border-bottom', '1px solid #9AA0A6')
        }


        if (email == '' || pass =='' || name == '' || Sname == '' || phone == ''){
            return false;
        }
        else{
            return true;
        }
    }

    $(".advanced_search_districts").select2({
        placeholder: "<?=AIN::getPhrase('homdom.select_city')?>",
        language: {
            searching: function() {
                return "<?=AIN::getPhrase('homdom.searching')?>";
            }
        },
        ajax: {
            url: "/_ajax?core[ajax]=true&core[call]=homdom.searchDistrict",
            data: function(params) {
                var query = {
                    search: params.term,
                    page: params.page || 1
                }
                return query;
            },
            delay: 600,
            cache: true
        }
    })
</script>



@yield('js')
{{loadjs}}
</html>