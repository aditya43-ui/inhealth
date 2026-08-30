<?php 
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
 
$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Status menyetujui berhasil disimpan!");
}

$this->widget('bootstrap.widgets.BootAlert'); 
echo "NO &nbsp;: <b>".$model->rencanggaranpeng_no."</b>";
echo "<br>Unit : <b>".$model->unitkerja->namaunitkerja."</b>";
?>
<table class="items table table-striped table-condensed" id="table-rencanaanggaranpengeluaran">
	<thead>
		<tr>
			<th>No.</th>
			<th>Kode Program</th>
			<th>Kode Sub Program</th>
			<th>Kode Kegiatan</th>
			<th>Kode Sub Kegiatan</th>
			<th>Program Kerja</th>
			<th>Bulan</th>
			<th>Nilai</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$kerangkaloop = count((array)$modPrograms['programkerja_kode']);
		for($i = 0; $i < $kerangkaloop; ++$i) {
		?>
		<tr>
				<td><?php echo $i+1; echo ". "; ?></td>
				<td><?php echo $modPrograms['programkerja_kode'][$i]; ?></td>
				<td><?php echo $modPrograms['subprogramkerja_kode'][$i]; ?></td>
				<td><?php echo $modPrograms['kegiatanprogram_kode'][$i]; ?></td>
				<td><?php echo $modPrograms['subkegiatanprogram_kode'][$i]; ?></td>
				<td><?php echo $modPrograms['subkegiatanprogram_nama'][$i]; ?></td>
				<td><?php echo $format->formatMonthForUser($detail['tglrencanapengdet'][$i]); ?></td>
				<td style="text-align: right;"><?php echo $format->formatNumberForPrint($detail['nilairencpengeluaran'][$i]); ?></td>
		</tr>
		<?php } ?>
		<tfoot>
			<tr>
				<td colspan="7" style="text-align:right;">Total Anggaran</td>
				<td style="text-align: right;">
					<?php echo $format->formatNumberForPrint($model->total_nilairencpeng) ?>
				</td>
			</tr>
		</tfoot>
	</tbody>
</table>
<div class="row">
	<div class="col-sm-6" style="text-align:center;">
		&nbsp;
	</div>
	<div class="col-sm-6" style="text-align:center;">
		<div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
			<?php 
			if(isset($_GET['sukses'])){
				echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
				echo "Menyetujui,";
			}else{
				echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
				echo CHtml::link(Yii::t('mds',' Menyetujui'), 
				$this->createUrl($this->id.'/index'), 
				array('class' => 'btn btn-danger',
					'onclick'=>'myConfirm("Apakah Anda yakin?","Perhatian!",
					function(r) {if(r) window.location = "'.$this->createUrl('Menyetujui',array('rencanggaranpeng_id'=>$model->rencanggaranpeng_id,'menyetujui_id'=>$model->menyetujui_id)).'";} ); return false;'));  
			}
			?>
		</div>
	</div>
		<div class="control-group">
			( <?php echo $model->menyetujui->nama_pegawai;?> )
		</div>
	</div>
</div>
<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    $urlPrint= $this->createUrl('printMenyetujui',array('rencanggaranpeng_id'=>$model->rencanggaranpeng_id));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}"+$('#inforencanapeng-form').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
    ?>