<?php
$this->breadcrumbs = array(
    'Anamnesis',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjpemeriksaan-fisik-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#RJPemeriksaanFisikT_detaknadi',
        ));
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.taggd.js'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/taggd.css'); ?>
<style>
    .groupUkurans{
        display:inline;
    }
</style>

<?php echo $form->errorSummary($modPemeriksaanFisik); ?>

<div class="row">
    <div class="col-sm-4">
		<div class="control-group">
			<?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
            <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
			<?php echo $form->labelEx($modPemeriksaanFisik, 'Tanggal Pemeriksaan', array('class' => 'control-label')) ?>
			<div class="controls">  
				<?php
				$this->widget('MyDateTimePicker', array(
					'model' => $modPemeriksaanFisik,
					'attribute' => 'tglperiksafisik',
					'mode' => 'datetime',
					'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3',
						'onkeypress' => "return $(this).focusNextInputField(event)"),
				));
				?>
			</div>
		</div>
	</div>
    <div class="col-sm-4">
		<?php echo $form->dropDownListRow($modPemeriksaanFisik, 'pegawai_id', CHtml::listData($modPemeriksaanFisik->getDokterItems($modPendaftaran->ruangan_id), 'pegawai_id', 'NamaLengkap'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
	</div>
    <div class="col-sm-4">
		<?php echo $form->dropDownListRow($modPemeriksaanFisik, 'paramedis_nama', CHtml::listData($modPemeriksaanFisik->ParamedisItems, 'pegawai.nama_pegawai', 'pegawai.NamaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
	</div>
</div>
<div class="row">
    <div class="col-sm-4">
		<fieldset class="box">
            <legend class="rim">Kebiasaan</legend>
            <legend><h4>Tanda Vital</h4></legend>
			<div class="control-group">
                <?php echo $form->labelEx($modPemeriksaanFisik, 'Nadi', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($modPemeriksaanFisik, 'detaknadi', array('class' => 'span2 integer  numbersOnly', 'maxlength' => 10, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    /Menit
                </div>
            </div>
			<div class="control-group">
                <?php echo $form->LabelEx($modPemeriksaanFisik, 'pernapasan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPemeriksaanFisik, 'pernapasan', array('class' => 'span2 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                    /Menit
                </div>
            </div>
			<div class="control-group">
                    <?php echo $form->LabelEx($modPemeriksaanFisik,'tekanandarah',array('class'=>'control-label'));?>
                    <div class="controls">
                     <?php
							$this->widget('CMaskedTextField', array(
							'model' => $modPemeriksaanFisik,
							'attribute' => 'td_systolic',
							'mask' => '999',
							'placeholder'=>'0',
							'htmlOptions' => array('class'=>'span1 integer systolic', 'onkeypress'=>"return $(this).focusNextInputField(event)",'onkeyup'=>'returnValue(this); getText();') // change(this); getTekananDarah(this) change(this);getText();
							));
							?>Mm
							<?php // echo $form->textField($modPemeriksaanFisik,'td_diastolic',array('onblur'=>'','readonly'=>false,'class'=>'span1 integer numbersOnly diastolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'returnValue(this)'));?>
                     <?php
							$this->widget('CMaskedTextField', array(
							'model' => $modPemeriksaanFisik,
							'attribute' => 'td_diastolic',
							'mask' => '999',
							'placeholder'=>'0',
							'htmlOptions' => array('class'=>'span1 integer diastolic', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'onkeyup'=>'returnValue(this); getText();') //getTekananDarah(this); ,'onkeyup'=>'getText();'
							));
							?>Hg
                     <?php // echo $form->textField($modPemeriksaanFisik,'td_systolic',array('class'=>'span1 numbersOnly systolic', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>3, 'onkeyup'=>'returnValue(this)'));?>
						&nbsp;
                    </div>
            </div>
			<div class="control-group">
				<?php echo CHtml::Label('','',array('class'=>'control-label'));?>
				<div class="controls">
					<?php
						$modPemeriksaanFisik->tekanandarah = empty($modPemeriksaanFisik->tekanandarah) ? "000 / 000" : $modPemeriksaanFisik->tekanandarah;
						$this->widget('CMaskedTextField', array(
						'model' => $modPemeriksaanFisik,
						'attribute' => 'tekanandarah',
						'mask' => '999 / 999',
						'placeholder'=>'000 / 000',
						'htmlOptions' => array('readonly'=>true, 'class'=>'span2', 'style'=>'width:60px;','onkeypress'=>"return $(this).focusNextInputField(event)") //,'onkeyup'=>'getTekananDarah(this);''onfocus'=>'change(this);', 'onblur'=>'change(this);',
						));
					?> Mm/Hg
				</div>
			</div>
			<div class="control-group">
                <?php echo $form->LabelEx($modPemeriksaanFisik, 'Keterangan', array('class' => 'control-label')); ?>
                <div class="controls">
					<?php echo $form->textField($modPemeriksaanFisik, 'kriteria_td', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
                </div>
            </div>
			<div class="control-group">
                <?php echo $form->LabelEx($modPemeriksaanFisik, 'suhutubuh', array('class' => 'control-label')); ?>
                <div class="controls">
                <?php echo $form->textField($modPemeriksaanFisik, 'suhutubuh', array('class' => 'span2 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                    &#176 Celcius
                </div>
            </div>
			<br>
			<legend><h4>Status Gizi</h4></legend>
			<div class="control-group">
                <?php echo $form->LabelEx($modPemeriksaanFisik, 'tinggibadan_cm', array('class' => 'control-label')); ?>
                <div class="controls">
					<div class="groupUkurans">
						<?php echo $form->textField($modPemeriksaanFisik, 'tinggibadan_cm', array('class' => 'span2 integer numbersOnly tinggibadan', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'size' => 3)); ?>
						<?php echo $form->hiddenField($modPemeriksaanFisik, 'tinggibadan_cm', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'size' => 3)); ?>
						<?php echo CHtml::dropDownList('meter', '100', array('100' => 'Cm', '0.01' => 'M'), array( 'class' => 'span1', 'onchange' => 'gantiJumlah(this)')); ?>
					</div>
                </div>
            </div>
			<div class="control-group">
                <?php echo $form->LabelEx($modPemeriksaanFisik, 'beratbadan_kg', array('class' => 'control-label')); ?>
                <div class="controls">
					<div class="groupUkurans">
						<?php echo $form->textField($modPemeriksaanFisik, 'beratbadan_kg', array('class' => 'span2 integer numbersOnly beratbadan', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'size' => 3)); ?>
						<?php echo $form->hiddenField($modPemeriksaanFisik, 'beratbadan_kg', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'size' => 3)); ?>
						<?php echo CHtml::dropDownList('gram', '0.001', array('1000' => 'Gr', '0.001' => 'Kg'), array('class' => 'span1', 'onchange' => 'gantiJumlah(this)')); ?>
					</div>
                </div>
            </div>
			<div class="control-group">
                <?php echo $form->LabelEx($modPemeriksaanFisik, 'Lingkar Perut', array('class' => 'control-label')); ?>
                <div class="controls">
					<?php echo $form->textField($modPemeriksaanFisik, 'lingkarperut_cm', array('class' => 'span2 integer numbersOnly beratbadan', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'size' => 3)); ?>
					<?php echo $form->LabelEx($modPemeriksaanFisik, ' Cm'); ?>
                </div>
            </div>
			<div class="control-group">
                <label class='control-label'>Index Masa Tubuh</label>
                <div class="controls">
                    <?php echo CHtml::textField('imtValue', '', array('readonly' => true, 'class' => 'span1')); ?>
                    <?php echo CHtml::textField('imt', '', array('readonly' => true, 'class' => 'span2')); ?>
                </div>
            </div>
			<?php echo $form->textFieldRow($modPemeriksaanFisik, 'bentukbadan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
			<div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'keadaanumum', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                        'model' => $modPemeriksaanFisik,
                        'attribute' => 'keadaanumum',
                        'data' => explode(',', $modPemeriksaanFisik->keadaanumum),
                        'debugMode' => true,
                        'options' => array(
                            //'bricket'=>false,
                            'json_url' => $this->createUrl('MasterKeadaanUmum'),
                            'addontab' => true,
                            'maxitems' => 10,
                            'input_min_size' => 0,
                            'cache' => true,
                            'newel' => true,
                            'addoncomma' => true,
                            'select_all_text' => "",
                        ),
                    ));
                    ?>
                <?php echo $form->error($modPemeriksaanFisik, 'keadaanumum'); ?>
                </div>
            </div>
			<br>
			<legend><h4>Mata</h4></legend>
			<div class="control-group">
                <?php echo $form->LabelEx($modPemeriksaanFisik, 'Buta Warna', array('class' => 'control-label')); ?>
                <div class="controls">
					<?php // echo $form->textField($modPemeriksaanFisik, 'mata_persepsiwarna', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
					<?php echo $form->dropDownList($modPasien,'jenisidentitas', LookupM::getItems('matapersepsiwarna'),  
							array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'
					)); ?>   
                </div>
            </div>
			<div class="control-group">
				<?php echo CHtml::Label('Berkacamata', 'Berkacamata', array('class' => 'control-label')); ?>
                <div class="controls">
					<?php echo CHtml::checkBox('is_berkacamata','is_berkacamata'); ?>
				</div>
			</div>
			<div class="control-group" id="visus">
				<?php echo $form->LabelEx($modPemeriksaanFisik, 'Visus', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPemeriksaanFisik, 'mata_visus_od', array('class' => 'span1 float','placeholder' => 'OD', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo $form->textField($modPemeriksaanFisik, 'mata_visus_os', array('class' => 'span1 float','placeholder' => 'OS', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
			<div class="control-group">
				<?php echo $form->LabelEx($modPemeriksaanFisik, 'Kelainan Mata Lainnya', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPemeriksaanFisik, 'mata_kelainan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
			<div class="control-group">
				<?php echo $form->LabelEx($modPemeriksaanFisik, 'Penglihatan Jauh', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modPemeriksaanFisik, 'mata_penglihatanjauh', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
			<br>
			<div class="control-group">
				<?php echo $form->labelEx($modPemeriksaanFisik,'Pada Bagian Tubuh', array('class'=>'control-label')) ?>
				<div class="controls">
					<div class="radio inline">
						<div class="form-inline">
							<?php echo $form->radioButtonList($modPemeriksaanFisik,'kelainanpadabagtubuh',array('Normal'=>'Normal','Ada Kelainan'=>'Ada Kelainan'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
						</div>
					</div>
					<?php echo $form->error($modPemeriksaanFisik, 'kelainanpadabagtubuh'); ?>
				</div>
			</div>
		</fieldset>
	</div>
    <div class="span8">
		<fieldset class="box">
            <legend class="rim">THT (Telinga Hidung Tenggorokan)</legend>
			
			
			<table style="width: 100%; border: none;">
				<tr>
					<td width="50%">
						<legend><h4>Telinga</h4></legend>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Bentuk', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'bentuk_telinga',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'bentuk_telinga'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Liang Telinga', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'liang_telinga',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'liang_telinga'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Membran Timpani', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'membran_timpani',array('Intak'=>'Intak','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'membran_timpani'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Serumen', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'serumen',array('Ada'=>'Ada','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'serumen'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Keterangan', array('class'=>'control-label')) ?>
							<div class="controls">
								<?php echo $form->textArea($modRiwayatTht, 'keterangan_telinga', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
							</div>
						</div>
						<br>
						<legend><h4>Hidung</h4></legend>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Bentuk', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'bentuk_hidung',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'bentuk_hidung'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Septum Nasi', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'septum_nasi',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'septum_nasi'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Konka Nasal', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'konka_nasal',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'konka_nasal'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Keterangan', array('class'=>'control-label')) ?>
							<div class="controls">
								<?php echo $form->textArea($modRiwayatTht, 'keterangan_hidung', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
							</div>
						</div>
						<br>
						<legend><h4>Tenggorokan</h4></legend>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Pharynx', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'pharynx',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'pharynx'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'tonsil', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'tonsil',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'tonsil'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->LabelEx($modRiwayatTht, 'Ukuran', array('class' => 'control-label')); ?>
							<div class="controls">
								<?php echo $form->textField($modRiwayatTht, 'ukuran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Keterangan', array('class'=>'control-label')) ?>
							<div class="controls">
								<?php echo $form->textArea($modRiwayatTht, 'keterangan_tenggorokan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
							</div>
						</div>
						<br>
						<legend><h4>Mulut</h4></legend>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'oral_hygine', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'oral_hygine',array('Baik'=>'Baik','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'oral_hygine'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'gusi', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'gusi',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'gusi'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'gigi', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'gigi',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'gigi'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Keterangan', array('class'=>'control-label')) ?>
							<div class="controls">
								<?php echo $form->textArea($modRiwayatTht, 'keterangan_mulut', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
							</div>
						</div>
						<legend><h4>Leher</h4></legend>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Bentuk', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'bentuk_leher',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'bentuk_leher'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Kelenjar Thyroid', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'kelenjar_thyroid',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'kelenjar_thyroid'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Keterangan', array('class'=>'control-label')) ?>
							<div class="controls">
								<?php echo $form->textArea($modRiwayatTht, 'keterangan_leher', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
							</div>
						</div>
						<legend><h4>Paru</h4></legend>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Inspeksi', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'paru_inspeksi',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'paru_inspeksi'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Palpasi', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'paru_palpasi',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'paru_palpasi'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->LabelEx($modRiwayatTht, 'Perkusi', array('class' => 'control-label')); ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'paru_perkusi',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Auskultasi', array('class'=>'control-label')) ?>
							<div class="controls">
									<?php echo $form->textField($modRiwayatTht, 'paru_auskultasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
								<?php echo $form->error($modRiwayatTht, 'paru_auskultasi'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Keterangan', array('class'=>'control-label')) ?>
							<div class="controls">
								<?php echo $form->textArea($modRiwayatTht, 'keterangan_paru', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
							</div>
						</div>
					</td>
					<td width="50%">
						<legend><h4>Jantung</h4></legend>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Inspeksi', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'jantung_inspeksi',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'jantung_inspeksi'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Palpasi', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'jantung_palpasi',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'jantung_palpasi'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->LabelEx($modRiwayatTht, 'Perkusi', array('class' => 'control-label')); ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'jantung_perkusi',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Auskultasi', array('class'=>'control-label')) ?>
							<div class="controls">
									<?php echo $form->textField($modRiwayatTht, 'jantung_auskultasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
								<?php echo $form->error($modRiwayatTht, 'jantung_auskultasi'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Keterangan', array('class'=>'control-label')) ?>
							<div class="controls">
								<?php echo $form->textArea($modRiwayatTht, 'keterangan_jantung', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
							</div>
						</div>
						<br>
						<legend><h4>Abdomen</h4></legend>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Bentuk', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'bentuk_abdomen',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'bentuk_abdomen'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Inspeksi / Palpasi / Perkusi', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'inspeksi_abdomen',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'inspeksi_abdomen'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Hati', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'hati',array('Teraba'=>'Teraba','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'hati'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Limpa', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'limpa',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'limpa'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Keterangan', array('class'=>'control-label')) ?>
							<div class="controls">
								<?php echo $form->textArea($modRiwayatTht, 'keterangan_abdomen', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
							</div>
						</div>
						<br>
						<legend>
							<h4>Rectal
							<?php echo $form->checkBox($modRiwayatTht,'rectal_tidakdilakukan', array('rel'=>'tooltip', 'title' => 'Checklist jika melakukan pemeriksaan Rectal', 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
							</h4>
						</legend>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Anus / Rektum / Periana', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'anus',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'anus'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Keterangan', array('class'=>'control-label')) ?>
							<div class="controls">
								<?php echo $form->textArea($modRiwayatTht, 'keterangan_rectal', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
							</div>
						</div>
						<br>
						<legend><h4>Ekstremitas</h4></legend>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Ekstremitas', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'extremitas',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'extremitas'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Keterangan', array('class'=>'control-label')) ?>
							<div class="controls">
								<?php echo $form->textArea($modRiwayatTht, 'keterangan_extremitas', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
							</div>
						</div>
						<br>
						<legend><h4>Neurologis</h4></legend>
						<div class="control-group">
							<?php echo $form->LabelEx($modRiwayatTht, 'Neurologis (reflex)', array('class' => 'control-label')); ?>
							<div class="controls">
								<?php echo $form->textField($modRiwayatTht, 'neurologis', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Keterangan', array('class'=>'control-label')) ?>
							<div class="controls">
								<?php echo $form->textArea($modRiwayatTht, 'keterangan_neurologis', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
							</div>
						</div>
						<br>
						<legend><h4>Kulit</h4></legend>
						<div class="control-group">
							<?php echo $form->LabelEx($modRiwayatTht, 'Warna Kulit', array('class' => 'control-label')); ?>
							<div class="controls">
								<?php echo $form->textField($modRiwayatTht, 'warna_kulit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Kelainan Kulit', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'kelainan_kulit',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'kelainan_kulit'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Sensibilitas Kulit', array('class'=>'control-label')) ?>
							<div class="controls">
								<div class="radio inline">
									<div class="form-inline">
										<?php echo $form->radioButtonList($modRiwayatTht,'sensibilitas_kulit',array('Normal'=>'Normal','Tidak'=>'Tidak'), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
									</div>
								</div>
								<?php echo $form->error($modRiwayatTht, 'sensibilitas_kulit'); ?>
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modRiwayatTht,'Keterangan', array('class'=>'control-label')) ?>
							<div class="controls">
								<?php echo $form->textArea($modRiwayatTht, 'keterangan_kulit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
							</div>
						</div>
					</td>
				</tr>
			</table>
			
		</fieldset>
	</div>
</div>
<div class="form-actions">
<?php
if ($modPemeriksaanFisik->isNewRecord) {
	echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','enabled'=>true));
    echo CHtml::link(Yii::t('mds', '{icon} Print Pemeriksaan Fisik', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;')). '&nbsp;';
} else {
	echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','onclick'=>"return false",'disabled'=>true));
    echo CHtml::link(Yii::t('mds', '{icon} Print Pemeriksaan Fisik', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printPemeriksaanFisik();return false", 'disabled' => FALSE)). '&nbsp;';
}
?>
<?php
$content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
$this->widget('UserTips', array('type' => 'admin', 'content' => $content));
?>
</div>

<?php $this->endWidget(); ?>

<?php
$diastolic = CHtml::activeId($modPemeriksaanFisik, 'td_diastolic');
$js = <<< JS
//Di komen karna menggunakan onkeyup = returnValue
//if ($('#${diastolic}').val().length == 2){
//    $('#${diastolic}').val('0'+$('#${diastolic}').val());
//};
//    $('#${diastolic}').blur(function(){
//    var jumlahPanjang = $(this).val().length;
//    var tambah = '';
//    for (i=jumlahPanjang; i<3;i++){
//        tambah = tambah+'0';
//    }
//    $(this).val(tambah+$(this).val());
//    change($(this));
//});

   $('#namaGCS').attr('value','Hasil Metode GCS');

$('#pemeriksaanFisik').attr('checked',true);
$('#divBagianYAngDiperiksa').slideToggle(500);
$('#pemeriksaanFisik').change(function(){
        if ($(this).is(':checked')){
                $('#divBagianYAngDiperiksa input').removeAttr('disabled');
                $('#divBagianYAngDiperiksa select').removeAttr('disabled');
        }else{
                $('#divBagianYAngDiperiksa input').attr('disabled','true');
                $('#divBagianYAngDiperiksa select').attr('disabled','true');
                $('#divBagianYAngDiperiksa input').attr('value','');
                $('#divBagianYAngDiperiksa select').attr('value','');
        }
        $('#divBagianYAngDiperiksa').slideToggle(500);
    });
//===============Awal untu Mengecek Form Sudah DiUbah Atw Belum====================    
    $(":input").keyup(function(event){
            $('#berubah').val('Ya');
         });
    $(":input").change(function(event){
            $('#berubah').val('Ya');
         });  
    $(":input").click(function(event){
            $('#berubah').val('Ya');
         });  
//================Akhir untuk Mengecek  Form Sudah DiUbah Atw Belum===================         
$('.groupUkurans').find('input').keyup(function(){
    gantiHidden();
    getBeratBadanIdeal();
    getBMI();
});

getBMI();
getText();
JS;
Yii::app()->clientScript->registerScript('cekform', $js, CClientScript::POS_READY);
?>

<?php
// RND-5044 $urlgetMetodeGCS=Yii::app()->createUrl('ActionAjax/GetMetodeGCS');
$urlgetMetodeGCS = $this->createUrl('GetMetodeGCS');
$idTekananDarah = CHtml::activeId($modPemeriksaanFisik, 'tekanandarah');
$systolic = CHtml::activeId($modPemeriksaanFisik, 'td_systolic');
$diastolic = CHtml::activeId($modPemeriksaanFisik, 'td_diastolic');
$idDetakNadi = CHtml::activeId($modPemeriksaanFisik, 'detaknadi');
$getTextTekananDarah = Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/GetTextTekananDarah');
$arteriPressure = CHtml::activeId($modPemeriksaanFisik, 'meanarteripressure');
$beratBadan = CHtml::activeId($modPemeriksaanFisik, 'beratbadan_kg');
$tinggiBadan = CHtml::activeId($modPemeriksaanFisik, 'tinggibadan_cm');
$jenisKelamin = CHtml::activeId($modPasien, 'jenis_kelamin');
$jenisKelaminPerempuan = Params::JENIS_KELAMIN_PEREMPUAN;
$beratBadanIdeal = CHtml::activeId($modPemeriksaanFisik, 'bb_ideal');
$getBMIText = Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/getBMIText');
// RND-5044 $getfromDevice = Yii::app()->createUrl('actionAjax/getfromDevice');
$getfromDevice = $this->createUrl('getfromDevice');
$js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"

function palidasiForm(obj)
{
    var berubah = $('#berubah').val();
    if(berubah=='Ya'){
        myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
            if(r){
                $('#url').val(obj);
                $('#btn_simpan').click();
            }
        });
    }      
}

function ubahWarna(obj)   
{ 
    $(obj).attr("class","btn btn-success");
}

function kembaliWarna(obj)
{
   $(obj).attr("class","btn");
}

function SetNilai(obj)
{
    idTombol=obj.id;
    valueGCS=obj.value;
    i=0;
    if(idTombol=='E'){
        $('#RJPemeriksaanFisikT_gcs_eye').val(valueGCS);
    }else if(idTombol=='M'){
        $('#RJPemeriksaanFisikT_gcs_motorik').val(valueGCS);
    }else if(idTombol=='V'){
        $('#RJPemeriksaanFisikT_gcs_verbal').val(valueGCS);
    } 
    
    $('#divTombol #'+idTombol).each(function() {
        $(this).attr("class","btn"); 
    });

//    jumlah=$('#divTombol #'+idTombol).length;

$(obj).attr("class","btn btn-success"); 
    $(obj).removeAttr('onmouseout');
    $(obj).removeAttr('onmouseover');

    hitungCGS();
}

function hitungCGS()
{
    gcs_eye =  $('#RJPemeriksaanFisikT_gcs_eye').val();
    gcs_motorik =  $('#RJPemeriksaanFisikT_gcs_motorik').val();
    gcs_verbal =  $('#RJPemeriksaanFisikT_gcs_verbal').val();    
    if((gcs_eye!='') && (gcs_motorik!='') &&(gcs_verbal!='')){
        $.post("${urlgetMetodeGCS}",{gcs_eye: gcs_eye,gcs_motorik:gcs_motorik,gcs_verbal:gcs_verbal},
        function(data){
               if(data.pesan==null){
                 $('#RJPemeriksaanFisikT_gcs_id').val(data.idGCS);
                 $('#namaGCS').val(data.namaGCS);
               }else{
                    myAlert(data.pesan);
               }    
        },"json");
    }
}    

function getTekananDarah(obj){
    var hasil = $(obj).val();
    var data = hasil.split(' / ');

    data[0] = data[0].replace(/_/gi, "0");
    data[1] = data[1].replace(/_/gi, "0");
    $('#${systolic}').val(data[0]);
    $('#${diastolic}').val(data[1]);
}
    
function returnValue(obj){
    var value = $(obj).val();
    var attrID = $(obj).attr('id');
    var td = $('#${idTekananDarah}').val();
    var splitTD = td.split(' / ');
    
    if (attrID == '${diastolic}'){
        splitTD[0] = splitTD[0].replace(/_/gi, "0");
        $('#${idTekananDarah}').val(splitTD[0]+' / '+value);
    }
    else if (attrID == '${systolic}'){
        splitTD[1] = splitTD[1].replace(/_/gi, "0");
        $('#${idTekananDarah}').val(value+' / '+splitTD[1]);
    }
}

function change(obj){
    var value = $(obj).val();
    var hasil = value.replace(/_/gi, "0");
    
    if (value == ''){
        $(obj).val('000 / 000')
    }else{
        $(obj).val(hasil);
        returnValue(obj);
    }
    
}

function getText(){
    var dias = parseFloat($('#${diastolic}').val());
    var sys = parseFloat($('#${systolic}').val());
    var arteri = ((sys+(2*dias))/3);
    
    if (jQuery.isNumeric(dias)){
        if (jQuery.isNumeric(sys)){
            $.post('${getTextTekananDarah}', {diastolic:dias, systolic:sys}, function(data){
                if (data.text == null){
                    $('#RJPemeriksaanFisikT_kriteria_td').val('Tekanan Darah Tidak Ditemukan');
                } else {
                    $('#RJPemeriksaanFisikT_kriteria_td').val(data.text);
                }
            },'json');
            $('#${arteriPressure}').val(arteri);
        }
    }
}

function gantiJumlah(obj){
    var value = parseFloat($(obj).val());
    var teman = $(obj).parent('.groupUkurans').find('input[type="text"]');
    var valueTeman = parseFloat(teman.val());
    var hasil;

    hasil = valueTeman*value;
    teman.val(hasil);
}

function gantiHidden(){
    var defaultBB = parseFloat(0.001);
    var defaultTB = parseFloat(100);
    var valueBB = parseFloat($('#${beratBadan}').val());
    var valueTB = parseFloat($('#${tinggiBadan}').val());

    if ($('#gram').val() != defaultBB){
        $('#${beratBadan}').parent('.groupUkurans').find('input[type="hidden"]').val(valueBB*defaultBB);
    }
    else{
        $('#${beratBadan}').parent('.groupUkurans').find('input[type="hidden"]').val(valueBB);
    }
    
    if ($('#meter').val() != defaultTB){
        $('#${tinggiBadan}').parent('.groupUkurans').find('input[type="hidden"]').val(valueTB*defaultTB);
    }
    else{
        $('#${tinggiBadan}').parent('.groupUkurans').find('input[type="hidden"]').val(valueTB);
    }
}            
            
function getBeratBadanIdeal(){
    var beratBadan = parseFloat($('#${beratBadan}').val());
    var tinggiBadan = parseFloat($('#${tinggiBadan}').parent('.groupUkurans').find('input[type="hidden"]').val());
    var jenisKelamin = $('#${jenisKelamin}').val();
    var hasil;
    if (jenisKelamin == "${jenisKelaminPerempuan}"){
        hasil = (tinggiBadan - 100) - ((15/100)*(tinggiBadan-100));
        if (hasil < 0){
            hasil = 0;
        }
        $('#${beratBadanIdeal}').val(hasil);
    }
    else{
        hasil = (tinggiBadan - 100) - ((10/100)*(tinggiBadan-100));
        if (hasil < 0){
            hasil = 0;
        }
        $('#${beratBadanIdeal}').val(hasil);
    }
}

function getBMI(){
    var beratBadan = parseFloat($('#${beratBadan}').parent('.groupUkurans').find('input[type="hidden"]').val());
    var tinggiBadan = parseFloat($('#${tinggiBadan}').parent('.groupUkurans').find('input[type="hidden"]').val());
    var hasil;
    
    hasil = (beratBadan/((tinggiBadan*tinggiBadan)/10000));
    if (jQuery.isNumeric(hasil)){
        $.post('${getBMIText}', {bmi:hasil}, function(data){
            $('#imt').val(data.text);
            $('#imtValue').val(Math.floor(hasil));
        },'json');
    }
}

function getfromDevice(){
    $.post('${getfromDevice}',{},function(dataz){
        $('#${idDetakNadi}').val(dataz.detaknadi);
        $('#${idTekananDarah}').val(dataz.tekanandarah);
        $('#${systolic}').val(dataz.sys);
        $('#${diastolic}').val(dataz.dias);
            getText();
    }, 'json');
    
    
}
JS;
Yii::app()->clientScript->registerScript('validasi', $js, CClientScript::POS_HEAD);

$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9.]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9.].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
?> 
<?php
echo $this->renderPartial($this->path_view_mcu . '_jsFunctions', array(
    'modPendaftaran' => $modPendaftaran,
    'modPemeriksaanFisik' => $modPemeriksaanFisik,
    'modBagianTubuh' => $modBagianTubuh,
    'modPemeriksaanGambar' => $modPemeriksaanGambar
));
?>