<?php

class PemakaianBmhpController extends MyAuthController
{
  public $path_view = "laboratorium.views.pemakaianBmhp.";
  public $obatalkespasientersimpan = true; //looping
  public $stokobatalkestersimpan = true; //looping
  public $succesSave = true;
  public $pesan = "";

  public function actionIndex($pasienmasukpenunjang_id = null, $linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pemakaian BMHP";
    $format = new MyFormatter();
    $modKunjungan = new LBPasienMasukPenunjangV;
    $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modObatAlkesPasien = new LBObatalkespasienT;
    $dataOas = array();

    if (!empty($pasienmasukpenunjang_id)) {
      $modKunjungan = LBPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    }

    if (isset($_POST['LBObatalkespasienT'])) {
      if (isset($_POST['pasienmasukpenunjang_id'])) {
        $modPasienMasukPenunjang = LBPasienmasukpenunjangT::model()->findByPk($_POST['pasienmasukpenunjang_id']);
        $transaction = Yii::app()->db->beginTransaction();
        try {
          if (count((array)$_POST['LBObatalkespasienT']) > 0) {
            //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
            $detailGroups = array();
            foreach ($_POST['LBObatalkespasienT'] as $i => $postDetail) {
              $modDetails[$i] = new LBObatalkespasienT;
              $modDetails[$i]->attributes = $postDetail;

              $modDetails[$i] = $this->simpanObatAlkesPasien2($modPasienMasukPenunjang, $modDetails[$i]);
              $this->simpanStokObatAlkesOut2($modDetails[$i]);

              if (Yii::app()->user->getState('isjurnalotomatis') == true) {
                $JurObatAlkes = ObatalkesM::model()->findByPk($modDetails[$i]->obatalkes_id);

                if (isset($JurObatAlkes)) {
                  $modPendaftaran = $modPasienMasukPenunjang->pendaftaran;
                  $modJnsObatRek = JnsobatalkesrekM::model()->findAllByAttributes(array('jenisobatalkes_id' => $JurObatAlkes->jenisobatalkes_id, 'ispemakaianruangan' => true, 'ruangan_id' => Yii::app()->user->getState("ruangan_id")));

                  if (count((array)$modJnsObatRek) > 0) {
                    $modJurnalRekening = $this->saveJurnalRekening($modPendaftaran, $modDetails[$i]);

                    foreach ($modJnsObatRek as $jnsObatRek) {
                      $this->saveJurnalDetail($modJurnalRekening, $modDetails[$i], $jnsObatRek);
                    }

                    $this->obatalkespasientersimpan = $this->succesSave;
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
                        $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
                        if(count((array)$modStokOAs) > 0){
                            foreach($modStokOAs AS $i => $stok){
                                $modDetails[$i] = $this->simpanObatAlkesPasien($modPasienMasukPenunjang,$stok, $_POST['LBObatalkespasienT']);
                                $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
                            }
                        }else{
                            $this->stokobatalkestersimpan &= false;
                            $obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;

                        }
                    }
                     *
                     */

          //                    if(count((array)$_POST['LBObatalkespasienT']) > 0){
          //                        foreach($_POST['LBObatalkespasienT'] AS $i => $postOa){
          //                            $dataOas[$i] = $this->simpanObatAlkesPasien($modPasienMasukPenunjang,$postOa);
          //                        }
          //                    }
          // var_dump($this->obatalkespasientersimpan, $this->stokobatalkestersimpan); die;
          if ($this->obatalkespasientersimpan && $this->stokobatalkestersimpan) {
            $transaction->commit();
            $this->redirect(array('index', 'pasienmasukpenunjang_id' => $modPasienMasukPenunjang->pasienmasukpenunjang_id, 'sukses' => 1));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data pemakaian BMHP gagal disimpan !");
          }
        } catch (Exception $e) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pemakaian BMHP gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
        }
      }
    }

    $this->render($this->path_view . 'index', array(
      'modKunjungan' => $modKunjungan,
      'modObatAlkesPasien' => $modObatAlkesPasien,
      'dataOas' => $dataOas,
      'linkHalaman' => $linkHalaman
    ));
  }

  /**
   * simpan LBObatalkespasienT
   * @param type $modPasienMasukPenunjang
   * @param type $post
   * @return \LBObatalkespasienT
   */
  public function simpanObatAlkesPasien2($modPasienMasukPenunjang, $postObatAlkesPasien)
  {
    $oa = ObatalkesM::model()->findByPk($postObatAlkesPasien->obatalkes_id);
    $modObatAlkesPasien = new LBObatalkespasienT;
    $modObatAlkesPasien->attributes = $postObatAlkesPasien->attributes;
    $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
    $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modObatAlkesPasien->pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
    $modObatAlkesPasien->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
    $modObatAlkesPasien->pasienadmisi_id = $modPasienMasukPenunjang->pasienadmisi_id;
    $modObatAlkesPasien->carabayar_id = $modPasienMasukPenunjang->pendaftaran->carabayar_id;
    $modObatAlkesPasien->penjamin_id = $modPasienMasukPenunjang->pendaftaran->penjamin_id;
    $modObatAlkesPasien->pegawai_id = $modPasienMasukPenunjang->pegawai_id;
    $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
    $modObatAlkesPasien->pasien_id = $modPasienMasukPenunjang->pasien_id;
    $modObatAlkesPasien->kelaspelayanan_id = $modPasienMasukPenunjang->kelaspelayanan_id;
    $modObatAlkesPasien->tglpelayanan = date('Y-m-d H:i:s');
    $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modObatAlkesPasien->create_time = date('Y-m-d H:i:s');
    //$modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
    //$modObatAlkesPasien->qty_stok = $stokOa->qtystok;
    $modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stokOa->HPP;
    $modObatAlkesPasien->hargasatuan_oa = round($oa->hargajual); //$stokOa->HargaJualSatuan;
    $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
    $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->hargajual_oa;
    // $modObatAlkesPasien->oa = Params::OBATALKESPASIEN_BMHP;

    /*
         foreach ($postObatAlkesPasien AS $i => $postDetail) {
            if ($stokOa->obatalkes_id==$postDetail['obatalkes_id']) {
                $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];
                $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];
                $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
                $modObatAlkesPasien->iurbiaya = $postDetail['iurbiaya'];
            }
        }
         *
         */

    // var_dump($modObatAlkesPasien->attributes); die;

    if ($modObatAlkesPasien->save()) {
      $this->obatalkespasientersimpan &= true;
    } else {
      $this->obatalkespasientersimpan &= false;
    }
    return $modObatAlkesPasien;
  }


  /**
   * simpan LBObatalkespasienT
   * @param type $modPasienMasukPenunjang
   * @param type $post
   * @return \LBObatalkespasienT
   */
  public function simpanObatAlkesPasien($modPasienMasukPenunjang, $stokOa, $postObatAlkesPasien)
  {
    $modObatAlkesPasien = new LBObatalkespasienT;
    $modObatAlkesPasien->attributes = $stokOa->attributes;
    $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
    $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modObatAlkesPasien->pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
    $modObatAlkesPasien->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
    $modObatAlkesPasien->pasienadmisi_id = $modPasienMasukPenunjang->pasienadmisi_id;
    $modObatAlkesPasien->carabayar_id = $modPasienMasukPenunjang->pendaftaran->carabayar_id;
    $modObatAlkesPasien->penjamin_id = $modPasienMasukPenunjang->pendaftaran->penjamin_id;
    $modObatAlkesPasien->pegawai_id = $modPasienMasukPenunjang->pegawai_id;
    $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
    $modObatAlkesPasien->pasien_id = $modPasienMasukPenunjang->pasien_id;
    $modObatAlkesPasien->kelaspelayanan_id = $modPasienMasukPenunjang->kelaspelayanan_id;
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
    foreach ($postObatAlkesPasien as $i => $postDetail) {
      if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
        $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];
        $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];
        $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
        $modObatAlkesPasien->iurbiaya = $postDetail['iurbiaya'];
      }
    }

    if ($modObatAlkesPasien->save()) {
      $this->obatalkespasientersimpan &= true;
    } else {
      $this->obatalkespasientersimpan &= false;
    }
    return $modObatAlkesPasien;

    //        old
    //        $modObatAlkesPasien = new LBObatalkespasienT;
    //        $modObatAlkesPasien->attributes = $post;
    //        $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    //        $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
    //        $modObatAlkesPasien->pendaftaran_id = $modPasienMasukPenunjang->pendaftaran_id;
    //        $modObatAlkesPasien->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
    //        $modObatAlkesPasien->pasienadmisi_id = $modPasienMasukPenunjang->pasienadmisi_id;
    //        $modObatAlkesPasien->carabayar_id = $modPasienMasukPenunjang->pendaftaran->carabayar_id;
    //        $modObatAlkesPasien->penjamin_id = $modPasienMasukPenunjang->pendaftaran->penjamin_id;
    //        $modObatAlkesPasien->pegawai_id = $modPasienMasukPenunjang->pegawai_id;
    //        $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
    //        $modObatAlkesPasien->pasien_id = $modPasienMasukPenunjang->pasien_id;
    //        $modObatAlkesPasien->kelaspelayanan_id = $modPasienMasukPenunjang->kelaspelayanan_id;
    //        $modObatAlkesPasien->tglpelayanan = date ('Y-m-d H:i:s');
    //        $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
    //        $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
    //        $modObatAlkesPasien->create_time = date ('Y-m-d H:i:s');
    //
    //        if($modObatAlkesPasien->validate()) {
    //            $modObatAlkesPasien->save();
    //            StokobatalkesT::kurangiStok($modObatAlkesPasien->qty_oa, $modObatAlkesPasien->obatalkes_id);
    //        } else {
    //            $this->obatalkespasientersimpan &= false;
    //        }
    //        return $modObatAlkesPasien;
  }

