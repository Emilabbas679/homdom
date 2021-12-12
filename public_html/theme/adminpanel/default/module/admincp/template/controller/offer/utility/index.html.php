<div class="content-inner">
    <div class="breadcrumb">
        <ul>
            <li><a href="https://www.adserver.az?az">{{phrase var="homdom.home"}}</a></li>
            <li><span>{{phrase var="homdom.utilities"}}</span></li>
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
                                <input id="searchQuery" type="text" name="val[searchQuery]" placeholder="{{phrase var='homdom.search_query'}}" value="{{value type='input' id='searchQuery'}}">
                            </div>
                        </div>

                        <div class="col-item col-d">
                            <div class="form-select">
                                <?php $statuses = AIN::getService('homdom.helpers')->getStatuses(); ?>
                                <select class="select-ns select2-hidden-accessible" name="val[status_id]" id="status_id" onchange="this.form.submit()">
                                    <option value="0"> {{phrase var="homdom.all"}} </option>
                                    <?php foreach ($statuses as $k=>$v) { ?>
                                        <option value="<?=$k?>" <?= AIN::getService('homdom.helpers')->selected_exist($this->_aVars['aForms'], 'status_id', $k) ?> ><?=$v?></option>
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
            <span class="breadcrumb-item active">{{phrase var="homdom.utilities"}}</span>
            <a href="{{url link='offer.utility.add'}}" class="a-button b-gr f-right with-icon add b-small"><i class="icon-add mr-1"></i>{{phrase var='homdom.add'}}</a>
        </div>
        <div class="a-block-body">
            {{template file='admincp.block.table'}}
        </div>
    </div>
</div>
@section('js')
<script>


</script>

@endsection