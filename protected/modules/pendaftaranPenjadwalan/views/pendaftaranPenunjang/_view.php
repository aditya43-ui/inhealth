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
                    //                 array(
                    //     'name'=>'pegawai.nomorindukpegawai',
                    //     'label'=>'NIP Penanggung Jawab'
                    // ),
                    //                 array(
                    //     'name'=>'pegawai.NamaLengkap',
                    //     'label'=>'Nama Penanggung Jawab'
                    // ),
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
                        'name'=>'carabayar_id',
                        'value'=>$model->carabayar->carabayar_nama,
                    ),
                    array(
                        'name'=>'penjamin_id',
                        'value'=>$model->penjamin->penjamin_nama,
                    ),
                    array(
                        'name'=>'keadaanmasuk',
                        'value'=>$model->keadaanmasuk,
                    ),
                    array(
                        'name'=>'transportasi',
                        'value'=>$model->transportasi,
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
    <?php if(count((array)$modPasienMasukPenunjangs) > 0){ ?>
        <div class="col-sm-4">
            <div class="block-tabel">
                <h6><b>Karcis</b></h6>
                <table class="table table-striped table-condensed detail-view">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Instalasi Tujuan</th>
                            <th>Ruangan Tujuan</th>
                            <th>Kelas Pelayanan / Dokter</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                        foreach($modPasienMasukPenunjangs AS $i => $modPasienMasukPenunjang){

                            echo "<tr>";
                            echo "<td>".($i+1)."</td>";
                            echo "<td>".$modPasienMasukPenunjang['ruangan']->instalasi->instalasi_nama."</td>";
                            echo "<td>".$modPasienMasukPenunjang['ruangan']->ruangan_nama."</td>";
                            echo "<td>".$modPasienMasukPenunjang['kelaspelayanan']->kelaspelayanan_nama." /"
                                    .(!empty($modPasienMasukPenunjang['pegawai'])? $modPasienMasukPenunjang['pegawai']->namaLengkap : "")."</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>    
    <?php if(count((array)$modKarcis) > 0){ ?>
        <div class="col-sm-4">
            <div class="block-tabel">
                <h6><b>Karcis</b></h6>
                <table class="table table-striped table-condensed detail-view">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Deskripsi</th>
                            <th>Tarif</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php  
                    foreach($modKarcis AS $ii => $karcis){
                        echo "<tr>";
                        echo "<td>".($ii+1)."</td>";
                        echo "<td>".$karcis->daftartindakan_nama."</td>";
                        echo "<td>".MyFormatter::formatNumberForPrint($karcis->harga_tariftindakan)."</td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>    
</div>