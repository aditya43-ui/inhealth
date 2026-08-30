<style>
    .is_ada_ttv td {
        background-color: #dcdcdc !important;
    }

    .disable-periksa {
		opacity: 0.6;
		pointer: not-allowed;
	}
</style>


<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarpasien-v-grid',
    'items_perpage' => 50,
    'dataProvider' => $model->searchDaftarPasien(),
    'template' => "{summary}\n{items}\n{pager}",
    "replaceUrl" => true,
    'itemsCssClass' => 'table table-condensed',
    'columns' => array(
        array(
            'name' => 'no_urutantri',
            'type' => 'raw',
            'header' => 'No. Antrian',
            'value' => function ($data) use (&$admisi) {
                $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));
                $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
                if (empty($data->waktupanggilpasien)) {
                    $verifikasi = CHtml::htmlButton(Yii::t("mds", "<i class='icon-ok icon-white'></i>", array()), array("class" => "btn btn-success", "onclick" => "myAlert('Panggil Pasien Dahulu');"));
                } else {
                    $verifikasi = CHtml::htmlButton(Yii::t("mds", "<i class='icon-ok icon-white'></i>", array()), array("class" => "btn btn-success", "onclick" => "verifikasiAntrian('" . $data->pendaftaran_id . "');"));
                }
                $label = '<a href="#" onclick="return false;" rel="tooltip" title="Tgl. Dilayani : ' . (empty($data->tglakandilayani) ? "-" : MyFormatter::formatDateTimeForUser($data->tglakandilayani)) . '">'
                    . $ruangan->ruangan_singkatan . "-" . $data->no_urutantri . '</a>';

                return $label . "<br>"
                    . ((!in_array($data->statusperiksa, array(Params::STATUSPERIKSA_ANTRIAN, Params::STATUSPERIKSA_SEDANG_PERIKSA))) ? "" : (empty($data->waktuverifikasipasien) ? "<span class=\"badge badge-info pull-right badge-status\">$data->jml_panggil</span>" . CHtml::htmlButton(Yii::t("mds", "{icon}", array("{icon}" => "<i class='icon-volume-up icon-white'></i>")), array("class" => "btn btn-primary", "onclick" => "panggilAntrian('" . $data->pendaftaran_id . "','" . $data->jml_panggil . "'); ", "rel" => "tooltip", "title" => "Klik untuk memanggil pasien ini")) . '<br/>' . $verifikasi : ""));
            },
        ),

        array(
            'header' => 'Tgl/<br>No.Pendaftaran/<br>Status Pasien',
            'name' => 'tgl_pendaftaran',
            'type' => 'raw',
            'value' => function ($data) {
                $pendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                $html = MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . "<br>" . $data->no_pendaftaran . "<br> <b>" . $data->statuspasien . "</b>";
                if (!empty($pendaftaran) && $pendaftaran->isbacahakpasien == true) {
                    $html .= "<br/>";
                    $html .= CHtml::Link(
                        "<i class=icon-form-detail></i> <br/> Hak & Kewajiban",
                        Yii::app()->createUrl("pendaftaranPenjadwalan/infoKunjunganRJ/hakKewajiban", array("pendaftaran_id" => $data->pendaftaran_id)),
                        array(
                            "class" => "",
                            "target" => "iframeHakKewajiban",
                            "onclick" => "$(\"#dialogHakKewajiban\").dialog(\"open\");",
                            "rel" => "tooltip",
                            "title" => "Klik Lihat Hak & Kewajiban",
                        )
                    );
                }
                return $html;
            },
        ),
        array(
            'header' => 'Nama Pasien/<br>No. Rekam Medis/<br>NIK/<br>Tanggal Lahir',
            //                        'value'=>'$data->namadepan.$data->nama_pasien'
            'type' => 'raw',
            'value' => function ($data) {
                echo  CHtml::link(
                    "<b>" . $data->namadepan . $data->nama_pasien . "</b>",
                    Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/getRiwayatPasien", array("id" => $data->pasien_id)),
                    array(
                        "rel" => "tooltip",
                        "title" => "Klik untuk melihat riwayat pemeriksaan pasien",
                        "target" => "frameRiwayatPasien",
                        "onclick" => "$('#dialogRiwayatPasien').dialog('open');"
                    )
                );
                echo "<br>";
                echo "<b>" . $data->no_rekam_medik . "</b>";
                echo "<br>";
                echo "<b>" . $data->no_identitas_pasien . "</b>";
                echo "<br>";
                echo MyFormatter::formatDateTimeForUser($data->tanggal_lahir);
                echo "<br>";
                // echo $data->alamat_pasien;
            },
            'headerHtmlOptions' => array('colspan' => 1, 'style' => ''),
        ),
        array(
            'header' => 'Jenis Penjamin' . '/<br>' . 'Penjamin' . '/<br>' . 'No SEP',
            'type' => 'raw',
            'value' => function ($data) {
                $str = $data->carabayar_nama . "<br/>" . $data->penjamin_nama;

                if ($data->carabayar_id == Params::CARABAYAR_ID_BPJS) {
                    // var_dump($data->pendaftaran_id);
                    $cr = new CDbCriteria;
                    $cr->join = "join pendaftaran_t p on p.sep_id = t.sep_id";
                    $cr->compare("p.pendaftaran_id", $data->pendaftaran_id);
                    $as = SepT::model()->find($cr);
                    if (!empty($as->nosep)) {
                        $str .= "<br/>" . CHtml::link('<b>' . $as->nosep . '</b>', Yii::app()->controller->createUrl('printSEP', array('sep_id' => $as->sep_id, 'pendaftaran_id' => $data->pendaftaran_id, 'preview' => 1)), array(
                            'target' => 'frame_sep',
                            'onclick' => "$('#dialog_sep').dialog('open')",
                        ));
                    }
                }
                $modPendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                $modSep = SepT::model()->findByAttributes(array('sep_id' => $modPendaftaran->sep_id));
                if (!empty($modSep)) {
                    $str .= "<br>";
                    $str .= CHtml::Link(
                        "<i class=icon-form-detail></i> Riwayat Pelayanan BPJS",
                        "",
                        array(
                            "class" => "",
                            "onclick" => "riwayatPelayanan('" . $modSep->nokartuasuransi . "', " . $modPendaftaran->pegawai->kodedokter_bpjs . ")",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Melihat Riwayat Pelayanan",
                            "style" => "cursor: pointer !important;"
                        )
                    );
                }

                return $str;
            },
        ),
        array(
            'header' => 'DPJP / PPDS / Riwayat Alih DPJP',
            'type' => 'raw',
            'value' => function ($data) use (&$admisi) {
                
                // nama dan tombol ubah dpjp
                $link = CHtml::link(
                    '<i class="icon-pencil-brown"></i>' . $data->gelardepan . " " . $data->nama_pegawai . " " . $data->gelarbelakang_nama,
                    Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/UbahDPJP", array("pendaftaran_id" => $data->pendaftaran_id)),
                    array("title" => "Klik untuk Mengubah Data Dokter Periksa", "target" => "iframeUbahDokter", "onclick" => '$("#EditRiwayatDPJP").dialog("open");', "rel" => "tooltip")
                );

                // pengecekan kelompok pegawai login
                $ppds2 = PpdsM:: model()->findByPk(Yii::app()->user->getState('ppds_id'));
                if (Yii::app()->user->getState('pegawai_id') !== null) {
                    if(Yii::app()->user->getState('kelompokpegawai_id') == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN) {
                        $link = CHtml::link(
                            '<i class="icon-pencil-brown"></i>' . $data->gelardepan . " " . $data->nama_pegawai . " " . $data->gelarbelakang_nama,
                            'javascript::(0)',
                            array(
                                "title" => "Klik untuk Mengubah Data Dokter Periksa", 
                                // "target" => "iframeUbahDokter",  
                                "onclick" => 'cekPemeriksaanUntukAksesUbahDPJP(' . $data->pendaftaran_id . ')', "rel" => "tooltip")
                        );

                    }
                }else{
                    if($ppds2->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN) {
                        $link = '<i class="icon-pencil-brown" style="opacity: 0.6; cursor: not-allowed;"></i>' . $data->gelardepan . " " . $data->nama_pegawai . " " . $data->gelarbelakang_nama;

                    }
                }
                echo $link;

                echo "<br>";
                if (Yii::app()->user->getState('isppds')) {

                    $link = CHtml::link(
                        '<i class="icon-pencil-brown"></i>Tambah PPDS',
                        Yii::app()->controller->createUrl(Yii::app()->controller->id . "/create", array("pendaftaran_id" => $data->pendaftaran_id)),
                        array("title" => "Klik untuk Tambah PPDS", "target" => "iframeDetailPPDS", "onclick" => '$("#dialogDetailPPDS").dialog("open");', "rel" => "tooltip")
                    );

                    if (Yii::app()->user->getState('pegawai_id')) {
                        if(Yii::app()->user->getState('kelompokpegawai_id') == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN) {
                        $link = '<i class="icon-pencil-brown" style="opacity: 0.6; cursor: not-allowed;"></i> Tambah PPDS';
                        }
                    }else{
                        if($ppds2->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN) {
                            $link = '<i class="icon-pencil-brown" style="opacity: 0.6; cursor: not-allowed;"></i> Tambah PPDS';
                            }
                    }
                    echo $link;

                    $ppds = PasienPpdsT::model()->findAllByAttributes(array(
                        'pendaftaran_id' => $data->pendaftaran_id
                    ));

                    $itemz = '';
                    $x = 1;

                    foreach ($ppds as $itemz) {
                        echo '<br>';
                        echo 'PPDS &nbsp;', $x++ . '-' . $itemz->ppds->ppds_nama;
                    }
                }
                
                echo "<hr>";
                echo '<div class="small-container">' . CHtml::link('<i class="icon-form-detail"></i><br>Riwayat DPJP', Yii::app()->controller->createUrl('/rawatDarurat/daftarPasien/viewRiwayatDPJP', array(
                    'pendaftaran_id' => $data->pendaftaran_id,
                )), array(
                    'target' => 'frameRiwayatDPJP',
                    'onclick' => "$('#dialogRiwayatDPJP').dialog('open');",
                )) . '</div>';
                echo "<hr>";
            },
            'htmlOptions' => array(
                'class' => 'rajal'
            )
        ),
        array(
            'header' => 'Status Periksa/<br>Jawaban Konsultasi',
            'type' => 'raw',
            'value' => function ($data) {
                echo $data->getStatus($data->statusperiksa, $data->pendaftaran_id, $data);
                if ($data->getAsalPoli()) {
                    echo $data->getAsalPoli();
                    echo '<div class="small-container">';
                    echo  CHtml::link('<i class="icon-form-rkontrol"></i><br>Jawaban <br>Konsultasi', Yii::app()->controller->createUrl(Yii::app()->controller->id . "/KonsultasiInternal", array("konsulpoli_id" => $data->getKonsulPasien())), array("title" => "Klik untuk Jawab Kontrol Internal", "target" => "iframeKonsulInternal", "onclick" => '$("#konsultasiInternal").dialog("open");', "rel" => "tooltip"));
                    echo '</div>';
                } else {
                    echo $data->getAsalPoli();
                    echo $data->getAsalRuangan();
                    // echo '<div class="small-container">';
                    // echo  CHtml::link('<i class="icon-form-rkontrol"></i><br>Jawaban <br>Konsultasi', Yii::app()->controller->createUrl(Yii::app()->controller->id . "/KonsultasiInternal", array("konsulpoli_id" => $data->getKonsulPasien())), array("title" => "Klik untuk Jawab Kontrol Internal", "target" => "iframeKonsulInternal", "onclick" => '$("#konsultasiInternal").dialog("open");', "rel" => "tooltip"));
                    // echo '</div>';
                    // echo '<br>';
                    // echo '<div class="small-container">';
                    // echo  CHtml::link('<i class="icon-form-rkontrol"></i><br>Masukkan <br>Hasil Pemeriksaan', Yii::app()->controller->createUrl(Yii::app()->controller->id . "/TindakanInternal", array("ruangtindakan_id" => $data->getAsalRuangan())), array("title" => "Klik untuk Jawab Tindakan Internal", "target" => "iframeTindakanInternal", "onclick" => '$("#tindakanInternal").dialog("open");', "rel" => "tooltip"));
                    // echo '</div>';
                    echo '</br>';
                }

                $periksaFisik = PemeriksaanfisikT::model()->findByAttributes(array(
                    'pendaftaran_id' => $data->pendaftaran_id,
                    'is_ns' => true,
                ), array('order' => 'create_time DESC'));
                $anamnesa = AnamnesaT::model()->findByAttributes(array(
                    'pendaftaran_id' => $data->pendaftaran_id,
                    'is_ns' => true,
                ), array('order' => 'create_time DESC'));

                if (!empty($anamnesa) && !empty($periksaFisik)) {
                    echo '<div class="is_ttv">Pasien Sudah Melakukan Pemeriksaan Tanda Vital di NS</div>';
                }
                // echo (!empty($data->asalpoliklinikkonsul_id)?$data->asalpoli->ruangan_nama:'');
            }
            // '$data->getStatus($data->statusperiksa,$data->pendaftaran_id,$data)<br/>$data->asalpoliklinikkonsul_id',
        ),
        array(
            'header' => 'Pemeriksaan Pasien',
            'type' => 'raw',
            'value' => function ($data) {
                // echo '<div class="small-container">';
                // echo (($data->alihstatus == FALSE) || (!empty($data->konsulpoli_id))) ? CHtml::link("<i class='icon-form-rj'></i><br>Asesmen Pasien", Yii::app()->controller->createUrl("/rawatJalan/pemeriksaanAsesmenPasienRJ", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Asesmen Pasien Rawat Jalan")) : CHtml::link("<i class='icon-list-alt'></i>", "javascript:cektindaklanjut()", array("rel" => "tooltip", "title" => "Klik untuk Pemeriksaan Pasien Rawat Jalan"));
                // echo '</div>';
                echo '<div class="small-container">';
                echo $data->linkPeriksaPasien;
                echo '</div>';
            },
            'htmlOptions' => array('style' => 'text-align: center; ')
        ),
        array(
            'name' => 'Rekam Medis Elektronik',
            'type' => 'raw',
            // 'value' => '',
            'value' => function ($data) {
                $link = '<div class="small-container">';
                $link .= CHtml::link('<i style="background: url(' . Yii::app()->getBaseUrl('webroot') . '/images/icon/doctor.png) center center no-repeat; display: inline-block; background-size: contain; width: 26px; height: 26px;"></i><br>Dokter ', Yii::app()->controller->createUrl("RekamMedikElektronikPasienRJ/index", array("pendaftaran_id" => $data->pendaftaran_id, 'type' => 'Dokter')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan rekam medik elektronik oleh dokter"));
                $link .= '</div>';
                $link .= '<div class="small-container">';
                $link .= CHtml::link('<i style="background: url(' . Yii::app()->getBaseUrl('webroot') . '/images/icon/nurse.png) center center no-repeat; display: inline-block; background-size: contain; width: 26px; height: 26px;"></i><br>Perawat / Bidan ', Yii::app()->controller->createUrl("RekamMedikElektronikPasienRJ/index", array("pendaftaran_id" => $data->pendaftaran_id, 'type' => 'Perawat')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan rekam medik elektronik oleh perawat"));
                $link .= '</div>';
                $link .= '<div class="small-container">';
                $link .=  CHtml::link("<i class='icon-form-konsulgizi'></i><br>Asuhan Gizi", Yii::app()->controller->createUrl('/rawatJalan/asuhanGiziPasienRJ/index', array(
                    'pendaftaran_id' => $data->pendaftaran_id,
                    // 'pasienadmisi_id' => $data->pasienadmisi_id,
                )), array('rel' => "tooltip", "title" => "Klik untuk Asuhan Gizi"));
                $link .= '</div>';

                return $link;
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'name' => 'Riwayat Vaksinasi/<br>Imunisasi',
            'type' => 'raw',
            // 'value' => '',
            'value' => function ($data) {
                return '<div class="small-container">' . CHtml::link('<i class="icon-form-detail"></i><br>Vaksinasi/<br>Imunisasi', Yii::app()->controller->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/updateRiwayatVaksinasi', array(
                    'pendaftaran_id' => $data->pendaftaran_id,
                )), array(
                    'target' => 'frameRiwayatVaksinasi',
                    'onclick' => "$('#dialogRiwayatVaksinasi').dialog('open');",
                )) . '</div>';
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        // array(
        //     'name' => 'Detail Pemeriksaan Fisik / Tanda Vital',
        //     'type' => 'raw',
        //     'value' => function ($data) {
        //         return '<div class="small-container">' . CHtml::link('<i class="icon-form-detail"></i><br>', Yii::app()->controller->createUrl('pemeriksaanFisik/detailPemeriksaanTandaVital', array(
        //             'pendaftaran_id' => $data->pendaftaran_id,
        //         )), array(
        //             'target' => 'frameDetailTandaVital',
        //             'onclick' => "$('#dialogDetailTandaVital').dialog('open');",
        //         )) . '</div>';
        //     },
        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        // ),
        // array(
        //     'name' => 'Persetujuan',
        //     'type' => 'raw',
        //     'value' => function ($data) {
        //         $link = '<div class="small-container">';
        //         $link .= CHtml::link('<i class="icon-form-file-a-edit"></i><br>Tindakan', Yii::app()->controller->createUrl("PersetujuanTindakanTRJ/index", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat persetujuan tindakan"));
        //         $link .= '</div>';
        //         $link .= '<div class="small-container">';
        //         $link .= CHtml::link('<i class="icon-form-file-b-edit"></i><br>Inform Consent', Yii::app()->controller->createUrl("PersetujuanTindakanUmumRJ/index", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan Inform Consent (Persetujuan)"));
        //         $link .= '</div>';
        //         $link .= '<div class="small-container">';
        //         $link .= CHtml::link('<i class="icon-form-file-c-edit"></i><br>Anestesi', Yii::app()->controller->createUrl("PersetujuanTindakanAnastesiRJ/index", array("pendaftaran_id" => $data->pendaftaran_id, "noframe" => 1)), array("id" => $data->no_pendaftaran . "_antrian", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat persetujuan tindakan anestesi"));
        //         $link .= '</div>';
        //         return $link;
        //     },
        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        // ),
        // array(
        //     'header' => 'Pemindahan Pasien',
        //     'type' => 'raw',
        //     'value' => function ($data) {
        //         $htmlLink = CHtml::link('<i class="icon-form-detail"></i><br>Transfer', Yii::app()->createUrl('/rawatJalan/pemindahanPasien/index', array('pendaftaran_id' => $data->pendaftaran_id)), array(
        //             'rel' => 'tooltip',
        //             'title' => 'Pemindahan Pasien',
        //         ));

        //         $modFormTransfer = PemindahanpasienT::model()->findAllByAttributes(array('ruangantujuan_id' => Yii::app()->user->getState("ruangan_id"), 'pendaftaran_id' => $data->pendaftaran_id), array('condition' => '(ispasienditerima IS NULL OR ispasienditerima = false)'));
        //         $linkPenerima = "";
        //         if (isset($modFormTransfer) && count($modFormTransfer) > 0) {
        //             $linkPenerima = CHtml::link('<i class="icon-form-check"></i><br>Terima Transfer', Yii::app()->createUrl("/perawatanIntensif/pemindahanPasienPI/index", array("pendaftaran_id" => $data->pendaftaran_id, 'pasienditerima' => 'diterima')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Penerimaan Pemindahaan Pasien"));
        //         }

        //         $modPemindahanPasien = PemindahanpasienT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id));
        //         if (!empty($modPemindahanPasien)) {
        //             $linkLihat = CHtml::link(
        //                 '<icon class="icon-form-detail"></icon><br> Lihat Transfer',
        //                 $this->createUrl("/bedahSentral/pemindahanPasienBS/detail", array("pemindahanpasien_id" => $modPemindahanPasien->pemindahanpasien_id)),
        //                 array(
        //                     "target" => "frameDetail",
        //                     "onclick" => "$('#dialogDetail').dialog('open');",
        //                     "rel" => "tooltip",
        //                     "title" => "Klik untuk Melihat Detail Riwayat Pemindahaan Pasien",

        //                 )
        //             );
        //         } else {
        //             $linkLihat = "";
        //         }

        //         return $htmlLink . '<br/>' . $linkPenerima . '<br>' . $linkLihat;
        //     },
        //     'htmlOptions' => array('style' => 'text-align: center; width:40px'),
        // ),
        // array(
        //     'header' => 'Catatan Pemindahan Pasien',
        //     'type' => 'raw',
        //     'value' => function ($data) {
        //         $modPemindahanPasien = PemindahanpasienT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id));
        //         if (!empty($modPemindahanPasien)) {
        //             return CHtml::link(
        //                 '<icon class="icon-form-detail"></icon>',
        //                 $this->createUrl("/bedahSentral/pemindahanPasienBS/detail", array("pemindahanpasien_id" => $modPemindahanPasien->pemindahanpasien_id)),
        //                 array(
        //                     "target" => "frameDetail",
        //                     "onclick" => "$('#dialogDetail').dialog('open');",
        //                     "rel" => "tooltip",
        //                     "title" => "Klik untuk Melihat Detail Riwayat Pemindahaan Pasien",

        //                 )
        //             );
        //         } else {
        //             return "";
        //         }
        //     },
        //     'htmlOptions' => array('style' => 'text-align: center; width:40px'),
        // ),
        // array(
        //     'name' => 'Penolakan',
        //     'type' => 'raw',
        //     'value' => function ($data) {
        //         $link = '<div class="small-container">';
        //         $link .= CHtml::link('<i class="icon-form-file-a-hapus"></i><br>Tindakan ', Yii::app()->controller->createUrl("PersetujuanTindakanTRJ/penolakan", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat penolakan tindakan"));
        //         $link .= '</div>';
        //         $link .= '<div class="small-container">';
        //         $link .= CHtml::link('<i class="icon-form-file-b-hapus"></i><br>Inform Refusal', Yii::app()->controller->createUrl("PersetujuanTindakanUmumRJ/penolakan", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan Inform Consent (Penolakan)"));
        //         $link .= '</div>';
        //         $link .= '<div class="small-container">';
        //         $link .= CHtml::link('<i class="icon-form-file-c-hapus"></i><br>Anestesi', Yii::app()->controller->createUrl("PersetujuanTindakanAnastesiRJ/penolakan", array("pendaftaran_id" => $data->pendaftaran_id, "noframe" => 1)), array("id" => $data->no_pendaftaran . "_antrian", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat penolakan tindakan anestesi"));
        //         $link .= '</div>';
        //         return $link;
        //     },
        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        // ),
        // array(
        //     'header' => 'Detail Persetujuan & Penolakan',
        //     'type' => 'raw',
        //     'value' => function ($data) {
        //         $str = "";
        //         $umum = SuratpersetujuanumumT::model()->findByAttributes(array(
        //             'pendaftaran_id' => $data->pendaftaran_id,
        //         ));
        //         if (!empty($umum)) {
        //             $str .= '<div class="small-container">';
        //             $str .= CHtml::link("<icon class='icon-form-detail'></icon><br>General<br>Consent", Yii::app()->controller->createUrl('suratPersetujuanUmumRJ/view', array('pendaftaran_id' => $data->pendaftaran_id)), array("target" => "frameGeneralConsent", "rel" => "tooltip", "title" => "Klik untuk melihat General Consent", "onclick" => "$('#dialogGeneralConsent').dialog('open');"));
        //             $str .= '</div>';
        //         }
        //         $str .= '<div class="small-container">';
        //         $str .= CHtml::link("<icon class='icon-form-file-a-lihat'></icon><br>Detail", Yii::app()->controller->createUrl('pencarianPasienRJ/detailPersetujuanTindakan', array('id' => $data->pendaftaran_id)), array("target" => "framePersetujuanTindakan", "rel" => "tooltip", "title" => "Klik untuk melihat Detail Persetujuan & Penolakan", "onclick" => "$('#dialogPersetujuanTindakan').dialog('open');"));
        //         $str .= '</div>';
        //         $str .= '<div class="small-container">';
        //         $str .= CHtml::link("<icon class='icon-form-file-b-lihat'></icon><br>Inform<br>Consent", Yii::app()->controller->createUrl('pencarianPasienRJ/detailInformConsent', array('id' => $data->pendaftaran_id)), array("target" => "frameInformConsent", "rel" => "tooltip", "title" => "Klik untuk melihat Inform Consent", "onclick" => "$('#dialogInformConsent').dialog('open');"));
        //         $str .= '</div>';
        //         $str .= '<div class="small-container">';
        //         $str .= CHtml::link("<icon class='icon-form-file-c-lihat'></icon><br>Anestesi", Yii::app()->controller->createUrl('pencarianPasienRJ/detailTindakanAnestesi', array('id' => $data->pendaftaran_id)), array("target" => "frameTindakanAnestesi", "rel" => "tooltip", "title" => "Klik untuk melihat Persetujuan Tindakan Anestesi", "onclick" => "$('#dialogTindakanAnestesi').dialog('open');"));
        //         $str .= '</div>';
        //         return $str;
        //     },
        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        // ),
        array(
            'header' => 'Tindak Lanjut',
            'type' => 'raw',
            'value' => function ($data) {
                $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));
                $ruangan = empty($admisi->ruangan_id) ? "" : $admisi->ruangan->ruangan_nama;
                $kamar = empty($admisi->kamarruangan_id) ? "" : $admisi->kamarruangan->kamarruangan_nokamar . ":" . $admisi->kamarruangan->kamarruangan_nobed;
                if (in_array($data->statusperiksa, array(Params::STATUSPERIKSA_ANTRIAN, Params::STATUSPERIKSA_SEDANG_PERIKSA))) {
                    echo '<div class="small-container">';
                    echo CHtml::link(
                        "<i class='icon-form-ri'></i><br>Rawat Inap",
                        ($data->statusperiksa == "SUDAH PULANG" ? '#' : Yii::app()->controller->createUrl('tindakLanjutRI', array(
                            'instalasi_id' => Params::INSTALASI_ID_RJ,
                            'pendaftaran_id' => $data->pendaftaran_id,
                        ))),
                        array(
                            "class" => "",
                            "target" => "frameTindakLanjut",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Proses Tindak Lanjut Pasien",
                            "onclick" => "myAlert('Status pasien masih " . $data->statusperiksa . ". Silakan Ubah Status untuk dapat ditindaklanjuti.'); return false;",
                        )
                    );
                    echo '</div>';
                } else {
                    $pulang = PasienpulangT::model()->findByAttributes(array(
                        'pendaftaran_id' => $data->pendaftaran_id,
                        'carakeluar_id' => Params::CARAKELUAR_ID_RAWATINAP,
                    ), array(
                        'condition' => 'pasienbatalpulang_id is null'
                    ));
                    echo '<div class="small-container">';
                    echo (!empty($pulang) || !empty($admisi)) ?
                        ((!empty($admisi) ? $ruangan . "<br>" . $kamar : "DIRAWAT INAP" . CHtml::link("<i class='icon-form-silang'></i>", Yii::app()->controller->createUrl("/" . Yii::app()->controller->module->id . "/" . Yii::app()->controller->id . "/BatalRawatInap", array("pendaftaran_id" => $data->pendaftaran_id)), array("title" => "Klik untuk Batal Proses Tindak Lanjut Pasien", "target" => "iframeBatalRawatInap", "onclick" => "$('#dialogBatalRawatInap').dialog('open');", "rel" => "tooltip"))))
                        :
                        CHtml::link(
                            "<i class='icon-form-ri'></i>",
                            (
                                //$data->statusperiksa == "SUDAH PULANG" ? 
                                '#'
                                //: Yii::app()->controller->createUrl('tindakLanjutRI', array(
                                //'instalasi_id'=>Params::INSTALASI_ID_RJ,
                                //'pendaftaran_id'=>$data->pendaftaran_id,
                                //))
                            ),
                            array(
                                "class" => "",
                                //"target"=>"frameTindakLanjut",
                                "rel" => "tooltip",
                                "title" => "Klik untuk Proses Tindak Lanjut Pasien",
                                "onclick" => $data->statusperiksa == "SUDAH PULANG" ? "myAlert('Pasien sudah dipulangkan.'); return false;" : "cekVerifikasiTindakLanjut(this,'" . $data->pendaftaran_id . "'); return false;" //'$("#dialogTindakLanjut").dialog("open");'
                            )
                        );
                }
                echo '</div>';
                if ($data->statusperiksa == "SUDAH PULANG") {
                    return '<div class="small-container">' . CHtml::link(
                        '<i class="icon-form-mintatawar"></i><br>Rencana Kontrol',
                        '#',
                        array("title" => "Klik untuk Rencana Kontrol Pasien", "target" => "iframeRencanaKontrol", "onclick" => "myAlert('Pasien sudah dipulangkan.'); return false;", "rel" => "tooltip")
                    ) . '</div>';
                }
                if (!empty($data->tglrenkontrol)) {
                    return '<div class="small-container">' . $data->tglrenkontrol . CHtml::link(
                        '<i class="icon-form-mintatawar"></i><br>Rencana Kontrol',
                        Yii::app()->controller->createUrl(Yii::app()->controller->id . "/RencanaKontrolPasienRJ", array("pendaftaran_id" => $data->pendaftaran_id)),
                        array("title" => "Klik untuk Rencana Kontrol Pasien", "target" => "iframeRencanaKontrol", "onclick" => "cekRenControl(event)", "rel" => "tooltip")
                    ) . '</div>';
                }
                echo '<div class="small-container">';
                echo CHtml::link(
                    '<i class="icon-form-mintatawar"></i><br>Rencana Kontrol',
                    Yii::app()->controller->createUrl(Yii::app()->controller->id . "/RencanaKontrolPasienRJ", array("pendaftaran_id" => $data->pendaftaran_id)),
                    array("title" => "Klik untuk Rencana Kontrol Pasien", "target" => "iframeRencanaKontrol", "onclick" => '$("#dialogRencanaKontrol").dialog("open");', "rel" => "tooltip")
                );
                echo '</div>';

                $htmlSuratRanap = (!empty($pulang) ? "<hr/>" . CHtml::link(
                    '<i class="icon-form-detail"></i><br/>Surat Perintah',
                    Yii::app()->controller->createUrl("/rawatJalan/suratPerintahRawatInap/index", array("pendaftaran_id" => $data->pendaftaran_id)),
                    array(
                        "id" => "$data->pendaftaran_id",
                        "rel" => "tooltip",
                        "title" => "Klik untuk Surat Perintah Rawat Inap",
                        "target" => "frameSuratPerintahRanap",
                        "onclick" => '$("#dialogSuratPerintahRanap").dialog("open");'
                    )
                ) : "");

                echo $htmlSuratRanap;
            },
            'htmlOptions' => array('style' => 'text-align: center; width:60px')
        ),
        //                array(
        //                    'header'=>'Rincian Tagihan',
        //                    'type'=>'raw',
        //                     'value'=>'CHtml::link("<icon class=\'icon-list-brown\' ></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/RinciantagihanpasienExtendsV/rincianBelumBayar", array("id"=>$data->pendaftaran_id)), array("target"=>"frameRincian","rel"=>"tooltip", "title"=>"lihat rincian tagihan pasien", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px ')                  
        //                ),
        /*array(
			'header'=>'Detail Rincian Tagihan',
			'type'=>'raw',
			'value'=>'CHtml::link("<icon class=\'icon-form-detailtagihan\' ></icon> ", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/printDetailRincianBelumBayar", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian","rel"=>"tooltip", "title"=>"lihat detail rincian tagihan pasien", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px ')                  
		),  */
        array(
			'header'=>'Rincian Tagihan <br> Sementara',
			'type'=>'raw',
			'value'=>function ($data) {
                echo CHtml::Link("<i class=\"icon-form-detailtagihan\"></i><br>Rincian Tagihan Sementara", Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayarRD", array("instalasi_id" => $data->instalasi_id, "pendaftaran_id" => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id, "frame" => true)), [
                    "target" => "iframeRincianTagihanSementara",
                    "onclick" => "$('#dialogRincianTagihanSementara').dialog('open');",
                    "rel" => "tooltip",
                    "title" => "Klik untuk Melihat Detail Riwayat Pemindahaan Pasien",
                    
                ]);
            }              
		),
        array(
            'header' => 'Status Dokumen',
            'type' => 'raw',
            'value' => function ($data) {
                $kirim = PengirimanrmT::model()->findByPk($data->pengirimanrm_id);
                // $crit = new CDbCriteria();
                // $crit->addCondition('pasien_id ='. $data->pasien_id);
                // $modDokfilerm = DokfilermR::model()->findAll($crit);
                // $modDokfilerms =[];
                // foreach ($modDokfilerm as $dok) {
                //     // var_dump((array)$dok->instalasi_ids);die;
                //     if (in_array( Yii::app()->user->getState('instalasi_id'), (array)$dok->instalasi_ids)) {
                //        $modDokfilerms[]=$dok; 
                //     }
                // }
                $pelayanan = '<hr>' . CHtml::link(
                    "<icon class='icon-form-detail'></icon><br>Pelayanan",
                    Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/riwayatPelayanan', array("pendaftaran_id" => $data->pendaftaran_id)),
                    array(
                        "class" => "",
                        "target" => "frameRiwayatPelayanan",
                        "rel" => "tooltip",
                        "title" => "Klik untuk melihat riwayat pelayanan",
                        "onclick" => '$("#dialogRiwayatPelayanan").dialog("open");'
                    )
                );


                $dok = CHtml::link("<i class='icon-file' style='margin: 7px;'></i><br>File Rekam Medis", Yii::app()->controller->createUrl('DaftarPasien/riwayatDokfilerm', array('pendaftaran_id' => $data->pendaftaran_id)), array("target" => "frameRiwayatDokfilerm", "rel" => "tooltip", "title" => "Klik untuk melihat File Rekam Medis", "onclick" => "$('#dialogDokFilerm').dialog('open');"));
                if (!empty($kirim)) {
                    if ($data->statusdokrm == "SUDAH DITERIMA") {
                        if ($kirim->ruanganpenerima_id == Yii::app()->user->getState('ruangan_id')) {
                            if ($data->statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) {
                                return CHtml::link(
                                    $data->statusdokrm,
                                    Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/statusDokumenKirim', array("pengirimanrm_id" => $data->pengirimanrm_id, "pendaftaran_id" => $data->pendaftaran_id)),
                                    array(
                                        "class" => "btn btn-primary",
                                        "target" => "frameStatusDokumen",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk mengirim dokumen ke ruangan lain",
                                        "onclick" => 'myConfirm("Pasien Masih Dalam Status Menunggu Admisi. Apakah Anda akan melanjutkan transaksi?","Perhatian",function(r){if(r){$("#dialogStatusDokumen").dialog("open")}});'
                                    )
                                )
                                    . '<br><br>' .
                                    $dok . '<br><br>' . $pelayanan;
                            } else {
                                return CHtml::link(
                                    $data->statusdokrm,
                                    Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/statusDokumenKirim', array("pengirimanrm_id" => $data->pengirimanrm_id, "pendaftaran_id" => $data->pendaftaran_id)),
                                    array(
                                        "class" => "btn btn-primary",
                                        "target" => "frameStatusDokumen",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk mengirim dokumen ke ruangan lain",
                                        "onclick" => "$('#dialogStatusDokumen').dialog('open');"
                                    )
                                ) . '<br><br>' .
                                    $dok . '<br><br>' . $pelayanan;
                            }
                        } else {
                            return $data->getStatusDokumen($data->pengirimanrm_id, $data->statusdokrm, $data->pendaftaran_id) . '<br><br>' .
                                $dok . '<br><br>' . $pelayanan;
                        }
                    } else {
                        return $data->getStatusDokumen($data->pengirimanrm_id, $data->statusdokrm, $data->pendaftaran_id) . '<br><br>' .
                            $dok . '<br><br>' . $pelayanan;
                    }
                } else {
                    return $data->getStatusDokumen($data->pengirimanrm_id, $data->statusdokrm, $data->pendaftaran_id) . '<br><br>' .
                        $dok . '<br><br>' . $pelayanan;
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        // array(
        //     'header' => 'Status Dokumen',
        //     'type' => 'raw',
        //     'value' => function ($data) {
        //         $kirim = PengirimanrmT::model()->findByPk($data->pengirimanrm_id);
        //         // $crit = new CDbCriteria();
        //         // $crit->addCondition('pasien_id ='. $data->pasien_id);
        //         // $modDokfilerm = DokfilermR::model()->findAll($crit);
        //         // $modDokfilerms =[];
        //         // foreach ($modDokfilerm as $dok) {
        //         //     // var_dump((array)$dok->instalasi_ids);die;
        //         //     if (in_array( Yii::app()->user->getState('instalasi_id'), (array)$dok->instalasi_ids)) {
        //         //        $modDokfilerms[]=$dok; 
        //         //     }
        //         // }
        //         $dok = CHtml::link("<i class='icon-file' style='margin: 7px;'></i><br>File Rekam Medis", Yii::app()->controller->createUrl('DaftarPasien/riwayatDokfilerm', array('pendaftaran_id' => $data->pendaftaran_id)), array("target" => "frameRiwayatDokfilerm", "rel" => "tooltip", "title" => "Klik untuk melihat File Rekam Medis", "onclick" => "$('#dialogDokFilerm').dialog('open');"));
        //         // if (!empty($kirim)) {
        //         //     if ($data->statusdokrm == "SUDAH DITERIMA") {
        //         //         if ($kirim->ruanganpenerima_id == Yii::app()->user->getState('ruangan_id')) {
        //         //             if ($data->statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) {
        //         //                 return CHtml::link(
        //         //                     $data->statusdokrm,
        //         //                     Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/statusDokumenKirim', array("pengirimanrm_id" => $data->pengirimanrm_id, "pendaftaran_id" => $data->pendaftaran_id)),
        //         //                     array(
        //         //                         "class" => "btn btn-primary",
        //         //                         "target" => "frameStatusDokumen",
        //         //                         "rel" => "tooltip",
        //         //                         "title" => "Klik untuk mengirim dokumen ke ruangan lain",
        //         //                         "onclick" => 'myConfirm("Pasien Masih Dalam Status Menunggu Admisi. Apakah Anda akan melanjutkan transaksi?","Perhatian",function(r){if(r){$("#dialogStatusDokumen").dialog("open")}});'
        //         //                     )
        //         //                 )
        //         //                     . '<br><br>' .
        //         //                     $dok;
        //         //             } else {
        //         //                 return CHtml::link(
        //         //                     $data->statusdokrm,
        //         //                     Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/statusDokumenKirim', array("pengirimanrm_id" => $data->pengirimanrm_id, "pendaftaran_id" => $data->pendaftaran_id)),
        //         //                     array(
        //         //                         "class" => "btn btn-primary",
        //         //                         "target" => "frameStatusDokumen",
        //         //                         "rel" => "tooltip",
        //         //                         "title" => "Klik untuk mengirim dokumen ke ruangan lain",
        //         //                         "onclick" => "$('#dialogStatusDokumen').dialog('open');"
        //         //                     )
        //         //                 ) . '<br><br>' .
        //         //                     $dok;
        //         //             }
        //         //         } else {
        //         //             return $data->getStatusDokumen($data->pengirimanrm_id, $data->statusdokrm, $data->pendaftaran_id) . '<br><br>' .
        //         //                 $dok;
        //         //         }
        //         //     } else {
        //         //         return $data->getStatusDokumen($data->pengirimanrm_id, $data->statusdokrm, $data->pendaftaran_id) . '<br><br>' .
        //         //             $dok;
        //         //     }
        //         // } else {
        //         //     return $data->getStatusDokumen($data->pengirimanrm_id, $data->statusdokrm, $data->pendaftaran_id) . '<br><br>' .
        //         //         $dok;
        //         // }
        //         return $dok;
        //     },
        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        // ),
        array(
            'header' => 'Batal Periksa',
            'type' => 'raw',
            'value' => function ($data) {
                $pendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));
                $pembayaranPelayanan = PembayaranpelayananT::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id]);
                
                if (!empty($pembayaranPelayanan)) {
                    return CHtml::link("<i class='icon-form-silang'></i>", "javascript:myAlert('Tidak Dapat Dibatalkan. Pasien sudah Melakukan Pembayaran.');", array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", 'data-placement' => 'left'));
                }
                if (!empty($data->sep_id)) {
                    return CHtml::link("<i class='icon-form-silang'></i>", "javascript:myAlert('Tidak Dapat Dibatalkan. Pasien sudah Terbit SEP.');", array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", 'data-placement' => 'left'));
                }
                if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                    return CHtml::link("<i class='icon-form-silang'></i>", "javascript:myAlert('Pasien sudah dipulangkan.');", array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", 'data-placement' => 'left'));
                }
                if (!empty($admisi) || !empty($pendaftaran->pasienpulang_id)) {
                    return CHtml::link("<i class='icon-form-silang'></i>", "javascript:myAlert('Pasien sedang di rawat inap.');", array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", 'data-placement' => 'left'));
                }
              
                return CHtml::link("<i class='icon-form-silang'></i>", "javascript:;", array('onclick' => 'dialogBatalPeriksaRj();', "id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", 'data-placement' => 'left', 'onclick' => 'dialogBatalPeriksaRj(' . $data->pendaftaran_id . ',"' . $data->statusperiksa . '","' . $data->nama_pasien . '")'));
               
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){ubahWarna();
			jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
			setPunyaTTV(); disableLink();}',
)); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Riwayat Peminahaan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 550,
        'resizable' => false
    ),
));
?>
<iframe name='frameDetail' width="100%" height="98%"></iframe>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSuratPerintahRanap',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Surat Perintah Rawat Inap</span><span style="float: right !important;">RM RI. 03 REV 02</span> </span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 650,
        'resizable' => true
    ),
));
?>
<iframe name='frameSuratPerintahRanap' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogEdukasiAnestesi',
        'options' => array(
            'title' => 'Formulir Edukasi Tindakan Anestesi dan Sedasi',
            'autoOpen' => false,
            'width' => 1000,
            'height' => 600,
            'resizable' => true,
        ),

    )
);
echo '<iframe name="frameEdukasiAnestesi" width="100%" height="100%"></iframe>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRiwayatPasien',
    'options' => array(
        'title' => 'Riwayat Pemeriksaan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameRiwayatPasien' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!-- LIST DOKUMEN RM -->
<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokFilerm',
    'options' => array(
        'title' => 'Riwayat Dokumen File Rekam Medis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameRiwayatDokfilerm' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!-- END DOKUMEN -->
<?php
//=============================== Dialog Riwayat Vaksinasi =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogRiwayatVaksinasi',
        'options' => array(
            'title' => 'Riwayat Vaksinasi/Imunisasi',
            'autoOpen' => false,
            'zIndex' => 1002,
            'width' => 1000,
            'height' => 450,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                        data: $('#formCari').serialize()
                    }); }",
        ),
    )
);
echo '<iframe name="frameRiwayatVaksinasi" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRiwayatPelayanan',
    'options' => array(
        'title' => 'Riwayat Pelayanan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 550,
        'resizable' => false
    ),
));
?>
<iframe name='frameRiwayatPelayanan' width="100%" height="98%"></iframe>
<?php $this->endWidget(); ?>



