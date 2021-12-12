<?php
$article = $this->_aVars['article'];
$related_articles = $this->_aVars['related_articles'];
$categories = $this->_aVars['categories'];
$tags = $this->_aVars['tags'];
?>


<main class="main">
    <div class="section_wrap wrap_journal">
        <div class="section_body">
            <div class="main_center">
                <div class="section_headers">
                    <h1 class="address_h">{{phrase var='homdom.blog'}} </h1>
                    <ul class="hdr_menu">
                        <?php foreach ($categories as $cat) { ?>
                            <li> <a href="/journal/category/<?=$cat['slug']?>" class="<?php if($cat['id'] == $article['category_id']) {?> active <?php } ?>"><?=AIN::getPhrase('homdom.'.$cat['phrase'])?></a> </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="journal_inner_content">
                    <div class="journal_in_header">
                        <h1 class="jr_in_title">
                           <?=$article['title']?>
                        </h1>
                        <div class="jr_date_info"><?=date("d.m.Y", strtotime($article['intime']))?></div>
                    </div>
                    <div class="jr_image">
                        <img src="<?=$article['image']?>" alt="<?=$article['title']?>">
                    </div>
                    <div class="jr_inner_text">
                        <?=$article['text']?>
                    </div>
                    <div class="keywords_sect">
                        <div class="key_row">
                            <div class="key_name">{{phrase var='homdom.owner'}}:</div>
                            <div class="key_item">
                                <span><?=$article['user_name']?></span>
                            </div>
                        </div>
                        <div class="key_row">
                            <div class="key_name">{{phrase var='homdom.tags'}}:</div>
                            <div class="key_item">
                                <?php foreach ($tags as $t) { ?>
                                <a href="/journal/tag/<?=$t['slug']?>" class="keywords_tag"><?=$t['phrase']?></a>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                    <div class="sahre_sect">
                        <?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "https") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
                        <div class="share_head">Xəbəri paylaşın </div>
                        <div class="share_info">Oxuduğunuz xəbəri sosial şəbəkələrdə paylaşın </div>
                        <div class="share_icon_links">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?=$actual_link?>" target="_blank" rel="noopener noreferrer" class="share_icon icon_lnk_fb"><span></span></a>
                            <a href="fb-messenger://share/?link=<?=$actual_link?>" target="_blank" rel="noopener noreferrer" class="share_icon icon_lnk_ms"><span></span></a>
                            <a href="whatsapp://send?text=<?=$actual_link?>" target="_blank" rel="noopener noreferrer" class="share_icon icon_lnk_wp"><span></span></a>
                            <a href="https://twitter.com/intent/tweet?text=<?=$actual_link?>" target="_blank" rel="noopener noreferrer" class="share_icon icon_lnk_twt"><span></span></a>
                            <a href="https://telegram.me/share/url?url=<?=$actual_link?>" target="_blank" rel="noopener noreferrer" class="share_icon icon_lnk_tgm"><span></span></a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="section_wrap wrap_journal">
        <div class="section_body">
            <div class="main_center">
                <div class="section_headers">
                    <h1 class="address_h">{{phrase var='homdom.also_read'}} </h1>
                </div>
                <div class="grid_content">
                    <div class="grid">

                        <?php foreach ($related_articles as $a) { ?>
                        <div class="grid-item gr_padding">
                            <a href="" class="grid_link">
                                <div class="grid_img">
                                    <img src="<?=$a['image']?>" alt="">
                                </div>
                                <div class="gr_news_content">
                                    <div class="nw_row">
                                        <div class="news_date_gr "><?=date("d.m.Y", strtotime($article['intime']))?></div>
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

            </div>
        </div>
    </div>
</main>
