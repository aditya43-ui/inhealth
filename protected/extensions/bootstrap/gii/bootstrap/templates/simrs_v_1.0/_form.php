
<?php echo "<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>\n" ?>
<?php echo "<?php \$form=\$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>\n"; ?>

	<p class="help-block"><?php echo '<?php echo Yii::t(\'mds\',\'Fields with <span class="required">*</span> are required.\') ?>' ?></p>

	<?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>

<?php
foreach($this->tableSchema->columns as $column)
{
	if($column->autoIncrement)
		continue;
?>
            <?php echo "<?php echo ".$this->bssGenerateActiveRow($this->modelClass,$column)."; ?>\n"; ?>
<?php
}
?>
	<div class="form-actions">
		<?php /*echo "<?php echo CHtml::submitButton(\$model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>\n";*/ ?>
                <?php echo "<?php echo CHtml::htmlButton(\$model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class=\"icon-ok icon-white\"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class=\"icon-ok icon-white\"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>\n"; ?>
                <?php echo "<?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class=\"icon-ban-circle icon-white\"></i>')), 
                        Yii::app()->createUrl(\$this->module->id.'/$this->controllerID/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'if(!confirm(\"'.Yii::t('mds','Do You want to cancel?').'\")) return false;')); ?>\n" ?>
	</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>