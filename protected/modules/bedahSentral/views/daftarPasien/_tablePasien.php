<?php 
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarpasien-v-grid',
    'dataProvider' => $modPasienMasukPenunjang->searchBS(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'replaceUrl' => true,
    'columns' => array(
        //            array(
        //                    'name'=>'no_urutperiksa',
        //                    'type'=>'raw',
        //                    'header'=>'No. Antrian/<br>Panggil Antrian',
        //                    'value'=>'$data->ruangan_singkatan."-".$data->no_urutperiksa."<br>".(($data->panggilantrian == TRUE) ? "Sudah Dipanggil" : CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-volume-up icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(\"$data->pasienmasukpenunjang_id\"); setSuaraPanggilanSingle(\"$data->ruangan_singkatan\",\"$data->no_urutperiksa\",\"$data->ruangan_id\")","rel"=>"tooltip","title"=>"Klik untuk memanggil pasien ini")))'
        //                ),
        array(
            'header' => 'Tgl. Masuk Penunjang<br>No. Penunjang',
            'name' => 'no_masukpenunjang',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)."<br>".$data->no_masukpenunjang',
        ),
        array(
            'header' => 'Instalasi/<br>Ruangan Asal',
            'name' => 'ruanganasal_nama',
            'type' => 'raw',
            'value' => function ($data) {
                //$pegawai = PegawaiM::model()->findByAttributes(array(
                //    'nama_pegawai'=>$data->nama_dokterasal,
                //));
                return $data->instalasiasal_nama . "/<br>" . $data->ruanganasal_nama; //."/<br>".(empty($pegawai)?"-":$pegawai->namaLengkap);
            },
        ),
        array(
            'name' => 'tgl_pendaftaran',
            'header' => 'No. Pendaftaran / No. RM',
            'type' => 'raw',
            'value' => ' (!empty($data->no_pendaftaran)?$data->no_pendaftaran:"-")." / ".$data->no_rekam_medik',
            'htmlOptions' => array('width' => '100px'),
        ),
        // array(
        //     'header' => 'No. RM',
        //     'name' => 'no_rekam_medik',
        // ),
        array(
            'header' => 'Nama Pasien / Tanggal Lahir / Umur',
            'type' => 'raw',
            // 'value' => '$data->namadepan',
            'value' => function ($data) {
                return $data->namadepan . $data->nama_pasien . '<br>' . MyFormatter::formatDateTimeForUser($data->tanggal_lahir) . '<br>' . $data->umur;
            }
            //
            // 'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',

            // 'value' => '$data->nama_pasien'.'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)' .
            // '$data->umur'

        ),
        // array(
        //     'header' => 'Tanggal Lahir',
        //     'name' => 'tanggal_lahir',
        //     'type' => 'raw',
        //     'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
        // ),
        // array(
        //     'header' => 'Umur',
        //     'type' => 'raw',
        //     'value' => '$data->umur',
        // ),
        'alamat_pasien',
        array(
            'header' => 'Kasus Penyakit/<br>Kelas Pelayanan',
            'type' => 'raw',
            'value' => '"$data->jeniskasuspenyakit_nama"."<br>"."$data->kelaspelayanan_nama"',
        ),
        //            'jeniskasuspenyakit_nama',
        array(
            'header' => 'Jenis Penjamin / Penjamin',
            'value' => '$data->caraBayarPenjamin',
        ),
        array(
            'header' => 'Dokter Pemeriksa',
            'type' => 'raw',
            //                'value'=>'($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>". $data->getNamaLengkapDokter($data->pegawai_id),Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/ApprovePemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk menyetujui pemeriksaan", "onclick"=>"return confirm(\"Apakah Anda akan menyetujui pemeriksaan ini?\");")) : $data->getNamaLengkapDokter($data->pegawai_id)',
            'value' => function ($data) {
                $p = PegawaiM::model()->findByPk($data->pegawai_id);
                return $p ? $p->namaLengkap : '-';
            }, //'$data->pegawai_id',
        ),
        array(
            'header' => 'Dokter Operator',
            'type' => 'raw',
            //                'value'=>'($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>". $data->getNamaLengkapDokter($data->pegawai_id),Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/ApprovePemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk menyetujui pemeriksaan", "onclick"=>"return confirm(\"Apakah Anda akan menyetujui pemeriksaan ini?\");")) : $data->getNamaLengkapDokter($data->pegawai_id)',
            'value' => function ($data) {
                $op = RencanaoperasiT::model()->findByAttributes(array(
                    'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id
                ));

                if (empty($op)) {
                    return "-";
                }

                $peg = PegawaiM::model()->findByPk($op->dokterpelaksana1_id);
                return $peg->namaLengkap;
            }, //'$data->pegawai_id',
        ),
        array(
            'header' => 'Dokter Anestesi',
            'type' => 'raw',
            
            'value' => function ($data) {
                $op = RencanaoperasiT::model()->findByAttributes(array(
                    'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id
                ));

                if (empty($op)) {
                    return "-";
                }

                $peg = PegawaiM::model()->findByPk($op->dokteranastesi_id);
                if (empty($peg)) {
                    return "-";
                } else {
                    return $peg->namaLengkap;
                }
            }, //'$data->pegawai_id',
        ),
        array(
            'header' => 'Diagnosa',
            'type' => 'raw',
            'value' => function ($data) {
                $morbid = PasienmorbiditasT::model()->findByAttributes(array(
                    'pendaftaran_id' => $data->pendaftaran_id,
                    'kelompokdiagnosa_id' => 2,
                    'ruangan_id' => $data->ruanganasal_id
                ), array(
                    'order' => 'pasienmorbiditas_id desc',
                ));
                if (empty($morbid)) {
                    $morbid = PasienmorbiditasT::model()->findByAttributes(array(
                        'pendaftaran_id' => $data->pendaftaran_id,
                        'ruangan_id' => $data->ruanganasal_id
                    ), array(
                        'order' => 'pasienmorbiditas_id desc',
                    ));

                    if (empty($morbid)) {
                        return "-";
                    }
                }

                $diag = DiagnosaM::model()->findByPk($morbid->diagnosa_id);

                return $diag->diagnosa_kode . " - " . $diag->diagnosa_nama;
            }
        ),
        array(
            'header' => 'Tindakan Operasi',
            'type' => 'raw',
            'value' => function ($data) {
                $rencana = RencanaoperasiT::model()->findAllByAttributes(array(
                    'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id,
                ), array(
                    'join' => 'join operasi_m o on o.operasi_id = t.operasi_id',
                    'select' => 't.*, o.operasi_nama',
                ));

                if (count((array)$rencana) == 0) {
                    return "-";
                }

                $str = '<ul>';
                foreach ($rencana as $item) {
                    $str .= '<li>' . $item->operasi_nama . '</li>';
                }
                $str .= '</ul>';
                return $str;
            }
        ),
        array(
            'header' => 'Status Periksa<hr>Status Operasi',
            'type' => 'raw',
            'value' => function ($data) {
                $status = Params::getWrStatusPeriksa($data->statuspendaftaran);

                $criteria = new CDbCriteria;
                $criteria->addCondition('pasienmasukpenunjang_id = '.$data->pasienmasukpenunjang_id);
                $model = BSRencanaOperasiT::model()->find($criteria);
                $statusoperasi = empty($model->statusoperasi) ? null : $model->statusoperasi;

                $operasi = Params::getWrStatusOperasiBS($statusoperasi);
                return '<center>' . $status . '<hr>' . $operasi . '</center>';
            }
        ),
        array(
            'header' => 'Pemeriksaan Pasien',
            'type' => 'raw',
            'value' => function ($data) {
                echo $data->linkPeriksaPasien;
            },
            'htmlOptions' => array('style' => 'text-align: center;')
        ),
        array(
            'header' => 'Riwayat Pasien <hr /> Rekam Medis Elektronik',
            'type' => 'raw',
            'value' => function ($data) {

                $criteria = new CDbCriteria;
                $criteria->addCondition('pasienmasukpenunjang_id = '.$data->pasienmasukpenunjang_id);
                $model = BSRencanaOperasiT::model()->find($criteria);

                $disabled_r = false;

                if(!empty($model)) {
                   $disabled_r = false;
                
                    if(!empty($model)) {
                       $disabled_r = $model->statusoperasi == 'BATAL';
                    }
                }

                $fa_disabled = $disabled_r ? 'fa-disabled' : '';
            
                $urlRm = Yii::app()->controller->createUrl("RekamMedikElektronikPasienBS/index", array("pendaftaran_id" => $data->pendaftaran_id,'type'=>'Perawat'));
                $disabled = false;
                if (empty($data->pendaftaran_id) || $disabled_r){
                    $urlRm = 'javascript:;';
                    $disabled = true;
                }
            
                return CHtml::link('<i class="icon-form-detail ' . $fa_disabled . '"></i>', $this->createUrl("riwayatPasienBS/index", array(
                    'id' => $data->pasien_id,
                )),
                 array(                                    
                    'target' => 'frameRiwayat',
                    'onclick' => '$("#dialogRiwayat").dialog("open");'
                )).'<br><br><hr>'.CHtml::link('<img class="'.(($disabled)?'disabled-icon':'').'" src="'.Yii::app()->getBaseUrl('webroot').'/images/icon/doctor.png" style="width:30px;height:30px;"><br>Dokter ', Yii::app()->controller->createUrl("RekamMedikElektronikPasienBS/index", array("pendaftaran_id" => $data->pendaftaran_id, 'type' =>'Dokter')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan rekam medik elektronik oleh dokter")).'<br><br><hr>'.CHtml::link('<img class="'.(($disabled)?'disabled-icon':'').'"  src="'.Yii::app()->getBaseUrl('webroot').'/images/icon/nurse.png" style="width:30px;height:30px;">', Yii::app()->controller->createUrl("RekamMedikElektronikPasienBS/index", array("pendaftaran_id" => $data->pendaftaran_id,'type'=>'Perawat')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik Observasi Pasien"));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            )
        ),
        array(
            'header' => 'Verifikasi Rencana Operasi',
            'type' => 'raw',
            'value' => function ($data) {

                $criteria = new CDbCriteria;
                $criteria->addCondition('pasienmasukpenunjang_id = '.$data->pasienmasukpenunjang_id);
                $model = BSRencanaOperasiT::model()->find($criteria);

                $disabled = false;

                if(!empty($model)) {
                    $disabled = $model->statusoperasi == 'BATAL';
                }
                $fa_disabled = $disabled ? 'fa-disabled' : '';

                if ($data->statuspendaftaran == Params::STATUSPERIKSA_SUDAH_PULANG) {
                    return CHtml::link("<i class='icon-form-roperasi $fa_disabled'>", 'javascript:;', array(
                        "onclick" => 'myAlert("Anda tidak dapat melanjutkan ke transaksi rencana operasi, karena status pasien ' . $data->statuspendaftaran . ' ","Perhatian !")',
                        "rel" => "tooltip",
                        "title" => "Klik untuk mengisi mengubah rencana operasi", 'data-placement' => 'left'
                    ));
                } else {
                    return (($data->getPegawaiMengetahuiOperasi($data->pasienmasukpenunjang_id) == null) ? "" : "Sudah diverifikasi") . (($data->getStatusOperasi($data->pasienmasukpenunjang_id) != "RENCANA") ?
                        " - " : CHtml::Link("<i class='icon-form-roperasi $fa_disabled'></i>", Yii::app()->controller->createUrl("PendaftaranBedahSentralRujukanRS/index/", array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)), array(
                            "class" => "icon-form-roperasi",
                            "id" => "selectPasien",
                            "rel" => "tooltip",
                            "title" => "Klik untuk ubah rencana operasi pasien"
                        )));
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Approve',
            'type' => 'raw',
            'value' => function ($data) use ($module, $controller) {

                $modRencanaOpterasiT = BSRencanaOperasiT::model()->findByAttributes(array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id));
                
                $disabled = false;

                if(!empty($model)) {
                   $disabled = $modRencanaOpterasiT->statusoperasi == 'BATAL';
                }

                $fa_disabled = $disabled ? 'fa-disabled' : '';

                if (empty($data->pendaftaran_id)){
                    return '';
                }
                
                if ($data->getPegawaiMengetahuiOperasi($data->pasienmasukpenunjang_id) == null) {
                    return "BELUM DI APPROVE";
                }


                if (isset($modRencanaOpterasiT)) {
                    if (!empty($modRencanaOpterasiT->tgl_mengetahui)) {
                        
                            // $dataDialog = 'myAlert("Hanya ' . (isset($modRencanaOpterasiT->pegmengetahui_id) ? $modRencanaOpterasiT->pegmengetahuis->namaLengkap : "-") . ' yang bisa mengakses");';
                            //if ($modRencanaOpterasiT->pegmengetahui_id == Yii::app()->user->getState('pegawai_id')) {
                            $dataDialog = "";
                            //}
                            $fa_disabled = 'fa-disabled';
                    } else {
                        $dataDialog = "$('#dialogApproveMengetahui').dialog('open');";
                    }
                } else {
                    $dataDialog = "";
                    $fa_disabled = 'fa-disabled';

                }
                return CHtml::link("<icon class='icon-form-check $fa_disabled'></icon> ", Yii::app()->controller->createUrl("/" . $module . '/' . $controller . '/ApproveMengetahui', array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id, "frame" => true)), array("target" => "frameApproveMengetahui", "rel" => "tooltip", "title" => "Klik untuk Approve Menyetujui", "onclick" => $dataDialog));

            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Sign In',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            'value' => function ($data) use (&$is_signin) {

                $criteria = new CDbCriteria;
                $criteria->addCondition('pasienmasukpenunjang_id = '.$data->pasienmasukpenunjang_id);
                $model = BSRencanaOperasiT::model()->find($criteria);

                $disabled = false;

                if(!empty($model)) {
                    $disabled = $model->statusoperasi == 'BATAL';
                }
                $fa_disabled = $disabled ? 'fa-disabled' : '';

                if (empty($data->pendaftaran_id)){
                    return '';
                }
                $is_signin = true;
                $modRencanaOpterasiT = BSRencanaOperasiT::model()->findByAttributes(array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id));

                if (empty($modRencanaOpterasiT->tgl_mengetahui)) {
                    $is_signin = false;
                    return "";
                }

                if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                    return CHtml::link("<i class='" . MyIcon::getIcons('signin') . " $fa_disabled'>", 'javascript:;', array(
                        "onclick" => 'myAlert("Anda tidak dapat menginput sign in, karena status pasien ' . $data->statusperiksa . '","Perhatian !")',
                        "rel" => "tooltip",
                        "title" => "Klik untuk mengisi form sign in", 'data-placement' => 'left'
                    ));
                } else {
                    return CHtml::link("<i class='" . MyIcon::getIcons('signin') . " $fa_disabled'>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/rujukanPenunjang/signIn', array("pasienkirimkeunitlain_id" => $data->pasienkirimkeunitlain_id, "pendaftaran_id" => $data->pendaftaran_id)), array(
                        "target" => "frameSignIn",
                        "onclick" => $disabled ? '' : '$("#dialogSignIn").dialog("open");',
                        "rel" => "tooltip",
                        "title" => "Klik untuk mengisi form sign in", 'data-placement' => 'left'
                    ));
                }
            }
        ),
        array(
            'header' => 'Time Out',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            'value' => function ($data) {

                $criteria = new CDbCriteria;
                $criteria->addCondition('pasienmasukpenunjang_id = '.$data->pasienmasukpenunjang_id);
                $model = BSRencanaOperasiT::model()->find($criteria);

                $disabled = false;

                if(!empty($model)) {
                    $disabled = $model->statusoperasi == 'BATAL';
                }
                $fa_disabled = $disabled ? 'fa-disabled' : '';
                
                if (empty($data->pendaftaran_id)){
                    return '';
                }
                $dataSignIn = BSOperasisigninT::model()->findByAttributes(array(
                    'pasienkirimkeunitlain_id' => $data->pasienkirimkeunitlain_id,
                ));

                if (empty($dataSignIn)) {
                    return "-";
                }

                $penunjang = PasienmasukpenunjangT::model()->findByPk($data->pasienmasukpenunjang_id);



                if ($data->statuspendaftaran == Params::STATUSPERIKSA_SUDAH_PULANG) {
                    return CHtml::link("<i class='" . MyIcon::getIcons('timeout') . " $fa_disabled'>", 'javascript:;', array(
                        "onclick" => 'myAlert("Anda tidak dapat melanjutkan ke transaksi time out, karena status pasien ' . $data->statuspendaftaran . ' ","Perhatian !")',
                        "rel" => "tooltip",
                        "title" => "Klik untuk mengisi form time out", 'data-placement' => 'left'
                    ));
                } else {
                    if (!empty($penunjang->pasienkirimkeunitlain_id)) {
                        //var_dump($penunjang->pasienkirimkeunitlain_id);
                        $signin = BSOperasisigninT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $penunjang->pasienkirimkeunitlain_id));
                        //
                        if (!empty($signin)) {
                            return CHtml::link("<i class='" . MyIcon::getIcons('timeout') . " $fa_disabled'>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/timeOut', array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id, "pendaftaran_id" => $data->pendaftaran_id)), array(
                                "target" => "frameTimeOut",
                                "onclick" => '$("#dialogTimeOut").dialog("open");',
                                "rel" => "tooltip",
                                "title" => "Klik untuk mengisi form time out", 'data-placement' => 'left'
                            ));
                        } else {
                            return CHtml::link("<i class='" . MyIcon::getIcons('timeout') . " $fa_disabled'>", 'javascript:;', array(
                                "onclick" => 'myAlert("Anda tidak dapat melanjutkan ke transaksi time out, karena transaksi sign in belum diinput","Perhatian !")',
                                "rel" => "tooltip",
                                "title" => "Klik untuk mengisi form time out", 'data-placement' => 'left'
                            ));
                        }
                    } else {
                        return CHtml::link("<i class='" . MyIcon::getIcons('timeout') . " $fa_disabled'>", 'javascript:;', array(
                            "onclick" => 'myAlert("Anda tidak dapat melanjutkan ke transaksi time out, karena transaksi sign in belum diinput","Perhatian !")',
                            "rel" => "tooltip",
                            "title" => "Klik untuk mengisi form time out", 'data-placement' => 'left'
                        ));
                        //	return CHtml::link("<i class='".MyIcon::getIcons('timeout')."'>",'javascript',array(
                        //						"onclick"=>'myAlert("Anda tidak dapat melanjutkan ke transaksi time out, karena transaksi sign in belum diinput","Perhatian !")',
                        //						"rel"=>"tooltip",
                        //						  "title"=>"Klik untuk mengisi form time out", 'data-placement'=>'left'));
                    }
                }
            }
        ),
        array(
            'header' => 'Operasi',
            'type' => 'raw',
            'value' => function ($data) use ($module, $controller) {
                
               

                if (empty($data->pendaftaran_id)){
                    return '';
                }
                
                if ($data->getPegawaiMengetahuiOperasi($data->pasienmasukpenunjang_id) == null) {
                    return "BELUM DI APPROVE";
                }


                $modRencanaOpterasiT = BSRencanaOperasiT::model()->findByAttributes(array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id));

                if (isset($modRencanaOpterasiT)) {

                    $disabled = $modRencanaOpterasiT->tindakanpelayanan_id != null;
                    $fa_disabled = $disabled ? 'fa-disabled' : '';
                    $link = $disabled ? 'javascript:void(0)' : Yii::app()->controller->createUrl("/" . $module . '/' . $controller . '/updateRencana', array("id" => $data->pasienmasukpenunjang_id));
                    $link_sedang = $disabled ? 'javascript:void(0)' : Yii::app()->controller->createUrl("/bedahSentral/daftarPasien/selesaiOperasi", array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id));

                    $tooltip_sedang = $disabled ? '' : 'Klik untuk Melakukan Operasi';
                    $tooltip = $disabled ? '' : 'Klik untuk Melakukan Operasi';

                    if (isset($modRencanaOpterasiT->pegmengetahui_id)) {
                            if ($data->statuspendaftaran == Params::STATUSPERIKSA_SUDAH_PULANG) {
                                if ($data->getStatusOperasi($data->pasienmasukpenunjang_id) != '') {
                                    if ($data->getStatusOperasi($data->pasienmasukpenunjang_id) == "MULAI") {
                                        return "<div class='inap' style='background-color:#FFFF00; text-align: center;'>SEDANG OPERASI</div>";
                                    } elseif ($data->getStatusOperasi($data->pasienmasukpenunjang_id) == "SELESAI") {
                                        return "<div class='inap' style='background-color:#33FF00; text-align: center'>SELESAI OPERASI</div>";
                                    } else {
                                        return CHtml::link("<i class='icon-form-operasi $fa_disabled'>", 'javascript:;', array(
                                            "onclick" => 'myAlert("Anda tidak dapat melanjutkan ke transaksi operasi, karena status pasien ' . $data->statuspendaftaran . ' ","Perhatian !")',
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk mengisi operasi", 'data-placement' => 'left'
                                        ));
                                    }
                                } else {
                                    return CHtml::link("<i class='icon-form-operasi $fa_disabled'>", 'javascript:;', array(
                                        "onclick" => 'myAlert("Anda tidak dapat melanjutkan ke transaksi operasi, karena status pasien ' . $data->statuspendaftaran . ' ","Perhatian !")',
                                        "rel" => "tooltip",
                                        "title" => "Klik untuk mengisi operasi", 'data-placement' => 'left'
                                    ));
                                }
                            } else {

                                $dataTimeOut = BSOperasitimeoutT::model()->findByAttributes(array(
                                    'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id,
                                ));

                                if (empty($dataTimeOut)) {
                                    return "-";
                                }

                                return ($data->getStatusOperasi($data->pasienmasukpenunjang_id) == "MULAI") ? "<div class='inap' style='background-color:#FFFF00; text-align: center;'>" .
                                    CHtml::link("SEDANG OPERASI", $link_sedang, array("rel" => "tooltip", "title" => "$tooltip_sedang", "target" => "frameSelesaiOperasi", "onclick" => "$('#selesaiOperasi').dialog('open');return true;")) : (($data->getStatusOperasi($data->pasienmasukpenunjang_id) == "SELESAI") ? "<div class='inap' style='background-color:#33FF00; text-align: center'>SELESAI OPERASI" :
                                        CHtml::link("<i class='icon-form-operasi $fa_disabled'></i>", $link, array("rel" => "tooltip", "title" => $tooltip)));
                            }
                        
                    } else {
                        return "";
                    }
                } else {
                    return "";
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Sign Out',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
            'value' => function ($data) {

                $signin = BSOperasitimeoutT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id));

                $modRencanaOpterasiT = BSRencanaOperasiT::model()->findByAttributes(array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id));

                $disabled = false;
                if(empty($modRencanaOpterasiT)) {
                    $disabled = true;
                } else {
                    $disabled = $modRencanaOpterasiT->tindakanpelayanan_id == null;
                }
                $fa_disabled = $disabled ? 'fa-disabled' : '';

                $dialog = $disabled ? '' : '$("#dialogSignOut").dialog("open");';

                $link = $disabled ? 'javascript::void(0)' : Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/signOut', array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id, "pendaftaran_id" => $data->pendaftaran_id, 'timeout_id' => $signin->operasitimeout_id));

                if (empty($data->pendaftaran_id)){
                    return '';
                }
                $modRencanaOpterasiT2 = RencanaoperasiT::model()->findByAttributes(array(
                    'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id,
                ));

                if (empty($modRencanaOpterasiT2)) {
                    return "-";
                }

                $dataTimeOut = BSOperasitimeoutT::model()->findByAttributes(array(
                    'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id,
                ));

                if (empty($dataTimeOut)) {
                    return "";
                }

                //$penunjang = PasienmasukpenunjangT::model()->findByPk($data->pasienmasukpenunjang_id);



                if ($data->statuspendaftaran == Params::STATUSPERIKSA_SUDAH_PULANG) {
                    return CHtml::link("<i class='" . MyIcon::getIcons('signout') . " $fa_disabled'>", 'javascript:;', array(
                        "onclick" => 'myAlert("Anda tidak dapat melanjutkan ke transaksi sign out, karena status pasien ' . $data->statuspendaftaran . ' ","Perhatian !")',
                        "rel" => "tooltip",
                        "title" => "Klik untuk mengisi form sign out", 'data-placement' => 'left'
                    ));
                } else {
                    if (!empty($data->pasienmasukpenunjang_id)) {
                        //var_dump($penunjang->pasienkirimkeunitlain_id);
                        $signin = BSOperasitimeoutT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id));
                        //
                        if (!empty($signin)) {
                            return CHtml::link("<i class='" . MyIcon::getIcons('signout') . " $fa_disabled'>", $link, array(
                                "target" => "frameSignOut",
                                "onclick" => $dialog,
                                "rel" => "tooltip",
                                "title" => "Klik untuk mengisi form sign out", 'data-placement' => 'left'
                            ));
                        } else {
                            return CHtml::link("<i class='" . MyIcon::getIcons('signout') . " $fa_disabled'>", 'javascript:;', array(
                                "onclick" => 'myAlert("Anda tidak dapat melanjutkan ke transaksi time out, karena transaksi sign out belum diinput","Perhatian !")',
                                "rel" => "tooltip",
                                "title" => "Klik untuk mengisi form sign out", 'data-placement' => 'left'
                            ));
                        }
                    } else {
                        return CHtml::link("<i class='" . MyIcon::getIcons('signout') . " $fa_disabled'>", 'javascript:;', array(
                            "onclick" => 'myAlert("Anda tidak dapat melanjutkan ke transaksi time out, karena transaksi sign out belum diinput","Perhatian !")',
                            "rel" => "tooltip",
                            "title" => "Klik untuk mengisi form sign out", 'data-placement' => 'left'
                        ));
                        //	return CHtml::link("<i class='".MyIcon::getIcons('timeout')."'>",'javascript',array(
                        //						"onclick"=>'myAlert("Anda tidak dapat melanjutkan ke transaksi time out, karena transaksi sign in belum diinput","Perhatian !")',
                        //						"rel"=>"tooltip",
                        //						  "title"=>"Klik untuk mengisi form time out", 'data-placement'=>'left'));
                    }
                }
            }
        ),

        array(
            'name' => 'Riwayat Vaksinasi/Imunisasi',
            'type' => 'raw',
            // 'value' => '',
            'value' => function ($data) {

                $criteria = new CDbCriteria;
                $criteria->addCondition('pasienmasukpenunjang_id = '.$data->pasienmasukpenunjang_id);
                $model = BSRencanaOperasiT::model()->find($criteria);

                $disabled = false;

                if(!empty($model)) {
                    $disabled = $model->statusoperasi == 'BATAL';
                }
                $fa_disabled = $disabled ? 'fa-disabled' : '';

                if (empty($data->pendaftaran_id)){
                    return '';
                }
                
                return CHtml::link('<i class="icon-form-detail ' . $fa_disabled . '"></i>', Yii::app()->controller->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/updateRiwayatVaksinasi', array(
                    'pendaftaran_id'=>$data->pendaftaran_id,
                )), array(
                    'target'=>'frameRiwayatVaksinasi',
                    'onclick'=>"$('#dialogRiwayatVaksinasi').dialog('open');",
                ));
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Persetujuan',
            'type' => 'raw',
            'value' => function ($data) use ($module, $controller) {

                $criteria = new CDbCriteria;
                $criteria->addCondition('pasienmasukpenunjang_id = '.$data->pasienmasukpenunjang_id);
                $model = BSRencanaOperasiT::model()->find($criteria);

                $disabled = false;

if(!empty($model)) {
$disabled = $model->statusoperasi == 'BATAL';
}
                $fa_disabled = $disabled ? 'fa-disabled' : '';

                if (empty($data->pendaftaran_id)){
                    return '';
                }
                
                if (!empty($data->pasienkirimkeunitlain_id)) {
                    $kirim = PersetujuananestesiT::model()->findByAttributes(array(
                        'pasienkirimkeunitlain_id' => $data->pasienkirimkeunitlain_id
                    ));
                    if (!empty($kirim)) {
                        $url = Yii::app()->controller->createUrl("/" . $module . '/persetujuanTindakanAnastesi/Index', array("pasienkirimkeunitlain_id" => $data->pasienkirimkeunitlain_id));
                    }
                }

                if (empty($url)) {
                    $url = Yii::app()->controller->createUrl("/" . $module . '/persetujuanTindakanAnastesi/Index', array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id));
                }

                $link = (CHtml::link("<i class='icon-form-ubah $fa_disabled'></i><br/>Tindakan", Yii::app()->controller->createUrl("PersetujuanTindakanTBS/index", array("pendaftaran_id" => $data->pendaftaran_id, "frame" => 1)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat persetujuan tindakan", "target" => "framePersetujuan", "onclick" => "$('#dialogPersetujuan').dialog('open');"))) . "<br/>";
                $link .= CHtml::link("<icon class='icon-form-ubah $fa_disabled'></icon><br/>Inform Consent", Yii::app()->controller->createUrl("/" . $module . '/PersetujuanTindakanUmumBS/Index', array("pendaftaran_id" => $data->pendaftaran_id, 'frame'=>1)), array("target" => "framePersetujuan", "rel" => "tooltip", "title" => "Klik untuk pembuatan Inform Consent (Persetujuan)", "onclick" => "$('#dialogPersetujuan').dialog('open');")). "<br/>";
                $link .= CHtml::link("<icon class='icon-form-ubah $fa_disabled'></icon><br/>Anastesi", $url, array("target" => "framePersetujuan", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat persetujuan tindakan anastesi", "onclick" => "$('#dialogPersetujuan').dialog('open');"));
            
                return $link;
             },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Penolakan',
            'type' => 'raw',
            'value' => function ($data) use ($module, $controller) {

                $criteria = new CDbCriteria;
                $criteria->addCondition('pasienmasukpenunjang_id = '.$data->pasienmasukpenunjang_id);
                $model = BSRencanaOperasiT::model()->find($criteria);

                $disabled = false;

if(!empty($model)) {
$disabled = $model->statusoperasi == 'BATAL';
}
                $fa_disabled = $disabled ? 'fa-disabled' : '';

                if (empty($data->pendaftaran_id)){
                    return '';
                }
                 
                if (!empty($data->pasienkirimkeunitlain_id)) {
                    $kirim = PersetujuananestesiT::model()->findByAttributes(array(
                        'pasienkirimkeunitlain_id' => $data->pasienkirimkeunitlain_id
                    ));
                    if (!empty($kirim)) {
                        $url = Yii::app()->controller->createUrl("/" . $module . '/persetujuanTindakanAnastesi/penolakan', array("pasienkirimkeunitlain_id" => $data->pasienkirimkeunitlain_id));
                    }
                }

                if (empty($url)) {
                    $url = Yii::app()->controller->createUrl("/" . $module . '/persetujuanTindakanAnastesi/penolakan', array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id));
                }
                
                $link = (CHtml::link("<i class='icon-form-silang $fa_disabled'></i><br/>Tindakan", Yii::app()->controller->createUrl("PersetujuanTindakanTBS/penolakan", array("pendaftaran_id" => $data->pendaftaran_id, "frame" => 1)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat penolakan tindakan", "target" => "framePersetujuan", "onclick" => "$('#dialogPersetujuan').dialog('open');"))) . "<br/>";
                $link .= CHtml::link("<icon class='icon-form-silang $fa_disabled'></icon><br/>Inform Refusal", Yii::app()->controller->createUrl("/" . $module . '/PersetujuanTindakanUmumBS/penolakan', array("pendaftaran_id" => $data->pendaftaran_id, 'frame'=>1)), array("target" => "framePersetujuan", "rel" => "tooltip", "title" => "Klik untuk pembuatan Inform Consent (Penolakan)", "onclick" => "$('#dialogPersetujuan').dialog('open');")). "<br/>";
                $link .= CHtml::link("<icon class='icon-form-silang $fa_disabled'></icon><br/>Anastesi", $url, array("target" => "framePersetujuan", "rel" => "tooltip", "title" => "Klik untuk pembuatan surat penolakan tindakan anastesi", "onclick" => "$('#dialogPersetujuan').dialog('open');"));
            
                return $link;
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Detail Persetujuan & Penolakan',
            'type' => 'raw',
            'value' => function ($data) use ($module, $controller) {

                $criteria = new CDbCriteria;
                $criteria->addCondition('pasienmasukpenunjang_id = '.$data->pasienmasukpenunjang_id);
                $model = BSRencanaOperasiT::model()->find($criteria);

                $disabled = false;

                if(!empty($model)) {
                    $disabled = $model->statusoperasi == 'BATAL';
                }
                $fa_disabled = $disabled ? 'fa-disabled' : '';

                if (empty($data->pendaftaran_id)){
                    return '';
                }
                
                $str = "";

                $anastesi = PersetujuananestesiT::model()->findByAttributes(array(
                    'pendaftaran_id' => $data->pendaftaran_id,
                ), array(
                    'condition' => "create_ruangan <> " . Yii::app()->user->getState('ruangan_id'),
                    'order' => 'create_time desc',
                ));
                $tindakan = SuratpersetujuantmT::model()->findByAttributes(array(
                    'pendaftaran_id' => $data->pendaftaran_id,
                ), array(
                    'condition' => "ruangan_id <> " . Yii::app()->user->getState('ruangan_id'),
                    'order' => 'tglpersetujuan desc',
                ));

                if (!empty($tindakan)) {
                    if ($tindakan->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) {
                        $url = Yii::app()->controller->createUrl("/" . $module . '/persetujuanTindakanTBS/index', array("pendaftaran_id" => $data->pendaftaran_id, 'suratpersetujuantm_id' => $tindakan->suratpersetujuantm_id, "frame" => 1));
                    } else {
                        $url = Yii::app()->controller->createUrl("/" . $module . '/persetujuanTindakanTBS/penolakan', array("pendaftaran_id" => $data->pendaftaran_id, 'suratpersetujuantm_id' => $tindakan->suratpersetujuantm_id, "frame" => 1));
                    }
                    $str .= CHtml::link("<icon class='icon-form-detail'></icon>Detail Persetujuan & Penolakan", $url, array("target" => "framePersetujuan", "rel" => "tooltip", "title" => "Klik untuk melihat Detail Persetujuan & Penolakan", "onclick" => "$('#dialogPersetujuan').dialog('open');"));
                }
                if (!empty($anastesi)) {
                    if ($anastesi->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) {
                        $url = Yii::app()->controller->createUrl("/" . $module . '/persetujuanTindakanAnastesi/index', array("pendaftaran_id" => $data->pendaftaran_id, 'persetujuananestesi_id' => $anastesi->persetujuananestesi_id));
                    } else {
                        $url = Yii::app()->controller->createUrl("/" . $module . '/persetujuanTindakanAnastesi/penolakan', array("pendaftaran_id" => $data->pendaftaran_id, 'persetujuananestesi_id' => $anastesi->persetujuananestesi_id));
                    }
                    $str .= CHtml::link("<icon class='icon-form-detail $fa_disabled'></icon>Anastesi", $url, array("target" => "framePersetujuan", "rel" => "tooltip", "title" => "Klik untuk melihat surat persetujuan", "onclick" => "$('#dialogPersetujuan').dialog('open');"));
                }

                return $str;
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
       
        array(
            'header' => 'Status Dokumen / Rincian Tagihan',
            'type' => 'raw',
            'value' => function ($data) {

                $criteria = new CDbCriteria;
                $criteria->addCondition('pasienmasukpenunjang_id = '.$data->pasienmasukpenunjang_id);
                $model = BSRencanaOperasiT::model()->find($criteria);

                $disabled = false;

                if(!empty($model)) {
                    $disabled = $model->statusoperasi == 'BATAL';
                }
                $fa_disabled = $disabled ? 'fa-disabled' : '';

                if (empty($data->pendaftaran_id)){
                    return '';
                }
                
                $status_dokumen = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                $dok =   CHtml::link("<icon class='icon-file $fa_disabled' style='font-size:48px;'></icon><br>File Rekam Medik<br>", Yii::app()->controller->createUrl('DaftarPasien/riwayatDokfilerm', array('pendaftaran_id' => $data->pendaftaran_id)), array("target" => "frameRiwayatDokfilerm", "rel" => "tooltip", "title" => "Klik untuk melihat File Rekam Medik", "onclick" => "$('#dialogDokFilerm').dialog('open');"));

                $rincian =  CHtml::Link("<i class='icon-form-detailtagihan'></i><br />Rincian Tagihan", Yii::app()->createUrl("rawatInap/pasienRawatInap/printRincianBelumBayar",array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id,"frame"=>true)),
                            array("class"=>"", 
                            "target"=>"iframeRincianTagihan",
                            "onclick"=>"$('#dialogRincianTagihan').dialog('open');",
                            "rel"=>"tooltip",
                            "title"=>"Klik untuk melihat Rincian Tagihan",));

                if ($status_dokumen->statusdokrm == "SUDAH DITERIMA") {
                    if (Yii::app()->user->getState('ruangan_id') == $status_dokumen->pengirimanrm->ruanganpenerima_id) {
                        //var_dump($data->statusperiksa);
                        if ($data->statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) {
                            return CHtml::link(
                                "<i class='$fa_disabled'></i> $status_dokumen->statusdokrm",
                                Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/statusDokumenKirim', array("pengirimanrm_id" => $status_dokumen->pengirimanrm_id, "pendaftaran_id" => $data->pendaftaran_id)),
                                array(
                                    "class" => "btn btn-primary $fa_disabled",
                                    "target" => "frameStatusDokumen",
                                    "rel" => "tooltip",
                                    "title" => "Klik untuk mengirim dokumen ke ruangan lain",
                                    "onclick" => 'myConfirm("Pasien Masih Dalam Status Menunggu Admisi. Apakah Anda akan melanjutkan transaksi?","Perhatian",function(r){if(r){$("#dialogStatusDokumen").dialog("open")}});'
                                )
                            ).'<br><br>'.$dok.'<br>'.$rincian;
                        } else {
                            return CHtml::link(
                                "<i class='$fa_disabled'></i> $status_dokumen->statusdokrm",
                                Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/statusDokumenKirim', array("pengirimanrm_id" => $status_dokumen->pengirimanrm_id, "pendaftaran_id" => $data->pendaftaran_id)),
                                array(
                                    "class" => "btn btn-primary $fa_disabled",
                                    "target" => "frameStatusDokumen",
                                    "rel" => "tooltip",
                                    "title" => "Klik untuk mengirim dokumen ke ruangan lain",
                                    "onclick" => '$("#dialogStatusDokumen").dialog("open");'
                                )
                            ).'<br><br>'.$dok.'<br>'.$rincian;
                        }
                    } else {
                        return $data->getStatusDokumen($status_dokumen->pengirimanrm_id, $status_dokumen->statusdokrm, $data->pendaftaran_id).'<br><br>'.$dok.'<br>'.$rincian;
                    }
                } else {
                    return $data->getStatusDokumen($status_dokumen->pengirimanrm_id, $status_dokumen->statusdokrm, $data->pendaftaran_id).'<br><br>'.$dok.'<br>'.$rincian;
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
        array(
            'header' => 'Batal Periksa',
            'type' => 'raw',
            'value' => function ($data) {

                $criteria = new CDbCriteria;
                $criteria->addCondition('pasienmasukpenunjang_id = '.$data->pasienmasukpenunjang_id);
                $model = BSRencanaOperasiT::model()->find($criteria);

                $disabled = false;

                if(!empty($model)) {
                $disabled = $model->statusoperasi == 'BATAL';
                }
                $fa_disabled = $disabled ? 'fa-disabled' : '';
                
                if (empty($data->pendaftaran_id || $disabled)){
                    return '';
                }
                
                if ($data->statuspendaftaran == Params::STATUSPERIKSA_SUDAH_PULANG) {
                    return CHtml::link("<i class='icon-form-silang'></i>", "javascript:;", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan Pemeriksaan", 'data-placement' => 'left', 'onclick' => 'myAlert("Anda tidak dapat mebatalkan pasien, karena status pasien ' . $data->statuspendaftaran . ' ","Perhatian !")'));
                } else {
                    if (in_array($data->getStatusOperasi($data->pasienmasukpenunjang_id), array("MULAI", "SELESAI")) || $disabled)
                        return "-";
                    //								return CHtml::link("<i class='icon-form-silang'></i>", "javascript:batalPeriksa(".$data->pasienmasukpenunjang_id.")",array("id"=>$data->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk membatalkan Pemeriksaan", 'data-placement'=>'left'));
                    //return CHtml::link("<i class='icon-form-silang'></i>", 'javascript:ubahPeriksaKarenaBatal('.$data->pendaftaran_id.','.$data->pasienmasukpenunjang_id.',"'.$data->nama_pasien.'")',array("id"=>$data->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk membatalkan Pemeriksaan", 'data-placement'=>'left'));
                    return CHtml::link("<i class='icon-form-silang $fa_disabled'></i>", 'javascript:dialogBatalPeriksa(' . $data->pendaftaran_id . ',' . $data->pasienmasukpenunjang_id . ',"' . $data->nama_pasien . '")', array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan Pemeriksaan", "data-placement" => "left"));
                }
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
    ),
   
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>