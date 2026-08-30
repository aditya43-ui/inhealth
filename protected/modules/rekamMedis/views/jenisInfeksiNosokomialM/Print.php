<?php

$itemCssClass='table table-striped table-bordered table-condensed';
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
if ($caraPrint != "PDF") {
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
}
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
                        'header'=>'ID',
                        'value'=>'$data->jenisin_id',
                ),
		'jenisin_nama',
		'jenisin_namalainnya',
		'jenisin_aktif',
                                array(
                                    'header'=>'Aktif',
                                    'value'=>'(($data->jenisin_aktif=1)? "Aktif" : "Tidak Aktif")',
                                ),
    ),
));
?>
