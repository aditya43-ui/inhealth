<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly' => true)); ?></td>

        <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly' => true)); ?></td>
        <td rowspan="5">
            <?php
            if (!empty($modPasien->photopasien)) {
                echo CHtml::image(Params::urlPhotoPasienDirectory() . $modPasien->photopasien, 'Foto pasien', array('width' => 120));
            } else {
                echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('width' => 120));
            }
            ?>
        </td>
    </tr>
    <tr>
        <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly' => true)); ?></td>

        <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?></td>
    </tr>
    <tr>
        <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly' => true)); ?></td>

        <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true, 'class' => 'nama_penerima')); ?></td>
    </tr>
    <tr>
        <td><?php echo CHtml::label('Tanggal Lahir', 'tanggal_lahir', array('class' => 'control-label')); ?></td>
        <td><?php echo CHtml::textField('tanggal_lahir', MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir), array('readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);")); ?></td>

        <td><?php echo CHtml::activeLabel($modPenjualan, 'pegawai_id', array('class' => 'control-label')); ?></td>
        <?php $dokter = PegawaiM::model()->findByAttributes(array('pegawai_id' => $modPenjualan->pegawai_id)); ?>
        <td><?php echo CHtml::activeTextField($modPenjualan, 'pegawai_id', array('value' => !empty($dokter->namaLengkap) ? $dokter->namaLengkap : "-", 'readonly' => true,)); ?></td>
    </tr>
</table>
<?php echo CHtml::hiddenField('PasienM[no_mobile_pasien]', $modPasien->no_mobile_pasien, array('readonly' => true)); ?>