<div class="white-container">
<?php
$this->breadcrumbs=array(
	'Saanastesi Ms',
);
	$this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
		'dataProvider'=>$dataProvider,
		'itemView'=>$this->path_view.'_view',
	)); ?>

	<div class="row-fluid">
		<div class="form-actions">
			<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Anestesi',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
			<?php 
				$content = $this->renderPartial($this->path_tips.'master',array(),true);
				$this->widget('UserTips',array('type'=>'master','content'=>$content)); 
			?>
		</div>
	</div>
</div>
