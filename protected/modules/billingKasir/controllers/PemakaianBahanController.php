<?php
Yii::import('billingKasir.controllers.PemakaianBmhpController');
class PemakaianBahanController extends PemakaianBmhpController
{
  public $layout = "//layouts/iframe";
  public $path_view_bmhp = "billingKasir.views.pemakaianBmhp.";
  public $path_view = "billingKasir.views.pemakaianBahan.";
  public $instalasi;
  public $obatalkespasientersimpan = true; //dilooping

  public function actionPrint($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
    $modObatAlkesPasien = BKObatalkesPasienT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $instalasi = '';
    $judul_print = 'Pemakaian Bahan ' . $modPendaftaran->ruangan->ruangan_nama;
    $this->render($this->path_view . 'printPemakaianBahan', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPendaftaran' => $modPendaftaran,
      'modObatAlkesPasien' => $modObatAlkesPasien,
      'instalasi' => $instalasi,
    ));
  }
}
