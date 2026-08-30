<?php

/**
 * untuk transaksi pengujian kompatibilitas
 * @author Rusdiyanto <rusdiyanto@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class PengujianKompatibilitasController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'bankDarah.views.pengujianKompatibilitas.';
  public $updatestokkantongdarah = true;

  /**
   * fungsi ini digunakan untuk menampilkan halaman awal dan insert 
   * @param integer $pendaftaran_id
   * @param integer $permintaandarah_id
   */
  public function actionIndex($pendaftaran_id = null, $permintaandarah_id = null)
  {
    $modUjiKompatibilitas = new BDUjikompatibilitasT();
    $modPengujianDarah = new BDPengujiandarahT();
    $modUjiDarahPasien = new BDUjidarahpasienT();
    $modUjiDarahPasien->tglujidarahpasien = date('Y-m-d H:i:s');
    $format = new MyFormatter();
    $modPendaftaran = '';
    $modUjiDarah = '';
    $modPermintaanDarah = '';
    $modPermantaanDetail = null;
    if (isset($pendaftaran_id) && $pendaftaran_id != null) {
      $modPendaftaran = BDPendaftaranT::model()->findByPk($pendaftaran_id);
      $modPermintaanDarah = BDPermintaandarahT::model()->findByPk($permintaandarah_id);
      $modUjiDarah = UjidarahpasienT::model()->findByAttributes(array('permintaandarah_id' => $modPermintaanDarah->permintaandarah_id, 'metodedarah_id' => Params::METODE_DARAH_ID_SLIDE_TEST));

      $cri = new CDbCriteria();
      $cri->join = " LEFT JOIN ujikompatibilitas_t ujikomp ON ujikomp.permintaandarahdet_id = t.permintaandarahdet_id ";
      $rl = array();
      foreach (Params::getRilis() as $key =>  $val) {
        $rl[] = "'" . $key . "'";
      }
      $cri->addCondition(" permintaandarah_id = '" . $permintaandarah_id . "' AND (ujikomp.permintaandarahdet_id is null OR (ujikomp.permintaandarahdet_id is not null AND ujikomp.rilis NOT IN (" . implode(',', $rl) . ")) ) ");
      $modPermantaanDetail = BDPermintaandarahdetT::model()->findAll($cri);

      $cekUjiTube = BDUjidarahpasienT::model()->findByAttributes(array('metodedarah_id' => Params::METODE_DARAH_ID_TUBE_TEST, 'permintaandarah_id' => $permintaandarah_id));
      if (!empty($cekUjiTube)) {
        $modUjiDarahPasien = $cekUjiTube;
        $modUjiDarahPasien->tglujidarahpasien_temp = $modUjiDarahPasien->tglujidarahpasien;
      }
    }

    if (isset($_POST['BDUjidarahpasienT'])) {

      $ok = true;
      $success = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if ($_POST['BDUjidarahpasienT']['ujidarahpasien_id']) {
          $modUjiDarahPasien = BDUjidarahpasienT::model()->findByPk($_POST['BDUjidarahpasienT']['ujidarahpasien_id']);
        } else {
          $modUjiDarahPasien = new BDUjidarahpasienT;
        }

        $modUjiDarahPasien->attributes = $_POST['BDUjidarahpasienT'];
        $modUjiDarahPasien->metodedarah_id = Params::METODE_DARAH_ID_TUBE_TEST; /* id tube test */
        if (!empty($_POST['BDUjidarahpasienT']['ujidarahpasien_id'])) {
          $modUjiDarahPasien->tglujidarahpasien = $_POST['BDUjidarahpasienT']['tglujidarahpasien_temp'];
          $modUjiDarahPasien->update_time = date('Y-m-d H:i:s');
          $modUjiDarahPasien->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        } else {
          $modUjiDarahPasien->tglujidarahpasien = $format->formatDateTimeForDb($_POST['BDUjidarahpasienT']['tglujidarahpasien']);
          $modUjiDarahPasien->permintaandarah_id = isset($modPermintaanDarah->permintaandarah_id) ? $modPermintaanDarah->permintaandarah_id : $_POST['BDUjidarahpasienT']['permintaandarah_id'];
          $modUjiDarahPasien->pasien_id = isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien_id : $_POST['BDUjidarahpasienT']['pasien_id'];
          $modUjiDarahPasien->pendaftaran_id = isset($modPendaftaran->pendaftaran_id) ? $modPendaftaran->pendaftaran_id : $_POST['BDUjidarahpasienT']['pendaftaran_id'];
          $modUjiDarahPasien->ruanguji_id = Yii::app()->user->getState('ruangan_id');
          $modUjiDarahPasien->create_time = date('Y-m-d H:i:s');
          $modUjiDarahPasien->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
          $modUjiDarahPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
        }

        $ok = $ok && $modUjiDarahPasien->save();

        $gen = MyGenerator::ujiKompatibilitasKe($modUjiDarahPasien->ujidarahpasien_id);

        if ($ok) {
          if (isset($_POST['BDUjikompatibilitasT']) && isset($_POST['BDPengujiandarahT'])) {
            $id = array();
            if (count((array)$_POST['BDUjikompatibilitasT']) > 0 && count((array)$_POST['BDPengujiandarahT']) > 0) {
              /* insert ke pengujiandarah_t */
              $modPengujianDarah = $this->validasiTabularPengujianDarah($modUjiDarahPasien, $_POST['BDPengujiandarahT']);
              foreach ($modPengujianDarah as $i => $data) {
                if ($data->save()) {
                  $id[] = $data->pengujiandarah_id;
                  $success = $success;
                } else {
                  $success = false;
                }
              }
              /*end*/

              /* insert ke ujikompatibilitas_t */
              $modUjiKompatibilitas = $this->validasiTabularUjiKompatibilitas($modUjiDarahPasien, $_POST['BDUjikompatibilitasT'], $gen);
              foreach ($modUjiKompatibilitas as $i => $data) {
                $data->pengujiandarah_id = $id[$i];
                if ($data->save()) {
                  if (!empty(Params::cekRilis($data->rilis))) {
                    $updateStokKantongDarah = $this->updateStokKantongDarah($data);
                  }
                  $success = $success;
                } else {
                  $success = false;
                }
              }
              /*end*/
            }
          } else {
            $success = false;
          }

          if ($success == true) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
            $this->redirect(array('index', 'pendaftaran_id' => $modUjiDarahPasien->pendaftaran_id, 'permintaandarah_id' => $modUjiDarahPasien->permintaandarah_id, 'sukses' => 1));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data harus diisi.');
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'modUjiKompatibilitas' => $modUjiKompatibilitas,
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPermintaanDarah' => $modPermintaanDarah,
      'modUjiDarah' => $modUjiDarah,
      'modPengujianDarah' => $modPengujianDarah,
      'modUjiDarahPasien' => $modUjiDarahPasien,
      'modPermantaanDetail' => $modPermantaanDetail
    ));
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
      $modUjiKompatibilitas[$i]->ujikompatibilitas_ke =  $gen;
      $modUjiKompatibilitas[$i]->peg_pemeriksa_id =  $model->peg_pemeriksa_id;
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
   * @param array $model
   * @param array $data
   * @return \BDPengujiandarahT
   */
  protected function validasiTabularPengujianDarah($model, $data)
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
      $valid = $modPengujianDarah[$i]->validate() && $valid;
    }
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
  /**
   * digunakan untuk untuk mengambilan data kantong darah 
   */
  public function actionGetKantong()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $stokkantongdarah_id = $_POST['stokkantongdarah_id'];
      $modKantong = BDInfostokkantongdarahV::model()->findByAttributes(array('stokkantongdarah_id' => $stokkantongdarah_id));
      $modDaftarPendonor = DaftardonasiT::model()->findByPk($modKantong->daftardonasi_id);
      $modPengujianDarah = new BDPengujiandarahT();
      $modUjiKompatibilitas = new BDUjikompatibilitasT();
      $modUjiKompatibilitas->stokkantongdarah_id = $modKantong->stokkantongdarah_id;
      $modUjiKompatibilitas->nomorbarcode = $modKantong->nomorbarcode;
      $modUjiKompatibilitas->stokkantongdarah_id = $modKantong->stokkantongdarah_id;
      $tr = $this->renderPartial($this->path_view . '_formDetailPengujian', array('modUjiKompatibilitas' => $modUjiKompatibilitas, 'modPengujianDarah' => $modPengujianDarah, 'modDaftarPendonor' => $modDaftarPendonor, 'modKantong' => $modKantong), true);
      echo json_encode($tr);
      Yii::app()->end();
    }
  }
  /**
   * digunakan untuk untuk mengambilan data permintaan 
   */
  public function actionGetDataPermintaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $permintaandarah_id = isset($_POST['permintaandarah_id']) ? $_POST['permintaandarah_id'] : '';
      $html = '';
      $tubeHtml = '';
      if (isset($permintaandarah_id)) {
        $modPermintaanDarah = PermintaandarahT::model()->findByPk($permintaandarah_id);
        $modPendaftaran = BDPendaftaranT::model()->findByPk($modPermintaanDarah->pendaftaran_id);
        $modUjiDarahPasien = BDUjidarahpasienT::model()->findByAttributes(array('permintaandarah_id' => $permintaandarah_id, 'metodedarah_id' => Params::METODE_DARAH_ID_TUBE_TEST));
        if (isset($modPendaftaran)) {
          $modUjiDarah = UjidarahpasienT::model()->findByAttributes(array('permintaandarah_id' => $modPermintaanDarah->permintaandarah_id));
          if (isset($modUjiDarah)) {
            $data['tgl_pengujian'] = isset($modUjiDarah->tglujidarahpasien) ? $format->formatDateTimeForUser($modUjiDarah->tglujidarahpasien) : ' ';
            $modPegawaiPenguji = isset($modUjiDarah->peg_pemeriksa_id) ? PegawaiM::model()->findByPk($modUjiDarah->peg_pemeriksa_id) : ' ';
            $data['nama_penguji'] = isset($modPegawaiPenguji->nama_pegawai) ? $modPegawaiPenguji->nama_pegawai : ' ';
            $data['anti_a'] = isset($modUjiDarah->anti_a) ? $modUjiDarah->anti_a : ' ';
            $data['anti_b'] = isset($modUjiDarah->anti_b) ? $modUjiDarah->anti_b : ' ';
            $data['anti_d'] = isset($modUjiDarah->anti_d) ? $modUjiDarah->anti_d : ' ';
            $data['kesimpulan'] = isset($modUjiDarah->kesimpulan_uji) ? $modUjiDarah->kesimpulan_uji : ' ';
          }
          $data['permintaandarah_id'] = $modPermintaanDarah->permintaandarah_id;
          $data['pendaftaran_id'] = $modPendaftaran->pendaftaran_id;
          $data['tgl_pendaftaran'] = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran);
          $data['no_pendaftaran'] = $modPendaftaran->no_pendaftaran;
          $data['umur'] = $modPendaftaran->umur;
          $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
          $data['pasien_id'] = $modPasien->pasien_id;
          $data['nama_pasien'] = $modPasien->nama_pasien;
          $data['alamat_pasien'] = $modPasien->alamat_pasien;
          $data['tanggal_lahir'] = MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir);
          $data['no_rekam_medik'] = $modPasien->no_rekam_medik;
          $data['jeniskelamin'] = $modPasien->jeniskelamin;
          $data['gol_darah_hide'] = $modPasien->golongandarah;
          $data['gol_darah'] = $modPasien->golongandarah . '/' . $modPasien->rhesus;
          $ruangan = isset($modPendaftaran->ruangan_id) ? BDRuanganM::model()->findByPk($modPendaftaran->ruangan_id) : ' ';
          $data['ruangan_nama'] = isset($ruangan->ruangan_nama) ? $ruangan->ruangan_nama : ' ';
          $kelaspelayanan = isset($modPendaftaran->kelaspelayanan_id) ? BDKelaspelayananM::model()->findByPk($modPendaftaran->kelaspelayanan_id) : ' ';
          $data['kelaspelayanan_nama'] = isset($kelaspelayanan->kelaspelayanan_nama) ? $kelaspelayanan->kelaspelayanan_nama : ' ';
          $penjamin = isset($modPendaftaran->penjamin_id) ? PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id) : ' ';
          $data['penjamin_nama'] = isset($penjamin->penjamin_nama) ? $penjamin->penjamin_nama : ' ';
          $modPegawai = isset($modPendaftaran->pegawai_id) ? PegawaiM::model()->findByPk($modPendaftaran->pegawai_id) : ' ';
          $data['nama_pegawai'] = isset($modPegawai->nama_pegawai) ? $modPegawai->nama_pegawai : ' ';
        }

        $data['diagnosis'] = $modPermintaanDarah->diagnosis;

        $arrDet = array();

        if (!empty($modUjiDarahPasien)) {
          $modUjiDarahPasien->tglujidarahpasien_temp = $modUjiDarahPasien->tglujidarahpasien;

          $cri = new CDbCriteria();
          $cri->join = " JOIN ujidarahpasien_t tube ON tube.ujidarahpasien_id = t.ujidarahpasien_id ";
          $cri->addCondition(" permintaandarah_id = '" . $modPermintaanDarah->permintaandarah_id . "' AND t.permintaandarahdet_id is not null");
          $cri->addInCondition("rilis", Params::getRilis());
          $ujiKomp = UjikompatibilitasT::model()->findAll($cri);

          foreach ($ujiKomp as $d) {
            $arrDet[] = $d->permintaandarahdet_id;
          }

          $tubeHtml = $this->renderPartial($this->path_view . '_formPemeriksaanPengujianDarahTube', array('modUjiDarahPasien' => $modUjiDarahPasien), true);
        }

        $cri = new CDbCriteria();
        $cri->join = " LEFT JOIN ujikompatibilitas_t ujikomp ON ujikomp.permintaandarahdet_id = t.permintaandarahdet_id ";
        $cri->addCondition(" permintaandarah_id = '" . $modPermintaanDarah->permintaandarah_id . "' ");

        if (!empty($arrDet)) {
          $cri->addNotInCondition(" t.permintaandarahdet_id ", $arrDet);
        }
        $modPermantaanDetail = BDPermintaandarahdetT::model()->findAll($cri);

        foreach ($modPermantaanDetail as $d) {
          $modPengujianDarah = new BDPengujiandarahT();
          $modUjiKompatibilitas = new BDUjikompatibilitasT();
          $modUjiKompatibilitas->permintaandarahdet_id = $d->permintaandarahdet_id;
          $modUjiKompatibilitas->singkatan_komp = isset($d->singkatan_komp) ? $d->singkatan_komp : " ";
          $html .= $this->renderPartial($this->path_view . 'ajaxLoadAset', array(
            'modPengujianDarah' => $modPengujianDarah,
            'modUjiKompatibilitas' => $modUjiKompatibilitas
          ), true);
        }
      }
      $data['tube'] = $tubeHtml;
      $data['tr'] = $html;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * load hasil kesimpulan, pemeriksaan golongan darah
   */
  public function actionHasilKesimpulan()
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
