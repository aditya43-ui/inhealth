<?php

/**
 *   - digunakan sebagai url utama untuk mengelola transaksi Proses Inspeksi
 *   @author	Rusdiyanto <rusdiyanto@.com>
 *   @website	<.com>
 */
class ProsesInspeksiController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'sterilisasi.views.prosesInspeksi.';

  public function actionIndex($pembersihan_id)
  {
    $model = new InspeksiinstrumenT();
    $modPembersihanSearch = new PembersihanT();
    $modPembersihanSearch->tgl_awal = date('Y-m-d H:i:s');
    $modPembersihanSearch->tgl_akhir = date('Y-m-d H:i:s');

    if (!empty($pembersihan_id)) {
      $modPembersihan = STPembersihanT::model()->findByAttributes(array('pembersihan_id' => $pembersihan_id));
    }

    if (isset($_POST['InspeksiinstrumenT'])) {
      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['InspeksiinstrumenT'];
        if (isset($pembersihan_id)) {
          $model->pembersihan_id = $pembersihan_id;
        }
        $model->create_loginpemakai_id  = Yii::app()->user->getState('loginpemakai_id');
        $model->create_ruangan  = Yii::app()->user->getState('ruangan_id');
        $model->create_time  = date('Y-m-d H:i:s');


        $ok = $ok && $model->save();

        $dekon = DekontaminasiT::model()->findByPk($modPembersihan->dekontaminasi_id);
        $det = DekontaminasidetailT::model()->findAllByAttributes(array(
          'dekontaminasi_id' => $dekon->dekontaminasi_id,
        ));

        foreach ($det as $item) {
          PenerimaansterilisasidetT::model()->updateByPk($item->penerimaansterilisasidet_id, array(
            'keadaanperalatan' => 'BERSIH',
          ));
        }


        // vaR_dump($dekon->attributes, $modPembersihan->attributes, $model->attributes); die;

        if ($ok) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data " . $model->pembersihan->no_pembersihan . " Berhasil Disimpan");
          $this->redirect(array('index', 'pembersihan_id' => $pembersihan_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modPembersihan' => $modPembersihan,
      'modPembersihanSearch' => $modPembersihanSearch
    ));
  }

  public function actionPencarianPembersihanView()
  {
    if (Yii::app()->request->isAjaxRequest) {
      parse_str($_REQUEST['data'], $data_parsing);
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      if (isset($data_parsing['PembersihanT'])) {
        $tgl_awal = $format->formatDateTimeForDb($data_parsing['PembersihanT']['tgl_awal']);
        $tgl_akhir = $format->formatDateTimeForDb($data_parsing['PembersihanT']['tgl_akhir']);
      }
      $criteria = new CDbCriteria();
      $criteria->addBetweenCondition('DATE(tgl_pembersihan)', $tgl_awal, $tgl_akhir, true);

      $modPembersihanDetail = array();
      $modPembersihanDetail = PembersihanT::model()->findAll($criteria);
      if (count((array)$modPembersihanDetail) > 0) {
        $modPembersihan = array();
        foreach ($modPembersihanDetail as $i => $pembersihan) {
          $modPembersihan = new STPembersihanT;
          $modPembersihan->tgl_pembersihan = $pembersihan->tgl_pembersihan;
          $form .= $this->renderPartial($this->path_view . '_rowPembersihan', array('modPembersihan' => $modPembersihan), true);
        }
      } else {
        $pesan = "Data Pembersihan tidak ada!";
      }
      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }
}
