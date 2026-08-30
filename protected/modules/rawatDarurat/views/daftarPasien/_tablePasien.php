<style>

/* .table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th.ubahwarna {
        background-color:#ffc7cf !important;
    } */
    .merah{
        background-color:#ffc7cf !important;
    }

    .jawab_konsul {
        background-color:yellow !important;
    }
    .btn-small [class^="icon-"] {
        margin-left: 20px !important;
    }

</style>

<?php

$is_validasi_pja = (Yii::app()->user->getState('kelompokpegawai_id') != 1)
    || (Yii::app()->user->name == 'sysadmin');

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarPasien-grid',
    'items_perpage' => 50,  
    // 'dropdownItemKelipatan' => 10,
    'dataProvider' => $model->searchRD(),
    'template' => "{summary}\n{items}\n{pager}",
    'replaceUrl' => true,
    'itemsCssClass' => 'table table-condensed',
    'rowCssClassExpression' => '$data->getCssClass($data->pendaftaran_id)',
    'columns' => array(
        array(
            'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran /<br> Status Kecelakaan',
            'name' => 'tgl_pendaftaran',
            'type' => 'raw',
            'value' => function ($data) {
                $html = MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran) . "<br>" . $data->no_pendaftaran;
                if (!empty($pendaftaran) && $pendaftaran->isbacahakpasien == true) {
                    $html .= "<br>";
                    
                    $html .= CHtml::Link(
                        "<i class=icon-form-detail></i><br>Hak & Kewajiban",
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
                $html .= '<br>';
                if($data->is_kecelakaan) {
                    $html .= '<b>Kecelakaan Lalu Lintas</b>';
                } else {
                    $html .= '<b>Bukan Kecelakaan</b>';
                }
                return $html;


              
                  
            },
             
    // return $warna;
    


            // 'value' => '$data->tgl_pendaftaran."/<br>".$data->no_pendaftaran'
        ),
        //                    array(
        //                        'header'=>'Instalasi / Poliklinik',
        //                        'value'=>'$data->insatalasiRuangan'
        //                    ),

               
        // array(
        //     'header' => 'Ini Tanggal',
        //     //                        'value'=>'$data->namadepan.$data->nama_pasien'
        //     'type' => 'raw',
        //     'value' => function ($data) {
        //         echo "Tanggal: " . $data->tgl_pendaftaran;
        //     },
        // ),

        array(
            'header' => 'No. Rekam Medis/N I K/Nama Pasien/<br>Tanggal Lahir',
            //                        'value'=>'$data->namadepan.$data->nama_pasien'
            'type' => 'raw',
            'value' => function ($data) {
                echo "<b>" . $data->no_rekam_medik . "</b>";
                echo "<hr>";
                echo "<b>" . $data->no_identitas_pasien . "</b>";
                echo "<hr>";
                echo CHtml::link(
                    "<b>" . $data->namadepan . $data->nama_pasien . "</b>",
                    Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/getRiwayatPasien", array("id" => $data->pasien_id)),
                    array(
                        "rel" => "tooltip",
                        "title" => "Klik untuk melihat riwayat pemeriksaan pasien",
                        "target" => "frameRiwayatPasien",
                        "onclick" => "$('#dialogRiwayatPasien').dialog('open');"
                    )
                );
                echo "<hr>";
                echo  $data->tanggal_lahir;
                echo "<hr>";
            },
        ),
        
        //                    array(
        //                        'header'=>'Kasus Penyakit',
        //                        'type'=>'raw',
        ////                        'value'=>'"$data->jeniskasuspenyakit_nama"."<br>"."$data->kelaspelayanan_nama"',
        //						'value'=>function($data){
        //								if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG){
        //									return $data->jeniskasuspenyakit_nama;
        //								}else{
        //									return CHtml::hiddenField("RDInfoKunjunganRDV[".$data->pendaftaran_id."][pendaftaran_id]", $data->pendaftaran_id, array("id"=>"pendaftaran_id","onkeypress"=>"return $(this).focusNextInputField(event)","class"=>"span3")).CHtml::link("<i class=icon-form-ubah></i> ".$data->jeniskasuspenyakit_nama,"javascript:void(0)",array("onclick"=>"ubahKasusPenyakit(this,".$data->pendaftaran_id.",".$data->jeniskasuspenyakit_id.");return false;","class"=>"kasus_penyakit","rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Mengubah Data Kasus Penyakit"));
        //								}
        //						},
        //						'htmlOptions'=>array(
        //							'style'=>'text-align: center',
        //							'class'=>'list_kasus_penyakit'
        //						)
        //                    ),
        array(
            'header' => 'Jenis Kelamin/<br>Umur/Alamat',
            'type' => 'raw',
            'value' => function ($data) {
                echo $data->jeniskelamin . "/<br>" . $data->umur;
                echo "<hr>";
                echo $data->alamat_pasien;
            },
        ),
        array(
            'name' => 'Rujukan',
            'type' => 'raw',
            'value' => '(!empty($data->asalrujukan_nama))? $data->asalrujukan_nama : ""',
        ),
        array(
            'header' => 'Jenis Penjamin/<br>Penjamin',
            'value' => function ($data) use (&$modPendaftaran) {
                echo  $data->caraBayarPenjamin;
                echo "<br>";
                $modPendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                $modAdmisi = PasienadmisiT::model()->findByAttributes(array(
                    'pasienadmisi_id'=>$modPendaftaran->pasienadmisi_id
                ));
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

                $ubahCaraBayarData = UbahcarabayarR::model()->findByAttributes(array(
                    'pendaftaran_id'=>$data->pendaftaran_id
                ));

                $is_restitusi = false;
                if (!empty($ubahCaraBayarData)) {
                    $is_restitusi = true;
                }
                if (!empty($modAdmisi) && $modPendaftaran->penjamin_id != $modAdmisi->penjamin_id) {
                    $is_restitusi = true;
                }

                if ($is_restitusi) {
                    echo '<br/>PASIEN<br/>RESTITUSI';
                }

            },
        ),
        array(
            'header' => 'Respon Time',
            'type' => 'raw',
            'value' => function ($data) {
                $link = CHtml::link('<i class="icon-form-detail"></i>', Yii::app()->controller->createUrl('setResponTime', array('id' => $data->pendaftaran_id)), array(
                    'target' => 'frameResponTime', 'onclick' => "$('#dialogResponTime').dialog('open');",
                    'rel' => 'tooltip', 'title' => 'Klik untuk ubah Respon Time Pasien',
                ));
                $txt = "<hr/>" . Yii::app()->controller->renderPartial('_formRespon', array('data' => $data), true);

                return $link . $txt;
            }
        ),
        array(
            'header' => 'Status Periksa/<br>Jawaban Konsultasi',
            'type' => 'raw',
            //                        'value'=>'$data->statusperiksa.CHtml::link("<i class=icon-pencil></i>","",array("href"=>"","rel"=>"tooltip","title"=>"Klik untuk Mengubah Status Periksa","onclick"=>"{buatSessionUbahStatus($data->pendaftaran_id); ubahStatusPeriksa(); $(\'#dialogUbahStatus\').dialog(\'open\');}return false;"))',
            'value' => function ($data) use (&$is_sudah_bayar) {

                $is_sudah_bayar = in_array($data->carakeluar_id, array(
                    Params::CARAKELUAR_ID_DIPULANGKAN,
                    Params::CARAKELUAR_ID_PERMINTAANSENDIRI,
                    Params::CARAKELUAR_ID_MELARIKANDIRI,
                    Params::CARAKELUAR_ID_MENINGGAL
                )) && CustomFunction::isBayarLunas($data->pendaftaran_id);

                if ($is_sudah_bayar) {
                    if ($data->statusperiksa != Params::STATUSPERIKSA_SUDAH_PULANG) {
                        $data->statusperiksa = Params::STATUSPERIKSA_SUDAH_PULANG;
                        PendaftaranT::model()->updateByPk($data->pendaftaran_id, array(
                            'statusperiksa'=>Params::STATUSPERIKSA_SUDAH_PULANG
                        ));
                    }
                }
                echo $data->getStatus($data->statusperiksa, $data->pendaftaran_id, $data);

                if (!empty($data->konsulpoli_id)) {

                    $konsul = KonsulpoliT::model()->findByPk($data->konsulpoli_id);

                    $class_ada_jawab = !empty($konsul->jawaban_konsul) ? "ada_jawab" : "";

                    if ($data->getAsalPoli()) {
                        echo $data->getAsalPoli();
                        echo '<div class="small-container '.$class_ada_jawab.'">';
                        echo  CHtml::link('<i class="icon-form-rkontrol"></i><br>Jawaban <br>Konsultasi', Yii::app()->controller->createUrl(Yii::app()->controller->id . "/KonsultasiInternal", array("konsulpoli_id" => $data->getKonsulPasien(), 'pendaftaran_id' => $data->pendaftaran_id)), array("title" => "Klik untuk Jawab Kontrol Internal", "target" => "iframeKonsulInternal", "onclick" => '$("#konsultasiInternal").dialog("open");', "rel" => "tooltip"));
                        echo '</div>';
                    } else {
                        echo $data->getAsalPoli();
                        echo $data->getAsalRuangan();
                        echo '<div class="small-container '.$class_ada_jawab.'">';
                        echo  CHtml::link('<i class="icon-form-rkontrol"></i><br>Jawaban <br>Konsultasi', Yii::app()->controller->createUrl(Yii::app()->controller->id . "/KonsultasiInternal", array("konsulpoli_id" => $data->getKonsulPasien(), 'pendaftaran_id' => $data->pendaftaran_id)), array("title" => "Klik untuk Jawab Kontrol Internal", "target" => "iframeKonsulInternal", "onclick" => '$("#konsultasiInternal").dialog("open");', "rel" => "tooltip"));
                        echo '</div>';
                        // echo '<br>';
                        // echo '<div class="small-container">';
                        // echo  CHtml::link('<i class="icon-form-rkontrol"></i><br>Masukkan <br>Hasil Pemeriksaan', Yii::app()->controller->createUrl(Yii::app()->controller->id . "/TindakanInternal", array("ruangtindakan_id" => $data->getAsalRuangan())), array("title" => "Klik untuk Jawab Tindakan Internal", "target" => "iframeTindakanInternal", "onclick" => '$("#tindakanInternal").dialog("open");', "rel" => "tooltip"));
                        // echo '</div>';
                        echo '</br>';
                    }
                }
                

            } //'$data->getStatus($data->statusperiksa,$data->pendaftaran_id)',
        ),
        // array(
        //    'name'=>'Dokter',
        //     'type'=>'raw',
        //     'value'=>'$data->nama_pegawai',
        // ),
        array(
            'header' => 'DPJP / PPDS',
            'name' => 'DPJP / PPDS',
            'type' => 'raw',
            'value' => function ($data) {
                if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                    echo $data->gelardepan . " " . $data->nama_pegawai . " " . $data->gelarbelakang_nama;
                } else {
                    $modUbahDokter = UbahdokterR::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id, 'alasanperubahandokter' => 'Disposisi'], ['order' => 'create_time desc']);
                    $modPasienmorbi = PasienmorbiditasT::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')]);

                    if(empty($modPasienmorbi)) {
                        
                        if(Yii::app()->user->getState('kelompokpegawai_id') == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN ) {
                            echo "<div style='width:100px;'>" . 
                            
                            CHtml::link(
                                '<i class="icon-pencil-brown"></i>' . $data->gelardepan . " " . $data->nama_pegawai . " " . $data->gelarbelakang_nama,
                                    Yii::app()->controller->createUrl(Yii::app()->controller->id . "/ubahDPJP", array("pendaftaran_id" => $data->pendaftaran_id)),
                                    array("title" => "Klik untuk Mengubah Data Dokter Periksa", "target" => "iframeUbahDPJP", "onclick" => '$("#editDPJP").dialog("open");', "rel" => "tooltip")
                                )
                            
                            . "</div>";
                        } else {
                            echo "<div style='width:100px;'>" . 
                                
                                CHtml::link(
                                    '<i class="icon-pencil-brown"></i>' . $data->gelardepan . " " . $data->nama_pegawai . " " . $data->gelarbelakang_nama,
                                       '',
                                       array("title" => "Tidak Dapat Ubah DPJP ( Hanya Perawat Yang Boleh Merubah)", 'disabled' => true, 'onclick' => 'myAlert("Tidak Dapat Ubah DPJP ( Hanya Perawat Yang Boleh Merubah)")')
                                   )
                                
                                . "</div>";
                        }
                            
                        
                    } else {
                        if($data->pegawai_id != Yii::app()->user->getState('pegawai_id')) {
                            echo "<div style='width:100px;'>" . 
                            
                            CHtml::link(
                                '<i class="icon-pencil-brown"></i>' . $data->gelardepan . " " . $data->nama_pegawai . " " . $data->gelarbelakang_nama,
                                   '',
                                   array("title" => "Tidak Dapat Ubah DPJP karena sudah disposisi", 'disabled' => true, 'onclick' => 'myAlert("Hanya Dokter ' .$data->nama_pegawai . ' Yang dapat mengubah")')
                               )
                            
                            . "</div>";
                        } else {
                            if(!empty($modUbahDokter)) {
                                echo "<div style='width:100px;'>" . 
                                
                                CHtml::link(
                                    '<i class="icon-pencil-brown"></i>' . $data->gelardepan . " " . $data->nama_pegawai . " " . $data->gelarbelakang_nama,
                                       '',
                                       array("title" => "Tidak Dapat Ubah DPJP karena sudah disposisi", 'disabled' => true, 'onclick' => 'myAlert("Tidak Dapat Ubah DPJP karena sudah disposisi")')
                                   )
                                
                                . "</div>";
                            } else {
                                echo "<div style='width:100px;'>" . 
                                
                                CHtml::link(
                                    '<i class="icon-pencil-brown"></i>' . $data->gelardepan . " " . $data->nama_pegawai . " " . $data->gelarbelakang_nama,
                                       Yii::app()->controller->createUrl(Yii::app()->controller->id . "/ubahDPJP", array("pendaftaran_id" => $data->pendaftaran_id)),
                                       array("title" => "Klik untuk Mengubah Data Dokter Periksa", "target" => "iframeUbahDPJP", "onclick" => '$("#editDPJP").dialog("open");', "rel" => "tooltip")
                                   )
                                
                                . "</div>";
                            }
                        }
                    }
                    
                }
                echo "<hr>";
                if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                    echo $data->jeniskasuspenyakit_nama;
                } else {
                    echo CHtml::hiddenField("RDInfoKunjunganRDV[" . $data->pendaftaran_id . "][pendaftaran_id]", $data->pendaftaran_id, array("id" => "pendaftaran_id", "onkeypress" => "return $(this).focusNextInputField(event)", "class" => "span3"));
                    
                    // CHtml::link("<i class=icon-form-ubah></i> " . $data->jeniskasuspenyakit_nama, "javascript:void(0)", array("onclick" => "ubahKasusPenyakit(this," . $data->pendaftaran_id . "," . $data->jeniskasuspenyakit_id . ");return false;", "class" => "kasus_penyakit", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Mengubah Data Kasus Penyakit"));
                    echo "<br>";
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
                  }
                echo "<hr>";
                
                $modPemindahanPasien = PemindahanpasienT::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id, 'ispasienditerima' => true]);

                
                if(empty($modPemindahanPasien)) {
                    echo "<div style='width:100px;'>" . 
                                
                    CHtml::link(
                        '<i class="icon-form-ubah"></i> Disposisi / Alih Leader',
                           '',
                           array("title" => "Tidak Dapat Ubah DPJP karena sudah disposisi", 'disabled' => true, 'onclick' => 'myAlert("Tidak Dapat di disposisi karena pasien belum di transfer ke emergency care")')
                       )
                    
                    . "</div>";
                } else {
                    echo "<div style='width:100px;'>" . 
                    CHtml::link(
                        '<i class="icon-form-ubah"></i> Disposisi / Alih Leader',
                            Yii::app()->controller->createUrl(Yii::app()->controller->id . "/UbahDokterPeriksa", array("pendaftaran_id" => $data->pendaftaran_id)),
                            array("title" => "Klik untuk Mengubah Data Dokter Periksa", "target" => "iframeUbahDokter", "onclick" => 'cekAkses(' . Yii::app()->user->getState('kelompokpegawai_id') . ', '. $data->pegawai_id .')', "rel" => "tooltip")
                        )
                    
                    . "</div>";
                }
               
                
                echo "<hr>";

                $dispos = UbahdokterR::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id, 'alasanperubahandokter' => 'Disposisi'], ['order' => 'create_time desc']);

                $alihLeader = UbahdokterR::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id, 'alasanperubahandokter' => 'ALIH LEADER'], ['order' => 'create_time desc']);

                if(!empty($dispos) && empty($alihLeader)) {
                    if($dispos->dokterlama_id != Yii::app()->user->getState('pegawai_id') && Yii::app()->user->getState('kelompokpegawai_id') != Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN) {
                        if($dispos->is_approve === null) {
                            // setuju
                            echo CHtml::Link("<i class='icon-form-check'></i> <br><b>Terima Disposisi</b>","#", [
                                "class"=>"btn-small", 
                                "onClick" => "approve(" . $dispos->ubahdokter_id . ", " . Yii::app()->user->getState('kelompokpegawai_id'). ", '" . 'Yakin Ingin Menyetujui Disposisi ?' . "')"
                            ]);

                            echo '<br>';

                            // tolak
                            // echo CHtml::Link("<i class='icon-form-silang'></i> <b>Tolak Disposisi</b>",Yii::app()->controller->createUrl(Yii::app()->controller->id . "/RejectedAlihLeader", array("ubahdokter_id" => $dispos->ubahdokter_id)), [
                            //     "class"=>"btn-small", 
                            //     "target" => "iframeAlihLeaderDanDispos",
                            //     "onClick" => '$("#dialogTolakAlihLeaderDanDispos").dialog("open");'
                            // ]);

                            echo '<br> <hr>';
                        } else {
                            echo '<div class="badge badge-success" style="padding:8px;font-size:10pt">Disposisi <br> Sudah Disetujui</div>';
                        }
                    } else {
                        if($dispos->is_approve === null) {
                            echo '<div class="badge badge-danger" style="padding:8px;font-size:10pt">Disposisi <br> Belum Disetujui</div>';
                        } else {
                            echo '<div class="badge badge-success" style="padding:8px;font-size:10pt">Disposisi <br> Sudah Disetujui</div>';
                        }
                    }
                } else {
                    if(!empty($alihLeader)) {
                        if($alihLeader->dokterbaru_id == Yii::app()->user->getState('pegawai_id')) {
                            if($alihLeader->is_approve === null) {
                                // setuju
                                echo CHtml::Link("<i class='icon-form-check'></i> <b>Setujui Alih Leader</b>","#", [
                                    "class"=>"btn-small", 
                                    "onClick" => "approve(" . $alihLeader->ubahdokter_id . ", " . Yii::app()->user->getState('kelompokpegawai_id'). ", '" . 'Yakin Ingin Menyetujui Alih Leader ?' . "')"
                                ]);

                                echo '<br>';

                                // tolak
                                echo CHtml::Link("<i class='icon-form-silang'></i> <b>Tolak Alih Leader</b>",Yii::app()->controller->createUrl(Yii::app()->controller->id . "/RejectedAlihLeader", array("ubahdokter_id" => $alihLeader->ubahdokter_id)), [
                                    "class"=>"btn-small", 
                                    "target" => "iframeAlihLeaderDanDispos",
                                    "onClick" => '$("#dialogTolakAlihLeaderDanDispos").dialog("open");'
                                ]);

                                echo '<br> <hr>';
                            } else {
                                if($alihLeader->is_approve === false) {
                                    echo '<div class="badge badge-danger" style="padding:8px;font-size:10pt">Alih Leader <br> Di Tolak</div>';
                                } else {
                                    echo '<div class="badge badge-success" style="padding:8px;font-size:10pt">Alih Leader <br> Sudah Disetujui</div>';
                                }
                            }
                        } else {
                            if($alihLeader->is_approve === null) {
                                echo '<div class="badge badge-warning" style="padding:8px;font-size:10pt;color:black">Alih Leader <br> Belum Disetujui</div>';
                            } else if($alihLeader->is_approve === false) {
                                echo '<div class="badge badge-danger" style="padding:8px;font-size:10pt">Alih Leader <br> Di Tolak</div>';
                            } else {
                                echo '<div class="badge badge-success" style="padding:8px;font-size:10pt">Alih Leader <br> Sudah Disetujui</div>';
                            }
                        }
                    }
                }

                // riwayat dpjp
                echo "<hr>";
                echo '<div class="small-container">' . CHtml::link('<i class="icon-form-detail"></i><br>Riwayat Disposisi / Alih Leader', Yii::app()->controller->createUrl('/rawatDarurat/daftarPasien/viewRiwayatDPJP', array(
                    'pendaftaran_id' => $data->pendaftaran_id,
                )), array(
                    'target' => 'frameRiwayatDPJP',
                    'onclick' => "$('#dialogRiwayatDPJP').dialog('open');",
                )) . '</div>';
                echo "<hr>";

                
            },
        ), 
        // array(
        //     'name' => 'Draft Triage Pasien',
        //     'type' => 'raw',
        //     'value' => function ($data) use (&$ases) {
                
        //             $ases = AsesmentriaseT::model()->findByAttributes([
        //                 'pendaftaran_id' => $data->pendaftaran_id
        //             ]);
                
        //             return CHtml::link(
        //                 !empty($ases)?"SUDAH ADA":"BELUM ADA",
        //                 'javascript:;',
        //                 array(                            
        //                     'onclick' => empty($ases)?'$("#dialogDraft").dialog("open");setDaftarId('.$data->pendaftaran_id.')':'',
        //                     "rel" => "tooltip",
        //                     "title" => "Klik untuk menampilkan list daftar asesmen triage",
        //                     "class" => !empty($ases)?"btn btn-success":"btn btn-danger",
        //                     )
        //             );
        array(
            'name' => 'No Triage Pasien',
            'type' => 'raw',
            'value' => function ($data) {                
                if (!empty($data->notriage_pasien_id)) {
                    return CHtml::link(
                        $data->no_bed_triage . " - " . $data->no_triage_pasien,
                        Yii::app()->createUrl("/rawatDarurat/daftarPasien/UpdateTriagePasien", array("pendaftaran_id" => $data->pendaftaran_id, "notriage_pasien_id" => $data->notriage_pasien_id)),
                        array(
                            "target" => "frameTriagePasien",
                            'onclick' => 'cekTriage(' . $data->pendaftaran_id . ',"' . $data->statusperiksa . '","' . $data->nama_pasien . '");',
                           "rel" => "tooltip",
                            "title" => "Klik untuk memilih nomor Triage",
                            "class" => "btn btn-success",
                            )
                        );
                    }else{
                        return CHtml::link(
                            'Pilih No Triage',
                            Yii::app()->createUrl("/rawatDarurat/daftarPasien/UpdateTriagePasien", array("pendaftaran_id" => $data->pendaftaran_id, "notriage_pasien_id" => $data->notriage_pasien_id)),
                            array(
                            "target" => "frameTriagePasien",
                            'onclick' => 'dialogTambahTriagePasien(' . $data->pendaftaran_id . ',"' . $data->statusperiksa . '","' . $data->nama_pasien . '")',
                            "rel" => "tooltip",
                            "title" => "Klik untuk memilih nomor Triage",
                            "class" => "btn btn-info",
                        )
                    );
                }
            },
        ),        

        // [
        //     'header' => 'Kategori Pasien',
        //     'value' => function($data) use (&$ases) {
        //         if (!empty($ases)){
        //             if ($ases->kategori_i){
        //                 return '1';
        //             }else if ($ases->kategori_ii){
        //                 return '2';
        //             }else if ($ases->kategori_iii){
        //                 return '3';
        //             }else if ($ases->kategori_iv){
        //                 return '4';
        //             }else if ($ases->kategori_v){
        //                 return '5';
        //             }
        //         }
        //     }
      // ]   ,         
        /*
                    array(
                       'name'=>'Transportasi',
                        'type'=>'raw',
                        'value'=>'(!empty($data->transportasi))? $data->transportasi : "-"',
                    ),
                    array(
                       'name'=>'Cara Masuk',
                        'type'=>'raw',
                        'value'=>'(!empty($data->caramasuk_nama))? $data->caramasuk_nama : "-"',
                    ),
                     * 
                     */
        //                    array(
        //                       'name'=>'kelaspelayanan_nama',
        //                        'type'=>'raw',
        //                        'value'=>'$data->kelaspelayanan_nama',
        //                    ),
        // array(
        //    'name'=>'pembayaranpelayanan_id',
        //     'type'=>'raw',
        //     'value'=>'$data->pembayaranpelayanan_id',
        // ),
        array(
            'name' => 'Pemeriksaan Pasien',
            'type' => 'raw',
            'value' => function ($data){
                $dispos = UbahdokterR::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id, 'alasanperubahandokter' => 'Disposisi'], ['order' => 'create_time desc']);
                
                $onclick = "javascript:cektindaklanjut()";

                if(!empty($data->no_triage_pasien)){
                    if(!empty($dispos) && $dispos->is_approve === null && Yii::app()->user->getState('pegawai_id') != $dispos->dokterlama_id) {
                        $onclick = "javascript:myAlert('Pasien belum dilakukan penerimaan disposisi')";
                    } else {
                        if($data->is_kecelakaan && $data->carabayar_id == Params::CARABAYAR_ID_BPJS) {
                            if(!empty($data->sep_id)) {
                                $modSep = SepT::model()->findByPk($data->sep_id);
                                if(!empty($modSep)) {
                                    if($modSep->statuskecelakaan_kode == 0) {
                                        $onclick = "javascript:alertMessage('Berkas pasien kecelakaan lalu lintas masih belum lengkap dan SEP pasien masih berstatus Bukan Kecelakaan.', " . $data->pendaftaran_id . ")";
                                    }
                                }
                            } else {
                                $onclick = 'javascript:alertMessage("Pasien belum memiliki SEP", ' . $data->pendaftaran_id . ')';
                            }
                        } else {
                            $onclick = Yii::app()->controller->createUrl("/rawatDarurat/pemeriksaanPasienTRD",array("pendaftaran_id"=>$data->pendaftaran_id));
                        }
                    }
                }else {
                    $onclick = "javascript:cektindaklanjut()";
                }

                

               return CHtml::link("<i class='icon-form-periksa'></i><br>Periksa Pasien", $onclick ,array("rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"));
               
            }
            
            
           
        ),
        array(
            'name' => 'Rekam Medis Elektronik Pasien',
            'type' => 'raw',
            // 'value' => '',
            'value' => function ($data) {
                $link = '<div class="small-container">';
                // $link .= CHtml::link('<i style="background: url(' . Yii::app()->getBaseUrl('webroot') . '/images/icon/doctor.png) center center no-repeat; display: inline-block; background-size: contain; width: 26px; height: 26px;"></i><br>Dokter ', Yii::app()->controller->createUrl("RekamMedikElektronikPasienRD/index", array("pendaftaran_id" => $data->pendaftaran_id, 'type' => 'Dokter')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan rekam medik elektronik oleh dokter")) . '<br><br><hr>';
                $link .= CHtml::link('<i style="background: url(' . Yii::app()->getBaseUrl('webroot') . '/images/icon/doctor.png) center center no-repeat; display: inline-block; background-size: contain; width: 26px; height: 26px;"></i><br>Dokter ', 'javascript:void(0)', array("id" => "$data->no_pendaftaran", 'style' => 'opacity:0.6; cursor:not-allowed;')) . '<br><br><hr>';
                $link .= '</div>';
                $link .= '<div class="small-container">';
                // $link .= CHtml::link('<i style="background: url(' . Yii::app()->getBaseUrl('webroot') . '/images/icon/nurse.png) center center no-repeat; display: inline-block; background-size: contain; width: 26px; height: 26px;"></i><br>Perawat / Bidan ', Yii::app()->controller->createUrl("RekamMedikElektronikPasienRD/index", array("pendaftaran_id" => $data->pendaftaran_id, 'type' => 'Perawat')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan rekam medik elektronik oleh perawat"));
                $link .= CHtml::link('<i style="background: url(' . Yii::app()->getBaseUrl('webroot') . '/images/icon/nurse.png) center center no-repeat; display: inline-block; background-size: contain; width: 26px; height: 26px;"></i><br>Perawat / Bidan ', 'javascript:void(0)', array("id" => "$data->no_pendaftaran", "rel" => "tooltip", 'style' => 'opacity:0.6; cursor:not-allowed;'));
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
                // return '<div class="small-container">' . CHtml::link('<i class="icon-form-detail"></i><br>Riwayat', Yii::app()->controller->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/updateRiwayatVaksinasi', array(
                //     'pendaftaran_id' => $data->pendaftaran_id,
                // )), array(
                //     'target' => 'frameRiwayatVaksinasi',
                //     'onclick' => "$('#dialogRiwayatVaksinasi').dialog('open');",
                // )) . '</div>';
                return '<div class="small-container">' . CHtml::link('<i class="icon-form-detail"></i><br>Riwayat', 'javascript:void(0);', array('style' => 'opacity:0.6; cursor:not-allowed;')) . '</div>';
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        // array(
        //     'name' => 'Persetujuan',
        //     'type' => 'raw',
        //     'value' => function ($data) {
        //         $link = '<div class="small-container">';
        //         $link .= CHtml::link('<i class="icon-form-file-a-edit"></i><br>Tindakan', Yii::app()->controller->createUrl("PersetujuanTindakanTRD/index", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat persetujuan tindakan"));
        //         $link .= '</div>';
        //         $link .= '<div class="small-container">';
        //         $link .= CHtml::link('<i class="icon-form-file-b-edit"></i><br>Inform Consent', Yii::app()->controller->createUrl("PersetujuanTindakanUmum/index", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan Inform Consent (Persetujuan)"));
        //         $link .= '</div>';
        //         $link .= '<div class="small-container">';
        //         $link .= CHtml::link('<i class="icon-form-file-c-edit"></i><br>Anestesi', Yii::app()->controller->createUrl("PersetujuanTindakanAnastesiRD/index", array("pendaftaran_id" => $data->pendaftaran_id, "noframe" => 1)), array("id" => $data->no_pendaftaran . "_antrian", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat persetujuan tindakan anestesi"));
        //         $link .= '</div>';
        //         return $link;
        //     },
        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        // ),
        // array(
        //     'name' => 'Penolakan',
        //     'type' => 'raw',
        //     'value' => function ($data) {
        //         $link = '<div class="small-container">';
        //         $link .= CHtml::link('<i class="icon-form-file-a-hapus"></i><br>Tindakan ', Yii::app()->controller->createUrl("PersetujuanTindakanTRD/penolakan", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat penolakan tindakan"));
        //         $link .= '</div>';
        //         $link .= '<div class="small-container">';
        //         $link .= CHtml::link('<i class="icon-form-file-b-hapus"></i><br>Inform Refusal', Yii::app()->controller->createUrl("PersetujuanTindakanUmum/penolakan", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan Inform Consent (Penolakan)"));
        //         $link .= '</div>';
        //         $link .= '<div class="small-container">';
        //         $link .= CHtml::link('<i class="icon-form-file-c-hapus"></i><br>Anestesi', Yii::app()->controller->createUrl("PersetujuanTindakanAnastesiRD/penolakan", array("pendaftaran_id" => $data->pendaftaran_id, "noframe" => 1)), array("id" => $data->no_pendaftaran . "_antrian", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat penolakan tindakan anestesi"));
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
        //             $str .= CHtml::link("<icon class='icon-form-detail'></icon><br>General<br>Consent", Yii::app()->controller->createUrl('suratPersetujuanUmumRD/view', array('pendaftaran_id' => $data->pendaftaran_id)), array("target" => "frameGeneralConsent", "rel" => "tooltip", "title" => "Klik untuk melihat General Consent", "onclick" => "$('#dialogGeneralConsent').dialog('open');"));
        //             $str .= '</div>';
        //         }
        //         $str .= '<div class="small-container">';
        //         $str .= CHtml::link("<icon class='icon-form-file-a-lihat'></icon><br>Detail", Yii::app()->controller->createUrl('pencarianPasienRD/detailPersetujuanTindakan', array('id' => $data->pendaftaran_id)), array("target" => "framePersetujuanTindakan", "rel" => "tooltip", "title" => "Klik untuk melihat Detail Persetujuan & Penolakan", "onclick" => "$('#dialogPersetujuanTindakan').dialog('open');"));
        //         $str .= '</div>';
        //         $str .= '<div class="small-container">';
        //         $str .= CHtml::link("<icon class='icon-form-file-b-lihat'></icon><br>Inform<br>Consent", Yii::app()->controller->createUrl('pencarianPasienRD/detailInformConsent', array('id' => $data->pendaftaran_id)), array("target" => "frameInformConsent", "rel" => "tooltip", "title" => "Klik untuk melihat Inform Consent", "onclick" => "$('#dialogInformConsent').dialog('open');"));
        //         $str .= '</div>';
        //         $str .= '<div class="small-container">';
        //         $str .= CHtml::link("<icon class='icon-form-file-c-lihat'></icon><br>Anestesi", Yii::app()->controller->createUrl('pencarianPasienRD/detailTindakanAnestesi', array('id' => $data->pendaftaran_id)), array("target" => "frameTindakanAnestesi", "rel" => "tooltip", "title" => "Klik untuk melihat Persetujuan Tindakan Anestesi", "onclick" => "$('#dialogTindakanAnestesi').dialog('open');"));
        //         $str .= '</div>';
        //         return $str;
        //     },
        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        // ),
        array(
            'header' => 'Tindak Lanjut',
            'type' => 'raw',
            'value' => function ($data) use ($is_validasi_pja, &$is_sudah_bayar) {
                $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));
                if (!empty($admisi)) {
                    $kamar = empty($admisi->kamarruangan_id) ? "" : ($admisi->kamarruangan->kamarruangan_nokamar . "<br>" . $admisi->kamarruangan->kamarruangan_nobed);
                    $ruangan = empty($admisi->ruangan_id) ? "" : $admisi->ruangan->ruangan_nama;
                    return $ruangan . "</br>" . $kamar;
                }
                if (($data->pasienpulang_id != 0) or ($data->carakeluar != "")) {

                    $pulang = PasienpulangT::model()->findByPk($data->pasienpulang_id);


                    // echo 'ini tes';
                    $str = "";
                    // $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$data->pendaftaran_id));
                    if (!empty($admisi)) {
                        $kamar = empty($admisi->kamarruangan_id) ? "" : ($admisi->kamarruangan->kamarruangan_nokamar . "<br>" . $admisi->kamarruangan->kamarruangan_nobed);
                        $ruangan = empty($admisi->ruangan_id) ? "" : $admisi->ruangan->ruangan_nama;

                        $str .= $ruangan . "</br>" . $kamar;
                    } else {
                        // vaR_dump($data->carakeluar_id);
                        if ($is_sudah_bayar) {
                            $str .= "CLOSE<br/>BILLING";
                        } else {
                            $pemPel = PembayaranpelayananT::model()->find("pendaftaran_id = '" . $data->pendaftaran_id . "' and orderbatalpembayaranpelayanan_id is null");
                            if (empty($pemPel)) {
                                if (!empty($pulang) && $pulang->carakeluar_id == Params::CARAKELUAR_ID_MENINGGAL && $pulang->isapprovaltindaklanjut) {
                                    $str .= $data->carakeluar; //. CHtml::link("<i class='icon-form-sampah'></i>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/BatalRawatInap', array("pendaftaran_id" => $data->pendaftaran_id)), array("title" => "Klik untuk Batal Proses Tindak Lanjut Pasien", "target" => "iframeBatalRawatInap", "onclick" => "myAlert('')", "rel" => "tooltip"));
                                } else {
                                    $str .= $data->carakeluar . CHtml::link("<i class='icon-form-sampah'></i>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/BatalRawatInap', array("pendaftaran_id" => $data->pendaftaran_id)), array("title" => "Klik untuk Batal Proses Tindak Lanjut Pasien", "target" => "iframeBatalRawatInap", "onclick" => "$('#dialogBatalRawatInap').dialog('open');", "rel" => "tooltip"));
                                }
                            } else {
                                $str .= $data->carakeluar . CHtml::link("<i class='icon-form-sampah'></i>", 'javascript:;', array("title" => "Klik untuk Batal Proses Tindak Lanjut Pasien", "onclick" => "alert('Maaf, Pembayaran Pada Pasien ini Belum Dibatalkan')", "rel" => "tooltip"));
                            }
                        }
    


                    }

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
                    
                    $spri = SuratperintahranapT::model()->findByAttributes(['pendaftaran_id' => $data->pendaftaran_id]);
                    if(empty($spri) && $data->carakeluar_id == Params::CARAKELUAR_ID_RAWATINAP) {
                        $onClickPJA = "myAlert('Validasi PJA tidak bisa dilakukan karena SPRI belum diterbitkan oleh dokter'); return false;";
                    }

                    
                    // if (!empty($pulang) && $pulang->carakeluar_id == Params::CARAKELUAR_ID_MENINGGAL && !$pulang->isapprovaltindaklanjut) {
                    //     $onClickPJA = "myAlert('PJA IKF belum melakukan validasi'); return false;";
                    // }

                    $linkPJA = CHtml::link(
                        '<i class="icon-form-detail"></i><br/>Validasi PJA', '#', array(
                            "id" => "$data->pendaftaran_id",
                            "rel" => "tooltip",
                            "title" => "Klik untuk Validasi PJA",
                            "onclick" => $onClickPJA,
                        )
                    );

                    if ($is_validasi_pja) {

                    $crPJA = new CDbCriteria;
                    $crPJA->compare('pendaftaran_id', $data->pendaftaran_id);
                    $crPJA->compare('ruangan_id_approvaltindaklanjut', Yii::app()->user->getState('ruangan_id'));
                    $crPJA->addCondition('isapprovaltindaklanjut = true');

                    $tindakanPJA = TindakanpelayananT::model()->count($crPJA);
                    $oaPJA = ObatalkespasienT::model()->count($crPJA);

                    // var_dump($tindakanPJA, $oaPJA);


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

                    if (($tindakanPJABelum + $oaPJABelum == 0) && ($tindakanPJA + $oaPJA > 0)) {
                        $tindakanPJA = TindakanpelayananT::model()->find($crPJA);
                        $oaPJA = ObatalkespasienT::model()->find($crPJA);

                        // cek apakah sudah di-verifikasi
                        $crPJA->addCondition('verifikasitagihan_id is not null');
                        $tindakanPJAVerif = TindakanpelayananT::model()->count($crPJA);
                        $oaPJAVerif = ObatalkespasienT::model()->count($crPJA);

                        $pegPJA = PegawaiM::model()->findByPk($tindakanPJA->userapprovaltindaklanjut_id ?? $oaPJA->userapprovaltindaklanjut_id);
                        $namapja = $pegPJA->namaLengkap ?? "Validasi PJA";
                        $tgl_verif = $tindakanPJA->tanggal_approvaltindaklanjut ?? $oaPJA->tanggal_approvaltindaklanjut;

                        if (!empty($tgl_verif)) {
                            $namapja .= "<br/>".MyFormatter::formatDateTimeForUser($tgl_verif);
                        }

                        $linkPJA = CHtml::link('<i class="icon-form-check"></i><br/>'.$namapja, '#', array(
                            'onclick'=>'return false',
                        ));

                        if ($tindakanPJAVerif + $oaPJAVerif == 0 && empty($admisi)) {
                            $linkPJA .= "<br/>".$linkBatalPJA;
                        }
                    }
                    } else {
                        $linkPJA = "";
                    }
                    $htmlSuratRanap = "<hr/>" . $linkPJA;
                    if($data->carakeluar_id == Params::CARAKELUAR_ID_RAWATINAP) {
                        $htmlSuratRanap = (empty($admisi) ? "<hr/>" . CHtml::link(
                            '<i class="icon-form-detail"></i><br/>Surat Perintah',
                            Yii::app()->controller->createUrl("/rawatJalan/suratPerintahRawatInap/index", array("pendaftaran_id" => $data->pendaftaran_id)),
                            array(
                                "id" => "$data->pendaftaran_id",
                                "rel" => "tooltip",
                                "title" => "Klik untuk Surat Perintah Rawat Inap",
                                "target" => "frameSuratPerintahRanap",
                                "onclick" => '$("#dialogSuratPerintahRanap").dialog("open");'
                            )
                        ) . "<hr/>" . $linkPJA : "");
                    }

                    return $str . $htmlSuratRanap;
                } else {
                    return '<div class="small-container">' . CHtml::link(
                        '<icon class="icon-form-ri"></icon><br>Tindak Lanjut',
                        '',
                        // Yii::app()->createUrl("/rawatDarurat/daftarPasien/PasienPulang", 
                        // array("pendaftaran_id" => $data->pendaftaran_id, "dialog" => true)),
                        array(
                            // "target" => "iframePasienPulang",
                            //"onclick"=>"$('#dialogPasienPulang').dialog('open');",
                            "onclick" => "cekVerifikasiTindakLanjut(this,'" . $data->pendaftaran_id . "');",
                            "rel" => "tooltip",
                            "title" => "Klik untuk menambahkan tindak lanjut",
                        )
                    ) . '</div>';
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            //'(($data->pasienpulang_id != 0) OR ($data->carakeluar != "")) ? $data->carakeluar : 
        ),
        array(
            'header' => 'Pemindahan Pasien / Rincian Tagihan',
            'type' => 'raw',
            'value' => function ($data) {
                $htmlLink = CHtml::link('<i class="icon-form-detail"></i><br>Transfer', 'javascript:;', array(
                    'rel' => 'tooltip',
                    'title' => 'Pemindahan Pasien',
                    'onclick' => 'cekNoTriage( ' . $data->pendaftaran_id . ')'
                ));

                $modFormTransfer = PemindahanpasienT::model()->findAllByAttributes(array('ruangantujuan_id' => Yii::app()->user->getState("ruangan_id"), 'pendaftaran_id' => $data->pendaftaran_id), array('condition' => '(ispasienditerima IS NULL OR ispasienditerima = false)'));
                $linkPenerima = "";
                if (isset($modFormTransfer) && count($modFormTransfer) > 0) {
                    $linkPenerima = CHtml::link('<i class="icon-form-check"></i><br>Terima Transfer', Yii::app()->createUrl("/rawatDarurat/pemindahanPasienRD/index", array("pendaftaran_id" => $data->pendaftaran_id, 'pasienditerima' => 'diterima')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Penerimaan Pemindahaan Pasien"));
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

                    $htmlLink2 = '<div class="small-container">' . CHtml::link('<i class="icon-form-detail"></i><br>Rincian Tagihan Sementara', Yii::app()->controller->createUrl('/billingKasir/pembayaranTagihanPasien/printRincianBelumBayarRD', array(
                        "instalasi_id" => $data->instalasi_id, "pendaftaran_id" => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id, "frame" => true)),
                         array('target' => 'iframeRincianTagihanSementara',  "rel" => "tooltip", "title" => "Klik untuk Melihat Detail Riwayat Pemindahaan Pasien",
                        'onclick' => "$('#dialogRincianTagihanSementara').dialog('open');",
                    )) . '</div>';
                    
                    // $htmlLink2 = CHtml::Link("<i class=\"icon-form-detailtagihan\"></i><br>Rincian Tagihan Sementara", Yii::app()->controller->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayarRD", array("instalasi_id" => $data->instalasi_id, "pendaftaran_id" => $data->pendaftaran_id, "pasienadmisi_id" => $data->pasienadmisi_id, "frame" => true)), [
                    //     "target" => "iframeRincianTagihanSementara",
                    //     "onclick" => "$('#dialogRincianTagihanSementara').dialog('open');",
                    //     "rel" => "tooltip",
                    //     "title" => "Klik untuk Melihat Detail Riwayat Pemindahaan Pasien",
                        
                    // ]);

              return $htmlLink .'<br/>'.$linkPenerima.'<br>'.$linkLihat.'<br>'.$htmlLink2;
            },
            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
        ),
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
        /*
					array(
						'header'=>'Tindak Lanjut<br>ke Rawat Inap',
						'type'=>'raw',
						'value'=>'($data->statusperiksa == "'.Params::STATUSPERIKSA_SEDANG_DIRAWATINAP.'") ? 
							("Pasien di Rawat Inap<br>".$data->getNamaKamar()."<br>".$data->getNoBed().
							CHtml::link("<i class=\'icon-form-sampah\'></i>", Yii::app()->controller->createUrl("/'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/BatalRawatInap",array("pendaftaran_id"=>$data->pendaftaran_id)) , array("title"=>"Klik untuk Batal Proses Tindak Lanjut Pasien","target"=>"iframeBatalRawatInap", "onclick"=>"$(\"#dialogBatalRawatInap\").dialog(\"open\");", "rel"=>"tooltip")))
							:  
							CHtml::link("<i class=\'icon-form-ri\'></i>", Yii::app()->createUrl("/'.Yii::app()->controller->module->id.'/TindakLanjutDariRD/tindakLanjutRI", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id)),
								array("class"=>"",
								"target"=>"frameTindakLanjut",
								"rel"=>"tooltip",
								"title"=>"Klik untuk Proses Tindak Lanjut Pasien",
								"onclick"=>"$(\'#dialogTindakLanjut\').dialog(\'open\');"))',
						'htmlOptions'=>array('style'=>'text-align: center; width:60px')
					),
                     * 
                     */
        /*array(
                        'header'=>'Rincian Detail Tagihan',
                        'type'=>'raw',
//                        'value'=>'CHtml::link("<icon class=\'icon-list-brown\'></icon>", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/RinciantagihanpasienExtendsV/rincianBelumBayarRD", array("id"=>$data->pendaftaran_id)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');","rel"=>"tooltip", "title"=>"Klik untuk melihat rincian tagihan"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
                        'value'=>'CHtml::link("<icon class=\'icon-form-detailtagihan\'></icon>", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/printDetailRincianBelumBayar", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');","rel"=>"tooltip", "title"=>"Klik untuk melihat detail rincian tagihan"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
                    ),  */
        /*array(
                        'header'=>'Rincian Tagihan',
                        'type'=>'raw',
//                        'value'=>'CHtml::link("<icon class=\'icon-list-brown\'></icon>", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/RinciantagihanpasienExtendsV/rincianBelumBayarRD", array("id"=>$data->pendaftaran_id)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');","rel"=>"tooltip", "title"=>"Klik untuk melihat rincian tagihan"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
                        'value'=>'CHtml::link("<icon class=\'icon-form-detail\'></icon>", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/printRincianBelumBayar", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');","rel"=>"tooltip", "title"=>"Klik untuk melihat rincian tagihan"))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
                    ),*/
        array(
            'header' => 'Status Dokumen',
            'type' => 'raw',
            'value' => function ($data) {
                $ruangan_id = Yii::app()->user->getState('ruangan_id');
                $status_dokumen = RDPendaftaranT::model()->findByPk($data->pendaftaran_id);
                $dok =   CHtml::link("<i class='icon-file' style='margin: 7px;'></i><br>File Rekam Medis<br>", Yii::app()->controller->createUrl('/rawatJalan/DaftarPasien/riwayatDokfilerm', array('pendaftaran_id' => $data->pendaftaran_id)), array("target" => "frameRiwayatDokfilerm", "rel" => "tooltip", "title" => "Klik untuk melihat File Rekam Medis", "onclick" => "$('#dialogDokFilerm').dialog('open');"));
                
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
                    if (Yii::app()->user->getState('ruangan_id') == $status_dokumen->pengirimanrm->ruanganpenerima_id) {
                        //var_dump($data->statusperiksa);
                        if ($data->statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) {
                            return CHtml::link(
                                "<i></i> $status_dokumen->statusdokrm",
                                Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/statusDokumenKirim', array("pengirimanrm_id" => $status_dokumen->pengirimanrm_id, "pendaftaran_id" => $data->pendaftaran_id)),
                                array(
                                    "class" => "btn btn-primary",
                                    "target" => "frameStatusDokumen",
                                    "rel" => "tooltip",
                                    "title" => "Klik untuk mengirim dokumen ke ruangan lain",
                                    "onclick" => 'myConfirm("Pasien Masih Dalam Status Menunggu Admisi. Apakah Anda akan melanjutkan transaksi?","Perhatian",function(r){if(r){$("#dialogStatusDokumen").dialog("open")}});'
                                )
                            ) . '<br><br>' . $dok . '<br><br>' . $pelayanan;
                        } else {
                            return CHtml::link(
                                "<i></i> $status_dokumen->statusdokrm",
                                Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/statusDokumenKirim', array("pengirimanrm_id" => $status_dokumen->pengirimanrm_id, "pendaftaran_id" => $data->pendaftaran_id)),
                                array(
                                    "class" => "btn btn-primary",
                                    "target" => "frameStatusDokumen",
                                    "rel" => "tooltip",
                                    "title" => "Klik untuk mengirim dokumen ke ruangan lain",
                                    "onclick" => '$("#dialogStatusDokumen").dialog("open");'
                                )
                            ) . '<br><br>' . $dok . '<br><br>' . $pelayanan;;
                        }
                    } else {
                        return $data->getStatusDokumen($status_dokumen->pengirimanrm_id, $status_dokumen->statusdokrm, $data->pendaftaran_id) . '<br><br>' . $dok  . '<br><br>' . $pelayanan;;
                    }
                } else {
                    return $data->getStatusDokumen($status_dokumen->pengirimanrm_id, $status_dokumen->statusdokrm, $data->pendaftaran_id) . '<br><br>' . $dok  . '<br><br>' . $pelayanan;;
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Batal Periksa',
            'type' => 'raw',
            'value' => function ($data) {
                $pen = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                if (!empty($pen->pengirimanrm_id)) {
                    if (Yii::app()->user->getState('ruangan_id') == $pen->pengirimanrm->ruanganpenerima_id) {
                        if (empty($pen->pengirimanrm->tglterimadokrm)) {
                            return CHtml::link('<i class="icon-form-silang"></i>', "javascript:;", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", 'data-placement' => 'left', 'onclick' => 'myAlert("Harap terima dan kembalikan dokumen RM sebelum Anda membatalkan pemeriksaan pasien ' . $data->nama_pasien . ' ","Perhatian")'));
                        } else {
                            return CHtml::link('<i class="icon-form-silang"></i>', "javascript:;", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", 'data-placement' => 'left', 'onclick' => 'myAlert("Harap kembalikan dokumen RM sebelum Anda membatalkan pemeriksaan pasien ' . $data->nama_pasien . ' ","Perhatian")'));
                        }
                    } else {
                        if (($data->pasienpulang_id != 0) or ($data->carakeluar != "")) return "";
                        $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));
                        //if (empty($admisi)) return CHtml::link('<i class="icon-form-silang"></i>', "javascript:batalperiksa($data->pendaftaran_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan", 'data-placement'=>'left'));
                        if (empty($admisi)) return CHtml::link('<i class="icon-form-silang"></i>', "javascript:;", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", 'data-placement' => 'left', 'onclick' => 'dialogBatalPeriksaRd(' . $data->pendaftaran_id . ',"' . $data->statusperiksa . '","' . $data->nama_pasien . '")'));
                        else return "";
                    }
                } else {
                    if (($data->pasienpulang_id != 0) or ($data->carakeluar != "")) return "";
                    $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));
                    //if (empty($admisi)) return CHtml::link('<i class="icon-form-silang"></i>', "javascript:batalperiksa($data->pendaftaran_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan", 'data-placement'=>'left'));
                    if (empty($admisi)) return CHtml::link('<i class="icon-form-silang"></i>', "javascript:;", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan pemeriksaan", 'data-placement' => 'left', 'onclick' => 'dialogBatalPeriksaRd(' . $data->pendaftaran_id . ',"' . $data->statusperiksa . '","' . $data->nama_pasien . '")'));
                    else return "";
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); cekKonsulJawab();}',
));


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

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Riwayat Pemindahan Pasien',
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
        'width' => 1050,
        'height' => 650,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $('#daftarPasien-form').serialize()
        }); }",
    ),
));
?>
<iframe name='frameSuratPerintahRanap' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

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



