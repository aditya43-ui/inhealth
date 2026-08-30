
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

echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));      

$this->widget($table, array(
    'id' => 'saaktifitas-m-grid',
    'enableSorting' => false,
    'dataProvider' => $model->searchPrint(),
    'template' => $template,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$row+1',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center; width:10px;'),
        ),
         array(
            'header' => 'Dokter',
            'type' => 'raw',
            'name' => 'nama_pegawai',                                
            'value' => function($data) {                                    
                return !empty($data->dokter_id)?$data->pegawai->namaLengkap:'';
            }
        ),
        'nama_paket',     
        'harga_paket',                
        array(
            'header' => 'Paket BMHP',
            'type' => 'raw',
            'value' => '(($data->is_paketbmhp) ? "Aktif" : "Tidak Aktif")',
        ),
        array(
            'header' => 'Status',
            'type' => 'raw',
            'value' => '(($data->is_aktif) ? "Aktif" : "Tidak Aktif")',
        ),
    ),
));
?>