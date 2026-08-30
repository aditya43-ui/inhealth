<?php

class InformasiPemesananObatAlkesKeluarController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.informasiPemesananObatAlkesKeluar.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pemesanan Obat Alkes Keluar";
    $model = new GFInformasipesanobatalkesV('searchInformasiPemesananKeluar');
    $format = new MyFormatter();
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    $model->ruanganpemesan_id = Yii::app()->user->getState('ruangan_id');
    $model->instalasipemesan_id = Yii::app()->user->getState('instalasi_id');
    $instalasiPemesanans = CHtml::listData(GFInstalasiM::getInstalasiPemesananObatAlkes(), 'instalasi_id', 'instalasi_nama');
    $ruanganPemesanans = CHtml::listData(GFRuanganM::getRuanganPemesananObatAlkes(Params::INSTALASI_ID_FARMASI), 'ruangan_id', 'ruangan_nama');
    if (isset($_GET['GFInformasipesanobatalkesV'])) {
      $model->attributes = $_GET['GFInformasipesanobatalkesV'];
      $model->instalasitujuan_id = $_GET['GFInformasipesanobatalkesV']['instalasitujuan_id'];
      $model->ruangantujuan_id = $_GET['GFInformasipesanobatalkesV']['ruangantujuan_id'];
      if (($model->ruanganpemesan_id) == "") {
        $model->ruanganpemesan_id = Yii::app()->user->getState('ruangan_id');
      }
      $model->statusmutasi = $_GET['GFInformasipesanobatalkesV']['statusmutasi'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFInformasipesanobatalkesV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInformasipesanobatalkesV']['tgl_akhir']);
    }
    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model,
      'instalasiPemesanans' => $instalasiPemesanans,
      'ruanganPemesanans' => $ruanganPemesanans,
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
        $instalasi_id = $_POST["$model_nama"]['instalasitujuan_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(GFRuanganM::getRuanganPemesananObatAlkes($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        if (count((array)$models) > 1) :
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        elseif (count((array)$models) == 0) :
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        endif;

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
   * menampilkan url print karna setiap modul berbeda
   */
  public function getUrlPrint()
  {
    return $this->createUrl('PemesananObatAlkes/print');
  }

  public function actionBatalPemesananObatAlkes()
  {
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;
      $ok = $ok && PesanoadetailT::model()->deleteAllByAttributes(array('pesanobatalkes_id' => $id));
      $ok = $ok && PesanobatalkesT::model()->deleteByPk($id);

      //var_dump($ok); die;
      if ($ok) {
        //$trans->rollback();
        $trans->commit();
        //$arr = array('info'=>'Pemesanan berhasil dibatalkan', 'status'=>'success');
      } else {
        $trans->rollback();
        //	$arr = array('info'=>'Pemesanan gagal dibatalkan', 'status'=>'gagal');
      }
      //echo CJSON::encode($arr);
      //Yii::app()->end();

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
}
