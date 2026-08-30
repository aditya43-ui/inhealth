<?php

class InfoKunjunganVKController extends MyAuthController
{
  public $path_view = 'pendaftaranPenjadwalan.views.infoKunjunganVK.';
  public $asuransipasientersimpan = false;

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Vk";
    $format = new MyFormatter();
    $modInfoKunjunganRDV = new PPInfoKunjunganPersalinanV;
    $modInfoKunjunganRDV->tgl_awal = date("Y-m-d");
    $modInfoKunjunganRDV->tgl_akhir = date("Y-m-d");
    $modInfoKunjunganRDV->tgl_awall = date('Y-m-d');
    $modInfoKunjunganRDV->tgl_akhirl = date('Y-m-d');
    $modInfoKunjunganRDV->ceklis = false;
    if (isset($_REQUEST['PPInfoKunjunganPersalinanV'])) {
      $modInfoKunjunganRDV->attributes = $_REQUEST['PPInfoKunjunganPersalinanV'];
      $modInfoKunjunganRDV->ceklis = $_REQUEST['PPInfoKunjunganPersalinanV']['ceklis'];
      $modInfoKunjunganRDV->rujukandari_id = $_REQUEST['PPInfoKunjunganPersalinanV']['rujukandari_id'];
      $modInfoKunjunganRDV->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganPersalinanV']['tgl_awal']);
      $modInfoKunjunganRDV->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganPersalinanV']['tgl_akhir']);
      $modInfoKunjunganRDV->tgl_awall = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganPersalinanV']['tgl_awall']);
      $modInfoKunjunganRDV->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganPersalinanV']['tgl_akhirl']);
    }
    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'modInfoKunjunganRDV' => $modInfoKunjunganRDV,
      'model' => $modInfoKunjunganRDV
    ));
  }

  //==================================Awal batal Periksa============================================================================        
  public function actionUbahPeriksa()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $statusperiksa = $_POST['statusperiksa'];
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $tglbatal = $_POST['tglbatal'];
      $keterangan_batal = $_POST['keterangan_batal'];
      //                $data['message']='Masih Dalam Pengembangan Karena TAbel dan View Belum Ada';
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modBatalPeriksa = new PasienbatalperiksaR;
      $modBatalPeriksa->pasien_id = $modPendaftaran->pasien_id;
      $modBatalPeriksa->pendaftaran_id = $pendaftaran_id;
      $modBatalPeriksa->tglbatal = $tglbatal;
      $modBatalPeriksa->keterangan_batal = $keterangan_batal;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $updatePendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_BATAL_PERIKSA));
        if ($modBatalPeriksa->save() && $updatePendaftaran) {
          $attributes = array(
            'pasienbatalperiksa_id' => $modBatalPeriksa->pasienbatalperiksa_id,
            'update_time' => date('Y-m-d H:i:s'),
            'update_loginpemakai_id' => Yii::app()->user->id,
          );
          $updatePendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);
          $transaction->commit();
          $data['message'] = 'Batal periksa berhasil dilakukan.';
          $data['success'] = true;
        } else {
          $transaction->rollback();
          $data['message'] = 'Gagal Batal Periksa! Data tidak valid.';
          $data['success'] = false;
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['message'] = 'Gagal Batal Periksa!';
      }


      echo json_encode($data);
      Yii::app()->end();
    }
  }

  //================================================Awal Print Lembar Poli============================================================
  public function actionPrintLembarPoli($pendaftaran_id)
  {
    $this->layout = '//layouts/printLembarPoli';
    $sql = "SELECT pendaftaran_t.no_pendaftaran,
                           pendaftaran_t.no_urutantri,
                           pendaftaran_t.tgl_pendaftaran,
                           pendaftaran_t.umur,
                           ruangan_m.ruangan_nama,
                           pasien_m.no_rekam_medik, 
                           penjaminpasien_m.penjamin_nama, 
                           carabayar_m.carabayar_nama, 
                           pasien_m.jeniskelamin, 
                           pasien_m.nama_pasien, 
                           pasien_m.nama_bin,
                           pasien_m.alamat_pasien, 
                           pasien_m.tanggal_lahir  
                    FROM pendaftaran_t
                    JOIN ruangan_m ON pendaftaran_t.ruangan_id = ruangan_m.ruangan_id
                    JOIN pasien_m ON pendaftaran_t.pasien_id = pasien_m.pasien_id 
                    JOIN carabayar_m ON carabayar_m.carabayar_id = pendaftaran_t.carabayar_id
                    JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pendaftaran_t.penjamin_id
                    
                    WHERE pendaftaran_t.pendaftaran_id ='$pendaftaran_id'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    //            daftartindakan_m.daftartindakan_nama
    //                                       tindakanpelayanan_t.tarif_tindakan

    //             tipepaket_m.tipepaket_nama,
    //                                LEFT JOIN pegawai_m ON pendaftaran_t.pegawai_id = pegawai_m.pegawai_id
    //            LEFT JOIN tindakanpelayanan_t ON tindakanpelayanan_t.no_pendaftaran = pendaftaran_t.no_pendaftaran 
    //                    LEFT JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = tindakanpelayanan_t.daftartindakan_id
    //                    LEFT JOIN tipepaket_m ON tipepaket_m.tipepaket_id = tindakanpelayanan_t.tipepaket_id
    // pegawai_m.nama_pegawai,
    $this->render('printLembarPoli', array(
      //'model'=>$model,
      //'noPendaftaran'=>$idx,
      'data' => $result,
    ));
  }
  //==========================================================Akhir Print Lembar Poli===================================================        

  /**
   * Action untuk mengubah kelompok penyakit
   */
  public function actionUbahKelompokPenyakit()
  {
    $model = new PPPendaftaranT;
    $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
    if (isset($_POST['PPPendaftaranT'])) {
      if ($_POST['PPPendaftaranT']['jeniskasuspenyakit_id'] != "") {
        $model->attributes = $_POST['PPPendaftaranT'];
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $attributes = array('jeniskasuspenyakit_id' => $_POST['PPPendaftaranT']['jeniskasuspenyakit_id']);
          $save = $model::model()->updateByPk($_POST['PPPendaftaranT']['pendaftaran_id'], $attributes);
          if ($save) {
            $transaction->commit();
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-success'>Berhasil merubah Kelompok Penyakit.</div>",
            ));
          } else {
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
            ));
          }
          exit;
        } catch (Exception $exc) {
          $transaction->rollback();
        }
      } else {
        echo CJSON::encode(
          array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Berhasil merubah Kelompok Penyakit.</div>",
          )
        );
        exit;
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formUbahKelompokPenyakit', array('model' => $model, 'menu' => $menu), true)
      ));
      exit;
    }
  }
  /**
   * untuk mengubah cara bayar
   */
  public function actionUbahCaraBayar()
  {
    $this->layout = 'iframe';
    $model = new UbahcarabayarR;
    $modPendaftaran = PPPendaftaranT::model()->findByPk($id);
    $modPasien = PPPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modRujukanBpjs = new PPRujukanbpjsT;
    $modAsuransiPasien = new PPAsuransipasienM;
    $modAsuransiPasienBpjs = new PPAsuransipasienbpjsM;
    $modSep = new PPSepT;

    if (isset($idSep)) {
      $modRujukanBpjs = PPRujukanbpjsT::model()->findByPk($modPendaftaran->rujukan_id);
      $modAsuransiPasienBpjs = PPAsuransipasienbpjsM::model()->findByPk($modPendaftaran->asuransipasien_id);
      $modSep = PPSepT::model()->findByPk($idSep);
    }

    if (isset($_POST['UbahcarabayarR'])) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $model->attributes = $_POST['UbahcarabayarR'];
      $model->pendaftaran_id = $_POST['pendaftaran_id'];
      $model->carabayar_id = $_POST['PPPendaftaranT']['carabayar_id'];
      $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
      $model->tglubahcarabayar = date('Y-m-d H:i:s');

      // echo "<pre>"; print_r($model->attributes);exit();
      $transaction = Yii::app()->db->beginTransaction();
      try {

        $modPendaftaran = PPPendaftaranT::model()->findByPk(
          $model->pendaftaran_id
        );

        if (isset($_POST['PPPendaftaranT'])) {
          $modPendaftaran->attributes = $_POST['PPPendaftaranT'];
        }

        $modPendaftaran->carabayar_id = $model->carabayar_id;
        $modPendaftaran->penjamin_id = $model->penjamin_id;
        if ($model->save()) {



          if (isset($_POST['PPRujukanbpjsT'])) {
            $modRujukanBpjs = $this->simpanRujukanBpjs($modRujukanBpjs, $_POST['PPRujukanbpjsT']);
          } else {
            $this->rujukantersimpan = true;
          }



          if (isset($_POST['PPAsuransipasienM'])) {
            if (isset($_POST['PPAsuransipasienM']['asuransipasien_id'])) {
              if ($_POST['PPAsuransipasienM']['asuransipasien_id'] == "") {
                $modAsuransiPasien = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienM']['asuransipasien_id']);
              }
            }
            $modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $modPendaftaran, $modPasien, $_POST['PPAsuransipasienM']);
          } else {
            $this->asuransipasientersimpan = true;
          }
          if (isset($_POST['PPAsuransipasienbpjsM'])) {
            if (isset($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])) {
              if ($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'] == "") {
                $modAsuransiPasienBpjs = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
              }
            }
            $modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $modPendaftaran, $modPasien, $_POST['PPAsuransipasienbpjsM']);
          } else {
            $this->asuransipasientersimpan = true;
          }

          if (!empty($modRujukanBpjs->rujukan_id) && !empty($modAsuransiPasienBpjs->asuransipasien_id)) {
            PPPendaftaranT::model()->updateByPk($pendaftaran_id, array('carabayar_id' => $modPendaftaran->carabayar_id, 'penjamin_id' => $modPendaftaran->penjamin_id, 'rujukan_id' => $modRujukanBpjs->rujukan_id, 'asuransipasien_id' => $modAsuransiPasienBpjs->asuransipasien_id));
          } else if (!empty($modAsuransiPasien->asuransipasien_id)) {
            PPPendaftaranT::model()->updateByPk($pendaftaran_id, array('carabayar_id' => $modPendaftaran->carabayar_id, 'penjamin_id' => $modPendaftaran->penjamin_id, 'asuransipasien_id' => $modAsuransiPasien->asuransipasien_id));
          } else {
            PPPendaftaranT::model()->updateByPk($pendaftaran_id, array('carabayar_id' => $modPendaftaran->carabayar_id, 'penjamin_id' => $modPendaftaran->penjamin_id));
          }

          if (isset($_POST['PPSepT'])) {
            $modSep = $this->simpanSep($modPendaftaran, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $_POST['PPSepT']);
          }




          $transaction->commit();

          $this->notifUbahBayar($model);

          if (isset($modSep->nosep)) {
            $this->redirect(array('ubahCaraBayar', 'id' => $model->pendaftaran_id, 'idSep' => $modSep->sep_id, 'sukses' => 1));
          } else {
            $this->redirect(array('ubahCaraBayar', 'id' => $model->pendaftaran_id, 'sukses' => 1));
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pasien gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pasien gagal disimpan !");
      }
    }

    $this->render(
      $this->path_view . '_formUbahCaraBayar',
      array(
        'model' => $model,
        'modPendaftaran' => $modPendaftaran,
        'modAsuransiPasien' => $modAsuransiPasien,
        'modAsuransiPasienBpjs' => $modAsuransiPasienBpjs,
        'modRujukanBpjs' => $modRujukanBpjs,
        'modSep' => $modSep,
      )
    );
  }
  /**
   * untuk mengubah status periksa RD
   */
  public function actionUbahStatusPeriksaVK()
  {
    $pendaftaran_id = Yii::app()->session['pendaftaran_id'];
    $format = new MyFormatter();
    $model = PPPendaftaranT::model()->findByPk($pendaftaran_id);
    $model->statusperiksa = Params::STATUSPERIKSA_BATAL_PERIKSA;
    $modBatalPeriksa = new PasienbatalperiksaR;
    $model->tglselesaiperiksa = date('Y-m-d h:i:s');
    if (isset($_POST['PPPendaftaranT'])) {
      $update = PPPendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => $_POST['PPPendaftaranT']['statusperiksa'], 'tglselesaiperiksa' => ($_POST['PPPendaftaranT']['tglselesaiperiksa'])));
      if (isset($_POST['PPPendaftaranT']['statusperiksa']) == "BATAL PERIKSA") {
        $modBatalPeriksa = new PasienbatalperiksaR;
        $modBatalPeriksa->pendaftaran_id = $pendaftaran_id;
        $modBatalPeriksa->pasien_id = $model->pasien_id;
        $modBatalPeriksa->tglbatal = $format->formatDateTimeForDb($_POST['PasienbatalperiksaR']['tglbatal']);
        $modBatalPeriksa->keterangan_batal = $_POST['PasienbatalperiksaR']['keterangan_batal'];
        $modBatalPeriksa->create_time = date('Y-m-d');
        $modBatalPeriksa->update_time = date('Y-m-d');
        $modBatalPeriksa->create_loginpemakai_id = Yii::app()->user->id;
        $modBatalPeriksa->update_loginpemakai_id = Yii::app()->user->id;
        $modBatalPeriksa->create_ruangan = Yii::app()->user->getState('ruangan_id');

        if ($modBatalPeriksa->validate()) {
          if ($modBatalPeriksa->save()) {
            PPPendaftaranT::model()->updateByPk($pendaftaran_id, array('pasienbatalperiksa_id' => $modBatalPeriksa->pasienbatalperiksa_id));
          }
        }
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
          ));
          exit;
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

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_ubahStatusPeriksa', array('model' => $model, 'modBatalPeriksa' => $modBatalPeriksa), true)
      ));
      exit;
    }
  }


  public function actionUbahKelasPelayanan()
  {
    $model = new PendaftaranT;
    $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
    if (isset($_POST['PendaftaranT'])) {
      if ($_POST['PendaftaranT']['kelaspelayanan_id'] != "") {
        $model->attributes = $_POST['PendaftaranT'];
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $attributes = array('kelaspelayanan_id' => $_POST['PendaftaranT']['kelaspelayanan_id']);
          $save = $model::model()->updateByPk($_POST['PendaftaranT']['pendaftaran_id'], $attributes);
          if ($save) {
            $transaction->commit();
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-success'>Berhasil merubah Kelas Pelayanan.</div>",
            ));
          } else {
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
            ));
          }
          exit;
        } catch (Exception $exc) {
          $transaction->rollback();
        }
      } else {
        echo CJSON::encode(
          array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Berhasil merubah data Kelas Pelayanan.</div>",
          )
        );
        exit;
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial($this->path_view . '_formUbahKelasPelayananRJ', array('model' => $model, 'menu' => $menu), true)
      ));
      exit;
    }
  }

  /*
         * Mencari kelas pelayanan berdasarkan ruangan_id di tabel KelasruanganM
         * and open the template in the editor.
         */
  public function actionSetDropdownKelasPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      if ($ruangan_id) {
        $kelasPelayanan = KelasruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id=' . $ruangan_id . ' and kelaspelayanan_aktif = true');
        $kelasPelayanan = CHtml::listData($kelasPelayanan, 'kelaspelayanan_id', 'kelaspelayanan.kelaspelayanan_nama');
      }
      if (empty($kelasPelayanan)) {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        foreach ($kelasPelayanan as $value => $name) {
          echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
    }
    Yii::app()->end();
  }

  public function actionGetListCaraBayar()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $idCaraBayar = $_POST['idCaraBayar'];

      $carabayars = CarabayarM::model()->findAllByAttributes(array('carabayar_aktif' => true), array('order' => 'carabayar_nama'));
      $carabayars = CHtml::listData($carabayars, 'carabayar_id', 'carabayar_nama');
      $Option = "";
      foreach ($carabayars as $value => $name) {
        if ($value == $idCaraBayar)
          $Option .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $Option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      $dataList['listCaraBayar'] = $Option;

      $penjamins = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $idCaraBayar, 'penjamin_aktif' => true), array('order' => 'penjamin_nama'));
      $penjamins = CHtml::listData($penjamins, 'penjamin_id', 'penjamin_nama');
      $Option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      foreach ($penjamins as $value => $name) {
        if ($value == $idCaraBayar)
          $Option .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $Option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      $dataList['listPenjamin'] = $Option;

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  public function actionGetDataPendaftaranRI()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id_pendaftaran = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $model = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $id_pendaftaran));
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      echo json_encode($returnVal);
      Yii::app()->end();
    }
  }

  public function actionGetListPenjamin()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $idCaraBayar = $_POST['idCaraBayar'];
      $idPenjamin = (isset($_POST['idPenjamin'])) ? $_POST['idPenjamin'] : '';

      $penjamins = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $idCaraBayar, 'penjamin_aktif' => true), array('order' => 'penjamin_nama'));
      $penjamins = CHtml::listData($penjamins, 'penjamin_id', 'penjamin_nama');
      $Option = "";
      foreach ($penjamins as $value => $name) {
        if ($value == $idPenjamin)
          $Option .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $Option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      $dataList['listPenjamin'] = $Option;

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  public function actionUbahKeteranganPendaftaran()
  {
    $model = new PendaftaranT;
    if (isset($_POST['PendaftaranT'])) {
      if ($_POST['PendaftaranT']['keterangan_pendaftaran'] != "") {
        $model->attributes = $_POST['PendaftaranT'];
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $attributes = array('keterangan_pendaftaran' => $_POST['PendaftaranT']['keterangan_pendaftaran']);
          $save = $model::model()->updateByPk($_POST['PendaftaranT']['pendaftaran_id'], $attributes);
          if ($save) {
            $transaction->commit();
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-success'>Berhasil merubah Keterangan Pendaftaran.</div>",
            ));
          } else {
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
            ));
          }
          exit;
        } catch (Exception $exc) {
          $transaction->rollback();
        }
      } else {
        echo CJSON::encode(
          array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Berhasil merubah data Keterangan Pendaftaran.</div>",
          )
        );
        exit;
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial($this->path_view . '_formUbahKeterangan', array('model' => $model), true)
      ));
      exit;
    }
  }

  public function actionGetDataPendaftaranVK()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id_pendaftaran = $_POST['pendaftaran_id'];
      $model = InfokunjunganpersalinanV::model()->findByAttributes(array('pendaftaran_id' => $id_pendaftaran));
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal['gelardepan'] = (empty($model->gelardepan) ? "" : $model->gelardepan);
      $returnVal['dokter'] = $model->nama_pegawai;
      $returnVal['gelarbelakang_nama'] = (empty($model->gelarbelakang_nama) ? "" : $model->gelarbelakang_nama);
      echo json_encode($returnVal);
      Yii::app()->end();
    }
  }

  /**
   * untuk load data dokter di Informasi Kunjungan Rawat Jalan
   */
  public function actionGetDataPendaftaranRJ()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id_pendaftaran = $_POST['pendaftaran_id'];
      $model = InfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id' => $id_pendaftaran));
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["no_pendaftaran"] = $model->no_pendaftaran;
      $returnVal["pendaftaran_id"] = $model->pendaftaran_id;
      $returnVal["gelardepan"] = (isset($model->gelardepan) ? $model->gelardepan : "");
      $returnVal["gelarbelakang_nama"] = (isset($model->gelarbelakang_nama) ? $model->gelarbelakang_nama : "");
      echo json_encode($returnVal);
      Yii::app()->end();
    }
  }

  public function actionGetKasusPenyakit()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['id_ruangan'];
      $jenisKasusPenyakit = array();
      if (!empty($ruangan_id)) {
        $sql = "SELECT jeniskasuspenyakit_m.jeniskasuspenyakit_id, jeniskasuspenyakit_m.jeniskasuspenyakit_nama 
							FROM jeniskasuspenyakit_m
							JOIN kasuspenyakitruangan_m ON jeniskasuspenyakit_m.jeniskasuspenyakit_id = kasuspenyakitruangan_m.jeniskasuspenyakit_id
							JOIN ruangan_m ON kasuspenyakitruangan_m.ruangan_id = ruangan_m.ruangan_id
							WHERE ruangan_m.ruangan_id = '$ruangan_id'
							ORDER BY jeniskasuspenyakit_m.jeniskasuspenyakit_nama ASC";
        $modJenKasusPenyakit = JeniskasuspenyakitM::model()->findAllBySql($sql);

        $jenisKasusPenyakit = CHtml::listData($modJenKasusPenyakit, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');
      }
      if (empty($jenisKasusPenyakit)) {
        $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      } else {
        $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        foreach ($jenisKasusPenyakit as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['listPenyakit'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  public function actionGetRuanganPasienVK()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
      $instalasi_id = (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
      $pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null);
      $jenisKasusPenyakit = null;
      if (isset($_POST['jeniskasuspenyakit_id'])) {
        $jeniskasuspenyakit_id = (isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null);
        $criteria = new CDbCriteria;
        $criteria->select = 't.ruangan_id, t.jeniskasuspenyakit_id, ruangan_m.ruangan_nama, jeniskasuspenyakit_m.jeniskasuspenyakit_nama,
										jeniskasuspenyakit_aktif';
        if (!empty($ruangan_id)) {
          $criteria->addCondition("t.ruangan_id = " . $ruangan_id);
        }
        if (!empty($jeniskasuspenyakit_id)) {
          $criteria->addCondition("t.jeniskasuspenyakit_id = " . $jeniskasuspenyakit_id);
        }
        $criteria->addCondition('jeniskasuspenyakit_m.jeniskasuspenyakit_aktif is true');
        $criteria->join = 'LEFT JOIN ruangan_m on t.ruangan_id = ruangan_m.ruangan_id
									   LEFT JOIN jeniskasuspenyakit_m on t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id
										';
        $dataJenisPenyakit = KasuspenyakitruanganM::model()->findAll($criteria);
        //                $dataJenisPenyakit =KasuspenyakitruanganM::model()->findAll('jeniskasuspenyakit_id='.$jeniskasuspenyakit_id.' AND jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama');

        foreach ($dataJenisPenyakit as $jenisPenyakit) {
          if ($jenisPenyakit['jeniskasuspenyakit_id'] == $jeniskasuspenyakit_id) {
            $jenisKasusPenyakit .= '<option value="' . $jenisPenyakit['jeniskasuspenyakit_id'] . '" selected="selected">' . $jenisPenyakit['jeniskasuspenyakit_nama'] . '</option>';
          } else {
            $jenisKasusPenyakit .= '<option value="' . $jenisPenyakit['jeniskasuspenyakit_id'] . '">' . $jenisPenyakit['jeniskasuspenyakit_nama'] . '</option>';
          }
        }
        $data['jenisKasusPenyakit'] = $jenisKasusPenyakit;
      }

      if (isset($_POST['pegawai_id'])) {
        $dokter = null;
        $pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null);
        $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
        $criteria = new CDbCriteria;
        $criteria->select = 't.ruangan_id, t.pegawai_id, t.nama_pegawai';
        if (!empty($ruangan_id)) {
          $criteria->addCondition("t.ruangan_id = " . $ruangan_id);
        }
        if (!empty($jeniskasuspenyakit_id)) {
          $criteria->addCondition("t.pegawai_id = " . $pegawai_id);
        }
        $dataDokter = DokterV::model()->findAll($criteria);
        //                $dataJenisPenyakit =KasuspenyakitruanganM::model()->findAll('jeniskasuspenyakit_id='.$jeniskasuspenyakit_id.' AND jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama');

        foreach ($dataDokter as $dokters) {
          if ($dokters['pegawai_id'] == $pegawai_id) {
            $dokter .= '<option value="' . $dokters['pegawai_id'] . '" selected="selected">' . $dokters['nama_pegawai'] . '</option>';
          } else {
            $dokter .= '<option value="' . $dokters['pegawai_id'] . '">' . $dokters['nama_pegawai'] . '</option>';
          }
        }
        $data['dokter'] = $dokter;
      }

      $dropDown = '';
      $criteria2 = new CDbCriteria;
      $criteria2->select = 't.ruangan_id, t.instalasi_id, ruangan_m.ruangan_nama, instalasi_m.instalasi_nama,
										ruangan_m.ruangan_aktif';
      //					if(!empty($instalasi_id)){$criteria->addCondition("t.instalasi_id = ".$instalasi_id); }
      $criteria2->addCondition('t.instalasi_id in (3,14)');
      //                if(!empty($ruangan_id)){
      //						$criteria->addCondition("t.ruangan_id = ".$ruangan_id);
      //                }
      $criteria2->addCondition('ruangan_m.ruangan_aktif is true');
      $criteria2->join = 'LEFT JOIN ruangan_m on t.ruangan_id = ruangan_m.ruangan_id
									   LEFT JOIN instalasi_m on t.instalasi_id = instalasi_m.instalasi_id
										';
      $dataRuangan = InstalasipenddaruratV::model()->findAll($criteria2);
      //            $dataRuangan =InstalasipenddaruratV::model()->findAll('instalasi_id='.$instalasi_id.' AND ruangan_aktif=TRUE ORDER BY ruangan_nama');
      foreach ($dataRuangan as $tampilRuangan) {
        if ($tampilRuangan['ruangan_id'] == $ruangan_id) {
          $dropDown .= '<option value="' . $tampilRuangan['ruangan_id'] . '" selected="selected" onchange="getKasusPenyakit(' . $ruangan_id . ')">' . $tampilRuangan['ruangan_nama'] . '</option>';
        } else {
          $dropDown .= '<option value="' . $tampilRuangan['ruangan_id'] . '" onchange="return getKasusPenyakit(' . $ruangan_id . ')">' . $tampilRuangan['ruangan_nama'] . '</option>';
        }
      }
      $data['dropDown'] = $dropDown;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * method untuk pindah ruangan poli klinik
   * digunakan di :
   * 1. Pendaftaran Penjadwalan -> informasi Rawat Jalan -> poliklinik
   * 2. Pendaftaran Penjadwalan -> informasi Rawat Darurat -> rawat darurat
   * 3. Pendaftaran Penjadwalan -> informasi Rawat Inap -> ruangan
   */
  /**
   * untuk merubah ruangan  (copy dari InfoKunjunganRJ)
   */
  public function actionUbahRuangan()
  {
    $updatetindakan = false;
    parse_str($_POST['post'], $post);
    $model = PendaftaranT::model()->findByPk($post['pendaftaran_id']);
    $data = array();
    $data['sukses'] = 0;
    $data['pesan'] = "Data perubahan ruangan gagal disimpan! ";
    $transaction = Yii::app()->db->beginTransaction();
    try {
      $sukses = false;
      $modRiwayat = new UbahruanganR;
      $modRiwayat->ruanganawal_id = $model->ruangan_id;
      $modRiwayat->menjadiruangan_id = $post['ruangan_id_ganti'];
      $modRiwayat->alasanperubahan = $post['alasanperubahan'];
      $modRiwayat->pendaftaran_id = $model->pendaftaran_id;
      $modRiwayat->tglperubahan = date('Y-m-d H:i:s');
      $modRiwayat->pasien_id = $model->pasien_id;
      if ($modRiwayat->validate()) {
        if ($modRiwayat->save()) {
          $sukses = true;
        }
        $model->ruangan_id = $post['ruangan_id_ganti'];
        $model->jeniskasuspenyakit_id = $post['jeniskasuspenyakit_id_ganti'];
        $model->pegawai_id = $post['pegawai_id_ganti'];
        $model->no_urutantri = MyGenerator::noAntrianJanjiPoli($model->ruangan_id);
        if ($model->update()) {
          $sukses &= true;
          if (isset($post['is_ubahkarcis'])) { //checked
            $tindakanpelayanan = TindakanpelayananT::model()->findAllByAttributes(array('pendaftaran_id' => $model->pendaftaran_id), "karcis_id IS NULL");
            if (count((array)$tindakanpelayanan) > 0) {
              $data['pesan'] = "Data perubahan ruangan gagal disimpan! Pendaftaran ini sudah pernah input tindakan!";
            } else {
              if (!empty($model->karcis_id)) {
                $karcis_id_hapus = $model->karcis_id;
                $model->karcis_id = null;
                $model->update();
                TindakanpelayananT::model()->deleteAllByAttributes(array('pendaftaran_id' => $model->pendaftaran_id, 'karcis_id' => $karcis_id_hapus));
              }
              $modTindakan = new TindakanpelayananT;
              $modTindakan->attributes = $model->attributes;
              $modTindakan->tgl_tindakan = date("Y-m-d H:i:s");
              $modTindakan->karcis_id = $post['TindakanpelayananT']['idKarcis'];
              $modTindakan->daftartindakan_id = $post['TindakanpelayananT']['idTindakan'];
              $modTindakan->tarif_satuan = $post['TindakanpelayananT']['tarifSatuan'];
              $modTindakan->qty_tindakan = 1;
              $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
              $modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;
              $modTindakan->cyto_tindakan = (!empty($modTindakan->cyto_tindakan) ? $modTindakan->cyto_tindakan : 0);
              $modTindakan->tarifcyto_tindakan = ($modTindakan->cyto_tindakan ? ($modTindakan->tarifcyto_tindakan > 0 ? $modTindakan->tarifcyto_tindakan : 0) : 0);
              $modTindakan->discount_tindakan = 0;
              $modTindakan->tipepaket_id = $this->tipePaketKarcis($model, $modTindakan);
              $modTindakan->subsidiasuransi_tindakan = 0;
              $modTindakan->subsidipemerintah_tindakan = 0;
              $modTindakan->subsisidirumahsakit_tindakan = 0;
              $modTindakan->iurbiaya_tindakan = 0;
              $modTindakan->create_time = date("Y-m-d H:i:s");
              $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
              $modTindakan->validate();
              if ($modTindakan->validate()) {
                $modTindakan->save();
                $model->karcis_id = $modTindakan->karcis_id;
                $model->update();
                $sukses &= true;
              } else {
                $data['pesan'] = "Data karcis gagal disimpan!";
                $sukses &= false;
              }
            }
          }
        } else {
          $sukses &= false;
        }
      }

      if ($sukses) {
        $data['sukses'] = 1;
        $data['pesan'] = "Data perubahan ruangan / poliklinik berhasil disimpan!";
        $transaction->commit();
      } else {
        $transaction->rollback();
      }
    } catch (Exception $exc) {
      $data['pesan'] = 'Gagal Disimpan! ' . $exc;
      $transaction->rollback();
    }

    echo CJSON::encode($data);
    Yii::app()->end();
  }

  public function tipePaketKarcis($model, $karcis)
  {
    $criteria = new CDbCriteria;

    $daftartindakan_id = (isset($karcis->daftartindakan_id) ? $karcis->daftartindakan_id : null);
    $criteria->with = array('tipepaket');
    if (!empty($daftartindakan_id)) {
      $criteria->addCondition("daftartindakan_id = " . $daftartindakan_id);
    }
    if (!empty($model->carabayar_id)) {
      $criteria->addCondition("tipepaket.carabayar_id = " . $model->carabayar_id);
    }
    if (!empty($model->penjamin_id)) {
      $criteria->addCondition("tipepaket.penjamin_id = " . $model->penjamin_id);
    }
    if (!empty($model->kelaspelayanan_id)) {
      $criteria->addCondition("tipepaket.kelaspelayanan_id = " . $model->kelaspelayanan_id);
    }
    $result = Params::TIPEPAKET_ID_NONPAKET;
    $paket = PaketpelayananM::model()->find($criteria);
    if (isset($paket->tipepaket_id)) $result = $paket->tipepaket_id;

    return $result;
  }

  public function actionUbahJenisKelamin()
  {
    $model = new PasienM;
    if (isset($_POST['PasienM'])) {
      $model->attributes = $_POST['PasienM'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $attributes = array('jeniskelamin' => $_POST['PasienM']['jeniskelamin']);
        $save = PasienM::model()->updateByPk($_POST['PasienM']['pasien_id'], $attributes);
        if ($save) {
          $transaction->commit();
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Berhasil merubah data Jenis Kelamin Pasien.</div>",
          ));
        } else {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
          ));
        }
        exit;
      } catch (Exception $exc) {
        $transaction->rollback();
      }
    }

    if (Yii::app()->request->isAjaxRequest) {

      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formUbahJenisKelamin', array('model' => $model), true)
      ));
      exit;
    }
  }

  public function actionUbahDokterPeriksa()
  {
    $model = new PPPendaftaranT;
    $modUbahDokter = new PPUbahdokterR;
    $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
    if (isset($_POST['PPPendaftaranT'])) {
      if ($_POST['PPPendaftaranT']['pegawai_id'] != "") {
        $model->attributes = $_POST['PPPendaftaranT'];
        $modUbahDokter->attributes = $_POST['PPUbahdokterR'];
        $modUbahDokter->pendaftaran_id = $_POST['PPPendaftaranT']['pendaftaran_id'];
        $modUbahDokter->dokterbaru_id = $_POST['PPPendaftaranT']['pegawai_id'];
        $modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
        $modUbahDokter->create_time = date('Y-m-d H:i:s');
        $modUbahDokter->create_loginpemakai_id = Yii::app()->user->id;
        $modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $attributes = array('pegawai_id' => $_POST['PPPendaftaranT']['pegawai_id']);
          $save = $model::model()->updateByPk($_POST['PPPendaftaranT']['pendaftaran_id'], $attributes);
          if ($save) {
            $modUbahDokter->save();
            $transaction->commit();
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
            ));
          } else {
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
            ));
          }
          exit;
        } catch (Exception $exc) {
          $transaction->rollback();
        }
      } else {
        echo CJSON::encode(
          array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
          )
        );
        exit;
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial($this->path_view . '_formUbahDokterPeriksa', array('model' => $model, 'menu' => $menu, 'modUbahDokter' => $modUbahDokter), true)
      ));
      exit;
    }
  }

  public function actionListDokterRuangan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $idPegawai = null;
      if (isset($_POST['idPegawai'])) $idPegawai = $_POST['idPegawai'];
      if (!empty($_POST['idRuangan'])) {
        $idRuangan = $_POST['idRuangan'];
        $data = DokterV::model()->findAllByAttributes(array('ruangan_id' => $idRuangan), array('order' => 'nama_pegawai'));
        $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');

        if (empty($data)) {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($data as $value => $name) {
            if ($value == $idPegawai) continue;
            $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }

        $dataList['listDokter'] = $option;
      } else {
        $dataList['listDokter'] = $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      }

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  public function actionBuatSessionUbahStatus()
  {
    $pendaftaran_id = $_POST['pendaftaran_id'];
    if (!empty($_POST['pendaftaran_id'])) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      Yii::app()->session['pendaftaran_id'] = $pendaftaran_id;
    }
    Yii::app()->session['pendaftaran_id'] =  $pendaftaran_id;
    echo CJSON::encode(array(
      'pendaftaran_id' => Yii::app()->session['pendaftaran_id']
    ));
  }

  /**
   * Mengatur dropdown kabupaten
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKabupaten($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new PPPasienM;
      if ($model_nama !== '' && $attr == '') {
        $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $propinsi_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $propinsi_id = $_POST["$model_nama"]["$attr"];
      }
      $kabupaten = null;
      if ($propinsi_id) {
        $kabupaten = $modPasien->getKabupatenItems($propinsi_id);
        $kabupaten = CHtml::listData($kabupaten, 'kabupaten_id', 'kabupaten_nama');
      }
      if ($encode) {
        echo CJSON::encode($kabupaten);
      } else {
        if (empty($kabupaten)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kabupaten as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  /**
   * Mengatur dropdown kecamatan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKecamatan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new PPPasienM;
      if ($model_nama !== '' && $attr == '') {
        $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kabupaten_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kabupaten_id = $_POST["$model_nama"]["$attr"];
      }
      $kecamatan = null;
      if ($kabupaten_id) {
        $kecamatan = $modPasien->getKecamatanItems($kabupaten_id);
        $kecamatan = CHtml::listData($kecamatan, 'kecamatan_id', 'kecamatan_nama');
      }

      if ($encode) {
        echo CJSON::encode($kecamatan);
      } else {
        if (empty($kecamatan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kecamatan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  /**
   * Mengatur dropdown kelurahan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKelurahan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new PPPasienM;
      if ($model_nama !== '' && $attr == '') {
        $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kecamatan_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kecamatan_id = $_POST["$model_nama"]["$attr"];
      }
      $kelurahan = null;
      if ($kecamatan_id) {
        $kelurahan = $modPasien->getKelurahanItems($kecamatan_id);
        //                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
        $kelurahan = CHtml::listData($kelurahan, 'kelurahan_id', 'kelurahan_nama');
      }

      if ($encode) {
        echo CJSON::encode($kelurahan);
      } else {
        if (empty($kelurahan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kelurahan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  /**
   * set dropdown daerah pasien berdasarkan
   * propinsi_id
   * kabupaten_id
   * kecamatan_id
   * kelurahan_id
   * pasien_id
   */
  public function actionSetDropdownDaerahPasien()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $modPasien = new PPPasienM;
      $propinsi_id = $_POST['propinsi_id'];
      $kabupaten_id = $_POST['kabupaten_id'];
      $kecamatan_id = $_POST['kecamatan_id'];
      $kelurahan_id = (isset($_POST['kelurahan_id']) ? $_POST['kelurahan_id'] : null);

      $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE');
      $propinsis = CHtml::listData($propinsis, 'propinsi_id', 'propinsi_nama');
      $propinsiOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($propinsis as $value => $name) {
        if ($value == $propinsi_id)
          $propinsiOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $propinsiOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kabupatens = $modPasien->getKabupatenItems($propinsi_id);
      //                $kabupatens = KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true,));
      $kabupatens = CHtml::listData($kabupatens, 'kabupaten_id', 'kabupaten_nama');
      $kabupatenOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kabupatens as $value => $name) {
        if ($value == $kabupaten_id)
          $kabupatenOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kabupatenOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kecamatans = $modPasien->getKecamatanItems($kabupaten_id);
      //                $kecamatans = KecamatanM::model()->findAllByAttributes(array('kabupaten_id'=>$kabupaten_id,'kecamatan_aktif'=>true,));
      $kecamatans = CHtml::listData($kecamatans, 'kecamatan_id', 'kecamatan_nama');
      $kecamatanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kecamatans as $value => $name) {
        if ($value == $kecamatan_id)
          $kecamatanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kecamatanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kelurahans = $modPasien->getKelurahanItems($kecamatan_id);
      $kelurahans = CHtml::listData($kelurahans, 'kelurahan_id', 'kelurahan_nama');
      $kelurahanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kelurahans as $value => $name) {
        if ($value == $kelurahan_id)
          $kelurahanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kelurahanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      $dataList['listPropinsi'] = $propinsiOption;
      $dataList['listKabupaten'] = $kabupatenOption;
      $dataList['listKecamatan'] = $kecamatanOption;
      $dataList['listKelurahan'] = $kelurahanOption;

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  public function actionGetPenjaminPasien($encode = false, $namaModel = '')
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

  /**
   * menampilkan karcis (copy dari InfoKunjunganRJ)
   */
  public function actionListKarcis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $kelasPelayanan = $_POST['kelasPelayanan'];
      $ruangan = $_POST['ruangan'];
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $modPendaftaran =  PendaftaranT::model()->findByPk($pendaftaran_id);
      $penjamin_id = $modPendaftaran->penjamin_id;
      //                $penjamin_id=$_POST['penjamin_id'];
      $modelKarcis = null;
      $form = '';
      if (!empty($ruangan)) {
        $karcis = Yii::app()->user->getState('karcisbarulama');
        if ($karcis) {
          $pasienLama = (isset($_POST['pasienLama']) ? (($_POST['pasienLama'] > 0) ? false : true) : false);
          $modelKarcis = KarcisV::model()->findByAttributes(array('penjamin_id' => $penjamin_id, "kelaspelayanan_id" => $kelasPelayanan, "ruangan_id" => $ruangan, 'pasienbaru_karcis' => $pasienLama));
        } else {
          $modelKarcis = KarcisV::model()->findByAttributes(array('penjamin_id' => $penjamin_id, "kelaspelayanan_id" => $kelasPelayanan, "ruangan_id" => $ruangan));
        }
        $modKarcisV = KarcisV::model()->findAll('kelaspelayanan_id=' . $kelasPelayanan . ' AND ruangan_id=' . $ruangan . ' AND penjamin_id=' . $penjamin_id . '');
        foreach ($modKarcisV as $tampil) {
          if ($karcis) {
            if ($ruangan == Params::RUANGAN_ID_LAB) {
              $form .= '<tr>
                                        <td><a data-karcis="' . $tampil['karcis_id'] . '"id="selectPasien" class="btn-small" href="javascript:void(0);" onclick="changeBackground(this,' . $tampil['daftartindakan_id'] . ',' . $tampil['harga_tariftindakan'] . ',' . $tampil['karcis_id'] . ');return false;">
                                            <i class="icon-form-check"></i>
                                            </a></td>                                    
                                        <td>' . $tampil['karcis_nama'] . '</td>
                                        <td>' . CHtml::hiddenField('tarifKarcis', $tampil['harga_tariftindakan']) . $tampil['harga_tariftindakan'] . '</td>
                                     </tr>';
            } else if ($ruangan == Params::RUANGAN_ID_RAD) {
              $form .= '<tr>
                                        <td><a data-karcis="' . $tampil['karcis_id'] . '"id="selectPasien" class="btn-small" href="javascript:void(0);" onclick="changeBackground(this,' . $tampil['daftartindakan_id'] . ',' . $tampil['harga_tariftindakan'] . ',' . $tampil['karcis_id'] . ');return false;">
                                            <i class="icon-form-check"></i>
                                            </a></td>                                    
                                        <td>' . $tampil['karcis_nama'] . '</td>
                                        <td>' . CHtml::hiddenField('tarifKarcis', $tampil['harga_tariftindakan']) . $tampil['harga_tariftindakan'] . '</td>
                                     </tr>';
            } else {
              //                                if (in_array($tampil['karcis_id'], $karcisM))
              //                                {
              $form .= '<tr>
                                            <td>' . $tampil['karcis_nama'] . '</td>
                                            <td>' . CHtml::hiddenField('tarifKarcis', $tampil['harga_tariftindakan']) . $tampil['harga_tariftindakan'] . '</td>
                                            <td><a data-karcis="' . $tampil['karcis_id'] . '"id="selectPasien" class="btn-small" href="javascript:void(0);" onclick="changeBackground(this,' . $tampil['daftartindakan_id'] . ',' . $tampil['harga_tariftindakan'] . ',' . $tampil['karcis_id'] . ');return false;">
                                                <i class="icon-form-check"></i>
                                                </a></td>    
                                         </tr>';
              //                                }                                
            }
          } else {
            $form .= '<tr>
                                    <td>' . $tampil['karcis_nama'] . '</td>
                                    <td>' . $tampil['harga_tariftindakan'] . '</td>
                                    <td><a data-karcis="' . $tampil['karcis_id'] . '"id="selectPasien" class="btn-small" href="javascript:void(0);" onclick="changeBackground(this,' . $tampil['daftartindakan_id'] . ',' . $tampil['harga_tariftindakan'] . ',' . $tampil['karcis_id'] . ');return false;">
                                        <i class="icon-form-check"></i>
                                        </a></td>    
                                 </tr>';
          }
        }
      }
      $data['karcis'] = (!empty($modelKarcis)) ? ((isset($modelKarcis->attributes)) ? $modelKarcis->attributes : 0) : 0;
      $data['form'] = $form;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
  public function simpanAsuransiPasien($modAsuransiPasien, $postPendaftaran, $postPasien, $postAsuransiPasien)
  {
    $format = new MyFormatter();
    $modAsuransiPasien->attributes = $postAsuransiPasien;
    $modAsuransiPasien->pasien_id = isset($postPasien['pasien_id']) ? $postPasien['pasien_id'] : null;
    $modAsuransiPasien->penjamin_id = isset($postPendaftaran['penjamin_id']) ? $postPendaftaran['penjamin_id'] : null;
    $modAsuransiPasien->carabayar_id = isset($postPendaftaran['carabayar_id']) ? $postPendaftaran['carabayar_id'] : null;
    $modAsuransiPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modAsuransiPasien->create_time = date("Y-m-d H:i:s");
    $modAsuransiPasien->tgl_konfirmasi = $format->formatDateTimeForDb($modAsuransiPasien->tgl_konfirmasi);

    if (empty($modAsuransiPasien->nopeserta)) $modAsuransiPasien->nopeserta = $modAsuransiPasien->nokartuasuransi;

    if ($modAsuransiPasien->save()) {
      $this->asuransipasientersimpan = true;
    }
    return $modAsuransiPasien;
  }

  public function actionCariPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $noRM = (isset($_POST['norekammedik']) ? $_POST['norekammedik'] : null);

      $model = PasienM::model()->findByAttributes(array('no_rekam_medik' => $noRM));
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }

      echo json_encode($returnVal);
      Yii::app()->end();
    }
  }

  /**
   * @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * 
   * - digunakan untuk membuat notifikasi, jika ada perubahan cara bayar
   * @param type $model
   * @return type
   */
  public function notifUbahBayar($model)
  {

    $judul = 'Perubahan Jenis Penjamin & Penjamin';

    $isi = $model->no_pendaftaran . ' ' . $model->pasien->no_rekam_medik . ' ' . $model->pasien->nama_pasien;
    $r = RuanganM::model()->findByPk($model->ruangan_id);

    return CustomFunction::broadcastNotif($judul, $isi, array(
      //array('instalasi_id'=>Params::INSTALASI_ID_KEUANGAN, 'ruangan_id'=> Params::RUANGAN_ID_KASIR, 'modul_id'=>Params::MODUL_ID_BILLINGKASIR ),											   
      array('instalasi_id' => $r->instalasi_id, 'ruangan_id' => $r->ruangan_id, 'modul_id' => $r->modul_id),
    ));
  }

  public function actionAkadIjarah($pendaftaran_id){
        
    $this->layout = '//layouts/iframe';
   
    // if (empty($pasienadmisi_id) || $pasienadmisi_id == "undefined"){
    //     echo 'pasien bukan pasien rawat inap';exit;
    // }
    $format = new MyFormatter;
    $model = new SuratakadijarahT;
    $modAdmisi = PPInfoKunjunganPersalinanV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));   
    $modDaftar = PendaftaranT::model()->findByPk($pendaftaran_id);     
    $modPasien = PasienM::model()->findByPk($modDaftar->pasien_id);
   
    
    $cek = SuratakadijarahT::model()->findByAttributes([
       'pendaftaran_id' => $modDaftar->pendaftaran_id 
    ]);
    if (!empty($cek)){
        $model = $cek;
        $model->rencana_uangmuka = $format->formatNumberForPrint($model->rencana_uangmuka);
        $model->tambah_uangmuka = $format->formatNumberForPrint($model->tambah_uangmuka);
    }
            
    $model->nama_pasien = $modPasien->nama_pasien;
    $pecah = (explode(' ',$modDaftar->umur));
    $model->umur_pasien = $pecah[0].' tahun';
    $model->jeniskelamin = $modPasien->jeniskelamin;
    $model->alamat_pasien = $modPasien->alamat_pasien;
    $model->jenisidentitas = $modPasien->jenisidentitas;
    $model->no_identitas_pasien = $modPasien->no_identitas_pasien;
    $model->tgl_masuk = $format->formatDateTimeForUser($modDaftar->tgl_pendaftaran);
    $model->no_rekam_medik = $modPasien->no_rekam_medik;
    $model->no_identitas_pasien = $modPasien->no_identitas_pasien;
    $model->noteleponpasien = !empty($modPasien->no_telepon_pasien)?$modPasien->no_telepon_pasien:$modPasien->no_mobile_pasien;
    
    $model->carabayar_nama = $modAdmisi->carabayar_nama;
    $model->kelaspelayanan_nama = $modAdmisi->kelaspelayanan_nama;
    $model->ruangan_nama = $modAdmisi->ruangan_nama;
    $model->kamarruangan_nama = '-';
    $model->doktermerawat = $modAdmisi->namaDokter;
    $model->tgl_tambahuangmuka = date("Y-m-d", strtotime($modAdmisi->tgladmisi.'+2 hours'));
    $model->catatanpenting = 'Catatan penting : ACC TINDAKAN CEK LAB DPL RP. 150.000, SUDAH DIJELASKAN MENGENAI BIAYA TIDAK RAPAT BERUBAH PENJAMIN SAMPAI AKHIR PERAWATAN TETAP MENJADI PASIEN TUNAI';
    $diagnosa = LaporantindaklanjutrjV::model()->findByAttributes([
        'pendaftaran_id' => $modDaftar->pendaftaran_id
    ]);
    $model->diagnosa_nama = !empty($diagnosa)?$diagnosa->diagnosa_nama:'-';
    
    $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
    $model->pihakpertama = $peg->namaLengkap;
    
    
    
    
    $modPj = PenanggungjawabM::model()->findByPk($modDaftar->penanggungjawab_id);
    if (!empty($modPj)){
        $model->pihakkedua = $model->nama_pj = $modPj->nama_pj;
        if (!empty($modPj->tgllahir_pj)){
            $pecah = (explode(' ',CustomFunction::getUmur($modPj->tgllahir_pj)));
            $model->umur_pj = !empty($modPj->tgllahir_pj)?$pecah[0].' tahun':'';
        }
        $model->pekerjaan_pj = '-';
        $model->alamat_pj = $modPj->alamat_pj;
        $model->no_telponpj = !empty($modPj->no_teleponpj)?$modPj->no_teleponpj:$modPj->no_mobilepj;
        $model->jenisidentitas_pj = $modPj->jenisidentitas;
        $model->no_identitas = $modPj->no_identitas;
        $model->hubungankeluarga = $modPj->hubungankeluarga;
        $model->jeniskelamin_pj = $modPj->jeniskelamin;
    }        
            
    if (isset($_POST['SuratakadijarahT'])){
        $post = $_POST['SuratakadijarahT'];
        $trans = Yii::app()->db->beginTransaction();
        $ok = true;
          try{
              
              $post = array_merge($post, [
                  'pasien_id'=>$modAdmisi->pasien_id,
                  'pendaftaran_id'=>$pendaftaran_id,
                  'penanggungjawab_id'=>$modDaftar->penanggungjawab_id,
                  'ruang_id'=>$modAdmisi->ruangan_id,
                  'dokter_dpjp1'=>$modAdmisi->pegawai_id,
                  'namapegawai_id'=>$peg->pegawai_id
              ]);

              $proses = SuratakadijarahT::simpanData($model, $post);
              $ok &= $proses['sukses'];
              
              if ($ok){                                                            
                  Yii::app()->user->setFlash('success', "Data berhasil gagal disimpan ! ");
                  $trans->commit();
                  
                  $this->redirect(['index','pendaftaran_id'=>$pendaftaran_id,'sukses'=>1]);
              }else{
                  $trans->rollback();
                  Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! ");
              }
          }catch(Exception $e){
              $trans->rollback();
              Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $e->getMessage());
          }
      }
      
      $this->render('formAkadIjarah',[
          'model'=>$model
      ]);
  }

  public function actionPenetapanDpjp($pendaftaran_id){
        
    $this->layout = '//layouts/iframe';
    
    $modAdmisi = PPInfoKunjunganPersalinanV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));     
    
    // if (empty($pasienadmisi_id)){
    //     echo 'pasien bukan pasien rawat inap';exit;
    // }else{
    //     if (empty($modAdmisi->kamarruangan_id)){
    //         echo 'pasien belum masuk kamar';exit;
    //     }
    // }
    
    $format = new MyFormatter;
    
    $model = new SuratpenetapandpjpT;
      
    $modPasien = PasienM::model()->findByPk($modAdmisi->pasien_id);
    $modDaftar = PendaftaranT::model()->findByPk($modAdmisi->pendaftaran_id);
    
    
    
    $cek = SuratpenetapandpjpT::model()->findByAttributes([
       'pendaftaran_id' => $modDaftar->pendaftaran_id 
    ]);
    if (!empty($cek)){
        $model = $cek;           
    }else{
        
        $dokAdmisi = PegawaiM::model()->findByPk($modAdmisi->pegawai_id);
        if (!empty($dokAdmisi)){
            $model->dokter_dpjp1 = $dokAdmisi->pegawai_id;
            $model->dokter_dpjp1_nama = $dokAdmisi->namaLengkap;
        }
        
        $model->nama_depan = $modPasien->namadepan;
        $model->nama_pasien = $modPasien->nama_pasien;
        $model->tempat_lahir = $modPasien->tempat_lahir;
        $model->tanggal_lahir = $modPasien->tanggal_lahir;
        $model->jeniskelamin = $modPasien->jeniskelamin;
        $model->alamat_pasien = $modPasien->alamat_pasien;
        $model->tgl_masuk = $format->formatDateTimeForUser($modDaftar->tgl_pendaftaran);
        $model->no_rekam_medik = $modPasien->no_rekam_medik;      
        $model->kamarruangan_id = $modAdmisi->kamarruangan_id;            
        $model->kelaspelayanan_id = $modAdmisi->kelaspelayanan_id;
        $model->kelaspelayanan_nama = $modAdmisi->kelaspelayanan_nama;
        $model->tgl_pendaftaran = $modDaftar->tgl_pendaftaran;
        
        $pecah = (explode(' ',$modDaftar->umur));
        $model->umur_pasien = $pecah[0].' tahun';
        
        // $kamarruangan = KamarruanganM::model()->findByPk($modAdmisi->kamarruangan_id);
        // $model->kamarruangan_nama = !empty($modAdmisi->kamarruangan_id)?$kamarruangan->kamarruangan_nokamar.' - '.$kamarruangan->kamarruangan_nobed:'-';
        $model->kamarruangan_nama = '-';       
        $modPj = PenanggungjawabM::model()->findByPk($modDaftar->penanggungjawab_id);
        if (!empty($modPj) && empty($cek)){
            $model->nama_pj = $modPj->nama_pj;
            $model->tempatlahir_pj = $modPj->tempatlahir_pj;
            $model->tgllahir_pj = $modPj->tgllahir_pj;
            $model->hubungankeluarga = $modPj->hubungankeluarga;            
            $model->penanggungjawab_id = $modPj->penanggungjawab_id;
        }
                    
        $suratpersetujuan = SuratpersetujuanumumT::model()->findByAttributes([
            'pendaftaran_id' => $modDaftar->pendaftaran_id 
        ]);
        $model->saksi_kebutuhanprivasi = !empty($suratpersetujuan)?$suratpersetujuan->saksi_pasien:'';
        $model->petugas_admisi = !empty($suratpersetujuan)?$suratpersetujuan->petugas_admisi:'';
                
        $model->kebutuhanprivasi = "<ol><li></li><li></li><li></li><li></li></ol>";
    }                   
            
    if (isset($_POST['SuratpenetapandpjpT'])){
        $post = $_POST['SuratpenetapandpjpT'];
        $trans = Yii::app()->db->beginTransaction();
        $ok = true;
        try{
            
            $post = array_merge($post, [
                'pasien_id'=>$modAdmisi->pasien_id,
                'pendaftaran_id'=>$modAdmisi->pendaftaran_id,
                'penanggungjawab_id'=>$modDaftar->penanggungjawab_id,                 
            ]);

            $proses = SuratpenetapandpjpT::simpanData($model, $post);
            $ok &= $proses['sukses'];
            
            if ($ok){                                                            
                Yii::app()->user->setFlash('success', "Data berhasil gagal disimpan ! ");
                $trans->commit();
                
                $this->redirect(['index','pasienadmisi_id'=>$pasienadmisi_id,'sukses'=>1]);
            }else{
                $trans->rollback();
                Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! ".$proses['pesan']);
            }
        }catch(Exception $e){
            $trans->rollback();
            Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $e->getMessage());
        }
    }
    
    $this->render('formPenetapanDpjp',[
        'model'=>$model
    ]);
  }

  /**
     * @param type $pendaftaran_id
     */
    public function actionPrintRM1($id)
    {
      // var_dump('kick');die;
        $this->layout = '//layouts/printWindows';
        $format = new MyFormatter;
        // $model = PasienadmisiT::model()->findByPk($id);
        $model = PPInfoKunjunganPersalinanV::model()->findByAttributes(array('pendaftaran_id' => $id));     

        $modDaftar = PendaftaranT::model()->findByPk($id);
        $modPasien = PasienM::model()->findByPk($modDaftar->pasien_id);
        $modPPJ = new PPPenanggungJawabM;
        if (!empty($modDaftar->penanggungjawab_id)) {
            $modPPJ = PPPenanggungJawabM::model()->findByPk($modDaftar->penanggungjawab_id);
        }
        
        $diagMasuk = PasienmorbiditasT::model()->findByAttributes([
            'pendaftaran_id' => $id,
            'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA
        ],['order'=>'create_time ASC']);
        
        $diagAkhir = PasienmorbiditasT::model()->findByAttributes([
            'pendaftaran_id' => $id,
            'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA
        ],['order'=>'create_time DESC']);
        
        // $model->diagnosisutama_masuk = !empty($diagMasuk)?$diagMasuk->diagnosa->diagnosa_nama:'-';
        // $model->diagnosisutama_akhir = !empty($diagAkhir)?$diagAkhir->diagnosa->diagnosa_nama:'-';
        
        $judul_print = 'LAMBAR MASUK DAN KELUAR (RM 1)';
        
        $this->render($this->path_view . 'printRM1', array(
            'format' => $format,           
            'judul_print' => $judul_print,            
            'model' => $model,
            'modDaftar' => $modDaftar,
            'modPPJ' => $modPPJ,
            'modPasien' => $modPasien
        ));
    }
}
