<?php

/**
 * perbaikan update pada profil
 * BMB-198
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package         application.modules.sistemAdministrator
 * @subpackage      controllers
 *
 */
class ProfilRumahSakitMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $modMisiRS = SAMisirsM::model()->findAllByAttributes(array('profilrs_id' => $id));
    $this->render('view', array(
      'model' => $this->loadModel($id), 'modMisiRS' => $modMisiRS
    ));
  }

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionPrintRS($id)
  {

    $modMisiRS = SAMisirsM::model()->findAllByAttributes(array('profilrs_id' => $id));
    $judulLaporan = '';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('view', array(
        'model' => $this->loadModel($id), 'modMisiRS' => $modMisiRS
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('PrintRS', array(
        'model' => $this->loadModel($id), 'modMisiRS' => $modMisiRS
      ));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/protected/extensions');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->render('PrintRS', array(
        'model' => $this->loadModel($id), 'modMisiRS' => $modMisiRS
      )), true);
      $mpdf->Output();
    }
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new SAProfilRumahSakitM;
    $modMisiRS = new SAMisirsM;
    $modProfilPict = new SAProfilpictureM;


    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAProfilRumahSakitM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $model = new SAProfilRumahSakitM;
      $model->attributes = $_POST['SAProfilRumahSakitM'];

      if ($model->validate()) {
        try {

          $random = rand(0000000, 9999999);
          $model->logo_rumahsakit = CUploadedFile::getInstance($model, 'logo_rumahsakit');
          $gambar = $model->logo_rumahsakit;
          if (!empty($model->logo_rumahsakit)) { //Klo User Memasukan Logo
            $model->path_logorumahsakit = $random . $model->logo_rumahsakit;
            //                   $model->path_logorumahsakit =Params::pathProfilRSDirectory().$random.$model->logo_rumahsakit;
            $model->logo_rumahsakit = $random . $model->logo_rumahsakit;

            Yii::import("ext.EPhpThumb.EPhpThumb");

            $thumb = new EPhpThumb();
            $thumb->init(); //this is needed

            $fullImgName = $model->logo_rumahsakit;
            $fullImgSource = Params::pathProfilRSDirectory() . $fullImgName;
            $fullThumbSource = Params::pathProfilRSTumbsDirectory() . 'kecil_' . $fullImgName;

            $model->logo_rumahsakit = $fullImgName;

            if ($model->save()) {
              Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
              $gambar->saveAs($fullImgSource);
              $thumb->create($fullImgSource)
                ->resize(200, 200)
                ->save($fullThumbSource);
            } else {
              Yii::app()->user->setFlash('error', 'Logo <strong>Gagal!</strong>  disimpan.');
            }
          } else { //Klo User Tidak Memasukan Logo
            $model->save();
          }


          if (isset($_POST['SAMisirsM'])) {  //Jika Misi Diisi
            $valid = true;
            foreach ($_POST['SAMisirsM'] as $i => $item) {
              if (is_integer($i)) {
                $modMisiRS = new SAMisirsM;
                if (isset($_POST['SAMisirsM'][$i]))
                  $modMisiRS->attributes = $_POST['SAMisirsM'][$i];
                $modMisiRS->profilrs_id = $model->profilrs_id;
                $modMisiRS->misi = $_POST['SAMisirsM'][$i]['misi'];
                $valid = $modMisiRS->validate();

                if ($valid) {
                  $modMisiRS->save();
                }
              }
            }
          }

          if (isset($_POST['SAProfilpictureM'])) {

            Yii::import("ext.EPhpThumb.EPhpThumb");

            foreach ($_POST['SAProfilpictureM'] as $i => $item) {
              $tempProfil = true;
              $thumb = new EPhpThumb();
              $thumb->init(); //this is needed

              $modProfil = new SAProfilpictureM();

              $modProfil->attributes = $_POST['SAProfilpictureM'][$i];

              $modProfil->profilpicture_path = CUploadedFile::getInstance($modProfil, '[' . $i . ']profilpicture_path');
              if (empty($modProfil->profilpicture_path)) {
                $modProfil->profilpicture_path = '1';
                $tempProfil = false;
              }
              $rand = rand(0000000, 9999999);
              $fullImgName = $rand . $modProfil->profilpicture_path;

              $modProfil->profilrs_id = $model->profilrs_id;
              $modProfil->profilpicture_tgl = date('Y-m-d');
              $gambar = $modProfil->profilpicture_path;
              $modProfil->profilpicture_path = $fullImgName;

              if ($modProfil->save()) {
                if (!empty($gambar)) {
                  if ($tempProfil == true) {
                    //                                                $fullImgSource = Params::pathAntrianSliderGambar().$fullImgName;
                    //                                                $fullThumbSource = Params::pathAntrianSliderGambarThumbs().'kecil_' . $fullImgName;
                    //                                                $gambar->saveAs($fullImgSource);
                    //                                                $thumb->create($fullImgSource)
                    //                                                      ->resize(200, 200)
                    //                                                      ->save($fullThumbSource);
                  }
                }
              }
            }
          }
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('admin'));
        } catch (Exception $e) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
        }
      }
    }
    $this->render('create', array(
      'model' => $model, 'modMisiRS' => $modMisiRS, 'modProfilPict' => $modProfilPict
    ));
  }
  /**
   * digunakan untuk memanggil file gallery
   */
  public function actionGallery()
  {
    $this->layout = '//layouts/iframe';
    $model = new SAProfilpictureM();

    $this->render('gallery', array('model' => $model));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id = null)
  {
    if (empty($id)) {
      $id = Params::getDefaultProfilRS();
    }
    $this->pageTitle = Yii::app()->name . " - Profil Rumah Sakit";
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel($id);
    $modMisiRS = SAMisirsM::model()->findAllByAttributes(array('profilrs_id' => $id));
    $modProfilPict = SAProfilpictureM::model()->findAllByAttributes(array("profilrs_id" => $id), array('order' => 'profilpicture_tgl'));
    $temLogo = $model->logo_rumahsakit;
    $temLogo2 = $model->logo_rumahsakit_2;
    $temLayar = $model->noimagelayarantrian;

    $tmp_navbar = $model->logo_navbar;
    $tmp_sidebar = $model->logo_sidebar;
    $tmp_footer = $model->logo_footer;
    $tmp_footer2 = $model->logo_footer_2;
    $me_temp = $model->videoprofil;
    if (empty($_POST['SAProfilRumahSakitM'])) {
        $model->logo_navbar = $tmp_navbar;
        $model->logo_sidebar = $tmp_sidebar;
        $model->logo_footer = $tmp_footer;
        $model->logo_footer_2 = $tmp_footer2;
        $model->videoprofil = $me_temp;
    // $me_temp = $model->;

    }

    if (isset($_POST['SAProfilRumahSakitM'])) {

      $transaction = Yii::app()->db->beginTransaction();
      $model = $this->loadModel($id);
      $model->attributes = $_POST['SAProfilRumahSakitM'];
      $model->tglregistrasi = !empty($_POST['SAProfilRumahSakitM']['tglregistrasi']) ? MyFormatter::formatDateTimeForDb($_POST['SAProfilRumahSakitM']['tglregistrasi']) : null;
      $model->notelphumas = $_POST['SAProfilRumahSakitM']['notelphumas'];
      $model->luastanah = $_POST['SAProfilRumahSakitM']['luastanah'];
      $model->luasbangunan = $_POST['SAProfilRumahSakitM']['luasbangunan'];
      $model->tglakreditasi = !empty($_POST['SAProfilRumahSakitM']['tglakreditasi']) ? MyFormatter::formatDateTimeForDb($_POST['SAProfilRumahSakitM']['tglakreditasi']) : null;

      $hapusMisiRS = SAMisirsM::model()->deleteAll('profilrs_id=' . $id . '');
      if (isset($_POST['SAMisirsM'])) {  //Jika Misi Diisi
        $valid = true;

        foreach ($_POST['SAMisirsM'] as $i => $item) {
          if (is_integer($i)) {
            $modMisiRS = new SAMisirsM;
            if (isset($_POST['SAMisirsM'][$i]))
              $modMisiRS->attributes = $_POST['SAMisirsM'][$i];
            $modMisiRS->profilrs_id = $model->profilrs_id;
            $modMisiRS->misi = $_POST['SAMisirsM'][$i]['misi'];

            $valid = $modMisiRS->validate() && $valid;

            if ($valid) {
              $modMisiRS->save();
            }
          }
        }
      }

      if ($model->validate()) {
        try {

          $random = rand(0000000, 9999999);
          
          // update navbar
          if(empty(CUploadedFile::getInstance($model, 'logo_navbar'))){
            $model->logo_navbar =$tmp_navbar;
          }else{
            $model->logo_navbar = CUploadedFile::getInstance($model, 'logo_navbar');
            // $model->logo_navbar = CUploadedFile::getInstance($model, 'logo_navbar');
            $logo_navbar = $model->logo_navbar;
            $random = rand(0000000, 9999999);
            if (isset($model->logo_navbar) && ($model->logo_navbar != $tmp_navbar)) {//jika data lama dan baru tidaksama;
                if (!empty($tmp_navbar)) {
                    if (file_exists(Params::pathProfilRSDirectory() . $tmp_navbar)) {
                        unlink(Params::pathProfilRSDirectory() . $tmp_navbar);
                    }
                }
                $model->logo_navbar = strtolower(str_replace(" ", "_", $random . $model->logo_navbar));
                $rand_gambar = $model->logo_navbar;
                $fullImgName = $rand_gambar;
                $fullImgSource = Params::pathProfilRSDirectory() . $fullImgName;
                $model->logo_navbar = $fullImgName;
                $logo_navbar->saveAs($fullImgSource);
            }
          }
          // update sidebar
          if(empty(CUploadedFile::getInstance($model, 'logo_sidebar'))){
            $model->logo_sidebar =$tmp_sidebar;
          }else{
            $model->logo_sidebar = CUploadedFile::getInstance($model, 'logo_sidebar');
            // $model->logo_navbar = CUploadedFile::getInstance($model, 'logo_navbar');
            $logo_sidebar = $model->logo_sidebar;
            $random = rand(0000000, 9999999);
            if (isset($model->logo_sidebar) && ($model->logo_sidebar != $tmp_sidebar)) {//jika data lama dan baru tidaksama;
                if (!empty($tmp_sidebar)) {
                    if (file_exists(Params::pathProfilRSDirectory() . $tmp_sidebar)) {
                        unlink(Params::pathProfilRSDirectory() . $tmp_sidebar);
                    }
                }
                $model->logo_sidebar = strtolower(str_replace(" ", "_", $random . $model->logo_sidebar));
                $rand_gambar = $model->logo_sidebar;
                $fullImgName = $rand_gambar;
                $fullImgSource = Params::pathProfilRSDirectory() . $fullImgName;
                $model->logo_sidebar = $fullImgName;
                $logo_sidebar->saveAs($fullImgSource);
            }
          }
          // update navbar
          if(empty(CUploadedFile::getInstance($model, 'logo_footer'))){
            $model->logo_footer =$tmp_footer;
          }else{
            $model->logo_footer = CUploadedFile::getInstance($model, 'logo_footer');
            $logo_footer = $model->logo_footer;
            $random = rand(0000000, 9999999);
            if (isset($model->logo_footer) && ($model->logo_footer != $tmp_footer)) {//jika data lama dan baru tidaksama;
                if (!empty($tmp_footer)) {
                    if (file_exists(Params::pathProfilRSDirectory() . $tmp_footer)) {
                        unlink(Params::pathProfilRSDirectory() . $tmp_footer);
                    }
                }
                $model->logo_footer = strtolower(str_replace(" ", "_", $random . $model->logo_footer));
                $rand_gambar = $model->logo_footer;
                $fullImgName = $rand_gambar;
                $fullImgSource = Params::pathProfilRSDirectory() . $fullImgName;
                $model->logo_footer = $fullImgName;
                $logo_footer->saveAs($fullImgSource);
            }
          }
          
          if(empty(CUploadedFile::getInstance($model, 'logo_footer_2'))){
            $model->logo_footer_2 =$tmp_footer2;
          }else{
            $model->logo_footer_2 = CUploadedFile::getInstance($model, 'logo_footer_2');
            $logo_footer_2 = $model->logo_footer_2;
            $random = rand(0000000, 9999999);
            if (isset($model->logo_footer_2) && ($model->logo_footer_2 != $tmp_footer2)) {//jika data lama dan baru tidaksama;
                if (!empty($tmp_footer2)) {
                    if (file_exists(Params::pathProfilRSDirectory() . $tmp_footer2)) {
                        unlink(Params::pathProfilRSDirectory() . $tmp_footer2);
                    }
                }
                $model->logo_footer_2 = strtolower(str_replace(" ", "_", $random . $model->logo_footer_2));
                $rand_gambar = $model->logo_footer_2;
                $fullImgName = $rand_gambar;
                $fullImgSource = Params::pathProfilRSDirectory() . $fullImgName;
                $model->logo_footer_2 = $fullImgName;
                $logo_footer_2->saveAs($fullImgSource);
            }
          }
          // Antrian

          if(empty(CUploadedFile::getInstance($model, 'noimagelayarantrian'))){
            $model->noimagelayarantrian =$temLayar;
          }else{
            $model->noimagelayarantrian = CUploadedFile::getInstance($model, 'noimagelayarantrian');
            $noimagelayarantrian = $model->noimagelayarantrian;
            $random = rand(0000000, 9999999);
            if (isset($model->noimagelayarantrian) && ($model->noimagelayarantrian != $temLayar)) {//jika data lama dan baru tidaksama;
                if (!empty($temLayar)) {
                    if (file_exists(Params::pathProfilRSDirectory() . $temLayar)) {
                        unlink(Params::pathProfilRSDirectory() . $temLayar);
                    }
                }
                $model->noimagelayarantrian = strtolower(str_replace(" ", "_", $random . $model->noimagelayarantrian));
                $rand_gambar_antrian = $model->noimagelayarantrian;
                $fullImgName = $rand_gambar_antrian;
                $fullImgSource = Params::pathProfilRSDirectory() . $fullImgName;
                $model->noimagelayarantrian = $fullImgName;
                $noimagelayarantrian->saveAs($fullImgSource);
            }
          }

          // var_dump(CUploadedFile::getInstance($model, 'videoprofil'));die;
          // video antrian
          if(empty(CUploadedFile::getInstance($model, 'videoprofil'))){
            $model->videoprofil =$me_temp;
            // exit('not');
          }else{


            $model->videoprofil = CUploadedFile::getInstance($model, 'videoprofil');
            $videoprofil = $model->videoprofil;
            $random = rand(0000000, 9999999);
            if (isset($model->videoprofil) && ($model->videoprofil != $me_temp)) {//jika data lama dan baru tidaksama;
                if (!empty($me_temp)) {
                    if (file_exists(Params::pathVideoAntrian() . $me_temp)) {
                        unlink(Params::pathVideoAntrian() . $me_temp);
                    }
                }
                $model->videoprofil = strtolower(str_replace(" ", "_", $random . $model->videoprofil));
                $rand_video = $model->videoprofil;
                $fullImgName = $rand_video;
                $fullImgSource = Params::pathVideoAntrian() . $fullImgName;
                $model->videoprofil = $fullImgName;
                
                // vaR_dump($fullImgSource); die;

              //   if (!file_exists(Yii::getPathOfAlias('webroot').'/data/video/')){
              //     mkdir(Yii::getPathOfAlias('webroot').'/data/video/', 0755, true);           
              // }

              // if (!file_exists(Params::pathVideoAntrian())){
              //     mkdir(Params::pathVideoAntrian(), 0755, true);           
              // }
              // var_dump()
              // var_dump($_FILES['videoprofil']['mime']);die;

                $videoprofil->saveAs($fullImgSource);
                // var_dump($fullImgSource);
                // var_dump($model->videoprofil);die;
            }
            // exit('notupload');
          }

          // $model->save();

          // $model->logo_sidebar= CUploadedFile::getInstance($model, 'logo_sidebar');
          // $model->logo_footer = CUploadedFile::getInstance($model, 'logo_footer');

          $gambar = $model->logo_rumahsakit;


          $random2 = rand(0000000, 9999999);
          $model->logo_rumahsakit_2 = CUploadedFile::getInstance($model, 'logo_rumahsakit_2');
          $gambar2 = $model->logo_rumahsakit_2;

          
          
          if (empty(CUploadedFile::getInstance($model, 'logo_rumahsakit'))) {
              $model->logo_rumahsakit = $temLogo;
          } else {
              $model->logo_rumahsakit = CUploadedFile::getInstance($model, 'logo_rumahsakit');
              
              $gambar = $model->logo_rumahsakit;
              
              if (isset($model->logo_rumahsakit) && ($model->logo_rumahsakit != $temLogo)) {
                    $model->path_logorumahsakit = $random . $model->logo_rumahsakit;
                    $model->logo_rumahsakit = $random . $model->logo_rumahsakit;


                    Yii::import("ext.EPhpThumb.EPhpThumb");

                $fullImgName = $model->logo_rumahsakit;
                $fullImgSource = Params::pathProfilRSDirectory() . $fullImgName;
                $fullThumbSource = Params::pathProfilRSTumbsDirectory() . 'kecil_' . $fullImgName;

                if (!isset($model->logo_rumahsakit)) {
                  $model->logo_rumahsakit = $temLogo;
                } else {
                  $model->logo_rumahsakit = $fullImgName;
                }
                

//                if ($model->save()) {
//                  if (!empty($temLogo)) {
                    //                                        unlink(Params::pathProfilRSDirectory().$temLogo);
                    //                                        unlink(Params::pathProfilRSTumbsDirectory().'kecil_'.$temLogo);
//                  }

                  // var_dump($fullImgSource); die;

                $gambar->saveAs($fullImgSource);
                  //                                    $thumb->create($fullImgSource)
                  //                                            ->resize(200, 200)
                  //                                            ->save($fullThumbSource);
                  //                            if (!empty($model->videoprofil) && ($model->videoprofil != $temVideo)) {
                  //                                $gambarVideo->saveAs($fullImgSourceV);
                  //                            }

//                  if (!empty($model->noimagelayarantrian) && ($model->noimagelayarantrian != $temLayar)) {
//                    $gambarDisplay->saveAs($fullImgSourceD);
//                  }
                //}
              }else{
                // if (!empty($model->logo_navbar)) {
                //     $model->logo_navbar = $random . $model->logo_navbar;
                //     $fullImgName = $model->logo_navbar;
                //     $fullImgSourceNavbar = Params::pathProfilRSDirectory() . $fullImgName;
                //     $gambar_navbar->saveAs($fullImgSourceNavbar);
                // }
                // if (!empty($model->logo_sidebar)) {
                //     $model->logo_sidebar = $random . $model->logo_sidebar;
                //     $fullImgName = $model->logo_sidebar;
                //     $fullImgSourceSidebar = Params::pathProfilRSDirectory() . $fullImgName;
                //     $gambar_sidebar->saveAs($fullImgSourceSidebar);
                // }
                // if (!empty($model->logo_footer)) {
                //     $model->logo_footer = $random . $model->logo_footer;
                //     $fullImgName = $model->logo_footer;
                //     $fullImgSourceFooter = Params::pathProfilRSDirectory() . $fullImgName;
                //     $gambar_footer->saveAs($fullImgSourceFooter);
                // }

    //            if ($model->save()) {
                    // $gambar_navbar->saveAs($fullImgSourceNavbar);
                    // $gambar_sidebar->saveAs($fullImgSourceSidebar);
                    // $gambar_footer->saveAs($fullImgSourceFooter);
    //            } else {
    //                Yii::app()->user->setFlash('error', 'Logo <strong>Gagal!</strong>  disimpan.');
    //            }
              }
              
          }
          
          
          $model->save();


          /*else if (isset($model->noimagelayarantrian) && ($model->noimagelayarantrian != $temLayar) && empty($model->logo_rumahsakit)) {
                        $model->noimagelayarantrian = $random . $model->noimagelayarantrian;
                        Yii::import("ext.EPhpThumb.EPhpThumb");
                        $fullImgNameD = $model->noimagelayarantrian;
                        $fullImgSourceD = Params::pathProfilRSDirectory() . $fullImgNameD;
                        $fullThumbSourceD = Params::pathProfilRSTumbsDirectory() . 'kecil_' . $fullImgNameD;

                        if (!isset($model->noimagelayarantrian)) {
                            $model->noimagelayarantrian = $temLayar;
                        } else {
                            $model->noimagelayarantrian = $fullImgNameD;
                        }

                        if ($model->save()) {
                            $gambarDisplay->saveAs($fullImgSourceD);
                            if (isset($model->videoprofil) && ($model->videoprofil != $temVideo)) {
                                $gambarVideo->saveAs($fullImgSourceV);
                            }
                        }
                    }
                    else if (isset($model->logo_rumahsakit) && ($model->logo_rumahsakit != $temLogo) && isset($model->noimagelayarantrian) && ($model->noimagelayarantrian != $temLayar)) {
                        Yii::import("ext.EPhpThumb.EPhpThumb");
                        $model->path_logorumahsakit = $random . $model->logo_rumahsakit;
                        $model->logo_rumahsakit = $random . $model->logo_rumahsakit;
                        $fullImgName = $model->logo_rumahsakit;
                        $fullImgSource = Params::pathProfilRSDirectory() . $fullImgName;
                        $fullThumbSource = Params::pathProfilRSTumbsDirectory() . 'kecil_' . $fullImgName;
                        if (!isset($model->logo_rumahsakit)) {
                            $model->logo_rumahsakit = $temLogo;
                        } else {
                            $model->logo_rumahsakit = $fullImgName;
                        }

                        $model->noimagelayarantrian = $random . $model->noimagelayarantrian;
                        $fullImgNameD = $model->noimagelayarantrian;
                        $fullImgSourceD = Params::pathProfilRSDirectory() . $fullImgNameD;
                        $fullThumbSourceD = Params::pathProfilRSTumbsDirectory() . 'kecil_' . $fullImgNameD;

                        if (!isset($model->noimagelayarantrian)) {
                            $model->noimagelayarantrian = $temLayar;
                        } else {
                            $model->noimagelayarantrian = $fullImgNameD;
                        }

                        if ($model->save()) {
                            $gambar->saveAs($fullImgSource);
                            $gambarDisplay->saveAs($fullImgSourceD);
                            if (isset($model->videoprofil) && ($model->videoprofil != $temVideo)) {
                                $gambarVideo->saveAs($fullImgSourceV);
                            }
                        }
                    }
                     *
                     */
          //           else {
          //   $model->logo_rumahsakit = $temLogo;
          //   $model->save();
          //   //                        if (!empty($model->videoprofil) && ($model->videoprofil != $temVideo)) {
          //   //                                $gambarVideo->saveAs($fullImgSourceV);
          //   //                            }
          //   if (!empty($model->noimagelayarantrian) && ($model->noimagelayarantrian != $temLayar)) {
          //     $gambarDisplay->saveAs($fullImgSourceD);
          //   }
          // }
//          die;
          if (isset($model->logo_rumahsakit_2) && ($model->logo_rumahsakit_2 != $temLogo2)) {
            $model->path_logorumahsakit2 = $random2 . $model->logo_rumahsakit_2;
            $model->logo_rumahsakit_2 = $random2 . $model->logo_rumahsakit_2;

            Yii::import("ext.EPhpThumb.EPhpThumb");

            //$thumb = new EPhpThumb();
            //$thumb->init(); //this is needed

            $fullImgName = $model->logo_rumahsakit_2;
            $fullImgSource = Params::pathProfilRSDirectory() . $fullImgName;
            $fullThumbSource = Params::pathProfilRSTumbsDirectory() . 'kecil_' . $fullImgName;

            if (!isset($model->logo_rumahsakit_2)) {
              $model->logo_rumahsakit_2 = $temLogo2;
            } else {
              $model->logo_rumahsakit_2 = $fullImgName;
            }

            if ($model->save()) {
              if (!empty($temLogo2)) {
                //                                        unlink(Params::pathProfilRSDirectory().$temLogo);
                //                                        unlink(Params::pathProfilRSTumbsDirectory().'kecil_'.$temLogo);
              }

              // var_dump($fullImgSource); die;

              $gambar2->saveAs($fullImgSource);
              //                                    $thumb->create($fullImgSource)
              //                                            ->resize(200, 200)
              //                                            ->save($fullThumbSource);
            }
          } else {
            $model->logo_rumahsakit_2 = $temLogo2;
            $model->save();
          }

          if (isset($_POST['SAProfilpictureM'])) {
            Yii::import("ext.EPhpThumb.EPhpThumb");

            SAProfilpictureM::model()->deleteAllByAttributes(array('profilrs_id' => $model->profilrs_id));
            foreach ($_POST['SAProfilpictureM'] as $i => $item) {
              $tempProfil = '';
              $dataGambar = true;
              // $thumb = new EPhpThumb();
              // $thumb->init(); //this is needed

              $modProfil = new SAProfilpictureM();
              $modProfil->attributes = $_POST['SAProfilpictureM'][$i];

              if (!empty($_POST['SAProfilpictureM'][$i]['profilpicture_id'])) {
                $tempProfil = $_POST['SAProfilpictureM'][$i]['temp_gambar'];
                $modProfil->profilpicture_id = $_POST['SAProfilpictureM'][$i]['profilpicture_id'];
              }
              //                                     echo 'a'.$_POST['SAProfilpictureM'][$i]['temp_gambar'].$modProfil->temp_gambar;
              $modProfil->profilpicture_path = CUploadedFile::getInstance($modProfil, '[' . $i . ']profilpicture_path');
              if (empty($modProfil->profilpicture_path)) {
                $dataGambar = false;
              }
              $rand = rand(0000000, 9999999);
              $fullImgName = $rand . $modProfil->profilpicture_path;

              if (empty($modProfil->profilpicture_path)) {
                if (empty($tempProfil)) {
                  $tempProfil = '1';
                }
                $modProfil->profilpicture_path = $tempProfil;
                $fullImgName = $tempProfil;
              }

              $modProfil->profilrs_id = $model->profilrs_id;
              $gambar = $modProfil->profilpicture_path;
              $modProfil->profilpicture_tgl = date('Y-m-d H:i:s');
              $modProfil->profilpicture_path = $fullImgName;

              if ($modProfil->save()) {
                if (!empty($gambar)) {
                  if (!empty($tempProfil)) {
                    if ($dataGambar == true) {
                      if (file_exists(Params::pathAntrianSliderGambar() . $tempProfil)) {
                        unlink(Params::pathAntrianSliderGambar() . $tempProfil);
                      }
                      //                                                     if (file_exists(Params::pathAntrianSliderGambarThumbs().'kecil_'.$tempProfil)){
                      //                                                        unlink(Params::pathAntrianSliderGambarThumbs(). 'kecil_' . $tempProfil);
                      //                                                     }
                    }
                  }
                  if ($fullImgName != $tempProfil) {
                    $fullImgSource = Params::pathAntrianSliderGambar() . $fullImgName;
                    //$fullThumbSource = Params::pathAntrianSliderGambarThumbs().'kecil_' . $fullImgName;
                    $gambar->saveAs($fullImgSource);
                    // $thumb->create($fullImgSource)
                    //  ->resize(200, 200)
                    //  ->save($fullThumbSource);
                  }
                }
              }
            }
          }

          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('update', 'sukses' => 1));
        } catch (Exception $e) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
        }
      } else {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
      }
    }

    $this->render('update', array(
      'model' => $model, 'modMisiRS' => $modMisiRS, 'modProfilPict' => $modProfilPict,
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


      //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $hapusMisiRS = SAMisirsM::model()->deleteAll('profilrs_id=' . $id . '');
        $hapusMisiRS = SAProfilpictureM::model()->deleteAll('profilrs_id=' . $id . '');
        $model = $this->loadModel($id)->delete();
        $temLogo = $model->logo_rumahsakit;

        if (!empty($temLogo)) {
          unlink(Params::urlProfilRSDirectory() . $temLogo);
          unlink(Params::urlProfilRSDirectory() . $temLogo);
        }

        $transaction->commit();
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
      } catch (Exception $e) {
        $transaction->rollback();
        echo 'error' . $e->getMessage();
      }
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SAProfilRumahSakitM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new SAProfilRumahSakitM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAProfilRumahSakitM']))
      $model->attributes = $_GET['SAProfilRumahSakitM'];

    $this->render('admin', array(
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
    $model = SAProfilRumahSakitM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'saprofil-rumah-sakit-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * digunakan untuk fitur cetak laporan
   */
  public function actionPrint()
  {

    $model = new SAProfilRumahSakitM;
    $model->attributes = $_REQUEST['SAProfilRumahSakitM'];
    $judulLaporan = '';
    $caraPrint = $_REQUEST['caraPrint'];

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
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
      $model = new SAProfilRumahSakitM;
      if ($model_nama !== '' && $attr == '') {
        $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $propinsi_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $propinsi_id = $_POST["$model_nama"]["$attr"];
      }
      $kabupaten = null;
      if ($propinsi_id) {
        $kabupaten = $model->getKabupatenItems($propinsi_id);
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
      $model = new SAProfilRumahSakitM;
      if ($model_nama !== '' && $attr == '') {
        $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kabupaten_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kabupaten_id = $_POST["$model_nama"]["$attr"];
      }
      $kecamatan = null;
      if ($kabupaten_id) {
        $kecamatan = $model->getKecamatanItems($kabupaten_id);
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
      $model = new SAProfilRumahSakitM;
      if ($model_nama !== '' && $attr == '') {
        $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kecamatan_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kecamatan_id = $_POST["$model_nama"]["$attr"];
      }
      $kelurahan = null;
      if ($kecamatan_id) {
        $kelurahan = $model->getKelurahanItems($kecamatan_id);
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
   * digunakan untuk set jenis RS
   */
  public function actionSetKodeJenisRs()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $modLookup = SALookupM::model()->findByAttributes(array('lookup_type' => 'jenisrs_profilrs', 'lookup_value' => $_POST['jenisrs']));
      if (!empty($modLookup->lookup_kode)) {
        $res = $modLookup->lookup_kode;
      } else {
        $res = '-';
      }
      echo json_encode($res);
      Yii::app()->end();
    }
  }

  /**
   * digunakan untuk set kode pemilik RS
   */
  public function actionSetKodePemilikRs()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $modLookup = SALookupM::model()->findByAttributes(array('lookup_type' => 'namakepemilikanrs', 'lookup_value' => $_POST['pemilikrs']));
      if (!empty($modLookup->lookup_kode)) {
        $res = $modLookup->lookup_kode;
      } else {
        $res = '-';
      }
      echo json_encode($res);
      Yii::app()->end();
    }
  }
  /**
   * digunakan untuk set kode status swasta
   */
  public function actionSetKodeStatusSwasta()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $modLookup = SALookupM::model()->findByAttributes(array('lookup_type' => 'statusrsswasta', 'lookup_value' => $_POST['statusswasta']));
      if (!empty($modLookup->lookup_kode)) {
        $res = $modLookup->lookup_kode;
      } else {
        $res = '-';
      }
      echo json_encode($res);
      Yii::app()->end();
    }
  }

  /**
   * difunakan untuk autocomplate nama direktur
   * @throws CHttpException menampilkan peringatan jika ada kesalahan
   */
  public function actionAutocompleteNamaDirektur()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;

      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->addCondition('pegawai_aktif = TRUE');
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 10;
      $models = PegawaiM::model()->findAll($criteria);
      if (count((array)$models) > 0) {
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->nama_pegawai . '-' . $model->nomorindukpegawai;
          $returnVal[$i]['value'] = $model->nama_pegawai;
        }
      } else {
        $returnVal = null;
      }


      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * digunakan untuk load data pada dropdown kelas rs
   */
  public function actionsetDropdownKelasRS()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $option = '';
      if (!empty($_POST['pemilik'])) {
        $criteria = new CDbCriteria();
        $criteria->addCondition("lookup_type = 'kelas_rumahsakit'");
        $criteria->addCondition("lookup_value = " . "'$_POST[pemilik]'");
        $criteria->order = "lookup_urutan";
        $criteria->addCondition("lookup_aktif IS TRUE");
        $data = LookupM::model()->findAll($criteria);
        $data = CHtml::listData($data, 'lookup_name', 'lookup_name');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['listKelas'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }
  
  
    public function actionUploadVideoAntrian() {
        if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
            Yii::app()->end();
        }
        $upload = CUploadedFile::getInstanceByName('file');
        $ok = 1;
        $msg = "File video berhasil di-upload.";
        // var_dump($upload);die;
        $name = str_replace(" ", "_", $upload->name);
        $type = $upload->type;
        
        $split1 = explode("/", $type);
        
        if ($split1[0] != "video") {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'File yang di-upload bukan video',
            ));
            
            Yii::app()->end();
        }
        
        if (!$upload->saveAs(Params::pathVideoAntrian().$name)) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'File video antrian gagal di-upload.',
            ));
            Yii::app()->end();
        }
        
        $list = scandir(Params::pathVideoAntrian());
        $html = "";

        $res_dat = array();
        foreach ($list as $item) {
            if (in_array($item, array('.', '..', 'logo.gif'))) {
                continue;
            }

            $res_dat[] = $item;
        }
        
        
        
        foreach ($res_dat as $item) {
            $html .= '<tr>';
            $html .= '<td class="nama_upload_antrian" data-nama="'.$item.'">'.$item.'</td>';
            $html .= '<td>'.CHtml::button('x', array('class'=>'btn btn-danger','onclick'=>'hapusFileUpload(this);')).'</td>';
            $html .= '</tr>';
        }
        
        
        
        echo CJSON::encode(array(
            'ok'=>$ok,
            'msg'=>$msg,
            'html'=>$html,
        ));
        
    }
    
    public function actionHapusVideoAntrian() {
        if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
            Yii::app()->end();
        }
        
        $nama = $_POST['nama'];
        
        $lokasi = Params::pathVideoAntrian().$nama;
        
        if (!file_exists($lokasi)) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'File video tidak ditemukan.',
            ));
            Yii::app()->end();
        }
        
        if (!unlink($lokasi)) {
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'File video gagal dihapus.',
            ));
            Yii::app()->end();
        }
        
        echo CJSON::encode(array(
            'ok'=>1,
            'msg'=>'File video berhasil dihapus.',
        ));
        
        
    }
}
