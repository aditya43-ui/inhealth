<div class="search-form">
	<?php
	$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
		'action' => Yii::app()->createUrl($this->route),
		'method' => 'get',
		'id' => 'pencarianbarang-form',
		'type' => 'horizontal',
		'focus' => '#' . CHtml::activeId($modMakanan, 'barang_kode'),
	));
	?>
	<div class="row-fluid">
		<div class="col-sm-6">
            <div class="control-group">
				<?php echo CHtml::label('Jenis Opname', 'jenis_opname', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php
					if (empty($model->formuliropname_id)) {
						echo $form->dropDownList($modMakanan, 'jenis_opname', LookupM::getItems('jenisinventarisasi'), array('class' => 'span3', 'onchange' => 'setJenisOpname();', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'empty'=>'-- Pilih --'));
					} else {
						echo $form->textField($modMakanan, 'jenis_opname', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));
					}
					?>
				</div>
			</div>
			  <?php echo $form->textFieldRow($modMakanan, 'namabahanmakanan', array('placeholder' => 'Ketik Nama Bahan Makanan', 'class' => 'span3', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
			<!-- <div class="control-group">
				<?php //echo CHtml::label('Jenis Bahan Makanan', 'jenisbahanmakanan', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php
					// if (empty($model->formuliropname_id)) {
					// 	echo $form->dropDownList($modMakanan, 'jenisbahanmakanan',  LookupM::getItemsUrutan("jenisbahanmakanan"), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'empty'=>'-- Pilih --'));
					// } else {
					// 	echo $form->textField($modMakanan, 'jenisbahanmakanan', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));
					// }
					?>
				</div>
			</div> -->
			<!-- <div class="control-group">
				<?php //echo CHtml::label('Golongan Bahan Makanan', 'golbahanmakanan_id', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php
					// if (empty($model->formuliropname_id)) {
					// 	echo $form->dropDownList($modMakanan, 'golbahanmakanan_id', CHtml::listData(GolbahanmakananM::model()->findAll('golbahanmakanan_aktif = true order by golbahanmakanan_nama asc'), 'golbahanmakanan_id', 'golbahanmakanan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'empty'=>'-- Pilih --'));
					// } else {
					// 	echo $form->textField($modMakanan, 'golbahanmakanan_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));
					// }
					?>
				</div>
			</div> -->
		</div>
        <div class="col-sm-6">
            <div class="control-group">
				<?php echo CHtml::label('Kelompok Bahan Makanan', 'kelbahanmakanan', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php
						echo $form->dropDownList($modMakanan, 'kelbahanmakanan', LookupM::getItemsUrutan("kelompokbahanmakanan"), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'empty'=>'-- Pilih --'));
					?>
				</div>
			</div>

			<?php echo $form->dropDownListRow($modMakanan, 'satuanbahan', LookupM::getItemsUrutan("satuanbahanmakanan"), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
		</div>
	</div>
	<div class="form-actions">

		<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>

		<?php //echo CHtml::htmlButton(Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>

	</div>
	<?php $this->endWidget(); ?>
</div>
