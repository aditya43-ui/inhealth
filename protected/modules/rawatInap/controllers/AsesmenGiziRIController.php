<?php

/**
 * Description of AsesmenGiziController
 *
 * @author Deni Hamdani <denihamdani@piiindonesia.co.id>
 */
class AsesmenGiziRIController extends MyAuthController
{
  public $path_view = "rawatInap.views.asesmenGiziRI.";
  public $path_view_gizi = "gizi.views.asesmenGizi.";

  public function actionIndex($pendaftaran_id, $pasienadmisi_id)
  {
    $this->layout = '//layouts/iframe';

    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $dataPendaftaran = PendaftaranT::model()->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id), array('order' => 'tgl_pendaftaran DESC'));

    $model = AsesmengiziT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      //'pasienadmisi_id'=>$pasienadmisi_id,
    ), array(
      'condition' => 'pasienmasukpenunjang_id is null'
    ));

    $modAdmisi = null;
    if (!empty($pasienadmisi_id)) {
      $modAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
    }

    if (empty($model)) {

      $model = new AsesmengiziT;
      $model->tgl_konsultasi = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
      $model->pendaftaran_id = $pendaftaran_id;
      $model->pasien_id = $modPasien->pasien_id;
      $model->andewasallap = 0;

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
    } else {
      $model->tgl_konsultasi = MyFormatter::formatDateTimeForUser($model->tgl_konsultasi);
    }





    if (isset($_POST['AsesmengiziT'])) {
      $trans = Yii::app()->db->beginTransaction();
      // echo '<pre>';var_dump($_POST);die;
      try {
        $ok = true;

        $model->attributes = $_POST['AsesmengiziT'];
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

        // echo '<pre>';var_dump($model);die;

        if ($model->validate()) {
          $ok = $ok && $model->save();

          if (isset($_POST['AsesmengizidetT'])) {
            foreach ($_POST['AsesmengizidetT'] as $item) {
              $det = new AsesmengizidetT;
              $det->attributes = $item;
              $det->asesmengizi_id = $model->asesmengizi_id;

              $ok = $ok && $det->save();

              // var_dump($det->errors);
            }
          }
        } else {
          $ok = false;
          // var_dump($model->errors);
        }

        // var_dump($ok); die;
        if ($ok) {

          // $this->notifAsesmenGizi($model);

          $trans->commit();
          Yii::app()->user->setFlash('success', "Asesmen Gizi berhasil disimpan");

          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id));
        } else {
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan');
          $trans->rollback();
        }
      } catch (Exception $ex) {
        $trans->rollback(); // var_dump($ex->getMessage()); die;
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan ' . $ex->getMessage());
      }
    }

    $modRiwayat = new AsesmengiziT();
    $modRiwayat->pendaftaran_id = $pendaftaran_id;

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'dataPendaftaran' => $dataPendaftaran,
      'model' => $model,
      'modAdmisi' => $modAdmisi,
      'pasienadmisi_id' => $pasienadmisi_id,
      'pendaftaran_id' => $pendaftaran_id,
      'modRiwayat' => $modRiwayat
    ));
  }

  public function actionPrint($pendaftaran_id, $pasienadmisi_id)
  {

    $this->layout = '//layouts/printWindows';

    $model = AsesmengiziT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      //'pasienadmisi_id'=>$pasienadmisi_id,
    ), array(
      'condition' => 'pasienmasukpenunjang_id is null'
    ));

    $this->render($this->path_view . 'detail', array(
      'model' => $model,
    ));
  }
  public function actionDetail($asesmengizi_id)
  {

    $this->layout = '//layouts/iframe';

    $model = AsesmengiziT::model()->findByPk($asesmengizi_id);

    $this->render($this->path_view . 'detail', array(
      'model' => $model,
    ));
  }
}
