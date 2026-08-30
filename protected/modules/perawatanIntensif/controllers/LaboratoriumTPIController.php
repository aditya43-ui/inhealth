<?php
Yii::import('rawatInap.models.*');

class LaboratoriumTPIController extends MyAuthController
{
  protected $statusSaveKirimkeUnitLain = false;
  protected $statusSavePermintaanPenunjang = false;
  protected $tindakanpelayanantersimpan = true;
  protected $komponentindakantersimpan = true;
  protected $path_view = 'perawatanIntensif.views.laboratoriumTPI.';

  public function actionIndex($pendaftaran_id, $pasienadmisi_id)
  {
    $this->layout = '//layouts/iframe';
    $modPasienMasukPenunjang = array();
    $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id)) : array();
    $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modKirimKeUnitLain = new RIPasienKirimKeUnitLainT;
    $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
    $modKirimKeUnitLain->pegawai_id = $modAdmisi->pegawai_id;
    //RSPMC-1260
    if (!empty(Yii::app()->user->getState('kelasrujukanpenunjang_id'))) {
      $modKirimKeUnitLain->kelaspelayanan_id = Yii::app()->user->getState('kelasrujukanpenunjang_id');
    } else {
      $modKirimKeUnitLain->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS; //$modAdmisi->kelaspelayanan_id; //RND-8117
    }

    $modKirimKeUnitLain->isbayarkekasirpenunjang = ($modPendaftaran->carabayar_id == 1) ? Yii::app()->user->getState('isbayarkekasirpenunjang') : false;
    $modJenisPeriksaLab = RIJenisPemeriksaanLabM::model()->findAllByAttributes(array('jenispemeriksaanlab_aktif' => true), array('order' => 'jenispemeriksaanlab_urutan'));


    $critpl = new CDbCriteria;
    $critpl->select = 't.pemeriksaanlab_id, t.pemeriksaanlab_nama, j.jenispemeriksaanlab_id,
                        j.jenispemeriksaanlab_nama, d.daftartindakan_id, k.kelaspelayanan_id';
    $critpl->join = ' JOIN jenispemeriksaanlab_m j ON t.jenispemeriksaanlab_id = j.jenispemeriksaanlab_id
                      JOIN daftartindakan_m d ON t.daftartindakan_id = d.daftartindakan_id
                      JOIN tariftindakan_m tt ON tt.daftartindakan_id = d.daftartindakan_id
                      JOIN kelaspelayanan_m k ON tt.kelaspelayanan_id = k.kelaspelayanan_id ';
    $critpl->group = $critpl->select;

    $critpl->addCondition('t.pemeriksaanlab_aktif = true');

    if(!empty($modPendaftaran->kelaspelayanan_id)) {
      $critpl->addCondition('k.kelaspelayanan_id = ' . $modPendaftaran->kelaspelayanan_id);
    }

    $modPeriksaLab = RIPemeriksaanLabM::model()->findAll($critpl);

    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modAdmisi->penjamin_id);
    $modPemeriksaanLab = new TarifpemeriksaanlabruanganV();

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

    if (isset($_GET['idPasienKirimKeUnitLain'])) {
      $modKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findByPk($_GET['idPasienKirimKeUnitLain']);
      $modPasien = $modKirimKeUnitLain->pasien;
    }

    if (isset($_POST['RIPasienKirimKeUnitLainT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        // if($_POST['RIPasienKirimKeUnitLainT']['is_cyto'] == 1){
        //   $_POST['RIPasienKirimKeUnitLainT']['is_cyto'] = true;
        // } else{
        //   $_POST['RIPasienKirimKeUnitLainT']['is_cyto'] = false;
        // }
        if (isset($_POST['permintaanPenunjang'])) {
          $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modAdmisi, Params::RUANGAN_ID_LAB_KLINIK);
        }

        if (isset($_POST['permintaanPenunjangAnatomi'])) {
          //$modKirimKeUnitLainAnatomi = $this->savePasienKirimKeUnitLain($modAdmisi, Params::RUANGAN_ID_LAB_ANATOMI);
          $modKirimKeUnitLainAnatomi = $this->savePasienKirimKeUnitLain($modAdmisi, Params::RUANGAN_ID_LAB_KLINIK);
          //$modKirimKeUnitLain->pasienkirimkeunitlain_id = $modKirimKeUnitLainAnatomi->pasienkirimkeunitlain_id;						
        }

        if (isset($_POST['permintaanPenunjang']) || isset($_POST['permintaanPenunjangAnatomi'])) {

          if (isset($_POST['permintaanPenunjang'])) {
            $this->savePermintaanPenunjang($_POST['permintaanPenunjang'], $modKirimKeUnitLain);
          }

          if (isset($_POST['permintaanPenunjangAnatomi'])) {
            $this->savePermintaanPenunjang($_POST['permintaanPenunjangAnatomi'], $modKirimKeUnitLainAnatomi);
          }
        } else {
          $this->statusSavePermintaanPenunjang = true;
        }

        //	RND-9378		if($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang && $this->tindakanpelayanantersimpan){
        if ($this->tindakanpelayanantersimpan) {

          $judul = 'Pasien Rujuk ke Laboratorium';

          $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;

          if (!empty($modKirimKeUnitLain->pendaftaran_id)) {
            $mr = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);

            $link = $this->createUrl('/laboratorium/RujukanPenunjang/Index', array(
              'LBPasienKirimKeUnitLainV[tgl_awal]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
              'LBPasienKirimKeUnitLainV[tgl_akhir]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
              'LBPasienKirimKeUnitLainV[no_pendaftaran]' => substr($modKirimKeUnitLain->pendaftaran->no_pendaftaran, 2),
              'LBPasienKirimKeUnitLainV[prefix_pendaftaran]' => substr($modKirimKeUnitLain->pendaftaran->no_pendaftaran, 0, 2),
              'LBPasienKirimKeUnitLainV[no_rekam_medik]' => $modPasien->no_rekam_medik,
              'LBPasienKirimKeUnitLainV[nama_pasien]' => $modPasien->nama_pasien
            ));

            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
              array('instalasi_id' => $mr->instalasi_id, 'ruangan_id' => $mr->ruangan_id, 'modul_id' => $mr->modul_id, 'link_proses' => $link),
              // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
              // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
            ));
          }

          if (!empty($modKirimKeUnitLainAnatomi->pendaftaran_id)) {
            $mr = RuanganM::model()->findByPk($modKirimKeUnitLainAnatomi->ruangan_id);

            $link = $this->createUrl('/laboratorium/RujukanPenunjang/Index', array(
              'LBPasienKirimKeUnitLainV[tgl_awal]' => date('Y-m-d', strtotime($modKirimKeUnitLainAnatomi->tgl_kirimpasien)),
              'LBPasienKirimKeUnitLainV[tgl_akhir]' => date('Y-m-d', strtotime($modKirimKeUnitLainAnatomi->tgl_kirimpasien)),
              'LBPasienKirimKeUnitLainV[no_pendaftaran]' => substr($modKirimKeUnitLainAnatomi->pendaftaran->no_pendaftaran, 2),
              'LBPasienKirimKeUnitLainV[prefix_pendaftaran]' => substr($modKirimKeUnitLainAnatomi->pendaftaran->no_pendaftaran, 0, 2),
              'LBPasienKirimKeUnitLainV[no_rekam_medik]' => $modPasien->no_rekam_medik,
              'LBPasienKirimKeUnitLainV[nama_pasien]' => $modPasien->nama_pasien
            ));

            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
              array('instalasi_id' => $mr->instalasi_id, 'ruangan_id' => $mr->ruangan_id, 'modul_id' => $mr->modul_id, 'link_proses' => $link),
              // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
              // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
            ));
          }

          // SMS GATEWAY
          $modPegawai = $modPendaftaran->pegawai;
          $sms = new Sms();
          $smspasien = 1;

          foreach ($modSmsgateway as $i => $smsgateway) {
            if (isset($_POST['tujuansms']) && in_array($smsgateway->tujuansms, $_POST['tujuansms'])) {
              $isiPesan = $smsgateway->templatesms;

              $attributes = $modPasien->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modPendaftaran->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modPegawai->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modKirimKeUnitLain->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modKirimKeUnitLain->tgl_kirimpasien), $isiPesan);



              if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                if (!empty($modPasien->no_mobile_pasien)) {
                  $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                } else {
                  $smspasien = 0;
                }
              }
            }
          }
          // END SMS GATEWAY

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'smspasien' => $smspasien, 'pasienkirim_id'=>$modKirimKeUnitLain->pasienkirimkeunitlain_id));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data tidak valid ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array('pendaftaran_id' => $pendaftaran_id),
      'pasienmasukpenunjang_id IS NULL AND ruangan_id IN(' . Params::RUANGAN_ID_LAB_KLINIK . ',' . Params::RUANGAN_ID_LAB_ANATOMI . ')'
    );

    $modBayarUangMuka = RIBayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $total = 0;
    foreach ($modBayarUangMuka as $key => $value) {
      $total += $modBayarUangMuka[$key]->jumlahuangmuka;
    }
    $modDeposit = (($modBayarUangMuka) ? $total : null);

    $this->render($this->path_view.'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modKirimKeUnitLain' => $modKirimKeUnitLain,
      'modJenisPeriksaLab' => $modJenisPeriksaLab,
      'modPeriksaLab' => $modPeriksaLab,
      'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
      'modAdmisi' => $modAdmisi,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modJenisTarif' => $modJenisTarif,
      'modDeposit' => $modDeposit,
      'modPemeriksaanLab' => $modPemeriksaanLab
    ));
  }

  protected function savePasienKirimKeUnitLain($modAdmisi, $ruangan_lab)
  {
    $modKirimKeUnitLain = new RIPasienKirimKeUnitLainT;
    $modKirimKeUnitLain->attributes = $_POST['RIPasienKirimKeUnitLainT'];
    $modKirimKeUnitLain->pasien_id = $modAdmisi->pasien_id;
    $modKirimKeUnitLain->pendaftaran_id = $modAdmisi->pendaftaran_id;
    $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_LAB;
    $modKirimKeUnitLain->kelaspelayanan_id = $modAdmisi->kelaspelayanan_id;
    $modKirimKeUnitLain->ruangan_id = $ruangan_lab;
    $modKirimKeUnitLain->ppds_id = isset($_POST['RIPasienKirimKeUnitLainT']['ppds_id']) ? $_POST['RIPasienKirimKeUnitLainT']['ppds_id'] : false;
    $modKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->update_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
    $modKirimKeUnitLain->isbayarkekasirpenunjang = isset($_POST['RIPasienKirimKeUnitLainT']['isbayarkekasirpenunjang']) ? $_POST['RIPasienKirimKeUnitLainT']['isbayarkekasirpenunjang'] : 0;
    $modKirimKeUnitLain->is_cito = isset($_POST['RIPasienKirimKeUnitLainT']['is_cito']) ? $_POST['RIPasienKirimKeUnitLainT']['is_cito'] : false;
    $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
    if ($modKirimKeUnitLain->validate()) {
      $modKirimKeUnitLain->save();
      $this->statusSaveKirimkeUnitLain = true;
    }

    return $modKirimKeUnitLain;
  }

  protected function savePermintaanPenunjang($permintaan, $modKirimKeUnitLain)
  {
    foreach ($permintaan['inputpemeriksaanlab'] as $i => $value) {
      $modPermintaan = new RIPermintaanPenunjangT;
      $modPermintaan->daftartindakan_id = isset($permintaan['idDaftarTindakan'][$i]) ? $permintaan['idDaftarTindakan'][$i] : null;
      $modPermintaan->pemeriksaanlab_id = $permintaan['inputpemeriksaanlab'][$i];
      $modPermintaan->pemeriksaanrad_id = '';
      $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
      $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PL');
      $modPermintaan->qtypermintaan = $permintaan['inputqty'][$i];
      $modPermintaan->tarif_pelayananan = str_replace(",", "", $permintaan['inputtarifpemeriksaanlab'][$i]);
      $modPermintaan->tglpermintaankepenunjang = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
      if($modKirimKeUnitLain->is_cyto == true){
        $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$modKirimKeUnitLain->kelaspelayanan_id,
                                                                            'daftartindakan_id'=>$modPermintaan->pemeriksaanlab->daftartindakan_id,
                                                                            'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
        $modPermintaan->tarif_pelayananan = empty($modTarif) ? 0 : $modTarif->totaltarifakhir_cyto;
      }else{
        $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$modKirimKeUnitLain->kelaspelayanan_id,
                                                                            'daftartindakan_id'=>$modPermintaan->pemeriksaanlab->daftartindakan_id,
                                                                            'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
        $modPermintaan->tarif_pelayananan = empty($modTarif) ? 0 : $modTarif->harga_tariftindakan;
      }
      if ($modPermintaan->validate()) {
        if ($modPermintaan->save()) {
          $this->statusSavePermintaanPenunjang = true;
          /*
						if($modKirimKeUnitLain->isbayarkekasirpenunjang){ 
							$modMasukKamar = MasukkamarT::model()->findByAttributes(array('pasienadmisi_id'=>$modKirimKeUnitLain->pendaftaran->pasienadmisi_id),'pindahkamar_id IS NULL');
							$modTindakan = $this->simpanTindakanPelayanan($modMasukKamar,$modKirimKeUnitLain,$modPermintaan); //AGAR BISA DI BAYAR DI KASIR
							$modPermintaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
							$modPermintaan->update();
						}
                         * 
                         */
        }
      }
    }
  }

  /**
   * proses simpan TindakanPelayananT dan TindakanKomponenT
   * khusus untuk permintaan penunjang (RI)
   */
  public function simpanTindakanPelayanan($modMasukKamar, $modKirimKeUnitLain, $modPermintaan)
  {
    $modTindakan = new RITindakanPelayananT;
    $modTindakan->attributes = $modMasukKamar->admisi->pendaftaran->attributes;
    $modTindakan->attributes = $modMasukKamar->admisi->attributes;
    $modTindakan->attributes = $modMasukKamar->attributes;
    $modTindakan->ruangan_id = $modKirimKeUnitLain->ruangan_id;
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    $modTindakan->daftartindakan_id = $modPermintaan->daftartindakan_id;
    $modTindakan->tarif_satuan = $modPermintaan->tarif_pelayananan;
    $modTindakan->qty_tindakan = $modPermintaan->qtypermintaan;
    $modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_LABORATORIUM;
    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->dokterpemeriksa1_id = $modKirimKeUnitLain->pegawai_id;
    $modTindakan->perawat_id = (!empty($modKirimKeUnitLain->perawat_id) ? $modKirimKeUnitLain->perawat_id : null);
    $modTindakan->tgl_tindakan = $modPermintaan->tglpermintaankepenunjang;
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
    $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
    $modTindakan->cyto_tindakan = 0;
    $modTindakan->tarifcyto_tindakan = 0;
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
        $this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
      }
    } else {
      $this->tindakanpelayanantersimpan &= false;
    }

    return $modTindakan;
  }
  //copy dari RJ - LaboratoriumController
  public function actionAjaxBatalKirim()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pasienkirimkeunitlain_id = $_POST['pasienkirimkeunitlain_id'];
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $data['pesan'] = "Pasien kirim ke laboratorium gagal dibatalkan!";
      $data['sukses'] = 0;
      $status = 'ok';

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $criteria = new CDbCriteria();
        $criteria->select = "count(t.permintaankepenunjang_id) as permintaankepenunjang_id";
        $criteria->join = "join tindakanpelayanan_t tp on tp.tindakanpelayanan_id = t.tindakanpelayanan_id ";
        $criteria->addCondition("t.pasienkirimkeunitlain_id = " . $pasienkirimkeunitlain_id . " and tp.tindakansudahbayar_id is not null");
        $permintaan = PermintaankepenunjangT::model()->find($criteria);

        if ($permintaan->permintaankepenunjang_id > 0) {
          $data['pesan'] = "Pasien kirim ke laboratorium tidak bisa dibatalkan karena tindakan sudah dibayarkan!";
          $data['sukses'] = 0;
        } else {
          $ok = true;
          $kirim = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);

          if (!empty($kirim)) {
            $kirimUnit = array(
              'instalasi_id' => $kirim->instalasi_id,
              'ruangan_id' => $kirim->ruangan_id,
              'pasien_id' => $kirim->pasien_id,
              'no_pendaftaran' => $kirim->pendaftaran->no_pendaftaran
            );
          }


          $permintaan = PermintaankepenunjangT::model()->findAllByAttributes(array(
            'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id
          ));
          foreach ($permintaan as $item) {
            if (!empty($item->tindakanpelayanan_id)) {
              $ok = $ok && TindakanpelayananT::model()->deleteByPk($item->tindakanpelayanan_id);
            }
          }
          $ok = $ok && PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
          $ok = $ok && PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
          $keterangan = "Pasien berhasil dibatalkan";

          if ($status == 'ok' && $ok) {

            $this->notifBatalRujuk($kirimUnit);

            $data['pesan'] = "Pasien kirim ke laboratorium berhasil dibatalkan!";
            $data['sukses'] = 1;
            $transaction->commit();
          } else {
            $transaction->rollback();
            $data['pesan'] = "Pasien kirim ke laboratorium tidak bisa dibatalkan!";
            $data['sukses'] = 0;
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['pesan'] = "Pasien kirim ke laboratorium gagal dibatalkan!<br/>" . $exc->getMessage();
        $data['sukses'] = 0;
      }
      $modRiwayatKirimKeUnitLain = PasienkirimkeunitlainT::model()->findAllByAttributes(
        array('pendaftaran_id' => $pendaftaran_id),
        'pasienmasukpenunjang_id IS NULL AND ruangan_id IN(' . Params::RUANGAN_ID_LAB_KLINIK . ',' . Params::RUANGAN_ID_LAB_ANATOMI . ')'
      );
      $data['result'] = $this->renderPartial('_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * ajax untuk load pemeriksaan lab ketika di cekllist
   */
  public function actionLoadFormPemeriksaanLab()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pemeriksaanlab_id = (isset($_POST['pemeriksaanlab_id']) ? $_POST['pemeriksaanlab_id'] : null);
      $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Params::RUANGAN_ID_LAB_KLINIK);
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modMasukKamar = MasukkamarT::model()->findByAttributes(array('pasienadmisi_id' => $modPendaftaran->pasienadmisi_id), 'pindahkamar_id IS NULL');

      $criteria = new CDbCriteria();
      $criteria->addCondition('pemeriksaanlab_id = ' . $pemeriksaanlab_id);
      $criteria->addCondition('kelaspelayanan_id = ' . $kelaspelayanan_id);
      // $criteria->addCondition('penjamin_id = ' . $modMasukKamar->penjamin_id);
      // $criteria->addCondition('ruangan_id = ' . $ruangan_id);
      $modTarif = TarifpemeriksaanlabruanganV::model()->find($criteria);
      echo CJSON::encode(array(
        'status' => 'create_form',
        'form' => $this->renderPartial('_formLoadPemeriksaanLab', array('modTarif' => $modTarif), true)
      ));
      exit;
    }
  }


  public function actionPrint()
  {
    $pendaftaran_id = $_GET['id'];
    $idPasienKirimKeUnitLain = $_GET['idPasienKirimKeUnitLain'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array(
        'pendaftaran_id' => $pendaftaran_id,
        'pasienkirimkeunitlain_id' => $idPasienKirimKeUnitLain
      ),
      'pasienmasukpenunjang_id IS NULL'
    );
    $modKirim = RIPasienKirimKeUnitLainT::model()->findByAttributes(
      array(
        'pendaftaran_id' => $pendaftaran_id,
        'pasienkirimkeunitlain_id' => $idPasienKirimKeUnitLain
      )
    );

    $judulLaporan = 'Permintaan Pemeriksaan Laboratorium';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'modAdmisi' => $modAdmisi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modKirim'=>$modKirim));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'modAdmisi' => $modAdmisi, 'caraPrint' => $caraPrint, 'modKirim'=>$modKirim));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'modAdmisi' => $modAdmisi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modKirim'=>$modKirim), true));
      $mpdf->Output();
    }
  }

  public function actionPrintRiwayat()
  {
    $pendaftaran_id = $_GET['id'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id=' . $pendaftaran_id);
    $modRiwayatKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array('pendaftaran_id' => $pendaftaran_id, 'instalasi_id' => Params::INSTALASI_ID_LAB),
      'pasienmasukpenunjang_id IS NULL'
    );


    $judulLaporan = 'Permintaan Pemeriksaan Laboratorium';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'modAdmisi' => $modAdmisi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'modAdmisi' => $modAdmisi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'modAdmisi' => $modAdmisi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
  /**
   * - digunakan untuk mengenerate notif batal rujukan
   * @param type $modKirimKeunitlain
   */
  protected function notifBatalRujuk($modKirimKeunitlain)
  {

    $modRuangan = RuanganM::model()->findByPk($modKirimKeunitlain['ruangan_id']);
    $pasien_id = $modKirimKeunitlain['pasien_id'];
    $modPasien = PasienM::model()->findByPk($pasien_id);
    $judul = 'Pasien Batal Rujuk Laboratorium';

    $isi = $modKirimKeunitlain['no_pendaftaran'] . ' ' . $modPasien->no_rekam_medik . ' ' . $modPasien->nama_pasien;


    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $modKirimKeunitlain['instalasi_id'], 'ruangan_id' => $modRuangan->ruangan_id, 'modul_id' => $modRuangan->modul_id),
    ));
  }

    /**
   * set checklist pemeriksaan lab
   */


  public function actionSetChecklistFormLab()
  {
    if (Yii::app()->request->isAjaxRequest) {


      $modPemeriksaanLab = new TarifpemeriksaanlabruanganV;

      $content = "";
      parse_str($_POST['data'], $post);


// echo '<pre>'; var_dump($_POST); die();

      // $modJenisPeriksaLab = RJJenisPemeriksaanLabM::model()->findAllByAttributes(array('jenispemeriksaanlab_aktif' => true), array('order' => 'jenispemeriksaanlab_urutan'));
      // $modPeriksaLab = RJPemeriksaanLabM::model()->findAllByAttributes(array('pemeriksaanlab_aktif' => true), array('order' => 'jenispemeriksaanlab_id, pemeriksaanlab_urutan'));
  


      // echo '<pre>'; var_dump(); die();
      $postPemeriksaan = $post['TarifpemeriksaanlabruanganV'];

      // tarif radiologi antar kelas sama
      $critpl = new CDbCriteria;
      $critpl->select = 't.pemeriksaanlab_id, t.pemeriksaanlab_nama, j.jenispemeriksaanlab_id,
                          r.jenisform_id,
                          r.jenisform_nama,
                          j.jenispemeriksaanlab_nama, d.daftartindakan_id, k.kelaspelayanan_id';
      $critpl->join = ' JOIN jenispemeriksaanlab_m j ON t.jenispemeriksaanlab_id = j.jenispemeriksaanlab_id
                        JOIN jenisform_m r ON r.jenisform_id = t.jenisform_id
                        JOIN daftartindakan_m d ON t.daftartindakan_id = d.daftartindakan_id
                        JOIN tariftindakan_m tt ON tt.daftartindakan_id = d.daftartindakan_id
                        JOIN kelaspelayanan_m k ON tt.kelaspelayanan_id = k.kelaspelayanan_id ';
      $critpl->group = $critpl->select;
      $critpl->order = ' t.pemeriksaanlab_id, t,pemeriksaanlab_urutan ';
  
  
      if(!empty($post['RIPendaftaranT']['kelaspelayanan_id'])) {
        $critpl->addCondition('k.kelaspelayanan_id = ' . $post['RIPendaftaranT']['kelaspelayanan_id']);
      }

      $critpl->addCondition('t.pemeriksaanlab_aktif = true');
  
      $critpl->compare('LOWER(t.pemeriksaanlab_nama)', strtolower($postPemeriksaan['pemeriksaanlab_nama']), true);
  
  
      $modPeriksaLab = RIPemeriksaanLabM::model()->findAll($critpl);

        $arr_jns = [];

        $jns_temp = 0;

        if(count($modPeriksaLab) > 0) {

          foreach($modPeriksaLab as $per) {

            if($jns_temp != $per->pemeriksaanlab_id) {

              array_push($arr_jns, $per->jenisform_id);
              array_push($arr_jns, $per->jenispemeriksaanlab_id);
              
            }

          }

        }

       $critJenis = new CdbCriteria();
      //   $critJenis->select = 't.pemeriksaanlab_id, t.pemeriksaanlab_nama, j.jenispemeriksaanlab_id,r.jenisform_id,r.jenisform_nama,
      //                     j.jenispemeriksaanlab_nama, d.daftartindakan_id, k.kelaspelayanan_id';
      // $critJenis->join = ' JOIN jenispemeriksaanlab_m j ON t.jenispemeriksaanlab_id = j.jenispemeriksaanlab_id
      //                   JOIN jenisform_m r ON r.jenisform_id = t.jenisform_id
      //                   JOIN daftartindakan_m d ON t.daftartindakan_id = d.daftartindakan_id
      //                   JOIN tariftindakan_m tt ON tt.daftartindakan_id = d.daftartindakan_id
      //                   JOIN kelaspelayanan_m k ON tt.kelaspelayanan_id = k.kelaspelayanan_id ';
      // $critJenis->group = $critpl->select;
      // $critJenis->order = ' t.pemeriksaanlab_id, t,pemeriksaanlab_urutan ';

        $critJenis->compare('LOWER(jenisform_nama)', strtolower($postPemeriksaan['jenisform_nama']), true);
        //$critJenis->compare('LOWER(jenisform_id)', strtolower($postPemeriksaan['jenisform_id']), true);
        //$critJenis->addCondition('jenispemeriksaanlab_aktif = true');


// echo '<pre>'; var_dump($arr_jns); die();

        // if(count($arr_jns) > 0) {
          $critJenis->addInCondition('jenisform_id', $arr_jns);
          //$critJenis->addInCondition('.jenisform_id', $arr_jns);
          
        // }

       // $critJenis->order = "jenispemeriksaanlab_urutan";
        $modJenisPeriksaLab = RIJenisForm::model()->findAll($critJenis);

        $modPendaftaran = new RIPendaftaranT();

        if(isset($_GET['pendaftaran_id'])) {
          $modPendaftaran = RIPendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
        }
      // echo '<pre>'; var_dump(count($modPemeriksaanlabs), $post, $criteria); die();


        $content = $this->renderPartial($this->path_view . '_checklistPemeriksaanLab',
        array('modJenisPeriksaLab' => $modJenisPeriksaLab, 'modPemeriksaanLab' => $modPemeriksaanLab,
         'modPeriksaLab' => $modPeriksaLab, 'modPendaftaran' => $modPendaftaran), true);
      echo CJSON::encode(array(
        'content' => $content
      ));
      Yii::app()->end();
    }
  }

  public function actionSetChecklistPemeriksaanLab()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $content = "";
      parse_str($_POST['data'], $post);
      $postPemeriksaan = $post['TarifpemeriksaanlabruanganV'];

      // pemeriksaanlab_nama

