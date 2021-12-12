<?php $aForms = $this->_aVars['aForms'] ?>
<link rel="stylesheet" href="/theme/frontend/homdom/style/css/reset.css">
<link rel="stylesheet" href="/theme/frontend/homdom/style/css/googlemap.css">
<link rel="stylesheet" href="/theme/frontend/homdom/style/css/select2.min.css"/>
<link rel="stylesheet" href="/theme/frontend/homdom/style/css/style.css?v8">

<script src="/theme/frontend/homdom/style/js/jquery-3.4.1.min.js"></script>
<script src="/theme/frontend/homdom/style/js/select2.min.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

@section('css')

<style>
    .filepond--drop-label {color: #4c4e53;}
    .filepond--label-action {text-decoration-color: #babdc0;}
    .filepond--panel-root {border-radius: 2em;background-color: #edf0f4;height: 1em;}
    .filepond--item-panel {background-color: #595e68;}
    .filepond--drip-blob {background-color: #7f8a9a;}
    #core_js_messages .alert {display: block !important;}
</style>

@endsection

<div class="content-inner">
    <div class="breadcrumb">
        <ul>
            <li><a href="{{url link='dashboard.index'}}">Homdom</a></li>
            <li><a href="{{url link='offers.index'}}">{{phrase var='homdom.offers'}}</a></li>
            <li><span>{{phrase var='homdom.agency_add'}}</span></li>
        </ul>
    </div>
    <div class="a-block a-center">
        <div class="a-block-head">{{phrase var='homdom.offers_add'}}</div>
        <div class="a-block-body">
            <div class="form form-horizontal result">
                <?php if (isset($aForms['id'])){$id = $aForms['id'];} else {$id = 0;} ?>
                <form action="/building/add?id=<?=$id?>" method="POST"  enctype="multipart/form-data">
                    {{error}}
                    <div class="resident_complex_container">

                        <div class="wrap_body">

                            <div class="add_row">


                                <div class="form-group">
                                    <label class="form-label" for="u-number">{{phrase var='homdom.building_name'}}</label>
                                    <div class="form-input">
                                        <input id="building_name" class="building_name" value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms, 'building_name')?>" name="val[building_name]" type="text" placeholder="{{phrase var='homdom.building_name'}}">
                                    </div>
                                </div>


                                <div class="form-group" >
                                    <label class="form-label" for="status_id">{{phrase var='homdom.status_id'}}</label>
                                    <div class="custom_select">
                                        <select name="val[status_id]" id="" class="select-regist">
                                            <option value="11" <?= AIN::getService('homdom.helpers')->selected_exist($aForms , 'status_id', 11)?>>{{ phrase var='homdom.status_id_11'}}</option>
                                            <option value="12" <?= AIN::getService('homdom.helpers')->selected_exist($aForms , 'status_id', 12)?>>{{ phrase var='homdom.status_id_12'}}</option>
                                            <option value="9" <?= AIN::getService('homdom.helpers')->selected_exist($aForms , 'status_id', 9)?>>{{ phrase var='homdom.status_id_9'}}</option>
                                            <option value="10" <?= AIN::getService('homdom.helpers')->selected_exist($aForms , 'status_id', 10)?>>{{ phrase var='homdom.status_id_10'}}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="u-number">{{phrase var='homdom.floors_total'}}</label>
                                    <div class="form-input">
                                        <input type="text" min="1" name="val[floors_total]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms, 'floors_total')?>" placeholder="" class="integer_num floors_total" maxlength="3">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="u-number">{{phrase var='homdom.ceiling_height'}}</label>
                                    <div class="form-input">
                                        <input type="text" min="1" name="val[ceiling_height]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms, 'ceiling_height')?>" placeholder="" class="decimal ceiling_height" maxlength="3">
                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label class="form-label" for="status_id">{{phrase var='homdom.guarded_building'}}</label>
                                    <div class="custom_select">
                                        <select name="val[guarded_building]" id="" class="select-regist">
                                            <option value="1" <?= AIN::getService('homdom.helpers')->selected_exist($aForms , 'guarded_building', 1)?>>{{ phrase var='homdom.guarded_building_1'}}</option>
                                            <option value="0" <?= AIN::getService('homdom.helpers')->selected_exist($aForms , 'guarded_building', 0)?>>{{ phrase var='homdom.guarded_building_0'}}</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="form-label" for="u-number">{{phrase var='homdom.built_year'}}</label>
                                    <div class="form-input">
                                        <input type="text" min="1" name="val[built_year]" id="built_year" value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms, 'built_year')?>" class="built_year integer_num" placeholder="" maxlength="4">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="u-number">{{phrase var='homdom.delivery_year'}}</label>
                                    <div class="form-input">
                                        <input type="text" min="1" name="val[delivery_year]" id="delivery_year" value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms, 'delivery_year')?>" class="delivery_year integer_num" placeholder="" maxlength="4">
                                    </div>
                                </div>


                                <div class="add_col col_1 item_lbl_child_1">
                                    <div class="add_col col_3">
                                        <div class="add_litle_title">{{ phrase var='homdom.lift' }}</div>
                                    </div>
                                    <div class="add_col col_5">
                                        <div class="add_check_items static">
                                            <label class="add_inp_check_static check_lift">
                                                <input type="checkbox" name="val[lift][]"  value="1" placeholder="" <?= AIN::getService('homdom.helpers')->checkedIfInArray($aForms, 'lift', 1)?>>
                                                <span>{{ phrase var='homdom.lift_1' }}</span>
                                            </label>
                                        </div>
                                        <div class="add_check_items static ck_lift_type check_lift_same">
                                            <label class="add_check">
                                                <input type="checkbox" name="val[lift][]" id="2" value="2" <?= AIN::getService('homdom.helpers')->checkedIfInArray($aForms, 'lift', 2)?>>
                                                <span>{{ phrase var='homdom.passenger_lift' }}</span>
                                            </label>
                                        </div>
                                        <div class="add_check_items static ck_lift_type check_lift_same">
                                            <label class="add_check">
                                                <input type="checkbox" name="val[lift][]"   value='3' <?= AIN::getService('homdom.helpers')->checkedIfInArray($aForms, 'lift', 3)?>>
                                                <span>{{ phrase var='homdom.freight_lift' }} </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>


                                <div class="add_col col_1 item_lbl_child_1">
                                    <div class="add_col col_3">
                                        <div class="add_litle_title"> {{ phrase var='homdom.parking_type' }} </div>
                                    </div>
                                    <div class="add_col col_5">
                                        <div class="add_check_items static ck_parking_type">
                                            <label class="add_check">
                                                <input type="radio" name="val[parking]" value='0' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms, 'parking', 0)?> >
                                                <span>{{ phrase var="homdom.no" }} </span>
                                            </label>
                                        </div>
                                        <div class="add_check_items static ck_parking_type">
                                            <label class="add_check">
                                                <input type="radio" name="val[parking]" value='1' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms, 'parking', 1)?> >
                                                <span>{{ phrase var="homdom.close" }} </span>
                                            </label>
                                        </div>
                                        <div class="add_check_items static ck_parking_type">
                                            <label class="add_check">
                                                <input type="radio" name="val[parking]" value='2' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms, 'parking', 2)?>>
                                                <span>{{ phrase var="homdom.underground" }} </span>
                                            </label>
                                        </div>
                                        <div class="add_check_items static ck_parking_type">
                                            <label class="add_check">
                                                <input type="radio" name="val[parking]" value='3' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms, 'parking', 3)?>  >
                                                <span>{{ phrase var="homdom.open" }} </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="add_col col_1">

                                    <div class="add_col col_1">
                                        <input type="hidden" name="val[latitude]" id="lat" placeholder="lat"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms, 'latitude')?>"  style="background-color: #eee;padding: 10px;float:left;">
                                        <input type="hidden" name="val[longitude]" id="lng" placeholder="lng"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms, 'longitude')?>" style="background-color: #eee;padding: 10px;float:left;">
                                        <div class="add_map">
                                            <input id="pac-input" class="controls" type="text" name="val[address]" value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms, 'address')?>" placeholder="{{ phrase var='homdom.select_address' }}" />
                                            <div id="map"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- this are all items have -->
                            </div>

                        </div>



                        <div class="add_row added_all_galery_foto">
                            <div class="add_head"> {{ phrase var='homdom.images' }} </div>
                            <div class="add_litle_info">
                                {{ phrase var='homdom.images_detail' }}
                            </div>
                            <div class="add_col col_1">
                                <div class="add_img_gallery">
                                    <?php if(isset($aForms['image'])) { ?>
                                        <?php foreach ($aForms['image'] as $img) { ?>
                                            <a href="<?=$img?>" data-fancybox="gallery" data-caption="" data-id="<?=$img?>" class="add_galery_items">
                                                <img src="<?=$img?>" alt="" />
                                            </a>
                                        <?php }} ?>
                                </div>
                            </div>

                            <div class="add_col col_1">
                                <div class="lg_input">
                                    <input type="file" name="image" class="image" multiple>
                                    <div id="images">
                                        <?php if(isset($aForms['image'])) { ?>

                                            <?php foreach ($aForms['image'] as $img) { ?>
                                                <input type="hidden" name="val[image][]" value="<?=$img?>">
                                            <?php } }?>
                                    </div>

                                </div>
                            </div>

                        </div>


                        <div class="add_row ">
                            <div class="add_head"> {{ phrase var='homdom.description' }} </div>
                            <div class="add_col col_1">
                                <textarea name="val[description]" id="ckeditor" style="width: 100%;"  class="add_home_comment" placeholder="{{phrase var='description_placeholder'}}"><?= AIN::getService('homdom.helpers')->getValueOfInput($aForms, 'description')?></textarea>
                            </div>
                        </div>

                        <div class="add_row add_form_finish">
                            <div class="add_col col_1">
                                <button type="submit" class="prof_inf_submit">Yadda saxla </button>
                            </div>
                        </div>
                    </div>
            </div>

            </form>
        </div>
    </div>
