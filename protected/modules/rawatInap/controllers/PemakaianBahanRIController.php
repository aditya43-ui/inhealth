<?php
Yii::import('rawatJalan.controllers.PemakaianBahanController');
Yii::import('rawatJalan.models.*');
// Yii::import('laboratorium.controllers.PemakaianBahanController');
// Yii::import('laboratorium.models.LBObatalkespasienT');
// Yii::import('laboratorium.models.LBObatalkesM');
// Yii::import('laboratorium.models.LBHasilPemeriksaanLabT');
// Yii::import('laboratorium.models.LBPasienmasukpenunjangT');
// Yii::import('laboratorium.models.LBPasienMasukPenunjangV');
class PemakaianBahanRIController extends PemakaianBahanController
{
  // public $path_view = "rawatInap.views.pemakaianBahanRI.";
  // public $path_view_bmhp = "laboratorium.views.pemakaianBmhp.";
  // public $path_view_bahan = "laboratorium.views.pemakaianBmhp.";
  // public $succesSave = true;
  // public $pesan = "";

  // // dicopy dari laboratorium.controller.pemakaianBmhp
  // public function actionIndex($pasienadmisi_id = null)
  // {
  //   $this->pageTitle = Yii::app()->name . " - Pemakaian Bahan";
  //   $format = new MyFormatter();
  //   $modKunjungan = new RIInfopasienmasukkamarV;
  //   $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
  //   $modObatAlkesPasien = new LBObatalkespasienT;
  //   $dataOas = array();

  //   if (!empty($pasienadmisi_id)) {
  //     if (Yii::app()->user->getState('instalasi_id') != Params::INSTALASI_ID_RD && Yii::app()->user->getState('instalasi_id') != Params::INSTALASI_ID_PERSALINAN) {
  //       $modKunjungan = RIInfopasienmasukkamarV::model()->findByAttributes(array('pasienadmisi_id' => $pasienadmisi_id));
  //       $modKunjungan->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
  //       $modKunjungan->tgladmisi = MyFormatter::formatDateTimeForUser($modKunjungan->tgladmisi);
  //       $modKunjungan->tanggal_lahir = MyFormatter::formatDateTimeForUser($modKunjungan->tanggal_lahir);
  //     } else {
  //       $modKunjungan = InfokunjunganpersalinanV::model()->findByAttributes(array('pasienadmisi_id' => $pasienadmisi_id));
  //       $modKunjungan->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
  //       $a = PasienadmisiT::model()->findByPk($modKunjungan->pasienadmisi_id);
  //       $modKunjungan->tgladmisi = (count((array)$a) > 0) ? MyFormatter::formatDateTimeForUser($a->tgladmisi) : null;
  //       $modKunjungan->tanggal_lahir = MyFormatter::formatDateTimeForUser($modKunjungan->tanggal_lahir);
  //     }
  //   }

  //   if (isset($_GET['pendaftaran_id']) && !empty($_GET['pendaftaran_id'])) {
  //     if (Yii::app()->user->getState('instalasi_id') != Params::INSTALASI_ID_RD && Yii::app()->user->getState('instalasi_id') != Params::INSTALASI_ID_PERSALINAN) {
  //       $modKunjungan = RIInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
  //       $modKunjungan->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
  //       $modKunjungan->tgladmisi = MyFormatter::formatDateTimeForUser($modKunjungan->tgladmisi);
  //       $modKunjungan->tanggal_lahir = MyFormatter::formatDateTimeForUser($modKunjungan->tanggal_lahir);
  //     } else {
  //       $modKunjungan = InfokunjunganpersalinanV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
  //       $modKunjungan->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
  //       $a = PasienadmisiT::model()->findByPk($modKunjungan->pasienadmisi_id);
  //       $modKunjungan->tgladmisi = (count((array)$a) > 0) ? MyFormatter::formatDateTimeForUser($a->tgladmisi) : null;
  //       $modKunjungan->tanggal_lahir = MyFormatter::formatDateTimeForUser($modKunjungan->tanggal_lahir);
  //     }
  //   }

