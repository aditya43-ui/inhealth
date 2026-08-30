<?php

//Yii::import('sistemAdministrator.controllers.NotifikasiRController'); RND-6398
class RadiologiNewController extends MyAuthController {

    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    protected $statusSaveKirimkeUnitLain = false;
    protected $statusSavePermintaanPenunjang = false;
    protected $tindakanpelayanantersimpan = true;
    protected $komponentindakantersimpan = true;
    protected $path_view = 'rawatJalan.views.radiologiNew.';

    public function actionIndex($pendaftaran_id, $idPasienKirimKeUnitLain = null) {
        $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
        $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
        // $modKirimKeUnitLain->tglrencanapemeriksaan = $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
        if(Yii::app()->user->getState('kelompokpegawai_id') === Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP) {
            $modKirimKeUnitLain->pegawai_id = Yii::app()->user->getState('pegawai_id');
        } else {
            $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
            if(isset($_GET['pasienadmisi_id'])) {
                $modKirimKeUnitLain->pegawai_id = $modPendaftaran->admisi->pegawai_id;
            }
        }
        $modKirimKeUnitLain->ruangan_id = 56;
        
    
        if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR && $modPendaftaran->penjamin_id == Params::PENJAMIN_ID_UMUM)
            $modKirimKeUnitLain->isbayarkekasirpenunjang = Yii::app()->user->getState('isbayarkekasirpenunjang');
        else
            $modKirimKeUnitLain->isbayarkekasirpenunjang = false;     
            $modPemeriksaanRad = new TarifpemeriksaanradruanganV();

        //RSPMC-1260
        if (!empty(Yii::app()->user->getState('kelasrujukanpenunjang_id'))) {
            $modKirimKeUnitLain->kelaspelayanan_id = Yii::app()->user->getState('kelasrujukanpenunjang_id');
        } else {
            $modKirimKeUnitLain->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
        }
        
        // $modPeriksaRad = RJPemeriksaanRadM::model()->findAllByAttributes(array('pemeriksaanrad_aktif' => true), array('order' => 'jenispemeriksaanrad_id, pemeriksaanrad_urutan ASC'));

        $critpr = new CDbCriteria;
        $critpr->select = 't.pemeriksaanrad_id, t.pemeriksaanrad_nama, t.jenispemeriksaanrad_id,
                            t.jenispemeriksaanrad_nama, d.daftartindakan_id, k.kelaspelayanan_id';
        $critpr->join = ' JOIN jenispemeriksaanrad_m j ON t.jenispemeriksaanrad_id = t.jenispemeriksaanrad_id
                          JOIN daftartindakan_m d ON t.daftartindakan_id = d.daftartindakan_id
                          JOIN tariftindakan_m tt ON tt.daftartindakan_id = d.daftartindakan_id
                          JOIN kelaspelayanan_m k ON tt.kelaspelayanan_id = k.kelaspelayanan_id ';
        $critpr->group = $critpr->select;
        $critpr->order = ' t.pemeriksaanrad_id, t,pemeriksaanrad_urutan ';
        $critpr->addCondition('t.pemeriksaanrad_aktif = true');

        // if(!empty($modPendaftaran->kelaspelayanan_id)) {
        //   $critpr->addCondition('k.kelaspelayanan_id = ' . $modPendaftaran->kelaspelayanan_id);
        // }

        $modJenisPeriksaRad = JenispemeriksaanradM::model()->findAll('jenispemeriksaanrad_aktif = true');
        // $modPeriksaRad = RJPemeriksaanRadM::model()->findAll($critpr);



        $critjns = new CDbCriteria();
        $critjns->select = 't.jenispemeriksaanrad_id, t.jenispemeriksaanrad_nama, count(t.jenispemeriksaanrad_id) as jumlah_jenis, t.jenispemeriksaanrad_urutan';
        $critjns->group = 't.jenispemeriksaanrad_id, t.jenispemeriksaanrad_nama, t.jenispemeriksaanrad_urutan';
        $critjns->order = 't.jenispemeriksaanrad_urutan';
        $critjns->having = 'count(t.jenispemeriksaanrad_id) > 0';
        $modJenis = OrderpemeriksaanradV::model()->findAll($critjns);
        
        // echo '<pre>'; var_dump($modJenis); die;

        $criteria = new CDbCriteria();
        $criteria->select = 't.*';
        $criteria->compare('t.is_paket',false);
        $criteria->order = 't.jenispemeriksaanrad_urutan, t.pemeriksaanrad_nama';

        $modPeriksaRad = OrderpemeriksaanradV::model()->findAll($criteria);

