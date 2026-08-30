<?php

/**
 *       - digunakan sebagai url utama untuk mengelola informasi dan tambah hukuman poin pegawai
 *       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *       @website	<piindonesia.co.id>
 */
class HukumanPoinPegawaiController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'kepegawaian.views.hukumanPoinPegawai.';
  public $saveDetail = true;

  /**
   * Lists all models.
   */
  public function actionIndex($id = null)
  {
    $format = new MyFormatter;
    $model = new KPPoinpegawaiR;
    $modPeg = new KPPegawaiM;
    $modDet = new KPPoinpegdetR;
    $det = new KPPoinpegdetR;

    $model->poinpegawai_tgl = date('Y-m-d');
    $model->pegpembuat_id = Yii::app()->user->getState('pegawai_id');
    $model->pegpembuat_nama = Yii::app()->user->getState('nama_pegawai');


    if (isset($_POST['KPPoinpegawaiR'])) {
      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['KPPoinpegawaiR'];
        $model->poinpegawai_tgl =  MyFormatter::formatDateTimeForDb($_POST['KPPoinpegawaiR']['poinpegawai_tgl']);
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->ruangan_id;
        $model->create_time = date('Y-m-d H:i:s');
        $ok = $ok && $model->save();

        // var_dump($_POST['KPPoinpegdetR']);die;
        if ($ok) {
          if (isset($_POST['KPPoinpegdetR'])) {

            foreach ($_POST['KPPoinpegdetR'] as $key => $postDetail) {
              if (isset($_POST['KPPoinpegdetR'][$key])) {

                $modDet = new KPPoinpegdetR;
                $modDet->attributes = $_POST['KPPoinpegdetR'][$key];
                $modDet->poinpegawai_id = $model->poinpegawai_id;
                $ok = $ok && $modDet->save();
              }
            }
          }
        }
        //   $ok = false;
        // die;
        if ($ok) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('index', 'id' => $model->pegawai_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "<strong>Gagal!</strong> Data Gagal Disimpan.");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Penilaiaan gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    if (!empty($id)) {
      $modPeg = KPPegawaiM::model()->findByPk($id);
      $modPeg->jabatan_id = (isset($modPeg->jabatan_id) ? $modPeg->jabatan_id : null);
      $modPeg->jabatan_nama = (isset($modPeg->jabatan_id) ? $modPeg->jabatan->jabatan_nama : "-");
      $modPeg->pangkat_id = (isset($modPeg->pangkat_id) ? $modPeg->pangkat_id : null);
      $modPeg->pangkat_nama = (isset($modPeg->pangkat_id) ? $modPeg->pangkat->pangkat_nama : "-");
      $modPeg->kelompokpegawai_id = (isset($modPeg->kelompokpegawai_id) ? $modPeg->kelompokpegawai_id : null);
      $modPeg->kelompokpegawai_nama = (isset($modPeg->kelompokpegawai_id) ? $modPeg->kelompokpegawai->kelompokpegawai_nama : "-");
      $modPeg->pendidikan_id = (isset($modPeg->pendidikan_id) ? $modPeg->pendidikan_id : null);
      $modPeg->pendidikan_nama = (isset($modPeg->pendidikan_id) ? $modPeg->pendidikan->pendidikan_nama : "-");
      $modPeg->tgl_lahirpegawai = (isset($modPeg->tgl_lahirpegawai) ? $format->formatDateTimeForUser($modPeg->tgl_lahirpegawai) : "-");

      $model->pegawai_id = $id;
    }

    if (isset($_POST['KPPoinpegdetR'])) {
      $det = $_POST['KPPoinpegdetR'];
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model,
      'modPeg' => $modPeg,
      'modDet' => $modDet,
      'det' => $det
    ));
  }

  public function actionCekDataHukum()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
      $tgl = isset($_POST['tgl']) ? $_POST['tgl'] : null;

      $cek = KPPoinpegawaiR::model()->findByAttributes(array('pegawai_id' => $pegawai_id, 'poinpegawai_tgl' => MyFormatter::formatDateTimeForDb($tgl)));
      $peg = KPPegawaiM::model()->findByPk($pegawai_id);

      if (!empty($cek)) {
        $data['sukses'] = 1;
        $data['pesan'] = "Maaf, <b>Hukuman Poin Pegawai</b> pada tanggal <b>" . $tgl . "</b> untuk pegawai <b>" . $peg->nama_pegawai . "</b> sudah tercatatkan ";
      } else {
        $data['suskes'] = 0;
      }

      echo json_encode($data);

      Yii::app()->end();
    }
  }

  /**
   * - digunakan untuk menampilkan inforimasi hukuman poin pegawai
   */
  public function actionInformasi()
  {
    $model  = new KPInfohukumanpoinpegV;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['KPInfohukumanpoinpegV'])) {
      $model->attributes = $_GET['KPInfohukumanpoinpegV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['KPInfohukumanpoinpegV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['KPInfohukumanpoinpegV']['tgl_akhir']);
    }

    $this->render($this->path_view . 'informasi', array('model' => $model));
  }

  /**
   * - digunakan untuk menampilkan detail data poin pegawai, untuk melihat jumlah poin per nilai poin
   * @param type $id
   */
  public function actionDetail($id)
  {
    $this->layout = '//layouts/iframe';
    $model = KPPoinpegawaiR::model()->findByPk($id);
    $modDet = KPPoinpegdetR::model()->findAllByAttributes(array('poinpegawai_id' => $model->poinpegawai_id));

    $model->poinpegawai_tgl = MyFormatter::formatDateTimeForDb($model->poinpegawai_tgl);

    $this->render($this->path_view . 'detail/_detailInfo', array(
      'model' => $model,
      'modDet' => $modDet,
      'judulLaporan' => 'Informasi Hukuman Poin Pegawai'
    ));
  }
}
