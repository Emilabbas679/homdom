<?php defined('AIN') or exit('NO DICE!'); ?>
<?php /* Cached: December 12, 2021, 5:29 pm */ ?>
<div class="content-inner">
    <div class="breadcrumb">
        <ul>
            <li><a href="https://www.adserver.az?az"><?php echo AIN::getPhrase("homdom.home"); ?></a></li>
            <li><span><?php echo AIN::getPhrase("homdom.translations"); ?></span></li>
        </ul>
    </div>


    <div class="a-block mb-20">
        <div class="a-block-head"><?php echo AIN::getPhrase('homdom.search_form'); ?></div>
        <div class="a-block-body">
            <form action="" method="get">
                <div class="form-group mb-0">
                    <div class="cols w-mob">
                        <div class="col-item col-d">
                            <div class="form-input">
                                <input id="searchQuery" type="text" name="search[searchQuery]" placeholder="<?php echo AIN::getPhrase('homdom.search_query'); ?>" value="<?php $aParams = (isset($aParams) ? $aParams : AIN::getLib('request')->getArray('val')); echo (isset($aParams['searchQuery']) ? AIN::getLib('parse.output')->clean($aParams['searchQuery']) : (isset($this->_aVars['aForms']['searchQuery']) ? AIN::getLib('parse.output')->clean($this->_aVars['aForms']['searchQuery']) : '')); ?>
">
                            </div>
                        </div>

                        <div class="col-item col-d">
                            <div class="form-select">
                                <?php $languages = [
                                    "az" => "AZ", 'en' => 'EN', 'ru'=>"RU", 'tr' => 'TR'
                                ] ?>
                                <select class="select-ns select2-hidden-accessible" name="search[language_id]" id="status_id" onchange="this.form.submit()">
                                    <option value="0"> <?php echo AIN::getPhrase("homdom.all"); ?> </option>
<?php foreach ($languages as $k=>$v) { ?>
                                        <option value="<?=$k?>" <?= AIN::getService('homdom.helpers')->selected_exist($this->_aVars['aForms'], 'language_id', $k) ?> ><?=$v?></option>
<?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-item col-e">
                            <button type="submit" class="a-button b-orange b-block"><?php echo AIN::getPhrase('homdom.search'); ?></button>
                        </div>
                    </div>
                </div>
            
</form>

        </div>
    </div>

    <div class="a-block">
        <div class="a-block-head">
            <span class="breadcrumb-item active"><?php echo AIN::getPhrase("homdom.translations"); ?></span>
            <a href="<?php echo AIN::getLib('url')->makeUrl('translation.add'); ?>" class="a-button b-gr f-right with-icon add b-small"><i class="icon-add mr-1"></i><?php echo AIN::getPhrase('homdom.add'); ?></a>
        </div>
        <div class="a-block-body">
            <form action="<?php echo AIN::getLib('url')->makeUrl('translation.index'); ?>" method="POST" id="apanel_agency_add" enctype="multipart/form-data">
<?php $rows = $this->_aVars['rows']; ?>
                <div class="table-responsive">

                    <table class="table">
                        <thead>
                            <tr>
                                <th><?php echo AIN::getPhrase('homdom.key'); ?></th>
                                <th><?php echo AIN::getPhrase('homdom.language_id'); ?></th>
                                <th><?php echo AIN::getPhrase('homdom.module_id'); ?></th>
                                <th><?php echo AIN::getPhrase('homdom.text'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
<?php foreach ($rows as $row) { ?>
                                <tr>
                                    <td>
                                        <?= $row['var_name'] ?>
                                        <input value='<?=$row["var_name"]?>' name="val[<?=$row['phrase_id']?>][var_name]" type="hidden" placeholder="" >
                                    </td>
                                    <td>
                                        <?= $row['language_id'] ?>
                                        <input   value='<?=$row["language_id"]?>' name="val[<?=$row['phrase_id']?>][language_id]" type="hidden" placeholder="" >
                                    </td>
                                    <td>
                                        <?= $row['module_id'] ?>
                                        <input value='<?=$row["module_id"]?>' name="val[<?=$row['phrase_id']?>][module_id]" type="hidden" placeholder="" >
                                    </td>
                                    <td>
                                        <textarea style="width: 100%" name="val[<?=$row['phrase_id']?>][text]"><?=$row['text']?></textarea>
                                    </td>
                                </tr>
<?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="form-group mb-0 d-block" style="margin: 10px; margin-bottom: 20px">
                    <div class="f-button t-center">
                        <button class="b-green" type="submit"><?php echo AIN::getPhrase('homdom.submit'); ?></button>
                    </div>
                </div>
            
</form>

            <div style="margin-top: 20px">
<?php if (!isset($this->_aVars['aPager'])): AIN::getLib('pager')->set(array('page' => AIN::getLib('request')->getInt('page'), 'size' => AIN::getLib('search')->getDisplay(), 'count' => AIN::getLib('search')->getCount())); endif;  $this->getLayout('pager'); ?>
            </div>
        </div>
    </div>
</div>