        $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id);

        $nama_modul = Yii::app()->controller->module->id;
        $nama_controller = Yii::app()->controller->id;
        $nama_action = Yii::app()->controller->action->id;
        $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
        $criteria = new CDbCriteria;
        $criteria->compare('modul_id', $modul_id);
        $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
        $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
        if (isset($_POST['tujuansms'])) {
            $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
        }
        $modSmsgateway = SmsgatewayM::model()->findAll($criteria);


        // if (isset($idPasienKirimKeUnitLain)) {
        //     $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($idPasienKirimKeUnitLain);
        //     $modPasien = PasienM::model()->findByPk($modKirimKeUnitLain->pasien_id);
        // }

        $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id')) ? null : KonsulpoliT::model()->findByAttributes(array(
                    'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
                    'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
                        ), array(
                    'order' => 'tglkonsulpoli desc',
        ));


        if (!empty($konsul)) {
            $modKirimKeUnitLain->pegawai_id = $konsul->pegawai_id;
        }

        if (isset($_POST['RJPasienKirimKeUnitLainT'])) {

            // echo '<pre>'; var_dump($_POST); die;
            
            $transaction = Yii::app()->db->beginTransaction();
            try {                
                // $cito = in_array("ya", $_POST['permintaanPenunjang']['cito_true']);
                $cito = false;

                if (isset($_POST['permintaanPenunjang'])) {
                    $modKirimKeUnitLain = $this->savePermintaanPenunjang($_POST['permintaanPenunjang'], $modPendaftaran, $cito);

                    PendaftaranT::model()->updateByPk(
                            $modPendaftaran->pendaftaran_id,
                            array(
                                'pembayaranpelayanan_id' => null
                            )
                    );

                    //                        RND-6398
                    //                        $params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
                    //                        $params['create_time'] = date( 'Y-m-d H:i:s');
                    //                        $params['create_loginpemakai_id'] = Yii::app()->user->id;
                    //                        $params['instalasi_id'] = 6;
                    //                        $params['modul_id'] = 9;
                    //                        $ruangan = RuanganM::model()->findByPk($ruangan_id);
                    //                        $params['isinotifikasi'] = $modPasien->no_rekam_medik . '-' . $modPendaftaran->no_pendaftaran . '-' . $modPasien->nama_pasien . '-' . $ruangan->ruangan_nama;
                    //                        $params['create_ruangan'] = 19;
                    //                        $params['judulnotifikasi'] = 'Rujukan Rawat Jalan';                        
                    //                        $nofitikasi = NotifikasiRController::insertNotifikasi($params);                        
                } else {
                    $this->statusSavePermintaanPenunjang = true;
                }

                $judul = 'Pasien Rujuk ke Radiologi';
                
                if ($modKirimKeUnitLain->is_cito){
                    $judul .= ' - <span class="required">CITO</span>';
                }

                $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;
                $mr = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);

                $link = Yii::app()->createUrl('/radiologi/rujukanPenunjang/Index', array(
                    'PasienkirimkeunitlainV[tgl_awal]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
                    'PasienkirimkeunitlainV[tgl_akhir]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
                    'PasienkirimkeunitlainV[no_pendaftaran]' => !empty($modKirimKeUnitLain->pendaftaran)?$modKirimKeUnitLain->pendaftaran->no_pendaftaran:'',
                    'PasienkirimkeunitlainV[no_rekam_medik]' => $modPasien->no_rekam_medik,
                    'PasienkirimkeunitlainV[nama_pasien]' => $modPasien->nama_pasien
                ));

                // var_dump($modKirimKeUnitLain->attributes); die;

                // var_dump($link); die;

                $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                            array('instalasi_id' => $mr->instalasi_id, 'ruangan_id' => $mr->ruangan_id, 'modul_id' => $mr->modul_id, 'link_proses' => $link),
                                // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
                                // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
                ));

                if (empty($modPendaftaran->waktumulaiperiksa)){
                    PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id,array('waktumulaiperiksa'=> date('Y-m-d H:i:s'))); 
                }
                // die;
                if ($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang) {

                    // SMS GATEWAY
                    $modPegawai = $modPendaftaran->pegawai;
                    $sms = new Sms();
                    $smspasien = 1;
                    foreach ($modSmsgateway as $i => $smsgateway) {
                        $isiPesan = $smsgateway->templatesms;

                        $attributes = $modPasien->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modPendaftaran->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modPegawai->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modKirimKeUnitLain->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modKirimKeUnitLain->tgl_kirimpasien), $isiPesan);

                        if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                            if (!empty($modPasien->no_mobile_pasien)) {
                                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                            } else {
                                $smspasien = 0;
                            }
                        }
                    }
                    // END SMS GATEWAY

                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
                    $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'smspasien' => $smspasien, 'idPasienKirimKeUnitLain' => $modKirimKeUnitLain->pasienkirimkeunitlain_id,
                     'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data tidak valid ");
                }
            } catch (Exception $exc) {
                echo '<pre>'; var_dump($exc); die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $q_riwayat = "(pendaftaran_id = ".$pendaftaran_id." OR (pendaftaran_id IS NULL AND pasien_id = ".$modPendaftaran->pasien_id.") ) AND instalasi_id = ".Params::INSTALASI_ID_RAD." ORDER BY  pasienmasukpenunjang_id IS NULL";

        // echo'<pre>'; var_dump($q_riwayat); die;
        
        $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAll($q_riwayat);

        $this->render($this->path_view . 'index', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modKirimKeUnitLain' => $modKirimKeUnitLain,
            'modPeriksaRad' => $modPeriksaRad,
            'modJenisPeriksaRad' => $modJenisPeriksaRad,
            'modJenis' => $modJenis,
      'modPemeriksaanRad' => $modPemeriksaanRad,
            'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
            'modJenisTarif' => $modJenisTarif,
        ));
    }

    protected function savePasienKirimKeUnitLain($modPendaftaran, $is_cito) {
        $format = new MyFormatter();
        $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
        $modKirimKeUnitLain->attributes = $_POST['RJPasienKirimKeUnitLainT'];
        $modKirimKeUnitLain->pasien_id = $modPendaftaran->pasien_id;
        $modKirimKeUnitLain->carabayar_id = $modPendaftaran->carabayar_id;
        $modKirimKeUnitLain->penjamin_id = $modPendaftaran->penjamin_id;
        $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_RAD;

        // $modKirimKeUnitLain->ruangan_id = Params::RUANGAN_ID_RAD;
        $modKirimKeUnitLain->tgl_kirimpasien = $format->formatDateTimeForDb($_POST['RJPasienKirimKeUnitLainT']['tgl_kirimpasien']);
        // $modKirimKeUnitLain->tglrencanapemeriksaan = $format->formatDateTimeForDb($_POST['RJPasienKirimKeUnitLainT']['tglrencanapemeriksaan']);
        $modKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
        $modKirimKeUnitLain->update_time = date("Y-m-d H:i:s");
        $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
        $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
        $modKirimKeUnitLain->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
        $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
        $modKirimKeUnitLain->tglrencanapemeriksaan = null;
        $modKirimKeUnitLain->isbayarkekasirpenunjang = isset($_POST['RJPasienKirimKeUnitLainT']['isbayarkekasirpenunjang']) ? $_POST['RJPasienKirimKeUnitLainT']['isbayarkekasirpenunjang'] : 0;
        $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
        $modKirimKeUnitLain->is_cito = $is_cito;
        !$modKirimKeUnitLain->is_elektif = $_POST['RJPasienKirimKeUnitLainT']['is_elektif'];

        // $modKirimKeUnitLain->is_elektif = 

        
        if (!$modKirimKeUnitLain->is_elektif){
            $modKirimKeUnitLain->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        } else {
            $modKirimKeUnitLain->pendaftaran_id = null;
        }

        // echo '<pre>'; var_dump($modKirimKeUnitLain->attributes, $is_cito); die;


        // $cito = false;
        // foreach ($is_cito as $ct) {
        //     if(in_array("1", $ct)) {
        //         $cito = true;
        //     }
        // }
        // $modKirimKeUnitLain->is_cito = $cito;


        if ($modKirimKeUnitLain->validate()) {
            $modKirimKeUnitLain->save();
            $this->statusSaveKirimkeUnitLain = true;

            $p = PendaftaranT::model()->findByPk($modPendaftaran->pendaftaran_id);
            $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);

            $st = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'create_ruangan' => Yii::app()->user->getState('ruangan_id')));
            if (!empty($st)) {
                $pasienpenunjang = PasienmasukpenunjangT::model()->updateByPk($st->pasienmasukpenunjang_id, array(
                    'statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA
                ));
                // echo '<pre>'; var_dump('st1', $st->pasienmasukpenunjang_id, $a->statusperiksa);die;
            }
            /* ================================================ */
            /* Proses update status periksa KonsulPoli EHS-179  */
            /* ================================================ */
            $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
            $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => $ruangan_id));
            if (!empty($konsulPoli)) {
                $updateStatusPeriksa = KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
            }
            /* ================================================ */
        }

        return $modKirimKeUnitLain;
    }

    protected function savePermintaanPenunjang($permintaan, $modPendaftaran, $cito) {
        // var_dump($permintaan); die;

        $pendaftaran = PendaftaranT::model()->findByPk($modPendaftaran->pendaftaran_id);
        $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modPendaftaran, $cito);

        foreach ($permintaan['inputpemeriksaanrad'] as $i => $value) {

            $cito = $_POST['permintaanPenunjang']['cito_true'][$i] == "ya" ? true : false;
            
            $modPermintaan = new RJPermintaanPenunjangT;
            $modPermintaan->daftartindakan_id = $permintaan['idDaftarTindakan'][$i];
            $modPermintaan->pemeriksaanlab_id = '';
            $modPermintaan->pemeriksaanrad_id = $permintaan['inputpemeriksaanrad'][$i];
            $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
            $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PR');
            $modPermintaan->qtypermintaan = $permintaan['inputqty'][$i];
            $modPermintaan->tarif_pelayananan = $permintaan['inputtarifpemeriksaanrad'][$i];
            $modPermintaan->tglpermintaankepenunjang = $modKirimKeUnitLain->tgl_kirimpasien; //date('Y-m-d H:i:s');
            $modPermintaan->is_cito = $permintaan['cito_true'][$i] == "ya" ? true : false;

            $criteria = new CDbCriteria;
            $criteria->addCondition('kode_unik = \'' . $permintaan['kode_unik'][$i] . '\'');
            $criteria->addCondition('kelaspelayanan_id = ' . $pendaftaran->kelaspelayanan_id);
            $criteria->addCondition('penjamin_id = ' . $pendaftaran->penjamin_id);
            $criteria->addCondition('carabayar_id = ' . $pendaftaran->carabayar_id);

            $modTarif = TarifpemeriksaanradruanganV::model()->find($criteria);

            $modPermintaan->kode_unik = $permintaan['inputpemeriksaanrad'][$i];

            if(!empty($modTarif)) {
                $modPermintaan->pemeriksaanrad_id = $modTarif->pemeriksaanrad_id;
                $modPermintaan->tarif_pelayananan = $modTarif->harga_tariftindakan;
            } else {
                $modPermintaan->tarif_pelayananan = 0;
            }

            if ($modPermintaan->is_cito == true) {
                $modKirimKeUnitLain->is_cito = true;
                $modKirimKeUnitLain->save();
            }

            // insert paket pelayanan
            /*
              if (isset($permintaan['tindakanpelayanan_id'][$i])) {
              $modPermintaan->tindakanpelayanan_id = $permintaan['tindakanpelayanan_id'][$i];
              }
             * 
             */

            // var_dump($modPermintaan->attributes); die;

            if ($modPermintaan->validate()) {
                if ($modPermintaan->save()) {
                    $this->statusSavePermintaanPenunjang = true;

                    // insert tindakan, jika bayar kasir di centang dan belum ada tindakan dari paket.
                    /*
                      if($modKirimKeUnitLain->isbayarkekasirpenunjang && empty($modPermintaan->tindakanpelayanan_id)){
                      $modPendaftaran = $modKirimKeUnitLain->pendaftaran;
                      $modTindakan = $this->simpanTindakanPelayanan($modPendaftaran,$modKirimKeUnitLain,$modPermintaan); //AGAR BISA DI BAYAR DI KASIR
                      $modPermintaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
                      $modPermintaan->update();
                      }
                     * 
                     */
                }
            }
            // var_dump($modPermintaan->attributes);
        }

        return $modKirimKeUnitLain;

        // die;
    }

    /**
     * proses simpan TindakanPelayananT dan TindakanKomponenT
     * khusus untuk permintaan penunjang
     */
    public function simpanTindakanPelayanan($modPendaftaran, $modKirimKeUnitLain, $modPermintaan) {
        $modTindakan = new RJTindakanPelayananT;

        $modTindakan->attributes = $modPendaftaran->attributes;
        $modTindakan->ruangan_id = $modKirimKeUnitLain->ruangan_id;
        $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
        $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modTindakan->daftartindakan_id = $modPermintaan->daftartindakan_id;
        $modTindakan->tarif_satuan = $modPermintaan->tarif_pelayananan;
        $modTindakan->qty_tindakan = $modPermintaan->qtypermintaan;
        $modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_LABORATORIUM;
        $modTindakan->create_time = date("Y-m-d H:i:s");
        $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
        $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
        $modTindakan->dokterpemeriksa1_id = $modKirimKeUnitLain->pegawai_id;
        $modTindakan->perawat_id = (!empty($modKirimKeUnitLain->perawat_id) ? $modKirimKeUnitLain->perawat_id : null);
        $modTindakan->tgl_tindakan = $modPermintaan->tglpermintaankepenunjang;
        $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
        $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
        $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
        $modTindakan->cyto_tindakan = 0;
        $modTindakan->tarifcyto_tindakan = 0;
        $modTindakan->discount_tindakan = 0;
        $modTindakan->subsidiasuransi_tindakan = 0;
        $modTindakan->subsidipemerintah_tindakan = 0;
        $modTindakan->subsisidirumahsakit_tindakan = 0;
        $modTindakan->iurbiaya_tindakan = 0;
        $modTindakan->tarif_rsakomodasi = 0;
        $modTindakan->tarif_medis = 0;
        $modTindakan->tarif_paramedis = 0;
        $modTindakan->tarif_bhp = 0;

        if ($modTindakan->validate()) {
            if ($modTindakan->save()) {
                $this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
            }
        } else {
            $this->tindakanpelayanantersimpan &= false;
        }

        return $modTindakan;
    }

    //copy dari RJ - LaboratoriumController penyesuaian di $modRiwayatKirimKeUnitLain
    public function actionAjaxBatalKirim() {
        if (Yii::app()->request->isAjaxRequest) {
            $pasienkirimkeunitlain_id = empty($_POST['pasienkirimkeunitlain_id']) ? null : $_POST['pasienkirimkeunitlain_id'];
            $pasien_id = empty($_POST['pasien_id']) ? null : $_POST['pasien_id'];
            $data['pesan'] = "Pasien kirim ke radiologi gagal dibatalkan!";
            $data['sukses'] = 0;
            $kirimUnit = array();

            $status = 'ok';

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $criteria = new CDbCriteria();
                $criteria->select = "count(t.permintaankepenunjang_id) as permintaankepenunjang_id";
                $criteria->join = "join tindakanpelayanan_t tp on tp.tindakanpelayanan_id = t.tindakanpelayanan_id ";
                $criteria->addCondition("t.pasienkirimkeunitlain_id = " . $pasienkirimkeunitlain_id . " and tp.tindakansudahbayar_id is not null");
                $permintaan = PermintaankepenunjangT::model()->find($criteria);
                $kirim = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);

                if ($permintaan->permintaankepenunjang_id > 0) {
                    $data['pesan'] = "Pasien kirim ke radiologi tidak bisa dibatalkan karena tindakan sudah dibayarkan!";
                    $data['sukses'] = 0;
                } else {
                    $ok = true;
                    $kirim = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);

                    if (!empty($kirim)) {
                        $kirimUnit = array(
                            'instalasi_id' => $kirim->instalasi_id,
                            'ruangan_id' => $kirim->ruangan_id,
                            'pasien_id' => $kirim->pasien_id,
                            // 'no_pendaftaran' => $kirim->pendaftaran->no_pendaftaran
                        );
                    }

                    $permintaan = PermintaankepenunjangT::model()->findAllByAttributes(array(
                        'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id
                    ));
                    foreach ($permintaan as $item) {
                        if (!empty($item->tindakanpelayanan_id)) {
                            $ok = $ok && TindakanpelayananT::model()->deleteByPk($item->tindakanpelayanan_id);
                        }
                    }
                    $ok = $ok && PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
                    $ok = $ok && PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
                    $keterangan = "Pasien berhasil dibatalkan";

                    if ($status == 'ok' && $ok) {

                        $this->notifBatalRujuk($kirimUnit);

                        $data['pesan'] = "Pasien kirim ke radiologi berhasil dibatalkan!";
                        $data['sukses'] = 1;
                        $transaction->commit();
                    } else {
                        $transaction->rollback();
                        $data['pesan'] = "Pasien kirim ke radiologi tidak bisa dibatalkan!";
                        $data['sukses'] = 0;
                    }
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                $data['pesan'] = "Pasien kirim ke radiologi gagal dibatalkan!<br/>" . $exc->getMessage();
                $data['sukses'] = 0;
            }
            $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(
                    array(
                        'pendaftaran_id' => $kirim->pendaftaran_id,
                        'ruangan_id' => Params::RUANGAN_ID_RAD
                    ),
                    'pasienmasukpenunjang_id IS NULL'
            );

            $data['result'] = $this->renderPartial($this->path_view . '_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain), true);

            echo json_encode($data);
            Yii::app()->end();

        }
    }

    public function actionUpdate($pendaftaran_id, $idPasienKirimKeUnitLain = null) {
        $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
        $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
        // $modKirimKeUnitLain->tglrencanapemeriksaan = $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
        $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
        $modKirimKeUnitLain->ruangan_id = 56;
        
    
        if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR && $modPendaftaran->penjamin_id == Params::PENJAMIN_ID_UMUM)
            $modKirimKeUnitLain->isbayarkekasirpenunjang = Yii::app()->user->getState('isbayarkekasirpenunjang');
        else
            $modKirimKeUnitLain->isbayarkekasirpenunjang = false;     
            $modPemeriksaanRad = new TarifpemeriksaanradruanganV();

        //RSPMC-1260
        if (!empty(Yii::app()->user->getState('kelasrujukanpenunjang_id'))) {
            $modKirimKeUnitLain->kelaspelayanan_id = Yii::app()->user->getState('kelasrujukanpenunjang_id');
        } else {
            $modKirimKeUnitLain->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
        }
        
        // $modPeriksaRad = RJPemeriksaanRadM::model()->findAllByAttributes(array('pemeriksaanrad_aktif' => true), array('order' => 'jenispemeriksaanrad_id, pemeriksaanrad_urutan ASC'));

        $critpr = new CDbCriteria;
        $critpr->select = 't.pemeriksaanrad_id, t.pemeriksaanrad_nama, t.jenispemeriksaanrad_id,
                            t.jenispemeriksaanrad_nama, d.daftartindakan_id, k.kelaspelayanan_id';
        $critpr->join = ' JOIN jenispemeriksaanrad_m j ON t.jenispemeriksaanrad_id = t.jenispemeriksaanrad_id
                          JOIN daftartindakan_m d ON t.daftartindakan_id = d.daftartindakan_id
                          JOIN tariftindakan_m tt ON tt.daftartindakan_id = d.daftartindakan_id
                          JOIN kelaspelayanan_m k ON tt.kelaspelayanan_id = k.kelaspelayanan_id ';
        $critpr->group = $critpr->select;
        $critpr->order = ' t.pemeriksaanrad_id, t,pemeriksaanrad_urutan ';
        $critpr->addCondition('t.pemeriksaanrad_aktif = true');

        // if(!empty($modPendaftaran->kelaspelayanan_id)) {
        //   $critpr->addCondition('k.kelaspelayanan_id = ' . $modPendaftaran->kelaspelayanan_id);
        // }

        $modJenisPeriksaRad = JenispemeriksaanradM::model()->findAll('jenispemeriksaanrad_aktif = true');
        // $modPeriksaRad = RJPemeriksaanRadM::model()->findAll($critpr);



        $critjns = new CDbCriteria();
        $critjns->select = 't.jenispemeriksaanrad_id, t.jenispemeriksaanrad_nama, count(t.jenispemeriksaanrad_id) as jumlah_jenis, t.jenispemeriksaanrad_urutan';
        $critjns->group = 't.jenispemeriksaanrad_id, t.jenispemeriksaanrad_nama, t.jenispemeriksaanrad_urutan';
        $critjns->order = 't.jenispemeriksaanrad_urutan';
        $critjns->having = 'count(t.jenispemeriksaanrad_id) > 0';
        $modJenis = OrderpemeriksaanradV::model()->findAll($critjns);
        
        // echo '<pre>'; var_dump($modJenis); die;

        $criteria = new CDbCriteria();
        $criteria->select = 't.*';
        $criteria->compare('t.is_paket',false);
        $criteria->order = 't.jenispemeriksaanrad_urutan, t.pemeriksaanrad_nama';

        $modPeriksaRad = OrderpemeriksaanradV::model()->findAll($criteria);

        $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id);

        $nama_modul = Yii::app()->controller->module->id;
        $nama_controller = Yii::app()->controller->id;
        $nama_action = Yii::app()->controller->action->id;
        $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
        $criteria = new CDbCriteria;
        $criteria->compare('modul_id', $modul_id);
        $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
        $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
        if (isset($_POST['tujuansms'])) {
            $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
        }
        $modSmsgateway = SmsgatewayM::model()->findAll($criteria);


        if (isset($idPasienKirimKeUnitLain)) {
             $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($idPasienKirimKeUnitLain);
             $modPasien = PasienM::model()->findByPk($modKirimKeUnitLain->pasien_id);
        }

        $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id')) ? null : KonsulpoliT::model()->findByAttributes(array(
                    'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
                    'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
                        ), array(
                    'order' => 'tglkonsulpoli desc',
        ));

        /*
        if (!empty($konsul)) {
            $modKirimKeUnitLain->pegawai_id = $konsul->pegawai_id;
        }
        */

        if (isset($_POST['RJPasienKirimKeUnitLainT'])) {

            // echo '<pre>'; var_dump($_POST); die;
            
            $transaction = Yii::app()->db->beginTransaction();
            try {                
                // $cito = in_array("ya", $_POST['permintaanPenunjang']['cito_true']);
                $cito = true;

                if (isset($_POST['permintaanPenunjang'])) {

                    $delete = PermintaankepenunjangT::model()->deleteAllByAttributes(array(
                        'pasienkirimkeunitlain_id'=>$modKirimKeUnitLain->pasienkirimkeunitlain_id
                    ));
                    $deletePasienKirimKeunitLain = PasienkirimkeunitlainT::model()->deleteByPk($modKirimKeUnitLain->pasienkirimkeunitlain_id);

                    if($delete && $deletePasienKirimKeunitLain) {

                        $this->savePermintaanPenunjang($_POST['permintaanPenunjang'], $modPendaftaran, $cito, $modKirimKeUnitLain);
    
                        PendaftaranT::model()->updateByPk(
                                $modPendaftaran->pendaftaran_id,
                                array(
                                    'pembayaranpelayanan_id' => null
                                )
                        );
                    }

                                        
                } else {
                    $this->statusSavePermintaanPenunjang = true;
                }

                $judul = 'Pasien Rujuk ke Radiologi';
                
                if ($modKirimKeUnitLain->is_cito){
                    $judul .= ' - <span class="required">CITO</span>';
                }

                $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;
                $mr = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);

                $link = Yii::app()->createUrl('/radiologi/rujukanPenunjang/Index', array(
                    'PasienkirimkeunitlainV[tgl_awal]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
                    'PasienkirimkeunitlainV[tgl_akhir]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
                    'PasienkirimkeunitlainV[no_pendaftaran]' => !empty($modKirimKeUnitLain->pendaftaran)?$modKirimKeUnitLain->pendaftaran->no_pendaftaran:'',
                    'PasienkirimkeunitlainV[no_rekam_medik]' => $modPasien->no_rekam_medik,
                    'PasienkirimkeunitlainV[nama_pasien]' => $modPasien->nama_pasien
                ));

                vaR_dump($modKirimKeUnitLain->attributes); die;

                $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                            array('instalasi_id' => $mr->instalasi_id, 'ruangan_id' => $mr->ruangan_id, 'modul_id' => $mr->modul_id, 'link_proses' => $link),
                                // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
                                // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
                ));

                if (empty($modPendaftaran->waktumulaiperiksa)){
                    PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id,array('waktumulaiperiksa'=> date('Y-m-d H:i:s'))); 
                }

                if ($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang) {

                    // SMS GATEWAY
                    $modPegawai = $modPendaftaran->pegawai;
                    $sms = new Sms();
                    $smspasien = 1;
                    foreach ($modSmsgateway as $i => $smsgateway) {
                        $isiPesan = $smsgateway->templatesms;

                        $attributes = $modPasien->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modPendaftaran->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modPegawai->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modKirimKeUnitLain->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                            $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modKirimKeUnitLain->tgl_kirimpasien), $isiPesan);

                        if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                            if (!empty($modPasien->no_mobile_pasien)) {
                                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                            } else {
                                $smspasien = 0;
                            }
                        }
                    }
                    // END SMS GATEWAY

                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
                    $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'smspasien' => $smspasien, 'idPasienKirimKeUnitLain' => $modKirimKeUnitLain->pasienkirimkeunitlain_id,
                     'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data tidak valid ");
                }
            } catch (Exception $exc) {
                echo '<pre>'; var_dump($exc); die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
            }
        }

        $q_riwayat = "(pendaftaran_id = ".$pendaftaran_id." OR (pendaftaran_id IS NULL AND pasien_id = ".$modPendaftaran->pasien_id.") ) AND instalasi_id = ".Params::INSTALASI_ID_RAD." ORDER BY  pasienmasukpenunjang_id IS NULL";

        // echo'<pre>'; var_dump($q_riwayat); die;
        
        $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAll($q_riwayat);

        $this->render($this->path_view . 'index', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modKirimKeUnitLain' => $modKirimKeUnitLain,
            'modPeriksaRad' => $modPeriksaRad,
            'modJenisPeriksaRad' => $modJenisPeriksaRad,
            'modJenis' => $modJenis,
      'modPemeriksaanRad' => $modPemeriksaanRad,
            'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
            'modJenisTarif' => $modJenisTarif,
        ));
    }

    // public function actionPrint()
    // {
    //      $pendaftaran_id = $_GET['id'];
    //      $modPendaftaran= PendaftaranT::model()->findByPk($pendaftaran_id);
    //      $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id='.$pendaftaran_id);
    //      $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
    //                                                                                               'ruangan_id'=>Params::RUANGAN_ID_RAD),
    //                                                                                         'pasienmasukpenunjang_id IS NULL');
    //     $judulLaporan='Permintaan Pasien Ke Radiologi';
    //     $caraPrint=$_REQUEST['caraPrint'];
    //     if($caraPrint=='PRINT') {
    //         $this->layout='//layouts/printWindows';
    //         $this->render($this->path_view.'Print',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
    //     }
    //     else if($caraPrint=='EXCEL') {
    //         $this->layout='//layouts/printExcel';
    //         $this->render($this->path_view.'Print',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
    //     }
    //     else if($_REQUEST['caraPrint']=='PDF') {
    //         $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
    //         $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
    //         $mpdf = new MyPDF60('',$ukuranKertasPDF); 
    //         //$mpdf->useOddEven = 2;  
    //         $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    //         $mpdf->WriteHTML($stylesheet,1);  
    //         $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
    //         $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
    //         $mpdf->Output();
    //     }                       
    // }

    public function actionPrint() {
        $pendaftaran_id = $_GET['id'];
        $idPasienKirimKeUnitLain = $_GET['idPasienKirimKeUnitLain'];
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(
                array(
                    'pendaftaran_id' => $pendaftaran_id,
                    'pasienkirimkeunitlain_id' => $idPasienKirimKeUnitLain
                ),
                'pasienmasukpenunjang_id IS NULL'
        );

        $judulLaporan = 'Permintaan Pemeriksaan Radiologi';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
            $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
            $mpdf->WriteHTML($formatkonten, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1);

            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }

    }

    public function actionPrintRiwayat() {
        $pendaftaran_id = $_GET['id'];
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id=' . $pendaftaran_id);
        $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'instalasi_id' => Params::INSTALASI_ID_RAD), 'pasienmasukpenunjang_id IS NULL');
        $judulLaporan = 'Permintaan Pemeriksaan Radiologi';
        $caraPrint = $_REQUEST['caraPrint'];
        if ($caraPrint == 'PRINT') {
            $this->layout = '//layouts/printWindows';
            $this->render($this->path_view . 'printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($this->path_view . 'printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
            $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
            $mpdf->WriteHTML($formatkonten, 1);
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output();
        }
    }

    /**
     * @author Deni Hamdani <denihamdani@piindonesia.co.id>
     * 
     * UNTUK LOAD DAFTAR PEMERIKSAAN RADIOLOGI
     * 
     */
    public function actionLoadFormPemeriksaanRad() {
        if (Yii::app()->request->isAjaxRequest) {
            $pemeriksaanrad_id = (isset($_POST['pemeriksaanrad_id']) ? $_POST['pemeriksaanrad_id'] : null);
            $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
            $carabayar_id = (isset($_POST['carabayar_id']) ? $_POST['carabayar_id'] : null);
            $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
            $is_paket = (isset($_POST['is_paket']) ? $_POST['is_paket'] : false);
            $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
            $ruangan_id = (isset($_POST['RJPasienKirimKeUnitLainT']['ruangan_id']) ? $_POST['RJPasienKirimKeUnitLainT']['ruangan_id'] : null);
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

            // echo '<pre>';var_dump($ruangan_id);die;
            //$modTindakanRuangan = TindakanruanganV::model()->findByAttributes(array('daftartindakan_id'=>$modPeriksaRad->daftartindakan_id));
            $criteria = new CDbCriteria();
            $criteria->addCondition("kode_unik = '" . $pemeriksaanrad_id . "'"); // AND ruangan_id = '" . Params::RUANGAN_ID_RAD . "'"
            $criteria->addCondition("kelaspelayanan_id=" . $kelaspelayanan_id);
            $criteria->addCondition("carabayar_id=" . $carabayar_id);
            $criteria->limit = 1;

            // var_dump($_POST); die;

            
            $modTarif = TarifpemeriksaanradruanganV::model()->find($criteria);
            // echo '<pre>';var_dump($modTarif);die;
            $cr1 = new CDbCriteria();
            $cr1->addCondition('kode_unik = \'' . $pemeriksaanrad_id . '\'');
            $cr1->addCondition('kelaspelayanan_id = ' . $kelaspelayanan_id);
            $cr1->addCondition('penjamin_id = ' . $penjamin_id);
            $cr1->addCondition('carabayar_id = ' . $carabayar_id);
            
            if($is_paket == 1) {
                $cr1->addCondition('is_paket is true ');
            } else {
                $cr1->addCondition('is_paket is false ');
            }
            
            $cr1->compare('ruangan_id', $ruangan_id);

            // var_dump($modTarif->attributes); die; 

            $cariTarif = TarifpemeriksaanradruanganV::model()->find($cr1);

            if(!empty($cariTarif)) {
                $modTarif->harga_tariftindakan = $cariTarif->harga_tariftindakan;
            } else {
                $modTarif->harga_tariftindakan = 0;
            }  

            

            $id_tindakan = null;
            $paket = null;

            /*
              if (!empty($modTarif)) {
              $crPaket = new CDbCriteria();
              $crPaket->compare('t.daftartindakan_id', $modTarif->daftartindakan_id);
              $crPaket->addCondition('t.tipepaket_id <> '.Params::TIPEPAKET_ID_NONPAKET);
              $crPaket->join = 'left join permintaankepenunjang_t p on t.tindakanpelayanan_id = p.tindakanpelayanan_id';
              $crPaket->addCondition('p.tindakanpelayanan_id is null');
              $crPaket->order = 'p.tindakanpelayanan_id asc';

              $tindakanPaket = TindakanpelayananT::model()->find($crPaket);

              if (!empty($tindakanPaket)) {
              $id_tindakan = null; //$tindakanPaket->tindakanpelayanan_id;
              $paket = TipepaketM::model()->findByPk($tindakanPaket->tipepaket_id);
              }
              }
             * 
             */

            /**
             * dicomment RND-3288
             */
            //                $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id = '.$modPasienAdmisi->penjamin_id)->jenistarif_id;
            //                $modPeriksaRad = PemeriksaanradM::model()->findByPk($pemeriksaanrad_id);
            //                $modTarif = TariftindakanM::model()->findByAttributes(array('daftartindakan_id'=>$modPeriksaRad->daftartindakan_id,
            //                                                                            'kelaspelayanan_id'=>$kelaspelayanan_id,
            //                                                                            'jenistarif_id'=>$jenistarif,
            //                                                                            'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));

            echo CJSON::encode(array(
                'status' => 'create_form',
                'form' => $this->renderPartial($this->path_view . '_formLoadPemeriksaanRad', array(
                    //                                                                                'modPeriksaRad'=>$modPeriksaRad,
                    //'modTindakanRuangan'=>$modTindakanRuangan,
                    'modTarif' => $modTarif, 'id_tindakan' => $pemeriksaanrad_id, 'paket' => $paket
                        ), true)
            ));
            exit;
        }
    }

    /**
     * - digunakan untuk mengenerate notif batal rujukan
     * @param type $modKirimKeunitlain
     */
    protected function notifBatalRujuk($modKirimKeunitlain) {

        $modRuangan = RuanganM::model()->findByPk($modKirimKeunitlain['ruangan_id']);
        $pasien_id = $modKirimKeunitlain['pasien_id'];
        $modPasien = PasienM::model()->findByPk($pasien_id);
        $judul = 'Pasien Batal Rujuk Radiologi';

        $isi = $modPasien->no_rekam_medik . ' ' . $modPasien->nama_pasien;

        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                    array('instalasi_id' => $modKirimKeunitlain['instalasi_id'], 'ruangan_id' => $modRuangan->ruangan_id, 'modul_id' => $modRuangan->modul_id),
        ));
    }

    // Uncomment the following methods and override them if needed
    /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */

     public function actionSetChecklistPemeriksaanRad()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $content = "";
      parse_str($_POST['data'], $post);

      $postPemeriksaan = $post['TarifpemeriksaanradruanganV'];

      $ruangan_id = $post['RJPasienKirimKeUnitLainT']['ruangan_id'];
      $jenispemeriksaanrad_nama = $postPemeriksaan['jenispemeriksaanrad_nama'] ?? null;
      $pemeriksaanrad_nama = $postPemeriksaan['pemeriksaanrad_nama'] ?? null;
      $penjamin_id = $postPemeriksaan['penjamin_id'] ?? null;
      $kelaspelayanan_id = $postPemeriksaan['kelaspelayanan_id'] ?? null;

      $is_paket = (isset($postPemeriksaan['is_paket']) ? $postPemeriksaan['is_paket'] : false);

      $critjns = new CDbCriteria();
      $critjns->select = 't.jenispemeriksaanrad_id, t.jenispemeriksaanrad_nama, count(t.jenispemeriksaanrad_id) as jumlah_jenis, t.jenispemeriksaanrad_urutan';
      $critjns->group = 't.jenispemeriksaanrad_id, t.jenispemeriksaanrad_nama, t.jenispemeriksaanrad_urutan';
      $critjns->order = 't.jenispemeriksaanrad_urutan';
      $critjns->compare('t.is_paket',$is_paket);
      $critjns->compare('t.jenispemeriksaanrad_nama', $jenispemeriksaanrad_nama);
      $critjns->compare('lower(t.pemeriksaanrad_nama)', strtolower($pemeriksaanrad_nama), true);

      $modJenis = OrderpemeriksaanradV::model()->findAll($critjns);


      $criteria = new CDbCriteria();
      $criteria->group = "t.kode_unik, t.pemeriksaanrad_nama, t.jenispemeriksaanrad_id, t.jenispemeriksaanrad_kode, t.jenispemeriksaanrad_nama,
      t.subjenis_pemeriksaanrad_id, t.subjenis_pr_nama,  
      t.jenispemeriksaanrad_urutan, t.is_paket, ta.harga_tariftindakan";
      $criteria->select = $criteria->group;
      $criteria->join = "
      join pemeriksaanrad_m p on p.kode_unik = t.kode_unik
      join tariftindakan_m ta on ta.daftartindakan_id = p.daftartindakan_id 
      join jenistarifpenjamin_m pj on pj.jenistarif_id = ta.jenistarif_id";
      $criteria->compare('t.is_paket',$is_paket);
      $criteria->compare('t.jenispemeriksaanrad_nama',$jenispemeriksaanrad_nama);
      $criteria->compare('lower(t.pemeriksaanrad_nama)', strtolower($pemeriksaanrad_nama), true);
      $criteria->compare('pj.penjamin_id', $penjamin_id);
      $criteria->compare('ta.kelaspelayanan_id', 6);
      $criteria->compare('ta.komponentarif_id', 6);
      $criteria->order = 't.jenispemeriksaanrad_urutan, t.pemeriksaanrad_nama';

      $modPeriksaRad = OrderpemeriksaanradV::model()->findAll($criteria);
    //   echo '<pre>'; var_dump($critjns, $criteria); die();


      // var_dump($modPemeriksaanlabs);die();
      $content = $this->renderPartial($this->path_view . '_checklistPemeriksaanRad', array('modPeriksaRad' => $modPeriksaRad, 'modJenis' => $modJenis), true);
      // }
      echo CJSON::encode(array(
        'content' => $content
      ));
      Yii::app()->end();
    }
    }
}