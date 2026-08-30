<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetail,'[ii]subkegiatanprogram_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modRencanaDetail,'[ii]tglrencanapengdet',array('readonly'=>true,'class'=>'span1')); ?>
    </td>
    <td>
        <?php echo (!empty($modProgramKerja->programkerja_kode) ? $modProgramKerja->programkerja_kode : "") ?>
    </td>
    <td>
        <?php echo (!empty($modProgramKerja->subprogramkerja_kode) ? $modProgramKerja->subprogramkerja_kode : "") ?>
    </td>
    <td>
        <?php echo (!empty($modProgramKerja->kegiatanprogram_kode) ? $modProgramKerja->kegiatanprogram_kode : "") ?>
    </td>
    <td>
        <?php echo (!empty($modProgramKerja->subkegiatanprogram_kode) ? $modProgramKerja->subkegiatanprogram_kode : "") ?>
    </td>
    <td>
        <?php echo (!empty($modProgramKerja->subkegiatanprogram_nama) ? $modProgramKerja->subkegiatanprogram_nama : "") ?>
    </td>
    <td>
        <?php echo (!empty($modRencanaDetail->tglrencanapengdet) ? $format->formatMonthForUser($modRencanaDetail->tglrencanapengdet) : "") ?>
    </td>
    <td>
			<?php echo CHtml::activeTextField($modRencanaDetail,'[ii]nilairencpengeluaran',array('class'=>'span2 integer2','style'=>'width:90px;','onkeyup'=>"hitungTotal(); return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <a onclick="batalRencana(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rencana"><i class="icon-form-silang"></i></a>
    </td>
</tr>
