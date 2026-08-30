<?php
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
header('Cache-Control: max-age=0');
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiExcelNew', array('judulLaporan' => $judulLaporan, 'colspan' => 12));
?>
<?= "<div class='header-space'>&nbsp;</div>" ?>
<div class="panel panel-success">
	<div class="panel-heading">
		<div class="panel-title">
			<i class="entypo-newspaper"></i> Laporan Kunjungan Rumah Sakit
		</div>
		<div class="panel-options">
			<a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
		</div>
	</div>
	<div class="panel-body">
		<?php
		$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
		$sort = true;
		if (isset($caraPrint)) {
			$data = $dataTable;
			$template = "{items}";
			$sort = false;
			if ($caraPrint == "EXCEL")
				$table = 'ext.bootstrap.widgets.BootExcelGridView';
		} else {
			$data = $dataTable;
			$template = "{summary}\n{items}\n{pager}";
		}
		// format date for value
		if ($model->jns_periode == "bulan") {
			$value = "MyFormatter::formatMonthForUser(date('Y-m',(strtotime(" . "$" . "data->periode))))";
		} elseif ($model->jns_periode == "tahun") {
			$value = "date('Y',(strtotime(" . "$" . "data->periode)))";
		} else {
			$value = "MyFormatter::formatDateTimeForUser(date('Y-m-d',(strtotime(" . "$" . "data->periode))))";
		}
		?>
		<?php
		$this->widget($table, array(
			'id' => 'table-grid',
			'dataProvider' => $data,
			'template' => $template,
			'enableSorting' => $sort,
			'itemsCssClass' => 'table table-striped table-condensed',
			'columns' => array(
				array(
					'header' => 'Periode',
					'type' => 'raw',
					'value' => $value,
					'footer' => 'Total',
				),
				array(
					'header' => 'Kunjungan Rawat Inap',
					'name' => 'jumlah_ri',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_ri)',
					'footer' => 'sum(jumlah_ri)',
				),
				array(
					'header' => 'Kunjungan Rawat Darurat',
					'name' => 'jumlah_rd',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_rd)',
					'footer' => 'sum(jumlah_rd)',
				),
				array(
					'header' => 'Kunjungan Rawat Jalan',
					'name' => 'jumlah_rj',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_rj)',
					'footer' => 'sum(jumlah_rj)',
				)
			),
			'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
		));
		?>
	</div>
</div>
<?= "<div class='footer-space'>&nbsp;</div>" ?>