<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if(!empty($modPasien)){
?>
<fieldset>
    <legend>Data Pasien</legend>
    <table class="table table-condensed">
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly'=>true)); ?></td>
            <td rowspan="4">
                <?php 
                    if(!empty($modPasien->photopasien)){
                        echo CHtml::image(Params::urlPhotoPasienDirectory().$modPasien->photopasien, 'photo pasien', array('width'=>120));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'photo pasien', array('width'=>120));
                    }
                ?> 
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPasien, 'nama_bin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly'=>true)); ?></td>
        </tr>
    </table>
</fieldset>
    
<hr/>
<?php
} else {
    Yii::app()->user->setFlash('error',"Tidak ada pasien");
    $this->widget('bootstrap.widgets.BootAlert');
}

$js = <<< JS
$('#cekRiwayatPasien').change(function(){
        $('#divRiwayatPasien').slideToggle(500);
});
JS;
Yii::app()->clientScript->registerScript('JSriwayatPasien',$js,CClientScript::POS_READY);
?>
