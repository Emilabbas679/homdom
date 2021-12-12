<div class="content-inner">
    <div class="breadcrumb">
        <ul>
            <li><a href="{{url link='dashboard.index'}}">Homdom</a></li>
            <li><a href="{{url link='agency.index'}}">{{phrase var='homdom.agencies'}}</a></li>
            <li><span>{{phrase var='homdom.agency_add'}}</span></li>
        </ul>
    </div>
    <div class="a-block a-center">
        <div class="a-block-head">{{phrase var='homdom.agency_add'}}</div>
        <div class="a-block-body">
            <div class="form form-horizontal result">
                {{error}}
                <form action="{{url link='agency.add' id=$aForms.id}}" method="POST" id="apanel_agency_add" enctype="multipart/form-data">
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


