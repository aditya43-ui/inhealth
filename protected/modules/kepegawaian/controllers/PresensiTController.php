<?php

class PresensiTController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $IP = Params::IP_FINGER_PRINT;
  public $Key = Params::KEY_FINGER_PRINT;
  public $presensi_id;

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate($presensi_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Presensi";
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $format = new MyFormatter();
    $model = new KPPresensiT;
    $model->tglpresensi = date('d M Y');
    $model->tglpresensi_akhir = date('d M Y');
    $modPegawai = new KPRegistrasifingerprint();

    if(!empty($_GET['abnormalabsen_id'])){
      $modAbnormalAbsen = AbnormalabsenT::model()->findByPk($_GET['abnormalabsen_id']);

      if(!empty($modAbnormalAbsen)){
        $model->pegawai_id = $modAbnormalAbsen->pegawai_id;
        $model->statuskehadiran_id = Params::STATUSKEHADIRAN_HADIR;
        $model->tglpresensi = (!empty($modAbnormalAbsen->tglabnormalabsen) ? MyFormatter::formatDateTimeForUser(date('Y-m-d',strtotime(MyFormatter::formatDateTimeForDb($modAbnormalAbsen->tglabnormalabsen)))) : null);
        $model->jamscanmasuk = (!empty($modAbnormalAbsen->jammasuk)? $modAbnormalAbsen->jammasuk: null);
        $model->jamscanpulang = (!empty($modAbnormalAbsen->jamkeluar)? $modAbnormalAbsen->jamkeluar: null);
      }
    }

    // Uncomment the following line if AJAX validation is needed


    if (!empty($presensi_id)) {
      $model = KPPresensiT::model()->findByPk($presensi_id);
      $modPegawai = KPRegistrasifingerprint::model()->findByAttributes(array('pegawai_id' => $model->pegawai_id));
    }
    if (isset($_POST['KPPresensiT'])) {
      $ok = true;
      $trans = Yii::app()->db->beginTransaction();

      try {
        $model->attributes = $_POST['KPPresensiT'];
        $model->bukti_file = CUploadedFile::getInstance($model, 'bukti_file');
        $file_bukti = $model->bukti_file;

        $fullImgName = date('dmY_s') . $model->pegawai_id . $file_bukti;

        $fullImgSource = Params::pathPegawaiFileDirectory() . $fullImgName;

        $modPegawai = KPRegistrasifingerprint::model()->findByPk($_POST['KPRegistrasifingerprint']['pegawai_id']);
        $modPegawai->jabatan_id = isset($modPegawai->jabatan_id) ? $modPegawai->jabatan->jabatan_nama : '-';
        $modPegawai->tgl_lahirpegawai = $format->formatDateTimeForUser($modPegawai->tgl_lahirpegawai);
        //var_dump($_POST);
        //die;
        $model->pegawai_id = $_POST['KPRegistrasifingerprint']['pegawai_id'];
        $model->no_fingerprint = (!empty($_POST['KPRegistrasifingerprint']['nofingerprint']) ? $_POST['KPRegistrasifingerprint']['nofingerprint'] : "Belum Register");
        $model->tglpresensi = MyFormatter::formatDateTimeForDb($model->tglpresensi);
        $model->isfingerprintscan = FALSE;
        $model->verifikasi = true;
        if (isset($_POST['KPPresensiT']['jamkerjamasuk'])) {
          $model->jamkerjamasuk = $_POST['KPPresensiT']['jamkerjamasuk'];
        }

        if (isset($_POST['KPPresensiT']['jamkerjapulang'])) {
          $model->jamkerjapulang = $_POST['KPPresensiT']['jamkerjapulang'];
        }
        $criteriaPresensiLoad = new CDbCriteria();
        $criteriaPresensiLoad->addCondition('pegawai_id ='.$model->pegawai_id);
        $criteriaPresensiLoad->addCondition("tglpresensi::date ='".$model->tglpresensi."'");
        $criteriaPresensiLoad->addCondition('statusscan_id ='.Params::STATUSSCAN_DATANG);
        $prs_datang = PresensiT::model()->find($criteriaPresensiLoad);

        $shift_iddatang = null;
        if(!empty($prs_datang)){
          $shift_iddatang = $prs_datang->shift_id;
        }

        if ($model->statusscan_id == Params::STATUSSCAN_MASUK || $model->statusscan_id == Params::STATUSSCAN_DATANG) {
          $model->tglpresensi = $model->tglpresensi . ' ' . $_POST['KPPresensiT']['jamscanmasuk'];
          if($model->statusscan_id == Params::STATUSSCAN_MASUK){
            $model->shift_id = $shift_iddatang;
          }
          $model->pulangawal_mnt = null;
        } elseif ($model->statusscan_id == Params::STATUSSCAN_KELUAR || $model->statusscan_id == Params::STATUSSCAN_PULANG) {
          $model->terlambat_mnt = null;
          
          if($model->statusscan_id == Params::STATUSSCAN_KELUAR){
            $model->shift_id = $shift_iddatang;
          }

          $model->tglpresensi = $model->tglpresensi . ' ' . $_POST['KPPresensiT']['jamscanpulang'];
        } else {
          $model->jamkerjamasuk = null;
          $model->jamkerjapulang = null;
        }

        $model->jamkerjamasuk = empty($model->jamkerjamasuk) ? null : $model->jamkerjamasuk;
        $model->jamkerjapulang = empty($model->jamkerjapulang) ? null : $model->jamkerjapulang;


        // var_dump($model->validate(), $model->errors, $model->attributes, $_POST); die;
        if ($model->statuskehadiran_id == Params::STATUSKEHADIRAN_HADIR) {
          $ok = $ok && $model->save();
        } else {
          $ok = $ok && $this->simpanMultiplePresensi($model, $_POST['KPPresensiT']);
          $model->presensi_id = $this->presensi_id;
        }


        // var_dump($ok); die;
        if ($ok) {

          if (!empty($file_bukti)) {
            $file_bukti->saveAs($fullImgSource);
          }
          //die;
          $trans->commit();
          Yii::app()->user->setFlash('success', 'Data Presensi ' . $model->pegawai->nama_pegawai . ' berhasil disimpan.');
          $this->redirect(array('create', 'presensi_id' => $model->presensi_id, 'sukses' => 1));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $e) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($e, true));
      }
      //var_dump($model->attributes);die;
      //$shift = $model->getShiftId($model->pegawai_id);

      //$tgl = date('Y-m-d',strtotime($format->formatDateTimeForDb($model->tglpresensi)));


      /*$model->statusscan_id = $_POST['KPPresensiT']['statusscan_id'];
                    if ($model->statusscan_id == Params::STATUSSCAN_MASUK){
                        //$model->jamkerjamasuk = $_POST['KPPresensiT']['jamkerjamasuk'];
                        $model->tglpresensi = $tgl.' '.$_POST['KPPresensiT']['jamkerjamasuk'];

                        $model->jamkerjamasuk = (count((array)$shift)>0 && !empty($shift))?$shift->shift_jamawal:'08:15:00';
                        //$model->terlambat_mnt = $model->getTerlambat($model->tglpresensi, $model->jamkerjamasuk);
                        //$model->pulangawal_mnt = '';

                        $jammasuk = date('H:is',strtotime($model->tglpresensi));
                        if (count((array)$shift)>0 && !empty($shift)){
                            if ( ($shift->shift_id == Params::SHIFT_PAGI)):
                                if ($jammasuk > '09:00:00'):
                                    $model->statuskehadiran_id = Params::STATUSKEHADIRAN_ALPHA;
                                endif;
                            endif;
                        }else{
                           // if ($shift==null){
                            //    if ($jammasuk > '09:00:00'):
                            //        $model->statuskehadiran_id = Params::STATUSKEHADIRAN_ALPHA;
                            //    endif;
                          //  }
                        }


                    }elseif($model->statusscan_id == Params::STATUSSCAN_PULANG){
                        $model->tglpresensi = $tgl.' '.$_POST['KPPresensiT']['jamkerjapulang'];
                        $model->jamkerjapulang = (count((array)$shift)>0 && !empty($shift))?$shift->shift_jamakhir:'15:00:00';
                       // $model->pulangawal_mnt = $model->getPulangAwal($model->tglpresensi, $model->jamkerjapulang);
                       // $model->terlambat_mnt = '';
                        //$model->jamkerjapulang = $_POST['KPPresensiT']['jamkerjapulang'];
                    }elseif($model->statusscan_id == Params::STATUSSCAN_DATANG){
                        $model->tglpresensi = $tgl.' '.$_POST['KPPresensiT']['jamkerjamasuk'];
                       // $model->terlambat_mnt = '';
                       // $model->pulangawal_mnt = '';
                    }elseif($model->statusscan_id == Params::STATUSSCAN_KELUAR){
                        $model->tglpresensi = $tgl.' '.$_POST['KPPresensiT']['jamkerjapulang'];
                     //   $model->terlambat_mnt = '';
                      //  $model->pulangawal_mnt = '';
                    }else{
                        $model->tglpresensi =$tgl.' '.date('H:i:s');
                    }


                    $cr = new CDbCriteria();
                     if ($model->statuskehadiran_id == Params::STATUSKEHADIRAN_IZIN){
                         $cr->addCondition("pegawai_id = '$model->pegawai_id' ");
                     }else{
                         $cr->addCondition("statusscan_id = ".$model->statusscan_id);
                         $cr->addCondition("statuskehadiran_id = '".Params::STATUSKEHADIRAN_HADIR."' AND pegawai_id = '$model->pegawai_id' ");
                     }
                    $cr->addBetweenCondition('tglpresensi', $tgl.' 00:00:00', $tgl.' 23:59:59');
                    $cek = PresensiT::model()->find($cr);

                    $cr2 = new CDbCriteria();
                    $cr2->addCondition("statusscan_id = ".$model->statusscan_id);
                    $cr2->addBetweenCondition('date(tglpresensi)', $tgl, $tgl);
                    $cekStatus = PresensiT::model()->find($cr2);
                          */
      //  $valid = $model->validate();
      // var_dump($model->tglpresensi);die;
      // if (count((array)$cek) > 0){
      //   if ($model->statuskehadiran_id == Params::STATUSKEHADIRAN_IZIN)
      // {
      //   $jam = (count((array)$shift)>0 && !empty($shift))?$shift->shift_jamakhir:'15:00:00';
      //  $tanggal = $tgl.' '.$jam;

      // if ($tanggal <= $model->tglpresensi){
      //   Yii::app()->user->setFlash('error', 'Maaf, pegawai '.$modPegawai->nama_pegawai.' jam kerjanya berakhir pada pukul '.date('H:i:s',strtotime($tanggal)));
      //}else{
      //  if($valid){
      // if (count((array)$cekStatus)>0){
      //   Yii::app()->user->setFlash('error', 'Maaf, pegawai '.$modPegawai->nama_pegawai.' sudah melakukan absensi masuk pada pukul '.date('H:i:s',strtotime($tanggal)));
      //}else{
      //echo "tes atas izin";die;
      //	$model->save();
      //	Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
      //	$this->redirect(array('create','presensi_id'=>$model->presensi_id,'sukses'=>1));
      //}
      // } else {
      //   Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
      // }
      // }
      /* }elseif ($model->statuskehadiran_id == Params::STATUSKEHADIRAN_ALPHA){
                            if ($cek->statuskehadiran_id == Params::STATUSKEHADIRAN_HADIR){
                                Yii::app()->user->setFlash('error', 'Maaf, pegawai '.$modPegawai->nama_pegawai.' sudah '.$cek->statusscan->statusscan_nama.' pada jam '.date('H:i:s',strtotime($cek->tglpresensi)));
                            }else{
                                 if (count((array)$cekStatus)>0){
                                    Yii::app()->user->setFlash('error', 'Maaf, pegawai '.$modPegawai->nama_pegawai.' sudah melakukan absensi masuk pada pukul '.date('H:i:s',strtotime($tanggal)));
                                }else{
                                    $model->save();
                                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                    $this->redirect(array('create','presensi_id'=>$model->presensi_id,'sukses'=>1));
                                }
                            }
                        }else{
                            if ($cek->statusscan_id == $model->statusscan_id){
                                Yii::app()->user->setFlash('error', 'Maaf, pegawai '.$modPegawai->nama_pegawai.' pada tanggal '.date('d M Y',strtotime($tgl)).' sudah melakukan absensi '.$model->statusscan->statusscan_nama);
                            }else{
                                if($valid){
                                    if (count((array)$cekStatus)>0){
                                        Yii::app()->user->setFlash('error', 'Maaf, pegawai '.$modPegawai->nama_pegawai.' sudah melakukan absensi masuk pada pukul '.date('H:i:s',strtotime($tanggal)));
                                    }else{
                                        $model->save();
                                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                        $this->redirect(array('create','presensi_id'=>$model->presensi_id,'sukses'=>1));
                                    }
                                } else {
                                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                                }
                            }
                        }   */
      //Yii::app()->user->setFlash('error', 'Sudah Ada.');
      //  }else{
      /*$cr1 = new CDbCriteria();
                        $cr1->addCondition("statuskehadiran_id = '".Params::STATUSKEHADIRAN_ALPHA."' AND pegawai_id = '$model->pegawai_id' ");
                        $cr1->addBetweenCondition('tglpresensi', $tgl.' 00:00:00', $tgl.' 23:59:59');
                        $cek1 = PresensiT::model()->find($cr1);

                       // if (count((array)$shift)>0){
                           // if ($shift->shift_id == Params::SHIFT_PAGI ):
                            //    if (count((array)$cek1) > 0){
                                    //$model->statuskehadiran_id = Params::STATUSKEHADIRAN_ALPHA;
                          //      }
                          //  endif;
                       // }else{
                           //if ($shift == null ):
                            //if (count((array)$cek1) > 0){
                              //  $model->statuskehadiran_id = Params::STATUSKEHADIRAN_ALPHA;
                          //  }
                           // endif;
                       // }

                        if ($model->statusscan_id != Params::STATUSSCAN_MASUK){
                            $cr2 = new CDbCriteria();
                            $cr->addCondition("statusscan_id = ".Params::STATUSSCAN_MASUK);
                            $cr2->addCondition("statuskehadiran_id = '".Params::STATUSKEHADIRAN_ALPHA."' AND pegawai_id = '$model->pegawai_id' ");
                            $cr2->addBetweenCondition('tglpresensi', $tgl.' 00:00:00', $tgl.' 23:59:59');
                            $cek2 = PresensiT::model()->find($cr2);

                            if (count((array)$cek2)==0):
                              //  $model->statuskehadiran_id = Params::STATUSKEHADIRAN_ALPHA;
                            endif;
                        }
                        */

      /* if($valid){
                                if (count((array)$cekStatus)>0){
                                    Yii::app()->user->setFlash('error', 'Maaf, pegawai '.$modPegawai->nama_pegawai.' sudah melakukan absensi masuk pada pukul '.date('H:i:s',strtotime($tanggal)));
                                }else{
                                    $model->save();
                                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                    $this->redirect(array('create','presensi_id'=>$model->presensi_id,'sukses'=>1));
                                }
                        } else {
                            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
                        }*/
      //  }

    }

    $this->render('create', array(
      'model' => $model, 'modPegawai' => $modPegawai,
    ));
  }


  public function simpanMultiplePresensi($model, $post)
  {

    $ok = true;

    $tgl_awal = MyFormatter::formatDateTimeForDb($post['tglpresensi']);
    $tgl_akhir = MyFormatter::formatDateTimeForDb($post['tglpresensi_akhir']);

    $period = new DatePeriod(
      new DateTime($tgl_awal),
      new DateInterval('P1D'),
      new DateTime(date('Y-m-d', strtotime('+1 day', strtotime($tgl_akhir))))
    );

    foreach ($period as $item) {
      $model_baru = new KPPresensiT;
      $model_baru->attributes = $model->attributes;
      $model_baru->isfingerprintscan = false;

      $model_baru->tglpresensi = $item->format('Y-m-d');

      if ($model_baru->validate()) {
        $ok = $ok && $model_baru->save();
        $this->presensi_id = $model_baru->presensi_id;
      }
    }

    return $ok;
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


    if (isset($_POST['KPPresensiT'])) {
      $model->attributes = $_POST['KPPresensiT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data Presensi ' . $model->pegawai->nama_pegawai . ' berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->presensi_id));
      }
    }

    $this->render('update', array(
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
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('KPPresensiT');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */


  public function actionAdmin()
  {


    if (Yii::app()->request->isAjaxRequest) {
      if (isset($_GET['idAlat']) && !isset($_GET['disconnect'])) {
        AlatfingerM::model()->updateAll(array('alat_aktif' => false));
        $idAlat = $_GET['idAlat'];
        $value = AlatfingerM::model()->updateByPk($idAlat, array('alat_aktif' => true));
        $result['success'] = $value;
        $result['data'] = AlatfingerM::model()->findByPk($idAlat)->attributes;
        $result['connection'] = $this->connection($result['data']['ipfinger']);
        $result['time'] = date('d M Y');
        echo json_encode($result);
        Yii::app()->end();
      } else if (isset($_GET['idAlat']) && isset($_GET['disconnect'])) {
        $value = AlatfingerM::model()->updateAll(array('alat_aktif' => false));
        $result['success'] = true;
        echo json_encode($result);
        Yii::app()->end();
      }
    }

    $model = new KPPresensiT('search');
    $model->tglpresensi = date('Y-m-d 00:00:00');
    $model->tglpresensi_akhir = date('Y-m-d 23:59:59');
    //		$model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPPresensiT'])) {
      $model->attributes = $_GET['KPPresensiT'];
      $format = new MyFormatter();
      $model->tglpresensi = $format->formatDateTimeForDb($model->tglpresensi);
      $model->tglpresensi_akhir = $format->formatDateTimeForDb($model->tglpresensi_akhir);
    }

    $this->render('admin', array(
      'model' => $model,
    ));
  }


  public function actionInformasiPresensi()
  {
    $this->pageTitle = Yii::app()->name . " - Presensi";
    $model = new KPPresensiT('search');
    $model->tglpresensi = date('Y-m-d');
    $model->tglpresensi_akhir = date('Y-m-d');
    //$criPmasuk = $model->searchInformasiPresensiBaru();
    //echo "<pre>";
    //var_dump($criPmasuk);
    //echo "</pre>";
    //die;



    if (!Yii::app()->user->getState('isotomatispresensi')) {  //RND-7741
      if (Yii::app()->request->isAjaxRequest) {
        if (isset($_GET['idAlat']) && !isset($_GET['disconnect'])) {
          AlatfingerM::model()->updateAll(array('alat_aktif' => false));
          $idAlat = $_GET['idAlat'];
          $value = AlatfingerM::model()->updateByPk($idAlat, array('alat_aktif' => true));
          $result['success'] = $value;
          $result['data'] = AlatfingerM::model()->findByPk($idAlat)->attributes;
          $result['connection'] = ($this->connection($result['data']['ipfinger']) == false ? $this->connection($result['data']['ipfinger']) : true);
          $result['time'] = date('d M Y');
          echo json_encode($result);
          Yii::app()->end();
        } else if (isset($_GET['idAlat']) && isset($_GET['disconnect'])) {
          $value = AlatfingerM::model()->updateAll(array('alat_aktif' => false));
          $result['success'] = true;
          echo json_encode($result);
          Yii::app()->end();
        }
      }
    }

    //		$model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPPresensiT'])) {
      $model->attributes = $_GET['KPPresensiT'];
      $format = new MyFormatter();
      $model->tglpresensi = $format->formatDateTimeForDb($model->tglpresensi);
      $model->tglpresensi_akhir = $format->formatDateTimeForDb($model->tglpresensi_akhir);
      $model->kelompokpegawai_id = isset($_GET['KPPresensiT']['kelompokpegawai_id']) ? $_GET['KPPresensiT']['kelompokpegawai_id'] : null;
      $model->jabatan_id = isset($_GET['KPPresensiT']['jabatan_id']) ? $_GET['KPPresensiT']['jabatan_id'] : null;
      $model->shift_id = isset($_GET['KPPresensiT']['shift_id']) ? $_GET['KPPresensiT']['shift_id'] : null;
      $model->statuskehadiran_id = isset($_GET['KPPresensiT']['statuskehadiran_id']) ? $_GET['KPPresensiT']['statuskehadiran_id'] : null;
      $model->statusscan = isset($_GET['KPPresensiT']['statusscan']) ? $_GET['KPPresensiT']['statusscan'] : null;
    }

    $this->render('informasiBaru', array(
      'model' => $model,
    ));
  }

  public function actionPrintInformasi($caraPrint = "PRINT")
  {
    $model = new KPPresensiT('search');
    $model->tglpresensi = date('Y-m-d');
    $model->tglpresensi_akhir = date('Y-m-d');
    //$criPmasuk = $model->searchInformasiPresensiBaru();
    //echo "<pre>";
    //var_dump($criPmasuk);
    //echo "</pre>";
    //die;



    if (!Yii::app()->user->getState('isotomatispresensi')) {  //RND-7741
      if (Yii::app()->request->isAjaxRequest) {
        if (isset($_GET['idAlat']) && !isset($_GET['disconnect'])) {
          AlatfingerM::model()->updateAll(array('alat_aktif' => false));
          $idAlat = $_GET['idAlat'];
          $value = AlatfingerM::model()->updateByPk($idAlat, array('alat_aktif' => true));
          $result['success'] = $value;
          $result['data'] = AlatfingerM::model()->findByPk($idAlat)->attributes;
          $result['connection'] = ($this->connection($result['data']['ipfinger']) == false ? $this->connection($result['data']['ipfinger']) : true);
          $result['time'] = date('d M Y');
          echo json_encode($result);
          Yii::app()->end();
        } else if (isset($_GET['idAlat']) && isset($_GET['disconnect'])) {
          $value = AlatfingerM::model()->updateAll(array('alat_aktif' => false));
          $result['success'] = true;
          echo json_encode($result);
          Yii::app()->end();
        }
      }
    }

    //		$model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPPresensiT'])) {
      $model->attributes = $_GET['KPPresensiT'];
      $format = new MyFormatter();
      $model->tglpresensi = $format->formatDateTimeForDb($model->tglpresensi);
      $model->tglpresensi_akhir = $format->formatDateTimeForDb($model->tglpresensi_akhir);
      $model->kelompokpegawai_id = isset($_GET['KPPresensiT']['kelompokpegawai_id']) ? $_GET['KPPresensiT']['kelompokpegawai_id'] : null;
      $model->jabatan_id = isset($_GET['KPPresensiT']['jabatan_id']) ? $_GET['KPPresensiT']['jabatan_id'] : null;
      $model->shift_id = isset($_GET['KPPresensiT']['shift_id']) ? $_GET['KPPresensiT']['shift_id'] : null;
      $model->statuskehadiran_id = isset($_GET['KPPresensiT']['statuskehadiran_id']) ? $_GET['KPPresensiT']['statuskehadiran_id'] : null;
      $model->statusscan = isset($_GET['KPPresensiT']['statusscan']) ? $_GET['KPPresensiT']['statusscan'] : null;
    }


    $periode = MyFormatter::formatDateTimeForUser($model->tglpresensi) . " s/d " . MyFormatter::formatDateTimeForUser($model->tglpresensi_akhir);
    $judulLaporan = 'PRESENSI';
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('informasiPrint', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('informasiPrint', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'periode' => $periode));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                    // Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                                     // Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('informasiPrint', array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }


  public function actionAmbilData()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (isset($_POST['ip'], $_POST['key'])) {
        $key = $_POST['key'];
        $ip = $_POST['ip'];
      }
      $result = $this->retrieveData($ip, $key);
      if (is_array($result)) {
        $insert = $this->insertPerdetik($result);
        if ($insert == true) {
          $this->deleteAllData($ip, $key);
        }
        echo $insert;
      } else {
        echo true;
      }
      Yii::app()->end();
    }
  }

  private function connection($ip)
  {
    $result = false;
    if (fsockopen($ip, "80", $errno, $errstr, 1)) {
      $result = fsockopen($ip, "80", $errno, $errstr, 1);
    }
    return $result;
  }

  protected function retrieveData($ip, $key)
  {
    //110.136.158.153 224 192.168.1.150 SUPERUSERBSS

    $Connect = $this->connection($ip);
    if ($Connect) {
      $soap_request = "<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">" . $key . "</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
      $newLine = "\r\n";
      fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
      fputs($Connect, "Content-Type: text/xml" . $newLine);
      fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
      fputs($Connect, $soap_request . $newLine);
      $buffer = "";
      while ($Response = fgets($Connect, 1024)) {
        $buffer = $buffer . $Response;
      }
      $buffer = $this->ParseData($buffer, "<GetAttLogResponse>", "</GetAttLogResponse>");
      $buffer = explode("\r\n", $buffer);


      $result = array();
      for ($a = 0; $a < count((array)$buffer); $a++) {
        $data = $this->ParseData($buffer[$a], "<Row>", "</Row>");
        $hasil = $this->ParseData($data, "<PIN>", "</PIN>");
        if (!empty($hasil)) {
          $result[$a]['pin'] = $this->ParseData($data, "<PIN>", "</PIN>");
          $result[$a]['date'] = $this->ParseData($data, "<DateTime>", "</DateTime>");
          $result[$a]['verified'] = $this->ParseData($data, "<Verified>", "</Verified>");
          $result[$a]['status'] = $this->ParseData($data, "<Status>", "</Status>");
        }
      }
      if (count((array)$result) == 0) {
        $result = false;
      }
      return $result;
    } else {
      return false;
    }
  }

  protected function insertPerdetik($result)
  {
    //            $data = $this->retrieveData();
    if (count((array)$result) > 0) {
      $transaction = Yii::app()->db->beginTransaction();
      $user_id = Yii::app()->user->id;
      try {
        $counter = 0;
        $jumlah = 0;
        foreach ($result as $i => $row) {
          $pegawai = PegawaiM::model()->findByAttributes(array('nofingerprint' => $row['pin']));
          if (!empty($pegawai)) {

            $jumlah++;
            $model = new PresensiT();
            $model->tglpresensi = $row['date'];
            $model->no_fingerprint = $row['pin'];
            $model->statusscan_id = $row['status'];
            if ($row['status'] == 0) {
              $model->statusscan_id = 5;
            }
            //                            $model->verifikasi = $row['verified'];
            $model->pegawai_id = $pegawai->pegawai_id;
            $model->create_time = date('Y-m-d H:i:s');
            $model->statuskehadiran_id = 1;
            $model->create_loginpemakai_id = $user_id;
            if ($model->save()) {
              $counter++;
            } else {
              throw new Exception('Presensi ' . $row['pin'] . ' - ' . $row['date'] . ' gagal disimpan');
            }
          } else {
            throw new Exception('Pegawai dengan no finger print ' . $row['pin'] . ' - ' . $row['date'] . ' tidak ditemukan');
          }
        }
        if (($jumlah == $counter) && ($counter != 0)) {
          $transaction->commit();
          return true;
        } else {
          throw new Exception("Jumlah yang di save tidak sesuai");
        }
      } catch (Exception $ex) {
        echo $ex->getMessage();
      }
    }
  }

  protected function deleteAllData($ip, $key)
  {
    $Connect = $this->connection($ip);
    if ($Connect) {
      $soap_request = "<ClearData><ArgComKey xsi:type=\"xsd:integer\">" . $key . "</ArgComKey><Arg><Value xsi:type=\"xsd:integer\">3</Value></Arg></ClearData>";
      $newLine = "\r\n";
      fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
      fputs($Connect, "Content-Type: text/xml" . $newLine);
      fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
      fputs($Connect, $soap_request . $newLine);
      $buffer = "";
      while ($Response = fgets($Connect, 1024)) {
        $buffer = $buffer . $Response;
      }
    } else
      echo "Koneksi Gagal";
    $buffer = $this->ParseData($buffer, "<Information>", "</Information>");
    //            echo $buffer;
  }

  protected function ParseData($data, $p1, $p2)
  {
    $data = " " . $data;
    $hasil = "";
    $awal = strpos($data, $p1);
    if ($awal != "") {
      $akhir = strpos(strstr($data, $p1), $p2);
      if ($akhir != "") {
        $hasil = substr($data, $awal + strlen($p1), $akhir - strlen($p1));
      }
    }
    return $hasil;
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = KPPresensiT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'kppresensi-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id
   */
  public function actionRemoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
    //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {
    $model = new KPPresensiT;
    $model->attributes = $_REQUEST['KPPresensiT'];
    $judulLaporan = 'Data Presensi';
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
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionGetDataPegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = PegawaiM::model()->findByAttributes(array('pegawai_id' => $_POST['idPegawai']));

      $shift = ShiftpegawaiM::model()->findAll(" pegawai_id = '" . $data->pegawai_id . "' ");

      $dropshift = '';
      if (count((array)$shift) >= 0) {
        $dropshift .= "<option value=''>-- Pilih --</option>";
      } elseif (count((array)$shift) == 0) {
        //$dropshift .= "<option value=''>-- Pilih --</option>";
      }
      foreach ($shift as $s) {
        $dropshift .= "<option value='" . $s->shift_id . "'>" . $s->ShiftPegawaiJam . "</option>";
      }

      if (file_exists(Params::urlPegawaiTumbsDirectory() . 'kecil_' . $data->photopegawai)) {
        $photopegawai = Params::urlPegawaiTumbsDirectory() . 'kecil_' . $data->photopegawai;
      } else {
        $photopegawai =  Params::urlPegawaiTumbsDirectory() . 'no_photo.jpeg';
      }
      $post = array(
        'nomorindukpegawai' => $data->nomorindukpegawai,
        'nofingerprint' => $data->nofingerprint,
        'pegawai_id' => $data->pegawai_id,
        'nama_pegawai' => $data->nama_pegawai,
        'tempatlahir_pegawai' => $data->tempatlahir_pegawai,
        'tgl_lahirpegawai' => $format->formatDateTimeForUser($data->tgl_lahirpegawai),
        'jabatan_nama' => (isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : ''),
        'pangkat_nama' => (isset($data->pangkat->pangkat_nama) ? $data->pangkat->pangkat_nama : ''),
        'kategoripegawai' => $data->kategoripegawai,
        'kategoripegawaiasal' => $data->kategoripegawaiasal,
        'kelompokpegawai_nama' => (isset($data->kelompokpegawai->kelompokpegawai_nama) ? $data->kelompokpegawai->kelompokpegawai_nama : ''),
        'pendidikan_nama' => (isset($data->pendidikan->pendidikan_nama) ? $data->pendidikan->pendidikan_nama : ''),
        'jeniskelamin' => $data->jeniskelamin,
        'statusperkawinan' => $data->statusperkawinan,
        'alamat_pegawai' => $data->alamat_pegawai,
        'photopegawai' => $photopegawai,
        'shiftpegawai' => $dropshift
      );
      echo CJSON::encode($post);
      Yii::app()->end();
    }
  }

  /**
   * untuk print data penjualan dokter
   */
  public function actionPrintPresensi($presensi_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $model = KPPresensiT::model()->findByPk($presensi_id);
    $modPegawai = KPRegistrasifingerprint::model()->findByAttributes(array('pegawai_id' => $model->pegawai_id));

    $judul_print = 'Presensi Pegawai';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render('_print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'model' => $model,
      'modPegawai' => $modPegawai,
      'caraPrint' => $caraPrint
    ));
  }

  public function actionUbahDataPresensi($pegawai_id, $tglpresensi)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $presensi_id = $_GET['presensi_id'];
    $modPegawai = PegawaiM::model()->findByPK($pegawai_id);
    $modPegawai->nama_pegawai = $modPegawai->namaLengkap;
    $modPegawai->kelompokpegawai_nama = isset($modPegawai->kelompokpegawai_id) ? $modPegawai->kelompokpegawai->kelompokpegawai_nama : '';
    $modPegawai->jabatan_nama = isset($modPegawai->jabatan) ? $modPegawai->jabatan->jabatan_nama : '';


    $modPresensiMasuk = KPPresensiT::model()->findByPk($presensi_id['masuk']);
    $modPresensiDatang = KPPresensiT::model()->findByPk($presensi_id['datang']);
    $modPresensiKeluar = KPPresensiT::model()->findByPk($presensi_id['keluar']);
    $modPresensiPulang = KPPresensiT::model()->findByPk($presensi_id['pulang']);

    $status = false;

    $modUbahStatus = new KPPresensiT();
    $modUbahStatus->verifikasi = false;
    $modUbahStatus->pegawai_id = $pegawai_id;
    $modUbahStatus->no_fingerprint = (!empty($modPegawai->nofingerprint) ? $modPegawai->nofingerprint : "Belum Register");
    $modUbahStatus->tglpresensi = $tglpresensi;

    if (isset($presensi_id['shift_id'])) {
      $modUbahStatus->shift_id = $presensi_id['shift_id'];
    }
    if (!empty($modPresensiMasuk)) {
      $modUbahStatus->attributes = $modPresensiMasuk->attributes;
      $modUbahStatus->tgl_jammasuk = date("H:i:s", strtotime($modPresensiMasuk->tglpresensi));
      $modUbahStatus->presensimasuk_id = $modPresensiMasuk->presensi_id;
      $modPegawai->no_fingerprint = $modPresensiMasuk->no_fingerprint;
    }

    if (!empty($modPresensiDatang)) {
      if (empty($modPresensiMasuk)) {
        $modUbahStatus->attributes = $modPresensiDatang->attributes;
      }
      $modUbahStatus->jamkerjapulang = $modPresensiDatang->jamkerjapulang;
      $modPegawai->no_fingerprint = $modPresensiDatang->no_fingerprint;
    }

    if (!empty($modPresensiKeluar)) {
      if (empty($modPresensiMasuk)) {
        $modUbahStatus->attributes = $modPresensiKeluar->attributes;
      }
      $modUbahStatus->jamkerjapulang = $modPresensiKeluar->jamkerjapulang;
      $modPegawai->no_fingerprint = $modPresensiKeluar->no_fingerprint;
    }

    if (!empty($modPresensiPulang)) {
      if (empty($modPresensiMasuk)) {
        $modUbahStatus->attributes = $modPresensiPulang->attributes;
      }
      $modUbahStatus->tgl_jampulang = date("H:i:s", strtotime($modPresensiPulang->tglpresensi));
      $modUbahStatus->jamkerjapulang = $modPresensiPulang->jamkerjapulang;
      $modUbahStatus->presensipulang_id = $modPresensiPulang->presensi_id;
      $modPegawai->no_fingerprint = $modPresensiPulang->no_fingerprint;
    }

    if (!empty($modUbahStatus->shift_id) && $modUbahStatus->verifikasi != true) {
      $modUbahStatus->jamkerjamasuk = $modUbahStatus->shift->shift_jamawal;
      $modUbahStatus->jamkerjapulang = $modUbahStatus->shift->shift_jamakhir;
    }





    if (isset($_POST['KPPresensiT'])) {
      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();

      try {
        $modUbahStatus->attributes = $_POST['KPPresensiT'];
        $modUbahStatus->jamkerjamasuk = (!empty($_POST['KPPresensiT']['jamkerjamasuk']) ? $_POST['KPPresensiT']['jamkerjamasuk'] : null);
        $modUbahStatus->jamkerjapulang = (!empty($_POST['KPPresensiT']['jamkerjapulang']) ? $_POST['KPPresensiT']['jamkerjapulang'] : null);
        $modUbahStatus->shift_id = (!empty($_POST['KPPresensiT']['shift_id']) ? $_POST['KPPresensiT']['shift_id'] : null);
        $modUbahStatus->statuskehadiran_id = $_POST['KPPresensiT']['statuskehadiran_id'];


        $shiftdata = KPShiftM::model()->findByPk($modUbahStatus->shift_id);

        if (isset($shiftdata)) {
          $jam_awal = $shiftdata->shift_jamawal;
          $jam_akhir = $shiftdata->shift_jamakhir;
        }

        if (isset($_POST['KPPresensiT']['masuk'])) {

          if (!empty($_POST['KPPresensiT']['masuk']['presensimasuk_id'])) {
            $presensi = KPPresensiT::model()->findByPk($_POST['KPPresensiT']['masuk']['presensimasuk_id']);
            $presensi->terlambat_mnt = $_POST['KPPresensiT']['masuk']['terlambat_mnt'];
            $presensi->keterangan = $modUbahStatus->keterangan;
            $presensi->no_fingerprint = $modUbahStatus->no_fingerprint;
            $presensi->shift_id = $modUbahStatus->shift_id;
            $presensi->statuskehadiran_id = $modUbahStatus->statuskehadiran_id;
            $presensi->jamkerjamasuk = $modUbahStatus->jamkerjamasuk;
            $presensi->jamkerjapulang = $modUbahStatus->jamkerjapulang;
            $presensi->statuskehadiran_id = $modUbahStatus->statuskehadiran_id;
            $presensi->tglpresensi = date('Y-m-d', strtotime($modUbahStatus->tglpresensi)) . ' ' . $_POST['KPPresensiT']['masuk']['tgl_jammasuk'];
            $presensi->update_time = date('Y-m-d H:i:s');
            $presensi->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $presensi->verifikasi = true;
            $ok = $ok && $presensi->update();
          } else {
            $presensi = new KPPresensiT;
            $presensi->pegawai_id = $modUbahStatus->pegawai_id;
            $presensi->no_fingerprint = $modUbahStatus->no_fingerprint;
            $presensi->terlambat_mnt = $_POST['KPPresensiT']['masuk']['terlambat_mnt'];
            $presensi->keterangan = $modUbahStatus->keterangan;
            $presensi->shift_id = $modUbahStatus->shift_id;
            $presensi->statuskehadiran_id = $modUbahStatus->statuskehadiran_id;
            $presensi->jamkerjamasuk = $modUbahStatus->jamkerjamasuk;
            $presensi->jamkerjapulang = $modUbahStatus->jamkerjapulang;
            $presensi->statuskehadiran_id = $modUbahStatus->statuskehadiran_id;
            $presensi->tglpresensi = date('Y-m-d', strtotime($modUbahStatus->tglpresensi)) . ' ' . $_POST['KPPresensiT']['masuk']['tgl_jammasuk'];
            $presensi->statusscan_id = Params::STATUSSCAN_MASUK;
            $presensi->create_time = date('Y-m-d H:i:s');
            $presensi->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $presensi->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $presensi->isfingerprintscan = false;
            $presensi->verifikasi = true;
            $ok = $ok && $presensi->save();
          }
        }

        if (isset($_POST['KPPresensiT']['pulang'])) {

          if (!empty($_POST['KPPresensiT']['pulang']['presensipulang_id'])) {
            $presensi = KPPresensiT::model()->findByPk($_POST['KPPresensiT']['pulang']['presensipulang_id']);
            $presensi->no_fingerprint = $modUbahStatus->no_fingerprint;
            $presensi->pulangawal_mnt = $_POST['KPPresensiT']['pulang']['pulangawal_mnt'];
            $presensi->keterangan = $modUbahStatus->keterangan;
            $presensi->shift_id = (!empty($modUbahStatus->shift_id) ? $modUbahStatus->shift_id : null);
            $presensi->statuskehadiran_id = $modUbahStatus->statuskehadiran_id;
            $presensi->jamkerjamasuk = $modUbahStatus->jamkerjamasuk;
            $presensi->jamkerjapulang = $modUbahStatus->jamkerjapulang;
            $presensi->statuskehadiran_id = $modUbahStatus->statuskehadiran_id;
            //                                                if(isset($shiftdata)){
            //                                                    if ($shiftdata->shift_bedatanggal == true || ($shiftdata->shift_jamawal > $shiftdata->shift_jamakhir)){
            //							$presensi->tglpresensi = date('Y-m-d', strtotime($modUbahStatus->tglpresensi.' +1 days')).' '.$_POST['KPPresensiT']['pulang']['tgl_jampulang'];
            //                                                    }else{
            //                                                            $presensi->tglpresensi = date('Y-m-d', strtotime($modUbahStatus->tglpresensi)).' '.$_POST['KPPresensiT']['pulang']['tgl_jampulang'];
            //                                                    }
            //                                                }else{
            $presensi->tglpresensi = date('Y-m-d', strtotime($modUbahStatus->tglpresensi)) . ' ' . $_POST['KPPresensiT']['pulang']['tgl_jampulang'];
            //						}
            $presensi->update_time = date('Y-m-d H:i:s');
            $presensi->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $presensi->verifikasi = true;

            $ok = $ok && $presensi->update();
          } else {
            $presensi = new KPPresensiT;
            $presensi->pegawai_id = $modUbahStatus->pegawai_id;
            $presensi->no_fingerprint = $modUbahStatus->no_fingerprint;
            $presensi->pulangawal_mnt = $_POST['KPPresensiT']['pulang']['pulangawal_mnt'];
            $presensi->keterangan = $modUbahStatus->keterangan;
            $presensi->shift_id = (!empty($modUbahStatus->shift_id) ? $modUbahStatus->shift_id : null);
            $presensi->statuskehadiran_id = $modUbahStatus->statuskehadiran_id;
            $presensi->jamkerjamasuk = $modUbahStatus->jamkerjamasuk;
            $presensi->jamkerjapulang = $modUbahStatus->jamkerjapulang;
            $presensi->statuskehadiran_id = $modUbahStatus->statuskehadiran_id;

            //                                                if(isset($shiftdata)){
            //                                                    if ($shiftdata->shift_bedatanggal == true || ($shiftdata->shift_jamawal > $shiftdata->shift_jamakhir)) {
            //                                                        $presensi->tglpresensi = date('Y-m-d', strtotime($modUbahStatus->tglpresensi.' +1 days')).' '.$_POST['KPPresensiT']['pulang']['tgl_jampulang'];
            //                                                    }else{
            //                                                            $presensi->tglpresensi = date('Y-m-d', strtotime($modUbahStatus->tglpresensi)).' '.$_POST['KPPresensiT']['pulang']['tgl_jampulang'];
            //                                                    }
            //                                                }else{
            $presensi->tglpresensi = date('Y-m-d', strtotime($modUbahStatus->tglpresensi)) . ' ' . $_POST['KPPresensiT']['pulang']['tgl_jampulang'];
            //                                                }



            $presensi->statusscan_id = Params::STATUSSCAN_PULANG;
            $presensi->create_time = date('Y-m-d H:i:s');
            $presensi->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $presensi->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $presensi->isfingerprintscan = false;
            $presensi->verifikasi = true;
            $ok = $ok && $presensi->save();
          }
        }

        if ($ok) {
          $transaction->commit();
          $status = true;
          Yii::app()->user->setFlash('success', "Data berhasil disimpan !");
          $this->redirect(array('ubahDataPresensi', 'pegawai_id' => $presensi->pegawai_id, 'tglpresensi' => date('Y-m-d', strtotime($presensi->tglpresensi)), 'status' => $status, 'presensi_id' => $presensi_id));
        } else {
          $status = false;
          Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan');
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $status = false;
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($exc));
      }
    }

    $this->render('_formUbahPresensi', array(
      'modPegawai' => $modPegawai,
      'modPresensiMasuk' => $modPresensiMasuk,
      'modPresensiPulang' => $modPresensiPulang,
      'status' => $status,
      'modUbahStatus' => $modUbahStatus
    ));
  }

  public function actionGenerateHitungPresensi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $shift = isset($_POST['shift']) ? $_POST['shift'] : null;
      $jammasuk = isset($_POST['jammasuk']) ? $_POST['jammasuk'] : null;
      $jampulang = isset($_POST['jampulang']) ? $_POST['jampulang'] : null;

      $modShift = ShiftM::model()->findByPk($shift);

      $jammasuk = strtotime(date("Y-m-d") . ' ' . ($jammasuk));
      $jampulang = strtotime(date("Y-m-d") . ' ' . ($jampulang));

      $awal = date("Y-m-d") . ' ' . ($modShift->shift_jamawal);


      $jamMasukTr = (date("Y-m-d H:i", $jammasuk));
      $jammasukConvert = strtotime($jamMasukTr);
      $awalMenit = strtotime(date("Y-m-d H:i", strtotime($modShift->shift_jamawal)));

      //			$awal = strtotime(date("Y-m-d H:i:s", strtotime($awal.' '.Params::PRESENSI_AWAL_TERLAMBAT)));
      $awal = strtotime(date("Y-m-d H:i:s", strtotime($awal)));

      $akhir = strtotime(date("Y-m-d") . ' ' . ($modShift->shift_jamakhir));
      $dateJam = 0;
			$dateMenit = 0;
			$dateDetik = 0;

			$dateJamPlg = 0;
			$dateMenitPlg = 0;
			$dateDetikPlg = 0;

      if ($jammasukConvert > $awalMenit) {
        // if ($jammasuk > $awal){
        // $terlambat = round(round(abs($jammasuk - $awal) / 60,2));
        // $terlambat = round(round(abs($jammasukConvert - $awalMenit) / 60, 2));
        $diff = abs($jammasuk - $awal);
				$jam   = floor($diff / (60 * 60));
				$menit = $diff - ( $jam * (60 * 60) );
				$detik = $diff % 60;

				$menitreal = floor( $menit / 60 );

				$terlambat = $diff;
				$dateJam = $jam;
				$dateMenit = $menitreal;
				$dateDetik = $detik;
      } else {
        $terlambat = 0;
      }

      if ($jampulang < $akhir) {
        $diff = abs($jampulang - $akhir);
				$jam   = floor($diff / (60 * 60));
				$menit = $diff - ( $jam * (60 * 60) );
				$detik = $diff % 60;
				$menitreal = floor( $menit / 60 );

				$pulangawal = $diff;
				$dateJamPlg = $jam;
				$dateMenitPlg = $menitreal;
				$dateDetikPlg = $detik;
        // $pulangawal = round(round(abs($jampulang - $akhir) / 60, 2));
      } else {
        $pulangawal = 0;
      }



      $data = array(
        'terlambat' => $terlambat,
        'pulangawal' => $pulangawal,
        'jamkerjamasuk' => $modShift->shift_jamawal,
        'jamkerjapulang' => $modShift->shift_jamakhir,
        'selisi_jam' => $dateJam,
				'selisi_menit' => $dateMenit,
				'selisi_detik' => $dateDetik,
				'selisi_jamPlg' => $dateJamPlg,
				'selisi_menitPlg' => $dateMenitPlg,
				'selisi_detikPlg' => $dateDetikPlg,
        'sukses' => 1
      );

      echo json_encode($data);

      Yii::app()->end();
    }
  }

  public function actionCekDataDinas()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
      $tglpresensi = isset($_POST['tglpresensi']) ? MyFormatter::formatDateTimeForDb($_POST['tglpresensi']) : null;

      $peg = PegawaiM::model()->findByPk($pegawai_id);

      $cri = new CDbCriteria();
      $cri->join = " JOIN rencanadiklatdet_t  rdd ON rdd.rencanadiklat_id = t.rencanadiklat_id ";
      $cri->addCondition(" rdd.pegawai_id = '" . $pegawai_id . "' ");
      $cri->addCondition(" '" . $tglpresensi . "' >= rencanadiklat_periode AND '" . $tglpresensi . "' <= rencanadiklat_sampaidgn ");
      $rencana = RencanadiklatT::model()->find($cri);

      if (empty($rencana)) {
        $data['pesan'] = " Pegawai <b>" . $peg->namaLengkap . "</b> tidak memiliki rencana diklat/dinas pada tanggal <b>" . MyFormatter::formatDateTimeForUser($tglpresensi) . "</b>, apakah akan melanjutkan pencatatan presensi?";
      } else {
        $data['pesan'] = '';
      }

      $data['sukses'] = 1;


      echo json_encode($data);

      Yii::app()->end();
    }
  }

  public function actionHapusPresensi()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $ok = 0;
    $msg = "Kehadiran gagal dihapus.";

    if (isset($_POST['hapus_presensi'])) {
      $trans = Yii::app()->db->beginTransaction();

      try {
        $model = new HapuspresensiR();
        $model->attributes = $_POST['hapus_presensi'];
        $model->tgl_presensi = MyFormatter::formatDateTimeForDb($model->tgl_presensi);
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        $model->save();

        if (isset($_POST['hapus_presensi']['presensimasuk_id']) && !empty($_POST['hapus_presensi']['presensimasuk_id'])) {
          PresensiT::model()->deleteByPk($_POST['hapus_presensi']['presensimasuk_id']);
        }
        if (isset($_POST['hapus_presensi']['presensipulang_id']) && !empty($_POST['hapus_presensi']['presensipulang_id'])) {
          PresensiT::model()->deleteByPk($_POST['hapus_presensi']['presensipulang_id']);
        }

        $ok = 1;
        $msg = "Kehadiran berhasil dihapus";

        $trans->commit();
      } catch (Exception $ex) {
        $trans->rollback();
        $ok = 0;
        $msg = "Kehadiran gagal dihapus.<br/>" . $ex->getMessage();
      }
    }

    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg));
  }

  public function actionLoadJamScanPresensi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
      $tglpresensi = isset($_POST['tglpresensi']) ? MyFormatter::formatDateTimeForDb($_POST['tglpresensi']) : null;

      $cri = new CDbCriteria();
      $cri->addCondition('pegawai_id ='.$pegawai_id);
      $cri->addCondition("tglpresensi::date ='".$tglpresensi."'");
      $cri->addCondition('statusscan_id ='.Params::STATUSSCAN_KELUAR);
      $presensi = PresensiT::model()->find($cri);

      $jamscan = "";
      if(!empty($presensi)){
        $jamscan = date('H:i:s',strtotime((string)MyFormatter::formatDateTimeForDb($presensi->tglpresensi)));
      }
      $data['jamscan'] = $jamscan;
      echo json_encode($data);

      Yii::app()->end();
    }
  }
}