  //   if (isset($_POST['LBObatalkespasienT'])) {
  //     if (isset($_POST['pasienadmisi_id'])) {
  //       $modPendaftaran = RIPendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
  //       $modPasienAdmisi = RIPasienAdmisiT::model()->findByPk($_POST['pasienadmisi_id']);
  //       $pasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
  //       $transaction = Yii::app()->db->beginTransaction();

  //       try {
  //         if (count((array)$_POST['LBObatalkespasienT']) > 0) {
  //           //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
  //           $detailGroups = array();
  //           foreach ($_POST['LBObatalkespasienT'] as $i => $postDetail) {
  //             $modDetails[$i] = new LBObatalkespasienT;
  //             $modDetails[$i]->attributes = $postDetail;
  //             $modDetails[$i] = $this->simpanObatAlkesPasien3($modPasienAdmisi, $modPendaftaran, $modDetails[$i]);
  //             $this->simpanStokObatAlkesOut2($modDetails[$i]);

  //             if (Yii::app()->user->getState('isjurnalotomatis') == true) {
  //               $JurObatAlkes = ObatalkesM::model()->findByPk($modDetails[$i]->obatalkes_id);

  //               if (isset($JurObatAlkes)) {
  //                 $modJnsObatRek = JnsobatalkesrekM::model()->findAllByAttributes(array('jenisobatalkes_id' => $JurObatAlkes->jenisobatalkes_id, 'ispemakaianruangan' => true, 'ruangan_id' => Yii::app()->user->getState("ruangan_id")));

  //                 if (count((array)$modJnsObatRek) > 0) {
  //                   $modJurnalRekening = $this->saveJurnalRekening($modPendaftaran, $modDetails[$i]);

  //                   foreach ($modJnsObatRek as $jnsObatRek) {
  //                     $this->saveJurnalDetail($modJurnalRekening, $modDetails[$i], $jnsObatRek);
  //                   }

  //                   $this->obatalkespasientersimpan = $this->succesSave;
  //                 }
  //               }
  //             }
  //             /*
  //                           $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
  //                           $modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
  //                           $obatalkes_id = $postDetail['obatalkes_id'];
  //                           if(isset($detailGroups[$obatalkes_id])){
  //                               $detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
  //                           }else{
  //                               $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
  //                               $detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
  //                           }
  //                            *
  //                            */
  //           }
  //           //END GROUP
  //         }
  //         /*
  //                   $obathabis = "";
  //                   //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
  //                   foreach($detailGroups AS $i => $detail){
  //                       $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
  //                       if(count((array)$modStokOAs) > 0){
  //                           foreach($modStokOAs AS $i => $stok){
  //                               $modDetails[$i] = $this->simpanObatAlkesPasien($modPasienAdmisi,$stok, $_POST['LBObatalkespasienT']);
  //                               $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
  //                           }
  //                       }else{
  //                           $this->stokobatalkestersimpan &= false;
  //                           $obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;

  //                       }
  //                   }
  //                    *
  //                    */

  //         //                    if(count((array)$_POST['LBObatalkespasienT']) > 0){
  //         //                        foreach($_POST['LBObatalkespasienT'] AS $i => $postOa){
  //         //                            $dataOas[$i] = $this->simpanObatAlkesPasien($modPasienAdmisi,$postOa);
  //         //                        }
  //         //                    }
  //         // var_dump($this->obatalkespasientersimpan&&$this->stokobatalkestersimpan); die;

  //         // notif
  //         $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));

  //         $judul = "Pemakaian Bahan Pasien - " . $pasien->no_rekam_medik;
  //         $isi = "Tgl. Pemakaian : " . MyFormatter::formatDateTimeForUser($modDetails[0]->tglpelayanan) . "<br />";
  //         $isi .= "No. Pendaftaran : " . $modPendaftaran->no_pendaftaran;
  //         $isi .= "Pasien : " . $pasien->nama_pasien . " - " . $pasien->no_rekam_medik;

  //         $ok = CustomFunction::broadcastNotif($judul, $isi, array(
  //           array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
  //         ));

  //         if ($this->obatalkespasientersimpan && $this->stokobatalkestersimpan) {
  //           $transaction->commit();

