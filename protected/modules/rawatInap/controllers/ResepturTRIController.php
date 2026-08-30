<?php
Yii::import('rawatJalan.controllers.ResepturController');
Yii::import('rawatJalan.models.*');
class ResepturTRIController extends ResepturController
{

}
// class ResepturTRIController extends MyAuthController
// {
//   public $layout = '//layouts/column1';
//   protected $successSave = false;
//   public $reseptur_id;

//   public function actionIndex($pendaftaran_id = null, $pasienadmisi_id = null)
//   {
//     $this->layout = '//layouts/iframe';
//     $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id)) : array();
//     $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
//     $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);

//     $modReseptur = new RIResepturT;
//     $instalasi_id = Yii::app()->user->getState('instalasi_id');
//     $modReseptur->noresep = MyGenerator::noResepReseptur();
//     $modReseptur->pegawai_id = (!empty($pasienadmisi_id)) ? $modAdmisi->pegawai_id : $modPendaftaran->pegawai_id;
//     $modReseptur->ruanganreseptur_id = Yii::app()->user->getState('ruangan_id');
//     $modReseptur->ruangan_id = Params::RUANGAN_ID_APOTEK_1;

//     if (isset($_GET['reseptur_id'])) {
//       $modReseptur = RIResepturT::model()->findByPk($_GET['reseptur_id']);
//       $modResepturDetail = RIResepturDetailT::model()->findAllByAttributes(array('reseptur_id' => $_GET['reseptur_id']));
//     }

//     $nama_modul = Yii::app()->controller->module->id;
//     $nama_controller = Yii::app()->controller->id;
//     $nama_action = Yii::app()->controller->action->id;
//     $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
//     $criteria = new CDbCriteria;
//     $criteria->compare('modul_id', $modul_id);
//     $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
//     $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
//     if (isset($_POST['tujuansms'])) {
//       $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
//     }
//     $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

//     if (isset($_POST['RIResepturT'])) {

//       $transaction = Yii::app()->db->beginTransaction();
//       try {
//         $this->saveReseptur($_POST, $modPendaftaran);

//         $this->broadcastNotifReseptur($modPendaftaran);

//         if ($this->successSave) {

//           // SMS GATEWAY
//           $modPegawai = $modPendaftaran->pegawai;
//           $modRuangan = $modReseptur->ruanganreseptur;
//           $sms = new Sms();
//           $smspasien = 1;
//           foreach ($modSmsgateway as $i => $smsgateway) {
//             $isiPesan = $smsgateway->templatesms;

//             $attributes = $modPegawai->getAttributes();
//             foreach ($attributes as $attributes => $value) {
//               $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
//             }
//             $attributes = $modReseptur->getAttributes();
//             foreach ($attributes as $attributes => $value) {
//               $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
//             }
//             $attributes = $modRuangan->getAttributes();
//             foreach ($attributes as $attributes => $value) {
//               $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
//             }
//             $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modReseptur->tglreseptur), $isiPesan);

//             if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
//               if (!empty($modPasien->no_mobile_pasien)) {
//                 $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
//               } else {
//                 $smspasien = 0;
//               }
//             }
//           }
//           // END SMS GATEWAY

//           $transaction->commit();
//           Yii::app()->user->setFlash('success', "Data Resep berhasil disimpan");
//           $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'reseptur_id' => $this->reseptur_id, 'sukses' => 1, 'smspasien' => $smspasien));
//         } else {
//           $transaction->rollback();
//           Yii::app()->user->setFlash('error', "Data gagal disimpan ");
//         }
//       } catch (Exception $exc) {
//         $transaction->rollback();
//         Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
//         //echo '<pre>'.print_r($_POST,1).'</pre>';
//       }
//     }
//     $modRiwayatResep = RIResepturT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'ruanganreseptur_id' => Yii::app()->user->getState('ruangan_id')), array('order' => 't.create_time DESC'));

