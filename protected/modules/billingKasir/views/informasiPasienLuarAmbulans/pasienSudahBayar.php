<?php
$this->breadcrumbs = array(
    'Daftar Pasien' => array('/billingKasir/daftarPasien'),
    'PasienKarcis',
); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'caripasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
Yii::app()->clientScript->registerScript('cariPasien', "
$('#caripasien-form').submit(function(){
	$.fn.yiiGridView.update('pencarianpasien-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<fieldset>
    <legend class="rim2">Informasi Pasien Sudah Bayar </legend>
    <?php
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'pencarianpasien-grid',
        'dataProvider' => $model->searchPasienSudahBayar(),
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Tgl. Bukti Bayar',
                'name' => 'tglbuktibayar',
                'type' => 'raw',
                'value' => '$data->tandabuktibayar->tglbuktibayar."<br>".$data->tandabuktibayar->nobuktibayar',
            ),
            array(
                'name' => 'instalasi',
                'type' => 'raw',
                'value' => '$data->pendaftaran->instalasi->instalasi_nama',
            ),
            //            array(
            //                'name'=>'no_pendaftaran',
            //                'type'=>'raw',
            //                'value'=>'$data->pendaftaran->no_pendaftaran',
            //            ),
            //            array(
            //                'name'=>'no_rekam_medik',
            //                'type'=>'raw',
            //                'value'=>'$data->pasien->no_rekam_medik',
            //            ),
            array(
                'header' => 'No. Pendaftaran / No. Rekam Medik',
                'value' => '$data->pendaftaran->no_pendaftaran." / ".$data->pasien->no_rekam_medik',
            ),
            array(
                'name' => 'nama_pasien',
                'type' => 'raw',
                'value' => '$data->pasien->namaNamaBin',
            ),
            array(
                'header' => 'Jenis Penjamin / Penjamin',
                'name' => 'carabayar_nama',
                'type' => 'raw',
                'value' => '$data->pendaftaran->carabayar->carabayar_nama."<br>".$data->pendaftaran->penjamin->penjamin_nama',
            ),
            array(
                'name' => 'total_tagihan',
                'type' => 'raw',
                'value' => '"Rp ".number_format($data->totalbiayapelayanan)',
            ),
            array(
                'header' => 'Tanggungan Asuransi',
                'name' => 'subsidi_asuransi',
                'type' => 'raw',
                'value' => '$data->totalsubsidiasuransi',
            ),
            array(
                'header' => 'Tanggungan Pemerintah',
                'name' => 'subsidi_pemerintah',
                'type' => 'raw',
                'value' => '$data->totalsubsidipemerintah',
            ),
            array(
                'header' => 'Tanggungan RS / Klinik',
                'name' => 'subsidi_rs',
                'type' => 'raw',
                'value' => '$data->totalsubsidirs',
            ),
            array(
                'header' => 'Biaya',
                'name' => 'iur_biaya',
                'type' => 'raw',
                'value' => '"Rp ".number_format($data->totaliurbiaya)',
            ),
            array(
                'header' => 'Keringanan',
                'name' => 'discount',
                'type' => 'raw',
                'value' => '$data->totaldiscount',
            ),
            array(
                'header' => 'Pembebasan',
                'name' => 'pembebasan',
                'type' => 'raw',
                'value' => '$data->totalpembebasan',
            ),
            array(
                'header' => 'Jumlah Pembayaran',
                'name' => 'jumlah_pembayaran',
                'type' => 'raw',
                'value' => '"Rp ".number_format($data->totalbayartindakan)',
            ),
            array(
                'header' => 'Retur Tagihan Pasien',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-list-alt\"></i>",Yii::app()->controller->createUrl("returTagihanPasien/index",array("idPembayaran"=>$data->pembayaranpelayanan_id,"frame"=>true)),
                            array("class"=>"", 
                                  "target"=>"iframePembayaran",
                                  "onclick"=>"$(\"#dialogRetur\").dialog(\"open\");",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk meretur tagihan pasien",
                            ))',           'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
            array(
                'header' => 'Kuitansi Pasien',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-list-silver\"></i>",Yii::app()->controller->createUrl("kwitansi/view",array("pendaftaran_id"=>$data->pendaftaran_id,"idPasienadmisi"=>$data->pasienadmisi_id,"idPembayaranPelayanan"=>$data->pembayaranpelayanan_id,"frame"=>true)),
                            array("class"=>"", 
                                  "target"=>"iframeKwitansi",
                                  "onclick"=>"$(\"#dialogKwitansi\").dialog(\"open\");",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk cetak kuitansi",
                            ))',           'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
    ?>
</fieldset>
<?php echo $this->renderPartial('_formKriteriaPencarian', array('model' => $model, 'form' => $form), true); ?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset')); ?>
    <?php
    $content = $this->renderPartial('../tips/informasi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRetur',
    'options' => array(
        'title' => 'Retur Tagihan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframePembayaran" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogKwitansi',
    'options' => array(
        'title' => 'Kuitansi Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeKwitansi" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>