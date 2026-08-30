
<style>
    thead th{
        background:none;
        color:#333;
    }
</style>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
$judulLaporan = "Template Excel - ".strtoupper($jenisgaji);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
header('Cache-Control: max-age=0');

?>
<?php if($jenisgaji == 'THR'){   ?>
<table class="table table-striped table-bordered table-condensed">
    <thead>
        <tr>
          <th>NIK</th>
          <th>Masa</th>
          <th>Tahun</th>
          <th>Nama Pegawai</th>
          <th>Total THR</th>
          <th>Tunjangan PPh 21 THR</th>
          <th>PPh 21 THR</th>
          <th>THP THR</th>
        </tr>
    </thead>
</table>
<?php }else{ ?>
  <table class="table table-striped table-bordered table-condensed">
      <thead>
          <tr>
            <th>NIK</th>
            <th>Masa</th>
            <th>Tahun</th>
            <th>Nama Pegawai</th>
            <th>Total Bonus</th>
            <th>Tunjangan PPh 21 Bonus</th>
            <th>PPh 21 Bonus</th>
            <th>THP Bonus</th>
          </tr>
      </thead>
  </table>
<?php } ?>
