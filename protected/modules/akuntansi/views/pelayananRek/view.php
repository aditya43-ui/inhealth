<?php
$this->breadcrumbs=array(
	'Jurnal Rekening Penjamin'=>array('index'),
	$model->ruangan_id, $model->daftartindakan_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jurnal Rekening Pelayanan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rekening Pelayanan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array(
                    'label'=>'Jenis Pelayanan',
                    'type'=>'raw',
                    'value'=>$model->jnspelayanan,
                ),
		array(
                    'label'=>'Ruangan',
                    'type'=>'raw',
                    'value'=>!empty($model->ruangan_id)?$model->ruangan->ruangan_nama:" -	",
                ),
		array(
                    'label'=>'Nama Pelayanan',
                    'type'=>'raw',
                    'value'=>$model->daftartindakan->daftartindakan_nama,
                ),
        array(
             		'label'=>'Rekening Debit',
             		'type'=>'raw',
             		'value'=>$this->renderPartial('_viewDebit',array('daftartindakan_id'=>$model->daftartindakan_id,'ruangan_id'=>$model->ruangan_id,'saldonormal'=>"D"),true),
												),
        array(
             		'label'=>'Rekening Kredit',
             		'type'=>'raw',
             		'value'=>$this->renderPartial('_viewDebit',array('daftartindakan_id'=>$model->daftartindakan_id,'ruangan_id'=>$model->ruangan_id,'saldonormal'=>"K"),true),
                 ),
	),
)); ?>

<?php $this->widget('UserTips',array('type'=>'view'));?>