</div>

@section('js')
<style>
    #cke_ckeditor{width: 100%}
</style>
<link href="/theme/frontend/homdom/style/filepond/filepond-plugin-media-preview.css?v=<?= AIN::getTime(); ?>" rel="stylesheet">
<link href="/theme/frontend/homdom/style/filepond/filepond.css?v=<?= AIN::getTime(); ?>" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

<style>
    .filepond--credits{display: none !important;}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.6.15/browser-polyfill.min.js"></script>
<!--<script src="https://unpkg.com/filepond-polyfill/dist/filepond-polyfill.js"></script>-->
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<!--<script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>-->
<!--<script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>-->
<!--<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>-->
<!--<script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>-->
<script src="/theme/frontend/homdom/style/filepond/filepond-plugin-media-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-validate-size/dist/filepond-plugin-image-validate-size.js"></script>
<!--<script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script>-->
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

<!--<script src="https://unpkg.com/filepond/dist/filepond.js"></script>-->
<!--<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>-->


<script src="/theme/frontend/homdom/style/js/datepicker.min.js"></script>
<script src="/theme/frontend/homdom/style/js/jquery.inputmask.min.js"></script>
<script src="/theme/frontend/homdom/style/js/select.js"></script>
<script src="/theme/frontend/homdom/style/js/myjs.js?v5"></script>

<script type="text/javascript">
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
    //Date
    $('[data-toggle="datepicker"]').datepicker({
        autoHide: true,
        format: 'dd.mm.yyyy',
        minDate: '-1m'
    });

</script>

