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
];

$kol[] = [
    'header' => 'Lokasi',
    'type' => 'raw',
    'name' => 'lokasiaset_namalokasi',           
    'footer'=>'<b>Total Keseluruhan</b>'  ,
    'footerHtmlOptions' => [
        'colspan' => 2
    ]
];

$look = LookupM::getItemsUrutan('kondisi_barang');

$medik = [];
$medik_non = [];
foreach($look as $key => $val){
    $init_medik = strtolower(str_replace(' ', '', $key).'_medik');
    $medik[] = [
        'header' => $val,
        'type' => 'raw',
        'name' => 'total_'.$init_medik,
        'htmlOptions' => [
            'style' => 'text-align:right;'
        ],
        'footerHtmlOptions' =>[
            'style' => 'text-align:right;'
        ],
        'footer' => '<b>'.$model->getTotal($init_medik).'</b>'
    ];
    
    $init_nonmedik = strtolower(str_replace(' ', '', $key).'_nonmedik');
    $medik_non[] = [
        'header' => $val,
        'type' => 'raw',
        'name' => 'total_'.$init_nonmedik,
        'htmlOptions' => [
            'style' => 'text-align:right;'
        ],
        'footerHtmlOptions' =>[
            'style' => 'text-align:right;'
        ],
        'footer' => '<b>'.$model->getTotal($init_nonmedik).'</b>'
    ];
}

$kol = array_merge($kol, $medik);
$kol = array_merge($kol, $medik_non);
$kol = array_merge($kol, [[
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
]]);

$this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,    
    'mergeHeaders'=>array(
            array(
                'name'=>'<center>Alat Medik</center>',
                'start'=>2, 
                'end'=>4, 
            ),
            array(
              'name'=>'<center>Alat Non Medik</center>',
              'start'=>5, 
              'end'=>7, 
          ),
      ),
    'columns' => $kol,
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>