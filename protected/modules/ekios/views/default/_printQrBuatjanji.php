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


    <div>
        <table cellpadding="0" cellspacing="0" >
            <tr>
                <td colspan="2">
                    <?php
                    $this->widget('ext.qrcode.QRCodeGenerator', array(
                        'data' => $modBuatJanjiPoli->no_buatjanji,
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
                    <?php 
                    $dateformat=date("Y-m-d", strtotime($modBuatJanjiPoli->tgljadwal));
                    ?>
                    Tanggal : <?php echo MyFormatter::formatDateTimeForUser($dateformat) ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    No Booking : <?php echo $modBuatJanjiPoli->no_buatjanji ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                  
                    Jam Estmasi  : <?php echo $modBuatJanjiPoli->jambooking ?>
                </td>
            </tr>
            <?php if($modBuatJanjiPoli->is_kontrol){ ?>
            <tr>
                <td colspan="2">
                  
                    Nama Dokter  : <?php echo ($modBuatJanjiPoli->pegawai ? $modBuatJanjiPoli->pegawai->nama_pegawai : '-') ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                  
                    Nama Poli  : <?php echo ($modBuatJanjiPoli->ruangan ? $modBuatJanjiPoli->ruangan->ruangan_nama : '-') ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                  
                    No Antrian  : <?php echo  (isset($dataKunjungan) ? $dataKunjungan->ruangan_singkatan."-".$dataKunjungan->no_urutantri : '') ?>
                </td>
            </tr>
            <?php } ?>

        </table>
    </div> 
