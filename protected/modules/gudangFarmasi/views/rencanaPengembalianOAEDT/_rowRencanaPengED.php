<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]supplier_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]storeeddetail_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]satuankecil_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]qty_renpenged',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]tglkadaluarsa_renpeng',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
	<td>
        <?php echo (!empty($modDetail->obatalkes_id) ? $modDetail->obatalkes_nama : "") ?>
    </td>
    <td>
        <?php echo (!empty($modDetail->supplier_id) ? $modDetail->supplier_nama : "") ?>
    </td>
    <td>
        <?php echo (!empty($modDetail->qty_renpenged) ? $modDetail->qty_renpenged : "") ?>
    </td>
    <td>
        <?php echo (!empty($modDetail->satuankecil_id) ? $modDetail->satuankecil_nama: "") ?>
    </td>
    <td>
        <?php echo (!empty($modDetail->tglkadaluarsa_renpeng) ? $format->formatDateTimeForUser($modDetail->tglkadaluarsa_renpeng) : "") ?>
    </td>
	<td>
        <a onclick="batalObatAlkesED(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan obat alkes ED"><i class="icon-form-silang"></i></a>
    </td>
</tr>