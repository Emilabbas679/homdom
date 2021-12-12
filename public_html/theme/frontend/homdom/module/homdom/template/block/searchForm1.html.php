<?php $search = $this->_aVars['search'] ?>
<div class="add_col col_1 ">
    <div class="add_col col_4">
        <div class="add_litle_title ">{{ phrase var='homdom.building_type' }}  </div>
    </div>
    <div class="add_col col_6">
        <div class="add_check_items oneChecked">
            <label class="add_check">
                <input type="checkbox" value="1" name="building_type" <?=AIN::getService('homdom.helpers')->checkedIfExist($search, 'building_type', 1)?>>
                <span>{{ phrase var='homdom.building_type_1' }} </span>
            </label>
        </div>
        <div class="add_check_items oneChecked">
            <label class="add_check">
                <input type="checkbox" value="0" name="building_type" <?=AIN::getService('homdom.helpers')->checkedIfExist($search, 'building_type', 0)?>>
                <span>{{ phrase var='homdom.building_type_0' }}  </span>
            </label>
        </div>
    </div>
</div>
<div class="add_col col_1 ">
    <div class="add_col col_4">
        <div class="add_litle_title">{{phrase var='homdom.flat_floor'}} </div>
    </div>
    <div class="add_col col_6">
        <div class="add_col col_4 p_0">
            <div class="all_filter_min_max">
                <div class="filter_m_inpt add_col p_0">
                    <div class="add_inp_number">
                        <input type="text"  name="flat_floor[min]" value="<?=AIN::getService('homdom.helpers')->getValueOfArray($search,'flat_floor', 'min')?>" placeholder="{{ phrase var='homdom.min' }}" class="integer_num" maxlength="3">
                        <span class="clear_inp_val"></span>
                    </div>
                    <div class="add_inp_number">
                        <input type="text" name="flat_floor[max]" value="<?=AIN::getService('homdom.helpers')->getValueOfArray($search,'flat_floor', 'max')?>" placeholder="{{ phrase var='homdom.max' }}" class="integer_num" maxlength="3" >
                        <span class="clear_inp_val"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="add_col col_6">
            <div class="add_check_items">
                <label class="add_check">
                    <input type="checkbox" name="flat_floor[not_first]" value="1" <?=AIN::getService('homdom.helpers')->checkedIfInExistValue($search,'flat_floor', 'not_first', 1)?>>
                    <span>{{phrase var='homdom.not_first'}} </span>
                </label>
            </div>
            <div class="add_check_items">
                <label class="add_check">
                    <input type="radio" name="flat_floor[last]" value="0" <?=AIN::getService('homdom.helpers')->checkedIfInExistValue($search,'flat_floor', 'last', 0)?>>
                    <span>{{phrase var='homdom.not_last'}}</span>
                </label>
            </div>
            <div class="add_check_items">
                <label class="add_check">
                    <input type="radio" name="flat_floor[last]" value="1" <?=AIN::getService('homdom.helpers')->checkedIfInExistValue($search,'flat_floor', 'last', 1)?>>
                    <span>{{phrase var='homdom.last'}}</span>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="add_col col_1 " >
    <div class="add_col col_4">
        <div class="add_litle_title">{{ phrase var='homdom.quality'}} </div>
    </div>
    <div class="add_col col_6">
        <?php for ($i=0; $i<5; $i++) { ?>
            <div class="add_check_items">
                <label class="add_check">
                    <input type="checkbox" name="quality[]" value="<?=$i?>" <?=AIN::getService('homdom.helpers')->checkedIfInArray($search, 'quality', $i)?>>
                    <span><?=AIN::getPhrase('homdom.quality_'.$i)?> </span>
                </label>
            </div>
        <?php } ?>
    </div>
