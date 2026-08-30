<?php
$form = $this->beginWidget(
	'ext.bootstrap.widgets.BootActiveForm',
	array(
		'method' => 'post',
		'type' => 'horizontal',
		'id' => 'form-update-spri',
		'htmlOptions' => array(
			'onKeyPress' => 'return disableKeyPress(event)'
		),
	)
);
if (isset($_GET['sukses'])) {
	Yii::app()->user->setFlash('success', "Data SPRI berhasil disimpan");
}

$this->widget('bootstrap.widgets.BootAlert');
?>


<div class="row-fluid">
	<div class="col-sm-6">
		<div class="control-group ">
			<?php

			$modSep = empty($modPendaftaran->sepTs) ? new SepT : $modPendaftaran->sepTs;

			if (empty($modSep->nokartuasuransi) && !empty($asuransi)) {
				$modSep->nokartuasuransi = $asuransi->nokartuasuransi;
			}

			echo $form->label($modSep, 'modSurat', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				echo $form->textField($modSep, 'nokartuasuransi', array('class' => 'span3', 'readonly' => true));
				?>
				<?php echo $form->error($modSep, 'nokartuasuransi'); ?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo $form->label($modSurat, 'nomorspri_bpjs', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				echo $form->textField($modSurat, 'nomorspri_bpjs', array('class' => 'span3', 'readonly' => true));
				?>
				<?php echo $form->error($modSurat, 'nomorspri_bpjs'); ?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo $form->label($modSurat, 'tgl_rencanaranap', array('class' => 'control-label', 'label' => 'Tanggal Rencana Rawat Inap <span class="required">*</span>')) ?>
			<div class="controls">
				<?php
				$this->widget('MyDateTimePicker', array(
					'model' => $modSurat,
					'attribute' => 'tgl_rencanaranap',
					'mode' => 'date',
					'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
						// 'maxDate' => 'd',
					),
					'htmlOptions' => array('class' => 'dtPicker3 span3', 'onchange' => 'cekSpesialisVClaim();'),
				)); ?>
				<?php echo $form->error($modSurat, 'tgl_rencanaranap'); ?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo $form->label($modSurat, 'spesialissubspesialis_id', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				echo $form->dropDownList(
					$modSurat,
					'spesialissubspesialis_id',
					CHtml::listData(SpesialissubspesialisM::model()->findAll('spesialissubspesialis_aktif = true order by spesialissubspesialis_nama'), 'spesialissubspesialis_id', 'spesialissubspesialis_nama'),
					array('empty' => '-- Pilih --', 'class' => 'span3', 'onchange' => 'cekSpesialisVClaim();')
				);
				?>
				<?php echo $form->error($modSurat, 'spesialissubspesialis_id'); ?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::label('DPJP', 'dpjp_id', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($modSurat, 'dpjp_id', $modSurat->getItemPegawaiDokter(), array('empty' => '-- Pilih  --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

				<?php echo $form->error($modSurat, 'dpjp_id'); ?>
			</div>
		</div>

	</div>
</div>

<div class="form-actions">
	<?php echo CHtml::htmlButton(
		Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-floppy"></i>')),
		array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
	); ?>
</div>

<?php $this->endWidget(); ?>

<script>
	function cekSpesialisVClaim() {
		<?php if ($modPendaftaran->carabayar_id != Params::CARABAYAR_ID_BPJS) : ?>
			return false;
		<?php elseif (Yii::app()->user->getState('isbridging') != true) : ?>
			myAlert("Bridging BPJS Tidak Aktif, SPRI tidak akan terupdate ke BPJS !");
		<?php else : ?>

			var sep_id = $("#PendaftaranT_sep_id").val();
			var no_kartu = $("#SepT_nokartuasuransi").val();
			var spesialis_id = $("#SuratperintahranapT_spesialissubspesialis_id").val();
			var tgl = $("#SuratperintahranapT_tgl_rencanaranap").val();

			if (tgl == "") {
				myAlert("Tanggal rencana harus di isi.");
				return false;
			}

			$("#SuratperintahranapT_spesialissubspesialis_id").addClass('animation-loading');

			$.post('<?php echo $this->createUrl('cekVClaimSpesialis'); ?>', {
				no_kartu: no_kartu,
				spesialis_id: spesialis_id,
				tgl: tgl
			}, function(data) {
				if (data.ok == 0) {
					myAlert(data.msg);
				}

				$("#SuratperintahranapT_dpjp_id").html(data.html);
				$("#SuratperintahranapT_dpjp_id").multiselect('rebuild');
				$("#SuratperintahranapT_spesialissubspesialis_id").removeClass('animation-loading');

			}, 'json');


		<?php endif; ?>
	}

	$(document).ready(function() {

		jQuery($("#SuratperintahranapT_spesialissubspesialis_id")).multiselect({
			includeSelectAllOption: false,
			buttonClass: "form-control",
			maxHeight: 200,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true,
		}).hide();

		jQuery($("#SuratperintahranapT_dpjp_id")).multiselect({
			includeSelectAllOption: false,
			buttonClass: "form-control",
			maxHeight: 200,
			buttonWidth: '182px',
			enableCaseInsensitiveFiltering: true
		}).hide();

		$('#multiselect-native-select').find('.radio').attr('style', 'text-align: left;');
		cekSpesialisVClaim();
	});
</script>