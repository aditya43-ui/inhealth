<?php

class RujukanPenunjangController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Rujukan";
    $model = new PasienkirimkeunitlainV;
    $model->tgl_awal = date('Y-m-d'); //-1 tahun
    $model->tgl_akhir = date('Y-m-d');
    $model->tgl_rencana_awal = date('Y-m-d'); //-1 tahun
    $model->tgl_rencana_akhir = date('Y-m-d');

    if (isset($_GET['PasienkirimkeunitlainV'])) {
      $model->attributes = $_GET['PasienkirimkeunitlainV'];
      $model->isPilihTglRencana = $_GET['PasienkirimkeunitlainV']['isPilihTglRencana'] ?? false;
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['PasienkirimkeunitlainV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['PasienkirimkeunitlainV']['tgl_akhir']);
      if(isset($_GET['PasienkirimkeunitlainV']['tgl_rencana_awal'])) {
        $model->tgl_rencana_awal = MyFormatter::formatDateTimeForDb($_GET['PasienkirimkeunitlainV']['tgl_rencana_awal']);
      }
      if(isset($_GET['PasienkirimkeunitlainV']['tgl_rencana_akhir'])) {
        $model->tgl_rencana_akhir = MyFormatter::formatDateTimeForDb($_GET['PasienkirimkeunitlainV']['tgl_rencana_akhir']);
      }
      $model->namaDokter = isset($_GET['PasienkirimkeunitlainV']['namaDokter']) ? $_GET['PasienkirimkeunitlainV']['namaDokter'] : null;
      $model->statusperiksa = isset($_GET['PasienkirimkeunitlainV']['statusperiksa']) ? $_GET['PasienkirimkeunitlainV']['statusperiksa'] : null;


    }

    $dataProvider = $model->searchRujukRad();

    if(Yii::app()->request->isAjaxRequest) {
      if(isset($_GET['ajax']) && $_GET['ajax'] == 'pasienpenunjangrujukan-m-grid') {
        $this->renderPartial('_table', [
          'dataProvider' => $dataProvider
        ]);
        Yii::app()->end();
      }
    }
    /*
			$criteria = new CDbCriteria;
			if(isset($_GET['ajax']) && $_GET['ajax']=='pasienpenunjangrujukan-m-grid') {
				$format = new MyFormatter;
				//echo $format->formatDateTimeForDb($_GET['tgl_akhir']);
				if (isset($_GET['no_pendaftaran'])) $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($_GET['noPendaftaran']),true);
				if (isset($_GET['nama_pasien'])) $criteria->compare('LOWER(t.nama_pasien)', strtolower($_GET['namaPasien']),true);
				if (isset($_GET['noRekamMedik'])) $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($_GET['noRekamMedik']),true);
				if (isset($_GET['tgl_awal']) && isset($_GET['tgl_akhir'])) $criteria->addBetweenCondition('t.tgl_kirimpasien::date', $format->formatDateTimeForDb($_GET['tgl_awal']), $format->formatDateTimeForDb($_GET['tgl_akhir']));
			} else {
//                $criteria->addBetweenCondition('tgl_pendaftaran', date('Y-m-d'), date('Y-m-d'));
				$criteria->addBetweenCondition('date(t.tgl_pendaftaran)', date('Y-m-d', strtotime('-5 days')).' 00:00:00', date('Y-m-d H:i:s'));
			}
			$criteria->addCondition('t.instalasi_id = '.Yii::app()->user->getState('instalasi_id'));
			$criteria->order='t.tgl_kirimpasien DESC';
			
                        $criteria->join = "join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id";
                        $criteria->addCondition('p.pasienbatalperiksa_id is null');
                        
			$dataProvider = new CActiveDataProvider(PasienkirimkeunitlainV::model(), array(
			'criteria'=>$criteria,
		));
             * 
             */
    $this->render('index', array('dataProvider' => $dataProvider, 'model' => $model));
  }

  // Uncomment the following methods and override them if needed
  /*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/

  /**
   * Date		: 12 Juni 2015
   * 
   */
  public function actionBatalRujuk()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $idKirimUnit = $_POST['idKirimUnit'];

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

      $transaction = Yii::app()->db->beginTransaction();
      $status = 'ok';
      $status_bayar = 'ok';

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
          //var_dump($ok);
          $ok = $ok && PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $idKirimUnit));
          //var_dump($ok);
          $ok = $ok && PasienkirimkeunitlainT::model()->deleteByPk($idKirimUnit);
          //var_dump($ok);
          //die;
          $keterangan = "Pasien berhasil dibatalkan";
          //var_dump($ok);
          //die;
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
        //print_r($ex);
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
    $judul = 'Pasien Batal Rujuk Radiologi';

    $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien
      . '<br/>Tgl. Rujuk : ' . MyFormatter::formatDateTimeForUser($modKirimKeunitlain->tgl_kirimpasien);

    //var_dump($judul." , ".$isi);

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $modRuangan->instalasi_id, 'ruangan_id' => $modRuangan->ruangan_id, 'modul_id' => $modRuangan->modul_id),
      // array('instalasi_id'=> Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=> Params::MODUL_ID_BILLINGKASIR),
    ));
  }

  public function actionKirimWAPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $data['pesan'] = "Whatsapp Gagal Terkirim Ke Pasien";
      $data['status'] = false;

      $pendaftaran_id = ($_POST['pendaftaran_id']);
      $pasienkirimkeunitlain_id = ($_POST['pasienkirimkeunitlain_id']);

      $modKirimUnitlain = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

      if(!empty($modKirimUnitlain) && !empty($modPendaftaran) && !empty($modPasien->no_mobile_pasien)){
         $modPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pasienkirimkeunitlain_id'=>$modKirimUnitlain->pasienkirimkeunitlain_id));
         $nourut = null;
         $intalasi_nama = null;
         $ruangan_nama = null;
         $penjamin_id = $modPendaftaran->penjamin_id;
         
         $dokter = $modKirimUnitlain->pegawai->namaLengkap;
         
         if(!empty($modPenunjang)){
          $nourut = $modPenunjang->ruangan->ruangan_singkatan."-".$modPenunjang->no_urutperiksa;
         }
         $ruanganAsal = RuanganM::model()->findByPk($modKirimUnitlain->create_ruangan);

         $intalasi_nama = $ruanganAsal->instalasi->instalasi_nama;
         $ruangan_nama = $ruanganAsal->ruangan_nama;

         if($ruanganAsal->instalasi_id != Params::INSTALASI_ID_RJ){
          $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
          $penjamin_id = (!empty($modAdmisi)?$modAdmisi->penjamin_id : $modPendaftaran->penjamin_id);

         }
         $modPenjamin = PenjaminpasienM::model()->findByPk($penjamin_id);
         $penjamin_nama = $modPenjamin->penjamin_nama;
         $carabayar_nama = $modPenjamin->carabayar->carabayar_nama;
         $waktupemeriksaan = "";
         $jenispemeriksaan = "";

         $modPermintaan = PermintaankepenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$modKirimUnitlain->pasienkirimkeunitlain_id));

         if(!empty($modPermintaan)){
           $jenisperiksa = array();
           foreach($modPermintaan as $itemtindakan){
             if(empty($itemtindakan->pemeriksaanrad_id)){
               continue;
             }
             $modPemeriksaan = PemeriksaanradM::model()->findByPk($itemtindakan->pemeriksaanrad_id);

            $jenisperiksa[$modPemeriksaan->jenispemeriksaanrad_id]['jenispemeriksaan'] = $modPemeriksaan->jenispemeriksaanrad->jenispemeriksaanrad_nama;
            $jenisperiksa[$modPemeriksaan->jenispemeriksaanrad_id]['waktupemeriksaan'] = (!empty($itemtindakan->tglpermintaankepenunjang)?MyFormatter::formatDateTimeForUser($itemtindakan->tglpermintaankepenunjang): "");
           }

           if(!empty($jenisperiksa)){
             $indx = 0;
             foreach($jenisperiksa as $jns){
               if($indx > 0){
                $waktupemeriksaan .= ", ";
                $jenispemeriksaan .= ", ";
               }
                $jenispemeriksaan .= $jns['jenispemeriksaan'];
                $waktupemeriksaan .= $jns['waktupemeriksaan'];

              $indx++;
             }
           }
         }

        $modProfil = ProfilrumahsakitM::model()->find();     
        $str = "Selamat Datang di ".ucwords(strtolower(($modProfil->nama_rumahsakit)))."\n\n";
        $str .= $modPasien->namadepan.' '.$modPasien->nama_pasien." dengan No RM ".$modPasien->no_rekam_medik." / No Register ".$modPendaftaran->no_pendaftaran." terdaftar sebagai pasien pada tanggal ".MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran).".\n\n";
        $str .= "Data Layanan \n";
        $str .= "Poliklinik: ".$intalasi_nama ."/".$ruangan_nama." \n";
        $str .= "Nama Dokter: ".$dokter." \n";
        $str .= "Penjamin: ".$carabayar_nama."/".$penjamin_nama." \n";
        $str .= "No Antrian: ".$nourut." \n";
        $str .= "Pemeriksaan: ".$jenispemeriksaan." \n";
        $str .= "Waktu pemeriksaan: ".$waktupemeriksaan." \n\n";

        $str .= "Kami mengharapkan kedatangan ".$modPasien->namadepan.' '.$modPasien->nama_pasien." sesuai dengan waktu dan tempat yang sudah disebutkan diatas. \n";
        $str .= "Atas perhatiannya, kami ucapkan terima kasih. \n\n";
        $str .= "Salam,\n";
        $str .= ucwords(strtolower(($modProfil->nama_rumahsakit))).' dan '.ucwords(strtolower(($modProfil->kabupaten->kabupaten_nama)));
        
        $wa = new WhatsApp();
        $res = $wa->kirimIndividu($modPasien->no_mobile_pasien, $str);
         
        if(!empty($res)){
          $data['pesan'] = "Whatsapp Berhasil Terkirim Ke Pasien";
          $data['status'] = true;
          
          PasienkirimkeunitlainT::model()->updateByPk($modKirimUnitlain->pasienkirimkeunitlain_id, array('iskirimwa_pasien'=>true));
        }
      }
      

      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
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
        $value->jenispemeriksaanrad_nama = $value->pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama ?? '';
        $value->pemeriksaanrad_nama = $value->pemeriksaanrad->pemeriksaanrad_nama ?? '';
        $value->pemeriksaanrad_kode = $value->pemeriksaanrad->pemeriksaanrad_kode ?? '';
        if (!empty($value->tgl_rencanapemeriksaan)) {
          $value->tgl_rencanapemeriksaan = MyFormatter::formatDateTimeForDB($value->tgl_rencanapemeriksaan);
          $value->tgl_rencanapemeriksaan = date('Y-m-d', strtotime($value->tgl_rencanapemeriksaan));
          $value->tgl_rencanapemeriksaan = MyFormatter::formatDateTimeForUser($value->tgl_rencanapemeriksaan);
        }
      }
    }
    
    if (isset($_POST['PasienkirimkeunitlainT'])) {
        $transaction = Yii::app()->db->beginTransaction();
        $ok = true;
        try {

            $arr_permintaan = array();
            
            if (isset($_POST['PermintaankepenunjangT'])) {
              foreach ($_POST['PermintaankepenunjangT'] as $permintaankepenunjang_id => $item) {

                $tanggal = MyFormatter::formatDateTimeForDB($item['tgl_rencanapemeriksaan']);

                if (empty($arr_permintaan[$tanggal])) {
                  $arr_permintaan[$tanggal] = array();
                }
                $arr_permintaan[$tanggal]['dataPermintaan'][] = $permintaankepenunjang_id;
                $arr_permintaan[$tanggal]['is_cito'] = $item['is_cito'] == '1' ? true : false;
              }
              
              // echo '<pre>';var_dump($arr_permintaan);die;
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
                $modKirim->is_cito = $item['is_cito'];

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


                foreach ($item['dataPermintaan'] as $permintaankepenunjang_id) {
                  $permintaan = PermintaankepenunjangT::model()->findByPk($permintaankepenunjang_id);
                  $permintaan->pasienkirimkeunitlain_id = $modKirim->pasienkirimkeunitlain_id;
                  $permintaan->tgl_rencanapemeriksaan = $modKirim->tglrencanapemeriksaan;
                  $ok = $ok && $permintaan->save(false, array('pasienkirimkeunitlain_id', 'tgl_rencanapemeriksaan'));
                  // var_dump($permintaan->attributes);
                }

                // var_dump($modKirim->attributes);
                

                $cnt++;
              }


            }

            if ($ok) {
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
}
