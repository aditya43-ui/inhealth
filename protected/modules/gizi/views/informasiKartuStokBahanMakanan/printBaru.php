<style>
   @page {
      margin-top: 12mm;
   }

   @media print {
      #headers {
         position: fixed;
         top: 0;
      }

      body {
         display: table;
         table-layout: fixed;
         padding-top: 4cm;
         padding-left: 1mm;
         height: auto;
         width: 100%;
      }
   }
</style>

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');

if ($caraPrint == 'EXCEL') {
   header('Content-Type: application/vnd.ms-excel');
   header('Content-Disposition: attachment;filename="Stok Kartu-' . date("Y/m/d") . '.xls"');
   header('Cache-Control: max-age=0');
}

if ($caraPrint != 'PDF') {
   echo "<div id='headers'>";
   echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF', array('judulLaporan' => 'Stok Kartu',  'periode' => $periode, 'colspan' => 10));
   echo '</div>';
}
?>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
   <tr>
      <td width="10%">Kelompok</td>
      <td width="15%">: <?php echo $model->kelbahanmakanan; ?></td>
      <td width="10%">Nama</td>
      <td width="15%">: <?php echo $model->namabahanmakanan; ?></td>
   </tr>
   <tr>
      <td>Jenis</td>
      <td>: <?php echo $model->jenisbahanmakanan; ?></td>
      <td>Satuan</td>
      <td>: <?php echo $model->satuanbahan; ?></td>
   </tr>
</table>
<br>
<?php
$this->renderPartial($this->path_view . '_tableBaruPrint', array(
   'model2' => $model2,
   'caraPrint' => $caraPrint,
   // 'pilihTgl' => $pilihTgl
));
?>