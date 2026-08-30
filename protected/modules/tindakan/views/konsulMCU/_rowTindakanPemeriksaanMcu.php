<?php if(!empty($modPermintaanMcu)){ ?>
	<tr>
		<td>
			<?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
		</td>
		<td>
			<span name="[ii][namatindakan]"><?php echo (!empty($modPermintaanMcu->namatindakan) ? $modPermintaanMcu->namatindakan : "-") ?></span>
			<?php echo CHtml::activeHiddenField($modPermintaanMcu,'[i][ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
			<?php echo CHtml::activeHiddenField($modPermintaanMcu,'[i][ii]paketpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
			<?php echo CHtml::activeHiddenField($modPermintaanMcu,'[i][ii]daftartindakan_id',array('readonly'=>true,'class'=>'span1')); ?>
			<?php echo CHtml::activeHiddenField($modPermintaanMcu,'[i][ii]tipepaket_id',array('readonly'=>true,'class'=>'span1')); ?>
			<?php echo CHtml::activeHiddenField($modPermintaanMcu,'[i][ii]ruangantujuan_id',array('readonly'=>true,'class'=>'span1')); ?>
                        <?php echo CHtml::activeHiddenField($modPermintaanMcu,'[i][ii]tarif_satuan',array('readonly'=>true,'class'=>'span1 integer')); ?>
                        <?php echo CHtml::activeHiddenField($modPermintaanMcu,'[i][ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer','style'=>'width:96px')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modPermintaanMcu,'[i][ii]qty_tindakan',array('readonly'=>true,'onkeyup'=>'hitungTotal(this);','class'=>'span1 integer')); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($modPermintaanMcu,'[i][ii]satuantindakan',array('readonly'=>true,'class'=>'span2')); ?>
		</td>
		<!--<td>
			<?php //echo CHtml::activeTextField($modPermintaanMcu,'[i][ii]tarif_satuan',array('readonly'=>true,'class'=>'span1 integer')); ?>
		</td>
		<td>
			<?php //echo CHtml::activeTextField($modPermintaanMcu,'[i][ii]tarif_tindakan',array('readonly'=>true,'readonly'=>true,'class'=>'span1 integer','style'=>'width:96px')); ?>
		</td>-->
	</tr>
<?php } ?>

