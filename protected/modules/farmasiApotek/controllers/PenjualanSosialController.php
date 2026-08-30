<?php

Yii::import('farmasiApotek.controllers.PenjualanResepRSController');
Yii::import('farmasiApotek.views.penjualanResepRS.*');

class PenjualanSosialController extends PenjualanResepRSController
{
  public $defaultAction = 'index';
  public $path_view = 'farmasiApotek.views.penjualanResepRS.';
  public $path_view_sosial = 'farmasiApotek.views.penjualanSosial.';
  public $obatalkespasientersimpan = true; //looping
  public $stokobatalkestersimpan = true; //looping

  public function actionIndex($permohonanoa_id = null, $penjualanresep_id = null)
  {
    $format = new MyFormatter();
    $sukses = false;
    $modPendaftaran = new FAPendaftaranT;
    $modPasien = new FAPasienM;
    $modReseptur = new FAResepturT;
    $modAntrian = new FAAntrianFarmasiT;
    $modPermohonanOa = new FAPermohonanoaT;
    $modObatAlkesPasien = array();
    $instalasi_id = Yii::app()->user->getState('instalasi_id');
    $modReseptur->noresep = MyGenerator::noResep($instalasi_id);
    $modReseptur->noresep_depan = $modReseptur->noresep . '/';
    $modReseptur->tglreseptur = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modReseptur->tglreseptur, 'yyyy-MM-dd hh:mm:ss', 'medium', null));
    $modPenjualan = new FAPenjualanResepT;
    $modPenjualan->tglpenjualan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenjualan->tglpenjualan, 'yyyy-MM-dd hh:mm:ss', 'medium', null));
    $modPenjualan->tglresep = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenjualan->tglresep, 'yyyy-MM-dd hh:mm:ss', 'medium', null));
    $modPenjualan->noresep = MyGenerator::noResep($instalasi_id);;
    $modPenjualan->jenispenjualan = 'PENJUALAN SOSIAL';
    $modPenjualan->carabayar_id = PARAMS::CARABAYAR_ID_GRATIS;
    $modPenjualan->penjamin_id = PARAMS::PENJAMIN_ID_GRATIS;


    $modPenjualan->totharganetto = 0;
    $modPenjualan->totalhargajual = 0;
    $modPenjualan->totaltarifservice = 0;
    $modPenjualan->biayaadministrasi = 0;
    $modPenjualan->biayakonseling = 0;
    $modPenjualan->pembulatanharga = 0;
    $modPenjualan->jasadokterresep = 0;
    $modPenjualan->discount = 0;
    $modPenjualan->subsidiasuransi = 0;
    $modPenjualan->subsidipemerintah = 0;
    $modPenjualan->subsidirs = 0;
    $modPenjualan->iurbiaya = 0;

    $modObatAlkes = array();

    if (!empty($penjualanresep_id)) {
      $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
      if (!empty($modPenjualan->permohonanoa_id)) {
        $modPermohonanOa = FAPermohonanoaT::model()->findByPk($modPenjualan->permohonanoa_id);
      }
      $modObatAlkesPasien = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $modPenjualan->penjualanresep_id));
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $pesan = '';
      if (count((array)$modObatAlkesPasien) > 0) {
        foreach ($modObatAlkesPasien as $i => $value) {
          $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($value->obatalkes_id, $value->qty_oa, $ruangan_id);
          $totalharganetto = 0;
          $totalhargajual = 0;
          if (count((array)$modStokOAs) > 0) {
            foreach ($modStokOAs as $i => $stok) {
              $modObatAlkesPasien[$i] = new FAObatalkesPasienT();
              $modObatAlkesPasien[$i]->stokobatalkes_id = $stok->stokobatalkes_id;
              $modObatAlkesPasien[$i]->qty_oa = $stok->qtystok_terpakai;
              $modObatAlkesPasien[$i]->harganetto_oa = $stok->HPP;
              $modObatAlkesPasien[$i]->hargasatuan_oa = $stok->HargaJualSatuan;
              $modObatAlkesPasien[$i]->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
              $modObatAlkesPasien[$i]->obatalkes_id = $stok->obatalkes_id;
              $modObatAlkesPasien[$i]->satuankecil_id = $stok->satuankecil_id;
              $modObatAlkesPasien[$i]->satuankecil_nama = $stok->satuankecil->satuankecil_nama;
              $modObatAlkesPasien[$i]->jmlstok = $stok->qtystok;
              $modObatAlkesPasien[$i]->subtotal = $modObatAlkesPasien[$i]->hargasatuan_oa * $modObatAlkesPasien[$i]->qty_oa;
              $modObatAlkesPasien[$i]->subsidirs = $modObatAlkesPasien[$i]->hargasatuan_oa * $modObatAlkesPasien[$i]->qty_oa;
              $modObatAlkesPasien[$i]->iurbiaya = $modObatAlkesPasien[$i]->subsidirs - $modObatAlkesPasien[$i]->subtotal;
              $totalharganetto += $modObatAlkesPasien[$i]->harganetto_oa;
              $totalhargajual += $modObatAlkesPasien[$i]->hargasatuan_oa;
            }
          } else {
            $pesan = "Stok obat " . $value->obatalkes->obatalkes_nama . " tidak mencukupi!";
          }
        }
      }
    }

    if (!empty($permohonanoa_id) && empty($penjualanresep_id)) {
      $modPermohonanOa = FAPermohonanoaT::model()->findByPk($permohonanoa_id);
      $modPermohonanOa->pegawaimengetahui_nama = !empty($modPermohonanOa->pegawaimengetahui->NamaLengkap) ? $modPermohonanOa->pegawaimengetahui->NamaLengkap : "";
      $modPermohonanOa->pegawaimenyetujui_nama = !empty($modPermohonanOa->pegawaimenyetujui->NamaLengkap) ? $modPermohonanOa->pegawaimenyetujui->NamaLengkap : "";

      $modDetails = FAPermohonanoadetailT::model()->findAllByAttributes(array('permohonanoa_id' => $modPermohonanOa->permohonanoa_id));
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $pesan = '';
      if (count((array)$modDetails) > 0) {
        foreach ($modDetails as $i => $value) {
          $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($value->obatalkes_id, $value->permohonanoadetail_qty, $ruangan_id);
          $totalharganetto = 0;
          $totalhargajual = 0;
          if (count((array)$modStokOAs) > 0) {
            foreach ($modStokOAs as $i => $stok) {
              $modObatAlkesPasien[$i] = new FAObatalkesPasienT();
              $modObatAlkesPasien[$i]->stokobatalkes_id = $stok->stokobatalkes_id;
              $modObatAlkesPasien[$i]->qty_oa = $stok->qtystok_terpakai;
              $modObatAlkesPasien[$i]->harganetto_oa = $stok->HPP;
              $modObatAlkesPasien[$i]->hargasatuan_oa = $stok->HargaJualSatuan;
              $modObatAlkesPasien[$i]->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
              $modObatAlkesPasien[$i]->obatalkes_id = $stok->obatalkes_id;
              $modObatAlkesPasien[$i]->satuankecil_id = $stok->satuankecil_id;
              $modObatAlkesPasien[$i]->satuankecil_nama = $stok->satuankecil->satuankecil_nama;
              $modObatAlkesPasien[$i]->jmlstok = $stok->qtystok;
              $modObatAlkesPasien[$i]->subtotal = $modObatAlkesPasien[$i]->hargasatuan_oa * $modObatAlkesPasien[$i]->qty_oa;
              $modObatAlkesPasien[$i]->subsidirs = $modObatAlkesPasien[$i]->hargasatuan_oa * $modObatAlkesPasien[$i]->qty_oa;
              $modObatAlkesPasien[$i]->iurbiaya = $modObatAlkesPasien[$i]->subsidirs - $modObatAlkesPasien[$i]->subtotal;
              $modObatAlkesPasien[$i]->permohonanoadetail_id = $value->permohonanoadetail_id;
              $totalharganetto += $modObatAlkesPasien[$i]->harganetto_oa;
              $totalhargajual += $modObatAlkesPasien[$i]->hargasatuan_oa;
            }
          } else {
            $pesan = "Stok obat " . $value->obatalkes->obatalkes_nama . " tidak mencukupi!";
          }
        }
      }
    }
    $modAntrian->tglambilantrian = date('Y-m-d H:i:s');
    $racikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_RACIKAN);
    $nonRacikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_NONRACIKAN);
    $modRacikanDetail = RacikandetailM::model()->findAll(); //load semua data untuk perhitungan js & jquery
    $racikanDetail = array();
    foreach ($modRacikanDetail as $i => $mod) { //convert object to array
      $racikanDetail[$i]['racikandetail_id'] = $mod->racikandetail_id;
      $racikanDetail[$i]['racikan_id'] = $mod->racikan_id;
      $racikanDetail[$i]['qtymin'] = $mod->qtymin;
      $racikanDetail[$i]['qtymaks'] = $mod->qtymaks;
      $racikanDetail[$i]['tarifservice'] = $mod->tarifservice;
    }

    $transaction = Yii::app()->db->beginTransaction();
    if (isset($_POST['FAPenjualanResepT'])) {

      $modPasien = FAPasienM::model()->findByPk(Params::DEFAULT_PASIEN_APOTEK_SOSIAL);
      $modPenjualan = $this->savePenjualanResepSosial($modPasien, $modPermohonanOa, $_POST['FAPenjualanResepT']);
      if ($this->penjualantersimpan) {
        if (count((array)$_POST['FAObatalkesPasienT']) > 0) {
          //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
          $detailGroups = array();
          foreach ($_POST['FAObatalkesPasienT'] as $i => $postDetail) {
            $modDetails[$i] = new FAObatalkesPasienT;
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
        }
        $obathabis = "";
        //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
        foreach ($detailGroups as $i => $detail) {
          $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));

          if (count((array)$modStokOAs) > 0) {
            foreach ($modStokOAs as $i => $stok) {
              $modDetails[$i] = $this->simpanObatAlkesPasien($modPasien, $modPenjualan, $stok, $_POST['FAObatalkesPasienT']);
              $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
            }
          } else {
            $this->stokobatalkestersimpan &= false;
            $obathabis .= "<br>- " . ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
          }
        }
        try {
          if ($this->obatalkespasientersimpan && $this->stokobatalkestersimpan) {
            $transaction->commit();
            $sukses = 1;
            $this->redirect(array('index', 'penjualanresep_id' => $modPenjualan->penjualanresep_id, 'permohonanoa_id' => $modPenjualan->permohonanoa_id, 'sukses' => $sukses));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data detail penjualan resep gagal disimpan !");
            if (!$this->stokobatalkestersimpan) {
              Yii::app()->user->setFlash('error', "Data detail penjualan resep gagal disimpan ! Stok obat berikut tidak mencukupi !:" . $obathabis);
            }
          }
        } catch (Exception $e) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data penjualan resep gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
        }
      }
    }

    $this->render('index', array(
      'modReseptur' => $modReseptur,
      'modPendaftaran' => $modPendaftaran,
      'modPermohonanOa' => $modPermohonanOa,
      'modPenjualan' => $modPenjualan,
      'modAntrian' => $modAntrian,
      'modObatAlkesPasien' => $modObatAlkesPasien,
      'racikan' => $racikan,
      'racikanDetail' => $racikanDetail,
      'nonRacikan' => $nonRacikan,
      'obatAlkes' => $modObatAlkes,
      'sukses' => $sukses,
    ));
  }

  /**
   * 
   * @param type $postsimpan / update pasien
   */
  public function simpanPasienApotek($modPasien, $post)
  {
    $loadPasien = PasienM::model()->findByPk(PARAMS::DEFAULT_PASIEN_APOTEK_SOSIAL);
    if (isset($loadPasien)) {
      $modPasien = $loadPasien;
      $modPasien->update_time = date("Y-m-d H:i:s");
      $modPasien->update_loginpemakai_id = Yii::app()->user->id;
    }
    $modPasien->attributes = $post;
    $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
    $modPasien->no_rekam_medik = MyGenerator::noRekamMedik(Yii::app()->user->getState('mr_apotik'), 'TRUE');
    $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
    $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    $modPasien->ispasienluar = true;
    $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
    $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
    $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
    $modPasien->agama = Params::DEFAULT_AGAMA;
    $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
    $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modPasien->create_time = date("Y-m-d H:i:s");
    $modPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modPasien->save();
    return $modPasien;
  }

  protected function savePenjualanResepSosial($modPasien, $modPermohonanOa, $penjualanResep)
  {
    $format = new MyFormatter();
    $modPenjualan = new FAPenjualanResepT;
    $modPenjualan->attributes = $penjualanResep;
    $modPenjualan->pendaftaran_id = null;
    $modPenjualan->permohonanoa_id = $modPermohonanOa->permohonanoa_id;
    $modPenjualan->penjamin_id = $penjualanResep['penjamin_id'];
    $modPenjualan->carabayar_id = $penjualanResep['carabayar_id'];
    $modPenjualan->antrianfarmasi_id = isset($penjualanResep['antrianfarmasi_id']) ? $penjualanResep['antrianfarmasi_id'] : null;
    $modPenjualan->pegawai_id = $penjualanResep['pegawai_id'];
    $modPenjualan->kelaspelayanan_id = null;
    $modPenjualan->pasien_id = $modPasien->pasien_id;
    $modPenjualan->pasienadmisi_id = null;
    $modPenjualan->tglpenjualan = $format->formatDateTimeForDb($_POST['FAPenjualanResepT']['tglpenjualan']);
    $modPenjualan->tglresep = date('Y-m-d H:i:s');
    $modPenjualan->ruanganasal_nama = 'Apotek Pelayanan 1';
    $modPenjualan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPenjualan->pembulatanharga = Yii::app()->user->getState('pembulatanharga');
    $modPenjualan->noresep = isset($_POST['FAPenjualanResepT']['noresep']) ? $_POST['FAPenjualanResepT']['noresep'] : $_POST['FAResepturT']['noresep'];
    $modPenjualan->subsidiasuransi = 0;
    $modPenjualan->subsidipemerintah = 0;
    $modPenjualan->subsidirs = $penjualanResep['subsidirs'];
    $modPenjualan->iurbiaya = 0;
    $modPenjualan->discount = 0;
    $modPenjualan->create_time = date("Y-m-d H:i:s");
    $modPenjualan->create_loginpemakai_id = Yii::app()->user->id;
    $modPenjualan->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($modPenjualan->validate()) {
      $modPenjualan->save();
      $this->penjualantersimpan = true;
    } else {
      $this->penjualantersimpan = false;
      Yii::app()->user->setFlash('error', "Data Penjualan Resep Tidak valid");
    }

    return $modPenjualan;
  }

  /**
   * simpan ObatalkesPasienT Jumlah Out
   * @param type $modPenjualan
   * @param type $postObatAlkesPasien
   * @return \ObatalkesPasienT
   */
  protected function simpanObatAlkesPasien($modPasien, $modPenjualan, $stokOa, $postObatAlkesPasien)
  {
    $format = new MyFormatter;
    $modObatAlkes = new FAObatalkesPasienT;
    $modObatAlkes->attributes = $stokOa->attributes;
    $modObatAlkes->tglpelayanan = date("Y-m-d H:i:s");
    $modObatAlkes->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    $modObatAlkes->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modObatAlkes->carabayar_id = $modPenjualan->carabayar_id;
    $modObatAlkes->pegawai_id = Yii::app()->user->getState('pegawai_id');
    $modObatAlkes->shift_id = Yii::app()->user->getState('shift_id');
    $modObatAlkes->pendaftaran_id = null;
    $modObatAlkes->pasien_id = $modPasien->pasien_id;
    $modObatAlkes->penjamin_id = $modPenjualan->penjamin_id;
    $modObatAlkes->create_time = date("Y-m-d H:i:s");
    $modObatAlkes->create_loginpemakai_id = Yii::app()->user->id;
    $modObatAlkes->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modObatAlkes->penjualanresep_id = $modPenjualan->penjualanresep_id;
    $modObatAlkes->qty_oa = $stokOa->qtystok_terpakai;
    $modObatAlkes->jmlstok = $stokOa->qtystok;
    $modObatAlkes->harganetto_oa = $stokOa->HPP;
    $modObatAlkes->hargasatuan_oa = $stokOa->HargaJualSatuan;
    $modObatAlkes->hargajual_oa = $modObatAlkes->hargasatuan_oa * $modObatAlkes->qty_oa;
    foreach ($postObatAlkesPasien as $i => $postDetail) {
      if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
        $modObatAlkes->sumberdana_id = $postDetail['sumberdana_id'];
        $modObatAlkes->permohonanoadetail_id = $postDetail['permohonanoadetail_id'];
        $modObatAlkes->r = $postDetail['r'];
        $modObatAlkes->rke = $postDetail['rke'];
        $modObatAlkes->permintaan_oa = $postDetail['permintaan_oa'];
        $modObatAlkes->kekuatan_oa = $postDetail['kekuatan_oa'];
        $modObatAlkes->jmlkemasan_oa = $postDetail['jmlkemasan_oa'];
        $modObatAlkes->iurbiaya = $postDetail['iurbiaya'];
        $modObatAlkes->subsidirs = $postDetail['subsidirs'];
        //                $modObatAlkes->biayaservice = $postDetail['biayaservice'];
        //                $modObatAlkes->biayakonseling = $postDetail['biayakonseling'];
        //                $modObatAlkes->jasadokterresep = $postDetail['jasadokterresep'];
        //                $modObatAlkes->biayakemasan = $postDetail['biayakemasan'];
        //                $modObatAlkes->biayaadministrasi = $postDetail['biayaadministrasi'];
        //                $modObatAlkes->tarifcyto = $postDetail['tarifcyto'];
        //                $modObatAlkes->subsidiasuransi = $postDetail['subsidiasuransi'];
        //                $modObatAlkes->subsidipemerintah = $postDetail['subsidipemerintah'];
        //                $modObatAlkes->subsidirs = $postDetail['subsidirs'];
        //                $modObatAlkes->discount = $postDetail['discount'];
        $modObatAlkes->signa_oa = $postDetail['signa_oa'];
        $modObatAlkes->etiket = $postDetail['etiket'];
      }
    }

    if ($modObatAlkes->save()) {
      $this->obatalkespasientersimpan &= true;
    } else {
      $this->obatalkespasientersimpan &= false;
    }
    return $modObatAlkes;
  }

  /**
   * set dropdown penjamin pasien dari carabayar_id
   * @param type $encode
   * @param type $namaModel
   */
  public function actionSetDropdownPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
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
      $obatalkes_id = $_POST['obatalkes_id'];
      $jumlah = $_POST['jumlah'];
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modObatAlkesPasien = new FAObatalkesPasienT;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
      if (count((array)$modStokOAs) > 0) {

        foreach ($modStokOAs as $i => $stok) {
          $modObatAlkesPasien->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
          $modObatAlkesPasien->obatalkes_id = $stok->obatalkes_id;
          $modObatAlkesPasien->qty_oa = $stok->qtystok_terpakai;
          $modObatAlkesPasien->harganetto_oa = $stok->HPP;
          $modObatAlkesPasien->hargasatuan_oa = $stok->HargaJualSatuan;
          $modObatAlkesPasien->jmlstok = $stok->qtystok;
          $modObatAlkesPasien->r = 'R/';
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

          $form .= $this->renderPartial($this->path_view_sosial . '_rowDetail', array('modObatAlkesPasien' => $modObatAlkesPasien), true);
        }
      } else {
        $pesan = "Stok tidak mencukupi!";
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  /**
   * untuk print data penjualan dokter
   */
  public function actionPrint($penjualanresep_id, $caraPrint = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
    $modPenjualanDetail = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $penjualanresep_id));
    if (!empty($modPenjualan->permohonanoa_id)) {
      $modPermohonanOa = FAPermohonanoaT::model()->findByPk($modPenjualan->permohonanoa_id);
    }

    $judul_print = 'Surat Serah Terima Barang';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render($this->path_view_sosial . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPenjualan' => $modPenjualan,
      'modPenjualanDetail' => $modPenjualanDetail,
      'modPermohonanOa' => $modPermohonanOa,
      'caraPrint' => $caraPrint
    ));
  }
}
