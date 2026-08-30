<div class = "col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("Spesimen ID", 'no_spesimen', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::textField('no_spesimen',$modSpesiman->no_spesimen ,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("No. Rekam Medik", 'no_rekam_medik', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::textField('no_spesimen',$modSpesiman->tindakanpelayanan->pendaftaran->pasien->no_rekam_medik ,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nama Pasien", 'nama_pasien', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::textField('nama_pasien',$modSpesiman->tindakanpelayanan->pendaftaran->pasien->nama_pasien ,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Ruangan", 'ruanngan_nama', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::textField('ruanngan_nama',$modSpesiman->tindakanpelayanan->pendaftaran->ruangan->ruangan_nama ,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class = "col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("Tgl. Pengambilan Spesimen", 'waktu_pengambilan_spesimen', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::textField('waktu_pengambilan_spesimen', MyFormatter::formatDateTimeForUser($modSpesiman->waktu_pengambilan_spesimen) ,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Spesimen", 'kelompoksamplelab_nama', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::textField('kelompoksamplelab_nama',$modSpesiman->samplelab->samplelab_nama ,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Pemeriksaan", 'samplelab_nama', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::textArea('samplelab_nama',$modSpesiman->tindakanpelayanan->daftartindakan->daftartindakan_nama,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Status", 'status', array('class'=>'control-label required')); ?>
        <div class="controls">
            <?php echo CHtml::textField('status',$modSpesiman->status ,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>