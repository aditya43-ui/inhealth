<?php
Yii::import('rawatJalan.controllers.PemakaianBahanController');
Yii::import('rawatJalan.models.*');
class PemakaianBahanTPIController extends PemakaianBahanController
{
}
// class PemakaianBahanTPIController extends MyAuthController
// {
//   protected $successSavePemakaianBahan = true;
//   public $obatalkespasientersimpan = true; //dilooping
//   public $stokobatalkestersimpan = true; //looping
//   public $successSaveBmhp = true;
//   public $succesSave = true;
//   public $pesan = "";

//   public function actionIndex($pendaftaran_id, $pasienadmisi_id)
//   {
//     $this->layout = '//layouts/iframe';
//     $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id)) : array();
//     $modPendaftaran = PIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
//     $modPasien = PIPasienM::model()->findByPk($modPendaftaran->pasien_id);

//     if (isset($_POST['pemakaianBahan']) || isset($_POST['paketBmhp'])) {
//       $transaction = Yii::app()->db->beginTransaction();
//       try {
//         if (isset($_POST['pemakaianBahan'])) {
//           if (count((array)$_POST['pemakaianBahan']) > 0) {
//             //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
//             $detailGroups = array();
//             foreach ($_POST['pemakaianBahan'] as $i => $postDetail) {
//               $modDetails[$i] = new PIObatalkespasienT;
//               $modDetails[$i]->attributes = $postDetail;
//               $modDetails[$i] = $this->simpanObatAlkesPasien2($modPendaftaran, $postDetail);
//               $this->simpanStokObatAlkesOut2($modDetails[$i]);

//               if (Yii::app()->user->getState('isjurnalotomatis') == true) {
//                 $JurObatAlkes = ObatalkesM::model()->findByPk($modDetails[$i]->obatalkes_id);

//                 if (isset($JurObatAlkes)) {
//                   $modJnsObatRek = JnsobatalkesrekM::model()->findAllByAttributes(array('jenisobatalkes_id' => $JurObatAlkes->jenisobatalkes_id, 'ispemakaianruangan' => true, 'ruangan_id' => Yii::app()->user->getState("ruangan_id")));

//                   if (count((array)$modJnsObatRek) > 0) {
//                     $modJurnalRekening = $this->saveJurnalRekening($modPendaftaran, $modDetails[$i]);

//                     foreach ($modJnsObatRek as $jnsObatRek) {
//                       $this->saveJurnalDetail($modJurnalRekening, $modDetails[$i], $jnsObatRek);
//                     }

//                     $this->obatalkespasientersimpan = true;
//                   }
//                 }
//               }
//               /*
// 							$modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
// 							$modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
// 							$obatalkes_id = $postDetail['obatalkes_id'];
// 							if (isset($detailGroups[$obatalkes_id])) {
// 								$detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
// 							} else {
// 								$detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
// 								$detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
// 							}
//                              *
//                              */
//             }
//             //END GROUP
//           }
//           /*
// 					$obathabis = "";
// 					//PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
// 					foreach ($detailGroups AS $i => $detail) {
// 						//						$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
// 						$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], $modAdmisi->ruangan_id);
// 						if (count((array)$modStokOAs) > 0) {
// 							foreach ($modStokOAs AS $i => $stok) {
// 								$modDetails[$i] = $this->simpanObatAlkesPasien($modPendaftaran, $stok, $_POST['pemakaianBahan']);
// 								$this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
// 							}
// 						} else {
// 							$this->stokobatalkestersimpan &= false;
// 							$obathabis .= "<br>- " . ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
// 						}
// 					}
//                      *
//                      */
//         }
//         /*
// 				if (isset($_POST['paketBmhp'])) { //RSSP-908
// 					if (count((array)$_POST['paketBmhp']) > 0) {
// 						//PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
// 						$detailGroups = array();
// 						foreach ($_POST['paketBmhp'] AS $j => $postDetail) {

// 							$modDetails[$i] = new RIObatalkespasienT;
// 							$modDetails[$i]->attributes = $postDetail;
// 							$modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
// 							$modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
// 							$obatalkes_id = $postDetail['obatalkes_id'];
// 							if (isset($detailGroups[$obatalkes_id])) {
// 								$detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qtypemakaian'];
// 							} else {
// 								$detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
// 								$detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qtypemakaian'];
// 							}
// 						}
// 						//END GROUP
// 					}

