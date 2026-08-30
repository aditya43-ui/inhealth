<?php
class AnestesiTRIController extends MyAuthController
{
  public function actionIndex($pendaftaran_id, $pasienadmisi_id = null)
  {
    $this->layout = '//layouts/iframe';

    $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $model = PasienanastesiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modRiwayat = PasienkirimkeunitlainT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modPenunjang = new PasienmasukpenunjangT();
    $modUnitLain = new PasienkirimkeunitlainT();

    if(empty($model)) {
      $model = new PasienanastesiT();
      $modUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
    }

    if (isset($_POST['PasienanastesiT'])) {

      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {

        //save: penunjang -> unit lain -> anastesi

        $lookup_ruangan = LookupM::model()->find("lookup_type = 'konfiganestesi' AND lookup_name = 'Ruangan Anestesi'");

        //Simpan Pasien Masuk Penunjang

        // $modPenunjang->pendaftaran_id = $pendaftaran_id;
        // $modPenunjang->pasien_id = $modPendaftaran->pasien_id;
        // $modPenunjang->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
        // $modPenunjang->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        // $modPenunjang->ruangan_id = !empty($lookup_ruangan) ? $lookup_ruangan->lookup_value : 26;
        // $modPenunjang->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
        // $modPenunjang->statusperiksa = 'ANTRIAN';
        // $modPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang('AN');
        // $modPenunjang->no_urutperiksa = MyGenerator::noAntrianPenunjang($modPenunjang->ruangan_id);
        // $modPenunjang->tglmasukpenunjang = MyFormatter::formatDateTimeForDb($_POST['PasienanastesiT']['tglanastesi']);
        // $modPenunjang->kunjungan = CustomFunction::getKunjungan($modPasien, $modPenunjang->ruangan_id);
        // $ok = $ok && $modPenunjang->save();

        // Simpan Pasien Kirim Ke Unit Lain

        $modUnitLain->attributes = $_POST['PasienkirimkeunitlainT'];
        $modUnitLain->isbayarkekasirpenunjang = false;
        // $modUnitLain->pasienmasukpenunjang_id = $modPenunjang->pasienmasukpenunjang_id;
        $modUnitLain->pendaftaran_id = $pendaftaran_id;
        $modUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($_POST['PasienkirimkeunitlainT']['tgl_kirimpasien']);
        $modUnitLain->jenisanastesi_id = $_POST['PasienkirimkeunitlainT']['jenisanastesi_id'];
        $modUnitLain->ruangan_id = !empty($lookup_ruangan) ? $lookup_ruangan->lookup_value : 26;
        $modUnitLain->pasien_id = $modPasien->pasien_id;
        $modUnitLain->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        $modUnitLain->instalasi_id = Yii::app()->user->getState('instalasi_id');
        $modUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modUnitLain->ruangan_id);
        $modUnitLain->create_time = date('Y-m-d H:i:s');
        $modUnitLain->update_time = date('Y-m-d H:i:s');
        $modUnitLain->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $modUnitLain->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $modUnitLain->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $ok = $ok && $modUnitLain->save();

        // $modPenunjang->pasienkirimkeunitlain_id = $modUnitLain->pasienkirimkeunitlain_id;
        // $ok = $ok && $modPenunjang->save();

        //Simpan Pasien Anastesi
        // $model->attributes = $_POST['PasienanastesiT'];
        // $model->pendaftaran_id = $pendaftaran_id;
        // $model->pasien_id = $modPendaftaran->pasien_id;
        // $model->statusanestesi = 'Evaluasi Pra Anastesi';
        // $model->dokteranastesi_id = $modUnitLain->pegawai_id;
        // // $model->pasienkirimkeunitlain_id = $modUnitLain->pasienkirimkeunitlain_id;
        // $model->pasienmasukpenunjang_id = $modPenunjang->pasienmasukpenunjang_id;
        // $model->ruangan_id = !empty($lookup_ruangan) ? $lookup_ruangan->lookup_value : 26;
        // $model->create_time = date('Y-m-d H:i:s');
        // // $modUnitLain->update_time = date('Y-m-d H:i:s');
        // $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        // // $modUnitLain->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        // $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        // $ok = $ok && $model->save();

        // echo '<pre>'; var_dump($modUnitLain->attributes, $modUnitLain->save(), $modUnitLain->getErrors()); die();

          if ($ok) {

              $transaction->commit();
              Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
              if (!empty($_GET['from'])) {
                  $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'sukses' => 1, 'update'=>'update'));
              } else {
                  $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'sukses' => 1, 'update'=>'update'));
              }
          } else {
              $transaction->rollback();
//                    Yii::app()->user->setFlash('error', "Data gagal disimpan !");
              Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($modUnitLain));
          }
      } catch (Exception $e) {
        echo '<pre>'; var_dump($e); die();
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pemakaian Bahan gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
  }

    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPenunjang' => $modPenunjang,
      'modUnitLain' => $modUnitLain,
      'modRiwayat' => $modRiwayat,
      'model' => $model,
     
    ));
  }

  public function actionHapusRiwayatAnestesi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = (isset($_POST['id']) ? $_POST['id'] : null);
      $data['pesan'] = "";
      $data['sukses'] = 0;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $deleteAnamnesa = PasienkirimkeunitlainT::model()->deleteByPk($id);
        if ($deleteAnamnesa) {
          $data['pesan'] = "Riwayat Anestesi Berhasil Dihapus!";
          $data['sukses'] = 1;
          $transaction->commit();
        } else {
          $data['pesan'] = "Gagal Menghapus Riwayat Anestesi";
          $data['sukses'] = 0;
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['pesan'] = "Hapus Data Gagal :" . MyExceptionMessage::getMessage($exc, true);
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }
  
}
