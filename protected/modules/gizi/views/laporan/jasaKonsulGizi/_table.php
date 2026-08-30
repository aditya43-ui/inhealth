<?php

$table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
$sort = true;
$itemsCssClass = 'table table-striped table-condensed';
if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $template = "{items}";
    $sort = false;
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
    $itemsCssClass = 'table border';
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
} else {
    $data = $model->searchTable();
    $template = "{summary}\n{items}\n{pager}";
}
?>
<?php

$this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemsCssClass,
    'columns' => array(
        array(
            'header' => 'No.',
            'htmlOptions' => array('style' => 'text-align:center'),
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
        array(
            'header' => 'Nama',
            'value' => '$data->nama_pasien',
        ),
        array(
            'header' => 'Kelas',
            'htmlOptions' => array('style' => 'text-align:center'),
            'value' => '$data->kelaspelayanan_nama',
            'footerHtmlOptions' => array('colspan' => 3, 'style' => 'text-align:right;font-style:italic;'),
            'footer' => 'Total',
        ),
        array(
            'header' => 'Tarif (Rp)',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'value' => '(Params::cekHiddenHargaGizi()==true) ? number_format($data->getSumTotal(array("pasien","kelaspelayanan"),"total"),0,"","."):"Hidden"',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => ((Params::cekHiddenHargaGizi() == true) ? number_format($model->getSumTotal(array("pasien", "kelaspelayanan"), "total"), 0, "", ".") : "Hidden"),
        ),
        /*
        array(
            'header' => 'Jasa Ahli Gizi (Rp)',
            'name' => 'tarif_tindakankomp',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'value' => 'number_format($data->getSumKomponen(array("pasien","kelaspelayanan"),"ag"),0,"",".")',
        ),
        array(
            'header' => 'Insentif (Rp)',
            'name' => 'tarif_tindakankomp',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'value' => 'number_format($data->getSumKomponen(array("pendaftaran","kelaspelayanan"),"insentif"),0,"",".")',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => 'number_format($model->getSumTotalKomponen(array("pasien", "kelaspelayanan"), "insentif"), 0, "", ".")',
        ),
         * 
         */
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>