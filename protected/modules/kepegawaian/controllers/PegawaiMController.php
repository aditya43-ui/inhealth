<?php

/**
 * vcontollers utama untuk mengelola menu pegawai
 * 
 * @package application.modules.kepegawaian
 * @subpackage  controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0 
 * @link    <http://piindonesia.co.id>
 */
class PegawaiMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'kepegawaian.views.pegawaiM.';
  public $kategoripegawaiasal = 'RS';
  //		public $path_view = 'kepegawaian.views.pencatatanRiwayat.';

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

  public function actionViewUser($id = '', $sukses = '')
  {
    if ($sukses == 1) :
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    endif;

    $loginpemakai = Yii::app()->user->id;
    $criteria = new CDbCriteria;
    $criteria->addCondition('loginpemakai_id = ' . $loginpemakai);
    $pegawai = LoginpemakaiK::model()->find($criteria);
    if (empty($id)) {
      $id = $pegawai->pegawai_id;
    }
    $this->render(
      $this->path_view . 'viewUser',
      array(
        'model' => $this->loadModel($id)
      )
    );
  }

  public function actionProfilKlinik()
  {
    $loginpemakai_id = Yii::app()->user->id;
    $criteria = new CDbCriteria;
    $criteria->compare('loginpemakai_id', $loginpemakai_id);
    $pegawai = LoginpemakaiK::model()->find($criteria);
    if (empty($idPegawai))
      $idPegawai = $pegawai->pegawai_id;

    $this->render('kepegawaian.views.pegawaiM._viewprofilKlinik', array(
      'model' => $this->loadModel($idPegawai),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */

  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new KPPegawaiM;
    $modRuanganPegawai = new RuanganpegawaiM;
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['KPPegawaiM'])) {
      $model->attributes = $_POST['KPPegawaiM'];
      $model->profilrs_id = 1;
      if ($_POST['caraAmbilPhoto'] == 'file') //Jika User Mengambil photo pegawai dengan cara upload file
      {

        $model->pegawai_aktif = true;
        //   $model->profilrs_id=Params::getDefaultProfilRS();
        $model->photopegawai = CUploadedFile::getInstance($model, 'photopegawai');
        $gambar = $model->photopegawai;
        $random = $model->nomorindukpegawai . '.' . $model->photopegawai->getExtensionName();

        if (!empty($model->photopegawai)) //Klo User Memasukan Logo
        {

          $model->photopegawai = $random; //.$model->photopegawai

          Yii::import("ext.EPhpThumb.EPhpThumb");

          $thumb = new EPhpThumb();
          $thumb->init(); //this is needed

          $fullImgName = $model->photopegawai;
          $fullImgSource = Params::pathPegawaiDirectory() . $fullImgName;
          $fullThumbSource = Params::pathPegawaiTumbsDirectory() . 'kecil_' . $fullImgName;
        }
      }

      if ($model->validate()) {
        if ($model->save()) {
          if (!empty($model->photopegawai)) {
            $gambar->saveAs($fullImgSource);

            $thumb->create($fullImgSource)
              ->resize(200, 200)
              ->save($fullThumbSource);
          }

          if ($model->validate()) {
            if ($model->save()) {
              $jumlahRuanganPegawai = count((array)$_POST['ruangan_id']);
              $pegawai_id = $model->pegawai_id;
              //                            $hapusRuanganPegawai =  RuanganpegawaiM::model()->deleteAll('pegawai_id='.$pegawai_id.'');
              for ($i = 0; $i <= $jumlahRuanganPegawai; $i++) {
                $modRuanganPegawai = new RuanganpegawaiM;
                $modRuanganPegawai->ruangan_id = $_POST['ruangan_id'][$i];
                $modRuanganPegawai->pegawai_id = $pegawai_id;
                $modRuanganPegawai->save();
              }
              Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
              $this->redirect(array('admin', 'id' => $model->pegawai_id));
            }
          }
        }
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model, 'modRuanganPegawai' => $modRuanganPegawai
    ));
  }


  public function actionPencatatanpegawai($pegawai_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pencatatan Pegawai";
    $format = new MyFormatter();
    $model = new KPPegawaiM;
    $modRuanganPegawai = new RuanganpegawaiM;
    $modShiftPegawai = new KPShiftpegawaiM;
    $modKomGajiDet = new KPKomponengajipegawaiM;
    $model->isNewRecord = TRUE;
    
    if (!empty($pegawai_id)) {
      $model = KPPegawaiM::model()->findByPk($pegawai_id);

      $cekPegawaiR = RuanganpegawaiM::model()->findAll('pegawai_id=' . $pegawai_id . '');
      if (isset($cekPegawaiR)) :
        $modRuanganPegawai = $cekPegawaiR;
      endif;

      $cekPegawaiS = KPShiftpegawaiM::model()->findAll('pegawai_id=' . $pegawai_id . '');
      if (isset($cekPegawaiS)) :
        $modShiftPegawai = $cekPegawaiS;
      endif;

      $cekKomGaji = KPKomponengajipegawaiM::model()->findAllByAttributes(array('pegawai_id' => $pegawai_id));

      if (count((array)$cekKomGaji) > 0) {
        $modKomGajiDet = $cekKomGaji;
      }
    }

    if (isset($_POST['KPPegawaiM'])) {
      
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model = new KPPegawaiM;
        $model->attributes = $_POST['KPPegawaiM'];
        if(Yii::app()->user->getState('metode_nokepegawaian') == 'Otomatis Sistem'){
          $model->nomorindukpegawai = MyGenerator::generateNIPOtomatis();
        }
        

        $random = $model->nomorindukpegawai;
        $model->profilrs_id = Params::getDefaultProfilRS();
        $model->tgl_lahirpegawai = $format->formatDateTimeForDb($_POST['KPPegawaiM']['tgl_lahirpegawai']);
        if (isset($model->tglditerima)) {
          $model->tglditerima = $format->formatDateTimeForDb($_POST['KPPegawaiM']['tglditerima']);
        } else {
          $model->tglditerima = date('Y-m-d');
        }
        if (isset($_POST['KPPegawaiM']['tglmasaaktifpeg']) || !empty($_POST['KPPegawaiM']['tglmasaaktifpeg'])) {
          $model->tglmasaaktifpeg = $format->formatDateTimeForDb($_POST['KPPegawaiM']['tglmasaaktifpeg']);
        }

        if (isset($_POST['KPPegawaiM']['tglmasaaktifpeg_sd']) || !empty($_POST['KPPegawaiM']['tglmasaaktifpeg_sd'])) {
          $model->tglmasaaktifpeg_sd = $format->formatDateTimeForDb($_POST['KPPegawaiM']['tglmasaaktifpeg_sd']);
        }

        if (isset($_POST['KPPegawaiM']['tglmasuk_bpjs_ketenagakerjaan']) || !empty($_POST['KPPegawaiM']['tglmasuk_bpjs_ketenagakerjaan'])) {
          $model->tglmasuk_bpjs_ketenagakerjaan = $format->formatDateTimeForDb($_POST['KPPegawaiM']['tglmasuk_bpjs_ketenagakerjaan']);
        }

        if (isset($_POST['KPPegawaiM']['tglkeluar_bpjs_ketenagakerjaan']) || !empty($_POST['KPPegawaiM']['tglkeluar_bpjs_ketenagakerjaan'])) {
          $model->tglkeluar_bpjs_ketenagakerjaan = $format->formatDateTimeForDb($_POST['KPPegawaiM']['tglkeluar_bpjs_ketenagakerjaan']);
        }

        $model->masa_str = isset($model->masa_str) ? $format->formatDateTimeForDb($model->masa_str) : null;
        $model->masa_sip = isset($model->masa_sip) ? $format->formatDateTimeForDb($model->masa_sip) : null;
        $model->masa_tenagasehat = isset($model->masa_tenagasehat) ? $format->formatDateTimeForDb($model->masa_tenagasehat) : null;
        $model->masa_medis = isset($model->masa_medis) ? $format->formatDateTimeForDb($model->masa_medis) : null;
        $model->nominal_sip = !empty($model->nominal_sip) ? $format->formatRupiahForDB($model->nominal_sip) : 0;
        $model->create_time = date('Y-m-d');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->tglterdaftarnpwp = isset($_POST['KPPegawaiM']['tglterdaftarnpwp']) ? $format->formatDateTimeForDb($_POST['KPPegawaiM']['tglterdaftarnpwp']) : null;
        //					$model->gajipokok = 0;
        $model->gajipokok = $_POST['KPPegawaiM']['gajipokok'];
        //					var_dump($_POST['KPPegawaiM']['gajipokok']); die();

        //					echo "<pre>";
        //					print_r($model->attributes);exit;
        if ($_POST['caraAmbilPhoto'] == 'file') //Jika User Mengambil photo pegawai dengan cara upload file
        {
          $model->pegawai_aktif = true;
          $model->photopegawai = CUploadedFile::getInstance($model, 'photopegawai');
          $gambar = $model->photopegawai;
          if (!empty($model->photopegawai)) //Klo User Memasukan Logo
          {

            $model->photopegawai = $random . '.' . $model->photopegawai->getExtensionName(); //.$model->photopegawai

            Yii::import("ext.EPhpThumb.EPhpThumb");

            $thumb = new EPhpThumb();
            $thumb->init(); //this is needed

            $fullImgName = $model->photopegawai;
            $fullImgSource = Params::pathPegawaiDirectory() . $fullImgName;
            $fullThumbSource = Params::pathPegawaiTumbsDirectory() . 'kecil_' . $fullImgName;
            $model->save();
            $gambar->saveAs($fullImgSource);
            $thumb->create($fullImgSource)
              ->resize(200, 200)
              ->save($fullThumbSource);

            $model->isNewRecord = FALSE;
          }
        } else {
          $model->photopegawai = $_POST['KPPegawaiM']['tempPhoto'];
          if ($model->validate()) {

            $model->save();
            $model->isNewRecord = FALSE;
          } else {
            unlink(Params::pathPegawaiDirectory() . $_POST['KPPegawaiM']['tempPhoto']);
            unlink(Params::pathPegawaiTumbsDirectory() . $_POST['KPPegawaiM']['tempPhoto']);
          }
        }


        $model->gajipokok = $_POST['KPPegawaiM']['gajipokok'];


        $ruanganPegawai = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;

        /*$pegawai_id=$model->pegawai_id;

					if($pegawai_id!=null){
					  $hapusRuanganPegawai=  RuanganpegawaiM::model()->deleteAll('pegawai_id='.$pegawai_id.''); 
					}

					if (isset($ruanganPegawai)){                                            
						foreach($ruanganPegawai as $i => $rp)
						{                                                    
							$modRuanganPegawai = new RuanganpegawaiM;
														var_dump($pegawai_id);
							$modRuanganPegawai->ruangan_id=$rp[$i];
							$modRuanganPegawai->pegawai_id=$pegawai_id;
							$modRuanganPegawai->save();
						}
					}
										var_dump($ruanganPegawai);die;*/
        if (!empty($model->gelardepan)) {
          $gelardepan = LookupM::model()->findByPk($model->gelardepan);
          $model->gelardepan = $gelardepan->lookup_name;
        }
        $model->jenistenagamedis_id = !empty($_POST['KPPegawaiM']['jenistenagamedis_id']) ? $_POST['KPPegawaiM']['jenistenagamedis_id'] : null;
        $model->garis_latitude = !empty($_POST['KPPegawaiM']['garis_latitude']) ? $_POST['KPPegawaiM']['garis_latitude'] : null;
        $model->garis_longitude = !empty($_POST['KPPegawaiM']['garis_longitude']) ? $_POST['KPPegawaiM']['garis_longitude'] : null;
        $model->tglmasaaktifpeg = !empty($_POST['KPPegawaiM']['tglmasaaktifpeg']) ? MyFormatter::formatDateTimeForDb($_POST['KPPegawaiM']['tglmasaaktifpeg']) : null;
        $model->tglmasaaktifpeg_sd = !empty($_POST['KPPegawaiM']['tglmasaaktifpeg_sd']) ? MyFormatter::formatDateTimeForDb($_POST['KPPegawaiM']['tglmasaaktifpeg_sd']) : null;

        $model->file_kontrak = CUploadedFile::getInstance($model, 'file_kontrak');

        if (!empty($model->file_kontrak)) {
          $filePDF = $model->file_kontrak;

          $fileName = $model->file_kontrak;
          $filePath = Params::pathPegawaiFileDirectory() . $fileName;


          $filePDF->saveAs($filePath);
        }

        $shiftPegawai = isset($_POST['shift_id']) ? $_POST['shift_id'] : null;


        if ($model->save()) {
          $pegawai_id = $model->pegawai_id;

          if ($pegawai_id != null) {
            $hapusRuanganPegawai =  RuanganpegawaiM::model()->deleteAll('pegawai_id=' . $pegawai_id . '');
          }

          if (isset($ruanganPegawai)) {
            /*foreach($ruanganPegawai as $i => $rp)
							{                                                    
									$modRuanganPegawai = new RuanganpegawaiM;

									$modRuanganPegawai->ruangan_id=$rp[$i];
									$modRuanganPegawai->pegawai_id=$pegawai_id;
									$modRuanganPegawai->save();
							}*/
            for ($i = 0; $i < count((array)$ruanganPegawai); $i++) {
              $modRuanganPegawai = new RuanganpegawaiM;
              $modRuanganPegawai->ruangan_id = $_POST['ruangan_id'][$i];
              $modRuanganPegawai->pegawai_id = $pegawai_id;
              $modRuanganPegawai->save();
            }
          }

          if ($pegawai_id != null) {
            $hapusShiftPegawai = KPShiftpegawaiM::model()->deleteAll('pegawai_id=' . $pegawai_id . '');
          }

          if (isset($shiftPegawai)) {
            for ($i = 0; $i < count((array)$shiftPegawai); $i++) {
              $modShiftPegawai = new KPShiftpegawaiM;
              $modShiftPegawai->shift_id = $_POST['shift_id'][$i];
              $modShiftPegawai->pegawai_id = $pegawai_id;
              $modShiftPegawai->save();
            }
          }

          //var_dump($_POST['KPKomponengajipegawaiM']);
          if (isset($_POST['KPKomponengajipegawaiM'])) {
            foreach ($_POST['KPKomponengajipegawaiM'] as $iv => $value) {
              $modKomGajiDet = new KPKomponengajipegawaiM;
              $modKomGajiDet->attributes = $value;
              $modKomGajiDet->pegawai_id = $pegawai_id;
              $modKomGajiDet->save();

              //var_dump($modKomGajiDet->attributes);
            }
          }

          if (!empty($_POST['Tanggunganbpjs'])) {
            foreach ($_POST['Tanggunganbpjs'] as $dataTanggungan) {
              if(!empty($dataTanggungan['nourutkel']) && !empty($dataTanggungan['hubkeluarga']) && !empty($dataTanggungan['susunankel_nama']) && !empty($dataTanggungan['susunankel_jk'])  && !empty($dataTanggungan['nopesertabpjs'])){
                $modSunKel = new SusunankelM();
                $modSunKel->attributes = $dataTanggungan;
                $modSunKel->pegawai_id = $pegawai_id;
                $modSunKel->save();
              }
            }
          }
          

          $this->notifPegawaiBaru($model);
//          echo "OK"; die;            
          $transaction->commit();
          $model->isNewRecord = FALSE;
          Yii::app()->user->setFlash('success', 'Data ' . $model->nama_lengkap . ' berhasil disimpan.');
          $this->redirect(array('Pencatatanpegawai', 'pegawai_id' => $model->pegawai_id));
          //                                $modRuanganPegawai = new RuanganpegawaiM;
          //                                 $model=new KPPegawaiM;
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Gagal Disimpan.");
        }
      } catch (Exception $e) {
//          var_dump($e->getMessage(), $e->getTrace()); die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pencatatan pegawai gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'pencatatanpegawai', array(
      'model' => $model, 'modRuanganPegawai' => $modRuanganPegawai, 'format' => $format, 'modKomGajiDet' => $modKomGajiDet,
      'modShiftPegawai' => $modShiftPegawai
    ));
  }


  // RND-4450
  //DIGANTIKAN DENGAN : kepegawaian/pencatatanRiwayat/index
  /* ========================= Pencatatan riwayat ============================================== */
  //                  public function actionPencatatanriwayat($id = null){
  //                     $modPendidikanpegawai = new KPPendidikanpegawaiR;
  //                     $modPegawaidiklat = new KPPegawaidiklatT;
  //                     $modPengalamankerja = new KPPengalamankerjaR;
  //                     $modPegawaijabatan = new KPPegawaijabatanR;
  //                     $modPegmutasi = new KPPegmutasiR;
  //                     $modPegawaicuti = new KPPegawaicutiT;
  //                     $modIzintugasbelajar = new KPIzintugasbelajarR;
  //                     $modHukdisiplin = new KPHukdisiplinR;
  //                     $detailPengalamankerja = array();
  //                     $detailPegawaidiklat = array();
  //                     $model = new KPPegawaiM;

  //                     if (!empty($id)) {
  //                         $model = KPPegawaiM::model()->findByPk($id);
  //                         $detailPegawaidiklat = KPPegawaidiklatT::model()->findAllByAttributes(
  //                             array('pegawai_id'=>$id)
  //                         );
  //                         $detailPengalamankerja = KPPengalamankerjaR::model()->findAllByAttributes(
  //                             array('pegawai_id'=>$id)
  //                         );
  //                     }

  //                     if (isset($_POST['KPPegawaiM'])) {
  //                         $model->attributes = $_POST['KPPegawaiM'];
  //                         $model->nama_pegawai = $_POST['namapegawai'];
  //                         $model->pegawai_id = $_POST['KPPegawaiM']['pegawai_id'];
  //                         $transaction = Yii::app()->db->beginTransaction();
  // /* ========================= Proses simpan Pendidikan pegawai===================================== */
  // //                    if (Yii::app()->request->isAjaxRequest) {
  //                         if (isset($_POST['submitpendidikan'])) {
  //                             $jmlhsavependidikan = 0;
  //                             foreach ($_POST['KPPendidikanpegawaiR'] as $i=>$row)
  //                             {
  //                                 $modPendidikanpegawai = new KPPendidikanpegawaiR;
  //                                 $modPendidikanpegawai->pegawai_id = $_POST['KPPegawaiM']['pegawai_id'];
  //                                 $modPendidikanpegawai->attributes = $row;
  //                                 if (empty($row['tglmasuk'])) {
  //                                     $modPendidikanpegawai->tglmasuk = null;
  //                                 }
  //                                 if (empty($row['tgl_ijazah_sert'])) {
  //                                     $modPendidikanpegawai->tgl_ijazah_sert = null;
  //                                 }
  //                                 $modPendidikanpegawai->create_time = date('Y-m-d');
  //                                 $modPendidikanpegawai->jenispendidikan = $_POST['KPPegawaiM']['jenispendidikan'];
  //                                 $modPendidikanpegawai->create_loginpemakai_id = Yii::app()->user->id;
  //                                 $modPendidikanpegawai->create_ruangan = Yii::app()->user->ruangan_id;
  //                                 if ($modPendidikanpegawai->validate()) {
  //                                     if ($modPendidikanpegawai->save()) {
  //                                         $jmlhsavependidikan++;
  //                                     }
  //                                 }
  //                             }
  //                           if ($jmlhsavependidikan==count((array)$_POST['KPPendidikanpegawaiR'])) {
  //                               $transaction->commit();
  //                               Yii::app()->user->setFlash('success','<strong>Berhasil </strong> Data berhasil disimpan');
  //                               $modPendidikanpegawai->unsetAttributes();
  //                           } else {
  //                               $transaction->rollback();
  //                               Yii::app()->user->setFlash('error','<strong>Gagal</strong> Data gagal disimpan');
  //                           }
  //                         }
  // /* ========================= Akhir simpan Pendidikan pegawai===================================== */
  // /* ========================= Proses simpan Pegawai diklat======================================= */
  //                         else if (isset($_POST['submitdiklat'])){
  //                             $details = $this->validasiTabularDiklat($_POST['KPPegawaidiklatT'], $model);
  //                             $jumlah = count((array)$details);
  //                             $tersimpan = 0;
  //                             foreach ($details as $i=>$row){
  //                                 $pegawaidiklat_lamanyasatuan = $_POST['KPPegawaidiklatT'][$i]['pegawaidiklat_lamanyasatuan'];
  //                                 $row->pegawaidiklat_lamanya = $row['pegawaidiklat_lamanya'] .' '. $pegawaidiklat_lamanyasatuan;
  //                                 $row->create_loginpemakai_id = Yii::app()->user->id;
  //                                 $row->create_ruangan = Yii::app()->user->ruangan_id;
  //                                 $row->pegawaidiklat_tahun = date('Y-m-d H:i:s');
  //                                 if($row->save()){
  //                                     $tersimpan++;
  //                                 }
  //                             }
  //                             if (($tersimpan > 0) && ($tersimpan == $jumlah)){
  //                                     $transaction->commit();
  //                                     Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
  //                                     $module = '/'.$this->module->id.'/';
  //                                     $id_pegawai = (is_null($id) ? '' : '&id='.$id);
  //                                     $urlDiklat = $module.'PegawaiM/Pencatatanriwayat'.$id_pegawai;
  //                                     $this->redirect(array($urlDiklat));
  //                             }else{
  //                                 $transaction->rollback();
  //                                 Yii::app()->user->setFlash('error','<strong>Gagal</strong> Data gagal disimpan');
  //                             }
  //                         }

  // /* ========================= Akhir simpan Pegawai diklat===================================== */
  // /* ========================= Proses simpan Pengalaman kerja===================================== */
  //                         else if (isset($_POST['submitPengalamankerja'])){
  //                             $jmlhsavepengalamankerja = 0;
  //                             $submitPengalamankerja = $this->validasiTabularPengalamanKerja($_POST['KPPengalamankerjaR'], $model);
  //                             $jumlah = count((array)$submitPengalamankerja);
  //                             $tersimpan = 0;
  //                             foreach ($submitPengalamankerja as $i=>$row){
  //                                 if (empty($row['tglmasuk'])) {
  //                                     $row->tglmasuk = null;
  //                                 }
  //                                 if (empty($row['tglkeluar'])) {
  //                                     $row->tglkeluar = null;
  //                                 }
  //                                 $row->create_time = date('Y-m-d');
  //                                 $row->create_loginpemakai_id = Yii::app()->user->id;
  //                                 $row->create_ruangan = Yii::app()->user->ruangan_id;                                
  //                                 if($row->save()){
  //                                     $tersimpan++;
  //                                 }
  //                             }
  //                             if (($tersimpan > 0) && ($tersimpan == $jumlah)){
  //                                     $transaction->commit();
  //                                     Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
  //                                     $module = '/'.$this->module->id.'/';
  //                                     $id_pegawai = (is_null($id) ? '' : '&id='.$id);
  //                                     $urlDiklat = $module.'PegawaiM/Pencatatanriwayat'.$id_pegawai;
  //                                     $this->redirect(array($urlDiklat));
  //                             }else{
  //                                 $transaction->rollback();
  //                                 Yii::app()->user->setFlash('error','<strong>Gagal</strong> Data gagal disimpan');
  //                             }
  //                         }
  // /* ========================= Akhir simpan Pengalaman kerja===================================== */
  // /* ========================= Proses simpan Pegawai jabatan ==================================== */
  //                         else if (isset($_POST['submitPegawaijabatan'])) {
  //                             $modPegawaijabatan = new KPPegawaijabatanR;
  //                             $modPegawaijabatan->pegawai_id = $_POST['KPPegawaiM']['pegawai_id'];
  //                             $modPegawaijabatan->attributes = $_POST['KPPegawaijabatanR'];
  //                             if (empty($_POST['KPPegawaijabatanR']['tglditetapkanjabatan'])) {
  //                                 $modPegawaijabatan->tglditetapkanjabatan = null;
  //                             }
  //                             if (empty($_POST['KPPegawaijabatanR']['tmtjabatan'])) {
  //                                 $modPegawaijabatan->tmtjabatan = null;
  //                             }
  //                             if (empty($_POST['KPPegawaijabatanR']['tglakhirjabatan'])) {
  //                                 $modPegawaijabatan->tglakhirjabatan = null;
  //                             }
  //                             $modPegawaijabatan->create_time = date('Ymd');
  //                             $modPegawaijabatan->create_loginpemakai_id = Yii::app()->user->id;
  //                             $modPegawaijabatan->create_ruangan = Yii::app()->user->ruangan_id;
  //                             if ($modPegawaijabatan->validate()) {
  //                                 if ($modPegawaijabatan->save()) {
  //                                     $transaction->commit();
  //                                     Yii::app()->user->setFlash('success','<strong>Berhasil </strong> Data berhasil disimpan');
  //                                     $modPegawaijabatan->unsetAttributes();
  //                                 } else {
  //                                     $transaction->rollback();
  //                                     Yii::app()->user->setFlash('error','<strong>Gagal </strong> Data gagal disimpan');
  //                                 }
  //                             }
  //                         }
  // /* ========================= Akhir simpan Pegawai jabatan ===================================== */
  // /* ========================= Proses simpan Pegawai mutasi =====================================*/
  //                         else if (isset($_POST['submitPegmutasi'])) {
  //                             $modPegmutasi = new KPPegmutasiR;
  //                             $modPegmutasi->attributes = $_POST['KPPegmutasiR'];
  //                             if (empty($_POST['KPPegmutasiR']['tglsk'])) {
  //                                 $modPegmutasi->tglsk = null;
  //                             }
  //                             if (empty($_POST['KPPegmutasiR']['tmtsk'])) {
  //                                 $modPegmutasi->tmtsk = null;
  //                             }
  //                             $modPegmutasi->pegawai_id = $_POST['KPPegawaiM']['pegawai_id'];
  //                             if ($modPegmutasi->validate()) {
  //                                 if ($modPegmutasi->save()) {
  //                                     $transaction->commit();
  //                                     Yii::app()->user->setFlash('success','<strong>Berhasil </strong> Data berhasil disimpan');
  //                                     $modPegmutasi->unsetAttributes();
  //                                 } else {
  //                                     $transaction->rollback();
  //                                     Yii::app()->user->setFlash('error','<strong>Gagal </strong> Data gagal disimpan');
  //                                 }
  //                             }
  //                         }
  // /* ========================= Akhir simpan Pegawai mutasi =====================================*/
  // /* ========================= Proses simpan Pegawai cuti ====================================== */
  //                         else if (isset($_POST['submitPegawaicuti'])) {
  //                             $modPegawaicuti = new KPPegawaicutiT;
  //                             $modPegawaicuti->pegawai_id = $_POST['KPPegawaiM']['pegawai_id'];
  //                             $modPegawaicuti->attributes = $_POST['KPPegawaicutiT'];
  //                             if (empty($_POST['KPPegawaicutiT']['tglakhircuti'])) {
  //                                 $modPegawaicuti->tglakhircuti = null;
  //                             }
  //                             if ($modPegawaicuti->validate()) {
  //                                 if ($modPegawaicuti->save()) {
  //                                     $transaction->commit();
  //                                     Yii::app()->user->setFlash('success','<strong>Berhasil </strong> Data berhasil disimpan');
  //                                     $modPegawaicuti->unsetAttributes();
  //                                 } else {
  //                                     $transaction->rollback();
  //                                     Yii::app()->user->setFlash('error','<strong>Gagal </strong> Data gagal disimpan');
  //                                 }
  //                             }
  //                         }
  // /* ========================= Akhir simpan Pegawai cuti ======================================= */
  // /* ========================= Proses simpan Izin tugas belajar =================================== */
  //                         else if (isset($_POST['submitIzintugasbelajar'])) {
  //                             $modIzintugasbelajar = new KPIzintugasbelajarR;
  //                             $modIzintugasbelajar->pegawai_id = $_POST['KPPegawaiM']['pegawai_id'];
  //                             $modIzintugasbelajar->attributes = $_POST['KPIzintugasbelajarR'];
  //                             if (empty($_POST['KPIzintugasbelajarR']['tglditetapkan'])) {
  //                                 $modIzintugasbelajar->tglditetapkan = null;
  //                             }
  //                             $modIzintugasbelajar->create_time = date('Ymd');
  //                             $modIzintugasbelajar->create_loginpemakai_id = Yii::app()->user->id;
  //                             $modIzintugasbelajar->create_ruangan = Yii::app()->user->ruangan_id;
  //                             if ($modIzintugasbelajar->validate()) {
  //                                 if ($modIzintugasbelajar->save()) {
  //                                     $transaction->commit();
  //                                     Yii::app()->user->setFlash('success','<strong>Berhasil </strong> Data berhasil disimpan');
  //                                     $modIzintugasbelajar->unsetAttributes();
  //                                 } else {
  //                                     $transaction->rollback();
  //                                     Yii::app()->user->setFlash('error','<strong>Gagal </strong> Data gagal disimpan');
  //                                 }
  //                             }
  //                         }
  // /* ========================= Akhir simpan izin tugas belajar ==================================== */
  // /* ========================= Proses simpan Hukuman disiplin =====================================*/
  //                         else if (isset($_POST['submitHukdisiplin'])) {
  //                             $modHukdisiplin = new KPHukdisiplinR;
  //                             $modHukdisiplin->pegawai_id = $_POST['KPPegawaiM']['pegawai_id'];
  //                             $modHukdisiplin->attributes = $_POST['KPHukdisiplinR'];
  //                             $modHukdisiplin->create_time = date('Ymd');
  //                             $modHukdisiplin->create_loginpemakai_id = Yii::app()->user->id;
  //                             $modHukdisiplin->create_ruangan = Yii::app()->user->ruangan_id;
  //                             if ($modHukdisiplin->validate()) {
  //                                 if ($modHukdisiplin->save()) {
  //                                     $transaction->commit();
  //                                     Yii::app()->user->setFlash('success','<strong>Berhasil </strong> Data berhasil disimpan');
  //                                     $modHukdisiplin->unsetAttributes();
  //                                 } else {
  //                                     $transaction->rollback();
  //                                     Yii::app()->user->setFlash('error','<strong>Gagal </strong> Data gagal disimpan');
  //                                 }
  //                             }
  //                         }
  // //                    }
  // /* ========================= Akhir simpan Hukuman disiplin =====================================*/
  //                     }
  //                     $this->render(
  //                             'pencatatanriwayat'
  //                             ,array(
  //                                 'model'=>$model,
  //                                 'modPendidikanpegawai'=>$modPendidikanpegawai,
  //                                 'modPegawaidiklat'=>$modPegawaidiklat,
  //                                 'modPengalamankerja'=>$modPengalamankerja,
  //                                 'modPegawaijabatan'=>$modPegawaijabatan,
  //                                 'modPegmutasi'=>$modPegmutasi,
  //                                 'modPegawaicuti'=>$modPegawaicuti,
  //                                 'modIzintugasbelajar'=>$modIzintugasbelajar,
  //                                 'modHukdisiplin'=>$modHukdisiplin,
  //                                 'namapegawai'=> (isset($model->nama_pegawai) ? $model->nama_pegawai : ''),
  //                                 'detailPegawaidiklat'=>$detailPegawaidiklat,
  //                                 'detailPengalamankerja'=>$detailPengalamankerja
  //                             )
  //                     );
  //                 }
  /* ======================= Akhir Pencatatan riwayat ============================================== */

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);
    $model->gajipokok = MyFormatter::formatNumberForPrint($model->gajipokok);
    $model->nominal_sip = MyFormatter::formatNumberForPrint($model->nominal_sip);
    $modRuanganPegawai = RuanganpegawaiM::model()->findAll('pegawai_id=' . $id . '');
    $modShiftPegawai =  KPShiftpegawaiM::model()->findAll('pegawai_id=' . $id . '');
    $temLogo = $model->photopegawai;
    $format = new MyFormatter();

    if (!empty($model->ptkp_id)) {
      $modPtkp = PtkpM::model()->findByPk($model->ptkp_id);
      if (isset($modPtkp)) {
        $model->ptkp_nama = $modPtkp->kodeptkp . '/' . $modPtkp->jmltanggunan;
      }
    }

    //var_dump(count((array)$modShiftPegawai));die;

    $modKomGajiDet = new KPKomponengajipegawaiM;

    $cekKomGaji = KPKomponengajipegawaiM::model()->findAllByAttributes(array('pegawai_id' => $id));

    if (count((array)$cekKomGaji) > 0) {
      $modKomGajiDet = $cekKomGaji;
    }

    if (isset($_POST['KPPegawaiM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['KPPegawaiM'];
        $random = $model->nomorindukpegawai;
        $model->profilrs_id = Params::getDefaultProfilRS();
        $model->masa_str = isset($model->masa_str) ? $format->formatDateTimeForDb($model->masa_str) : null;
        $model->masa_sip = isset($model->masa_sip) ? $format->formatDateTimeForDb($model->masa_sip) : null;
        $model->masa_tenagasehat = isset($model->masa_tenagasehat) ? $format->formatDateTimeForDb($model->masa_tenagasehat) : null;
        $model->masa_medis = isset($model->masa_medis) ? $format->formatDateTimeForDb($model->masa_medis) : null;
        $model->nominal_sip = !empty($model->nominal_sip) ? $format->formatRupiahForDB($model->nominal_sip) : 0;
        $model->update_time = date('Y-m-d');
        $model->update_loginpemakai_id = Yii::app()->user->id;
        if (!empty($_POST['KPPegawaiM']['tgl_lahirpegawai'])) {
          $model->tgl_lahirpegawai = $format->formatDateTimeForDb($model->tgl_lahirpegawai);
        } else {
          $model->tgl_lahirpegawai = null;
        }

        if (!empty($_POST['KPPegawaiM']['tglditerima'])) {
          $model->tglditerima = $format->formatDateTimeForDb($model->tglditerima);
        } else {
          $model->tglditerima = null;
        }

        $model->tglterdaftarnpwp = !empty($_POST['KPPegawaiM']['tglterdaftarnpwp']) ? $format->formatDateTimeForDb($_POST['KPPegawaiM']['tglterdaftarnpwp']) : null;

        // $model->pegawai_aktif=true;
        $model->tglmasuk_bpjs_ketenagakerjaan = empty($model->tglmasuk_bpjs_ketenagakerjaan) ? null : $model->tglmasuk_bpjs_ketenagakerjaan;
        $model->tglkeluar_bpjs_ketenagakerjaan = empty($model->tglkeluar_bpjs_ketenagakerjaan) ? null : $model->tglkeluar_bpjs_ketenagakerjaan;
        $model->photopegawai = CUploadedFile::getInstance($model, 'photopegawai');
        $gambar = $model->photopegawai;
        if (isset($model->photopegawai)) {
          if ($_POST['caraAmbilPhoto'] == 'file') //Jika User Mengambil photo pegawai dengan cara upload file
          {
            if (!empty($model->photopegawai)) //Klo User Memasukan Logo
            {
              $model->photopegawai = $random . '.' . $model->photopegawai->getExtensionName(); //.$model->photopegawai
              Yii::import("ext.EPhpThumb.EPhpThumb");
              $thumb = new EPhpThumb();
              $thumb->init(); //this is needed
              $fullImgName = $model->photopegawai;
              $fullImgSource = Params::pathPegawaiDirectory() . $fullImgName;
              $fullThumbSource = Params::pathPegawaiTumbsDirectory() . 'kecil_' . $fullImgName;
              //                                    if($model->save())

              //                                                                var_dump($model->attributes); die;
              if ($model->update()) {
                if (!empty($temLogo)) {
                  if (file_exists(Params::pathPegawaiDirectory() . $temLogo)) {
                    unlink(Params::pathPegawaiDirectory() . $temLogo);
                  }
                  if (file_exists(Params::pathIconModulThumbsDirectory() . 'kecil_' . $temLogo)) {
                    unlink(Params::pathIconModulThumbsDirectory() . 'kecil_' . $temLogo);
                  }
                }
                $gambar->saveAs($fullImgSource);
                $thumb->create($fullImgSource)
                  ->resize(200, 200)
                  ->save($fullThumbSource);
              } else {
                Yii::app()->user->setFlash('error', 'Data <strong>Gagal!</strong>  disimpan.');
              }
            } else {
              $model->photopegawai = $model->photopegawai;
            }
          } else {
            ////Jika user Memasukan Photo Dari Webcam
            if (!empty($temLogo)) {
              if (!empty($temLogo)) {
                if (file_exists(Params::pathPegawaiDirectory() . $temLogo)) {
                  unlink(Params::pathPegawaiDirectory() . $temLogo);
                }
                if (file_exists(Params::pathIconModulThumbsDirectory() . 'kecil_' . $temLogo)) {
                  unlink(Params::pathIconModulThumbsDirectory() . 'kecil_' . $temLogo);
                }
              }
            }
            $model->update();
          }
        } else {
          $model->photopegawai = $temLogo;
        }

        if (!empty($_POST['ruangan_id']))
          $jumlahRuanganPegawai = count((array)$_POST['ruangan_id']);
        else
          $jumlahRuanganPegawai = 0;
        $pegawai_id = $model->pegawai_id;
        $hapusRuanganPegawai =  RuanganpegawaiM::model()->deleteAll('pegawai_id=' . $pegawai_id . '');
        for ($i = 0; $i < $jumlahRuanganPegawai; $i++) {
          $modRuanganPegawai = new RuanganpegawaiM;
          $modRuanganPegawai->ruangan_id = isset($_POST['ruangan_id'][$i]) ? $_POST['ruangan_id'][$i] : null;
          $modRuanganPegawai->pegawai_id = $pegawai_id;
          $modRuanganPegawai->save();
        }
        //var_dump($_POST['deletekomponen']);die;
        if (isset($_POST['KPKomponengajipegawaiM'])) {

          if (isset($_POST['deletekomponen'])) {
            foreach ($_POST['deletekomponen'] as $d => $valdel) {
              if (!empty($valdel)) {
                $delkom = KPKomponengajipegawaiM::model()->deleteByPk($valdel);
              }
            }
          }

          foreach ($_POST['KPKomponengajipegawaiM'] as $iv => $value) {

            if (empty($value['komponengajipegawai_id'])) {
              $modKomGajiDet = new KPKomponengajipegawaiM;
              $modKomGajiDet->attributes = $value;
              $modKomGajiDet->pegawai_id = $pegawai_id;
              $modKomGajiDet->save();
            } else {
              $modKomGajiDet = KPKomponengajipegawaiM::model()->findByPk($value['komponengajipegawai_id']);
              $modKomGajiDet->attributes = $value;
              $modKomGajiDet->save();
            }

            //var_dump($modKomGajiDet->attributes);
          }
        }

        if (!empty($_POST['shift_id'])) {
          $jumlahShiftPegawai = count((array)$_POST['shift_id']);
        } else {
          $jumlahShiftPegawai = 0;
        }

        $pegawai_id = $model->pegawai_id;
        $hapusShiftPegawai = KPShiftpegawaiM::model()->deleteAll('pegawai_id=' . $pegawai_id . '');
        for ($i = 0; $i < $jumlahShiftPegawai; $i++) {
          $modShiftPegawai = new KPShiftpegawaiM;
          $modShiftPegawai->shift_id = isset($_POST['shift_id'][$i]) ? $_POST['shift_id'][$i] : null;
          $modShiftPegawai->pegawai_id = $pegawai_id;
          $modShiftPegawai->save();
        }
        // $gelardepan = LookupM::model()->findByPk($model->gelardepan);
        // $model->gelardepan = $gelardepan->lookup_name;

        // var_dump($model->attributes); die;

        $model->update(); // update data 
        $transaction->commit();
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan !');
        $this->redirect(array('Informasi', 'id' => $model->pegawai_id));
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model, 'modRuanganPegawai' => $modRuanganPegawai, 'format' => $format,
      'modKomGajiDet' => $modKomGajiDet,
      'modShiftPegawai' => $modShiftPegawai
    ));
  }

  public function actionUpdateUser($id = '')
  {
    $loginpemakai = Yii::app()->user->id;
    $criteria = new CDbCriteria;
    $criteria->addCondition('loginpemakai_id = ' . $loginpemakai);
    $pegawai = LoginpemakaiK::model()->find($criteria);
    if (empty($id)) {
      $id = $pegawai->pegawai_id;
    }
    $model = $this->loadModel($id);
    $modRuanganPegawai = RuanganpegawaiM::model()->findAll('pegawai_id=' . $id . '');
    $temLogo = $model->photopegawai;
    $format = new MyFormatter();
    if (isset($_POST['KPPegawaiM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $random = $model->nomorindukpegawai;
        $model->attributes = $_POST['KPPegawaiM'];
        $model->profilrs_id = Params::getDefaultProfilRS();
        $model->masa_str = isset($model->masa_str) ? $format->formatDateTimeForDb($model->masa_str) : null;
        $model->masa_sip = isset($model->masa_sip) ? $format->formatDateTimeForDb($model->masa_sip) : null;
        $model->masa_tenagasehat = isset($model->masa_tenagasehat) ? $format->formatDateTimeForDb($model->masa_tenagasehat) : null;
        $model->masa_medis = isset($model->masa_medis) ? $format->formatDateTimeForDb($model->masa_medis) : null;
        $model->update_time = date('Y-m-d');
        $model->update_loginpemakai_id = Yii::app()->user->id;
        if (!empty($_POST['KPPegawaiM']['tgl_lahirpegawai'])) {
          $model->tgl_lahirpegawai = $format->formatDateTimeForDb($model->tgl_lahirpegawai);
        } else {
          $model->tgl_lahirpegawai = null;
        }

        if (!empty($_POST['KPPegawaiM']['tglditerima'])) {
          $model->tglditerima = $format->formatDateTimeForDb($model->tglditerima);
        } else {
          $model->tglditerima = null;
        }

        $model->pegawai_aktif = true;
        $model->photopegawai = CUploadedFile::getInstance($model, 'photopegawai');
        $gambar = $model->photopegawai;
        if (isset($model->photopegawai)) {
          if ($_POST['caraAmbilPhoto'] == 'file') //Jika User Mengambil photo pegawai dengan cara upload file
          {
            if (!empty($model->photopegawai)) //Klo User Memasukan Logo
            {
              $model->photopegawai = $random . '.' . $model->photopegawai->getExtensionName(); //.$model->photopegawai
              Yii::import("ext.EPhpThumb.EPhpThumb");
              $thumb = new EPhpThumb();
              $thumb->init(); //this is needed
              $fullImgName = $model->photopegawai;
              $fullImgSource = Params::pathPegawaiDirectory() . $fullImgName;
              $fullThumbSource = Params::pathPegawaiTumbsDirectory() . 'kecil_' . $fullImgName;
              //                                    if($model->save())
              if ($model->update()) {
                if (!empty($temLogo)) {
                  if (file_exists(Params::pathPegawaiDirectory() . $temLogo)) {
                    unlink(Params::pathPegawaiDirectory() . $temLogo);
                  }
                  if (file_exists(Params::pathIconModulThumbsDirectory() . 'kecil_' . $temLogo)) {
                    unlink(Params::pathIconModulThumbsDirectory() . 'kecil_' . $temLogo);
                  }
                }
                $gambar->saveAs($fullImgSource);
                $thumb->create($fullImgSource)
                  ->resize(200, 200)
                  ->save($fullThumbSource);
              } else {
                Yii::app()->user->setFlash('error', 'Data <strong>Gagal!</strong>  disimpan.');
              }
            } else {
              $model->photopegawai = $model->photopegawai;
            }
          } else {
            ////Jika user Memasukan Photo Dari Webcam
            if (!empty($temLogo)) {
              if (!empty($temLogo)) {
                if (file_exists(Params::pathPegawaiDirectory() . $temLogo)) {
                  unlink(Params::pathPegawaiDirectory() . $temLogo);
                }
                if (file_exists(Params::pathIconModulThumbsDirectory() . 'kecil_' . $temLogo)) {
                  unlink(Params::pathIconModulThumbsDirectory() . 'kecil_' . $temLogo);
                }
              }
            }
            $model->update();
          }
        } else {
          $model->photopegawai = $temLogo;
        }

        /*if(!empty($_POST['ruangan_id']))
						$jumlahRuanganPegawai = count((array)$_POST['ruangan_id']);
					else
						$jumlahRuanganPegawai = 0;
						$pegawai_id=$model->pegawai_id;
						$hapusRuanganPegawai=  RuanganpegawaiM::model()->deleteAll('pegawai_id='.$pegawai_id.''); 
						for($i=0; $i<$jumlahRuanganPegawai; $i++)
						{
							$modRuanganPegawai = new RuanganpegawaiM;
							$modRuanganPegawai->ruangan_id=isset($_POST['ruangan_id'][$i]) ? $_POST['ruangan_id'][$i] : null;
							$modRuanganPegawai->pegawai_id=$pegawai_id;
							$modRuanganPegawai->save();
						}*/
        // $gelardepan = LookupM::model()->findByPk($model->gelardepan);
        // $model->gelardepan = $gelardepan->lookup_name;
        $model->update(); // update data 
        $transaction->commit();
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan !');
        $this->redirect(array('viewUser', 'sukses' => 1));
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'updateUser', array(
      'model' => $model, 'modRuanganPegawai' => $modRuanganPegawai, 'format' => $format
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
  /* ============================ Proses delete riwayat ========================================= */
  public function actiondeletePegawaidiklat($pegawaidiklat_id, $pegawai_id)
  {
    $modPegawaidiklat = new KPPegawaidiklatT;
    if ($modPegawaidiklat->deleteByPK($pegawaidiklat_id)) {
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil dihapus !');
      $this->redirect(array('Riwayat', 'id' => $pegawai_id));
    }
  }

  public function actiondeletePegawaijabatan($pegawaijabatan_id, $pegawai_id)
  {
    $modPegawaijabatan = new KPPegawaijabatanR;
    if ($modPegawaijabatan->deleteByPK($pegawaijabatan_id)) {
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil dihapus !');
      $this->redirect(array('Riwayat', 'id' => $pegawai_id));
    }
  }

  public function actiondeletePegmutasi($pegmutasi_id, $pegawai_id)
  {
    $modPegmutasi = new KPPegmutasiR;
    if ($modPegmutasi->deleteByPK($pegmutasi_id)) {
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil dihapus !');
      $this->redirect(array('Riwayat', 'id' => $pegawai_id));
    }
  }

  public function actiondeletePegawaicuti($pegawaicuti_id, $pegawai_id)
  {
    $modPegawaicuti = new KPPegawaicutiT;
    if ($modPegawaicuti->deleteByPK($pegawaicuti_id)) {
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil dihapus !');
      $this->redirect(array('Riwayat', 'id' => $pegawai_id));
    }
  }

  public function actiondeleteIzintugasbelajar($izintugasbelajar_id, $pegawai_id)
  {
    $modIzintugasbelajar = new KPIzintugasbelajarR;
    if ($modIzintugasbelajar->deleteByPK($izintugasbelajar_id)) {
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil dihapus !');
      $this->redirect(array('Riwayat', 'id' => $pegawai_id));
    }
  }

  public function actiondeleteHukdisiplin($hukdisiplin_id, $pegawai_id)
  {
    $modHukdisiplin = new KPHukdisiplinR;
    if ($modHukdisiplin->deleteByPK($hukdisiplin_id)) {
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil dihapus !');
      $this->redirect(array('Riwayat', 'id' => $pegawai_id));
    }
  }
  /* =========================== Akhir proses delete riwayat ======================================= */
  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('KPPegawaiM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new KPPegawaiM('search');
    $model->unsetAttributes();  // clear any default values
    $model->pegawaiP_aktif = true;
    if (isset($_GET['KPPegawaiM']))
      $model->attributes = $_GET['KPPegawaiM'];

    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  public function actionInformasi()
  {
    $this->pageTitle = Yii::app()->name . " - Pegawai Rs";
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    // Uncomment the following line if AJAX validation is needed
    $model = new KPPegawaiM('search');
    $model->unsetAttributes();  // clear any default values
    $model->kategoripegawaiasal = $this->kategoripegawaiasal;
    $model->pegawai_aktif = true;
    $model->tglberhenti_awal = date('Y-m-d');
    $model->tglberhenti_akhir = date('Y-m-d');

    if (isset($_GET['KPPegawaiM'])) {
      $model->attributes = $_GET['KPPegawaiM'];
      $model->instalasi_id = isset($_GET['KPPegawaiM']['instalasi_id']) ? $_GET['KPPegawaiM']['instalasi_id'] : null;
      $model->ruangan_id = isset($_GET['KPPegawaiM']['ruangan_id']) ? $_GET['KPPegawaiM']['ruangan_id'] : null;
      $model->tglberhenti_awal = isset($_GET['KPPegawaiM']['tglberhenti_awal']) ? MyFormatter::formatDateTimeForDb($_GET['KPPegawaiM']['tglberhenti_awal']) : null;
      $model->tglberhenti_akhir = isset($_GET['KPPegawaiM']['tglberhenti_akhir']) ? MyFormatter::formatDateTimeForDb($_GET['KPPegawaiM']['tglberhenti_akhir']) : null;
    }

    $this->render($this->path_view . 'informasi', array(
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
    $model = KPPegawaiM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sapegawai-m-form') {
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
    KPPegawaiM::model()->updateByPk($id, array('pegawai_aktif' => false));
    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('informasi'));
  }

  public function actionPrint()
  {
    $model = new KPPegawaiM('search');
    $judulLaporan = 'Data Pegawai';

    $model->unsetAttributes();  // clear any default values
    $model->kategoripegawaiasal = $this->kategoripegawaiasal;
    $model->pegawai_aktif = true;
    if (isset($_GET['KPPegawaiM'])) {
      $model->attributes = $_GET['KPPegawaiM'];
      $model->instalasi_id = isset($_GET['KPPegawaiM']['instalasi_id']) ? $_GET['KPPegawaiM']['instalasi_id'] : null;
      $model->ruangan_id = isset($_GET['KPPegawaiM']['ruangan_id']) ? $_GET['KPPegawaiM']['ruangan_id'] : null;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }


  public function actionRiwayat($id)
  {


    $this->render($this->path_view . 'riwayat', array(
      'model' => $this->loadModel($id),
    ));
  }

  public function actionPenilaian($id)
  {
    if (!empty($id)) {
      $modelpegawai = KPPegawaiM::model()->find('pegawai_id = ' . $id . '');
      $modelpegawai->jabatan_id = $modelpegawai->jabatan->jabatan_nama;
      $model = PenilaianpegawaiT::model()->find('pegawai_id = ' . $modelpegawai->pegawai_id . ' ');
    }

    if (empty($model)) {
      $model = new PenilaianpegawaiT;
    }

    $this->render($this->path_view . 'penilaian', array(
      'modelpegawai' => $modelpegawai,
      'model' => $model,
    ));
  }

  public function actionPrintDetailPenilaian($id)
  {
    $modelpegawai = PegawaiM::model()->findByPk($id);
    $model = PenilaianpegawaiT::model()->find('pegawai_id = ' . $modelpegawai->pegawai_id . ' ');
    $modelpegawai->attributes = $_REQUEST['KPPegawaiM'];
    if (empty($model)) {
      $model = new PenilaianpegawaiT;
    }
    $judulLaporan = 'Penilaian Pegawai';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'PrintPenilaian', array('model' => $model, 'modelpegawai' => $modelpegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'PrintPenilaian', array('model' => $model, 'modelpegawai' => $modelpegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->session['ukuran_kertas'];                  // Ukuran Kertas Pdf
      $posisi = Yii::app()->session['posisi_kertas'];                                      // Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->render($this->path_view . 'PrintPenilaian', array('model' => $model, 'modelpegawai' => $modelpegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionPrintRiwayat($id)
  {
    $model = PegawaiM::model()->findByPk($id);
    $modOrganisasi = PengorganisasiR::model()->findAllByAttributes(array('pegawai_id' => $model->pegawai_id), array('order' => 'pengorganisasi_tahun'));
    $modPendidikanpegawai = PendidikanpegawaiR::model()->findAllByAttributes(array('pegawai_id' => $model->pegawai_id), array('order' => 'tglmasuk'));
    $modSusunanKel = SusunankelM::model()->findAllByAttributes(array('pegawai_id' => $model->pegawai_id), array('order' => 'susunankel_id'));
    $modKenaikanPangkat = KenaikanpangkatT::model()->findAllByAttributes(array('pegawai_id' => $model->pegawai_id));
    $modPegawaidiklat = PegawaidiklatT::model()->findAllByAttributes(array('pegawai_id' => $model->pegawai_id), array('order' => 'tglditetapkandiklat'));
    $modPengalamankerja = PengalamankerjaR::model()->findAllByAttributes(array('pegawai_id' => $model->pegawai_id), array('order' => 'pengalamankerja_nourut'));
    $modPrestasi = PrestasikerjaR::model()->findAllByAttributes(array('pegawai_id' => $model->pegawai_id), array('order' => 'tglprestasidiperoleh'));
    $modPegawaijabatan = PegawaijabatanR::model()->findAllByAttributes(array('pegawai_id' => $model->pegawai_id), array('order' => 'tglditetapkanjabatan'));
    $modPegmutasi = PegmutasiR::model()->findAllByAttributes(array('pegawai_id' => $model->pegawai_id), array('order' => 'pegmutasi_id'));
    $modDinas = PerjalanandinasR::model()->findAllByAttributes(array('pegawai_id' => $model->pegawai_id), array('order' => 'perjalanandinas_id'));
    $modPegawaicuti = PegawaicutiT::model()->findAllByAttributes(array('pegawai_id' => $model->pegawai_id), array('order' => 'tglmulaicuti'));
    $modIzintugasbelajar = IzintugasbelajarR::model()->findAllByAttributes(array('pegawai_id' => $model->pegawai_id), array('order' => 'izintugasbelajar_id'));
    $modHukdisiplin = HukdisiplinR::model()->findAllByAttributes(array('pegawai_id' => $model->pegawai_id), array('order' => 'hukdisiplin_id'));
    $modPenggajian = PenggajianpegawaiV::model()->findAllByAttributes(array('pegawai_id' => $model->pegawai_id), array('order' => 'penggajianpeg_id'));


    if (isset($_REQUEST['KPPegawaiM'])) {
      $model->attributes = $_REQUEST['KPPegawaiM'];
    }
    $judulLaporan = 'Riwayat Pegawai';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'PrintRiwayat', array(
        'model' => $model,
        'judulLaporan' => $judulLaporan,
        'caraPrint' => $caraPrint,
        'modOrganisasi' => $modOrganisasi,
        'modPendidikanpegawai' => $modPendidikanpegawai,
        'modSusunanKel' => $modSusunanKel,
        'modKenaikanPangkat' => $modKenaikanPangkat,
        'modPegawaidiklat' => $modPegawaidiklat,
        'modPengalamankerja' => $modPengalamankerja,
        'modPrestasi' => $modPrestasi,
        'modPegawaijabatan' => $modPegawaijabatan,
        'modPegmutasi' => $modPegmutasi,
        'modDinas' => $modDinas,
        'modPegawaicuti' => $modPegawaicuti,
        'modIzintugasbelajar' => $modIzintugasbelajar,
        'modHukdisiplin' => $modHukdisiplin,
        'modPenggajian' => $modPenggajian
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'PrintRiwayat', array(
        'model' => $model,
        'judulLaporan' => $judulLaporan,
        'caraPrint' => $caraPrint,
        'modOrganisasi' => $modOrganisasi,
        'modPendidikanpegawai' => $modPendidikanpegawai,
        'modSusunanKel' => $modSusunanKel,
        'modKenaikanPangkat' => $modKenaikanPangkat,
        'modPegawaidiklat' => $modPegawaidiklat,
        'modPengalamankerja' => $modPengalamankerja,
        'modPrestasi' => $modPrestasi,
        'modPegawaijabatan' => $modPegawaijabatan,
        'modPegmutasi' => $modPegmutasi,
        'modDinas' => $modDinas,
        'modPegawaicuti' => $modPegawaicuti,
        'modIzintugasbelajar' => $modIzintugasbelajar,
        'modHukdisiplin' => $modHukdisiplin,
        'modPenggajian' => $modPenggajian
      ));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);

      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'PrintRiwayat', array(
        'model' => $model,
        'judulLaporan' => $judulLaporan,
        'caraPrint' => $caraPrint,
        'modOrganisasi' => $modOrganisasi,
        'modPendidikanpegawai' => $modPendidikanpegawai,
        'modSusunanKel' => $modSusunanKel,
        'modKenaikanPangkat' => $modKenaikanPangkat,
        'modPegawaidiklat' => $modPegawaidiklat,
        'modPengalamankerja' => $modPengalamankerja,
        'modPrestasi' => $modPrestasi,
        'modPegawaijabatan' => $modPegawaijabatan,
        'modPegmutasi' => $modPegmutasi,
        'modDinas' => $modDinas,
        'modPegawaicuti' => $modPegawaicuti,
        'modIzintugasbelajar' => $modIzintugasbelajar,
        'modHukdisiplin' => $modHukdisiplin,
        'modPenggajian' => $modPenggajian
      ), true));
      $mpdf->Output();
    }
  }

  protected function validasiTabularDiklat($datas, $model)
  {
    $pegawai = 0;
    $details = array();
    foreach ($datas as $i => $data) {
      $data = array_filter($data, 'strlen');
      if (is_array($data)) {
        if (!empty($data['pegawaidiklat_id'])) {
          $details[$i] = KPPegawaidiklatT::model()->findByPk($data['pegawaidiklat_id']);
          $details[$i]->attributes = $data;
          $pegawai = $data['pegawai_id'];
        } else {
          if (!empty($data['pegawaidiklat_nama'])) {
            $details[$i] = new KPPegawaidiklatT();
            $details[$i]->attributes = $data;
            $details[$i]->pegawai_id = $model->pegawai_id;
          }
        }
      } else {
        if (empty($data)) {
        } else {
          $pegawai = $data;
        }
      }
    }

    $rows = array();
    foreach ($details as $i => $data) {
      $rows[$i] = $data;
      $rows[$i]->validate();
    }

    return $rows;
  }

  protected function validasiTabularPengalamanKerja($datas, $model)
  {
    $pegawai = 0;
    $details = array();
    foreach ($datas as $i => $data) {
      $data = array_filter($data, 'strlen');
      if (is_array($data)) {
        if (!empty($data['pengalamankerja_id'])) {
          $details[$i] = KPPengalamankerjaR::model()->findByPk($data['pengalamankerja_id']);
          $details[$i]->attributes = $data;
          $pegawai = $data['pegawai_id'];
        } else {
          if (!empty($data['namaperusahaan'])) {
            $details[$i] = new KPPengalamankerjaR();
            $details[$i]->attributes = $data;
            $details[$i]->pegawai_id = $model->pegawai_id;
          }
        }
      }
    }
    $rows = array();
    foreach ($details as $i => $data) {
      $rows[$i] = $data;
      $rows[$i]->validate();
    }
    return $rows;
  }

  /**
   * menampilkan penggajian pegawai
   * @return rows table
   */
  public function actionGetPenggajian()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai_id = $_POST['pegawai_id'];
      $modPenggajian = PenggajianpegawaiV::model()->findAllByAttributes(array('pegawai_id' => $pegawai_id), array('order' => 'penggajianpeg_id'));
      $login_id = Yii::app()->user->id;

      if ($login_id == $pegawai_id) {
        $i = 1;
        $tr = '';
        foreach ($modPenggajian as $row) {
          $tr .= '<tr>';

          $tr .= '<td>' . $i . ' </td>';
          $tr .= '<td>' . (isset($row->periodegaji) ? $row->periodegaji : '-') . '</td>';
          $tr .= '<td>' . (isset($row->gelardepan) ? $row->gelardepan . $row->nama_pegawai : $row->nama_pegawai) . '</td>';
          $tr .= '<td>' . (isset($row->nama_keluarga) ? $row->nama_keluarga : '-') . '</td>';
          $tr .= '<td>' . MyFormatter::formatDateTimeForUser($row->tglpenggajian) . '</td>';
          $tr .= '<td>' . $row->nopenggajian . '</td>';
          $tr .= '<td>' . $row->penerimaanbersih . '</td>';
          $tr .= '<td>' . $row->totalpajak . '</td>';

          $tr .= '</tr>';
          $i++;
        }
      } else {
        $tr = '';
        $tr .= '<tr>';
        $tr .= '<td> Data Tidak Ditemukan </td>';
        $tr .= '</tr>';
      }
      $data['tr'] = $tr;

      echo json_encode($data);
      Yii::app()->end();
    }
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
      $modPegawai = new KPPegawaiM;
      if ($model_nama !== '' && $attr == '') {
        $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $propinsi_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $propinsi_id = $_POST["$model_nama"]["$attr"];
      }
      $kabupaten = null;
      if ($propinsi_id) {
        $kabupaten = $modPegawai->getKabupatenItems($propinsi_id);
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
      $modPegawai = new KPPegawaiM;
      if ($model_nama !== '' && $attr == '') {
        $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kabupaten_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kabupaten_id = $_POST["$model_nama"]["$attr"];
      }
      $kecamatan = null;
      if ($kabupaten_id) {
        $kecamatan = $modPegawai->getKecamatanItems($kabupaten_id);
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
      $modPegawai = new KPPegawaiM;

      if ($model_nama !== '' && $attr == '') {
        $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kecamatan_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kecamatan_id = $_POST["$model_nama"]["$attr"];
      }

      $kelurahan = null;
      if ($kecamatan_id) {
        $kelurahan = $modPegawai->getKelurahanItems($kecamatan_id);
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
      $modPegawai = new KPPegawaiM;
      $propinsi_id = $_POST['propinsi_id'];
      $kabupaten_id = $_POST['kabupaten_id'];
      $kecamatan_id = $_POST['kecamatan_id'];
      $kelurahan_id = (isset($_POST['kelurahan_id']) ? $_POST['kelurahan_id'] : null);

      $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE order by propinsi_nama asc');
      $propinsis = CHtml::listData($propinsis, 'propinsi_id', 'propinsi_nama');
      $propinsiOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($propinsis as $value => $name) {
        if ($value == $propinsi_id)
          $propinsiOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $propinsiOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kabupatens = $modPegawai->getKabupatenItems($propinsi_id);
      //                $kabupatens = KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true,));
      $kabupatens = CHtml::listData($kabupatens, 'kabupaten_id', 'kabupaten_nama');
      $kabupatenOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kabupatens as $value => $name) {
        if ($value == $kabupaten_id)
          $kabupatenOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kabupatenOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kecamatans = $modPegawai->getKecamatanItems($kabupaten_id);
      //                $kecamatans = KecamatanM::model()->findAllByAttributes(array('kabupaten_id'=>$kabupaten_id,'kecamatan_aktif'=>true,));
      $kecamatans = CHtml::listData($kecamatans, 'kecamatan_id', 'kecamatan_nama');
      $kecamatanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kecamatans as $value => $name) {
        if ($value == $kecamatan_id)
          $kecamatanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kecamatanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
      $kelurahans = $modPegawai->getKelurahanItems($kecamatan_id);
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

  public function actionGetTahun()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      if (!empty($_POST['tahun'])) {
        $format = new MyFormatter;
        $tahun = $format->formatDateTimeForDb($_POST['tahun']);
        $dob = $tahun;
        $today = date("Y-m-d");
        list($y, $m, $d) = explode('-', $dob);
        list($ty, $tm, $td) = explode('-', $today);
        if ($td - $d < 0) {
          $day = ($td + 30) - $d;
          $tm--;
        } else {
          $day = $td - $d;
        }
        if ($tm - $m < 0) {
          $month = ($tm + 12) - $m;
          $ty--;
        } else {
          $month = $tm - $m;
        }
        $year = $ty - $y;

        $data['tahun'] = str_pad($year, 2, '0', STR_PAD_LEFT);
        $data['bulan'] = str_pad($month, 2, '0', STR_PAD_LEFT);
        echo json_encode($data);
      }
      Yii::app()->end();
    }
  }

  public function actionKartuPegawai($idPegawai)
  {
    $this->layout = '//layouts/printWindows';
    $model = PegawaiM::model()->findByPk($idPegawai);
    $judulLaporan = 'Kartu Pegawai';
    $this->render($this->path_view . 'kartuPegawai', array(
      'model' => $model,
      'judulLaporan' => $judulLaporan
    ));
  }



  public function actionSetDropdownPendKualifikasi($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPegawai = new KPPegawaiM;
      if ($model_nama !== '' && $attr == '') {
        $pendidikan_id = $_POST["$model_nama"]['pendidikan_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $pendidikan_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $pendidikan_id = $_POST["$model_nama"]["$attr"];
      }
      $pendKualifikasi = null;
      if ($pendidikan_id) {
        $pendKualifikasi = $modPegawai->getPendKualifikasiItems($pendidikan_id);
        $pendKualifikasi = CHtml::listData($pendKualifikasi, 'pendkualifikasi_id', 'pendkualifikasi_nama');
      }
      if ($encode) {
        echo CJSON::encode($pendKualifikasi);
      } else {
        if (empty($pendKualifikasi)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($pendKualifikasi as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionSetDropdownKelompokPegawai($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPegawai = new KPPegawaiM;
      if ($model_nama !== '' && $attr == '') {
        $pendKualifikasi = $_POST["$model_nama"]['pendkualifikasi_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $pendKualifikasi = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $pendKualifikasi = $_POST["$model_nama"]["$attr"];
      }
      $kelpegawai = null;
      if ($pendKualifikasi) {
        $kelpegawai = $modPegawai->getKelompokPegawaiItems($pendKualifikasi);
        $kelpegawai = CHtml::listData($kelpegawai, 'kelompokpegawai_id', 'kelompokpegawai_nama');
      }
      if ($encode) {
        echo CJSON::encode($kelpegawai);
      } else {
        if (empty($kelpegawai)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          if (count((array)$kelpegawai) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          foreach ($kelpegawai as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
   * - digunakan untuk mencetak prinout data informasi pegawai aktif
   * @param type $pengajuanpetty_id
   * @param type $caraPrint
   */
  public function actionPrintInfo()
  {

    if ($_GET['caraPrint'] == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    } else {
      $this->layout = '//layouts/printWindows';
    }

    $cri = new CDbCriteria();
    $cri->select = " t.*, uk.namaunitkerja, p.statusperkawinan, p.kategoripegawai, j.jabatan_nama, p.tglditerima, p.kategoripegawaiasal, p.npwp, ptkp.kodeptkp, ptkp.jmltanggunan ";
    $cri->join =  " JOIN pegawai_m p ON t.pegawai_id = p.pegawai_id "
      .  " LEFT JOIN unitkerja_m uk ON uk.unitkerja_id = p.unitkerja_id "
      .  " LEFT JOIN jabatan_m j ON j.jabatan_id = t.jabatan_id "
      .       " LEFT JOIN ptkp_m ptkp ON ptkp.ptkp_id = p.ptkp_id ";
    $cri->addCondition(" p.pegawai_aktif = TRUE ");
    $cri->compare("LOWER(p.nofingerprint)", strtolower($_GET['KPPegawaiM']['nofingerprint']));
    $cri->compare("LOWER(p.nomorindukpegawai)", strtolower($_GET['KPPegawaiM']['nomorindukpegawai']));
    $cri->compare("LOWER(p.jeniskelamin)", strtolower($_GET['KPPegawaiM']['jeniskelamin']));
    $cri->compare("LOWER(p.agama)", strtolower($_GET['KPPegawaiM']['agama']));
    $cri->compare("LOWER(p.nama_pegawai)", strtolower($_GET['KPPegawaiM']['nama_pegawai']), true);
    $cri->compare(" t.pegawai_aktif ", $_GET['KPPegawaiM']['pegawai_aktif']);
    $cri->compare('LOWER(p.kategoripegawaiasal)', strtolower($this->kategoripegawaiasal), true);

    if (!empty($_GET['KPPegawaiM']['jabatan_id'])) {
      $cri->addCondition("p.jabatan_id = " . $_GET['KPPegawaiM']['jabatan_id'] . " ");
    }

    if (!empty($_GET['KPPegawaiM']['kategoripegawai'])) {
      $cri->addCondition("p.kategoripegawai = :kategoripegawai");
      $cri->params[':kategoripegawai'] = $_GET['KPPegawaiM']['kategoripegawai'];
    }

    if (!empty($_GET['KPPegawaiM']['kelompokpegawai_id'])) {
      $cri->addCondition("p.kelompokpegawai_id = " . $_GET['KPPegawaiM']['kelompokpegawai_id'] . " ");
    }

    if (!empty($_GET['KPPegawaiM']['unitkerja_id'])) {
      $cri->addCondition("p.unitkerja_id = " . $_GET['KPPegawaiM']['unitkerja_id'] . " ");
    }

    if (!empty($_GET['KPPegawaiM']['ruangan_id'])) {
      $r = PegawairuanganV::model()->findAll("ruangan_id = '" . $_GET['KPPegawaiM']['ruangan_id'] . "' ");

      $id = array();
      foreach ($r as $v) {
        $id[] = $v->pegawai_id;
      }

      $cri->addInCondition("t.pegawai_id", $id);
    } else {
      if (!empty($this->instalasi_id)) {


        $r = PegawairuanganV::model()->findAll("instalasi_id = '" . $_GET['KPPegawaiM']['instalasi_id'] . "' ");

        $id = array();
        foreach ($r as $v) {
          $id[] = $v->pegawai_id;
        }
        $cri->addInCondition("t.pegawai_id", $id);
      }
    }

    $cri->order = " p.nama_pegawai ASC ";

    $modDet = KPPegawaiV::model()->findAll($cri);

    $data = array();
    $jenis = '';
    foreach ($modDet as $det) {

      if ($det->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI) {
        $jenis = 'L';
      } elseif ($det->jeniskelamin == Params::JENIS_KELAMIN_PEREMPUAN) {
        $jenis = 'P';
      }
      $data["$det->namaunitkerja"]['nama'] = $det->namaunitkerja;

      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["nomorindukpegawai"] = $det->nomorindukpegawai;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["kategoripegawaiasal"] = $det->kategoripegawaiasal;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["agama"] = $det->agama;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["statuskepegawaian"] = (($det->pegawai_aktif == 1) ? "Aktif" : "Tidak Aktif");
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["nama"] = $det->namaLengkap;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["ttl"] = $det->tempatlahir_pegawai . ', ' . MyFormatter::formatDateTimeForUser($det->tgl_lahirpegawai);
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["alamat"] = $det->alamat_pegawai;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["statusperkawinan"] = $det->statusperkawinan;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["jeniskelamin"] = $jenis;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["pendidikan"] = $det->pendidikan_nama;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["status"] = $det->kategoripegawai;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["divisi"] = $det->namaunitkerja;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["jabatan"] = $det->jabatan_nama;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["mulaikerja"] = $det->tglditerima;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["masakerja"] = (!empty($det->tglditerima)) ? CustomFunction::getUmur($det->tglditerima) : '-';
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["npwp"] = (!empty($det->npwp)) ? $det->npwp : '-';
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["kodeptkp"] = (!empty($det->kodeptkp)) ? ($det->kodeptkp . "/" . $det->jmltanggunan) : '-';
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["unitkerja"] = (!empty($det->namaunitkerja)) ? $det->namaunitkerja : '-';

      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["suku_id"] = $det->suku_id;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["warganegara_pegawai"] = $det->warganegara_pegawai;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["kelompokpegawai_nama"] = $det->kelompokpegawai_nama;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["jenistenagamedis_id"] = $det->jenistenagamedis_id;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["kelompokjabatan"] = $det->kelompokjabatan;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["jeniswaktukerja"] = $det->jeniswaktukerja;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["masa_str"] = $det->masa_str;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["surattandaregistrasi"] = $det->surattandaregistrasi;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["masa_sip"] = $det->masa_sip;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["suratizinpraktek"] = $det->suratizinpraktek;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["masa_tenagasehat"] = $det->masa_tenagasehat;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["masa_medis"] = $det->masa_medis;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["no_rekening"] = $det->no_rekening;
      //$data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["bank_no_rekening"] = $det->bank_no_rekening;
      //$data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["notelp_pegawai"] = $det->notelp_pegawai;
      //$data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["nomobile_pegawai"] = $det->nomobile_pegawai;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["alamatemail"] = $det->alamatemail;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["photopegawai"] = $det->photopegawai;
      $data["$det->namaunitkerja"]['pembagian']["$det->pegawai_id"]["noidentitas"] = $det->nomorindukpegawai;
    }

    $profil = ProfilrumahsakitM::model()->findByPk(Yii::app()->user->getState('profilrs_id'));

    $judul_print = 'Karyawan ' . $profil->nama_rumahsakit;
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;

    $this->render($this->path_view . 'PrintInfo', array(
      'judul_print' => str_replace(' ', '_', str_replace('.', '_', $judul_print)),
      'judulLap' => $judul_print,
      'modDet' => $modDet,
      'data' => $data,
      'caraPrint' => $_GET['caraPrint']
    ));
  }

  public function actionGetKomponenGaji()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = isset($_POST['id']) ? $_POST['id'] : null;

      $data = array();

      $kom = KomponengajiM::model()->findByPk($id);

      $data['sukses'] = 0;
      $data['pesan'] = 0;
      //var_dump($id);
      if (!empty($kom)) {
        $data['sukses'] = 1;
        $data['tipekomponen'] = $kom->tipekomponengaji;
        $data['jeniskomponen'] = ($kom->ispotongan == true) ? 'Potongan' : 'Gaji';
      } else {
        $data['sukses'] = 1;
        $data['tipekomponen'] = '';
        $data['jeniskomponen'] = '';
      }

      echo json_encode($data);

      Yii::app()->end();
    }
  }

  public function actionGetNamaPtkp()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ptkp_id = isset($_POST['ptkp_id']) ? $_POST['ptkp_id'] : null;
      $data = array();
      $kom = PtkpM::model()->findByPk($ptkp_id);
      $data['sukses'] = 0;
      if (!empty($kom)) {
        $data['sukses'] = 1;
        $data['ptkpnama'] = $kom->kodeptkp . '/' . $kom->jmltanggunan;
      } else {
        $data['sukses'] = 0;
        $data['ptkpnama'] = '';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function notifPegawaiBaru($modPegawai)
  {
    $pegawai = PegawaiM::model()->findByPk($modPegawai->pegawai_id);

    $judul = 'Pendaftaran Pegawai Baru';

    $isi = $pegawai->nomorindukpegawai . ' ' . $pegawai->namaLengkap . '<br/>'
      .  'Terdaftar sebagai pegawai ' . $pegawai->kategoripegawai;

    // var_dump($judul, $isi, $modelAdmisi->attributes); die;
    $ok = true;

    $cri = new CDbCriteria();
    $cri->join = " JOIN instalasi_m i ON i.instalasi_id = t.instalasi_id ";
    $cri->addCondition(" i.instalasi_aktif = TRUE AND t.ruangan_aktif = TRUE ");
    $r = KPRuanganM::model()->findAll($cri);

    foreach ($r as $d) {
      if (!empty($d->modul_id)) {
          
          $modul = ModulK::model()->findByPk($d->modul_id);
          if (!empty($modul)) {
            $ok = CustomFunction::broadcastNotif($judul, $isi, array(
              array('instalasi_id' => $d->instalasi_id, 'ruangan_id' => $d->ruangan_id, 'modul_id' => $modul->modul_id),
            ));
              
          }
          
      }
    }

    return $ok;
  }

  public function actionPrintPegawai()
  {
    $format = new MyFormatter();
    $model = array();
    $modelPeg = new KPPegawaiM('search');
    $modelPeg->unsetAttributes();  // clear any default values
    $modelPeg->kategoripegawaiasal = $this->kategoripegawaiasal;
    $modelPeg->pegawai_aktif = true;

    if (isset($_GET['KPPegawaiM'])) {
      $modelPeg->attributes = $_GET['KPPegawaiM'];
      $modelPeg->instalasi_id = isset($_GET['KPPegawaiM']['instalasi_id']) ? $_GET['KPPegawaiM']['instalasi_id'] : null;
      $modelPeg->ruangan_id = isset($_GET['KPPegawaiM']['ruangan_id']) ? $_GET['KPPegawaiM']['ruangan_id'] : null;
      $modelPeg->tglberhenti_awal = isset($_GET['KPPegawaiM']['tglberhenti_awal']) ? MyFormatter::formatDateTimeForDb($_GET['KPPegawaiM']['tglberhenti_awal']) : null;
      $modelPeg->tglberhenti_akhir = isset($_GET['KPPegawaiM']['tglberhenti_akhir']) ? MyFormatter::formatDateTimeForDb($_GET['KPPegawaiM']['tglberhenti_akhir']) : null;

      $prov = $modelPeg->search();
      $prov->criteria->order = 'nama_pegawai asc';
      $prov->pagination = false;
      $model = $prov->data;
    }
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printPegawaiExcel', array('format' => $format, 'model' => $model, 'judulLaporan' => "Data Pegawai " . $this->kategoripegawaiasal, 'caraPrint' => $caraPrint));
    }
  }

  public function actionGetMasaAktifPegawai(){
    if (Yii::app()->request->isAjaxRequest) {
        $onemonth = date('Y-m-d',strtotime('+30 days',strtotime(date('Y-m-d'))));
        $oneweek = date('Y-m-d',strtotime('+7 days',strtotime(date('Y-m-d'))));

        $data=[];
        $critstr = new CDbCriteria();
        $critsip = new CDbCriteria();
        $critaktif = new CDbCriteria();
        //STR
        $critstr->addCondition('masa_str is not null');
        $critstr->compare('jenispegawai','Tetap',true);
        $criteriastr2 = new CDbCriteria();
        $criteriastr2->addCondition('masa_str ='."'".$onemonth."'");
        $criteriastr2->addCondition('masa_str ='."'".$oneweek."'", 'OR');
        $critstr->mergeWith($criteriastr2);
        $strData = PegawaiM::model()->findAll($critstr);
        //SIP
        $critsip->addCondition('masa_sip is not null');
        $critsip->compare('jenispegawai','Tetap',true);
        $criteriasip2 = new CDbCriteria();
        $criteriasip2->addCondition('masa_sip ='."'".$onemonth."'");
        $criteriasip2->addCondition('masa_sip ='."'".$oneweek."'", 'OR');
        $critsip->mergeWith($criteriasip2);
        $sipData = PegawaiM::model()->findAll($critsip);
        //KONTRAK
        $critaktif->compare('jenispegawai','Tidak Tetap',true);
        $criteriaaktif2 = new CDbCriteria();
        $criteriaaktif2->addCondition('tglmasaaktifpeg_sd ='."'".$onemonth."'");
        $criteriaaktif2->addCondition('tglmasaaktifpeg_sd ='."'".$oneweek."'", 'OR');
        $critaktif->mergeWith($criteriaaktif2);
        $aktifData = PegawaiM::model()->findAll($critaktif);
        $show= false;
        $table ='
        <h5 style="text-align:center;"><b>Daftar Pegawai STR/SIP/Masa Kontrak Akan Habis</b></h5>
        <table class="table" width="100%">'.
        '<thead>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Status</th>
            <th>Masa Aktif</th>
        </thead>
        <tbody>';

        if(count($strData) > 0){
          $trstr = '';
          foreach($strData as $str){
            $trstr .= '<tr>'.
                          '<td>'.$str->nama_pegawai.'</td>'.
                          '<td>'.$str->jeniskelamin.'</td>'.
                          '<td>STR</td>'.
                          '<td>'.$str->masa_str.'</td>'.
                      '</tr>';
          }
        }
        if (count($sipData) > 0) {
          $trsip = '';
          foreach($sipData as $sip){
            $trsip .= '<tr>'.
                          '<td>'.$sip->nama_pegawai.'</td>'.
                          '<td>'.$sip->jeniskelamin.'</td>'.
                          '<td>SIP</td>'.
                          '<td>'.$sip->masa_sip.'</td>'.
                      '</tr>';
          }
        }

        if (count($aktifData) > 0) {
          $trkontrak = '';
          foreach($aktifData as $kontrak){
            $trkontrak .= '<tr>'.
                          '<td>'.$kontrak->nama_pegawai.'</td>'.
                          '<td>'.$kontrak->jeniskelamin.'</td>'.
                          '<td>Kontrak</td>'.
                          '<td>'.$kontrak->tglmasaaktifpeg_sd.'</td>'.
                      '</tr>';
          }
        }

        $table .='</tbody>';
        if(count($strData) > 0 ){
          $table .=$trstr;
          $show = true;
        }
        if(count($sipData) > 0 ){
          $table .=$trsip;
          $show=  true;
        }
        if(count($aktifData) > 0 ){
          $table .=$trkontrak;
          $show=  true;

        }
        $table .='</table>';
        $data['table'] = $table;
        $data['show'] = $show;
        echo CJSON::encode($data);
        // echo json_encode(['date'=>$dateNow]);
    }
  }

  public function actionSetFormDokterBpjs() {
    if (Yii::app()->request->isAjaxRequest) {
      $bpjs = new BpjsVklaim();
      $pesan = "Tidak Ada";
      $sukses = 0;
      $html = "";

      $query = $_POST['query'];
      $start = 1;
      $limit = 10;
      
      $dataRespon = CJSON::decode($bpjs->search_dokter($query, $start, $limit));
      
      if(!empty($dataRespon) && $dataRespon['metaData']['code'] =='200'){
        $sukses = 1;
        $dokterList = (!empty($dataRespon['response']['list'])?$dataRespon['response']['list'] : array());

        if(!empty($dokterList)){
          foreach ($dokterList AS $i => $dokter) {
            $kode = $dokter['kode'];
            $nama = $dokter['nama'];
            $html .= "<tr>
                <td>
                    <a class='btn-small' href='javascript:void(0);' onclick='setDokterBpjs(".$kode.");'>
                    <i class='icon-form-check'></i></a>
                </td>
                <td>
                    <span>" . $kode . "</span>
                </td>
                <td>
                    <span>" . $nama . "</span>
                </td>
            </tr>";
          }
        }else{
          $html = "<tr> <td colspan='3'>Data Tidak Ditemukan !</td></tr>";
        }
      }else{
        if(!empty($dataRespon['metaData']['code'])){
          $pesan = $dataRespon['metaData']['message'];
        }
      }


        echo CJSON::encode(array('html' => $html, 'pesan' => $pesan, 'sukses' => $sukses));
        Yii::app()->end();
    }
  }

}
