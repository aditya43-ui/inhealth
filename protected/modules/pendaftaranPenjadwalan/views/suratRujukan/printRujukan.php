<?php $data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<style>
    .barcode-label {
        margin-top: -20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }

    td,
    th {
        font-size: 11pt !important;
        padding: 4px;
    }

    body {
        width: 21.7cm;
    }

    .barcode {
        width: 100px;
        border: 0px solid;
        margin: 0px;
        padding: 0px;
        /*top:8px;*/
        overflow: hidden;
        position: absolute;
        filter: gray;
        z-index: 2;
    }

    .sep_id {
        width: 100px;
        margin-top: 10px;
        z-index: 1;
        text-align: center;
    }
</style>
<?php
// $model->jenispelayanan_bpjs = 2;
$idtipe = 0;
$nama_jenis = "Penuh";
if (strtolower($model->tiperujukan_bpjs) == 'penuh' || $model->tiperujukan_bpjs == "0") {
    $idtipe = 0;
    $nama_jenis = "Penuh";
} else if (strtolower($model->tiperujukan_bpjs) == 'partial' || $model->tiperujukan_bpjs == "1") {
    $idtipe = 1;
    $nama_jenis = "Partial";
} else if (strtolower($model->tiperujukan_bpjs) == 'rujuk balik' || $model->tiperujukan_bpjs == "2") {
    $idtipe = 2;
    $nama_jenis = "Balik PRB";
}
?>

<table width="100%">
    <tr>
        <td width="30%" valign="bottom">
            <img src="<?php echo Yii::app()->getBaseUrl('webroot') . '/images/logo_bpjs.png'; ?>" width="200">
        </td>
        <td width="30%" valign="bottom">
            <?php echo strtoupper($judul_print) . '<br/>' . strtoupper($data->nama_rumahsakit); ?>
        </td>
        <td width="40%" valign="bottom">
            No. <?php echo $model->nosuratrujukan; ?> <br />
            Tgl. <?php echo (!empty($model->sampaidengan) ? MyFormatter::formatDateTimeId($model->sampaidengan) : ""); ?>
        </td>
    </tr>
</table>
<br />
<table width="100%">
    <?php if ($idtipe == 2) { ?>
        <tr>
            <td width="15%">Kepada Yth</td>
            <td width="45%">: <?php echo $model->kepadayth; ?></td>
            <td><?php echo "== Rujukan Balik =="; ?></td>
        </tr>
    <?php } else { ?>
        <tr>
            <td width="15%">Kepada Yth</td>
            <td colspan="2">: <?php echo $model->dirujukkebagian; ?></td>
        </tr>
        <tr>
            <td></td>
            <td width="45%">&nbsp;&nbsp;<?php echo $model->kepadayth; ?></td>
            <td><?php echo "== Rujukan " . ucfirst(strtolower($nama_jenis)) . " =="; ?></td>
        </tr>
    <?php } ?>

    <tr>
        <td colspan="2">Mohon Pemeriksaan dan Penanganan Lebih Lanjut :</td>
        <td><?php echo (!empty($model->jenispelayanan_bpjs)) ? (($model->jenispelayanan_bpjs == '1') ? "Rawat Inap" : "Rawat Jalan") : ""; ?></td>
    </tr>
    <tr>
        <td>No. Kartu</td>
        <td colspan="2">: <?php echo $modSep->nokartuasuransi; ?></td>
    </tr>
    <tr>
        <td>Nama Peserta</td>
        <td colspan="2">: <?php echo $model->pasien->nama_pasien . ' (' . $model->pasien->jeniskelamin . ')'; ?></td>
    </tr>
    <tr>
        <td>Tgl. Lahir</td>
        <td colspan="2">: <?php echo MyFormatter::formatDateTimeId($model->pasien->tanggal_lahir); ?></td>
    </tr>
    <tr>
        <td>Diagnosa</td>
        <td colspan="2">: <?php echo $model->kodediagnosasementara_ruj . ' ' . $model->diagnosasementara_ruj; ?></td>
    </tr>
    <tr>
        <td>Keterangan</td>
        <td colspan="2">: <?php echo $model->catatandokterperujuk; ?></td>
    </tr>
    <tr>
        <td colspan="3">Demikian atas bantuannya, diucapkan banyak terima kasih.</td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td width="60%" valign="top" style="font-size: 10pt !important;">
            * Rujukan Berlaku Sampai Dengan <?php echo (!empty($model->sampaidengan) ? MyFormatter::formatDateTimeId($model->sampaidengan) : ""); ?> <br />
            * Tgl. Rencana Berkunjung <?php echo (!empty($model->tglrencanakunjungan_bpjs) ? MyFormatter::formatDateTimeId($model->tglrencanakunjungan_bpjs) : ""); ?>
        </td>
        <td width="40%">
            Mengetahui,
            <br><br><br><br><br>
            <?php
            $pegawai = $model->pendaftaran->pegawai->namaLengkap;
            if (!empty($model->pasienadmisi)) {
                $pegawai = $model->pasienadmisi->pegawai->namaLengkap;
            }
            echo $pegawai;
            ?>
            <br />
            ___________________
        </td>
    </tr>
    <tr>
        <td colspan="2" style="font-size: 8pt !important;">
            Tgl. Cetak <?php echo date('d-m-Y g:i a'); ?>
        </td>
    </tr>
</table>