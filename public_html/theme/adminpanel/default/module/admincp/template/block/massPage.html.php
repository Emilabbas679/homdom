{{ if $massType == 'targets' }}


<div class="add_col col_1" id="locality_block">
    <div class="add_col col_3">
        <div class="add_litle_title">{{phrase var='homdom.targets'}} </div>
    </div>
    <div class="add_col col_5">
        <div class="custom_select2">
            <select class="form-control select_2_autocomplete" name="val[targets][]" id="targets" multiple>

            </select>
        </div>
    </div>
</div>


{{ else if $massType == 'utility' }}

<div class="add_row item_lbl_child_1">
    <div class="add_head">{{ phrase var='homdom.utilities' }} </div>
    <div class="add_col col_1 ">
        <?php $utilities = []; ?>
        <?php foreach ($utilities as $key=>$val) { ?>
            <div class="add_col col_4 static">
                <label class="label_item check_btn">
                    <input type="checkbox" value="<?=$val['id']?>" name="val[utilities][]" id="utility-<?=$val['id']?>">
                    <div class="check_item itm_type">
                        <span class="itm_name"> <?=AIN::getPhrase('homdom.'.$val['phrase'])?> </span>
                        <span class="itm_tik"></span>
                    </div>
                </label>
            </div>
        <?php } ?>
    </div>
</div>



{{ /if }}