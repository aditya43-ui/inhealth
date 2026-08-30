<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label class="control-label">No. SEP</label>
            <div class="controls">
                <?php echo CHtml::textField('no_sep', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Tanggal SEP</label>
            <div class="controls">
                <?php echo CHtml::textField('tgl_sep', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Jenis Pelayanan</label>
            <div class="controls">
                <?php echo CHtml::textField('jns_pelayanan', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Poli Pelayanan</label>
            <div class="controls">
                <?php echo CHtml::textField('poli_pelayanan', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Poli Eksekutif</label>
            <div class="controls">
                <?php echo CHtml::textField('poli_eksekutif', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Kelas Rawat Hak</label>
            <div class="controls">
                <?php echo CHtml::textField('kls_rawat', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Kelas Rawat Naik Kelas</label>
            <div class="controls">
                <?php echo CHtml::textField('kls_rawat_naik', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Penanggung Jawab Pembiayaan Naik Kelas</label>
            <div class="controls">
                <?php echo CHtml::textField('kls_rawat_pj', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Diagnosa</label>
            <div class="controls">
                <?php echo CHtml::textField('diagnosa', '', array('class' => 'span3', 'readonly' => true)); ?>
                <?php echo CHtml::hiddenField('diagnosaLengkap', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Status Kecelakaan</label>
            <div class="controls">
                <?php echo CHtml::textArea('status_kecelakaan', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Tanggal Kejadian</label>
            <div class="controls">
                <?php echo CHtml::textField('tgl_kejadian', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <em>Lokasi Kejadian Kecelakaan</em>
        <div class="control-group">
            <label class="control-label">Provinsi</label>
            <div class="controls">
                <?php echo CHtml::textField('propinsi', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Kabupaten/Kota</label>
            <div class="controls">
                <?php echo CHtml::textField('kabupaten', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Kecamatan</label>
            <div class="controls">
                <?php echo CHtml::textField('kecamatan', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Keterangan Kejadian Kecelakaan</label>
            <div class="controls">
                <?php echo CHtml::textField('keterangan_kecelakaan', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>  
        <div class="control-group">
            <label class="control-label">Penjamin</label>
            <div class="controls">
                <?php echo CHtml::textField('penjamin', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">DPJP Pelayanan</label>
            <div class="controls">
                <?php echo CHtml::textField('dpjp_pelayanan', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>  
        <hr/>
        <em id="kelompok_kontrol">Surat Kontrol</em>
        <div class="control-group">
            <label class="control-label">Nama Dokter</label>
            <div class="controls">
                <?php echo CHtml::textField('dokter_kontrol', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">No. Surat</label>
            <div class="controls">
                <?php echo CHtml::textField('surat_kontrol', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        
    </div>
    <div class="span6">
    <div class="control-group">
            <label class="control-label">Asuransi</label>
            <div class="controls">
                <?php echo CHtml::textField('asuransi', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">No. Kartu</label>
            <div class="controls">
                <?php echo CHtml::textField('no_kartu', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">No. Rekam Medik</label>
            <div class="controls">
                <?php echo CHtml::textField('no_rm', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Nama</label>
            <div class="controls">
                <?php echo CHtml::textField('nama', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Tanggal Lahir</label>
            <div class="controls">
                <?php echo CHtml::textField('tgl_lahir', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Jenis Kelamin</label>
            <div class="controls">
                <?php echo CHtml::textField('jns_kelamin', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Hak Akses</label>
            <div class="controls">
                <?php echo CHtml::textField('hak_akses', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Jenis Peserta</label>
            <div class="controls">
                <?php echo CHtml::textField('jns_peserta', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">COB</label>
            <div class="controls">
                <?php echo CHtml::textField('cob', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Katarak</label>
            <div class="controls">
                <?php echo CHtml::textField('katarak', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Keterangan</label>
            <div class="controls">
                <?php echo CHtml::textArea('keterangan_sep', '', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
    </div>
</div>