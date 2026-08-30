<?php
class KeperawatanController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';
  public $path_view = 'rawatJalan.views.keperawatan.';

  public function actionStatusSosial($pendaftaran_id)
  {
    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $model = RJSosialekonomispiritualT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')]);
    if(empty($model)){
      $model = new RJSosialekonomispiritualT();
    }else{
      if($model->tempattinggal == 'Kontrak'){
        $model->iskontrak = true;
      }else if($model->tempattinggal == 'Rumah Sendiri'){
        $model->isrumahsendiri = true;
      }else{
        $model->islainlain == true;
        $model->rumahlainlain = $model->tempattinggal;
      }

      if($model->is_pembiayaanperusahaan == true){
        $model->perusahaannama = $model->keterangan_pembiayaan;
      }else if($model->is_pembiayaanasuransi == true){
        $model->asuransinama = $model->keterangan_pembiayaan;
      }
    }

    if (isset($_POST['RJSosialekonomispiritualT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $ok = true;
      try {
        if(!empty($model)){
          $model->update_time = date('Y-m-d H:i:s');
          $model->update_loginpemakai_id = Yii::app()->user->id;
        }
        $model->attributes = $_POST['RJSosialekonomispiritualT'];
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->pasien_id = $modPendaftaran->pasien_id;
        $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
        $model->pendaftaran_id = $pendaftaran_id;
        if($_POST['RJSosialekonomispiritualT']['iskontrak'] == true){
          $model->tempattinggal = 'Kontrak';
        }else if($_POST['RJSosialekonomispiritualT']['isrumahsendiri'] == true){
          $model->tempattinggal = 'Rumah Sendiri';
        }else if($_POST['RJSosialekonomispiritualT']['islainlain'] == true){
          $model->tempattinggal = $_POST['RJSosialekonomispiritualT']['rumahlainlain'];
        }else{
          $model->tempattinggal = null;
        }

        if($_POST['RJSosialekonomispiritualT']['is_pembiayaanperusahaan'] == true){
          $model->keterangan_pembiayaan = $_POST['RJSosialekonomispiritualT']['perusahaannama'];
        }else if($_POST['RJSosialekonomispiritualT']['is_pembiayaanasuransi'] == true){
          $model->keterangan_pembiayaan = $_POST['RJSosialekonomispiritualT']['asuransinama'];
        }else{
          $model->keterangan_pembiayaan = null;
        }
        $ok &= $model->save();
        
        if($ok){
          $modAsesmenAwalKeperawatan = AsesmenawalperawatrjT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')]);
          if(empty($modAsesmenAwalKeperawatan)){
            $modAsesmenAwalKeperawatan = new AsesmenawalperawatrjT();
          }else{
            $modAsesmenAwalKeperawatan->update_time = date('Y-m-d H:i:s');
            $modAsesmenAwalKeperawatan->update_loginpemakai_id = Yii::app()->user->id;
          }
          
          $modAsesmenAwalKeperawatan->attributes = $model->attributes;
          $ok &= $modAsesmenAwalKeperawatan->save();
        }

        if ($ok) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil</strong>Data Berhasil disimpan');
          $this->redirect(array('statusSosial', 'pendaftaran_id' => $pendaftaran_id, 'id' => $model->sosialekonomispiritual_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan');
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($ex));
      }
    }

    $this->render($this->path_view . 'statusSosial', array(
      'model' => $model, 
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
    ));
  }

  public function actionSkriningGizi($pendaftaran_id, $ruangan = null, $salin = null)
  {
    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $pertanyaan = RJSkrininggizimstM::model()->findAllByAttributes(['skrininggizimst_jenis' => 'Rawat Jalan Dewasa', 'skrininggizimst_aktif' => true]);
    $create_ruangan = !empty($ruangan) ? $ruangan : Yii::app()->user->getState('ruangan_id');

    $cek = $model = RJSkrininggiziT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id, 'create_ruangan' => $create_ruangan]);
    if(empty($model)){
      $model = new RJSkrininggiziT();
      $modDetail = new RJSkriningmstT();
    }else{
      $cekDetail = $modDetail = RJSkriningmstT::model()->findAllByAttributes(['skrininggizi_id' => $model->skrininggizi_id]);
      if(empty($modDetail)){
        $modDetail = new RJSkriningmstT();
      }
    }
    
    $modRiwayat = new RJSkrininggiziT();
    $modRiwayat->pasien_id = $modPendaftaran->pasien_id;
    
    $data = [];
    foreach ($pertanyaan as $value) {
      $jawaban = RJJawabanskrininggizimstM::model()->findAllByAttributes(['skrininggizimst_id' => $value->skrininggizimst_id, 'jawabanskrininggizimst_aktif' => true]);
      
      $id = $value->skrininggizimst_id;
      $data['gizi'][$id]['pertanyaan'] = $value->skrininggizimst_nama;
      $data['gizi'][$id]['nilai'] = 0;
      foreach ($jawaban as $item) {
        $jawaban_id = $item->jawabanskrininggizimst_id;
        $data['gizi'][$id]['det'][$jawaban_id]['nama'] = $item->jawabanskrininggizimst_nama;
        $data['gizi'][$id]['det'][$jawaban_id]['nilai'] = $item->jawabanskrininggizimst_nilai;
        $data['gizi'][$id]['det'][$jawaban_id]['id'] = $item->jawabanskrininggizimst_id;
        $data['gizi'][$id]['det'][$jawaban_id]['kondisi'] = false;
        
        if(!empty($cek)){
          $nilai = RJSkriningmstT::model()->findByAttributes(['skrininggizi_id' => $model->skrininggizi_id, 'jawabanskrininggizimst_id' => $jawaban_id]);
          if(!empty($nilai)){
            $data['gizi'][$id]['det'][$jawaban_id]['kondisi'] = true;
            $data['gizi'][$id]['nilai'] = $item->jawabanskrininggizimst_nilai;
          }
        }
      }
    }

    if (isset($_POST['RJSkriningmstT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $ok = true;
      try {
        if(!empty($salin)){
          $model = new RJSkrininggiziT();
        }

        if(!empty($cek)){
          $model->update_time = date('Y-m-d H:i:s');
          $model->update_loginpemakai_id = Yii::app()->user->id;
        }
        $model->attributes = $_POST['RJSkrininggiziT'];
        $model->create_time = date('Y-m-d H:i:s');
        $model->pasien_id = $modPendaftaran->pasien_id;
        $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
        $model->pendaftaran_id = $pendaftaran_id;
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $ok &= $model->save();
        
        if(!empty($cekDetail)){
          $deleteDiagnosa = RJSkriningmstT::model()->deleteAllByAttributes(['skrininggizi_id' => $model->skrininggizi_id]);
        }

        foreach ($_POST['RJSkriningmstT'] as $key => $value) {
          if(!empty($value["jawabanskrininggizimst_id"])){
            $modDetail = new RJSkriningmstT();
            $modDetail->attributes = $_POST['RJSkriningmstT'];
            $modDetail->skrininggizimst_id = $value["skrininggizimst_id"];
            $modDetail->skriningmst_jawaban = $value["skriningmst_jawaban"];
            $modDetail->jawabanskrininggizimst_id = $value["jawabanskrininggizimst_id"];
            $modDetail->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modDetail->pasien_id = $modPendaftaran->pasien_id;
            $modDetail->pegawai_id = Yii::app()->user->getState('pegawai_id');
            $modDetail->pendaftaran_id = $pendaftaran_id;
            $modDetail->skrininggizi_id = $model->skrininggizi_id;
            $modDetail->create_loginpemakai = Yii::app()->user->id;
            $modDetail->create_time = date('Y-m-d H:i:s');
            $modDetail->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modDetail->update_time = date('Y-m-d H:i:s');
            $modDetail->update_loginpemakai = Yii::app()->user->id;
            $ok &= $modDetail->save();
          }
        }

        if($ok){
          $modAsesmenAwalKeperawatan = AsesmenawalperawatrjT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')]);
          if(empty($modAsesmenAwalKeperawatan)){
            $modAsesmenAwalKeperawatan = new AsesmenawalperawatrjT();
          }else{
            $modAsesmenAwalKeperawatan->update_time = date('Y-m-d H:i:s');
            $modAsesmenAwalKeperawatan->update_loginpemakai_id = Yii::app()->user->id;
          }
          
          $modAsesmenAwalKeperawatan->attributes = $model->attributes;
          $modAsesmenAwalKeperawatan->ruangan_id = Yii::app()->user->getState('ruangan_id');
          $ok &= $modAsesmenAwalKeperawatan->save();
        }

        if ($ok) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil</strong>Data Berhasil disimpan');
          $this->redirect(array('skriningGizi', 'pendaftaran_id' => $pendaftaran_id, 'id' => $model->skrininggizi_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan');
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($ex));
      }
    }

    $this->render($this->path_view . 'skriningGizi', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'model' => $model, 
      'modDetail' => $modDetail, 
      'data' => $data,
      'modRiwayat' => $modRiwayat
    ));
  }

  public function actionHapusRiwayat()
  {
    if (Yii::app()->request->isAjaxRequest) {
        $data['pesan'] = "";
        $data['sukses'] = 0;
        $data['pasien_id'] = "";
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $deleteDetail = RJSkriningmstT::model()->deleteAllByAttributes(['skrininggizi_id' => $_POST['skrininggizi_id']]);
            $model = RJSkrininggiziT::model()->findByPk($_POST['skrininggizi_id']);
            
            if ($deleteDetail) {
                if ($model->delete()) {
                    $data['pesan'] = "Riwayat Pemeriksaan Termasuk Detail Pemeriksaan Berhasil Dihapus!";
                    $data['sukses'] = 1;
                    $data['pasien_id'] = $model->pasien_id;
                    $transaction->commit();
                } else {
                    $transaction->rollback();
                    $data['pesan'] = "Gagal Menghapus Pemeriksaan";
                    $data['sukses'] = 0;
                }
            } else {
                $transaction->rollback();
                $data['pesan'] = "Gagal Menghapus Detail Pemeriksaan";
                $data['sukses'] = 0;
            }
        } catch (Exception $exc) {
            $transaction->rollback();
            $data['pesan'] = "Transaksi Gagal :" . MyExceptionMessage::getMessage($exc, true);
        }
        prints:
        echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  public function actionAjaxDetail()
  {
    if (Yii::app()->request->isAjaxRequest) {
        $skrininggizi_id = $_POST['skrininggizi_id'];
        $model = RJSkrininggiziT::model()->findByPk($skrininggizi_id);
        $pertanyaan = RJSkrininggizimstM::model()->findAllByAttributes(['skrininggizimst_jenis' => 'Rawat Jalan Dewasa', 'skrininggizimst_aktif' => true]);

        $data = [];
        foreach ($pertanyaan as $value) {
          $jawaban = RJJawabanskrininggizimstM::model()->findAllByAttributes(['skrininggizimst_id' => $value->skrininggizimst_id, 'jawabanskrininggizimst_aktif' => true]);
          
          $id = $value->skrininggizimst_id;
          $data['gizi'][$id]['pertanyaan'] = $value->skrininggizimst_nama;
          $data['gizi'][$id]['nilai'] = 0;
          foreach ($jawaban as $item) {
            $jawaban_id = $item->jawabanskrininggizimst_id;
            $data['gizi'][$id]['det'][$jawaban_id]['nama'] = $item->jawabanskrininggizimst_nama;
            $data['gizi'][$id]['det'][$jawaban_id]['nilai'] = $item->jawabanskrininggizimst_nilai;
            $data['gizi'][$id]['det'][$jawaban_id]['id'] = $item->jawabanskrininggizimst_id;
            $data['gizi'][$id]['det'][$jawaban_id]['kondisi'] = false;
            
            if(!empty($model)){
              $nilai = RJSkriningmstT::model()->findByAttributes(['skrininggizi_id' => $model->skrininggizi_id, 'jawabanskrininggizimst_id' => $jawaban_id]);
              if(!empty($nilai)){
                $data['gizi'][$id]['det'][$jawaban_id]['kondisi'] = true;
                $data['gizi'][$id]['nilai'] = $item->jawabanskrininggizimst_nilai;
              }
            }
          }
        }

        $data['result'] = $this->renderPartial($this->path_view . 'skriningGizi/_viewDetail', array('data' => $data, 'model' => $model), true);

        echo json_encode($data);
        Yii::app()->end();
    }
  }
}
