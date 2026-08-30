<?php

/**
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @digunakan   - controller pengujian golongan darah
 * @website      <http://>
 * RSST-1471
 */
class PengujianGolonganDarahController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'bankDarah.views.pengujianGolonganDarah.';
  public $init = '';

  public $updatestokkantongdarah = true;

  public function actionIndex($permintaandarah_id = null, $pendaftaran_id = null, $ujidarahpasien_id = null, $iframe = null, $pasienkirimkeunitlain_id = null)
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (isset($_GET['ajax']) && $_GET['ajax'] == 'kantong-m-grid') {
        $this->renderPartial($this->path_view . 'form/_dialogKantong');
        Yii::app()->end();
      }
    }
    $this->pageTitle = Yii::app()->name . " - Pengujian Golongan Darah";
    $updateStokKantongDarah = true;

    if ($iframe == 1) {
      // $this->layout = '//layouts/iframe';
    }

    $modHasilUjiCocok = new HasilujicocokserasiT();
    $modPemeriksaanGolDar = new PemeriksaangoldarT();
    $modPemeriksaanDarah = new BDPemeriksaangoldarT();

    $modUjiKompatibilitas = new BDUjikompatibilitasT();
    $modPengujianDarah = new BDPengujiandarahT();

    $modKunjungan = PasienmasukpenunjangV::model()->findByAttributes(['pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id]);

    $modKirim = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
    if (!empty($modKirim)) {
      $modKirim->ruangan_nama = $modKirim->createruangan->ruangan_nama;
      $modKirim->diagnosa_nama = $modKirim->diagnosa->diagnosa_nama ?? '';
    } else {
      $modKirim = new PasienkirimkeunitlainT();
    }
    if (!empty($modKunjungan)) {
      $modKunjungan->nama_pegawai = $modKunjungan->namaLengkap;
      $dataKantong = $this->getJenisKantongDarah($pasienkirimkeunitlain_id);
      $dataJumlahPermintaan = $this->getJumlahPermintaan($pasienkirimkeunitlain_id);
      $dataJumlahDilayani = $this->getJumlahPermintaan($pasienkirimkeunitlain_id);

      $modKunjungan->jeniskantongdarah_singkatan = implode(',', $dataKantong);
      $modKunjungan->jumlahpermintaan = implode(',', $dataJumlahPermintaan);
      $modKunjungan->jumlahdilayani = implode(',', $dataJumlahDilayani);
    } else {
      $modKunjungan = new PasienmasukpenunjangV();
    }
    $model = new BDUjidarahpasienT();
    $model->tglujidarahpasien = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
    $peg = BDPegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
    if (!empty($peg)) {
      $model->peg_pemeriksa_id = $peg->pegawai_id;
      $model->peg_pemeriksa_nama = $peg->namaLengkap;
    }
    $modPendaftaran = new BDPendaftaranT;
    $modPasien = new BDPasienM;
    $modPermintaanDetail = array();

    if (!empty($pendaftaran_id)) {
      $modHasilUjiCocok = HasilujicocokserasiT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id]);
      if (empty($modHasilUjiCocok)) {
        $modHasilUjiCocok = new HasilujicocokserasiT();
      }
      $modPendaftaran = BDPendaftaranT::model()->findByPk($pendaftaran_id);
      $modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran);

      $diagnosa = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));

      if (!empty($diagnosa)) {
        $modPendaftaran->diagnosa_nama = $diagnosa->diagnosa->diagnosa_nama;
      }

      $modPasien = BDPasienM::model()->findByPk($modPendaftaran->pasien_id);
      $modPasien->tanggal_lahir = MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir);
      $modPasien->golongandarah = $modPasien->golongandarah . '/' . $modPasien->rhesus;

      if (!empty($permintaandarah_id)) {
        $cekPermintaan = BDPermintaandarahT::model()->findByPk($permintaandarah_id);
        $modPermintaanDetail = BDPermintaandarahdetT::model()->findAllByAttributes(array(
          'permintaandarah_id' => $permintaandarah_id,
        ));
        $modPendaftaran->diagnosa_nama = $cekPermintaan->diagnosis;
      }

      $modPendaftaran->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
    }



    if (!empty($ujidarahpasien_id)) {
      $model = BDUjidarahpasienT::model()->findByPk($ujidarahpasien_id);
      $model->peg_pemeriksa_nama = $model->pegpemeriksa->namaLengkap;
      $model->tglujidarahpasien = MyFormatter::formatDateTimeForUser($model->tglujidarahpasien);
    }


    if (isset($_POST['HasilujicocokserasiT'])) {
      $ok = true;
      $saveUjiCocok = false;
      $saveGoldar = false;
      $trans = Yii::app()->db->beginTransaction();
      try {

        $modKirimPasien = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
        // echo '<pre>';var_dump($_POST);die;
        if (isset($_POST['HasilujicocokserasiT'])) {
          // $modHasilUjiCocok = new HasilujicocokserasiT();
          $modHasilUjiCocok->attributes = $_POST['HasilujicocokserasiT'];
          $modHasilUjiCocok->pendaftaran_id = $pendaftaran_id;
          $modHasilUjiCocok->pasien_id = $modPendaftaran->pasien_id ?? null;
          $modHasilUjiCocok->jam_pemeriksaangoldar = MyFormatter::formatDateTimeForDb($modHasilUjiCocok->jam_pemeriksaangoldar);
          $modHasilUjiCocok->jam_pemeriksaancocokserasi = MyFormatter::formatDateTimeForDb($modHasilUjiCocok->jam_pemeriksaancocokserasi);
          // untuk mengambil jeniskantong darah singkatan
          $dataJenisKantongDarah = $this->getJenisKantongDarah($pasienkirimkeunitlain_id);

          $modHasilUjiCocok->jeniskantongdarah_singkatan = implode('+', $dataJenisKantongDarah);

          if (!empty($modKirimPasien)) {
            $modHasilUjiCocok->ruanganasal_id = $modKirimPasien->create_ruangan;
          }

          $modHasilUjiCocok->tgl_hasilujigoldar = date('Y-m-d H:i:s');
          $modHasilUjiCocok->ruangan_id = Yii::app()->user->getState('ruangan_id');
          $modHasilUjiCocok->pegawai_id = Yii::app()->user->getState('pegawai_id');
          $modHasilUjiCocok->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
          $modHasilUjiCocok->create_ruangan = Yii::app()->user->getState('ruangan_id');
          $modHasilUjiCocok->create_time = date('Y-m-d H:i:s');
          if ($modHasilUjiCocok->validate()) {
            if ($modHasilUjiCocok->save()) {
              // echo '<pre>';var_dump($modHasilUjiCocok);die;
              $saveUjiCocok = true;
              if (isset($_POST['PemeriksaangoldarT'])) {
                if (count($_POST['PemeriksaangoldarT']) > 0) {
                  foreach ($_POST['PemeriksaangoldarT'] as $key => $value) {
                    $modGoldar = new PemeriksaangoldarT();
                    $modGoldar->attributes = $value;
                    if (isset($_POST['BDPemeriksaangoldarT'])) {
                      $modGoldar->attributes = $_POST['BDPemeriksaangoldarT'];
                    }
                    $modGoldar->hasilujicocokserasi_id = $modHasilUjiCocok->hasilujicocokserasi_id;
                    $modGoldar->pasien_id = $modPendaftaran->pasien_id ?? null;
                    $modGoldar->pendaftaran_id = $pendaftaran_id;
                    $modGoldar->pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id;
                    $modGoldar->pasienmasukpenunjang_id = $modKirimPasien->pasienmasukpenunjang_id ?? null;
                    $modGoldar->create_time = date('Y-m-d H:i:s');
                    $modGoldar->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $modGoldar->create_ruangan = Yii::app()->user->getState('ruangan_id');

                    if ($modGoldar->validate()) {
                      $ok = $modGoldar->save();
                      if (!empty($modGoldar->stokkantongdarah_id)) {
                        StokkantongdarahT::model()->updateByPk($modGoldar->stokkantongdarah_id, ['pemeriksaangoldar_id' => $modGoldar->pemeriksaangoldar_id]);
                      }
                      $saveGoldar = $ok;
                    } else {
                      $ok = false;
                      $saveGoldar = false;
                    }
                    // var_dump($modGoldar->getErrors());
                  }
                }
              }
            } else {
              $ok = false;
            }
          } else {
            $ok = false;
          }
          // echo '<pre>';var_dump($modHasilUjiCocok->validate(), $modHasilUjiCocok);die;
        }

        // echo '<pre>';var_dump($saveGoldar, $saveUjiCocok);die;
        if ($ok) {
          if (!empty($pasienkirimkeunitlain_id)) {
            $update = PasienkirimkeunitlainT::model()->updateByPk($pasienkirimkeunitlain_id, ['is_progressgoldarah' => false]);
          }
          $trans->commit();
          Yii::app()->user->setFlash('success', "Data Pasien " . $modPendaftaran->pasien->nama_pasien . " Berhasil Disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id, 'sukses' => 1));
        } else {

          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
        }
        // echo '<pre>';var_dump($model->getErrors());die;
      } catch (Exception $exc) {
        $trans->rollback();
        var_dump($exc->getMessage());
        die;
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    $modRiwayatGolDar = [];
    if (!empty($modHasilUjiCocok)) {
      $modRiwayatGolDar = PemeriksaangoldarT::model()->findAllByAttributes(['hasilujicocokserasi_id' => $modHasilUjiCocok->hasilujicocokserasi_id, 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id]);

      if (count($modRiwayatGolDar) > 0) {
        foreach ($modRiwayatGolDar as $i => $data) {
          $modPemeriksaanDarah->attributes = $data->attributes;
        }
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPermintaanDetail' => $modPermintaanDetail,
      'modUjiKompatibilitas' => $modUjiKompatibilitas,
      'modPengujianDarah' => $modPengujianDarah,
      'modHasilUjiCocok' => $modHasilUjiCocok,
      'modPemeriksaanGolDar' => $modPemeriksaanGolDar,
      'modRiwayatGolDar' => $modRiwayatGolDar,
      'modPemeriksaanDarah' => $modPemeriksaanDarah,
      'modKunjungan' => $modKunjungan,
      'modKirim' => $modKirim
    ));
  }

  function getJenisKantongDarah($pasienkirimkeunitlain_id)
  {
    $modPermintaan = PermintaankepenunjangT::model()->findAllByAttributes(['pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id]);

    $jeniskantongdarahsingakatan = [];
    if (!empty($modPermintaan)) {
      foreach ($modPermintaan as $i => $data) {
        array_push($jeniskantongdarahsingakatan, $data->jeniskomponendarah->jeniskantongdarah_singkatan);
      }
    }

    return $jeniskantongdarahsingakatan;
  }

  function getJumlahPermintaan($pasienkirimkeunitlain_id)
  {
    $modPermintaan = PermintaankepenunjangT::model()->findAllByAttributes(['pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id]);

    $jumlahPermintaan = [];
    if (!empty($modPermintaan)) {
      foreach ($modPermintaan as $i => $data) {
        array_push($jumlahPermintaan, $data->jumlah_kantong . $data->jeniskomponendarah->jeniskantongdarah_singkatan);
      }
    }

    return $jumlahPermintaan;
  }

  function getJumlahDilayani($pasienkirimkeunitlain_id)
  {
    $modPermintaan = PermintaankepenunjangT::model()->findAllByAttributes(['pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id]);

    $jumlahDilayani = [];
    if (!empty($modPermintaan)) {
      foreach ($modPermintaan as $i => $data) {
        array_push($jumlahDilayani, $data->diambil . $data->jeniskomponendarah->jeniskantongdarah_singkatan);
      }
    }

    return $jumlahDilayani;
  }

  /**
   * fungsi insert BDUjikompatibilitasT
   * @author rusdiyanto <rusdiyanto@.com>
   * @param array $model
   * @param array $data
   * @return \BDUjikompatibilitasT
   */
  protected function validasiTabularUjiKompatibilitas($model, $data, $gen)
  {
    $valid = true;
    $modLoginPemakai = LoginpemakaiK::model()->findByPk(Yii::app()->user->getState('loginpemakai_id'));
    foreach ($data as $i => $row) {
      $modUjiKompatibilitas[$i] = new BDUjikompatibilitasT;
      $modUjiKompatibilitas[$i]->attributes = $row;
      $modUjiKompatibilitas[$i]->ujikompatibilitas_ke = $gen;
      $modUjiKompatibilitas[$i]->peg_pemeriksa_id = $model->peg_pemeriksa_id;
      $modUjiKompatibilitas[$i]->ruang_periksa = Yii::app()->user->getState('ruangan_id');
      $modUjiKompatibilitas[$i]->pasien_id = $model->pasien_id;
      $modUjiKompatibilitas[$i]->rilis = isset($row['rilis']) ? $row['rilis'] : '';
      $modUjiKompatibilitas[$i]->pendaftaran_id = $model->pendaftaran_id;
      $modUjiKompatibilitas[$i]->tglujikompabilitas = date('Y-m-d H:i:s');
      $modUjiKompatibilitas[$i]->ujidarahpasien_id = $model->ujidarahpasien_id;
      $modUjiKompatibilitas[$i]->create_time = date('Y-m-d H:i:s');
      $modUjiKompatibilitas[$i]->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
      $modUjiKompatibilitas[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modUjiKompatibilitas[$i]->validate();
      $valid = $modUjiKompatibilitas[$i]->validate() && $valid;
    }
    return $modUjiKompatibilitas;
  }

  /**
   * fungsi insert BDPengujiandarahT
   * @author Rusdiyanto <rusdiyanto@.com>
   * @param array $data
   * @return \BDPengujiandarahT
   */
  protected function validasiTabularPengujianDarah($data)
  {
    $valid = true;
    $modLoginPemakai = LoginpemakaiK::model()->findByPk(Yii::app()->user->getState('loginpemakai_id'));
    foreach ($data as $i => $row) {
      $modPengujianDarah[$i] = new BDPengujiandarahT;
      $modPengujianDarah[$i]->attributes = $row;
      $modPengujianDarah[$i]->tglpengujian = date('Y-m-d H:i:s');
      $modPengujianDarah[$i]->petugaspengujian_id = $modLoginPemakai->pegawai_id;
      $modPengujianDarah[$i]->shift_id = Yii::app()->user->getState('shift_id');
      $modPengujianDarah[$i]->hasil_uji = 'COCOK';
      $modPengujianDarah[$i]->asalruangan_id = Yii::app()->user->getState('ruangan_id');
      $modPengujianDarah[$i]->create_time = date('Y-m-d H:i:s');
      $modPengujianDarah[$i]->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
      $modPengujianDarah[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modPengujianDarah[$i]->validate();

      var_dump($modPengujianDarah[$i]->attributes(), $modPengujianDarah[$i]->validate(), $modPengujianDarah[$i]->errors);

      $valid = $modPengujianDarah[$i]->validate() && $valid;
    }

    die;



    return $modPengujianDarah;
  }

  /**
   * fungsi update column ujikompatibilitas_id pada table stokkantongdarah_t jika pengujian kompatibilitas rilis
   * @author rusdiyanto <rusdiyanto@.com>
   * @param array $data
   */
  protected function updateStokKantongDarah($data)
  {
    if (isset($data->stokkantongdarah_id)) {
      $modStokKantong = StokkantongdarahT::model()->findByPk($data->stokkantongdarah_id);
      $modStokKantong->ujikompatibilitas_id = $data->ujikompatibilitas_id;
      $modStokKantong->update_time = date('Y-m-d H:i:s');
      $modStokKantong->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
      if ($modStokKantong->save()) {
        $this->updatestokkantongdarah = true;
      } else {
        $this->updatestokkantongdarah = false;
      }
    }
  }

  public function actionAutocompletePendaftaran()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $criteria = new CDbCriteria();
      $criteria->select = 't.*,permintaan.*';
      $criteria->join = "LEFT JOIN permintaandarah_t permintaan ON t.pendaftaran_id=permintaan.pendaftaran_id ";
      $criteria->addCondition("permintaan.isbatal = false");
      $models = PendaftaranT::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {

          $returnVal[$i]['label'] = $model->no_pendaftaran;
          $returnVal[$i]['value'] = $model->pendaftaran_id;
        }
      }

      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * @param type $ujidarahpasien_id
   * untuk menampilkan detail data, yang sudah tersimpan 
   */
  public function actionDetail($ujidarahpasien_id)
  {
    $this->layout = "//layouts/iframe";

    $model = BDUjidarahpasienT::model()->findByPk($ujidarahpasien_id);
    $model->peg_pemeriksa_nama = $model->pegpemeriksa->namaLengkap;
    $model->tglujidarahpasien = MyFormatter::formatDateTimeForUser($model->tglujidarahpasien);

    $modPendaftaran = BDPendaftaranT::model()->findByPk($model->pendaftaran_id);

    $diagnosa = PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));

    if (!empty($diagnosa)) {
      $modPendaftaran->diagnosa_nama = $diagnosa->diagnosa->diagnosa_nama;
    }

    $modPasien = BDPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPasien->tanggal_lahir = MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir);
    $modPasien->golongandarah = $modPasien->golongandarah . '/' . $modPasien->rhesus;

    $modPendaftaran->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);

    $this->render($this->path_view . 'print', array(
      'model' => $model,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien
    ));
  }

  /**
   * load hasil kesimpulan, pemeriksaan anti
   */
  public function actionHasilKesimpulan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $anti_a = isset($_POST['anti_a']) ? $_POST['anti_a'] : null;
      $anti_b = isset($_POST['anti_b']) ? $_POST['anti_b'] : null;
      $anti_d = isset($_POST['anti_d']) ? $_POST['anti_d'] : null;

      $arr = array(
        'anti_a' => $anti_a,
        'anti_b' => $anti_b,
        'anti_d' => $anti_d
      );

      $hasil = CustomFunction::ujiGolDarah($arr);

      $data['sukses'] = 1;
      $data['pesan'] = '';
      $data['kesimpulan'] = $hasil;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * load hasil kesimpulan, pemeriksaan golongan darah
   */
  public function actionHasilKesimpulanKantong()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $anti_a = isset($_POST['anti_a']) ? $_POST['anti_a'] : null;
      $anti_b = isset($_POST['anti_b']) ? $_POST['anti_b'] : null;
      $anti_ab = isset($_POST['anti_ab']) ? $_POST['anti_ab'] : null;
      $anti_d = isset($_POST['anti_d']) ? $_POST['anti_d'] : null;

      $sel_a = isset($_POST['sel_a']) ? $_POST['sel_a'] : null;
      $sel_b = isset($_POST['sel_b']) ? $_POST['sel_b'] : null;
      $sel_o = isset($_POST['sel_o']) ? $_POST['sel_o'] : null;

      $metode = isset($_POST['metode']) ? $_POST['metode'] : null;

      $metode_untuk = isset($_POST['metode_untuk']) ? $_POST['metode_untuk'] : null;

      $arr = array(
        'anti_a' => strtoupper($anti_a),
        'anti_b' => strtoupper($anti_b),
        'anti_ab' => strtoupper($anti_ab),
        'anti_d' => strtoupper($anti_d),
        'sel_a' => strtoupper($sel_a),
        'sel_b' => strtoupper($sel_b),
        'sel_o' => strtoupper($sel_o),
        'metode' => $metode,
        'metode_untuk' => $metode_untuk
      );

      $hasil = CustomFunction::ujiKonfirmasiGolDarah($arr);

      $data['sukses'] = 1;
      $data['pesan'] = '';

      if ($hasil['status'] == Params::KESIMPULAN_GOLDARAH_TIDAK) {
        $data['kesimpulan'] = $hasil['status'];
      } else {
        $data['kesimpulan'] = $hasil['gol_darah'] . ' ' . $hasil['nama_rhesus'];
      }


      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * load hasil kesimpulan, uji kompatibilitas
   */
  public function actionHasilUjiKompatibilitas()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $mayor = isset($_POST['mayor']) ? $_POST['mayor'] : null;
      $minor = isset($_POST['minor']) ? $_POST['minor'] : null;
      $autocontrol = isset($_POST['autocontrol']) ? $_POST['autocontrol'] : null;
      $dct = isset($_POST['dct']) ? $_POST['dct'] : null;

      $arr = array(
        'mayor' => $mayor,
        'minor' => $minor,
        'autocontrol' => $autocontrol,
        'dct' => $dct,
      );

      $hasil = CustomFunction::ujiSilangSerasi($arr);

      $data['sukses'] = 1;
      $data['pesan'] = '';
      $data['kesimpulan'] = $hasil['kesimpulan'];
      $data['pilihan'] = '';
      if (!empty($hasil['pilihan'])) {
        foreach ($hasil['pilihan'] as $det) {
          $data['pilihan'] .= '<option value="' . $det . '">' . $det . '</option>';
        }
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
