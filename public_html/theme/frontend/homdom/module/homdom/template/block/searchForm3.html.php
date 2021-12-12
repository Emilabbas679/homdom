<?php $search = $this->_aVars['search'] ?>

<div class="add_col col_1 ">
    <div class="add_col col_4">
        <div class="add_litle_title">{{phrase var='homdom.field_type'}}</div>
    </div>
    <div class="add_col col_6">
        <?php for($i=1; $i<=3; $i++) { ?>
            <div class="add_check_items">
                <label class="add_check">
                    <input type="checkbox" value="<?=$i?>" name="field_type[]" <?=AIN::getService('homdom.helpers')->checkedIfInArray($search, 'field_type', $i)?>>
                    <span><?=AIN::getPhrase('homdom.field_type_'.$i)?></span>
                </label>
            </div>
        <?php } ?>
    </div>
</div>