</div>
<div class="add_col col_1 " >
    <div class="add_col col_4">
        <div class="add_litle_title">{{phrase var='homdom.kitchen_minimum'}} </div>
    </div>
    <div class="add_col col_6">

        <?php foreach ([3,6,12,15,20] as $val) { ?>
            <div class="add_check_items oneChecked">
                <label class="add_check">
                    <input type="checkbox" value="<?=$val?>" name="kitchen_area" <?=AIN::getService('homdom.helpers')->checkedIfExist($search, 'kitchen_area', $val)?> >
                    <span><?=$val?> m² </span>
                </label>
            </div>
        <?php } ?>
    </div>
</div>
<div class="add_col col_1 " >
    <div class="add_col col_4">
        <div class="add_litle_title">{{ phrase var='homdom.utilities_include'}} </div>
    </div>
    <div class="add_col col_6">
        <?php for ($i=0;$i<=1; $i++ ) { ?>
            <div class="add_check_items oneChecked">
                <label class="add_check">
                    <input type="checkbox" name="utilities_include" value="<?=$i?>" <?=AIN::getService('homdom.helpers')->checkedIfExist($search, 'utilities_include', $i)?>>
                    <span><?=AIN::getPhrase('homdom.utilities_include_'.$i)?> </span>
                </label>
            </div>
        <?php } ?>
    </div>
</div>
<div class="add_col col_1 ">
    <div class="add_col col_4">
        <div class="add_litle_title">{{phrase var='homdom.ceiling_height'}}</div>
    </div>
    <div class="add_col col_6">
        <?php foreach (['2.5' ,'2.8', '3', '4'] as $h) { ?>
            <div class="add_check_items oneChecked">
                <label class="add_check">
                    <input type="checkbox" name="ceiling_height" id="" value="<?=$h?>" <?=AIN::getService('homdom.helpers')->checkedIfExist($search, 'ceiling_height', $h)?>>
                    <span><?=$h?> m </span>
                </label>
            </div>
        <?php } ?>
    </div>
</div>
<div class="add_col col_1 " >
    <div class="add_col col_4">
        <div class="add_litle_title">{{ phrase var='homdom.balcony' }} </div>
    </div>
    <div class="add_col col_6">
        <?php for ($i=0; $i<=2;$i++) { ?>
            <div class="add_check_items oneChecked">
                <label class="add_check">
                    <input type="checkbox" name="balcony" value="<?=$i?>" <?=AIN::getService('homdom.helpers')->checkedIfExist($search, 'balcony', $i)?> >
                    <span><?=AIN::getPhrase('homdom.balcony_'.$i)?> </span>
                </label>
            </div>
        <?php } ?>
    </div>
</div>
<div class="add_col col_1 ">
    <div class="add_col col_4">
        <div class="add_litle_title">{{phrase var='homdom.window_view'}} </div>
    </div>
    <div class="add_col col_6">
        <?php for ($i=1; $i<=2; $i++) { ?>
            <div class="add_check_items">
                <label class="add_check">
                    <input type="checkbox" name="window_view[]" <?=AIN::getService('homdom.helpers')->checkedIfInArray($search, 'window_view', $i)?> value="<?=$i?>">
                    <span><?=AIN::getPhrase('homdom.window_view_'.$i)?> </span>
                </label>
            </div>
        <?php } ?>
    </div>
</div>
<div class="add_col col_1 " >
    <div class="add_col col_4">
        <div class="add_litle_title">{{ phrase var='homdom.sanitary' }} </div>
    </div>
    <div class="add_col col_6">
        <?php for ($i=1;$i<=3; $i++) { ?>
            <div class="add_check_items oneChecked">
                <label class="add_check">
                    <input type="checkbox" name="sanitary" value="<?=$i?>" <?=AIN::getService('homdom.helpers')->checkedIfExist($search, 'sanitary', $i)?>>
                    <span><?=AIN::getPhrase('homdom.sanitary_'.$i)?></span>
                </label>
            </div>
        <?php } ?>
    </div>
