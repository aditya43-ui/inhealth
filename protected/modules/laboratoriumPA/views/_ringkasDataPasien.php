<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
 <legend class="rim2">Periksa Pasien</legend>
<fieldset>
    <legend class="rim">Data Pasien</legend>
    <table class="table table-condensed">
        <tr>
            <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'tgl_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'tgl_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'no_rekam_medik',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'no_rekam_medik', array('readonly'=>true)); ?></td>
            <td rowspan="5">
                <?php 
                    if(!empty($modPasienMasukPenunjang->photopasien)){
                        echo CHtml::image(Params::urlPhotoPasienDirectory().$modPasienMasukPenunjang->photopasien, 'photo pasien', array('width'=>120));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'photo pasien', array('width'=>120));
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
         <tr>
            <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'tglpengambilansample',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'tglpengambilansample', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'no_pengambilansample',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'no_pengambilansample', array('readonly'=>true)); ?></td>
        </tr>
    </table>
</fieldset>   
