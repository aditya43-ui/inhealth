<?php

class PeriksaRonggaMulutController extends MyAuthController
{
  protected $path_view = 'rawatJalan.views.periksaRonggaMulut.';

  public function actionIndex($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';

    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modBagianTubuh = new RJBagiantubuhM();
    $modGambarTubuh = new RJGambartubuhM();
    $modPemeriksaanGambar = PemeriksaangambarronggamulutT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $model = PeriksaronggamulutT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
    ));

    if (empty($model)) {
      $model = new PeriksaronggamulutT;
      $model->tglperiksaronggamulut = MyFormatter::formatDateTimeForDb(date('Y-m-d H:i:s'));
      $model->pegawai_id = $modPendaftaran->pegawai_id;
    } else {
      $model->tglperiksaronggamulut = MyFormatter::formatDateTimeForDb($model->tglperiksaronggamulut);
    }

    if (isset($_POST['PeriksaronggamulutT'])) {
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      try {
        $model->attributes = $_POST['PeriksaronggamulutT'];
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
        $model->create_time = MyFormatter::formatDateTimeForDb(date('Y-m-d H:i:s'));
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($model->validate()) {
          $ok = $ok && $model->save();
        } else {
          $ok = false;
        }


        if (isset($_POST['PemeriksaangambarronggamulutT'])) {
          foreach ($_POST['PemeriksaangambarronggamulutT'] as $item) {
            if (isset($item['pemeriksaangambarronggamulut_id']) && !empty($item['pemeriksaangambarronggamulut_id'])) {
              $det = PemeriksaangambarronggamulutT::model()->findByPk($item['pemeriksaangambarronggamulut_id']);


              $det->update_time = MyFormatter::formatDateTimeForDb(date('Y-m-d H:i:s'));
              $det->update_loginpemakai_id = Yii::app()->user->id;
            } else {
              $det = new PemeriksaangambarronggamulutT;
              $det->tglpemeriksaan = MyFormatter::formatDateTimeForDb($model->tglperiksaronggamulut);
            }
            $det->attributes = $item;
            $det->periksaronggamulut_id = $model->periksaronggamulut_id;
            $det->pasien_id = $model->pasien_id;
            $det->pendaftaran_id = $model->pendaftaran_id;
            $det->bentuklesi = $item['reguler'];

            $det->create_time = MyFormatter::formatDateTimeForDb(date('Y-m-d H:i:s'));
            $det->create_loginpemakai_id = Yii::app()->user->id;
            $det->create_ruangan = Yii::app()->user->getState('ruangan_id');

            if ($det->validate()) {
              $ok = $ok && $det->save();
            } else {
              $ok = false;
            }
          }
        }

        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', 'Pemeriksaan berhasil disimpan');
          $this->redirect(['index', 'pendaftaran_id' => $modPendaftaran->pendaftaran_id]);
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', 'Pemeriksaan gagal disimpan');
          $this->redirect(['index', 'pendaftaran_id' => $modPendaftaran->pendaftaran_id]);
        }
      } catch (Exception $ex) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', 'Pemeriksaan gagal disimpan.' . MyExceptionMessage::getMessage($ex, true));
      }
    }



    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modBagianTubuh' => $modBagianTubuh,
      'modGambarTubuh' => $modGambarTubuh,
      'modPemeriksaanGambar' => $modPemeriksaanGambar,
      'model' => $model
    ));
  }

  public function actionPrint()
  {
    $this->render('print');
  }

  public function actionGetBagianTubuhId()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $data = array();
      $kordinat_x = $_POST['kordinat_x'];
      $kordinat_y = $_POST['kordinat_y'];
      $gambartubuh_id = $_POST['gambartubuh_id'];

      $cr = new CDbCriteria();
      $cr->addCondition("" . $kordinat_x . " between kordinat_x and kordinat_x2");
      $cr->addCondition("" . $kordinat_y . " between kordinat_y and kordinat_y2");
      $cr->compare('gambartubuh_id', $gambartubuh_id);
      $cr->order = ('bagiantubuh_urutan asc');

      $result = BagiantubuhM::model()->find($cr);

      $modList = BagiantubuhM::model()->findAllByAttributes(array(
        'gambartubuh_id' => $gambartubuh_id,
        'bagiantubuh_aktif' => true,
      ), array(
        'order' => 'bagiantubuh_urutan',
      ));

      $option = '<option value="">-- Pilih --</option>';

      foreach ($modList as $item) {
        $option .= '<option value="' . $item->bagiantubuh_id . '">' . $item->namabagtubuh . '</option>';
      }

      //          $loadPemeriskaanGamabr = RJPemeriksaangambarT::model()->findByPk($_POST['pemeriksaangambar_id']);
      //$sql = "select bagiantubuh_id, namabagtubuh from bagiantubuh_m where (".$kordinat_x." >= kordinat_x2 AND ".$kordinat_x." <= kordinat_x) AND (".$kordinat_y." >= kordinat_y AND ".$kordinat_y." <= kordinat_y2) ORDER BY bagiantubuh_urutan ASC LIMIT 1";
      $data['options'] = $option;
      $data['bagiantubuh_id'] = $result['bagiantubuh_id'];

      if (!empty($result)) {
        $data['pesan'] = '';
        $data['namabagtubuh'] = $result['namabagtubuh'];
      }
      echo json_encode($data);
    }
    Yii::app()->end();
  }

  public function actionTambahBagianTubuh()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $form = '';
      if (!empty($_POST['bagiantubuh_id'])) {
        $modPemeriksaanGbr = new PemeriksaangambarronggamulutT();
        $modPemeriksaanGbr->bagiantubuh_id      = $_POST['bagiantubuh_id'];
        $modPemeriksaanGbr->namabagtubuh      = $modPemeriksaanGbr->bagiantubuh->namabagtubuh;
        $modPemeriksaanGbr->keterangan_periksa_gbr  = $_POST['keterangan'];
        $modPemeriksaanGbr->kordinat_tubuh_x    = $_POST['pic_x'];
        $modPemeriksaanGbr->kordinat_tubuh_y    = $_POST['pic_y'];
        $modPemeriksaanGbr->gambartubuh_id          = $_POST['gambartubuh_id'];
        $modPemeriksaanGbr->lebar                   = $_POST['lebar'];
        $modPemeriksaanGbr->rotasi                  = $_POST['rotasi'];
        $modPemeriksaanGbr->reguler                 = isset($_POST['reguler']) ? $_POST['reguler'] : '';


        $form = $this->renderPartial($this->path_view . '_rowDetail', array('modPemeriksaanGbr' => $modPemeriksaanGbr), true);
        $axis['lebar'] = $modPemeriksaanGbr->lebar;
        $axis['rotasi'] = $modPemeriksaanGbr->rotasi;
        $axis['x'] = $modPemeriksaanGbr->kordinat_tubuh_x;
        $axis['y'] = $modPemeriksaanGbr->kordinat_tubuh_y;
        echo CJSON::encode(array('pesan' => $pesan, 'form' => $form, 'axis' => $axis, 'bagiantubuh_id' => $modPemeriksaanGbr->bagiantubuh_id));
      } else {
        $pesan = 'Bagian tubuh tidak boleh kosong!';
        echo CJSON::encode(array('pesan' => $pesan));
      }
    }
    Yii::app()->end();
  }

  public function actionHapusBagianTubuh()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $ok = 0;
      $del = true;




      $ok = PemeriksaangambarronggamulutT::model()->findByAttributes(
        array(
          'pemeriksaangambarronggamulut_id' => $_POST['pemeriksaangambarronggamulut_id'],
        )
      );

      if (!empty($ok)) {
        $del = $del && $ok->delete();
      }



      if ($del) {
        $pesan = 'Data Berhasil Dihapus dari database';
        $ok = 1;
        echo CJSON::encode(array('pesan' => $pesan, 'ok' => $ok));
      } else {
        $ok = 0;
        $pesan = "Bagian Tubuh gagal dihapus!";
        echo CJSON::encode(array('pesan' => $pesan, 'ok' => $ok));
      }
    }
    Yii::app()->end();
  }
}
