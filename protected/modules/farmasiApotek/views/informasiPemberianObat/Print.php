<?php 
$itemCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
    $template = "{items}";
    if($caraPrint=='EXCEL'){
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');   
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }

    if ($caraPrint=='PDF') {
        $table = 'ext.bootstrap.widgets.BootGridViewPDF';
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
}
if($caraPrint!="PDF"){
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
}
$this->widget($table,array(
    'id'=>'pengajuanremunerasi-t-grid',
    'enableSorting'=>false,
    'dataProvider'=>$model->searchPrint(),
    'template'=>$template,
    'itemsCssClass'=>$itemCssClass,
    'columns'=>array(
        array(
            'header' => 'No',
            'value'=>'($this->grid->dataProvider->pagination) ? 
                        ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1): ($row+1)',
            'filter'=>false,
        ),
        array(
            'header'=>'Tanggal dan Nomer Reseptur',
            'value' => function ($data) {
                echo MyFormatter::formatDateTimeForUser($data->tglreseptur)."<br>".$data->noresep;
            },
        ),
        array(
            'header'=>'Nomor Pendaftaran',
            'value' => '$data->no_pendaftaran',
        ),
        array(
            'header'=>'Nama dan No.RM Pasien',
            'value' => function ($data) {
                echo $data->nama_pasien;
                echo "<br>";
                echo $data->no_rekam_medik;
            },
        ),
        array(
            'header'=>'Nama Obat',
            'value' => '$data->obatalkes_nama',
        ),
        array(
            'header'=>'Satuan',
            'value' => '$data->satuankecil_nama',
        ),
        array(
            'header'=>'Jumlah Reseptur',
            'value'=>function($data){
                echo number_format($data->qty_reseptur,2,",",".");
            },
        ),
        array(
            'header'=>'Jumlah Penjualan Reseptur',
            'value'=>function($data){
                echo number_format($data->qty_penjualan,2,",",".");
            },
        ),
        array(
            'header' => 'Status',
            'value' => '$data->status',
        ),
    ),
)); 
?>