//     $modBayarUangMuka = RIBayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
//     $total = 0;
//     foreach ($modBayarUangMuka as $key => $value) {
//       $total += $modBayarUangMuka[$key]->jumlahuangmuka;
//     }
//     $modDeposit = (($modBayarUangMuka) ? $total : null);

//     $this->render('index', array(
//       'modPendaftaran' => $modPendaftaran,
//       'modPasien' => $modPasien,
//       'modReseptur' => $modReseptur,
//       'modAdmisi' => $modAdmisi,
//       'modRiwayatResep' => $modRiwayatResep,
//       'modDeposit' => $modDeposit
//     ));
//   }

//   protected function broadcastNotifReseptur($modPendaftaran)
//   {
//     $reseptur = ResepturT::model()->findByPk($this->reseptur_id);

//     //var_dump($modPendaftaran->attributes);
//     //var_dump($reseptur->attributes);

//     $rr = RuanganM::model()->findByPk($reseptur->ruanganreseptur_id);
//     $dokter = PegawaiM::model()->findByPk($reseptur->pegawai_id);
//     $pasien = PasienM::model()->findByPk($reseptur->pasien_id);

//     //var_dump($rr->attributes);

//     $judul = "Reseptur Pasien";
//     $isi = $reseptur->noresep . " - " . $rr->ruangan_nama . " - " . $dokter->namaLengkap . " - " .
//       $pasien->no_rekam_medik . " - " . $pasien->namadepan . $pasien->nama_pasien;

//     //var_dump($isi);
//     $link = $this->createUrl('/farmasiApotek/InformasiPasienResep/Index', array(
//       'FAInformasiresepturV[tgl_awal]' => date('Y-m-d', strtotime($reseptur->tglreseptur)),
//       'FAInformasiresepturV[tgl_akhir]' => date('Y-m-d', strtotime($reseptur->tglreseptur)),
//       'FAInformasiresepturV[noreseptur]' => $reseptur->noresep,
//       'FAInformasiresepturV[no_rekam_medik]' => $reseptur->pasien->no_rekam_medik,
//       'FAInformasiresepturV[nama_pasien]' => $reseptur->pasien->nama_pasien
//     ));

//     $ok = CustomFunction::broadcastNotif($judul, $isi, array(
//       array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => $reseptur->ruangan_id, 'modul_id' => 10, 'link_proses' => $link),
//     ));
//   }

//   protected function saveReseptur($post, $modPendaftaran)
//   {
//     $reseptur = new RIResepturT;
//     $reseptur->pendaftaran_id = $modPendaftaran->pendaftaran_id;
//     $reseptur->tglreseptur = $post['RIResepturT']['tglreseptur'];
//     $instalasi_id = Yii::app()->user->getState('instalasi_id');
//     $reseptur->noresep = MyGenerator::noResepReseptur();
//     $reseptur->pegawai_id = $post['RIResepturT']['pegawai_id'];
//     $reseptur->ruangan_id = $post['RIResepturT']['ruangan_id'];
//     $reseptur->ruanganreseptur_id = Yii::app()->user->getState('ruangan_id');
//     $reseptur->pasien_id = $modPendaftaran->pasien_id;
//     $reseptur->pasienadmisi_id = $_GET['pasienadmisi_id'];

//     // var_dump($reseptur->validate());
//     // var_dump($reseptur->errors);
//     // var_dump($this->successSave);

//     if ($reseptur->validate()) {
//       $reseptur->save();
//       $this->saveDetailReseptur($post, $reseptur);
//     } else {
//       $this->successSave = false;
//     }

//     // var_dump($this->successSave); die;
//   }

//   protected function saveDetailReseptur($post, $reseptur)
//   {
//     $valid = true;
//     foreach ($post['RIResepturDetailT'] as $i => $detailreseptur) {
//       $detail = new RIResepturDetailT;
//       $detail->reseptur_id = $reseptur->reseptur_id;
//       $detail->attributes = $detailreseptur;

