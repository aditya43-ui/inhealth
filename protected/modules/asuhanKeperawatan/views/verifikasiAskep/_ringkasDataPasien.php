<?php $this->widget('bootstrap.widgets.BootAlert'); ?> 

<table class="table table-condensed">
    <tr>
        <td>
            <?php //echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?>
            <label class="control-label">No. Pendaftaran</label>
        </td>
        <td>
            <?php //echo CHtml::textField('ASInfopengkajianaskepV[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly'=>true)); ?>
            <?php
            echo CHtml::textField('ASInfopengkajianaskepV[no_pendaftaran]', $modPasien->no_pendaftaran, array('readonly' => true));
            ?>
        </td>
        <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label ')); ?></td>
        <td><?php
            echo CHtml::textField('ASInfopengkajianaskepV[nama_pasien]', $modPasien->nama_pasien, array('readonly' => true));
            ?></td>

    </tr>
    <tr>
        <td><?php echo CHtml::activeLabel($modPasien, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::textField('ASInfopengkajianaskepV[tgl_pendaftaran]', $modPasien->tgl_pendaftaran, array('readonly' => true)); ?></td>

        <td><?php echo CHtml::activeLabel($modPasien, 'umur', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::textField('ASInfopengkajianaskepV[umur]', $modPasien->umur, array('readonly' => true)); ?></td>

    </tr>
    <tr>
        <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label ')); ?></td>
        <td><?php
            echo CHtml::textField('ASInfopengkajianaskepV[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly' => true));
            ?></td>
        <td><?php echo CHtml::label('Diagnosa Medik Masuk', 'diagnosa_nama', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::textField('ASInfopengkajianaskepV[diagnosa_nama]', isset($modPasien->diagnosa_nama) ? $modPasien->diagnosa_nama : $model->getDiagnosaMedis($modPasien->pasien_id, $modPasien->pendaftaran_id), array('readonly' => true)); ?></td>
    </tr>
    <tr>
        <td><?php echo CHtml::activeLabel($modPasien, 'ruangan_id', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::textField('ASInfopengkajianaskepV[ruangan_nama]', isset($modPasien->ruangan_nama) ? $modPasien->ruangan_nama : '-', array('readonly' => true)); ?></td>
        <td><?php echo CHtml::label('Kelas', 'kelaspelayanan_nama', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::textField('ASInfopengkajianaskepV[kelaspelayanan_nama]', (isset($modPasien->kelaspelayanan_nama) ? $modPasien->kelaspelayanan_nama : $model->getKelasPelayanan($modPasien->pendaftaran_id)), array('readonly' => true)); ?></td>
    </tr>
    <tr>
    <td><?php echo CHtml::label('No Kamar / No. Bed', 'no_kamarbed', array('class' => 'control-label')); ?></td>
    <td><?php echo CHtml::textField('ASInfopengkajianaskepV[no_kamarbed]', (isset($modPasien->kamarruangan_nokamar) ? $modPasien->kamarruangan_nokamar : $model->getNoKamar($modPasien->pendaftaran_id) ) . '/' . (isset($modPasien->kamarruangan_nobed) ? $modPasien->kamarruangan_nobed : $model->getNoBed($modPasien->pendaftaran_id) ), array('readonly' => true)); ?></td>
</tr>
</table>