<main class="main">
    <div class="section_wrap wrap_add_announce">
    <?php $aForms = $this->_aVars['aForms'] ?>

      <div class="section_body">
        <div class="main_center">
<!--             id="add_anc_form"-->
          <form action="" method="post" class="add_anc_form" id="add_anc_form" novalidate>
            <div class="section_headers">
              <h1 class="address_h">{{ phrase var="homdom.new_offer" }}</h1>
              <div class="add_row">
                <div class="add_col col_2 home_check_buy_sell">
                  <label class="label_item radio_btn">
                    <input type="radio" name="val[offer_type]" value='1' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms, 'offer_type', '1')?>>
                    <div class="check_item itm_catg ch_hm_validate">
                      <span class="itm_name">{{ phrase var="homdom.offer_type_sell" }}</span>
                      <span class="itm_tik"></span>
                    </div>
                  </label>
                </div>
                <div class="add_col col_2 home_check_buy_sell" >
                  <label class="label_item radio_btn">
                    <input type="radio" name="val[offer_type]" value='2' <?= AIN::getService('homdom.helpers')->checkedIfExist($aForms, 'offer_type', '2')?>>
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
                                      <option value="<?=$aForms['building_id'] ?>" selected><?=$aForms['b_name']?></option>
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
                      <div class="add_litle_title">Sahə ölçüsü</div>
                    </div>
                    <div class="add_col col_5">
                      <div class="add_col col_3 p_0">
                        <div class="custom_select">
                          <select name="select" class="select-regist">
                            <option value="">m² </option>
                            <option value="">Ar </option>
                            <option value="">Hektar</option>
                          </select>
                        </div>
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
                  <div class="add_col col_1 item_lbl_child_4">
                    <div class="add_col col_3">
                      <div class="add_litle_title">Sahə ölçüsü</div>
                    </div>
                    <div class="add_col col_5">
                      <div class="add_col col_3 p_0">
                        <div class="custom_select">
                          <select name="select" class="select-regist">
                            <option value="">m² </option>
                            <option value="">Ar </option>
                            <option value="">Hektar</option>
                          </select>
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
                      <div class="add_litle_title">Sahə ölçüsü</div>
                    </div>
                    <div class="add_col col_5">
                      <div class="add_col col_3 p_0">
                        <div class="custom_select">
                          <select name="select" class="select-regist">
                            <option value="">m² </option>
                            <option value="">Ar </option>
                            <option value="">Hektar</option>
                          </select>
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
                  <div class="add_col col_1 item_lbl_child_6">
                    <div class="add_col col_3">
                      <div class="add_litle_title">Sahə ölçüsü</div>
                    </div>
                    <div class="add_col col_5">
                      <div class="add_col col_3 p_0">
                        <div class="custom_select">
                          <select name="select" class="select-regist">
                            <option value="">m² </option>
                            <option value="">Ar </option>
                            <option value="">Hektar</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- this item_6 elements -->

                  <!-- this are all items have -->
                  <div class="add_col col_1">
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

                    <div class="add_col col_1" id="locality_block">
                        <div class="add_col col_3">
                            <div class="add_litle_title">{{phrase var='homdom.targets'}} </div>
                        </div>
                        <div class="add_col col_5">
                            <div class="custom_select2">
                                <select class="form-control select_2_autocomplete" name="val[targets][]" id="targets" multiple>
                                    <?php if (isset($aForms['targets']) and $aForms['targets'] > 0 ) {
                                        foreach ($aForms['targets'] as $target_id) {
                                            $a_target = AIN::getService('homdom.helpers')->getTargetById($target_id);
                                            if ($a_target != false) { ?>
                                                <option value="<?=$a_target['id'] ?>" selected><?=AIN::getPhrase('homdom.'.$a_target['phrase'])?></option>
                                            <?php    }} }?>
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
                  <div class="add_col col_1">
                    <div class="add_col col_3">
                      <div class="add_litle_title">Sahə ölçüsü</div>
                    </div>
                    <div class="add_col col_5">
                      <div class="add_col col_3 p_0">
                        <div class="custom_select">
                          <select name="select" class="select-regist">
                            <option value="">m² </option>
                            <option value="">Ar </option>
                            <option value="">Hektar</option>
                          </select>
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
                      <div class="add_litle_title">Sahə ölçüsü</div>
                    </div>
                    <div class="add_col col_5">
                      <div class="add_col col_3 p_0">
                        <div class="custom_select">
                          <select name="select" class="select-regist">
                            <option value="">m² </option>
                            <option value="">Ar </option>
                            <option value="">Hektar</option>
                          </select>
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
                          <input type="file" name="image" class="image" data-allow-reorder="true" multiple>
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
                      <div class="add_col col_3">
                        <div class="add_litle_title">Youtube linki </div>
                      </div>
                      <div class="add_col col_5">
                        <div class="add_search">
                          <input type="text" name="" id="" value="" placeholder="https://www.youtube.com/">
                          <div class="alert alert-danger alert-block">
                            <button type="button" class="hide_error" data-dismiss="alert">x</button>
                            <span>boş qala bilməz</span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="add_col col_1">
                        <div class="lg_input">
                            <input type="file" name="image" class="video" data-allow-reorder="true" multiple>
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
                        <input type="text"  name="val[price]"  value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms, 'price')?>" placeholder="" class="decimal" maxlength="13">
                        <!-- <span class="clear_inp_val"></span> -->
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
</main>

