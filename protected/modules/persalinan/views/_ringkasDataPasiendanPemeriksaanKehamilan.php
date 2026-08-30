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
                        echo CHtml::image(Params::urlPhotoPasienDirectory().$modPasien->photopasien, 'Foto pasien', array('width'=>120));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'Foto pasien', array('width'=>120));
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
<?php if ($this->getId() != 'imunisasi'){ ?>
<fieldset>
    <legend>Data Periksa Kehamilan</legend>    
    <table>        
         <tr>
            <td><?php echo CHtml::activeLabel($modPeriksaKehamilan, 'pegawai_id',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPeriksaKehamilan->pegawai, 'nama_pegawai', array('readonly'=>true)); ?></td>

            <td><?php echo CHtml::activeLabel($modPeriksaKehamilan, 'tglakhirmenstruasi',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPeriksaKehamilan, 'tglakhirmenstruasi', array('readonly'=>true)); ?></td>
        </tr>     

         <tr>
             <td><?php echo CHtml::Label('Jumlah Partus','Jumlah Partus',array('class'=>'control-label')); ?></td>
            <td><?php
                    $jumlahpartus=$modPeriksaKehamilan->jmlpartusimaturus + $modPeriksaKehamilan->jmlpartusmaturus + $modPeriksaKehamilan->jmlpartuspostmaturus;
                    echo CHtml::TextField('nama',$jumlahpartus, array('readonly'=>true)); ?>
            </td>

            <td><?php echo CHtml::activeLabel($modPeriksaKehamilan, 'jmlabortus',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPeriksaKehamilan, 'jmlabortus', array('readonly'=>true)); ?></td>
        </tr> 
        <tr>
            <td><?php echo CHtml::activeLabel($modPeriksaKehamilan, 'posisijanin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::activeTextField($modPeriksaKehamilan, 'posisijanin', array('readonly'=>true)); ?></td>
            <td>
                 <?php echo CHtml::activeLabel($modPeriksaKehamilan,'tb_cm',array('class'=>'control-label','style'=>'width:75px'));?>
                 <?php echo CHtml::activeLabel($modPeriksaKehamilan,'bb_gram',array('class'=>'control-label','style'=>'width:80px'));?>
            </td>
            <td>

                 <?php echo CHtml::activeTextField($modPeriksaKehamilan,'tb_cm',array('readonly'=>true,'class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10,'size'=>3));?>
                 <?php echo CHtml::activeTextField($modPeriksaKehamilan,'bb_gram',array('readonly'=>true,'class'=>'span1 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10,'size'=>3));?>
                    Cm / Gram
            </td>
        </tr> 
</table>
</fieldset>
<?php } ?>

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
