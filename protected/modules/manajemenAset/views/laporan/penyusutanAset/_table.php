<div id="tableLaporan" class="grid-view">
	<table class="table table-striped table-condensed">
		<thead>
			<tr>
				<th>No.</th>
				<th>Periode Pembelian</th>
				<th>Nama Perusahaan Penjual</th>
				<th>Periode Penyusutan</th>
				<th>Nama Aktiva</th>
				<th>Umur Ekonomis</th>
				<th>Barang Kode</th>
				<th>Harga Perolehan</th>
				<th>Ruangan Nama</th>
				<th>Nilai Penyusutan sd Sekarang</th>
			</tr>
		</thead>
		<?php
		$total_perolehan = 0;
		$total_penyusutan = 0;
		?>
		<?php if(!empty($modPenyusutans)){ ?>
		<tbody>
				<?php foreach ($modPenyusutans as $i => $modPenyusutan){ ?>
				<?php
					$modPenyusutanDetails = $model->getPenyusutanDetail($modPenyusutan->penyusutanaset_id);
					foreach ($modPenyusutanDetails as $ii => $modPenyusutanDetail){ ?>
					<tr>
						<?php if($ii == 0){ ?>
							<td><?php echo $i+1; ?></td>
							<td><?php echo $modPenyusutanDetail->barang_thnbeli; ?></td>
							<td><?php echo $modPenyusutanDetail->barang_nama; ?></td>
						<?php }else{ echo "<td></td><td></td><td></td>"; }?>
							
							<td><?php echo MyFormatter::formatDateTimeForUser($modPenyusutanDetail->penyusutanaset_periode); ?></td>
							
						<?php if($ii == 0){ ?>
							<td><?php echo $modPenyusutanDetail->barang_nama; ?></td>
							<td><?php echo $modPenyusutanDetail->umurekonomis; ?></td>
							<td><?php echo $modPenyusutanDetail->barang_kode; ?></td>
							<td style="text-align: right; "><?php echo number_format($modPenyusutanDetail->hargaperolehan); ?></td>
							<td><?php echo $modPenyusutanDetail->ruangan_nama; ?></td>
						<?php }else{ echo "<td></td><td></td><td></td><td></td><td></td>"; }?>
							
							<td style="text-align: right; "><?php echo number_format($modPenyusutanDetail->penyusutanaset_saldo); ?></td>
					</tr>
				<?php } ?>
					<tr>
						<td colspan="9"></td>
						<td style="text-align: right; font-weight: bold;"><?php echo number_format($modPenyusutanDetail->totalpenyusutan); ?></td>
					</tr>
			<?php 
				$total_perolehan += $modPenyusutanDetail->hargaperolehan;
				$total_penyusutan += $modPenyusutanDetail->totalpenyusutan;
			} ?>
		</tbody>
		<thead>
			<tr>
				<td colspan="7" style="text-align: right; font-weight: bold; padding-top: 15px;">TOTAL</td>
				<td style="text-align: right; font-weight: bold;  padding-top: 15px"><?php echo number_format($total_perolehan); ?></td>
				<td></td>
				<td style="text-align: right; font-weight: bold;  padding-top: 15px"><?php echo number_format($total_penyusutan); ?></td>
			</tr>
		</thead>
		<?php } ?>
		
	</table>
</div>