<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]linen_id',array('readonly'=>true,'class'=>'span1 cancel')); ?>
    </td>
    <td>
        <?php echo (!empty($modLinen->noregisterlinen) ? $modLinen->noregisterlinen : "") ?>
    </td>
    <td>
        <?php echo (!empty($modLinen->barang_id) ? $modLinen->namalinen : "") ?>
    </td>
    <td>
        <?php echo ((!empty($modLinen->barang_id) && !empty($modLinen->barang)) ? $modLinen->barang->barang_nama : "") ?>
    </td>
    <td>
		<?php echo CHtml::activeDropDownList($modDetail, '[ii]jenisperawatan', LookupM::getItems('jenisperawatan'), array('empty'=>'-- Pilih --', 'class'=>'span2')); ?>
	</td>
    <td>
		<?php echo CHtml::activeTextField($modDetail, '[ii]jumlah', array('class'=>'span1 integer', 'style'=>'text-align: right;')); ?>
	</td>
    <td>
		<?php echo CHtml::activeTextField($modDetail, '[ii]keterangan_pengperawatan', array('class'=>'span3')); ?>
	</td>
    <td>
        <a onclick="batalLinen(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan linen"><i class="icon-form-silang"></i></a>
    </td>
</tr>
