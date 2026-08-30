<div class="row-fluid">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'konfigtemplatesurat_id', CHtml::listData(KonfigtemplatesuratK::model()->findAllByAttributes(array('jenissurat_id' => 38)), 'konfigtemplatesurat_id', 'konfigtemplatesurat_nama'), array('class' => 'span3 jenisform', 'onkeyup' => "return $(this).focusNextInputField(event)", 'return false;')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'banegosiasi_nomor', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
    <div class="clear"></div>
    <hr>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nomor_beritaacara', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor Surat')); ?>

        <div class="control-group ">
            <?php echo $form->labelEx($model, 'banegosiasi_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'banegosiasi_tanggal',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
//                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
                <?php echo $form->error($model, 'banegosiasi_tanggal'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'supplier_id', array('class' => 'control-label', 'label' => 'Nama Penyedia')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'supplier_nama', array('readonly' => true, 'class' => 'span3', 'onblur' => 'return false;')); ?>
                <?php echo $form->hiddenField($model, 'supplier_id', array('readonly' => true, 'class' => 'span1', 'onblur' => 'return false;')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'alamat_supplier', array('class' => 'control-label', 'label' => 'Alamat Penyedia')) ?>
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
            <?php echo $form->labelEx($model, 'nama_direktur', array('class' => 'control-label', 'label' => 'Nama Direktur')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nama_direktur', array('readonly' => true, 'class' => 'span3', 'onblur' => 'return false;')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'penawaranpenyedia_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'penawaranpenyedia_nomor', array('readonly' => true, 'class' => 'span3', 'onblur' => 'return false;')); ?>
                <?php echo $form->hiddenField($model, 'penawaranpenyedia_id', array('readonly' => true, 'class' => 'span1', 'onblur' => 'return false;')); ?>
            </div>
        </div>
        <?php 
            $cekInformasi = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
            if(!empty($cekInformasi->pegpengadaan_id)) {
        ?>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'pejabat_pengadaan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pejabat_pengadaan', array('readonly' => true, 'class' => 'span3', 'onblur' => 'return false;')); ?>
                <?php echo $form->hiddenField($model, 'pegpengadaan_id', array('readonly' => true, 'class' => 'span1', 'onblur' => 'return false;')); ?>
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
            <?php echo $form->labelEx($model, 'nomor_sk', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'nomor_sk', array('readonly' => true, 'class' => 'span3', 'onblur' => 'return false;')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'tanggal_sk', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'tanggal_sk', array('readonly' => true, 'class' => 'span3', 'onblur' => 'return false;')); ?>
            </div>
        </div>
        <?php } ?>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'harga_setelah_negosiasi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'harga_setelah_negosiasi', array('readonly' => true, 'class' => 'span3 integer-decimal', 'onblur' => 'return false;')); ?>
            </div>
        </div>
        <div class="control-group ">
        <?php echo CHtml::label("Dokumen Pendukung", '', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php echo $form->fileField($model, 'dokumen_pendukung', array('accept'=>'application/pdf','class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 500)); ?>
            <?php
                if (!empty($model->dokumen_pendukung)) {
                    echo CHtml::link("$model->dokumen_pendukung", $this->createUrl('Unduh', array('id' => $model->banegosiasi_id)), array('title' => 'Unduh dokumen pendukung', 'rel' => 'tooltip', 'style' => 'color:blue;'));
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls" >
                <span class="required" style="font-size: 10px;"><i>Hanya file dengan ekstensi .pdf (maks 5mb)</i></span>
            </div>
        </div>
    </div>
</div>