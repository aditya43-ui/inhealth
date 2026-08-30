<?php

class AsesmenGiziController extends Controller
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  public $path_view = 'gizi.views.asesmenGizi.';

  public function actionIndex($pendaftaran_id, $pasien_id = null, $pasienadmisi_id = null, $pasienmasukpenunjang_id = null)
  {
    $modPendaftaran = GZPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = GZPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $dataPendaftaran = GZPendaftaranT::model()->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id), array('order' => 'tgl_pendaftaran DESC'));

    $model = new AsesmengiziT;
    $model->tgl_konsultasi = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
    $model->pendaftaran_id = $pendaftaran_id;
    $model->pasien_id = $modPasien->pasien_id;
    $model->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;

    $modAdmisi = null;
    if (!empty($pasienadmisi_id)) {
      $modAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);

      $model->ruangan_id = $modAdmisi->ruangan_id;
      $model->kelaspelayanan_id = $modAdmisi->kelaspelayanan_id;
    } else {
      $model->ruangan_id = $modPendaftaran->ruangan_id;
      $model->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    }



    // diagnosa terakhir
    $crd = new CDbCriteria();
    $crd->join = "join pasienmorbiditas_t m on m.diagnosa_id = t.diagnosa_id";
    $crd->compare('m.pendaftaran_id', $pendaftaran_id);
    $crd->compare('m.kelompokdiagnosa_id', Params::KELOMPOKDIAGNOSA_UTAMA);
    $crd->order = "m.pasienmorbiditas_id desc";

    $diag = DiagnosaM::model()->find($crd);
    if (!empty($diag)) {
      $model->diagnosa = $diag->diagnosa_kode . " " . $diag->diagnosa_nama;
    }


    if (isset($_POST['AsesmengiziT'])) {
      $trans = Yii::app()->db->beginTransaction();

      try {
        $ok = true;

        $model->attributes = $_POST['AsesmengiziT'];
        $model->ananakimtu = isset($_POST['AsesmengiziT']['ananakimtu']) ? $_POST['AsesmengiziT']['ananakimtu'] : null;
        $model->ananakpjgbdnu = isset($_POST['AsesmengiziT']['ananakpjgbdnu']) ? $_POST['AsesmengiziT']['ananakpjgbdnu'] : null;
        $model->ananakpjgbdn = isset($_POST['AsesmengiziT']['ananakpjgbdn']) ? $_POST['AsesmengiziT']['ananakpjgbdn'] : null;
        $model->ananakutb = isset($_POST['AsesmengiziT']['ananakutb']) ? $_POST['AsesmengiziT']['ananakutb'] : null;
        $model->ananakket = isset($_POST['AsesmengiziT']['ananakket']) ? $_POST['AsesmengiziT']['ananakket'] : null;
        $model->tgl_konsultasi = MyFormatter::formatDateTimeForDb($model->tgl_konsultasi);
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($model->pantangan_makanan == 0) {
          $model->pantangan_makanan_jenis = "";
        }
        if ($model->alergi_makanan == 0) {
          $model->alergi_makanan_jenis = "";
        }

        if ($model->validate()) {
          $ok = $ok && $model->save();

          if (isset($_POST['AsesmengizidetT'])) {
            foreach ($_POST['AsesmengizidetT'] as $item) {
              $det = new AsesmengizidetT;
              $det->attributes = $item;
              $det->asesmengizi_id = $model->asesmengizi_id;

              $ok = $ok && $det->save();
            }
          }
        } else {
          $ok = false;
        }

        if ($ok) {

          $this->notifAsesmenGizi($model);

          $trans->commit();
          Yii::app()->user->setFlash('success', "Asesmen Gizi berhasil disimpan");

          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id));
        } else {
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan ' . '<pre>' .
            print_r($row->getErrors(), 1) . '</pre>');

          $trans->rollback();
        }
      } catch (Exception $ex) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan ' . $ex->getMessage());
      }
    }


    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'dataPendaftaran' => $dataPendaftaran,
      'model' => $model,
      'modAdmisi' => $modAdmisi,
    ));
  }

  public function notifAsesmenGizi($model)
  {

    //$pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
    //$pasien = PasienM::model()->findByPk($pendaftaran->pasien_id);
    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id,
    ));

    $ruangan_id = $model->ruangan_id;

    $ruangan = RuanganM::model()->findByPk($ruangan_id);

    $judul = "Asesmen Gizi - " . $penunjang->nama_pasien;
    $isi = "Pasien dengan nama " . $penunjang->nama_pasien . " (" . $penunjang->no_rekam_medik . ") sudah dilakukan asesmen gizi";

    CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
    ));
  }

  public function actionDetail($asesmengizi_id)
  {
    $model = AsesmengiziT::model()->findByPk($asesmengizi_id);

    $this->render('detail', array(
      'model' => $model,
    ));
  }

  public function actionHapus()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $asesmengizi_id = $_POST['id'];

    AsesmengizidetT::model()->deleteAllByAttributes(array(
      'asesmengizi_id' => $asesmengizi_id,
    ));
    AsesmengiziT::model()->deleteByPk($asesmengizi_id);
  }
}
