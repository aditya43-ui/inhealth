<?php

class RujukanPenunjangController extends MyAuthController
{
  /**
   * @return array action filters
   */

  public $successSave = false;
  public $path_view_rujuk = 'bedahSentral.views.rujukanPenunjang.';
  public $simpan_signin = true;
  public $simpan_signindet = true;

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Rujukan";
    $model = new PasienkirimkeunitlainV;
    $model->tgl_awal = date('Y-m-d', strtotime('-5 days'));
    $model->tgl_akhir = date('Y-m-d');
    $model->tgl_rencana_awal = date('Y-m-d', strtotime('-5 days'));
    $model->tgl_rencana_akhir = date('Y-m-d');
    // $model->ruangan_id = 12; //Yii::app()->user->getState('ruangan_id');

    if (isset($_GET['PasienkirimkeunitlainV'])) {
      $model->attributes = $_GET['PasienkirimkeunitlainV'];
      $model->nama_pegawai = $_GET['PasienkirimkeunitlainV']['nama_pegawai'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['PasienkirimkeunitlainV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['PasienkirimkeunitlainV']['tgl_akhir']);
      $model->statusperiksa = isset($_GET['PasienkirimkeunitlainV']['statusperiksa']) ? $_GET['PasienkirimkeunitlainV']['statusperiksa'] : null;
    }

    
    $dataProvider = $model->searchRujukBedah();
    if(Yii::app()->request->isAjaxRequest) {
      if(isset($_GET['ajax']) && $_GET['ajax'] == 'pasienpenunjangrujukan-m-grid') {
        $module = $this->module->id;
        $this->renderPartial('_table', ['dataProvider' => $dataProvider, 'module' => $module]);
        Yii::app()->end();
      }
    }
    /*
            $criteria = new CDbCriteria;
            if(isset($_GET['ajax']) && $_GET['ajax']=='pasienpenunjangrujukan-m-grid') {
                $format = new MyFormatter;
                echo $format->formatDateTimeForDb($_GET['tgl_akhir']);
                $criteria->compare('LOWER(no_pendaftaran)', strtolower($_GET['noPendaftaran']),true);
                $criteria->compare('LOWER(nama_pasien)', strtolower($_GET['namaPasien']),true);
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['noRekamMedik']),true);
                if (isset($_GET['PasienkirimkeunitlainV'])) {
                    $criteria->compare();
                }
                //if($_GET['cbTglMasuk'])
                    $criteria->addBetweenCondition('DATE(tgl_kirimpasien)', "'".$format->formatDateTimeForDb($_GET['tgl_awal'])."'", "'".$format->formatDateTimeForDb($_GET['tgl_akhir'])."'");
            } else {
                //$criteria->addBetweenCondition('tgl_pendaftaran', date('Y-m-d').' 00:00:00', date('Y-m-d').' 23:59:59');
            }
            $criteria->addCondition('instalasi_id = '.Params::INSTALASI_ID_IBS); //NANTI DIGANTI AMA SESSION, SEMENTARA PAKE PARAM DL
            $criteria->order='tgl_kirimpasien DESC';
            
            $dataProvider = new CActiveDataProvider(PasienkirimkeunitlainV::model(), array(
			'criteria'=>$criteria,
		));
             * 
             */
    $this->render('index', array('dataProvider' => $dataProvider, 'model' => $model));
  }

  public function actionMasukPenunjang($idPasienKirimKeUnitLain, $pendaftaran_id)
  {
    $this->pageTitle = Yii::app()->name . " - Rencana Operasi";
    $modPendaftaran = BSPendaftaranMp::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = BSPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modOperasi = BSOperasiM::model()->findAllByAttributes(array('operasi_aktif' => true));
    $modKegiatanOperasi = BSKegiatanOperasiM::model()->findAllByAttributes(array('kegiatanoperasi_aktif' => true));
    $modPermintaan = BSPermintaanKePenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id' => $idPasienKirimKeUnitLain));
    $modPasienKirimKeunitLain = PasienkirimkeunitlainT::model()->findByPk($idPasienKirimKeUnitLain);
    $modRencanaOperasi = new BSRencanaOperasiT;
    $modRencanaOperasi->norencanaoperasi = MyGenerator::noRencanaOperasi();
    $modRencanaOperasi->tglrencanaoperasi = date('Y-m-d h:i:s');
    $modRencanaOperasi->statusoperasi = Params::DEFAULT_STATUS_OPERASI;
    $modPenunjang = new BSMasukPenunjangV;
    $modPenunjangSave = new BSPasienMasukPenunjangT;

    if (isset($_POST['BSRencanaOperasiT'])) {

      if (!empty($_POST['operasi_id'])) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          if (!empty($_POST['PasienkirimkeunitlainT']['kelaspelayanan_id'])) {
            $modPasienKirimKeunitLain->kelaspelayanan_id = $_POST['PasienkirimkeunitlainT']['kelaspelayanan_id'];
            $modPasienKirimKeunitLain->update_time = date("Y-m-d H:i:s");
            $modPasienKirimKeunitLain->update_loginpemakai_id = Yii::app()->user->id;
            $modPasienKirimKeunitLain->save();
          }
          $modPenunjangSave = $this->savePasienPenunjang($modPendaftaran, $modPasienKirimKeunitLain);
          $modRencanaOperasi = $this->saveRencanaOperasi($modPendaftaran, $modPenunjangSave, $_POST['BSRencanaOperasiT'], $_POST['operasi_id'], null, $_POST['BSTindakanPelayananT']);
          if ($this->successSave) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data berhasil disimpan");
            $module = Yii::app()->controller->module->id . '/DaftarPasien';
            $this->redirect(array('/' . $module));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        }
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan, Anda belum memilih operasi");
      }
    }


