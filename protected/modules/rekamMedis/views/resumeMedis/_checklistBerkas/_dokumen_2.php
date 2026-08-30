<?php

    $folder = ['F1', 'F2', 'F3', 'F5', 'F5', 'F5', 'F5', 'F6', 'F8', 'F8', 'COVER', 'F5', 'F5', 'F8'];
    $isi_folder = ['FORMULIR PERMINTAAN RAWAT INAP', 'KAJIAN AWAL MEDIS', 'RENCANA AWAL MEDIS', 'LAPORAN OPERASI', 'LAPORAN ANESTESI', 'PROTOKOL KEMOTERAPI', 'DOKUMEN MEDIK TRANSFUSI',
                    'CPPT / CATATAN PERKEMBANGAN PASIEN', 'RINGKASAN PASIEN PULANG', 'LAPORAN KEMATIAN', 'LEMBAR CASEMIX', 'LAPORAN OPERASI', 'PROTOKOL KEMOTERAPI', 'RINGKASAN PASIEN PULANG'];
    
    $subfolder = [
        [['A' => ['f1_a', 'Diagnosa masuk, alasan / indikasi rawat', 'ket_f1_a']]],
        
        [['A' => ['f2_a', 'Tanggal dan Jam', 'ket_f2_a']], ['B' => ['f2_b', 'Tanda tangan DPJP', 'ket_f2_b']]],
        [['A' => ['f3_a', 'Tanggal dan Tanda Tangan', 'ket_f3_a']], ['B' => ['f3_b', 'Target Waktu', 'ket_f3_b']]],
        [
            ['A' => ['f5_a_operasi', 'Nama DPJP Bedah, Operator, Asisten Operator, Instrumen', 'ket_f5_a_operasi']], ['B' => ['f5_b_operasi', 'Nama DPJP Anestesi, Perawat anestesi, Tgl. Pembedahan', 'ket_f5_b_operasi']],
            ['C' => ['f5_c_operasi', 'Jenis Operasi, Sifat Operasi, Jenis Anestesi', 'ket_f5_c_operasi']], ['D' => ['f5_d_operasi', 'Mulai / selesai operasi, mulai / selesai pembiusan', 'ket_f5_d_operasi']],
            ['E' => ['f5_e_operasi', 'Jenis pembedahan, operasi ke ...', 'ket_f5_e_operasi']], ['F' => ['f5_f_operasi', 'Tanda tangan DPJP, Operator', 'ket_f5_f_operasi']],
            ['G' => ['f5_g_operasi', 'Diagnosa pra & pasca bedah', 'ket_f5_g_operasi']], ['H' => ['f5_h_operasi', 'Nama tindakan operasi', 'ket_f5_h_operasi']],
        ],
        [
            ['A' => ['f5_a_anastesi', 'TTD Ahli anestesi', 'ket_f5_a_anastesi']], ['B' => ['f5_b_anastesi', 'Petugas anestesi', 'ket_f5_b_anastesi']],
            ['C' => ['f5_c_anastesi', 'Petugas RR', 'ket_f5_c_anastesi']],
        ],
        [
            ['A' => ['f5_a_kemoterapi', 'Seri kemo', 'ket_f5_a_kemoterapi']], ['B' => ['f5_b_kemoterapi', 'Tanda tangan & Nama terang Dokter', 'ket_f5_b_kemoterapi']],
        ],
        [
            ['A' => ['f5_a_transfusi', 'No. Seri darah', 'ket_f5_a_transfusi']], ['B' => ['f5_b_transfusi', 'Jam mulai / selesai transfusi', 'ket_f5_b_transfusi']],
            ['C' => ['f5_c_transfusi', 'Tanda tangan & Nama terang Dokter', 'ket_f5_c_transfusi']],
        ],
        [
            ['A' => ['f6_a_cppt', 'Tanggal dan jam Pengkajian', 'ket_f6_a_cppt']], ['B' => ['f6_b_cppt', 'Nama dokter / perawat yang melakukan pengkajian', 'ket_f6_b_cppt']],
            ['C' => ['f6_c_cppt', 'Verifikasi DPJP', 'ket_f6_c_cppt']], ['D' => ['f6_d_cppt', 'Kronologi Kematian', 'ket_f6_d_cppt']],
        ],
        [
            ['A' => ['f8_a_ringkasan', 'Indikasi Dirawat', 'ket_f8_a_ringkasan']], ['B' => ['f8_b_ringkasan', 'Dasar diagnosa / kriteria diagnosa', 'ket_f8_b_ringkasan']],
            ['C' => ['f8_c_ringkasan', 'Tanda tanga DPJP dan pasien / Kel.Pasien', 'ket_f8_c_ringkasan']],
        ],
        [
            ['A' => ['f8_a_kematian', 'Diagnosa sebab kematian', 'ket_f8_a_kematian']], ['B' => ['f8_b_kematian', 'Tanda Tangan Dokter', 'ket_f8_b_kematian']],
        ],
        [
            ['A' => ['casemix_a', 'Tanda Tangan DPJP', 'ket_casemix_a']], ['B' => ['casemix_b', 'Tanda Tangan Dokter', 'ket_casemix_b']],
        ],
        [
            ['I' => ['f5_i_operasi', 'Laporan Prosedur Lain', 'ket_f5_i_operasi']],
        ],
        [
            ['C' => ['f5_c_kemoterapi', 'Tanggal kemoterapi sesuai pelayanan', 'ket_f5_c_kemoterapi']],
        ],
        [
            ['D' => ['f8_d_ringkasan', 'Prosedur Operatif/Non Operatif', 'ket_f8_d_ringkasan']], ['E' => ['f8_e_ringkasan', 'Pemberian obat-obatan', 'ket_f8_e_ringkasan']],
        ],
    ];
?>


<div class="col-sm-12" style="margin-top: 20px;">
    <table class="items table table-striped table-bordered table-condensed" style="width: 100%;">
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
                <td style="text-align: center;"><?php echo $form->dropDownList($model, $s[0], LookupM::getItems('checklistberkas_rm'), array('empty'=>'-- Pilih --','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <td>
                <?php
                     echo $form->textField($model, $s[2], array('class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);")); 
                ?>
                </td>
            </tr>
            <?php endforeach;?>
            <?php endforeach;?>

            <?php endforeach;?>
        </tbody>
    </table>
</div>