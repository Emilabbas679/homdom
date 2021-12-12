<?php $aForms = $this->_aVars['aForms'] ?>
<link rel="stylesheet" href="/theme/frontend/homdom/style/css/reset.css">
<link rel="stylesheet" href="/theme/frontend/homdom/style/css/googlemap.css">
<link rel="stylesheet" href="/theme/frontend/homdom/style/css/select2.min.css"/>
<link rel="stylesheet" href="/theme/frontend/homdom/style/css/style.css?v8">

<script src="/theme/frontend/homdom/style/js/jquery-3.4.1.min.js"></script>
<script src="/theme/frontend/homdom/style/js/select2.min.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

@section('js')

<style>
  .filepond--drop-label {color: #4c4e53;}
  .filepond--label-action {text-decoration-color: #babdc0;}
  .filepond--panel-root {border-radius: 2em;background-color: #edf0f4;height: 1em;}
  .filepond--item-panel {background-color: #595e68;}
  .filepond--drip-blob {background-color: #7f8a9a;}
</style>

@endsection

<div class="content-inner">
    <div class="breadcrumb">
        <ul>
            <li><a href="{{url link='dashboard.index'}}">Homdom</a></li>
            <li><a href="{{url link='offers.index'}}">{{phrase var='homdom.offers'}}</a></li>
            <li><span>
                    <?php
                    if (AIN::getService('homdom.helpers')->checkActiveRoute('offers/edit') == 'active') {
                        echo AIN::getPhrase('homdom.edit');
                    }
                    else{
                        echo AIN::getPhrase('homdom.add');
                    }
                    ?>
                </span>
            </li>
        </ul>
    </div>
    <div class="a-block a-center">
        <div class="a-block-head">
            <?php
            if (AIN::getService('homdom.helpers')->checkActiveRoute('offers/edit') == 'active') {
                echo AIN::getPhrase('homdom.edit');
            }
            else{
                echo AIN::getPhrase('homdom.add');
            }
            ?>
        </div>
        <div class="a-block-body">
            <div class="form form-horizontal result">
                {{error}}
                <form action="{{url link='offers.add' id=$aForms.id}}" method="POST" id="apanel_agency_add" class="add_anc_form" enctype="multipart/form-data">

                    <div class="section_headers">

                      <div class="add_row">
                        <div class="add_col col_4">
                          <div class="report_date_input">
                              <?php $validity = AIN::getService('homdom.helpers')->getValueOfInput($aForms , 'validity_date');
                                    if ($validity != null){
                                        $validity = explode(' ', $validity);
                                        $validity = explode('-', $validity[0]);
                                        $validity = $validity[2].'.'.$validity[1].'.'.$validity[0];
                                    }
                              ?>
                            <input type="text" data-toggle="datepicker" name="val[validity_date]" value="<?=$validity?>" placeholder="">
                          </div>
                        </div>
                        <div class="add_col col_2">
                          <div class="custom_select">
                            <select name="val[status_id]" id="" class="select-regist">
                              <option value="11" <?= AIN::getService('homdom.helpers')->selected_exist($aForms , 'status_id', 11)?>>{{ phrase var='homdom.status_id_11'}}</option>
                              <option value="12" <?= AIN::getService('homdom.helpers')->selected_exist($aForms , 'status_id', 12)?>>{{ phrase var='homdom.status_id_12'}}</option>
                              <option value="9" <?= AIN::getService('homdom.helpers')->selected_exist($aForms , 'status_id', 9)?>>{{ phrase var='homdom.status_id_9'}}</option>
                              <option value="10" <?= AIN::getService('homdom.helpers')->selected_exist($aForms , 'status_id', 10)?>>{{ phrase var='homdom.status_id_10'}}</option>

                            </select>
                          </div>
                        </div>
                        
                      </div>
                      <div class="add_row">
                        <div class="add_col col_2 home_check_buy_sell">
                          <label class="label_item radio_btn">
                            <input type="radio" name="val[offer_type]" value='sale' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms, 'offer_type', '1')?>>
                            <div class="check_item itm_catg ch_hm_validate">
                              <span class="itm_name">{{ phrase var="homdom.offer_type_sell" }}</span>
                              <span class="itm_tik"></span>
                            </div>
                          </label>
                        </div>
                        <div class="add_col col_2 home_check_buy_sell" >
                          <label class="label_item radio_btn">
                            <input type="radio" name="val[offer_type]" value='rent' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms, 'offer_type', '2')?>>
                            <div class="check_item itm_catg ch_hm_validate">
                              <span class="itm_name">{{ phrase var="homdom.offer_type_rent" }}</span>
                              <span class="itm_tik"></span>
                            </div>
                          </label>
                        </div>
                        <div class="add_col col_2"></div>
                      </div>
                    </div>
                    <div class="resident_complex_container">

                      <div class="wrap_body">

                        <div class="add_row">
                          <div class="add_head">{{ phrase var="homdom.offer_property_type" }}</div>
                          <div class="add_col col_1">
                            <?php for ($i =1;$i <= 6;$i++) { ?>
                                <div class="add_col col_4">
                                  <label class="label_item check_btn item_lbl_<?=$i?>">
                                    <input type="radio" name="val[property_type_id]" value="<?=$i?>" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms, 'property_type_id', $i)?>  >
                                    <div class="check_item itm_type">
                                      <span class="itm_name"><?=AIN::getPhrase('homdom.offer_property_type_id_'.$i)?> </span>
                                      <span class="itm_tik"></span>
                                    </div>
                                  </label>
                                </div>
                            <?php } ?>
                          </div>
                        </div>


                        <div class="add_row">
                          <div class="add_head item_lbl_child_1">{{ phrase var="homdom.about_building" }}</div>
                          <div class="add_head item_lbl_child_2">{{ phrase var="homdom.about_home" }} </div>
                          <div class="add_head item_lbl_child_3">{{ phrase var="homdom.about_land" }} </div>
                          <div class="add_head item_lbl_child_4">{{ phrase var="homdom.about_garrage" }}</div>
                          <div class="add_head item_lbl_child_5">{{ phrase var="homdom.about_office" }}</div>
                          <div class="add_head item_lbl_child_6">{{ phrase var="homdom.about_object" }}</div>
                          <!-- this item_1 elements -->
                          <div class="add_col col_1 item_lbl_child_1">
                            <div class="add_col col_3">
                                <div class="add_litle_title ">{{ phrase var="homdom.building_type" }}</div>
                                <!-- <div class="add_litle_title ">Evin növü</div> -->
                            </div>

                            <div class="add_col col_5">
                              <div class="add_check_items static ck_build_type">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][building_type]" value='1' id="building_type_1" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'building_type', 1)?>>
                                  <span>{{ phrase var="homdom.building_type_1" }} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_type">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][building_type]" value='0' id="building_type_0" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'building_type', 0)?>>
                                  <span>{{ phrase var="homdom.building_type_0" }} </span>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1 item_lbl_child_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var="homdom.name" }}  </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_search">
                                  <div class="custom_select2">
                                  <span class="clear_inp_val"></span>
                                      <select class="form-control select_2_autocomplete valid_slct_1" id="buildings" name="val[type_1][building_id]">
                                          <?php if (isset($aForms['building_id']) and $aForms['building_id'] > 0 and isset($aForms['b_name'])) { ?>
                                              <option value="<?=$aForms['building_id'] ?>"><?=$aForms['b_name']?></option>
                                          <?php }
                                          elseif(isset($aForms['building_name']) and $aForms['building_name'] != null) { ?>
                                              <option value="<?=$aForms['building_name']?>"><?=$aForms['building_name']?></option>
                                          <?php } ?>
                                    </select>
                                    <div class="alert alert-danger alert-block">
                                      <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                      <span>{{ phrase var='homdom.enter' }}</span>
                                    </div>

                                  </div>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1 item_lbl_child_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var="homdom.built_year" }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_inp_number static">
                                <input type="text" min="1" name="val[type_1][built_year]" id="built_year" value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_1'], 'built_year')?>" class="built_year integer_num" placeholder="" maxlength="4">
                                <span class="clear_inp_val"></span>
                                <div class="alert alert-danger alert-block">
                                  <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                  <span>{{ phrase var='homdom.enter' }}</span>
                                </div>
                              </div>
                              <label class="add_inp_check_static">
                                <input type="checkbox" name="val[type_1][delivery_type]" id="delivery_type" value="0" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'delivery_type', 0)?> class="delivery_type" placeholder="">
                                <span>{{ phrase var='homdom.not_delivery' }}</span>
                              </label>
                            </div>
                          </div>
                          <div class="add_col col_1 item_lbl_child_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.ceiling_height' }}</div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_inp_number static">
                                <input type="text" min="1" name="val[type_1][ceiling_height]" id="ceiling_height" class="ceiling_height decimal rpl_input_val" value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_1'], 'ceiling_height')?>" placeholder="" maxlength="5">
                                <span class="clear_inp_val"></span>
                                <div class="alert alert-danger alert-block">
                                  <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                  <span>{{ phrase var='homdom.enter' }}</span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1 item_lbl_child_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title"> {{ phrase var="homdom.parking_type" }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static ck_parking_type">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][parking]" id="parking" value='0' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'parking', 0)?>>
                                  <span> {{ phrase var="homdom.no" }} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_parking_type">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][parking]" value="1" id="parking_1" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'parking', 1)?>>
                                  <span>{{ phrase var="homdom.close" }}  </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_parking_type">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][parking]" id="parking_2" value="2" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'parking', 2)?>>
                                  <span>{{ phrase var="homdom.underground" }}  </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_parking_type">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][parking]" id="parking_3"  value="3" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'parking', 3)?>>
                                  <span>{{ phrase var="homdom.open" }} </span>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1 item_lbl_child_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.lift' }}</div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static">
                                <label class="add_inp_check_static check_lift">
                                  <input type="checkbox" name="val[type_1][lift][]"  value="1" placeholder="" <?= AIN::getService('homdom.helpers')->checkedIfInArray($aForms['type_1'], 'lift', 1)?>>
                                  <span>{{ phrase var='homdom.lift_1' }}</span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_lift_type check_lift_same">
                                <label class="add_check">
                                  <input type="checkbox" name="val[type_1][lift][]" id="2" value="2" <?= AIN::getService('homdom.helpers')->checkedIfInArray($aForms['type_1'], 'lift', 2)?>>
                                  <span>{{ phrase var='homdom.passenger_lift' }}</span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_lift_type check_lift_same">
                                <label class="add_check">
                                  <input type="checkbox" name="val[type_1][lift][]"   value='3' <?= AIN::getService('homdom.helpers')->checkedIfInArray($aForms['type_1'], 'lift', 3)?>>
                                  <span>{{ phrase var='homdom.freight_lift' }} </span>
                                </label>
                              </div>
                            </div>
                          </div>
                          <!-- this item_1 elements -->

                          <!-- this item_2 elements -->
                          <div class="add_col col_1 item_lbl_child_2">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.built_year' }}</div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_inp_number static">
                                  <input type="text" min="1" name="val[type_2][built_year]" value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_2'], 'built_year')?>" class="built_year integer_num" placeholder="" maxlength="4">
                                  <span class="clear_inp_val"></span>
                              </div>
                              <!-- <label class="add_inp_check_static">
                                <input type="checkbox"   value="" placeholder="">
                                <span>Təhvil verilməyib</span>
                              </label> -->
                            </div>
                          </div>
                          <div class="add_col col_1 item_lbl_child_2">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.ceiling_height' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_inp_number static">
                                  <input type="text" min="1" name="val[type_2][ceiling_height]" class="ceiling_height decimal rpl_input_val" value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_2'], 'ceiling_height')?>" placeholder="" maxlength="5>
                                  <span class="clear_inp_val"></span>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1 item_lbl_child_2">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.material'}} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static ck_build_material">
                                <label class="add_check">
                                  <input type="radio"  name="val[type_2][material]"   value='1' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'material', 1)?>>
                                  <span>{{ phrase var='homdom.material_1'}} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_material">
                                <label class="add_check">
                                  <input type="radio"  name="val[type_2][material]"   value='2' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'material', 2)?> >
                                  <span>{{ phrase var='homdom.material_2'}}  </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_material">
                                <label class="add_check">
                                  <input type="radio" name="val[type_2][material]"   value='3' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'material', 3)?>>
                                  <span>{{ phrase var='homdom.material_3'}}  </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_material">
                                <label class="add_check">
                                  <input type="radio"  name="val[type_2][material]"   value='4' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'material', 4)?>>
                                  <span>{{ phrase var='homdom.material_4'}}  </span>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1 item_lbl_child_2">
                            <div class="add_col col_3">
                              <div class="add_litle_title"> {{ phrase var='homdom.parking_type' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static ck_parking_type">
                                <label class="add_check">
                                  <input type="radio" name="val[type_2][parking]" value='0' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'parking', 0)?> >
                                  <span>{{ phrase var="homdom.no" }} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_parking_type">
                                <label class="add_check">
                                  <input type="radio" name="val[type_2][parking]" value='1' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'parking', 1)?> >
                                  <span>{{ phrase var="homdom.close" }} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_parking_type">
                                <label class="add_check">
                                  <input type="radio" name="val[type_2][parking]" value='2' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'parking', 2)?>>
                                  <span>{{ phrase var="homdom.underground" }} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_parking_type">
                                <label class="add_check">
                                  <input type="radio" name="val[type_2][parking]" value='3' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'parking', 3)?>  >
                                  <span>{{ phrase var="homdom.open" }} </span>
                                </label>
                              </div>
                            </div>
                          </div>
                          <!-- this item_2 elements -->
                          
                          <!-- this item_3 elements -->
                          <div class="add_col col_1 item_lbl_child_3">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.area' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_inp_number">
                                  <input type="text" min="1" name="val[type_3][area][all]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_3']['area'], 'all')?>" placeholder="" class="decimal" maxlength="4">
                                  <span class="clear_inp_val"></span>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1 item_lbl_child_3">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{phrase var='homdom.field_type'}}</div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static ck_home_field_type">
                                <label class="add_check">
                                  <input type="radio" name="val[type_3][field_type]" value='1' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_3'], 'field_type', 1)?> >
                                  <span>{{phrase var='homdom.field_type_1'}} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_home_field_type">
                                <label class="add_check">
                                  <input type="radio" name="val[type_3][field_type]" value='2' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_3'], 'field_type', 2)?> >
                                  <span>{{phrase var='homdom.field_type_2'}} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_home_field_type">
                                <label class="add_check">
                                  <input type="radio" name="val[type_3][field_type]" value='3' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_3'], 'field_type', 3)?>>
                                  <span>{{phrase var='homdom.field_type_3'}} </span>
                                </label>
                              </div>
                            </div>
                          </div>
                          <!-- this item_3 elements -->


                          <!-- this item_4 elements -->
                          <div class="add_col col_1 item_lbl_child_4">
                            <div class="add_col col_3">
                              <div class="add_litle_title"> {{ phrase var='homdom.garage_type' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static ck_home_garage_type">
                                <label class="add_check">
                                  <input type="radio" name="val[type_4][garage_type]" value='1' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_4'], 'garage_type', 1)?>  >
                                  <span>{{ phrase var='homdom.garage_type_1' }} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_home_garage_type">
                                <label class="add_check">
                                  <input type="radio" name="val[type_4][garage_type]" value='2' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_4'], 'garage_type', 2)?> >
                                  <span>{{ phrase var='homdom.garage_type_2' }} </span>
                                </label>
                              </div>

                              <div class="add_check_items static ck_home_garage_type">
                                <label class="add_check">
                                  <input type="radio" name="val[type_4][garage_type]" value='3' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_4'], 'garage_type', 3)?>  >
                                  <span>{{ phrase var='homdom.garage_type_3' }}</span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>seç</span>
                                  </div>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1 item_lbl_child_4">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.material'}} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static ck_build_material">
                                <label class="add_check">
                                  <input type="radio" name="val[type_4][material]"   value='1' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_4'], 'material', 1)?>  >
                                  <span>{{phrase var='homdom.material_1'}} </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>seç</span>
                                  </div>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_material">
                                <label class="add_check">
                                  <input type="radio" name="val[type_4][material]"   value='5' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_4'], 'material', 5)?>  >
                                  <span>{{phrase var='homdom.material_5'}} </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>seç</span>
                                  </div>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_material">
                                <label class="add_check">
                                  <input type="radio" name="val[type_4][material]"   value='6' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_4'], 'material', 6)?>  >
                                  <span>{{phrase var='homdom.material_6'}}  </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>seç</span>
                                  </div>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1 item_lbl_child_4">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{phrase var='homdom.garage_status'}} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static ck_build_garage_status">
                                <label class="add_check">
                                  <input type="radio" name="val[type_4][garage_status]"   value='1' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_4'], 'garage_status', 1)?> >
                                  <span>{{phrase var='homdom.garage_status_1'}}</span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>seç</span>
                                  </div>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_garage_status">
                                <label class="add_check">
                                  <input type="radio" name="val[type_4][garage_status]"   value='2' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_4'], 'garage_status', 2)?> >
                                  <span>{{phrase var='homdom.garage_status_2'}} </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>seç</span>
                                  </div>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_garage_status">
                                <label class="add_check">
                                  <input type="radio" name="val[type_4][garage_status]"   value='3' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_4'], 'garage_status', 3)?>  >
                                  <span>{{phrase var='homdom.garage_status_3'}}</span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>seç</span>
                                  </div>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1 item_lbl_child_4">
                            <div class="add_col col_3">
                              <div class="add_litle_title">Adı </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_search">
                                <span class="clear_inp_val"></span>
                                <input type="text" name="val[type_4][building_name]" id="building_name_4" value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_4'], 'building_name')?>" placeholder="">
                                <div class="alert alert-danger alert-block">
                                  <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                  <span>{{ phrase var='homdom.enter' }}</span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1 item_lbl_child_4">
                            <div class="add_col col_3">
                              <div class="add_litle_title"> {{ phrase var='homdom.area' }}  </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_inp_number">
                                <input type="text"  name="val[type_4][area]" id="area_4" value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_4'], 'area')?>" placeholder="" class="decimal" maxlength="6">
                                <span class="clear_inp_val"></span>
                                <div class="alert alert-danger alert-block">
                                  <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                  <span>{{ phrase var='homdom.enter' }}</span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- this item_4 elements -->


                          <!-- this item_5 elements -->
                          <div class="add_col col_1 item_lbl_child_5">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.exit' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static ck_build_exit">
                                <label class="add_check">
                                  <input type="radio" name="val[type_5][building_exit]"   value='1' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_5'], 'building_exit', 1)?>  >
                                  <span>{{phrase var='homdom.exit_1'}} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_exit">
                                <label class="add_check">
                                  <input type="radio" name="val[type_5][building_exit]"   value='2' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_5'], 'building_exit', 2)?> >
                                  <span>{{phrase var='homdom.exit_2'}} </span>
                                </label>
                              </div>
                            </div>
                          </div>

                          <div class="add_col col_1 item_lbl_child_5">
                            <div class="add_col col_3">
                              <div class="add_litle_title"> {{ phrase var='homdom.area' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_inp_number">
                                <input type="text"  name="val[type_5][area]" id="area_5" value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_5'], 'area')?>" class="decimal" maxlength="6">
                                <span class="clear_inp_val"></span>
                                <div class="alert alert-danger alert-block">
                                  <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                  <span>{{ phrase var='homdom.enter' }}</span>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="add_col col_1 item_lbl_child_5">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.room_count' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_inp_number">
                                <input type="text" name="val[type_5][room_count]" id="room_count_5" value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_5'], 'room_count')?>" class="integer_num" maxlength="3">
                                <span class="clear_inp_val"></span>
                                <div class="alert alert-danger alert-block">
                                  <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                  <span>{{ phrase var='homdom.enter' }}</span>
                                </div>
                              </div>
                            </div>
                          </div>


                          <div class="add_col col_1 item_lbl_child_5">
                              <div class="add_col col_3">
                                  <div class="add_litle_title">{{ phrase var='homdom.quality' }} </div>
                              </div>
                              <div class="add_col col_5">
                                  <div class="add_check_items static ck_build_quality">
                                      <label class="add_check">
                                          <input type="radio" name="val[type_5][quality]" value="0"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_5'], 'quality', 0)?>  >
                                          <span>{{ phrase var='homdom.quality_0' }} </span>
                                          <div class="alert alert-danger alert-block">
                                              <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                              <span>{{ phrase var='homdom.enter' }}</span>
                                          </div>
                                      </label>
                                  </div>
                                  <div class="add_check_items static ck_build_quality">
                                      <label class="add_check">
                                          <input type="radio" name="val[type_5][quality]" value="1"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_5'], 'quality', 1)?>  >
                                          <span>{{ phrase var='homdom.quality_1' }} </span>
                                          <div class="alert alert-danger alert-block">
                                              <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                              <span>{{ phrase var='homdom.enter' }}</span>
                                          </div>
                                      </label>
                                  </div>
                                  <div class="add_check_items static ck_build_quality">
                                      <label class="add_check">
                                          <input type="radio" name="val[type_5][quality]" value="2"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_5'], 'quality',2)?>  >
                                          <span>{{ phrase var='homdom.quality_2' }} </span>
                                          <div class="alert alert-danger alert-block">
                                              <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                              <span>{{ phrase var='homdom.enter' }}</span>
                                          </div>
                                      </label>
                                  </div>
                                  <div class="add_check_items static ck_build_quality">
                                      <label class="add_check">
                                          <input type="radio" name="val[type_5][quality]" value="3"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_5'], 'quality', 3)?> >
                                          <span>{{ phrase var='homdom.quality_3' }} </span>
                                          <div class="alert alert-danger alert-block">
                                              <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                              <span>{{ phrase var='homdom.enter' }}</span>
                                          </div>
                                      </label>
                                  </div>
                                  <div class="add_check_items static ck_build_quality">
                                      <label class="add_check">
                                          <input type="radio" name="val[type_5][quality]" value="4"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_5'], 'quality', 4)?>  >
                                          <span> {{ phrase var='homdom.quality_4' }} </span>
                                          <div class="alert alert-danger alert-block">
                                              <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                              <span>{{ phrase var='homdom.enter' }}</span>
                                          </div>
                                      </label>
                                  </div>
                              </div>
                          </div>
                          <!-- this item_5 elements -->
                            
                          <!-- this item_6 elements -->
                          <div class="add_col col_1 item_lbl_child_6">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{phrase var='homdom.commercial_type'}} </div>
                            </div>
                            <div class="add_col col_5">
                                <?php foreach ($this->_aVars['commercialTypes'] as $key=>$val) { ?>
                                    <div class="add_check_items">
                                        <label class="add_check">
                                            <input type="radio" type="checkbox" value="<?=$val['id']?>" name="val[type_6][commercial_type_id]" id="commercial-type-<?=$val['id']?>" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_6'], 'commercial_type_id', $val['id'])?> >
                                            <span><?=AIN::getPhrase('homdom.'.$val['phrase'])?>  </span>
                                        </label>
                                    </div>

                                <?php } ?>
                            </div>
                          </div>
                          <div class="add_col col_1 item_lbl_child_6">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{phrase var='homdom.entrance'}} </div>
                            </div>
                            <div class="add_col col_5">
                                <div class="add_check_items">
                                    <label class="add_check">
                                        <input type="radio" name="val[type_6][building_entrance]"   value='1' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_6'], 'building_entrance', 1)?>  >
                                        <span>{{phrase var='homdom.entrance_1'}} </span>
                                    </label>
                                </div>
                                <div class="add_check_items">
                                    <label class="add_check">
                                        <input type="radio" name="val[type_6][building_entrance]"   value='2' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_6'], 'building_entrance', 2)?> >
                                        <span>{{phrase var='homdom.entrance_2'}} </span>
                                    </label>
                                </div>
                            </div>
                          </div>
                          <div class="add_col col_1 item_lbl_child_6">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{phrase var='homdom.area'}}</div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_inp_number">
                                  <input type="text" name="val[type_6][area]" id="area_6" value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_6'], 'area')?>" class="decimal" maxlength="6">
                                  <span class="clear_inp_val"></span>
                                <div class="alert alert-danger alert-block">
                                  <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                  <span>{{ phrase var='homdom.enter' }}</span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- this item_6 elements -->

                          <!-- this are all items have -->
                          <div class="add_col col_1" style="display: none !important;">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.region' }}</div>
                            </div>
                            <div class="add_col col_5">
                              <div class="custom_select2">
                                <select class="form-control select_2_autocomplete" id="regions" name="val[region_id]">
                                    <?php if (isset($aForms['region_id']) and $aForms['region_id'] > 0 and isset($aForms['region_title'])) { ?>
                                        <option value="<?=$aForms['region_id'] ?>"><?=AIN::getPhrase('homdom.'.$aForms['region_title'])?></option>
                                    <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>

                          <div class="add_col col_1" id="city_block">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.city' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="custom_select2">
                                <select class="form-control select_2_autocomplete" name="val[district_id]" id="cities">
                                    <?php if (isset($aForms['district_id']) and $aForms['district_id'] > 0 and isset($aForms['district_title'])) { ?>
                                        <option value="<?=$aForms['district_id'] ?>"><?=AIN::getPhrase('homdom.'.$aForms['district_title'])?></option>
                                    <?php } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1" id="metro_block">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{phrase var='homdom.metro'}} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="custom_select2">
                                <select class="form-control select_2_autocomplete" name="val[metro_id]" id="metros">
                                    <?php if (isset($aForms['metro_id']) and $aForms['metro_id'] > 0 and isset($aForms['metro_title'])) { ?>
                                        <option value="<?=$aForms['metro_id'] ?>"><?=AIN::getPhrase('homdom.'.$aForms['metro_title'])?></option>
                                    <?php } ?>

                                </select>
                              </div>
                            </div>
                          </div>

                            <div class="add_col col_1" id="locality_block">
                                <div class="add_col col_3">
                                    <div class="add_litle_title">{{phrase var='homdom.locality'}} </div>
                                </div>
                                <div class="add_col col_5">
                                    <div class="custom_select2">
                                        <select class="form-control select_2_autocomplete" name="val[locality_id]" id="localities">
                                            <?php if (isset($aForms['locality_id']) and $aForms['locality_id'] > 0 and isset($aForms['locality_title'])) { ?>
                                                <option value="<?=$aForms['locality_id'] ?>"><?=AIN::getPhrase('homdom.'.$aForms['locality_title'])?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                </div>
                            </div>

                          <div class="add_col col_1">
                            <div class="add_col col_1">
                              <div class="add_col col_3">
                                <div class="add_litle_title">{{  phrase var='homdom.address' }} </div>
                              </div>
                              <div class="add_col col_5">
                                <div class="add_search">
                                  <input type="text" name="val[address_detail]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms, 'address_detail')?>" placeholder="{{ phrase var='homdom.address_detail' }}">
                                </div>
                              </div>
                            </div>
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


                        <div class="add_row item_lbl_child_1">
                          <div class="add_head"> {{ phrase var='homdom.about_apartment' }} </div>
                          <div class="add_col col_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.room_count' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items ">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][room_count]" value="1"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'room_count', 1)?>  class="room_count_change" >
                                  <span>1 </span>
                                </label>
                              </div>
                              <div class="add_check_items ">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][room_count]" value="2"  class="room_count_change" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'room_count', 2)?>>
                                  <span>2 </span>
                                </label>
                              </div>
                              <div class="add_check_items ">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][room_count]" value="3"  class="room_count_change" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'room_count', 3)?>>
                                  <span>3 </span>
                                </label>
                              </div>
                              <div class="add_check_items ">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][room_count]" value="4" class="room_count_change" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'room_count', 4)?>>
                                  <span>4 </span>
                                </label>
                              </div>
                              <div class="add_check_items ">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][room_count]" value="5"  class="room_count_change" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'room_count', 5)?>>
                                  <span>5 </span>
                                </label>
                              </div>
                              <div class="add_check_items ">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][room_count]" value="6"  class="room_count_change" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'room_count', 6)?>>
                                  <span>6 </span>
                                </label>
                              </div>
                              <div class="add_check_items ">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][room_count]" value="7"  class="room_count_change" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'room_count', 7)?>>
                                  <span>7+ </span>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title"> {{ phrase var='homdom.area' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="room_field">
                                <!-- <div class="room_static_field"> -->
                                  <div class="add_col col_7 ">
                                    <div class="add_inp_number static">
                                      <input type="text" min="1" name="val[type_1][area][all]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_1']['area'], 'all')?>" placeholder="" class="decimal " maxlength="5">
                                      <span class="clear_inp_val"></span>
                                    </div>
                                    <div class="rm_fld_name">{{ phrase var='homdom.all' }} </div>
                                  </div>
                                  <div class="add_col col_7">
                                    <div class="add_inp_number static">
                                      <input type="text" min="1" name="val[type_1][area][living]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_1']['area'], 'living')?>" placeholder="" class="decimal " maxlength="5">
                                      <span class="clear_inp_val"></span>
                                    </div>
                                    <div class="rm_fld_name">{{ phrase var='homdom.living' }} </div>
                                    <!-- <div class="alert alert-danger alert-block">
                                      <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                      <span>{{ phrase var='homdom.enter' }}</span>
                                    </div> -->
                                  </div>

                                <!-- </div> -->
                                <div class="room_change_field room_change_1">
                                  <div class="add_col col_7 room_input_element" data-input="1">
                                    <div class="add_inp_number change">
                                      <input type="text" name="val[type_1][area][room_1]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_1']['area'], 'room_1')?>" placeholder="" class="decimal " maxlength="5">
                                      <span class="clear_inp_val"></span>
                                    </div>
                                    <div class="rm_fld_name">{{ phrase var='homdom.room_1' }}</div>
                                  </div>
                                  <div class="add_col col_7 room_input_element" data-input="2">
                                    <div class="add_inp_number change">
                                      <input type="text" name="val[type_1][area][room_2]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_1']['area'], 'room_2')?>" placeholder="" class="decimal " maxlength="5">
                                      <span class="clear_inp_val"></span>
                                    </div>
                                    <div class="rm_fld_name">{{ phrase var='homdom.room_2' }}</div>
                                  </div>
                                  <div class="add_col col_7 room_input_element" data-input="3">
                                    <div class="add_inp_number change">
                                      <input type="text" name="val[type_1][area][room_3]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_1']['area'], 'room_3')?>" placeholder="" class="decimal " maxlength="5">
                                      <span class="clear_inp_val"></span>
                                    </div>
                                    <div class="rm_fld_name">{{ phrase var='homdom.room_3' }}</div>
                                  </div>
                                  <div class="add_col col_7 room_input_element" data-input="4">
                                    <div class="add_inp_number change">
                                      <input type="text" name="val[type_1][area][room_4]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_1']['area'], 'room_4')?>" placeholder="" class="decimal " maxlength="5">
                                      <span class="clear_inp_val"></span>
                                    </div>
                                    <div class="rm_fld_name">{{ phrase var='homdom.room_4' }}</div>
                                  </div>
                                  <div class="add_col col_7 room_input_element" data-input="5">
                                    <div class="add_inp_number change">
                                      <input type="text" name="val[type_1][area][room_5]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_1']['area'], 'room_5')?>" placeholder="" class="decimal " maxlength="5">
                                      <span class="clear_inp_val"></span>
                                    </div>
                                    <div class="rm_fld_name">{{ phrase var='homdom.room_5' }}</div>
                                  </div>
                                  <div class="add_col col_7 room_input_element" data-input="6">
                                    <div class="add_inp_number change">
                                      <input type="text" name="val[type_1][area][room_6]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_1']['area'], 'room_6')?>" placeholder="" class="decimal " maxlength="5">
                                      <span class="clear_inp_val"></span>
                                    </div>
                                    <div class="rm_fld_name">{{ phrase var='homdom.room_6' }}</div>
                                  </div>
                                  <div class="add_col col_7 room_input_element" data-input="7">
                                    <div class="add_inp_number change">
                                      <input type="text" name="val[type_1][area][room_7]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_1']['area'], 'room_7')?>" placeholder="" class="decimal " maxlength="5">
                                      <span class="clear_inp_val"></span>
                                    </div>
                                    <div class="rm_fld_name">{{ phrase var='homdom.room_7' }}</div>
                                  </div>
                                </div>
                                <div class="add_col col_7 ">
                                  <div class="add_inp_number static">
                                    <input type="text" min="1" name="val[type_1][area][kitchen]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_1']['area'], 'kitchen')?>" placeholder="" class="decimal " maxlength="5">
                                    <span class="clear_inp_val"></span>
                                  </div>
                                  <div class="rm_fld_name">{{ phrase var='homdom.kitchen' }}</div>
                                  <!-- <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>{{ phrase var='homdom.enter' }}</span>
                                  </div> -->
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="add_col col_1 ">
                            <div class="add_col col_3">
                              <div class="add_litle_title"> {{ phrase var='homdom.floors_total' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_inp_number static">
                                <input type="text" min="1" name="val[floors_total]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms, 'floors_total')?>" placeholder="" class="integer_num floors_total" maxlength="3">
                                <span class="clear_inp_val"></span>
                                <div class="alert alert-danger alert-block">
                                  <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                  <span>{{ phrase var='homdom.enter' }}</span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1 ">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.flat_floor' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_inp_number static">
                                <input type="text" min="1" name="val[flat_floor]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms, 'flat_floor')?>" placeholder="" class="integer_num" maxlength="3">
                                <span class="clear_inp_val"></span>
                                <div class="alert alert-danger alert-block">
                                  <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                  <span>{{ phrase var='homdom.enter' }}</span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title"> {{ phrase var='homdom.sanitary' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static ck_build_sanitary">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][sanitary]"  value="1" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'sanitary', 1)?>>
                                  <span>{{ phrase var='homdom.together' }} </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>{{ phrase var='homdom.enter' }}</span>
                                  </div>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_sanitary">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][sanitary]"  value="2" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'sanitary', 2)?>>
                                  <span>{{ phrase var='homdom.seperate' }} </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>{{ phrase var='homdom.enter' }}</span>
                                  </div>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_sanitary">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][sanitary]"  value="3"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'sanitary', 3)?>>
                                  <span>{{ phrase var='homdom.more_1' }} </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>{{ phrase var='homdom.enter' }}</span>
                                  </div>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1 ">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.balcony' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static ck_build_balcony">
                                <label class="add_check">
                                  <input type="radio" name="val[balcony]" value="0"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms, 'balcony', 0)?>>
                                  <span> {{ phrase var='homdom.no' }} </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>{{ phrase var='homdom.enter' }}</span>
                                  </div>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_balcony">
                                <label class="add_check">
                                  <input type="radio"name="val[balcony]" value="1"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms, 'balcony', 1)?>>
                                  <span>{{ phrase var='homdom.yes' }} </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>{{ phrase var='homdom.enter' }}</span>
                                  </div>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_balcony">
                                <label class="add_check">
                                  <input type="radio" name="val[balcony]" value="2"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms, 'balcony', 2)?> >
                                  <span>{{ phrase var='homdom.more_2' }} </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>{{ phrase var='homdom.enter' }}</span>
                                  </div>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.quality' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static ck_build_quality">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][quality]" value="0"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'quality', 0)?>  >
                                  <span>{{ phrase var='homdom.quality_0' }} </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>{{ phrase var='homdom.enter' }}</span>
                                  </div>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_quality">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][quality]" value="1"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'quality', 1)?>  >
                                  <span>{{ phrase var='homdom.quality_1' }} </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>{{ phrase var='homdom.enter' }}</span>
                                  </div>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_quality">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][quality]" value="2"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'quality',2)?>  >
                                  <span>{{ phrase var='homdom.quality_2' }} </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>{{ phrase var='homdom.enter' }}</span>
                                  </div>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_quality">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][quality]" value="3"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'quality', 3)?> >
                                  <span>{{ phrase var='homdom.quality_3' }} </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>{{ phrase var='homdom.enter' }}</span>
                                  </div>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_quality">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][quality]" value="4"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'quality', 4)?>  >
                                  <span> {{ phrase var='homdom.quality_4' }} </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>{{ phrase var='homdom.enter' }}</span>
                                  </div>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.window_view' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static ck_build_window_view">
                                <label class="add_check">
                                  <input type="checkbox" name="val[type_1][window_view][]" value="1"  <?= AIN::getService('homdom.helpers')->checkedIfInArray($aForms['type_1'], 'window_view', 1)?>  >
                                  <span> {{ phrase var='homdom.window_view_1' }} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_window_view">
                                <label class="add_check">
                                  <input type="checkbox" name="val[type_1][window_view][]" value="2"  <?= AIN::getService('homdom.helpers')->checkedIfInArray($aForms['type_1'], 'window_view', 2)?> >
                                  <span>{{ phrase var='homdom.window_view_2' }} </span>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title"> {{ phrase var='homdom.bill_of_sale' }}</div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static ck_build_bill_of_sale">
                                <label class="add_check">
                                  <input type="radio" name="val[type_1][bill_of_sale]" value="1" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'bill_of_sale', 1)?> >
                                  <span>{{ phrase var='homdom.bill_of_sale_1' }} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_bill_of_sale">
                                <label class="add_check">
                                  <input type="radio"  name="val[type_1][bill_of_sale]"  value="0" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_1'], 'bill_of_sale', 0)?>>
                                  <span>{{ phrase var='homdom.bill_of_sale_0' }} </span>
                                </label>
                              </div>
                            </div>
                          </div>

                        </div>

                        <!-- Add_row ev/menzil -->
                        <div class="add_row item_lbl_child_2">
                          <div class="add_head">{{ phrase var='homdom.about_apartment' }} </div>
                          <div class="add_col col_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.room_count' }}</div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items ">
                                <label class="add_check">
                                    <input type="radio" name="val[type_2][room_count]" value="1"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'room_count', 1)?>  class="room_count_change_2" >
                                  <span>1 </span>
                                </label>
                              </div>
                              <div class="add_check_items ">
                                <label class="add_check">
                                  <input type="radio" name="val[type_2][room_count]" value="2"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'room_count', 2)?>  class="room_count_change_2" >
                                  <span>2 </span>
                                </label>
                              </div>
                              <div class="add_check_items ">
                                <label class="add_check">
                                  <input type="radio" name="val[type_2][room_count]" value="3"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'room_count', 3)?>  class="room_count_change_2"  >
                                  <span>3 </span>
                                </label>
                              </div>
                              <div class="add_check_items ">
                                <label class="add_check">
                                  <input type="radio" name="val[type_2][room_count]" value="4"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'room_count', 4)?>  class="room_count_change_2"  >
                                  <span>4 </span>
                                </label>
                              </div>
                              <div class="add_check_items ">
                                <label class="add_check">
                                  <input type="radio" name="val[type_2][room_count]" value="5"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'room_count', 5)?>  class="room_count_change_2"  >
                                  <span>5 </span>
                                </label>
                              </div>
                              <div class="add_check_items ">
                                <label class="add_check">
                                  <input type="radio" name="val[type_2][room_count]" value="6"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'room_count', 6)?>  class="room_count_change_2"  >
                                  <span>6 </span>
                                </label>
                              </div>
                              <div class="add_check_items ">
                                <label class="add_check">
                                  <input type="radio" name="val[type_2][room_count]" value="7"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'room_count', 7)?>  class="room_count_change_2" >
                                  <span>7+ </span>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.area' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="room_field">
                                  <div class="add_col col_7 ">
                                    <div class="add_inp_number static">
                                        <input type="text" min="1" name="val[type_2][area][all]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_2']['area'], 'all')?>" placeholder="" class="decimal " maxlength="5">
                                        <span class="clear_inp_val"></span>
                                    </div>
                                    <div class="rm_fld_name">{{phrase var='homdom.all'}} </div>
                                  </div>
                                  <div class="add_col col_7">
                                    <div class="add_inp_number static">
                                        <input type="text" min="1" name="val[type_2][area][living]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_2']['area'], 'living')?>" placeholder="" class="decimal " maxlength="5">
                                      <span class="clear_inp_val"></span>
                                    </div>
                                    <div class="rm_fld_name">{{phrase var='homdom.living'}} </div>
                                  </div>

                                <!-- </div> -->
                                <div class="room_change_field room_change_2">
                                    <?php for($i=1; $i<=7; $i++) { ?>
                                        <div class="add_col col_7 room_input_element" data-input="1">
                                            <div class="add_inp_number change">
                                                <input type="text" min="1" name="val[type_2][area][room_<?=$i?>]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_2']['area'], 'room_'.$i)?>" placeholder="" class="decimal " maxlength="5">
                                                <span class="clear_inp_val"></span>
                                            </div>
                                            <div class="rm_fld_name"><?=AIN::getPhrase('homdom.room_'.$i)?></div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="add_col col_7">
                                  <div class="add_inp_number static">
                                      <input type="text" min="1" name="val[type_2][area][kitchen]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms['type_2']['area'], 'kitchen')?>" placeholder="" class="decimal " maxlength="5">
                                    <span class="clear_inp_val"></span>
                                  </div>
                                  <div class="rm_fld_name">{{ phrase var='homdom.kitchen' }}</div>
                                </div>
                              </div>
                            </div>
                          </div>
                          
                          <div class="add_col col_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.sanitary' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static ck_build_sanitary">
                                <label class="add_check">
                                    <input type="radio" name="val[type_2][sanitary]"  value="1" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'sanitary', 1)?>>
                                    <span>{{ phrase var='homdom.together' }} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_sanitary">
                                <label class="add_check">
                                  <input type="radio" name="val[type_2][sanitary]"  value="2" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'sanitary', 2)?>>
                                  <span>{{ phrase var='homdom.seperate' }} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_sanitary">
                                <label class="add_check">
                                  <input type="radio" name="val[type_2][sanitary]"  value="3" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'sanitary', 3)?>>
                                  <span>{{ phrase var='homdom.more_1' }} </span>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.quality' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static ck_build_quality">
                                <label class="add_check">
                                  <input type="radio" name="val[type_2][quality]" value="0"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'quality', 0)?>  >
                                  <span>{{ phrase var='homdom.quality_0' }} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_quality">
                                <label class="add_check">
                                  <input type="radio" name="val[type_2][quality]" value="1"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'quality', 1)?> >
                                  <span>{{ phrase var='homdom.quality_1' }} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_quality">
                                <label class="add_check">
                                  <input type="radio" name="val[type_2][quality]" value="2"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'quality', 2)?>  >
                                  <span>{{ phrase var='homdom.quality_2' }} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_quality">
                                <label class="add_check">
                                  <input type="radio" name="val[type_2][quality]" value="3"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'quality', 3)?>>
                                  <span>{{ phrase var='homdom.quality_3' }} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_quality">
                                <label class="add_check">
                                  <input type="radio" name="val[type_2][quality]" value="4"  <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'quality', 4)?> >
                                  <span>{{ phrase var='homdom.quality_4' }} </span>
                                </label>
                              </div>
                            </div>
                          </div>

                          <div class="add_col col_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.window_view' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static ck_build_window_view">
                                <label class="add_check">
                                  <input type="checkbox" name="val[type_2][window_view][]" value="1"  <?= AIN::getService('homdom.helpers')->checkedIfInArray($aForms['type_2'], 'window_view', 1)?>  >
                                  <span>{{phrase var='homdom.window_view_1'}} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_window_view">
                                <label class="add_check">
                                  <input type="checkbox" name="val[type_2][window_view][]" value="1"  <?= AIN::getService('homdom.helpers')->checkedIfInArray($aForms['type_2'], 'window_view', 1)?>  >
                                  <span>{{phrase var='homdom.window_view_2'}}  </span>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title"> {{ phrase var='homdom.bill_of_sale' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static ck_build_bill_of_sale">
                                <label class="add_check">
                                    <input type="radio" name="val[type_2][bill_of_sale]" value="1" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'bill_of_sale', 1)?> >
                                    <span>{{ phrase var='homdom.bill_of_sale_1' }} </span>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_bill_of_sale">
                                <label class="add_check">
                                    <input type="radio" name="val[type_2][bill_of_sale]" value="0" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms['type_2'], 'bill_of_sale', 0)?> >
                                    <span>{{ phrase var='homdom.bill_of_sale_0' }} </span>
                                </label>
                              </div>
                            </div>
                          </div>

                        </div>
                        <!-- Add_row ev/menzil -->


                        <div class="add_row item_lbl_child_1" style="display: none !important;">
                          <div class="add_head">Mənzil planı</div>
                          <div class="add_litle_info">
                            Layihənizin bir şəklini yükləyin. Mənzil planı reklamları alıcılar üçün daha cəlbedicidir
                          </div>
                              <div class="add_img_gallery">
                                  <a href="/theme/frontend/homdom/style/img/news_2.jpg" data-fancybox="gallery" data-caption="" class="add_galery_items">
                                    <img src="/theme/frontend/homdom/style/img/news_2.jpg" alt="" />
                                  </a>
                                  <a href="/theme/frontend/homdom/style/img/news_3.jpg" data-fancybox="gallery" data-caption="" class="add_galery_items">
                                    <img src="/theme/frontend/homdom/style/img/news_3.jpg" alt="" />
                                  </a>
                                  <a href="/theme/frontend/homdom/style/img/news_4.jpg" data-fancybox="gallery" data-caption="" class="add_galery_items">
                                    <img src="/theme/frontend/homdom/style/img/news_4.jpg" alt="" />
                                  </a>
                                  <a href="/theme/frontend/homdom/style/img/news_5.jpg" data-fancybox="gallery" data-caption="" class="add_galery_items">
                                    <img src="/theme/frontend/homdom/style/img/news_5.jpg" alt="" />
                                  </a>
                                  <a href="/theme/frontend/homdom/style/img/room_1.png" data-fancybox="gallery" data-caption="" class="add_galery_items">
                                    <img src="/theme/frontend/homdom/style/img/room_1.png" alt="" />
                                  </a>
                                  <label class="add_img_label">
                                    <input type="file"  >
                                    <div class="add_galry_icon_info">
                                      <div class="add_gallry_icon">
                                        <span></span>
                                      </div>
                                      <div class="add_gallry_inf">Layihə planı əlavə edin </div>
                                    </div>
                                  </label>
                            </div>
                          </div>
                        </div>



                        <div class="add_row added_all_galery_foto">
                          <div class="add_head"> {{ phrase var='homdom.images' }} </div>
                          <div class="add_litle_info">
                              {{ phrase var='homdom.images_detail' }}
                          </div>
                          <div class="add_col col_1">
                            <div class="add_img_gallery">
                                <?php foreach ($aForms['image'] as $img) { ?>
                                    <a href="<?=$img?>" data-fancybox="gallery" data-caption="" data-id="<?=$img?>" class="add_galery_items">
                                        <img src="<?=$img?>" alt="" />
                                    </a>
                                <?php } ?>
                            </div>
                          </div>

                          <div class="add_col col_1">
                              <div class="lg_input">
                                  <input type="file" name="image" class="image" multiple>
                                  <div id="images">
                                      <?php foreach ($aForms['image'] as $img) { ?>
                                          <input type="hidden" name="val[images][]" value="<?=$img?>">
                                      <?php } ?>
                                  </div>

                              </div>
                          </div>

                        </div>

                        <div class="add_row added_video">
                          <div class="add_head">{{phrase var='homdom.video'}} </div>
                          <div class="add_litle_info">
                              {{phrase var='homdom.video_detail'}}
                          </div>

                            <div class="add_col col_1">
                                <div class="lg_input">
                                    <input type="file" name="image" class="video" multiple>
                                    <div id="videos">
                                        <?php foreach ($aForms['video'] as $v) { ?>
                                            <input type="hidden" name="val[videos][]" value="<?=$v?>">
                                        <?php } ?>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- this item_1 elements -->
                        <div class="add_row item_lbl_child_1">
                          <div class="add_head">{{ phrase var='homdom.utilities' }} </div>
                          <div class="add_col col_1 ">
                              <?php foreach ($this->_aVars['utilityRows'][1] as $key=>$val) { ?>
                                <div class="add_col col_4 static">
                                    <label class="label_item check_btn">
                                        <input type="checkbox" value="<?=$val['id']?>" name="val[type_1][utilities][]" id="utility-<?=$val['id']?>" <?= AIN::getService('homdom.helpers')->checkedIfInArray($aForms['type_1'], 'utilities', $val['id'])?>>
                                        <div class="check_item itm_type">
                                            <span class="itm_name"> <?=AIN::getPhrase('homdom.'.$val['phrase'])?> </span>
                                            <span class="itm_tik"></span>
                                        </div>
                                    </label>
                                </div>
                              <?php } ?>
                          </div>
                        </div>
                        <!-- this item_1 elements -->


                        <!-- this item_2 elements -->
                        <div class="add_row item_lbl_child_2">
                          <div class="add_head">{{phrase var='homdom.utilities'}} </div>
                          <div class="add_col col_1 ">
                              <?php foreach ($this->_aVars['utilityRows'][2] as $key=>$val) { ?>
                                  <div class="add_col col_4 static">
                                      <label class="label_item check_btn">
                                          <input type="checkbox" value="<?=$val['id']?>" name="val[type_2][utilities][]" id="utility-<?=$val['id']?>" <?= AIN::getService('homdom.helpers')->checkedIfInArray($aForms['type_2'], 'utilities', $val['id'])?>>
                                          <div class="check_item itm_type">
                                              <span class="itm_name"> <?=AIN::getPhrase('homdom.'.$val['phrase'])?> </span>
                                              <span class="itm_tik"></span>
                                          </div>
                                      </label>
                                  </div>
                              <?php } ?>
                          </div>
                        </div>
                        <!-- this item_2 elements -->


                        
                        <!-- this item_4 elements -->
                        <div class="add_row item_lbl_child_4">
                          <div class="add_head">{{ phrase var='homdom.utilities' }} </div>
                          <div class="add_col col_1 ">
                              <?php foreach ($this->_aVars['utilityRows'][4] as $key=>$val) { ?>
                                  <div class="add_col col_4">
                                      <label class="label_item check_btn">
                                          <input type="checkbox" value="<?=$val['id']?>" name="val[type_4][utilities][]" id="utility-<?=$val['id']?>" <?= AIN::getService('homdom.helpers')->checkedIfInArray($aForms['type_1'], 'utilities', $val['id'])?>>
                                          <div class="check_item itm_type">
                                              <span class="itm_name"> <?=AIN::getPhrase('homdom.'.$val['phrase'])?> </span>
                                              <span class="itm_tik"></span>
                                          </div>
                                      </label>
                                  </div>
                              <?php } ?>

                          </div>
                        </div>
                        <!-- this item_4 elements -->
                        <!-- this item_5 elements -->
                        <div class="add_row item_lbl_child_5">
                          <div class="add_head">{{phrase var='homdom.utilities'}} </div>
                          <div class="add_col col_1 ">
                              <?php foreach ($this->_aVars['utilityRows'][5] as $key=>$val) { ?>
                                  <div class="add_col col_4">
                                      <label class="label_item check_btn">
                                          <input type="checkbox" value="<?=$val['id']?>" name="val[type_5][utilities][]" id="utility-<?=$val['id']?>" <?= AIN::getService('homdom.helpers')->checkedIfInArray($aForms['type_5'], 'utilities', $val['id'])?>>
                                          <div class="check_item itm_type">
                                              <span class="itm_name"> <?=AIN::getPhrase('homdom.'.$val['phrase'])?> </span>
                                              <span class="itm_tik"></span>
                                          </div>
                                      </label>
                                  </div>
                              <?php } ?>
                          </div>
                        </div>
                        <!-- this item_5 elements -->
                        <!-- this item_6 elements -->
                        <div class="add_row item_lbl_child_6">
                          <div class="add_head">{{phrase var='homdom.utilities'}} </div>
                          <div class="add_col col_1 ">
                              <?php foreach ($this->_aVars['utilityRows'][6] as $key=>$val) { ?>
                                  <div class="add_col col_4">
                                      <label class="label_item check_btn">
                                          <input type="checkbox" value="<?=$val['id']?>" name="val[type_6][utilities][]" id="utility-<?=$val['id']?>" <?= AIN::getService('homdom.helpers')->checkedIfInArray($aForms['type_6'], 'utilities', $val['id'])?>>
                                          <div class="check_item itm_type">
                                              <span class="itm_name"> <?=AIN::getPhrase('homdom.'.$val['phrase'])?> </span>
                                              <span class="itm_tik"></span>
                                          </div>
                                      </label>
                                  </div>
                              <?php } ?>
                          </div>
                        </div>
                        <!-- this item_6 elements -->

                        <div class="add_row ">
                          <div class="add_head"> {{ phrase var='homdom.description' }} </div>
                          <div class="add_col col_1">
                            <textarea name="val[description]"   class="add_home_comment" placeholder="{{phrase var='description_placeholder'}}"><?= AIN::getService('homdom.helpers')->getValueOfInput($aForms, 'description')?></textarea>
                          </div>
                        </div>

                        <div class="add_row appart_price_row">
                          <div class="add_head">{{ phrase var='homdom.amount' }} </div>
                          <div class="add_col col_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.amount_title' }} </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_inp_number">
                                <input type="number"  name="val[price]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms, 'price')?>" placeholder="" class="decimal" maxlength="13">
                                <span class="clear_inp_val"></span>
                                <div class="alert alert-danger alert-block">
                                  <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                  <span>{{ phrase var='homdom.required' }}</span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title"> {{ phrase var='homdom.mortgage' }}</div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static ck_build_mortgage">
                                <label class="add_check">
                                  <input type="radio" name="val[mortgage]"  value="1" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms, 'mortgage', '1')?>>
                                  <span> {{phrase var='homdom.mortgage_yes'}} </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>{{ phrase var='homdom.required' }}</span>
                                  </div>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_mortgage">
                                <label class="add_check">
                                  <input type="radio" name="val[mortgage]"   value="0" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms, 'mortgage', '0')?>>
                                  <span>{{phrase var='homdom.mortgage_no'}} </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>{{ phrase var='homdom.required' }}</span>
                                  </div>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title">{{ phrase var='homdom.haggle'}}</div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items static ck_build_haggle">
                                <label class="add_check">
                                  <input type="radio" name="val[haggle]"  value="1" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms, 'haggle', '1')?>>
                                  <span>{{ phrase var='homdom.haggle_yes'}} </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>{{ phrase var='homdom.required' }}</span>
                                  </div>
                                </label>
                              </div>
                              <div class="add_check_items static ck_build_haggle">
                                <label class="add_check">
                                  <input type="radio" name="val[haggle]"   value="0" <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms, 'haggle', '0')?>>
                                  <span>{{ phrase var='homdom.haggle_no'}}  </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>{{ phrase var='homdom.required' }}</span>
                                  </div>
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>


                        {{ if !auth() }}
                        <div class="add_row contact_row">
                          <div class="add_head">Əlaqə </div>
                          <div class="add_col col_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title">İpoteka ilə satış </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_check_items">
                                <label class="add_check">
                                  <input type="radio" name="contact_menecer"  checked>
                                  <span>Mülkiyyətçi </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>{{ phrase var='homdom.required' }}</span>
                                  </div>
                                </label>
                              </div>
                              <div class="add_check_items">
                                <label class="add_check">
                                  <input type="radio" name="contact_menecer"  >
                                  <span>Agentlik </span>
                                  <div class="alert alert-danger alert-block">
                                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                    <span>{{ phrase var='homdom.required' }}</span>
                                  </div>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title">Adınız </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_search">
                                <input type="text"   value="" placeholder="Məsələn, Şahin Şahbazov">
                                <div class="alert alert-danger alert-block">
                                  <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                  <span>{{ phrase var='homdom.required' }}</span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title">E-poçt </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_search">
                                <input type="text"   value="" placeholder="">
                                <div class="alert alert-danger alert-block">
                                  <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                  <span>{{ phrase var='homdom.required' }}</span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="add_col col_1">
                            <div class="add_col col_3">
                              <div class="add_litle_title">Telefon </div>
                            </div>
                            <div class="add_col col_5">
                              <div class="add_inp_number contact_number">
                                <input type="text"   value="+994 55 000 00 00" placeholder="" class="phone">
                                <span class="clear_inp_val"></span>
                                <div class="alert alert-danger alert-block">
                                  <button type="button" class="hide_error" data-dismiss="alert">x</button>
                                  <span>{{ phrase var='homdom.required' }}</span>
                                </div>
                              </div>
                              <div class="confirm_btn">
                                <button type="button" class="cnf_btn">Təsdiqlə </button>
                              </div>
                            </div>
                          </div>
                        </div>

                        {{ /if }}
                        <div class="add_row add_form_finish">
                          <div class="add_col col_1">
                            <div class="add_litle_info">
                              Elan yerləşdirərək, <a href="" class="jr_in_link">Siz Every.az-ın İstifadəçi razılaşması</a> ilə razı olduğunuzu təsdiq edirsiniz.
                            </div>
                          </div>
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
<script src="/theme/frontend/homdom/style/js/myjs.js?v11"></script>

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
                            $("#images").append('<input type="hidden" name="val[images][]" value="'+arr['down_url']+'" id="'+arr['down_url']+'">')
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

    // $( ".add_anc_form" ).submit(function( event ) {
    //     // return true;
    //   item_AllVideo();
    //   item_AllPrice();
    //   home_buy_sell();
    //   {{ if !auth() }}
    //     item_AllContact();
    //   {{ /if }}

    //   if ($(".item_lbl_1 input").is(":checked")){
    //     item_1();
    //   } else if ($(".item_lbl_2 input").is(":checked")){
    //     item_2();
    //   } else if ($(".item_lbl_3 input").is(":checked")){
    //     item_3();
    //   } else if ($(".item_lbl_4 input").is(":checked")){
    //     item_4();
    //   } else if ($(".item_lbl_5 input").is(":checked")){
    //     item_5();
    //   } else if ($(".item_lbl_6 input").is(":checked")){
    //     item_6();
    //   } else{
    //     event.preventDefault();
    //   }
      
    //   //event.preventDefault();
    // });
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

@endsection()

