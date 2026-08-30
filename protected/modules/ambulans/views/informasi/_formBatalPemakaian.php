
<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'batalPemakaian-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        )
    );
?>
<p class="help-block">
    <?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?>
</p>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->hiddenField($model,'pemakaianambulans_id',array('class'=>'span3 ','readonly'=>true));?>
<?php echo $form->textFieldRow($model,'tglpembatalan',array('class'=>'span3 realtime','readonly'=>true));?>
<?php echo $form->textareaRow($model,'alasanpembatalanambulans',array('class'=>'span4','cols'=>30,'rows'=>5, 'onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
            
<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
    ?>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
	$(document).ready(function(){
        var pemakaian_id = $("#temp_idPemakaian").val();
		document.getElementById('AMBatalpakaiambulansT_pemakaianambulans_id').value = pemakaian_id;
    });
</script>