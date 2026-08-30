<?php

class AmbilTiketLabController extends Controller
{
  public $layout = '//layouts/kiosAntrian';

  public $pathView = 'antrian.views.ambilTiketLab.';

  public function actionIndex($lokasiantrian_id)
  {
    $criteria = new CdbCriteria();
    $criteria->addCondition('lokasi_karcisantrian_id = ' . $lokasiantrian_id);
    $criteria->addCondition('modelantrian_aktif = true');
    $criteria->order = 'modelantrian_singkatan';
    // var_dump($criteria); die;
    $modLokets = ModelantrianM::model()->findAll($criteria);
    //var_dump(count((array)$modLokets)); die;
    $lokasiAntrian = LokasiKarcisantrianM::model()->findByPk($lokasiantrian_id);
    $model = new ANAntrianT;



    $this->render($this->pathView . 'index', array('model' => $model, 'modLokets' => $modLokets, 'lokasiAntrian' => $lokasiAntrian));
  }
  /**
   * untuk menyimpan tiket (ajax)
   */
  public function actionSimpanTiket()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = array();
      $data['pesan'] = "Data gagal disimpan! ";
      if (isset($_POST['data'])) {
        parse_str($_POST['data'], $post);


        $model = new ANAntrianT;
        $model->attributes = $post['ANAntrianT'];
        $model->profilrs_id = Params::getDefaultProfilRS();
        $model->ruangan_id = Params::DEFAULT_RUANGAN_KIOSK;

        $modelAntrian = ModelantrianM::model()->findByPk($model->modelantrian_id);

        // var_dump(MyGenerator::noModelAntrianLoket($model->modelantrian_id, $modelAntrian->modelantrian_formatnomor)); die;

        $model->tglantrian = date('Y-m-d H:i:s');
        $model->noantrian = (empty($model->noantrian) ? MyGenerator::noModelAntrianLoket($model->modelantrian_id, $modelAntrian->modelantrian_formatnomor) : $model->noantrian);
        $delaytombol = $this->actionGetDelayTombolAntrian();
        // var_dump($model->attributes, $model->validate(), $model->errors); die;
        if ($model->validate()) {
          $model->save();
          $data['model'] = $model;
          $data['delaytombol'] = $delaytombol;
          $data['pesan'] = "Data berhasil disimpan!";
        } else {
          $data['pesan'] = "Data gagal disimpan! " . CHtml::errorSummary($model);
        }
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }

  public function actionPrint($antrian_id)
  {
    $modAntrian = ANAntrianT::model()->findByPk($antrian_id);
    $this->layout = '//layouts/printWindows';
    $this->render($this->pathView . 'printNoAntrian', array('modAntrian' => $modAntrian));
  }

  public function actionGetRunningText()
  {
    //konfig tidak ngambil dari session (state) karena tidak ada login untuk controller ini
    $konfig = KonfigsystemK::model()->find();

    $text = $konfig->running_text_kiosk;

    echo json_encode($text);
  }

  public function actionGetDelayTombolAntrian()
  {
    //konfig tidak ngambil dari session (state) karena tidak ada login untuk controller ini
    $konfig = KonfigsystemK::model()->find();

    $delaytombol = $konfig->delaytombolantrian;

    return $delaytombol;
  }
}
