<?php
Yii::import('laundry.models.*');
class InformasiPengirimanLinenRIController extends MyAuthController
{
  public $path_view = 'rawatInap.views.informasiPengirimanLinen.';
  public $path_view_petunjuk = 'rawatInap.views.tips.';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $modPengirimanLinen = new LAPengirimanlinenT('searchInformasi');
    $modPengirimanLinen->tgl_awal = date("Y-m-d");
    $modPengirimanLinen->tgl_akhir = date("Y-m-d");

    if (isset($_GET['LAPengirimanlinenT'])) {
      $modPengirimanLinen->attributes = $_GET['LAPengirimanlinenT'];
      $modPengirimanLinen->tgl_awal = $format->formatDateTimeForDb($_GET['LAPengirimanlinenT']['tgl_awal']);
      $modPengirimanLinen->tgl_akhir = $format->formatDateTimeForDb($_GET['LAPengirimanlinenT']['tgl_akhir']);
    }

    $modPengirimanLinen->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $modPengirimanLinen->ruangantujuan_id = Yii::app()->user->getState('ruangan_id');

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $modPengirimanLinen
    ));
  }


  public function actionDetail($id = null)
  {
    $this->layout = 'iframe';

    $model = LAPengirimanlinenT::model()->findByPk($id);
    $modDetail = LAPengirimanlinendetailT::model()->findAllByAttributes(array('pengirimanlinen_id' => $id));


    $this->render($this->path_view . '_detailPengiriman', array(
      'model' => $model,
      'modDetail' => $modDetail,
    ));
  }
  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(LARuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionUbahStatusTerima()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $pengirimanlinen_id = isset($_POST['pengirimanlinen_id']) ? $_POST['pengirimanlinen_id'] : null;
      $pesan = '';

      $tglterimalinen = date('Y-m-d H:i:s');
      $update = LAPengirimanlinenT::model()->updateByPk($pengirimanlinen_id, array('issudahditerima' => true, 'tglterimalinen' => $tglterimalinen));
      if ($update) {
        $pesan = 'ok';
      } else {
        $pesan = 'not';
      }
      $data['pesan'] = $pesan;

      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
