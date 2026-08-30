<?php
$this->breadcrumbs = array(
    'Informasi Kunjungan RS',
);
$arrMenu = array();
$this->menu = $arrMenu;
$this->widget('bootstrap.widgets.BootAlert');
?>
<!--div class="white-container"-->
<?php
Yii::app()->clientScript->registerScript('search', "
	$('#search').submit(function(){
		$.fn.yiiGridView.update('kunjunganrs-grid', {
			data: $(this).serialize()
		});
		return false;
	});
	", CClientScript::POS_READY);
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-info-circled"></i> Informasi <b>Kunjungan RS</b>
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
                        <?php echo $this->renderPartial('_search', array('model' => $model)); ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Kunjungan</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'kunjunganrs-grid',
                            'dataProvider' => $model->searchInformasi(),
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'columns' => array(
                                array(
                                    'header' => 'Tanggal Pendaftaran/<br> No. Pendaftaran',
                                    'name' => 'tgl_pendaftaran',
                                    'type' => 'raw',
                                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br>".$data->no_pendaftaran'
                                ),
                                array(
                                    'header' => 'No. Rekam Medik',
                                    'name' => 'no_rekam_medik',
                                    'type' => 'raw',
                                    'value' => '$data->no_rekam_medik',
                                ),
                                array(
                                    'header' => 'Nama Pasien',
                                    'type' => 'raw',
                                    'value' => '$data->namadepan." ".$data->nama_pasien',
                                ),
                                array(
                                    'header' => 'Umur/ <br> Jenis Kelamin',
                                    'type' => 'raw',
                                    'value' => '$data->umur."/ <br>".$data->jeniskelamin',
                                ),
                                array(
                                    'name' => 'alamat_pasien',
                                    'type' => 'raw',
                                    'value' => '$data->alamat_pasien',
                                ),
                                array(
                                    'header' => 'Kasus Penyakit',
                                    'type' => 'raw',
                                    'value' => '$data->jeniskasuspenyakit_nama',
                                ),
                                array(
                                    'header' => 'Kelas Pelayanan',
                                    'type' => 'raw',
                                    'value' => '$data->kelaspelayanan_nama',
                                ),
                                array(
                                    'header' => 'Jenis Penjamin/ <br> Penjamin',
                                    'name' => 'carabayar_nama',
                                    'type' => 'raw',
                                    'value' => '$data->carabayar_nama."/<br> ".$data->penjamin_nama',
                                ),
                                array(
                                    'header' => 'Instalasi/ <br> Ruangan',
                                    'name' => 'instalasi_nama',
                                    'type' => 'raw',
                                    'value' => '$data->instalasi_nama."/ <br>".$data->ruangan_nama',
                                ),
                                array(
                                    'header' => 'Dokter Penanggung Jawab',
                                    'type' => 'raw',
                                    'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/div-->