// 					$obathabis = "";
// 					//PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
// 					foreach ($detailGroups AS $i => $detail) {
// //                                $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
// 						$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], $modAdmisi->ruangan_id);
// 						if (count((array)$modStokOAs) > 0) {
// 							foreach ($modStokOAs AS $i => $stok) {
// 								$modDetails[$i] = $this->savePaketBmhp($modPendaftaran, $stok, $_POST['paketBmhp']);
// 								$this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
// 							}
// 						} else {
// 							$this->stokobatalkestersimpan &= false;
// 							$obathabis .= "<br>- " . ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
// 						}
// 					}
// 				}
//                  *
//                  */

//         if ($this->obatalkespasientersimpan && $this->stokobatalkestersimpan) { // && $this->successSaveBmhp) {
//           $transaction->commit();
//           Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
//           $this->refresh();
//         } else {
//           $transaction->rollback();
//           Yii::app()->user->setFlash('error', "Data pemakaian Bahan gagal disimpan !");
//         }
//       } catch (Exception $e) {
//         $transaction->rollback();
//         Yii::app()->user->setFlash('error', "Data pemakaian Bahan gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
//       }
//     }

//     $modViewBmhp = PIObatalkespasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

//     $this->render('index', array(
//       'modPendaftaran' => $modPendaftaran,
//       'modPasien' => $modPasien,
//       'modViewBmhp' => $modViewBmhp,
//       'modAdmisi' => $modAdmisi
//     ));
//   }

//   protected function savePemakaianBahan($modPendaftaran, $pemakaianBahan)
//   {
//     $valid = true;
//     foreach ($pemakaianBahan as $i => $bmhp) {
//       $modPakaiBahan[$i] = new PIObatalkespasienT;
//       $modPakaiBahan[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
//       $modPakaiBahan[$i]->penjamin_id = $modPendaftaran->penjamin_id;
//       $modPakaiBahan[$i]->carabayar_id = $modPendaftaran->carabayar_id;
//       $modPakaiBahan[$i]->daftartindakan_id = $bmhp['daftartindakan_id'];
//       $modPakaiBahan[$i]->sumberdana_id = $bmhp['sumberdana_id'];
//       $modPakaiBahan[$i]->pasien_id = $modPendaftaran->pasien_id;
//       $modPakaiBahan[$i]->satuankecil_id = $bmhp['satuankecil_id'];
//       //                $modPakaiBahan[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
//       $modPakaiBahan[$i]->ruangan_id = $this->getRuanganId();
//       $modPakaiBahan[$i]->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
//       $modPakaiBahan[$i]->obatalkes_id = $bmhp['obatalkes_id'];
//       $modPakaiBahan[$i]->pegawai_id = $modPendaftaran->pegawai_id;
//       $modPakaiBahan[$i]->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
//       $modPakaiBahan[$i]->shift_id = Yii::app()->user->getState('shift_id');
//       $modPakaiBahan[$i]->tglpelayanan = date('Y-m-d H:i:s');
//       $modPakaiBahan[$i]->qty_oa = $bmhp['qty'];
//       $modPakaiBahan[$i]->hargajual_oa = $bmhp['subtotal'];
//       $modPakaiBahan[$i]->harganetto_oa = $bmhp['harganetto'];
//       $modPakaiBahan[$i]->hargasatuan_oa = $bmhp['hargasatuan'];
//       $modPakaiBahan[$i]->pasienadmisi_id = isset($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pasienadmisi_id : (isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null);

//       $valid = $modPakaiBahan[$i]->validate() && $valid;
//       if ($valid) {
//         $modPakaiBahan[$i]->save();
//         $this->kurangiStok($modPakaiBahan[$i]->qty_oa, $modPakaiBahan[$i]->obatalkes_id);
//         $this->successSavePemakaianBahan = true;
//       } else {
//         $this->successSavePemakaianBahan = false;
//       }
//     }

//     return $modPakaiBahan;
//   }

//   private function traceObatAlkesPasien($modObatPasiens)
//   {
//     foreach ($modObatPasiens as $key => $modObatPasien) {
//       $echo .= "<pre>" . print_r($modObatPasien->attributes, 1) . "</pre>";
//     }
//     return $echo;
//   }

//   protected function kurangiStok($qty, $idobatAlkes)
//   {
//     $sql = "SELECT stokobatalkes_id,qtystok_in,qtystok_out FROM stokobatalkes_t WHERE obatalkes_id = $idobatAlkes ORDER BY tglstok_in";
//     $stoks = Yii::app()->db->createCommand($sql)->queryAll();
//     $selesai = false;
//     foreach ($stoks as $i => $stok) {
//       if ($qty <= $stok['qtystok_in'] - $stok['qtystok_out']) {
//         $stok_current = ($stok['qtystok_in'] - $stok['qtystok_out']) - $qty;
//         $stok_out = $stok['qtystok_out'] + $qty;
//         StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('qtystok_out' => $stok_out));
//         $selesai = true;
//         break;
//       } else {
//         $qty = $qty - ($stok['qtystok_in'] - $stok['qtystok_out']);
//         $stok_current = 0;
//         $stok_out = $stok['qtystok_out'] + ($stok['qtystok_in'] - $stok['qtystok_out']);
//         StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('stok_current' => $stok_current, 'qtystok_out' => $stok_out));
//       }
//     }
//   }

