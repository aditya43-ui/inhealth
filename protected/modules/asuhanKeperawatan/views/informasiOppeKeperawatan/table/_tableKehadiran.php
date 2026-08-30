<?php $this->widget('bootstrap.widgets.BootAlert'); 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
'action' => Yii::app()->createUrl($this->route),
'method' => 'get',
'id' => 'oppekeperawatan-info-search',
'type' => 'horizontal',
    ));
?>
<?php
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'informasiasuhankeperawatan-grid',
    'dataProvider' => $modKehadiran->search(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
	array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
            'type'=>'raw',
            'htmlOptions'=>array('style'=>'text-align:right;'),
	),
        'nama_perawat',
        'nip_perawat',
        array(
            'header' => 'Indikator OPPE',
            'type' => 'raw',
            'value' => '$data->indikatoroppekeperawatan->nama_indikator',
        ),
        array(
            'header' => 'Bulan Pencatatan',
            'type' => 'raw',
            'value' => function ($data){
                echo MyFormatter::getMonthId(date('m', strtotime($data->bulan_kehadiran))).date(' Y', strtotime($data->bulan_kehadiran));
            },
        ),
        array(
            'header' => 'Prosentase Kehadiran (%)',
            'type' => 'raw',
            'value' => function ($data){
                echo $data->prosentase_kehadiran;
            },
        ),
        array(
            'header' => 'Detail',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("DetailKehadiran",array("oppekehadiran_id"=>$data->oppekehadiran_id,"frame"=>true)),
                        array("class"=>"",
                                "rel"=>"tooltip",
                                "title"=>"Klik untuk detail Kehadiran",
                        ));
            ', 
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Ubah',
            'type' => 'raw',
            'value' => function ($data) { 
                echo CHtml::link("<i class='entypo-pencil'></i> ",  Yii::app()->controller->createUrl("/asuhanKeperawatan/informasiOppeKeperawatan/ubah",array("id"=>$data->oppekehadiran_id)),array("rel"=>"tooltip","title"=>"Klik untuk Mengubah Data", "onclick"=>"myAlert('Coming Soon'); return false;"));
            }, 
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>
<?php $this->endWidget(); ?>