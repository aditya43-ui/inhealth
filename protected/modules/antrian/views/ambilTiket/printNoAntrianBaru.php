<style>
    body {
        font-size: 15px important;
        font-family: Arial !important;
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
        width:172px;
        /* height:200px; */
        border: 0 solid;
        margin: 5px;
        padding: 0;
        filter: gray;
    }
</style>
<?php

$data = ProfilrumahsakitM::model()->find();
$model = ModelantrianM::model()->findByPk($modAntrian->modelantrian_id);
$ruangan = $modAntrian->ruangan;
$pegawai = $modAntrian->pegawai;
$loket = $modAntrian->loket;
?>
<table style='width:100vw;' class="details">
    <!-- <tr> -->
        <!-- <td colspan="2" style="font-size: 20px;">
            <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultKarcisRJ2',array('judulLaporan'=>'ANTRIAN PENDAFTARAN')); ?>
        </td> -->
        <!-- </tr> -->
   
    <!-- <tr>
       <td width="100%" colspan="3" style="text-align: center;">
           <b> - Print Ambil Tiket</b><br>
           <b>NOMOR ANTRIAN PENDAFTARAN <br><?php //echo strtoupper($model->modelantrian_nama); ?></b>  
           <br>
           <br><br>
        </td>
    </tr> -->
    
    <tr>
       <td width="100%" colspan="3">
           <div style="padding: 3px;margin: 15px;border: 0;">
           <p style="margin: 10px; text-align: center;">
           <span style="font-size: 1.8em;">NOMOR ANTRIAN</span>
           <br><br>
           <p style="margin: 10px; text-align: center;">
           
           <b><span style="font-size: 60px;"><?php 
            if($model->modelantrian_id == Params::MODELANTRIAN_UMUM_ANTRIAN){
                echo strtoupper($model->modelantrian_singkatan."-".$modAntrian->noantrian);
               } else {
                echo strtoupper($ruangan->ruangan_singkatan . "-" . $modAntrian->noantrian);
                    } ?>
                    </span></b>
                </span></b>  
           <br>
           <br>           
            </div>
           
           <!-- <table width="100%">
               <tr>
                   <th width="15%">&nbsp;</th>
                   <th width="36%" style="text-align:left;font-size:14pt;">Antrian</th>
                   <th style="text-align:left;font-size:14pt;" width="2%">:</th>
                   <th style="text-align:left;font-size:14pt;"><?php //echo $model->modelantrian_nama ?></th>
               </tr>
               <tr>
                   <th></th>
                   <th style="text-align:left;font-size:14pt;">Poliklinik</th>
                   <th style="text-align:left;font-size:14pt;">:</th>
                   <th style="text-align:left;font-size:14pt;"><?php // echo $ruangan->ruangan_nama ?></th>
               </tr>
               <tr>
                   <th></th>
                   <th style="text-align:left;font-size:14pt;">Kunjungan</th>
                   <th style="text-align:left;font-size:14pt;">:</th>
                   <th style="text-align:left;font-size:14pt;"><?php // echo $modAntrian->jenis_kunjungan ?></th>
               </tr>
               <tr>
                   <th></th>
                   <th style="text-align:left;font-size:14pt;">Tanggal Periksa</th>
                   <th style="text-align:left;font-size:14pt;">:</th>
                   <th style="text-align:left;font-size:14pt;"><?php //echo date('d/m/Y', strtotime($modAntrian->tglakandilayani))  ?></th>
               </tr>
               <tr>
                   <th></th>
                   <th style="text-align:left;font-size:14pt;">Jam Dilayani</th>
                   <th style="text-align:left;font-size:14pt;">:</th>
                   <th style="text-align:left;font-size:14pt;"><?php //echo date('H:i', strtotime($modAntrian->tglakandilayani))  ?></th>
               </tr>
           </table> -->
        </td>
    </tr>
    <tr>
        <td colspan="3" width="100%" style="text-align: center;font-size:12pt !important;margin:10px;">
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
                $nobarcode =  $modAntrian->barcode;//$tahun.$bulan.$tanggal.$modAntrian->noantrian;
            ?>
            <br>
            <div class="barcode hide">
                <img src="index.php?r=barcode/myBarcodeKarcis&code=<?php echo $nobarcode; ?>&is_text=" style="transform:scale(2.1)">
               <br>
               <div style="margin-bottom:9px;"></div>
                <span style="font-weight:bold;font-size:16pt;"><?= $nobarcode ?></span><br/>
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