<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>

<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
         'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'mergeHeaders'=>array(
            array(
                'name'=>'<center>Hari Pemasangan</center>',
                'start'=>5, //indeks kolom 3
                'end'=>8, //indeks kolom 4
            ),
            array(
                'name'=>'<center>Infeksi</center>',
                'start'=>9, //indeks kolom 3
                'end'=>12, //indeks kolom 4
            ), 
             array(
                'name'=>'<center>Hasil Kultur</center>',
                'start'=>14, //indeks kolom 3
                'end'=>17, //indeks kolom 4
            ),
        ),
	'columns'=>array( 
            array(
                'header' => 'No',
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),  
            array(
                'header' => 'Nama Pasien',
                'value' => '$data->nama_pasien',
            ),
            array(
                'header' => 'TGL',
                'value' => 'MyFormatter::formatDateTimeForUser($data->surveilans_tgl)'
            ),  
            array(
                'header' => 'Ruangan',
                'value' => '$data->ruangan_nama'
            ), 
            array(
                'header' => 'Instalasi',
                'value' => '$data->instalasi_nama'
            ), 
            array(
                'header' => 'ETT',
                'value' => '($data->ett == true) ? 1 : 0'
            ),
            array(
                'header' => 'IVL',
                'value' => '($data->ivl == true) ? 1 : 0'
            ),
            array(
                'header' => 'CVL',
                'value' => '($data->cvl == true) ? 1 : 0'
            ),
            array(
                'header' => 'UC',
                'value' => '($data->uc == true) ? 1 : 0'
            ), 
           array(
                'header' => 'VAP',
                'value' => '($data->vap == true) ? 1 : 0'
            ),
            array(
                'header' => 'IAD',
                'value' => '($data->iad == true) ? 1 : 0'
            ),
            array(
                'header' => 'PLEB',
                'value' => '($data->pleb == true) ? 1 : 0'
            ),
            array(
                'header' => 'ISK',
                'value' => '($data->isk == true) ? 1 : 0'
            ), 
           array(
                'header' => 'DEKU',
                'value' => '($data->deku == "Ya") ? 1 : 0'
            ), 
            array(
                'header' => 'Sputum',
                'value' => '$data->sputum'
            ),
            array(
                'header' => 'Darah',
                'value' => '$data->darah'
            ), 
            array(
                'header' => 'Urine',
                'value' => '$data->urine'
            ), 
            array(
                'header' => 'Antibiotik',
                'value' => '$data->antibiotik'
            ),
            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>