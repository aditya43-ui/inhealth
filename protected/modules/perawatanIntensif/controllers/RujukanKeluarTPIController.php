<?php
//Yii::import('rawatJalan.controllers.RujukanKeluarController');
//Yii::import('rawatJalan.models.*');
//class RujukanKeluarTPIController extends RujukanKeluarController
//{
//        
//}
class RujukanKeluarTPIController extends MyAuthController
{
  public function actionIndex($pendaftaran_id, $pasienadmisi_id)
  {
    $format = new MyFormatter();
    $this->layout = '//layouts/iframe';
    $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id)) : array();
    $modPendaftaran = PIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = PIPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $modRujukanKeluar = new PIPasienDirujukKeluarT;
    $modRujukanKeluar->pendaftaran_id = $pendaftaran_id;
    $modRujukanKeluar->pasien_id = $modPendaftaran->pasien_id;
    //            $modRujukanKeluar->pegawai_id = $modPendaftaran->pegawai_id;
    $modRujukanKeluar->pegawai_id = isset($modAdmisi->pegawai_id) ? $modAdmisi->pegawai_id : $modPendaftaran->pegawai_id;
    //            $modRujukanKeluar->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
    $modRujukanKeluar->ruanganasal_id = $modAdmisi->ruangan_id;
    $modRujukanKeluar->tgldirujuk = date('d M Y H:i:s');
    $modRujukanKeluar->tglberlakusurat = date('d M Y H:i:s');
    $modRujukanKeluar->diagnosasementara_ruj = $modRujukanKeluar->getDiagnosaSementara($pendaftaran_id);
    $modRujukanKeluar->nosuratrujukan = "-- Otomatis --";

    $smspasien = 1;
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
				$modRujukanKeluar = PIPasienDirujukKeluarT::model()->findByPk($_GET['pasiendirujukkeluar_id']);
			}
             * 
             */

    if (isset($_POST['PIPasienDirujukKeluarT'])) {
      $estimasihari = 30;
      $modRujukanKeluar->attributes = $_POST['PIPasienDirujukKeluarT'];
      $modRujukanKeluar->pasienadmisi_id = $_GET['pasienadmisi_id'];
      $modRujukanKeluar->tgldirujuk = $format->formatDateTimeForDb($_POST['PIPasienDirujukKeluarT']['tgldirujuk']);
      $modRujukanKeluar->tglberlakusurat = $_POST['PIPasienDirujukKeluarT']['tglberlakusurat'];
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
        $modRujukanKeluar->save();
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
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('index', 'status' => 1, 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'smspasien' => $smspasien)); //,'pasiendirujukkeluar_id'=>$modRujukanKeluar->pasiendirujukkeluar_id)); 
      }
    }

    $modRiwayatRujukanKeluar = PIPasienDirujukKeluarT::model()->with('rujukankeluar', 'pendaftaran')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 't.create_time DESC'));

    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modRujukanKeluar' => $modRujukanKeluar,
      'modRiwayatRujukanKeluar' => $modRiwayatRujukanKeluar,
      'modAdmisi' => $modAdmisi
    ));
  }

  public function actionAjaxDetailRujukanKeluar()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idPasienDirujuk = $_POST['idPasienDirujuk'];
      $modRujukanKeluar = PIPasienDirujukKeluarT::model()->findByPk($idPasienDirujuk);
      $data['result'] = $this->renderPartial('_viewRujukanKeluar', array('modRujukanKeluar' => $modRujukanKeluar), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {
    //            $modKonsul = new PIKonsulPoliT;
    $pendaftaran_id = $_GET['id'];
    $modPendaftaran = PIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modRujukanKeluar = new PIPasienDirujukKeluarT;
    $modRiwayatRujukanKeluar = PIPasienDirujukKeluarT::model()->with('rujukankeluar', 'pendaftaran')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 't.create_time DESC'));

    //             $karcisTindakan = DaftartindakanM::model()->findAllByAttributes(array('daftartindakan_karcis'=>true));
    // echo "<pre>"; echo $pendaftaran_id; exit();
    $judulLaporan = 'Rujukan Keluar';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatRujukanKeluar' => $modRiwayatRujukanKeluar, 'modRujukanKeluar' => $modRujukanKeluar, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatRujukanKeluar' => $modRiwayatRujukanKeluar, 'modRujukanKeluar' => $modRujukanKeluar, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatRujukanKeluar' => $modRiwayatRujukanKeluar, 'modRujukanKeluar' => $modRujukanKeluar, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionPrintRujukan()
  {
    //            $modKonsul = new PIKonsulPoliT;
    $pendaftaran_id = $_GET['id'];
    $idRujukanKeluar = $_GET['rujukankeluar_id'];
    $modPendaftaran = PIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modRujukanKeluar = PIPasienDirujukKeluarT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modRiwayatRujukanKeluar = PIPasienDirujukKeluarT::model()->with('rujukankeluar', 'pendaftaran')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'rujukankeluar_id' => $idRujukanKeluar), array('order' => 't.create_time DESC'));

    $judulLaporan = 'Rujukan Keluar';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatRujukanKeluar' => $modRiwayatRujukanKeluar, 'modRujukanKeluar' => $modRujukanKeluar, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatRujukanKeluar' => $modRiwayatRujukanKeluar, 'modRujukanKeluar' => $modRujukanKeluar, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatRujukanKeluar' => $modRiwayatRujukanKeluar, 'modRujukanKeluar' => $modRujukanKeluar, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionHapusRujukKeluar()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $id = $_POST['rujukankeluar_id'];

    $sukses = 0;
    $pesan = "Data rujukan keluar gagal dihapus.";

    if (PasiendirujukkeluarT::model()->deleteByPk($id)) {
      $sukses = 1;
      $pesan = "Data rujukan keluar berhasil dihapus.";
    }

    echo CJSON::encode(array('sukses' => $sukses, 'pesan' => $pesan));
  }
}
