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
            <td><?php echo CHtml::activeLabel($modHasilLab, 'nohasilperiksalab',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modHasilLab, 'nohasilperiksalab', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modHasilLab, 'tglhasilpemeriksaanlab',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modHasilLab, 'tglhasilpemeriksaanlab', array('readonly'=>true)); ?></td>
        </tr>
    </table>
<?php echo CHtml::hiddenField('LBPasienM[no_mobile_pasien]', $modPasien->no_mobile_pasien, array('readonly'=>true)); ?>
<?php echo CHtml::hiddenField('LBPasienM[jenisidentitas]', $modPasien->jenisidentitas, array('readonly'=>true)); ?>
<?php echo CHtml::hiddenField('LBPasienM[no_identitas_pasien]', $modPasien->no_identitas_pasien, array('readonly'=>true)); ?>
<?php echo CHtml::hiddenField('LBPasienM[alamat_pasien]', $modPasien->alamat_pasien, array('readonly'=>true)); ?>