<div class = "col-sm-6">
    <?php echo CHtml::activeHiddenField($model, 'kirimkantongdarah_id', array('readonly'=>true,'class'=>'required')); ?>
    <?php echo CHtml::activeHiddenField($model, 'coolboxdarah_id', array('readonly'=>true,'class'=>'required')); ?>
    <div class="control-group">
        <?php echo CHtml::label("Nomor Pengiriman <span class='required'>*</span>", 'no_kirimkantong', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modKirimKantongDarah, 'no_kirimkantong', array('readonly'=>true,'class'=>'span3 required')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Ruang Asal / Pengirim", 'ruangankirim_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modKirimKantongDarah, 'ruangankirim_nama', array('readonly'=>true,'class'=>'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Waktu Pengiriman", 'tglkirimkantongdarah', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modKirimKantongDarah, 'tglkirimkantongdarah', array('readonly'=>true,'class'=>'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Suhu", 'suhu_kirim', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modKirimKantongDarah, 'suhu_kirim', array('readonly'=>true,'class'=>'span3 desimal')); ?> &#8451;
        </div>
    </div>
</div>
<div class = "col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("Petugas Pengirim", 'petugaskirim_nama', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php 
            $modKirimKantongDarah->petugaskirim_nama = $modKirimKantongDarah->petugaskirim_gelardepan.' '.$modKirimKantongDarah->petugaskirim_nama;
            ?>
            <?php echo CHtml::activeTextField($modKirimKantongDarah, 'petugaskirim_nama', array('readonly'=>true,'class'=>'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Cool Box <span class='required'>*</span>", 'coolbox_jenis', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modKirimKantongDarah, 'coolbox_jenis', array('readonly'=>true,'class'=>'span3 required')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jumlah Cool Box", 'coolbox_jml', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modKirimKantongDarah, 'jml_coolbox_permintaan', array('readonly'=>true,'class'=>'span3 desimal')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jumlah Ice Pack", 'jml_icepack', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modKirimKantongDarah, 'jml_icepack_permintaan', array('readonly'=>true,'class'=>'span3 desimal')); ?>
        </div>
    </div>
</div>