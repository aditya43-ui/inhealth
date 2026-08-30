

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'rdjadwaldokter-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#PPJadwaldokterM_ruangan_id',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

            <?php echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData(PPPendaftaranT::model()->getRuanganJadwalDokter(), 'ruangan_id', 'ruangan_nama') ,
                                                      array('empty'=>'-- Pilih --',
                                                            'onchange'=>"listDokterRuangan(this.value)",
                                                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($model,'pegawai_id', CHtml::listData(PPPendaftaranT::model()->getDokterItems($model->ruangan_id), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($model,'jadwaldokter_hari', $listHari ,array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'empty'=>'- Pilih -')); ?>
            <?php echo $form->textFieldRow($model, 'estimasipelayanan', array('class'=>'span2 numbers-only estimasipelayanan', 'onblur'=>'hitungJumlahPasienDariEstimasi()')); ?>
            <?php echo $form->textFieldRow($model, 'maximumantrian', array('class'=>'span2 numbers-only maximumantrian')); ?>
            <?php echo $form->textFieldRow($model, 'maximumbpjsantrian', array('class'=>'span2 numbers-only maximumbpjsantrian')); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'jadwaldokter_mulai', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'jadwaldokter_mulai',
                                            'mode'=>'time',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,
                                                                'class'=>'jadwaldokter_mulai',
                                                                'onchange'=>'hitungJumlahPasienDariEstimasi()',
                                                                 'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                 ),
                    )); ?> <?php echo $form->error($model, 'jadwaldokter_mulai'); ?>
                   
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'jadwaldokter_tutup', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'jadwaldokter_tutup',
                                            'mode'=>'time',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,
                                                                'class'=>'jadwaldokter_tutup',
                                                                'onchange'=>'hitungJumlahPasienDariEstimasi()',
                                                                 'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                 'onFocus'=>"compare();",),
                    )); ?><?php echo $form->error($model, 'jadwaldokter_tutup'); ?>
                    
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
                        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jadwal Dokter',array('{icon}'=>'<i class="entypo-folder"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
                                              <?php
                            $content = $this->renderPartial('../tips/tipsaddedit4',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                        ?>
    </div>

<?php $this->endWidget(); ?>
<?php
$urlListDokterRuangan = $this->createUrl('AjaxListDokter');
$jscript = <<< JS
function listDokterRuangan(idRuangan)
{
    $.post("${urlListDokterRuangan}", { idRuangan: idRuangan },
        function(data){
            $('#PPJadwaldokterM_pegawai_id').html(data.listDokter);
    }, "json");
}

function hitungJumlahPasienDariEstimasi() {
    var jam_awal = timeStringToFloat($(".jadwaldokter_mulai").val());
    var jam_akhir = timeStringToFloat($(".jadwaldokter_tutup").val());
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
    var endDateTextBox = $('#PPJadwaldokterM_jadwaldokter_tutup');
    var dateText = $('#PPJadwaldokterM_jadwaldokter_mulai').val();
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
Yii::app()->clientScript->registerScript('jsDokter',$jscript, CClientScript::POS_BEGIN);
?>
