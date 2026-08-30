<tr>
	<td>Total Keseluruhan
	<?php echo CHtml::hiddenField('totalsetoran', $item['total']); ?>
	</td>
	<td style="text-align: right"><?php echo $item['jml_pasien'][Params::STATUSPASIEN_LAMA]; ?></td>
	<td style="text-align: right"><?php echo $item['jml_pasien'][Params::STATUSPASIEN_BARU]; ?></td>
	
	<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item['retribusi'][Params::STATUSPASIEN_LAMA]); ?></td>
	<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item['retribusi'][Params::STATUSPASIEN_BARU]); ?></td>
	
	<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item['jasa_medis'][Params::STATUSPASIEN_LAMA]); ?></td>
	<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item['jasa_medis'][Params::STATUSPASIEN_BARU]); ?></td>
	
	<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item['jasa_paramedis'][Params::STATUSPASIEN_LAMA]); ?></td>
	<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item['jasa_paramedis'][Params::STATUSPASIEN_BARU]); ?></td>
	
	<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item['administrasi'][Params::STATUSPASIEN_LAMA]); ?></td>
	<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item['administrasi'][Params::STATUSPASIEN_BARU]); ?></td>
	
	<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item['jumlah'][Params::STATUSPASIEN_LAMA]); ?></td>
	<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item['jumlah'][Params::STATUSPASIEN_BARU]); ?></td>
	
	<td style="text-align: right"><?php echo MyFormatter::formatNumberForPrint($item['total']); ?></td>
</tr>