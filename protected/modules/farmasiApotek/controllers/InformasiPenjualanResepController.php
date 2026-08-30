<?php

class InformasiPenjualanResepController extends MyAuthController
{
  public $suksesRetur = false;
  public $suksesUbahJualResep = false;
  public $suksesReturStok = true; //karna di looping
  public $suksesUpdateObatAlkesPasien = true; //karna di looping
  public $stokobatalkestersimpan = true; //karna di looping
  public $obatalkespasientersimpan = true; //karna di looping
  public $path_view = 'farmasiApotek.views.informasiPenjualanResep.';
  public $path_view_RS = 'farmasiApotek.views.penjualanResepRS.';

  public function actionIndex()
  {
    $modInfoPenjualan = new FAInformasipenjualanresepV('searchInfoJualResep');
    $format = new MyFormatter();
    $modInfoPenjualan->unsetAttributes();
    $modInfoPenjualan->tgl_awal = date('Y-m-d');
    $modInfoPenjualan->tgl_akhir = date('Y-m-d');
    if (isset($_GET['FAInformasipenjualanresepV'])) {
      $modInfoPenjualan->attributes = $_GET['FAInformasipenjualanresepV'];
      $modInfoPenjualan->tgl_awal = $format->formatDateTimeForDb($_GET['FAInformasipenjualanresepV']['tgl_awal']);
      $modInfoPenjualan->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInformasipenjualanresepV']['tgl_akhir']);
      $modInfoPenjualan->statusperiksa = $_GET['FAInformasipenjualanresepV']['statusperiksa'];
    }

    $modCatatanpemberianobat = CatatanpemberianobatT::model()->findAllByAttributes(array(
      'obatalkespasien_id' => $modInfoPenjualan->obatalkespasien_id,
      'pendaftaran_id'=>$modInfoPenjualan->pendaftaran_id,
      'pasien_id'=>$modInfoPenjualan->pasien_id,
    ), array('order' => 'obatalkespasien_id asc'));


    $this->render('index', array('format' => $format, 'modInfoPenjualan' => $modInfoPenjualan, 'modCatatanpemberianobat' => $modCatatanpemberianobat));
  }

  public function actionDetailPenjualan($id, $pasien_id)
  {
    $this->layout = '//layouts/iframe';

    $modDetailPenjualan = FAInformasipenjualanresepV::model()->findAll('penjualanresep_id=' . $id . ' and pasien_id=' . $pasien_id . '');
    $modReseptur = FAPenjualanResepT::model()->findByPk($id);


    $detailreseptur = FAObatalkesPasienT::model()->findAll('penjualanresep_id = ' . $id . ' ');
    $modPasien = FAPasienM::model()->findByPk($pasien_id);

    $this->render('/informasiPenjualanResep/DetailPenjualan', array(
      'modDetailPenjualan' => $modDetailPenjualan,
      'modReseptur' => $modReseptur, 'detailreseptur' => $detailreseptur
    ));
  }

