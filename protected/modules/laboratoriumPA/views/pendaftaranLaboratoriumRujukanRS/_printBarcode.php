<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: left;
        letter-spacing: 10px; 
        font-size: 5pt;
    } 
    tr, td{ 
        
        font-size: 8pt !important; 
        margin-top: 1px;
    }
    body{
        width:6cm; 
         
    }
</style>
<table width="100%" style='position: absolute;'>
    <tr>
        <td><?php echo $modPasienPenunjang->no_masukpenunjang ?></td>
        <td></td>
        <td><?php // echo $modPasienPenunjang->tglmasukpenunjang ?></td>
    </tr>
</table>
<div style="border: 0px solid;margin-top: 5px;text-align:left; width:320px;">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <img style="height: 71px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPasienPenunjang->no_masukpenunjang; ?>&is_text=" > 

    <table width="100%" style='position: absolute;top:50px'>
        <tr>
            <td>Rm : <?php echo $modPasien->no_rekam_medik ?></td>
            <td></td>
            <td><?php echo $modPasienPenunjang->tglmasukpenunjang ?></td>
        </tr> 
        <tr>
            <td><?php echo $modPasien->nama_pasien ?></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div> 
