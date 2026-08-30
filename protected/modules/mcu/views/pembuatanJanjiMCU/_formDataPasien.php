<div class="row">
    <div class="col-sm-6">
        <!--<div class="control-group">
					<?php echo $form->labelEx($modPasien, 'no_identitas_pasien', array('class' => 'control-label')) ?>
					<div class="controls">
						<?php echo $form->dropDownList(
                            $modPasien,
                            'jenisidentitas',
                            LookupM::getItems('jenisidentitas'),
                            array(
                                'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span2'
                            )
                        ); ?>   
						<?php echo $form->textField($modPasien, 'no_identitas_pasien', array('placeholder' => 'No. Identitas', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>            
						<?php echo $form->error($modPasien, 'jenisidentitas'); ?><?php echo $form->error($modPasien, 'no_identitas'); ?>
					</div>
			</div>-->
        <div class="control-group">
            <?php echo $form->labelEx($modPasien, 'nama_pasien', array('class' => 'control-label')) ?>
            <div class="controls inline">

                <?php echo $form->dropDownList(
                    $modPasien,
                    'namadepan',
                    LookupM::getItems('namadepan'),
                    array(
                        'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1'
                    )
                ); ?>
                <?php echo $form->textField($modPasien, 'nama_pasien', array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 all-caps', 'placeholder' => 'Nama Pasien')); ?>

                <?php echo $form->error($modPasien, 'namadepan'); ?><?php echo $form->error($modPasien, 'nama_pasien'); ?>
            </div>
        </div>
        <?php //echo $form->textFieldRow($modPasien,'nama_bin', array('class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Alias')); 
        ?>
        <?php //echo $form->textFieldRow($modPasien,'tempat_lahir', array('class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Tempat Lahir')); 
        ?>

        <div class="control-group">
            <?php echo $form->labelEx($modPasien, 'tanggal_lahir', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $modPasien->tanggal_lahir = (!empty($modPasien->tanggal_lahir) ? date("d/m/Y", strtotime($modPasien->tanggal_lahir)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $modPasien,
                    'attribute' => 'tanggal_lahir',
                    'mode' => 'date',
                    'options' => array(
                        //                                                                  'dateFormat'=>Params::DATE_FORMAT,
                        'maxDate' => 'd',
                        'onkeyup' => "js:function(){getUmur(this);}",
                        'onSelect' => 'js:function(){getUmur(this);}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Tanggal Lahir',
                        'class' => 'dtPicker4 datemask',
                        'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
                <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($modPasien, 'umur', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('CMaskedTextField', array(
                    'model' => $modPasien,
                    'attribute' => 'umur',
                    'mask' => '99 Thn 99 Bln 99 Hr',
                    'htmlOptions' => array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onblur' => 'getTglLahir(this)', 'placeholder' => 'Umur Pasien')
                ));
                ?>
                <?php echo $form->error($modPasien, 'umur', array('placeholder' => 'Umur Pasien')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <?php //echo $form->dropDownListRow($modPasien,'statusperkawinan', LookupM::getItems('statusperkawinan'),array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); 
        ?>

        <!--<div class="control-group">
					<?php echo $form->labelEx($modPasien, 'golongandarah', array('class' => 'control-label')) ?>

					<div class="controls">

						<?php echo $form->dropDownList(
                            $modPasien,
                            'golongandarah',
                            LookupM::getItems('golongandarah'),
                            array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4')
                        ); ?>   
						<div class="radio inline">
							<div class="form-inline">
							<?php echo $form->radioButtonList($modPasien, 'rhesus', LookupM::getItems('rhesus'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>            
							</div>
					   </div>
						<?php echo $form->error($modPasien, 'golongandarah'); ?>
						<?php echo $form->error($modPasien, 'rhesus'); ?>
					</div>
			</div>-->
        <?php echo $form->textAreaRow($modPasien, 'alamat_pasien', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Alamat Lengkap Pasien',)); ?>

        <!--<div class="control-group">
				<?php echo $form->labelEx($modPasien, 'rt', array('class' => 'control-label inline ')) ?>

				<div class="controls">
					<?php echo $form->textField($modPasien, 'rt', array('placeholder' => 'RT', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 numbersOnly', 'maxlength' => 3)); ?>   / 
					<?php echo $form->textField($modPasien, 'rw', array('placeholder' => 'RW', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 numbersOnly', 'maxlength' => 3)); ?>            
					<?php echo $form->error($modPasien, 'rt'); ?>
					<?php echo $form->error($modPasien, 'rw'); ?>
				</div>
			</div>-->
        <?php //echo $form->textFieldRow($modPasien,'no_telepon_pasien', array('onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. Telepon Pasien ','class'=>'span4 numbersOnly')); 
        ?>
        <?php echo $form->textFieldRow($modPasien, 'no_mobile_pasien', array('onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'No. Hp Pasien', 'class' => 'span4 numbersOnly')); ?>
    </div>

    <!--<div class="col-sm-6">
			<div class="control-group">
				<?php echo $form->labelEx($modPasien, 'propinsi_id', array('class' => 'control-label')) ?>
				<div class="controls">
				<?php $modPasien->propinsi_id = (!empty($modPasien->propinsi_id)) ? $modPasien->propinsi_id : Yii::app()->user->getState('propinsi_id'); ?>
				<?php echo $form->dropDownList(
                    $modPasien,
                    'propinsi_id',
                    CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'),
                    array(
                        'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('GetKabupaten', array('encode' => false, 'namaModel' => 'PPPasienM')),
                            'update' => '#PPPasienM_kabupaten_id',
                        ),
                        'onchange' => "clearKecamatan();clearKelurahan();",
                    )
                ); ?>
			   <?php echo $form->error($modPasien, 'propinsi_id'); ?>
				</div>
			</div>

			<div class="control-group">
				<?php echo $form->labelEx($modPasien, 'kabupaten_id', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php $modPasien->kabupaten_id = (!empty($modPasien->kabupaten_id)) ? $modPasien->kabupaten_id : Yii::app()->user->getState('kabupaten_id'); ?>
					<?php echo $form->dropDownList(
                        $modPasien,
                        'kabupaten_id',
                        CHtml::listData($modPasien->getKabupatenItems($modPasien->propinsi_id), 'kabupaten_id', 'kabupaten_nama'),
                        array(
                            'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('GetKecamatan', array('encode' => false, 'namaModel' => 'PPPasienM')),
                                'update' => '#PPPasienM_kecamatan_id'
                            ),
                            'onchange' => "clearKelurahan();",
                        )
                    ); ?>
					<?php echo $form->error($modPasien, 'kabupaten_id'); ?>
				</div>
			</div>

			<div class="control-group">
				<?php echo $form->labelEx($modPasien, 'kecamatan_id', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php $modPasien->kecamatan_id = (!empty($modPasien->kecamatan_id)) ? $modPasien->propinsi_id : Yii::app()->user->getState('kecamatan_id'); ?>
					<?php echo $form->dropDownList(
                        $modPasien,
                        'kecamatan_id',
                        CHtml::listData($modPasien->getKecamatanItems($modPasien->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'),
                        array(
                            'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('GetKelurahan', array('encode' => false, 'namaModel' => 'PPPasienM')),
                                'update' => '#PPPasienM_kelurahan_id'
                            )
                        )
                    ); ?>
					<?php echo $form->error($modPasien, 'kecamatan_id'); ?>
				</div>
			</div>

			 <div class="control-group">
				<?php echo $form->labelEx($modPasien, 'kelurahan_id', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id)) ? $modPasien->propinsi_id : Yii::app()->user->getState('kelurahan_id'); ?>
					<?php echo $form->dropDownList(
                        $modPasien,
                        'kelurahan_id',
                        CHtml::listData($modPasien->getKelurahanItems($modPasien->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'),
                        array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")
                    ); ?>
					<?php echo $form->error($modPasien, 'kelurahan_id'); ?>
				</div>
			</div>

			 <?php echo $form->dropDownListRow($modPasien, 'agama', LookupM::getItems('agama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
			 <?php echo $form->dropDownListRow($modPasien, 'pendidikan_id', CHtml::listData($modPasien->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
			 <?php echo $form->dropDownListRow($modPasien, 'pekerjaan_id', CHtml::listData($modPasien->getPekerjaanItems(), 'pekerjaan_id', 'pekerjaan_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
			 <?php echo $form->dropDownListRow($modPasien, 'warga_negara', LookupM::getItems('warganegara'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>

		</div>-->
</div>