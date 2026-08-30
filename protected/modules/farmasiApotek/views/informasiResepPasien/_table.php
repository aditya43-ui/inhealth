<?php 
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'informasipenjualanresep-grid',
    'dataProvider' => $modInfoPenjualan->searchInfoResepPasien(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'replaceUrl' => true,
    'columns' => array(
        array(
            'name' => 'noantrian',
            'header' => 'No. Antrian/<br>Panggil Antrian',
            'type' => 'raw',
            'value' => function ($data) {
                if (empty($data->noantrian)) {
                    return "Tanpa Antrian";
                }
                $antrian = AntrianfarmasiT::model()->findByPk($data->antrianfarmasi_id);
                $modelLoket = ModelantrianM::model()->findByPk(array(
                    $antrian->modelantrian_id
                ));
                $str = $data->racikanantrian_singkatan . "-" . $antrian->noantrian . '<br>';
                if (!empty($modelLoket)) {
                    $str = $modelLoket->modelantrian_kode . $str;
                }
                if ($data->panggilantrian && $antrian->jumlah_panggil == 10) {
                    return $str . "Sudah Dipanggil";
                }
                return CHtml::htmlButton(Yii::t("mds", "{icon}", array("{icon}" => '<i class="icon-volume-up icon-white"></i>')), array(
                    "class" => "btn btn-primary",
                    "onclick" => 'panggilAntrian("' . $data->penjualanresep_id . '","' . $data->antrianfarmasi_id . '")', "rel" => "tooltip", "title" => "Klik untuk memanggil pasien ini"
                ));
            }
        ),
        /*
                array(
                    'header'=>'Tanggal Penjualan',
                    'type'=>'raw',
                    'value'=>'$data->tglpenjualan',
                ),
                */
        array(
            'header' => 'Tanggal Penjualan/<br>No Penjualan',
            'type' => 'raw',
            'value' => '$data->tglpenjualan."/<br>".$data->noresep',
        ),
        array(
            'header' => 'No. Rekam Medik',
            'type' => 'raw',
            'value' => '$data->no_rekam_medik',
        ),
        array(
            'header' => 'Nama Pasien',
            'type' => 'raw',
            'value'=>function ($data){
                echo CHtml::link(
                    "<b>".$data->namadepan . $data->nama_pasien. "</b>",
                    Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/getRiwayatPasien", array("id" => $data->pasien_id)),
                    array(
                        "rel" => "tooltip",
                        "title" => "Klik untuk melihat riwayat pemeriksaan pasien",
                        "target" => "frameRiwayatPasien",
                        "onclick" => "$('#dialogRiwayatPasien').dialog('open');"
                    )
                );
            },
        ),
        array(
            'header' => 'Umur/<br>Jenis Kelamin',
            'type' => 'raw',
            'value' => '"$data->umur"."<br>"."$data->jeniskelamin"',
        ),
        array(
            'header' => 'Alamat',
            'type' => 'raw',
            'value' => '$data->alamat_pasien',
        ),
        array(
            'header' => 'Jenis Penjamin/ <br>Penjamin',
            'type' => 'raw',
            'value' => '$data->carabayar_nama."/<br>".$data->penjamin_nama',
        ),
        array(
            'header' => 'Ruangan',
            'type' => 'raw',
            'value' => function ($data) use (&$p) {
                $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                //return !empty($p)?$p->ruangan->ruangan_nama:"-";
                $ruang = PenjualanresepT::model()->findByPk($data->penjualanresep_id);
                if (!empty($ruang)) {
                    return $ruang->ruanganasal_nama;
                }
            }, //'$data->ruanganasal_nama',
        ),
        array(
            'header' => 'Kamar/<br>Bed/<br>Kelas Pelayanan',
            'type' => 'raw',
            'value' => function ($data){
                $kelas = KelaspelayananM::model()->findByPk(['kelaspelayanan_id'=>$data->kelaspelayanan_id]);
                $kelas = !empty($kelas->kelaspelayanan_nama) ? $kelas->kelaspelayanan_nama : "-";
                return $data->kamarruangan_nokamar." / ".$data->kamarruangan_nobed." / ".$kelas;
            }
        ),
        array(
            'header' => 'Dokter',
            'type' => 'raw',
            'value' => '($data->jenispenjualan == "PENJUALAN BEBAS" OR $data->nama_pegawai == "Eli Hismiati") ? "-" : $data->NamaDokter',
        ),
        array(
            'header' => 'Status Periksa',
            'type' => 'raw',
            'value' => function ($data) use (&$p) {
                return !empty($p) ?  Params::getWrStatusPeriksa($p->statusperiksa) : "-";
            },
        ),
        array(
            'header' => 'Catatan Pemberian Obat',
            'value' => function ($data) {
                if($data->instalasiasal_nama=='Rawat Inap'){
                    if(!empty($data->penjualanresep_id)){
                        // echo CHtml::link('<a rel="tooltip" title="Tidak dapat diubah karena sudah diketahui oleh Manager Keuangan"><icon class="icon-form-ubah" style="opacity: 0.3"></icon></a> ');
                        echo CHtml::link('<icon class=\'icon-form-ubah\'></icon> ',  Yii::app()->controller->createUrl("informasiPasienResep/create",array("pendaftaran_id"=>$data->pendaftaran_id)),array("rel"=>"tooltip","title"=>"Klik untuk Mengubah Catatan", "return false;"));
                    }else{
                        echo CHtml::link('<icon class=\'icon-form-ubah\'></icon> ',  Yii::app()->controller->createUrl("informasiPasienResep/create",array("pendaftaran_id"=>$data->pendaftaran_id)),array("rel"=>"tooltip","title"=>"Klik untuk Mengubah Catatan", "return false;"));
                    }
                }else{
                    echo 'Bukan Pasien Rawat Inap';
                }
        }),
        array(
            'header' => 'Riwayat Obat',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::link('<i class="icon-form-reseptur"></i>', Yii::app()->controller->createUrl('riwayatObat', array('id'=>$data->pendaftaran_id)), array(
                    'target'=>'frameRiwayatObat',
                    'onclick'=>"$('#dialogRiwayatObat').dialog('open');",
                ));
            },
            'htmlOptions' => array(
                "nowrap" => "",
                'style' => 'text-align: center;',
            )
        ),
        array(
            'header' => 'Reseptur Dokter',
            'type' => 'raw',
            'value' => function ($data) use (&$ada_racikan, &$ada_nonracikan) {
                $link = array();
                $ada_racikan = false;
                $ada_nonracikan = false;
                $racikan = ResepturdetailT::model()->findByAttributes(array(
                    'reseptur_id' => $data->reseptur_id,
                    'racikan_id' => Params::RACIKAN_ID_RACIKAN,
                ));
                $nonRacikan = ResepturdetailT::model()->findByAttributes(array(
                    'reseptur_id' => $data->reseptur_id,
                    'racikan_id' => Params::RACIKAN_ID_NONRACIKAN,
                ));
                if (!empty($racikan)) {
                    $ada_racikan = true;
                    $link[] = CHtml::Link(
                        '<i class="icon-form-reseptur"></i><br>Racikan',
                        Yii::app()->createUrl("farmasiApotek/InformasiPasienResep/printResepDokter", array("id" => $data->reseptur_id, "racikan_id" => Params::RACIKAN_ID_RACIKAN, "frame" => 1)),
                        array(
                            "class" => "",
                            "target" => "iframeReseptur",
                            "onclick" => "$(\"#dialogReseptur\").dialog(\"open\");",
                            "rel" => "tooltip",
                            "title" => "Klik untuk print reseptur dokter (Racikan)",
                        )
                    );
                }
                if (!empty($nonRacikan)) {
                    $ada_nonracikan = true;
                    $link[] = CHtml::Link(
                        '<i class="icon-form-reseptur"></i><br>Non Racikan',
                        Yii::app()->createUrl("farmasiApotek/InformasiPasienResep/printResepDokter", array("id" => $data->reseptur_id, "racikan_id" => Params::RACIKAN_ID_NONRACIKAN, "frame" => 1)),
                        array(
                            "class" => "",
                            "target" => "iframeReseptur",
                            "onclick" => "$(\"#dialogReseptur\").dialog(\"open\");",
                            "rel" => "tooltip",
                            "title" => "Klik untuk print reseptur dokter (Non Racikan)",
                        )
                    );
                }
                return implode("<br>", $link);
            },
            'htmlOptions' => array(
                "nowrap" => "",
                'style' => 'text-align: center;',
            )
        ),
        array(
            'header' => 'Reseptur Penjualan',
            'type' => 'raw',
            'value' => function ($data){
                // $ada_racikan = false;
                // $ada_nonracikan = false;
                // $racikan = ObatalkespasienT::model()->findByAttributes(array(
                //     'penjualanresep_id' => $data->penjualanresep_id,
                //     // 'racikan_id' => Params::RACIKAN_ID_RACIKAN,
                // ));
                // $nonRacikan = ObatalkespasienT::model()->findByAttributes(array(
                //     'penjualanresep_id' => $data->penjualanresep_id,
                //     // 'racikan_id' => Params::RACIKAN_ID_NONRACIKAN,
                // ));
                if(!empty($data->penjualanresep_id) && !empty($data->reseptur_id)){
                    // if (!empty($racikan)) {
                        // $ada_racikan = true;
                    return CHtml::Link(
                        '<i class="icon-form-reseptur"></i><br>',
                        Yii::app()->createUrl("farmasiApotek/InformasiPasienResep/PrintResepPenjualan", array("penjualanresep_id" => $data->penjualanresep_id, "frame" => 1)),
                        array(
                            "class" => "",
                            "target" => "iframeResepturPenjualan",
                            "onclick" => "$(\"#dialogResepturPenjualan\").dialog(\"open\");",
                            "rel" => "tooltip",
                            "title" => "Klik untuk print reseptur penjualan (Racikan)",
                        )
                    );
                }else{
                    return "-";
                }
            }
        ),
        array(
            'header' => 'Etiket',
            'type' => 'raw',
            'value' => function ($data) {

                $racikan = ObatalkespasienT::model()->findByAttributes(array(
                    'penjualanresep_id' => $data->penjualanresep_id,
                    'racikan_id' => Params::RACIKAN_ID_RACIKAN,
                ));
                $nonRacikan = ObatalkespasienT::model()->findByAttributes(array(
                    'penjualanresep_id' => $data->penjualanresep_id,
                    'racikan_id' => Params::RACIKAN_ID_NONRACIKAN,
                ));

                $str = array();

                if (!empty($racikan)) {
                    $str[] = CHtml::link('<i class="icon-form-print"></i><br>Racikan', Yii::app()->createUrl('/farmasiApotek/penjualanDariReseptur/printEtiket', array(
                        'penjualanresep_id' => $data->penjualanresep_id, 
                        'racikan' => Params::RACIKAN_ID_RACIKAN
                    )), array(
                        'target' => 'frameEtiket',
                        'onclick' => "$('#dialogEtiket').dialog('open');"
                    ));
                }
                if (!empty($nonRacikan)) {
                    $str[] = CHtml::link('<i class="icon-form-print"></i><br>Non Racikan', Yii::app()->createUrl('/farmasiApotek/penjualanDariReseptur/printEtiket', array(
                        'penjualanresep_id' => $data->penjualanresep_id, 
                        'racikan' => Params::RACIKAN_ID_NONRACIKAN
                    )), array(
                        'target' => 'frameEtiket',
                        'onclick' => "$('#dialogEtiket').dialog('open');"
                    ));
                }
                // $str[] .= "<br/>".CHtml::Link('<i class="icon-form-ubah"></i>',Yii::app()->createUrl("/farmasiApotek/informasiPenjualanResep/ubahPenjualanResep", array(
                //     "idPenjualan"=>$data->penjualanresep_id,
                // )),
                // array(
                //     "title"=>"Klik untuk Ubah Penjualan",
                //     "data-placement"=>"left"
                // ));

                return implode("<br/>", $str);
            },
            'htmlOptions' => array('style' => 'text-align: center; width:60px')
        ),
        array(
            'header' => 'Tagihan Pasien',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            'value' => function($data) {
                $oa = ObatalkespasienT::model()->findByAttributes(array(
                    'penjualanresep_id'=>$data->penjualanresep_id,
                ), array(
                    'condition'=>'oasudahbayar_id is not null',
                ));

                if (empty($oa)) {
                    return "";
                }

                $sb = OasudahbayarT::model()->findByPk($oa->oasudahbayar_id);

                return CHtml::Link('<i class="icon-form-rincianrs"></i>',Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianSudahBayar2",array("pembayaranpelayanan_id"=>$sb->pembayaranpelayanan_id, "frame"=>true)),
                array("class"=>"",
                    "target"=>"iframeRincianTagihan",
                    "onclick"=>'$("#dialogRincianTagihan").dialog("open");',
                    "rel"=>"tooltip",
                    "title"=>"Klik untuk melihat Rincian Tagihan",
                ));
            },
        ),
        array(
            'header' => 'Detail Penjualan Resep',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            'value' => 'CHtml::Link("<i class=\"icon-form-rincianjual\"></i>",Yii::app()->controller->createUrl("informasiPenjualanResep/detailPenjualan",array("id"=>$data->penjualanresep_id , "pasien_id"=>$data->pasien_id)),
                        array("class"=>"",
                            "target"=>"iframePasienResep",
                            "onclick"=>"$(\"#dialogDetailPenjualan\").dialog(\"open\");",
                            "rel"=>"tooltip",
                            "title"=>"Klik untuk lihat detail penjualan",
                        ))',
        ),
        array(
            'header' => 'Retur Stok',
            'type' => 'raw',
            'value' => function ($data) {
                $str = "";
                $retur = FAReturresepT::model()->findAllByAttributes(array(
                    'penjualanresep_id' => $data->penjualanresep_id,
                ), array(
                    'order' => 'returresep_id asc',
                ));
                foreach ($retur as $item) {
                    $str .= CHtml::link(
                        '<u>' . MyFormatter::formatDateTimeForUser($item->tglretur) . '<br>' . $item->noreturresep . '</u>',
                        Yii::app()->controller->createUrl("informasiPenjualanResep/detailRetur", array("returresep_id" => $item->returresep_id, 'belumbayar' => true)),
                        array(
                            "class" => "",
                            "target" => "iframeDetailRetur",
                            "onclick" => '$("#dialogDetailRetur").dialog("open");',
                            "rel" => "tooltip",
                            "title" => "Klik untuk melihat detail Retur Stok Penjualan",
                            "data-placement" => "left"
                        )
                    ) . '<br>';
                }
                if (!empty($data->nomorResepSudahBayar)) {
                    if (count((array)$retur) == 0) return "";
                    return ""; //"Sudah Lunas<br>";
                }
                if (!empty($data->pasienadmisi_id)) {
                    $str .= "<br>" . CHtml::Link(
                        '<i class="icon-pencil-brown"></i>',
                        Yii::app()->controller->createUrl("informasiPenjualanResep/returPenjualan", array("penjualanresep_id" => $data->penjualanresep_id, "belumbayar" => 1)),
                        array(
                            "class" => "",
                            "target" => "iframeReturStok",
                            "onclick" => '$("#dialogReturStok").dialog("open");',
                            "rel" => "tooltip",
                            "title" => "Klik untuk Retur Stok Penjualan",
                            "data-placement" => "left"
                        )
                    );
                }
                return $str;
            },
            /*        '(!empty($data->returresep_id)) ? "Sudah Diretur":
                    (!empty($data->nomorResepSudahBayar) ?
                    "Sudah Lunas":
                        CHtml::Link("<i class=\"icon-pencil-brown\"></i>",Yii::app()->createUrl("/farmasiApotek/informasiPenjualanResep/ubahPenjualanResep", array(
                            "idPenjualan"=>$data->penjualanresep_id,
                        )),
                        array(
                            "title"=>"Klik untuk Retur Stok Penjualan Resep",
                            "data-placement"=>"left"
                        )))',
                     *
                     */
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Batal / Retur Penjualan',
            'type' => 'raw',
            'value' => function ($data) {
                if (!empty($data->returresep_id) && !empty($data->nomorResepSudahBayar))
                    return "Sudah Diretur<br>" . CHtml::Link(
                        '<i class="icon-form-print"></i>',
                        "#",
                        array(
                            "class" => "",
                            'onclick' => 'printRetur(' . $data->returresep_id . ',' . $data->penjualanresep_id . ',"PRINT");return false;',
                            "rel" => "tooltip",
                            "title" => "Klik untuk mencetak Retur Penjualan",
                            "data-placement" => "left"
                        )
                    );
                if (!empty($data->nomorResepSudahBayar))
                    return "Sudah Lunas<br>" . CHtml::Link(
                        '<i class="icon-form-retur"></i>',
                        Yii::app()->controller->createUrl("informasiPenjualanResep/returPenjualan", array("penjualanresep_id" => $data->penjualanresep_id)),
                        array(
                            "class" => "",
                            "target" => "iframeReturPenjualan",
                            "onclick" => '$("#dialogReturPenjualan").dialog("open");',
                            "rel" => "tooltip",
                            "title" => "Klik untuk Retur Penjualan",
                            "data-placement" => "left"
                        )
                    );
                $str = CHtml::Link(
                    '<i class="icon-form-silang"></i>',
                    "javascript:void(0);",
                    array(
                        "class" => "",
                        "onclick" => "cekHakBatal(" . $data->penjualanresep_id . ");return false;",
                        "rel" => "tooltip",
                        "title" => "Klik untuk Batal Penjualan Resep",
                        "data-placement" => "left"
                    )
                );
                // $str .= "<br/>".CHtml::Link('<i class="icon-form-ubah"></i>',Yii::app()->createUrl("/farmasiApotek/informasiPenjualanResep/ubahPenjualanResep", array(
                //     "idPenjualan"=>$data->penjualanresep_id,
                // )),
                // array(
                //     "title"=>"Klik untuk Ubah Penjualan",
                //     "data-placement"=>"left"
                // ));
                return $str;
            },
            /*
                    '(!empty($data->returresep_id)) ? "Sudah Diretur" :
                    (!empty($data->nomorResepSudahBayar) ?
                    "Sudah Lunas".CHtml::Link("<i class=\"icon-form-retur\"></i>",Yii::app()->controller->createUrl("informasiPenjualanResep/returPenjualan",array("penjualanresep_id"=>$data->penjualanresep_id)),
                        array("class"=>"",
                            "target"=>"iframeReturPenjualan",
                            "onclick"=>"$(\"#dialogReturPenjualan\").dialog(\"open\");",
                            "rel"=>"tooltip",
                            "title"=>"Klik untuk Retur Penjualan",
                            "data-placement"=>"left"
                        )):
                        CHtml::Link("<i class=\"icon-form-silang\"></i>","javascript:void(0);",
                        array("class"=>"",
                            "onclick"=>"cekHakBatal(".$data->penjualanresep_id.");return false;",
                            "rel"=>"tooltip",
                            "title"=>"Klik untuk Batal Penjualan Resep",
                            "data-placement"=>"left"
  )).CHtml::Link("<i class=\"icon-form-retur\"></i>",Yii::app()->controller->createUrl("informasiPenjualanResep/returPenjualan",array("penjualanresep_id"=>$data->penjualanresep_id)),
      array("class"=>"",
          "target"=>"iframeReturPenjualan",
          "onclick"=>"$(\"#dialogReturPenjualan\").dialog(\"open\");",
          "rel"=>"tooltip",
          "title"=>"Klik untuk Retur Penjualan",
"data-placement"=>"left"
      )))',
                     *
                     */
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Status Obat',
            'type' => 'raw',
            'value' => '$data->getStatusObat($data->statusobat,$data->penjualanresep_id)',
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'name' => 'Penyerahan Obat',
            'type' => 'raw',
            'value' => function ($data) {
                $oa = ObatalkespasienT::model()->findByAttributes(array(
                    'penjualanresep_id' => $data->penjualanresep_id,
                ), array(
                    'condition' => 'oasudahbayar_id is null',
                ));
                if (!empty($oa)) {
                    if ($data->instalasiasal_nama == 'Rawat Inap') {
                        return CHtml::Link(
                            "<i class=\"icon-form-verifikasi\"></i>",
                            Yii::app()->controller->createUrl("InformasiResepPasien/ambilObat", array("penjualanresep_id" => $data->penjualanresep_id, "frame" => 1, "popup" => "true")),
                            array(
                                "class" => "",
                                "target" => "iframeAmbilObat",
                                "onclick" => "$(\"#dialogAmbilObat\").dialog(\"open\");",
                                "rel" => "tooltip",
                                "title" => "Klik untuk Penyerahan Obat",
                            )
                        );
                    } 
                    else {
                        return "BELUM VERIFIKASI".CHtml::Link(
                            "<i class=\"icon-form-verifikasi\"></i>",
                            Yii::app()->controller->createUrl("InformasiResepPasien/ambilObat", array("penjualanresep_id" => $data->penjualanresep_id, "frame" => 1, "popup" => "true")),
                            array(
                                "class" => "",
                                "target" => "iframeAmbilObat",
                                "onclick" => "$(\"#dialogAmbilObat\").dialog(\"open\");",
                                "rel" => "tooltip",
                                "title" => "Klik untuk Penyerahan Obat",
                            )
                        );
                    }
                }else if (!empty($data->tglpenyerahan)) {
                    // return "Penyerahan Obat Tgl " . $data->tglpenyerahan;
                    return "Penyerahan Obat Tgl " . $data->tglpenyerahan."".CHtml::Link(
                        "<i class=\"icon-form-verifikasi\"></i>",
                        Yii::app()->controller->createUrl("InformasiResepPasien/ambilObat", array("penjualanresep_id" => $data->penjualanresep_id, "frame" => 1, "popup" => "true")),
                        array(
                            "class" => "",
                            "target" => "iframeAmbilObat",
                            "onclick" => "$(\"#dialogAmbilObat\").dialog(\"open\");",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Penyerahan Obat",
                        )
                    );
                } else {
                    return CHtml::Link(
                        "<i class=\"icon-form-verifikasi\"></i>",
                        Yii::app()->controller->createUrl("InformasiResepPasien/ambilObat", array("penjualanresep_id" => $data->penjualanresep_id, "frame" => 1, "popup" => "true")),
                        array(
                            "class" => "",
                            "target" => "iframeAmbilObat",
                            "onclick" => "$(\"#dialogAmbilObat\").dialog(\"open\");",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Penyerahan Obat",
                        )
                    );
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Petugas Farmasi',
            'type' => 'raw',
            'value' => function ($data) {
                $login = LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id);
                if (empty($login->pegawai_id)) return "-";
                $peg = PegawaiM::model()->findByPk($login->pegawai_id);
                return $peg->namaLengkap;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>