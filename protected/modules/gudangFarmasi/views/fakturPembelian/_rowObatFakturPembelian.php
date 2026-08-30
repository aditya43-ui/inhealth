<?php $modFakturDetail->tglkadaluarsa = MyFormatter::formatDateTimeForUser($modFakturDetail->tglkadaluarsa); ?>
<tr>
    <td>
        <?php echo CHtml::activeCheckBox($modFakturDetail,'[ii]checklist',array('class'=>'inputFormTabel lebar2')); ?>
        <?php echo CHtml::activeHiddenField($modFakturDetail,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>        
        <?php echo CHtml::activeHiddenField($modFakturDetail,'[ii]sumberdana_id',array('readonly'=>true,'class'=>'span1')); ?>        
        <?php echo CHtml::activeHiddenField($modFakturDetail,'[ii]persenppn',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activeHiddenField($modFakturDetail,'[ii]persenpph',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo CHtml::activeHiddenField($modFakturDetail,'[ii]tglkadaluarsa',array('readonly'=>true,'class'=>'span2')); ?>                
        <?php echo CHtml::activeHiddenField($modFakturDetail,'[ii]penerimaandetail_id',array('readonly'=>true,'class'=>'span2')); ?>                
        <?php echo CHtml::activeHiddenField($modFakturDetail,'[ii]kemasanbesar',array('readonly'=>true,'class'=>'span2')); ?>                
        <?php echo CHtml::activeHiddenField($modFakturDetail,'[ii]satuanbesar_id',array('readonly'=>true,'class'=>'span2')); ?>                
        <?php echo CHtml::activeHiddenField($modFakturDetail,'[ii]satuankecil_id',array('readonly'=>true,'class'=>'span2')); ?>                
    </td>
    <td>
        <span name="[ii][sumberdana_nama]"><?php echo (!empty($modFakturDetail->sumberdana_id) ? $modFakturDetail->sumberdana->sumberdana_nama : "") ?></span>
    </td>
    <td>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modFakturDetail->obatalkes_id) ? $modFakturDetail->obatalkes->obatalkes_kategori ."<br/>".$modFakturDetail->obatalkes->obatalkes_nama : "") ?></span>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'[ii]jmlpermintaan',array('readonly'=>false,'class'=>'span2 integer2','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        
        <?php echo CHtml::activeTextField($modFakturDetail,'[ii]jmlterima',array('readonly'=>false,'class'=>'span2 integer2','style'=>'width:90px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'[ii]persendiscount',array('readonly'=>false,'class'=>'span2 integer2 persendisc','onblur'=>'setJmlDiscountNol(this); hitungTotal();','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'[ii]jmldiscount',array('readonly'=>false,'class'=>'span2 integer2 jmldisc','onblur'=>'setPersenDiscountNol(this); hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'[ii]harganettoper',array('readonly'=>false,'class'=>'span2 integer2','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'[ii]persenppn',array('readonly'=>false,'class'=>'span2 integer2','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'[ii]persenpph',array('readonly'=>false,'class'=>'span2 integer2','onblur'=>'hitungTotal();','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>    
    <td>
        <?php echo CHtml::activeTextField($modFakturDetail,'[ii]subtotal',array('readonly'=>true,'class'=>'span2 integer2','style'=>'width:90px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
</tr>