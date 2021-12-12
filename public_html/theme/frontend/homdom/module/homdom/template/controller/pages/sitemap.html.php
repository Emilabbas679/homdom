<main class="main">
    <div class="section_wrap wrap_main">

        <div class="section_body">
            <div class="main_center">

                <div class="section_wrap metro_blocks">
                    <div class="section_headers">
                        <h1 class="address_h">{{ phrase var='homdom.districts'}} </h1>
                    </div>
                    <?php $districts = AIN::sendApi('homdom_get_district', ['status_id'=>11, 'limit' => 500]);
                    $districts = $districts['data']['rows'];
                    $districts = AIN::getService('homdom.helpers')->sortByAlphabet($districts);
                    ?>
                    <ul class="metro_blist">
                        <?php foreach ($districts as $letters) {
                            foreach ($letters as $id=>$val) {?>
                                <li><a target="_blank" href="/offers?district_id<?=$id?>"><?=AIN::getPhrase('homdom.'.$val)?></a> </li>
                            <?php }} ?>
                    </ul>
                </div>




                <div class="section_wrap metro_blocks">
                    <div class="section_headers">
                        <h1 class="address_h">{{ phrase var='homdom.targets'}} </h1>
                    </div>
                    <?php $targets = AIN::sendApi('homdom_get_target', ['status_id'=>11, 'limit' => 500]);
                    $targets = $targets['data']['rows'];
                    $targets = AIN::getService('homdom.helpers')->sortByAlphabet($targets);

                    ?>
                    <ul class="metro_blist">
                        <?php foreach ($targets as $letters) {
                            foreach ($letters as $id=>$val) {?>
                                <li><a target="_blank" href="/offers?targets%5B%5D=<?=$id?>"><?=AIN::getPhrase('homdom.'.$val)?></a> </li>
                            <?php }} ?>

                    </ul>
                </div>

                <div class="section_wrap metro_blocks">
                    <div class="section_headers">
                        <h1 class="address_h">{{ phrase var='homdom.localities'}} </h1>
                    </div>
                    <?php $localities = AIN::sendApi('homdom_get_locality', ['status_id'=>11, 'limit' => 500]);
                    $localities = $localities['data']['rows'];
                    $localities = AIN::getService('homdom.helpers')->sortByAlphabet($localities);

                    ?>
                    <ul class="metro_blist">
                        <?php foreach ($localities as $letters) {
                            foreach ($letters as $id=>$val) {?>
                                <li><a target="_blank" href="/offers?locality_id=<?=$id?>"><?=AIN::getPhrase('homdom.'.$val)?></a> </li>
                            <?php }} ?>

                    </ul>
                </div>



                <div class="section_wrap metro_blocks">
                    <div class="section_headers">
                        <h1 class="address_h">{{ phrase var='homdom.list_of_metros'}} </h1>
                    </div>
                    <?php $metros = AIN::getService('homdom.helpers')->redisMetros();  ?>
                    <ul class="metro_blist">
                        <?php foreach ($metros as $keys) {
                            foreach ($keys as $id=>$val) {?>
                                <li><a target="_blank" href="/offers?metros%5B%5D=<?=$id?>"><?=AIN::getPhrase('homdom.'.$val)?></a> </li>
                            <?php }} ?>

                    </ul>
                </div>

                <div class="section_wrap metro_blocks">
                    <div class="section_headers">
                        <h1 class="address_h">{{ phrase var='homdom.pages'}} </h1>
                    </div>
                    <?php $pages = AIN::sendApi('get_page', ['status_id'=>11, 'limit' => 500]);
                    $pages = (isset($pages['data']) and isset($pages['data']['rows'])) ? $pages['data']['rows'] : [];
                    ?>
                    <ul class="metro_blist">
                        <?php foreach ($pages as $item) { ?>
                            <li><a target="_blank" href="/page/<?=$item['slug']?>" style="word-break: break-word"><?=$item['title']?></a> </li>
                        <?php } ?>

                    </ul>
                </div>


            </div>
        </div>


    </div>
</main>