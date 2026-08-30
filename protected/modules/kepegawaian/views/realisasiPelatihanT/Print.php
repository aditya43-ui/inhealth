<style>
	body {
		color: black;
	}
	
	hr {
		border: none;
		border-bottom: 1px solid black;
	}
	
	.tab_header td {
		color: black;
		padding: 2px;
	}
	
	.tab_detail th, .tab_detail td {
		border: 1px solid black;
		padding: 2px;
	}
	
	.tab_detail th, .tab_detail tfoot td {
		font-weight: bold;
	}
	
	.num {
		text-align: right;
	}
	
	.signature {
		margin-top: 20px;
	}
	
	.signature td {
		text-align: center;
	}
	.bolds td {
		font-weight: bold;
	}
</style>


<?php
$tipe = JenisdiklatM::model()->findByPk($model->jenisdiklat_id);
$modPembuat = empty($model->pemberitugas_id) ? new PegawaiM : PegawaiM::model()->findByPk($model->pemberitugas_id);
$modMengetahui = empty($model->mengetahui_id) ? new PegawaiM : PegawaiM::model()->findByPk($model->mengetahui_id);
$modMenyetujui = empty($model->menyetujui_id) ? new PegawaiM : PegawaiM::model()->findByPk($model->menyetujui_id);

// var_dump($modBiaya->attributes); die;

// var_dump($model->attributes); die;

echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>'<h3>Realisasi Pelatihan '.$tipe->jenisdiklat_nama.'</h3>', 'colspan'=>10));
?>

<table width="100%" class="tab_header">
	<tr>
		<td>No. Realisasi</td>
		<td>:</td>
		<td width="100%"><?php echo $model->norealisasi; ?></td>
		<td nowrap>Tgl. Realisasi</td>
		<td>:</td>
		<td nowrap><?php echo date('d M Y', strtotime($model->tglrealisasi)); ?></td>
	</tr>
	<tr>
		<td>Nama Pelatihan</td>
		<td>:</td>
		<td><?php echo $model->namapelatihan; ?></td>
		<?php if ($model->jenisdiklat_id == Params::JENIS_DIKLAT_EKSTERNAL): ?>
			<td>Penyelenggara</td>
			<td>:</td>
			<td nowrap><?php echo $model->penyelenggara; ?></td>
		<?php elseif ($model->jenisdiklat_id == Params::JENIS_DIKLAT_INTERNAL): ?>
			<td>Pemateri</td>
			<td>:</td>
			<td nowrap><?php echo $model->pemateri; ?></td>
		<?php endif; ?>
	</tr>
	
	<tr>
		<td nowrap>Tempat Pelatihan</td>
		<td>:</td>
		<td><?php echo $model->tempat; ?></td>
		<td>Tanggal</td>
		<td>:</td>
		<td nowrap><?php echo MyFormatter::formatDateTimeForUser($model->realisasi_tglawal).' - '.
				MyFormatter::formatDateTimeForUser($model->realisasi_tglakhir); ?></td>
	</tr>
	
	
	<tr>
		<td>Alamat Pelatihan</td>
		<td>:</td>
		<td><?php echo $model->alamat; ?></td>
		<td>Jam</td>
		<td>:</td>
		<td nowrap><?php echo date('H:i', strtotime($model->jam_mulai)).' - '.
				date('H:i', strtotime($model->jam_akhir)).' ('.$model->total_jam.' Jam'.
				($model->total_menit == 0 ? '' : ' '.$model->total_menit.' Menit').
				')'; ?></td>
	</tr>
	
	<?php if ($model->jenisdiklat_id == Params::JENIS_DIKLAT_INTERNAL): ?>
	<tr>
		<td style="border-bottom: 1px solid black" colspan="6">&nbsp;</td>
	</tr>
	
	<tr>
		<td>Biaya Pemateri</td>
		<td>:</td>
		<td><?php echo MyFormatter::formatNumberForPrint($modBiaya->internal_biayapemateri); ?></td>
		<td nowrap>Keterangan Lain-lain</td>
		<td>:</td>
		<td rowspan="5" style="vertical-align: top;"></td>
	</tr>
	<tr>
		<td>Biaya Konsumsi</td>
		<td>:</td>
		<td><?php echo MyFormatter::formatNumberForPrint($modBiaya->internal_biayakonsumsi); ?></td>
	</tr>
	<tr>
		<td nowrap>Biaya Alat Peraga</td>
		<td>:</td>
		<td><?php echo MyFormatter::formatNumberForPrint($modBiaya->internal_biayaalatperaga); ?></td>
	</tr>
	<tr>
		<td>Biaya Lain-lain</td>
		<td>:</td>
		<td><?php echo MyFormatter::formatNumberForPrint($modBiaya->internal_biayalainlain); ?></td>
	</tr>
	<tr class="bolds">
		<td>Total Biaya</td>
		<td>:</td>
		<td><?php echo MyFormatter::formatNumberForPrint($modBiaya->total_biaya); ?></td>
	</tr>
	<?php endif; ?>
</table>
<hr>

<?php
if ($model->jenisdiklat_id == Params::JENIS_DIKLAT_EKSTERNAL) {
	echo $this->renderPartial('_detailEksternal', array(
		'model'=>$model, 'modDetail'=>$modDetail,
	), true);
} else {
	echo $this->renderPartial('_detailInternal', array(
		'model'=>$model, 'modDetail'=>$modDetail,
	), true);
}

?>

<table width="100%" class="signature" hidden>
	<tr>
		<td nowrap>Pembuat Tugas<br><br><br><br><br>
			<?php echo $modPembuat->namaLengkap; ?>
		</td>
		<td width="100%">Disetujui<br><br><br><br><br>
			<?php echo $modMenyetujui->namaLengkap; ?>
		</td>
		<td nowrap>Mengetahui<br><br><br><br><br>
			<?php echo $modMengetahui->namaLengkap; ?>
		</td>
	</tr>
</table>

