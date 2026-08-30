<div class="col-md-6">
    <?php echo $form->textFieldRow($model, 'nomor_dokumen', array('readonly' => false, 'class' => 'span4 required', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>

    <div class = "control-group">
        <?php echo CHtml::label("Tanggal Surat <i style='color: red'> * </i>", 'pembukaanpenawaran_tanggal', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'pembukaanpenawaran_tanggal',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'span4 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            ));
            ?>
        </div>
    </div>
    <div class = "control-group">
        <?php echo CHtml::label('Nama Penyedia', 'supplier_nama', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->textField($model, 'supplier_nama', array('class' => 'span4', 'readonly' => true,)); ?>
        </div>
    </div>
    <div class = "control-group">
        <?php echo CHtml::label('Alamat Penyedia', 'supplier_alamat', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->textArea($model, 'supplier_alamat', array('class' => 'span4', 'readonly' => true,)); ?>
        </div>
    </div>
    <div class = "control-group">
        <?php echo CHtml::label('Personalia dan Organisasi Rapat', 'personalia_rapat', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->textArea($model, 'personalia_rapat', array('class' => 'span4', 'readonly' => false,)); ?>
        </div>
    </div>
</div>
<div class="col-md-6">
    <?php 
        $cekInformasi = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
        if(!empty($cekInformasi->pegpengadaan_id)) {
    ?>
    <div class = "control-group">
        <?php echo CHtml::label('Pejabat Pengadaan', 'pejabatpengadaan_nama', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->hiddenField($model, 'pejabatpengadaan_id', array('class' => 'span4', 'readonly' => true,)); ?>
            <?php echo $form->textField($model, 'pejabatpengadaan_nama', array('class' => 'span4', 'readonly' => true,)); ?>
        </div>
    </div>
    <div class = "control-group">
        <?php echo CHtml::label('NIP', 'pejabatpengadaan_nip', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->textField($model, 'pejabatpengadaan_nip', array('class' => 'span4', 'readonly' => true,)); ?>
        </div>
    </div>
    <div class = "control-group">
        <?php echo CHtml::label('Jabatan', 'pejabatpengadaan_jabatan', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->textField($model, 'pejabatpengadaan_jabatan', array('class' => 'span4', 'readonly' => true,)); ?>
        </div>
    </div>
    <div class = "control-group">
        <?php echo CHtml::label('Nomor SK', 'sk_nomor', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->textField($model, 'sk_nomor', array('class' => 'span4', 'readonly' => true,)); ?>
        </div>
    </div>
    <div class = "control-group">
        <?php echo CHtml::label("Tanggal SK <i style='color: red'> * </i>", 'sk_tanggal', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'sk_tanggal',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'span4 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                ),
            ));
            ?>
        </div>
    </div>
        <?php }?>
    <div class = "control-group">
        <?php echo CHtml::label('Dokumen Pendukung', 'dokumen_pendukung', array('class' => 'control-label')) ?>
        <div class = "controls">
            <?php echo $form->fileField($model, 'dokumen_pendukung', array('class' => 'span4',)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("", '', array('class' => 'control-label ')); ?>
        <div class="controls">
            <p style="color: red">Hanya file dengan ekstensi PDF, Max 5Mb.</p> 
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("", '', array('class' => 'control-label ')); ?>
        <div class="controls">
            <?php
            if (!empty($model->dokumen_pendukung)) {
                echo CHtml::link("$model->dokumen_pendukung", $this->createUrl('Unduh', array('id' => $model->pembukaanpenawaran_id)), array('title' => 'Unduh Dokumen Pendukung', 'rel' => 'tooltip')) . '</td>';
            } else {
                echo "Belum ada dokumen pendukung";
            }
            ?>            
        </div>
    </div>
</div>

<script>
    document.getElementById("ADPembukaanpenawaranT_dokumen_pendukung").onchange = function () {
        if (this.files[0].size > 5000000) {
            toastr.warning("ukuran maks : 5Mb", "Perhatian!");
            $("#ADPembukaanpenawaranT_dokumen_pendukung").attr("src", "blank");
            $('#ADPembukaanpenawaranT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#ADPembukaanpenawaranT_dokumen_pendukung').unwrap();
            return false;
        }
        if (this.files[0].type.indexOf("pdf") == -1) {
            toastr.warning("Tipe file harus PDF", "Perhatian!");
            $("#ADPembukaanpenawaranT_dokumen_pendukung").attr("src", "blank");
            $('#ADPembukaanpenawaranT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#ADPembukaanpenawaranT_dokumen_pendukung').unwrap();
            return false;
        }
    };
</script>