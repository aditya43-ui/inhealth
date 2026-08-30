<?php
$table = 'ext.bootstrap.widgets.MergeHeaderGroupGridView';
$itemsCssClass = 'table table-striped table-condensed';
$sort = true;
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
            'value' => 'number_format($data->getSumTotal(array("pasien","kelaspelayanan"),"total"),0,"",".")',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => number_format($model->getSumTotal(array("pasien", "kelaspelayanan"), "total"), 0, "", "."),
        ),
        /*
        array(
            'header' => 'Jasa Ahli Gizi',
            'name' => 'tarif_tindakankomp',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'value' => 'number_format($data->getSumKomponen(array("pasien","kelaspelayanan"),"ag"))',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => number_format($model->getSumTotalKomponen(array("pasien", "kelaspelayanan"), "ag"), 0),
        ),
        array(
            'header' => 'Insentif',
            'name' => 'tarif_tindakankomp',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'value' => 'number_format($data->getSumKomponen(array("pendaftaran","kelaspelayanan"),"insentif"))',
            'footerHtmlOptions' => array('style' => 'text-align:right;'),
            'footer' => number_format($model->getSumTotalKomponen(array("pasien", "kelaspelayanan"), "insentif")),
        ),
         * 
         */
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>
<br>
<?php /*
<table border="1" width="50%" style="margin-left:30px;">
    <tr>
        <td width="20%"> JUMLAH : </td>
        <td align="center"> (AHLI GIZI) </td>
        <td width="20%"> Rp <?php echo number_format($model->getSumTotalKomponen(array("pasien", "kelaspelayanan"), "ag")); ?></td>
    </tr>
    <tr>
        <td width="30%">  </td>
        <td align="center"> (INSENTIF) </td>
        <td width="20%"> Rp <span STYLE='text-align:right;'><?php echo number_format($model->getSumTotalKomponen(array("pasien", "kelaspelayanan"), "insentif")); ?></span></td>
    </tr>
    <tr>
        <td colspan="2" width="60%" align="center">  TOTAL </td>
        <td width="20%"> Rp <span STYLE='text-align:right;'><?php echo number_format($model->getTotalKomponen(array("pasien", "kelaspelayanan"))); ?><span STYLE='text-align:right;'></td>
    </tr>
</table>
 * 
 */ ?>