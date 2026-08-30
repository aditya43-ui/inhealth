<?php if(!empty($modPermintaanMcu)){
	?>
	<tr>
		<td>
			<?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:30px;')); ?>
		</td>
		<td>
			<span name="[ii][namatindakan]"><?php echo (!empty($modPermintaanMcu->namatindakan) ? $modPermintaanMcu->namatindakan : "-") ?></span>
			<?php echo CHtml::activeHiddenField($modPermintaanMcu,'[i][ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
			<?php echo CHtml::activeHiddenField($modPermintaanMcu,'[i][ii]paketpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
			<?php echo CHtml::activeHiddenField($modPermintaanMcu,'[i][ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
			<?php echo CHtml::activeHiddenField($modPermintaanMcu,'[i][ii]tipepaket_id',array('readonly'=>true,'class'=>'span1')); ?>
			<?php echo CHtml::activeHiddenField($modPermintaanMcu,'[i][ii]ruangantujuan_id',array('readonly'=>true,'class'=>'span1')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modPermintaanMcu,'[i][ii]ruangan_nama',array('readonly'=>true,'class'=>'span2')); ?>
		</td>
		<td style="text-align:right;">
			<?php echo CHtml::activeTextField($modPermintaanMcu,'[i][ii]qty_tindakan',array('readonly'=>true,'onkeyup'=>'hitungTotal(this);','class'=>'span1 integer','style'=>'text-align:right;')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modPermintaanMcu,'[i][ii]satuantindakan',array('readonly'=>true,'class'=>'span1')); ?>
		</td>
                <td style="text-align:right;">
			<?php echo CHtml::activeTextField($modPermintaanMcu,'[i][ii]tarif_satuan',array('readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:96px;text-align:right;')); ?>
		</td>
		<td style="text-align:right;">
			<?php echo CHtml::activeTextField($modPermintaanMcu,'[i][ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer-decimal','style'=>'width:96px;text-align:right;')); ?>
		</td>
	</tr>
<?php } ?>
