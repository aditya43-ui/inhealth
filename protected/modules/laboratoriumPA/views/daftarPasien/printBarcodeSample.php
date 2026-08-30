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
<?php if(!empty($modSample)) {  
         $umur = $modSample->pasienmasukpenunjang->pendaftaran->umur;
         $umur_explode = (explode(" ", $umur));
         $umur_baru = $umur_explode[0]." ".$umur_explode[1]." ".$umur_explode[2]." ".$umur_explode[3];
     ?>
<div style="margin-top: 5px;text-align:left; width:5cm; height: 2.5cm">
    <table cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="2">
                <span style="margin-left: 8px;font-size: 6pt; position:absolute; color: black" > SID: <?php echo $modSample->no_pengambilansample; ?> </span>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <img style="height: 113.385826772px; margin-bottom: -52px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modSample->no_pengambilansample; ?>&is_text=" > 
            </td>
        </tr>
        <tr>
            <td> <span style="margin-left: 8px;font-size: 6pt; position:absolute; color: black; margin-top: 8px" > RM: <?php echo $modSample->pasienmasukpenunjang->pasien->no_rekam_medik?> </span></td>
            <td> <span style="font-size: 6pt; position:absolute; color: black; margin-top: 8px" > <?php echo date("d/m/Y H:i", strtotime($modSample->pasienmasukpenunjang->create_time))." ".$umur_baru?> </span></td>
        </tr>
        <tr> <td colspan="2"> <span style="margin-left: 8px;font-size: 6pt; position:absolute; color: black; margin-top: 20px" >  <?php echo $modSample->pasienmasukpenunjang->pasien->nama_pasien?> </span> </td></tr>
    </table>
</div> 
<?php  
     
     }else{
         echo'Pasien Belum Melakukan Ambil Sample';
         
     } ?>
