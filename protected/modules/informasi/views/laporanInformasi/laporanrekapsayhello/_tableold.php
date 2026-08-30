<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$data = $modSayHello->searchSayHelloTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)){
  $sort = false;
  $data = $modSayHello->searchSayHelloPrint();
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
}

	$this->widget($table,array(
        'id'=>'laporansayhello-grid',
        'dataProvider'=>$data,
		'enableSorting'=>$sort,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-condensed',
        'columns'=>array(
            array(
                'name'=>'tgl_sayhello',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_sayhello)',
            ),
			array(
                'header' => 'No.',
                'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
            ),
			array(
				'header'=>'Nama',
				'value'=>'$data->nama',
			),
			array(
                'name'=>'tgl_krs',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_krs)',
            ),
			array(
				'header'=>'Alamat',
				'value'=>'$data->alamat',
			),
			
			array(
				'header'=>'Diagnosa',
				'value'=>'$data->diagnosa',
			),
			array(
				'header'=>'Kondisi Pasien Terkini Setelah Opname',
				'value'=>'$data->kondisi_pasien',
			),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
?>