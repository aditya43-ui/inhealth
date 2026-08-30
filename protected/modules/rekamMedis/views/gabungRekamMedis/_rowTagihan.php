<?php
$bukti = TandabuktibayarT::model()->findByAttributes(array(
    'pembayaranpelayanan_id' => $data->pembayaranpelayanan_id
));
?>
<tr>
    <td>
        <?php echo MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . "/<br/>" . $data->no_pendaftaran; ?>
    </td>
    <td>
        <?php echo MyFormatter::formatDateTimeForUser($data->tglpembayaran) . "/<br/>" . $data->nopembayaran; ?>
    </td>
    <td>
        <?php
        echo $data->ruanganakhir_nama;
        ?>
    </td>
    <td style="text-align: right;">
        <?php
        if (!empty($bukti)) {
            $total = $data->totalbiayapelayanan + $bukti->biayaadministrasi + $bukti->biayamaterai - $data->totaldiscount;
        } else {
            $total = $data->totalbiayapelayanan - $data->totaldiscount;
        }
        //if (empty($bukti)) return "Rp".number_format($data->totalbayartindakan,0,"",".");
        // if ($bukti->jmlpembayaran == 0) return "Rp".number_format($data->totalbayartindakan,0,"",".");
        echo number_format($total, 0, ",", ".");
        ?>
    </td>
</tr>