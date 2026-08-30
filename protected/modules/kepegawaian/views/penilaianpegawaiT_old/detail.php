<legend class="rim2">Personal Scoring Detail</legend>
<fieldset class="form-horizontal">
    <table class="table">
        <tr>
            <!--====================== kolom ke-1 ==============================================-->
            <td>
                <?php // echo $form->textFieldRow($modPegawai,'nomorindukpegawai',array('readonly'=>true,'id'=>'NIP')); ?>
                <div class="control-group">
                    <?php echo CHtml::label('NIP','nip',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->pegawai->nomorindukpegawai,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Nama Pegawai','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->nama_pegawai,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tempat lahir pegawai','',array('class'=>'control-label')) ?>
                    <div class="controls"><?php echo CHtml::label($model->pegawai->tempatlahir_pegawai,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. lahir pegawai','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->pegawai->tgl_lahirpegawai,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Jenis kelamin','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->pegawai->jeniskelamin,'') ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Status perkawinan','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->pegawai->statusperkawinan,''); ?></div>
                </div>
            </td>
            <!--=========================== kolom ke 2 ======================================-->
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Jabatan','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo isset($model->pegawai->jabatan_id) ? CHtml::label($model->pegawai->jabatan->jabatan_nama,'') : "-"; ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Pangkat','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo isset($model->pegawai->pangkat_id) ? CHtml::label($model->pegawai->pangkat->pangkat_nama,'') : "-"; ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Pendidikan','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo isset($model->pegawai->pendidikan_id) ? CHtml::label($model->pegawai->pendidikan->pendidikan_nama,'') : "-"; ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Gaji pokok','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->pegawai->gajipokok,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Kategori pegawai','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->pegawai->kategoripegawai,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Kategori pegawai asal','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->pegawai->kategoripegawaiasal,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Kelompok pegawai','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->pegawai->kelompokpegawai->kelompokpegawai_nama,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Alamat pegawai','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->pegawai->alamat_pegawai,''); ?></div>
                </div>
            </td>
            <td>
                <?php 
                    if(!empty($modPegawai->photopegawai)){
                        echo CHtml::image(Params::urlPegawaiTumbsDirectory().'kecil_'.$model->pegawai->photopegawai, 'Foto pasien', array('id'=>'photo_pasien','width'=>150));
                    } else {
                        echo CHtml::image(Params::urlPegawaiDirectory().'no_photo.jpeg', 'Photo Pegawai', array('id'=>'photo_pasien','width'=>150));
                    }
                ?> 
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td colspan="2">
                <legend class="rim">Detail Penilaian</legend>
            </td>
        </tr>
        <tr>
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. penilaian','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->tglpenilaian,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Periode penilaian','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->periodepenilaian,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Kesetiaan','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::label($model->kesetiaan,''); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Prestasi kerja','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->prestasikerja,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tanggung jawab','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->tanggungjawab,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Ketaatan','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->ketaatan,''); ?></div>
                </div>
            </td>
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('','',array('class'=>'control-label')); ?>
                    <div class="controls">&nbsp;</div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Sampai dengan','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->sampaidengan,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Kejujuran','',array('class'=>'control-label')); ?>
                    <div class="controls">
                       <?php echo CHtml::label($model->kejujuran,''); ?>
                    </div>
                </div>                
                <div class="control-group">
                    <?php echo CHtml::label('Kerjasama','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::label($model->kerjasama,''); ?>
                    </div>
                </div>                
                <div class="control-group">
                    <?php echo CHtml::label('Prakarsa','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::label($model->prakarsa,''); ?>
                    </div>
                </div>                
                <div class="control-group">
                    <?php echo CHtml::label('Kepemimpinan','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::label($model->kepemimpinan,''); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Jumlah penilaian','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::label($model->jumlahpenilaian,''); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Nilai rata-rata penilaian','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::label($model->nilairatapenilaian,''); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Performance index','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::label($model->performanceindex,''); ?>
                    </div>
                </div>
                
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <legend class="rim">Keterangan</legend>
            </td>
        </tr>
        <tr>
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Keterangan penilaian pegawai','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->penilaianpegawai_keterangan,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('keberatan pegawai','',array('class'=>'control-label')); ?>
                    <div class="controls">
                    <?php echo CHtml::label($model->tanggal_keberatanpegawai,'').'<br>'; ?>
                    <?php echo CHtml::label($model->keberatanpegawai,''); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. diterima pegawai','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->diterimatanggalpegawai,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. diterima atasan','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->diterimatanggalatasan,''); ?></div>
                </div>
            </td>
            <td>
                
                <div class="control-group">
                    <?php echo CHtml::label('Tanggapan pejabat','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::label($model->tanggapanpejabat,''); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Keputusan atasan','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::label($model->tanggal_keputusanatasan,''); ?>
                        <?php echo CHtml::label($model->keputusanatasan,''); ?>
                    </div>
                </div>
                
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <legend class="rim">Penilai</legend>
            </td>
        </tr>
        <tr>
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Penilai nama','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->penilainama,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Golongan pangkat penilai','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->penilaipangkatgol,'') ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Jabatan penilai','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->penilaijabatan,''); ?></div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Penilai unit organisasi','',array('class'=>'control-label')); ?>
                    <div class="controls"><?php echo CHtml::label($model->penilaiunitorganisasi,''); ?></div>
                </div>
                
            </td>
            <td>
                
                <div class="control-group">
                    <?php echo CHtml::label('Pimpinan nama','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::label($model->pimpinannama,''); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Pimpinan NIP','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::label($model->pimpinannip,''); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Pimpinan pangkat golongan','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::label($model->pimpinanpangkatgol,''); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Pimpinan jabatan','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::label($model->pimpinanjabatan,''); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Pimpinan unit organisasi','',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::label($model->pimpinanunitorganisasi,''); ?>
                    </div>
                </div>
                
            </td>
        </tr>
    </table>
</fieldset>
