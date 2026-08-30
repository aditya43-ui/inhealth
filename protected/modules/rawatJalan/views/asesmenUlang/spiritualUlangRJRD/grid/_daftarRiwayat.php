<?php
$modRiwayat = new AsesmenspiritualUlangpasienrajalT('searchDialog');
$modRiwayat->default = 'kosong';
if(isset($_GET['AsesmenspiritualUlangpasienrajalT'])){
    $modRiwayat->attributes = $_GET['AsesmenspiritualUlangpasienrajalT']; 
    $modRiwayat->default = isset($_GET['AsesmenspiritualUlangpasienrajalT']['default'])?$_GET['AsesmenspiritualUlangpasienrajalT']['default']:null;
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
                    'value' => '$data->ruangan_nama'
                ],
            
                [
                    'header' => '<center>Lihat</center>',
                    'value' => function($data){
                        echo CHtml::link("<i class='icon-form-lihat'></i>", 'javascript:;',['data-url'=>$this->createUrl("cetak",['detail'=>1,'jenis'=>'spiritualUlangRJRD','id'=>$data->asesmenspiritual_ulangpasienrajal_id]),'onclick'=>'cetak(this)', 'rel'=>'tooltip', 'title'=>'detail asesmen spritual ulang pasien']);
                    },
                    'htmlOptions' => [
                        'style' => 'text-align:center;'
                    ]
                ],
                [
                    'header' => '<center>Cetak</center>',
                    'value' => function($data){
                        echo CHtml::link("<i class='fa fa-print'></i>", 'javascript:;',['data-url'=>$this->createUrl("cetak",['jenis'=>'spiritualUlangRJRD','id'=>$data->asesmenspiritual_ulangpasienrajal_id]),'onclick'=>'cetak(this)', 'rel'=>'tooltip', 'title'=>'Cetak asesmen spritual ulang pasien']);
                    },
                    'htmlOptions' => [
                        'style' => 'text-align:center;'
                    ]
                ],
                [
                    'header' => '<center>Hapus</center>',
                    'value' => function($data){
                        echo CHtml::link("<i class='icon-form-sampah'></i>", 'javascript:;',['data-url'=>$this->createUrl("hapus",['jenis'=>'spiritualUlangRJRD']),'onclick'=>'hapus('.$data->asesmenspiritual_ulangpasienrajal_id.', this)', 'rel'=>'tooltip', 'title'=>'Hapus cpis pasien']);
                    },
                    'htmlOptions' => [
                        'style' => 'text-align:center;'
                    ]
                ]
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));