<?php
$modRiwayat = new EkstubasipasienT('searchDialog');
$modRiwayat->default = 'kosong';
if(isset($_GET['EkstubasipasienT'])){
    $modRiwayat->attributes = $_GET['EkstubasipasienT']; 
    $modRiwayat->default = isset($_GET['EkstubasipasienT']['default'])?$_GET['EkstubasipasienT']['default']:null;
}

$modRiwayat->pasien_id = $model->pasien_id;

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftar-riwayat-grid',
	'dataProvider'=>$modRiwayat->searchRiwayat(),	
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                [
                    'header' => '<center>Tanggal</center>',
                    'value' => '!empty($data->tgl_tindakan)?MyFormatter::formatDateTimeForUser($data->tgl_tindakan):""'
                ],
                [
                    'header' => '<center>Lihat Detail</center>',
                    'value' => function($data){
                        echo CHtml::link("<i class='icon-form-lihat'></i>", 'javascript:;',['onclick'=>'cetak('.$data->ekstubasipasien_id.',"detail")','rel'=>'tooltip', 'title'=>'Lihat persiapan ekstubasi pasien']);
                    },
                    'htmlOptions' => [
                        'style' => 'text-align:center;'
                    ]
                ],
                [
                    'header' => '<center>Cetak</center>',
                    'value' => function($data){
                        echo CHtml::link("<i class='fa fa-print'></i>", 'javascript:;',['onclick'=>'cetak('.$data->ekstubasipasien_id.')', 'rel'=>'tooltip', 'title'=>'Cetak persiapan ekstubasi pasien']);
                    },
                    'htmlOptions' => [
                        'style' => 'text-align:center;'
                    ]
                ],
                [
                    'header' => '<center>Hapus</center>',
                    'value' => function($data){
                        echo CHtml::link("<i class='icon-form-sampah'></i>", 'javascript:;',['onclick'=>'hapus('.$data->ekstubasipasien_id.')', 'rel'=>'tooltip', 'title'=>'Hapus persiapan ekstubasi pasien']);
                    },
                    'htmlOptions' => [
                        'style' => 'text-align:center;'
                    ]
                ]
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));