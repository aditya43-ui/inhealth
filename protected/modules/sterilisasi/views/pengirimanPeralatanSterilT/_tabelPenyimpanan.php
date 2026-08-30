<table class="items table table-striped table-condensed" id="table-peralatansteril">
	<thead>
		<tr>
			<th>Pilih</th>
			<th>No.</th>
			<!--<th>Ruangan Asal</th>-->
			<th>No. Penyimpanan</th>
			<th>Nama Peralatan dan Linen</th>
			<th>Jumlah</th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if(count((array)$modPenyimpananDetails) > 0){
			foreach($modPenyimpananDetails AS $i=>$modPenyimpananDet){ ?>
				<tr>
					<td>
						<?php echo CHtml::activeCheckBox($modPenyimpananDet,'['.$i.']checklist', array('class'=>'ceklis','checked'=>true)); ?>
					</td>
					<td>
						<?php echo $i+1; ?>
						<?php echo CHtml::activeHiddenField($modPenyimpananDet,'['.$i.']penyimpanansteril_id',array('readonly'=>true,'class'=>'span1')); ?>
						<?php echo CHtml::activeHiddenField($modPenyimpananDet,'['.$i.']penyimpanansterildet_id',array('readonly'=>true,'class'=>'span1')); ?>
						<?php echo CHtml::activeHiddenField($modPenyimpananDet,'['.$i.']peralatansterilisasi_id',array('readonly'=>true,'class'=>'span1')); ?>
						<?php echo CHtml::activeHiddenField($modPenyimpananDet,'['.$i.']lokasipenyimpanan_id',array('readonly'=>true,'class'=>'span1')); ?>
						<?php echo CHtml::activeHiddenField($modPenyimpananDet,'['.$i.']rakpenyimpanan_id',array('readonly'=>true,'class'=>'span1')); ?>
						<?php echo CHtml::activeHiddenField($modPenyimpananDet,'['.$i.']sterilisasi_id',array('readonly'=>true,'class'=>'span1')); ?>
                                                <?php echo CHtml::activeHiddenField($modPenyimpananDet,'['.$i.']barang_id',array('readonly'=>true,'class'=>'span1')); ?>
					</td>
					<!--<td>-->
						<?php // echo $modPenyimpananDet->pengajuan->ruangan->ruangan_nama; ?>
					<!--</td>-->
					<td>
						<?php echo $modPenyimpananDet->penyimpanansteril->penyimpanansteril_no; ?>
					</td>
					<td>
						<?php 
//                                                echo $modPenyimpananDet->peralatansterilisasi->peralatansterilisasi_nama; 
                                                echo $modPenyimpananDet->PeralatansterilisasiNama;
                                                ?>
					</td>
					<td>
						<?php echo CHtml::activeTextField($modPenyimpananDet,'['.$i.']penyimpanansterildet_jml',array('class'=>'span2 integer','style'=>'width:90px;','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
					</td>
					<td>
						<?php echo CHtml::activeTextField($modPenyimpananDet,'['.$i.']penyimpanansterildet_ket',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
					</td>
				</tr>
	<?php 	}
		}
		?>
	</tbody>
</table>