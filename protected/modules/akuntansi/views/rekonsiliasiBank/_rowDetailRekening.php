<tr>
	<td><?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer2', 'style'=>'width:20px;')); ?>
        <?php // echo CHtml::activeHiddenField($modRekonDetail, '[ii]rekening1_id',array('readonly'=>true,'style'=>'width:20px;')); ?>
        <?php // echo CHtml::activeHiddenField($modRekonDetail, '[ii]rekening2_id',array('readonly'=>true,'style'=>'width:20px;')); ?>
        <?php // echo CHtml::activeHiddenField($modRekonDetail, '[ii]rekening3_id',array('readonly'=>true,'style'=>'width:20px;')); ?>
        <?php // echo CHtml::activeHiddenField($modRekonDetail, '[ii]rekening4_id',array('readonly'=>true,'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modRekonDetail, '[ii]rekening5_id',array('readonly'=>true,'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modRekonDetail, '[ii]jenisrekonsiliasibank_id',array('readonly'=>true,'style'=>'width:20px;')); ?>
        <?php // echo CHtml::activeHiddenField($modRekonDetail, '[ii]kelrekening_id',array('readonly'=>true,'style'=>'width:20px;')); ?>
        <span id="isi-r" name="[ii][uraian]"><?php echo isset($modRekonDetail->uraiantransaksi) ? $modRekonDetail->uraiantransaksi : ""; ?></span>
	</td>
	<td><span name="[ii][kode_rekening]"><?php echo $modRekonDetail->kode_rekening; ?></span></td>
	<td><span name="[ii][nama_rekening]"><?php echo $modRekonDetail->nama_rekening; ?></span></td>
	<td><?php echo CHtml::activeTextField($modRekonDetail, '[ii]saldodebit',array('disabled'=>($status == 'debit' ? "" : "disabled"),'class'=>'span2 integer2')); ?></td>
	<td><?php echo CHtml::activeTextField($modRekonDetail, '[ii]saldokredit',array('disabled'=>($status == 'kredit' ? "" : "disabled"),'class'=>'span2  integer2')); ?></td>
	<td><span name="[ii][keterangan]"><?php echo $modRekonDetail->keterangan; ?></span></td>
	<td><a onclick="batalRekening(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan rekening rekonsiliasi bank"><i class="icon-form-silang"></i></a></td>
</tr>