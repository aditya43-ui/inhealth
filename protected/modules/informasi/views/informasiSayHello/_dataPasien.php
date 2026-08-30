<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if (!empty($modPasien)) {
?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-user"></i> Data <b>Pasien</b>
            </div>
        </div>
        <div class="panel-body">
            <table style="width: 100%; border: none;">
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly' => true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly' => true)); ?></td>
                    <td rowspan="4">
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

                    <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly' => true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modPasien, 'nama_bin', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?></td>
                    <td>
                        <?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?>
                    </td>

                    <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modAdmisi->pegawai, 'dokter_pemeriksa', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modAdmisi->pegawai, 'nama_pegawai', array('readonly' => true,)); ?></td>

                    <td><?php echo CHtml::Label('No. Kamar / No. Bed', (isset($modAdmisi->kamarruangan_id) ? $modAdmisi->kamarruangan->kamarruangan_nokamar : ""), array('class' => 'control-label')); ?></td>
                    <td class="span3">
                        <?php if (isset($modAdmisi->kamarruangan_id)) { ?>
                            <?php echo CHtml::activeTextField($modAdmisi->kamarruangan, 'kamarruangan_nokamar', array('readonly' => true, 'style' => 'width:40%')); ?> /
                            <?php echo CHtml::activeTextField($modAdmisi->kamarruangan, 'kamarruangan_nobed', array('readonly' => true, 'style' => 'width:40%')); ?>
                        <?php } else { ?>
                            <?php echo CHtml::TextField('kamarruangan_nokamar', '', array('readonly' => true, 'style' => 'width:40%')); ?> /
                            <?php echo CHtml::TextField('kamarruangan_nobed', '', array('readonly' => true, 'style' => 'width:40%')); ?>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>

                    <td><?php echo CHtml::activeLabel($modAdmisi->kelaspelayanan, 'kelaspelayanan_nama', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modAdmisi->kelaspelayanan, 'kelaspelayanan_nama', array('readonly' => true)); ?></td>
                </tr>

            </table>
        </div>
    </div>

<?php
} else {
    Yii::app()->user->setFlash('error', "Tidak ada pasien");
    $this->widget('bootstrap.widgets.BootAlert');
}

?>