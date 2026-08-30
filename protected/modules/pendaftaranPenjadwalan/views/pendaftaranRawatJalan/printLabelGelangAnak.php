<style>
    @media screen {
	@page { size: 25mm 305mm; margin: 0;}
    
        .content-depan {
            width: 50mm;
            height: 240mm;
            border: 1px solid black;
        }
        
        .info_pasien {
            position: absolute;
            transform-origin: left top;
            transform: rotate(90deg);
            left: 24mm;
            /*
            height:15mm; width:95mm;    
            /* top: 25mm; */
            /* top: 160mm; */
            /* top: 60mm; */
        }
        
        .barcode_pasien {
            position: absolute;
            top: 0mm;
            left: 60mm;
        }
    }
    
    @media print {
    @page { size: 25mm 305mm; margin: 0; }
        .content-depan {
            width: 50mm;
            height: 240mm;
        }
    
        .info_pasien {
            position: absolute;
            transform-origin: left top;
            transform: rotate(90deg);
            left: 24mm;
            /*
            position: absolute;
            transform-origin: left top;
            transform: rotate(90deg);
            left: 21mm;
            height:15mm; width:95mm;
            top: 60mm;
            */
        }
        
        .barcode_pasien {
            position: absolute;
            top: 0mm;
            left: 60mm;
        }
    
    
    }
</style>

<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>  
<?php 
	$tgllahir = new DateTime($modPendaftaran->pasien->tanggal_lahir);
	$hariini = new DateTime();
	
	$selisih = $hariini->diff($tgllahir);
    
    // $modPendaftaran->pasien->nama_pasien = "ACHMAD BAGAS MAULANA";
        
        
?>
<div class="content-depan">
<div class="info_pasien">
    
<table>
  <tr width="100%"> 
      <td style="font-size:9.5pt; font-family:Sans-Serif" colspan="3">
          <b><?php echo $modPendaftaran->pasien->namadepan.' '.$modPendaftaran->pasien->nama_pasien; ?>
    <?php if($modPendaftaran->pasien->jeniskelamin == 'LAKI-LAKI'){
        echo '(L)';
    } else{
        echo '(P)';
    }?></b>
      </td> 
  </tr>
  <tr width="100%">
    <td style="font-size:9.5pt; font-wight:bold; font-family:Arial; width:1.5cm;"><b>No. RM</b></td>
    <td width="10">:</td>
    <td style="font-size:9.5pt; font-wight:bold; font-family:Arial; width:5cm;">
        <b style="font-size: 9.5pt;"><?php echo $modPendaftaran->pasien->no_rekam_medik; ?></b>
    </td>
   
  </tr>
  <tr width="100%">
    <td style="font-size:9.5pt; font-wight:bold; font-family:Arial" colspan="3">
    <b><?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->pasien->tanggal_lahir); ?>
        <?php
            echo '( '.$selisih->y.' Th )'; 
        ?></b>
    </td>
  </tr>
  <tr width="100%">
    <td style="font-size:9.5pt; font-wight:bold; font-family:Arial" colspan="3">
        <b style="font-size: 10pt;">RSUD Dr. SAIFUL ANWAR</b>
    </td>
  </tr> 
</table>
</div>
<?php // die; ?>