  /**
   * method retur penjualan resep yang sudah dibayar
   * digunakan di
   * 1. farmasi Apotek -> informasi penjualan resep -> retur penjualan
   * 2. farmasi Apotek -> informasi resep pasien Rs -> retur penjualan
   * @param integer $penjualanresep_id penjualanresep_id
   */
  public function actionReturPenjualan($penjualanresep_id = null, $id = null, $belumbayar = 0)
  {
    $this->layout = '//layouts/iframe';
    $modRetur = new FAReturresepT;
    $modReturDetail = array();
    $modPenjualanResep = array();
    $modObatAlkesPasien = array();
    $modPasien = array();
    $modPendaftaran = array();
    $modRetur->tglretur = date('Y-m-d H:i:s');
    $modRetur->noreturresep = "-- Otomatis --";
    $modRetur->pegretur_id = Yii::app()->user->getState('pegawai_id');
    $modRetur->belumbayar = $belumbayar == 1 ? true : false;
    $infoJualObat = FAInformasipenjualanapotikV::model()->findByAttributes(array('penjualanresep_id' => $penjualanresep_id));
    // die;
    new ObatalkesM; //ini agar data obat yang berelasi dengan ObatalkespasienT muncul

    if (!empty($id)) {
      $modRetur = FAReturresepT::model()->findByPk($id);
      $modReturDetail = FAReturresepdetT::model()->findAllByAttributes(array('returresep_id' => $id));
      $modPenjualanResep = FAPenjualanResepT::model()->findByPk($modRetur->penjualanresep_id);
      $modRetur->penjualanresep_id = $modPenjualanResep->penjualanresep_id;
      $modObatAlkesPasien = ObatalkespasienT::model()->findAllByAttributes(array('penjualanresep_id' => $modPenjualanResep->penjualanresep_id), "returresepdet_id IS NOT NULL");
      $modPasien = PasienM::model()->findByPk($modPenjualanResep->pasien_id);
      if (empty($modPenjualanResep->pendaftaran_id)) {
        $modPendaftaran = new PendaftaranT;
      } else {
        $modPendaftaran = PendaftaranT::model()->findByPk($modPenjualanResep->pendaftaran_id);
      }
    }

    if (!empty($penjualanresep_id)) { // && empty($id)){
      if (isset($_GET['sukses'])) {
        $modPenjualanResep = FAPenjualanResepT::model()->findByAttributes(array('penjualanresep_id' => $penjualanresep_id));
      } else {
        $modPenjualanResep = FAPenjualanResepT::model()->findByAttributes(array('penjualanresep_id' => $penjualanresep_id, 'returresep_id' => null));
      }
      //var_dump(count((array)$modPenjualanResep));die;
      if (count((array)$modPenjualanResep) > 0) {
        $modRetur->penjualanresep_id = $modPenjualanResep->penjualanresep_id;
        $modRetur->mengetahui_id = $modPenjualanResep->pegawai_id;
        $modObatAlkesPasien = ObatalkespasienT::model()->findAllByAttributes(array('penjualanresep_id' => $modPenjualanResep->penjualanresep_id));
        $modPasien = PasienM::model()->findByPk($modPenjualanResep->pasien_id);
        $modPendaftaran = PendaftaranT::model()->findByPk($modPenjualanResep->pendaftaran_id);
        //default nilai retur berdasarkan penjualan detail
        foreach ($modObatAlkesPasien as $i => $mod) {
          $modReturDetail[$i] = new FAReturresepdetT;
          $modReturDetail[$i]->attributes = $mod->attributes;
          //                    $modReturDetail[$i]->satuankecil_id = empty($mod->satuankecil_id) ? $mod->satuankecil_id : ObatalkesM::model()->findByPk($mod->obatalkes_id)->satuankecil_id;
          //                    $modReturDetail[$i]->qty_retur = $mod->qty_oa;
          //                    $modReturDetail[$i]->hargasatuan = $mod->hargasatuan_oa;
        }
      } else {
        $modul_id =  Yii::app()->session['modul_id'];
        echo '<script type="text/javascript">parent.location.href="' . Yii::app()->createUrl("farmasiApotek/InformasiPenjualanResep/Index", array('modul_id' => $modul_id)) . '";</script>';
        Yii::app()->user->setFlash('info', "Maaf, data resep sudah diretur sebelumnya");
        exit();
      }
    }


    if (isset($_POST['FAReturresepT']) && empty($id)) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $sukses = true;
        $modRetur = $this->saveReturResep($modRetur, $_POST, $belumbayar);
        $modReturDetail = $this->saveReturResepDetail($modRetur, $modReturDetail, $_POST['FAReturresepdetT']);
        $modObatAlkesPasien = $this->updateObatAlkesPasien($modReturDetail, $modPenjualanResep);

        $this->broadcastReturResep($modRetur);
        //                  TIDAK ADA RETUR PEMBAYARAN KARENA RETUR DILAKUKAN APABILA PASIEN BELUM MEMBAYAR  <<< $returPembayaran = $this->saveReturPembayaran($modRetur, $modReturDetail);
        if ($this->suksesRetur  && $this->suksesReturStok && $this->suksesUpdateObatAlkesPasien) { //&& $this->suksesReturBayar

          //if ($belumbayar == 0){
          //}

          //var_dump($modPenjualanResep->penjualanresep_id);die;
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('returPenjualan', 'penjualanresep_id' => $modPenjualanResep->penjualanresep_id, 'id' => $modRetur->returresep_id, 'sukses' => $sukses));
        } else {
          $modRetur->isNewRecord = true;
          $transaction->rollback();
          if (!$this->suksesRetur)
            Yii::app()->user->setFlash('error', "Data gagal disimpan!");
          if (!$this->suksesReturStok)
            Yii::app()->user->setFlash('error', "Stok Obat Alkes gagal diretur!");
          if (!$this->suksesUpdateObatAlkesPasien)
            Yii::app()->user->setFlash('error', "Transaksi Resep Gagal diubah!");
        }
      } catch (Exception $exc) {
        $modRetur->isNewRecord = true;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    //echo "<pre>";print_r($modPenjualanResep->attributes);exit();
    $this->render('returPenjualan', array(
      'infoJualObat' => $infoJualObat,
      'modPenjualanResep' => $modPenjualanResep,
      'modObatAlkesPasien' => $modObatAlkesPasien,
      'modRetur' => $modRetur,
      'modReturDetail' => $modReturDetail,
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran,
      'belumbayar' => $belumbayar
    ));
  }
  /**
   * saveReturResep = simpan returresep_t
   * @param type $modRetur
   * @param type $retur
   * @return type
   */
  protected function saveReturResep($modRetur, $post, $belumbayar = 0)
  {
    $retur = $post['FAReturresepT'];
    $modRetur->attributes = $retur;
    if ($belumbayar == 0) {
      $modRetur->noreturresep = MyGenerator::noReturResep();
    } else {
      $modRetur->noreturresep = MyGenerator::noReturResepStok();
    }
    $modRetur->tglretur = date('Y-m-d H:i:s');
    $modRetur->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modRetur->belumbayar = $belumbayar == 1 ? true : false;

    if (isset($post['FAPenjualanResepT']['pendaftaran_id'])) {
      $modRetur->pendaftaran_id = $post['FAPenjualanResepT']['pendaftaran_id'];
    }
    if (isset($post['FAPenjualanResepT']['pasienadmisi_id'])) {
      $modRetur->pasienadmisi_id = $post['FAPenjualanResepT']['pasienadmisi_id'];
    }

    // var_dump($post, $modRetur->attributes, $modRetur->validate(), $modRetur->errors); die;

    if ($modRetur->validate()) {
      if ($modRetur->save()) {
        $this->suksesRetur = true;
        if ($belumbayar == 0)
          FAPenjualanResepT::model()->updateByPk($modRetur->penjualanresep_id, array('returresep_id' => $modRetur->returresep_id));
      }
    }

    // var_dump($this->suksesRetur); die;
    return $modRetur;
  }
  /**
   * cek hak akses khusus untuk transaksi (action) tertentu
   * RND-8049
   */
  public function actionCekHakAkses($action)
  {
    $data['cekAkses'] = false;
    //            DIKOMEN KARNA WAJIB LOGIN DAHULU SEBELUM MEMBATALKAN RND-8049
    //            if($this->checkAccess(array('action'=>$action))){ //MyAuthController
    //                //echo 'punya hak akses';
    //                $data['cekAkses'] = true;
    //                $data['userid'] = Yii::app()->user->id;
    //                $data['username'] = Yii::app()->user->name;
    //            }

    echo CJSON::encode($data);
    Yii::app()->end();
  }
  /**
   * submit login dari dialog login
   * @param type $action
   */
  public function actionAjaxLogin()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $data['pesan'] = '';

      $log = LoginpemakaiK::model()->findByAttributes(array('nama_pemakai' => $_POST['username'], 'loginpemakai_aktif' => true));
      $cek = $log->cekPassword3($_POST['password']);


      $untukaction = $_POST['untukaction'];

      //$loadLoginPemakai = LoginpemakaiK::model()->findByAttributes(array('nama_pemakai'=>$username, 'katakunci_pemakai'=>$password),'loginpemakai_aktif = TRUE');
      if ($cek) {
        if ($this->checkAccess(array('loginpemakai_id' => $log->loginpemakai_id, 'action' => $untukaction))) {
          $data['sukses'] = 1;
        }
      } else {
        $data['pesan'] = 'Login gagal! Silakan masukan nama pemakai dan kata kunci dengan benar!';
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * saveReturResepDetail = simpan returresepdet_t
   * @param type $modRetur
   * @param type $modReturDetail
   * @param type $returdetail
   * @return type
   */
  protected function saveReturResepDetail($modRetur, $modReturDetail, $returdetail)
  {
    if (count((array)$returdetail) > 0) {
      foreach ($returdetail as $i => $detail) {
        if (isset($detail['isRetur']) && $detail['isRetur'] == true && $detail['qty_retur'] > 0) {
          $modReturDetail[$i]->attributes = $modRetur->attributes;
          $modReturDetail[$i]->returresep_id = $modRetur->returresep_id;
          $modReturDetail[$i]->obatalkespasien_id = $detail['obatalkespasien_id'];
          $modReturDetail[$i]->satuankecil_id = $detail['satuankecil_id'];
          $modReturDetail[$i]->qty_retur = $detail['qty_retur'];
          $modReturDetail[$i]->hargasatuan = $detail['hargasatuan'];
          $modReturDetail[$i]->kondisibrg = $detail['kondisibrg'];

          // var_dump($modReturDetail[$i]->attributes);

          if ($modReturDetail[$i]->validate()) {
            $modReturDetail[$i]->save();
            //Update returresepdet_id pada obatalkespasien_t yang ada
            if ($modRetur->belumbayar == 0) ObatalkespasienT::model()->updateByPk($modReturDetail[$i]->obatalkespasien_id, array('returresepdet_id' => $modReturDetail[$i]->returresepdet_id));
            $this->returStok($modReturDetail[$i]);
          }
        }
      }
    }
    $this->simpanJurnalReturOA($modRetur, $modReturDetail);

    return $modReturDetail;
  }


  protected function simpanJurnalReturOA($modRetur, $modReturDetail)
  {

    // var_dump($modRetur->attributes);

    $ok = true;

    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $pendaftaran = PendaftaranT::model()->findByPk($modRetur->pendaftaran_id);
    $pasien_kunjungan = "";

    if (!empty($pendaftaran)) {
      $pasien_kunjungan = " - " . $pendaftaran->no_pendaftaran . " - " . $pendaftaran->pasien->nama_pasien;
    }


    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->tglbuktijurnal = $modRetur->tglretur;
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRekTanggal($modRetur->tglretur, 'JPS');
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $modRetur->noreturresep;
    $modJurnalRekening->tglreferensi = $modRetur->tglretur;
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = 'Retur Resep - ' . $modRetur->noreturresep . $pasien_kunjungan;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PERSEDIAAN;
    $modJurnalRekening->rekperiod_id = $period;
    $modJurnalRekening->create_time = $modRetur->tglretur;
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->returresep_id = $modRetur->returresep_id;


    $rekDetailD = array();
    $rekDetailK = array();

    if ($modJurnalRekening->validate()) {
      $ok = $ok && $modJurnalRekening->save();

      foreach ($modReturDetail as $item) {
        if (count((array)$item->errors) > 0) {
          $ok = false;
          continue;
        }

        $oa = ObatalkespasienT::model()->findByPk($item->obatalkespasien_id);
        $master = ObatalkesM::model()->findByPk($oa->obatalkes_id);
        $hpp = round($oa->harganetto_oa * $item->qty_retur * (100 + $oa->persenppnjual) / 100);
        $rekD = JnsobatalkesrekM::model()->findByAttributes(array(
          'jenisobatalkes_id' => $master->jenisobatalkes_id,
          'debitkredit' => 'D',
          'isreturoa' => true,
        ));
        $rekK = JnsobatalkesrekM::model()->findByAttributes(array(
          'jenisobatalkes_id' => $master->jenisobatalkes_id,
          'debitkredit' => 'K',
          'isreturoa' => true,
        ));

        // var_dump($item->attributes, $master->jenisobatalkes_id);

        if (!empty($rekD)) {
          if (empty($rekDetailD[$rekD->rekening5_id])) {
            $rekDetailD[$rekD->rekening5_id] = $hpp;
          } else {
            $rekDetailD[$rekD->rekening5_id] += $hpp;
          }
        }

        // debit
        if (!empty($rekK)) {
          if (empty($rekDetailK[$rekK->rekening5_id])) {
            $rekDetailK[$rekK->rekening5_id] = $hpp;
          } else {
            $rekDetailK[$rekK->rekening5_id] += $hpp;
          }
        }
      }

      $urut = 1;
      foreach ($rekDetailD as $rek5 => $item) {

        $rek = RekeningakuntansiV::model()->findByAttributes(array(
          'rekeninglast_id' => $rek5,
        ));

        $det = new JurnaldetailT();
        $det->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
        $det->rekperiod_id = $modJurnalRekening->rekperiod_id;
        $det->uraiantransaksi = $modJurnalRekening->urianjurnal;
        $det->rekening5_id = $rek5;
        // $det->rekening4_id = $rek->rekening4_id;
        // $det->rekening3_id = $rek->rekening3_id;
        // $det->rekening2_id = $rek->rekening2_id;
        // $det->rekening1_id = $rek->rekening1_id;
        $det->saldodebit = $item;
        $det->saldokredit = 0;
        $det->nourut = $urut++;

        $ok = $ok && $det->save();
      }

      foreach ($rekDetailK as $rek5 => $item) {

        $rek = RekeningakuntansiV::model()->findByAttributes(array(
          'rekeninglast_id' => $rek5,
        ));

        $det = new JurnaldetailT();
        $det->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
        $det->rekperiod_id = $modJurnalRekening->rekperiod_id;
        $det->uraiantransaksi = $modJurnalRekening->urianjurnal;
        $det->rekening5_id = $rek5;
        // $det->rekening4_id = $rek->rekening4_id;
        // $det->rekening3_id = $rek->rekening3_id;
        // $det->rekening2_id = $rek->rekening2_id;
        // $det->rekening1_id = $rek->rekening1_id;
        $det->saldodebit = 0;
        $det->saldokredit = $item;
        $det->nourut = $urut++;

        $ok = $ok && $det->save();
      }
    } else {
      $ok = false;
    }

    $this->suksesRetur = $this->suksesRetur && $ok;
  }

  /**
   * updateObatAlkesPasien untuk transaksi retur resep
   * @param type $modDetailRetur
   */
  protected function updateObatAlkesPasien($modReturDetail, $modPenjualanResep)
  {
    $modObatAlkesPasienUpdate = array();
    $totalHargaJual = 0;
    $totalHargaNetto = 0;
    $pembulatan = 0;
    $totalpembulatan = 0;
    foreach ($modReturDetail as $i => $mod) {
      if ($mod->returresepdet_id != "") {
        $modObatAlkesPasienUpdate[$i] = ObatalkespasienT::model()->findByPk($mod->obatalkespasien_id);
        $modObatAlkesPasienUpdate[$i]->qty_oa = $modObatAlkesPasienUpdate[$i]->qty_oa - $mod->qty_retur;
        $modObatAlkesPasienUpdate[$i]->hargajual_oa = $modObatAlkesPasienUpdate[$i]->qty_oa * $modObatAlkesPasienUpdate[$i]->hargasatuan_oa;
        if ($modObatAlkesPasienUpdate[$i]->validate()) { //update
          $modObatAlkesPasienUpdate[$i]->save();
          $this->suksesUpdateObatAlkesPasien = $this->suksesUpdateObatAlkesPasien && true;
        } else {
          $this->suksesUpdateObatAlkesPasien = false;
        }
      }
    }
    //Update Total Penjualan
    $this->suksesUpdateObatAlkesPasien = $modPenjualanResep->updateByObatalkespasienT();

    return $modObatAlkesPasienUpdate;
  }

  /**
   * returStok hanya boleh dilakukan apabila ada ubah retur (pengembalian belum bayar) atau batal transaksi
   * @param type $obatAlkesT
   * @return type
   */
  protected function returStok($modReturDetail)
  {
    $format = new MyFormatter();
    $modObat = ObatalkesM::model()->findByPk($modReturDetail->obatpasien->obatalkes_id);

    $modStokObat = new StokobatalkesT;
    $modStokObat->attributes = $modReturDetail->attributes;
    $modStokObat->satuankecil_id = $modReturDetail->obatpasien->satuankecil_id;
    $modStokObat->obatalkes_id = $modReturDetail->obatpasien->obatalkes_id;
    $modStokObat->harganetto = $modReturDetail->obatpasien->harganetto_oa;
    //            $modStokObat->hargajual_oa = $modReturDetail->obatpasien->hargasatuan_oa;
    $modStokObat->tglstok_in = date('Y-m-d H:i:s');
    $modStokObat->tglstok_out = null;
    $modStokObat->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modStokObat->qtystok_in = $modReturDetail->qty_retur;
    $modStokObat->qtystok_out = 0;
    $modStokObat->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modStokObat->create_loginpemakai_id = Yii::app()->user->id;
    $modStokObat->create_time = date('Y-m-d H:i:s');
    $modStokObat->update_loginpemakai_id = null;
    $modStokObat->terimamutasidetail_id = null;
    $modStokObat->penerimaandetail_id = null;
    $modStokObat->tglkadaluarsa = $format->formatDateTimeForDb($modObat->tglkadaluarsa);
    $modStokObat->tglterima = date('Y-m-d H:i:s');
    $modStokObat->persenppn = $modObat->ppn_persen;
    $modStokObat->persenmargin = $modObat->margin;
    $modStokObat->create_time = date('Y-m-d H:i:s');
    $modStokObat->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modStokObat->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
    //var_dump($modStokObat->attributes);die;
    //            if(!empty($modObat->obatalkes_id)){
    //                $modStokObat->hjaresep = $modObat->hjaresep;
    //                $modStokObat->hjanonresep = $modObat->hjanonresep;
    //                $modStokObat->marginresep = $modObat->marginresep;
    //                $modStokObat->marginnonresep = $modObat->marginnonresep;
    //                $modStokObat->hpp = $modObat->hpp;
    //            }
    //            echo "<pre>";
    //            print_r($modStokObat->attributes);exit;
    if ($modStokObat->validate()) {
      $modStokObat->save();
      $this->suksesReturStok = $this->suksesReturStok && true;
    } else {
      $this->suksesReturStok = false;
    }
  }

  /**
   * Fungsi actionUbahPenjualanResep khusus untuk mengubah data lama transaksi Penjualan Resep &  Penjualan Resep Luar
   * di tabel informasi penjualan
   * RND-4546
   */
  public function actionUbahPenjualanResep($idPenjualan)
  {
    $format = new MyFormatter();
    $racikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_RACIKAN);
    $nonRacikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_NONRACIKAN);
    $modRacikanDetail = RacikandetailM::model()->findAll(); //load semua data untuk perhitungan js & jquery
    $racikanDetail = array();
    $modAntrian = new FAAntrianFarmasiT;
    $sukses = 0;
    foreach ($modRacikanDetail as $i => $mod) { //convert object to array
      $racikanDetail[$i]['racikandetail_id'] = $mod->racikandetail_id;
      $racikanDetail[$i]['racikan_id'] = $mod->racikan_id;
      $racikanDetail[$i]['qtymin'] = $mod->qtymin;
      $racikanDetail[$i]['qtymaks'] = $mod->qtymaks;
      $racikanDetail[$i]['tarifservice'] = $mod->tarifservice;
    }
    if (isset($idPenjualan)) {
      $modPenjualan = FAPenjualanResepT::model()->findByPk($idPenjualan);
      $modPendaftaran = FAPendaftaranT::model()->findByPk($modPenjualan->pendaftaran_id);
      $modPasien = FAPasienM::model()->findByPk($modPenjualan->pasien_id);
      $modPasien->tanggal_lahir = $format->formatDateTimeForUser($modPasien->tanggal_lahir);
      $modReseptur = FAResepturT::model()->findByAttributes(array('penjualanresep_id' => $idPenjualan));

      $modPenjualan->tglresep = MyFormatter::formatDateTimeForUser($modPenjualan->tglresep);
      $modPenjualan->tglpenjualan = MyFormatter::formatDateTimeForUser($modPenjualan->tglpenjualan);

      if (empty($modReseptur->noresep)) //jika tidak ada reseptur
        $modReseptur = new FAResepturT;
      if (!empty($modPenjualan)) {
        $modPenjualan->isNewRecord = false;
        $obatAlkes = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $modPenjualan->penjualanresep_id));
      }
    }


    if (isset($_POST['FAPenjualanResepT']) && (isset($_POST['FAResepturT'])) && (isset($_POST['FAObatalkesPasienT']))) {
      // echo "<pre>";
      // var_dump($_POST);die;
      $modPenjualan->tglresep = $format->formatDateTimeForDb($modPenjualan->tglresep);
      $modPenjualan->tglpenjualan = $format->formatDateTimeForDb($modPenjualan->tglpenjualan);
      $transaction = Yii::app()->db->beginTransaction();

      // var_dump($_POST);

      $totnetto = 0;
      $totjual = 0;

      try {
        //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
        $detailGroups = array();
        foreach ($_POST['FAObatalkesPasienT'] as $i => $postDetail) {

          // var_dump($postDetail);

          if (empty($postDetail['obatalkespasien_id'])) {
            $oa = ObatalkesM::model()->findByPk($postDetail['obatalkes_id']);
            $modDetails[$i] = new FAObatalkesPasienT;
            $modDetails[$i]->attributes = $postDetail;
            // var_dump($modDetails[$i]->racikan_id);
            $modDetails[$i]->penjualanresep_id = $modPenjualan->penjualanresep_id;
            $modDetails[$i]->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
            $modDetails[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modDetails[$i]->shift_id = Yii::app()->user->getState('shift_id');
            $modDetails[$i]->pendaftaran_id = $modPenjualan->pendaftaran_id;
            $modDetails[$i]->pasien_id = $modPenjualan->pasien_id;
            $modDetails[$i]->carabayar_id = $modPenjualan->carabayar_id;
            $modDetails[$i]->penjamin_id = $modPenjualan->penjamin_id;
            $modDetails[$i]->permintaan_oa = 0;
            // if (empty($modDetails[$i]->racikan_id)) $modDetails[$i]->racikan_id = Params::RACIKAN_ID_NONRACIKAN;
            $modDetails[$i]->pegawai_id = $modPenjualan->pegawai_id;
            $modDetails[$i]->tglpelayanan = date("Y-m-d H:i:s");
            $modDetails[$i]->satuankecil_id = $oa->satuankecil_id;
            $modDetails[$i]->r = "R/";
            $modDetails[$i]->qty_oa = MyFormatter::formatRupiahForDB($postDetail['qty_oa']);
            // var_dump($_POST['obatlain']);die;
            if (!empty($_POST['obatlain'])){
              $modDetails[$i]->obatalkes_nama = $_POST['obatlain'];
          }

            //var_dump($postDetail);

            //$modDetails[$i]->hargajual_oa = $postDetail['hargajual_reseptur'];
            //$modDetails[$i]->harganetto_oa = $postDetail['harganetto_reseptur'];
            //$modDetails[$i]->hargasatuan_oa = $postDetail['hargasatuan_reseptur'];
            //$modDetails[$i]->signa_oa = $postDetail['signa_reseptur'];
            $modDetails[$i]->create_time = date("Y-m-d H:i:s");
            $modDetails[$i]->create_loginpemakai_id = Yii::app()->user->id;
            $modDetails[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modDetails[$i]->kelaspelayanan_id = $modPenjualan->kelaspelayanan_id;
            $modDetails[$i]->pasienadmisi_id = $modPenjualan->pasienadmisi_id;


            if ($modDetails[$i]->validate()) {
              $this->obatalkespasientersimpan &= $modDetails[$i]->save();
              $this->simpanStokObatAlkesOut2($modDetails[$i]);
              $totnetto += $modDetails[$i]->harganetto_oa * $modDetails[$i]->qty_oa;
              $totjual += $modDetails[$i]->hargajual_oa * $modDetails[$i]->qty_oa;
            } else {
              $this->obatalkespasientersimpan &= false;
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
                            }
                             *
                             */
          } else {
            $modDetails[$i] = ObatalkespasienT::model()->findByPk($postDetail['obatalkespasien_id']);

            $modDetails[$i]->qty_oa = MyFormatter::formatRupiahForDB($postDetail['qty_oa']);
            $modDetails[$i]->hargajual_oa = $postDetail['hargajual_oa'];
            $modDetails[$i]->signa_oa = $postDetail['signa_oa'];
            $modDetails[$i]->iurbiaya = 0;
            $modDetails[$i]->update_loginpemakai_id = Yii::app()->user->id;
            $modDetails[$i]->update_time = date('Y-m-d H:i:s');
            if ($modDetails[$i]->validate()) {
              $this->obatalkespasientersimpan &= $modDetails[$i]->save();
              StokobatalkesT::model()->deleteAllByAttributes(array('obatalkespasien_id' => $modDetails[$i]->obatalkespasien_id));
              $this->simpanStokObatAlkesOut2($modDetails[$i]);

              $totnetto += $modDetails[$i]->harganetto_oa * $modDetails[$i]->qty_oa;
              $totjual += $modDetails[$i]->hargajual_oa * $modDetails[$i]->qty_oa;
            } else {
              $this->obatalkespasientersimpan &= false;
            }


            // var_dump($modDetails[$i]->attributes);
          }
        }
        // die;
        // Hapus OA Pasien //
        if (isset($_POST['oahapus_id'])) {
          if (trim($_POST['oahapus_id']) != "") {
            $oahapus_id = explode(" ", trim($_POST['oahapus_id']));
            foreach ($oahapus_id as $item) {
              StokobatalkesT::model()->deleteAllByAttributes(array('obatalkespasien_id' => $item));
              ObatalkespasienT::model()->deleteByPk($item);
            }
          }
        }


        // die;



        //END GROUP
        /*
                    $obathabis = "";
                    //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
                    foreach($detailGroups AS $i => $detail){
                        $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
                        if(count((array)$modStokOAs) > 0){
                            foreach($modStokOAs AS $i => $stok){
                                $modDetails[$i] = $this->simpanObatAlkesPasien($modPendaftaran, $modPenjualan, $stok, $_POST['FAObatalkesPasienT'] );
                                $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
                            }
                        }else{
                            $this->stokobatalkestersimpan &= false;
                            $obathabis .= "<br>- ".ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;

                        }
                    }
                     *
                     */
        $modPenjualan = $this->ubahJualResep($modPenjualan, $_POST['FAPenjualanResepT'], $totnetto, $totjual);

        // var_dump($this->suksesUbahJualResep); die;

        if ($this->suksesUbahJualResep) {
          $transaction->commit();
          $sukses = 1;
          $this->redirect(array('UbahPenjualanResep', 'idPenjualan' => $idPenjualan, 'sukses' => $sukses));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data detail penjualan resep gagal disimpan !");
          if (!$this->stokobatalkestersimpan) {
            Yii::app()->user->setFlash('error', "Data detail penjualan resep gagal disimpan ! Stok obat berikut tidak mencukupi !:" . $obathabis);
          }
        }
      } catch (Exception $e) {
        var_dump($e->getMessage());die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data penjualan resep gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }
    //Pisahkan no resep depan belakang

    // var_dump($modPenjualan->attributes); die;

    $modPenjualan->noresep_depan = substr($modPenjualan->noresep, 0, 21);
    $modPenjualan->noresep_belakang = substr($modPenjualan->noresep, 21, 100);
    $this->render($this->path_view . 'ubahPenjualan', array(
      'modReseptur' => $modReseptur,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'obatAlkes' => $obatAlkes,
      'modPenjualan' => $modPenjualan,
      'modAntrian' => $modAntrian,
      'racikan' => $racikan,
      'racikanDetail' => $racikanDetail,
      'nonRacikan' => $nonRacikan,
      'sukses' => $sukses,
    ));
  }

  protected function ubahJualResep($modPenjualan, $penjualanResep, $totnetto = null, $totjual = null)
  {
    $modPenjualan->totalhargajual = !empty($totjual) ? $totjual : $penjualanResep['totalhargajual'];
    $modPenjualan->totaltarifservice = $penjualanResep['totaltarifservice'];
    $modPenjualan->totharganetto = !empty($totnetto) ? $totnetto : $penjualanResep['totharganetto'];
    $modPenjualan->update_loginpemakai_id = Yii::app()->user->id;
    $modPenjualan->update_time = date('Y-m-d H:i:s');
    if ($modPenjualan->save())
      $this->suksesUbahJualResep = true;
    return $modPenjualan;
  }

  /**
   * menampilkan obat
   * @return row table
   */
  public function actionSetFormObatAlkesPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = $_POST['obatalkes_id'];
      $jumlah = str_replace(",", ".", trim($_POST['jumlah']));
      $therapiobat_id = isset($_POST['therapiobat_id']) ? $_POST['therapiobat_id'] : null;
      $penggunaan_oa = isset($_POST['penggunaan_oa']) ? $_POST['penggunaan_oa'] : null;
      $racikan = isset($_POST['racikan']) ? $_POST['racikan'] : false;
      $obatlain = !empty($_POST['obatlain']) ? $_POST['obatlain'] : "-";



      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modObatAlkesPasien = new FAObatalkesPasienT;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      // $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
      $oa = ObatalkesM::model()->findByPk($obatalkes_id);
      $jmlStok = StokobatalkesT::getJumlahStok($obatalkes_id, $ruangan_id);
      //if(count((array)$modStokOAs) > 0){

      //    foreach($modStokOAs AS $i => $stok){
      $modObatAlkesPasien->sumberdana_id = $oa->sumberdana_id; //(isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
      $modObatAlkesPasien->obatalkes_id = $oa->obatalkes_id; //$stok->obatalkes_id;
      $modObatAlkesPasien->qty_oa = $jumlah; //ceil($stok->qtystok_terpakai); // LNG Ceil (Pembulatan keatas request pak tito)
      $modObatAlkesPasien->harganetto_oa = $oa->harganetto; //$stok->HPP;
      $modObatAlkesPasien->hargasatuan_oa = $oa->hargajual; //$stok->HargaJualSatuan;
      $modObatAlkesPasien->jmlstok = $jmlStok;
      $modObatAlkesPasien->r = 'R/';
      $modObatAlkesPasien->hargajual_oa = floor($jumlah * $modObatAlkesPasien->hargasatuan_oa);
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
      $modObatAlkesPasien->obatalkes_nama = $obatlain;
      // if(integer($modObatAlkesPasien->qty_oa) && integer($modObatAlkesPasien->qty_oa)){
        $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
      // }
      $modObatAlkesPasien->therapiobat_id = $therapiobat_id;
      $modObatAlkesPasien->ket_penggunaan = $penggunaan_oa;
      $modObatAlkesPasien->racikan_id = $racikan ? Params::RACIKAN_ID_RACIKAN : Params::RACIKAN_ID_NONRACIKAN;

      $modObatAlkesPasien->hargasatuan_oa = MyFormatter::formatNumberForPrint($modObatAlkesPasien->hargasatuan_oa, 2);
      $modObatAlkesPasien->qty_oa = MyFormatter::formatNumberForPrint($modObatAlkesPasien->qty_oa, 2);
      $form .= $this->renderPartial($this->path_view . '_rowDetail3', array('modObatAlkesPasien' => $modObatAlkesPasien), true);
      //    }
      //}else{
      //    $pesan = "Stok tidak mencukupi!";
      //}

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  /**
   * hapus FAObatalkespasienT yang sudah ada di database
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
        $kembalikanstok = $this->hapusStokObatAlkes($loadObatAlkesPasien->obatalkespasien_id);

        if ($kembalikanstok) {
          if ($loadObatAlkesPasien->delete()) {
            $transaction->commit();
            $data['pesan'] = "Obat berhasil dihapus!";
            $data['sukses'] = 1;
          } else {
            $transaction->rollback();
            $data['pesan'] = "Stok Obat gagal dikembalikan!";
            $data['sukses'] = 0;
          }
        } else {
          $transaction->rollback();
          $data['pesan'] = "Obat gagal dihapus!";
          $data['sukses'] = 0;
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['pesan'] = "Obat gagal dihapus! :" . MyExceptionMessage::getMessage($exc, true);
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }
  /**
   * menghapus stok jika ada pembatalan
   * @param type $obatAlkesT
   */

  protected function hapusStokObatAlkes($obatalkespasien_id)
  {
    $stok = StokobatalkesT::model()->findByAttributes(array('obatalkespasien_id' => $obatalkespasien_id));
    //StokobatalkesT::model()->updateAll(array('stokoa_aktif'=>TRUE),'stokobatalkesasal_id = '.$stok->stokobatalkesasal_id);
    //StokobatalkesT::model()->updateByPk($stok->stokobatalkesasal_id,array('stokoa_aktif'=>TRUE));

    if ($stok->delete())
      return true;
  }

  /**
   * simpan ObatalkesPasienT Jumlah Out
   * @param type $modPenjualan
   * @param type $postObatAlkesPasien
   * @return \ObatalkesPasienT
   */
  protected function simpanObatAlkesPasien($modPendaftaran, $modPenjualan, $stokOa, $postObatAlkesPasien)
  {
    $format = new MyFormatter;
    $carabayar_id = '';
    $penjamin_id = '';
    $modObatAlkes = new FAObatalkesPasienT;
    $modObatAlkes->attributes = $stokOa->attributes;
    $modObatAlkes->tglpelayanan = date("Y-m-d H:i:s");
    $modObatAlkes->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    $modObatAlkes->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($modPendaftaran->carabayar_id)) {
      $carabayar_id = $modPendaftaran->carabayar_id;
    } else {
      $carabayar_id = $modPenjualan->carabayar_id;
    }

    if (isset($modPendaftaran->penjamin_id)) {
      $penjamin_id = $modPendaftaran->penjamin_id;
    } else {
      $penjamin_id = $modPenjualan->penjamin_id;
    }
    $modObatAlkes->carabayar_id = $carabayar_id;
    $modObatAlkes->pegawai_id = Yii::app()->user->getState('pegawai_id');
    $modObatAlkes->shift_id = Yii::app()->user->getState('shift_id');
    $modObatAlkes->pendaftaran_id = isset($modPendaftaran->pendaftaran_id) ? $modPendaftaran->pendaftaran_id : null;
    $modObatAlkes->pasien_id = isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien_id : $modPenjualan->pasien_id;
    $modObatAlkes->penjamin_id = $penjamin_id;
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
        $modObatAlkes->jmlstok = $postDetail['jmlstok'];
        $modObatAlkes->r = $postDetail['r'];
        $modObatAlkes->rke = $postDetail['rke'];
        $modObatAlkes->permintaan_oa = $postDetail['permintaan_oa'];
        $modObatAlkes->kekuatan_oa = $postDetail['kekuatan_oa'];
        $modObatAlkes->jmlkemasan_oa = $postDetail['jmlkemasan_oa'];
        //                $modObatAlkes->biayaservice = $postDetail['biayaservice'];
        //                $modObatAlkes->biayakonseling = $postDetail['biayakonseling'];
        //                $modObatAlkes->jasadokterresep = $postDetail['jasadokterresep'];
        //                $modObatAlkes->biayakemasan = $postDetail['biayakemasan'];
        //                $modObatAlkes->biayaadministrasi = $postDetail['biayaadministrasi'];
        //                $modObatAlkes->tarifcyto = $postDetail['tarifcyto'];
        //                $modObatAlkes->subsidiasuransi = $postDetail['subsidiasuransi'];
        //                $modObatAlkes->subsidipemerintah = $postDetail['subsidipemerintah'];
        //                $modObatAlkes->subsidirs = $postDetail['subsidirs'];
        //                $modObatAlkes->iurbiaya = $postDetail['iurbiaya'];
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
    $modStokOaNew->unsetIdTransaksi();
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

    // var_dump($modStokOaNew->attributes); die;

    if ($modStokOaNew->validate()) {
      $this->stokobatalkestersimpan &= $modStokOaNew->save();
      // $modStokOaNew->setStokOaAktifBerdasarkanStok();
    } else {
      $this->stokobatalkestersimpan &= false;
    }

    // var_dump($this->stokobatalkestersimpan);

    return $modStokOaNew;
  }


  public function actionAutocompleteObatReseptur()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $term = explode(';', $_GET['term']);
      $obatalkes_nama = isset($term[0]) ? $term[0] : '';
      $hargajual = isset($term[1]) ? $term[1] : '';
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(obatalkes_nama)', strtolower($obatalkes_nama), true);
      if ($hargajual != '') {
        $criteria->addCondition('hargajual =' . $hargajual, 'or');
      }
      $criteria->addCondition('obatalkes_farmasi = TRUE');
      $criteria->addCondition('obatalkes_aktif = true');
      $criteria->order = 'obatalkes_nama';
      $criteria->limit = 5;
      $models = ObatalkesM::model()->with('sumberdana', 'satuankecil')->findAll($criteria);
      $persenjual = $this->persenJualRuangan();
      $format = new MyFormatter();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();

        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $qtyStok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
        $returnVal[$i]['label'] = $model->obatalkes_kode . " - " . $model->obatalkes_nama . " - Jumlah Stok " . $qtyStok;
        $returnVal[$i]['value'] = $model->obatalkes_nama;
        $returnVal[$i]['obatalkes_id'] = $model->obatalkes_id;
        $returnVal[$i]['sumberdana_nama'] = $model->sumberdana->sumberdana_nama;
        $returnVal[$i]['qtyStok'] = $qtyStok;
        $returnVal[$i]['hargajual'] = floor(($persenjual + 100) / 100 * $model->hargajual);
        $returnVal[$i]['satuankecil'] = $model->satuankecil->satuankecil_nama;
        $returnVal[$i]['idsatuankecil'] = $model->satuankecil_id;
        $returnVal[$i]['diskonJual'] = empty($model->diskonJual) ? 0 : $model->diskonJual;
        $returnVal[$i]['kadaluarsa'] = ((strtotime($format->formatDateTimeForDb($model->tglkadaluarsa)) - strtotime(date('Y-m-d'))) > 0) ? 0 : 1;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
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
   * actionDetailRetur untuk detail retur setelah retur berhasil dilakukan
   * @param type $returresep_id id tabel returreseo_t
   */
  public function actionDetailRetur($returresep_id)
  {
    $this->layout = '//layouts/iframe';

    $modPegawaiRetur = new FAPegawaiM;
    //            if(!empty($id)){
    $modRetur = FAReturresepT::model()->findByPk($returresep_id);
    $infoJualObat = FAInformasipenjualanapotikV::model()->findAllByAttributes(array('penjualanresep_id' => $modRetur->penjualanresep_id));
    $modReturDetail = FAReturresepdetT::model()->findAllByAttributes(array('returresep_id' => $returresep_id));
    $modPenjualan = FAPenjualanResepT::model()->findByPk($modRetur->penjualanresep_id);
    $modRetur->penjualanresep_id = $modPenjualan->penjualanresep_id;
    $modObatAlkesPasien = new ObatalkespasienT;
    $modMengetahuiRetur = array();
    //            }else{
    //                $this->redirect(array('index'));
    //            }
    $modPegawaiRetur = FAPegawaiM::model()->findByAttributes(array('pegawai_id' => $modRetur->pegretur_id));
    if (!empty($modRetur->mengetahui_id))
      $modMengetahuiRetur = FAPegawaiM::model()->findByAttributes(array('pegawai_id' => $modRetur->mengetahui_id));
    $this->render('printStrukRetur', array(
      'infoJualObat' => $infoJualObat,
      'modPenjualan' => $modPenjualan,
      'modObatAlkesPasien' => $modObatAlkesPasien,
      'modRetur' => $modRetur,
      'modReturDetail' => $modReturDetail,
      'modPegawaiRetur' => $modPegawaiRetur,
      'modMengetahuiRetur' => $modMengetahuiRetur,
    ));
  }

  /**
   * actionPrintStrukRetur untuk print struk retur setelah retur berhasil dilakukan
   * @param type $returresep_id
   * @param type $penjualanresep_id
   */
  public function actionPrintStrukRetur($returresep_id, $penjualanresep_id)
  {
    $this->layout = '//layouts/iframe';
    if ($_GET['caraPrint'] == "PRINT")
      $this->layout = '//layouts/printWindows';
    $modPegawaiRetur = new FAPegawaiM;
    $infoJualObat = FAInformasipenjualanapotikV::model()->findAllByAttributes(array('penjualanresep_id' => $penjualanresep_id));
    //            if(!empty($id)){
    $modRetur = FAReturresepT::model()->findByPk($returresep_id);
    $modReturDetail = FAReturresepdetT::model()->findAllByAttributes(array('returresep_id' => $returresep_id));
    $modPenjualan = FAPenjualanResepT::model()->findByPk($modRetur->penjualanresep_id);
    $modRetur->penjualanresep_id = $modPenjualan->penjualanresep_id;
    $modObatAlkesPasien = new ObatalkespasienT;
    $modMengetahuiRetur = array();
    //            }else{
    //                $this->redirect(array('index'));
    //            }
    $modPegawaiRetur = FAPegawaiM::model()->findByAttributes(array('pegawai_id' => $modRetur->pegretur_id));
    if (!empty($modRetur->mengetahui_id))
      $modMengetahuiRetur = FAPegawaiM::model()->findByAttributes(array('pegawai_id' => $modRetur->mengetahui_id));
    $this->render('printStrukRetur', array(
      'infoJualObat' => $infoJualObat,
      'modPenjualan' => $modPenjualan,
      'modObatAlkesPasien' => $modObatAlkesPasien,
      'modRetur' => $modRetur,
      'modReturDetail' => $modReturDetail,
      'modPegawaiRetur' => $modPegawaiRetur,
      'modMengetahuiRetur' => $modMengetahuiRetur,
    ));
  }

  public function actionPrintStruk($id, $pasien_id)
  {
    $this->layout = '//layouts/iframe';

    $modDetailPenjualan = FAInformasipenjualanresepV::model()->findAll('penjualanresep_id=' . $id . ' and pasien_id=' . $pasien_id . '');
    $reseptur = FAPenjualanResepT::model()->find('penjualanresep_id = ' . $id . '');

    $criteria = new CDbCriteria();
    $criteria->select = 't.penjualanresep_id,
                                sum(t.qty_oa) As qty_oa,
                                sum(penjualanresep_t.biayaadministrasi) As biayaadministrasi,
                                sum(penjualanresep_t.biayakonseling) As biayakonseling,
                                sum(penjualanresep_t.totaltarifservice) As biayaservice,
                                sum(penjualanresep_t.jasadokterresep) As jasadokterresep,
                                sum(t.hargasatuan_oa) As hargasatuan_oa,
                                sum((t.qty_oa*t.hargasatuan_oa)*(t.discount/100)) As diskon,
                                sum((t.qty_oa * t.hargasatuan_oa)) As subtotal';
    $criteria->group = 't.penjualanresep_id';
    $criteria->join = 'RIGHT JOIN penjualanresep_t ON penjualanresep_t.penjualanresep_id = t.penjualanresep_id RIGHT JOIN obatalkes_m ON obatalkes_m.obatalkes_id = t.obatalkes_id';
    //           $criteria->with = array('penjualanresep,obatalkes');
    if (!empty($id)) {
      $criteria->addCondition("t.penjualanresep_id = " . $id);
    }
    $detailreseptur = FAObatalkesPasienT::model()->findAll($criteria);
    $daftar = FAPendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $reseptur->pendaftaran_id));
    $pasien = FAPasienM::model()->findByAttributes(array('pasien_id' => $reseptur->pasien_id));

    $this->render('PrintStrukPenjualan', array(
      'reseptur' => $reseptur,
      'detailreseptur' => $detailreseptur, 'daftar' => $daftar, 'pasien' => $pasien, 'modDetailPenjualan' => $modDetailPenjualan
    ));
  }
  public function actionStrukPrint($id, $pasien_id)
  {
    $this->layout = '//layouts/iframe';

    $modDetailPenjualan = FAInformasipenjualanresepV::model()->findAll('penjualanresep_id=' . $id . ' and pasien_id=' . $pasien_id . '');
    $reseptur = FAPenjualanResepT::model()->find('penjualanresep_id = ' . $id . '');

    $criteria = new CDbCriteria();
    $criteria->select = 't.penjualanresep_id,
                                sum(t.qty_oa) As qty_oa,
                                sum(penjualanresep_t.biayaadministrasi) As biayaadministrasi,
                                sum(penjualanresep_t.biayakonseling) As biayakonseling,
                                sum(penjualanresep_t.totaltarifservice) As biayaservice,
                                sum(penjualanresep_t.jasadokterresep) As jasadokterresep,
                                sum(t.hargasatuan_oa) As hargasatuan_oa,
                                sum((t.qty_oa*t.hargasatuan_oa)*(t.discount/100)) As diskon,
                                sum((t.qty_oa * t.hargasatuan_oa)) As subtotal';
    $criteria->group = 't.penjualanresep_id';
    $criteria->join = 'RIGHT JOIN penjualanresep_t ON penjualanresep_t.penjualanresep_id = t.penjualanresep_id RIGHT JOIN obatalkes_m ON obatalkes_m.obatalkes_id = t.obatalkes_id';
    //           $criteria->with = array('penjualanresep,obatalkes');
    if (!empty($id)) {
      $criteria->addCondition("t.penjualanresep_id = " . $id);
    }
    $detailreseptur = FAObatalkesPasienT::model()->findAll($criteria);
    $daftar = FAPendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $reseptur->pendaftaran_id));
    $pasien = FAPasienM::model()->findByAttributes(array('pasien_id' => $reseptur->pasien_id));
    $judulLaporan = 'Struk Penjualan';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('farmasiApotek.views.informasiPenjualanResep.PrintStrukPenjualan', array(
        'reseptur' => $reseptur,
        'detailreseptur' => $detailreseptur, 'daftar' => $daftar,
        'pasien' => $pasien, 'modDetailPenjualan' => $modDetailPenjualan,
        'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('farmasiApotek.views.informasiPenjualanResep.PrintStrukPenjualan', array(
        'reseptur' => $reseptur,
        'detailreseptur' => $detailreseptur, 'daftar' => $daftar,
        'pasien' => $pasien, 'modDetailPenjualan' => $modDetailPenjualan,
        'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('farmasiApotek.views.informasiPenjualanResep.PrintStrukPenjualan', array(
        'reseptur' => $reseptur,
        'detailreseptur' => $detailreseptur, 'daftar' => $daftar,
        'pasien' => $pasien, 'modDetailPenjualan' => $modDetailPenjualan,
        'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ), true));
      $mpdf->Output();
    }
  }

  public function actionPrintDetailPenjualan()
  {
    $id = $_POST['id'];
    $modDetailPenjualan = FAInformasipenjualanresepV::model()->findAll('penjualanresep_id=:penjualanresep', array(':penjualanresep' => $id));
    $modReseptur = FAPenjualanResepT::model()->findByPk($id);

    $detailreseptur = FAObatalkesPasienT::model()->findAll('penjualanresep_id = ' . $id . ' ');
    $modPasien = FAPasienM::model()->findByPk($pasien_id);

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('DetailPenjualan', array(
        'modDetailPenjualan' => $modDetailPenjualan,
        'modReseptur' => $modReseptur, 'detailreseptur' => $detailreseptur
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('DetailPenjualan', array(
        'modDetailPenjualan' => $modDetailPenjualan,
        'modReseptur' => $modReseptur, 'detailreseptur' => $detailreseptur
      ));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('DetailPenjualan', array(
        'modDetailPenjualan' => $modDetailPenjualan,
        'modReseptur' => $modReseptur, 'detailreseptur' => $detailreseptur
      ), true));
      $mpdf->Output();
    }
    $this->render('DetailPenjualan', array(
      'modDetailPenjualan' => $modDetailPenjualan,
      'modReseptur' => $modReseptur, 'detailreseptur' => $detailreseptur
    ));
  }

  public function actionCopyResep($penjualanresep_id, $pasien_id, $id = null)
  {
    $this->layout = '//layouts/iframe';
    $modObatAlkesPasien = array();
    if (!empty($id)) {
      $model = FACopyResepR::model()->findAllByAttributes(array('penjualanresep_id' => $penjualanresep_id));
    } else {
      $model = new FACopyResepR;
    }
    $tersimpan = 'Tidak';

    $modelPenjualanResep = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
    $modObatAlkesPasien = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $penjualanresep_id, 'pasien_id' => $pasien_id));
    $modPasien = FAPasienM::model()->findByPk($pasien_id);
    $modDetailReseptur = FAResepturDetailT::model()->findAllByAttributes(array('reseptur_id' => $modelPenjualanResep->reseptur_id), array('order' => 'rke ASC'));
    $modCopy = CopyresepR::model()->findAll('penjualanresep_id=' . $penjualanresep_id . ' order by copyresep_id desc limit 1');
    foreach ($modCopy as $i => $data) {
      $copy = $data->jmlcopy;
      $penjualanresep = $data->penjualanresep_id;
      $copyresep = $data->copyresep_id;
    }
    if (isset($_POST['FACopyResepR'])) {
      if ($modCopy == null) {
        $copy = 1;
        $jmlCopy = $copy;
        $model->attributes = $_POST['FACopyResepR'];
        $model->tglcopy = date('Y-m-d');
        $model->penjualanresep_id = $_POST['FAPenjualanResepT']['penjualanresep_id'];
        $model->keterangancopy = $_POST['FACopyResepR']['keterangancopy'];
        $model->jmlcopy = $jmlCopy;
        $model->create_time = date('Y-m-d');
        $model->update_time = date('Y-m-d');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->update_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if (!empty($modelPenjualanResep->reseptur_id)) {
          $model->reseptur_id = $modelPenjualanResep->reseptur_id;
        } else {
          $model->reseptur_id = null;
        }
      } else {
        $copy = $copy + 1;
      }

      $penjualanresep = (isset($penjualanresep) ? $penjualanresep : null);
      if ($penjualanresep == $penjualanresep_id) {
        $update = CopyresepR::model()->UpdateAll(array(
          'jmlcopy' => $copy,
          'tglcopy' => date('Y-m-d'),
          'keterangancopy' => $_POST['FACopyResepR']['keterangancopy'],
          'create_time' => date('Y-m-d'),
          'update_time' => date('Y-m-d'),
          'create_loginpemakai_id' => Yii::app()->user->id,
          'update_loginpemakai_id' => Yii::app()->user->id,
          'create_ruangan' => Yii::app()->user->getState('ruangan_id')
        ), 'penjualanresep_id=:penjualanresep_id and copyresep_id=:copyresep_id', array(':penjualanresep_id' => $_POST['FAPenjualanResepT']['penjualanresep_id'], ':copyresep_id' => $copyresep));

        if ($update) {
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $tersimpan = 'Ya';
        } else {
          //                            $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } else {
        if ($model->save()) {
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $tersimpan = 'Ya';
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      }
    }

    $model->tglcopy = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($model->tglcopy, 'yyyy-MM-dd')
    );

    $this->render('formCopyResep', array(
      'modelPenjualanResep' => $modelPenjualanResep,
      'modPasien' => $modPasien,
      'model' => $model,
      'modCopy' => $modCopy,
      'modObatAlkesPasien' => $modObatAlkesPasien,
      'tersimpan' => $tersimpan,
    ));
  }

  public function actionPrintCopyResep($idPenjualanResep)
  {
    $this->layout = '//layouts/printWindows';

    $modelPenjualanResep = FAPenjualanResepT::model()->findByPk($idPenjualanResep);
    $modReseptur = ResepturT::model()->findAll('penjualanresep_id = ' . $idPenjualanResep);
    $modCopy = CopyresepR::model()->findAll('penjualanresep_id = ' . $idPenjualanResep . ' order by copyresep_id desc limit 1');
    $modDetailPenjualan = FAInformasipenjualanresepV::model()->findAll('penjualanresep_id=' . $idPenjualanResep . ' and pasien_id=' . $modelPenjualanResep->pasien_id . '');
    $modPasien = FAPasienM::model()->findByPk($modelPenjualanResep->pasien_id);

    $this->render('PrintCopyResep', array(
      'modelPenjualanResep' => $modelPenjualanResep,
      'modPasien' => $modPasien,
      'modDetailPenjualan' => $modDetailPenjualan,
      'modReseptur' => $modReseptur,
      'modCopy' => $modCopy,
    ));
  }
  /**
   * batal / hapus penjualan resep by ajax
   * RND-8049
   */
  public function actionBatalPenjualanResep()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = array();
      $data['sukses'] = 0;
      $data['pesan'] = 'Penjualan gagal dihapus!';
      $ishapusoa = false;
      $ishapuspenjualan = false;

      if (isset($_POST['penjualanresep_id'])) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $penjualanresep_id = $_POST['penjualanresep_id'];
          $modPenjualanResep = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
          if ($modPenjualanResep) {
            $oaSudahBayars = ObatalkespasienT::model()->findAllByAttributes(array('penjualanresep_id' => $modPenjualanResep->penjualanresep_id), 'oasudahbayar_id IS NOT NULL');
            if (count((array)$oaSudahBayars) > 0) {
              $data['pesan'] = 'Penjualan gagal dihapus karena ' . count((array)$oaSudahBayars) . ' obat yang sudah dibayarkan!';
            } else {
              $ishapusoa = ObatalkespasienT::model()->deleteAllByAttributes(array('penjualanresep_id' => $modPenjualanResep->penjualanresep_id));
              
              //untuk hapus stokobatalkes_t relasinya di cascade
              if ($ishapusoa) {
                //tambahan buat mengubah penjualanresep_id menjadi null pada reseptur_t
                if (!empty($modPenjualanResep->reseptur_id)) {
                  $upReseptur = ResepturT::model()->updateByPk($modPenjualanResep->reseptur_id, array('penjualanresep_id' => null));
                }
                $ishapuspenjualan = $modPenjualanResep->delete();
              }
            }
          }

          if ($ishapusoa && $ishapuspenjualan) {
            $transaction->commit();
            $data['pesan'] = 'Penjualan resep berhasil dibatalkan!';
            $data['status'] = 1;
          } else {
            $transaction->rollback();
          }
        } catch (Exception $exc) {
          var_dump($exc->getMessage());
          $transaction->rollback();
          $data['pesan'] = 'Data Gagal Dibatalkan';
        }
      }
      echo json_encode($data);
    }
    Yii::app()->end();
  }

  /**
   * action ketika tombol panggil di klik
   */
  public function actionPanggilAntrian()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $data['pesan'] = "";
      $penjualanresep_id = ($_POST['penjualanresep_id']);
      $keterangan = (isset($_POST['keterangan']) ? $_POST['keterangan'] : null);
      $modPenjualanResep = PenjualanresepT::model()->findByPk($penjualanresep_id);
      $modAntrianFarmasi = AntrianfarmasiT::model()->findByPk($modPenjualanResep->antrianfarmasi_id);

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
      $data['smspasien'] = 1;
      $data['nama_pasien'] = '';

      if (isset($modPenjualanResep)) {
        if (isset($modAntrianFarmasi)) {
          if ($modAntrianFarmasi->panggilantrian == true && $modAntrianFarmasi->jumlah_panggil == 6) {
            if ($keterangan == "batal") {
              $modAntrianFarmasi->panggilantrian = false;
              if ($modAntrianFarmasi->update()) {
                // SMS GATEWAY
                $modPasien = $modPenjualanResep->pasien;
                $sms = new Sms();
                $smspasien = 1;
                foreach ($modSmsgateway as $i => $smsgateway) {
                  $isiPesan = $smsgateway->templatesms;

                  $attributes = $modPasien->getAttributes();
                  foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                  }
                  $attributes = $modPenjualanResep->getAttributes();
                  foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                  }
                  $attributes = $modAntrianFarmasi->getAttributes();
                  foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                  }

                  if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                    if (!empty($modPasien->no_mobile_pasien)) {
                      $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                    } else {
                      $smspasien = 0;
                    }
                  }
                }
                // END SMS GATEWAY
                $data['smspasien'] = $smspasien;
                $data['nama_pasien'] = $modPasien->nama_pasien;
                $data['pesan'] = "Pemanggilan no. antrian " . $modAntrianFarmasi->noantrian . " dibatalkan !";
              }
            } else {
              $data['pesan'] = "No. antrian " . $modAntrianFarmasi->noantrian . " sudah dipanggil sebelumnya !";
            }
          } else {
            $modAntrianFarmasi->panggilantrian = true;
            $modAntrianFarmasi->jumlah_panggil++;
            if ($modAntrianFarmasi->update()) {
              $data['pesan'] = "No. antrian " . $modAntrianFarmasi->noantrian . " dipanggil! (" . $modAntrianFarmasi->jumlah_panggil . " kali)";
            }
          }
        } else {
          $data['pesan'] = "Pasien tidak ada dalam No. Antrian";
        }
      }

      if (isset($modPenjualanResep->antrianfarmasi_id)) {
        $attributes = $modAntrianFarmasi->attributeNames();
        foreach ($attributes as $i => $attribute) {
          $data["$attribute"] = $modAntrianFarmasi->$attribute;
        }
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * untuk print data penjualan resep
   */
  public function actionPrint($penjualanresep_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
    $modPenjualanDetail = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $penjualanresep_id));

    $judul_print = 'Penjualan Resep Bebas';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPenjualan' => $modPenjualan,
      'modPenjualanDetail' => $modPenjualanDetail,
      'caraPrint' => $caraPrint
    ));
  }


  // ================== AJAX UPDATE PENJUALAN RESEP ========================
  public function actionSetTherapiobatid()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = $_POST['obatalkes_id'];
      $modTherapi = FATherapimapobatM::model()->findByAttributes(array('obatalkes_id' => $obatalkes_id));
      if (!empty($modTherapi)) {
        $data = $modTherapi->therapiobat_id;
      } else {
        $data = null;
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  public function actionSetDropdownRke()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = '';
      $rmax = isset($_POST['rmax']) ? $_POST['rmax'] : null;
      if (!empty($rmax)) {
        for ($i = $rmax + 1; $i <= 20; $i++) {
          $data .=  CHtml::tag('option', array('value' => $i), CHtml::encode($i), true);
        }
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  public function actionListDokter()
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
      $criteria->addCondition('kelompokpegawai_id = 1');
      $criteria->select = 'gelardepan, nama_pegawai, gelarbelakang_nama, pegawai_id';
      $criteria->group = 'gelardepan, nama_pegawai, gelarbelakang_nama, pegawai_id';
      $models = DokterV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * @author Deni Hamdani <denihamdani@piindonesia.co.id>
   *
   * Mengambil data lookup signa untuk autocomplete
   *
   * @param string $term input dari textfield autocomplete untuk memfilter nama lookup-nya.
   */
  public function actionGetSignaFarmasi($term = null)
  {
    $cr = new CDbCriteria();
    $cr->compare('lookup_type', 'signa_oa');
    $cr->compare('lower(lookup_name)', strtolower($term), true);
    $cr->addCondition('lookup_aktif = true');
    $cr->order = 'lookup_urutan';

    $signa = LookupM::model()->findAll($cr);

    $res = array();
    foreach ($signa as $item) {
      $res[] = array('label' => $item->lookup_name, 'value' => $item->lookup_name);
    }

    echo CJSON::encode($res);
  }


  /**
   * method to get Terapi Obat
   */
  public function actionAutoCompleteTherapiObat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $term = $_GET['term'];
      $criteria = new CDbCriteria();
      $criteria->addCondition("therapiobat_nama ILIKE '%" . $term . "%'");
      $criteria->addCondition('therapiobat_aktif = true');
      $models = FATherapiobatM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();

        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->therapiobat_nama;
        $returnVal[$i]['value'] = $model->therapiobat_id;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   *
   * @param type $modPenjualan
   */
  public function broadcastReturResep($modRetur)
  {
    // var_dump($modPenjualan->attributes);

    $pegawai = PegawaiM::model()->findByPk($modRetur->pegretur_id);
    $pasien = PasienM::model()->findByPk($modRetur->pasien_id);

    $judul = "Retur Penjualan Resep";
    $isi = $modRetur->noreturresep . " - " . $pegawai->namaLengkap . " - " . $pasien->no_rekam_medik . " - " . $pasien->nama_pasien;

    CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => Params::INSTALASI_ID_KEUANGAN, 'ruangan_id' => Params::RUANGAN_ID_KASIR, 'modul_id' => Params::MODUL_ID_BILLINGKASIR),
    ));

    // var_dump($isi);
  }

  public function actionUbahStatusObat()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $status = isset($_POST['status']) ? $_POST['status'] : null;
      $penjualanresep_id = isset($_POST['penjualanresep_id']) ? $_POST['penjualanresep_id'] : null;
    //  exit($penjualanresep_id);
      $pesan = 'gagal';
      $tanggal = date('Y-m-d H:i:s');
      if ($status == 'BELUM' || $status == 'SEDANG DIKONSULTASIKAN') {
        $statusNew = 'SEDANG DILAYANI';
        $update = PenjualanresepT::model()->updateByPk($penjualanresep_id, array('statusobat' => $statusNew, 'tglsedangdisiapkan' => $tanggal));
      } else {
        $statusNew = 'SUDAH';
        $update = PenjualanresepT::model()->updateByPk($penjualanresep_id, array('statusobat' => $statusNew, 'tglselesaidisiapkan' => $tanggal));
      }

      if ($update) {
        $pesan = 'ok';
      } else {
        $pesan = 'gagal';
      }
      $data['pesan'] = $pesan;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionUbahStatusObatKonsul()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $status = isset($_POST['status']) ? $_POST['status'] : null;
      $penjualanresep_id = isset($_POST['penjualanresep_id']) ? $_POST['penjualanresep_id'] : null;
    //  exit($penjualanresep_id);
      $pesan = 'gagal';
      $tanggal = date('Y-m-d H:i:s');

      $is_siap = $_POST['is_siap'];

      $statusNew = 'SEDANG DIKONSULTASIKAN';

      if($is_siap == 'y') {
        $statusNew = 'SUDAH';
      } else if($is_siap == 'n') {
        $statusNew = 'SEDANG DILAYANI';
      } 
      $update = PenjualanresepT::model()->updateByPk($penjualanresep_id, array('statusobat' => $statusNew, 'tglsedangdisiapkan' => $tanggal));

      if ($update) {
        $pesan = 'ok';
      } else {
        $pesan = 'gagal';
      }
      $data['pesan'] = $pesan;

      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
