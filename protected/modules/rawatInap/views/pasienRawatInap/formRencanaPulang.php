<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'pasienpulang-t-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
	'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
	'focus' => '#',
));
$this->widget('bootstrap.widgets.BootAlert'); ?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary(array($model)); ?>

<div class="col-sm-6">
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">Rencana Pulang</div>
		</div>
		<div class="panel-body">
			<div class="control-group ">
				<?php echo $form->labelEx($modPasien, 'no_rekam_medik', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					echo $form->textField($modPasien, 'no_rekam_medik', array('class' => 'span3', 'readonly' => true));
					echo $form->hiddenField($modelAdmisi, 'pasienadmisi_id', array('class' => 'span3', 'readonly' => true));
					?>
					<?php echo $form->error($modPasien, 'no_rekam_medik'); ?>
				</div>
			</div>

			<div class="control-group ">
				<?php echo $form->labelEx($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					echo $form->textField($modPendaftaran, 'no_pendaftaran', array('class' => 'span3', 'readonly' => true));
					?>
					<?php echo $form->error($modPendaftaran, 'no_pendaftaran'); ?>
				</div>
			</div>

			<div class="control-group ">
				<?php echo $form->labelEx($modPasien, 'nama_pasien', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					echo $form->textField($modPasien, 'nama_pasien', array('class' => 'span3', 'readonly' => true));
					?>
					<?php echo $form->error($modPasien, 'nama_pasien'); ?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo $form->labelEx($modPendaftaran, 'carabayar_id', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					echo $form->textField($modPendaftaran->carabayar, 'carabayar_nama', array('class' => 'span3', 'readonly' => true));
					?>
					<?php // echo $form->error($modPasien, 'nama_pasien'); 
					?>
				</div>
			</div>
			<?php if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS) : ?>
				<div class="control-group ">
					<?php echo $form->labelEx($modPendaftaran, 'sep_id', array('class' => 'control-label', 'label' => 'No. SEP')) ?>
					<div class="controls">
						<?php
						$sep = SepT::model()->findByPk($modelAdmisi->sep_id); // karena pasien rawat inap pengambilan data dari pasien admisi
						//$sep = SepT::model()->find();
						if (!empty($sep)) {
							$modPendaftaran->sep_id = $sep->sep_id;
						} else {
							$modPendaftaran->sepTs = new SepT;
						}
						echo $form->hiddenField($modPendaftaran, 'sep_id');
						echo $form->textField($modPendaftaran->sepTs, 'nosep', array('class' => 'span3', 'readonly' => true));
						?>
						<?php // echo $form->error($modPasien, 'nama_pasien'); 
						?>
					</div>
				</div>
			<?php endif; ?>
			<div class="control-group ">
				<?php echo $form->labelEx($model, 'rencanapulang', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $model,
						'attribute' => 'rencanapulang',
						'mode' => 'datetime',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							//                                                        'maxDate' => 'd',
						),
						'htmlOptions' => array(
							'class' => 'dtPicker3 span3',
						),
					)); ?>
					<?php echo $form->error($model, 'rencanapulang'); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-sm-6">
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">
				<?php echo CHtml::checkBox('isKontrol', false, array('onkeypress' => "return $(this).focusNextInputField(event)")) ?>
				Rencana Kontrol Pasien
			</div>
		</div>
		<div class="panel-body">
			<?php
			$ruangan = RuanganM::model()->findAllByAttributes(array(
				'instalasi_id' => Params::INSTALASI_ID_RJ,
				'ruangan_aktif' => true,
			), array(
				'order' => 'ruangan_nama',
			));

			echo $form->dropDownListRow($modPendaftaran, 'ruangankontrol_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array(
				'empty' => '-- Pilih --', 'disabled' => true, 'onchange' => 'openTglKontrol(this); loadDokterDanRuangan();', 'class' => 'span3'
			));
			?>
			<div class="control-group " id="tanggal_kontrol">
				<?php echo CHtml::label('Tanggal Rencana Kontrol', 'tglrenkontrol', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $modPendaftaran,
						'attribute' => 'tglrenkontrol',
						'mode' => 'datetime',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'onSelect' => 'js: function(date) { 																	
											   loadDokterDanRuangan(date);
										}',
							'minDate' => 'd+1'
						),
						'htmlOptions' => array(
							//'onchange' => 'cekJadwalPoli(this)',
							//'onblur' => 'cekJadwalPoli(this)',
							'readonly' => true,
							'class' => 'dtPicker3 span3',
							'disabled' => true
						),
					));
					?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo CHtml::label('Dokter Tujuan Kontrol', 'doktertujuankontrol_id', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					if ($modPendaftaran->carabayar_id != Params::CARABAYAR_ID_BPJS || Yii::app()->user->getState('isbridging') == false) {
						echo $form->dropDownList($modPendaftaran, 'doktertujuankontrol_id', CHtml::listData(DokterV::model()->findAllByAttributes(array(
							'kelompokpegawai_id' => Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
							'ruangan_id' => Yii::app()->user->getState('ruangan_id')
						)), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3'));
					} else {
						echo $form->dropDownList($modPendaftaran, 'doktertujuankontrol_id', array(), array('empty' => '-- Pilih --', 'class' => 'span3', 'class' => 'doktertujuankontrol_id'));
					}


					?>
					<?php echo $form->error($modPendaftaran, 'doktertujuankontrol_id'); ?>
				</div>
			</div>


			<div class="control-group ">
				<?php echo CHtml::label('Nomor Surat', '', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					echo $form->textField($modSuratKeterangan, 'nomorsurat', array('class' => 'span2', 'readonly' => true, 'style' => 'width:270px'));
					?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo CHtml::label('No. Surat Kontrol', 'nomorsurat_bpjs', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					echo $form->textField($modSuratKeterangan, 'nomorsurat_bpjs', array('class' => 'span3', 'readonly' => true));
					?>
					<?php echo $form->error($modSuratKeterangan, 'nomorsurat_bpjs'); ?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo CHtml::label('Tindakan', '', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					echo $form->textArea($modSuratKeterangan, 'kontrolri_tindakan', array('rows' => 6));
					?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo CHtml::label('Terapi Pulang', '', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					echo $form->textArea($modSuratKeterangan, 'kontrolri_terapipulang', array('rows' => 6));
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="clear"></div>

<div class="form-actions">
	<?php echo CHtml::htmlButton(
		Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')),
		array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'verifikasiSubmit()')
	); ?>
	<?php if (!empty($modPendaftaran->tglrenkontrol)) {
		echo CHtml::htmlButton(Yii::t('mds', '{icon} Print Kontrol', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-info',  'type' => 'button', 'onclick' => 'printKontrol(\'PRINT\')'));
	} else {
		echo CHtml::htmlButton(Yii::t('mds', '{icon} Print Kontrol', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-info', 'disabled' => true, 'type' => 'button'));
	}
	// cek resume
	$modResume = ResumemedisR::model()->findByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id], 'pasienadmisi_id is not null');
	if(!empty($modResume)) {
		$disable = false;
	} else {
		$disable = true;
	}
	echo CHtml::htmlButton(
                    
		Yii::t('mds', '{icon} Print Resume', array('{icon}' => '<i class="entypo-print"></i>')),
		array('class' => 'btn btn-success', 'type' => 'button', 'onclick' => 'printResume(' .$modPendaftaran->pendaftaran_id .')', 'disabled' => $disable)
	);
	if (isset($_GET['idPasienadmisi'])) {

		$modPasienAdmisi = PasienadmisiT::model()->findByPk($_GET['idPasienadmisi']);
		$criteria = new CDbCriteria;
		$criteria->addCondition("pendaftaran_id=" . $modPasienAdmisi->pendaftaran_id);
		$criteria->addCondition("nomorsurat_bpjs is not null");
		$criteria->order = "suratketerangan_id desc";
		$modSurat = SuratketeranganR::model()->find($criteria);
		if (empty($modSurat)) {
			$disable = true;
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Print SRK BPJS', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'disabled' => $disable));
		} else {
			$disable = false;
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Print SRK BPJS', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => "printSRK('$modSurat->pendaftaran_id')", 'disabled' => $disable));
		}
		
	}

	?>
	<?php echo CHtml::htmlButton(
		Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="icon-refresh icon-white"></i>')),
		array('class' => 'btn btn-danger', 'onclick' => 'konfirmasi()')
	); ?>

</div>

<?php $this->endWidget(); ?>
<?php
if ($tersimpan == 'Ya') {
?>
	<script>
		//parent.location.reload();
	</script>
<?php
}
?>
<script>
	function printResume(pendaftaran_id) {
        window.open('<?php echo $this->createUrl('/rekamMedis/resumeMedis/print'); ?>&pendaftaran_id=' + pendaftaran_id, 'printwin', 'left=100,top=100,width=480,height=640');
    }
	function konfirmasi() {
		myConfirm("<?php echo Yii::t('mds', 'Do You want to cancel?') ?>", "Perhatian!", function(r) {
			if (r) {
				$('#iframeRencanaPulang').attr('src', $(this).attr("href"));
				window.parent.$('#dialogRencanaPulang').dialog('close');
				return false;
			} else {
				$('#RIPasienM_no_rekam_medik').focus();
				return false;
			}
		});
	}

	/**
	 * - digunakan untuk menambahkan fungsi, ketika chekbox rencana kontrol pasien dipilih atau tidak
	 * @added	27 Januari 2018
	 * @param {type} param
	 */
	$('#isKontrol').change(function() {
		if ($(this).is(':checked')) {
			$('#RIPendaftaranT_tglrenkontrol, #RIPendaftaranT_ruangankontrol_id').removeAttr('disabled');
			//$('#RIPendaftaranT_tglrenkontrol').val('<?php //echo Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-MM-dd HH:ii:ss'));
														?>');
			$("#RIPendaftaranT_ruangankontrol_id").addClass('required');
			$("#RIPendaftaranT_tglrenkontrol").addClass('required');
			$("#RIPendaftaranT_ruangankontrol_id").val('');
		} else {
			$('#RIPendaftaranT_tglrenkontrol, #RIPendaftaranT_ruangankontrol_id').attr('disabled', 'true');
			$('#RIPendaftaranT_tglrenkontrol').val('');
			$("#RIPendaftaranT_ruangankontrol_id").val('');
			$("#RIPendaftaranT_ruangankontrol_id").removeClass('required');
			$("#RIPendaftaranT_tglrenkontrol").removeClass('required');
			openTglKontrol($('#RIPendaftaranT_tglrenkontrol'));
		}
	});

	function printKontrol(caraPrint) {
		var pasienpulang_id = '<?php echo isset($modelPulang->pasienpulang_id) ? $modelPulang->pasienpulang_id : null ?>';
		window.open('<?php echo $this->createUrl('printPasienKontrol'); ?>&pasienpulang_id=' + pasienpulang_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
	}

	/**
	 * - digunakan untuk, menampilkan tanggal rencana kontrol dan meresetnya
	 * @added	27 Januari 2018
	 * @param {type} obj
	 * @returns {menampilkan field tanggal kontrol}
	 */

	function openTglKontrol(obj) {
		var ruangan = $(obj).val();

		if (ruangan == '') {
			$("#tanggal_kontrol").attr('style', 'display:none;');
			$("#<?php echo CHtml::activeId($modPendaftaran, 'tglrenkontrol') ?>").val('');
		} else {
			$("#tanggal_kontrol").attr('style', 'display:block;');
			$("#<?php echo CHtml::activeId($modPendaftaran, 'tglrenkontrol') ?>").val('');
		}
	}

	/**
	 * - digunakan untuk memeriksa jam buka jadwal Poli
	 * @added	27 Januari 2018
	 * @param {type} obj
	 * @returns {cek validasi, jika tanggal lebih dari hari ini, dan jam buka poli tidak lebih dari jam akhir buka dan tidak kurang dari jam awal buka}
	 */
	function cekJadwalPoli(tanggal) {
		//function cekJadwalPoli(obj){


		var waktu = tanggal;

		var rencanapulang = $("#<?php echo CHtml::activeId($modelAdmisi, 'rencanapulang') ?>").val();
		var ruangan = $("#<?php echo CHtml::activeId($modPendaftaran, 'ruangankontrol_id') ?>").val();

		$.ajax({
			type: 'POST',
			url: '<?php echo $this->createUrl('cekJadwalPoli'); ?>',
			data: {
				waktu: waktu,
				ruangan_id: ruangan,
				rencanapulang: rencanapulang
			},
			dataType: "json",
			success: function(data) {
				if (data.validateTgl == 1) {
					if (data.sukses == 0) {
						$("#<?php echo CHtml::activeId($modPendaftaran, 'tglrenkontrol') ?>").val('');
						$("#<?php echo CHtml::activeId($modPendaftaran, 'tglrenkontrol') ?>").attr('value', '');
						alert(data.pesan);
					}
				} else {
					$("#<?php echo CHtml::activeId($modPendaftaran, 'tglrenkontrol') ?>").val('');
					$("#<?php echo CHtml::activeId($modPendaftaran, 'tglrenkontrol') ?>").attr('value', '');
					alert(data.pesan);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});


	}

	/**
	 * - digunakan untuk mengenerate prinout rencana kontrol pasien
	 */
	function printKontrol(caraPrint) {
		var pasienadmisi_id = '<?php echo isset($modelAdmisi->pasienadmisi_id) ? $modelAdmisi->pasienadmisi_id : null ?>';
		window.open('<?php echo $this->createUrl('printPasienKontrolRencana'); ?>&pasienadmisi_id=' + pasienadmisi_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
	}

	function loadDokterDanRuangan() {
		setLoadDokterKontrol();
		setLoadRencanaKontrol();
	}

	function setLoadDokterKontrol() {
		var tgl = $("#RIPendaftaranT_tglrenkontrol").val();
		var ruangan_id = $("#RIPendaftaranT_ruangankontrol_id").val();
		<?php if ($modelAdmisi->carabayar_id != Params::CARABAYAR_ID_BPJS || Yii::app()->user->getState('isbridging') == false) : ?>
			if (ruangan_id != "" && tgl != "") {
				cekJadwalPoli(tgl);
			}

			$.post('<?php echo $this->createUrl('cekPraktekDokter'); ?>', {
				ruangan_id: ruangan_id,
				tgl: tgl
			}, function(data) {
				if (data.ok == 0) {
					myAlert(data.msg, "Dokter");
				} else {
					$(".doktertujuankontrol_id").html(data.html).multiselect('rebuild');
				}
			}, 'json');


			return false;
		<?php endif; ?>


		if (ruangan_id == "" || tgl == "") {
			$(".doktertujuankontrol_id").html("").multiselect('rebuild');
		} else {
			$.post('<?php echo $this->createUrl('vclaimCekPraktekDokter'); ?>', {
				ruangan_id: ruangan_id,
				tgl: tgl
			}, function(data) {
				if (data.ok == 0) {
					myAlert(data.msg, "VClaim - Dokter");
				} else {
					$(".doktertujuankontrol_id").html(data.html).multiselect('rebuild');
				}
			}, 'json');
		}
	}

	function setLoadRencanaKontrol() {

		<?php if ($modelAdmisi->carabayar_id != Params::CARABAYAR_ID_BPJS || Yii::app()->user->getState('isbridging') == false) : ?>
			return false;
		<?php endif; ?>


		var ruangan_id = $("#RIPendaftaranT_ruangankontrol_id").val();
		var tgl = $("#RIPendaftaranT_tglrenkontrol").val();
		var sep_id = $("#RIPendaftaranT_sep_id").val();


		if (ruangan_id == "" || tgl == "") {
			// $(".doktertujuankontrol_id").html("");
		} else {
			$.post('<?php echo $this->createUrl('vclaimCekRuangan'); ?>', {
				sep_id: sep_id,
				ruangan_id: ruangan_id,
				tgl: tgl
			}, function(data) {
				if (data.ok == 0) {
					myAlert(data.msg, "VClaim - Ruangan");
				}
			}, 'json');
		}
	}

	function verifikasiSubmit() {
		<?php if ($modelAdmisi->carabayar_id == Params::CARABAYAR_ID_BPJS && Yii::app()->user->getState('isbridging') == false) : ?>
			myAlert("Bridging BPJS Tidak Aktif ! Rencana Kontrol tidak akan terbridging dengan BPJS", "Peringatan", function() {
				$("#pasienpulang-t-form").submit();
			});
		<?php else : ?>
			$("#pasienpulang-t-form").submit();
		<?php endif; ?>
	}


	var input_dokter = $("<?php echo "#" . CHtml::activeId($modPendaftaran, 'doktertujuankontrol_id'); ?>");

	function setMultiselect() {
		jQuery(input_dokter).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true,
			onChange: function(element, checked) {
				console.log(checked, element);
			}
		}).hide();

	}

	$(document).ready(function() {
		setMultiselect();
	})

	function printSRK(id) {
		window.open('<?php echo $this->createUrl('/rawatJalan/daftarPasien/printRencanaKontrolBpjs'); ?>&pendaftaran_id=' + id + '&caraPrint=PRINT', 'printwin', 'left=100,top=100,width=860,height=480');
	}
</script>