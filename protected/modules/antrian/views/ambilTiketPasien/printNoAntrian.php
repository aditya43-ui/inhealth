<style>
    body {
        font-size: 15px important;
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
</style>

<table style='width:100%;' class="details">
    <tr>
        <td colspan="2" style="font-size: 20px;">
            <?php echo $this->renderPartial('application.views.headerReport.headerDefaultKarcisRJ2',array('judulLaporan'=>'ANTRIAN PENDAFTARAN')); ?>
        </td>
        </tr>
    <tr>
        <td width="30%" colspan="1" style="text-align: left; font-weight: bold">
            Tgl. <?= strtoupper(date('d M Y')); ?>
        </td>
        <td width="30%" colspan="1" style="text-align: right; font-weight: bold">
            Jam <?= strtoupper(date('H:i:s')); ?>
        </td>
    </tr>
    <tr>
       <td width="100%" colspan="3" style="text-align: center;">
           <b>NOMOR ANTRIAN PENDAFTARAN </b>
           <br>
           <b> <?php echo strtoupper($modAntrian->loket->loket_namalain); ?></b>  
           <br>

        </td>
    </tr>
    <tr>
       <td width="100%" colspan="3">
           <div style="padding: 0;margin: 0;border: 0;">
           <p style="margin: 0; text-align: center;">
           <b><span style="font-size: 50px;"><?php echo strtoupper($modAntrian->loket->loket_singkatan."-".$modAntrian->noantrian) ?></span></b>  
           <br>
           <p><?php echo $modAntrian->ruangan->ruangan_nama ?> - <?php echo $modAntrian->pegawai ? $modAntrian->pegawai->namaLengkap : '';?></p>
           </p>
               </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" width="100%" style="text-align: center;">
            <?php 
                $konfig = KonfigsystemK::model()->find();
                echo $konfig->footer_antrian;
            ?>
        </td>
    </tr>
</table>
</b></span>
</p>