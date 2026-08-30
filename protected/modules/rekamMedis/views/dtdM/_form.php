
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sadtd-m-form',
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
                     <?php echo $form->textFieldRow($model,'dtd_noterperinci',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                     <div class="control-group">
                      <?php echo $form->labelEx($model,'tabularlist_id',array('class'=>'control-label required')); ?>
                         <div class="controls inline">
                      <?php echo $form->dropDownList($model,'tabularlist_id',  CHtml::listData($model->getTabularItems(), 'tabularlist_id', 'tabularlist_block'), 
                                          array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                'class'=>'span3')); ?> 
                         </div> 
                     </div>
                     <?php echo $form->textFieldRow($model,'dtd_nourut',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                     <?php echo $form->textFieldRow($model,'dtd_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                </td>
                <td>
                     <?php echo $form->textFieldRow($model,'dtd_kode',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                     <?php echo $form->textFieldRow($model,'dtd_nama',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                     <?php echo $form->textFieldRow($model,'dtd_katakunci',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                     <?php echo $form->checkBoxRow($model,'dtd_menular', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                     <?php echo $form->labelEx($modDTDDiagnosaM,'diagnosa_id',array('class'=>'control-label')); ?>
                        <div class="control-group">
                            <div class="controls">

                                 <?php 
                                       $this->widget('application.extensions.emultiselect.EMultiSelect',
                                                     array('sortable'=>true, 'searchable'=>true)
                                                );
                                        echo CHtml::listBox(
                                        'diagnosa_id[]',
                                        '',
                                        CHtml::listData($model->getDiagnosaItems(), 'diagnosa_id', 'diagnosa_nama'),
                                        array('multiple'=>'multiple','key'=>'diagnosa_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                                                );
                                  ?>
                            </div>
                        </div>
                </td>
            </tr>
        </table>
            <?php //echo $form->checkBoxRow($model,'dtd_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.dtdM.'/admin'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
	$content = $this->renderPartial('../tips/informasi',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
	</div>

<?php $this->endWidget(); ?>
