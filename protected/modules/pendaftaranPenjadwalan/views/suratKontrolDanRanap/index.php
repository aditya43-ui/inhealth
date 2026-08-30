<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	return submitInformasiDetail();
});
");

?>


<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">
			Surat Kontrol dan SPRI
		</div>
	</div>
	<div class="panel-body">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
			</div>
			<div class="panel-body search-form">

				<?php
				$form = $this->beginWidget(
					'ext.bootstrap.widgets.BootActiveForm',
					array(
						'action' => Yii::app()->createUrl($this->route),
						'method' => 'get',
						'type' => 'horizontal',
						'id' => 'formCari',
						'htmlOptions' => array(
							'onKeyPress' => 'return disableKeyPress(event)'
						),
					)
				);
				?>

				<div class="control-group">
					<?php echo CHtml::label("Tanggal", 'tgl_rekam', array('class' => 'control-label')) ?>
					<div class="controls">
						<div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_akhir)) ?>">
							<i class="entypo-calendar"></i>
							<span><?php echo date('d F Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_akhir)) ?></span>
							<?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
							<?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
						</div>
					</div>
				</div>
				<div class="control-group">
					<?php echo CHtml::label("Berdasarkan", 'tgl_rekam', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php echo $form->dropDownList($model, 'cari_berdasarkan', array(
							'tglsurat' => 'Tanggal Surat',
							'tglrenkontrol' => 'Tanggal Rencana Kontrol/Ranap'
						)); ?>
					</div>
				</div>
				<div class="control-group">
					<?php echo CHtml::label("Jenis Surat", 'tgl_rekam', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php echo $form->checkBoxList($model, 'jenissurat', array(
							'1' => 'Rencana Kontrol',
							'2' => 'SPRI'
						)); ?>
					</div>
				</div>

				<div class="form-actions">
					<?php echo CHtml::htmlButton(
						Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
						array(
							'class' => 'btn btn-danger',
							'type' => 'submit',
							'title' => 'Cari'
						)
					); ?>
					<?php echo CHtml::link(
						Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
						$this->createUrl($this->id . '/index'),
						array(
							'class' => 'btn btn-default',
							'title' => 'Ulang',
							'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
						)
					); ?>
					<?php
					$content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiPasienRJ', array(), true);
					$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
				</div>

				<?php $this->endWidget(); ?>
			</div>
		</div>
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title"><i class="entypo-table"></i> Tabel Surat Kontrol & SPRI</div>
			</div>
			<div class="panel-body table-responsive">
				<div class="row-fluid">
					<?php echo CHtml::activeTextField($model, 'katakunci', array('class' => 'span3 katakunci'));
					echo CHtml::htmlButton('<i class="entypo-search"></i>', array(
						'class' => 'btn btn-danger', 'onclick' => 'cariInformasi()',
					)); ?>
				</div>
				<?php
				$this->renderPartial('_table', ['model' => $model]);
				?>
			</div>
		</div>
		<?php
		echo CHtml::link(
			Yii::t('mds', '{icon} Tambah Rencana Kontrol', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
			$this->createUrl('suratRencanaKontrol/index', array('modul_id' => Yii::app()->session['modul_id'])),
			array('class' => 'btn btn-danger', 'title' => 'Tambah jadwal dokter')
		);
		echo CHtml::link(
			Yii::t('mds', '{icon} Tambah SPRI', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
			$this->createUrl('suratPerintahRawatInapPP/index', array('modul_id' => Yii::app()->session['modul_id'])),
			array('class' => 'btn btn-danger', 'title' => 'Tambah jadwal dokter')
		);
		?>
	</div>
</div>

<script>
	function printSRK(id) {
		window.open('<?php echo $this->createUrl('/rawatJalan/daftarPasien/printRencanaKontrolBpjs'); ?>&pendaftaran_id=' + id + '&caraPrint=PRINT', 'printwin', 'left=100,top=100,width=860,height=480');
	}

	function printDetailSurat(id, jenis) {
		window.open('<?php echo $this->createUrl('view'); ?>&id=' + id + '&jenis=' + jenis + '&caraPrint=PRINT', 'printwin', 'left=100,top=100,width=860,height=480');
	}

	function printDetailSuratTanpaKunjungan(id, jenis) {
		window.open('<?php echo $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/printSRK'); ?>&id=' + id, 'printwin', 'left=100,top=100,width=640,height=480');
	}

	function cariInformasi() {
		$.fn.yiiGridView.update('srk-spri-grid', {
			data: $('.search-form form, .katakunci').serialize()
		});
		return false;
	}

	function submitInformasiDetail() {
		$(".katakunci").val("");
		return cariInformasi();
	}

	function hapusKontrolSPRI(id, jenis) {
		myConfirm("anda yakin untuk menghapus ini ?", "Peringatan", function(r) {
			if (r) {
				$.post('<?php echo $this->createUrl('hapusSurat'); ?>', {
					surat_id: id,
					jenissurat: jenis
				}, function(data) {
					if (data.ok == 1) {
						myAlert(data.msg);
						$.fn.yiiGridView.update('srk-spri-grid');
					} else {
						myAlert(data.msg);
					}
				}, 'json');
			}
		});
	}
</script>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'dialog-ranap',
	'options' => array(
		'title' => 'Update SPRI',
		'autoOpen' => false,
		'modal' => true,
		'minWidth' => 480,
		'height' => 480,
		'resizable' => false,
	),
));
echo '<iframe name="frame-ranap" width="100%" height="450"></iframe>';
?>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'dialog-kontrol',
	'options' => array(
		'title' => 'Update Rencana Kontrol',
		'autoOpen' => false,
		'modal' => true,
		'minWidth' => 480,
		'height' => 480,
		'resizable' => false,
	),
));
echo '<iframe name="frame-kontrol" width="100%" height="450"></iframe>';
?>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'dialogRSKTanpaKunjungan',
	'options' => array(
		'title' => 'Update Rencana Kontrol',
		'autoOpen' => false,
		'modal' => true,
		'minWidth' => 480,
		'height' => 480,
		'resizable' => false,
		'close' => "js:function(){ $.fn.yiiGridView.update('srk-spri-grid', {
				data: $('.search-form form, .katakunci').serialize()
			}); }",
	),
));
?>
<iframe name="iframeUpdateSRKTanpaKunjungan" width="100%" height="450"></iframe>
<?php $this->endWidget(); ?>