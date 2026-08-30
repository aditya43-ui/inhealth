<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
$logomui = 'logo_mui.png';
$logoslhs = 'logo_slhs.png';
?>
<style>
body {
    font-size: 6pt;
    font-family: "Arial" !important;
    color: black !important;
}

table tr, table td {
    vertical-align: top;
}

@page {
    font-size: 7pt !important;
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
        <td style="width: 30%;">Tgl. Diet</td>
        <td style="width: 3%;">:</td>
        <td><?= date('d-m-Y', strtotime($model->tglpesanmenu))?></td>
    </tr>
    <tr>
        <td style="">Waktu Diet</td>
        <td>:</td>
        <td><?= JeniswaktuM::model()->findByPk($jns)->jeniswaktu_nama ?></td>
    </tr>
    <tr>
        <td style="">Ruangan</td>
        <td>:</td>
        <td><?php echo $modRuangan->ruangan_namalainnya . " - " . $modPendaftaran->pasienadmisi->kelaspelayanan->kelaspelayanan_nama; ?></td>
    </tr>
</table>
<br>
<div style="text-align: center;">IDENTITAS PASIEN</div>
<div style="text-align: center;">-------------------------------------------</div>
<table style="width: 100%;" class="bkn-ket">
    <tr>
        <td style="width: 30%;">Nama</td>
        <td style="width: 3%;">:</td>
        <td><?= $modDet[0]->pasien->nama_pasien ?></td>
    </tr>
    <tr>
        <td style="">Tgl. Lahir</td>
        <td>:</td>
]       <td><?= MyFormatter::formatDateTimeId($modDet[0]->pasien->tanggal_lahir) ?></td>
    </tr>
    <tr>
        <td style="">No. RM</td>
        <td>:</td>
        <td><?= $modDet[0]->pasien->no_rekam_medik ?></td>
    </tr>
    <tr>
        <td>Diet</td>
        <td>:</td>
        <td><?= !empty($model->jenisdiet) ? $model->jenisdiet->jenisdiet_nama : '' ?></td>
    </tr>
    <tr>
        <td>Ket</td>
        <td>:</td>
        <td>
            

            <?php foreach($modDet as $det):?>
                    <?php if($det->jeniswaktu_id == $jns):?>
                            <?php 
                                if (!empty($det->menudiet->menudiet_nama)) {
                                    $arr_menu = explode(",", $det->menudiet->menudiet_nama);
                        
                                    foreach ($arr_menu as $idx_menu => $val_menu) {
                                    $arr_menu[$idx_menu] = trim($val_menu);
                                    }
                        
                                    echo implode("<br/>", $arr_menu);
                        
                                } else {
                                    echo "-";
                                }    
                            ?>
                        
                        <?php endif;?>
                <?php endforeach;?>
            

        </td>
    </tr>
    <tr>
        <td>Petugas</td>
        <td>:</td>
        <td><?= $model->nama_pemesan ?></td>
    </tr>
    <tr>
        <td>Verifikasi</td>
        <td>:</td>
        <td>
            <?php 
                foreach($modDet as $val) {
                    if($val->jeniswaktu_id == $jns) {
                        // cek waktu diet ini sudah di verif belum
                        if(!empty($val->verifikasi_id)) {
                            echo $val->pegawaiverif->namaLengkap;
                        }
                    }
                }
            ?>
        </td>
    </tr>
</table>
<?php endforeach; ?>