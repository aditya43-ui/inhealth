<?php
$modInfo = InformasipersiapanpengadaanV::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
$cekpengadaansumberdana = PengadaansumberdanaT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $modInfo->rencanaumumpengadaan_id));
if (!empty($cekpengadaansumberdana)) {
    //Kode Rekening
    $koderekening = '';
    foreach ($cekpengadaansumberdana as $value) {
        $cekRekening = Rekening5M::model()->findByPk($value->rekening5_id);
        $koderekening .= !empty($cekRekening) ? $cekRekening->kdrekening5 . ', ' : ' ';
    }
}
?>  
<div style="margin-top:0mm; margin-bottom:0mm; margin-left:0mm; margin-right:3mm; 
     position: fixed; left:15mm; bottom:70mm; rotate: -90; height:60mm; width:auto;">
    <table border="0" width="100%">
        <tr width="100%"> 
            <td style="font-size:10pt; font-wight:bold; font-family:Sans-Serif" colspan="3"><?php echo !empty($model->nomor_kuitansi) ? $model->nomor_kuitansi : ''; ?></td> 
        </tr>
    </table>
</div>
<div style="margin-top:0mm; margin-bottom:0mm; margin-left:0mm; margin-right:3mm; 
     position: fixed; left:22mm; bottom:100mm; rotate: -90; height:60mm; width:140mm;">
    <table border="0">
        <tr width="100%"> 
            <td style="font-size:10pt; font-wight:bold; font-family:Sans-Serif" colspan="3"><?php echo !empty($model->telahditerima_dari) ? $model->telahditerima_dari : ''; ?></td> 
        </tr>
        <tr width="100%"> 
            <td style="font-size:10pt; font-wight:bold; font-family:Sans-Serif" colspan="3"><?php echo !empty($model->jumlah_diterima) ? ucwords(MyFormatter::kataTerbilang($model->jumlah_diterima)) : ''; ?> Rupiah</td> 
        </tr>
        <tr width="100%"> 
            <td style="font-size:10pt; font-wight:bold; font-family:Sans-Serif" colspan="3">
                Sub Kegiatan : <?php echo !empty($modInfo->subkegiatanprogram_nama) ? $modInfo->subkegiatanprogram_nama : ''; ?>, 
                Program : <?php echo !empty($modInfo->programkerja_kode) ? $modInfo->programkerja_kode : ''; ?>,
                Kegiatan : <?php echo !empty($modInfo->kegiatanprogram_kode) ? $modInfo->kegiatanprogram_kode : ''; ?>,
                Kode Rek : <?php echo $koderekening; ?>
                tanggal <?php echo !empty($model->tanggal_pembayaran) ? date('d ', strtotime($model->tanggal_pembayaran)) . MyFormatter::getMonthId(date('m', strtotime($model->tanggal_pembayaran))) . date(' Y', strtotime($model->tanggal_pembayaran)) : ''; ?>
            </td> 
        </tr>
    </table>
</div>
<div style="margin-top:0mm; margin-bottom:0mm; margin-left:0mm; margin-right:3mm; 
     position: fixed; left:80mm; bottom:80mm; rotate: -90; height:60mm; width:auto;">
    <table border="0">
        <tr width="100%"> 
            <td style="font-size:10pt; font-wight:bold; font-family:Sans-Serif" colspan="3"><?php echo !empty($model->jumlah_diterima) ? number_format($model->jumlah_diterima, 2, ",", ".") : ''; ?></td> 
        </tr>
    </table>
</div>
<div style="margin-top:0mm; margin-bottom:0mm; margin-left:0mm; margin-right:3mm; 
     position: fixed; left:60mm; bottom:160mm; rotate: -90; height:80mm; width:80mm;">
    <table border="0" width="100%" style="text-align: center">
        <tr width="100%"> 
            <td style="font-size:10pt; font-wight:bold; font-family:Sans-Serif" colspan="3">Surabaya</td> 
        </tr>
        <tr width="100%"> 
            <td style="font-size:10pt; font-wight:bold; font-family:Sans-Serif" colspan="3">Yang Menerima,</td> 
        </tr>
        <tr width="100%"> 
            <td style="font-size:10pt; font-wight:bold; font-family:Sans-Serif" colspan="3">
                <br><br><br>
                <u><?php echo !empty($model->pegpjk_id) ? $model->pegpjk->namaLengkap : ''; ?></u><br>NIP. <?php echo !empty($model->pegpjk_id) ? $model->pegpjk->nomorindukpegawai : ''; ?>
            </td> 
        </tr>
    </table>
</div>