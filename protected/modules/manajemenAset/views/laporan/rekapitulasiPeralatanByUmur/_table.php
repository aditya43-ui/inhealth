<?php

$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGroupGridView';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$data = $model->searchLaporan();
if (isset($caraPrint)) {
    $row = '$row+1';
    $data->pagination->pageSize = $data->totalItemCount;

    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }

    if ($caraPrint == 'PDF') {
        $table = 'ext.bootstrap.widgets.BootGroupGridViewPDF';
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
} else {

    $template = "{summary}\n{items}\n{pager}";
}
?>

<?php

$this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,    
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$data["no"]',  
            'footer' => '&nbsp;'
        ),
        array(
            'header' => 'Lokasi',
            'type' => 'raw',
            'name' => 'lokasiaset_namalokasi',           
            'footer'=>'<b>Total Keseluruhan</b>'
        ),
        array(
            'header' => '0 s/d 4 tahun',
            'type' => 'raw',
            'name' => 'total_range1',
            'htmlOptions' => [
                'style' => 'text-align:right;'
            ],
            'footerHtmlOptions' =>[
                'style' => 'text-align:right;'
            ],
            'footer' => '<b>'.$model->getTotal('range1').'</b>'
        ),        
        array(
            'header' => '5 s/d 8 tahun',
            'type' => 'raw',
            'name' => 'total_range2',
            'htmlOptions' => [
                'style' => 'text-align:right;'
            ],
            'footerHtmlOptions' =>[
                'style' => 'text-align:right;'
            ],
            'footer' => '<b>'.$model->getTotal('range2').'</b>'
        ),        
        array(
            'header' => '9 s/d 16 tahun',
            'type' => 'raw',
            'name' => 'total_range3',
            'htmlOptions' => [
                'style' => 'text-align:right;'
            ],
            'footerHtmlOptions' =>[
                'style' => 'text-align:right;'
            ],
            'footer' => '<b>'.$model->getTotal('range3').'</b>'
        ),   
        array(
            'header' => '17 s/d 20 tahun',
            'type' => 'raw',
            'name' => 'total_range4',
            'htmlOptions' => [
                'style' => 'text-align:right;'
            ],
            'footerHtmlOptions' =>[
                'style' => 'text-align:right;'
            ],
            'footer' => '<b>'.$model->getTotal('range4').'</b>'
        ), 
        array(
            'header' => '> 20 tahun',
            'type' => 'raw',
            'name' => 'total_range5',
            'htmlOptions' => [
                'style' => 'text-align:right;'
            ],
            'footerHtmlOptions' =>[
                'style' => 'text-align:right;'
            ],
            'footer' => '<b>'.$model->getTotal('range5').'</b>'
        ), 
        array(
            'header' => 'Total',
            'type' => 'raw',
            'name' => 'total_total_semua',
            'htmlOptions' => [
                'style' => 'text-align:right;'
            ],
            'footerHtmlOptions' =>[
                'style' => 'text-align:right;'
            ],
            'footer' => '<b>'.$model->getTotal('total_semua').'</b>'
        ), 
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>