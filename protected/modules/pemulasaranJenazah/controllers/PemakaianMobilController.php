<?php

class PemakaianMobilController extends MyAuthController
{
  protected $successSavePemakaianBahan = true;
  protected $successSaveTindakanPelayanan = true;

  public function actionIndex($idPemesanan = '', $pendaftaran_id = '')
  {
    $modPemakaian = new PJPemakaianambulansT;
    $modPemakaian->tglpemakaianambulans = date('d M Y H:i:s');
    $modKunjungan = new PJInfokunjunganrjV;
    $modPasien = new PasienM;
    $modInstalasi = InstalasiM::model()->findAllByAttributes(array('instalasi_aktif' => true), array('order' => 'instalasi_nama'));
    $instalasi = '';
    $tarif = array();
    $tarif['tarifAmbulans'][] = null;
    $format = new MyFormatter();

    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $criteria = new CDbCriteria;
    $criteria->compare('modul_id', $modul_id);
    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
    if (isset($_POST['tujuansms'])) {
      $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
    }
    $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

    if (!empty($idPemesanan)) {
      $modPemakaian = $this->setDataPemakaianFromPemesanan($idPemesanan);
      $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;
    }

    if (!empty($pendaftaran_id)) {
      $modPemakaian = $this->setDataPemakaianFromPendaftaran($pendaftaran_id);
      $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;
      $modKunjungan = $this->setDataPasienFromPendaftaran($pendaftaran_id);
      $modPemakaian->tglpemakaianambulans = date('d M Y H:i:s');
    }

    $is_api_gmap = Yii::app()->user->getState('is_api_gmap');

    if (isset($_POST['PJPemakaianambulansT'])) {
      if (isset($_POST['tarif'])) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          foreach ($_POST['tarif']['tarifAmbulans'] as $i => $tarifAmbulans) {
            $tarif['tarifAmbulans'][$i] = $tarifAmbulans;
            $tarif['tarifKM'][$i] = isset($_POST['tarif']['tarifKM'][$i]) ? $_POST['tarif']['tarifKM'][$i] : 0;
            $tarif['jmlKM'][$i] = isset($_POST['tarif']['jmlKM'][$i]) ? $_POST['tarif']['jmlKM'][$i] : 0;
            $tarif['kelurahan'][$i] = isset($_POST['tarif']['kelurahan'][$i]) ? $_POST['tarif']['kelurahan'][$i] : "";
            $tarif['kecamatan'][$i] = isset($_POST['tarif']['kecamatan'][$i]) ? $_POST['tarif']['kecamatan'][$i] : "";
            $tarif['kabupaten'][$i] = isset($_POST['tarif']['kabupaten'][$i]) ? $_POST['tarif']['kabupaten'][$i] : "";
            $tarif['propinsi'][$i] = isset($_POST['tarif']['propinsi'][$i]) ? $_POST['tarif']['propinsi'][$i] : "";
            $tarif['daftartindakanId'][$i] = isset($_POST['tarif']['daftartindakanId'][$i]) ? $_POST['tarif']['daftartindakanId'][$i] : null;
            $tarif['alamat'][$i] = isset($_POST['tarif']['alamat'][$i]) ? $_POST['tarif']['alamat'][$i] : "";
            $tarif['layanan'][$i] = isset($_POST['tarif']['layanan'][$i]) ? $_POST['tarif']['layanan'][$i] : "";
            $tarif['tindakan'][$i] = isset($_POST['tarif']['tindakan'][$i]) ? $_POST['tarif']['tindakan'][$i] : "";

            $tarif['jenispelayanan_ambulans_id'][$i] = isset($_POST['tarif']['jenispelayanan_ambulans_id'][$i]) ? $_POST['tarif']['jenispelayanan_ambulans_id'][$i] : null;
            $tarif['ruteasal_ambulan'][$i] = isset($_POST['tarif']['ruteasal_ambulan'][$i]) ? $_POST['tarif']['ruteasal_ambulan'][$i] : "";
            $tarif['rutetujuan_ambulan'][$i] = isset($_POST['tarif']['rutetujuan_ambulan'][$i]) ? $_POST['tarif']['rutetujuan_ambulan'][$i] : "";
            $tarif['durasipemakaian_ambulan'][$i] = isset($_POST['tarif']['durasipemakaian_ambulan'][$i]) ? $_POST['tarif']['durasipemakaian_ambulan'][$i] : "";
            $tarif['jenispelayanan_ambulans'][$i] = isset($_POST['tarif']['jenispelayanan_ambulans'][$i]) ? $_POST['tarif']['jenispelayanan_ambulans'][$i] : "";
            $tarif['jasasarana_ambulans'][$i] = isset($_POST['tarif']['jasasarana_ambulans'][$i]) ? $_POST['tarif']['jasasarana_ambulans'][$i] : 0;
            $tarif['harga_bbm'][$i] = isset($_POST['tarif']['harga_bbm'][$i]) ? $_POST['tarif']['harga_bbm'][$i] : 0;
            $tarif['bhp'][$i] = isset($_POST['tarif']['bhp'][$i]) ? $_POST['tarif']['bhp'][$i] : 0;
            $tarif['jasapengemudi'][$i] = isset($_POST['tarif']['jasapengemudi'][$i]) ? $_POST['tarif']['jasapengemudi'][$i] : 0;
            $tarif['jasapendamping'][$i] = isset($_POST['tarif']['jasapendamping'][$i]) ? $_POST['tarif']['jasapendamping'][$i] : 0;
            $tarif['jasadokter'][$i] = isset($_POST['tarif']['jasadokter'][$i]) ? $_POST['tarif']['jasadokter'][$i] : 0;
            $tarif['biayatol'][$i] = isset($_POST['tarif']['biayatol'][$i]) ? $_POST['tarif']['biayatol'][$i] : 0;

            $modPasien = PasienM::model()->findByPk($_POST['PJPemakaianambulansT']['pasien_id']);
            //=== set attribute pemakaian ambulans ===//
            $save = true;
            $modPemakaian = new PJPemakaianambulansT;
            $modPemakaian->attributes = $_POST['PJPemakaianambulansT'];
            $modPemakaian->namapasien = $modPasien->nama_pasien;
            $modPemakaian->norekammedis = $modPasien->no_rekam_medik;
            $modPemakaian->noidentitas = $modPasien->no_identitas_pasien;
            $modPemakaian->nomobile = !empty($modPasien->no_mobile_pasien) ? $modPasien->no_mobile_pasien : '-';
            $modPemakaian->rt_rw = $_POST['PJPemakaianambulansT']['rt'] . '/' . $_POST['PJPemakaianambulansT']['rw'];
            $modPemakaian->tarifperkm = $tarif['tarifKM'][$i];
            $modPemakaian->jumlahkm = $tarif['jmlKM'][$i];
            $modPemakaian->biayatol = $tarif['biayatol'][$i];
            $modPemakaian->totaltarifambulans = $tarif['tarifAmbulans'][$i];
            $modPemakaian->daftartindakanId = $tarif['daftartindakanId'][$i];
            $modPemakaian->daftartindakan_id = $tarif['daftartindakanId'][$i];
            $modPemakaian->create_time = date('Y-m-d H:i:s');
            $modPemakaian->create_loginpemakai_id = Yii::app()->user->id;
            $modPemakaian->create_ruangan = Yii::app()->user->getState('ruangan_id');

            $modPemakaian->noidentitas = Yii::app()->user->getState('ruangan_id');

            $modPemakaian->jenispelayanan_ambulans_id = $tarif['jenispelayanan_ambulans_id'][$i];
            $modPemakaian->ruteasal_ambulan = $tarif['ruteasal_ambulan'][$i];
            $modPemakaian->rutetujuan_ambulan = $tarif['rutetujuan_ambulan'][$i];
            $modPemakaian->durasipemakaian_ambulan = $tarif['durasipemakaian_ambulan'][$i];
            $modPemakaian->jenispelayanan_ambulans = $tarif['jenispelayanan_ambulans'][$i];
            $modPemakaian->jasasarana_ambulans = $tarif['jasasarana_ambulans'][$i];
            $modPemakaian->harga_bbm = $tarif['harga_bbm'][$i];
            $modPemakaian->bhp = $tarif['bhp'][$i];
            $modPemakaian->jasapengemudi = $tarif['jasapengemudi'][$i];
            $modPemakaian->jasapendamping = $tarif['jasapendamping'][$i];
            $modPemakaian->jasadokter = $tarif['jasadokter'][$i];

            $instalasi = $_POST['instalasi'];
            $format = new MyFormatter();
            $modPemakaian->tglpemakaianambulans = $format->formatDateTimeForDb($_POST['PJPemakaianambulansT']['tglpemakaianambulans']);
            $modPemakaian->tglkembaliambulans = isset($_POST['PJPemakaianambulansT']['tglpemakaianambulans']) ? $format->formatDateTimeForDb($_POST['PJPemakaianambulansT']['tglkembaliambulans']) : null;

            //                            $modPemakaian->tarifperkm = str_replace(",", "", $modPemakaian->tarifperkm);
            //                            $modPemakaian->totaltarifambulans = str_replace(",", "", $modPemakaian->totaltarifambulans);
            //                            $modPemakaian->biayatol = str_replace(",", "", $modPemakaian->biayatol);
            $modPemakaian->alamattujuan = $_POST['PJPemakaianambulansT']['alamattujuan'];

            $modPemakaian->validate();
            echo CHtml::errorSummary($modPemakaian);
            //=== save pemakaian ambulans ===//
            //							echo '<pre>';
            //							print_r($_POST);
            //							print_r($modPasien->attributes);
            //							print_r($modPemakaian->attributes);
            //							$modPemakaian->validate();
            //							echo CHtml::errorSummary($modPemakaian);
            //							exit;
            if ($modPemakaian->validate()) {
              $save = $save && $modPemakaian->save();
              if (!empty($modPemakaian->pendaftaran_id) && $save) {
                $modPendaftaran = PendaftaranT::model()->findByPk($modPemakaian->pendaftaran_id);
                $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                $tindakanPel = $this->saveTindakanPelayanan($modPasien, $modPendaftaran, $modPemakaian);
              }
              if (!empty($idPemesanan)) {
                PJPesanambulansT::model()->updateByPk($idPemesanan, array('pemakaianambulans_id' => $modPemakaian->pemakaianambulans_id));
              }
            } else {
              $save = false;
            }
          }
          //=== simpan pemakaian obat alkes ===//
          if (!empty($modPemakaian->pendaftaran_id)) {
            $modPendaftaran = PendaftaranT::model()->findByPk($modPemakaian->pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            if (isset($_POST['PJObatalkesPasienT'])) {
              if (count((array)$_POST['PJObatalkesPasienT']) > 0) {
                //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
                $detailGroups = array();
                foreach ($_POST['PJObatalkesPasienT'] as $i => $postDetail) {
                  $modDetails[$i] = new PJObatalkesPasienT;
                  $modDetails[$i]->attributes = $postDetail;
                  $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
                  $modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
                  $obatalkes_id = $postDetail['obatalkes_id'];
                  if (isset($detailGroups[$obatalkes_id])) {
                    $detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
                  } else {
                    $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
                    $detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
                  }
                }
                //END GROUP
                $obathabis = "";
                //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
                foreach ($detailGroups as $i => $detail) {
                  $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
                  if (count((array)$modStokOAs) > 0) {
                    foreach ($modStokOAs as $i => $stok) {
                      $modDetails[$i] = $this->simpanObatAlkesPasien($modPendaftaran, $stok, $_POST['PJObatalkesPasienT']);
                      $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
                    }
                  } else {
                    $this->stokobatalkestersimpan &= false;
                    $obathabis .= "<br>- " . ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
                  }
                }
              }
            }
          }

          //=== commit or rollback ===//
          if ($save && $this->successSavePemakaianBahan && $this->successSaveTindakanPelayanan) {

            // SMS GATEWAY
            $modPenanggungJawab = $modPendaftaran->penanggungjawab;
            $sms = new Sms();

            foreach ($modSmsgateway as $i => $smsgateway) {

              $isiPesan = $smsgateway->templatesms;
              $attributes = $modPemakaian->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modPemakaian->tglpemakaianambulans), $isiPesan);
              $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);

              if ($smsgateway->tujuansms == Params::TUJUANSMS_PENANGGUNGJAWAB && $smsgateway->statussms) {
                if (!empty($modPemakaian->nomobile)) {
                  $sms->kirim($modPemakaian->nomobile, $isiPesan);
                }
              }
            }
            // END SMS GATEWAY

            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
            //=== mengosongkan nilai attribute pemakaian ambulans ===//
            //                            $modPemakaian = new PJPemakaianambulansT;
            //                            $modPemakaian->tglpemakaianambulans = date('d M Y H:i:s');
            //                            $tarif = array();
            //                            $tarif['tarifAmbulans'][] = null;
            $sukses = 1;
            $this->redirect(array('Index', 'sukses' => $sukses));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data Gagal disimpan");
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
        }
      }
    }

    $this->render('index', array(
      'modPemakaian' => $modPemakaian,
      'modPasien' => $modPasien,
      'modInstalasi' => $modInstalasi,
      'instalasi' => $instalasi,
      'modKunjungan' => $modKunjungan,
      'format' => $format,
      'tarif' => $tarif,
      'is_api_gmap' => $is_api_gmap,
    ));
  }

  public function actionSetTarifAmbulans()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $komponenunit_id = isset($_POST['komponenunit_id']) ? $_POST['komponenunit_id'] : null;
      $modKonfigTarifAmbulas = array();
      if (!empty($komponenunit_id)) {
        $modKonfigTarifAmbulas = KonfigtarifambulasK::model()->findByAttributes(array('komponenunit_id' => $komponenunit_id));
      }
      $pesan = "";
      $harga_bbm = 0;
      $daftartindakan_id = null;
      if (!empty($modKonfigTarifAmbulas)) {
        $modKonfigTarifAmbulas->attributes = $modKonfigTarifAmbulas;
        $harga_bbm = KonfigsystemK::model()->findByPk(1)->harga_bbm;
        if ($harga_bbm == null) {
          $harga_bbm = 0;
        }
        $daftartindakan_id = null;
        $daftartindakan = DaftartindakanM::model()->findByAttributes(array('komponenunit_id' => $modKonfigTarifAmbulas->komponenunit_id)); //ambil daftar tindakan RSSP-1456
        if (!empty($daftartindakan)) {
          $daftartindakan_id = $daftartindakan->daftartindakan_id;
        }
      } else {
        $pesan = "Komponen Tarif belum ada!";
      }

      echo CJSON::encode(array(
        'pesan' => $pesan,
        'modKonfigTarifAmbulas' => $modKonfigTarifAmbulas,
        'harga_bbm' => $harga_bbm,
        'daftartindakan_id' => $daftartindakan_id,
      ));
      Yii::app()->end();
    }
  }

  protected function setDataPasienFromPendaftaran($pendaftaran_id)
  {
    $modKunjungan = new PJInfokunjunganrjV;
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modKunjungan->pendaftaran_id = $pendaftaran_id;
    $modKunjungan->ruangan_id = $modPendaftaran->ruangan_id;
    $modKunjungan->ruangan_nama = $modPendaftaran->ruangan->ruangan_nama;
    $modKunjungan->instalasi_id = $modPendaftaran->instalasi_id;
    $modKunjungan->instalasi_nama = $modPendaftaran->instalasi->instalasi_nama;
    $modKunjungan->no_pendaftaran = $modPendaftaran->no_pendaftaran;
    $modKunjungan->tgl_pendaftaran = $modPendaftaran->tgl_pendaftaran;
    $modKunjungan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modKunjungan->kelaspelayanan_nama = $modPendaftaran->kelaspelayanan->kelaspelayanan_nama;
    $modKunjungan->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
    $modKunjungan->jeniskasuspenyakit_nama = $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama;

    $modKunjungan->carabayar_id = $modPendaftaran->carabayar_id;
    $modKunjungan->carabayar_nama = $modPendaftaran->carabayar->carabayar_nama;
    $modKunjungan->penjamin_id = $modPendaftaran->penjamin_id;
    $modKunjungan->penjamin_nama = $modPendaftaran->penjamin->penjamin_nama;

    $modKunjungan->alamat_pasien = $modPendaftaran->pasien->alamat_pasien;
    $modKunjungan->no_rekam_medik = $modPendaftaran->pasien->no_rekam_medik;
    $modKunjungan->nama_pasien = $modPendaftaran->pasien->nama_pasien;
    $modKunjungan->nama_bin = $modPendaftaran->pasien->nama_bin;
    $modKunjungan->pasien_id = $modPendaftaran->pasien_id;

    $modKunjungan->tanggal_lahir = $modPendaftaran->pasien->tanggal_lahir;
    $modKunjungan->jeniskelamin = $modPendaftaran->pasien->jeniskelamin;
    $modKunjungan->umur = $modPendaftaran->umur;


    $modKunjungan->alamattujuan = $modPendaftaran->pasien->alamat_pasien;
    if (isset($modPendaftaran->pasien->kelurahan)) {
      $modKunjungan->kelurahan_nama = $modPendaftaran->pasien->kelurahan->kelurahan_nama;
    } else {
      $modKunjungan->kelurahan_nama = "";
    }
    $modKunjungan->rt_rw = $modPendaftaran->pasien->rt . '/' . $modPendaftaran->pasien->rw;
    $modKunjungan->rt = $modPendaftaran->pasien->rt;
    $modKunjungan->rw = $modPendaftaran->pasien->rw;


    return $modKunjungan;
  }

  protected function setDataPemakaianFromPendaftaran($pendaftaran_id)
  {
    $modPemakaian = new PJPemakaianambulansT;
    $modPendaftaran = PendaftaranT::model()->with('pasien')->findByPk($pendaftaran_id);
    $modPemakaian->tglpemakaianambulans = date('d M Y H:i:s');
    $modPemakaian->pasien_id = $modPendaftaran->pasien_id;
    $modPemakaian->namapasien = $modPendaftaran->pasien->nama_pasien;
    $modPemakaian->nomobile = $modPendaftaran->pasien->no_mobile_pasien;
    $modPemakaian->notelepon = $modPendaftaran->pasien->no_telepon_pasien;
    $modPemakaian->norekammedis = $modPendaftaran->pasien->no_rekam_medik;
    $modPemakaian->noidentitas = $modPendaftaran->pasien->no_identitas_pasien;
    $modPemakaian->tempattujuan = '';
    $modPemakaian->alamattujuan = $modPendaftaran->pasien->alamat_pasien;
    if (isset($modPendaftaran->pasien->kelurahan)) {
      $modPemakaian->kelurahan_nama = $modPendaftaran->pasien->kelurahan->kelurahan_nama;
    } else {
      $modPemakaian->kelurahan_nama = "";
    }
    $modPemakaian->rt_rw = $modPendaftaran->pasien->rt . '/' . $modPendaftaran->pasien->rw;
    $modPemakaian->rt = $modPendaftaran->pasien->rt;
    $modPemakaian->rw = $modPendaftaran->pasien->rw;
    $modPemakaian->tglpemakaianambulans = null;
    $modPemakaian->pesanambulans_t = null;
    $modPemakaian->pendaftaran_id = $pendaftaran_id;
    $modPemakaian->ruangan_id = $modPendaftaran->ruangan_id;

    return $modPemakaian;
  }

  protected function setDataPemakaianFromPemesanan($idPemesanan)
  {
    $modPemakaian = new PJPemakaianambulansT;
    $modPemesanan = PJPesanambulansT::model()->findByPk($idPemesanan);
    $modPemakaian->pasien_id = $modPemesanan->pasien_id;
    $modPemakaian->namapasien = $modPemesanan->namapasien;
    $modPemakaian->nomobile = $modPemesanan->nomobile;
    $modPemakaian->notelepon = $modPemesanan->notelepon;
    $modPemakaian->norekammedis = $modPemesanan->norekammedis;
    $modPemakaian->noidentitas = PasienM::model()->findByPk($modPemesanan->pasien_id)->no_identitas_pasien;
    $modPemakaian->tempattujuan = $modPemesanan->tempattujuan;
    $modPemakaian->alamattujuan = $modPemesanan->alamattujuan;
    $modPemakaian->kelurahan_nama = $modPemesanan->kelurahan_nama;
    $modPemakaian->rt_rw = $modPemesanan->rt_rw;
    $modPemakaian->tglpemakaianambulans = $modPemesanan->tglpemakaianambulans;
    $modPemakaian->pesanambulans_t = $idPemesanan;
    $modPemakaian->pendaftaran_id = $modPemesanan->pendaftaran_id;
    $modPemakaian->ruangan_id = $modPemesanan->ruangan_id;

    return $modPemakaian;
  }

  /**
   * simpan PJObatalkesPasienT
   * @param type $modPendaftaran
   * @param type $stokOa
   * @param type $postObatAlkesPasien
   * @return \PJObatalkesPasienT
   * copy dari : PemakaianBmhpController
   */
  public function simpanObatAlkesPasien($modPendaftaran, $stokOa, $postObatAlkesPasien)
  {
    $modObatAlkesPasien = new PJObatalkesPasienT;
    $modObatAlkesPasien->attributes = $stokOa->attributes;
    $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
    $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modObatAlkesPasien->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
    $modObatAlkesPasien->carabayar_id = $modPendaftaran->carabayar_id;
    $modObatAlkesPasien->penjamin_id = $modPendaftaran->penjamin_id;
    $modObatAlkesPasien->pegawai_id = $modPendaftaran->pegawai_id;
    $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
    $modObatAlkesPasien->pasien_id = $modPendaftaran->pasien_id;
    $modObatAlkesPasien->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modObatAlkesPasien->tglpelayanan = date('Y-m-d H:i:s');
    $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modObatAlkesPasien->create_time = date('Y-m-d H:i:s');
    $modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
    $modObatAlkesPasien->qty_stok = $stokOa->qtystok;
    $modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
    //		   $modObatAlkesPasien->hargasatuan_oa = $stokOa->getHargaJualSatuan($modObatAlkesPasien->penjamin_id);
    //		   $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
    //RND-12254
    $modObatAlkesPasien->hargasatuan_oa = 0;
    $modObatAlkesPasien->hargajual_oa = 0;
    $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->hargajual_oa;
    foreach ($postObatAlkesPasien as $i => $postDetail) {
      if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
        $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];
        $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];
        $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
      }
    }

    if ($modObatAlkesPasien->save()) {
      $this->successSavePemakaianBahan &= true;
    } else {
      $this->successSavePemakaianBahan &= false;
    }

    return $modObatAlkesPasien;
  }

  /**
   * simpan StokobatalkesT Jumlah Out
   * @param type $stokobatalkesasal_id
   * @param type $modObatAlkesPasien
   * @return \StokobatalkesT
   */
  protected function simpanStokObatAlkesOut($stokobatalkesasal_id, $modObatAlkesPasien)
  {
    $format = new MyFormatter;
    $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
    $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
    $modStokOaNew->qtystok_in = 0;
    $modStokOaNew->qtystok_out = $modObatAlkesPasien->qty_oa;
    $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
    $modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
    $modStokOaNew->tglstok_in = null;
    $modStokOaNew->tglstok_out = date('Y-m-d H:i:s');
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

    if ($modStokOaNew->validateStok()) {
      $modStokOaNew->save();
      $modStokOaNew->setStokOaAktifBerdasarkanStok();
    } else {
      $this->stokobatalkestersimpan &= false;
    }
    return $modStokOaNew;
  }


  //        protected function savePemakaianBahan($modPendaftaran,$pemakaianBahan)
  //        {
  //            $valid = true;
  //            foreach ($pemakaianBahan as $i => $bmhp) {
  //                $modPakaiBahan[$i] = new PJObatalkesPasienT;
  //                $modPakaiBahan[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
  //                $modPakaiBahan[$i]->penjamin_id = $modPendaftaran->penjamin_id;
  //                $modPakaiBahan[$i]->carabayar_id = $modPendaftaran->carabayar_id;
  //                $modPakaiBahan[$i]->daftartindakan_id = $bmhp['daftartindakan_id'];
  //                $modPakaiBahan[$i]->sumberdana_id = $bmhp['sumberdana_id'];
  //                $modPakaiBahan[$i]->pasien_id = $modPendaftaran->pasien_id;
  //                $modPakaiBahan[$i]->satuankecil_id = $bmhp['satuankecil_id'];
  //                $modPakaiBahan[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
  //                $modPakaiBahan[$i]->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
  //                $modPakaiBahan[$i]->obatalkes_id = $bmhp['obatalkes_id'];
  //                $modPakaiBahan[$i]->pegawai_id = $modPendaftaran->pegawai_id;
  //                $modPakaiBahan[$i]->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
  //                $modPakaiBahan[$i]->shift_id = Yii::app()->user->getState('shift_id');
  //                $modPakaiBahan[$i]->tglpelayanan = date('Y-m-d H:i:s');
  //                $modPakaiBahan[$i]->qty_oa = $bmhp['qty_oa'];                
  ////                $modPakaiBahan[$i]->harganetto_oa = $bmhp['harganetto_oa'];
  ////				$modPakaiBahan[$i]->hargasatuan_oa = $stokOa->getHargaJualSatuan($modPakaiBahan[$i]->penjamin_id);
  ////				$modPakaiBahan[$i]->hargajual_oa = $modPakaiBahan[$i]->hargasatuan_oa * $modPakaiBahan[$i]->qty_oa;
  //				$modPakaiBahan[$i]->hargajual_oa = 0;
  //                $modPakaiBahan[$i]->hargasatuan_oa = 0;
  //
  //                $valid = $modPakaiBahan[$i]->validate() && $valid;
  //                if($valid) {
  //                    $modPakaiBahan[$i]->save();
  //                    $this->kurangiStok($modPakaiBahan[$i]->qty_oa, $modPakaiBahan[$i]->obatalkes_id);
  //                    $this->successSavePemakaianBahan = true;
  //                } else {
  //                    $this->successSavePemakaianBahan = false;
  //                }
  //            }
  //            
  //            return $modPakaiBahan;
  //        }

  protected function kurangiStok($qty, $idobatAlkes)
  {
    $sql = "SELECT stokobatalkes_id,qtystok_in,qtystok_out,qtystok_current FROM stokobatalkes_t WHERE obatalkes_id = $idobatAlkes ORDER BY tglstok_in";
    $stoks = Yii::app()->db->createCommand($sql)->queryAll();
    $selesai = false;
    foreach ($stoks as $i => $stok) {
      if ($qty <= $stok['qtystok_current']) {
        $stok_current = $stok['qtystok_current'] - $qty;
        $stok_out = $stok['qtystok_out'] + $qty;
        StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('qtystok_current' => $stok_current, 'qtystok_out' => $stok_out));
        $selesai = true;
        break;
      } else {
        $qty = $qty - $stok['qtystok_current'];
        $stok_current = 0;
        $stok_out = $stok['qtystok_out'] + $stok['qtystok_current'];
        StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('stok_current' => $stok_current, 'qtystok_out' => $stok_out));
      }
    }
  }

  protected function kembalikanStok($obatAlkesT)
  {
    foreach ($obatAlkesT as $i => $obatAlkes) {
      $stok = new StokObatalkesT;
      $stok->unsetIdTransaksi();
      $stok->obatalkes_id = $obatAlkes->obatalkes_id;
      $stok->sumberdana_id = $obatAlkes->sumberdana_id;
      $stok->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $stok->tglstok_in = date('Y-m-d H:i:s');
      $stok->tglstok_out = date('Y-m-d H:i:s');
      $stok->qtystok_in = $obatAlkes->qty_oa;
      $stok->qtystok_out = 0;
      $stok->harganetto_oa = $obatAlkes->harganetto_oa;
      $stok->hargajual_oa = $obatAlkes->hargasatuan_oa;
      $stok->discount = $obatAlkes->discount;
      $stok->satuankecil_id = $obatAlkes->satuankecil_id;
      $stok->save();
    }
  }

  protected function saveTindakanPelayanan($modPasien, $modPendaftaran, $modPemakaian)
  {
    $modTindakan = new TindakanpelayananT;
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modTindakan->pasien_id = $modPasien->pasien_id;
    $modTindakan->daftartindakan_id = $modPemakaian->daftartindakanId;
    $modTindakan->carabayar_id = $modPendaftaran->carabayar_id;
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTindakan->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
    $modTindakan->instalasi_id =  Yii::app()->user->getState('instalasi_id');
    $modTindakan->ruangan_id =  Yii::app()->user->getState('ruangan_id');
    $modTindakan->penjamin_id = $modPendaftaran->penjamin_id;
    $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');

    $modTindakan->tarif_tindakan = $modPemakaian->totaltarifambulans;
    $modTindakan->satuantindakan = 'Km';
    $modTindakan->qty_tindakan = $modPemakaian->jumlahkm;
    $modTindakan->tarif_satuan = $modPemakaian->tarifperkm;

    $modTindakan->cyto_tindakan = 0;
    $modTindakan->tarifcyto_tindakan = 0;
    $modTindakan->discount_tindakan = 0;
    $modTindakan->subsidiasuransi_tindakan = 0;
    $modTindakan->subsidipemerintah_tindakan = 0;
    $modTindakan->subsisidirumahsakit_tindakan = 0;
    $modTindakan->iurbiaya_tindakan = 0;

    if ($modTindakan->save()) {
      $this->successSaveTindakanPelayanan &= true;
    } else {
      $this->successSaveTindakanPelayanan = false;
      Yii::app()->user->setFlash('info', '<pre>' . print_r($modTindakan->getErrors(), 1) . '</pre>');
    }

    return $this->successSaveTindakanPelayanan;
  }

  public function actionDynamicRuangan()
  {
    $data = RuanganM::model()->findAll(
      'instalasi_id=:instalasi_id AND ruangan_aktif = TRUE order by ruangan_nama',
      array(':instalasi_id' => (int) $_POST['instalasi'])
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

  public function actionAddFormPemakaianBahan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $idObatAlkes = (isset($_POST['idObatAlkes']) ? $_POST['idObatAlkes'] : null);
      $idDaftartindakan = (isset($_POST['idDaftartindakan']) ? $_POST['idDaftartindakan'] : "");
      $modObatAlkes = ObatalkesM::model()->findByPk($idObatAlkes);
      $modDaftartindakan = DaftartindakanM::model()->findByPk($idDaftartindakan);
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

      echo CJSON::encode(array(
        'pendaftaran_id' => $pendaftaran_id,
        'namaObat' => $modObatAlkes->obatalkes_nama,
        'form' => $this->renderPartial('_formAddPemakaianBahan', array(
          'modObatAlkes' => $modObatAlkes, 'modDaftartindakan' => $modDaftartindakan,
          'modPendaftaran' => $modPendaftaran,
        ), true),
      ));
      exit;
    }
  }

  public function actionPasienJenazah()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
      $criteria->order = 'no_rekam_medik';
      $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
      $criteria->limit = 10;
      $models = PasienmasukpenunjangV::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->no_pendaftaran;
        $returnVal[$i]['value'] = $model->no_rekam_medik;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
      }
      if (!empty($pasienadmisi_id)) {
        echo "a";
        exit;
        $criteria->addCondition('pasienadmisi_id = ' . $pasienadmisi_id);
      }
      if (!empty($instalasi_id)) {
        $criteria->addCondition('instalasi_id = ' . $instalasi_id);
      }
      $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
      $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));
      if ($instalasi_id == Params::INSTALASI_ID_RJ) {
        $model = PJInfokunjunganrjV::model()->find($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
        $model = PJInfoKunjunganRDV::model()->find($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RI) {
        $model = PJPasienrawatinapV::model()->find($criteria);
      }

      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * menampilkan obat
   * @return row table 
   */
  public function actionSetFormObatAlkesPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null;
      $satuankecil_id = isset($_POST['satuankecil_id']) ? $_POST['satuankecil_id'] : null;
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : "");

      $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : 1;
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modDaftartindakan = DaftartindakanM::model()->findByPk($daftartindakan_id);
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modObatAlkesPasien = new PJObatalkesPasienT;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
      if (count((array)$modStokOAs) > 0) {
        foreach ($modStokOAs as $i => $stok) {
          $modObatAlkesPasien->daftartindakan_id = isset($modDaftartindakan->daftartindakan_id) ? $modDaftartindakan->daftartindakan_id : null;
          $modObatAlkesPasien->pendaftaran_id = isset($modPendaftaran->pendaftaran_id) ? $modPendaftaran->pendaftaran_id : null;
          $modObatAlkesPasien->pasien_id = isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien_id : null;
          $modObatAlkesPasien->penjamin_id = isset($modPendaftaran->penjamin_id) ? $modPendaftaran->penjamin_id : null;
          $modObatAlkesPasien->carabayar_id = isset($modPendaftaran->carabayar_id) ? $modPendaftaran->carabayar_id : null;
          $modObatAlkesPasien->kelaspelayanan_id = isset($modPendaftaran->kelaspelayanan_id) ? $modPendaftaran->kelaspelayanan_id : null;
          $modObatAlkesPasien->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
          $modObatAlkesPasien->obatalkes_id = $stok->obatalkes_id;
          $modObatAlkesPasien->satuankecil_id = $stok->satuankecil_id;
          $modObatAlkesPasien->qty_oa = $stok->qtystok_terpakai;
          $modObatAlkesPasien->harganetto_oa = $stok->HPP;
          $modObatAlkesPasien->qty_stok = $stok->qtystok;
          $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
          if (!empty($pendaftaran_id)) {
            $modObatAlkesPasien->hargasatuan_oa = $stok->getHargaJualSatuan($modPendaftaran->penjamin_id);
          }
          $modObatAlkesPasien->stokobatalkes_id = $stok->stokobatalkes_id;
          $modObatAlkesPasien->biayaservice = 0;
          $modObatAlkesPasien->biayakonseling = 0;
          $modObatAlkesPasien->jasadokterresep = 0;
          $modObatAlkesPasien->biayakemasan = 0;
          $modObatAlkesPasien->biayaadministrasi = 0;
          $modObatAlkesPasien->tarifcyto = 0;
          $modObatAlkesPasien->discount = 0;
          $modObatAlkesPasien->subsidiasuransi = 0;
          $modObatAlkesPasien->subsidipemerintah = 0;
          $modObatAlkesPasien->subsidirs = 0;
          $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
          $modObatAlkesPasien->satuankecil_id = $stok->satuankecil_id;
          $modObatAlkesPasien->satuankecil_nama = $stok->satuankecil->satuankecil_nama;

          $form .= $this->renderPartial('_rowPemakaianBahan', array('modObatAlkesPasien' => $modObatAlkesPasien, 'modDaftartindakan' => $modDaftartindakan, 'modPendaftaran' => $modPendaftaran), true);
        }
      } else {
        $pesan = "Stok tidak mencukupi!";
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  public function actionAutocompleteObatAlkes()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->join = "JOIN sumberdana_m ON sumberdana_m.sumberdana_id = t.sumberdana_id 
						   JOIN satuankecil_m ON satuankecil_m.satuankecil_id = t.satuankecil_id
						   LEFT JOIN jenisobatalkes_m ON jenisobatalkes_m.jenisobatalkes_id = t.jenisobatalkes_id
						   ";
      $criteria->compare('LOWER(t.obatalkes_nama)', strtolower($_GET['term']), true);
      $criteria->addCondition('obatalkes_farmasi = TRUE');
      $criteria->addCondition('obatalkes_aktif = true');
      $criteria->limit = 5;
      $models = ObatalkesM::model()->findAll($criteria);
      $format = new MyFormatter();
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();

        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $qty_stok = StokobatalkesT::getJumlahStok($model->obatalkes_id, isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id'));
        $returnVal[$i]['label'] = $model->obatalkes_kode . " - " . $model->obatalkes_nama . " - Jumlah Stok " . $qty_stok;
        $returnVal[$i]['value'] = $model->obatalkes_nama;
        $returnVal[$i]['qty_stok'] = $qty_stok;
        $returnVal[$i]['satuankecil_nama'] = $model->satuankecil->satuankecil_nama;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_pendaftaran
   * - no_rekam_medik
   * - nama_pasien
   */
  public function actionAutocompleteKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $instalasi_id = isset($_GET['instalasi_id']) ? $_GET['instalasi_id'] : null;
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->limit = 5;
      if ($instalasi_id == Params::INSTALASI_ID_RJ) {
        $criteria->addCondition("DATE(tgl_pendaftaran) = '" . date("Y-m-d") . "'");
        $models = PJInfokunjunganrjV::model()->findAll($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
        $criteria->addCondition("DATE(tgl_pendaftaran) = '" . date("Y-m-d") . "'");
        $models = PJInfoKunjunganRDV::model()->findAll($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RI) {
        $criteria->addBetweenCondition("DATE(tglmasukkamar)", date("Y-m-d", strtotime("-31 days")), date("Y-m-d"));
        $models = PJPasienrawatinapV::model()->findAll($criteria);
      }
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
        $returnVal[$i]['value'] = $model->no_pendaftaran;
        $returnVal[$i]['pasienadmisi_id'] = isset($model->pasienadmisi_id) ? $model->pasienadmisi_id : '';
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
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
