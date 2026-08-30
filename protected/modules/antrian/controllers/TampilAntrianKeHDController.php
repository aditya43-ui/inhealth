<?php
class TampilAntrianKeHDController extends Controller
{
  public $layout = '//layouts/antrian';
  public $defaultAction = 'index';

  public function actionIndex($layarantrian_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Tampil Antrian Ke Hemodialisa";
    $format = new MyFormatter();
    $modLayar = ANLayarantrianM::model()->findByPk($layarantrian_id);
    $konfig = KonfigsystemK::model()->find();
    $modRuangan = new ANLayarruanganM;
    $modRuangans = array();
    if (!empty($modLayar)) {
      $modRuangans = $modRuangan->getRuanganAntrian($modLayar);
    }

    $model = new PasienmasukpenunjangV();
    //        $modRuangans = ANRuanganM::getRuanganAntrian($modLayar->layarantrian_maksitem,Params::INSTALASI_ID_RJ);

    $this->render('index', array(
      'format' => $format,
      'model' => $model,
      'modLayar' => $modLayar,
      'modRuangans' => $modRuangans,
      'konfig' => $konfig,
    ));
  }

  /**
   * get nilai antrian
   * @throws CHttpException
   */
  public function actionGetAntrians()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $layarantrian_id = (isset($_POST['layarantrian_id']) ? $_POST['layarantrian_id'] : null);
      $modLayar = ANLayarantrianM::model()->findByPk($layarantrian_id);
      $modRuangan = new ANLayarruanganM;
      $modRuangans = $modRuangan->getRuanganAntrian($modLayar);

      if (!empty($modRuangans) > 0) {
        foreach ($modRuangans as $r => $ruangan) {
          $modKunjungan = $this->loadModelAntrian($ruangan->ruangan_id);
          if (isset($_POST['pasienmasukpenunjang_id']) && $_POST['pasienmasukpenunjang_id'] != '') {
            $modKunjungan = $this->loadModelAntrianById($ruangan->ruangan_id, $_POST['pasienmasukpenunjang_id']);
          }
          if (isset($modKunjungan)) {
            $attributes = $modKunjungan->attributeNames();
            foreach ($attributes as $i => $attribute) {
              $data["r_" . $ruangan->ruangan_id]["$attribute"] = $modKunjungan->$attribute;
            }
          }
        }
      }

      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
  /**
   * cari antrian berdasarkan statuspasien
   * @return \ANAntrianT
   */
  protected function loadModelAntrian($ruangan_id)
  {
    $criteria = new CDbCriteria();
    $criteria->compare("DATE(tglmasukpenunjang)", date("Y-m-d"));
    $criteria->addCondition("panggilantrian = TRUE");
    $criteria->addCondition("ruangan_id = " . $ruangan_id);
    $criteria->order = "no_urutperiksa DESC"; //panggil terakhir
    $criteria->limit = 1;
    $model = PasienmasukpenunjangV::model()->find($criteria);
    if (!isset($model)) {
      $model = new PasienmasukpenunjangV;
    }
    return $model;
  }
  /**
   * cari antrian berdasarkan statuspasien
   * @return \ANAntrianT
   */
  protected function loadModelAntrianById($ruangan_id, $pasienmasukpenunjang_id)
  {
    $criteria = new CDbCriteria();
    // $criteria->compare("DATE(tglmasukpenunjang)",date("Y-m-d"));
    // $criteria->addCondition("panggilantrian = TRUE");
    $criteria->addCondition("ruangan_id = " . $ruangan_id);
    $criteria->addCondition("pasienmasukpenunjang_id = " . $pasienmasukpenunjang_id);
    $criteria->order = "no_urutperiksa DESC"; //panggil terakhir
    $criteria->limit = 1;
    $model = PasienmasukpenunjangV::model()->find($criteria);
    if (!isset($model)) {
      $model = new PasienmasukpenunjangV;
    }
    return $model;
  }
  /**
   * suara panggilan SINGLE no antrian (array)
   * akses dengan iframe
   */
  public function actionSuaraPanggilanSingle()
  {
    $this->layout = "//layouts/antrian";
    $kodeantrian = $_GET["kodeantrian"];
    $noantrian = $_GET["noantrian"];
    $ruangan_id = $_GET["ruangan_id"];
    $modRuangan = RuanganM::model()->findByPk($ruangan_id);
    $this->render('suaraPanggilanSingle', array('kodeantrian' => $kodeantrian, 'noantrian' => $noantrian, 'modRuangan' => $modRuangan));
  }
}
