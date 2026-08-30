
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pendaftaran-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'statusperiksa'),
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>
<legend class="rim">Ubah Status Periksa Pasien </legend>
	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
        <?php echo $form->errorSummary(array($model,$modBatalPeriksa)); ?>
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
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                            )); 
                                     ?>
                        </div>
                    </div>
                     <?php echo $form->dropDownListRow($model,'statusperiksa', LookupM::getItems('statusperiksa'),array('empty'=>'-- Pilih --','onChange'=>'updateFormStatus();')); ?>
                     
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <div id="divFormBatalPeriksa">
                        <div class="control-group">
                            <?php echo $form->labelEx($modBatalPeriksa,'tglbatal', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php   
                                        $this->widget('MyDateTimePicker',array(
                                                        'model'=>$modBatalPeriksa,
                                                        'attribute'=>'tglbatal',
                                                        'mode'=>'date',
                                                        'options'=> array(
                                                            'dateFormat'=>Params::DATE_FORMAT,
                                                            'maxDate' => 'd',
                                                        ),
                                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                                )); 
                                         ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modBatalPeriksa,'keterangan_batal', array('class'=>'control-label')) ?>
                            <div class="controls">
                                <?php   
                                     echo $form->textArea($modBatalPeriksa,'keterangan_batal',array('class'=>'span3','row'=>4,'cols'=>'5'));
                                 ?>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
	<div class="form-actions">
            <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                        Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                    Yii::app()->createAbsoluteUrl('rawatJalan/daftarPasien/index'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'$("#dialogUbahStatus").attr("src",$(this).attr("href")); window.parent.$("#dialogUbahStatus").dialog("close");return false;'));
            ?>
	</div>

<?php $this->endWidget(); ?>

<script>
    $('#PPPendaftaranT_statusperiksa').focus();
    function updateFormStatus(){
        var status = $('#PendaftaranT_statusperiksa').val();
        
        if(status == 'BATAL PERIKSA'){
            $('#divFormBatalPeriksa').show();
        }else{
            $('#divFormBatalPeriksa').hide();
        }
    } 
</script>