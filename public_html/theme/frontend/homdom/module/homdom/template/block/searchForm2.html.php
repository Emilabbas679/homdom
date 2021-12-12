<?php $search = $this->_aVars['search'] ?>

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
