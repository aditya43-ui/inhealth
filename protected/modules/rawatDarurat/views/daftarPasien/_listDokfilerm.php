<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/dflip/js/libs/jquery.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/dflip/js/dflip.min.js'); ?>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/dflip/css/dflip.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/dflip/css/themify-icons.min.css" rel="stylesheet" type="text/css">

<div class="table-responsive">
    <table class="table table-condensed table-bordered">
        <thead>
            <th>Tanggal Upload</th>
            <th>Lihat File</th>
        </thead>
        <tbody>
            <?php if (count($modDokfilerm) > 0 ) { ?>
            <?php foreach ($modDokfilerm as $dok) { ?>
            <tr>
                <td><?= MyFormatter::formatDateTimeForUser($dok->dokfilerm_tgl);?></td>
                <td>
                    <?php if(pathinfo($dok->dokfilerm_filepath, PATHINFO_EXTENSION) == 'pdf') {?>
                        <a class="_df_custom" href="#" source="<?php echo Params::urlFileRMPasienDirectory().$dok->namafolder.'/'.$dok->dokfilerm_filepath ?>"> Lihat Dokumen
                    <?php } else { ?>
                
                        <?php echo CHtml::link("<br>Lihat Dokumen<br>", Yii::app()->controller->createUrl('DaftarPasien/detailScanRM', array('dokfilerm_id' => $dok->dokfilerm_id)), 
                            array(
                                  "class" => "",
                                  "target" => "frameGambar",
                                  "rel" => "tooltip",
                                  "title" => "Klik untuk melihat File Rekam Medik",
                                  "onclick" => "$('#dialogGambar').dialog('open');"
                        )); ?>
                        <!-- // echo CHtml::link("<br>Lihat Dokumen<br>", Yii::app()->controller->createUrl('DaftarPasien/detailScanRM', array('dokfilerm_id' => $dok->dokfilerm_id)), array("target" => "iframe_detail", "rel" => "tooltip", "title" => "Klik untuk melihat File Rekam Medik", "onclick" => "$('#dialog_detail').dialog('open');")); -->
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="2">Belum ada dokumen yang diupload</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogGambar',
    'options' => array(
        'title' => 'Dokumen File Rekam Medis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 250,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>



<iframe name="frameGambar" style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<script type="text/javascript">
jQuery.browser = {};
(function () {
jQuery.browser.msie = false;
jQuery.browser.version = 0;
if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
jQuery.browser.msie = true;
jQuery.browser.version = RegExp.$1;
}
})();

        function setFlipbook(pdf){
            if(getFileExtension(pdf) == 'pdf'){
                window.ope
            }
            // console.log()
        }
        jQuery(function() {

        DFLIP.defaults.onReady = function(flipbook){
            console.log("flipbook ready");
            flipbook.ui.fullScreen.trigger("click");
        }

        });
        function getFileExtension(filename) {
                return filename.slice((filename.lastIndexOf(".") - 1 >>> 0) + 2);
        }

    </script>