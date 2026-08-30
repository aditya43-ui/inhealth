<?php

$dpjp1 = "";
$dpjp2 = "";
$dpjp3 = "";
$carabayarNama = "";
$modMasterCarapemb = LookupM::model()->findByAttributes(array('lookup_type'=> 'carapembayaran','lookup_value'=>$modTandabukti->carapembayaran));

if(isset($modMasterCarapemb)){
  $carabayarNama = $modMasterCarapemb->lookup_name;
}

if (!empty($admisi)) {
    if (!empty($admisi->pegawai_id)) {
        $pegawai = PegawaiM::model()->findByPk($admisi->pegawai_id);
        $dpjp1 = $pegawai->namaLengkap;
    }
    if (!empty($admisi->dpjp2_id)) {
        $pegawai = PegawaiM::model()->findByPk($admisi->dpjp2_id);
        $dpjp2 = $pegawai->namaLengkap;
    }
    if (!empty($admisi->dpjp3_id)) {
        $pegawai = PegawaiM::model()->findByPk($admisi->dpjp3_id);
        $dpjp3 = $pegawai->namaLengkap;
    }
}

?>

<div class="row-fluid">
    <div class="col-sm-4">
        <div class="block-tabel">
            <h6>Data <b>Kunjungan</b></h6>
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$modKunjungan,
                'attributes'=>array(
                    'instalasi_nama',
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
                    array(
                        'name'=>'kelaspelayanan_nama',
                        'label'=>'Kelas Pelayanan',
                    ),
                    array(
                        'name'=>'jeniskasuspenyakit_nama',
                        'label'=>'Jenis Kasus Penyakit',
                    ),
    //                'carabayar_nama',
                    'penjamin_nama',
                    'no_rekam_medik',
                    'nama_pasien',
    //                'nama_bin',
                    'jeniskelamin',
    //                array(
    //                    'name'=>'tanggal_lahir',
    //                    'value'=>MyFormatter::formatDateTimeForUser($modKunjungan->tgl_pendaftaran),
    //                ),
                    array(
                        'name'=>'tanggal_lahir',
                        'value'=>MyFormatter::formatDateTimeForUser($modKunjungan->tanggal_lahir),
                    ),
    //                'umur',
                    'nama_pj',
                    array(
                        'label'=>'DPJP 1',
                        'value'=>$dpjp1,
                        'visible'=>!empty($admisi),
                    ),
                    array(
                        'label'=>'DPJP 2',
                        'value'=>$dpjp2,
                        'visible'=>!empty($admisi),
                    ),
                    array(
                        'label'=>'DPJP 3',
                        'value'=>$dpjp3,
                        'visible'=>!empty($admisi),
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
                      'label'=>$modTandabukti->getAttributeLabel('carapembayaran'),
                      'type'=>'raw',
                      'value'=>$carabayarNama,
                  ),
                    array(
                        'name'=>'tglpembayaran',
                        'value'=>MyFormatter::formatDateTimeForUser($model->tglpembayaran),
                    ),
                    array(
                        'name'=>'totalbiayapelayanan',
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($model->totalbiayapelayanan).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('biayaadministrasi'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($modTandabukti->biayaadministrasi).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('biayamaterai'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($modTandabukti->biayamaterai).'</div>',
                    ),
                    array(
                        'label'=>"Total Keringanan",
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($model->totaldiscount).'</div>',
                    ), /*
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('jmlpembulatan'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">'.MyFormatter::formatUang($modTandabukti->jmlpembulatan).'</div>',
                    ), */
                    array(
                        'label'=>"Jasa Pelayanan Farmasi",
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($model->jasapelayanan_farmasi).'</div>',
                        'visible'=>(!empty($model->jasapelayanan_farmasi)? true: false),
                    ), 
                    array(
                        'label'=>'Total Tagihan',
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($modTandabukti->jmlpembayaran).'</div>',
                    ),
                    array(
                        'label'=>'Total INACBG / Asuransi',
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint((!empty($model->total_inacbg)? $model->total_inacbg : (!empty($model->totalsubsidiasuransi)?$model->totalsubsidiasuransi:0))).'</div>',
                    ),
                    array(
                        'label'=>'Total Tanggungan Rumah Sakit',
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($model->totalsubsidirs).'</div>',
                    ),
                    array(
                        'label'=>'Total Pembebasan',
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($model->totalpembebasan).'</div>',
                    ),
                    array(
                        'label'=>$modPemakaianuangmuka->getAttributeLabel('pemakaianuangmuka'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($modPemakaianuangmuka->pemakaianuangmuka).'</div>',
                    ),
                    array(
                        'label'=>'Dibayar Oleh Pasien',
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($model->totaliurbiaya).'</div>',
                    ),
                    array(
                        'label'=>'Jumlah Pembulatan',
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($modTandabukti->jmlpembulatan, 0,true).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('uangditerima'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($modTandabukti->uangditerima).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('uangkembalian'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($modTandabukti->uangkembalian).'</div>',
                    ),
                    array(
                        'label'=>'Total Sisa Tagihan',
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($model->totalsisatagihan).'</div>',
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
                <h6>Pembayaran <b>Non Tunai</b></h6>
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
                              'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($jnspem['nominal'], 2).'</div>',
                          )
                        ),
                    ));
                  }
              ?>
            </div>
        </div>
    <?php } ?>

</div>
