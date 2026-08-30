<?php

class InformasiPermohonanBantuanObatController extends MyAuthController
{
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $model = new FAInformasipermohonanobatalkesV;
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['FAInformasipermohonanobatalkesV'])) {
      $model->attributes = $_GET['FAInformasipermohonanobatalkesV'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['FAInformasipermohonanobatalkesV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInformasipermohonanobatalkesV']['tgl_akhir']);
    }
    $this->render('index', array('format' => $format, 'model' => $model));
  }

  /*
         * untuk informasi di farmasiApotek/InformasiPermohonanBantuanObat
         */
  public function actionUbahStatusApproved($permohonanoa_id = null)
  {
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    $sukses = '';

    $model = new FAPermohonanoaT;
    $model->permohonanoa_id = $permohonanoa_id;
    if (isset($_POST['FAPermohonanoaT'])) {
      $model->attributes = $_POST['FAPermohonanoaT'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $attributes = array('permohonanoa_isapproved' => true, 'pegawaimenyetujui_id' => $_POST['FAPermohonanoaT']['pegawaimenyetujui_id']);
        $save = FAPermohonanoaT::model()->updateByPk($permohonanoa_id, $attributes);
        if ($save) {
          $sukses = 1;
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          //                        echo "<script>
          //                                myAlert('Data berhasil disimpan');
          //                                window.top.location.href='".Yii::app()->createUrl('farmasiApotek/informasiPermohonanBantuanObat/index')."';
          //                            </script>";
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal diubah!");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
      }
    }

    $this->render('_ubahStatusApproved', array('model' => $model, 'sukses' => $sukses));
  }

  public function actionAutocompletePegawaiMenyetujui()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $nama_pegawai = isset($_GET['pegawaimenyetujui_nama']) ? $_GET['pegawaimenyetujui_nama'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = FAPegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
