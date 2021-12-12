<!DOCTYPE html>
<html lang="en">
<head>
    <?php $sections = $this->_aVars['sections'] ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informer Inner</title>
    <style>
        * {
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
        }
        a{
            text-decoration: none;
        }

        li{
            display: inline-block; margin-right: 14px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        }
        h5.infomr_title{
            text-align: center; padding: 10px; color:<?=$sections['title_color']?>; background-color: <?=$sections['title_bg_color']?>;
        }
        
        h3.inform_in_title {
            background-color: <?=$sections['offer_title_bg_color']?>; padding: 10px;  position: relative;
            font-size: 15px; color: <?=$sections['offer_title_color']?>; line-height: 20px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        }
        ul{
            list-style: none; padding: 0; margin: 0; color: #000000;
        }
        ul li{
            list-style: none;
        }
        .inform_in_block {
            display: block;
            width: 100%;
            /*padding: 3px 5px;*/
        }
        .inform_in_block.horizontal{
            float: none;
            width: 100%;
        }
        .inform_in_block.vertical {
            width: 250px;
            float: left;
        }
        .inform_in_title_full {
            flex: 1;position: relative;
        }
        .inform_in_list {
            width: 100%;
            padding: 5px 5px;
            background-color: #f0c1c1;
        }
    </style>
</head>
<body>
    <div class="tasks-list-container">
        <?php if (isset($sections['block_title'])) { ?>
        <h5 class="infomr_title"><?=$sections['block_title']?></h5>
        <?php } ?>

        <?php foreach ($this->_aVars['offers'] as $item) { ?>
            <a href="https://homdom.az/offer/<?=$item['id']?>" target="_blank" style="  text-decoration: none; ">
                <div class="inform_in_block horizontal">
                    <!-- Details -->
                    <div class="inform_in_title_full">
                        <h3 class="inform_in_title"><?=AIN::getService('homdom.helpers')->getOfferTitle($item)?></h3>
                        <!--                    <div class="inform_in_list">-->
                        <!--                        <ul>-->
                        <!--                            <li> saasjdasdasjasj dasdh dj </li>-->
                        <!--                        </ul>-->
                        <!--                    </div>-->
                    </div>
                </div>
            </a>
        <? } ?>
    </div>
</body>
</html>