  //           //jika pasien admisi kosong, karena fungsi ini dipakai selain RI
  //           if (!empty($modPasienAdmisi)) {
  //             $this->redirect(array('index', 'pasienadmisi_id' => $modPasienAdmisi->pasienadmisi_id, 'pendaftaran_id' => $modPasienAdmisi->pendaftaran_id, 'sukses' => 1));
  //           } else {
  //             $this->redirect(array('index', 'pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'sukses' => 1));
  //           }
  //         } else {
  //           $transaction->rollback();
  //           Yii::app()->user->setFlash('error', "Data pemakaian BMHP gagal disimpan !");
  //         }
  //       } catch (Exception $e) {
  //         $transaction->rollback();
  //         Yii::app()->user->setFlash('error', "Data pemakaian BMHP gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
  //       }
  //     }
  //   }

  //   $this->render($this->path_view . 'index', array(
  //     'modKunjungan' => $modKunjungan,
  //     'modObatAlkesPasien' => $modObatAlkesPasien,
  //     'dataOas' => $dataOas,
  //   ));
  // }

  // /**
  //  * simpan RIObatalkespasienT
  //  * @param type $modPasienAdmisi
  //  * @param type $post
  //  * @return \RIObatalkespasienT
  //  */
  // public function simpanObatAlkesPasien3($modPasienAdmisi, $modPendaftran, $postObatAlkesPasien)
  // {
  //   $oa = ObatalkesM::model()->findByPk($postObatAlkesPasien->obatalkes_id);
  //   $modObatAlkesPasien = new RIObatalkespasienT();
  //   $modObatAlkesPasien->attributes = $postObatAlkesPasien->attributes;
  //   $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
  //   $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
  //   $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
  //   $modObatAlkesPasien->pendaftaran_id = empty($modPasienAdmisi) ? $modPendaftran->pendaftaran_id : $modPasienAdmisi->pendaftaran_id;
  //   $modObatAlkesPasien->pasienmasukpenunjang_id = null;
  //   $modObatAlkesPasien->pasienadmisi_id = $modPendaftran->pasienadmisi_id;
  //   $modObatAlkesPasien->carabayar_id = $modPendaftran->carabayar_id;
  //   $modObatAlkesPasien->penjamin_id = $modPendaftran->penjamin_id;
  //   $modObatAlkesPasien->pegawai_id = empty($modPasienAdmisi) ? $modPendaftran->pegawai_id : $modPasienAdmisi->pegawai_id;
  //   $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
  //   $modObatAlkesPasien->pasien_id = $modPendaftran->pasien_id;
  //   $modObatAlkesPasien->kelaspelayanan_id = empty($modPasienAdmisi) ? $modPendaftran->kelaspelayanan_id : $modPasienAdmisi->kelaspelayanan_id;
  //   $modObatAlkesPasien->tglpelayanan = date('Y-m-d H:i:s');
  //   $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
  //   $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
  //   $modObatAlkesPasien->create_time = date('Y-m-d H:i:s');
  //   //$modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
  //   //$modObatAlkesPasien->qty_stok = $stokOa->qtystok;
  //   $modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stokOa->HPP;
  //   $modObatAlkesPasien->hargasatuan_oa = $oa->hargajual; //$stokOa->HargaJualSatuan;
  //   $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
  //   $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->hargajual_oa;
  //   /*
  //       foreach ($postObatAlkesPasien AS $i => $postDetail) {
  //           if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
  //               $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];
  //               $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];
  //               $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
  //               $modObatAlkesPasien->iurbiaya = $postDetail['iurbiaya'];
  //           }
  //       }
  //        *
  //        */

  //   if ($modObatAlkesPasien->save()) {
  //     $this->obatalkespasientersimpan &= true;
  //   } else {
  //     $this->obatalkespasientersimpan &= false;
  //   }
  //   return $modObatAlkesPasien;
  // }

