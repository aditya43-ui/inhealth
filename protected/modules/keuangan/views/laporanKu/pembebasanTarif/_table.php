<?php 
$itemCssClass='table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchTable();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)){
	$row = '$row+1';
    $sort = false;
  $data = $model->searchPrint();  
  $template = "{items}";
  if ($caraPrint == "EXCEL"){
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
  
  if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
        }
  
        echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
        $itemCssClass='table border';
}
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporan',
    'dataProvider'=>$data,
    'enableSorting'=>$sort,
    'template'=>$template,
        'htmlOptions'=>array(
            'style'=>'font-size',
            
        ),
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
				array(
					'header' => 'No.',
					'value' => $row
				),
                 array(
                    'header'=>'Nama Dokter',
                    // 'name'=>'nobuktibayar',
                    'type'=>'raw',
                    'value'=>'$data->gelardepan." ".$data->nama_pegawai.", ".$data->gelarbelakang_nama',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
// //                'nobuktibayar',
                array(
                    'header'=>'Tanggal <br> Pembebasan',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeFOrUser($data->tglpembebasan)',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Tanggal <br> Pelayanan',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeFOrUser($data->tgl_tindakan)',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'No. Rekam Medik',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->no_pendaftaran',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->namadepan.$data->nama_pasien',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Ruangan Pelayanan',
                    'type'=>'raw',
                    'value'=>'$data->ruangan_nama',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),
                ),
                array(
                    'header'=>'Jumlah Tarif',
                    'type'=>'raw',
                    'value'=>'"".MyFormatter::formatNumberForPrint($data->tarif_satuan)',
                    'htmlOptions'=>array('style'=>'font-size:10px; text-align: right;'),
                ),
                array(
                    'header'=>'Uraian Tindakan',
                    'type'=>'raw',
                    'value'=>'$data->daftartindakan_nama',
                    'htmlOptions'=>array('style'=>'font-size:10px;'),   
                ),
                array(
                    'header'=>'Kompora Tarif',
                    'type'=>'raw',
                    'value'=>'0',
                    'htmlOptions'=>array('style'=>'font-size:10px; text-align: right;'),
                ),
                array(
                    'header'=>'Jumlah Pembebasan',
                    'type'=>'raw',
                    'value'=>'"".MyFormatter::formatNumberForPrint($data->jmlpembebasan)',
                    'htmlOptions'=>array('style'=>'font-size:10px; text-align: right;'),
                ),                                                                

	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>