<div class="row">
<div class="col-md-12">
	<div class="panel panel-success">
	<div class="panel-heading">
		<div class="panel-title">Tambah Klasifikasi Sub Kelas</div>
	</div>
	<div class="panel-body">
<?php
$this->breadcrumbs=array(
	'Sub Kelas'=>array('index'),
	'Create',
);

$this->menu=array(
//        array('label'=>Yii::t('mds','Create').' Asal Rujukan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
//	array('label'=>Yii::t('mds','List').' Asal Rujukan', 'icon'=>'list', 'url'=>array('index')),
//	array('label'=>Yii::t('mds','Manage').' Asal Rujukan', 'icon'=>'folder-open', 'url'=>array('admin')),
);

$this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo $this->renderPartial($this->path_view.'_form', array('model'=>$model)); ?>
    <?php //$this->widget('UserTips',array('type'=>'create'));?>
	</div>
	</div>
</div>
</div>
