<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <table style="width: 100%; border: none;">
        <tr>
            <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'tgl_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'tgl_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'no_rekam_medik',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'no_rekam_medik', array('readonly'=>true)); ?></td>
            <td rowspan="5">
                <?php 
                    if(!empty($modPasienPenunjang->photopasien)){
                        echo CHtml::image(Params::urlPhotoPasienDirectory().$modPasienPenunjang->photopasien, 'Foto pasien', array('width'=>120));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'Foto pasien', array('width'=>120));
                    }
                ?> 
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'no_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'no_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'jeniskelamin', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'umur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'umur', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'nama_pasien',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'nama_pasien', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'jeniskasuspenyakit_nama',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'jeniskasuspenyakit_nama', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'nama_bin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'nama_bin', array('readonly'=>true)); ?></td>
        </tr>
    </table>
<?php echo CHtml::hiddenField('ROPasienM[no_mobile_pasien]', $modPasien->no_mobile_pasien, array('readonly'=>true)); ?>
<?php echo CHtml::hiddenField('ROPasienM[jenisidentitas]', $modPasien->jenisidentitas, array('readonly'=>true)); ?>
<?php echo CHtml::hiddenField('ROPasienM[no_identitas_pasien]', $modPasien->no_identitas_pasien, array('readonly'=>true)); ?>
<?php echo CHtml::hiddenField('ROPasienM[alamat_pasien]', $modPasien->alamat_pasien, array('readonly'=>true)); ?>