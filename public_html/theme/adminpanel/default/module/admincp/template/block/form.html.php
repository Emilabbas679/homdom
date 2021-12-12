
{{foreach from=$aEditForm.data item=aData}}

{{if $aData.type == 'input:hidden'}}
<input type="hidden" id="{{$aData.id}}" placeholder="{{$aData.title}}" name="val[{{$aData.id}}]" value='{{$aData.value}}'>

{{elseif $aData.type == 'input:text'}}
<div class="form-group {{$aData.class}}" id="adJs{{$aData.id}}">
    <label class="form-label" for="u-number">{{if isset($aData.required) && $aData.required}}{{required}}{{/if}}{{$aData.title}}</label>
    <div class="form-input">
        <input id="{{$aData.id}}" class="{{$aData.class}}" value='{{$aData.value}}' name="val[{{$aData.id}}]" type="text" placeholder="{{$aData.title}}">
    </div>
</div>
{{elseif $aData.type == 'input:number'}}
<div class="form-group {{$aData.class}}" id="adJs{{$aData.id}}">
    <label class="form-label" for="u-number">{{if isset($aData.required) && $aData.required}}{{required}}{{/if}}{{$aData.title}}</label>
    <div class="form-input">
        <input id="{{$aData.id}}" class="{{$aData.class}}" value='{{$aData.value}}' name="val[{{$aData.id}}]" type="number" placeholder="{{$aData.title}}">
    </div>
</div>

{{elseif $aData.type == 'input:date'}}
<div class="form-group">
    <label class="form-label" for="u-number">{{if isset($aData.required) && $aData.required}}{{required}}{{/if}}{{$aData.title}}</label>
    <div class="form-input">
        <input id="{{$aData.id}}" class="{{$aData.class}}" value='{{$aData.value}}' name="val[{{$aData.id}}]" type="date" placeholder="{{$aData.title}}">
    </div>
</div>
{{elseif $aData.type == 'input:time'}}
<div class="form-group">
    <label class="form-label" for="u-number">{{if isset($aData.required) && $aData.required}}{{required}}{{/if}}{{$aData.title}}</label>
    <div class="form-input">
        <input id="{{$aData.id}}" class="{{$aData.class}}" value='{{$aData.value}}' name="val[{{$aData.id}}]" type="time" placeholder="{{$aData.title}}">
    </div>
</div>

{{elseif $aData.type == 'input:dropify'}}

<div class="form-group">
    <label class="form-label" for="u-number">{{if isset($aData.required) && $aData.required}}{{required}}{{/if}}{{$aData.title}}</label>
    <div class="form-input">
        <input id="{{$aData.id}}" type="file" class="{{$aData.class}}" value='{{$aData.value}}' name="{{$aData.id}}" data-default-file="{{$aData.value}}" placeholder="{{$aData.title}}">
    </div>
</div>


{{elseif $aData.type == 'input:email'}}
<div class="form-group">
    <label class="form-label" for="u-number">{{if isset($aData.required) && $aData.required}}{{required}}{{/if}}{{$aData.title}}</label>
    <div class="form-input">
        <input id="{{$aData.id}}" class="{{$aData.class}}" value='{{$aData.value}}' name="val[{{$aData.id}}]" type="text" placeholder="{{$aData.title}}" readonly>
    </div>
</div>

{{elseif $aData.type == 'input:staff_search'}}
<div class="form-group">
    <label class="form-label" for="u-number">{{if isset($aData.required) && $aData.required}}{{required}}{{/if}}{{$aData.title}}</label>
    <div class="form-input">
        <div class="col-right">
            <button class="b-scn a-button" type="submit">{{phrase var='adnetwork.staff_search'}}</button>
        </div>
        <div class="col-fr">
            <input id="u-number" value='{{$aData.value}}' name="val[{{$aData.id}}]" type="text" placeholder="{{$aData.title}}">
        </div>
    </div>
</div>

