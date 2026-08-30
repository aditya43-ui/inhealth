<tr>
    <td>
        <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 desimal', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeCheckBox($modDetail,'[ii]checklist', array('class'=>'checklist',"onclick"=>"setNol(this);")); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]pembayaranpelayanan_id',array('readonly'=>true)); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]obatalkespasien_id',array('readonly'=>true)); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]pajak_id',array('readonly'=>true)); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]bayarke',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
      <td>
        <?php echo $index; ?>
    </td>
    <td><span><?php echo MyFormatter::formatDateTimeForUser($modDetail->tglpembayaran)."<br>".$modDetail->nopembayaran; ?></span></td>
    <td><span><?php echo MyFormatter::formatDateTimeForUser($modDetail->tgl_pendaftaran)."<br>".$modDetail->no_pendaftaran; ?></span></td>
    <td><span><?php echo $modDetail->no_rekam_medik; ?></span></td>
    <td><span><?php echo $modDetail->nama_pasien; ?></span></td>
    <td><span><?php echo $modDetail->instalasi_nama; ?></span></td>
    <td><span><?php echo $modDetail->ruangan_nama; ?></span></td>
    <!--<td style="text-align: center"><?php //echo $modDetail->bayarke; ?></td>-->
    <td><span><?php echo $modDetail->pajak_nama; ?></span></td>
    <td><span style="text-align: right">Rp <?php echo MyFormatter::formatNumberForPrint($modDetail->jumlahppn,2); ?></span></td>
    <td style="text-align: right">
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]jumlahppn',array('onkeypress'=>"return $(this).focusNextInputField(event);",'class'=>'')); ?>
        <?php echo CHtml::activeTextField($modDetail,'[ii]jmldibayarkan',array('class'=>'span2 integer-decimal','onblur'=>'hitungsisa(this)','onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
    </td>
    <td style="text-align: right">
            <?php echo CHtml::activeTextField($modDetail,'[ii]sisahutang',array('readonly'=>true,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
     <?php echo CHtml::activeTextArea($modDetail,'[ii]keterangan',array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
    </td>
</tr>
