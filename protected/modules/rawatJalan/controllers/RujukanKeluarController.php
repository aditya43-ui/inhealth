<?php

class RujukanKeluarController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  protected $path_view = 'rawatJalan.views.rujukanKeluar.';
  public function actionIndex($pendaftaran_id)
  {
    $format = new MyFormatter();
    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $smspasien = 1;

    $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id')) ? null : KonsulpoliT::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
    ), array(
      'order' => 'tglkonsulpoli desc',
    ));

    if (!empty($konsul)) {
      $modPendaftaran->pegawai_id = $konsul->pegawai_id;
      $modPendaftaran->ruangan_id = $konsul->ruangan_id;
    }

    $modRujukanKeluar = new RJPasienDirujukKeluarT;
    $modRujukanKeluar->pendaftaran_id = $pendaftaran_id;
    $modRujukanKeluar->pasien_id = $modPendaftaran->pasien_id;
    $modRujukanKeluar->pegawai_id = $modPendaftaran->pegawai_id;
    $modRujukanKeluar->ruanganasal_id = $ruangan_id;
    //            $modRujukanKeluar->create_ruangan = $ruangan_id;
    $modRujukanKeluar->tgldirujuk = date('d M Y H:i:s');
    $modRujukanKeluar->tglberlakusurat = date('d M Y H:i:s');
    $modRujukanKeluar->diagnosasementara_ruj = $modRujukanKeluar->getDiagnosaSementara($pendaftaran_id);
    $modRujukanKeluar->nosuratrujukan = "-- Otomatis --";

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

    /*
			if(isset($_GET['pasiendirujukkeluar_id'])){
				$modRujukanKeluar = RJPasienDirujukKeluarT::model()->findByPk($_GET['pasiendirujukkeluar_id']);
			}
             *  
             */

    if (isset($_POST['RJPasienDirujukKeluarT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $estimasihari = 30;
        $modRujukanKeluar->attributes = $_POST['RJPasienDirujukKeluarT'];
        $modRujukanKeluar->tgldirujuk = $format->formatDateTimeForDb($_POST['RJPasienDirujukKeluarT']['tgldirujuk']);
        $modRujukanKeluar->tglberlakusurat = $_POST['RJPasienDirujukKeluarT']['tglberlakusurat'];
        $modRujukanKeluar->create_time = date('Y-m-d H:i:s');
        $modRujukanKeluar->create_loginpemakai_id = Yii::app()->user->id;
        $modRujukanKeluar->nosuratrujukan = MyGenerator::noSuratRujukanKeluar();
        if (!empty($modRujukanKeluar->tglberlakusurat)) {
          $modRujukanKeluar->tglberlakusurat = $format->formatDateTimeForDb($modRujukanKeluar->tglberlakusurat);
          $tanggal = strtotime($modRujukanKeluar->tglberlakusurat . ' + ' . $estimasihari . ' days');
          $tglsampaidengan = date('Y-m-d H:i:s', $tanggal);
        } else {
          $tanggal = date('Y-m-d H:i:s');
          $tanggal = strtotime($modRujukanKeluar->tglberlakusurat . ' + ' . $estimasihari . ' days');
          $tglsampaidengan = date('Y-m-d H:i:s', $tanggal);
        }
        $modRujukanKeluar->sampaidengan = $tglsampaidengan;
        if ($modRujukanKeluar->validate()) {
          if ($modRujukanKeluar->save()) {
            $p = PendaftaranT::model()->findByPk($pendaftaran_id);
            $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
            /* ================================================ */
            /* Proses update status periksa KonsulPoli EHS-179  */
            /* ================================================ */
            $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
            if (!empty($konsulPoli)) {
              $updateStatusPeriksa = KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
            }

            // SMS GATEWAY
            $modPegawai = $modPendaftaran->pegawai;
            $modRujukan = $modRujukanKeluar->rujukankeluar;
            $sms = new Sms();
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
              $attributes = $modRujukanKeluar->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modRujukan->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modRujukanKeluar->tgldirujuk), $isiPesan);

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
            /* ================================================ */
          } else {
            echo "gagal Simpan";
            exit;
          }
        }
        Yii::app()->user->setFlash('success', "Data Rujukan Keluar Pasien berhasil disimpan");
        $this->redirect(array('index', 'status' => 1, 'pendaftaran_id' => $pendaftaran_id, 'smspasien' => $smspasien)); //,'pasiendirujukkeluar_id'=>$modRujukanKeluar->pasiendirujukkeluar_id));
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Rujukan Keluar Pasien gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modRiwayatRujukanKeluar = RJPasienDirujukKeluarT::model()->with('rujukankeluar', 'pendaftaran')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 't.create_time DESC'));

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modRujukanKeluar' => $modRujukanKeluar,
      'modRiwayatRujukanKeluar' => $modRiwayatRujukanKeluar
    ));
  }

  public function actionAjaxDetailRujukanKeluar()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idPasienDirujuk = $_POST['idPasienDirujuk'];
      $modRujukanKeluar = RJPasienDirujukKeluarT::model()->findByPk($idPasienDirujuk);
      $data['result'] = $this->renderPartial($this->path_view . '_viewRujukanKeluar', array('modRujukanKeluar' => $modRujukanKeluar), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {
    //            $modKonsul = new RJKonsulPoliT;
    $pendaftaran_id = $_GET['id'];
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modRujukanKeluar = new RJPasienDirujukKeluarT;
    $modRiwayatRujukanKeluar = RJPasienDirujukKeluarT::model()->with('rujukankeluar', 'pendaftaran')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 't.create_time DESC'));

    //             $karcisTindakan = DaftartindakanM::model()->findAllByAttributes(array('daftartindakan_karcis'=>true));
    // echo "<pre>"; echo $pendaftaran_id; exit();
    $judulLaporan = 'Rujukan Keluar';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatRujukanKeluar' => $modRiwayatRujukanKeluar, 'modRujukanKeluar' => $modRujukanKeluar, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatRujukanKeluar' => $modRiwayatRujukanKeluar, 'modRujukanKeluar' => $modRujukanKeluar, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //                //$mpdf->useOddEven = 2;  
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatRujukanKeluar' => $modRiwayatRujukanKeluar, 'modRujukanKeluar' => $modRujukanKeluar, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionPrintRujukan()
  {
    //            $modKonsul = new RJKonsulPoliT;
    $pendaftaran_id = $_GET['id'];
    $idRujukanKeluar = $_GET['rujukankeluar_id'];
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modRujukanKeluar = RJPasienDirujukKeluarT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modRiwayatRujukanKeluar = RJPasienDirujukKeluarT::model()->with('rujukankeluar', 'pendaftaran')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'rujukankeluar_id' => $idRujukanKeluar), array('order' => 't.create_time DESC'));

    $judulLaporan = 'Rujukan Keluar';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatRujukanKeluar' => $modRiwayatRujukanKeluar, 'modRujukanKeluar' => $modRujukanKeluar, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatRujukanKeluar' => $modRiwayatRujukanKeluar, 'modRujukanKeluar' => $modRujukanKeluar, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatRujukanKeluar' => $modRiwayatRujukanKeluar, 'modRujukanKeluar' => $modRujukanKeluar, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * - digunakan untuk memanggil form inputan rujukan keluar 
   * @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * @category   auto complete
   * @added		1 Pebruari 2018
   */
  public function actionFrameRujukanKeluar()
  {
    $this->layout = '//layouts/iframe';
    $model = new RujukankeluarM;

    if (isset($_POST['RujukankeluarM'])) {
      $trans = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['RujukankeluarM'];
        $model->rujukankeluar_aktif = TRUE;
        if ($model->save()) {

          $trans->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('frameRujukanKeluar', 'sukses' => 1));
        } else {
          Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
          $trans->rollback();
        }
      } catch (Exception $e) {
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
        $trans->rollback();
      }
    }

    $this->render($this->path_view . 'addMaster.create', array(
      'model' => $model,
    ));
  }


  public function actionHapusRujukKeluar()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $id = $_POST['rujukankeluar_id'];

    $sukses = 0;
    $pesan = "Data rujukan keluar gagal dihapus.";

    if (RJPasienDirujukKeluarT::model()->deleteByPk($id)) {
      $sukses = 1;
      $pesan = "Data rujukan keluar berhasil dihapus.";
    }

    echo CJSON::encode(array('sukses' => $sukses, 'pesan' => $pesan));
  }
}
