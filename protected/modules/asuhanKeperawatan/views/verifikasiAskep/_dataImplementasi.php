<?php // echo $form->dropDownListRow($modTandabukti, 'dengankartu', LookupM::getItems('dengankartu'), array('required' => true,'onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<div class="white-container">
	<div class="row">
		<div class="col-sm-4">
			<div class="control-group">
				<?php echo CHtml::activeHiddenField($modImplementasi, 'implementasiaskep_id', array('readonly' => true, 'class' => 'span1')); ?>
				<?php // echo CHtml::activeHiddenField($model, 'anamesa_id',array('readonly'=>true, 'class'=>'span1')); ?>
				<?php // echo CHtml::activeHiddenField($model, 'pemeriksaanfisik_id',array('readonly'=>true, 'class'=>'span1')); ?>
				<?php echo CHtml::activeLabel($modImplementasi, 'no_implementasi', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::activeTextField($modImplementasi, 'no_implementasi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="control-group">
				<?php echo CHtml::activeLabelEx($modImplementasi, 'implementasiaskep_tgl', array('class' => 'control-label inline')) ?>
				<div class="controls">
					<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $modImplementasi,
						'attribute' => 'implementasiaskep_tgl',
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
					<?php echo CHtml::activeHiddenField($modImplementasi, 'pegawai_id', array('readonly' => true)) ?>
					<?php
					$modul = ModulK::model()->findByAttributes(
							array('modul_key' => $this->module->id)
					);
					$modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '' );
					$this->widget('MyJuiAutoComplete', array(
						'name' => 'ASImplementasiaskepT[nama_pegawai]',
						'value' => isset($modImplementasi->pegawai->nama_pegawai) ? $modImplementasi->pegawai->nama_pegawai : "",
						'sourceUrl' => $this->createUrl('Pegawairiwayat'),
						'options' => array(
							'showAnim' => 'fold',
							'minLength' => 3,
							'focus' => 'js:function( event, ui ) {
                                                    $("#ASImplementasiaskepT_pegawai_id").val( ui.item.value );
                                                    $("#ASImplementasiaskepT_nama_pegawai").val( ui.item.nama_pegawai );
                                                    return false;
                                                }',
							'select' => 'js:function( event, ui ) {
                                                    $("#ASImplementasiaskepT_pegawai_id").val( ui.item.value );
                                                    return false;
                                                }',
						),
						'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 '),
						'tombolDialog' => array('idDialog' => 'dialogPegawaiImplementasi', 'idTombol' => 'tombolPasienDialog'),
					));
					?>
				</div>
			</div>
		</div>
	</div>
</div>
