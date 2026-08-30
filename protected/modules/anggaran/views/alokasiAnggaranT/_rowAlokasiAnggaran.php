<?php // for ($i = 1; $i <= $termin; $i++) {  ?>
<tr>
    <td>
        <?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modAlokasiAnggaran,'[ii]sumberanggaran_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modAlokasiAnggaran,'[ii]subkegiatanprogram_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modAlokasiAnggaran,'[ii]realisasianggpenerimaan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modAlokasiAnggaran,'[ii]apprrencanggaran_id',array('readonly'=>true,'class'=>'span1')); ?>
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
        <?php echo (!empty($modProgramKerja->tglapprrencanggaran) ? $format->formatMonthForUser($modProgramKerja->tglapprrencanggaran) : "") ?>
    </td>
    <td>
		<?php echo CHtml::activeTextField($modAlokasiAnggaran,'[ii]nilairencana',array('class'=>'span2 integer2','style'=>'width:90px;','readonly'=>true,'onkeyup'=>'hitungTotal();')); ?>
    </td>
	<td><?php echo (!empty($modAlokasiAnggaran->sumberanggarannama) ? $modAlokasiAnggaran->sumberanggarannama : ""); ?></td>
	<td>
		<?php echo CHtml::activeTextField($modAlokasiAnggaran, '[ii]nilaiygdialokasikan', array('class'=>'span2 integer2','style'=>'width:90px;','readonly'=>false,'onkeyup'=>'hitungTotal();')); ?>
	</td>
	<td>
        <a onclick="batalAlokasi(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan alokasi anggaran"><i class="icon-form-silang"></i></a>
    </td>
</tr>
<?php // } ?>