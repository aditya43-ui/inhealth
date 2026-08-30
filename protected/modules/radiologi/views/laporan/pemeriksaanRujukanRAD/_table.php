<?php 
    $itemCssClass='table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchLapPemeriksaanRujukRADPrint();
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
        $data = $model->searchLapPemeriksaanRujukRAD();
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
                    'header'=>'No.',
                    'value' => '$row+1',
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                ),
                array(
                    'header'=>'Tanggal <br> / No. Pendaftaran',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)." <br> / ".$data->no_pendaftaran',
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                ),
                array(
                    'header'=>'Pemeriksaan',                    
                    'value' => '$data->daftartindakan_nama',
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                ),
               array(
                    'header'=>'Institusi',                    
                    'value' => '$data->asalrujukan_nama',
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                ),
                array(
                    'header'=>'Nama Perujuk',                    
                    'value' => '$data->nama_perujuk',
                    'headerHtmlOptions'=>array('style'=>'text-align: left;vertical-align:middle;'),
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

