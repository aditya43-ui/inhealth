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
                if(count($modSPKRincian)){
                    
                    foreach ($modSPKRincian as $key => $value) {
                        
                        $modelDetail->barang_id = $value->barang_id;
                        $modelDetail->jenis_barang = $value->jenis_barang;
                        $modelDetail->nama_barang = $value->barang_nama;
                        $modelDetail->volume_barang = $value->barang_jumlah;
                        $modelDetail->harga_satuan = $value->barang_harga;
                        $modelDetail->pajak_persen = $value->pajak_persen;
                        $modelDetail->pajak_jumlah = $value->pajak_jumlah;
                        $modelDetail->harga_total = $value->barang_total;
                                
                        echo "
                        <tr>
                            <td>".
                                ($key+1).
                                CHtml::activeHiddenField($modelDetail, '['.$key.']barang_id', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modelDetail, '['.$key.']jenis_barang', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modelDetail, '['.$key.']nama_barang', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modelDetail, '['.$key.']volume_barang', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modelDetail, '['.$key.']harga_satuan', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modelDetail, '['.$key.']pajak_persen', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modelDetail, '['.$key.']pajak_jumlah', array('class'=>'span3', 'readonly'=>true)).
                                CHtml::activeHiddenField($modelDetail, '['.$key.']harga_total', array('class'=>'span3', 'readonly'=>true))
                            ."</td>
                            <td>".$value->barang_jumlah." ".$value->barang_satuan."</td>
                            <td>".$value->barang_nama."</td>
                            <td style=\"text-align: right\">".number_format((float)$value->barang_harga,2,",",".")."</td>
                            <td style=\"text-align: right\">".number_format((float)$value->barang_jumlah * $value->barang_harga,2,",",".")."</td>
                        </tr>
                        ";
                        
                        $jumlah += ($value->barang_jumlah * $value->barang_harga);
                    }
                }
                
                $ppn = ($jumlah * 10)/100;
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right"><b>Jumlah</b></td>
                    <td style="text-align: right">
                    <?= 
                        number_format((float)$jumlah,2,",",".").
                        CHtml::activeHiddenField($model, 'jumlah_harga', array('class'=>'span3 integer-decimal', 'readonly'=>true, 'value'=>number_format((float)$jumlah,2,",",".")))
                    ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right"><b>PPN 10 %</b></td>
                    <td style="text-align: right">
                    <?= 
                        number_format((float)$modSPK->jumlah_pajak,2,",",".").
                        CHtml::activeHiddenField($modSPK, 'jumlah_pajak', array('value'=>$modSPK->jumlah_pajak,'class'=>'span3 integer-decimal', 'readonly'=>true))
                    ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right"><b>Jumlah + PPN</b></td>
                    <td style="text-align: right">
                    <?= 
                        number_format((float)$jumlah + $modSPK->jumlah_pajak,2,",",".").
                        CHtml::activeHiddenField($model, 'total_harga', array('class'=>'span3 integer-decimal', 'readonly'=>true, 'value'=>number_format((float)($jumlah + $modSPK->jumlah_pajak),2,",",".")))
                    ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>