//       $detail->qty_reseptur = MyFormatter::formatRupiahForDb($detail->qty_reseptur);

//       //$detail->hargasatuan_reseptur = $detail->getHargaSatuanBerdasarkanInstalasi($reseptur->ruanganreseptur_id);

//       $detail->harganetto_reseptur = MyFormatter::formatRupiahForDb($detail->harganetto_reseptur);
//       $detail->persenppnjual = MyFormatter::formatRupiahForDb($detail->persenppnjual);
//       $detail->jumlahppn = MyFormatter::formatRupiahForDb($detail->jumlahppn);
//       $detail->hargasatuan_reseptur = MyFormatter::formatRupiahForDb($detail->hargasatuan_reseptur);
//       // $detail->hargajual_reseptur = $detail->hargasatuan_reseptur * $detail->qty_reseptur;
//       $detail->hargajual_reseptur = round(($detail->hargasatuan_reseptur * $detail->qty_reseptur) + $detail->jumlahppn);
//       //$detail->hargajual_reseptur = str_replace(",", "", $detail->hargajual_reseptur);


//       $detail->signa_reseptur = $detailreseptur['signa_reseptur'];
//       $detail->iter = $detailreseptur['iter'];
//       $detail->satuansediaan = $detailreseptur['satuansediaan'];

//       if (!empty($detail->permintaan_reseptur)) {
//         $detail->permintaan_reseptur = MyFormatter::formatRupiahForDB($detail->permintaan_reseptur);
//       }
//       if (!empty($detail->kekuatan_reseptur)) {
//         $detail->kekuatan_reseptur = MyFormatter::formatRupiahForDB($detail->kekuatan_reseptur);
//       }
//       if (!empty($detail->jmlkemasan_reseptur)) {
//         $detail->jmlkemasan_reseptur = MyFormatter::formatRupiahForDB($detail->jmlkemasan_reseptur);
//       }

//       $this->reseptur_id = $reseptur->reseptur_id;
//       $valid = $detail->validate() && $valid;


//       if ($valid) {
//         $valid = $valid && $detail->save();
//       }

//       // var_dump($detail->attributes, $detail->errors);
//     }
//     $this->successSave = ($valid) ? true : false;



//     // var_dump($this->successSave); die;
//   }

//   /**
//    * method to get obat reseptur
//    * used in :
//    * 1. rawatInap/resepturTRI
//    */
//   public function actionObatReseptur()
//   {
//     if (Yii::app()->request->isAjaxRequest) {
//       $criteria = new CDbCriteria();
//       $criteria2 = new CDbCriteria;
//       $criteria2->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
//       $modObat = ObatalkesM::model()->find($criteria2);
//       if (isset($modObat)) {
//         $generik_id = $modObat->generik_id;
//         if (!empty($generik_id)) {
//           $criteria->addCondition("LOWER(t.obatalkes_nama) ILIKE '%" . $_GET['term'] . "%' OR t.generik_id = " . $generik_id);
//         }
//       } else {
//         $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
//       }
//       $criteria->addCondition('obatalkes_farmasi = TRUE');
//       $criteria->addCondition('obatalkes_aktif = true');
//       $criteria->order = 'obatalkes_nama';
//       $criteria->limit = 5;
//       $models = ObatalkesM::model()->with('sumberdana', 'satuankecil')->findAll($criteria);
//       $persenjual = $this->persenJualRuangan();
//       $format = new MyFormatter();
//       $returnVal = array();
//       foreach ($models as $i => $model) {
//         $attributes = $model->attributeNames();

