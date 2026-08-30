<?php

class RujukanPenunjangController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Rujukan";
    $model = new PasienkirimkeunitlainV;
    $model->tgl_awal = date('Y-m-d'); //-1 tahun
    $model->tgl_akhir = date('Y-m-d');
    $model->tgl_jadwalpemeriksaanawal = date('Y-m-d');
    $model->tgl_jadwalpemeriksaanakhir = date('Y-m-d');
    
    if (isset($_GET['PasienkirimkeunitlainV'])) {
      $model->attributes = $_GET['PasienkirimkeunitlainV'];
  
    
      if(isset($_GET['PasienkirimkeunitlainV']['tgl_awal'])) {
        $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['PasienkirimkeunitlainV']['tgl_awal']);
      }
      if(isset($_GET['PasienkirimkeunitlainV']['tgl_akhir'])) {
        $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['PasienkirimkeunitlainV']['tgl_akhir']);
      }
      $model->ceklis = isset($_GET['PasienkirimkeunitlainV']['ceklis']) ? $_GET['PasienkirimkeunitlainV']['ceklis'] : null;
      $model->ceklisJadwal = isset($_GET['PasienkirimkeunitlainV']['ceklisJadwal']) ? $_GET['PasienkirimkeunitlainV']['ceklisJadwal'] : false;
      $model->no_pendaftaran = isset($_GET['noPendaftaran']) ? $_GET['noPendaftaran'] : null;
      $model->no_rekam_medik = isset($_GET['noRekamMedik']) ? $_GET['noRekamMedik'] : null;
      $model->nama_pasien = isset($_GET['namaPasien']) ? $_GET['namaPasien'] : null;
      $model->pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
      $model->tgl_jadwalpemeriksaanawal = MyFormatter::formatDateTimeForDb($_GET['PasienkirimkeunitlainV']['tgl_jadwalpemeriksaanawal']);
      $model->tgl_jadwalpemeriksaanakhir = MyFormatter::formatDateTimeForDb($_GET['PasienkirimkeunitlainV']['tgl_jadwalpemeriksaanakhir']);

     
    }
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    $dataProvider = $model->searchRujukTindakan();

    if(Yii::app()->request->isAjaxRequest) {
      if(isset($_GET['ajax']) && $_GET['ajax'] == 'pasienpenunjangrujukan-m-grid') {
        $this->renderPartial('_table', ['dataProvider' => $dataProvider]);
        Yii::app()->end();
      }
    }

    $this->render('index', array('dataProvider' => $dataProvider,'model'=>$model));
  }
  /**
   * Fungsi untuk mengupadte hasil pemeriksaan rehab medis menset tindakanpelayanan id
   * @param type $modTindPelayanan model object
   */
  protected function upadateHasilTindakan($modTindPelayanan)
  {
    $modHasil = $this->loadById($modTindPelayanan->hasilpemeriksaanrm_id);
    $modHasil->tindakanpelayanan_id = $modTindPelayanan->tindakanpelayanan_id;
    $modHasil->save();
  }

  /**
   * Fungsi untuk mengembalikan object $model dengan method findByPk yang nanti digunakan untuk menyimpan data-data hasil pemeriksaan
   * @param type $id
   * @return type 
   */
  protected function loadById($id)
  {
    $model = HasilpemeriksaanrmT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
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

  public function actionLoadFormPemeriksaanRMPendRM()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idPemeriksaanRM = $_POST['idPemeriksaanRM'];
      $idKelasPelayanan = $_POST['kelasPelayan_id'];
      $modPeriksaRM = TindakanrmM::model()->with('jenistindakanrm')->findByPk($idPemeriksaanRM);
      $modTarif = TariftindakanM::model()->findByAttributes(array(
        'daftartindakan_id' => $modPeriksaRM->daftartindakan_id,
        'kelaspelayanan_id' => $idKelasPelayanan,
        'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL
      ));

      echo CJSON::encode(array(
        'status' => 'create_form',
        'form' => $this->renderPartial('_formLoadPemeriksaanRMPendRM', array(
          'modPeriksaRM' => $modPeriksaRM,
          'modTarif' => $modTarif,
          'idKelasPelayanan' => $idKelasPelayanan
        ), true)
      ));
      exit;
    }
  }

  public function actionLoadFormRehabMedisMasuk()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idPemeriksaanRM = $_POST['idPemeriksaanRM'];
      $idKelasPelayanan = $_POST['kelasPelayanan_id'];


      $modTindakan = TindakanrmM::model()->with('jenistindakanrm')->findByPk($idPemeriksaanRM);
      $modTarif = TariftindakanM::model()->findByAttributes(array(
        'daftartindakan_id' => $modTindakan->daftartindakan_id,
        'kelaspelayanan_id' => $idKelasPelayanan,
        'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL
      ));
      echo CJSON::encode(array(
        'status' => 'create_form',
        'form' => $this->renderPartial('_formLoadRehabMedisMasuk', array(
          'modTindakan' => $modTindakan,
          'modTarif' => $modTarif,
          'idKelasPelayanan' => $idKelasPelayanan
        ), true)
      ));
      exit;
    }
  }

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
        if (!$user->cekPassword3($password)) {
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

                    $delete_tindakanpelayanan = TindakanpelayananT::model()->deleteAllByAttributes(array(
                      'daftartindakan_id' => $detail->daftartindakan_id,
                      'pasienmasukpenunjang_id' => null
                    ));

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

  /**
   * Tambah / ubah Jadwal Tindakan
   */
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
            $kirim->tgl_jadwalpemeriksaan = MyFormatter::formatDateTimeForDb($_POST['tgl_jadwalpemeriksaan']);
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
      $models = CHtml::listData(RuanganM::getItems($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        if (count((array)$models) > 1) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionPilihTglPeriksa($pasienkirimkeunitlain_id, $pasien_id) {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modKirimKeUnitLain = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);
    $modKirimKeUnitLain->tglrencanapemeriksaan = !empty($modKirimKeUnitLain->tglrencanapemeriksaan) ? MyFormatter::formatDateTimeForUser($modKirimKeUnitLain->tglrencanapemeriksaan) : '';
    $modKirimKeUnitLain->tgl_kirimpasien = !empty($modKirimKeUnitLain->tgl_kirimpasien) ? MyFormatter::formatDateTimeForUser($modKirimKeUnitLain->tgl_kirimpasien) : '';

    $modPermintaan = TNPasienKirimKeUnitLainT::model()->findAllByPk($pasienkirimkeunitlain_id);
   
    if (isset($_POST['PasienkirimkeunitlainT'])) {
        $transaction = Yii::app()->db->beginTransaction();
        $ok = true;
        try {
          // echo '<pre>';var_dump($_POST);die;
            $arr_permintaan = array();
            
            if (isset($_POST['TNPasienKirimKeUnitLainT'])) {
              foreach ($_POST['TNPasienKirimKeUnitLainT'] as $pasienkirimkeunitlain_id => $item) {
                $tanggal = MyFormatter::formatDateTimeForDB($item['tglrencanapemeriksaan']);

                if (empty($arr_permintaan[$tanggal])) {
                  $arr_permintaan[$tanggal] = array();
                }
                $arr_permintaan[$tanggal]['dataPermintaan'][] = $pasienkirimkeunitlain_id;
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
