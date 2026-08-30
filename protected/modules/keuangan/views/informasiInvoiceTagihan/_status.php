<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
        array(
            'id'=>'ubahstatusverifikasi-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        )
    );
?>
<?php
	$this->widget('bootstrap.widgets.BootAlert');
?>
<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
<?php echo $form->errorSummary($model); ?>
<?php echo $form->dropDownListRow($model, 'status_verifikasi', KUInformasiinvoicetagihanV::statusVerifikasi(), array('empty'=>'-- Pilih --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<div class="control-group">
            <?php echo $form->labelEx($model,'tgl_verfikasi_tagihan', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php 
                $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tgl_verfikasi_tagihan',
                                'mode'=>'datetime',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'timeFormat'=>  Params::TIME_FORMAT,
                                    'maxDate'=> 'd',
                                ),
                                'htmlOptions'=>array('readonly'=>true,
				'class'=>'dtPicker3',
				'onkeypress'=>"return $(this).focusNextInputField(event);",
				),
                )); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'verifikator_nama'); ?>

<div class="form-actions">
    <?php
        echo CHtml::htmlButton(
                Yii::t('mds','{icon} Save', array('{icon}'=>'<i class="entypo-check"></i>')), 
                array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')
            );
    ?>
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="entypo-cancel"></i>')),
                        array('class' => 'btn btn-default', 'type'=>'button', 'name'=>'btn_batal','onclick'=>'close_dialog()')); ?> 	
</div>

<?php $this->endWidget(); ?>
