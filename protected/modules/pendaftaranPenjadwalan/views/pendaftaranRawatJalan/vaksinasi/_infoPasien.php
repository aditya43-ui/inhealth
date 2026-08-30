<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Informasi Data Pasien</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($modPasien, 'no_rekam_medik', array('readonly'=>true)); ?>
                <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('readonly'=>true)); ?>
                <?php echo $form->textFieldRow($modPasien, 'nama_pasien', array('readonly'=>true)); ?>
                <?php echo $form->textFieldRow($modPasien, 'nama_bin', array('readonly'=>true)); ?>
                <?php echo $form->textFieldRow($modPasien, 'jeniskelamin', array('readonly'=>true)); ?>
                <?php echo $form->textFieldRow($modPasien, 'tanggal_lahir', array('readonly'=>true)); ?>
                <?php echo $form->textFieldRow($modPasien, 'alamat_pasien', array('readonly'=>true)); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'umur', array('readonly'=>true)); ?>
                <div class="control-group">
                    <label class="control-label">Jenis Kasus Penyakit</label>
                    <div class="controls">
                        <?php echo $form->textField($model->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly'=>true)); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model->ruangan, 'ruangan_nama', array('readonly'=>true)); ?>
                <div class="control-group">
                    <label class="control-label">Kelas Pelayanan</label>
                    <div class="controls">
                        <?php echo $form->textField($model->kelaspelayanan, 'kelaspelayanan_nama', array('readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Jenis Penjamin/Penjamin</label>
                    <div class="controls">
                        <?php echo $form->textField($model->carabayar, 'carabayar_nama', array('readonly'=>true, 'class'=>'span2')); ?>
                        <?php echo $form->textField($model->penjamin, 'penjamin_nama', array('readonly'=>true, 'class'=>'span2')); ?>
                        
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Dokter</label>
                    <div class="controls">
                        <?php echo $form->textField($model->pegawai, 'namaLengkap', array('readonly'=>true)); ?>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>