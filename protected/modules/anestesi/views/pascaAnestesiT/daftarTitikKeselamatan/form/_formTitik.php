<div class="col-sm-4"  style="padding:0px !important">
    <?php
        echo CHtml::activeHiddenField($model, 'pendaftaran_id',array('readonly' => true));
        echo CHtml::activeHiddenField($model, 'pasienmasukpenunjang_id',array('readonly' => true));
        echo CHtml::activeHiddenField($model, 'pasien_id',array('readonly' => true));
        echo CHtml::activeHiddenField($model, 'pasienanastesi_id',array('readonly' => true));
    ?>
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::activeCheckBox($model, 'is_identifikasipasien'); ?>
        </div>
        <div class="controls">
            <label>Identifikasi Pasien</label>
        </div>
    </div>
    
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::activeCheckBox($model, 'is_ijinoperasi'); ?>
        </div>
        <div class="controls">
            <label>Ijin Operasi</label>
        </div>
    </div>
    
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::activeCheckBox($model, 'is_puasadngbaik'); ?>
        </div>
        <div class="controls">
            <label>Puasa Dijalankan dengan baik</label>
        </div>
    </div>
    
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::activeCheckBox($model, 'is_mesinanestesi'); ?>
        </div>
        <div class="controls">
            <label>Mesin Anestesi</label>
        </div>
    </div>
    
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::activeCheckBox($model, 'is_suction'); ?>
        </div>
        <div class="controls">
            <label>Suction</label>
        </div>
    </div>
    
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::activeCheckBox($model, 'is_obatan'); ?>
        </div>
        <div class="controls">
            <label>Obat Obatan</label>
        </div>
    </div>
    
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::activeCheckBox($model, 'is_antibiotikprofilaksis'); ?>
        </div>
        <div class="controls">
            <label>Antibiotik profilaksis</label>
        </div>
    </div>
    
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::activeCheckBox($model, 'is_pulseoxymeter'); ?>
        </div>
        <div class="controls">
            <label>Pulse Oxymeter</label>
        </div>
    </div>
</div>

<div class="col-sm-4" style="padding:0px !important">
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::activeCheckBox($model, 'is_ekg'); ?>
        </div>
        <div class="controls">
            <label>EKG</label>
        </div>
    </div>
    
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::activeCheckBox($model, 'is_sabukpengaman'); ?>
        </div>
        <div class="controls">
            <label>Sabuk Pengaman</label>
        </div>
    </div>
    
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::activeCheckBox($model, 'is_stetoskopprecordial'); ?>
        </div>
        <div class="controls">
            <label>Stetoskop Precordial</label>
        </div>
    </div>
    
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::activeCheckBox($model, 'is_nibp'); ?>
        </div>
        <div class="controls">
            <label>NIBP</label>
        </div>
    </div>
    
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::activeCheckBox($model, 'is_termometer'); ?>
        </div>
        <div class="controls">
            <label>Termometer</label>
        </div>
    </div>
    
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::activeCheckBox($model, 'is_selimutpenghangat'); ?>
        </div>
        <div class="controls">
            <label>Selimut penghangat</label>
        </div>
    </div>
    
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::activeCheckBox($model, 'is_urinkateter'); ?>
        </div>
        <div class="controls">
            <label>Urin Kateter</label>
        </div>
    </div>
    
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::activeCheckBox($model, 'is_penghangatcairan'); ?>
        </div>
        <div class="controls">
            <label>Penghangat Cairan</label>
        </div>
    </div>
</div>

<div class="col-sm-4"  style="padding:0px !important">
    <div class="control-group">
        <div class="controls">
            <label>Pasca Induksi</label>
        </div>        
    </div>
    
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::activeCheckBox($model, 'pascainduksi_titiktekanan'); ?>
        </div>
        <div class="controls">
            <label>Titik titik tekanan diperiksa dan diberi bantalan</label>
        </div>
    </div>
    
    <div class="control-group">
        <div class="controls">
            <?php echo CHtml::activeCheckBox($model, 'pascainduksi_mataterlindunga'); ?>
        </div>
        <div class="controls">
            <label>Mata terlindungi</label>
        </div>
    </div>
</div>