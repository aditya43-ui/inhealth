<?php

    $folder = ['F1', 'F2', 'F3', 'F5', 'F5', 'F5', 'F5', 'F6', 'F8', 'F8', 'COVER', 'F5', 'F5', 'F8'];
    $isi_folder = ['FORMULIR PERMINTAAN RAWAT INAP', 'KAJIAN AWAL MEDIS', 'RENCANA AWAL MEDIS', 'LAPORAN OPERASI', 'LAPORAN ANESTESI', 'PROTOKOL KEMOTERAPI', 'DOKUMEN MEDIK TRANSFUSI',
    'CPPT / CATATAN PERKEMBANGAN PASIEN', 'RINGKASAN PASIEN PULANG', 'LAPORAN KEMATIAN', 'LEMBAR CASEMIX', 'LAPORAN OPERASI', 'PROTOKOL KEMOTERAPI', 'RINGKASAN PASIEN PULANG'];

    $subfolder = [
        [['A' => [$model->f1_a, 'Diagnosa masuk, alasan / indikasi rawat', $model->ket_f1_a]]],
        
        [['A' => [$model->f2_a, 'Tanggal dan Jam', $model->ket_f2_a]], ['B' => [$model->f2_b, 'Tanda tangan DPJP', $model->ket_f2_b]]],
        [['A' => [$model->f3_a, 'Tanggal dan Tanda Tangan', $model->ket_f3_a]], ['B' => [$model->f3_b, 'Target Waktu', $model->ket_f3_b]]],
        [
            ['A' => [$model->f5_a_operasi, 'Nama DPJP Bedah, Operator, Asisten Operator, Instrumen', $model->ket_f5_a_operasi]], ['B' => [$model->f5_b_operasi, 'Nama DPJP Anestesi, Perawat anestesi, Tgl. Pembedahan', $model->ket_f5_b_operasi]],
            ['C' => [$model->f5_c_operasi, 'Jenis Operasi, Sifat Operasi, Jenis Anestesi', $model->ket_f5_c_operasi]], ['D' => [$model->f5_d_operasi, 'Mulai / selesai operasi, mulai / selesai pembiusan', $model->ket_f5_d_operasi]],
            ['E' => [$model->f5_e_operasi, 'Jenis pembedahan, operasi ke ...', $model->ket_f5_e_operasi]], ['F' => [$model->f5_f_operasi, 'Tanda tangan DPJP, Operator', $model->ket_f5_f_operasi]],
            ['G' => [$model->f5_g_operasi, 'Diagnosa pra & pasca bedah', $model->ket_f5_g_operasi]], ['H' => [$model->f5_h_operasi, 'Nama tindakan operasi', $model->ket_f5_h_operasi]],
        ],
        [
            ['A' => [$model->f5_a_anastesi, 'TTD Ahli anestesi', $model->ket_f5_a_anastesi]], ['B' => [$model->f5_b_anestesi, 'Petugas anestesi', $model->ket_f5_b_anastesi]],
            ['C' => [$model->f5_c_anastesi, 'Petugas RR', $model->ket_f5_c_anastesi]],
        ],
        [
            ['A' => [$model->f5_a_kemoterapi, 'Seri kemo', $model->ket_f5_a_kemoterapi]], ['B' => [$model->f5_b_kemoterapi, 'Tanda tangan & Nama terang Dokter', $model->ket_f5_b_kemoterapi]],
        ],
        [
            ['A' => [$model->f5_a_transfusi, 'No. Seri darah', $model->ket_f5_a_transfusi]], ['B' => [$model->f5_b_transfusi, 'Jam mulai / selesai transfusi', $model->ket_f5_b_transfusi]],
            ['C' => [$model->f5_c_transfusi, 'Tanda tangan & Nama terang Dokter', $model->ket_f5_c_transfusi]],
        ],
        [
            ['A' => [$model->f6_a_cppt, 'Tanggal dan jam Pengkajian', $model->ket_f6_a_cppt]], ['B' => [$model->f6_b_cppt, 'Nama dokter / perawat yang melakukan pengkajian', $model->ket_f6_b_cppt]],
            ['C' => [$model->f6_c_cppt, 'Verifikasi DPJP', $model->ket_f6_c_cppt]], ['D' => [$model->f6_d_cppt, 'Kronologi Kematian', $model->ket_f6_d_cppt]],
        ],
        [
            ['A' => [$model->f8_a_ringkasan, 'Indikasi Dirawat', $model->ket_f8_a_ringkasan]], ['B' => [$model->f8_b_ringkasan, 'Dasar diagnosa / kriteria diagnosa', $model->ket_f8_b_ringkasan]],
            ['C' => [$model->f8_c_ringkasan, 'Tanda tanga DPJP dan pasien / Kel.Pasien', $model->ket_f8_c_ringkasan]],
        ],
        [
            ['A' => [$model->f8_a_kematian, 'Diagnosa sebab kematian', $model->ket_f8_a_kematian]], ['B' => [$model->f8_b_kematian, 'Tanda Tangan Dokter', $model->ket_f8_b_kematian]],
        ],
        [
            ['A' => [$model->casemix_a, 'Tanda Tangan DPJP', $model->ket_casemix_a]], ['B' => [$model->casemix_b, 'Tanda Tangan Dokter', $model->ket_casemix_b]],
        ],
        [
            ['I' => [$model->f5_i_operasi, 'Laporan Prosedur Lain', $model->ket_f5_i_operasi]],
        ],
        [
            ['C' => [$model->f5_c_kemoterapi, 'Tanggal kemoterapi sesuai pelayanan', $model->ket_f5_c_kemoterapi]],
        ],
        [
            ['D' => [$model->f8_d_ringkasan, 'Prosedur Operatif/Non Operatif', $model->ket_f8_d_ringkasan]], ['E' => [$model->f8_e_ringkasan, 'Pemberian obat-obatan', $model->ket_f8_e_ringkasan]],
        ],
    ];
?>


<table class="items table" style="width: 75%; margin: 20px;">
    <thead>
        <tr>
            <th style="width: 5%;">Folder </th>
            <th style="width: 40%;">Isi Dokumen Rekam Medis</th>
            <th style="width: 20%; text-align: center;">Checklist</th>
            <th style="text-align: center;">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($folder as $i => $fd):?>
        <tr>
            <td style="background-color: #93CAED; text-align: center; font-weight: bold;"><?= $fd ?></td>
            <td style="background-color: #93CAED;" colspan="3"><b><?= $isi_folder[$i] ?></b></td>
        </tr>

        <?php foreach($subfolder[$i] as $j => $sf):?>
        <?php foreach($sf as $h => $s):?>
        <tr>
            <?php // echo '<pre>'; var_dump($s[2], $j); die;?>

            <td style="text-align: center; font-weight: bold;"><?= $h ?></td>
            <td style="font-weight: bold;"><?= $s[1] ?></td>
            <td style="text-align: center;"><?= $s[0] ?></td>
            <td><?= $s[2] ?></td>
        </tr>
        <?php endforeach;?>
        <?php endforeach;?>

        <?php endforeach;?>
    </tbody>
</table>
<br><br>
<?php $pg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));?>
<table style="width: 30%; float: right; text-align: center; margin-right: 20px;" class="inner">
    <tr>
        <td>Petugas</td>
    </tr>
    <tr>
        <td><br><br><br></td>
    </tr>
    <tr>
        <td>( <?= $pg->namaLengkap ?> )</td>
    </tr>
</table>