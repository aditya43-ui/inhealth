<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/_print_triase.css">

<style>
    .tab_detail th {
        font-weight: bold;
        text-align: center;
        vertical-align: middle !important;
    }
</style>

<?php
$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';
?>

<div class="row-fluid">
    <div class="col-sm-6">
        <table class="tab_info">
            <tbody>
                <tr>
                    <td>Ruangan, Kamar/No Bed</td>
                    <td>:</td>
                    <td><?php 
                    $masuk = MasukkamarT::model()->findByAttributes(array(
                        'ruangan_id'=>$model->ruangan_id,
                        'pasienadmisi_id'=>$kunjungan->pasienadmisi_id,
                    ));
                    
                    echo empty($model->ruangan) ? "-" : $model->ruangan->ruangan_nama;
                    echo empty($masuk) ? "" : (", ".$masuk->kamarruangan->kamarruangan_nokamar." Bed ".$masuk->kamarruangan->kamarruangan_nobed);
                    
                    ?></td>
                </tr>
                <tr>
                    <td>MRS</td>
                    <td>:</td>
                    <td><?php echo MyFormatter::formatDateTimeForUser($kunjungan->tgladmisi); ?></td>
                </tr>
                <tr>
                    <td>Hari Perawatan Ke-</td>
                    <td>:</td>
                    <td><?php echo $model->hariperawatke ?></td>
                </tr>
                <tr>
                    <td>Nama Auditor</td>
                    <td>:</td>
                    <td><?php echo empty($model->auditor) ? "-" : $model->auditor->namaLengkap; ?></td>
                </tr>
                <tr>
                    <td>Tanggal Audit</td>
                    <td>:</td>
                    <td><?php echo MyFormatter::formatDateTimeForUser($model->tgl_audit); ?></td>
                </tr>
                <tr>
                    <td>Jam Audit</td>
                    <td>:</td>
                    <td><?php echo $model->jam_audit; ?></td>
                </tr>
                <tr>
                    <td>Jenis Diet</td>
                    <td>:</td>
                    <td><?php echo empty($model->jenisdiet) ? "-" : $model->jenisdiet->jenisdiet_nama ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-sm-6">
        <u>Diagnosa</u>
        <?php
        $diagnosa_utama = "";
        $diagnosa_penyerta = "";

        if (!empty($kunjungan)) {
            $diagnosa_utama_data = PasienmorbiditasT::model()->findByAttributes(array(
                'pendaftaran_id' => $kunjungan->pendaftaran_id,
                'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA,
            ));
            $diagnosa_penyerta_data = PasienmorbiditasT::model()->findByAttributes(array(
                'pendaftaran_id' => $kunjungan->pendaftaran_id,
                'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_TAMBAH,
            ));

            if (!empty($diagnosa_utama_data)) {
                $diagnosa_utama = empty($diagnosa_utama_data->diagnosa) ? "" : ($diagnosa_utama_data->diagnosa->diagnosa_kode." - ".$diagnosa_utama_data->diagnosa->diagnosa_nama);
            }
            if (!empty($diagnosa_penyerta_data)) {
                $diagnosa_penyerta = empty($diagnosa_penyerta_data->diagnosa) ? "" : ($diagnosa_penyerta_data->diagnosa->diagnosa_kode." - ".$diagnosa_penyerta_data->diagnosa->diagnosa_nama);
            }
        }
        ?>
        <table class="tab_info">
            <tbody>
                <tr>
                    <td>Utama</td>
                    <td>:</td>
                    <td><?php echo empty($diagnosa_utama) ? "-" : $diagnosa_utama; ?></td>
                </tr>
                <tr>
                    <td>Penyerta</td>
                    <td>:</td>
                    <td><?php echo empty($diagnosa_penyerta) ? "-" : $diagnosa_penyerta; ?></td>
                </tr>
                <tr>
                    <td>Bentuk Makanan</td>
                    <td>:</td>
                    <td><?php echo empty($model->tipediet) ? "-" : $model->tipediet->tipediet_nama; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php

