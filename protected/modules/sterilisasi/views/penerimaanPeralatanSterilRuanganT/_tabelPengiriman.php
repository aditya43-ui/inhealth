<table class="items table table-striped table-condensed" id="table-peralatansteril">
	<thead>
		<tr>
			<th>Pilih</th>
			<th>No.</th>
			<th>Ruangan Asal</th>
			<th>Nama Peralatan dan Linen</th>
			<th>Jumlah</th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if(count((array)$modPengDetails) > 0){
			foreach($modPengDetails AS $i=>$modPengDetail){ 
                            
                            //proses mapping
                            $mapBarang = MapbarangsterilisasiM::model()->findByAttributes(array('peralatansterilisasi_id'=>$modPengDetail->peralatansterilisasi_id));
                            if(!empty($mapBarang)){
                                $modPengDetail->barang_id = $mapBarang->barang_id;
                            }
                            
                            $mapLinen = MaplinensterilisasiM::model()->findByAttributes(array('peralatansterilisasi_id'=>$modPengDetail->peralatansterilisasi_id));
                            if(!empty($mapLinen)){
                                $modPengDetail->linen_id = $mapLinen->linen_id;
                            }
                ?>
				<tr>
					<td>
						<?php echo CHtml::activeCheckBox($modPengDetail,'['.$i.']checklist', array('class'=>'ceklis','checked'=>true)); ?>
					</td>
					<td>
						<?php echo $i+1; ?>
						<?php echo CHtml::activeHiddenField($modPengDetail,'['.$i.']kirimperlinensteril_id',array('readonly'=>true,'class'=>'span1')); ?>
						<?php echo CHtml::activeHiddenField($modPengDetail,'['.$i.']kirimperlinensterildet_id',array('readonly'=>true,'class'=>'span1')); ?>
						<?php echo CHtml::activeHiddenField($modPengDetail,'['.$i.']linen_id',array('readonly'=>true,'class'=>'span1')); ?>
						<?php echo CHtml::activeHiddenField($modPengDetail,'['.$i.']barang_id',array('readonly'=>true,'class'=>'span1')); ?>
					</td>
					<td>
						<?php echo $modPengDetail->kirimperlinensteril->ruangan->ruangan_nama; ?>
					</td>
					<td>
						<?php echo !empty($modPengDetail->barang_id) ? $modPengDetail->barang->barang_nama : $modPengDetail->peralatansterilisasi->peralatansterilisasi_nama; ?>
					</td>
					<td>
						<?php echo CHtml::activeTextField($modPengDetail,'['.$i.']kirimperlinensterildet_jml',array('class'=>'span2 integer','style'=>'width:90px;','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
					</td>
					<td>
						<?php echo CHtml::activeTextField($modPengDetail,'['.$i.']kirimperlinensterildet_ket',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
					</td>
				</tr>
	<?php 	}
		}
		?>
	</tbody>
</table>