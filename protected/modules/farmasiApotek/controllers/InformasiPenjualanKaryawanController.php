<?php
Yii::import('farmasiApotek.controllers.InformasiPenjualanResepController');
Yii::import('farmasiApotek.views.informasiPenjualanResep.*');

class InformasiPenjualanKaryawanController extends InformasiPenjualanResepController
{
  public $suksesRetur = false;
  public $suksesUbahJualResep = false;
  public $suksesReturStok = true; //karna di looping
  public $suksesUpdateObatAlkesPasien = true; //karna di looping
  public $stokobatalkestersimpan = true; //karna di looping
  public $obatalkespasientersimpan = true; //karna di looping

  public $path_view = 'farmasiApotek.views.informasiPenjualanResep.';
  public $path_view_ubah_karyawan = 'farmasiApotek.views.informasiPenjualanKaryawan.';
  public $path_view_karyawan = 'farmasiApotek.views.penjualanResepRS.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Penjualan Pegawai";
    $format = new MyFormatter();
    $modInfoPenjualan = new FAInformasipenjualanresepV('searchInfoJualResep');
    $modInfoPenjualan->unsetAttributes();
    $modInfoPenjualan->tgl_awal = date('Y-m-d');
    $modInfoPenjualan->tgl_akhir = date('Y-m-d');
    if (isset($_GET['FAInformasipenjualanresepV'])) {
      $modInfoPenjualan->attributes = $_GET['FAInformasipenjualanresepV'];
      $modInfoPenjualan->tgl_awal = $format->formatDateTimeForDb($_GET['FAInformasipenjualanresepV']['tgl_awal']);
      $modInfoPenjualan->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInformasipenjualanresepV']['tgl_akhir']);
    }

