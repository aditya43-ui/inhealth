pe<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>  
<?php
	$tgllahir = new DateTime($modPendaftaran->pasien->tanggal_lahir);
	$hariini = new DateTime();
	
	$selisih = $hariini->diff($tgllahir);
?>
<?php if($modPendaftaran->pasien->kelompokumur_id == Params::KELOMPOKUMUR_DEWASA) { ?> 
<div style="margin-top:0mm; margin-bottom:0mm; margin-left:0mm; margin-right:3mm; position: fixed; left:2mm; top:50mm; rotate: -90; height:50mm; width:51mm;">
<!--<div>-->
    
<table>
  <tr width="100%"> 
    <td style="font-size:7pt; font-wight:bold; font-family:Sans-Serif"><?php echo $modPendaftaran->pasien->namadepan.' '.$modPendaftaran->pasien->nama_pasien; ?></td> 
    <td></td>
    <td></td>
  </tr>
  <tr width="100%">
    <td style="font-size:7pt; font-wight:bold; font-family:Sans-Serif">No. RM</td>
    <td>:</td>
    <td style="font-size:7pt; font-wight:bold; font-family:Sans-Serif"><?php echo $modPendaftaran->pasien->no_rekam_medik; ?>
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
<div style="margin-top:0mm; margin-bottom:0mm; margin-left:0mm; margin-right:6mm; position: fixed; left:0mm; top: 5mm; rotate: -90; height:31mm; width:41mm;">
<table>
  <tr width="100%">
    <td style="font-size:10pt; font-wight:bold; font-family:Sans-Serif"></td>
    <td></td>
    <td style="font-size:10pt; font-wight:bold; font-family:Sans-Serif"></td>
  </tr>
  <tr width="100%">
      <td colspan="4" style="text-align:right;">
        <img style="width: 132.28346457px;height:40.897637795px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->no_pendaftaran; ?>&is_text="> 
        <br>
        <p style="font-size:6pt;"><?php echo date('d/m/Y H:i:s', strtotime($modPendaftaran->tgl_pendaftaran)); ?></p>
    </td>
  </tr>
</table>
    <table style="width: 100%; border: none;">
  <tr width="100%">
    <td style="font-size:10pt; font-wight:bold; font-family:Sans-Serif"></td>
    <td></td>
    <td style="font-size:10pt; font-wight:bold; font-family:Sans-Serif"></td>
  </tr>
  <tr width="100%">
    <td colspan="4">
        <img style="height: 50px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->no_pendaftaran; ?>&is_text="> 
        <br>
        <?php echo date('d/m/Y H:i:s', strtotime($modPendaftaran->tgl_pendaftaran)); ?>
    </td>
  </tr>
  <tr width="100%">
    <td style="font-size:10pt; font-wight:bold; font-family:Sans-Serif"></td>
  </tr>
</table>
</div>

<?php  
    }elseif ($modPendaftaran->pasien->kelompokumur_id == Params::KELOMPOKUMUR_ANAK) { ?>
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
        <img style="height: 50px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->no_pendaftaran; ?>&is_text="> 
        
    </td> 
    <td></td>
    <td></td>
  </tr>
</table>
</div>

<?php  
    }elseif ($modPendaftaran->pasien->kelompokumur_id == Params::KELOMPOKUMUR_BAYI || $modPendaftaran->pasien->kelompokumur_id == Params::KELOMPOKUMUR_BARU_LAHIR) { ?>
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
        <img style="height: 50px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->no_pendaftaran; ?>&is_text="> 
        
    </td> 
    <td></td>
    <td></td>
  </tr>
</table>
</div>

<?php  
    }else{?>
<div style="margin-top:0mm; margin-bottom:0mm; margin-left:0mm; margin-right:3mm; position: fixed; left:2mm; top:50mm; rotate: -90; height:50mm; width:51mm;">
<!--<div>-->
<table>
<tr width="100%"> 
    <td  width="110" style="font-size:7pt; font-wight:bold; font-family:Sans-Serif;"><b><?php echo $modPendaftaran->pasien->nama_pasien; ?> <?php if($modPendaftaran->pasien->jeniskelamin == 'LAKI-LAKI'){
        echo '(L)';
    } else{
        echo '(P)';
    }
    ?> </b></td> 
    <td></td>
    <td></td>
  </tr>
</table>
<table>
  <tr width="100%">
    <td style="font-size:7pt; font-wight:bold; font-family:Sans-Serif"><b>No. RM</b></td>
    <td>:</td>
    <td style="font-size:7pt; font-wight:bold; font-family:Sans-Serif"><b><?php echo $modPendaftaran->pasien->no_rekam_medik; ?></b>
    </td>
   
  </tr>
  <tr width="100%">
    <td style="font-size:7pt; font-wight:bold; font-family:Sans-Serif"><b>NIK</b></td>
    <td>:</td>
    <td style="font-size:7pt; font-wight:bold; font-family:Sans-Serif"><b><?php echo $modPendaftaran->pasien->no_identitas_pasien; ?></b>
    </td>
   
  </tr>
  <tr width="100%">
    <td style="font-size:7pt; font-wight:bold; font-family:Sans-Serif">Tgl. Lahir</td>
    <td>:</td>
    <td style="font-size:7pt; font-wight:bold; font-family:Sans-Serif">
        <?= MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir)?> <?php
            echo '( '.$selisih->y.' Th )'; 
        ?>
        
    </td>
  </tr> 
</table>
</div>
<?php }?>