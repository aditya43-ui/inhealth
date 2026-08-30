<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/fileupload/fileupload.js'); ?>
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
<?php
$this->breadcrumbs = array(
    'Transaksi Pengambilan Gambar Pasien'
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class='fas fa-camera'></i> Transaksi <b>Pengambilan Gambar Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="far fa-file-alt"></i> Data <b>Kunjungan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'photopemeriksaan-t-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
                    'focus' => '#',
                ));
                ?>
                <?php
                $this->widget('bootstrap.widgets.BootAlert');
                echo $form->errorSummary(array($model));
                ?>
                <?php $this->renderPartial($this->path_view . '_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan, 'model' => $model, 'judulphoto' => $judulphoto)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class='fas fa-images'></i> Data <b>Gambar</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->widget('GalleryManager', array(
                    'gallery' => $model,
                    'controllerRoute' => '/rawatJalan/PengambilanGambarPasien', //route to gallery controller
                ));
                //    if ($model->galleryBehavior->getGallery() === null) {
                //        echo '<p>Before add photos to product gallery, you need to save product</p>';
                //    } else {
                //        $this->widget('GalleryManager', array(
                //            'gallery' => $model->galleryBehavior->getGallery(),
                //        ));
                //    }
                ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="far fa-file-alt"></i> Data <b>Gambar</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial($this->path_view . '_gallery', array('form' => $form, 'modKunjungan' => $modKunjungan, 'model' => $model, 'judulphoto' => $judulphoto)); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['id'])) ? true : (($sukses > 0) ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php
            if (!isset($_GET['frame'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array(
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                ));
            }
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
//================= dialog webcam =====================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog-addphoto',
    'options' => array(
        'title' => 'Ambil Foto',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 360,
        'height' => 250,
        'resizable' => false,
    ),
));
?>
<div id="dialog-content" style="text-align: center;">
    <div id="cam-preview"></div>
    <br>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-cog icon-white"></i>')), array('rel' => 'tooltip', 'title' => 'Konfigurasi Kamera', 'class' => 'btn btn-mini btn-primary', 'type' => 'button', 'onclick' => 'webcam.configure();', 'style' => 'font-size:10px; width:32px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Ambil', array('{icon}' => '<i class="icon-camera icon-white"></i>')), array('id' => 'btn_ambil_gambar', 'class' => 'btn btn-mini btn-primary', 'type' => 'button', 'onclick' => 'ambilGambar();', 'style' => 'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="icon-download-alt icon-white"></i>')), array('id' => 'btn_simpan_gambar', 'disabled' => true, 'class' => 'btn btn-mini btn-primary', 'type' => 'button', 'onclick' => 'simpanGambar();', 'style' => 'font-size:10px; width:80px; height:24px;')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('id' => 'btn_ulang_gambar', 'class' => 'btn btn-mini btn-danger', 'type' => 'button', 'onclick' => 'ulangGambar();', 'style' => 'font-size:10px; width:76px; height:24px;')); ?>
    <div id="upload_results" style="background-color:#eee; margin-top:10px"></div>
</div>
<?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
    <?php
    $random = rand(0000000000000000, 9999999999999999);
    ?>
    /**
     * ambil gambar pada webcam
     * @returns {Boolean}
     */
    function ambilGambar() {
        webcam.freeze();
        $("#btn_ambil_gambar").attr("disabled", true);
        $("#btn_simpan_gambar").removeAttr("disabled");
    }
    /**
     * menyimpan / meng-upload gambar
     * @returns {undefined}
     */
    function simpanGambar() {
        $("#btn_simpan_gambar").attr("disabled", true);
        document.getElementById('upload_results').innerHTML = '<h3>Proses Penyimpanan...</h3>';
        //    webcam.snap(); << sering bugs hasil photo blank putih
        webcam.upload();
    }
    /**
     * mengulang pengambilan gambar
     * @returns {undefined}
     */
    function ulangGambar() {
        $("#btn_ambil_gambar").removeAttr("disabled");
        $("#btn_simpan_gambar").attr("disabled", true);
        webcam.reset();
    }
    /**
     * keterangan setelah berhasil ambil gambar webcam
     * @returns {Boolean}
     */
    function suksesUpload(msg) {
        if (msg == 'OK') {
            //            $('#photo-preview').attr('src','<?php echo Params::urlPemeriksaanPasienPhotosDirectory() . "no_photo.jpeg" ?>');
            setTimeout(function() {
                document.getElementById('upload_results').innerHTML = '';
                //                $("#<?php echo CHtml::activeId($model, 'pathphoto') ?>").val("<?php echo $random ?>.jpg")
                //                $('#photo-preview').attr('src','<?php echo Params::urlPemeriksaanPasienThumbsDirectory() . "kecil_" . $random; ?>.jpg');
                savePhoto("<?php echo $random ?>.jpg");
                $('#dialog-addphoto').dialog('close');
            }, 3000);
        } else {
            myAlert("PHP Error: " + msg);
        }
    }

    function savePhoto(img) {
        var pendaftaran_id = $('#pendaftaran_id').val();
        var pasien_id = $('#pasien_id').val();
        var judulphoto = $('#judulphoto').val();
        var image = img;
        if (pendaftaran_id != '') {
            $('.sorter').addClass('animation-loading');
            $('#frame').addClass('animation-loading');
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('AjaxUpload'); ?>',
                data: {
                    pendaftaran_id: pendaftaran_id,
                    pasien_id: pasien_id,
                    judulphoto: judulphoto,
                    image: image
                }, //
                dataType: "json",
                success: function(data) {
                    if (data.preview !== "") {
                        $('.sorter').removeClass('animation-loading');
                        //                    document.getElementById('sorter').contentWindow.location.reload(true);
                        location.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            myAlert("Silakan pilih data pasein terlebih dahulu!");
        }
    }
    $(document).ready(function() {
        /**
         * set webcam
         * @returns {Boolean}
         */
        function setWebcam() {
            webcam.set_api_url('index.php?r=photoWebCam/jpegcam.saveJpg&random=<?php echo $random; ?>&pathTumbs=<?php echo Params::pathPemeriksaanPasienThumbsDirectory(); ?>&path=<?php echo Params::pathPemeriksaanPasienPhotosDirectory(); ?>');
            webcam.set_quality(90);
            webcam.set_shutter_sound(false);
            webcam.set_stealth(1);
            webcam.set_swf_url('<?php echo Yii::app()->baseUrl . '/js/jpegcam/assets/'; ?>webcam.swf');
            $('#cam-preview').append(webcam.get_html(303, 320));
            webcam.set_hook('onComplete', 'suksesUpload');
        }
        setWebcam();
    });
</script>
<?php //================= end dialog webcam ===================== 
?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'model' => $model, 'judulphoto' => $judulphoto)); ?>