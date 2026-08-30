<?php

Yii::import('rawatJalan.controllers.DaftarPasienController');
Yii::import('rawatJalan.models.*');

class RekamMedikElektronikPasienController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $path_view = 'rekamMedis.views.rekamMedikElektronikPasien.';

  public function actionIndex($pendaftaran_id=null, $pasienmasukpenunjang_id = null, $type=null)
  {
    $format = new MyFormatter();

    $modPenunjang = null;

    if(isset($pasienmasukpenunjang_id)) {
      $modPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
    }

    $modPendaftaran = PendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $criteria = new CDbCriteria(array(
      'condition' => 't.pasien_id = ' . $modPendaftaran->pasien_id,
      'order' => 'tgl_pendaftaran DESC',
    ));

    $pages = new CPagination(RKKPendaftaranT::model()->count($criteria));
    $pages->pageSize = Params::JUMLAH_PERHALAMAN; //Yii::app()->params['postsPerPage'];
    $pages->applyLimit($criteria);

    $modKunjungan = RKKPendaftaranT::model()->with('hasilpemeriksaanlab', 'anamnesa', 'pemeriksaanfisik', 'pasienmasukpenunjang', 'diagnosa')->findAll($criteria);


   
    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPenunjang' => $modPenunjang,
      'pages' => $pages,
      'modKunjungan' => $modKunjungan,
    ));
    // $this->render($this->path_view . 'index', array(
    //   'format' => $format,
    //   // 'model' => $model
    // ));
  }

  // public function actionGetRiwayatPasien($id)
  // {
  //   $this->layout = '//layouts/iframe';
   
  //   $this->render($this->path_view . '_riwayatPasien', array(
  //     'pages' => $pages,
  //     'modKunjungan' => $modKunjungan,
  //   ));
  // }

}
