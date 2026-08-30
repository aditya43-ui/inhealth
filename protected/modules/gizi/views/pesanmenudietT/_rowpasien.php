<?php
// $jenismakanan = !empty($tampilData->jenismakanan_id) ? $tampilData->menudiet->jenismakanan_nama : '';
$jenismenudiet = !empty($tampilData->menudiet->menudiet_nama) ? $tampilData->menudiet->menudiet_nama : '';
$jenismenudietlain = !empty($tampilData->menudietlain->jenismenudiet) ? $tampilData->menudietlain->jenismenudiet->jenismenudiet_nama : '';
$jeniswaktu = !empty($tampilData->jeniswaktu_id) ? $tampilData->jeniswaktu->jeniswaktu_nama : '';
$alatmakan = !empty($tampilData->alatmakanan_id) ? $tampilData->alatmakanan->alatmakanan_nama : '';
$tipediet = !empty($tampilData->tipediet_id) ? $tampilData->tipediet->tipediet_nama : '';
?>
<tr>
    <td style="text-align: center"> <?php echo CHtml::checkBox("pilihcetak_" . $i, $check, array('class' => 'pilihcheck', 'value' => $tampilData->pesanmenudetail_id, 'onchange' => '')) ?></td>
    <td><?php echo $tampilData->pendaftaran->no_pendaftaran ?></td>   
    <td><?php echo $tampilData->pasien->no_rekam_medik ?></td>   
    <td><?php echo $tampilData->pasien->namadepan . $tampilData->pasien->nama_pasien ?></td>   
    <td><?php echo $tampilData->pendaftaran->umur ?></td>   
    <td><?php echo $tampilData->pasien->jeniskelamin ?></td>
    <td><?php echo $tipediet ?></td>
    <!-- <td><?php //echo $jenismakanan ?></td> -->
    <td><?php echo $jenismenudiet ?></td>
    <!-- <td><?php //echo $jenismenudietlain ?></td> -->
    <td><?php echo $jeniswaktu ?></td>
    <td><?php echo $alatmakan ?></td>
    <td style="text-align: center !important;" nowrap><?php echo $tampilData->jml_pesan_porsi ?></td>
</tr>