// echo '<pre>'; var_dump($post); die();

      // tarif radiologi antar kelas sama
      //$postPemeriksaan['kelaspelayanan_id'] = Params::KELASPELAYANAN_ID_TANPA_KELAS;

      // if ( !empty($postPemeriksaan['pemeriksaanrad_nama']) ) {
        // $modPeriksaRad = RJPemeriksaanRadM::model()->findAllByAttributes(array('pemeriksaanrad_aktif' => true), array('order' => 'jenispemeriksaanrad_id, pemeriksaanrad_urutan ASC'));

     
    // $critRad = new CDbCriteria();
    // $critRad->select = 'jenispemeriksaanlab_id, jenispemeriksaanlab_nama, pemeriksaanlab_id, pemeriksaanlab_nama, jenispemeriksaanlab_urutan, pemeriksaanlab_urutan';
    // $critRad->group = $critRad->select;
    // $critRad->order = 'jenispemeriksaanlab_urutan, pemeriksaanlab_urutan';
    // $critRad->compare('LOWER(jenispemeriksaanlab_nama)', strtolower($postPemeriksaan['jenispemeriksaanlab_nama']), true);
    // $critRad->compare('LOWER(pemeriksaanlab_nama)', strtolower($postPemeriksaan['pemeriksaanlab_nama']), true);
    // $modPeriksaRad = RITarifpemeriksaanlabruanganV::model()->findAll($critRad);
        
    // echo '<pre>'; var_dump($post); die();
    $critpl = new CDbCriteria;
    $critpl->select = 't.pemeriksaanlab_id, t.pemeriksaanlab_nama, j.jenispemeriksaanlab_id,
                        j.jenispemeriksaanlab_nama, d.daftartindakan_id, k.kelaspelayanan_id';
    $critpl->join = ' JOIN jenispemeriksaanlab_m j ON t.jenispemeriksaanlab_id = j.jenispemeriksaanlab_id
                      JOIN daftartindakan_m d ON t.daftartindakan_id = d.daftartindakan_id
                      JOIN tariftindakan_m tt ON tt.daftartindakan_id = d.daftartindakan_id
                      JOIN kelaspelayanan_m k ON tt.kelaspelayanan_id = k.kelaspelayanan_id ';
    $critpl->group = $critpl->select;
    $critpl->order = ' t.pemeriksaanlab_id, t,pemeriksaanlab_urutan ';

    $critpl->addCondition('t.pemeriksaanlab_aktif = true');

    if(!empty($post['RIPendaftaranT']['kelaspelayanan_id'])) {
      $critpl->addCondition('k.kelaspelayanan_id = ' . $post['RIPendaftaranT']['kelaspelayanan_id']);
    }

    $critpl->compare('LOWER(t.pemeriksaanlab_nama)', strtolower($postPemeriksaan['pemeriksaanlab_nama']), true);


    $modPeriksaLab = RIPemeriksaanLabM::model()->findAll($critpl);
    
    // $modPeriksaLab = RIPemeriksaanLabM::model()->findAll($critPeriksa);


    

    // var_dump(count($modPeriksaLab)); die;

    $arr_jns = [];

    $jns_temp = 0;

    if(count($modPeriksaLab) > 0) {

      foreach($modPeriksaLab as $per) {

        if($jns_temp != $per->pemeriksaanlab_id) {

          array_push($arr_jns, $per->jenispemeriksaanlab_id);
        }

      }

    }

    $critJenis = new CdbCriteria();
    $critJenis->compare('LOWER(jenispemeriksaanlab_nama)', strtolower($postPemeriksaan['jenispemeriksaanlab_nama']), true);
    $critJenis->addCondition('jenispemeriksaanlab_aktif = true');
    $critJenis->order = "jenispemeriksaanlab_urutan";


// echo '<pre>'; var_dump($arr_jns); die();

    // if(count($arr_jns) > 0) {
      $critJenis->addInCondition('jenispemeriksaanlab_id', $arr_jns);
    // }

    $modJenisPeriksaLab = RIJenisPemeriksaanLabM::model()->findAll($critJenis);
        
        // var_dump($modPemeriksaanlabs);die();
        $content = $this->renderPartial('_checklistPemeriksaanLab', array('modJenisPeriksaLab' => $modJenisPeriksaLab, 'modPeriksaLab' => $modPeriksaLab), true);
      // }
      echo CJSON::encode(array(
        'content' => $content
      ));
      Yii::app()->end();
    }
        
    // echo '<pre>'; var_dump($post); die();

        
     
  }


}
