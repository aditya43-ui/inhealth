<?php
class PemakaianBahanController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  protected $successSavePemakaianBahan = true;
  public $obatalkespasientersimpan = true; //dilooping
  public $stokobatalkestersimpan = true; //looping
  protected  $path_view_rj = 'rawatJalan.views.pemakaianBahan.';
  public $succesSave = true;
  public $pesan = "";

  public function actionIndex($pendaftaran_id)
  {
    $pasienadmisi_id = isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null;
    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);

    if (isset($_POST['pemakaianBahan'])) {
      $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (isset($_POST['pemakaianBahan']) && count((array)$_POST['pemakaianBahan']) > 0) {
          //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
          $detailGroups = array();
          foreach ($_POST['pemakaianBahan'] as $i => $postDetail) {
            $modDetails[$i] = new RJObatalkesPasienT;
            $modDetails[$i]->attributes = $postDetail;
            $modDetails[$i] = $this->simpanObatAlkesPasien2($modPendaftaran, $postDetail, $pasienadmisi_id);
            $this->simpanStokObatAlkesOut2($modDetails[$i]);

            if (Yii::app()->user->getState('isjurnalotomatis') == true) {
              $JurObatAlkes = ObatalkesM::model()->findByPk($modDetails[$i]->obatalkes_id);

              if (isset($JurObatAlkes)) {
                $modJnsObatRek = JnsobatalkesrekM::model()->findAllByAttributes(array('jenisobatalkes_id' => $JurObatAlkes->jenisobatalkes_id, 'ispemakaianruangan' => true, 'ruangan_id' => Yii::app()->user->getState("ruangan_id")));

                if (count((array)$modJnsObatRek) > 0) {
                  $modJurnalRekening = $this->saveJurnalRekening($modPendaftaran, $modDetails[$i]);

                  foreach ($modJnsObatRek as $jnsObatRek) {
                    $this->saveJurnalDetail($modJurnalRekening, $modDetails[$i], $jnsObatRek);
                  }

                  $this->obatalkespasientersimpan = true;
                }
              }
            }
            /*
							$modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
							$modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
							$obatalkes_id = $postDetail['obatalkes_id'];
							if(isset($detailGroups[$obatalkes_id])){
								$detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
							}else{
								$detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
								$detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
							} */
          }
          //END GROUP
        }
        /*
					$obathabis = "";
					//PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
					foreach($detailGroups AS $i => $detail){
						$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id'));
						if(count((array)$modStokOAs) > 0){
							foreach($modStokOAs AS $i => $stok){
								$modDetails[$i] = $this->simpanObatAlkesPasien($modPendaftaran,$stok, $_POST['pemakaianBahan']);
								$this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
							}
						}else{
							$this->stokobatalkestersimpan &= false;
							$obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;

						}
					}
                                         *
                                         */

        if ($this->obatalkespasientersimpan && $this->stokobatalkestersimpan) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          //$this->refresh();

          if (!empty($pasienadmisi_id)) {
            $this->redirect(array('index', 'pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'sukses' => 1));
          } else {
              $this->redirect(array('index', 'pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'sukses' => 1));
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Pemakaian Bahan gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pemakaian Bahan gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $modViewBmhp = RJObatalkesPasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'oa' => Params::OBATALKESPASIEN_BMHP, 'ruangan_id' =>$ruangan_id));

    $this->render($this->path_view_rj . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modViewBmhp' => $modViewBmhp,
    ));
  }

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

  protected function kembalikanStok2($modObatAlkesPasien)
  {
    return StokobatalkesT::model()->deleteAllByAttributes(array(
      'obatalkespasien_id' => $modObatAlkesPasien->obatalkespasien_id,
    ));
  }

  protected function kembalikanStok($modObatAlkesPasien)
  {
    $format = new MyFormatter();
    $stok = new StokobatalkesT;
    $stok->attributes = $modObatAlkesPasien->attributes;
    $modObatAlkes = ObatalkesM::model()->findByPk($modObatAlkesPasien->obatalkes_id); //sementara menggunakan harga terupdate
    $stok->tglkadaluarsa = $format->formatDateTimeForDb($modObatAlkes->tglkadaluarsa);
    $stok->harganetto = $modObatAlkes->harganetto;
    $stok->persendiscount = $modObatAlkes->discount;
    $stok->persenmargin = $modObatAlkes->margin;
    $stok->satuankecil_id = $modObatAlkes->satuankecil_id;
    $stok->jmlmargin = 0;
    $stok->jmldiscount = 0;
    $stok->persenppn = $modObatAlkes->ppn_persen;
    $stok->persenpph = 0;
    $stok->tglstok_in = date('Y-m-d H:i:s');
    $stok->tglterima = date('Y-m-d H:i:s');
    $stok->tglstok_out = null;
    $stok->qtystok_in = $modObatAlkesPasien->qty_oa;
    $stok->qtystok_out = 0;

    $stok->create_time = date('Y-m-d H:i:s');
    $stok->update_time = date('Y-m-d H:i:s');
    $stok->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
    $stok->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');

    if ($stok->save())
      return true;
  }

  public function actionHapusObatAlkesPasien() {
    if (Yii::app()->request->isAjaxRequest) {
        $data['pesan'] = "";
        $data['sukses'] = 0;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $loadObatAlkesPasien = ObatalkespasienT::model()->findByPk($_POST['obatalkespasien_id']);

            $modJurnalBefore = JurnalrekeningT::model()->findAllByAttributes(array('obatalkespasien_id' => $loadObatAlkesPasien->obatalkespasien_id));

            if (!empty($modJurnalBefore)) {
                if (!empty($modJurnalBefore)) {
                    foreach ($modJurnalBefore as $jurnalBef) {
                        $jurnaldetail = JurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id' => $jurnalBef->jurnalrekening_id));

                        if (!empty($jurnaldetail)) {
                            foreach ($jurnaldetail as $jurnaldetBefor) {
                                $jurnaldetBefor->delete();
                            }
                        }
                        $jurnalBef->delete();
                    }
                }
            }

            $kembalikanstok = $this->kembalikanStok2($loadObatAlkesPasien);
            if ($kembalikanstok) {
                // var_dump("Kick1"); die;
                if ($loadObatAlkesPasien->delete()) {
                    $transaction->commit();
                    $data['pesan'] = "Obat / Alat Kesehatan berhasil dihapus!";
                    $data['sukses'] = 1;
                } else {
                    $transaction->rollback();
                    $data['pesan'] = "Stok Obat / Alat Kesehatan gagal dikembalikan!";
                    $data['sukses'] = 0;
                }
            } else {
                //  var_dump("Kick2"); die;
                $transaction->rollback();
                $data['pesan'] = "Obat / Alat Kesehatan gagal dihapus!";
                $data['sukses'] = 0;
            }
        } catch (Exception $exc) {
            $transaction->rollback();
            $data['pesan'] = "Obat / Alat Kesehatan gagal dihapus! :" . MyExceptionMessage::getMessage($exc, true);
        }
        echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  public function actionPrint($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;

    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modViewBmhp = RJObatalkesPasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $judul_print = 'Pemakaian Bahan ' . $modPasien->nama_pasien;
    $this->render($this->path_view_rj . 'print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modViewBmhp' => $modViewBmhp,
    ));
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
      $persenjual = $this->persenJualRuangan();
      $modObatAlkes->hargajual = floor(($persenjual + 100) / 100 * $modObatAlkes->hargajual);

      echo CJSON::encode(array(
        'pendaftaran_id' => $pendaftaran_id,
        'namaObat' => $modObatAlkes->obatalkes_nama,
        'form' => $this->renderPartial($this->path_view_rj . '_formAddPemakaianBahan', array(
          'modObatAlkes' => $modObatAlkes, 'modDaftartindakan' => $modDaftartindakan,
          'modPendaftaran' => $modPendaftaran,
        ), true),
      ));
      exit;
    }
  }

  /**
   * simpan RJObatalkesPasienT
   * @param type $modPendaftaran
   * @param type $post
   * @return \RJObatalkesPasienT
   */
  public function simpanObatAlkesPasien2($modPendaftaran, $postObatAlkesPasien, $pasienadmisi_id = null)
  {
    $modObatAlkesPasien = new RJObatalkesPasienT();
    $modObatAlkesPasien->attributes = $postObatAlkesPasien;
    $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
    $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    $modObatAlkesPasien->ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modObatAlkesPasien->pasienadmisi_id = $pasienadmisi_id;
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
    $modObatAlkesPasien->oa = Params::OBATALKESPASIEN_BMHP;


    //var_dump($postObatAlkesPasien);
    // var_dump($modObatAlkesPasien->attributes);

    //die;

    //$modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
    //$modObatAlkesPasien->qty_stok = $stokOa->qtystok;
    //$modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
    //$modObatAlkesPasien->hargasatuan_oa = $stokOa->HargaJualSatuan;
    //$modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
    
    //foreach ($postObatAlkesPasien AS $i => $postDetail) {
    //   if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
    //	   $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];
    //	   $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];
    //	   $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
    //	   $modObatAlkesPasien->iurbiaya = $postDetail['iurbiaya'];
    //   }
    //}

    //var_dump($modObatAlkesPasien->validate());
    //var_dump($modObatAlkesPasien->errors);

    //die;

    // var_dump($modObatAlkesPasien->attributes); die;

    if ($modObatAlkesPasien->save()) {

      $p = PendaftaranT::model()->findByPk($modPendaftaran->pendaftaran_id);
      $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);

      /* ================================================ */
      /* Proses update status periksa KonsulPoli EHS-179  */
      /* ================================================ */
      $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id')));
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
      $this->obatalkespasientersimpan &= true;
    } else {
      $this->obatalkespasientersimpan &= false;
    }
    return $modObatAlkesPasien;
  }

  /**
   * simpan RJObatalkesPasienT
   * @param type $modPendaftaran
   * @param type $post
   * @return \RJObatalkesPasienT
   */
  public function simpanObatAlkesPasien($modPendaftaran, $stokOa, $postObatAlkesPasien)
  {
    $modObatAlkesPasien = new RJObatalkesPasienT();
    $modObatAlkesPasien->attributes = $stokOa->attributes;
    $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
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
    $modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
    $modObatAlkesPasien->qty_stok = $stokOa->qtystok;
    $modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
    $modObatAlkesPasien->hargasatuan_oa = $stokOa->HargaJualSatuan;
    $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
    $modObatAlkesPasien->oa = Params::OBATALKESPASIEN_BMHP;
    foreach ($postObatAlkesPasien as $i => $postDetail) {
      if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
        $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];
        $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];
        $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
        $modObatAlkesPasien->iurbiaya = $postDetail['iurbiaya'];
      }
    }

    if ($modObatAlkesPasien->save()) {
      // $updateStatusPeriksa=PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
      /* ================================================ */
      /* Proses update status periksa KonsulPoli EHS-179  */
      /* ================================================ */
      $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id')));
      // if(count((array)$konsulPoli)>0){
      // 	$updateStatusPeriksa=KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
      // }
      /* ================================================ */

      PendaftaranT::model()->updateByPk(
        $modPendaftaran->pendaftaran_id,
        array(
          'pembayaranpelayanan_id' => null
        )
      );
      $this->obatalkespasientersimpan &= true;
    } else {
      $this->obatalkespasientersimpan &= false;
    }
    return $modObatAlkesPasien;
  }

  /**
   * menampilkan obat
   * @return row table
   */
  public function actionSetFormObatAlkesPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : "");
      $obatalkes_id = isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null;
      $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : 1;
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modObatAlkesPasien = new RJObatalkesPasienT;
      $modDaftartindakan = DaftartindakanM::model()->findByPk($daftartindakan_id);
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
      $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
      $oa = ObatalkesM::model()->findByPk($obatalkes_id);

      //if(count((array)$modStokOAs) > 0){
      //	foreach($modStokOAs AS $i => $stok){
      $modObatAlkesPasien->sumberdana_id = $oa->sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
      $modObatAlkesPasien->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
      $modObatAlkesPasien->qty_oa = $jumlah; //$stok->qtystok_terpakai;
      $modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stok->HPP;
      $modObatAlkesPasien->hargasatuan_oa = $oa->hargajual; //$stok->HargaJualSatuan;
      $modObatAlkesPasien->qty_stok = 0; //$stok->qtystok;
      $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
      $modObatAlkesPasien->stokobatalkes_id = null; //$stok->stokobatalkes_id;
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
      $modObatAlkesPasien->qty_oa = MyFormatter::formatNumberForPrint($jumlah, 2); //$stok->qtystok_terpakai;

      $modObatAlkesPasien->satuankecil_id = $oa->satuankecil_id; //$stok->satuankecil_id;
      $modObatAlkesPasien->satuankecil_nama = $oa->satuankecil->satuankecil_nama; //$stok->satuankecil->satuankecil_nama;
      $modObatAlkesPasien->obatalkes_nama = $oa->obatalkes_nama; //$stok->obatalkes->obatalkes_nama;
      $modObatAlkesPasien->ruangan_id = $ruangan_id;

      $modObatAlkesPasien->harganetto_oa =  MyFormatter::formatNumberForPrint($modObatAlkesPasien->harganetto_oa,2);
      $modObatAlkesPasien->hargasatuan_oa =  MyFormatter::formatNumberForPrint($modObatAlkesPasien->hargasatuan_oa,2);
      $modObatAlkesPasien->hargajual_oa =  MyFormatter::formatNumberForPrint($modObatAlkesPasien->hargajual_oa,2);
      $modObatAlkesPasien->iurbiaya = MyFormatter::formatNumberForPrint($modObatAlkesPasien->iurbiaya,2);
      $modObatAlkesPasien->qty_stok = MyFormatter::formatNumberForPrint($modObatAlkesPasien->qty_stok,2);

      $form .= $this->renderPartial($this->path_view_rj . '_formAddPemakaianBahan', array(
        'modObatAlkesPasien' => $modObatAlkesPasien, 'modDaftartindakan' => $modDaftartindakan,
        'modPendaftaran' => $modPendaftaran
      ), true);
      //	}
      //}else{
      //	$pesan = "Stok tidak mencukupi!";
      //}

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
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
    $modStokOaNew->qtystok_out = $modObatAlkesPasien->qty_oa; // LNG Ceil (Pembulatan keatas request pak tito)
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
    $modStokOaNew->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');

    if ($modStokOaNew->validateStok()) {
      $modStokOaNew->save();
      $modStokOaNew->setStokOaAktifBerdasarkanStok();
    } else {
      $this->stokobatalkestersimpan &= false;
    }
    return $modStokOaNew;
  }

  /**
   * untuk form tambah obat alkes
   * di copy dari laboratorium/pemakaianBmhpController
   */
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
      $criteria->order = 'obatalkes_nama';
      $criteria->compare('t.jenisobatalkes_id', Params::JENISOBATALKES_ID_BHP);
      $criteria->limit = 5;
      $models = ObatalkesM::model()->findAll($criteria);
      $format = new MyFormatter();
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

  protected function saveJurnalRekening($model, $dtDetail)
  {

    $format = new MyFormatter();
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PERSEDIAAN;
    $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tgl_pendaftaran);
    $modJenisjurnal = JenisjurnalM::model()->findByPk($modJurnalRekening->jenisjurnal_id);
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek($modJenisjurnal->jeniskode);
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $model->no_pendaftaran;
    $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tgl_pendaftaran);
    $modJurnalRekening->nobku = "";
    $ruangan_nama = "";
    $modRuangan = RuanganM::model()->findByPk($model->ruangan_id);

    if (isset($modRuangan)) {
      $ruangan_nama = $modRuangan->ruangan_nama;
    }
    $oa = ObatalkesM::model()->findByPk($dtDetail->obatalkes_id);
    $modJurnalRekening->urianjurnal = 'Pemakaian Bahan ' . $oa->obatalkes_nama . " Ruangan " . $ruangan_nama . " - " . $model->no_pendaftaran;

    $periodeID = $modJurnalRekening->currentPeriod;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = date('Y-m-d H:i:s');
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->ruangan_id = $model->create_ruangan;
    $modJurnalRekening->obatalkespasien_id = $dtDetail->obatalkespasien_id;

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modJurnalRekening->getErrors();
    }
    return $modJurnalRekening;
  }

  public function saveJurnalDetail($modJurnalRekening, $postRekenings, $modelRek)
  {
    $valid = true;
    $modJurnalPosting = null;
    $modObatAlkes = ObatalkesM::model()->findByPk($postRekenings->obatalkes_id);

    // $rekening5 = Rekening5M::model()->findByPk($modelRek->rekening5_id);
    // $rekening4 = Rekening4M::model()->findByPk($rekening5->rekening4_id);
    // $rekening3 = Rekening3M::model()->findByPk($rekening4->rekening3_id);
    // $rekening2 = Rekening2M::model()->findByPk($rekening3->rekening2_id);

    $modelJurnalDetail = new JurnaldetailT();

    $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    $modelJurnalDetail->rekening5_id = $modelRek->rekening5_id;
    // $modelJurnalDetail->rekening1_id = $rekening2->rekening1_id;
    // $modelJurnalDetail->rekening2_id = $rekening2->rekening2_id;
    // $modelJurnalDetail->rekening3_id = $rekening3->rekening3_id;
    // $modelJurnalDetail->rekening4_id = $rekening4->rekening4_id;
    $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;

    $totalHasilQty = ($modObatAlkes->hpp * $postRekenings->qty_oa);

    if ($modelRek->debitkredit == 'K') {
      $modelJurnalDetail->nourut = 2;
      $modelJurnalDetail->saldokredit = $totalHasilQty;
      $modelJurnalDetail->saldodebit = 0;
    } else if ($modelRek->debitkredit == 'D') {
      $modelJurnalDetail->nourut = 1;
      $modelJurnalDetail->saldodebit = $totalHasilQty;
      $modelJurnalDetail->saldokredit = 0;
    }

    if ($modelJurnalDetail->validate()) {
      $modelJurnalDetail->save();

      //                if(Yii::app()->user->getState('ispostingotomatis'))
      //                {
      //                    $modJurnalPosting = new JurnalpostingT;
      //                    $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
      //                    $modJurnalPosting->keterangan = "Posting automatis";
      //                    $modJurnalPosting->create_time = date('Y-m-d H:i:s');
      //                    $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
      //                    $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
      //                    $modJurnalPosting->jurnaldetail_id = $modelJurnalDetail->jurnaldetail_id;
      //                    $modJurnalPosting->periodeposting_id = $modelJurnalDetail->jurnalposting_id;
      //
      //                    $periode = PeriodepostingM::model()->findByAttributes(array('rekperiode_id'=>$modJurnalRekening->rekperiod_id));
      //                    if (!empty($periode)) {
      //                        $modJurnalPosting->periodeposting_id = $periode->periodeposting_id;
      //                    }
      //
      //                    if($modJurnalPosting->validate()){
      //                        if($modJurnalPosting->save()){
      //                            JurnaldetailT::model()->updateByPk($modelJurnalDetail->jurnaldetail_id, array('jurnalposting_id'=>$modJurnalPosting->jurnalposting_id));
      //                        }
      //                    }
      //                }
    } else {
      //                      KARENA TIDAK DI SEMUA CONTROLLER DI DEKLARASIKAN >>  $this->pesan = $model[$i]->getErrors();
      $valid = false;
    }

    return $valid;
  }
}
