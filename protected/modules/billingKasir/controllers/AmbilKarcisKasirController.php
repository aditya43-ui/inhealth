<?php

class AmbilKarcisKasirController extends Controller
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';

  public $path_view = 'billingKasir.views.pembayaranTagihanPasien.';

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionIndex($id = null)
  {
    $model = new BKAntrianT;
    $model->noantrian = "Otomatis";
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $format = new MyFormatter();
    $modKunjungan = new BKInformasikasirinappulangV;
    $modKunjungan->instalasi_id = Params::INSTALASI_ID_RJ;



    if (!empty($id)) {
      $model = BKAntrianT::model()->findByPk($id);
    }
    if (isset($_POST['BKAntrianT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['BKAntrianT'];

        $model->tglantrian = date('Y-m-d H:i:s');
        $model->noantrian = MyGenerator::noAntrianKasir($model->ruangan_id);
        $model->carabayar_id = isset($_POST['carabayar_id']) ? $_POST['carabayar_id'] : 1;
        $model->pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
        $model->profilrs_id = Params::getDefaultProfilRS();


        if ($model->save()) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data nomor antrian " . $model->noantrian . " berhasil disimpan!");
          $this->redirect(array('index', 'id' => $model->antrian_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data tindakan gagal disimpan!");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $sukses = 0;
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('index', array(
      'model' => $model,
      'modKunjungan' => $modKunjungan,
      'format' => $format,
    ));
  }


  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'ambilkarciskasir-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mengurai data kunjungan berdasarkan:
   * - instalasi_id
   * - pendaftaran_id
   * - pasienadmisi_id
   * - no_pendaftaran
   * - no_rekam_medik
   * @throws CHttpException
   */
  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('pendaftaran_id', $pendaftaran_id);
      $criteria->compare('pasienadmisi_id', $pasienadmisi_id);
      $criteria->compare('instalasi_id', $instalasi_id);
      $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
      $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));
      if ($instalasi_id == Params::INSTALASI_ID_RJ) {
        $model = BKInformasikasirrawatjalanV::model()->find($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
        $model = BKInformasikasirrdpulangV::model()->find($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RI) {
        $model = BKInformasikasirinappulangV::model()->find($criteria);
      }

      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      //load uang muka
      $crit_uangmuka = new CDbCriteria();
      $crit_uangmuka->compare('pendaftaran_id', $model->pendaftaran_id);
      $crit_uangmuka->compare('pasienadmisi_id', (isset($model->pasienadmisi_id) ? $model->pasienadmisi_id : null));
      $crit_uangmuka->addCondition("pemakaianuangmuka_id IS NULL");
      $crit_uangmuka->select = "sum(jumlahuangmuka) as jumlahuangmuka";
      $modUangMuka = BKBayaruangmukaT::model()->find($crit_uangmuka);
      $returnVal["jumlahuangmuka"] = (isset($modUangMuka->jumlahuangmuka) ? $modUangMuka->jumlahuangmuka : 0);
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * actionPrintKwPenjualanResep digunakan untuk print karcis antrian
   * @param type $id
   */
  public function actionPrintKarcisKasir($id, $caraprint = null)
  {
    $this->layout = '//layouts/iframe';
    if ($caraprint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    }
    $format = new MyFormatter();
    $modAntrian = BKAntrianT::model()->findByPk($id);
    $judulLaporan = 'Antrian Kasir';

    $this->render('_printRincianKarcis', array('format' => $format, 'modAntrian' => $modAntrian, 'judulLaporan' => $judulLaporan));
  }
}
