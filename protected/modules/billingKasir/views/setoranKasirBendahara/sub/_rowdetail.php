<tr>
	<td>
		<?php echo $item['ruangan_nama']; ?>
		<?php echo CHtml::hiddenField('detail['.$idx.'][jml_pasien_l]', $item['jml_pasien'][Params::STATUSPASIEN_LAMA]); ?>
		<?php echo CHtml::hiddenField('detail['.$idx.'][jml_pasien_p]', $item['jml_pasien'][Params::STATUSPASIEN_BARU]); ?>
	
		<?php echo CHtml::hiddenField('detail['.$idx.'][jml_retirbusi_pl]', $item['retribusi'][Params::STATUSPASIEN_LAMA]); ?>
		<?php echo CHtml::hiddenField('detail['.$idx.'][jml_retirbusi_pb]', $item['retribusi'][Params::STATUSPASIEN_BARU]); ?>
		
		<?php echo CHtml::hiddenField('detail['.$idx.'][jml_jasamedis_pl]', $item['jasa_medis'][Params::STATUSPASIEN_LAMA]); ?>
		<?php echo CHtml::hiddenField('detail['.$idx.'][jml_jasamedis_pb]', $item['jasa_medis'][Params::STATUSPASIEN_BARU]); ?>
		
		<?php echo CHtml::hiddenField('detail['.$idx.'][jml_paramedis_pl]', $item['jasa_paramedis'][Params::STATUSPASIEN_LAMA]); ?>
		<?php echo CHtml::hiddenField('detail['.$idx.'][jml_paramedis_pb]', $item['jasa_paramedis'][Params::STATUSPASIEN_BARU]); ?>
		
		<?php echo CHtml::hiddenField('detail['.$idx.'][jml_administrasi_pl]', $item['administrasi'][Params::STATUSPASIEN_LAMA]); ?>
		<?php echo CHtml::hiddenField('detail['.$idx.'][jml_administrasi_pb]', $item['administrasi'][Params::STATUSPASIEN_BARU]); ?>
		
		<?php echo CHtml::hiddenField('detail['.$idx.'][jml_setoran_pl]', $item['jumlah'][Params::STATUSPASIEN_LAMA]); ?>
		<?php echo CHtml::hiddenField('detail['.$idx.'][jml_setoran_pb]', $item['jumlah'][Params::STATUSPASIEN_BARU]); ?>
		
		<?php echo CHtml::hiddenField('detail['.$idx.'][totsetkasirruangan]', $item['total']); ?>
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