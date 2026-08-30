<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>No.</th>
            <th>R Ke</th>
            <th>Nama Obat Alkes</th>
            <th>Sumber Dana</th>
            <th>Satuan Kecil</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Sub Total</th>
            <th>Status Bayar</th>
            <th>Pembatalan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $totQty = 0; $totHargaSatuan = 0; $toHarga = 0;
        foreach ($detailJuals as $i => $detail) { 
            $totQty = $totQty + $detail->qty_oa;
            $totHargaSatuan = $totHargaSatuan + $detail->hargasatuan_oa;
            $toHarga = $toHarga + $detail->hargajual_oa;
        ?>
        <tr>
            <td><?php echo ($i+1); ?></td>
            <td><?php echo $detail->rke; ?></td>
            <td><?php echo $detail->obatalkes_nama; ?></td>
            <td><?php echo $detail->sumberdana_nama; ?></td>
            <td><?php echo $detail->satuankecil_nama; ?></td>
            <td style="text-align: right;"><?php echo number_format($detail->qty_oa,1); ?></td>
            <td style="text-align: right;"><?php echo number_format($detail->hargasatuan_oa); ?></td>
            <td style="text-align: right;"><?php echo number_format($detail->hargajual_oa); ?></td>
            <td><?php echo (!empty($detail->oasudahbayar_id)) ? 'SUDAH BAYAR' : 'BELUM BAYAR' ;?></td>
            <td style="text-align: center;"><?php echo (!empty($detail->oasudahbayar_id)) ? '' : CHtml::link('<i class="icon-form-silang"></i>','javascript:void(0)',array('rel'=>'tooltip','data-original-title'=>'Klik untuk membatalkan',
                                                                                                                                                                      'onclick'=>'batalObat('.$detail->penjualanresep_id.','.$detail->reseptur_id.','.$detail->obatalkes_id.');return false;')) ; ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="text-align: right;"><b>Total</b></td>
            <td style="text-align: right;"><?php echo number_format($totQty); ?></td>
            <td style="text-align: right;"><?php echo number_format($totHargaSatuan); ?></td>
            <td style="text-align: right;"><?php echo number_format($toHarga); ?></td>
            <td colspan="2">&nbsp;</td>
        </tr>
    </tfoot>
</table>