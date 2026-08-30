<div class="col-sm-4">
    <div class="control-group">
        <?php echo CHtml::label("Ikhtisar Singkat", '', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textArea('alamat_pasien',$modKunjungan->alamat_pasien,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",
																							'placeholder'=>'Ikhtisar klinik singkat')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Diagnosis Kelainan", '', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textArea('alamat_pasien',$modKunjungan->alamat_pasien,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
	<div class="control-group">
        <?php echo CHtml::label('Diagnosa Sementara', '', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('nama_bin',$modKunjungan->nama_bin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
	<div class="control-group">
        <?php echo CHtml::label('Pengobatan Sementara', '', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('nama_bin',$modKunjungan->nama_bin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
</div>
<div class="col-sm-4">
	<div class="control-group">
        <?php echo CHtml::label('Diagnosa Akhir', '', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('nama_bin',$modKunjungan->nama_bin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
	<div class="control-group">
        <?php echo CHtml::label('Pengobatan Akhir', '', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('nama_bin',$modKunjungan->nama_bin,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
	<div class="control-group">
        <?php echo CHtml::label("Saran", '', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textArea('alamat_pasien',$modKunjungan->alamat_pasien,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",
																							'placeholder'=>'Saran Dokter')); ?>
        </div>
    </div>
</div>