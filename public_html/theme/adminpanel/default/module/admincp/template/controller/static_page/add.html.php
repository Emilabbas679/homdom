<div class="content-inner">
    <div class="breadcrumb">
        <ul>
            <li><a href="{{url link='dashboard.index'}}">Homdom</a></li>
            <li><a href="{{url link='static_page.index'}}">{{phrase var='homdom.pages'}}</a></li>
            <li><span>{{phrase var='homdom.add'}}</span></li>
        </ul>
    </div>
    <div class="a-block a-center">
        <div class="a-block-head">{{phrase var='homdom.add'}}</div>
        <div class="a-block-body">
            <div class="form form-horizontal result">
                {{error}}
                <form action="{{url link='static_page.add' id=$aForms.id}}" method="POST" id="apanel_agency_add" enctype="multipart/form-data">
                    {{foreach from=$aTableForm key=Ikey item=aEditForm}}
                    {{template file='admincp.block.form'}}
                    {{/foreach}}
                    <div class="form-group mb-0 d-block">
                        <div class="f-button t-center">
                            <button class="b-green" type="submit">{{phrase var='homdom.submit'}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('js')

<script>
    $("#district_id").removeClass("select-ns");
    $('#district_id').select2({
        placeholder: "<?=AIN::getPhrase('homdom.select_city')?>",
        language: {
            searching: function() {
                return "<?=AIN::getPhrase('homdom.searching')?>";
            }
        },
        ajax: {
            url: "/_ajax?core[ajax]=true&core[call]=homdom.searchDistrict",
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


@section('css')
<style>
    .content{
        min-height: 500px !important;
    }
</style>
@endsection