<script>
    // class="im
    document.addEventListener('DOMContentLoaded', function() {
        FilePond.registerPlugin(
            FilePondPluginFileValidateSize,
            FilePondPluginMediaPreview,
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType
        );
        var pond_image = FilePond.create(document.querySelector('input.image'),{
            labelIdle: '<span class="prof_inf_lb_file"><?=AIN::getPhrase('homdom.add_files')?></span><span class="add_gallry_inf">və ya sahəyə sürükləyin</span>',
            imagePreviewHeight: 300,
            imageCropAspectRatio: '4:3',
            imageResizeTargetWidth: 200,
            imageResizeTargetHeight: 300,
            // files: [
            //     {
            // source: 'https://cdn.ainsyndication.com/2021-09/1631695518_f19c9085129709ee14d013be869df69b.png',
            // }
            // ]

        });
        pond_image.setOptions({
            server: {
                process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    const formData = new FormData();
                    formData.append(fieldName, file, file.name);
                    const request = new XMLHttpRequest();
                    request.open('POST', '/_ajax?core[ajax]=true&core[call]=homdom.upload');
                    request.upload.onprogress = (e) => {
                        progress(e.lengthComputable, e.loaded, e.total);
                    };
                    request.onload = function () {
                        if (request.status >= 200 && request.status < 300) {
                            let res = request.responseText
                            let arr = JSON.parse(res)
                            console.log(arr['down_url'])
                            $("#images").append('<input type="hidden" name="val[image][]" value="'+arr['down_url']+'" id="'+arr['down_url']+'">')
                            load(arr['down_url']);
                        } else {
                            error(request.responseText);
                        }
                    };
                    request.send(formData);
                },
                revert:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    $("input[value='"+fieldName+"']").remove()
                },
                restore: '/static/api/restore?id=',
                fetch: '/static/api/fetch?data=',
                load: '/static/api/load',
            },
            acceptedFileTypes: [
                'image/*'
            ],
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        FilePond.registerPlugin(
            FilePondPluginFileValidateSize,
            FilePondPluginMediaPreview,
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType
        );
        var pond_image = FilePond.create(document.querySelector('input.logo'),{
            labelIdle: '<span class="prof_inf_lb_file"><?=AIN::getPhrase('homdom.add_logo')?></span><span class="add_gallry_inf">və ya sahəyə sürükləyin</span>',
            imagePreviewHeight: 300,
            imageCropAspectRatio: '4:3',
            imageResizeTargetWidth: 200,
            imageResizeTargetHeight: 300,
            // files: [
            //     {
            // source: 'https://cdn.ainsyndication.com/2021-09/1631695518_f19c9085129709ee14d013be869df69b.png',
            // }
            // ]

        });
        pond_image.setOptions({
            server: {
                process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    const formData = new FormData();
                    formData.append(fieldName, file, file.name);
                    const request = new XMLHttpRequest();
                    request.open('POST', '/_ajax?core[ajax]=true&core[call]=homdom.upload');
                    request.upload.onprogress = (e) => {
                        progress(e.lengthComputable, e.loaded, e.total);
                    };
                    request.onload = function () {
                        if (request.status >= 200 && request.status < 300) {
                            let res = request.responseText
                            let arr = JSON.parse(res)
                            console.log(arr['down_url'])
                            $("#logo").val(arr['down_url'])
                            load(arr['down_url']);
                        } else {
                            error(request.responseText);
                        }
                    };
                    request.send(formData);
                },
                revert:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    $("input[value='"+fieldName+"']").remove()
                },
                restore: '/static/api/restore?id=',
                fetch: '/static/api/fetch?data=',
                load: '/static/api/load',
            },
            acceptedFileTypes: [
                'image/*'
            ],
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        FilePond.registerPlugin(
            FilePondPluginFileValidateSize,
            FilePondPluginMediaPreview,
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType
        );
        var pond_image = FilePond.create(document.querySelector('input.cover_photo'),{
            labelIdle: '<span class="prof_inf_lb_file"><?=AIN::getPhrase('homdom.add_cover')?></span><span class="add_gallry_inf">və ya sahəyə sürükləyin</span>',
            imagePreviewHeight: 300,
            imageCropAspectRatio: '4:3',
            imageResizeTargetWidth: 200,
            imageResizeTargetHeight: 300,
            // files: [
            //     {
            // source: 'https://cdn.ainsyndication.com/2021-09/1631695518_f19c9085129709ee14d013be869df69b.png',
            // }
            // ]

        });
        pond_image.setOptions({
            server: {
                process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    const formData = new FormData();
                    formData.append(fieldName, file, file.name);
                    const request = new XMLHttpRequest();
                    request.open('POST', '/_ajax?core[ajax]=true&core[call]=homdom.upload');
                    request.upload.onprogress = (e) => {
                        progress(e.lengthComputable, e.loaded, e.total);
                    };
                    request.onload = function () {
                        if (request.status >= 200 && request.status < 300) {
                            let res = request.responseText
                            let arr = JSON.parse(res)
                            console.log(arr['down_url'])
                            $("#cover_photo").val(arr['down_url'])
                            load(arr['down_url']);
                        } else {
                            error(request.responseText);
                        }
                    };
                    request.send(formData);
                },
                revert:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    $("input[value='"+fieldName+"']").remove()
                },
                restore: '/static/api/restore?id=',
                fetch: '/static/api/fetch?data=',
                load: '/static/api/load',
            },
            acceptedFileTypes: [
                'image/*'
            ],
        });
    });




    document.addEventListener('DOMContentLoaded', function() {
        FilePond.registerPlugin(
            FilePondPluginFileValidateSize,
            FilePondPluginMediaPreview,
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType
        );

        var pond_video = FilePond.create(document.querySelector('input.video'),{
            labelIdle: '<?=AIN::getPhrase('homdom.add_videos')?>',
        });

        pond_video.setOptions({
            server: {
                process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {

                    const formData = new FormData();
                    formData.append(fieldName, file, file.name);
                    const request = new XMLHttpRequest();
                    //console.log(request.responseText);
                    request.open('POST', '/_ajax?core[ajax]=true&core[call]=homdom.upload');
                    request.upload.onprogress = (e) => {
                        progress(e.lengthComputable, e.loaded, e.total);
                    };
                    request.onload = function () {
                        if (request.status >= 200 && request.status < 300) {
                            let res = request.responseText
                            let arr = JSON.parse(res)
                            $("#videos").append('<input type="hidden" name="val[videos][]" value="'+arr['down_url']+'" id="'+arr['down_url']+'">')
                            load(arr['down_url']);
                        } else {
                            error(request.responseText);
                        }
                    };

                    request.send(formData);
                },
                revert:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    $("input[value='"+fieldName+"']").remove()
                },
                restore: '/static/api/restore?id=',
                fetch: '/static/api/fetch?data=',
                load: '/static/api/load',
            },
            acceptedFileTypes: [
                'video/*'
            ],
        });

    });



</script>

