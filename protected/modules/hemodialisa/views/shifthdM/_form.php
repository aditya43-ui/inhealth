<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'resephd-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#'.CHtml::activeId($model,'shift_hd_nama')
)); ?>

	<p class="help-block" style="color:#333"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
            <div class = "col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'Nama Shift <span class="required">*</span>',array('class'=>'span3 control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'shift_hd_nama',array('class'=>'span3 required', 'onkeyup'=>"shiftNama(this);", 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'Nama Lainnya <span class="required">*</span>',array('class'=>'span3 control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'shift_hd_namalainnya',array('class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">Jam Awal Shift</label>
                    <div class="controls">
                        <?php   
                            $model->shift_hd_jamawal = (!empty($model->shift_hd_jamawal) ? date('H:i:s', strtotime($model->shift_hd_jamawal)) : '00:00:00');
                            $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'shift_hd_jamawal',
                            'mode'=>'time',
                            'options'=> array(
                                    'showOn' => false,
                                    'maxDate' => 'd',
                                    'yearRange'=> "-150:+0",
                            ),
                            'htmlOptions'=>array('placeholder'=>"$model->shift_hd_jamawal", 'readonly'=>true, 'class'=>'dtPicker2 timemask', 'style'=>'width: 150px;'),
                        )); 
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Jam Akhir Shift</label>
                    <div class="controls">
                        <?php   
                            $model->shift_hd_jamakhir = (!empty($model->shift_hd_jamakhir) ? date('H:i:s', strtotime($model->shift_hd_jamakhir)) : '00:00:00');
                            $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'shift_hd_jamakhir',
                            'mode'=>'time',
                            'options'=> array(
                                    'showOn' => false,
                                    'maxDate' => 'd',
                                    'yearRange'=> "-150:+0",
                            ),
                            'htmlOptions'=>array('placeholder'=>"$model->shift_hd_jamakhir", 'readonly'=>true, 'class'=>'dtPicker2 timemask', 'style'=>'width:150px;'),
                        )); 
                            
                        ?>
                    </div>
                </div>
                
                <?php echo $form->textFieldRow($model,'shift_hd_urutan',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                <?php // echo $form->textAreaRow($model,'resephd_desc',array('rows'=>2, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                
                <div class="control-group">
                    <?php echo CHtml::label("","",array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->checkBox($model,'shift_hd_aktif',array('checked'=>true,'onkeyup'=>"return $(this).focusNextInputField(event);")); ?> <label>Aktif</label>
                    </div>
                </div>
                    <?php // echo $form->checkBoxRow($model,'resephd_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-default',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Shift HD',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>''));?>
		</div>
	</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">

    function shiftNama(nama)
    {
        document.getElementById('ShiftHdM_shift_hd_namalainnya').value = nama.value.toUpperCase();
        document.getElementById('ShiftHdM_shift_hd_nama').value = nama.value;
    }
</script>