<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <div class="controls inline">
                <?php echo $form->hiddenField($model, 'pasien_id'); ?>
                <?php echo $form->checkBox($model, 'byphone', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <label for="MCBuatJanjiMCU_byphone"><i class="icon-phone"></i> <?php echo $model->getAttributeLabel('byphone'); ?></label>
                <?php echo $form->error($model, 'byphone'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPasien, 'Ruangan <span class="required">*</span> ', array('class' => 'control-label')) ?>
            <div class="controls inline">
                <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData(
                    $model->getRuanganItemsMcu(),
                    'ruangan_id',
                    'ruangan_nama'
                ), array(
                    'class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => "listDokterRuangan(this.value);",
                    'ajax' => array(),
                    'onkeypress' => "return $(this).focusNextInputField(event)"
                )); ?>
                <span id="msg_ruangan" style="color:red"></span>
            </div>
        </div>
        <?php echo $form->dropDownListRow($model, 'pegawai_id', array(), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tgljadwal', array('class' => 'control-label')) ?>
            <div class="controls inline">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgljadwal',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'minDate' => 'd',
                        'onkeypress' => "js:function(){hariBaru(this);}",
                        'onSelect' => 'js:function(){hariBaru(this);}',
                        'sideBySide' => true,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true, 'class' => 'dtPicker3 span3',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'hariBaru(this)'
                    ),
                )); ?>
            </div>
            <span id="msg_tgljadwal" style="color:red; margin-left: 160px;"></span>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'harijadwal', array('class' => 'control-label')) ?>
            <div class="controls inline">
                <?php echo $form->textField($model, 'harijadwal', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => TRUE)); ?>
            </div>
            <span id="msg_harijadwal" style="color:red"></span>
        </div>
        <?php echo $form->textAreaRow($model, 'keteranganbuatjanji', array('placeholder' => 'Keterangan', 'rows' => 6, 'cols' => 60, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>