<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]pengirimanlinen_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]linen_id',array('readonly'=>true,'class'=>'span1')); ?>
		<?php echo CHtml::activeHiddenField($modDetail,'[ii]penyimpananlinen_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
	<td>
        <span name="[ii][kodepenyimpan]"><?php echo $modDetail->kodepenyimpan; ?></span>
    </td>
    <td>
        <span name="[ii][kodelinen]"><?php echo (!empty($modDetail->kodelinen) ? $modDetail->kodelinen : "") ?></span>
    </td>
    <td>
        <span name="[ii][namalinen]"><?php echo (!empty($modDetail->namalinen) ? $modDetail->namalinen : "") ?></span>
    </td>
	<td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]keterangan_linen',array('readonly'=>false,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    
    <td>
        <a onclick="batalPengirimanLinen(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan pengiriman linen ini"><i class="icon-form-silang"></i></a>
    </td>
</tr>