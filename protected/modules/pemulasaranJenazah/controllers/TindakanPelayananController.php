<?php

class TindakanPelayananController extends MyAuthController
{
  public $succesSave = false;
  protected $successSaveBmhp = true;
  protected $successSavePemakaianBahan = true;
  protected $stokobatalkestersimpan = true;
  protected $path_view = 'pemulasaranJenazah.views.tindakanPelayanan.';

  public function actionIndex($pendaftaran_id = '', $instalasi_id = '', $pasienmasukpenunjang_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Tindakan Dan Pelayanan";
    $format = new MyFormatter();
    if (isset($_GET['pendaftaran_id'])) {
      $pendaftaran_id = $_GET['pendaftaran_id'];
    }

    $modViewTindakans = array();
    if (!empty($pendaftaran_id)) {
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

      if (!empty($pasienmasukpenunjang_id)) {
        $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
      } else {
        $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      }

      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modViewTindakans = PJTindakanPelayananT::model()
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
        ->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
    } else {
      $modPendaftaran = new PendaftaranT;
      $modPasien = new PasienM;
      $modPasienMasukPenunjang = new PasienmasukpenunjangT;
    }

    $instalasi_id = Yii::app()->user->getState('instalasi_id');
    $modTindakans = array();
    $dataTindakans = array();
    $modViewBmhp = array();
    $modTindakan = new PJTindakanPelayananT;
    $modTindakan->tarifcyto_tindakan = 0;
    $modTindakan->tgl_tindakan = $format->formatDateTimeForUser(date("Y-m-d H:i:s"));
    $modTindakan->instalasi_id = $instalasi_id;

    if (isset($_POST['PJTindakanPelayananT']) || isset($_POST['TindakanpelayananT'])) {
      $pendaftaran_id = $_POST['PendaftaranT']['pendaftaran_id'];
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = PasienM::model()->findByPk(isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien_id : null);
      //            $modTindakans = $this->saveTindakan($modPasien, $modPendaftaran);
      $modTindakans = $this->saveTindakan($modPasien, $modPendaftaran, $modPasienMasukPenunjang);
      //            '<pre>'; print_r($modTindakans); exit();
      if ($this->succesSave) {
        PasienmasukpenunjangT::model()->updateByPk($modPasienMasukPenunjang->pasienmasukpenunjang_id, array(
          'statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA,
        ));
        if ($modPasienMasukPenunjang->ruanganasal_id == $modPasienMasukPenunjang->ruangan_id) {
          PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array(
            'statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA,
          ));
        }
        $sukses = 1;
        Yii::app()->user->setFlash('success', "Data Pasien " . $modPasien->nama_pasien . " berhasil disimpan !");
        $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'instalasi_id' => @$_GET['instalasi_id'], 'sukses' => $sukses));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }

    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modTindakans' => $modTindakans,
      'modTindakan' => $modTindakan,
      'dataTindakans' => $dataTindakans,
      'modViewBmhp' => $modViewBmhp,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'instalasi_id' => $instalasi_id,
      'modViewTindakans' => $modViewTindakans
    ));
  }

  /**
   * untuk menyimpan tindakan pelayanan jenazah
   * @param type $modPasien
   * @param type $modPendaftaran
   * @return \PJTindakanPelayananT
   */
  public function saveTindakan($modPasien, $modPendaftaran, $modPasienMasukPenunjang)
  {
    $post = (isset($_POST['TindakanpelayananT'])) ? $_POST['TindakanpelayananT'] : $_POST['PJTindakanPelayananT'];
    $valid = true;
    $format = new MyFormatter();

    $transaction = Yii::app()->db->beginTransaction();
    $tindakanSimpan = array();
    try {
      if (isset($post)) {
        foreach ($post as $i => $item) {
          if (!empty($item) && (!empty($item['daftartindakan_id'])) && ($i !== $item['tgl_tindakan'])) {
            $modTindakans[$i] = new PJTindakanPelayananT();
            $modTindakans[$i]->attributes = $item;
            $modTindakans[$i]->tipepaket_id = isset($_POST['tipepaket_id']) ? $_POST['tipepaket_id'] : null;
            $modTindakans[$i]->daftartindakan_id = isset($item['daftartindakan_id']) ? $item['daftartindakan_id'] : null;
            $modTindakans[$i]->pasien_id = $modPasien->pasien_id;
            $modTindakans[$i]->pasienmasukpenunjang_id = $_POST['pasienmasukpenunjang_id'];
            // $modTindakans[$i]->ppds1_id = $_POST['ppds1_id'];
            // $modTindakans[$i]->ppds2_id = $_POST['ppds2_id'];
            // $modTindakans[$i]->ppds3_id = $_POST['ppds3_id'];
            // $modTindakans[$i]->ppds4_id = $_POST['ppds4_id'];
            // $modTindakans[$i]->ppds5_id = $_POST['ppds5_id'];
            
            $modTindakans[$i]->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
            $modTindakans[$i]->kelaspelayanan_id = (isset($modPendaftaran->kelaspelayanan_id) ? $modPendaftaran->kelaspelayanan_id : null);
            $modTindakans[$i]->carabayar_id = (isset($modPendaftaran->carabayar_id) ? $modPendaftaran->carabayar_id : null);
            $modTindakans[$i]->penjamin_id = (isset($modPendaftaran->penjamin_id) ? $modPendaftaran->penjamin_id : null);
            $modTindakans[$i]->jeniskasuspenyakit_id = (isset($modPendaftaran->jeniskasuspenyakit_id) ? $modPendaftaran->jeniskasuspenyakit_id : null);
            $modTindakans[$i]->pendaftaran_id = (isset($modPendaftaran->pendaftaran_id) ? $modPendaftaran->pendaftaran_id : null);
            $modTindakans[$i]->tgl_tindakan = isset($item['tgl_tindakan']) ? $format->formatDateTimeForDb($item['tgl_tindakan']) : date('Y-m-d H:i:s');
            $modTindakans[$i]->shift_id = Yii::app()->user->getState('shift_id');
            $modTindakans[$i]->tarif_satuan = $modTindakans[$i]->getTarifSatuan(); //RND-7250
            $modTindakans[$i]->tarif_tindakan = $modTindakans[$i]->tarif_satuan * $modTindakans[$i]->qty_tindakan;
            $modTindakans[$i]->satuantindakan = isset($item['satuantindakan']) ? $item['satuantindakan'] : null;
            $modTindakans[$i]->cyto_tindakan = isset($item['cyto_tindakan']) ? $item['cyto_tindakan'] : null;
            if (!empty($item['cyto_tindakan'])) {
              $modTindakans[$i]->tarifcyto_tindakan = ($item['persenCyto'] / 100) * $modTindakans[$i]->tarif_tindakan;
            } else {
              $modTindakans[$i]->tarifcyto_tindakan = 0;
            }
            $modTindakans[$i]->discount_tindakan = 0;
            $modTindakans[$i]->subsidiasuransi_tindakan = 0;
            $modTindakans[$i]->subsidipemerintah_tindakan = 0;
            $modTindakans[$i]->subsisidirumahsakit_tindakan = 0;
            $modTindakans[$i]->iurbiaya_tindakan = 0;
            $modTindakans[$i]->instalasi_id = (isset($modPendaftaran->instalasi_id) ? $modPendaftaran->instalasi_id : null);
            $modTindakans[$i]->ruangan_id =  Yii::app()->user->getState('ruangan_id');
            $modTindakans[$i]->alatmedis_id = $this->cekAlatmedis($modTindakans[$i]->daftartindakan_id);
            $modTindakans[$i]->create_time = date('Y-m-d H:i:s');
            $modTindakans[$i]->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
            $modTindakans[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modTindakans[$i]->tarif_rsakomodasi = 0;
            $modTindakans[$i]->tarif_medis = 0;
            $modTindakans[$i]->tarif_paramedis = 0;
            $modTindakans[$i]->tarif_bhp = 0;
            $modTindakans[$i]->create_time = date("Y-m-d H:i:s");
            $modTindakans[$i]->create_loginpemakai_id = Yii::app()->user->id;
            $modTindakans[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');

            $valid = $modTindakans[$i]->validate() && $valid;
          }
        }
      }
      if (isset($modTindakans)) {

        if ($valid && (count((array)$modTindakans) > 0)) {
          foreach ($modTindakans as $i => $tindakan) {
            if ($tindakan->save()) {
              $tindakanSimpan[$tindakan->daftartindakan_id] = $tindakan->tindakanpelayanan_id;
              $statusSaveKomponen = true;
            }
            if (isset($_POST['paketBmhp'])) {
              $modObatPasiens = $this->savePaketBmhp($modPendaftaran, $_POST['paketBmhp'], $tindakan);
            }
            if (isset($_POST['pemakaianBahan'])) {
              if (count((array)$_POST['pemakaianBahan']) > 0) {
                //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
                $detailGroups = array();
                foreach ($_POST['pemakaianBahan'] as $i => $postDetail) {
                  $modDetails[$i] = new PJObatalkesPasienT;
                  $modDetails[$i]->attributes = $postDetail;
                  if (!empty($modDetails[$i]->daftartindakan_id)) {
                    $postDetail['tindakanpelayanan_id'] = $tindakanSimpan[$modDetails[$i]->daftartindakan_id];
                  }
                  $modDetails[$i] = $this->simpanObatAlkesPasien2($modPendaftaran, $postDetail);
                  $this->simpanStokObatAlkesOut2($modDetails[$i]);

                  /*
                                $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
                                $modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
                                $obatalkes_id = $postDetail['obatalkes_id'];
                                if(isset($detailGroups[$obatalkes_id])){
                                    $detailGroups[$obatalkes_id]['qty'] += $postDetail['qty'];
                                    $detailGroups[$obatalkes_id]['ruangan_id'] = $postDetail['ruangan_id'];
                                }else{
                                    $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
                                    $detailGroups[$obatalkes_id]['qty'] = $postDetail['qty'];
                                    $detailGroups[$obatalkes_id]['ruangan_id'] = $postDetail['ruangan_id'];
                                }
                                 * 
                                 */
                }

                $obathabis = "";
                //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
                foreach ($detailGroups as $i => $detail) {
                  $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty'], Yii::app()->user->getState('ruangan_id'));
                  if (count((array)$modStokOAs) > 0) {
                    foreach ($modStokOAs as $i => $stok) {
                      $modDetails[$i] = $this->savePemakaianBahan($modPendaftaran, $stok, $tindakan, $_POST['pemakaianBahan']);
                      $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
                    }
                  } else {
                    $this->stokobatalkestersimpan &= false;
                    $obathabis .= "<br>- " . ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
                  }
                }
                //END GROUP
              }
              //                         $modPemakainBahans = $this->savePemakaianBahan($modPendaftaran, $_POST['pemakaianBahan'],$tindakan);
            }
          }
          if ($statusSaveKomponen && $this->successSaveBmhp && $this->successSavePemakaianBahan && $this->stokobatalkestersimpan) {
            //                     $updateStatusPeriksa=PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA)); //komen RSSP-1303
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
      } else {
        $modTindakans = array();
        $transaction->rollback();
      }
    } catch (Exception $exc) {
      $transaction->rollback();
      Yii::app()->user->setFlash('error', "Data Tindakan Pasien Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
    }

    return $modTindakans;
  }

  /**
   * untuk mengecek alat medis yang dipilih
   * @param type $daftartindakan_id
   */
  protected function cekAlatmedis($daftartindakan_id)
  {
    $alatmedis = null;
    if (!empty($_POST['pemakaianAlat'])) {
      foreach ($_POST['pemakaianAlat'] as $k => $item) {
        if ($item['daftartindakan_id'] == $daftartindakan_id) {
          $alatmedis = $item['alatmedis_id'];
        }
      }
    }

    return $alatmedis;
  }

  /**
   * untuk menyimpan paket BMHP
   * @param type $modPendaftaran
   * @param type $paketBmhp
   * @param type $tindakan
   * @return \PJObatalkesPasienT
   */
  protected function savePaketBmhp($modPendaftaran, $paketBmhp, $tindakan)
  {
    $valid = true;
    foreach ($paketBmhp as $i => $bmhp) {
      if ($tindakan->daftartindakan_id == $bmhp['daftartindakan_id']) {
        $modObatPasien[$i] = new PJObatalkesPasienT;
        $modObatPasien[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modObatPasien[$i]->penjamin_id = $modPendaftaran->penjamin_id;
        $modObatPasien[$i]->carabayar_id = $modPendaftaran->carabayar_id;
        $modObatPasien[$i]->daftartindakan_id = $bmhp['daftartindakan_id'];
        $modObatPasien[$i]->sumberdana_id = $bmhp['sumberdana_id'];
        $modObatPasien[$i]->pasien_id = $modPendaftaran->pasien_id;
        $modObatPasien[$i]->satuankecil_id = $bmhp['satuankecil_id'];
        $modObatPasien[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modObatPasien[$i]->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
        $modObatPasien[$i]->tipepaket_id = $tindakan->tipepaket_id;
        $modObatPasien[$i]->obatalkes_id = $bmhp['obatalkes_id'];
        $modObatPasien[$i]->pegawai_id = $modPendaftaran->pegawai_id;
        $modObatPasien[$i]->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        $modObatPasien[$i]->shift_id = Yii::app()->user->getState('shift_id');
        $modObatPasien[$i]->tglpelayanan = date('Y-m-d H:i:s');
        $modObatPasien[$i]->qty_oa = $bmhp['qtypemakaian'];
        $modObatPasien[$i]->hargajual_oa = $bmhp['hargapemakaian'];
        $modObatPasien[$i]->harganetto_oa = $bmhp['harganetto'];
        $modObatPasien[$i]->hargasatuan_oa = $bmhp['hargasatuan'];

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

    return $modObatPasien;
  }

  /**
   * menampilkan obat
   * @return row table 
   */
  public function actionSetFormPemakaianBahan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null;
      $satuankecil_id = isset($_POST['satuankecil_id']) ? $_POST['satuankecil_id'] : null;
      $daftartindakan_id = isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $penjamin_id = isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null;
      $jumlah = 1;
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modObatAlkesPasien = new PJObatalkesPasienT;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modDaftartindakan = DaftartindakanM::model()->findByPk($daftartindakan_id);
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modOa = ObatalkesM::model()->findByPk($obatalkes_id);
      //$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);


      $modObatAlkesPasien->sumberdana_id = $modOa->sumberdana_id;
      $modObatAlkesPasien->obatalkes_id = $modOa->obatalkes_id;
      $modObatAlkesPasien->qty_oa = $jumlah;
      $modObatAlkesPasien->harganetto = $modOa->harganetto;
      $modObatAlkesPasien->hargasatuan = $modOa->hargajual;
      $modObatAlkesPasien->hargasatuan_oa = $modOa->hargajual;
      // $modObatAlkesPasien->qty_stok = 0;
      $modObatAlkesPasien->hargajual = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
      // $modObatAlkesPasien->stokobatalkes_id = $stok->stokobatalkes_id;
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
      $modObatAlkesPasien->satuankecil_id = $modOa->satuankecil_id;
      $modObatAlkesPasien->satuankecil_nama = $modOa->satuankecil->satuankecil_nama;
      $modObatAlkesPasien->obatalkes_nama = $modOa->obatalkes_nama;
      $modObatAlkesPasien->ruangan_id = $ruangan_id;

      $form .= $this->renderPartial($this->path_view . '_formAddPemakaianBahan', array('modObatAlkesPasien' => $modObatAlkesPasien, 'modDaftartindakan' => $modDaftartindakan, 'modPendaftaran' => $modPendaftaran), true);
      /*
            if(count((array)$modStokOAs) > 0){
                foreach($modStokOAs AS $i => $stok){
                    $modObatAlkesPasien->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
                    $modObatAlkesPasien->obatalkes_id = $stok->obatalkes_id;
                    $modObatAlkesPasien->qty_oa = $stok->qtystok_terpakai;
                    $modObatAlkesPasien->harganetto = $stok->HPP;
                    $modObatAlkesPasien->hargasatuan = $stok->getHargaJualSatuan($penjamin_id);
                    $modObatAlkesPasien->qty_stok = $stok->qtystok;
                    $modObatAlkesPasien->hargajual = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
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
                    $modObatAlkesPasien->obatalkes_nama = $stok->obatalkes->obatalkes_nama;
                    $modObatAlkesPasien->ruangan_id = $ruangan_id;
                    
                    $form .= $this->renderPartial($this->path_view.'_formAddPemakaianBahan', array('modObatAlkesPasien'=>$modObatAlkesPasien,'modDaftartindakan'=>$modDaftartindakan,'modPendaftaran'=>$modPendaftaran), true);
                }
            }else{
                $pesan = "Stok tidak mencukupi!";
            }
             * 
             */

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  /**
   * simpan BKObatalkesPasienT
   * @param type $modPendaftaran
   * @param type $stokOa
   * @param type $postObatAlkesPasien
   * @return \BKObatalkesPasienT
   */
  public function savePemakaianBahan($modPendaftaran, $stokOa, $tindakan, $postBmhp)
  {
    $modPakaiBahan = new PJObatalkesPasienT;
    $modPakaiBahan->attributes = $stokOa->attributes;
    $modPakaiBahan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modPakaiBahan->penjamin_id = $modPendaftaran->penjamin_id;
    $modPakaiBahan->carabayar_id = $modPendaftaran->carabayar_id;
    $modPakaiBahan->pasien_id = $modPendaftaran->pasien_id;
    $modPakaiBahan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPakaiBahan->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
    $modPakaiBahan->pasienmasukpenunjang_id = $_POST['pasienmasukpenunjang_id'];
    $modPakaiBahan->tipepaket_id = $tindakan->tipepaket_id;
    $modPakaiBahan->pegawai_id = $modPendaftaran->pegawai_id;
    $modPakaiBahan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modPakaiBahan->shift_id = Yii::app()->user->getState('shift_id');
    $modPakaiBahan->tglpelayanan = date('Y-m-d H:i:s');
    $modPakaiBahan->create_time = date('Y-m-d H:i:s');
    $modPakaiBahan->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modPakaiBahan->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
    $modPakaiBahan->oa = Params::OBATALKESPASIEN_BMHP;
    foreach ($postBmhp as $i => $postDetail) {
      if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
        $modPakaiBahan->daftartindakan_id = $postDetail['daftartindakan_id'];
        $modPakaiBahan->sumberdana_id = $postDetail['sumberdana_id'];
        $modPakaiBahan->hargajual_oa = $postDetail['subtotal'];
        $modPakaiBahan->harganetto_oa = $postDetail['harganetto'];
        $modPakaiBahan->hargasatuan_oa = $postDetail['hargasatuan'];
        $modPakaiBahan->satuankecil_id = $postDetail['satuankecil_id'];
        $modPakaiBahan->obatalkes_id = $postDetail['obatalkes_id'];
        $modPakaiBahan->qty_oa = $postDetail['qty'];
      }
    }

    if ($modPakaiBahan->save()) {
      $this->successSavePemakaianBahan &= true;
    } else {
      $this->successSavePemakaianBahan &= false;
    }
    return $modPakaiBahan;
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

  /**
   * untuk mengurangi stock
   * @param type $qty
   * @param type $idobatAlkes
   */
  protected function kurangiStok($qty, $idobatAlkes)
  {
    $sql = "SELECT stokobatalkes_id,qtystok_in,qtystok_out,qtystok_current FROM stokobatalkes_t WHERE obatalkes_id = $idobatAlkes ORDER BY tglstok_in";
    $stoks = Yii::app()->db->createCommand($sql)->queryAll();
    $selesai = false;
    if (count((array)$stoks) > 0) {
      foreach ($stoks as $i => $stok) {
        echo "a";
        exit;
        if ($qty <= $stok['qtystok_current']) {
          echo "b";
          exit;
          $stok_current = $stok['qtystok_current'] - $qty;
          $stok_out = $stok['qtystok_out'] + $qty;
          StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('qtystok_current' => $stok_current, 'qtystok_out' => $stok_out));
          $selesai = true;
          break;
        } else {
          echo "c";
          exit;
          $qty = $qty - $stok['qtystok_current'];
          $stok_current = 0;
          $stok_out = $stok['qtystok_out'] + $stok['qtystok_current'];
          StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('stok_current' => $stok_current, 'qtystok_out' => $stok_out));
        }
      }
    }
  }

  /**
   * untuk mengembalikan stok
   * @param type $obatAlkesT
   */
  protected function kembalikanStok($obatAlkesT)
  {
    foreach ($obatAlkesT as $i => $obatAlkes) {
      $stok = new PJStokObatalkesT;
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
      if ($tipepaket_id == Params::TIPEPAKET_ID_LUARPAKET) {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
        if (Yii::app()->user->getState('tindakanruangan')) {
          $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
        }
        if (Yii::app()->user->getState('tindakankelas')) {
          $criteria->compare('kelaspelayanan_id', $kelaspelayanan_id);
          $criteria->compare('tipepaket_id', Params::TIPEPAKET_ID_LUARPAKET);
        }
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
      } else if ($tipepaket_id == Params::TIPEPAKET_ID_NONPAKET) {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
        $criteria->compare('kelaspelayanan_id', $kelaspelayanan_id);
        $criteria->order = 'daftartindakan_nama';

        if (isset($_GET['daftartindakan_id'])) {
          $criteria->compare('daftartindakan_id', $_GET['daftartindakan_id']);
        }

        if (Yii::app()->user->getState('tindakankelas')) {
          $criteria->compare('kelaspelayanan_id', $kelaspelayanan_id);
        }

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

        if (Yii::app()->user->getState('tindakanruangan')) {
          $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
        }

        if (Yii::app()->user->getState('tindakankelas')) {
          $criteria->compare('kelaspelayanan_id', $kelaspelayanan_id);
        }

        $criteria->compare('tipepaket_id', $tipepaket_id);
        $criteria->compare('kelaspelayanan_id', $kelaspelayanan_id);
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
   * untuk menambahkan / menampilkan daftar tindakan
   */
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

  /**
   * untuk menambahkan alat pemakaian
   */
  public function actionAddFormPemakaianAlat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $alatmedis_id = $_POST['alatmedis_id'];
      $daftartindakan_id = $_POST['daftartindakan_id'];
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

  /**
   * untuk mencari dokter di autocomplete
   */
  public function actionGetDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      if (isset($_GET['term'])) {
        $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      }
      //$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
      $criteria->limit = 5;
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
   * untuk mencari bidan di autocomplete
   */
  public function actionGetBidan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      //$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->pegawai_id;
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
      //$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk mencari perawat di autocomplete
   */
  public function actionGetPerawat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      //$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
      $criteria->limit = 5;
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
   * untuk mencari paket bmhp di autocomplete
   */
  public function actionAutocompletePaketBMHP()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->with = array('obatalkes', 'daftartindakan', 'kelompokumur');
      $criteria->compare('LOWER(obatalkes.obatalkes_nama)', strtolower($_GET['term']), true);
      //$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
      $criteria->limit = 5;
      $models = PJPaketbmhpM::model()->findAll($criteria);
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
  public function actionAutocompletePemakaianBahan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
      //$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
      $criteria->addCondition('obatalkes_farmasi is true');
      $criteria->limit = 5;
      $models = PJObatAlkesM::model()->findAll($criteria);
      $returnVal = array();
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
   * untuk mencari pemakaian alat medis di autocomplete
   */
  public function actionAutocompletePemakaianAlatMedis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(alatmedis_nama)', strtolower($_GET['term']), true);
      //            $criteria->compare('instalasi_id', Yii::app()->user->getState('instalasi_id'));
      $criteria->limit = 5;
      $models = PJAlatmedisM::model()->findAll($criteria);
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
    $modStokOaNew->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($modStokOaNew->validateStok()) {
      $modStokOaNew->save();
      $modStokOaNew->setStokOaAktifBerdasarkanStok();
    } else {
      $this->stokobatalkestersimpan &= false;
    }
    return $modStokOaNew;
  }

  /**
   * 
   * @return intuntuk menghitung persen penjualan berdasarkan ruangan
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
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_pendaftaran
   * - no_rekam_medik
   * - nama_pasien
   */
  public function actionAutocompleteDaftarTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $tipepaket_id = isset($_GET['tipepaket_id']) ? $_GET['tipepaket_id'] : null;
      $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : null;
      $kelaspelayanan_id = isset($_GET['kelaspelayanan_id']) ? $_GET['kelaspelayanan_id'] : null;
      $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
      $daftartindakan_nama = isset($_GET['daftartindakan_nama']) ? $_GET['daftartindakan_nama'] : null;
      if (empty($daftartindakan_nama)) {
        $daftartindakan_nama = isset($_POST['daftartindakan_nama']) ? $_POST['daftartindakan_nama'] : null;
      }
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(daftartindakan_nama)', strtolower($daftartindakan_nama), true);
      $criteria->limit = 5;
      if ($tipepaket_id == Params::TIPEPAKET_ID_NONPAKET) {
        $criteria->addCondition('penjamin_id = ' . $penjamin_id);
        if (Yii::app()->user->getState('tindakankelas')) {
          $criteria->addCondition('kelaspelayanan_id = ' . $kelaspelayanan_id);
        }
        if (Yii::app()->user->getState('tindakanruangan')) {
          //                    RSSP-1333
          //                    $criteria->compare('ruangan_id',$ruangan_id);
          $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
          $models = TariftindakanperdaruanganV::model()->findAll($criteria);
        } else {
          $models = TariftindakanperdaV::model()->findAll($criteria);
        }
      } else {
        if (Yii::app()->user->getState('tindakanruangan')) {
          //                    RSSP-1333
          //                    $criteria->addCondition('ruangan_id = '.$ruangan_id);
          $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
        }
        if (Yii::app()->user->getState('tindakankelas')) {
          $criteria->addCondition('kelaspelayanan_id = ' . $kelaspelayanan_id);
        }
        $criteria->compare('tipepaket_id', $tipepaket_id);
        $criteria->addCondition('kelaspelayanan_id = ' . $kelaspelayanan_id);
        $models = PaketpelayananV::model()->findAll($criteria);
      }
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->daftartindakan_nama . " - " . $format->formatUang($model->harga_tariftindakan);
        $returnVal[$i]['value'] = $model->daftartindakan_nama;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * untuk menampilkan data dokter
   */
  public function actionAutocompleteDokterPemeriksa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
      $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;

      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->compare('ruangan_id', $ruangan_id);
      $criteria->limit = 5;
      $models = PJDokterV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->NamaLengkap;
        $returnVal[$i]['value'] = $model->NamaLengkap;
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
        $models = BKInformasikasirrawatjalanV::model()->findAll($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RD || $instalasi == Params::INSTALASI_ID_PERSALINAN) {
        $criteria->addCondition("DATE(tglpulang) = '" . date("Y-m-d") . "'");
        $models = BKInformasikasirrdpulangV::model()->findAll($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RI) {
        $criteria->addCondition("DATE(tglpulang) = '" . date("Y-m-d") . "'");
        $models = BKInformasikasirinappulangV::model()->findAll($criteria);
      }
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
        $returnVal[$i]['value'] = $model->no_pendaftaran;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAddFormPaketBmhp()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $kelumur_id = (isset($_POST['kelumur_id']) ? $_POST['kelumur_id'] : null);
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
      $daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : null);
      $modPaketBmhp = PaketbmhpM::model()->with('daftartindakan', 'obatalkes')->findAllByAttributes(array(
        'daftartindakan_id' => $daftartindakan_id,
        'kelompokumur_id' => $kelumur_id,
      ));
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modObatAlkesPasien = new PJObatalkesPasienT;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modDaftartindakan = DaftartindakanM::model()->findByPk($daftartindakan_id);
      $persenjual = $this->persenJualRuangan();
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

      foreach ($modPaketBmhp as $j => $paket) {
        $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($paket->obatalkes_id, $paket->qtypemakaian, $ruangan_id);
        if (count((array)$modStokOAs) > 0) {
          foreach ($modStokOAs as $i => $stok) {
            $modObatAlkesPasien->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
            $modObatAlkesPasien->daftartindakan_id = $paket->daftartindakan_id;
            $modObatAlkesPasien->daftartindakan_nama = $paket->daftartindakan->daftartindakan_nama;
            $modObatAlkesPasien->obatalkes_id = $stok->obatalkes_id;
            $modObatAlkesPasien->stokobatalkes_id = $stok->stokobatalkes_id;
            $modObatAlkesPasien->obatalkes_nama = $stok->obatalkes->obatalkes_nama;
            $modObatAlkesPasien->qtypemakaian = $stok->qtystok_terpakai;
            $modObatAlkesPasien->hargapemakaian = $paket->hargapemakaian;
            $modObatAlkesPasien->harganetto_oa = $stok->HPP;
            $modObatAlkesPasien->hargasatuan_oa = $stok->getHargaJualSatuan($penjamin_id);
            $modObatAlkesPasien->qty_stok = $stok->qtystok;
            $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
            $modObatAlkesPasien->stokobatalkes_id = $stok->stokobatalkes_id;
            $modObatAlkesPasien->hargajual = floor(($persenjual + 100) / 100 * $modObatAlkesPasien->hargajual);
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

            $form .= $this->renderPartial($this->path_view . '_formAddPaketBmhp', array(
              'paketBmhp' => $modObatAlkesPasien, 'modDaftartindakan' => $modDaftartindakan,
              'modPendaftaran' => $modPendaftaran
            ), true);
          }
        } else {
          $pesan = "Obat : " . $paket->obatalkes->obatalkes_nama . " Stok tidak mencukupi!";
        }
      }
      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_rekam_medik
   */
  public function actionAutocompletePasienJenazah()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_rekam_medik = isset($_GET['term']) ? $_GET['term'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->limit = 5;
      $models = PJPasienmasukpenunjangV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
        $returnVal[$i]['value'] = $model->pendaftaran_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAjaxDeleteTindakanPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idTindakanpelayanan = $_POST['idTindakanpelayanan'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $obatAlkesT = PJObatalkesPasienT::model()->findAllByAttributes(
          array(
            'tindakanpelayanan_id' => $idTindakanpelayanan
          )
        );
        $data['success'] = true;
        if (count((array)$obatAlkesT) > 0) {
          $this->kembalikanStok($obatAlkesT);
          $deleteObatPasien = PJObatalkesPasienT::model()->deleteAllByAttributes(
            array(
              'tindakanpelayanan_id' => $idTindakanpelayanan
            )
          );
          $deleteTindakan = PJTindakanPelayananT::model()->deleteByPk($idTindakanpelayanan);
          if (!$deleteObatPasien) {
            $data['success'] = false;
          }
        } else {
          $deleteTindakan = PJTindakanPelayananT::model()->deleteByPk($idTindakanpelayanan);
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

  /**
   * simpan PIObatalkesPasienT
   * @param type $modPendaftaran
   * @param type $post
   * @return \PIObatalkesPasienT
   */
  public function simpanObatAlkesPasien2($modPendaftaran, $postObatAlkesPasien)
  {


    $modObatAlkesPasien = new PJObatalkesPasienT();
    $modObatAlkesPasien->attributes = $postObatAlkesPasien;
    $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
    $modObatAlkesPasien->qty_oa = $postObatAlkesPasien['qty'];
    $modObatAlkesPasien->harganetto_oa = $postObatAlkesPasien['harganetto'];
    $modObatAlkesPasien->hargasatuan_oa = $postObatAlkesPasien['hargajual'];
    $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
    $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    $modObatAlkesPasien->ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modObatAlkesPasien->pasienmasukpenunjang_id = null;
    $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modObatAlkesPasien->carabayar_id = $modPendaftaran->carabayar_id;
    $modObatAlkesPasien->penjamin_id = $modPendaftaran->penjamin_id;
    $modObatAlkesPasien->pegawai_id = $modPendaftaran->pegawai_id;
    $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
    $modObatAlkesPasien->pasien_id = $modPendaftaran->pasien_id;
    $modObatAlkesPasien->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modObatAlkesPasien->tglpelayanan = date('Y-m-d H:i:s');
    $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modObatAlkesPasien->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modObatAlkesPasien->create_time = date('Y-m-d H:i:s');



    //var_dump($postObatAlkesPasien);
    // var_dump($modObatAlkesPasien->attributes);

    //die;

    //$modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
    //$modObatAlkesPasien->qty_stok = $stokOa->qtystok;
    //$modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
    //$modObatAlkesPasien->hargasatuan_oa = $stokOa->HargaJualSatuan;
    //$modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
    $modObatAlkesPasien->oa = Params::OBATALKESPASIEN_BMHP;
    //foreach ($postObatAlkesPasien AS $i => $postDetail) {
    //   if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
    //	   $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];                
    //	   $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];                
    //	   $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
    //	   $modObatAlkesPasien->iurbiaya = $postDetail['iurbiaya'];
    //   }
    //}

    if ($modObatAlkesPasien->save()) {
      PendaftaranT::model()->updateByPk(
        $modPendaftaran->pendaftaran_id,
        array(
          'pembayaranpelayanan_id' => null
        )
      );
      $this->successSavePemakaianBahan &= true;
    } else {
      $this->successSavePemakaianBahan &= false;
    }
    return $modObatAlkesPasien;
  }

  protected function simpanStokObatAlkesOut2($modObatAlkesPasien)
  {
    $format = new MyFormatter;
    //$modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $oa = ObatalkesM::model()->findByPk($modObatAlkesPasien->obatalkes_id);
    // var_dump($modObatAlkesPasien->attributes);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $oa->attributes;
    $modStokOaNew->attributes = $modObatAlkesPasien->attributes; //duplicate
    //$modStokOaNew->unsetIdTransaksi();
    $modStokOaNew->qtystok_in = 0;
    $modStokOaNew->qtystok_out = ceil($modObatAlkesPasien->qty_oa); // LNG Ceil (Pembulatan keatas request pak tito)
    $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
    //$modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = $modStokOaNew->tglterima = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

    //$modStokOaNew->validate();
    //var_dump($modStokOaNew->errors); 

    //var_dump($modStokOaNew->attributes); die;

    if ($modStokOaNew->validate()) {
      $this->stokobatalkestersimpan &= $modStokOaNew->save();
      // $modStokOaNew->setStokOaAktifBerdasarkanStok();
    } else {
      $this->stokobatalkestersimpan &= false;
    }

    // var_dump($this->stokobatalkestersimpan);

    return $modStokOaNew;
  }
}