<script>
    $('#buildings').select2({
        placeholder: "<?=AIN::getPhrase('homdom.select_building')?>",
        tags:true,
        language: {
            searching: function() {
                return "<?=AIN::getPhrase('homdom.searching')?>";
            },
            noResults: function(){
                return "<?=AIN::getPhrase('homdom.not_found')?>"
            }
        },

        ajax: {
            url: "/_ajax?core[ajax]=true&core[call]=homdom.searchBuilding",
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

    $("#buildings").change(function(){
        let value = $(this).val();
        if (parseInt(value) != 0) {
            $.ajax({
                type: "GET",
                data: {
                    'id': parseInt(value),
                },
                url: '/_ajax?core[ajax]=true&core[call]=homdom.getBuilding',
                success: function (response) {
                    $(".built_year").val(response.built_year)
                    $(".ceiling_height").val(response.ceiling_height)
                    $(".floors_total").val(response.floors_total)
                    if(response.delivery_year == null) {
                        $('.delivery_type').prop('checked', true);
                    }else{
                        $('.delivery_type').prop('checked', false);
                    }
                    $(".built_year").val(response.built_year)

                }
            });
            $(this).siblings(".select2").find(".selection").removeClass("inp_null");
        }else{
            $(".built_year").val()
            $(".ceiling_height").val()
            $(".floors_total").val()
            $('.delivery_type').prop('checked', false);
            $(this).siblings(".select2").find(".selection").addClass("inp_null");
        }
    })



    $('#regions').select2({
        placeholder: "<?=AIN::getPhrase('homdom.select_region')?>",
        language: {
            searching: function() {
                return "<?=AIN::getPhrase('homdom.searching')?>";
            },
            noResults: function(){
                return "<?=AIN::getPhrase('homdom.not_found')?>"
            }
        },

        ajax: {
            url: "/_ajax?core[ajax]=true&core[call]=homdom.searchRegion",
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


    $("#locality_block").hide()
    $("#metro_block").hide()


    $('#cities').select2({
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
    });




    $('#metros').select2({
        placeholder: "<?=AIN::getPhrase('homdom.select_metro')?>",
        language: {
            searching: function() {
                return "<?=AIN::getPhrase('homdom.searching')?>";
            }
        },
        ajax: {
            url: "/_ajax?core[ajax]=true&core[call]=homdom.searchMetro",
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


    $("#cities").change(function () {
        let city_id = $(this).val();
        let metro_id = $("#metros").val();
        if (city_id == 2) {
            $("#metro_block").show()
            $("#locality_block").show();
            localities(city_id)
        }
        else{
            $("#metro_block").hide();
            $("#locality_block").hide()
            let c = $(metro_id).val('0');
            //console.log(c+"redd");
        }
    })


    function localities(districtId){
        $('#localities').select2({
            placeholder: "<?=AIN::getPhrase('homdom.select_locality')?>",
            language: {
                searching: function() {
                    return "<?=AIN::getPhrase('homdom.searching')?>";
                }
            },
            ajax: {
                url: "/_ajax?core[ajax]=true&core[call]=homdom.searchLocality",
                data: function(params) {
                    var query = {
                        search: params.term,
                        districtId: districtId,
                        page: params.page || 1
                    }
                    return query;
                },
                delay: 600,
                cache: true
            }
        });
    }



</script>
<script>
    $(document).ready(function() {

        $('select.select_tags').select2({
            tags: true,
            createTag: function (params) {
                var term = $.trim(params.term);

                if (term === '') {
                    return null;
                }

                return {
                    id: term,
                    text: term,
                    newTag: true
                }
            }
        });
    });
</script>
<script>
    var defaults = {
        // Close existing modals
        // Set this to false if you do not need to stack multiple instances
        closeExisting: false,

        // Enable infinite gallery navigation
        loop: false,

        // Horizontal space between slides
        gutter: 50,

        // Enable keyboard navigation
        keyboard: true,

        // Should allow caption to overlap the content
        preventCaptionOverlap: true,

        // Should display navigation arrows at the screen edges
        arrows: true,

        // Should display counter at the top left corner
        infobar: true,

        // Should display close button (using `btnTpl.smallBtn` template) over the content
        // Can be true, false, "auto"
        // If "auto" - will be automatically enabled for "html", "inline" or "ajax" items
        smallBtn: "auto",

        // Should display toolbar (buttons at the top)
        // Can be true, false, "auto"
        // If "auto" - will be automatically hidden if "smallBtn" is enabled
        toolbar: "auto",

        // What buttons should appear in the top right corner.
        // Buttons will be created using templates from `btnTpl` option
        // and they will be placed into toolbar (class="fancybox-toolbar"` element)
        buttons: [
            "zoom",
            //"share",
            "slideShow",
            //"fullScreen",
            //"download",
            "thumbs",
            "close"
        ],

        // Detect "idle" time in seconds
        idleTime: 3,

        // Disable right-click and use simple image protection for images
        protect: false,

        // Shortcut to make content "modal" - disable keyboard navigtion, hide buttons, etc
        modal: false,

        image: {
            // Wait for images to load before displaying
            //   true  - wait for image to load and then display;
            //   false - display thumbnail and load the full-sized image over top,
            //           requires predefined image dimensions (`data-width` and `data-height` attributes)
            preload: false
        },

        ajax: {
            // Object containing settings for ajax request
            settings: {
                // This helps to indicate that request comes from the modal
                // Feel free to change naming
                data: {
                    fancybox: true
                }
            }
        },

        iframe: {
            // Iframe template
            tpl:
                '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" allowfullscreen allow="autoplay; fullscreen" src=""></iframe>',

            // Preload iframe before displaying it
            // This allows to calculate iframe content width and height
            // (note: Due to "Same Origin Policy", you can't get cross domain data).
            preload: true,

            // Custom CSS styling for iframe wrapping element
            // You can use this to set custom iframe dimensions
            css: {},

            // Iframe tag attributes
            attr: {
                scrolling: "auto"
            }
        },

        // For HTML5 video only
        video: {
            tpl:
                '<video class="fancybox-video" controls controlsList="nodownload" poster="">' +
                '<source src="" type="" />' +
                'Sorry, your browser doesn\'t support embedded videos, <a href="">download</a> and watch with your favorite video player!' +
                "</video>",
            format: "", // custom video format
            autoStart: true
        },

        // Default content type if cannot be detected automatically
        defaultType: "image",

        // Open/close animation type
        // Possible values:
        //   false            - disable
        //   "zoom"           - zoom images from/to thumbnail
        //   "fade"
        //   "zoom-in-out"
        //
        animationEffect: "zoom",

        // Duration in ms for open/close animation
        animationDuration: 366,

        // Should image change opacity while zooming
        // If opacity is "auto", then opacity will be changed if image and thumbnail have different aspect ratios
        zoomOpacity: "auto",

        // Transition effect between slides
        //
        // Possible values:
        //   false            - disable
        //   "fade'
        //   "slide'
        //   "circular'
        //   "tube'
        //   "zoom-in-out'
        //   "rotate'
        //
        transitionEffect: "fade",

        // Duration in ms for transition animation
        transitionDuration: 366,

        // Custom CSS class for slide element
        slideClass: "",

        // Custom CSS class for layout
        baseClass: "",

        // Base template for layout
        baseTpl:
            '<div class="fancybox-container" role="dialog" tabindex="-1">' +
            '<div class="fancybox-bg"></div>' +
            '<div class="fancybox-inner">' +
            '<div class="fancybox-infobar"><span data-fancybox-index></span>&nbsp;/&nbsp;<span data-fancybox-count></span></div>' +
            '<div class="fancybox-toolbar"></div>' +
            '<div class="fancybox-navigation"></div>' +
            '<div class="fancybox-stage"></div>' +
            '<div class="fancybox-caption"><div class=""fancybox-caption__body"></div></div>' +
            '</div>' +
            '</div>',

        // Loading indicator template
        spinnerTpl: '<div class="fancybox-loading"></div>',

        // Error message template
        errorTpl: '<div class="fancybox-error"><p></p></div>',

        btnTpl: {
            download:
                '<a download data-fancybox-download class="fancybox-button fancybox-button--download" title="" href="javascript:;">' +
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.62 17.09V19H5.38v-1.91zm-2.97-6.96L17 11.45l-5 4.87-5-4.87 1.36-1.32 2.68 2.64V5h1.92v7.77z"/></svg>' +
                "</a>",

            zoom:
                '<button data-fancybox-zoom class="fancybox-button fancybox-button--zoom" title="">' +
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.7 17.3l-3-3a5.9 5.9 0 0 0-.6-7.6 5.9 5.9 0 0 0-8.4 0 5.9 5.9 0 0 0 0 8.4 5.9 5.9 0 0 0 7.7.7l3 3a1 1 0 0 0 1.3 0c.4-.5.4-1 0-1.5zM8.1 13.8a4 4 0 0 1 0-5.7 4 4 0 0 1 5.7 0 4 4 0 0 1 0 5.7 4 4 0 0 1-5.7 0z"/></svg>' +
                "</button>",

            close:
                '<button data-fancybox-close class="fancybox-button fancybox-button--close" title="">' +
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 10.6L6.6 5.2 5.2 6.6l5.4 5.4-5.4 5.4 1.4 1.4 5.4-5.4 5.4 5.4 1.4-1.4-5.4-5.4 5.4-5.4-1.4-1.4-5.4 5.4z"/></svg>' +
                "</button>",

            // Arrows
            arrowLeft:
                '<button data-fancybox-prev class="fancybox-button fancybox-button--arrow_left" title="">' +
                '<div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.28 15.7l-1.34 1.37L5 12l4.94-5.07 1.34 1.38-2.68 2.72H19v1.94H8.6z"/></svg></div>' +
                "</button>",

            arrowRight:
                '<button data-fancybox-next class="fancybox-button fancybox-button--arrow_right" title="">' +
                '<div><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15.4 12.97l-2.68 2.72 1.34 1.38L19 12l-4.94-5.07-1.34 1.38 2.68 2.72H5v1.94z"/></svg></div>' +
                "</button>",

            // This small close button will be appended to your html/inline/ajax content by default,
            // if "smallBtn" option is not set to false
            smallBtn:
                '<button type="button" data-fancybox-close class="fancybox-button fancybox-close-small" title="">' +
                '<svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24"><path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"/></svg>' +
                "</button>"
        },

        // Container is injected into this element
        parentEl: "body",

        // Hide browser vertical scrollbars; use at your own risk
        hideScrollbar: true,

        // Focus handling
        // ==============

        // Try to focus on the first focusable element after opening
        autoFocus: true,

        // Put focus back to active element after closing
        backFocus: true,

        // Do not let user to focus on element outside modal content
        trapFocus: true,

        // Module specific options
        // =======================

        fullScreen: {
            autoStart: false
        },

        // Set `touch: false` to disable panning/swiping
        touch: {
            vertical: true, // Allow to drag content vertically
            momentum: true // Continue movement after releasing mouse/touch when panning
        },

        // Hash value when initializing manually,
        // set `false` to disable hash change
        hash: null,

        // Customize or add new media types
        // Example:
        /*
        media : {
        youtube : {
        params : {
        autoplay : 0
        }
        }
        }
        */
        media: {},

        slideShow: {
            autoStart: false,
            speed: 3000
        },

        thumbs: {
            autoStart: false, // Display thumbnails on opening
            hideOnClose: true, // Hide thumbnail grid when closing animation starts
            parentEl: ".fancybox-container", // Container is injected into this element
            axis: "y" // Vertical (y) or horizontal (x) scrolling
        },

        // Use mousewheel to navigate gallery
        // If 'auto' - enabled for images only
        wheel: "auto",

        // Callbacks
        //==========

        // See Documentation/API/Events for more information
        // Example:
        /*
        afterShow: function( instance, current ) {
        console.info( 'Clicked element:' );
        console.info( current.opts.$orig );
        }
        */

        onInit: $.noop, // When instance has been initialized

        beforeLoad: $.noop, // Before the content of a slide is being loaded
        afterLoad: $.noop, // When the content of a slide is done loading

        beforeShow: $.noop, // Before open animation starts
        afterShow: $.noop, // When content is done loading and animating

        beforeClose: $.noop, // Before the instance attempts to close. Return false to cancel the close.
        afterClose: $.noop, // After instance has been closed

        onActivate: $.noop, // When instance is brought to front
        onDeactivate: $.noop, // When other instance has been activated

        // Interaction
        // ===========

        // Use options below to customize taken action when user clicks or double clicks on the fancyBox area,
        // each option can be string or method that returns value.
        //
        // Possible values:
        //   "close"           - close instance
        //   "next"            - move to next gallery item
        //   "nextOrClose"     - move to next gallery item or close if gallery has only one item
        //   "toggleControls"  - show/hide controls
        //   "zoom"            - zoom image (if loaded)
        //   false             - do nothing

        // Clicked on the content
        clickContent: function(current, event) {
            return current.type === "image" ? "zoom" : false;
        },

        // Clicked on the slide
        clickSlide: "close",

        // Clicked on the background (backdrop) element;
        // if you have not changed the layout, then most likely you need to use `clickSlide` option
        clickOutside: "close",

        // Same as previous two, but for double click
        dblclickContent: false,
        dblclickSlide: false,
        dblclickOutside: false,

        // Custom options when mobile device is detected
        // =============================================

        mobile: {
            preventCaptionOverlap: false,
            idleTime: false,
            clickContent: function(current, event) {
                return current.type === "image" ? "toggleControls" : false;
            },
            clickSlide: function(current, event) {
                return current.type === "image" ? "toggleControls" : "close";
            },
            dblclickContent: function(current, event) {
                return current.type === "image" ? "zoom" : false;
            },
            dblclickSlide: function(current, event) {
                return current.type === "image" ? "zoom" : false;
            }
        },

        // Internationalization
        // ====================

        lang: "en",
        i18n: {
            en: {
                CLOSE: "Close",
                NEXT: "Next",
                PREV: "Previous",
                ERROR: "The requested content cannot be loaded. <br/> Please try again later.",
                PLAY_START: "Start slideshow",
                PLAY_STOP: "Pause slideshow",
                FULL_SCREEN: "Full screen",
                THUMBS: "Thumbnails",
                DOWNLOAD: "Download",
                SHARE: "Share",
                ZOOM: "Zoom"
            },
            de: {
                CLOSE: "Schliessen",
                NEXT: "Weiter",
                PREV: "Zurück",
                ERROR: "Die angeforderten Daten konnten nicht geladen werden. <br/> Bitte versuchen Sie es später nochmal.",
                PLAY_START: "Diaschau starten",
                PLAY_STOP: "Diaschau beenden",
                FULL_SCREEN: "Vollbild",
                THUMBS: "Vorschaubilder",
                DOWNLOAD: "Herunterladen",
                SHARE: "Teilen",
                ZOOM: "Maßstab"
            }
        }
    };
</script>
<script src="/theme/frontend/homdom/style/js/datepicker.min.js"></script>
<!-- <script src="js/jquery-ui.1.11.2.min.js"></script>
<script src="js/jquery.canvasjs.min.js"></script> -->
<script src="/theme/frontend/homdom/style/js/chart.js"></script>
<!--<script src="/theme/frontend/homdom/style/js/google_map.js" async ></script>-->
<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-CKp2U2hWbhVaaGhHBgvH0qJt4pFWbl4&callback=initAutocomplete&libraries=places&v=weekly" async></script>
<script type="text/javascript">
    // This example adds a search box to a map, using the Google Place Autocomplete
    // feature. People can enter geographical searches. The search box will return a
    // pick list containing a mix of places and predicted search terms.
    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
    let map;
    let marker;
    let markers = [];
    function initAutocomplete() {
        const map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 40.409264, lng: 49.867092 },
            zoom: 13,
            mapTypeId: "roadmap",
        });

        // Create the search box and link it to the UI element.
        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });



        // Create the initial InfoWindow.
        let infoWindow = new google.maps.InfoWindow({
            //content: "Click the map to get Lat/Lng!",
            position: { lat: 40.409264, lng: 49.867092 },
        });
        //infoWindow.open(map);
        // [START maps_event_click_latlng_listener]
        // Configure the click listener.
        map.addListener("click", (mapsMouseEvent) => {
            // Close the current InfoWindow.
            infoWindow.close();
            // Create a new InfoWindow.
            infoWindow = new google.maps.InfoWindow({
                position: mapsMouseEvent.latLng,

            });

            let json_latLng = JSON.stringify(mapsMouseEvent.latLng, null, 2);

            $("#lat").val(JSON.parse(json_latLng)['lat'])
            $("#lng").val(JSON.parse(json_latLng)['lng'])
            addMarker(mapsMouseEvent.latLng);
            //infoWindow.open(map);


        });

        function addMarker(position) {
            const marker = new google.maps.Marker({
                map,
                draggable: true,
                animation: google.maps.Animation.DROP,
                position,
            });

            markers.push(marker);
            marker.addListener("click", toggleBounce);
        }
        // Sets the map on all markers in the array.
        function setMapOnAll(map) {
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }

        // Removes the markers from the map, but keeps them in the array.
        function hideMarkers() {
            setMapOnAll(null);
        }

        // Shows any markers currently in the array.
        function showMarkers() {
            setMapOnAll(map);
        }

        // Deletes all markers in the array by removing references to them.
        function deleteMarkers() {
            hideMarkers();
            markers = [];
        }
        //map.addListener("click", (showMarkers) => {
        //  console.log("uuuuuu");
        //});
        document.getElementById("map").addEventListener("mousedown", deleteMarkers);

        //let markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }
            // Clear out the old markers.
            //markers.forEach((marker) => {
            // marker.setMap(null);
            //});
            //markers = [];
            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();
            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                const icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25),
                };
                // Create a marker for each place.
                markers.push(
                    new google.maps.Marker({
                        map,
                        icon,
                        title: place.name,
                        position: place.geometry.location,
                    })
                );

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
    }

    function toggleBounce() {
        if (marker.getAnimation() !== null) {
            marker.setAnimation(null);
        } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
        }
    }
</script>


<script>
    // $(".add_check_items.static input").each(function() {
    //   $(this).click(function() {

    //     if ($(this).is(":checked")){
    //       console.log("noncheckeddd");
    //       $(this).prop( "checked", false );
    //     }
    //   });
    // });

    $( ".add_anc_form" ).submit(function( event ) {
        // return true;
        item_AllVideo();
        item_AllPrice();
        home_buy_sell();
        {{ if !auth() }}
        item_AllContact();
        {{ /if }}

            if ($(".item_lbl_1 input").is(":checked")){
                item_1();
            } else if ($(".item_lbl_2 input").is(":checked")){
                item_2();
            } else if ($(".item_lbl_3 input").is(":checked")){
                item_3();
            } else if ($(".item_lbl_4 input").is(":checked")){
                item_4();
            } else if ($(".item_lbl_5 input").is(":checked")){
                item_5();
            } else if ($(".item_lbl_6 input").is(":checked")){
                item_6();
            } else{
                event.preventDefault();
            }

            //event.preventDefault();
        });
            function home_buy_sell(){

                function item_radio_control() {
                    $(".home_check_buy_sell input").each(function(index) {
                        let elem_this = $(this);
                        home_buy(elem_this);
                    });
                }
                item_radio_control();
                function home_buy(elem_this){
                    if (elem_this.is(":checked") || elem_this.parents(".home_check_buy_sell").siblings().find("input").is(":checked")){
                        elem_this.siblings(".ch_hm_validate").removeClass("inp_null");
                        elem_this.parents(".home_check_buy_sell").siblings().find("input").siblings(".ch_hm_validate").removeClass("inp_null");
                        return true;
                    } else {
                        elem_this.siblings(".ch_hm_validate").addClass("inp_null");
                        event.preventDefault();
                    }
                    elem_this.click(function() {
                        if (elem_this.is(":checked")){
                            elem_this.siblings(".ch_hm_validate").removeClass("inp_null");
                            elem_this.parents(".home_check_buy_sell").siblings().find("input").siblings(".ch_hm_validate").removeClass("inp_null");
                            return true;
                        } else {
                            elem_this.siblings(".ch_hm_validate").addClass("inp_null");
                        }
                    });
                }


            }

            function item_AllVideo(){
                $(".added_video .add_search input").each(function(index) {
                    if ($(this).val() === "") {
                        $(this).addClass("inp_null");
                        $(this).parents(".add_col").find(".alert").addClass("show");
                        event.preventDefault();
                    } else {
                        $(this).removeClass("inp_null");
                        $(this).parents(".add_col").find(".alert").removeClass("show");
                        return true;
                    }
                    $(this).keyup(function() {
                        if ($(this).val() === "") {
                            $(this).addClass("inp_null");
                        } else {
                            $(this).removeClass("inp_null");
                            $(this).parents(".add_col").find(".alert").removeClass("show");
                        }
                    });
                });
            }

            function item_AllPrice(){
                $(".appart_price_row .add_search input").each(function(index) {
                    if ($(this).val() === "") {
                        $(this).addClass("inp_null");
                        $(this).parents(".add_col").find(".alert").addClass("show");
                        event.preventDefault();
                    } else {
                        $(this).removeClass("inp_null");
                        $(this).parents(".add_col").find(".alert").removeClass("show");
                        return true;
                    }
                    $(this).keyup(function() {
                        if ($(this).val() === "") {
                            $(this).addClass("inp_null");
                        } else {
                            $(this).removeClass("inp_null");
                            $(this).parents(".add_col").find(".alert").removeClass("show");
                        }
                    });


                });
                $(".appart_price_row .add_inp_number input").each(function(index) {
                    if ($(this).val() === "") {
                        $(this).addClass("inp_null");
                        $(this).parents(".add_col").find(".alert").addClass("show");
                        event.preventDefault();
                        item_radio_control();
                    } else {
                        $(this).removeClass("inp_null");
                        $(this).parents(".add_col").find(".alert").removeClass("show");
                        item_radio_control();
                    }
                    $(this).keyup(function() {
                        if ($(this).val() === "") {
                            $(this).addClass("inp_null");
                        } else {
                            $(this).removeClass("inp_null");
                            $(this).parents(".add_col").find(".alert").removeClass("show");
                        }
                    });
                });

                function item_radio_control() {
                    $(".appart_price_row .add_check_items.static.ck_build_mortgage input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                    $(".appart_price_row .add_check_items.static.ck_build_haggle input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                }


            }
            function item_AllContact(){
                $(".contact_row .add_search input").each(function(index) {
                    if ($(this).val() === "") {
                        $(this).addClass("inp_null");
                        $(this).parents(".add_col").find(".alert").addClass("show");
                        event.preventDefault();
                    } else {
                        $(this).removeClass("inp_null");
                        $(this).parents(".add_col").find(".alert").removeClass("show");
                        return true;
                    }
                    $(this).keyup(function() {
                        if ($(this).val() === "") {
                            $(this).addClass("inp_null");
                        } else {
                            $(this).removeClass("inp_null");
                            $(this).parents(".add_col").find(".alert").removeClass("show");
                        }
                    });
                });
                $(".contact_row .add_inp_number input").each(function(index) {
                    if ($(this).val() === "") {
                        $(this).addClass("inp_null");
                        $(this).parents(".add_col").find(".alert").addClass("show");
                        event.preventDefault();
                    } else {
                        $(this).removeClass("inp_null");
                        return true;
                    }
                    $(this).keyup(function() {
                        if ($(this).val() === "") {
                            $(this).addClass("inp_null");
                        } else {
                            $(this).removeClass("inp_null");
                        }
                    });
                });
            }
            // Checkbox element validation
            function items_checked(elem_this){
                if (elem_this.is(":checked") || elem_this.parents(".add_check_items").siblings().find("input").is(":checked")){
                    elem_this.siblings("span").removeClass("inp_null");
                    elem_this.parents(".add_check_items").siblings().find("input").siblings("span").removeClass("inp_null");
                    return true;
                } else {
                    elem_this.siblings("span").addClass("inp_null");
                    // console.log("secilmiyibbbbb");
                    event.preventDefault();
                }
                elem_this.click(function() {
                    if (elem_this.is(":checked")){
                        elem_this.siblings("span").removeClass("inp_null");
                        elem_this.parents(".add_check_items").siblings().find("input").siblings("span").removeClass("inp_null");
                        return true;
                    } else {
                        elem_this.siblings("span").removeClass("inp_null");
                    }
                });
            }
            // Checkbox element validation

            function item_1(){
                $(".item_lbl_child_1 .add_search input").each(function(index) {
                    if ($(this).val() === "") {
                        $(this).addClass("inp_null");
                        $(this).parents(".add_col").find(".alert").addClass("show");
                        event.preventDefault();
                    } else {
                        $(this).removeClass("inp_null");
                        $(this).parents(".add_col").find(".alert").removeClass("show");
                        return true;
                    }

                    $(this).keyup(function() {
                        if ($(this).val() === "") {
                            $(this).addClass("inp_null");
                        } else {
                            $(this).removeClass("inp_null");
                            $(this).parents(".add_col").find(".alert").removeClass("show");
                        }
                    });
                });
                // $(".item_lbl_child_1 .add_search select").each(function(index) {
                //   if ($(this).val() === "") {
                //     $(this).addClass("inp_null");
                //     $(this).parents(".add_col").find(".alert").addClass("show");
                //     event.preventDefault();
                //     console.log("sec");
                //   } else {
                //     $(this).removeClass("inp_null");
                //     $(this).parents(".add_col").find(".alert").removeClass("show");
                //     console.log("dell");
                //     return true;
                //   }

                //   $(this).keyup(function() {
                //     if ($(this).val() === "") {
                //       $(this).addClass("inp_null");
                //     } else {
                //       $(this).removeClass("inp_null");
                //       $(this).parents(".add_col").find(".alert").removeClass("show");
                //     }
                //   });
                // });
                // $(".item_lbl_child_1 .add_search select").change(function(index) {
                //   if ($(this).val() === "") {
                //     $(this).addClass("inp_null");
                //     $(this).parents(".add_col").find(".alert").addClass("show");
                //     event.preventDefault();
                //     console.log("sec22");
                //   } else {
                //     $(this).removeClass("inp_null");
                //     $(this).parents(".add_col").find(".alert").removeClass("show");
                //     //console.log("dell11");
                //     return true;
                //   }

                //   $(this).keyup(function() {
                //     if ($(this).val() === "") {
                //       $(this).addClass("inp_null");
                //     } else {
                //       $(this).removeClass("inp_null");
                //       $(this).parents(".add_col").find(".alert").removeClass("show");
                //     }
                //   });
                // });

                $(".item_lbl_child_1 .add_inp_number.static input").each(function(index) {
                    if ($(this).val() === "") {
                        $(this).addClass("inp_null");
                        $(this).parents(".add_col").find(".alert").addClass("show");
                        event.preventDefault();
                        item_radio_control();
                    } else {
                        $(this).removeClass("inp_null");
                        $(this).parents(".add_col").find(".alert").removeClass("show");
                        item_1_1();
                        item_radio_control();
                    }
                    $(this).keyup(function() {
                        if ($(this).val() === "") {
                            $(this).addClass("inp_null");
                        } else {
                            $(this).removeClass("inp_null");
                            $(this).parents(".add_col").find(".alert").removeClass("show");
                        }
                    });
                });
                // function select_valid() {

                $(".item_lbl_child_1 .valid_slct_1").each(function(index) {
                    // console.log($(this).val());
                    if ($(this).val() === null || $(this).val() === "") {
                        // console.log("bossdurr");
                        $(this).siblings(".select2").find(".selection").addClass("inp_null");
                        event.preventDefault();
                    }
                    else {
                        console.log("doludur");
                        $(this).siblings(".select2").find(".selection").removeClass("inp_null");
                        return true;
                        // return true;
                        // $(this).removeClass("inp_null");
                    }

                });
                $(".item_lbl_child_1 .valid_slct_1").on("change", function() {
                    $('.clear_inp_val').addClass("active");
                    console.log($(this).val());
                    if ($(this).val() === "" || $(this).val() === null) {
                        $(this).siblings(".select2").children(".selection").addClass("inp_null");
                        event.preventDefault();
                    } else {
                        $(this).siblings(".select2").children(".selection").removeClass("inp_null");
                    }
                });

                // }
                // select_valid();


                function item_1_1() {

                    $(".item_lbl_child_1 .add_inp_number.change input").each(function(index) {
                        if ($(this).parents(".room_input_element.show").find("input").val() == "") {
                            $(this).addClass("inp_null");
                            $(this).parents(".add_col").find(".alert").addClass("show");
                            event.preventDefault();
                        } else {
                            $(this).removeClass("inp_null");
                            $(this).parents(".add_col").find(".alert").removeClass("show");
                            return true;
                        }
                        $(this).keyup(function() {
                            if ($(this).val() === "") {
                                $(this).addClass("inp_null");
                            } else {
                                $(this).removeClass("inp_null");
                                $(this).parents(".add_col").find(".alert").removeClass("show");
                            }
                        });
                    });
                }

                function item_radio_control() {
                    $(".item_lbl_child_1 .add_check_items.static.ck_build_type input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                    $(".item_lbl_child_1 .add_check_items.static.ck_parking_type input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                    $(".item_lbl_child_1 .add_check_items.static.ck_lift_type input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                    $(".item_lbl_child_1 .add_check_items.static.ck_build_sanitary input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                    $(".item_lbl_child_1 .add_check_items.static.ck_build_balcony input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                    $(".item_lbl_child_1 .add_check_items.static.ck_build_quality input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                    $(".item_lbl_child_1 .add_check_items.static.ck_build_window_view input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                    $(".item_lbl_child_1 .add_check_items.static.ck_build_bill_of_sale input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                }

            }
            function item_2(){
                $(".item_lbl_child_2 .add_search input").each(function(index) {
                    if ($(this).val() === "") {
                        $(this).addClass("inp_null");
                        $(this).parents(".add_col").find(".alert").addClass("show");
                        event.preventDefault();
                    } else {
                        $(this).removeClass("inp_null");
                        //return true;
                    }
                    $(this).keyup(function() {
                        if ($(this).val() === "") {
                            $(this).addClass("inp_null");
                        } else {
                            $(this).removeClass("inp_null");
                        }
                    });
                });
                $(".item_lbl_child_2 .add_inp_number.static input").each(function(index) {
                    if ($(this).val() === "") {
                        $(this).addClass("inp_null");
                        $(this).parents(".add_col").find(".alert").addClass("show");
                        event.preventDefault();
                        item_radio_control();
                    } else {
                        $(this).removeClass("inp_null");
                        $(this).parents(".add_col").find(".alert").removeClass("show");
                        item_1_1();
                        item_radio_control();
                    }
                    $(this).keyup(function() {
                        if ($(this).val() === "") {
                            $(this).addClass("inp_null");
                        } else {
                            $(this).removeClass("inp_null");
                            $(this).parents(".add_col").find(".alert").removeClass("show");
                        }
                    });
                });
                function item_1_1() {
                    $(".item_lbl_child_2 .add_inp_number.change input").each(function(index) {
                        if ($(this).parents(".room_input_element.show").find("input").val() == "") {
                            $(this).addClass("inp_null");
                            $(this).parents(".add_col").find(".alert").addClass("show");
                            event.preventDefault();
                        } else {
                            $(this).removeClass("inp_null");
                            $(this).parents(".add_col").find(".alert").removeClass("show");
                            return true;
                        }
                        $(this).keyup(function() {
                            if ($(this).val() === "") {
                                $(this).addClass("inp_null");
                            } else {
                                $(this).removeClass("inp_null");
                                $(this).parents(".add_col").find(".alert").removeClass("show");
                            }
                        });
                    });
                }

                function item_radio_control() {
                    $(".item_lbl_child_2 .add_check_items.static.ck_parking_type input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                    $(".item_lbl_child_2 .add_check_items.static.ck_build_sanitary input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                    $(".item_lbl_child_2 .add_check_items.static.ck_build_balcony input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                    $(".item_lbl_child_2 .add_check_items.static.ck_build_quality input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                    $(".item_lbl_child_2 .add_check_items.static.ck_build_window_view input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                    $(".item_lbl_child_2 .add_check_items.static.ck_build_bill_of_sale input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                    $(".item_lbl_child_2 .add_check_items.static.ck_build_material input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                }

            }
            function item_3(){
                $(".item_lbl_child_3 .add_search input").each(function(index) {
                    if ($(this).val() === "") {
                        $(this).addClass("inp_null");
                        $(this).parents(".add_col").find(".alert").addClass("show");
                        event.preventDefault();
                    } else {
                        $(this).removeClass("inp_null");
                        $(this).parents(".add_col").find(".alert").removeClass("show");
                    }
                    $(this).keyup(function() {
                        if ($(this).val() === "") {
                            $(this).addClass("inp_null");
                        } else {
                            $(this).removeClass("inp_null");
                            $(this).parents(".add_col").find(".alert").removeClass("show");
                        }
                    });
                });
                $(".item_lbl_child_3 .add_inp_number input").each(function(index) {
                    if ($(this).val() === "") {
                        $(this).addClass("inp_null");
                        $(this).parents(".add_col").find(".alert").addClass("show");
                        event.preventDefault();
                        item_radio_control();
                    } else {
                        $(this).removeClass("inp_null");
                        item_radio_control();
                    }
                    $(this).keyup(function() {
                        if ($(this).val() === "") {
                            $(this).addClass("inp_null");
                            event.preventDefault();
                        } else {
                            $(this).removeClass("inp_null");
                        }
                    });
                });

                function item_radio_control() {
                    $(".item_lbl_child_3 .add_check_items.static.ck_home_field_type input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                }

            }
            function item_4(){
                $(".item_lbl_child_4 .add_search input").each(function(index) {
                    if ($(this).val() === "") {
                        $(this).addClass("inp_null");
                        $(this).parents(".add_col").find(".alert").addClass("show");
                        event.preventDefault();
                    } else {
                        $(this).removeClass("inp_null");
                        $(this).parents(".add_col").find(".alert").removeClass("show");
                    }
                    $(this).keyup(function() {
                        if ($(this).val() === "") {
                            $(this).addClass("inp_null");
                        } else {
                            $(this).removeClass("inp_null");
                            $(this).parents(".add_col").find(".alert").removeClass("show");
                        }
                    });
                });
                $(".item_lbl_child_4 .add_inp_number input").each(function(index) {
                    if ($(this).val() === "") {
                        $(this).addClass("inp_null");
                        $(this).parents(".add_col").find(".alert").addClass("show");
                        event.preventDefault();
                        item_radio_control();
                    } else {
                        $(this).removeClass("inp_null");
                        $(this).parents(".add_col").find(".alert").removeClass("show");
                        item_radio_control();
                    }
                    $(this).keyup(function() {
                        if ($(this).val() === "") {
                            $(this).addClass("inp_null");
                            event.preventDefault();
                        } else {
                            $(this).removeClass("inp_null");
                            $(this).parents(".add_col").find(".alert").removeClass("show");
                        }
                    });
                });

                function item_radio_control() {
                    $(".item_lbl_child_4 .add_check_items.static.ck_home_garage_type input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                    $(".item_lbl_child_4 .add_check_items.static.ck_build_material input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                    $(".item_lbl_child_4 .add_check_items.static.ck_build_garage_status input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                }


            }
            function item_5(){
                $(".item_lbl_child_5 .add_search input").each(function(index) {
                    if ($(this).val() === "") {
                        $(this).addClass("inp_null");
                        $(this).parents(".add_col").find(".alert").addClass("show");
                        event.preventDefault();
                    } else {
                        $(this).removeClass("inp_null");
                        $(this).parents(".add_col").find(".alert").removeClass("show");
                    }
                    $(this).keyup(function() {
                        if ($(this).val() === "") {
                            $(this).addClass("inp_null");
                            event.preventDefault();
                        } else {
                            $(this).removeClass("inp_null");
                            $(this).parents(".add_col").find(".alert").removeClass("show");
                        }
                    });
                });
                $(".item_lbl_child_5 .add_inp_number input").each(function(index) {
                    if ($(this).val() === "") {
                        $(this).addClass("inp_null");
                        $(this).parents(".add_col").find(".alert").addClass("show");
                        event.preventDefault();
                        item_radio_control();
                    } else {
                        $(this).removeClass("inp_null");
                        $(this).parents(".add_col").find(".alert").removeClass("show");
                        item_radio_control();
                    }
                    $(this).keyup(function() {
                        if ($(this).val() === "") {
                            $(this).addClass("inp_null");
                            event.preventDefault();
                        } else {
                            $(this).removeClass("inp_null");
                            $(this).parents(".add_col").find(".alert").removeClass("show");
                        }
                    });
                });

                function item_radio_control() {
                    $(".item_lbl_child_5 .add_check_items.static.ck_build_quality input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                    $(".item_lbl_child_5 .add_check_items.static.ck_build_exit input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                }

            }
            function item_6(){
                $(".item_lbl_child_6 .add_search input").each(function(index) {
                    if ($(this).val() === "") {
                        $(this).addClass("inp_null");
                        $(this).parents(".add_col").find(".alert").addClass("show");
                        event.preventDefault();
                    } else {
                        $(this).removeClass("inp_null");
                        $(this).parents(".add_col").find(".alert").removeClass("show");
                    }
                    $(this).keyup(function() {
                        if ($(this).val() === "") {
                            $(this).addClass("inp_null");
                            event.preventDefault();
                        } else {
                            $(this).removeClass("inp_null");
                            $(this).parents(".add_col").find(".alert").removeClass("show");
                        }
                    });
                });
                $(".item_lbl_child_6 .add_inp_number input").each(function(index) {
                    if ($(this).val() === "") {
                        $(this).addClass("inp_null");
                        $(this).parents(".add_col").find(".alert").addClass("show");
                        event.preventDefault();
                    } else {
                        $(this).removeClass("inp_null");
                        $(this).parents(".add_col").find(".alert").removeClass("show");
                        item_radio_control();
                    }
                    $(this).keyup(function() {
                        if ($(this).val() === "") {
                            $(this).addClass("inp_null");
                            event.preventDefault();
                        } else {
                            $(this).removeClass("inp_null");
                            $(this).parents(".add_col").find(".alert").removeClass("show");
                        }
                    });
                });

                function item_radio_control() {
                    $(".item_lbl_child_6 .add_check_items.static.ck_build_quality input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                    $(".item_lbl_child_6 .add_check_items.static.ck_build_exit input").each(function(index) {
                        let elem_this = $(this);
                        items_checked(elem_this);
                    });
                }

            }

            // Input replace value
            $(".rpl_input_val").keyup(function(){
                let val = $(this).val();
                val = val.replace(".", "");

                let newVal = "";
                let first = 0;
                if(val.length != 0){
                    first = val[0];
                }
                for(let i=0; i< val.length; i++) {
                    if(i != 0){
                        newVal += val[i];
                    }
                }
                if(val.length > 1) {
                    $(".rpl_input_val").val(first+"."+newVal)
                }
                else{
                    $(".rpl_input_val").val(val)
                }
            });
</script>

@endsection