<?php
//=============================== Dialog Riwayat Vaksinasi =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogRiwayatDPJP',
        'options' => array(
            'title' => 'Riwayat Disposisi',
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
echo '<iframe name="frameRiwayatDPJP" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php echo $this->renderPartial("_dialogPersetujuan", array(), true); ?>
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
<?php
//=============================== Tambah Triage Pasien =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'tambahTriagePasien',
        'options' => array(
            'title' => 'Pilih No Triage Pasien  - <span id="titleNamaPasienTraige"></span>',
            'autoOpen' => false,
            'zIndex' => 1002,
            'width' => 500,
            'height' => 350,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                data: $('#daftarPasien-grid').serialize()
            }); }",
        ),
    )
);
echo '<iframe name="frameTriagePasien" id="frameTriagePasien" style="width: 100%; height: 98%;"></iframe>';
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
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $('#daftarPasien-form').serialize()
        }); }",
    ),
));
?>
<iframe name='iframeDetailPPDS' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'editDokterPeriksa',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Riwayat DPJP</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 790,
        'height' => 570,
        'resizable' => true,
        'close' => "js:function(){ 
            $.fn.yiiGridView.update('daftarPasien-grid', {
                data: $('#daftarPasien-form').serialize()
            }); 
            cekPersetujualAlihLeader();
        }",
    ),
));
?>
<iframe name='iframeUbahDokter' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTolakAlihLeaderDanDispos',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Form Penolakan Disposisi / Alih Leader</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 350,
        'resizable' => true,
        'close' => "js:function(){ 
            $.fn.yiiGridView.update('daftarPasien-grid', {
                data: $('#daftarPasien-form').serialize()
            }); 
            cekPersetujualAlihLeader();
        }",
    ),
));
?>
<iframe name='iframeAlihLeaderDanDispos' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'editDPJP',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Ubah DPJP</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 650,
        'height' => 570,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $('#daftarPasien-form').serialize()
        }); }",
    ),
));
?>
<iframe name='iframeUbahDPJP' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

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
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $('#daftarPasien-form').serialize()
        }); }",
    ),
));
?>
<iframe name='iframeRincianTagihanSementara' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php echo $this->renderPartial('form/_dialogVerifikasiPJA', array(), true); ?>


    </script>
