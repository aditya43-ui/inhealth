<form class="form-horizontal">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-user"></i> Data <b>Pegawai</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('NIP', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($model,'nomorindukpegawai',array('readonly'=>true));?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Nama Pegawai', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($model,'NamaLengkap',array('readonly'=>true));?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Tempat Lahir', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($model,'tempatlahir_pegawai',array('readonly'=>true));?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Tanggal Lahir', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                                $model->tgl_lahirpegawai = MyFormatter::formatDateTimeForUser($model->tgl_lahirpegawai);
                            echo CHtml::activeTextField($model,'tgl_lahirpegawai',array('readonly'=>true));?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Jenis Kelamin', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($model,'jeniskelamin',array('readonly'=>true));?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Status Pernikahan', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($model,'statusperkawinan',array('readonly'=>true));?>
                        </div>
                    </div>
                    
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Jabatan', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($model,'jabatan_nama',array('readonly'=>true));?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Alamat Pegawai', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextArea($model,'alamat_pegawai',array('readonly'=>true));?>
                        </div>
                    </div>
                    <?php
                        if (file_exists(Params::pathPegawaiTumbsDirectory() . 'kecil_' . $model->photopegawai)) {
                            echo CHtml::image(Params::pathPegawaiTumbsDirectory() . 'kecil_' . $model->photopegawai, 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
                        } else {
                            echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
                        }
                    ?>
                </div>
            </div>  
        </div>
    </div>

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-user"></i> Mutasi <b>Pegawai</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Nomor Surat', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPegmutasi,'nomorsurat',array('readonly'=>true));?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Jabatan', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPegmutasi,'jabatan_nama',array('readonly'=>true));?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Unit Kerja', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPegmutasi,'unitkerja',array('readonly'=>true));?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Jenis Promosi', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPegmutasi,'jenispromosi_mutasi',array('readonly'=>true));?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Jabatan Baru', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPegmutasi,'jabatan_baru',array('readonly'=>true));?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Lokasi Kerja Baru', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPegmutasi,'lokasikerja_baru',array('readonly'=>true));?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Unit Kerja Baru', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPegmutasi,'unitkerja_baru',array('readonly'=>true));?>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-file"></i> Surat <b>Keputusan</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('No. SK', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPegmutasi,'nosk',array('readonly'=>true));?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Tanggal SK', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                        <?php
                                $modPegmutasi->tglsk = MyFormatter::formatDateTimeForUser($modPegmutasi->tglsk);
                            echo CHtml::activeTextField($modPegmutasi,'tglsk',array('readonly'=>true));?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('TMT SK', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                        <?php
                                $modPegmutasi->tmtsk = MyFormatter::formatDateTimeForUser($modPegmutasi->tmtsk);
                            echo CHtml::activeTextField($modPegmutasi,'tmtsk',array('readonly'=>true));?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Mengetahui', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPegmutasi,'mengetahui_nama',array('readonly'=>true));?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Menyetujui', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPegmutasi,'pimpinan_nama',array('readonly'=>true));?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Dokumen', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo (!empty($modPegmutasi->dokumen)? CHtml::link($modPegmutasi->dokumen, Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/download', array("pegmutasi_id"=>$modPegmutasi->pegmutasi_id)),array("rel"=>"tooltip","title"=>"Klik untuk mendownload dokumen")) : "");?>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</form>