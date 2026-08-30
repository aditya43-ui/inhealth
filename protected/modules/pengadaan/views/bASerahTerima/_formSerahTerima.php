<div class="row-fluid">
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label('Nomor Transaksi', 'baserahterima_nomor', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'baserahterima_nomor', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nomor BA <span class="required">*</span>', 'nomor_beritaacara', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nomor_beritaacara', array('readonly' => false, 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="control-group ">
            <?php echo CHtml::label("Tanggal Pembuatan BA <span class='required'>*</span>", 'baserahterima_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'baserahterima_tanggal',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 required dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
                <?php echo $form->error($model, 'baserahterima_tanggal'); ?>
            </div>
        </div>
         <div class="control-group">
            <?php echo CHtml::label('Termin <span class="required">*</span>', 'nomor_beritaacara', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'termin_terminjumlah', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <label> dari</label>
                <?php echo $form->textField($model, 'termin_termintotal', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->hiddenField($model, 'terminke', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->hiddenField($model, 'termin_persen', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'dokumen_pendukung', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->fileField($model, 'dokumen_pendukung', array('class' => 'span3 ', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?> 
                <?php
                if (!empty($model->dokumen_pendukung)) {
                    echo CHtml::link("$model->dokumen_pendukung", $this->createUrl('Unduh', array('id' => $model->baserahterima_id)), array('title' => 'Unduh dokumen pendukung', 'rel' => 'tooltip', 'style' => 'color:blue;'));
                }
                ?> 
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row-fluid">
    <div class="col-md-6">
        <p><h4><b>PIHAK KESATU</b></h4></p>
            <div class="control-group ">
            <?php echo CHtml::label('Nama Pegawai', 'nomor_beritaacara', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegpihakkesatu_id'); ?>
                <?php echo $form->textField($model, 'pegpihakkesatu_nama', array('class' => 'span4 required', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('NIP', 'nomor_beritaacara', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pegpihakkesatu_nip', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'NIP Pihak Kesatu')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Alamat', 'nomor_beritaacara', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'pegpihakkesatu_alamat', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Alamat Pihak Kesatu')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label("Jabatan <span class='required'>*</span>", 'nomor_beritaacara', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'jabatan_pihakkesatu', array('class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => false, 'placeholder' => 'jabatan Pihak Kesatu')); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <p><h4><b>PIHAK KEDUA</b></h4></p>
        <div class="control-group ">
            <?php echo CHtml::label('Penyedia', 'supplier_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'supplier_id', array('class' => 'supplier_id'));

                $supplier_nama = "";
                if (!empty($model->supplier_id)) {
                    $sup = SupplierM::model()->findByPk($model->supplier_id);
                    $supplier_nama = $sup->supplier_nama;
                }
                echo $form->textField($model, 'supplier_nama', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Nama Supplier'));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Direktur', 'supplier_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'direktur', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Direktur Penyedia')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Alamat', 'supplier_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'alamat_penyedia', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Alamat Penyedia', 'rows' => 4)); ?>
            </div>
        </div>
    </div>
</div>