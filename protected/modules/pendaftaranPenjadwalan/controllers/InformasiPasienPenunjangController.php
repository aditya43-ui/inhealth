<?php

class InformasiPasienPenunjangController extends MyAuthController
{
  /**
   * @return array action filters
   */

  public $path_view = 'pendaftaranPenjadwalan.views.informasiPasienPenunjang.';

  public $rujukantersimpan = false;
  public $asuransipasientersimpan = false;
  public $septersimpan = false;

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Informasi Pasien Penunjang";
    $format = new MyFormatter();
    $model = new PPPasienMasukPenunjangT('searchPasienPenunjang');
    //		$model->unsetAttributes(); // clear any default values
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['PPPasienMasukPenunjangT'])) {
      $model->attributes = $_GET['PPPasienMasukPenunjangT'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['PPPasienMasukPenunjangT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienMasukPenunjangT']['tgl_akhir']);
      $model->asalrujukan_id = $_GET['PPPasienMasukPenunjangT']['asalrujukan_id'];
      $model->rujukandari_id = $_GET['PPPasienMasukPenunjangT']['rujukandari_id'];
      $model->no_rekam_medik = $_GET['PPPasienMasukPenunjangT']['no_rekam_medik'];
      $model->nama_pasien = $_GET['PPPasienMasukPenunjangT']['nama_pasien'];
      $model->carabayar_id = $_GET['PPPasienMasukPenunjangT']['carabayar_id'];
      $model->penjamin_id = $_GET['PPPasienMasukPenunjangT']['penjamin_id'];
      $model->create_loginpemakai_id = $_GET['PPPasienMasukPenunjangT']['create_loginpemakai_id'];
      $model->statusperiksa_pendaftaran = $_GET['PPPasienMasukPenunjangT']['statusperiksa_pendaftaran'];
    }
    $this->render($this->path_view . 'index', array(
      'model' => $model, 'format' => $format
    ));
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

  public function actionGetDataPendaftaranRJRDRI()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id_pendaftaran = $_POST['pendaftaran_id'];
      $model = InfokunjunganrjrdriV::model()->findByAttributes(array('pendaftaran_id' => $id_pendaftaran));
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




  public function actionUbahCaraBayar($id = null, $idSep = null)
  {
    $this->layout = '//layouts/iframe';
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
      // var_dump($_POST); die;
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $model->attributes = $_POST['UbahcarabayarR'];
      $model->pendaftaran_id = $_POST['pendaftaran_id'];
      $model->carabayar_id = $_POST['PPPendaftaranT']['carabayar_id'];
      $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
      $model->tglubahcarabayar = date('Y-m-d H:i:s');

      // echo "<pre>"; print_r($model->attributes);exit();
      $transaction = Yii::app()->db->beginTransaction();
      $ok = true;
      try {

        $modPendaftaran = PPPendaftaranT::model()->findByPk(
          $model->pendaftaran_id
        );

        if (isset($_POST['PPPendaftaranT'])) {
          $modPendaftaran->attributes = $_POST['PPPendaftaranT'];
        }

        $modPendaftaran->carabayar_id = $model->carabayar_id;
        $modPendaftaran->penjamin_id = $model->penjamin_id;
        $modPendaftaran->status_konfirmasi = "-";
        $modPendaftaran->asuransipasien_id = null;
        if ($model->save()) {
          $modPendaftaran->save();
          // $ok = $ok && $this->updateKarcis($modPendaftaran);


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
            $modPendaftaran->status_konfirmasi = $modAsuransiPasien->status_konfirmasi;
            $modPendaftaran->tgl_konfirmasi = $modAsuransiPasien->tgl_konfirmasi;
            $modPendaftaran->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;

            //var_dump($modPendaftaran->attributes); die;
            $modPendaftaran->save();
          } else {
            $this->asuransipasientersimpan = true;
            // $modPendaftaran->status_konfirmasi = $modAsuransiPasien->status_konfirmasi;
            // $modPendaftaran->tgl_konfirmasi = $modAsuransiPasien->tgl_konfirmasi;
            // $modPendaftaran->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;
          }
          if (isset($_POST['PPAsuransipasienbpjsM'])) {
            //var_dump($_POST['PPAsuransipasienbpjsM']); die;
            if (isset($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'])) {
              if ($_POST['PPAsuransipasienbpjsM']['asuransipasien_id'] != "") {
                $modAsuransiPasienBpjs = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbpjsM']['asuransipasien_id']);
              }
            }
            $modAsuransiPasienBpjs = $this->simpanAsuransiPasien($modAsuransiPasienBpjs, $modPendaftaran, $modPasien, $_POST['PPAsuransipasienbpjsM']);
            $modPendaftaran->status_konfirmasi = $modAsuransiPasienBpjs->status_konfirmasi;
            $modPendaftaran->tgl_konfirmasi = $modAsuransiPasienBpjs->tgl_konfirmasi;
            $modPendaftaran->asuransipasien_id = $modAsuransiPasienBpjs->asuransipasien_id;

            $modPendaftaran->save();
          } else {
            $this->asuransipasientersimpan = true;
          }

          // var_dump($modAsuransiPasien->attributes); die;



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


          // ubah tindakan

          $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
            'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
          ));
          foreach ($tindakan as $item) {

            $item->carabayar_id = $modPendaftaran->carabayar_id;
            $item->penjamin_id = $modPendaftaran->penjamin_id;

            TindakanpelayananT::model()->updateByPk($item->tindakanpelayanan_id, array(
              'carabayar_id' => $modPendaftaran->carabayar_id,
              'penjamin_id' => $modPendaftaran->penjamin_id,
              'tarif_satuan' => $item->getTarifSatuan(),
              'tarif_tindakan' => $item->getTarifSatuan() * $item->qty_tindakan,
            ));
          }

          // var_dump($ok, $modAsuransiPasien->attributes); die;
          // var_dump($ok); die;
          //die;
          if ($ok) {

            $this->notifUbahBayar($modPendaftaran);

            $transaction->commit();
            if (isset($modSep->nosep)) {
              $this->redirect(array('ubahCaraBayar', 'id' => $model->pendaftaran_id, 'idSep' => $modSep->sep_id, 'sukses' => 1));
            } else {
              $this->redirect(array('ubahCaraBayar', 'id' => $model->pendaftaran_id, 'sukses' => 1));
            }
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data pasien gagal disimpan err1 !");
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pasien gagal disimpan err2 !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! (X)" . MyExceptionMessage::getMessage($exc, true));
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

  private function updateKarcis($modPendaftaran)
  {

    $ok = true;

    $isBaru = $modPendaftaran->statuspasien == 'PENGUNJUNG BARU';

    $karcis = KarcisV::model()->findByAttributes(array(
      'penjamin_id' => $modPendaftaran->penjamin_id,
      'kelaspelayanan_id' => $modPendaftaran->kelaspelayanan_id,
      'ruangan_id' => $modPendaftaran->ruangan_id,
      'pasienbaru_karcis' => $isBaru
    ));


    $kdat = TindakanpelayananT::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'karcis_id' => $modPendaftaran->karcis_id,
    ));

    // cek tindakan yang sudah bayar, hapus kalo belum dibayar
    // jika daftar tindakannya sama dengan yang dikarcis, maka update dibatalkan
    if (!empty($kdat->daftartindakan_id)) {

      if (!empty($karcis->daftartindakan_id)) {
        if ($kdat->daftartindakan_id == $karcis->daftartindakan_id) {
          return true;
        }
      }

      if (!empty($kdat->tindakansudahbayar_id)) {
        return false;
      }
      $ok = $ok && TindakanpelayananT::model()->deleteByPk($kdat->tindakanpelayanan_id);
    }

    if (!empty($karcis)) {

      $knew = new TindakanpelayananT;
      if (!empty($kdat)) $knew->attributes = $kdat->attributes;
      else {

        $knew->qty_tindakan = 1;
        $knew->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;
        $knew->discount_tindakan = 0;
        $knew->subsidiasuransi_tindakan = 0;
        $knew->subsidipemerintah_tindakan = 0;
        $knew->subsisidirumahsakit_tindakan = 0;
      }
      $knew->cyto_tindakan = (!empty($knew->cyto_tindakan) ? $knew->cyto_tindakan : 0);
      $knew->tarifcyto_tindakan = ($knew->cyto_tindakan ? ($knew->tarifcyto_tindakan > 0 ? $knew->tarifcyto_tindakan : 0) : 0);
      $knew->tgl_tindakan = date("Y-m-d H:i:s");
      $knew->tindakanpelayanan_id = null;
      $knew->daftartindakan_id = $karcis->daftartindakan_id;
      $knew->karcis_id = $karcis->karcis_id;
      $knew->tarif_satuan = $knew->tarif_tindakan = $karcis->harga_tariftindakan;
      $knew->tipepaket_id = $this->tipePaketKarcis($modPendaftaran, $knew);
      $knew->iurbiaya_tindakan = $knew->tarif_tindakan;
      $knew->create_time =  $knew->update_time = date("Y-m-d H:i:s");
      $knew->create_loginpemakai_id = $knew->update_loginpemakai_id = Yii::app()->user->id;

      if ($knew->validate()) {
        $ok = $ok && $knew->save();
        $modPendaftaran->karcis_id = $karcis->karcis_id;
        $ok = $ok && $modPendaftaran->save();
      } else {
        //var_dump($knew->errors);
        $ok = false;
      }

      //var_dump($ok);
    }

    //var_dump($ok);
    // var_dump($ok, $modPendaftaran->attributes, $isBaru, $karcis->attributes, $kdat->attributes, $knew->attributes);
    //die;
    return $ok;
  }

  public function simpanRujukanBpjs($modRujukanBpjs, $post)
  {
    $format = new MyFormatter();
    $modRujukanBpjs->attributes = $post;
    $modRujukanBpjs->kddiagnosa_rujukan = isset($post['kddiagnosa_rujukan']) ? ((count((array)$post['kddiagnosa_rujukan']) > 0) ? implode(', ', $post['kddiagnosa_rujukan']) : '') : '';
    $modRujukanBpjs->diagnosa_rujukan = isset($post['diagnosa_rujukan']) ? ((count((array)$post['diagnosa_rujukan']) > 0) ? implode(', ', $post['diagnosa_rujukan']) : '') : '';
    $modRujukanBpjs->tanggal_rujukan = $format->formatDateTimeForDb($modRujukanBpjs->tanggal_rujukan);

    if ($modRujukanBpjs->save()) {
      $this->rujukantersimpan = true;
    }
    return $modRujukanBpjs;
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

    // if ($postPendaftaran->carabayar_id == Params::CARABAYAR_ID_JAMKESPA) {

    if (empty($modAsuransiPasien->nopeserta)) $modAsuransiPasien->nopeserta = $modAsuransiPasien->nokartuasuransi;

    //} else 
    if ($postPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS) {
      //if (Yii::app()->user->getState('isbridging')) {
      $kelas = KelaspelayananM::model()->findByAttributes(array(
        'kelasbpjs_id' => $modAsuransiPasien->kelastanggunganasuransi_id
      ));
      $modAsuransiPasien->kelastanggunganasuransi_id = $kelas->kelaspelayanan_id;
      //}
      $modAsuransiPasien->status_konfirmasi = "SUDAH DIKONFIRMASI";
      $modAsuransiPasien->tgl_konfirmasi = date('Y-m-d H:i:s');
    }

    // var_dump($modAsuransiPasien->attributes); die;



    //var_dump($postPendaftaran->attributes, $modAsuransiPasien->attributes, $modAsuransiPasien->validate(), $modAsuransiPasien->errors);
    //die;

    // $modAsuransiPasien->validate();
    // var_dump($modAsuransiPasien->attributes, $modAsuransiPasien->errors, $postAsuransiPasien);
    // die;

    if ($modAsuransiPasien->save()) {
      $this->asuransipasientersimpan = true;
    }
    return $modAsuransiPasien;
  }

  public function simpanSep($model, $modPasien, $modRujukanBpjs, $modAsuransiPasienBpjs, $postSep, $isRI = false)
  {
    $reqSep = null;
    $modSep = new PPSepT;
    $bpjs = new Bpjs();

    $kelas = KelaspelayananM::model()->findByPk($modAsuransiPasienBpjs->kelastanggunganasuransi_id);

    $modSep->tglsep = date('Y-m-d H:i:s');
    $modSep->nokartuasuransi = $modAsuransiPasienBpjs->nopeserta;
    $modSep->tglrujukan = $modRujukanBpjs->tanggal_rujukan;
    if (empty($modSep->tglrujukan)) $modSep->tglrujukan = $modSep->tglsep;
    $modSep->norujukan = $modRujukanBpjs->no_rujukan;
    if (isset($postSep['ppkrujukan'])) $modSep->ppkrujukan = $postSep['ppkrujukan'];
    else $modSep->ppkrujukan = Yii::app()->user->getState('ppkpelayanan');
    $modSep->ppkpelayanan = Yii::app()->user->getState('ppkpelayanan');
    $modSep->jnspelayanan = ($model->instalasi_id == Params::INSTALASI_ID_RI || $isRI) ? Params::JENISPELAYANAN_RI : Params::JENISPELAYANAN_RJ;
    $modSep->catatansep = $postSep['catatansep'];
    $data_diagnosa = explode(', ', $modRujukanBpjs->kddiagnosa_rujukan);
    $modSep->diagnosaawal = isset($data_diagnosa[0]) ? $data_diagnosa[0] : '';
    $modSep->politujuan = $model->ruangan->ruangan_singkatan;
    $modSep->klsrawat = $kelas->kelasbpjs_id;
    $modSep->tglpulang = date('Y-m-d H:i:s');
    $modSep->create_time = date('Y-m-d H:i:s');
    $modSep->create_loginpemakai_id = Yii::app()->user->id;
    $modSep->create_ruangan = Yii::app()->user->getState('ruangan_id');

    //var_dump($modSep->attributes, $modSep->validate(), $modSep->errors); die;

    $lakalantas = 2;

    $reqSep = json_decode($bpjs->create_sep($modSep->nokartuasuransi, $modSep->tglsep, $modSep->tglrujukan, $modSep->norujukan, $modSep->ppkrujukan, $modSep->ppkpelayanan, $modSep->jnspelayanan, $modSep->catatansep, $modSep->diagnosaawal, $modSep->politujuan, $modSep->klsrawat, Yii::app()->user->id, $modPasien->no_rekam_medik, $model->pendaftaran_id, $lakalantas), true);

    // var_dump($reqSep); die;

    if ($reqSep['metadata']['code'] == 200) {
      $modSep->nosep = $reqSep['response'];
      if ($modSep->save()) {
        $this->septersimpan = true;
      }
    }

    return $modSep;
  }

  public function actionAutocompleteAsuransi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nopeserta = isset($_GET['nopeserta']) ? $_GET['nopeserta'] : '';
      $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
      $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nopeserta)', strtolower($nopeserta), true);
      $criteria->addCondition('penjamin_id=' . $penjamin_id);
      $criteria->addCondition('asuransipasien_aktif is true');
      if ($_GET['pasien_id'] == "") {
        $criteria->addCondition('pasien_id is null');
      } else {
        $criteria->addCondition('pasien_id=' . $pasien_id);
      }
      $criteria->order = 'namapemilikasuransi';
      $criteria->limit = 5;
      $models = PPAsuransipasienM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nopeserta . ' - ' . $model->namapemilikasuransi;
        $returnVal[$i]['value'] = $model->nopeserta;
        $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
        $returnVal[$i]['nokartuasuransi'] = $model->nokartuasuransi;
        $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
        $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
        $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
        $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
        $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
      }


      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
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
      array('instalasi_id' => Params::INSTALASI_ID_KEUANGAN, 'ruangan_id' => Params::RUANGAN_ID_KASIR, 'modul_id' => Params::MODUL_ID_BILLINGKASIR),
      array('instalasi_id' => $r->instalasi_id, 'ruangan_id' => $r->ruangan_id, 'modul_id' => $r->modul_id),
    ));
  }
}
