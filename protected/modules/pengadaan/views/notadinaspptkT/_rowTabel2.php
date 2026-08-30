<thead>
    <tr>
        <th>No.</th>
        <th>Uraian</th>
        <th>Jumlah</th>
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
    <?php foreach ($modPersiapanPengadaan as $row) { ?>
    <tr>
        <td><?php 
                echo $i; 
                echo CHtml::activeHiddenField($modDet, '[' . $i . ']barang_id',array('readonly'=>true,'class'=>'barang_id', 'value'=>$row->barang_id)); 
                echo CHtml::activeHiddenField($modDet, '[' . $i . ']notadinaspptkdet_jenisbarang',array('readonly'=>true,'class'=>'barang_id', 'value'=>$row->jenis_barang)); 
            ?>
        </td>
        <td><?php echo CHtml::activeHiddenField($modDet, '[' . $i . ']notadinaspptkdet_uraian',array('readonly'=>true,'class'=>'span3 notadinaspptkdet_uraian', 'value'=>$row->persiapanpengadaandet_nama)); echo $row->persiapanpengadaandet_nama; ?></td>
        <td style="text-align: right">
            <?php echo CHtml::activeHiddenField($modDet, '[' . $i . ']jumlah_harga',array('readonly'=>true,'class'=>'span2 jumlah_harga integer-decimal', 'value'=>number_format($row->jumlah_harga, 2, ",", "."))); echo "Rp. " . number_format($row->jumlah_harga, 2, ",", "."); ?>
            <?php echo CHtml::activeHiddenField($modDet, '[' . $i . ']jumlah_diterima',array('readonly'=>true,'class'=>'span2 jumlah_diterima integer-decimal', 'value'=>number_format($row->jumlah_harga, 2, ",", "."))); ?></td>
        <td><?php echo CHtml::activeTextArea($modDet, '[' . $i . ']notadinaspptkdet_ket',array('class'=>'span3 notadinaspptkdet_ket', 'rows'=>3)); ?></td>
    </tr>
    <?php            
        $i++;
        $total += $row->jumlah_harga;
        $total_pph22 += ($row->jumlah_harga * (1.5 / 100));
        $total_diterima += ($row->jumlah_harga - ($row->jumlah_harga * (1.5 / 100)));
    }
    ?>
</tbody>
<tfoot>
    <tr>
        <th colspan='2' style='text-align: center; font-weight: bold'>Jumlah</th>
        <th style="text-align: right"><?php echo CHtml::activeHiddenField($model, 'jumlah_harga',array('readonly'=>true,'class'=>'span2 jumlah_harga integer-decimal', 'value'=>number_format($total, 2, ",", "."))); echo "Rp. " . number_format($total, 2, ",", "."); ?></th>
        <th style="text-align: right"><?php echo CHtml::activeHiddenField($model, 'jumlah_diterima',array('readonly'=>true,'class'=>'span2 jumlah_diterima integer-decimal', 'value'=>number_format($total, 2, ",", ".")));?></th>
    </tr>
</tfoot>