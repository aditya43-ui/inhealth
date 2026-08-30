<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <table style="width: 100%; border: none;">
        <tr>
            <td><?php echo CHtml::activeLabel($modPasienMcu, 'tgl_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMcu, 'tgl_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasienMcu, 'no_rekam_medik',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMcu, 'no_rekam_medik', array('readonly'=>true)); ?></td>
            <td rowspan="5">
                <?php 
                    if(!empty($modPasienMcu->photopasien)){
                        echo CHtml::image(Params::urlPhotoPasienDirectory().$modPasienMcu->photopasien, 'Foto pasien', array('width'=>120));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'Foto pasien', array('width'=>120));
                    }
                ?> 
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPasienMcu, 'no_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMcu, 'no_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasienMcu, 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMcu, 'jeniskelamin', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPasienMcu, 'umur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMcu, 'umur', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasienMcu, 'nama_pasien',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMcu, 'nama_pasien', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPasienMcu, 'jeniskasuspenyakit_nama',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMcu, 'jeniskasuspenyakit_nama', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasienMcu, 'nama_bin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMcu, 'nama_bin', array('readonly'=>true)); ?></td>
        </tr>
    </table>
<?php echo CHtml::hiddenField('PasienM[no_mobile_pasien]', $modPasien->no_mobile_pasien, array('readonly'=>true)); ?>
<?php echo CHtml::hiddenField('PasienM[jenisidentitas]', $modPasien->jenisidentitas, array('readonly'=>true)); ?>
<?php echo CHtml::hiddenField('PasienM[no_identitas_pasien]', $modPasien->no_identitas_pasien, array('readonly'=>true)); ?>
<?php echo CHtml::hiddenField('PasienM[alamat_pasien]', $modPasien->alamat_pasien, array('readonly'=>true)); ?>