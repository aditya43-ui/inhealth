<?php
class InformasiPengirimanPeralatanLinenSterilController extends MyAuthController
{
  public $path_view = 'sterilisasi.views.informasiPengirimanPeralatanLinenSteril.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pengiriman Peralatan Linen Steril";
    $format = new MyFormatter();
    $model = new STKirimperlinensterilT('searchInformasi');
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");

    if (isset($_GET['STKirimperlinensterilT'])) {
      $model->attributes = $_GET['STKirimperlinensterilT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['STKirimperlinensterilT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['STKirimperlinensterilT']['tgl_akhir']);
      $model->ruangan_id = $_GET['STKirimperlinensterilT']['ruangan_id'];
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model
    ));
  }


  public function actionDetail($id = null)
  {
    $this->layout = 'iframe';

    $model = STKirimperlinensterilT::model()->findByPk($id);
    $modDetail = STKirimperlinensterildetT::model()->findAllByAttributes(array('kirimperlinensteril_id' => $id));


    $this->render($this->path_view . '_detail', array(
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

  public function actionBatalPengiriman($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $deleteDetail = STKirimperlinensterildetT::model()->deleteAllByAttributes(array('kirimperlinensteril_id' => $id));
      $deletePengiriman = STKirimperlinensterilT::model()->deleteByPk($id);
      if ($deleteDetail && $deletePengiriman) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
  }
}
