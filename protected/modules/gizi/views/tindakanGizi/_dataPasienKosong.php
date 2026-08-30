<?php
$this->widget('bootstrap.widgets.BootAlert');

if(!empty($modPendaftaran->tgl_pendaftaran)) {
    $modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTImeForUser($modPendaftaran->tgl_pendaftaran);
}

if(!empty($modPasien->tgl_lahir)) {
    $modPasien->tanggal_lahir = MyFormatter::formatDateTImeForUser($modPasien->tanggal_lahir);
    $modPasien->nama_pasien = $modPasien->namadepan . $modPasien->nama_pasien;
}


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
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                    <?php echo CHtml::activeHiddenField($modPendaftaran, 'pendaftaran_id', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly' => true)); ?>
                </td>

                <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly' => true, 'class'=>'idrm')); ?>
                </td>
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
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly' => true)); ?>
                </td>

                <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?>
                </td>
                <td>
                <?php if(isset($modPendaftaran->penjamin)):?>
                    <?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?>
                <?php else:?>
                    <?php echo CHtml::textField('jeniskasuspenyakit', '', array('readonly' => true)); ?>
                <?php endif;?>
                    <?php echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('readonly' => true)); ?>
                    <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly' => true)); ?>
                </td>

                <?php if(isset($modPendaftaran->carabayar)):?>
                <td><?php echo CHtml::activeLabel($modPendaftaran->carabayar, 'cara bayar', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::activeTextField($modPendaftaran->carabayar, 'carabayar_nama', array('readonly' => true)); ?>
                </td>
                <?php else:?>
                <td><?php echo CHtml::label('Jenis Penjamin', 'cara bayar', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::textField('carabayar', '', array('readonly' => true)); ?>
                </td>
                <?php endif;?>
            </tr>
            <tr>
            <?php if(isset($modPendaftaran->penjamin)):?>
                <td><?php echo CHtml::activeLabel($modPendaftaran->dokter, 'dokter_pemeriksa', array('class' => 'control-label')); ?>
                </td>
                <?php else:?>
                    <td><?php echo CHtml::label('Dokter Pemeriksa', 'dokter_pemeriksa', array('class' => 'control-label')); ?>
                </td>
                <?php endif;?>

                <td><?php echo CHtml::activeTextField($modPendaftaran, 'dokter_pemeriksa', array('readonly' => true)); ?>
                </td>

                <?php if(isset($modPendaftaran->penjamin)):?>
                    <td><?php echo CHtml::activeLabel($modPendaftaran->penjamin, 'penjamin', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::activeTextField($modPendaftaran->penjamin, 'penjamin_nama', array('readonly' => true)); ?>
                </td>
                <?php else:?>
                <td><?php echo CHtml::label('Penjamin', 'penjamin', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::textField('penjamin', '', array('readonly' => true)); ?>
                </td>
                <?php endif;?>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPasien, 'tanggal_lahir', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::activeTextField($modPasien, 'tanggal_lahir', array('readonly' => true)); ?></td>
            </tr>

        </table>
    </div>
</div>