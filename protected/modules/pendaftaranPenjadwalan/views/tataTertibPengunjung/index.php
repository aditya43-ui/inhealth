<style>
    body{
        color: black !important;
    }
    h5{
        color: black !important;
    }
    label{
        color: black !important;
    }
    .tab_header {
        width: 100%;
    }

/*    .tab_header td {
        border: 1px solid black;
        line-height: 32px;
        padding-left: 5px;
        vertical-align: top;
    }

    .tab_header .head_cell {
        font-weight: bold;
    }
    */
    .pilihan_ijin, .pilihan_privasi {
        font-weight: bold;
        cursor: pointer;
    }

    /* p {
        text-align: justify;
    } */

    .borderclass {
        border: 1px solid black;
    }
    .bordertopclass {
        border-top: 1px solid black;
    }
    .borderrightclass {
        border-right: 1px solid black;
    }
    .borderleftclass {
        border-left: 1px solid black;
    }
    .borderbottomclass {
        border-bottom: 1px solid black !important;
    }


</style>


<?php
$this->widget('bootstrap.widgets.BootAlert');
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());


$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'tatatertib-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
));
?>
	<?php echo $form->errorSummary($model); ?>
  <?php echo $form->hiddenField($model,'pendaftaran_id'); ?>
<?php echo $form->hiddenField($model,'pasienadmisi_id'); ?>
<?php echo $form->hiddenField($model,'pasien_id'); ?>
<?php echo $form->hiddenField($model,'tatatertibpengunjung_judul'); ?>
<?php echo $form->hiddenField($model,'tatatertibpengunjung_isi'); ?>
<?php echo $form->hiddenField($model,'pihak_menyetujui'); ?>

<table width="100%">
    <tr>
    <td style="width: 30%" valign="top">
        <table>
            <tr>
                <td width="25%" align="center" class="bordertopclass borderbottomclass borderleftclass">
                    <div style="padding:5px"><img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="height: 100px; width: 90px"/></div>
                </td>
                <td width="1%" class="bordertopclass borderbottomclass">
                </td>
                <td  class="bordertopclass borderrightclass borderbottomclass">
                    <font style="font-size:12px;"><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></font><br><br>
                     <font style="font-size:12px;"><?php echo ucwords($modProfilRs->alamatlokasi_rumahsakit). ' '. ucwords(strtolower($modProfilRs->kecamatan->kecamatan_nama)) . ' '.ucwords(strtolower($modProfilRs->kabupaten->kabupaten_nama)); ?></font><br>
                    <font style="font-size:12px;">Phone. <?php echo $modProfilRs->no_telp_profilrs;?></font> <br>
                <font style="font-size:12px;">FAX : <?php echo $modProfilRs->no_faksimili; ?></font>
                </td>
            </tr>
        </table>
    </td>
    <td style="width: 35%" valign="bottom" >
        <center>
            <table>
                <tr>
                    <td style="font-weight: bold; font-size: 14pt;">
                        <?php echo (isset($modMasterTataTertib)?$modMasterTataTertib->tatatertibpengunjung_judul :"") ?>
                    </td>
                </tr>
            </table>
        </center>
    </td>
    <td style="width: 35%;">
        <table class="borderclass" style="float:right; width: 100%">
            <tr>
                <td style="padding: 2px" width="150px">Nama Pasien</td>
                <td style="padding: 2px" width="10px">:</td>
                <td style="padding: 2px">
                    <?php echo CHtml::textField('pasien_nama',$modPasien->nama_pasien, array('readonly'=>true)); ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 2px" width="150px">Tanggal Lahir</td>
                <td style="padding: 2px" width="10px">:</td>
                <td style="padding: 2px">
                  <?php echo CHtml::textField('tanggal_lahir',MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir), array('readonly'=>true)); ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 2px" width="150px">Jenis Kelamin</td>
                <td style="padding: 2px" width="10px">:</td>
                <td style="padding: 2px">
                  <?php echo CHtml::textField('pasien_nama',$modPasien->jeniskelamin, array('readonly'=>true)); ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 2px" width="150px">No. RM</td>
                <td style="padding: 2px" width="10px">:</td>
                <td style="padding: 2px">
                  <?php echo CHtml::textField('no_rekam_medik',$modPasien->no_rekam_medik, array('readonly'=>true)); ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 2px" width="150px">Dokter DPJP</td>
                <td style="padding: 2px" width="10px">:</td>
                <td style="padding: 2px">
                  <?php  $modPeg = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id); ?>
                  <?php echo CHtml::textField('pasien_nama',(isset($modPeg)? $modPeg->namaLengkap:""), array('readonly'=>true)); ?>

                </td>
            </tr>
        </table>
    </td>
    </tr>
</table>
<br>
<table width="100%">
  <tr>
      <td class="borderclass" style="padding: 10px">
          <?php echo (isset($modMasterTataTertib)?$modMasterTataTertib->tatatertibpengunjung_isi :"") ?>
      </td>
  </tr>
</table>

<br/>
<?php
    $classHidden = "";
    
    if(!empty($urlId) && $urlId == 'pendaftaranRawatInapDariRJRD'){
        $classHidden = "hidden";
    }
?>
<table width="100%">
<tr>
     <td style="text-align: center;" width="35%" <?php echo $classHidden; ?>>
     </td>
     <td style="text-align: center;" width="<?php echo (!empty($classHidden)? "50%":"30%"); ?>">
       Menyetujui, <br/><br/><br/>
     </td>
     <td style="text-align: center;" width="<?php echo (!empty($classHidden)? "50%":"35%"); ?>">
     </td>
 </tr>
</table>
<table width="100%">
<tr>
     <td style="text-align: center;" width="35%" <?php echo $classHidden; ?>>
        Pasien <span class="required">*</span> <br/>
        <?php echo $form->textField($model,'namapasien_menyetujui',array('class'=>'span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->error($model,'namapasien_menyetujui'); ?>
     </td>
     <td style="text-align: center;" width="<?php echo (!empty($classHidden)? "50%":"30%"); ?>">
         Pendamping Pasien <span class="required">*</span><br/>
        <?php echo $form->textField($model,'namapihak_menyetujui',array('class'=>'span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->error($model,'namapihak_menyetujui'); ?>
     </td>
     <td style="text-align: center;" width="<?php echo (!empty($classHidden)? "50%":"35%"); ?>">
        Petugas <span class="required">*</span> <br/>
        <?php echo $form->textField($model,'petugas_menyetujui',array('class'=>'span3 required', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->error($model,'petugas_menyetujui'); ?>
     </td>
 </tr>
</table>
<br /><br />
	<div class="form-actions">
            <?php
                $disabled = true;
                $disabledsimpan = false;
                if(isset($_GET['sukses'])){
                    $disabled = false;
                    $disabledsimpan = true;
                }
            ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disabledsimpan)); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'onclick'=>'print("PRINT");', 'disabled'=>$disabled)); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-info', 'onclick'=>'print("PDF");', 'disabled'=>$disabled)); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>


<script>

function print(caraprint)
{
    <?php
        $idsurat = "";

        if(isset($_GET['sukses'])){
           $idsurat = $_GET['tatatertibpengunjungri_id'];
        }
    ?>
    window.open('<?php echo $this->createUrl('print',array('pendaftaran_id'=>$model->pendaftaran_id,'tatatertibpengunjungri_id'=>$idsurat,'urlId'=>$urlId)); ?>&caraPrint='+caraprint,'printwin','left=100,top=100,width=860,height=480');
}

$(document).ready(function() {

});


</script>
