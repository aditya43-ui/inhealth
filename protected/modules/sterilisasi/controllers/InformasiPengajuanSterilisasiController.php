<?php
class InformasiPengajuanSterilisasiController extends MyAuthController
{
  public $path_view = 'sterilisasi.views.informasiPengajuanSterilisasi.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pengajuan Sterilisasi";
    $format = new MyFormatter();
    $modPengajuanSterilisasi = new STPengajuansterlilisasiT('searchInformasi');
    $modPengajuanSterilisasi->tgl_awal = date("Y-m-d");
    $modPengajuanSterilisasi->tgl_akhir = date("Y-m-d");

    if (isset($_GET['STPengajuansterlilisasiT'])) {
      $modPengajuanSterilisasi->attributes = $_GET['STPengajuansterlilisasiT'];
      $modPengajuanSterilisasi->tgl_awal = $format->formatDateTimeForDb($_GET['STPengajuansterlilisasiT']['tgl_awal']);
      $modPengajuanSterilisasi->tgl_akhir = $format->formatDateTimeForDb($_GET['STPengajuansterlilisasiT']['tgl_akhir']);
      $modPengajuanSterilisasi->ruangan_id = $_GET['STPengajuansterlilisasiT']['ruangan_id'];
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $modPengajuanSterilisasi
    ));
  }


  public function actionDetail($id = null)
  {
    $this->layout = 'iframe';

    $model = STPengajuansterlilisasiT::model()->findByPk($id);
    $modDetail = STPengajuansterlilisasidetT::model()->findAllByAttributes(array('pengajuansterlilisasi_id' => $id));
    $judul_print = 'Detail Pengajuan Sterilisasi';

    $this->render($this->path_view . '_detailSterilisasi', array(
      'model' => $model,
      'modDetail' => $modDetail,
      'judul_print' => $judul_print
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
