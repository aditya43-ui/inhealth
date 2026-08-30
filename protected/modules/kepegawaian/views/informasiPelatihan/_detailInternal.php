<table class="tab_detail" width="100%">
	<thead>
		<tr>
			<th style="vertical-align: middle;text-align: center;">No.</th>
			<th style="vertical-align: middle;text-align: center;">No. Induk Pegawai</th>
			<th style="vertical-align: middle;text-align: center;">Nama Pegawai</th>
			<th style="vertical-align: middle;text-align: center;">Jabatan</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$cnt = 1;
		
		$total_pelatihan = 0;
		$total_transportasi = 0;
		$total_penginapan = 0;
		$total_perjalanandinas = 0;
		$total_lainlain = 0;
		$total_total = 0;
		
		foreach ($modDetail as $item):
			
			// var_dump($item->attributes); die;
			
			$modPegawai = PegawaiM::model()->findByPk($item->pegawai_id);
			$modJabatan = new JabatanM;
			
			$total_pelatihan += $item->biaya_pelatihan;
			$total_transportasi += $item->biaya_transportasi;
			$total_penginapan += $item->biaya_penginapan;
			$total_perjalanandinas += $item->biaya_perjalanandinas;
			$total_lainlain += $item->biaya_lainlain;
			$total_total += $item->total;
			
			if (!empty($modPegawai->jabatan_id))
				$modJabatan = JabatanM::model()->findByPk($modPegawai->jabatan_id);
		?>
		<tr>
			<td class="num"><?php echo $cnt++; ?></td>
			<td><?php echo $modPegawai->nomorindukpegawai; ?></td>
			<td><?php echo $modPegawai->namaLengkap; ?></td>
			<td><?php echo $modJabatan->jabatan_nama; ?></td>
			
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>