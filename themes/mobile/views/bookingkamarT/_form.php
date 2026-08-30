
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ppbooking-kamar-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>


<fieldset>
    <legend class="rim2">Booking Kamar</legend>
<!--        <!-- <p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p> -->-->
    <?php echo $form->errorSummary(array($model,$modPasien)); ?>
    <table width="22%" class="table-condensed" >
      <tr>
        <td rowspan="2" ><?php echo $this->renderPartial('_formPasienBookingKamar',array('form'=>$form,'model'=>$model,'modPasien'=>$modPasien)); ?> </td>
      </tr>
    </table>
    <fieldset>
        <legend class="rim">Data Booking</legend>
            <?php echo $form->hiddenField($model,'pasienadmisi_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
            <?php echo $form->hiddenField($model,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
            <?php echo $form->hiddenField($model,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
            <?php echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData(KamarruanganM::model()->getRuanganItems(Params::INSTALASI_ID_RI), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --',
                                                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                'ajax'=>array(
                                                                    'type'=>'POST',
                                                                    'url'=>Yii::app()->createUrl('ActionDynamic/GetKamarRuangan',array('encode'=>false,'namaModel'=>'PPBookingKamarT')),
                                                                    'update'=>'#PPBookingKamarT_kamarruangan_id',))); 
            ?>

            <?php echo $form->dropDownListRow($model,'kamarruangan_id', array(),array('empty'=>'-- Pilih --',
                                                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                'ajax'=>array(
                                                                    'type'=>'POST',
                                                                    'url'=>Yii::app()->createUrl('ActionDynamic/GetKelasPelayanan',array('encode'=>false,'namaModel'=>'PPBookingKamarT')),
                                                                    'update'=>'#PPBookingKamarT_kelaspelayanan_id',))); 
            ?>

            <?php echo $form->dropDownListRow($model,'kelaspelayanan_id', array() ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>

            <?php echo $form->textFieldRow($model,'bookingkamar_no',array('class'=>'span3', 'readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>

            <div class='control-group'>
            <?php echo $form->labelEx($model,'tglbookingkamar', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tglbookingkamar',
                                            'mode'=>'datetime',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
                                                'minDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"),
                    )); ?>
                    <?php echo $form->error($model, 'tglbookingkamar'); ?>
                </div>
            </div>
        <?php echo $form->dropDownListRow($model,'statusbooking', LookupM::getItems('statusbooking'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
    </fieldset>
</fieldset>
<div class='form-actions'>
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Kirim',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                               Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl(''), array('class'=>'btn btn-danger')); ?>
			<?php $this->endWidget(); ?>
</div>
<script>
    function enableInputNoPend(obj)
    {

        if(!obj.checked) {
            $('#inputNoPendaftaran input').attr('disabled','true');
            $('#inputNoPendaftaran button').attr('disabled','true');
        }
        else {
            $('#inputNoPendaftaran input').removeAttr('disabled');
            $('#inputNoPendaftaran button').removeAttr('disabled');
            getRuanganberdasarkanRM(obj);

        }
    }
</script>
<?php
$enableInputPendaftaran = ($model->isNoPendaftaran) ? 1 : 0;
$js = <<< JS
if(${enableInputPendaftaran}) {
            $('#inputNoPendaftaran input').attr('disabled','true');
            $('#inputNoPendaftaran button').attr('disabled','true');
}
else {
            $('#inputNoPendaftaran input').attr('disabled','true');
            $('#inputNoPendaftaran button').attr('disabled','true');
}
JS;
Yii::app()->clientScript->registerScript('formPasienNopend',$js,CClientScript::POS_READY);
?>
<?php
    $urlgetRuanganberdasarkanRM=Yii::app()->createUrl('ActionAjax/RuanganberdasarkanRM');
    $idNoRM = CHtml::activeId($modPasien,'no_rekam_medik');
    $pendaftaranid = CHtml::activeId($model,'pendaftaran_id');
    $pasien_id= CHtml::activeId($model,'pasien_id');
    $ruangan_id=CHtml::activeId($model,'ruangan_id');
    $pasienadmisi_id=CHtml::activeId($model,'pasienadmisi_id');                        
    $urlPrintLembarBookingKamar = Yii::app()->createUrl('print/lembarBookingKamar',array('idBookingKamar'=>''));

    $cekKartuPasien=PPKonfigSystemK::model()->find()->printkartulsng;
    if(!empty($cekKartuPasien)){ //Jika Kunjungan Pasien diisi TRUE
        $statusKartuPasien=$cekKartuPasien;
    }else{ //JIka Print Kunjungan Diset FALSE
        $statusKartuPasien=0;
    }

$js = <<< JS

function print(idBookingKamar)
{

        if(${statusKartuPasien}==1){ //JIka di Konfig Systen diset TRUE untuk Print kunjungan
             window.open('${urlPrintLembarBookingKamar}'+idBookingKamar,'printwin','left=100,top=100,width=400,height=400');
        }             
}
function getRuanganberdasarkanRM(no_rekam_medik)
{

    $.post("${urlgetRuanganberdasarkanRM}",{no_rekam_medik: no_rekam_medik},
        function(data){
                    if(data.cek!=null)
                        {
                            $('#${pasien_id}').val(data.pasien_id);
                        }
                    $('#${pendaftaranid}').val(data.pendaftaran_id);
                    $('#dataPesan').html();
                    $('#ruangan').val(data.ruangan_nopendaftaran);
                      
                    $('#${ruangan_id}').val(data.ruangan_id); 
                    $('#${pasienadmisi_id}').val(data.pasienadmisi_id);    
                    $('#dataPesan').html(data.data_pesan);
    },"json");
  
}



JS;
Yii::app()->clientScript->registerScript('formPasienNopend',$js,CClientScript::POS_HEAD);
$js = <<< JS
$('#isPasienLama').click(function(){
    if ($(this).is(':checked'))
      {
         $('#PPPasienM_no_rekam_medik').removeAttr('disabled');
         $('#buttonSearch').removeAttr('disabled');
      }
    else
      {
        $('#PPPasienM_no_rekam_medik').attr('disabled','true');
        $('#no_rekam_medik').val('');
        $('#buttonSearch').attr('disabled','true');
        $('#PPPasienM_kabupaten_id').html('<option value=\'\'>--Pilih--</option>');
        $('#PPPasienM_kecamatan_id').html('<option value=\'\'>--Pilih--</option>');
        $('#PPPasienM_kelurahan_id').html('<option value=\'\'>--Pilih--</option>');
//        $('#isPasienLama').attr('checked',true);
         
       }

       
      
});
JS;
Yii::app()->clientScript->registerScript('fungsipasien',$js,CClientScript::POS_READY);
$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);
?>