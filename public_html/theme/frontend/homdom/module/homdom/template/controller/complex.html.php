<?php $aForms = $this->_aVars['aForms'] ?>
<main class="main">
    <div class="section_wrap wrap_resident">

        <div class="section_body">
            <div class="main_center">
                <div class="section_headers">
                    <h1 class="address_h">{{phrase var='homdom.complexes'}} </h1>
                    <div class="agency_select_search">
                        <form action="" method="GET">
                            <div class="filter_top">
                                <div class="add_row">
                                    <div class="add_col col_5">
                                        <div class="add_col col_2 p_0">
                                            <div class="custom_select2">
                                                <select name="district_id" id="cities" >
                                                    <?php if (isset($aForms['district_id']) and $aForms['district_id'] != '' and $aForms['district_id'] != '0') {
                                                        $getDistrict = AIN::getService('homdom.helpers')->getDistrictById($aForms['district_id']);
                                                        if ($getDistrict){ ?>
                                                            <option value="<?=$aForms['district_id'] ?>"><?=AIN::getPhrase('homdom.'.$getDistrict['phrase'])?></option>
                                                        <?php }} ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="add_col col_2 p_0">
                                            <div class="angency_search">
                                                 <input type="text" name="searchQuery" value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms, 'searchQuery')?>" placeholder="{{phrase var='homdom.complex_name'}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add_col col_3">
                                        <div class="all_filter_min_max">
                                            <div class="filter_name add_col col_3 p_0">{{phrase var='homdom.qiymet_1_kv_m'}}</div>
                                            <div class="filter_m_inpt add_col col_5 p_0">
                                                <div class="add_inp_number">
                                                    <input type="text" name="min_price" value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms, 'min_price')?>" placeholder="{{ phrase var='homdom.min' }}" class="decimal" maxlength="12" >
                                                    <span class="clear_inp_val"></span>
                                                </div>
                                                <div class="add_inp_number">
                                                    <input type="text" name="max_price" value="<?= AIN::getService('homdom.helpers')->getValueOfInput($aForms, 'max_price')?>" placeholder="{{ phrase var='homdom.max' }}" class="decimal" maxlength="12" >
                                                    <span class="clear_inp_val"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="filter_footer">
                                <div class="filtr_submit">
                                    <button type="submit" class="prof_inf_submit">{{ phrase var='homdom.search' }} </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="resident_complex_container">

                    <div class="wrap_body">
                        <div class="wrap_owl">
                            <div class="res_row">
                                <?php foreach ($this->_aVars['complexes'] as $item) { ?>
                                <div class="res_items">
                                    <a href="/complex/<?=$item['slug']?>" class="res_items_link">
                                        <div class="res_img">
                                            <img class="lozad" src="/theme/frontend/homdom/style/img/loading.gif" data-src="<?=AIN::getService('homdom.helpers')->imageResize($item['cover_photo'], 720, 480)?>" alt="<?=$item['name']?>">
                                            <div class="res_text res_adrs_info"><?=$item['address']?> </div>
                                        </div>
                                        <div class="res_info">
                                            <div class="res_adrs"><?=$item['name']?></div>
                                            <div class="res_text"><?=($district = AIN::getService('homdom.helpers')->getDistrictById($item['district_id'])) ? AIN::getPhrase('homdom'.$district['phrase']) : '' ;?> </div>
                                            <div class="res_text"><?=$item['price']?> ₼ / {{ phrase var='homdom.kv_m_den' }} </div>
                                            <div class="res_text"><?=$item['built_year']?> </div>
                                        </div>
                                    </a>
                                </div>
                                <?php } ?>
                            </div>


                            {{pager}}
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


</main>

@section('js')
<script src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
<script>
    const observer = lozad();
    observer.observe();
</script>

<script>

    $('#cities').select2({
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
      