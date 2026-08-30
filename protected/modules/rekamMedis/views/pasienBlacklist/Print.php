<style>
	.spasi1 {
		margin: 0 0px 0px 10px;
	}

	.spasi2 {
		padding: 0 0px 0px 20px;
	}

</style>
<div class="row">
    <div class="col-sm-12">
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
	<div class='block-tabel'>
		<?php
		$this->widget('ext.bootstrap.widgets.BootGridView', array(
			'id' => 'blacklist-grid',
			'enableSorting' => false,
			'template' => "{items}",
			'dataProvider' => $model->searchPrint($model->pasienblacklist_id),
			'itemsCssClass' => 'table table-striped table-bordered table-condensed',
			'columns' => array(
				array(
					'header' => 'Tanggal',
					'name' => 'pasienblacklist_tgl',
					'value' => 'isset($data->pasienblacklist_tgl) ? MyFormatter::FormatDateTimeForUser($data->pasienblacklist_tgl) : " - "',
				),
				array(
					'header' => 'No. Blacklist',
					'name' => 'pasienblacklist_no',
					'value' => 'isset($data->pasienblacklist_no) ? $data->pasienblacklist_no : " - "',
				),
				array(
					'header' => 'Karena Kasus',
					'name' => 'pasienblacklist_karenakasus',
					'value' => 'isset($data->pasienblacklist_karenakasus) ? $data->pasienblacklist_karenakasus : " - "',
				),
				array(
					'header' => 'Keterangan',
					'name' => 'pasienblacklist_ket',
					'value' => 'isset($data->pasienblacklist_ket) ? $data->pasienblacklist_ket : " - "',
				),
				array(
					'header' => 'Status',
					'name' => 'isblacklist',
					'value' => '($data->isblacklist == 1) ? "Ya" : "Tidak"',
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
</div>