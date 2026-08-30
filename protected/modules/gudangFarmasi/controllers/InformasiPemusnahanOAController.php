<?php

class InformasiPemusnahanOAController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.informasiPemusnahanOA.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pemusnahan Obat Dan Alkes";
    $model = new GFInformasipemusnahanoaV;
    $instalasiTujuan = CHtml::listData(GFInstalasiM::getInstalasiPemusnahanObatAlkes(), 'instalasi_id', 'instalasi_nama');
    $ruanganAsal = CHtml::listData(GFRuanganM::getRuanganAsalPemusnahan($model->instalasi_id), 'ruangan_id', 'ruangan_nama');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['GFInformasipemusnahanoaV'])) {
      $model->attributes = $_GET['GFInformasipemusnahanoaV'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['GFInformasipemusnahanoaV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInformasipemusnahanoaV']['tgl_akhir']);
    }
    $this->render('index', array('format' => $format, 'model' => $model, 'instalasiTujuan' => $instalasiTujuan, 'ruanganAsal' => $ruanganAsal));
  }

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
      $models = CHtml::listData(GFRuanganM::getRuanganAsalPemusnahan($instalasi_id), 'ruangan_id', 'ruangan_nama');

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

  /**
   * untuk print data rencana kebutuhan farmasi
   */
  public function actionPrint($pemusnahanobatalkes_id, $caraprint = null)
  {
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    } else if ($caraprint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }
    $format = new MyFormatter;
    $model = GFPemusnahanobatalkesT::model()->findByPk($pemusnahanobatalkes_id);
    $modDetails = GFPemusnahanoadetailT::model()->findAllByAttributes(array('pemusnahanobatalkes_id' => $pemusnahanobatalkes_id));

    $judul_print = 'Pemusnahan Obat Alkes';

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'model' => $model,
      'modDetails' => $modDetails,
      'caraprint' => $caraprint
    ));
  }
}
