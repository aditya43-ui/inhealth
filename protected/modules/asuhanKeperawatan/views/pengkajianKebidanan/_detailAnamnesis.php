<?php
echo '<p style="text-align:center;"><b>RIWAYAT ANAMNESIS</b></p>';
?>
<table style="width: 100%; border: none;">
    <tr>
        <td width="20%">
            <b>Nama Pasien</b>
        </td>
        <td width="30%">
            : <?php echo $modAnamnesa->nama_pasien; ?>
        </td>
        <td width="20%">
            <b>Tanggal Anamnesis</b>
        </td>
        <td width="30%">
            : <?php echo MyFormatter::formatDateTimeForUser($modAnamnesa->tglanamnesis); ?>
        </td>
    </tr>
    <tr>
        <td width="20%">
            <b>Jenis Kelamin</b>
        </td>
        <td width="30%">
            : <?php echo $modAnamnesa->jeniskelamin; ?>
        </td>
        <td width="20%">
            <b>Dokter Pemeriksa</b>
        </td>
        <td width="30%">
            : <?php echo (!empty($modAnamnesa->gelardepan) ? $modAnamnesa->gelardepan : "") . " " . (!empty($modAnamnesa->nama_pegawai) ? $modAnamnesa->nama_pegawai : "") . " " . (!empty($modAnamnesa->gelarbelakang_nama) ? $modAnamnesa->gelarbelakang_nama : ""); ?>
        </td>
    </tr>
    <tr>
        <td width="20%">
            <b>Umur</b>
        </td>
        <td width="30%">
            : <?php echo $modAnamnesa->umur; ?>
        </td>
        <td width="20%">
            <b>Nama Paramedis</b>
        </td>
        <td width="30%">
            : <?php echo $modAnamnesa->paramedis_nama; ?>
        </td>
    </tr>
    <tr>
        <td width="20%">
            <b>Tanggal Pendaftaran</b>
        </td>
        <td width="30%">
            : <?php echo MyFormatter::formatDateTimeForUser($modAnamnesa->tgl_pendaftaran); ?>
        </td>
        <td width="20%">
            <b>Kelas Pelayanan</b>
        </td>
        <td width="30%">
            : <?php echo $modAnamnesa->kelaspelayanan_nama; ?>
        </td>
    </tr>
    <tr>
        <td width="20%">
            <b>No. Pendaftaran</b>
        </td>
        <td width="30%">
            : <?php echo $modAnamnesa->no_pendaftaran; ?>
        </td>
        <td width="20%">
        </td>
        <td width="30%">
        </td>
    </tr>
</table>
<br>
<table width="100%" class="table table-striped table-bordered table-condensed">
    <tr>
        <td width="20%">
            <b>Keluhan Utama</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->keluhanutama; ?>
        </td>
        <td width="20%">
            <b>Dismenorche</b>
        </td>
        <td width="30%">
            <?php echo ($modAnamnesa->dismenorche == 1) ? "Ya" : "Tidak"; ?>
        </td>
    </tr>
    <tr>
        <td width="20%">
            <b>Keluhan Tambahan</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->keluhantambahan; ?>
        </td>
        <td width="20%">
            <b>HPHT</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->hpht; ?>
        </td>
    </tr>
    <tr>
        <td width="20%">
            <b>Riwayat Perjalanan Penyakit Pasien</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->riwayatpenyakitterdahulu; ?>
        </td>
        <td width="20%">
            <b>Taksiran Persalinan</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->taksiranpersalinan; ?>
        </td>
    </tr>
    <tr>
        <td width="20%">
            <b>Lama Sakit</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->lamasakit; ?>
        </td>
        <td width="20%">
            <b>Keluhan Saat Hamil</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->keluhansaathamil; ?>
        </td>
    </tr>
    <tr>
        <td width="20%">
            <b>Riwayat Penyakit Terdahulu</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->riwayatpenyakitterdahulu; ?>
        </td>
        <td width="20%">
            <b>ANC</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->anc; ?>
        </td>
    </tr>
    <tr>
        <td width="20%">
            <b>Riwayat Penyakit Keluarga</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->riwayatpenyakitkeluarga; ?>
        </td>
        <td width="20%">
            <b>Riwayat Keluarga Berencana</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->riwayatkb; ?>
        </td>
    </tr>
    <tr>
        <td width="20%">
            <b>Riwayat Alergi Obat</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->riwayatalergiobat; ?>
        </td>
        <td width="20%">
            <b>Frekuensi Makan</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->frekmakan_hari; ?>
        </td>
    </tr>
    <tr>
        <td width="20%">
            <b>Pengobatan Yang Sudah Dilakukan</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->pengobatanygsudahdilakukan; ?>
        </td>
        <td width="20%">
            <b>Makanan Yang Dipantang</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->makananyangdipantang; ?>
        </td>
    </tr>
    <tr>
        <td width="20%">
            <b>Riwayat Alergi Makanan</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->riwayatmakanan; ?>
        </td>
        <td width="20%">
            <b>Lama Tidur</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->lamatidur_jam_hari; ?>
        </td>
    </tr>
    <tr>
        <td width="20%">
            <b>Riwayat Kelahiran</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->riwayatkelahiran; ?>
        </td>
        <td width="20%">
            <b>Masalah Tidur</b>
        </td>
        <td width="30%">
            <?php echo ($modAnamnesa->masalah == 1) ? "Ya" : "Tidak"; ?>
        </td>
    </tr>
    <tr>
        <td width="20%">
            <b>Riwayat Imunisasi</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->riwayatimunisasi; ?>
        </td>
        <td width="20%">
            <b>Kegiatan / Aktifitas</b>
        </td>
        <td width="30%">
            <?php echo ($modAnamnesa->kegiatan_aktivitas == 1) ? "Ya" : "Tidak"; ?>
        </td>
    </tr>
    <tr>
        <td width="20%">
            <b>Status Merokok</b>
        </td>
        <td width="30%">
            <?php echo ($modAnamnesa->statusmerokok == 1) ? "Ya" : "Tidak"; ?>
        </td>
        <td width="20%">
            <b>Olahraga</b>
        </td>
        <td width="30%">
            <?php echo ($modAnamnesa->olahraga == 1) ? "Ya" : "Tidak"; ?>
        </td>
    </tr>
    <tr>
        <td width="20%">
            <b>Jml Rokok/Hari</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->jmlrokok_btg_hr; ?>
        </td>
        <td width="20%">
            <b>Ketergantungan Obat</b>
        </td>
        <td width="30%">
            <?php echo ($modAnamnesa->ketergantunganobat == 1) ? "Ya" : "Tidak"; ?>
        </td>
    </tr>
    <tr>
        <td width="20%">
            <b>Haid Pertama/Menarche Umur</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->menarcheumur_thn; ?>
        </td>
        <td width="20%">
            <b>Minuman Keras</b>
        </td>
        <td width="30%">
            <?php echo ($modAnamnesa->minumankeras == 1) ? "Ya" : "Tidak"; ?>
        </td>
    </tr>
    <tr>
        <td width="20%">
            <b>Siklus Menstruasi/Hari</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->siklusmenstruasi_hari; ?>
        </td>
        <td width="20%">
            <b>Keterangan Anamnesis</b>
        </td>
        <td width="30%">
            <?php echo $modAnamnesa->keterangananamesa; ?>
        </td>
    </tr>
    <tr>
        <td width="20%">
            <b>Siklus Menstruasi Teratur</b>
        </td>
        <td width="30%">
            <?php echo ($modAnamnesa->siklusmenstruasiteratur == 1) ? "Ya" : "Tidak"; ?>
        </td>
        <td width="20%">
        </td>
        <td width="30%">
        </td>
    </tr>
