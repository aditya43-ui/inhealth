<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ppbuat-janji-poli-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

	<!-- <p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p> -->

	<?php echo $form->errorSummary($modPPBuatJanjiPoli); ?>
        <table>
            <tr>
                <td colspan="2">
                   <?php echo $form->textFieldRow($modPPBuatJanjiPoli,'no_rekam_medik',array('value'=>$modPPBuatJanjiPoli->pasien->no_rekam_medik,'readonly'=>TRUE,'placeholder'=>'No. Rekam Medik','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
              
            </tr>
            <tr>
                
                <td>
                        <?php echo $form->dropDownListRow($modPPBuatJanjiPoli,'ruangan_id', CHtml::listData($modPPBuatJanjiPoli->getRuanganItems(), 'ruangan_id', 'ruangan_nama') ,
                                                      array('empty'=>'-- Pilih --',
                                                             'onchange'=>"listDokterRuangan(this.value);",
                                                             'ajax'=>array(),
                                                           
                                                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>    
                </td>
                <td>
                    <?php echo $form->dropDownListRow($modPPBuatJanjiPoli,'pegawai_id', CHtml::listData($modPPBuatJanjiPoli->getDokterItems(),'pegawai_id','nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="control-group">
                    <?php echo $form->labelEx($modPPBuatJanjiPoli,'tgljadwal', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modPPBuatJanjiPoli,
                                                    'attribute'=>'tgljadwal',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                        //
                                                        'onkeypress'=>"js:function(){getUmur(this);}",
                                                        'onSelect'=>'js:function(){hariBaru(this);}',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                            <?php echo $form->error($modPPBuatJanjiPoli, 'tgljadwal'); ?>
                        </div>
                    </div>
                </td>
                <td>
                     <?php echo $form->textFieldRow($modPPBuatJanjiPoli,'harijadwal',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>TRUE)); ?>
                </td>
                
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo $form->textAreaRow($modPPBuatJanjiPoli,'keteranganbuatjanji',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
             
            </tr>
        </table>
             <div class="form-actions">
	    <?php echo CHtml::htmlButton($modPPBuatJanjiPoli->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.buatJanjiPoliT.'/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'if(!confirm("'.Yii::t('mds','Do You want to cancel?').'")) return false;')); ?>
	</div>

<?php $this->endWidget(); ?>

<?php
$urlListDokterRuangan = Yii::app()->createUrl('actionDynamic/listDokterRuangan');
$urlGetHari = Yii::app()->createUrl('ActionAjax/GetHari');
$js = <<< JS
$('#isPasienBaru').change(function(){
    if ($(this).is(':checked'))
      {
        $('#no_rekam_medik').attr('disabled','true');
        $('#divPasien').slideDown(500);
        $('#controlNoRekamMedik button').attr('disabled','true');

      }
    else
      {
         $('#no_rekam_medik').removeAttr('disabled');
         $('#divPasien').slideUp(500);
         $('#controlNoRekamMedik button').removeAttr('disabled');

      }  
});

function hariBaru()
    {
        var tanggal = $('#PPBuatJanjiPoliT_tgljadwal').val();
            $.post("${urlGetHari}",{tanggal: tanggal},
            function(data){

               $('#PPBuatJanjiPoliT_harijadwal').val(data.hari); 

       },"json");
       
    
    }

function listDokterRuangan(idRuangan)
{
    $.post("${urlListDokterRuangan}", { idRuangan: idRuangan },
        function(data){
            $('#PPBuatJanjiPoliT_pegawai_id').html(data.listDokter);
    }, "json");
}
JS;
Yii::app()->clientScript->registerScript('fungsipasien',$js,CClientScript::POS_READY);
?>