//         foreach ($attributes as $j => $attribute) {
//           $returnVal[$i]["$attribute"] = $model->$attribute;
//         }
//         $qtyStok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
//         $returnVal[$i]['label'] = $model->obatalkes_kode . " - " . $model->obatalkes_nama;
//         $returnVal[$i]['value'] = $model->obatalkes_nama;
//         $returnVal[$i]['sumberdana_nama'] = $model->sumberdana->sumberdana_nama;
//         $returnVal[$i]['qtyStok'] = $qtyStok;
//         $returnVal[$i]['hargajual'] = floor(($persenjual + 100) / 100 * $model->hargajual);
//         $returnVal[$i]['satuankecil'] = $model->satuankecil->satuankecil_nama;
//         $returnVal[$i]['idsatuankecil'] = $model->satuankecil_id;
//         $returnVal[$i]['diskonJual'] = empty($model->diskonJual) ? 0 : $model->diskonJual;
//         $returnVal[$i]['kadaluarsa'] = ((strtotime($format->formatDateTimeForDb($model->tglkadaluarsa)) - strtotime(date('Y-m-d'))) > 0) ? 0 : 1;
//       }
//       echo CJSON::encode($returnVal);
//     }
//     Yii::app()->end();
//   }

//   protected function persenJualRuangan()
//   {
//     switch (Yii::app()->user->getState('instalasi_id')) {
//       case Params::INSTALASI_ID_RI:
//         $persen = Yii::app()->user->getState('ri_persjual');
//         break;
//       case Params::INSTALASI_ID_RJ:
//         $persen = Yii::app()->user->getState('rj_persjual');
//         break;
//       case Params::INSTALASI_ID_RD:
//         $persen = Yii::app()->user->getState('rd_persjual');
//         break;
//       default:
//         $persen = 0;
//         break;
//     }

//     return $persen;
//   }

//   public function actionPrint()
//   {
//     $pendaftaran_id = $_GET['id'];
//     $reseptur_id = isset($_GET['idReseptur']) ? $_GET['idReseptur'] : null;

//     if (!empty($reseptur_id)) {
//       $maxtime = RIResepturT::model()->findByPk($reseptur_id);
//     } else {
//       $criteria = new CDbCriteria;
//       $criteria->addCondition("create_time=(select max(create_time) from reseptur_t)");
//       $maxtime = RIResepturT::model()->find($criteria);
//     }
//     $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id' => $maxtime->reseptur_id));
//     $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
//     $judulLaporan = 'Reseptur';
//     $caraPrint = $_REQUEST['caraPrint'];
//     if (isset($_GET['idReseptur'])) {
//       $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id' => $_GET['idReseptur']));
//       if ($caraPrint == 'PRINT') {
//         $this->layout = '//layouts/printWindows';
//         $this->render('_viewDetailResep', array('modPendaftaran' => $modPendaftaran, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modDetailResep' => $modDetailResep, 'modReseptur' => $maxtime));
//       }
//     } else {
//       if ($caraPrint == 'PRINT') {
//         $this->layout = '//layouts/printWindows';
//         $this->render('Print', array('modPendaftaran' => $modPendaftaran, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, "modDetailResep" => $modDetailResep, 'modReseptur' => $maxtime));
//       }
//     }
//   }

//   public function actionAjaxDetailResep()
//   {
//     if (Yii::app()->request->isAjaxRequest) {
//       $idReseptur = $_POST['idReseptur'];
//       $pendaftaran_id = $_POST['pendaftaran_id'];
//       $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
//       $modReseptur = RIResepturT::model()->findByPk($idReseptur);
//       $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id' => $idReseptur));

//       $data['result'] = $this->renderPartial('_viewDetailResep', array(
//         'modDetailResep' => $modDetailResep,
//         'modPendaftaran' => $modPendaftaran,
//         'modReseptur' => $modReseptur,
//         'idReseptur' => $idReseptur,
//       ), true);

//       echo json_encode($data);
//       Yii::app()->end();
//     }
//   }

