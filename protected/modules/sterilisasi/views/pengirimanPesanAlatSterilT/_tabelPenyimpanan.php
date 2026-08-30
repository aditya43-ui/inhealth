<table class="items table table-striped table-condensed" id="table-peralatansteril">
	<thead>
		<tr>
			<th>No.</th>
			<th>Ruangan Asal</th>
			<th>No. Pemesanan</th>
			<th>Nama Peralatan dan Linen</th>
			<th>Jumlah</th>
			<th>Keterangan</th>
			<th>Batal</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if(count((array)$modPemesananDet) > 0){
			foreach($modPemesananDet AS $i=>$detail){ ?>
				<tr>
					<td>
						<?php // echo $i+1; ?>
						<?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
						<?php echo CHtml::activeHiddenField($detail,'[ii]pesanperlinensteril_id',array('readonly'=>true,'class'=>'span1')); ?>
						<?php echo CHtml::activeHiddenField($detail,'[ii]pesanperlinensterildet_id',array('readonly'=>true,'class'=>'span1')); ?>
						<?php echo CHtml::activeHiddenField($detail,'[ii]barang_id',array('readonly'=>true,'class'=>'span1')); ?>
						<?php echo CHtml::activeHiddenField($detail,'[ii]linen_id',array('readonly'=>true,'class'=>'span1')); ?>
						<?php echo CHtml::activeHiddenField($detail,'[ii]pesanperlinensterildet_jml',array('class'=>'span1','readonly'=>true)); ?>
						<?php echo CHtml::activeHiddenField($detail,'[ii]pesanperlinensterildet_ket',array('class'=>'span1','readonly'=>true)); ?>
					</td>
					<td>
						<?php echo $detail->pesan->ruangan->ruangan_nama; ?>
					</td>
					<td>
						<?php echo $detail->pesan->pesanperlinensteril_no; ?>
					</td>
					<td>
						<?php echo $detail->barang->barang_nama; ?>
					</td>
					<td>
						<?php echo $detail->pesanperlinensterildet_jml; ?>
					</td>
					<td>
						<?php echo $detail->pesanperlinensterildet_ket; ?>
					</td>
					<td>
						<a onclick="batalLinen(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan linen"><i class="icon-form-silang"></i></a>
					</td>
				</tr>
	<?php 	}
		}
		?>
	</tbody>
</table>