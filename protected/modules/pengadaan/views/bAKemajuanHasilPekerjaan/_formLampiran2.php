<div class="row-fluid">
    <div class="col-sm-12">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Banyaknya</th>
                    <th>Uraian Barang/Jasa Lainnya yang Diserahkan</th>
                    <th style="text-align: right">Harga Satuan (Rp)</th>
                    <th style="text-align: right">Total Harga (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $jumlah = 0;
                $ppn = 0;
                if (count($modelDetail)) {

                    foreach ($modelDetail as $key => $value) {
                        $value->harga_total = $value->volume_barang * $value->harga_satuan;
                        echo "
                        <tr>
                            <td>" . ($key + 1) .
                                CHtml::activeHiddenField($value, '[' . $key . ']bakemajuanhasilpekerjaandet_id', array('class' => 'span3', 'readonly' => true)) .
                                CHtml::activeHiddenField($value, '[' . $key . ']barang_id', array('class' => 'span3', 'readonly' => true)) .
                                CHtml::activeHiddenField($value, '[' . $key . ']jenis_barang', array('class' => 'span3', 'readonly' => true)) .
                                CHtml::activeHiddenField($value, '[' . $key . ']nama_barang', array('class' => 'span3', 'readonly' => true)) .
                                CHtml::activeHiddenField($value, '[' . $key . ']volume_barang', array('class' => 'span3', 'readonly' => true)) .
                                CHtml::activeHiddenField($value, '[' . $key . ']harga_satuan', array('class' => 'span3', 'readonly' => true)) .
                                CHtml::activeHiddenField($value, '[' . $key . ']pajak_persen', array('class' => 'span3', 'readonly' => true)) .
                                CHtml::activeHiddenField($value, '[' . $key . ']pajak_jumlah', array('class' => 'span3', 'readonly' => true)) .
                                CHtml::activeHiddenField($value, '[' . $key . ']harga_total', array('class' => 'span3', 'readonly' => true))
                            . "</td>
                            <td>" . $value->volume_barang . " " . $value->barang_satuan . "</td>
                            <td>" . $value->nama_barang ."</td>
                            <td style=\"text-align: right\">" . number_format((float)$value->harga_satuan,2,",",".") . "</td>
                            <td style=\"text-align: right\">" . number_format((float)$value->harga_total,2,",",".") . "</td>
                        </tr>
                        ";

                        $jumlah += $value->volume_barang * $value->harga_satuan;
                    }
                }

                $ppn = $modSPK->jumlah_pajak;
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right"><b>Jumlah Harga </b></td>
                    <td style="text-align: right">
                        <?=
                        number_format((float)$modSPK->jumlah_harga,2,",",".") .
                        CHtml::activeHiddenField($modSPK, 'jumlah_harga', array('class' => 'span3 integer-decimal', 'readonly' => true))
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right"><b>Jumlah Pajak</b></td>
                    <td style="text-align: right">
                        <?=
                        number_format((float)$modSPK->jumlah_pajak,2,",",".") .
                        CHtml::activeHiddenField($modSPK, 'jumlah_pajak', array('class' => 'span3 integer-decimal', 'readonly' => true))
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right"><b>Total Harga</b></td>
                    <td style="text-align: right">
                        <?=
                        number_format((float)$modSPK->jumlah_pajak + $modSPK->jumlah_harga,2,",",".") .
                        CHtml::activeHiddenField($modSPK, 'total_harga', array('class' => 'span3 integer-decimal', 'readonly' => true, 'value' => $modSPK->jumlah_pajak + $modSPK->jumlah_harga))
                        ?>
                    </td>
                </tr>
                <?php 
                
                $suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];
                if ($modSPK->istermin == true && !empty($model->terminke)) {
                    $cekTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'terminke' => $model->terminke));
                } else {
                    $cekpemeriksaanpekerjaan = ADBapemeriksaanpekerjaanT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id));
                    $jumlahpemeriksaan = count($cekpemeriksaanpekerjaan) + 1;

                    $cekTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $suratperjanjiankerja_id, 'urutan' => $jumlahpemeriksaan));
                }
                if ($modSPK->istermin == true && !empty($cekTermin)) {
                    $model->total_pembayaran = $cekTermin->jumlah_harga;
                    ?>
                    <tr>
                        <td colspan="4" style="text-align: right"><b>Total Pembulatan</b></td>
                        <td style="text-align: right">
                            <?=
                            number_format((float)$modSPK->total_pembulatan,2,",",".") .
                            CHtml::activeHiddenField($modSPK, 'total_pembulatan', array('class' => 'span3 integer-decimal', 'readonly' => true))
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: right"> <b> Termin <?php echo $cekTermin->terminke." (".$cekTermin->jumlah_persen." %)"; ?></b> </td>
                        <td style="text-align: right"> 
                            <?=
                                number_format((float)$cekTermin->jumlah_harga,2,",",".");
                            ?>
                            <?php echo CHtml::activeHiddenField($model, 'total_pembayaran', array('value' => $cekTermin->jumlah_harga, 'class' => 'span3 integer-decimal', 'readonly' => true)); ?>
                        </td>
                    </tr>
                <?php } ?>
            </tfoot>
        </table>
    </div>
</div>