<?php
Yii::import('bankDarah.controllers.PemakaianBmhpController');
class PemakaianBahanController extends PemakaianBmhpController
{
  public $path_view = "bankDarah.views.pemakaianBahan.";
  public $path_view_bmhp = "bankDarah.views.pemakaianBmhp.";
  public $obatalkespasientersimpan = true; //dilooping

  public function actionPrint($pasienmasukpenunjang_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPasienMasukPenunjang = BDPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modObatAlkesPasien = BDObatalkespasienT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));

    $judul_print = 'Pemakaian Bahan ' . $modPasienMasukPenunjang->ruangan_nama;
    $this->render($this->path_view . 'printPemakaianBahan', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modObatAlkesPasien' => $modObatAlkesPasien,
    ));
  }

  public function actionAddFormPemakaianBahan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $idObatAlkes = (isset($_POST['idObatAlkes']) ? $_POST['idObatAlkes'] : null);
      $idDaftartindakan = (isset($_POST['idDaftartindakan']) ? $_POST['idDaftartindakan'] : "");
      $modObatAlkes = ObatalkesM::model()->findByPk($idObatAlkes);
      $modDaftartindakan = DaftartindakanM::model()->findByPk($idDaftartindakan);
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $persenjual = $this->persenJualRuangan();
      $modObatAlkes->hargajual = floor(($persenjual + 100) / 100 * $modObatAlkes->hargajual);

      echo CJSON::encode(array(
        'pendaftaran_id' => $pendaftaran_id,
        'namaObat' => $modObatAlkes->obatalkes_nama,
        'form' => $this->renderPartial('_formAddPemakaianBahan', array(
          'modObatAlkes' => $modObatAlkes, 'modDaftartindakan' => $modDaftartindakan,
          'modPendaftaran' => $modPendaftaran,
        ), true),
      ));
      exit;
    }
  }
}
