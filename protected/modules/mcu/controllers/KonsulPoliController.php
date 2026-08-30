<?php
Yii::import('rawatJalan.models.*');
class KonsulPoliController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  protected $path_view = 'mcu.views.konsulPoli.';

  public function actionIndex($pendaftaran_id)
  {
    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $karcisTindakan = DaftartindakanM::model()->findAllByAttributes(array('daftartindakan_karcis' => true));

    $modKonsul = new RJKonsulPoliT;
    $modelPendaftaran = new RJPendaftaranT;
    $modKonsul->pasien_id = $modPendaftaran->pasien_id;
    $modKonsul->pendaftaran_id = $pendaftaran_id;
    $modKonsul->pegawai_id = $modPendaftaran->pegawai_id;
    $modKonsul->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
    $modKonsul->asalpoliklinikkonsul_id = $ruangan_id;

    if (isset($_GET['idKonsulPoli'])) {
      $modKonsul = RJKonsulPoliT::model()->findByPk($_GET['idKonsulPoli']);
    }

    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id);
    if (isset($_POST['RJKonsulPoliT'])) {
      $modKonsul->attributes = $_POST['RJKonsulPoliT'];
      $modelPendaftaran->pasienpulang_id = $modPendaftaran->pasienpulang_id;
      $modelPendaftaran->pasienbatalperiksa_id = $modPendaftaran->pasienbatalperiksa_id;
      if (empty($modelPendaftaran->penanggungjawab_id)) {
        $penanggungjawab = 1;
      } else {
        $penanggungjawab = $modPendaftaran->penanggungjawab_id;
      }
      $modKonsul->no_antriankonsul = MyGenerator::noAntrianKonsulPoli($modKonsul->ruangan_id);
      if ($modKonsul->validate()) {
        if ($modKonsul->save()) {
          $updateStatusPeriksa = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
          /* ================================================ */
          /* Proses update status periksa KonsulPoli EHS-179  */
          /* ================================================ */
          $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
          if (!empty($konsulPoli)) {
            $updateStatusPeriksa = KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
          }
          /* ================================================ */

          PendaftaranT::model()->updateByPk(
            $pendaftaran_id,
            array(
              'pembayaranpelayanan_id' => null
            )
          );
          $modTindakanPelayanan =  new RJTindakanPelayananT;
          $modTindakanPelayanan->konsulpoli_id = $modKonsul->konsulpoli_id;
          $modTindakanPelayanan->pasien_id = $modPendaftaran->pasien_id;
          $modTindakanPelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
          $modTindakanPelayanan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
          $modTindakanPelayanan->instalasi_id = $modPendaftaran->instalasi_id;
          $modTindakanPelayanan->shift_id     = $modPendaftaran->shift_id;
          $modTindakanPelayanan->carabayar_id = $modPendaftaran->carabayar_id;
          $modTindakanPelayanan->penjamin_id = $modPendaftaran->penjamin_id;
          $modTindakanPelayanan->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
          $modTindakanPelayanan->ruangan_id   = $modKonsul->ruangan_id;
          $modTindakanPelayanan->cyto_tindakan = 0;
          $modTindakanPelayanan->tarifcyto_tindakan = 0;
          $modTindakanPelayanan->discount_tindakan = 0;
          $modTindakanPelayanan->subsidiasuransi_tindakan = 0;
          $modTindakanPelayanan->subsidipemerintah_tindakan = 0;
          $modTindakanPelayanan->subsisidirumahsakit_tindakan = 0;
          $modTindakanPelayanan->iurbiaya_tindakan = 0;
          $modTindakanPelayanan->create_loginpemakai_id = Yii::app()->user->id;
          $modTindakanPelayanan->create_ruangan = $modKonsul->ruangan_id;
          $modTindakanPelayanan->create_time =  date('Y-m-d H:i:s');
          $modTindakanPelayanan->satuantindakan = "Hari";

          $modTindakanPelayanan->daftartindakan_id = Params::DAFTARTINDAKAN_ID_KONSUL;
          $modTindakanPelayanan->tgl_tindakan = date('Y-m-d H:i:s');

          $modTindakanPelayanan->tarif_satuan = $modTindakanPelayanan->getTarifSatuan(); //RND-7250
          $modTindakanPelayanan->tarif_tindakan = $modTindakanPelayanan->qty_tindakan * $modTindakanPelayanan->tarif_satuan;

          if ($modTindakanPelayanan->validate()) {
            if ($modTindakanPelayanan->save()) {
              $valid = true;
            }
          }
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'idKonsulPoli' => $modKonsul->konsulpoli_id));
        }
      }
    }

    $modRiwayatKonsul = RJKonsulPoliT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'asalpoliklinikkonsul_id' => $ruangan_id));

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modKonsul' => $modKonsul,
      'karcisTindakan' => $karcisTindakan,
      'modRiwayatKonsul' => $modRiwayatKonsul,
      'modelPendaftaran' => $modelPendaftaran,
      'modJenisTarif' => $modJenisTarif
    ));
  }
}
