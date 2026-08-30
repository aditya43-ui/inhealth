<?php
class RencanaTindakanController extends MyAuthController
{
  protected $successSaveRencanaTindakan = true;
  protected $path_view = 'perawatanIntensif.views.rencanaTindakan.';

  public function actionIndex($pendaftaran_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Rencana Tindakan";
    $sukses = false;
    $format = new MyFormatter();
    $modInfoPasien = new PIInfopasienmasukkamarV;
    $modPendaftaran = new PIPendaftaranT;
    $modPasien = new PIPasienM;
    $modRencanaTindakan = new PIRencanatindakanT;
    $modTindakans = array();
    $modTindakan = new PITindakanPelayananT;
    $modRiwayatTindakans = array();
    $modAdmisi = new PIPasienAdmisiT;
    $modJenisTarif = new JenistarifpenjaminM;

    $modRencanaTindakan->tglperencanaan = date('Y-m-d H:i:s');

    if (!empty($pendaftaran_id)) {
      $modInfoPasien = PIInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      $modRiwayatTindakans = PIRencanatindakanT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'tglperencanaan DESC'));

      $criteria = new CDbCriteria;
      $criteria->addCondition('t.pendaftaran_id = ' . $pendaftaran_id);
      $criteria->addCondition('tindakanpelayanan_t.rencanatindakan_id is NULL');
      $criteria->order = 't.tglperencanaan DESC';
      $criteria->join = 'LEFT JOIN tindakanpelayanan_t ON tindakanpelayanan_t.rencanatindakan_id = t.rencanatindakan_id';

