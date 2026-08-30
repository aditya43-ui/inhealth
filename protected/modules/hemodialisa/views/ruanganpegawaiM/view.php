<?php
$this->breadcrumbs=array(
	'Rjruanganpegawai Ms'=>array('index'),
	$model->ruangan_id,
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Ruangan Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelas Ruangan ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

$this->menu=$arrMenu;

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ruangan.ruangan_nama',
                                array(
                                    'label'=>'Pegawai',
                                    'type'=>'raw',
                                    'value'=>$this->renderPartial('_pegawai', array('ruangan_id'=>$model->ruangan_id), true),
                                ),
	),
)); ?>
<?php $this->widget('UserTips',array('type'=>'view'));?>
