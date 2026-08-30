<div class="panel panel-success" style="margin-top: 17px">
	<div class="panel-heading">
		<div class="panel-title">
			<i class="entypo-credit-card"></i> Tabel Efisiensi Pelayanan
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
					'header' => 'BOR',
					'name' => 'jumlah_bor',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_bor,4)',
					'footer' => 'sum(jumlah_bor)',
				),
				array(
					'header' => 'ALOS',
					'name' => 'jumlah_alos',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_alos)',
					'footer' => 'sum(jumlah_alos)',
				),
				array(
					'header' => 'BTO',
					'name' => 'jumlah_bto',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_bto,4)',
					'footer' => 'sum(jumlah_bto)',
				),
				array(
					'header' => 'TOI',
					'name' => 'jumlah_toi',
					'type' => 'raw',
					'value' => 'number_format($data->jumlah_toi)',
					'footer' => 'sum(jumlah_toi)',
				)
			),
			'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
		));
		?>
	</div>
</div>