    $this->render('index', array('format' => $format, 'modInfoPenjualan' => $modInfoPenjualan));
  }

  public function actionDetailPenjualan($id, $pasien_id)
  {
    $this->layout = '//layouts/iframe';

    $modDetailPenjualan = FAInformasipenjualanresepV::model()->findAll('penjualanresep_id=' . $id . ' and pasien_id=' . $pasien_id . '');
    $modReseptur = FAPenjualanResepT::model()->findByPk($id);


    $detailreseptur = FAObatalkesPasienT::model()->findAll('penjualanresep_id = ' . $id . ' ');
    $modPasien = FAPasienM::model()->findByPk($pasien_id);

    $this->render('DetailPenjualan', array(
      'modDetailPenjualan' => $modDetailPenjualan,
      'modReseptur' => $modReseptur, 'detailreseptur' => $detailreseptur
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

  public function actionCopyResep($idPenjualanResep, $pasien_id, $id = null)
  {
    $this->layout = '//layouts/iframe';
    if (!empty($id)) {
      $model = FACopyResepR::model()->findAllByAttributes(array('penjualanresep_id' => $idPenjualanResep));
    } else {
      $model = new FACopyResepR;
    }
    $tersimpan = 'Tidak';

    $modelPenjualanResep = FAPenjualanResepT::model()->findByPk($idPenjualanResep);
    $modDetailPenjualan = FAInformasipenjualanresepV::model()->findAll('penjualanresep_id=' . $idPenjualanResep . ' and pasien_id=' . $pasien_id . '');
    $modPasien = FAPasienM::model()->findByPk($pasien_id);
    $modCopy = CopyresepR::model()->findAll('penjualanresep_id=' . $idPenjualanResep);
    foreach ($modCopy as $i => $data) {
      $copy = $data->jmlcopy;
    }
    $copy = $copy + 1;
    //             echo $copy;
    //             exit;
    if (isset($_POST['FACopyResepR'])) {
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
      //                    
      //                    echo print_r($model->getAttributes());
      //                    exit;
      if ($model->validate()) {
        if ($modCopy > 0) {
          $update = CopyresepR::model()->UpdateAll(array(
            'jmlcopy' => $jmlCopy,
            'tglcopy' => date('Y-m-d'),
            'keterangancopy' => $_POST['FACopyResepR']['keterangancopy'],
            'create_time' => date('Y-m-d'),
            'update_time' => date('Y-m-d'),
            'create_loginpemakai_id' => Yii::app()->user->id,
            'update_loginpemakai_id' => Yii::app()->user->id,
            'create_ruangan' => Yii::app()->user->getState('ruangan_id')
          ), 'penjualanresep_id=:penjualanresep_id', array(':penjualanresep_id' => $_POST['FAPenjualanResepT']['penjualanresep_id']));

          if ($update) {
            Yii::app()->user->setFlash('success', "Data berhasil disimpan");
            $tersimpan = 'Ya';
          } else {
            $transaction->rollback();
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
    }

    $model->tglcopy = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($model->tglcopy, 'yyyy-MM-dd')
    );

    $this->render('formCopyResep', array(
      'modelPenjualanResep' => $modelPenjualanResep,
      'modPasien' => $modPasien,
      'model' => $model,
      'modCopy' => $modCopy,
      'modDetailPenjualan' => $modDetailPenjualan,
      'tersimpan' => $tersimpan,
    ));
  }

  public function actionPrintCopyResep($idPenjualanResep)
  {
    $this->layout = '//layouts/printWindows';

    $modelPenjualanResep = FAPenjualanResepT::model()->findByPk($idPenjualanResep);
    $modReseptur = ResepturT::model()->findAll('penjualanresep_id = ' . $idPenjualanResep);
    $modCopy = CopyresepR::model()->findAll('penjualanresep_id = ' . $idPenjualanResep);
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
   * Fungsi actionUbahPenjualanResep khusus untuk mengubah data lama transaksi Penjualan Pegawai
   * di tabel informasi penjualan pegawai
   * RND-4564
   */
  public function actionUbahPenjualanResep($penjualanresep_id = null)
  {
    $format = new MyFormatter();
    $racikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_RACIKAN);
    $nonRacikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_NONRACIKAN);
    $modRacikanDetail = RacikandetailM::model()->findAll(); //load semua data untuk perhitungan js & jquery
    $racikanDetail = array();
    $modAntrian = new FAAntrianFarmasiT;
    $modInfoPegawai = new FAPegawaiV;
    $sukses = 0;
    foreach ($modRacikanDetail as $i => $mod) { //convert object to array
      $racikanDetail[$i]['racikandetail_id'] = $mod->racikandetail_id;
      $racikanDetail[$i]['racikan_id'] = $mod->racikan_id;
      $racikanDetail[$i]['qtymin'] = $mod->qtymin;
      $racikanDetail[$i]['qtymaks'] = $mod->qtymaks;
      $racikanDetail[$i]['tarifservice'] = $mod->tarifservice;
    }
    if (isset($penjualanresep_id)) {
      $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
      $modPendaftaran = FAPendaftaranT::model()->findByPk($modPenjualan->pendaftaran_id);
      $modPasien = FAPasienM::model()->findByPk($modPenjualan->pasien_id);
      $modReseptur = FAResepturT::model()->findByAttributes(array('penjualanresep_id' => $penjualanresep_id));

      if (!empty($modPenjualan->pasienpegawai_id)) {
        $modInfoPegawai = FAPegawaiM::model()->findByPk($modPenjualan->pasienpegawai_id);
      }

      if (empty($modReseptur->noresep)) //jika tidak ada reseptur
        $modReseptur = new FAResepturT;
      if (!empty($modPenjualan)) {
        $modPenjualan->isNewRecord = false;
        $obatAlkes = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $modPenjualan->penjualanresep_id));
      }
    }


    if (isset($_POST['FAPenjualanResepT']) && (isset($_POST['FAResepturT'])) && (isset($_POST['FAObatalkesPasienT']))) {
      $modPenjualan->tglresep = $format->formatDateTimeForDb($modPenjualan->tglresep);
      $modPenjualan->tglpenjualan = $format->formatDateTimeForDb($modPenjualan->tglpenjualan);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPenjualan = $this->ubahJualResep($modPenjualan, $_POST['FAPenjualanResepT']);
        //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
        $detailGroups = array();
        foreach ($_POST['FAObatalkesPasienT'] as $i => $postDetail) {
          if (empty($postDetail['obatalkespasien_id'])) {
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
        }
        //END GROUP

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

        if ($this->suksesUbahJualResep) {
          $transaction->commit();
          $sukses = 1;
          $this->redirect(array('UbahPenjualanResep', 'penjualanresep_id' => $penjualanresep_id, 'sukses' => $sukses));
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
    //Pisahkan no resep depan belakang
    $modPenjualan->noresep_depan = substr($modPenjualan->noresep, 0, 21);
    $modPenjualan->noresep_belakang = substr($modPenjualan->noresep, 21, 100);

    $this->render($this->path_view_ubah_karyawan . 'ubahPenjualan', array(
      'modReseptur' => $modReseptur,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modInfoPegawai' => $modInfoPegawai,
      'obatAlkes' => $obatAlkes,
      'modPenjualan' => $modPenjualan,
      'modAntrian' => $modAntrian,
      'racikan' => $racikan,
      'racikanDetail' => $racikanDetail,
      'nonRacikan' => $nonRacikan,
      'sukses' => $sukses,
    ));
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

  public function actionCekLogin($task = 'Retur')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $username = $_POST['username'];
      $password = $_POST['password'];
      $idRuangan = Yii::app()->user->getState('ruangan_id');

      $user = LoginpemakaiK::model()->findByAttributes(array(
        'nama_pemakai' => $username,
        'loginpemakai_aktif' => TRUE
      ));
      if ($user === null) {
        $data['error'] = "Login Pemakai salah!";
        $data['cssError'] = 'username';
        $data['status'] = 'Gagal Login';
      } else {
        // cek password
        if ($user->katakunci_pemakai !== $user->encrypt($password)) {
          $data['error'] = 'password salah!';
          $data['cssError'] = 'password';
          $data['status'] = 'Gagal Login';
        } else {
          // cek ruangan
          $ruangan_user = RuanganpemakaiK::model()->findByAttributes(array(
            'loginpemakai_id' => $user->loginpemakai_id,
            'ruangan_id' => $idRuangan
          ));
          if ($ruangan_user === null) {
            $data['error'] = 'ruangan salah!';
            $data['status'] = 'Gagal Login';
          } else {
            $data['error'] = '';
            $cek = $this->checkAccess(array('loginpemakai_id' => $user->loginpemakai_id)); //dari MyAuthController
            if ($cek) {
              $data['status'] = 'success';
              $data['userid'] = $user->loginpemakai_id;
              $data['username'] = $user->nama_pemakai;
            } else {
              $data['status'] = 'Anda tidak memiliki hak melakukan proses ini!';
            }
          }
        }
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * untuk print data penjualan resep
   */
  public function actionPrint($penjualanresep_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
    $modPenjualanDetail = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $penjualanresep_id));

    $judul_print = 'Penjualan Pegawai / Dokter';
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

  public function actionUbahStatusObat()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $status = isset($_POST['status']) ? $_POST['status'] : null;
      $penjualanresep_id = isset($_POST['penjualanresep_id']) ? $_POST['penjualanresep_id'] : null;
      $pesan = 'gagal';
      $tanggal = date('Y-m-d H:i:s');
      if ($status == 'BELUM') {
        $statusNew = 'SEDANG';
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
}
