<?php
$this->breadcrumbs = array(
    'Informasi Pembebasan Tarif',
);
Yii::app()->clientScript->registerScript('search', "
 $('#informasipembebasantarif-t-search').submit(function(){
	$.fn.yiiGridView.update('informasipembebasantarif-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pembebasan Tarif</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
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
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pembebasan Tarif</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasipembebasantarif-m-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'type' => 'raw',
                            'value' => '$row+1'
                        ),
                        array(
                            'header' => 'Tanggal Pembebasan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpembebasan)'
                        ),
                        array(
                            'header' => 'Tanggal Pelayanan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)'
                        ),
                        array(
                            'header' => 'No. Pendaftaran',
                            'type' => 'raw',
                            'value' => '$data->no_pendaftaran'
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik'
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'type' => 'raw',
                            'value' => '$data->namadepan." ".$data->nama_pasien'
                        ),
                        array(
                            'header' => 'Ruangan Pelayanan',
                            'type' => 'raw',
                            'value' => '$data->ruangan_nama'
                        ),
                        array(
                            'header' => 'Uraian Tindakan',
                            'type' => 'raw',
                            'value' => '$data->daftartindakan_nama'
                        ),
                        array(
                            'header' => 'Jumlah Tarif',
                            'type' => 'raw',
                            'value' => '"Rp ".number_format(($data->tarif_satuan * $data->qty_tindakan),0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Komponen Tarif',
                            'type' => 'raw',
                            'value' => '$data->komponentarif_nama'
                        ),
                        array(
                            'header' => 'Jumlah Pembebasan',
                            'type' => 'raw',
                            'value' => '"Rp ".number_format($data->jmlpembebasan,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        array(
                            'header' => 'Nama Dokter',
                            'type' => 'raw',
                            'value' => '$data->dokterLengkap'
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function resetForm() {
        window.open("<?php echo $this->createUrl("/" . $this->route); ?>", "_self");
    }
</script>