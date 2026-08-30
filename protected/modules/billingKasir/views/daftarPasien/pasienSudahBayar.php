<?php
$this->breadcrumbs = array(
    'Daftar Pasien' => array('/billingKasir/daftarPasien'),
    'PasienKarcis',
); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'caripasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#BKPembayaranpelayananT_no_rekam_medik',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
Yii::app()->clientScript->registerScript('cariPasien', "
    $('#caripasien-form').submit(function(){
            $.fn.yiiGridView.update('pencarianpasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Informasi <b>Pasien Sudah Bayar</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial('_formKriteriaPencarianBkm', array('model' => $model, 'form' => $form), true); ?>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    ); ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    );
                    ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Sudah Bayar</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                    'id' => 'pencarianpasien-grid',
                    'dataProvider' => $model->searchInformasi(),
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
                            'value' => function ($data) use (&$det) {
                                $det = PembayaranpelayananT::model()->findByPk($data->pembayaranpelayanan_id);
                                return number_format($det->totalsisatagihan, 2, ",", ".");
                            }
                        ),
                        array(
                            'header' => 'Keterangan',
                            'type' => 'raw',
                            'value' => function ($data) use (&$det) {
                                //$det = PembayaranpelayananT::model()->findByPk($data->pembayaranpelayanan_id);
                                return $det->keterangan;
                            }
                        ),
                        array(
                            'header' => 'Rincian Tagihan',
                            'type' => 'raw',
                            'value' => function($data) {
                                return CHtml::Link('<i class="icon-form-rincianrs"></i>',Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayar", array("instalasi_id" => $data->instalasi_id, "pendaftaran_id" => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id, "frame" => true, "is_rsb"=>true)),
                                                    array("class"=>"",
                                                        "target"=>"iframeRincianTagihanSementara",
                                                        "onclick"=>"$('#dialogRincianTagihanSementara').dialog('open');",
                                                        "rel"=>"tooltip",
                                                        "title"=>"Klik untuk melihat Rincian Tagihan Sementara",
                                ));
                            },
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
                            'header' => 'Rincian Pembayaran',
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

                                return CHtml::Link("<i class=\"icon-print\"></i>",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianSudahBayar2",array("pembayaranpelayanan_id"=>$data->pembayaranpelayanan_id, "frame"=>true)),
                                array("class"=>"",
                                    "target"=>"iframeRincianTagihan",
                                    "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                    "rel"=>"tooltip",
                                    "title"=>"Klik untuk melihat INVOICE Pembayaran",
                                ));

                                /*
                                return CHtml::link("<i class=\"icon-print\"></i>",'javascript:void(0);', array(
                                    'onclick'=>"printRincianSudahBayar(". $data->pembayaranpelayanan_id .");return false",
                                    'disabled'=>FALSE,
                                    "rel"=>"tooltip",
                                    "title"=>"Klik untuk melihat INVOICE Pembayaran",  ));
                                */
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 80px;'),  
                        ),
                        /*
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
                        */
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
                            'header' => 'Pernyataan Piutang',
                            'type'=> 'raw',
                            'value' => function($data) use (&$det) {

                                if ($det->penjamin_id != Params::PENJAMIN_ID_MANDIRI_PIUTANG) {
                                    return "";
                                }

                                return CHtml::Link('<i class="icon-form-print"></i>',Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasienPenjamin/printBayarPiutang",array("id"=>$data->pembayaranpelayanan_id)),
                                        array("class"=>"",
                                            "target"=>"iframePenyataanPiutang",
                                            "onclick"=>"$('#dialogPenyataanPiutang').dialog('open');",
                                            "rel"=>"tooltip",
                                            "title"=>"Klik untuk Print Kwitansi",
                                ));
                            },
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
                        /*
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
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRetur',
    'options' => array(
        'title' => 'Retur Tagihan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => true,
        'close' => 'js:function(event, ui) {'
            .
            '$.fn.yiiGridView.update("pencarianpasien-grid", {
            data: $("#caripasien-form").serialize()
        });'
            . '}',
    ),
));
?>
<iframe src="" name="iframePembayaran" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogKwitansi',
    'options' => array(
        'title' => 'Kuitansi Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeKwitansi" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPenyataanPiutang',
    'options' => array(
        'title' => 'Pernyataan Piutang Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframePenyataanPiutang" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetPembayaran',
    'options' => array(
        'title' => 'Detail Pembayaran',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 610,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeDetPembayaran" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincianTagihan',
    'options' => array(
        'title' => 'Rincian Tagihan',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1024,
        'height' => 520,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRincianTagihanSementara',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Rincian Tagihan Sementara</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 570,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
            data: $('#caripasien-form').serialize()
        }); }",
    ),
));
?>
<iframe name='iframeRincianTagihanSementara' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'loginDialog',
    'options' => array(
        'title' => 'Login',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 190,
        'resizable' => false,
    ),
)); ?>
<?php echo CHtml::beginForm('', 'POST', array('class' => 'form-horizontal', 'id' => 'formLogin')); ?>
<div class="control-group">
    <?php echo CHtml::label('Login Pemakai', 'username', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::textField('username', '', array()); ?>
        <?php echo CHtml::hiddenField('tandabuktibayar_id', '', array()); ?>
        <?php echo CHtml::hiddenField('pembayaranpelayanan_id', '', array()); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Password', 'password', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php echo CHtml::passwordField('password', '', array()); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Login', array('{icon}' => '<i class="icon-lock icon-white"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'cekLogin();return false;')
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), '#', array('class' => 'btn btn-default', 'onclick' => "$('#loginDialog').dialog('close');return false", 'disabled' => false)); ?>
</div>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    function notifKwitansi(cekPrint, pendaftaranid) {
        if (cekPrint >= 1) {
            $.ajax({
                type: 'POST',
                'url': '<?php echo $this->createUrl('/ActionAjax/DataRincian') ?>',
                'data': {
                    pendaftaranid: pendaftaranid
                },
                dataType: "json",
                success: function(data) {
                    if (data.hasil == "BERHASIL") {
                        myConfirm(" Kuitansi Sebelumnya Sudah Dicetak Oleh:\n\
                                            <?php
                                            /*       $rincian = getRincianCetak($pendaftaran_id);
                                                echo "<table>";
                                                echo "<tr>";
                                                echo "<td>Nama</td>";echo "<td>:</td>";echo "<td>data dimari</td>";
                                                echo "</tr>";
                                                echo "<tr>";
                                                echo "<td>Tanggal Dicetak</td>";echo "<td>:</td>";echo "<td>data dimari</td>";
                                                echo "</tr>";
                                                echo "<tr>";
                                                echo "<td>Ruangan</td>";echo "<td>:</td>";echo "<td>data dimari</td>";
                                                echo "</tr>";
                                                echo "</table>"*/
                                            ?> Apakah Anda ingin mencetak lagi?", " Perhatian!", function(r) {
                            if (r) {
                                $("#dialogKwitansi").dialog("open");
                            }
                        });
                    } else {
                        myConfirm(" Kuitansi Sebelumnya Sudah Dicetak Oleh:\n\
                                                        Nama : " + data.nama + "\n\
                                                        Tanggal Cetak : " + data.tanggal + "\n\
                                                        Ruangan : " + data.ruangan + "\n\
                                                        \n\
                                                        Apakah Anda ingin mencetak lagi?", " Perhatian!", function(r) {
                            if (r) {
                                $("#dialogKwitansi").dialog("open");
                            }
                        });
                    }
                },
            });
        } else {
            $("#dialogKwitansi").dialog("open");
        }
    }

    function batalBayar(tandabuktibayar_id, pembayaranpelayanan_id) {
        myConfirm("Anda akan <b>membatalkan tagihan pasien dan jurnalnya</b>. Apakah Anda yakin akan melanjutkan?", "Perhatian!", function(r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    'url': '<?php echo $this->createUrl('BatalBayar') ?>',
                    'data': {
                        tandabuktibayar_id: tandabuktibayar_id,
                        pembayaranpelayanan_id: pembayaranpelayanan_id
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.hasil == "BERHASIL") {
                            $.fn.yiiGridView.update('pencarianpasien-grid', {
                                data: $(this).serialize()
                            });
                        } else {
                            myAlert(data.hasil);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        });
    }

    function cekLogin() {
        $.post('<?php echo $this->createUrl('CekLoginBatalBayar', array('task' => 'BatalBayar')); ?>', $('#formLogin').serialize(), function(data) {
            if (data.error != '')
                myAlert(data.error);
            $('#' + data.cssError).addClass('error');
            if (data.status == 'success') {
                var idTandabuktibayar = $('#tandabuktibayar_id').val();
                var idPembayaranpelayanan = $('#pembayaranpelayanan_id').val();
                jQuery.ajax({
                    'url': '<?php echo Yii::app()->createUrl('billingKasir/ActionAjax/BatalBayar') ?>',
                    'data': {
                        idTandabuktibayar: idTandabuktibayar,
                        idPembayaranpelayanan: idPembayaranpelayanan
                    },
                    'type': 'post',
                    'dataType': 'json',
                    'success': function(data) {
                        // myAlert(data);
                        if (data.hasil == 'GAGAL') {
                            myAlert('Pembatalan pembayaran gagal, data sudah di Closing.');
                        } else {
                            myAlert('Pembatalan pembayaran sudah dilakukan');
                            // reloadTable();
                            $.fn.yiiGridView.update('pencarianpasien-grid', {});
                        }
                    },
                    'cache': false
                });
                $('#loginDialog').dialog('close');
                return true;
            } else {
                myAlert(data.status);
            }
        }, 'json');
    }
    function printRincianSudahBayar(id)
    {
        
        window.open("<?php echo $this->createUrl('/billingKasir/PembayaranTagihanPasien/printRincianSudahBayar2') ?>&pembayaranpelayanan_id="+id,"",'location=_new, width=1024px');
    }
    function printRincianSudahBayar2(id)
    {
        
        window.open("<?php echo $this->createUrl('/billingKasir/PembayaranTagihanPasien/cetakGabung') ?>&pembayaranpelayanan_id="+id,"",'location=_new, width=1024px');
    }
</script>