  // /**
  //  * simpan RIObatalkespasienT
  //  * @param type $modPasienAdmisi
  //  * @param type $post
  //  * @return \RIObatalkespasienT
  //  */
  // public function simpanObatAlkesPasien($modPasienAdmisi, $stokOa, $postObatAlkesPasien)
  // {
  //   $modObatAlkesPasien = new RIObatalkespasienT();
  //   $modObatAlkesPasien->attributes = $stokOa->attributes;
  //   $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
  //   $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
  //   $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
  //   $modObatAlkesPasien->pendaftaran_id = $modPasienAdmisi->pendaftaran_id;
  //   $modObatAlkesPasien->pasienmasukpenunjang_id = null;
  //   $modObatAlkesPasien->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
  //   $modObatAlkesPasien->carabayar_id = $modPasienAdmisi->pendaftaran->carabayar_id;
  //   $modObatAlkesPasien->penjamin_id = $modPasienAdmisi->pendaftaran->penjamin_id;
  //   $modObatAlkesPasien->pegawai_id = $modPasienAdmisi->pegawai_id;
  //   $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
  //   $modObatAlkesPasien->pasien_id = $modPasienAdmisi->pasien_id;
  //   $modObatAlkesPasien->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
  //   $modObatAlkesPasien->tglpelayanan = date('Y-m-d H:i:s');
  //   $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
  //   $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
  //   $modObatAlkesPasien->create_time = date('Y-m-d H:i:s');
  //   $modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
  //   $modObatAlkesPasien->qty_stok = $stokOa->qtystok;
  //   $modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
  //   $modObatAlkesPasien->hargasatuan_oa = $stokOa->HargaJualSatuan;
  //   $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
  //   foreach ($postObatAlkesPasien as $i => $postDetail) {
  //     if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
  //       $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];
  //       $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];
  //       $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
  //       $modObatAlkesPasien->iurbiaya = $postDetail['iurbiaya'];
  //     }
  //   }

  //   if ($modObatAlkesPasien->save()) {
  //     $this->obatalkespasientersimpan &= true;
  //   } else {
  //     $this->obatalkespasientersimpan &= false;
  //   }
  //   return $modObatAlkesPasien;
  // }

  // /**
  //  * Mengurai data kunjungan berdasarkan:
  //  * - pasienadmisi_id
  //  * @throws CHttpException
  //  */
  // public function actionGetDataKunjungan()
  // {
  //   if (Yii::app()->request->isAjaxRequest) {
  //     $format = new MyFormatter();
  //     $returnVal = array();
  //     $returnVal['pesan'] = "";
  //     $criteria = new CDbCriteria();
  //     if (Yii::app()->user->getState('instalasi_id') != Params::INSTALASI_ID_RD && Yii::app()->user->getState('instalasi_id') != Params::INSTALASI_ID_PERSALINAN) {
  //       $model = $this->loadModPasienRawatInap($_POST['pasienadmisi_id']);
  //     } else {
  //       $model = $this->loadModPasienPersalinan($_POST['pasienadmisi_id'], $_POST['pendaftaran_id']);
  //     }
  //     if (isset($model) && !empty($model->pasienadmisi_id)) {
  //       $loadHasilPemeriksaan = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienadmisi_id' => $model->pasienadmisi_id));
  //       if (!empty($loadHasilPemeriksaan)) {
  //         if (strtolower(trim($loadHasilPemeriksaan->statusperiksahasil)) == strtolower(Params::STATUSPERIKSAHASIL_SUDAH)) {
  //           $returnVal['pesan'] = "Pasien dengan status sudah diperiksa tidak bisa menggunakan obat / alat kesehatan !";
  //         }
  //       }
  //     }

  //     if ($model->statusperiksa == Params::STATUSPERIKSA_ANTRIAN) {
  //       $returnVal['pesan'] = "Pasien dengan status ANTRIAN tidak bisa menggunakan obat / alat kesehatan !";
  //     }
  //     if ($model->statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) {
  //       $returnVal['pesan'] = "Pasien dengan status MENUNGGU ADMISI PASIEN tidak bisa menggunakan obat / alat kesehatan !";
  //     }
  //     if ($model->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
  //       $returnVal['pesan'] = "Pasien dengan status SUDAH PULANG tidak bisa menggunakan obat / alat kesehatan !";
  //     }
  //     if ($model->statusperiksa == Params::STATUSPERIKSA_SEDANG_PERIKSA) {
  //       $returnVal['pesan'] = "Pasien dengan status SEDANG PERIKSA tidak bisa menggunakan obat / alat kesehatan !";
  //     }

