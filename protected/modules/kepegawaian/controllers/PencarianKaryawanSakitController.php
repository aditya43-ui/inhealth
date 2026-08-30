<?php

class PencarianKaryawanSakitController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'cariPasien';
  public $pathView = 'kepegawaian.views.pencarianKaryawanSakit.';

  /**
   * @return array action filters
   */
  public function filters()
  {
    return array(
      'accessControl', // perform access control for CRUD operations
    );
  }

  /**
   * Specifies the access control rules.
   * This method is used by the 'accessControl' filter.
   * @return array access control rules
   */
  public function accessRules()
  {
    return array(
      array(
        'allow',  // allow all users to perform 'index' and 'view' actions
        'actions' => array('index', 'view', 'myBarcode'),
        'users' => array('@'),
      ),
      array(
        'allow', // allow authenticated user to perform 'create' and 'update' actions
        'actions' => array('create', 'update'),
        'users' => array('@'),
      ),
      array(
        'allow', // allow admin user to perform 'admin' and 'delete' actions
        'actions' => array('CariPasien', 'PrintKartu', 'UbahPasien', 'UbahPenanggungJawab', 'DaftarPjP'),
        'users' => array('@'),
      ),
      array(
        'deny',  // deny all users
        'users' => array('*'),
      ),
    );
  }

  public function actions()
  {
    return array(
      'myBarcode' => array(
        'class' => 'MyBarcodeAction',
        'canvasWidth' => '300',
        'type' => 'code128',
      ),
    );
  }

  public function actionCariPasien()
  {
    $this->pageTitle = Yii::app()->name . " - Pencarian Pegawai Sakit";
    //                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_OPERATING)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));} 
    $cek = null;
    $format = new MyFormatter();
    $modProp = PropinsiM::model()->findAll(array('order' => 'propinsi_nama'));
    $modKab =  KabupatenM::model()->findAll(array('order' => 'kabupaten_nama'));
    $modKec =  KecamatanM::model()->findAll(array('order' => 'kecamatan_nama'));
    $modKel =  KelurahanM::model()->findAll(array('order' => 'kelurahan_nama'));
    $model = new InformasipasienpegawaiV;
    $model->tgl_rm_awal = date('Y-m-d');
    $model->tgl_rm_akhir = date('Y-m-d');
    $modPendaftaran = new PendaftaranT();
    //$modPendaftaran->pasien_id = 0;
    /*
                 * Proses Pencarian
                 */
    if (isset($_GET['PendaftaranT']) && $_GET['ajax'] == 'pencarianlistkunjungan-grid') {
      $modPendaftaran->pasien_id = $_GET['PendaftaranT']['pasien_id'];
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $this->render($this->pathView . '_gridListKunjungan', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien));
      Yii::app()->end();
    }

    if (isset($_GET['InformasipasienpegawaiV'])) {
      $model->attributes = $_GET['InformasipasienpegawaiV'];
      $model->tgl_rm_awal  = $format->formatDateTimeForDB($_REQUEST['InformasipasienpegawaiV']['tgl_rm_awal']);
      $model->tgl_rm_akhir = $format->formatDateTimeForDB($_REQUEST['InformasipasienpegawaiV']['tgl_rm_akhir']);
      //$model->ceklis = $_REQUEST['InformasipasienpegawaiV']['ceklis'];
    }
    if (isset($_REQUEST['InformasipasienpegawaiV'])) {
      $model->attributes = $_REQUEST['InformasipasienpegawaiV'];
      $model->tgl_rm_awal  = $format->formatDateTimeForDB($_REQUEST['InformasipasienpegawaiV']['tgl_rm_awal']);
      $model->tgl_rm_akhir = $format->formatDateTimeForDB($_REQUEST['InformasipasienpegawaiV']['tgl_rm_akhir']);
      //$model->ceklis = $_REQUEST['InformasipasienpegawaiV']['ceklis'];

    }
    //                                        $model->tgl_rm_awal = Yii::app()->dateFormatter->formatDateTime(
    //                                                                CDateTimeParser::parse($model->tgl_rm_awal, 'yyyy-MM-dd hh:mm:ss'));
    //                                        $model->tgl_rm_akhir = Yii::app()->dateFormatter->formatDateTime(
    //                                                                CDateTimeParser::parse($model->tgl_rm_akhir, 'yyyy-MM-dd hh:mm:ss'));

    $this->render($this->pathView . 'cariPasien', array(
      'cek' => $cek,
      'model' => $model,
      'modProp' => $modProp,
      'modKab' => $modKab,
      'modKec' => $modKec,
      'modPendaftaran' => $modPendaftaran,
      'modKel' => $modKel,
    ));
  }


  public function actionUbahPenanggungJawab($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    /*
                                 * GET penanggungjawab_id berdasarkan no_rekam_medik dari tabel pendaftaran_t
                                 */
    $model = PenanggungjawabM::model()->findByPk($id);
    if (isset($_POST['PenanggungjawabM'])) {
      $model->attributes = $_POST['PenanggungjawabM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('cariPasien'));
      }
    }
    $this->render($this->pathView . 'ubahPenanggungJawab', array('model' => $model));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model =  KPPasienM::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function actionDaftarPjP($id)
  {
    // echo $pendaftaran_id;
    // exit();
    $this->layout = '//layouts/frameDialog';
    $data['judulLaporan'] = 'Daftar Penanggung Jawab';
    $modPasien = KPPasienM::model()->findByPk($id);
    // $modPendaftaran = PPPendaftaranT::model()->findAllByAttributes(array('pasien_id'=>$id));
    $criteria = new CDbCriteria();
    $criteria->addCondition('t.pasien_id = ' . $id);
    $criteria->order = 'tgl_pendaftaran';
    $modPendaftaran = PPPendaftaranT::model()->findAll($criteria);
    $this->render('pendaftaranPenjadwalan.views.pencarianPasien.listpjp', array('modPasien' => $modPasien, 'data' => $data, 'modPendaftaran' => $modPendaftaran));
  }
}
