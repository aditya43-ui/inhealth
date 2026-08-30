<div class="row">
	<div class="col-sm-4">
		<fieldset class="box">
			<legend class="rim">Pola Eliminasi</legend>
			<div class="control-group">
				<?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_frekbab', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($modPengkajian, 'pengkajianaskep_frekbab', array( 'class' => 'span3 numbersOnly integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_keluhanbab', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->textArea($modPengkajian, 'pengkajianaskep_keluhanbab', array( 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_frekbak', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($modPengkajian, 'pengkajianaskep_frekbak', array( 'class' => 'span3 numbersOnly integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_keluhanbak', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->textArea($modPengkajian, 'pengkajianaskep_keluhanbak', array( 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="col-sm-4">
		<fieldset class="box">
			<legend class="rim">Pola Aktifitas, Istirahat / Tidur</legend>
			<div class="control-group">
				<?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_aktsehari', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
				<div class="controls">  
					<?php echo CHtml::activeRadioButtonList($modPengkajian,'pengkajianaskep_aktsehari', array('Dibantu' => 'Dibantu','Dilakukan Sendiri' => 'Dilakukan Sendiri')); ?>
					<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_aktsehari', array('value' => 'Dibantu')); ?> 
					<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_aktsehari', array('value' => 'Dilakukan Sendiri')); ?>                                
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_keluhanakt', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->textArea($modPengkajian, 'pengkajianaskep_keluhanakt', array( 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_polatidur', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>

				<div class="controls"> 
					<?php echo CHtml::activeRadioButtonList($modPengkajian,'pengkajianaskep_polatidur', array('Pagi' => 'Pagi','Siang' => 'Siang','Malam' => 'Malam')); ?>
<!--					<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_polatidur', array('value' => 'Pagi')); ?> Pagi
					<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_polatidur', array('value' => 'Siang')); ?> Siang
					<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_polatidur', array('value' => 'Malam')); ?> Malam-->
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_keluhanpolatid', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->textArea($modPengkajian, 'pengkajianaskep_keluhanpolatid', array( 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="col-sm-4">
		<fieldset class="box">
			<legend class="rim">Pola Kebersihan Diri</legend>
			<div class="row">
				<div class="col-sm-6">
					<div class="control-group">
						<?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_kulit', array('class' => 'control-label','style'=>'width:auto;' , 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
						<div class="controls"> 
							<?php echo CHtml::activeRadioButtonList($modPengkajian,'pengkajianaskep_kulit', array('Normal' => 'Normal','Tidak Normal' => 'Tidak Normal')); ?>
							<!--<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_kulit', array('value' => 'Normal')); ?> Normal 
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_kulit', array('value' => 'Tidak Normal')); ?> Tidak Normal-->                             
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="control-group">
						<?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_mulut', array('class' => 'control-label', 'style'=>'width:auto;','onkeypress' => "return $(this).focusNextInputField(event);")) ?>
						<div class="controls">  
							<?php echo CHtml::activeRadioButtonList($modPengkajian,'pengkajianaskep_mulut', array('Bersih' => 'Bersih','Tidak Bersih' => 'Tidak Bersih')); ?>
						<!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_mulut', array('value' => 'Bersih')); ?> Bersih <br>
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_mulut', array('value' => 'Tidak Bersih')); ?> Tidak Bersih-->                           
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="control-group">
						<?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_rambut', array('class' => 'control-label', 'style'=>'width:auto;','onkeypress' => "return $(this).focusNextInputField(event);")) ?>
						<div class="controls">  
							<?php echo CHtml::activeRadioButtonList($modPengkajian,'pengkajianaskep_rambut', array('Bersih' => 'Bersih','Tidak Bersih' => 'Tidak Bersih')); ?>
						<!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_rambut', array('value' => 'Bersih')); ?> Bersih <br>
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_rambut', array('value' => 'Tidak Bersih')); ?> Tidak Bersih-->                       
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="control-group">
						<?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_genitalia', array('class' => 'control-label', 'style'=>'width:auto;','onkeypress' => "return $(this).focusNextInputField(event);")) ?>
						<div class="controls">  
							<?php echo CHtml::activeRadioButtonList($modPengkajian,'pengkajianaskep_genitalia', array('Bersih' => 'Bersih','Tidak Bersih' => 'Tidak Bersih')); ?>
						<!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_genitalia', array('value' => 'Bersih')); ?> Bersih <br>
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_genitalia', array('value' => 'Tidak Bersih')); ?> Tidak Bersih-->                          
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="control-group">
						<?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_telinga', array('class' => 'control-label', 'style'=>'width:auto;','onkeypress' => "return $(this).focusNextInputField(event);")) ?>
						<div class="controls">  
							<?php echo CHtml::activeRadioButtonList($modPengkajian,'pengkajianaskep_telinga', array('Bersih' => 'Bersih','Tidak Bersih' => 'Tidak Bersih')); ?>
						<!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_telinga', array('value' => 'Bersih')); ?> Bersih <br>
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_telinga', array('value' => 'Tidak Bersih')); ?> Tidak Bersih-->                    
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="control-group">
						<?php echo $form->labelEx($modPengkajian, 'pengkajianaskep_kuku', array('class' => 'control-label', 'style'=>'width:auto;','onkeypress' => "return $(this).focusNextInputField(event);")) ?>
						<div class="controls">  
							<?php echo CHtml::activeRadioButtonList($modPengkajian,'pengkajianaskep_kuku', array('Bersih' => 'Bersih','Tidak Bersih' => 'Tidak Bersih')); ?>
						<!--	<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_kuku', array('value' => 'Bersih')); ?> Bersih <br>
							<?php // echo CHtml::activeRadioButton($modPengkajian,'pengkajianaskep_kuku', array('value' => 'Tidak Bersih')); ?> Tidak Bersih-->                           
						</div>
					</div>
				</div>
			</div>
		</fieldset>
	</div>
</div>
<div class="row">
	<div class="col-sm-4">
		<fieldset class="box">
			<legend class="rim">Pola Seksualitas</legend>
			<div class="control-group">
				<?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_seksualitas', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->textArea($modPengkajian, 'pengkajianaskep_seksualitas', array( 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="col-sm-6">
		<fieldset class="box">
			<legend class="rim">Aspek Psikologis</legend>
			<div class="control-group">
				<?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_perspenyakit', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($modPengkajian, 'pengkajianaskep_perspenyakit', array( 'class' => 'span5', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_perssembuh', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($modPengkajian, 'pengkajianaskep_perssembuh', array( 'class' => 'span5', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_ekswajah', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($modPengkajian, 'pengkajianaskep_ekswajah', array( 'class' => 'span5', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_intelektual', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($modPengkajian, 'pengkajianaskep_intelektual', array( 'class' => 'span5', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::activeLabel($modPengkajian, 'pengkajianaskep_koping', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($modPengkajian, 'pengkajianaskep_koping', array( 'class' => 'span5', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
		</fieldset>
	</div>
</div>