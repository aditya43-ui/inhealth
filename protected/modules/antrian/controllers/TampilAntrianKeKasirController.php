<?php
class TampilAntrianKeKasirController extends Controller
{
  public $layout = '//layouts/antrian';
  public $defaultAction = 'index';

  public function actionIndex($layarantrian_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Tampil Antrian Ke Kasir";
    $layout = '//layouts/antrian_baru';
    $format = new MyFormatter();
    $model = new ANAntrianT();
    $konfig = KonfigsystemK::model()->find();
    $criteria = new CdbCriteria;
    $criteria->addCondition("loket_aktif = true AND iskasir = TRUE");
    $criteria->order = "loket_nourut ASC";
    $modLokets = ANLoketM::model()->findAll($criteria);
    $modModels = ModelantrianM::model()->findAll("modelantrian_singkatan in ('K') and modelantrian_aktif = true order by modelantrian_id asc");
    $modProfile = ProfilrumahsakitM::model()->findByPk(1);
    $this->render('index', array(
      'format' => $format,
      'model' => $model,
      'modLokets' => $modLokets,
      'modModels' => $modModels,
      'konfig' => $konfig,
      'modProfile' => $modProfile,
    ));
  }

  /**
   * get nilai antrian
   * @throws CHttpException
   */
  public function actionGetAntrians()
  {
    //if(Yii::app()->request->isAjaxRequest)
    //{
    $format = new MyFormatter();
    $data = array();

    $modLokets = ANLoketM::model()->findAll('iskasir = TRUE AND loket_aktif = TRUE');
    if (count((array)$modLokets) > 0) {
      foreach ($modLokets as $i => $loket) {
        $modAntrian = $this->loadModelAntrian($loket->loket_id);
        $modJumlah = $this->loadDataStatistik($loket->loket_id);
        if ($modAntrian) {
          if (isset($_POST['antrian_id']) && $_POST['antrian_id'] != '') {
            $modAntrian = $this->loadModelAntrianById($loket->loket_id, $_POST['antrian_id']);
            $modModel = ModelantrianM::model()->findByPk($loket->modelantrian_id);
            $modJumlah = $this->loadDataStatistik($modModel->modelantrian_id);
          }
          if (!empty($modAntrian)) {
            $data["an_" . $i] = $modAntrian->attributes;
            $data["an_" . $i] += $loket->attributes;
            $data["an_" . $i] += $modModel->attributes;
            $data["an_" . $i] += $modJumlah;
          }
        }
      }
    }

    echo CJSON::encode($data);
    Yii::app()->end();
    //}
    //else
    //throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
  }

  /**
   * cari antrian berdasarkan loket_id
   * @return \ANAntrianT
   */
  protected function loadModelAntrian($loket_id)
  {
    $criteria = new CDbCriteria();
    $criteria->compare("DATE(tglantrian)", date("Y-m-d"));
    $criteria->addCondition("pendaftaran_id IS NULL");
    $criteria->addCondition("panggil_flaq = TRUE");
    $criteria->addCondition("loket_id = " . $loket_id);
    $criteria->order = "loket_id DESC, noantrian DESC"; //panggil terakhir
    $model =  ANAntrianT::model()->find($criteria);
    return $model;
  }

  /**
   * cari antrian berdasarkan loket_id
   * @return \ANAntrianT
   */
  protected function loadModelAntrianById($loket_id, $antrian_id)
  {
    $criteria = new CDbCriteria();
    $criteria->compare("DATE(tglantrian)", date("Y-m-d"));
    $criteria->addCondition("pendaftaran_id IS NULL");
    $criteria->compare("loket_id", $loket_id);
    $criteria->compare("antrian_id", $antrian_id);
    $criteria->order = "loket_id DESC, noantrian DESC"; //panggil terakhir
    $model =  ANAntrianT::model()->find($criteria);
    return $model;
  }

  /**
   * suara panggilan MULTI no antrian (array) dan loket (array)
   * akses dengan ajax
   */
  public function actionSuaraPanggilan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $this->layout = "//layouts/iframe";
      $noantrians = $_POST["noantrians"];
      $loket_ids = $_POST["loket_ids"];
      $modLokets = array();
      if (count((array)$loket_ids) >  0) {
        foreach ($loket_ids as $i => $loket_id) {
          $modLokets[$i] = ANLoketM::model()->findByPk($loket_id);
        }
      }
      $data["suarapanggilan"] = $this->renderPartial('suaraPanggilan', array('noantrians' => $noantrians, 'modLokets' => $modLokets), true);
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  public function actionUpdateStatistik()
  {
    $format = new MyFormatter();
    $data = array();

    if (isset($_POST['loket_id'])) {
      $modJumlah = $this->loadDataStatistik($_POST['loket_id']);
    }

    echo CJSON::encode(array('stat' => $modJumlah));
    Yii::app()->end();
  }

  protected function loadDataStatistik($loket_id)
  {
    $default = '000';
    $data['jmlpasien'] = 0;
    $data['jmlmenunggu'] = 0;
    $data['jmlterdaftar'] = 0;

    $criteria = new CDbCriteria();
    $criteria->compare("DATE(tglantrian)", date("Y-m-d"));
    $criteria->addCondition("modelantrian_id = " . $loket_id);
    $criteria->order = "modelantrian_id DESC, noantrian DESC"; //panggil terakhir
    $models =  ANAntrianT::model()->findAll($criteria);

    if (count((array)$models) > 0) {
      foreach ($models as $i => $model) {
        $data['jmlpasien'] += 1;
        if (!empty($model->pendaftaran_id)) {
          $data['jmlterdaftar'] += 1;
        }
      }
    }

    //start RSPMC-625
    $criteriaMenunggu = new CDbCriteria();
    $criteriaMenunggu->compare("DATE(tglantrian)", date("Y-m-d"));
    $criteriaMenunggu->addCondition("loket_id = " . $loket_id);
    $criteriaMenunggu->addCondition("panggil_flaq = FALSE");
    $criteriaMenunggu->order = "loket_id DESC, noantrian DESC"; //panggil terakhir
    $modelsMenunggu =  ANAntrianT::model()->findAll($criteriaMenunggu);
    $jmlmenunggu = 0;
    if (count((array)$modelsMenunggu) > 0) {
      foreach ($modelsMenunggu as $i => $model) {
        $jmlmenunggu += 1;
      }
    }
    //end RSPMC-625

    //		$jmlmenunggu = $data['jmlpasien'] - $data['jmlterdaftar'];
    $data['jmlpasien'] = (isset($data['jmlpasien']) ? (str_pad($data['jmlpasien'], strlen($default), 0, STR_PAD_LEFT)) : $default);
    $data['jmlterdaftar'] = (isset($data['jmlterdaftar']) ? (str_pad($data['jmlterdaftar'], strlen($default), 0, STR_PAD_LEFT)) : $default);
    $data['jmlmenunggu'] = str_pad(($data['jmlpasien'] - $data['jmlterdaftar']), strlen($default), 0, STR_PAD_LEFT);
    return $data;
  }
}