  /**
   * simpan StokobatalkesT Jumlah Out (Lepas Validasi Stok)
   * @param type $stokobatalkesasal_id
   * @param type $modObatAlkesPasien
   * @return \StokobatalkesT
   */
  protected function simpanStokObatAlkesOut2($modObatAlkesPasien)
  {
    $format = new MyFormatter;
    // $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $oa = ObatalkesM::model()->findByPk($modObatAlkesPasien->obatalkes_id);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $oa->attributes;
    $modStokOaNew->attributes = $modObatAlkesPasien->attributes; //duplicate
    $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
    $modStokOaNew->qtystok_in = 0;
    $modStokOaNew->qtystok_out = $modObatAlkesPasien->qty_oa;
    $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
    // $modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

    $modStokOaNew->tglterima = $modStokOaNew->create_time;

    // var_dump($modStokOaNew->attributes);
    // var_dump($modStokOaNew->validate());
    // var_dump($modStokOaNew->errors);
    // die;

    if ($modStokOaNew->validate()) {
      $modStokOaNew->save();
      // $modStokOaNew->setStokOaAktifBerdasarkanStok();
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

  /**
   * Mengurai data kunjungan berdasarkan:
   * - pasienmasukpenunjang_id
   * @throws CHttpException
   */
  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $returnVal['pesan'] = "";
      $criteria = new CDbCriteria();
      $model = $this->loadModPasienMasukPenunjang($_POST['pasienmasukpenunjang_id']);
      if (isset($model)) {
        $loadHasilPemeriksaan = LBHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id));
        if (isset($loadHasilPemeriksaan)) {
          if (strtolower(trim($loadHasilPemeriksaan->statusperiksahasil)) == strtolower(Params::STATUSPERIKSAHASIL_SUDAH)) {
            $returnVal['pesan'] = "Pasien dengan status sudah diperiksa tidak bisa menggunakan obat / alat kesehatan !";
          }
        }
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
   * @param type $pasienmasukpenunjang_id
   * @return LBPasienMasukPenunjangV
   */
  public function loadModPasienMasukPenunjang($pasienmasukpenunjang_id)
  {
    $criteria = new CDbCriteria;
    $criteria->addCondition("t.pasienmasukpenunjang_id = " . $pasienmasukpenunjang_id);
    $model = LBPasienMasukPenunjangV::model()->find($criteria);
    return $model;
  }
  /**
   * untuk form kunjungan
   */
  public function actionAutocompleteKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : null;
      $no_masukpenunjang = isset($_GET['no_masukpenunjang']) ? $_GET['no_masukpenunjang'] : null;
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_masukpenunjang)', strtolower($no_masukpenunjang), true);
      $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->addCondition('ruangan_id = ' . $ruangan_id);
      $criteria->order = 'no_pendaftaran, no_masukpenunjang, no_rekam_medik, nama_pasien';
      $criteria->limit = 5;
      $models = LBPasienMasukPenunjangV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_pendaftaran . "-" . $model->no_masukpenunjang . '-' . $model->no_rekam_medik . '-' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * untuk form tambah obat alkes
   */
  public function actionAutocompleteObatAlkes()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->join = " JOIN stokobatalkes_t stok ON stok.obatalkes_id = t.obatalkes_id ";
      $criteria->compare('LOWER(t.obatalkes_nama)', strtolower($_GET['term']), true);
      $criteria->addCondition('t.obatalkes_farmasi = TRUE');
      $criteria->addCondition('t.obatalkes_aktif = true');
      $criteria->addCondition("stok.ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "' ");
      $criteria->order = 't.obatalkes_nama';
      $criteria->limit = 5;
      $models = ObatalkesM::model()->with('sumberdana', 'satuankecil')->findAll($criteria);
      $format = new MyFormatter();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();

        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $qty_stok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
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
   * set LKTindakanpelayananT yang sudah ada di database
   * @params pasienmasukpenunjang_id
   */
  public function actionSetRiwayatObatAlkesPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $loadOaPasiens = LBObatalkespasienT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id']));
      if (count((array)$loadOaPasiens) > 0) {
        foreach ($loadOaPasiens as $i => $modObatAlkesPasien) {
          $modObatAlkesPasien->tglpelayanan = $format->formatDateTimeForUser($modObatAlkesPasien->tglpelayanan);
          $modObatAlkesPasien->hargajual_oa = $format->formatNumberForUser($modObatAlkesPasien->hargajual_oa);
          $modObatAlkesPasien->qty_oa = $format->formatNumberForUser($modObatAlkesPasien->qty_oa);
          $modObatAlkesPasien->iurbiaya = $format->formatNumberForUser($modObatAlkesPasien->iurbiaya);
          $rows .= $this->renderPartial($this->path_view . "_rowRiwayatObatAlkesPasien", array('modObatAlkesPasien' => $modObatAlkesPasien), true);
        }
      }
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }
  /**
   * hapus LBObatalkespasienT yang sudah ada di database
   * @params obatalkespasien_id
   */
  public function actionHapusObatAlkesPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['pesan'] = "";
      $data['sukses'] = 0;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $loadObatAlkesPasien = ObatalkespasienT::model()->findByPk($_POST['obatalkespasien_id']);
        $kembalikanstok = $this->kembalikanStok($loadObatAlkesPasien);
        if ($kembalikanstok) {
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
  /**
   * mengembalikan stok jika ada pembatalan
   * @param type $obatAlkesT
   */
  protected function kembalikanStok($modObatAlkesPasien)
  {
    $format = new MyFormatter();
    StokobatalkesT::model()->deleteAllByAttributes(array(
      'obatalkespasien_id' => $modObatAlkesPasien->obatalkespasien_id,
    ));
    return true;
    /*
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
        $stok->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if($stok->save())
            return true;
         *
         */
  }

  /**
   * menampilkan obat
   * @return row table
   */
  public function actionSetFormObatAlkesPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null;
      $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : 1;
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modObatAlkesPasien = new LBObatalkespasienT;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
      $oa = ObatalkesM::model()->findByPk($obatalkes_id);
      //            dihilangkan komen karena error ketika simpan RSPMC-1350
      if (count((array)$modStokOAs) > 0) { //RSPMC-1350

        foreach ($modStokOAs as $i => $stok) { //RSPMC-1350
          $modObatAlkesPasien->sumberdana_id = $oa->sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
          $modObatAlkesPasien->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
          $modObatAlkesPasien->qty_oa = $jumlah; //$stok->qtystok_terpakai;
          $modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stok->HPP;
          $modObatAlkesPasien->hargasatuan_oa = round($oa->hargajual); //$stok->HargaJualSatuan;
          $modObatAlkesPasien->qty_stok = $stok->qtystok;
          $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
          //$modObatAlkesPasien->stokobatalkes_id = null; //$stok->stokobatalkes_id;
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
          $modObatAlkesPasien->satuankecil_id = $oa->satuankecil_id; //$stok->satuankecil_id;
          $modObatAlkesPasien->satuankecil_nama = $oa->satuankecil->satuankecil_nama; //$stok->satuankecil->satuankecil_nama;
          // $modObatAlkesPasien->obatalkes_nama = $oa->obatalkes_nama; //$stok->obatalkes->obatalkes_nama;
          $modObatAlkesPasien->ruangan_id = $ruangan_id;

          $form .= $this->renderPartial($this->path_view . '_rowObatAlkesPasien', array('modObatAlkesPasien' => $modObatAlkesPasien), true);
        } //RSPMC-1350
      } else { //RSPMC-1350
        $pesan = "Stok tidak mencukupi!"; //RSPMC-1350
      } //RSPMC-1350

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  public function actionPrint($pasienmasukpenunjang_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPasienMasukPenunjang = LBPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modObatAlkesPasien = LBObatalkespasienT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));

    $judul_print = 'Pemakaian BMHP ' . $modPasienMasukPenunjang->ruangan_nama;
    $this->render($this->path_view . 'printPemakaianBmhp', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modObatAlkesPasien' => $modObatAlkesPasien,
    ));
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