      $modRiwayatTindakans = PIRencanatindakanT::model()->findAll($criteria);
    }
    if (isset($_POST['PITindakanPelayananT']) || isset($_POST['PIRencanatindakanT'])) {
      $modRencanaTindakan = $this->saveRencanaTindakan($_POST['PIInfopasienmasukkamarV'], $_POST['PITindakanPelayananT'], $_POST['PIRencanatindakanT']);
      if ($this->successSaveRencanaTindakan) {
        $sukses = 1;
        $this->redirect(array('index', 'pendaftaran_id' => $modRencanaTindakan->pendaftaran_id, 'sukses' => $sukses));
      }
    }

    $this->render('index', array(
      'modInfoPasien' => $modInfoPasien,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modRencanaTindakan' => $modRencanaTindakan,
      'modTindakans' => $modTindakans,
      'modTindakan' => $modTindakan,
      'modRiwayatTindakans' => $modRiwayatTindakans,
      'modAdmisi' => $modAdmisi,
      'modJenisTarif' => $modJenisTarif,
      'format' => $format,
      'sukses' => $sukses
    ));
  }

  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_pendaftaran
   * - no_rekam_medik
   * - nama_pasien
   */
  public function actionAutocompleteInfoPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
      $criteria->addBetweenCondition("DATE(tglmasukkamar)", date("Y-m-d", strtotime("31 days")), date("Y-m-d"));
      $criteria->limit = 5;

      $models = PIInfopasienmasukkamarV::model()->findAll($criteria); //default
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
        $returnVal[$i]['value'] = $model->no_pendaftaran;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Mengurai data pasien berdasarkan:
   * - pendaftaran_id
   * - pasienadmisi_id
   * - no_pendaftaran
   * - no_rekam_medik
   * @throws CHttpException
   */
  public function actionGetDataInfoPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
      }
      if (!empty($pasienadmisi_id)) {
        $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
      }
      $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
      $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));
      $model = PIInfopasienmasukkamarV::model()->find($criteria);
      $modJenisTarif = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id' => $model->penjamin_id));
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      $returnVal["jenistarif_id"] = $modJenisTarif->jenistarif_id;
      $returnVal["jenistarif_nama"] = $model->penjamin_nama;
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * action ajax select tindakan ke form
   */
  public function actionDaftarTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (!isset($_GET['term'])) {
        $_GET['term'] = null;
      }
      $returnVal = array();
      $kelaspelayanan_id = (isset($_GET['kelaspelayanan_id']) ? $_GET['kelaspelayanan_id'] : null);
      $tipepaket_id = (isset($_GET['tipepaket_id']) ? $_GET['tipepaket_id'] : null);
      $penjamin_id = (isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null);

      $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $penjamin_id);
      if ($tipepaket_id == Params::TIPEPAKET_ID_LUARPAKET) {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
        if (Yii::app()->user->getState('tindakanruangan')) {
          $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
        }
        if (Yii::app()->user->getState('tindakankelas')) {
          if (!empty($kelaspelayanan_id)) {
            $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
          }
          $criteria->addCondition('tipepaket_id = ' . Params::TIPEPAKET_ID_LUARPAKET);
        }
        if (isset($_GET['daftartindakan_id'])) {
          if (!empty($_GET['daftartindakan_id'])) {
            $criteria->addCondition("daftartindakan_id = " . $_GET['daftartindakan_id']);
          }
        }
        if (!empty($kelaspelayanan_id)) {
          $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
        }
        $criteria->order = 'daftartindakan_nama';
        $models = PaketpelayananV::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->daftartindakan_nama;
          $returnVal[$i]['value'] = $model->daftartindakan_id;
        }

        echo CJSON::encode($returnVal);
      } else if ($tipepaket_id == Params::TIPEPAKET_ID_NONPAKET) {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
        if (!empty($kelaspelayanan_id)) {
          $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
        }
        if (!empty($penjamin_id)) {
          $criteria->addCondition("penjamin_id = " . $penjamin_id);
        }
        $criteria->order = 'daftartindakan_nama';

        if (isset($_GET['daftartindakan_id'])) {
          if (!empty($_GET['daftartindakan_id'])) {
            $criteria->addCondition("daftartindakan_id = " . $_GET['daftartindakan_id']);
          }
        }

        if (Yii::app()->user->getState('tindakankelas')) {
          if (!empty($kelaspelayanan_id)) {
            $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
          }
        }

        if (Yii::app()->user->getState('tindakanruangan')) {
          $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
          $models = TariftindakanperdaruanganV::model()->findAll($criteria);
        } else {
          $models = TariftindakanperdaV::model()->findAll($criteria);
        }
        $returnVal = array();
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->daftartindakan_nama;
          $returnVal[$i]['value'] = $model->daftartindakan_id;
        }

        echo CJSON::encode($returnVal);
      } else {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
        if (isset($_GET['daftartindakan_id'])) {
          if (!empty($_GET['daftartindakan_id'])) {
            $criteria->addCondition("daftartindakan_id = " . $_GET['daftartindakan_id']);
          }
        }

        if (Yii::app()->user->getState('tindakanruangan')) {
          $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
        }

        if (Yii::app()->user->getState('tindakankelas')) {
          if (!empty($kelaspelayanan_id)) {
            $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
          }
        }

        if (!empty($tipepaket_id)) {
          $criteria->addCondition("tipepaket_id = " . $tipepaket_id);
        }
        if (!empty($kelaspelayanan_id)) {
          $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
        }
        $criteria->order = 'daftartindakan_nama';
        $models = PaketpelayananV::model()->find($criteria);
        if (isset($models)) {
          foreach ($models as $i => $model) {
            $attributes = $model->attributeNames();
            foreach ($attributes as $j => $attribute) {
              $returnVal[$i]["$attribute"] = $model->$attribute;
            }
            $returnVal[$i]['label'] = $model->daftartindakan_nama;
            $returnVal[$i]['value'] = $model->daftartindakan_id;
          }
        }

        echo CJSON::encode($returnVal);
      }
    }
    Yii::app()->end();
  }

  /**
   * action ajax select dokter ke form
   */
  public function actionDaftarDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (!isset($_GET['term'])) {
        $_GET['term'] = null;
      }
      $returnVal = array();

      $pegawai_id = (isset($_GET['pegawai_id']) ? $_GET['pegawai_id'] : null);

      $criteria = new CDbCriteria();
      if (isset($pegawai_id)) {
        if (!empty($pegawai_id)) {
          $criteria->addCondition("pegawai_id = " . $pegawai_id);
        }
      }
      $models = PegawaiM::model()->find($criteria);
      if (isset($models)) {
        $attributes = $models->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal["$attribute"] = $models->$attribute;
        }
        $returnVal['label'] = $models->nama_pegawai;
        $returnVal['value'] = $models->pegawai_id;
        $returnVal['nama_pegawai'] = $models->NamaLengkap;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  protected function saveRencanaTindakan($modPendaftaran, $rencanaTindakan, $postRencana)
  {
    $format = new MyFormatter();
    $modRencanaTindakan = null;
    $valid = true;
    foreach ($rencanaTindakan as $i => $tindakan) {
      $modRencanaTindakan = new PIRencanatindakanT;
      $modRencanaTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modRencanaTindakan->daftartindakan_id = $tindakan['daftartindakan_id'];
      $modRencanaTindakan->pasien_id = $modPendaftaran['pasien_id'];
      $modRencanaTindakan->pendaftaran_id = $modPendaftaran['pendaftaran_id'];
      $modRencanaTindakan->tglperencanaan = $format->formatDateTimeForDb($postRencana['tglperencanaan']);
      $modRencanaTindakan->tglrencanatindakan = $format->formatDateTimeForDb($tindakan['tgl_tindakan']);
      $modRencanaTindakan->tarifsatuan = $tindakan['tarif_satuan'];
      $modRencanaTindakan->qty_rentindakan = $tindakan['qty_tindakan'];
      $modRencanaTindakan->tarif_tindakan = $modRencanaTindakan->tarifsatuan * $modRencanaTindakan->qty_rentindakan;
      $modRencanaTindakan->iscyto = $tindakan['cyto_tindakan'];
      $modRencanaTindakan->satuanrenctinda = $tindakan['satuantindakan'];
      $modRencanaTindakan->keteranganrentinda = $tindakan['keterangantindakan'];
      $modRencanaTindakan->ygmerencanakan_id = $postRencana['ygmerencanakan_id'];
      $modRencanaTindakan->pegawai_id = $tindakan['pegawai_id'];
      $modRencanaTindakan->create_time = date('Y-m-d H:i:s');
      $modRencanaTindakan->create_loginpemakai_id = Yii::app()->user->id;
      $modRencanaTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');

      $valid = $modRencanaTindakan->validate() && $valid;
      if ($valid) {
        $modRencanaTindakan->save();
        $this->successSaveRencanaTindakan = true;
      } else {
        $this->successSaveRencanaTindakan = false;
      }
    }
    return $modRencanaTindakan;
  }

  /**
   * set tabel riwayat kunjungan pasien
   */
  public function actionSetRiwayatRencanaTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data['table'] = "";
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $pasien_id = $_POST['pasien_id'];

      $criteria = new CDbCriteria;
      $criteria->addCondition('t.pendaftaran_id = ' . $pendaftaran_id);
      $criteria->addCondition('t.pasien_id = ' . $pasien_id);
      $criteria->addCondition('tindakanpelayanan_t.rencanatindakan_id is NULL');
      $criteria->order = 't.tglperencanaan DESC';
      $criteria->join = 'LEFT JOIN tindakanpelayanan_t ON tindakanpelayanan_t.rencanatindakan_id = t.rencanatindakan_id';

      $modRiwayatTindakans = PIRencanatindakanT::model()->findAll($criteria);

      $data['table'] = $this->renderPartial('_tableRiwayatTindakan', array(
        'modRiwayatTindakans' => $modRiwayatTindakans,
        'format' => $format,
        'frame' => 1,
      ), true);
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * untuk print data rencana tindakan
   */
  public function actionPrint($pendaftaran_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $criteria = new CDbCriteria;
    $criteria->addCondition('t.pendaftaran_id = ' . $pendaftaran_id);
    $criteria->addCondition('tindakanpelayanan_t.rencanatindakan_id is NULL');
    $criteria->order = 't.tglperencanaan DESC';
    $criteria->join = 'LEFT JOIN tindakanpelayanan_t ON tindakanpelayanan_t.rencanatindakan_id = t.rencanatindakan_id';

    $modRencanaTindakan = PIRencanatindakanT::model()->findAll($criteria);
    $modInfoPasien = PIInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $judul_print = 'Rencana Tindakan Pasien';

    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render('Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modRencanaTindakan' => $modRencanaTindakan,
      'modInfoPasien' => $modInfoPasien,
      'caraPrint' => $caraPrint
    ));
  }
}
