<?php Yii::app()->clientScript->registerScriptFile('js/dropdownMulti.js', CClientScript::POS_END); ?>
<?php

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'type' => 'horizontal',
	'id' => 'searchLaporan',
	'focus' => '#BKLaporanpenerimaankasirV_shift_id',
	'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<style>
	td label.checkbox {
		width: 150px;
		display: inline-block;

	}

	.checkbox.inline+.checkbox.inline {
		margin-left: 0;
	}
</style>
<div class="row">
	<div class="col-sm-6">
		<?php echo CHtml::hiddenField('type', ''); ?>
		<div class="control-group">
			<?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
			<?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
			<?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
			<?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
			<?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
			<?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
			<div class="controls">
				<div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
					<i class="entypo-calendar"></i>
					<span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
					<?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
					<?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::label("Shift", '', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($model, 'shift_id', CHtml::listData(ShiftM::model()->findAll("shift_aktif = TRUE ORDER BY shift_nama"), 'shift_id', 'shift_nama'), array(
					'class' => 'form-control', 'multiple' => 'multiple'
				)) ?>
			</div>
		</div>
		<?php /*$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
			'id'=>'kunjungan',
			'slide'=>true,
			'content'=>array(
			'content2'=>array(
				'header'=>'Berdasarkan Shift',
				'multi' => 'multi',
				'isi'=>  '<table class="">                                            
							<tr>
									<td>'.
										   //$form->checkBoxList($model, 'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama ASC"), 'kelaspelayanan_id', 'kelaspelayanan_nama'))

											$form->dropDownList($model, 'shift_id', CHtml::listData(ShiftM::model()->findAll("shift_aktif = TRUE ORDER BY shift_nama"), 'shift_id', 'shift_nama'),array(
											'class'=>'form-control', 'multiple'=>'multiple'))																			
									.'</td>
							</tr>
							</table>',            
				'active'=>true,
					),
			),
//                                    'htmlOptions'=>array('class'=>'aw',)
			)); */
		?>
		<!--fieldset class="box2"-->
		<!--legend class="rim">Berdasarkan Shift </legend>
		<div class="controls">
			<?php //echo $form->hiddenField($model, 'pegawai_id', array('readonly'=>true)); 
			?>
			<?php //echo CHtml::label('Nama Dokter', 'nama_dokter', array('class' => 'control-label', 'style'=>'text-align:center;')) 
			?>
			<div class="controls">
				<?php //echo $form->dropDownlistRow($model,'shift_id',Chtml::listData($model->ShiftItems, 'shift_id', 'shift_nama'),array('empty'=>'Semua','class'=>'span3')); 
				?>
			</div>
		</div>
		<!--</fieldset>-->
	</div>

	<div class="col-sm-6">
		<div class="control-group">
			<?php echo CHtml::label("Kasir", 'pegawai_id', array('class' => 'control-label')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($model, 'pegawai_id', PegawairuanganV::getDropPegawai(Yii::app()->user->getState('ruangan_id')), array(
					'class' => 'form-control', 'multiple' => 'multiple'
				)); ?>
			</div>
		</div>
		<?php /*            
		<div id='searching'>
			<!--fieldset class="box2"-->
				<legend class="rim">Berdasarkan Ruangan Kasir&nbsp;<?php echo CHtml::checkBox('cek_ruangan', true, array('onchange'=>'cek_all_ruangan(this)','value'=>'cek_ruangan'));?></legend>
				<?php echo '<table id="ruangan_tbl">
					<tr>
						<td>'.
						$form->checkBoxList($model, 'ruangan_id', CHtml::listData(RuangankasirV::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array('inline'=>true, 'onkeypress' => "return $(this).focusNextInputField(event)")).'
						</td>
					</tr>
				 </table>'; ?>
			<!--</fieldset>-->
		</div>
             * 
         */ ?>
		<?php /*$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                    'id'=>'kunjungan',
                    'slide'=>true,
                    'content'=>array(
                    'content2'=>array(
                            'header'=>'Berdasarkan Kasir',
                            'multi' => 'multi',
                            'isi'=>  '<table class="">                                            
                                        <tr>
                                                        <td>'.
                                                                   //$form->checkBoxList($model, 'kelaspelayanan_id', CHtml::listData(KelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama ASC"), 'kelaspelayanan_id', 'kelaspelayanan_nama'))

                                                                        $form->dropDownList($model, 'pegawai_id',PegawairuanganV::getDropPegawai(Yii::app()->user->getState('ruangan_id')),array(
                                                                        'class'=>'form-control', 'multiple'=>'multiple'))																			
                                                        .'</td>
                                        </tr>
                                        </table>',            
                            'active'=>true,
                                    ),
                    ),
//                                    'htmlOptions'=>array('class'=>'aw',)
                    )); */
		?>
	</div>

</div>

<div class="form-actions">
	<?php
	echo CHtml::htmlButton(
		Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
		array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
	);
	?>
	<?php echo CHtml::htmlButton(
		Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
		array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
	); ?>
</div>
<?php //$this->widget('UserTips', array('type' => 'create')); 
?>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
',  CClientScript::POS_READY);
?>

<script type="text/javascript">
	function cek_all_ruangan(obj) {
		if ($(obj).is(':checked')) {
			$("#ruangan_tbl").find("input[type=\'checkbox\']").attr("checked", "checked");
		} else {
			$("#ruangan_tbl").find("input[type=\'checkbox\']").attr("checked", false);
		}
	}

	jQuery(document).ready(function() {
		dropMulti('<?php echo CHtml::activeId($model, 'pegawai_id') ?>');
	});
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>