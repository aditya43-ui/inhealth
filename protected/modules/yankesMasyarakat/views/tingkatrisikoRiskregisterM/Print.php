<?php 
$itemCssClass = 'table table-striped table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
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
echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiNew',array('judulLaporan'=>$judulLaporan, 'colspan'=>6));      
$this->widget($table,array(
    'id'=>'tingkatrisiko-m-grid',
    'enableSorting'=>false,
    'dataProvider'=>$model->search(),
    'template'=>$template,
    'itemsCssClass'=>$itemCssClass,
    'columns'=>array(
        array(
            'header'=>'No',
            'value'=>'$row+1',
        ),
        array(
            'header' => 'Tingkat Risiko',
            'name' => 'tingkatrisiko_nama',
        ),
        array(
            'header' => 'Batas Bawah',
            'name' => 'tingkatrisiko_batasbawah',
        ),
        array(
            'header' => 'Batas Atas',
            'name' => 'tingkatrisiko_batasatas',
        ),
        array(
            'header' => 'Warna Risiko',
            'name' => 'tingkatrisiko_warna',
        ),
        array(
            'header' => 'Tindakan',
            'name' => 'tingkatrisiko_tindakan',
        ),	
        array(
            'header'=>'<center>Status</center>',
            'value'=>'($data->tingkatrisiko_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
            'htmlOptions'=>array('style'=>'text-align:center;'),
        ),
    ),
)); 
?>