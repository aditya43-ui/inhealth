
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rujukandari-add-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#RujukandariM_asalrujukan_id',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php
                echo $form->dropDownListRow($model, 'asalrujukan_id', CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = TRUE ORDER BY asalrujukan_nama ASC'), 'asalrujukan_id', 'asalrujukan_nama'),array('empty'=>'-- Pilih --',
                                                                            'onkeypress'=>"return $(this).focusNextInputField(event)")); 
            ?>
            <?php echo $form->textFieldRow($model,'namaperujuk',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'spesialis',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            <?php echo $form->textAreaRow($model,'alamatlengkap',array('rows'=>5, 'cols'=>30, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->textFieldRow($model,'notelp',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'ppkrujukan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
	
	<div class="form-actions">
                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                   Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                                    array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    var idAsalRujukan = $('#divRujukan').find('select[name$="[asalrujukan_id]"]').val();
    $('#dialogAddNamaRujukan div.divForFormNamaRujukan #RujukandariM_asalrujukan_id').val(idAsalRujukan);
</script>