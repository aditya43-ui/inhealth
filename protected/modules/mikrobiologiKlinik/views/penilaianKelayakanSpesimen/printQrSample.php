<style>
    @page {
        margin: 0cm 0cm 0cm 0cm;
    }
    @media print {
        html, body {
            padding: 0.08cm 0.08cm 0.08cm 0.08cm;
            width: 1.5cm;
            height: 1.5cm;
        }
    }
</style> 

<?php
if (!empty($modKunjungan)) {
    $umur = $modKunjungan->umur;
    $umur_explode = (explode(" ", $umur));
    $umur_baru = $umur_explode[0] . " " . $umur_explode[1] . " " . $umur_explode[2] . " " . $umur_explode[3];
    ?>
    <div>
        <table cellpadding="0" cellspacing="0" >
            <tr>
                <td colspan="2">
                    <?php
                    $this->widget('ext.qrcode.QRCodeGenerator', array(
                        'data' => $modSpesimen->no_spesimen,
                        'subfolderVar' => false,
                        'matrixPointSize' => 5,
                        'displayImage' => true, // default to true, if set to false display a URL path
                        'errorCorrectionLevel' => 'L', // available parameter is L,M,Q,H
                        'matrixPointSize' => 3, // 1 to 10 only
                    ))
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    SID : <?php echo $modSpesimen->no_spesimen; ?>
                </td>
            </tr>
        </table>
    </div> 
    <?php
} else {
    echo'Pasien Belum Melakukan Ambil Sample';
}
?>
