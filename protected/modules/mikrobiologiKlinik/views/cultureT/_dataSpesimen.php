<div class="row-fluid">
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label('Spesimen ID', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSpesimen, 'no_spesimen', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('No Rekam Medik', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPenilaian->pasienkirimkeunitlain->pasien, 'no_rekam_medik', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Pasien', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPenilaian->pasienkirimkeunitlain->pasien, 'nama_pasien', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan Asal', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPenilaian->pasienkirimkeunitlain->pasien, 'no_rekam_medik', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Pengambilan Spesimen', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                    $modSpesimen->waktu_pengambilan_spesimen = MyFormatter::formatDateTimeForUser($modSpesimen->waktu_pengambilan_spesimen);
                    echo $form->textField($modSpesimen, 'waktu_pengambilan_spesimen', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jenis Spesimen', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSpesimen->samplelab, 'samplelab_nama', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jenis Pemeriksaan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSpesimen->tindakanpelayanan->daftartindakan, 'daftartindakan_nama', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Status', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSpesimen, 'status', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
    </div>
</div>