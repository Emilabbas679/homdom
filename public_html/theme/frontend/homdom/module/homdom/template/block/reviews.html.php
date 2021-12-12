<?php  $reviews = $this->_aVars['reviews'];?>
<?php foreach ($reviews as $item) { ?>
<li>
    <div class="vd_write_commt_users">
        <div class="comment-item ">
            <div class="vd_commt_row">
                <div class="ch-img">
                    <img src="<?=($item['user_image']) ? $item['user_image'] : AIN::getService('homdom.helpers')->defaultProfilePhoto()?>" alt="">
                </div>
                <div class="cmnt_name_date">
                    <div class="yr_cmt_title">
                        <?php if ($item['is_anonym'] != 1) {
                            if ($item['user_fullname'] != '')  { echo $item['user_fullname'];} elseif($item['full_name']) echo $item['full_name'];

                        }?>
                    </div>
                    <div class="yr_cmt_date"><?=date('d.m.Y', strtotime($item['intime']))?> </div>
                    <div class="report_icon"></div>
                </div>
            </div>
            <div class="vd_commt_row">
                <div class="reply_comnt_sect clearfix">
                    <form action="{{ url link='complex.review.add'}}" method="POST">
                        <input type="hidden"  name="val[complex_id]" value="<?=$item['entity_id']?>">
                        <input type="hidden"  name="val[review_id]" value="<?=$item['id']?>">


                        <div class="your_profile">
                            <div class="yr_pr_img">
                                <img src="<?=AIN::getService('homdom.helpers')->userProfilePhoto()?>" alt="">
                            </div>
                            <!-- <div class="yr_cmt_title">Your comment </div> -->
                            <input type="text" class="yr_cmt_title" name="val[full_name]" {{ if auth() }} disabled value="<?=AIN::getUserBy('full_name')?>"   {{ /if }} placeholder="{{ phrase var='homdom.name_placeholder' }}" >
                        </div>
                        <div class="yr_comnt_area clearfix">
                            <textarea name="val[content]"  placeholder="{{ phrase var='homdom.write_here'}}" class="your_comt_textare"></textarea>
                            <div class="your_cmnt_send">
                                <div class="yr_cmnt_bnts">
                                    <div class="lp-check">
                                        <label>
                                            <input type="checkbox" value="1" name="val[is_anonym]" class="agree">
                                            <span>{{ phrase var='homdom.send_anonym'}}</span>
                                        </label>
                                    </div>
                                    <button type="submit" class="send_your_cmnt">{{ phrase var='homdom.submit'}} </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="vd_commt_row">
                <div class="comment_text"><?=$item['content']?></div>
            </div>

        </div>

    </div>
    <?php
    $sComments = [];
    $subComments = AIN::sendApi('get_reviews', ['review_id' => $item['id'], 'status_id' => 11, 'limit'=> 100]);
    if (isset($subComments['data']) and isset($subComments['data']['rows']) and count($subComments['data']['rows']) > 0)
        $sComments = $subComments['data']['rows'];

    if (count($sComments) > 0 ){  ?>

        <ul class="under_comment_list">
            <?php foreach ($sComments as $sItem) { ?>
            <li>
                <div class="vd_write_commt_users">
                    <div class="comment-item ">
                        <div class="vd_commt_row">
                            <div class="ch-img">
                                <img src="<?=($sItem['user_image']) ? $sItem['user_image'] : AIN::getService('homdom.helpers')->defaultProfilePhoto()?>" alt="">
                            </div>
                            <div class="cmnt_name_date">
                                <div class="yr_cmt_title">
                                    <?php if ($sItem['is_anonym'] != 1) {
                                        if ($sItem['user_fullname'] != '')  { echo $sItem['user_fullname'];} elseif($sItem['full_name']) echo $sItem['full_name'];

                                    }?>
                                </div>
                                <div class="yr_cmt_date"><?=date('d.m.Y', strtotime($sItem['intime']))?> </div>
                            </div>
                        </div>
                        <div class="vd_commt_row">
                            <div class="comment_text"><?=$sItem['content']?></div>
                        </div>
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>

    <?php } ?>


</li>
<?php } ?>