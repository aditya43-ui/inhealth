<tr>
    <td>
        <?php 
		if (isset($modRencanaDetail->no_urut)){
			echo CHtml::activeTextField($modRencanaDetail,'['.$i.']no_urut',array('readonly'=>true,'class'=>'span1', 'style'=>'width:20px;')); 
		}else {
			echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); 
		}
			?>
        <?php echo CHtml::activeHiddenField($modRencanaDetail,'['.$i.']rencanggaranpengdet_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetail,'['.$i.']subkegiatanprogram_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetail,'['.$i.']tglrencanapengdet',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetail,'['.$i.']apprrencanggaran_id',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo (!empty($modRencanaDetail->programkerja_kode) ? $modRencanaDetail->programkerja_kode : "") ?>
    </td>
    <td>
        <?php echo (!empty($modRencanaDetail->subprogramkerja_kode) ? $modRencanaDetail->subprogramkerja_kode : "") ?>
    </td>
    <td>
        <?php echo (!empty($modRencanaDetail->kegiatanprogram_kode) ? $modRencanaDetail->kegiatanprogram_kode : "") ?>
    </td>
    <td>
        <?php echo (!empty($modRencanaDetail->subkegiatanprogram_kode) ? $modRencanaDetail->subkegiatanprogram_kode : "") ?>
    </td>
    <td>
        <?php echo (!empty($modRencanaDetail->subkegiatanprogram_nama) ? $modRencanaDetail->subkegiatanprogram_nama : "") ?>
    </td>
    <td>
        <?php echo (!empty($modRencanaDetail->tglrencanapengdet) ? $format->formatMonthForUser($modRencanaDetail->tglrencanapengdet) : "") ?>
    </td>
    <td>
			<?php echo CHtml::activeTextField($modRencanaDetail,'['.$i.']nilairencpengeluaran',array('class'=>'span2 integer2','style'=>'width:90px;','onkeyup'=>"hitungTotal(); return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo CHtml::activeCheckBox($modRencanaDetail,'['.$i.']approve', array('class'=>'ceklis','onclick'=>'ceklistUbah(this,\''.$modRencanaDetail->approve.'\',\''.$modRencanaDetail->rencanggaranpengdet_id.'\',\''.$modRencanaDetail->apprrencanggaran_id.'\')')); ?>
	</td>
</tr>