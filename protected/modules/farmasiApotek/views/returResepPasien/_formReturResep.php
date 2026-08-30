<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglretur', array('class' => 'control-label required')) ?>
            <div class="controls">
                <?php $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglretur',
                    'mode' => 'datetime',
                    'options' => array(
                        'maxDate' => 'd',
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'class' => 'span2 realtime'
                    ),
                )); ?>
            </div>
        </div>
        <?php echo $form->hiddenField($model, 'penjualanresep_id', array('readonly' => true, 'class' => 'span3 required', 'readonly' => false, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textAreaRow($model, 'alasanretur', array('placeholder' => 'Alasan retur', 'class' => 'span3 required', 'readonly' => false, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model, 'noreturresep', array('class' => 'span3', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'keteranganretur', array('placeholder' => 'Keterangan retur', 'class' => 'span3', 'readonly' => false, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->dropDownListRow($model, 'pegretur_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('ruangan_id' => Yii::app()->user->getState('ruangan_id')), array('order' => 'nama_pegawai')), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'class' => 'span3 required', 'readonly' => false, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->dropDownListRow($model, 'mengetahui_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('ruangan_id' => Yii::app()->user->getState('ruangan_id')), array('order' => 'nama_pegawai')), 'pegawai_id', 'nama_pegawai'), array('empty' => '-- Pilih --', 'class' => 'span3', 'readonly' => false, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    </div>
</div>