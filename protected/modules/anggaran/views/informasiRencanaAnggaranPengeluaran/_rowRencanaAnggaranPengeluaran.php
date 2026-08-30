<tr>
    <td>
        <?php 
		if (isset($modRencanaDetail->no_urut)){
			echo CHtml::activeTextField($modRencanaDetail,'['.$i.']no_urut',array('readonly'=>true,'class'=>'span1', 'style'=>'width:20px;')); 
		}else {
			echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); 
		}
                
			?>
        <?php echo CHtml::activeHiddenField($modRencanaDetail,'['.$i.']rencanggaranpengdet_id'); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetail,'['.$i.']subkegiatanprogram_id'); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetail,'['.$i.']tglrencanapengdet'); ?>
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
			<?php 
                        echo CHtml::activeTextField($modRencanaDetail,'['.$i.']nilairencpengeluaran',array('class'=>'span2 integer2','style'=>'width:90px;','onkeyup'=>"hitungTotal(); return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <a onclick="batalRencana(this,<?php echo (isset($modRencanaDetail->rencanggaranpengdet_id) ? $modRencanaDetail->rencanggaranpengdet_id : 0); ?>);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rencana"><i class="icon-form-silang"></i></a>
    </td>
</tr>
