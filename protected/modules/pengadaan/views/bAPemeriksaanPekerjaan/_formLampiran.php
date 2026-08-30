<div class="row-fluid">
    <div class="col-sm-12">
        <table class="table table-striped table-bordered" id="tabel_lampiran">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Uraian Pekerjaan</th>
                    <th>Satuan</th>
                    <th>Volume</th>
                    <th>Harga Satuan (Rp)</th>
                    <th>Jumlah Harga (Rp)</th>
                    <th>Hasil Pemeriksaan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $jumlah = 0;
                $ppn = 0;
                if (count($modSPKRincian)) {

                    foreach ($modSPKRincian as $key => $value) {

                        $modelDetail = new ADBapemeriksaanpekerjaandetT;
                        if (!isset($value->bapemeriksaanpekerjaandet_id)) {
                            $modelDetail->barang_id = $value->barang_id;
                            $modelDetail->jenis_barang = $value->jenis_barang;
                            $modelDetail->satuan_barang = $value->barang_satuan;
                            $modelDetail->nama_barang = $value->barang_nama;
                            $modelDetail->jumlah_barang = $value->barang_jumlah;
                            $modelDetail->harga_satuan = $value->barang_harga;
                            $modelDetail->jumlah_harga = ($value->barang_jumlah * $value->barang_harga);
                            $modelDetail->jumlah_pajak = $value->pajak_jumlah;
                            $modelDetail->pajak_persen = $value->pajak_persen;
                        } else {
                            $modelDetail->attributes = $value->attributes;
                        }

                        echo "
                        <tr>
                            <td>" .
                        ($key + 1) .
                        CHtml::activeHiddenField($modelDetail, '[' . $key . ']barang_id', array('class' => 'span3', 'readonly' => true)) .
                        CHtml::activeHiddenField($modelDetail, '[' . $key . ']jenis_barang', array('class' => 'span3', 'readonly' => true)) .
                        CHtml::activeHiddenField($modelDetail, '[' . $key . ']satuan_barang', array('class' => 'span3', 'readonly' => true)) .
                        CHtml::activeHiddenField($modelDetail, '[' . $key . ']nama_barang', array('class' => 'span3', 'readonly' => true)) .
                        CHtml::activeHiddenField($modelDetail, '[' . $key . ']jumlah_barang', array('class' => 'span3 integer-decimal', 'readonly' => true)) .
                        CHtml::activeHiddenField($modelDetail, '[' . $key . ']harga_satuan', array('class' => 'span3 integer-decimal', 'readonly' => true)) .
                        CHtml::activeHiddenField($modelDetail, '[' . $key . ']jumlah_harga', array('class' => 'span3 integer-decimal', 'readonly' => true)) .
                        CHtml::activeHiddenField($modelDetail, '[' . $key . ']jumlah_pajak', array('class' => 'span3 integer-decimal', 'readonly' => true)) .
                        CHtml::activeHiddenField($modelDetail, '[' . $key . ']pajak_persen', array('class' => 'span3 float2', 'readonly' => true))
                        . "</td>
                            <td>" . $modelDetail->nama_barang . "</td>
                            <td>" . $modelDetail->satuan_barang . "</td>
                            <td>" . $modelDetail->jumlah_barang . "</td>
                            <td style='text-align:right'> Rp. " . number_format((float)$modelDetail->harga_satuan,2,",",".") . "</td>
                            <td style='text-align:right'> Rp. " . number_format((float)$modelDetail->jumlah_harga,2,",",".") . "</td>
                            <td style='text-align: center;'>" . CHtml::activeCheckBox($modelDetail, '[' . $key . ']hasil_pemeriksaan', array('rel' => 'tooltip', 'title' => 'Centang bila sesuai kontrak', 'class' => 'hasil_pemeriksaan', 'onclick' => 'cekHasil();')) . "</td>
                            <td style='text-align: center;'>" . CHtml::activeTextArea($modelDetail, '[' . $key . ']keterangan_pemeriksaan', array('class' => 'span2')) . "</td>
                        </tr>
                        ";
                        $jumlah += $modelDetail->jumlah_harga;
                    }
                }
                $ppn = $modSPK->jumlah_pajak;
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" style="text-align: right">Jumlah</th>
                    <th style='text-align:right'>Rp. <?php echo number_format((float)$jumlah,2,",",".") . CHtml::activeHiddenField($model, 'jumlah_harga', array('class' => 'span3 integer-decimal', 'readonly' => true, 'value' => $jumlah)); ?></th>
                    <th colspan="2" rowspan="5"></th>
                </tr>
                <tr>
                    <th colspan="5" style="text-align: right">PPN 10%</th>
                    <th style='text-align:right'>Rp. <?php echo number_format((float)$ppn,2,",",".") . CHtml::activeHiddenField($model, 'jumlah_pajak', array('class' => 'span3 integer-decimal', 'readonly' => true, 'value' => $ppn)); ?></th>
                </tr>
                <tr>
                    <th colspan="5" style="text-align: right">Total</th>
                    <th style='text-align:right'>Rp. <?php echo number_format((float)$jumlah + $ppn,2,",",".") . CHtml::activeHiddenField($model, 'total_harga', array('class' => 'span3 integer-decimal', 'readonly' => true, 'value' => ($jumlah + $ppn))) ?></th>
                </tr>
                <tr>
                    <th colspan="5" style="text-align: right">Dibulatkan</th>
                    <th style='text-align:right'>Rp. <?php echo number_format((float)$modSPK->total_pembulatan,2,",",".") . CHtml::activeHiddenField($model, 'total_dibulatkan', array('class' => 'span3 integer-decimal', 'readonly' => true, 'value' => $modSPK->total_pembulatan)) ?></th>
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
                    ?>
                    <tr>
                        <th colspan="5" style="text-align: right">Termin <?php echo $cekTermin->terminke; ?> (<?php echo $cekTermin->jumlah_persen ?>%)</th>
                        <th style='text-align:right'>Rp. <?php echo number_format($cekTermin->jumlah_harga,2,",","."); ?>
                            <?=
                            CHtml::activeHiddenField($model, 'pajak_persen', array('class' => 'span3 integer-decimal', 'readonly' => true, 'value' => $cekTermin->jumlah_persen)) .
                            CHtml::activeHiddenField($model, 'total_pembayaran', array('class' => 'span3 integer-decimal', 'readonly' => true, 'value' => $cekTermin->jumlah_harga));
                            ?>
                        </th>
                    </tr>
                    <?php
                } else {
                    echo CHtml::activeHiddenField($model, 'total_pembayaran', array('class' => 'span3 integer-decimal', 'readonly' => true, 'value' => $modSPK->total_pembulatan));
                }
                ?>
            </tfoot>
        </table>
        <?php echo $form->textFieldRow($model, 'bapemeriksaanpekerjaan_hasil', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
    </div>
</div>