//   // protected function kembalikanStok($obatAlkesT)
//   // {
//   //     foreach ($obatAlkesT as $i => $obatAlkes) {
//   //         $stok = new PIStokObatalkesT;
//   //         $stok->obatalkes_id = $obatAlkes->obatalkes_id;
//   //         $stok->sumberdana_id = $obatAlkes->sumberdana_id;
//   //         $stok->ruangan_id = Yii::app()->user->getState('ruangan_id');
//   //         $stok->tglstok_in = date('Y-m-d H:i:s');
//   //         $stok->tglstok_out = date('Y-m-d H:i:s');
//   //         $stok->qtystok_in = $obatAlkes->qty_oa;
//   //         $stok->qtystok_out = 0;
//   //         $stok->harganetto_oa = $obatAlkes->harganetto_oa;
//   //         $stok->hargajual_oa = $obatAlkes->hargasatuan_oa;
//   //         $stok->discount = $obatAlkes->discount;
//   //         $stok->satuankecil_id = $obatAlkes->satuankecil_id;
//   //         $stok->save();
//   //     }
//   // }

//   protected function kembalikanStok($modObatAlkesPasien)
//   {
//     $format = new MyFormatter();
//     $stok = new StokobatalkesT;
//     $stok->attributes = $modObatAlkesPasien->attributes;
//     $modObatAlkes = ObatalkesM::model()->findByPk($modObatAlkesPasien->obatalkes_id); //sementara menggunakan harga terupdate
//     $stok->tglkadaluarsa = $format->formatDateTimeForDb($modObatAlkes->tglkadaluarsa);
//     $stok->harganetto = $modObatAlkes->harganetto;
//     $stok->persendiscount = $modObatAlkes->discount;
//     $stok->persenmargin = $modObatAlkes->margin;
//     $stok->satuankecil_id = $modObatAlkes->satuankecil_id;
//     $stok->jmlmargin = 0;
//     $stok->jmldiscount = 0;
//     $stok->persenppn = $modObatAlkes->ppn_persen;
//     $stok->persenpph = 0;
//     $stok->tglstok_in = date('Y-m-d H:i:s');
//     $stok->tglterima = date('Y-m-d H:i:s');
//     $stok->tglstok_out = null;
//     $stok->qtystok_in = $modObatAlkesPasien->qty_oa;
//     $stok->qtystok_out = 0;

//     $stok->create_time = date('Y-m-d H:i:s');
//     $stok->update_time = date('Y-m-d H:i:s');
//     $stok->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
//     //            $stok->create_ruangan = Yii::app()->user->getState('ruangan_id');
//     $stok->create_ruangan = $this->getRuanganId();

//     if ($stok->save())
//       return true;
//   }

//   public function actionHapusObatAlkesPasien()
//   {
//     if (Yii::app()->request->isAjaxRequest) {
//       $data['pesan'] = "";
//       $data['sukses'] = 0;
//       $transaction = Yii::app()->db->beginTransaction();
//       try {
//         $loadObatAlkesPasien = ObatalkespasienT::model()->findByPk($_POST['obatalkespasien_id']);
//         $kembalikanstok = $this->kembalikanStok($loadObatAlkesPasien);
//         if ($kembalikanstok) {
//           if ($loadObatAlkesPasien->delete()) {
//             $transaction->commit();
//             $data['pesan'] = "Obat / Alat Kesehatan berhasil dihapus!";
//             $data['sukses'] = 1;
//           } else {
//             $transaction->rollback();
//             $data['pesan'] = "Stok Obat / Alat Kesehatan gagal dikembalikan!";
//             $data['sukses'] = 0;
//           }
//         } else {
//           $transaction->rollback();
//           $data['pesan'] = "Obat / Alat Kesehatan gagal dihapus!";
//           $data['sukses'] = 0;
//         }
//       } catch (Exception $exc) {
//         $transaction->rollback();
//         $data['pesan'] = "Obat / Alat Kesehatan gagal dihapus! :" . MyExceptionMessage::getMessage($exc, true);
//       }
//       echo CJSON::encode($data);
//     }
//     Yii::app()->end();
//   }

//   public function actionPrint($pendaftaran_id)
//   {
//     $this->layout = '//layouts/printWindows';
//     $format = new MyFormatter;

