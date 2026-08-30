<?php
Yii::import('rawatJalan.controllers.PemakaianBahanRJController');
Yii::import('rawatJalan.models.*');
// Yii::import('laboratorium.models.LBObatalkespasienT');
// Yii::import('laboratorium.models.LBObatalkesM');
// Yii::import('laboratorium.models.LBHasilPemeriksaanLabT');
// Yii::import('laboratorium.models.LBPasienmasukpenunjangT');
// Yii::import('laboratorium.models.LBPasienMasukPenunjangV');
// Yii::import('gudangFarmasi.models.GFInformasistokobatalkesV');
class PemakaianBahanRDController extends PemakaianBahanRJController
{
  // public $path_view = "rawatDarurat.views.pemakaianBahanRD.";
  // public $path_view_bmhp = "laboratorium.views.pemakaianBmhp.";
  // public $path_view_bahan = "laboratorium.views.pemakaianBmhp.";
  // public $succesSave = true;
  // public $pesan = "";

  // // dicopy dari laboratorium.controller.pemakaianBmhp
  // public function actionIndex($pendaftaran_id = null)
  // {
  //   $this->pageTitle = Yii::app()->name . " - Pemakaian Bahan";
  //   $format = new MyFormatter();
  //   $modKunjungan = new RDInfoKunjunganRDV;
  //   $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
  //   $modObatAlkesPasien = new LBObatalkespasienT;
  //   $dataOas = array();

  //   if (!empty($pendaftaran_id)) {
  //     $modKunjungan = RDInfoKunjunganRDV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
  //   }

  //   if (isset($_POST['LBObatalkespasienT'])) {
  //     if (isset($_POST['pendaftaran_id'])) {
  //       $modPendaftaran = RDPendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
  //       $transaction = Yii::app()->db->beginTransaction();
  //       try {
  //         if (count((array)$_POST['LBObatalkespasienT']) > 0) {
  //           //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
  //           $detailGroups = array();
  //           foreach ($_POST['LBObatalkespasienT'] as $i => $postDetail) {
  //             $modDetails[$i] = new LBObatalkespasienT;
  //             $modDetails[$i]->attributes = $postDetail;

  //             $modDetails[$i] = $this->simpanObatAlkesPasien2($modPendaftaran, $modDetails[$i]);
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
  //           }
  //           //END GROUP
  //         }

  //         $this->notifPemakaianBahan($modPendaftaran, $modDetails);

  //         if ($this->obatalkespasientersimpan && $this->stokobatalkestersimpan) {
  //           $transaction->commit();
  //           $this->redirect(array('index', 'pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'sukses' => 1));
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

  // public function notifPemakaianBahan($modPendaftaran, $modDetails)
  // {
  //   if (count((array)$modDetails) == 0) {
  //     return;
  //   }

  //   $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
  //   $pasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

  //   $judul = "Pemakaian Bahan Pasien";
  //   $isi = "Pasien : " . $modPendaftaran->no_pendaftaran . " - " . $pasien->no_rekam_medik . " - " . $pasien->nama_pasien . "<br/>"
  //     . "Tgl. Transaksi : " . MyFormatter::formatDateTimeForUser($modDetails[0]->tglpelayanan) . "<br/>"
  //     . "<ul>";
  //   foreach ($modDetails as $item) {
  //     $oa = ObatalkesM::model()->findByPk($item->obatalkes_id);
  //     $isi .= "<li>" . $oa->obatalkes_nama . " (" . $item->qty_oa . ")</li>";
  //   }
  //   $isi .= "</ul>";

  //   $ok = CustomFunction::broadcastNotif($judul, $isi, array(
  //     array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
  //   ));
  // }

  // /**
  //  * simpan RDObatalkesPasienT
  //  * @param type $modPendaftaran
  //  * @param type $post
  //  * @return \RDObatalkesPasienT
  //  */
  // public function simpanObatAlkesPasien2($modPendaftaran, $postObatAlkesPasien)
  // {
  //   $oa = ObatalkesM::model()->findByPk($postObatAlkesPasien->obatalkes_id);
  //   $modObatAlkesPasien = new RDObatalkesPasienT();
  //   $modObatAlkesPasien->attributes = $postObatAlkesPasien->attributes;
  //   $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
  //   $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
  //   $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
  //   $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
  //   $modObatAlkesPasien->pasienmasukpenunjang_id = null;
  //   $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
  //   $modObatAlkesPasien->carabayar_id = $modPendaftaran->carabayar_id;
  //   $modObatAlkesPasien->penjamin_id = $modPendaftaran->penjamin_id;
  //   $modObatAlkesPasien->pegawai_id = $modPendaftaran->pegawai_id;
  //   $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
  //   $modObatAlkesPasien->pasien_id = $modPendaftaran->pasien_id;
  //   $modObatAlkesPasien->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
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
  //   // foreach ($postObatAlkesPasien AS $i => $postDetail) {
  //   // if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
  //   //    $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];
  //   //    $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];
  //   //    $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
  //   //    $modObatAlkesPasien->iurbiaya = $postDetail['iurbiaya'];
  //   //}
  //   // }
  //   //var_dump($modObatAlkesPasien->attributes);
  //   //var_dump($modObatAlkesPasien->validate());
  //   //var_dump($modObatAlkesPasien->errors);
  //   //die;