</div>
<div class="add_col col_1 "  >
    <div class="add_col col_4">
        <div class="add_litle_title">{{phrase var='homdom.building_name'}} </div>
    </div>
    <div class="add_col col_6">

        <div class="add_search">
            <div class="custom_select2">
                <span class="clear_inp_val"></span>
                <select class="form-control select_2_autocomplete valid_slct_1" id="buildings" name="building_id">
                    <?php if (isset($search['building_id']) and $search['building_id'] > 0) {
                        $s_building = AIN::getService('homdom.helpers')->getBuildingById($search['building_id']);
                        if ($s_building) { ?>
                        <option value="<?=$s_building['id'] ?>"><?=$s_building['building_name']?></option>
                    <?php } } ?>

                </select>
                <div class="alert alert-danger alert-block">
                    <button type="button" class="hide_error" data-dismiss="alert">x</button>
                    <span>{{ phrase var='homdom.enter' }}</span>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="add_col col_1 " >
    <div class="add_col col_4">
        <div class="add_litle_title">{{ phrase var='homdom.total_floor' }}</div>
    </div>
    <div class="add_col col_6">
        <div class="add_col col_4 p_0">
            <div class="all_filter_min_max">
                <div class="filter_m_inpt add_col p_0">
                    <div class="add_inp_number">
                        <input type="text" name="floors_total_min" value="<?=AIN::getService('homdom.helpers')->getValueOfInput($search, 'floors_total_min')?>" placeholder="{{ phrase var='homdom.min' }}" class="integer_num" maxlength="3">
                        <span class="clear_inp_val"></span>
                    </div>
                    <div class="add_inp_number">
                        <input type="text" name="floors_total_max" value="<?=AIN::getService('homdom.helpers')->getValueOfInput($search, 'floors_total_max')?>" placeholder="{{ phrase var='homdom.max' }}" class="integer_num" maxlength="3"  >
                        <span class="clear_inp_val"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="add_col col_1 " >
    <div class="add_col col_4">
        <div class="add_litle_title">{{phrase var='homdom.built_year'}} </div>
    </div>
    <div class="add_col col_6">
        <div class="add_col col_4 p_0">
            <div class="all_filter_min_max">
                <div class="filter_m_inpt add_col p_0">
                    <div class="add_inp_number">
                        <input type="text" name="built_year_min" value="<?=AIN::getService('homdom.helpers')->getValueOfInput($search, 'built_year_min')?>" placeholder="{{phrase var='homdom.min'}}" class="integer_num" maxlength="4">
                        <span class="clear_inp_val"></span>
                    </div>
                    <div class="add_inp_number">
                        <input type="text" name="built_year_max" value="<?=AIN::getService('homdom.helpers')->getValueOfInput($search, 'built_year_max')?>" placeholder="{{phrase var='homdom.min'}}" class="integer_num" maxlength="4" >
                        <span class="clear_inp_val"></span>
                    </div>
                </div>
            </div>
        </div>
        <label class="add_inp_check_static">
            <input type="checkbox" name="built_not_delivery"  value="1" <?=AIN::getService('homdom.helpers')->checkedIfExist($search, 'built_not_delivery', 1)?>>
            <span>{{phrase var='homdom.not_delivery'}}</span>
        </label>
    </div>
</div>
<div class="add_col col_1 " >
    <div class="add_col col_4">
        <div class="add_litle_title"> {{ phrase var='homdom.parking' }}</div>
    </div>
    <div class="add_col col_6">
        <?php for ($i =0; $i<=3; $i++) { ?>
            <div class="add_check_items">
                <label class="add_check">
                    <input type="checkbox" name="parking[]" value="<?=$i?>" <?=AIN::getService('homdom.helpers')->checkedIfInArray($search, 'parking', $i)?>>
                    <span><?=AIN::getPhrase('homdom.parking_'.$i)?> </span>
                </label>
            </div>
        <?php } ?>

    </div>
