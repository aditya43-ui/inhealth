<div class = "col-sm-5">
    <?php echo CHtml::activeHiddenField($modPendonor, 'pendonor_id', array('readonly' => true)); ?>
    <?php echo CHtml::activeHiddenField($modDaftarDonasi, 'daftardonasi_id', array('readonly' => true)); ?>
    <?php echo $form->hiddenField($model, 'is_gagalseleksiawal', array('readony' => true)) ?>
    <?php echo $form->hiddenField($model, 'gagal_seleksi_wanita', array('readony' => true)) ?>
    <div class="control-group">
        <?php echo CHtml::label("No. Formulir", 'no_formulir', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modDaftarDonasi, 'no_formulir', array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("No. Registrasi", 'no_pendonor', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modPendonor, 'no_pendonor', array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama Pendonor", 'nama_lengkap', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modPendonor, 'nama_lengkap', array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Tanggal Lahir", 'tgllahir', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modPendonor, 'tgllahir', array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Umur", 'umur', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tgllahir', (!empty($modPendonor->tgllahir)) ? CustomFunction::hitungUmur($modPendonor->tgllahir) : "-", array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Kelamin", 'jenis_kelamin', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modPendonor, 'jenis_kelamin', array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>
</div>
<div class = "col-sm-5">
    <div class="control-group">
        <?php echo CHtml::label("Agama", 'agama', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modPendonor, 'agama', array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Golongan Darah", 'gol_darah', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modPendonor, 'gol_darah', array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Rhesus", 'rhesus', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modPendonor, 'rhesus', array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Status", 'statusperkawinan', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modPendonor, 'statusperkawinan', array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Riwayat Donor Terakhir", 'waktu_observasi', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modPendonor, 'waktu_observasi', array('readonly' => true, 'class' => 'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Berat Badan", 'beratbadan_kg', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modPendonor, 'beratbadan_kg', array('readonly' => true, 'class' => 'span3')); ?> <label> Kg </label>
        </div>
    </div>
</div>
<div class = "col-sm-2">
    <?php $url_photopasien = (!empty($modPendonor->photopendonor) ? Params::urlPendonorDirectory() . $modPendonor->photopendonor : Params::urlPendonorDirectory() . "no_photo.jpeg"); ?>
    <img id="photo-preview" src="<?php echo $url_photopasien ?>"width="184px"/>     
</div>