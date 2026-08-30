<div class="row-fluid">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'konfigtemplatesurat_id', CHtml::listData(KonfigtemplatesuratK::model()->findAll("konfigtemplatesurat_nama LIKE '%Perintah Pengiriman%' AND konfigtemplatesurat_aktif = true order by konfigtemplatesurat_nama ASC"), 'konfigtemplatesurat_id', 'konfigtemplatesurat_nama'), array('empty' => '-- Pilih --', 'class' => 'span4  required jenisform', 'onkeyup' => "return $(this).focusNextInputField(event)", 'return false;')); ?>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'Termin Ke', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'terminke', array('class'=>'span1','readonly'=>true)); ?>
                <?php echo $form->hiddenField($model, 'total_pembayaran', array('class'=>'span1','readonly'=>true)); ?>
                <?php echo $form->textField($model, 'termin_angka', array('class'=>'span1','readonly'=>true)); ?>
            </div>
            <label class="control-label" style="width: 35px">Dari</label>
            <div class="controls">
                <?php echo $form->textField($model, 'termin_jumlah', array('class'=>'span1','readonly'=>true)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'perintahpengiriman_nomor', array('disabled' => true, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
    </div>
</div>
<div class="clear"> </div>
<hr> 
<div class="row-fluid">
    <div class="col-sm-6">
        <div class = "control-group">
            <?php echo CHtml::label('Nomor Surat <span class="required">*</span>', 'nomor_dokumen', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'nomor_dokumen', array('class' => 'span4 required', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo CHtml::label("Tanggal Surat <i style='color: red'> * </i>", '', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'perintahpengiriman_tanggal',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span4 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo CHtml::label('Nama Penyedia <span class="required">*</span>', 'nomor_dokumen', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textArea($model, 'nama_supplier', array('readonly' => true, 'class' => 'span4 required', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo CHtml::label('Alamat Penyedia <span class="required">*</span>', 'nomor_dokumen', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textArea($model, 'alamat_supplier', array('readonly' => true, 'class' => 'span4 required', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo CHtml::label('Nama Penyedia <span class="required">*</span>', 'nomor_dokumen', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'direktur_supplier', array('readonly' => true, 'class' => 'span4 required', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo CHtml::label('Tanggal Mulai Kerja <span class="required">*</span>', 'nomor_dokumen', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'tanggal_awal', array('readonly' => true, 'class' => 'span4 required', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo CHtml::label('Tanggal Akhir Kerja <span class="required">*</span>', 'nomor_dokumen', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'tanggal_akhir', array('readonly' => true, 'class' => 'span4 required', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo CHtml::label('Denda', '', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textArea($model, 'denda_keterangan', array('readonly' => false, 'class' => 'span4', 'maxlength' => 100)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class = "control-group">
            <?php echo CHtml::label('Nomor SPK <span class="required">*</span>', 'nomor_dokumen', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'nosuratperjanjiankerja', array('readonly' => true, 'class' => 'span4 required', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo CHtml::label('Tanggal SPK <span class="required">*</span>', 'nomor_dokumen', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'tglsuratperjanjian', array('readonly' => true, 'class' => 'span4 required', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo CHtml::label('Pejabat Pembuat Komitmen <span class="required">*</span>', 'nomor_dokumen', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'pegppk_nama', array('readonly' => true, 'class' => 'span4 required', 'maxlength' => 100)); ?>
                <?php echo $form->hiddenField($model, 'pegppk_id', array('readonly' => true, 'class' => 'span4 required', 'maxlength' => 100)); ?>
                <?php echo $form->hiddenField($model, 'suratperjanjiankerja_id', array('readonly' => true, 'class' => 'span4 required', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo CHtml::label('NIP', '', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'pegppk_nip', array('readonly' => true, 'class' => 'span4', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo CHtml::label('Alamat', '', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textArea($model, 'pegppk_alamat', array('readonly' => true, 'class' => 'span4')); ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo CHtml::label('Waktu Penyelesaian', '', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'jangka_pelaksanaan', array('readonly' => true, 'class' => 'span2 required', 'maxlength' => 100)); ?>
                <label> hari </label>
            </div>
        </div>
    </div>
</div>