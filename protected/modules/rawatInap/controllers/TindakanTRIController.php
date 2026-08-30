<?php

/**
 * DIEXTEND OLEH :
 * SistemAdministrator/TindakanTSAController
 */
class TindakanTRIController extends MyAuthController
{
  public $succesSave = false;
  public $successSaveBmhp = true;
  public $successSavePemakaianBahan = true;
  public $stokobatalkestersimpan = true; //looping
    protected $statusSaveKirimkeUnitLain = true;
    protected $statusSavePermintaanPenunjang = true;	
  protected $path_view = 'rawatInap.views.tindakanTRI.';
  protected $path_view_rj = 'rawatJalan.views.tindakan.';

  public function actionIndex($pendaftaran_id, $pasienadmisi_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modTindakans = array();
    $modAdmisi = (!empty($pasienadmisi_id)) ? PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id)) : array();
    $modMasukKamar = RIMasukKamarT::model()->findByAttributes(array('pasienadmisi_id' => $modAdmisi->pasienadmisi_id));
    $selisihHari = CustomFunction::hitungHari($format->formatDateTimeForDb($modMasukKamar->tglmasukkamar));
    $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modViewTindakans = RITindakanPelayananT::model()
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
      //->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'pasienadmisi_id'=>$pasienadmisi_id, 'ruangan_id'=>Yii::app()->user->getState('ruangan_id')));
      ->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));

    $modTindakan = new RITindakanPelayananT;
    $modTindakan->tarifcyto_tindakan = 0;
    $modTindakan->dokterpemeriksa1_id = $modAdmisi->pegawai_id;
    $modTindakan->dokterpemeriksa1Nama = $modAdmisi->pegawai->NamaLengkap;

    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id = ' . $modAdmisi->penjamin_id);

    if (isset($_POST['RITindakanPelayananT']) || isset($_POST['TindakanpelayananT'])) {
      // var_dump($_POST); die;
      //var_dump($_POST['RITindakanPelayananT']);die;
      $modTindakans = $this->saveTindakan($modPasien, $modPendaftaran, $modAdmisi);
      if ($this->succesSave)
        $this->refresh(); //=>TERLALU PANJANG $this->redirect(array('tindakanTRI/','pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id));
    }

    $modViewBmhp = RIObatalkespasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $modBayarUangMuka = RIBayaruangmukaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'bayaruangmuka_id DESC'));
    $modBayarUangMukas = RIBayaruangmukaT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $total = 0;
    foreach ($modBayarUangMukas as $key => $value) {
      $total += $modBayarUangMukas[$key]->jumlahuangmuka;
    }
    $modDeposit = (($modBayarUangMukas) ? $total : null);
    $this->render($this->path_view.'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modTindakans' => $modTindakans,
      'modTindakan' => $modTindakan,
      'modViewTindakans' => $modViewTindakans,
      'modViewBmhp' => $modViewBmhp,
      'modAdmisi' => $modAdmisi,
      'modJenisTarif' => $modJenisTarif,
      'modDeposit' => $modDeposit,
      'modBayarUangMuka' => $modBayarUangMuka
    ));
  }

  public function saveTindakan($modPasien, $modPendaftaran, $modAdmisi)
  {
    $post = isset($_POST['TindakanpelayananT']) ? $_POST['TindakanpelayananT'] : $_POST['RITindakanPelayananT'];
    $valid = true;
    $modTindakans = array();
    foreach ($post as $i => $item) {
      if (!empty($item) && (!empty($item['daftartindakan_id']))) {
        $modTindakans[$i] = new RITindakanPelayananT;
        $modTindakans[$i]->attributes = $item;
        $modTindakans[$i]->tipepaket_id = $_POST['RITindakanPelayananT'][0]['tipepaket_id'];
        $modTindakans[$i]->pasien_id = $modPasien->pasien_id;
        $modTindakans[$i]->pasienadmisi_id = $modAdmisi->pasienadmisi_id;
        $modTindakans[$i]->kelaspelayanan_id = $modAdmisi->kelaspelayanan_id;
        $modTindakans[$i]->carabayar_id = $modPendaftaran->carabayar_id;
        $modTindakans[$i]->penjamin_id = $modPendaftaran->penjamin_id;
        $modTindakans[$i]->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
        $modTindakans[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modTindakans[$i]->keterangantindakan = isset($item['keterangantindakan']) ? $item['keterangantindakan'] : '';
        // $modTindakans[$i]->tgl_tindakan = $item['tgl_tindakan'];
        $modTindakans[$i]->tgl_tindakan = $modTindakans[0]->tgl_tindakan;
        $modTindakans[$i]->shift_id = Yii::app()->user->getState('shift_id');
        if ($modTindakans[$i]->tipepaket_id == Params::TIPEPAKET_ID_NONPAKET) {
            // $modTindakans[$i]->tarif_satuan = $modTindakans[$i]->getTarifSatuan(); //RND-7250
        }
        $modTindakans[$i]->tarif_tindakan = $modTindakans[$i]->tarif_tindakan ?? $modTindakans[$i]->tarif_satuan * $modTindakans[$i]->qty_tindakan;
        // if ($item['cyto_tindakan'])
        //   $modTindakans[$i]->tarifcyto_tindakan = ($item['persenCyto'] / 100) * $modTindakans[$i]->tarif_tindakan;
        // else
        //   $modTindakans[$i]->tarifcyto_tindakan = 0;
        $modTindakans[$i]->discount_tindakan = 0;
        // $modTindakans[$i]->subsidiasuransi_tindakan = 0;
        // $modTindakans[$i]->subsidipemerintah_tindakan = 0;
        // $modTindakans[$i]->subsisidirumahsakit_tindakan = 0;
        // $modTindakans[$i]->iurbiaya_tindakan = 0;
        $modTindakans[$i]->ruangan_id = isset($item['ruangan_id']) ? $item['ruangan_id'] : Yii::app()->user->getState('ruangan_id'); 
        $modTindakans[$i]->instalasi_id = $modTindakans[$i]->ruangan->instalasi_id;
        $modTindakans[$i]->alatmedis_id = $this->cekAlatmedis($modTindakans[$i]->daftartindakan_id);

        $valid = $modTindakans[$i]->validate() && $valid;
      }
    }

    $transaction = Yii::app()->db->beginTransaction();
    try {
      if ($valid && (count((array)$modTindakans) > 0)) {
        foreach ($modTindakans as $i => $tindakan) {
          if ($tindakan->save()) {
            var_dump($tindakan->ruangan_id);
            if ($tindakan->ruangan_id == Params::RUANGAN_ID_BEDAH || $tindakan->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK || $tindakan->ruangan_id == Params::RUANGAN_ID_RAD){
                $this->simpanPasienKirimKeUnitLain($tindakan);
            }
              
            $statusSaveKomponen = $tindakan->saveTindakanKomponen();
          }
          if (isset($_POST['paketBmhp'])) {
            if (count((array)$_POST['paketBmhp']) > 0) {
              //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
              $detailGroups = array();
              foreach ($_POST['paketBmhp'] as $j => $postDetail) {

                $modDetails[$i] = new RIObatalkespasienT;
                $modDetails[$i]->attributes = $postDetail;
                $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
                $modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
                $obatalkes_id = $postDetail['obatalkes_id'];
                if (isset($detailGroups[$obatalkes_id])) {
                  $detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qtypemakaian'];
                } else {
                  $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
                  $detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qtypemakaian'];
                }
              }
              //END GROUP
            }

            $obathabis = "";
            //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
            foreach ($detailGroups as $i => $detail) {
              $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
              if (count((array)$modStokOAs) > 0) {
                foreach ($modStokOAs as $i => $stok) {
                  $modDetails[$i] = $this->savePaketBmhp($modPendaftaran, $stok, $_POST['paketBmhp'], $tindakan);
                  $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
                }
              } else {
                $this->stokobatalkestersimpan &= false;
                $obathabis .= "<br>- " . ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
              }
            }
            //                            $modObatPasiens = $this->savePaketBmhp($modPendaftaran, $_POST['paketBmhp'],$tindakan);
          }

          if (isset($_POST['pemakaianBahan'])) {
            if (count((array)$_POST['pemakaianBahan']) > 0) {
              //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
              $detailGroups = array();
              foreach ($_POST['pemakaianBahan'] as $k => $postDetail) {
                $modDetails[$i] = new RIObatalkespasienT;
                $modDetails[$i]->attributes = $postDetail;
                $modDetails[$i] = $this->savePemakaianBahan2($modPendaftaran, $postDetail, $tindakan);
                $this->simpanStokObatAlkesOut2($modDetails[$i]);
                /*$modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
                                    $modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
                                    $obatalkes_id = $postDetail['obatalkes_id'];
                                    if(isset($detailGroups[$obatalkes_id])){
                                        $detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty'];
                                    }else{
                                        $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
                                        $detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty'];
                                    } */
              }
              //END GROUP
            }
            /*
                            $obathabis = "";
                            //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
                            foreach($detailGroups AS $l => $detail){
                                $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
                                if(count((array)$modStokOAs) > 0){
                                    foreach($modStokOAs AS $l => $stok){
                                        $modDetails[$i] = $this->savePemakaianBahan($modPendaftaran, $stok, $_POST['pemakaianBahan'],$tindakan);
                                        $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
                                    }
                                }else{
                                    $this->stokobatalkestersimpan &= false;
                                    $obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;

                                }
                            } */
            //                            $modPemakainBahans = $this->savePemakaianBahan($modPendaftaran, $_POST['pemakaianBahan'],$tindakan);
          }
        }

        if ($this->statusSavePermintaanPenunjang && $this->statusSaveKirimkeUnitLain && $statusSaveKomponen && $this->successSaveBmhp && $this->successSavePemakaianBahan && $this->stokobatalkestersimpan) {
//          echo "OK"; die;
          $transaction->commit();
          $this->succesSave = true;
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data tidak valid ");
          //Yii::app()->user->setFlash('error',"Data tidak valid ".$this->traceObatAlkesPasien($modPemakainBahans));
        }
      } else {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data tidak valid ");
        //Yii::app()->user->setFlash('error',"Data tidak valid ".$this->traceTindakan($modTindakans));
      }
    } catch (Exception $exc) {
      $transaction->rollback();
      Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
    }

    return $modTindakans;
  }
  
  /**
    * method untuk menyimpan data pasien ke unit lain RJPasienKirimkeUnitLainT
    * digunakan di :
    * 1. rawatJalan/laboratorium/index
    * @param object $modPendaftaran model PendaftaranT
    * @return \RJPasienKirimKeUnitLainT 
    */
   protected function simpanPasienKirimKeUnitLain($tindakan)
   {
       $modKirimKeUnitLain = new RIPasienKirimKeUnitLainT;
       $modKirimKeUnitLain->attributes = $tindakan->attributes;
       $modKirimKeUnitLain->pasien_id = $tindakan->pasien_id;
       $modKirimKeUnitLain->pendaftaran_id = $tindakan->pendaftaran_id;
       $modKirimKeUnitLain->instalasi_id = $tindakan->ruangan->instalasi_id;
       $modKirimKeUnitLain->ruangan_id = $tindakan->ruangan_id;     
       $modKirimKeUnitLain->pegawai_id = $tindakan->dokterpemeriksa1_id;
       $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($tindakan->tgl_tindakan);
       $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
       $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
       $modKirimKeUnitLain->create_ruangan = Yii::app()->user->getState('ruangan_id');
       $modKirimKeUnitLain->create_time = date( 'Y-m-d H:i:s');
       $modKirimKeUnitLain->update_time = date( 'Y-m-d H:i:s');
       $modKirimKeUnitLain->isbayarkekasirpenunjang = 0;
       $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);

       $this->statusSaveKirimkeUnitLain &= $modKirimKeUnitLain->save();
       $this->savePermintaanPenunjang($tindakan, $modKirimKeUnitLain);
   }

   /**
    * method untuk menyimpan dan validasi permintaan penunjang
    * digunakan di :
    * 1. rawatJalan/laboratorium/index
    * @param array $permintaan berupa post request berisi data permintaan penunjang
    * @param object $modKirimKeUnitLain model PasienkirimkeunitlainT
    */
   protected function savePermintaanPenunjang($tindakan,$modKirimKeUnitLain)
   {

        $modPermintaan = new RIPermintaanPenunjangT();
        $modPermintaan->daftartindakan_id = $tindakan->daftartindakan_id;
        if ($tindakan->ruangan_id == Params::RUANGAN_ID_BEDAH){
            $modPermintaan->operasi_id = $modPermintaan->loadPemeriksaanOperasi();
        }elseif($tindakan->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK){
            $modPermintaan->pemeriksaanlab_id = $modPermintaan->loadPemeriksaanLab();
        }elseif($tindakan->ruangan_id == Params::RUANGAN_ID_RAD){
            $modPermintaan->pemeriksaanrad_id = $modPermintaan->loadPemeriksaanRad();
        }
        $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
        $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PL');
        $modPermintaan->qtypermintaan = $tindakan->qty_tindakan;
        $modPermintaan->tarif_pelayananan = $tindakan->tarif_satuan;
        $modPermintaan->tglpermintaankepenunjang = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
        $modPermintaan->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;

        $this->statusSavePermintaanPenunjang &= $modPermintaan->save();
   }

  public function cekAlatmedis($idDaftartindakan)
  {
    $idAlatmedis = null;
    if (!empty($_POST['pemakaianAlat'])) {
      foreach ($_POST['pemakaianAlat'] as $k => $item) {
        if ($item['daftartindakan_id'] == $idDaftartindakan) {
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

        $data['success'] = true;
        $data['pesan'] = "berhasil";
        $modTindakanPelayanan = RITindakanPelayananT::model()->findByPk($idTindakanpelayanan);
        $obatAlkesT = RIObatalkespasienT::model()->findAllByAttributes(
          array('tindakanpelayanan_id' => $idTindakanpelayanan)
        );
        if (count((array)$obatAlkesT) > 0) {
          $this->kembalikanStok($obatAlkesT);
          $deleteObatPasien = RIObatalkespasienT::model()->deleteAllByAttributes(
            array('tindakanpelayanan_id' => $idTindakanpelayanan)
          );
          $deleteKomponen = RITindakanKomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $idTindakanpelayanan));
          $deleteTindakan = RITindakanPelayananT::model()->deleteByPk($idTindakanpelayanan);
          if (!$deleteObatPasien) {
            $data['success'] = false;
          }
        } else {
          $deleteKomponen = RITindakanKomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $idTindakanpelayanan));
          $deleteTindakan = RITindakanPelayananT::model()->deleteByPk($idTindakanpelayanan);
        }

        if (!empty($modTindakanPelayanan->tindakansudahbayar_id) && !empty($obatAlkesT->oasudahbayar_id)) {
          $data['success'] = false;
          $data['pesan'] = "gagal";
        } else {
          if ($deleteTindakan && $data['success']) {
            $data['success'] = true;
            $transaction->commit();
          } else {
            $data['success'] = false;
            $transaction->rollback();
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        print_r(MyExceptionMessage::getMessage($exc, true));
        $data['success'] = false;
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function savePaketBmhp($modPendaftaran, $stokOa, $postPaketBmhp, $tindakan)
  {
    $valid = true;
    $format = new MyFormatter;
    $modObatPasien = new RIObatalkespasienT;
    $modObatPasien->attributes = $stokOa->attributes;
    $modObatPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modObatPasien->penjamin_id = $modPendaftaran->penjamin_id;
    $modObatPasien->carabayar_id = $modPendaftaran->carabayar_id;
    $modObatPasien->pasien_id = $modPendaftaran->pasien_id;
    $modObatPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modObatPasien->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
    $modObatPasien->tipepaket_id = $tindakan->tipepaket_id;
    $modObatPasien->pegawai_id = $modPendaftaran->pegawai_id;
    $modObatPasien->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modObatPasien->shift_id = Yii::app()->user->getState('shift_id');
    $modObatPasien->tglpelayanan = date('Y-m-d H:i:s');
    $modObatPasien->qty_oa = $stokOa->qtystok_terpakai;
    $modObatPasien->harganetto_oa = $stokOa->HPP;
    $modObatPasien->hargasatuan_oa = $stokOa->HargaJualSatuan;
    $modObatPasien->hargajual_oa = $modObatPasien->hargasatuan_oa * $modObatPasien->qty_oa;

    foreach ($postPaketBmhp as $i => $postDetail) {
      if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
        $modObatPasien->daftartindakan_id = $postDetail['daftartindakan_id'];
        $modObatPasien->sumberdana_id = $postDetail['sumberdana_id'];
        $modObatPasien->satuankecil_id = $postDetail['satuankecil_id'];
        $modObatPasien->obatalkes_id = $postDetail['obatalkes_id'];
      }
    }

    $valid = $modObatPasien->validate() && $valid;
    if ($valid) {
      $modObatPasien->save();
      $this->successSaveBmhp &= true;
    } else {
      $this->successSaveBmhp &= false;
    }

    /**
     * old
     */
    //            $modObatPasien = array();
    //            foreach ($paketBmhp as $i => $bmhp) {
    //                if($tindakan->daftartindakan_id == $bmhp['daftartindakan_id']){
    //                    $modObatPasien[$i] = new RIObatalkespasienT;
    //                    $modObatPasien[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    //                    $modObatPasien[$i]->penjamin_id = $modPendaftaran->penjamin_id;
    //                    $modObatPasien[$i]->carabayar_id = $modPendaftaran->carabayar_id;
    //                    $modObatPasien[$i]->daftartindakan_id = $bmhp['daftartindakan_id'];
    //                    $modObatPasien[$i]->sumberdana_id = $bmhp['sumberdana_id'];
    //                    $modObatPasien[$i]->pasien_id = $modPendaftaran->pasien_id;
    //                    $modObatPasien[$i]->satuankecil_id = $bmhp['satuankecil_id'];
    //                    $modObatPasien[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
    //                    $modObatPasien[$i]->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
    //                    $modObatPasien[$i]->tipepaket_id = $tindakan->tipepaket_id;
    //                    $modObatPasien[$i]->obatalkes_id = $bmhp['obatalkes_id'];
    //                    $modObatPasien[$i]->pegawai_id = $modPendaftaran->pegawai_id;
    //                    $modObatPasien[$i]->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    //                    $modObatPasien[$i]->shift_id = Yii::app()->user->getState('shift_id');
    //                    $modObatPasien[$i]->tglpelayanan = date('Y-m-d H:i:s');
    //                    $modObatPasien[$i]->qty_oa = $bmhp['qtypemakaian'];
    //                    $modObatPasien[$i]->hargajual_oa = $bmhp['hargapemakaian'];
    //                    $modObatPasien[$i]->harganetto_oa = $bmhp['harganetto'];
    //                    $modObatPasien[$i]->hargasatuan_oa = $bmhp['hargasatuan'];
    //
    //                    $valid = $modObatPasien[$i]->validate() && $valid;
    //                    if($valid) {
    //                        $modObatPasien[$i]->save();
    //                        StokobatalkesT::kurangiStok($modObatPasien[$i]->qty_oa, $modObatPasien[$i]->obatalkes_id);
    //                        $this->successSaveBmhp = true;
    //                    } else {
    //                        $this->successSaveBmhp = false;
    //                    }
    //                }
    //            }

    return $modObatPasien;
  }


  public function savePemakaianBahan2($modPendaftaran, $postPemakaianBahan, $tindakan)
  {
    $valid = true;
    $format = new MyFormatter;
    $modPakaiBahan = new RIObatalkespasienT;
    $modPakaiBahan->attributes = $postPemakaianBahan;
    $modPakaiBahan->qty_oa = $postPemakaianBahan['qty'];
    $modPakaiBahan->tglpelayanan = date("Y-m-d H:i:s");
    $modPakaiBahan->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    $modPakaiBahan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPakaiBahan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modPakaiBahan->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
    $modPakaiBahan->carabayar_id = $modPendaftaran->carabayar_id;
    $modPakaiBahan->penjamin_id = $modPendaftaran->penjamin_id;
    $modPakaiBahan->pegawai_id = $modPendaftaran->pegawai_id;
    $modPakaiBahan->shift_id = Yii::app()->user->getState('shift_id');
    $modPakaiBahan->pasien_id = $modPendaftaran->pasien_id;
    $modPakaiBahan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modPakaiBahan->tglpelayanan = date('Y-m-d H:i:s');
    $modPakaiBahan->create_loginpemakai_id = Yii::app()->user->id;
    $modPakaiBahan->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modPakaiBahan->create_time = date('Y-m-d H:i:s');



    //$modPakaiBahan->qty_oa = $stokOa->qtystok_terpakai;
    $modPakaiBahan->harganetto_oa = $postPemakaianBahan['harganetto'];
    $modPakaiBahan->hargasatuan_oa = $postPemakaianBahan['hargasatuan'];
    $modPakaiBahan->hargajual_oa = $modPakaiBahan->hargasatuan_oa * $modPakaiBahan->qty_oa;
    $modPakaiBahan->oa = Params::OBATALKESPASIEN_BMHP;

    //var_dump($postPemakaianBahan);
    //var_dump($modPakaiBahan->attributes); die;

    // foreach ($postPemakaianBahan AS $i => $postDetail) {
    //    if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
    $modPakaiBahan->daftartindakan_id = $postPemakaianBahan['daftartindakan_id'];
    $modPakaiBahan->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
    $modPakaiBahan->sumberdana_id = $postPemakaianBahan['sumberdana_id'];
    $modPakaiBahan->satuankecil_id = $postPemakaianBahan['satuankecil_id'];
    $modPakaiBahan->obatalkes_id = $postPemakaianBahan['obatalkes_id'];
    //$modPakaiBahan->qty_stok = $postPemakaianBahan['qty_stok'];
    $modPakaiBahan->iurbiaya = $postPemakaianBahan['subtotal'];
    $modPakaiBahan->pasienadmisi_id = $_GET['pasienadmisi_id'];
    //    }
    //}
    //var_dump($modPakaiBahan->validate()); die;
    $valid = $modPakaiBahan->validate() && $valid;
    if ($valid) {
      $modPakaiBahan->save();
      $this->successSavePemakaianBahan &= true;
    } else {
      $this->successSavePemakaianBahan &= false;
    }

    //          old
    //              $valid = true;
    //            $modPakaiBahan = array();
    //            foreach ($pemakaianBahan as $i => $bmhp) {
    //                if($tindakan->daftartindakan_id == $bmhp['daftartindakan_id']){
    //                    $modPakaiBahan[$i] = new RIObatalkespasienT;
    //                    $modPakaiBahan[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    //                    $modPakaiBahan[$i]->penjamin_id = $modPendaftaran->penjamin_id;
    //                    $modPakaiBahan[$i]->carabayar_id = $modPendaftaran->carabayar_id;
    //                    $modPakaiBahan[$i]->daftartindakan_id = $bmhp['daftartindakan_id'];
    //                    $modPakaiBahan[$i]->sumberdana_id = $bmhp['sumberdana_id'];
    //                    $modPakaiBahan[$i]->pasien_id = $modPendaftaran->pasien_id;
    //                    $modPakaiBahan[$i]->satuankecil_id = $bmhp['satuankecil_id'];
    //                    $modPakaiBahan[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
    //                    $modPakaiBahan[$i]->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
    //                    $modPakaiBahan[$i]->tipepaket_id = $tindakan->tipepaket_id;
    //                    $modPakaiBahan[$i]->obatalkes_id = $bmhp['obatalkes_id'];
    //                    $modPakaiBahan[$i]->pegawai_id = $modPendaftaran->pegawai_id;
    //                    $modPakaiBahan[$i]->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    //                    $modPakaiBahan[$i]->shift_id = Yii::app()->user->getState('shift_id');
    //                    $modPakaiBahan[$i]->tglpelayanan = date('Y-m-d H:i:s');
    //                    $modPakaiBahan[$i]->qty_oa = $bmhp['qty'];
    //                    $modPakaiBahan[$i]->hargajual_oa = $bmhp['subtotal'];
    //                    $modPakaiBahan[$i]->harganetto_oa = $bmhp['harganetto'];
    //                    $modPakaiBahan[$i]->hargasatuan_oa = $bmhp['hargasatuan'];
    //
    //                    $valid = $modPakaiBahan[$i]->validate() && $valid;
    //                    if($valid) {
    //                        $modPakaiBahan[$i]->save();
    //                        StokobatalkesT::kurangiStok($modPakaiBahan[$i]->qty_oa, $modPakaiBahan[$i]->obatalkes_id);
    //                        $this->successSavePemakaianBahan = true;
    //                    } else {
    //                        $this->successSavePemakaianBahan = false;
    //                    }
    //                }
    //            }

    return $modPakaiBahan;
  }

  public function savePemakaianBahan($modPendaftaran, $stokOa, $postPemakaianBahan, $tindakan)
  {
    $valid = true;
    $format = new MyFormatter;
    $modPakaiBahan = new RIObatalkespasienT;
    $modPakaiBahan->attributes = $stokOa->attributes;
    $modPakaiBahan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modPakaiBahan->penjamin_id = $modPendaftaran->penjamin_id;
    $modPakaiBahan->carabayar_id = $modPendaftaran->carabayar_id;
    $modPakaiBahan->pasien_id = $modPendaftaran->pasien_id;
    $modPakaiBahan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPakaiBahan->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
    $modPakaiBahan->tipepaket_id = $tindakan->tipepaket_id;
    $modPakaiBahan->pegawai_id = $modPendaftaran->pegawai_id;
    $modPakaiBahan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modPakaiBahan->shift_id = Yii::app()->user->getState('shift_id');
    $modPakaiBahan->tglpelayanan = date('Y-m-d H:i:s');
    $modPakaiBahan->qty_oa = $stokOa->qtystok_terpakai;
    $modPakaiBahan->harganetto_oa = $stokOa->HPP;
    $modPakaiBahan->hargasatuan_oa = $stokOa->HargaJualSatuan;
    $modPakaiBahan->hargajual_oa = $modPakaiBahan->hargasatuan_oa * $modPakaiBahan->qty_oa;
    $modPakaiBahan->oa = Params::OBATALKESPASIEN_BMHP;

    foreach ($postPemakaianBahan as $i => $postDetail) {
      if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
        $modPakaiBahan->daftartindakan_id = $postDetail['daftartindakan_id'];
        $modPakaiBahan->sumberdana_id = $postDetail['sumberdana_id'];
        $modPakaiBahan->satuankecil_id = $postDetail['satuankecil_id'];
        $modPakaiBahan->obatalkes_id = $postDetail['obatalkes_id'];
        $modPakaiBahan->pasienadmisi_id = $_GET['pasienadmisi_id'];
      }
    }

    $valid = $modPakaiBahan->validate() && $valid;
    if ($valid) {
      $modPakaiBahan->save();
      $this->successSavePemakaianBahan &= true;
    } else {
      $this->successSavePemakaianBahan &= false;
    }

    //          old
    //              $valid = true;
    //            $modPakaiBahan = array();
    //            foreach ($pemakaianBahan as $i => $bmhp) {
    //                if($tindakan->daftartindakan_id == $bmhp['daftartindakan_id']){
    //                    $modPakaiBahan[$i] = new RIObatalkespasienT;
    //                    $modPakaiBahan[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    //                    $modPakaiBahan[$i]->penjamin_id = $modPendaftaran->penjamin_id;
    //                    $modPakaiBahan[$i]->carabayar_id = $modPendaftaran->carabayar_id;
    //                    $modPakaiBahan[$i]->daftartindakan_id = $bmhp['daftartindakan_id'];
    //                    $modPakaiBahan[$i]->sumberdana_id = $bmhp['sumberdana_id'];
    //                    $modPakaiBahan[$i]->pasien_id = $modPendaftaran->pasien_id;
    //                    $modPakaiBahan[$i]->satuankecil_id = $bmhp['satuankecil_id'];
    //                    $modPakaiBahan[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
    //                    $modPakaiBahan[$i]->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
    //                    $modPakaiBahan[$i]->tipepaket_id = $tindakan->tipepaket_id;
    //                    $modPakaiBahan[$i]->obatalkes_id = $bmhp['obatalkes_id'];
    //                    $modPakaiBahan[$i]->pegawai_id = $modPendaftaran->pegawai_id;
    //                    $modPakaiBahan[$i]->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    //                    $modPakaiBahan[$i]->shift_id = Yii::app()->user->getState('shift_id');
    //                    $modPakaiBahan[$i]->tglpelayanan = date('Y-m-d H:i:s');
    //                    $modPakaiBahan[$i]->qty_oa = $bmhp['qty'];
    //                    $modPakaiBahan[$i]->hargajual_oa = $bmhp['subtotal'];
    //                    $modPakaiBahan[$i]->harganetto_oa = $bmhp['harganetto'];
    //                    $modPakaiBahan[$i]->hargasatuan_oa = $bmhp['hargasatuan'];
    //
    //                    $valid = $modPakaiBahan[$i]->validate() && $valid;
    //                    if($valid) {
    //                        $modPakaiBahan[$i]->save();
    //                        StokobatalkesT::kurangiStok($modPakaiBahan[$i]->qty_oa, $modPakaiBahan[$i]->obatalkes_id);
    //                        $this->successSavePemakaianBahan = true;
    //                    } else {
    //                        $this->successSavePemakaianBahan = false;
    //                    }
    //                }
    //            }

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
  public function saveObatAlkesKomponen($modObatPasien)
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
  public function kembalikanStok($obatAlkesT)
  {
    foreach ($obatAlkesT as $i => $obatAlkes) {
      $stok = new RIStokObatalkesT;
      $stok->obatalkes_id = $obatAlkes->obatalkes_id;
      $stok->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $stok->tglstok_in = date('Y-m-d H:i:s');
      $stok->tglstok_out = date('Y-m-d H:i:s');
      $stok->qtystok_in = $obatAlkes->qty_oa;
      $stok->qtystok_out = 0;
      $stok->harganetto = $obatAlkes->harganetto_oa;
      $stok->satuankecil_id = $obatAlkes->satuankecil_id;
      $stok->save();
    }
  }

  protected function kembalikanStok2($obatAlkesT)
  {
    foreach ($obatAlkesT as $i => $obatAlkes) {
      StokobatalkesT::model()->deleteAllByAttributes(array(
        'obatalkespasien_id' => $obatAlkes->obatalkespasien_id
      ));
    }
  }

  /**
   * UNTUK LOAD PAKET BMHP
   */
  public function actionAddFormPaketBmhp()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $form = "";
      $pesan = "";
      $status = true;
      $format = new MyFormatter();
      $modObatAlkesPasien = new RIObatalkespasienT;

      $kelompokumur_id = (isset($_POST['kelompokumur_id']) ? $_POST['kelompokumur_id'] : null);
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : null);

      $modPaketBmhp = PaketbmhpM::model()->with('daftartindakan', 'obatalkes')->findAllByAttributes(array('daftartindakan_id' => $daftartindakan_id));
      //                $modPaketBmhp = PaketbmhpM::model()->with('daftartindakan','obatalkes')->findAllByAttributes(array('daftartindakan_id'=>$daftartindakan_id,'kelompokumur_id'=>$kelompokumur_id));
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      if (count((array)$modPaketBmhp) > 0) {
        foreach ($modPaketBmhp as $i => $paket) {
          $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($paket->obatalkes_id, $paket->qtypemakaian, $ruangan_id);
          if (count((array)$modStokOAs) > 0) {
            foreach ($modStokOAs as $b => $stok) {
              $modObatAlkesPasien->sumberdana_id = (isset($stok->obatalkes->sumberdana_id) ? $stok->obatalkes->sumberdana_id : '');
              $modObatAlkesPasien->daftartindakan_id = $paket->daftartindakan_id;
              $modObatAlkesPasien->obatalkes_id = $stok->obatalkes_id;
              $modObatAlkesPasien->stokobatalkes_id = $stok->stokobatalkes_id;
              $modObatAlkesPasien->daftartindakan_id = $paket->daftartindakan_id;
              $modObatAlkesPasien->pendaftaran_id = $pendaftaran_id;
              $modObatAlkesPasien->hargapemakaian = $paket->hargapemakaian;
              $modObatAlkesPasien->harganetto_oa = $stok->HPP;
              $modObatAlkesPasien->hargasatuan_oa = $stok->HargaJualSatuan;
              $modObatAlkesPasien->qtypemakaian = $stok->qtystok_terpakai;
              $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qtypemakaian * $modObatAlkesPasien->hargasatuan_oa;
              $modObatAlkesPasien->satuankecil_id = $stok->satuankecil_id;
              $modObatAlkesPasien->daftartindakan_nama = $paket->daftartindakan->daftartindakan_nama;
              $modObatAlkesPasien->obatalkes_nama = $stok->obatalkes->obatalkes_nama;

              $form .= $this->renderPartial($this->path_view.'_formAddPaketBmhp', array('modPaketBmhp' => $modPaketBmhp, 'modPendaftaran' => $modPendaftaran, 'modObatAlkesPasien' => $modObatAlkesPasien), true);
            }
          } else {
            $pesan = "Stok tidak mencukupi!";
          }
        }
      } else {
        $status = false;
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan, 'status' => $status));
      Yii::app()->end();
    }
  }

  /**
   * UNTUK LOAD PEMAKAIAN BAHAN
   */
  public function actionAddFormPemakaianBahan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $form = "";
      $pesan = "";

      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $obatalkes_id = (isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null);
      $daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : "");
      $jumlah = (isset($_POST['qty_oa']) ? $_POST['qty_oa'] : 1);

      $modObatAlkes = ObatalkesM::model()->findByPk($obatalkes_id);
      $modDaftartindakan = DaftartindakanM::model()->findByPk($daftartindakan_id);
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

      $modObatAlkesPasien = new RIObatalkespasienT;

      $persenjual = $this->persenJualRuangan();
      $modObatAlkes->hargajual = floor(($persenjual + 100) / 100 * $modObatAlkes->hargajual);


      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      //$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($modObatAlkes->obatalkes_id, $jumlah, $ruangan_id);
      //    if(count((array)$modStokOAs) > 0){
      //        foreach($modStokOAs AS $b => $stok){
      $modObatAlkesPasien->sumberdana_id = $modObatAlkes->sumberdana_id; //(isset($stok->obatalkes->sumberdana_id) ? $stok->obatalkes->sumberdana_id : '');
      $modObatAlkesPasien->daftartindakan_id = $modDaftartindakan->daftartindakan_id;
      $modObatAlkesPasien->obatalkes_id = $modObatAlkes->obatalkes_id; //$stok->obatalkes_id;
      $modObatAlkesPasien->stokobatalkes_id = null; //$stok->stokobatalkes_id;
      $modObatAlkesPasien->pendaftaran_id = $pendaftaran_id;
      $modObatAlkesPasien->harganetto_oa = $modObatAlkes->harganetto; //$stok->HPP;
      $modObatAlkesPasien->hargasatuan_oa = $modObatAlkes->hargajual; //$stok->HargaJualSatuan;
      $modObatAlkesPasien->qty_oa = $jumlah; //$stok->qtystok_terpakai;
      $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qtypemakaian * $modObatAlkesPasien->hargasatuan_oa;
      $modObatAlkesPasien->satuankecil_id = $modObatAlkes->satuankecil_id; //$stok->satuankecil_id;
      $modObatAlkesPasien->obatalkes_nama = $modObatAlkes->obatalkes_nama; //$stok->obatalkes->obatalkes_nama;

      $form .= $this->renderPartial($this->path_view.'_formAddPemakaianBahan', array('modObatAlkesPasien' => $modObatAlkesPasien, 'modDaftartindakan' => $modDaftartindakan, 'modPendaftaran' => $modPendaftaran), true);
      //        }
      //    }else{
      //        $pesan = "Stok tidak mencukupi!";
      //    }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  /**
   * UNTUK LOAD PEMAKAIAN ALAT
   */
  public function actionAddFormPemakaianAlat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $alatmedis_id = isset($_POST['alatmedis_id']) ? $_POST['alatmedis_id'] : null;
      $daftartindakan_id = isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : null;
      $modAlat = AlatmedisM::model()->findByPk($alatmedis_id);
      $modDaftartindakan = DaftartindakanM::model()->findByPk($daftartindakan_id);
      $modObatAlkes = new ObatalkesM;
      echo CJSON::encode(array(
        'daftarTinNama' => $modDaftartindakan->daftartindakan_nama,
        'namaAlat' => $modAlat->alatmedis_nama,
        'form' => $this->renderPartial($this->path_view.'_formAddPemakaianAlat', array(
          'modAlat' => $modAlat, 'modDaftartindakan' => $modDaftartindakan, 'modObatAlkes' => $modObatAlkes
        ), true),
      ));
      exit;
    }
  }

  /**
   * UNTUK LOAD FORM TINDAKAN PAKET
   */
  public function actionLoadFormTindakanPaket()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $tipepaket_id = (isset($_POST['tipepaket_id']) ? $_POST['tipepaket_id'] : null);
      $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
      $kelompokumur_id = (isset($_POST['kelompokumur_id']) ? $_POST['kelompokumur_id'] : null);
      $carabayar_id = isset($_POST['carabayar_id']) ? $_POST['carabayar_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id'])?$_POST['pendaftaran_id']:null;

        $daftar = null;
        $peg = null;

        if (!empty($pendaftaran_id)) {
            $daftar = PendaftaranT::model()->findByPk($pendaftaran_id);
            if (!empty($daftar)) {
                $admisi = PasienadmisiT::model()->findByPk($daftar->pasienadmisi_id);
                $peg = PegawaiM::model()->findByPk($admisi->pegawai_id);
            }
          }
      
      $modPaketTindakan = PaketpelayananV::model()->findAllByAttributes(array('tipepaket_id' => $tipepaket_id));
      $modTindakans = array();
      $optionDaftarttindakan = '';
      if (isset($modPaketTindakan)) {
        if ($tipepaket_id != Params::TIPEPAKET_ID_LUARPAKET) {
          foreach ($modPaketTindakan as $i => $tindakan) {

            $modTindakans[$i] = new RITindakanPelayananT;
            $modTindakans[$i]->daftartindakan_id = $tindakan->daftartindakan_id;
            $modTindakans[$i]->daftartindakanNama = $tindakan->daftartindakan_nama;
            $modTindakans[$i]->kategoriTindakanNama = $tindakan->kategoritindakan_nama;
            $modTindakans[$i]->qty_tindakan = 1;
            $modTindakans[$i]->persenCyto = 0;
            $modTindakans[$i]->dokterpemeriksa1_id = empty($daftar) ? null : $daftar->pegawai_id;
            $modTindakans[$i]->dokterpemeriksa1Nama = empty($peg) ? null : $peg->namaLengkap;
            //                    $modTindakans[$i]->tarif_satuan = $tindakan->tarifpaketpel;
            $modTindakans[$i]->tarif_satuan = $tindakan->tarifpaketpel;
            $modTindakans[$i]->jumlahTarif = $modTindakans[$i]->qty_tindakan * $modTindakans[$i]->tarif_satuan;
            $modTindakans[$i]->subsidiasuransi_tindakan = 0;
            $modTindakans[$i]->subsidipemerintah_tindakan = 0;
            $modTindakans[$i]->subsisidirumahsakit_tindakan = 0;
            $modTindakans[$i]->iurbiaya_tindakan = 0; //$tindakan->iurbiaya;
            $modTindakans[$i]->ruangan_id = empty($tindakan->ruangan_id) ? Yii::app()->user->getState('ruangan_id') : $tindakan->ruangan_id;


            //buat option daftartindakanPemakaianBahan
            $optionDaftarttindakan .= CHtml::tag('option', array('value' => $modTindakans[$i]->daftartindakan_id), $modTindakans[$i]->daftartindakanNama, true);
          }
        }
      }

      // ambil data untuk paket BMHP
      $totHargaBmhp = 0;
      $criteria = new CDbCriteria();
      if (!empty($tipepaket_id)) {
        $criteria->addCondition("tipepaket_id = " . $tipepaket_id);
      }
      if (!empty($kelompokumur_id)) {
        $criteria->addCondition("kelompokumur_id = " . $kelompokumur_id);
      }
      $criteria->with = array('obatalkes', 'daftartindakan');
      $modPaketBmhp = PaketbmhpM::model()->findAll($criteria);
      //            $modPaketBmhp = PaketbmhpM::model()->with('obatalkes','daftartindakan')->findAllByAttributes(array('tipepaket_id'=>$idTipePaket,
      //                                                                                                               'kelompokumur_id'=>$idKelompokUmur));
      if (isset($modPaketBmhp)) {
        foreach ($modPaketBmhp as $i => $bmhp) {
          $totHargaBmhp = $totHargaBmhp + $bmhp->hargapemakaian;
        }
      }
      // ---------------------------

      echo CJSON::encode(array(
        'form' => $this->renderPartial($this->path_view.'_formLoadTindakanPaket', array(
          'modPaketTindakan' => $modPaketTindakan,
          'modTindakans' => $modTindakans,
        ), true),
        'formPaketBmhp' => $this->renderPartial($this->path_view.'_formLoadPaketBmhp', array(
          'modPaketBmhp' => $modPaketBmhp,
        ), true),
        'totHargaBmhp' => $totHargaBmhp,
        'optionDaftarttindakan' => $optionDaftarttindakan,
      ));
      exit;
    }
  }

  /**
   * untuk memanggil function persen harga jual
   */
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
   * untuk mencari dokter di autocomplete
   */
  public function actionGetDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      if (isset($_GET['term'])) {
        $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      } else if (isset($_POST['id'])) {
        $criteria->compare('pegawai_id', $_POST['id']);
      }
      $criteria->order = 'nama_pegawai';
      if (isset($_GET['idPegawai'])) {
        if (!empty($_GET['idPegawai'])) {
          $criteria->addCondition("pegawai_id = " . $_GET['idPegawai']);
        }
      }
      $models = DokterpegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['nama_pegawai'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk mencari bidan di autocomplete
   */
  public function actionGetBidan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $models = PegawaiM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['nama_pegawai'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk mencari suster di autocomplete
   */

  public function actionGetSuster()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $models = PegawaiM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['nama_pegawai'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk mencari perawat di autocomplete
   */
  public function actionGetPerawat($term = null)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($term), true);
      $criteria->order = 'nama_pegawai';
      if (isset($_POST['id'])) {
        $criteria->compare('pegawai_id', $_POST['id']);
      }
      $criteria->addInCondition("kelompokpegawai_id", array(Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_BIDAN));
      $models = PegawaiV::model()->findAll($criteria);


      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['nama_pegawai'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

   /**
   * untuk mencari perawat di autocomplete
   */
  public function actionGetOkupasi($term = null)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($term), true);
      $criteria->order = 'nama_pegawai';
      if (isset($_POST['id'])) {
        $criteria->compare('pegawai_id', $_POST['id']);
      }
      $criteria->addInCondition("kelompokpegawai_id", array(Params::KELOMPOKPEGAWAI_ID_OKUPASITERAPI));
      $models = PegawaiV::model()->findAll($criteria);


      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['nama_pegawai'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

   /**
   * untuk mencari perawat di autocomplete
   */
  public function actionGetTerapi($term = null)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($term), true);
      $criteria->order = 'nama_pegawai';
      if (isset($_POST['id'])) {
        $criteria->compare('pegawai_id', $_POST['id']);
      }
      $criteria->addInCondition("kelompokpegawai_id", array(Params::KELOMPOKPEGAWAI_ID_TERAPIWICARA));
      $models = PegawaiV::model()->findAll($criteria);


      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['nama_pegawai'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk mencari paket bmhp di autocomplete
   */
  public function actionPaketBMHP()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->with = array('obatalkes', 'daftartindakan', 'kelompokumur');
      $criteria->compare('LOWER(obatalkes.obatalkes_nama)', strtolower($_GET['term']), true);
      //$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
      $criteria->order = 'obatalkes.obatalkes_nama';
      $criteria->limit = 5;
      $models = PaketbmhpM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->obatalkes->obatalkes_nama . ' - ' . $model->daftartindakan->daftartindakan_nama . ' (' . $model->kelompokumur->kelompokumur_nama . ')';
        $returnVal[$i]['value'] = $model->obatalkes->obatalkes_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk mencari pemakaian bahan di autocomplete
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
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $qtyStok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
        $returnVal[$i]['label'] = $model->obatalkes_kode . " - " . $model->obatalkes_nama . " - Jumlah Stok " . $qtyStok;
        $returnVal[$i]['value'] = $model->obatalkes_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk mencari pemakaian alat medis di autocomplete
   */
  public function actionPemakaianAlatMedis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(alatmedis_nama)', strtolower($_GET['term']), true);
      $criteria->addCondition('instalasi_id = ' . Yii::app()->user->getState('instalasi_id'));
      $criteria->order = 'alatmedis_nama';
      $models = AlatmedisM::model()->findAll($criteria);
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
   * action ajax select tindakan ke form
   */
  public function actionDaftarTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (!isset($_GET['term'])) {
        $_GET['term'] = null;
      }
      $returnVal = array();
      $kelaspelayanan_id = (isset($_GET['kelaspelayanan_id']) ? $_GET['kelaspelayanan_id'] : null);
      $tipepaket_id = (isset($_GET['tipepaket_id']) ? $_GET['tipepaket_id'] : null);
      $penjamin_id = (isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null);
      
      $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $penjamin_id);
      if ($tipepaket_id == Params::TIPEPAKET_ID_LUARPAKET) {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
        if (Yii::app()->user->getState('tindakanruangan')) {
          $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
        }
        //if(Yii::app()->user->getState('tindakankelas')){
        if (!empty($kelaspelayanan_id)) {
          $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
        }
        $criteria->addCondition('tipepaket_id = ' . Params::TIPEPAKET_ID_LUARPAKET);
        //}
        if (isset($_GET['daftartindakan_id'])) {
          if (!empty($_GET['daftartindakan_id'])) {
            $criteria->addCondition("daftartindakan_id = " . $_GET['daftartindakan_id']);
          }
        }
        if (!empty($kelaspelayanan_id)) {
          $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
        }
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
      } else if ($tipepaket_id == Params::TIPEPAKET_ID_NONPAKET) {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
        if (!empty($kelaspelayanan_id)) {
          $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
        }
        if (!empty($penjamin_id)) {
          $criteria->addCondition("penjamin_id = " . $penjamin_id);
        }
        $criteria->order = 'daftartindakan_nama';

        if (isset($_GET['daftartindakan_id'])) {
          if (!empty($_GET['daftartindakan_id'])) {
            $criteria->addCondition("daftartindakan_id = " . $_GET['daftartindakan_id']);
          }
        }

        //if(Yii::app()->user->getState('tindakankelas'))
        //{
        if (!empty($kelaspelayanan_id)) {
          $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
        }
        //}

        if (Yii::app()->user->getState('tindakanruangan')) {
          $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
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
          if (!empty($_GET['daftartindakan_id'])) {
            $criteria->addCondition("daftartindakan_id = " . $_GET['daftartindakan_id']);
          }
        }

        if (Yii::app()->user->getState('tindakanruangan')) {
          $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
        }

        //if(Yii::app()->user->getState('tindakankelas')){
        if (!empty($kelaspelayanan_id)) {
          $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
        }
        //}

        if (!empty($tipepaket_id)) {
          $criteria->addCondition("tipepaket_id = " . $tipepaket_id);
        }
        if (!empty($kelaspelayanan_id)) {
          $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
        }
        $criteria->order = 'daftartindakan_nama';
        $models = PaketpelayananV::model()->find($criteria);
        if (isset($models)) {
          foreach ($models as $i => $model) {
            $attributes = $model->attributeNames();
            foreach ($attributes as $j => $attribute) {
              $returnVal[$i]["$attribute"] = $model->$attribute;
            }
            $returnVal[$i]['label'] = $model->daftartindakan_nama;
            $returnVal[$i]['value'] = $model->daftartindakan_id;
          }
        }

        echo CJSON::encode($returnVal);
      }
    }
    Yii::app()->end();
  }

  /**
   * simpan StokobatalkesT Jumlah Out
   * @param type $stokobatalkesasal_id
   * @param type $modObatAlkesPasien
   * @return \StokobatalkesT
   */
  protected function simpanStokObatAlkesOut2($modObatAlkesPasien)
  {
    $format = new MyFormatter;
    $oa = ObatalkesM::model()->findByPk($modObatAlkesPasien->obatalkes_id);
    // $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $oa->attributes; //duplicate
    $modStokOaNew->attributes = $modObatAlkesPasien->attributes; //duplicate
    $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
    //$modStokOaNew->qtystok_in = 0;
    $modStokOaNew->qtystok_out = $modObatAlkesPasien->qty_oa;
    $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
    //$modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = $modStokOaNew->tglterima = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

    if ($modStokOaNew->validate()) {
      $this->stokobatalkestersimpan &= $modStokOaNew->save();
      //$modStokOaNew->setStokOaAktifBerdasarkanStok();
    } else {
      $this->stokobatalkestersimpan &= false;
    }
    return $modStokOaNew;
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

  public function actionPrintTindakan($id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($id);
    $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modViewTindakans = RITindakanPelayananT::model()
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
      ->findAllByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));

    $modViewBmhp = RIObatalkespasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $id));

    $judul_print = 'Tindakan Pasien ' . $modPasien->nama_pasien;
    $this->render(
      $this->path_view_rj.'printPerPage',
      array(
        'format' => $format,
        'judul_print' => $judul_print,
        'modPendaftaran' => $modPendaftaran,
        'modTindakans' => $modViewTindakans,
        'modViewBmhp' => $modViewBmhp,
        'modPasien' => $modPasien
      )
    );
  }


  public function actionCekDeposit()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $modBayarUangMuka = BayaruangmukaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'bayaruangmuka_id DESC'));
      echo CJSON::encode($modBayarUangMuka);
    }
  }

  public function actionUpdateDepositPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $bayaruangmuka_id = $_POST['bayaruangmuka_id'];
      $tglperjanjian = $_POST['tglperjanjian'];
      $ketperjanjian = $_POST['ketperjanjian'];
      $success = false;
      $modBayarUangMuka = BayaruangmukaT::model()->findByPk($bayaruangmuka_id);
      $modBayarUangMuka->tglperjanjian = $tglperjanjian;
      $modBayarUangMuka->keterangan_perjanjian = $ketperjanjian;
      if ($modBayarUangMuka->validate()) {
        $modBayarUangMuka->save();
        $success = true;
      }
      echo CJSON::encode($success);
    }
  }

  public function actionCekTanggalPerjanjian()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $bayaruangmuka_id = $_POST['bayaruangmuka_id'];
      $modBayarUangMuka = BayaruangmukaT::model()->findByPk($bayaruangmuka_id);
      $tglperjanjian = strtotime(MyFormatter::formatDateTimeForDb($modBayarUangMuka->tglperjanjian));
      $currdate = strtotime(date('Y-m-d'));
      if ($tglperjanjian >= $currdate) {
        $status = true;
      } else {
        $status = false;
      }
      echo CJSON::encode($status);
    }
  }

  public function actionSudahBacaEdukasi()
  {
    if (isset($_POST['id'])) {
      PendaftaranT::model()->updateByPk($_POST['id'], array(
        'isbacaedukasitransfusi' => true,
      ));
    }
  }

  public function actionLoadPembebasanTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $tindakanpelayanan_id = $_GET['tindakanpelayanan_id'];
      $returnVal = array();

      $komponentarif_id = array(Params::KOMPONENTARIF_ID_TOTAL);

      $criteria = new CDbCriteria();
      $criteria->addCondition('tindakanpelayanan_id = ' . $tindakanpelayanan_id);
      $criteria->addNotInCondition('komponentarif_id', $komponentarif_id);
      $komponens = TindakankomponenT::model()->findAll($criteria);

      if(!empty($komponens)){
        foreach ($komponens as $j => $komponen) {
          $tindKomponenId = $komponen->tindakankomponen_id;
          $jmlpembebasan = 0;
          $pembebasantarif_id = null;

          $pembebasan = PembebasantarifT::model()->findByAttributes(array('tindakanpelayanan_id'=>$komponen->tindakanpelayanan_id, 'komponentarif_id'=>$komponen->komponentarif_id));
          
          if(!empty($pembebasan)){
            $jmlpembebasan = $pembebasan->jmlpembebasan;
            $pembebasantarif_id = $pembebasan->pembebasantarif_id;
          }
            
          $returnVal[$tindKomponenId]['tindakankomponen_id'] = $tindKomponenId;
          $returnVal[$tindKomponenId]['tindakanpelayanan_id'] = $komponen->tindakanpelayanan_id;
          $returnVal[$tindKomponenId]['komponentarif_id'] = $komponen->komponentarif_id;
          $returnVal[$tindKomponenId]['komponentarif_nama'] = $komponen->komponentarif->komponentarif_nama;
          $returnVal[$tindKomponenId]['tarif_kompsatuan'] = $komponen->tarif_kompsatuan;
          $returnVal[$tindKomponenId]['tarif_tindakankomp'] = $komponen->tarif_tindakankomp;
          $returnVal[$tindKomponenId]['tarifcyto_tindakankomp'] = $komponen->tarifcyto_tindakankomp;
          $returnVal[$tindKomponenId]['subsidiasuransikomp'] = $komponen->subsidiasuransikomp;
          $returnVal[$tindKomponenId]['subsidipemerintahkomp'] = $komponen->subsidipemerintahkomp;
          $returnVal[$tindKomponenId]['subsidirumahsakitkomp'] = $komponen->subsidirumahsakitkomp;
          $returnVal[$tindKomponenId]['iurbiayakomp'] = $komponen->iurbiayakomp;
          $returnVal[$tindKomponenId]['jmlpembebasan'] = $jmlpembebasan;
          $returnVal[$tindKomponenId]['pembebasantarif_id'] = $pembebasantarif_id;


        }
      }
      $form = "";
      if(!empty($returnVal)){
        $form = $this->renderPartial($this->path_view . '_rowPembebasan', array('data' => $returnVal), true);
      }
      
      $dataForm = $form;

      echo CJSON::encode($dataForm);
    }
  }


  public function actionSavePembebasanTindakan(){
    if (Yii::app()->request->isAjaxRequest) {
      $data = array();
      $sukses = 0;
      $pesan = "Data Free Of Change Gagal Disimpan!!";

      if (isset($_POST['pembebasan'])) {
        $transaction = Yii::app()->db->beginTransaction();

        try {
            $tersimpanpembebas = true;
            $terupdatetindakan = false;

            $sumjumlah = 0;
            $tindakanpelayanan_id = $_POST['tindakanpelayanan_id_pembebasan'];
            $model = TindakanpelayananT::model()->findByPk($tindakanpelayanan_id);

            $modPembebasanAll = PembebasantarifT::model()->findAllByAttributes(array('tindakanpelayanan_id'=>$tindakanpelayanan_id));

            if(!empty($modPembebasanAll)){
              foreach($modPembebasanAll as $dataPembebasanOri){
                $cekdata = 0;

                foreach ($_POST['pembebasan'] as $tindkomponen_id => $dataPembebasan) {
                  if($dataPembebasanOri->pembebasantarif_id == $dataPembebasan['pembebasantarif_id']){
                    $cekdata = 1;
                  }
                }

                if($cekdata == 0){
                  PembebasantarifT::model()->deleteByPk($dataPembebasanOri->pembebasantarif_id);
                }
              }
            }

            foreach ($_POST['pembebasan'] as $tindkomponen_id => $dataPembebasan) {
              if(!empty($dataPembebasan['pembebasantarif_id'])){
                $modPembebasan = PembebasantarifT::model()->findByPk($dataPembebasan['pembebasantarif_id']);
              }

              if(empty($modPembebasan)){
                $modPembebasan = new PembebasantarifT;
              }
              
              $modPembebasan->attributes = $model->attributes;
              $modPembebasan->pegawai_id = $model->dokterpemeriksa1_id;
              $modPembebasan->tglpembebasan = date('Y-m-d H:i:s');
              $modPembebasan->tindakanpelayanan_id = $dataPembebasan['tindakanpelayanan_id'];
              $modPembebasan->komponentarif_id = $dataPembebasan['komponentarif_id'];
              $modPembebasan->jmlpembebasan = $dataPembebasan['tarif_tindakankomp'];
              $modPembebasan->loginpemakai_id = Yii::app()->user->id;
              
              $sumjumlah += $modPembebasan->jmlpembebasan;
             
              if(!$modPembebasan->save()){
                $tersimpanpembebas &= false;
              }
            }

            $terupdatetindakan = TindakanpelayananT::model()->updateByPk($tindakanpelayanan_id, array('pembebasan_tindakan'=> $sumjumlah));

            if($tersimpanpembebas && $terupdatetindakan){
              $transaction->commit();
              $sukses = 1;
              $pesan = "Data Free Of Change Berhasil disimpan!!";
            }else{
              $transaction->rollback();
                 $sukses = 0;
                 $pesan = "Data Free Of Change Gagal Disimpan!!";
            }
           } catch (Exception $ex) {
               $transaction->rollback();
               $sukses = 0;
               $pesan = "Data Free Of Change Gagal Disimpan!! ".MyExceptionMessage::getMessage($ex,true);
           }
      }
      $data['sukses'] = $sukses;
      $data['pesan'] = $pesan;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionLoadReturTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $tindakanpelayanan_id = $_GET['tindakanpelayanan_id'];
      $tindakansudahbayar_id = $_GET['tindakansudahbayar_id'];
      $form = "";
      $pesan = "";
      $issudahretur = false;

      $crt_tindakan = new CDbCriteria();
      $crt_tindakan->addCondition('t.tindakanpelayanan_id = ' . $tindakanpelayanan_id);
      $crt_tindakan->addCondition('t.tindakansudahbayar_id = ' . $tindakansudahbayar_id);
      $crt_tindakan->addCondition('pembebasantarif_t.tindakanpelayanan_id IS NOT NULL');
      $crt_tindakan->join = 'LEFT JOIN pembebasantarif_t on pembebasantarif_t.tindakanpelayanan_id = t.tindakanpelayanan_id';
      $modTindakanPembebasan = TindakanpelayananT::model()->findAll($crt_tindakan);


      if(empty($modTindakanPembebasan)){
        $cekpembebasan = 0;
        $komponentarif_id = array(Params::KOMPONENTARIF_ID_TOTAL);

        $criteria = new CDbCriteria();
        $criteria->addCondition('tindakanpelayanan_id = ' . $tindakanpelayanan_id);
        $criteria->addNotInCondition('komponentarif_id', $komponentarif_id);
        $komponens = TindakankomponenT::model()->findAll($criteria);

        if(!empty($komponens)){
          foreach ($komponens as $j => $komponen) {
            $tindKomponenId = $komponen->tindakankomponen_id;
            $jmlpembebasan = 0;
            $pembebasantarif_id = null;

            $pembebasan = PembebasantarifT::model()->findByAttributes(array('tindakansudahbayar_id'=>$tindakansudahbayar_id, 'komponentarif_id'=>$komponen->komponentarif_id));
            
            if(!empty($pembebasan)){
              $jmlpembebasan = $pembebasan->jmlpembebasan;
              $pembebasantarif_id = $pembebasan->pembebasantarif_id;
              $cekpembebasan += 1;
            }else{
              if($cekpembebasan > 0){
                $cekpembebasan -= 1;
              }
            }
              
            $returnVal[$tindKomponenId]['tindakankomponen_id'] = $tindKomponenId;
            $returnVal[$tindKomponenId]['tindakanpelayanan_id'] = $komponen->tindakanpelayanan_id;
            $returnVal[$tindKomponenId]['tindakansudahbayar_id'] = $tindakansudahbayar_id;
            $returnVal[$tindKomponenId]['komponentarif_id'] = $komponen->komponentarif_id;
            $returnVal[$tindKomponenId]['komponentarif_nama'] = $komponen->komponentarif->komponentarif_nama;
            $returnVal[$tindKomponenId]['tarif_kompsatuan'] = $komponen->tarif_kompsatuan;
            $returnVal[$tindKomponenId]['tarif_tindakankomp'] = $komponen->tarif_tindakankomp;
            $returnVal[$tindKomponenId]['tarifcyto_tindakankomp'] = $komponen->tarifcyto_tindakankomp;
            $returnVal[$tindKomponenId]['subsidiasuransikomp'] = $komponen->subsidiasuransikomp;
            $returnVal[$tindKomponenId]['subsidipemerintahkomp'] = $komponen->subsidipemerintahkomp;
            $returnVal[$tindKomponenId]['subsidirumahsakitkomp'] = $komponen->subsidirumahsakitkomp;
            $returnVal[$tindKomponenId]['iurbiayakomp'] = $komponen->iurbiayakomp;
            $returnVal[$tindKomponenId]['jmlpembebasan'] = $jmlpembebasan;
            $returnVal[$tindKomponenId]['pembebasantarif_id'] = $pembebasantarif_id;
          }

          if(!empty($returnVal)){
            $form = $this->renderPartial($this->path_view . '_rowReturTagihan', array('data' => $returnVal), true);
          }
        }

        if($cekpembebasan == count((array) $komponens)){
          $pesan = "Tindakan Sudah Melakukan Retur Tagihan!";
          $issudahretur = true;
        }
      }else{
        $pesan = "Tindakan Sudah Melakukan Free OF Charge (FOC)!";
      }

      echo CJSON::encode(array('form'=>$form,'pesan'=>$pesan, 'issudahretur' =>$issudahretur));
    }
  }

  public function actionSaveReturTindakan(){
    if (Yii::app()->request->isAjaxRequest) {
      $data = array();
      $sukses = 0;
      $pesan = "Data Retur Tagihan Gagal Disimpan!!";

      if (isset($_POST['Returtagihan'])) {
        $transaction = Yii::app()->db->beginTransaction();
        
        try {
            $tersimpanpembebas = true;
            $terupdatetindakan = false;

            $sumjumlah = 0;
            $tindakanpelayanan_id = $_POST['tindakanpelayanan_id_retur'];
            $tindakansudahbayar_id = $_POST['tindakansudahbayar_id_retur'];
            $model = TindakanpelayananT::model()->findByPk($tindakanpelayanan_id);

            $modReturAll = PembebasantarifT::model()->findAllByAttributes(array('tindakansudahbayar_id'=>$tindakansudahbayar_id));

            if(!empty($modReturAll)){
              foreach($modReturAll as $dataReturOri){
                $cekdata = 0;

                foreach ($_POST['Returtagihan'] as $tindkomponen_id => $dataRetur) {
                  if($dataReturOri->pembebasantarif_id == $dataRetur['pembebasantarif_id']){
                    $cekdata = 1;
                  }
                }

                if($cekdata == 0){
                  PembebasantarifT::model()->deleteByPk($dataReturOri->pembebasantarif_id);
                }
              }
            }

            foreach ($_POST['Returtagihan'] as $tindkomponen_id => $dataPembebasan) {
              if(!empty($dataPembebasan['pembebasantarif_id'])){
                $modPembebasan = PembebasantarifT::model()->findByPk($dataPembebasan['pembebasantarif_id']);
              }

              if(empty($modPembebasan)){
                $modPembebasan = new PembebasantarifT;
              }
              
              $modPembebasan->attributes = $model->attributes;
              $modPembebasan->pegawai_id = $model->dokterpemeriksa1_id;
              $modPembebasan->tglpembebasan = date('Y-m-d H:i:s');
              $modPembebasan->tindakansudahbayar_id = $dataPembebasan['tindakansudahbayar_id'];
              $modPembebasan->tindakanpelayanan_id = null;
              $modPembebasan->komponentarif_id = $dataPembebasan['komponentarif_id'];
              $modPembebasan->jmlpembebasan = $dataPembebasan['hargaretur'];
              $modPembebasan->loginpemakai_id = Yii::app()->user->id;
              
              $sumjumlah += $modPembebasan->jmlpembebasan;
             
              
              if(!$modPembebasan->save()){
                $tersimpanpembebas &= false;
              }
            }
            
            $terupdatetindakan = TindakanpelayananT::model()->updateByPk($tindakanpelayanan_id, array('pembebasan_tindakan'=> $sumjumlah));

            if($tersimpanpembebas && $terupdatetindakan){
              $transaction->commit();
              $sukses = 1;
              $pesan = "Data Retur Tagihan Berhasil disimpan!!";
            }else{
              $transaction->rollback();
                 $sukses = 0;
                 $pesan = "Data Retur Tagihan Gagal Disimpan!!";
            }
           } catch (Exception $ex) {
               $transaction->rollback();
               $sukses = 0;
               $pesan = "Data Retur Tagihan Gagal Disimpan!! ".MyExceptionMessage::getMessage($ex,true);
           }
      }

      
      $data['sukses'] = $sukses;
      $data['pesan'] = $pesan;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