  //   if ($modObatAlkesPasien->save()) {
  //     $this->obatalkespasientersimpan &= true;
  //   } else {
  //     $this->obatalkespasientersimpan &= false;
  //   }
  //   return $modObatAlkesPasien;
  // }

  // /**
  //  * simpan RDObatalkesPasienT
  //  * @param type $modPendaftaran
  //  * @param type $post
  //  * @return \RDObatalkesPasienT
  //  */
  // public function simpanObatAlkesPasien($modPendaftaran, $stokOa, $postObatAlkesPasien)
  // {
  //   $modObatAlkesPasien = new RDObatalkesPasienT();
  //   $modObatAlkesPasien->attributes = $stokOa->attributes;
  //   $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
  //   $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
  //   $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
  //   $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
  //   $modObatAlkesPasien->pasienmasukpenunjang_id = null;
  //   $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
  //   $modObatAlkesPasien->carabayar_id = $modPendaftaran->carabayar_id;
  //   $modObatAlkesPasien->penjamin_id = $modPendaftaran->penjamin_id;
  //   $modObatAlkesPasien->pegawai_id = $modPendaftaran->pegawai_id;
  //   $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
  //   $modObatAlkesPasien->pasien_id = $modPendaftaran->pasien_id;
  //   $modObatAlkesPasien->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
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
  //  * - pendaftaran_id
  //  * @throws CHttpException
  //  */
  // public function actionGetDataKunjungan()
  // {
  //   if (Yii::app()->request->isAjaxRequest) {
  //     $format = new MyFormatter();
  //     $returnVal = array();
  //     $returnVal['pesan'] = "";
  //     $criteria = new CDbCriteria();
  //     $model = $this->loadModPasienRawatJalan($_POST['pendaftaran_id']);
  //     if (isset($model)) {
  //       $loadHasilPemeriksaan = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
  //       if (isset($loadHasilPemeriksaan)) {
  //         if (strtolower(trim($loadHasilPemeriksaan->statusperiksahasil)) == strtolower(Params::STATUSPERIKSAHASIL_SUDAH)) {
  //           $returnVal['pesan'] = "Pasien dengan status sudah diperiksa tidak bisa menggunakan obat / alat kesehatan !";
  //         }
  //       }
  //     }

  //     $attributes = $model->attributeNames();
  //     foreach ($attributes as $j => $attribute) {
  //       $returnVal["$attribute"] = $model->$attribute;
  //     }
  //     $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
  //     $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
  //     echo CJSON::encode($returnVal);
  //   }
  //   Yii::app()->end();
  // }

  // /**
  //  * @param type $pendaftaran_id
  //  * @return RDInfoKunjunganRDV
  //  */
  // public function loadModPasienRawatJalan($pendaftaran_id)
  // {
  //   $criteria = new CDbCriteria;
  //   $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
  //   $model = RDInfoKunjunganRDV::model()->find($criteria);
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
  //     $loadOaPasiens = RDObatalkesPasienT::model()->findAllByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id']));
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

  // public function actionPrint($pendaftaran_id)
  // {
  //   $this->layout = '//layouts/printWindows';
  //   $format = new MyFormatter;
  //   $modPendaftaran = RDInfoKunjunganRDV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
  //   $modObatAlkesPasien = RDObatalkesPasienT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

  //   $judul_print = 'Pemakaian Bahan ' . $modPendaftaran->ruangan_nama;
  //   $this->render($this->path_view . 'printPemakaianBahan', array(
  //     'format' => $format,
  //     'judul_print' => $judul_print,
  //     'modPendaftaran' => $modPendaftaran,
  //     'modObatAlkesPasien' => $modObatAlkesPasien,
  //   ));
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
