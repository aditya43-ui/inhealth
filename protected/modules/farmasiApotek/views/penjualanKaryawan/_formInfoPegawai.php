<div class="panel panel-success">
	<div class="panel-heading">
		<div class="panel-title"><span class='judul'>Data Karyawan</span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setInfoPegawaiReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></div>
	</div>
	<div class="panel-body">
		<div class="row-fluid">

			<div class="col-sm-6">
				<div class="control-group ">
					<?php echo $form->labelEx($modPenjualan, 'jenispenjualan', array('readonly' => true, 'class' => 'control-label')) ?>
					<div class="controls">
						<?php
						echo CHtml::textField('jenispenjualan_nama','PENJUALAN KARYAWAN',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));
						echo CHtml::activeHiddenField($modPenjualan,'jenispenjualan');
						// echo $form->dropDownList($modPenjualan,'jenispenjualan', LookupM::getItems('jenispenjualan'),
						// 	array('empty'=>'-- Pilih --','disabled'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3', 'onchange'=>'jenisPenjualan()'
						//)); 
						?>
					</div>
				</div>
				<?php echo CHtml::hiddenField('pasien_id', '', array('readonly' => true)); ?>
				<?php echo CHtml::activeHiddenField($modPenjualan, 'pasienpegawai_id', array('readonly' => true)); ?>
				<div class="control-group" id="karyawan">
					<label class="control-label" for="FAPegawaiV_nomorindukpegawai">NIP</label>
					<div class="controls">
						<?php
						$this->widget('MyJuiAutoComplete', array(
							'model' => $modInfoPegawai,
							'attribute' => 'nomorindukpegawai',
							'value' => $modInfoPegawai->nomorindukpegawai,
							'source' => 'js: function(request, response) {
									$.ajax({
										url: "' . $this->createUrl('AutocompleteInfoPegawai') . '",
										dataType: "json",
										data: {
											nomorindukpegawai: request.term,
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
										setInfoPegawai(ui.item.pegawai_id, ui.item.nomorindukpegawai, ui.item.nama_pegawai);
										return false;
									}',
							),
							'tombolDialog' => array('idDialog' => 'dialogPegawaiKaryawan'),
							'htmlOptions' => array(
								'placeholder' => 'Ketik NIP', 'class' => 'span3 all-caps', 'rel' => 'tooltip', 'title' => 'Ketik no. pendaftaran / klik icon untuk mencari data pegawai',
								'onkeyup' => "return $(this).focusNextInputField(event)",
							),
						));
						?>
					</div>
				</div>
				<div class="control-group" id="dokter" style="display: none;">
					<label class="control-label" for="FADokterV_nomorindukpegawai">NIP</label>
					<div class="controls">
						<?php
						$this->widget('MyJuiAutoComplete', array(
							'model' => $modInfoDokter,
							'attribute' => 'nomorindukpegawai',
							'value' => $modInfoDokter->nomorindukpegawai,
							'source' => 'js: function(request, response) {
									$.ajax({
										url: "' . $this->createUrl('AutocompleteInfoDokter') . '",
										dataType: "json",
										data: {
											nomorindukpegawai: request.term,
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
										setInfoDokter(ui.item.pegawai_id, ui.item.nomorindukpegawai, ui.item.nama_pegawai);
										return false;
									}',
							),
							'tombolDialog' => array('idDialog' => 'dialogPegawaiDokter'),
							'htmlOptions' => array(
								'placeholder' => 'Ketik NIP', 'class' => 'span3 all-caps', 'rel' => 'tooltip', 'title' => 'Ketik no. pendaftaran / klik icon untuk mencari data dokter',
								'onkeyup' => "return $(this).focusNextInputField(event)",
							),
						));
						?>
					</div>
				</div>
				<div class="control-group ">
					<label class="control-label" for="FAPegawaiV_nama_pegawai">Nama</label>
					<div class="controls">
						<?php
						$this->widget('MyJuiAutoComplete', array(
							'name' => 'nama_pegawai',
							'value' => $modInfoPegawai->nama_pegawai,
							'source' => 'js: function(request, response) {
									$.ajax({
										url: "' . $this->createUrl('AutocompleteInfoPegawai') . '",
										dataType: "json",
										data: {
											nama_pegawai: request.term,
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
										setInfoPegawai(ui.item.pegawai_id, ui.item.nomorindukpegawai, ui.item.nama_pegawai);
										return false;
									}',
							),
							'htmlOptions' => array(
								'placeholder' => 'Ketik Nama Pegawai', 'class' => 'span3 all-caps', 'rel' => 'tooltip', 'title' => 'Ketik no. pendaftaran / klik icon untuk mencari data pegawai',
								'onkeyup' => "return $(this).focusNextInputField(event)",
							),
						))
						?>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="control-group">
					<?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo CHtml::textField('jeniskelamin', $modInfoPegawai->jeniskelamin, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
					</div>
				</div>
				<div class="control-group">
					<?php echo CHtml::label("Alamat Karyawan", 'alamat_pegawai', array('class'=>'control-label')); ?>
					<div class="controls">
						<?php echo CHtml::textArea('alamat_pegawai', $modInfoPegawai->alamat_pegawai, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
					</div>
				</div>
				<div align="center">
					<?php
					$url_photopasienpegawai = (!empty($modInfoPegawai->photopegawai) ? Params::urlPegawaiTumbsDirectory() . "kecil_" . $modInfoPegawai->photopegawai : Params::urlPegawaiDirectory() . "no_photo.jpeg");
					?>
					<img id="photo-preview" src="<?php echo $url_photopasienpegawai; ?>" width="128px" />
				</div><br>
			</div>
		</div>
		<?php
		//========= Dialog buat cari data pegawai =========================
		$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
			'id'=>'dialogPegawaiKaryawan',
			'options'=>array(
				'title'=>'Pencarian Data Karyawan',
				'autoOpen'=>false,
				'modal'=>true,
				'width'=>980,
				'height'=>550,
				'resizable'=>false,
			),
		));
		if (!isset($_GET['sukses'])) { //RND-5894
			$modDialogPegawai = new FAPegawaiV('search');
			$modDialogPegawai->unsetAttributes();
			if (isset($_GET['FAPegawaiV'])) {
				$modDialogPegawai->attributes = $_GET['FAPegawaiV'];
			}

			$this->widget('ext.bootstrap.widgets.BootGridView', array(
				'id' => 'datakunjungankaryawan-grid',
				'dataProvider' => $modDialogPegawai->search(),
				'filter' => $modDialogPegawai,
				//'template'=>"{items}\n{pager}",
				'template' => "{summary}\n{items}\n{pager}",
				'itemsCssClass' => 'table table-striped table-bordered table-condensed',
				'columns' => array(
					array(
						'header' => 'Pilih',
						'type' => 'raw',
						'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small",
								"id" => "selectPegawai",
								"onClick" => "
									setInfoPegawai($data->pegawai_id, \"\", \"\", \"\");
									$(\"#dialogPegawaiKaryawan\").dialog(\"close\");
								"))',
					),
					'gelardepan',
					'nomorindukpegawai',
					'nama_pegawai',
					'jeniskelamin',
					'alamat_pegawai',
				),
				'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
			));
		}
		$this->endWidget();
		////======= end pendaftaran dialog =============
		?>

		<?php
		//========= Dialog buat cari data dokter =========================
		$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
			'id' => 'dialogPegawaiDokter',
			'options' => array(
				'title' => 'Pencarian Data Dokter',
				'autoOpen' => false,
				'modal' => true,
				'width' => 980,
				'height' => 480,
				'resizable' => false,
			),
		));
		if (!isset($_GET['sukses'])) { //RND-6185 => diubah ke pagawai_m (disamakan dengan pilih dokter resep)
			$modDialogDokter = new PegawaiM('searchByDokter');
			$modDialogDokter->unsetAttributes();
			if (isset($_GET['PegawaiM'])) {
				$modDialogDokter->attributes = $_GET['PegawaiM'];
			}

			$this->widget('ext.bootstrap.widgets.BootGridView', array(
				'id' => 'datakunjungandokter-grid',
				'dataProvider' => $modDialogDokter->searchByDokter(),
				'filter' => $modDialogDokter,
				'template' => "{items}\n{pager}",
				//        'template'=>"{summary}\n{items}\n{pager}",
				'itemsCssClass' => 'table table-striped table-bordered table-condensed',
				'columns' => array(
					array(
						'header' => 'Pilih',
						'type' => 'raw',
						'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small",
								"id" => "selectPegawai",
								"onClick" => "
									setInfoDokter($data->pegawai_id, \"\", \"\", \"\");
									$(\"#dialogPegawaiDokter\").dialog(\"close\");
								"))',
					),
					'gelardepan',
					'nomorindukpegawai',
					'nama_pegawai',
					'jeniskelamin',
					'alamat_pegawai',
				),
				'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
			));
		}
		$this->endWidget();
		////======= end pendaftaran dialog =============
		?>
	</div>
</div>