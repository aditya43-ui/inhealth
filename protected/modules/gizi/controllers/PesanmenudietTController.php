<?php

class PesanmenudietTController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  protected $path_view = 'gizi.views.pesanmenudietT.';
  protected $path_view_tamu = 'gizi.views.pesanmenudietTamu.';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render($this->path_view . 'view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionIndex($id = null, $linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pemesanan Menu Diet Pasien";
    $model = new GZPesanmenudietT;
    $model->tglpesanmenu = date('d M Y H:i:s');
    $model->nopesanmenu = MyGenerator::noPesanMenuDiet();
    $model->temp_no = '-- Otomatis --';

    //$p = PegawaiM::model()->findByPK(LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
    $pegawai_nama = ""; //PegawaiM::model()->findByPK(LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id)->nama_pegawai;
    $model->jenispesanmenu = Params::JENISPESANMENU_PASIEN;
    $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
    $model->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
    $model->penjamin_id = Params::PENJAMIN_ID_UMUM;
    //$model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    //$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->nama_pemesan = Yii::app()->user->getState('nama_pegawai');
    $model->disabled = true;
    if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_GIZI) {
      $model->disabled = false;
    }

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

    if (isset($id)) {
      if (!empty($id)) {
        $model = GZPesanmenudietT::model()->findByPk($id);
        $model->temp_no = $model->nopesanmenu;
        // $model->instalasi_id =$POST['GZPesanmenudietT']['instalasi_id'];
        // $model->jeniswaktu_id =$_POST['GZPesanmenudietT']['jeniswaktu_id'];
      
      }
    }

    if (isset($_POST['GZPesanmenudietT'])) {
      $model->attributes = $_POST['GZPesanmenudietT'];
      $model->jenispesanmenu = Params::JENISPESANMENU_PASIEN;
      // $model->nama_pemesan = $pegawai_nama;
      $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
      $model->tglpesanmenu = MyFormatter::formatDateTimeForDb($model->tglpesanmenu);
      $model->nopesanmenu = MyGenerator::noPesanMenuDiet();
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $model->create_time = date('Y-m-d');
      $transaction = Yii::app()->db->beginTransaction();
      try {
        //var_dump($_POST);die;
        $success = true;
        if ($model->validate() && $model->save()) {
          foreach ($_POST['PesanmenudetailT'] as $i => $v) {
            if (isset($v['checkList']) && $v['checkList'] == 1) {
              foreach ($v['menudiet_id'] as $j => $x) {
                if (!empty($x)) {
                  $modDetail = new GZPesanmenudetailT();
                  $modDetail->attributes = $v;
                  $modDetail->pesanmenudiet_id = $model->pesanmenudiet_id;
                  $modDetail->jeniswaktu_id = $j;
                  $modDetail->menudiet_id = $x;
                  if ($modDetail->save()) {
                    // SMS GATEWAY
                    $modPasien = $modDetail->pasien;
                    $modRuangan = $model->ruangan;
                    $sms = new Sms();
                    /*
                                          foreach ($modSmsgateway as $i => $smsgateway) {
                                          $isiPesan = $smsgateway->templatesms;

                                          $attributes = $modPasien->getAttributes();
                                          foreach($attributes as $attributes => $value){
                                          $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                          }
                                          $attributes = $modDetail->getAttributes();
                                          foreach($attributes as $attributes => $value){
                                          $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                          }
                                          $attributes = $model->getAttributes();
                                          foreach($attributes as $attributes => $value){
                                          $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                          }
                                          $attributes = $modRuangan->getAttributes();
                                          foreach($attributes as $attributes => $value){
                                          $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                          }
                                          $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($model->tglpesanmenu),$isiPesan);
                                          $isiPesan = str_replace("{{nama_rumahsakit}}",Yii::app()->user->getState('nama_rumahsakit'),$isiPesan);

                                          if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                          if(!empty($modPasien->no_mobile_pasien)){
                                          $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                          }
                                          }

                                          }
                                         * 
                                         */
                    // END SMS GATEWAY
                  } else {
                    $success = false;
                  }
                }
              }
            }
          }
        } else {
          $success = false;
        }


        $this->notifPesanMenuDiet($model);

        if ($success == TRUE) {
          $transaction->commit();
          $this->redirect(array('index', 'id' => $model->pesanmenudiet_id));
          $this->refresh();
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(3046);

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'linkHalaman' => $linkHalaman
    ));
  }



  public function actionIndexUpdate($id,$linkHalaman = null)
  {
    //$id = $_GET['pesanmenudiet_id'];
    $this->pageTitle = Yii::app()->name . " - Pemesanan Menu Diet Pasien";
    $model = GZPesanmenudietT::model()->findByPk($id);
    
    $model->tglpesanmenu = MyFormatter::formatDateTimeForUser($model->tglpesanmenu);
    $model->nopesanmenu = MyGenerator::noPesanMenuDiet();
    $model->temp_no = '-- Otomatis --';

    //$p = PegawaiM::model()->findByPK(LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
    $pegawai_nama = ""; //PegawaiM::model()->findByPK(LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id)->nama_pegawai;
    $model->jenispesanmenu = Params::JENISPESANMENU_PASIEN;
    $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
    $model->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
    $model->penjamin_id = Params::PENJAMIN_ID_UMUM;
    //$model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    //$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->nama_pemesan = Yii::app()->user->getState('nama_pegawai');
    $model->disabled = true;
    if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_GIZI) {
      $model->disabled = false;
    }

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

    if (isset($id)) {
      if (!empty($id)) {
        $model = GZPesanmenudietT::model()->findByPk($id);
        $model->temp_no = $model->nopesanmenu;
        // $model->instalasi_id =$POST['GZPesanmenudietT']['instalasi_id'];
        // $model->jeniswaktu_id =$_POST['GZPesanmenudietT']['jeniswaktu_id'];
      
      }
    }

    if (isset($_POST['GZPesanmenudietT'])) {
      $model->attributes = $_POST['GZPesanmenudietT'];
      $model->jenispesanmenu = Params::JENISPESANMENU_PASIEN;
      // $model->nama_pemesan = $pegawai_nama;
      $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
      $model->tglpesanmenu = MyFormatter::formatDateTimeForDb($model->tglpesanmenu);
      $model->nopesanmenu = MyGenerator::noPesanMenuDiet();
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $model->create_time = date('Y-m-d');
      $transaction = Yii::app()->db->beginTransaction();
      try {
        //var_dump($_POST);die;
        $success = TRUE;
        if ($model->validate() && $model->save()) {
          foreach ($_POST['PesanmenudetailT'] as $i => $v) {
            if (isset($v['checkList']) && $v['checkList'] == 1) {
              foreach ($v['menudiet_id'] as $j => $x) {
                if (!empty($x)) {
                  $modDetail = new GZPesanmenudetailT();
                  $modDetail->attributes = $v;
                  $modDetail->pesanmenudiet_id = $model->pesanmenudiet_id;
                  $modDetail->jeniswaktu_id = $j;
                  $modDetail->menudiet_id = $x;
                  if ($modDetail->save()) {
                    // SMS GATEWAY
                    $modPasien = $modDetail->pasien;
                    $modRuangan = $model->ruangan;
                    $sms = new Sms();
                    /*
                                          foreach ($modSmsgateway as $i => $smsgateway) {
                                          $isiPesan = $smsgateway->templatesms;

                                          $attributes = $modPasien->getAttributes();
                                          foreach($attributes as $attributes => $value){
                                          $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                          }
                                          $attributes = $modDetail->getAttributes();
                                          foreach($attributes as $attributes => $value){
                                          $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                          }
                                          $attributes = $model->getAttributes();
                                          foreach($attributes as $attributes => $value){
                                          $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                          }
                                          $attributes = $modRuangan->getAttributes();
                                          foreach($attributes as $attributes => $value){
                                          $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                          }
                                          $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($model->tglpesanmenu),$isiPesan);
                                          $isiPesan = str_replace("{{nama_rumahsakit}}",Yii::app()->user->getState('nama_rumahsakit'),$isiPesan);

                                          if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                          if(!empty($modPasien->no_mobile_pasien)){
                                          $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                          }
                                          }

                                          }
                                         * 
                                         */
                    // END SMS GATEWAY
                  } else {
                    $success = false;
                  }
                }
              }
            }
          }
          
        } else {
          $success = false;
        }


        $this->notifPesanMenuDiet($model);

        if ($success == TRUE) {
          $transaction->commit();
          $this->redirect(array('index', 'id' => $model->pesanmenudiet_id));
        
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(3046);

    $this->render($this->path_view . 'index2', array(
      'model' => $model,
      'linkHalaman' => $linkHalaman
    ));
  }



  public function notifPesanMenuDiet($model)
  {
    $ruangan = RuanganM::model()->findByPk($model->ruangan_id);
    $tujuan = RuanganM::model()->findByPk(Params::RUANGAN_ID_GIZI);

    $judul = "Pemesanan menu diet dari " . $ruangan->ruangan_nama;
    $isi = "Tgl. Pemesanan : " . MyFormatter::formatDateTimeForUser($model->tglpesanmenu) . '<br/>';
    $isi .= "No. Pemesanan : " . ($model->nopesanmenu) . '<br/>';
    $isi .= "Jenis : " . ($model->jenispesanmenu) . '<br/>';
    $isi .= "Total Pemesanan : " . ($model->totalpesan_org) . '<br/>';

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
      array('instalasi_id' => $tujuan->instalasi_id, 'ruangan_id' => $tujuan->ruangan_id, 'modul_id' => $tujuan->modul_id),
    ));
  }

  public function actionIndexPegawai($id = null, $linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pemesanan Menu Pegawai";
    $model = new GZPesanmenudietT;
    $model->tglpesanmenu = date('d M Y H:i:s');
    $model->nopesanmenu = MyGenerator::noPesanMenuDiet();
    $model->temp_no = '-- Otomatis --';
    $pegawai_nama = ""; //PegawaiM::model()->findByPK(LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id)->nama_pegawai;
    //$model->nama_pemesan = $pegawai_nama;
    $model->nama_pemesan = Yii::app()->user->getState('nama_pegawai');
    $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
    $model->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
    $model->penjamin_id = Params::PENJAMIN_ID_UMUM;
    //$model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    //$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jenispesanmenu = Params::JENISPESANMENU_PEGAWAI;

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

    if (isset($id)) {
      if (!empty($id)) {
        $model = GZPesanmenudietT::model()->findByPk($id);
        $model->no_temp = $model->nopesanmenu;
      }
    }
    if (isset($_POST['GZPesanmenudietT'])) {
      $model->attributes = $_POST['GZPesanmenudietT'];
      $model->jenispesanmenu = $_POST['jenisPesan'];
      $model->tglpesanmenu = MyFormatter::formatDateTimeForDb($model->tglpesanmenu);
      $model->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $model->create_time = date('Y-m-d');
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = true;
        $jumlah = count((array)$_POST['PesanmenupegawaiT']);
        $ruangan = array();
        $tempRuangan = array();
        for ($i = 0; $i < $jumlah; $i++) {
          foreach ($_POST['PesanmenupegawaiT'][$i] as $x => $v) {
            if (in_array($x, $ruangan)) {
              array_push($tempRuangan[$x], $v);
            } else {
              $ruangan[] = $x;
              $tempRuangan[$x] = array($v);
            }
          }
        }
        foreach ($tempRuangan as $i => $baris) {
          $models = new GZPesanmenudietT();
          $models->attributes = $model->attributes;
          $models->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
          $models->create_ruangan = Yii::app()->user->getState('ruangan_id');
          $models->create_time = date('Y-m-d');
          $models->nopesanmenu = MyGenerator::noPesanMenuDiet();
          $models->totalpesan_org = count((array)$baris);
          $models->ruangan_id = $i;
          if ($models->save()) {
            foreach ($baris as $row) {
              foreach ($row['menudiet_id'] as $j => $v) {
                if ($row['checkList'] == 1) {
                  if (!empty($v)) {
                    $modDetail = new PesanmenupegawaiT();
                    $modDetail->attributes = $row;
                    $modDetail->pesanmenudiet_id = $models->pesanmenudiet_id;
                    $modDetail->jeniswaktu_id = $j;
                    $modDetail->menudiet_id = $v;
                    if ($modDetail->save()) {
                      // SMS GATEWAY
                      $modPegawai = $modDetail->pegawai;
                      $modRuangan = $model->ruangan;
                      $sms = new Sms();
                      foreach ($modSmsgateway as $i => $smsgateway) {
                        $isiPesan = $smsgateway->templatesms;

                        $attributes = $modPegawai->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                          $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modDetail->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                          $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $model->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                          $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modRuangan->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                          $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($model->tglpesanmenu), $isiPesan);
                        $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);

                        if ($smsgateway->tujuansms == Params::TUJUANSMS_PEGAWAI && $smsgateway->statussms) {
                          if (!empty($modPegawai->nomobile_pegawai)) {
                            $sms->kirim($modPegawai->nomobile_pegawai, $isiPesan);
                          }
                        }
                      }
                      // END SMS GATEWAY
                    } else {
                      $success = false;
                    }
                  }
                }
              }
            }
          } else {
            $success = FALSE;
          }
        }

        $this->notifPesanMenuDiet($model);

        if ($success == TRUE) {
          $transaction->commit();
          //					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('indexPegawai', 'id' => $model->pesanmenudiet_id, 'sukses' => 1));
          $this->refresh();
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render($this->path_view . 'indexPegawai', array(
      'model' => $model,
      'linkHalaman' => $linkHalaman
    ));
  }

  public function actionIndexTamu($id = null, $linkHalaman = null)
  {
    $model = new GZPesanmenudietT;
    $model->tglpesanmenu = date('d M Y H:i:s');
    $model->nopesanmenu = MyGenerator::noPesanMenuDiet();
    $model->temp_no = '-- Otomatis --';
    $pegawai_nama = ""; //PegawaiM::model()->findByPK(LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id)->nama_pegawai;
    //$model->nama_pemesan = $pegawai_nama;
    $model->nama_pemesan = Yii::app()->user->getState('nama_pegawai');
    $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
    $model->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
    $model->penjamin_id = Params::PENJAMIN_ID_UMUM;
    //$model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    //$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jenispesanmenu = Params::JENISPESANMENU_PENDAMPING;


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

    if (isset($id)) {
      if (!empty($id)) {
        $model = GZPesanmenudietT::model()->findByPk($id);
        $model->no_temp = $model->nopesanmenu;
      }
    }

    if (isset($_POST['GZPesanmenudietT'])) {
      $model->attributes = $_POST['GZPesanmenudietT'];
      $model->jenispesanmenu = $_POST['jenisPesan'];
      $model->tglpesanmenu = MyFormatter::formatDateTimeForDb($model->tglpesanmenu);
      $model->pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $model->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $model->create_time = date('Y-m-d');
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = true;
        $jumlah = count((array)$_POST['PesanmenupegawaiT']);
        $ruangan = array();
        $tempRuangan = array();
        for ($i = 0; $i < $jumlah; $i++) {
          foreach ($_POST['PesanmenupegawaiT'][$i] as $x => $v) {
            if (in_array($x, $ruangan)) {
              array_push($tempRuangan[$x], $v);
            } else {
              $ruangan[] = $x;
              $tempRuangan[$x] = array($v);
            }
          }
        }
        foreach ($tempRuangan as $i => $baris) {
          $models = new GZPesanmenudietT();
          $models->attributes = $model->attributes;
          $models->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
          $models->create_ruangan = Yii::app()->user->getState('ruangan_id');
          $models->create_time = date('Y-m-d');
          $models->nopesanmenu = MyGenerator::noPesanMenuDiet();
          $models->totalpesan_org = count((array)$baris);
          $models->ruangan_id = $i;
          if ($models->save()) {
            foreach ($baris as $row) {
              foreach ($row['menudiet_id'] as $j => $v) {
                if ($row['checkList'] == 1) {
                  if (!empty($v)) {
                    $modDetail = new PesanmenupegawaiT();
                    $modDetail->attributes = $row;
                    $modDetail->pesanmenudiet_id = $models->pesanmenudiet_id;
                    $modDetail->jeniswaktu_id = $j;
                    $modDetail->menudiet_id = $v;
                    if ($modDetail->save()) {
                      // SMS GATEWAY
                      $modPegawai = $modDetail->pegawai;
                      $modRuangan = $model->ruangan;
                      $sms = new Sms();
                      foreach ($modSmsgateway as $i => $smsgateway) {
                        $isiPesan = $smsgateway->templatesms;

                        $attributes = $modPegawai->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                          $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modDetail->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                          $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $model->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                          $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $attributes = $modRuangan->getAttributes();
                        foreach ($attributes as $attributes => $value) {
                          $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                        }
                        $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($model->tglpesanmenu), $isiPesan);
                        $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);

                        if ($smsgateway->tujuansms == Params::TUJUANSMS_PEGAWAI && $smsgateway->statussms) {
                          if (!empty($modPegawai->nomobile_pegawai)) {
                            $sms->kirim($modPegawai->nomobile_pegawai, $isiPesan);
                          }
                        }
                      }
                      // END SMS GATEWAY
                    } else {
                      $success = false;
                    }
                  }
                }
              }
            }
          } else {
            $success = FALSE;
          }
        }

        $this->notifPesanMenuDiet($model);

        if ($success == TRUE) {
          $transaction->commit();
          //					Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('indexTamu', 'id' => $model->pesanmenudiet_id, 'sukses' => 1));
          $this->refresh();
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render($this->path_view_tamu . 'index', array(
      'model' => $model,
      'linkHalaman' => $linkHalaman
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['GZPesanmenudietT'])) {
      $model->attributes = $_POST['GZPesanmenudietT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->pesanmenudiet_id));
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new GZPesanmenudietT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['GZPesanmenudietT']))
      $model->attributes = $_GET['GZPesanmenudietT'];

    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = GZPesanmenudietT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'gzpesanmenudiet-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionPrint($id, $caraprint = null)
  {
    $modPesan = new GZPesanmenudietT;
    $kolomNama = "";
    $modPesan = PesanmenudietT::model()->findByPk($id);
    if ($modPesan->jenispesanmenu == Params::JENISPESANMENU_PASIEN) {
      $criteria = new CDbCriteria();
      $criteria->select = 'pasienadmisi_id, pendaftaran_id, pasien_id,  pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
      $criteria->group = 'pasienadmisi_id, pendaftaran_id, pasien_id, pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
      $criteria->compare('pesanmenudiet_id', $id);
      $modDetailPesan = PesanmenudetailT::model()->findAll($criteria);
      $kolomNama = "Pasien";
    } else {
      $criteria = new CDbCriteria();
      $criteria->select = 'pegawai_id,  pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
      $criteria->group = 'pegawai_id, pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
      $criteria->compare('pesanmenudiet_id', $id);
      $modDetailPesan = PesanmenupegawaiT::model()->findAll($criteria);

      if ($modPesan->jenispesanmenu == Params::JENISPESANMENU_PEGAWAI) {
        $kolomNama = "Pegawai";
      } else if ($modPesan->jenispesanmenu == Params::JENISPESANMENU_PENDAMPING) {
        $kolomNama = "Pendamping";
      }
    }

    $judulLaporan = 'Pemesanan Menu Diet';
    $caraprint = $caraprint;
    if ($caraprint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'detailInformasi', array('modPesan' => $modPesan, 'modDetailPesan' => $modDetailPesan, 'kolomNama' => $kolomNama, 'judulLaporan' => $judulLaporan, 'caraprint' => $caraprint));
    } else if ($caraprint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'detailInformasi', array('modPesan' => $modPesan, 'modDetailPesan' => $modDetailPesan, 'kolomNama' => $kolomNama, 'judulLaporan' => $judulLaporan, 'caraprint' => $caraprint));
    } else if ($caraprint == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'detailInformasi', array('modPesan' => $modPesan, 'modDetailPesan' => $modDetailPesan, 'kolomNama' => $kolomNama, 'judulLaporan' => $judulLaporan, 'caraprint' => $caraprint), true));
      $mpdf->Output();
    }
  }

  public function actionInformasi($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pemesanan Menu Pegawai";
    $model = new GZPesanmenudietT('searchInformasi');
    $model2 = new JeniswaktuM();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');

    if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_GIZI) {
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }



    if(isset($_GET['JeniswaktuM'])){

      $model2->attributes = $_GET['JeniswaktuM'];
      if (isset($_GET['JeniswaktuM']['jeniswaktu_id'])){
        $model2->jeniswaktu_id = $_GET['JeniswaktuM']['jeniswaktu_id'];
      }
    }


    if (isset($_GET['GZPesanmenudietT'])) {
      $model->attributes = $_GET['GZPesanmenudietT'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZPesanmenudietT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZPesanmenudietT']['tgl_akhir']);
      if (isset($_GET['GZPesanmenudietT']['ruangan_id']))
        $model->ruangan_id = $_GET['GZPesanmenudietT']['ruangan_id'];
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(3256);

    $this->render($this->path_view . 'informasi', array(
      'model' => $model,
      'model2' => $model2,      
      'linkHalaman' => $linkHalaman
    ));
  }

  public function actionInformasiPasien()
  {
      //insert menu diet hari ini yang sudah pesan menu diet
      if(Yii::app()->user->getState('pesanmenudietotomatis')) {
        $this->pesanMenuDietOtomatis();
      }

      $this->pageTitle = Yii::app()->name . " - Pasien Rawat Inap";
      $format = new MyFormatter();
      $modelRawatInap = new GZPendaftaranT('searchPasienBaruRawatInap');
      $modelRawatInap->tgl_awal = date('d M Y', strtotime('-7 days'));
      $modelRawatInap->tgl_akhir = date('d M Y');

      
      // $model->jenispesanmenu = Params::JENISPESANMENU_PASIEN;

      if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_GIZI) {
        $modelRawatInap->ruangan_id = Yii::app()->user->getState('ruangan_id');
      }

      // echo '<pre>';var_dump($_GET);die;
      if (isset($_GET['GZPendaftaranT'])) {
          $modelRawatInap->attributes = $_GET['GZPendaftaranT'];
          $format = new MyFormatter();
          $modelRawatInap->tgl_awal = $format->formatDateTimeForDb($_GET['GZPendaftaranT']['tgl_awal']);
          $modelRawatInap->tgl_akhir = $format->formatDateTimeForDb($_GET['GZPendaftaranT']['tgl_akhir']);
          if (isset($_GET['GZPendaftaranT']['ruangan_id'])){
              $modelRawatInap->ruangan_id = $_GET['GZPendaftaranT']['ruangan_id'];
          }
          if (isset($_GET['GZPendaftaranT']['nama_pasien'])){
              $modelRawatInap->nama_pasien = $_GET['GZPendaftaranT']['nama_pasien'];
          }
          if (isset($_GET['GZPendaftaranT']['no_rekam_medik'])){
              $modelRawatInap->no_rekam_medik = $_GET['GZPendaftaranT']['no_rekam_medik'];
          }
      }

      $this->pageTitle = Yii::app()->name . " - Pemesanan Menu Diet Pasien";
      $model = new GZPesanmenudietT('searchInformasiMenuPasien');
      $model->tgl_awal = date('d M Y');
      $model->tgl_akhir = date('d M Y');
      $model->jenispesanmenu = Params::JENISPESANMENU_PASIEN;

      // if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_GIZI) {
      //     $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      // }

      if (isset($_GET['GZPesanmenudietT'])) {
        // echo '<pre>';var_dump($_GET);die;
          $model->attributes = $_GET['GZPesanmenudietT'];
          $format = new MyFormatter();
          $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZPesanmenudietT']['tgl_awal']);
          $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZPesanmenudietT']['tgl_akhir']);
          if (isset($_GET['GZPesanmenudietT']['ruangan_id'])){
              $model->ruangan_id = $_GET['GZPesanmenudietT']['ruangan_id'];
          }
          if (isset($_GET['GZPesanmenudietT']['instalasi_id'])){
              $model->instalasi_id = $_GET['GZPesanmenudietT']['instalasi_id'];
          }
          if (isset($_GET['GZPesanmenudietT']['nama_pasien'])){
              $model->nama_pasien = $_GET['GZPesanmenudietT']['nama_pasien'];
          }
          if (isset($_GET['GZPesanmenudietT']['no_rekam_medik'])){
              $model->no_rekam_medik = $_GET['GZPesanmenudietT']['no_rekam_medik'];
          }
          if (isset($_GET['GZPesanmenudietT']['nama_pasien'])){
              $model->nama_pasien = $_GET['GZPesanmenudietT']['nama_pasien'];
          }
          if (isset($_GET['GZPesanmenudietT']['jeniswaktu_id'])){
              $model->jeniswaktu_id = $_GET['GZPesanmenudietT']['jeniswaktu_id'];
          }
      }

      if(Yii::app()->request->isAjaxRequest) {
        if(isset($_GET['ajax']) && $_GET['ajax'] == 'gzpesanmenudietpasien-v-grid') {
          $this->renderPartial($this->path_view . '_tablePemesananMenuDiet', ['model' => $model]);
          Yii::app()->end();
        }
      }
      $this->render($this->path_view . 'informasiPasien', array(
          'model' => $model,
          'modelRawatInap'=>$modelRawatInap
      ));
  }

  private function pesanMenuDietOtomatis() {
    // mengambil data pemesanan menu diet yang pertama kali di pesan dan sekalian cek hari ini sudah ada pemesanan
    // Mengambil instance dari CDbConnection
    $db = Yii::app()->db;

    // Membuat objek CDbCommand untuk kueri SELECT
    $command = $db->createCommand("
        SELECT 
            nomer, data_all.pesanmenudiet_id as parent_pesanmenudiet_id, data_all.ruangan_id, data_all.kirimmenudiet_id, data_all.jenisdiet_id, data_all.bahandiet_id, 
            data_all.jenispesanmenu, data_all.adaalergimakanan, data_all.keterangan_pesan, 
            data_all.nama_pemesan, data_all.totalpesan_org, data_all.create_ruangan, data_all.pasien_id, data_all.pendaftaran_id, data_all.tipediet 
        FROM (
            SELECT 
                ROW_NUMBER() OVER (PARTITION BY ps.pasienadmisi_id ORDER BY pesanmenudiet_id DESC) AS nomer, 
                pesanmenudiet_id,
                ps.ruangan_id, kirimmenudiet_id, jenisdiet_id, bahandiet_id, 
                jenispesanmenu, adaalergimakanan, keterangan_pesan, 
                nama_pemesan, totalpesan_org, t.create_ruangan, pt.pasien_id, t.pendaftaran_id, tipediet 
            FROM pesanmenudiet_t t
            JOIN pendaftaran_t pt ON pt.pendaftaran_id = t.pendaftaran_id
            JOIN pasienadmisi_t ps ON ps.pasienadmisi_id = pt.pasienadmisi_id AND ps.pasienpulang_id IS NULL
        ) AS data_all
        LEFT JOIN pesanmenudiet_t val ON val.tglpesanmenu::DATE = '" . date('Y-m-d') . "' AND data_all.pendaftaran_id = val.pendaftaran_id
        WHERE data_all.nomer = 1 AND val.pesanmenudiet_id IS NULL
    ");

    // Mengeksekusi kueri dan mengambil hasilnya dalam bentuk array
    $result = $command->queryAll();
          // echo '<pre>';var_dump($result);die;
    $transaction = Yii::app()->db->beginTransaction();
    $save = true;
    try {
      if(!empty($result) && count($result) > 0) {
        foreach ($result as $data) {
            $modPesanMenu = new PesanmenudietT();
            $modPesanMenu->attributes = $data;
            $modPesanMenu->tglpesanmenu = date('Y-m-d H:i:s');
            $modPesanMenu->nopesanmenu = MyGenerator::noPesanMenuDiet();
            $modPesanMenu->parent_pesanmenudiet_id = $data['parent_pesanmenudiet_id'];
            $modPesanMenu->auto_insert_detail = false;
            $modPesanMenu->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $modPesanMenu->create_ruangan = Yii::app()->user->getState('ruangan_id');
            // echo '<pre>';var_dump($modPesanMenu);die;
            if (!$modPesanMenu->save()) {
                $save = false;
                $transaction->rollback();
                // Proses error atau tindakan yang diperlukan jika penyimpanan gagal
            }
            // echo '<pre>';var_dump($modPesanMenu->getErrors());die;
        }
      }
      if($save) {
        $transaction->commit();
      }
      // Proses yang diperlukan jika semua data berhasil disimpan
    } catch (Exception $e) {
        $transaction->rollback();
        // Proses yang diperlukan jika terjadi kesalahan dalam transaksi
        // echo '<pre>';var_dump($e);die;
    }
    
    // echo '<pre>';var_dump($result);die;
  }

  function actionVerifikasi() {
    $pesanmenudetail_id = $_POST['pesanmenudetail_id'];
    $update = PesanmenudetailT::model()->updateByPk($pesanmenudetail_id, [
      'verifikasi_id' => Yii::app()->user->getState('pegawai_id'),
      'tgl_verif' => date('Y-m-d H:i:s')
    ]);

    if($update) {
      $data['sukses'] = 1;
    } else {
      $data['sukses'] = 0;
    }

    echo json_encode($data);
  }

  function actionVerifikasiAll() {
    $jeniswaktu_id = $_POST['jeniswaktu_id'];

    if(!empty($jeniswaktu_id)) {
      $update = PesanmenudetailT::model()->updateAll([
        'verifikasi_id' => Yii::app()->user->getState('pegawai_id'),
        'tgl_verif' => date('Y-m-d H:i:s')
      ], 'verifikasi_id is null and jeniswaktu_id = ' . $jeniswaktu_id);
    } else {
      $update = PesanmenudetailT::model()->updateAll([
        'verifikasi_id' => Yii::app()->user->getState('pegawai_id'),
        'tgl_verif' => date('Y-m-d H:i:s')
      ], 'verifikasi_id is null');
    }

    if($update) {
      $data['sukses'] = 1;
    } else {
      $data['sukses'] = 0;
    }

    echo json_encode($data);
  }

  public function actionInformasiPendamping($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pemesanan Menu Diet Pendamping";
    $model = new GZPesanmenudietT('searchInformasiPendamping');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $model->jenispesanmenu = Params::JENISPESANMENU_PENDAMPING;

    if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_GIZI) {
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }

    if (isset($_GET['GZPesanmenudietT'])) {
      $model->attributes = $_GET['GZPesanmenudietT'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZPesanmenudietT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZPesanmenudietT']['tgl_akhir']);
      if (isset($_GET['GZPesanmenudietT']['ruangan_id']))
        $model->ruangan_id = $_GET['GZPesanmenudietT']['ruangan_id'];
    }

    $this->render($this->path_view_tamu . 'informasi', array(
      'model' => $model,
      'linkHalaman' => $linkHalaman
    ));
  }

  public function actionTerimaKonfirmasi()
  {
    $idPesan = $_POST['idPesan'];

    if (isset($idPesan)) {
      $data = PesanmenudietT::model()->findByPk($idPesan);
      $data->status_terima = true;
      $data->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
      $data->update_time = date('Y-m-d H:i:s');

      $update = $data->save();

      if ($update) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'sukses',
          ));
          exit;
        }
      }
    } else {
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'gagal',
        ));
        exit;
      }
    }
  }

  public function actionDetailPesanMenuDiet($id)
  {
    $this->layout = '//layouts/iframe';
    $kolomNama = "";

    $modPesan = PesanmenudietT::model()->findByPk($id);
    if ($modPesan->jenispesanmenu == Params::JENISPESANMENU_PASIEN) {
      $criteria = new CDbCriteria();
      $criteria->select = 'pasienadmisi_id, pendaftaran_id, pasien_id,  pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
      $criteria->group = 'pasienadmisi_id, pendaftaran_id, pasien_id, pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
      $criteria->compare('pesanmenudiet_id', $id);
      $modDetailPesan = PesanmenudetailT::model()->findAll($criteria);
      $kolomNama = "Pasien";
    } else {
      $criteria = new CDbCriteria();
      $criteria->select = 'pegawai_id,  pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
      $criteria->group = 'pegawai_id, pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
      $criteria->compare('pesanmenudiet_id', $id);
      $modDetailPesan = PesanmenupegawaiT::model()->findAll($criteria);

      if ($modPesan->jenispesanmenu == Params::JENISPESANMENU_PEGAWAI) {
        $kolomNama = "Pegawai";
      } else if ($modPesan->jenispesanmenu == Params::JENISPESANMENU_PENDAMPING) {
        $kolomNama = "Pendamping";
      }
    }
    $this->render($this->path_view . 'detailInformasi', array(
      'modPesan' => $modPesan,
      'modDetailPesan' => $modDetailPesan,
      'kolomNama' => $kolomNama
    ));
  }

  /**
   * actionAjax untuk mengambil menudiet
   */
  public function actionGetMenuDietDetail()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $pasienadmisi_id = (isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
      $menudiet_id = (isset($_POST['menudiet_id']) ? $_POST['menudiet_id'] : null);
      $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
      $instalasi_id = (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
      $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
      $jenisdiet_id = (isset($_POST['jenisdiet_id']) ? $_POST['jenisdiet_id'] : null);

      $urt = $_POST['urt'];
      $jumlah = $_POST['jumlah'];
      $jeniswaktu = $_POST['jeniswaktu'];
      $pendaftaranId = (isset($_POST['pendaftaranId']) ? $_POST['pendaftaranId'] : null);
      $pasienAdmisi = (isset($_POST['pasienAdmisi']) ? $_POST['pasienAdmisi'] : null);
      $modDetail = new PesanmenudetailT();
      $modJenisWaktu = JeniswaktuM::getJenisWaktu();
      $diet = MenuDietM::model()->findByPK($menudiet_id);
      $jnsDiet = JenisdietM::model()->findByPk($jenisdiet_id);
      $jumlahPasien = empty($pasienAdmisi) ? 0 : count((array)$pasienAdmisi);
      if ($jumlahPasien == 0) {
        $jumlahPasien = 1;
      }
      $dt = array();
      $tr = '';
      for ($i = 0; $i < $jumlahPasien; $i++) {
        $modDetail = new PesanmenudetailT();
        if (empty($pasienAdmisi)) {
          $model = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id, 'pasienadmisi_id' => $pasienadmisi_id));
        } else {
          $model = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaranId[$i], 'ruangan_id' => $ruangan_id, 'pasienadmisi_id' => $pasienAdmisi[$i]));
          //                    echo print_r($model->attributes);
          //                    exit();
        }
        $tr .= '<tr>
						<td>'
          //                            .CHtml::activeHiddenField($modDetail, '[]ruangan_id',array('value'=>$model->ruangan_id))
          . CHtml::checkBox('PesanmenudetailT[][checkList]', true, array('class' => 'cekList', 'onclick' => 'hitungSemua()'))
          . CHtml::activeHiddenField($modDetail, '[]pendaftaran_id', array('value' => $model->pendaftaran_id))
          . CHtml::activeHiddenField($modDetail, '[]pasien_id', array('value' => $model->pasien_id, 'class' => 'pasienNama'))
          . CHtml::activeHiddenField($modDetail, '[]pasienadmisi_id', array('value' => $model->pasienadmisi_id))
          . CHtml::activeHiddenField($jnsDiet, '[]jenisdiet_id', array('value' => $jenisdiet_id . '-' . $pasien_id, 'class' => 'jenisDiet'))
          . '</td>
						<td>' . RuanganM::model()->with('instalasi')->findByPk($ruangan_id)->instalasi->instalasi_nama . '/ ' . $model->ruangan_nama . '</td>
						<td>' . $model->no_pendaftaran . '</td>
						<td>' . $model->no_rekam_medik . '</td>
                                                <td>' . $model->nama_pasien . '</td>
						<td>' . $model->jeniskelamin . '/ <br/>' . $model->umur . '</td>
						<td>' . $jnsDiet->jenisdiet_nama . '</td>';
        foreach ($modJenisWaktu as $v) {
          if (in_array($v->jeniswaktu_id, $jeniswaktu)) {
            $tr .= '<td>' . CHtml::hiddenField('PesanmenudetailT[][jeniswaktu_id][' . $v->jeniswaktu_id . ']', $v->jeniswaktu_id)
              . CHtml::dropDownList('PesanmenudetailT[][menudiet_id][' . $v->jeniswaktu_id . ']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 menudiet', 'options' => array("$menudiet_id" => array("selected" => "selected")))) . '</td>';
          } else {
            $tr .= '<td>' . CHtml::hiddenField('PesanmenudetailT[][jeniswaktu_id][' . $v->jeniswaktu_id . ']', $v->jeniswaktu_id)
              . CHtml::dropDownList('PesanmenudetailT[][menudiet_id][' . $v->jeniswaktu_id . ']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 menudiet',)) . '</td>';
          }
        }
        $tr .= '<td>' . CHtml::activeTextField($modDetail, '[]jml_pesan_porsi', array('value' => $jumlah, 'class' => ' span1 numbersOnly', 'style' => 'text-align: right;')) . '</td>' .
        '<td>' . CHtml::activeTextField($modDetail, '[]satuanjml_urt', array('value' => $urt, 'class' => ' span2 urt', 'style' => 'text-align: left;', 'readonly' => true)) . '</td>
        </tr>';
      }
      $dt['tr'] = $tr;
      $dt['jenisDietPasien'] = $jenisdiet_id . '-' . $pasien_id;
      $dt['namaPasien'] = $model->nama_pasien;
      $dt['jenisDiet'] = $jnsDiet->jenisdiet_nama;
      echo json_encode($dt);
      Yii::app()->end();
    }
  }

  //-- Gizi -- 
  //Get List Jenis Diet untuk Pemesanan Menu Diet
  public function actionJenisDiet()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(jenisdiet_nama)', strtolower($_GET['term']), true);
      $criteria->order = 'jenisdiet_id';
      $models = JenisdietM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->jenisdiet_nama;
        $returnVal[$i]['value'] = $model->jenisdiet_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  //-- Gizi -- 
  //Get List Pasien untuk Pemesanan Menu Diet
  public function actionPasienUntukMenuDiet()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_GET['ruangan_id'];
      if (!empty($ruangan_id)) {
        $criteria = new CDbCriteria();
        //                $criteria->with =array('pasien', 'ruangan');  
        $criteria->compare('LOWER(nama_pasien)', strtolower($_GET['term']), true);
        if (!empty($ruangan_id)) {
          $criteria->compare('ruangan_id', $ruangan_id);
        }
        $criteria->order = 'nama_pasien';
        $models = InfokunjunganriV::model()->findAll($criteria);
        $returnVal = array();
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id = ' . $model->penjamin_id);
          $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien . ' - ' . $model->ruangan_nama;
          $returnVal[$i]['value'] = $model->pasien_id;
          $returnVal[$i]['jenistarif_id'] = isset($modJenisTarif->jenistarif_id) ? $modJenisTarif->jenistarif_id : null;
        }

        echo CJSON::encode($returnVal);
      }
    }
    Yii::app()->end();
  }

  //-- Gizi -- 
  //Get List Menu Diet untuk Pemesanan Menu Diet
  public function actionMenuDiet()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $penjamin_id;
      if (isset($_GET['penjamin_id'])) {
        $penjamin_id = $_GET['penjamin_id'];
      }

      $jt = JenistarifpenjaminM::model()->findByAttributes(array(
        'penjamin_id' => $penjamin_id
      ));

      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(t.menudiet_nama)', strtolower($_GET['term']), true);
      if (!empty($_GET['kelaspelayanan_id'])) {
        $criteria->compare('tariftindakan_m.kelaspelayanan_id', $_GET['kelaspelayanan_id']);
      }
      if (!empty($_GET['jenisdiet_id'])) {
        $criteria->compare('t.jenisdiet_id', $_GET['jenisdiet_id']);
      }
      if (!empty($penjamin_id)) {
        $criteria->compare('tariftindakan_m.jenistarif_id', $jt->jenistarif_id);
      }
      $criteria->order = 't.menudiet_nama';
      $criteria->join = 'JOIN tariftindakan_m on tariftindakan_m.daftartindakan_id = t.daftartindakan_id
							   JOIN kelaspelayanan_m on kelaspelayanan_m.kelaspelayanan_id = tariftindakan_m.kelaspelayanan_id';
      $criteria->addCondition('tariftindakan_m.komponentarif_id = 6');
      $criteria->limit = 5;
      $models = MenuDietM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->menudiet_nama;
        $returnVal[$i]['value'] = $model->menudiet_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  //-- Gizi -- 
  //Get List Bahan Diet untuk Pemesanan Menu Diet
  public function actionBahanDiet()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(bahandiet_nama)', strtolower($_GET['term']), true);
      $criteria->order = 'bahandiet_id';
      $models = BahandietM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->bahandiet_nama;
        $returnVal[$i]['value'] = $model->bahandiet_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  // ajax untuk mengambil menu diet pegawai
  public function actionGetMenuDietPegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modDetail = new PesanmenupegawaiT();

      $pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : Yii::app()->user->getState('pegawai_id'));
      $menudiet_id = (isset($_POST['menudiet_id']) ? $_POST['menudiet_id'] : null);
      $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
      $instalasi_id = (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);

      $urt = $_POST['urt'];
      $jumlah = $_POST['jumlah'];
      $jeniswaktu = $_POST['jeniswaktu'];
      $pegawaiId = (isset($_POST['pegawaiId']) ? $_POST['pegawaiId'] : null);

      $jumlahPesan = !is_array($pegawaiId) ? 1 : count((array)$pegawaiId);
      if (!is_array($pegawaiId) || $jumlahPesan < 1) {
        $pegawaiId = array($pegawai_id);
      }
      $tr = '';
      foreach ($pegawaiId as $i => $pegawai_id) {
        $model = PegawaiM::model()->findByPk($pegawai_id);
        $nama = $model->nama_pegawai;
        $jeniskelamin = $model->jeniskelamin;
        $tr .= '<tr>
                        <td>'
          . CHtml::checkBox('PesanmenupegawaiT[][' . $ruangan_id . '][checkList]', true, array('class' => 'cekList', 'onclick' => 'hitungSemua()'))
          . CHtml::activeHiddenField($modDetail, '[][' . $ruangan_id . ']pegawai_id', array('value' => $model->pegawai_id))
          . CHtml::hiddenField('PesanmenupegawaiT[][' . $ruangan_id . '][ruangan_id]', $ruangan_id)
          . '</td>
                        <td>' . RuanganM::model()->with('instalasi')->findByPk($ruangan_id)->instalasi->instalasi_nama . '/<br/>' . RuanganM::model()->findByPk($ruangan_id)->ruangan_nama . '</td>
                        <td>' . CHtml::textField('nama', $nama, array('readonly' => true, 'class' => 'span2 nama')) . '</td>
                        <td>' . $jeniskelamin . '</td>';
        foreach (JeniswaktuM::getJenisWaktu() as $v) {
          if (in_array($v->jeniswaktu_id, $jeniswaktu)) {
            $tr .= '<td>' . CHtml::hiddenField('PesanmenupegawaiT[][' . $ruangan_id . '][jeniswaktu_id][' . $v->jeniswaktu_id . ']', $v->jeniswaktu_id)
              . CHtml::dropDownList('PesanmenupegawaiT[][' . $ruangan_id . '][menudiet_id][' . $v->jeniswaktu_id . ']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 menudiet', 'options' => array($menudiet_id => array("selected" => "selected")))) . '</td>';
          } else {
            $tr .= '<td>' . CHtml::hiddenField('PesanmenupegawaiT[][' . $ruangan_id . '][jeniswaktu_id][' . $v->jeniswaktu_id . ']', $v->jeniswaktu_id)
              . CHtml::dropDownList('PesanmenupegawaiT[][' . $ruangan_id . '][menudiet_id][' . $v->jeniswaktu_id . ']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 menudiet',)) . '</td>';
          }
        }
        $tr .= '<td>' . CHtml::activeTextField($modDetail, '[][' . $ruangan_id . ']jml_pesan_porsi', array('value' => $jumlah, 'class' => ' span1 numbersOnly',)) . '</td>
                        <td>' . CHtml::activeDropDownList($modDetail, '[][' . $ruangan_id . ']satuanjml_urt', LookupM::getItems('ukuranrumahtangga'), array('empty' => '-- Pilih --', 'class' => 'span2 urt', 'options' => array($urt => array("selected" => "selected")))) . '</td>
                        </tr>';
      }
      echo json_encode($tr);
      Yii::app()->end();
    }
  }

  /**
   * set dropdown penjamin dari carabayar_id
   * @param type $encode
   * @param type $namaModel
   */
  public function actionSetDropdownPenjamin($encode = false, $namaModel = '')
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
   * set dropdown ruangan dari instalasi_id
   * @param type $encode
   * @param type $namaModel
   */
  public function actionSetDropdownRuangan($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = $_POST["$namaModel"]['instalasi_id'];
      if ($encode) {
        echo CJSON::encode($ruangan);
      } else {
        if (empty($instalasi_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $ruangan = RuanganM::model()->findAllByAttributes(array('instalasi_id' => $instalasi_id, 'ruangan_aktif' => true), array('order' => 'ruangan_nama ASC'));
          if (count((array)$ruangan) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $ruangan = CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama');
          foreach ($ruangan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }


  public function actionSetDropdownRuangan2($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = $_POST["$namaModel"]['instalasi_id'];
      if ($encode) {
        echo CJSON::encode($ruangan);
      } else {
        if (empty($instalasi_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $ruangan = RuanganM::model()->findAllByAttributes(array('instalasi_id' => $instalasi_id, 'ruangan_aktif' => true), array('order' => 'ruangan_nama ASC'));
          if (count((array)$ruangan) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $ruangan = CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama');
          foreach ($ruangan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  /*
     * untuk pembatalan pemesanan menu diet 
     */

  public function actionBatalMenuDiet()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idPesanDiet = $_POST['idPesanDiet'];
      $modelPesan = new PesanmenudietT;
      $model = PesanmenudietT::model()->findByPk($idPesanDiet);
      $modDetail = PesanmenudetailT::model()->findAllByAttributes(array('pesanmenudiet_id' => $model->pesanmenudiet_id));
      $modPegawai = PesanmenupegawaiT::model()->findAllByAttributes(array('pesanmenudiet_id' => $model->pesanmenudiet_id));

      $totDet = count((array)$modDetail);
      $totPeg = count((array)$modPegawai);

      if (isset($_POST['PesanmenupegawaiT']) || isset($_POST['PesanmenudetailT'])) {
        if (count((array)$modDetail) > 0 || count((array)$modPegawai) > 0) {
          if (count((array)$modPegawai) > 0) {
            // Untuk Menghapus Pesan Menu Diet untuk Pegawai
            if (count((array)$_POST['PesanmenupegawaiT']) > 0) {
              foreach ($_POST['PesanmenupegawaiT'] as $i => $v) {
                if (isset($v['checkList'])) {
                  if (empty($v['kirimmenupegawai_id'])) {
                    $detail = false;
                  } else {
                    $detail = true;
                    $updatePesanPegawai = PesanmenupegawaiT::model()->updateByPk($v['pesanmenupegawai_id'], array('kirimmenupegawai_id' => null));
                    $updateKirimPegawai = KirimmenupegawaiT::model()->updateByPk($v['kirimmenupegawai_id'], array('pesanmenupegawai_id' => null));
                    if (count((array)$modPegawai) <= 1) {
                      $updatePesanDiet = KirimmenudietT::model()->updateByPk($v['kirimmenudiet_id'], array('pesanmenudiet_id' => null));
                      $updateKirimDiet = PesanmenudietT::model()->updateByPk($idPesanDiet, array('kirimmenudiet_id' => null));
                    }
                  }

                  if ($detail == true) {
                    $deletePegawai = PesanmenupegawaiT::model()->deleteByPk($v['pesanmenupegawai_id']);
                    if ($updatePesanPegawai && $updatePesanDiet && $updateKirimPegawai && $updateKirimDiet) {
                      $delete = true;
                    } else {
                      $delete = false;
                    }
                  } else {
                    $deletePegawai = PesanmenupegawaiT::model()->deleteByPk($v['pesanmenupegawai_id']);
                    if ($deletePegawai) {
                      $delete = true;
                    } else {
                      $delete = false;
                    }
                  }
                  $totPeg = count(PesanmenupegawaiT::model()->findAllByAttributes(array('pesanmenudiet_id' => $idPesanDiet)));
                }
              }
              if ($delete == true) {
                if ($totPeg < 1) {
                  PesanmenudietT::model()->deleteByPk($idPesanDiet);
                }
                echo CJSON::encode(array(
                  'status' => 'proses_form',
                  'pesan' => 'Berhasil',
                  'keterangan' => '',
                  'total' => $totPeg,
                  'div' => "<div class='flash-success'>Pemesanan Menu Diet <b></b> berhasil dibatalkan </div>",
                ));
                exit;
              } else {
                echo CJSON::encode(array(
                  'status' => 'proses_form',
                  'pesan' => 'Gagal',
                  'keterangan' => '',
                  'total' => $totPeg,
                  'div' => "<div class='flash-success'>Pemesanan Menu Diet <b></b> gagal dibatalkan </div>",
                ));
                exit;
              }
            }
          } else {
            if (count((array)$_POST['PesanmenudetailT']) > 0) {
              $jml = 0;
              foreach ($_POST['PesanmenudetailT'] as $i => $v) {
                if (isset($v['checkList'])) {
                  //                            foreach($modDetail as $i=>$detail){
                  if (empty($v['kirimmenupasien_id'])) {
                    $details = false;
                  } else {
                    $details = true;
                    $updatePesanPasien = PesanmenudetailT::model()->updateByPk($v['pesanmenudetail_id'], array('kirimmenupasien_id' => null));
                    $updateKirimPasien = KirimmenupasienT::model()->updateByPk($v['kirimmenupasien_id'], array('pesanmenudetail_id' => null));

                    if (count((array)$modDetail) <= 1) {
                      $updatePesanDiet = KirimmenudietT::model()->updateByPk($v['kirimenudiet_id'], array('pesanmenudiet_id' => null));
                      $updateKirimDiet = PesanmenudietT::model()->updateByPk($idPesanDiet, array('kirimmenudiet_id' => null));
                    }
                  }
                  //                            }
                  // Untuk Menghapus menu Gizi dari PesanmenudetailT                    
                  if ($details == true) {
                    $deleteDetail = PesanmenudetailT::model()->deleteByPk($v['pesanmenudetail_id']);
                    if ($updatePesanPasien && $updatePesanDiet && $updateKirimPasien && $updateKirimDiet && $deleteDetail) {
                      $tindakan = true;
                    } else {
                      $tindakan = false;
                    }
                  } else {
                    $deleteDetail = PesanmenudetailT::model()->deleteByPk($v['pesanmenudetail_id']);
                    if ($deleteDetail) {
                      $tindakan = true;
                    } else {
                      $tindakan = false;
                    }
                  }
                  $jml++;
                  $totDet = count(PesanmenudetailT::model()->findAllByAttributes(array('pesanmenudiet_id' => $idPesanDiet)));
                }
              }
              if ($tindakan == true) {
                if ($totDet < 1) {
                  PesanmenudietT::model()->deleteByPk($idPesanDiet);
                }
                // Untuk Menghapus Data Kirim Menu Diet dari PesanmenudietT
                echo CJSON::encode(array(
                  'status' => 'proses_form',
                  'pesan' => 'Berhasil',
                  'keterangan' => '',
                  'total' => $totDet,
                  'div' => "<div class='flash-success'>Pemesanan Menu Diet <b></b> berhasil dibatalkan </div>",
                ));
                exit;
              } else {
                echo CJSON::encode(array(
                  'status' => 'proses_form',
                  'pesan' => 'Gagal',
                  'keterangan' => '',
                  'total' => $totDet,
                  'div' => "<div class='flash-success'>Pemesanan Menu Diet <b></b> gagal dibatalkan </div>",
                ));
                exit;
              }
            }
          }
        }
      }
      $path = $this->path_view;

      if ($model->jenispesanmenu == Params::JENISPESANMENU_PENDAMPING) {
        $path = $this->path_view_tamu;
      }
      echo CJSON::encode(array(
        'status' => 'create_form',
        'idPesan' => $idPesanDiet,
        'total' => $totDet,
        'div' => $this->renderPartial($path . '_formBatalPesanDiet', array('modelPesan' => $modelPesan, 'modDetail' => $modDetail, 'modPegawai' => $modPegawai, 'model' => $model), true)
      ));
      exit;
    }
  }

  public function actionPrintGizi($pesanmenudiet_id, $caraPrint = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $model = GZPesanmenudietT::model()->findByPk($pesanmenudiet_id);
    $modDet = GZPesanmenudetailT::model()->findAll("pesanmenudiet_id = $pesanmenudiet_id");


    $judul_print = 'Etiket Gizi';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      //            $this->layout='//layouts/printWindows';
    }

    $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
    $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
    $mpdf = new MyPDF60('', array(75, 100));
    ob_clean();
    $mpdf->mirrorMargins = 0;
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/ETICKET.css');
    $mpdf->WriteHTML($formatkonten, 1);
    $mpdf->AddPage($posisi, '', '', '', '', 5, 5, 5, 5, 0, 0);
    $mpdf->setHtmlFooter('<span></span>');
    //$mpdf->SetHtmlFooter($this->renderPartial("application.views.footer._footerLabel", array(), true),'O');
    $mpdf->WriteHTML(
      $this->renderPartial($this->path_view . 'PrintEtiketNew', array(
        'format' => $format,
        'judul_print' => $judul_print,
        'model' => $model,
        'modDet' => $modDet,
        'caraPrint' => $caraPrint
      ), true)
    );
    $mpdf->SetJS('this.print();');
    $mpdf->Output();

    // echo $this->renderPartial($this->path_view . 'PrintEtiketNew', array(
      // 'format' => $format,
      // 'judul_print' => $judul_print,
      // 'model' => $model,
      // 'modDet' => $modDet,
      // 'caraPrint' => $caraPrint
    // ), true);
  }

  public function actionPrintInformasiPasien($caraPrint)
  {
    $format = new MyFormatter();
    $model = new GZPesanmenudietT('searchInformasiMenuPasienPrint');

    $model->unsetAttributes();  // clear any default values
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['GZPesanmenudietT'])) {
      $model->attributes = $_GET['GZPesanmenudietT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZPesanmenudietT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZPesanmenudietT']['tgl_akhir']);
    }

    $path = $this->path_view;

    $this->printFunction($model, $caraPrint, "Informasi Pemesanan Menu Diet Pasien", $path . "printInformasiPasienNew");
  }




  public function actionPrintAllEtiket($caraPrint)
  {
    $format = new MyFormatter();
    $model = new GZPesanmenudietT('searchInformasiMenuPasienPrint');

    $model->unsetAttributes();  // clear any default values
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $judul_print = 'Etiket Gizi';
    if (isset($_GET['GZPesanmenudietT'])) {
      $model->attributes = $_GET['GZPesanmenudietT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZPesanmenudietT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZPesanmenudietT']['tgl_akhir']);
      $model->jeniswaktu_id = $_GET['GZPesanmenudietT']['jeniswaktu_id'];

    }
    $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
    $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
    $mpdf = new MyPDF60('', array(60, 80));
    ob_clean();
    $mpdf->mirrorMargins = 0;
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/ETICKET.css');
    $mpdf->WriteHTML($formatkonten, 1);
    $mpdf->AddPage($posisi, '', '', '', '', 3, 3, 3, 3, 0, 0);
    $mpdf->setHtmlFooter('<span></span>');

    //$mpdf->SetHtmlFooter($this->renderPartial("application.views.footer._footerLabel", array(), true),'O');
    $mpdf->WriteHTML(
      $this->renderPartial($this->path_view . 'printInformasiEtiket', array(
        'format' => $format,
        'judul_print' => $judul_print,
        'model' => $model,
        'caraPrint' => $caraPrint
      ), true)
    );
    $mpdf->SetJS('this.print();');
    $mpdf->Output();

    // $path = $this->path_view;

    // $this->printFunction($model, $caraPrint, "Informasi Pemesanan Menu Diet Pasien", $path . "printInformasiEtiket");
  }

  public function actionPrintInformasiPegawai($caraPrint)
  {
    $format = new MyFormatter();
    $model = new GZPesanmenudietT();

    $model->unsetAttributes();  // clear any default values
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['GZPesanmenudietT'])) {
      $model->attributes = $_GET['GZPesanmenudietT'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZPesanmenudietT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZPesanmenudietT']['tgl_akhir']);
    }

    $path = $this->path_view;

    $this->printFunction($model, $caraPrint, "Informasi Pemesanan Menu Diet Pegawai", $path . "printInformasiPegawai");
  }

  public function actionPrintInformasiPendamping($caraPrint)
  {
    $model = new GZPesanmenudietT('searchInformasiPendamping');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $model->jenispesanmenu = Params::JENISPESANMENU_PENDAMPING;

    if (Yii::app()->user->getState('ruangan_id') != Params::RUANGAN_ID_GIZI) {
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }

    if (isset($_GET['GZPesanmenudietT'])) {
      $model->attributes = $_GET['GZPesanmenudietT'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZPesanmenudietT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZPesanmenudietT']['tgl_akhir']);
      if (isset($_GET['GZPesanmenudietT']['ruangan_id']))
        $model->ruangan_id = $_GET['GZPesanmenudietT']['ruangan_id'];
    }


    $path = $this->path_view_tamu;

    $this->printFunction($model, $caraPrint, "Informasi Pemesanan Menu Diet Pendamping", $path . "printInformasi");
  }

  protected function printFunction($model, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = 'L';                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->setHtmlFooter('<span></span>');


      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * Load halaman cetak label makanan
   * @param type $pesanmenudiet_id
   */
  public function actionCetakLabel($pesanmenudiet_id)
  {
      $this->layout = '//layouts/iframe';
      $modPesan = PesanmenudietT::model()->findByPk($pesanmenudiet_id);
      if ($modPesan->jenispesanmenu == Params::JENISPESANMENU_PASIEN) {
          $criteria = new CDbCriteria();
          $criteria->select = 't.*';
          $criteria->join = " JOIN pasienadmisi_t p ON p.pasienadmisi_id = t.pasienadmisi_id ";
          $criteria->addCondition("pesanmenudiet_id = ".$pesanmenudiet_id);
          $criteria->addCondition("pasienpulang_id IS NULL");
          $modDetailPesan = PesanmenudetailT::model()->findAll($criteria);
          $model = new PesanmenudetailT;
      } else {
          $modDetailPesan = PesanmenupegawaiT::model()->findAllByAttributes(array('pesanmenudiet_id' => $pesanmenudiet_id));
          $model = new PesanmenupegawaiT;
      }
      $this->render($this->path_view . '_cetakLabel', array(
          'modPesan' => $modPesan,
          'modDetailPesan' => $modDetailPesan,
          'pesanmenudiet_id' => $pesanmenudiet_id,
          'model' => $model
      ));
  }

  /**
   * Digunakan untuk set data yang dipilih kedalam session
   */
  public function actionSetprint()
  {
      if (Yii::app()->request->isAjaxRequest) {
          $data['sukses'] = 0;
          $id = isset($_POST['id']) ? $_POST['id'] : null;

          Yii::app()->user->setState('pilih_print', $id);

          echo CJSON::encode($data);
      }
  }

  /**
   * Fungsi Cetak label makanan pdf
   */
  public function actionCetakLabelMakanan()
  {
      $pesanmenudiet_id = $_REQUEST['PesanmenudietT']['pesanmenudiet_id'];
      $jenispesanmenu = $_REQUEST['PesanmenudietT']['jenispesanmenu'];
      $tgl_kirim = $_REQUEST['PesanmenudietT']['tgl_kirim'];

      $konvert = MyFormatter::formatDateTimeForDb($tgl_kirim);

      $modPesan = PesanmenudietT::model()->findByPk($pesanmenudiet_id);
      $criteria = new CDbCriteria();
      $criteria->addCondition('pesanmenudiet_id = ' . $pesanmenudiet_id);

      if ($modPesan->jenispesanmenu == Params::JENISPESANMENU_PASIEN) {
          if (!empty(Yii::app()->user->getState('pilih_print'))) {
              $criteria->addInCondition('pesanmenudetail_id', Yii::app()->user->getState('pilih_print'));
          } else {
              $criteria->addCondition('pesanmenudetail_id=null'); //jika tidak ada data yang dipilih
          }
          $modDetailPesan = PesanmenudetailT::model()->findAll($criteria);
          $model = new PesanmenudetailT;
      } else {
          if (!empty(Yii::app()->user->getState('pilih_print'))) {
              $criteria->addInCondition('pesanmenupegawai_id', Yii::app()->user->getState('pilih_print'));
          } else {
              $criteria->addCondition('pesanmenupegawai_id=null'); //jika tidak ada data yang dipilih
          }
          $modDetailPesan = PesanmenupegawaiT::model()->findAll($criteria);
          $model = new PesanmenupegawaiT;
      }
      $judulLaporan = 'Label Makanan';
      $caraPrint = $_REQUEST['caraPrint'];
      if ($caraPrint == 'PRINT') {
          $this->layout = '//layouts/printWindows';
          foreach ($modDetailPesan as $key => $value) {
              $this->render($this->path_view . '_labelMakanan', array('val' => $value, 'jenispesanmenu' => $jenispesanmenu, 'modPesan' => $modPesan, 'tgl_kirim' => $konvert, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
          }
      } else {   
          $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');      //Ukuran Kertas Pdf
          $posisi = Yii::app()->user->getState('posisi_kertas');         //Posisi L->Landscape,P->Portait
          $mpdf = new MyPDF60('', [60, 80]);
          $mpdf->SetHTMLFooter('<span></span>');
          
          foreach ($modDetailPesan as $key => $value) {
              $mpdf->mirrorMargins = 0;
              $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
          $mpdf->WriteHTML($stylesheet, 1);
          $mpdf->AddPage($posisi, '', '', '', '', 3, 3, 3, 3, 0, 0);

          $mpdf->WriteHTML($this->renderPartial($this->path_view . '_labelMakanan', array(
            'val' => $value, 
            'jenispesanmenu' => $jenispesanmenu, 
            'modPesan' => $modPesan, 
            'tgl_kirim' => $konvert, 
            'judulLaporan' => $judulLaporan, 
            'caraPrint' => $caraPrint
          ), true));
      }

      $mpdf->SetJS('this.print();');
      $mpdf->Output();

      }
  }

  public function actionCetakInformasiLabelMakanan()
  {
      $jeniswaktu_id = $_REQUEST['jeniswaktu_id'];

      $kofig = KonfigsystemK::model()->find();


      
      
      $criteria = new CDbCriteria();
      $criteria->join = " JOIN jeniswaktu_m as j ON j.jeniswaktu_id = t.jeniswaktu_id JOIN pesanmenudiet_t p on t.pesanmenudiet_id = p.pesanmenudiet_id
      JOIN pesanmenudetail_t as pasienpeg ON pasienpeg.pesanmenudiet_id = t.pesanmenudiet_id JOIN pasienadmisi_t on pasienpeg.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id JOIN pasien_m as pasien on pasienpeg.pasien_id = pasien.pasien_id JOIN kamarruangan_m on pasienadmisi_t.kamarruangan_id = kamarruangan_m.kamarruangan_id JOIN ruangan_m on ruangan_m.ruangan_id = pasienadmisi_t.ruangan_id
      ";
      $criteria->select = "t.*, j.*, p.tglpesanmenu,p.ruangan_id,pasien.nama_pasien, pasien.no_rekam_medik,pasienadmisi_t.pasienadmisi_id";
      
      
              $criteria->group = 'p.pesanmenudiet_id, pasien.nama_pasien, pasien.no_rekam_medik,pasienadmisi_t.pasienadmisi_id, pasienadmisi_t.kamarruangan_id,kamarruangan_m.kamarruangan_nobed,kamarruangan_m.kamarruangan_nokamar,ruangan_m.ruangan_nama,t.pesanmenudetail_id,j.jeniswaktu_id';

      if(!empty($jeniswaktu_id)){
          $criteria->addCondition('j.jeniswaktu_id = ' . $jeniswaktu_id);
      }else{
          if($kofig->est_cetaklabelmakanan == true){
              $time_now = date('H:i:s');
              if($time_now > $kofig->est_labelmakanpagi || $time_now < $kofig->est_labelmakansiang){
                  $criteria->addCondition("jam_cetak > '".$kofig->est_labelmakanpagi."' or jam_cetak < '".$kofig->est_labelmakansiang."'" );
              }else if($time_now > $kofig->est_labelmakansiang && $time_now < $kofig->est_labelmakansore){
                  $criteria->addCondition("jam_cetak > '".$kofig->est_labelmakansiang."' and jam_cetak < '".$kofig->est_labelmakansore."'" );
              }else if($time_now > $kofig->est_labelmakansore && $time_now < $kofig->est_labelmakanpagi){
                  $criteria->addCondition("jam_cetak > '".$kofig->est_labelmakansore."' and jam_cetak < '".$kofig->est_labelmakanpagi."'" );
              }
          }
      }
      if (!empty(Yii::app()->user->getState('pilih_print'))) {
          $criteria->addInCondition('t.pesanmenudiet_id', Yii::app()->user->getState('pilih_print'));
      } else {
          $criteria->addCondition('t.pesanmenudiet_id=null');
      }

      // $criteria->order = 'tglpesanmenu DESC';
      // $criteria->order = 'ruangan_id ASC';
      
      $criteria->order = 'ruangan_m.ruangan_nama ASC, kamarruangan_m.kamarruangan_nokamar ASC,kamarruangan_nobed ASC';
      $modDetailPesan = PesanmenudetailT::model()->findAll($criteria);
      $model = new PesanmenudetailT;
  

      $judulLaporan = 'Label Makanan';
      $caraPrint = $_REQUEST['caraPrint'];
      if ($caraPrint == 'PRINT') {
          $this->layout = '//layouts/printWindows';
          $this->render($this->path_view . '_labelMakanan', array('model' => $modDetailPesan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      } else {   
          $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');      //Ukuran Kertas Pdf
          $posisi = Yii::app()->user->getState('posisi_kertas');         //Posisi L->Landscape,P->Portait
          $mpdf = new MyPDF60('', [60, 80]);
          $mpdf->SetHTMLFooter('<span></span>');
          
          foreach ($modDetailPesan as $key => $value) {
          $modPesan = PesanmenudietT::model()->findByPk($value->pesanmenudiet_id);

          $mpdf->mirrorMargins = 0;
          $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
          $mpdf->WriteHTML($stylesheet, 1);
          $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);

          $mpdf->WriteHTML($this->renderPartial($this->path_view . '_labelMakanan', array('val' => $value, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modPesan' => $modPesan), true));
      }

      $mpdf->SetJS('this.print();');
      $mpdf->Output();

      }
  }
}
