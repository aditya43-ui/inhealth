<?php 
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'guinvperalatan-t-grid',
    'dataProvider'=>$model->searchInformasi(),   
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'No',				
            'filter' => false,
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
            'headerHtmlOptions' => array('style' => 'text-align:center')
        ),
        array( 
            'header'=>'Nomor Aset',
            'value' => '$data->invperalatan_kode'
        ), 
        array( 
            'header'=>'Jenis Peralatan',
            'value' => '$data->invperalatan_namabrg'
        ), 
        array( 
            'header'=>'Ruangan Aset',
            'value' => '!empty($data->ruangan->ruangan_nama)?$data->ruangan->ruangan_nama:""'
        ),
        array( 
            'header'=>'Lokasi Aset',
            'value' => '!empty($data->lokasi->lokasiaset_namalokasi)?$data->lokasi->lokasiaset_namalokasi:""'
        ),         
        [
            'header' => 'Kondisi',
            'name' => 'invperalatan_keadaan'
        ],
        array(
            'header' => 'Detail',
            'type' => 'raw',
            'value' => function($data){
                return CHtml::link("<i class='".MyIcon::getIcons('lihat2')."'>",Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id."/".Yii::app()->controller->id."/detailaset",array("id"=>$data->invperalatan_id)),array('rel'=>'tooltip','title'=>'Klik untuk melihat detail aset'));
            },
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ]
        ), 
        array(
            'header' => 'Print QR Code',
            'type' => 'raw',
            'value' => function($data){
                return CHtml::link("<i class='".MyIcon::getIcons('cetak')."'>",'javascript:void(0);',array('rel'=>'tooltip','title'=>'Klik untuk print QR Code','onclick'=>"printQrCode(".$data->invperalatan_id.");return false"));
            },
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ]
        ), 
        [
            'header' => 'Pilih '. CHtml::checkBox('pilihSemua',false,['onclick'=>'pilihSemua(this);','class'=>'pilihsemua']),
            'type' => 'raw',
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ],
            'value' => function($data){
                return CHtml::checkBox('pilih',false,['class'=>'pilih_print','data-id'=>$data->invperalatan_id,'onclick'=>'setCeklis(this);']);
            }
        ]
    ),
   'afterAjaxUpdate'=>'function(id, data){
        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});        
        cekCeklis();
    }',
)); ?>                 
