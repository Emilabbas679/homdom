<?php $aForms = $this->_aVars['aForms'] ?>

@section('css')
<link rel="stylesheet" href="/theme/frontend/homdom/style/css/reset.css">
<link rel="stylesheet" href="/theme/frontend/homdom/style/css/select2.min.css"/>
<link rel="stylesheet" href="/theme/frontend/homdom/style/css/style.css?v8">
<script src="/theme/frontend/homdom/style/js/jquery-3.4.1.min.js"></script>
<script src="/theme/frontend/homdom/style/js/select2.min.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

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
        <div class="a-block-head">{{phrase var='homdom.mass'}}</div>
        <div class="a-block-body">
            <div class="form form-horizontal result">
                <?php if (isset($aForms['id'])){$id = $aForms['id'];} else {$id = 0;} ?>
                <form action="{{ url link='location.locality.mass' }}" method="POST"  enctype="multipart/form-data">


                    {{error}}


                    <div class="resident_complex_container">
                        <?php foreach ($aForms['ids'] as $id){ ?>
                            <input type="hidden" name="val[ids][]" value="<?=$id?>">
                        <?php } ?>


                        <div class="add_col col_1" id="locality_block">
                            <div class="add_col col_3">
                                <div class="add_litle_title">{{phrase var='homdom.district'}} </div>
                            </div>
                            <div class="add_col col_5">
                                <div class="custom_select2">
                                    <?php $aRows = AIN::getService('homdom.core')->homdom_get_district(['status_id' => 11, 'limit' => 100]); ?>
                                    <select class="form-control select_2_autocomplete" name="val[district_id]" id="districts">
                                        <?php foreach ($aRows['data']['rows'] as $item) { ?>
                                            <option value="<?=$item['id']?>"><?=AIN::getPhrase('homdom.'.$item['phrase'])?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>





                        <div class="add_row add_form_finish">
                            <div class="add_col col_1">
                                <button type="submit" class="prof_inf_submit">{{phrase var='homdom.mass'}} </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.6.15/browser-polyfill.min.js"></script>
<script src="/theme/frontend/homdom/style/js/datepicker.min.js"></script>
<script src="/theme/frontend/homdom/style/js/jquery.inputmask.min.js"></script>
<script src="/theme/frontend/homdom/style/js/select.js"></script>

<script>
    $('#districts').select2()
</script>


@endsection

