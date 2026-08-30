<div class="row-fluid">
    <div class="span12">
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'riwayat-diagnosa-grid',
	'dataProvider'=>$modPasienMorbiditas->searchRiwayatDiagnosa($modPasienMasukPenunjang->pendaftaran_id),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
                    'header'=>'Tanggal Diagnosa',
                    'value'=>'$data->tglmorbiditas',
                    'filter'=>false,
                ),
		array(
                    'header'=>'Kelompok Diagnosa',
                    'value'=>'$data->kelompokdiagnosa->kelompokdiagnosa_nama',
                    'filter'=>false,
                ),
		array(
                    'header'=>'Kode',
                    'value'=>'$data->diagnosa->diagnosa_kode',
                    'filter'=>false,
                ),
		array(
                    'header'=>'Nama Diagnosa',
                    'value'=>'$data->diagnosa->diagnosa_nama',
                    'filter'=>false,
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
</div>
</div>