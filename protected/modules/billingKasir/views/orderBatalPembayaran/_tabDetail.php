<?php

$model = new BKInformasipasiensudahbayarV('searchInformasi');
$model->unsetAttributes();

if (isset($_GET['cariPasien']['pendaftaran_id'])) {
    $model->pendaftaran_id = $_GET['cariPasien']['pendaftaran_id'];
} else {
    $model->pendaftaran_id = -1;
}

$prov = $model->searchInformasi();
$prov->pagination = false;
$prov->criteria->join .= " left join orderbatalpembayaranpelayanan_t order_batal on order_batal.pembayaranpelayanan_id = t.pembayaranpelayanan_id";
$prov->criteria->addCondition("order_batal.pembayaranpelayanan_id is null");

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
    'id' => 'pencarianpasien-grid',
    'dataProvider' => $prov,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'mergeHeaders' => array(
        array(
            'name' => '<p style="margin: 0; text-align: center;">Jumlah Pembayaran</p>',
            'start' => 18, //indeks kolom 3
            'end' => 19, //indeks kolom 4
        ),
    ),
    'columns' => array(
        array(
            'header' => 'Order Batal Pembayaran Pelayanan',
            'type' => 'raw',
            'value' => function($data) {
                $dataPem = PembayaranpelayananT::model()->findByPk($data->pembayaranpelayanan_id);
                return 
                CHtml::checkBox('orderBatal['.$data->pembayaranpelayanan_id.'][ceklis]', false)
                .Chtml::hiddenField('orderBatal['.$data->pembayaranpelayanan_id.'][pendaftaran_id]', $dataPem->pendaftaran_id)
                .Chtml::hiddenField('orderBatal['.$data->pembayaranpelayanan_id.'][pasien_id]', $dataPem->pasien_id)
                .Chtml::hiddenField('orderBatal['.$data->pembayaranpelayanan_id.'][penjamin_id]', $dataPem->penjamin_id);
            },
            'htmlOptions' => array(
                'style'=>'text-align: center',
            ),
        ),
        array(
            'header' => 'Tanggal Pembayaran/<br>No. Pembayaran',
            'name' => 'tglbuktibayar',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpembayaran)."/<br>".$data->nopembayaran',
        ),
        array(
            'header' => 'Tanggal Pendaftaran/<br>No. Pendaftaran',
            'name' => 'tgl_pendaftaran',
            'type' => 'raw',
            'value' => 'isset($data->tgl_pendaftaran)?MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br>".$data->no_pendaftaran:null',
        ),
        array(
            'header' => 'Instalasi/<br> Ruangan',
            'type' => 'raw',
            'value' => '$data->instalasiakhir_nama."/<br>".$data->ruanganakhir_nama',
        ),
        array(
            'header' => 'Jenis Penjamin/<br>Penjamin',
            'name' => 'carabayar_nama',
            'type' => 'raw',
            'value' => function ($data) {
                $dataPem = PembayaranpelayananT::model()->findByPk($data->pembayaranpelayanan_id);
                return (isset($dataPem->carabayar)?$dataPem->carabayar->carabayar_nama:null)."/<br>".(isset($dataPem->penjamin) ? $dataPem->penjamin->penjamin_nama :null);
            }
            // 'value' => '(isset($data->carabayar_nama)?$data->carabayar_nama:null)."/<br>".(isset($data->penjamin_nama) ? $data->penjamin_nama :null)',
        ),
        array(
            'header' => 'Kelas Pelayanan',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->kelaspelayanan_nama . "<br>" . $data->kamarruangan_nokamar . " " . $data->kamarruangan_nobed;
            }
        ),
        array(
            'header' => 'Kelas Tanggungan',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->kelastanggungan_nama;
            }
        ),
        array(
            'header' => 'No. Rekam Medik',
            'type' => 'raw',
            'value' => '(isset($data->no_rekam_medik) ? $data->no_rekam_medik :null)',
        ),
        array(
            'name' => 'nama_pasien',
            'type' => 'raw',
            'value' => '$data->getNamaSapaan($data->no_rekam_medik)." ".$data->nama_pasien',
        ),
        array(
            'header' => 'Total Biaya Pelayanan <br>(Rp)',
            'name' => 'total_tagihan',
            'type' => 'raw',
            'value' => 'number_format($data->totalbiayapelayanan,2,",",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Biaya Administrasi <br>(Rp)',
            'type' => 'raw',
            'value' => function ($data) use (&$bukti) {
                $bukti = TandabuktibayarT::model()->findByAttributes(array(
                    'pembayaranpelayanan_id' => $data->pembayaranpelayanan_id
                ), array(
                    'order' => 'tandabuktibayar_id asc',
                ));
                if (empty($bukti)) return "0";
                return number_format($bukti->biayaadministrasi, 2, ",", ".");
            },
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Total Keringanan <br>(Rp)',
            'name' => 'discount',
            'type' => 'raw',
            'value' => 'number_format($data->totaldiscount,2,",",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Total Tagihan <br>(Rp)',
            'name' => 'jumlah_pembayaran',
            'type' => 'raw',
            'value' => function ($data) use (&$bukti) {
                if (!empty($bukti)) {
                    $total = $data->totalbiayapelayanan + $bukti->biayaadministrasi + $bukti->biayamaterai - $data->totaldiscount;
                } else {
                    $total = $data->totalbiayapelayanan - $data->totaldiscount;
                }
                return number_format($total, 2, ",", ".");
            },
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Total Tanggungan Asuransi <br>(Rp)',
            'name' => 'subsidi_asuransi',
            'type' => 'raw',
            'value' => 'number_format($data->totalsubsidiasuransi + $data->total_inacbg,2,",",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Total Tanggungan Rumah Sakit <br>(Rp)',
            'name' => 'subsidi_rs',
            'type' => 'raw',
            'value' => 'number_format($data->totalsubsidirs,2,",",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Total Pembebasan <br>(Rp)',
            'name' => 'totalpembebasan',
            'type' => 'raw',
            'value' => 'number_format($data->totalpembebasan,2,",",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Total Pemakaian Uang Muka <br>(Rp)',
            'type' => 'raw',
            'value' => function ($data) {
                $bayaruangmuka = PemakaianuangmukaT::model()->findByAttributes(array(
                    'pembayaranpelayanan_id' => $data->pembayaranpelayanan_id
                ));
                $jml_uangmuka = 0;
                if (!empty($bayaruangmuka)) :
                    $jml_uangmuka = $bayaruangmuka->pemakaianuangmuka;
                endif;
                return number_format($jml_uangmuka, 2, ",", ".");
            },
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Dibayar Oleh Pasien <br>(Rp)',
            'name' => 'iur_biaya',
            'type' => 'raw',
            // 'value' => function ($data) use (&$bukti) {
            //     if (!empty($bukti)) {
            //         $total = $data->totalbiayapelayanan + $bukti->biayaadministrasi + $bukti->biayamaterai - $data->totaldiscount;
            //     } else {
            //         $total = $data->totalbiayapelayanan - $data->totaldiscount;
            //     }
            //     return number_format($total, 2, ",", ".");
            // },
            'value' => 'number_format($data->totaliurbiaya,2,",",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Jumlah Pembulatan <br>(Rp)',
            'type' => 'raw',
            'value' => function ($data) use (&$bukti) {
                return ($bukti->jmlpembulatan < 0 ? "-" : "") . number_format(abs($bukti->jmlpembulatan), 2, ",", ".");
            },
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Tunai <br>(Rp)',
            'name' => 'jumlah_pembayaran',
            'type' => 'raw',
            // 'value' => function ($data) use (&$bukti) {
            //     if (!empty($bukti)) {
            //         $total = $data->totalbiayapelayanan + $bukti->biayaadministrasi + $bukti->biayamaterai - $data->totaldiscount;
            //     } else {
            //         $total = $data->totalbiayapelayanan - $data->totaldiscount;
            //     }
            //     return number_format($total, 2, ",", ".");
            // },
            'value' => function ($data) use (&$bukti) {
                // $total = $data->totalsubsidiasuransi + $data->totalsubsidirs + $data->totaliurbiaya;
                $total = $bukti->uangditerima - $bukti->uangkembalian;
                //if (empty($bukti)) return number_format($data->totalbayartindakan,0,"",".");
                // if ($bukti->jmlpembayaran == 0) return number_format($data->totalbayartindakan,0,"",".");
                return number_format($total, 2, ",", ".");
            },
            //'value'=>'number_format($data->jumlah_pembayaran,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Non Tunai <br>(Rp)',
            'name' => 'jumlah_pembayaran',
            'type' => 'raw',
            'value' => function ($data) use (&$bukti) {
                // $total = $data->totalsubsidiasuransi + $data->totalsubsidirs + $data->totaliurbiaya;
                $total = $bukti->bank_nominal;
                //if (empty($bukti)) return number_format($data->totalbayartindakan,0,"",".");
                // if ($bukti->jmlpembayaran == 0) return number_format($data->totalbayartindakan,0,"",".");
                return number_format($total, 2, ",", ".");
            },
            //'value'=>'number_format($data->jumlah_pembayaran,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'header' => 'Total Sisa Tagihan <br>(Rp)',
            'type' => 'raw',
            'value' => function ($data) {
                $det = PembayaranpelayananT::model()->findByPk($data->pembayaranpelayanan_id);
                return number_format($det->totalsisatagihan, 2, ",", ".");
            }
        ),
        array(
            'header' => 'Keterangan',
            'type' => 'raw',
            'value' => function ($data) {
                $det = PembayaranpelayananT::model()->findByPk($data->pembayaranpelayanan_id);
                return $det->keterangan;
            }
        ),
        /*
        array(
            'header' => 'Rincian Tagihan',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-rincianrs\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianSudahBayar2",array("pembayaranpelayanan_id"=>$data->pembayaranpelayanan_id, "frame"=>true)),
                                    array("class"=>"",
                                        "target"=>"iframeRincianTagihan",
                                        "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk melihat Rincian Tagihan",
                                    ))',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Rincian Farmasi',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-rtfarmasi\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianSudahBayarFarmasi",array("pembayaranpelayanan_id"=>$data->pembayaranpelayanan_id, "frame"=>true)),
                                    array("class"=>"",
                                        "target"=>"iframeRincianTagihan",
                                        "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk melihat Rincian Farmasi",
                                    ))',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Grup Rincian',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-rincianbayar\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianSudahBayarGrup",array("pembayaranpelayanan_id"=>$data->pembayaranpelayanan_id, "frame"=>true)),
                                    array("class"=>"",
                                        "target"=>"iframeRincianTagihan",
                                        "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk melihat Grup Rincian",
                                    ))',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'INVOICE',
            'type'=> 'raw',
            'value'=> function ($data) {
                return CHtml::link("<i class=\"icon-print\"></i>",'javascript:void(0);', array(
                    'onclick'=>"printRincianSudahBayar(". $data->pembayaranpelayanan_id .");return false",
                    'disabled'=>FALSE,
                    "rel"=>"tooltip",
                    "title"=>"Klik untuk melihat INVOICE Pembayaran",  ));
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 80px;'),  
        ),
        array(
            'header' => 'INV Casemix',
            'type'=> 'raw',
            'value'=> function ($data) {
                return CHtml::link("<i class=\"icon-form-rincian\"></i>",'javascript:void(0);', array(
                    'onclick'=>"printRincianSudahBayar2(". $data->pembayaranpelayanan_id .");return false",
                    'disabled'=>FALSE,
                    "rel"=>"tooltip",
                    "title"=>"Klik untuk melihat INVOICE Casemix",  ));
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 80px;'),  
        ),
        array(
            'header' => 'Print Kwitansi',
            'type'=> 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-print\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printKuitansi",array("pembayaranpelayanan_id"=>$data->pembayaranpelayanan_id, "frame"=>true)),
                        array("class"=>"",
                            "target"=>"iframeKwitansi",
                            "onclick"=>"$(\"#dialogKwitansi\").dialog(\"open\");",
                            "rel"=>"tooltip",
                            "title"=>"Klik untuk Print Kwitansi",
                        ))',
            'htmlOptions' => array('style' => 'text-align: center; width: 80px;'),  
        ),
        array(
            'header' => 'Status Closing',
            'type' => 'raw',
            'value' => '(isset($data->closingkasir_id) ? "SUDAH" :"BELUM")',
            'htmlOptions' => array('style' => 'text-align:left; width:40px'),
        ),
        array(
            'header' => 'Petugas Kasir',
            'type' => 'raw',
            // 'value'=>'$data->getNamaUsername($data->petugasadministrasi_id)',
            'value' => '$data->petugasadministrasi_nama',
            'htmlOptions' => array('style' => 'text-align:left; width:40px'),
        ),
        array(
            'header' => 'Ubah Pembayaran',
            'type' => 'raw',
            'value' => function ($data){
                if ($data->getCekBayar($data->tandabuktibayar_id)) {
                    return "SUDAH CLOSING";
                }
                $modPengajuandet = PengajuanklaimdetailT::model()->findByAttributes(array('pembayaranpelayanan_id' => $data->pembayaranpelayanan_id, 'tandabuktibayar_id' => $data->tandabuktibayar_id));
                if (isset($modPengajuandet)) {
                    return "SUDAH DILAKUKAN KLAIM";
                }
                $modAngsuran = BayarangsuranpelayananT::model()->findByAttributes(array('pembayaranpelayanan_id' => $data->pembayaranpelayanan_id, 'tandabuktibayar_id' => $data->tandabuktibayar_id));
                if (isset($modAngsuran)) {
                    return "SUDAH DILAKUKAN BAYAR ANGSURAN";
                }
                if($data->petugasadministrasi_id == Yii::app()->user->getState('pegawai_id')){
                    $html = CHtml::Link(
                        "<i class=\"icon-form-ubah\"></i>",
                        Yii::app()->controller->createUrl("PembayaranTagihanPasien/index",array('instalasi_id' => $data->instalasiakhir_id, 'pendaftaran_id' => $data->pendaftaran_id, 'pembayaranpelayanan_id' => $data->pembayaranpelayanan_id, 'tandabuktibayar_id' => $data->tandabuktibayar_id, 'ubah'=>true)),
                        array(
                            "class" => "",
                            "rel" => "tooltip",
                            "title" => "Klik untuk merubah pembayaran kasir",
                        )
                    );
                }else{
                   $html = "-";
                }

                $criteria = new CDbCriteria();
                $criteria->addCondition('ispenunjangmedis = true');
                $criteria->addCondition('instalasi_aktif = true');
                $criteria->addNotInCondition('instalasi_id',array(Params::INSTALASI_ID_FARMASI));
                $criteria->addCondition('instalasi_id = '. $data->instalasiakhir_id);
                $modInstPenunjang = InstalasiM::model()->find($criteria);

                if(!empty($modInstPenunjang)){
                    $html = CHtml::Link(
                        "<i class=\"icon-form-ubah\"></i>",
                        Yii::app()->controller->createUrl("PembayaranTagihanPasienPenunjang/index",array('instalasi_id' => $data->instalasiakhir_id, 'pendaftaran_id' => $data->pendaftaran_id, 'pembayaranpelayanan_id' => $data->pembayaranpelayanan_id, 'tandabuktibayar_id' => $data->tandabuktibayar_id, 'ubah'=>true)),
                        array(
                            "class" => "",
                            "rel" => "tooltip",
                            "title" => "Klik untuk merubah pembayaran kasir Penunjang",
                        )
                    ); 
                }else if($data->instalasiakhir_id == Params::INSTALASI_ID_FARMASI) {
                    // $html = "-";
                    $html = CHtml::Link(
                        "<i class=\"icon-form-ubah\"></i>",
                        Yii::app()->controller->createUrl("PembayaranTagihanPasienPenunjang/index",array('instalasi_id' => $data->instalasiakhir_id, 'pendaftaran_id' => $data->pendaftaran_id, 'pembayaranpelayanan_id' => $data->pembayaranpelayanan_id, 'tandabuktibayar_id' => $data->tandabuktibayar_id, 'ubah'=>true)),
                        array(
                            "class" => "",
                            "rel" => "tooltip",
                            "title" => "Klik untuk merubah pembayaran kasir Penunjang",
                        )
                    ); 
                }

                return $html; 
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            //'header'=>'Batal Pembayaran',
            'header' => 'Pembatalan',
            'type' => 'raw',
            // 'value'=>'isset($data->closingkasir_id)?"Sudah Bayar":CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:batalBayar($data->tandabuktibayar_id,$data->pembayaranpelayanan_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Membatalkan Pembayaran"))',
            //  'value'=>'isset($model->getCekBayar($data->tandabuktibayar_id))?"Sudah Bayar":CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:batalBayar($data->tandabuktibayar_id,$data->pembayaranpelayanan_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Membatalkan Pembayaran"))',
            'value' => function ($data) {
                if(Yii::app()->user->id == 1){
                    // var_dump(Yii::app()->user->id);die;
                    if ($data->getCekBayar($data->tandabuktibayar_id)) {
                        return "SUDAH CLOSING";
                    }
                    $modPengajuandet = PengajuanklaimdetailT::model()->findByAttributes(array('pembayaranpelayanan_id' => $data->pembayaranpelayanan_id, 'tandabuktibayar_id' => $data->tandabuktibayar_id));
                    if (isset($modPengajuandet)) {
                        return "SUDAH DILAKUKAN KLAIM";
                    }
                    $modAngsuran = BayarangsuranpelayananT::model()->findByAttributes(array('pembayaranpelayanan_id' => $data->pembayaranpelayanan_id, 'tandabuktibayar_id' => $data->tandabuktibayar_id));
                    if (isset($modAngsuran)) {
                        return "SUDAH DILAKUKAN BAYAR ANGSURAN";
                    }
                    return CHtml::link(
                        "<i class='icon-form-silang'></i>",
                        "javascript:batalBayar($data->tandabuktibayar_id,$data->pembayaranpelayanan_id)",
                        array(
                            "id" => $data->no_pendaftaran,
                            "rel" => "tooltip",
                            "title" => "Klik untuk membatalkan",
                        )
                    );
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        */
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));


?>