</table>
<?php
echo '<p><b>RIWAYAT PERKAWINAN</b></p>';
?>
<table style="width: 100%; border: none;">
    <tr>
        <td width="20%">
            Status Perkawinan
        </td>
        <td width="40%">
            <?php echo $modAnamnesa->statusperkawinan; ?>
        </td>
        <td width="40%">
            <?php echo $modAnamnesa->jmlperkawinan_kali . ' Kali'; ?>
        </td>
    </tr>
</table>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'informasiasuhankeperawatan-grid',
    'dataProvider' => $modPerkawinan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Perkawinan Ke-',
            'type' => 'raw',
            'value' => '$data->perkawinan_ke',
        ),
        array(
            'header' => 'Tanggal Perkawinan',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglperkawanan)',
        ),
        array(
            'header' => 'Lamanya (Tahun)',
            'name' => 'lamaperkawinan_thn',
            'type' => 'raw',
            'value' => '$data->lamaperkawinan_thn',
        ),
        array(
            'header' => 'Tgl. Lahir Suami',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgllahir_suami)',
        ),
        array(
            'header' => 'Umur Suami (Tahun)',
            'type' => 'raw',
            'value' => '$data->umursuami_thn',
        ),
        array(
            'header' => 'Anak (Orang)',
            'type' => 'raw',
            'value' => '$data->jmlanak_org',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>
<?php
echo '<p><b>RIWAYAT KEHAMILAN, PERSALINAN, NIFAS DAN LAKTASI YANG LALU</b></p>';
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'informasiasuhankeperawatan-grid',
    'dataProvider' => $modPersalinan,
    'mergeHeaders' => array(
        array(
            'name' => '<p style="margin: 0; text-align: center;">Anak</p>',
            'start' => 6,
            'end' => 7,
        ),
    ),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Tgl/Bln/Th Partus',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpartus)',
        ),
        array(
            'header' => 'Tempat Partus',
            'type' => 'raw',
            'value' => '$data->tempatpartus',
        ),
        array(
            'header' => 'Umur Hamil',
            'name' => 'umurhamil_bln',
            'type' => 'raw',
            'value' => '$data->umurhamil_bln',
        ),
        array(
            'header' => 'Jenis Persalinan',
            'type' => 'raw',
            'value' => '$data->jenispersalinan',
        ),
        array(
            'header' => 'Penolong Persalinan',
            'type' => 'raw',
            'value' => '$data->penolongpersalinan',
        ),
        array(
            'header' => 'Penyulit',
            'type' => 'raw',
            'value' => '$data->penyulit',
        ),
        array(
            'header' => 'BB',
            'type' => 'raw',
            'value' => '$data->bbanak_gram',
        ),
        array(
            'header' => 'PB',
            'type' => 'raw',
            'value' => '$data->pbanak_cm',
        ),
        array(
            'header' => 'Pemberian Asi',
            'type' => 'raw',
            'value' => '$data->pemberianasi',
        ),
        array(
            'header' => 'Keadaan Anak Sekarang',
            'type' => 'raw',
            'value' => '$data->keadaananakskrg',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>