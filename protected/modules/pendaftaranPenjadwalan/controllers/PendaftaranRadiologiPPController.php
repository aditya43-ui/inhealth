<?php
Yii::import('radiologi.controllers.PendaftaranRadiologiController');
Yii::import('radiologi.models.*');
Yii::import('radiologi.views.pendaftaranRadiologi');
class PendaftaranRadiologiPPController extends PendaftaranRadiologiController
{
  public $path_view_pendaftaran = 'pendaftaranPenjadwalan.views.pendaftaranRadiologiPP.';

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
    if (isset($post['pegawai_id'])) {
      $modPasien->pegawai_id = $post['pegawai_id'];
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

    if (empty($modPasien->pasien_id)) {
      $modPasien->pasien_id = null;
    }

    if (empty($modPasien->create_ruangan)) {
      $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
    }

    if (!is_numeric($modPasien->no_mobile_pasien)) {
      $modPasien->no_mobile_pasien = str_replace("-", "", $modPasien->no_mobile_pasien);
      $modPasien->no_mobile_pasien = str_replace("_", "", $modPasien->no_mobile_pasien);

      $modPasien->no_mobile_pasien = trim($modPasien->no_mobile_pasien);
    }
    if (!is_numeric($modPasien->no_telepon_pasien)) {
      $modPasien->no_telepon_pasien = str_replace("-", "", $modPasien->no_telepon_pasien);
      $modPasien->no_telepon_pasien = str_replace("_", "", $modPasien->no_telepon_pasien);
      $modPasien->no_telepon_pasien = trim($modPasien->no_telepon_pasien);
    }
    
    if ($modPasien->save()) {
      $this->pasientersimpan = true;
    }
    // var_dump($modPasien->errors, $modPasien->attributes); die;

    return $modPasien;
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

  function actionGetPJPasien()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
            $returnValPP = array();
            if (!empty($pasien_id)) {
                $pendaftaran = PendaftaranT::model()->findByAttributes(array(
                    'pasien_id' => $pasien_id,
                ), array(
                    'condition' => 'pasienbatalperiksa_id is not null And penanggungjawab_id is not null'
                ));
                if (!empty($pendaftaran)) {
                    $penanggungJP = PenanggungjawabM::model()->findByAttributes(array(
                        'penanggungjawab_id' => $pendaftaran->penanggungjawab_id,
                    ));

                    $returnValPP['pengantar'] = $penanggungJP->pengantar;
                    $returnValPP['nama_pj'] = $penanggungJP->nama_pj;
                    $returnValPP['jeniskelamin'] = $penanggungJP->jeniskelamin;
                    $returnValPP['jenisidentitas'] = $penanggungJP->jenisidentitas;
                    $returnValPP['no_identitas'] = $penanggungJP->no_identitas;
                    $returnValPP['no_teleponpj'] = $penanggungJP->no_teleponpj;
                    $returnValPP['no_mobilepj'] = $penanggungJP->no_mobilepj;
                    $returnValPP['hubungankeluarga'] = $penanggungJP->hubungankeluarga;
                    $returnValPP['tempatlahir_pj'] = $penanggungJP->tempatlahir_pj;
                    $returnValPP['tgllahir_pj'] = date("d/m/Y", strtotime($penanggungJP->tgllahir_pj));
                    $returnValPP['alamat_pj'] = $penanggungJP->alamat_pj;
                } else {
                    $returnValPP = null;
                }
            }
            echo CJSON::encode($returnValPP);
            Yii::app()->end();
        }
    }

}
