<?php 
	$itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
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
<?php 
if(isset($caraPrint) && $caraPrint == "EXCEL"){
    $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        //'mergeHeaders'=>array(
          //  array(
            //    'name'=>'<p style="margin: 0; text-align: center;">Tarif</p>',
              //  'start'=>7, //indeks kolom 3
                //'end'=>12, //indeks kolom 4
            //),
        //),
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
                array(
                    'header' => 'No.',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                    'value' => $row,
                ),
                array(
                    'header'=>'No. Rekam Medik',
                    'name'=>'no_rekam_medik',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Nama Pasien / Nama Panggilan',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'$data->NamaNamaBIN',
                ),
                array(
                    'header'=>'No. Pendaftaran',
                    'name'=>'no_pendaftaran',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'name'=>'nama_pegawai',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Jenis Penjamin / Penjamin',
                    'name'=>'carabayarPenjamin',
					'type' => 'raw',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Kelas Pelayanan',
                    'value'=>'$data->kelaspelayanan_nama',
                    'name'=>'kelaspelayanan_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                /*array(
                    'header'=>'Tarif Satuan',
                    'value'=>'$data->tarif_satuan',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Tarif Cyto Tindakan',
                    'value'=>'$data->tarifcyto_tindakan',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Tarif RS Akomodasi',
                    'value'=>'$data->tarif_rsakomodasi',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Tarif Medis',
                    'value'=>'$data->tarif_medis',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Tarif Paramedis',
                    'value'=>'$data->tarif_paramedis',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Tarif Bhp',
                    'value'=>'$data->tarif_bhp',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),*/
                array(
                    'header'=>'Total',
                    'value'=>'$data->totalTarif',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
}else{
    $this->widget($table,array(
	'id'=>'tableLaporan',
	'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
       // 'mergeHeaders'=>array(
         //   array(
           //     'name'=>'<p style="margin: 0; text-align: center;">Tarif</p>',
             //   'start'=>7, //indeks kolom 3
               // 'end'=>12, //indeks kolom 4
            //),
        //),
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
                array(
                    'header' => 'No.',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                    'value' => $row,
                ),
				array(
                    'header'=>'Tanggal Pendaftaran/ <br> No. Pendaftaran',
                    'name'=>'no_pendaftaran',
					'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br>".$data->no_pendaftaran',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'No. Rekam Medik',
                    'name'=>'no_rekam_medik',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Nama Pasien',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'value'=>'$data->namadepan." ".$data->nama_pasien',
                ),                
                array(
                    'name'=>'nama_pegawai',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Jenis Penjamin / Penjamin',
                    'name'=>'carabayarPenjamin',
					'type' => 'raw',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Kelas Pelayanan',
                    'value'=>'$data->kelaspelayanan_nama',
                    'name'=>'kelaspelayanan_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                /*array(
                    'header'=>'Tarif Satuan',
                    'value'=>'MyFormatter::formatNumberForPrint($data->tarif_satuan)',
//                    'name'=>'tarif_satuan',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Tarif Cyto Tindakan',
                    'value'=>'MyFormatter::formatNumberForPrint($data->tarifcyto_tindakan)',
//                    'name'=>'tarifcyto_tindakan',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Tarif RS Akomodasi',
                    'value'=>'MyFormatter::formatNumberForPrint($data->tarif_rsakomodasi)',
//                    'name'=>'tarif_rsakomodasi',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Tarif Medis',
//                    'name'=>'tarif_medis',
                    'value'=>'MyFormatter::formatNumberForPrint($data->tarif_medis)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Tarif Paramedis',
                    'value'=>'MyFormatter::formatNumberForPrint($data->tarif_paramedis)',
//                    'name'=>'tarif_paramedis',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header'=>'Tarif Bhp',
                    'value'=>'MyFormatter::formatNumberForPrint($data->tarif_bhp)',
//                    'name'=>'tarif_bhp',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),*/
                array(
                    'header'=>'Total',
                    'value'=>'MyFormatter::formatNumberForPrint($data->totalTarif)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
}
?>