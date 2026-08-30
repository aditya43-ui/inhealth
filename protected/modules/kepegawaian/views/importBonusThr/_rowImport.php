<?php

                    $peg = PegawaiM::model()->findByPk($model->pegawai_id);
                    /*
                    $id[] = $model->penggajianpeg_id;
                    $totalTerima += $model->totalterima;
                    $totalBersih += $model->penerimaanbersih;
                     *
                     */
?>
<?php if($jenisgaji == 'THR'){ ?>
<tr>
    <td><?php echo $no; ?></td>
    <td>

        <?php echo $peg->nomorindukpegawai;
        echo CHtml::hiddenField('PengbonusthrdetailT['.$model->pengbonusthrdetail_id.'][pph21]', $row[$indexRow[strtolower('PPh 21 THR')]]);
        echo CHtml::hiddenField('PengbonusthrdetailT['.$model->pengbonusthrdetail_id.'][totaltarif]', $row[$indexRow[strtolower('THP THR')]]);
        echo CHtml::hiddenField('PengbonusthrdetailT['.$model->pengbonusthrdetail_id.'][tunjanganpph21]', $row[$indexRow[strtolower('Tunjangan PPh 21 THR')]]);
        ?>
    </td>
    <td><?php echo date('n', strtotime($model->periodebonusthr)); ?></td>
    <td><?php echo $tahun; ?></td>
    <td><?php echo $peg->namaLengkap; ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($model->totalthr,2,true); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('Tunjangan PPh 21 THR')]],2,true); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('PPh 21 THR')]],2,true); ?></td>
    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('THP THR')]],2,true); ?></td>
</tr>
<?php }else{ ?>
  <tr>
      <td><?php echo $no; ?></td>
      <td>

          <?php echo $peg->nomorindukpegawai;
          echo CHtml::hiddenField('PengbonusthrdetailT['.$model->pengbonusthrdetail_id.'][pph21]', $row[$indexRow[strtolower('PPh 21 Bonus')]]);
          echo CHtml::hiddenField('PengbonusthrdetailT['.$model->pengbonusthrdetail_id.'][totaltarif]', $row[$indexRow[strtolower('THP Bonus')]]);
          echo CHtml::hiddenField('PengbonusthrdetailT['.$model->pengbonusthrdetail_id.'][tunjanganpph21]', $row[$indexRow[strtolower('Tunjangan PPh 21 Bonus')]]);
          ?>
      </td>
      <td><?php echo date('n', strtotime($model->periodebonusthr)); ?></td>
      <td><?php echo $tahun; ?></td>
      <td><?php echo $peg->namaLengkap; ?></td>
      <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($model->nilaibonus,2,true); ?></td>
      <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('Tunjangan PPh 21 Bonus')]],2,true); ?></td>
      <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('PPh 21 Bonus')]],2,true); ?></td>
      <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($row[$indexRow[strtolower('THP Bonus')]],2,true); ?></td>
  </tr>
  <?php } ?>
