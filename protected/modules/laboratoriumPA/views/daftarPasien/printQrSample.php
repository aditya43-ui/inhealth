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
<div style="text-align:left; width:7cm; height: 2.5cm">
    <table cellpadding="0" cellspacing="0">
        
        <tr>
            <td colspan="2">
                <?php 
                $this->widget('ext.qrcode.QRCodeGenerator',array(
                    'data' =>$modSample->no_pengambilansample,
                    'subfolderVar' => false,
                    'matrixPointSize' => 5,
                    'displayImage'=>true, // default to true, if set to false display a URL path
                    'errorCorrectionLevel'=>'L', // available parameter is L,M,Q,H
                    'matrixPointSize'=>3, // 1 to 10 only
                )) 
                        
                        ?>
            </td>
        </tr>
        
    </table>
</div> 
<?php  
     }else{
         echo'Pasien Belum Melakukan Ambil Sample';
         
     } ?>
