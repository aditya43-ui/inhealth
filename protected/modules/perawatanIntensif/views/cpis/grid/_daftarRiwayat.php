<?php
$modRiwayat = new CpispasienT('searchDialog');
$modRiwayat->default = 'kosong';
if(isset($_GET['CpispasienT'])){
    $modRiwayat->attributes = $_GET['CpispasienT']; 
    $modRiwayat->default = isset($_GET['CpispasienT']['default'])?$_GET['CpispasienT']['default']:null;
}

$modRiwayat->pendaftaran_id = $model->pendaftaran_id;

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftar-riwayat-grid',
	'dataProvider'=>$modRiwayat->searchRiwayat(),	
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                [
                    'header' => '<center>Tanggal</center>',
                    'value' => '!empty($data->tanggalpengkajian)?MyFormatter::formatDateTimeForUser($data->tanggalpengkajian):""'
                ],
                [
                    'header' => '<center>Lihat Detail</center>',
                    'value' => function($data){
                        echo CHtml::link("<i class='icon-form-lihat'></i>", $this->createUrl('detail',['id'=>$data->cpispasien_id]),['rel'=>'tooltip', 'title'=>'Lihat cpis pasien']);
                    },
                    'htmlOptions' => [
                        'style' => 'text-align:center;'
                    ]
                ],
                [
                    'header' => '<center>Cetak</center>',
                    'value' => function($data){
                        echo CHtml::link("<i class='fa fa-print'></i>", 'javascript:;',['onclick'=>'cetak('.$data->cpispasien_id.')', 'rel'=>'tooltip', 'title'=>'Cetak cpis pasien']);
                    },
                    'htmlOptions' => [
                        'style' => 'text-align:center;'
                    ]
                ],
                [
                    'header' => '<center>Hapus</center>',
                    'value' => function($data){
                        echo CHtml::link("<i class='icon-form-sampah'></i>", 'javascript:;',['onclick'=>'hapus('.$data->cpispasien_id.')', 'rel'=>'tooltip', 'title'=>'Hapus cpis pasien']);
                    },
                    'htmlOptions' => [
                        'style' => 'text-align:center;'
                    ]
                ]
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));