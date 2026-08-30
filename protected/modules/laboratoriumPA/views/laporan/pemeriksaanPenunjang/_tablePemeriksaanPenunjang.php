<?php 
    $itemCssClass = 'table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchPrintLaporan();
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
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
        $itemCssClass = 'table border';
    } else{
        $data = $model->searchTableLaporan();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php $this->widget($table,array(
    'id'=>'tableLaporanPemeriksaanPenunjang',
    'dataProvider'=>$data,
        'template'=>$template,
        'enableSorting'=>$sort,
        'itemsCssClass'=>$itemCssClass,
    'columns'=>array(
        array(

            'header' => '<center>No.</center>',
            'type'=>'raw',
            'value' => '$row+1',
            'htmlOptions'=>array('style'=>'text-align:center'),
        ),
        array(
            'header' => '<center>Kode</center>',
            'type'=>'raw',
            'value' => '$data->daftartindakan_kode',
        ),
        array(
            'header'=>'<center>Nama Pemeriksaan</center>',
            'type'=>'raw',
            'value'=>'$data->daftartindakan_nama',
            'footerHtmlOptions'=>array('colspan'=>3,'style'=>'text-align:right;font-style:italic;'),
            'footer'=>'Total',
        ),
        array(
            'header'=>'<center>Tarif</center>',
            'name'=>'tarif_satuan',
            'type'=>'raw',
            'value'=>'number_format($data->tarif_satuan,0, "", ".")',
            'htmlOptions'=>array('style'=>'text-align:right'),
            'footerHtmlOptions'=>array('style'=>'text-align:right;'),
            'footer'=>'sum(tarif_satuan)',
        ),
        array(
            'header'=>'<center>Jumlah</center>',
            'name'=>'qty_tindakan',
            'type'=>'raw',
            'value'=>'number_format($data->qty_tindakan,0, "", ".")',
            'htmlOptions'=>array('style'=>'text-align:right'),
            'footerHtmlOptions'=>array('style'=>'text-align:right;'),
            'footer'=>'sum(qty_tindakan)',
        ),
        array(
            'header'=>'<center>Total</center>',
            'name'=>'Total',
            'type'=>'raw',
            'value'=>'number_format($data->Total,0, "", ".")',
            'htmlOptions'=>array('style'=>'text-align:right'),
            'footerHtmlOptions'=>array('style'=>'text-align:right;'),
            'footer'=>'sum(Total)',
        ),
        
    ),
)); ?> 