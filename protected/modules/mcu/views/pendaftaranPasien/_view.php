<div class="row">
    <div class="col-sm-4">
        <legend class="btn-success">Data Pasien</legend>
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
            ),
    )); ?>

    </div>

    <div class="col-sm-4">
        <legend class="btn-success">Data Kunjungan</legend>
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
                    'label'=>'Poliklinik',
                    'value'=>$model->ruangan->ruangan_nama,
                ),
		array(
                    'name'=>'jeniskasuspenyakit_id',
                    'value'=>$model->jeniskasuspenyakit->jeniskasuspenyakit_nama,
                ),
		array(
                    'name'=>'kelaspelayanan_id',
                    'value'=>$model->kelaspelayanan->kelaspelayanan_nama,
                ),
		array(
                    'name'=>'pegawai_id',
                    'value'=>$model->pegawai->nama_pegawai,
                ),
		array(
                    'name'=>'carabayar_id',
                    'value'=>$model->carabayar->carabayar_nama,
                ),
		array(
                    'name'=>'penjamin_id',
                    'value'=>$model->penjamin->penjamin_nama,
                ),

            ),
        )); ?>
    </div>
    <?php if(isset($modTindakan)){ ?>
<!--<div class="col-sm-4">
            <legend class="btn-info">Karcis</legend>
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$modTindakan,
                'attributes'=>array(
                    array(
                        'name'=>'karcis_id',
                        'value'=>$modTindakan->karcis->karcis_nama,
                    ),
                    array(
                        'name'=>'tarif_satuan',
                        'value'=>MyFormatter::formatNumberForUser($modTindakan->tarif_satuan,2),
                    ),
                    'qty_tindakan',
                    array(
                        'name'=>'tarif_tindakan',
                        'value'=>MyFormatter::formatNumberForUser(($modTindakan->tarif_satuan * $modTindakan->qty_tindakan),2),
                    ),
                ),
        )); ?>
        </div>-->
    <?php } ?>

</div>
