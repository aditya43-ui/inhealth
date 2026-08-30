<div class="panel panel-success " id="panel-ginekologi">
	<div class="panel-heading">
		<div class="panel-title">
			Status Ginekologi
		</div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-6">
				<div class="control-group">
					<?php echo $form->labelEx($modGinekologi, 'pegawai_id', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
						$pegawai = new CDbCriteria();
						$pegawai->with = array('ruanganpegawai');
						$pegawai->addCondition("t.pegawai_aktif = TRUE ");
						$pegawai->addCondition("ruanganpegawai.ruangan_id = ".Yii::app()->user->getState('ruangan_id')); 
						$pegawai->addCondition('t.kelompokpegawai_id IN ('.Params::KELOMPOKPEGAWAI_ID_BIDAN.','.Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK.') ');
						$pegawai->order = 't.nama_pegawai ASC';
						
						echo $form->dropDownList($modGinekologi, 'pegawai_id', 
								CHtml::listData(PSPegawaiM::model()->findAll($pegawai), 'pegawai_id', 'namaLengkap'),
								array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
						?>
						<?php echo $form->error($modGinekologi, 'pegawai_id'); ?>
					</div>
				</div>
				<div class="control-group">
					<?php echo $form->labelEx($modGinekologi, 'ppds_id', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
						// $pegawai = new CDbCriteria();
						// $pegawai->with = array('ruanganpegawai');
						// $pegawai->addCondition("t.ppds_aktif = TRUE ");
						// $pegawai->addCondition("ruanganpegawai.ruangan_id = ".Yii::app()->user->getState('ruangan_id')); 
						// $pegawai->addCondition('t.kelompokpegawai_id IN ('.Params::KELOMPOKPEGAWAI_ID_BIDAN.','.Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK.') ');
						// $pegawai->order = 't.nama_pegawai ASC';
						
						echo $form->dropDownList($modGinekologi, 'ppds_id', 
								CHtml::listData(PpdsM::model()->findAll(), 'ppds_id', 'ppds_nama'),
								array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
						?>
						<?php echo $form->error($modGinekologi, 'ppds_id'); ?>
					</div>
				</div>
				<div class="control-group">
					<?php echo $form->labelEx($modGinekologi,  'tglperiksaobgyn', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
						$this->widget('MyDateTimePicker', array(
							'model' => $modGinekologi,
							'attribute' => 'tglperiksaobgyn',
							'mode' => 'datetime',
							'options' => array(
								'dateFormat' => Params::DATE_FORMAT,
								'maxDate' => 'd',
							),
							'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
							),
						));
						?>
						<?php echo $form->error($modGinekologi, 'obs_periksadalam'); ?>
					</div>
				</div>
				<div class="control-group">
					<?php echo $form->labelEx($modGinekologi, 'gin_keluhan', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
							$this->widget('application.extensions.FCBKcomplete.FCBKcomplete',array(
								'model'=>$modGinekologi,
								'attribute'=>'gin_keluhan',
								'data'=> explode(',', $modGinekologi->gin_keluhan),   
								'debugMode'=>true,
								'options'=>array(
									//'bricket'=>false,
									'json_url'=>$this->createUrl('RiwayatKehamilanKeluhan'),
									'addontab'=> true, 
									'maxitems'=> 10,
									'input_min_size'=> 0,
									'cache'=> true,
									'newel'=> true,
									'addoncomma'=>true,
									'select_all_text'=> "", 
									'autoFocus'=>true,
								),
							));
						?>
						<?php echo $form->error($modGinekologi, 'keluhanutama'); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($modGinekologi, 'gin_jmlkawin_kali', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
						echo $form->textField($modGinekologi, 'gin_jmlkawin_kali', array('style'=>'text-align:right;', 'class'=>'span1 numbers-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 4)).' <label>Kali</label>';
						?> 
						<?php echo $form->error($modGinekologi, 'gin_jmlkawin_kali'); ?>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($modGinekologi, 'gin_statuskawin', array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo $form->radioButton($modGinekologi, 'gin_statuskawin', array('value'=>  Params::STATUS_PERKAWINAN_KAWIN, 'uncheckValue'=>null)); ?> <label>Masih Kawin</label>
						<?php echo $form->radioButton($modGinekologi, 'gin_statuskawin', array('value'=> Params::STATUS_PERKAWINAN_TIDAK_KAWIN, 'uncheckValue'=>null)); ?> <label>Tidak</label>
					</div>
				</div>

				<div class="control-group">
					<?php echo $form->labelEx($modGinekologi, 'gin_usiakawin_thn', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
						echo $form->textField($modGinekologi, 'gin_usiakawin_thn', array('style'=>'text-align:right;', 'class'=>'span1 numbers-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 4)).' <label>Tahun</label>';
						?> 
						<?php echo $form->error($modGinekologi, 'gin_usiakawin_thn'); ?>
					</div>
				</div>		
			</div>
			<div class="col-sm-6">
				<div class="control-group">
					<?php echo $form->labelEx($modGinekologi, 'gin_nafsumakan', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
						echo $form->textField($modGinekologi, 'gin_nafsumakan', array('style'=>'width:215px;','class'=>'angkahuruf-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
						?> 
						<?php echo $form->error($modGinekologi, 'gin_nafsumakan'); ?>
					</div>
				</div>
				
					<div class="control-group">
					<?php echo Chtml::label("", 'gin_nafsumakan_kurusgemuk', array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo $form->radioButton($modGinekologi, 'gin_nafsumakan_kurusgemuk', array('value'=>  0, 'uncheckValue'=>null)); ?> <label>Menjadi Kurus</label>
						<?php echo $form->radioButton($modGinekologi, 'gin_nafsumakan_kurusgemuk', array('value'=> 1, 'uncheckValue'=>null)); ?> <label>Menjadi Gemuk</label>
					</div>
				</div>
				
				<div class="control-group">
					<?php echo $form->labelEx($modGinekologi, 'gin_mictio', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
						echo $form->textField($modGinekologi, 'gin_mictio', array('style'=>'width:215px;','class'=>'angkahuruf-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
						?> 
						<?php echo $form->error($modGinekologi, 'gin_mictio'); ?>
					</div>
				</div>
				
				<div class="control-group">
					<?php echo $form->labelEx($modGinekologi, 'gin_defecatio', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
						echo $form->textField($modGinekologi, 'gin_defecatio', array('style'=>'width:215px;','class'=>'angkahuruf-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
						?> 
						<?php echo $form->error($modGinekologi, 'gin_defecatio'); ?>
					</div>
				</div>
				<div class="control-group">
					<?php echo CHtml::label('Dikirim oleh', '', array('class' => 'control-label')) ?>
					<div class="controls">
						<div class="row">
							<?php
								$lookup_dikirim = LookupM::model()->findAllByAttributes(array('lookup_type'=>'asalpasien_ginekologi'),array('order'=>'lookup_urutan asc'));
								
								if(!empty($lookup_dikirim)){
									$indDikirim = 0;
									foreach($lookup_dikirim as $look){
										$indDikirim += 1;

										echo '<div class="col-sm-6">';
										echo CHtml::activeRadioButton($modGinekologi, 'asal_pasien',array('value'=>$look->lookup_value, 'uncheckValue'=>null,'onchange'=>'changeDikirimOleh_ginekologi()', 'class'=>'asal_pasien')).' <label>'.$look->lookup_name.'</label>';
										if($look->lookup_value== 'Poliklinik Rumah Sakit'){
											echo CHtml::activeDropDownList($modGinekologi, 'ruanganpoli_asalpasien', 
											CHtml::listData(RuanganM::model()->findAll('instalasi_id = 2 and ruangan_aktif = true order by ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'),
											array('empty'=>'-- Pilih --','class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);",'class'=>'span3'));
										}
										echo '</div>';

										if($indDikirim == 2){
											echo '<div class="clear"></div>';
											$indDikirim = 0;
										}
									}
								}
							?> 
						</div>
						
					</div>
				</div>	
				<div class="control-group">
				<?php echo CHtml::label('Riwayat Pengobatan Sebelumnya', '', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php
						echo $form->textArea($modGinekologi, 'riwayatpengobatan_sebelumnya', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);"));
						?> 
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="col-sm-12">
				<div style="margin-top: 20px !important;" class="panel panel-darkk">
					<span class="group-title">
						Pola Menstruasi
					</span>
					<div class="panel-body" style="padding-top:5px !important;">
						<div class="row">
							<div class="col-sm-6">
								<div class="control-group">
									<?php echo $form->labelEx($modGinekologi, 'gin_menarche_thn', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textField($modGinekologi, 'gin_menarche_thn', array('style'=>'text-align:right;', 'class'=>'span1 numbers-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 4)).' <label>Tahun</label>';
										?> 
										<?php echo $form->error($modGinekologi, 'gin_menarche_thn'); ?>
									</div>
								</div>
										
								<div class="control-group">
									<label class="control-label">Hari pertama haid terakhir</label>
									<div class="controls">
										<?php
										$this->widget('MyDateTimePicker', array(
											'model' => $modGinekologi,
											'attribute' => 'gin_tglpertamahaid',
											'mode' => 'date',
											'options' => array(
												'dateFormat' => Params::DATE_FORMAT,
												'maxDate' => 'd',
											),
											'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
											),
										));
										?>
									</div>
								</div>
										
								<div class="control-group">
									<?php echo $form->labelEx($modGinekologi, 'gin_siklushaid_hari', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textField($modGinekologi, 'gin_siklushaid_hari', array('style'=>'text-align:right;','class'=>'span1 numbers-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 4)).' <label>Hari</label>';
										?> 
										<?php echo $form->error($modGinekologi, 'gin_siklushaid_hari'); ?>
									</div>
								</div>
								
								<div class="control-group">
									<?php echo $form->labelEx($modGinekologi, 'gin_lamahaid_hari', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textField($modGinekologi, 'gin_lamahaid_hari', array('style'=>'text-align:right;', 'class'=>'span1 numbers-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 4)).' <label>Hari</label>';
										?> 
										<?php echo $form->error($modGinekologi, 'gin_lamahaid_hari'); ?>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="control-group">
									<?php echo CHtml::label('Menopause', '', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php echo $form->radioButton($modGinekologi, 'ismenopause', array('uncheckValue' => null, 'value' => 'Belum', 'class' => 'ismenopause', 'onchange'=>'changemenopause_ginekologi()')); ?> <label>Belum</label>
										<br/>
										<?php echo $form->radioButton($modGinekologi, 'ismenopause', array('uncheckValue' => null, 'value' => 'Sudah', 'class' => 'ismenopause', 'onchange'=>'changemenopause_ginekologi()')); ?> <label>Sudah</label>
										<br/>
										<label style="padding-left: 20px;">Usia</label>
										<?php echo $form->textField($modGinekologi, 'usia_menopause', array('class' => 'span1 integer2', 'readonly' => true)) ?>
										<label>Tahun</label>
									</div>
								</div>
								<div class="control-group">
									<?php echo $form->labelEx($modGinekologi, 'gin_darahhaid', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textField($modGinekologi, 'gin_darahhaid', array('style'=>'width:215px;','class'=>'angkahuruf-only','onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
										?> 
										<?php echo $form->error($modGinekologi, 'gin_darahhaid'); ?>
									</div>
								</div>
								
								<div class="control-group">
									<?php echo Chtml::label("", 'gin_darahhaid_tambahkurang', array('class'=>'control-label')); ?>
									<div class="controls">
										<?php echo $form->radioButton($modGinekologi, 'gin_darahhaid_tambahkurang', array('value'=>  0, 'uncheckValue'=>null)); ?> <label>Bertambah</label>
										<?php echo $form->radioButton($modGinekologi, 'gin_darahhaid_tambahkurang', array('value'=> 1, 'uncheckValue'=>null)); ?> <label>Berkurang</label>
									</div>
								</div>	
							</div>
						</div>
					</div>
				</div>
				<div style="margin-top: 20px !important;" class="panel panel-darkk">
					<span class="group-title">
						Pola Keputihan
					</span>
					<div class="panel-body" style="padding-top:5px !important;">
						<div class="row">
							<div class="col-sm-6">
								<div class="control-group">
									<?php echo CHtml::label('Cairan Vagina', 'polakeputihan_cairanvagina', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textArea($modGinekologi, 'polakeputihan_cairanvagina', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);"));
										?> 
									</div>
								</div>	
								<div class="control-group">
									<?php echo CHtml::label('Lama', 'polakeputihan_lama', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textField($modGinekologi, 'polakeputihan_lama', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);"));
										?> 
									</div>
								</div>	

							</div>
							<div class="col-sm-6">
								<div class="control-group">
									<?php echo CHtml::label('Warna', 'polakeputihan_warna', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textField($modGinekologi, 'polakeputihan_warna', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);"));
										?> 
									</div>
								</div>	
								<div class="control-group">
									<?php echo CHtml::label('Berbau', 'polakeputihan_isberbau', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php echo $form->radioButtonList($modGinekologi, 'polakeputihan_isberbau',array('Ya'=>'Ya','Tidak'=>'Tidak'), array('class' => 'polakeputihan_isberbau')) ?>
									</div>
								</div>	
							</div>
						</div>
					</div>
				</div>
				<div style="margin-top: 20px !important;" class="panel panel-darkk">
					<span class="group-title">
						Riwayat Kehamilan & Kelahiran
					</span>
					<div class="panel-body" style="padding-top:5px !important;">
						<table width="100%" class="tabledosis">
							<tr>
								<td width="width: 30%" valign="top" style="border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; padding-left: 20px;">
									<table width="100%" class="tablecustom">
										<tr>
											<td width="150px"> Hamil ke-</td>
											<td width="100px">
												<?php echo CHtml::textField('hamilke',0,array('class'=>'span1 integer2')); ?>
											</td>
										</tr>
										<tr>
											<td width="150px"> Suami ke-</td>
											<td width="100px">
												<?php echo CHtml::textField('suamike',0,array('class'=>'span1 integer2')); ?>
											</td>
										</tr>
										<tr>
											<td width="150px">Umur Kehamilan</td>
											<td width="100px">
												<?php echo CHtml::textField('umurkehamilan',0,array('class'=>'span1 integer2')); ?> Minggu
											</td>
										</tr>
										<tr>
											<td width="150px">Penyulit Kehamilan</td>
											<td width="100px">
												<?php echo CHtml::textArea('penyulit_kehamilan','',array('class'=>'span3')); ?>
											</td>
										</tr>
										<tr>
											<td width="150px">Penolong Persalinan</td>
											<td width="100px">
												<?php echo CHtml::textField('persalinan_penolong','',array('class'=>'span3')); ?>
											</td>
										</tr>
									</table>
								</td>
								<td width="width: 30%" valign="top" style="border-top: 1px solid black; border-bottom: 1px solid black;">
									<table width="100%" class="tablecustom">
										<tr>
											<td width="150px">Jenis Persalinan</td>
											<td>
												<?php echo CHtml::textField('persalinan_jenis','',array('class'=>'span3')); ?>
											</td>
										</tr>
										<tr>
											<td width="150px">Penyulit Persalinan</td>
											<td>
												<?php echo CHtml::textField('persalinan_penyulit','',array('class'=>'span3')); ?>
											</td>
										</tr>
										<tr>
											<td width="150px">Nifas</td>
											<td>
												<?php echo CHtml::textField('nifas','',array('class'=>'span3')); ?>
											</td>
										</tr>
										<tr>
											<td width="150px"> Anak ke-</td>
											<td width="100px">
												<?php echo CHtml::textField('anak_ke',0,array('class'=>'span1 integer2')); ?>
											</td>
										</tr>

										<tr>
											<td width="150px">Jenis Kelamin Anak</td>
											<td width="100px">
												<?php echo CHtml::radioButtonList('jeniskelamin','',array('Laki-laki'=>'Laki-laki','Perempuan'=>'Perempuan') , array('class'=>'jeniskelamin')); ?>
											</td>
										</tr>
									</table>
								</td>
								<td width="width: 30%" valign="top" style="border-top: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black;">
									<table width="100%" class="tablecustom">
										<tr>
											<td width="150px">Berat Badan Lahir</td>
											<td width="100px">
												<?php echo CHtml::textField('beratbadan','',array('class'=>'span1 float2')); ?>
												<?php echo CHtml::dropDownList('beratbadan_status', 'Kg', array('Gr'=>'Gr', 'Kg'=>'Kg'), array('class'=>'span1')); ?>
											</td>
										</tr>
										<tr>
											<td>Keadaan Lahir</td>
											<td>
											<?php echo CHtml::dropDownList('anak_keadaanlahir', '', LookupM::getItems('keadaanlahir'), array('class'=>'span3')); ?>
											</td>
										</tr>
										<tr>
											<td>Lama Persalinan</td>
											<td>
											<?php echo CHtml::textField('anak_lamapersalinanmenit','',array('class'=>'span1 integer2')); ?> Menit
											</td>
										</tr>
										<tr>
											<td>KB Cara</td>
											<td>
												<?php echo CHtml::textField('kb_cara','',array('class'=>'span3')); ?>
											</td>
										</tr>
										<tr>
											<td>Keterangan</td>
											<td>
												<?php echo CHtml::textArea('keterangan','',array('class'=>'span3')); ?>
											</td>
										</tr>
									</table>
								</td>
								<td width="width: 10%" valign="middle" style="padding-left: 20px;">
								<?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
										array('onclick'=>'tambahKehamilan_ginekologi(this);return false;',
												'class'=>'btn btn-primary',
												'id'=>'tomboltambah',
												'onkeypress'=>"tambahKehamilan_ginekologi(this);return false;",
												'rel'=>"tooltip",
												'title'=>"Klik untuk menambahkan ke tabel Riwayat Kehamilan & Kelahiran")); ?>
								</td>
							</tr>
							</table>
							<br/>
							<table class="table table-striped table-bordered table-condensed" style="width: 100%" id="tblRiwayatKehamilan">
							<thead>
								<tr>
									<th colspan="4" style="font-weight: bold; text-align: center;">Kehamilan</th>
									<th colspan="3" style="font-weight: bold; text-align: center;">Persalinan</th>
									<th rowspan="2">Nifas</th>
									<th colspan="5" style="font-weight: bold; text-align: center;">Anak</th>
									<th rowspan="2">KB Cara</th>
									<th rowspan="2">Keterangan</th>
									<th rowspan="2" style="text-align: center;">Batal</th>
								</tr>
								<tr>
									<th>Hamil Ke-</th>
									<th>Suami Ke-</th>
									<th>Umur Kehamilan <br/>(Minggu)</th>
									<th>Penyulit Kehamilan</th>

									<th>Penolong Persalinan</th>
									<th>Jenis Persalinan</th>
									<th>Penyulit Persalinan</th>

									<th>Anak Ke-</th>
									<th>Jenis Kelamin</th>
									<th>Berat Badan</th>
									<th>Keadaan Lahir</th>
									<th>Lama Persalinan<br/>(Menit)</th>
								</tr>
							</thead>
							<tbody>
							<?php
								if (isset($modRiwayatKehamilan)) {
									foreach ($modRiwayatKehamilan as $i => $detail) { ?>
										<tr>
											<td> 
												<?php echo Chtml::activeHiddenField($detail, '[' . $i . ']hamil_ke', array('class' => 'hamil_ke'));
													echo $detail->hamil_ke; ?> 
												<?php echo Chtml::activeHiddenField($detail, '[' . $i . ']suami_ke', array('class' => 'suami_ke')); ?>
												<?php echo Chtml::activeHiddenField($detail, '[' . $i . ']umurkehamilan_minggu', array('class' => 'umurkehamilan_minggu')); ?>
												<?php echo Chtml::activeHiddenField($detail, '[' . $i . ']penyulit_kehamilan', array('class' => 'penyulit_kehamilan')); ?>
												<?php echo Chtml::activeHiddenField($detail, '[' . $i . ']persalinan_penolong', array('class' => 'persalinan_penolong')); ?>
												<?php echo Chtml::activeHiddenField($detail, '[' . $i . ']persalinan_jenis', array('class' => 'persalinan_jenis')); ?>
												<?php echo Chtml::activeHiddenField($detail, '[' . $i . ']persalinan_penyulit', array('class' => 'persalinan_penyulit')); ?>
												<?php echo Chtml::activeHiddenField($detail, '[' . $i . ']nifas', array('class' => 'nifas')); ?>
												<?php echo Chtml::activeHiddenField($detail, '[' . $i . ']anak_ke', array('class' => 'anak_ke')); ?>
												<?php echo Chtml::activeHiddenField($detail, '[' . $i . ']anak_jeniskelamin', array('class' => 'anak_jeniskelamin')); ?>
												<?php echo Chtml::activeHiddenField($detail, '[' . $i . ']anak_beratbadanlahir', array('class' => 'anak_beratbadanlahir')); ?>
												<?php echo Chtml::activeHiddenField($detail, '[' . $i . ']anak_beratbadanlahirsatuan', array('class' => 'anak_beratbadanlahirsatuan')); ?>
												<?php echo Chtml::activeHiddenField($detail, '[' . $i . ']anak_keadaanlahir', array('class' => 'anak_keadaanlahir')); ?>
												<?php echo Chtml::activeHiddenField($detail, '[' . $i . ']anak_lamapersalinanmenit', array('class' => 'anak_lamapersalinanmenit')); ?>
												<?php echo Chtml::activeHiddenField($detail, '[' . $i . ']kb_cara', array('class' => 'kb_cara')); ?>
												<?php echo Chtml::activeHiddenField($detail, '[' . $i . ']keterangan', array('class' => 'keterangan')); ?>

											</td>
											<td> 
													<?php echo $detail->suami_ke;  ?> 
											</td>
											<td> 
													<?php echo $detail->umurkehamilan_minggu;  ?> 
											</td>
											<td> 
													<?php echo $detail->penyulit_kehamilan;  ?> 
											</td>
											<td> 
													<?php echo $detail->persalinan_penolong;  ?> 
											</td>
											<td> 
													<?php echo $detail->persalinan_jenis;  ?> 
											</td>
											<td> 
													<?php echo $detail->persalinan_penyulit;  ?> 
											</td>
											<td> 
													<?php echo $detail->nifas;  ?> 
											</td>
											<td> 
													<?php echo $detail->anak_ke;  ?> 
											</td>
											<td> 
													<?php echo $detail->anak_jeniskelamin;  ?> 
											</td>
											<td> 
													<?php echo $detail->anak_beratbadanlahir.'<br/>'.$detail->anak_beratbadanlahirsatuan;  ?> 
											</td>
											<td> 
													<?php echo $detail->anak_keadaanlahir;  ?> 
											</td>
											<td> 
													<?php echo $detail->anak_lamapersalinanmenit;  ?> 
											</td>
											<td> 
													<?php echo $detail->kb_cara;  ?> 
											</td>
											<td> 
													<?php echo $detail->keterangan;  ?> 
											</td>
											<td> 
											<a onclick='batalKehamilan_ginekologi(this);return false;' rel='tooltip' href='javascript:void(0);' title='Klik untuk membatalkan Riwayat Kehamilan'><i class='icon-remove'></i></a>
											</td>
										</tr>
								<?php }
								}
								?>		
							</tbody>
							</table>				
					</div>
				</div>
				<div style="margin-top: 20px !important;" class="panel panel-darkk">
					<span class="group-title">
						Status Umum
					</span>
					<div class="panel-body" style="padding-top:5px !important;">
						<div class="row">
							<div class="col-sm-6">
								<div class="control-group">
									<div class="controls" style="width: 50%">
									<?php
										$lookup_statusumum = LookupM::model()->findAllByAttributes(array('lookup_type'=>'ginekologi_statusumum'),array('order'=>'lookup_urutan asc'));
										
										if(!empty($lookup_statusumum)){
											$indUmum = 0;
											foreach($lookup_statusumum as $look){
												$indUmum += 1;

												echo '<div class="col-sm-6">';
												echo CHtml::activeRadioButton($modGinekologi, 'statusumum',array('value'=>$look->lookup_value, 'uncheckValue'=>null, 'class'=>'statusumum')).' <label>'.$look->lookup_name.'</label>';
												echo '</div>';

												if($indUmum == 2){
													echo '<div class="clear"></div>';
													$indUmum = 0;
												}
											}
										}
									?> 
									</div>
								</div>	
								<div class="control-group">
									<?php echo CHtml::label('Tekanan Darah', '', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textField($modGinekologi, 'td_systolic', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'onkeyup' => 'setTekanan_ginekologi(this);', 'style' => 'text-align: right;')); ?><label>Mm</label>
										<?php
										echo $form->textField($modGinekologi, 'td_diastolic', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'onkeyup' => 'setTekanan_ginekologi(this);', 'style' => 'text-align: right;')); ?><label>Hg</label>
										
									</div>
								</div>
								<div class="control-group">
									<?php echo CHtml::Label('', '', array('class' => 'control-label')); ?>
									<div class="controls">
										<?php
										$tekanandarah_ori = (empty($modGinekologi->td_systolic) ? "0" : $modGinekologi->td_systolic).' / '.(empty($modGinekologi->td_diastolic) ? "0" : $modGinekologi->td_diastolic);
										echo CHtml::textField('tekananDarah_ori_genikologi', $tekanandarah_ori, array('class' => 'span2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);"));
										?> <label>Mm/Hg</label>
									</div>
								</div>
								<div class="control-group">
									<div class="controls">
										<?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
										<?php echo CHtml::textField('tekananDarah_genikologi', '', array('class' => 'span2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
									</div>
								</div>
								<div class="control-group">
									<?php echo CHtml::label('Mean Arteri Pressure', '', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php echo $form->textField($modGinekologi, 'map', array('readonly' => true, 'class' => 'span2 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
									</div>
								</div>	
								
								<div class="control-group">
									<?php echo Chtml::label("Nadi", 'detaknadi', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textField($modGinekologi, 'detaknadi', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
										?> <label>/ Menit</label>
									</div>
								</div>
								<div class="control-group">
									<?php echo Chtml::label("RR", 'respiratoryrate', array('class' => 'control-label')) ?>	
									<div class="controls">
										<?php
										echo $form->textField($modGinekologi, 'respiratoryrate', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
										?><label>x/ Menit</label>
									</div>
								</div>

							</div>
							<div class="col-sm-6">
								<div class="control-group ">
									<?php echo Chtml::label("Suhu", 'suhutubuh', array('class' => 'control-label')) ?>
									<div class="controls">
											<?php echo $form->textField($modGinekologi,'suhutubuh',array('class'=>'span2 float', 'maxlength'=>5, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align:right;'));?>
									&#176; C
									</div>
								</div>
								<div class="control-group">
									<?php echo CHtml::label('Edema', '', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php echo $form->radioButton($modGinekologi, 'isedema', array('uncheckValue' => null, 'value' => 'Tidak', 'class' => 'isedema', 'onchange'=>'changeedema_ginekologi()')); ?> <label>Tidak</label>
										<br/>
										<?php echo $form->radioButton($modGinekologi, 'isedema', array('uncheckValue' => null, 'value' => 'Ya', 'class' => 'isedema', 'onchange'=>'changeedema_ginekologi()')); ?> <label>Ya</label>
										<br/>
										<label style="padding-left: 20px;">Lokasi</label>
										<?php echo $form->textField($modGinekologi, 'edema_lokasi', array('class' => 'span3', 'readonly' => true)) ?>
									</div>
								</div>
								<div class="control-group">
									<?php echo CHtml::label('Cor', 'cor', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textArea($modGinekologi, 'cor', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);"));
										?> 
									</div>
								</div>
								<div class="control-group">
									<?php echo CHtml::label('Pulmo', 'pulmo', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textArea($modGinekologi, 'pulmo', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);"));
										?> 
									</div>
								</div>	
							</div>
						</div>
					</div>
				</div>
				<div style="margin-top: 20px !important;" class="panel panel-darkk">
					<span class="group-title">
						Pemeriksaan Dalam
					</span>
					<div class="panel-body" style="padding-top:5px !important;">
						<div class="row">
							<div class="col-sm-6">
								<div class="control-group">
									<?php echo CHtml::label("Petugas Pemeriksaan", 'periksadalam_pemeriksa', array('class' => 'control-label')); ?>
									<div class="controls">
										<?php echo $form->hiddenField($modGinekologi,'periksadalam_pemeriksa') ?>
										<?php
										$this->widget('MyJuiAutoComplete', array(
											'model' => $modGinekologi,
											'attribute' => 'periksadalam_pemeriksa_nama',
											'source' => 'js: function(request, response) {
															$.ajax({
																url: "' . $this->createUrl('AutocompletePetugasKala1') . '",
																dataType: "json",
																data: {
																	term: request.term,
																},
																success: function (data) {
																		response(data);
																}
															})
															}',
											'options' => array(
												'showAnim' => 'fold',
												'minLength' => 3,
												'focus' => 'js:function( event, ui ) {
													$(this).val( ui.item.label);
													return false;
												}',
												'select' => 'js:function( event, ui ) {
													$("#' . Chtml::activeId($modGinekologi, 'periksadalam_pemeriksa') . '").val(ui.item.pegawai_id); 
													return false;
												}',
											),
											'htmlOptions' => array(
												'placeholder'=>'Ketikan nama pegawai',
												'class' => 'span3',
												'onkeyup' => "return $(this).focusNextInputField(event)",
												'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modGinekologi, 'periksadalam_pemeriksa') . '").val(""); '
											),
											'tombolDialog' => array('idDialog' => 'dialogPetugas_ginekologi'),
										));
										?>
									</div>
								</div>
								<div class="control-group">
									<?php echo CHtml::label('Vulva', 'periksadalam_vulva', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textArea($modGinekologi, 'periksadalam_vulva', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);"));
										?> 
									</div>
								</div>
								<div class="control-group">
									<?php echo CHtml::label('Vagina', 'periksadalam_vagina', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textArea($modGinekologi, 'periksadalam_vagina', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);"));
										?> 
									</div>
								</div>
								<div class="control-group">
									<?php echo CHtml::label('Portio', 'periksadalam_portio', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textArea($modGinekologi, 'periksadalam_portio', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);"));
										?> 
									</div>
								</div>
								<div class="control-group">
									<?php echo CHtml::label('Adneksa Kanan', 'periksadalam_adneksakanan', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textArea($modGinekologi, 'periksadalam_adneksakanan', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);"));
										?> 
									</div>
								</div>
								<div class="control-group">
									<?php echo CHtml::label('Adneksa Kiri', 'periksadalam_adneksakiri', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textArea($modGinekologi, 'periksadalam_adneksakiri', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);"));
										?> 
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="control-group">
									<?php echo CHtml::label('CU', 'periksadalam_cu', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textArea($modGinekologi, 'periksadalam_cu', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);"));
										?> 
									</div>
								</div>
								<div class="control-group">
									<?php echo CHtml::label('CD', 'periksadalam_cd', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textArea($modGinekologi, 'periksadalam_cd', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);"));
										?> 
									</div>
								</div>
								<div class="control-group">
									<?php echo CHtml::label('Inspeculo', 'periksadalam_inspeculo', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textArea($modGinekologi, 'periksadalam_inspeculo', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);"));
										?> 
									</div>
								</div>
								<div class="control-group">
									<?php echo CHtml::label('Rectal Toucher', 'periksadalam_rectaltoucher', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textArea($modGinekologi, 'periksadalam_rectaltoucher', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);"));
										?> 
									</div>
								</div>
							</div>
						</div>				
					</div>
				</div>
				<div style="margin-top: 20px !important;" class="panel panel-darkk">
					<span class="group-title">
						Status Lokalis & Skor Pelvik
					</span>
					<div class="panel-body" style="padding-top:5px !important;">
						<div class="row">
							<div class="col-sm-6">
								<div class="control-group">
									<?php echo CHtml::label('Status Lokalis Abdomen', 'statuslokalis_abdomen', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textArea($modGinekologi, 'statuslokalis_abdomen', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);"));
										?> 
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="control-group">
									<?php echo CHtml::label('Skor Pelvis', 'skor_pelvis', array('class' => 'control-label')) ?>
									<div class="controls">
										<?php
										echo $form->textArea($modGinekologi, 'skor_pelvis', array('class'=>'span3','onkeypress' => "return $(this).focusNextInputField(event);"));
										?> 
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div style="margin-top: 20px !important;" class="panel panel-darkk">
					<span class="group-title">
						Pemeriksaan Anggota Tubuh
					</span>
					<div class="panel-body" style="padding-top:5px !important;">
						<?php $this->renderPartial($this->path_view.'ginekologi/_pemeriksaanAnggotaTubuh',array('modPemeriksaanGambar'=>$modPemeriksaanGambar)); ?>
					</div>
				</div>
				<div style="margin-top: 20px !important;" class="panel panel-darkk">
					<span class="group-title">
						Rencana Pengobatan
					</span>
					<div class="panel-body" style="padding-top:5px !important;">
						<div class="row">
							<div class="col-sm-6">
								<div class="control-group">
									<?php echo CHtml::label('Ginekologis', 'periksadalam_rectaltoucher', array('class' => 'control-label')) ?>
									<div class="controls" style="width: 70%;">
										<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modGinekologi,'attribute'=>'rencanapengobatan_ginekologis','toolbar'=>'mini','height'=>'200px'));?> 
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="control-group">
									<?php echo CHtml::label('Medikamentosa', 'periksadalam_rectaltoucher', array('class' => 'control-label')) ?>
									<div class="controls" style="width: 70%;">
									<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modGinekologi,'attribute'=>'rencanapengobatan_medikamentosa','toolbar'=>'mini','height'=>'200px'));?> 
									</div>
								</div>
							</div>
						</div>
					
					</div>
				</div>

				<div style="margin-top: 20px !important;" class="panel panel-darkk">
					<span class="group-title">
						Lain-lain/ Keterangan Tambahan
					</span>
					<div class="panel-body" style="padding-top:5px !important; width: 100%">
						<?php $this->widget('ext.redactorjs.Redactor',array('model'=>$modGinekologi,'attribute'=>'keterangan_tambahan','toolbar'=>'mini','height'=>'200px'));?> 
					</div>
				</div>

			</div>

		</div>
	</div>
</div>
