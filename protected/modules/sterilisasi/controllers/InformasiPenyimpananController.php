<?php
class InformasiPenyimpananController extends MyAuthController
{
  public $path_view = 'sterilisasi.views.informasiPenyimpanan.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Penyimpanan Sterilisasi";
    $format = new MyFormatter();
    $modPenyimpanan = new STPenyimpanansterilT('searchInformasi');
    $modPenyimpanan->tgl_awal = date("Y-m-d");
    $modPenyimpanan->tgl_akhir = date("Y-m-d");

    if (isset($_GET['STPenyimpanansterilT'])) {
      $modPenyimpanan->attributes = $_GET['STPenyimpanansterilT'];
      $modPenyimpanan->tgl_awal = $format->formatDateTimeForDb($_GET['STPenyimpanansterilT']['tgl_awal']);
      $modPenyimpanan->tgl_akhir = $format->formatDateTimeForDb($_GET['STPenyimpanansterilT']['tgl_akhir']);
      $modPenyimpanan->ruangan_id = $_GET['STPenyimpanansterilT']['ruangan_id'];
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $modPenyimpanan
    ));
  }

  public function actionDetail($id = null)
  {
    $this->layout = 'iframe';

    $model = STPenyimpanansterilT::model()->findByPk($id);
    $modDetail = STPenyimpanansterildetT::model()->findAllByAttributes(array('penyimpanansteril_id' => $id));


    $this->render($this->path_view . '_detailPenyimpanan', array(
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
      $models = CHtml::listData(STRuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

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
}
