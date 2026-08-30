<?php
Yii::app()->clientScript->registerScript('search', "
$('#rmpenerimaan-t-search').submit(function(){
	$.fn.yiiGridView.update('informasipenerimaan-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<fieldset>
    <legend class="rim2">Informasi Penerimaan Dokumen </legend>
</fieldset>

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'informasipenerimaan-t-grid',
	'dataProvider'=>$model->searchInformasiPenerimaan(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Instalasi Tujuan',
                    'type'=>'raw',
                    'value'=>'$data->pendaftaran->instalasi->instalasi_nama',
                ),
                array(
                    'header'=>'Ruangan Tujuan',
                    'type'=>'raw',
                    'value'=>'$data->pendaftaran->ruangan->ruangan_nama',
                ),
                array(
                    'header'=>'Tgl. <br>Peminjaman <br>Dok.RK',
                    'type'=>'raw',
                    'value'=>'$data->peminjaman->tglpeminjamanrm'
                ),
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->pasien->nama_pasien',
                ),
                array(
                    'header'=>'No. RK',
                    'type'=>'raw',
                    'value'=>'$data->pasien->no_rekam_medik',
                ),
                array(
                    'header'=>'Tgl. RK',
                    'type'=>'raw',
                    'value'=>'$data->pasien->tgl_rekam_medik',
                ),
                array(
                    'header'=>'Jenis Kelamin',
                    'type'=>'raw',
                    'value'=>'$data->pasien->jeniskelamin',
                ),
                array(
                    'header'=>'Tgl. Lahir',
                    'type'=>'raw',
                    'value'=>'$data->pasien->tanggal_lahir',
                ),
                array(
                    'header'=>'Tgl. Kembali',
                    'type'=>'raw',
                    'value'=>'$data->tglkembali',
                ),
                array(
                    'header'=>'Kelengkapan <br>Dokumen <br>Kembali',
                    'type'=>'raw',
                    'value'=>'($data->lengkapdokumenkembali == 1) ? "Ya" : "Belum"',
                ),
                array(
                    'header'=>'Petugas Penerima',
                    'type'=>'raw',
                    'value'=>'$data->petugaspenerima',
                ),
                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<?php $this->renderPartial($this->path_view.'_searchinformasi',array('model'=>$model)); ?>