<div class="col-sm-6">
    <?php echo $form->hiddenField($modKematian, 'pendaftaran_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->hiddenField($modKematian, 'pasien_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->hiddenField($modKematian, 'profilrs_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($modKematian, 'judulsurat', array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
    <?php echo $form->dropDownListRow($modKematian, 'jenissurat_id',  CHtml::listData($modKematian->getJenisSurat(), 'jenissurat_id', 'jenissurat_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($modKematian, 'tglsurat', array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <div class="control-group">
        <label for="penyebabkematian" class="control-label">Penyebab Kematian <span class="required">*</span></label>
        <div class="controls">
            <?php $form->textArea($modKematian, 'penyebabkematian', array('placeholder' => 'Penyebab Kematian', 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <?php echo $form->textFieldRow($modKematian, 'nourutsurat', array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php echo $form->textFieldRow($modKematian, 'nomorsurat', array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
    <?php echo $form->dropDownListRow($modKematian, 'mengetahui_surat',  CHtml::listData($modKematian->getMengetahuiItems(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK), 'nama_pegawai', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3 pilihanSearch', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
</div>