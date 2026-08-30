<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]linen_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]barang_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo $modDetail->namaPeralatan; ?>
    </td>
    <td>
		<?php echo CHtml::activeTextField($modDetail, '[ii]pesanperlinensterildet_jml', array('class'=>'span3 integer')); ?>
	</td>
    <td>
		<?php echo CHtml::activeTextField($modDetail, '[ii]pesanperlinensterildet_ket', array('class'=>'span3')); ?>
	</td>
    <td>
        <a onclick="batalLinen(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan Peralatan Sterilisasi"><i class="icon-form-silang"></i></a>
    </td>
</tr>