$jenis = JeniswaktuM::model()->findAllByAttributes(array(
    'jeniswaktu_aktif' => true,
    ), array(
    'order' => 'urutan',
));

$persen = PersensisamakananM::model()->findAllByAttributes(array(
    'persensisamakanan_aktif' => true,
    ), array(
    'order' => 'urutan'
));
?>
<br/>
<table class="tab_detail">
    <thead>
        <tr>
            <th rowspan="2">Waktu Makan</th>
            <th rowspan="2">No.</th>
            <th rowspan="2">Jenis Makanan</th>
            <th colspan="6">% Sisa Makanan</th>
            <th rowspan="2">Keterangan</th>
        </tr>
        <tr>
            <?php foreach ($persen as $item): ?>
            <th style="text-align: center;"><?php echo $item->persensisamakanan_nama; ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php
        
        $cnt = 1;
        foreach ($jenis as $item):
            $makanan = JenismakananM::model()->findAllByAttributes(array(
                'jeniswaktu_id' => $item->jeniswaktu_id,
                ), array(
                'order' => 'urutan'
            ));

            if (count($makanan) == 0) {
                continue;
            }
            
            $rowspan = count($makanan);
            
            foreach($makanan as $idx => $item2): 
                
                $det = SisamakananpasiendetT::model()->findByAttributes(array(
                    'sisamakananpasien_id' => $model->sisamakananpasien_id,
                    'jenismakanan_id' => $item2->jenismakanan_id,
                ));

                if (empty($det)) {
                    $det = new SisamakananpasiendetT;
                    $det->jenismakanan_id = $item2->jenismakanan_id;
                }
                
        ?>
        <tr>
            <?php if ($idx == 0): ?>
            <td rowspan="<?php echo $rowspan; ?>">
                <?php echo $item->jeniswaktu_nama; ?>
            </td>
            <?php endif; ?>
            <td><?php echo $cnt++; ?></td>
            <td><?php echo $item2->jenismakanan_nama; ?></td>
            <?php foreach ($persen as $item3): ?>
            <td style="text-align: center;">
                <?php echo $det->persensisamakanan_id == $item3->persensisamakanan_id ? $ceklis : $unceklis; ?>
            </td>
            <?php endforeach; ?>
            <td><?php echo $det->keterangan; ?></td>
        </tr>
            <?php  
            
            endforeach; ?>
        <?php  endforeach; ?>
    </tbody>
</table>
<br/>
<div class="panel_main">
    <div class="panel_judul">
        AUDIT SCORE
    </div>
    <div class="panel_body">
        <div class="row-fluid">
            <div class="col-sm-6">
            <table class="tab_info">
                <tbody>
                    <tr>
                        <td>Jumlah Jenis Menu</td>
                        <td>:</td>
                        <td><?php echo $model->jml_jenismenu ?></td>
                    </tr>
                    <tr>
                        <td>Total 4 dan 5 (Sisa Makanan 25% dan 0%)</td>
                        <td>:</td>
                        <td><?php echo $model->jml_4dan5 ?></td>
                    </tr>
                    <tr>
                        <td>Audit Score</td>
                        <td>:</td>
                        <td><?php echo number_format($model->auditscore_persen, 2, "," ,"") ?> %</td>
                    </tr>
                    <tr>
                        <td>Kesimpulan</td>
                        <td>:</td>
                        <td><?php echo empty($model->kesimpulan) ? "-" : $model->kesimpulan ?></td>
                    </tr>
                </tbody>
            </table>
            </div>
            <div class="col-sm-6">
                <br/>
                <div class="panel panel-darkk" style="">
                    <span class="group-title">
                        Rumus Audit Score
                    </span>
                    <div class="panel-body">
                        Rumus = (Total Sisa Makanan 25% dan Sisa Makanan 0% : Jumlah Jenis Menu) x 100%<br/>
                        Kesimpulan :<br/>
                        Audi Score &ge; 20 % = Terpenuhi<br/>Audit Score &le; 20 % = Tidak Terpenuhi
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>