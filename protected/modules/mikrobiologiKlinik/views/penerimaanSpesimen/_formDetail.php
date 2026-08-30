<div class="row-fluid" id="formDetailBarang">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('No. Pengiriman', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php $no_kirimspesimen = isset($modKirimSpesimen->no_kirimspesimen) ? $modKirimSpesimen->no_kirimspesimen : ' '; ?>
                <?php $spesimen_id = isset($modKirimSpesimen->spesimen_id) ? $modKirimSpesimen->spesimen_id : ''; ?>
                <?php $pengirimanspesimen_id = isset($modKirimSpesimen->pengirimanspesimen_id) ? $modKirimSpesimen->pengirimanspesimen_id : ''; ?>
                <?php echo CHtml::textField('no_kirimspesimenform', $no_kirimspesimen, array('class' => 'span3', 'readonly' => true)); ?>
                <?php echo CHtml::hiddenField('spesimen_id', $spesimen_id, array('class' => 'span3', 'readonly' => true)); ?>
                <?php echo CHtml::hiddenField('pengirimanspesimen_id', $pengirimanspesimen_id, array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tanggal Pengiriman', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php $tglkirimspesimen = isset($modKirimSpesimen->tglkirimspesimen) ? $format->formatDateTimeForUser($modKirimSpesimen->tglkirimspesimen) : ''; ?>
                <?php echo CHtml::textField('tglkirimspesimen', $tglkirimspesimen, array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Petugas', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $pegawai_nama = '';
                if (isset($modKirimSpesimen->petugaskirim_id)) {
                    $modPegawai = PegawaiM::model()->findByPk($modKirimSpesimen->petugaskirim_id);
                    $pegawai_nama = $modPegawai->nama_pegawai;
                }
                ?>
                <?php echo CHtml::textField('pegawai_nama', $pegawai_nama, array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Instalasi', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php $instalasikirim_nama = ''; ?> 
                <?php
                if (isset($modKirimSpesimen->ruangan_id)) {
                    $modRuangan = RuanganM::model()->findByPk($modKirimSpesimen->ruangan_id);
                    $instalasikirim_nama = $modRuangan->instalasi->instalasi_nama;
                }
                ?>
                <?php echo CHtml::textField('instalasikirim_nama', $instalasikirim_nama, array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan Pengirim', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php $ruangankirim_nama = ''; ?> 
                <?php
                if (isset($modKirimSpesimen->ruangan_id)) {
                    $modRuangan = RuanganM::model()->findByPk($modKirimSpesimen->ruangan_id);
                    $ruangankirim_nama = $modRuangan->ruangan_nama;
                }
                ?>
                <?php echo CHtml::textField('ruangankirim_nama', $ruangankirim_nama, array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php $keterangan = isset($modKirimSpesimen->keterangan_pengiriman) ? $modKirimSpesimen->keterangan_pengiriman : ''; ?>
                <?php echo CHtml::textArea('keterangan_pengiriman', $keterangan, array('rows' => 2, 'class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
    </div>
</div>

