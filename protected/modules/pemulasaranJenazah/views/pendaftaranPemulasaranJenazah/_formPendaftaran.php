<?php
$realtime = !isset($_GET['sukses']) ? 'realtime' : '';
?>
<?php echo $form->hiddenField($model, 'pendaftaran_id', array('readonly' => true, 'class' => 'span3')); ?>
<?php
if (Yii::app()->user->getState('tgltransaksimundur')) {
	?>
	<div class="control-group">
		<?php echo CHtml::Label('Tgl. Pendaftaran <span class="required">*</span> <i class="entypo-arrows-ccw"></i>', 'tgl_pendaftaran', array('rel' => 'tooltip', 'title' => 'Klik untuk set Realtime', 'class' => 'control-label', 'onclick' => '$("#ROPendaftaranT_tgl_pendaftaran").addClass("realtime");', 'style' => ' cursor: pointer;')) ?>
		<div class="controls">
			<?php
			$model->tgl_pendaftaran = (!empty($model->tgl_pendaftaran) ? date("d/m/Y H:i:s", strtotime($model->tgl_pendaftaran)) : date("d/m/Y H:i:s"));
			$this->widget('MyDateTimePicker', array(
				'model' => $model,
				'attribute' => 'tgl_pendaftaran',
				'mode' => 'datetime',
				'options' => array(
					'showOn' => false,
					'maxDate' => 'd',
				),
				'htmlOptions' => array('class' => 'dtPicker3 span2 ' . $realtime, 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => '$(this).removeClass("realtime")'),
			));
			?>
		</div>
        </div>
		<?php
	} else {
		echo $form->textFieldRow($model, 'tgl_pendaftaran', array('readonly' => true, 'class' => 'span3 realtime', 'onkeyup' => "return $(this).focusNextInputField(event);"));
	}
	?>

    <!--RSSP-1116-->
    <?php echo $form->dropDownListRow($modPasienMasukPenunjang,'jeniskasuspenyakit_id', CHtml::listData($model->getJenisKasusPenyakitItems($modPasienMasukPenunjang->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); ?>
    <?php echo $form->dropDownListRow($modPasienMasukPenunjang,'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems($modPasienMasukPenunjang->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>"setKarcis();", 'class'=>'span3')); ?>
    <div class="control-group">
        <?php echo $form->labelEx($modPasienMasukPenunjang,'pegawai_id',array('class'=>'control-label')); ?>
        <div class="controls"> 
            
            <?php echo $form->dropDownList($modPasienMasukPenunjang,'pegawai_id', CHtml::listData($model->getDokterItems($modPasienMasukPenunjang->ruangan_id), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>
                <div class="checkbox inline">
			<i class="icon-home" style="margin:0" rel="tooltip" title="Ceklis jika Kunjungan Rumah"></i>
			<?php echo $form->checkBox($model, 'kunjunganrumah', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
			<?php // echo CHtml::activeLabel($model, 'kunjunganrumah'); ?> 
		</div>
        </div>
    </div>

<div class="control-group">
	<?php echo $form->labelEx($model, 'carabayar_id', array('class' => 'control-label refreshable')) ?>
	<div class="controls">
		<?php
		echo $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
			'ajax' => array('type' => 'POST',
				'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
//                                                        'update'=>'#'.CHtml::activeId($model, 'penjamin_id'),  //DIHIDE KARENA DIGANTIKAN DENGAN 'success'
				'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data);setKarcis(0);setKarcis(1);}',
			),
			'onchange' => 'setFormAsuransi(this.value);',
			'class' => 'span3',
		));
		?>
	</div>
</div>    
		<?php
		echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onchange' => 'setKarcis(0);setKarcis(1);',
	      'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3'));
?>

<?php
$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
	'id' => 'form-asuransi',
	'content' => array(
		'content-asuransi' => array(
			'header' => '<b>Asuransi</b>',
			'isi' => $this->renderPartial($this->path_view . '_formAsuransi', array(
				'form' => $form,
				'modPasien' => $modPasien,
				'model' => $model,
				'modAsuransiPasien' => $modAsuransiPasien,
					), true),
			'active' => false,
		),
	),
));
?>
