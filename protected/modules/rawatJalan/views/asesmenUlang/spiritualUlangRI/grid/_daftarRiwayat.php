<?php
$modRiwayat = new AsesmenspiritualUlangpasienT('searchDialog');
$modRiwayat->default = 'kosong';
if(isset($_GET['AsesmenspiritualUlangpasienT'])){
    $modRiwayat->attributes = $_GET['AsesmenspiritualUlangpasienT']; 
    $modRiwayat->default = isset($_GET['AsesmenspiritualUlangpasienT']['default'])?$_GET['AsesmenspiritualUlangpasienT']['default']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftar-riwayat-grid',
	'dataProvider'=>$modRiwayat->searchRiwayat(),	
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                [
                    'header' => 'No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ],
                [
                    'header' => '<center>Tanggal Asesmen</center>',
                    'value' => '!empty($data->tanggal)?MyFormatter::formatDateTimeForUser($data->tanggal):""'
                ],
                [
                    'header' => '<center>Ruang</center>',
                    'name' => 'kamarruangan_nama'
                ],
            
                [
                    'header' => '<center>Lihat</center>',
                    'value' => function($data){
                        echo CHtml::link("<i class='icon-form-lihat'></i>", 'javascript:;',['data-url'=>$this->createUrl("cetak",['detail'=>1,'jenis'=>'spiritualUlangRI','id'=>$data->asesmenspiritual_ulangpasien_id]),'onclick'=>'cetak(this)', 'rel'=>'tooltip', 'title'=>'detail asesmen spritual ulang pasien']);
                    },
                    'htmlOptions' => [
                        'style' => 'text-align:center;'
                    ]
                ],
                [
                    'header' => '<center>Cetak</center>',
                    'value' => function($data){
                        echo CHtml::link("<i class='fa fa-print'></i>", 'javascript:;',['data-url'=>$this->createUrl("cetak",['jenis'=>'spiritualUlangRI','id'=>$data->asesmenspiritual_ulangpasien_id]),'onclick'=>'cetak(this)', 'rel'=>'tooltip', 'title'=>'Cetak asesmen spritual ulang pasien']);
                    },
                    'htmlOptions' => [
                        'style' => 'text-align:center;'
                    ]
                ],
                [
                    'header' => '<center>Hapus</center>',
                    'value' => function($data){
                        echo CHtml::link("<i class='icon-form-sampah'></i>", 'javascript:;',['data-url'=>$this->createUrl("hapus",['jenis'=>'spiritualUlangRI']),'onclick'=>'hapus('.$data->asesmenspiritual_ulangpasien_id.', this)', 'rel'=>'tooltip', 'title'=>'Hapus cpis pasien']);
                    },
                    'htmlOptions' => [
                        'style' => 'text-align:center;'
                    ]
                ]
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));