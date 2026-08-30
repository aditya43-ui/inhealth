<table class="tab_detail" width="100%">
	<thead>
		<tr>
			<th rowspan="2" style="vertical-align: middle;text-align: center;">No.</th>
			<th rowspan="2" style="vertical-align: middle;text-align: center;">No. Induk Pegawai</th>
			<th rowspan="2" style="vertical-align: middle;text-align: center;">Nama Pegawai</th>
			<th rowspan="2" style="vertical-align: middle;text-align: center;">Jabatan</th>
			<th colspan="6" style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Biaya</th> 
			<th rowspan="2" style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Subtotal</th>
		</tr>
		<tr>
			<th style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Pelatihan</th>
			<th style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Transportasi</th>
			<th style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Penginapan</th>
			<th style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Perjalanan Dinas</th>
			<th style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Lain - Lain</th>
			<th style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Keterangan<br>Biaya Lain - Lain</th>
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
			<td class="num"><?php echo MyFormatter::formatNumberForPrint($item->biaya_pelatihan); ?></td>
			<td class="num"><?php echo MyFormatter::formatNumberForPrint($item->biaya_transportasi); ?></td>
			<td class="num"><?php echo MyFormatter::formatNumberForPrint($item->biaya_penginapan); ?></td>
			<td class="num"><?php echo MyFormatter::formatNumberForPrint($item->biaya_perjalanandinas); ?></td>
			<td class="num"><?php echo MyFormatter::formatNumberForPrint($item->biaya_lainlain); ?></td>
			<td><?php echo $item->keterangan_lainlain; ?></td>
			<td class="num"><?php echo MyFormatter::formatNumberForPrint($item->total); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4" class="num">Grand Total</td>
			<td class="num"><?php echo MyFormatter::formatNumberForPrint($total_pelatihan); ?></td>
			<td class="num"><?php echo MyFormatter::formatNumberForPrint($total_transportasi); ?></td>
			<td class="num"><?php echo MyFormatter::formatNumberForPrint($total_penginapan); ?></td>
			<td class="num"><?php echo MyFormatter::formatNumberForPrint($total_perjalanandinas); ?></td>
			<td class="num"><?php echo MyFormatter::formatNumberForPrint($total_lainlain); ?></td>
			<td></td>
			<td class="num"><?php echo MyFormatter::formatNumberForPrint($total_total); ?></td>
		</tr>
	</tfoot>
</table>