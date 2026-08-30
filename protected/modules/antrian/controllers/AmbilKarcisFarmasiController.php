
<?php

class AmbilKarcisFarmasiController extends Controller
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/mainNeonSidebar';
  public $defaultAction = 'index';

  public $path_view = 'antrian.views.ambilKarcisFarmasi.';

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionIndex($id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Ambil Karcis Farmasi";
    $model = new ANAntrianfarmasiT;
    $model->noantrian = "Otomatis";

    if (!empty($id)) {
      $model = ANAntrianfarmasiT::model()->findByPk($id);
    }
    if (isset($_POST['ANAntrianfarmasiT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $format = new MyFormatter();
        $model->attributes = $_POST['ANAntrianfarmasiT'];
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->tglambilantrian = date('Y-m-d H:i:s');
        $model->noantrian = MyGenerator::noAntrianFarmasi($model->racikan_id);
        $model->panggilantrian = false;
        $model->antrianlewat = false;
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if (((int)$model->noantrian) == 1) {
          $model->tglakandilayani = $model->tglambilantrian;
        } else {

          $racikan = RacikanM::model()->findByPk($model->racikan_id);
          $estimasi = $racikan->estimasiantrian;

          $cr = new CDbCriteria();
          $cr->order = 'antrianfarmasi_id desc';
          $cr->compare('racikan_id', $model->racikan_id);
          $cr->addCondition("tglambilantrian::date = current_date");

          $terakhir = ANAntrianfarmasiT::model()->find($cr);

          $tgl_dilayani = new DateTime($terakhir->tglakandilayani);
          $tgl_antrian = new DateTime($model->tglambilantrian);

          if ($tgl_dilayani < $tgl_antrian) {
            $tgl_antrian->add(new DateInterval("PT" . $estimasi . "M"));
            $model->tglakandilayani = $tgl_antrian->format('Y-m-d H:i:s');
          } else {
            $tgl_dilayani->add(new DateInterval("PT" . $estimasi . "M"));
            $model->tglakandilayani = $tgl_dilayani->format('Y-m-d H:i:s');
          }
        }

        if ($model->save()) {
          $transaction->commit();
          $this->redirect(array('index', 'id' => $model->antrianfarmasi_id, 'sukses' => 1));
        }
        $transaction->rollback();
      } catch (Exception $exc) {
        $transaction->rollback();
        $sukses = 0;
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
    ));
  }

  /**
   * actionPrintKwPenjualanResep digunakan untuk print karcis antrian
   * @param type $id
   */
  public function actionPrintKarcisFarmasi($id, $caraprint = null)
  {
    $this->layout = '//layouts/iframe';
    if ($caraprint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    }
    $format = new MyFormatter();
    $modAntrian = ANAntrianfarmasiT::model()->findByPk($id);
    $judulLaporan = 'Antrian Farmasi';

    $this->render($this->path_view . 'PrintKarcisFarmasi', array('format' => $format, 'modAntrian' => $modAntrian, 'judulLaporan' => $judulLaporan));
  }
}
