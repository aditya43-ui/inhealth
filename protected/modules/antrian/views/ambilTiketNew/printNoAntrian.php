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

<table style='width:100%;' class="details" >
    <tr>
        <td width="100%" colspan="3" style="font-size: 20px; text-align: center">
                   <div style=""><?php echo $this->renderPartial('application.views.headerReport.headerDefaultantrian',array('judulLaporan'=>'ANTRIAN PENDAFTARAN')); ?></div>
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
           <div style="padding:0px;margin:0px;border:0px;">
           <center>
           <b><font style="font-size: 18px;"><?php 
           
           $modelAntrian = ModelantrianM::model()->findByPk($modAntrian->modelantrian_id);
           echo strtoupper($modelAntrian->modelantrian_deskripsi); 
           ?></font></b>  
           <br>
           </center>
               </div>
        </td>
    </tr>
    <tr>
       <td width="100%" colspan="3">
           <div style="padding:0px;margin:0px;border:0px;">
           <center>
           <b><font style="font-size: 60px;"><?php echo strtoupper($modelAntrian->modelantrian_singkatan."-".$modAntrian->noantrian) ?></font></b>  
           <br>
           </center>
               </div>
        </td>
    </tr>
    <tr>
       <td width="100%" colspan="3">
           <div style="padding:0px;margin:0px;border:0px;">
                <center>
                <b><font style="font-size: 12px;"> Simpan no antrian ini</font></b>  
                <br>
                </center>
            </div>
            <div style="padding:0px;margin:0px;border:0px;">
                <center>
                <b><font style="font-size: 12px;">dan</font></b>
                <br>
                </center>
            </div>
           <div style="padding:0px;margin:0px;border:0px;">
                <center>
                <b><font style="font-size: 12px;">tunggu panggilan antrian</font> </b>
                <br>
                </center>
               <div colspan="1" HEIGHT=1 style="border-bottom: 1px dashed #000000"></div>
            </div>
        </td>
    </tr>
    
</table>
</b></font>
</center>