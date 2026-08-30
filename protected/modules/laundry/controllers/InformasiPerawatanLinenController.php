<?php
class InformasiPerawatanLinenController extends MyAuthController
{
  public $path_view = 'laundry.views.informasiPerawatanLinen.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Perawatan Linen";
    $format = new MyFormatter();
    $modPerawatanLinen = new LAPerawatanlinenT('searchInformasi');
    $modPerawatanLinen->tgl_awal = date("Y-m-d");
    $modPerawatanLinen->tgl_akhir = date("Y-m-d");

    if (isset($_GET['LAPerawatanlinenT'])) {
      $modPerawatanLinen->attributes = $_GET['LAPerawatanlinenT'];
      $modPerawatanLinen->tgl_awal = $format->formatDateTimeForDb($_GET['LAPerawatanlinenT']['tgl_awal']);
      $modPerawatanLinen->tgl_akhir = $format->formatDateTimeForDb($_GET['LAPerawatanlinenT']['tgl_akhir']);
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $modPerawatanLinen
    ));
  }

  public function actionDetail($id = null)
  {
    $this->layout = 'iframe';

    $model = LAPerawatanlinenT::model()->findByPk($id);
    $modDetail = LAPerawatanlinendetailT::model()->findAllByAttributes(array('perawatanlinen_id' => $id));


    $this->render($this->path_view . '_detailPerawatan', array(
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

  public function actionUbahStatusDetailLinen()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $perawatanlinendetail_id = $_POST['perawatanlinendetail_id'];
      $status = false;

      $modDetail = PerawatanlinendetailT::model()->findByPk($perawatanlinendetail_id);
      $modDetail->statusperawatanlinen = Params::STATUSPERAWATAN_SELESAI;
      if ($modDetail->update()) {
        $status = true;
      }

      echo CJSON::encode($status);
    }
    Yii::app()->end();
  }

  public function actionUpdateTglKembali()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $ok = 1;

    if (isset($_POST['LAPerawatanlinenT'])) {

      $trans = Yii::app()->db->beginTransaction();

      try {
        $model = LAPerawatanlinenT::model()->findByPk($_POST['LAPerawatanlinenT']['perawatanlinen_id']);
        $tglPerawatan = date('Y-m-d H:i:s');
        if (!empty($_POST['LAPerawatanlinenT']['tgl_kembali'])) {
          $tgl = MyFormatter::formatDateTimeForDb($_POST['LAPerawatanlinenT']['tgl_kembali']);
          $time = date("H:i:s");
          $tglPerawatan = $tgl . " " . $time;
        }

        $model->tgl_kembali = $tglPerawatan;
        $modelDetail = LAPerawatanlinendetailT::model()->findAllByAttributes(array('perawatanlinen_id' => $model->perawatanlinen_id));

        if (count((array)$modelDetail) > 0) {
          foreach ($modelDetail as $data) {
            LAPerawatanlinendetailT::model()->updateByPk($data->perawatanlinendetail_id, array('statusperawatanlinen' => "SELESAI"));
          }
        }

        if (!$model->save()) {
          $ok = 0;
        }

        if ($ok == 1) {
          $trans->commit();
        } else {
          $trans->rollback();
        }
      } catch (Exception $ex) {
        $trans->rollback();
        $ok = 0;
      }
    }

    echo CJSON::encode(array('ok' => $ok));
  }
}
