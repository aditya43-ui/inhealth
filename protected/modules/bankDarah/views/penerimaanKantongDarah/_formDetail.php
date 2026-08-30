<div class="row-fluid" id="formDetailBarang">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('No. Pengiriman','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php $no_kirimkantong = isset($modKirimKantong->no_kirimkantong) ? $modKirimKantong->no_kirimkantong : ' '; ?>
                <?php $kantongdarah_id = isset($modKirimKantong->kantongdarah_id) ? $modKirimKantong->kantongdarah_id : ''; ?>
                <?php $kirimkantongdarah_id = isset($modKirimKantong->kirimkantongdarah_id) ? $modKirimKantong->kirimkantongdarah_id : ''; ?>
                <?php echo CHtml::textField('no_kirimkantongform',$no_kirimkantong,array('class'=>'span3','readonly'=>true)); ?>
                <?php echo CHtml::hiddenField('kantongdarah_id',$kantongdarah_id,array('class'=>'span3','readonly'=>true)); ?>
                <?php echo CHtml::hiddenField('kirimkantongdarah_id',$kirimkantongdarah_id,array('class'=>'span3','readonly'=>true)); ?>

            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Ruangan Asal','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php $ruangankirim_nama = '';?> 
                <?php if(isset($modKirimKantong->ruangankirim_id)) {
                    $modRuangan = RuanganM::model()->findByPk($modKirimKantong->ruangankirim_id);
                    $ruangankirim_nama = $modRuangan->ruangan_nama;
                  }
                ?>
                <?php echo CHtml::textField('ruangankirim_nama',$ruangankirim_nama,array('class'=>'span3','readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Waktu Pengiriman','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php $tglkirimkantongdarah = isset($modKirimKantong->tglkirimkantongdarah) ? $format->formatDateTimeForUser($modKirimKantong->tglkirimkantongdarah) : '' ; ?>
                <?php echo CHtml::textField('tglkirimkantongdarah',$tglkirimkantongdarah,array('class'=>'span3','readonly'=>true)); ?>
            </div>
        </div>
        
    </div>
    <div class="col-sm-6">
       <div class="control-group">
            <?php echo CHtml::label('Petugas Pengiriman','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php
                $pegawai_nama ='';
                if(isset($modKirimKantong->petugaskirim_id)) {
                    $modPegawai = PegawaiM::model()->findByPk($modKirimKantong->petugaskirim_id);
                    $pegawai_nama = $modPegawai->nama_pegawai;
                }
                ?>
                <?php echo CHtml::textField('pegawai_nama',$pegawai_nama,array('class'=>'span3','readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Jenis Coolbox','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php
                $jenis_coolbox='';
                if(isset($modKirimKantong->coolboxdarah_id)) {
                    $modCoolbox = CoolboxdarahM::model()->findByPk($modKirimKantong->coolboxdarah_id);
                    $jenis_coolbox = $modCoolbox->coolboxdarah_nama;
                }      
                ?>
                <?php echo CHtml::textField('jenis_coolbox',$jenis_coolbox,array('class'=>'span3','readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Suhu','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php $suhu = isset($modKirimKantong->suhu) ? $modKirimKantong->suhu : '';?>
                <?php echo CHtml::textField('suhu',$suhu,array('class'=>'span2 integer2','readonly'=>true)); ?> <label>&#8451;</label>
            </div>
        </div>
        <?php /*
         <div class="control-group">
            <?php echo CHtml::label('Jumlah Coolbox','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php $jml_coolbox = isset($modKirimKantong->jml_coolbox) ? $modKirimKantong->jml_coolbox: ''; ?>
                <?php echo CHtml::textField('jml_coolbox',$jml_coolbox,array('class'=>'span2 integer2','readonly'=>true)); ?>
            </div>
        </div>
         <div class="control-group">
            <?php echo CHtml::label('Jumlah Ice Pak','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php $jml_icepack = isset($modKirimKantong->jml_icepack) ? $modKirimKantong->jml_icepack :''; ?>
                <?php echo CHtml::textField('jml_icepack',$jml_icepack,array('class'=>'span2 integer2','readonly'=>true)); ?>
            </div>
        </div>
         * 
         */ ?>
    </div>
</div>

