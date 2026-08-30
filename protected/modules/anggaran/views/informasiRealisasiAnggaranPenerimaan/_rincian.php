<?php 
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
$format = new MyFormatter();
echo "No. : <b>".$models[0]->norealisasianggpen."</b>";
echo "<br>Sumber Anggaran : <b>".$models[0]->sumberanggaran->sumberanggarannama."</b>";
?>
<table class="items table table-striped table-condensed" id="table-rencanaanggaranpengeluaran">
	<thead>
		<tr>
			<th>No.</th>
			<th>Termin ke-</th>
			<th>Tanggal Realisasi Penerimaan</th>
			<th>Nilai Anggaran</th>
			<th>Nilai Realisasi</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$total_nilai = 0;
		$total_realisasi = 0;
		foreach($models as $i => $modDetail){
		?>
		<tr>
				<td><?php echo $i+1; echo ". "; ?></td>
				<td style="text-align: right;"><?php echo $modDetail->penerimaanke; ?></td>
				<td><?php echo $format->formatDateTimeId($modDetail->tglrealisasianggpen); ?></td>
				<td style="text-align: right;"><?php echo $format->formatUang($modDetail->nilaipenerimaan); ?></td>
				<td style="text-align: right;"><?php echo $format->formatUang($modDetail->realisasipenerimaan); ?></td>
				<?php
				$total_nilai += $modDetail->nilaipenerimaan;
				$total_realisasi += $modDetail->realisasipenerimaan;
				?>
		</tr>
		<?php } ?>
		<tfoot>
			<tr>
				<td colspan="3" style="text-align:right;"><b>Total Anggaran</b></td>
				<td style="text-align: right;">
					<b><?php echo $format->formatUang($total_nilai) ?></b>
				</td>
				<td style="text-align: right;">
					<b><?php echo $format->formatUang($total_realisasi) ?></b>
				</td>
			</tr>
		</tfoot>
	</tbody>
</table>
<?php // if (!empty($models[0]->renpen_tglmengetahui) && !empty($models[0]->renpen_tglmenyetujui)){ ?>
<!--	<div class="row">
		<div class="col-sm-6" style="text-align:center;">
			<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
				 Mengetahui,
			</div>	
			<div class="control-group">-->
				<!--( <?php // echo $models[0]->mengetahui->nama_pegawai;?> )-->
<!--			</div>	
		</div>
		<div class="col-sm-6" style="text-align:center;">
			<div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
				Menyetujui,
			</div>
			<div class="control-group">-->
				<!--( <?php // echo $models[0]->menyetujui->nama_pegawai;?> )-->
<!--			</div>
		</div>
	</div>-->
<?php // } ?>
<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    $urlPrint= $this->createUrl('printRincian',array('norealisasianggpen'=>$models[0]->norealisasianggpen));
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