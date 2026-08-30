
<table width="100%" style='border-collapse: collapse;table-layout: fixed;'>
    <tr>     
        <td style="padding:0px;" style='text-align:center;'>
        <?php 
        $this->widget('ext.qrcode.QRCodeGenerator',array(
            'data' =>$load,
            'filename' => $kode,
            'subfolderVar' => 'uploads',
            'subfolderVar' => false,
            'matrixPointSize' => 5,
            'displayImage'=>true,
            'errorCorrectionLevel'=>'L', // available parameter is L,M,Q,H
            'matrixPointSize'=>4, // 1 to 10 only
        )) ?>
        </td>
        <td style="padding:0px;font-size:9pt;vertical-align: top;">
            <b>
            <?= $inv->invperalatan_namabrg.'<br/>' ?>
            <?= $inv->invperalatan_kode.'<br/>' ?>
            <?= $inv->sumberdana.'<br/>' ?>
            <?= $inv->invperalatan_thnpembelian.'<br/>' ?>
            </b>
        </td>
    </tr>    
</table>
