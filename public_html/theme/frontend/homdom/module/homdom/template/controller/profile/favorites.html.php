<main class="main">

    <div class="section_wrap wrap_my_annouce">

        <div class="my_anc_menu">
            {{template file='homdom.block.profile_header'}}
        </div>

        <div class="section_body">
            <div class="main_center">
                <div class="my_anc_items">
                    <?php foreach ($this->_aVars['items'] as $item) { ?>

                    <?php $offer = AIN::getService('homdom.helpers')->getOfferById($item['offer_id']); ?>



                    <div class="my_anc_slide_info_item ">
                        <div class="my_left">
                            <div class="my_anc_img_slider">
                                <div class="owl-carousel owl-theme">
                                    <?php foreach ($offer['image'] as $img) { ?>
                                            <div class="item">
                                                <a href="/offer/<?=$item['offer_id']?>">
                                                    <div class="my_anc_img">
                                                        <img src="<?=$img?>" alt="">
                                                    </div>
                                                </a>
                                            </div>
                                        <?php } ?>
                                </div>

                            </div>
                            <div class="my_anc_info click_vip">
                                <div class="my_anc_row">
                                    <div class="my_anc_adrs"> <?=AIN::getService('homdom.helpers')->getOfferTitle($offer)?></div>
                                </div>
                                <div class="my_anc_row">
                                    <div class="my_anc_text"><?=$offer['address_detail']?> </div>
                                </div>
                                <div class="my_anc_row">
                                    <div class="my_anc_price"><?=$offer['description']?></div>
                                </div>
                                <div class="my_anc_row">
                                    <div class="show_number">
                                        <div class="current_show_num">{{ phrase var='homdom.show_number' }}</div>
                                        <div class="current_show_num_info">
                                            <div class="currnt_num"><?php if($offer['user_phone'] != null ) echo '+'.$offer['user_phone']; else echo '+994'.$offer['phone'] ?></div>
                                        </div>
                                    </div>
                                    <button type="button" class="selected_togle active favority" data-offer-id="<?=$offer['id']?>">
                                        <div class="chosed_info_span">
                                            <span class="selct_th">{{phrase var='homdom.selected'}}</span>
                                            <span class="no_selct_th">{{phrase var='homdom.add_to_favorites'}}</span>
                                            <span class="hov_selct_th">{{phrase var='homdom.remove_from_favorites'}}</span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="my_right">
                            <div class="my_anc_row">
                                <div class="my_h_price"><?=$offer['price']?> ₼</div>
                            </div>
<!--                            <div class="my_anc_row">-->
<!--                                <div class="my_h_info">1750 ₼ / m² </div>-->
<!--                            </div>-->
                            <div class="my_anc_row">
                                <div class="my_h_info"><?=AIN::getPhrase('homdom.bill_of_sale_'.$offer['bill_of_sale'])?> </div>
                            </div>
<!--                            <div class="my_anc_row">-->
<!--                                <div class="my_h_info">12/18 mərtəbə </div>-->
<!--                            </div>-->
                            <div class="my_anc_row">
                                <div class="my_h_recomd">Tövsiyə edirik! </div>
                            </div>
                            <div class="my_anc_row">
                                <div class="my_h_date"> <?=AIN::getService('homdom.helpers')->CalculateDate($offer['intime'])?> </div>
                            </div>
                        </div>

                    </div>
                    <?php } ?>
                </div>


                {{ pager }}


            </div>
        </div>
    </div>


</main>

@section('js')
<script>
    $(".favority").click(function (){
        let type = 'delete';
        let offerId = $(this).attr('data-offer-id');
        if ($(this).hasClass('active')){
            type = 'delete';
        }
        else {
            type = 'add'
        }
        $.ajax({
            type: "POST",
            data: {
                'type' : type,
                'offer_id' : offerId
            },
            url: '/_ajax?core[ajax]=true&core[call]=homdom.userFavority',
            success: function (response) {
                console.log(response)
            }
        });
    });
</script>
@endsection

