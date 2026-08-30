<style type="text/css">
	fieldset.field-booking-kamar{
		height: 137px;
	}
</style>
<script>
    $(function(){
//        $('#BKPasienM_no_identitas_pasien').keyboard();
//        $('#BKPasienM_nama_pasien').keyboard();
//        $('#BKPasienM_nama_bin').keyboard();
//        $('#BKPasienM_tempat_lahir').keyboard();
//        $('#BKPasienM_alamat_pasien').keyboard(); 
//        $('#BKPasienM_rt').keyboard();
//        $('#BKPasienM_rw').keyboard();
//        $('#BookingkamarT_keteranganbooking').keyboard();
//        $('#BookingkamarT_bookingkamar_no').keyboard();
//        $('#BKPasienM_no_rekam_medik').keyboard();
    });
</script>
<?php
$module = '/'.$this->module->id.'/';
$controlModule = $module.$this->id.'/';


?>
<div class="block-kioskmodule" id="bookingkamar" name="bookingkamar">

	
        
        <div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary panel-gradient">
			<div class="panel-heading">
				<div class="panel-title">Booking Kamar</div>
			</div>
			<div class="panel-body">


                                    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
                                    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                                            'action'=>Yii::app()->createUrl('ekios/Default/SimpanBooking'),
                                    'method'=>'post',
                                    'id'=>'ppbooking-kamar-t-form',
                                            'enableAjaxValidation'=>false,
                                    'type'=>'horizontal',
                                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return cek_booking()'),
                                            //'focus'=>'#',
                                    )); ?>
                                    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                                    <?php 
                                            $modPasien = new BKPasienM();
                                            $modPPBookingKamar = new BookingkamarT();
                                            $modPPBookingKamar->bookingkamar_no = MyGenerator::noBookingKamar();
                                            $modPPBookingKamar->tglbookingkamar = date('d M Y H:i:s');
                                    ?>
                                    <?php echo $form->errorSummary(array($modPPBookingKamar,$modPasien)); ?>
                                    <?php echo $this->renderPartial('_formPasienBookingKamar', array('model'=>$model,'form'=>$form,'modPasien'=>$modPasien,'format'=>$format)); ?>
                                    

                               
                                    <div class="row">
                                        <div class="col-md-12">
                                                <div class="panel panel-success">
                                                        <div class="panel-heading">
                                                                <div class="panel-title">Data Booking Kamar</div>
                                                        </div>
                                                        <div class="panel-body">

                                                            <table  width="100%">
                                                                    <tr>
                                                                          <td>
                                                                              <?php echo $form->hiddenField($modPPBookingKamar,'pasienadmisi_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                                                                              <?php echo $form->hiddenField($modPPBookingKamar,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                                                                              <?php echo $form->hiddenField($modPPBookingKamar,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                                                                              <?php echo $form->dropDownListRow($modPPBookingKamar,'ruangan_id', CHtml::listData(KamarruanganM::model()->getRuanganItems(Params::INSTALASI_ID_RI), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --',
                                                                                  'onchange'=>"kamarruangan(this.value);",
                                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                              'ajax'=>array()
                                                                              ));?>

                                                                              <?php echo $form->dropDownListRow($modPPBookingKamar,'kamarruangan_id', array(),array('empty'=>'-- Pilih --',
                                                                              'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                              'onChange'=>'kelaspelayanan(this.value)',
                                                                              'ajax'=>array()
                                                                              ));?>
                                                                              <?php echo $form->dropDownListRow($modPPBookingKamar,'kelaspelayanan_id', array() ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                                                                              <?php echo $form->textFieldRow($modPPBookingKamar,'bookingkamar_no',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                                                                          </td>

                                                                          <td>
                                                                              <div class='control-group'>
                                                                                  <?php echo $form->labelEx($modPPBookingKamar,'tglbookingkamar', array('class'=>'control-label')) ?>
                                                                                  <div class="controls">
                                                                                       <?php   
                                                                                              $this->widget('MyDateTimePicker',array(
                                                                                              'model'=>$modPPBookingKamar,
                                                                                              'attribute'=>'tglbookingkamar',
                                                                                              'mode'=>'datetime',
                                                                                              'options'=> array(
                                                                                              'dateFormat'=>Params::DATE_FORMAT,
                                                                                              'minDate' => 'd',
                                                                                              ),
                                                                                              'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                                                                          )); ?>
                                                                                          <?php echo $form->error($modPPBookingKamar, 'tglbookingkamar'); ?>
                                                                                   </div>
                                                                              </div>

                                                                               <?php echo $form->dropDownListRow($modPPBookingKamar,'statusbooking', LookupM::getItems('statusbooking'),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                                                                               <?php echo $form->textAreaRow($modPPBookingKamar,'keteranganbooking',array('rows'=>3, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'placeholder'=>'Keterangan Booking')); ?> 
                                                                           </td>
                                                                    </tr>
                                                            </table>
                                

                                                            

                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>     
                         
                                                            <div class="form-actions">
                                                                    <?php
                                                                    if ($modPPBookingKamar->isNewRecord) {
                                                                            echo CHtml::htmlButton($modPPBookingKamar->isNewRecord ? Yii::t('mds','{icon} Kirim',array('{icon}'=>'<i class="entypo-floppy "></i>')) : 
                                                                                Yii::t('mds','{icon} Kirim',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                                array('class'=>'btn btn-success', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)'));
                                                                    } else {
                                                                            echo CHtml::htmlButton($modPPBookingKamar->isNewRecord ? Yii::t('mds','{icon} Kirim',array('{icon}'=>'<i class="entypo-floppy"></i>')) : 
                                                                                Yii::t('mds','{icon} Kirim',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                                array('class'=>'btn btn-success', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','disabled'=>true));
                                                                             }
                                                                    ?>
                                                                    <a href="index.php?r=ekios/Default/bkamar" class="btn btn-danger">
                                                                                    <i class="icon-refresh icon-white"></i>
                                                                                    Batal
                                                                    </a>
                                                            </div>  
                            
                            
                        </div> 
                    </div>
                                                
                </div>
            </div> 
        </div>
    <?php $this->endWidget(); ?>
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

    function kamarruangan(idRuangan)
	{
         
	    $.post("<?php echo Yii::app()->createUrl($controlModule.'KamarRuanganEkios'); ?>", { idRuangan: idRuangan },
	        function(data){
	            $('#BookingkamarT_kamarruangan_id').html(data.listKamarRuangan);
	    }, "json");
	}

	function kelaspelayanan(idKelasPelayanan)
	{
	    $.post("<?php echo Yii::app()->createUrl($controlModule.'KelasPelayananEkios'); ?>", { idKelasPelayanan: idKelasPelayanan },
	        function(data){
	            $('#BookingkamarT_kelaspelayanan_id').html(data.listKelasPelayanan);
	    }, "json");
	}
</script>
<?php
$enableInputPendaftaran = ($modPPBookingKamar->isNoPendaftaran) ? 1 : 0;
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
$urlgetStatusKamar = Yii::app()->createUrl('ActionAjax/getStatusKamar');
$idNoRM = CHtml::activeId($modPasien,'no_rekam_medik');
$pendaftaranid = CHtml::activeId($modPPBookingKamar,'pendaftaran_id');
$pasien_id= CHtml::activeId($modPPBookingKamar,'pasien_id');
$ruangan_id=CHtml::activeId($modPPBookingKamar,'ruangan_id');
$pasienadmisi_id=CHtml::activeId($modPPBookingKamar,'pasienadmisi_id');                        
$urlPrintLembarBookingKamar = Yii::app()->createUrl('print/lembarBookingKamar',array('idBookingKamar'=>''));

$js = <<< JS

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

function getStatus(obj){
    
    idKamarruangan = (obj.value);
    $.post("${urlgetStatusKamar}",{idKamarruangan: idKamarruangan},
        function(data){
         $('div.divForForm').html(data.status);
    },"json");
}

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

<script type="text/javascript">

function cek_booking(){
    var nama_pasien = $('#BKPasienM_nama_pasien').val();
    var tgl_lahir   = $('#BKPasienM_tanggal_lahir').val();
    var jk_l        = $('input:radio[id=BKPasienM_jeniskelamin_0]:checked').val();
    var jk_p        = $('input:radio[id=BKPasienM_jeniskelamin_1]:checked').val();
    var alamat      = $('#BKPasienM_alamat_pasien').val();

    var ruangan     = $('#BookingkamarT_ruangan_id').val();
    var nokamar     = $('#BookingkamarT_kamarruangan_id').val();
    var kelas       = $('#BookingkamarT_kelaspelayanan_id').val();
    var no_booking  = $('#BookingkamarT_bookingkamar_no').val();

    var tgl_booking = $('#BookingkamarT_tglbookingkamar').val();
    var status      = $('#BookingkamarT_statusbooking').val();

    //myAlert(nama_pasien);
    
    if(nama_pasien==null || nama_pasien==''){
        myAlert('Nama Pasien Harus Diisi');
        return false;
    }else if(tgl_lahir==null || tgl_lahir==''){
        myAlert('Tgl. Lahir Harus Diisi');
        return false;
    }else if((jk_l=='' || jk_l==null) && (jk_p=='' || jk_p==null)){
        myAlert('Jenis Kelamin Harus Diisi');
        return false;
    }else if(alamat==null || alamat==''){
        myAlert('Alamat Harus Diisi');
        return false;
    }else if(ruangan=='' || ruangan==null){
        myAlert('Ruangan harus dipilih');
        return false;
    }else if(nokamar=='' || nokamar==null){
        myAlert('No. Kamar harus dipilih');
        return false;
    }else if(kelas=='' || kelas==null){
        myAlert('Kelas Pelayanan harus dipilih');
        return false;
    }else if(no_booking=='' || no_booking==null){
        myAlert('No. Booking harus diisi');
        return false;
    }else if(tgl_booking=='' || tgl_booking==null){
        myAlert('Tanggal Booking harus diisi');
        return false;
    }else if(status=='' || status==null){
        myAlert('Status Booking harus dipilih');
        return false;
    }else{
        return true;
    }
}

</script>