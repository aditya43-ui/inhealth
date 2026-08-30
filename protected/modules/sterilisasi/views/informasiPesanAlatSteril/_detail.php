<?php 
echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>
<table class="items table table-striped table-condensed" id="table-rencanaanggaranpengeluaran">
	<thead>
		<tr>
			<th>No.</th>
			<th>No. Pemesanan</th>
			<th>Nama Peralatan dan Linen</th>
			<th>Jumlah</th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<?php if(count((array)$modDetails)>0){ ?>
		<tbody>
			<?php 
			$total_jumlah = 0;
			$disabled = false;
			foreach ($modDetails as $i => $detail) {?>
				<tr>
						<td><?php echo $i+1; echo ". "; ?></td>
						<td><?php echo $detail->pesan->pesanperlinensteril_no; ?></td>
						<td><?php echo isset($detail->linen_id) ? $detail->linen->namalinen : $detail->barang->barang_nama ; ?></td>
						<td><?php echo $detail->pesanperlinensterildet_jml; ?></td>
						<td><?php echo $detail->pesanperlinensterildet_ket; ?></td>
						<?php $total_jumlah += $detail->pesanperlinensterildet_jml;?>
				</tr>
				<?php } ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="3" style="text-align:right;">Total</td>
				<td>
					<?php echo $total_jumlah; ?>
				</td>
			</tr>
		</tfoot>
	<?php }else{ $disabled = true; ?>
		<tbody>
			<tr>
				<th colspan="8"><i>Data tidak ditemukan</i></th>
			</tr>
		</tbody>
	<?php } ?>
	
</table>
	<div class="row">
		<div class="col-sm-6" style="text-align:center;">
			<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>
				 Mengetahui,
			</div>	
			<div class="control-group">
				( <?php echo isset($model->pegmengetahui_id) ? $model->pegawaiMengetahui->nama_pegawai : "-";?> )
			</div>	
		</div>
		<div class="col-sm-6" style="text-align:center;">
			<div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
				Memesan,
			</div>
			<div class="control-group">
				( <?php echo $model->pegawaiMemesan->nama_pegawai;?> )
			</div>
		</div>
	</div>
<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>$disabled, 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'disabled'=>$disabled, 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'disabled'=>$disabled, 'type'=>'button','onclick'=>'print(\'PDF\')')); 
?>
<script type="text/javascript">
function print(caraPrint)
{
    var pesanperlinensteril_id = '<?php echo isset($_GET['pesanperlinensteril_id']) ? $_GET['pesanperlinensteril_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('printDetail'); ?>&pesanperlinensteril_id='+pesanperlinensteril_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
</script>