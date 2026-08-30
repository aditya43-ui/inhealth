<tr>
    <td>
        <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer ceklis', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($penerimaan,'[ii]sterilisasi_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($penerimaan,'[ii]sterilisasidetail_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($penerimaan,'[ii]peralatansterilisasi_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($penerimaan,'[ii]waktukadaluarsa',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($penerimaan,'[ii]penyimpanansterildet_jml',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($penerimaan,'[ii]penyimpanansterildet_ket',array('readonly'=>true,'class'=>'span1')); ?>
		<?php echo CHtml::activeCheckBox($penerimaan,'[ii]checklist', array('class'=>'checklist','onclick'=>'setNol(this);')); ?>
    </td>
	<td>
        <?php echo CHtml::activeDropDownList($penerimaan, '[ii]lokasipenyimpanan_id', CHtml::listData(STLokasipenyimpananM::model()->findAll(),'lokasipenyimpanan_id','lokasipenyimpanan_nama'),array('style'=>'width:80px;')); ?>
    </td>
	<td>
        <?php echo CHtml::activeDropDownList($penerimaan, '[ii]rakpenyimpanan_id', CHtml::listData(STRakpenyimpananM::model()->findAll(),'rakpenyimpanan_id','rakpenyimpanan_nama'),array('style'=>'width:80px;')); ?>
    </td>
	<td>
        <span><?php echo (!empty($penerimaan->sterilisasi_no) ? $penerimaan->sterilisasi_no : "") ?></span>
    </td>  
	<td>
        <span><?php echo (!empty($penerimaan->instalasi_nama) ? $penerimaan->instalasi_nama : "") ?></span>
    </td>
	<td>
        <span><?php echo (!empty($penerimaan->ruangan_nama) ? $penerimaan->ruangan_nama : "") ?></span>
    </td>      
    <td>
        <span><?php echo (!empty($penerimaan->peralatansterilisasi_nama) ? $penerimaan->peralatansterilisasi_nama : "") ?></span>
    </td>
    <td>
        <span><?php echo (!empty($penerimaan->waktukadaluarsa) ? MyFormatter::formatDateTimeForUser($penerimaan->waktukadaluarsa) : "") ?></span>
    </td>
</tr>