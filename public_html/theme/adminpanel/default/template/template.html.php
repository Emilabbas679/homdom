<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{title}}</title>
    {{header}}
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">

    <link media="screen" href="https://cdn.ainsyndication.com/front/css/style.css?v=<?= AIN::getTime(); ?>" type="text/css" rel="stylesheet" />
    <link media="screen" href="/theme/adminpanel/style/css/datatables.min.css" type="text/css" rel="stylesheet" />
    <link media="screen" href="https://cdn.ainsyndication.com/front/css/responsive.css?v=<?= AIN::getTime(); ?>" type="text/css" rel="stylesheet" />
    <link media="screen" href="https://cdn.ainsyndication.com/front/css/st-adserver.css?v=<?= AIN::getTime(); ?>" type="text/css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @yield('css')

    <script src="https://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!--    <link href="/theme/frontend/homdom/style/css/select2.min.css" rel="stylesheet" />-->
<!--    <script src="/theme/frontend/homdom/style/js/select2.min.js"></script>-->
    <style>
        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        /* Style the buttons inside the tab */
        .tab button {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }
    </style>
</head>
<body>
<div class="x-admin">
    {{template file='admincp.block.header'}}
    {{template file='admincp.block.sidebar'}}
    <!-- Main content start -->
    <div class="main-content d-10">
        {{content}}
    </div>
    <!-- Main content end -->
</div>

<script type="text/javascript" src="/theme/adminpanel/default/style/js/jquery.scrollbar.min.js"></script>
<script type="text/javascript" src="/theme/adminpanel/default/style/js/datatables.min.js"></script>
<script type="text/javascript" src="/theme/adminpanel/default/style/js/select2.full.min.js"></script>


<script type="text/javascript" src="https://cdn.ainsyndication.com/front/js/xate.js?v=1630484636"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    $(document).ready(function(){
        var table = $('.dataTable').DataTable({
            searching: false,
            lengthChange: false,
            paging: false,
            info: false,
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": 1 },
            ],
            "order" : [['0', 'desc']]
        });

    });
</script>

<script>


    var drEvent = $(".dropify").dropify({
        messages: {
            'default': 'Şəkil əlavə etmək üçün kliklə və ya şəkli sürükləyin',
            'replace': 'Şəkil yeniləmək üçün kliklə və ya şəkli sürükləyin',
            'remove':  'Sil',
            'error':   'dropif.Error. The file is either not square, larger than 2 MB or not an acceptable file type'
        },

    })
    drEvent.on('dropify.afterClear', function(event, element){
        $("#old_image").val('')
    });

    $("#image").change(function (){
        $("#old_image").val('')
    })

    

</script>

<script>
    $('select#tags').select2({
        placeholder: "<?=AIN::getPhrase('homdom.tags')?>",
        language: {
            searching: function() {
                return "homdom.searching";
            }
        },

        ajax: {
            url: "/_ajax?core[ajax]=true&core[call]=admincp.searchArticleTags",
            tags:true,
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
    });
</script>
<script>
    function openTab(evt, lang) {
        var i, tabcontent, tablinks;
        let arr  = lang.split(".");
        tabcontent = document.getElementsByClassName("tabcontent-"+arr[0]);
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks-"+arr[0]);
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(lang).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>

<script>
    CKEDITOR.replace('ckeditor', {
        height: 300,
        filebrowserUploadUrl: '/_ajax?core[ajax]=true&core[call]=admincp.fileUploadCkEditor',
    });

</script>
@yield('js')

</body>
</html>