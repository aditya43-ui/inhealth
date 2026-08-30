<?php 
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));

echo "NO : <b>".$model->noren_penerimaan."</b>";
echo "<br>Sumber Anggaran : <b>".$model->sumberanggaran->sumberanggarannama."</b>";
?>
<table class="items table table-striped table-condensed" id="table-rencanaanggaranpengeluaran">
	<thead>
		<tr>
			<th>No.</th>
			<th>Termin ke-</th>
			<th>Tanggal Penerimaan</th>
			<th>Nilai Anggaran</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach($modDetails as $i => $modDetail){
		?>
		<tr>
				<td><?php echo $i+1; echo ". "; ?></td>
				<td style="text-align: right"><?php echo $modDetail->renanggaran_ke; ?></td>
				<td><?php echo $format->formatMonthForUser($modDetail->tglrenanggaranpen); ?></td>
				<td style="text-align: right"><?php echo $format->formatNumberForPrint($modDetail->nilaipenerimaan); ?></td>
		</tr>
		<?php } ?>
		<tfoot>
			<tr>
				<td colspan="3" style="text-align:right;">Total Anggaran</td>
				<td style="text-align: right">
					<?php echo $format->formatNumberForPrint($model->total_renanggaranpen) ?>
				</td>
			</tr>
		</tfoot>
	</tbody>
</table>

<?php if (!empty($model->renpen_tglmengetahui) && !empty($model->renpen_tglmenyetujui)){ ?>
	<div class="row">
		<div class="col-sm-6" style="text-align:center;">
			<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
				 Mengetahui,
			</div>	
			<div class="control-group">
				( <?php echo $model->mengetahui->nama_pegawai;?> )
			</div>	
		</div>
		<div class="col-sm-6" style="text-align:center;">
			<div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
				Menyetujui,
			</div>
			<div class="control-group">
				( <?php echo $model->menyetujui->nama_pegawai;?> )
			</div>
		</div>
	</div>
<?php } ?>
<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    $urlPrint= $this->createUrl('printRincian',array('renanggpenerimaan_id'=>$model->renanggpenerimaan_id));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}"+$('#inforencanapen-form').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
    ?>