<script type="text/javascript">
    {
        function batalperiksa(pendaftaran_id) {
            myConfirm("Anda yakin akan membatalkan pemeriksaan rawat darurat pasien ini?", "Perhatian!", function(r) {
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
                                $.fn.yiiGridView.update('daftarPasien-grid', {
                                    data: $(this).serialize()
                                });
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
            myAlert("Pilih No Triage Pasien terlebih dahulu");
        }

        function cekTriage(pendaftaran_id, statusperiksa, namaPasien) {
            myConfirm("Nomor Triage sudah memiliki Nomor Pendaftaran, Apakah Anda yakin ingin mengubah?", 'Perhatian!',
            function(e) {
                if(e) {
                    dialogTambahTriagePasien(pendaftaran_id, statusperiksa, namaPasien);
                }else{
                 return false;
                    
                }
            }
            );
        }
    }
    /**
     * untuk ubah kasus penyakit
     * @param {type} obj
     * @param {type} pendaftaran_id
     * @param {type} jeniskasuspenyakit_id
     * @returns {Boolean} */
    function ubahKasusPenyakit(obj, pendaftaran_id, jeniskasuspenyakit_id) {
        var pendaftaran_id = pendaftaran_id;
        var jeniskasuspenyakit_id = jeniskasuspenyakit_id;
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetDropdownKasusPenyakit'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id,
                jeniskasuspenyakit_id: jeniskasuspenyakit_id
            },
            dataType: "json",
            success: function(data) {
                $(obj).parents('tr').find('.list_kasus_penyakit').append(data.kasusPenyakit);
                $(obj).parents('td').find('.kasus_penyakit').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        return false;
    }

    function saveKasusPenyakit(obj, pendaftaran_id) {
        var jeniskasuspenyakit_id = $(obj).val();
        var pendaftaran_id = pendaftaran_id;
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('saveKasusPenyakit'); ?>',
            data: {
                pendaftaran_id: pendaftaran_id,
                jeniskasuspenyakit_id: jeniskasuspenyakit_id
            },
            dataType: "json",
            success: function(data) {
                if (data.pesan == 'berhasil') {
                    myAlert('Data Kasus Penyakit berhasil di ubah');
                    $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $(this).serialize()
                    });
                } else {
                    myAlert('Data Kasus Penyakit gagal di ubah');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function verifikasiKirimanRM(id, kirimrm) {
        myConfirm('Yakin untuk Menerima Dokumen Rekam Medis Pasien? ', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('terimaDokumen'); ?>', {
                    pendaftaran_id: id,
                    pengirimanrm_id: kirimrm
                }, function(data) {
                    if (data.status == 'proses_form') {
                        //$('#dialogStatusDokumen div.divForForm').html(data.div);
                        $.fn.yiiGridView.update('daftarPasien-grid');
                        //setTimeout("$('#dialogStatusDokumen').dialog('close')",1000);
                    }
                }, 'json');
            } else {
                // preventDefault();
            }
        });
    }


    
  
    
    /**
     * 
     * @param {type} pendaftaran_id
     * @param {type} statusperiksa
     * @param {type} namaPasien
     * @returns {undefined}
     */
    function dialogBatalPeriksaRd(pendaftaran_id, statusperiksa, namaPasien) {
        $('#titleNamaPasienBatal_rd').html(namaPasien);
        $('#DialogBatalperiksa_rd #pendaftaran_id_rd').val(pendaftaran_id);
        $('#DialogBatalperiksa_rd #statusperiksa_rd').val(statusperiksa);
        $('#DialogBatalperiksa_rd').dialog('open');
    }

    function dialogTambahTriagePasien(pendaftaran_id, statusperiksa, namaPasien) {
        $('#titleNamaPasienTraige').html(namaPasien);
        $('#tambahTriagePasien').dialog('open');
    }

