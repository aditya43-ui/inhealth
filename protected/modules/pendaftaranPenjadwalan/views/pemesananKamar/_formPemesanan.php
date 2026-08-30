<div class="minradius-kiri">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-basket"></i> Data <b>Pemesanan</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <?php echo $form->hiddenField($model, 'pasienadmisi_id', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                    <?php echo $form->hiddenField($model, 'pasien_id', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                    <?php echo $form->hiddenField($model, 'pendaftaran_id', array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                    <?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData(KamarruanganM::model()->getRuanganItems(Params::INSTALASI_ID_RI), 'ruangan_id', 'ruangan_nama'), array(
                        'class' => 'span3', 'empty' => '-- Pilih --',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('GetKamarRuangan', array('encode' => false, 'namaModel' => 'PPBookingKamarT')),
                            'update' => '#PPBookingKamarT_kamarruangan_id',
                        ),
                    ));
                    ?>

                    <?php echo $form->dropDownListRow($model, 'kamarruangan_id', array(), array(
                        'class' => 'span3', 'empty' => '-- Pilih --',
                        'onkeyup' => "return $(this).focusNextInputField(event)", 'onChange' => 'getStatus(this)',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('GetKelasPelayanan', array('encode' => false, 'namaModel' => 'PPBookingKamarT')),
                            'update' => '#PPBookingKamarT_kelaspelayanan_id',
                        )
                    ));
                    ?>

                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls">
                            <div class="divForForm"></div>
                        </div>
                    </div>

                    <?php echo $form->dropDownListRow($model, 'kelaspelayanan_id', array(), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>

                    <?php echo $form->textFieldRow($model, 'bookingkamar_no', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true)); ?>
                </div>
                <div class="col-sm-6">
                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'tglbookingkamar', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglbookingkamar',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'minDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker4', 'onkeyup' => "return $(this).focusNextInputField(event)"),
                            )); ?>
                            <?php echo $form->error($model, 'tglbookingkamar'); ?>
                        </div>
                    </div>
                    <div class='control-group'>
                        <?php echo $form->labelEx($model, 'tglakhirkonfirmasi', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglakhirkonfirmasi',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'minDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker4', 'onkeyup' => "return $(this).focusNextInputField(event)"),
                            )); ?>
                            <?php echo $form->error($model, 'tglakhirkonfirmasi'); ?>
                        </div>
                    </div>
                    <?php echo $form->dropDownListRow($model, 'statusbooking', LookupM::getItems1('statusbooking'), array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); //'empty' => '-- Pilih --', ?>
                    <?php echo $form->textAreaRow($model, 'keteranganbooking', array('rows' => 3, 'cols' => 50, 'class' => 'span3 autogrow', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keterangan Pemesanan')); ?>
                </div>
            </div>
        </div>
    </div>
</div>