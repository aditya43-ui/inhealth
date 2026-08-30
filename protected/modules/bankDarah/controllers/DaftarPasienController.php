<?php

class DaftarPasienController extends MyAuthController
{

  public $successPengambilanSample = false;
  public $successKirimSample = false;
  public $path_view = 'bankDarah.views.daftarPasien.';

  public function actionIndex()
  {
    $format = new MyFormatter();
    // if(Yii::app()->user->getState('ruangan_id')==Params::RUANGAN_ID_LAB_KLINIK){
    $modPasienMasukPenunjang = new BDPasienMasukPenunjangV();
    // }else{
    //     $modPasienMasukPenunjang = new BDPasienmasukpenunjangT;
    // } 

    $modPasienMasukPenunjang->statusperiksahasil = NULL;
    $modPasienMasukPenunjang->tgl_awal = date('Y-m-d');
    $modPasienMasukPenunjang->tgl_akhir = date('Y-m-d');
    if (isset($_REQUEST['BDPasienMasukPenunjangV'])) {
      $modPasienMasukPenunjang->attributes = $_REQUEST['BDPasienMasukPenunjangV'];
      $modPasienMasukPenunjang->statusperiksahasil = $_REQUEST['BDPasienMasukPenunjangV']['statusperiksahasil'];
      $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BDPasienMasukPenunjangV']['tgl_awal']);
      $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BDPasienMasukPenunjangV']['tgl_akhir']);
    }
    $this->render('index', array('format' => $format, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang));
  }

