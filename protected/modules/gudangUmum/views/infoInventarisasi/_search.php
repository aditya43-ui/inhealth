<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'id' => 'searchInformasi',
	'type' => 'horizontal',
	'focus' => '#' . CHtml::activeId($model, 'invbarang_no'),
)); ?>
<div class="row-fluid">
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::label("Tanggal Inventarisasi", 'invbarang_tgl', array('class' => 'control-label')) ?>
			<div class="controls">
				<div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
					<i class="entypo-calendar"></i>
					<span><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
					<?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
					<?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
				</div>
			</div>
		</div>
		<?php echo $form->textFieldRow($model, 'invbarang_no', array('placeholder' => 'Ketik No. Inventarisasi', 'class' => 'angkahuruf-only')); ?>
	</div>
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::label("Petugas Mengetahui", 'invbarang_jenis', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				echo  $form->dropDownList($model, 'mengetahui_id', CHtml::listData(PegawaiM::model()->findAll('pegawai_aktif = true order by nama_pegawai ASC'), 'pegawai_id', 'namaLengkap'), array('class' => 'span3', 'empty' => '--Pilih--'));
				?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label("Petugas 1", 'petugas1_id', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				echo  $form->dropDownList($model, 'petugas1_id', CHtml::listData(PegawairuanganV::model()->findAll('ruangan_id = ' . Yii::app()->user->getState('ruangan_id') . ' order by nama_pegawai ASC'), 'pegawai_id', 'namaLengkap'), array('class' => 'span3', 'empty' => '--Pilih--'));
				?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label("Petugas 2", 'petugas2_id', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php
				echo  $form->dropDownList($model, 'petugas2_id', CHtml::listData(PegawairuanganV::model()->findAll('ruangan_id = ' . Yii::app()->user->getState('ruangan_id') . ' order by nama_pegawai ASC'), 'pegawai_id', 'namaLengkap'), array('class' => 'span3', 'empty' => '--Pilih--'));
				?>
			</div>
		</div>
	</div>
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit')); ?>
	<?php echo CHtml::link(
		Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
		$this->createUrl($this->id . '/index'),
		array(
			'class' => 'btn btn-default',
			'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
		)
	); ?>
	<?php
	echo CHtml::htmlButton(
		Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')),
		array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')
	) . "&nbsp;";
	echo CHtml::htmlButton(
		Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="' . MyIcon::getIcons('pdf') . '"></i>')),
		array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')')
	) . "&nbsp;";
	echo CHtml::htmlButton(
		Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="' . MyIcon::getIcons('excel') . '"></i>')),
		array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')
	) . "&nbsp;";
	echo CHtml::htmlButton(
		Yii::t('mds', '{icon} Export CSV', array('{icon}' => '<i class="entypo-newspaper"></i>')),
		array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'CSV\')')
	);
	?>
	<?php
	$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
	$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
	$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
	$urlEksportCsv =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/eksportCSV');
	$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#searchInformasi :input').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
function exportTemplateCsv()
{
    window.open("${urlEksportCsv}","",'location=_new, width=900px');
}
JSCRIPT;
	Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
	?>
	<?php
	$tips = array(
		'0' => 'tanggal',
		'1' => 'detail2',
		'2' => 'cari',
		'3' => 'ulang2'
	);
	$content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
	$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
	?>
</div>
<?php $this->endWidget(); ?>