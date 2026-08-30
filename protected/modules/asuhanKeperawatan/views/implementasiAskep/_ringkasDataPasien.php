<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">No. Pendaftaran</label>
            <?php echo CHtml::textField('ASInforencanaaskepV[no_pendaftaran]', $modPasien->no_pendaftaran, array('readonly' => true)); ?>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPasien, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
            <?php echo CHtml::textField('ASInforencanaaskepV[tgl_pendaftaran]', $modPasien->tgl_pendaftaran, array('readonly' => true)); ?>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label ')); ?>
            <?php echo CHtml::textField('ASInforencanaaskepV[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly' => true)); ?>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPasien, 'ruangan_id', array('class' => 'control-label')); ?>
            <?php echo CHtml::textField('ASInforencanaaskepV[ruangan_nama]', isset($modPasien->ruangan_nama) ? $modPasien->ruangan_nama : '-', array('readonly' => true)); ?>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('No Kamar / No. Bed', 'no_kamarbed', array('class' => 'control-label')); ?>
            <?php echo CHtml::textField('ASInforencanaaskepV[no_kamarbed]', (isset($modPasien->kamarruangan_nokamar) ? $modPasien->kamarruangan_nokamar : $model->getNoKamar($modPasien->pendaftaran_id)) . '/' . (isset($modPasien->kamarruangan_nobed) ? $modPasien->kamarruangan_nobed : $model->getNoBed($modPasien->pendaftaran_id)), array('readonly' => true)); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label ')); ?>
            <?php echo CHtml::textField('ASInforencanaaskepV[nama_pasien]', $modPasien->nama_pasien, array('readonly' => true)); ?>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPasien, 'umur', array('class' => 'control-label')); ?>
            <?php echo CHtml::textField('ASInforencanaaskepV[umur]', $modPasien->umur, array('readonly' => true)); ?>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Diagnosa Medik Masuk', 'diagnosa_nama', array('class' => 'control-label')); ?>
            <?php echo CHtml::textField('ASInforencanaaskepV[diagnosa_nama]', (isset($modPasien->diagnosa_nama) ? $modPasien->diagnosa_nama : $model->getDiagnosaMedis($modPasien->pasien_id, $modPasien->pendaftaran_id)), array('readonly' => true)); ?>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Kelas', 'kelaspelayanan_nama', array('class' => 'control-label')); ?>
            <?php echo CHtml::textField('ASInforencanaaskepV[kelaspelayanan_nama]', isset($modPasien->kelaspelayanan_nama) ? $modPasien->kelaspelayanan_nama : '-', array('readonly' => true)); ?>
        </div>
    </div>
</div>