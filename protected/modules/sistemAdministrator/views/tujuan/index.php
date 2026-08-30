<?php
$this->breadcrumbs=array(
	'Sarekeningcolumn Ms',
);
?>
<div class="white-container">
	$this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php $this->widget('ext.bootstrap.widgets.BootListView',array(
		'dataProvider'=>$dataProvider,
		'itemView'=>$this->path_view.'_view',
	)); ?>

	<div class="row">
		<div class="form-actions">
			<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
			<?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="entypo-cancel"></i>')), 
					$this->createUrl('admin'), 
					array('class'=>'btn btn-danger',
						  'onclick'=>'if(!confirm("'.Yii::t('mds','Do You want to cancel?').'")) return false;')); ?>
			<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Ekspektasi',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
			<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
</div>
