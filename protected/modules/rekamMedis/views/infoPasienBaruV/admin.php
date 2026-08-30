<?php
$this->breadcrumbs = array(
    'Informasi Pasien Baru',
);
?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#rminfo-pasien-baru-v-search').submit(function(){
	$.fn.yiiGridView.update('rminfo-pasien-v-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pasien Baru</b>
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
                <?php $this->renderPartial('_search', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Baru</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                    'id' => 'rminfo-pasien-v-grid',
                    'dataProvider' => $model->searchDataPasien(),
                    //	'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'replaceUrl' => true,
                    'mergeHeaders' => array(
                        array(
                            'name' => 'Ubah',
                            'start' => 8, //indeks kolom 3
                            'end' => 9, //indeks kolom 4
                        ),
                    ),
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        //		'pasien_id',
                        //		'jenisidentitas',
                        //		'no_identitas_pasien',
                        //		'namadepan',
                        //		'nama_pasien',
                        //		'nama_bin',
                        array(
                            'header' => 'Instalasi/<br>Tanggal Pendaftaran',
                            'type' => 'raw',
                            'value' => '"$data->instalasi_nama"." / ".MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                        ),
                        array(
                            'header' => 'Ruangan/<br>Poliklinik',
                            'type' => 'raw',
                            'value' => '((!empty($data->ruangan_nama)&&($data->statusperiksa!=Params::STATUSPERIKSA_BATAL_PERIKSA)) ? CHtml::link("<i class=icon-form-ubah></i> ".$data->ruangan_nama,"javascript:gantiPoli(\'$data->pendaftaran_id\',\'$data->ruangan_id\',\'$data->instalasi_id\',\'$data->pasien_id\',\'$data->nama_pasien\');",array("rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Mengubah Poliklinik")) : $data->ruangan_nama) ',
                        ),
                        array(
                            'header' => 'No. Rekam Medik/<br>No. Pendaftaran',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return Chtml::link('<i class="icon-form-input"></i>' . $data->no_rekam_medik, Yii::app()->createUrl('rekamMedis/pembuatanDokumenRK/create', array('pasien_id' => $data->pasien_id, 'tipe' => 3)), array("rel" => "tooltip", "title" => "Klik untuk Pencatatan Berkas RM Pasien Baru", "target" => "_blank"))
                                    . " / " . (!empty($data->no_pendaftaran) ? CHtml::link("<i class=icon-form-print></i> " . $data->no_pendaftaran, "javascript:print($data->pendaftaran_id);", array("rel" => "tooltip", "title" => "Klik untuk Print Lembar Poli")) : "-");
                            },
                            'htmlOptions' => array('style' => 'width:120px')
                        ),
                        array(
                            'header' => 'Nama Pasien/<br>Alias',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\"icon-form-ubah\"></i>", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahPasien",array("id"=>"$data->pasien_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien"))." ".CHtml::link($data->nama_pasien, Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahPasien",array("id"=>"$data->pasien_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien"))',
                        ),
                        array(
                            'header' => 'Jenis Kelamin/<br>Umur',
                            'type' => 'raw',
                            'value' => '"$data->jeniskelamin"." / "."$data->umur"',
                        ),
                        array(
                            'header' => 'Alamat',
                            'type' => 'raw',
                            'value' => '"$data->alamat_pasien"." / "."$data->rt"."/"."$data->rw"',
                        ),
                        array(
                            'header' => 'Jenis Penjamin/<br>Penjamin',
                            'type' => 'raw',
                            'value' => '((!empty($data->CaraBayarPenjamin)&&($data->statusperiksa!=Params::STATUSPERIKSA_BATAL_PERIKSA)) ? CHtml::link("<i class=icon-form-ubah></i> ".$data->CaraBayarPenjamin," ",array("onclick"=>"ubahCaraBayar(\'$data->pendaftaran_id\',\'$data->nama_pasien\');$(\'#carabayardialog\').dialog(\'open\');return false;",
                                                                                                                                                                 "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Mengubah Jenis Penjamin & Penjamin pasien")) : $data->CaraBayarPenjamin) ',
                        ),
                        array(
                            'header' => 'Kelas Pelayanan',
                            'type' => 'raw',
                            'value' => '"$data->kelaspelayanan_nama"',
                        ),
                        array(
                            'header' => 'Penanggung Jawab',
                            'type' => 'raw',
                            'value' => '(!empty($data->penanggungjawab_id) ? CHtml::link($data->pj->nama_pj, Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahPenanggungJawab",array("id"=>"$data->penanggungjawab_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data penanggung jawab"))." ".CHtml::link("<i class=\"icon-form-ubah\"></i>", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahPenanggungJawab",array("id"=>"$data->penanggungjawab_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data penanggung jawab")) : CHtml::link("<i class=\"icon-form-ubah\"></i>", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahPenanggungJawab", array("pendaftaran_id"=>$data->pendaftaran_id)), array("rel"=>"tooltip","title"=>"Klik untuk menambah data penanggung jawab"))) ',
                        ),
                        array(
                            'header' => 'Rujukan',
                            'type' => 'raw',
                            'value' => '(!empty($data->asalrujukan_id) ? CHtml::link($data->asalrujukan->asalrujukan_nama, Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahRujukan",array("id"=>"$data->asalrujukan_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data rujukan"))." ".CHtml::link("<i class=\"icon-form-ubah\"></i>", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahRujukan",array("id"=>"$data->asalrujukan_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data Rujukan")) : "-") ',
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
//========================================= Jenis Penjamin dialog =============================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'carabayardialog',
    'options' => array(
        'title' => 'Ganti Jenis Penjamin dan Penjamin <span id="titleNamaPasienCaraBayar"></span>',
        'autoOpen' => false,
        'minWidth' => 480,
        'modal' => true,
        'resizable' => false,
        //'hide'=>explode,
    ),
));
echo '<div class="divForFormUbahCaraBayar"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
//========================================================= end cara bayar dialog =========
//=============================== Ganti Poli Dialog =======================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'ganti_poli',
    'options' => array(
        'title' => 'Ganti Ruangan Pasien - <span id="titleNamaPasien"></span>',
        'autoOpen' => false,
        'width' => 300,
        'height' => 320,
        'modal' => true,
    ),
));
?>
<div class="col-sm-12">
    <div class="control-group">
        <label class="control-label">Poliklinik</label>
        <div class="controls">
            <?php echo CHtml::dropDownList('ruangan_sebelumnya', '', array(), array('disabled' => true)); ?>
            <?php echo CHtml::hiddenField('ruangan_awal', '', array('readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Alasan Perubahan <span class="required">*</span></label>
        <div class="controls">
            <td><?php echo CHtml::textArea('alasanperubahan', '', array('placeholder' => 'Alasan Perubahan',)); ?></td>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Menjadi Poliklinik</label>
        <div class="controls">
            <td><?php echo CHtml::dropDownList('ruangan_id_ganti', 'ruangan_id_ganti', array(), array('empty' => '-- Pilih --',)); ?></td>
        </div>
    </div>
    <?php
    echo CHtml::hiddenField('pendaftaran_id');
    echo CHtml::hiddenField('pasien_id');
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Ya', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'simpanRuanganBaru();')
    );
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-cancel"></i>')),
        array('class' => 'btn btn-default', 'type' => 'button', 'onclick' => '$(\'#ganti_poli\').dialog(\'close\');')
    );
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
</div>
<?php $this->renderPartial("_jsFunctions"); ?>