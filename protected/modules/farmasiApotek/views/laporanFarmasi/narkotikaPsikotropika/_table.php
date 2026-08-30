<?php 
/**
 * css untuk membuat text head berada d tengah
 */
echo CHtml::css('.table thead tr th{
    vertical-align:middle;
}'); ?>
<?php 
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$mergeColumns = array('obatalkes_nama');
$data = $model->searchTableNarkotika();
$template = "{summary}\n{items}\n{pager}";
$sort = false;
if (isset($caraPrint)){ 
    $sort = false;
  $data = $model->searchPrintNarkotika();  
  $template = "{items}";
  if ($caraPrint == "EXCEL")
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
//    'mergeColumns'=>$mergeColumns,
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
            
            array(
                    'header' => 'No.',
                    'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',                    
            ),
			 array(
                'header'=>'No Resep',
                'type'=>'raw',
                'value'=>'$data->noresep',
            ),
			array(
                'header'=>'Tanggal Resep',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser($data->tglresep)',
            ),
           
            
             array(
                'header'=>'No. Pendaftaran',
                'type'=>'raw',
				'value'=>'$data->no_pendaftaran'				
            ),
			array(
                'header'=>'Nama Pasien',
                'type'=>'raw',
				'value'=>'$data->nama_pasien'				
            ),
			array(
                'header'=>'Alamat Pasien',
                'type'=>'raw',
				'value'=>'$data->alamat_pasien'				
            ),
			array(
                'header'=>'Dokter Resep',
                'type'=>'raw',
				'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama'				
            ),
			array(
                'header'=>'Nama Obat',
                'type'=>'raw',
				'value'=>'$data->obatalkes_nama'				
            ),
			array(
                'header'=>'Jumlah',
                'type'=>'raw',
				'value'=>'number_format($data->qty_oa,2,",",".")',
				'htmlOptions' => array('style' => 'text-align: right;'),
            ),
			array(
                'header'=>'Satuan',
                'type'=>'raw',
				'value'=>'$data->satuankecil_nama'				
            ),
            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>