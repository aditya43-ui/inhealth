<style>

    .header_alamat h4 {
        font-weight: normal;
        font-size: 10pt;
    }

    .tab_detail {
        width: 100%;
        border-collapse: collapse;
    }
    
    .tab_detail td, .tab_detail th {
        border: 1px solid black;
        padding: 3px;
    }
    
    .tab_base_1 td {
        vertical-align: top;
    }
    
    .panel_ket {
        margin-top: 10px;
        border: 1px solid black;
        display: inline-block;
        padding: 5px;
    }
    
</style>

<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)) {
    $template = "{items}";
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}

echo $this->renderPartial('_headerPrint', array(
    'kunjungan' => $daftar, 'daftar' => PendaftaranT::model()->findByPk($daftar->pendaftaran_id), 'judulLaporan' => $judulLaporan,
));

// var_dump($permintaan->attributes); die;

$admisi = PasienadmisiT::model()->findByAttributes(array(
    'pendaftaran_id'=>$daftar->pendaftaran_id,
), array(
    'order'=>'pasienadmisi_id desc'
));

if (!empty($admisi)) {
    $daftar->ruangan_id = $admisi->ruangan_id;
    $daftar->instalasi_id = $admisi->ruangan->instalasi_id;
    $daftar->pegawai_id = $admisi->pegawai_id;
}







?>

<table width="100%" class="tab_base_1">
    <tr>
        <td width="150">Ruang Rawat</td>
        <td width="10">:</td>
        <td width="35%"><?php echo $daftar->ruangan->ruangan_nama; ?></td>
        <td width="150">Riwayat Alergi</td>
        <td width="10">:</td>
        <td><?php 
        echo $permintaan->riwayat_alergi;
        if ($permintaan->riwayat_alergi == "Ya") {
            echo ", ".$permintaan->riwayat_alergijenis;
        }
        ?></td>
    </tr>
    <tr>
        <td>Dokter yang Merawat</td>
        <td>:</td>
        <td><?php echo $daftar->pegawai->namaLengkap; ?></td>
        <td>Pernah Transfusi Darah/Produk Darah</td>
        <td>:</td>
        <td><?php echo $permintaan->pernah_transfusi ?></td>
    </tr>
</table>

<table class="tab_detail">
    <thead>
        <tr>
            <th rowspan="2">Tanggal Monitoring</th>
            <th rowspan="2">Jam Monitoring</th>
            <th rowspan="2">Jenis Darah</th>
            <th rowspan="2">No. Kantong</th>
            <th rowspan="2">Isi</th>
            <th colspan="4">TTV</th>
            <th rowspan="2">Nama Perawat/ Bidan</th>
            <th rowspan="2">Reaksi<br>-/+ (Sebutkan)</th>
        </tr>
        <tr>
            <th>TD<br>(mmHg)</th>
            <th>Nadi<br>(x/menit)</th>
            <th>RR<br>(x/menit)</th>
            <th>Suhu<br>(&deg;C)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($riwayat as $item): ?>
            <tr>
                <td><?php echo MyFormatter::formatDateTimeForUser($item->monitoring_tanggal); ?></td>
                <td><?php echo $item->monitoring_jam; ?></td>
                <td><?php 
                        $stok = StokkantongdarahT::model()->findByPk($item->stokkantongdarah_id);
                        if (!empty($stok)) {
                            $jenis = JeniskantongdarahM::model()->findByPk($stok->jeniskantongdarah_id);
                            
                            if (!empty($jenis)) {
                                echo $jenis->nama_jenis;
                            }
                            
                            $komponen = KomponendarahM::model()->findByPk($stok->komponendarah_id);
                            
                            if (!empty($komponen)) {
                                echo "<br>".$komponen->namaKomponenLengkap;
                            }
                            
                            echo "<br>".$stok->golongan_darah." ".$stok->rhesus;
                            
                        }
                    ?>
                </td>
                <td><?php echo $item->no_kantongdarah; ?></td>
                <td><?php echo $item->isi_kantongdarah; ?></td>
                <td><?php echo $item->ttv_tdsystolic . " / " . $item->ttv_tddiastolic; ?></td>
                <td><?php echo $item->ttv_nadi; ?></td>
                <td><?php echo $item->ttv_respirasi; ?></td>
                <td><?php echo $item->ttv_suhutubuh; ?></td>
                <td><?php echo empty($item->petugasmonitoring) ? "-" : $item->petugasmonitoring->namaLengkap; ?></td>
                <td>
                    <?php echo $item->reaksi_transfusi; ?>
                    <?php
                    if (!empty($item->reaksidetail_transfusi)) {
                        echo "<br>" . $item->reaksidetail_transfusi;
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="panel_ket">
    Observasi dilakukan pada: <br>
    <ul>
    <?php foreach (LookupM::getItemsUrutan("jenismonitoring_transfusidarah") as $val => $data): ?>
        <li><?php echo $val; ?></li>
    <?php endforeach; ?>
    </li>
</div>