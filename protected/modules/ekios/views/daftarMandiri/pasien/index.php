<div id="panel-pasien">
    <div class="col-sm-8">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Data Pribadi Pasien
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">

                    <div class="control-group">
                        <label class="control-label">Nama Pasien</label>
                        <div class="controls">
                            <?= CHtml::activeTextField($model,'nama_pasien',['class'=>'span3','readonly'=>true]) ?>
                        </div>
                    </div>

                     <div class="control-group">
                        <label class="control-label">No Identitas</label>
                        <div class="controls">
                            <?= CHtml::activeTextField($model,'jenisidentitas',['class'=>'span3','readonly'=>true]) ?>
                            <br/>
                            <?= CHtml::activeTextField($model,'no_identitas_pasien',['class'=>'span3','readonly'=>true]) ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Jenis Kelamin</label>
                        <div class="controls">
                            <?= CHtml::activeTextField($model,'jeniskelamin',['class'=>'span3','readonly'=>true]) ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Tempat Lahir</label>
                        <div class="controls">
                            <?= CHtml::activeTextField($model,'tempat_lahir',['class'=>'span3','readonly'=>true]) ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Tanggal Lahir</label>
                        <div class="controls">
                            <?= CHtml::activeTextField($model,'tanggal_lahir',['class'=>'span3','readonly'=>true]) ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Umur</label>
                        <div class="controls">
                            <?= CHtml::activeTextField($model,'umur',['class'=>'span3','readonly'=>true]) ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Status Perkawinan</label>
                        <div class="controls">
                            <?= CHtml::activeTextField($model,'statusperkawinan',['class'=>'span3','readonly'=>true]) ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Umur</label>
                        <div class="controls">
                            <?= CHtml::activeTextField($model,'golongandarah',['class'=>'span3','readonly'=>true]) ?>
                        </div>
                    </div>
                    <br/>
                </div>

                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label">Nama Ibu</label>
                        <div class="controls">
                            <?= CHtml::activeTextField($model,'nama_ibu',['class'=>'span3','readonly'=>true]) ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Nama Ayah</label>
                        <div class="controls">
                            <?= CHtml::activeTextField($model,'nama_ayah',['class'=>'span3','readonly'=>true]) ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Anak Ke</label>
                        <div class="controls">
                            <?= CHtml::activeTextField($model,'anakke',['class'=>'span1','readonly'=>true]) ?>
                        </div>
                        <div class="controls">dari</div>
                        <div class="controls">
                            <?= CHtml::activeTextField($model,'jumlah_bersaudara',['class'=>'span1','readonly'=>true]) ?>
                        </div>
                        <div class="controls">bersaudara</div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Pekerjaan</label>
                        <div class="controls">
                            <?= CHtml::activeTextField($model,'pekerjaan_nama',['class'=>'span3','readonly'=>true]) ?>
                        </div>
                    </div>

                     <div class="control-group">
                        <label class="control-label">Agama</label>
                        <div class="controls">
                            <?= CHtml::activeTextField($model,'agama',['class'=>'span3','readonly'=>true]) ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Pendidikan</label>
                        <div class="controls">
                            <?= CHtml::activeTextField($model,'pendidikan_nama',['class'=>'span3','readonly'=>true]) ?>
                        </div>
                    </div>

                </div>            
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Alamat Dan Kontak
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <label class="control-label">Alamat</label>
                    <div class="controls">
                        <?= CHtml::activeTextArea($model,'alamat_pasien',['class'=>'span3','rows'=>4,'readonly'=>true]) ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">RT/RW</label>
                    <div class="controls">
                        <?= CHtml::activeTextField($model,'rt',['class'=>'span1','readonly'=>true]) ?>
                    </div>
                    <div class="controls">/</div>
                    <div class="controls">
                        <?= CHtml::activeTextField($model,'rw',['class'=>'span1','readonly'=>true]) ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Propinsi</label>
                    <div class="controls">
                        <?= CHtml::activeTextField($model,'propinsi_nama',['class'=>'span3','readonly'=>true]) ?>
                    </div>
                </div>      

                <div class="control-group">
                    <label class="control-label">Kabupaten</label>
                    <div class="controls">
                        <?= CHtml::activeTextField($model,'kabupaten_nama',['class'=>'span3','readonly'=>true]) ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Kecamatan</label>
                    <div class="controls">
                        <?= CHtml::activeTextField($model,'kecamatan_nama',['class'=>'span3','readonly'=>true]) ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Kelurahan</label>
                    <div class="controls">
                        <?= CHtml::activeTextField($model,'kelurahan_nama',['class'=>'span3','readonly'=>true]) ?>
                    </div>
                </div>

                 <div class="control-group">
                    <label class="control-label">No. Handphone</label>
                    <div class="controls">
                        <?= CHtml::activeTextField($model,'no_mobile_pasien',['class'=>'span3','readonly'=>true]) ?>
                    </div>
                </div>

                 <div class="control-group">
                    <label class="control-label">Warga Negara</label>
                    <div class="controls">
                        <?= CHtml::activeTextField($model,'warga_negara',['class'=>'span3','readonly'=>true]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <div class="col-sm-6">
            <?= CHtml::button("Kembali",['onclick'=>"location.href='".$this->createUrl('/ekios/daftarMandiri/pasien')."'", 'class'=>'btn btn-white']) ?>
        </div>

        <div class="col-sm-6 lanjut-position" style="text-align:right;">
            <?= CHtml::button("Lanjut",['onclick'=>"loadPolik();", 'class'=>'btn btn-success btn-lanjut']) ?>
        </div>
    </div>
</div>


<div id="panel-polik"></div>

<div id="panel-dokter"></div>

<div id="panel-jadwal"></div>

<div id="panel-verifikasi"></div>