{{elseif $aData.type == 'input:full_name'}}
<div class="form-group">
    <label class="form-label" for="l-name">{{if isset($aData.required) && $aData.required}}{{required}}{{/if}}{{$aData.title}}</label>
    <div class="form-input">
        <div class="cols">
            <div class="col-item col-b">
                <input id="lastname" name="val[lastname]" value='{{$aData.lastname}}' type="text" placeholder="{{phrase var='adnetwork.lastname'}}">
            </div>
            <div class="col-item col-b">
                <input id="firstname" type="text" name="val[firstname]" value='{{$aData.firstname}}' placeholder="{{phrase var='adnetwork.firstname'}}">
            </div>
            <div class="col-item col-b">
                <input id="fathername" type="text" name="val[fathername]" value='{{$aData.fathername}}' placeholder="{{phrase var='adnetwork.fathername'}}">
            </div>
        </div>
    </div>
</div>

{{elseif $aData.type == 'select'}}
<div class="form-group" id="adJs{{$aData.id}}" >
    <label class="form-label" for="{{$aData.id_css}}">{{$aData.title}} {{required}}</label>
    <div class="form-select">
        <select class="select-ns" style="width: 100% !important;" name="val[{{$aData.id}}]"  id="{{$aData.id_css}}" {{if isset($aData.disabled) and $aData.disabled == true}}disabled{{/if}}>
        {{foreach from=$aData.options key=sOptionValue item=sOptionTitle}}
        <option value="{{$sOptionValue}}" {{if $sOptionValue == $aData.value}} selected="selected"{{/if}} >{{ $sOptionTitle }}</option>
        {{/foreach}}
        </select>
    </div>
</div>


{{elseif $aData.type == 'select2:multiple'}}
<div class="form-group" id="adJs{{$aData.id}}" >
    <label class="form-label" for="{{$aData.id_css}}">{{$aData.title}} {{required}}</label>
    <div class="form-select">
        <select  data-select2-tags="true" class="select2" style="width: 100%" multiple name="val[{{$aData.id}}][]"  id="{{$aData.id_css}}" {{if isset($aData.disabled) and $aData.disabled == true}}disabled{{/if}}>
        {{foreach from=$aData.options key=sOptionValue item=sOptionTitle}}
            <option value="{{$sOptionValue}}"   selected="selected " >{{ $sOptionTitle }}</option>
        {{/foreach}}
        </select>
    </div>
</div>



{{elseif $aData.type == 'input:checkbox'}}
<div class="form-group" id="adJs{{$aData.id}}" >
    <label class="form-label" for="{{$aData.id_css}}">{{$aData.title}} {{required}}</label>
    <div class="form-select" id="{{$aData.id_css}}">
        {{foreach from=$aData.options key=sOptionValue item=sOptionTitle}}

        <div class="chb">
            <input type="checkbox" name="val[{{$aData.id}}][{{$sOptionValue}}]" value="{{$sOptionValue}}" id="{{$aData.id_css}}{{$sOptionValue}}" {{ if in_array($sOptionValue, $aData.value )  }} checked {{/if}}>
            <label for="{{$aData.id_css}}{{$sOptionValue}}">{{$sOptionTitle}}</label>

        </div>
        {{/foreach}}
    </div>
</div>



{{elseif $aData.type == 'select_search'}}
<div class="form-group">
    <label class="form-label" for="company">{{$aData.title}} {{required}}</label>
    <div class="form-select">
        <select  class="select-ns" name="user_id" id="users" style="width: 100%"  data-live-search="true">

        </select>
    </div>
</div>


{{elseif $aData.type == 'numselectmix'}}
<div class="form-group {{$aData.class}}" id="adJs{{$aData.id}}" {{if isset($aData.display)}} style="display: none;" {{/if}}>
<label class="form-label" id="adJs{{$aData.id}}label">{{if isset($aData.required) && $aData.required}}{{required}}{{/if}}{{$aData.title}}</label>
<div class="cols">
    <div class="col-item col-a mxw-250">
        <div class="form-select ">
            <select class="select-ns" name="val[{{$aData.id}}]" data-placeholder="Şirkət seçin" id="{{$aData.id}}" {{if isset($aData.disabled) and $aData.disabled == true}}disabled{{/if}}>
            {{foreach from=$aData.options key=sOptionValue item=sOptionTitle}}
            <option value="{{$sOptionValue}}"{{if $sOptionValue == $sOptionValue}} selected="selected"{{/if}}>{{$sOptionTitle}}</option>
            {{/foreach}}
            </select>
        </div>
    </div>
    <div class="col-item col-a mxw-250">
        <div class="form-input">
            <input type="number" id="budget_planned"  name="val[budget_planned]" value='{{$aData.budget_planned}}' {{if isset($aData.disabled) and $aData.disabled == true}}readonly{{/if}}>
        </div>
    </div>