  //     $attributes = $model->attributeNames();
  //     foreach ($attributes as $j => $attribute) {
  //       $returnVal["$attribute"] = $model->$attribute;
  //     }
  //     $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
  //     $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
  //     if (Yii::app()->user->getState('instalasi_id') != Params::INSTALASI_ID_RD && Yii::app()->user->getState('instalasi_id') != Params::INSTALASI_ID_PERSALINAN) {
  //       $returnVal["tgladmisi"] = (!empty($model->tgladmisi)) ? $format->formatDateTimeForUser($model->tgladmisi) : '';
  //     } else {
  //       $a = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);
  //       $returnVal["tgladmisi"] = (!empty($a)) ? $format->formatDateTimeForUser($a->tgladmisi) : '';
  //     }
  //     echo CJSON::encode($returnVal);
  //   }
  //   Yii::app()->end();
  // }

  // /**
  //  * @param type $pasienadmisi_id
  //  * @return RIInfopasienmasukkamarV
  //  */
  // public function loadModPasienRawatInap($pasienadmisi_id)
  // {
  //   $criteria = new CDbCriteria;
  //   $criteria->addCondition("t.pasienadmisi_id = " . $pasienadmisi_id);
  //   $model = RIInfopasienmasukkamarV::model()->find($criteria);
  //   return $model;
  // }

  // public function loadModPasienPersalinan($pasienadmisi_id, $pendaftaran_id)
  // {
  //   $criteria = new CDbCriteria;
  //   if (!empty($pasienadmisi_id)) {
  //     $criteria->addCondition("t.pasienadmisi_id = " . $pasienadmisi_id);
  //   } else {
  //     $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
  //   }
  //   $model = InfokunjunganpersalinanV::model()->find($criteria);
  //   return $model;
  // }

  // /**
  //  * set LKTindakanpelayananT yang sudah ada di database
  //  * @params pasienmasukpenunjang_id
  //  */
  // public function actionSetRiwayatObatAlkesPasien()
  // {
  //   if (Yii::app()->request->isAjaxRequest) {
  //     $format = new MyFormatter();
  //     $rows = "";
  //     if (!empty($_POST['pasienadmisi_id'])) {
  //       $loadOaPasiens = RIObatalkespasienT::model()->findAllByAttributes(array('pasienadmisi_id' => $_POST['pasienadmisi_id']));
  //     } else {
  //       $loadOaPasiens = RIObatalkespasienT::model()->findAllByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id']));
  //     }

  //     if (count((array)$loadOaPasiens) > 0) {
  //       foreach ($loadOaPasiens as $i => $modObatAlkesPasien) {
  //         $modObatAlkesPasien->tglpelayanan = $format->formatDateTimeForUser($modObatAlkesPasien->tglpelayanan);
  //         $modObatAlkesPasien->hargajual_oa = $format->formatNumberForUser($modObatAlkesPasien->hargajual_oa);
  //         $modObatAlkesPasien->qty_oa = $format->formatNumberForUser($modObatAlkesPasien->qty_oa);
  //         $modObatAlkesPasien->iurbiaya = $format->formatNumberForUser($modObatAlkesPasien->iurbiaya);
  //         $rows .= $this->renderPartial($this->path_view . "_rowRiwayatObatAlkesPasien", array('modObatAlkesPasien' => $modObatAlkesPasien), true);
  //       }
  //     }
  //     echo CJSON::encode(array(
  //       'rows' => $rows
  //     ));
  //   }
  //   Yii::app()->end();
  // }