//     $modPendaftaran = PIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
//     $modPasien = PIPasienM::model()->findByPk($modPendaftaran->pasien_id);
//     $modViewBmhp = PIObatalkespasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

//     $judul_print = 'Pemakaian Bahan ' . $modPasien->nama_pasien;
//     $this->render('print', array(
//       'format' => $format,
//       'judul_print' => $judul_print,
//       'modPendaftaran' => $modPendaftaran,
//       'modPasien' => $modPasien,
//       'modViewBmhp' => $modViewBmhp,
//     ));
//   }

//   public function actionAddFormPemakaianBahan()
//   {
//     if (Yii::app()->request->isAjaxRequest) {
//       $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
//       $idObatAlkes = (isset($_POST['idObatAlkes']) ? $_POST['idObatAlkes'] : null);
//       $idDaftartindakan = (isset($_POST['idDaftartindakan']) ? $_POST['idDaftartindakan'] : "");
//       $modObatAlkes = ObatalkesM::model()->findByPk($idObatAlkes);
//       $modDaftartindakan = DaftartindakanM::model()->findByPk($idDaftartindakan);
//       $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
//       $persenjual = $this->persenJualRuangan();
//       $modObatAlkes->hargajual = floor(($persenjual + 100) / 100 * $modObatAlkes->hargajual);

//       echo CJSON::encode(array(
//         'pendaftaran_id' => $pendaftaran_id,
//         'namaObat' => $modObatAlkes->obatalkes_nama,
//         'form' => $this->renderPartial('_formAddPemakaianBahan', array(
//           'modObatAlkes' => $modObatAlkes, 'modDaftartindakan' => $modDaftartindakan,
//           'modPendaftaran' => $modPendaftaran,
//         ), true),
//       ));
//       exit;
//     }
//   }

//   /**
//    * simpan PIObatalkespasienT
//    * @param type $modPendaftaran
//    * @param type $post
//    * @return \PIObatalkespasienT
//    */
//   public function simpanObatAlkesPasien($modPendaftaran, $stokOa, $postObatAlkesPasien)
//   {
//     $modObatAlkesPasien = new PIObatalkespasienT();
//     $modObatAlkesPasien->attributes = $stokOa->attributes;
//     $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
//     $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
//     //	   $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
//     $modObatAlkesPasien->ruangan_id = $this->getRuanganId();
//     $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
//     $modObatAlkesPasien->pasienadmisi_id = isset($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pasienadmisi_id : null;
//     $modObatAlkesPasien->pasienmasukpenunjang_id = null;
//     $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
//     $modObatAlkesPasien->carabayar_id = $modPendaftaran->carabayar_id;
//     $modObatAlkesPasien->penjamin_id = $modPendaftaran->penjamin_id;
//     $modObatAlkesPasien->pegawai_id = $modPendaftaran->pegawai_id;
//     $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
//     $modObatAlkesPasien->pasien_id = $modPendaftaran->pasien_id;
//     $modObatAlkesPasien->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
//     $modObatAlkesPasien->tglpelayanan = date('Y-m-d H:i:s');
//     $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
//     //	   $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
//     $modObatAlkesPasien->create_ruangan = $this->getRuanganId();
//     $modObatAlkesPasien->create_time = date('Y-m-d H:i:s');
//     $modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
//     $modObatAlkesPasien->qty_stok = $stokOa->qtystok;
//     $modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
//     $modObatAlkesPasien->hargasatuan_oa = $stokOa->getHargaJualSatuan($modObatAlkesPasien->penjamin_id);
//     $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
//     foreach ($postObatAlkesPasien as $i => $postDetail) {
//       if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
//         $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];
//         $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];
//         $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
//         $modObatAlkesPasien->iurbiaya = $postDetail['iurbiaya'];
//       }
//     }

//     if ($modObatAlkesPasien->save()) {
//       $this->obatalkespasientersimpan &= true;
//     } else {
//       $this->obatalkespasientersimpan &= false;
//     }
//     return $modObatAlkesPasien;
//   }

//   /**
//    * menampilkan obat
//    * @return row table
//    */
//   public function actionSetFormObatAlkesPasien()
//   {
//     if (Yii::app()->request->isAjaxRequest) {
//       $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
//       //			$daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : "");
//       $obatalkes_id = isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null;
//       $satuankecil_id = isset($_POST['satuankecil_id']) ? $_POST['satuankecil_id'] : null;
//       $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : 1;
//       $form = "";
//       $pesan = "";
//       $format = new MyFormatter();
//       $modObatAlkesPasien = new PIObatalkespasienT;
//       //			$modDaftartindakan = DaftartindakanM::model()->findByPk($daftartindakan_id);
//       $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
//       //			$ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
//       $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : $this->getRuanganId();
//       $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
//       $oa = ObatalkesM::model()->findByPk($obatalkes_id);

