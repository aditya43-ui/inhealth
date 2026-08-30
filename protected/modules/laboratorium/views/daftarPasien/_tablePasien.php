<?php 
    $autoopen = Yii::app()->user->getState('isantrian');
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $this->widget('ext.bootstrap.widgets.MergeHeaderGroupGridView', array(
        'id' => 'daftarpasien-v-grid',
        'dataProvider' => $daftar,
        'replaceUrl' => true,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
        'mergeHeaders'=>array(
            /*
            array(
                'name'=>'Masukkan Hasil',
                'headerHtmlOptions'=>array('style'=>'background-color:#4bb1cf;'),
                'start'=>10, 
                'end'=>11, 
            ),
            */
        ),
        'columns' => array(
            array(
                'name' => 'no_urutperiksa',
                'type' => 'raw',
                'header' => 'No. Antrian/<br>Panggil Antrian',
                'value' => 'isset($data->waktumulaiperiksa) ? $data->ruangan_singkatan."-".$data->no_urutperiksa : $data->ruangan_singkatan."-".$data->no_urutperiksa."<br>
                            <span class=\"badge badge-info pull-right badge-status\">".$data->jml_panggil."</span>".CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-volume-up icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(\"$data->pasienmasukpenunjang_id\",\"$data->jml_panggil\",\"$data->ruangan_singkatan\",\"$data->no_urutperiksa\",\"$data->ruangan_id\");","rel"=>"tooltip","title"=>"Klik untuk Panggil Antrian"))
                            ',
                'visible' => $autoopen
            ),
            // array(
            //     'name' => 'pasienkirimkeunitlain_id',
            //     'type' => 'raw',
            //     'header' => 'pasienkirimkeunitlain_id',
            //     'value' => '$data->pasienkirimkeunitlain_id',
            // ),
            // array(
            //     'name' => 'pasienmasukpenunjang_id',
            //     'type' => 'raw',
            //     'header' => 'pasienmasukpenunjang_id',
            //     'value' => '$data->no_mobilepj',
            // ),
            // array(
            //     // 'name' => 'pasien_id',
            //     'type' => 'raw',
            //     'header' => 'pasien_id',
            //     'value' => function ($data) {
            //         if(!empty($data->pasienmasukpenunjang_id)){
            //             $pasienmasukpenunjang = PasienmasukpenunjangT::model()->findByPk($data->pasienmasukpenunjang_id); 
            //             $modKirimUnitlain = PasienkirimkeunitlainT::model()->findByPk($data->pasienkirimkeunitlain_id);
            //             // $masukpenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(
            //             //   array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id)
            //             // );
            //             // $modKirimUnitlain = PasienkirimkeunitlainT::model()->findByPk($pasienmasukpenunjang->pasienkirimkeunitlain_id);
            //             $pegawai = PegawaiM::model()->findByPk($data->dokterasal_id);
            //             // $pegawai = PegawaiM::model()->findByAttributes(array('nama_pegawai'=>$modKirimUnitlain->nama_pegawai));
            //             // $pasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($data->pasienmasukpenunjang_id);
            //             // $modPasienPenunjang = $pasienMasukPenunjang->pasien;
            //             // $modPasien = LBPasienM::model()->findByPk($modPasienPenunjang->pasien_id);
            //             echo $data->pasienmasukpenunjang_id .'<br>';
            //             // echo $pasienmasukpenunjang->pasienkirimkeunitlain_id;
            //             echo !empty($pegawai->nomobile_pegawai)?$pegawai->nomobile_pegawai:'';
            //             echo !empty($pegawai->pegawai_id)?$pegawai->pegawai_id:'';
            //             // echo !empty($modKirimUnitlain->nama_pegawai)?$modKirimUnitlain->nama_pegawai:'';
            //             // echo !empty($pegawai->nama_pegawai)?$pegawai->nama_pegawai:'';
            //         }else{
            //             echo '-';
            //         }
            //         // echo !empty($data->pasien->no_mobile_pasien?$data->pasien->no_mobile_pasien:"-");
            //     }
            //         // 'value' => '$data->pasien->no_mobile_pasien?$data->pasien->no_mobile_pasien:""',
            // ),
            // array(
            //     'name' => 'pasien_id',
            //     'type' => 'raw',
            //     'header' => 'pasien_id',
            //     'value' => '$data->pasien_id',
            // ),
            // // 'tgl_pendaftaran',
            // /*array(
            // 				'name'=>'no_urutperiksa',
            // 				'type'=>'raw',
            // 				'header'=>'No. Antrian/<br>Panggil Antrian',
            // 				'value'=>'$data->ruangan_singkatan."-".$data->no_urutperiksa."<br>".CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-volume-up icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(\"$data->pasienmasukpenunjang_id\"); setSuaraPanggilanSingle(\"$data->ruangan_singkatan\",\"$data->no_urutperiksa\",\"$data->ruangan_id\")","rel"=>"tooltip","title"=>"Klik untuk memanggil pasien ini"))'
            // 			),*/
            array(
                'header' => 'Tgl. Pendaftaran<br>No. Pendaftaran',
                'name' => 'tgl_pendaftaran',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."<br>".$data->no_pendaftaran',
            ),
            array(
                'header' => 'Tgl. Masuk Penunjang<br>No. Penunjang',
                'name' => 'no_masukpenunjang',
                'type' => 'raw',
                //'value'=>'(($data->statusperiksahasil != "SUDAH") ? CHtml::link("<i class=\"icon-form-ubah\"></i><br>".MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)."<br>".$data->no_masukpenunjang,Yii::app()->controller->createUrl("pemeriksaanPasienLaboratorium/index",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk Mengubah Pemeriksaan")) : MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)."<br>".$data->no_masukpenunjang)',
                'value' => function ($data) {
                    if ($data->statusPeriksaDaftar == Params::STATUSPERIKSA_SUDAH_PULANG || $data->statusPeriksaDaftar == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) {
                        if ($data->statusPeriksaDaftar == Params::STATUSPERIKSA_SUDAH_PULANG) {
                            return MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang) . "/<br>" . $data->no_masukpenunjang;
                        } else {
                            return (($data->statusperiksahasil != "SUDAH") ? CHtml::link("<i class=\"icon-form-ubah\"></i><br>" . MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang) . "<br>" . $data->no_masukpenunjang, "javascript:;", array("rel" => "tooltip", "title" => "Klik untuk Mengubah Pemeriksaan", 'onclick' => 'myAlert("Anda tidak dapat menginput hasil pemeriksan, karena status pasien ' . $data->statusPeriksaDaftar . '","Perhatian !")')) : MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang) . "<br>" . $data->no_masukpenunjang);
                        }
                    } else {
                        return (($data->statusperiksahasil != "SUDAH") ? CHtml::link("<i class=\"icon-form-ubah\"></i><br>" . MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang) . "<br>" . $data->no_masukpenunjang, Yii::app()->controller->createUrl("pemeriksaanPasienLaboratorium/index", array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)), array("rel" => "tooltip", "title" => "Klik untuk Mengubah Pemeriksaan")) : MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang) . "<br>" . $data->no_masukpenunjang);
                    }
                }
            ),
            array(
                'header' => 'Nama Perujuk/<br>Dokter Perujuk/<br>Diagnosa',
                'name' => 'ruanganasal_nama',
                'type' => 'raw',
                'value' => function ($data) {
                    echo !empty($data->nama_perujuk)?$data->nama_perujuk.'/<br/>':' - /<br/>';
                    $pegawai = PegawaiM::model()->findByAttributes(array(
                        'nama_pegawai' => $data->nama_dokterasal,
                    ));
                    echo (empty($pegawai) ? " - / <br/>" : $pegawai->namaLengkap)  . " / <br>";
                    

                    $criteria = new CDbCriteria();
                    $criteria->select = 'd.diagnosa_nama';
                    $criteria->join = 'JOIN diagnosa_m d ON t.diagnosa_id = d.diagnosa_id';
                    $criteria->addCondition('pendaftaran_id = ' . $data->pendaftaran_id);
                    $query = LBPasienMorbiditasT::model()->findAll($criteria);

                    $diagnosa_nama = '';
                    $keterangan = '';
                    if (count((array)$query) > 0) {
                        $ket = [];
                        foreach ($query as $key => $value) {
                            if ($value->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_UTAMA && empty($diagnosa_nama)) {
                                $diagnosa_nama = $value->diagnosa_nama;
                            }else{                                            
                                $title = '- ' . $value->diagnosa_nama;
                                array_push($ket, $title);
                                $keterangan = implode("<br>",$ket);
                            }
                        }
                        
                        if (empty($diagnosa_nama)){
                            $diagnosa_nama = $query[0]->diagnosa_nama;
                            $keterangan = '';
                        }
                    }else{
                        $diagnosa_nama = '-';
                        $keterangan = '';
                    }

                    $diagnosa =  "<a title='$keterangan' rel='tooltip' href='javascript:;'>".$diagnosa_nama."</a>";
                    if (Params::TAMBAH_DIAGNOSA === TRUE) {
                        echo  CHtml::link(
                        $diagnosa,
                        Yii::app()->controller->createUrl(
                            Yii::app()->controller->id . '/diagnosa',
                            array("pendaftaran_id" => $data->pendaftaran_id)
                        ),
                        array(
                            "title" => $diagnosa,
                            "target" => "iframeDiagnosa",
                            "onclick" => "$(\"#dialogDiagnosa\").dialog(\"open\");",
                            "rel" => "tooltip"
                        )
                    );
                    }else{
                        echo $diagnosa;
                    }
                },
            ),
            array(
                'header' => 'Nama Pasien/NIK/No. RM/Tanggal Lahir/Jenis Kelamin/<br>Umur/Alamat',
                'type' => 'raw',
                // 'value'=> '((substr($data->no_rekam_medik,0,-6)) == "LB" || (substr($data->no_rekam_medik,0,-6)) == "RD" ? CHtml::link("<i class=\"icon-pencil\"></i>", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahPasien",array("id"=>"$data->pasien_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien"))." ".CHtml::link($data->nama_pasien.\' / \'.$data->nama_bin, Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahPasien",array("id"=>"$data->pasien_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien")) : $data->nama_pasien.\' / \'.$data->nama_bin )',
                'value' => function ($data) {
                    if ($data->instalasiasal_id == PARAMS::INSTALASI_ID_LAB) {
                        echo CHtml::link("<i class='icon-form-ubah'></i> " . "<b>".$data->namadepan . $data->nama_pasien."</b>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . "/ubahPasien", array("id" => $data->pasien_id, "pendaftaran_id" => $data->pendaftaran_id, "modul_id" => Yii::app()->session["modul_id"])), array("rel" => "tooltip", "title" => "Klik untuk mengubah data pasien"));
                    } else {
                        echo "<b>".$data->namadepan . $data->nama_pasien."</b>";
                    }
                    echo '<br>';
                    echo "<b>".$data->pasien_id."</b>";
                    echo '<br>';
                    echo "<b>".$data->no_rekam_medik."</b>";
                    echo "<br>";
                    echo MyFormatter::formatDateTimeForUser($data->tanggal_lahir);
                    echo "<br>";
                    echo $data->jeniskelamin . "/<br>" . $data->umur;
                    echo "<br>";
                    echo $data->alamat_pasien;
                },
            ),
            array(
                'header' => 'Dokter Pemeriksa',
                'type' => 'raw',
                // 'value'=>'($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>". $data->getNamaLengkapDokter($data->pegawai_id),Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/ApprovePemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk menyetujui pemeriksaan", "onclick"=>"return confirm(\"Apakah Anda akan menyetujui pemeriksaan ini?\");")) : $data->getNamaLengkapDokter($data->pegawai_id)',
                'value' => '($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>".$data->getNamaLengkapDokter($data->pegawaipenunjang_id), "javascript:approveperiksa($data->pendaftaran_id, $data->pasienmasukpenunjang_id)",array("rel"=>"tooltip","title"=>"Klik untuk menyetujui pemeriksaan")) : $data->getNamaLengkapDokter($data->pegawaipenunjang_id)',
            ),
            array(
                'header' => 'Ruangan Asal',
                'type' => 'raw',
                // 'value'=>'($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>". $data->getNamaLengkapDokter($data->pegawai_id),Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/ApprovePemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk menyetujui pemeriksaan", "onclick"=>"return confirm(\"Apakah Anda akan menyetujui pemeriksaan ini?\");")) : $data->getNamaLengkapDokter($data->pegawai_id)',
                'value' => function($data) {
                    $str = $data->ruanganasal_nama;

                    if (in_array($data->instalasiasal_id, Params::getArrayInstalasiInap())) {
                        $admisi = PasienadmisiT::model()->findByAttributes(array(
                            'pendaftaran_id'=>$data->pendaftaran_id,
                        ), array(
                            'join'=>'join pendaftaran_t p on p.pasienadmisi_id = t.pasienadmisi_id'
                        ));

                        if (!empty($admisi)) {
                            $kamar = MasukkamarT::model()->findByAttributes(array(
                                'pasienadmisi_id'=>$admisi->pasienadmisi_id,
                                'ruangan_id'=>$data->ruanganasal_id,
                            ));

                            $kelas = $admisi->kelaspelayanan;
                            $kamarruangan = $admisi->kamarruangan;

                            if (!empty($kamar)) {
                                $kelas = $kamar->kelaspelayanan;
                                $kamarruangan = $kamar->kamarruangan;
                            }




                            $str .= "<br/>".(!empty($kelas) ? $kelas->kelaspelayanan_nama : "-");
                            $str .= "<br/>".(!empty($kamarruangan) ? ($kamarruangan->kamarruangan_nokamar.":".$kamarruangan->kamarruangan_nobed) : "-");
                            
                        }


                    }




                    return $str;
                },
            ),
            array(
                'header' => 'Jenis Penjamin/<br>Penjamin',
                'name' => 'CaraBayarPenjamin',
                'type' => 'raw',
                'value' => '$data->caraBayarPenjamin',
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
            array(
                'header' => 'Status Periksa',
                'type' => 'raw',
                //'value' => function ($data){
                //	return Params::getWrStatusPeriksa($data->statusperiksa);
                //}
                'value' => 
                function ($data) {
                    $hasil = HasilpemeriksaanpaT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id));
                    if (!empty($hasil)) {
                        if(!empty($hasil->statushasilperiksapa)) {
                            echo '<button class="btn btn-primary nohover">'. $hasil->statushasilperiksapa.' DIPERIKSA</button>';
                        } else {
                            echo '<button class="btn btn-gold nohover btn-status">ANTRIAN</button>';
                        }
                    } else {
                        echo '<button class="btn btn-gold nohover btn-status">ANTRIAN</button>';
                    }
                    // if ($data->statusPeriksaDaftar == Params::STATUSPERIKSA_SUDAH_PULANG) {
                    //     echo Params::getWrStatusHasil($data->statusperiksahasil);
                    // } else {
                    //     echo ($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>" . $data->statusperiksahasil, "javascript:batalstatusperiksa(" . $data->pendaftaran_id . "," . $data->pasienmasukpenunjang_id . ")", array("rel" => "tooltip", "title" => "Klik untuk membatalkan varifikasi hasil pemeriksaan")) : ((empty($data->pasienbatalperiksa_id)) ? Params::getWrStatusHasil($data->statusperiksahasil) : "DIBATALKAN");
                    // }
                },
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                //'$data->getStatusLab($data->statusperiksa,$data->pendaftaran_id,$data->pasienmasukpenunjang_id)'
            ),
            /*
            array(
                'name' => 'Riwayat Vaksinasi/Imunisasi',
                'type' => 'raw',
                // 'value' => '',
                'value' => function ($data) {
                    return CHtml::link('<i class="icon-form-detail"></i>', Yii::app()->controller->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/updateRiwayatVaksinasi', array(
                        'pendaftaran_id' => $data->pendaftaran_id,
                    )), array(
                        'target' => 'frameRiwayatVaksinasi',
                        'onclick' => "$('#dialogRiwayatVaksinasi').dialog('open');",
                    ));
                },
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
            // // array(
            // // 	'header'=>'Status Print',
            // // 	'type'=>'raw',
            // // 	'value'=>'($data->printhasillab == true) ? "SUDAH" : "BELUM"',
            // // ),
            */
            array(
                'name' => 'ambilSample',
                'type' => 'raw',
                'value' => function ($data) use ($module, $controller) {
                    if ($data->statusPeriksaDaftar == Params::STATUSPERIKSA_SUDAH_PULANG || $data->statusPeriksaDaftar == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) {
                        if ($data->statusPeriksaDaftar == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) {
                            return CHtml::link("<i class='icon-form-ambilsample'></i>", 'javascript:;', array("rel" => "tooltip", "title" => "Klik untuk Mengubah Ambil Sampel", 'onclick' => 'myAlert("Anda tidak dapat menginput hasil pemeriksan, karena status pasien ' . $data->statusPeriksaDaftar . '","Perhatian !")'));
                        } elseif ($data->statusPeriksaDaftar == Params::STATUSPERIKSA_SUDAH_PULANG) {
                            return CHtml::link("<i class='icon-form-ambilsample'></i>", Yii::app()->controller->createUrl('/' . $module . '/' . $controller . '/updateSample', array("pendaftaran_id" => $data->pendaftaran_id, "pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)), array("rel" => "tooltip", "title" => "Klik untuk Mengubah Ambil Sampel"));
                        }
                    } else {
                        return ($data->statusperiksahasil != Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class='icon-form-ambilsample'></i>", Yii::app()->controller->createUrl('/' . $module . '/' . $controller . '/updateSample', array("pendaftaran_id" => $data->pendaftaran_id, "pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)), array("rel" => "tooltip", "title" => "Klik untuk Mengubah Ambil Sampel")) : CHtml::link("<i class='icon-form-ambilsample'></i>", 'javascript:;', array("rel" => "tooltip", "title" => "Klik untuk Mengubah Ambil Sampel", 'onclick' => 'myAlert("Anda tidak dapat menginput ambil sample karena status pemeriksaan hasil sudah di verifikasi ","Perhatian !")'));;
                    }
                },
                //  dicomment RND-5771
                // 'value'=>'($data->statusperiksahasil != Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>",Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/updateSample",array("pendaftaran_id"=>$data->pendaftaran_id,"idPengambilanSample"=>$data->pengambilansample_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk Mengubah Ambil Sampel")) : ""',    
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
            // // array(
            // //    'name'=>'masukanHasil',
            // //    'type'=>'raw',
            // //    'value'=>'(($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG || $data->statusperiksahasil == Params::STATUSPERIKSAHASIL_BELUM) ? CHtml::link("<i class=\"icon-pencil-brown\"></i>",Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/hasilPemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk Masukan Hasil Pemeriksaan")) 
            // //      : 
            // //      CHtml::link("<i class=\"icon-pencil-brown\"></i>",Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/hasilPemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk Masukan Hasil Pemeriksaan Lab Anatomi")))',    
            // //    'htmlOptions'=>array('style'=>'text-align: left; width:40px')
            // // ),
            // //TEST NEW
            array(
                'header' => 'HASIL',
                'name' => 'masukanHasil',
                'type' => 'raw',
                'value' => function ($data) {
                    if ($data->statusPeriksaDaftar == Params::STATUSPERIKSA_SUDAH_PULANG || $data->statusPeriksaDaftar == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) {
                        if ($data->statusPeriksaDaftar == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) {
                            echo CHtml::link("<i class='icon-form-input'></i>", "javascript:;", array("rel" => "tooltip", "title" => "Klik untuk Masukan Hasil Pemeriksaan Lab", 'onclick' => 'myAlert("Anda tidak dapat menginput hasil pemeriksan, karena status pasien ' . $data->statusPeriksaDaftar . '","Perhatian !")'));
                        } else {
                            echo CHtml::link("<i class='icon-form-input'></i>", Yii::app()->controller->createUrl("/laboratorium/pencatatanHasilPemeriksaan/index", array("id" => $data->pasienmasukpenunjang_id)), array("rel" => "tooltip", "title" => "Klik untuk Masukan Hasil Pemeriksaan Lab"));
                        }
                    } else {
                        echo (($data->statusperiksahasil != "SUDAH")
                            ? CHtml::link("<i class='icon-form-input'></i>", Yii::app()->controller->createUrl("/laboratorium/pencatatanHasilPemeriksaan/index", array("id" => $data->pasienmasukpenunjang_id)), array("rel" => "tooltip", "title" => "Klik untuk Masukan Hasil Pemeriksaan Lab"))
                            : CHtml::link("<i class='icon-form-input'></i>", 'javascript:;', array("rel" => "tooltip", "title" => "Hasil Pemeriksaan Lab sudah diinput", 'onclick' => 'myAlert("Anda tidak dapat menginput hasil pemerikasaan lab karena status pemeriksaan hasil sudah di verifikasi ","Perhatian !")'))
                            . "<br>" . CHtml::link("<i class='icon-form-ubah'></i>", Yii::app()->controller->createUrl("/laboratorium/pencatatanHasilPemeriksaan/index", array("id" => $data->pasienmasukpenunjang_id)), array("rel" => "tooltip", "title" => "Klik untuk Merubah Hasil Pemeriksaan Lab")));
                    }
                    // echo "<hr>";
                    // echo  CHtml::link(
                    //     "<i class='icon-form-input'></i> ",
                    //     Yii::app()->controller->createUrl(
                    //         Yii::app()->controller->id . '/diagnosa',
                    //         array("pendaftaran_id" => $data->pendaftaran_id)
                    //     ),
                    //     array(
                    //         "title" => "Klik untuk Masukkan Diagnosa",
                    //         "target" => "iframeDiagnosa",
                    //         "onclick" => "$(\"#dialogDiagnosa\").dialog(\"open\");",
                    //         "rel" => "tooltip"
                    //     )
                    // );TAMBAH_DIAGNOSA
                },
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
            /*
            array(
                'header' => 'TAT',
                'name' => 'respondtime',
                'type' => 'raw',
                // 'value' => '',
                'value' => function ($data) {

                    return "<a href='javascript:;' class='hover' rel='tooltip' title='TAT dihitung dari verifikasi pemeriksaan sampai masukkan hasil'>".(isset($data->respondtime) ? MyFormatter::formatDateTimeId($data->respondtime) : '-') . '</a>';
                },
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
            array(
                'name' => 'Upload Hasil Pemeriksaan Lab',
                'type' => 'raw',
                'value' => function ($data) {
                    return CHtml::link('<i class="icon-idokrekm"></i>', Yii::app()->controller->createUrl('/rekamMedis/ScanRM/Index', array(
                        'pendaftaran_id'=>$data->pendaftaran_id,                                        
                    )), array(
                        'target'=>'frameUploadFile',
                        'onclick'=>"$('#dialogUploadFile').dialog('open');",
                    ));
                },
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ), 
            */
            array(
                'header' => 'Status Hasil Lab/<br> Status Pemeriksaan Hasil',
                'type' => 'raw',
                'value' => function ($data) {
                    $hasil = HasilpemeriksaanpaT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id));
                    if (!empty($hasil)) {
                        if(!empty($hasil->statushasilperiksapa)) {
                            echo '<button class="btn btn-primary nohover">'. $hasil->statushasilperiksapa.' PEMERIKSAAN</button>';
                        } else {
                            echo '<button class="btn btn-primary nohover">BELUM PEMERIKSAAN</button>';
                        }
                    } else {
                        echo '<button class="btn btn-primary nohover">BELUM PEMERIKSAAN</button>';
                    }
                    if ($data->statusPeriksaDaftar == Params::STATUSPERIKSA_SUDAH_PULANG) {
                        echo Params::getWrStatusHasil($data->statusperiksahasil);
                    } else {
                        echo ($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>" . $data->statusperiksahasil, "javascript:batalstatusperiksa(" . $data->pendaftaran_id . "," . $data->pasienmasukpenunjang_id . ")", array("rel" => "tooltip", "title" => "Klik untuk membatalkan varifikasi hasil pemeriksaan")) : ((empty($data->pasienbatalperiksa_id)) ? Params::getWrStatusHasil($data->statusperiksahasil) : "DIBATALKAN");
                    }
                },
                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            ),
            // array(
            //     'header' => 'Status Hasil Lab/<br> Status Pemeriksaan Hasil',
            //     'type' => 'raw',
            //     'value' => function ($data) {
            //         $hasil = HasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id));
            //         if (!empty($hasil)) {
            //             if ($hasil->statushasilpemeriksaan == 'KRITIS') {
            //                 echo '<button class="btn btn-danger nohover">KRITIS</button>';
            //             } else if ($hasil->statushasilpemeriksaan == 'NORMAL') {
            //                 echo '<button class="btn btn-success nohover">NORMAL</button>';
            //             } else {
            //                 echo '<button class="btn btn-primary nohover">BELUM PEMERIKSAAN</button>';
            //             }
            //         } else {
            //             echo '<button class="btn btn-primary nohover">BELUM PEMERIKSAAN</button>';
            //         }
            //         if ($data->statusPeriksaDaftar == Params::STATUSPERIKSA_SUDAH_PULANG) {
            //             echo Params::getWrStatusHasil($data->statusperiksahasil);
            //         } else {
            //             echo ($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>" . $data->statusperiksahasil, "javascript:batalstatusperiksa(" . $data->pendaftaran_id . "," . $data->pasienmasukpenunjang_id . ")", array("rel" => "tooltip", "title" => "Klik untuk membatalkan varifikasi hasil pemeriksaan")) : ((empty($data->pasienbatalperiksa_id)) ? Params::getWrStatusHasil($data->statusperiksahasil) : "DIBATALKAN");
            //         }
            //     },
            //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            // ),
            array(
                'header' => 'Lihat Hasil',
                'type' => 'raw',
                'value' =>  function ($data) {
                    echo ((Yii::app()->user->getState("ruangan_id") == Params::RUANGAN_ID_LAB_KLINIK) ? 
                                CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("pencatatanHasilPemeriksaan/print",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id,"frame"=>1,"popup"=>"true")),
                                    array("class"=>"", 
                                        "target"=>"iframeLihatHasil",
                                        "onclick"=>"$(\"#dialogLihatHasil\").dialog(\"open\");",
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk melihat hasil pemeriksaan", 
                                    )) : 
                                CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("pencatatanHasilPemeriksaan/PrintPA",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id,"frame"=>1,"popup"=>"true")),
                                    array("class"=>"", 
                                        "target"=>"iframeLihatHasil",
                                        "onclick"=>"$(\"#dialogLihatHasil\").dialog(\"open\");",
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk melihat hasil pemeriksaan", 
                                    )))
                                    ."<hr>".

                                    CHtml::link("<i class='icon-bayarklaim'></i> ",  Yii::app()->controller->createUrl(
                                        "/rawatJalan/daftarPasien/hasilPemeriksaanPenunjang",
                                        array("id" => $data->pendaftaran_id, 'is_lab' => 1)
                                    ), array("id" => "$data->no_pendaftaran", "target" => "detailDialogPenunjang", "rel" => "tooltip", "title" => "Klik untuk Detail Hasil Pemeriksaan Penunjang", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailDataPenunjang').dialog('open');", "dialog-text" => "Riwayat Konsul Poliklinik"))
                                    ."<hr>".
                                (($data->pembayaranpelayanan_id != "") ? 
                                (($data->namapenerimahasil == "") ? 
                                    CHtml::Link("<i class=\"icon-form-verifikasi\"></i>",Yii::app()->controller->createUrl("daftarPasien/ambilHasil",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id,"hasilpemeriksaanlab_id"=>$data->hasilpemeriksaanlab_id,"frame"=>1,"popup"=>"true")),
                                        array("class"=>"", 
                                                "target"=>"iframeAmbilHasil",
                                                "onclick"=>"$(\"#dialogAmbilHasil\").dialog(\"open\");",
                                                "rel"=>"tooltip",
                                                "title"=>"Klik untuk Pengambilan Hasil", 
                                        )) : "Pengambilan Hasil ".MyFormatter::formatDateTimeForUser($data->tglpengambilanhasil) )
                                    : "")
                                    ."<hr>".
                                    CHtml::link("<i class=\"icon-chating\"></i>","javascript:verifkirim($data->pendaftaran_id, $data->pasienmasukpenunjang_id)",
                                        array("id" => $data->no_pendaftaran,
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk kirim Whatsapp ke pasien",
                                            "data-placement" => "left"
                                        )
                                    )
                                    ."<hr>".
                                    CHtml::link("<i class=\"icon-chating\"></i>","javascript:verifkirimdpjp($data->pendaftaran_id, $data->pasienmasukpenunjang_id)",
                                        array("id" => $data->no_pendaftaran,
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk kirim Whatsapp ke dokter",
                                            "data-placement" => "left"
                                        )
                );
                },
                'htmlOptions' => array('style' => 'text-align: center; width:60px')
            ),
            // array(
            //     'header' => 'Batal Periksa',
            //     'type' => 'raw',
            //     'value' => function ($data) {
            //         if ($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SUDAH) {
            //         } else {
            //             if ($data->statusPeriksaDaftar == Params::STATUSPERIKSA_SUDAH_PULANG) {
            //                 return CHtml::link("<i class='icon-form-silang'></i>", "javascript:;", array("rel" => "tooltip", "title" => "Klik untuk membatalkan pasien", 'onclick' => 'myAlert("Anda tidak dapat menginput hasil pemeriksan, karena status pasien ' . $data->statusPeriksaDaftar . '","Perhatian !")', 'data-placement' => 'left'));
            //             } else {
            //                 //return ($data->statusperiksahasil != Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class='icon-form-silang'></i>", "javascript:batalperiksa(".$data->pendaftaran_id.",".$data->pasienmasukpenunjang_id.")",array("id"=>$data->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk membatalkan Pemeriksaan","data-placement"=>"left")) : null;
            //                 return ($data->statusperiksahasil != Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class='icon-form-silang'></i>", 'javascript:dialogBatalPeriksa(' . $data->pendaftaran_id . ',' . $data->pasienmasukpenunjang_id . ',"' . $data->nama_pasien . '")', array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan pasien", "data-placement" => "left")) : CHtml::link("<i class='icon-form-silang'></i>", 'javascript:;', array("rel" => "tooltip", "title" => "Klik untuk membatalkan pasien", 'onclick' => 'myAlert("Anda tidak dapat menginput ambil sample karena status pemeriksaan hasil sudah di verifikasi ","Perhatian !")', 'data-placement' => 'left'));
            //             }
            //         }
            //     },
            //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            // ),
            [
                'header' => 'Upload Dokumen Pendukung',
                'type' => 'raw',
                'value' => function($data) {
                        $tombolUpload =  CHtml::link("Upload",$this->createUrl('/rekamMedis/scanRM/index', ['pendaftaran_id' => $data->pendaftaran_id, 'penunjang' => 'laboratorium']),
                            array("id" => $data->no_pendaftaran,
                                "rel" => "tooltip",
                                "title" => "Klik untuk kirim Whatsapp ke pasien",
                                "data-placement" => "left",
                                'class' => 'btn btn-success'
                            )
                        );

                        $dok = CHtml::link("<i class='icon-file' style='margin: 7px;'></i>", Yii::app()->controller->createUrl('/rawatJalan/DaftarPasien/riwayatDokfilerm', array('pendaftaran_id' => $data->pendaftaran_id)), array("target" => "frameRiwayatDokfilerm", "rel" => "tooltip", "title" => "Klik untuk melihat File Rekam Medis", "onclick" => "$('#dialogDokFilerm').dialog('open');"));


                        echo $tombolUpload . '<br><hr>' . $dok;
                }
            ],
            array(
                'header' => 'Cetak Ulang Nota Tindakan',
                'type' => 'raw',
                'value' => function($data) {
                    /*
                    return CHtml::link("<i class='icon-form-print'></i>",'javascript:void(0);', array(
                        'onclick'=>"printUlangNotaTindakan(". $data->pendaftaran_id .");return false",
                        'disabled'=>FALSE,
                        "rel"=>"tooltip",
                        "title"=>"Klik untuk Cetak Ulang Nota Tindakan",  ));
                    */
                    return  CHtml::link(
                            Yii::t(
                                'mds',
                                '{icon}',
                                array('{icon}' => '<i class="icon-form-print"></i>')
                            ),
                            Yii::app()->controller->createUrl("/rawatJalan/tindakan/printUlangTindakanPenunjangDialog", array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)),
                            array(
                                "title" => "Klik untuk Cetak Ulang Nota Tindakan", 
                                "target" => "iframeCetakUlang", 
                                "onclick" => '$("#dialogCetakUlang").dialog("open");', 
                                "rel" => "tooltip", 
                            ));
                }
            )
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )); ?>