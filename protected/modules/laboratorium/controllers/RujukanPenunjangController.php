<?php

class RujukanPenunjangController extends MyAuthController
{
  public $path_view_pj = "laboratorium.views.rujukanPenunjang.";
  public $instalasi_ruangan, $nama_pasien_panggilan, $cara_bayar_penjamin, $kasus_pelayanan;
  public function actionIndex()
  {
    // var_dump($this->createUrl('printStatusLab'));die;
    $this->pageTitle = Yii::app()->name . " - Pasien Rujukan";
    $format = new MyFormatter;
    $model = new LBPasienKirimKeUnitLainV();
    $model->tgl_awal = date('Y-m-d'); //, strtotime('-5 days')
    $model->tgl_akhir = date('Y-m-d');
    $model->tgl_rencana_awal = date('Y-m-d'); //, strtotime('-5 days')
    $model->tgl_rencana_akhir = date('Y-m-d');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($_GET['LBPasienKirimKeUnitLainV'])) {
      $model->attributes = $_GET['LBPasienKirimKeUnitLainV'];
      $model->isPilihTglRencana = $_GET['LBPasienKirimKeUnitLainV']['isPilihTglRencana'] ?? false;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['LBPasienKirimKeUnitLainV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LBPasienKirimKeUnitLainV']['tgl_akhir']);
      $model->prefix_pendaftaran = $_GET['LBPasienKirimKeUnitLainV']['prefix_pendaftaran'];
      $model->statusperiksa = isset($_GET['LBPasienKirimKeUnitLainV']['statusperiksa']) ? $_GET['LBPasienKirimKeUnitLainV']['statusperiksa'] : null;
      if(isset($_GET['LBPasienKirimKeUnitLainV']['tgl_rencana_awal'])) {
        $model->tgl_rencana_awal = MyFormatter::formatDateTimeForDb($_GET['LBPasienKirimKeUnitLainV']['tgl_rencana_awal']);
      }
      if(isset($_GET['LBPasienKirimKeUnitLainV']['tgl_rencana_akhir'])) {
        $model->tgl_rencana_akhir = MyFormatter::formatDateTimeForDb($_GET['LBPasienKirimKeUnitLainV']['tgl_rencana_akhir']);
      }