</div>
<div class="add_col col_1 " >
    <div class="add_col col_4">
        <div class="add_litle_title">{{ phrase var='homdom.lift' }} </div>
    </div>
    <div class="add_col col_6">
        <?php for ($i = 2; $i<=3; $i++) { ?>
            <div class="add_check_items oneChecked">
                <label class="add_check">
                    <input type="checkbox" name="seller_type" value="<?=$i?>" <?=AIN::getService('homdom.helpers')->checkedIfExist($search, 'lift', $i)?>>
                    <span><?=AIN::getPhrase('homdom.lift_'.$i)?> </span>
                </label>
            </div>
        <?php } ?>
    </div>
</div>
<div class="add_col col_1 " >
    <div class="add_col col_4">
        <div class="add_litle_title">{{phrase var='homdom.imagine'}} </div>
    </div>
    <div class="add_col col_6">
        <div class="add_check_items">
            <label class="add_check">
                <input type="checkbox" name="imagine[image]"value="1"  <?=AIN::getService('homdom.helpers')->checkedIfInExistValue($search, 'imagine', 'image',1)?>>
                <span>{{phrase var='homdom.image'}} </span>
            </label>
        </div>
        <div class="add_check_items">
            <label class="add_check">
                <input type="checkbox" name="imagine[video]" value="1"  <?=AIN::getService('homdom.helpers')->checkedIfInExistValue($search, 'imagine', 'video',1)?>>
                <span>{{phrase var='homdom.video'}} </span>
            </label>
        </div>
        <div class="add_check_items">
            <label class="add_check">
                <input type="checkbox" name="imagine[3d]" value="1"  <?=AIN::getService('homdom.helpers')->checkedIfInExistValue($search, 'imagine', '3d',1)?>>
                <span>{{phrase var='homdom.3D'}} </span>
            </label>
        </div>
    </div>
</div>
<div class="add_col col_1 " >
    <div class="add_col col_4">
        <div class="add_litle_title">{{ phrase var='homdom.bill_of_sale' }}</div>
    </div>
    <div class="add_col col_6">
        <?php for ($i =0; $i<=1; $i++) { ?>
            <div class="add_check_items oneChecked">
                <label class="add_check">
                    <input type="checkbox" name="bill_of_sale" value="<?=$i?>" <?=AIN::getService('homdom.helpers')->checkedIfExist($search, 'bill_of_sale', $i)?>>
                    <span><?=AIN::getPhrase('homdom.bill_of_sale_'.$i)?> </span>
                </label>
            </div>
        <?php } ?>
    </div>
</div>
<div class="add_col col_1 " >
    <div class="add_col col_4">
        <div class="add_litle_title">{{phrase var='homdom.mortgage'}} </div>
    </div>
    <div class="add_col col_6">
        <?php for ($i =0; $i<=1; $i++) { ?>
            <div class="add_check_items oneChecked">
                <label class="add_check">
                    <input type="checkbox" name="mortgage" value="<?=$i?>" <?=AIN::getService('homdom.helpers')->checkedIfExist($search, 'mortgage', $i)?>>
                    <span><?=AIN::getPhrase('homdom.mortgage_'.$i)?> </span>
                </label>
            </div>
        <?php } ?>
    </div>
</div>
<div class="add_col col_1 " >
    <div class="add_col col_4">
        <div class="add_litle_title">{{phrase var='homdom.seller_type' }} </div>
    </div>
    <div class="add_col col_6">
        <?php for ($i =0; $i<=1; $i++) { ?>
            <div class="add_check_items oneChecked">
                <label class="add_check">
                    <input type="checkbox" name="seller_type" value="<?=$i?>" <?=AIN::getService('homdom.helpers')->checkedIfExist($search, 'seller_type', $i)?>>
                    <span><?=AIN::getPhrase('homdom.seller_type_'.$i)?> </span>
                </label>
            </div>
        <?php } ?>
    </div>
</div>

