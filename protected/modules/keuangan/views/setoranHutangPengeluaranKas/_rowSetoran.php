<tr>
    <td>
        <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 desimal', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeCheckBox($modDetail,'[ii]checklist', array('class'=>'checklist',"onclick"=>"setNol(this);")); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]pengeluaranumum_id',array('readonly'=>true,'class'=>'span1')); ?> 
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]pajak_id',array('readonly'=>true,'class'=>'span1')); ?> 
    </td>
      <td>
        <?php echo $index; ?>
    </td>
    <td><span><?php echo (!empty($modDetail->tglpengeluaran) ? MyFormatter::formatDateTimeForUser($modDetail->tglpengeluaran) : "") ?></span></td>
    <td><span><?php echo (!empty($modDetail->nopengeluaran) ? $modDetail->nopengeluaran : "") ?></span></td>
    <td><span><?php echo (!empty($modDetail->jenispengeluaran_nama) ? $modDetail->jenispengeluaran_nama : "") ?></span></td>
    <td><span><?php echo (!empty($modDetail->pajak_nama) ? $modDetail->pajak_nama : "") ?></span></td>
    <td><span style="text-align: right">Rp <?php echo (!empty($modDetail->totalpajak) ? number_format($modDetail->totalpajak,2,",",".") : 0) ?></span></td>
    <td style="text-align: right">
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]totalpajak',array('onkeypress'=>"return $(this).focusNextInputField(event);",'class'=>'integer-float')); ?>
            <?php echo CHtml::activeTextField($modDetail,'[ii]jmlsetoran',array('class'=>'span2 integer-decimal','onblur'=>'hitungsisa(this)','onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
    </td>
    <td style="text-align: right">
            <?php echo CHtml::activeTextField($modDetail,'[ii]sisahutang',array('readonly'=>true,'class'=>'span2 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
     <?php echo CHtml::activeTextArea($modDetail,'[ii]keterangan',array('class'=>'span2','onkeyup'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
    </td>
</tr>