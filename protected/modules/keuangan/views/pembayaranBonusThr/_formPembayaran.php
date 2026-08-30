<div class="row" style="margin-top: 17px;">
    <div class='col-md-6'>
        <div class="control-group">
            <?php echo CHtml::label('No Pembayaran <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'jenisgaji'); ?>
                <?php echo $form->textField($model, 'nopembayaran', array('class' => 'span3',
                    'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                    'readonly' => true)); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modBuktiKeluar, 'nokaskeluar', array('class' => 'span3',
			'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
			'readonly' => true)); ?>
        <div class="control-group">
            <?php $model->tglpembayaran = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tglpembayaran, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
            <?php echo $form->labelEx($model, 'tglpembayaran', array('class' => 'control-label inline')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                        'model'			 => $model,
                        'attribute'		 => 'tglpembayaran',
                        'mode'			 => 'datetime',
                        'options'		 => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate'	 => 'd',
                        ),
                        'htmlOptions'	 => array('readonly'=> true, 'class'=> 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
            <?php echo $form->labelEx($modBuktiKeluar, 'tglkaskeluar', array('class' => 'control-label inline')) ?>
            <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                            'model'			 => $modBuktiKeluar,
                            'attribute'		 => 'tglkaskeluar',
                            'mode'			 => 'datetime',
                            'options'		 => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate'	 => 'd',
                            ),
                            'htmlOptions'=> array('readonly'	 => true, 'class'		 => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                    ));
                    ?>

            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Cara Pembayaran <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
            <div class="controls">
                 <?php echo $form->dropDownList($modBuktiKeluar, 'carabayarkeluar', LookupM::getItems('carabayarkeluar'), array(
            'onchange' => 'formCarabayar(this.value)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
            'maxlength' => 50)); ?>
            </div>
        </div>
        <div id="divCaraBayarTransfer">
            <div class="control-group">
                <?php echo CHtml::activeLabel($modBuktiKeluar, 'bank_id', array('class' => 'control-label', 'required' => true, 'label'=>'Bank Pengirim')); ?>
                    <div class="controls">
                    <?php
                        $bank_data = BankM::model()->findAll('bank_aktif = true order by namabank');

                        $list_bank = CHtml::listData($bank_data, 'bank_id', 'bankNoRekening');
                        $option_bank = array();

                        foreach ($bank_data as $item) {
                            $rekening = BankrekM::model()->findByAttributes(array(
                                'bank_id'=>$item->bank_id,
                                'saldonormal'=>'D',
                            ));

                            $option_bank[$item->bank_id] = array(
                                'data-rekening'=>'',
                            );

                            if (!empty($rekening)) {
                                $rek5 = Rekening5M::model()->findByPk($rekening->rekening5_id);
                                $option_bank[$item->bank_id]['data-rekening'] = $rek5->kdrekening5." - ".$rek5->nmrekening5;
                                $option_bank[$item->bank_id]['data-norek'] = $item->norekening;
                            }

                        }

                        echo $form->dropDownList($modBuktiKeluar, 'bank_id', $list_bank,
                            array('required' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);",
                                'onchange'=>'setKodeAkunBank()','empty' => '-- Pilih Bank --',
                                'options'=>$option_bank)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Kode Akun", '', array('class' => 'control-label', 'required' => true, 'label'=>'Nominal')); ?>
                        <div class="controls">
                        <?php echo CHtml::textField('kode_akun_bank', '', array(
                            'id'=>'kode_akun_bank', 'class'=>'span3', 'readonly'=>true,
                        )); ?>
                        </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("No. Rekening", '', array('class' => 'control-label', 'required' => true)); ?>
                        <div class="controls">
                         <?php echo $form->textField($modBuktiKeluar, 'denganrekening', array('placeholder' => 'No. Rekening', 'class' => 'span3',
                            'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        </div>
                </div>
            <div class="control-group">
                <?php echo CHtml::label("No. Bukti Transfer", '', array('class' => 'control-label', 'required' => true)); ?>
                    <div class="controls">
                     <?php echo $form->textField($modBuktiKeluar, 'nobukti_transfer', array('placeholder' => 'No. Bukti Transfer', 'class' => 'span3',
                'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::activeLabel($modBuktiKeluar, 'melalubank', array('class' => 'control-label', 'required' => true, 'label'=>'Bank Penerima')); ?>
                <div class="controls">
                <?php
                echo $form->dropDownList($modBuktiKeluar, 'melalubank', LookupM::getItems('bank'), array('required' => true, 'class' => 'span3', 'empty' => '-- Pilih Bank --', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('No. Rekening Penerima', '', array('class' => 'control-label', 'required' => true,)) ?>
                <div class="controls">
                    <?php echo $form->textField($modBuktiKeluar, 'norekpenerima', array('placeholder' => 'No Rekening Penerima', 'class' => 'span3',
                        'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Penerima <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->textField($modBuktiKeluar, 'namapenerima', array('placeholder' => 'Nama Penerima', 'class' => 'span3',
                'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Alamat Penerima <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
            <div class="controls">
               <?php echo $form->textArea($modBuktiKeluar, 'alamatpenerima', array('placeholder' => 'Alamat Penerima', 'rows' => 3,  'class' => 'span3',
                'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Untuk Pembayaran <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->textField($modBuktiKeluar, 'untukpembayaran', array('class' => 'span3',
                'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </div>
        </div>
    </div>
    <div class='col-md-6'>
        <?php echo $form->textFieldRow($model, 'totalhutang', array('readonly' => true,
					'class' => 'integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'totaldibayarkan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'totaldibayarkan', array('readonly' => false,
    			'class' => 'integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onblur' => 'hitungPlorate(this);')); ?>
            </div>
        </div>

            <?php echo $form->textFieldRow($modBuktiKeluar, 'biayaadministrasi', array('onblur' => 'hitungKasKeluar();',
	'class' => 'integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($modBuktiKeluar, 'jmlkaskeluar', array('readonly' => true,
		'class' => 'integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'totalsisahutang', array('readonly' => true,
		'class' => 'integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
