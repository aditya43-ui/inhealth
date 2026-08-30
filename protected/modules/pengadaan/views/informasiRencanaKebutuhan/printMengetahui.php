<style>
	.table td,
	.table th {
		border: 1px solid black;
	}

	.table {
		box-shadow: none;
	}

	.uang {
		text-align: right !important;
	}
</style>
<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)) {
	$template = "{items}";
	if ($caraPrint == 'EXCEL') {
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
		header('Cache-Control: max-age=0');
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

echo $this->renderPartial('application.views.headerReport.headerAnggaran', array('judulLaporan' => $judulLaporan, 'deskripsi' => $deskripsi, 'colspan' => 10));
echo "No. Rencana : <b>" . $model->noperencnaan . "</b>";
?>
<table class="table">
	<thead>
		<tr style="border:1px solid;">
			<th>No.</th>
			<th>Supplier</th>
			<th>Jenis</th>
			<th>Nama Obat</th>
			<th>Tgl. Kadaluarsa</th>
			<th>Jumlah yang Harus Diorder</th>
			<!-- <th>Maksimal Stok</th> -->
			<th>Stok Akhir</th>
			<th>Jumlah Kemasan (Satuan)</th>
			<th>Jumlah Kebutuhan</th>
			<th>HPP</th>
			<th>VEN</th>
			<th>ABC</th>
			<th>Sub Total</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$total = 0;
		$subtotal = 0;
		foreach ($modDetails as $i => $modDetail) {
			$oa = ObatalkesM::model()->findByPk($modDetail->obatalkes_id);
			$modSupplier = ObatalkesV::model()->findByAttributes(array(
				'obatalkes_id' => $modDetail->obatalkes_id
			));
			$sat = !empty($modDetail->satuankecil_id) ? $modDetail->satuankecil->satuankecil_nama : $modDetail->satuanbesar->satuanbesar_nama;
			$kecil = $oa->satuankecil->satuankecil_nama;
			$modLookup = ADLookupM::model()->findByAttributes(array('lookup_value' => $modDetail->obatalkes->ven));
		?>
			<tr>
				<td><?php echo $i + 1;
					echo ". "; ?></td>
				<td><?php echo $modSupplier->supplier_nama; ?></td>
				<td><?php echo empty($oa->jenisobatalkes_id) ? "-" : $oa->jenisobatalkes->jenisobatalkes_nama; ?></td>
				<td><?php echo $oa->obatalkes_nama; ?></td>
				<td><?php echo MyFormatter::formatDateTimeForUser($oa->tglkadaluarsa); ?></td>
				<td class="uang"><?php echo $modDetail->jmlharusorder . " " . $kecil; ?></td>
				<td class="uang" hidden><?php echo $modDetail->maksimalstok . " " . $kecil; ?></td>
				<td class="uang"><?php echo $modDetail->stokakhir . " " . $kecil; ?></td>
				<td class="uang"><?php echo $modDetail->kemasanbesar . " " . $kecil; ?></td>
				<td class="uang"><?php echo number_format($modDetail->jmlpermintaan, 2, ",", ".") . " " . $sat; ?></td>
				<td class="uang"><?php echo (Params::cekHiddenHargaGudangFarmasi() == true) ? $format->formatNumberForPrint($modDetail->harganettorenc) : "Hidden"; ?></td>
				<td><?php echo isset($modLookup->lookup_name) ? $modLookup->lookup_name : "-"; ?></td>
				<td><?php echo $modDetail->kategori_abc; ?></td>
				<td style="font-weight: normal; text-align: right;">
					<?php
					//                                if (!empty($modDetail->satuankecil_id)) {
					//                                    $subtotal = $modDetail->harganettorenc * $modDetail->jmlpermintaan;
					//                                } else {
					//                                    $subtotal = $modDetail->harganettorenc * $modDetail->jmlpermintaan * $modDetail->kemasanbesar;
					//                                }
					// $subtotal = ($modDetail->hargatotalrenc * $modDetail->jmlpermintaan);
					$total += $modDetail->hargatotalrenc;
					echo (Params::cekHiddenHargaGudangFarmasi() == true) ? $format->formatNumberForPrint($modDetail->hargatotalrenc) : "Hidden"; ?>
				</td>
			</tr>
		<?php } ?>

		<tr style="border:1px solid;">
			<td colspan="12" style="text-align:right;font-weight: normal; font-style: italic;">Total Anggaran</td>
			<td style="font-weight: normal; font-style: italic; text-align: right;">
				<?php echo (Params::cekHiddenHargaGudangFarmasi() == true) ? $format->formatNumberForPrint($total) : "Hidden"; ?>
			</td>
		</tr>
	</tbody>
</table>
<table width="100%">
	<tr>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
			<?php
			if (isset($model->tglmengetahui)) { ?>
				Mengetahui,
				<br><br><br><br><br><br>
				( <?php echo $model->PegawaimengetahuiLengkap; ?> )
			<?php } ?>
		</th>
		<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="2">
			Menyetujui,
			<br><br><br><br><br><br>
			( <?php echo $model->PegawaimenyetujuiLengkap; ?> )
		</th>
	</tr>
</table>