<div class="content-inner">
    <div class="breadcrumb">
        <ul>
            <li><a href="https://www.admin.homdom.az?az">{{phrase var="homdom.home"}}</a></li>
            <li><a href="{{url link='complex.index'}}">{{phrase var="homdom.complexes"}}</a></li>
            <li><span>{{phrase var="homdom.blocks"}}</span></li>
        </ul>
    </div>


    <div class="a-block mb-20">
        <div class="a-block-head">{{phrase var='homdom.search_form'}}</div>
        <div class="a-block-body">
            <form action="" method="get">
                <div class="form-group mb-0">
                    <div class="cols w-mob">

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

                        <div class="col-item col-d">
                            <div class="form-select">
                                <?php $aForms = $this->_aVars['aForms'] ?>
                                <select class="select_2_autocomplete" name="val[complex_id]" id="complexes" style="width: 100%">
                                    <option value="0" selected> {{phrase var="homdom.all"}} </option>

                                    <?php if (isset($aForms['complex_id']) and $aForms['complex_id'] != '' and $aForms['complex_id'] != '0') {
                                        $getComplex = AIN::getService('homdom.helpers')->getComplexById($aForms['complex_id']);
                                        if ($getComplex){ ?>
                                            <option value="<?=$aForms['complex_id'] ?>" selected><?=$getComplex['name']?></option>
                                        <?php }} ?>
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
            <span class="breadcrumb-item active">{{phrase var="homdom.pages"}}</span>
            <a href="{{url link='complex.block.add'}}" class="a-button b-gr f-right with-icon add b-small"><i class="icon-add mr-1"></i>{{phrase var='homdom.add'}}</a>
        </div>
        <div class="a-block-body">
            {{template file='admincp.block.table'}}
        </div>
    </div>
</div>
@section('js')
<script>

    $('#complexes').select2({
        placeholder: "<?=AIN::getPhrase('homdom.select_complex')?>",
        language: {
            searching: function() {
                return "<?=AIN::getPhrase('homdom.searching')?>";
            }
        },
        ajax: {
            url: "/_ajax?core[ajax]=true&core[call]=homdom.searchComplex",
            data: function(params) {
                var query = {
                    search: params.term,
                    page: params.page || 1
                }
                return query;
            },
            delay: 600,
            cache: true
        }
    });
</script>

@endsection