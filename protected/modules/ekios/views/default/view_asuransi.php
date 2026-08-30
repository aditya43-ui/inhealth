<style type="text/css">
    .table th, .table td{padding:8px;line-height:35px;text-align:left;vertical-align:top;border-top:1px solid #ddd;font-size: 14px; font-family: monospace;}
</style>

<?php
$this->breadcrumbs=array(
    'View Asuransi'=>array('index'),
    $model->penjamin_id,
);

$arrMenu = array();
    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Asuransi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
    'data'=>$model,
    'attributes'=>array(
        
        array(
                    'label'=>'Nama Asuransi',
                    'type'=>'raw',
                    'value'=>$model->penjamin_nama,
                ),
        array(
                    'label'=>'Nama Lain',
                    'type'=>'raw',
                    'value'=>$model->penjamin_namalainnya,
                ),
        array(
                    'label'=>'Jenis Penjamin',
                    'type'=>'raw',
                     'value'=>$model->carabayar->carabayar_nama,
                 ),
    ),
)); ?>