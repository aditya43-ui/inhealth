<?php

    $is_validasi_pja = (Yii::app()->user->getState('kelompokpegawai_id') != 1)
    || (Yii::app()->user->name == 'sysadmin');

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'daftarPasien-grid',
        'dataProvider' => $model->searchPI(),
        'replaceUrl' => true,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-condensed table-bordered',
        'columns' => array(
            array(
                'header' => 'Tanggal Admisi / Masuk Kamar',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tglAdmisiMasukKamar)'
            ),
            array(
                'name' => 'caramasuk_nama',
                'type' => 'raw',
                'value' => '$data->caramasuk_nama',
            ),
            array(
                'header' => 'No. RM / No. Pendaftaran',
                'type' => 'raw',
                'value' => '$data->noRmNoPend',
            ),
            array(
                'header' => 'NIK/Nama Pasien / Alias/Tanggal Lahir/Jenis Kelamin/Umur',
                'value' => function ($data) {
                    echo "<b>".$data->no_identitas_pasien."</b>";
                    echo "<br>";
                    echo $data->namaPasienNamaBin;
                    echo "<br>";
                    echo MyFormatter::formatDateTimeForUser($data->tanggal_lahir);
                    echo "<br>";
                    echo $data->jeniskelamin;
                    echo "<br>";
                    echo CHtml::hiddenField("PIInfokunjunganriV[$data->pendaftaran_id][pendaftaran_id]", $data->pendaftaran_id, array("id" => "pendaftaran_id", "onkeypress" => "return $(this).focusNextInputField(event)", "class" => "span3")) . "" . $data->umur;
                    
                }
            ),
            array(
                'header' => 'Dokter Penerima/Kelas Pelayanan/Alergi Obat',
                'type' => 'raw',
                'value' => function ($data) {
                    echo "<div style='width:100px;'>" . CHtml::link("<i class=icon-pencil-brown></i> " . $data->gelardepan . " " . $data->nama_pegawai . " " . $data->gelarbelakang_nama, " ", array("onclick" => "ubahDokterPeriksa('$data->pendaftaran_id','$data->pasienadmisi_id');$('#editDokterPeriksa').dialog('open');return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Mengubah Data Dokter Periksa")) . "</div>";
                    echo "<hr>";
                    echo $data->kelaspelayanan_nama;
                    echo "<hr>";
                    echo $data->AlergiObat;
                },
            ),
            array(
                'header' => 'DPJP / PPDS',
                'type' => 'raw',
                'value' => function ($data) {
                    $nama = "<br>";
                    if (!empty($data->dpjp1_id)) {
                        $pegawai = PegawaiM::model()->findByPk($data->dpjp1_id);
                        $nama .= "DPJP 1 : " . $pegawai->namaLengkap . "</br>";
                    }
                    if (!empty($data->dpjp2_id)) {
                        $pegawai = PegawaiM::model()->findByPk($data->dpjp2_id);
                        $nama .= "DPJP 2 : " . $pegawai->namaLengkap . "</br>";
                    }
                    if (!empty($data->dpjp3_id)) {
                        $pegawai = PegawaiM::model()->findByPk($data->dpjp3_id);
                        $nama .= "DPJP 3 : " . $pegawai->namaLengkap . "</br>";
                    }
                            if(Yii::app()->user->getState('isppds')) {
                    echo CHtml::link(
                        '<i class="icon-pencil-brown"></i>Tambah PPDS',
                            Yii::app()->controller->createUrl(Yii::app()->controller->id . "/create", array("pendaftaran_id" => $data->pendaftaran_id)),
                            array("title" => "Klik untuk Tambah PPDS", "target" => "iframeDetailPPDS", "onclick" => '$("#dialogDetailPPDS").dialog("open");', "rel" => "tooltip")
                        );
                        $ppds = PasienPpdsT::model()->findAllByAttributes(array(
                            'pendaftaran_id' => $data->pendaftaran_id
                        ));

                        $itemz ='';      
                        $x =1;   
                        
                        foreach($ppds as $itemz){
                            echo '<br>';
                            echo '<i class="icon-pencil-brown"></i>PPDS &nbsp;',$x++.'-'.$itemz->ppds->ppds_nama;
                            }                                       
                        }
                            echo "<br>";
                    if (empty($data->renPulang)) {
                        return '<div style="width:100px;">' . CHtml::link(
                            '<i class="icon-pencil-brown"></i> ' . $nama,
                            " ",
                            array("onclick" => 'ubahDokterPeriksa2("' . $data->pendaftaran_id . '","' . $data->pasienadmisi_id . '");$("#editDokterPeriksa2").dialog("open"); $("#dialog-dpjp-m-grid").hide();return false;', "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Mengubah Data DPJP")
                        ) . "</div>";

                            
                    } else {
                        return $nama;
                    }
                    
                }, //'"<div style=\'width:100px;\'>" . CHtml::link("<i class=icon-pencil-brown></i> ". $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama," ",array("onclick"=>"ubahDokterPeriksa(\'$data->pendaftaran_id\',\'$data->pasienadmisi_id\');$(\'#editDokterPeriksa\').dialog(\'open\'); $(\'#dialog-dpjp-m-grid\').hide();return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Mengubah Data Dokter PJP")) . "</div>"',
            ),
            array(
                'header' => 'Jenis Penjamin / Penjamin',
                'value' => '$data->caraBayarPenjamin',
            ),
            array(
                'name' => 'jeniskasuspenyakit_nama',
                'type' => 'raw',
                'value' => '',
                'htmlOptions' => array(
                    'style' => 'text-align: center;',
                    'class' => 'list_kasus_penyakit'
                )
            ),
            
            array(
                'header' => 'No. Kamar/Ruangan<br>No. Bed',
                'name' => 'kamarruangan_nokamar',
                'type' => 'raw',
                'value' => '(!empty($data->kamarruangan_nokamar))? "Kmr : ".$data->kamarruangan_nokamar."<br>"."Ruangan : ".$data->ruangan_nama."<br>"."Bed : ".$data->kamarruangan_nobed.CHtml::link("<i class=icon-form-kamar></i>","",array("href"=>"","rel"=>"tooltip","title"=>"Klik untuk Memasukan Pasien Ke kamar","onclick"=>"{buatSessionMasukKamar($data->masukkamar_id,$data->kelaspelayanan_id,$data->pendaftaran_id); addMasukKamar(); $(\'#dialogMasukKamar\').dialog(\'open\');}return false;")) : CHtml::link("<i class=icon-form-kamar></i>","",array("href"=>"","rel"=>"tooltip","title"=>"Klik untuk Memasukan Pasien Ke kamar","onclick"=>"{buatSessionMasukKamar($data->masukkamar_id,$data->kelaspelayanan_id,$data->pendaftaran_id); addMasukKamar(); $(\'#dialogMasukKamar\').dialog(\'open\');}return false;"))',
                'htmlOptions' => array('style' => 'text-align: center;'),
            ),
            array(
                'header' => 'Jawaban Konsultasi',
                'type' => 'raw',
                //                        'value'=>'$data->statusperiksa.CHtml::link("<i class=icon-pencil></i>","",array("href"=>"","rel"=>"tooltip","title"=>"Klik untuk Mengubah Status Periksa","onclick"=>"{buatSessionUbahStatus($data->pendaftaran_id); ubahStatusPeriksa(); $(\'#dialogUbahStatus\').dialog(\'open\');}return false;"))',
                'value' => function ($data) {

                    if (empty($data->konsulpoli_id)) {
                        echo "-";
                        return;
                    }

                    $konsul = KonsulpoliT::model()->findByPk($data->konsulpoli_id);

                    $class_ada_jawab = !empty($konsul->jawaban_konsul) ? "ada_jawab" : "";

                    if ($data->getAsalPoli()) {
                        echo $data->getAsalPoli();
                        echo '<div class="small-container" '.$class_ada_jawab.'>';
                        echo  CHtml::link('<i class="icon-form-rkontrol"></i><br>Jawaban <br>Konsultasi', Yii::app()->controller->createUrl("/rawatInap/pasienRawatInap/KonsultasiInternal", array("konsulpoli_id" => $data->getKonsulPasien())), array("title" => "Klik untuk Jawab Kontrol Internal", "target" => "iframeKonsulInternal", "onclick" => '$("#konsultasiInternal").dialog("open");', "rel" => "tooltip"));
                        echo '</div>';
                    } else {
                        echo $data->getAsalPoli();
                        echo $data->getAsalRuangan();
                        echo '<div class="small-container" '.$class_ada_jawab.'>';
                        echo  CHtml::link('<i class="icon-form-rkontrol"></i><br>Jawaban <br>Konsultasi', Yii::app()->controller->createUrl("/rawatInap/pasienRawatInap/KonsultasiInternal", array("konsulpoli_id" => $data->getKonsulPasien())), array("title" => "Klik untuk Jawab Kontrol Internal", "target" => "iframeKonsulInternal", "onclick" => '$("#konsultasiInternal").dialog("open");', "rel" => "tooltip"));
                        echo '</div>';
                        // echo '<br>';
                        // echo '<div class="small-container">';
                        // echo  CHtml::link('<i class="icon-form-rkontrol"></i><br>Masukkan <br>Hasil Pemeriksaan', Yii::app()->controller->createUrl(Yii::app()->controller->id . "/TindakanInternal", array("ruangtindakan_id" => $data->getAsalRuangan())), array("title" => "Klik untuk Jawab Tindakan Internal", "target" => "iframeTindakanInternal", "onclick" => '$("#tindakanInternal").dialog("open");', "rel" => "tooltip"));
                        // echo '</div>';
                        echo '</br>';
                    }
                    /* 
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
                    */
                    // echo (!empty($data->asalpoliklinikkonsul_id)?$data->asalpoli->ruangan_nama:'');
                } //'$data->getStatus($data->statusperiksa,$data->pendaftaran_id)',
            ),
            /*
            array(
                'header' => 'Pindah Ruangan',
                'type' => 'raw',
                'value' => '((!empty($data->pasienpulang_id)) ? $data->carakeluar : CHtml::link("<i class=\'icon-form-pindahkamar\'></i><br>Pindah Kamar",Yii::app()->controller->createUrl("' . Yii::app()->controller->id . '/PindahKamarPasienPI",array("pendaftaran_id"=>$data->pendaftaran_id)) ,array("title"=>"Klik untuk Pindah Kamar","target"=>"iframePindahKamar", "onclick" => "validasiDialogPindahKamar(".$data->pendaftaran_id.", ".strtotime($data->tglmasukkamar)."); return false;", "rel"=>"tooltip")))',
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
            */
            array(
                'header' => 'Pindahan Dari',
                'type' => 'raw',
                'value' => '($data->PindahanDari->pindahkamar_id == "") ?  "Bukan Pindahan" : 
                        "Rg:".(isset($data->PindahanDari->ruangan->ruangan_nama) ? $data->PindahanDari->ruangan->ruangan_nama : "")." Kmr :".(isset($data->PindahanDari->kamarruangan->kamarruangan_nokamar) ? $data->PindahanDari->kamarruangan->kamarruangan_nokamar : "")." Bed:".(isset($data->PindahanDari->kamarruangan->kamarruangan_nobed) ? $data->PindahanDari->kamarruangan->kamarruangan_nobed : "")."<br>".
                        ($data->TindakanDanObat["ada"] ? CHtml::link("Sedang Diperiksa", "#",array("title"=>"Silakan batalkan dulu ".$data->TindakanDanObat["msg"]."!")) : CHtml::link("<i class=icon-remove-sign></i>","#",array("rel"=>"tooltip","title"=>"Klik untuk Batal Pindah Kamar","onclick"=>"batalPindahKamar(".$data->PindahanDari->pindahkamar_id.",".$data->PindahanDari->masukkamar_id.");")))
                    ',
            ),
            array(
                'name' => 'Periksa Pasien',
                'type' => 'raw',
                'value' => function ($data) {
                    $cekPembayaran = (PasienpulangT::model()->cekSisaPembayaran($data->pendaftaran_id) == false) ? 'ada' : 'tidak';
                    if ($cekPembayaran == 'ada') {
                        $alert = 'Pasien sudah membuat rencana pulang';
                    } else {
                        $alert = 'Tagihan Pasien Sudah Lunas. Anda tidak dapat melakukan transaksi ini.';
                    }
                    echo '<div class="small-container">';
                    echo CHtml::link("<i class='icon-form-rj'></i><br>Asesmen Pasien", Yii::app()->controller->createUrl("/rawatJalan/pemeriksaanAsesmenPasienRJ", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Asesmen Pasien Rawat Jalan"));
                    echo '</div>';
                    if (empty($data->renPulang)) {
                        if (!empty($data->kamarruangan_nokamar))
                            echo CHtml::link("<i class='icon-form-periksa'></i><br>Periksa Pasien", Yii::app()->controller->createUrl("/perawatanIntensif/pemeriksaanPasien", array("pendaftaran_id" => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id)), array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk Pemeriksaan Pasien"));
                        else
                            echo (CHtml::link("<i class='icon-form-periksa'></i><br>Periksa Pasien", "#", array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Pemeriksaan Pasien", "onclick" => "myAlert('Pasien belum masuk kamar.'); return false;")));
                    } else {
                        echo CHtml::link("<i class='icon-form-periksa'></i><br>Periksa Pasien", Yii::app()->controller->createUrl("/perawatanIntensif/pemeriksaanPasien", array("pendaftaran_id" => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id)), array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk Pemeriksaan Pasien"));
                        //echo CHtml::link("<i class='icon-form-periksa'></i> <br>Periksa Pasien", 'javascript:;', array("rel" => "tooltip", "title" => "Klik untuk Pemeriksaan Pasien", 'onclick' => 'myAlert("' . $alert . '")', "Perhatian"));
                    }
                    echo "<hr>";
                    echo  CHtml::link(
                        "<i  style='font-size:20px' class='entypo-newspaper'></i> <br> Kalkulator Infus",
                        Yii::app()->controller->createUrl("/perawatanIntensif/KalkulatorInfusPI/Index", array("pendaftaran_id" => $data->pendaftaran_id, "iframe" => 1)),
                        array(
                            "id" => "$data->no_pendaftaran",
                            "rel" => "tooltip",
                            "title" => "Klik untuk menggunakan kalkulator infus",
                            "target" => "frameKalkulator",
                            "onclick" => "$('#dialogKalkulator').dialog('open');"
                        )
                    );
                }, //'(CHtml::link("<i class=\'icon-form-periksa\'></i> ", Yii::app()->controller->createUrl("/perawatanIntensif/pemeriksaanPasien",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien")))',
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
            array(
                'name' => 'Rekam Medis Elektronik',
                'type' => 'raw',
                // 'value' => '',
                'value' => function ($data) {
                    // icon dokter
                    $link = CHtml::link('<img src="' . Yii::app()->getBaseUrl('webroot') . '/images/icon/doctor.png" style="width:30px;height:30px;"><br>Dokter ', Yii::app()->controller->createUrl("RekamMedikElektronikPasienPI/index", array("pendaftaran_id" => $data->pendaftaran_id, 'type' => 'Dokter')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan rekam medik elektronik oleh dokter")) . '<br><br><hr>';

                    // icon perawat
                    $link .= CHtml::link('<img src="' . Yii::app()->getBaseUrl('webroot') . '/images/icon/nurse.png" style="width:30px;height:30px;cursor: not-allowed !important;opacity:30%"><br>Perawat / Bidan ', 'javascript:;', array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan rekam medik elektronik oleh perawat"));
                    // Yii::app()->controller->createUrl("RekamMedikElektronikPasienPI/index", array("pendaftaran_id" => $data->pendaftaran_id, 'type' => 'Perawat'))

                    // icon asuhan gizi
                    $link .=  '<br>' . CHtml::link("<i class='icon-form-konsulgizi'></i><br>Asuhan Gizi", Yii::app()->controller->createUrl('/rawatInap/asuhanGiziPasien/index', array(
                        'pendaftaran_id' => $data->pendaftaran_id,
                        'pasienadmisi_id' => $data->pasienadmisi_id,
                    )), array('rel' => "tooltip", "title" => "Klik untuk Asuhan Gizi")) . '<br><br><hr>';

                    // icon verifikasi obat
                    $link .= CHtml::link('<i class="icon-form-stockopname"></i><br>Verifikasi Obat', $this->createUrl('/rawatInap/verifikasiApoteker/index', ['pendaftaran_id' => $data->pendaftaran_id]), array()) . "<br><br>";

                    return $link;
                },
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
            array(
                'name' => 'Riwayat Vaksinasi/Imunisasi',
                'type' => 'raw',
                // 'value' => '',
                'value' => function ($data) {
                    return CHtml::link('<i class="icon-form-detail"></i><br>Vaksinasi', Yii::app()->controller->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/updateRiwayatVaksinasi', array(
                        'pendaftaran_id' => $data->pendaftaran_id,
                    )), array(
                        'target' => 'frameRiwayatVaksinasi',
                        'onclick' => "$('#dialogRiwayatVaksinasi').dialog('open');",
                    ));
                },
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
            
            array(
                //                           'header'=>'Pulangkan Pasien <br> Rencana Pulang',
                'header' => 'Tindak Lanjut',
                'type' => 'raw',
                'value' => function ($data) use ($is_validasi_pja) {

                    $bayar = PembayaranpelayananT::model()->findByAttributes(array(
                        'pasienadmisi_id'=>$data->pasienadmisi_id
                    ), array(
                        'condition'=>'orderbatalpembayaranpelayanan_id is null'
                    ));
                    $cekPembayaran = !empty($bayar) ? "tidak" : "ada";


                    $linkPJAPengkap = "";
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

                        if(empty($modResume)) {
                            $onClickPJA = 'myAlert("Resume medis belum diterbitkan oleh dokter"); return false;';
                        }

                        if (!empty($data->pasienpulang_id) && $data->carakeluar_id == Params::CARAKELUAR_ID_MENINGGAL) {
                            $pulang = PasienpulangT::model()->findByPk($data->pasienpulang_id);
                            if (!empty($pulang) && !$pulang->isapprovaltindaklanjut) {
                                $onClickPJA = "myAlert('PJA IKF belum melakukan validasi'); return false;";
                            }
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
    
                            if ($tindakanPJAVerif + $oaPJAVerif == 0) {
                                $linkPJA .= "<br/>".$linkBatalPJA;
                            }
                        }

                        $linkPJAPengkap .= "<hr/>".$linkPJA;

                    }


                    if (empty($data->kamarruangan_nokamar)) {
                        return "Belum Masuk Kamar";
                    } else {
                        if (!empty($data->pasienpulang_id)) {
                            
                            $modPasienPulang = PasienpulangT::model()->findByPk($data->pasienpulang_id);
                            return $modPasienPulang->carakeluar->carakeluar_nama . '<hr></br>' . $linkPJAPengkap;
                            
                        } else {
                            $cekPembayaran = (PasienpulangT::model()->cekSisaPembayaran($data->pendaftaran_id) == false) ? 'ada' : 'tidak';
                            $tindakan = TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')), array(
                                'condition' => 'karcis_id is null'
                            ));
                            if ($cekPembayaran == 'ada') {
                                if($data->rencanacarakeluar_id != Params::CARAKELUAR_ID_MENINGGAL) {
                                    echo CHtml::link("<i class='icon-form-pulang'></i><br>Pulangkan Pasien", "#", array(
                                        "title" => "Klik untuk Pemulangan Pasien",
                                        //"onclick" => "myAlert('Tagihan pasien belum diselesaikan di Kasir','Perhatian')"));
                                        "onclick" => "periksaPembayaranUntukPulang(" . $data->pendaftaran_id . "); return false;"
                                    ));
                                }
                            } else {
                                echo CHtml::link("<i class='icon-form-pulang'></i> ", Yii::app()->controller->createUrl(Yii::app()->controller->id . '/TindakLanjutDariPasienPI', array("pendaftaran_id" => $data->pendaftaran_id)), array(
                                    "title" => "Klik untuk Pemulangan Pasien", "target" => "iframeTindakLanjut",
                                    "onclick" => "verifikasiPulangPasien(" . $data->pendaftaran_id . ")", "rel" => "tooltip"
                                ));
                            }
                            if (!empty($data->renPulang)) {
                                if ($cekPembayaran == 'ada') {
                                    echo  '<hr><br><b>Rencana Pulang : </b>'. MyFormatter::formatDateTimeForUser($data->renPulang);
                                    echo "<br>";
                                    echo CHtml::link("<i class='icon-form-silang'></i> ", 'javascript:;', array("title" => "Klik untuk Batal Rencana Pulang Pasien", "onclick" => "batalRencanaPulang(" . $data->pasienadmisi_id . ")", "rel" => "tooltip"));
                                
                                    echo $linkPJAPengkap;
                                
                                } else {
                                    echo "CLOSING BILLING";
                                }
                            } else {
                                if (empty($tindakan)) {
                                    echo "<br>";
                                    echo CHtml::link("<i class='icon-form-rencanapulang'></i><br>Rencana Pulang ", "#", array(
                                        "title" => "Klik untuk Rencana Pulang Pasien", "target" => "iframeRencanaPulang",
                                        "onclick" => "myAlert('Pasien belum memiliki tindakan di ruangan ini.','Perhatian'); return false;", "rel" => "tooltip"
                                    ));
                                } else {
                                    if($data->rencanacarakeluar_id == Params::CARAKELUAR_ID_MENINGGAL) {
                                        echo "<br>";
                                        echo CHtml::link("<i class='icon-form-ambiljenazah'></i><br>Meninggal", "#", array(
                                            "title" => "Klik untuk Menyatakan Pasien Meninggal",
                                            "onclick" => "cekVerifikasiMeninggal(" . $data->pendaftaran_id . "); false;", "rel" => "tooltip"
                                        ));
                                        echo $linkPJAPengkap;
                                    } else if(empty($data->rencanacarakeluar_id)){
                                        echo "<br>";
                                        echo CHtml::link("<i class='icon-form-rencanapulang'></i><br>Rencana Pulang ", Yii::app()->controller->createUrl(Yii::app()->controller->id . '/RencanaPulangPasienPI', array("idPasienadmisi" => $data->pasienadmisi_id)), array(
                                            "title" => "Klik untuk Rencana Pulang Pasien", "target" => "iframeRencanaPulang",
                                            "onclick" => "verifikasiRencanaPulang(" . $data->pendaftaran_id . ")", "rel" => "tooltip"
                                        ));
                                        echo "<br>";
                                        echo CHtml::link("<i class='icon-form-ambiljenazah'></i><br>Meninggal", "#", array(
                                            "title" => "Klik untuk Menyatakan Pasien Meninggal",
                                            "onclick" => "cekVerifikasiMeninggal(" . $data->pendaftaran_id . "); false;", "rel" => "tooltip"
                                        ));
                                    } else {
                                        echo "<br>";
                                        echo CHtml::link("<i class='icon-form-rencanapulang'></i><br>Rencana Pulang ", Yii::app()->controller->createUrl(Yii::app()->controller->id . '/RencanaPulangPasienPI', array("idPasienadmisi" => $data->pasienadmisi_id)), array(
                                            "title" => "Klik untuk Rencana Pulang Pasien", "target" => "iframeRencanaPulang",
                                            "onclick" => "verifikasiRencanaPulang(" . $data->pendaftaran_id . ")", "rel" => "tooltip"
                                        ));
                                        echo $linkPJAPengkap;
                                    }
                                }
                            }
                        }
                    }
                },
                'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
            ),
            array(
                'header' => 'Pemindahan Pasien',
                'type' => 'raw',
                'value' => function($data) {
                    $htmlLink = CHtml::link('<i class="icon-form-detail"></i><br>Transfer', Yii::app()->createUrl('/perawatanIntensif/pemindahanPasienPI/index', array('pendaftaran_id'=>$data->pendaftaran_id)), array(
                        'rel'=>'tooltip',
                        'title'=>'Pemindahan Pasien',
                    ));
    
                    $modFormTransfer = PemindahanpasienT::model()->findAllByAttributes(array('ruangantujuan_id'=>Yii::app()->user->getState("ruangan_id"),'pendaftaran_id'=>$data->pendaftaran_id),array('condition'=>'(ispasienditerima IS NULL OR ispasienditerima = false)'));
                    $linkPenerima = "";
                    if(isset($modFormTransfer) && count($modFormTransfer) > 0){
                        $linkPenerima = CHtml::link('<i class="icon-form-check"></i> <br>Penerimaan Pasien', Yii::app()->createUrl("/perawatanIntensif/pemindahanPasienPI/index",array("pendaftaran_id"=>$data->pendaftaran_id,'pasienditerima'=>'diterima')),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Penerimaan Pemindahaan Pasien"));
                    }

                    $modPemindahanPasien = PemindahanpasienT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id));
                    if (!empty($modPemindahanPasien)) {
                        $linkLihat = CHtml::link(
                            '<icon class="icon-form-detail"></icon><br>Lihat Transfer',
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
    
                    return $htmlLink .'<br/>'.$linkPenerima.'<br>'.$linkLihat;
                },
                'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
            ), 
            array(
                'header' => 'Rincian Tagihan',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-detailtagihan\"></i><br>Rincian Tagihan",Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayar",array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id,"frame"=>true)),
                array("class"=>"", 
                    "target"=>"iframeRincianTagihan",
                    "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                    "rel"=>"tooltip",
                    "title"=>"Klik untuk melihat Rincian Tagihan",
                ))',
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
            
            array(
                'header' => 'Rincian Tagihan Sudah Bayar',
                'type' => 'raw',
                'value' => '
                                    CHtml::link("<icon class=\'icon-form-detail\'></icon><br>Rincian Sudah Bayar", Yii::app()->controller->createUrl("' . Yii::app()->controller->id . '/RincianPembayaranPasien", array("pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincianSudahBayar", "onclick"=>"$(\'#dialogRincianSudahBayar\').dialog(\'open\');"))',
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
            array(
                'header' => 'Status Dokumen',
                'type' => 'raw',
                'value' => function ($data){
                    return CHtml::link("<i class='icon-file' style='margin: 7px;'></i><br>File Rekam Medis", Yii::app()->controller->createUrl('PasienRawatIntensif/riwayatDokfilerm', array('pendaftaran_id' => $data->pendaftaran_id)), array("target" => "frameRiwayatDokfilerm", "rel" => "tooltip", "title" => "Klik untuk melihat File Rekam Medis", "onclick" => "$('#dialogDokFilerm').dialog('open');"));
                }
                
            ),
            [
                'header' => 'Riwayat Periksa Pasien',
                'type' => 'raw',
                'value' => function($data) {
                    echo  CHtml::link(
                        '<i class="icon-form-lihat"></i> Lihat Riwayat',
                        Yii::app()->controller->createUrl("/rawatJalan/pemeriksaanPasien", array("pendaftaran_id" => $data->pendaftaran_id, 'lihat' => 1)),
                        array(
                            "rel" => "tooltip",
                            "title" => "Klik untuk melihat riwayat pasien",
                            "target" => "blank",
                        )
                    );
                }
            ],
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
                            return CHtml::link("<i class='icon-form-silang'></i>", Yii::app()->controller->createUrl(Yii::app()->controller->id . '/batalRawatInap', array("pendaftaran_id" => $data->pendaftaran_id)), array(
                                "title" => "Klik untuk Batal Rawat Intensif", "target" => "iframeBatalRawatInap",
                                "onclick" => "$('#dialogBatalRawatInap').dialog('open');", "rel" => "tooltip"
                            ));
                        } else {
                            return CHtml::link("<i class='icon-form-silang'></i>", "javascript:;", array(
                                "title" => "Klik untuk Batal Rawat Intensif",
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