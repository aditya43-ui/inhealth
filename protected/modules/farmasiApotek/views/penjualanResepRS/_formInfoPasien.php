<div class="panel panel-success">
	<div class="panel-heading">
		<div class="panel-title">
			<i class="entypo-user"></i> Data Pasien
			<span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setInfoPasienReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
		</div>
	</div>
	<div class="panel-body">
		<div class="col-sm-6">
			<div class="control-group">
				<?php echo CHtml::label("Instalasi <font style=color:red;> * </font>", 'instalasi_id', array('class' => 'control-label required')); ?>
				<div class="controls">
					<?php
					if (!empty($modInfoRI->pendaftaran_id)) {
						//                 echo CHtml::hiddenField('instalasi_id',$modInfoRI->ruangan->instalasi_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
						echo CHtml::textField('instalasi_nama', $modInfoRI->ruangan->instalasi->instalasi_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
					} else {
						echo CHtml::dropDownList('instalasi_id', $modInfoRI->instalasi_id, CHtml::listData(FAInstalasiM::model()->getInstalasiCustom(Params::FILTER_INSTALASI_ID_FOR_PENJUALANRESEP_RS), 'instalasi_id', 'instalasi_nama'), array('empty'=>'-- Pilih --', 'onchange' => 'setInfoPasienReset();refreshDialogInfoPasien();', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)",));
					}
					?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::hiddenField('pendaftaran_id', $modInfoRI->pendaftaran_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				<?php
				$pasienadmisi_id = (isset($modInfoRI->pasienadmisi_id) ? $modInfoRI->pasienadmisi_id : null);
				echo CHtml::hiddenField('pasienadmisi_id', $pasienadmisi_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
				?>
				<?php //echo CHtml::label("Barcode", 'cari_pendaftaran_id', array('class'=>'control-label')); 
				?>
				<div class="controls">
					<?php echo CHtml::hiddenField('cari_pendaftaran_id', $modInfoRI->pendaftaran_id, array('onchange' => "if($(this).val()=='') setKunjunganReset(); else setKunjungan(this.value,'','','')", 'class' => 'span3', 'placeholder' => 'Scan Barcode Pada Print Status', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label("No. Pendaftaran <font style=color:red;> * </font>", 'no_pendaftaran', array('class' => 'control-label required')); ?>
				<div class="controls">
					<?php
					$this->widget('MyJuiAutoComplete', array(
						'name' => 'no_pendaftaran',
						'value' => $modInfoRI->no_pendaftaran,
						'source' => 'js: function(request, response) {
								$.ajax({
									url: "' . $this->createUrl('AutocompleteInfoPasien') . '",
									dataType: "json",
									data: {
										no_pendaftaran: request.term,
										instalasi_id: $("#instalasi_id").val(),
									},
									success: function (data) {
										response(data);
									}
								})
							}',
						'options' => array(
							'minLength' => 4,
							'focus' => 'js:function( event, ui ) {
									$(this).val( "");
									return false;
								}',
							'select' => 'js:function( event, ui ) {
									$(this).val( ui.item.value);
									setInfoPasien(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
									return false;
								}',
						),
						'tombolDialog' => array('idDialog' => 'dialogPasien'),
						'htmlOptions' => array(
							'placeholder' => 'Ketik No. Pendaftaran', 'class' => 'span3 all-caps', 'rel' => 'tooltip', 'title' => 'Ketik no. pendaftaran / klik icon untuk mencari data kunjungan',
							'onkeyup' => "return $(this).focusNextInputField(event)",
						),
					));
					?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Tgl. Pendaftaran', 'tgl_pendaftaran', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::textField('tgl_pendaftaran', $modInfoRI->tgl_pendaftaran, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
					<?php //echo CHtml::hiddenField('tglselesaiperiksa',$modInfoRI->tglselesaiperiksa,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
					?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label("Poliklinik / Ruangan", 'ruangan_nama', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php
					$ruangan_id = null;
					if (isset($modInfoRI->ruangan_id)) {
						$ruangan_id = $modInfoRI->ruangan_id;
					}

					echo CHtml::hiddenField('ruangan_id', $ruangan_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
					?>
					<?php echo CHtml::textField('ruangan_nama', $modInfoRI->ruangan_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));  ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label("Kelas Pelayanan", 'kelaspelayanan_id', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::hiddenField('kelaspelayanan_id', $modInfoRI->kelaspelayanan_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
					<?php echo CHtml::textField('kelaspelayanan_nama', $modInfoRI->kelaspelayanan_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label("Kamar Ruangan", 'kamarruangan_nokamar', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::hiddenField('kamarruangan_id', $modInfoRI->kamarruangan_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
					<?php echo CHtml::textField('kamarruangan_nokamar', $modInfoRI->kamarruangan_nokamar, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label("No Bed", 'kamarruangan_nobed', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::hiddenField('kamarruangan_id', $modInfoRI->kamarruangan_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
					<?php echo CHtml::textField('kamarruangan_nobed', $modInfoRI->kamarruangan_nobed, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label("Jenis Kasus Penyakit", 'jeniskasuspenyakit_nama', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::hiddenField('jeniskasuspenyakit_id', $modInfoRI->jeniskasuspenyakit_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
					<?php echo CHtml::textField('jeniskasuspenyakit_nama', $modInfoRI->jeniskasuspenyakit_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
					?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Jenis Penjamin', 'carabayar_nama', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::hiddenField('carabayar_id', $modInfoRI->carabayar_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
					<?php echo CHtml::textField('carabayar_nama', $modInfoRI->carabayar_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label("Penjamin", 'penjamin_nama', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::hiddenField('penjamin_id', $modInfoRI->penjamin_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
					<?php echo CHtml::textField('penjamin_nama', $modInfoRI->penjamin_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div align="center">
				<?php
				$url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory() . "kecil_" . $modPasien->photopasien : Params::urlPhotoPasienDirectory() . "no_photo.jpeg");
				?>
				<img id="photo-preview" src="<?php echo $url_photopasien ?>" width="128px" />
			</div><br>
		</div>
		<div class="col-sm-6">
			<div class="control-group">
				<?php echo CHtml::label("No. Rekam Medik <font style=color:red;> * </font>", 'no_rekam_medik', array('class' => 'control-label required')); ?>
				<div class="controls">
					<?php echo CHtml::hiddenField('pasien_id', $modInfoRI->pasien_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
					<?php // echo CHtml::textField('no_rekam_medik',$modInfoRI->no_rekam_medik,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
					?>
					<?php
					$this->widget('MyJuiAutoComplete', array(
						'name' => 'no_rekam_medik',
						'value' => $modInfoRI->no_rekam_medik,
						'source' => 'js: function(request, response) {
								$.ajax({
									url: "' . $this->createUrl('AutocompleteInfoPasien') . '",
									dataType: "json",
									data: {
										no_rekam_medik: request.term,
										instalasi_id: $("#instalasi_id").val(),
									},
									success: function (data) {
										response(data);
									}
								})
							}',
						'options' => array(
							'minLength' => 4,
							'focus' => 'js:function( event, ui ) {
									$(this).val( "");
									return false;
								}',
							'select' => 'js:function( event, ui ) {
									$(this).val( ui.item.value);
									setInfoPasien(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
									return false;
								}',
						),
						'htmlOptions' => array(
							'placeholder' => 'Ketik No. Rekam Medik', 'rel' => 'tooltip', 'title' => 'Ketik no. rekam medik untuk mencari data kunjungan',
							'onkeyup' => "return $(this).focusNextInputField(event)",
							'class' => 'span3 numbers-only',
						),
					));
					?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label("Nama Pasien <font style=color:red;> * </font>", 'nama_pasien', array('class' => 'control-label required')); ?>
				<div class="controls">
					<?php //echo CHtml::hiddenField('namadepan',$modInfoRI->namadepan,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
					?>
					<?php
					$this->widget('MyJuiAutoComplete', array(
						'name' => 'nama_pasien',
						'value' => $modInfoRI->nama_pasien,
						'source' => 'js: function(request, response) {
								$.ajax({
									url: "' . $this->createUrl('AutocompleteInfoPasien') . '",
									dataType: "json",
									data: {
										nama_pasien: request.term,
										instalasi_id: $("#instalasi_id").val(),
									},
									success: function (data) {
										response(data);
									}
								})
							}',
						'options' => array(
							'minLength' => 2,
							'focus' => 'js:function( event, ui ) {
									$(this).val( "");
									return false;
								}',
							'select' => 'js:function( event, ui ) {
									$(this).val( ui.item.value);
									setInfoPasien(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
									return false;
								}',
						),
						'htmlOptions' => array(
							'class' => 'span3', 'placeholder' => 'Ketik Nama Pasien', 'rel' => 'tooltip', 'title' => 'Ketik nama pasien untuk mencari data kunjungan',
							'onkeyup' => "return $(this).focusNextInputField(event)",
						),
					));
					?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Alias', 'nama_bin', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::textField('nama_bin', $modInfoRI->nama_bin, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Tanggal Lahir', 'tanggal_lahir', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::textField('tanggal_lahir', $modInfoRI->tanggal_lahir, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label("Umur", 'umur', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::textField('umur', $modInfoRI->umur, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">							
				<?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::textField('jeniskelamin', $modInfoRI->jeniskelamin, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label("Nama Penanggung Jawab", 'nama_pj', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::hiddenField('penanggungjawab_id', $modInfoRI->penanggungjawab_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
					<?php echo CHtml::textField('nama_pj', $modInfoRI->nama_pj, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label("DPJP", 'dpjp', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::hiddenField('dpjp1_id', $modInfoRI->dpjp1_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
					<?php //$dokter = PegawaiM::model()->findByPk($modInfoRI->dpjp1_id);?>
					<?php echo CHtml::textField('nama_pegawai',  $modInfoRI->nama_pegawai, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="control-group">
				<?php echo CHtml::label("Alamat Pasien", 'alamat_pasien', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::textArea('alamat_pasien', $modInfoRI->alamat_pasien, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->renderPartial('_dialogPasien'); ?>