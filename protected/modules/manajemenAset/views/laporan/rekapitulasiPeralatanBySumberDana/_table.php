<?php

$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
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
        $table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
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

$kol[] = [
    'header' => 'No.',
    'value' => '$data["no"]',      
    'footer'=>"&nbsp;",    
    'htmlOptions'=>[
        'width'=>'7%'
    ]
];

$kol[] = [
    'header' => 'Lokasi',
    'type' => 'raw',
    'name' => 'lokasiaset_namalokasi',           
    'footer'=>'<b>Total Keseluruhan</b>'  ,    
];

$look = SumberdanaM::model()->findAll("sumberdana_aktif = TRUE ORDER BY sumberdana_nama ASC");

$medik = [];
$medik_non = [];
foreach($look as $key => $val){
    $init = str_replace(' ','_',strtolower($val->sumberdana_nama));
    $kol[] = [
        'header' => $val->sumberdana_nama,
        'type' => 'raw',
        'name' => $init,
        'htmlOptions' => [
            'style' => 'text-align:right;'
        ],
        'footerHtmlOptions' =>[
            'style' => 'text-align:right;'
        ],
        'footer' => '<b>'.$model->getTotal($val->sumberdana_nama).'</b>'
    ];        
}

$kol[] = [
    'header' => 'Total',
    'type' => 'raw',
    'name' => 'total_semua',
    'htmlOptions' => [
        'style' => 'text-align:right;'
    ],
    'footerHtmlOptions' =>[
        'style' => 'text-align:right;'
    ],
    'footer' => '<b>'.$model->getTotal('').'</b>'
];

$this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,        
    'columns' => $kol,
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>