//       //if (count((array)$modStokOAs) > 0) {
//       //	foreach ($modStokOAs AS $i => $stok) {
//       $modObatAlkesPasien->sumberdana_id = $oa->sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
//       $modObatAlkesPasien->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
//       $modObatAlkesPasien->qty_oa = $jumlah; //$stok->qtystok_terpakai;
//       $modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stok->HPP;
//       $modObatAlkesPasien->hargasatuan_oa = $oa->hargajual; //$stok->HargaJualSatuan;
//       $modObatAlkesPasien->qty_stok = 0; //$stok->qtystok;
//       $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
//       $modObatAlkesPasien->stokobatalkes_id = null; //$stok->stokobatalkes_id;
//       $modObatAlkesPasien->biayaservice = 0;
//       $modObatAlkesPasien->biayakonseling = 0;
//       $modObatAlkesPasien->jasadokterresep = 0;
//       $modObatAlkesPasien->biayakemasan = 0;
//       $modObatAlkesPasien->biayaadministrasi = 0;
//       $modObatAlkesPasien->tarifcyto = 0;
//       $modObatAlkesPasien->discount = 0;
//       $modObatAlkesPasien->subsidiasuransi = 0;
//       $modObatAlkesPasien->subsidipemerintah = 0;
//       $modObatAlkesPasien->subsidirs = 0;
//       $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
//       $modObatAlkesPasien->qty_oa = number_format($jumlah, 2, ',', ''); //$stok->qtystok_terpakai;

//       $modObatAlkesPasien->satuankecil_id = $oa->satuankecil_id; //$stok->satuankecil_id;
//       $modObatAlkesPasien->satuankecil_nama = $oa->satuankecil->satuankecil_nama; //$stok->satuankecil->satuankecil_nama;
//       $modObatAlkesPasien->obatalkes_nama = $oa->obatalkes_nama; //$stok->obatalkes->obatalkes_nama;
//       $modObatAlkesPasien->ruangan_id = $ruangan_id;


//       $penjamin_id = $modPendaftaran->penjamin_id;
//       if (!empty($modPendaftaran->pasienadmisi_id)) {
//         $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
//         $penjamin_id = $modPasienAdmisi->penjamin_id;
//       }

//       $form .= $this->renderPartial('_formAddPemakaianBahan', array(
//         'modObatAlkesPasien' => $modObatAlkesPasien,
//         'modPendaftaran' => $modPendaftaran
//       ), true);
//       //	}
//       //} else {
//       //	$pesan = "Stok tidak mencukupi!";
//       //}

//       echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
//       Yii::app()->end();
//     }
//   }

//   /**
//    * simpan StokobatalkesT Jumlah Out
//    * @param type $stokobatalkesasal_id
//    * @param type $modObatAlkesPasien
//    * @return \StokobatalkesT
//    */
//   protected function simpanStokObatAlkesOut($stokobatalkesasal_id, $modObatAlkesPasien)
//   {
//     $format = new MyFormatter;
//     $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
//     $modStokOaNew = new StokobatalkesT;
//     $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
//     $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
//     $modStokOaNew->qtystok_in = 0;
//     $modStokOaNew->qtystok_out = $modObatAlkesPasien->qty_oa;
//     $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
//     $modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
//     $modStokOaNew->tglstok_in = null;
//     $modStokOaNew->tglstok_out = date('Y-m-d H:i:s');
//     $modStokOaNew->create_time = date('Y-m-d H:i:s');
//     $modStokOaNew->update_time = date('Y-m-d H:i:s');
//     $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
//     $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
//     //	   $modStokOaNew->create_ruangan = Yii::app()->user->getState('ruangan_id');
//     $modStokOaNew->create_ruangan = $this->getRuanganId();

//     if ($modStokOaNew->validateStok()) {
//       $modStokOaNew->save();
//       $modStokOaNew->setStokOaAktifBerdasarkanStok();
//     } else {
//       $this->stokobatalkestersimpan &= false;
//     }
//     return $modStokOaNew;
//   }

