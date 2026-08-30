<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	\$model->{$nameColumn},
);\n";
?>
?>
<legend class="rim2">Lihat <?php echo $this->modelClass; ?></legend>
<?php echo "<?php \$this->widget('bootstrap.widgets.BootAlert'); ?>\n"; ?>
<?php
$element = count($this->tableSchema->columns);
?>
<div class="row">
    <div class="span6">
    <?php echo "<?php"; ?> $this->widget('ext.bootstrap.widgets.BootDetailView',array(
			'data'=>$model,
			'attributes'=>array(
<?php
$count = 0;
foreach($this->tableSchema->columns as $column){
	if($count < round($element/2))
	echo "\t\t\t\t'".$column->name."',\n";
	else
	echo "\t\t\t\t//'".$column->name."',\n";
	
	$count++;
}
		?>
			),
    )); ?>
    </div>
    <div class="span6">
		<?php echo "<?php"; ?> $this->widget('ext.bootstrap.widgets.BootDetailView',array(
			'data'=>$model,
			'attributes'=>array(
<?php
$count = 0;
foreach($this->tableSchema->columns as $column){
	if($count >= round($element/2))
	echo "\t\t\t\t'".$column->name."',\n";
	else
	echo "\t\t\t\t//'".$column->name."',\n";

	$count++;
}
?>
			),
    )); ?>
    </div>
</div>
<div class="row">
    <div class="form-actions">
    <?php echo "<?php echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class=\"entypo-pencil\"></i>')),\$this->createUrl('update',array('id'=>\$model->".$this->tableSchema->primaryKey.",'modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>\n"; ?>
    <?php echo "<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan ".$this->modelClass."',array('{icon}'=>'<i class=\"icon-folder-open icon-white\"></i>')),\$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>\n"; ?>
    <?php echo "<?php \$this->widget('UserTips',array('content'=>''));?>\n" ?>
    </div>
</div>
