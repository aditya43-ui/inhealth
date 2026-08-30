<div class="panel panel-success panel-shadow">
          <div class="panel-heading">
              <div class="panel-title"><strong>Data Pasien</strong></div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo CHtml::label('Nama Pasien','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPasien, 'nama_pasien', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Tanggal Lahir','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPasien, 'tanggal_lahir', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Pendidikan','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($model, 'pendidikan_nama', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Pekerjaan','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($model, 'pekerjaan_nama', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Alamat Lengkap','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPasien, 'alamat_pasien', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('No. Telepon','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPasien, 'no_mobile_pasien', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Status Perkawinan','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPasien, 'statusperkawinan', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Nama Penanggungan Jawab Pembayar','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($model, 'nama_pj', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Nama Keluarga Terdekat','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($model, 'hubungankeluarga', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo CHtml::label('Alamat Keluarga Terdekat','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($model, 'alamat_pj', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('No. Rekam Medik','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPasien, 'no_rekam_medik', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Agama','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPasien, 'agama', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Jenis Pasien','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPendaftaran, 'carabayar_nama', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div><div class="control-group ">
                    <?php echo CHtml::label('Ruang Rawat','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPendaftaran, 'ruangan_nama', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Kelas','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPendaftaran, 'kelaspelayanan_nama', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Tanggal Masuk','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPendaftaran, 'tgl_pendaftaran', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Tanggal Keluar','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($modPasienPulang, 'tglpasienpulang', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Lama Dirawat','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textField($model, 'lamarawat', array('readonly'=>true,'class'=>'span3')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Diagnosa Masuk','', array('class'=>'control-label')) ?>
                    <div class="controls">
                       <?php echo $form->textArea($model, 'diagnosa_masuk', array('class'=>'span3')); ?>
                    </div>
                </div>
              </div>
            </div>
          </div>
      </div>