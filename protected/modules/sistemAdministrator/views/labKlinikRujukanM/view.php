<?php
$this->breadcrumbs=array(
	'Salab Klinik Rujukan Ms'=>array('index'),
	$model->labklinikrujukan_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Lab Klinik Rujukan #'.$model->labklinikrujukan_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Lab Klinik Rujukan', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Lab Klinik Rujukan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Lab Klinik Rujukan', 'icon'=>'pencil','url'=>array('update','id'=>$model->labklinikrujukan_id))) :  '' ;
                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Lab Klinik Rujukan','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->labklinikrujukan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Lab Klinik Rujukan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'labklinikrujukan_id',
		'labklinikrujukan_nama',
		'labklinikrujukan_alamat',
		'labklinikrujukan_telp',
		'labklinikrujukan_mobile',
		'labklinikrujukan_dokterpj',
		array(            
                                            'label'=>'Aktif',
                                            'type'=>'raw',
                                            'value'=>(($model->labklinikrujukan_aktif==1)? ''.Yii::t('mds','Yes').'' : ''.Yii::t('mds','No').''),
                                        ),
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>