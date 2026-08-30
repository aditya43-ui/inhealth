<?php

class PasienPindahController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Pindah";
    $format = new MyFormatter();
    $model = new PIPasienriyangpindahV;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_REQUEST['PIPasienriyangpindahV'])) {
      $model->attributes = $_REQUEST['PIPasienriyangpindahV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PIPasienriyangpindahV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PIPasienriyangpindahV']['tgl_akhir']);
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->ceklis = $_REQUEST['PIPasienriyangpindahV']['ceklis'];
    }
    $this->render('index', array('model' => $model, 'format' => $format));
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

  public function actionBatalPindah($task = 'BatalPindah')
  {

    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;

    $pindahkamar_id = isset($_POST['pindahkamar_id']) ? $_POST['pindahkamar_id'] : null;
    $masukkamar_id = isset($_POST['masukkamar_id']) ? $_POST['masukkamar_id'] : '';
    $nama_pemakai = isset($_POST['nama_pemakai']) ? $_POST['nama_pemakai'] : null;
    $kata_kunci = isset($_POST['kata_kunci']) ? $_POST['kata_kunci'] : null;


    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $status_batal = true;
    $ruangan_nama = '';

    $pesan = '';
    $status = false;
    $success = false;

    $update_kamarruanganbaru = false;
    $update_pasienadmisi = false;
    $update_masukkamarlama = false;
    $delete_pindahkamar = false;
    $delete_masukkamarbaru = false;
    $update_kamarruanganlama = false;
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $user = LoginpemakaiK::model()->findByAttributes(array(
        'nama_pemakai' => $nama_pemakai,
        'loginpemakai_aktif' => TRUE
      ));
      if ($user === null) {
        $data['error'] = "Login Pemakai salah!";
        $data['cssError'] = 'username';
        $status = false;
        $pesan = 'Gagal Login';
      } else {
        // cek password
        if ($user->katakunci_pemakai !== $user->encrypt($kata_kunci)) {
          $data['error'] = 'password salah!';
          $data['cssError'] = 'password';
          $status = 'Gagal Login';
          $pesan = 'Gagal Login';
        } else {
          // cek ruangan					
          $ruangan_user = RuanganpemakaiK::model()->findByAttributes(array(
            'loginpemakai_id' => $user->loginpemakai_id,
            'ruangan_id' => $ruangan_id
          ));
          if ($ruangan_user === null) {
            $data['error'] = 'ruangan salah!';
            $status = false;
            $pesan = 'Gagal Login';
          } else {
            $data['error'] = '';
            $cek = $this->checkAccess(array('loginpemakai_id' => $user->loginpemakai_id)); //dari MyAuthController
            if ($cek) {
              $status = 'success';
              $data['userid'] = $user->loginpemakai_id;
              $data['username'] = $user->nama_pemakai;

              $transaction = Yii::app()->db->beginTransaction();
              try {
                $modPindahKamar = PindahkamarT::model()->findByPk($pindahkamar_id);
                $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPindahKamar->pasienadmisi_id);

                if (!empty($masukkamar_id)) {
                  $modMasukKamarBaru = MasukkamarT::model()->findByPk($masukkamar_id);
                }

                $criteria = new CDbCriteria();
                $criteria->addCondition('pasienadmisi_id = ' . $modPasienAdmisi->pasienadmisi_id);
                $criteria->addCondition('pindahkamar_id is NOT NULL');
                $modMasukKamarLama = MasukkamarT::model()->find($criteria);

                $update_kamarruangan = KamarruanganM::model()->updateByPk($modMasukKamarBaru->kamarruangan_id, array(
                  'kamarruangan_status' => true,
                  'keterangan_kamar' => Params::KETERANGANKAMAR_TERSEDIA
                ));

                if ($update_kamarruangan) {
                  $update_kamarruanganbaru = true;
                }

                if (!empty($modPasienAdmisi)) {
                  $modPasienAdmisi->ruangan_id = $modMasukKamarLama->ruangan_id;
                  $modPasienAdmisi->kamarruangan_id = $modMasukKamarLama->kamarruangan_id;
                  $modPasienAdmisi->shift_id = $modMasukKamarLama->shift_id;
                  $modPasienAdmisi->carabayar_id = $modMasukKamarLama->carabayar_id;
                  $modPasienAdmisi->penjamin_id = $modMasukKamarLama->penjamin_id;
                  $modPasienAdmisi->kelaspelayanan_id = $modMasukKamarLama->kelaspelayanan_id;
                  if ($modPasienAdmisi->save()) {
                    $update_pasienadmisi = true;
                  }
                }

                $update_kamarruangan_lama = KamarruanganM::model()->updateByPk($modMasukKamarLama->kamarruangan_id, array(
                  'kamarruangan_status' => false,
                  'keterangan_kamar' => Params::KETERANGANKAMAR_DIGUNAKAN
                ));

                if ($update_kamarruangan_lama) {
                  $update_kamarruangan_lama = true;
                }

                $update_masukkamarlama = MasukkamarT::model()->updateByPk($modMasukKamarLama->masukkamar_id, array(
                  'pindahkamar_id' => NULL,
                ));
                if ($update_masukkamarlama) {
                  $update_masukkamarlama = true;
                }

                $delete_pindahkamar = PindahkamarT::model()->deleteByPk($pindahkamar_id);
                if ($delete_pindahkamar) {
                  $delete_pindahkamar = true;
                }

                $delete_masukkamar = MasukkamarT::model()->deleteByPk($masukkamar_id);
                if ($delete_pindahkamar) {
                  $delete_masukkamarbaru = true;
                }

                if ($update_kamarruanganbaru && $update_pasienadmisi && $update_masukkamarlama && $delete_pindahkamar && $delete_masukkamarbaru) {
                  $success = true;
                } else {
                  $success = false;
                  $pesan = 'Data pindahan rawat intensif pasien gagal dibatalkan';
                }
                if ($success) {
                  $transaction->commit();
                  $status = true;
                  $pesan = 'Data pindahan rawat intensif pasien berhasil dibatalkan';
                } else {
                  $status = false;
                  $pesan = 'Data pindahan rawat intensif pasien gagal dibatalkan';
                  $transaction->rollback();
                  Yii::app()->user->setFlash('error', "Data gagal dibatalkan");
                }
              } catch (Exception $ex) {
                $status = false;
                $pesan = "exist";
                $transaction->rollback();
              }
            } else {
              $status = 'Tidak memiliki akses untuk melakukan pembatalan!';
            }
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

  /**
   * untuk load session masuk kamar
   */
  public function actionBuatSessionMasukKamar()
  {

    $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
    $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
    if (!empty($_POST['masukkamar_id'])) {
      $masukkamar_id = (isset($_POST['masukkamar_id']) ? $_POST['masukkamar_id'] : null);
      Yii::app()->session['masukkamar_id'] = $masukkamar_id;
    }
    Yii::app()->session['kelaspelayanan_id'] = $kelaspelayanan_id;
    Yii::app()->session['pendaftaran_id'] = $pendaftaran_id;
    Yii::app()->session['masukkamar_id'] = $masukkamar_id;

    echo CJSON::encode(array(
      'kelaspelayanan_id' => Yii::app()->session['kelaspelayanan_id'],
      'pendaftaran_id' => Yii::app()->session['pendaftaran_id'],
      'masukkamar_id' => Yii::app()->session['masukkamar_id']
    ));
  }

  /**
   * untuk load form masuk kamar pasien
   * Issue  : RND-2717
   * Date   : 24 September 2014
   */
  public function actionAddMasukKamarPI()
  {
    $pendaftaran_id = (isset(Yii::app()->session['pendaftaran_id']) ? Yii::app()->session['pendaftaran_id'] : null);
    $kamarruangan_id = (isset($_POST['kamarruangan_id']) ? $_POST['kamarruangan_id'] : null);
    $masukkamar_id = (isset(Yii::app()->session['masukkamar_id']) ? Yii::app()->session['masukkamar_id'] : null);
    $kelaspelayanan_id = (isset(Yii::app()->session['kelaspelayanan_id']) ? Yii::app()->session['kelaspelayanan_id'] : null);
    //		$ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($masukkamar_id)) {
      $modMasukKamar = MasukkamarT::model()->findByPk($masukkamar_id);
    } else {
      $modMasukKamar = new MasukkamarT();
    }
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    $ruangan_id = $modPasienAdmisi->ruangan_id;

    $modMasukKamar->ruangan_id = (isset($kamarruangan_id) ? $modMasukKamar->ruangan_id : $ruangan_id);
    $modMasukKamar->tglmasukkamar = date('Y-m-d H:i:s');
    $modMasukKamar->jammasukkamar = date('H:i:s');

    $modDataPasien = PasienrawatinapV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    if (isset($_POST['MasukkamarT'])) {
      $modMasukKamar->attributes = $_POST['MasukkamarT'];
      $modMasukKamar->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
      $modMasukKamar->carabayar_id = $modPasienAdmisi->carabayar_id;
      $modMasukKamar->penjamin_id = $modPasienAdmisi->penjamin_id;
      $modMasukKamar->pegawai_id = $modPasienAdmisi->pegawai_id;
      $modMasukKamar->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
      $modMasukKamar->nomasukkamar = MyGenerator::noMasukKamar($modMasukKamar->ruangan_id);
      $modMasukKamar->shift_id = Yii::app()->user->getState('shift_id');
      $modMasukKamar->create_time = date('Y-m-d H:i:s');
      $modMasukKamar->create_loginpemakai_id = Yii::app()->user->id;
      //			$modMasukKamar->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modMasukKamar->create_ruangan = $modMasukKamar->ruangan_id;

      $kamarruanganidupdate = isset($_POST['MasukkamarT']['kamarruangan_id']) ? $_POST['MasukkamarT']['kamarruangan_id'] : null;
      //            $cekidkamar = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
      $cekidkamar = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      if (empty($kamarruanganidupdate)) {
        PasienadmisiT::model()->updateByPk($cekidkamar->pasienadmisi_id, array('kamarruangan_id' => $kamarruanganidupdate));
        if (!empty($modDataPasien->kamarruangan_id)) {
          KamarruanganM::model()->updateByPk($modDataPasien->kamarruangan_id, array('kamarruangan_status' => true));
        }
      }
      if ($modMasukKamar->save()) {
        if (!empty($kamarruanganidupdate)) {
          KamarruanganM::model()->updateByPk($kamarruanganidupdate, array('kamarruangan_status' => false));
        }

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
    if (Yii::app()->request->isAjaxRequest) {

      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formMasukKamar', array('modMasukKamar' => $modMasukKamar, 'modDataPasien' => $modDataPasien), true)
      ));
      exit;
    }
  }

  //	public function actionBatalPindahKamar()
  //    {
  //        if (Yii::app()->request->isAjaxRequest){
  //            $idPindahKamar = $_POST['idPindahKamar'];
  //			
  //            $idMasukKamar = isset($_POST['idMasukKamar'])?$_POST['idMasukKamar']:'';
  ////			print_r($_POST);exit;
  //			
  //            $modPindahKamar = PindahkamarT::model()->findByPk($idPindahKamar);
  //            
  //            $modMasukKamarBaru = MasukkamarT::model()->findByPk($modPindahKamar->masukkamar_id);
  //            $transaction = Yii::app()->db->beginTransaction();
  //            try {
  //                $success = false;
  //                $modPasienAdmisi = PasienadmisiT::model()->findByPK($modPindahKamar->pasienadmisi_id);
  //				
  //				if($idMasukKamar != 'null'){
  //					$modMasukKamar = MasukkamarT::model()->findByPk($idMasukKamar);
  //					$modPasienAdmisi->ruangan_id = $modMasukKamar->ruangan_id;
  //					$modPasienAdmisi->kelaspelayanan_id = $modMasukKamar->kelaspelayanan_id;
  //					$modPasienAdmisi->kamarruangan_id = $modMasukKamar->kamarruangan_id;
  //					$updatePasienAdmisi = $modPasienAdmisi->save();   
  //					$modMasukKamar->pindahkamar_id = null;
  //					$updateMasukKamar = $modMasukKamar->save();
  //
  //					$updateKamar1 = KamarruanganM::model()->updateByPk($modPindahKamar->kamarruangan_id, array('kamarruangan_status'=>true));
  //					$updateKamar2 = KamarruanganM::model()->updateByPk($modPasienAdmisi->kamarruangan_id, array('kamarruangan_status'=>false));
  //
  //					$modPindahKamar->masukkamar_id = null;
  //					$modPindahKamar->save();
  //					if($updatePasienAdmisi && $updateMasukKamar ) //TIDAK PERLU DI VALIDASI >> && $updateKamar1 && $updateKamar2
  //					{
  //						 //Hapus masukkamar baru
  //						 if (isset($modMasukKamarBaru) ? $modMasukKamarBaru->delete():true){
  //							 if (isset($modPindahKamar) ? $modPindahKamar->delete():true){
  //									$success = true;
  //									echo CJSON::encode(array(
  //										   'status'=>'true',
  //										   'div'=>"<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>"
  //										   ));                       
  //							}
  //						 }
  //					}
  //				}else{
  //					$ruangan_lama = Yii::app()->user->getState('ruangan_id');
  //					$modPasienAdmisi->ruangan_id = $ruangan_lama;
  //					$updatePasienAdmisi = $modPasienAdmisi->save(); 
  //					// kondisi jika pasien belum masuk ruangan
  //					if (isset($modPindahKamar) ? $modPindahKamar->delete():true){
  //							$success = true;
  //							echo CJSON::encode(array(
  //								   'status'=>'true',
  //								   'div'=>"<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>"
  //								   ));                       
  //					}
  //				}
  //				
  //				
  //                if ($success){
  //                    $transaction->commit();
  //                }
  //                else{
  //                    $transaction->rollback();
  //                    Yii::app()->user->setFlash('error',"Data gagal disimpan");
  //                }
  //            } catch (Exception $exc) {
  //                $transaction->rollback();
  //                Yii::app()->user->setFlash('error',"Data gagal disimpan ".ExceptionMessage::getMessage($exc,true));    
  //            }
  //            Yii::app()->end();
  //        }
  //    }
}
