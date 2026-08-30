<?php
$css = "#imgtag" . $id . " {
            position: relative;
            width: 521px !important;
            max-width:none;
            border: 3px solid #ddd;
            cursor: crosshair;
            text-align: center;
            float: none;
            background-repeat:no-repeat;
            background-size: 521px 347.5px;  
            background-color: #ddd;
        }

        #tagit" . $id . " {
            position: absolute;
            top: 0;
            left: 0;
            width: 350px;
            border: 1px solid #D7C7C7;
            z-index: 10;
            border-radius: 15px;
        }

        #tagit" . $id . " .name {
            background-color: #FFF;
            width: 295px;
            font-size: 10pt;
            margin:0 auto;
            margin-bottom: 0 auto;
            border-radius: 15px;
            height: 170px;
        }

        #tagit" . $id . " DIV.text {
            margin-bottom: 5px;
        }

        #tagit" . $id . " INPUT[type=text] {
            margin-bottom: 5px;
        }

        #tagit" . $id . " #tagname" . $id . " {
            width: 110px;
        }";
Yii::app()->clientScript->registerCss('anatomi', $css);
?>
<div align="center" id="imgtag<?php echo $id ?>">
    <img img-no="<?php echo $id ?>" alt="<?php echo $id ?>" id="myImgId<?php echo $id ?>" src="<?php echo Yii::app()->request->baseUrl; ?>/data/images/anatomi/<?php echo $temp_file?>" class="taggd<?php echo $id ?>" style="width:480px;" />
    <div id="tagbox<?php echo $id ?>"></div>
</div>