<style>
   
   
    @media print {
     body.receipt { width: 12cm }  
     #print-head {
    display: block;
  } 
  BODY, DIV, TABLE, TBODY, TFOOT, TR, TH, TD, P {
        font-family: "Arial" !important;
        font-size: 20pt !important;
        text-align: left;
    }
    canvas{
        margin-top: 10px;
    }
    B{
        font-size: 22pt !important;
    }
  
    header { display: none !important; } 
footer { display: none !important; } 
}
</style>
<table style="margin-top:10px;margin-left:10px;" width="100%">
<tr style="text-align: left;">
            <td>
            <b>    <?php
         
            echo $modPendaftaran->pasien->no_rekam_medik ?></b>
            <br>
            <?php echo $modPendaftaran->pasien->nama_pasien; ?>
            <br>
            <?php
                echo date('d/m/Y', strtotime($modPendaftaran->pasien->tanggal_lahir));
                ?>
        <br>
        <?php
                echo $modPendaftaran->pasien->no_identitas_pasien;
                ?>
                 <br>
                 <br>
        <img  style="transform:scale(2.3);margin-left:50px;" width="170px" height="30%" src="index.php?r=barcode/myBarcodeKartuPasien&code=<?php echo $modPendaftaran->pasien->no_rekam_medik; ?>&is_text=" >  
            </td>
   
    </table>

    