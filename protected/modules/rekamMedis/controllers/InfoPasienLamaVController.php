<?php
Yii::import('rekamMedis.controllers.InfoPasienBaruVController');
Yii::import('rekamMedis.models.RKPasienM');
Yii::import('rawatJalan.models.*'); // untuk riwayat
class InfoPasienLamaVController extends InfoPasienBaruVController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view_pasienbaru = 'rekamMedis.views.infoPasienBaruV.';

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
  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new RKInfoPasienLamaV;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['RKInfoPasienLamaV'])) {
      $model->attributes = $_POST['RKInfoPasienLamaV'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->pendaftaran_id));
      }
    }

    $this->render('create', array(
      'model' => $model,
    ));
  }
  public function actionGetDataPendaftaranRI()
  {
    if (Yii::app()->request->isAjaxRequest) {
      print_r($_POST['pendaftaran_id']);
      exit;
      $id_pendaftaran = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $model = RKInfoPasienLamaV::model()->findByAttributes(array('pendaftaran_id' => $id_pendaftaran));
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      echo json_encode($returnVal);
      Yii::app()->end();
    }
  }

  public function actionGetDataPendaftaranRD()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id_pendaftaran = $_POST['pendaftaran_id'];
      $model = InfokunjunganrdV::model()->findByAttributes(array('pendaftaran_id' => $id_pendaftaran));
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

  public function actionUbahPasien($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel2($id);
    $format = new MyFormatter();
    $temLogo = $model->photopasien;
    $modPegawai = new RKPegawaiM;
    $modPendaftaran = new PendaftaranT;
    if (!empty($model->pegawai_id)) {
      $modPegawai = RKPegawaiM::model()->findByPk($model->pegawai_id);
    }
    if (isset($_POST['RKPasienM'])) {
      $random = rand(0000000, 9999999);
      $format = new MyFormatter();
      $model->attributes = $_POST['RKPasienM'];
      if (isset($_POST['RKPegawaiM'])) {
        $model->pegawai_id = $_POST['RKPegawaiM']['pegawai_id'];
      }
      $model->kelompokumur_id = CustomFunction::getKelompokUmur($model->tanggal_lahir);
      $model->photopasien = CUploadedFile::getInstance($model, 'photopasien');
      $gambar = $model->photopasien;
      if (!empty($model->photopasien)) { //if user input the photo of patient
        $model->photopasien = $random . $model->photopasien;

        Yii::import("ext.EPhpThumb.EPhpThumb");

        $thumb = new EPhpThumb();
        $thumb->init(); //this is needed

        $fullImgName = $model->photopasien;
        $fullImgSource = Params::pathPasienDirectory() . $fullImgName;
        $fullThumbSource = Params::pathPasienTumbsDirectory() . 'kecil_' . $fullImgName;

        if ($model->save()) {
          if (!empty($temLogo)) {
            if (file_exists(Params::pathPasienDirectory() . $temLogo))
              unlink(Params::pathPasienDirectory() . $temLogo);
            if (file_exists(Params::pathPasienTumbsDirectory() . 'kecil_' . $temLogo))
              unlink(Params::pathPasienTumbsDirectory() . 'kecil_' . $temLogo);
          }
          $gambar->saveAs($fullImgSource);
          $thumb->create($fullImgSource)
            ->resize(200, 200)
            ->save($fullThumbSource);

          $model->tgl_rekam_medik  = $format->formatDateTimeForDb($_POST['RKPasienM']['tgl_rekam_medik']);
          $model->updateByPk($id, array('tgl_rekam_medik' => $model->tgl_rekam_medik));
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('admin'));
        } else {
          Yii::app()->user->setFlash('error', 'Data <strong>Gagal!</strong>  disimpan.');
        }
      } else { //if user not input the photo
        $model->photopasien = $temLogo;
        if ($model->save()) {
          $model->tgl_rekam_medik  = $format->formatDateTimeForDb($_POST['RKPasienM']['tgl_rekam_medik']);
          $model->updateByPk($id, array('tgl_rekam_medik' => $model->tgl_rekam_medik));
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('admin'));
        }
      }
    }
    $this->render('ubahPasien', array('model' => $model, 'modPegawai' => $modPegawai));
  }
  public function actionUbahRujukan($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $modRujukan = RKRujukanT::model()->findByAttributes(array('asalrujukan_id' => $id));

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['RKRujukanT'])) {
      $modRujukan->attributes = $_POST['RKRujukanT'];
      if ($_POST['RKRujukanT']['tanggal_rujukan'] == "") {
        $modRujukan->tanggal_rujukan = MyFormatter::formatDateTimeForDb(date('d-M-Y'));
      }
      if ($modRujukan->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $modRujukan->rujukan_id));
      }
    }

    $this->render('ubahRujukan', array(
      'modRujukan' => $modRujukan,
    ));
  }

  public function actionGetRiwayatPasien($id)
  {
    //            $this->layout='//layouts/iframe';
    $criteria = new CDbCriteria;
    if (!empty($id)) {
      $criteria->addCondition("t.pasien_id = " . $id);
    }

    $pages = new CPagination(RKPendaftaranT::model()->count($criteria));
    $pages->pageSize = Params::JUMLAH_PERHALAMAN; //Yii::app()->params['postsPerPage'];
    $pages->applyLimit($criteria);

    $modKunjungan = RKPendaftaranT::model()->with('hasilpemeriksaanlab', 'anamnesa', 'pemeriksaanfisik', 'pasienmasukpenunjang', 'diagnosa')->findAll($criteria);


    $this->render('/_periksaDataPasien/_riwayatPasien', array(
      'pages' => $pages,
      'modKunjungan' => $modKunjungan,
    ));
  }

  public function actionDetailTindakan($id)
  {
    //            $this->layout='//layouts/iframe';
    $modPendaftaran = RKPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modTindakan = RKTindakanpelayananT::model()->with('daftartindakan')->findAllByAttributes(array('pendaftaran_id' => $id));
    $format = new MyFormatter;
    $modTindakanSearch = new RKTindakanpelayananT('search');
    $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      '/_periksaDataPasien/_tindakan',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modTindakan' => $modTindakan,
        'modTindakanSearch' => $modTindakanSearch,
        'modPasien' => $modPasien
      )
    );
  }

  public function actionDetailHasilLab($id)
  {
    //            $this->layout='//layouts/iframe';
    $modPendaftaran = RKPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modHasilLab = HasilpemeriksaanlabT::model()->findByAttributes(array('pendaftaran_id' => $id));
    $modDetailHasilLab = DetailhasilpemeriksaanlabT::model()->with('pemeriksaanlab')->findAllByAttributes(array('hasilpemeriksaanlab_id' => $modHasilLab->hasilpemeriksaanlab_id));
    $modDetailHasil = new DetailhasilpemeriksaanlabT();
    $format = new MyFormatter;
    $modHasilLab->tglhasilpemeriksaanlab = $format->formatDateTimeId($modHasilLab->tglhasilpemeriksaanlab);

    $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      '/_periksaDataPasien/detailHasilLab',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modHasilLab' => $modHasilLab,
        'modDetailHasilLab' => $modDetailHasilLab,
        'modDetailHasil' => $modDetailHasil,
        'modPasien' => $modPasien
      )
    );
  }

  public function actionDetailTerapi($id)
  {
    //            $this->layout='//layouts/iframe';
    $modPendaftaran = RKPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modTerapi = PenjualanresepT::model()->with('reseptur')->findAllByAttributes(array('pendaftaran_id' => $id));
    $format = new MyFormatter;
    $modDetailTerapi = new PenjualanresepT();
    $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      '/_periksaDataPasien/_terapi',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modTerapi' => $modTerapi,
        'modDetailTerapi' => $modDetailTerapi,
        'modPasien' => $modPasien
      )
    );
  }

  public function actionDetailPemakaianBahan($id)
  {
    //            $this->layout='//layouts/iframe';
    $modPendaftaran = RKPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modBahan = ObatalkespasienT::model()->with('obatalkes')->findAllByAttributes(array('pendaftaran_id' => $id));
    $format = new MyFormatter;
    $modPemakaianBahan = new ObatalkespasienT;
    $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);
    $this->render(
      '/_periksaDataPasien/_pemakaianBahan',
      array(
        'modPendaftaran' => $modPendaftaran,
        'modBahan' => $modBahan,
        'modPemakaianBahan' => $modPemakaianBahan,
        'modPasien' => $modPasien
      )
    );
  }

  /**
   * method to change penanggung jawab if penanggungjawab_id is not null if null this method will create new row in table penanggungjawab_m
   * digunakan pada :
   * 1. Modul Rekam Medis -> informasi pasien baru -> ubah penanggung jawab
   * @param type $id penanggungjawab_id default null
   * @throws CHttpException if user doesn't have enough access to create or update
   */
  public function actionUbahPenanggungJawab($id = null, $pendaftaran_id = null)
  {
    //            if (!empty($id)) {
    //                if (!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) {
    //                    throw new CHttpException(401, Yii::t('mds', 'You are prohibited to access this page. Contact Super Administrator'));
    //                }
    //                /*
    //                 * GET penanggungjawab_id berdasarkan no_rekam_medik dari tabel pendaftaran_t
    //                 */
    //                $model = PenanggungjawabM::model()->findByPk($id);
    //            } else if (isset($pendaftaran_id)){
    //                if (!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) {
    //                    throw new CHttpException(401, Yii::t('mds', 'You are prohibited to access this page. Contact Super Administrator'));
    //                }
    //                $model = new PenanggungjawabM();
    //            }
    if ($id != null)
      $model = PenanggungjawabM::model()->findByPk($id);
    else
      $model = new PenanggungjawabM();


    if (isset($_POST['PenanggungjawabM'])) {
      $model->attributes = $_POST['PenanggungjawabM'];
      $model->tgllahir_pj = MyFormatter::formatDateTimeForDb($_POST['PenanggungjawabM']['tgllahir_pj']);
      if (!isset($id) && (isset($pendaftaran_id))) {
        if ($model->validate()) {
          if ($_POST['PenanggungjawabM']['tgllahir_pj'] == "") {
            $model->tgllahir_pj = MyFormatter::formatDateTimeForDb(date('d-M-Y'));
          }
          if ($model->save()) {

            $updatePendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, array('penanggungjawab_id' => $model->penanggungjawab_id));
            if ($updatePendaftaran) {
              Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
              $this->redirect(array('admin', 'sukses' => 1));
            }
          }
        }
      } else {
        if ($model->save()) {
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('admin', 'sukses' => 1));
        }
      }
    }

    $this->render('ubahPenanggungJawab', array('model' => $model));
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


    if (isset($_POST['RKInfoPasienLamaV'])) {
      $model->attributes = $_POST['RKInfoPasienLamaV'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->pendaftaran_id));
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
    $dataProvider = new CActiveDataProvider('RKInfoPasienLamaV');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Lama";
    $format = new MyFormatter();
    $model = new RKInfoPasienLamaV;
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    if (isset($_REQUEST['RKInfoPasienLamaV'])) {
      $model->attributes = $_REQUEST['RKInfoPasienLamaV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RKInfoPasienLamaV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RKInfoPasienLamaV']['tgl_akhir']);
    }

    //                $modPPInfoKunjunganRJV->tgl_awal = Yii::app()->dateFormatter->formatDateTime(
    //                                        CDateTimeParser::parse($modPPInfoKunjunganRJV->tgl_awal, 'yyyy-MM-dd hh:mm:ss'));
    //                $modPPInfoKunjunganRJV->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(
    //                                        CDateTimeParser::parse($modPPInfoKunjunganRJV->tgl_akhir, 'yyyy-MM-dd hh:mm:ss'));  

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Manages all models.
   */

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = RKInfoPasienLamaV::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }
  public function loadModel2($id)
  {
    $model = RKPasienM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'rminfo-pasien-baru-v-form') {
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
    $model = new RKInfoPasienLamaV;
    $model->attributes = $_REQUEST['RKInfoPasienLamaV'];
    $judulLaporan = 'Data RKInfoPasienLamaV';
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

  /**
   * Action Ajax untuk mengubah ruangan / poliklinik
   */
  public function actionGetRuanganPasien()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
      $instalasi_id = (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
      $pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null);

      if (isset($_POST['jeniskasuspenyakit_id'])) {
        $jeniskasuspenyakit_id = (isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null);
        $jenisKasusPenyakit = '';
        $criteria = new CDbCriteria;
        $criteria->select = 't.ruangan_id, t.jeniskasuspenyakit_id, ruangan_m.ruangan_nama, jeniskasuspenyakit_m.jeniskasuspenyakit_nama,
                                    jeniskasuspenyakit_aktif';
        if (!empty($ruangan_id)) {
          $criteria->addCondition("t.ruangan_id = " . $ruangan_id);
        }
        if (!empty($jeniskasuspenyakit_id)) {
          $criteria->addCondition('t.jeniskasuspenyakit_id = ' . $jeniskasuspenyakit_id);
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
        $pegawai_id = $_POST['pegawai_id'];
        $ruangan_id = $_POST['ruangan_id'];
        $criteria = new CDbCriteria;
        $criteria->select = 't.ruangan_id, t.pegawai_id, t.nama_pegawai';
        if (!empty($ruangan_id)) {
          $criteria->addCondition("t.ruangan_id = " . $ruangan_id);
        }
        if (!empty($jeniskasuspenyakit_id)) {
          $criteria->addCondition('t.pegawai_id = ' . $pegawai_id);
        }
        $dataDokter = DokterV::model()->findAll($criteria);
        //                $dataJenisPenyakit =KasuspenyakitruanganM::model()->findAll('jeniskasuspenyakit_id='.$jeniskasuspenyakit_id.' AND jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama');
        $dokter = '';
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
      $dataRuangan = RuanganM::model()->findAll('instalasi_id=' . $instalasi_id . ' AND ruangan_aktif=TRUE ORDER BY ruangan_nama');
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
   * action ajax untuk mengubah kelas pelayanan
   */
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
        'div' => $this->renderPartial('_formUbahKelasPelayanan', array('model' => $model, 'menu' => $menu), true)
      ));
      exit;
    }
  }

  /**
   * method untuk pindah ruangan poli klinik
   * digunakan di :
   * 1. Rekam Medis -> Informasi Pasien Lama -> Ruangan / Poliklinik
   */
  public function actionSaveRuanganBaru()
  {
    $updatetindakan = false;
    $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
    $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
    $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
    $jeniskasuspenyakit_id = (isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null);
    $alasan = (isset($_POST['alasan']) ? $_POST['alasan'] : null);
    $ruangan_awal = (isset($_POST['ruangan_awal']) ? $_POST['ruangan_awal'] : null);
    $idTindakan = (isset($_POST['idTindakan']) ? $_POST['idTindakan'] : null);
    $tarifSatuan = (isset($_POST['tarifSatuan']) ? $_POST['tarifSatuan'] : null);
    $idKarcis = (isset($_POST['idKarcis']) ? $_POST['idKarcis'] : null);
    $tarifkarcis = (isset($_POST['tarifkarcis']) ? $_POST['tarifkarcis'] : null);
    $kelas = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
    $karcisTindakan = (isset($_POST['karcisTindakan']) ? $_POST['karcisTindakan'] : null);
    $modPasien = PasienM::model()->findByPk($pasien_id);
    $model = PendaftaranT::model()->findByPk($pendaftaran_id);
    if (!empty($model->pegawai_id)) {
      $pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null);
    } else {
      $pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : $model->pegawai_id);
    }

    //            $pegawai_id = (!isset($_POST['pegawai_id']) && ($_POST['pegawai_id'] == 'null') ? $model->pegawai_id : $_POST['pegawai_id']);
    $modRiwayat = new UbahruanganR;
    $modRiwayat->ruanganawal_id = $ruangan_awal;
    $modRiwayat->menjadiruangan_id = $ruangan_id;
    $modRiwayat->alasanperubahan = $alasan;
    $modRiwayat->pendaftaran_id = $pendaftaran_id;
    $modRiwayat->tglperubahan = date('Y-m-d');
    $modRiwayat->pasien_id = $pasien_id;

    $data = array();
    $transaction = Yii::app()->db->beginTransaction();
    try {
      $success = false;
      if ($modRiwayat->validate()) {
        if (isset($_POST['pasienadmisi_id'])) {
          if (PasienadmisiT::model()->updateByPk($_POST['pasienadmisi_id'], array('ruangan_id' => $ruangan_id))) {
            $update = true;
            $success = true;
            $data['status'] = 'OK';
          }
        } else {
          if (PendaftaranT::model()->updateByPk($pendaftaran_id, array('ruangan_id' => $ruangan_id, 'jeniskasuspenyakit_id' => $jeniskasuspenyakit_id, 'pegawai_id' => $pegawai_id))) {
            $model->ruangan_id = $ruangan_id;
            $update = true;
            $success = true;
            $data['status'] = 'OK';
          }
        }

        if ($update && $success) {
          if ($modRiwayat->save()) {
            $data['status'] = 'OK';
          } else {
            $success = false;
            $data['status'] = 'Gagal';
          }
        } else {
          $success = false;
          $data['status'] = 'Gagal';
        }
      } else {
        $data['status'] = 'Gagal';
        echo print_r($modRiwayat->errors, 1);
      }

      if ($success) {
        $transaction->commit();
      } else {
        $transaction->rollback();
      }
    } catch (Exception $exc) {
      $data['status'] = 'Gagal' . $exc;
      $transaction->rollback();
    }

    echo CJSON::encode($data);
    Yii::app()->end();
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
      $modPasien = new RKPasienM;
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
      $modPasien = new RKPasienM;
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
      $modPasien = new RKPasienM;
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
      $modPasien = new RKPasienM;
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

  public function actionListDokterRuangan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      if (!empty($_POST['idRuangan'])) {
        $idRuangan = $_POST['idRuangan'];
        $data = DokterV::model()->findAllByAttributes(array('ruangan_id' => $idRuangan), array('order' => 'nama_pegawai'));
        $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');

        if (empty($data)) {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($data as $value => $name) {
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
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
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

  public function actionAutocompleteNobadge()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_badge = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)', strtolower($no_badge), true);
      $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id";
      $criteria->order = 'pegawai_m.nomorindukpegawai, t.nama_pasien';
      $criteria->limit = 50;
      $models = RKPasienM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->pegawai->nomorindukpegawai .
          ' - ' . $model->no_rekam_medik .
          ' - ' . $model->nama_pasien .
          ' - (' . $model->pegawai->nama_pegawai .
          ') - ' . $format->formatDateTimeForUser($model->tanggal_lahir);
        $returnVal[$i]['value'] = $model->pegawai->nomorindukpegawai;
      }

      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  public function actionSetNobadge()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $nip = null;
      $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
      $models = RKPegawaiM::model()->findByPk($pegawai_id);
      if (!empty($models)) {
        $nip = $models->nomorindukpegawai;
      }
      echo CJSON::encode($nip);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }
}
