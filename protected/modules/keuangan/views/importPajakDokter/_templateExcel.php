
<style>
    thead th{
        background:none;
        color:#333;
    }
</style>

<?php 
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
$judulLaporan = "Template Excel";
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
header('Cache-Control: max-age=0');     

?>
<table class="table table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <th>Nik</th>
            <th>Nama WP</th>
            <th>Tahun</th>
            <th>Masa</th>
            <th>NPWP</th>
            <th>Kode OP</th>
            <th>Bruto</th>
            <th>PPh 21</th>
        </tr>
    </thead>
</table>