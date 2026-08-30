<?php

class VerifikasiBerkasMcuController extends MyAuthController
{
  protected $verifikasiberkastersimpan = false;
  public $path_view = 'keuangan.views.verifikasiBerkasMcu.';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new KUVerifikasiberkasmcuT();
    $modVerifikasi = new KUVerifikasiberkasmcuV;
    $modPasien = new KUPasienM;
    $modPendaftaran = new KUPendaftaranT();

    $model->tglberkasmcumasuk = date('Y-m-d H:i:s');
    $model->tgljatuhtempo = date('Y-m-d H:i:s');
    $model->tglsurat_rs = date('Y-m-d H:i:s');
    $model->noverifkasiberkasmcu = 'Otomatis';

    if (isset($_POST['KUVerifikasiberkasmcuT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['KUVerifikasiberkasmcuT'];
        $model->noverifkasiberkasmcu = MyGenerator::noVerifikasiBerkasMcu();
        $model->tglberkasmcumasuk = $format->formatDateTimeForDb($_POST['KUVerifikasiberkasmcuT']['tglberkasmcumasuk']);
        $model->petugasverifikasi_id = $_POST['KUVerifikasiberkasmcuT']['petugasverifikasi_id'];

        foreach ($_POST['KUVerifikasiberkasmcuV'] as $i => $data) {
          $modDetails = $this->simpanVerifikasi($model, $_POST['KUVerifikasiberkasmcuT'], $data);
        }

        if ($this->verifikasiberkastersimpan) {
          $transaction->commit();
          $this->redirect(array('index', 'noverifkasiberkasmcu' => $model->noverifkasiberkasmcu, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data verifikasi berkas mcu gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
          . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
          . "</a>";
        Yii::app()->user->setFlash('error', "Data verifikasi berkas mcu gagal disimpan ! " . $btn_ulang . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('index', array(
      'model' => $model,
      'modVerifikasi' => $modVerifikasi,
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran
    ));
  }

  /**
   * proses simpan detail verifikasi berkas mcu
   */
  public function simpanVerifikasi($modVerifikasi, $postVerifikasi, $postDetail)
  {
    $format = new MyFormatter();

    $noverifkasiberkasmcu = $modVerifikasi->noverifkasiberkasmcu;
    $model = new KUVerifikasiberkasmcuT();
    $model->pendaftaran_id = $postDetail['pendaftaran_id'];
    $model->ruangan_id = $postDetail['ruangan_id'];
    $model->pasien_id = $postDetail['pasien_id'];
    $model->noverifkasiberkasmcu = $noverifkasiberkasmcu;
    $model->tglverifikasiberkasmcu = isset($postDetail['tglverifikasiberkasmcu']) ? $format->formatDateTimeForDb($postDetail['tglverifikasiberkasmcu']) : date('Y-m-d H:i:s)');
    $model->tglberkasmcumasuk = $modVerifikasi->tglberkasmcumasuk;
    $model->tgljatuhtempo = isset($postDetail['tgljatuhtempo']) ? $format->formatDateTimeForDb($postDetail['tgljatuhtempo']) : null;
    $model->tglsurat_rs = isset($postDetail['tglsurat_rs']) ? $format->formatDateTimeForDb($postDetail['tglsurat_rs']) : date('Y-m-d H:i:s)');
    $model->nosurat_rs = $postDetail['nosurat_rs'];
    $model->namarumahsakit = $postDetail['rumahsakitrujukan'];
    $model->berkas_1 = $postDetail['berkas_1'];
    $model->berkas_2 = $postDetail['berkas_2'];
    $model->berkas_3 = $postDetail['berkas_3'];
    $model->berkas_4 = $postDetail['berkas_4'];
    $model->berkas_5 = $postDetail['berkas_5'];
    $model->statusverifikasiberkas = $postDetail['statusverifikasiberkas'];
    $model->totaltagihanmcu = $postDetail['tagihan'];
    $model->create_time = date('Y-m-d H:i:s');
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($model->save()) {
      $this->verifikasiberkastersimpan = true;
    } else {
      $this->verifikasiberkastersimpan = false;
    }
    return $model;
  }

  public function actionAutocompletePetugasVerifikasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->NamaLengkap;
        $returnVal[$i]['value'] = $model->NamaLengkap;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
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
      $criteria->addCondition('ruangan_id = ' . Params::RUANGAN_ID_KLINIK_MCU);
      $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
      $criteria->limit = 5;

      $models = InfokunjunganrjV::model()->findAll($criteria);

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
   * - no_pendaftaran
   * - no_rekam_medik
   * @throws CHttpException
   */
  public function actionGetDataInfoPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
      }

      $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
      $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));
      $criteria->addCondition('ruangan_id = ' . Params::RUANGAN_ID_KLINIK_MCU);
      $model = KUInfokunjunganrjV::model()->find($criteria);
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * menampilkan data verifikasi
   * @return row table 
   */
  public function actionLoadFormVerifikasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $form = '';
      $pesan = '';
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;

      $format = new MyFormatter();
      $modVerifikasi = new KUVerifikasiberkasmcuV;

      $criteria = new CDbCriteria();
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
      }
      if (!empty($no_pendaftaran)) {
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      }
      if (!empty($no_rekam_medik)) {
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      }
      $criteria->addCondition('DATE(tglberkasmcumasuk) is Null');
      $model = KUVerifikasiberkasmcuV::model()->findAll($criteria);

      if (count((array)$model) > 0) {

        foreach ($model as $i => $data) {
          $modVerifikasi->pendaftaran_id = $data->pendaftaran_id;
          $modVerifikasi->pasien_id = $data->pasien_id;
          $modVerifikasi->ruangan_id = $data->ruangan_id;
          $modVerifikasi->no_pendaftaran = $data->no_pendaftaran;
          $modVerifikasi->no_rekam_medik = $data->no_rekam_medik;
          $modVerifikasi->ruangan_nama = $data->ruangan_nama;
          $modVerifikasi->nama_pasien = $data->nama_pasien;
          $modVerifikasi->rumahsakitrujukan = $data->rumahsakitrujukan;
          $modVerifikasi->pendaftaran_id = $data->pendaftaran_id;
          $modVerifikasi->tagihan = $data->tagihan;

          $form .= $this->renderPartial($this->path_view . '_rowVerifikasi', array('modVerifikasi' => $modVerifikasi), true);
        }
      } else {
        $pesan = "Berkas sudah Diverifikasi!";
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  /**
   * menampilkan form verifikasi berkas
   * @return row table 
   */
  public function actionLoadFormVerifikasiBerkas()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $this->layout = '//layouts/iframe';
      $form = '';
      $namarumahsakit = isset($_POST['namarumahsakit']) ? $_POST['namarumahsakit'] : null;
      $totaltagihan = isset($_POST['totaltagihan']) ? $_POST['totaltagihan'] : "";

      $format = new MyFormatter();
      $modPendaftaran = new KUPendaftaranT();
      $modPasien = new KUPasienM;
      $model = new KUVerifikasiberkasmcuT;
      $model->namarumahsakit = $namarumahsakit;
      $model->totaltagihanmcu = $totaltagihan;
      $model->tglberkasmcumasuk = date('Y-m-d H:i:s');
      $model->tglverifikasiberkasmcu = date('Y-m-d H:i:s');

      $form = $this->renderPartial($this->path_view . '_formVerifikasi', array('model' => $model, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien), true);

      echo CJSON::encode(array('form' => $form));
      exit;
    }
  }

  /**
   * menampilkan tgl jatuh tempo berdasarkan konfigurasi
   * @return row table 
   */
  public function actionSetJatuhTempo()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = '';
      $format = new MyFormatter();
      $konfig = KonfigsystemK::model()->find();
      $konfig_jatuhtempo = isset($konfig) ? $konfig->jatuhtempotagihan : null;

      $status = isset($_POST['status']) ? $_POST['status'] : null;
      $tglverifikasi = isset($_POST['tglverifikasi']) ? $format->formatDateTimeForDb($_POST['tglverifikasi']) : null;
      $tgl = strtotime($tglverifikasi . ' + ' . $konfig_jatuhtempo . ' days');
      $tgl_jatuhtempo = date('Y-m-d H:i:s', $tgl);

      if ($status == 'DITERIMA') {
        $data['tgl_jatuhtempo'] = date('d/m/Y H:i:s', strtotime($tgl_jatuhtempo));
      } else {
        $data['tgl_jatuhtempo'] = '';
      }

      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }

  /**
   * menampilkan data verifikasi ke tabel
   * @return row table 
   */
  public function actionSetDataVerifikasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = '';
      $format = new MyFormatter();

      $model = new KUVerifikasiberkasmcuT;
      $model->attributes = $_POST['KUVerifikasiberkasmcuT'];
      $model->berkas_1 = ($_POST['KUVerifikasiberkasmcuT']['berkas_1'] == 1) ? 'Ya' : '';
      $model->berkas_2 = ($_POST['KUVerifikasiberkasmcuT']['berkas_2'] == 1) ? 'Ya' : '';
      $model->berkas_3 = ($_POST['KUVerifikasiberkasmcuT']['berkas_3'] == 1) ? 'Ya' : '';
      $model->tglsurat_rs = date('d/m/Y H:i:s');
      $data = $model->attributes;

      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }
}
