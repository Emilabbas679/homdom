<?php
$articles = $this->_aVars['articles'];
$categories = $this->_aVars['categories'];
?>
<main class="main">
    <div class="section_wrap wrap_journal">
        <div class="section_body">
            <div class="main_center">
                <div class="section_headers">
                    <h1 class="address_h">Jurnal </h1>
                    <ul class="hdr_menu  ">
                        <?php foreach ($categories as $cat) { ?>
                            <li> <a href="/journal/category/<?=$cat['slug']?>" class=""><?=AIN::getPhrase('homdom.'.$cat['phrase'])?></a> </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="grid_content">
                    <div id="post-area" class="grid">
                        <?php foreach ($articles as $a) { ?>
                        <div class="grid-item gr_padding">
                            <a href="/journal/<?=$a['slug']?>" class="grid_link">
                                <div class="grid_img">
                                    <img src="<?=$a['image']?>" alt="">
                                </div>
                                <div class="gr_news_content">
                                    <div class="nw_row">
                                        <div class="news_date_gr "><?=date("d.m.Y", strtotime($a['intime']))?> </div>
                                    </div>
                                    <div class="nw_row">
                                        <h3 class="news_head_gr ">
                                            <?=$a['title']?>
                                        </h3>
                                    </div>
                                    <div class="nw_row">
                                        <div class="news_short_info_gr ">
                                            <?=substr(strip_tags($a['text']), 0, 400)?>...
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php } ?>

                    </div>
                </div>
                {{ pager }}
            </div>
        </div>
    </div>
</main>