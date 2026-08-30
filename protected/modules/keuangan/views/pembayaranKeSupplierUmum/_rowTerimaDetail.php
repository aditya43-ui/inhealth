<tr>
	<td>
		<?php echo $detail->barang->barang_nama; ?>
	</td>
	<!--<td>
		<?php //echo ; ?>
	</td>-->
	<td style = "text-align:right;">
		<?php echo number_format($detail->jmlterima,0,"",".").' '.$detail->satuanbeli; ?>
	</td>
	<td style = "text-align:right;">
		<?php echo number_format($detail->hargasatuan,0,"","."); ?>
	</td>
	<td style = "text-align:right;">
		<?php echo number_format($detail->hargabeli,0,"","."); ?>
	</td>
	<td style = "text-align:right;">
		<?php echo number_format($detail->hargabeli,0,"","."); ?>
	</td>
</tr>