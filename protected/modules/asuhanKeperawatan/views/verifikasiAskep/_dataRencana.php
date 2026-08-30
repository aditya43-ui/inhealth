<?php // echo $form->dropDownListRow($modTandabukti, 'dengankartu', LookupM::getItems('dengankartu'), array('required' => true,'onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<div class="white-container">
	<div class="row">
		<div class="col-sm-4">
			<div class="control-group">
				<?php echo CHtml::activeHiddenField($modRencana, 'rencanaaskep_id',array('readonly'=>true, 'class'=>'span1')); ?>
				<?php // echo CHtml::activeHiddenField($modRencana, 'anamesa_id',array('readonly'=>true, 'class'=>'span1')); ?>
				<?php // echo CHtml::activeHiddenField($modRencana, 'pemeriksaanfisik_id',array('readonly'=>true, 'class'=>'span1')); ?>
				<?php echo CHtml::activeLabel($modRencana, 'no_rencana', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::activeTextField($modRencana, 'no_rencana', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="control-group">
				<?php echo CHtml::activeLabelEx($modRencana, 'rencanaaskep_tgl', array('class' => 'control-label inline')) ?>
				<div class="controls">
					<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $modRencana,
						'attribute' => 'rencanaaskep_tgl',
						'mode' => 'datetime',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate' => 'd',
						),
						'htmlOptions' => array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
						),
					));
					?>

				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="control-group">
				<?php 
				echo CHtml::label('Nama Pegawai', 'nama_pegawai', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::activeHiddenField($modRencana, 'pegawai_id', array('readonly' => true)) ?>
					<?php
					$modul = ModulK::model()->findByAttributes(
							array('modul_key' => $this->module->id)
					);
					$modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '' );
					$this->widget('MyJuiAutoComplete',array(
						'model'=>$modRencana,
						'name' => 'ASRencanaaskepT[nama_pegawai]',
						'value' => isset($modRencana->pegawai->nama_pegawai) ? $modRencana->pegawai->nama_pegawai : "",
						'source'=>'js: function(request, response) {
									   $.ajax({
										   url: "'.$this->createUrl('Pegawairiwayat').'",
										   dataType: "json",
										   data: {
											   term: request.term,
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
						'options'=>array(
						   'showAnim'=>'fold',
						   'minLength' => 3,
						   'focus'=> 'js:function( event, ui ) {
								$(this).val( ui.item.label);
								return false;
							}',
						   'select'=>'js:function( event, ui ) {
								$("#ASRencanaaskepT_pegawai_id").val(ui.item.pegawai_id); 
								$("#ASRencanaaskepT_nama_pegawai").val( ui.item.nama_pegawai );
								return false;
							}',

						),
						'tombolDialog'=>array("idDialog"=>'dialogPegawaiRencana','idTombol' => 'tombolRencanaDialog'),
						'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2'),
					)); ?>
				</div>
			</div>
		</div>
	</div>
</div>

