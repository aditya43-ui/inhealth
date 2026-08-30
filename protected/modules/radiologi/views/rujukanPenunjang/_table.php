<?php 

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasienpenunjangrujukan-m-grid',
    'dataProvider' => $dataProvider,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Tgl. Rujukan',
            'value' => function($data) {
                echo $data->tgl_kirimpasien;
            }
        ),
        array(
            'header' => 'Tgl. Rencana Pemeriksaan',
            'value' => function ($data) {
                // echo MyFormatter::formatDateTimeForUser($data->tglrencanapemeriksaan);

                $dialog = '';

                if(empty($data->tglrencanapemeriksaan)) {
                $dialog = CHtml::Link("Pilih<br>Tgl. Pemeriksaan",Yii::app()->createUrl("radiologi/rujukanPenunjang/pilihTglPeriksa",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id, "pasien_id"=>$data->pasien_id, "frame"=>1,"popup"=>"true")),
                        array("class"=>"btn btn-info", 
                            "target"=>"framePilihTglPeriksa",
                            "onclick"=>"$(\"#dialogPilihTglPeriksa\").dialog(\"open\");",
                            "rel"=>"tooltip",
                            "title"=>"Klik untuk memilih tanggal pemeriksaan", 
                ));
            } else {

                $tgl1 = explode(" ", $data->tglrencanapemeriksaan);
                $tgl = MyFormatter::formatDateTimeForUser($tgl1[0]);
                $jam = $tgl1[1];
                $dialog = CHtml::Link("$tgl",Yii::app()->createUrl("radiologi/rujukanPenunjang/pilihTglPeriksa",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id, "pasien_id"=>$data->pasien_id, "frame"=>1,"popup"=>"true")),
                array("class"=>"btn btn-success", 
                    "target"=>"framePilihTglPeriksa",
                    "onclick"=>"$(\"#dialogPilihTglPeriksa\").dialog(\"open\");",
                    "rel"=>"tooltip",
                    "title"=>"Klik untuk memilih tanggal pemeriksaan", 
        ));
            }
                echo "<center>$dialog</center>";
            },
        ),
        array(
            'header' => 'Tgl. Pendaftaran/<br>No. Pendaftaran',
            'name' => 'tgl_pendaftaran',
            'type' => 'raw',
            'value' => function ($data) {

                echo $data->tgl_pendaftaran."/<br>".$data->no_pendaftaran . "<br>";
                $dialog = CHtml::Link("Pilih Pendaftaran",Yii::app()->createUrl("laboratorium/rujukanPenunjang/pilihPendaftaran",array("pasienkirimkeunitlain_id"=>$data->pasienkirimkeunitlain_id, "pasien_id"=>$data->pasien_id, "frame"=>1,"popup"=>"true")),
                        array("class"=>"btn btn-info", 
                            "target"=>"framePilihPendaftaran",
                            "onclick"=>"$(\"#dialogPilihPendaftaran\").dialog(\"open\");",
                            "rel"=>"tooltip",
                            "title"=>"Klik untuk memilih pendaftaran", 
            ));
                echo $data->pendaftaran_id == null ? $dialog : null;
            },
        ),
        array(
            'header' => ' Instalasi/<br>Ruangan',
            'value' => '$data->InstalasiNamaRuanganNama',
        ),
        array(
            'header' => 'Dokter Pengirim',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama'
        ),
        'no_rekam_medik',
        array(
            'header' => 'Nama Pasien',
            'value' => '$data->namadepan.$data->nama_pasien',
        ),
        array(
            'header' => 'Diagnosa Klinis',
            'value' => function ($data) {
                if(!empty($data->pendaftaran_id)) {
                    $morbid = PasienmorbiditasR::model()->findAll('pendaftaran_id = ' . $data->pendaftaran_id . " and is_verifikasidiagnosa = false");
                    $mb_arr = [];

                    if(!empty($morbid)) {

                        foreach($morbid as $mb) {
                            array_push($mb_arr, $mb->diagnosa->diagnosa_nama);
                        }

                        return implode(', ', $mb_arr);
                    } else {
                        return '';
                    }
                }
            },
        ),
        //'alamat_pasien',										
        //'jeniskasuspenyakit_nama',             
        array(
            'header' => 'Kasus Penyakit',
            'value' => '$data->jeniskasuspenyakit_nama'
        ),
        array(
            'header' => 'Jenis Penjamin / Penjamin',
            'value' => '$data->CaraBayarPenjaminNama',
        ),
        array(
            'header' => 'Status Periksa',
            'type' => 'raw',
            'value' => function ($data) {                                
                $cito = "";

                if (!empty($data->pasienkirimkeunitlain_id)) {

                    $modUnitLain = PasienkirimkeunitlainT::model()->findByPk($data->pasienkirimkeunitlain_id);

                    if ($modUnitLain->is_cito == true) {
                        $cito = "cito";
                    }
                }
                echo CHtml::hiddenField('warna', $cito, array('class' => 'ubah'));

                return Params::getWrStatusPeriksa($data->statusperiksa);
            }
        ),
        array(
            'header' => 'Periksa',
            'type' => 'raw',
            'value' => function ($data) {
            
                $url = Yii::app()->controller->createUrl("pendaftaranRadiologiRujukanRS/index", array("pasienkirimkeunitlain_id" => $data->pasienkirimkeunitlain_id));
                $opacity = '';
                if ($data->pendaftaran_id == null){
                    $url = 'javascript:;';
                    $opacity = 'disabled-icon';
                }
            
                if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                    return CHtml::Link(
                                    "<i class='icon-form-periksa '></i>",
                                    'javascript:;',
                                    array(
                                        "class" => "icon-form-periksa ".$opacity,
                                        "id" => "selectPasien",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk periksa pasien",
                                        'onclick' => 'myAlert("Anda tidak dapat menginput pemeriksan, karena status pasien ' . $data->statusperiksa . '","Perhatian !")'
                                    )
                    );
                } else if(empty($data->tglrencanapemeriksaan)) {
                    return CHtml::Link(
                        "<i class='icon-form-periksa '></i>",
                        'javascript:;',
                        array(
                            "class" => "icon-form-periksa ".$opacity,
                            "id" => "selectPasien",
                            "rel" => "tooltip",
                            "title" => "Klik untuk periksa pasien",
                            'onclick' => 'myAlert("Silahkan Isi Tgl Rencana Pemeriksan Terlebih Dahulu","Perhatian !")'
                            )
                        );
                } else {
                    return CHtml::Link(
                                    "<i class='icon-form-periksa'></i>",
                                    $url,
                                    array(
                                        "class" => "icon-form-periksa ".$opacity,
                                        "id" => "selectPasien",
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk periksa pasien",
                                    )
                    );
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Riwayat Pemeriksaan Pasien',
            'type' => 'raw',
            'value' => function ($data) {
            
                $url = Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/getRiwayatPasienLama", array("id" => $data->pasien_id));
                $opacity = '';
                if ($data->pendaftaran_id == null){
                    $url = 'javascript:;';
                    $opacity = 'disabled-icon';
                }
            

                 return '<center>'. CHtml::Link(
                                "<i class='icon-form-detail'></i>",
                                $url,
                                array(
                                    // "class" => "icon-form-periksa ".$opacity,
                                    "id" => "selectPasien",
                                    "rel" => "tooltip",
                                    "title" => "Klik untuk periksa pasien",
                                    "target"=>"frameRiwayatPemeriksaan",
                                    "onclick"=>"$(\"#dialogRiwayatPemeriksaan\").dialog(\"open\");",
                                )
                ) . '</center>';
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        // array(
        //     'name' => 'Inform Consent',
        //     'type' => 'raw',
        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        //     'value' => '(CHtml::link("<i class=\'icon-form-ubah\'></i><br>Tindakan", Yii::app()->controller->createUrl("PersetujuanTindakanUmumTRO/index",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk pembuatan surat persetujuan tindakan")))."<br>"'
        //         . '.(CHtml::link("<i class=\'icon-form-silang\'></i><br>Penolakan", Yii::app()->controller->createUrl("PersetujuanTindakanUmumTRO/penolakan",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk pembuatan surat penolakan tindakan")))."<br>"'
        //         . '.(CHtml::link("<i class=\'icon-form-detail\'></i><br>Asesmen Radiologi", Yii::app()->controller->createUrl("AsesmenRadiologi/index",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk melihat Asesmen Radiologi")))."<br>"',
        // ),
        // array(
        //     'header' => 'Detail Inform Consent',
        //     'type' => 'raw',
        //     'value' => function ($data) {
        //         $str = "";
        //         $umum = SuratpersetujuanumumT::model()->findByAttributes(array(
        //             'pendaftaran_id' => $data->pendaftaran_id,
        //         ));
        //         if (!empty($umum)) {
        //             $str .= CHtml::link("<icon class='icon-form-detail'></icon><br>General<br>Consent", Yii::app()->controller->createUrl('suratPersetujuanUmumTRO/view', array('pendaftaran_id' => $data->pendaftaran_id)), array("target" => "frameGeneralConsent", "rel" => "tooltip", "title" => "Klik untuk melihat General Consent", "onclick" => "$('#dialogGeneralConsent').dialog('open');"));
        //         }
        //         $str .= CHtml::link("<icon class='icon-form-detail'></icon><br>Detail<br>Persetujuan", Yii::app()->controller->createUrl('pencarianPasienTRO/detailInformConsent', array('id' => $data->pendaftaran_id)), array("target" => "frameInformConsent", "rel" => "tooltip", "title" => "Klik untuk melihat Inform Consent", "onclick" => "$('#dialogInformConsent').dialog('open');"));
        //         return $str;
        //     },
        //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        // ),
        array(
            'header' => 'Batal Periksa',
            'type' => 'raw',
            'value' => function ($data) {
                
                $url = "javascript:batalperiksa(" . $data->pendaftaran_id . "," . $data->pasienkirimkeunitlain_id . ")";
                $opacity = '';
                if ($data->pendaftaran_id == null){
                    $url = 'javascript:;';
                    $opacity = 'disabled-icon';
                }
                
                if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                    return CHtml::link("<i class='icon-form-silang'></i>", "javascript:;", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan rujukan", "data-placement" => "left", "onclick" => 'myAlert("Anda tidak dapat membatalkan rujukan, karena status pasien ' . $data->statusperiksa . '","Perhatian !")','class'=>$opacity));
                } else {
                    return CHtml::link("<i class='icon-form-silang'></i>", $url, array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan rujukan", "data-placement" => "left",'class'=>$opacity));
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
    ),
    
    'afterAjaxUpdate' => 'function(id, data){ubahWarna();jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));