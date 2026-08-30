<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('NIP','nomorindukpegawai',array('class'=>'control-label')) ?>
        <div class="controls">
            <?php
              echo $form->textField($modPegawai,'nomorindukpegawai',array('readonly'=>true));
               ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Nama Pegawai','namapegawai',array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->hiddenField($modPegawai,'pegawai_id',array('readonly'=>true)) ?>
            <?php echo $form->textField($modPegawai,'nama_pegawai',array('readonly'=>true)) ?>
            <?php
 ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modPegawai,'tempatlahir_pegawai',array('readonly'=>true,'id'=>'tempatlahir_pegawai')); ?>
    <?php echo $form->textFieldRow($modPegawai, 'tgl_lahirpegawai',array('readonly'=>true,'id'=>'tgl_lahirpegawai')); ?>
    <?php echo $form->textFieldRow($modPegawai, 'jeniskelamin',array('readonly'=>true,'id'=>'jeniskelamin')); ?>
    <?php echo $form->textFieldRow($modPegawai,'jabatan_nama',array('readonly'=>true,'id'=>'jabatan')); ?>
</div>
<div class="col-sm-6">
    <?php echo $form->textFieldRow($modPegawai,'no_rekening',array('readonly'=>true,)); ?>
    <?php echo $form->textFieldRow($modPegawai,'npwp',array('readonly'=>true,)); ?>
    <?php echo $form->textFieldRow($modPegawai,'nomobile_pegawai',array('readonly'=>true,)); ?>
    <?php echo $form->textFieldRow($modPegawai,'agama',array('readonly'=>true,)); ?>
    <?php echo $form->textAreaRow($modPegawai,'alamat_pegawai',array('readonly'=>true,'id'=>'alamat_pegawai', 'class'=>'autogrow')); ?>
    <?php 
        if(file_exists(Params::pathPegawaiTumbsDirectory().'kecil_'.$modPegawai->photopegawai)){
            echo CHtml::image(Params::pathPegawaiTumbsDirectory().'kecil_'.$modPegawai->photopegawai, 'Foto pasien', array('id'=>'photo_pasien','width'=>150));
        } else {
            echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'Photo tidak tersedia', array('id'=>'photo_pasien','width'=>150));
        }
    ?> 
</div>