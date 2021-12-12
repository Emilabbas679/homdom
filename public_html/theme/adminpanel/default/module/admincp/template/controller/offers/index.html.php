@section('css')
<style>
    .match_sect {
        display: block;
        float: right;
        position: relative;
        margin: -5px 20px 0 0;
    }
    .match_btn {
        display: block;
        /* padding: 10px 12px; */
        font-size:15px;
        line-height:22px;
        padding: 3px 20px;
        height: 32px;
        border-radius:5px; 
        font-weight:500;
        color: #2196F3;
        background-color: rgb(33 150 243 / 10%);
        border: none;
        outline: none;
        cursor: pointer;
        transition: all 0.3s ease;
        -webkit-transition: all 0.3s ease;
        -moz-transition: all 0.3s ease;
        -ms-transition: all 0.3s ease;
        -o-transition: all 0.3s ease;
    }
    .match_btn:hover{background-color: rgb(33 150 243 / 80%);color: #fff}

    .match_links {
        display: none;
        position: absolute;
        top: 36px;
        right: 0;
        list-style: none;
        min-width: 110px;
        /* background-color: rgb(33 150 243 / 10%); */
        border: 1px solid #dbe2eb;
        background: #fff;
        z-index: 999;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -ms-border-radius: 5px;
        -o-border-radius: 5px;
    }
    .match_links li {
        display: block;
    }
    .match_links li a {
        display: block;
        padding: 7px 10px;
        color: #333;
        font-size: 14px;
        line-height: 18px;
        font-weight: normal;
        transition: all 0.3s ease;
        -webkit-transition: all 0.3s ease;
        -moz-transition: all 0.3s ease;
        -ms-transition: all 0.3s ease;
        -o-transition: all 0.3s ease;
    }
    .match_links li a:hover{background-color: #ebebeb;}
</style>
@endsection

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
            <?php $entry_count = AIN::getService('homdom.helpers')->getDefaultEntryCount() ?>
            <span class="breadcrumb-item active">{{phrase var="homdom.offers"}}

                Show
                <select id="entries">
                    <option value="10" <?=($entry_count == 10) ? 'selected' : ''?> >10</option>
                    <option value="25" <?=($entry_count == 25) ? 'selected' : ''?>>25</option>
                    <option value="50" <?=($entry_count == 50) ? 'selected' : ''?>>50</option>
                    <option value="100" <?=($entry_count == 100) ? 'selected' : ''?>>100</option>
                    <option value="250" <?=($entry_count == 250) ? 'selected' : ''?>>250</option>
                </select>
                Entries

            </span>
            <a href="{{url link='offers.add'}}" class="a-button b-gr f-right with-icon add b-small"><i class="icon-add mr-1"></i>{{phrase var='homdom.add'}}</a>
            <div class="match_sect">
                <form action="{{ url link='offers.mass' }}">
                    <div id="mass_ids">

                    </div>
                    <button class="match_btn" style="display: none" type="submit">Mass </button>
<!--                    <ul class="match_links">-->
<!--                        <li><a href="">link1</a> </li>-->
<!--                        <li><a href="">link1</a> </li>-->
<!--                        <li><a href="">link1</a> </li>-->
<!--                    </ul>-->
                </form>

            </div> 
        </div>
        <div class="a-block-body">

            {{if isset($aTables.tbody) and count($aTables.tbody) > 0 }}
            <div class="table-responsive">
                <table class="table">
                    {{if isset($aTables.thead)}}
                    <thead>
                    <tr>
                        {{foreach from=$aTables.thead key=tHeadId item=tHead}}
                        <th>{{$tHead}}</th>
                        {{/foreach}}
                    </tr>
                    </thead>
                    {{/if}}
                    {{if isset($aTables.tbody)}}
                    <tbody>
                    {{foreach from=$aTables.tbody key=tBodyId item=tbody}}
                    <tr>
                        {{foreach from=$tbody key=tId item=tbodyRow}}

                        {{if gettype($tbodyRow) == 'array'}}
                        <td>
                            <div class="tools"></div>
                            <div class="tools-list multi">
                                <ul>
                                    {{foreach from=$tbodyRow key=tId2 item=tbodyRow2}}
                                    {{$tbodyRow2}}
                                    {{/foreach}}
                                </ul>
                            </div>
                        </td>
                        {{else}}

                        <td>
                            {{ if $tId == 'ID' }}
                            <input type="checkbox" class="offer_ids" value="{{$tbodyRow}}" id="id_{{$tbodyRow}}">
                            <label for="id_{{$tbodyRow}}" style="cursor: pointer">{{$tbodyRow}}</label>

                            {{ else }}
                                {{$tbodyRow}}
                            {{/if}}
                        </td>
                        {{/if}}
                        {{/foreach}}
                    </tr>
                    {{/foreach}}
                    </tbody>
                    {{/if}}
                    {{if isset($aTables.tfoot)}}
                    <tfoot>
                    <tr>
                        {{foreach from=$aTables.tfoot key=tId item=tfoot}}
                        <th>{{$tfoot}}</th>
                        {{/foreach}}
                    </tr>
                    </tfoot>
                    {{/if}}
                </table>
            </div>
            {{else}}
            <div class="alert alert-warning alert-styled-right alert-dismissible">
                {{phrase var='adnetwork.error_empty_anythings'}}
            </div>
            {{/if}}
            {{if isset($datatable.script)}} {{$datatable.script}}{{/if}}
            {{pager}}

        </div>
    </div>
</div>

@section('js')

<script>
    $(".match_btn").click(function(e) {
        e.stopPropagation();
        $(this).siblings(".match_links").slideToggle();
    });
    $("body").click(function() {
        $(".match_links").slideUp();
    });
    $(".match_links").click(function(e) {
        e.stopPropagation();
    });

    $(".offer_ids").change(function (){
        var sList = [];
        $('input[type=checkbox]').each(function () {
            if (this.checked){
                sList.push($(this).val())
            }
        });
        addIdsToForm(sList);
    })

    function addIdsToForm(sList)
    {
        $('#mass_ids').html('')
        if (sList.length > 0) {
            $('.match_btn').show();
        }
        else{
            $('.match_btn').hide();
        }
        for (let i=0; i<sList.length; i++){
            $("#mass_ids").append('<input type="hidden" name="offer_ids[]" value="'+sList[i]+'">')
        }


    }

    $('#entries').change(function (){
      let entryId = $(this).val();
        $.ajax({
            url: "/_ajax?core[ajax]=true&core[call]=homdom.SetDefaultEntryCount",
            data: {'entry_id': entryId, 'user_id': "<?=AIN::getService('homdom.user')->getUserBy('user_id')?>"},
            success: function (data) {
                location.reload()
            }
        });

    })

</script> 
 
@endsection