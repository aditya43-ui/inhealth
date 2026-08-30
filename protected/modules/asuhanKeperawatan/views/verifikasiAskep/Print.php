<style>
	.spasi1 {
		margin: 0 0px 0px 10px;
	}

	.spasi2 {
		padding: 0 0px 0px 20px;
	}

</style>
<div class="white-container">
	<?php
	if ($caraPrint == 'EXCEL') {
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
		header('Cache-Control: max-age=0');
	}
	echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 7));
	$no_urut = 1;
	$class='';
	if (isset($_GET['frame'])) {
		$class="table table-striped";
	}
	?>
    <table width="100%" class="spasi1">
		<tr>
			<td width="5%">Nama</td>
			<td width="25%">: <?php echo (isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : " - "); ?></td>
			<td width="5%">No. RM</td>
			<td width="25%">: <?php echo isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : " - "; ?></td>
			<td width="5%">Umur</td>
			<td width="35%">: <?php echo (isset($modPasien->umur) ? $modPasien->umur : " - ") . ' / ' . (isset($modPasien->jeniskelamin) ? $modPasien->jeniskelamin : " - " ); ?></td>
		</tr>
		<tr>
			<td width="10%">Ruang / Kelas</td>
			<td width="25%">: <?php echo (isset($modPasien->ruangan_nama) ? $modPasien->ruangan_nama : " - ") . ' / ' . (isset($modPasien->kelaspelayanan_nama) ? $modPasien->kelaspelayanan_nama : $model->getKelasPelayanan($modPasien->pendaftaran_id) ); ?></td>
			<td width="5%">Tanggal</td>
			<td width="25%">: <?php echo (isset($model->verifikasiaskep_tgl) ? MyFormatter::formatDateTimeForUser($model->verifikasiaskep_tgl) : " - "); ?></td>
			<td width="5%">Diagnosa</td>
			<td width="35%">: <?php echo (isset($modPasien->diagnosa_nama) ? $modPasien->diagnosa_nama : $model->getDiagnosaMedis($modPasien->pasien_id,$modPasien->pendaftaran_id)); ?></td>
		</tr>

	</table>
	<br>
	<div class='block-tabel'>
		<?php
		$this->widget('ext.bootstrap.widgets.BootGridView', array(
			'id' => 'verifikasi-grid',
			'enableSorting' => false,
			'template' => "{items}",
			'dataProvider' => $model->searchPrint($model->verifikasiaskep_id),
			'itemsCssClass' => 'table table-striped table-bordered table-condensed',
			'columns' => array(
				array(
					'header' => 'Tanggal',
					'name' => 'verifikasiaskep_tgl',
					'value' => 'isset($data->verifikasiaskep_tgl) ? MyFormatter::FormatDateTimeForUser($data->verifikasiaskep_tgl) : " - "',
				),
				array(
					'header' => 'No. Verifikasi',
					'name' => 'verifikasiaskep_no',
					'value' => 'isset($data->verifikasiaskep_no) ? $data->verifikasiaskep_no : " - "',
				),
				array(
					'header' => 'Petugas Verifikasi',
					'name' => 'petugasverifikasi_nama',
					'value' => 'isset($data->petugasverifikasi_nama) ? $data->petugasverifikasi_nama : " - "',
				),
				array(
					'header' => 'Mengetahui',
					'name' => 'mengetahui_nama',
					'value' => 'isset($data->mengetahui_nama) ? $data->mengetahui_nama : " - "',
				),
				array(
					'header' => 'Keterangan',
					'name' => 'verifikasiaskep_ket',
					'value' => 'isset($data->verifikasiaskep_ket) ? $data->verifikasiaskep_ket : " - "',
				),
				array(
					'header' => 'Status',
					'name' => 'verifikasiaskep_status',
					'value' => 'isset($data->verifikasiaskep_status) ? $data->verifikasiaskep_status : " - "',
				),
			),
			'afterAjaxUpdate' => 'function(id, data){
                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })
                 $("table").find("select").each(function(){
                    cekForm(this);
                })
            }',
		));
		?>
    </div>
</div>