<div class="content-inner">
    <div class="breadcrumb">
        <ul>
            <li><a href="https://www.admin.homdom.az/az">{{phrase var="homdom.home"}}</a></li>
            <li><span>{{phrase var="homdom.offers"}}</span></li>
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
                                <input id="searchQuery" type="text" name="val[searchQuery]" placeholder="{{phrase var='homdom.searchQuery'}}" value="{{value type='input' id='searchQuery'}}">
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
            <span class="breadcrumb-item active">{{phrase var="homdom.contacts"}}</span>
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