<div class = "span6">
	<div class="control-group ">
		<?php echo CHtml::label('Waktu Pemakaian Barang <span style="color:red">*</span>', '', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo CHtml::activeHiddenField($modRencanaKebBarang, 'leadtime_lt', array('readonly'=>false,'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span2 numbers-only')) ?>
			<?php echo CHtml::activeTextField($modRencanaKebBarang, 'ro_barang_bulan', array('readonly'=>false,'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span2 numbers-only')) ?> bulan
			<?php //echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i> Hitung RO',
				//	array('onclick'=>'hitungRO();return false;',
				//		  'class'=>'btn btn-primary',
				//		  'onkeyup'=>"hitungRO();",
				//		  'rel'=>"tooltip",
				//		  'title'=>"Klik untuk menghitung Recomended Order (RO)",)); ?>
		</div>
	</div>
</div>
