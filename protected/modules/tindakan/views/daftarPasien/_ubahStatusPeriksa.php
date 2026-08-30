
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ubahstatusperiksa-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

<legend class="rim">Ubah Status Periksa Pasien </legend>
	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
        <?php echo $form->errorSummary($model); ?>
        <table class="table">
            <tr>
                <td>
                     <div class="control-group">
                        <?php echo CHtml::label('Tgl. Selesai Periksa','tglselesaiperiksa', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tglselesaiperiksa',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                            )); 
                                     ?>
                        </div>
                    </div>
                     <?php echo $form->dropDownListRow($model,'statusperiksa', LookupM::getItems('statusperiksa'),array('empty'=>'-- Pilih --')); ?>
                     
                </td>
            </tr>
        </table>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createAbsoluteUrl('rawatJalan/daftarPasien/index'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'$("#dialogUbahStatus").attr("src",$(this).attr("href")); window.parent.$("#dialogUbahStatus").dialog("close");return false;'));  
$content = $this->renderPartial('../tips/informasi',array(),true);
//$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
	</div>

<?php $this->endWidget(); ?>
