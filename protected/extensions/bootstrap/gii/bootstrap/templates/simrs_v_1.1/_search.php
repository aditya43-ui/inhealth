<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php \$form=\$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl(\$this->route),
	'method'=>'get',
	'id'=>'".$this->class2id($this->modelClass)."-search',
	'type'=>'horizontal',
)); ?>\n"; ?>

<?php foreach($this->tableSchema->columns as $column): ?>
<?php
	$field=$this->generateInputField($this->modelClass,$column);
	if(strpos($field,'password')!==false)
		continue;
?>
	<?php 
		if($column->isPrimaryKey)
			echo "<?php //echo ".$this->generateActiveRow($this->modelClass,$column)."; ?>\n"; 
		else
			echo "<?php echo ".$this->generateActiveRow($this->modelClass,$column)."; ?>\n"; 
	?>

<?php endforeach; ?>
	<div class="form-actions">
		<?php echo "<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class=\"entypo-search\"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>\n"; ?>
		<?php echo "<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class=\"entypo-search\"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>\n"; ?>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>