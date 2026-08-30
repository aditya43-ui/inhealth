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
$konfig = KonfigsystemK::model()->find();
$model = ModelantrianM::model()->findByPk($modAntrian->modelantrian_id);
$ruangan = $modAntrian->ruangan;
$pegawai = $modAntrian->pegawai;
$loket = $modAntrian->loket;
$tanggal = explode(' ', $modAntrian->tglantrian)[0];


// $modAntrianAll = AntrianT::model()->findAll(array('modelantrian_id' => 12, 'panggil_flaq' => false));
$sql = "SELECT count(antrian_id) as menunggu FROM antrian_t WHERE DATE(tglantrian)='" . date('Y-m-d') . "' AND panggil_flaq = false AND modelantrian_id = " . $model->modelantrian_id;
$menunggu = Yii::app()->db->createCommand($sql)->queryRow();
$jmlMenunggu = (isset($menunggu['menunggu'])) ? $menunggu['menunggu'] : 0;
$jmlMenunggu = ($jmlMenunggu > 0) ? $jmlMenunggu = $jmlMenunggu - 1 : $jmlMenunggu;
$hari = MyFormatter::getDayUser(date('w', strtotime($tanggal)));

?>
<table style='width:100vw;' class="details">
    <tr> 
        <td colspan="2" style="font-size: 20px;">
            <?php echo $this->renderPartial('application.views.headerReport.headerDefaultKarcis',array('judulLaporan'=>'ANTRIAN PENDAFTARAN')); ?>
        </td>
    </tr>
   
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
           <span style="font-size: 1.8em;font-weight: bold;"><?= $hari . ', ' .MyFormatter::formatDateTimeForUser($modAntrian->tglantrian) ?></span>
           <br><br>
            <span style="font-size: 1.8em;font-weight: bold;">Rawat Inap</span>
            <br><br>
           <p style="margin: 10px; text-align: center;">
           <b><span style="font-size: 60px;">
                <?php 
                    echo strtoupper($model->modelantrian_singkatan."-".$modAntrian->noantrian);
                ?>
                </span></b>  
           <br>
           <br>           
            </div>
           
           <table width="100%">
               <tr>
                   <th width="15%">&nbsp;</th>
                   <th width="36%" style="text-align:right;font-size:14pt;">Menunggu</th>
                   <th style="text-align:left;font-size:14pt;" width="2%">:</th>
                   <th style="text-align:left;font-size:14pt;"><?= $jmlMenunggu ?></th>
               </tr>
           </table>
        </td>
    </tr>
    
    <tr>
        <td colspan="3"><hr style="width: max-content; color: black solid;"></td>
    </tr>
    
    <tr>
        <td colspan="3" width="100%" style="text-align: center; border-top:1px solid black">
           <span style="font-size:14pt;">Terimakasih Atas Kunjungan Anda | Terlewat Satu Nomor Silahkan Ambil Tiket Kembali</span>
        </td>
    </tr>
   
    <tr>
       <!-- <td width="100%" colspan="3" style="text-align: center;">
           <b>PERKIRAAN AKAN DILAYANI : <?php //echo MyFormatter::formatDateTimeForUser($modAntrian->tglakandilayani); ?></b>  
           <br>
        </td> -->
    </tr>
    
</table>