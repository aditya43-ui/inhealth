<?php

class PemeriksaanAnamnesaRKController extends MyAuthController
{
  public $layout = '//layouts/column1';
  //public $defaultAction = 'index';
  public $tab = 'anamnesa';
  public $judul = 'Pemeriksaan Anamnesa';
  public $path_view = 'rekamMedis.views.pemeriksaanAnamnesaRK.';
  //public $peminjamandokumenrmtersimpan = false;

  public function actionIndex()
  {
    $modPendaftaran = new RKPendaftaranT;
    $modPasien = new RKPasienM;
    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
    ));
  }

  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $returnVal['pesan'] = "";
      $criteria = new CDbCriteria();
      $model = RKPendaftaranT::model()->findByPk($_POST['pendaftaran_id']);

      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }

      //$returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["no_rekam_medik"] = $model->pasien->no_rekam_medik;
      $returnVal["nama_pasien"] = $model->pasien->namadepan . " " . $model->pasien->nama_pasien;
      $returnVal["jeniskelamin"] = $model->pasien->namadepan . " " . $model->pasien->jeniskelamin;
      $returnVal["jeniskasuspenyakit_nama"] = $model->jeniskasuspenyakit->jeniskasuspenyakit_nama;
      $returnVal["namaLengkap"] = $model->pegawai->namaLengkap;
      $returnVal["carabayar_nama"] = $model->carabayar->carabayar_nama;
      $returnVal["penjamin_nama"] = $model->penjamin->penjamin_nama;
      $returnVal["photopasien"] = $model->pasien->photopasien;
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompleteKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      // $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : null;
      // $no_masukpenunjang = isset($_GET['no_masukpenunjang']) ? $_GET['no_masukpenunjang'] : null;
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->with = array('pasien');
      // $criteria->compare('LOWER(no_masukpenunjang)', strtolower($no_masukpenunjang), true);
      $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($nama_pasien), true);
      //  $criteria->addCondition('ruangan_id = '.$ruangan_id);
      $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
      $criteria->limit = 5;
      $models = RKPendaftaranT::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_pendaftaran . "-" . $model->pasien->no_rekam_medik . '-' . $model->pasien->nama_pasien . (!empty($model->pasien->nama_bin) ? "(" . $model->pasien->nama_bin . ")" : "");
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