  // public function actionPrint($pasienadmisi_id = null, $pendaftaran_id = null)
  // {
  //   $this->layout = '//layouts/printWindows';
  //   $format = new MyFormatter;
  //   if (!empty($pasienadmisi_id)) {
  //     if (Yii::app()->user->getState('instalasi_id') != Params::INSTALASI_ID_RD && Yii::app()->user->getState('instalasi_id') != Params::INSTALASI_ID_PERSALINAN) {
  //       $modPasienAdmisi = RIInfopasienmasukkamarV::model()->findByAttributes(array('pasienadmisi_id' => $pasienadmisi_id));
  //     } else {
  //       $modPasienAdmisi = InfokunjunganpersalinanV::model()->findByAttributes(array('pasienadmisi_id' => $pasienadmisi_id));
  //     }
  //     $modObatAlkesPasien = RIObatalkespasienT::model()->findAllByAttributes(array('pasienadmisi_id' => $pasienadmisi_id));
  //   } else {
  //     if (Yii::app()->user->getState('instalasi_id') != Params::INSTALASI_ID_RD && Yii::app()->user->getState('instalasi_id') != Params::INSTALASI_ID_PERSALINAN) {
  //       $modPasienAdmisi = RIInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
  //     } else {
  //       $modPasienAdmisi = InfokunjunganpersalinanV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
  //     }
  //     $modObatAlkesPasien = RIObatalkespasienT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
  //   }


  //   $judul_print = 'Pemakaian Bahan ' . $modPasienAdmisi->ruangan_nama;
  //   $this->render($this->path_view . 'printPemakaianBahan', array(
  //     'format' => $format,
  //     'judul_print' => $judul_print,
  //     'modPasienAdmisi' => $modPasienAdmisi,
  //     'modObatAlkesPasien' => $modObatAlkesPasien,
  //   ));
  // }

  // /**
  //  * mengembalikan stok jika ada pembatalan
  //  * @param type $obatAlkesT
  //  * di copy dari laboratorium/pemakaianBmhpController
  //  */
  // protected function kembalikanStok($modObatAlkesPasien)
  // {
  //   /*
  //       $stok = new StokobatalkesT;
  //       $stok->attributes = $modObatAlkesPasien->attributes;
  //       $modObatAlkes = ObatalkesM::model()->findByPk($modObatAlkesPasien->obatalkes_id); //sementara menggunakan harga terupdate
  //       $stok->harganetto_oa = $modObatAlkes->harganetto;
  //       $stok->hargajual_oa = $modObatAlkes->hargajual;
  //       $stok->jasadokter = $modObatAlkes->jasadokter;
  //       $stok->discount = $modObatAlkes->discount;
  //       $stok->marginresep = $modObatAlkes->marginresep;
  //       $stok->marginnonresep = $modObatAlkes->marginnonresep;
  //       $stok->hjaresep = $modObatAlkes->hjaresep;
  //       $stok->hjanonresep = $modObatAlkes->hjanonresep;
  //       $stok->hpp = $modObatAlkes->hpp;
  //       $stok->tglstok_in = date('Y-m-d H:i:s');
  //       $stok->tglstok_out = null;
  //       $stok->qtystok_in = $modObatAlkesPasien->qty_oa;
  //       $stok->qtystok_out = 0;
  //       $stok->qtystok_current = $stok->qtystok_in;

  //       if($stok->save())
  //           return true;
  //        *
  //        */
  //   StokobatalkesT::model()->deleteAllByAttributes(array(
  //     'obatalkespasien_id' => $modObatAlkesPasien->obatalkespasien_id,
  //   ));

  //   return true;
  // }

  // protected function saveJurnalRekening($model, $dtDetail)
  // {

  //   $format = new MyFormatter();
  //   $modJurnalRekening = new JurnalrekeningT;
  //   $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PERSEDIAAN;
  //   $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tgl_pendaftaran);
  //   $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
  //   $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
  //   $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
  //   $modJurnalRekening->noreferensi = $model->no_pendaftaran;
  //   $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tgl_pendaftaran);
  //   $modJurnalRekening->nobku = "";
  //   $ruangan_nama = "";
  //   $modRuangan = RuanganM::model()->findByPk($model->ruangan_id);

  //   if (isset($modRuangan)) {
  //     $ruangan_nama = $modRuangan->ruangan_nama;
  //   }
  //   $oa = ObatalkesM::model()->findByPk($dtDetail->obatalkes_id);
  //   $modJurnalRekening->urianjurnal = 'Pemakaian Bahan ' . $oa->obatalkes_nama . " Ruangan " . $ruangan_nama . " - " . $model->no_pendaftaran;