</div>
</div>

{{ elseif $aData.type == 'translatable' }}
<div class="form-group">
    <label class="form-label" for="{{$aData.id}}">{{if isset($aData.required) && $aData.required}}{{required}}{{/if}}{{$aData.title}}</label>
    <?php $i = 1; ?>
    <div class="form-input">
        <div class="tab">
            {{foreach from=$aData.languages key=sOptionValue item=sOptionTitle}}
            <button class="tablinks tablinks-<?=$this->_aVars['aData']['id']?> <?php if ($i==1) echo 'active'?>" type="button" onclick='openTab(event, "<?=$this->_aVars['aData']['id']?>.<?=$this->_aVars['sOptionTitle']?>")'>{{ $sOptionTitle }}</button>
            <?php $i ++; ?>
            {{/foreach}}
        </div>

        <?php $i = 1; ?>
        {{foreach from=$aData.languages key=sOptionValue item=sOptionTitle}}
        <div id="<?=$this->_aVars['aData']['id']?>.<?=$this->_aVars['sOptionTitle']?>" class="tabcontent tabcontent-<?=$this->_aVars['aData']['id']?>" style=" <?php if ($i==1) echo 'display:block'?>">
            <textarea style="resize: none" class="{{$aData.class}}"  name="val[{{$aData.id}}][<?=$this->_aVars['sOptionTitle']?>]" placeholder="{{$aData.title}}--{{ $sOptionTitle }}"  data-sample-short ><?=$this->_aVars['aData']['value'][$this->_aVars['sOptionTitle']]?></textarea>
        </div>
        <?php $i ++; ?>
        {{/foreach}}
    </div>


</div>


{{elseif $aData.type == 'selectmultiplebs'}}
<div class="form-group">
    <label class="form-label" for="{{$aData.id}}">{{if isset($aData.required) && $aData.required}}{{required}}{{/if}}{{$aData.title}}</label>
    <div class="form-select">
        <select class="{{$aData.class}}" name="val[{{$aData.id}}][]" id="{{$aData.id}}" multiple="" size="3" style="display: none;"  {{if isset($aData.disabled) and $aData.disabled == true}}disabled{{/if}}>
        {{foreach from=$aData.options key=sOptionValue item=sOptionTitle}}
        <option value="{{$sOptionValue}}" {{if in_array($sOptionValue, $aData.value) }} selected="selected" {{/if}}>{{$sOptionTitle}}</option>
        {{/foreach}}
        </select>
    </div>
</div>

{{elseif $aData.type == 'plan'}}
<div class="form-group">
    <label class="form-label" for="{{$aData.id}}" >{{if isset($aData.required) && $aData.required}}{{required}}{{/if}}{{$aData.title}}</label>
    <div class="cols">
        <div class="col-item col-a">
            <div class="form-input f-calendar">
                <input id='{{$aData.id}}' placeholder="Tarix" name="val[{{$aData.id}}]" value="{{$aData.day}}"  type="text" data-toggle="datepicker">
                <i></i>
            </div>
        </div>
        <div class="col-item col-a">
            <div class="form-input f-time">
                <input type="text"  type="time" name="val[{{$aData.id}}_time]" class="bs-timepicker" id="{{$aData.id}}_time" value="{{$aData.time}}" {{if isset($aData.readonly) and $aData.readonly == true}}readonly{{/if}}>
                <i></i>
            </div>
        </div>
    </div>
</div>
{{if ! isset($aData.readonly) or $aData.readonly == false }}
<script>
    $Behavior.loadAdPage{{$aData.id}} = function()
    {{l}}
    var dateToday{{$aData.id}} = new Date();
    // Accessibility labels
    $('#{{$aData.id}}').datepicker({{l}}
    language: 'az',
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        minDate: dateToday{{$aData.id}}
    {{r}});
    {{r}}
</script>
{{/if}}

