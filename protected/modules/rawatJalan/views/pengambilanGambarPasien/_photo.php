<script>
    !window.jQuery && document.write('<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/themes/fancybox/jquery-1.4.3.min.js"><\/script>');
</script>
<!--css fancybox-->
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/themes/fancybox/fancybox/jquery.fancybox-1.3.4.css'); ?>
<!--end css fancybox-->
<!--javascript fancybox-->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/fancybox/fancybox/jquery.fancybox-1.3.4.pack.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js'); ?>
<!--end javascript fancybox-->
<div class='row'>
    <?php
    $id = 1;
    foreach ($model as $i => $photo) {
        $url_photo = (!empty($photo->pathphoto) ? Params::urlPemeriksaanPasienPhotosDirectory() . $photo->pathphoto : Params::urlPemeriksaanPasienThumbsDirectory() . "no_photo.jpeg");
        $path = (!empty($photo->pathphoto) ? Params::urlPemeriksaanPasienPhotosDirectory() . $photo->pathphoto : Params::urlPemeriksaanPasienThumbsDirectory() . "no_photo.jpeg");
        $id = isset($photo->photopemeriksaan_id) ? $photo->photopemeriksaan_id : null;
    ?>
        <div class="span3">
            <span>
                <?php if (!empty($id)) { ?>
                    <?php echo CHtml::activeCheckBox($photo, '[' . $i . ']pilih_gambar', array('onclick' => 'updateGallery(this,' . $photo->photopemeriksaan_id . ');', 'onkeyup' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => 'Klik untuk Edit gambar', 'style' => 'margin-left:250px;')) ?>
                    <?php echo CHtml::activeHiddenField($photo, '[' . $i . ']photopemeriksaan_id', array('onkeyup' => "return $(this).focusNextInputField(event);")) ?>
                <?php } ?>
            </span>
            <div class="fileupload-preview fileupload-exists thumbnail dopelessrotate" style="width: 250px; height: 250px;">
                <?php if (isset($photo->pathphoto)) { ?>
                    <a id="show7" href="<?php echo $path; ?>" title="<?php echo $photo->keteranganphoto; ?>">
                        <img src="<?php echo $url_photo; ?>" style="width:250px;height:245px;" alt="show7" id='rotateimage' />
                    </a>
                <?php } else { ?>
                <?php } ?>
            </div><br>
        </div>
    <?php
    }
    ?>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'model' => $model)); ?>