<?php
$itemCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchUnitPelayananPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
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
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
    $itemCssClass = 'table border';
} else {
    $data = $model->searchUnitPelayanan();
    $template = "{summary}\n{items}\n{pager}";
}
?>
<?php $this->widget($table, array(
    'id' => 'tableLaporan',
    'dataProvider' => $data,
    //    'filter'=>$model,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,
    //       'mergeColumns' => array('instalasi_nama', 'ruangan_nama', 'dokter_nama'),
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
            'htmlOptions' => array('style' => 'text-align:center;width:30px;'),
            'type' => 'raw',
        ),
        array(
            'header' => 'Nama Ruangan',
            'name' => 'ruangan_nama',
            'value' => '$data->ruangan_nama',
            'htmlOptions' => array('style' => 'text-align:left;'),
            'type' => 'raw',
        ),
        array(
            'header' => 'Kunjungan Baru',
            'value' => '$data->jumlahkunjunganbaru',
            'htmlOptions' => array('style' => 'text-align:center;width:100px'),
            'type' => 'raw',
        ),
        array(
            'header' => 'Kunjungan Lama',
            'value' => '$data->jumlahkunjunganlama',
            'htmlOptions' => array('style' => 'text-align:center;width:100px;'),
            'type' => 'raw',
        ),
        array(
            'header' => 'Jumlah',
            'value' => '$data->jumlahkunjungan',
            'htmlOptions' => array('style' => 'text-align:center;width:30px;'),
            'type' => 'raw',
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){
        
        var paging = $("#tableLaporan table").find("input[name=\'paging\']").val();
        if(typeof paging == \'undefined\')
        {
            paging = 0;
        }
        paging = parseInt(paging) + 1;
        $(".number_page").val(paging);

        $("#tableLaporan").parent().find("li").each(
            function()
            {
                if($(this).attr("class") == "active")
                {
                    setType(this);
                }
            }
        );
        
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
    }',
)); ?> 
