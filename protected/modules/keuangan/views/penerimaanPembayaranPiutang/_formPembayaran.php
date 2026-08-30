<div class="row" style="margin-top: 17px;">
    <div class='col-md-6'>
        <div class="control-group">
            <?php echo CHtml::label('Nomor Pembayaran Piutang <span class="required">*</span>', 'nopembayaran', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nopembayaran', array(
                    'class' => 'span3',
                    'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                    'readonly' => true
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modBuktiBayar, 'nobuktibayar', array('class' => 'control-label', 'label' => 'No Kas Masuk')) ?>
            <div class="controls">
                <?php echo $form->textField($modBuktiBayar, 'nobuktibayar', array(
                    'class' => 'span3',
                    'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                    'readonly' => true
                )); ?>
            </div>
        </div>

        <div class="control-group">
            <?php $model->tglpembayaran = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tglpembayaran, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
            <?php echo $form->labelEx($model, 'tglpembayaran', array('class' => 'control-label inline')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model'             => $model,
                    'attribute'         => 'tglpembayaran',
                    'mode'             => 'datetime',
                    'options'         => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate'     => 'd',
                    ),
                    'htmlOptions'     => array(
                        'readonly' => true, 'class' => 'dtPicker2-5 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php $modBuktiBayar->tglbuktibayar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiBayar->tglbuktibayar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
            <?php echo $form->labelEx($modBuktiBayar, 'tglbuktibayar', array('class' => 'control-label inline', 'label' => 'Tgl. Kas Masuk')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model'             => $modBuktiBayar,
                    'attribute'         => 'tglbuktibayar',
                    'mode'             => 'datetime',
                    'options'         => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate'     => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly'     => true, 'class'         => 'dtPicker2-5 span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>

            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Cara Pembayaran <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($modBuktiBayar, 'carapembayaran', LookupM::getItems('carapembayaranklaim'), array(
                    'onchange' => 'formCarabayar(this.value)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
                    'maxlength' => 50
                )); ?>
            </div>
        </div>
        <div id="divCaraBayarTransfer">
            <div class="control-group">
                <?php echo CHtml::activeLabel($modBuktiBayar, 'bank_nama', array('class' => 'control-label', 'required' => true, 'label' => 'Nama Bank Pengirim')); ?>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($modBuktiBayar, 'bank_nama', LookupM::getItems('bank'), array('required' => true, 'class' => 'span3', 'empty' => '-- Pilih Bank --', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                    ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label("No. Rekening Pengirim", '', array('class' => 'control-label', 'required' => true)); ?>
                <div class="controls">
                    <?php echo $form->textField($modBuktiBayar, 'nokartu', array(
                        'class' => 'span3',
                        'placeholder' => 'No. Rekening Pengirim',
                        'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100
                    )); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("No. Struk Bukti Transfer", '', array('class' => 'control-label', 'required' => true)); ?>
                <div class="controls">
                    <?php echo $form->textField($modBuktiBayar, 'nostrukkartu', array(
                        'class' => 'span3',
                        'placeholder' => 'No. Struk Bukti Transfer',
                        'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100
                    )); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::activeLabel($modBuktiBayar, 'bank_id', array('class' => 'control-label', 'required' => true, 'label' => 'Nama Bank Penerima')); ?>
                <div class="controls">
                    <?php
                    $bank_data = BankM::model()->findAll('bank_aktif = true and ispenerimaan = true order by namabank');

                    $list_bank = CHtml::listData($bank_data, 'bank_id', 'bankNoRekening');
                    $option_bank = array();

                    foreach ($bank_data as $item) {
                        $rekening = BankrekM::model()->findByAttributes(array(
                            'bank_id' => $item->bank_id,
                            'saldonormal' => 'D',
                        ));

                        $option_bank[$item->bank_id] = array(
                            'data-rekening' => '',
                        );

                        if (!empty($rekening)) {
                            $rek5 = Rekening5M::model()->findByPk($rekening->rekening5_id);
                            $option_bank[$item->bank_id]['data-rekening'] = $rek5->kdrekening5 . " - " . $rek5->nmrekening5;
                            $option_bank[$item->bank_id]['data-norek'] = $item->norekening;
                        }
                    }

                    echo $form->dropDownList(
                        $modBuktiBayar,
                        'bank_id',
                        $list_bank,
                        array(
                            'required' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);",
                            'onchange' => 'setKodeAkunBank()', 'empty' => '-- Pilih Bank --',
                            'options' => $option_bank
                        )
                    ); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label('No. Rekening Penerima', '', array('class' => 'control-label', 'required' => true,)) ?>
                <div class="controls">
                    <?php echo $form->textField($modBuktiBayar, 'norekpenerima', array(
                        'class' => 'span3',
                        'placeholder' => 'No. Rekening Penerima',
                        'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true
                    )); ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Pengirim <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->textField($modBuktiBayar, 'namapengirim', array(
                    'class' => 'span3',
                    'placeholder' => 'Nama Pengirim',
                    'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Alamat Pengirim <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->textArea($modBuktiBayar, 'alamatpengirim', array(
                    'class' => 'span3',
                    'placeholder' => 'Alamat Pengirim',
                    'rows' => 3,
                    'onkeypress' => "return $(this).focusNextInputField(event);"
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Sebagai Pembayaran <span class="required">*</span>', '', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php echo $form->textField($modBuktiBayar, 'sebagaipembayaran_bkm', array(
                    'class' => 'span3',
                    'placeholder' => 'Sebagai Pembayaran',
                    'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100
                )); ?>
            </div>
        </div>
    </div>
    <div class='col-md-6'>
        <?php echo $form->textFieldRow($model, 'totalpiutang', array(
            'readonly' => true,
            'class' => 'integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);"
        )); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'totalbayar', array('class' => 'control-label', 'label' => 'Total Yang Dibayarkan')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'totalbayar', array(
                    'readonly' => false,
                    'class' => 'integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onblur' => 'hitungPlorate(this);'
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modBuktiBayar, 'biayaadministrasi', array('class' => 'control-label', 'label' => 'Total Biaya Administrasi Bank')); ?>
            <div class="controls">
                <?php echo $form->textField($modBuktiBayar, 'biayaadministrasi', array(
                    'onblur' => 'hitungKasKeluar();',
                    'class' => 'integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true
                )); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($modBuktiBayar, 'biayamaterai', array('class' => 'control-label', 'label' => 'Total Biaya Materai')); ?>
            <div class="controls">
                <?php echo $form->textField($modBuktiBayar, 'biayamaterai', array(
                    'onblur' => 'hitungKasKeluar();',
                    'class' => 'integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true
                )); ?>
            </div>
        </div>


        <div class="control-group">
            <?php echo $form->labelEx($model, 'totalbayar', array('class' => 'control-label', 'label' => 'Total Penerimaan')); ?>
            <div class="controls">
                <?php echo $form->textField($modBuktiBayar, 'uangditerima', array(
                    'readonly' => true,
                    'class' => 'integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);"
                )); ?>
            </div>
        </div>

        <?php echo $form->textFieldRow($model, 'totalsisapiutang', array(
            'readonly' => true,
            'class' => 'integer-decimal span3', 'onkeypress' => "return $(this).focusNextInputField(event);"
        )); ?>
    </div>
</div>