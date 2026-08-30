<div class="panel panel-success" style="margin-top: 17px">
	<div class="panel-heading">
		<div class="panel-title">
			<i class="entypo-credit-card"></i> Tabel Pembayaran Pelayanan Pasien
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
			$data = $model->searchPrint();
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
			'itemsCssClass' => 'table table-bordered table-striped table-condensed',
			'columns' => array(
				array(
					'header' => 'Periode',
					'type' => 'raw',
					'value' => $value,
					'footer' => 'Total',
				),
				array(
					'header' => 'Pendaftaran',
					'name' => 'jumlah_daftar',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_daftar)',
					'footer' => 'sum(jumlah_daftar)',
				),
				array(
					'header' => 'Lunas',
					'name' => 'jumlah_lunas',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_lunas)',
					'footer' => 'sum(jumlah_lunas)',
				),
				array(
					'header' => 'Belum Lunas',
					'name' => 'jumlah_belumlunas',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_belumlunas)',
					'footer' => 'sum(jumlah_belumlunas)',
				)
			),
			'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
		));
		?>
	</div>
</div>