  //   $periodeID = $modJurnalRekening->currentPeriod;
  //   $modJurnalRekening->rekperiod_id = $periodeID;
  //   $modJurnalRekening->create_time = date('Y-m-d H:i:s');
  //   $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
  //   $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
  //   $modJurnalRekening->ruangan_id = $model->create_ruangan;
  //   $modJurnalRekening->obatalkespasien_id = $dtDetail->obatalkespasien_id;

  //   if ($modJurnalRekening->validate()) {
  //     $modJurnalRekening->save();
  //     $this->succesSave = true;
  //   } else {
  //     $this->succesSave = false;
  //     $this->pesan = $modJurnalRekening->getErrors();
  //   }
  //   return $modJurnalRekening;
  // }

  // public function saveJurnalDetail($modJurnalRekening, $postRekenings, $modelRek)
  // {
  //   $valid = true;
  //   $modJurnalPosting = null;
  //   $modObatAlkes = ObatalkesM::model()->findByPk($postRekenings->obatalkes_id);

  //   // $rekening5 = Rekening5M::model()->findByPk($modelRek->rekening5_id);
  //   // $rekening4 = Rekening4M::model()->findByPk($rekening5->rekening4_id);
  //   // $rekening3 = Rekening3M::model()->findByPk($rekening4->rekening3_id);
  //   // $rekening2 = Rekening2M::model()->findByPk($rekening3->rekening2_id);

  //   $modelJurnalDetail = new JurnaldetailT();

  //   $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
  //   $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
  //   $modelJurnalDetail->rekening5_id = $modelRek->rekening5_id;
  //   // $modelJurnalDetail->rekening1_id = $rekening2->rekening1_id;
  //   // $modelJurnalDetail->rekening2_id = $rekening2->rekening2_id;
  //   // $modelJurnalDetail->rekening3_id = $rekening3->rekening3_id;
  //   // $modelJurnalDetail->rekening4_id = $rekening4->rekening4_id;
  //   $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;

  //   $totalHasilQty = ($modObatAlkes->hpp * $postRekenings->qty_oa);

  //   if ($modelRek->debitkredit == 'K') {
  //     $modelJurnalDetail->nourut = 2;
  //     $modelJurnalDetail->saldokredit = $totalHasilQty;
  //     $modelJurnalDetail->saldodebit = 0;
  //   } else if ($modelRek->debitkredit == 'D') {
  //     $modelJurnalDetail->nourut = 1;
  //     $modelJurnalDetail->saldodebit = $totalHasilQty;
  //     $modelJurnalDetail->saldokredit = 0;
  //   }

  //   if ($modelJurnalDetail->validate()) {
  //     $modelJurnalDetail->save();

  //     //                if(Yii::app()->user->getState('ispostingotomatis'))
  //     //                {
  //     //                    $modJurnalPosting = new JurnalpostingT;
  //     //                    $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
  //     //                    $modJurnalPosting->keterangan = "Posting automatis";
  //     //                    $modJurnalPosting->create_time = date('Y-m-d H:i:s');
  //     //                    $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
  //     //                    $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
  //     //                    $modJurnalPosting->jurnaldetail_id = $modelJurnalDetail->jurnaldetail_id;
  //     //                    $modJurnalPosting->periodeposting_id = $modelJurnalDetail->jurnalposting_id;
  //     //
  //     //                    $periode = PeriodepostingM::model()->findByAttributes(array('rekperiode_id'=>$modJurnalRekening->rekperiod_id));
  //     //                    if (!empty($periode)) {
  //     //                        $modJurnalPosting->periodeposting_id = $periode->periodeposting_id;
  //     //                    }
  //     //
  //     //                    if($modJurnalPosting->validate()){
  //     //                        if($modJurnalPosting->save()){
  //     //                            JurnaldetailT::model()->updateByPk($modelJurnalDetail->jurnaldetail_id, array('jurnalposting_id'=>$modJurnalPosting->jurnalposting_id));
  //     //                        }
  //     //                    }
  //     //                }
  //   } else {
  //     //                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
  //     $valid = false;
  //   }

  //   return $valid;
  // }
}
