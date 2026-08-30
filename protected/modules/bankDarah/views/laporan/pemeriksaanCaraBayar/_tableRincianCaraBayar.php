<?php
$data = $model->searchLaporanRincianCarabayar();
$template = "{summary}\n{items}\n{pager}";
 $sort = true;
if(isset($caraPrint)){
    $data = $model->searchPrintLaporanRincianCarabayar();
	$template = "{items}";
	$sort = false;
	if ($caraPrint == "EXCEL")
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
    'id'=>'rincianPmeriksaanLab',
    'dataProvider'=>$data,
    'template'=>$template,
    'enableSorting'=>$sort,
    'itemsCssClass'=>'table table-striped table-condensed',
    'mergeColumns' => array(
        'no_pendaftaran',
        'no_masukpenunjang',
        'nama_pasien'
    ),
    'columns'=>array(
        array(
            'header'=>'No. Pendaftaran',
            'type'=>'raw',
            'name'=>'no_pendaftaran',
        ),
        array(
            'header'=>'No. Lab',
            'type'=>'raw',
            'name'=>'no_masukpenunjang',
        ),
        array(
            'header'=>'Nama Pasien',
            'type'=>'raw',
            'name'=>'nama_pasien',
        ),
        array(
            'header'=>'Pemeriksaan',
            'type'=>'raw',
            'name'=>'daftartindakan_nama',
        ),
        array(
            'header'=>'Jenis Penjamin',
            'type'=>'raw',
            'name'=>'carabayar_nama',
            'footerHtmlOptions'=>array(
                'colspan'=>6,
                'style'=>'text-align:right;font-style:italic;'
            ),
            'footer'=>'Total',
        ),
        array(
            'header'=>'Penjamin',
            'type'=>'raw',
            'name'=>'penjamin_nama',
        ),
        array(
            'header' => 'Total Biaya',
            'type'=>'raw',
            'name' => 'total_biaya',
            'value'=>'number_format($data->total_biaya)',
            'htmlOptions'=>array(
                'style'=>'text-align:right',
                'class'=>'currency'
            ),
            'footerHtmlOptions'=>array(
                'style'=>'text-align:right',
                'class'=>'currency'
            ),                            
            'footer'=>'sum(total_biaya)',
        ),
        array(
            'header' => 'Bayar',
            'type'=>'raw',
            'name' => 'bayartindakan',
            'value'=>'number_format($data->bayartindakan)',
            'htmlOptions'=>array(
                'style'=>'text-align:right',
                'class'=>'currency'
            ),
            'footerHtmlOptions'=>array(
                'style'=>'text-align:right',
                'class'=>'currency'
            ),                            
            'footer'=>'sum(bayartindakan)',
        ),
        array(
            'header' => 'Sisa',
            'type'=>'raw',
            'name' => 'sisatindakan',
            'value'=>'number_format($data->sisatindakan)',
            'htmlOptions'=>array(
                'style'=>'text-align:right',
                'class'=>'currency'
            ),
            'footerHtmlOptions'=>array(
                'style'=>'text-align:right',
                'class'=>'currency'
            ),                            
            'footer'=>'sum(sisatindakan)',
        ),
    ),
));
