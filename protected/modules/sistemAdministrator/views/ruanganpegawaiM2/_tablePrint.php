<?php
$itemCssClass='table table-striped table-bordered table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }if ($caraPrint == "PDF") {
        $itemCssClass='table border';
    }
} else {
    $data = $model->searchPrint();
    $template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
    'id' => 'sajenis-kelas-m-grid',
    'enableSorting' => false,
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,
    'columns' => array(
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$row + 1',
        ),
        array(
            'name' => 'ruangan.ruangan_nama',
            'header' => 'Nama Ruangan',
            'value' => '$data->ruangan->ruangan_nama',
        ),
        array(
            'header' => 'Nama Pegawai',
            'value' => '$data->pegawai->nama_pegawai',
            'htmlOptions' => array(
                'style' => 'border-left: 1px solid #DDDDDD;'
            ),
        ),
    ),
));