//   public function actionHapusRiwayatReseptur()
//   {
//     if (Yii::app()->request->isAjaxRequest) {
//       $data['pesan'] = "";
//       $data['sukses'] = 0;
//       $transaction = Yii::app()->db->beginTransaction();
//       try {
//         $detailResep = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id' => $_POST['reseptur_id']));
//         $resep = ResepturT::model()->findByPk($_POST['reseptur_id']);
//         $deleteDetailResep = ResepturdetailT::model()->deleteAllByAttributes(array('reseptur_id' => $_POST['reseptur_id']));
//         if ($deleteDetailResep) {
//           if ($resep->delete()) {
//             $data['pesan'] = "Riwayat Resep Termasuk Detail Resep Berhasil Dihapus!";
//             $data['sukses'] = 1;
//             $transaction->commit();
//           } else {
//             $transaction->rollback();
//             $data['pesan'] = "Gagal Menghapus Reseptur";
//             $data['sukses'] = 0;
//           }
//         } else {
//           $transaction->rollback();
//           $data['pesan'] = "Gagal Menghapus Detail Reseptur";
//           $data['sukses'] = 0;
//         }
//       } catch (Exception $exc) {
//         $transaction->rollback();
//         $data['pesan'] = "Transaksi Gagal :" . MyExceptionMessage::getMessage($exc, true);
//       }
//       echo CJSON::encode($data);
//     }
//     Yii::app()->end();
//   }

//   // Uncomment the following methods and override them if needed
//   /*
// 	public function filters()
// 	{
// 		// return the filter configuration for this controller, e.g.:
// 		return array(
// 			'inlineFilterName',
// 			array(
// 				'class'=>'path.to.FilterClass',
// 				'propertyName'=>'propertyValue',
// 			),
// 		);
// 	}

// 	public function actions()
// 	{
// 		// return external action classes, e.g.:
// 		return array(
// 			'action1'=>'path.to.ActionClass',
// 			'action2'=>array(
// 				'class'=>'path.to.AnotherActionClass',
// 				'propertyName'=>'propertyValue',
// 			),
// 		);
// 	}
// 	*/


//   /**
//    * method to get Terapi Obat
//    * made for : LNG Projects
//    * LNG-321
//    */
//   public function actionAutoCompleteTherapiObat()
//   {
//     if (Yii::app()->request->isAjaxRequest) {
//       $term = $_GET['term'];
//       $criteria = new CDbCriteria();
//       $criteria->addCondition("therapiobat_nama ILIKE '%" . $term . "%'");
//       $criteria->addCondition('therapiobat_aktif = true');
//       $models = RITherapiobatM::model()->findAll($criteria);
//       $returnVal = array();
//       foreach ($models as $i => $model) {
//         $attributes = $model->attributeNames();

//         foreach ($attributes as $j => $attribute) {
//           $returnVal[$i]["$attribute"] = $model->$attribute;
//         }
//         $returnVal[$i]['label'] = $model->therapiobat_nama;
//         $returnVal[$i]['value'] = $model->therapiobat_id;
//       }
//       echo CJSON::encode($returnVal);
//     }
//     Yii::app()->end();
//   }

//   public function actionSetTherapiobatid()
//   {
//     if (Yii::app()->request->isAjaxRequest) {
//       $obatalkes_id = $_POST['obatalkes_id'];
//       $modTherapi = RITherapimapobatM::model()->findByAttributes(array('obatalkes_id' => $obatalkes_id));
//       if (!empty($modTherapi)) {
//         $data = $modTherapi->therapiobat_id;
//       } else {
//         $data = null;
//       }
//       echo CJSON::encode($data);
//     }
//     Yii::app()->end();
//   }

//   public function actionSetDropdownRke()
//   {
//     if (Yii::app()->request->isAjaxRequest) {
//       $data = '';
//       $rmax = isset($_POST['rmax']) ? $_POST['rmax'] : null;
//       if (!empty($rmax)) {
//         for ($i = $rmax + 1; $i <= 20; $i++) {
//           $data .=  CHtml::tag('option', array('value' => $i), CHtml::encode($i), true);
//         }
//       }
//       echo CJSON::encode($data);
//     }
//     Yii::app()->end();
//   }

