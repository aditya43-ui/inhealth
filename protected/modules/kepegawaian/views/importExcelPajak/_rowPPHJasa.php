<?php

                
                    $peg = PegawaiM::model()->findByPk($model->pegawai_id);
                    /*
                    $id[] = $model->penggajianpeg_id;
                    $totalTerima += $model->totalterima;
                    $totalBersih += $model->penerimaanbersih;
                     * 
                     */
?>

<tr>
    <td>
        
        <?php echo $peg->nomorindukpegawai; 
        
        echo CHtml::hiddenField('PembayaranjasaT['.$model->pembayaranjasa_id.'][total_pajak]', $row[$indexRow[strtolower('PPh')]]);
        
        ?>
    </td>
    <td><?php echo $peg->namaLengkap; ?></td>
    <td><?php echo $tahun; ?></td>
    <td><?php echo date('n', strtotime($model->periodejasa)); ?></td>
    <td><?php echo $peg->npwp; ?></td>
    <!--<td><?php // echo $row['D']; ?></td>-->
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('Take Home Pay')]]); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('PPh')]]); ?></td>
    <!--<td><?php // echo $peg->kode_negara; ?></td>-->
</tr>