      if(Yii::app()->request->isAjaxRequest) {
        if(isset($_GET['ajax']) && $_GET['ajax'] == 'pasienpenunjangrujukan-m-grid') {
          $this->renderPartial('_table', ['model' => $model]);
          Yii::app()->end();
        }
      }
    }
    $this->render('index', array('model' => $model, 'format' => $format));
  }

  /**
   * Date		: 12 Juni 2015
   *
   */
  public function actionBatalRujuk()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $idKirimUnit = $_POST['idKirimUnit'];
      //$keterangan_batal = isset($_POST['keterangan_batal'])?$_POST['keterangan_batal']:null;

      $transaction = Yii::app()->db->beginTransaction();
      $status = 'ok';
      $status_bayar = 'ok';

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

          /*$model = new PasienbatalperiksaR();
						$model->pendaftaran_id = $kirim->pendaftaran_id;
						$model->pasien_id = $kirim->pasien_id;
						//$model->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
						$model->pasienkirimkeunitlain_id = $idKirimUnit;
						$model->tglbatal = date('Y-m-d');
						$model->keterangan_batal = $keterangan_batal;
						$model->create_time = date('Y-m-d H:i:s');
						$model->update_time = null;
						$model->create_loginpemakai_id = Yii::app()->user->id;
						$model->create_ruangan = Yii::app()->user->getState('ruangan_id');*/

          //if ($model->validate()) {
          //	$ok = $ok && $model->save();
          //} else $ok = false;


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
    }
  }

  protected function notifBatalRujuk($modKirimKeunitlain)
  {

    $modRuangan = RuanganM::model()->findByPk($modKirimKeunitlain->create_ruangan);
    $pasien_id = $modKirimKeunitlain->pasien_id;
    $modPasien = PasienM::model()->findByPk($pasien_id);
    $judul = 'Pasien Batal Rujuk Laboratorium';

    $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien
      . '<br/>Tgl. Rujuk : ' . MyFormatter::formatDateTimeForUser($modKirimKeunitlain->tgl_kirimpasien);

    //var_dump($judul." , ".$isi);

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $modRuangan->instalasi_id, 'ruangan_id' => $modRuangan->ruangan_id, 'modul_id' => $modRuangan->modul_id),
      // array('instalasi_id'=> Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=> Params::MODUL_ID_BILLINGKASIR),
    ));
  }


  /**
   * @param type $pendaftaran_id
   */
  public function actionPrintStatusLab($pendaftaran_id, $pasienkirimkeunitlain_id)
  {
   
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = $this->loadModel($pendaftaran_id);
    $modAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modPasien = LBPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modTindakans = array();
    $modPasienMasukPenunjangs = array();
    $daftartindakan = array();
    $criteria1 = new CdbCriteria();
    $criteria1->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    $criteria1->order = "pendaftaran_id DESC, pasienmasukpenunjang_id DESC";
    $criteria1->addCondition('ruangan_id = ' . Params::RUANGAN_ID_LAB_KLINIK);
    // $loadPasienMasukPenunjangs[0] = LBPasienmasukpenunjangT::model()->find($criteria1);
   
    $loadPasienMasukPenunjangs[0] = PasienkirimkeunitlaindetailV::model()->find($criteria1);
  
  
    if (isset($loadPasienMasukPenunjangs[0])) {
      $modPasienMasukPenunjangs[0] = $loadPasienMasukPenunjangs[0];
      if (!empty($modPasienMasukPenunjangs[0]->pasienkirimkeunitlain_id)) {
        // $modTindakans[0] = LBTindakanPelayananT::model()->findByAttributes(array('pendaftaran_id' => $modPasienMasukPenunjangs[0]->pendaftaran_id), "karcis_id is not null");
        $criteria_daf = new CdbCriteria();
        // $criteria_daf->addCondition("karcis_id IS NULL");
        $criteria_daf->addCondition("pasienkirimkeunitlain_id = " . $pasienkirimkeunitlain_id);
        $daftartindakan= LBPermintaanKePenunjangT::model()->findAll($criteria_daf);
      }
    }
    
    // var_dump($daftartindakan);die;
    
    // $criteria2 = new CdbCriteria();
    // $criteria2->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    // $criteria2->order = "pendaftaran_id DESC, pasienmasukpenunjang_id DESC";
    // $criteria2->addCondition('ruangan_id = ' . Params::RUANGAN_ID_LAB_ANATOMI);
    // $loadPasienMasukPenunjangs[1] = LBPasienmasukpenunjangT::model()->find($criteria2);
    // if (isset($loadPasienMasukPenunjangs[1])) {
    //   $modPasienMasukPenunjangs[1] = $loadPasienMasukPenunjangs[1];
    //   $modTindakans[1] = LBTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjangs[1]->pasienmasukpenunjang_id), "karcis_id is not null");
    //   $criteria_daf = new CdbCriteria();
    //   $criteria_daf->addCondition("karcis_id IS NULL");
    //   $criteria_daf->addCondition("pasienmasukpenunjang_id = " . $modPasienMasukPenunjangs[1]->pasienmasukpenunjang_id);
    //   $daftartindakan[1] = LBTindakanPelayananT::model()->findAll($criteria_daf);
    // }
    
    $judul_print = 'Kunjungan Laboratorium';
    $this->render($this->path_view_pj . 'printStatusLab', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPasienMasukPenunjangs' => $modPasienMasukPenunjangs,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modTindakans' => $modTindakans,
      'daftartindakan' => $daftartindakan,
    ));
  }


  public function actionPilihPendaftaran($pasienkirimkeunitlain_id, $pasien_id) {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modKirimKeUnitLain = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);

    if (isset($_POST['PasienkirimkeunitlainT'])) {
        $transaction = Yii::app()->db->beginTransaction();
        try {

            $modKirimKeUnitLain->attributes = $_POST['PasienkirimkeunitlainT'];
            $modKirimKeUnitLain->update_time = date('Y-m-d H:i:s');
            $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');

            if ($modKirimKeUnitLain->validate()) {
                $modKirimKeUnitLain->save();
                $transaction->commit();
                Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
                $this->redirect(array('pilihPendaftaran', 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id, 'pasien_id' => $pasien_id, 'frame' => 1, 'popup' => 'true', 'sukses' => 1));
            } else {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan!");
            }
        } catch (Exception $exc) {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        }
    }

    $this->render('_pilihPendaftaran', array(
        'modKirimKeUnitLain' => $modKirimKeUnitLain,
        'format' => $format,
    ));
}

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model =  LBPendaftaranT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function actionPilihTglPeriksa($pasienkirimkeunitlain_id, $pasien_id) {
      $this->layout = '//layouts/iframe';
      $format = new MyFormatter();
      $modKirimKeUnitLain = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
      $modKirimKeUnitLain->tglrencanapemeriksaan = !empty($modKirimKeUnitLain->tglrencanapemeriksaan) ? MyFormatter::formatDateTimeForUser($modKirimKeUnitLain->tglrencanapemeriksaan) : '';
      $modKirimKeUnitLain->tgl_kirimpasien = !empty($modKirimKeUnitLain->tgl_kirimpasien) ? MyFormatter::formatDateTimeForUser($modKirimKeUnitLain->tgl_kirimpasien) : '';

      $modPermintaan = PermintaankepenunjangT::model()->findAll("pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id");
      if(count($modPermintaan) > 0) {
        foreach ($modPermintaan as $i => $value) {
          $value->jenispemeriksaanlab_nama = $value->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama ?? '';
          $value->pemeriksaanlab_nama = $value->pemeriksaanlab->pemeriksaanlab_nama ?? '';
          $value->pemeriksaanlab_kode = $value->pemeriksaanlab->pemeriksaanlab_kode ?? '';
          if (!empty($value->tgl_rencanapemeriksaan)) {
            $value->tgl_rencanapemeriksaan = MyFormatter::formatDateTimeForDB($value->tgl_rencanapemeriksaan);
            $value->tgl_rencanapemeriksaan = date('Y-m-d', strtotime($value->tgl_rencanapemeriksaan));
            $value->tgl_rencanapemeriksaan = MyFormatter::formatDateTimeForUser($value->tgl_rencanapemeriksaan);
          }
        }
      }

      $crit = new CDbCriteria();
      $crit->select = "j.jenispemeriksaanlab_id, j.jenispemeriksaanlab_nama, t.tgl_rencanapemeriksaan";
      $crit->distinct = true;
      $crit->join = "JOIN pemeriksaanlab_m p ON p.pemeriksaanlab_id = t.pemeriksaanlab_id JOIN jenispemeriksaanlab_m j ON j.jenispemeriksaanlab_id = p.jenispemeriksaanlab_id";
      $crit->addCondition("pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id");

      $modPermintaanJenis = LBPermintaanKePenunjangT::model()->findAll($crit);
      // echo '<pre>'; var_dump($modPermintaanJenis); die;


      $inst = Yii::app()->user->getState('instalasi_id');      
      

      if (isset($_POST['PasienkirimkeunitlainT'])) {
          // echo '<pre>';var_dump($_POST);die;
          $transaction = Yii::app()->db->beginTransaction();
          $ok = true;
          try {

              $arr_permintaan = array();

              if (isset($_POST['PermintaankepenunjangT'])) {
                // var_dump($_POST['PermintaankepenunjangT']); die;
                foreach ($_POST['PermintaankepenunjangT'] as $permintaankepenunjang_id => $item) {

                  $tanggal = MyFormatter::formatDateTimeForDB($item['tgl_rencanapemeriksaan']);

                  if (empty($arr_permintaan[$tanggal])) {
                    $arr_permintaan[$tanggal] = array();
                  }
                  $arr_permintaan[$tanggal][] = $permintaankepenunjang_id;
                }


                $cnt = 0;
                foreach ($arr_permintaan as $tgl_rencanapemeriksaan => $item) {
                  if ($cnt == 0) {
                    $modKirim = $modKirimKeUnitLain;
                  } else {
                    $modKirim = clone $modKirimKeUnitLain;
                    $modKirim->isNewRecord = true;
                    $modKirim->pasienkirimkeunitlain_id = null;
                  }

                  $modKirim->attributes = $_POST['PasienkirimkeunitlainT'];
                  $modKirim->is_elektif = isset($_POST['PasienkirimkeunitlainT']['is_elektif']) ? $_POST['PasienkirimkeunitlainT']['is_elektif'] : null;
                  $modKirim->tglrencanapemeriksaan = $tgl_rencanapemeriksaan;
                  $modKirim->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($_POST['PasienkirimkeunitlainT']['tgl_kirimpasien']);
                  

                  $modKirim->update_time = date('Y-m-d H:i:s');
                  $modKirim->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');

                  if ($modKirim->isNewRecord) {
                    $modKirim->create_time = $modKirim->update_time;
                    $modKirim->create_loginpemakai_id = $modKirim->update_loginpemakai_id;
                  }

                  if ($modKirim->validate()) {
                    $ok = $ok && $modKirim->save();
                  } else {
                    $ok = false;
                  }


                  foreach ($item as $permintaankepenunjang_id) {
                    $permintaan = PermintaankepenunjangT::model()->findByPk($permintaankepenunjang_id);
                    $permintaan->pasienkirimkeunitlain_id = $modKirim->pasienkirimkeunitlain_id;
                    $permintaan->tgl_rencanapemeriksaan = $modKirim->tglrencanapemeriksaan;
                    $ok = $ok && $permintaan->save(false, array('pasienkirimkeunitlain_id', 'tgl_rencanapemeriksaan'));

                    // var_dump($permintaan->attributes);
                  }

                  // var_dump($modKirim->attributes);
                  

                  $cnt++;
                }


                // var_dump($ok, $_POST, $arr_permintaan); die;

                /*
                foreach ($modPermintaan as $item) {
                  if (!empty($_POST['PermintaankepenunjangT'][$item->permintaankepenunjang_id])) {
                    $item->tgl_rencanapemeriksaan = MyFormatter::formatDateTimeForDB($_POST['PermintaankepenunjangT'][$item->permintaankepenunjang_id]['tgl_rencanapemeriksaan']);
                    $item->save(false, array('tgl_rencanapemeriksaan'));
                    var_dump($item->attributes);
                  }
                }
                */
              } else if(isset($_POST['LBPermintaanKePenunjangT'])) {

                $modKirim = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
                $modKirim->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($_POST['PasienkirimkeunitlainT']['tgl_kirimpasien']);

                $modKirim->update_time = date('Y-m-d H:i:s');
                $modKirim->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');

                $ok &= $modKirim->save();

                foreach ($_POST['LBPermintaanKePenunjangT'] as $i => $pen) {

                  // echo '<pre>'; var_dump($pen); die;

                  $cri = new CDbCriteria();
                  $cri->select = "t.pasienkirimkeunitlain_id, j.jenispemeriksaanlab_id, t.tgl_rencanapemeriksaan, t.pemeriksaanlab_id";
                  $cri->distinct = true;
                  $cri->join = "JOIN pemeriksaanlab_m p on p.pemeriksaanlab_id = t.pemeriksaanlab_id JOIN jenispemeriksaanlab_m j ON j.jenispemeriksaanlab_id = p.jenispemeriksaanlab_id";
                  $cri->addCondition("t.pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id AND j.jenispemeriksaanlab_id = " . $pen['jenispemeriksaanlab_id']);

                  $permintaanke = LBPermintaanKePenunjangT::model()->findAll($cri);

                  $jns = [];
                  foreach($permintaanke as $pk) {
                    array_push($jns, $pk->jenispemeriksaanlab_id);
                  }
 
                  foreach ($permintaanke as $permintaankepenunjang_id => $item2) {

                    $perm = LBPermintaanKePenunjangT::model()->find("pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id and pemeriksaanlab_id = $item2->pemeriksaanlab_id");
                    $tanggal = MyFormatter::formatDateTimeForDB($pen['tgl_rencanapemeriksaan']);
                    $perm->pasienkirimkeunitlain_id = $modKirim->pasienkirimkeunitlain_id;
                    $perm->tgl_rencanapemeriksaan = $tanggal;
                    $perm->tglpermintaankepenunjang = MyFormatter::formatDateTimeForDb($perm->tglpermintaankepenunjang);
                    $ok &= $perm->save();

                    $modKirim->tglrencanapemeriksaan = $perm->tgl_rencanapemeriksaan;
                    $ok &= $modKirim->save();

                  }

                }

              }


              // echo '<pre>'; var_dump($modKirimKeUnitLain->attributes, $_POST); die;

              if ($ok) {
                  $transaction->commit();
                  Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
                  $this->redirect(array('pilihTglPeriksa', 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id, 'pasien_id' => $pasien_id, 'frame' => 1, 'popup' => 'true', 'sukses' => 1));
              } else {
                  $transaction->rollback();
                  Yii::app()->user->setFlash('error', "Data gagal disimpan!");
              }
          } catch (Exception $exc) {
              echo '<pre>';  var_dump($exc); die;

              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
          }
      }

      if($inst !== 17) {
        $this->render('_pilihTglPeriksa', array(
          'modKirimKeUnitLain' => $modKirimKeUnitLain,
          'modPermintaan' => $modPermintaan,
          'format' => $format,
      ));
      } else {
        $this->render('_pilihTglPeriksaMK', array(
          'modKirimKeUnitLain' => $modKirimKeUnitLain,
          'modPermintaanJenis' => $modPermintaanJenis,
          'format' => $format,
      ));
      }

     
  }

}
