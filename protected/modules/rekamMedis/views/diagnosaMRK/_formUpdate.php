
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sadiagnosa-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($model); ?>
        <table class="table">
            <tr>
                <td>
                     <?php echo $form->textFieldRow($model,'diagnosa_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                     <?php echo $form->textFieldRow($model,'diagnosa_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                     <?php echo $form->textFieldRow($model,'diagnosa_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                </td>
                <td>
                     <?php echo $form->textFieldRow($model,'diagnosa_katakunci',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                     <?php echo $form->textFieldRow($model,'diagnosa_nourut',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                     <?php echo $form->checkBoxRow($model,'diagnosa_imunisasi', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                     <?php echo $form->checkBoxRow($model,'diagnosa_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                     <?php //echo $form->labelEx($modDTDDiagnosaM,'dtd_id',array('class'=>'control-label')); ?>
                        <div class="control-group">
                            <div class="controls">

                                 <?php 
                                  $arrDTD = array();
                                     foreach($modDTDDiagnosaM as $data){
                                        $arrDTD[] = $data['dtd_id'];
                                    } 
                                       $this->widget('application.extensions.emultiselect.EMultiSelect',
                                                     array('sortable'=>true, 'searchable'=>true)
                                                );
                                        echo CHtml::dropDownList(
                                        'dtd_id[]',
                                        $arrDTD,
                                        CHtml::listData(SADtdM::model()->findAll(array('order'=>'dtd_nama')), 'dtd_id', 'dtd_nama'),
                                        array('multiple'=>'multiple','key'=>'dtd_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                                                );
                                  ?>
                            </div>
                        </div>
                </td>
            </tr>
        </table>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.diagnosaM.'/admin'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
	</div>

<?php $this->endWidget(); ?>
