
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
            <th>Nama Pegawai</th>
            <th>Tahun</th>
            <th>Masa</th>
            <th>Iuran JHT 3.7%</th>
            <th>Tunjangan JKK</th>
            <th>Tunjangan JKM</th>
            <th>Iuran JP 2%</th>
            <th>Tunjangan BPJS Kes. 4%</th>
            <th>Iuran JHT 2% Karyawan</th>
            <th>Potongan JHT 3.7%</th>
            <th>Potongan JKK</th>
            <th>Potongan JKM</th>
            <th>Potongan JP 2%</th>
            <th>Iuran JP 1% Karyawan</th>
            <th>Potongan BPJS Kes. 4%</th>
            <th>Iuran BPJS Kes. 1% Karyawan</th>
            <th>PPh 21 Seluruh Penghasilan</th>
            <th>Take Home Pay</th>
        </tr>
    </thead>
</table>