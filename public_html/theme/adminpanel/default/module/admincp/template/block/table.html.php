
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
            <td>{{$tbodyRow}}</td>
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
