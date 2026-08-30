
<div class="panel_jenispembayaran panel_jenispembayaran_debit">
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'bank', array('class' => 'control-label', 'label' => 'Bank Pengirim <span class="required">*</span>')); ?>
        <div class="controls">
            <?php echo CHtml::activeDropDownList($modJenis, '[detail][' . $i . ']bank', LookupM::getItems('bank'), array('empty' => '-- Pilih', 'class' => 'span3 bank')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'pemilikkartu', array('class' => 'control-label', 'label' => 'Nama Pemilik Kartu <span class="required">*</span>')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail][' . $i . ']pemilikkartu', array('class' => 'span3 pemilikkartu')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'nokartu', array('class' => 'control-label', 'label' => 'No Kartu / Rekening Pengirim <span class="required">*</span>')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail][' . $i . ']nokartu', array('class' => 'span3 nokartu')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'nostruk', array('class' => 'control-label', 'label'=>'No. Bukti Transfer / Transaksi <span class="required">*</span>')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail][' . $i . ']nostruk', array('class' => 'span3 nostruk')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'tgltransaksi', array('class'=>'control-label', 'label'=>'Waktu Transaksi <span class="required">*</span>')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model'=>$modJenis,
                'attribute'=>'[detail]['.$i.']tgltransaksi',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('readonly' => true,
                    'onkeyup' => "return $(this).focusNextInputField(event)", 'class'=>'tgltransaksi'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'tgljatuhtempo', array('class'=>'control-label', 'label'=>'Tanggal Jatuh Tempo <span class="required">*</span>')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model'=>$modJenis,
                'attribute'=>'[detail]['.$i.']tgljatuhtempo',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    // 'maxDate' => 'd',
                ),
                'htmlOptions' => array('readonly' => true,
                    'onkeyup' => "return $(this).focusNextInputField(event)", 'class'=>'tgljatuhtempo'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'bankpenerima_id', array('class' => 'control-label', 'label'=>'Bank Penerima <span class="required">*</span>')); ?>
        <div class="controls">
            <?php
            $bank_data = BankM::model()->findAll('bank_aktif = true and ispenerimaan = true order by namabank');

            $list_bank = CHtml::listData($bank_data, 'bank_id', 'bankNoRekening');
            $option_bank = array();

            foreach ($bank_data as $item) {
              $jnsPembayar = JnspembrekM::model()->findByAttributes(array(
                  'bank_id' => $item->bank_id,
                  'saldonormal' => 'D',
              ));
                // $rekening = BankrekM::model()->findByAttributes(array(
                //     'bank_id' => $item->bank_id,
                //     'saldonormal' => 'D',
                // ));

                $option_bank[$item->bank_id] = array(
                    'data-rekening' => '',
                );

                if (!empty($jnsPembayar)) {
                    $rek5 = Rekening5M::model()->findByPk($jnsPembayar->rekening5_id);
                    if (!empty($rek5)) {
                        $option_bank[$item->bank_id]['data-rekening'] = $rek5->kdrekening5 . " - " . $rek5->nmrekening5;
                    }
                }
            }


            echo CHtml::activeDropDownList($modJenis, '[detail][' . $i . ']bankpenerima_id', $list_bank, array('class' => 'span3 bankpenerima_id', 'options' => $option_bank,'empty'=>'- Pilih -' ,'onchange' => 'setKodeAkunBankMulti(this);'));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Kode Akun", '', array('class' => 'control-label', 'required' => true, 'label' => 'Nominal')); ?>
        <div class="controls">
            <?php
            echo CHtml::textField('kode_akun_bank', '', array(
                'class' => 'span3 kode_akun_bank', 'readonly' => true,
            ));
            ?>
        </div>
    </div>
    <?php /*
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'no_mobile_pengirim', array('class' => 'control-label', 'label' => 'No. Mobile <span class="required">*</span>')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail][' . $i . ']no_mobile_pengirim', array('class' => 'span3 no_mobile_pengirim')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'email_pengirim', array('class' => 'control-label', 'label' => 'Email <span class="required">*</span>')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail][' . $i . ']email_pengirim', array('class' => 'span3 email_pengirim')); ?>
        </div>
    </div>
     *
     */ ?>
</div>
