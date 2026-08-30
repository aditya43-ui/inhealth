<?php
class AnamnesaTPIController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $this->layout = '//layouts/iframe';
    $pendaftaran_id = (isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null);
    $pasienadmisi_id = (isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null);
    $format = new MyFormatter();

    if (isset($_GET['pendaftaran_id'])) { // jika di klik ubah di tabel Riwayat Fisik
      $pendaftaran_id = (isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null);
      $pasienadmisi_id = (isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null);
      $tglanamnesis = (isset($_GET['tglanamnesis']) ? $_GET['tglanamnesis'] : null);
      $cekAnamnesa = PIAnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'tglanamnesis' => $tglanamnesis));
      $modPendaftaran = PIPendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = PIPasienM::model()->findByPk($modPendaftaran->pasien_id);
      $modPpds = PpdsM::model()->findByPk($modPendaftaran->ppds_id);
      $dataPendaftaran = PIPendaftaranT::model()->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id), array('order' => 'tgl_pendaftaran DESC'));
      $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id)) : array();
      $tabelAnamnesa = PIAnamnesaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id), array('order' => 'create_time DESC'));
    }

    //print_r($lastPendaftaran);
    //echo $modPasien->pasien_id;exit();
    $i = 1;
    if (count((array)$dataPendaftaran) > 1) {
      foreach ($dataPendaftaran as $row) {
        if ($i == 2) {
          $lastPendaftaran = $row->pendaftaran_id;
        }
        $i++;
      }
    } else {
      $lastPendaftaran = $pendaftaran_id;
    }


    $modDiagnosa = new PIDiagnosaM;

    if (!empty($cekAnamnesa)) {  //Jika Pasien Sudah Melakukan Anamnesa Sebelumnya
      $modAnamnesa = $cekAnamnesa;
      
      $lama = explode(" ", $modAnamnesa->lamasakit);
      $modAnamnesa->lamasakit = $lama[0];
      if (!empty($lama[1]))
        $modAnamnesa->satuanWaktu = $lama[1];
      
      //$modAnamnesa->riwayatimunisasi = $modPendaftaran->statuspasien;
      $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
      if (!empty($pegawai)) $modAnamnesa->paramedis_nama = $pegawai->nama_pegawai;
    } else {
      ////Jika Pasien Belum Pernah melakukan Anamnesa
      $modAnamnesa = new PIAnamnesaT;
      $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
      $modAnamnesa->ppds_id = isset($_POST['PIAnamnesaT']['ppds_id']) ? $_POST['PIAnamnesaT']['ppds_id'] : null;
      if (!empty($pegawai)) $modAnamnesa->paramedis_nama = $pegawai->nama_pegawai;
      $modAnamnesa->pegawai_id = $modPendaftaran->pegawai_id;
      $modAnamnesa->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $modAnamnesa->pasien_id = $modPendaftaran->pasien_id;
      $modAnamnesa->tglanamnesis = date('Y-m-d H:i:s');
      $modAnamnesa->statusmerokok = 0;
      $modAnamnesa->isbayianak_kelainanconginetal = "Tidak";
      $modAnamnesa->keb_konsumsialkohol = "Tidak";
      $modAnamnesa->riwayatperiksa_diagnosahiv = "Tidak";
      $modAnamnesa->ispasienwanitahamil = "Tidak";
      $modAnamnesa->ispasienwanitamenyusui = "Tidak";
      $modAnamnesa->keb_olahraga = "Tidak";

      //$isPasien = RIPendaftaranT::model()->findByPk($pendaftaran_id)->statuspasien;
      //                $sql = "SELECT c(diagnosa_id) FROM pasienimunisasi_t WHERE pendaftaran_id = $pendaftaran_id";
      //                $stoks = Yii::app()->db->createCommand($sql)->queryAll();

    }

    if ($modPendaftaran->statuspasien == "PENGUNJUNG LAMA") {
      $modDiagnosaTerdahulu = PIPasienMorbiditasT::model()->with('diagnosa')->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id, 'pendaftaran_id' => $lastPendaftaran));

      $hasilImunisasi = array();
      $hasilDiagnosaDahulu = array();
      foreach ($modDiagnosaTerdahulu as $row) {
        if ($row->diagnosa->diagnosa_imunisasi == true)
          $hasilImunisasi[] = $row->diagnosa->diagnosa_nama;
        else
          $hasilDiagnosaDahulu[] = $row->diagnosa->diagnosa_nama;
      }
      if (empty($modAnamnesa->riwayatimunisais)) {
        $modAnamnesa->riwayatimunisasi = implode(', ', $hasilImunisasi);
      }
      if (empty($modAnamnesa->riwayatpenyakitterdahulu)) {
        $modAnamnesa->riwayatpenyakitterdahulu = implode(', ', $hasilDiagnosaDahulu);
      }
    }

    // input baru 
    if (isset($_POST['PIAnamnesaT']) && isset($_GET['pendaftaran_id'])  && isset($_GET['pasienadmisi_id'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modAnamnesa->attributes = $_POST['PIAnamnesaT'];
        $modAnamnesa->lamasakit .= " " . $_POST['PIAnamnesaT']['satuanWaktu'];
        $modAnamnesa->keluhanutama = (isset($_POST['PIAnamnesaT']['keluhanutama'])) ? $_POST['PIAnamnesaT']['keluhanutama'] : '';
        $modAnamnesa->keluhantambahan = (isset($_POST['PIAnamnesaT']['keluhantambahan'])) ? $_POST['PIAnamnesaT']['keluhantambahan'] : '';
        $modAnamnesa->riwayatperjalananpasien = isset($_POST['PIAnamnesaT']['riwayatperjalananpasien']) ? $_POST['PIAnamnesaT']['riwayatperjalananpasien'] : null;
        $modAnamnesa->pasienadmisi_id = $_GET['pasienadmisi_id'];
        $modAnamnesa->ppds_id = $_POST['PIAnamnesaT']['ppds_id'];
        $modAnamnesa->create_time = date('Y-m-d H:i:s');
        $modAnamnesa->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modAnamnesa->create_loginpemakai_id = Yii::app()->user->id;
        $modAnamnesa->tglanamnesis = $format->formatDateTimeForDb($modAnamnesa->tglanamnesis);
        if (
          $modAdmisi->pegawai_id == Yii::app()->user->getState('pegawai_id')
          || $modAdmisi->dpjp2_id == Yii::app()->user->getState('pegawai_id')
          || $modAdmisi->dpjp3_id == Yii::app()->user->getState('pegawai_id')
        ) {
          $modAnamnesa->dokterverifikasi_id = $modAnamnesa->pegawai_id;
        }
        // $updateStatusPeriksa=PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
        if ($modAnamnesa->save()) {
          $transaction->commit();
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'sukses' => 1, 'id'=>$modAnamnesa->anamesa_id));
        } else {
          Yii::app()->user->setFlash('error', "Data anamnesa gagal disimpan " . CHtml::errorSummary($modAnamnesa));
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    // end input baru
    // update data
    if (isset($_POST['PIAnamnesaT']) && isset($_GET['pendaftaran_id']) && isset($_GET['pasienadmisi_id']) && isset($_GET['tglanamnesis'])) {
      $modAnamnesa->attributes = $_POST['PIAnamnesaT'];
      $modAnamnesa->keluhanutama = (isset($_POST['PIAnamnesaT']['keluhanutama'])) ? implode(', ', $_POST['PIAnamnesaT']['keluhanutama']) : '';
      $modAnamnesa->keluhantambahan = (isset($_POST['PIAnamnesaT']['keluhantambahan'])) ? implode(', ', $_POST['PIAnamnesaT']['keluhantambahan']) : '';
      $modAnamnesa->riwayatperjalananpasien = isset($_POST['PIAnamnesaT']['riwayatperjalananpasien']) ? $_POST['PIAnamnesaT']['riwayatperjalananpasien'] : null;
      $modAnamnesa->pasienadmisi_id = $_GET['pasienadmisi_id'];
      $modAnamnesa->ppds_id = $_POST['PIAnamnesaT']['ppds_id'];
      $modAnamnesa->update_time = date('Y-m-d H:i:s');
      $modAnamnesa->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modAnamnesa->update_loginpemakai_id = Yii::app()->user->id;

      if ($modAnamnesa->save()) {
        Yii::app()->user->setFlash('success', "Update Data Anamnesa Berhasil");
        $this->refresh();
      }
    }
    //end update data


    $modAnamnesa->tglanamnesis = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($modAnamnesa->tglanamnesis, 'yyyy-MM-dd hh:mm:ss')
    );

    $modDataDiagnosa = new PIDiagnosaM('searchDiagnosaAnamnesa');
    $modDataDiagnosa->unsetAttributes();
    // if(isset($_GET['RIDiagnosaM']))
    //     $modDataDiagnosa->attributes = $_GET['RIDiagnosaM'];

    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modPpds' => $modPpds,
      'modAnamnesa' => $modAnamnesa, 'modDiagnosa' => $modDiagnosa, 'modDataDiagnosa' => $modDataDiagnosa,
      'modAdmisi' => $modAdmisi, 'tabelAnamnesa' => $tabelAnamnesa, 'format' => $format
    ));
  }

  public function actionHapusRiwayatAnamnesa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idAnamnesa = (isset($_POST['anamesa_id']) ? $_POST['anamesa_id'] : null);
      $data['pesan'] = "";
      $data['sukses'] = 0;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $deleteAnamnesa = PIAnamnesaT::model()->deleteByPk($idAnamnesa);
        if ($deleteAnamnesa) {
          $data['pesan'] = "Riwayat Anamnesa Berhasil Dihapus!";
          $data['sukses'] = 1;
          $transaction->commit();
        } else {
          $data['pesan'] = "Gagal Menghapus Anamnesa";
          $data['sukses'] = 0;
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['pesan'] = "Hapus Data Gagal :" . MyExceptionMessage::getMessage($exc, true);
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }
  /**
   * @param type $pendaftaran_id
   */
  public function actionPrintAnamnesa($pendaftaran_id, $anamnesa_id = null)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = PIPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PIPasienM::model()->findByPk($modPendaftaran->pasien_id);

    if (!empty($anamnesa_id)) {
      $modAnamnesa = PIAnamnesaT::model()->findByPk($anamnesa_id);
    } else {
      $modAnamnesa = PIAnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    }

    $judul_print = 'ANAMNESIS';
    $this->render('printAnamnesa', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modAnamnesa' => $modAnamnesa,
    ));
  }

  public function actionAjaxDetailAnamnesa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idAnamnesis = $_POST['idAnamnesis'];
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $modPendaftaran = PIPendaftaranT::model()->findByPk($pendaftaran_id);
      $modAnamnesa = AnamnesaT::model()->findByPk($idAnamnesis);

      $data['result'] = $this->renderPartial('_viewDetailAnamnesa', array('modAnamnesa' => $modAnamnesa, 'modPendaftaran' => $modPendaftaran), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionMasterRiwayatPenyakitKelDari()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $lookup_type = 'penyakitkeldari';
      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(lookup_name)', strtolower($_GET['tag']), true);
      $criteria->compare('LOWER(lookup_type)', $lookup_type, true);
      $lookups = LookupM::model()->findAll($criteria);
      $data = array();
      foreach ($lookups as $i => $lookup) {
        $data[$i] = array(
          'key' => $lookup->lookup_name,
          'value' => $lookup->lookup_name
        );
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  public function actionMasterPenyakitMayor()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $lookup_type = 'penyakitmayor';
      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(lookup_name)', strtolower($_GET['tag']), true);
      $criteria->compare('LOWER(lookup_type)', $lookup_type, true);
      $lookups = LookupM::model()->findAll($criteria);
      $data = array();
      foreach ($lookups as $i => $lookup) {
        $data[$i] = array(
          'key' => $lookup->lookup_name,
          'value' => $lookup->lookup_name
        );
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  public function actionMasterStatusPsikologis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $lookup_type = 'statuspsikologis';
      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(lookup_name)', strtolower($_GET['tag']), true);
      $criteria->compare('LOWER(lookup_type)', $lookup_type, true);
      $lookups = LookupM::model()->findAll($criteria);
      $data = array();
      foreach ($lookups as $i => $lookup) {
        $data[$i] = array(
          'key' => $lookup->lookup_name,
          'value' => $lookup->lookup_name
        );
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  public function actionMasterNyeriHilangBila()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $lookup_type = 'nyerihilangbila';
      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(lookup_name)', strtolower($_GET['tag']), true);
      $criteria->compare('LOWER(lookup_type)', $lookup_type, true);
      $lookups = LookupM::model()->findAll($criteria);
      $data = array();
      foreach ($lookups as $i => $lookup) {
        $data[$i] = array(
          'key' => $lookup->lookup_name,
          'value' => $lookup->lookup_name
        );
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  public function actionMasterTempatTinggal()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $lookup_type = 'tempattinggal';
      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(lookup_name)', strtolower($_GET['tag']), true);
      $criteria->compare('LOWER(lookup_type)', $lookup_type, true);
      $lookups = LookupM::model()->findAll($criteria);
      $data = array();
      foreach ($lookups as $i => $lookup) {
        $data[$i] = array(
          'key' => $lookup->lookup_name,
          'value' => $lookup->lookup_name
        );
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }
}
