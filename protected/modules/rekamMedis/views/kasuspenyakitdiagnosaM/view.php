<?php
$this->breadcrumbs=array(
	'RIkasuspenyakitdiagnosa Ms'=>array('index'),
	$model->jeniskasuspenyakit_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Diagnosa Kasus Penyakit ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Diagnosa Kasus Penyakit ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'jeniskasuspenyakit.jeniskasuspenyakit_nama',
                                array(
                                    'label'=>'Diagnosa',
                                    'type'=>'raw',
                                    'value'=>$this->renderPartial('_diagnosa', array('jeniskasuspenyakit_id'=>$model->jeniskasuspenyakit_id), true),
                                ),
	),
)); ?>
<?php $this->widget('UserTips',array('type'=>'view'));?>
