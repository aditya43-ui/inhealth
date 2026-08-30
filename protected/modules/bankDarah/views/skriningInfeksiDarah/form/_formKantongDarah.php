<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Nomor Barcode Sample', '', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php //echo CHtml::textField('barcode_kantong', $kantong->nomorbarcode_sample_imltd, array('readonly'=>true)); ?>
            <?php echo CHtml::textField('barcode_kantong', $kantong->nomorbarcode_sample, array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Jenis Kantong Darah', '', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('barcode', $kantong->jeniskantongdarah->nama_jenis, array('readonly'=>true)); ?>
            
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Penerimaan Kantong', '', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('tgl_terima', !empty($kantong->terimakantongdarah_id)?MyFormatter::formatDateTimeForUser($kantong->terimakantongdarah->tglterimakantong):'', array('readonly'=>true)); ?>
            
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Golongan Darah', '', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php             
            
            echo CHtml::textField('golongan_darah', $kantong->gol_darah, array('readonly'=>true)); ?>
            
        </div>
    </div>
    <div class="control-group">
        <?php 
        $ruangan = RuanganM::model()->findByPk($kantong->create_ruangan);
        echo CHtml::label('Rhesus', '', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('rhesus', $kantong->rhesus, array('readonly'=>true)); ?>
            
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Ruangan Asal', '', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('ruangan_asal', $ruangan->ruangan_nama, array('readonly'=>true)); ?>
            
        </div>
    </div>
    
</div>

