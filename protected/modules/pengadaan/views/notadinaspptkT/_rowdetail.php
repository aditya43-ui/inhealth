<thead>
    <tr>
        <th>No.</th>
        <th>Tanggal</th>
        <th>Uraian</th>
        <th>Jumlah</th>
        <th>PPh 22</th>
        <th>Jumlah Diterima</th>
        <th>Keterangan</th>
    </tr>
</thead>
<?php 
$i = 1;
$total = 0;
$total_pph22 = 0;
$total_diterima = 0; 
?>
<tbody>
    <?php foreach ($modDetail as $modDet) { ?>
    <tr>
        <td><?php 
                echo $i; 
                echo CHtml::activeHiddenField($modDet, '[' . $i . ']barang_id',array('readonly'=>true,'class'=>'barang_id', 'value'=>$modDet->barang_id)); 
                echo CHtml::activeHiddenField($modDet, '[' . $i . ']notadinaspptkdet_jenisbarang',array('readonly'=>true,'class'=>'barang_id', 'value'=>$modDet->notadinaspptkdet_jenisbarang)); 
            ?>
        </td>
        <td>
            <?php 
            $modDet->notadinaspptkdet_tanggal = !empty($modDet->notadinaspptkdet_tanggal) ? date('d M Y', strtotime($modDet->notadinaspptkdet_tanggal)) : null;
                echo $this->widget('MyDateTimePicker', array(
                        'model'=>$modDet, 
                        'attribute'=>'[' . $i . ']notadinaspptkdet_tanggal',                                
                        'mode' => 'date',                                 
                        'htmlOptions' => array(
                            'size' => '10',
                            'style'=>'width:200px',
                            'class'=>'notadinaspptkdet_tanggal'
                        ),
                        'options' => array(  // (#3)                    
                            'dateFormat' => Params::DATE_FORMAT,   
                        ),     
                    ), 
                    true);
            ?>
        </td>
        <td><?php echo CHtml::activeHiddenField($modDet, '[' . $i . ']notadinaspptkdet_uraian',array('readonly'=>true,'class'=>'span3 notadinaspptkdet_uraian', 'value'=>$modDet->notadinaspptkdet_uraian)); echo $modDet->notadinaspptkdet_uraian; ?></td>
        <td style="text-align: right"><?php echo CHtml::activeHiddenField($modDet, '[' . $i . ']jumlah_harga',array('readonly'=>true,'class'=>'span2 jumlah_harga integer-decimal', 'value'=>number_format($modDet->jumlah_harga,2, ",", "."))); echo "Rp. " . number_format($modDet->jumlah_harga,2, ",", "."); ?></td>
        <td style="text-align: right"><?php echo CHtml::activeHiddenField($modDet, '[' . $i . ']jumlah_pph22',array('readonly'=>true,'class'=>'span2 jumlah_pph22 integer-decimal', 'value'=>number_format($modDet->jumlah_harga * (1.5 / 100),2, ",", ".") )); echo "Rp. " . number_format(($modDet->jumlah_harga * (1.5 / 100)),2, ",", "."); ?></td>
        <td style="text-align: right"><?php echo CHtml::activeHiddenField($modDet, '[' . $i . ']jumlah_diterima',array('readonly'=>true,'class'=>'span2 jumlah_diterima integer-decimal', 'value'=>number_format($modDet->jumlah_harga - ($modDet->jumlah_harga * (1.5 / 100)),2, ",", "."))); echo "Rp. " . number_format(($modDet->jumlah_harga - ($modDet->jumlah_harga * (1.5 / 100))),2, ",", "."); ?></td>
        <td><?php echo CHtml::activeTextArea($modDet, '[' . $i . ']notadinaspptkdet_ket',array('class'=>'span3 notadinaspptkdet_ket', 'rows'=>3)); ?></td>
    </tr>
    <?php            
        $i++;
        $total += $modDet->jumlah_harga;
        $total_pph22 += ($modDet->jumlah_harga * (1.5 / 100));
        $total_diterima += ($modDet->jumlah_harga - ($modDet->jumlah_harga * (1.5 / 100)));
    }
    ?>
</tbody>
<tfoot>
    <tr>
        <th colspan='3' style='text-align: center; font-weight: bold'>Jumlah</th>
        <th style="text-align: right"><?php echo CHtml::activeHiddenField($model, 'jumlah_harga',array('readonly'=>true,'class'=>'span2 jumlah_harga integer-decimal', 'value'=>number_format($total,2, ",", "."))); echo "Rp. " . number_format($total, 2, ",", "."); ?></th>
        <th style="text-align: right"><?php echo CHtml::activeHiddenField($model, 'jumlah_pph22',array('readonly'=>true,'class'=>'span2 jumlah_pph22 integer-decimal', 'value'=>number_format($total_pph22,2, ",", "."))); echo "Rp. " . number_format($total_pph22, 2, ",", "."); ?></th>
        <th style="text-align: right"><?php echo CHtml::activeHiddenField($model, 'jumlah_diterima',array('readonly'=>true,'class'=>'span2 jumlah_diterima integer-decimal', 'value'=>number_format($total_diterima,2, ",", "."))); echo "Rp. " . number_format($total_diterima, 2, ",", "."); ?></th>
        <th></th>
    </tr>
</tfoot>