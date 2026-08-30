<?php

    $is_validasi_pja = (Yii::app()->user->getState('kelompokpegawai_id') != 1)
    || (Yii::app()->user->name == 'sysadmin');


    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'daftarPasien-grid',
        'items_perpage' => 20,
        'dropdownItemKelipatan' => 20,
        'dataProvider' => $model->searchRI(),
        'replaceUrl' => true,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
        'columns' => array(
            array(
                'header' => 'Tgl. Masuk Kamar',
                'type' => 'raw',
                'value' => '$data->tglAdmisiMasukKamar'
            ),
            //                    'ruangan_nama',
            array(
                'header' => 'Tgl. Registrasi Awal',
                'type' => 'raw',
                'value' => function ($data) {
                    $pendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                    $html = $data->caramasuk_nama;
                    $html .= "<br/>";
                    $html .= MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . "<br>" . $data->no_pendaftaran;
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
                }
            ),
            array(
                'header' => 'Identitas Pasien',
                'type' => 'raw',
                'value' => function ($data) {
                    echo  "<b>" . $data->no_rekam_medik . "</b>";
                    echo "<hr>";
                    echo "<b>" . $data->no_identitas_pasien . "</b>";
                    echo "<hr>";
                    echo  CHtml::link(
                        "<b>" . $data->namadepan . $data->nama_pasien . "</b>" . '<i class="icon-form-lihat"></i>',
                        Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/getRiwayatPasien", array("id" => $data->pasien_id)),
                        array(
                            "rel" => "tooltip",
                            "title" => "Klik untuk melihat riwayat pemeriksaan pasien",
                            "target" => "frameRiwayatPasien",
                            "onclick" => "$('#dialogRiwayatPasien').dialog('open');"
                        )
                    );
                    echo "<hr>";
                    echo MyFormatter::formatDateTimeForUser($data->tanggal_lahir);
                    echo "<hr>";
                    echo  CHtml::link(
                        '<i class="icon-form-detailtagihan"></i>',
                        Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/getSosialPasien", array("id" => $data->pendaftaran_id)),
                        array(
                            "rel" => "tooltip",
                            "title" => "Klik untuk melihat riwayat data sosial pasien",
                            "target" => "frameSosialPasien",
                            "onclick" => "$('#dialogSosialPasien').dialog('open');"
                        )
                    );
                    
                },
            ),
            array(
                'header' => 'Penjamin',
                'value' => function ($data) {
                    echo  $data->caraBayarPenjamin;
                    echo "<br>";
                    $modPendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                    $modSep = SepT::model()->findByAttributes(array('sep_id' => $modPendaftaran->sep_id));
                    if (!empty($modSep)) {
                        echo CHtml::Link(
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
                },
            ),
            
            array(
                'header' => 'Dokter Penerima/Alergi Obat',
                'type' => 'raw',
                'value' => function ($data) {
                    if (empty($data->dokterpenerima_id)) {
                        echo "-";
                    }
                    $pegawai = PegawaiM::model()->findByPk($data->dokterpenerima_id);
                    $admisi = PasienadmisiT::model()->findByPk($data->pasienadmisi_id);

                    $jeniskasus = !empty($admisi->spesialis_id) ? $admisi->spesialis->jeniskasuspenyakit_nama : "-";

                    echo $pegawai ? $pegawai->namaLengkap : "-";
                    echo "<hr>";
                    if (empty($data->renPulang)) {
                        echo CHtml::hiddenField("RIInfopasienmasukkamarV[pendaftaran_id]", $data->pendaftaran_id, array("id" => "pendaftaran_id", "onkeypress" => "return $(this).focusNextInputField(event)", "class" => "span3 list_kasus_penyakit")) . "" . CHtml::link("<i class=icon-form-ubah></i> " . $jeniskasus, "javascript:void(0)", array("onclick" => "ubahKasusPenyakit(this," . $data->pendaftaran_id . "," . $data->pasienadmisi_id . "," . $data->jeniskasuspenyakit_id . ");return false;", "class" => "kasus_penyakit", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Mengubah Data Kasus Penyakit"));
                    } else {
                        echo  $jeniskasus;
                    }
                    echo "<hr>";
                    echo $data->AlergiObat;
                },
                'htmlOptions' => array(
                    // 'style' => 'text-align: center;',
                    'class' => 'list_kasus_penyakit'
                )
                
            ),
            array(
                'header' => 'DPJP / PPDS / Riwayat Alih DPJP',
                'type' => 'raw',
                'value' => function ($data) {
                    $nama = "";
                    $admisi = PasienadmisiT::model()->findByPk($data->pasienadmisi_id);

                    if (!empty($admisi->pegawai_id)) {
                        $nama .= "<br>DPJP 1 : " . $admisi->pegawai->namaLengkap . "</br>";
                    }
                    // if (!empty($admisi->dpjp2_id)) {
                    //     $nama .= "<br>DPJP 2 : " . $admisi->pegawai2->namaLengkap ?? "" . "</br>";
                    // }
                    // if (!empty($admisi->dpjp3_id)) {
                    //     $nama .= "<br>DPJP 3 : " . $admisi->pegawai3->namaLengkap ?? "" . "</br>";
                    // }

                    // if (!empty($admisi->dpjp4_id)) {
                    //     $nama .= "<br>DPJP 4 : " . $admisi->pegawai4->namaLengkap ?? "" . "</br>";
                    // }

                    // if (!empty($admisi->dpjp5_id)) {
                    //     $nama .= "<br>DPJP 5 : " . $admisi->pegawai5->namaLengkap ?? "" . "</br>";
                    // }

                    // ubah DPJP
                    if (empty($data->renPulang)) {
                        if(Yii::app()->user->getState('kelompokpegawai_id') != Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP || Yii::app()->user->getState('loginpemakai_id') == Params::LOGINPEMAKAI_ID_ADMIN) {
                            echo '<div style="width:100px;">' . CHtml::link(
                                '<i class="icon-pencil-brown"></i> ' . $nama,
                                Yii::app()->controller->createUrl('ubahDPJP', ['pendaftaran_id' => $data->pendaftaran_id, 'pasienadmisi_id' => $data->pasienadmisi_id]),
                                array(
                                    'target' => 'iframeEditDokterPeriksa2',
                                    "onclick" => '$("#editDokterPeriksa2").dialog("open");', "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Mengubah Data DPJP")
                            ) . "</div>";
                        } else {
                            echo '<div style="width:100px;">' . CHtml::link(
                                '<i class="icon-pencil-brown"></i> ' . $nama,
                               '',
                                array(
                                    "onclick" => 'myAlert("Tidak Dapat Ubah DPJP")', "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Mengubah Data DPJP")
                            ) . "</div>";
                        }
                    } else {
                        echo $nama;
                    }

                   
                    echo "<hr>"; // garis
                    echo "<br>"; //line baru

                    // tambah PPDS
                    if (Yii::app()->user->getState('isppds')) {
                        echo CHtml::link(
                            '<i class="icon-pencil-brown"></i>Tambah PPDS',
                            Yii::app()->controller->createUrl(Yii::app()->controller->id . "/create", array("pendaftaran_id" => $data->pendaftaran_id)),
                            array("title" => "Klik untuk Tambah PPDS", "target" => "iframeDetailPPDS", "onclick" => '$("#dialogDetailPPDS").dialog("open");', "rel" => "tooltip")
                        );
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
                    echo "<hr>"; // garis

                    // riwayat DPJP
                    echo '<div class="small-container">' . CHtml::link('<i class="icon-form-detail"></i><br>Riwayat DPJP', Yii::app()->controller->createUrl('/rawatDarurat/daftarPasien/viewRiwayatDPJP', array(
                        'pendaftaran_id' => $data->pendaftaran_id,
                    )), array(
                        'target' => 'frameRiwayatDPJP',
                        'onclick' => "$('#dialogRiwayatDPJP').dialog('open');",
                    )) . '</div>';
                    echo "<hr>"; // garis

                

                    echo "<div style='width:100px;'>" . 
                        
                    CHtml::link(
                        '<i class="icon-form-ubah"></i> Alih DPJP',
                            Yii::app()->controller->createUrl("alihDPJP", array("pendaftaran_id" => $data->pendaftaran_id)),
                            array("title" => "Klik untuk Mengubah Data Dokter Periksa", "target" => "iframeUbahDokter", "onclick" => 'cekAkses(' . Yii::app()->user->getState('kelompokpegawai_id') . ', ' . $admisi->pegawai_id .');', "rel" => "tooltip")
                        )
                    
                    . "</div>";

                    echo "<hr>";

                    $modUbahDokter = UbahdokterR::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id, 'alasanperubahandokter' => 'ALIH LEADER'], ['order' => 'create_time desc']);

                    if(!empty($modUbahDokter)) {
                        if($modUbahDokter->dokterbaru_id == Yii::app()->user->getState('pegawai_id')) {
                            // jika dokter yang dituju
                            if($modUbahDokter->is_approve === null) {
                                // terima
                                echo CHtml::Link("<i class='icon-form-check'></i> <b>Setujui Alih DPJP</b>","", [
                                    "class"=>"btn-small", 
                                    "id" => "approve",
                                    "onClick" => "approve(" . $modUbahDokter->ubahdokter_id . ", " . Yii::app()->user->getState('kelompokpegawai_id') . ")"
                                ]);
                                echo '<br>';
                                 // tolak
                                 echo CHtml::Link("<i class='icon-form-silang'></i> <b>Tolak Alih DPJP</b>",Yii::app()->controller->createUrl("RejectedAlihDPJP", array("ubahdokter_id" => $modUbahDokter->ubahdokter_id)), [
                                    "class"=>"btn-small", 
                                    "target" => "iframeAlihLeaderDanDispos",
                                    "onClick" => '$("#dialogTolakAlihLeaderDanDispos").dialog("open");'
                                ]);
    
                            } else {
                                if($modUbahDokter->is_approve) {
                                    echo '<div class="badge badge-success" style="padding:8px;font-size:10pt">Alih DPJP <br> Sudah Disetujui</div>';
                                } else {
                                    echo '<div class="badge badge-danger" style="padding:8px;font-size:10pt">Alih DPJP <br> Ditolak</div>';
                                }
                            }
                        } else if($modUbahDokter->dokterlama_id == Yii::app()->user->getState('pegawai_id')){
                            // jika doker yang melakukan transaksi alih leader
                            if($modUbahDokter->is_approve) {
                                echo '<div class="badge badge-success" style="padding:8px;font-size:10pt">Alih DPJP <br> Sudah Disetujui</div>';
                            } else if($modUbahDokter->is_approve === false) {
                                echo '<div class="badge badge-danger" style="padding:8px;font-size:10pt">Alih DPJP <br> Ditolak</div>';
                            } else {
                                echo '<div class="badge badge-warning" style="padding:8px;font-size:10pt;color:black">Alih DPJP <br> Menunggu Persetujuan</div>';
                            }
                        }
                    }
                }, 
            ),
            
            array(
                'header' => 'Kelas/Kamar',
                'name' => 'kamarruangan_nokamar',
                'type' => 'raw',
                'value' => function ($data) {
                    echo $data->kelaspelayanan_nama;
                    echo "<hr>";
                    $cekPembayaran = (PasienpulangT::model()->cekSisaPembayaran($data->pendaftaran_id) == false) ? 'ada' : 'tidak';
                    if ($cekPembayaran == 'ada') {
                        $alert = 'Pasien sudah membuat rencana pulang';
                    } else {
                        $alert = 'Tagihan Pasien Sudah Lunas. Anda tidak dapat melakukan transaksi ini.';
                    }
                    if (!empty($data->kamarruangan_nokamar)) {
                        if (empty($data->renPulang)) {
                            echo "Kmr : " . $data->kamarruangan_nokamar .
                                "<br>" . "Bed : " .
                                $data->kamarruangan_nobed; 
                                /* .
                                CHtml::link("<i class='icon-form-ubah'></i>", "", array(
                                    "href" => "",
                                    "rel" => "tooltip",
                                    "title" => "Klik untuk Memindahkan Bed Pasien",
                                    "onclick" => "{buatSessionMasukKamar(" . $data->masukkamar_id . "," . $data->kelaspelayanan_id . "," . $data->pendaftaran_id . "); addMasukKamar(); $('#dialogMasukKamar').dialog('open');}return false;"
                                ));
                                */
                        } else {
                            echo "Kmr : " . $data->kamarruangan_nokamar .
                                "<br>" . "Bed : " .
                                $data->kamarruangan_nobed; /* .
                                CHtml::link("<i class='icon-form-ubah'></i>", "javascript:;", array(
                                    "href" => "",
                                    "rel" => "tooltip",
                                    "title" => "Klik untuk Memindahkan Bed Pasien",
                                    "onclick" => 'myAlert("' . $alert . '","Perhatian")'
                                )); */
                        }
                    } else {
                        echo "<span class=\"no_kamar\">" . CHtml::link("<i class=icon-form-kamar></i>", "", array("href" => "", "rel" => "tooltip", "title" => "Klik untuk Memasukkan Pasien Ke Kamar", "onclick" => "{buatSessionMasukKamar(" . $data->masukkamar_id . "," . $data->kelaspelayanan_id . "," . $data->pendaftaran_id . "); addMasukKamar(); $('#dialogMasukKamar').dialog('open');}return false;"));
                    }
                    /*
                    echo "<hr>";
                    $cekPembayaran = (PasienpulangT::model()->cekSisaPembayaran($data->pendaftaran_id) == false) ? 'ada' : 'tidak';
                    if ($cekPembayaran == 'ada') {
                        $alert = 'Pasien sudah membuat rencana pulang';
                    } else {
                        $alert = 'Tagihan Pasien Sudah Lunas. Anda tidak dapat melakukan transaksi ini.';
                    }
                    if (empty($data->renPulang)) {
                        if (!empty($data->pasienpulang_id)) {
                            echo $data->carakeluar;
                        } else {
                            if (!empty($data->kamarruangan_nokamar)) {
                                $time_masukkamar = strtotime($data->tglmasukkamar);
                                echo CHtml::link("<i class='icon-form-pindahkamar'></i> ", Yii::app()->controller->createUrl(Yii::app()->controller->id . '/PindahKamarPasienRI', array("pendaftaran_id" => $data->pendaftaran_id)), array("title" => "Klik untuk Pindah Kamar", "target" => "iframePindahKamar", "onclick" => "validasiDialogPindahKamar(" . $data->pendaftaran_id . ", " . $time_masukkamar . "); return false;", "rel" => "tooltip"));
                            } else {
                                echo CHtml::link("<i class='icon-form-pindahkamar'></i> ", "#", array("title" => "Klik untuk Pindah Kamar", "target" => "iframePindahKamar", "onclick" => "myAlert('Pasien belum masuk kamar.'); return false;", "rel" => "tooltip"));
                            }
                        }
                    } else {
                        echo CHtml::link("<i class='icon-form-pindahkamar'></i> ", "#", array("title" => "Klik untuk Pindah Kamar", "target" => "iframePindahKamar", "onclick" => "myAlert('" . $alert . "','Perhatian'); return false;", "rel" => "tooltip"));
                    }
                    */
                    echo "<hr>";
                    if ($data->PindahanDari->pindahkamar_id == "") {
                        echo "Bukan Pindahan";
                    } else {
                        echo   "Rg:" . $data->PindahanDari->ruangan->ruangan_nama . " Kmr :" . $data->PindahanDari->kamarruangan->kamarruangan_nokamar . " Bed:" . $data->PindahanDari->kamarruangan->kamarruangan_nobed . "<br>" .
                            ($data->TindakanDanObat["ada"] ? CHtml::link("Sedang Diperiksa", "#", array("title" => "Silakan batalkan dulu " . $data->TindakanDanObat["msg"] . "!")) : CHtml::link("<i class=icon-remove-sign></i>", "#", array("rel" => "tooltip", "title" => "Klik untuk Batal Pindah Kamar", "onclick" => "batalPindahKamar(" . $data->PindahanDari->pindahkamar_id . "," . $data->PindahanDari->masukkamar_id . ");")));
                    }
                },
            ),
            array(
                'header' => 'Jawaban Konsultasi',
                'type' => 'raw',
                
                'value' => function ($data) {

                    if (empty($data->konsulpoli_id)) {
                        echo "";
                        return;
                    }

                    $konsul = KonsulpoliT::model()->findByPk($data->konsulpoli_id);

                    $class_ada_jawab = !empty($konsul->jawaban_konsul) ? "ada_jawab" : "";

                    if ($data->getAsalPoli()) {
                        echo $data->getAsalPoli();
                        echo '<div class="small-container '.$class_ada_jawab.'">';
                        echo  CHtml::link('<i class="icon-form-rkontrol"></i><br>Jawaban <br>Konsultasi', Yii::app()->controller->createUrl(Yii::app()->controller->id . "/KonsultasiInternal", array("konsulpoli_id" => $data->getKonsulPasien())), array("title" => "Klik untuk Jawab Kontrol Internal", "target" => "iframeKonsulInternal", "onclick" => '$("#konsultasiInternal").dialog("open");', "rel" => "tooltip"));
                        echo '</div>';
                    } else {
                        echo $data->getAsalPoli();
                        echo $data->getAsalRuangan();
                        echo '<div class="small-container '.$class_ada_jawab.'">';
                        echo  CHtml::link('<i class="icon-form-rkontrol"></i><br>Jawaban <br>Konsultasi', Yii::app()->controller->createUrl(Yii::app()->controller->id . "/KonsultasiInternal", array("konsulpoli_id" => $data->getKonsulPasien())), array("title" => "Klik untuk Jawab Kontrol Internal", "target" => "iframeKonsulInternal", "onclick" => '$("#konsultasiInternal").dialog("open");', "rel" => "tooltip"));
                        echo '</div>';
                        
                        echo '</br>';
                    }
                    
                } 
            ),
            array(
                'name' => 'Periksa Pasien',
                'type' => 'raw',
                'value' => function ($data) {
                    
                    if (!empty($data->kamarruangan_nokamar)) {
                        echo '<div class="small-container">';

                        $link = Yii::app()->controller->createUrl("/rawatInap/pemeriksaanPasien", array("pendaftaran_id" => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id));

                        if($data->is_titipan) {
                            $link = Yii::app()->controller->createUrl("/rawatInap/pemeriksaanPasien", array("pendaftaran_id" => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id, 'is_titipan' => 1));
                        }
                        echo CHtml::link("<i class='icon-form-periksa'></i><br>Periksa Pasien", $link, array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk Pemeriksaan Pasien"));
                        echo '</div>';
                    } else {
                        echo '<div class="small-container">';
                        echo (CHtml::link("<i class='icon-form-periksa'></i><br>Periksa Pasien", "#", array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Pemeriksaan Pasien", "onclick" => "myAlert('Pasien belum masuk kamar.'); return false;")));
                        echo '</div>';
                    }
                    
                    $mod = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                    $anamnesa = AnamnesaT::model()->findByAttributes(array(
                        'pendaftaran_id' => $mod->pendaftaran_id,
                        'create_ruangan' => $mod->ruangan_id,
                    ), array(
                        'condition' => 'skrining_dewasa = true or skrining_anak = true',
                        'order' => 'anamesa_id desc'
                    ));
                    return '<div class="small-container">';
                },
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
            array(
                'name' => 'Rekam Medis Elektronik',
                'type' => 'raw',
                // 'value' => '',
                'value' => function ($data) {
                    $link =  CHtml::link("<i class='icon-form-konsulgizi'></i><br>Asuhan Gizi", Yii::app()->controller->createUrl('/rawatInap/asuhanGiziPasien/index', array(
                        'pendaftaran_id' => $data->pendaftaran_id,
                        'pasienadmisi_id' => $data->pasienadmisi_id,
                    )), array('rel' => "tooltip", "title" => "Klik untuk Asuhan Gizi")) . '<br><br><hr>'; 

                    // icon perawat
                    $link .= CHtml::link('<img src="' . Yii::app()->getBaseUrl('webroot') . '/images/icon/nurse.png" style="width:30px;height:30px;cursor: not-allowed !important; opacity: 30%;"><br>Perawat / Bidan ', 'javascript:;', array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan rekam medik elektronik oleh perawat", 'class' => 'disabled-link'));
                    // Yii::app()->controller->createUrl("RekamMedikElektronikPasienRI/index", array("pendaftaran_id" => $data->pendaftaran_id, 'type' => 'Perawat'))

                    // garis pembatas
                    $link .= '<br><br><hr>';

                    // icon verifikasi apoteker
                    $link .= CHtml::link('<i class="icon-form-stockopname"></i><br>Verifikasi Apoteker', $this->createUrl('/rawatInap/verifikasiApoteker/index', ['pendaftaran_id' => $data->pendaftaran_id, 'pasienadmisi_id' => $data->pasienadmisi_id]), array());
                    
                    return $link;
                },
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
            array(
                'name' => 'Riwayat Vaksinasi/<br>Imunisasi',
                'type' => 'raw',
                // 'value' => '',
                'value' => function ($data) {
                    return CHtml::link('<i class="icon-form-detail"></i><br>Imunisasi', Yii::app()->controller->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/updateRiwayatVaksinasi', array(
                        'pendaftaran_id' => $data->pendaftaran_id,
                    )), array(
                        'target' => 'frameRiwayatVaksinasi',
                        'onclick' => "$('#dialogRiwayatVaksinasi').dialog('open');",
                    ));
                },
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
            array(
                'header' => 'Kalkulator Infus',
                'type' => 'raw',
                'value' => function ($data) {
                    echo '<div class="small-container">';
                    echo CHtml::link(
                        "<i style='font-size: 22px !important;' class='entypo-tag'></i><br>Label Gelang",
                        Yii::app()->controller->createUrl("/rawatInap/pasienRawatInap/labelGelang", array("pendaftaran_id" => $data->pendaftaran_id)),
                        array(
                            "id" => "$data->no_pendaftaran",
                            "rel" => "tooltip",
                            "title" => "Klik untuk melihat label gelang pasien",
                            "target" => "frameLabelGelang",
                            "onclick" => "$('#dialogLabelGelang').dialog('open');"
                        )
                    );
                    echo "</div>";
                    echo '<div class="small-container">';
                    echo CHtml::link(
                        "<i style='font-size: 22px !important;' class='entypo-newspaper'></i><br>Kalkulator Infus",
                        Yii::app()->controller->createUrl("/rawatInap/KalkulatorInfus/Index", array("pendaftaran_id" => $data->pendaftaran_id, "iframe" => 1)),
                        array(
                            "id" => "$data->no_pendaftaran",
                            "rel" => "tooltip",
                            "title" => "Klik untuk menggunakan kalkulator infus",
                            "target" => "frameKalkulator",
                            "onclick" => "$('#dialogKalkulator').dialog('open');"
                        )
                    );
                    echo "</div>";
                },
                'htmlOptions' => array('style' => 'text-align: center; width:60px')
            ),

            // tambahan Rincian Tagihan
            array(
                'header' => 'Rincian Tagihan/<br> Riwayat Obat',
                'type' => 'raw',
                'value' => function ($data) {
                    return  CHtml::Link("<i class=\"icon-form-detailtagihan\"></i><br>Rincian", Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayar", array("instalasi_id" => $data->instalasi_id, "pendaftaran_id" => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id, "frame" => true))) . "<br>" . CHtml::link('<i class="icon-form-reseptur"></i><br>Riwayat Obat', Yii::app()->controller->createUrl('/farmasiApotek/informasiResepPasien/riwayatObat', array('id' => $data->pendaftaran_id)), array(
                        'target' => 'frameRiwayatObat',
                        'onclick' => "$('#dialogRiwayatObat').dialog('open');",
                    ));
                },
                'htmlOptions' => array(
                    "nowrap" => "",
                    'style' => 'text-align: center;',
                )

            ),

            array(
                'header' => 'Tindak Lanjut',
                'type' => 'raw',
                'value' => function ($data) use ($is_validasi_pja) {
                    $url = !empty($data->kamarruangan_nokamar) ? Yii::app()->controller->createUrl("/rawatInap/verifikasiTindakan", array("pendaftaran_id" => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id)) : "#";
                    $click = !empty($data->kamarruangan_nokamar) ? "return true" : "myAlert('Pasien belum masuk kamar.'); return false;";
                    // echo (CHtml::link("<i class='icon-form-detailtagihan'></i><br>Verifikasi Tindakan", $url, array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Verifikasi Tindakan Pasien", "onclick" => $click)));
                    $bayar = PembayaranpelayananT::model()->findByAttributes(array(
                        'pasienadmisi_id'=>$data->pasienadmisi_id
                    ), array(
                        'condition'=>'orderbatalpembayaranpelayanan_id is null'
                    ));
                    $cekPembayaran = !empty($bayar) ? "tidak" : "ada"; //(PasienpulangT::model()->cekSisaPembayaran($data->pendaftaran_id) == false) ? 'ada' : 'tidak';
                    $tindakan = TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')), array(
                        'condition' => 'karcis_id is null'
                    ));
                    $linkPJA = '';
                    if ($is_validasi_pja) {

                        $linkBatalPJA = CHtml::link(
                            '<i class="icon-form-silang"></i><br/>Batal PJA', '#', array(
                                "id" => "$data->pendaftaran_id",
                                "rel" => "tooltip",
                                "title" => "Klik untuk Batal Validasi PJA",
                                "onclick" => "batalPJA(".$data->pendaftaran_id.", '".$data->no_pendaftaran."'); return false;",
                            )
                        );

                        $triaseObat = PengambilanobatTriageT::model()->findAllByAttributes(array(
                            'pendaftaran_id'=>$data->pendaftaran_id,
                        ), array(
                            'condition'=>'is_jual = false'
                        ));
    
                        $onClickPJA = 'verifikasiPJADialog('.$data->pendaftaran_id.'); return false;';
    
                        if (count($triaseObat) > 0) {
                            $onClickPJA = "myAlert('Reseptur Triage belum di verifikasi'); return false;";
                        }

                        $modResume = ResumemedisR::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id, 'pasienadmisi_id' => $data->pasienadmisi_id]);


                        if (!empty($data->pasienpulang_id) && $data->carakeluar_id == Params::CARAKELUAR_ID_MENINGGAL) {
                            $pulang = PasienpulangT::model()->findByPk($data->pasienpulang_id);
                            if (!empty($pulang) && !$pulang->isapprovaltindaklanjut) {
                                $onClickPJA = "myAlert('PJA IKF belum melakukan validasi'); return false;";
                            }
                        }


                        // var_dump($modResume->resumemedis_id);
                        if(empty($modResume)) {
                            $onClickPJA = 'myAlert("Resume medis belum diterbitkan oleh dokter"); return false;';
                        }

    
                        $linkPJA = CHtml::link(
                            '<i class="icon-form-detail"></i><br/>Validasi PJA', '#', array(
                                "id" => "$data->pendaftaran_id",
                                "rel" => "tooltip",
                                "title" => "Klik untuk Validasi PJA",
                                "onclick" => $onClickPJA,
                            )
                        );

                        $crPJA = new CDbCriteria;
                        $crPJA->compare('pendaftaran_id', $data->pendaftaran_id);
                        $crPJA->compare('ruangan_id_approvaltindaklanjut', Yii::app()->user->getState('ruangan_id'));
                        $crPJA->addCondition('isapprovaltindaklanjut = true');

                        $crPJAOA = clone $crPJA;

                        //$crPJA->addCondition("tgl_tindakan > '".$data->tgladmisi."'");
                        //$crPJAOA->addCondition("tglpelayanan > '".$data->tgladmisi."'");

                        $tindakanPJA = TindakanpelayananT::model()->count($crPJA);
                        $oaPJA = ObatalkespasienT::model()->count($crPJAOA);


                        $tindakanPJABelum = TindakanpelayananT::model()->countByAttributes(array(
                            'pendaftaran_id'=>$data->pendaftaran_id,
                        ), array(
                            'condition'=>'isapprovaltindaklanjut = false or isapprovaltindaklanjut is null'
                        ));
                        $oaPJABelum = ObatalkespasienT::model()->countByAttributes(array(
                            'pendaftaran_id'=>$data->pendaftaran_id,
                        ), array(
                            'condition'=>'isapprovaltindaklanjut = false or isapprovaltindaklanjut is null'
                        ));

                        // var_dump($oaPJABelum, $tindakanPJABelum);

                        if (($tindakanPJABelum + $oaPJABelum == 0) && ($tindakanPJA + $oaPJA > 0)) {
                            $tindakanPJA = TindakanpelayananT::model()->find($crPJA);
                            $oaPJA = ObatalkespasienT::model()->find($crPJAOA);
    
                            // cek apakah sudah di-verifikasi
                            $crPJA->addCondition('verifikasitagihan_id is not null');
                            $crPJAOA->addCondition('verifikasitagihan_id is not null');
                            $tindakanPJAVerif = TindakanpelayananT::model()->count($crPJA);
                            $oaPJAVerif = ObatalkespasienT::model()->count($crPJAOA);
    
                            $pegPJA = PegawaiM::model()->findByPk($tindakanPJA->userapprovaltindaklanjut_id ?? $oaPJA->userapprovaltindaklanjut_id);
                            $namapja = $pegPJA->namaLengkap ?? "Validasi PJA";
                            $tgl_verif = $tindakanPJA->tanggal_approvaltindaklanjut ?? $oaPJA->tanggal_approvaltindaklanjut;
    
                            if (!empty($tgl_verif)) {
                                $namapja .= "<br/>".MyFormatter::formatDateTimeForUser($tgl_verif);
                            }
    
                            $linkPJA = CHtml::link('<i class="icon-form-check"></i><br/>'.$namapja, '#', array(
                                'onclick'=>'return false',
                            ));
    
                            // if ($tindakanPJAVerif + $oaPJAVerif == 0) {
                                $linkPJA .= "<br/>".$linkBatalPJA;
                            // }
                        }

                      

                    }
                    // echo "<hr>";
                    if (empty($data->kamarruangan_nokamar)) {
                        echo "Belum Masuk Kamar";
                    } else {
                        if (!empty($data->pasienpulang_id)) {
                            echo $data->carakeluar;
                            $modPasienPulang = PasienpulangT::model()->findByPk($data->pasienpulang_id);
                            if ($cekPembayaran == 'ada') {
                                $linkPJA = $linkPJA;
                            } else {
                                $linkPJA = 'CLOSING BILLING';
                            }
                            return $modPasienPulang->carakeluar->carakeluar_nama . '<hr><br>' . $linkPJA;
                        } else {
                            // icon pemulangan pasien
                            if($data->rencanacarakeluar_id != 4) {
                                if ($cekPembayaran == 'ada') {
                                    echo CHtml::link("<i class='icon-form-pulang'></i><br>Pemulangan", "javascript:;", array(
                                        "title" => "Klik untuk Pemulangan Pasien",
                                        "onclick" => "myAlert('Tagihan pasien belum diselesaikan di Kasir','Perhatian')"
                                    ));
                                } else {
                                    echo CHtml::link("<i class='icon-form-pulang'></i>", Yii::app()->controller->createUrl(Yii::app()->controller->id . '/TindakLanjutDariPasienRI', array("pendaftaran_id" => $data->pendaftaran_id, 'pasienadmisi_id' => $data->pasienadmisi_id)), array(
                                        "title" => "Klik untuk Pemulangan Pasien", "target" => "iframeTindakLanjut",
                                        "onclick" => "verifikasiPulangPasien(" . $data->pendaftaran_id . ")", "rel" => "tooltip"
                                    )) . '<br> Pemulangan';
                                }
                                echo "<hr>";
                            }


                            if (!empty($data->renPulang)) {
                               
                                if ($cekPembayaran == 'ada') {
                                    echo '<b>Rencana Pulang : </b>' . MyFormatter::formatDateTimeForUser($data->renPulang);
                                    echo "<br>";
                                    echo CHtml::link("<i class='icon-form-silang'></i> ", 'javascript:;', array("title" => "Klik untuk Batal Rencana Pulang Pasien", "onclick" => "batalRencanaPulang(" . $data->pasienadmisi_id . ")", "rel" => "tooltip"));
                                
                                    if ($is_validasi_pja) {
                                        echo "<hr/>".$linkPJA;
                                    }
                
                                } else {
                                    echo "CLOSING BILLING";
                                }
                            } else {
                                if (empty($tindakan)) {
                                    echo CHtml::link("<i class='icon-form-rencanapulang'></i><br>Rencana Pulang", "#", array(
                                        "title" => "Klik untuk Rencana Pulang Pasien", "target" => "iframeRencanaPulang",
                                        "onclick" => "myAlert('Pasien belum memiliki tindakan di ruangan ini.','Perhatian'); return false;", "rel" => "tooltip"
                                    ));
                                } else {
                                    if($data->rencanacarakeluar_id == Params::CARAKELUAR_ID_MENINGGAL) {
                                        echo "<br>";
                                        echo CHtml::link("<i class='icon-form-ambiljenazah'></i><br>Meninggal", "javascript:;", array(
                                            "title" => "Klik untuk Menyatakan Pasien Meninggal",
                                            "onclick" => "cekVerifikasiMeninggal(" . $data->pendaftaran_id . ", ".$data->pasienadmisi_id.");", "rel" => "tooltip"
                                        ));
                                        echo "<hr>";
                                    } else if(empty($data->rencanacarakeluar_id)){
                                        // rencana pulang
                                        echo CHtml::link("<i class='icon-form-rencanapulang'></i><br>Rencana Pulang", Yii::app()->controller->createUrl(Yii::app()->controller->id . '/RencanaPulangPasienRI', array("idPasienadmisi" => $data->pasienadmisi_id)), array(
                                            "title" => "Klik untuk Rencana Pulang Pasien", "target" => "iframeRencanaPulang",
                                            "onclick" => "verifikasiRencanaPulang(" . $data->pendaftaran_id . ")", "rel" => "tooltip"
                                        ));
                                        echo "<br>";
                                        // meninggal
                                        echo CHtml::link("<i class='icon-form-ambiljenazah'></i><br>Meninggal", "javascript:;", array(
                                            "title" => "Klik untuk Menyatakan Pasien Meninggal",
                                            "onclick" => "cekVerifikasiMeninggal(" . $data->pendaftaran_id . ", ".$data->pasienadmisi_id."); false;", "rel" => "tooltip"
                                        ));
                                        echo "<hr>";
                                    } else {
                                        // rencana pulang
                                        echo CHtml::link("<i class='icon-form-rencanapulang'></i><br>Rencana Pulang", Yii::app()->controller->createUrl(Yii::app()->controller->id . '/RencanaPulangPasienRI', array("idPasienadmisi" => $data->pasienadmisi_id)), array(
                                            "title" => "Klik untuk Rencana Pulang Pasien", "target" => "iframeRencanaPulang",
                                            "onclick" => "verifikasiRencanaPulang(" . $data->pendaftaran_id . ")", "rel" => "tooltip"
                                        ));
                                        echo "<br>";
                                    }
                                }
                            }
                            echo "<br>";
                        }
                    }
                },
                'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
            ),
            array(
                'header' => 'Pemindahan Pasien',
                'type' => 'raw',
                'value' => function ($data) {
                    $htmlLink = CHtml::link('<i class="icon-form-detail"></i><br>Transfer', Yii::app()->createUrl('/rawatInap/pemindahanPasienRI/index', array('pendaftaran_id' => $data->pendaftaran_id)), array(
                        'rel' => 'tooltip',
                        'title' => 'Pemindahan Pasien',
                    ));

                    $modFormTransfer = PemindahanpasienT::model()->findAllByAttributes(array('ruangantujuan_id' => Yii::app()->user->getState("ruangan_id"), 'pendaftaran_id' => $data->pendaftaran_id), array('condition' => '(ispasienditerima IS NULL OR ispasienditerima = false)'));
                    $linkPenerima = "";
                    if (isset($modFormTransfer) && count($modFormTransfer) > 0) {
                        $linkPenerima = CHtml::link('<i class="icon-form-check"></i><br>Terima Transfer', Yii::app()->createUrl("/rawatInap/pemindahanPasienRI/index", array("pendaftaran_id" => $data->pendaftaran_id, 'pasienditerima' => 'diterima')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Penerimaan Pemindahaan Pasien"));
                    }

                    $modPemindahanPasien = PemindahanpasienT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id));
                    if (!empty($modPemindahanPasien)) {
                        $linkLihat = CHtml::link(
                            '<icon class="icon-form-detail"></icon><br>Lihat Trasnfer',
                            $this->createUrl("/bedahSentral/pemindahanPasienBS/detail", array("pemindahanpasien_id" => $modPemindahanPasien->pemindahanpasien_id)),
                            array(
                                "target" => "frameDetail",
                                "onclick" => "$('#dialogDetail').dialog('open');",
                                "rel" => "tooltip",
                                "title" => "Klik untuk Melihat Detail Riwayat Pemindahaan Pasien",

                            )
                        );
                    } else {
                        $linkLihat = "";
                    }

                    return $htmlLink . '<br/>' . $linkPenerima . '<br>' . $linkLihat;
                },
                'htmlOptions' => array('style' => 'text-align: center; width:40px'),
            ),
            array(
                'header' => 'Status Dokumen',
                'type' => 'raw',
                'value' => function ($data) {
                    $ruangan_id = Yii::app()->user->getState('ruangan_id');
                    $status_dokumen = RIPendaftaranT::model()->findByPk($data->pendaftaran_id);
                    $dok =   CHtml::link("<icon class='icon-file' style='font-size:48px;'></icon><br>File Rekam Medik<br>", Yii::app()->controller->createUrl('/rawatJalan/DaftarPasien/riwayatDokfilerm', array('pendaftaran_id' => $data->pendaftaran_id)), array("target" => "frameRiwayatDokfilerm", "rel" => "tooltip", "title" => "Klik untuk melihat File Rekam Medik", "onclick" => "$('#dialogDokFilerm').dialog('open');"));
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

                    if ($status_dokumen->statusdokrm == "SUDAH DITERIMA") {
                        if ($status_dokumen->pengirimanrm->ruanganpenerima_id == Yii::app()->user->getState('ruangan_id')) {
                            return CHtml::link("<i></i> $status_dokumen->statusdokrm", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/statusDokumenKirim', array("pengirimanrm_id" => $status_dokumen->pengirimanrm_id, "pendaftaran_id" => $data->pendaftaran_id)), array(
                                "class" => "btn btn-primary",
                                "target" => "frameStatusDokumen",
                                "rel" => "tooltip",
                                "title" => "Klik untuk mengirim dokumen ke ruangan lain",
                                "onclick" => '$("#dialogStatusDokumen").dialog("open");'
                            )) . '<br><br>' . $dok . '<br><br>' . $pelayanan;
                        } else {
                            return $data->getStatusDokumen($status_dokumen->pengirimanrm_id, $status_dokumen->statusdokrm, $data->pendaftaran_id) . '<br><br>' . $dok . '<br><br>' . $pelayanan;
                        }
                    } else {
                        return $data->getStatusDokumen($status_dokumen->pengirimanrm_id, $status_dokumen->statusdokrm, $data->pendaftaran_id) . '<br><br>' . $dok . '<br><br>' . $pelayanan;
                    }
                },
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
            array(
                'header' => 'Batal Rawat',
                'type' => 'raw',
                'value' => function ($data) {
                    $pen = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                    $cekPembayaran = (PasienpulangT::model()->cekSisaPembayaran($data->pendaftaran_id) == false) ? 'ada' : 'tidak';
                    $cekDok = false;
                    if (!empty($pen->pengirimanrm_id)) {
                        if (Yii::app()->user->getState('ruangan_id') == $pen->pengirimanrm->ruanganpenerima_id) {
                            if (empty($pen->pengirimanrm->tglterimadokrm)) {
                                return CHtml::link('<i class="icon-form-silang"></i>', "javascript:;", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", 'data-placement' => 'left', 'onclick' => 'myAlert("Harap terima dan kembalikan dokumen RM sebelum Anda membatalkan pemeriksaan pasien ' . $data->nama_pasien . ' ","Perhatian")'));
                            } else {
                                return CHtml::link('<i class="icon-form-silang"></i>', "javascript:;", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", 'data-placement' => 'left', 'onclick' => 'myAlert("Harap kembalikan dokumen RM sebelum Anda membatalkan pemeriksaan pasien ' . $data->nama_pasien . ' ","Perhatian")'));
                            }
                        } else {
                            $cekDok = true;
                        }
                    } else {
                        $cekDok = true;
                    }
                    if ($cekDok == true) {
                        if ($cekPembayaran == 'ada') {
                            $alert = 'Pasien sudah membuat rencana pulang';
                        } else {
                            $alert = 'Tagihan Pasien Sudah Lunas. Anda tidak dapat melakukan transaksi ini.';
                        }
                        if (empty($data->renPulang)) {
                            echo CHtml::link("<i class='icon-form-silang'></i>", Yii::app()->controller->createUrl(Yii::app()->controller->id . '/batalRawatInap', array("pendaftaran_id" => $data->pendaftaran_id, 'pasienadmisi_id' => $data->pasienadmisi_id)), array(
                                "title" => "Klik untuk Batal Rawat Inap", "target" => "iframeBatalRawatInap",
                                "onclick" => "$('#dialogBatalRawatInap').dialog('open');", "rel" => "tooltip"
                            ));
                        } else {
                            echo CHtml::link("<i class='icon-form-silang'></i>", "javascript:;", array(
                                "title" => "Klik untuk Batal Rawat Inap",
                                "onclick" => "myAlert('" . $alert . "','Perhatian')", "rel" => "tooltip"
                            ));
                        }
                    }
                },
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
            
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
?>

<?php echo $this->renderPartial('_dialogVerifikasiPJA', array(), true); ?>