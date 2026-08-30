<?php

class KonsultasiGiziController extends MyAuthController
{
  public $defaultAction = 'index';
  public $succesSave = false;
  public $pasienpenunjangtersimpan = false;
  protected $successSaveBmhp = true;
  protected $successSavePemakaianBahan = true;
  protected $path_view = 'gizi.views.konsultasiGizi.';

  public function actionIndex($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = GZPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = GZPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modViewTindakans = GZTindakanpelayananT::model()
      ->with(
        'daftartindakan',
        'dokter1',
        'dokter2',
        'dokterPendamping',
        'dokterAnastesi',
        'dokterDelegasi',
        'bidan',
        'suster',
        'perawat',
        'tipePaket'
      )
      ->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));
    $modTindakans = null;
    $modTindakan = new GZTindakanpelayananT;
    $modTindakan->tarifcyto_tindakan = 0;
    $modTindakan->dokterpemeriksa1_id = $modPendaftaran->pegawai_id;
    $modTindakan->dokterpemeriksa1Nama = $modPendaftaran->pegawai->NamaLengkap;

    $modPasienMasukPenunjang = GZPasienMasukPenunjangT::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
    ));
    // var_dump($modPasienMasukPenunjang->attributes); die;
    if (empty($modPasienMasukPenunjang)) {
      $modPasienMasukPenunjang = new GZPasienMasukPenunjangT;
      $modPasienMasukPenunjang->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modPasienMasukPenunjang->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
    }
    $models = new GZPaketpelayananV();

    if (isset($_POST['GZTindakanpelayananT']) || isset($_POST['TindakanpelayananT'])) {
      if ($modPasienMasukPenunjang->isNewRecord) $modPasienMasukPenunjang = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, null);
      $post = (isset($_POST['TindakanpelayananT'])) ? $_POST['TindakanpelayananT'] : $_POST['GZTindakanpelayananT'];
      $modTindakans = $this->saveTindakan($modPasien, $modPendaftaran, $modPasienMasukPenunjang);

      if ($this->succesSave) {
        Yii::app()->user->setFlash('success', "Pemeriksaan Konsultasi Gizi berhasil disimpan");
        $this->redirect($_POST['url']);
      } else {
        Yii::app()->user->setFlash('error', "Data Konsultasi Gizi gagal disimpan !");
      }
    }

    $modViewBmhp = GZObatalkesPasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modTindakans' => $modTindakans,
      'modTindakan' => $modTindakan,
      'modViewTindakans' => $modViewTindakans,
      'modViewBmhp' => $modViewBmhp, 'models' => $models
    ));
  }

  /**
   * Fungsi untuk menyimpan data ke model GZPasienMasukPenunjangT
   * @param type $modPendaftaran
   * @param type $modPasien
   * @return GZPasienMasukPenunjangT 
   */
  public function simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $post)
  {
    $modPasienMasukPenunjang = new $modPasienMasukPenunjang;
    $modPasienMasukPenunjang->attributes = $modPendaftaran->attributes;
    $modPasienMasukPenunjang->attributes = $post;
    $modPasienMasukPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $instalasi_id = $modPasienMasukPenunjang->ruangan->instalasi_id;
    $kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
    $modPasienMasukPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($kode_instalasi);
    $modPasienMasukPenunjang->tglmasukpenunjang = date("Y-m-d H:i:s");
    $modPasienMasukPenunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($modPasienMasukPenunjang->ruangan_id);
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

  public function saveTindakan($modPasien, $modPendaftaran, $modPasienMasukPenunjang)
  {
    $modTindakans = null;
    $post = $_POST['GZTindakanpelayananT'];
    $valid = true;
    foreach ($post as $i => $item) {
      if (!empty($item) && (!empty($item['daftartindakan_id']))) {
        $modTindakans[$i] = new GZTindakanpelayananT;
        $modTindakans[$i]->attributes = $item;
        $modTindakans[$i]->tipepaket_id = $_POST['GZTindakanpelayananT'][0]['tipepaket_id'];
        $modTindakans[$i]->pasien_id = $modPasien->pasien_id;
        $modTindakans[$i]->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        $modTindakans[$i]->carabayar_id = $modPendaftaran->carabayar_id;
        $modTindakans[$i]->penjamin_id = $modPendaftaran->penjamin_id;
        $modTindakans[$i]->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
        $modTindakans[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modTindakans[$i]->instalasi_id = Yii::app()->user->getState('instalasi_id');
        $modTindakans[$i]->ruangan_id =  Yii::app()->user->getState('ruangan_id');
        $modTindakans[$i]->keterangantindakan = (isset($item['keterangantindakan']) ? $item['keterangantindakan'] : null);
        //                    $modTindakans[$i]->tgl_tindakan = $item['tgl_tindakan'];
        $modTindakans[$i]->tgl_tindakan = $modTindakans[0]->tgl_tindakan;
        $modTindakans[$i]->shift_id = Yii::app()->user->getState('shift_id');
        $modTindakans[$i]->tarif_satuan = $modTindakans[$i]->getTarifSatuan(); //RND-7250
        $modTindakans[$i]->tarif_tindakan = $modTindakans[$i]->tarif_satuan * $modTindakans[$i]->qty_tindakan;
        if ($item['cyto_tindakan'])
          $modTindakans[$i]->tarifcyto_tindakan = ($item['persenCyto'] / 100) * $modTindakans[$i]->tarif_tindakan;
        else
          $modTindakans[$i]->tarifcyto_tindakan = 0;
        $modTindakans[$i]->discount_tindakan = 0;
        $modTindakans[$i]->subsidiasuransi_tindakan = 0;
        $modTindakans[$i]->subsidipemerintah_tindakan = 0;
        $modTindakans[$i]->subsisidirumahsakit_tindakan = 0;
        $modTindakans[$i]->iurbiaya_tindakan = 0;
        $modTindakans[$i]->alatmedis_id = $this->cekAlatmedis($modTindakans[$i]->daftartindakan_id);

        $modTindakans[$i]->create_time = date('Y-m-d H:i:s');
        $modTindakans[$i]->create_loginpemakai_id = Yii::app()->user->id;
        $modTindakans[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modTindakans[$i]->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
        $valid = $modTindakans[$i]->validate() && $valid;
      }
    }
    $transaction = Yii::app()->db->beginTransaction();
    try {
      if ($valid && (count((array)$modTindakans) > 0)) {
        foreach ($modTindakans as $i => $tindakan) {
          $tindakan->save();
          $statusSaveKomponen = $tindakan->saveTindakanKomponen();
          if (isset($_POST['paketBmhp'])) {
            $modObatPasiens = $this->savePaketBmhp($modPendaftaran, $_POST['paketBmhp'], $tindakan);
          }
          if (isset($_POST['pemakaianBahan'])) {
            $modPemakainBahans = $this->savePemakaianBahan($modPendaftaran, $_POST['pemakaianBahan'], $tindakan);
          }
        }
        if ($statusSaveKomponen && $this->successSaveBmhp && $this->successSavePemakaianBahan) {
          $p = PendaftaranT::model()->findByPk($modPendaftaran->pendaftaran_id);
          $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
          /* ================================================ */
          /* Proses update status periksa KonsulPoli EHS-179  */
          /* ================================================ */
          $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));
          if (!empty($konsulPoli)) {
            $updateStatusPeriksa = KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
          }
          /* ================================================ */

          PendaftaranT::model()->updateByPk(
            $modPendaftaran->pendaftaran_id,
            array(
              'pembayaranpelayanan_id' => null
            )
          );

          $transaction->commit();
          $this->succesSave = true;
          Yii::app()->user->setFlash('success', "Data Tindakan Pasien berhasil disimpan");
          //Yii::app()->user->setFlash('error',"Data valid ".$this->traceObatAlkesPasien($modPemakainBahans));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data tidak valid 1");
          //Yii::app()->user->setFlash('error',"Data tidak valid ".$this->traceObatAlkesPasien($modPemakainBahans));
        }
      } else {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data tidak valid 2");
        //Yii::app()->user->setFlash('error',"Data tidak valid ".$this->traceTindakan($modTindakans));
      }
    } catch (Exception $exc) {
      $transaction->rollback();
      Yii::app()->user->setFlash('error', "Data Tindakan Pasien Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
    }

    return $modTindakans;
  }

  protected function cekAlatmedis($daftartindakan_id)
  {
    $idAlatmedis = null;
    if (!empty($_POST['pemakaianAlat'])) {
      foreach ($_POST['pemakaianAlat'] as $k => $item) {
        if ($item['daftartindakan_id'] == $daftartindakan_id) {
          $idAlatmedis = $item['alatmedis_id'];
        }
      }
    }

    return $idAlatmedis;
  }

  private function traceTindakan($modTindakans)
  {
    foreach ($modTindakans as $key => $modTindakan) {
      $echo .= "<pre>" . print_r($modTindakan->attributes, 1) . "</pre>";
    }
    return $echo;
  }

  public function actionAjaxDeleteTindakanPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idTindakanpelayanan = (isset($_POST['idTindakanpelayanan']) ? $_POST['idTindakanpelayanan'] : null);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $obatAlkesT = GZObatalkesPasienT::model()->findAllByAttributes(
          array(
            'tindakanpelayanan_id' => $idTindakanpelayanan
          )
        );
        $data['success'] = true;
        if (count((array)$obatAlkesT) > 0) {
          $this->kembalikanStok($obatAlkesT);
          $deleteObatPasien = GZObatalkesPasienT::model()->deleteAllByAttributes(
            array(
              'tindakanpelayanan_id' => $idTindakanpelayanan
            )
          );
          $deleteKomponenTindakan = GZTindakanKomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $idTindakanpelayanan));
          $deleteTindakan = GZTindakanpelayananT::model()->deleteByPk($idTindakanpelayanan);
          if (!$deleteObatPasien) {
            $data['success'] = false;
          }
        } else {
          $deleteKomponenTindakan = GZTindakanKomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $idTindakanpelayanan));
          $deleteTindakan = GZTindakanpelayananT::model()->deleteByPk($idTindakanpelayanan);
        }

        if ($deleteTindakan && $data['success']) {
          $data['success'] = true;
          $transaction->commit();
        } else {
          $data['success'] = false;
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        echo MyExceptionMessage::getMessage($exc, true);
        $data['success'] = false;
      }



      echo json_encode($data);
      Yii::app()->end();
    }
  }

  protected function savePaketBmhp($modPendaftaran, $paketBmhp, $tindakan)
  {
    $modObatPasien = array();
    $valid = true;
    $totalBmhp = 0;
    foreach ($paketBmhp as $i => $bmhp) {
      if ($tindakan->daftartindakan_id == $bmhp['daftartindakan_id']) {
        $modObatPasien[$i] = new GZObatalkesPasienT;
        $modObatPasien[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modObatPasien[$i]->penjamin_id = $modPendaftaran->penjamin_id;
        $modObatPasien[$i]->carabayar_id = $modPendaftaran->carabayar_id;
        $modObatPasien[$i]->daftartindakan_id = $bmhp['daftartindakan_id'];
        $modObatPasien[$i]->sumberdana_id = $bmhp['sumberdana_id'];
        $modObatPasien[$i]->pasien_id = $modPendaftaran->pasien_id;
        $modObatPasien[$i]->satuankecil_id = $bmhp['satuankecil_id'];
        $modObatPasien[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modObatPasien[$i]->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
        $modObatPasien[$i]->tipepaket_id = Params::TIPEPAKET_BMHP; //$tindakan->tipepaket_id;
        $modObatPasien[$i]->obatalkes_id = $bmhp['obatalkes_id'];
        $modObatPasien[$i]->pegawai_id = $modPendaftaran->pegawai_id;
        $modObatPasien[$i]->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        $modObatPasien[$i]->shift_id = Yii::app()->user->getState('shift_id');
        $modObatPasien[$i]->tglpelayanan = date('Y-m-d H:i:s');
        $modObatPasien[$i]->qty_oa = $bmhp['qtypemakaian'];
        $modObatPasien[$i]->hargajual_oa = $bmhp['hargapemakaian'];
        $modObatPasien[$i]->harganetto_oa = $bmhp['harganetto'];
        $modObatPasien[$i]->hargasatuan_oa = $bmhp['hargapemakaian']; //$bmhp['hargasatuan'];
        $totalBmhp = $totalBmhp + $bmhp['hargapemakaian'];

        $valid = $modObatPasien[$i]->validate() && $valid;
        if ($valid) {
          $modObatPasien[$i]->save();
          $this->kurangiStok($modObatPasien[$i]->qty_oa, $modObatPasien[$i]->obatalkes_id);
          $this->successSaveBmhp = true;
        } else {
          $this->successSaveBmhp = false;
        }
      }
    }

    $totalBmhp = $totalBmhp + $tindakan->tarif_bhp;
    $tindakan->tarif_bhp = $totalBmhp;
    $tindakan->update();

    return $modObatPasien;
  }

  protected function savePemakaianBahan($modPendaftaran, $pemakaianBahan, $tindakan)
  {
    $modPakaiBahan = null;
    $valid = true;
    foreach ($pemakaianBahan as $i => $bmhp) {
      if ($tindakan->daftartindakan_id == $bmhp['daftartindakan_id']) {
        $modPakaiBahan[$i] = new GZObatalkesPasienT;
        $modPakaiBahan[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modPakaiBahan[$i]->penjamin_id = $modPendaftaran->penjamin_id;
        $modPakaiBahan[$i]->carabayar_id = $modPendaftaran->carabayar_id;
        $modPakaiBahan[$i]->daftartindakan_id = $bmhp['daftartindakan_id'];
        $modPakaiBahan[$i]->sumberdana_id = $bmhp['sumberdana_id'];
        $modPakaiBahan[$i]->pasien_id = $modPendaftaran->pasien_id;
        $modPakaiBahan[$i]->satuankecil_id = $bmhp['satuankecil_id'];
        $modPakaiBahan[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modPakaiBahan[$i]->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
        $modPakaiBahan[$i]->tipepaket_id = $tindakan->tipepaket_id;
        $modPakaiBahan[$i]->obatalkes_id = $bmhp['obatalkes_id'];
        $modPakaiBahan[$i]->pegawai_id = $modPendaftaran->pegawai_id;
        $modPakaiBahan[$i]->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        $modPakaiBahan[$i]->shift_id = Yii::app()->user->getState('shift_id');
        $modPakaiBahan[$i]->tglpelayanan = date('Y-m-d H:i:s');
        $modPakaiBahan[$i]->qty_oa = $bmhp['qty'];
        $modPakaiBahan[$i]->hargajual_oa = $bmhp['subtotal'];
        $modPakaiBahan[$i]->harganetto_oa = $bmhp['harganetto'];
        $modPakaiBahan[$i]->hargasatuan_oa = $bmhp['hargasatuan'];
        $modPakaiBahan[$i]->oa = Params::OBATALKESPASIEN_BMHP;

        $valid = $modPakaiBahan[$i]->validate() && $valid;
        if ($valid) {
          $modPakaiBahan[$i]->save();
          $this->kurangiStok($modPakaiBahan[$i]->qty_oa, $modPakaiBahan[$i]->obatalkes_id);
          $this->successSavePemakaianBahan = true;
        } else {
          $this->successSavePemakaianBahan = false;
        }
      }
    }

    return $modPakaiBahan;
  }

  private function traceObatAlkesPasien($modObatPasiens)
  {
    foreach ($modObatPasiens as $key => $modObatPasien) {
      $echo .= "<pre>" . print_r($modObatPasien->attributes, 1) . "</pre>";
    }
    return $echo;
  }

  /**
   * 
   * @param ObatalkespasienT $modObatPasien 
   */
  protected function saveObatAlkesKomponen($modObatPasien)
  {
    $modObatPasien = new ObatalkespasienT;
    $obat = ObatalkesM::model()->findByPk($modObatPasien->obatalkes_id);
    $obat = new ObatalkesM;
    $modObatPasienKomponen = new ObatalkeskomponenT;
    $modObatPasienKomponen->obatalkespasien_id = $modObatPasien->obatalkespasien_id;
    $modObatPasienKomponen->hargajualkomponen = $obat->hargajual;
    $modObatPasienKomponen->harganettokomponen = $obat->harganetto;
    $modObatPasienKomponen->hargasatuankomponen = $obat->hargajual;
    $modObatPasienKomponen->iurbiaya = 0;
    $modObatPasienKomponen->komponentarif_id = null;
  }

  protected function kurangiStok($qty, $idobatAlkes)
  {
    $sql = "SELECT stokobatalkes_id,qtystok_in,qtystok_out,qtystok_current FROM stokobatalkes_t WHERE obatalkes_id = $idobatAlkes ORDER BY tglstok_in";
    $stoks = Yii::app()->db->createCommand($sql)->queryAll();
    $selesai = false;
    //            while(!$selesai){
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
    //            }
  }

  protected function kembalikanStok($obatAlkesT)
  {
    foreach ($obatAlkesT as $i => $obatAlkes) {
      $stok = new GZStokObatalkesT;
      $stok->obatalkes_id = $obatAlkes->obatalkes_id;
      $stok->sumberdana_id = $obatAlkes->sumberdana_id;
      $stok->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $stok->tglstok_in = date('Y-m-d H:i:s');
      $stok->tglstok_out = date('Y-m-d H:i:s');
      $stok->qtystok_in = $obatAlkes->qty_oa;
      $stok->qtystok_out = 0;
      $stok->qtystok_current = $obatAlkes->qty_oa;
      $stok->harganetto_oa = $obatAlkes->harganetto_oa;
      $stok->hargajual_oa = $obatAlkes->hargasatuan_oa;
      $stok->discount = $obatAlkes->discount;
      $stok->satuankecil_id = $obatAlkes->satuankecil_id;
      $stok->save();
    }
  }

  public function actionLoadFormTindakanPaket()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $tipepaket_id = (isset($_POST['tipepaket_id']) ? $_POST['tipepaket_id'] : null);
      $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
      $kelompokumur_id = (isset($_POST['kelompokumur_id']) ? $_POST['kelompokumur_id'] : null);
      $carabayar_id = isset($_POST['carabayar_id']) ? $_POST['carabayar_id'] : null;

      $modPaketTindakan = PaketpelayananV::model()->findAllByAttributes(array('tipepaket_id' => $tipepaket_id));
      $modTindakans = array();
      $optionDaftarttindakan = '';
      if (isset($modPaketTindakan)) {
        if ($tipepaket_id != Params::TIPEPAKET_ID_LUARPAKET) {
          foreach ($modPaketTindakan as $i => $tindakan) {

            $modTindakans[$i] = new TindakanpelayananT;
            $modTindakans[$i]->daftartindakan_id = $tindakan->daftartindakan_id;
            $modTindakans[$i]->daftartindakanNama = $tindakan->daftartindakan_nama;
            $modTindakans[$i]->kategoriTindakanNama = $tindakan->kategoritindakan_nama;
            $modTindakans[$i]->qty_tindakan = 1;
            $modTindakans[$i]->persenCyto = 0;
            //                    $modTindakans[$i]->tarif_satuan = $tindakan->tarifpaketpel;
            $modTindakans[$i]->tarif_satuan = $tindakan->iurbiaya;
            $modTindakans[$i]->jumlahTarif = $modTindakans[$i]->qty_tindakan * $modTindakans[$i]->tarif_satuan;
            $modTindakans[$i]->subsidiasuransi_tindakan = 0;
            $modTindakans[$i]->subsidipemerintah_tindakan = 0;
            $modTindakans[$i]->subsisidirumahsakit_tindakan = 0;
            $modTindakans[$i]->iurbiaya_tindakan = 0; //$tindakan->iurbiaya;


            //buat option daftartindakanPemakaianBahan
            $optionDaftarttindakan .= CHtml::tag('option', array('value' => $modTindakans[$i]->daftartindakan_id), $modTindakans[$i]->daftartindakanNama, true);
          }
        }
      }

      // ambil data untuk paket BMHP
      $totHargaBmhp = 0;
      $criteria = new CDbCriteria();
      $criteria->compare('tipepaket_id', $tipepaket_id);
      $criteria->compare('kelompokumur_id', $kelompokumur_id);
      $criteria->with = array('obatalkes', 'daftartindakan');
      $modPaketBmhp = PaketbmhpM::model()->findAll($criteria);
      //            $modPaketBmhp = PaketbmhpM::model()->with('obatalkes','daftartindakan')->findAllByAttributes(array('tipepaket_id'=>$tipepaket_id,
      //                                                                                                               'kelompokumur_id'=>$kelompokumur_id));
      if (isset($modPaketBmhp)) {
        foreach ($modPaketBmhp as $i => $bmhp) {
          $totHargaBmhp = $totHargaBmhp + $bmhp->hargapemakaian;
        }
      }
      // ---------------------------

      echo CJSON::encode(array(
        'form' => $this->renderPartial('_formLoadTindakanPaket', array(
          'modPaketTindakan' => $modPaketTindakan,
          'modTindakans' => $modTindakans,
        ), true),
        'formPaketBmhp' => $this->renderPartial('_formLoadPaketBmhp', array(
          'modPaketBmhp' => $modPaketBmhp,
        ), true),
        'totHargaBmhp' => $totHargaBmhp,
        'optionDaftarttindakan' => $optionDaftarttindakan,
      ));
      exit;
    }
  }

  public function actionAddFormPaketBmhp()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $kelompokumur_id = (isset($_POST['kelompokumur_id']) ? $_POST['kelompokumur_id'] : null);
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : null);
      $modPaketBmhp = PaketbmhpM::model()->with('daftartindakan', 'obatalkes')->findAllByAttributes(array(
        'daftartindakan_id' => $daftartindakan_id,
        'kelompokumur_id' => $kelompokumur_id,
      ));
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      echo CJSON::encode(array(
        'form' => $this->renderPartial('_formAddPaketBmhp', array(
          'modPaketBmhp' => $modPaketBmhp, 'modPendaftaran' => $modPendaftaran,
        ), true),
      ));
      exit;
    }
  }

  public function actionAddFormPemakaianBahan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $obatalkes_id = (isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null);
      $daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : "");
      $modObatAlkes = ObatalkesM::model()->findByPk($obatalkes_id);
      $modDaftartindakan = DaftartindakanM::model()->findByPk($daftartindakan_id);
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $persenjual = $this->persenJualRuangan();
      $modObatAlkes->hargajual = floor(($persenjual + 100) / 100 * $modObatAlkes->hargajual);

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
  protected function persenJualRuangan()
  {
    switch (Yii::app()->user->getState('instalasi_id')) {
      case Params::INSTALASI_ID_RI:
        $persen = Yii::app()->user->getState('ri_persjual');
        break;
      case Params::INSTALASI_ID_RJ:
        $persen = Yii::app()->user->getState('rj_persjual');
        break;
      case Params::INSTALASI_ID_RD:
        $persen = Yii::app()->user->getState('rd_persjual');
        break;
      default:
        $persen = 0;
        break;
    }

    return $persen;
  }
  /**
   * action ajax untuk mencari daftar tindakan pada auto complete
   */
  public function actionDaftarTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (!isset($_GET['term'])) {
        $_GET['term'] = null;
      }
      $kelaspelayanan_id = (isset($_GET['kelaspelayanan_id']) ? $_GET['kelaspelayanan_id'] : null);
      $tipepaket_id = (isset($_GET['tipepaket_id']) ? $_GET['tipepaket_id'] : null);
      if ($_GET['tipepaket_id'] == Params::TIPEPAKET_ID_LUARPAKET) {
        //                    $sql = "SELECT * FROM paketpelayanan_m
        //                            JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = paketpelayanan_m.daftartindakan_id
        //                            JOIN kategoritindakan_m ON kategoritindakan_m.kategoritindakan_id = daftartindakan_m.kategoritindakan_id
        //                            WHERE tipepaket_id = ".Params::TIPEPAKET_ID_LUARPAKET."
        //                            AND LOWER(daftartindakan_m.daftartindakan_nama) LIKE '".strtolower($_GET['term'])."%'";
        //                            AND tariftindakan_m.kelaspelayanan_id = 22 
        //                            AND ruangan_id = 1";
        //                    $datas = Yii::app()->db->createCommand($sql)->queryAll();
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
        //                    $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['daftartindakanNama']), true);
        if (Yii::app()->user->getState('tindakanruangan'))
          $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
        if (Yii::app()->user->getState('tindakankelas'))
          $criteria->compare('kelaspelayanan_id', $kelaspelayanan_id);
        $criteria->compare('tipepaket_id', Params::TIPEPAKET_ID_LUARPAKET);
        if (isset($_GET['daftartindakan_id'])) {
          $criteria->compare('daftartindakan_id', $_GET['daftartindakan_id']);
        }
        $criteria->compare('kelaspelayanan_id', $kelaspelayanan_id);
        $criteria->order = 'daftartindakan_nama';
        $models = PaketpelayananV::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->daftartindakan_nama;
          $returnVal[$i]['value'] = $model->daftartindakan_id;
        }

        echo CJSON::encode($returnVal);
      } else if ($_GET['tipepaket_id'] == Params::TIPEPAKET_ID_NONPAKET) {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
        $criteria->compare('kelaspelayanan_id', $kelaspelayanan_id);
        $criteria->order = 'daftartindakan_nama';

        if (isset($_GET['daftartindakan_id'])) {
          $criteria->compare('daftartindakan_id', $_GET['daftartindakan_id']);
        }

        //                    print_r(Yii::app()->user->getState('tindakankelas'));
        if (Yii::app()->user->getState('tindakankelas')) {
          $criteria->compare('kelaspelayanan_id', $kelaspelayanan_id);
        }

        //                    print_r(Yii::app()->user->getState('ruangan_id'));
        if (Yii::app()->user->getState('tindakanruangan')) {
          $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
          $models = TariftindakanperdaruanganV::model()->findAll($criteria);
        } else {
          $models = TariftindakanperdaV::model()->findAll($criteria);
        }
        $returnVal = array();
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->daftartindakan_nama;
          $returnVal[$i]['value'] = $model->daftartindakan_id;
        }

        echo CJSON::encode($returnVal);
      } else {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
        if (isset($_GET['daftartindakan_id'])) {
          $criteria->compare('daftartindakan_id', $_GET['daftartindakan_id']);
        }

        if (Yii::app()->user->getState('tindakanruangan'))
          $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));

        if (Yii::app()->user->getState('tindakankelas'))
          $criteria->compare('kelaspelayanan_id', $_GET['kelaspelayanan_id']);

        $criteria->compare('tipepaket_id', $_GET['tipepaket_id']);
        $criteria->compare('kelaspelayanan_id', $_GET['kelaspelayanan_id']);
        $criteria->order = 'daftartindakan_nama';
        $models = PaketpelayananV::model()->find($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->daftartindakan_nama;
          $returnVal[$i]['value'] = $model->daftartindakan_id;
        }

        echo CJSON::encode($returnVal);
      }
    }
    Yii::app()->end();
  }

  /**
   * action ajax untuk mencari pemakaian bahan pada auto complete
   */
  public function actionPemakaianBahan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
      //$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
      $criteria->order = 'obatalkes_nama';
      $criteria->addCondition('obatalkes_farmasi is true');
      $criteria->limit = 5;
      $models = ObatalkesM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->obatalkes_nama;
        $returnVal[$i]['value'] = $model->obatalkes_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * action ajax untuk mencari daftar pemakaian alat medis pada auto complete
   */
  public function actionPemakaianAlatMedis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->with = array('jenisalatmedis');
      $criteria->compare('LOWER(alatmedis_nama)', strtolower($_GET['term']), true);
      //                $criteria->compare('t.instalasi_id', Yii::app()->user->getState('instalasi_id'));
      $criteria->order = 't.alatmedis_nama';
      $models = AlatmedisM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->alatmedis_nama;
        $returnVal[$i]['value'] = $model->alatmedis_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * action ajax untuk mencari daftar bmhp pada auto complete
   */
  public function actionPaketBMHP()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->with = array('obatalkes', 'daftartindakan', 'kelompokumur');
      $criteria->compare('LOWER(daftartindakan.daftartindakan_nama)', strtolower($_GET['term']), true);
      //$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
      $criteria->addCondition('t.kelompokumur_id is not null');
      $criteria->order = 'daftartindakan.daftartindakan_nama';
      $criteria->limit = 5;
      $models = PaketbmhpM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $kelompokumur_nama = isset($model->kelompokumur->kelompokumur_nama) ? $model->kelompokumur->kelompokumur_nama : "";
        $returnVal[$i]['label'] = $model->obatalkes->obatalkes_nama . ' - ' . $model->daftartindakan->daftartindakan_nama . ' (' . $kelompokumur_nama . ')';
        $returnVal[$i]['value'] = $model->obatalkes->obatalkes_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * action ajax untuk mencari data dokter pada auto complete
   */
  public function actionGetDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      if (isset($_GET['term'])) {
        $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      }
      //$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
      $criteria->order = 'nama_pegawai';
      if (isset($_GET['idPegawai'])) {
        $criteria->compare('pegawai_id', $_GET['idPegawai']);
      }
      $models = DokterpegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * ajax action untuk menambahkan baris pada pemakaian alat medis
   */
  public function actionAddFormPemakaianAlat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $alatmedis_id = (isset($_POST['alatmedis_id']) ? $_POST['alatmedis_id'] : null);
      $daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : null);
      $modAlat = AlatmedisM::model()->findByPk($alatmedis_id);
      $modDaftartindakan = DaftartindakanM::model()->findByPk($daftartindakan_id);
      $modObatAlkes = new ObatalkesM;
      echo CJSON::encode(array(
        'namaAlat' => $modAlat->alatmedis_nama,
        'form' => $this->renderPartial('_formAddPemakaianAlat', array(
          'modAlat' => $modAlat, 'modDaftartindakan' => $modDaftartindakan, 'modObatAlkes' => $modObatAlkes
        ), true),
      ));
      exit;
    }
  }
}
