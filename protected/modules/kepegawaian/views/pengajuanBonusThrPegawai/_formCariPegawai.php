<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Pegawai ', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('nama_pegawai', '', array('placeholder' => 'Nama Pegawai', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('NIP ', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('nip', '', array('placeholder' => 'NIP', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Instalasi ', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::dropDownList('instalasi_id', '', CHtml::listData(KPInstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan ', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::dropDownList('ruangan_id', '', CHtml::listData(KPRuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Unit Kerja ', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::dropDownList('unitkerja_id', '', KPPegawaiM::model()->getDropUnitKerjaItems(), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Kategori Pegawai ', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::dropDownList('kategoripegawai', '', LookupM::getItems('kategoripegawai'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Kelompok Pegawai', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::dropDownList('kelompokpegawai_id', '', KPPegawaiM::model()->getDropKelompokPegItems(), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jabatan ', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::dropDownList('jabatan_id', '', CHtml::listData(KPPegawaiM::model()->getJabatanItems(), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'addDetail();')
    );
    ?>
</div>