<?php
// Dialog untuk menampilkan dialog sep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog_sep',
    'options' => array(
        'title' => 'Detail SEP',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'minWidth' => 980,
        'height' => 460,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="frame_sep" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
//========= end dialog detail SEP =============================
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogHakKewajiban',
    'options' => array(
        'title' => 'Hak & Kewajiban Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 960,
        'height' => 580,
        'resizable' => false,
    ),
));
?>
<iframe name="iframeHakKewajiban" style="width: 100%; height: 98%;"></iframe>
</iframe>
<?php
$this->endWidget();
?>

<?php
//=============================== Dialog Riwayat Vaksinasi =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogDetailTandaVital',
        'options' => array(
            'title' => 'Detail Pemeriksaan Fisik | Data Pemeriksaan dan Tanda Vital',
            'autoOpen' => false,
            'zIndex' => 1002,
            'width' => 1000,
            'height' => 550,
            'resizable' => true
        ),
    )
);
echo '<iframe name="frameDetailTandaVital" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>




<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailPPDS',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">PPDS</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 650,
        'height' => 570,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
            data: $('#caripasien-form').serialize()
        }); }",
    ),
));
?>
<iframe name='iframeDetailPPDS' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php
//bpjs ICARE
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogFrameRiwayat',
    'options' => array(
        'title' => 'Riwayat Pelayanan BPJS-Kes (I-Care)',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe id="iframeRiwayatPelayanan" name="iframeRiwayatPelayanan" style="width: 100%; height: 98%;"></iframe>
</iframe>
<?php
$this->endWidget();
?>
<?php echo $this->renderPartial($this->path_view . "_dialogPersetujuan", array(), true); ?>
<script type="text/javascript">
    function setPunyaTTV() {
        $("#daftarpasien-v-grid tbody tr").each(function() {
            if ($(this).find(".is_ttv").length != 0) {
                $(this).addClass("is_ada_ttv");
            }
        });
    }

    {
        function batalperiksa(pendaftaran_id) {
            myConfirm("Anda yakin akan membatalkan pemeriksaan rawat jalan pasien ini?", "Perhatian!", function(r) {
                if (r) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalPeriksa'); ?>',
                        data: {
                            pendaftaran_id: pendaftaran_id
                        }, //
                        dataType: "json",
                        success: function(data) {
                            if (data.status == true) {
                                myAlert(data.pesan);
                                $.fn.yiiGridView.update('daftarpasien-v-grid', {
                                    data: $(this).serialize()
                                });
                                // Notifikasi Pasien
                                if (data.smspasien == 0) {
                                    var params = [];
                                    params = {
                                        instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                                        modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                                        judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                                        isinotifikasi: 'Pasien ' + data.nama_pasien + ' tidak memiliki nomor mobile'
                                    }; // 16 
                                    insert_notifikasi(params);
                                }
                                // Notifikasi Dokter
                                if (data.smsdokter == 0) {
                                    var params = [];
                                    params = {
                                        instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                                        modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                                        judulnotifikasi: 'GAGAL KIRIM SMS DOKTER',
                                        isinotifikasi: 'dr. ' + data.nama_pegawai + ' tidak memiliki nomor mobile'
                                    }; // 16 
                                    insert_notifikasi(params);
                                }
                            } else if (data.pesan == 'exist') {
                                myAlert('Pasien telah melakukan pemeriksaan');
                            } else {
                                myAlert(data.pesan);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }
            });
        }
        //validasi pemeriksaan
        function cektindaklanjut() {
            myAlert("Pasien sudah ditindak lanjut ke Rawat Inap!");
        }

        function setSedangPeriksa(pendaftaran_id, nama_pasien) {
            myConfirm(' Apakah pasien atas nama ' + nama_pasien + ' sudah selesai periksa? ', 'Perhatian!', function(r) {
                if (r) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'SetSedangPeriksa'); ?>',
                        data: {
                            pendaftaran_id: pendaftaran_id
                        }, //
                        dataType: "json",
                        success: function(data) {
                            if (data) {
                                $.fn.yiiGridView.update('daftarpasien-v-grid');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }
            });
        }
    }
    /**
     * 
     * @param {type} pendaftaran_id
     * @param {type} statusperiksa
     * @param {type} namaPasien
     * @returns {undefined}
     */
    function dialogBatalPeriksaRj(pendaftaran_id, statusperiksa, namaPasien) {
        $('#titleNamaPasienBatal_rj').html(namaPasien);
        $('#DialogBatalperiksa_rj #pendaftaran_id_rj').val(pendaftaran_id);
        $('#DialogBatalperiksa_rj #statusperiksa_rj').val(statusperiksa);
        $('#DialogBatalperiksa_rj').dialog('open');
    }

    function ubahPeriksaKarenaBatal() {
        var pendaftaran_id = $('#DialogBatalperiksa_rj #pendaftaran_id_rj').val();
        var tglbatal = $('#DialogBatalperiksa_rj #tglbatal_rj').val();
        var keterangan_batal = $('#DialogBatalperiksa_rj #keterangan_batal_rj').val();
        $('#DialogBatalperiksa_rj #keterangan_batal_rj').attr('class', '');

        if (cekAlasanBatal($("#keterangan_batal_rj")) == false) {
            return false;
        }

        if (keterangan_batal == '') {
            myAlert("Alasan Pembatalan Pasien Ini, wajib diisi");
            $('#DialogBatalperiksa_rj #keterangan_batal_rj').attr('class', 'error');
            return false;
        }
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('batalPeriksa'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id,
                tglbatal: tglbatal,
                keterangan_batal: keterangan_batal
            }, //
            dataType: "json",
            success: function(data) {
                if (data.status == true) {
                    myAlert(data.pesan);
                    $('#DialogBatalperiksa_rj').dialog('close');
                    $.fn.yiiGridView.update('daftarpasien-v-grid', {
                        data: $(this).serialize()
                    });
                    // Notifikasi Pasien
                    if (data.smspasien == 0) {
                        var params = [];
                        params = {
                            instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                            modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                            judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                            isinotifikasi: 'Pasien ' + data.nama_pasien + ' tidak memiliki nomor mobile'
                        }; // 16 
                        insert_notifikasi(params);
                    }
                    // Notifikasi Dokter
                    if (data.smsdokter == 0) {
                        var params = [];
                        params = {
                            instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                            modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                            judulnotifikasi: 'GAGAL KIRIM SMS DOKTER',
                            isinotifikasi: 'dr. ' + data.nama_pegawai + ' tidak memiliki nomor mobile'
                        }; // 16 
                        insert_notifikasi(params);
                    }
                } else if (data.pesan == 'exist') {
                    myAlert('Pasien telah melakukan pemeriksaan');
                    $('#DialogBatalperiksa_rj').dialog('close');
                } else {
                    myAlert(data.pesan);
                    $('#DialogBatalperiksa_rj').dialog('close');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    const cekAlasanBatal = (obj) => {
        let word = ($(obj).val()).replace(/ /g, "");
        var count = (word).length;

        if (count < 10) {
            toastr.error("Alasan batal tidak boleh kurang dari 10 karakter, spasi tidak termasuk", "Perhatian!");
            return false;
        }
        return true;
    }


    function ubahWarna() {
        // find baris kolom 
        $('#daftarpasien-v-grid > table > tbody > tr').each(function() {
            var tbl = $(this).find('.ubah').val();

            console.log('jns: ' + tbl);
            if (tbl == "Fast Track") {
                // set jika nilai selain kondisi di atas warna merah
                $(this).find('td').attr('style', 'background: #F5B9B9 !important');
            } else {
                // set jika kondisi di atas warna putih
                $(this).find('td').attr('style', 'background: white !important');
            }
        });
    }

    $(document).ready(function() {
        setPunyaTTV();
        ubahWarna();
    });

    function riwayatPelayanan(noka, kodedokter) {
        console.log(noka, kodedokter);
        $("#dialogFrameRiwayat").dialog('open')
        $.ajax({
            type: 'GET',
            url: '<?php echo $this->createUrl('/rawatJalan/daftarPasien/riwayatPelayananPasien'); ?>',
            data: {
                noka: noka,
                kodedokter: kodedokter,
            },
            dataType: "json",
            success: function(data) {
                if (data.pesan != '') {
                    myAlert(data.pesan);
                }
                if (data.url != "" || data.url != null) {
                    // $("#dialogFrameRiwayat").dialog('open')
                    $('#iframeRiwayatPelayanan').attr('src', data.url);
                }


            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }
</script>