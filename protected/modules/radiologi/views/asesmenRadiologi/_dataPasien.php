<?php 

$this->widget('bootstrap.widgets.BootAlert'); 
$modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTImeForUser($modPendaftaran->tgl_pendaftaran);
$modPasien->nama_pasien = $modPasien->namadepan.$modPasien->nama_pasien;
?>


    <div class="panel panel-primary panel-success" >
        <div class="panel-heading">
            <div class="panel-title">Data Pasien</div>
        </div>
        <div class="panel-body">
            <div class="col-sm-5">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'pendaftaran_id',array('class'=>'control-label')); ?>
                        <?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly'=>true)); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly'=>true)); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly'=>true)); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly'=>true)); ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('readonly'=>true)); ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly'=>true)); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran->dokter, 'dokter_pemeriksa', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran->dokter, 'namaLengkap', array('readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"> Tanggal & Jam Masuk Ruangan </label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($model, 'tglmasuk_rs', array('readonly'=>true)); ?>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-5">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly'=>true)); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'nama_pasien',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly'=>true)); ?>
                    </div>
                </div>
                
                 <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'nama_bin',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly'=>true)); ?>
                    </div>
                </div>
                
                 <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly'=>true)); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran->kelaspelayanan, 'kelaspelayanan_nama', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran->kelaspelayanan, 'kelaspelayanan_nama', array('readonly'=>true)); ?>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-2">
                 <?php 
                            if(!empty($modPasien->photopasien)){
                                echo CHtml::image(Params::urlPhotoPasienDirectory().$modPasien->photopasien, 'photo pasien', array('width'=>120));
                            } else {
                                echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'photo pasien', array('width'=>120));
                            }
                        ?> 
            </div>                     
        </div>
    </div>


