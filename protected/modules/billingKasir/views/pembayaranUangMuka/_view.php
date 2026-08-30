<div class="row-fluid">
    <div class="col-sm-4">
        <div class="block-tabel">
            <h6>Data <b>Kunjungan</b></h6>
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$modKunjungan,
                'attributes'=>array(
					array(
						'label'=>'Instalasi',
						'name'=>'instalasi_nama',
					),
                    'no_pendaftaran',
                    array(
                        'name'=>'tgl_pendaftaran',
                        'value'=>MyFormatter::formatDateTimeForUser($modKunjungan->tgl_pendaftaran),
                    ),
                    array(
                        'name'=>'ruangan_nama',
                        'label'=>'Poliklinik / Ruangan',
                        'value'=>$modKunjungan->ruangan_nama,
                    ),
                    'kelaspelayanan_nama',
                    array(
						'label'=>'Jenis Kasus Penyakit',
						'name'=>'jeniskasuspenyakit_nama',
					),
					array(
						'label'=>'Penjamin',
						'name'=>'penjamin_nama',
					),
    //                'carabayar_nama',
                    'no_rekam_medik',
                    'nama_pasien',
    //                'nama_bin',
					array(
						'label'=>'Jenis Kelamin',
						'name'=>'jeniskelamin',
					),
                    array(
                        'name'=>'tanggal_lahir',
                        'value'=>MyFormatter::formatDateTimeForUser($modKunjungan->tanggal_lahir),
                    ),
    //                'umur',
					array(
						'label'=>'Penanggung Jawab',
						'name'=>'nama_pj',
					),
    //                array(
    //                    'name'=>'pengantar',
    //                    'label'=>'Status Penanggung Jawab',
    //                    'value'=>$modKunjungan->pengantar,
    //                ),
                ),
            )); ?>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="block-tabel">
            <h6>Data <b>Pembayaran</b></h6>
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$model,
                'attributes'=>array(
                    array(
                        'name'=>'tgluangmuka',
                        'value'=>$model->tgluangmuka,
                    ),
                    array(
                        'label'=>'Total Biaya Sementara',
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">'.MyFormatter::formatNumberForPrint($model->totbiayasementara,2).'</div>',
                    ),
                    array(
                        'name'=>'jumlahuangmuka',
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">'.MyFormatter::formatNumberForPrint($model->jumlahuangmuka,2).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('biayaadministrasi'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">'.MyFormatter::formatNumberForPrint($modTandabukti->biayaadministrasi,2).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('biayamaterai'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">'.MyFormatter::formatNumberForPrint($modTandabukti->biayamaterai,2).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('jmlpembulatan'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">'.MyFormatter::formatNumberForPrint($modTandabukti->jmlpembulatan,2,true).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('jmlpembayaran'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">'.MyFormatter::formatNumberForPrint($modTandabukti->jmlpembayaran,2).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('uangditerima'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">'.MyFormatter::formatNumberForPrint($modTandabukti->uangditerima,2).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('uangkembalian'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">'.MyFormatter::formatNumberForPrint($modTandabukti->uangkembalian,2).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('carapembayaran'),
                        'type'=>'raw',
                        'value'=>$modTandabukti->carapembayaran,
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('tglbuktibayar'),
                        'type'=>'raw',
                        'value'=>$modTandabukti->tglbuktibayar,
                    ),
                ),
            )); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="block-tabel">
            <h6>Tanda <b>Bukti Bayar</b></h6>
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$modTandabukti,
                'attributes'=>array(
                    'darinama_bkm',
                    'alamat_bkm',
                    'sebagaipembayaran_bkm',
                ),
            )); ?>
        </div>
    </div>

    <?php if(count((array)$modJenisPembayaran)>0){ ?>
        <div class="col-sm-4">
            <div class="block-tabel">
                <h6>Kartu <b>Pembayaran</b></h6>
                <?php

                  foreach($modJenisPembayaran as $jnspem){
                    $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                        'data'=>$jnspem,
                        'attributes'=>array(
                          array(
                              'label'=>'Pembayaran Ke-',
                              'type'=>'raw',
                              'value'=>$jnspem['bayarke'],
                          ),
                          array(
                              'label'=>'Jenis Pembayaran',
                              'type'=>'raw',
                              'value'=>$jnspem['jnspembayar_nama'],
                          ),
                          array(
                              'label'=>'Bank',
                              'type'=>'raw',
                              'value'=>$jnspem['bank_nama'],
                          ),
                          array(
                              'label'=>'Waktu Transaksi',
                              'type'=>'raw',
                              'value'=>$jnspem['tgltransaksi'],
                          ),
                          array(
                              'label'=>'Nominal',
                              'type'=>'raw',
                              'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($jnspem['nominal']).'</div>',
                          )
                        ),
                    ));
                  }
              ?>
            </div>
        </div>
    <?php } ?>

</div>
