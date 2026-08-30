<?php
/**
 * digunakan untuk mengelola transaksi informasi rujukan penunjang
 * RSST-5081
 * @package application.modules.mikrobiologiKlinik
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id> 
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class RujukanPenunjangController extends MyAuthController
{
    public $instalasi_ruangan, $nama_pasien_panggilan, $cara_bayar_penjamin, $kasus_pelayanan;
    
    /**
     * Default menu
     */
    public function actionIndex()
    {
        $format = new MyFormatter;
        $model = new MKPasienKirimKeUnitLainV();
        $model->tgl_awal = date('Y-m-d');//, strtotime('-5 days')
        $model->tgl_akhir = date('Y-m-d');
        $model->tgl_rencana_awal = date('Y-m-d'); //, strtotime('-5 days')
        $model->tgl_rencana_akhir = date('Y-m-d');
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        
        if(isset($_GET['MKPasienKirimKeUnitLainV'])){
            $model->attributes = $_GET['MKPasienKirimKeUnitLainV'];  
            $model->isPilihTglRencana = $_GET['MKPasienKirimKeUnitLainV']['isPilihTglRencana'] ?? false;                      
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['MKPasienKirimKeUnitLainV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['MKPasienKirimKeUnitLainV']['tgl_akhir']);
            $model->prefix_pendaftaran = $_GET['MKPasienKirimKeUnitLainV']['prefix_pendaftaran'];
            $model->statusperiksa = isset($_GET['MKPasienKirimKeUnitLainV']['statusperiksa'])?$_GET['MKPasienKirimKeUnitLainV']['statusperiksa']:null;
            $model->samplelab_nama = isset($_GET['MKPasienKirimKeUnitLainV']['samplelab_nama'])?$_GET['MKPasienKirimKeUnitLainV']['samplelab_nama']:null;
            if(isset($_GET['MKPasienKirimKeUnitLainV']['tgl_rencana_awal'])) {
                $model->tgl_rencana_awal = MyFormatter::formatDateTimeForDb($_GET['MKPasienKirimKeUnitLainV']['tgl_rencana_awal']);
              }
              if(isset($_GET['MKPasienKirimKeUnitLainV']['tgl_rencana_akhir'])) {
                $model->tgl_rencana_akhir = MyFormatter::formatDateTimeForDb($_GET['MKPasienKirimKeUnitLainV']['tgl_rencana_akhir']);
              }
            if(Yii::app()->request->isAjaxRequest) {
                if(isset($_GET['ajax']) && $_GET['ajax'] == 'pasienpenunjangrujukan-m-grid') {
                    $this->renderPartial('_table', ['model' => $model]);
                    Yii::app()->end();
                }
            }			
        }
        $this->render('index',array('model'=>$model,'format'=>$format));
        
    }
        /**
         * Batal rujukan pasien
         */
	public function actionBatalRujuk()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $pendaftaran_id = $_POST['pendaftaran_id'];
                $idKirimUnit = $_POST['idKirimUnit'];
				//$keterangan_batal = isset($_POST['keterangan_batal'])?$_POST['keterangan_batal']:null;

                $transaction = Yii::app()->db->beginTransaction();
                $status = 'ok';
                $status_bayar = 'ok';

                $nama_modul = Yii::app()->controller->module->id;
                $nama_controller = Yii::app()->controller->id;
                $nama_action = Yii::app()->controller->action->id;
                $modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
                $criteria = new CDbCriteria;
                $criteria->compare('modul_id',$modul_id);
                $criteria->compare('LOWER(modcontroller)',strtolower($nama_controller),true);
                $criteria->compare('LOWER(modaction)',strtolower($nama_action),true);
                if(isset($_POST['tujuansms'])){
                    $criteria->addInCondition('tujuansms',$_POST['tujuansms']);
                }
                $modSmsgateway = SmsgatewayM::model()->findAll($criteria);
                $smspasien = 1;
                $nama_pasien = '';

                try {
                    $criteria = new CDbCriteria();
                    $criteria->select = "count(t.permintaankepenunjang_id) as permintaankepenunjang_id";
                    $criteria->join = "join tindakanpelayanan_t tp on tp.tindakanpelayanan_id = t.tindakanpelayanan_id ";
                    $criteria->addCondition("t.pasienkirimkeunitlain_id = ".$idKirimUnit." and tp.tindakansudahbayar_id is not null");
                    $permintaan = PermintaankepenunjangT::model()->find($criteria);
                    
                    
                    
                    if ($permintaan->permintaankepenunjang_id > 0) {
                        $keterangan = "Pemeriksaan tidak bisa dibatalkan karena ada pemeriksaan yang sudah dibayarkan";
                    } else {
                        $ok = true;
                        $kirim = PasienkirimkeunitlainT::model()->findByPk($idKirimUnit);
                        $permintaan = PermintaankepenunjangT::model()->findAllByAttributes(array(
                            'pasienkirimkeunitlain_id'=>$idKirimUnit
                        ));

                        foreach ($permintaan as $item) {
                            if (!empty($item->tindakanpelayanan_id)) {
                                $ok = $ok && TindakanpelayananT::model()->deleteByPk($item->tindakanpelayanan_id);
                            }
                        }

                        $kirim_spes = KirimspesimenlabT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id' => $idKirimUnit));

                        if(!empty($kirim_spes)) {
                            $ok = $ok && KirimspesimenlabT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $idKirimUnit));
                        }
                        // echo '<pre>'; var_dump("OK1: " . $ok, $idKirimUnit);

                        $modPenilaian = MKPenialianKelayakanSpesimenT::model()->findByAttributes(array('pasienkirimkeunitlain_id' => $idKirimUnit));

                        if(!empty($modPenilaian)) {
                            $spesimen = SpesimenT::model()->findAllByAttributes(array('penilaian_kelayakan_spesimen_id' => $modPenilaian->penilaian_kelayakan_spesimen_id));

                            if(!empty($spesimen)) {
                                $ok = $ok && SpesimenT::model()->deleteAllByAttributes(array('penilaian_kelayakan_spesimen_id' => $modPenilaian->penilaian_kelayakan_spesimen_id));
                            }    
                        }
                        
                        // echo '<pre>'; var_dump("OK2: " . $ok);

                        if(!empty($modPenilaian)) {
                            $ok = $ok && $modPenilaian->delete();
                        }
                        // echo '<pre>'; var_dump("OK3: " . $ok);

                        $ok = $ok && PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id'=>$idKirimUnit));
                        // echo '<pre>'; var_dump("OK4: " . $ok);

                        $ok = $ok && PasienkirimkeunitlainT::model()->deleteByPk($idKirimUnit);
                        $keterangan = "Pasien berhasil dibatalkan";

                        // var_dump("OK5: " . $ok); die;
                        
                        if($status == 'ok' && $ok) {
                            $this->notifBatalRujuk($kirim);
                            $transaction->commit();
                        } else {
                            $keterangan = "Pasien gagal dibatalkan";
                            $status = 'not';
                            $transaction->rollback();
                        }
                    }
                } catch (Exception $ex) {
                    $status = 'not';
                    $keterangan = "Pasien gagal dibatalkan";
                    $transaction->rollback();
                }
                $data = array(
                    'status'=>$status,
                    'keterangan'=>$keterangan,
                    //'smspasien'=>$smspasien,
                    //'nama_pasien'=>$nama_pasien,
                );
                echo json_encode($data);
                Yii::app()->end(); 
            }
	}
        
        /**
         * Notifikasi batal
         * @param type $modKirimKeunitlain
         */
        protected function notifBatalRujuk($modKirimKeunitlain) {
            
            $modRuangan = RuanganM::model()->findByPk($modKirimKeunitlain->create_ruangan);
            $pasien_id = $modKirimKeunitlain->pasien_id;
            $modPasien = PasienM::model()->findByPk($pasien_id);
            $judul = 'Pasien Batal Rujuk Laboratorium';

            $isi = $modPasien->no_rekam_medik.' - '.$modPasien->nama_pasien
                    .'<br/>Tgl Rujuk : '.MyFormatter::formatDateTimeForUser($modKirimKeunitlain->tgl_kirimpasien);
                        
            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id'=>$modRuangan->instalasi_id, 'ruangan_id'=>$modRuangan->ruangan_id, 'modul_id'=>$modRuangan->modul_id),
				array('instalasi_id'=> Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=> Params::MODUL_ID_BILLINGKASIR),
            )); 
        }
        
    /**
     * @author Tantowy <tantowijaya@.com>
     * action ketika tombol panggil di klik
     */
    public function actionPanggil()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $data = array();
            $data['pesan']="";
            $data['status']="";
            $pasienkirimkeunitlain_id = ($_POST['pasienkirimkeunitlain_id']);
            $modKirimUnit = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);

            $nama_modul = Yii::app()->controller->module->id;
            $nama_controller = Yii::app()->controller->id;
            $nama_action = Yii::app()->controller->action->id;
            $modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
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
            
            $tatusPanggil = true;
            if(!empty($modKirimUnit->panggil_loginpemakai_id)){
                if($modKirimUnit->panggil_loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')){
                    $tatusPanggil = true;
                }else{
                    $tatusPanggil = false;
                    $data['pesan'] = "Antrian sudah dipanggil loket lain";
                    $data['status'] = "gagal";
                }
            }

            if (isset($modKirimUnit) && $tatusPanggil) {
                if(empty($modKirimUnit->nourut)){
                    $modKirimUnit->jml_panggil = 1;
                    $modKirimUnit->jampanggil = date('Y-m-d H:i:s');
                    $modKirimUnit->panggil_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $modKirimUnit->update();
                    $data['pesan'] = "No. antrian ".$modKirimUnit->nourut." dipanggil !";
                }else{
                    $modKirimUnit->jml_panggil = ($modKirimUnit->jml_panggil+1);
                    $modKirimUnit->jampanggil = date('Y-m-d H:i:s');
                    $modKirimUnit->panggil_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                    $modKirimUnit->update();
                    $data['pesan'] = "No. antrian ".$modKirimUnit->nourut." dipanggil !";
                }
                $data['smspasien'] = 1;
            }
            $attributes = $modKirimUnit->attributeNames();
            foreach ($attributes as $i=>$attribute) {
                $data["$attribute"] = $modKirimUnit->$attribute;
            }
            echo CJSON::encode($data);
            Yii::app()->end();
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionBuatJadwal($pasienkirimkeunitlain_id)
    {
      $this->layout = '//layouts/iframe';
      $format = new MyFormatter();
  
      $kirim = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
      $permintaan = PermintaankepenunjangT::model()->findAll("pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id");
     
      
      if (isset($_POST['pasienkirimkeunitlain_id'])) {
        // echo '<pre>'; var_dump($_POST); die;
        
        $transaction = Yii::app()->db->beginTransaction();
  
        try {
  
          $ok = false;
  
          if(!empty($_POST['pasienkirimkeunitlain_id'])) {
              $kirim->tglrencanapemeriksaan = MyFormatter::formatDateTimeForDb($_POST['tglrencanapemeriksaan']);
              $kirim->petugas_jadwal_id = Yii::app()->user->getState('pegawai_id');
              if($kirim->save()) {
                $ok = true;
              }
          }
  
  
          // $ok &= PendaftaranT::model()->updateByPk($kirim->pendaftaran_id, array('ruangan_id' => Yii::app()->user->getState('ruangan_id'),
          //  'update_time' => date('Y-m-d H:i:s'), 'update_loginpemakai_id' => Yii::app()->user->getState('pegawai_id')));
  
          //  var_dump($ok); die;
         
          if ($ok) {
  
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Jadwal Berhasil dibuat !");
            $this->redirect(array('buatJadwal', 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id, 'sukses' => 1));
          } else {
            $transaction->rollback();
  
            Yii::app()->user->setFlash('error', "Jadwal gagal dibuat[1] !<br>");
          }
        } catch (Exception $exc) {
          // var_dump($exc); die;
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Jadwal gagal dibuat[2] !" . " " . MyExceptionMessage::getMessage($exc, true));
        }
      }
  
      $this->render('buatJadwal', array(
        'kirim' => $kirim,
        'permintaan' => $permintaan
      ));
    }

    public function actionPilihTglPeriksa($pasienkirimkeunitlain_id, $pasien_id) {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $modKirimKeUnitLain = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
        $modKirimKeUnitLain->tglrencanapemeriksaan = !empty($modKirimKeUnitLain->tglrencanapemeriksaan) ? MyFormatter::formatDateTimeForUser($modKirimKeUnitLain->tglrencanapemeriksaan) : '';
        $modKirimKeUnitLain->tgl_kirimpasien = !empty($modKirimKeUnitLain->tgl_kirimpasien) ? MyFormatter::formatDateTimeForUser($modKirimKeUnitLain->tgl_kirimpasien) : '';
  
        $modPermintaan = PermintaankepenunjangT::model()->find("pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id");
  
        if(!empty($modPermintaan)) {
            $modPermintaan->jenispemeriksaanlab_nama = $modPermintaan->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama ?? '';
            $modPermintaan->pemeriksaanlab_nama = $modPermintaan->pemeriksaanlab->pemeriksaanlab_nama ?? '';
        } else {
            $modPermintaan = new PermintaankepenunjangT();
        }
        // echo '<pre>';var_dump($modPermintaan);die;
        
  
        if (isset($_POST['PasienkirimkeunitlainT'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
  
                $modKirimKeUnitLain->attributes = $_POST['PasienkirimkeunitlainT'];
                $modKirimKeUnitLain->is_elektif = $_POST['PasienkirimkeunitlainT']['is_elektif'];
                $modKirimKeUnitLain->tglrencanapemeriksaan = $_POST['PasienkirimkeunitlainT']['tglrencanapemeriksaan'] !== '' ? MyFormatter::formatDateTimeForDb($_POST['PasienkirimkeunitlainT']['tglrencanapemeriksaan']) : null;
                $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($_POST['PasienkirimkeunitlainT']['tgl_kirimpasien']);
                $modKirimKeUnitLain->update_time = date('Y-m-d H:i:s');
                $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
  
                // echo '<pre>'; var_dump($modKirimKeUnitLain->attributes, $_POST); die;
  
                if ($modKirimKeUnitLain->validate()) {
                    $modKirimKeUnitLain->save();
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
                    $this->redirect(array('pilihTglPeriksa', 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id, 'pasien_id' => $pasien_id, 'frame' => 1, 'popup' => 'true', 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan!");
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
  
        $this->render('_pilihTglPeriksa', array(
            'modKirimKeUnitLain' => $modKirimKeUnitLain,
            'modPermintaan' => $modPermintaan,
            'format' => $format,
        ));
    }

    public function actionMintaSampelUlang($pasienkirimkeunitlain_id) {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $modKirimKeUnitLain = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
        $modKirimKeUnitLain->tglrencanapemeriksaan = !empty($modKirimKeUnitLain->tglrencanapemeriksaan) ? MyFormatter::formatDateTimeForUser($modKirimKeUnitLain->tglrencanapemeriksaan) : '';
        $modKirimKeUnitLain->tgl_kirimpasien = !empty($modKirimKeUnitLain->tgl_kirimpasien) ? MyFormatter::formatDateTimeForUser($modKirimKeUnitLain->tgl_kirimpasien) : '';
  

        $crit = new CDbCriteria;
        $crit->join = "LEFT JOIN pemeriksaanlab_m p ON p.pemeriksaanlab_id = t.pemeriksaanlab_id";
        $crit->addCondition("pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id");
        $crit->order = "p.jenispemeriksaanlab_id";
        $modPermintaan = PermintaankepenunjangT::model()->findAll($crit);        
  
        if (isset($_POST['permintaan'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {

                $ok = true;

                // echo '<pre>'; var_dump($_POST['permintaan']); die;
                foreach($_POST['permintaan'] as $perm){
                    
                    if(isset($perm['alasan_mintaulangsampel'])) {
                        $permintaan = PermintaankepenunjangT::model()->findByPk($perm['permintaankepenunjang_id']);
                        $permintaan->mintaulang_samplelab_id = $perm['mintaulang_samplelab_id'];
                        $permintaan->alasan_mintaulangsampel = $perm['alasan_mintaulangsampel'];
                        $permintaan->tglpermintaankepenunjang = MyFormatter::formatDateTimeForDb($permintaan->tglpermintaankepenunjang);
                        $permintaan->tgl_rencanapemeriksaan = MyFormatter::formatDateTimeForDb($permintaan->tgl_rencanapemeriksaan);
                        $ok &= $permintaan->save();    
                    }
                   
                }

                $modKirimKeUnitLain->tglrencanapemeriksaan = !empty($modKirimKeUnitLain->tglrencanapemeriksaan) ? MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tglrencanapemeriksaan) : '';
                $modKirimKeUnitLain->tgl_kirimpasien = !empty($modKirimKeUnitLain->tgl_kirimpasien) ? MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien) : '';
    
                if ($modKirimKeUnitLain->validate()) {
                    $modKirimKeUnitLain->save();
                    $this->notifMintaSampelUlang($modKirimKeUnitLain);
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
                    $this->redirect(array('mintaSampelUlang', 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan!");
                }
            } catch (Exception $exc) {
                echo '<pre>'; var_dump($exc); die;
                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
  
        $this->render('_mintaSampelUlang', array(
            'modKirimKeUnitLain' => $modKirimKeUnitLain,
            'modPermintaan' => $modPermintaan,
            'format' => $format,
        ));
    }


    public function actionMintaSampelUlangOrder($pasienkirimkeunitlain_id) {
        $this->layout = '//layouts/iframe';
        $format = new MyFormatter();
        $modKirimKeUnitLain = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
        $modKirimKeUnitLain->tglrencanapemeriksaan = !empty($modKirimKeUnitLain->tglrencanapemeriksaan) ? MyFormatter::formatDateTimeForUser($modKirimKeUnitLain->tglrencanapemeriksaan) : '';
        $modKirimKeUnitLain->tgl_kirimpasien = !empty($modKirimKeUnitLain->tgl_kirimpasien) ? MyFormatter::formatDateTimeForUser($modKirimKeUnitLain->tgl_kirimpasien) : '';
  
       
        $crit = new CDbCriteria;
        $crit->join = "LEFT JOIN pemeriksaanlab_m p ON p.pemeriksaanlab_id = t.pemeriksaanlab_id";
        $crit->addCondition("pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id");
        $crit->order = "p.jenispemeriksaanlab_id";
        $modPermintaan = PermintaankepenunjangT::model()->findAll($crit);       
  
        if (isset($_POST['permintaan'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {

                $ok = true;
                foreach($_POST['permintaan'] as $perm){
                    
                    $permintaan = PermintaankepenunjangT::model()->findByPk($perm['permintaankepenunjang_id']);
                    $permintaan->mintaulang_samplelab_id = $perm['mintaulang_samplelab_id'];
                    $permintaan->alasan_mintaulangsampel = $perm['alasan_mintaulangsampel'];
                    $ok &= $permintaan->save();

                }

    
                if ($modKirimKeUnitLain->validate()) {
                    $modKirimKeUnitLain->save();
                    $this->notifMintaSampelUlang2($modKirimKeUnitLain);
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
                    $this->redirect(array('mintaSampelUlangOrder', 'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id, 'sukses' => 1));
                } else {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', "Data gagal disimpan!");
                }
            } catch (Exception $exc) {
                // echo '<pre>'; var_dump($exc); die;

                $transaction->rollback();
                Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
            }
        }
  
        $this->render('_mintaSampelUlangOrder', array(
            'modKirimKeUnitLain' => $modKirimKeUnitLain,
            'modPermintaan' => $modPermintaan,
            'format' => $format,
        ));
    }

                    /**
         * Notifikasi batal
         * @param type $modKirimKeunitlain
         */
        protected function notifMintaSampelUlang($modKirimKeunitlain) {
            
            $modRuangan = RuanganM::model()->findByPk($modKirimKeunitlain->create_ruangan);
            $pasien_id = $modKirimKeunitlain->pasien_id;
            $modPasien = PasienM::model()->findByPk($pasien_id);
            $judul = 'Minta Ulang Sampel Mikrobiologi';


            $isi = $modPasien->no_rekam_medik.' - '.$modPasien->nama_pasien;

            $link = $this->createUrl('/mikrobiologiKlinik/RujukanPenunjang/Index',array(
                'MKPasienKirimKeUnitLainV[tgl_awal]'=>date('Y-m-d', strtotime($modKirimKeunitlain->tgl_kirimpasien)),
                'MKPasienKirimKeUnitLainV[tgl_akhir]'=>date('Y-m-d', strtotime($modKirimKeunitlain->tgl_kirimpasien)),
                'MKPasienKirimKeUnitLainV[no_pendaftaran]'=>substr($modKirimKeunitlain->pendaftaran->no_pendaftaran,2),			
                'MKPasienKirimKeUnitLainV[prefix_pendaftaran]'=>substr($modKirimKeunitlain->pendaftaran->no_pendaftaran,0,2),			
                'MKPasienKirimKeUnitLainV[no_rekam_medik]'=>$modPasien->no_rekam_medik,
                'MKPasienKirimKeUnitLainV[nama_pasien]'=>$modPasien->nama_pasien
        ));
                        
            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id'=>$modRuangan->instalasi_id, 'ruangan_id'=>$modRuangan->ruangan_id, 'modul_id'=>$modRuangan->modul_id, 'link_proses' => $link),
            )); 
        }

        public function notifMintaSampelUlang2($modPasienKirimKeUnitLain)
        {
    
    
            $penunjang = PasienkirimkeunitlainV::model()->findByAttributes(array(
            'pasienkirimkeunitlain_id' => $modPasienKirimKeUnitLain->pasienkirimkeunitlain_id
            ));
            $judul = "Minta Sampel Ulang - " . $modPasienKirimKeUnitLain->samplelab_nama;
    
            $asal = RuanganM::model()->findByPk($penunjang->ruanganasal_id);
    
            $isi = "Tgl. Periksa : " . MyFormatter::formatDateTimeForUser($modPasienKirimKeUnitLain->tgl_kirimpasien) . "<br/>";
            $isi .= "No. Periksa : " . $modPasienKirimKeUnitLain->no_permintaan . "<br/>";
            $isi .= "No. Pendaftaran : " . $penunjang->no_pendaftaran . "<br/>";
            $isi .= "Pasien : " . $penunjang->no_rekam_medik . " - " . $penunjang->nama_pasien;
    
            $link = $this->createUrl('/rawatJalan/pemeriksaanPasien/index', array(
                'pendaftaran_id' => $modPasienKirimKeUnitLain->pendaftaran_id
            ));
    
            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $penunjang->instalasiasal_id, 'ruangan_id' => $penunjang->ruanganasal_id, 'modul_id' => $asal->modul_id, 'link_proses' => $link),
            ));
        }
}