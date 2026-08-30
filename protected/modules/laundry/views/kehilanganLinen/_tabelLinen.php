<?php echo CHtml::css('#table-linen thead tr th{vertical-align:middle;}'); ?>

<table class="table table-striped table-condensed" id="table-linen">
	<thead>
		<tr>
			<th>No. </th>
			<th>No. Register Linen</th>
			<th>Nama Barang</th>
			<th>Jumlah</th>
			<th>Jenis Perawatan</th>
			<th>Keterangan</th>
			<th>Tambah / Batal</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		if(count((array)$modDetail) > 0){
			echo $this->renderPartial($this->path_view.'_rowDetail', array('modDetail' => $modDetail, 'form' => $form, 'row' => 0));
		}
		else{
			echo $this->renderPartial($this->path_view.'_rowDetail', array('modDetail' => $modDetail, 'form' => $form, 'row' => 0));
		}
		?>
	</tbody>
</table>