//   /**
//    * untuk form tambah obat alkes
//    * di copy dari laboratorium/pemakaianBmhpController
//    */
//   public function actionAutocompleteObatAlkes()
//   {
//     if (Yii::app()->request->isAjaxRequest) {
//       $criteria = new CDbCriteria();
//       $criteria->join = "JOIN sumberdana_m ON sumberdana_m.sumberdana_id = t.sumberdana_id
// 						   JOIN satuankecil_m ON satuankecil_m.satuankecil_id = t.satuankecil_id
// 						   LEFT JOIN jenisobatalkes_m ON jenisobatalkes_m.jenisobatalkes_id = t.jenisobatalkes_id
// 						   ";
//       $criteria->compare('LOWER(t.obatalkes_nama)', strtolower($_GET['term']), true);
//       $criteria->addCondition('obatalkes_farmasi = TRUE');
//       $criteria->addCondition('obatalkes_aktif = true');
//       $criteria->compare('t.jenisobatalkes_id', Params::JENISOBATALKES_ID_BHP);
//       $criteria->limit = 5;
//       $models = ObatalkesM::model()->findAll($criteria);
//       $format = new MyFormatter();
//       foreach ($models as $i => $model) {
//         $attributes = $model->attributeNames();

//         foreach ($attributes as $j => $attribute) {
//           $returnVal[$i]["$attribute"] = $model->$attribute;
//         }
//         //			   $qty_stok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
//         $qty_stok = StokobatalkesT::getJumlahStok($model->obatalkes_id, $this->getRuanganId());
//         $returnVal[$i]['label'] = $model->obatalkes_kode . " - " . $model->obatalkes_nama . " - Jumlah Stok " . $qty_stok;
//         $returnVal[$i]['value'] = $model->obatalkes_nama;
//         $returnVal[$i]['qty_stok'] = $qty_stok;
//         $returnVal[$i]['satuankecil_nama'] = $model->satuankecil->satuankecil_nama;
//       }
//       echo CJSON::encode($returnVal);
//     }
//     Yii::app()->end();
//   }

//   public function actionSetSatuanObat()
//   {
//     if (Yii::app()->request->isAjaxRequest) {
//       $obatalkes_id = isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null;
//       $form = "";
//       $pesan = "";
//       $satuankecil_nama = "";
//       $satuanterkecil_nama = "";
//       $format = new MyFormatter();
//       $modObatAlkes = ObatalkesM::model()->findByPk($obatalkes_id);

//       if (!empty($modObatAlkes)) {
//         $satuankecil_nama = isset($modObatAlkes->satuankecil_id) ? $modObatAlkes->satuankecil->satuankecil_nama : null;
//         $satuanterkecil_nama = isset($modObatAlkes->satuankecil_id) ? $modObatAlkes->satuankecil->satuankecil_nama : null;
//       } else {
//         $pesan = "Obat tidak mencukupi!";
//       }

//       echo CJSON::encode(array(
//         'form' => $form, 'pesan' => $pesan,
//         'satuankecil' => $satuankecil_nama,
//         'satuanterkecil' => $satuanterkecil_nama
//       ));
//       Yii::app()->end();
//     }
//   }

//   public function getRuanganId()
//   {
//     $ruangan_id = null;
//     if (isset($_GET['pasienadmisi_id'])) {
//       $modAdmisi = PasienadmisiT::model()->findByPk($_GET['pasienadmisi_id']);
//       $ruangan_id = $modAdmisi->ruangan_id;
//     } else {
//       $ruangan_id = Yii::app()->user->getState('ruangan_id');
//     }
//     return $ruangan_id;
//   }

//   public function savePaketBmhp($modPendaftaran, $stokOa, $postPaketBmhp)
//   {
//     $valid = true;
//     $format = new MyFormatter;
//     $modObatPasien = new RIObatalkespasienT;
//     $modObatPasien->attributes = $stokOa->attributes;
//     $modObatPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
//     $modObatPasien->penjamin_id = $modPendaftaran->penjamin_id;
//     $modObatPasien->carabayar_id = $modPendaftaran->carabayar_id;
//     $modObatPasien->pasien_id = $modPendaftaran->pasien_id;
//     //            $modObatPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
//     $modObatPasien->ruangan_id = $this->getRuanganId();
//     $modObatPasien->pegawai_id = $modPendaftaran->pegawai_id;
//     $modObatPasien->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
//     $modObatPasien->shift_id = Yii::app()->user->getState('shift_id');
//     $modObatPasien->tglpelayanan = date('Y-m-d H:i:s');
//     $modObatPasien->qty_oa = $stokOa->qtystok_terpakai;
//     $modObatPasien->harganetto_oa = $stokOa->HPP;
//     $modObatPasien->hargasatuan_oa = $stokOa->getHargaJualSatuan($modObatPasien->penjamin_id);
//     $modObatPasien->hargajual_oa = $modObatPasien->hargasatuan_oa * $modObatPasien->qty_oa;
//     $modObatPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;

//     foreach ($postPaketBmhp as $i => $postDetail) {
//       if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
//         $modObatPasien->daftartindakan_id = $postDetail['daftartindakan_id'];
//         $modObatPasien->sumberdana_id = $postDetail['sumberdana_id'];
//         $modObatPasien->satuankecil_id = $postDetail['satuankecil_id'];
//         $modObatPasien->obatalkes_id = $postDetail['obatalkes_id'];
//       }
//     }

