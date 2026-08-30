<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]bahanperawatan_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <span name="[ii][bahanperawatan_nama]"><?php echo (!empty($modDetail->bahanperawatan_nama) ? $modDetail->bahanperawatan_nama : "") ?></span>
    </td>
	<td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]jmlpemakaian',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
	<td>
        <?php echo CHtml::activeDropDownList($modDetail, '[ii]satuanpemakaian', CHtml::listData(SatuankecilM::model()->findAll(),'satuankecil_nama','satuankecil_nama'),array('style'=>'width:80px;')); ?>
    </td>
    
    <td>
        <a onclick="batalBahanPerawatan(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan mutasi obat alkes ini"><i class="icon-form-silang"></i></a>
    </td>
</tr>