//     function ubahDokterPeriksa(pendaftaran_id)
// {
//     console.log("pendaftaran: " + pendaftaran_id);
//     $('#temp_idPendaftaranDP').val(pendaftaran_id);
//     jQuery.ajax({'url':'<?php echo $this->createUrl('ubahDokterPeriksa2')?>',
//         'data':{pendaftaran_id: pendaftaran_id},
//         'type':'post',
//         'dataType':'json',
//         'success':function(data){
//             if (data.status == 'create_form') {
//                 $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
//                 $('#editDokterPeriksa div.divForFormEditDokterPeriksa form').submit(ubahDokterPeriksa);
//             }else{
//                 $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
//                 $.fn.yiiGridView.update('daftarpasien-v-grid', {
//                         data: $('form').serialize()
//                 });
//                 setTimeout("$('#editDokterPeriksa').dialog('close') ",500);
//             }
//         },
//         'cache':false
//     });
//     return false; 
// }

    function ubahPeriksaKarenaBatal() {
        var pendaftaran_id = $('#DialogBatalperiksa_rd #pendaftaran_id_rd').val();
        var tglbatal = $('#DialogBatalperiksa_rd #tglbatal_rd').val();
        var keterangan_batal = $('#DialogBatalperiksa_rd #keterangan_batal_rd').val();
        $('#DialogBatalperiksa_rd #keterangan_batal_rd').attr('class', '');
        if (keterangan_batal == '') {
            myAlert("Alasan Pembatalan Pasien Ini, wajib diisi");
            $('#DialogBatalperiksa_rd #keterangan_batal_rd').attr('class', 'error');
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
                    $('#DialogBatalperiksa_rd').dialog('close');
                    $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $(this).serialize()
                    });
                } else if (data.pesan == 'exist') {
                    myAlert('Pasien telah melakukan pemeriksaan');
                    $('#DialogBatalperiksa_rd').dialog('close');
                } else {
                    myAlert(data.pesan);
                    $('#DialogBatalperiksa_rd').dialog('close');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

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

    $(function(){
        cekPersetujualAlihLeader();
    });

        
    function cekPersetujualAlihLeader() {
        var tgl_awal = $('.start').val();
        var tgl_akhir = $('.end').val();
        $.post('<?php echo $this->createUrl('cekPersetujualAlihLeader'); ?>',{
            tgl_awal:tgl_awal,
            tgl_akhir:tgl_akhir
        }, function(data) {
            if (data.total > 0) {
                alert(data.msg);
            }
        }, 'json');
    }

   
    function approve(ubahdokter_id, kelompokpegawai_id, pesan) { 
        if(kelompokpegawai_id == 1 || kelompokpegawai_id == 3) {
            myConfirm(pesan, 'Perhatian !', function(r) {
                if(r) {
                    $.post('<?php echo $this->createUrl('/rawatDarurat/daftarPasien/ApproveAlihLeader'); ?>',{ubahdokter_id:ubahdokter_id}, function(data) {
                        if (data.sukses == 1) {
                            myAlert(data.msg);
                            cekPersetujualAlihLeader();
                            $.fn.yiiGridView.update("daftarPasien-grid", {
                                data: $("#daftarPasien-form").serialize()
                            });
                        }
                    }, 'json');
                }    
            })
        } else {
            myAlert('Anda Tidak Dapat Menyetujui Disposisi/Alih Leader (Hak Akses)');
            return false;
        }
    }

    function cekAkses(kelompokpegawai_id, pegawai_id){
        loginpemakai_id = '<?= Yii::app()->user->getState('loginpemakai_id') ?>';
        console.log(loginpemakai_id, 'kelompokpegawai_id');

        if(kelompokpegawai_id == 1 || kelompokpegawai_id == 3){
            if(pegawai_id == <?= Yii::app()->user->getState('pegawai_id') ?> || loginpemakai_id == 1) {
                $("#editDokterPeriksa").dialog("open");
            } else {
                myAlert('Anda Tidak Dapat Mengubah Disposisi/Alih Leader (Hak Akses)');
                return false;    
            }
        } else {
            myAlert('Anda Tidak Dapat Mengubah Disposisi/Alih Leader (Hak Akses)');
            return false;
        }
    }

    function cekKonsulJawab() {
        $("#daftarPasien-grid tbody tr").each(function() {
            if ($(this).find(".ada_jawab").length != 0) {
                $(this).find(".ada_jawab").parents("button").addClass("jawab_konsul");
            }
        });

        var tgl_awal = $('.start').val();
        var tgl_akhir = $('.end').val();
        $.post('<?= $this->createUrl('cekJawabanKonsul') ?>', {
            tgl_awal:tgl_awal,
            tgl_akhir:tgl_akhir
        }, function(data){
            if(data.total > 0) {
                alert(data.msg);
            }
        }, 'json');
    }

    $(document).ready(function() {
        cekKonsulJawab();
    });

    function alertMessage(message, pendaftaran_id) {

        Notiflix.Report.Info(
            'Informasi!',
            message,
            'oke',
            () => {
                window.location.href = '<?php echo Yii::app()->controller->createUrl("/rawatDarurat/pemeriksaanPasienTRD") ?>' + '&pendaftaran_id=' + pendaftaran_id;
            },
        );
        
        
    }

    function cekNoTriage(pendaftaran_id) {
        $.get('<?= $this->createUrl('cekNoTriage') ?>', {
            pendaftaran_id:pendaftaran_id
        }, function(data){
            if(data.triage) {
                window.location.href = '<?= Yii::app()->createUrl('/rawatDarurat/pemindahanPasienRD/index') ?>' + '&pendaftaran_id=' + pendaftaran_id;
            } else {
                myAlert('Pilih No Triage Pasien terlebih dahulu');
            }
        }, 'json');
    }
</script>