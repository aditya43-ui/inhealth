<?php
class InformasiSayHelloController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Say Hello";
    $format = new MyFormatter();
    $modSayHello = new INInfopasiensayhelloV('searchSayHello');
    $modSayHello->unsetAttributes();
    $modSayHello->tgl_awal = date('Y-m-d');
    $modSayHello->tgl_akhir = date('Y-m-d');
    $modSayHello->ceklis = TRUE;
    if (isset($_GET['INInfopasiensayhelloV'])) {
      $modSayHello->attributes = $_GET['INInfopasiensayhelloV'];
      $modSayHello->tgl_awal = $format->formatDateTimeForDb($_GET['INInfopasiensayhelloV']['tgl_awal']);
      $modSayHello->tgl_akhir = $format->formatDateTimeForDb($_GET['INInfopasiensayhelloV']['tgl_akhir']);
      //            $modSayHello->ceklis = $_GET['INInfopasiensayhelloV']['ceklis'];
      $modSayHello->tgl_awal = $modSayHello->tgl_awal . " 00:00:00";
      $modSayHello->tgl_akhir = $modSayHello->tgl_akhir . " 23:59:59";
    }

    $this->render('index', array(
      'modSayHello' => $modSayHello,
      'format' => $format
    ));
  }

  public function actionInputSayHello()
  {
    $pendaftaran_id = $_GET['pendaftaran_id'];
    $pasienadmisi_id = $_GET['pasienadmisi_id'];

    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAdmisi = INPasienadmisiT::model()->findByPk($pasienadmisi_id);
    $modMasukKamar = INMasukKamarT::model()->findByAttributes(array('pasienadmisi_id' => $modAdmisi->pasienadmisi_id));
    $format = new MyFormatter();

    if (isset($_GET['pasiensayhello_id'])) {
      $modSayHello = INPasiensayhelloT::model()->findByPk($_GET['pasiensayhello_id']);
      $modSayHello->pasiensayhello_tgl = MyFormatter::formatDateTimeForUser($modSayHello->pasiensayhello_tgl);
    } else {
      $modSayHello = new INPasiensayhelloT();
      $modSayHello->pasiensayhello_tgl = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
    }
    //			if(count((array)$modMasukKamar) > 0){
    //				$modPendaftaran->pegawai->nama_pegawai = $modMasukKamar->pegawai->NamaLengkap;
    //			}else{
    //				$modPendaftaran->pegawai->nama_pegawai	 = $modPendaftaran->dokter->NamaLengkap;
    //			}
    //			
    if (isset($_POST['INPasiensayhelloT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modSayHello->attributes = $_POST['INPasiensayhelloT'];
        //                    $modSayHello->pasiensayhello_tgl = date('Y-m-d h:i:s');
        $modSayHello->pasiensayhello_tgl = MyFormatter::formatDateTimeForDb($_POST['INPasiensayhelloT']['pasiensayhello_tgl']);
        $modSayHello->petugassayhello_id = Yii::app()->user->id;
        $modSayHello->sayhello_createtime = date('Y-m-d H:i:s');
        $modSayHello->sayhello_ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modSayHello->sayhello_create_login = Yii::app()->user->id;

        if ($modSayHello->validate()) {
          $modSayHello->save();
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
          $this->redirect(array('inputSayHello', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'pasiensayhello_id' => $modSayHello->pasiensayhello_id, 'SUKSES' => 1));
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('formSayHello', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modAdmisi' => $modAdmisi,
      'modSayHello' => $modSayHello,
    ));
  }

  public function actionPrint($pendaftaran_id, $pasienadmisi_id, $pasiensayhello_id)
  {
    $this->layout = '//layouts/printWindows';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAdmisi = INPasienadmisiT::model()->findByPk($pasienadmisi_id);
    $modMasukKamar = INMasukKamarT::model()->findByAttributes(array('pasienadmisi_id' => $modAdmisi->pasienadmisi_id));
    $modSayHello = INPasiensayhelloT::model()->findByPk($_GET['pasiensayhello_id']);
    $modViewSayHello = INInfopasiensayhelloV::model()->findAllByAttributes(array('pasiensayhello_id' => $_GET['pasiensayhello_id']));

    $this->render('printSayHello', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modAdmisi' => $modAdmisi,
      'modSayHello' => $modSayHello,
      'modViewSayHello' => $modViewSayHello,
    ));
  }
}
