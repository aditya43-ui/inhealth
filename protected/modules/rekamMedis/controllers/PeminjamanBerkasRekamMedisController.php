<?php

class PeminjamanBerkasRekamMedisController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'rekamMedis.views.peminjamanBerkasRekamMedis.';
  public $peminjamandokumenrmtersimpan = false;

  public function actionIndex($id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Peminjaman Berkas Rekam Medis";
    $format = new MyFormatter();
    if (isset($id)) {
      $model = RKPeminjamanrmT::model()->findByPk($id);
      $modPengiriman = RKDokumenpasienrmlamaV::model()->findByAttributes(array('peminjamanrm_id' => $model->peminjamanrm_id));
      if (isset($modPengiriman)) {
        $model->lokasirak_nama = $modPengiriman->lokasirak_nama;
        $model->subrak_nama = $modPengiriman->subrak_nama;
        $model->warnadokrm_namawarna = $modPengiriman->warnadokrm_namawarna;
      }

      $modRekamMedis = RKDokrekammedisM::model()->with('pasien')->findByPk($model->dokrekammedis_id);
      $model->no_rekam_medik = $modRekamMedis->pasien->no_rekam_medik;
      $model->nama_pasien = $modRekamMedis->pasien->nama_pasien;
      $model->jenis_kelamin = $modRekamMedis->pasien->jeniskelamin;
      $model->tanggal_lahir = $format->formatDateTimeForUser($modRekamMedis->pasien->tanggal_lahir);
    } else {
      $model = new RKPeminjamanrmT;
      $model->namapeminjam = Yii::app()->user->getState('nama_pegawai');

      $model->tglakandikembalikan = date('Y-m-d H:i:s');
      $model->tglpeminjamanrm = date('Y-m-d H:i:s');
    }

    if (isset($_POST['RKPeminjamanrmT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['RKPeminjamanrmT'];
        $model->nourut_pinjam = MyGenerator::noUrutPinjamRM();
        $model->tglpeminjamanrm = isset($_POST['RKPeminjamanrmT']['tglpeminjamanrm']) ? $format->formatDateTimeForDb($_POST['RKPeminjamanrmT']['tglpeminjamanrm']) : date('Y-m-d H:i:s');
        $model->tglakandikembalikan = isset($_POST['RKPeminjamanrmT']['tglakandikembalikan']) ? $format->formatDateTimeForDb($_POST['RKPeminjamanrmT']['tglakandikembalikan']) : date('Y-m-d H:i:s');
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($model->validate()) {
          $this->peminjamandokumenrmtersimpan = true;
          $model->save();
          PendaftaranT::model()->updateByPk($model->pendaftaran_id, array('pengirimanrm_id' => null, 'peminjamanrm_id' => $model->peminjamanrm_id));
        } else {
          $this->peminjamandokumenrmtersimpan = false;
        }

        if ($this->peminjamandokumenrmtersimpan) {
          $transaction->commit();
          $this->redirect(array('index', 'id' => $model->peminjamanrm_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Peminjaman Dokumen Rekam Medis gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
          . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
          . "</a>";
        Yii::app()->user->setFlash('error', "Data Peminjaman Dokumen Rekam Medis gagal disimpan ! " . $btn_ulang . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model
    ));
  }

  public function actionGetNamaPeminjam()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->addCondition('pegawai_aktif is true');
      $criteria->order = 'nama_pegawai';
      $models = PegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->nama_pegawai;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * set umur dari tanggal lahir (date)
   */
  public function actionSetUmur()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data['umur'] = null;
      if (isset($_POST['tanggal_lahir']) && !empty($_POST['tanggal_lahir'])) {
        $data['umur'] = CustomFunction::hitungUmur($_POST['tanggal_lahir']);
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionPrintPeminjaman($id)
  {
    $this->layout = '//layouts/printWindows';
    $modPeminjaman = RKPeminjamanrmT::model()->with('dokrekammedis')->findByPk($id);
    RKPeminjamanrmT::model()->updateByPk($id, array('printpeminjaman' => true));
    $model = PasienM::model()->findByPk($modPeminjaman->dokrekammedis->pasien_id);
    $judulLaporan = "Peminjaman Dokumen Rekam Medis";
    $this->render($this->path_view . 'printKartu', array('modPasien' => $model, 'modPinjam' => $modPeminjaman, 'judulLaporan' => $judulLaporan));
  }

  protected function updatePrint($data = null)
  {
    if (isset($data)) {
      $jumlah = count((array)$data);
      for ($i = 0; $i < $jumlah; $i++) {
        RKPeminjamanrmT::model()->updateAll(array('printpeminjaman' => TRUE), 'pendaftaran_id = ' . $data[$i]);
      }
    }
  }

  //-- RekamMedis -- 
  //Get Daftar Pasien Lama untuk Peminjaman
  public function actionPasienLamauntukPeminjaman()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
      $criteria->addCondition('peminjamanrm_id is null or (peminjamanrm_id is not null and kembalirm_id is not null)');
      $criteria->order = 'no_rekam_medik';
      $models = DokumenpasienrmlamaV::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien;
        $returnVal[$i]['value'] = $model->no_rekam_medik;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionLoginPemakai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pemakai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pemakai';
      $models = LoginpemakaiK::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pemakai;
        $returnVal[$i]['value'] = $model->loginpemakai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        if (count((array)$models) > 1) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
}