    $modRiwayatKirimKeUnitLain = BSPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array(
        'pendaftaran_id' => $pendaftaran_id,
        'ruangan_id' => Params::RUANGAN_ID_BEDAH,
      ),
      'pasienmasukpenunjang_id IS NULL'
    );
    $modRiwayatPenunjang = BSPasienMasukPenunjangT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      'ruangan_id' => Params::RUANGAN_ID_BEDAH,
    ));

    $this->render('masukPenunjang', array(
      'modPermintaan' => $modPermintaan,
      'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
      'modKegiatanOperasi' => $modKegiatanOperasi,
      'modOperasi' => $modOperasi,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modRiwayatPenunjang' => $modRiwayatPenunjang,
      'modRencanaOperasi' => $modRencanaOperasi,
      'modPenunjang' => $modPenunjang,
      'modPenunjangSave' => $modPenunjangSave,
      'modPasienKirimKeunitLain' => $modPasienKirimKeunitLain
    ));
  }

  /**
   * Fungsi untuk menyimpan data ke model BSPasienMasukPenunjangT
   * @param type $modPendaftaran
   * @param type $modPasien
   * @return ROPasienMasukPenunjangT 
   */
  protected function savePasienPenunjang($modPendaftaran, $modPasienKirimKeunitLain)
  {
    $modPasienPenunjang = new BSPasienMasukPenunjangT;
    $modPasienPenunjang->pasien_id = $modPendaftaran->pasien_id;
    $modPasienPenunjang->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
    $modPasienPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modPasienPenunjang->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
    $modPasienPenunjang->pegawai_id = $modPendaftaran->pegawai_id;
    $modPasienPenunjang->kelaspelayanan_id = $modPasienKirimKeunitLain->kelaspelayanan_id;
    $modPasienPenunjang->ruangan_id = Params::RUANGAN_ID_BEDAH;   //$modPendaftaran->ruangan_id;
    $modPasienPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang('BS');
    $modPasienPenunjang->tglmasukpenunjang = date('Y-m-d H:i:s');
    $modPasienPenunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($modPasienPenunjang->ruangan_id);
    $modPasienPenunjang->kunjungan = $modPendaftaran->kunjungan;
    $modPasienPenunjang->statusperiksa = $modPendaftaran->statusperiksa;
    $modPasienPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;
    $modPasienPenunjang->pasienkirimkeunitlain_id = $modPasienKirimKeunitLain->pasienkirimkeunitlain_id;

    if ($modPasienPenunjang->validate()) {
      $modPasienPenunjang->Save();
      $this->successSave = true;
      //                $this->updatePasienKirimKeUnitLain($modPasienPenunjang); << TIDAK MENGUPDATE
      $modPasienKirimKeunitLain->pasienmasukpenunjang_id = $modPasienPenunjang->pasienmasukpenunjang_id;
      $modPasienKirimKeunitLain->save();
    } else {
      $this->successSave = false;
    }

    return $modPasienPenunjang;
  }

  public function saveRencanaOperasi($attrPendaftaran, $attrPenunjang, $attrRencana, $attrOperasi, $attrCeklis, $attrTindakanPelayanan)
  {
    $arrSave = array();
    $validRencana = 'true';
    $arrOperasi = array(); // array untuk menampung operasi yg nantinnya digunakan pada proses saveTindakanPelayanan
    for ($i = 0; $i < count((array)$attrOperasi); $i++) {
      $format = new MyFormatter();
      $modRencana = new BSRencanaOperasiT;
      $modRencana->attributes = $attrRencana;
      $modRencana->norencanaoperasi = MyGenerator::noRencanaOperasi();
      $modRencana->pasienmasukpenunjang_id = $attrPenunjang->pasienmasukpenunjang_id;
      $modRencana->pendaftaran_id = $attrPenunjang->pendaftaran_id;
      $modRencana->pasien_id = $attrPenunjang->pasien_id;
      $modRencana->pasienadmisi_id = $attrPenunjang->pasienadmisi_id;

      $modRencana->dokterpelaksana1_id = $attrRencana['dokterpelaksana1_id'];
      $modRencana->kamarruangan_id = (!empty($modRencana->kamarruangan_id)) ? $modRencana->kamarruangan_id : null;
      $modRencana->dokterpelaksana2_id = (!empty($modRencana->dokterpelaksana2_id)) ? $modRencana->dokterpelaksana2_id : null;
      $modRencana->perawat_id = (!empty($modRencana->perawat_id)) ? $modRencana->perawat_id : null;
      $modRencana->dokteranastesi_id = (!empty($modRencana->dokteranastesi_id)) ? $modRencana->dokteranastesi_id : null;


      $modRencana->selesaioperasi = $format->formatDateTimeForDb($modRencana->tglrencanaoperasi); //sementara di set sama dl, nanti pas proses fix operasi baru di update lg
      $modRencana->mulaioperasi = $format->formatDateTimeForDb($modRencana->tglrencanaoperasi); //sementara di set sama dl, nanti pas proses fix operasi baru di update lg

      $modRencana->operasi_id = $attrOperasi[$i];
      $arrOperasi[$i] = array(
        'operasi' => $attrOperasi[$i]
      );

      $modRencana->create_time = date('Y-m-d H:i:s');
      $modRencana->create_loginpemakai_id = Yii::app()->user->id;
      $modRencana->create_ruangan = Yii::app()->user->getState('ruangan_id');

      if ($modRencana->validate()) {
        if ($modRencana->save()) {
          $simpanTindakanPelayanan = $this->saveTindakanPelayanT($attrPendaftaran, $attrPenunjang, $modRencana, $attrTindakanPelayanan, $attrOperasi[$i]);
        } else {
          $this->successSave = TRUE;
        }
      } else {
        $this->successSave = FALSE;
      }
    } //ENDING FOR 
    return $modRencana;
  }

  public function saveTindakanPelayanT($attrPendaftaran, $attrPenunjang, $attrRencanaOperasi, $attrTindakanPelayanan, $attrOperasi)
  {

    $modTindakanPelayanan = new BSTindakanPelayananT;
    $modTindakanPelayanan->penjamin_id = $attrPendaftaran->penjamin_id;
    $modTindakanPelayanan->pasien_id = $attrPendaftaran->pasien_id;
    $modTindakanPelayanan->kelaspelayanan_id = $_POST['kelaspelayanan_id'];
    $modTindakanPelayanan->tipepaket_id = 1;
    $modTindakanPelayanan->pendaftaran_id = $attrPendaftaran->pendaftaran_id;
    $modTindakanPelayanan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakanPelayanan->pasienmasukpenunjang_id = $attrPenunjang->pasienmasukpenunjang_id;
    $modTindakanPelayanan->daftartindakan_id = $attrOperasi['daftartindakan_id'];
    $modTindakanPelayanan->carabayar_id = $attrPendaftaran->carabayar_id;
    $modTindakanPelayanan->jeniskasuspenyakit_id = $attrPendaftaran->jeniskasuspenyakit_id;
    $modTindakanPelayanan->tgl_tindakan = date('Y-m-d H:i:s');
    $modTindakanPelayanan->tarif_satuan = $attrOperasi['tarif_satuan'];
    $modTindakanPelayanan->tarif_tindakan = $attrOperasi['tarif_tindakan'];
    $modTindakanPelayanan->satuantindakan = $attrOperasi['satuantindakan'];
    $modTindakanPelayanan->qty_tindakan = $attrOperasi['qty_tindakan'];

    $modTindakanPelayanan->rencanaoperasi_id = $attrRencanaOperasi->rencanaoperasi_id;
    $modTindakanPelayanan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modTindakanPelayanan->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $modTindakanPelayanan->cyto_tindakan = 0; //FALSE
    $modTindakanPelayanan->create_time = date('Y-m-d H:i:s');
    $modTindakanPelayanan->update_time = date('Y-m-d H:i:s');
    $modTindakanPelayanan->create_loginpemakai_id = Yii::app()->user->id;
    $modTindakanPelayanan->update_loginpemakai_id = Yii::app()->user->id;
    $modTindakanPelayanan->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($modTindakanPelayanan->cyto_tindakan) {
      $modTindakanPelayanan->tarifcyto_tindakan = $modTindakanPelayanan->tarif_tindakan * ($attrTindakanPelayanan['persencyto_tind'][$attrOperasi] / 100);
    } else {
      $modTindakanPelayanan->tarifcyto_tindakan = 0;
    }
    $modTindakanPelayanan->discount_tindakan = 0;
    $modTindakanPelayanan->dokterpemeriksa1_id = $attrRencanaOperasi->dokterpelaksana1_id;
    $modTindakanPelayanan->dokterpemeriksa2_id = (!empty($attrRencanaOperasi->dokterpelaksana2)) ? $attrRencanaOperasi->dokterpelaksana2 : null;
    $modTindakanPelayanan->perawat_id = (!empty($attrRencanaOperasi->perawat_id)) ? $attrRencanaOperasi->perawat_id : null;
    $modTindakanPelayanan->subsidiasuransi_tindakan = 0;
    $modTindakanPelayanan->subsidipemerintah_tindakan = 0;
    $modTindakanPelayanan->subsisidirumahsakit_tindakan = 0;
    $modTindakanPelayanan->iurbiaya_tindakan = 0;
    if ($modTindakanPelayanan->validate()) {
      if ($modTindakanPelayanan->save()) {
        $modTindakanPelayanan->saveTindakanKomponen();
      }
      $this->successSave = TRUE;
    } else {
      $this->successSave = FALSE;
    }

    return $modTindakanPelayanan;
  }

  protected function updatePasienKirimKeUnitLain($modPasienPenunjang)
  {

    if (!empty($_POST['permintaanPenunjang'])) {
      foreach ($_POST['permintaanPenunjang'] as $i => $item) {
        PasienkirimkeunitlainT::model()->updateByPk(
          $item['idPasienKirimKeUnitLain'],
          array('pasienmasukpenunjang_id' => $modPasienPenunjang->pasienmasukpenunjang_id)
        );
      }
    }
  }
  /**
   * membatalkan rujukan dari daftar pasien rujukan
   */
  public function actionBatalRujuk()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $idKirimUnit = $_POST['idKirimUnit'];
      $transaction = Yii::app()->db->beginTransaction();
      $status = 'ok';
      $status_bayar = 'ok';
      //PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id'=>$idKirimUnit));
      //PasienkirimkeunitlainT::model()->deleteByPk($idKirimUnit);
      //BSOperasisigninT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id'=>$idKirimUnit));
      try {
        $criteria = new CDbCriteria();
        $criteria->select = "count(t.permintaankepenunjang_id) as permintaankepenunjang_id";
        $criteria->join = "join tindakanpelayanan_t tp on tp.tindakanpelayanan_id = t.tindakanpelayanan_id ";
        $criteria->addCondition("t.pasienkirimkeunitlain_id = " . $idKirimUnit . " and tp.tindakansudahbayar_id is not null");
        $permintaan = PermintaankepenunjangT::model()->find($criteria);
        if ($permintaan->permintaankepenunjang_id > 0) {
          $keterangan = "Pemeriksaan tidak bisa dibatalkan karena ada pemeriksaan yang sudah dibayarkan";
        } else {
          $ok = true;
          $kirim = PasienkirimkeunitlainT::model()->findByPk($idKirimUnit);
          $permintaan = PermintaankepenunjangT::model()->findAllByAttributes(array(
            'pasienkirimkeunitlain_id' => $idKirimUnit
          ));


          foreach ($permintaan as $item) {
            if (!empty($item->tindakanpelayanan_id)) {
              $ok = $ok && TindakanpelayananT::model()->deleteByPk($item->tindakanpelayanan_id);
            }
          }
          //var_dump($idKirimUnit);
          $ok = $ok && PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $idKirimUnit));
          //var_dump($ok);
          $ok = $ok && PasienkirimkeunitlainT::model()->deleteByPk($idKirimUnit);
          //var_dump($ok);
          if (count(BSOperasisigninT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id' => $idKirimUnit))) > 0) {
            $ok = $ok && BSOperasisigninT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $idKirimUnit));
          }
          //var_dump($ok);
          $keterangan = "Pasien berhasil dibatalkan";
          if ($status == 'ok' && $ok) {
            $this->notifBatalRujuk($kirim);
            $transaction->commit();
          } else {
            $keterangan = "Pasien gagal dibatalkan";
            $status = 'not';
            $transaction->rollback();
          }
        }
      } catch (Exception $ex) {
        print_r($ex);
        $status = 'not';
        $transaction->rollback();
      }
      $data = array(
        'status' => $status,
        'keterangan' => $keterangan,
        //'smspasien'=>$smspasien,
        //'nama_pasien'=>$nama_pasien,
      );
      echo json_encode($data);
      Yii::app()->end();


      //$data['status'] = 'ok';
      //$data['keterangan']= "<div class='flash-success'>pasien berhasil dibatalkan</div>";

      //echo json_encode($data);
      // Yii::app()->end();
    }
  }

  public function actionLoadFormOperasiMasuk()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idOperasi = $_POST['idOperasi'];
      $idKelasPelayanan = $_POST['idKelasPelayanan'];
      //            echo $idOperasi;exit;
      //            echo $idKelasPelayanan;exit;
      $modOperasi = OperasiM::model()->with('kegiatanoperasi')->findByPk($idOperasi);
      $modTarif = TariftindakanM::model()->findByAttributes(array(
        'daftartindakan_id' => $modOperasi->daftartindakan_id,
        'kelaspelayanan_id' => $idKelasPelayanan,
        'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL
      ));
      echo CJSON::encode(array(
        'status' => 'create_form',
        'form' => $this->renderPartial('_formLoadOperasiMasuk', array(
          'modOperasi' => $modOperasi,
          'modTarif' => $modTarif,
          'idKelasPelayanan' => $idKelasPelayanan
        ), true)
      ));

      exit;
    }
  }

  public function actionSignIn($pasienkirimkeunitlain_id, $pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modKirimUnitLain = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);


    $model = BSOperasisigninT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id, 'pendaftaran_id' => $pendaftaran_id));

    $cekSignIn = array();
    $cekSignInDel = array();
    $getDet = array();

    if (empty($model)) {
      $model = new BSOperasisigninT;
      $model->signin_tgl = date('Y-m-d H:i:s');

      $morbid = PasienmorbiditasT::model()->findByAttributes(array(
        'pendaftaran_id' => $modKirimUnitLain->pendaftaran_id,
        'ruangan_id' => $modKirimUnitLain->create_ruangan,
      ), array(
        'order' => 'tglmorbiditas desc',
      ));

      if (!empty($morbid)) {
        $diag = DiagnosaM::model()->findByPk($morbid->diagnosa_id);
        $model->signin_diagnosapreop = $diag->diagnosa_kode . " - " . $diag->diagnosa_nama;
      }
    } else {
      $model->dokteranestesi_nama = $model->dokteranestesi->namaLengkap;
      $model->perawatsirkuler_nama = $model->perawatsirkuler->namaLengkap;

      $getDet = BSOperasisignindetT::model()->findAllByAttributes(array('operasisignin_id' => $model->operasisignin_id));

      foreach ($getDet as $det) {
        if ($det->signindet_hasil == true) {
          $st = 'true';
        } else {
          $st = 'false';
        }

        if ($det->checklistsignin_id == null || $det->checklistsignin_id == '') {
          $checklist = 'kosong';
        } else {
          $checklist = $det->checklistsignin_id;
        }

        $iden = $det->formsignin_id . $checklist;
        $cekSignIn["$iden"] = $iden . $st;
        $cekSignInDel["$iden"] = $det->operasisignindet_id;
      }
    }

    $modDet = new BSOperasisignindetT;

    $cri = new CDbCriteria();
    $cri->select = " fs.formsignin_id, fs.formsignin_nama, fs.haschecklist, t.checklistsignin_nama, t.checklistsignin_id";
    $cri->join = " RIGHT JOIN formsignin_m fs ON fs.formsignin_id = t.formsignin_id ";
    $cri->addCondition(" fs.formsignin_aktif = TRUE ");
    $cri->addCondition(" t.checklistsignin_aktif = TRUE OR t.checklistsignin_aktif IS NULL ");
    $cri->order = 't.checklistsignin_urutan';
    $loadFormIsian = BSChecklistsigninM::model()->findAll($cri);

    $loadSignIn = array();

    if (count((array)$loadFormIsian) > 0) {
      foreach ($loadFormIsian as $load) {

        if ($load->checklistsignin_id == null || $load->checklistsignin_id == '') {
          $checklist = 'kosong';
        } else {
          $checklist = $load->checklistsignin_id;
        }
        $loadSignIn[$load->formsignin_id]['form_id'] =  $load->formsignin_id;
        $loadSignIn[$load->formsignin_id]['check_id'] =  'kosong';
        $loadSignIn[$load->formsignin_id]['form_nama'] =  $load->formsignin_nama;
        $loadSignIn[$load->formsignin_id]['form_haschecklist'] =  $load->haschecklist;
        $loadSignIn[$load->formsignin_id]['value'] = isset($cekSignIn[$load->formsignin_id . $checklist]) ? $cekSignIn[$load->formsignin_id . $checklist] : null;
        if ($load->haschecklist) {
          $loadSignIn[$load->formsignin_id]['checklist'][$load->checklistsignin_id]['check_id'] =  $checklist;
          $loadSignIn[$load->formsignin_id]['checklist'][$load->checklistsignin_id]['check_nama'] =  $load->checklistsignin_nama;
          $loadSignIn[$load->formsignin_id]['checklist'][$load->checklistsignin_id]['value'] =  isset($cekSignIn[$load->formsignin_id . $checklist]) ? $cekSignIn[$load->formsignin_id . $checklist] : null;
        }
      }
    }

    //	echo "<pre>";
    //	print_r($loadSignIn);
    //	echo "</pre>";
    //	die;
    if (isset($_POST['BSOperasisigninT'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['BSOperasisigninT'];
        $model->signin_tgl = MyFormatter::formatDateTimeForDb($model->signin_tgl);
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $model->pasienkirimkeunitlain_id = $modKirimUnitLain->pasienkirimkeunitlain_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
        if ($model->isNewRecord) {
          $model->create_time = date('Y-m-d H:i:s');
          $model->update_time = date('Y-m-d H:i:s');
          $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
          $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        } else {
          $model->update_time = date('Y-m-d H:i:s');
          $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        }

        $this->simpan_signin = $this->simpan_signin && $model->save();
        if ($this->simpan_signin) {
          if (isset($_POST['BSOperasisignindetT']['signin'])) {
            foreach ($_POST['BSOperasisignindetT']['signin'] as $i => $val) {
              $modDet->attributes = $_POST['BSOperasisignindetT']['signin'][$i];

              $cri = new CDbCriteria();

              if ($modDet->checklistsignin_id == 'kosong' || $modDet->checklistsignin_id == '') {
                $modDet->checklistsignin_id = null;
                $cri->addCondition(" checklistsignin_id IS NULL ");
              } else {
                $cri->addCondition(" checklistsignin_id = " . $modDet->checklistsignin_id . " ");
              }
              $cri->addCondition(" operasisignin_id = " . $model->operasisignin_id . " ");
              $cri->addCondition(" formsignin_id = " . $modDet->formsignin_id . " ");

              $cek = BSOperasisignindetT::model()->find($cri);


              //var_dump($_POST['BSOperasisignindetT']['signin']);
              if (empty($cek)) {
                $modDet = new BSOperasisignindetT;
                $modDet->attributes =  $_POST['BSOperasisignindetT']['signin'][$i];
                if ($modDet->checklistsignin_id == 'kosong') {
                  $modDet->checklistsignin_id = null;
                }

                if ($modDet->signindet_hasil == '0') {
                  $modDet->signindet_hasil = false;
                } else {
                  $modDet->signindet_hasil = true;
                }

                $modDet->operasisignin_id = $model->operasisignin_id;
                $this->simpan_signindet = $this->simpan_signindet && $modDet->save();
              } else {
                $cek->attributes =  $_POST['BSOperasisignindetT']['signin'][$i];

                if ($cek->checklistsignin_id == 'kosong' || $cek->checklistsignin_id == '') {
                  $cek->checklistsignin_id = null;
                  $checklist = 'kosong';
                } else {
                  $checklist = $cek->checklistsignin_id;
                }

                if ($cek->signindet_hasil == '0') {
                  $cek->signindet_hasil = false;
                } else {
                  $cek->signindet_hasil = true;
                }

                $this->simpan_signindet = $this->simpan_signindet && $cek->save();

                $iden = $cek->formsignin_id . $checklist;
                //var_dump($iden);
                //var_dump($iden);										
                if (!empty($cekSignInDel)) {
                  unset($cekSignInDel[$iden]);
                }
              }
            }
            //var_dump($cekSignInDel);die;
            $del = $cekSignInDel;

            if (!empty($del)) {
              $delete =  array();
              foreach ($del as $d) {
                $delete[] = $d;
              }

              //var_dump($delete);die;

              $cri = new CDbCriteria();
              $cri->addCondition("operasisignin_id = '" . $model->operasisignin_id . "' ");
              $cri->addInCondition('operasisignindet_id', $delete);
              $up = BSOperasisignindetT::model()->deleteAll($cri);
            }
          } else {
            $del = $cekSignInDel;

            if (!empty($del)) {
              $delete =  array();
              foreach ($del as $d) {
                $delete[] = $d;
              }

              //var_dump($delete);die;

              $cri = new CDbCriteria();
              $cri->addCondition("operasisignin_id = '" . $model->operasisignin_id . "' ");
              $cri->addInCondition('operasisignindet_id', $delete);
              $up = BSOperasisignindetT::model()->deleteAll($cri);
            }
          }


          $modKirim = PasienkirimkeunitlainT::model()->findByAttributes(array(
            'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id,
          ));

          $daftar = PendaftaranT::model()->findByPk($modKirim->pendaftaran_id);
          $pasien = PasienM::model()->findByPk($daftar->pasien_id);

          $ruangan = RuanganM::model()->findByPk($modKirim->create_ruangan);


          $judul = 'Sign In Bedah Sentral'; //.$modKirim->no_rekam_medik.' - '.$modKirim->nama_pasien;

          $isi = $daftar->no_pendaftaran . ' - ' . $pasien->no_rekam_medik . ' - ' . $pasien->nama_pasien;


          CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => !empty($ruangan->modul_id) ? $ruangan->modul_id : null),
            array('instalasi_id' => Yii::app()->user->getState('instalasi_id'), 'ruangan_id' => Yii::app()->user->getState("ruangan_id"), 'modul_id' => Params::MODUL_ID_BEDAHSENTRAL),
          ));

          if ($this->simpan_signindet && $this->simpan_signin) {
            $transaction->commit();
            $status = true;
            Yii::app()->user->setFlash('success', "Data berhasil disimpan !");
            $this->redirect(array('signIn', 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id, 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
          } else {
            $transaction->rollback();
            $status = false;
            Yii::app()->user->setFlash('success', "Data gagal disimpan !");
          }
        } else {

          $transaction->rollback();
          $status = false;
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan');
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $status = false;
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($exc));
      }
    }

    $this->render($this->path_view_rujuk . 'signin._formSignIn', array(
      'modPendaftaran' => $modPendaftaran,
      'modKirimUnitLain' => $modKirimUnitLain,
      'model' => $model,
      'loadSignIn' => $loadSignIn,
      'modDet' => $modDet,
      'getDet' => $getDet
    ));
  }

  public function actionAddTambahDetailSignin()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $form_id = isset($_POST['form_id']) ? $_POST['form_id'] : null;
      $check_id = isset($_POST['check_id']) ? $_POST['check_id'] : null;
      $status = isset($_POST['status']) ? $_POST['status'] : null;
      $identifier = $form_id . '_' . $check_id;

      $pesan = '';
      $sukses = 1;

      $modDet = new BSOperasisignindetT;
      $modDet->formsignin_id = $form_id;
      $modDet->checklistsignin_id = $check_id;
      $modDet->signindet_hasil = $status;
      $modDet->identifier = $identifier;


      $tr = $this->renderPartial($this->path_view_rujuk . "signin._formGetSignIn", array('modDet' => $modDet, 'i' => 0), true);

      echo json_encode(array(
        'tr' => $tr,
        'pesan' => $pesan,
        'sukses' => $sukses,
        'identifier' => $identifier
      ));

      Yii::app()->end();
    }
  }

  /**
   * - digunakan untuk mengenerate notif batal rujukan
   * @param type $modKirimKeunitlain
   */
  protected function notifBatalRujuk($modKirimKeunitlain)
  {

    $modRuangan = RuanganM::model()->findByPk($modKirimKeunitlain->create_ruangan);
    $pasien_id = $modKirimKeunitlain->pasien_id;
    $modPasien = PasienM::model()->findByPk($pasien_id);
    $judul = 'Pasien Batal Bedah Sentral';

    $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien
      . '<br/>Tgl. Rujuk : ' . MyFormatter::formatDateTimeForUser($modKirimKeunitlain->tgl_kirimpasien);

    //var_dump($judul." , ".$isi);

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $modRuangan->instalasi_id, 'ruangan_id' => $modRuangan->ruangan_id, 'modul_id' => $modRuangan->modul_id),
      // array('instalasi_id'=> Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=> Params::MODUL_ID_BILLINGKASIR),
    ));
  }
}
