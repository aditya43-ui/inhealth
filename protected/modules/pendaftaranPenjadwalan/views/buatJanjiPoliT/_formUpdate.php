<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'ppbuat-janji-poli-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->

	<?php echo $form->errorSummary($modPPBuatJanjiPoli); ?>
        <table style="width: 100%; border: none;">
            <tr>
                <td>
                    <?php echo $form->textFieldRow($modPPBuatJanjiPoli,'no_rekam_medik',array('value'=>$modPPBuatJanjiPoli->pasien->no_rekam_medik,'readonly'=>TRUE,'placeholder'=>'No. Rekam Medik','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->dropDownListRow($modPPBuatJanjiPoli,'ruangan_id', CHtml::listData($modPPBuatJanjiPoli->getRuanganItems(), 'ruangan_id', 'ruangan_nama') ,
                                                  array('empty'=>'-- Pilih --',
                                                        'class' => 'span3',
                                                        'onchange'=>"listDokterRuangan(this.value);",
                                                        'ajax'=>array(),
                                                        'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
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
//                                                        'maxDate' => 'd',
                                                        //
                                                        //'onkeypress'=>"js:function(){getUmur(this);}",
                                                        'onSelect'=>'js:function(){hariBaru(this);listKuota();}',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3 tgl_jadwal', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                            <?php echo $form->error($modPPBuatJanjiPoli, 'tgljadwal'); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($modPPBuatJanjiPoli,'no_kartu_bpjs',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                </td>
                <td>
                    <?php echo $form->dropDownListRow($modPPBuatJanjiPoli,'pegawai_id', CHtml::listData($modPPBuatJanjiPoli->getDokterItems(),'pegawai_id','nama_pegawai') ,array('empty'=>'-- Pilih --', 'class' => 'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <div class="control-group">
                    <label class="control-label">Slot <span class="required">*</span></label> 
                        <div class="controls">
                            <?php echo $form->dropDownList($modPPBuatJanjiPoli, 'tgljadwal[1]', array(), array(
                                'empty'=>'-- Pilih --',
                                'class'=>'span3 slot_jadwal',
                                'onchange'=>'cekSlotTersedia();'
                            )); ?>
                            <?php echo $form->hiddenField($modPPBuatJanjiPoli, 'no_antrianjanji', array('class'=>'no_antrianjanji')); ?>
                        </div>
                        <div class="checkbox inline">
                    <label for="antrian">Slot Antrian</label>
                    <?php echo $form->checkBox($modPPBuatJanjiPoli, 'slotantrian', array('onkeyup' => "return $(this).focusNextInputField(event)", 'id' => 'antrian')); ?>
                    <?php // echo CHtml::activeLabel($model, 'kunjunganrumah'); 
                    ?>
                </div>
                        </div>
                    <?php echo $form->textFieldRow($modPPBuatJanjiPoli,'harijadwal',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>TRUE)); ?>
                    <?php echo $form->textAreaRow($modPPBuatJanjiPoli,'keteranganbuatjanji',array('rows'=>4, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
          
            </tr>
            <tr>
                <td>
                    
                </td>
                <td>
                     
                </td>
                
            </tr>
            <tr>
                <td colspan="2">
                    
                </td>
             
            </tr>
        </table>
             <div class="form-actions">
	    <?php echo CHtml::htmlButton($modPPBuatJanjiPoli->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                            Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                        array('class'=>'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/buatJanjiPoliT/admin'), 
                        array('class'=>'btn btn-default',
                              'onclick'=>'return refreshForm(this);')); ?>
                 <?php $this->widget('UserTips',array('type'=>'tipsaddedit'));?>
	</div>
<?php $this->endWidget(); ?>

<?php
$urlListDokterRuangan = $this->createUrl('listDokterRuangan');
$urlGetHari = $this->createUrl('GetHari');
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


$(function () {
        $("#antrian").click(function () {
            if ($(this).is(":checked")) {
                $(".slot_jadwal").hide();
                $(".ceklis_jadwal").hide();
            } else {
                $(".slot_jadwal").show();
                $(".ceklis_jadwal").show();
                cekSlotTersedia();
            }
        });
    });

function cekSlotTersedia() {
    $(".no_antrianjanji").val("");
    if ($(".slot_jadwal :selected").data('terisi') == 1
    || $(".slot_jadwal :selected").data('terisi-jadwal') == 1) {
        $(".slot_jadwal").val("");
        myAlert("Slot jadwal yang dipilih sudah terisi.");
    } else {
        $(".no_antrianjanji").val($(".slot_jadwal :selected").data('slot'));
    }

}

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
<script>
function listKuota() {
    var pegawai_id = $("#PPBuatJanjiPoliT_pegawai_id").val();
    var tgl = $(".tgl_jadwal").val();
    var ruangan_id = $("#PPBuatJanjiPoliT_ruangan_id").val();
    
    console.log(pegawai_id, ruangan_id, tgl);
    
    
    if (pegawai_id == "" || ruangan_id == "" || tgl == "") {
        return false;
    }

    $(".panel_jadwal").empty();
    
    $.post("<?php echo $this->createUrl("/pendaftaranPenjadwalan/pembuatanJanjiPoli/getKuotaJanjiPoli") ?>", {pegawai_id: pegawai_id, ruangan_id: ruangan_id, tgl: tgl}, function(data) {
        
        if (data.is_penuh == 1) {
            myAlert(data.msg);
            $("#kuota_janji").val("");
            $("#sisa_kuota").val("");
            $("#PPBuatJanjiPoliT_pegawai_id").val(null);
            $(".panel_jadwal").html("");
            return false;
        }
        
        $("#kuota_janji").val(data.kuota);
        $("#sisa_kuota").val(data.sisa);
        $(".slot_jadwal").html(data.slot);
        $(".panel_jadwal").html(data.checkbox_jadwal);
        setCeklisJadwalDokter();
    }, 'json');
}
</script>