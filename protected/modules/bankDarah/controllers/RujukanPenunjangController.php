<?php

class RujukanPenunjangController extends MyAuthController
{
  public $instalasi_ruangan, $nama_pasien_panggilan, $cara_bayar_penjamin, $kasus_pelayanan;
  public function actionIndex()
  {
    $format = new MyFormatter;
    $model = new BDPasienKirimKeUnitLainV();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->cbTglMasuk = true;

    if (isset($_GET['BDPasienKirimKeUnitLainV'])) {
      $model->attributes = $_GET['BDPasienKirimKeUnitLainV'];

      $model->cbTglMasuk = $_GET['BDPasienKirimKeUnitLainV']['cbTglMasuk'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDPasienKirimKeUnitLainV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDPasienKirimKeUnitLainV']['tgl_akhir']);
    }
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $this->render('index', array('model' => $model, 'format' => $format));
  }

  public function actionBatalPemeriksaan()
  {
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
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if (!$model->save()) {
          $status = 'not';
        }

        if ($pasienMasukPenunjang->pasienkirimkeunitlain_id == null) {
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
          //                        $transaction->commit();
        } else {
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        print_r($ex);
        $status = 'not';
        $transaction->rollback();
      }
      $data = array(
        'pesan' => 'succes',
        'status' => 'ok'
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * Date		: 12 Juni 2015
   * Issue	: RND-7153
   */
  //	public function actionbatalRujuk_old()
  //	{
  //		if(Yii::app()->request->isAjaxRequest) {
  //		$pendaftaran_id = $_POST['pendaftaran_id'];
  //		$idKirimUnit = $_POST['idKirimUnit'];
  //
  //		$transaction = Yii::app()->db->beginTransaction();
  //		$status = 'ok';
  //		$status_bayar = 'ok';
  //
  //        $nama_modul = Yii::app()->controller->module->id;
  //        $nama_controller = Yii::app()->controller->id;
  //        $nama_action = Yii::app()->controller->action->id;
  //        $modul_id = ModulK::model()->findByAttributes(array('url_modul'=>$nama_modul))->modul_id;
  //        $criteria = new CDbCriteria;
  //        $criteria->compare('modul_id',$modul_id);
  //        $criteria->compare('LOWER(modcontroller)',strtolower($nama_controller),true);
  //        $criteria->compare('LOWER(modaction)',strtolower($nama_action),true);
  //        if(isset($_POST['tujuansms'])){
  //            $criteria->addInCondition('tujuansms',$_POST['tujuansms']);
  //        }
  //        $modSmsgateway = SmsgatewayM::model()->findAll($criteria);
  //        $smspasien = 1;
  //        $nama_pasien = '';
  //
  //		try{			
  //			$modPermintaanPenunjang = BDPermintaanKePenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id'=>$idKirimUnit));
  //			$modPasienKirimUnit = BDPasienKirimKeUnitLainT::model()->findByPk($idKirimUnit);
  //
  //			foreach($modPermintaanPenunjang as $i=>$permintaan){
  //				$modTindakanPelayanan = BDTindakanPelayananT::model()->findByPk($permintaan->tindakanpelayanan_id);
  //				if(!empty($modTindakanPelayanan->tindakansudahbayar_id)){
  //					$status_bayar = 'ok';
  //				}else{
  //					$status_bayar = 'not';
  //					TindakanpelayananT::model()->deleteByPk($permintaan->tindakanpelayanan_id);
  //					TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id'=>$permintaan->tindakanpelayanan_id));
  //				}
  //			}
  //
  //			if($status_bayar == 'ok'){
  //				$keterangan = "Pemeriksaan tidak bisa dibatalkan karena ada pemeriksaan yang sudah dibayarkan";
  ////					$keterangan = "<div class='flash-success'>Pemeriksaan tidak bisa dibatalkan karena ada pemeriksaan yang sudah dibayarkan</div>";
  //			}else{
  //                // SMS GATEWAY
  //                $modKirimKeunitlain = PasienkirimkeunitlainT::model()->findByPk($idKirimUnit);
  //                $modPasien = $modKirimKeunitlain->pasien;
  //                $nama_pasien = $modPasien->nama_pasien;
  //                $sms = new Sms();
  //                foreach ($modSmsgateway as $i => $smsgateway) {
  //                    $isiPesan = $smsgateway->templatesms;
  //
  //                    $attributes = $modPasien->getAttributes();
  //                    foreach($attributes as $attributes => $value){
  //                        $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
  //                    }
  //               
  //                    $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName(date('Y-m-d')),$isiPesan);
  //                    $isiPesan = str_replace("{{sekarang}}",MyFormatter::formatDateTimeForUser(date('Y-m-d')),$isiPesan);
  //                    
  //                    if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
  //                        if(!empty($modPasien->no_mobile_pasien)){
  //                            $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
  //                        }
  //                        else{
  //                            $smspasien = 0;
  //                        }
  //                    }
  //                    
  //                }
  //                // END SMS GATEWAY
  //				PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id'=>$idKirimUnit));
  //				PasienkirimkeunitlainT::model()->deleteByPk($idKirimUnit);
  //				
  //                $status = 'ok';	
  //				$keterangan = "pasien berhasil dibatalkan";
  //			}
  //
  //			/*
  //			 * kondisi_commit
  //			 */
  //			if($status == 'ok')
  //			{
  //				$transaction->commit();
  //			}else{
  //				$transaction->rollback();
  //			}
  //
  //		}catch(Exception $ex){
  //			print_r($ex);
  //			$status = 'not';
  //			$transaction->rollback();
  //		}            
  //		$data = array(
  //			'status'=>$status,
  //            'keterangan'=>$keterangan,
  //            'smspasien'=>$smspasien,
  //            'nama_pasien'=>$nama_pasien,
  //
  //		);
  //		echo json_encode($data);
  //		 Yii::app()->end();
  //		}
  //	}

  public function actionBatalRujukan($task = 'BatalPenunjang')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $status = '';

      $pasienkirimkeunitlain_id = isset($_POST['pasienkirimkeunitlain_id']) ? $_POST['pasienkirimkeunitlain_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;

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
              $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

              $criteria = new CDbCriteria();
              $criteria->addCondition('t.pasienkirimkeunitlain_id = ' . $pasienkirimkeunitlain_id);
              $criteria->addCondition('tindakanpelayanan_t.tindakansudahbayar_id is not null');
              $criteria->join = 'JOIN tindakanpelayanan_t ON tindakanpelayanan_t.tindakanpelayanan_id = t.tindakanpelayanan_id';
              $modPermintaanPenunjang = PermintaankepenunjangT::model()->findAll($criteria);

              if (count((array)$modPermintaanPenunjang) > 0) {
                $pesan = "Pemeriksaan Rujukan tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!";
              } else {
                $modPermintaanKePenunjang = PermintaankepenunjangT::model()->findAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
                if (count((array)$modPermintaanKePenunjang) > 0) {
                  foreach ($modPermintaanKePenunjang as $i => $detail) {
                    $update_tindakanpelayanan = TindakanpelayananT::model()->updateByPk($detail->tindakanpelayanan_id, array(
                      'detailhasilpemeriksaanlab_id' => null,
                      'hasilpemeriksaanrm_id' => null,
                      'hasilpemeriksaanrad_id' => null,
                      'hasilpemeriksaanpa_id' => null
                    ));

                    if ($update_tindakanpelayanan) {
                      $update_tindakan = true;
                      $status = true;
                    } else {
                      $update_tindakan = false;
                      $status = false;
                    }

                    $delete_tindakanpelayanan = TindakanpelayananT::model()->deleteByPk($detail->tindakanpelayanan_id);
                    if ($delete_tindakanpelayanan) {
                      $delete_tindakan = true;
                      $status = true;
                    } else {
                      $delete_tindakan = false;
                      $status = false;
                    }
                  }
                  if ($status = true) {
                    $delete_permintaankepenunjang = PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
                    if ($delete_permintaankepenunjang) {
                      $delete_penunjang = true;
                      PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
                      $status = true;
                    } else {
                      $delete_penunjang = false;
                      $status = false;
                    }
                  }
                } else {
                  $delete_permintaankepenunjang = PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
                  if ($delete_permintaankepenunjang) {
                    $delete_penunjang = true;
                    PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
                    $status = true;
                  } else {
                    $delete_penunjang = false;
                    $status = false;
                  }
                }

                if ($status = true) {
                  $pesan = 'Pasien Penunjang berhasil di batalkan';
                  $transaction->commit();
                } else {
                  $transaction->rollback();
                }
              }
            } catch (Exception $ex) {
              $status = false;
              $pesan = "exist";
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
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
