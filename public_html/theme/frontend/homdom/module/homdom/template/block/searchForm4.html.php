<?php $search = $this->_aVars['search'] ?>

<div class="add_col col_1 ">
    <div class="add_col col_4">
        <div class="add_litle_title">{{phrase var='homdom.building_name'}} </div>
    </div>
    <div class="add_col col_6">
        <div class="add_search">
            <input type="text" name="building_name" value="<?=AIN::getService('homdom.helpers')->getValueOfInput($search, 'floors_total_min')?>">
        </div>
    </div>
</div>

<div class="add_col col_1 ">
    <div class="add_col col_4">
        <div class="add_litle_title">{{phrase var='homdom.garage_type'}} </div>
    </div>
    <div class="add_col col_6">
        <?php for($i=1; $i<=3; $i++) { ?>
        <div class="add_check_items">
            <label class="add_check">
                <input type="checkbox" value="<?=$i?>" name="garage_type[]" <?=AIN::getService('homdom.helpers')->checkedIfInArray($search, 'garage_type', $i)?>>
                <span><?=AIN::getPhrase('homdom.garage_type_'.$i)?></span>
            </label>
        </div>
        <?php } ?>
    </div>
</div>
<div class="add_col col_1 ">
    <div class="add_col col_4">
        <div class="add_litle_title">{{phrase var='homdom.material'}} </div>
    </div>
    <div class="add_col col_6">
        <?php foreach([1,5,6] as $i) { ?>

        <div class="add_check_items">
            <label class="add_check">
                <input type="checkbox" name="material[]" value="<?=$i?>" <?=AIN::getService('homdom.helpers')->checkedIfInArray($search, 'material', $i)?>>
                <span><?=AIN::getPhrase('homdom.material_'.$i)?></span>
            </label>
        </div>
        <?php } ?>
    </div>
</div>
<div class="add_col col_1 ">
    <div class="add_col col_4">
        <div class="add_litle_title">{{phrase var='homdom.garage_status'}} </div>
    </div>
    <div class="add_col col_6">
        <?php for($i=1; $i<=3; $i++) { ?>
            <div class="add_check_items">
                <label class="add_check">
                    <input type="checkbox" value="<?=$i?>" name="garage_status[]" <?=AIN::getService('homdom.helpers')->checkedIfInArray($search, 'garage_status', $i)?>>
                    <span><?=AIN::getPhrase('homdom.garage_status_'.$i)?></span>
                </label>
            </div>
        <?php } ?>
    </div>
</div>