<link href="/theme/frontend/homdom/style/filepond/filepond.css?v=<?= AIN::getTime(); ?>" rel="stylesheet">
<link href="/theme/frontend/homdom/style/filepond/filepond-plugin-media-preview.css?v=<?= AIN::getTime(); ?>" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css?v=<?= AIN::getTime(); ?>" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css?v=<?= AIN::getTime(); ?>" rel="stylesheet"/>
<link href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css" rel="stylesheet"/>


@section('js')
<style>
    .filepond--credits{display: none !important;}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.6.15/browser-polyfill.min.js"></script>
<!-- <script src="https://unpkg.com/filepond-polyfill/dist/filepond-polyfill.js"></script> -->

<!-- <script src="https://unpkg.com/filepond-plugin-image-validate-size/dist/filepond-plugin-image-validate-size.js"></script> -->
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="/theme/frontend/homdom/style/filepond/filepond-plugin-media-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>

<script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>

<!-- <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script> -->
<!-- <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script> -->
<!-- <script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script> -->
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<!--<script src="https://unpkg.com/filepond/dist/filepond.js"></script>-->
<!--<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>-->

<script>
    // class="im
    document.addEventListener('DOMContentLoaded', function() {
        FilePond.registerPlugin(
            FilePondPluginFileValidateSize,
            FilePondPluginMediaPreview,
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType,
            FilePondPluginImageCrop,
            FilePondPluginImageTransform,
            FilePondPluginFilePoster,
            FilePondPluginImageResize,
            FilePondPluginImageEdit
        );
        var pond_image = FilePond.create(document.querySelector('input.image'),{
            labelIdle: '<span class="prof_inf_lb_file"><?=AIN::getPhrase('homdom.add_files')?></span><span class="add_gallry_inf">və ya sahəyə sürükləyin</span>',
            imagePreviewHeight: 200,
            imageCropAspectRatio: '1:1',
            imageResizeTargetWidth: 260,
            imageResizeTargetHeight: 260,
            styleLoadIndicatorPosition: 'center bottom',
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
            imagePreviewHeight: 300,
            imageCropAspectRatio: '1:1',
            imageResizeTargetWidth: 560,
            imageResizeTargetHeight: 560,
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


    // $("#locality_block").hide()
    // $("#metro_block").hide()


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
        console.log(city_id)
        localities(city_id)

    })

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
                    page: params.page || 1
                }
                return query;
            },
            delay: 600,
            cache: true
        }
    });


    $('#targets').select2({
        placeholder: "<?=AIN::getPhrase('homdom.select_targets')?>",
        language: {
            searching: function() {
                return "<?=AIN::getPhrase('homdom.searching')?>";
            }
        },
        ajax: {
            url: "/_ajax?core[ajax]=true&core[call]=homdom.searchTarget",
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

<script src="/theme/frontend/homdom/style/js/fancybox.js"></script>

<script src="/theme/frontend/homdom/style/js/datepicker.min.js"></script>

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
    

    searchBox.addListener("places_changed", () => {
      const places = searchBox.getPlaces();

      if (places.length == 0) {
        return;
      }

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

  $( "#add_anc_form" ).submit(function( event ) {
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
</script>
<script src="/theme/frontend/homdom/style/js/valid.js"></script>

@endsection()
