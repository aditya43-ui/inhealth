<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<div class="white-container">
<?php
echo "<?php\n";
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label',
);\n";
?>
	$this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo "<?php"; ?> $this->widget('ext.bootstrap.widgets.BootListView',array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
	)); ?>

	<div class="row">
		<div class="form-actions">
			<?php echo "<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan ".$this->modelClass."',array('{icon}'=>'<i class=\"icon-folder-open icon-white\"></i>')),\$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>\n"; ?>
			<?php echo "<?php \$this->widget('UserTips',array('content'=>''));?>\n" ?>
		</div>
	</div>
</div>
