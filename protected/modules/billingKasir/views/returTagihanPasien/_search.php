<?php //$format = new MyFormatter(); 
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <div class="control-group">
                <?php echo CHtml::label("Tgl. Retur Pelayanan", 'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label("No. Retur", 'noreturbayar', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'noreturbayar', array('placeholder' => 'No. Retur', 'class' => 'span3 angkahuruf-only', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($model, 'nobuktibayar', array('placeholder' => 'No. Bukti Bayar', 'class' => 'span3 angkahuruf-only', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span3 angkahuruf-only', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'autofocus' => true, 'class' => 'span3 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span3 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
        <div class="control-group">
            <?php
            $carabayar = CarabayarM::model()->findAll(array(
                'condition' => 'carabayar_aktif = true',
                'order' => 'carabayar_nourut',
            ));
            $penjamin = PenjaminpasienM::model()->findAll(array(
                'condition' => 'penjamin_aktif = true',
                'order' => 'penjamin_nama',
            ));
            /*
				$pegawai = DokterV::model()->findAllByAttributes(array(
					'instalasi_id'=>Params::INSTALASI_ID_RJ,
					'pegawai_aktif'=>true,
				), array(
					'order'=>'nama_pegawai',
				)); */
            foreach ($carabayar as $idx => $item) {
                $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                    'carabayar_id' => $item->carabayar_id,
                    'penjamin_aktif' => true,
                ));
                if (empty($penjamins)) unset($carabayar[$idx]);
            }
            echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                'empty' => '-- Pilih --',
                'class' => 'span3',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                    'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
                ),
            ));
            echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50));
            // echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData($model->getRuanganItems(Params::INSTALASI_ID_RJ), 'ruangan_id', 'ruangan_nama'),array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)"));
            // echo $form->dropDownListRow($model,'nama_pegawai', CHtml::listData($pegawai, 'nama_pegawai', 'namaLengkap'), array('empty'=>'-- Pilih --', 'class'=>'span3'));
            /*
				$sp = LookupM::getItems('statusperiksa');
				unset($sp['BATAL PERIKSA']);
				echo $form->dropDownListRow($model,'statusperiksa', $sp, array('empty'=>'-- Pilih --', 'class'=>'span3'));
				echo $form->dropDownListRow($model,'statusBayar', LookupM::getItems('statusbayar'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>20));
				*/
            ?>
        </div>
    </div>
</div>
<?php /*
<div class="control-group">
	<?php echo CHtml::label('Alias', 'nama_bin', array('class'=>'control-label')); ?>
	<div class="controls">
		<?php echo $form->textField($model,'nama_bin',array('placeholder'=>'Nama Panggilan','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
	</div>
</div>
 * 
 */ ?>