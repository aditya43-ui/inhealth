<?php 
     $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchTablePrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
		
		if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
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
        //'mergeHeaders'=>array(
          //  array(
            //    'name'=>'<p style="margin: 0; text-align: center;">Tarif</p>',
              //  'start'=>8, //indeks kolom 3
                //'end'=>9, //indeks kolom 4
            //),
        //),
        'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
                array(
                    'header'=>'No.',
                    'value' => $row,
                ),
                array(
                    'header'=>'Tgl. Pembayaran/<br>No Pembayaran',
                    'name'=>'pp.tglpembayaran',
					'type'=>'raw',
					'value'=>'(!empty($data->tglpembayaran)?MyFormatter::formatDateTimeForUser($data->tglpembayaran):"")."/<br>".$data->nopembayaran',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'No. Rekam Medik',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik',
                    'headerHtmlOptions'=>array('colspan'=>1,'style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Nama Pasien',
                    'value' => '$data->nama_pasien',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'footer' => ''
                ),               
                array(
                    'header'=>'Jenis Penjamin /<br> Penjamin',
                    'type'=>'raw',
                    'name'=>'carabayarPenjamin',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                ),
                array(
                    'header'=>'Kelas Pelayanan',
                    'type'=>'raw',
                    'value'=>'$data->kelaspelayanan_nama',
//                    'name'=>'kelaspelayanan_nama',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;'),
                    'footerHtmlOptions'=>array('colspan'=>7,'style'=>'text-align:right;font-style:italic;'),
                    'footer'=>'Total',
                ),                              
				array(
					'header' => 'Ruangan',
					'type' => 'raw',
					'value' => '$data->ruangan_nama',					
				),
				array(
					'header' => 'Total Pendapatan',
					'type' => 'raw',
					'name'=>'totalpendapatan',
					'value' => 'number_format($data->totalpendapatan,0,"",".")',
					'htmlOptions'=>array('style'=>'text-align:right;'),
					'footer'=>'sum(totalpendapatan)',
					'footerHtmlOptions'=>array('style'=>'text-align:right;'),
				),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>