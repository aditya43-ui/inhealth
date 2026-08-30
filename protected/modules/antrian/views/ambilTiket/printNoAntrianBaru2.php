<style>
    body {
        font-size: 15px important;
        font-family: Arial, Helvetica, sans-serif;
    }
    .headers td .nama_profil font{
        font-size: 15px !important;
    }
    
    .headers .judul > font > h5, .details td {
        font-size: 10px !important;
    }
    
    .headers .logo_profil > img {
        width: 50px !important;
    }
    
     .barcode{
        width:100px;
        border: 0 solid;
        margin: 0;
        padding: 0;
        filter: gray;
    }
</style>
<?php

$model = ModelantrianM::model()->findByPk($modAntrian->modelantrian_id);
$ruangan = $modAntrian->ruangan;
$pegawai = $modAntrian->pegawai;
$loket = $modAntrian->loket;
?>
<table style='width:100%;' class="details">
    <!-- <tr> -->
        <!-- <td colspan="2" style="font-size: 20px;">
            <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultKarcisRJ2',array('judulLaporan'=>'ANTRIAN PENDAFTARAN')); ?>
        </td> -->
        <!-- </tr> -->
    <tr>
        <td width="30%" colspan="1" style="text-align: left; font-weight: bold">
        </td>
        <td width="30%" colspan="1" style="text-align: right; font-weight: bold">
        </td>
    </tr>
    <tr>
       <td width="100%" colspan="3" style="text-align: center;">
           <b>NOMOR ANTRIAN PENDAFTARAN <br><?php echo strtoupper($model->modelantrian_nama); ?></b>  
           <br>
           <br><br>
        </td>
    </tr>
    
    <tr>
       <td width="100%" colspan="3">
           <div style="padding: 0;margin: 0;border: 0;">
           <p style="margin: 0; text-align: center;">
           <b><span style="font-size: 50px;">
           <?php 

            if($model->modelantrian_id == Params::MODELANTRIAN_UMUM_ANTRIAN){
                echo strtoupper($model->modelantrian_singkatan."-". str_pad($modAntrian->noantrian, 3, '0', STR_PAD_LEFT));
            } else {
                echo strtoupper($ruangan->ruangan_singkatan . "-" . str_pad($modAntrian->noantrian, 3, '0', STR_PAD_LEFT));
            } 
                       
           
           ?></span></b>  
           <br>
           <br>           
            </div>
           
           <table width="100%">
               <tr>
                   <th width="15%">&nbsp;</th>
                   <th width="36%" style="text-align:left;font-size:9pt;">Antrian</th>
                   <th style="text-align:left;font-size:9pt;" width="2%">:</th>
                   <th style="text-align:left;font-size:9pt;"><?= $model->modelantrian_nama ?></th>
               </tr>
               <tr>
                   <th></th>
                   <th style="text-align:left;font-size:9pt;">Poliklinik</th>
                   <th style="text-align:left;font-size:9pt;">:</th>
                   <th style="text-align:left;font-size:9pt;"><?= $ruangan->ruangan_nama ?></th>
               </tr>
               <tr>
                   <th></th>
                   <th style="text-align:left;font-size:9pt;">Kunjungan</th>
                   <th style="text-align:left;font-size:9pt;">:</th>
                   <th style="text-align:left;font-size:9pt;"><?= $modAntrian->jenis_kunjungan ?></th>
               </tr>
               <tr>
                   <th></th>
                   <th style="text-align:left;font-size:9pt;">Tanggal Periksa</th>
                   <th style="text-align:left;font-size:9pt;">:</th>
                   <th style="text-align:left;font-size:9pt;"><?= date('d/m/Y', strtotime($modAntrian->tglakandilayani))  ?></th>
               </tr>
               <tr>
                   <th></th>
                   <th style="text-align:left;font-size:9pt;">Jam Dilayani</th>
                   <th style="text-align:left;font-size:9pt;">:</th>
                   <th style="text-align:left;font-size:9pt;"><?= date('H:i', strtotime($modAntrian->tglakandilayani))  ?></th>
               </tr>
           </table>
        </td>
    </tr>
    <tr>
        <td colspan="3" width="100%" style="text-align: center;font-size:15pt !important;margin:10px;">
            <?php 
                echo '|'.(!empty($loket)?$loket->loket_nama:'').'|';
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" width="100%" align="center">
            <?php
                $tahun =  date('y', strtotime($modAntrian->tglantrian));
                $bulan =  date('m', strtotime($modAntrian->tglantrian));
                $tanggal =  date('d', strtotime($modAntrian->tglantrian));
                $no_loket = $loket->loket_nourut;
                $nobarcode =  $tahun.$bulan.$tanggal.$no_loket.$modAntrian->noantrian;
            ?>
            <div class="barcode">
                <img src="index.php?r=barcode/myBarcodeKarcis&code=<?php echo $nobarcode; ?>&is_text=" style="transform:scale(2.0)">
                <span style="font-weight:bold;font-size:10pt;"><?= $nobarcode ?></span><br/>
            </div>            
        </td>
    </tr>
    <tr>
        <td colspan="3" width="100%" style="text-align: center;">
            <?php 
            
            
                $konfig = KonfigsystemK::model()->find();
                echo '<p>Tanggal cetak '.date('d/m/Y').'</p>';
                echo $konfig->footer_antrian;
            ?>
        </td>
    </tr>
   
    <tr>
       <!-- <td width="100%" colspan="3" style="text-align: center;">
           <b>PERKIRAAN AKAN DILAYANI : <?php //echo MyFormatter::formatDateTimeForUser($modAntrian->tglakandilayani); ?></b>  
           <br>
        </td> -->
    </tr>
    
</table>