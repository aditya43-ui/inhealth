<table class="items table table-striped table-condensed" id="table-pemantauan-kondisi-pasien">        
	<thead>
		<tr>
			<th>Tanggal Pemantauan</th>
			<th>Jam Mulai</th>
			<th>Jam Selesai</th>
			<th>Menit Ke-</th>
			<th>Oksigen L/mnt</th>
			<th>Ventilasi mmHg</th>
			<th>Sirkulasi</th>
			<th>Suhu</th>
			<th>Perfusi Jaringan</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
			if(count($modDetails) > 0){
				foreach($modDetails AS $i=> $detail){
					echo $this->renderPartial($this->path_view.'_rowPemantauanKondisi',array('modKondisiPasienAnestesi'=> $detail));
				}
			}else{
				$this->renderPartial($this->path_view.'_rowPemantauanKondisi',array('modKondisiPasienAnestesi'=>$modKondisiPasienAnestesi));
			}
		?>
	</tbody>
</table>
