<?php $search = $this->_aVars['search'] ?>

<div class="add_col col_1">
    <div class="add_col col_4">
        <div class="add_litle_title">{{phrase var='homdom.exit'}} </div>
    </div>
    <div class="add_col col_6">
        <?php for($i=1; $i<=2; $i++) { ?>
            <div class="add_check_items">
                <label class="add_check">
                    <input type="checkbox" value="<?=$i?>" name="building_exit[]" <?=AIN::getService('homdom.helpers')->checkedIfInArray($search, 'building_exit', $i)?>>
                    <span><?=AIN::getPhrase('homdom.exit_'.$i)?></span>
                </label>
            </div>
        <?php } ?>
    </div>
</div>

