<?php

/**
 * controller ini digunakan untuk mengelola transaksi konsul poli
 * 
 * @package application.modules.perawatanIntensif
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0
 * @link    <http://piindonesia.co.id> 
 */
class KonsulPoliTPIController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  protected $path_view = 'rawatJalan.views.konsulPoli.';
  protected $successSave = true;

  /**
   * action ini digunakan untuk mengelola transaksi konsul poli
   * @param type $pendaftaran_id
   * @param type $idPasienKirimKeUnitLain
   * @param type $idKonsulPoli
   */
  public function actionIndex($pendaftaran_id, $idPasienKirimKeUnitLain = null, $idKonsulPoli = null)
  {
    //		$ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : $this->getRuanganId();
    $modPendaftaran = PIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = PIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $karcisTindakan = DaftartindakanM::model()->findAllByAttributes(array('daftartindakan_karcis' => true));

    $modKonsul = new PIKonsulPoliT;
    $modJawabKonsul = new PIJawabkonsulpoliT;
    $modelPendaftaran = new PIPendaftaranT;
    $modKonsul->pasien_id = $modPendaftaran->pasien_id;
    $modKonsul->pendaftaran_id = $pendaftaran_id;
    $modKonsul->pegawai_id = $modPendaftaran->pegawai_id;
    $modKonsul->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
    $modKonsul->asalpoliklinikkonsul_id = $ruangan_id;

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
      $modKirimKeUnitLain = PIPasienKirimKeUnitLainT::model()->findByPk($idPasienKirimKeUnitLain);
      $modPasien = $modKirimKeUnitLain->pasien;
    }

    if (!empty($idKonsulPoli)) {
      $modKonsulPoli = PIKonsulPoliT::model()->findByPk($idKonsulPoli);
    } else {
      $modKonsulPoli = new PIKonsulPoliT();
    }

    if (isset($_POST['PIKonsulPoliT'])) {
      $modKonsul->attributes = $_POST['PIKonsulPoliT'];
      $modelPendaftaran->pasienpulang_id = $modPendaftaran->pasienpulang_id;
      $modelPendaftaran->pasienbatalperiksa_id = $modPendaftaran->pasienbatalperiksa_id;
      if (empty($modelPendaftaran->penanggungjawab_id)) {
        $penanggungjawab = 1;
      } else {
        $penanggungjawab = $modPendaftaran->penanggungjawab_id;
      }
      //			$modKonsul->no_antriankonsul = MyGenerator::noAntrianKonsulPoli($modKonsul->ruangan_id);
      $modKonsul->no_antriankonsul = MyGenerator::noAntrianPPKonsul($modKonsul->ruangan_id); //fungsi diganti karena no antrian duplikat ketika ada konsul poli ke ruangan.
      //			$modKonsul->create_ruangan = Yii::app()->user->ruangan_id;
      $modKonsul->create_ruangan = $this->getRuanganId();
      $modKonsul->create_time = date('Y-m-d');
      $modKonsul->create_loginpemakai_id = Yii::app()->user->id;
      $modKonsul->ruangan_id = $_POST['PIKonsulPoliT']['ruangan_id'];
      if ($_POST['PIKonsulPoliT']['ruangan_id'] != Params::RUANGAN_ID_HEMODIALISA) {
        $modKonsul->jenisdialisat_id = null;
        $modKonsul->penarikan_cairan = null;
        $modKonsul->lama_hd = null;
        $modKonsul->jenistransfusi_id = null;
        $modKonsul->aksesvaskular_id = null;
      }
      $modKonsul->tglkonsulpoli = MyFormatter::formatDateTimeForDb($modKonsul->tglkonsulpoli);
      if ($modKonsul->validate()) {
        if ($modKonsul->save()) {
          // $updateStatusPeriksa = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
          /* ================================================ */
          /* Proses update status periksa KonsulPoli EHS-179  */
          /* ================================================ */
          $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
          if (!empty($konsulPoli)) {
            $updateStatusPeriksa = KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
          }
          /* ================================================ */

          PendaftaranT::model()->updateByPk(
            $pendaftaran_id,
            array(
              'pembayaranpelayanan_id' => null
            )
          );

          $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id)->jenistarif_id;
          $modTarif = PITariftindakanM::model()->findByAttributes(array('daftartindakan_id' => Params::DAFTARTINDAKAN_ID_KONSUL, 'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL, 'kelaspelayanan_id' => $modPendaftaran->kelaspelayanan_id, 'jenistarif_id' => $jenistarif));
          if (!empty($modTarif)) {
            $modTindakanPelayanan = new PITindakanPelayananT;
            $modTindakanPelayanan->konsulpoli_id = $modKonsul->konsulpoli_id;
            $modTindakanPelayanan->pasien_id = $modPendaftaran->pasien_id;
            $modTindakanPelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modTindakanPelayanan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
            $modTindakanPelayanan->shift_id = $modPendaftaran->shift_id;
            $modTindakanPelayanan->carabayar_id = $modPendaftaran->carabayar_id;
            $modTindakanPelayanan->penjamin_id = $modPendaftaran->penjamin_id;
            $modTindakanPelayanan->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
            $modTindakanPelayanan->ruangan_id = $modKonsul->ruangan_id;
            $modTindakanPelayanan->instalasi_id = $modTindakanPelayanan->ruangan->instalasi_id;
            $modTindakanPelayanan->cyto_tindakan = 0;
            $modTindakanPelayanan->tarifcyto_tindakan = 0;
            $modTindakanPelayanan->discount_tindakan = 0;
            $modTindakanPelayanan->subsidiasuransi_tindakan = 0;
            $modTindakanPelayanan->subsidipemerintah_tindakan = 0;
            $modTindakanPelayanan->subsisidirumahsakit_tindakan = 0;
            $modTindakanPelayanan->iurbiaya_tindakan = 0;
            $modTindakanPelayanan->create_loginpemakai_id = Yii::app()->user->id;
            $modTindakanPelayanan->create_ruangan = $modKonsul->ruangan_id;
            $modTindakanPelayanan->create_time = date('Y-m-d H:i:s');
            $modTindakanPelayanan->satuantindakan = "Hari";

            $modTindakanPelayanan->daftartindakan_id = Params::DAFTARTINDAKAN_ID_KONSUL;
            $modTindakanPelayanan->tgl_tindakan = date('Y-m-d H:i:s');

            $modTindakanPelayanan->tarif_satuan = (isset($modTarif->harga_tariftindakan) ? $modTarif->harga_tariftindakan : 0);
            $modTindakanPelayanan->tarif_tindakan = $modTindakanPelayanan->qty_tindakan * $modTindakanPelayanan->tarif_satuan;

            if ($modTindakanPelayanan->validate()) {
              if ($modTindakanPelayanan->save()) {
                $valid = true;
              }
            }
          }


          $judul = 'Pasien Konsul Poli';

          $isi = 'Pasien ' . $modPasien->nama_pasien . ' dengan nomor rekam medik ' . $modPasien->no_rekam_medik . ' telah dikonsul ke ' . $modKonsul->politujuan->ruangan_nama . ' pada ' . $modKonsul->tglkonsulpoli . ' dari ' . $modKonsul->poliasal->ruangan_nama;

          $ruangan = RuanganM::model()->findByPk($modKonsul->ruangan_id);


          $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
          ));

          // SMS GATEWAY
          $modPegawai = $modPendaftaran->pegawai;
          $modRuangan = $modKonsul->politujuan;
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
            $attributes = $modKonsul->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modRuangan->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modKonsul->tglkonsulpoli), $isiPesan);

            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
              if (!empty($modPasien->no_mobile_pasien)) {
                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
              } else {
                $smspasien = 0;
              }
            }
          }

          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'idKonsulPoli' => $modKonsul->konsulpoli_id, 'smspasien' => $smspasien));
        }
      }
    }

    //RND-11092            $modRiwayatKonsul = PIKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'asalpoliklinikkonsul_id'=>$ruangan_id));
    $criteria_riwayat = new CDbCriteria();
    $criteria_riwayat->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    //		$criteria_riwayat->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id') . ' OR asalpoliklinikkonsul_id = ' . Yii::app()->user->getState('ruangan_id'));
    $criteria_riwayat->addCondition('ruangan_id = ' . $this->getRuanganId() . ' OR asalpoliklinikkonsul_id = ' . $this->getRuanganId());
    $modRiwayatKonsul = PIKonsulPoliT::model()->findAll($criteria_riwayat);

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modKonsul' => $modKonsul,
      'modKonsulPoli' => $modKonsulPoli,
      'modJawabKonsul' => $modJawabKonsul,
      'karcisTindakan' => $karcisTindakan,
      'modRiwayatKonsul' => $modRiwayatKonsul,
      'modelPendaftaran' => $modelPendaftaran,
      'modJenisTarif' => $modJenisTarif
    ));
  }

  /**
   * mengenerate detail konsul poli
   */
  public function actionAjaxDetailKonsul()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $konsulantarpoli_id = $_POST['idKonsulAntarPoli'];
      $modKonsulPoli = PIKonsulPoliT::model()->findByPk($konsulantarpoli_id);
      $data['result'] = $this->renderPartial($this->path_view . '_viewKonsulPoli', array('modKonsul' => $modKonsulPoli), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * mengenerate jawab konsul
   */
  public function actionJawabKonsul()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modKonsul = new PIKonsulPoliT;
    $modJawabKonsul = new PIJawabkonsulpoliT;

    if (isset($_GET['konsulpoli_id'])) {
      $modKonsul = PIKonsulPoliT::model()->findByPk($_GET['konsulpoli_id']);
      $jawab = PIJawabkonsulpoliT::model()->findByAttributes(array('konsulpoli_id' => $_GET['konsulpoli_id']));
      if (!empty($jawab)) {
        $modJawabKonsul = PIJawabkonsulpoliT::model()->findByPk($jawab->jawabkonsulpoli_id);
      }
    }

    if (isset($_POST['PIJawabkonsulpoliT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modelKonsul = $this->saveJawabKonsul($_POST['PIJawabkonsulpoliT'], $modKonsul);

        KonsulpoliT::model()->updateByPk($_GET['konsulpoli_id'], array('jawabkonsulpoli_id' => $modelKonsul->jawabkonsulpoli_id));

        $successSave = $this->successSave;
        if ($successSave) {
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $transaction->commit();
          //                    $this->redirect(array('index','status'=>1,'jawabko'=>$model->pasienblacklist_id)); 
        } else {
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $transaction->rollback();
      }
    }
    $this->render($this->path_view . '_jawabKonsulPoli', array(
      'modKonsul' => $modKonsul,
      'modJawabKonsul' => $modJawabKonsul,
      //			'status' => $status,
    ));
  }

  /**
   * menyimpan jawab poli
   * @param type $post
   * @param type $konsul
   * @return \PIJawabkonsulpoliT
   */
  protected function saveJawabKonsul($post, $konsul)
  {
    $model = new PIJawabkonsulpoliT;
    $model->attributes = $post;
    $model->konsulpoli_id = $konsul->konsulpoli_id;
    //		$model->ruangan_id = Yii::app()->user->ruangan_id;
    $model->ruangan_id = $this->getRuanganId();
    $model->pegawai_id = $post['pegawai_id'];
    $model->pendaftaran_id = $konsul->pendaftaran_id;
    $model->pasien_id = $konsul->pasien_id;
    $model->asalpoliklinikkonsul_id = $konsul->asalpoliklinikkonsul_id;
    $model->nojawabkonsul = MyGenerator::noJawabKonsul();
    $model->tgljawabkonsul = MyFormatter::formatDateTimeForDb($post['tgljawabkonsul']);
    $model->jawabankonsul = $post['jawabankonsul'];
    //		$model->create_ruangan = Yii::app()->user->ruangan_id;
    $model->create_ruangan = $this->getRuanganId();
    $model->create_time = date('Y-m-d');
    $model->create_loginpemakai_id = Yii::app()->user->id;
    if ($model->validate()) {
      $model->save();
      $this->successSave = $this->successSave && true;
    } else {
      $this->successSave = false;
    }

    return $model;
  }

  /**
   * batal konsul
   */
  public function actionAjaxBatalKonsul()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $konsulantarpoli_id = (isset($_POST['idKonsulAntarPoli']) ? $_POST['idKonsulAntarPoli'] : null);
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);

      $tindakanpelayanan = PITindakanPelayananT::model()->findByAttributes(array('konsulpoli_id' => $konsulantarpoli_id));
      if (!empty($tindakanpelayanan)) {
        TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $tindakanpelayanan->tindakanpelayanan_id));
        PITindakanPelayananT::model()->deleteByPk($tindakanpelayanan->tindakanpelayanan_id);
      }

      PIKonsulPoliT::model()->deleteByPk($konsulantarpoli_id);
      $modRiwayatKonsul = PIKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

      $data['result'] = $this->renderPartial($this->path_view . '_listKonsulPoli', array('modRiwayatKonsul' => $modRiwayatKonsul), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * ajax untuk menampilkan tarif tindakan konsultasi poliklinik
   */
  public function actionAjaxSetTarif()
  {
    if (Yii::app()->request->isAjaxRequest) {
      //			$penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
      $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
      //			$kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
      //			$ruangan = RuanganM::model()->findByPk($ruangan_id);
      //			$ruangan_nama = $ruangan->ruangan_nama;
      //			$jenistarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $penjamin_id)->jenistarif_id;
      //
      //			$criteria = new CDbCriteria();
      //			$criteria->addCondition('komponentarif_id =' . Params::KOMPONENTARIF_ID_TOTAL);
      //			$criteria->addCondition('daftartindakan_id = ' . Params::DAFTARTINDAKAN_ID_KONSUL);
      //			if (!empty($kelaspelayanan_id)) {
      //				$criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
      //			}
      //			if (!empty($jenistarif)) {
      //				$criteria->addCondition("jenistarif_id = " . $jenistarif);
      //			}
      //			$model = TariftindakanM::model()->findAll($criteria);
      //
      //			$data['result'] = $this->renderPartial($this->path_view . '_listTarifKonsul', array('model' => $model, 'ruangan_nama' => $ruangan_nama), true);
      $data['result'] = "";
      $data['dokter'] = $this->loadDokterRuangan($ruangan_id);
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  protected function loadDokterRuangan($ruangan_id)
  {
    $dokter = DokterV::model()->findAllByAttributes(array(
      'pegawai_aktif' => true,
      'ruangan_id' => $ruangan_id,
    ));
    $dat = CHtml::listData($dokter, 'pegawai_id', 'namaLengkap');
    $str = count((array)$dat) > 1 ? '<option value="">-- Pilih --</option>' : '';
    foreach ($dat as $val => $item) {
      $str .= '<option value="' . $val . '">' . $item . '</option>';
    }

    return $str;
  }

  /**
   * mengenerate prinout
   */
  public function actionPrint()
  {
    $modKonsul = new PIKonsulPoliT;
    $pendaftaran_id = (isset($_GET['id']) ? $_GET['id'] : null);
    $konsulpoli_id = (isset($_GET['idKonsulPoli']) ? $_GET['idKonsulPoli'] : null);
    $modPendaftaran = PIPendaftaranT::model()->findByPk($pendaftaran_id);

    //            $modKonsulPoli = PIKonsulPoliT::model()->findByPk($idKonsulAntarPoli);
    $modRiwayatKonsul = PIKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'konsulpoli_id' => $konsulpoli_id));

    $judulLaporan = 'Permintaan Konsultasi Poliklinik';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');          //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');               //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * mengenerate prinout konsul poli
   */
  public function actionPrintJawabKonsul()
  {
    $criteria = new CDbCriteria();
    $criteria->with = array('ruangan');
    $criteria->addCondition('jawabkonsulpoli_id =' . $_REQUEST['jawabkonsulpoli_id']);
    $modJawabKonsul = PIJawabkonsulpoliT::model()->find($criteria);
    $modPendaftaran = PIPendaftaranT::model()->findByPk($modJawabKonsul->pendaftaran_id);

    $criteria = new CDbCriteria();
    $criteria->with = array('pegawai');
    $criteria->addCondition('konsulpoli_id =' . $modJawabKonsul->konsulpoli_id);
    $modKonsul = PIKonsulPoliT::model()->find($criteria);
    $modPasien = PIPasienM::model()->findByPk($modJawabKonsul->pasien_id);
    $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());

    $judulLaporan = 'Jawaban Konsultasi Poliklinik';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('modJawabKonsul' => $modJawabKonsul, 'modPendaftaran' => $modPendaftaran, 'modKonsul' => $modKonsul, 'modPasien' => $modPasien, 'modProfilRs' => $modProfilRs, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('modJawabKonsul' => $modJawabKonsul, 'modPendaftaran' => $modPendaftaran, 'modKonsul' => $modKonsul, 'modPasien' => $modPasien, 'modProfilRs' => $modProfilRs, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');          //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');               //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('modJawabKonsul' => $modJawabKonsul, 'modPendaftaran' => $modPendaftaran, 'modKonsul' => $modKonsul, 'modPasien' => $modPasien, 'modProfilRs' => $modProfilRs, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * mencetak riwayat
   */
  public function actionPrintRiwayat()
  {
    $modKonsul = new PIKonsulPoliT;
    $pendaftaran_id = (isset($_GET['id']) ? $_GET['id'] : null);
    $modPendaftaran = PIPendaftaranT::model()->findByPk($pendaftaran_id);
    $modRiwayatKonsul = PIKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $judulLaporan = 'Permintaan Konsultasi Poliklinik';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      //			$this->render($this->path_view . 'printRiwayat', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      $this->render('printRiwayat', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      //			$this->render($this->path_view . 'printRiwayat', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      $this->render('printRiwayat', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');          //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');               //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      //			$mpdf->WriteHTML($this->renderPartial($this->path_view . 'printRiwayat', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->WriteHTML($this->renderPartial('printRiwayat', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * set dropdown ruangan dari instalasi_id
   * @param type $encode
   * @param type $namaModel
   */
  public function actionSetDropdownRuangan($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = $_POST["$namaModel"]['instalasi_id'];
      if ($encode) {
        echo CJSON::encode($ruangan);
      } else {
        if (empty($instalasi_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $ruangan = RuanganM::model()->findAllByAttributes(array('instalasi_id' => $instalasi_id, 'ruangan_aktif' => true), array('order' => 'ruangan_nama ASC'));
          if (count((array)$ruangan) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $ruangan = CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama');
          foreach ($ruangan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * set dropdown dokter dari ruangna_id
   * @param type $encode
   * @param type $namaModel
   */
  public function actionSetDropdownDokter($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST["$namaModel"]['ruangan_id'];
      if ($encode) {
        echo CJSON::encode($dokter);
      } else {
        if (empty($ruangan_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $dokter = DokterV::model()->findAllByAttributes(array('ruangan_id' => $ruangan_id, 'pegawai_aktif' => true), array('order' => 'nama_pegawai ASC'));
          if (count((array)$dokter) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $dokter = CHtml::listData($dokter, 'pegawai_id', 'nama_pegawai');
          foreach ($dokter as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
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

  /**
   * mengambil nilai ruangan
   * @return type
   */
  public function getRuanganId()
  {
    $ruangan_id = null;
    if (isset($_GET['pasienadmisi_id'])) {
      $modAdmisi = PasienadmisiT::model()->findByPk($_GET['pasienadmisi_id']);
      $ruangan_id = $modAdmisi->ruangan_id;
    } else {
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
    }
    return $ruangan_id;
  }
}