{{elseif $aData.type == 'tags'}}
<div class="form-group">
    <label class="form-label" for="{{$aData.id}}">{{if isset($aData.required) && $aData.required}}{{required}}{{/if}}{{$aData.title}}</label>
    <div class="form-input">
        <input id="{{$aData.id}}" class="{{$aData.class}}" name="val[{{$aData.id}}]" type="text" value="{{$aData.value}}" placeholder="{{$aData.title}}">
    </div>
</div>

{{elseif $aData.type == 'advert_file'}}
<div class="form-group" id="adJsqqfile">
    <label class="form-label">File</label>
    <div class="form-input">
        <input type="file" class="filepond" name="filepond"/>
        {{if isset($aData.value) and count($aData.value) > 0 }}
        <div class="filepond-a">
            {{foreach from=$aData.value item=ff}}
            {{if isset($ff.type) }}
            {{if str_contains($ff.type, "image") }}
            <div class="fp-wrap"><img src="{{$ff.dir_url}}" alt="" id="filepond_file"></div>
            {{elseif str_contains($ff.type, "video") }}
            <div class="fp-wrap">
                <video width="400" controls  id="filepond_file" style="width: 100%">
                    <source src="{{$ff.dir_url}}" type="video/mp4">
                </video>
            </div>
            <span class="file-delete" data-filename-url="{{$ff.dir_path}}{{$ff.name_path}}"></span>

            {{/if}}
            {{/if}}
            {{/foreach}}
        </div>
        {{/if}}

    </div>
</div>
{{elseif $aData.type == 'input:textarea'}}
<div class="form-group {{$aData.class}}" id="adJs{{$aData.id}}">
    <label class="form-label">{{$aData.title}}</label>
    <div class="form-input">
        <textarea  id="{{$aData.class}}" name="val[{{$aData.id}}]" placeholder="{{$aData.title}}"  data-sample-short >{{$aData.value}}</textarea>
<!--        <input type="text" name="val[{{$aData.id}}]" >-->
    </div>
</div>

{{elseif $aData.type == 'bid'}}
<div class="form-group  {{$aData.class}}" id="adJs{{$aData.id}}">
    <label class="form-label">{{$aData.title}}</label>
    <div class="f-tbl">
        <div class="cols">
            <div class="col-item col-b">
                <div class="form-input d-block in-left">
                    <span class="in-group">{{phrase var='adnetwork.unit_cost_min'}}</span>
                    <div class="in-input">
                        <input type="text" name="val[unit_cost_min]" value="{{if isset($aData.unit_cost_min)}}{{$aData.unit_cost_min}}{{/if}}" {{if isset($aData.max_val)}} max="{{$aData.max_val}}" {{/if}} {{if isset($aData.min_val)}} min="{{$aData.min_val}}" {{/if}}>
                    </div>
                </div>
            </div>
            <div class="col-item col-b">
                <div class="form-input d-block in-left">
                    <span class="in-group">{{phrase var='adnetwork.unit_cost_max'}}</span>
                    <div class="in-input">
                        <input type="text" name="val[unit_cost_max]" value="{{if isset($aData.unit_cost_max)}}{{$aData.unit_cost_max}}{{/if}}" {{if isset($aData.max_val)}} max="{{$aData.max_val}}" {{/if}} {{if isset($aData.min_val)}} min="{{$aData.min_val}}" {{/if}}>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{elseif $aData.type == 'week_day_hours'}}
