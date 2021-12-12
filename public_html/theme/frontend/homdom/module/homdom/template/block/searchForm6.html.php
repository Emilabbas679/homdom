<?php $search = $this->_aVars['search']; ?>
<?php $cTypes = $this->_aVars['cTypes'] ?>
<div class="add_col col_1 ">
    <div class="add_col col_4">
        <div class="add_litle_title">{{phrase var='homdom.commercial_type'}} </div>
    </div>
    <div class="add_col col_6">
        <?php foreach ($cTypes as $type) {
            $type = (array) json_decode($type) ;?>

            <div class="add_check_items">
                <label class="add_check">
                    <input type="checkbox" value="<?=$type['id']?>" name="commercial_type[]" <?=AIN::getService('homdom.helpers')->checkedIfInArray($search, 'commercial_type', $type['id'])?>>
                    <span><?=AIN::getPhrase('homdom.'.$type['phrase'])?></span>
                </label>
            </div>
        <?php } ?>
    </div>
</div>
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