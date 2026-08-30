<?php // echo $form->dropDownListRow($modTandabukti, 'dengankartu', LookupM::getItems('dengankartu'), array('required' => true,'onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<div class="white-container">
	<div class="row">
		<div class="col-sm-4">
			<div class="control-group">
				<?php echo CHtml::activeHiddenField($modEvaluasi, 'evaluasiaskep_id', array('readonly' => true, 'class' => 'span1')); ?>
				<?php // echo CHtml::activeHiddenField($model, 'pemeriksaanfisik_id',array('readonly'=>true, 'class'=>'span1')); ?>
				<?php echo CHtml::activeLabel($modEvaluasi, 'no_evaluasi', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::activeTextField($modEvaluasi, 'no_evaluasi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="control-group">
				<?php echo CHtml::activeLabelEx($modEvaluasi, 'evaluasiaskep_tgl', array('class' => 'control-label inline')) ?>
				<div class="controls">
					<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $modEvaluasi,
						'attribute' => 'evaluasiaskep_tgl',
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
				<?php echo CHtml::label('Nama Pegawai', 'nama_pegawai', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::activeHiddenField($modEvaluasi, 'pegawai_id', array('readonly' => true)) ?>
					<?php
					$modul = ModulK::model()->findByAttributes(
							array('modul_key' => $this->module->id)
					);
					$modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '' );
					$this->widget('MyJuiAutoComplete', array(
						'name' => 'ASEvaluasiaskepT[nama_pegawai]',
						'value' => isset($modEvaluasi->pegawai->nama_pegawai) ? $modEvaluasi->pegawai->nama_pegawai : "",
						'sourceUrl' => $this->createUrl('Pegawairiwayat'),
						'options' => array(
							'showAnim' => 'fold',
							'minLength' => 3,
							'focus' => 'js:function( event, ui ) {
                                                    $("#ASEvaluasiaskepT_pegawai_id").val( ui.item.value );
                                                    $("#ASEvaluasiaskepT_nama_pegawai").val( ui.item.nama_pegawai );
                                                    return false;
                                                }',
							'select' => 'js:function( event, ui ) {
                                                    $("#ASEvaluasiaskepT_pegawai_id").val( ui.item.value );
                                                    return false;
                                                }',
						),
						'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 '),
						'tombolDialog' => array('idDialog' => 'dialogPegawaiEvaluasi', 'idTombol' => 'tombolPasienDialog'),
					));
					?>
				</div>
			</div>
		</div>
	</div>
</div>
