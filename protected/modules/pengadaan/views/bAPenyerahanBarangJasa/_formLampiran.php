<div class="row-fluid">
    <div class="col-sm-12">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Banyaknya</th>
                    <th>Uraian dan Spesifikasi </th>
                    <th style="text-align: right">Harga Satuan (Rp)</th>
                    <th style="text-align: right">Total Harga (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $jumlah = 0;
                $ppn = 0;
                if (!empty($modRincian)) {
                    foreach ($modRincian as $key => $value) {
                        $modDetail->barang_id = $value->barang_id;
                        $modDetail->jenis_barang = $value->jenis_barang;
                        $modDetail->nama_barang = $value->barang_nama;
                        $modDetail->jumlah_barang = $value->barang_jumlah;
                        $modDetail->harga_satuan = $value->barang_harga;
                        $modDetail->pajak_persen = $value->pajak_persen;
                        $modDetail->jumlah_pajak = $value->pajak_jumlah;
                        $modDetail->jumlah_harga = $value->barang_total;
                        $modDetail->satuan_barang = $value->barang_satuan;
                        echo "
                        <tr>
                            <td>".
                                ($key+1).
                                CHtml::activeHiddenField($modDetail, '['.$key.']barang_id', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modDetail, '['.$key.']jenis_barang', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modDetail, '['.$key.']nama_barang', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modDetail, '['.$key.']satuan_barang', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modDetail, '['.$key.']jumlah_barang', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modDetail, '['.$key.']harga_satuan', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modDetail, '['.$key.']pajak_persen', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modDetail, '['.$key.']jumlah_pajak', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modDetail, '['.$key.']jumlah_harga', array('class'=>'span3', 'readonly'=>true))
                            ."</td>
                            <td>" . $value->barang_jumlah . " " . $value->barang_satuan . "</td>
                            <td>" . $value->barang_nama . "</td>
                            <td style=\"text-align: right\">" . number_format((float)$value->barang_harga,2,",",".") . "</td>
                            <td style=\"text-align: right\">" . number_format((float)$value->barang_jumlah * $value->barang_harga,2,",",".") . "</td>
                        </tr>
                        ";
                        $jumlah += $value->barang_jumlah * $value->barang_harga;
                    }
                }
                $ppn = $modSurat->jumlah_pajak;
                ?>
            </tbody>
             <tfoot>
                <tr>
                    <th colspan="4" style="text-align: right"><b>Jumlah</b></th>
                    <th style="text-align: right">
                        <?=
                        number_format((float)$jumlah,2,",",".") .
                        CHtml::activeHiddenField($model, 'jumlah_harga', array('class' => 'span3 integer-decimal', 'readonly' => true, 'value' => $jumlah))
                        ?>
                    </th>
                </tr>
                <tr>
                    <th colspan="4" style="text-align: right"><b>PPN 10 %</b></th>
                    <th style="text-align: right">
                        <?=
                        number_format((float)$ppn,2,",",".") .
                        CHtml::activeHiddenField($model, 'jumlah_pajak', array('class' => 'span3 integer-decimal', 'readonly' => true, 'value' => $ppn))
                        ?>
                    </th>
                </tr>
                <tr>
                    <th colspan="4" style="text-align: right"><b>Jumlah + PPN</b></th>
                    <th style="text-align: right">
                        <?=
                        number_format((float)$jumlah + $ppn,2,",",".") .
                        CHtml::activeHiddenField($model, 'total_harga', array('class' => 'span3 integer-decimal', 'readonly' => true, 'value' => ($jumlah + $ppn)))
                        ?>
                    </th>
                </tr>
                <tr>
                    <th colspan="4" style="text-align: right">Dibulatkan</th>
                    <th style='text-align:right'><?php echo number_format((float)$modSurat->total_pembulatan,2,",","."). CHtml::activeHiddenField($model, 'total_dibulatkan', array('class' => 'span3', 'readonly' => true, 'value' => $modSurat->total_pembulatan)) ?></th>
                </tr>
                <?php 
                $suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];
                if($modSurat->istermin == true && !empty($model->terminke)){
                    $cekTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id'=>$suratperjanjiankerja_id, 'terminke'=>$model->terminke));
                }else{
                    $cekpemeriksaanpekerjaan = BapenyerahanbarangjasaT::model()->findAllByAttributes(array('suratperjanjiankerja_id'=>$suratperjanjiankerja_id));
                    $jumlahpemeriksaan = count($cekpemeriksaanpekerjaan)+1;

                    $cekTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id'=>$suratperjanjiankerja_id, 'urutan'=>$jumlahpemeriksaan));
                }
                if($modSurat->istermin == true && !empty($cekTermin)){
                ?>
                <tr>
                    <th colspan="4" style="text-align: right">Termin <?php echo $cekTermin->terminke; ?> (<?php echo $cekTermin->jumlah_persen ?>%)</th>
                    <th style='text-align:right'><?php echo number_format((float)$cekTermin->jumlah_harga,2,",","."); ?>
                    <?= CHtml::activeHiddenField($model, 'pajak_persen', array('class' => 'span3 integer-decimal', 'readonly' => true, 'value' => $cekTermin->jumlah_persen)).
                        CHtml::activeHiddenField($model, 'total_pembayaran', array('class' => 'span3 integer-decimal', 'readonly' => true, 'value' => $cekTermin->jumlah_harga));?>
                    </th>
                </tr>
                <?php }else{
                    echo CHtml::activeHiddenField($model, 'total_pembayaran', array('class' => 'span3 integer-decimal', 'readonly' => true, 'value' => $modSurat->total_pembulatan));
                } ?>
            </tfoot>
        </table>
    </div>
</div>