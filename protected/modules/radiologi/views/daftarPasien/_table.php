<?php 

$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
    'id' => 'daftarpasien-v-grid',
    'dataProvider' => $modPasienMasukPenunjang->searchRAD(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'mergeHeaders' => array(
        array(
            'name' => 'Masukan Hasil',
            'headerHtmlOptions' => array('style' => 'background-color:#4bb1cf;'),
            'start' => 12,
            'end' => 13,
        ),
    ),
    'columns' => array(
        array(
            'name' => 'no_urutperiksa',
            'type' => 'raw',
            'header' => 'No. Antrian/<br>Panggil Antrian',
            //										'value'=>'$data->ruangan_singkatan."-".$data->no_urutperiksa."<br>".CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-volume-up icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(\"$data->pasienmasukpenunjang_id\"); setSuaraPanggilanSingle(\"$data->ruangan_singkatan\",\"$data->no_urutperiksa\",\"$data->ruangan_id\")","rel"=>"tooltip","title"=>"Klik untuk memanggil pasien ini"))',
            // 'value' => 'isset($data->waktumulaiperiksa) ? $data->ruangan_singkatan."-".$data->no_urutperiksa : $data->ruangan_singkatan."-".$data->no_urutperiksa."<br>
            //                                                                       <span class=\"badge badge-info pull-right badge-status\">".$data->jml_panggil."</span>".CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-volume-up icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(\"$data->pasienmasukpenunjang_id\",\"$data->jml_panggil\",\"$data->ruangan_singkatan\",\"$data->no_urutperiksa\",\"$data->ruangan_id\");","rel"=>"tooltip","title"=>"Klik untuk Panggil Antrian"))',

            'value' => function ($data) use (&$admisi) {
              $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));
           
              if(!empty($data->tgl_pasiendatang)){
               // echo CHtml::htmlButton(Yii::t("mds","<i class='icon-ok icon-white'></i>",array()),array("class"=>"btn btn-success","onclick"=>"verifikasiAntrian('".$data->pasienmasukpenunjang_id."');"));
                if($data->is_verifikasi = true){
                    echo '';
                }
                else{
                    echo CHtml::htmlButton(Yii::t("mds","<i class='icon-ok icon-white'></i>",array()),array("class"=>"btn btn-success","onclick"=>"verifikasiAntrian('".$data->pasienmasukpenunjang_id."');"));
                    
                }
              }else{
                echo CHtml::htmlButton(Yii::t("mds", "{icon}", array("{icon}" => "<i class='icon-volume-up icon-white'></i>")), array("style" => "z-index: -1;", "class" => "btn btn-primary", "onclick" => "panggilAntrian('" . $data->pasienmasukpenunjang_id . "','".$data->jml_panggil. "','". $data->ruangan_singkatan . "','". $data->no_urutperiksa .  "','" . $data->ruangan_id . "'); ", "rel" => "tooltip", "title" => "Klik untuk memanggil pasien ini"));
                echo CHtml::htmlButton(Yii::t("mds","<i class='icon-ok icon-white'></i>",array()),array("class"=>"btn btn-success","onclick"=>"verifikasiAntrian('".$data->pasienmasukpenunjang_id."');"));
       
            }

            // if($pasienmasukpenunjang->panggilantrian == false) {
            //     $verifikasi = CHtml::htmlButton(Yii::t("mds","<i class='icon-ok icon-white'></i>",array()),array("class"=>"btn btn-success","onclick"=>"verifikasiAntrian('".$data->pasienmasukpenunjang_id."');"));
          
            // }else{
            //     $verifikasi = '';
            // }

           // return $verifikasi2.$verifikasi;
          //  $label = '<a href="#" onclick="return false;" rel="tooltip" title="Tgl. Dilayani : ' . (empty($data->tverifikasiAntrianglakandilayani) ? "-" : MyFormatter::formatDateTimeForUser($data->tglakandilayani)) . '">'
          //      . $data->ruangan_singkatan . "-" . $data->no_urutperiksa . '</a>';

        //    return '&emsp;'. $label . '&emsp;'. "<br>"
         //       . (empty($data->tgl_pasiendatang) ? "<span class=\"badge badge-info pull-right badge-status\" style=\"margin-bottom: -2pt; z-index: 1;\">$data->jml_panggil</span>".CHtml::htmlButton(Yii::t("mds", "{icon}", array("{icon}" => "<i class='icon-volume-up icon-white'></i>")), array("style" => "z-index: -1;", "class" => "btn btn-primary", "onclick" => "panggilAntrian('" . $data->pasienmasukpenunjang_id . "','".$data->jml_panggil. "','". $data->ruangan_singkatan . "','". $data->no_urutperiksa .  "','" . $data->ruangan_id . "'); ", "rel" => "tooltip", "title" => "Klik untuk memanggil pasien ini")).'<br/>'.$verifikasi : "");
          },
         //   'visible' => $autoopen
        ),
        array(
            'header' => 'Tgl. Pendaftaran<br>No. Pendaftaran',
            'name' => 'tgl_pendaftaran',
            'type' => 'raw',
            //'value'=>'CHtml::link("<i class=\"icon-form-ubah\"></i><br>".$data->tgl_pendaftaran."/<br>".$data->no_pendaftaran,Yii::app()->controller->createUrl("pemeriksaanPasienRadiologi/index",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk mengubah pemeriksaan"))'
            'value' => function ($data) {
                if (($data->StatusPeriksaDaftar == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) || ($data->StatusPeriksaDaftar == Params::STATUSPERIKSA_SUDAH_PULANG)) {
                    if ($data->StatusPeriksaDaftar == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) {
                        return CHtml::link("<i class='icon-form-ubah'></i><br>" . $data->tgl_pendaftaran . "/<br>" . $data->no_pendaftaran, 'javascript:;', array('onclick' => 'alert("Maaf, Pasien ' . $data->StatusPeriksaDaftar . ' ")', "rel" => "tooltip", "title" => "Klik untuk mengubah pemeriksaan"));
                    } else {
                        return $data->tgl_pendaftaran . "/<br>" . $data->no_pendaftaran;
                    }
                } else {
                    return $data->tgl_pendaftaran . "/<br>" . $data->no_pendaftaran;
                }
            }
        ),
        array(
            'header' => 'Tgl. Penunjang<br>No. Penunjang',
            'name' => 'tglmasukpenunjang',
            'type' => 'raw',
            'value' => function($data) use (&$rad){
                                        
                $criRad = new CDbCriteria();
                $criRad->addCondition(" pendaftaran_id = '" . $data->pendaftaran_id . "' AND pasienmasukpenunjang_id = '" . $data->pasienmasukpenunjang_id . "' ");
                $criRad->addCondition(" (statusperiksahasil = '" . Params::STATUSPERIKSAHASIL_BELUM . "') OR (statusperiksahasil IS NULL)  ");
                $rad = ROHasilpemeriksaanradT::model()->findAll($criRad);
            
                if (count((array)$rad) > 0) {
                    return CHtml::link("<i class='icon-form-ubah'></i><br>".$data->tglmasukpenunjang."/<br>".$data->no_masukpenunjang,Yii::app()->controller->createUrl("pemeriksaanPasienRadiologi/index", array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)), array("rel" => "tooltip", "title" => "Klik untuk mengubah pemeriksaan"));
                } else {
                    return $data->tglmasukpenunjang."/<br>".$data->no_masukpenunjang;                                                                        
                }                                                                
            }
        ),
        array(
            'header' => 'Tgl. Rencana Pemeriksaan',
            'name' => 'tglmasukpenunjang',
            'type' => 'raw',
            'value' => function($data){
                                        
                    return $data->tgl_tindakan;                                                                        
                                                                        
            }
        ),
        array(
            'header' => 'Ruangan/<br>Dokter Perujuk',
            'name' => 'ruanganasal_nama',
            'type' => 'raw',
            'value' => function ($data) {
                $pegawai = PegawaiM::model()->findByAttributes(array(
                    'nama_pegawai' => $data->nama_dokterasal,
                ));

                $cito = "";

                    if(!empty($data->pasienkirimkeunitlain_id)) {

                        $modKirimKeUnitLain = PasienkirimkeunitlainT::model()->findByPk($data->pasienkirimkeunitlain_id);
                        
                        if($modKirimKeUnitLain->is_cito == true) {
                            
                            $cito = "ya";

                        }
                    }

                    echo CHtml::hiddenField('warna', $cito, array('class' => 'ubah'));
                    
                return $data->ruanganasal_nama . "/<br>" . (empty($pegawai) ? "-" : $pegawai->namaLengkap);
            },
        ),
        // 'nama_perujuk',

        array(
            'header' => 'No. RM/Nama Pasien/Tanggal Lahir/Jenis Kelamin/Umur',
            'type' => 'raw',
            'value' => function ($data) {
                echo  $data->no_rekam_medik;
                echo "/<br>";
                if (substr($data->no_rekam_medik, 0, -6) == "LB" || (substr($data->no_rekam_medik, 0, -6)) == "RO") {
                    echo CHtml::link("<i class='icon-pencil-blue'></i><br>" . $data->namadepan . $data->nama_pasien . '' . $data->nama_bin, Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . "/ubahPasien", array("id" => $data->pasien_id, "modul_id" => Yii::app()->session['modul_id'])), array("rel" => "tooltip", "title" => "Klik untuk mengubah data pasien"));
                } else {
                    echo   $data->namadepan . $data->nama_pasien;
                }
                echo "/<br>";
                echo MyFormatter::formatDateTimeForUser($data->tanggal_lahir);
                echo "/<br>";
                echo $data->jeniskelamin . "/<br>" . $data->umur;
                echo "<br/>";
                echo CHtml::htmlButton('<i class="icon-form-print"></i>', array(
                    'onclick' => 'konfigurasiLabel("' . $data->pasienmasukpenunjang_id . '")',
                    'style' => 'border: none;background-color: white;'
                ));
            },
        ),

        'alamat_pasien',
        array(
            'header' => 'Jenis Penjamin / Penjamin',
            'value' => '$data->caraBayarPenjamin',
        ),
        array(
            'header' => 'Diagnosa Klinis',
            'value' => function($data) {

                $diagnosa = PasienmorbiditasR::model()->findAll("pendaftaran_id = $data->pendaftaran_id and is_verifikasidiagnosa = false");
                $arr_diagnosa = [];

                if(!empty($diagnosa)) {
                    echo '<ul>';
                    foreach($diagnosa as $d) {
                        echo '<li>' . $d->diagnosa->diagnosa_nama . '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo '-';
                }

            },
        ),
        array(
            'header' => 'Dokter Pemeriksa',
            'type' => 'raw',
            //                'value'=>'($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>". $data->getNamaLengkapDokter($data->pegawai_id),Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/ApprovePemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk menyetujui pemeriksaan", "onclick"=>"return confirm(\"Apakah Anda akan menyetujui pemeriksaan ini?\");")) : $data->getNamaLengkapDokter($data->pegawai_id)',
             'value' => function ($data) {
                        $ppds = PasienPpdsT::model()->findAllByAttributes(
                            array(
                                'pendaftaran_id' => $data->pendaftaran_id
                            )
                        );

                        $penunjang = PasienmasukpenunjangT::model()->findByPk($data->pasienmasukpenunjang_id);
                    
                        $itemz = '';
                        $x = 1;
                    
                        $dokter = $data->getNamaLengkapDokter($data->pegawai_id);

                        echo "<div style='width:100px;'>" . 
    
                        CHtml::link(
                            '<i class="icon-pencil-brown"></i>&emsp;' . $dokter,
                               Yii::app()->controller->createUrl(Yii::app()->controller->id . "/ubahPemeriksa", array("pendaftaran_id" => $data->pendaftaran_id, "pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)),
                               array("title" => "Klik untuk Mengubah Data Dokter Periksa", "target" => "iframeEditPemeriksa", "onclick" => '$("#editPemeriksa").dialog("open");', "rel" => "tooltip")
                           )
                        
                        . "</div>";
                    
                        // if(!empty($penunjang->ppds_id)) {

                        //     echo '&nbsp;/&nbsp;';
                        //     echo $penunjang->ppds->ppds_nama;

                        // }
                        
            }
            
      ),
      /*
        array(
            'name' => 'Cetak Label',
            'type' => 'raw',
            // 'value' => '',
            'value' => function ($data) {
                // RSCMS-
                // return CHtml::link('<i class="icon-form-print"></i>', Yii::app()->controller->createUrl('/radiologi/daftarPasien/printLabel', array(
                //     'id'=>$data->pasienmasukpenunjang_id,
                // )), array(
                //     'target'=>'frameCetakLabel',
                //     'onclick'=>"$('#dialogCetakLabel').dialog('open');",
                // ));
                return CHtml::htmlButton('<i class="icon-form-print"></i>', array(
                    'onclick' => 'konfigurasiLabel("' . $data->pasienmasukpenunjang_id . '")',
                    'style' => 'border: none;background-color: white;'
                ));
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),            
        */
        array(
            'name' => 'Riwayat Vaksinasi/Imunisasi',
            'type' => 'raw',
            // 'value' => '',
            'value' => function ($data) {
                return CHtml::link('<i class="icon-form-detail"></i>', Yii::app()->controller->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/updateRiwayatVaksinasi', array(
                    'pendaftaran_id'=>$data->pendaftaran_id,
                )), array(
                    'target'=>'frameRiwayatVaksinasi',
                    'onclick'=>"$('#dialogRiwayatVaksinasi').dialog('open');",
                ));
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),            
                    
        array(
            'header' => 'Hasil',
            'name' => 'masukanHasil',
            'type' => 'raw',
            'value' => function ($data) use ($module, $controller) {

                $str = "";

                if (!empty($data->tgl_pasiendatang)){
                  //  echo $data->tgl_pasiendatang;
                   $str .= CHtml::link("<i class=icon-form-input></i>", Yii::app()->controller->createUrl('/' . $module . '/' . $controller . '/hasilPemeriksaan', array("pendaftaran_id" => $data->pendaftaran_id, "pasien_id" => $data->pasien_id, "pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)), array("rel" => "tooltip", "title" => "Klik untuk memasukkan hasil"));
               
                } else{
                   // echo $data->tgl_pasiendatang;
                   $str .= CHtml::link("<i class=icon-form-input></i>", 'javascript:void(0);', array("rel" => "tooltip", "title" => "Klik untuk memasukkan hasil", 'onclick' => 'myAlert("Klik verifikasi kedatangan pasien terlebih dahulu")'));
                    
                }

                // if($data->tgl_pasiendatang == null) {
                //     $str .= CHtml::link("<i class=icon-form-input></i>", 'javascript:void(0);', array("rel" => "tooltip", "title" => "Klik untuk memasukkan hasil", 'onclick' => 'myAlert("Klik verifikasi kedatangan pasien terlebih dahulu")'));
                // } else {
                //     $str .= CHtml::link("<i class=icon-form-input></i>", Yii::app()->controller->createUrl('/' . $module . '/' . $controller . '/hasilPemeriksaan', array("pendaftaran_id" => $data->pendaftaran_id, "pasien_id" => $data->pasien_id, "pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)), array("rel" => "tooltip", "title" => "Klik untuk memasukkan hasil"));
                // }


                if (Yii::app()->user->getState('weasis_aktif') == true) {

                    $hasil = HasilpemeriksaanradT::model()->findAllByAttributes(array(
                        'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id,
                    ));

                    if (count((array)$hasil) > 0) {
                        $str .= "<ul style='margin-left: 0.3rem; padding-left: none'>";
                        foreach ($hasil as $item) {

                            $studyID = $item->study_uid;
                            $accessionNumber = $data->no_masukpenunjang;
                            $patientID = $item->hasilpemeriksaanrad_id;

                            if (!empty($item->pemeriksaanrad)) {
                                if ($item->pacs_ok) {
                                    if ($item->hapus_gambar == false) {
                                        $str .= "<li>" . CHtml::link($item->pemeriksaanrad->pemeriksaanrad_nama  . " - ". $patientID. ' <i class="entypo-eye"></i>', '#', array(
                                            'onclick' => "lihatHasilPeriksa('" . $studyID . "', '" . $accessionNumber . "', '" . $patientID . "'); return false;",
                                        )) . "</li>"; 
                                    } else {
                                        $str .= "<li> <b>" . $item->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama . "</b> - " . $item->pemeriksaanrad->pemeriksaanrad_nama ." - " .$patientID. "</li>";
                                    }
                                } else {
                                    $str .= "<li><b>" . $item->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama . "</b> - " . $item->pemeriksaanrad->pemeriksaanrad_nama ." - " .$patientID. "</li>";
                                }
                            }
                        }
                        $str .= "</ul>";
                    }
                }

                return $str;
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'TAT',
            'name' => 'respondtime',
            'type' => 'raw',
            // 'value' => '',
            'value' => function ($data) {

                $tat = '-';

                $hasil = HasilpemeriksaanradT::model()->find("pasienmasukpenunjang_id = $data->pasienmasukpenunjang_id");
                $datang = $data->tgl_pasiendatang;
                if(!empty($hasil) && !empty($datang)) {
                    if(!empty($hasil->tglpegambilanhasilrad)) {

                        $tat =$data::getTAT($hasil->tglpegambilanhasilrad, $datang);
                    }
                }

                return "<span title='TAT dihitung dari verifikasi pemeriksaan sampai masukkan hasil'>" . $tat . '</span>';
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),  
        array(
            'header' => 'Status Periksa /<br>Status Hasil Radiologi',
            'type' => 'raw',
            //                'value'=>'($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>". $data->statusperiksahasil,Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/CancelPemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan", "onclick"=>"return confirm(\"Apakah Anda akan membatalkan pemeriksaan ini?\");")) : ((empty($data->pasienbatalperiksa_id)) ? $data->statusperiksahasil : "DIBATALKAN")',
            'value' => function ($data) use (&$rad) {
                
                echo '<center>';
                echo $data->getStatusRad($data->statusperiksa,$data->pendaftaran_id,$data->pasienmasukpenunjang_id);

                // echo '<br>';

                if (count((array)$rad) > 0) {
                    echo $data->getStatusHasil(Params::STATUSPERIKSAHASIL_BELUM);
                } else {
                    echo $data->getStatusHasil(Params::STATUSPERIKSAHASIL_SUDAH);
                    // echo $data->getPemeriksaanRad($data->statusperiksa, $data->pendaftaran_id, $data->pasienmasukpenunjang_id);
                }
                // if (!empty($data->getKePoli())){
                // echo $data->getKePoli();
                // }else{
                //     echo '';
                // }
                echo '</center>';
            },

            'htmlOptions' => array('style' => 'text-align: center;', 'class' => ''),

        ),
        [ 
            'header'  => 'Persetujuan / Penolakan <br> Detail <br> Persetujuan / <br> Penolakan',
            'type' => 'raw',
            'value' => function($data) {
                $div = '<div class="column">';
                $tutupDiv = '</div>';

                // persetujuan
                $linkPersetujuan = CHtml::link('<i class="icon-form-ubah"></i><br>Tindakan', Yii::app()->controller->createUrl("PersetujuanTindakanTRO/index", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat persetujuan tindakan"))
                . "<br>" .  CHtml::link('<i class="icon-form-ubah"></i><br>Inform Consent', Yii::app()->controller->createUrl("PersetujuanTindakanUmumRO/index", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan Inform Consent (Persetujuan)"));

                // penolakan
                $linkPenolakan = CHtml::link('<i class="icon-form-silang"></i><br>Tindakan ', Yii::app()->controller->createUrl("PersetujuanTindakanTRO/penolakan", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat penolakan tindakan"))
                . "<br>" . CHtml::link('<i class="icon-form-silang"></i><br>Inform Refusal', Yii::app()->controller->createUrl("PersetujuanTindakanUmumRO/penolakan", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan Inform Consent (Penolakan)"));


                // detail persetujuan 

                $detailPersetujuan = "<br>" . CHtml::link("<icon class='icon-form-detail'></icon><br>Detail", Yii::app()->controller->createUrl('pencarianPasienRO/detailPersetujuanTindakan', array('id' => $data->pendaftaran_id)), array("target" => "framePersetujuanTindakan", "rel" => "tooltip", "title" => "Klik untuk melihat Detail Persetujuan & Penolakan", "onclick" => "$('#dialogPersetujuanTindakan').dialog('open');"));

                // penolakan
                $detailPenolakan = '<br>' . CHtml::link("<icon class='icon-form-detail'></icon><br>Inform<br>Consent", Yii::app()->controller->createUrl('pencarianPasienRO/detailInformConsent', array('id' => $data->pendaftaran_id)), array("target" => "frameInformConsent", "rel" => "tooltip", "title" => "Klik untuk melihat Inform Consent", "onclick" => "$('#dialogInformConsent').dialog('open');"));


                return '<div class="container">' . $div. $linkPersetujuan . $detailPersetujuan . $tutupDiv. $div. $linkPenolakan . $detailPenolakan . $tutupDiv . '</div>';
            }
        ],
       
        


        array(
            // 'name' => 'Inform Consent<hr>Asesmen Radiologi<hr>Detail Inform Consent<hr>Asesmen awal',
            'name' => 'Periksa Pasien / <br> Anastesi',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            'value' =>  function ($data) {
                
                return CHtml::link("<i class='icon-form-periksa'></i><br>Periksa Pasien", Yii::app()->controller->createUrl("/radiologi/pemeriksaanPasien",array("pendaftaran_id"=>$data->pendaftaran_id, 'pasienmasukpenunjang_id'=>$data->pasienmasukpenunjang_id)),array("id"=>$data->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien")) . 
                
                '<br>' . 
                
                CHtml::link('<i class="icon-form-input"></i>', Yii::app()->controller->createUrl('/rawatInap/anestesiTRI/index', array(
                    'pendaftaran_id'=>$data->pendaftaran_id,
                )), array(
                    'target'=>'frameAnestesi',
                    'onclick'=>"$('#dialogAnestesi').dialog('open');",
                )) . '<br> Anastesi';
              
            },
        ),
        
        /*  
        array(
            'name' => 'Reseptur',
            'type' => 'raw',
            // 'value' => '',
            'value' => function ($data) {
                return CHtml::link('<i class="icon-form-reseptur"></i>', Yii::app()->controller->createUrl('/rawatInap/resepturTRI/index', array(
                    'pendaftaran_id'=>$data->pendaftaran_id,
                )), array(
                    "rel" => "tooltip",
                    "title" => "Klik untuk pemeriksaan reseptur",
                    'target'=>'frameReseptur',
                    'onclick'=>"$('#dialogReseptur').dialog('open');",
                ));
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ), 
        */
        array(
            'name' => 'lihatHasil',
            'type' => 'raw',
            'value' => function ($data) {

                $color_isverif = '';

                $str = CHtml::link(
                    "<i class=icon-form-lihat></i>",
                    Yii::app()->controller->createUrl("lihatHasil/HasilPeriksa", array("pendaftaran_id" => $data->pendaftaran_id, "pasien_id" => $data->pasien_id, "pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)),
                    array(
                        "rel" => "tooltip",
                        "title" => "Klik untuk melihat hasil",
                        "target" => "iframeLihatHasil",
                        "onclick" => "$(\"#dialogLihatHasil\").dialog(\"open\");",
                    )
                ) . "<br>" .
                    (($data->statusPemeriksaan($data->pasienmasukpenunjang_id) == Params::STATUSPERIKSAHASIL_SUDAH) ?
                        (($data->pengambilanHasil($data->pasienmasukpenunjang_id) == "") ?
                            CHtml::Link(
                                "<i class=\"icon-form-verifikasi\"></i>",
                                Yii::app()->controller->createUrl("daftarPasien/ambilHasil", array("pendaftaran_id" => $data->pendaftaran_id, "pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id, "frame" => 1, "popup" => "true")),
                                array(
                                    "class" => "",
                                    "target" => "iframeAmbilHasil",
                                    "onclick" => "$(\"#dialogAmbilHasil\").dialog(\"open\");",
                                    "rel" => "tooltip",
                                    "title" => "Klik untuk Pengambilan Hasil",
                                )
                            ) : $data->pengambilanHasil($data->pasienmasukpenunjang_id))
                        : "") . '<br><br><hr><br>' . 
                        CHtml::link( "<icon class=\"fas fa-user-check fa-2x\" style=\"$color_isverif\"></icon>", Yii::app()->controller->createUrl('verifikasiDokter', array(
                            'pasienmasukpenunjang_id'=>$data->pasienmasukpenunjang_id,
                        )), array(
                            'target'=>'frameVerifHasilPemeriksaan',
                            'onclick'=>"$('#dialogVerifHasilPemeriksaan').dialog('open');",
                            "rel" => "tooltip",
                            "title" => "Verifikasi Dokter",
                        )). '<br><br><hr><br>' . 
                        CHtml::link('<icon class="fa fa-check-square fa-2x"></icon>', 'javascript:void(0)', array(
                            'onclick'=>"pemeriksaanSelesai($data->pasienmasukpenunjang_id);", "rel" => "tooltip",
                            "title" => "Pemeriksaan Selesai"
                        ));

                        $selesai = "";


                        $penunjang = PasienmasukpenunjangT::model()->findByPk($data->pasienmasukpenunjang_id);
                        
                        if($penunjang->is_selesai == true) {
                            
                            $selesai = "ya";

                        }
                    

                    echo CHtml::hiddenField('warna', $selesai, array('class' => 'ubah-selesai'));
                        

                return "<center>$str</center>";
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        [
            'header' => 'Upload Dokumen Pendukung',
            'type' => 'raw',
            'value' => function($data) {
                    $tombolUpload =  CHtml::link("Upload",$this->createUrl('/rekamMedis/scanRM/index', ['pendaftaran_id' => $data->pendaftaran_id, 'penunjang' => 'radiologi']),
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
        // array(
        //     'header' => 'Batal Periksa',
        //     'type' => 'raw',
        //     'value' => function ($data) {
        //         if ($data->StatusPeriksaDaftar == Params::STATUSPERIKSA_SUDAH_PULANG) {
        //             return CHtml::link("<i class=icon-form-silang></i>", 'javascript:;', array('onclick' => 'myAlert("Anda tidak dapat menginput hasil pemeriksan, karena status pasien ' . $data->StatusPeriksaDaftar . '","Perhatian !")', "rel" => "tooltip", "title" => "Klik untuk membatalkan pasien", 'data-placement' => 'left'));
        //         } else {
        //             if (!empty($data->tgl_pasiendatang)){
        //                 return null ;
        //                      }else{
                      
        //                 return CHtml::link("<i class='icon-form-silang'></i>", 'javascript:dialogBatalPeriksa(' . $data->pendaftaran_id . ',' . $data->pasienmasukpenunjang_id . ',"' . $data->nama_pasien . '")', array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan pasien", "data-placement" => "left"));
            
        //             }
        //             //return CHtml::link("<i class='icon-form-silang'></i>", "javascript:batalperiksa(".$data->pendaftaran_id.", ".$data->pasienmasukpenunjang_id.")",array("id"=>$data->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan","data-placement"=>"left"));
        //             // return CHtml::link("<i class='icon-form-silang'></i>", "javascript:;", array('onclick' => "dialogBatalPeriksa(" . $data->pendaftaran_id . ", " . $data->pasienmasukpenunjang_id . ",\"" . $data->nama_pasien . "\")", "id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", "data-placement" => "left"));
        //         }
        //     },
        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        // ),
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
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){ubahWarna(); jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));