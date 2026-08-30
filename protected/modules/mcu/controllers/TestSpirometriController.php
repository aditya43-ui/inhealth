<?php

class TestSpirometriController extends Controller
{
  public $path_view = "mcu.views.testSpirometri.";

  public function actionAutocompletePegawaiMengetahui($term = null)
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $modPegawai = new PegawairuanganV();
    $modPegawai->unsetAttributes();
    $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');

    $modPegawai->nama_pegawai = strtolower($term);

    $prop = $modPegawai->search();
    $prop->criteria->order = 'nama_pegawai';

    $res = null;
    foreach ($prop->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->namaLengkap;
      $sub['value'] = $item->pegawai_id;

      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  public function actionIndex($pendaftaran_id, $baru = null)
  {
    $this->layout = '//layouts/iframe';

    $format = new MyFormatter();
    $criteria = new CDbCriteria();
    $criteria->addCondition('pendaftaran_id =' . $pendaftaran_id);
    $criteria->order = 'spirometri_id DESC';
    $model = SpirometriT::model()->find($criteria);
    if (empty($model) || isset($baru))
      $model = new SpirometriT();
    $model->spirometri_tgl = date('Y-m-d H:i:s');
    $modelRiwayat = new SpirometriT();
    if (isset($pendaftaran_id)) {
      $modelRiwayat = SpirometriT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPegawai = PegawaiV::model()->findByAttributes(array('pegawai_id' => $modPendaftaran->pegawai_id));
    }

    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

    if (empty($modPendaftaran)) {
      throw new CHttpException(400, "Data tidak ditemukan");
    }

    $modPemeriksaanFisik = McuPemeriksaanumumT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
    ), array(
      'order' => 'mcu_pemeriksaanumum_id desc',
    ));

    if (empty($modPemeriksaanFisik)) {
      $modPemeriksaanFisik = new McuPemeriksaanumumT;
    }

    $model = SpirometriT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
    ));

    if (empty($model)) {
      $model = new SpirometriT();
      $model->pendaftaran_id = $pendaftaran_id;
      $model->spirometri_tgl = date('Y-m-d H:i:s');
      $model->test_reversibilitas_is_positif = 0;
      $modelRiwayat = new SpirometriT();
      if (isset($pendaftaran_id)) {
        $modelRiwayat = SpirometriT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPegawai = PegawaiV::model()->findByAttributes(array('pegawai_id' => $modPendaftaran->pegawai_id));
        //$model->dokterpemeriksa_id = $modPendaftaran->pegawai_id;
      }
    }

    if (isset($_POST['SpirometriT'])) {

      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      try {
        $model->attributes = $_POST['SpirometriT'];

        foreach ($model->metadata->tableSchema->columns as $columnName => $column) {
          if ($column->dbType == "double precision") {
            $model->$columnName = MyFormatter::formatRupiahForDB($model->$columnName);
          }
        }

        if ($model->pakai_bronkhodilator == 1) $model->pakai_bronkhodilator = true;

        $model->test_reversibilitas_is_positif = $model->test_reversibilitas_is_positif == 1 ? true : false;

        $model->spirometri_tgl = MyFormatter::formatDateTimeForDb($model->spirometri_tgl);
        $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($model->validate()) {
          $ok = $ok && $model->save();
        } else {
          $ok = false;
        }

        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('index', 'pendaftaran_id' => $model->pendaftaran_id));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "<strong>Gagal!</strong> Data Gagal Disimpan.");
          $this->redirect(array('index', 'pendaftaran_id' => $model->pendaftaran_id));
        }
      } catch (Exception $e) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    if (!empty($model->pengetahui_id)) {
      $peg = PegawaiM::model()->findByPk($model->pengetahui_id);

      $model->mengetahui_nama = $peg->namaLengkap;
    }

    foreach ($model->metadata->tableSchema->columns as $columnName => $column) {
      if ($column->dbType == "double precision" && !empty($model->$columnName)) {
        $model->$columnName = number_format($model->$columnName, 2, ',', '');
      }
    }

    $model->spirometri_tgl = MyFormatter::formatDateTimeForUser($model->spirometri_tgl);


    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modelRiwayat' => $modelRiwayat,
      'modPendaftaran' => $modPendaftaran,
      'modPemeriksaanFisik' => $modPemeriksaanFisik,
      'format' => $format,
      'modPegawai' => $modPegawai
    ));
  }

  public function actionPrint()
  {
    $this->render($this->path_view . 'print');
  }

  public function actionDetail($id)
  {
    $this->layout = "//layouts/iframe";
    $format = new MyFormatter();
    $model = SpirometriT::model()->findByPk($id);
    $modPemeriksaanFisik = new McuPemeriksaanumumT;

    if (!empty($model->pengetahui_id)) {
      $modPegawai = PegawaiM::model()->findByPk($model->pengetahui_id);

      $model->mengetahui_nama = $modPegawai->namaLengkap;
    }

    $this->render($this->path_view . 'detail', array(
      'model' => $model,
      'format' => $format,
      'modPegawai' => $modPegawai,
      'modPemeriksaanFisik' => $modPemeriksaanFisik

    ));
  }

  public function actionUpdate($id)
  {
    $this->layout = "//layouts/iframe";
    $format = new MyFormatter();
    $model = SpirometriT::model()->findByPk($id);
    //var_dump($model);die();
    $modPemeriksaanFisik = new McuPemeriksaanumumT;

    if (!empty($model->pengetahui_id)) {
      $modPegawai = PegawaiM::model()->findByPk($model->pengetahui_id);

      $model->mengetahui_nama = $modPegawai->namaLengkap;
    }

    if (isset($_POST['SpirometriT']))
    //var_dump($_POST['SpirometriT']); die();
    {
      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modelSpirometri = SpirometriT::model()->findByPk($id);
        //var_dump($modelSpirometri); 
        $modelSpirometri->attributes = $_POST['SpirometriT'];
        $model->spirometri_tgl = $format->formatDateTimeForDb($_POST['SpirometriT']['spirometri_tgl']);
        $modelSpirometri->update_time = date('Y-m-d H:i:s');
        $modelSpirometri->update_loginpemakai_id = Yii::app()->user->id;

        if ($modelSpirometri->update()) {
          $ok = true;
        } else {
          $ok = false;
        }
        if ($ok == true) {

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil diubah");
          $this->redirect(array('update', 'id' => $modelSpirometri->spirometri_id, 'sukses' => 1));
          // die();
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Pemeriksaan Kandungan gagal diubah !");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pemeriksaan Kandungan gagal diubah ! " . MyExceptionMessage::getMessage($ex, true));
      }
    }
    $this->render($this->path_view . 'ubah/_formUbah', array(
      'model' => $model,
      'format' => $format,
      'modPegawai' => $modPegawai,
      'modPemeriksaanFisik' => $modPemeriksaanFisik
    ));
  }

  public function actionSetDelete()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $spirometri_id = isset($_POST['id']) ? $_POST['id'] : " ";
      $model = SpirometriT::model()->findByPk($spirometri_id);

      if ($model->delete()) {
        $data['status'] = true;
        $data['pesan'] = 'data pemeriksaan KAndungan berhasil dihapus !!';
      } else {
        $data['status'] = false;
        $data['pesan'] = 'data pemeriksaan KAndungan gagal dihapus !!';
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }
}
