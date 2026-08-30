<div class="row-fluid">
    <div class="col-sm-12">
        <table class="table table-striped table-bordered tabelLampiran">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Item yang Diperiksa</th>
                    <th>Volume dan Spesifikasi</th>
                    <th>Hasil Pemeriksaan</th>
                    <th>Satuan </th>
                    <th>Volume</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah Harga </th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody  id="tabel_lampiran">
                <?php
                if (count($modelDetail) > 0) {

                    foreach ($modelDetail as $key => $value) {
                        $hasilPemeriksaan = isset($value->hasil_pemeriksaan)? "<i class=\"fa fa-check-square-o\"></i>" : "<i class=\"fa fa-square-o\"></i>";
                        echo "
                        <tr>
                            <td>".($key+1)."</td>
                            <td>".$value->nama_barang."</td>
                            <td>".$value->jumlah_barang." ".$value->satuan_barang."</td>
                            <td>".$hasilPemeriksaan."</td>
                            <td>".$value->satuan_barang."</td>
                            <td>".$value->jumlah_barang."</td>
                            <td style='text-align:right;'>".number_format((float)$value->harga_satuan,2,",",".")."</td>
                            <td style='text-align:right;'>".number_format((float)$value->jumlah_harga,2,",",".")."</td>
                            <td>".$value->keterangan_pemeriksaan."</td>
                        </tr>
                        ";
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" style="text-align: right"> <b> Jumlah </b></td>
                    <td style='font-weight: bold;text-align: right;'> Rp. <?php echo number_format((float)$modSPK->jumlah_harga,2,",",".")?></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="7" style="text-align: right"> <b> PPN 10% </b></td>
                    <td style='font-weight: bold;text-align: right;'> Rp. <?php echo number_format((float)$modSPK->jumlah_pajak,2,",",".")?></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="7" style="text-align: right"> <b> Total </b></td>
                    <?php 
                        $harga = ($modSPK->total_harga != 0) ? $modSPK->total_harga : $modSPK->jumlah_harga + $modSPK->jumlah_pajak;
                    ?>
                    <td style='font-weight: bold;text-align: right;'> Rp. <?php echo number_format((float)$harga,2,",",".")?></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="7" style="text-align: right"> <b> <!--Dibulatkan--> </b></td>
                    <td style='font-weight: bold;text-align: right;'> Rp. <?php echo number_format((float)$modSPK->total_pembulatan,2,",",".")?></td>
                    <td> </td>
                </tr>
                <?php if(!empty($_GET['bahasilpemeriksaanpekerjaan_id']) && $model->termin_persen != 100) {?>
                    <tr>
                        <td colspan="7" style="text-align: right; font-weight: bold"> Termin <?php echo $model->terminke." (".$model->termin_persen."%)" ?></td>
                        <td style="text-align: right;"> Rp. <?php echo number_format((float)$model->total_pembayaran,2,",",".") ?></td>
                        <td> </td>
                    </tr>
                <?php } ?>
            </tfoot>
        </table>
    </div>
</div>