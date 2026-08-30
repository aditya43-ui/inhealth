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
        echo CHtml::hiddenField('PenggajianpegT['.$model->penggajianpeg_id.'][TJHT]', $row[$indexRow[strtolower('Iuran JHT 3.7%')]]);
        echo CHtml::hiddenField('PenggajianpegT['.$model->penggajianpeg_id.'][JKK]', $row[$indexRow[strtolower('Tunjangan JKK')]]);
        echo CHtml::hiddenField('PenggajianpegT['.$model->penggajianpeg_id.'][JKM]', $row[$indexRow[strtolower('Tunjangan JKM')]]);
        echo CHtml::hiddenField('PenggajianpegT['.$model->penggajianpeg_id.'][TBK]', $row[$indexRow[strtolower('Iuran JP 2%')]]);
        echo CHtml::hiddenField('PenggajianpegT['.$model->penggajianpeg_id.'][JHT]', $row[$indexRow[strtolower('Tunjangan BPJS Kes. 4%')]]);
        echo CHtml::hiddenField('PenggajianpegT['.$model->penggajianpeg_id.'][JP]', $row[$indexRow[strtolower('Iuran JHT 2% Karyawan')]]);
        echo CHtml::hiddenField('PenggajianpegT['.$model->penggajianpeg_id.'][TBKSHT]', $row[$indexRow[strtolower('Potongan JHT 3.7%')]]);
        echo CHtml::hiddenField('PenggajianpegT['.$model->penggajianpeg_id.'][TJP]', $row[$indexRow[strtolower('Potongan JKK')]]);
        echo CHtml::hiddenField('PenggajianpegT['.$model->penggajianpeg_id.'][PTJP]', $row[$indexRow[strtolower('Potongan JKM')]]);
        echo CHtml::hiddenField('PenggajianpegT['.$model->penggajianpeg_id.'][PTJHT]', $row[$indexRow[strtolower('Potongan JP 2%')]]);
        echo CHtml::hiddenField('PenggajianpegT['.$model->penggajianpeg_id.'][PTBK]', $row[$indexRow[strtolower('Iuran JP 1% Karyawan')]]);
        echo CHtml::hiddenField('PenggajianpegT['.$model->penggajianpeg_id.'][PJKK]', $row[$indexRow[strtolower('Potongan BPJS Kes. 4%')]]);
        echo CHtml::hiddenField('PenggajianpegT['.$model->penggajianpeg_id.'][PJKM]', $row[$indexRow[strtolower('Iuran BPJS Kes. 1% Karyawan')]]);
        echo CHtml::hiddenField('PenggajianpegT['.$model->penggajianpeg_id.'][totalpajak]', $row[$indexRow[strtolower('PPh 21 Seluruh Penghasilan')]]);
        echo CHtml::hiddenField('PenggajianpegT['.$model->penggajianpeg_id.'][totalpenerimaan]', $row[$indexRow[strtolower('Take Home Pay')]]);
        
        ?>
    </td>
    <td><?php echo $peg->namaLengkap; ?></td>
    <td><?php echo $tahun; ?></td>
    <td><?php echo date('n', strtotime($model->periodegaji)); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('Iuran JHT 3.7%')]],2,true); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('Tunjangan JKK')]],2,true); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('Tunjangan JKM')]],2,true); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('Iuran JP 2%')]],2,true); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('Tunjangan BPJS Kes. 4%')]],2,true); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('Iuran JHT 2% Karyawan')]],2,true); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('Potongan JHT 3.7%')]],2,true); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('Potongan JKK')]],2,true); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('Potongan JKM')]],2,true); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('Potongan JP 2%')]],2,true); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('Iuran JP 1% Karyawan')]],2,true); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('Potongan BPJS Kes. 4%')]],2,true); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('Iuran BPJS Kes. 1% Karyawan')]],2,true); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('PPh 21 Seluruh Penghasilan')]],2,true); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('Take Home Pay')]]); ?></td>
</tr>

										
