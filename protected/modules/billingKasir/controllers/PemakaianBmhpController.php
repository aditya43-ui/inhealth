<?php
class PemakaianBmhpController extends MyAuthController
{
  public $layout = "//layouts/iframe";
  public $path_view = "billingKasir.views.pemakaianBmhp.";

  public $obatalkespasientersimpan = true; //dilooping
  public $stokobatalkestersimpan = true; //looping

  /**
   * di copy dari laboratorium/pemakaianBmhpController
   */
  public function actionIndex($pendaftaran_id, $pasienadmisi_id = null)
  {
    $format = new MyFormatter();
    $modPasienAdmisi = new BKPasienadmisiT;
    $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
    if (!empty($pasienadmisi_id)) {
      $modPasienAdmisi = BKPasienadmisiT::model()->findByPk($pasienadmisi_id);
    }

    $modKunjungan = new BKPasienkirimkeunitlainV;
    $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modObatAlkesPasien = new BKObatalkesPasienT;
    $dataOas = array();

    if (isset($_POST['BKObatalkesPasienT'])) {
      if (isset($_POST['pendaftaran_id'])) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          if (count((array)$_POST['BKObatalkesPasienT']) > 0) {
            //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
            $detailGroups = array();
            foreach ($_POST['BKObatalkesPasienT'] as $i => $postDetail) {
              $modDetails[$i] = new BKObatalkesPasienT;
              $modDetails[$i]->attributes = $postDetail;
              $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
              $modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
              $obatalkes_id = $postDetail['obatalkes_id'];
              if (isset($detailGroups[$obatalkes_id])) {
                $detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
                $detailGroups[$obatalkes_id]['ruangan_id'] = $postDetail['ruangan_id'];
              } else {
                $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
                $detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
                $detailGroups[$obatalkes_id]['ruangan_id'] = $postDetail['ruangan_id'];
              }
            }
            //END GROUP
          }
          $obathabis = "";
          //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
          foreach ($detailGroups as $i => $detail) {
            $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], $detail['ruangan_id']);
            if (count((array)$modStokOAs) > 0) {
              foreach ($modStokOAs as $i => $stok) {
                $modDetails[$i] = $this->simpanObatAlkesPasien($modPendaftaran, $stok, $_POST['BKObatalkesPasienT']);
                $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
              }
            } else {
              $this->stokobatalkestersimpan &= false;
              $obathabis .= "<br>- " . ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
            }
          }

          //                    if (count((array)$_POST['BKObatalkesPasienT']) > 0){
          //                        foreach($_POST['BKObatalkesPasienT'] AS $i => $postOa){
          //                            $dataOas[$i] = $this->simpanObatAlkesPasien($modPendaftaran,$postOa);
          //                        }
          //                    }

