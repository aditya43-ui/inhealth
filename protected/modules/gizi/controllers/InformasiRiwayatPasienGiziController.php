<?php

class InformasiRiwayatPasienGiziController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Riwayat Pasien";
    $modPasienMasukPenunjang = new GZPasienMasukPenunjangV;
    $format = new MyFormatter();
    $modPasienMasukPenunjang->tgl_awal = date('d M Y');
    $modPasienMasukPenunjang->tgl_akhir = date('d M Y');
    if (isset($_REQUEST['GZPasienMasukPenunjangV'])) {
      $modPasienMasukPenunjang->attributes = $_REQUEST['GZPasienMasukPenunjangV'];
      $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GZPasienMasukPenunjangV']['tgl_awal']);
      $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GZPasienMasukPenunjangV']['tgl_akhir']);
    }
    $this->render('index', array('modPasienMasukPenunjang' => $modPasienMasukPenunjang));
  }
  public function actionRiwayatPasien($id, $pasien_id)
  {
    $criteria = new CDbCriteria(array(
      'condition' => 't.pasien_id = ' . $pasien_id,
      //.'
      //      and t.ruangan_id ='.Yii::app()->user->getState('ruangan_id'),
      'order' => 'tgl_pendaftaran DESC',
    ));

    $pages = new CPagination(GZPendaftaranT::model()->count($criteria));
    $pages->pageSize = Params::JUMLAH_PERHALAMAN; //Yii::app()->params['postsPerPage'];
    $pages->applyLimit($criteria);

    $modKunjungan = GZPendaftaranT::model()->with('hasilpemeriksaanlab', 'anamnesa', 'pemeriksaanfisik', 'pasienmasukpenunjang', 'tindakanpelayanan', 'diagnosa')->findAll($criteria);
    $modPasienMasukPenunjang = GZPasienMasukPenunjangT::model()->findAllByAttributes(array('pendaftaran_id' => $id));
    $modPendaftaran = GZPendaftaranT::model()->findByPk($id);
    $modPasien = GZPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAnamnesa = GZAnamnesaDietT::model()->findAllByAttributes(array('pendaftaran_id' => $id));

    $this->render('_riwayatPasien', array(
      'pages' => $pages,
      'modKunjungan' => $modKunjungan,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modAnamnesa' => $modAnamnesa,
    ));
  }
}
