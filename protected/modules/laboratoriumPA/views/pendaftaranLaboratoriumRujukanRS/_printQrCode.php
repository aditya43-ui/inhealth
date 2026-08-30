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
        width:2cm; 
         
    }
</style>
<div style="border: 0px solid;margin-top: 5px;text-align:left; width:320px;">
<?php $this->widget('ext.qrcode.QRCodeGenerator',array(
    'data' =>$modPasienPenunjang->no_masukpenunjang,
    'subfolderVar' => false,
    'matrixPointSize' => 5,
    'displayImage'=>true, // default to true, if set to false display a URL path
    'errorCorrectionLevel'=>'L', // available parameter is L,M,Q,H
    'matrixPointSize'=>3, // 1 to 10 only
)) ?>
</div>