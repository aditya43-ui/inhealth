<?php
Yii::import('laboratorium.controllers.PendaftaranLaboratoriumController');
Yii::import('laboratorium.models.*');
Yii::import('laboratorium.views.pendaftaranLaboratorium');
/**
 * untuk transaksi pendaftaran lab
 * @author <rusdiyanto@.com>
 * @package    application.modules.pendaftaranPenjadwalan
 * @subpackage controllers
 */
class PendaftaranLaboratoriumPPController extends PendaftaranLaboratoriumController
{
  public $path_view_pendaftaran = 'pendaftaranPenjadwalan.views.pendaftaranLaboratoriumPP.';

  /**
   * proses simpan / ubah data pasien
   * @param type $modPasien
   * @param type $post
   * @return type
   */


  public function simpanPasien($modPasien, $post)
  {
    $format = new MyFormatter();
    if (isset($post['pasien_id']) && (!empty($post['pasien_id']))) {
      $load = new $modPasien;
      $modPasien = $load->findByPk($post['pasien_id']);
    }
    $modPasien->attributes = $post;
    $modPasien->tanggal_lahir = $format->formatDateTimeForDb($modPasien->tanggal_lahir);
    $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);

    if (empty($modPasien->pasien_id)) {
      $this->is_pasien_baru = true;
      $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
      $modPasien->profilrs_id = Params::getDefaultProfilRS();
      $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
      $modPasien->ispasienluar = FALSE;
      $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modPasien->create_loginpemakai_id = Yii::app()->user->id;
      $modPasien->create_time = date('Y-m-d H:i:s');
      $modPasien->no_rekam_medik = MyGenerator::noRekamMedik();
    } else {
      $modPasien->update_loginpemakai_id = Yii::app()->user->id;
      $modPasien->update_time = date('Y-m-d H:i:s');
    }
    $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id) ? $modPasien->kelurahan_id : null);
    $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;

    // simpan gambar
    if (isset($post['is_ambilfoto']) && $post['is_ambilfoto'] == 1) {
      $nama_file = "pasien_" . date('YmdHis') . "_" . (str_replace(".", "_", microtime(true))) . ".png";
      $fullImgSource = Params::pathPasienDirectory() . $nama_file;
      $fullThumbSource = Params::pathPasienTumbsDirectory() . 'kecil_' . $nama_file;

      $file = fopen($fullImgSource, "wb");
      $data_foto = explode(",", $modPasien->photopasien);

      fwrite($file, base64_decode($data_foto[1]));
      fclose($file);

      // thumbnail
      Yii::import("ext.EPhpThumb.EPhpThumb");
      $thumb = new EPhpThumb();
      $thumb->init();
      $thumb->create($fullImgSource)
        ->resize(200, 200)
        ->save($fullThumbSource);

      $modPasien->photopasien = $nama_file;
    }

    if (empty($modPasien->create_ruangan)) {
      $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
    }

    if (!is_numeric($modPasien->no_mobile_pasien)) {
      $modPasien->no_mobile_pasien = str_replace("-", "", $modPasien->no_mobile_pasien);
      $modPasien->no_mobile_pasien = trim($modPasien->no_mobile_pasien);
    }
    if (!is_numeric($modPasien->no_telepon_pasien)) {
      $modPasien->no_telepon_pasien = str_replace("-", "", $modPasien->no_telepon_pasien);
      $modPasien->no_telepon_pasien = trim($modPasien->no_telepon_pasien);
    }

    if ($modPasien->save()) {
      $this->pasientersimpan = true;
    }

    return $modPasien;
  }

  /**
   * proses simpan / ubah data pendaftaran
   * @return type
   */
  public function simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $post, $postPasien, $postPenunjang, $modAsuransiPasien)
  {
    $format = new MyFormatter();
    $model->attributes = $post;
    $model->pendaftaran_id = null;
    $model->pasien_id = $modPasien->pasien_id;
    $model->penanggungjawab_id = $modPenanggungJawab->penanggungjawab_id;
    $model->rujukan_id = $modRujukan->rujukan_id;
    $model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    if (empty($model->ruangan_id)) {
      $model->ruangan_id = Params::RUANGAN_ID_LAB_KLINIK;
    }
    $model->instalasi_id = (isset($model->ruangan_id) ? RuanganM::model()->findByPk($model->ruangan_id)->instalasi_id : null);
    if (count((array)$postPenunjang) > 0) { //pegawai_id, jeniskasuspenyakit_id, kelaspelayanan_id dari salah satu form pasienmasukpenunjang
      foreach ($postPenunjang as $i => $penunjang) {
        if (!empty($penunjang['pegawai_id'])) {
          $model->pegawai_id = $penunjang['pegawai_id'];
        }
        if (!empty($penunjang['jeniskasuspenyakit_id'])) {
          $model->jeniskasuspenyakit_id = $penunjang['jeniskasuspenyakit_id'];
        }
        if (!empty($penunjang['kelaspelayanan_id'])) {
          $model->kelaspelayanan_id = $penunjang['kelaspelayanan_id'];
        }
      }
    }
    //		$model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id);
    $model->no_urutantri = MyGenerator::noAntrianPPKonsul($model->ruangan_id); //fungsi diganti karena no antrian duplikat ketika ada konsul poli ke ruangan.
    $model->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
    $model->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
    $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
    $model->shift_id = Yii::app()->user->getState('shift_id');
    $model->statusmasuk = (!empty($model->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
    $model->statuspasien = (empty($postPasien['pasien_id']) ? Params::STATUSPASIEN_BARU : Params::STATUSPASIEN_LAMA);
    $model->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
    $model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_time = date("Y-m-d H:i:s");
    if (Yii::app()->user->getState('tgltransaksimundur') && !empty($model->tgl_pendaftaran)) {
      $model->tgl_pendaftaran = $format->formatDateTimeForDb($model->tgl_pendaftaran);
    } else {
      $model->tgl_pendaftaran = date("Y-m-d H:i:s");
    }
    $model->no_pendaftaran = MyGenerator::noPendaftaran($model->instalasi_id, $model->tgl_pendaftaran);
    $model->tgl_konfirmasi = $format->formatDateTimeForDb($model->tgl_konfirmasi);
    $model->tglselesaiperiksa = $format->formatDateTimeForDb($model->tglselesaiperiksa);
    $model->tglrenkontrol = $format->formatDateTimeForDb($model->tglrenkontrol);
    $model->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;

    if ($model->save()) {
      $this->pendaftarantersimpan = true;
      if (!empty($model->antrian_id)) {
        PPAntrianT::model()->updateByPk($model->antrian_id, array(
          'pendaftaran_id' => $model->pendaftaran_id,
        ));
      }
    }
    return $model;
  }


  public function actionSetDropdownLoket()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id_nama_loket = $_POST["idModelantrian"];
      $data = array();
      $data['diLoket_antrian'] = '';
      if (empty($id_nama_loket)) {
        $data['diLoket_antrian'] = CHtml::dropDownList('namaLoket', 'namaLoket', array(), array('class' => 'span2', 'empty' => '-- Pilih --', 'style' => 'width:100px;'));
      } else {
        $data['diLoket_antrian'] = CHtml::dropDownList('namaLoket', 'namaLoket', CHtml::listData(LoketM::model()->findAllByAttributes(array('modelantrian_id' => $id_nama_loket, 'ispendaftaran' => TRUE, 'loket_aktif' => TRUE), array('order' => 'loket_nama ASC')), 'loket_id', 'loket_nama'), array('class' => 'span2', 'empty' => '-- Pilih --', 'style' => 'width:100px;', 'onchange' => 'setFormAntrian("reset");'));
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }

  public function actionSetFormAntrian()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $data['pesan'] = "";
      $record = (isset($_POST['record']) ? $_POST['record'] : "");
      $noantrian = (isset($_POST['noantrian']) ? $_POST['noantrian'] : "");
      $loket_id = (isset($_POST['loket_id']) ? $_POST['loket_id'] : null);
      if (empty($noantrian)) { //antrian baru
        $criteria = new CDbCriteria();
        $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
        $criteria->addCondition("pendaftaran_id IS NULL");
        
        if (!empty($loket_id)) {
          $criteria->addCondition("modelantrian_id = " . $loket_id);
        }
        $criteria->order = "noantrian ASC";
        $criteria->limit = 1;
        $modAntrian =  PPAntrianT::model()->find($criteria);
      } else {
        $criteria = new CDbCriteria();
        $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
        $criteria->compare("noantrian", trim($noantrian));
        $criteria->addCondition("pendaftaran_id IS NULL");
        if (!empty($loket_id)) {
          $criteria->addCondition("modelantrian_id = " . $loket_id);
        }
        $cari =  PPAntrianT::model()->find($criteria);
        if (!empty($loket_id)) {
          if ($record == 'next') {
            $cari->loket_id = $loket_id;
            $modAntrian = $cari->AntrianBerikut;
          } else if ($record == 'prev') {
            $cari->loket_id = $loket_id;
            $modAntrian = $cari->AntrianSebelum;
          } else {
            $modAntrian = $cari;
          }
        }
      }

      if (!isset($modAntrian)) {
        $modAntrian = new PPAntrianT;
        $data['pesan'] = "Antrian Habis !";
      }
      $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
      $data['form_antrian'] = $this->renderPartial($this->path_view . '_formPanggilAntrian', array('modAntrian' => $modAntrian), true);
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
}
