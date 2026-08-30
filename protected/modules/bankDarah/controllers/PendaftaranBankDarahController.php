<?php

Yii::import('pendaftaranPenjadwalan.models.*');
Yii::import('pendaftaranPenjadwalan.views.pendaftaranRawatJalan');

class PendaftaranBankDarahController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "bankDarah.views.pendaftaranBankDarah.";
  public $path_viewPPRJ = 'pendaftaranPenjadwalan.views.pendaftaranRawatJalan.';
  public $pasientersimpan = false;
  public $pendaftarantersimpan = false;
  public $penanggungjawabtersimpan = false;
  public $tindakanpelayanantersimpan = true; //dilooping / boleh tanpa ini
  public $karcistersimpan = true; //dilooping / boleh tanpa ini
  public $komponentindakantersimpan = true; //di looping
  public $rujukantersimpan = false;
  public $pengambilansampletersimpan = true; //dilooping / boleh tanpa ini
  public $pasienpenunjangtersimpan = true; //dilooping
  public $hasilpemeriksaantersimpan = true; //dilooping
  public $asuransipasientersimpan = false;

  /**
   * Index transaksi pendaftaran
   */
  public function actionIndex($id = null)
  {

    $format = new MyFormatter();
    $model = new BDPendaftaranT;
    $model->pendaftaran_id = null; //new record
    $modPasien = new BDPasienM;
    $modPenanggungJawab = new BDPenanggungJawabM;
    $modAsuransiPasien = new BDAsuransipasienM;

    $modPegawai = new PPPegawaiM;
    $modAntrian = new PPAntrianT;
    $modPasienMasukPenunjangs[0] = new BDPasienmasukpenunjangT;
    $modPasienMasukPenunjangs[0]->ruangan_id = Params::RUANGAN_ID_LAB_KLINIK;
    $modPasienMasukPenunjangs[0]->is_pilihpenunjang = 0;
    $modPasienMasukPenunjangs[0]->is_adakarcis = 0; //dibawah ada switch
    $modPasienMasukPenunjangs[1] = new BDPasienmasukpenunjangT;
    $modPasienMasukPenunjangs[1]->ruangan_id = Params::RUANGAN_ID_LAB_ANATOMI;
    $modPasienMasukPenunjangs[1]->is_pilihpenunjang = 0;
    $modPasienMasukPenunjangs[1]->is_adakarcis = 0; //dibawah ada switch

    switch (Yii::app()->user->getState('ruangan_id')) {
      case Params::RUANGAN_ID_LAB_KLINIK:
        $modPasienMasukPenunjangs[0]->is_pilihpenunjang = 1;
        $modPasienMasukPenunjangs[0]->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
        break;
      case Params::RUANGAN_ID_LAB_ANATOMI:
        $modPasienMasukPenunjangs[1]->is_pilihpenunjang = 1;
        $modPasienMasukPenunjangs[1]->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
        break;
      default:
        $modPasienMasukPenunjangs[0]->is_pilihpenunjang = 1;
        $modPasienMasukPenunjangs[0]->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
    }

    $modPemeriksaanLab = new BDTarifpemeriksaanlabruanganV;
    $modRujukan = new BDRujukanT;
    $modTindakan = new BDTindakanPelayananT;
    $modHasilPemeriksaan = new BDHasilPemeriksaanLabT;
    $modHasilPemeriksaanPA = new BDHasilPemeriksaanPAT;
    $modDetailHasilPemeriksaan = new BDDetailHasilPemeriksaanLabT;
    $modPengambilanSample = new BDPengambilanSampleT;
    $modPengambilanSample->no_pengambilansample = "- Otomatis -";
    $dataTindakans[0] = array();
    $dataTindakans[1] = array();
    $modKarcis[0] = array();
    $modKarcis[1] = array();
    $dataSamples[0] = array();
    $dataSamples[1] = array();
    $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
    $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
    $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
    $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
    $modPasien->agama = Params::DEFAULT_AGAMA;

    //==load data
    if (isset($id)) {
      $model = $this->loadModel($id);
      $modPasien = BDPasienM::model()->findByPk($model->pasien_id);
      $criteria = new CdbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $model->pendaftaran_id);
      $criteria->order = "pendaftaran_id DESC, pasienmasukpenunjang_id ASC";
      $criteria->limit = 2;
      $criteria1 = $criteria;
      $criteria1->addCondition('ruangan_id = ' . Params::RUANGAN_ID_LAB_KLINIK);
      $loadPasienMasukPenunjangs[0] = BDPasienmasukpenunjangT::model()->find($criteria1);
      if (isset($loadPasienMasukPenunjangs[0])) {
        $modPasienMasukPenunjangs[0] = $loadPasienMasukPenunjangs[0];
        $modPasienMasukPenunjangs[0]->is_pilihpenunjang = 1;
        $modPasienMasukPenunjangs[0]->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
      }
      $criteria2 = $criteria;
      $criteria2->addCondition('ruangan_id = ' . Params::RUANGAN_ID_LAB_ANATOMI);
      $loadPasienMasukPenunjangs[1] = BDPasienmasukpenunjangT::model()->find($criteria2);
      if (isset($loadPasienMasukPenunjangs[1])) {
        $modPasienMasukPenunjangs[1] = $loadPasienMasukPenunjangs[1];
        $modPasienMasukPenunjangs[1]->is_pilihpenunjang = 1;
        $modPasienMasukPenunjangs[1]->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
      }
      if (!empty($model->penanggungjawab_id)) {
        $modPenanggungJawab = BDPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
      }
      if (!empty($model->rujukan_id)) {
        $modRujukan = BDRujukanT::model()->findByPk($model->rujukan_id);
      }
      $dataKarcis[0] = BDTindakanPelayananT::model()->findByAttributes(array('ruangan_id' => Params::RUANGAN_ID_LAB_KLINIK, 'pendaftaran_id' => $model->pendaftaran_id), "karcis_id is not null");
      $dataKarcis[1] = BDTindakanPelayananT::model()->findByAttributes(array('ruangan_id' => Params::RUANGAN_ID_LAB_ANATOMI, 'pendaftaran_id' => $model->pendaftaran_id), "karcis_id is not null");
      if (isset($dataKarcis[0]->karcis_id)) {
        $modKarcis[0][0] = BDKarcisV::model()->findByAttributes(array('karcis_id' => $dataKarcis[0]->karcis_id));
        $modKarcis[0][0]->harga_tariftindakan = $dataKarcis[0]->tarif_tindakan;
      }
      if (isset($dataKarcis[1]->karcis_id)) {
        $modKarcis[1][0] = BDKarcisV::model()->findByAttributes(array('karcis_id' => $dataKarcis[1]->karcis_id));
        $modKarcis[1][0]->harga_tariftindakan = $dataKarcis[1]->tarif_tindakan;
      }
      $dataTindakans[0] = BDTindakanPelayananT::model()->findAllByAttributes(array('ruangan_id' => Params::RUANGAN_ID_LAB_KLINIK, 'pendaftaran_id' => $model->pendaftaran_id), "karcis_id is null");
      $dataTindakans[1] = BDTindakanPelayananT::model()->findAllByAttributes(array('ruangan_id' => Params::RUANGAN_ID_LAB_ANATOMI, 'pendaftaran_id' => $model->pendaftaran_id), "karcis_id is null");
    }

    if (isset($_POST['BDPendaftaranT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPasien = $this->simpanPasien($modPasien, $_POST['BDPasienM']);

        if ($_POST['BDPendaftaranT']['is_adapjpasien']) {
          if (isset($_POST['BDPenanggungJawabM'])) {
            $modPenanggungJawab = $this->simpanPenanggungjawab($modPenanggungJawab, $_POST['BDPenanggungJawabM']);
          }
        } else {
          $this->penanggungjawabtersimpan = true;
        }

        if ($_POST['BDPendaftaranT']['is_pasienrujukan']) {
          if (isset($_POST['BDRujukanT'])) {
            $modRujukan = $this->simpanRujukan($modRujukan, $_POST['BDRujukanT']);
          }
        } else {
          $this->rujukantersimpan = true;
        }

        if (isset($_POST['BDAsuransipasienM'])) {
          if (isset($_POST['BDAsuransipasienM']['asuransipasien_id'])) {
            if (!empty($_POST['BDAsuransipasienM']['asuransipasien_id'])) {
              $modAsuransiPasien = BDAsuransipasienM::model()->findByPk($_POST['BDAsuransipasienM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['BDPendaftaranT'], $modPasien, $_POST['BDAsuransipasienM']);
        } else {
          $this->asuransipasientersimpan = true;
        }


        $model = $this->simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $_POST['BDPendaftaranT'], $_POST['BDPasienM'], $_POST['BDPasienmasukpenunjangT'], $modAsuransiPasien);

        if (count((array)$_POST['BDPasienmasukpenunjangT']) > 0) {
          foreach ($_POST['BDPasienmasukpenunjangT'] as $i => $postPenunjang) {
            if ($postPenunjang['is_pilihpenunjang']) {
              $modPasienMasukPenunjangs[$i] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjangs[$i], $model, $postPenunjang);
              if ($postPenunjang['ruangan_id'] == Params::RUANGAN_ID_LAB_KLINIK) {
                $modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjangs[$i]);
              }
              if (isset($_POST['BDTindakanPelayananT'][$i])) {
                if (count((array)$_POST['BDTindakanPelayananT'][$i]) > 0) {
                  foreach ($_POST['BDTindakanPelayananT'][$i] as $ii => $tindakan) {
                    $dataTindakans[$i][$ii] = $this->simpanTindakanPelayanan($model, $modPasienMasukPenunjangs[$i], $tindakan);
                    $dataTindakans[$i][$ii]->pemeriksaanlab_id = $tindakan['pemeriksaanlab_id'];
                    $dataTindakans[$i][$ii]->jenistarif_id = $tindakan['jenistarif_id'];
                    if ($postPenunjang['ruangan_id'] == Params::RUANGAN_ID_LAB_KLINIK) {
                      if (!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)) {
                        $this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$i][$ii], $tindakan);
                      }
                    } else if ($postPenunjang['ruangan_id'] == Params::RUANGAN_ID_LAB_ANATOMI) {
                      $modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjangs[$i], $dataTindakans[$i][$ii], $tindakan);
                    }
                    $dataTindakans[$i][$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);
                  }
                }
              }
              if ($postPenunjang['is_adakarcis']) {
                if (isset($_POST['BDKarcisV'][$i])) {
                  if (count((array)$_POST['BDKarcisV'][$i]) > 0) {
                    foreach ($_POST['BDKarcisV'][$i] as $ii => $karcis) {
                      if ($karcis['is_pilihkarcis']) {
                        $modKarcis[$i][$ii] = new BDKarcisV;
                        $modKarcis[$i][$ii]->attributes = $karcis;
                        $this->simpanTindakanPelayanan($model, $modPasienMasukPenunjangs[$i], $karcis);
                      }
                    }
                  }
                }
              }

              if ($postPenunjang['is_adasample']) {
                $modPengambilanSamples[$i] = $this->simpanPengambilanSample($modPasienMasukPenunjangs[$i], $_POST['BDPengambilanSampleT'][$i]);
              } else {
                $this->pengambilansampletersimpan &= true;
              }
            }
          }
        }
        if ($this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->tindakanpelayanantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan && $this->pasienpenunjangtersimpan && $this->hasilpemeriksaantersimpan && $this->pengambilansampletersimpan && $this->asuransipasientersimpan) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data pendaftaran berhasil disimpan !");
          $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pendaftaran gagal disimpan !");
          //                        echo "-".$this->pasientersimpan."<br>";
          //                        echo "-".$this->pendaftarantersimpan."<br>";
          //                        echo "-".$this->penanggungjawabtersimpan."<br>";
          //                        echo "-".$this->rujukantersimpan."<br>";
          //                        echo "-".$this->karcistersimpan."<br>";
          //                        echo "-".$this->tindakanpelayanantersimpan."<br>";
          //                        echo "-".$this->komponentindakantersimpan."<br>";
          //                        echo "-".$this->hasilpemeriksaantersimpan."<br>";
          //                        echo "-".$this->pengambilansampletersimpan."<br>";
          //                        exit;
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pendaftaran gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }



    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modPasien' => $modPasien,
      'modPenanggungJawab' => $modPenanggungJawab,
      'modAsuransiPasien' => $modAsuransiPasien,
      'modPasienMasukPenunjangs' => $modPasienMasukPenunjangs,
      'modPemeriksaanLab' => $modPemeriksaanLab,
      'modPengambilanSample' => $modPengambilanSample,
      'modRujukan' => $modRujukan,
      'modAntrian' => $modAntrian,
      'modTindakan' => $modTindakan,
      'dataTindakans' => $dataTindakans,
      'modKarcis' => $modKarcis,
      'dataSamples' => $dataSamples,
      'modPegawai' => $modPegawai,
    ));
  }

  /**
   * form verifikasi sebelum submit
   * @param type $id
   */
  public function actionVerifikasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $this->layout = '//layouts/iframe';
      if (isset($_POST['BDPendaftaranT'])) {
        $format = new MyFormatter();
        $model = new BDPendaftaranT;
        $modPasien = new BDPasienM;
        $modPengambilanSamples = array();
        $modPenanggungJawab = null;
        $modRujukan = null;
        $modTindakans = array();
        $modKarcis = array();

        $model->attributes = $_POST['BDPendaftaranT'];
        $modPasien->attributes = $_POST['BDPasienM'];
        if ($_POST['BDPendaftaranT']['is_adapjpasien']) {
          if (isset($_POST['BDPenanggungJawabM'])) {
            $modPenanggungJawab = new BDPenanggungJawabM;
            $modPenanggungJawab->attributes = $_POST['BDPenanggungJawabM'];
          }
        }

        if ($_POST['BDPendaftaranT']['is_pasienrujukan']) {
          if (isset($_POST['BDRujukanT'])) {
            $modRujukan = new BDRujukanT;
            $modRujukan->attributes = $_POST['BDRujukanT'];
            $modRujukan->rujukandari_id = !empty($modRujukan->rujukandari_id) ? $modRujukan->rujukandari_id : null;
          }
        }
        if (count((array)$_POST['BDPasienmasukpenunjangT']) > 0) {
          foreach ($_POST['BDPasienmasukpenunjangT'] as $i => $postPenunjang) {
            if ($postPenunjang['is_pilihpenunjang']) {
              $modPasienMasukPenunjangs[$i] = new BDPasienmasukpenunjangT;
              $modPasienMasukPenunjangs[$i]->attributes = $postPenunjang;
              $modPasienMasukPenunjangs[$i]->tglmasukpenunjang = date('Y-m-d H:i:s');
              if (isset($_POST['BDTindakanPelayananT'][$i])) {
                if (count((array)$_POST['BDTindakanPelayananT'][$i]) > 0) {
                  foreach ($_POST['BDTindakanPelayananT'][$i] as $ii => $tindakan) {
                    $modTindakans[$i][$ii] = new BDTindakanPelayananT;
                    $modTindakans[$i][$ii]->attributes = $tindakan;
                  }
                }
              }
              if ($postPenunjang['is_adakarcis']) {
                if (isset($_POST['BDKarcisV'][$i])) {
                  if (count((array)$_POST['BDKarcisV'][$i]) > 0) {
                    foreach ($_POST['BDKarcisV'][$i] as $ii => $karcis) {
                      if ($karcis['is_pilihkarcis']) {
                        $modKarcis[$i] = new BDKarcisV;
                        $modKarcis[$i]->attributes = $karcis;
                      }
                    }
                  }
                }
              }
              if ($postPenunjang['is_adasample']) {
                $modPengambilanSamples[$i] = new BDPengambilanSampleT;
                $modPengambilanSamples[$i]->attributes = $_POST['BDPengambilanSampleT'][$i];
              }
            }
          }
        }
      }
      echo CJSON::encode(array(
        'content' => $this->renderPartial($this->path_view . 'verifikasi', array(
          'model' => $model,
          'modPasienMasukPenunjangs' => $modPasienMasukPenunjangs,
          'modPasien' => $modPasien,
          'modPenanggungJawab' => $modPenanggungJawab,
          'modRujukan' => $modRujukan,
          'modTindakans' => $modTindakans,
          'modKarcis' => $modKarcis,
          'modPengambilanSamples' => $modPengambilanSamples,
          'format' => $format,
        ), true)
      ));
      Yii::app()->end();
    }
  }

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
    if (isset($post['tempPhoto'])) {
      $modPasien->photopasien = $post['tempPhoto'];
    }
    if (empty($modPasien->pasien_id)) {
      $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
      $modPasien->profilrs_id = Params::getDefaultProfilRS();
      $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
      $modPasien->ispasienluar = TRUE;
      $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modPasien->create_loginpemakai_id = Yii::app()->user->id;
      $modPasien->create_time = date('Y-m-d H:i:s');
      $modPasien->no_rekam_medik = MyGenerator::noRekamMedikPenunjang(Yii::app()->user->getState('mr_lab'));
    } else {
      $modPasien->update_loginpemakai_id = Yii::app()->user->id;
      $modPasien->update_time = date('Y-m-d H:i:s');
    }
    $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id) ? $modPasien->kelurahan_id : null);
    $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
    if ($modPasien->save()) {
      $this->pasientersimpan = true;
    }

    return $modPasien;
  }

  /**
   * proses simpan data penanggungjawab pasien
   * @param type $modPenanggungjawab
   * @param type $post
   * @return type
   */
  public function simpanPenanggungjawab($modPenanggungjawab, $post)
  {
    $format = new MyFormatter;
    $modPenanggungjawab->attributes = $post;
    $modPenanggungjawab->tgllahir_pj = $format->formatDateTimeForDb($modPenanggungjawab->tgllahir_pj);

    if ($modPenanggungjawab->save()) {
      $this->penanggungjawabtersimpan = true;
    }
    return $modPenanggungjawab;
  }

  /**
   * proses simpan data rujukan
   * @param type $modRujukan
   * @param type $post
   * @return type
   */
  public function simpanRujukan($modRujukan, $post)
  {
    $format = new MyFormatter();
    $modRujukan->attributes = $post;
    $modRujukan->tanggal_rujukan = $format->formatDateTimeForDb($modRujukan->tanggal_rujukan);

    if ($modRujukan->save()) {
      $this->rujukantersimpan = true;
    }
    return $modRujukan;
  }

  /**
   * simpan asuransi pasien
   * @param type $modAsuransiPasien
   * @param type $postPendaftaran
   * @param type $postPasien
   * @param type $postAsuransiPasien
   * @return type
   */
  public function simpanAsuransiPasien($modAsuransiPasien, $postPendaftaran, $postPasien, $postAsuransiPasien)
  {
    $format = new MyFormatter();
    $modAsuransiPasien->attributes = $postAsuransiPasien;
    $modAsuransiPasien->pasien_id = isset($postPasien['pasien_id']) ? $postPasien['pasien_id'] : null;
    $modAsuransiPasien->penjamin_id = isset($postPendaftaran['penjamin_id']) ? $postPendaftaran['penjamin_id'] : null;
    $modAsuransiPasien->carabayar_id = isset($postPendaftaran['carabayar_id']) ? $postPendaftaran['carabayar_id'] : null;
    $modAsuransiPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modAsuransiPasien->create_time = date("Y-m-d H:i:s");
    $modAsuransiPasien->tgl_konfirmasi = $format->formatDateTimeForDb($modAsuransiPasien->tgl_konfirmasi);
    $modAsuransiPasien->hubkeluarga = isset($postAsuransiPasien['hubkeluarga']) ? $postAsuransiPasien['hubkeluarga'] : '';
    if (empty($postAsuransiPasien['nokartuasuransi'])) {
      $modAsuransiPasien->nokartuasuransi = $modAsuransiPasien->nopeserta;
    }

    if ($modAsuransiPasien->save()) {
      $this->asuransipasientersimpan = true;
    }
    return $modAsuransiPasien;
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
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
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
    $model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id);
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
    }
    return $model;
  }

  /**
   * Fungsi untuk menyimpan data ke model BDPasienmasukpenunjangT
   * @param type $modPendaftaran
   * @param type $modPasien
   * @return BDPasienmasukpenunjangT 
   */
  public function simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $post)
  {
    $modPasienMasukPenunjang = new $modPasienMasukPenunjang;
    $modPasienMasukPenunjang->attributes = $modPendaftaran->attributes;
    $modPasienMasukPenunjang->attributes = $post;
    $modPasienMasukPenunjang->perawat_id = (isset($post['perawat_id']) ? $post['perawat_id'] : null);
    $modPasienMasukPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $instalasi_id = $modPasienMasukPenunjang->ruangan->instalasi_id;
    $kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
    $modPasienMasukPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($kode_instalasi);
    $modPasienMasukPenunjang->tglmasukpenunjang = date("Y-m-d H:i:s");
    $modPasienMasukPenunjang->no_urutperiksa = MyGenerator::noAntrianPenunjang($modPasienMasukPenunjang->ruangan_id);
    $modPasienMasukPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;
    $modPasienMasukPenunjang->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modPasienMasukPenunjang->create_loginpemakai_id = Yii::app()->user->id;
    $modPasienMasukPenunjang->create_time = date('Y-m-d H:i:s');

    if ($modPasienMasukPenunjang->validate()) {
      $modPasienMasukPenunjang->save();
      $this->pasienpenunjangtersimpan &= true;
    } else {
      $this->pasienpenunjangtersimpan &= false;
    }

    return $modPasienMasukPenunjang;
  }

  /**
   * simpan BDHasilPemeriksaanLabT
   */
  public function simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjang)
  {
    $modHasilPemeriksaan = new BDHasilPemeriksaanLabT;
    $modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
    $modHasilPemeriksaan->nohasilperiksalab = MyGenerator::noHasilPemeriksaanLK();
    $modHasilPemeriksaan->tglhasilpemeriksaanlab = $modPasienMasukPenunjang->tglmasukpenunjang;
    $modHasilPemeriksaan->hasil_kelompokumur = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    $modHasilPemeriksaan->hasil_jeniskelamin = $modPasien->jeniskelamin;
    $modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_BELUM;
    $modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;
    if ($modHasilPemeriksaan->validate()) {
      $modHasilPemeriksaan->save();
    } else {
      $this->hasilpemeriksaantersimpan &= false;
    }
    return $modHasilPemeriksaan;
  }

  /**
   * proses simpan BDTindakanPelayananT
   */
  public function simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $post)
  {
    $modTindakan = new BDTindakanPelayananT;

    $modTindakan->attributes = $modPendaftaran->attributes;
    $modTindakan->attributes = $modPasienMasukPenunjang->attributes;
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTindakan->attributes = $post;
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
    $modTindakan->karcis_id = (isset($post['karcis_id']) ? $post['karcis_id'] : null);
    if (!empty($modTindakan->karcis_id)) {
      $this->karcistersimpan = true;
      if (isset($post['harga_tariftindakan'])) { //jika dari form karcis
        if (!empty($post['harga_tariftindakan'])) {
          $modTindakan->tarif_satuan = $post['harga_tariftindakan'];
        }
      }
      $modTindakan->tipepaket_id = $this->tipePaketKarcis($modPendaftaran, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
    }
    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->dokterpemeriksa1_id = $modPasienMasukPenunjang->pegawai_id;
    $modTindakan->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
    $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
    $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan + $post['tarif_cyto'];
    //		$modTindakan->cyto_tindakan = 0;
    $modTindakan->cyto_tindakan = isset($post['cyto_tindakan']) ? $post['cyto_tindakan'] : 0;
    //		$modTindakan->tarifcyto_tindakan = 0;
    $modTindakan->tarifcyto_tindakan = isset($post['tarif_cyto']) ? $post['tarif_cyto'] : 0;
    $modTindakan->discount_tindakan = 0;
    $modTindakan->subsidiasuransi_tindakan = 0;
    $modTindakan->subsidipemerintah_tindakan = 0;
    $modTindakan->subsisidirumahsakit_tindakan = 0;
    $modTindakan->iurbiaya_tindakan = 0;
    $modTindakan->tarif_rsakomodasi = 0;
    $modTindakan->tarif_medis = 0;
    $modTindakan->tarif_paramedis = 0;
    $modTindakan->tarif_bhp = 0;

    if ($modTindakan->validate()) {
      if ($modTindakan->save()) {
        $this->komponentindakantersimpan &= true;
      }
    } else {
      $this->tindakanpelayanantersimpan &= false;
    }

    return $modTindakan;
  }

  /**
   * simpan BDDetailHasilPemeriksaanLabT
   */
  public function simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $modTindakan, $post)
  {
    $modDetailHasilPemeriksaans = array();
    $date1 = new DateTime($modTindakan->pendaftaran->tgl_pendaftaran);
    $date2 = new DateTime($modTindakan->pasien->tanggal_lahir);
    $umurhari = $date2->diff($date1)->format("%a");
    $criteria = new CDbCriteria();
    $criteria->addCondition('pemeriksaanlab_id = ' . $post['pemeriksaanlab_id']);
    $criteria->addCondition("'" . $umurhari . "' BETWEEN hariminlab AND harimakslab");
    $criteria->compare('LOWER(nilairujukan_jeniskelamin)', strtolower($modHasilPemeriksaan->pasien->jeniskelamin), true);
    $criteria->order = 'pemeriksaanlabdet_nourut ASC';
    $modPemeriksaanLadDet = PemeriksaanlabdetV::model()->findAll($criteria);

    if (count((array)$modPemeriksaanLadDet) > 0) {
      foreach ($modPemeriksaanLadDet as $i => $pemeriksaanDet) {
        $modDetailHasilPemeriksaans[$i] = new BDDetailHasilPemeriksaanLabT;
        $modDetailHasilPemeriksaans[$i]->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
        $modDetailHasilPemeriksaans[$i]->pemeriksaanlabdet_id = $pemeriksaanDet->pemeriksaanlabdet_id;
        $modDetailHasilPemeriksaans[$i]->pemeriksaanlab_id = $pemeriksaanDet->pemeriksaanlab_id;
        $modDetailHasilPemeriksaans[$i]->hasilpemeriksaanlab_id = $modHasilPemeriksaan->hasilpemeriksaanlab_id;
        $modDetailHasilPemeriksaans[$i]->nilairujukan = $pemeriksaanDet->nilairujukan_nama;
        $modDetailHasilPemeriksaans[$i]->hasilpemeriksaan_satuan = $pemeriksaanDet->nilairujukan_satuan;
        $modDetailHasilPemeriksaans[$i]->hasilpemeriksaan_metode = $pemeriksaanDet->nilairujukan_metode;
        $modDetailHasilPemeriksaans[$i]->create_time = date("Y-m-d H:i:s");
        $modDetailHasilPemeriksaans[$i]->create_loginpemakai_id = Yii::app()->user->id;
        $modDetailHasilPemeriksaans[$i]->create_ruangan = $modHasilPemeriksaan->create_ruangan;
        if ($modDetailHasilPemeriksaans[$i]->validate()) {
          $modDetailHasilPemeriksaans[$i]->save();
        } else {
          $this->hasilpemeriksaantersimpan &= false;
        }
      }
    }
    return $modDetailHasilPemeriksaans;
  }

  /**
   * simpan BDHasilPemeriksaanPAT
   */
  public function simpanHasilPemeriksaanPA($modPasienMasukPenunjang, $modTindakan, $post)
  {
    $modHasilPemeriksaanPA = new BDHasilPemeriksaanPAT;
    $modHasilPemeriksaanPA->attributes = $modPasienMasukPenunjang->attributes;
    $modHasilPemeriksaanPA->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
    $modHasilPemeriksaanPA->pemeriksaanlab_id = $post['pemeriksaanlab_id'];
    $modHasilPemeriksaanPA->nosediaanpa = MyGenerator::noSediaanPA();
    $modHasilPemeriksaanPA->tglperiksapa = $modPasienMasukPenunjang->tglmasukpenunjang;
    $modHasilPemeriksaanPA->create_time = date("Y-m-d H:i:s");
    $modHasilPemeriksaanPA->create_loginpemakai_id = Yii::app()->user->id;
    $modHasilPemeriksaanPA->create_ruangan = $modPasienMasukPenunjang->ruangan_id;

    if ($modHasilPemeriksaanPA->validate()) {
      $modHasilPemeriksaanPA->save();
      $modTindakan->hasilpemeriksaanpa_id = $modHasilPemeriksaanPA->hasilpemeriksaanpa_id;
      $modTindakan->update();
    } else {
      $this->hasilpemeriksaantersimpan = false;
    }
  }

  /**
   * Fungsi untuk menyimpan data ke model BDPengambilanSampleT
   */
  public function simpanPengambilanSample($modPasienMasukPenunjang, $post)
  {
    $modPengambilanSample = new BDPengambilanSampleT;
    $modPengambilanSample->attributes = $post;
    $modPengambilanSample->tglpengambilansample = $modPasienMasukPenunjang->tglmasukpenunjang;
    $modPengambilanSample->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
    $modPengambilanSample->no_pengambilansample = MyGenerator::noPengambilanSample($modPengambilanSample->alatmedis_id);
    if ($modPengambilanSample->validate()) {
      $modPengambilanSample->save();
      $this->pengambilansampletersimpan &= true;
    } else {
      $this->pengambilansampletersimpan &= false;
    }

    return $modPengambilanSample;
  }

  /**
   * menentukan tipepaket_id
   * @param type $modPendaftaran
   * @param type $karcis_id
   * @param type $idTindakan
   * @return type
   */
  public function tipePaketKarcis($modPendaftaran, $karcis_id, $tindakan_id)
  {
    $criteria = new CDbCriteria;
    $criteria->with = array('tipepaket');
    if (!empty($tindakan_id)) {
      $criteria->addCondition('daftartindakan_id = ' . $tindakan_id);
    }
    if (!empty($modPendaftaran->carabayar_id)) {
      $criteria->addCondition('tipepaket.carabayar_id = ' . $modPendaftaran->carabayar_id);
    }
    if (!empty($modPendaftaran->penjamin_id)) {
      $criteria->addCondition('tipepaket.penjamin_id = ' . $modPendaftaran->penjamin_id);
    }
    if (!empty($modPendaftaran->kelaspelayanan_id)) {
      $criteria->addCondition('tipepaket.kelaspelayanan_id = ' . $modPendaftaran->kelaspelayanan_id);
    }
    $paket = PaketpelayananM::model()->find($criteria);
    $result = Params::TIPEPAKET_ID_NONPAKET;
    if (isset($paket))
      $result = $paket->tipepaket_id;

    return $result;
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

  /**
   * set dropdown dokter
   */
  public function actionSetDropdownDokter()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new BDPendaftaranT;
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($_POST['ruangan_id'])) {
        $data = $model->getDokterItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['listDokter'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * set dropdown jenis kasus penyakit
   */
  public function actionSetDropdownJeniskasuspenyakit()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new BDPendaftaranT;
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($_POST['ruangan_id'])) {
        $data = $model->getJenisKasusPenyakitItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['listKasuspenyakit'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * set dropdown penjamin pasien dari carabayar_id
   * @param type $encode
   * @param type $namaModel
   */
  public function actionSetDropdownPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * set antrian ruangan
   */
  public function actionSetAntrianRuangan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      $data = array();
      $data['maxantrianruangan'] = null;
      $data['no_urutantri'] = '001';
      if (!empty($ruangan_id)) {
        $data['no_urutantri'] = MyGenerator::noAntrian($ruangan_id);
        $criteria = new CDbCriteria;
        if (!empty($ruangan_id)) {
          $criteria->addCondition('ruangan_id = ' . $ruangan_id);
        }
        $modJadwalBukaPoli = JadwalbukapoliM::model()->findAll($criteria);
        if (count((array)$modJadwalBukaPoli) > 0) {
          foreach ($modJadwalBukaPoli as $key => $antrian) {
            $data['maxantrianruangan'] = $antrian->maxantiranpoli;
          }
        }
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * set antrian dokter
   */
  public function actionSetAntrianDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      $pegawai_id = $_POST['pegawai_id'];
      $data = array();
      $data['maxantriandokter'] = 0;
      if (!empty($ruangan_id) && !empty($pegawai_id)) {
        $criteria = new CDbCriteria;
        if (!empty($ruangan_id)) {
          $criteria->addCondition('ruangan_id = ' . $ruangan_id);
        }
        if (!empty($pegawai_id)) {
          $criteria->addCondition('pegawai_id = ' . $pegawai_id);
        }
        $modJadwalDokter = JadwaldokterM::model()->findAll($criteria);
        if (count((array)$modJadwalDokter) > 0) {
          foreach ($modJadwalDokter as $key => $antrian) {
            $data['maxantriandokter'] = $antrian->maximumantrian;
          }
        }
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * menampilkan karcis
   */
  public function actionSetKarcis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $form_index = $_POST['form_index'];
      $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
      $ruangan_id = $_POST['ruangan_id'];
      $pasien_id = $_POST['pasien_id'];
      $penjamin_id = $_POST['penjamin_id'];
      $form = '';
      $is_pasienbaru = 'true';
      if (!empty($pasien_id)) {
        $modPasien = PasienM::model()->findByPk($pasien_id);
        if (isset($modPasien)) {
          $is_pasienbaru = ($modPasien->statusrekammedis == Params::STATUSREKAMMEDIS_AKTIF) ? 'false' : 'true';
        }
      }
      $criteria = new CdbCriteria();
      $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
      $criteria->addCondition("ruangan_id = " . $ruangan_id);
      $criteria->addCondition("penjamin_id = " . $penjamin_id);
      if (Yii::app()->user->getState('karcisbarulama')) { //RND-7737
        $criteria->addCondition("pasienbaru_karcis = $is_pasienbaru");
      }
      $modKarcis = BDKarcisV::model()->findAll($criteria);
      $form = $this->renderPartial($this->path_view . '_formKarcis', array('i' => $form_index, 'modKarcis' => $modKarcis), true);
      $data['listKarcis'][$form_index] = $form;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * set tabel riwayat kunjungan pasien
   */
  public function actionSetRiwayatKunjunganPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['table'] = "";
      $modPasien = new BDPasienM;
      $modPasien->pasien_id = $_POST['pasien_id'];
      $data['table'] = $this->renderPartial($this->path_view . '_tableRiwayatPasien', array(
        'modPasien' => $modPasien,
      ), true);
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * untuk menampilkan pasien lama dari autocomplete
   * 1. no_rekam_medik
   * 2. no_identitas_pasien
   * 3. nama_pasien
   * 4. nama_bin (alias)
   */
  public function actionAutocompletePasienLama()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $no_identitas_pasien = isset($_GET['no_identitas_pasien']) ? $_GET['no_identitas_pasien'] : null;
      $jenisidentitas = isset($_GET['jenisidentitas']) ? $_GET['jenisidentitas'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $tanggal_lahir = isset($_GET['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['tanggal_lahir']) : null;
      $no_badge = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;

      if (empty($no_badge)) {

        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($no_identitas_pasien), true);
        $criteria->compare('LOWER(jenisidentitas)', strtolower($jenisidentitas), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
        $criteria->compare('tanggal_lahir', $tanggal_lahir);
        $criteria->addCondition('ispasienluar = FALSE');
        $criteria->limit = 5;
        $models = PasienM::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "") . " - " . $format->formatDateTimeForUser($model->tanggal_lahir);
          $returnVal[$i]['value'] = $model->no_rekam_medik;
        }
      } else {

        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)', strtolower($no_badge), true);
        $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id";
        $criteria->limit = 5;
        $models = PPPasienM::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->pegawai->nomorindukpegawai .
            ' - ' . $model->no_rekam_medik .
            ' - ' . $model->nama_pasien .
            ' - (' . $model->pegawai->nama_pegawai .
            ') - ' . $format->formatDateTimeForUser($model->tanggal_lahir);
          $returnVal[$i]['value'] = $model->no_rekam_medik;
        }
      }

      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * Mengurai data pasien berdasarkan pasien_id
   * @throws CHttpException
   */
  public function actionGetDataPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      if (!empty($pasien_id)) {
        $criteria->addCondition('pasien_id = ' . $pasien_id);
      }
      $criteria->compare('no_rekam_medik', $no_rekam_medik);
      $model = PasienM::model()->find($criteria);
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["tanggal_lahir"] = date("d/m/Y", strtotime($model->tanggal_lahir));
      $pendaftaran = BDPendaftaranT::model()->findAllByAttributes(array('pasien_id' => $pasien_id));
      if (count((array)$pendaftaran)) {
        $bl = 0;
        foreach ($pendaftaran as $i => $daftar) {
          $blacklist = BDPasienblacklistT::model()->findAllByAttributes(array('pendaftaran_id' => $daftar->pendaftaran_id));
          if (count((array)$blacklist)) {
            $bl++;
          }
        }
        if (isset($bl)) {
          $returnVal["blacklist"] = $bl;
        } else {
          $returnVal["blacklist"] = 0;
        }
      }
      if (!empty($model->pegawai_id)) {
        $returnVal['nomorindukpegawai'] = $model->pegawai->nomorindukpegawai;
        $returnVal['nama_pegawai'] = $model->pegawai->nama_pegawai;
        $returnVal['gelardepan'] = $model->pegawai->gelardepan;
        $returnVal['unit_perusahaan'] = $model->pegawai->unit_perusahaan;
        $returnVal['gelarbelakang_nama'] = isset($model->pegawai->gelarbelakang->gelarbelakang_nama) ? $model->pegawai->gelarbelakang->gelarbelakang_nama : "";
        $returnVal['jabatan_nama'] = isset($model->pegawai->jabatan->jabatan_nama) ? $model->pegawai->jabatan->jabatan_nama : "";
        $returnVal["nomorindukpegawai"] = $model->pegawai->nomorindukpegawai;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Mengatur dropdown kabupaten
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKabupaten($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new BDPasienM;
      if ($model_nama !== '' && $attr == '') {
        $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $propinsi_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $propinsi_id = $_POST["$model_nama"]["$attr"];
      }
      $kabupaten = null;
      if ($propinsi_id) {
        $kabupaten = $modPasien->getKabupatenItems($propinsi_id);
        $kabupaten = CHtml::listData($kabupaten, 'kabupaten_id', 'kabupaten_nama');
      }
      if ($encode) {
        echo CJSON::encode($kabupaten);
      } else {
        if (empty($kabupaten)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kabupaten as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * Mengatur dropdown kecamatan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKecamatan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new BDPasienM;
      if ($model_nama !== '' && $attr == '') {
        $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kabupaten_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kabupaten_id = $_POST["$model_nama"]["$attr"];
      }
      $kecamatan = null;
      if ($kabupaten_id) {
        $kecamatan = $modPasien->getKecamatanItems($kabupaten_id);
        $kecamatan = CHtml::listData($kecamatan, 'kecamatan_id', 'kecamatan_nama');
      }

      if ($encode) {
        echo CJSON::encode($kecamatan);
      } else {
        if (empty($kecamatan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kecamatan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * Mengatur dropdown kelurahan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKelurahan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new BDPasienM;
      if ($model_nama !== '' && $attr == '') {
        $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kecamatan_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kecamatan_id = $_POST["$model_nama"]["$attr"];
      }
      $kelurahan = null;
      if ($kecamatan_id) {
        $kelurahan = $modPasien->getKelurahanItems($kecamatan_id);
        //                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
        $kelurahan = CHtml::listData($kelurahan, 'kelurahan_id', 'kelurahan_nama');
      }

      if ($encode) {
        echo CJSON::encode($kelurahan);
      } else {
        if (empty($kelurahan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kelurahan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * set dropdown daerah pasien berdasarkan
   * propinsi_id
   * kabupaten_id
   * kecamatan_id
   * kelurahan_id
   * pasien_id
   */
  public function actionSetDropdownDaerahPasien()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $modPasien = new BDPasienM;
      $propinsi_id = $_POST['propinsi_id'];
      $kabupaten_id = $_POST['kabupaten_id'];
      $kecamatan_id = $_POST['kecamatan_id'];
      $kelurahan_id = $_POST['kelurahan_id'];

      $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE');
      $propinsis = CHtml::listData($propinsis, 'propinsi_id', 'propinsi_nama');
      $propinsiOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($propinsis as $value => $name) {
        if ($value == $propinsi_id)
          $propinsiOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $propinsiOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kabupatens = $modPasien->getKabupatenItems($propinsi_id);
      //                $kabupatens = KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true,));
      $kabupatens = CHtml::listData($kabupatens, 'kabupaten_id', 'kabupaten_nama');
      $kabupatenOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kabupatens as $value => $name) {
        if ($value == $kabupaten_id)
          $kabupatenOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kabupatenOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kecamatans = $modPasien->getKecamatanItems($kabupaten_id);
      //                $kecamatans = KecamatanM::model()->findAllByAttributes(array('kabupaten_id'=>$kabupaten_id,'kecamatan_aktif'=>true,));
      $kecamatans = CHtml::listData($kecamatans, 'kecamatan_id', 'kecamatan_nama');
      $kecamatanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kecamatans as $value => $name) {
        if ($value == $kecamatan_id)
          $kecamatanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kecamatanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kelurahans = $modPasien->getKelurahanItems($kecamatan_id);
      $kelurahans = CHtml::listData($kelurahans, 'kelurahan_id', 'kelurahan_nama');
      $kelurahanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kelurahans as $value => $name) {
        if ($value == $kelurahan_id)
          $kelurahanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kelurahanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      $dataList['listPropinsi'] = $propinsiOption;
      $dataList['listKabupaten'] = $kabupatenOption;
      $dataList['listKecamatan'] = $kecamatanOption;
      $dataList['listKelurahan'] = $kelurahanOption;

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * set tanggal lahir dari umur (__ Thn __ Bln __ Hr)
   */
  public function actionSetTanggalLahir()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data['tanggal_lahir'] = date("d/m/Y", strtotime(CustomFunction::getTanggalUmur($_POST['umur'])));

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * untuk drop down rujukan
   */
  public function actionGetRujukanDari($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $asalrujukan_id = $_POST["$namaModel"]['asalrujukan_id'];

      if ($encode) {
        echo CJSON::encode($rujukandari);
      } else {
        if (empty($asalrujukan_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          $rujukandari = RujukandariM::model()->findAllByAttributes(array('asalrujukan_id' => $asalrujukan_id), array('order' => 'namaperujuk'));
          $rujukandari = CHtml::listData($rujukandari, 'rujukandari_id', 'namaperujuk');
          foreach ($rujukandari as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = BDPendaftaranT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'lkpendaftaran-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * set checklist pemeriksaan lab
   */
  public function actionSetChecklistPemeriksaanLab()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $content = "";
      parse_str($_POST['data'], $post);
      $postPemeriksaan = $post['BDTarifpemeriksaanlabruanganV'];
      if (!empty($postPemeriksaan['ruangan_id']) && !empty($postPemeriksaan['kelaspelayanan_id']) && !empty($postPemeriksaan['penjamin_id'])) {
        $criteria = new CdbCriteria();
        $criteria->addCondition('ruangan_id = ' . $postPemeriksaan['ruangan_id']);
        $criteria->addCondition('kelaspelayanan_id = ' . $postPemeriksaan['kelaspelayanan_id']);
        $criteria->addCondition('penjamin_id = ' . $postPemeriksaan['penjamin_id']);
        $criteria->compare('LOWER(jenispemeriksaanlab_nama)', strtolower($postPemeriksaan['jenispemeriksaanlab_nama']), true);
        $criteria->compare('LOWER(pemeriksaanlab_nama)', strtolower($postPemeriksaan['pemeriksaanlab_nama']), true);
        $criteria->order = "jenispemeriksaanlab_urutan, pemeriksaanlab_urutan";
        $modPemeriksaanlabs = BDTarifpemeriksaanlabruanganV::model()->findAll($criteria);
        $content = $this->renderPartial($this->path_view . '_checklistPemeriksaanLab', array('modPemeriksaanlabs' => $modPemeriksaanlabs), true);
      }
      echo CJSON::encode(array(
        'content' => $content
      ));
      Yii::app()->end();
    }
  }

  /**
   * Autocomplete Asuransi
   * @throws CHttpException
   */
  public function actionAutocompleteAsuransi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nopeserta = isset($_GET['nopeserta']) ? $_GET['nopeserta'] : '';
      $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
      $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nopeserta)', strtolower($nopeserta), true);
      $criteria->addCondition('penjamin_id=' . $penjamin_id);
      $criteria->addCondition('asuransipasien_aktif is true');
      if ($_GET['pasien_id'] == "") {
        $criteria->addCondition('pasien_id is null');
      } else {
        $criteria->addCondition('pasien_id=' . $pasien_id);
      }
      $criteria->limit = 5;
      $models = BDAsuransipasienM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nopeserta . ' - ' . $model->namapemilikasuransi;
        $returnVal[$i]['value'] = $model->nopeserta;
        $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
        $returnVal[$i]['nokartuasuransi'] = $model->nokartuasuransi;
        $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
        $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
        $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
        $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
        $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
      }


      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  public function actionAutocompleteAsuransiKartu()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nokartuasuransi = isset($_GET['nokartuasuransi']) ? $_GET['nokartuasuransi'] : '';
      $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
      $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nokartuasuransi)', strtolower($nokartuasuransi), true);
      $criteria->addCondition('penjamin_id=' . $penjamin_id);
      if ($_GET['pasien_id'] == "") {
        $criteria->addCondition('pasien_id is null');
      } else {
        $criteria->addCondition('pasien_id=' . $pasien_id);
      }
      $criteria->limit = 5;
      $models = BDAsuransipasienM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nokartuasuransi . ' - ' . $model->namapemilikasuransi;
        $returnVal[$i]['value'] = $model->nokartuasuransi;
        $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
        $returnVal[$i]['nopeserta'] = $model->nopeserta;
        $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
        $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
        $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
        $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
        $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
      }


      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * menampilkan data asuransi terakhir pasien
   * @throws CHttpException
   */
  public function actionSetAsuransiPasienLama()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data = array();
      $criteria = new CDbCriteria();
      $criteria->addCondition("pasien_id = " . $_POST['pasien_id']);
      $criteria->order = 'asuransipasien_id DESC';
      $model = AsuransipasienM::model()->find($criteria);
      $data["penjamin_nama"] = '';
      if ($model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $data["$attribute"] = $model->$attribute;
        }
        $data["penjamin_nama"] = $model->penjamin->penjamin_nama;
        $data['listPenjamin'] = "";
        $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $model->carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
        if (count((array)$penjamin) > 1) {
          $data['listPenjamin'] .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }
        $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
        foreach ($penjamin as $value => $name) {
          $data['listPenjamin'] .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      echo CJSON::encode($data);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * @param type $pendaftaran_id
   */
  public function actionPrintStatusLab($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = $this->loadModel($pendaftaran_id);
    $modPasien = BDPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modTindakans = array();
    $criteria1 = new CdbCriteria();
    $criteria1->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    $criteria1->order = "pendaftaran_id DESC, pasienmasukpenunjang_id DESC";
    $criteria1->addCondition('ruangan_id = ' . Params::RUANGAN_ID_LAB_KLINIK);
    $loadPasienMasukPenunjangs[0] = BDPasienmasukpenunjangT::model()->find($criteria1);
    if (isset($loadPasienMasukPenunjangs[0])) {
      $modPasienMasukPenunjangs[0] = $loadPasienMasukPenunjangs[0];
      $modTindakans[0] = BDTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjangs[0]->pasienmasukpenunjang_id), "karcis_id is not null");
      $criteria_daf = new CdbCriteria();
      $criteria_daf->addCondition("karcis_id IS NULL");
      $criteria_daf->addCondition("pasienmasukpenunjang_id = " . $modPasienMasukPenunjangs[0]->pasienmasukpenunjang_id);
      $daftartindakan[0] = BDTindakanPelayananT::model()->findAll($criteria_daf);
    }

    $criteria2 = new CdbCriteria();
    $criteria2->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    $criteria2->order = "pendaftaran_id DESC, pasienmasukpenunjang_id DESC";
    $criteria2->addCondition('ruangan_id = ' . Params::RUANGAN_ID_LAB_ANATOMI);
    $loadPasienMasukPenunjangs[1] = BDPasienmasukpenunjangT::model()->find($criteria2);
    if (isset($loadPasienMasukPenunjangs[1])) {
      $modPasienMasukPenunjangs[1] = $loadPasienMasukPenunjangs[1];
      $modTindakans[1] = BDTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjangs[1]->pasienmasukpenunjang_id), "karcis_id is not null");
      $criteria_daf = new CdbCriteria();
      $criteria_daf->addCondition("karcis_id IS NULL");
      $criteria_daf->addCondition("pasienmasukpenunjang_id = " . $modPasienMasukPenunjangs[1]->pasienmasukpenunjang_id);
      $daftartindakan[1] = BDTindakanPelayananT::model()->findAll($criteria_daf);
    }
    $judul_print = 'Kunjungan Laboratorium';
    $this->render($this->path_view . 'printStatusLab', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPasienMasukPenunjangs' => $modPasienMasukPenunjangs,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modTindakans' => $modTindakans,
      'daftartindakan' => $daftartindakan,
    ));
  }

  /**
   * @param type $pendaftaran_id
   * Cetak label
   */
  public function actionPrintStatusLabel($pendaftaran_id, $pengambilansample_id = NULL)
  {
    $this->layout = '//layouts/printWindows';
    $modPendaftaran = $this->loadModel($pendaftaran_id);
    if (isset($pengambilansample_id)) {
      $sql = "				
					SELECT
					pasien_m.no_rekam_medik,pasien_m.nama_pasien,pendaftaran_t.no_pendaftaran,pendaftaran_t.tgl_pendaftaran,
					pengambilansample_t.tglpengambilansample,
					pengambilansample_t.no_pengambilansample
					FROM
					pengambilansample_t
					left join pasienmasukpenunjang_t ON pengambilansample_t.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
					left join pendaftaran_t on pasienmasukpenunjang_t.pendaftaran_id=pendaftaran_t.pendaftaran_id
					left join pasien_m on (pasien_m.pasien_id = pendaftaran_t.pasien_id)
					WHERE pasienmasukpenunjang_t.pasien_id = '" . $modPendaftaran->pasien_id . "' AND pasienmasukpenunjang_t.pendaftaran_id = '" . $pendaftaran_id . "'
					AND pengambilansample_t.pengambilansample_id = '" . $_GET['pengambilansample_id'] . "'
					";
    } else {
      $sql = "				
						SELECT
						pasien_m.no_rekam_medik,pasien_m.nama_pasien,pendaftaran_t.no_pendaftaran,pendaftaran_t.tgl_pendaftaran,
						pengambilansample_t.tglpengambilansample,
						pengambilansample_t.no_pengambilansample
						FROM
						pengambilansample_t
						left join pasienmasukpenunjang_t ON pengambilansample_t.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
						left join pendaftaran_t on pasienmasukpenunjang_t.pendaftaran_id=pendaftaran_t.pendaftaran_id
						left join pasien_m on (pasien_m.pasien_id = pendaftaran_t.pasien_id)
						WHERE pasienmasukpenunjang_t.pasien_id = '" . $modPendaftaran->pasien_id . "' AND pasienmasukpenunjang_t.pendaftaran_id = '" . $pendaftaran_id . "'
						";
    }
    $query = Yii::app()->db->createCommand($sql)->queryAll();

    $this->render($this->path_view . 'printStatusLabel', array(
      'query' => $query,
      'modPendaftaran' => $modPendaftaran,
    ));
  }

  /**
   * untuk menampilkan data pegawai 
   */
  public function actionAutocompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $nomorindukpegawai = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;
      $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nomorindukpegawai)', strtolower($nomorindukpegawai), true);
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->limit = 5;
      $models = PPPegawaiM::model()->findAll($criteria);
      if (count((array)$models) > 0) {
        foreach ($models as $i => $model) {
          $returnVal[$i] = $model->attributes;
          if (!empty($nomorindukpegawai)) {
            $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->nama_pegawai;
          } else {
            $returnVal[$i]['label'] = $model->nama_pegawai;
          }
          $returnVal[$i]['value'] = $model->pegawai_id;
          $returnVal[$i]['jabatan_nama'] = !empty($model->jabatan_id) ? $model->jabatan->jabatan_nama : "";
          $returnVal[$i]['gelarbelakang_nama'] = !empty($model->gelarbelakang_id) ? $model->gelarbelakang->gelarbelakang_nama : "";
        }
      }
      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * menampilkan form antrian dari request ajax
   * @param type $record
   * @param type $noantrian
   * @throws CHttpException
   */
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
        if ($record == "reset") {
          $criteria->addCondition("panggil_flaq = false");
        }
        if (!empty($loket_id)) {
          $criteria->addCondition("loket_id = " . $loket_id);
        }
        $criteria->order = "noantrian ASC";
        $criteria->limit = 1;
        $modAntrian = PPAntrianT::model()->find($criteria);
      } else {
        $criteria = new CDbCriteria();
        $criteria->compare('DATE(tglantrian)', date("Y-m-d"));
        $criteria->compare("noantrian", trim($noantrian));
        if (!empty($loket_id)) {
          $criteria->addCondition("loket_id = " . $loket_id);
        }
        $cari = PPAntrianT::model()->find($criteria);
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

  /**
   * action ketika tombol panggil di klik
   */
  public function actionPanggil($antrian_id, $ket = null)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $data['pesan'] = "";
      $modAntrian =  PPAntrianT::model()->findByPk($antrian_id);
      if (isset($modAntrian)) {
        if ($modAntrian->panggil_flaq == true) {
          if ($ket == "batal") {
            $modAntrian->panggil_flaq = false;
            if ($modAntrian->update()) {
              //                            $data['pesan'] = "Pemanggilan no. antrian ".$modAntrian->noantrian." dibatalkan !";
            }
          } else {
            $data['pesan'] = "No. antrian " . $modAntrian->noantrian . " sudah dipanggil sebelumnya !";
          }
        } else {
          $modAntrian->panggil_flaq = true;
          if ($modAntrian->update()) {
            //                        $data['pesan'] = "No. antrian ".$modAntrian->noantrian." dipanggil !";
          }
        }
      }
      $attributes = $modAntrian->attributeNames();
      foreach ($attributes as $i => $attribute) {
        $data["$attribute"] = $modAntrian->$attribute;
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  public function actionDynamicRuangan()
  {
    $instalasi_id = (isset($_POST['instalasi']) ? $_POST['instalasi'] : null);
    $data = RuanganM::model()->findAll(
      'instalasi_id=:instalasi_id AND ruangan_aktif = TRUE order by ruangan_nama',
      array(':instalasi_id' => $instalasi_id)
    );

    $data = CHtml::listData($data, 'ruangan_id', 'ruangan_nama');

    if (empty($data)) {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Ruangan --'), true);
    } else {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Ruangan --'), true);
      foreach ($data as $value => $name) {
        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
    }
  }

  public function actionSetSatuanObat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null;
      $form = "";
      $pesan = "";
      $satuankecil_nama = "";
      $satuanterkecil_nama = "";
      $format = new MyFormatter();
      $modObatAlkes = ObatalkesM::model()->findByPk($obatalkes_id);

      if (!empty($modObatAlkes)) {
        $satuankecil_nama = isset($modObatAlkes->satuankecil_id) ? $modObatAlkes->satuankecil->satuankecil_nama : null;
        $satuanterkecil_nama = isset($modObatAlkes->satuankecil_id) ? $modObatAlkes->satuankecil->satuankecil_nama : null;
      } else {
        $pesan = "Obat tidak mencukupi!";
      }

      echo CJSON::encode(array(
        'form' => $form, 'pesan' => $pesan,
        'satuankecil' => $satuankecil_nama,
        'satuanterkecil' => $satuanterkecil_nama
      ));
      Yii::app()->end();
    }
  }
}
