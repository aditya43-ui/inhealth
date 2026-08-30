<thead>
    <tr>
        <th style="text-align: center">No.</th>
        <th style="text-align: center">Uraian</th>
        <th style="text-align: center">Volume</th>
        <th style="text-align: center">Satuan</th>
        <th style="text-align: center">Pajak <br> (%) </th>
        <th style="text-align: center">Harga</th>
        <th style="text-align: center">Sebelum <br> Pajak</th>
        <th style="text-align: center">Jumlah</th>
        <th style="text-align: center">Pagu </th>
        <th style="text-align: center">Serapan</th>
        <th style="text-align: center">Sisa</th>
        <th style="text-align: center">Keterangan</th>
    </tr>
</thead>
<?php 
$i = 1;
$total = 0;
$total_pagu = 0;
$total_serapan = 0; 
$total_sisa = 0; 
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
        <td> <?= $modDet->notadinaspptkdet_uraian; ?></td>
        <td> <?= $modDet->barang_volume; ?></td>
        <td> <?= $modDet->barang_satuan; ?></td>
        <td style="text-align: right"> <?= number_format($modDet->pajak_persen, 2, ',', '.'); ?></td>
        <td style="text-align: right"> <?= number_format($modDet->harga_satuan, 2, ',', '.'); ?></td>
        <td style="text-align: right"> <?= number_format($modDet->jumlah_harga, 2, ',', '.'); ?></td>
        <td style="text-align: right"> <?= number_format($modDet->jumlah_diterima, 2, ',', '.'); ?></td>
        <td style="text-align: right"> <?= number_format($modDet->pagu, 2, ',', '.'); ?></td>
        <td style="text-align: right"> <?= number_format($modDet->serapan, 2, ',', '.'); ?></td>
        <td style="text-align: right"> <?= number_format($modDet->sisa, 2, ',', '.'); ?></td>
        <td><?php echo CHtml::activeTextArea($modDet, '[' . $i . ']notadinaspptkdet_ket',array('class'=>'span3 notadinaspptkdet_ket', 'rows'=>3,'readonly'=>true)); ?></td>
    </tr>
    <?php            
        $i++;
        $total += $modDet->jumlah_harga;
        $total_diterima += $modDet->jumlah_diterima;
        $total_pagu += $modDet->pagu;
        $total_serapan += $modDet->serapan;
        $total_sisa += $modDet->sisa;
    }
    ?>
</tbody>