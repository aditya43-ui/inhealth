
<div class="row">
<div class="col-md-12">
	<div class="panel panel-success">
	<div class="panel-heading">
		<div class="panel-title">Ubah Sub Kelas</div>
	</div>
	<div class="panel-body"><?php
$this->breadcrumbs=array(
	'Domain'=>array('index'),
	$model->subkelas_id=>array('view','id'=>$model->subkelas_id),
	'Update',
);

$this->menu=array(
//        array('label'=>Yii::t('mds','Update').' Asal Rujukan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
//	array('label'=>Yii::t('mds','List').' Asal Rujukan', 'icon'=>'list', 'url'=>array('index')),
//	array('label'=>Yii::t('mds','Create').' Asal Rujukan', 'icon'=>'file', 'url'=>array('create')),
//	array('label'=>Yii::t('mds','View').' Asal Rujukan', 'icon'=>'eye-open', 'url'=>array('view','id'=>$model->asalrujukan_id)),
//	array('label'=>Yii::t('mds','Manage').' Asal Rujukan', 'icon'=>'folder-open', 'url'=>array('admin')),
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_formUpdate',array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'update'));?>
	</div>
	</div>
</div>
</div>