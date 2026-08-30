<?php
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xlsx"');
    header('Cache-Control: max-age=0');     
}
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
$format = new MyFormatter;
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judul_print, 'colspan'=>9));      
?>
<p>&nbsp;</p>
<table class="table border" border="1">
	<tr>
		<th bgcolor="#149900">Tanggal Pengajuan</th>
		<th bgcolor="#149900">No. Pengajuan</th>
		<th bgcolor="#149900">Yang Mengajukan</th>
		<th bgcolor="#149900">Divisi</th>
		<th bgcolor="#149900">Untuk Pengajuan Pembelian</th>
		<th bgcolor="#149900">Nama Barang/ Nama Perusahaan</th>
		<th bgcolor="#149900">Qty</th>
		<th bgcolor="#149900">Harga Satuan</th>
		<th bgcolor="#149900">Subtotal</th>
	</tr>	
	<?php
		foreach ($data as $dt){
			$count = count((array)$dt['nopengajuan']);
			
			$i  = 1;
			$total = 0;
			foreach ($dt['nopengajuan'] as $dt2){
				$total = $total + $dt2['subtotal'];
	?>
				<tr>
					<td><?php echo ($i == 1 )?$dt['tgl']:''; ?></td>
					<td><?php echo ($i == 1 )?$dt['no']:''; ?></td>
					<td><?php echo ($i == 1 )?$dt['nama']:''; ?></td>
					<td><?php echo ($i == 1 )?$dt['unit']:''; ?></td>
					<td><?php echo ($i == 1 )?$dt['untuk']:''; ?></td>
					<td><?php echo $dt2['item'] ?></td>
					<td><?php echo $dt2['qty'] ?></td>
					<td style="text-align: right;" align="right"><?php echo '="'.number_format($dt2['hargasatuan'],0,"",".").'"' ?></td>
					<td style="text-align: right;" align="right"><?php echo '="'.number_format($dt2['subtotal'],0,"",".").'"' ?></td>
				</tr>
	<?php
				$i++;
			}
	?>
				<tr>
					<th colspan="8" style="text-align:right;" align="right">
						Total
					</th>
					<th  style="text-align:right;" align="right">
						<?php echo '="'.number_format($total,0,"",".").'"'; ?>
					</th>
				</tr>
			
	<?php
		}
	?>
</table>