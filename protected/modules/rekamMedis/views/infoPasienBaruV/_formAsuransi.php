<table>
		<tr>
			<td><?php echo CHtml::activeLabel($modAsuransiPasien,'nopeserta', array('label'=>'No. Peserta <span class="required">*</span>','class'=>'control-label')) ?></td>
			<td>: 
				<?php echo CHtml::activeHiddenField($modAsuransiPasien, 'asuransipasien_id',array('readonly'=>true))?>
				<?php echo CHtml::activeTextField($modAsuransiPasien, 'nopeserta',array('class'=>'span3 required','onkeyup'=>"return $(this).focusNextInputField(event)"))?>
			</td>
		</tr>
		<tr>
			<td><?php echo CHtml::activeLabel($modAsuransiPasien,'nokartuasuransi', array('class'=>'control-label')) ?></td>
			<td>: <?php echo CHtml::activeTextField($modAsuransiPasien, 'nokartuasuransi',array('Placeholder'=>'Jika beda dgn No. Peserta','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)"))?> </td>
		</tr>
		<tr>
			<td><?php echo CHtml::activeLabel($modAsuransiPasien,'namapemilikasuransi', array('label'=>'Nama Pemilik Asuransi <span class="required">*</span>','class'=>'control-label')) ?></td>
			<td>: <?php echo CHtml::activeTextField($modAsuransiPasien, 'namapemilikasuransi',array('class'=>'span3 required','onkeyup'=>"return $(this).focusNextInputField(event)"))?> </td>
		</tr>
		<tr>
			<td><?php echo CHtml::activeLabel($modAsuransiPasien,'nomorpokokperusahaan', array('class'=>'control-label')) ?></td>
			<td>: <?php echo CHtml::activeTextField($modAsuransiPasien, 'nomorpokokperusahaan',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)"))?> </td>
		</tr>
		<tr>
			<td><?php echo CHtml::activeLabel($modAsuransiPasien,'namaperusahaan', array('class'=>'control-label')) ?></td>
			<td>: <?php echo CHtml::activeTextField($modAsuransiPasien, 'namaperusahaan',array('Placeholder'=>'Jika beda dgn Penjamin','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)"))?> </td>
		</tr>
		<tr>
			<td><?php echo CHtml::activeLabel($modAsuransiPasien,'kelastanggunganasuransi_id', array('label'=>'Kelas Tanggungan <span class="required">*</span>','class'=>'control-label')) ?></td>
			<td>: <?php echo CHtml::activeDropDownList($modAsuransiPasien, 'kelastanggunganasuransi_id',CHtml::listData(RKKelaspelayananM::model()->getItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'),array('empty'=>'-- Pilih --','class'=>'span3 required','onkeyup'=>"return $(this).focusNextInputField(event)"))?> </td>
		</tr>
		<tr>
			<td><?php echo CHtml::activeLabel($modAsuransiPasien,'status_konfirmasi', array('class'=>'control-label')) ?></td>
			<td>: 
				<?php echo CHtml::activeCheckbox($modAsuransiPasien, 'status_konfirmasi',array('onclick'=>'defaultTanggalKonfirmasi();','onkeyup'=>"return $(this).focusNextInputField(event)"))?> 
				<?php   
					$modAsuransiPasien->tgl_konfirmasi = (!empty($modAsuransiPasien->tgl_konfirmasi) ? date("d/m/Y H:i:s",strtotime($modAsuransiPasien->tgl_konfirmasi)) : null);
					echo CHtml::activeTextField($modAsuransiPasien, 'tgl_konfirmasi',array('placeholder'=>'00/00/0000 00:00:00','class'=>'span3 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"))
				?> 
			</td>
		</tr>
</table>
