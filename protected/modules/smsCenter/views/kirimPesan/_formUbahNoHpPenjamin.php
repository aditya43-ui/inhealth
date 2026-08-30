
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahKelPenyakit-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        )
    );
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $form->hiddenField($model, 'penjamin_id',array('readonly'=>true)); ?>

<div class="control-group">
    <?php echo CHtml::label('Nama Penjamin', 'ap', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->textField($model, 'penjamin_nama', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Nama Contact Person', 'ap', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php echo $form->textField($model, 'penjamin_cp', array('readonly' => false, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('No. Handphone Contact Person', 'k', array('class'=>'control-label')) ?>
    <div class="controls">
       <?php echo $form->textField($model, 'penjamin_nomobile', array('readonly' => false, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
    ?>
	<?php
        echo CHtml::htmlButton(
			Yii::t('mds','{icon} Cancel', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
			array('class' => 'btn btn-default', 'type'=>'button','onClick'=>'closeDialog();')
		);
    ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function closeDialog(){
            window.parent.$('#editNomor').dialog('close');
    }
</script>