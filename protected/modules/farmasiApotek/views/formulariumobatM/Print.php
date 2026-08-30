
<style>
    @page {
        font-size: 10pt !important;
        margin: 0;
    }

    @media print {

        html,
        body {
            margin: 1cm;
            font-family: "Arial" !important;
            font-size: 10pt;
            width: 21cm;
            height: 33cm;
        }

        div.footer {
            position: fixed;
            bottom: 0;
        }

        .page-break {
            display: block;
            page-break-before: always;
        }
    }
</style>
<?php 
$table = 'ext.bootstrap.widgets.BootGroupGridView';
if($caraPrint=='EXCEL')
{
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>3));      
$this->widget($table,array(
	'id'=>'sajenis-kelas-m-grid',
    'enableSorting'=>false,
    'dataProvider'=>$model->searchPrint(),
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'name'=>'obatalkes_id',
            'header'=>'Nama Obat Alkes',
            'value'=>'$data->obatalkes->obatalkes_nama',
        ),
        'jenisformularium',
        array(
            'name'=>'carabayar_id',
            'header'=>'Jenis Penjamin',
            'value'=>'$data->carabayar->carabayar_nama',
        ),
        array(
            'name'=>'penjamin_id',
            'header'=>'Penjamin',
            'value'=>'$data->penjamin->penjamin_nama',
        ),
        array(
            'header' => 'Status',
            'value'=>'($data->is_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
            'htmlOptions'=>array('style'=>'text-align:center;'),
        ),
        ),
    )); 
?>