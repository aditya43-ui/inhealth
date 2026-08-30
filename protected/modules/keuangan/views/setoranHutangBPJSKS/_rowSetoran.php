<tr>
    <td>
        <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 desimal', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeCheckBox($modDetail,'[ii]checklist', array('class'=>'checklist',"onclick"=>"setNol(this);")); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]periodegaji',array('readonly'=>true,'class'=>'span1')); ?> 
    </td>
      <td>
        <?php echo $index; ?>
    </td>
    <td><span><?php echo (!empty($modDetail->periodegaji) ? date('M Y', strtotime(MyFormatter::formatDateTimeForDb($modDetail->periodegaji))) : "") ?></span></td>
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