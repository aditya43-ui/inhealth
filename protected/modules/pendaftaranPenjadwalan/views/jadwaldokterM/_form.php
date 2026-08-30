

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
            <?php echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData(PPPendaftaranT::model()->getRuanganItems(), 'ruangan_id', 'ruangan_nama') ,
                                                      array('empty'=>'-- Pilih --',
                                                            'onchange'=>"listDokterRuangan(this.value)",
                                                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($model,'pegawai_id', CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($model,'jadwaldokter_hari', $listHari ,array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'empty'=>'- Pilih -')); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'jadwaldokter_mulai', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'jadwaldokter_mulai',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,
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
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,
                                                                 'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                 'onFocus'=>"compare();",),
                    )); ?><?php echo $form->error($model, 'jadwaldokter_tutup'); ?>
                    
                </div>
            </div>
            <?php echo $form->textFieldRow($model,'maximumantrian',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
           
	<div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl('admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
$content = $this->renderPartial($this->path_view.'tips/tipsAdmin',array(),true);
$this->widget('TipsMasterData',array('type'=>'transaksi','content'=>$content));  ?>
	
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