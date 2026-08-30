<?php

class KirimmenudietTController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $successSaveTindakan = true;

  public function actionIndex($idPesan = null, $id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pengiriman Menu Diet Pasien";
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new GZKirimmenudietT;
    $modDetailPesan = array();
    $model->jenispesanmenu = Params::JENISPESANMENU_PASIEN;

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

    if (isset($idPesan)) {
      // $modPesan = PesanmenudietT::model()->find('pesanmenudiet_id = ' . $idPesan . ' and kirimmenudiet_id is null');
      if('kirimmenudiet_id' != null ){
        $modPesan = GZPesanmenudietT::model()->find('pesanmenudiet_id = '.$idPesan.'');
      }else{
        $modPesan = GZPesanmenudietT::model()->find('pesanmenudiet_id = '.$idPesan.' and kirimmenudiet_id is null');
      }

      if (!empty($modPesan)) {
        $model->bahandiet_id = $modPesan->bahandiet_id;
        $model->jenisdiet_id = $modPesan->jenisdiet_id;
        $model->pesanmenudiet_id = $idPesan;
        $model->jenispesanmenu = $modPesan->jenispesanmenu;
        $model->instalasi_id = $modPesan->ruangan->instalasi_id;
        $model->ruangan_id = $modPesan->ruangan->ruangan_id;
        
        if ($modPesan->jenispesanmenu == Params::JENISPESANMENU_PASIEN) {
          //                            $modDetailPesan = GZPesanmenudetailT::model()->with('menudiet')->findAllByAttributes(array('pesanmenudiet_id'=>$idPesan));
          $criteria = new CDbCriteria();
          $criteria->select = 'pasienadmisi_id, pendaftaran_id, pasien_id,  pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
          $criteria->group = 'pasienadmisi_id, pendaftaran_id, pasien_id, pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
          $criteria->compare('pesanmenudiet_id', $idPesan);
          $modDetailPesan = GZPesanmenudetailT::model()->findAll($criteria);
        }
        foreach ($modDetailPesan AS $tampilData):
          $model->namaPasien = $tampilData->pasien->nama_pasien;
        endforeach;

      }
    } else {
      $modPesan = null;
      $modDetailPesan = null;
    }

    if (isset($id)) {
      $model = GZKirimmenudietT::model()->findByPk($id);
      $criteria = new CDbCriteria();
      $criteria->select = 'pasienadmisi_id, ruangan_id,pendaftaran_id, pasien_id,  kirimmenudiet_id, jml_kirim, satuanjml_urt,menudiet_id';
      $criteria->group = 'pasienadmisi_id, ruangan_id,pendaftaran_id, pasien_id, kirimmenudiet_id, jml_kirim, satuanjml_urt,menudiet_id';
      $criteria->compare('kirimmenudiet_id', $id);
      $modDetailKirim = GZKirimmenupasienT::model()->findAll($criteria);
    } else {
      $modDetailKirim = null;
    }
    $model->nokirimmenu = 'Otomatis';
    $model->tglkirimmenu = date('d M Y H:i:s');
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['GZKirimmenudietT'])) {
      $model->attributes = $_POST['GZKirimmenudietT'];
      $model->tglkirimmenu = MyFormatter::formatDateTimeForDb($model->tglkirimmenu);
      $model->nokirimmenu = MyGenerator::noKirimMenuDiet();
      $model->create_time = date('Y-m-d H:i:s');
      $model->update_time = date('Y-m-d H:i:s');
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->update_loginpemakai_id = Yii::app()->user->id;

      //                    $model->ruangan_id = $_POST['GZKirimmenudietT']['ruangan_id'];
      //                    $model->instalasi_id = $_POST['GZKirimmenudietT']['instalasi_id'];                    
      $transaction = Yii::app()->db->beginTransaction();

      $notif_target = array();

      try {
        $success = true;
        if ($model->save()) {
          if (!empty($model->pesanmenudiet_id)) {
            PesanmenudietT::model()->updateByPk($model->pesanmenudiet_id, array('kirimmenudiet_id' => $model->kirimmenudiet_id));
          }
          if (count((array)$_POST['KirimmenupasienT']) > 0) {
            foreach ($_POST['KirimmenupasienT'] as $i => $v) {


              if (isset($v['checkList']) && $v['checkList'] == 1) {
                foreach ($v['menudiet_id'] as $j => $x) {
                  if (!empty($x)) {
                    $modDetail = new GZKirimmenupasienT();
                    //$modDetail->attributes = $v;
                    $modDetail->ruangan_id = (isset($v['ruangan_id']) ? $v['ruangan_id'] : Yii::app()->user->getState('ruangan_id'));
                    $modDetail->kirimmenudiet_id = $model->kirimmenudiet_id;
                    $modDetail->pasien_id = $v['pasien_id'];
                    $modDetail->pasienadmisi_id = $v['pasienadmisi_id'];
                    $modDetail->menudiet_id = $x;
                    $modDetail->pendaftaran_id = $v['pendaftaran_id'];
                    $modDetail->pesanmenudetail_id = (isset($v['pesanmenudetail_id'][$j]) ? $v['pesanmenudetail_id'][$j] : null);
                    $modDetail->jeniswaktu_id = $j;
                    $modDetail->jml_kirim = $v['jml_kirim'];
                    $modDetail->satuanjml_urt = $v['satuanjml_urt'];
                    $modDetail->kelaspelayanan_id = $v['kelaspelayanan_id'][$j];
                    $modDetail->hargasatuan = $v['satuanTarif'][$j];

                    if (!empty($modDetail->pasienadmisi_id)) {
                      $admisi = PasienadmisiT::model()->findByPk($modDetail->pasienadmisi_id);
                      $modDetail->kamarruangan_id = $admisi->kamarruangan_id;
                    }

                    //$modDetail->status_menu = $v['status_menu'];
                    //                                                    if(!isset($idPesan)){
                    //                                                        $modDetail->ruangan_id = $model->ruangan_id;
                    //                                                    }
                    $criteria = new CDbCriteria();
                    if (isset($v['pendaftaran_id'][$j])) {
                      $criteria->compare('pendaftaran_id', $v['pendaftaran_id'][$j]);
                    }
                    $modPendaftaran = PendaftaranT::model()->find($criteria);
                    //set null pembayaran supaya muncul di informasi belum bayar
                    if (isset($modPendaftaran)) {
                      PendaftaranT::model()->updateByPk(
                        $modPendaftaran->pendaftaran_id,
                        array('pembayaranpelayanan_id' => null)
                      );
                    }
                    $criteria2 = new CDbCriteria();
                    if (isset($v['pendaftaran_id'][$j])) {
                      $criteria2->compare('pendaftaran_id', $v['pendaftaran_id'][$j]);
                    }
                    $criteria2->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                    $modPasienPenunjang = PasienmasukpenunjangT::model()->find($criteria2);
                    if ($modDetail->save()) {

                      if (empty($notif_target[$modDetail->ruangan_id])) {
                        $notif_target[$modDetail->ruangan_id] = array();
                      }

                      if (!in_array($modDetail->pasien_id, $notif_target[$modDetail->ruangan_id])) {
                        $notif_target[$modDetail->ruangan_id][] = $modDetail->pasien_id;
                      }
                      // SMS GATEWAY
                      $modPasien = $modDetail->pasien;
                      $modRuangan = $modDetail->ruangan;
                      $sms = new Sms();
                      foreach ($modSmsgateway as $i => $smsgateway) {
                        $isiPesan = $smsgateway->templatesms;

                        $attributes = $modPasien->getAttributes();
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
                        $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($model->tglkirimmenu), $isiPesan);
                        $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);

                        if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                          if (!empty($modPasien->no_mobile_pasien)) {
                            $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                          }
                        }
                      }
                      // END SMS GATEWAY

                      if (!empty($modDetail->pesanmenudetail_id)) {
                        GZPesanmenudetailT::model()->updateByPk($modDetail->pesanmenudetail_id, array('kirimmenupasien_id' => $modDetail->kirimmenupasien_id));
                      }

                      if (Yii::app()->user->getState('krngistokgizi') == true) {
                        //echo "aku disini";


                        if (StokbahanmakananT::validasiStokMenu($modDetail->jml_kirim, $modDetail->menudiet_id)) {
                          //echo "aku masuk validasi stok";
                          StokbahanmakananT::kurangiStokMenu($modDetail->jml_kirim, $modDetail->menudiet_id);
                        } else {
                          //echo "aku tidak masuk validasi stok";
                          $success = true;
                        }
                      }

                      //	die;
                    } else {
                      $success = false;
                    }
                  }
                }
              }
            }
            $this->successSaveTindakan = true;
            $this->saveTindakanPelayanan($_POST['KirimmenupasienT']); //RSIH-1889
          } else {

            $success = false;
          }
        } else {

          $success = false;
        }

        $this->kirimNotifKirimMenuDiet($model, $notif_target);

        // var_dump($success, $this->successSaveTindakan); die;
        if ($success == TRUE && $this->successSaveTindakan) {
          //                           
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data ' . $model->nokirimmenu . ' berhasil disimpan.');
          $this->redirect(array('index', 'id' => $model->kirimmenudiet_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }
    if (empty($modPendaftaran)) {
      $modPendaftaran = null;
    }
    if (empty($modPasienPenunjang)) {
      $modPasienPenunjang = null;
    }
    $this->render('index', array(
      'model' => $model, 'modPesan' => $modPesan,
      'modDetailPesan' => $modDetailPesan,
      'modPendaftaran' => $modPendaftaran,
      'modPasienPenunjang' => $modPasienPenunjang,
      'modDetailKirim' => $modDetailKirim,
    ));
  }

  public function kirimNotifKirimMenuDiet($model, $notif_target)
  {
    $no_kirim = $model->nokirimmenu;
    $tgl_kirim = $model->tglkirimmenu;
    $judul = "Kirim menu Diet Pasien";

    foreach ($notif_target as $ruangan_id => $item) {
      $ruangan = RuanganM::model()->findByPk($ruangan_id);

      $isi = "Tgl. Kirim : " . MyFormatter::formatDateTimeForUser($tgl_kirim) . "<br/>";
      $isi .= "No. Kirim : " . $no_kirim . "<br/>";
      $isi .= "Pasien : <br/><ul>";

      foreach ($item as $pasien_id) {
        $pasien = PasienM::model()->findByPk($pasien_id);
        $isi .= '<li>' . $pasien->nama_pasien . '</li>';
      }

      $isi .= "</ul>";

      //var_dump($isi);

      //var_dump($ruangan->attributes);

      CustomFunction::broadcastNotif($judul, $isi, array(
        array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
      ));
    }
  }

  public function actionIndexPegawai($idPesan = null, $id = null, $jenisPesanMenu = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pengiriman Menu Pegawai";
    $model = new GZKirimmenudietT;
    if (isset($idPesan)) {
      $modPesan = PesanmenudietT::model()->find('pesanmenudiet_id = ' . $idPesan . ' and kirimmenudiet_id is null');
      if (!empty($modPesan)) {
        $model->bahandiet_id = $modPesan->bahandiet_id;
        $model->jenisdiet_id = $modPesan->jenisdiet_id;
        $model->pesanmenudiet_id = $idPesan;
        $model->jenispesanmenu = $modPesan->jenispesanmenu;
        if ($modPesan->jenispesanmenu != Params::JENISPESANMENU_PASIEN) {
          $criteria = new CDbCriteria();
          $criteria->select = 'pegawai_id, pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
          $criteria->group = 'pegawai_id, pesanmenudiet_id, jml_pesan_porsi, satuanjml_urt,menudiet_id';
          $criteria->compare('pesanmenudiet_id', $idPesan);
          $modDetailPesan = GZPesanmenupegawaiT::model()->findAll($criteria);
        }
      }
    }
    $model->nokirimmenu = MyGenerator::noKirimMenuDiet();
    $model->tglkirimmenu = date('d M Y H:i:s');
    $model->jenispesanmenu = !empty($jenisPesanMenu) ? $jenisPesanMenu : Params::JENISPESANMENU_PEGAWAI;

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

    // Uncomment the following line if AJAX validation is needed

    if (!empty($id)) {
      $model = GZKirimmenudietT::model()->findByPk($id);
    }


    if (isset($_POST['GZKirimmenudietT'])) {
      $model->attributes = $_POST['GZKirimmenudietT'];
      $model->jenispesanmenu = (!empty($modPesan->jenispesanmenu) ? $modPesan->jenispesanmenu : $model->jenispesanmenu);
      if (!isset($idPesan)) {
        $model->jenispesanmenu = $_POST['jenisPesan'];
      }

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = true;
        if ($model->save()) {
          if (!empty($model->pesanmenudiet_id)) {
            PesanmenudietT::model()->updateByPk($model->pesanmenudiet_id, array('kirimmenudiet_id' => $model->kirimmenudiet_id));
          }
          if (count((array)$_POST['KirimmenupegawaiT']) > 0) {
            foreach ($_POST['KirimmenupegawaiT'] as $i => $v) {
              if ($v['checkList'] == 1) {
                foreach ($v['menudiet_id'] as $j => $x) {
                  if (!empty($x)) {
                    $modDetail = new GZKirimmenupegawaiT();
                    $modDetail->attributes = $v;
                    $modDetail->kirimmenudiet_id = $model->kirimmenudiet_id;
                    $modDetail->pesanmenupegawai_id = isset($v['pesanmenupegawai_id'][$j]) ? $v['pesanmenupegawai_id'][$j] : null;
                    $modDetail->jeniswaktu_id = $j;
                    $modDetail->menudiet_id = $x;
                    $modDetail->pegawai_id = !empty($modDetail->pegawai_id) ? $modDetail->pegawai_id : null;
                    if ($modDetail->save()) {

                      if (empty($notif_target[$modDetail->ruangan_id])) {
                        $notif_target[$modDetail->ruangan_id] = array();
                      }

                      if (!in_array($modDetail->pegawai_id, $notif_target[$modDetail->ruangan_id])) {
                        $notif_target[$modDetail->ruangan_id][] = $modDetail->pegawai_id;
                      }

                      // SMS GATEWAY
                      if (Yii::app()->user->getState('issmsgateway') && !empty($modPegawai)) {
                        $modPegawai = $modDetail->pegawai;
                        $modRuangan = $modDetail->ruangan;
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
                          $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($model->tglkirimmenu), $isiPesan);
                          $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);

                          if ($smsgateway->tujuansms == Params::TUJUANSMS_PEGAWAI && $smsgateway->statussms) {
                            if (!empty($modPegawai->nomobile_pegawai)) {
                              $sms->kirim($modPegawai->nomobile_pegawai, $isiPesan);
                            }
                          }
                        }
                      }
                      // END SMS GATEWAY

                      if (!empty($modDetail->pesanmenupegawai_id)) {
                        GZPesanmenupegawaiT::model()->updateByPk($modDetail->pesanmenupegawai_id, array('kirimmenupegawai_id' => $modDetail->kirimmenupegawai_id));
                      }
                      if (Yii::app()->user->getState('krngistokgizi') == TRUE) {
                        // if (StokbahanmakananT::validasiStokMenu($modDetail->jml_kirim, $modDetail->menudiet_id)){
                        //	StokbahanmakananT::kurangiStokMenu($modDetail->jml_kirim, $modDetail->menudiet_id);                                                            
                        // }else{
                        //	$success = true;
                        // }
                      }
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
        } else {
          $success = false;
        }

        $this->kirimNotifKirimMenuDietPegawai($model, $notif_target);

        if ($success == TRUE) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data ' . $model->nokirimmenu . ' berhasil disimpan.');
          $this->redirect(array('indexPegawai', 'id' => $model->kirimmenudiet_id, 'jenisPesanMenu' => $jenisPesanMenu));
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
    if (empty($modPesan)) {
      $modPesan = null;
    }
    if (empty($modDetail)) {
      $modDetail = null;
    }

    if (empty($modDetailPesan)) {
      $modDetailPesan = null;
    }

    $this->render('indexPegawai', array(
      'model' => $model, 'modPesan' => $modPesan, 'modDetail' => $modDetail, 'modDetailPesan' => $modDetailPesan
    ));
  }


  public function kirimNotifKirimMenuDietPegawai($model, $notif_target)
  {
    $no_kirim = $model->nokirimmenu;
    $tgl_kirim = $model->tglkirimmenu;
    $judul = "Kirim menu Diet Pasien";

    foreach ($notif_target as $ruangan_id => $item) {
      $ruangan = RuanganM::model()->findByPk($ruangan_id);

      $isi = "Tgl. Kirim : " . MyFormatter::formatDateTimeForUser($tgl_kirim) . "<br/>";
      $isi .= "No. Kirim : " . $no_kirim . "<br/>";
      $isi .= "Pegawai : <br/><ul>";

      foreach ($item as $pegawai_id) {
        $pasien = PegawaiM::model()->findByPk($pegawai_id);
        if (!empty($pasien)) {
          $isi .= '<li>' . $pasien->namaLengkap . '</li>';
        } else {
          $isi .= '<li>Tamu</li>';
        }
      }

      $isi .= "</ul>";

      //var_dump($isi);

      //var_dump($ruangan->attributes);

      CustomFunction::broadcastNotif($judul, $isi, array(
        array('instalasi_id' => $ruangan->instalasi_id, 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id),
      ));
    }
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


    if (isset($_POST['GZKirimmenudietT'])) {
      $model->attributes = $_POST['GZKirimmenudietT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->kirimmenudiet_id));
      }
    }

    $this->render('update', array(
      'model' => $model,
    ));
  }

  public function actionAdmin()
  {

    $model = new GZKirimmenudietT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['GZKirimmenudietT']))
      $model->attributes = $_GET['GZKirimmenudietT'];

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'gzkirimmenudiet-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {
    $model = new GZKirimmenudietT;
    $model->attributes = $_REQUEST['GZKirimmenudietT'];
    $judulLaporan = 'Data GZKirimmenudietT';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionInformasi()
  {
    $this->pageTitle = Yii::app()->name . " - Pengiriman Menu Diet";
    //                
    $model = new GZKirimmenudietT('search');
    //		$model->unsetAttributes();  // clear any default values
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    if (isset($_GET['GZKirimmenudietT'])) {
      $model->attributes = $_GET['GZKirimmenudietT'];
      //$model->ruangan_id = $_GET['GZKirimmenudietT']['ruangan_id'];
      //$model->instalasi_id = $_GET['GZKirimmenudietT']['instalasi_id'];
      $model->pesan_menu = $_GET['GZKirimmenudietT']['pesan_menu'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GZKirimmenudietT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZKirimmenudietT']['tgl_akhir']);
    }

    $this->render('informasi', array(
      'model' => $model,
    ));
  }

  public function actionDetailKirimMenuDiet($id, $frame = null)
  {
    $this->layout = '//layouts/iframe';

    if ($frame == FALSE) {
      $this->layout = '//layouts/printWindows';
    }
    $modKirim = KirimmenudietT::model()->findByPk($id);
    if ($modKirim->jenispesanmenu == Params::JENISPESANMENU_PASIEN) {
      $criteria = new CDbCriteria();
      $criteria->select = 'pasienadmisi_id, pendaftaran_id, pasien_id, menudiet_id, kirimmenudiet_id, jml_kirim, satuanjml_urt,ruangan_id';
      $criteria->group = 'pasienadmisi_id, pendaftaran_id, pasien_id, menudiet_id,kirimmenudiet_id, jml_kirim, satuanjml_urt,ruangan_id';
      $criteria->compare('kirimmenudiet_id', $id);
      $modDetailKirim = KirimmenupasienT::model()->findAll($criteria);
    } else {
      $criteria = new CDbCriteria();
      $criteria->select = 'pegawai_id, menudiet_id, kirimmenudiet_id, jml_kirim, satuanjml_urt, ruangan_id';
      $criteria->group = 'pegawai_id, menudiet_id, kirimmenudiet_id, jml_kirim, satuanjml_urt, ruangan_id';
      $criteria->compare('kirimmenudiet_id', $id);
      $modDetailKirim = KirimmenupegawaiT::model()->findAll($criteria);
    }
    $this->render('detailInformasi', array(
      'modKirim' => $modKirim,
      'modDetailKirim' => $modDetailKirim,
    ));
  }

  protected function saveTindakanPelayanan($modDetail)
  {
    $valid = true;
    $modTindakans = null;
    $arr = array();

    if (count((array)$_POST['KirimmenupasienT']) > 0) {
      foreach ($_POST['KirimmenupasienT'] as $i => $v) {
        if ($v['checkList'] == 1) {
          // var_dump($v);
          $pid = $v['pendaftaran_id'];
          if (empty($arr[$v['pendaftaran_id']])) {
            $arr[$v['pendaftaran_id']] = array(
              'pendaftaran_id' => $v['pendaftaran_id'],
              'pasienadmisi_id' => null,
              'pasien_id' => $v['pasien_id'],
              'penjamin_id' => $v['penjamin_id'],
              'jeniskasuspenyakit_id' => $v['jeniskasuspenyakit_id'],
              'ruangan_id' => $v['ruangan_id'],
            );
          }


          if (is_array($arr[$v['pendaftaran_id']]['penjamin_id'])) {
            foreach ($arr[$v['pendaftaran_id']]['penjamin_id'] as $item) {
              $arr[$v['pendaftaran_id']]['penjamin_id'] = $item;
              break;
            }
          }

          if (is_array($arr[$v['pendaftaran_id']]['jeniskasuspenyakit_id'])) {

            foreach ($arr[$v['pendaftaran_id']]['jeniskasuspenyakit_id'] as $item) {
              $arr[$v['pendaftaran_id']]['jeniskasuspenyakit_id'] = $item;
              break;
            }

            //$arr[$v['pendaftaran_id']]['jeniskasuspenyakit_id'] = $arr[$v['pendaftaran_id']]['jeniskasuspenyakit_id'][1];
          }

          if (!empty($v['pasienadmisi_id'])) {
            $arr[$pid]['pasienadmisi_id'] = $v['pasienadmisi_id'];
          }

          foreach ($v['daftartindakan_id'] as $j => $x) {
            // var_dump($j, $x);
            if (empty($arr[$pid]['daftartindakan_id'])) {
              $arr[$pid]['daftartindakan_id'] = $x;
            }
            if (empty($arr[$pid]['carabayar_id'])) {
              $arr[$pid]['carabayar_id'] = $v['carabayar_id'][$j];
            }
            if (empty($arr[$pid]['kelaspelayanan_id'])) {
              $arr[$pid]['kelaspelayanan_id'] = $v['kelaspelayanan_id'][$j];
            }
            if (empty($arr[$pid]['satuanTarif'])) {
              $arr[$pid]['satuanTarif'] = $v['satuanTarif'][$j];
            }
          }

          /*
                      foreach($v['menudiet_id'] as $j=>$x){
                      if (!empty($x)){

                      $modPendaftaran = PendaftaranT::model()->findAllByAttributes(array('pendaftaran_id'=>$v['pendaftaran_id']));

                      $daftartindakan_id = $v['daftartindakan_id'];
                      $kelaspelayanan_id = $v['kelaspelayanan_id'];

                      //                            echo "<pre>";
                      //                            echo count((array)$_POST['KirimmenupasienT']);
                      //                            exit;
                      if (isset($data)){
                      $daftartindakan_id =  (int) $data;
                      }
                      $modTindakans = new TindakanpelayananT;
                      $modTindakans->attributes=$v;

                      $modTindakans->penjamin_id = (int) $v['penjamin_id'];
                      $modTindakans->pasien_id = $v['pasien_id'];
                      $modTindakans->kelaspelayanan_id = (int) $v['kelaspelayanan_id'][$j];
                      $modTindakans->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
                      $modTindakans->instalasi_id = Params::INSTALASI_ID_GIZI; //$modPendaftaran->instalasi_id;
                      $modTindakans->pendaftaran_id = $v['pendaftaran_id'];
                      $modTindakans->shift_id = Yii::app()->user->getState('shift_id');
                      $modTindakans->pasienmasukpenunjang_id = null;
                      $modTindakans->daftartindakan_id = $v['daftartindakan_id'][$j];
                      $modTindakans->carabayar_id = (int) $v['carabayar_id'][$j];
                      $modTindakans->jeniskasuspenyakit_id = (int) $v['jeniskasuspenyakit_id'];
                      $modTindakans->tgl_tindakan = date('Y-m-d H:i:s');
                      $modTindakans->tarif_satuan = $modTindakans->getTarifSatuan();
                      $modTindakans->qty_tindakan = $v['jml_kirim'];
                      $modTindakans->tarif_tindakan = $modTindakans->tarif_satuan * $modTindakans->qty_tindakan;
                      $modTindakans->satuantindakan = "HARI";
                      $modTindakans->cyto_tindakan = isset($item['cyto']) ? $item['cyto'] : 0;
                      if(!$modTindakans->cyto_tindakan){ //false
                      $modTindakans->tarifcyto_tindakan = 0;
                      }else{
                      $modTindakans->tarifcyto_tindakan = $modTindakans->tarif_tindakan + ($modTindakans->tarif_tindakan * 10 / 100);
                      }
                      if (isset($modPendaftaran->kelastanggungan_id)){
                      $modTindakans->kelastanggungan_id = $modPendaftaran->kelastanggungan_id;
                      }
                      if (isset($modPendaftaran->pegawai_id)){
                      $modTindakans->dokterpemeriksa1_id = $modPendaftaran->pegawai_id;
                      }

                      $modTindakans->discount_tindakan = 0;
                      $modTindakans->subsidiasuransi_tindakan = 0;
                      $modTindakans->subsidipemerintah_tindakan = 0;
                      $modTindakans->subsisidirumahsakit_tindakan = 0;
                      $modTindakans->iurbiaya_tindakan = 0;
                      $modTindakans->ruangan_id = Yii::app()->user->getState('ruangan_id');

                      // var_dump($modTindakans->attributes);
                      $valid = $modTindakans->validate() && $valid;
                      // var_dump($modTindakans->errors); die;

                      if($valid){
                      if($modTindakans->save()){
                      $statusSaveKomponen = $modTindakans->saveTindakanKomponen();
                      //                                      KirimmenupasienT::model()->updateByPk($modDetail->kirimmenupasien_id,array('tindakanpelayanan_id'=>$modTindakans->tindakanpelayanan_id));
                      }

                      if($statusSaveKomponen) {
                      $this->successSaveTindakan = true;
                      } else {
                      $this->successSaveTindakan = false;
                      }
                      } else {
                      $this->successSaveTindakan = false;
                      }
                      }
                      } */
        }
      }

      foreach ($arr as $id => $item) {

        if (empty($item['daftartindakan_id']) || strtolower($item['daftartindakan_id']) == 'nan') {
          continue;
        }

        $modTindakans = null;

        if (!empty($item['pasienadmisi_id'])) {
          $a = PasienadmisiT::model()->findByPk($item['pasienadmisi_id']);
          $item['kelaspelayanan_id'] = $a->kelaspelayanan_id;
        }

        $criteria = new CDbCriteria();
        $criteria->compare('tgl_tindakan::date', date('Y-m-d'));
        $criteria->compare('pendaftaran_id', $item['pendaftaran_id']);
        $criteria->compare('pasienadmisi_id', $item['pasienadmisi_id']);
        $criteria->compare('pasien_id', $item['pasien_id']);
        $criteria->compare('penjamin_id', $item['penjamin_id']);
        $criteria->compare('carabayar_id', $item['carabayar_id']);
        $criteria->compare('daftartindakan_id', $item['daftartindakan_id']);
        $criteria->compare('kelaspelayanan_id', $item['kelaspelayanan_id']);

        // var_dump($item);

        $t = TindakanpelayananT::model()->find($criteria);
        // var_dump($t->attributes);

        if (empty($t)) {
          $modTindakans = new TindakanpelayananT;
          $modTindakans->attributes = $item;

          $modTindakans->penjamin_id = (int) $item['penjamin_id'];
          $modTindakans->pasien_id = $item['pasien_id'];
          $modTindakans->kelaspelayanan_id = (int) $item['kelaspelayanan_id'];
          $modTindakans->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
          $modTindakans->instalasi_id = Params::INSTALASI_ID_GIZI; //$modPendaftaran->instalasi_id;
          $modTindakans->pendaftaran_id = $item['pendaftaran_id'];
          $modTindakans->shift_id = Yii::app()->user->getState('shift_id');
          $modTindakans->pasienmasukpenunjang_id = null;
          $modTindakans->daftartindakan_id = $item['daftartindakan_id'];
          $modTindakans->carabayar_id = (int) $item['carabayar_id'];
          $modTindakans->jeniskasuspenyakit_id = (int) $item['jeniskasuspenyakit_id'];
          $modTindakans->tgl_tindakan = date('Y-m-d H:i:s');
          $modTindakans->tarif_satuan = $modTindakans->getTarifSatuan();
          $modTindakans->qty_tindakan = 1;
          $modTindakans->tarif_tindakan = $modTindakans->tarif_satuan * $modTindakans->qty_tindakan;
          $modTindakans->satuantindakan = "HARI";
          $modTindakans->cyto_tindakan = isset($item['cyto']) ? $item['cyto'] : 0;
          if (!$modTindakans->cyto_tindakan) { //false
            $modTindakans->tarifcyto_tindakan = 0;
          } else {
            $modTindakans->tarifcyto_tindakan = $modTindakans->tarif_tindakan + ($modTindakans->tarif_tindakan * 10 / 100);
          }
          if (isset($modPendaftaran->kelastanggungan_id)) {
            $modTindakans->kelastanggungan_id = $modPendaftaran->kelastanggungan_id;
          }
          if (isset($modPendaftaran->pegawai_id)) {
            $modTindakans->dokterpemeriksa1_id = $modPendaftaran->pegawai_id;
          }

          $modTindakans->discount_tindakan = 0;
          $modTindakans->subsidiasuransi_tindakan = 0;
          $modTindakans->subsidipemerintah_tindakan = 0;
          $modTindakans->subsisidirumahsakit_tindakan = 0;
          $modTindakans->iurbiaya_tindakan = $modTindakans->tarif_tindakan;
          $modTindakans->ruangan_id = Yii::app()->user->getState('ruangan_id');

          // var_dump($modTindakans->attributes);
          $valid = $modTindakans->validate() && $valid;
          // var_dump($modTindakans->errors); die;

          if ($valid) {
            if ($modTindakans->save()) {
              $statusSaveKomponen = $modTindakans->saveTindakanKomponen();
              //                                      KirimmenupasienT::model()->updateByPk($modDetail->kirimmenupasien_id,array('tindakanpelayanan_id'=>$modTindakans->tindakanpelayanan_id));
            }

            if ($statusSaveKomponen) {
              $this->successSaveTindakan = true;
            } else {
              $this->successSaveTindakan = false;
            }
          } else {
            $this->successSaveTindakan = false;
          }
        }
      }
    }
    //var_dump($arr, $this->successSaveTindakan);
    //die;

    return $modTindakans;
  }

  //        RND-6260
  //        protected function saveTindakanKomponen($tindakan)
  //        {   
  //            $valid = true;
  //            $criteria = new CDbCriteria();
  ////            $criteria->addCondition('komponentarif_id !='.Params::KOMPONENTARIF_ID_TOTAL);
  //            $criteria->compare('daftartindakan_id', $tindakan->daftartindakan_id);
  //            $criteria->compare('kelaspelayanan_id', $tindakan->kelaspelayanan_id);
  //            $modTarifs = TariftindakanM::model()->findAll($criteria);
  //            foreach ($modTarifs as $i => $tarif) {
  //                $modTindakanKomponen[$i] = new TindakankomponenT;
  //                $modTindakanKomponen[$i]->tindakanpelayanan_id = $tindakan->tindakanpelayanan_id;
  //                $modTindakanKomponen[$i]->komponentarif_id = $tarif->komponentarif_id;
  //                $modTindakanKomponen[$i]->tarif_kompsatuan = $tarif->harga_tariftindakan;
  //                $modTindakanKomponen[$i]->tarif_tindakankomp = $modTindakanKomponen[$i]->tarif_kompsatuan * $tindakan->qty_tindakan;
  //                if($tindakan->cyto_tindakan){
  //                    $modTindakanKomponen[$i]->tarifcyto_tindakankomp = $tarif->harga_tariftindakan * ($tarif->persencyto_tind/100);
  //                } else {
  //                    $modTindakanKomponen[$i]->tarifcyto_tindakankomp = 0;
  //                }
  //                $modTindakanKomponen[$i]->subsidiasuransikomp = $tindakan->subsidiasuransi_tindakan;
  //                $modTindakanKomponen[$i]->subsidipemerintahkomp = $tindakan->subsidipemerintah_tindakan;
  //                $modTindakanKomponen[$i]->subsidirumahsakitkomp = $tindakan->subsisidirumahsakit_tindakan;
  //                $modTindakanKomponen[$i]->iurbiayakomp = $tindakan->iurbiaya_tindakan;
  //                $valid = $modTindakanKomponen[$i]->validate() && $valid;
  //                if($valid)
  //                    $modTindakanKomponen[$i]->save();
  //            }
  //            
  //            return $valid;
  //        }        

  /**
   * untuk mengubah tarif tindakan ketika mengubah menu diet
   */
  public function actionsetTarifTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : null);
      $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
      $satuanTarif = 0;
      $tarifTindakan = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id' => $daftartindakan_id, 'kelaspelayanan_id' => $kelaspelayanan_id, 'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL));
      foreach ($tarifTindakan as $key => $tarif) {
        if (count((array)$tarif) > 0) {
          $satuanTarif = $tarif->harga_tariftindakan;
        } else {
          $tarifTindakan = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id' => $daftartindakan_id, 'kelaspelayanan_id' => Params::KELASPELAYANAN_ID_TANPA_KELAS, 'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL));
          foreach ($tarifTindakan as $key => $tarif) {
            //                        if (count((array)$tarif) > 0) {
            $satuanTarif = $tarif->harga_tariftindakan;
            //                        } else {
            //                            $satuanTarif = 0;
            //                        }
          }
        }
      }
      $data['satuan_tarif'] = $satuanTarif;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * untuk print kirim menudiet
   */
  public function actionPrintKirimMenuDiet($id = null)
  {
    $format = new MyFormatter();
    $modKirim = KirimmenudietT::model()->findByPk($id);
    if ($modKirim->jenispesanmenu == Params::JENISPESANMENU_PASIEN) {
      $criteria = new CDbCriteria();
      $criteria->select = 'pasienadmisi_id, pendaftaran_id, pasien_id, kirimmenudiet_id, jml_kirim, satuanjml_urt,ruangan_id';
      $criteria->group = 'pasienadmisi_id, pendaftaran_id, pasien_id,kirimmenudiet_id, jml_kirim, satuanjml_urt,ruangan_id';
      $criteria->compare('kirimmenudiet_id', $id);
      $modDetailKirim = KirimmenupasienT::model()->findAll($criteria);
    } else {
      $criteria = new CDbCriteria();
      $criteria->select = 'pegawai_id, menudiet_id, kirimmenudiet_id, jml_kirim, satuanjml_urt, ruangan_id';
      $criteria->group = 'pegawai_id, menudiet_id, kirimmenudiet_id, jml_kirim, satuanjml_urt, ruangan_id';
      $criteria->compare('kirimmenudiet_id', $id);
      $modDetailKirim = KirimmenupegawaiT::model()->findAll($criteria);
    }
    $judulLaporan = 'Pengiriman Menu Diet Pasien';
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    $this->layout = '//layouts/printWindows';
    $this->render('PrintKirimMenuBaru', array('modKirim' => $modKirim, 'modDetailKirim' => $modDetailKirim, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'format' => $format));
  }

  /**
   * Action Ajax untuk memasukan menu diet
   */
  public function actionGetMenuDietDetailKirim()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $pasienadmisi_id = (isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
      $menudiet_id = (isset($_POST['menudiet_id']) ? $_POST['menudiet_id'] : null);
      $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
      $instalasi_id = (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
      $daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : null);
      $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
      //            $satuanTarif = $_POST['satuanTarif'];
      $urt = (isset($_POST['urt']) ? $_POST['urt'] : null);
      $jumlah = (isset($_POST['jumlah']) ? $_POST['jumlah'] : null);
      $jeniswaktu = (isset($_POST['jeniswaktu']) ? $_POST['jeniswaktu'] : null);
      $pendaftaranId = (isset($_POST['pendaftaranId']) ? $_POST['pendaftaranId'] : null);
      if (empty($pendaftaranId))
        $pendaftaranId = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $pasienAdmisi = (isset($_POST['pasienAdmisi']) ? $_POST['pasienAdmisi'] : null);
      $modDetail = new GZPesanmenudetailT();
      $modJenisWaktu = JeniswaktuM::getJenisWaktu();
      $diet = MenuDietM::model()->findByPK($menudiet_id);
      $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $satuanTarif = 0;
      $tr = "";
      if (!empty($daftartindakan_id) && strtolower($daftartindakan_id) != "nan") {
        $tarifTindakan = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id' => $daftartindakan_id, 'kelaspelayanan_id' => $kelaspelayanan_id, 'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL));
        $ruangan = RuanganM::model()->with('instalasi')->findByPk($ruangan_id);
        $satuanTarif = 0;
        foreach ($tarifTindakan as $key => $tarif) {
          //if (count((array)$tarif) > 0) {
          $satuanTarif = $tarif->harga_tariftindakan;
          //                    } else {
          //                        $tarifTindakan = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id' => $daftartindakan_id, 'kelaspelayanan_id' => Params::KELASPELAYANAN_ID_TANPA_KELAS, 'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL));
          //                        foreach ($tarifTindakan as $key => $tarif) {
          //                            if (count((array)$tarif) > 0) {
          //                                $satuanTarif = $tarif->harga_tariftindakan;
          //                            } else {
          //                                $satuanTarif = 0;
          //                            }
          //                        }
          //                    }
        }
      }

      $jumlahPasien = empty($pasienAdmisi) ? 0 : count((array)$pasienAdmisi);
      if ($jumlahPasien == 0) {
        $jumlahPasien = 1;
      }
      for ($i = 0; $i < $jumlahPasien; $i++) {
        $modDetail = new GZPesanmenudetailT();
        //            echo $pasienAdmisi;exit;
        if (!empty($pasienadmisi_id)) {
          $model = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id, 'pasienadmisi_id' => $pasienadmisi_id));
          $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        } else {
          $model = InfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaranId[$i]));
          $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaranId[$i]));
        }
        $tr .= '<tr>
                        <td>'  //  .CHtml::activeHiddenField($modDetail, '[]ruangan_id',array('value'=>$model->ruangan_id))
          . CHtml::checkBox('GZPesanmenudetailT[][checkList]', true, array('class' => 'cekList', 'onclick' => 'hitungSemua()'))
          . CHtml::activeHiddenField($modDetail, '[]pendaftaran_id', array('value' => (isset($model->pendaftaran_id) ? $model->pendaftaran_id : null)))
          . CHtml::activeHiddenField($modDetail, '[]pasien_id', array('value' => (isset($model->pasien_id) ? $model->pasien_id : null)))
          . CHtml::activeHiddenField($modDetail, '[]pasienadmisi_id', array('value' => (isset($model->pasienadmisi_id) ? $model->pasienadmisi_id : null)))
          . CHtml::activeHiddenField($modDetail, '[]ruangan_id', array('value' => (isset($model->ruangan_id) ? $model->ruangan_id : null)))
          . '</td>
                        <td>' . (isset($ruangan) ? $ruangan->instalasi->instalasi_nama : "") . '/<br/> ' . (isset($model->ruangan_nama) ? $model->ruangan_nama : "") . '</td>
                        <td>' . (isset($model->no_pendaftaran) ? $model->no_pendaftaran : "") . '/<br/> ' . (isset($model->no_rekam_medik) ? $model->no_rekam_medik : "") . '</td>
                        <td>' . (isset($model->nama_pasien) ? $model->nama_pasien : "") . '</td>
                        <td>' . (isset($model->umur) ? $model->umur : "") . '</td>
                        <td>' . (isset($model->jeniskelamin) ? $model->jeniskelamin : "") . '</td>';
        foreach ($modJenisWaktu as $v) {
          if (in_array($v->jeniswaktu_id, $jeniswaktu)) {
            $carabayar = isset($model->carabayar_id) ? $model->carabayar_id : null;
            $penjamin = isset($model->penjamin_id) ? $model->penjamin_id : null;
            $jenis = isset($model->jeniskasuspenyakit_id) ? $model->jeniskasuspenyakit_id : null;
            $tr .= '<td>' . CHtml::hiddenField('GZPesanmenudetailT[][jeniswaktu_id][' . $v->jeniswaktu_id . ']', $v->jeniswaktu_id)
              . CHtml::hiddenField('GZPesanmenudetailT[][daftartindakan_id][' . $v->jeniswaktu_id . ']', $daftartindakan_id)
              . CHtml::hiddenField('GZPesanmenudetailT[][carabayar_id][' . $v->jeniswaktu_id . ']', $carabayar)
              . CHtml::hiddenField('GZPesanmenudetailT[][penjamin_id][' . $v->jeniswaktu_id . ']', $penjamin)
              . CHtml::hiddenField('GZPesanmenudetailT[][kelaspelayanan_id][' . $v->jeniswaktu_id . ']', $kelaspelayanan_id)
              . CHtml::hiddenField('GZPesanmenudetailT[][jeniskasuspenyakit_id][' . $v->jeniswaktu_id . ']', $jenis)
              . CHtml::hiddenField('GZPesanmenudetailT[][satuanTarif][' . $v->jeniswaktu_id . ']', $satuanTarif, array('class' => 'span2 numbersOnly', 'style' => 'text-align: right'))
              . CHtml::dropDownList('GZPesanmenudetailT[][menudiet_id][' . $v->jeniswaktu_id . ']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 menudiet', 'options' => array("$menudiet_id" => array("selected" => "selected")))) . '</td>';
          } else {
            $carabayar = isset($model->carabayar_id) ? $model->carabayar_id : null;
            $penjamin = isset($model->penjamin_id) ? $model->penjamin_id : null;
            $jenis = isset($model->jeniskasuspenyakit_id) ? $model->jeniskasuspenyakit_id : null;
            $tr .= '<td>' . CHtml::hiddenField('GZPesanmenudetailT[][jeniswaktu_id][' . $v->jeniswaktu_id . ']', $v->jeniswaktu_id)
              . CHtml::hiddenField('GZPesanmenudetailT[][carabayar_id][' . $v->jeniswaktu_id . ']', $carabayar)
              . CHtml::hiddenField('GZPesanmenudetailT[][penjamin_id][' . $v->jeniswaktu_id . ']', $penjamin)
              . CHtml::hiddenField('GZPesanmenudetailT[][daftartindakan_id][' . $v->jeniswaktu_id . ']', $daftartindakan_id)
              . CHtml::hiddenField('GZPesanmenudetailT[][kelaspelayanan_id][' . $v->jeniswaktu_id . ']', $kelaspelayanan_id)
              . CHtml::hiddenField('GZPesanmenudetailT[][jeniskasuspenyakit_id][' . $v->jeniswaktu_id . ']', $jenis)
              . CHtml::hiddenField('GZPesanmenudetailT[][satuanTarif][' . $v->jeniswaktu_id . ']', 0, array('class' => 'span2  numbersOnly', 'style' => 'text-align: right'))
              . CHtml::dropDownList('GZPesanmenudetailT[][menudiet_id][' . $v->jeniswaktu_id . ']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('empty' => '-- Pilih --', 'class' => 'span2 menudiet',)) . '</td>';
          }
        }
        $tr .= '<td>' . CHtml::activeTextField($modDetail, '[]jml_kirim', array('value' => $jumlah, 'class' => ' span1 numbersOnly', 'style' => 'text-align: right;')) . '</td>
                        <td>' . CHtml::activeDropDownList($modDetail, '[]satuanjml_urt', LookupM::getItems('ukuranrumahtangga'), array('empty' => '-- Pilih --', 'style' => 'width:80px;', 'class' => 'span2 urt', 'options' => array("$urt" => array("selected" => "selected")))) . '</td>
                        <td>' . CHtml::activeDropDownList($modDetail, '[]status_menu', LookupM::getItems('statusmakanan'), array('empty' => '-- Pilih --', 'style' => 'width:80px;', 'class' => 'span2 urt', 'options' => array("SASET" => array("selected" => "selected")))) . '</td>
                        ';
        $tr .= "<td><center>" . CHtml::link("<i class='icon-list-alt'></i> ", Yii::app()->controller->createUrl("/gizi/RiwayatPasienMenuDiet/index", array("pendaftaran_id" => $modPendaftaran->pendaftaran_id)), array(
          "pendaftaran_id" => "$modPendaftaran->pendaftaran_id",
          "target" => "frameRiwayat",
          "rel" => "tooltip",
          "title" => "Klik untuk melihat riwayat pemeriksaan pasien",
          "onclick" => "window.parent.$('#dialogRiwayat').dialog('open')"
        )) . "</center></td>";

        $tr .= "</tr>";
      }

      echo json_encode($tr);
      Yii::app()->end();
    }
  }

  public function actionGetMenuDietPegawaiDariKirim()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai_id = (!empty($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null);
      $menudiet_id = isset($_POST['menudiet_id']) ? $_POST['menudiet_id'] : null;
      $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
      $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
      $jeniskelamin = isset($_POST['jenisKelamin']) ? $_POST['jenisKelamin'] : null;
      $urt = isset($_POST['urt']) ? $_POST['urt'] : null;
      $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : null;
      $jeniswaktu = isset($_POST['jeniswaktu']) ? $_POST['jeniswaktu'] : null;
      $modDetail = new GZPesanmenupegawaiT();
      $pegawaiId = $pegawai_id;

      $butuh = isset($_POST['butuh']) ? $_POST['butuh'] : null;
      $total = isset($_POST['total']) ? $_POST['total'] : null;

      $tr = "";
      if (isset($butuh)) {
        if (in_array($menudiet_id, $butuh)) {
          foreach ($butuh as $i => $dataRow) {
            if ($dataRow == $menudiet_id) {
              $total = $total[$i];
            }
          }
        } else {
          $total = 0;
        }
      } else {
        $total = 0;
      }
      $hasil = true;
      $jumlahPesan = count((array)$pegawaiId);
      if (Yii::app()->user->getState('krngistokgizi') == true) {
        $bahanMenu = BahanMenuDietM::model()->findAllByAttributes(array('menudiet_id' => $menudiet_id));
        $kelipatan = count(JeniswaktuM::getJenisWaktu());
        foreach ($bahanMenu as $v) {
          $jumlahPesanPegawai = $jumlahPesan;
          if ($jumlahPesan < 0) {
            $jumlahPesanPegawai = 1;
          }
          if ($total != 0) {
            $jumlahButuh = $kelipatan * $v->jmlbahan * ($jumlah + ($total / $kelipatan)) * $jumlahPesanPegawai;
          } else {
            $jumlahButuh = $kelipatan * $v->jmlbahan * $jumlah * $jumlahPesanPegawai;
          }

          //if (StokbahanmakananT::validasiStok($jumlahButuh, $v->bahanmakanan_id) == false){
          //    $hasil = false;
          //}
        }
      }

      // var_dump($hasil); die;

      if ($hasil == true) {
        if ($jumlahPesan < 1) {
          $pegawaiId = array($pegawai_id);
        }

        foreach ($pegawaiId as $pegawai_id) {
          $modDetail = new KirimmenupegawaiT();
          if ($pegawai_id == null) {
            $model = new PegawaiM();
            $model->pegawai_id = empty($pegawai_id) ? null : $pegawai_id;
            $nama = "Tamu";
            $jeniskelamin = $jeniskelamin;
          } else {
            $model = PegawaiM::model()->findByPk($pegawai_id);
            $nama = $model->nama_pegawai;
            $jeniskelamin = $model->jeniskelamin;
          }
          $tr .= '<tr>
                            <td>'
            . CHtml::checkBox('KirimmenupegawaiT[][checkList]', true, array('class' => 'cekList', 'onclick' => 'hitungSemua()'))
            . CHtml::activeHiddenField($modDetail, '[]pegawai_id', array('value' => $model->pegawai_id, 'readonly' => true))
            . CHtml::hiddenField('KirimmenupegawaiT[][ruangan_id]', $ruangan_id, array('readonly' => true))
            . '</td>
                            <td>' . RuanganM::model()->with('instalasi')->findByPk($ruangan_id)->instalasi->instalasi_nama . '/<br/>' . RuanganM::model()->findByPk($ruangan_id)->ruangan_nama . '</td>
                            <td>' . CHtml::textField('nama', $nama, array('readonly' => true, 'class' => 'span2 nama')) . '</td>
                            <td>' . $jeniskelamin . '</td>';
          foreach (JeniswaktuM::getJenisWaktu() as $v) {
            if (!empty($jeniswaktu)) {
              if (in_array($v->jeniswaktu_id, $jeniswaktu)) {
                $tr .= '<td>' . CHtml::hiddenField('KirimmenupegawaiT[][jeniswaktu_id][' . $v->jeniswaktu_id . ']', $v->jeniswaktu_id, array('readonly' => true))
                  . CHtml::dropDownList('KirimmenupegawaiT[][menudiet_id][' . $v->jeniswaktu_id . ']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('onchange' => 'cekStokMenu(this)', 'empty' => '-- Pilih --', 'class' => 'span2 menudiet', 'options' => array("$menudiet_id" => array("selected" => "selected")))) . '</td>';
              }
            } else {
              if (!empty($menudiet_id)) {
                $tr .= '<td>' . CHtml::hiddenField('KirimmenupegawaiT[][jeniswaktu_id][' . $v->jeniswaktu_id . ']', $v->jeniswaktu_id, array('readonly' => true))
                  . CHtml::dropDownList('KirimmenupegawaiT[][menudiet_id][' . $v->jeniswaktu_id . ']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('onchange' => 'cekStokMenu(this)', 'empty' => '-- Pilih --', 'class' => 'span2 menudiet', 'options' => array("$menudiet_id" => array("selected" => "selected")))) . '</td>';
              } else {
                $tr .= '<td>' . CHtml::hiddenField('KirimmenupegawaiT[][jeniswaktu_id][' . $v->jeniswaktu_id . ']', $v->jeniswaktu_id, array('readonly' => true))
                  . CHtml::dropDownList('KirimmenupegawaiT[][menudiet_id][' . $v->jeniswaktu_id . ']', '', Chtml::listData(MenuDietM::model()->findAll(), 'menudiet_id', 'menudiet_nama'), array('onchange' => 'cekStokMenu(this)', 'empty' => '-- Pilih --', 'class' => 'span2 menudiet',)) . '</td>';
              }
            }
          }
          $tr .= '<td>' . CHtml::activeTextField($modDetail, '[]jml_kirim', array('value' => $jumlah, 'class' => ' span1 numbersOnly jmlKirim', 'onblur' => 'cekStokMenuInput(this)')) . '</td>
                            <td>' . CHtml::activeDropDownList($modDetail, '[]satuanjml_urt', LookupM::getItems('ukuranrumahtangga'), array('empty' => '-- Pilih --', 'class' => 'span2 urt', 'options' => array("$urt" => array("selected" => "selected")))) . '</td>
                            </tr>';
        }
      }

      echo json_encode($tr);
      Yii::app()->end();
    }
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

  public function actionBatalKirimMenuDiet()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idKirimDiet = $_POST['idKirimDiet'];
      $modelKirim = new KirimmenudietT;
      $model = KirimmenudietT::model()->findByPk($idKirimDiet);
      $modDetail = KirimmenupasienT::model()->findAllByAttributes(array('kirimmenudiet_id' => $idKirimDiet));
      $modPegawai = KirimmenupegawaiT::model()->findAllByAttributes(array('kirimmenudiet_id' => $idKirimDiet));

      $totDet = count((array)$modDetail);
      $totPeg = count((array)$modPegawai);

      if (count((array)$modPegawai) > 0) {
        $total = $totPeg;
      } else {
        $total = $totDet;
      }

      if (isset($_POST['KirimmenupegawaiT']) || isset($_POST['KirimmenupasienT'])) {
        if (count((array)$modDetail) > 0 || count((array)$modPegawai) > 0) {
          if (count((array)$modPegawai) > 0) {
            // Untuk Menghapus Kirim Menu Diet untuk Pegawai
            if (count((array)$_POST['KirimmenupegawaiT']) > 0) {
              foreach ($_POST['KirimmenupegawaiT'] as $i => $v) {
                if (isset($v['checkList'])) {
                  if (empty($v['pesanmenupegawai_id'])) {
                    $detail = false;
                  } else {
                    $detail = true;
                    $updatePesanPegawai = PesanmenupegawaiT::model()->updateByPk($v['pesanmenupegawai_id'], array('kirimmenupegawai_id' => null));
                    $updateKirimPegawai = KirimmenupegawaiT::model()->updateByPk($v['kirimmenupegawai_id'], array('pesanmenupegawai_id' => null));
                  }

                  if ($detail == true) {
                    $deletePegawai = KirimmenupegawaiT::model()->deleteByPk($v['kirimmenupegawai_id']);
                    if ($updatePesanPegawai && $updateKirimPegawai && $deletePegawai) {
                      $delete = true;
                    } else {
                      $delete = false;
                    }
                  } else {
                    $deletePegawai = KirimmenupegawaiT::model()->deleteByPk($v['kirimmenupegawai_id']);
                    if ($deletePegawai) {
                      $delete = true;
                    } else {
                      $delete = false;
                    }
                  }
                  $totPeg = count(KirimmenupegawaiT::model()->findAllByAttributes(array('kirimmenudiet_id' => $idKirimDiet)));
                  if ($totPeg < 1) {
                    $updatePasienDiet = PesanmenudietT::model()->updateAll(array('kirimmenudiet_id' => null), 'kirimmenudiet_id = ' . $idKirimDiet . '');
                    $updateKirimDiet = KirimmenudietT::model()->updateByPk($idKirimDiet, array('pesanmenudiet_id' => null));
                    if (isset($v['pesanmenudiet_id'])) {
                      $deletePesanDiet = PesanmenudietT::model()->deleteByPk($v['pesanmenudiet_id']);
                    }
                    if ($updatePasienDiet && $updateKirimDiet) {
                      $updateAll = true;
                    } else {
                      $updateAll = false;
                    }
                  }
                }
              }
              if ($delete == true || $updateAll == true) {
                if ($totPeg < 1) {
                  KirimmenudietT::model()->deleteByPk($idKirimDiet);
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
            // Untuk Menghapus Kirim Menu Diet untuk Pasien
            if (count((array)$_POST['KirimmenupasienT']) > 0) {
              $jml = 1;
              foreach ($_POST['KirimmenupasienT'] as $i => $v) {
                if (isset($v['checkList'])) {
                  if (empty($v['pesanmenudetail_id'])) {
                    $details = false;
                  } else {
                    $details = true;
                    $updatePesanPasien = PesanmenudetailT::model()->updateByPk($v['pesanmenudetail_id'], array('kirimmenupasien_id' => null));
                    $updateKirimPasien = KirimmenupasienT::model()->updateByPk($v['kirimmenupasien_id'], array('pesanmenudetail_id' => null));
                  }

                  $criteria = new CDbCriteria();
                  $criteria->compare('menudiet_id', $v['menudiet_id']);
                  $menudiet = MenuDietM::model()->findAll($criteria);
                  // Untuk Menghapus menu gizi dari TindakanPelayananT
                  foreach ($menudiet as $d => $diet) {
                    $criteria2 = new CDbCriteria();
                    $criteria2->compare('pendaftaran_id', $v['pendaftaran_id']);
                    $criteria2->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                    $criteria2->compare('daftartindakan_id', $diet->daftartindakan_id);
                    $criteria2->addCondition('tindakansudahbayar_id is null');
                    $tindakan = TindakanpelayananT::model()->findAll($criteria2);
                    if (count((array)$tindakan) > 0) {
                      foreach ($tindakan as $key => $datas) {
                        $tindakanpelayanan_id = $datas->tindakanpelayanan_id;
                        $daftartindakan_id = $diet->daftartindakan_id;
                      }
                    } else {
                      echo CJSON::encode(array(
                        'status' => 'proses_form',
                        'pesan' => 'Gagal',
                        'keterangan' => 'Maaf, tindakan tidak dapat dibatalkan , karena sudah dibayarkan !',
                        'total' => $totDet,
                        'div' => "<div class='flash-success'>Maaf, tindakan tidak dapat dibatalkan , karena sudah dibayarkan ! </div>",
                      ));
                    }
                  }
                  // Untuk Menghapus menu Gizi dari KirimmenupasienT                    
                  if ($details == true) {
                    $deleteDetail = KirimmenupasienT::model()->deleteByPk($v['kirimmenupasien_id']);
                    if ($deleteDetail) {
                      TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $tindakanpelayanan_id));
                      TindakanpelayananT::model()->deleteByPk($tindakanpelayanan_id);
                      $tindakan = true;
                    } else {
                      $tindakan = false;
                    }
                  } else {
                    $deleteDetail = KirimmenupasienT::model()->deleteByPk($v['kirimmenupasien_id']);
                    if ($deleteDetail) {
                      TindakanpelayananT::model()->deleteByPk($tindakanpelayanan_id);
                      TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $tindakanpelayanan_id));
                      $tindakan = true;
                    } else {
                      $tindakan = false;
                    }
                  }
                }
                $totDet = count(KirimmenupasienT::model()->findAllByAttributes(array('kirimmenudiet_id' => $idKirimDiet)));
                if ($totDet < 1) {
                  $updatePasienDiet = PesanmenudietT::model()->updateAll(array('kirimmenudiet_id' => null), 'kirimmenudiet_id = ' . $idKirimDiet . '');
                  $updateKirimDiet = KirimmenudietT::model()->updateByPk($idKirimDiet, array('pesanmenudiet_id' => null));
                  if (isset($v['pesanmenudiet_id'])) {
                    $deletePesanDiet = PesanmenudietT::model()->deleteByPk($v['pesanmenudiet_id']);
                  }
                  if ($updatePasienDiet && $updateKirimDiet) {
                    $updateAll = true;
                  } else {
                    $updateAll = false;
                  }
                }
                $jml++;
              }
            }
          }

          if ($tindakan == true || $updateAll == true) {
            // Untuk Menghapus Data Kirim Menu Diet dari KirimmenudietT
            if ($totDet < 1) {
              KirimmenudietT::model()->deleteByPk($idKirimDiet);
            }
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'pesan' => 'Berhasil',
              'keterangan' => '',
              'total' => $totDet,
              'div' => "<div class='flash-success'>Pengiriman Menu Diet <b></b> berhasil dibatalkan </div>",
            ));
            exit;
          } else {
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'pesan' => 'Gagal',
              'keterangan' => '',
              'total' => $totDet,
              'div' => "<div class='flash-success'>Pengiriman Menu Diet <b></b> gagal dibatalkan </div>",
            ));
            exit;
          }
        }
      }

      echo CJSON::encode(array(
        'status' => 'create_form',
        'idKirim' => $idKirimDiet,
        'total' => $total,
        'div' => $this->renderPartial('_formBatalKirimDiet', array('modelKirim' => $modelKirim, 'modDetail' => $modDetail, 'modPegawai' => $modPegawai, 'model' => $model), true)
      ));
      exit;
    }
  }

  public function actionPrintLabelNew($id = null, $jeniswaktu = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;

    $modKirim = KirimmenudietT::model()->findByPk($id);
    if ($modKirim->jenispesanmenu == Params::JENISPESANMENU_PASIEN) {
      $criteria = new CDbCriteria();
      $criteria->select = 'kirimmenudiet_id,pendaftaran_id,pasienadmisi_id';
      $criteria->group = 'kirimmenudiet_id,pendaftaran_id,pasienadmisi_id';
      $criteria->compare('kirimmenudiet_id', $id);
      $modDetailKirim = KirimmenupasienT::model()->find($criteria);
    } else {
      $criteria = new CDbCriteria();
      $criteria->select = 'kirimmenudiet_id,pegawai_id';
      $criteria->group = 'kirimmenudiet_id,pegawai_id';
      $criteria->compare('kirimmenudiet_id', $id);
      $modDetailKirim = KirimmenupegawaiT::model()->find($criteria);
    }

    $model = GZPesanmenudietT::model()->findByPk($modKirim->pesanmenudiet_id);

    $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
    $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait

    /*
        $this->render('printLabelNew', array(
                'format'=>$format,
                'modKirim'=>$modKirim,
                'modDetailKirim'=>$modDetailKirim,
                'jeniswaktu'=>$jeniswaktu,
            ));
        Yii::app()->end();
        // * 
        // */

    $mpdf = new MyPDF60('', array(70, 60));
    // ob_clean();
    $mpdf->mirrorMargins = 0;
    $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    $mpdf->WriteHTML($stylesheet, 1);
    $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
    $mpdf->SetHtmlFooter($this->renderPartial("application.views.footer._footerLabel", array(), true), 'O');
    $mpdf->WriteHTML(
      $this->renderPartial('printLabelNew', array(
        'format' => $format,
        'modKirim' => $modKirim,
        'modDetailKirim' => $modDetailKirim,
        'jeniswaktu' => $jeniswaktu,
        'model' => $model,
      ), true)
    );
    $mpdf->SetJS('this.print();');
    $mpdf->Output();
  }
}
