

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'slotbed-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#SASotbedM_instalasi',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->dropDownListRow($model,'jadwal_hari', $listHari ,array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'empty'=>'- Pilih -')); ?>
            <?php echo $form->textFieldRow($model, 'estimasipelayanan', array('class'=>'span2 numbers-only estimasipelayanan', 'onblur'=>'hitungJumlahPasienDariEstimasi()')); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'jadwal_mulai', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'jadwal_mulai',
                                            'mode'=>'time',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,
                                                                'class'=>'jadwal_mulai',
                                                                'onchange'=>'hitungJumlahPasienDariEstimasi()',
                                                                 'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                 ),
                    )); ?> <?php echo $form->error($model, 'jadwal_mulai'); ?>
                   
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'jadwal_tutup', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'jadwal_tutup',
                                            'mode'=>'time',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,
                                                                'class'=>'jadwal_tutup',
                                                                'onchange'=>'hitungJumlahPasienDariEstimasi()',
                                                                 'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                 'onFocus'=>"compare();",),
                    )); ?><?php echo $form->error($model, 'jadwal_tutup'); ?>
                    
                </div>
            </div>
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-floppy"></i>')),
                                    array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                    $this->createUrl('admin'), 
                                    array('class'=>'btn btn-danger',
                                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jadwal Bed',array('{icon}'=>'<i class="entypo-folder"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
                                              <?php
                            $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips/tipsaddedit4',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                        ?>
    </div>

<?php $this->endWidget(); ?>
<?php
$jscript = <<< JS

function hitungJumlahPasienDariEstimasi() {
    var jam_awal = timeStringToFloat($(".jadwal_mulai").val());
    var jam_akhir = timeStringToFloat($(".jadwal_tutup").val());
    var estimasi = $(".estimasipelayanan").val();
    var selisih = 0;

    if (jam_akhir >= jam_awal) {
        selisih = Math.ceil((jam_akhir - jam_awal) / estimasi) + 1;
    }

    $(".maximumantrian").val(selisih);
    $(".maximumbpjsantrian").val(selisih);
    $(".maksbuatjanji").val(selisih);
}

function timeStringToFloat(time) {
  var hoursMinutes = time.split(/[.:]/);
  var hours = parseInt(hoursMinutes[0], 10);
  var minutes = hoursMinutes[1] ? parseInt(hoursMinutes[1], 10) : 0;
  return (hours * 60) + minutes;
}

function compare()
{
    var endDateTextBox = $('#SASotbedM_jadwal_tutup');
    var dateText = $('#SASotbedM_jadwal_mulai').val();
    if (endDateTextBox.val() != '') 
    {
        var testStartDate = new Date(dateText);
        var testEndDate = new Date(endDateTextBox.val());
        if (testStartDate > testEndDate)
            endDateTextBox.val(dateText);
    }
    else 
    {
        endDateTextBox.val(dateText);
    } 
}
JS;
?>
