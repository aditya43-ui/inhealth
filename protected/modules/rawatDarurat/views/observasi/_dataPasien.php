<?php 
$modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTImeForUser($modPendaftaran->tgl_pendaftaran);
$modPasien->nama_pasien = $modPasien->namadepan.$modPasien->nama_pasien;
$modPasien->tanggal_lahir = MyFormatter::formatDateTImeForUser($modPasien->tanggal_lahir);
?>
<?php
if(!empty($modPasien)){
?>

    <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title">Data Pasien</div>
        </div>
        <div class="panel-body">
            <table width="100%" class="table-condensed">
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran',array('class'=>'control-label')); ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'pendaftaran_id',array('class'=>'control-label')); ?>
                    </td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly'=>true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly'=>true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran',array('class'=>'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly'=>true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien',array('class'=>'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly'=>true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?></td>
                    <td>
                        <?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly'=>true)); ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('readonly'=>true)); ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly'=>true)); ?>
                    </td>

                    <td><?php echo CHtml::activeLabel($modPasien, 'tanggal_lahir',array('class'=>'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'tanggal_lahir', array('readonly'=>true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran->carabayar, 'cara bayar',array('class'=>'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran->carabayar, 'carabayar_nama', array('readonly'=>true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly'=>true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPendaftaran->penjamin, 'penjamin', array('class'=>'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPendaftaran->penjamin, 'penjamin_nama', array('readonly'=>true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly'=>true)); ?></td>
                </tr>
            </table>
        </div>
    </div>
<?php
} else {
    Yii::app()->user->setFlash('error',"Tidak ada pasien");
    $this->widget('bootstrap.widgets.BootAlert');
}
?>