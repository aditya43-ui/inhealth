<?php 
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$modul = $this->module->name;
$control = $this->id;
$this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
    'id'                 => 'daftarpasien-v-grid',
    'dataProvider'         => $modPasienMasukPenunjang->searchRM(),
    'template'             => "{summary}\n{items}\n{pager}",
    // 'mergeColumns'         => array('rincian'),
    'itemsCssClass'         => 'table table-striped table-condensed table-bordered',
    'columns'             => array(
        array(
            'name'     => 'no_urutperiksa',
            'type'     => 'raw',
            'header' => 'No. Antrian/<br>Panggil Antrian',
            'value'     => function ($data) {
                if (date('Y-m-d', strtotime($data->tglmasukpenunjang)) != date('Y-m-d')) {
                    return "Sudah Dipanggil";
                }
                if ($data->panggilantrian == TRUE) {
                    return "Sudah Dipanggil";
                }
                return CHtml::htmlButton(Yii::t("mds", "{icon}", array("{icon}" => '<i class="icon-volume-up icon-white"></i>')), array("class" => "btn btn-primary", "onclick" => "panggilAntrian(\"$data->pasienmasukpenunjang_id\"); setSuaraPanggilanSingle(\"$data->ruangan_singkatan\",\"$data->no_urutperiksa\",\"$data->ruangan_id\")", "rel" => "tooltip", "title" => "Klik untuk memanggil pasien ini"));
            },
        ),
        'tglmasukpenunjang',
        array(
            'header' => 'Instalasi/<br>Ruangan Asal',
            'value'     => '$data->insatalasiRuanganAsal'
        ),

        // RSIH-572
        array(
            'header' => 'Ruangan/<br>Dokter Perujuk',
            'type' => 'raw',
            'value' => function ($data) {
                $pegawai = PegawaiM::model()->findByAttributes(array(
                    'nama_pegawai' => $data->nama_dokterasal,
                ));
                return $data->ruanganasal_nama . "/<br>" . (empty($pegawai) ? "-" : $pegawai->namaLengkap);
            },
        ),
        //            'no_pendaftaran',
        array(
            'name'             => 'no_pendaftaran',
            'header'         => 'No. Pendaftaran',
            'type'             => 'raw',
            'value'             => '$data->no_pendaftaran',
            'htmlOptions'     => array('width' => '100px'),
        ),
        array(
            'header' => 'No. Rekam Medik',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::link(
                    "<i class='icon-form-print'></i><br>" . $data->no_rekam_medik,
                    Yii::app()->createUrl("/rehabMedis/pendaftaranRehabilitasiMedis/printKlaim", array("pendaftaran_id" => $data->pendaftaran_id)),
                    array(
                        "class" => "",
                        "target" => "frameEditPasien",
                        "rel" => "tooltip",
                        "title" => "Klik untuk Print Form Klaim Rehab Medis",
                        "onclick" => "$('#editPasien').dialog('open');return true;"
                    )
                );
            },
            //'value'     => '$data->no_rekam_medik',
            'htmlOptions'     => array('style' => 'font-weight:bold;'),
        ),
        // 'no_rekam_medik',
        array(
            'header' => 'Nama Pasien/<br>Alias',
            'value'     => '$data->namaPasienNamaBin',
            'htmlOptions'     => array('style' => 'font-weight:bold;'),
        ),
        array(
            'header' => 'Tanggal Lahir/<br>Umur/Alamat',
            'name' => 'tanggal_lahir',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)'
        ),
        array(
            'header' => 'Kasus Penyakit/<br>Kelas Pelayanan',
            'type'     => 'raw',
            'value'     => '"$data->jeniskasuspenyakit_nama"."<br>"."$data->kelaspelayanan_nama"',
        ),
        // 'umur',
        // 'alamat_pasien',
        array(
            'header' => 'Jenis Penjamin/<br>Penjamin',
            'value'     => '$data->caraBayarPenjamin',
        ),
        
        array(
            'header' => 'Dokter Pemeriksa /<br> PPDS',
            'value'     => function ($data) {
                    if(Yii::app()->user->getState('isppds')) {
                        $ppds = PasienmasukpenunjangT::model()->findAllByAttributes(array(
                            'pendaftaran_id' => $data->pendaftaran_id
                        ));
                        $itemz ='';      
                        $x =1;
                        $pegawai = PegawaiM::model()->findByAttributes(array(
                            'pegawai_id' => $data->pegawai_id,
                        ));
                        // echo 'Dokter &nbsp;',$data->nama_pegawai ?? 'TANPA DOKTER'; 
                        echo $pegawai->namaLengkap ?? 'TANPA DOKTER'; 

                        // echo '<br>';
                        // foreach($ppds as $itemz){
                        //     echo '<br>';
                        //     echo 'PPDS &nbsp;',$x++ ?? "".'-'.$itemz->ppds->ppds_nama ?? "-";
                        //    }
                        }
                    } 
            
            
          //  '$data->nama_pegawai ?? $data->nama_pegawai : "TANPA DOKTER"."/<br>".$data->ppds->ppds_nama ?? $data->ppds->ppds_nama : "-" ',
        ),
        //            'kelaspelayanan_nama',
        [
            'header' => 'Tindakan terapi',
            'type' => 'raw',
            'value' => function ($data) {
                if(!empty($data->tindakanterapi_rehab)) {
                    $ex = explode(',', $data->tindakanterapi_rehab);

                    if(!empty($ex)) {
                        foreach ($ex as $i => $value) {
                            echo '<b>*' . $value . '</b><br><hr>';
                        }
                    }
                }
            },
            'htmlOptions' => array('width' => '30px'),
        ],
        array(
            'header' => 'Status Periksa',
            'type' => 'raw',
            'value' => '$data->getStatusRM($data->statusperiksa,$data->pendaftaran_id,$data->pasienmasukpenunjang_id)'
        ),
        array(
            'name'             => 'Pemeriksaan Pasien',
            'type'             => 'raw',
            // 'value'             => 'CHtml::link("<i class=\'icon-form-periksa\'></i> ", Yii::app()->controller->createUrl("/rehabMedis/pemeriksaanPasienTRM/index",array("pendaftaran_id"=>$data->pendaftaran_id, "pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"))',
            'value' => function ($data) {
                echo '<div class="small-container">';
                echo CHtml::link("<i class='icon-form-rj'></i><br>Asesmen Pasien", Yii::app()->controller->createUrl("/rawatJalan/pemeriksaanAsesmenPasienRJ", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Asesmen Pasien Rawat Jalan"));
                echo '</div>';
                echo '<div class="small-container">';
                echo $data->linkPeriksaPasien;
                echo '</div>';
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        // array(
        //     'name' => 'Riwayat Vaksinasi/Imunisasi',
        //     'type' => 'raw',
        //     // 'value' => '',
        //     'value' => function ($data) {
        //         return CHtml::link('<i class="icon-form-detail"></i>', Yii::app()->controller->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/updateRiwayatVaksinasi', array(
        //             'pendaftaran_id' => $data->pendaftaran_id,
        //         )), array(
        //             'target' => 'frameRiwayatVaksinasi',
        //             'onclick' => "$('#dialogRiwayatVaksinasi').dialog('open');",
        //         ));
        //     },
        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        // ),
        // array(
        //     'header'         => 'Buat Jadwal',
        //     'type'             => 'raw',
        //     'value'             => 'CHtml::link("<i class=icon-form-buatjadwal></i>",Yii::app()->controller->createUrl("/' . $module . '/' . $controller . '/buatJadwal",array("id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk Membuat Jadwal Rehab Medis"))',
        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        // ),
        array(
            'header'         => 'Kunjungan Rehab',
            'type'             => 'raw',
            'value'             => function($data) {
                    $html = CHtml::Link("<i class='icon-form-ubah'></i>",Yii::app()->controller->createUrl("kunjunganRehab",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),
                    array("class"=>"icon-form-ubah", 
                        "id" => "selectPasien",
                        "rel"=>"tooltip",
                        "title"=>"Klik",
                        "target"=>"frameBuatJadwal",
                        "onclick"=>"$('#dialogBuatJadwal').dialog('open')",
                    ));
                    $modPenunjang = PasienmasukpenunjangT::model()->findByPk($data->pasienmasukpenunjang_id);

                    $html .= '<br>';
                    
                    if(!empty($modPenunjang->tglkunjunganrehab) && !empty($modPenunjang->kunjunganrehabke)) {
                        $html .= '<b>' . $modPenunjang->kunjunganrehabke . '/<br>'. $modPenunjang->tglkunjunganrehab .'</b>';
                    }

                    return $html;
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'name'             => 'masukanHasil',
            'type'             => 'raw',
            'value'             => 'CHtml::link("<i class=icon-form-input></i>",Yii::app()->controller->createUrl("/' . $module . '/' . $controller . '/hasilPemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk Memasukkan hasil"))',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header'         => 'Lihat Hasil',
            'type'             => 'raw',
            'value'             => 'CHtml::link("<icon class=\'icon-form-lihat\'></idcon>", Yii::app()->createUrl("' . $modul . '/' . $controller . '/lihatHasil", array("id"=>$data->pendaftaran_id)), array("target"=>"frameLihatHasil", "onclick"=>"$(\'#dialogLihatHasil\').dialog(\'open\');"))',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        // array(
        //     'header' => 'Rincian Tagihan',
        //     'name'   => 'rincian',
        //     'type'   => 'raw',
        //     'value'  =>  function ($data) {
        //         $str = "";
        //         $str .= CHtml::Link(
        //             "<i class=\"icon-form-detailtagihan\"></i>",
        //             Yii::app()->controller->createUrl("/rehabMedis/daftarPasien/RincianTagihanPenunjang", array("pendaftaran_id" => $data->pendaftaran_id, "pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id, "instalasi_id" => $data->instalasi_id, "pasienadmisi_id" => "", "frame" => true)),
        //             array(
        //                 "target" => "iframeRincianTagihan",
        //                 "onclick" => "$(\"#dialogRincianTagihan\").dialog(\"open\");",
        //                 "rel" => "tooltip",
        //                 "title" => "Klik untuk melihat Rincian Tagihan",
        //             )
        //         );
        //         $total = (empty($data->totaltagihan)) ? "0" : $data->totaltagihan;
        //         $str .= ($total != 0 ? "<div id=\"$data->pendaftaran_id\">Belum Lunas</div>" : "Sudah Lunas" . "<br>");
        //         return $str;
        //     },
        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px; vertical-align: initial !important'),
        // ),
        array(
            'name' => 'Persetujuan',
            'type' => 'raw',
            'value' => '(CHtml::link("<i class=\'icon-form-ubah\'></i><br>Tindakan", Yii::app()->controller->createUrl("PersetujuanTindakanUmumRM/index",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk pembuatan surat persetujuan tindakan")))."<br>"'
                . '.(CHtml::link("<i class=\'icon-form-ubah\'></i><br>Anastesi", Yii::app()->controller->createUrl("PersetujuanTindakanAnastesiRM/index",array("pendaftaran_id"=>$data->pendaftaran_id, "noframe"=>1)),array("id"=>$data->no_pendaftaran."_antrian","rel"=>"tooltip","title"=>"Klik untuk pembuatan surat persetujuan tindakan anastesi")))',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'name' => 'Penolakan',
            'type' => 'raw',
            'value' => '(CHtml::link("<i class=\'icon-form-ubah\'></i><br>Tindakan", Yii::app()->controller->createUrl("PersetujuanTindakanUmumRM/penolakan",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk pembuatan surat penolakan tindakan")))."<br>"'
                . '.(CHtml::link("<i class=\'icon-form-ubah\'></i><br>Anastesi", Yii::app()->controller->createUrl("PersetujuanTindakanAnastesiRM/penolakan",array("pendaftaran_id"=>$data->pendaftaran_id, "noframe"=>1)),array("id"=>$data->no_pendaftaran."_antrian","rel"=>"tooltip","title"=>"Klik untuk pembuatan surat penolakan tindakan anastesi")))',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Detail Persetujuan & Penolakan',
            'type' => 'raw',
            'value' => function ($data) {
                $str = "";
                $umum = SuratpersetujuanumumT::model()->findByAttributes(array(
                    'pendaftaran_id' => $data->pendaftaran_id,
                ));
                if (!empty($umum)) {
                    $str .= CHtml::link("<icon class='icon-form-detail'></icon><br>General<br>Consent", Yii::app()->controller->createUrl('suratPersetujuanUmumRM/view', array('pendaftaran_id' => $data->pendaftaran_id)), array("target" => "frameGeneralConsent", "rel" => "tooltip", "title" => "Klik untuk melihat General Consent", "onclick" => "$('#dialogGeneralConsent').dialog('open');"));
                }
                $str .= CHtml::link("<icon class='icon-form-detail'></icon><br>Tindakan", Yii::app()->controller->createUrl('pencarianPasienRM/detailPersetujuanTindakan', array('id' => $data->pendaftaran_id)), array("target" => "framePersetujuanTindakan", "rel" => "tooltip", "title" => "Klik untuk melihat Persetujuan Tindakan", "onclick" => "$('#dialogPersetujuanTindakan').dialog('open');"));
                $str .= CHtml::link("<icon class='icon-form-detail'></icon><br>Inform<br>Consent", Yii::app()->controller->createUrl('pencarianPasienRM/detailInformConsent', array('id' => $data->pendaftaran_id)), array("target" => "frameInformConsent", "rel" => "tooltip", "title" => "Klik untuk melihat Inform Consent", "onclick" => "$('#dialogInformConsent').dialog('open');"));
                $str .= CHtml::link("<icon class='icon-form-detail'></icon><br>Anestesi", Yii::app()->controller->createUrl('pencarianPasienRM/detailTindakanAnestesi', array('id' => $data->pendaftaran_id)), array("target" => "frameTindakanAnestesi", "rel" => "tooltip", "title" => "Klik untuk melihat Persetujuan Tindakan Anestesi", "onclick" => "$('#dialogTindakanAnestesi').dialog('open');"));
                return $str;
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Catatan Edukasi',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::link('<i class="icon-form-detail"></i>', $this->createUrl('catatanEdukasiRM/create', array('pendaftaran_id' => $data->pendaftaran_id)), array(
                    'rel' => 'tooltip',
                    'title' => 'Catatan Edukasi Pasien',
                ));
            },
            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
        ),
        array(
            'name' => 'Catatan Perkembangan Pasien Terintegrasi (CPPT)',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::link('<i class="icon-form-detail"></i> ', Yii::app()->createUrl("/rehabMedis/CPPTRM/index", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Catatan Perkembangan Pasien Terintegrasi (CPPT)"));
            },
            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
        ),
        // array(
        //     'header' => 'Pemindahan Pasien',
        //     'type' => 'raw',
        //     'value' => function ($data) {
        //         $htmlLink = CHtml::link('<i class="icon-form-detail"></i>', Yii::app()->createUrl('/rehabMedis/pemindahanPasienRM/index', array('pendaftaran_id' => $data->pendaftaran_id)), array(
        //             'rel' => 'tooltip',
        //             'title' => 'Pemindahan Pasien',
        //         ));

        //         $modFormTransfer = PemindahanpasienT::model()->findAllByAttributes(array('ruangantujuan_id' => Yii::app()->user->getState("ruangan_id"), 'pendaftaran_id' => $data->pendaftaran_id), array('condition' => '(ispasienditerima IS NULL OR ispasienditerima = false)'));
        //         $linkPenerima = "";
        //         if (isset($modFormTransfer) && count($modFormTransfer) > 0) {
        //             $linkPenerima = CHtml::link('<i class="icon-form-check"></i> ', Yii::app()->createUrl("/rehabMedis/pemindahanPasienRM/index", array("pendaftaran_id" => $data->pendaftaran_id, 'pasienditerima' => 'diterima')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Penerimaan Pemindahaan Pasien"));
        //         }

        //         return $htmlLink . '<br/>' . $linkPenerima;
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
        //                 $this->createUrl("/rehabMedis/pemindahanPasienRM/detail", array("pemindahanpasien_id" => $modPemindahanPasien->pemindahanpasien_id)),
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
        array(
            'header'         => 'Batal Periksa',
            'type'             => 'raw',
            'value'             => '($data->statusperiksahasil != Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:dialogBatalPeriksa(\'$data->pendaftaran_id\',\'$data->pasienmasukpenunjang_id\',\'$data->statusperiksa\',\'$data->nama_pasien\')",array("id"=>"$data->pendaftaran_id","rel"=>"tooltip","title"=>"Klik untuk membatalkan Pemeriksaan")) : null',
            'htmlOptions'     => array('style' => 'text-align: center; width:40px'),
        ),
    ),
    'afterAjaxUpdate'     => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>