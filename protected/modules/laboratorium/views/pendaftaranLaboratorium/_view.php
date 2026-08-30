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
                        'name'=>'no_urutantri',
                        'value'=>(!empty($model->no_urutantri) ? $model->no_urutantri : "Otomatis"),
                    ),
    //		array(
    //                    'name'=>'ruangan_id',
    //                    'label'=>'Poliklinik',
    //                    'value'=>$model->ruangan->ruangan_nama,
    //                ),
    //		array(
    //                    'name'=>'jeniskasuspenyakit_id',
    //                    'value'=>$model->jeniskasuspenyakit->jeniskasuspenyakit_nama,
    //                ),
    //		array(
    //                    'name'=>'kelaspelayanan_id',
    //                    'value'=>$model->kelaspelayanan->kelaspelayanan_nama,
    //                ),
    //		array(
    //                    'name'=>'pegawai_id',
    //                    'value'=>$model->pegawai->nama_pegawai,
    //                ),
                    array(
                        'name'=>'carabayar_id',
                        'value'=>$model->carabayar->carabayar_nama,
                    ),
                    array(
                        'name'=>'penjamin_id',
                        'value'=>$model->penjamin->penjamin_nama,
                    ),
    //		array(
    //                    'name'=>'keadaanmasuk',
    //                    'value'=>$model->keadaanmasuk,
    //                ),
    //		array(
    //                    'name'=>'transportasi',
    //                    'value'=>$model->transportasi,
    //                ),

                ),
            )); ?>
        </div>
    </div>
    <?php foreach($modPasienMasukPenunjangs AS $i => $modPenunjang){ ?>
        <div class="col-sm-4">
            <div class="block-tabel">
                <h6>Kunjungan <b><?php echo $modPenunjang->ruangan->ruangan_nama ?? null ?></b></h6>
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    'data'=>$modPenunjang,
                    'attributes'=>array(
                        array(
                            'name'=>'no_masukpenunjang',
                            'value'=>(!empty($modPenunjang->no_pendaftaran) ? $model->no_pendaftaran : "Otomatis"),
                        ),
                        array(
                            'name'=>'tglmasukpenunjang',
                            'value'=>MyFormatter::formatDateTimeForUser(empty($modPenunjang->tglmasukpenunjang) ? date("Y-m-d H:i:s"):$modPenunjang->tglmasukpenunjang),
                        ),
                        array(
                            'name'=>'jeniskasuspenyakit_id',
                            'value'=>isset($modPenunjang->jeniskasuspenyakit) ? $modPenunjang->jeniskasuspenyakit->jeniskasuspenyakit_nama : "-",
                        ),
                        array(
                            'name'=>'kelaspelayanan_id',
                            'value'=>isset($modPenunjang->kelaspelayanan) ? $modPenunjang->kelaspelayanan->kelaspelayanan_nama : "-",
                        ),
                        array(
                            'name'=>'pegawai_id',
                            'value'=> !empty($modPenunjang->pegawai_id) ? $modPenunjang->pegawai->nama_pegawai : '-',
                        ),
                    ),
                )); ?>
            </div>
        </div>
    <?php } ?>
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

    <?php if(count((array)$modTindakans) > 0){ ?>
        <div class="col-sm-4">
            <div class="block-tabel">
                <h6><b>Pemeriksaan</b></h6>
                <table class="table table-condensed table-bordered">
                    <thead>
                        <th>Pemeriksaan</th>
                        <th>Tarif (Rp)</th>
                    </thead>
                    <tbody>
                <?php
                $total = 0;
                foreach($modTindakans AS $i=>$modTindakan){
                    foreach($modTindakan AS $ii=>$tindakan){
                        $total += ($tindakan->tarif_satuan * $tindakan->qty_tindakan);
                ?>
                        <tr>
                            <td><?php echo $tindakan->getPemeriksaanLab()->pemeriksaanlab_nama?></td>
                            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForUser(($tindakan->tarif_satuan * $tindakan->qty_tindakan),2)?></td>
                        </tr>
                <?php
                    }
                }
                ?>
                    </tbody>
                    <tfoot>
                        <tr style="text-align: right;">
                            <td>Total</td>
                            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForUser($total,2); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    <?php } ?>
    <?php if(count((array)$modKarcis) > 0){ ?>
        <div class="col-sm-4">
            <div class="block-tabel">
                <h6><b>Karcis</b></h6>
                <table class="table table-condensed table-bordered">
                    <thead>
                        <th>Karcis</th>
                        <th>Tarif (Rp)</th>
                    </thead>
                    <tbody>
                <?php
                $total = 0;
                foreach($modKarcis AS $i=>$karcis){
                        $total += ($karcis->harga_tariftindakan);
                ?>
                        <tr>
                            <td><?php echo $karcis->karcis_nama?></td>
                            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForUser($karcis->harga_tariftindakan,2)?></td>
                        </tr>
                <?php
                }
                ?>
                    </tbody>
                    <tfoot>
                        <tr style="text-align: right;">
                            <td>Total</td>
                            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForUser($total,2); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    <?php } ?>

    <?php if(count((array)$modPengambilanSamples) > 0){ ?>
            <?php foreach($modPengambilanSamples AS $i=>$modPengambilanSample){ ?>
                <div class="col-sm-4">
                    <legend class="btn-info">Sample <?php echo $modPasienMasukPenunjangs[$i]->ruangan->ruangan_nama;?></legend>
                    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                        'data'=>$modPengambilanSample,
                        'attributes'=>array(
                                array(
                                    'name'=>'samplelab_id',
                                    'value'=>$modPengambilanSample->samplelab->samplelab_nama,
                                ),
                                array(
                                    'name'=>'no_pengambilansample',
                                    'value'=>$modPengambilanSample->no_pengambilansample,
                                ),
                                array(
                                    'name'=>'jmlpengambilansample',
                                    'value'=>$modPengambilanSample->jmlpengambilansample,
                                ),
                                array(
                                    'name'=>'tglpengambilansample',
                                    'value'=>MyFormatter::formatDateTimeForUser($modPengambilanSample->tglpengambilansample),
                                ),
                            ),
                    )); ?>
                </div>
        <?php } ?>
    <?php } ?>
</div>