          if ($this->obatalkespasientersimpan && $this->stokobatalkestersimpan) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data pemakaian Bahan Pasien " . $modPendaftaran->pasien->nama_pasien . " berhasil disimpan !");
            $this->redirect($this->createUrl('index', array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'sukses' => 1)));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data pemakaian gagal disimpan !");
          }
        } catch (Exception $e) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pemakaian gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
        }
      }
    }

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasienAdmisi' => $modPasienAdmisi,
      'modKunjungan' => $modKunjungan,
      'modObatAlkesPasien' => $modObatAlkesPasien,
      'dataOas' => $dataOas,
    ));
  }

  public function actionDynamicRuangan()
  {
    $instalasi_id = (isset($_POST['instalasi']) ? $_POST['instalasi'] : null);
    $data = RuanganM::model()->findAll(
      'instalasi_id=:instalasi_id AND ruangan_aktif = TRUE order by ruangan_nama',
      array(':instalasi_id' => $instalasi_id)
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

  /**
   * simpan BKObatalkesPasienT
   * @param type $modPendaftaran
   * @param type $stokOa
   * @param type $postObatAlkesPasien
   * @return \BKObatalkesPasienT
   */
  public function simpanObatAlkesPasien($modPendaftaran, $stokOa, $postObatAlkesPasien)
  {
    $modObatAlkesPasien = new BKObatalkesPasienT;
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
    $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->hargajual_oa;
    $modObatAlkesPasien->oa = Params::OBATALKESPASIEN_BMHP;
    foreach ($postObatAlkesPasien as $i => $postDetail) {
      if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
        $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];
        $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];
        $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
      }
    }

    if ($modObatAlkesPasien->save()) {
      $this->obatalkespasientersimpan &= true;
    } else {
      $this->obatalkespasientersimpan &= false;
    }
    //        
    //        $modObatAlkesPasien = new BKObatalkesPasienT;
    //        $modObatAlkesPasien->attributes = $post;
    //        $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    //        $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
    //        $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    //        $modObatAlkesPasien->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
    //        $modObatAlkesPasien->carabayar_id = $modPendaftaran->carabayar_id;
    //        $modObatAlkesPasien->penjamin_id = $modPendaftaran->penjamin_id;
    //        $modObatAlkesPasien->pegawai_id = $modPendaftaran->pegawai_id;
    //        $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
    //        $modObatAlkesPasien->pasien_id = $modPendaftaran->pasien_id;
    //        $modObatAlkesPasien->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
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
   * set BKObatalkesPasienT yang sudah ada di database
   * @params pendaftaran_id
   * di copy dari laboratorium/pemakaianBmhpController
   */
  public function actionSetRiwayatObatAlkesPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $loadOaPasiens = BKObatalkesPasienT::model()->findAllByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id']));
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
      $criteria->limit = 5;
      $models = ObatalkesM::model()->findAll($criteria);
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
   * hapus LBObatalkespasienT yang sudah ada di database
   * @params obatalkespasien_id
   * di copy dari laboratorium/pemakaianBmhpController
   */
  public function actionHapusObatAlkesPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['pesan'] = "";
      $data['sukses'] = 0;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $loadObatAlkesPasien = ObatalkespasienT::model()->findByPk($_POST['obatalkespasien_id']);
        // var_dump($_POST);die;
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
   * di copy dari laboratorium/pemakaianBmhpController
   */
  protected function kembalikanStok($modObatAlkesPasien)
  {
    $stok = new StokobatalkesT;
    // $stok->attributes = $modObatAlkesPasien->attributes;
    $modObatAlkes = ObatalkesM::model()->findByPk($modObatAlkesPasien->obatalkes_id); //sementara menggunakan harga terupdate
    $stok->obatalkes_id = $modObatAlkes->obatalkes_id;
    $stok->tglkadaluarsa = $modObatAlkes->tglkadaluarsa;
    $stok->tglstok_in = date('Y-m-d H:i:s');
    $stok->tglstok_out = null;
    $stok->qtystok_in = $modObatAlkesPasien->qty_oa;
    $stok->qtystok_out = 0;
    $stok->harganetto = $modObatAlkesPasien->harganetto_oa;
    $stok->jmldiscount = $modObatAlkesPasien->discount;
    $stok->persendiscount = $modObatAlkesPasien->persen_discount;
    $stok->persenppn = $modObatAlkesPasien->persenppnjual;
    $stok->persenpph = 0;
    $stok->persenmargin = 0;
    $stok->jmlmargin = $modObatAlkes->margin;
    $stok->stokoa_aktif = true;
    $stok->satuankecil_id = $modObatAlkesPasien->satuankecil_id;
    $stok->tglterima = $modObatAlkesPasien->tglpelayanan;





    // $stok->hargajual = $modObatAlkes->hargajual;
    // $stok->jasadokter = $modObatAlkes->jasadokter;
    // $stok->discount = $modObatAlkes->discount;
    // $stok->marginresep = $modObatAlkes->marginresep;
    // $stok->marginnonresep = $modObatAlkes->marginnonresep;
    // $stok->hjaresep = $modObatAlkes->hjaresep;
    // $stok->hjanonresep = $modObatAlkes->hjanonresep;
    // $stok->hpp = $modObatAlkes->hpp;
    
   
    // $stok->qtystok_current = $stok->qtystok_in;
    // var_dump($stok->getErrors());die;
    // if ($stok->save())
      return true;
  }

  /**
   * di copy dari laboratorium/pemakaianBmhpController
   * @param type $pendaftaran_id
   */
  public function actionPrint($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modObatAlkesPasien = BKObatalkesPasienT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $judul_print = 'Pemakaian BMHP ' . $modPendaftaran->ruangan->ruangan_nama;
    $this->render($this->path_view . 'printPemakaianBmhp', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPendaftaran' => $modPendaftaran,
      'modObatAlkesPasien' => $modObatAlkesPasien,
    ));
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
      $modObatAlkesPasien = new BKObatalkesPasienT;
      $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
      $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);

      if (count((array)$modStokOAs) > 0) {
        foreach ($modStokOAs as $i => $stok) {
          $modObatAlkesPasien->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
          $modObatAlkesPasien->obatalkes_id = $stok->obatalkes_id;
          $modObatAlkesPasien->qty_oa = $stok->qtystok_terpakai;
          $modObatAlkesPasien->harganetto_oa = $stok->HPP;
          $modObatAlkesPasien->hargasatuan_oa = $stok->HargaJualSatuan;
          $modObatAlkesPasien->qty_stok = $stok->qtystok;
          $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
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

          $form .= $this->renderPartial($this->path_view . '_rowObatAlkesPasien', array('modObatAlkesPasien' => $modObatAlkesPasien), true);
        }
      } else {
        $pesan = "Stok tidak mencukupi!";
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }
}
