<?php 
$oa = ObatalkesM::model()->findByPk($modDetail->obatalkes_id);
$jenis = JenisobatalkesM::model()->findByPk($oa->jenisobatalkes_id);

?>

<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]obatalkes_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]sumberdana_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]stok',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td hidden>
        <span name="[ii][sumberdana_nama]"><?php echo (!empty($modDetail->sumberdana_id) ? $modDetail->sumberdana->sumberdana_nama : "") ?></span>
    </td>
    <td>
        <span name="[ii][jenisobatalkes_id]"><?php echo (!empty($jenis) ? $jenis->jenisobatalkes_nama : "") ?></span>
    </td>    
    <td>
        <span name="[ii][obatalkes_nama]"><?php echo (!empty($modDetail->obatalkes_id) ? $modDetail->obatalkes->obatalkes_nama : "") ?></span>
    </td>
    <td>
        <span name="[ii][tglkadaluarsa]"><?php echo (!empty($modDetail->tglkadaluarsa)?MyFormatter::formatDateTimeForUser($modDetail->tglkadaluarsa):'-');//(!empty($oa->tglkadaluarsa) ? MyFormatter::formatDateTimeForUser($oa->tglkadaluarsa) : "") ?></span>
        <?php echo CHtml::activeHiddenField($modDetail,'[ii]tglkadaluarsa',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
     <td hidden>
        <?php echo CHtml::activeDropDownList($modDetail, '[ii]satuankecil_id', CHtml::listData(SatuankecilM::model()->findAll(),'satuankecil_id','satuankecil_nama'),array('style'=>'width:80px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDetail,'[ii]jmlpesan',array('readonly'=>true,'class'=>'span2 integer','style'=>'width:45px;','onkeyup'=>"return $(this).focusNextInputField(event);"))." ".$modDetail->satuankecil->satuankecil_nama; ?>
    </td>
    <td>
        <a onclick="batalPemesananDetail(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan mutasi obat alkes ini"><i class="icon-form-silang"></i></a>
    </td>
</tr>