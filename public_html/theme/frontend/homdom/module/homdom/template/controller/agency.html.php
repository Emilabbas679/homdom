<?php $agencies = $this->_aVars['agencies'] ?>
<main class="main">
    <div class="section_wrap wrap_agency">
        <div class="section_body">
            <div class="main_center">
                <div class="section_headers">
                    <h1 class="address_h">{{phrase var='homdom.agencies'}} </h1>
                    <div class="agency_select_search">
                        <form action="" method="GET">
                            <div class="ag_custom_slct">
                                <div class="custom_select">
                                    <select name="val[agency_type]" id="" class="select-regist">
                                        <option value="0" <?= AIN::getService('homdom.helpers')->selected_exist($this->_aVars['aForms'], 'agency_type', 0) ?>>{{phrase var='homdom.all'}}</option>
                                        <option value="1" <?= AIN::getService('homdom.helpers')->selected_exist($this->_aVars['aForms'], 'agency_type', 1) ?>>{{phrase var='homdom.agency_type_1'}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="angency_search">
                                <input type="text" name="val[searchQuery]" id="" value="{{value type='input' id='searchQuery'}}" placeholder="{{ phrase var='homdom.agency_search' }}">
                            </div>
                            <button type="submit" class="ag_src_btn">{{phrase var='homdom.search'}} </button>
                        </form>
                    </div>
                </div>
                <div class="agency_items">

                    <?php foreach ($agencies as $a) { ?>
                    <a href="/agency-in/<?=$a['slug']?>" class="ag_link">
                        <div class="ag_img">
                            <img src="<?=$a['image']?>" alt="">
                        </div>
                        <div class="ag_info">
                            <div class="ag_row">
                                <div class="ag_head">
                                    <div class="ag_adrs"><?=$a['title']?> </div>
                                    <div class="ag_text"><?=AIN::getPhrase('homdom.agency_type_'.$a['agency_type'])?> </div>
                                </div>
                                <div class="ag_catg" style="display:none;">4727 obyekt</div>
                            </div>
                            <div class="ag_row">
                                <div class="ag_price"><?=substr(strip_tags($a['description']),0,300)?>... </div>
                            </div>
                        </div>
                    </a>
                    <?php } ?>
                </div>
                {{ pager }}
            </div>
        </div>
    </div>


</main>
      