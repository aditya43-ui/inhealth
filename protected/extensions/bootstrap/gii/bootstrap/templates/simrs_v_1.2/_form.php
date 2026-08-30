<?php echo "<?php \$form=\$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>\n"; ?>

	<p class="help-block"><?php echo '<?php echo Yii::t(\'mds\',\'Fields with <span class="required">*</span> are required.\') ?>' ?></p>

	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

	<div class="row">

<?php
$element = count($this->tableSchema->columns);
$count = 0;
foreach($this->tableSchema->columns as $column)
{
	if($column->autoIncrement)
		continue;
		//split form
		if($count == 0){
			echo "\t\t<div class = \"span4\">\n";
		}
?>
			<?php echo "<?php echo ".$this->bssGenerateActiveRowV11($this->modelClass,$column)."; ?>\n"; ?>
<?php
		if($count == round($element/2)){
			echo "\t\t</div>\n\t\t<div class = \"span4\">\n";
		}else if($count == round($element-1)){
			echo "\t\t</div>\n";
		}
		$count++;
}   
?>
		</div>
		<div class="span4">
				
		</div>
	</div>
	<div class="row">
	<div class="form-actions">
		<?php echo "<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class=\"icon-ok icon-white\"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>\n"; ?>
		<?php echo "<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class=\"icon-refresh icon-white\"></i>')), 
				\$this->createUrl('create'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>\n" ?>
		<?php echo "<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan ".$this->modelClass."',array('{icon}'=>'<i class=\"icon-folder-open icon-white\"></i>')),\$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>\n"; ?>
		<?php echo "<?php \$this->widget('UserTips',array('content'=>''));?>\n" ?>
		</div>
	</div>
<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
