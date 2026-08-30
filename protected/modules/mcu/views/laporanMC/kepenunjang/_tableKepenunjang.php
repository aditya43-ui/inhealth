<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
	$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
		$row = '$row+1';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
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
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
	'template'=>$template,
	'enableSorting'=>$sort,
	'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
		array(
				'header' => 'No.',
				'value' => $row
			),
//            'instalasi_nama',
            array(
              'name' =>'tglmasukpenunjang',
              'header' => 'Tanggal Masuk Kepenunjang',
              'value'=>'MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)',
            ),
            'no_pendaftaran',
            'no_rekam_medik',
            array(
                'header' => 'Nama Pasien',
                'value' => '$data->namadepan." ".$data->nama_pasien'
            ),            
           
            array(
                'header' => 'Umur',
                'value' => function($data){
                    return CustomFunction::getUmurTahun($data->tanggal_lahir,date("Y-m-d"))." Thn";
                },
            ),
          //  'jeniskelamin',
            array(
                'header'=>'Ruangan Penunjang',
                'value'=>'$data->ruanganpenunj_nama',
            ),
//            'ruanganpenunj_nama',
//            'catatan_dokter_konsul',
            array(
                'header'=>'Status Periksa',
                'value'=>'$data->statusperiksa',
            ),
//            array(
//                   'header'=>'CaraBayar/Penjamin',
//                   'type'=>'raw',
//                   'value'=>'$data->CaraBayarPenjamin',
//                   'htmlOptions'=>array('style'=>'text-align: center')
//            ),  
//            'alamat_pasien',   
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>