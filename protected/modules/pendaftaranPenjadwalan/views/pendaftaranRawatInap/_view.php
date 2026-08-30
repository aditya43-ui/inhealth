<div class="row">
    <div class="col-sm-4">
        <div class="block-tabel">
            <h6>Data <b>Pasien</b></h6>
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$modPasien,
                'attributes'=>array(
                    array(
                        'name'=>'no_rekam_medik',
                        'value'=>(!empty($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : "Otomatis"),
                    ),
                    'nama_pasien',
                    'nama_bin',
                    'jeniskelamin',
                    array(
                        'name'=>'tanggal_lahir',
                        'value'=>MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir),
                    ),
                    'tempat_lahir',
                    'alamat_pasien',
                    'no_mobile_pasien',
                    'statusperkawinan',
                    'nama_ibu',
                    'warga_negara',
                    'agama',
                                    array(
                        'name'=>'pegawai.nomorindukpegawai',
                        'label'=>'NIP Penanggung Jawab'
                    ),
                                    array(
                        'name'=>'pegawai.NamaLengkap',
                        'label'=>'Nama Penanggung Jawab'
                    ),
                ),
            )); ?>
        </div>
        <?php if(isset($modPenanggungJawab)){ ?>
        <div class="block-tabel">
            <h6>Data <b>Penanggung Jawab</b></h6>
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$modPenanggungJawab,
                'attributes'=>array(
                    'pengantar',
                    'nama_pj',
                    'jeniskelamin',
                    'no_mobilepj',
                ),
            )); ?>
        </div>
        <?php } ?>
    </div>
  
    <div class="col-sm-4">
        <div class="block-tabel">
            <h6>Data <b>Kunjungan</b></h6>
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$model,
                'attributes'=>array(
                    array(
                        'name'=>'no_pendaftaran',
                        'value'=>(!empty($model->no_pendaftaran) ? $model->no_pendaftaran : "Otomatis"),
                    ),
                    array(
                        'name'=>'tgl_pendaftaran',
                        'value'=>MyFormatter::formatDateTimeForUser($model->tgl_pendaftaran),
                    ),
                    array(
                        'name'=>'no_pendaftaran',
                        'value'=>(!empty($model->no_urutantri) ? $model->no_urutantri : "Otomatis"),
                    ),
                    array(
                        'name'=>'ruangan_id',
                        'value'=>$modPasienAdmisi->ruangan->ruangan_nama,
                    ),
                    array(
                        'label'=>'Kamar',
                        'value'=>!empty($modPasienAdmisi->kamarruangan_id) ? $modPasienAdmisi->kamarruangan->kamarruangan_nokamar.' - '.$modPasienAdmisi->kamarruangan->kamarruangan_nobed : "-",
                    ),
                    array(
                        'name'=>'jeniskasuspenyakit_id',
                        'value'=>$model->jeniskasuspenyakit->jeniskasuspenyakit_nama,
                    ),
                    array(
                        'name'=>'kelaspelayanan_id',
                        'value'=>$modPasienAdmisi->kelaspelayanan->kelaspelayanan_nama,
                    ),
                    array(
                        'name'=>'pegawai_id',
                        'value'=>$modPasienAdmisi->pegawai->namaLengkap,
                    ),
                    array(
                        'name'=>'carabayar_id',
                        'value'=>$modPasienAdmisi->carabayar->carabayar_nama,
                    ),
                    array(
                        'name'=>'penjamin_id',
                        'value'=>$modPasienAdmisi->penjamin->penjamin_nama,
                    ),
                    array(
                        'name'=>'keterangan_pendaftaran',
                        'value'=>$model->keterangan_pendaftaran,
                    ),

                ),
            )); ?>
        </div>
    </div>
    <?php if(isset($modRujukan)){ ?>
        <div class="col-sm-4">
            <div class="block-tabel">
                <h6>Data <b>Rujukan</b></h6>
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    'data'=>$modRujukan,
                    'attributes'=>array(
                        array(
                        'name'=>'asalrujukan_id',
                        'value'=>$modRujukan->asalrujukan->asalrujukan_nama,
                        ),
                        'no_rujukan',
                        array(
                            'name'=>'nama_perujuk',
                            'value'=>(isset($modRujukan->rujukandari_id)?$modRujukan->rujukandari->namaperujuk:" ").(!empty($modRujukan->nama_perujuk)?" /".$modRujukan->nama_perujuk:" "),
                        ),
                        array(
                        'name'=>'tanggal_rujukan',
                        'value'=>MyFormatter::formatDateTimeForUser($modRujukan->tanggal_rujukan),
                        ),
                    ),
                )); ?>
            </div>
        </div>
    <?php } ?>
    <?php if(isset($modTindakan)){ ?>
        <div class="col-sm-4">
            <div class="block-tabel">
                <h6><b>Karcis</b></h6>
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    'data'=>$modTindakan,
                    'attributes'=>array(
                        array(
                            'name'=>'karcis_id',
                            'value'=>$modTindakan->karcis->karcis_nama,
                        ),
                        array(
                            'name'=>'tarif_satuan',
                            'value'=>MyFormatter::formatNumberForUser($modTindakan->tarif_satuan),
                        ),
                        'qty_tindakan',
                        array(
                            'name'=>'tarif_tindakan',
                            'value'=>MyFormatter::formatNumberForUser($modTindakan->tarif_satuan * $modTindakan->qty_tindakan),
                        ),
                    ),
                )); ?>
            </div>
        </div>
    <?php } ?>
    
</div>