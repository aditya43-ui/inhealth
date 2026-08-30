<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Spesimen ID', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modSpesimen, 'no_spesimen', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modSpesimen, 'no_rekam_medik', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modSpesimen, 'no_rekam_medik', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modSpesimen, 'nama_pasien', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modSpesimen, 'nama_pasien', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modSpesimen, 'ruangan_asal', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modSpesimen, 'ruangan_asal', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Pengambilan Spesimen', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modSpesimen, 'waktu_pengambilan_spesimen', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modSpesimen, 'jenis_spesimen', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modSpesimen, 'jenis_spesimen', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modSpesimen, 'jenis_pemeriksaan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modSpesimen, 'jenis_pemeriksaan', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Pengambilan Spesimen', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modSpesimen, 'status', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
    </div>
</div>
