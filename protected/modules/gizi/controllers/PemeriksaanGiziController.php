<?php
class PemeriksaanGiziController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'gizi.views.pemeriksaanGizi.';
  /**
   * Lists all models.
   */
  public function actionIndex($pendaftaran_id, $pasien_id, $pasienadmisi_id, $pasienmasukpenunjang_id = null, $konsulpoli_id = null)
  {
    $modPendaftaran = GZPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = GZPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $modKonsul = new KonsulpoliT;

    if(!empty($konsulpoli_id)) {
      $modKonsul = KonsulpoliT::model()->findByPk($konsulpoli_id);
    }

    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modKonsul' => $modKonsul
    ));
  }

  public function actionJawabKonsul($pendaftaran_id, $pasien_id, $pasienadmisi_id, $pasienmasukpenunjang_id = null, $konsulpoli_id = null) {
    
    $this->layout = "//layouts/iframe";
    
    $modPendaftaran = GZPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = GZPasienM::model()->findByPk($modPendaftaran->pasien_id);

    


    $kirim = PasienkirimkeunitlainT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id,
    ));

    if (!empty($kirim)) {
      $modKonsul = KonsulpoliT::model()->findByAttributes(array(
        'pasienkirimkeunitlain_id' => $kirim->pasienkirimkeunitlain_id,
      ));
    }

    if(!empty($konsulpoli_id)) {
      $modKonsul = KonsulpoliT::model()->findByPk($konsulpoli_id);
    }

    if (empty($modKonsul)) {
      
      $modKonsul = new KonsulpoliT;
      $modKonsul->tglkonsulpoli = $kirim->tgl_kirimpasien ?? date('Y-m-d H:i:s');
      $modKonsul->uraian_konsul = $kirim->catatandokterpengirim;
      $modKonsul->pegawai_id = $kirim->pegawai_id;
      // var_dump($modKonsul->attributes, $kirim->attributes); die;
    }

    $modKonsul->tglkonsulpoli = MyFormatter::formatDateTimeForUser($modKonsul->tglkonsulpoli);


    if ($modKonsul->isNewRecord) {
      $crLama = new CDbCriteria;
      $crLama->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
      $crLama->compare('pendaftaran_id', $modPendaftaran->pendaftaran_id);
      $crLama->order = "konsulpoli_id desc";

      $konsulLama = KonsulpoliT::model()->find($crLama);

      if (!empty($konsulLama)) {
        $modKonsul->uraian_konsuljawaban = $konsulLama->uraian_konsuljawaban;

        // vaR_dump($modKonsul->uraian_konsuljawaban);
      }
    }

    $pasienMorbiditas = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));

    $modMorbiditas = GZPasienMorbiditasT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
    ));
    

    // var_dump($modKonsul->attributes); die;
    
    if(isset($_POST['KonsulpoliT'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {

        $ok = true;

        $modKonsul->attributes = $_POST['KonsulpoliT'];
        $modKonsul->uraian_konsuljawaban = $_POST['KonsulpoliT']['uraian_konsuljawaban'] ?? $modKonsul->uraian_konsuljawaban;
        $modKonsul->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modKonsul->pasien_id = $modPendaftaran->pasien_id;
        $modKonsul->tglkonsulpoli = date('Y-m-d H:i:s');
        $modKonsul->tgljawabpoli = date('Y-m-d H:i:s');

        $modKonsul->statusperiksa = $modPendaftaran->statusperiksa;
        $modKonsul->asalpoliklinikkonsul_id = $kirim->create_ruangan;

        $modKonsul->create_time = date('Y-m-d H:i:s');
        $modKonsul->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modKonsul->create_loginpemakai_id = Yii::app()->user->id;
        $modKonsul->create_ruangan = $kirim->create_ruangan ?? Yii::app()->user->getState('ruangan_id');


        if (!empty($kirim)) {
          $modKonsul->pasienkirimkeunitlain_id = $kirim->pasienkirimkeunitlain_id;
        }


        // var_dump($modKonsul->attributes, $_POST); die;

        $ok &= $modKonsul->save();

        if ($ok) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('jawabKonsul', 'pendaftaran_id' => $pendaftaran_id, 'pasien_id' => $pasien_id, 'pasienadmisi_id' => $pasienadmisi_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'konsulpoli_id' => $modKonsul->konsulpoli_id, 'sukses' => 1));
        } else {
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan ' . '<pre>' .
            print_r($modKonsul->getErrors(), 1) . '</pre>');

          //                            Yii::app()->user->setFlash('error','<strong>Gagal</strong> Data gagal disimpan');
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan ' . $ex->getMessage());
      }

    }

    $this->render('indexKonsul', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modKonsul' => $modKonsul,
      'pasienMorbiditas' => $pasienMorbiditas,
      'modMorbiditas' => $modMorbiditas,
    ));
  }

  function actionJawabanKonsul($pendaftaran_id, $pasien_id, $pasienadmisi_id, $pasienmasukpenunjang_id = null, $konsulpoli_id = null) {
    $this->layout = "//layouts/iframe";

    $modPendaftaran = GZPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = GZPasienM::model()->findByPk($modPendaftaran->pasien_id);

    
    $modUraian = new GZPasienMorbiditasT();

    $kirim = PasienkirimkeunitlainT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id,
    ));

    if (!empty($kirim)) {
      $model = KonsulpoliT::model()->findByAttributes(array(
        'pasienkirimkeunitlain_id' => $kirim->pasienkirimkeunitlain_id,
      ));
    }

    if(!empty($konsulpoli_id)) {
      $model = KonsulpoliT::model()->findByPk($konsulpoli_id);
    }

    if (empty($model)) {
      
      $model = new KonsulpoliT;
      $model->tglkonsulpoli = $kirim->tgl_kirimpasien ?? date('Y-m-d H:i:s');
      $model->uraian_konsul = $kirim->catatandokterpengirim;
      $model->pegawai_id = $kirim->pegawai_id;
      // var_dump($modKonsul->attributes, $kirim->attributes); die;
    }

    $model->tglkonsulpoli = MyFormatter::formatDateTimeForUser($model->tglkonsulpoli);


    if ($model->isNewRecord) {
      $crLama = new CDbCriteria;
      $crLama->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
      $crLama->compare('pendaftaran_id', $modPendaftaran->pendaftaran_id);
      $crLama->order = "konsulpoli_id desc";

      $konsulLama = KonsulpoliT::model()->find($crLama);

      if (!empty($konsulLama)) {
        $model->uraian_konsuljawaban = $konsulLama->uraian_konsuljawaban;

        // vaR_dump($model->uraian_konsuljawaban);
      }
    }

    $pasienMorbiditas = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));

    $modMorbiditas = GZPasienMorbiditasT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
    ));
    

    // var_dump($model->attributes); die;
    
    if(isset($_POST['KonsulpoliT'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {

        $ok = true;

        $model->attributes = $_POST['KonsulpoliT'];
        $model->uraian_konsuljawaban = $_POST['KonsulpoliT']['uraian_konsuljawaban'] ?? $model->uraian_konsuljawaban;
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
        $model->tglkonsulpoli = date('Y-m-d H:i:s');
        $model->tgljawabpoli = date('Y-m-d H:i:s');

        $model->statusperiksa = $modPendaftaran->statusperiksa;
        $model->asalpoliklinikkonsul_id = $kirim->create_ruangan;

        $model->create_time = date('Y-m-d H:i:s');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = $kirim->create_ruangan ?? Yii::app()->user->getState('ruangan_id');


        if (!empty($kirim)) {
          $model->pasienkirimkeunitlain_id = $kirim->pasienkirimkeunitlain_id;
        }


        // var_dump($model->attributes, $_POST); die;

        $ok &= $model->save();

        if ($ok) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('jawabanKonsul', 'pendaftaran_id' => $pendaftaran_id, 'pasien_id' => $pasien_id, 'pasienadmisi_id' => $pasienadmisi_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'konsulpoli_id' => $model->konsulpoli_id, 'sukses' => 1));
        } else {
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan ' . '<pre>' .
            print_r($model->getErrors(), 1) . '</pre>');

          //                            Yii::app()->user->setFlash('error','<strong>Gagal</strong> Data gagal disimpan');
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan ' . $ex->getMessage());
      }

    }

    $this->render('jawabankonsul/index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'model' => $model,
      'pasienMorbiditas' => $pasienMorbiditas,
      'modMorbiditas' => $modMorbiditas,
      'modUraian' => $modUraian
    ));
  }
}