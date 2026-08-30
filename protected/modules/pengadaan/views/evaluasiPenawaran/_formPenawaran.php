<div class="row-fluid">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'konfigtemplatesurat_id', CHtml::listData(KonfigtemplatesuratK::model()->findAllByAttributes(array('jenissurat_id' => 44)), 'konfigtemplatesurat_id', 'konfigtemplatesurat_nama'), array('class' => 'span3 jenisform', 'onkeyup' => "return $(this).focusNextInputField(event)", 'return false;')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'evaluasipenawaran_nomor', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="clear"></div>
    <hr>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'nomor_dokumen', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nomor_dokumen', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor Surat')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'evaluasipenawaran_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'evaluasipenawaran_tanggal',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
                <?php echo $form->error($model, 'evaluasipenawaran_tanggal'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'supplier_id', array('class' => 'control-label', 'label' => 'Nama Penyedia <span class="required">*</span>')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'supplier_nama', array('readonly' => true, 'class' => 'span3', 'onblur' => 'return false;')); ?>
                <?php echo $form->hiddenField($model, 'supplier_id', array('readonly' => true, 'class' => 'span1', 'onblur' => 'return false;')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'alamat_supplier', array('class' => 'control-label', 'label' => 'Alamat Penyedia <span class="required">*</span>')) ?>
            <div class="controls">
                <?php
                echo $form->textArea($model, 'alamat_supplier', array(
                    'readonly' => true,
                    'class' => 'span3',
                    'style' => 'height:65px !important',
                    'onblur' => 'return false;',
                ));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'personalia_rapat', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'personalia_rapat', array('class' => 'span3', 'onblur' => 'return false;')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'keterangan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'keterangan', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php 
            $cekInformasi = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $modPersiapanPengadaan->persiapanpengadaan_id));
            if(!empty($cekInformasi->pegpengadaan_id)) {
        ?>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'pejabat_pengadaan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pejabat_pengadaan', array('readonly' => true, 'class' => 'span3', 'onblur' => 'return false;')); ?>
                <?php echo $form->hiddenField($model, 'pejabatpengadaan_id', array('readonly' => true, 'class' => 'span1', 'onblur' => 'return false;')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'pejabat_pengadaan_nip', array('class' => 'control-label', 'label' => 'NIP')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pejabat_pengadaan_nip', array('readonly' => true, 'class' => 'span3', 'onblur' => 'return false;')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'jabatan_pengadaan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'jabatan_pengadaan', array('readonly' => true, 'class' => 'span3', 'onblur' => 'return false;')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'sk_nomor', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'sk_nomor', array('readonly' => true, 'class' => 'span3', 'onblur' => 'return false;')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'sk_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'sk_tanggal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
                <?php echo $form->error($model, 'sk_tanggal'); ?>
            </div>
        </div>
        <?php } ?>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'harga_penawaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'harga_penawaran', array('readonly' => true, 'class' => 'span3 integer-decimal', 'onblur' => 'return false;')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'harga_terkoreksi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'harga_terkoreksi', array('class' => 'span3 integer-decimal', 'onblur' => 'return false;')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'dokumen_pendukung', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->fileField($model, 'dokumen_pendukung', array('class' => 'span3 ', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?> 
                <?php
                if (!empty($model->dokumen_pendukung)) {
                    echo CHtml::link("$model->dokumen_pendukung", $this->createUrl('Unduh', array('id' => $model->evaluasipenawaran_id)), array('title' => 'Unduh dokumen pendukung', 'rel' => 'tooltip', 'style' => 'color:blue;'));
                }
                ?> 
            </div>
        </div>
    </div>
</div>