//     $valid = $modObatPasien->validate() && $valid;
//     if ($valid) {
//       $modObatPasien->save();
//       $this->successSaveBmhp &= true;
//     } else {
//       $this->successSaveBmhp &= false;
//     }

//     return $modObatPasien;
//   }


//   /**
//    * simpan RJObatalkesPasienT
//    * @param type $modPendaftaran
//    * @param type $post
//    * @return \RJObatalkesPasienT
//    */
//   public function simpanObatAlkesPasien2($modPendaftaran, $postObatAlkesPasien)
//   {
//     $modObatAlkesPasien = new PIObatalkespasienT();
//     $modObatAlkesPasien->attributes = $postObatAlkesPasien;
//     $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
//     $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
//     $modObatAlkesPasien->ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
//     $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
//     $modObatAlkesPasien->pasienmasukpenunjang_id = null;
//     $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
//     $modObatAlkesPasien->carabayar_id = $modPendaftaran->carabayar_id;
//     $modObatAlkesPasien->penjamin_id = $modPendaftaran->penjamin_id;
//     $modObatAlkesPasien->pegawai_id = $modPendaftaran->pegawai_id;
//     $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
//     $modObatAlkesPasien->pasien_id = $modPendaftaran->pasien_id;
//     $modObatAlkesPasien->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
//     $modObatAlkesPasien->tglpelayanan = date('Y-m-d H:i:s');
//     $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
//     $modObatAlkesPasien->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
//     $modObatAlkesPasien->create_time = date('Y-m-d H:i:s');



//     //var_dump($postObatAlkesPasien);
//     // var_dump($modObatAlkesPasien->attributes);

//     //die;

//     //$modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
//     //$modObatAlkesPasien->qty_stok = $stokOa->qtystok;
//     //$modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
//     //$modObatAlkesPasien->hargasatuan_oa = $stokOa->HargaJualSatuan;
//     //$modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
//     $modObatAlkesPasien->oa = Params::OBATALKESPASIEN_BMHP;
//     //foreach ($postObatAlkesPasien AS $i => $postDetail) {
//     //   if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
//     //	   $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];
//     //	   $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];
//     //	   $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
//     //	   $modObatAlkesPasien->iurbiaya = $postDetail['iurbiaya'];
//     //   }
//     //}

//     //var_dump($modObatAlkesPasien->validate());
//     //var_dump($modObatAlkesPasien->errors);

//     //die;

//     // var_dump($modObatAlkesPasien->attributes); die;

//     if ($modObatAlkesPasien->save()) {
//       $this->obatalkespasientersimpan &= true;
//     } else {
//       $this->obatalkespasientersimpan &= false;
//     }
//     return $modObatAlkesPasien;
//   }

//   protected function simpanStokObatAlkesOut2($modObatAlkesPasien)
//   {
//     $format = new MyFormatter;
//     //$modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
//     $oa = ObatalkesM::model()->findByPk($modObatAlkesPasien->obatalkes_id);
//     // var_dump($modObatAlkesPasien->attributes);
//     $modStokOaNew = new StokobatalkesT;
//     $modStokOaNew->attributes = $oa->attributes;
//     $modStokOaNew->attributes = $modObatAlkesPasien->attributes; //duplicate
//     //$modStokOaNew->unsetIdTransaksi();
//     $modStokOaNew->qtystok_in = 0;
//     $modStokOaNew->qtystok_out = ceil($modObatAlkesPasien->qty_oa); // LNG Ceil (Pembulatan keatas request pak tito)
//     $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
//     //$modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
//     $modStokOaNew->create_time = date('Y-m-d H:i:s');
//     $modStokOaNew->update_time = $modStokOaNew->tglterima = date('Y-m-d H:i:s');
//     $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
//     $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
//     $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

//     //$modStokOaNew->validate();
//     //var_dump($modStokOaNew->errors);

//     //var_dump($modStokOaNew->attributes); die;

//     if ($modStokOaNew->validate()) {
//       $this->stokobatalkestersimpan &= $modStokOaNew->save();
//       // $modStokOaNew->setStokOaAktifBerdasarkanStok();
//     } else {
//       $this->stokobatalkestersimpan &= false;
//     }

//     // var_dump($this->stokobatalkestersimpan);

//     return $modStokOaNew;
//   }

//   protected function saveJurnalRekening($model, $dtDetail)
//   {

