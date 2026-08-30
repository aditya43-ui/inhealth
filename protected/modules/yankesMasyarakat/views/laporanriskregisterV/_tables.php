<?php
    $bor = '1';
    $color_border = '';
    if (isset($caraPrint)){
        $cssTabel = 'lapdpaunit table border';
        if ($caraPrint == 'EXCEL'){
            $bor = 1;
            $color_border = "bgcolor='#ebebeb'  ";
        }
    }else{
        $cssTabel = 'lapdpaunit table table-bordered';
    }
?>
<table class="<?= $cssTabel ?>" id="tableLaporan" border="<?php echo $bor; ?>" >
    <thead>
        <tr>
            <th rowspan="2" style="text-align: center; vertical-align: middle; background: #ffff99 !important" bgcolor="#ffff99"> No. </th>
            <th rowspan="2" style="text-align: left; vertical-align: middle; background: #ffff99 !important" bgcolor="#ffff99"> Sumber : <br>
                1. Laporan insiden <br>
                2. Komplain <br>
                3. Survey/ronde <br>
                4. Rapat/ brainstorming <br>
                5. Investigasi <br>
                6. Litigasi <br>
                7. External requirement </th>
            <th rowspan="2" style="text-align: center; vertical-align: middle; background: #ffff99 !important" bgcolor="#ffff99"> Deskripsi risiko / kejadian
                (Risiko potensial atau risiko aktual) </th>
            <th rowspan="2" style="text-align: center; vertical-align: middle; background: #ffff99 !important" bgcolor="#ffff99"> Dampak <br> Risiko </th>
            <th rowspan="2" style="text-align: center; vertical-align: middle; background: #ffff99 !important" bgcolor="#ffff99"> Unit <br> Kerja </th>
            <th rowspan="2" style="text-align: center; vertical-align: middle; background: #ffff99 !important" bgcolor="#ffff99"> Penyebab <br> (akar masalah) </th>
            <th rowspan="2" style="text-align: center; vertical-align: middle; background: #ffff99 !important" bgcolor="#ffff99"> Kategori Risiko <br> (sesuai akar masalah) </th>
            <th colspan="3" style="text-align: center; vertical-align: middle; background: #ffcc99 !important" bgcolor="#ffcc99"> Rating Analisis Resiko </th>
            <th rowspan="2" style="text-align: center; vertical-align: middle; background: #ffcc99 !important" bgcolor="#ffcc99"> <div style="transform: rotate(-90deg);transform-origin: left;padding-top: 65px;width: 30px;margin-bottom: -55px;height: 121px;margin-top: 50px;">Controlability </div> </th>
            <th rowspan="2" style="text-align: center; vertical-align: middle; background: #ffcc99 !important" bgcolor="#ffcc99"> <div style="transform: rotate(-90deg);transform-origin: left;padding-top: 65px;width: 30px;margin-bottom: -55px;height: 121px;margin-top: 50px;">Skor&nbsp;Risiko </div> </th>
            <th rowspan="2" style="text-align: center; vertical-align: middle; background: #ffcc99 !important" bgcolor="#ffcc99"> <div style="transform: rotate(-90deg);transform-origin: left;padding-top: 65px;width: 30px;margin-bottom: -55px;height: 121px;margin-top: 50px;">Deskripsi&nbsp;Rating</div> </th>
            <th rowspan="2" style="text-align: center; vertical-align: middle; background: #c6d9f1 !important" bgcolor="#c6d9f1"> Evaluasi Resiko </th>
            <th rowspan="2" style="text-align: center; vertical-align: middle; background: #c6d9f1 !important" bgcolor="#c6d9f1"> Risk Respon And Action Plan ( Apa Yang Kita Lakukan Untuk Mengurangi Risiko) </th>
            <th rowspan="2" style="text-align: center; vertical-align: middle; background: #c6d9f1 !important" bgcolor="#c6d9f1"> Due Date <br> Batas Waktu </th>
            <th rowspan="2" style="text-align: center; vertical-align: middle; background: #c6d9f1 !important" bgcolor="#c6d9f1"> PIC <br> (<i> risk owner</i>) </th>
            <th colspan="3" style="text-align: center; vertical-align: middle; background: #ff99ff !important" bgcolor="#ff99ff"> PROGRES / LAPORAN MONEV </th>
        </tr>
        <tr>
            <th style="text-align: center; vertical-align: middle; background: #ffcc99 !important" bgcolor="#ffff99"> <div style="transform: rotate(-90deg);transform-origin: left;padding-top: 65px;width: 30px;margin-bottom: -55px;height: 121px;margin-top: 50px;">Consequence&nbsp;(c)</div> </th>
            <th style="text-align: center; vertical-align: middle; background: #ffcc99 !important" bgcolor="#ffff99"> <div style="transform: rotate(-90deg);transform-origin: left;padding-top: 65px;width: 30px;margin-bottom: -55px;height: 121px;margin-top: 50px;">Likelihood&nbsp;(L)</div> </th>
            <th style="text-align: center; vertical-align: middle; background: #ffcc99 !important" bgcolor="#ffff99"> <div style="transform: rotate(-90deg);transform-origin: left;padding-top: 65px;width: 30px;margin-bottom: -55px;height: 121px;margin-top: 50px;">(C&nbsp;x&nbsp;L)</div> </th>
            <th style="text-align: center; vertical-align: middle; background: #ff99ff !important" bgcolor="#ff99ff"> <div style="transform: rotate(-90deg);transform-origin: left;padding-top: 65px;width: 30px;margin-bottom: -55px;height: 121px;margin-top: 50px;">Skor&nbsp;Risiko&nbsp;Sisa</div> </th>
            <th style="text-align: center; vertical-align: middle; background: #ff99ff !important" bgcolor="#ff99ff"> Laporan Singkat </th>
            <th style="text-align: center; vertical-align: middle; background: #ff99ff !important" bgcolor="#ff99ff"> Status </th>
        </tr >
        <tr >
            <th style="text-align: center; vertical-align: middle; background: #ffff99 !important" bgcolor="#ffff99"> 1 </th>
            <th style="text-align: center; vertical-align: middle; background: #ffff99 !important" bgcolor="#ffff99"> 2 </th>
            <th style="text-align: center; vertical-align: middle; background: #ffff99 !important" bgcolor="#ffff99"> 3 </th>
            <th style="text-align: center; vertical-align: middle; background: #ffff99 !important" bgcolor="#ffff99"> 4 </th>
            <th style="text-align: center; vertical-align: middle; background: #ffff99 !important" bgcolor="#ffff99"> 5 </th>
            <th style="text-align: center; vertical-align: middle; background: #ffff99 !important" bgcolor="#ffff99"> 6 </th>
            <th style="text-align: center; vertical-align: middle; background: #ffff99 !important" bgcolor="#ffff99"> 7 </th>
            <th style="text-align: center; vertical-align: middle; background: #ffcc99 !important" bgcolor="#ffff99"> 8 </th>
            <th style="text-align: center; vertical-align: middle; background: #ffcc99 !important" bgcolor="#ffff99"> 9 </th>
            <th style="text-align: center; vertical-align: middle; background: #ffcc99 !important" bgcolor="#ffff99"> 10 </th>
            <th style="text-align: center; vertical-align: middle; background: #ffcc99 !important" bgcolor="#ffff99"> 11 </th>
            <th style="text-align: center; vertical-align: middle; background: #ffcc99 !important" bgcolor="#ffff99"> 12 </th>
            <th style="text-align: center; vertical-align: middle; background: #ffcc99 !important" bgcolor="#ffff99"> 13 </th>
            <th style="text-align: center; vertical-align: middle; background: #c6d9f1 !important" bgcolor="#c6d9f1"> 14 </th>
            <th style="text-align: center; vertical-align: middle; background: #c6d9f1 !important" bgcolor="#c6d9f1"> 15 </th>
            <th style="text-align: center; vertical-align: middle; background: #c6d9f1 !important" bgcolor="#c6d9f1"> 16 </th>
            <th style="text-align: center; vertical-align: middle; background: #c6d9f1 !important" bgcolor="#c6d9f1"> 17 </th>
            <th style="text-align: center; vertical-align: middle; background: #ff99ff !important" bgcolor="#ff99ff"> 18 </th>
            <th style="text-align: center; vertical-align: middle; background: #ff99ff !important" bgcolor="#ff99ff"> 19</th>
            <th style="text-align: center; vertical-align: middle; background: #ff99ff !important" bgcolor="#ff99ff"> 20</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; foreach($tabel as $det){?>
        <tr>
            <td> <?= $i++;?> </td>
            <td> <?= $det['sumber_resiko'];?> </td>
            <td> <?= $det['deskripsiresiko'];?> </td>
            <td> <?= $det['dampakrisiko'];?> </td>
            <td> <?= $det['namaunitkerja'];?> </td>
            <td> <?= $det['penyebabresiko'];?> </td>
            <td> <?= $det['tiperesiko_nama'];?> </td>
            <td style="<?= $det['style_warna_konsekuensi'] ?>" <?= $det['style_warna_konsekuensi_excel'] ?>> <?= $det['konsekuensi_bobot'];?> </td>
            <td style="<?= $det['style_warna_konsekuensi'] ?>" <?= $det['style_warna_konsekuensi_excel'] ?>> <?= $det['peluang_bobotdescriptor'];?> </td>
            <td style="<?= $det['style_warna_konsekuensi'] ?>" <?= $det['style_warna_konsekuensi_excel'] ?>> <?= $det['detectability_bobot'];?> </td>
            <td style="<?= $det['style_warna_cl'] ?>" <?= $det['style_warna_cl_excel'] ?>> <?= $det['skor_cl'];?> </td>
            <td style="<?= $det['style_warna_rpn'] ?>" <?= $det['style_warna_rpn_excel'] ?>> <?= $det['rpn_score'];?> </td>
            <td style="<?= $det['style_warna_rpn'] ?>" <?= $det['style_warna_rpn_excel'] ?>> <?= $det['tingkatrisiko_nama'];?> </td>
            <td> <?= $det['evaluasi_risiko'];?> </td>
            <td> <?= $det['riskrespon'];?> </td>
            <td> <?= $det['tgl_tinjauan'];?> </td>
            <td> <?= $det['nama_pegawai'];?> </td>
            <td> <?= $det['rpn_sisa'];?> </td>
            <td> <?= $det['laporansingkat'];?> </td>
            <td> <?= $det['status_riskregister'];?> </td>
        </tr>
        <?php } ?>
    </tbody>
</table>