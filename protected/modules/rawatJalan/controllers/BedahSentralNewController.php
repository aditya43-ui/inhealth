<?php
//Yii::import('sistemAdministrator.controllers.NotifikasiRController'); //RND-6398
class BedahSentralNewController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  protected $statusSaveKirimkeUnitLain = false;
  protected $statusSavePermintaanPenunjang = false;
  protected $pelaksanaoperasisimpan = true;
  protected $rencanaoperasitersimpan = true;
  protected $path_view = 'rawatJalan.views.bedahSentralNew.';

  public function actionIndex($pendaftaran_id, $idPasienKirimKeUnitLain = null)
  {

    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modKegiatanOperasi = RJKegiatanOperasiM::model()->findAllByAttributes(array('kegiatanoperasi_aktif' => true), array('order' => 'kegiatanoperasi_nama'));
    $modOperasi = RJOperasiM::model()->findAllByAttributes(array('operasi_aktif' => true), array('order' => 'operasi_nama'));
    $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
    $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
    if(Yii::app()->user->getState('kelompokpegawai_id') === Params::KELOMPOKPEGAWAI_ID_DOKTER_TETAP) {
      $modKirimKeUnitLain->pegawai_id = Yii::app()->user->getState('pegawai_id');
    } else {
        $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
        if(isset($_GET['pasienadmisi_id'])) {
            $modKirimKeUnitLain->pegawai_id = $modPendaftaran->admisi->pegawai_id;
        }
    }
    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id);
    $fisik = new CDbCriteria();
    $fisik->select = "tekanandarah, detaknadi, suhutubuh ,pernapasan";
    $fisik->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    $modFisik = PemeriksaanfisikT::model()->find($fisik);

    $modRencanaOperasi = new BSRencanaOperasiT();
    $modRencanaOperasi->norencanaoperasi = MyGenerator::noRencanaOperasi();
    $modRencanaOperasi->statusoperasi = Params::DEFAULT_STATUS_OPERASI;
    $modRencanaOperasi->tglrencanaoperasi = date('Y-m-d h:i:s');
    $modRencanaOperasi->qty_tindakan = 1;
    
    $dataFisik ="";
    $insHemo = RuanganhemodialisaV::arrIns();
    if (in_array(Yii::app()->user->getState('instalasi_id'), $insHemo)){
        
        $awalMedik = AsesmenAwalMedisT::model()->findByAttributes([
           'pendaftaran_id'=>$modPendaftaran->pendaftaran_id 
        ],['order'=>'create_time DESC']);
        
        if (!empty($awalMedik)){
            $dataFisik .= "Tensi : ".$awalMedik->tekanandarah_sistolok."/".$awalMedik->tekanandarah_diastolik."\n ";
            $dataFisik .= "Nadi : ".$awalMedik->nadi."\n";
            $dataFisik .= "Suhu : ".$awalMedik->suhu."\n";
            $dataFisik .= "Pernapasan : ".$awalMedik->pernafasan."\n";
        }
    }else{                
        if (!empty($modFisik)) {
            $dataFisik .= "Tensi : ".$modFisik->tekanandarah."\n ";
            $dataFisik .= "Nadi : ".$modFisik->detaknadi."\n";
            $dataFisik .= "Suhu : ".$modFisik->suhutubuh."\n";
            $dataFisik .= "Pernapasan : ".$modFisik->pernapasan."\n";
        }
    }
    
    $modKirimKeUnitLain->vitalsignterakhir = $dataFisik; 

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

    if (isset($idPasienKirimKeUnitLain)) {
      $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($idPasienKirimKeUnitLain);
      $modPasien = $modKirimKeUnitLain->pasien;
    }

    $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id')) ? null : KonsulpoliT::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
    ), array(
      'order' => 'tglkonsulpoli desc',
    ));

    if (!empty($konsul)) {
      $modKirimKeUnitLain->pegawai_id = $konsul->pegawai_id;
    }

    if (isset($_POST['RJPasienKirimKeUnitLainT'])) {
      
      $transaction = Yii::app()->db->beginTransaction();
      try {

        $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modPendaftaran);
        if (isset($_POST['permintaanPenunjang'])) {
          $this->savePermintaanPenunjang($_POST['permintaanPenunjang'], $modKirimKeUnitLain);

          if (!$modKirimKeUnitLain->is_elektif){
           $modKirimAnestesi = $this->savePasienKirimKeUnitLainAnestesi($modPendaftaran, $modKirimKeUnitLain->pasienkirimkeunitlain_id);

            $this->savePermintaanPenunjangAnestesi($modKirimAnestesi);
          }

          
          PendaftaranT::model()->updateByPk(
            $pendaftaran_id,
            array(
              'pembayaranpelayanan_id' => null
            )
          );
        } else {
          $this->statusSavePermintaanPenunjang = true;
        }

        if (isset($_POST['BSRencanaOperasiT'])) {

          $modRencana = new BSRencanaOperasiT;
          $modRencana->attributes = $_POST['BSRencanaOperasiT'];
          $modRencana->pendaftaran_id = $pendaftaran_id;
          $modRencana->pasien_id = $modPendaftaran->pasien_id;
          $modRencana->tglrencanaoperasi = date('Y-m-d H:i:s');
          $modRencana->norencanaoperasi = MyGenerator::noRencanaOperasi();

          $modRencana->paramedis_id = $_POST['BSRencanaOperasiT']['paramedis_id'];
          $modRencana->ppds_id = $_POST['BSRencanaOperasiT']['ppds_id'];
          $modRencana->dokteranastesi_id = $_POST['BSRencanaOperasiT']['dokteranastesi_id'];
          $modRencana->dokterresusitasi_id = $_POST['BSRencanaOperasiT']['dokterresusitasi_id'];

          $modRencana->create_time = date('Y-m-d H:i:s');
          $modRencana->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
          $modRencana->create_ruangan = Yii::app()->user->getState('ruangan_id');

          $modRencana->dokterresusitasi_id = !empty($modRencana->dokterresusitasi_id) ? $modRencana->dokterresusitasi_id : null;
          $modRencana->dokteranastesi_id = !empty($modRencana->dokteranastesi_id) ? $modRencana->dokteranastesi_id : null;
          $modRencana->paramedis_id = !empty($modRencana->paramedis_id) ? $modRencana->paramedis_id : null;
          $modRencana->suster_id = !empty($modRencana->suster_id) ? $modRencana->suster_id : null;
          $modRencana->bidan_id = !empty($modRencana->bidan_id) ? $modRencana->bidan_id : null;
          $modRencana->perawatsirkuler_id = !empty($modRencana->perawatsirkuler_id) ? $modRencana->perawatsirkuler_id : null;
          if(isset($_POST['ceklis_ppds']) && $_POST['ceklis_ppds'] == 1) {
            if(isset($_POST['BSRencanaOperasiT']['dokterpelaksana2_id'])) {
              $modRencana->dokterpelaksana2_id = null;
              $modRencana->ppdspelaksana2_id = $_POST['BSRencanaOperasiT']['dokterpelaksana2_id'];
            }
          }
          // $modRencana->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;

          // $this->rencanaoperasitersimpan = $modRencana->save();

          // echo '<pre>'; var_dump($_POST['BSRencanaOperasiT'], $modRencana->attributes, $modRencana->save()); die;

          // var_dump($modRencana->attributes, $_POST); die;
          if($modRencana->save()) {

            if (isset($_POST['BSPelaksanaoperasiT'])) {

              foreach ($_POST['BSPelaksanaoperasiT'] as $iiii => $val) {
                  if (empty($val['pelaksanaoperasi_id'])) {
                      $modPelaksanaOp = new BSPelaksanaoperasiT();
                      $modPelaksanaOp->attributes = $_POST['BSPelaksanaoperasiT'][$iiii];
                      $modPelaksanaOp->rencanaoperasi_id = $modRencana->rencanaoperasi_id;
                      $modPelaksanaOp->create_time = date('Y-m-d H:i:s');
                      $modPelaksanaOp->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                      $modPelaksanaOp->create_ruangan = Yii::app()->user->getState('create_ruangan');

                      $this->pelaksanaoperasisimpan = $this->pelaksanaoperasisimpan && $modPelaksanaOp->save();
                  } else {
                      $modPelaksanaOp = BSPelaksanaoperasiT::model()->findByPk($val['pelaksanaoperasi_id']);
                      $modPelaksanaOp->attributes = $_POST['BSPelaksanaoperasiT'][$iiii];
                      $modPelaksanaOp->update_time = date('Y-m-d H:i:s');
                      $modPelaksanaOp->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

                      $this->pelaksanaoperasisimpan = $this->pelaksanaoperasisimpan && $modPelaksanaOp->save();
                  }

                }
            }
          }

        }



        $judul = 'Pasien ' . Yii::app()->user->getState('instalasi_nama') . ' Rujuk ke Bedah Sentral';

        $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;
        $mr = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);

        // var_dump($mr->attributes); die;
        $link = $this->createUrl('/bedahSentral/RujukanPenunjang/Index', array(
          'PasienkirimkeunitlainV[tgl_awal]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
          'PasienkirimkeunitlainV[tgl_akhir]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
          'PasienkirimkeunitlainV[no_pendaftaran]' => !empty($modKirimKeUnitLain->pendaftaran)?$modKirimKeUnitLain->pendaftaran->no_pendaftaran:null,
          'PasienkirimkeunitlainV[no_rekam_medik]' => $modPasien->no_rekam_medik,
          'PasienkirimkeunitlainV[nama_pasien]' => $modPasien->nama_pasien
        ));

        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
          array('instalasi_id' => $mr->instalasi_id, 'ruangan_id' => $mr->ruangan_id, 'modul_id' => $mr->modul_id, 'link_proses' => $link),
          // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
          // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
        ));



        // echo '<pre>';
        // var_dump($this->statusSaveKirimkeUnitLain, $this->statusSavePermintaanPenunjang, $this->pelaksanaoperasisimpan, $this->rencanaoperasitersimpan); die;

        if ($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang && $this->pelaksanaoperasisimpan &&  $this->rencanaoperasitersimpan) {
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

            if (empty($modPendaftaran->waktumulaiperiksa)){
              PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id,array('waktumulaiperiksa'=> date('Y-m-d H:i:s'))); 
            }

            
            $ins_hemo = RuanganhemodialisaV::arrIns();
            if (in_array($modPendaftaran->instalasi_id, $ins_hemo)) {
                $cri = new CDbCriteria;
                $cri->join = " JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id ";
                $cri->addInCondition("r.instalasi_id", $ins_hemo);
                $cri->addCondition(" pendaftaran_id = ".$modPendaftaran->pendaftaran_id);
                $modKonsulPoli = KonsulpoliT::model()->find($cri);
                if (!empty($modKonsulPoli)) {
                    $modKonsulPoli->update_time = date("Y-m-d h:i:s");
                    $modKonsulPoli->statusperiksa = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
                    $modKonsulPoli->save(); 
                } else {
                    $modPendaftaran->update_time = date("Y-m-d h:i:s");
                    $modPendaftaran->status_hd = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
                    $modPendaftaran->save(); 
                }
            }
            
          // SMS GATEWAY
          $modPegawai = $modPendaftaran->pegawai;
          $sms = new Sms();
          $smspasien = 1;
          foreach ($modSmsgateway as $i => $smsgateway) {
            if (isset($_POST['tujuansms']) && in_array($smsgateway->tujuansms, $_POST['tujuansms'])) {
              $isiPesan = $smsgateway->templatesms;

              $attributes = $modPasien->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modPendaftaran->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modPegawai->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modKirimKeUnitLain->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modKirimKeUnitLain->tgl_kirimpasien), $isiPesan);

              if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                if (!empty($modPasien->no_mobile_pasien)) {
                  $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                } else {
                  $smspasien = 0;
                }
              }
            }
          }
          // END SMS GATEWAY

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'idPasienKirimKeUnitLain' => $modKirimKeUnitLain->pasienkirimkeunitlain_id, 'smspasien' => $smspasien,'sukses'=>1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data tidak valid ");
        }
      } catch (Exception $exc) { 
          
         echo '<pre>';          var_dump($exc); die();
          
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAll("
        (pendaftaran_id = ".$pendaftaran_id." OR (pendaftaran_id IS NULL AND pasien_id = ".$modPendaftaran->pasien_id.") ) AND instalasi_id = ".Params::INSTALASI_ID_IBS." ORDER BY  pasienmasukpenunjang_id IS NULL");
    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modKegiatanOperasi' => $modKegiatanOperasi,
      'modOperasi' => $modOperasi,
      'modKirimKeUnitLain' => $modKirimKeUnitLain,
      'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
      'modJenisTarif' => $modJenisTarif,
      'modRencanaOperasi' => $modRencanaOperasi,
    ));
  }


  public function actionUpdate($pendaftaran_id, $idPasienKirimKeUnitLain = null)
  {
    
    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modKegiatanOperasi = RJKegiatanOperasiM::model()->findAllByAttributes(array('kegiatanoperasi_aktif' => true), array('order' => 'kegiatanoperasi_nama'));
    $modOperasi = RJOperasiM::model()->findAllByAttributes(array('operasi_aktif' => true), array('order' => 'operasi_nama'));
    $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
    $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
    $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id);
    $fisik = new CDbCriteria();
    $fisik->select = "tekanandarah, detaknadi, suhutubuh ,pernapasan";
    $fisik->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    $modFisik = PemeriksaanfisikT::model()->find($fisik);
    
    $dataFisik ="";
    $insHemo = RuanganhemodialisaV::arrIns();
    if (in_array(Yii::app()->user->getState('instalasi_id'), $insHemo)){
        
        $awalMedik = AsesmenAwalMedisT::model()->findByAttributes([
           'pendaftaran_id'=>$modPendaftaran->pendaftaran_id 
        ],['order'=>'create_time DESC']);
        
        if (!empty($awalMedik)){
            $dataFisik .= "Tensi : ".$awalMedik->tekanandarah_sistolok."/".$awalMedik->tekanandarah_diastolik."\n ";
            $dataFisik .= "Nadi : ".$awalMedik->nadi."\n";
            $dataFisik .= "Suhu : ".$awalMedik->suhu."\n";
            $dataFisik .= "Pernapasan : ".$awalMedik->pernafasan."\n";
        }
    }else{                
        if (!empty($modFisik)) {
            $dataFisik .= "Tensi : ".$modFisik->tekanandarah."\n ";
            $dataFisik .= "Nadi : ".$modFisik->detaknadi."\n";
            $dataFisik .= "Suhu : ".$modFisik->suhutubuh."\n";
            $dataFisik .= "Pernapasan : ".$modFisik->pernapasan."\n";
        }
    }
    
    $modKirimKeUnitLain->vitalsignterakhir = $dataFisik; 

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

    if (isset($idPasienKirimKeUnitLain)) {
      $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($idPasienKirimKeUnitLain);
      $modPasien = $modKirimKeUnitLain->pasien;
    }

    $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id')) ? null : KonsulpoliT::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
    ), array(
      'order' => 'tglkonsulpoli desc',
    ));

    if (!empty($konsul) && $modKirimKeUnitLain->isNewRecord) {
      $modKirimKeUnitLain->pegawai_id = $konsul->pegawai_id;
    }

    
    $modRencanaOperasi = BSRencanaOperasiT::model()->findByAttributes(array(
      'pendaftaran_id'=>$pendaftaran_id
    ));

    if(empty($modRencanaOperasi)){
      $modRencanaOperasi = new BSRencanaOperasiT();
    }
    
    if (isset($_POST['RJPasienKirimKeUnitLainT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modPendaftaran, $modKirimKeUnitLain);
        if (isset($_POST['permintaanPenunjang'])) {

          RJPermintaanPenunjangT::model()->deleteAllByAttributes(array(
            'pasienkirimkeunitlain_id'=>$modKirimKeUnitLain->pasienkirimkeunitlain_id,
          ));

          $this->savePermintaanPenunjang($_POST['permintaanPenunjang'], $modKirimKeUnitLain);

          if (!$modKirimKeUnitLain->is_elektif){
            $modKirimAnestesi = $this->savePasienKirimKeUnitLainAnestesi($modPendaftaran, $modKirimKeUnitLain->pasienkirimkeunitlain_id);

            RJPermintaanPenunjangT::model()->deleteAllByAttributes(array(
              'pasienkirimkeunitlain_id'=>$modKirimAnestesi->pasienkirimkeunitlain_id,
            ));

            $this->savePermintaanPenunjangAnestesi($modKirimAnestesi);

            
          }
          
          PendaftaranT::model()->updateByPk(
            $pendaftaran_id,
            array(
              'pembayaranpelayanan_id' => null
            )
          );
        } else {
          $this->statusSavePermintaanPenunjang = true;
        }


        if (isset($_POST['BSRencanaOperasiT'])) {

          $modRencana = $modRencanaOperasi;
          $modRencana->attributes = $_POST['BSRencanaOperasiT'];
          $modRencana->pendaftaran_id = $pendaftaran_id;
          $modRencana->pasien_id = $modPendaftaran->pasien_id;
          $modRencana->tglrencanaoperasi = date('Y-m-d H:i:s');
          $modRencana->norencanaoperasi = MyGenerator::noRencanaOperasi();

          $modRencana->paramedis_id = $_POST['BSRencanaOperasiT']['paramedis_id'];
          $modRencana->ppds_id = $_POST['BSRencanaOperasiT']['ppds_id'];
          $modRencana->dokteranastesi_id = $_POST['BSRencanaOperasiT']['dokteranastesi_id'];
          $modRencana->dokterresusitasi_id = $_POST['BSRencanaOperasiT']['dokterresusitasi_id'];

          $modRencana->create_time = date('Y-m-d H:i:s');
          $modRencana->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
          $modRencana->create_ruangan = Yii::app()->user->getState('ruangan_id');

          // $this->rencanaoperasitersimpan = $modRencana->save();

          // echo '<pre>'; var_dump($_POST, $modRencana->attributes); die;

          // var_dump($modRencana->attributes, $_POST); die;
          if($modRencana->save()) {

            BSPelaksanaoperasiT::model()->deleteAllByAttributes(array(
              'rencanaoperasi_id'=>$modRencana->rencanaoperasi_id
            ));

            if (isset($_POST['BSPelaksanaoperasiT'])) {
              foreach ($_POST['BSPelaksanaoperasiT'] as $iiii => $val) {
                  if (empty($val['pelaksanaoperasi_id'])) {
                      $modPelaksanaOp = new BSPelaksanaoperasiT();
                      $modPelaksanaOp->attributes = $_POST['BSPelaksanaoperasiT'][$iiii];
                      $modPelaksanaOp->rencanaoperasi_id = $modRencana->rencanaoperasi_id;
                      $modPelaksanaOp->create_time = date('Y-m-d H:i:s');
                      $modPelaksanaOp->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                      $modPelaksanaOp->create_ruangan = Yii::app()->user->getState('create_ruangan');

                      $this->pelaksanaoperasisimpan = $this->pelaksanaoperasisimpan && $modPelaksanaOp->save();
                  } else {
                      $modPelaksanaOp = BSPelaksanaoperasiT::model()->findByPk($val['pelaksanaoperasi_id']);
                      $modPelaksanaOp->attributes = $_POST['BSPelaksanaoperasiT'][$iiii];
                      $modPelaksanaOp->update_time = date('Y-m-d H:i:s');
                      $modPelaksanaOp->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

                      $this->pelaksanaoperasisimpan = $this->pelaksanaoperasisimpan && $modPelaksanaOp->save();
                  }

                }
            }
          }

        }



        $judul = 'Pasien ' . Yii::app()->user->getState('instalasi_nama') . ' Rujuk ke Bedah Sentral';

        $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;
        $mr = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);

        // var_dump($mr->attributes); die;
        $link = $this->createUrl('/bedahSentral/RujukanPenunjang/Index', array(
          'PasienkirimkeunitlainV[tgl_awal]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
          'PasienkirimkeunitlainV[tgl_akhir]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
          'PasienkirimkeunitlainV[no_pendaftaran]' => !empty($modKirimKeUnitLain->pendaftaran)?$modKirimKeUnitLain->pendaftaran->no_pendaftaran:null,
          'PasienkirimkeunitlainV[no_rekam_medik]' => $modPasien->no_rekam_medik,
          'PasienkirimkeunitlainV[nama_pasien]' => $modPasien->nama_pasien
        ));

        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
          array('instalasi_id' => $mr->instalasi_id, 'ruangan_id' => $mr->ruangan_id, 'modul_id' => $mr->modul_id, 'link_proses' => $link),
          // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
          // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
        ));
        if ($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang) {
            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

            if (empty($modPendaftaran->waktumulaiperiksa)){
              PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id,array('waktumulaiperiksa'=> date('Y-m-d H:i:s'))); 
            }

            
            $ins_hemo = RuanganhemodialisaV::arrIns();
            if (in_array($modPendaftaran->instalasi_id, $ins_hemo)) {
                $cri = new CDbCriteria;
                $cri->join = " JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id ";
                $cri->addInCondition("r.instalasi_id", $ins_hemo);
                $cri->addCondition(" pendaftaran_id = ".$modPendaftaran->pendaftaran_id);
                $modKonsulPoli = KonsulpoliT::model()->find($cri);
                if (!empty($modKonsulPoli)) {
                    $modKonsulPoli->update_time = date("Y-m-d h:i:s");
                    $modKonsulPoli->statusperiksa = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
                    $modKonsulPoli->save(); 
                } else {
                    $modPendaftaran->update_time = date("Y-m-d h:i:s");
                    $modPendaftaran->status_hd = Params::STATUS_PEMERIKSAAN_HEMODIALISA_SEDANG_TINDAKAN;
                    $modPendaftaran->save(); 
                }
            }
            
          // SMS GATEWAY
          $modPegawai = $modPendaftaran->pegawai;
          $sms = new Sms();
          $smspasien = 1;
          foreach ($modSmsgateway as $i => $smsgateway) {
            if (isset($_POST['tujuansms']) && in_array($smsgateway->tujuansms, $_POST['tujuansms'])) {
              $isiPesan = $smsgateway->templatesms;

              $attributes = $modPasien->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modPendaftaran->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modPegawai->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modKirimKeUnitLain->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modKirimKeUnitLain->tgl_kirimpasien), $isiPesan);

              if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                if (!empty($modPasien->no_mobile_pasien)) {
                  $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                } else {
                  $smspasien = 0;
                }
              }
            }
          }
          // END SMS GATEWAY

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'idPasienKirimKeUnitLain' => $modKirimKeUnitLain->pasienkirimkeunitlain_id, 'smspasien' => $smspasien,'sukses'=>1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data tidak valid ");
        }
      } catch (Exception $exc) { 
          
//          echo '<pre>';          var_dump($exc); die();
          var_dump($exc->getMessage()); die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAll("
        (pendaftaran_id = ".$pendaftaran_id." OR (pendaftaran_id IS NULL AND pasien_id = ".$modPendaftaran->pasien_id.") ) AND instalasi_id = ".Params::INSTALASI_ID_IBS." ORDER BY  pasienmasukpenunjang_id IS NULL");
    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modKegiatanOperasi' => $modKegiatanOperasi,
      'modOperasi' => $modOperasi,
      'modKirimKeUnitLain' => $modKirimKeUnitLain,
      'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
      'modJenisTarif' => $modJenisTarif,
      'modRencanaOperasi' => $modRencanaOperasi,
    ));
  }

  protected function savePasienKirimKeUnitLain($modPendaftaran, $modKirimKeUnitLain = null)
  {

    if (empty($modKirimKeUnitLain)) {
      $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
    }
    
    $format = new MyFormatter();
    $modKirimKeUnitLain->attributes = $_POST['RJPasienKirimKeUnitLainT'];
    $modKirimKeUnitLain->pasien_id = $modPendaftaran->pasien_id;    
    $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
    $modKirimKeUnitLain->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modKirimKeUnitLain->carabayar_id = $modPendaftaran->carabayar_id;
    $modKirimKeUnitLain->penjamin_id = $modPendaftaran->penjamin_id;
    $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_IBS;
    // $modKirimKeUnitLain->ruangan_id = Params::RUANGAN_ID_BEDAH;
    $modKirimKeUnitLain->tgl_kirimpasien = $format->formatDateTimeForDb($_POST['RJPasienKirimKeUnitLainT']['tgl_kirimpasien']);
    $modKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->update_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
    $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);

    $modKirimKeUnitLain->tglrencanapemeriksaan = $format->formatDateTimeForDb($_POST['RJPasienKirimKeUnitLainT']['tglrencanaoperasi']);
    $modKirimKeUnitLain->indikasioperasi = $_POST['RJPasienKirimKeUnitLainT']['indikasioperasi'];
    $modKirimKeUnitLain->sifatoperasi = $_POST['RJPasienKirimKeUnitLainT']['sifatoperasi'];
    $modKirimKeUnitLain->vitalsignterakhir = $_POST['RJPasienKirimKeUnitLainT']['vitalsignterakhir'];
    $modKirimKeUnitLain->petugasruangan_id = $_POST['RJPasienKirimKeUnitLainT']['petugasruangan_id'];
    $modKirimKeUnitLain->petugasok_id = $_POST['RJPasienKirimKeUnitLainT']['petugasok_id'];
   
    $modKirimKeUnitLain->is_elektif = isset($_POST['RJPasienKirimKeUnitLainT']['is_elektif']) ? $_POST['RJPasienKirimKeUnitLainT']['is_elektif'] : false;
    $modKirimKeUnitLain->estimasioperasi = !empty($_POST['RJPasienKirimKeUnitLainT']['estimasioperasi']) ? MyFormatter::formatNumberForDb($_POST['RJPasienKirimKeUnitLainT']['estimasioperasi']) : '';

    if (!$modKirimKeUnitLain->is_elektif){
        $modKirimKeUnitLain->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    } else {
      $modKirimKeUnitLain->pendaftaran_id = null;
    }

    // echo '<pre>'; var_dump($modKirimKeUnitLain->save()); die;

        // echo '<pre>'; var_dump($modKirimKeUnitLain->attributes, $_POST['RJPasienKirimKeUnitLainT']); die;


    if ($modKirimKeUnitLain->validate()) {
      $modKirimKeUnitLain->save();

      $p = PendaftaranT::model()->findByPk($modPendaftaran->pendaftaran_id);
      $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);

      /* ================================================ */
      /* Proses update status periksa KonsulPoli EHS-179  */
      /* ================================================ */
      $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
      $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => $ruangan_id));
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
      $this->statusSaveKirimkeUnitLain = true;
    }

    // var_dump($modKirimKeUnitLain->attributes, $_POST); die;

    return $modKirimKeUnitLain;
  }

  protected function savePermintaanPenunjang($permintaan, $modKirimKeUnitLain)
  {
    foreach ($permintaan['inputoperasi'] as $i => $value) {
      $modPermintaan = new RJPermintaanPenunjangT;
      $modPermintaan->daftartindakan_id = '';
      $modPermintaan->pemeriksaanlab_id = '';
      $modPermintaan->operasi_id = $permintaan['inputoperasi'][$i];
      $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
      $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PB');
      $modPermintaan->qtypermintaan = $permintaan['inputqty'][$i];
      $modPermintaan->detailoperasi_id = $permintaan['detailoperasi'][$i];
      $modPermintaan->tglpermintaankepenunjang = $modKirimKeUnitLain->tgl_kirimpasien; //date('Y-m-d H:i:s');
      if ($modPermintaan->validate()) {
        $modPermintaan->save();
        $this->statusSavePermintaanPenunjang = true;
      }
    }
  }

  /**
   * untuk ajax action load tindakan operasi
   */
  public function actionLoadFormPermintaanOperasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $operasi_id = isset($_POST['operasi_id']) ? $_POST['operasi_id'] : null;
      $kelaspelayanan_id = isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id)->jenistarif_id;
      $modOperasi = OperasiM::model()->with('kegiatanoperasi')->findByPk($operasi_id);
      $criteria = new CDbCriteria();
      $criteria->addCondition('daftartindakan_id =' . $modOperasi->daftartindakan_id);
      $criteria->addCondition('kelaspelayanan_id =' . $kelaspelayanan_id);
      $criteria->addCondition('jenistarif_id =' . $jenistarif);
      $criteria->addCondition('komponentarif_id =' . Params::KOMPONENTARIF_ID_TOTAL);
      $modTarif = TariftindakanM::model()->find($criteria);
      echo CJSON::encode(array(
        'status' => 'create_form',
        'form' => $this->renderPartial($this->path_view . '_formLoadPermintaanOperasi', array(
          'modOperasi' => $modOperasi,
          'kelaspelayanan_id' => $kelaspelayanan_id,
          'modTarif' => $modTarif
        ), true)
      ));
      exit;
    }
  }

  public function actionAjaxBatalKirim()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pasienkirimkeunitlain_id = $_POST['idPasienKirimKeUnitLain'];
      // $pendaftaran_id = $_POST['pendaftaran_id'];
      $data['pesan'] = "Pasien kirim ke laboratorium gagal dibatalkan!";
      $pasien_id = empty($_POST['pasien_id']) ? null : $_POST['pasien_id'];
      $data['sukses'] = 0;
      $status = 'ok';

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $criteria = new CDbCriteria();
        $criteria->select = "count(t.permintaankepenunjang_id) as permintaankepenunjang_id";
        $criteria->join = "join tindakanpelayanan_t tp on tp.tindakanpelayanan_id = t.tindakanpelayanan_id ";
        $criteria->addCondition("t.pasienkirimkeunitlain_id = " . $pasienkirimkeunitlain_id . " and tp.tindakansudahbayar_id is not null");
        $permintaan = PermintaankepenunjangT::model()->find($criteria);

        if ($permintaan->permintaankepenunjang_id > 0) {
          $data['pesan'] = "Pasien kirim ke laboratorium tidak bisa dibatalkan karena tindakan sudah dibayarkan!";
          $data['sukses'] = 0;
        } else {
          $ok = true;
          $kirim = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);

          if (!empty($kirim)) {
            $kirimUnit = array(
              'instalasi_id' => $kirim->instalasi_id,
              'ruangan_id' => $kirim->ruangan_id,
              'pasien_id' => $kirim->pasien_id,
              // 'no_pendaftaran' => $kirim->pendaftaran->no_pendaftaran
            );
          }


          $permintaan = PermintaankepenunjangT::model()->findAllByAttributes(array(
            'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id
          ));
          foreach ($permintaan as $item) {
            if (!empty($item->tindakanpelayanan_id)) {
              $ok = $ok && TindakanpelayananT::model()->deleteByPk($item->tindakanpelayanan_id);
            }
          }
          $ok = $ok && PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
          $ok = $ok && PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
          $keterangan = "Pasien berhasil dibatalkan";

          // var_dump($status, $ok); die; 
          if ($status == 'ok' && $ok) {

            $this->notifBatalRujuk($kirimUnit);

            $data['pesan'] = "Pasien kirim ke bedah sentral berhasil dibatalkan!";
            $data['sukses'] = 1;
            $transaction->commit();
          } else {
            $transaction->rollback();
            $data['pesan'] = "Pasien kirim ke bedah sentral tidak bisa dibatalkan karena tindakan sudah dibayarkan1!";
            $data['sukses'] = 0;
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['pesan'] = "Pasien kirim ke bedah sentral gagal dibatalkan karena tindakan sudah dibayarkan2!";
        $data['sukses'] = 0;
      }

      $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array(
        'pasien_id' => $pasien_id,
        'ruangan_id' => Params::RUANGAN_ID_BEDAH,
        'pasienmasukpenunjang_id' => null
      ));

      $data['result'] = $this->renderPartial($this->path_view . '_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {
    $pendaftaran_id = $_GET['id'];
    $idPasienKirimKeUnitLain = $_GET['idPasienKirimKeUnitLain'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array(
        'pendaftaran_id' => $pendaftaran_id,
        'pasienkirimkeunitlain_id' => $idPasienKirimKeUnitLain
      ),
      'pasienmasukpenunjang_id IS NULL'
    );

    $judulLaporan = 'Permintaan Operasi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
  public function actionPrintRujukan()
  {
    $pendaftaran_id = $_GET['id'];
    $idPasienKirimKeUnitLain = $_GET['rujukankeluar_id'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($idPasienKirimKeUnitLain);
    $morbid = PasienmorbiditasT::model()->findByAttributes(array(
        'pendaftaran_id' => $pendaftaran_id,
        'kelompokdiagnosa_id' => 2,
    ), array(
        'order' => 'pasienmorbiditas_id desc',
    ));
    $modRencanaOp = RencanaoperasiT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
    ),array(  'order' => 'rencanaoperasi_id desc',));

    $judulLaporan = 'Permintaan Operasi';
    $caraPrint = $_REQUEST['caraPrint'];

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';

      $this->render($this->path_view . 'PrintRujukan', array('modRencanaOp'=>$modRencanaOp,'modPendaftaran' => $modPendaftaran,'morbid'=>$morbid, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionPrintRiwayat()
  {
    $pendaftaran_id = $_GET['id'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id=' . $pendaftaran_id);
    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Params::RUANGAN_ID_BEDAH), 'pasienmasukpenunjang_id IS NULL');
    $judulLaporan = 'Permintaan Operasi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * - digunakan untuk mengenerate notif batal rujukan
   * @param type $modKirimKeunitlain
   */
  protected function notifBatalRujuk($modKirimKeunitlain)
  {

    $modRuangan = RuanganM::model()->findByPk($modKirimKeunitlain['ruangan_id']);
    $pasien_id = $modKirimKeunitlain['pasien_id'];
    $modPasien = PasienM::model()->findByPk($pasien_id);
    $judul = 'Pasien Batal Rujuk Bedah Sentral';

    $isi = (isset($modKirimKeunitlain['no_pendaftaran']) ? $modKirimKeunitlain['no_pendaftaran'] . ' ' : "") . $modPasien->no_rekam_medik . ' ' . $modPasien->nama_pasien;


    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $modKirimKeunitlain['instalasi_id'], 'ruangan_id' => $modRuangan->ruangan_id, 'modul_id' => $modRuangan->modul_id),
    ));
  }
  
  public function actionSetPendaftaran(){
      if (Yii::app()->request->isAjaxRequest){
          
          $kirimId = isset($_POST['kirimId'])?$_POST['kirimId']:null;
          $pendaftaran_id = isset($_POST['pendaftaran_id'])?$_POST['pendaftaran_id']:null;
          $tglrencana = isset($_POST['tglrencana'])?$_POST['tglrencana']:null;
          $sukses = true;
          
          $trans = Yii::app()->db->beginTransaction();
          try{
              $modDaftar = PendaftaranT::model()->findByPk($pendaftaran_id);
              
              $model = PasienkirimkeunitlainT::model()->findByPk($kirimId);
              $model->tglrencanapemeriksaan = MyFormatter::formatDateTimeForDb($tglrencana);
              $model->pendaftaran_id = $pendaftaran_id;
              $sukses &= $model->update(['pendaftaran_id','tglrencanapemeriksaan']);
                            
              $penunjang = PasienmasukpenunjangT::model()->findByAttributes([
                 'pasienkirimkeunitlain_id' => $kirimId
              ]);
              if (!empty($penunjang)){
                  $penunjang->pendaftaran_id = $pendaftaran_id;
                  $penunjang->kunjungan = $model->pendaftaran->kunjungan;
                  $sukses &= $penunjang->update(['pendaftaran_id']);
              }
              
              if (empty($model->is_elektif)){
                  
                  $_POST['RJPasienKirimKeUnitLainT'] = $model->attributes;
                  $_POST['RJPasienKirimKeUnitLainT']['pegawai_id'] = $model->pegawai_id;
                  $_POST['RJPasienKirimKeUnitLainT']['tgl_kirimpasien'] = $model->tgl_kirimpasien;
                  $_POST['RJPasienKirimKeUnitLainT']['isbayarkekasirpenunjang'] = $model->isbayarkekasirpenunjang;
                  $_POST['RJPasienKirimKeUnitLainT']['indikasioperasi'] = $model->indikasioperasi;
                  $_POST['RJPasienKirimKeUnitLainT']['sifatoperasi'] = $model->sifatoperasi;
                  $_POST['RJPasienKirimKeUnitLainT']['vitalsignterakhir'] = $model->vitalsignterakhir;
                  $_POST['RJPasienKirimKeUnitLainT']['petugasruangan_id'] = $model->petugasruangan_id;
                  $_POST['RJPasienKirimKeUnitLainT']['petugasok_id'] = $model->petugasok_id;
                  $_POST['RJPasienKirimKeUnitLainT']['tglrencanapemeriksaan'] = $model->tglrencanapemeriksaan;
                  $_POST['RJPasienKirimKeUnitLainT']['dokteroperator_id'] = $model->dokteroperator_id;
                  $_POST['RJPasienKirimKeUnitLainT']['carabayar_id'] = $model->carabayar_id;
                  $_POST['RJPasienKirimKeUnitLainT']['penjamin_id'] = $model->penjamin_id;
                  
                 $modKirimAnestesi = $this->savePasienKirimKeUnitLainAnestesi($modDaftar, $model->pasienkirimkeunitlain_id);
                 $this->savePermintaanPenunjangAnestesi($modKirimAnestesi);
              }
              
              if ($sukses){
                  $trans->commit();
              }else{
                  $trans->rollback();
              }              
          }catch(Exception $e){
              $sukses &= false;
              $trans->rollback();
          }
          
          echo json_encode([
              'sukses'=>$sukses,              
          ]);
          exit;
      }
  }

    /**
     * Simpan data tabel pasienkirimunitlain_t dengan instalasi_id = instalasi anestesi
     * @param type $modPendaftaran
     * @param type $parentbedah_id
     * @return \RJPasienKirimKeUnitLainT
     */
    protected function savePasienKirimKeUnitLainAnestesi($modPendaftaran, $parentbedah_id) {
        
//        $ranas = RuangananestesiV::model()->find();
        
        $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByAttributes(array(
          'pasienkirimkeunitlainparent_id' => $parentbedah_id
        ));

        if (empty($modKirimKeUnitLain)) {
          $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
        }

        $format = new MyFormatter();
        $modKirimKeUnitLain->attributes = $_POST['RJPasienKirimKeUnitLainT'];        
//        $modKirimKeUnitLain->no_permintaan = MyGenerator::generateNomorPermintaan(Yii::app()->user->getState('ruangan_id'));        
        $modKirimKeUnitLain->pasien_id = $modPendaftaran->pasien_id;
        $modKirimKeUnitLain->pendaftaran_id = $modPendaftaran->pendaftaran_id;        
        $modKirimKeUnitLain->pegawai_id = $_POST['RJPasienKirimKeUnitLainT']['pegawai_id'];
        $modKirimKeUnitLain->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
//        $modKirimKeUnitLain->instalasi_id = !empty($ranas)?$ranas->instalasi_id:Params::INSTALASI_ID_ANESTESI;
//        $modKirimKeUnitLain->ruangan_id = !empty($ranas)?$ranas->ruangan_id:Params::RUANGAN_ID_ANASTESI;
        $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_ANESTESI;
        $modKirimKeUnitLain->ruangan_id = Params::RUANGAN_ID_ANASTESI;
        $modKirimKeUnitLain->tgl_kirimpasien = $format->formatDateTimeForDb($_POST['RJPasienKirimKeUnitLainT']['tgl_kirimpasien']);        
        
//        $modKirimKeUnitLain->ops_tgl = !empty($modKirimKeUnitLain->ops_tgl) ? MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->ops_tgl) : null;
//        $modKirimKeUnitLain->ops_tglmrs = !empty($modKirimKeUnitLain->ops_tglmrs) ? MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->ops_tglmrs) : null;
        $modKirimKeUnitLain->update_time = $modKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
        $modKirimKeUnitLain->update_loginpemakai_id = $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
        $modKirimKeUnitLain->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
        $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
        $modKirimKeUnitLain->pasienkirimkeunitlainparent_id = $parentbedah_id;
        $modKirimKeUnitLain->isbayarkekasirpenunjang = isset($_POST['RJPasienKirimKeUnitLainT']['isbayarkekasirpenunjang']) ? $_POST['RJPasienKirimKeUnitLainT']['isbayarkekasirpenunjang'] : 0;                           
        $modKirimKeUnitLain->estimasioperasi = !empty($_POST['RJPasienKirimKeUnitLainT']['estimasioperasi']) ? MyFormatter::formatNumberForDb($_POST['RJPasienKirimKeUnitLainT']['estimasioperasi']) : '';
        
        if ($modKirimKeUnitLain->save()){
            $this->statusSaveKirimkeUnitLain  = true;
        }else{
            $this->statusSaveKirimkeUnitLain  = false;
        }  
        return $modKirimKeUnitLain;
    }
    
    /**
     * fungsi simpan ke tabel PermintaanPenunjang_t untuk anestesi     
     * @param type $modKirimKeUnitLain
     */
    protected function savePermintaanPenunjangAnestesi($modKirimKeUnitLain) {
        $r = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);
        $init = !empty($r->ruangan_singkatan) ? $r->ruangan_singkatan : 'AR';

        $modPermintaan = new RJPermintaanPenunjangT;
        $modPermintaan->daftartindakan_id = null;
        $modPermintaan->pemeriksaanlab_id = null;
        $modPermintaan->operasi_id = null;
        $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
        $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang($init);
        $modPermintaan->qtypermintaan = 1;
        $modPermintaan->tglpermintaankepenunjang = $modKirimKeUnitLain->tgl_kirimpasien; //date('Y-m-d H:i:s');
        
        $this->statusSavePermintaanPenunjang &= $modPermintaan->save();                        
    }

    /**
   * set checklist pemeriksaan lab
   */
  public function actionSetChecklistOperasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $content = "";
      
      $kegiatan_operasi = $_POST['kegiatan_operasi'];
      $operasi = $_POST['operasi'];

      $cr1 = new CDbCriteria;
      $cr1->select = "t.kegiatanoperasi_id, t.kegiatanoperasi_nama";
      $cr1->group = $cr1->select;
      $cr1->join = "JOIN operasi_m o on o.kegiatanoperasi_id = t.kegiatanoperasi_id";
      $cr1->addCondition('t.kegiatanoperasi_aktif = true');
      $cr1->compare('LOWER(o.operasi_nama)', strtolower($operasi),true);
      $cr1->compare('t.kegiatanoperasi_id', $kegiatan_operasi);
      $cr1->order = 't.kegiatanoperasi_nama';
      // $cr1->compare('LOWER(agama)',strtolower($this->agama),true);
      $modKegiatanOperasi = RJKegiatanOperasiM::model()->findAll($cr1);

      $cr2 = new CDbCriteria;
      $cr2->addCondition('operasi_aktif = true');
      $cr2->compare('LOWER(operasi_nama)', strtolower($operasi),true);
      $cr2->order = 'operasi_nama';
      $modOperasi = RJOperasiM::model()->findAll($cr2);

      // var_dump($modPemeriksaanlabs);die();
      $content = $this->renderPartial($this->path_view . '_formOperasi', array('modKegiatanOperasi' => $modKegiatanOperasi, 'modOperasi' => $modOperasi), true);
      // }
      echo CJSON::encode(array(
        'content' => $content
      ));
      Yii::app()->end();
    }
  }

  function actionSetPPDS() {
    $type = $_POST['type'];
    
    $option = '<option value> -- Pilih -- </option>';
    if($type == 'PPDS') {
      $modPPDS = PpdsM::model()->findAll(['condition' => 'ppds_aktif is true', 'order' => 'ppds_nama ASC']);
      
      if(!empty($modPPDS)) {
        foreach ($modPPDS as $i => $value) {
          $option .= "<option value='" . $value->ppds_id ."'> " . $value->ppds_nama . " </option>";
        }
      }
    } else {
      $modPegawai = PegawaiM::model()->findAll('kelompokpegawai_id = 1 and pegawai_aktif = true order by nama_pegawai');
      if(!empty($modPegawai)) {
        foreach ($modPegawai as $i => $value) {
          $option .= "<option value='" . $value->pegawai_id ."'> " . $value->namaLengkap . " </option>";
        }
      }
    }

    echo json_encode(['option' => $option]);
  }
}
