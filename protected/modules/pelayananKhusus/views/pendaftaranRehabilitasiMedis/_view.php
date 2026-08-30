<div class="row-fluid">
    <div class="span4">
        <legend class="btn-info">Data Pasien</legend>
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
        
    <?php if(isset($modPenanggungJawab)){ ?>
            <legend class="btn-info">Data Penanggung Jawab</legend>
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$modPenanggungJawab,
                'attributes'=>array(
                    'pengantar',
                    'nama_pj',
                    'jeniskelamin',
                    'no_mobilepj',
                ),
        )); ?>
    <?php } ?>
    </div>
    
    
    <div class="span4">
        <legend class="btn-info">Data Kunjungan</legend>
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
        <div class="span4">
            <legend class="btn-info">Kunjungan <?php echo $modPasienMasukPenunjang->ruangan->ruangan_nama ?></legend>
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$modPasienMasukPenunjang,
                'attributes'=>array(
                    array(
                        'name'=>'no_masukpenunjang',
                        'value'=>(!empty($modPasienMasukPenunjang->no_pendaftaran) ? $model->no_pendaftaran : "Otomatis"),
                    ),
                    array(
                        'name'=>'tglmasukpenunjang',
                        'value'=>MyFormatter::formatDateTimeForUser(empty($modPasienMasukPenunjang->tglmasukpenunjang) ? date("Y-m-d H:i:s"):$modPasienMasukPenunjang->tglmasukpenunjang),
                    ),
                    array(
                        'name'=>'jeniskasuspenyakit_id',
                        'value'=>$modPasienMasukPenunjang->jeniskasuspenyakit->jeniskasuspenyakit_nama,
                    ),
                    array(
                        'name'=>'kelaspelayanan_id',
                        'value'=>$modPasienMasukPenunjang->kelaspelayanan->kelaspelayanan_nama,
                    ),
                    array(
                        'name'=>'pegawai_id',
                        'value'=>$modPasienMasukPenunjang->pegawai->nama_pegawai,
                    ),
                ),
            )); ?>
        </div>
    <?php if(isset($modRujukan)){ ?>
        <div class="span4">
            <legend class="btn-info">Data Rujukan</legend>
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
    <?php } ?>
    
    <?php if(count($modTindakans) > 0){ ?>
        <div class="span4">
            <legend class="btn-info">Pemeriksaan</legend>
            <table class="table table-condensed table-bordered">
                <thead>
                    <th>Pemeriksaan</th>
                    <th>Tarif (Rp.)</th>
                </thead>
                <tbody>
            <?php 
            $total = 0;
            foreach($modTindakans AS $ii=>$tindakan){
                $total += ($tindakan->tarif_satuan * $tindakan->qty_tindakan);
            ?>
                <tr>
                    <td><?php echo $tindakan->getPemeriksaanRm()->daftartindakan_nama?></td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForUser($tindakan->tarif_satuan * $tindakan->qty_tindakan)?></td>
                </tr>
            <?php 
            }
            ?>
                </tbody>
                <tfoot>
                    <tr style="text-align: right;">
                        <td>Total</td>
                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForUser($total); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php } ?> 
    
    <?php if(isset($modKarcis) > 0){ ?>
        <div class="span4">
            <legend class="btn-info">Karcis</legend>
            <table class="table table-condensed table-bordered">
                <thead>
                    <th>Karcis</th>
                    <th>Tarif (Rp.)</th>
                </thead>
                <tbody>
            <?php 
            $total = 0;
            foreach($modKarcis AS $i=>$karcis){
                    $total += ($karcis->harga_tariftindakan);
            ?>
                    <tr>
                        <td><?php echo $karcis->karcis_nama?></td>
                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForUser($karcis->harga_tariftindakan)?></td>
                    </tr>
            <?php 
            }
            ?>
                </tbody>
                <tfoot>
                    <tr style="text-align: right;">
                        <td>Total</td>
                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForUser($total); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php } ?> 
</div>