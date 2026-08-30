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
                if (!empty($modDetail)) {
                    foreach ($modDetail as $key => $value) { ?>
                        <tr>
                            <td style="text-align: center"> 
                                <?php echo ($key + 1).".";  ?> 
                                <?php echo CHtml::activeHiddenField($modBADetail, '['.$key.']barang_id', array('value' => $value->barang_id, 'class' => 'span1', 'readonly' => true)); ?>
                                <?php echo CHtml::activeHiddenField($modBADetail, '['.$key.']jenis_barang', array('value' => $value->jenis_barang, 'class' => 'span1', 'readonly' => true)); ?>
                                <?php echo CHtml::activeHiddenField($modBADetail, '['.$key.']nama_barang', array('value' => $value->barang_nama, 'class' => 'span1', 'readonly' => true)); ?>
                                <?php echo CHtml::activeHiddenField($modBADetail, '['.$key.']satuan_barang', array('value' => $value->barang_satuan, 'class' => 'span1', 'readonly' => true)); ?>
                                <?php echo CHtml::activeHiddenField($modBADetail, '['.$key.']jumlah_barang', array('value' => $value->barang_jumlah, 'class' => 'span1', 'readonly' => true)); ?>
                                <?php echo CHtml::activeHiddenField($modBADetail, '['.$key.']harga_satuan', array('value' => $value->barang_harga, 'class' => 'span1', 'readonly' => true)); ?>
                                <?php echo CHtml::activeHiddenField($modBADetail, '['.$key.']jumlah_pajak', array('value' => $value->pajak_jumlah, 'class' => 'span1', 'readonly' => true)); ?>
                                <?php echo CHtml::activeHiddenField($modBADetail, '['.$key.']jumlah_harga', array('value' => $value->barang_total, 'class' => 'span1', 'readonly' => true)); ?>
                                <?php echo CHtml::activeHiddenField($modBADetail, '['.$key.']pajak_persen', array('value' => $value->pajak_persen, 'class' => 'span1', 'readonly' => true)); ?>

                            </td>
                            <td> <?php echo $value->barang_jumlah . " " . $value->barang_satuan  ?></td>
                            <td> <?php echo $value->barang_nama ?> </td>
                            <td style="text-align: right"><?php echo number_format((float)$value->barang_harga, 2,",",".") ?></td>
                            <td style="text-align: right"><?php echo number_format((float)$value->barang_jumlah * $value->barang_harga, 2,",",".") ?></td>
                        </tr>
                        
                    <?php 
                        $jumlah += $value->barang_total;
                    }
                }

                $jumlah = $modSurat->jumlah_harga;
                $ppn = $modSurat->jumlah_pajak;
                ?>
            </tbody>
             <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right"><b>Jumlah</b></td>
                    <td style="text-align: right">
                        <?=
                        number_format((float)$jumlah, 2,",",".") .
                        CHtml::activeHiddenField($model, 'jumlah_harga', array('class' => 'span3 integer-decimal', 'readonly' => true, 'value' => $jumlah))
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right"><b>PPN 10 %</b></td>
                    <td style="text-align: right">
                        <?=
                        number_format((float)$ppn, 2,",",".") .
                        CHtml::activeHiddenField($model, 'jumlah_pajak', array('class' => 'span3 integer-decimal', 'readonly' => true, 'value' => $ppn))
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right"><b>Jumlah + PPN</b></td>
                    <td style="text-align: right">
                        <?=
                        number_format((float)$jumlah + $ppn, 2,",",".") .
                        CHtml::activeHiddenField($model, 'total_harga', array('class' => 'span3 integer-decimal', 'readonly' => true, 'value' => ($jumlah + $ppn)))
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right"><b>Dibulatkan</b></td>
                    <td style="text-align: right">
                        <?=
                        number_format((float)$modSurat->total_pembulatan, 2,",",".") 
                        ?>
                    </td>
                </tr>
                <?php
                if (!empty($model->termin_terminjumlah)) {
                    $modTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'], 'urutan' => $model->termin_terminjumlah));
                    if (!empty($modTermin) && $modTermin->jumlah_persen != 100) {
                ?>
                <?php 
                $modSurat= SuratperjanjiankerjaT::model()->findByPk($_GET['suratperjanjiankerja_id']);
                if($modSurat->istermin){ ?>
                <tr>
                    <td colspan="4" style="text-align: right"><b><?php echo "Termin ".$modTermin->terminke." (".$modTermin->jumlah_persen."%)"?></b></td>
                    <td style="text-align: right">
                        <?=
                        number_format((float)$modTermin->jumlah_harga, 2,",","."); 
                        ?>
                    </td>
                </tr>
                
                <?php }}} ?>
            </tfoot>
        </table>
    </div>
</div>