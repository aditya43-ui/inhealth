<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
$logomui = 'logo_mui.png';
$logoslhs = 'logo_slhs.png';
?>
<style>
body {
    font-size: 6pt;
    font-family: "Courier New", Courier, monospace;
}

table tr, table td {
    vertical-align: top;
}

</style>

<?php

    $jenis = [];
    $jenis_id = [];
    $waktu = '';
    $waktu_id = [];

    foreach($modDet as $det) {
        array_push($jenis, $det->jeniswaktu_id);
    }

    $wkt = [];

    $crit = new CDbCriteria;
    $crit->select = 'jeniswaktu_id, jeniswaktu_nama, jeniswaktu_namalain';
    $crit->group = $crit->select;
    $crit->addInCondition('jeniswaktu_id', $jenis);
    $crit->order = 'urutan';

    $modJenis = JeniswaktuM::model()->findAll($crit);
        
    foreach($modJenis as $jns1) {
        array_push($wkt, $jns1->jeniswaktu_namalain);
        array_push($jenis_id, $jns1->jeniswaktu_id);

    }

    // var_dump($jenis_id); die;

    $waktu = implode(', ', $wkt);

    foreach($jenis_id as $j => $jns):
?>

<?php if($j > 0): ?>
    <div style="page-break-before: always;"></div>
<?php endif;?>

<table style="width: 100%;" class="bkn-ket">
    <tr>
        <td style="width: 40%;">Tgl. Diet</td>
        <td>&emsp;:&emsp;<?= date('d-m-Y', strtotime($model->tglpesanmenu))?></td>
    </tr>
    <tr>
        <td style="">Waktu Diet</td>
        <td>&emsp;:&emsp;<?= JeniswaktuM::model()->findByPk($jns)->jeniswaktu_nama ?></td>
    </tr>
    <tr>
        <td style="">Ruangan</td>
        <td>&emsp;:&emsp;<?= $model->ruangan->ruangan_nama ?></td>
    </tr>
</table>
<br>
<div style="text-align: center;">IDENTITAS PASIEN</div>
<div style="text-align: center;">-------------------------------------------</div>
<table style="width: 100%;" class="bkn-ket">
    <tr>
        <td style="width: 40%;">Nama</td>
        <td>&emsp;:&emsp;<?= $modDet[0]->pasien->nama_pasien ?></td>
    </tr>
    <tr>
        <td style="">Tgl. Lahir</td>
]        <td>&emsp;:&emsp;<?= MyFormatter::formatDateTimeId($modDet[0]->pasien->tanggal_lahir) ?></td>
    </tr>
    <tr>
        <td style="">No. RM</td>
        <td>&emsp;:&emsp;<?= $modDet[0]->pasien->no_rekam_medik ?></td>
    </tr>
</table>
<p>Diet&emsp;:&emsp;<?= !empty($model->jenisdiet) ? $model->jenisdiet->jenisdiet_nama : '' ?></p>
<p>Ket&emsp;:&emsp;<?php //echo $model->jenisdiet->jenisdiet_nama ?></p>
<table style="width: 100%; margin-left: 50px;" class="tbl-ket">
    <?php foreach($modDet as $det):?>
            <?php if($det->jeniswaktu_id == $jns):?>
                <tr><td>&emsp;-&emsp;</td><td style=""><?= $det->menudiet->menudiet_nama ?></td></tr>
            <?php endif;?>
    <?php endforeach;?>
</table>
<p style="">
    Petugas&emsp;:&emsp;<?= $model->nama_pemesan ?><br>Verifikasi&emsp;:&emsp;<?= $model->loginpemakai->pegawai->namaLengkap ?>
</p>
<p style="text-align: center;">-------------------------------------------</p>
<?php endforeach; ?>