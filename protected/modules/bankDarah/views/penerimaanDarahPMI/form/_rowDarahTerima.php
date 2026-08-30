<tr>
    <td class="nomor"><?php echo $cnt; ?></td>
    <td><?php echo $jenis->jeniskantongdarah_singkatan; ?></td>
    <td class="golongandarah_label"><?php echo $item->golongandarah; ?></td>
    <td class="rhesus_label"><?php echo CustomFunction::cekNamaRhesus($item->rhesus); ?></td>
    <td style="text-align: right;"  class="jumlah_permintaan_label"><?php echo $item->jumlah_permintaan; ?></td>
    <td style="text-align: right;"><?php echo $item->jumlah_terima; ?></td>
    <td><?php echo $item->keterangan_det; ?></td>
    <td style="text-align: center">
    </td>
</tr>
