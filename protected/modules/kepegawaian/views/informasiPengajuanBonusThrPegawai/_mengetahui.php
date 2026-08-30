<style>
    .uang {
        text-align: right !important;
    }
</style>

<?php
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));

$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Status Mengetahui berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
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


<div class="row">
	<div class="col-sm-4" style="text-align:center;">
			<?php
			if(isset($_GET['sukses'])){
				echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
				echo "Mengetahui (RS),";
			}else{
				echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
				if($model->mengetahuirs_id == Yii::app()->user->getState('pegawai_id')){
                                    echo CHtml::link(Yii::t('mds',' Mengetahui (RS)'),
                                    $this->createUrl($this->id.'/index'),
                                    array('class' => 'btn btn-danger',
                                            'onclick'=>'myConfirm("Apakah Anda yakin?","Perhatian!",
                                            function(r) {if(r) window.location = "'.$this->createUrl('ApproveMengetahui',array('pengbonusthr_id'=>$model->pengbonusthr_id,'approve'=>true)).'";} ); return false;'));
                                }
                                else{
                                    echo CHtml::link(Yii::t('mds',' Mengetahui (RS)'),
                                    $this->createUrl($this->id.'/index'),
                                    array('class' => 'btn btn-danger',
                                            'onclick'=>'myAlert("Maaf, Anda tidak berhak Mengapprove Pegawai Mengetahui ini?"); return false;'));
                                }
			}
			?>
		</div>
		<div class="control-group">
			( <?php echo (isset($model->mengetahuirs)?$model->mengetahuirs->namaLengkap:"");?> )
		</div>
	</div>
	<div class="col-sm-4" style="text-align:center;">

	</div>
	<div class="col-sm-4" style="text-align:center;">

	</div>
</div>

<?php
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'));
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')'));
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')'));
    $urlPrint= $this->createUrl('printApproveMengetahui',array('pengbonusthr_id'=>$model->pengbonusthr_id));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
    ?>
