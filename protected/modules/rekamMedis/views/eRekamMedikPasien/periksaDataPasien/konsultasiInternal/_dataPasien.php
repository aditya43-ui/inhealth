<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <table style="width: 100%; border: none;">
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                    <?php echo CHtml::activeHiddenField($modPendaftaran, 'pendaftaran_id', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran->kelaspelayanan, 'kelaspelayanan_nama', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran->carabayar, 'cara bayar', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran->carabayar, 'carabayar_nama', array('readonly' => true)); ?></td>

                <td rowspan="2"><?php echo CHtml::activeLabel($modPasien, 'alamat_pasien', array('class' => 'control-label')); ?></td>
                <td rowspan="2"><?php echo CHtml::activeTextArea($modPasien, 'alamat_pasien', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran->penjamin, 'penjamin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran->penjamin, 'penjamin_nama', array('readonly' => true)); ?></td>
            </tr>

        </table>
    </div>
</div>