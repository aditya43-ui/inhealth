<div class="row-fluid">
	<div class="span6">
		<?php 
		echo $form->textFieldRow($modPascaAnestesi, 'nopascaanestesi', array(
			'class'		 => 'span3', 'readonly'=>true,
			'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength'=> 100));
		?>
		<div class="control-group ">
			<?php echo $form->hiddenField($modPascaAnestesi, 'pasienanastesi_id'); ?>
				<?php echo $form->hiddenField($modPascaAnestesi, 'intraanestesi_id'); ?>
				<?php echo $form->labelEx($modPascaAnestesi, 'tglpascaanestesi', array(
					'class' => 'control-label')) ?>
			<div class="controls">  
				<?php
				$modPascaAnestesi->tglpascaanestesi = (!empty($modPascaAnestesi->tglpascaanestesi) ? date("d/m/Y H:i:s", strtotime($modPascaAnestesi->tglpascaanestesi)) : date("d/m/Y H:i:s"));
				$this->widget('MyDateTimePicker', array(
					'model'			 => $modPascaAnestesi,
					'attribute'		 => 'tglpascaanestesi',
					'mode'			 => 'datetime',
					'options'		 => array(
						'dateFormat' => Params::DATE_FORMAT,
						'maxDate'	 => 'd',
					),
					'htmlOptions'	 => array('readonly'	 => true, 'class'		 => 'dtPicker2 datetimemask	',
						'onkeypress' => "return $(this).focusNextInputField(event)"),
				));
				?>
			</div>
		</div>
		<div class="control-group ">
				<?php echo CHtml::activelabel($modPraAnestesi, 'Dokter Anestesi<font style="color:red;">*</font>', array(
					'class' => 'control-label required'))
				?>
			<div class="controls">
				<?php
				echo $form->dropDownList($modPraAnestesi, 'dokter_id', CHtml::listData($modPraAnestesi->DokterItems, 'pegawai.pegawai_id', 'pegawai.NamaLengkap'), array(
					'empty'		 => '-- Pilih --', 'class'		 => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
					'maxlength'	 => 100));
				?>
			</div>
		</div>
			
	</div>
	<div class="span6">
            <div class="control-group ">
			<?php echo $form->label($modPraAnestesi, 'perawat1_id', array('class' => 'control-label')) ?>
			<div class="controls">
			<?php
			echo $form->dropDownList($modPraAnestesi, 'perawat1_id', CHtml::listData($modPraAnestesi->ParamedisItems, 'pegawai.pegawai_id', 'pegawai.NamaLengkap'), array(
				'empty'		 => '-- Pilih --', 'class'		 => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
				'maxlength'	 => 100));
			?>
			</div>
		</div>
		<div class="control-group ">
		<?php echo $form->label($modPraAnestesi, 'perawat2_id', array('class' => 'control-label')) ?>
			<div class="controls">
		<?php
		echo $form->dropDownList($modPraAnestesi, 'perawat2_id', CHtml::listData($modPraAnestesi->ParamedisItems, 'pegawai.pegawai_id', 'pegawai.NamaLengkap'), array(
			'empty'		 => '-- Pilih --', 'class'		 => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
			'maxlength'	 => 100));
		?>
			</div>
		</div>
<?php

echo $form->textAreaRow($modPascaAnestesi, 'komplikasi', array('class'		 => 'span3' , 'placeholder'=>'Ketik Komplikasi',
	'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength'	 => 100));
?>
	</div>
</div>