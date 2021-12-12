<div class="content-inner">
    <div class="breadcrumb">
        <ul>
            <li><a href="https://www.adserver.az?az">{{phrase var="homdom.home"}}</a></li>
            <li><span>{{phrase var="homdom.translations"}}</span></li>
        </ul>
    </div>


    <div class="a-block mb-20">
        <div class="a-block-head">{{phrase var='homdom.search_form'}}</div>
        <div class="a-block-body">
            <form action="" method="get">
                <div class="form-group mb-0">
                    <div class="cols w-mob">
                        <div class="col-item col-d">
                            <div class="form-input">
                                <input id="searchQuery" type="text" name="search[searchQuery]" placeholder="{{phrase var='homdom.search_query'}}" value="{{value type='input' id='searchQuery'}}">
                            </div>
                        </div>

                        <div class="col-item col-d">
                            <div class="form-select">
                                <?php $languages = [
                                    "az" => "AZ", 'en' => 'EN', 'ru'=>"RU", 'tr' => 'TR'
                                ] ?>
                                <select class="select-ns select2-hidden-accessible" name="search[language_id]" id="status_id" onchange="this.form.submit()">
                                    <option value="0"> {{phrase var="homdom.all"}} </option>
                                    <?php foreach ($languages as $k=>$v) { ?>
                                        <option value="<?=$k?>" <?= AIN::getService('homdom.helpers')->selected_exist($this->_aVars['aForms'], 'language_id', $k) ?> ><?=$v?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-item col-e">
                            <button type="submit" class="a-button b-orange b-block">{{phrase var='homdom.search'}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="a-block">
        <div class="a-block-head">
            <span class="breadcrumb-item active">{{phrase var="homdom.translations"}}</span>
            <a href="{{url link='translation.add'}}" class="a-button b-gr f-right with-icon add b-small"><i class="icon-add mr-1"></i>{{phrase var='homdom.add'}}</a>
        </div>
        <div class="a-block-body">
            <form action="{{url link='translation.index'}}" method="POST" id="apanel_agency_add" enctype="multipart/form-data">
                <?php $rows = $this->_aVars['rows']; ?>
                <div class="table-responsive">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ phrase var='homdom.key' }}</th>
                                <th>{{ phrase var='homdom.language_id' }}</th>
                                <th>{{ phrase var='homdom.module_id' }}</th>
                                <th>{{ phrase var='homdom.text' }}</th>
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
                        <button class="b-green" type="submit">{{phrase var='homdom.submit'}}</button>
                    </div>
                </div>
            </form>
            <div style="margin-top: 20px">
                {{ pager }}
            </div>
        </div>
    </div>
</div>
@section('js')
<script>


</script>

@endsection