<div class="form-group" {{if isset($aData.display)}} style="display: none;" {{/if}}>
<label class="form-label">{{$aData.title}}</label>
<div class="form-select">
    <select class="select-ns" id="{{$aData.type}}_level" name="val[{{$aData.id}}_level]" id="{{$aData.id}}" {{if isset($aData.disabled) and $aData.disabled == true}}disabled{{/if}}>
    {{foreach from=$aData.select_options key=sOptionValue item=sOptionTitle}}
    <option value="{{$sOptionValue}}"{{if $sOptionValue == $aData.select_value}} selected="selected"{{/if}}>{{$sOptionTitle}}</option>
    {{/foreach}}
    </select>
    <div class="wkd">
        <div class="h-target" id="week_day_hours_target" style="">
            <div class="h-target-wrap">
                <div class="h-target-top">
                    <ul>
                        <li class="h-day"></li>
                        <li>00:00</li>
                        <li>03:00</li>
                        <li>06:00</li>
                        <li>09:00</li>
                        <li>12:00</li>
                        <li>15:00</li>
                        <li>18:00</li>
                        <li>21:00</li>
                    </ul>
                </div>
                <div class="h-target-a">
                    {{foreach from=$aData.options key=day item=rows}}
                    <ul>
                        <li class="h-day dy-name">{{$day}}</li>
                        <li>
                            {{foreach from=$rows key=hour item=hrow name=hourNum}}
                            {{if is_int($AIN.iteration.hourNum/3) and $hour < 23 }}
                        </li> <li>
                            {{/if}}
                            <span>
                                             <input id="d{{$hrow.id}}" type="checkbox" name="val[{{$aData.id}}][{{$hrow.id}}]" value="{{$hrow.id}}" {{if in_array($hrow.id, $aData.value) }} checked="checked" {{/if}}>
                                             <label for="d{{$hrow.id}}" title="{{$day}} {{$hrow.title}}"></label>
                                            </span>
                            {{/foreach}}
                        </li>
                    </ul>
                    {{/foreach}}
                </div>

            </div>
        </div>
    </div>
</div>
</div>


{{elseif $aData.type == 'targeting'}}
<div class="form-group d-block">
    <div class="form-select mt-30 d-block">
        <select class="select-ns" name="val[{{$aData.id}}]" id="{{$aData.id}}">
            {{foreach from=$aData.options key=sOptionValue item=sOptionTitle}}
            <option value="{{$sOptionValue}}"{{if $sOptionValue == $aData.value}} selected="selected"{{/if}}>{{$sOptionTitle}}</option>
            {{/foreach}}
        </select>
    </div>
</div>

{{elseif $aData.type == 'sites'}}
<div class="h-block">
    <div class="alert alert-info">
        <button type="button" class="a-close"></button>
        <strong>{{$aData.title}}</strong>
    </div>

    <div class="form-group">
        <label class="form-label">{{if isset($aData.required) && $aData.required}}{{required}}{{/if}}{{$aData.title}}</label>
        <div class="f-tbl">
            <div class="form-select d-block">
                <select class="select-tag sites" name="sites[]" multiple="multiple" style="width: 100%">

                </select>
            </div>
            <span class="badge badge-z mt-5 mbtn" data-target="#websites">{{phrase var='adnetwork.website_list'}}</span>
        </div>
    </div>
</div>


{{elseif $aData.type == 'frequency'}}
<div class="h-block" {{if isset($aData.display)}} style="display: none;" {{/if}}>
<div class="form-group">
    <label class="form-label">{{$aData.title}}</label>
    <div class="form-input">
        <div class="switch-wrap">
            <div class="switch-button">
                <input id="status" name="val[frequency]" value="1" type="checkbox" {{if isset($aData.frequency) and $aData.frequency > 0 }}checked{{/if}}>
                <label for="status"></label>
            </div>
        </div>

        <div class="fq-section" {{if isset($aData.frequency) and $aData.frequency > 0}} style="display: block;" {{else}} style="display: none;" {{/if}}>
            <div class="form-input">
                <input placeholder="Sayı" name="val[frequency_capping]" value="{{$aData.frequency_capping}}" type="text">
            </div>
            <div class="form-select d-block in-left">
                <span class="in-group">{{phrase var='adnetwork.impression'}}</span>
                <div class="in-input">
                    <select class="select-ns" name="val[frequency_period]" id="frequency_period" >
                        {{foreach from=$aData.frequency_period_list key=sOptionValue item=sOptionTitle}}
                        <option value="{{$sOptionValue}}"{{if $sOptionValue == $aData.frequency_period}} selected="selected"{{/if}}>{{$sOptionTitle}}</option>
                        {{/foreach}}
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
{{else}}
<div class="form-group" id="adJs{{$aData.id}}">
    <label class="form-label">{{phrase var='adnetwork.campaign_name'}} {{required}}</label>
    <div class="col-lg-9">
        <input type="hidden" name="val[campaign_id]" value="{{value id='campaign_id' type='input'}}">
        <input type="text" name="val[campaign_name]" value="{{$aForms.campaign_name}}" class="form-control" readonly="" value="read only">
    </div>
</div>
{{/if}}
{{/foreach}}


