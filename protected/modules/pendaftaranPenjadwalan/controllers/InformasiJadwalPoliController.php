<?php

class InformasiJadwalPoliController extends MyAuthController
{
  /**
   * @return array action filters
   */
  public $_lastHari = null;
  public $path_view = 'pendaftaranPenjadwalan.views.informasiJadwalPoli.';

  public function filters()
  {
    return array(
      'accessControl', // perform access control for CRUD operations
    );
  }

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Informasi Jadwal Buka PoliKlinik";

    $model = new PPJadwalBukaPoliM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['PPJadwalBukaPoliM'])) {
      $model->attributes = $_GET['PPJadwalBukaPoliM'];
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
    ));
  }

  protected function gridHari($data, $row)
  {
    if ($this->_lastHari != $data->hari) {
      $this->_lastHari = $data->hari;
      return $data->hari;
    } else {
      return '';
    }
  }

  public function actionUbahJamBukaPoli()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idJadwal = $_POST['idJadwal'];
      $jamMulai = $_POST['jamMulai'];
      $jamTutup = $_POST['jamTutup'];
      $jamBuka = $jamMulai . ' s/d ' . $jamTutup;

      if (JadwalbukapoliM::model()->updateByPk(
        $idJadwal,
        array(
          'jmabuka' => $jamBuka,
          'jammulai' => $jamMulai,
          'jamtutup' => $jamTutup,
          'update_loginpemakai_id' => Yii::app()->user->id,
          'update_time' => date('Y-m-d H:i:s')
        )
      )) {
        $data['status'] = 'OK';
      } else {
        $data['status'] = 'gagal';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
