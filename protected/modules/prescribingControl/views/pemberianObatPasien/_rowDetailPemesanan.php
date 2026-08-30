<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]sumberdana_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modDetail->obatalkes_id) ? $modDetail->obatalkes->obatalkes_nama : "") ?></span>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]jmlpesan',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:45px;','onblur'=>'hitungTotal();','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        
    </td>
    <td>
        <a onclick="batalPemesananDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan pemberian obat alkes ini"><i class="icon-form-silang"></i></a>
    </td>
</tr>