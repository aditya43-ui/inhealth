<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("No. Pasien Anestesi <span class='required'>*</span>", 'noanestesi', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo CHtml::activeHiddenField($modKunjungan, 'pasienanastesi_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::activeHiddenField($modKunjungan, 'pendaftaran_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::activeHiddenField($modKunjungan, 'pasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::activeHiddenField($modKunjungan, 'pasienmasukpenunjang_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php
                    echo CHtml::activeTextField($modKunjungan, 'noanestesi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pasien Anestesi <span class='required'>*</span>", 'tglanastesi', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modKunjungan, 'tglanastesi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Umur', 'umur', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modKunjungan, 'umur', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Kasus Penyakit", 'instalasiasal_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeHiddenField($modKunjungan, 'jeniskasuspenyakit_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::activeTextField($modKunjungan, 'jeniskasuspenyakit_nama', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Dokter Pemeriksa", 'nama_pegawai', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeHiddenField($modKunjungan, 'pegawai_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::activeTextField($modKunjungan, 'nama_pegawai', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Alamat Pasien", 'alamat_pasien', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextArea($modKunjungan, 'alamat_pasien', array('readonly' => true, 'class' => 'span3', 'placeholder'=>'Ketik Alamat Pasien', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("No. Rekam Medik", 'no_rekam_medik', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                    echo CHtml::activeTextField($modKunjungan, 'no_rekam_medik', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama Pasien", 'nama_pasien', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                 echo CHtml::activeTextField($modKunjungan, 'nama_pasien', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modKunjungan, 'jeniskelamin', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Pekerjaan", 'pekerjaan_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeHiddenField($modKunjungan, 'pekerjaan_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::activeTextField($modKunjungan, 'pekerjaan_nama', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>    
        <div class="control-group">
            <?php echo CHtml::label("Kelas Pelayanan", 'kelaspelayanan_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::activeHiddenField($modKunjungan, 'kelaspelayanan_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::activeTextField($modKunjungan, 'kelaspelayanan_nama', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div align="center">
            <?php
            $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory() . "kecil_" . $modPasien->photopasien : Params::urlPhotoPasienDirectory() . "no_photo.jpeg");
            ?>
            <img id="photo-preview" src="<?php echo $url_photopasien ?>"width="128px"/> 
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('input[name="ATInformasipasienanestesiV[tgl_masuk_cari]"]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        });
    });
</script>