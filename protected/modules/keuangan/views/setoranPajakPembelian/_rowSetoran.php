<tr>
    <td>
        <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 desimal', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeCheckBox($modDetail,'[ii]checklist', array('class'=>'checklist',"onclick"=>"setNol(this);")); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]faktur_id',array('readonly'=>true,'class'=>'span1')); ?> 
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]typefaktur',array('readonly'=>true,'class'=>'span1')); ?> 
    </td>
      <td>
        <?php echo $index; ?>
    </td>
    <td><span><?php echo (!empty($modDetail->nofaktur) ? $modDetail->nofaktur : "") ?></span></td>
    <td><span><?php echo (!empty($modDetail->tglfaktur) ? MyFormatter::formatDateTimeForUser($modDetail->tglfaktur) : "") ?></span></td>
    <td><span><?php echo (!empty($modDetail->pajak_nama) ? $modDetail->pajak_nama : "") ?></span></td>
    <td><span style="text-align: right">Rp <?php echo (!empty($modDetail->pajakpph) ? number_format($modDetail->pajakpph,2,",",".") : 0) ?></span></td>
    <td style="text-align: right">
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]pajakpph',array('onkeypress'=>"return $(this).focusNextInputField(event);",'class'=>'float')); ?>
            <?php echo CHtml::activeTextField($modDetail,'[ii]jmlsetoran',array('class'=>'span3 integer-decimal','onblur'=>'hitungsisa(this)','onkeypress'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
    </td>
    <td style="text-align: right">
            <?php echo CHtml::activeTextField($modDetail,'[ii]sisahutang',array('readonly'=>true,'class'=>'span3 integer-decimal','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
     <?php echo CHtml::activeTextArea($modDetail,'[ii]keterangan',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
    </td>
</tr>