<style>
    @media screen {
    /* @page { size: 25mm 155mm; margin: 0; } */
	@page { size: 25mm 305mm; margin: 0;}
    
        /* .content-depan {
            width: 20mm;
            height: 150mm;
        } */
        .content-depan {
            width: 20mm;
            height: 240mm;
            border: 1px;
        }
        
        .info_pasien {
            position: absolute;
            transform-origin: left top;
            transform: rotate(90deg);
            left: 21mm;
            height:15mm; width:95mm;    
            /* top: 25mm; */
            /* top: 160mm; */
            top: 60mm;
        }
        
        .barcode_pasien {
            position: absolute;
            top: 0mm;
            left: 60mm;
        }
    }
    
    @media print {
	/* @page { size: 25mm 155mm; margin: 0; } */
    /*@page { size: 25mm 260mm; margin: 0; }*/
    /* @page { size: 23mm 300mm; margin: 0; } */
    @page { size: 25mm 305mm; margin: 0; }
    
        /* .content-depan {
            width: 25mm;
            height: 150mm;
        } */
        .content-depan {
            width: 20mm;
            height: 240mm;
        }
    
        .info_pasien {
            position: absolute;
            transform-origin: left top;
            transform: rotate(90deg);
            left: 21mm;
            height:15mm; width:95mm;
            /* top: 20mm; */
            /* top: 125mm; */
            top: 210mm;
            /* top: 60mm; */
        }
        
        .barcode_pasien {
            position: absolute;
            top: 0mm;
            left: 68mm;
        }
    
    
    }
    
    <?php /*
    .content-depan{
    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    -o-transform: rotate(-90deg);
    -ms-transform: rotate(0deg);
    transform: rotate(0deg);
        color:#000000;
        /*width:8.6cm;*/ /*
        width:8.6cm;
        height:5.5cm;
        border:0px solid;
        margin: 0;
        <?php if(Yii::app()->user->getState('iskartudgntemplate')){ ?>
            background-image: url("images/kartu_pasien_depan.jpg");
            background-size:8.6cm 5.5cm;
            background-repeat:no-repeat;
        <?php } ?>
        position:absolute;
    }
    <?php /* if(Yii::app()->user->getState('iskartudgntemplate')){ ?>
    .content-belakang{
        color:#000000;
        width:8.6cm;
        height:5.5cm;
        border:0px solid;
        margin: 5cm 0px 0px 0px;
            background-image: url("images/kartu_pasien_belakang.jpg");
            background-size:8.6cm 5.5cm;
            background-repeat:no-repeat;
        position:absolute;
    }
    <?php } */ /* ?>
    .pasien{
        font-weight: bold;
        width:35%;
        top:45%;
        left:2%;
        border:0px solid;
        text-align: left;
        position:relative;
    }
    .foto{
        width: 2cm;
        top:57%;
        left:38%;
        border:0px solid;
        text-align: center;
        position:absolute;
    }
    .barcode{
        width:100px;
        border: 0 solid;
        margin:125px 0px 0px 182px;
        padding: 0;
        top: 0;
        overflow: hidden;
        position: absolute;
        filter: gray;
    }
    .data{
        width:200%;
        top:5px;
        margin-left:3px;
        z-index: 1;
        position: relative;
        font-size: 9px;
    }
     * 
     */ ?>
</style>

<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>  
<?php 
	$tgllahir = new DateTime($modPendaftaran->pasien->tanggal_lahir);
	$hariini = new DateTime();
	
	$selisih = $hariini->diff($tgllahir);    
        
    $tgl_lahir = explode('-',$modPendaftaran->pasien->tanggal_lahir);
    $tgl = $tgl_lahir[2];    
    $bulan = $tgl_lahir[1];    
    $tahun = $tgl_lahir[0];    
?>
<div class="content-depan">
<div class="info_pasien">
<!--<div>-->
    
<table>
  <tr width="100%">
    <td style="font-size:10pt; font-wight:bold; font-family:Arial"><b>MR</b></td>
    <td>:</td>
    <td style="font-size:10pt; font-wight:bold; font-family:Arial">
        <b style="font-size: 10pt;"><?php echo $modPendaftaran->pasien->no_rekam_medik; ?></b>
    </td>
   
  </tr>
  <tr width="100%"> 
      <td style="font-size:10.5pt; font-family:Sans-Serif" colspan="3">
          <b><?php echo $modPendaftaran->pasien->namadepan.' '.substr($modPendaftaran->pasien->nama_pasien, 0, 15); ?>
      </td> 
  </tr>
  <tr width="100%">
    <td style="font-size:10pt; font-wight:bold; font-family:Arial" colspan="3">
    <b><?php echo $tgl . '-'. $bulan . '-' . $tahun; ?>
        <?php
            echo ' '.$selisih->y.' Tahun'; 
        ?></b>
    </td>
  </tr>
  <tr width="100%">
    <td style="font-size:10pt; font-wight:bold; font-family:Arial" colspan="3">
        <b style="font-size: 10pt;"><?php echo $modProfilRs->nama_rumahsakit; ?></b>
    </td>
  </tr> 
</table>
<table  class="barcode_pasien">
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
                            // 'matrixPointSize'=>2, // 1 to 10 only
                            'matrixPointSize'=>3, // 1 to 10 only
                        )); 
          ?>
        <div style="font-size: 6pt;"><?php echo $modPasien->no_rekam_medik; ?></div>
    </td>
  </tr>
</table>
</div>
</div>
