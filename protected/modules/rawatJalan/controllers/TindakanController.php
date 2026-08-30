<?php

class TindakanController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  public $succesSave = false;
  protected $successSaveBmhp = true;
  protected $successSavePemakaianBahan = true;
  protected $stokobatalkestersimpan = true;
  protected $statusSaveKirimkeUnitLain = true;
  protected $statusSavePermintaanPenunjang = true;
  protected $path_view = 'rawatJalan.views.tindakan.';

  public function actionIndex($pendaftaran_id)
  {
    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id'); //RND-6244
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);

    $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id')) ? null : KonsulpoliT::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
    ), array(
      'order' => 'tglkonsulpoli desc',
    ));

    if (!empty($konsul)) {
      if (!empty($konsul->pegawai_id)) {
        $modPendaftaran->pegawai_id = $konsul->pegawai_id;
      }
      $modPendaftaran->ruangan_id = $konsul->ruangan_id;
    }

    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modViewTindakans = RJTindakanPelayananT::model()
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
        'tipePaket',
        'alatmedis'
      )
      ->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id), array(
        'condition'=>'daftartindakan.daftartindakan_akomodasi = false'
      ));
    $modTindakans = null;
    $modTindakan = new RJTindakanPelayananT;
    $modTindakan->tarifcyto_tindakan = 0;
    $modTindakan->dokterpemeriksa1_id = $modPendaftaran->pegawai_id;
    $modTindakan->dokterpemeriksa1Nama = $modPendaftaran->pegawai->NamaLengkap;
    
    if(!empty($modPendaftaran->admisi)) {
      $modTindakan->dokterpemeriksa1_id = $modPendaftaran->admisi->dokterpenerima_id;
      $modTindakan->dokterpemeriksa1Nama = $modPendaftaran->admisi->dokpenerima->NamaLengkap;
    }
    
    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id = ' . $modPendaftaran->penjamin_id);
    $models = new RJPaketpelayananV();
    
    if (isset($_POST['RJTindakanPelayananT']) || isset($_POST['TindakanpelayananT'])) {
      // $transaction = Yii::app()->db->beginTransaction();

      try {

        $modTindakans = $this->saveTindakan($modPasien, $modPendaftaran);

        // var_dump($this->succesSave); die;

        // echo '<pre>';
        // var_dump($this->statusSavePermintaanPenunjang, $this->statusSaveKirimkeUnitLain, $this->successSaveBmhp, $this->successSavePemakaianBahan, $this->stokobatalkestersimpan);
        // die;
        
  
        if ($this->succesSave) {
          // $transaction->commit();
          Yii::app()->user->setFlash('success', "Data tindakan berhasil disimpan");
          $this->redirect(array($this->id . '/', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
        } else {
            // $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan <br>");
        }

      } catch (Exception $exc) {
        // echo '<pre>'; var_dump($exc); die; 
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        // $transaction->rollback();

      }
      
    }

    // if(isset($_GET['ajax'])) {
    //   if($_GET['ajax'] == 'giladiagnosa-m-grid2') {
    //     var_dump($_GET);die;
    //   }
    // }
    
    $modViewBmhp = RJObatalkesPasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    // echo '<pre>'; var_dump($modTindakans); die;
    if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_HEMO) {
      $this->render($this->path_view . 'indexHemo', array(
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
        'modTindakans' => $modTindakans,
        'modTindakan' => $modTindakan,
        'modViewTindakans' => $modViewTindakans,
        'modViewBmhp' => $modViewBmhp, 'models' => $models,
        'modJenisTarif' => $modJenisTarif
      ));
  } else {

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modTindakans' => $modTindakans,
      'modTindakan' => $modTindakan,
      'modViewTindakans' => $modViewTindakans,
      'modViewBmhp' => $modViewBmhp, 'models' => $models,
      'modJenisTarif' => $modJenisTarif
    ));
  }
}

  public function saveTindakan($modPasien, $modPendaftaran)
  {

    $post = (isset($_POST['TindakanpelayananT'])) ? $_POST['TindakanpelayananT'] : $_POST['RJTindakanPelayananT'];

    $ruangan_id = Yii::app()->user->getState('ruangan_id');

    $md_noawal = TindakanpelayananT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id AND nopelayanan IS NOT NULL order by nopelayanan DESC");

    if(!empty($md_noawal)) {
      $noawal = intval($md_noawal->nopelayanan);
    } else {
      $noawal = 1;
    }

    $pasienadmisi_id = null;
    if (!empty($modPendaftaran->pasienadmisi_id) && in_array(Yii::app()->user->getState('instalasi_id'), Params::grupInstalasiRIID())) {
      $pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
    }


    $valid = true; //echo $_POST['RJTindakanPelayananT'][0]['tipepaket_id'];exit;
    foreach ($post as $i => $item) {

      // echo '<pre>';
      // var_dump($modPendaftaran->jeniskasuspenyakit_id); die;
      if (!empty($item) && (!empty($item['daftartindakan_id']))) {
        $modTindakans[$i] = new RJTindakanPelayananT;
        $modTindakans[$i]->attributes = $item;
        $modTindakans[$i]->tipepaket_id = $_POST['RJTindakanPelayananT'][0]['tipepaket_id'];
        $modTindakans[$i]->pasien_id = $modPasien->pasien_id;
        // $modTindakans[$i]->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
        $modTindakans[$i]->carabayar_id = $modPendaftaran->carabayar_id;
        $modTindakans[$i]->penjamin_id = $modPendaftaran->penjamin_id;
        $modTindakans[$i]->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
        $modTindakans[$i]->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modTindakans[$i]->keterangantindakan = empty($item['keterangantindakan']) ? null : $item['keterangantindakan'];
        //                    $modTindakans[$i]->tgl_tindakan = $item['tgl_tindakan'];
        $modTindakans[$i]->tgl_tindakan = $modTindakans[0]->tgl_tindakan;
        $modTindakans[$i]->shift_id = Yii::app()->user->getState('shift_id');
        $modTindakans[$i]->pasienadmisi_id = $modPendaftaran->pasienadmisi_id ?? null;

        // if ($modTindakans[$i]->tipepaket_id == Params::TIPEPAKET_ID_NONPAKET)
        //   $modTindakans[$i]->tarif_satuan = $modTindakans[$i]->getTarifSatuan(); //RND-7250

        // $modTindakans[$i]->tarif_tindakan = $modTindakans[$i]->tarif_satuan * $modTindakans[$i]->qty_tindakan;
        // if ($item['cyto_tindakan'])
        //   $modTindakans[$i]->tarifcyto_tindakan = ($item['persenCyto'] / 100) * $modTindakans[$i]->tarif_tindakan;
        // else
        //   $modTindakans[$i]->tarifcyto_tindakan = 0;
        $modTindakans[$i]->discount_tindakan = 0;
        //$modTindakans[$i]->subsidiasuransi_tindakan = 0;
        //$modTindakans[$i]->subsidipemerintah_tindakan = 0;
        //$modTindakans[$i]->subsisidirumahsakit_tindakan = 0;
        //$modTindakans[$i]->iurbiaya_tindakan = 0;
        $modTindakans[$i]->ruangan_id =  isset($item['ruangan_id']) ? $item['ruangan_id'] : Yii::app()->user->getState('ruangan_id'); // RND-6244
        $modTindakans[$i]->instalasi_id = $modTindakans[$i]->ruangan->instalasi_id;
        $modTindakans[$i]->alatmedis_id = $this->cekAlatmedis($modTindakans[$i]->daftartindakan_id);

        if (empty($modTindakans[$i]->kelaspelayanan_id)) {
            $modTindakans[$i]->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
        }

        $modTindakans[$i]->nopelayanan = str_pad($noawal+1,3,"0",STR_PAD_LEFT);
        
        $valid = $modTindakans[$i]->validate() && $valid;
       
        // var_dump($modTindakans[$i]->attributes);
      }
    }




    // die;

    $transaction = Yii::app()->db->beginTransaction();
    try {
      if ($valid && (count((array)$modTindakans) > 0)) {


        foreach ($modTindakans as $i => $tindakan) {



          // var_dump($tindakan->attributes); // die;

          if ($tindakan->save()) {
            // if ($tindakan->ruangan_id == Params::RUANGAN_ID_BEDAH || $tindakan->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK || $tindakan->ruangan_id == Params::RUANGAN_ID_RAD){
            //     $this->simpanPasienKirimKeUnitLain($tindakan);
            // }
            $statusSaveKomponen = $tindakan->saveTindakanKomponen();

            /*
                         * // tracing
                        $komponen = TindakankomponenT::model()->findAllByAttributes(array(
                            'tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id,
                        ));

                        foreach ($komponen as $item) {
                            var_dump($item->attributes);
                        }
                         *
                         */
          }

          // echo '<pre>'; var_dump($valid, count((array)$modTindakans), $tindakan->save()); die;


          // die;
          if (isset($_POST['paketBmhp'])) {
            if (count((array)$_POST['paketBmhp']) > 0) {
              //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jumlah pesan
              $detailGroups = array();
              foreach ($_POST['paketBmhp'] as $i => $postDetail) {
                $modDetails[$i] = new RJObatalkesPasienT();
                $modDetails[$i]->attributes = $postDetail;
                $modDetails[$i] = $this->savePaketBmhp2($modPendaftaran, $postDetail, $tindakan);
                $this->simpanStokObatAlkesOut2($modDetails[$i]);
              }
              //END GROUP
            }
          }
          //var_dump($this->stokobatalkestersimpan);
          //die;
          if (isset($_POST['pemakaianBahan'])) {
            if (count((array)$_POST['pemakaianBahan']) > 0) {
              //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jumlah pesan
              $detailGroups = array();
              foreach ($_POST['pemakaianBahan'] as $i => $postDetail) {
                $modDetails[$i] = new RJObatalkesPasienT();
                $modDetails[$i]->attributes = $postDetail;
                $modDetails[$i] = $this->savePemakaianBahan2($modPendaftaran, $postDetail, $tindakan);
                $this->simpanStokObatAlkesOut2($modDetails[$i]);
                /*
								$modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
								$modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
								$obatalkes_id = $postDetail['obatalkes_id'];
								if(isset($detailGroups[$obatalkes_id])){
									$detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
								}else{
									$detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
									$detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
								}*/
              }
              //END GROUP
            }
            /*
						$obathabis = "";
						//PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
						foreach($detailGroups AS $i => $detail){
							$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
							if(count((array)$modStokOAs) > 0){
								foreach($modStokOAs AS $i => $stok){
									$modDetails[$i] = $this->savePemakaianBahan($modPendaftaran,$stok, $_POST['pemakaianBahan'],$tindakan);
									$this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
								}
							}else{
								$this->stokobatalkestersimpan &= false;
								$obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;

							}
						}
                                                 *
                                                 */
            //						$modPemakainBahans = $this->savePemakaianBahan($modPendaftaran, $_POST['pemakaianBahan'],$tindakan);
          }
        }

        // TindakanpelayananT::model()->updateAll(array('nopelayanan' => '001'), 'nopelayanan is null and masukkamar_id is null');

        

        //  var_dump($this->stokobatalkestersimpan);die;
        if ($this->statusSavePermintaanPenunjang && $this->statusSaveKirimkeUnitLain && $statusSaveKomponen && $this->successSaveBmhp && $this->successSavePemakaianBahan && $this->stokobatalkestersimpan) {
          // echo "OK"; die;
            $p = PendaftaranT::model()->findByPk($modPendaftaran->pendaftaran_id);
          // $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SUDAH_DIPERIKSA);

          /* ================================================ */
          /* Proses update status periksa KonsulPoli EHS-179  */
          /* ================================================ */
          $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id'))); // RND-6244
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
      echo '<pre>'; var_dump($exc); die;
      $transaction->rollback();
      Yii::app()->user->setFlash('error', "Data Tindakan Pasien Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
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
        $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
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
      
        $modPermintaan = new RJPermintaanPenunjangT;
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

  protected function cekAlatmedis($idDaftartindakan)
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
    $data = array();
    if (Yii::app()->request->isAjaxRequest) {
      $idTindakanpelayanan = $_POST['idTindakanpelayanan'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $obatAlkesT = RJObatalkesPasienT::model()->findAllByAttributes(
          array(
            'tindakanpelayanan_id' => $idTindakanpelayanan
          )
        );
        $data['success'] = true;
        if (count((array)$obatAlkesT) > 0) {
          $this->kembalikanStok2($obatAlkesT);
          $deleteObatPasien = RJObatalkesPasienT::model()->deleteAllByAttributes(
            array(
              'tindakanpelayanan_id' => $idTindakanpelayanan
            )
          );
          $deleteTindakan = RJTindakanPelayananT::model()->deleteByPk($idTindakanpelayanan);
          if (!$deleteObatPasien) {
            $data['success'] = false;
          }
        } else {
          $deleteTindakan = RJTindakanPelayananT::model()->deleteByPk($idTindakanpelayanan);
        }
        // var_dump($data['success']); die;
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

  protected function savePaketBmhp2($modPendaftaran, $paketBmhp, $tindakan)
  {
    // var_dump($paketBmhp);
    $modObatAlkesPasien = new RJObatalkesPasienT();
    $modObatAlkesPasien->attributes = $paketBmhp;
    $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
    $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET; //$tindakan->tipepaket_id;
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

    //$modObatAlkesPasien->qty_oa = $paketBmhp['qtypemakaian']; //$stokOa->qtystok_terpakai;
    // $modObatAlkesPasien->qty_stok = //$stokOa->qtystok;
    //$modObatAlkesPasien->harganetto_oa = $paketBmhp['harganetto']; //$stokOa->HPP;
    //$modObatAlkesPasien->hargasatuan_oa = $paketBmhp['hargasatuan']; //$stokOa->HargaJualSatuan;
    //$modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
    $totalBmhp = 0;



    //foreach ($paketBmhp AS $i => $bmhp) {
    //	 if ($stokOa->obatalkes_id==$bmhp['obatalkes_id']) {
    $modObatAlkesPasien->sumberdana_id = $paketBmhp['sumberdana_id'];
    $modObatAlkesPasien->satuankecil_id = $paketBmhp['satuankecil_id'];
    $modObatAlkesPasien->qty_stok = $paketBmhp['qty_stok'];
    $modObatAlkesPasien->iurbiaya = $paketBmhp['subtotal'];
    $modObatAlkesPasien->qty_oa = $paketBmhp['qtypemakaian'];
    $modObatAlkesPasien->hargajual_oa = $paketBmhp['hargapemakaian'];
    $modObatAlkesPasien->harganetto_oa = $paketBmhp['harganetto'];
    $modObatAlkesPasien->hargasatuan_oa = $paketBmhp['hargasatuan']; //$bmhp['hargasatuan'];
    $modObatAlkesPasien->daftartindakan_id = $paketBmhp['daftartindakan_id'];
    $modObatAlkesPasien->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
    $totalBmhp = $totalBmhp + $paketBmhp['hargapemakaian'];
    //	 }
    //}

    //var_dump($modObatAlkesPasien->attributes);

    //var_dump($modObatAlkesPasien->validate());

    //var_dump($modObatAlkesPasien->errors);


    //die;
    if ($modObatAlkesPasien->save()) {
      $this->successSaveBmhp &= true;
      $totalBmhp = $totalBmhp + $tindakan->tarif_bhp;
      $tindakan->tarif_bhp = $totalBmhp;
      $tindakan->update();
    } else {
      $this->successSaveBmhp &= false;
    }

    // var_dump($this->successSaveBmhp); die;

    return $modObatAlkesPasien;
  }

  protected function savePemakaianBahan2($modPendaftaran, $pemakaianBahan, $tindakan)
  {
    // var_dump($pemakaianBahan);
    $modObatAlkesPasien = new RJObatalkesPasienT();
    $modObatAlkesPasien->attributes = $pemakaianBahan;
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


    //$modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
    //$modObatAlkesPasien->qty_stok = $stokOa->qtystok;
    //$modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
    $modObatAlkesPasien->hargasatuan_oa = floor($modObatAlkesPasien->hargajual_oa / $modObatAlkesPasien->qty_oa);
    //$modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
    $modObatAlkesPasien->oa = Params::OBATALKESPASIEN_BMHP;

    //foreach ($pemakaianBahan AS $i => $postDetail) {
    //   if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
    $modObatAlkesPasien->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
    $modObatAlkesPasien->sumberdana_id = $pemakaianBahan['sumberdana_id'];
    $modObatAlkesPasien->satuankecil_id = $pemakaianBahan['satuankecil_id'];
    $modObatAlkesPasien->daftartindakan_id = $pemakaianBahan['daftartindakan_id'];
    $modObatAlkesPasien->qty_stok = $pemakaianBahan['qty_stok'];
    $modObatAlkesPasien->iurbiaya = $pemakaianBahan['subtotal'];
    //}
    //}
    //echo "Kick";

    // var_dump($modObatAlkesPasien->attributes);

    //var_dump($modObatAlkesPasien->validate());
    //var_dump($modObatAlkesPasien->errors);

    // die;



    if ($modObatAlkesPasien->save()) {
      $this->successSavePemakaianBahan &= true;
    } else {
      $this->successSavePemakaianBahan &= false;
    }
    return $modObatAlkesPasien;
  }


  protected function savePaketBmhp($modPendaftaran, $stokOa, $paketBmhp, $tindakan)
  {
    $modObatAlkesPasien = new RJObatalkesPasienT();
    $modObatAlkesPasien->attributes = $stokOa->attributes;
    $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
    $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET; //$tindakan->tipepaket_id;
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
    $modObatAlkesPasien->hargasatuan_oa = $stokOa->HargaJualSatuan;
    $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
    $totalBmhp = 0;

    foreach ($paketBmhp as $i => $bmhp) {
      if ($stokOa->obatalkes_id == $bmhp['obatalkes_id']) {
        $modObatAlkesPasien->sumberdana_id = $bmhp['sumberdana_id'];
        $modObatAlkesPasien->satuankecil_id = $bmhp['satuankecil_id'];
        $modObatAlkesPasien->qty_stok = $bmhp['qty_stok'];
        $modObatAlkesPasien->iurbiaya = $bmhp['subtotal'];
        $modObatAlkesPasien->qty_oa = $bmhp['qtypemakaian'];
        $modObatAlkesPasien->hargajual_oa = $bmhp['hargapemakaian'];
        $modObatAlkesPasien->harganetto_oa = $bmhp['harganetto'];
        $modObatAlkesPasien->hargasatuan_oa = $bmhp['hargasatuan']; //$bmhp['hargasatuan'];
        $modObatAlkesPasien->daftartindakan_id = $bmhp['daftartindakan_id'];
        $modObatAlkesPasien->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
        $totalBmhp = $totalBmhp + $bmhp['hargapemakaian'];
      }
    }

    if ($modObatAlkesPasien->save()) {
      $this->successSaveBmhp &= true;
      $totalBmhp = $totalBmhp + $tindakan->tarif_bhp;
      $tindakan->tarif_bhp = $totalBmhp;
      $tindakan->update();
    } else {
      $this->successSaveBmhp &= false;
    }
    return $modObatAlkesPasien;
  }

  protected function savePemakaianBahan($modPendaftaran, $stokOa, $pemakaianBahan, $tindakan)
  {
    $modObatAlkesPasien = new RJObatalkesPasienT();
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
    $modObatAlkesPasien->hargasatuan_oa = $stokOa->HargaJualSatuan;
    $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
    $modObatAlkesPasien->oa = Params::OBATALKESPASIEN_BMHP;
    foreach ($pemakaianBahan as $i => $postDetail) {
      if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
        $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];
        $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];
        $modObatAlkesPasien->daftartindakan_id = $postDetail['daftartindakan_id'];
        $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
        $modObatAlkesPasien->iurbiaya = $postDetail['subtotal'];
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

  protected function simpanStokObatAlkesOut2($modObatAlkesPasien)
  {
    $format = new MyFormatter;
    //$modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $oa = ObatalkesM::model()->findByPk($modObatAlkesPasien->obatalkes_id);
    //var_dump($oa->attributes);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $oa->attributes;
    $modStokOaNew->attributes = $modObatAlkesPasien->attributes; //duplicate
    //$modStokOaNew->unsetIdTransaksi();
    $modStokOaNew->qtystok_in = 0;
    $modStokOaNew->qtystok_out = ceil($modObatAlkesPasien->qty_oa); // LNG Ceil (Pembulatan keatas request pak tito)
    $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
    $modStokOaNew->tglkadaluarsa = $oa->tglkadaluarsa;
    //$modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = $modStokOaNew->tglterima = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;
    //var_dump($modStokOaNew->tglkadaluarsa);
    //$modStokOaNew->validate();
    //var_dump($modStokOaNew->errors);

    // var_dump($modStokOaNew->attributes); die;

    if ($modStokOaNew->validate()) {
      $this->stokobatalkestersimpan &= $modStokOaNew->save();
      // $modStokOaNew->setStokOaAktifBerdasarkanStok();
    } else {
      $this->stokobatalkestersimpan &= false;
    }
    // var_dump($modStokOaNew->getErrors());die;
    // var_dump($this->stokobatalkestersimpan);

    return $modStokOaNew;
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
    $sql = "SELECT stokobatalkes_id,qtystok_in,qtystok_out FROM stokobatalkes_t WHERE obatalkes_id = $idobatAlkes ORDER BY tglstok_in";
    $stoks = Yii::app()->db->createCommand($sql)->queryAll();
    $selesai = false;
    //            while(!$selesai){
    foreach ($stoks as $i => $stok) {
      if ($qty <= $stok['qtystok_current']) {
        $stok_current = $stok['qtystok_current'] - $qty;
        $stok_out = $stok['qtystok_out'] + $qty;
        StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('qtystok_out' => $stok_out));
        $selesai = true;
        break;
      } else {
        $qty = $qty - $stok['qtystok_current'];
        $stok_current = 0;
        $stok_out = $stok['qtystok_out'] + $stok['qtystok_current'];
        StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('qtystok_out' => $stok_out));
      }
    }
    //            }
  }

  protected function kembalikanStok($obatAlkesT)
  {
    foreach ($obatAlkesT as $i => $obatAlkes) {
      $stok = new RJStokObatalkesT;
      $stok->obatalkes_id = $obatAlkes->obatalkes_id;
      $stok->ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id'); // RND-6244
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

  public function actionLoadFormTindakanPaket() {
        if (Yii::app()->request->isAjaxRequest) {
            $idTipePaket = (isset($_POST['idTipePaket']) ? $_POST['idTipePaket'] : null);
            if (empty($idTipePaket))
                $idTipePaket = (isset($_POST['tipepaket_id']) ? $_POST['tipepaket_id'] : null);

            $idKelasPelayanan = (isset($_POST['idKelasPelayanan']) ? $_POST['idKelasPelayanan'] : null);
            $idKelompokUmur = (isset($_POST['idKelompokUmur']) ? $_POST['idKelompokUmur'] : null);
            $idCarabayar = isset($_POST['idCarabayar']) ? $_POST['idCarabayar'] : null;
            $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;

            $modPaketTindakan = PaketpelayananV::model()->findAllByAttributes(array('tipepaket_id' => $idTipePaket));

            // print_r(count($modPaketTindakan)); die;

            $daftar = null;
            $peg = null;

            if (!empty($pendaftaran_id)) {
                $daftar = PendaftaranT::model()->findByPk($pendaftaran_id);
                if (!empty($daftar)) {
                    $peg = PegawaiM::model()->findByPk($daftar->pegawai_id);
                }
            }

            $modTindakans = array();
            $optionDaftarttindakan = '';
            if (isset($modPaketTindakan)) {
                if ($idTipePaket != Params::TIPEPAKET_ID_LUARPAKET) {
                    foreach ($modPaketTindakan as $i => $tindakan) {

                        $modTindakans[$i] = new RJTindakanPelayananT;
                        $modTindakans[$i]->daftartindakan_id = $tindakan->daftartindakan_id;
                        $modTindakans[$i]->daftartindakanNama = $tindakan->daftartindakan_nama;
                        $modTindakans[$i]->kategoriTindakanNama = $tindakan->kategoritindakan_nama;
                        $modTindakans[$i]->qty_tindakan = 1;
                        $modTindakans[$i]->persenCyto = 0;
                        $modTindakans[$i]->dokterpemeriksa1_id = empty($daftar) ? null : $daftar->pegawai_id;
                        $modTindakans[$i]->dokterpemeriksa1Nama = empty($peg) ? null : $peg->namaLengkap;
                        $modTindakans[$i]->kelaspelayanan_id = $tindakan->kelaspelayanan_id;
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
            if (!empty($idTipePaket)) {
                $criteria->addCondition("tipepaket_id = " . $idTipePaket);
            }
            if (!empty($idKelompokUmur)) {
                $criteria->addCondition("kelompokumur_id = " . $idKelompokUmur);
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
                'form' => $this->renderPartial($this->path_view . '_formLoadTindakanPaket', array(
                    'modPaketTindakan' => $modPaketTindakan,
                    'modTindakans' => $modTindakans,
                        ), true),
                'formPaketBmhp' => $this->renderPartial($this->path_view . '_formLoadPaketBmhp', array(
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
      $kelumur_id = (isset($_POST['kelumur_id']) ? $_POST['kelumur_id'] : null);
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : null);
      $modPaketBmhp = PaketbmhpM::model()->with('daftartindakan', 'obatalkes')->findAllByAttributes(array(
        'daftartindakan_id' => $daftartindakan_id,
        'kelompokumur_id' => $kelumur_id,
      ));
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modObatAlkesPasien = new RJObatalkesPasienT;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modDaftartindakan = DaftartindakanM::model()->findByPk($daftartindakan_id);
      $persenjual = $this->persenJualRuangan();
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);


      foreach ($modPaketBmhp as $j => $paket) {
        $oa = ObatalkesM::model()->findByPk($paket->obatalkes_id);
        $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($paket->obatalkes_id, $paket->qtypemakaian, $ruangan_id);
        //if(count((array)$modStokOAs) > 0){
        //	foreach($modStokOAs AS $i => $stok){
        $modObatAlkesPasien->sumberdana_id = $oa->sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
        $modObatAlkesPasien->daftartindakan_id = $paket->daftartindakan_id;
        $modObatAlkesPasien->daftartindakan_nama = $paket->daftartindakan->daftartindakan_nama;
        $modObatAlkesPasien->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
        $modObatAlkesPasien->stokobatalkes_id = null; //$stok->stokobatalkes_id;
        $modObatAlkesPasien->obatalkes_nama = $oa->obatalkes_nama; //$stok->obatalkes->obatalkes_nama;
        $modObatAlkesPasien->qtypemakaian = $paket->qtypemakaian; //$stok->qtystok_terpakai;
        $modObatAlkesPasien->hargapemakaian = $paket->hargapemakaian;
        $modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stok->HPP;
        $modObatAlkesPasien->hargasatuan_oa = $oa->hargajual; //$stok->HargaJualSatuan;
        $modObatAlkesPasien->qty_stok = 0; //$stok->qtystok;
        $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
        $modObatAlkesPasien->stokobatalkes_id = null; //$stok->stokobatalkes_id;
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
        $modObatAlkesPasien->satuankecil_id = $oa->satuankecil_id; //$stok->satuankecil_id;
        $modObatAlkesPasien->satuankecil_nama = $oa->satuankecil->satuankecil_nama; //$stok->satuankecil->satuankecil_nama;

        $form .= $this->renderPartial($this->path_view . '_formAddPaketBmhp', array(
          'paketBmhp' => $modObatAlkesPasien, 'modDaftartindakan' => $modDaftartindakan,
          'modPendaftaran' => $modPendaftaran
        ), true);
        //}
        //}else{
        //	$pesan = "Obat : ". $paket->obatalkes->obatalkes_nama." Stok tidak mencukupi!"	;
        //}

      }
      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  public function actionSetFormPemakaianBahan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $obatalkes_id = (isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null);
      $daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : "");
      $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : 1;
      $ruangan_id = Yii::app()->user->getState('ruangna_id');
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modObatAlkesPasien = new RJObatalkesPasienT;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
      $oa = ObatalkesM::model()->findByPk($obatalkes_id);
      $modDaftartindakan = DaftartindakanM::model()->findByPk($daftartindakan_id);
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $persenjual = $this->persenJualRuangan();
      //if(count((array)$modStokOAs) > 0){

      //foreach($modStokOAs AS $i => $stok){
      $modObatAlkesPasien->sumberdana_id = $oa->sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
      $modObatAlkesPasien->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
      $modObatAlkesPasien->stokobatalkes_id = null; //$stok->stokobatalkes_id;
      $modObatAlkesPasien->obatalkes_nama = $oa->obatalkes_nama; // $stok->obatalkes->obatalkes_nama;
      $modObatAlkesPasien->qty_oa = $jumlah; //$stok->qtystok_terpakai;
      $modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stok->HPP;
      $modObatAlkesPasien->hargasatuan_oa = $oa->hargajual; //$stok->HargaJualSatuan;
      $modObatAlkesPasien->qty_stok = 0; //$stok->qtystok;
      $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
      $modObatAlkesPasien->stokobatalkes_id = null; //$stok->stokobatalkes_id;
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
      $modObatAlkesPasien->satuankecil_id = $oa->satuankecil_id; //$stok->satuankecil_id;
      $modObatAlkesPasien->satuankecil_nama = $oa->satuankecil->satuankecil_nama; //$stok->satuankecil->satuankecil_nama;

      $form .= $this->renderPartial($this->path_view . '_formAddPemakaianBahan', array(
        'modObatAlkesPasien' => $modObatAlkesPasien, 'modDaftartindakan' => $modDaftartindakan,
        'modPendaftaran' => $modPendaftaran,
      ), true);
      //}
      //}else{
      //	$pesan = "Stok tidak mencukupi!"	;
      //}

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  public function actionAddFormPemakaianAlat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idAlat = $_POST['idAlat'];
      $idDaftartindakan = $_POST['idDaftartindakan'];
      $modAlat = AlatmedisM::model()->findByPk($idAlat);
      $modDaftartindakan = DaftartindakanM::model()->findByPk($idDaftartindakan);
      $modObatAlkes = new ObatalkesM;
      echo CJSON::encode(array(
        'daftarTinNama' => $modDaftartindakan->daftartindakan_nama,
        'namaAlat' => $modAlat->alatmedis_nama,
        'form' => $this->renderPartial($this->path_view . '_formAddPemakaianAlat', array(
          'modAlat' => $modAlat, 'modDaftartindakan' => $modDaftartindakan, 'modObatAlkes' => $modObatAlkes
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
   * action ajax select no pelayanan berdasarkan pendaftaran ke form
   */

  public function actionPelayanan()
	{
    if(Yii::app()->request->isAjaxRequest) {
        $criteria = new CDbCriteria();
        $criteria->select = 'p.no_pendaftaran, t.nopelayanan, concat(t.nopendaftaran, t.nopelayanan) as no_nota';
        $criteria->join = 'join pendaftaran_t p on t.pendaftaran_id = p.pendaftaran_id';

        $criteria->compare('LOWER(t.nopelayanan)', strtolower($_GET['term']), true);
        $criteria->compare('LOWER(p.no_pendaftaran)', strtolower($_GET['term']), true, 'OR');

        $criteria->order = 'nopelayanan';
        $criteria->limit = 5;
        $models = TindakanpelayananT::model()->findAll($criteria);
        foreach($models as $i=>$model)
        {
            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal[$i]["$attribute"] = $model->$attribute;
            }
            $returnVal[$i]['label'] = $model->daftartindakan_nama;
            $returnVal[$i]['value'] = $model->daftartindakan_id;
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
      $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id'); // RND-6244
      $kelaspelayanan_id = (isset($_GET['kelaspelayanan_id']) ? $_GET['kelaspelayanan_id'] : null);
      $tipepaket_id = (isset($_GET['tipepaket_id']) ? $_GET['tipepaket_id'] : null);
      $penjamin_id = (isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null);
      $dokter_id = (isset($_GET['dokter_id']) ? $_GET['dokter_id'] : null);



      $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $penjamin_id);
      if ($tipepaket_id == Params::TIPEPAKET_ID_LUARPAKET) {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
        if (Yii::app()->user->getState('tindakanruangan')) {
          $criteria->addCondition('ruangan_id = ' . $ruangan_id); // RND-6244
        }
        if (Yii::app()->user->getState('tindakankelas')) {
          if (!empty($kelaspelayanan_id)) {
            $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
          }
          $criteria->addCondition('tipepaket_id', Params::TIPEPAKET_ID_LUARPAKET);
        }
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
        // if (!empty($kelaspelayanan_id)) {
        //   $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
        // }
        if (!empty($penjamin_id)) {
          $criteria->addCondition("penjamin_id = " . $penjamin_id);
        }
        $criteria->order = 'daftartindakan_nama';

        if (isset($_GET['daftartindakan_id'])) {
          if (!empty($_GET['daftartindakan_id'])) {

            // $dt = DaftartindakanM::model()->findByPk($_GET['daftartindakan_id']);
            $criteria->addCondition("daftartindakan_id = " . $_GET['daftartindakan_id']);
            // $criteria->addCondition("daftartindakan_nama = '" . $dt->daftartindakan_nama . "'");
          }
        }

        // if (Yii::app()->user->getState('tindakankelas')) {
          if (!empty($kelaspelayanan_id)) {
            $criteria->addCondition("kelaspelayanan_id =" . $kelaspelayanan_id);
          }
        // }

        // if (!empty($_GET['dokter_id'])) {
        //   $peg = PegawaiM::model()->findByPk($_GET['dokter_id']);
        //   $criteria->compare("jeniswaktukerja" , ((!empty($peg)) ? $peg->jeniswaktukerja : null), false);
        // }

        // if (Yii::app()->user->getState('tindakanruangan')) {
          // $criteria->addCondition('ruangan_id = ' . $ruangan_id);

          $models = TariftindakanperdaruanganV::model()->findAll($criteria);
        // } else {
        //   $models = TariftindakanperdaV::model()->findAll($criteria);
        // }
        $returnVal = array();
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->daftartindakan_nama;
          $returnVal[$i]['value'] = $model->daftartindakan_id;
        }

        // echo '<pre>'; var_dump($returnVal[0], 'tes 123', count($models)); die;


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
          // $criteria->addCondition('ruangan_id = ' . $ruangan_id);
        }

        if (Yii::app()->user->getState('tindakankelas')) {
          if (!empty($kelaspelayanan_id)) {
            $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
          }
        }

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
   * untuk mencari dokter di autocomplete
   */
  public function actionGetDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      if (isset($_GET['term'])) {
        $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      }
      $criteria->order = 'nama_pegawai';
      if (isset($_GET['idPegawai'])) {
        if (!empty($_GET['idPegawai'])) {
          $criteria->addCondition("pegawai_id = " . $_GET['idPegawai']);
        }
      }

      if (isset($_POST['id'])) {
        $criteria->compare("pegawai_id", $_POST['id']);
      }


      $models = DokterpegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['nama_pegawai'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk mencari dokter + perawat di autocomplete
   */
  public function actionGetDokterPerawat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      if (isset($_GET['term'])) {
        $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      }
      $criteria->order = 'nama_pegawai';
      if (isset($_GET['idPegawai'])) {
        if (!empty($_GET['idPegawai'])) {
          $criteria->addCondition("pegawai_id = " . $_GET['idPegawai']);
        }
      }

      if (isset($_POST['id'])) {
        $criteria->compare("pegawai_id", $_POST['id']);
      }

      $criteria->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK, Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_BIDAN));


      $models = PegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['nama_pegawai'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk mencari bidan di autocomplete
   */
  public function actionGetBidan($term = null)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($term), true);
      $criteria->order = 'nama_pegawai';

      if (isset($_POST['id']))
        $criteria->compare('pegawai_id', $_POST['id']);

      $models = PegawaiM::model()->findAll($criteria);
      $returnVal = array();
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
      $criteria->order = 'nama_pegawai';
      $models = PegawaiM::model()->findAll($criteria);
      $returnVal = array();
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
  public function actionGetPerawat($term = null)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($term), true);
      $criteria->order = 'nama_pegawai';

      if (isset($_POST['id'])) {
        $criteria->compare('pegawai_id', $_POST['id']);
      }

      // print_r($criteria); die;

      $models = PegawaiM::model()->findAll($criteria);
      $returnVal = array();
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
  public function actionPaketBMHP()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->with = array('obatalkes', 'daftartindakan', 'kelompokumur');
      $criteria->compare('LOWER(obatalkes.obatalkes_nama)', strtolower($_GET['term']), true);
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
  //        public function actionUpdateStok()
  //        {
  //            $qty = $_POST['qty'];
  //            $idobatAlkes = $_POST['idObatAlkes'];
  //            $sql = "select stokobatalkes_id,qtystok_in,qtystok_out from stokobatalkes_t order by tglstok_in";
  //            $stoks = Yii::app()->db->createCommand($sql)->queryAll();
  //            $selesai = false;
  //            while(!$selesai){
  //                foreach ($stoks as $i => $stok) {
  //                    if($qty <= $stok['qtystok_in']) {
  //                        $stok_in = $stok['qtystok_in'] - $qty;
  //                        $stok_out = $stok['qtystok_out'] + $qty;
  //                        StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('qtystok_in'=>$stok_in,'qtystok_out'=>$stok_out));
  //                        $selesai = true;
  //                        break;
  //                    } else {
  //                        $qty = $qty - $stok['qtystok_in'];
  //                        $stok_in = 0;
  //                        $stok_out = $stok['qtystok_out'] + $stok['qtystok_in'];
  //                        StokobatalkesT::model()->updateByPk($stok['stokobatalkes_id'], array('qtystok_in'=>$stok_in,'qtystok_out'=>$stok_out));
  //                    }
  //                }
  //            }
  //            $data['input'] = 'qty: '.$qty.' | ID Obat: '.$idobatAlkes;
  //            echo CJSON::encode($data);
  //            Yii::app()->end();
  //        }


  // Uncomment the following methods and override them if needed
  /*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
  public function actionPrintTindakan($id)
  {
    // echo '<pre>'; var_dump($_GET); die;
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');



    $con_nomor = " and t.ruangan_id = ".$ruangan_id." ";
    if (isset($_GET['nopelayanan'])) {
      $con_nomor = " and t.nopelayanan = '".$_GET['nopelayanan']."' ";
    }

    /*
    var_dump("t.pendaftaran_id = $id 
    $con_nomor 
    and t.verifbataltindakan_id is null"); die;
    */

    $modViewTindakans = RJTindakanPelayananT::model()
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
      ->findAll(array(
        'condition'=>"t.pendaftaran_id = $id 
        $con_nomor 
        and t.verifbataltindakan_id is null",
        'order'=>'t.tgl_tindakan, t.tindakanpelayanan_id'
      )); // RND-6244

      $nopelayanan = '';

      $crit2 = new CDbCriteria;
      $crit2->select = 'nopelayanan';
      $crit2->group = $crit2->select;
      $crit2->addCondition(' pendaftaran_id = ' . $modPendaftaran->pendaftaran_id . ' and ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
      $crit2->order = 'nopelayanan desc';
            
      $notatindakan_last = TindakanpelayananT::model()->find($crit2);

      $ruangan_id = Yii::app()->user->getState('ruangan_id');
    
      $condition = " pendaftaran_id = $id 
      $con_nomor 
      and verifbataltindakan_id is null ";

        if(!isset($_GET['is_all']) && !isset($_GET['nopelayanan'])) {
          $condition .= " and nopelayanan = '$notatindakan_last->nopelayanan'";
        } else if(isset($_GET['nopelayanan'])) {
          $nopelayanan = $_GET['nopelayanan'];

          if(!empty($nopelayanan)) {
            $condition .= " and nopelayanan = '$nopelayanan'";
          } else {
            $condition .= " and nopelayanan is null";
          }
        }

        $modTindakan = TindakanpelayananT::model()->findAll(array('condition'=>$condition, 'order'=>"tgl_tindakan, tindakanpelayanan_id"));

        if(!empty($modTindakan)) {
          foreach($modTindakan as $td) {

            $cetakan = !empty($td->cetakan) ? intval($td->cetakan) : 0;
            $ke = $cetakan + 1;

            TindakanpelayananT::model()->updateByPk($td->tindakanpelayanan_id, array('cetakan' => $ke));

          }
        }

      // $tinnull = TindakanpelayananT::model()->findAll(array(
      //   'condition'=>'nopelayanan = null and masukkamar_id is null and pendaftaran_id = ' . $id . 'and ruangan_id = ' . $ruangan_id,
      //   'order'=>'tgl_tindakan, tindakanpelayanan_id'
      // ));

      $saveno = true;
      /*
      if(!empty($tinnull)) {
        foreach($tinnull as $tn) {
          $tn->nopelayanan = '001';
          $saveno &= $tn->update();

        }
      }
      */

      // var_dump($condition); die;
    
      $modViewBmhp = RJObatalkesPasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $id), array(
        'order'=>'obatalkespasien_id'
      ));

    $judul_print = 'Tindakan Pasien ' . $modPasien->nama_pasien;
    $this->render(
      $this->path_view . 'printPerPage',
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

  public function actionPrintTindakanPenunjang($pasienmasukpenunjang_id)
  {
    // echo '<pre>'; var_dump($_GET); die;
    $this->layout = '//layouts/printWindows';
    $penunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
    if (!empty($penunjang->pasienkirimkeunitlain_id)) {
      $kirim = PasienkirimkeunitlainT::model()->findByPk($penunjang->pasienkirimkeunitlain_id);
    } else {
      $kirim = new PasienkirimkeunitlainT;
    }
    $format = new MyFormatter;
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($penunjang->pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $ruangan_id = $penunjang->ruangan_id;
    $modViewTindakans = RJTindakanPelayananT::model()
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
      ->findAll(array(
        'condition'=>"t.pasienmasukpenunjang_id = $pasienmasukpenunjang_id and t.verifbataltindakan_id is null",
        'order'=>'t.tgl_tindakan, t.tindakanpelayanan_id'
      )); // RND-6244

      $nopelayanan = '';

      $crit2 = new CDbCriteria;
      $crit2->select = 'nopelayanan';
      $crit2->group = $crit2->select;
      $crit2->addCondition(' pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
      $crit2->order = 'nopelayanan desc';
            
      $notatindakan_last = TindakanpelayananT::model()->find($crit2);

      $ruangan_id = Yii::app()->user->getState('ruangan_id');
    
      $condition = " pasienmasukpenunjang_id = $pasienmasukpenunjang_id and verifbataltindakan_id is null ";

        if(!isset($_GET['is_all']) && !isset($_GET['nopelayanan'])) {
          $condition .= " and nopelayanan = '$notatindakan_last->nopelayanan'";
        } else if(isset($_GET['nopelayanan'])) {
          $nopelayanan = $_GET['nopelayanan'];

          if(!empty($nopelayanan)) {
            $condition .= " and nopelayanan = '$nopelayanan'";
          } else {
            $condition .= " and nopelayanan is null";
          }
        }


        $modTindakan = TindakanpelayananT::model()->findAll(array('condition'=>$condition, 'order'=>'tgl_tindakan, tindakanpelayanan_id'));

        if(!empty($modTindakan)) {
          foreach($modTindakan as $td) {

            $cetakan = !empty($td->cetakan) ? intval($td->cetakan) : 0;
            $ke = $cetakan + 1;

            TindakanpelayananT::model()->updateByPk($td->tindakanpelayanan_id, array('cetakan' => $ke));

          }
        }

      // $tinnull = TindakanpelayananT::model()->findAll(array(
      //   'condition'=>'nopelayanan = null and pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id,
      //   'order'=>'tgl_tindakan, tindakanpelayanan_id'
      // ));

      $saveno = true;

      /*
      if(!empty($tinnull)) {
        foreach($tinnull as $tn) {
          $tn->nopelayanan = '001';
          $saveno &= $tn->update();

        }
      }
      */

      // var_dump($condition); die;
    
      $modViewBmhp = RJObatalkesPasienT::model()->with('obatalkes')->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id), array(
        'order'=>'obatalkespasien_id'
      ));

    $judul_print = 'Tindakan Pasien Penunjang ' . $modPasien->nama_pasien;
    $this->render(
      $this->path_view . 'printPerPagePenunjang',
      array(
        'format' => $format,
        'judul_print' => $judul_print,
        'modPendaftaran' => $modPendaftaran,
        'modTindakans' => $modViewTindakans,
        'modViewBmhp' => $modViewBmhp,
        'modPasien' => $modPasien,
        'penunjang' => $penunjang,
        'kirim' => $kirim,
      )
    );
  }

  public function actionUpdateCetakanKe() {
    if (Yii::app()->request->isPostRequest) {
        
        $pendaftaran_id = $_POST['pendaftaran_id'];
        $ruangan_id = $_POST['ruangan_id'];
        $nopelayanan = $_POST['nopelayanan'];

        $condition = " pendaftaran_id = $pendaftaran_id and ruangan_id = $ruangan_id ";

        if(!empty($nopelayanan)) {
          $condition .= " nopelayanan = '$nopelayanan'";
        }

        $modTindakan = TindakanpelayananT::model()->findAll($condition);

        if(!empty($modTindakan)) {
          foreach($modTindakan as $td) {

            $cetakan = !empty($td->cetakan) ? intval($td->cetakan) : 0;
            $ke = $cetakan + 1;

            $update = TindakanpelayananT::model()->updateByPk($td->tindakanpelayanan_id, array('cetakan' => $ke));

          }
        }

        if ($update) {
            if (Yii::app()->request->isAjaxRequest) {
                echo CJSON::encode(array(
                    'status' => 'proses_form',
                    'div' => "<div class='flash-success'>Data berhasil diupdate.</div>",
                ));
                exit;
            }
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
        throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  public function actionPrintUlangTindakan($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modViewTindakans = RJTindakanPelayananT::model()
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
      ->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id)); // RND-6244

    

    $dataTindakan = [];
    if(count($modViewTindakans) > 0) {
      foreach($modViewTindakans as $i => $data) {
        if($data->nopelayanan != null) {
          $dataTindakan[$data->nopelayanan][] = $data;
        }
      }
    }

    // echo '<pre>';  
    // var_dump($dataTindakan);die;

    $dataTindakanPerPageLimit6 = [];
    if(count($dataTindakan) > 0) {
      
      foreach($dataTindakan as $key => $val) {
        if(count($val) > 0) {

          // untuk menghitung total dari setiap nolayanan
          $biayaArray = array_map(function($item) {
              return $item['tarif_tindakan'];
          }, $val);
          
          $totalBiaya = array_sum($biayaArray);
          // akhir hitung total
        
          // untuk membagi array jadi jumlah 6 perpagenya
          $arr = array_chunk($val, 6);
          $page = 1;
          $nomulai = 0;
          foreach($arr as $ii => $data) {
            $dataTindakanPerPageLimit6[$key]["Page_$page"]['data'] = $data;
            $dataTindakanPerPageLimit6[$key]["Page_$page"]['nomulai'] = $nomulai;
            $page++;
            $nomulai+=6;
          }

          // meletakan total biaya pada page terakhir
          $lastPage = "Page_" . ($page - 1);
          $dataTindakanPerPageLimit6[$key][$lastPage]['data']['total_biaya'] = $totalBiaya;
        }
      }
    }



    // var_dump($dataTindakanPerPageLimit6);die;



    $modViewTindakans = $dataTindakanPerPageLimit6;


    $modViewBmhp = RJObatalkesPasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $judul_print = 'Tindakan Pasien ' . $modPasien->nama_pasien;
    $this->render(
      $this->path_view . 'printUlangPerNota',
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

  public function actionPrintUlangTindakanDialog($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $modTindakan = new RJTindakanPelayananT;
    $modTindakan->tarifcyto_tindakan = 0;
    $modTindakan->dokterpemeriksa1_id = $modPendaftaran->pegawai_id;
    $modTindakan->dokterpemeriksa1Nama = $modPendaftaran->pegawai->NamaLengkap;
    
    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id = ' . $modPendaftaran->penjamin_id);

    $this->render(
      $this->path_view . 'printUlangDialog',
      array(
        'format' => $format,
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
        'modTindakan' => $modTindakan,
        'modJenisTarif' => $modJenisTarif,
      )
    );
  }

  public function actionPrintUlangTindakanPenunjangDialog($pasienmasukpenunjang_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $penunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($penunjang->pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);


    $modTindakan = new RJTindakanPelayananT;
    $modTindakan->tarifcyto_tindakan = 0;
    $modTindakan->dokterpemeriksa1_id = $penunjang->pegawai_id ?? $modPendaftaran->pegawai_id;
    $modTindakan->dokterpemeriksa1Nama = $penunjang->pegawai->NamaLengkap ?? $modPendaftaran->pegawai->namaLengkap ?? "-";
    
    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id = ' . $modPendaftaran->penjamin_id);

    $this->render(
      $this->path_view . 'printUlangPenunjangDialog',
      array(
        'format' => $format,
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
        'modTindakan' => $modTindakan,
        'modJenisTarif' => $modJenisTarif,
        'penunjang' => $penunjang,
      )
    );
  }

  public function actionPrintTindakanRad($id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modViewTindakans = RJTindakanPelayananT::model()
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
      ->findAllByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id'))); // RND-6244

    $modViewBmhp = RJObatalkesPasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $id));

    $judul_print = 'Tindakan Pasien ' . $modPasien->nama_pasien;
    $this->render(
      $this->path_view . 'printPerPage',
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
            // var_dump($tersimpanpembebas, $terupdatetindakan); die;
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
               $pesan = "Data Free Of Change Gagal Disimpan!! ".$ex->getMessage();
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
            $tindKomponenId = $komponen->komponentarif_id;
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
              
            $returnVal[$tindKomponenId]['tindakankomponen_id'] = $komponen->tindakankomponen_id;
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
            // $returnVal[$tindKomponenId]['jmlpembebasan'] = $jmlpembebasan;
            $returnVal[$tindKomponenId]['jmlpembebasan'] = $komponen->tarif_tindakankomp;
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
        // var_dump($_POST); die;
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
              $modPembebasan = null;
              
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
      $criteria->addInCondition("kelompokpegawai_id", [Params::KELOMPOKPEGAWAI_ID_OKUPASITERAPI]);
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
      $criteria->addInCondition("kelompokpegawai_id",[Params::KELOMPOKPEGAWAI_ID_TERAPIWICARA]);
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

}
