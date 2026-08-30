<?php $this->widget('bootstrap.widgets.BootAlert'); 

$jabatan = $modPegawai->jabatan;

if (empty($jabatan)) {
    $jabatan = new JabatanM;
} 

?>
    <table style="width: 100%; border: none;">
        <tr>
            <td><?php echo CHtml::activeLabel($modPegawai, 'nomorindukpegawai',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPegawai, 'nomorindukpegawai', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::activeLabel($modPegawai, 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPegawai, 'jeniskelamin', array('readonly'=>true)); ?></td>
            
        </tr>
        <tr>
            <td><?php echo CHtml::activeLabel($modPegawai, 'nama_pegawai',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPegawai, 'namaLengkap', array('readonly'=>true, 'class'=>'nama_penerima')); ?></td>
            
            <td><?php echo CHtml::activeLabel($jabatan, 'jabatan_nama',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($jabatan, 'jabatan_nama', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            
        </tr>
    </table>
<?php echo CHtml::hiddenField('PasienM[no_mobile_pasien]', $modPegawai->nomobile_pegawai, array('readonly'=>true)); ?>