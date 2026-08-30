<?php

Yii::import('gudangUmum.models.*');
Yii::import('gudangUmum.controllers.PesanbarangTController');

class PesanbarangTLKController extends PesanbarangTController
{
  private $_valid;
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'gudangUmum.views.pesanbarangT.';

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionIndex($id = null)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new GUPesanbarangT;
    $modDetails = array();
    $instalasi_id = Yii::app()->user->getState('instalasi_id');
    $model->nopemesanan = MyGenerator::noPemesananBarang();
    $model->tglpesanbarang = date('d M Y H:i:s');
    $modLogin = LoginpemakaiK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->id));
    $model->pegpemesan_id = $modLogin->pegawai_id;
    $model->pegpemesan_nama = $modLogin->pegawai->nama_pegawai;
    $model->ruanganpemesan_id = Yii::app()->user->getState('ruangan_id');
    $model->instalasi_id = $model->ruanganpemesan->instalasi->instalasi_id;
    if (isset($id)) {
      $modelPesan = GUPesanbarangT::model()->findByPk($id);
      $model->nopemesanan = MyGenerator::noPemesananBarang();
      if (!empty($modelPesan)) {
        $model = $modelPesan;
        $model->instalasi_id = $model->ruanganpemesan->instalasi->instalasi_id;
        $model->pegpemesan_nama = $model->pegawaipemesan->nama_pegawai;
        $model->pegmengetahui_nama = isset($model->pegawaimengetahui->nama_pegawai) ? $model->pegawaimengetahui->nama_pegawai : null;
        $modDetails = GUPesanbarangdetailT::model()->findAll('pesanbarang_id = ' . $id);
      }
    }

    if (isset($_POST['GUPesanbarangT'])) {
      $model->attributes = $_POST['GUPesanbarangT'];
      if (count((array)$_POST['PesanbarangdetailT']) > 0) {
        $modDetails = $this->validasiTabularInput($_POST['PesanbarangdetailT'], $model);
        if ($model->validate()) {
          $transaction = Yii::app()->db->beginTransaction();
          try {
            $success = true;
            $model->nopemesanan = MyGenerator::noPemesananBarang();
            if ($model->save()) {
              $modDetails = $this->validasiTabularInput($_POST['PesanbarangdetailT'], $model);
              foreach ($modDetails as $i => $data) {
                if ($data->qty_pesan > 0) {
                  if ($data->save()) {
                  } else {
                    $success = false;
                  }
                }
              }
            } else {
              $success = false;
            }

            if ($success == true) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
              $this->redirect(array('index', 'id' => $model->pesanbarang_id, 'sukses' => 1));
            } else {
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan ");
            }
          } catch (Exception $ex) {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
          }
        }
      } else {
        $model->validate();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data detail barang harus diisi.');
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model, 'modDetail' => $modDetails,
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
      $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        if (empty($models)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          if (count((array)$models) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionAjaxGetPesanBarang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idBarang = $_POST['idBarang'];
      $jumlah = $_POST['jumlah'];
      $satuan = $_POST['satuan'];

      $modBarang = BarangM::model()->with('subsubkelompok')->findByPk($idBarang);
      $modDetail = new PesanbarangdetailT();
      $modDetail->barang_id = $idBarang;
      $modDetail->satuanbarang = $satuan;
      $modDetail->qty_pesan = $jumlah;

      $tr = $this->renderPartial($this->path_view . '_detailPesanBarang', array('modBarang' => $modBarang, 'modDetail' => $modDetail), true);
      echo json_encode($tr);
      Yii::app()->end();
    }
  }

  protected function validasiTabularInput($datas, $model)
  {
    $valid = true;
    foreach ($datas as $i => $data) {
      $modDetail[$i] = new PesanbarangdetailT();
      $modDetail[$i]->attributes = $data;
      $modDetail[$i]->pesanbarang_id = $model->pesanbarang_id;
      $valid = $modDetail[$i]->validate() && $valid;
    }
    $this->_valid = $valid;
    return $modDetail;
  }

  public function actionPrint($id)
  {
    $this->layout = '//layouts/printWindows';
    $caraPrint = $_REQUEST['caraPrint'];
    $judulLaporan = 'Data Pemesanan Barang';
    $modPesan = PesanbarangT::model()->findByPk($id);
    $modDetailPesan = PesanbarangdetailT::model()->findAllByAttributes(array('pesanbarang_id' => $modPesan->pesanbarang_id));
    $this->render('gudangUmum.views.pesanbarangT.detailInformasi', array(
      'judulLaporan' => $judulLaporan,
      'modPesan' => $modPesan,
      'modDetailPesan' => $modDetailPesan,
      'caraPrint' => $caraPrint,
    ));
  }
}
