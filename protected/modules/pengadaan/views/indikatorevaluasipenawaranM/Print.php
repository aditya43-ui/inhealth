<?php
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
if($caraPrint!="PDF"){
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
}else{
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
    echo '<div style="margin-top:20px;">';
    echo '</div>';
}
    $table = 'ext.bootstrap.widgets.BootGridView';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchPrint();
         $template = "{summary}\n{items}\n{pager}";
    }
$this->widget($table, array(
    'id' => 'sajenis-kelas-m-grid',
    'enableSorting' => $sort,
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
            'htmlOptions' => array('style' => 'text-align:right;'),
        ),
        array(
            'header' => 'Jenis Pengadaan',
            'name' => 'jenispengadaan_id',
            'value' => '$data->jenispengadaan->jenispengadaan_nama',
        ),
        'evaluasipenawaran_jenis',
        'evaluasipenawaran_nama',
        'urutan',
        array(
            'header'=>'<center>Aktif</center>',
            'value'=>'($data->indikatorevaluasipenawaran_aktif == TRUE ) ? "Aktif" : "Tidak Aktif"',
            'htmlOptions'=>array('style'=>'text-align:center;'),
        ),
    ),
));
?>