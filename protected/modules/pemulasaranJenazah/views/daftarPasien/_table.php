<?php 
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarPasien-grid',
    'dataProvider' => $model->search(),
    //        'filter'=>$model,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
    'columns' => array(
        'tgl_pendaftaran',
        array(
            'header' => 'Tanggal Meninggal',
            'value' => '$data->getTanggalMeninggal()'
        ),
        'no_pendaftaran',
        'no_rekam_medik',
        array(
            'header' => 'Nama Pasien / Alias',
            'value' => '$data->namaPasienNamaBin'
        ),
        'caramasuk_nama',
        'instalasiasal_nama',
        'alamat_pasien',
        'carabayar_nama',
        'penjamin_nama',
        array(
            'header' => 'Tindakan & Pelayanan',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            'value' => 'CHtml::Link("<i class=\"icon-form-tindakan\"></i>",Yii::app()->controller->createUrl("TindakanPelayananTab/Index",array("pendaftaran_id"=>$data->pendaftaran_id,"instalasi_id"=>Params::INSTALASI_ID_RD,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),
                    array("class"=>"", 
                            "target"=>"",
                            "rel"=>"tooltip",
                            "title"=>"Klik untuk Tindakan & Pelayanan",
                    ))'
        ),
        array(
            'header' => 'Ambil Jenazah',
            'type' => 'raw',
            'value' => function ($data) {
                $bayar = PembayaranpelayananT::model()->findByAttributes(array(
                    'pendaftaran_id' => $data->pendaftaran_id,
                ));
                $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                    'pendaftaran_id' => $data->pendaftaran_id,
                ), array(
                    'condition' => 'tindakansudahbayar_id is null',
                ));
                $oa = ObatalkespasienT::model()->findByAttributes(array(
                    'pendaftaran_id' => $data->pendaftaran_id,
                ), array(
                    'condition' => 'oasudahbayar_id is null',
                ));
                if (empty($bayar) || !empty($tindakan) || !empty($oa)) {
                    return "BELUM BAYAR";
                }
                return (PJAmbiljenazahT::getStatusJenazah($data->pasien_id) > 0) ? "JENAZAH SUDAH DIAMBIL" : CHtml::Link(
                    "<i class=\"icon-form-ambiljenazah\"></i>",
                    Yii::app()->controller->createUrl("AmbilJenazah/Index", array("pendaftaran_id" => $data->pendaftaran_id, "instalasi_id" => Params::INSTALASI_ID_RD)),
                    array(
                        "class" => "",
                        "target" => "",
                        "rel" => "tooltip",
                        "title" => "Klik untuk Ambil Jenazah",
                    )
                );
            },
        ),
        array(
            'header' => 'Pemesanan Mobil Jenazah',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-pakaiambulans\"></i>",Yii::app()->controller->createUrl("pemesananAmbulansTPJ/index",array("pendaftaran_id"=>$data->pendaftaran_id)),
                    array("class"=>"", 
                            "target"=>"",
                            "rel"=>"tooltip",
                            "title"=>"Klik untuk Memesan Mobil Jenazah",
                    ))'
        ),
        array(
            'header' => 'Surat Ket. Meninggal',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            'value' => 'CHtml::Link("<i class=\"icon-form-skm\"></i>",Yii::app()->controller->createUrl("suratKeterangan/SuratKematian",array("pendaftaran_id"=>$data->pendaftaran_id,"instalasi_id"=>Params::INSTALASI_ID_RD)),
                    array("class"=>"", 
                            "target"=>"iframeCetakSurat",
                            "onclick"=>"$(\"#dialogCetakSurat\").dialog(\"open\");",
                            "rel"=>"tooltip",
                            "title"=>"Klik untuk membuat Surat Keterangan Kematian",
                    ))'
        ),
        array(
            'header' => 'Validasi JPA',
            'type' => 'raw',
            'value' => function($data) {

                $pulang = PasienpulangT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$data->pendaftaran_id,
                    'carakeluar_id'=>Params::CARAKELUAR_ID_MENINGGAL
                ));

                $linkPJA = CHtml::link(
                    '<i class="icon-form-detail"></i><br/>Validasi PJA', '#', array(
                        "id" => "$data->pendaftaran_id",
                        "rel" => "tooltip",
                        "title" => "Klik untuk Validasi PJA",
                        "onclick" => "verifikasiPJADialog(".$data->pendaftaran_id.", '".$pulang->pasienpulang_id."'); return false;",
                    )
                );


                $linkBatalPJA = CHtml::link(
                    '<i class="icon-form-silang"></i><br/>Batal PJA', '#', array(
                        "id" => "$data->pendaftaran_id",
                        "rel" => "tooltip",
                        "title" => "Klik untuk Batal Validasi PJA",
                        "onclick" => "batalPJA(".$data->pendaftaran_id.", '".$data->no_pendaftaran."', '".$pulang->pasienpulang_id."'); return false;",
                    )
                );

                

                $tindakan = TindakanpelayananT::model()->findByAttributes(array(
                    'pendaftaran_id'=>$data->pendaftaran_id,
                    'ruangan_id'=>Params::RUANGAN_ID_FORENSIC,
                    'ruangan_id_approvaltindaklanjut'=>Yii::app()->user->getState('ruangan_id'),
                ));

                $str = "";

                if (empty($tindakan)) {
                    $linkBatalPJANonTindakan = CHtml::link(
                        '<i class="icon-form-silang"></i><br/>Batal PJA', '#', array(
                            "id" => "$data->pendaftaran_id",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Batal Validasi PJA",
                            "onclick" => "batalPJANonTindakan(".$data->pendaftaran_id.", '".$data->no_pendaftaran."', '".$pulang->pasienpulang_id."'); return false;",
                        )
                    );
                    $linkPJA = CHtml::link(
                        '<i class="icon-form-detail"></i><br/>Validasi PJA', '#', array(
                            "id" => "$data->pendaftaran_id",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Validasi PJA",
                            "onclick" => 'verifikasiPJADialogNonTindakan('.$data->pendaftaran_id.', "'.$pulang->pasienpulang_id.'"); return false;',
                        )
                    );

                    $pegPJA = PegawaiM::model()->findByPk($pulang->userapprovaltindaklanjut_id);
                    $namapja = $pegPJA->namaLengkap ?? "Validasi PJA";
                    $tgl_verif = $pulang->tanggal_approvaltindaklanjut;

                    if (!empty($tgl_verif)) {
                        $namapja .= "<br/>".MyFormatter::formatDateTimeForUser($tgl_verif);
                    }

                    if (empty($pulang->isapprovaltindaklanjut) || $pulang->isapprovaltindaklanjut == false) {
                        $str .= $linkPJA;
                    } else {
                        $linkPJA = CHtml::link('<i class="icon-form-check"></i><br/>'.$namapja, '#', array(
                            'onclick'=>'return false',
                        ));
                        $str .= $linkPJA.$linkBatalPJANonTindakan;
                    }
                } else {
                    $tindakanPJABelum = TindakanpelayananT::model()->countByAttributes(array(
                        'pendaftaran_id'=>$data->pendaftaran_id,
                        'ruangan_id'=>Params::RUANGAN_ID_FORENSIC
                    ), array(
                        'condition'=>'isapprovaltindaklanjut = false or isapprovaltindaklanjut is null'
                    ));

                    if ($tindakanPJABelum == 0) {
                        $tindakanPJAVerif = TindakanpelayananT::model()->findByAttributes(array(
                            'pendaftaran_id'=>$data->pendaftaran_id,
                            'ruangan_id'=>Params::RUANGAN_ID_FORENSIC
                        ), array(
                            'condition'=>'isapprovaltindaklanjut = true'
                        ));

                        // cek apakah sudah di-verifikasi
                        // $crPJA->addCondition('verifikasitagihan_id is not null');
                        // $tindakanPJAVerif = TindakanpelayananT::model()->count($crPJA);

                        $pegPJA = PegawaiM::model()->findByPk($tindakanPJAVerif->userapprovaltindaklanjut_id);
                        $namapja = $pegPJA->namaLengkap ?? "Validasi PJA";
                        $tgl_verif = $tindakanPJAVerif->tanggal_approvaltindaklanjut;

                        if (!empty($tgl_verif)) {
                            $namapja .= "<br/>".MyFormatter::formatDateTimeForUser($tgl_verif);
                        }

                        $linkPJA = CHtml::link('<i class="icon-form-check"></i><br/>'.$namapja, '#', array(
                            'onclick'=>'return false',
                        ));

                        $linkPJA .= "<br/>".$linkBatalPJA;
                    }

                    $str .= $linkPJA;
                }

                return $str;
                

                
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
        ),
        array(
            'header' => 'Rincian Tagihan / Detail Rincian Tagihan',
            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
            'type' => 'raw',
            'value' => '
                        CHtml::link("<icon class=\'icon-form-detail\'></idcon>", Yii::app()->controller->createUrl("' . Yii::app()->controller->id . '/RincianTagihanPasien", array("pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');")).
                        CHtml::link("<icon class=\'icon-form-detailtagihan\'></idcon>", Yii::app()->controller->createUrl("' . Yii::app()->controller->id . '/RincianTagihanPasienDetail", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))', 'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Rincian Tagihan Sudah Bayar',
            'type' => 'raw',
            'value' => 'CHtml::link("<icon class=\'icon-form-detail\'></idcon>", Yii::app()->controller->createUrl("' . Yii::app()->controller->id . '/RincianPembayaranPasien", array("pendaftaran_id"=>$data->pendaftaran_id,"pembayaranpelayanan_id"=>$data->pembayaranpelayanan_id,"frame"=>true)), array("target"=>"frameRincianSudahBayar", "onclick"=>"$(\'#dialogRincianSudahBayar\').dialog(\'open\');"))',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Batal Periksa',
            'type' => 'raw',
            'value' => '($data->statusperiksahasil != Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:dialogBatalPeriksa(\'$data->pendaftaran_id\',\'$data->pasienmasukpenunjang_id\',\'$data->statusperiksa\',\'$data->nama_pasien\')",array("id"=>"$data->pendaftaran_id","rel"=>"tooltip","title"=>"Klik untuk membatalkan Pemeriksaan")) : null',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>

<?php echo $this->renderPartial('_dialogVerifikasiPJA', array(), true); ?>
<?php echo $this->renderPartial('_dialogVerifikasiPJANonTindakan', array(), true); ?>