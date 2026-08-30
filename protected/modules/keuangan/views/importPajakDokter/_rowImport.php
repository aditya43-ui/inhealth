<?php
 $peg = PegawaiM::model()->findByPk($model->pegawai_id);
?>

<tr>
    <td>
        <?php echo $no; ?>
    </td>
    <td>
        
        <?php echo $peg->nomorindukpegawai; 
        echo CHtml::hiddenField('PembayaranjasaT['.$model->pembayaranjasa_id.'][totalbayarjasa]', $row[$indexRow[strtolower('Bruto')]]);
        echo CHtml::hiddenField('PembayaranjasaT['.$model->pembayaranjasa_id.'][total_pajak]', $row[$indexRow[strtolower('PPh 21')]]);
        ?>
    </td>
    <td><?php echo $peg->namaLengkap; ?></td>
    <td><?php echo $tahun; ?></td>
    <td><?php echo date('n', strtotime($model->periodejasa)); ?></td>
    <td><?php echo $peg->npwp; ?></td>
    <td><?php echo (!empty($model->kode_objekpajak)? $model->kode_objekpajak : ""); ?></td>
    
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('Bruto')]],2,true); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('PPh 21')]],2,true); ?></td>
</tr>

										
