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
        <td width="100%" colspan="3" style="font-size: 20px; text-align: center">
                   <div><?php echo $this->renderPartial('application.views.headerReport.headerDefaultantrian',array('judulLaporan'=>'ANTRIAN PENDAFTARAN')); ?></div>
        </td>
        </tr>
       
    <tr>
        <td width="100%" colspan="1" style="text-align: center; font-weight: bold">
            Tgl :<?= strtoupper(date('d M Y')); ?> - Waktu :<?= strtoupper(date('H:i:s')); ?>
        </td>
   
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr>
       
        <td width="100%" colspan="3">
           <div style="padding: 0;margin: 0;border: 0;">
           <p style="margin: 0; text-align: center;">
           <b><span style="font-size: 18px;"><?php 
           
           $modelAntrian = ModelantrianM::model()->findByPk($modAntrian->modelantrian_id);
           echo strtoupper($modelAntrian->modelantrian_deskripsi); 
           ?></span></b>  
           <br>
           </p>
               </div>
        </td>
    </tr>
    <tr>
       <td width="100%" colspan="3">
           <div style="padding: 0;margin: 0;border: 0;">
           <p style="margin: 0; text-align: center;">
           <b><span style="font-size: 60px;"><?php echo strtoupper($modelAntrian->modelantrian_singkatan."-".$modAntrian->noantrian) ?></span></b>  
           <br>
           </p>
               </div>
        </td>
    </tr>
    <tr>
       <td width="100%" colspan="3">
           <div style="padding: 0;margin: 0;border: 0;">
                <p style="margin: 0; text-align: center;">
                <b><span style="font-size: 12px;"> Simpan No. Antrian Ini</span></b>  
                <br>
                </p>
            </div>
           <div style="padding: 0;margin: 0;border: 0;">
                <p style="margin: 0; text-align: center;">
                <span style="font-size: 12px;">No. Antrian ini menjadi No Panggil</span>
                <br>
                </p>
            </div>
           <div style="padding: 0;margin: 0;border: 0;">
                <p style="margin: 0; text-align: center;">
                <span style="font-size: 12px;">untuk Ruangan Selanjutnya</span> 
                <br>
                </p>
               <div colspan="1" HEIGHT=1 style="border-bottom: 1px dashed #000000"></div>
            </div>
        </td>
    </tr>
    
</table>
</b></span>
</p>