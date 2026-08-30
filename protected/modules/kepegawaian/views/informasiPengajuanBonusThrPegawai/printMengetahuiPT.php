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
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>
<?php
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
}

echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>

<table bgcolor='white' class='table' style = "box-shadow:none;">
    <tr bgcolor='white'>
        <td>
             <b>Tanggal Pengajuan</b>
        </td>
        <td>
            : <?php echo MyFormatter::formatDateTimeForUser($model->tglpengajuan); ?>
        </td>
        <td>
            <b>Jenis Transaksi</b>
        </td>
        <td>: <?php echo CHtml::encode($model->jenisgaji); ?></td>
    </tr>
    <tr>
        <td>
             <b>No. Pengajuan</b>
        </td>
        <td>
            : <?php echo $model->nopengajuan; ?>
        </td>
        <td>
            <b>Keterangan</b>
        </td>
        <td>: <?php echo CHtml::encode($model->keteranganpengajuan); ?></td>

    </tr>
</table>
<br>
<?php if($model->jenisgaji == 'THR'){
  ?>
  <table id="tableObatAlkes" class="table border" bgcolor='white'>
      <thead>
          <th>No.</th>
          <th>Nama Pegawai</th>
          <th>PPh 21</th>
          <th>Status Pegawai</th>
          <th>Tanggal Masuk</th>
          <th>Gaji Pokok</th>
          <th>Tunjungan Tetap</th>
          <th>Total THR</th>
          <th>Tunjangan PPh 21</th>
          <th>Total Pajak</th>
      </thead>
       <tbody>
           <?php $no = 1; foreach ($modDetail as $item): ?>
           <tr bgcolor='white'>
             <td bgcolor='white'><?php echo $no; ?></td>
              <td bgcolor='white'><?php echo $item->pegawai->namaLengkap; ?></td>
              <td bgcolor='white'><?php echo $item->pegawai->metode_pph_21; ?></td>
              <td bgcolor='white'><?php echo $item->statuspegawai; ?></td>
              <td bgcolor='white'><?php echo MyFormatter::formatDateTimeForUser($item->tglditerima); ?></td>
              <td bgcolor='white' style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item->gajipokok); ?></td>
              <td bgcolor='white' style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item->tunjangantetap); ?></td>
              <td bgcolor='white' style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item->totalthr); ?></td>
              <td bgcolor='white' style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item->tunjangan_pph_21_thr); ?></td>
              <td bgcolor='white' style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item->totalpajak); ?></td>
           </tr>
            <?php $no++; endforeach; ?>
       </tbody>
  </table>
  <?php
}else{
  ?>
  <table id="tableObatAlkes" class="table border" bgcolor='white'>
      <thead>
          <th>No.</th>
          <th>Nama Pegawai</th>
          <th>PPh 21</th>
          <th>Status Pegawai</th>
          <th>Nilai Bonus</th>
          <th>Nilai Pajak Bonus</th>
          <th>Tunjangan PPh 21</th>
          <th>Keterangan Bonus</th>
      </thead>
       <tbody>
           <?php $no = 1; foreach ($modDetail as $item): ?>
           <tr bgcolor='white'>
             <td bgcolor='white'><?php echo $no; ?></td>
              <td bgcolor='white'><?php echo $item->pegawai->namaLengkap; ?></td>
              <td bgcolor='white'><?php echo $item->pegawai->metode_pph_21; ?></td>
              <td bgcolor='white'><?php echo $item->statuspegawai; ?></td>
              <td bgcolor='white' style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item->nilaibonus); ?></td>
              <td bgcolor='white' style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item->pajakbonus); ?></td>
              <td bgcolor='white' style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item->tunjangan_pph_21_bonus); ?></td>
              <td bgcolor='white'><?php echo $item->keteranganbonus; ?></td>
           </tr>
            <?php $no++; endforeach; ?>
       </tbody>
  </table>
  <?php
} ?>
<table style="width: 100%; border: none;">
	<tr>
		<th style="width:33%; text-align:center; padding-bottom: 50px;" colspan="2">
		<?php
		if(isset($model->tgl_mengetahui)){ ?>
			Mengetahui (RS),
			<br><br><br><br><br><br>
			( <?php echo $model->mengetahuirs->namaLengkap;?> )
		<?php } ?>
		</th>
        <th style="text-align:center; padding-bottom: 50px;" colspan="2">
		<?php
		if(isset($model->tgl_mengetahuipt)){ ?>
			Mengetahui (PT),
			<br><br><br><br><br><br>
			( <?php echo $model->mengetahuipts->namaLengkap;?> )
		<?php } ?>
		</th>
		<th style="width:33%; text-align:center; padding-bottom: 50px;" colspan="2">
			Menyetujui,
			<br><br><br><br><br><br>
			( <?php echo $model->menyetujui->namaLengkap;?> )
		</th>
	</tr>
</table>
