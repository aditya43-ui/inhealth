<?php
$this->breadcrumbs = array(
    'Daftar Pasien' => array('/billingKasir/daftarPasien'),
    'Pasien Rawat Inap Melarikan Diri',
); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
Yii::app()->clientScript->registerScript('cariPasien', "
$('#caripasien-form').submit(function(){
$.fn.yiiGridView.update('pencarianpasien-grid', {
data: $(this).serialize()
});
return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Rawat Inap Melarikan Diri</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'caripasien-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'focus' => '#' . CHtml::activeId($modRI, 'no_rekam_medik'),
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
                )); ?>
                <?php echo $this->renderPartial('_formKriteriaPencarianPasienMelarikanDiri', array('model' => $modRI, 'form' => $form, 'format' => $format), true); ?>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <?php //echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit','ajax' => array(
                    //                 'type' => 'GET', 
                    //                 'url' => array("/".$this->route), 
                    //                 'update' => '#pencarianpasien-grid',
                    //                 'beforeSend' => 'function(){
                    //                                      $("#pencarianpasien-grid").addClass("animation-loading");
                    //                                  }',
                    //                 'complete' => 'function(){
                    //                                      $("#pencarianpasien-grid").removeClass("animation-loading");
                    //                                  }',
                    //             ))); 
                    ?>
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset')); ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasi_pencarian', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Rawat Inap Melarikan Diri</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial('_tablePasienMelarikanDiri', array('modRI' => $modRI), true); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPembayaranKasir',
    'options' => array(
        'title' => 'Pembayaran Kasir',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1124,
        'height' => 510,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
data: $('#caripasien-form').serialize()
}); }",
    ),
));
?>
<iframe src="" name="iframePembayaran" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincianTagihan',
    'options' => array(
        'title' => 'Rincian Tagihan',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1024,
        'height' => 610,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailVerifikasi',
    'options' => array(
        'title' => 'Detail Verifikasi Tagihan',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1001,
        'minWidth' => 1024,
        'height' => 510,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeDetailVerifikasi" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>
<script>
    var url_bayar = '<?php echo Yii::app()->controller->createUrl("PembayaranTagihanPasien/index"); ?>';
    var url_verifikasi = '<?php echo Yii::app()->controller->createUrl("verifikasiTagihan/index"); ?>';

    function cekStatusPasien(id, admisi, instalasi_id) {
        //$.post('<?php echo $this->createUrl('cekStatusPasienRI'); ?>', {id: id, pasienadmisi_id: admisi}, function(data) {
        //    if (data.ok == 0) {
        //        myAlert(data.msg);
        //    } else {
        window.location.href = url_bayar + '&instalasi_id=' + instalasi_id + '&pendaftaran_id=' + id + "&pasienadmisi_id=" + admisi;
        // $("#dialogPembayaranKasir iframe").prop('src', url_bayar + '&pendaftaran_id=' + id + "&pasienadmisi_id=" + admisi);
        // $("#dialogPembayaranKasir").dialog("open");
        //    }
        //}, 'json');
    }

    function gotoVerifikasi(id) {
        window.location.href = url_verifikasi + '&pendaftaran_id=' + id;
    }
</script>