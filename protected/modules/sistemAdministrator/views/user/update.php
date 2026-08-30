
<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->user_id=>array('view','id'=>$model->user_id),
	'Update',
);

$this->menu=array(
        array('label'=>Yii::t('mds','Update').' User #'.$model->user_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
	array('label'=>Yii::t('mds','List').' User', 'icon'=>'list', 'url'=>array('index')),
	array('label'=>Yii::t('mds','Create').' User', 'icon'=>'file', 'url'=>array('create')),
	array('label'=>Yii::t('mds','View').' User', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->user_id)),
	array('label'=>Yii::t('mds','Manage').' User', 'icon'=>'folder-open', 'url'=>array('admin')),
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo $this->renderPartial('_formUpdate',array('model'=>$model)); ?>
<?php //$this->widget('UserTips',array('type'=>'update','content'=>'<ol><b>Ganti Password</b><li>Isi Kolom Password lama, password baru apabila ingin mengganti password Anda.</li></ol>'));?>