//   public function actionSetFormObatAlkesPasien()
//   {
//     if (Yii::app()->request->isAjaxRequest) {
//       $obatalkes_id = $_POST['obatalkes_id'];
//       $jumlah = MyFormatter::formatRupiahForDB($_POST['jumlah']);
//       $isRacikan = $_POST['isRacikan'];
//       $ruangan_id = $_POST['ruangan_id'];
//       $therapiobat_id = isset($_POST['therapiobat_id']) ? $_POST['therapiobat_id'] : null;
//       $form = "";
//       $pesan = "";
//       $format = new MyFormatter();
//       $modResepturDetail = new RIResepturDetailT;
//       $jmlStok = StokobatalkesT::getJumlahStok($obatalkes_id, $ruangan_id);

//       $modObatAlkes = RIObatalkesM::model()->findByPk($obatalkes_id);
//       //if($jmlStok > 0){
//       $modResepturDetail->obatalkes_id = $modObatAlkes->obatalkes_id;
//       $modResepturDetail->sumberdana_id = $modObatAlkes->sumberdana_id;
//       $modResepturDetail->satuankecil_id = $modObatAlkes->satuankecil_id;
//       $modResepturDetail->racikan_id = ($isRacikan == 0) ? Params::RACIKAN_ID_NONRACIKAN : Params::RACIKAN_ID_RACIKAN;
//       $modResepturDetail->r = 'R/';
//       $modResepturDetail->qty_reseptur = number_format($jumlah, 2, ',', '.'); //ceil($jumlah); // LNG Ceil (Pembulatan keatas request pak tito)
//       $modResepturDetail->jmlstok = 0; //$jmlStok;
//       $modResepturDetail->kekuatan_reseptur = $modObatAlkes->kekuatan;
//       $modResepturDetail->satuankekuatan = $modObatAlkes->satuankekuatan;

//       $instalasi = Yii::app()->user->getState('instalasi_id');

//       $konfigFarmasi = KonfigfarmasiK::model()->find();
//       if ($instalasi == Params::INSTALASI_ID_RJ || $instalasi == Params::INSTALASI_ID_HD || $instalasi == 74) {
//         $modResepturDetail->persenppnjual = $konfigFarmasi->rj_persjualppn;
//       } else if ($instalasi == Params::INSTALASI_ID_RI || $instalasi == Params::INSTALASI_ID_PERAWATAN_INTENSIF) {
//         $modResepturDetail->persenppnjual = $konfigFarmasi->ri_persjualppn;
//       } else if ($instalasi == Params::INSTALASI_ID_RD || $instalasi == Params::INSTALASI_ID_PERSALINAN) {
//         $modResepturDetail->persenppnjual = $konfigFarmasi->rd_persjualppn;
//       } else {
//         $modResepturDetail->persenppnjual = 0;
//       }
//       $hargaQytOa = round(($modObatAlkes->hargajual * (int)$modResepturDetail->qty_reseptur));
//       $jmlPPn = round((($modResepturDetail->persenppnjual * $hargaQytOa) / 100));

//       $modResepturDetail->hargasatuan_reseptur = MyFormatter::formatNumberForPrint(round($modObatAlkes->hargajual));
//       $modResepturDetail->jumlahppn = MyFormatter::formatNumberForPrint($jmlPPn);
//       $modResepturDetail->harganetto_reseptur = MyFormatter::formatNumberForPrint(round($modObatAlkes->harganetto));
//       $modResepturDetail->hargajual_reseptur = MyFormatter::formatNumberForPrint(round($hargaQytOa + $jmlPPn));
//       $modResepturDetail->therapiobat_id = $therapiobat_id;

//       //                $modResepturDetail->permintaan_reseptur = $post['jmlpermintaan'][$i];
//       //                $modResepturDetail->jmlkemasan_reseptur = $post['jmlkemasan'][$i];

