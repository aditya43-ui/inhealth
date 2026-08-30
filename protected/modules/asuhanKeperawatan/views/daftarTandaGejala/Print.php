
<?php

$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)) {
    $template = "{items}";
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}

echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew', array('judulLaporan' => $judulLaporan, 'colspan' => '8'));

$this->widget($table, array(
    'id' => 'sajenis-kelas-m-grid',
    'enableSorting' => false,
    'dataProvider' => $model->searchPrint(),
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '($this->grid->dataProvider->pagination) ? 
						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
						: ($row+1)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Nama Tanda Gejala',
            'value' => function($data) {
                echo $data->tandagejala_daftar_nama;
            }
        ),
        array(
            'header' => 'Nama Lain Tanda Gejala',
            'value' => function($data) {
                echo $data->tandagejala_daftar_namalain;
            }
        ),        
        array(
            'header' => 'Aktif',
            'value' => function($data) {
                echo ($data->tandagejala_daftar_aktif == true ) ? 'Aktif' : 'Tidak Aktif';
            }
        ),
    ),
));
?>