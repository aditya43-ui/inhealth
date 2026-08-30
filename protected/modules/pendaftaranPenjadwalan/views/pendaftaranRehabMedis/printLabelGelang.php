<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>  
<?php 
	$tgllahir = new DateTime($modPendaftaran->pasien->tanggal_lahir);
	$hariini = new DateTime();
	
	$selisih = $hariini->diff($tgllahir);    
        
        
?>
<?php if($gelang_tipe == 0) {?> 
<div style="margin-top:135mm; margin-bottom:0mm; margin-left:8mm; margin-right:15mm; position: fixed; left:2mm; top:50mm; rotate: -90; height:175mm; width:20mm;">
 
<table>
  <tr width="100%"> 
      <td style="font-size:10.5pt; font-family:Sans-Serif" colspan="3">
          <b><?php echo $modPendaftaran->pasien->namadepan.' '.$modPendaftaran->pasien->nama_pasien; ?></b>
      </td> 
  </tr>
  <tr width="100%">
    <td style="font-size:7pt; font-wight:bold; font-family:Sans-Serif">No. RM</td>
    <td>:</td>
    <td style="font-size:7pt; font-wight:bold; font-family:Sans-Serif">
        <b style="font-size: 10.5pt;"><?php echo $modPendaftaran->pasien->no_rekam_medik; ?></b>
    <?php if($modPendaftaran->pasien->jeniskelamin == 'LAKI-LAKI'){
        echo '(L)';
    } else{
        echo '(P)';
    }
    ?> 
    <?php echo date('d/m/Y',strtotime($modPendaftaran->pasien->tanggal_lahir)); ?>
    </td>
   
  </tr>
  <tr width="100%">
    <td style="font-size:7pt; font-wight:bold; font-family:Sans-Serif">Umur</td>
    <td>:</td>
    <td style="font-size:7pt; font-wight:bold; font-family:Sans-Serif">
        <?php
            echo $selisih->y.' th/ '.$selisih->m.' bl/ '.$selisih->d.' hr'; 
        ?>
        
    </td>
  </tr> 
</table>
</div>
<!-- margin-left:0mm; margin-right:6mm; -->
<div style="margin-top:145mm; margin-bottom:0mm; margin-left:4mm; margin-right:20mm; position: fixed; left:0mm; top: 10mm; rotate: -90; height:10mm; width:43mm;">
<table  width="100%" style=" margin-top: 30px; margin-left: 10px;">
  <tr>
      <td colspan="4" style="text-align:center;">
        <!--<img style="width: 132.28346457px;height:40.897637795px;" src="index.php?r=barcode/myBarcode&code=<?php // echo $modPendaftaran->no_pendaftaran; ?>&is_text=">--> 
          <?php 
          $this->widget('application.extensions.qrcode.QRCodeGenerator',array(
                            'data' =>$modPasien->no_rekam_medik,
                            'subfolderVar' => false,
//                            'matrixPointSize' => 5,
                            'displayImage'=>true, // default to true, if set to false display a URL path
                            'errorCorrectionLevel'=>'M', // available parameter is L,M,Q,H
                            'matrixPointSize'=>2, // 1 to 10 only
                        )); 
          ?>
        <div style="font-size: 6pt; margin-top: -10px;"><?php echo date('d/m/Y H:i:s', strtotime($modPasien->no_rekam_medik)); ?></div>
    </td>
  </tr>
</table>
<!--<table style="width: 100%; border: none;">
  <tr width="100%">
    <td colspan="4">
        <img style="height: 50px;" src="index.php?r=barcode/myBarcode&code=<?php // echo $modPendaftaran->no_pendaftaran; ?>&is_text="> 
        <br>
        <?php // echo date('d/m/Y H:i:s', strtotime($modPendaftaran->tgl_pendaftaran)); ?>
    </td>
  </tr>
</table>-->
</div>

<?php  
    }elseif ($gelang_tipe == 1) { ?>
<!-- 
  perubahan ukuran top
  top:80mm;
  top:50mm;
  height: 50mm
  margin-left:8mm
  margin-left:4mm
  margin-top:8mm
  margin-top: 30mm
  margin-top:80mm
  font-size:9pt
 -->
<div style="margin-top:84mm; margin-bottom:0mm; margin-left:3mm; margin-right:15mm; position: fixed; left:2mm; top:65mm; rotate: -90; height:131mm; width:61mm;">
<!--<div>-->
    
<style>
    .tab_print td {
        padding: 1px;
    }
</style>

<table class='tab_print'>
  <tr width="100%"> 
      <td style="font-size:8pt; font-family:Sans-Serif; padding: 1px;" colspan="3">
          <b><?php echo $modPendaftaran->pasien->namadepan.' '.$modPendaftaran->pasien->nama_pasien; ?></b>
      </td> 
  </tr>
  <tr width="100%">
    <td style="font-size:6pt; font-weight:bold; font-family:Sans-Serif">No. RM</td>
    <td style="font-size:6pt; font-weight:bold; font-family:Sans-Serif">:</td>
    <td style="font-size:6pt; font-weight:bold; font-family:Sans-Serif">
        <b style="font-size: 8pt;"><?php echo $modPendaftaran->pasien->no_rekam_medik; ?></b>
    <?php if($modPendaftaran->pasien->jeniskelamin == 'LAKI-LAKI'){
        echo '(L)';
    } else{
        echo '(P)';
    }
    ?> 
    <?php echo date('d/m/Y',strtotime($modPendaftaran->pasien->tanggal_lahir)); ?>
    </td>
   
  </tr>
  <tr width="100%">
    <td style="font-size:7pt; font-weight:bold; font-family:Sans-Serif">Umur</td>
    <td style="font-size:7pt; font-weight:bold; font-family:Sans-Serif">:</td>
    <td style="font-size:7pt; font-weight:bold; font-family:Sans-Serif">
        <?php
            echo $selisih->y.' th/ '.$selisih->m.' bl/ '.$selisih->d.' hr'; 
        ?>
        
    </td>
  </tr> 
</table>
</div>
<!-- 
  perubahan ukuran top
  top: 35mm;
  top:10 mm;
  margin-left: 4mm
  margin-left: 2mm
  margin-top: 33mm
  margin-top: 95mm
 -->
<div style="margin-top:117mm; margin-bottom:0mm; margin-left:1mm; margin-right:20mm; position: fixed; left:-1mm; top: 20mm; rotate: -90; height:10mm; width:43mm;">
<table  width="100%" style=" margin-top: 30px; margin-left: 10px;">
  <tr>
      <td colspan="4" style="text-align:center;">
        <!--<img style="width: 132.28346457px;height:40.897637795px;" src="index.php?r=barcode/myBarcode&code=<?php // echo $modPendaftaran->no_pendaftaran; ?>&is_text=">--> 
          <?php 
          $this->widget('application.extensions.qrcode.QRCodeGenerator',array(
                            'data' =>$modPasien->no_rekam_medik,
                            'subfolderVar' => false,
//                            'matrixPointSize' => 5,
                            'displayImage'=>true, // default to true, if set to false display a URL path
                            'errorCorrectionLevel'=>'M', // available parameter is L,M,Q,H
                            'matrixPointSize'=>1, // 1 to 10 only
                        )); 
          ?>
        <!-- <div style="font-size: 6pt; margin-top: -10px;"><?php //echo date('d/m/Y H:i:s', strtotime($modPasien->no_rekam_medik)); ?></div> -->
    </td>
  </tr>
</table>
<!--<table style="width: 100%; border: none;">
  <tr width="100%">
    <td colspan="4">
        <img style="height: 50px;" src="index.php?r=barcode/myBarcode&code=<?php // echo $modPendaftaran->no_pendaftaran; ?>&is_text="> 
        <br>
        <?php // echo date('d/m/Y H:i:s', strtotime($modPendaftaran->tgl_pendaftaran)); ?>
    </td>
  </tr>
</table>-->
</div>

<?php 
    }elseif ($gelang_tipe == 2) { ?>
<div style="margin-top:0mm; margin-bottom:0mm; margin-left:0mm; margin-right:15mm; position: fixed; left:2mm; top :0mm; rotate: -90; height:46mm; width:43mm;">
<table>
  <tr width="100%"> 
    <td style="font-size:5pt; font-wight:bold; font-family:Sans-Serif">
        <?php echo $modPendaftaran->pasien->namadepan.' '.$modPendaftaran->pasien->nama_pasien; ?>
        <br>
        No. RM : <?php echo $modPendaftaran->pasien->no_rekam_medik; ?> 
        <?php if($modPendaftaran->pasien->jeniskelamin == 'LAKI-LAKI'){
            echo '(L)';
        } else{
            echo '(P)';
        }
        ?> 
        <?php echo date('d/m/Y',strtotime($modPendaftaran->pasien->tanggal_lahir)); ?>
        <br>
        Umur :  <?php
            echo $selisih->y.' th/ '.$selisih->m.' bl/ '.$selisih->d.' hr'; 
        ?>
        <?php echo date('d/m/Y H:i:s', strtotime($modPendaftaran->tgl_pendaftaran)); ?>
        <br>
        <img style="height: 50px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPasien->no_rekam_medik; ?>&is_text="> 
        
    </td> 
    <td></td>
    <td></td>
  </tr>
</table>
</div>

<?php  
    }?>