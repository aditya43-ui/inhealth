<?php

$dpjp1 = "";
$dpjp2 = "";
$dpjp3 = "";
$dokterpenerima = "";




$arr_main = array(
    'jenispenjualan',
    'noresep',
    array(
        'name'=>'tglpelayanan',
        'value'=>MyFormatter::formatDateTimeForUser($modPenjualan->tglpelayanan),
    ),
    array(
        'name'=>'ruangan_nama',
        'label'=>'Poliklinik / Ruangan',
        'value'=>$modPenjualan->ruanganasal_nama,
    ),
    'penjamin_nama',
    'no_rekam_medik',
    'nama_pasien',
//                'nama_bin',
    'jeniskelamin',
    array(
        'name'=>'tanggal_lahir',
        'value'=>MyFormatter::formatDateTimeForUser($modPenjualan->tanggal_lahir),
    ),
//                'umur',
    'nama_pj',
//                array(
//                    'name'=>'pengantar',
//                    'label'=>'Status Penanggung Jawab',
//                    'value'=>$modPenjualan->pengantar,
//                ),
);

if (!empty($admisi)) {
    if (!empty($admisi->dokterpenerima_id)) {
        $pegawai = PegawaiM::model()->findByPk($admisi->dokterpenerima_id);
        $dokterpenerima = $pegawai->namaLengkap;
    }
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

    array_push($arr_main,
    array(
        'label'=>'Dokter Penerima',
        'value'=>$dokterpenerima,
    ),
    array(
        'label'=>'DPJP 1',
        'value'=>$dpjp1,
    ),
    array(
        'label'=>'DPJP 2',
        'value'=>$dpjp2,
    ),
    array(
        'label'=>'DPJP 3',
        'value'=>$dpjp3,
    ));
}

?>

<div class="row-fluid">
    <div class="col-sm-4">
        <div class="block-tabel">
            <h6>Data <b>Kunjungan</b></h6>
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$modPenjualan,
                'attributes'=>$arr_main,
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
                      'value'=>$modTandabukti->carapembayaran,
                  ),
                    array(
                        'name'=>'tglpembayaran',
                        'value'=>MyFormatter::formatDateTimeForUser($model->tglpembayaran),
                    ),
                    array(
                        'name'=>'totalbiayapelayanan',
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($model->totalbiayapelayanan,0).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('biayaadministrasi'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($modTandabukti->biayaadministrasi,0).'</div>',
                    ),
                    array(
                        'label'=>"Total Keringanan",
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($model->totaldiscount, 0).'</div>',
                    ),
                    array(
                        'label'=>'Total Tagihan',
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($modTandabukti->jmlpembayaran, 0).'</div>',
                    ),
                    array(
                        'label'=>'Total Subsidi Asuransi',
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($model->totalsubsidiasuransi, 0).'</div>',
                    ),
                    array(
                        'label'=>'Total Subsidi RS',
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($model->totalsubsidirs, 0).'</div>',
                    ),
                    array(
                        'label'=>$modPemakaianuangmuka->getAttributeLabel('pemakaianuangmuka'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($modPemakaianuangmuka->pemakaianuangmuka,0).'</div>',
                    ),
                    array(
                        'label'=>'Dibayar Oleh Pasien',
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($model->totaliurbiaya, 0).'</div>',
                    ),
                    array(
                        'label'=>'Jumlah Pembulatan',
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($modTandabukti->jmlpembulatan, 0,true).'</div>',
                    ),
                    // array(
                    //     'label'=>$modTandabukti->getAttributeLabel('biayamaterai'),
                    //     'type'=>'raw',
                    //     'value'=>'<div style="text-align:right;">'.MyFormatter::formatUang($modTandabukti->biayamaterai).'</div>',
                    // ),
                    // array(
                    //     'label'=>$modTandabukti->getAttributeLabel('jmlpembulatan'),
                    //     'type'=>'raw',
                    //     'value'=>'<div style="text-align:right;">'.MyFormatter::formatUang($modTandabukti->jmlpembulatan).'</div>',
                    // ),
                    // array(
                    //     'label'=>$modTandabukti->getAttributeLabel('jmlpembayaran'),
                    //     'type'=>'raw',
                    //     'value'=>'<div style="text-align:right;">'.MyFormatter::formatUang($modTandabukti->jmlpembayaran).'</div>',
                    // ),

                    array(
                        'label'=>$modTandabukti->getAttributeLabel('uangditerima'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($modTandabukti->uangditerima,0).'</div>',
                    ),
                    array(
                        'label'=>$modTandabukti->getAttributeLabel('uangkembalian'),
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint($modTandabukti->uangkembalian,0).'</div>',
                    ),
                    array(
                        'label'=>'Total Sisa Tagihan',
                        'type'=>'raw',
                        'value'=>'<div style="text-align:right;">Rp. '.MyFormatter::formatNumberForPrint((empty($model->totalsisatagihan) ? 0 : $model->totalsisatagihan),0).'</div>',
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

    <?php //if($modTandabukti->is_menggunakankartu){ ?>
        <!-- <div class="span4">
            <div class="block-tabel">
                <h6>Kartu <b>Pembayaran</b></h6>
                <?php //$this->widget('ext.bootstrap.widgets.BootDetailView',array(
                    // 'data'=>$modTandabukti,
                    // 'attributes'=>array(
                    //     'dengankartu',
                    //     'bankkartu',
                    //     'nokartu',
                    //     'nostrukkartu',
                    // ),
                //)); ?>
            </div>
        </div> -->
    <?php //} ?>

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