  public function actionUpdateSample($pendaftaran_id, $pasienmasukpenunjang_id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_OPERATING)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));} 
    $format = new MyFormatter();
    $modPasienMasukPenunjang = BDPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modPengambilanSamples = BDPengambilanSampleT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modPengambilanSample = new BDPengambilanSampleT;
    $modKirimSample = new BDKirimSampleLabT;

    $modPengambilanSample->tglpengambilansample = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-MM-dd hh:mm:ss')
    );
    $modPengambilanSample->no_pengambilansample = "- Otomatis-";

    if (isset($_POST['BDPengambilanSampleT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        foreach ($_POST['BDPengambilanSampleT'] as $i => $postPengambilanSample) {
          if (!empty($postPengambilanSample['pengambilansample_id'])) {
            $modPengambilanSample = BDPengambilanSampleT::model()->findByPk($postPengambilanSample['pengambilansample_id']);
            if (isset($_POST['BDKirimSampleLabT'][$i]['kirimsamplelab_id'])) {
              $modPengambilanSample = BDKirimSampleLabT::model()->findByPk($_POST['BDKirimSampleLabT'][$i]['kirimsamplelab_id']);
            } else {
              $modKirimSample = new BDKirimSampleLabT;
            }
          } else {
            $modPengambilanSample = new BDPengambilanSampleT;
            $modKirimSample = new BDKirimSampleLabT;
          }
          if (isset($_POST['BDKirimSampleLabT'][$i]['isKirimSample'])) {
            if ($_POST['BDKirimSampleLabT'][$i]['isKirimSample'] == 1) { //Jika User MengisiKan Kirim Sample
              $modKirimSample->attributes = $_POST['BDKirimSampleLabT'][$i];
              $modKirimSample->tglkirimsample = $format->formatDateTimeForDb($_POST['BDKirimSampleLabT'][$i]['tglkirimsample']);
              if ($modKirimSample->validate()) {
                $modKirimSample->save();
                $modPengambilanSample->kirimsamplelab_id = $modKirimSample->kirimsamplelab_id;
                $this->successKirimSample = TRUE;
              } else {
                $this->successKirimSample = FALSE;
              }
            } else {
              $this->successKirimSample = TRUE;
            }
          } else {
            $this->successKirimSample = TRUE;
          }

          //                                        echo $format->formatDateTimeForDb($postPengambilanSample['tglpengambilansample']);
          //                                        exit();
          $tglambilsample = $format->formatDateTimeForDb($postPengambilanSample['tglpengambilansample']);
          $modPengambilanSample->attributes = $postPengambilanSample;
          $modPengambilanSample->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
          //					$modPengambilanSample->tglpengambilansample = $format->formatDateTimeForDb($postPengambilanSample['tglpengambilansample']);
          $modPengambilanSample->tglpengambilansample = $tglambilsample;
          //                                        $modPengambilanSample->tglpengambilansample = $postPengambilanSample['tglpengambilansample'];
          if ($modPengambilanSample->isNewRecord) {
            $modPengambilanSample->no_pengambilansample = MyGenerator::noPengambilanSample($modPengambilanSample->alatmedis_id);
            $modPengambilanSample->create_time = date("Y-m-d H:i:s");
            $modPengambilanSample->create_loginpemakai_id = Yii::app()->user->id;
            $modPengambilanSample->create_ruangan = Yii::app()->user->getState('ruangan_id');
          } else {
            $modPengambilanSample->update_time = date("Y-m-d H:i:s");
            $modPengambilanSample->update_loginpemakai_id = Yii::app()->user->id;
          }
          if ($modPengambilanSample->validate()) {
            $modPengambilanSample->save();
            BDKirimSampleLabT::model()->updateByPk($modKirimSample->kirimsamplelab_id, array('pengambilansample_id' => $modPengambilanSample->pengambilansample_id));
            $this->successPengambilanSample = TRUE;
            //Update status periksa
            $modHasilpemeriksaanLab = BDHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pendaftaran_id' => $pendaftaran_id));

            if (!empty($modHasilpemeriksaanLab)) {
              $modHasilpemeriksaanLab->statusperiksahasil = Params::STATUSPERIKSAHASIL_SEDANG; // SEDANG
              $modHasilpemeriksaanLab->update();
            }
          }
        }
        if ($this->successKirimSample && $this->successPengambilanSample) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
          $this->redirect(array('index'));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    $this->render('updateSample', array(
      'modPengambilanSample' => $modPengambilanSample,
      'modPengambilanSamples' => $modPengambilanSamples,
      'modKirimSample' => $modKirimSample,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang
    ));
  }

  public function actionHasilPemeriksaan($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id)
  {
    $modPasienMasukPenunjang = BDPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modPasienKirimKeUnitLain = BDPasienKirimKeUnitLainT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modPendaftaran = BDPendaftaranMp::model()->findByPk($pendaftaran_id);
    $modRujukanT = BDRujukanT::model()->findByPk($modPendaftaran->rujukan_id);
    $format = new MyFormatter();
    $modRujukanT = array();
    $kelompokUmur = (strtolower($modPasienMasukPenunjang->golonganumur_nama)) == 'bayi' ? 'dewasa' : 'dewasa';
    $modHasilpemeriksaanLab = BDHasilPemeriksaanLabT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
      'pasien_id' => $pasien_id
    ));
    $criteria = new CDbCriteria();
    $criteria->together = true;
    $criteria->with = array('pemeriksaanlab', 'pemeriksaandetail', 'pemeriksaandetail.nilairujukan');
    if (!empty($modHasilpemeriksaanLab->hasilpemeriksaanlab_id)) {
      $criteria->addCondition('hasilpemeriksaanlab_id = ' . $modHasilpemeriksaanLab->hasilpemeriksaanlab_id);
    }
    $criteria->compare('LOWER(nilairujukan_jeniskelamin)', strtolower(trim($modPasienMasukPenunjang->jeniskelamin)));
    $criteria->compare('LOWER(kelompokumur)', strtolower($kelompokUmur));
    $criteria->order = "pemeriksaanlab_urutan, pemeriksaanlabdet_nourut ASC";
    $modDetailHasilPemeriksaanLab = BDDetailHasilPemeriksaanLabT::model()->findAll($criteria);
    //jika belum ada hasil/pemeriksaan, maka input/pilih dulu pemeriksaannya
    if (empty($modDetailHasilPemeriksaanLab)) {
      $this->redirect($this->createUrl('pemeriksaanPasienBankDarah/index', array(
        'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
        'modul_id' => Yii::app()->session['modul_id']
      )));
    }
    $modNilaiRujukan = BDNilaiRujukanM::model()->findByAttributes(array(
      'kelompokumur' => strtoupper($modHasilpemeriksaanLab->hasil_kelompokumur),
      'nilairujukan_jeniskelamin' => strtoupper($modHasilpemeriksaanLab->hasil_jeniskelamin)
    ));
    $modHasilPemeriksaanPA = BDHasilPemeriksaanPAT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
      'pasien_id' => $pasien_id
    ));
    $modHasilpemeriksaanLab->tglpengambilanhasil = $format->formatDateTimeForUser($modHasilpemeriksaanLab->tglpengambilanhasil);


    if (isset($_POST['BDDetailHasilPemeriksaanLabT']) || isset($_POST['BDHasilPemeriksaanPAT'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (isset($_POST['BDRujukanT'])) { // Update Dokter Perujuk pada RujukanT
          $modRujukanDari = RujukandariM::model()->findByPk($_POST['BDRujukanT']['rujukandari_id']);
          $modRujukanT->nama_perujuk = $modRujukanDari->namaperujuk;
          $modRujukanT->update();
        }
        if (isset($_POST['BDDetailHasilPemeriksaanLabT'])) {

          $jumlahDetalHasilPemesiksaan = count((array)$_POST['BDDetailHasilPemeriksaanLabT']['detailhasilpemeriksaanlab_id']);

          for ($j = 0; $j < $jumlahDetalHasilPemesiksaan; $j++) :
            $idHasilPemeriksaan = $_POST['BDDetailHasilPemeriksaanLabT']['detailhasilpemeriksaanlab_id'][$j];
            $modDetailHasilPemeriksaanLab = BDDetailHasilPemeriksaanLabT::model()->findByPk($idHasilPemeriksaan);
            $modDetailHasilPemeriksaanLab->hasilpemeriksaan = $_POST['BDDetailHasilPemeriksaanLabT']['hasilpemeriksaan'][$j];
            $modDetailHasilPemeriksaanLab->nilairujukan = $_POST['BDDetailHasilPemeriksaanLabT']['nilairujukan'][$j];
            $modDetailHasilPemeriksaanLab->hasilpemeriksaan_satuan = $_POST['BDDetailHasilPemeriksaanLabT']['hasilpemeriksaan_satuan'][$j];
            $modDetailHasilPemeriksaanLab->hasilpemeriksaan_metode = $_POST['BDDetailHasilPemeriksaanLabT']['hasilpemeriksaan_metode'][$j];
            $modDetailHasilPemeriksaanLab->update();
          endfor;

          $modHasilpemeriksaanLab = BDHasilPemeriksaanLabT::model()->findByPk($_POST['BDHasilPemeriksaanLabT']['hasilpemeriksaanlab_id']);
          $modHasilpemeriksaanLab->catatanlabklinik = $_POST['BDHasilPemeriksaanLabT']['catatanlabklinik'];
          $modHasilpemeriksaanLab->tglpengambilanhasil = $format->formatDateTimeForDb($_POST['BDHasilPemeriksaanLabT']['tglpengambilanhasil']);
          $modHasilpemeriksaanLab->statusperiksahasil = Params::STATUSPERIKSAHASIL_SEDANG;
          $modHasilpemeriksaanLab->printhasillab = false;
          $modHasilpemeriksaanLab->update();
        }

        if (isset($_POST['BDHasilPemeriksaanPAT'])) {
          $this->saveHasilPemeriksaan($_POST['BDHasilPemeriksaanPAT']);
        }
        //Update dokter pemeriksa (pegawai_id) pada pasien masuk penunjang
        BDPasienmasukpenunjangT::model()->updateByPk($pasienmasukpenunjang_id, array('pegawai_id' => $_POST['BDPasienmasukpenunjangT']['pegawai_id']));
        $transaction->commit();
        Yii::app()->user->setFlash('success', "Data Hasil Pemeriksaan berhasil Disimpan");
        //                    $this->redirect($this->createUrl("index")); 
        $this->redirect($this->createUrl("/bankDarah/daftarPasien/Details", array('pendaftaran_id' => $pendaftaran_id, 'pasien_id' => $pasien_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'caraPrint' => 'PRINT')));
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    $this->render('hasilPemeriksaan', array(
      'modHasilpemeriksaanLab' => $modHasilpemeriksaanLab,
      'modNilaiRujukan' => $modNilaiRujukan,
      'modDetailHasilPemeriksaanLab' => $modDetailHasilPemeriksaanLab,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modHasilPemeriksaanPA' => $modHasilPemeriksaanPA,
      'modPasienKirimKeUnitLain' => $modPasienKirimKeUnitLain,
      //'modRincian'=>$modRincian,
      'modRujukanT' => $modRujukanT,
    ));
  }

  public function actionApprovePemeriksaan($pasienmasukpenunjang_id, $pendaftaran_id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_OPERATING)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));} 
    $modHasilpemeriksaanLab = BDHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pendaftaran_id' => $pendaftaran_id));
    $modHasilpemeriksaanLab->statusperiksahasil = Params::STATUSPERIKSAHASIL_SUDAH; // SUDAH

    if ($modHasilpemeriksaanLab->update())
      Yii::app()->user->setFlash('success', "Pemeriksaan Berhasil Disetujui!");
    else
      Yii::app()->user->setFlash('error', "Pemeriksaan Gagal Disetujui!");
    $this->redirect(array('index'));
  }

  public function actionApprovePemeriksaanAjax()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $status = 'ok';
      try {
        $pendaftaran_id = $_POST['pendaftaran_id'];
        $pasienmasukpenunjang_id = $_POST['idPenunjang'];
        $modHasilpemeriksaanLab = BDHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pendaftaran_id' => $pendaftaran_id));
        $modHasilpemeriksaanLab->statusperiksahasil = Params::STATUSPERIKSAHASIL_SUDAH; // SUDAH

        if ($modHasilpemeriksaanLab->update()) {
          $transaction->commit();
          $status = 'ok';
        } else {
          $transaction->rollback();
          $status = 'gagal';
        }
      } catch (Exception $ex) {
        print_r($ex);
        $status = 'gagal';
        $transaction->rollback();
      }
      $data['status'] = $status;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  protected function saveHasilPemeriksaan($arrHasil)
  {
    foreach ($arrHasil as $i => $hasil) {
      BDHasilPemeriksaanPAT::model()->updateByPk($hasil['hasilpemeriksaanpa_id'], array(
        'makroskopis' => $hasil['makroskopis'],
        'mikroskopis' => $hasil['mikroskopis'],
        'catatanpa' => $hasil['catatanpa'],
        'saranpa' => $hasil['saranpa']
      ));
    }
  }

  public function actionCancelPemeriksaan($pasienmasukpenunjang_id, $pendaftaran_id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_OPERATING)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));} 
    $modHasilpemeriksaanLab = BDHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pendaftaran_id' => $pendaftaran_id));
    $modHasilpemeriksaanLab->statusperiksahasil = Params::STATUSPERIKSAHASIL_SEDANG; // SEDANG
    if ($modHasilpemeriksaanLab->update())
      Yii::app()->user->setFlash('success', "Pemeriksaan Berhasil Dibatalkan !");
    else
      Yii::app()->user->setFlash('error', "Pemeriksaan Gagal Di Dibatalkan !");
    $this->redirect(array('index'));
  }

  public function actionCancelPemeriksaanAjax()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $status = 'ok';
      try {
        $pendaftaran_id = $_POST['pendaftaran_id'];
        $pasienmasukpenunjang_id = $_POST['idPenunjang'];
        $modHasilpemeriksaanLab = BDHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pendaftaran_id' => $pendaftaran_id));
        $modHasilpemeriksaanLab->statusperiksahasil = Params::STATUSPERIKSAHASIL_SEDANG; // SEDANG
        if ($modHasilpemeriksaanLab->update()) {
          $transaction->commit();
          $status = 'ok';
        } else {
          $transaction->rollback();
          $status = 'gagal';
        }
      } catch (Exception $ex) {
        print_r($ex);
        $status = 'gagal';
        $transaction->rollback();
      }
      $data['status'] = $status;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionDetails($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id)
  {
    $this->layout = '//layouts/iframe';

    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_LAB_KLINIK) {


      //            $cek_penunjang = BDPasienMasukPenunjangV::model()->findAllByAttributes(
      //                array('pendaftaran_id'=>$pendaftaran_id)
      //            );
      //            
      //            $data_rad = array();
      //            if(count((array)$cek_penunjang) > 1)
      //            {
      //                $masukpenunjangRad=BDPasienMasukPenunjangV::model()->findByAttributes(
      //                    array(
      //                        'pendaftaran_id'=>$pendaftaran_id,                        
      //                        'ruangan_id'=>Params::RUANGAN_ID_RAD,
      //                    )
      //                );
      //                $modHasilPeriksaRad = HasilpemeriksaanradV::model()->findAllByAttributes(
      //                    array(
      //                        'pasienmasukpenunjang_id'=>$masukpenunjangRad['pasienmasukpenunjang_id']
      //                    ),
      //                    array(
      //                        'order'=>'pemeriksaanrad_urutan'
      //                    )
      //                );
      //                
      //                foreach($modHasilPeriksaRad as $i=>$val)
      //                {
      //                    $data_rad[] = array(
      //                        'pemeriksaan'=>$val['pemeriksaanrad_nama'],
      //                       // 'hasil'=>'Hasil Pemeriksaan ' . $val['pemeriksaanrad_nama'] . ' terlampir',
      //                        'hasil'=>'Hasil terlampir'
      //                    );
      //                }
      //                    
      //            }

      $masukpenunjang = BDPasienMasukPenunjangV::model()->findByAttributes(
        array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id)
      );
      $unitLain = PasienkirimkeunitlainT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

      if (isset($unitLain) > 0) {
        $perujuk = PegawaiM::model()->findByAttributes(array('pegawai_id' => $unitLain->pegawai_id));
      } else {
        $perujuk = PegawaiM::model()->findByAttributes(array('pegawai_id' => $masukpenunjang->pegawai_id));
      }
      $pemeriksa = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);

      $modHasilPeriksa = HasilpemeriksaanlabV::model()->findByAttributes(
        array(
          'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
        )
      );

      $kelompokUmur = (strtolower($masukpenunjang->golonganumur_nama)) == 'bayi' ? 'dewasa' : 'dewasa';
      $query = "
                SELECT * FROM detailhasilpemeriksaanlab_t 
                JOIN pemeriksaanlab_m ON detailhasilpemeriksaanlab_t.pemeriksaanlab_id = pemeriksaanlab_m.pemeriksaanlab_id 
                JOIN pemeriksaanlabdet_m ON detailhasilpemeriksaanlab_t.pemeriksaanlabdet_id = pemeriksaanlabdet_m.pemeriksaanlabdet_id 
                JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
                JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id
                WHERE detailhasilpemeriksaanlab_t.hasilpemeriksaanlab_id = '" . $modHasilPeriksa->hasilpemeriksaanlab_id . "'
                    AND LOWER(nilairujukan_m.nilairujukan_jeniskelamin) = '" . strtolower(trim($masukpenunjang->jeniskelamin)) . "'
                    AND LOWER(nilairujukan_m.kelompokumur) = '" . $kelompokUmur . "'
                ORDER BY jenispemeriksaanlab_m.jenispemeriksaanlab_urutan,pemeriksaanlab_urutan,pemeriksaanlabdet_nourut
            ";
      $detailHasil = Yii::app()->db->createCommand($query)->queryAll();
      $data = array();
      $kelompokDet = null;
      $idx = 0;
      $temp = '';
      $goldarah = 0;
      foreach ($detailHasil as $i => $detail) {
        $id_jenisPeriksa = $detail['jenispemeriksaanlab_id'];
        $jenisPeriksa = $detail['jenispemeriksaanlab_nama'];
        $kelompokDet = $detail['kelompokdet'];
        if ($detail['pemeriksaanlab_id'] == '99') {
          $goldarah++;
        }
        if ($id_jenisPeriksa == '72') {
          $query = "
                        SELECT jenispemeriksaanlab_m.* FROM pemeriksaanlabdet_m
                        JOIN pemeriksaanlab_m ON pemeriksaanlabdet_m.pemeriksaanlab_id = pemeriksaanlab_m.pemeriksaanlab_id
                        JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
                        WHERE nilairujukan_id = " . $detail['nilairujukan_id'] . " AND pemeriksaanlab_m.jenispemeriksaanlab_id <> " . $id_jenisPeriksa . "
                    ";
          $rec = Yii::app()->db->createCommand($query)->queryRow();
          $id_jenisPeriksa = $rec['jenispemeriksaanlab_id'];
          $jenisPeriksa = $rec['jenispemeriksaanlab_nama'];
        }

        if ($temp != $kelompokDet) {
          $idx = 0;
        }

        $data[$id_jenisPeriksa]['tittle'] = $jenisPeriksa;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['id'] = $id_jenisPeriksa;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['nama'] = $jenisPeriksa;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['kelompok'] = $kelompokDet;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['kelompok'] = $kelompokDet;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['namapemeriksaan_det'] = $detail['pemeriksaanlab_nama'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['namapemeriksaan'] = $detail['namapemeriksaandet'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['id_pemeriksaan'] = $detail['nilairujukan_id'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['normal'] = $detail['nilairujukan_nama'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['metode'] = $detail['nilairujukan_metode'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['hasil'] = $detail['hasilpemeriksaan'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['nilairujukan'] = $detail['nilairujukan'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['satuan'] = $detail['hasilpemeriksaan_satuan'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['keterangan'] = $detail['nilairujukan_keterangan'];
        $temp = $kelompokDet;
        $idx++;
      }
    } else {
      $masukpenunjang = BDPasienMasukPenunjangV::model()->findByAttributes(
        array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id)
      );
      $pemeriksa = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);
      $modHasilPeriksa = HasilpemeriksaanpaT::model()->findByAttributes(
        array(
          'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
        )
      );
      $unitLain = PasienkirimkeunitlainT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      $perujuk = PegawaiM::model()->findByAttributes(array('pegawai_id' => $unitLain->pegawai_id));
      $data = HasilpemeriksaanpaT::model()->findAllByAttributes(
        array(
          'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
        )
      );
    }
    $this->render(
      'details',
      array(
        'modHasilPeriksa' => $modHasilPeriksa,
        'masukpenunjang' => $masukpenunjang,
        'pemeriksa' => $pemeriksa,
        'unitLain' => $unitLain,
        'perujuk' => $perujuk,
        'data' => $data,
        //               'data_rad'=>$data_rad,
        'goldarah' => $goldarah
      )
    );
  }

  public function actionPrintHasil($pasienmasukpenunjang_id, $pendaftaran_id, $caraPrint)
  {
    if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_LAB_KLINIK) {
      $masukpenunjang = BDPasienMasukPenunjangV::model()->findByAttributes(
        array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id)
      );
      $pemeriksa = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);

      $modHasilPeriksa = HasilpemeriksaanlabV::model()->findByAttributes(
        array(
          'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
        )
      );
      $kelompokUmur = (strtolower($masukpenunjang->golonganumur_nama)) == 'bayi' ? 'dewasa' : 'dewasa';
      $query = "
                SELECT * FROM detailhasilpemeriksaanlab_t 
                JOIN pemeriksaanlab_m ON detailhasilpemeriksaanlab_t.pemeriksaanlab_id = pemeriksaanlab_m.pemeriksaanlab_id 
                JOIN pemeriksaanlabdet_m ON detailhasilpemeriksaanlab_t.pemeriksaanlabdet_id = pemeriksaanlabdet_m.pemeriksaanlabdet_id 
                JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
                JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id
                WHERE detailhasilpemeriksaanlab_t.hasilpemeriksaanlab_id = '" . $modHasilPeriksa->hasilpemeriksaanlab_id . "'
                    AND LOWER(nilairujukan_m.nilairujukan_jeniskelamin) = '" . strtolower(trim($masukpenunjang->jeniskelamin)) . "'
                    AND LOWER(nilairujukan_m.kelompokumur) = '" . $kelompokUmur . "'
                ORDER BY jenispemeriksaanlab_m.jenispemeriksaanlab_urutan, pemeriksaanlab_urutan, pemeriksaanlabdet_nourut
            ";
      $detailHasil = Yii::app()->db->createCommand($query)->queryAll();

      $data = array();
      $kelompokDet = null;
      $idx = 0;
      $temp = '';

      foreach ($detailHasil as $i => $detail) {
        $id_jenisPeriksa = $detail['jenispemeriksaanlab_id'];
        $jenisPeriksa = $detail['jenispemeriksaanlab_nama'];
        $kelompokDet = $detail['kelompokdet'];
        if ($id_jenisPeriksa == '72') {
          $query = "
                        SELECT jenispemeriksaanlab_m.* FROM pemeriksaanlabdet_m
                        JOIN pemeriksaanlab_m ON pemeriksaanlabdet_m.pemeriksaanlab_id = pemeriksaanlab_m.pemeriksaanlab_id
                        JOIN jenispemeriksaanlab_m ON jenispemeriksaanlab_m.jenispemeriksaanlab_id = pemeriksaanlab_m.jenispemeriksaanlab_id
                        WHERE nilairujukan_id = " . $detail['nilairujukan_id'] . " AND pemeriksaanlab_m.jenispemeriksaanlab_id <> " . $id_jenisPeriksa . "
                    ";
          $rec = Yii::app()->db->createCommand($query)->queryRow();
          $id_jenisPeriksa = $rec['jenispemeriksaanlab_id'];
          $jenisPeriksa = $rec['jenispemeriksaanlab_nama'];
        }

        if ($temp != $kelompokDet) {
          $idx = 0;
        }
        $data[$id_jenisPeriksa]['tittle'] = $jenisPeriksa;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['id'] = $id_jenisPeriksa;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['nama'] = $jenisPeriksa;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['kelompok'] = $kelompokDet;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['kelompok'] = $kelompokDet;
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['namapemeriksaan_det'] = $detail['pemeriksaanlab_nama'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['namapemeriksaan'] = $detail['namapemeriksaandet'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['id_pemeriksaan'] = $detail['nilairujukan_id'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['normal'] = $detail['nilairujukan_nama'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['metode'] = $detail['nilairujukan_metode'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['hasil'] = $detail['hasilpemeriksaan'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['nilairujukan'] = $detail['nilairujukan'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['satuan'] = $detail['hasilpemeriksaan_satuan'];
        $data[$id_jenisPeriksa]['grid'][$kelompokDet]['pemeriksaan'][$idx]['keterangan'] = $detail['nilairujukan_keterangan'];

        $temp = $kelompokDet;
        $idx++;
      }
    } else {
      $masukpenunjang = BDPasienMasukPenunjangV::model()->findByAttributes(
        array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id)
      );
      $pemeriksa = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);
      $modHasilPeriksa = HasilpemeriksaanpaT::model()->findByAttributes(
        array(
          'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
        )
      );
      $data = HasilpemeriksaanpaT::model()->findAllByAttributes(
        array(
          'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
        )
      );
    }

    $judulLaporan = 'hasil_pemeriksaan_lab';
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render(
        'print_hasil',
        array(
          'judulLaporan' => $judulLaporan,
          'modHasilPeriksa' => $modHasilPeriksa,
          'detailHasil' => $detailHasil,
          'caraPrint' => $caraPrint,
          'hasil' => $data,
          'masukpenunjang' => $masukpenunjang,
          'pemeriksa' => $pemeriksa,
          'data' => $data
        )
      );
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render(
        'Print',
        array(
          'judulLaporan' => $judulLaporan,
          'caraPrint' => $caraPrint,
          'modHasilPeriksa' => $modHasilPeriksa,
          'detailHasil' => $detailHasil,
          'hasil' => $hasil,
          'masukpenunjang' => $masukpenunjang,
          'pemeriksa' => $pemeriksa,
          'data' => $data
        )
      );
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $this->layout = '//layouts/iframe';

      //                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $ukuranKertasPDF = 'LAB';   //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //                $mpdf->mirrorMargins = 2;  
      //                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      //                $mpdf->WriteHTML($stylesheet,1);
      /*
			 * cara ambil margin
			 * tinggi_header * 72 / (72/25.4)
			 *  tinggi_header = inchi
			 */
      $header = 1.14 * 72 / (72 / 25.4);
      $mpdf->AddPage($posisi, '', '', '', '', 3, 8, $header, 5, 0, 0);
      $mpdf->WriteHTML(
        $this->renderPartial(
          'print_hasil',
          array(
            'caraPrint' => $caraPrint,
            'judulLaporan' => $judulLaporan,
            'modHasilPeriksa' => $modHasilPeriksa,
            'detailHasil' => $detailHasil,
            'hasil' => $hasil,
            'masukpenunjang' => $masukpenunjang,
            'pemeriksa' => $pemeriksa,
            'data' => $data,
            //                            'data_rad'=>$data_rad
          ),
          true
        )
      );
      $mpdf->Output();
    }
  }

  public function actionPrint($pasienmasukpenunjang_id, $pendaftaran_id, $caraPrint)
  {
    $judulLaporan = 'Laporan Detail Permintaan Penawaran';
    //            $masukpenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);  
    $masukpenunjang = BDPasienMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $pemeriksa = PegawaiM::model()->findByPk($masukpenunjang->pegawai_id);
    $modHasilPeriksa = HasilpemeriksaanlabV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modHasilpemeriksaanLab = BDHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pendaftaran_id' => $pendaftaran_id));
    $modHasilpemeriksaanLab->printhasillab = true;
    $modHasilpemeriksaanLab->update();
    $detailHasil = DetailhasilpemeriksaanlabT::model()->findAllByAttributes(array('hasilpemeriksaanlab_id' => $modHasilPeriksa->hasilpemeriksaanlab_id), array('order' => 'detailhasilpemeriksaanlab_id'));

    $data = array();
    $kelompokDet = null;
    $idx = 0;
    $temp = '';
    foreach ($detailHasil as $i => $detail) {
      $id_jenisPeriksa = $detail->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_id;
      $jenisPeriksa = $detail->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
      $kelompokDet = $detail->pemeriksaandetail->nilairujukan->kelompokdet;

      if ($temp != $kelompokDet) {
        $idx = 0;
      }

      $data[$id_jenisPeriksa][$kelompokDet]['id'] = $id_jenisPeriksa;
      $data[$id_jenisPeriksa][$kelompokDet]['nama'] = $jenisPeriksa;
      $data[$id_jenisPeriksa][$kelompokDet]['kelompok'] = $kelompokDet;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['kelompok'] = $kelompokDet;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['namapemeriksaan_det'] = $detail->pemeriksaanlab->pemeriksaanlab_nama;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['namapemeriksaan'] = $detail->pemeriksaandetail->nilairujukan->namapemeriksaandet;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['id_pemeriksaan'] = $detail->pemeriksaandetail->nilairujukan->nilairujukan_id;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['normal'] = $detail->pemeriksaandetail->nilairujukan->nilairujukan_nama;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['metode'] = $detail->pemeriksaandetail->nilairujukan->nilairujukan_metode;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['hasil'] = $detail->hasilpemeriksaan;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['nilairujukan'] = $detail->nilairujukan;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['satuan'] = $detail->hasilpemeriksaan_satuan;
      $data[$id_jenisPeriksa][$kelompokDet]['pemeriksaan'][$idx]['keterangan'] = $detail->pemeriksaandetail->nilairujukan->nilairujukan_keterangan;

      $temp = $kelompokDet;
      $idx++;
    }

    $hasil = array();
    foreach ($detailHasil as $i => $detail) {
      $jenisPeriksa = $detail->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
      $kelompokDet = $detail->pemeriksaandetail->nilairujukan->kelompokdet;
      $hasil[$jenisPeriksa][$kelompokDet][$i]['namapemeriksaan'] = $detail->pemeriksaandetail->nilairujukan->namapemeriksaandet;
      $hasil[$jenisPeriksa][$kelompokDet][$i]['hasil'] = $detail->hasilpemeriksaan;
      $hasil[$jenisPeriksa][$kelompokDet][$i]['nilairujukan'] = $detail->nilairujukan;
      $hasil[$jenisPeriksa][$kelompokDet][$i]['satuan'] = $detail->hasilpemeriksaan_satuan;
      $hasil[$jenisPeriksa][$kelompokDet][$i]['keterangan'] = $detail->pemeriksaandetail->nilairujukan->nilairujukan_keterangan;
    }

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      //                $this->render('Print',array('judulLaporan'=>$judulLaporan,
      //                                            'caraPrint'=>$caraPrint,
      //                                            'modPermintaanPenawaran'=>$modPermintaanPenawaran,
      //                                            'modPermintaanPenawaranDetails'=>$modPermintaanPenawaranDetails));

      $this->render(
        'Print',
        array(
          'judulLaporan' => $judulLaporan,
          'caraPrint' => $caraPrint,
          'modHasilPeriksa' => $modHasilPeriksa,
          'detailHasil' => $detailHasil,
          'hasil' => $hasil,
          'masukpenunjang' => $masukpenunjang,
          'pemeriksa' => $pemeriksa,
          'data' => $data
        )
      );
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render(
        'Print',
        array(
          'judulLaporan' => $judulLaporan,
          'caraPrint' => $caraPrint,
          'modHasilPeriksa' => $modHasilPeriksa,
          'detailHasil' => $detailHasil,
          'hasil' => $hasil,
          'masukpenunjang' => $masukpenunjang,
          'pemeriksa' => $pemeriksa,
          'data' => $data
        )
      );
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML(
        $this->renderPartial(
          'Print',
          array(
            'judulLaporan' => $judulLaporan,
            'caraPrint' => $caraPrint,
            'modHasilPeriksa' => $modHasilPeriksa,
            'detailHasil' => $detailHasil,
            'hasil' => $hasil,
            'masukpenunjang' => $masukpenunjang,
            'pemeriksa' => $pemeriksa,
            'data' => $data
          ),
          true
        )
      );

      $mpdf->Output();
    }
  }

  public function actionBatalPenunjang($task = 'BatalPenunjang')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $cek = '';
      //$status = '';
      $status = false;
      $update_tindakan = false;
      $delete_tindakan = false;
      $delete_penunjang = false;

      $pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;

      $username = isset($_POST['nama_pemakai']) ? $_POST['nama_pemakai'] : null;
      $password = isset($_POST['kata_kunci']) ? $_POST['kata_kunci'] : null;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');

      $status_tindakan = false;
      $status_obat = false;
      $status_batal = true;
      $user = LoginpemakaiK::model()->findByAttributes(array(
        'nama_pemakai' => $username,
        'loginpemakai_aktif' => TRUE
      ));
      if ($user === null) {
        $data['error'] = "Login Pemakai salah!";
        $data['cssError'] = 'username';
        $data['status'] = 'Gagal Login';
        $pesan = 'Gagal Login';
      } else {
        // cek password
        if ($user->katakunci_pemakai !== $user->encrypt($password)) {
          $data['error'] = 'password salah!';
          $data['cssError'] = 'password';
          $data['status'] = 'Gagal Login';
          $pesan = 'Gagal Login';
        } else {
          $data['error'] = '';
          $cek = $this->checkAccess(array('loginpemakai_id' => $user->loginpemakai_id, 'action' => $task)); //dari MyAuthController
          if ($cek) {
            $data['status'] = 'success';
            $data['userid'] = $user->loginpemakai_id;
            $data['username'] = $user->nama_pemakai;

            $transaction = Yii::app()->db->beginTransaction();
            try {
              $criteria = new CDbCriteria();
              $criteria->addCondition('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
              $criteria->addCondition('tindakansudahbayar_id is not null');
              $modTindakanPelayanan = TindakanpelayananT::model()->find($criteria);

              $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
              $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

              if ($modPendaftaran->ruangan_id == $modPasienMasukPenunjang->ruangan_id) {
                $criteriaTindakan = new CDbCriteria();
                $criteriaTindakan->addCondition('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
                $criteriaTindakan->addCondition('tindakansudahbayar_id is not null');

                $modTindakanPelayanan = TindakanpelayananT::model()->find($criteriaTindakan);

                $criteriaObat = new CDbCriteria();
                $criteriaObat->addCondition('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
                $criteriaObat->addCondition('oasudahbayar_id is not null');
                $modObatalkesPasien = ObatalkespasienT::model()->find($criteriaObat);

                if (!empty($modTindakanPelayanan)) {
                  $status_tindakan = true;
                }

                if ($modObatalkesPasien) {
                  $status_obat = true;
                }

                if ($status_tindakan == true || $status_obat == true) {
                  $status_batal = false;
                  $pesan = "Pemeriksaan tidak bisa dibatalkan karena ada tindakan/obat yang sudah dibayarkan. Silakan hubungi Kasir!";
                } else {
                  $status_batal = true;
                }

                if ($status_batal == true) {
                  /*
									 * cek data pendaftaran pasien masuk penunjang
									 */
                  $criteria = new CDbCriteria();
                  if (!empty($pasienmasukpenunjang_id)) {
                    $criteria->addCondition("pasienmasukpenunjang_id = " . $pasienmasukpenunjang_id);
                  }

                  $pasienMasukPenunjang = PasienmasukpenunjangT::model()->find($criteria);

                  $pesan = '';
                  $status = false;
                  $model = new PasienbatalperiksaR();
                  $model->pendaftaran_id = $pendaftaran_id;
                  $model->pasien_id = $modPendaftaran->pasien_id;
                  $model->tglbatal = isset($tglbatal) ? MyFormatter::formatDateTimeForDb($tglbatal) : date('Y-m-d');
                  $model->keterangan_batal = isset($keterangan_batal) ? $keterangan_batal : "Batal Pemeriksaan Laboratorium";
                  $model->create_ruangan = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                  $model->create_time = date('Y-m-d H:i:s');
                  $model->create_loginpemakai_id = Yii::app()->user->id;

                  if ($model->save()) {
                    $status = true;
                    $pesan = "Pemeriksaan pasien berhasil dibatalkan!";
                  } else {
                    $status = false;
                    $pesan = "Pemeriksaan gagal dibatalkan! " . CHtml::errorSummary($model);
                    $cek = "simpan pasienbatal gagal";
                  }

                  $attributes = array(
                    'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
                    'update_time' => date('Y-m-d H:i:s'),
                    'update_loginpemakai_id' => Yii::app()->user->id
                  );
                  $pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);

                  if (!empty($pasienMasukPenunjang)) {
                    if ($pasienMasukPenunjang->pasienkirimkeunitlain_id == null) {
                      $attributes = array(
                        'pasienkirimkeunitlain_id' => $pasienMasukPenunjang->pasienkirimkeunitlain_id
                      );
                      $Perminataan_penunjang = PermintaankepenunjangT::model()->deleteAllByAttributes($attributes);
                    }

                    $attributes = array(
                      'statusperiksa' => Params::STATUSPERIKSA_BATAL_PERIKSA,
                      'update_time' => date('Y-m-d H:i:s'),
                      'update_loginpemakai_id' => Yii::app()->user->id
                    );
                    //										
                    /*
										 * cek data tindakan_pelayanan
										 */
                    $attributes = array(
                      'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id,
                      'tindakansudahbayar_id' => null
                    );

                    $criteria2 = new CDbCriteria();
                    $criteria2->addCondition('pasienmasukpenunjang_id = ' . $pasienMasukPenunjang->pasienmasukpenunjang_id);
                    $criteria2->addCondition('tindakansudahbayar_id is null');
                    $tindakan = TindakanpelayananT::model()->findAll($criteria2);

                    if (count((array)$tindakan) > 0) {

                      foreach ($tindakan as $val => $key) {
                        $attributes = array(
                          'tindakanpelayanan_id' => $key->tindakanpelayanan_id
                        );
                        $hapus_komponen = TindakankomponenT::model()->deleteAllByAttributes($attributes);
                      }

                      $attributes = array(
                        'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id
                      );

                      $hapus_tindakan = TindakanPelayananT::model()->deleteAllByAttributes($attributes);
                      if (!$hapus_tindakan) {
                        $status = false;
                        $pesan = "exist";
                        $cek = "hapus tindakan gagal";
                      }
                    } else {
                      $status = true;
                    }

                    $criteriaObat2 = new CDbCriteria();
                    $criteriaObat2->addCondition('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
                    $criteriaObat2->addCondition('oasudahbayar_id is null');
                    $modObatalkesPasien2 = ObatalkespasienT::model()->findAll($criteriaObat2);

                    if (count((array)$modObatalkesPasien2) > 0) {

                      foreach ($modObatalkesPasien2 as $val => $obat) {
                        $attributes = array(
                          'obatalkespasien_id' => $obat->obatalkespasien_id
                        );
                        $hapusobatalkes = ObatalkeskomponenT::model()->deleteAllByAttributes($attributes);
                      }

                      $hapus_obat = ObatalkespasienT::model()->deleteAllByAttributes($attributes);
                      if (!$hapus_obat) {
                        $status = false;
                        $pesan = "exist";
                        $cek = "hapus obat gagal";
                      }
                    } else {
                      $status = true;
                    }
                  }
                  $penunjang = PasienmasukpenunjangT::model()->updateByPk($pasienMasukPenunjang->pasienmasukpenunjang_id, $attributes);
                  $updatePenunjangUnitLain = PasienmasukpenunjangT::model()->updateByPk($pasienMasukPenunjang->pasienmasukpenunjang_id, array('pasienkirimkeunitlain_id' => NULL));
                  if ($pasienMasukPenunjang->pasienkirimkeunitlain_id != NULL) {
                    $permintaanPenunjang = PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienMasukPenunjang->pasienkirimkeunitlain_id));
                  }
                  $kirimUnitLain = PasienkirimkeunitlainT::model()->deleteAllByAttributes(array('pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id));
                  $pengambilanSample = PengambilansampleT::model()->deleteAllByAttributes(array('pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id));
                  $penunjang = PasienmasukpenunjangT::model()->deleteByPk($pasienMasukPenunjang->pasienmasukpenunjang_id);
                  if (!$penunjang) {
                    $status = false;
                  }
                }
              } else {
                if (!empty($modTindakanPelayanan)) {
                  $status = false;
                  $pesan = "Pemeriksaan tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!";
                } else {
                  $update_tindakanpelayanan = TindakanpelayananT::model()->updateAll(
                    array(
                      'detailhasilpemeriksaanlab_id' => null,
                      'hasilpemeriksaanrm_id' => null,
                      'hasilpemeriksaanrad_id' => null,
                      'hasilpemeriksaanpa_id' => null
                    ),
                    'pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id
                  );

                  if ($update_tindakanpelayanan) {
                    $update_tindakan = true;
                    $status = true;
                  } else {
                    $update_tindakan = false;
                    $status = false;
                  }

                  $delete_tindakanpelayanan = TindakanpelayananT::model()->deleteAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
                  if ($delete_tindakanpelayanan) {
                    $delete_tindakan = true;
                    $status = true;
                  } else {
                    $delete_tindakan = false;
                    $status = false;
                  }

                  if ($delete_tindakan) {
                    if ($modPasienMasukPenunjang->pasienkirimkeunitlain_id != NULL) {
                      $permintaanPenunjang = PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $modPasienMasukPenunjang->pasienkirimkeunitlain_id));
                    }
                    $updatePenunjangUnitLain = PasienmasukpenunjangT::model()->updateByPk($pasienmasukpenunjang_id, array('pasienkirimkeunitlain_id' => NULL));
                    $kirimunitlain = PasienkirimkeunitlainT::model()->deleteAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
                    $pengambilanSample = PengambilansampleT::model()->deleteAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
                    $delete_pasienmasukpenunjang = PasienmasukpenunjangT::model()->deleteByPk($pasienmasukpenunjang_id);
                    if ($delete_pasienmasukpenunjang) {
                      $delete_penunjang = true;
                      $status = true;
                    } else {
                      $delete_penunjang = false;
                      $status = false;
                    }
                  }
                }
              }
              if ($status != false) {
                $transaction->commit();
                $pesan = 'Pasien Penunjang berhasil di batalkan';
              } else {
                $transaction->rollback();
              }
            } catch (Exception $ex) {
              $status = false;
              $pesan = "exist";
              $cek = $ex;
              $transaction->rollback();
            }
          } else {
            $data['status'] = 'Tidak memiliki akses untuk melakukan pembatalan!';
          }
        }
      }

      $data = array(
        'pesan' => $pesan,
        'status' => $status,
        'cek' => $cek,
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  //	public function actionBatalPeriksaPasienLuar() { // ada perubahan di RND-10294
  //		$nama_modul = Yii::app()->controller->module->id;
  //		$nama_controller = Yii::app()->controller->id;
  //		$nama_action = Yii::app()->controller->action->id;
  //
  //		$pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null;
  //		$pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
  //		$statusperiksa = isset($_POST['statusperiksa']) ? $_POST['statusperiksa'] : null;
  //		$tglbatal = isset($_POST['tglbatal']) ? $_POST['tglbatal'] : null;
  //		$keterangan_batal = isset($_POST['keterangan_batal']) ? $_POST['keterangan_batal'] : null;
  //		$nama_pemakai = isset($_POST['nama_pemakai']) ? $_POST['nama_pemakai'] : null;
  //		$kata_kunci = isset($_POST['kata_kunci']) ? $_POST['kata_kunci'] : null;
  //
  //
  //		$modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
  //		$smspasien = 1;
  //		$smsdokter = 1;
  //		$criteria = new CDbCriteria;
  //		$criteria->compare('modul_id',$modul_id);
  //		$criteria->compare('LOWER(modcontroller)',strtolower($nama_controller),true);
  //		$criteria->compare('LOWER(modaction)',strtolower($nama_action),true);
  //		if(isset($_POST['tujuansms'])){
  //			$criteria->addInCondition('tujuansms',$_POST['tujuansms']);
  //		}
  //		$modSmsgateway = SmsgatewayM::model()->findAll($criteria);
  //
  //		$status_tindakan = false;
  //		$status_obat = false;
  //		$status_batal = true;
  //		$pesan = '';
  //		if(Yii::app()->request->isAjaxRequest)
  //		{ 
  //		  $transaction = Yii::app()->db->beginTransaction();
  //		  try{
  //			  $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
  //			  $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
  //
  //				$criteriaTindakan = new CDbCriteria();
  //				$criteriaTindakan->addCondition('pasienmasukpenunjang_id = '.$pasienmasukpenunjang_id);
  //				$criteriaTindakan->addCondition('tindakansudahbayar_id is not null');
  //
  //				$modTindakanPelayanan = TindakanpelayananT::model()->find($criteriaTindakan);
  //
  //				$criteriaObat = new CDbCriteria();
  //				$criteriaObat->addCondition('pasienmasukpenunjang_id = '.$pasienmasukpenunjang_id);
  //				$criteriaObat->addCondition('oasudahbayar_id is not null');
  //				$modObatalkesPasien = ObatalkespasienT::model()->find($criteriaObat);
  //
  //				if($modTindakanPelayanan){
  //					$status_tindakan = true;
  //				}
  //
  //				if($modObatalkesPasien){
  //					$status_obat = true;
  //				}
  //
  //				if($status_tindakan == true || $status_obat == true){
  //					$status_batal = false;
  //					$pesan = "Pemeriksaan tidak bisa dibatalkan karena ada tindakan/obat yang sudah dibayarkan. Silakan hubungi Kasir!";
  //				}else{
  //					$status_batal = true;								
  //				}
  //
  //				if($status_batal == true){
  //					/*
  //					* cek data pendaftaran pasien masuk penunjang
  //					*/
  //					$criteria = new CDbCriteria();
  //					if(!empty($pasienmasukpenunjang_id)){
  //						$criteria->addCondition("pasienmasukpenunjang_id = ".$pasienmasukpenunjang_id);						
  //					}
  //
  //					$pasienMasukPenunjang = PasienmasukpenunjangT::model()->find($criteria);
  //
  //					$pesan = '';
  //					$status = false;
  //					$model = new PasienbatalperiksaR();
  //					$model->pendaftaran_id = $pendaftaran_id;
  //					$model->pasien_id = $modPendaftaran->pasien_id;
  //					$model->tglbatal = isset($tglbatal) ? MyFormatter::formatDateTimeForDb($tglbatal) : date('Y-m-d');
  //					$model->keterangan_batal = isset($keterangan_batal) ? $keterangan_batal : "Batal Pemeriksaan Laboratorium";
  //					$model->create_ruangan = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
  //					$model->create_time = date('Y-m-d H:i:s');
  //					$model->create_loginpemakai_id = Yii::app()->user->id;
  //
  //					if($model->save())
  //					{
  //						$status = true;
  //						$pesan = "Pemeriksaan pasien berhasil dibatalkan!";
  //					}else{
  //						$status = false;
  //						$pesan = "Pemeriksaan gagal dibatalkan! ".CHtml::errorSummary($model);
  //					}
  //
  //					$attributes = array(
  //						'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
  //						'update_time' => date('Y-m-d H:i:s'),
  //						'update_loginpemakai_id' => Yii::app()->user->id
  //					);
  //					$pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);
  //
  //					if(count((array)$pasienMasukPenunjang) > 0){
  //						if($pasienMasukPenunjang->pasienkirimkeunitlain_id == null)
  //						{
  //							$attributes = array(
  //								'pasienkirimkeunitlain_id' => $pasienMasukPenunjang->pasienkirimkeunitlain_id
  //							);
  //							$Perminataan_penunjang = PermintaankepenunjangT::model()->deleteAllByAttributes($attributes);
  //						}
  //
  //						$attributes = array(
  //							'statusperiksa' => Params::STATUSPERIKSA_BATAL_PERIKSA,
  //							'update_time' => date('Y-m-d H:i:s'),
  //							'update_loginpemakai_id' => Yii::app()->user->id
  //						);
  //						$penunjang = PasienmasukpenunjangT::model()->updateByPk($pasienMasukPenunjang->pasienmasukpenunjang_id, $attributes);
  //						if(!$penunjang)
  //						{
  //							$status = false;
  //						}
  //						/*
  //						* cek data tindakan_pelayanan
  //						*/
  //					   $attributes = array(
  //						   'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id,
  //						   'tindakansudahbayar_id' => null
  //					   );
  //
  //					   $criteria2 = new CDbCriteria();
  //					   $criteria2->addCondition('pasienmasukpenunjang_id = '.$pasienMasukPenunjang->pasienmasukpenunjang_id);
  //					   $criteria2->addCondition('tindakansudahbayar_id is null');
  //					   $tindakan = TindakanpelayananT::model()->findAll($criteria2);
  //
  //					   if(count((array)$tindakan) > 0)
  //					   {
  //
  //						   foreach($tindakan as $val=>$key)
  //						   {
  //							   $attributes = array(
  //								   'tindakanpelayanan_id' => $key->tindakanpelayanan_id
  //							   );
  //							   $hapus_komponen= TindakankomponenT::model()->deleteAllByAttributes($attributes);
  //						   }
  //
  //						   $attributes = array(
  //							   'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id
  //						   );
  //
  //						   $hapus_tindakan = TindakanPelayananT::model()->deleteAllByAttributes($attributes);
  //						   if(!$hapus_tindakan)
  //						   {
  //							   $status = false;
  //							   $pesan = "exist";
  //						   }
  //					   }else{
  //						   $status = true;
  //					   }
  //
  //						$criteriaObat2 = new CDbCriteria();
  //						$criteriaObat2->addCondition('pasienmasukpenunjang_id = '.$pasienmasukpenunjang_id);
  //						$criteriaObat2->addCondition('oasudahbayar_id is null');
  //						$modObatalkesPasien2 = ObatalkespasienT::model()->findAll($criteriaObat2);
  //
  //						if(count((array)$modObatalkesPasien2) > 0)
  //						{
  //
  //							foreach($modObatalkesPasien2 as $val=>$obat)
  //							{
  //								$attributes = array(
  //									'obatalkespasien_id' => $obat->obatalkespasien_id
  //								);
  //								$hapusobatalkes= ObatalkeskomponenT::model()->deleteAllByAttributes($attributes);
  //							}
  //
  //							$hapus_obat = ObatalkespasienT::model()->deleteAllByAttributes($attributes);
  //							if(!$hapus_obat)
  //							{
  //								$status = false;
  //								$pesan = "exist";
  //							}
  //						}else{
  //							$status = true;
  //						}
  //					}
  //
  //					  /*
  //					  * kondisi_commit
  //					  */
  //					 if($status == true)
  //					 {
  //						$modPegawai = $modPendaftaran->pegawai;
  //						$modPasien = $modPendaftaran->pasien;
  //						// SMS GATEWAY
  //						if(Yii::app()->user->getState('issmsgateway')){								
  //							$sms = new Sms();
  //							foreach ($modSmsgateway as $i => $smsgateway) {
  //								$isiPesan = $smsgateway->templatesms;
  //
  //								$attributes = $modPasien->getAttributes();
  //								foreach($attributes as $attributes => $value){
  //									$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
  //								}
  //								$attributes = $model->getAttributes();
  //								foreach($attributes as $attributes => $value){
  //									$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
  //								}
  //								$isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($model->tglbatal),$isiPesan);
  //
  //								if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
  //									if(!empty($modPasien->no_mobile_pasien)){
  //										$sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
  //									}else{
  //										$smspasien = 0;
  //									}
  //								}elseif($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms){
  //									if(!empty($modPegawai->nomobile_pegawai)){
  //										$sms->kirim($modPegawai->nomobile_pegawai,$isiPesan);
  //									}else{
  //										$smsdokter = 0;
  //									}
  //								}
  //
  //							}
  //						}
  //						// END SMS GATEWAY
  //
  //						$transaction->commit();
  //					}else{
  //						$transaction->rollback();
  //
  //					}
  //				}
  //		  }catch(Exception $ex){
  //			  $status = false;
  //			  $pesan = "exist";
  //			  $transaction->rollback();
  //		  }  
  //
  //		  $data = array(
  //			  'pesan'=>$pesan,
  //			  'status'=>$status,
  //			  'smspasien'=>$smspasien,
  //			  'smsdokter'=>$smsdokter,
  //			  'nama_pasien'=>$modPasien->nama_pasien,
  //			  'nama_pegawai'=>$modPegawai->nama_pegawai,
  //		  );
  //		  echo json_encode($data);
  //		  Yii::app()->end();            
  //	  }
  //	}
  public function actionBatalPeriksaPasienLuarTidakDipakai3()
  {
    $idKirimUnit = null;

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
    $smspasien = 1;
    $nama_pasien = '';

    $status_tindakan = false;
    $status_obat = false;
    $status_batal = true;
    $pesan = '';
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $pesan = 'success';
      $status = 'ok';

      try {

        $criteriaTindakan = new CDbCriteria();
        $criteriaTindakan->addCondition('pendaftaran_id = ' . $pendaftaran_id);
        $criteriaTindakan->addCondition('tindakansudahbayar_id is not null');

        $modTindakanPelayanan = TindakanpelayananT::model()->findAll($criteriaTindakan);

        $criteriaObat = new CDbCriteria();
        $criteriaObat->addCondition('pendaftaran_id = ' . $pendaftaran_id);
        $criteriaObat->addCondition('oasudahbayar_id is not null');
        $modObatalkesPasien = ObatalkespasienT::model()->findAll($criteriaObat);

        if (count((array)$modTindakanPelayanan) > 0) {
          $status_tindakan = true;
        }

        if (count((array)$modObatalkesPasien) > 0) {
          $status_obat = true;
        }

        if ($status_tindakan == true || $status_obat == true) {
          $status_batal = false;
          $pesan = "Pemeriksaan tidak bisa dibatalkan karena ada tindakan/obat yang sudah dibayarkan. Silakan hubungi Kasir!";
        } else {
          $status_batal = true;
        }

        if ($status_batal == true) {
          /*
					 * cek data pendaftaran &  pasien masuk penunjang
					 */
          $pasienMasukPenunjang = PasienmasukpenunjangT::model()->findByAttributes(
            array(
              'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
              'ruangan_id' => Params::RUANGAN_ID_LAB_KLINIK
            )
          );

          if (!empty($pasienMasukPenunjang)) {
            $pendaftaran = PendaftaranT::model()->findByPk($pasienMasukPenunjang->pendaftaran_id);
            $pendaftaran_id = $pasienMasukPenunjang->pendaftaran_id;
            $pasien_id = $pasienMasukPenunjang->pasien_id;
            $pasienmasukpenunjang_id = $pasienMasukPenunjang->pasienmasukpenunjang_id;
            $pasienkirimkeunitlain_id = $pasienMasukPenunjang->pasienkirimkeunitlain_id;
          } else {
            $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
            $pendaftaran_id = $pendaftaran->pendaftaran_id;
            $pasien_id = $pendaftaran->pasien_id;
            $pasienmasukpenunjang_id = null;
            $pasienkirimkeunitlain_id = $idKirimUnit;
          }
          if (empty($pasienMasukPenunjang->pasienkirimkeunitlain_id)) {
            $model = new PasienbatalperiksaR();
            $model->pendaftaran_id = $pendaftaran_id;
            $model->pasien_id = $pasien_id;
            $model->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
            $model->tglbatal = isset($tglbatal) ? MyFormatter::formatDateTimeForDb($tglbatal) : date('Y-m-d');
            $model->keterangan_batal = isset($keterangan_batal) ? $keterangan_batal : "Batal Laboratorium";
            $model->create_time = date('Y-m-d H:i:s');
            $model->update_time = null;
            $model->create_loginpemakai_id = Yii::app()->user->id;
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

            if (!$model->save()) {
              $status = 'not';
              $pesan = 'exist';
              $keterangan = "<div class='flash-success'>Data gagal disimpan</div>";
            }

            if (empty($pendaftaran->pembayaranpelayanan_id)) {
              $attributes = array(
                'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
                'update_time' => date('Y-m-d H:i:s'),
                'update_loginpemakai_id' => Yii::app()->user->id
              );
              $pendaftaran = BDPendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);

              // $attributes = array(
              //     'pasienkirimkeunitlain_id' => $pasienMasukPenunjang->pasienkirimkeunitlain_id
              // );
              // $Perminataan_penunjang = PermintaankepenunjangT::model()->deleteAllByAttributes($attributes);
              // SMS GATEWAY
              $modPasien = PasienM::model()->findByPk($model->pasien_id);
              $nama_pasien = $modPasien->nama_pasien;
              $sms = new Sms();

              foreach ($modSmsgateway as $i => $smsgateway) {
                $isiPesan = $smsgateway->templatesms;

                $attributes = $modPasien->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $attributes = $model->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($model->tglbatal), $isiPesan);


                if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                  if (!empty($modPasien->no_mobile_pasien)) {
                    $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                  } else {
                    $smspasien = 0;
                  }
                }
              }
              // END SMS GATEWAY

              $pesan = 'success';
              $status = 'ok';
              $keterangan = "<div class='flash-success'>Data berhasil disimpan</div>";
            } else {
              $pesan = 'exist';
              $keterangan = "<div class='flash-success'>Pasien <b> " . $pendaftaranT->pendaftaran->pasien->nama_pasien . " 
											   </b> sudah melakukan pembayaran pemeriksaan </div>";
            }
          } else {
            /*
						 * cek data tindakan_pelayanan
						 */
            $attributes = array(
              'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id,
            );
            $tindakan = BDTindakanPelayananT::model()->findAllByAttributes($attributes);
            if (count((array)$tindakan) > 0) {
              if (empty($tindakan->tindakansudahbayar_id)) {
                $findHasil = HasilpemeriksaanlabT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id));
                if (empty($pendaftaran->pembayaranpelayanan_id)) {
                  $model = new PasienbatalperiksaR();
                  $model->pendaftaran_id = $pendaftaran_id;
                  $model->pasien_id = $pasien_id;
                  $model->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
                  $model->pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id;
                  $model->tglbatal = isset($tglbatal) ? MyFormatter::formatDateTimeForDb($tglbatal) : date('Y-m-d');
                  $model->keterangan_batal = isset($keterangan_batal) ? $keterangan_batal : "Batal Laboratorium";
                  $model->create_time = date('Y-m-d H:i:s');
                  $model->update_time = null;
                  $model->create_loginpemakai_id = Yii::app()->user->id;
                  $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                  if (!$model->save()) {
                    $status = 'not';
                    $pesan = 'exist';
                    $keterangan = "<div class='flash-success'>Data gagal disimpan</div>";
                  }
                  $attributes = array(
                    'statusperiksa' => 'BATAL PERIKSA',
                    'update_time' => date('Y-m-d H:i:s'),
                    'update_loginpemakai_id' => Yii::app()->user->id
                  );
                  $penunjang = PasienmasukpenunjangT::model()->updateByPk($pasienMasukPenunjang->pasienmasukpenunjang_id, $attributes);

                  $pesan = 'success';
                  $status = 'ok';
                  $keterangan = "<div class='flash-success'>Data berhasil disimpan</div>";
                } else {
                  $pesan = 'exist';
                  $keterangan = "<div class='flash-success'>Pasien <b> " . $pendaftaranT->pendaftaran->pasien->nama_pasien . " 
														   </b> sudah melakukan pembayaran pemeriksaan </div>";
                }
              } else {
                $pesan = 'exist';
                $keterangan = "<div class='flash-success'>Pasien <b> " . $pendaftaranT->pendaftaran->pasien->nama_pasien . " 
												   </b> sudah melakukan pembayaran pemeriksaan </div>";
              }
            } else {
              if (empty($tindakan->tindakansudahbayar_id)) {
                $findHasil = HasilpemeriksaanlabT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id));
                $model = new PasienbatalperiksaR();
                $model->pendaftaran_id = $pendaftaran_id;
                $model->pasien_id = $pasien_id;
                $model->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
                $model->pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id;
                $model->tglbatal = date('Y-m-d');
                $model->keterangan_batal = "Batal Laboratorium";
                $model->create_time = date('Y-m-d H:i:s');
                $model->update_time = null;
                $model->create_loginpemakai_id = Yii::app()->user->id;
                $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

                if (!$model->save()) {
                  $status = 'not';
                  $pesan = 'exist';
                  $keterangan = "<div class='flash-success'>Data gagal disimpan</div>";
                }

                if (empty($pendaftaran->pembayaranpelayanan_id)) {
                  $attributes = array(
                    'statusperiksa' => 'BATAL PERIKSA',
                    'update_time' => date('Y-m-d H:i:s'),
                    'update_loginpemakai_id' => Yii::app()->user->id
                  );
                  $penunjang = PasienmasukpenunjangT::model()->updateByPk($pasienMasukPenunjang->pasienmasukpenunjang_id, $attributes);

                  $pesan = 'success';
                  $status = 'ok';
                  $keterangan = "<div class='flash-success'>Data berhasil disimpan</div>";
                } else {
                  $pesan = 'exist';
                  $keterangan = "<div class='flash-success'>Pasien <b> " . $pendaftaranT->pendaftaran->pasien->nama_pasien . " 
															   </b> sudah melakukan pembayaran pemeriksaan </div>";
                }
              } else {
                $pesan = 'exist';
                $keterangan = "<div class='flash-success'>Pasien <b> " . $pendaftaranT->pendaftaran->pasien->nama_pasien . " 
												   </b> sudah melakukan pembayaran pemeriksaan </div>";
              }
            }
          }

          /*
					 * kondisi_commit
					 */
          if ($status == 'ok') {
            $transaction->commit();
          } else {
            $transaction->rollback();
          }
        }
      } catch (Exception $ex) {
        print_r($ex);
        $status = 'not';
        $transaction->rollback();
      }

      $data['pesan'] = $pesan;
      $data['status'] = $status;
      $data['keterangan'] = $keterangan;
      $data['smspasien'] = $smspasien;
      $data['nama_pasien'] = $nama_pasien;


      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionBatalPeriksaPasienLuar2()
  { //ini fungsi yang lama tapi jangan Di HAPUS, takut minta di rubah lagi
    // if(!Yii::app()->user->checkAccess(Params::DEFAULT_OPERATING)){
    //     throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));
    // }
    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $pesan = 'success';
      $status = 'ok';

      try {
        $pendaftaran_id = $_POST['pendaftaran_id'];

        /*
				 * cek data pendaftaran pasien masuk penunjang
				 */
        $pasienMasukPenunjang = PasienmasukpenunjangT::model()->findByAttributes(
          array(
            'pendaftaran_id' => $pendaftaran_id
          )
        );

        $model = new PasienbatalperiksaR();
        $model->pendaftaran_id = $pendaftaran_id;
        $model->pasien_id = $pasienMasukPenunjang->pasien_id;
        $model->tglbatal = date('Y-m-d');
        $model->keterangan_batal = "Batal Laboratorium";
        $model->create_time = date('Y-m-d H:i:s');
        $model->update_time = null;
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if (!$model->save()) {
          $status = 'not';
        }

        if (empty($pasienMasukPenunjang->pasienkirimkeunitlain_id)) {
          $attributes = array(
            'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
            'update_time' => date('Y-m-d H:i:s'),
            'update_loginpemakai_id' => Yii::app()->user->id
          );
          $pendaftaran = BDPendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);

          $attributes = array(
            'pasienkirimkeunitlain_id' => $pasienMasukPenunjang->pasienkirimkeunitlain_id
          );
          $Perminataan_penunjang = PermintaankepenunjangT::model()->deleteAllByAttributes($attributes);
        }

        $attributes = array(
          'statusperiksa' => 'BATAL PERIKSA',
          'update_time' => date('Y-m-d H:i:s'),
          'update_loginpemakai_id' => Yii::app()->user->id
        );
        $penunjang = PasienmasukpenunjangT::model()->updateByPk($pasienMasukPenunjang->pasienmasukpenunjang_id, $attributes);

        if (!$penunjang) {
          $status = 'not';
        }


        /*
				 * cek data tindakan_pelayanan
				 */
        $attributes = array(
          'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id,
          'tindakansudahbayar_id' => null
        );
        $tindakan = BDTindakanPelayananT::model()->findAllByAttributes($attributes);

        if (count((array)$tindakan) > 0) {
          foreach ($tindakan as $val => $key) {
            $attributes = array(
              'tindakanpelayanan_id' => $key->tindakanpelayanan_id
            );
            $hapus_det_tindakan = BDDetailHasilPemeriksaanLabT::model()->deleteAllByAttributes($attributes);
          }


          $attributes = array(
            'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id
          );
          $hapus_tindakan = BDTindakanPelayananT::model()->deleteAllByAttributes($attributes);
          if (!$hapus_tindakan) {
            $status = 'not';
          }
        } else {
          $pesan = 'exist';
        }

        /*
				 * kondisi_commit
				 */
        if ($status == 'ok') {
          $transaction->commit();
        } else {
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        print_r($ex);
        $status = 'not';
        $transaction->rollback();
      }

      $data['pesan'] = $pesan;
      $data['status'] = $status;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionBatalPeriksaPasienLuarTidakDipakai()
  {
    $ajax = Yii::app()->request->isAjaxRequest;
    // if(!Yii::app()->user->checkAccess(Params::DEFAULT_OPERATING)){
    //     throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));
    // } 
    if ($ajax) {
      $pendaftaran_id = $_POST['idpendaftaran'];
      $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $pasien = PasienM::model()->findByPk($pendaftaran->pasien_id);
      $pasienMasukPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pasien_id' => $pendaftaran->pasien_id));
      $hasilPemeriksaanLab = HasilpemeriksaanlabT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

      $pasienKirimKeUnitLain = PasienkirimkeunitlainT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'instalasi_id' => 5));
      $detailHasilPemeriksaanLab = DetailhasilpemeriksaanlabT::model()->findAllByAttributes(array('hasilpemeriksaanlab_id' => $hasilPemeriksaanLab->hasilpemeriksaanlab_id));

      $cekPasien = substr($pendaftaran->no_pendaftaran, 0, 2);
      //                jika pasien berasal dari pendaftaran pasien luar
      if ($cekPasien == 'BD') {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          //                   update rujuakan_id = null terlebih dahulu di pendaftaran_t
          $updateRujuakan = PendaftaranT::model()->updateByPk($pendaftaran_id, array('rujukan_id' => null));
          //                    delete tabel rujukan sesuai dengan id_rujuan yang berada di pendaftaran_t
          $deletePasienRujukan = RujukanT::model()->deleteByPk($pendaftaran->rujukan_id);
          //                    delete penagambilan sampel berdasarkan pasienmasukpenunjang_id di pasienmasukpenunjang_t
          $deletePengambilanSample = PengambilansampleT::model()->deleteAllByAttributes(array('pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id));
          //                    delete detailhasilpemeriksaanlab_t berdasarkan dengan hasilpemeriksaanlab_id
          $deleteDetailPemeriksaanLab = DetailhasilpemeriksaanlabT::model()->deleteAllByAttributes(array('hasilpemeriksaanlab_id' => $hasilPemeriksaanLab->hasilpemeriksaanlab_id));
          //                    delete hasilpemeriksaanlab_t berdasarkan pendaftaran_id
          $deleteHasilPemeriksaanLab = HasilpemeriksaanlabT::model()->deleteAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
          //                    delete uabahcarabayar_t berdasarkan pendaftaran_id
          $deleteUbahCarabayar = UbahcarabayarR::model()->deleteAll('pendaftaran_id = ' . $pendaftaran_id);
          //                    delete tindakanpelayanan_t berdasarkan pendaftaran_id
          $deleteTindakanPelayanan = TindakanpelayananT::model()->deleteAll('pendaftaran_id = ' . $pendaftaran_id);
          //                    delete pasienmasuk penunjang berdasarkan pendaftaran_t
          $deletePasienMasukPenunjang = PasienmasukpenunjangT::model()->deleteAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
          //                    delete pendaftaran berdasarkan id_pendaftaran
          $deletePendaftaran = PendaftaranT::model()->deleteByPk($pendaftaran_id);
          //                    delete pasie_m berdasarkan pasien_id
          //                        $deletePasien               = PasienM::model()->deleteByPk($pasien->pasien_id);
          //                    
          //                    $delete = $deletePasienRujukan && $deletePengambilanSample && $deleteUbahCarabayar && $deleteHasilPemeriksaanLab && $deleteTindakanPelayanan && $deletePasien && $deletePendaftaran;

          if ($deletePasien && $pendaftaran) {
            $data['status'] = 'success';
            $transaction->commit();
          } else {
            $data['status'] = 'gagal';
            $transaction->rollback();
            throw new Exception("Pasien tidak bisa dibatalkan");
          }
        } catch (Exception $ex) {
          $transaction->rollback();
          $data['status'] = 'gagal';
          $data['info'] = $ex;
        }
      } else {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          //                        echo "pasienkirimke unit lain->".$pasienKirimKeUnitLain->pasienmasukpenunjang_id;
          //                        echo "----pasien masuk penunjang ->".$pasienKirimKeUnitLain->pasienmasukpenunjang_id;
          $updatePasienKirimKeUnitLain = PasienkirimkeunitlainT::model()->updateByPk(
            $pasienKirimKeUnitLain->pasienkirimkeunitlain_id,
            array('pasienmasukpenunjang_id' => null)
          );

          $deleteDetailPemeriksaanLab = DetailhasilpemeriksaanlabT::model()->deleteAllByAttributes(
            array('hasilpemeriksaanlab_id' => $hasilPemeriksaanLab->hasilpemeriksaanlab_id)
          );

          foreach ($detailHasilPemeriksaanLab as $key => $deleteDetailHasil) {
            $deleteTindakanPelayanan = TindakanpelayananT::model()->deleteByPk($deleteDetailHasil->tindakanpelayanan_id);
          }

          $deleteHasilPemeriksaanLab = HasilpemeriksaanlabT::model()->deleteAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
          //                        $deletePasienMasukPenunjang = PasienmasukpenunjangT::model()->deleteAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id)); 
          $deletePasienMasukPenunjang = PasienmasukpenunjangT::model()->deleteByPk($pasienKirimKeUnitLain->pasienmasukpenunjang_id);
          if ($deletePasienMasukPenunjang) {
            $data['status'] = 'success';
            $transaction->commit();
          } else {
            $data['status'] = 'gagal';
            $transaction->rollback();
            throw new Exception("Pasien tidak bisa dibatalkan");
          }
        } catch (Exception $ex) {
          $transaction->rollback();
          $data['status'] = 'gagal';
          $data['info'] = $ex;
        }
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionUbahPasien($id, $pendaftaran_id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = BDPasienM::model()->findByPk($id);
    $modPendaftaran = BDPendaftaranT::model()->findByPk($pendaftaran_id);
    $format = new MyFormatter();
    $temLogo = $model->photopasien;
    $model->update_time = date('Y-m-d');
    $model->update_loginpemakai_id = Yii::app()->user->id;
    $model->tgl_rekam_medik = $format->formatDateTimeForUser($model->tgl_rekam_medik);
    if (isset($_POST['BDPasienM'])) {
      $random = rand(0000000, 9999999);
      $model->attributes = $_POST['BDPasienM'];
      $model->umur = $_POST['BDPasienM']['umur'];
      //                    $modPendaftaran->attributes = $_POST['BDPendaftaranT'];

      $model->umur = $_POST['BDPasienM']['umur'];
      $model->tanggal_lahir = $format->formatDateTimeForDb($model->tanggal_lahir);
      $model->kelompokumur_id = CustomFunction::getKelompokUmur($model->tanggal_lahir);
      $model->photopasien = CUploadedFile::getInstance($model, 'photopasien');
      $gambar = $model->photopasien;
      $model->tgl_rekam_medik = $format->formatDateTimeForDb($model->tgl_rekam_medik);

      if (!empty($model->photopasien)) { //if user input the photo of patient
        $model->photopasien = $random . $model->photopasien;

        Yii::import("ext.EPhpThumb.EPhpThumb");

        $thumb = new EPhpThumb();
        $thumb->init(); //this is needed

        $fullImgName = $model->photopasien;
        $fullImgSource = Params::pathPasienDirectory() . $fullImgName;
        $fullThumbSource = Params::pathPasienTumbsDirectory() . 'kecil_' . $fullImgName;

        if ($model->save()) {
          if (!empty($temLogo)) {
            if (file_exists(Params::pathPasienDirectory() . $temLogo))
              unlink(Params::pathPasienDirectory() . $temLogo);
            if (file_exists(Params::pathPasienTumbsDirectory() . 'kecil_' . $temLogo))
              unlink(Params::pathPasienTumbsDirectory() . 'kecil_' . $temLogo);
          }
          $gambar->saveAs($fullImgSource);
          $thumb->create($fullImgSource)
            ->resize(200, 200)
            ->save($fullThumbSource);
          BDPendaftaranT::model()->updateByPk($pendaftaran_id, array('umur' => $model->umur));
          //                            $model->updateByPk($id, array('tgl_rekam_medik'=>$model->tgl_rekam_medik));
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          //                            $this->redirect(array('cariPasien'));
        } else {
          Yii::app()->user->setFlash('error', 'Data <strong>Gagal!</strong>  disimpan.');
        }
      } else { //if user not input the photo
        $model->photopasien = $temLogo;
        if ($model->save()) {
          //                            $model->updateByPk($id, array('tgl_rekam_medik'=>$model->tgl_rekam_medik));
          BDPendaftaranT::model()->updateByPk($pendaftaran_id, array('umur' => $model->umur));
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          //                            $this->redirect(array('cariPasien'));
        }
      }
    }
    $this->render($this->path_view . 'ubahPasien', array('model' => $model));
  }

  /**
   * actionPrintKartuGolonganDarah
   * @param type $pendaftaran_id
   * @param type $pasienmasukpenunjang_id
   * @param type $caraPrint
   */
  public function actionPrintKartuGolonganDarah($pasienmasukpenunjang_id, $pendaftaran_id, $caraPrint = null)
  {
    $this->layout = '//layouts/iframe';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = BDPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modHasilPemeriksaan = HasilpemeriksaanlabT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
    $modPeriksaGolonganDarah = DetailhasilpemeriksaanlabT::model()->findByAttributes(array('hasilpemeriksaanlab_id' => $modHasilPemeriksaan->hasilpemeriksaanlab_id, 'pemeriksaanlab_id' => Params::PERIKSA_GOLONGANDARAH_ID));
    $modPeriksaRhesus = DetailhasilpemeriksaanlabT::model()->findByAttributes(array('hasilpemeriksaanlab_id' => $modHasilPemeriksaan->hasilpemeriksaanlab_id, 'pemeriksaanlab_id' => Params::PERIKSA_RHESUS_ID));
    if ($modPeriksaGolonganDarah) {
      if (empty($modPeriksaGolonganDarah->hasilpemeriksaan)) {
        echo "Hasil pemeriksaan golongan darah masih kosong !";
      } else {
        if ($_REQUEST['caraPrint'] == 'PDF') {
          $this->layout = '//layouts/iframe';

          //                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
          $ukuranKertasPDF = 'KGDLAB';   //Ukuran Kertas Pdf
          $posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
          $mpdf = new MyPDF60('', $ukuranKertasPDF);
          $mpdf->mirrorMargins = 2;
          $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
          $mpdf->WriteHTML($stylesheet, 1);
          /*
					 * cara ambil margin
					 * tinggi_header * 72 / (72/25.4)
					 *  tinggi_header = inchi
					 */
          $header = 0.4 * 72 / (72 / 25.4);
          $mpdf->AddPage($posisi, '', '', '', '', 3, 8, $header, 2, 0, 0);
          $mpdf->WriteHTML(
            $this->renderPartial('PrintKartuGolonganDarah', array(
              'caraPrint' => $caraPrint,
              'modPasien' => $modPasien,
              'modPendaftaran' => $modPendaftaran,
              'modHasilPemeriksaan' => $modHasilPemeriksaan,
              'modPeriksaGolonganDarah' => $modPeriksaGolonganDarah,
              'modPeriksaRhesus' => $modPeriksaRhesus,
            ), true)
          );
          $mpdf->Output();
        } else if ($caraPrint == 'PRINT') {
          $this->layout = '//layouts/printWindows';
          $this->render('PrintKartuGolonganDarah', array(
            'caraPrint' => $caraPrint,
            'modPasien' => $modPasien,
            'modPendaftaran' => $modPendaftaran,
            'modHasilPemeriksaan' => $modHasilPemeriksaan,
            'modPeriksaGolonganDarah' => $modPeriksaGolonganDarah,
            'modPeriksaRhesus' => $modPeriksaRhesus,
          ));
        }
      }
    } else {
      echo "Pasien " . $modPasien->no_rekam_medik . " - " . $modPasien->nama_pasien . " tidak melakukan pemeriksaan golongan darah";
    }
  }

  public function actionGetUmur()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $format = new MyFormatter;
      $tglLahir = $format->formatDateTimeForDb($_POST['tglLahir']);
      $dob = $tglLahir;
      $today = date("Y-m-d");
      list($y, $m, $d) = explode('-', $dob);
      list($ty, $tm, $td) = explode('-', $today);
      if ($td - $d < 0) {
        $day = ($td + 30) - $d;
        $tm--;
      } else {
        $day = $td - $d;
      }
      if ($tm - $m < 0) {
        $month = ($tm + 12) - $m;
        $ty--;
      } else {
        $month = $tm - $m;
      }
      $year = $ty - $y;

      // $data['umur'] = str_pad($year, 2, '0', STR_PAD_LEFT).' Thn '. str_pad($month, 2, '0', STR_PAD_LEFT) .' Bln '. str_pad($day, 2, '0', STR_PAD_LEFT).' Hr';
      $data['thn'] = str_pad($year, 2, '0', STR_PAD_LEFT);
      $data['bln'] = str_pad($month, 2, '0', STR_PAD_LEFT);
      $data['hr'] = str_pad($day, 2, '0', STR_PAD_LEFT);
      //$data['umur'] = $dob;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionAddKabupaten()
  {
    $modelKab = new KabupatenM;
    $modProp = PropinsiM::model()->findAll();

    if (isset($_POST['KabupatenM'])) {
      $modelKab->attributes = $_POST['KabupatenM'];
      $modelKab->kabupaten_aktif = true;
      if ($modelKab->save()) {
        $data = KabupatenM::model()->findAllByAttributes(array('propinsi_id' => $_POST['KabupatenM']['propinsi_id'],), array('order' => 'kabupaten_nama'));
        $data = CHtml::listData($data, 'kabupaten_id', 'kabupaten_nama');

        if (empty($data)) {
          $kabupatenOption = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $kabupatenOption = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($data as $value => $name) {
            $kabupatenOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }

        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Kabupaten <b>" . $_POST['KabupatenM']['kabupaten_nama'] . "</b> berhasil ditambahkan </div>",
            'kabupaten' => $kabupatenOption,
          ));
          exit;
        }
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formAddKabupaten', array('model' => $modelKab, 'modProp' => $modProp), true)
      ));
      exit;
    }
  }

  /**
   * action ketika tombol panggil di klik
   */
  public function actionPanggil()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $data['pesan'] = "";
      $pasienmasukpenunjang_id = ($_POST['pasienmasukpenunjang_id']);
      $keterangan = (isset($_POST['keterangan']) ? $_POST['keterangan'] : null);
      $pasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

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

      if (isset($pasienMasukPenunjang)) {
        if ($pasienMasukPenunjang->panggilantrian == true) {
          if ($keterangan == "batal") {
            $pasienMasukPenunjang->panggilantrian = false;
            if ($pasienMasukPenunjang->update()) {
              // SMS GATEWAY
              $modPasien = $pasienMasukPenunjang->pasien;
              $sms = new Sms();
              $smspasien = 1;
              foreach ($modSmsgateway as $i => $smsgateway) {
                $isiPesan = $smsgateway->templatesms;

                $attributes = $modPasien->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $attributes = $pasienMasukPenunjang->getAttributes();
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
              $data['pesan'] = "Pemanggilan no. antrian " . $pasienMasukPenunjang->no_urutperiksa . " dibatalkan !";
            }
          } else {
            $data['pesan'] = "No. antrian " . $pasienMasukPenunjang->no_urutperiksa . " sudah dipanggil sebelumnya !";
          }
        } else {
          $pasienMasukPenunjang->panggilantrian = true;
          if ($pasienMasukPenunjang->update()) {
            $data['pesan'] = "No. antrian " . $pasienMasukPenunjang->no_urutperiksa . " dipanggil !";
            // $data_telnet = $pasienMasukPenunjang->ruangan->ruangan_nama.", ".$pasienMasukPenunjang->ruangan->ruangan_singkatan."-".$pasienMasukPenunjang->no_urutperiksa;
            //              AKAN DIGANTI MENGGUNAKAN NODE JS
            // self::postTelnet($data_telnet);
          }
        }
      }

      $attributes = $pasienMasukPenunjang->attributeNames();
      foreach ($attributes as $i => $attribute) {
        $data["$attribute"] = $pasienMasukPenunjang->$attribute;
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  public function actionGetAntrianTerakhir()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $data['pesan'] = "";
      $criteria = new CDbCriteria;
      $criteria->addCondition('panggilantrian != TRUE');
      $criteria->addCondition('date(tglmasukpenunjang) BETWEEN \'' . date('d M Y') . '\' AND \'' . date('d M Y') . '\'');
      $criteria->order = 'no_urutperiksa ASC';

      $model = PasienmasukpenunjangV::model()->find($criteria);
      if (!empty($model)) {
        $data['pasienmasukpenunjang_id'] = $model->pasienmasukpenunjang_id;
        $data['ruangan_singkatan'] = $model->ruangan_singkatan;
        $data['no_urutperiksa'] = $model->no_urutperiksa;
        $data['ruangan_id'] = $model->ruangan_id;
      } else {
        $data['pesan'] = "Tidak ada antrian!";
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  public function actionAddKelurahan()
  {
    $modelKel = new KelurahanM;

    if (isset($_POST['KelurahanM'])) {
      $modelKel->attributes = $_POST['KelurahanM'];
      $modelKel->kelurahan_aktif = true;
      if ($modelKel->save()) {
        $data = KelurahanM::model()->findAllByAttributes(array('kecamatan_id' => $_POST['KelurahanM']['kecamatan_id']), array('order' => 'kelurahan_nama'));
        $data = CHtml::listData($data, 'kelurahan_id', 'kelurahan_nama');

        if (empty($data)) {
          $kelurahanOption = CHtml::tag('option', array('value' => ''), CHtml::encode('-Pilih-'), true);
        } else {
          $kelurahanOption = CHtml::tag('option', array('value' => ''), CHtml::encode('-Pilih-'), true);
          foreach ($data as $value => $name) {
            $kelurahanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }

        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Kelurahan <b>" . $_POST['KelurahanM']['kelurahan_nama'] . "</b> berhasil ditambahkan </div>",
            'kelurahan' => $kelurahanOption,
          ));
          exit;
        }
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formAddKelurahan', array('model' => $modelKel,), true)
      ));
      exit;
    }
  }

  public function actionAjaxDeleteDataSample()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pengambilansample_id = $_POST['id'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modKirimSample = BDKirimSampleLabT::model()->findByAttributes(
          array(
            'pengambilansample_id' => $pengambilansample_id
          )
        );
        $data['success'] = true;
        if (!empty($modKirimSample)) {
          BDPengambilanSampleT::model()->updateByPk($pengambilansample_id, array('kirimsamplelab_id' => null));
          $deleteKirimSample = BDKirimSampleLabT::model()->deleteAllByAttributes(
            array(
              'pengambilansample_id' => $pengambilansample_id
            )
          );

          $deletePengambilanSample = BDPengambilanSampleT::model()->deleteByPk($pengambilansample_id);
          if (!$deleteKirimSample) {
            $data['success'] = false;
          }
        } else {
          $deletePengambilanSample = BDPengambilanSampleT::model()->deleteByPk($pengambilansample_id);
        }

        if ($deletePengambilanSample && $data['success']) {
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
   * Untuk cek tagihan pasien pada saat batal periksa
   */
  public function actionCekTagihan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $status_tindakan = false;
      $status_obat = false;
      $status_batal = true;
      $pesan = '';
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null;

      $criteriaTindakan = new CDbCriteria();
      $criteriaTindakan->addCondition('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
      $criteriaTindakan->addCondition('tindakansudahbayar_id is not null');

      $modTindakanPelayanan = TindakanpelayananT::model()->find($criteriaTindakan);

      $criteriaObat = new CDbCriteria();
      $criteriaObat->addCondition('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
      $criteriaObat->addCondition('oasudahbayar_id is not null');
      $modObatalkesPasien = ObatalkespasienT::model()->find($criteriaObat);

      if ($modTindakanPelayanan) {
        $status_tindakan = true;
      }

      if ($modObatalkesPasien) {
        $status_obat = true;
      }

      if ($status_tindakan == true || $status_obat == true) {
        $status_batal = false;
        $pesan = "Pemeriksaan tidak bisa dibatalkan karena ada tindakan/obat yang sudah dibayarkan. Silakan hubungi Kasir!";
      } else {
        $status_batal = true;
      }

      $data['status_tindakan'] = $status_tindakan;
      $data['status_obat'] = $status_obat;
      $data['status_batal'] = $status_batal;
      $data['pesan'] = $pesan;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionCekLoginBatalPemeriksaan($task = 'BatalPenunjang')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $username = isset($_POST['nama_pemakai']) ? $_POST['nama_pemakai'] : null;
      $password = isset($_POST['kata_kunci']) ? $_POST['kata_kunci'] : null;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');

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
          $data['error'] = '';
          $cek = $this->checkAccess(array('loginpemakai_id' => $user->loginpemakai_id, 'action' => $task)); //dari MyAuthController
          if ($cek) {
            $data['status'] = 'success';
            $data['userid'] = $user->loginpemakai_id;
            $data['username'] = $user->nama_pemakai;
          } else {
            $data['status'] = 'Tidak memiliki akses untuk melakukan pembatalan!';
          }
        }
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /*
	 * Ubah Status Periksa Pasien Baru -- Yang Pake Button
	 */

  public function actionUbahStatusPeriksaPasien()
  {
    $pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null;
    $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;
    $model = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
    $modelPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modBatalPeriksa = new PasienbatalperiksaR;
    //		$modelPendaftaran->tglselesaiperiksa = date('Y-m-d H:i:s');
    if (isset($_POST['status'])) {
      if ($status == Params::STATUSPERIKSA_ANTRIAN) {
        if ($model->ruangan_id == $modelPendaftaran->ruangan_id) {
          $updatePendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
        }
        $update = PasienmasukpenunjangT::model()->updateByPk($pasienmasukpenunjang_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
      } else {
        if ($status == Params::STATUSPERIKSA_SEDANG_PERIKSA) {
          if ($model->ruangan_id == $modelPendaftaran->ruangan_id) {
            $updatePendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
          }
          $update = PasienmasukpenunjangT::model()->updateByPk($pasienmasukpenunjang_id, array('statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
        } else if ($status == Params::STATUSPERIKSA_SEDANG_DIRAWATINAP) {
          if ($model->ruangan_id == $modelPendaftaran->ruangan_id) {
            $updatePendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SUDAH_PULANG));
          }
          $update = PasienmasukpenunjangT::model()->updateByPk($pasienmasukpenunjang_id, array('statusperiksa' => Params::STATUSPERIKSA_SUDAH_PULANG));
        }
      }
      if ($update) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
          ));
          exit;
        }
      } else {

        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-error'>Data Pasien <b></b> gagal disimpan </div>",
          ));
          exit;
        }
      }
    }
  }

  /**
   * ubah status dokumen
   */
  public function actionStatusDokumenTerima()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $pengirimanrm_id = $_POST['pengirimanrm_id'];
      $statusdok = $_POST['status'];
      $update = false;
      $status = '';
      $div = '';
      $model = PendaftaranT::model()->findByPk($pendaftaran_id);
      if (!empty($pengirimanrm_id)) {
        $modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
        $modPenerimaanRm->tglterimadokrm = date('Y-m-d H:i:s');
        $modPenerimaanRm->petugaspenerima_id = Yii::app()->user->id;
        $modPenerimaanRm->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');
        if ($modPenerimaanRm->save()) {
          $model->statusdokrm = 'SUDAH DITERIMA';
          $model->save();
          $update = true;
        } else {
          $update = false;
        }
      }

      if ($update == true) {
        $status = 'proses_form';
        $div = "<div class='flash-success'>Data Dokumen Pasien <b></b> berhasil diterima </div>";
      } else {
        $status = 'proses_form';
        $div = "<div class='flash-error'>Data Dokumen Pasien <b></b> gagal diterima </div>";
      }

      echo CJSON::encode(array(
        'status' => $status,
        'div' => $div,
      ));
      exit;
    }
  }

  /**
   * Pengiriman Dokumen RM
   */
  public function actionStatusDokumenKirim($pengirimanrm_id, $pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $status = false;
    if (!empty($pengirimanrm_id)) {
      $modPengirimanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
    } else {
      $modPengirimanRm = new PengirimanrmT();
    }

    $modUbahStatus = new PengirimanrmT;

    if (isset($_POST['PengirimanrmT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modUbahStatus->attributes = $_POST['PengirimanrmT'];
        $modUbahStatus->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modUbahStatus->pasien_id = $modPendaftaran->pasien_id;
        $modUbahStatus->dokrekammedis_id = isset($modPengirimanRm) ? $modPengirimanRm->dokrekammedis_id : null;
        $modUbahStatus->nourut_keluar = MyGenerator::noUrutKeluarRM();
        $modUbahStatus->tglpengirimanrm = $format->formatDateTimeForDb($_POST['PengirimanrmT']['tglpengirimanrm']);
        $modUbahStatus->kelengkapandokumen = TRUE;
        $modUbahStatus->petugaspengirim_id = $_POST['PengirimanrmT']['petugaspengirim_id'];
        $modUbahStatus->create_time = date('Y-m-d H:i:s');
        $modUbahStatus->create_loginpemakai_id = Yii::app()->user->id;
        $modUbahStatus->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modUbahStatus->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');

        if ($modUbahStatus->save()) {
          $modPendaftaran->statusdokrm = 'SUDAH DIKIRIM';
          $modPendaftaran->save();

          $transaction->commit();
          $status = true;
          Yii::app()->user->setFlash('success', "Data pengiriman dokumen pasien berhasil disimpan !");
        } else {
          $status = false;
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data pengiriman dokumen pasien gagal disimpan');
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $status = false;
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($exc));
      }
    }

    $this->render('_formStatusDokumen', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPengirimanRm' => $modPengirimanRm,
      'modUbahStatus' => $modUbahStatus,
      'status' => $status
    ));
  }

  /**
   * penghapusan dokumen RM
   */

  /**
   * ubah status dokumen
   */
  public function actionHapusDokumenPengiriman()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $pengirimanrm_id = $_POST['pengirimanrm_id'];
      $statusdok = $_POST['status'];
      $delete = false;
      $status = '';
      $div = '';
      $model = PendaftaranT::model()->findByPk($pendaftaran_id);
      if (!empty($pengirimanrm_id)) {
        $model->pengirimanrm_id = null;
        $modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
        if ($model->save()) {
          $modPenerimaanRm->delete();
          $delete = true;
        } else {
          $delete = false;
        }
      }

      if ($delete == true) {
        $status = 'proses_form';
        $div = "<div class='flash-success'>Data Dokumen Pasien <b></b> berhasil dihapus </div>";
      } else {
        $status = 'proses_form';
        $div = "<div class='flash-error'>Data Dokumen Pasien <b></b> gagal dihapus </div>";
      }

      echo CJSON::encode(array(
        'status' => $status,
        'div' => $div,
      ));
      exit;
    }
  }

  /**
   * ambil status penerimaan dokumen
   */
  public function actionGetStatusPenerimaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $pengirimanrm_id = $_POST['pengirimanrm_id'];
      $ruanganpenerimaan_id = $_POST['ruanganpenerimaan_id'];
      $statusdok = $_POST['status'];
      $penerimaan = false;
      $div = '';
      $ruangan = '';
      $model = PendaftaranT::model()->findByPk($pendaftaran_id);
      if (!empty($pengirimanrm_id)) {
        $modPenerimaanRm = PengirimanrmT::model()->findByPk($pengirimanrm_id);
        if ($modPenerimaanRm->ruanganpenerimaan_id == $ruanganpenerimaan_id) {
          $penerimaan = true;
        }
      }

      if ($penerimaan == true) {
        $div = "<div class='flash-success'>Dokumen Sudah Diterima Oleh Ruangan  <b>" . $ruangan . "</b></div>";
      } else {
        $div = "<div class='flash-error'>Dokumen Belum Diterima Oleh Ruangan  <b>" . $ruangan . "</b></div>";
      }

      echo CJSON::encode(array(
        'div' => $div,
      ));
      exit;
    }
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionRincianTagihanPenunjang($pendaftaran_id, $instalasi_id, $pasienmasukpenunjang_id, $pasienadmisi_id = null)
  {
    $format = new MyFormatter();
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    // untuk load data pasien
    $criteria = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
    }
    if (!empty($pasienmasukpenunjang_id)) {
      $criteria->addCondition("pasienmasukpenunjang_id = " . $pasienmasukpenunjang_id);
    }
    if (!empty($pasienadmisi_id)) {
      $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
    }
    if (!empty($instalasi_id)) {
      $criteria->addCondition("instalasi_id = " . $instalasi_id);
    }
    $modInfo = BDPasienMasukPenunjangV::model()->find($criteria);

    // untuk load data tindakan
    $criteriaTindakan = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteriaTindakan->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    }
    if (!empty($pasienmasukpenunjang_id)) {
      $criteriaTindakan->addCondition("pasienmasukpenunjang_id = " . $pasienmasukpenunjang_id);
    }
    if (!empty($pasienadmisi_id)) {
      $criteriaTindakan->addCondition('pasienadmisi_id = ' . $pasienadmisi_id);
    }
    if (!empty($instalasi_id)) {
      $criteriaTindakan->addCondition("instalasi_id = " . $instalasi_id);
    }
    $criteriaTindakan->addCondition('pasienmasukpenunjang_id is not null');
    $criteriaTindakan->group = 'pendaftaran_id, pasien_id, instalasi_id, ruangan_id, kelaspelayanan_id, pasienmasukpenunjang_id, tgl_tindakan, instalasi_nama, ruangan_nama, kelaspelayanan_nama';
    $criteriaTindakan->select = $criteriaTindakan->group . ', sum(tarif_tindakan) as tarif_tindakan, sum(tarif_medis) as tarif_medis, sum(tarif_bhp) as tarif_bhp, sum(tarif_paramedis) as tarif_paramedis, sum(tarifcyto_tindakan) as tarifcyto_tindakan';
    $criteriaTindakan->order = 'instalasi_id, ruangan_id, tgl_tindakan';
    $modRincianTindakan = RinciantagihantindakanV::model()->findAll($criteriaTindakan);

    $this->render('printRincianTagihanPenunjang', array(
      'format'       => $format,
      'modInfo'       => $modInfo,
      'modRincianTindakan' => $modRincianTindakan,
    ));
  }
}
