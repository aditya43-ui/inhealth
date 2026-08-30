<div class="white-container">
<?php
$this->breadcrumbs=array(
	'Saalatmedis Ms',
);
	$this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
		'dataProvider'=>$dataProvider,
		'itemView'=>$this->path_view.'_view',
	)); ?>

	<div class="row-fluid">
		<div class="form-actions">
			<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Alat Medis',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
			<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
