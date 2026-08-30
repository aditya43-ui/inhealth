<?php

/**
 * RND-7811 : INI SUDAH TIDAK DIGUNAKAN LAGI, FUNCTION PINDAHKAN KE CONTROLLER MASING2
 */
class ActionAutoCompleteController extends MyAuthController
{
  /**
   * actionDaftarPasien digunakan di Transaksi Penjualan Resep Pasien RS
   * edited by
   */
  public function actionDaftarPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $models = null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
      //$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
      if (isset($_GET['instalasiId'])) {
        if (!empty($_GET['instalasiId'])) {
          $criteria->addCondition("instalasi_id = " . $_GET['instalasiId']);
        }
      }
      $criteria->limit = 5;
      $criteria->order = 'tgl_pendaftaran DESC';
      //kembalikan format
      if ($_GET['instalasiId'] == Params::INSTALASI_ID_RD) {
        $models = FAInfoKunjunganRDV::model()->findAll($criteria);
      } else if ($_GET['instalasiId'] == Params::INSTALASI_ID_RJ) {
        $models = FAInfoKunjunganRJV::model()->findAll($criteria);
      } else if ($_GET['instalasiId'] == Params::INSTALASI_ID_RI) {
        $models = FAInfopasienmasukkamarV::model()->findAll($criteria);
      }
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->no_pendaftaran . ' - ' . $model->tgl_pendaftaran; //.' - '.$model->statusperiksa
        $returnVal[$i]['value'] = $model->no_rekam_medik;
        $returnVal[$i]['jeniskelamin'] = $model->jeniskelamin;
        $returnVal[$i]['namapasien'] = $model->nama_pasien;
        $returnVal[$i]['namabin'] = $model->nama_bin;
        $returnVal[$i]['jeniskasuspenyakit'] = $model->jeniskasuspenyakit_nama;
        $returnVal[$i]['namainstalasi'] = $model->instalasi_nama;
        $returnVal[$i]['namaruangan'] = $model->ruangan_nama;
        $returnVal[$i]['carabayar_nama'] = $model->carabayar_nama;
        $returnVal[$i]['penjamin_nama'] = $model->penjamin_nama;
        //cari tanggungan penjamin
        $criteria = new CDbCriteria();
        if (!empty($model->penjamin_id)) {
          $criteria->addCondition("penjamin_id = " . $model->penjamin_id);
        }
        if (!empty($model->kelaspelayanan_id)) {
          $criteria->addCondition("kelaspelayanan_id = " . $model->kelaspelayanan_id);
        }
        if (!empty($model->carabayar_id)) {
          $criteria->addCondition("carabayar_id = " . $model->carabayar_id);
        }
        $tanggungan = TanggunganpenjaminM::model()->find($criteria);
        $returnVal[$i]['subsidirumahsakitoa'] = $tanggungan->subsidirumahsakitoa;
        $returnVal[$i]['subsidipemerintahoa'] = $tanggungan->subsidipemerintahoa;
        $returnVal[$i]['subsidiasuransioa'] = $tanggungan->subsidiasuransioa;
        $returnVal[$i]['iurbiayaoa'] = $tanggungan->iurbiayaoa;
        $returnVal[$i]['makstanggpel'] = $tanggungan->makstanggpel;
        //cari dokter ruangan
        $pasienAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        if (!empty($pasienAdmisi->pasienadmisi_id)) {
          $returnVal[$i]['pegawai_id'] = $pasienAdmisi->pegawai_id;
          $returnVal[$i]['pegawai_nama'] = PegawaiM::model()->findByPk($pasienAdmisi->pegawai_id)->NamaLengkap;
        } else {
          $returnVal[$i]['pegawai_id'] = $model->pegawai_id;
          $returnVal[$i]['pegawai_nama'] = PegawaiM::model()->findByPk($model->pegawai_id)->NamaLengkap;
        }
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * actionDaftarPasien digunakan di Transaksi Penjualan Resep Pasien RS
   * edited by
   */
  public function actionNamaPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $models = null;
      $criteria = new CDbCriteria();
      //$criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($_GET['term']), true);
      if (!empty($_GET['instalasiId'])) {
        $criteria->addCondition("instalasi_id = " . $_GET['instalasiId']);
      }
      $criteria->limit = 5;
      $criteria->order = 'tgl_pendaftaran DESC';
      //kembalikan format
      if ($_GET['instalasiId'] == Params::INSTALASI_ID_RD) {
        $models = FAInfoKunjunganRDV::model()->findAll($criteria);
      } else if ($_GET['instalasiId'] == Params::INSTALASI_ID_RJ) {
        $models = FAInfoKunjunganRJV::model()->findAll($criteria);
      } else if ($_GET['instalasiId'] == Params::INSTALASI_ID_RI) {
        $models = FAInfopasienmasukkamarV::model()->findAll($criteria);
      }
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pasien . ' - ' . $model->no_rekam_medik . ' - ' . $model->alamat_pasien; //.' - '.$model->statusperiksa
        $returnVal[$i]['value'] = $model->nama_pasien;
        $returnVal[$i]['jeniskelamin'] = $model->jeniskelamin;
        $returnVal[$i]['namapasien'] = $model->nama_pasien;
        $returnVal[$i]['namabin'] = $model->nama_bin;
        $returnVal[$i]['jeniskasuspenyakit'] = $model->jeniskasuspenyakit_nama;
        $returnVal[$i]['namainstalasi'] = $model->instalasi_nama;
        $returnVal[$i]['namaruangan'] = $model->ruangan_nama;
        $returnVal[$i]['carabayar_nama'] = $model->carabayar_nama;
        $returnVal[$i]['penjamin_nama'] = $model->penjamin_nama;
        //cari tanggungan penjamin
        $criteria = new CDbCriteria();
        if (!empty($model->penjamin_id)) {
          $criteria->addCondition("penjamin_id = " . $model->penjamin_id);
        }
        if (!empty($model->kelaspelayanan_id)) {
          $criteria->addCondition("kelaspelayanan_id = " . $model->kelaspelayanan_id);
        }
        if (!empty($model->carabayar_id)) {
          $criteria->addCondition("carabayar_id = " . $model->carabayar_id);
        }
        $tanggungan = TanggunganpenjaminM::model()->find($criteria);
        $returnVal[$i]['subsidirumahsakitoa'] = $tanggungan->subsidirumahsakitoa;
        $returnVal[$i]['subsidipemerintahoa'] = $tanggungan->subsidipemerintahoa;
        $returnVal[$i]['subsidiasuransioa'] = $tanggungan->subsidiasuransioa;
        $returnVal[$i]['iurbiayaoa'] = $tanggungan->iurbiayaoa;
        $returnVal[$i]['makstanggpel'] = $tanggungan->makstanggpel;
        //cari dokter ruangan
        $pasienAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        if (!empty($pasienAdmisi->pasienadmisi_id)) {
          $returnVal[$i]['pegawai_id'] = $pasienAdmisi->pegawai_id;
          $returnVal[$i]['pegawai_nama'] = PegawaiM::model()->findByPk($pasienAdmisi->pegawai_id)->NamaLengkap;
        } else {
          $returnVal[$i]['pegawai_id'] = $model->pegawai_id;
          $returnVal[$i]['pegawai_nama'] = PegawaiM::model()->findByPk($model->pegawai_id)->NamaLengkap;
        }
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionGetBiayaRacik()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $jum_racik = $_POST['idx'];
      $sql = "SELECT * FROM racikandetail_m WHERE racikan_id = 1 AND " . $jum_racik . " BETWEEN qtymin AND qtymaks";
      $record = YII::app()->db->createCommand($sql)->queryRow();

      if ($record) {
        $tarifservice = $record['tarifservice'];
      } else {
        $sql = "SELECT * FROM racikan_m WHERE racikan_id = 1 AND racikan_aktif = true";
        $record = YII::app()->db->createCommand($sql)->queryRow();
        $tarifservice = $record['tarifservice'];
      }
      $return = array(
        'value' => $tarifservice
      );
      echo CJSON::encode($return);
    }
    Yii::app()->end();
  }
}
