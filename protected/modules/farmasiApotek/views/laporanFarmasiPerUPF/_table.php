<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    
    $total = 0;

    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchLaporanPrintFarmasiPerUPF();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
         if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
        }

        foreach ($data->data as $item) {
            $total += $item->tarif_tindakan;
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
        $data = $model->searchLaporanFarmasiPerUPF();
        $dataTotal = $model->searchLaporanPrintFarmasiPerUPF();
        $template = "{summary}\n{items}\n{pager}";

        foreach ($dataTotal->data as $item) {
            $total += $item->tarif_tindakan;
        }
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
                'footer'=>'Total',
                'footerHtmlOptions' => array(
                    'colspan'=>isset($caraPrint) ? 9 : 1,
                    'style'=>'font-weight: bold;',
                ),
            ),
            array(
                'name' => 'create_time',
                'header'=>'TANGGAL',
                'value' => function($data) {
                    return MyFormatter::formatDateTimeId($data->create_time);
                }
             ),
             array(
                'name' => 'nama_pasien',
                'header'=>'NAMA PASIEN',
                'headerHtmlOptions' => array('style' => 'text-align: center;')

             ),
             array(
                'name' => 'carabayar_nama',
                'header'=>'JENIS PENJAMIN',
             ),
             array(
                'name' => 'no_pendaftaran',
                'header'=>'NO. BILLING',
                'headerHtmlOptions' => array('style' => 'text-align: center;')

             ),
             array(
                'name' => 'nopelayanan',
                'header'=>'NO. NOTA',
                'value' => '$data->no_pendaftaran . $data->nopelayanan',
                'htmlOptions' => array('style' => 'width: 150px;'),
                'headerHtmlOptions' => array('style' => 'text-align: center;')


             ),
             array(
                'name' => 'daftartindakan_kode',
                'header'=>'KODE TARIF',
                'htmlOptions' => array('style' => 'width: 50px;'),
                'headerHtmlOptions' => array('style' => 'text-align: center;')


             ),
             array(
                'name' => 'daftartindakan_nama',
                'header'=>'URAIAN TARIF',
                'headerHtmlOptions' => array('style' => 'text-align: center;')

             ),
             array(
                'name' => 'nama_pegawai',
                'header'=>'PETUGAS',
             ),
             array(
                'name' => 'tarif_tindakan',
                'header'=>'JUMLAH',
                'value' =>  '"Rp. " . MyFormatter::formatNumberForPrint($data->tarif_tindakan)',
                'htmlOptions' => array('style' => 'text-align: right; width: 150px;'),
                'headerHtmlOptions' => array('style' => 'text-align: center;'),
                'footer' => "Rp. " . MyFormatter::formatNumberForPrint($total),
                'footerHtmlOptions' => array('style' => 'text-align: right; font-weight: bold;'),
             ),

	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>