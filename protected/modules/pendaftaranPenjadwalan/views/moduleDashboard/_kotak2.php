<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/fonts.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/neon.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/custom.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo-codes.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo-embedded.css">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">

<div class="tile-stats tile-aqua col-sm-6" style="width:225px;height:120px;margin:0px 0px 0px 40px;">
<div class="icon" style="margin:50px 5px 40px;">
<i class="entypo-users"></i>
</div>
    <div class="num" data-delay="0" data-duration="1500" data-postfix="" data-end="83" data-start="0">
        <?php echo $dataProvider->totalItemCount;?>
    </div>
<p><b>Jumlah Pasien Rawat Inap</b><br>
(dari rawat jalan & darurat)</p>
</div><br><br><br><br><br><br><br>