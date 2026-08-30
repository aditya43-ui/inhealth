<?php

/**
 * Digunakan sebagai informasi stok kantong darah
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 * @category controller
 */
class InformasiStokKantongDarahController extends MyAuthController
{
  public $path_view = 'bankDarah.views.informasiStokKantongDarah';

  /**
   * Load Data informasi stok kantong darah
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Stok Kantong Darah";
    $model = new BDInformasiStokKantongDarahV();
    $modKantong = BDInformasiStokKantongDarahV::model()->findByAttributes(array('stokkantongdarah_id' => $model->stokkantongdarah_id));

    if (isset($_GET['BDInformasiStokKantongDarahV'])) {
      //$model->komponendarah_id = $_GET['BDInformasiStokKantongDarahV']['komponendarah_id'];
      $model->singkatan_komp = $_GET['BDInformasiStokKantongDarahV']['singkatan_komp'];
      $model->gol_darah = $_GET['BDInformasiStokKantongDarahV']['gol_darah'];
    }
    $this->render(
      'index',
      array(
        'model' => $model,
      )
    );
  }

  /**
   * Load data detail setiap stok kantong darah berdasarkan singkatan komponen dan golongan
   * @param type $singkatan_komp
   * @param type $gol
   */
  public function actionDetail($singkatan_komp, $gol)
  {
    $this->layout = '//layouts/iframe';
    $model = BDInformasiStokKantongDarahV::model()->findByAttributes(array('singkatan_komp' => $singkatan_komp, 'gol_darah' => $gol));

    $this->render(
      '_detail',
      array(
        'model' => $model,
      )
    );
  }

  /**
   * Menampikan detail stok kantong darah berdasarkan singkatan komponen dan golongan
   * @author Elham Budianto <elhambudianto@.com>
   * @param type $singkatan_komp
   * @param type $gol_darah
   */
  public function actionDetailStokKantongDarah($singkatan_komp, $gol_darah)
  {
    $this->layout = '//layouts/iframe';
    $criteria = new CDbCriteria();
    $criteria->select = 'komponen.singkatan_komp,t.nomorbarcode,t.rhesus, komponen.singkatan_komp ,t.gol_darah,t.jeniskantongdarah_id';
    $criteria->join = 'LEFT JOIN komponendarah_m as komponen ON t.komponendarah_id = komponen.komponendarah_id';
    $criteria->addCondition("t.ujikompatibilitas_id is null");
    $criteria->addCondition("komponen.singkatan_komp ='" . $singkatan_komp . "'");
    $criteria->addCondition("t.gol_darah ='" . $gol_darah . "'");
    $model = InfostokkantongdarahV::model()->findAll($criteria);
    $judul = 'Stok Kantong Darah';
    $this->render(
      '_detail',
      array(
        'model' => $model,
        'singkatan_komp' => $singkatan_komp,
        'gol_darah' => $gol_darah,
        'judul' => $judul,
      )
    );
  }

  /**
   * Menampilkan detail stok darah siap berdasarkan singkatan_komp dan gol_darah
   * @author Elham Budianto <elhambudianto@.com>
   * @param type $singkatan_komp
   * @param type $gol_darah
   */
  public function actionDetailStokDarahSiap($singkatan_komp, $gol_darah)
  {
    $this->layout = '//layouts/iframe';
    $criteria = new CDbCriteria();
    $criteria->select = 'komponen.singkatan_komp,t.golongan_darah,t.nomorbarcode,t.rhesus,t.jeniskantongdarah_id';
    $criteria->join = 'LEFT JOIN ujikompatibilitas_t as uji ON t.ujikompatibilitas_id = uji.ujikompatibilitas_id '
      //. 'LEFT JOIN penyiapandarah_t as penyiapan ON uji.ujikompatibilitas_id = penyiapan.ujikompatibilitas_id '
      //. 'LEFT JOIN penyerahandarah_t as penyerahan ON penyiapan.penyiapandarah_id = penyerahan.penyiapandarah_id '
      . 'LEFT JOIN komponendarah_m as komponen ON t.komponendarah_id = komponen.komponendarah_id';
    $criteria->addCondition("t.ujikompatibilitas_id is not null");
    //$criteria->addCondition("penyiapan.penyiapandarah_id is not null");
    //$criteria->addCondition("penyerahan.penyerahandarah_id is null");
    $criteria->addCondition("komponen.singkatan_komp ='" . $singkatan_komp . "'");
    $criteria->addCondition("t.golongan_darah ='" . $gol_darah . "'");
    $model = StokkantongdarahT::model()->findAll($criteria);
    $judul = 'Stok Darah Siap';
    $this->render('_detail', array(
      'model' => $model,
      'singkatan_komp' => $singkatan_komp,
      'gol_darah' => $gol_darah,
      'judul' => $judul,
    ));
  }

  /**
   * Menampilkan detail stok darah keluar berdasarkan singkatan_komp dan gol_darah
   * @author Elham Budianto <elhambudianto@.com>
   * @param type $singkatan_komp
   * @param type $gol_darah
   */
  public function actionDetailStokDarahKeluar($singkatan_komp, $gol_darah)
  {
    $this->layout = '//layouts/iframe';
    $criteria = new CDbCriteria();
    $criteria->select = 'komponen.singkatan_komp,t.golongan_darah,t.nomorbarcode,t.rhesus,t.jeniskantongdarah_id';
    $criteria->join = 'LEFT JOIN ujikompatibilitas_t as uji ON t.ujikompatibilitas_id = uji.ujikompatibilitas_id '
      . 'LEFT JOIN penyiapandarah_t as penyiapan ON uji.ujikompatibilitas_id = penyiapan.ujikompatibilitas_id '
      . 'LEFT JOIN penyerahandarah_t as penyerahan ON penyiapan.penyiapandarah_id = penyerahan.penyiapandarah_id '
      . 'LEFT JOIN komponendarah_m as komponen ON t.komponendarah_id = komponen.komponendarah_id';
    $criteria->addCondition("t.ujikompatibilitas_id is not null");
    $criteria->addCondition("penyiapan.penyiapandarah_id is not null");
    $criteria->addCondition("penyerahan.penyerahandarah_id is not null");
    $criteria->addCondition("komponen.singkatan_komp ='" . $singkatan_komp . "'");
    $criteria->addCondition("t.golongan_darah ='" . $gol_darah . "'");
    $model = StokkantongdarahT::model()->findAll($criteria);
    $judul = 'Stok Darah Keluar';
    $this->render('_detail', array(
      'model' => $model,
      'singkatan_komp' => $singkatan_komp,
      'gol_darah' => $gol_darah,
      'judul' => $judul,
    ));
  }
}