//       $form .= $this->renderPartial('_rowDetail', array('modResepturDetail' => $modResepturDetail, 'isRacikan' => $isRacikan), true);

//       //}else{
//       //    $pesan = "Stok tidak mencukupi!";
//       //}

//       echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
//       Yii::app()->end();
//     }
//   }

//   public function actionAutocompleteObatReseptur()
//   {
//     if (Yii::app()->request->isAjaxRequest) {
//       $term = explode(';', $_GET['term']);
//       $ruangan_id = $_GET['ruangantujuan_id'];
//       $obatalkes_nama = isset($term[0]) ? $term[0] : '';
//       $hargajual = isset($term[1]) ? $term[1] : '';
//       $criteria = new CDbCriteria();
//       $criteria->compare('LOWER(obatalkes_nama)', strtolower($obatalkes_nama), true);
//       if ($hargajual != '') {
//         $criteria->addCondition('hargajual =' . $hargajual, 'or');
//       }
//       $criteria->addCondition('obatalkes_farmasi = TRUE');
//       $criteria->addCondition('obatalkes_aktif = true');
//       $criteria->order = 'obatalkes_nama';
//       $criteria->limit = 5;
//       $models = ObatalkesM::model()->with('sumberdana', 'satuankecil')->findAll($criteria);
//       $persenjual = $this->persenJualRuangan();
//       $format = new MyFormatter();
//       foreach ($models as $i => $model) {
//         $attributes = $model->attributeNames();
//         $satuan = SatuankecilM::model()->findByPk($model->satuankecil_id);

//         foreach ($attributes as $j => $attribute) {
//           $returnVal[$i]["$attribute"] = $model->$attribute;
//         }
//         $qtyStok = StokobatalkesT::getJumlahStok($model->obatalkes_id, $ruangan_id);
//         $returnVal[$i]['label'] = $model->obatalkes_kode . " - " . $model->obatalkes_nama . " : " . $qtyStok . " " . $satuan->satuankecil_nama;
//         $returnVal[$i]['value'] = $model->obatalkes_nama;
//         $returnVal[$i]['obatalkes_id'] = $model->obatalkes_id;
//         $returnVal[$i]['sumberdana_nama'] = $model->sumberdana->sumberdana_nama;
//         $returnVal[$i]['qtyStok'] = $qtyStok;
//         $returnVal[$i]['hargajual'] = floor(($persenjual + 100) / 100 * $model->hargajual);
//         $returnVal[$i]['satuankecil'] = $model->satuankecil->satuankecil_nama;
//         $returnVal[$i]['idsatuankecil'] = $model->satuankecil_id;
//         $returnVal[$i]['diskonJual'] = empty($model->diskonJual) ? 0 : $model->diskonJual;
//         $returnVal[$i]['kadaluarsa'] = ((strtotime($format->formatDateTimeForDb($model->tglkadaluarsa)) - strtotime(date('Y-m-d'))) > 0) ? 0 : 1;
//       }
//       echo CJSON::encode($returnVal);
//     }
//     Yii::app()->end();
//   }

//   /**
//    * @author Deni Hamdani <denihamdani@piindonesia.co.id>
//    *
//    * Mengambil data lookup signa untuk autocomplete
//    *
//    * @param string $term input dari textfield autocomplete untuk memfilter nama lookup-nya.
//    */
//   public function actionGetSignaFarmasi($term = null)
//   {
//     $cr = new CDbCriteria();
//     $cr->compare('lookup_type', 'signa_oa');
//     $cr->compare('lower(lookup_name)', strtolower($term), true);
//     $cr->addCondition('lookup_aktif = true');
//     $cr->order = 'lookup_urutan';

//     $signa = LookupM::model()->findAll($cr);

//     $res = array();
//     foreach ($signa as $item) {
//       $res[] = array('label' => $item->lookup_name, 'value' => $item->lookup_name);
//     }

//     echo CJSON::encode($res);
//   }
// }
