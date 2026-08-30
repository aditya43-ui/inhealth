<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchLaporanPrint();
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
        $data = $model->searchLaporan();
         $template = "{summary}\n{items}\n{pager}";
    }


    $dataTotal = $model->searchLaporanPrint();
    $total = 0;
    foreach ($dataTotal->data as $item) {
        $total += $item->tarif_tindakan;
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
               'header'=>'NO. URUT',
               'value' => $row,
               'headerHtmlOptions' => array('style' => 'text-align: center;'),
               'footer' => 'Subtotal',
               'footerHtmlOptions' => array(
                    'colspan'=>7,
                    'style'=>'font-weight: bold',
               ),

            ),
            array(
                'name' => 'create_time',
                'header'=>'TANGGAL',
                'value' => function($data) {
                    return MyFormatter::formatDateTimeId(date('Y-m-d', strtotime($data->create_time)));
                },
                'footerHtmlOptions' => array('class' => 'hide'),
             ),
             array(
                'name' => 'nama_pasien',
                'header'=>'NAMA PASIEN',
                'headerHtmlOptions' => array('style' => 'text-align: center;'),
                'footerHtmlOptions' => array('class' => 'hide'),

             ),
             array(
                'name' => 'no_pendaftaran',
                'header'=>'NO. BILLING',
                'headerHtmlOptions' => array('style' => 'text-align: center;'),
                'footerHtmlOptions' => array('class' => 'hide'),

             ),
             array(
                'name' => 'nopelayanan',
                'header'=>'NO. NOTA',
                'value' => '$data->no_pendaftaran . $data->nopelayanan',
                'htmlOptions' => array('style' => 'width: 150px;'),
                'headerHtmlOptions' => array('style' => 'text-align: center;'),
                'footerHtmlOptions' => array('class' => 'hide'),


             ),
             array(
                'name' => 'daftartindakan_kode',
                'header'=>'KODE TARIF',
                'htmlOptions' => array('style' => 'width: 50px;'),
                'headerHtmlOptions' => array('style' => 'text-align: center;'),
                'footerHtmlOptions' => array('class' => 'hide'),


             ),
             array(
                'name' => 'daftartindakan_nama',
                'header'=>'URAIAN TARIF',
                'headerHtmlOptions' => array('style' => 'text-align: center;'),
                'footerHtmlOptions' => array('class' => 'hide'),
             ),
             array(
                'name' => 'tarif_tindakan',
                'header'=>'JUMLAH',
                'value' =>  '"Rp. " . MyFormatter::formatNumberForPrint($data->tarif_tindakan)',
                'htmlOptions' => array('style' => 'text-align: right; width: 150px;'),
                'headerHtmlOptions' => array('style' => 'text-align: center;'),
                'footer' => "Rp. ".MyFormatter::formatNumberForPrint($total),
                'footerHtmlOptions' => array('style' => 'text-align: right; font-weight: bold;'),
             ),

	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>