//     $format = new MyFormatter();
//     $modJurnalRekening = new JurnalrekeningT;
//     $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PERSEDIAAN;
//     $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tgl_pendaftaran);
//     $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
//     $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
//     $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
//     $modJurnalRekening->noreferensi = $model->no_pendaftaran;
//     $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tgl_pendaftaran);
//     $modJurnalRekening->nobku = "";
//     $ruangan_nama = "";
//     $modRuangan = RuanganM::model()->findByPk($model->ruangan_id);

//     if (isset($modRuangan)) {
//       $ruangan_nama = $modRuangan->ruangan_nama;
//     }
//     $oa = ObatalkesM::model()->findByPk($dtDetail->obatalkes_id);
//     $modJurnalRekening->urianjurnal = 'Pemakaian Bahan ' . $oa->obatalkes_nama . " Ruangan " . $ruangan_nama . " - " . $model->no_pendaftaran;

//     $periodeID = $modJurnalRekening->currentPeriod;
//     $modJurnalRekening->rekperiod_id = $periodeID;
//     $modJurnalRekening->create_time = date('Y-m-d H:i:s');
//     $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
//     $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
//     $modJurnalRekening->ruangan_id = $model->create_ruangan;
//     $modJurnalRekening->obatalkespasien_id = $dtDetail->obatalkespasien_id;

//     if ($modJurnalRekening->validate()) {
//       $modJurnalRekening->save();
//       $this->succesSave = true;
//     } else {
//       $this->succesSave = false;
//       $this->pesan = $modJurnalRekening->getErrors();
//     }
//     return $modJurnalRekening;
//   }

//   public function saveJurnalDetail($modJurnalRekening, $postRekenings, $modelRek)
//   {
//     $valid = true;
//     $modJurnalPosting = null;
//     $modObatAlkes = ObatalkesM::model()->findByPk($postRekenings->obatalkes_id);

//     // $rekening5 = Rekening5M::model()->findByPk($modelRek->rekening5_id);
//     // $rekening4 = Rekening4M::model()->findByPk($rekening5->rekening4_id);
//     // $rekening3 = Rekening3M::model()->findByPk($rekening4->rekening3_id);
//     // $rekening2 = Rekening2M::model()->findByPk($rekening3->rekening2_id);

//     $modelJurnalDetail = new JurnaldetailT();

//     $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
//     $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
//     $modelJurnalDetail->rekening5_id = $modelRek->rekening5_id;
//     // $modelJurnalDetail->rekening1_id = $rekening2->rekening1_id;
//     // $modelJurnalDetail->rekening2_id = $rekening2->rekening2_id;
//     // $modelJurnalDetail->rekening3_id = $rekening3->rekening3_id;
//     // $modelJurnalDetail->rekening4_id = $rekening4->rekening4_id;
//     $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;

//     $totalHasilQty = ($modObatAlkes->hpp * $postRekenings->qty_oa);

//     if ($modelRek->debitkredit == 'K') {
//       $modelJurnalDetail->nourut = 2;
//       $modelJurnalDetail->saldokredit = $totalHasilQty;
//       $modelJurnalDetail->saldodebit = 0;
//     } else if ($modelRek->debitkredit == 'D') {
//       $modelJurnalDetail->nourut = 1;
//       $modelJurnalDetail->saldodebit = $totalHasilQty;
//       $modelJurnalDetail->saldokredit = 0;
//     }

//     if ($modelJurnalDetail->validate()) {
//       $modelJurnalDetail->save();

//       //                if(Yii::app()->user->getState('ispostingotomatis'))
//       //                {
//       //                    $modJurnalPosting = new JurnalpostingT;
//       //                    $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
//       //                    $modJurnalPosting->keterangan = "Posting automatis";
//       //                    $modJurnalPosting->create_time = date('Y-m-d H:i:s');
//       //                    $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
//       //                    $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
//       //                    $modJurnalPosting->jurnaldetail_id = $modelJurnalDetail->jurnaldetail_id;
//       //                    $modJurnalPosting->periodeposting_id = $modelJurnalDetail->jurnalposting_id;
//       //
//       //                    $periode = PeriodepostingM::model()->findByAttributes(array('rekperiode_id'=>$modJurnalRekening->rekperiod_id));
//       //                    if (!empty($periode)) {
//       //                        $modJurnalPosting->periodeposting_id = $periode->periodeposting_id;
//       //                    }
//       //
//       //                    if($modJurnalPosting->validate()){
//       //                        if($modJurnalPosting->save()){
//       //                            JurnaldetailT::model()->updateByPk($modelJurnalDetail->jurnaldetail_id, array('jurnalposting_id'=>$modJurnalPosting->jurnalposting_id));
//       //                        }
//       //                    }
//       //                }
//     } else {
//       //                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
//       $valid = false;
//     }

//     return $valid;
//   }
// }
