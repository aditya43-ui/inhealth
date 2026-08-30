<?php

class InformasiPengajuanKlaimPiutangController extends MyAuthController
{
  protected $succesSave = true;
  protected $pesan = "succes";

  public function actionIndex()
  {
    $model = new KUInformasipengajuanklaimpiutangV('search');
    $model->unsetAttributes();  // clear any default values
    $format = new MyFormatter();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');

    if (isset($_GET['KUInformasipengajuanklaimpiutangV'])) {
      $model->attributes = $_GET['KUInformasipengajuanklaimpiutangV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KUInformasipengajuanklaimpiutangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInformasipengajuanklaimpiutangV']['tgl_akhir']);
    }

    $this->render('index', array(
      'model' => $model,
      'format' => $format
    ));
  }

  public function actionDetail($id = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modDetail = new KUPengajuanklaimdetailT();
    $this->render('detail', array(
      'modDetail' => $modDetail,
      'format' => $format,
      'id' => $id,
    ));
  }

  public function actionBatalPembayaran($id = null)
  {
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
      KUPengajuanklaimpiutangT::model()->deleteByPk($id);
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
          'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
        ));
        exit;
      }

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  public function actionGetPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];

      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
}
