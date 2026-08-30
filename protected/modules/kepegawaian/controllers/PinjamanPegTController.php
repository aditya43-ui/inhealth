<?php

class PinjamanPegTController extends MyAuthController
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
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate($id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Peminjaman";
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new KPPinjamanPegT;
    $modPegawai = new KPPegawaiM();
    $modPinjamDetail = new KPPinjamPegDetT();
    $model->nopinjam = '-- Otomatis --';
    if (!empty($id)) {
      $model = KPPinjamanPegT::model()->findByPk($id);
      $modPegawai = KPPegawaiM::model()->findByPk($model->pegawai_id);
      $modPinjamDetail = KPPinjamPegDetT::model()->findAllbyAttributes(array('pinjamanpeg_id' => $id));
      $modPegawai->tgl_lahirpegawai = MyFormatter::formatDateTimeForUser($modPegawai->tgl_lahirpegawai);
    }

    $format = new MyFormatter();

    if (isset($_POST['KPPinjamanPegT'])) {
      $model->attributes = $_POST['KPPinjamanPegT'];
      $model->pegawai_id = $_POST['KPPegawaiM']['pegawai_id'];
      $idpegawai = $_POST['KPPegawaiM']['pegawai_id'];
      $model->tglpinjampeg = $format->formatDateTimeForDb($_POST['KPPinjamanPegT']['tglpinjampeg']);
      $model->tgljatuhtempo = $format->formatDateTimeForDb($_POST['KPPinjamanPegT']['tgljatuhtempo']);
      $model->nopinjam = MyGenerator::noPinjamPegawai();
      //var_dump($model->nopinjam);die;
      //$modPegawai = KPPegawaiM::model()->findByPk($idpegawai);

      $model->sisapinjaman = 0;
      $params['komponengaji_id'] = Params::KOMPONENGAJI_ID_PINJAMAN;
      $model->komponengaji_id = $params['komponengaji_id'];

      $model->lamapinjambln = $_POST['KPPinjamanPegT']['lamapinjambln'];
      $angsuranke     = $_POST['angsuranke'];

      // echo"<pre>";
      // print_r($model->attributes);
      // exit();

      if (empty($_POST['angsuranke'])) {
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Anda belum men-generate tabel angsuran pembayaran.');
      } else {

        if ($model->save()) {
          $i = 1;
          foreach ($angsuranke as $angsuran => $data) {
            $modPinjamDetail = new KPPinjamPegDetT();
            $tgl[$i]            = $_POST['tglakanbayar'][$i];
            //var_dump($_POST['tglakanbayar'][$i]);
            //die;
            $cicilan[$i]        = $_POST['jmlcicilan'][$i];
            $modPinjamDetail->angsuranke        = $data;
            //$tgla                               = date_create($tgl[$i]);
            //$tgla                               = date_create($tgl[$i]);
            $tgl_db                             = date("Y-m-d", strtotime($tgl[$i]));

            $modPinjamDetail->tglakanbayar      = $tgl_db;
            $modPinjamDetail->jmlcicilan        = $cicilan[$i];
            $modPinjamDetail->pinjamanpeg_id    = $model->pinjamanpeg_id;
            $modPinjamDetail->bulan             = substr($tgl_db, 5, 2);
            //$modPinjamDetail->tahun             = substr($tgl[$i], 11,4);
            $modPinjamDetail->tahun             = substr($tgl_db, 0, 4);
            //var_dump($tgla);die;
            $modPinjamDetail->save();
            $i++;
          }

          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $model->isNewRecord = False;
          $this->redirect(array('create', 'id' => $model->pinjamanpeg_id));
        } else {
          Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
        }
      }
    }
    if (!isset($modPinjamDetail)) {
      $modPinjamDetail = null;
    }

    $this->render('create', array(
      'model' => $model, 'modPegawai' => $modPegawai, 'modPinjamDetail' => $modPinjamDetail,
    ));
  }


  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('KPPinjamanPegT');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */


  public function actionAdmin()
  {
    $model = new KPPinjamanPegT('search');
    $model->tglpinjampeg = date('Y-m-d');
    //$model->tglpresensi_akhir = date('Y-m-d 23:59:59');
    // $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPPinjamanPegT'])) {
      $model->attributes = $_GET['KPPinjamanPegT'];

      $format = new MyFormatter();
      $model->tglpinjampeg = $format->formatDateTimeForDb($model->tglpinjampeg);
    }

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  public function actionPrint()
  {

    $idpinjaman = $_GET['id'];

    $model = KPPinjamanPegT::model()->findByPk($idpinjaman);
    $idpegawai = $model->pegawai_id;

    $modPegawai = KPPegawaiM::model()->findByPk($idpegawai);
    // $model->attributes=$_REQUEST['KPPinjamanPegT'];

    // $modPinjamDetail = KPPinjamPegDetT::model()->findByAttributes(array('pinjamanpeg_id'=>$idpinjaman),array('order'=>'angsuranke'));
    // echo"<pre>";
    // print_r($modPinjamDetail->attributes);
    // exit();          

    $judulLaporan = 'Data Peminjaman';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'modPegawai' => $modPegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'modPegawai' => $modPegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'modPegawai' => $modPegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionInformasi()
  {

    $model = new KPPinjamanPegT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPPinjamanPegT']))
      $model->attributes = $_GET['KPPinjamanPegT'];

    $this->render('informasi', array(
      'model' => $model,
    ));
  }

  public function actionPegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->nama_pegawai . ' - ' . $model->jeniskelamin;
        $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['jabatan_nama'] = (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : '-');
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionPegawaiNip()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nomorindukpegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nomorindukpegawai';
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->nama_pegawai . ' - ' . $model->jeniskelamin;
        $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['jabatan_nama'] = (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : '-');
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionGetDataPegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = PegawaiM::model()->findByAttributes(array('pegawai_id' => $_POST['idPegawai']));
      $post = array(
        'nomorindukpegawai' => $data->nomorindukpegawai,
        'pegawai_id' => $data->pegawai_id,
        'nama_pegawai' => $data->nama_pegawai,
        'tempatlahir_pegawai' =>  $data->tempatlahir_pegawai,
        'tgl_lahirpegawai' => MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai),
        'jabatan_nama' => (isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : ''),
        'pangkat_nama' => (isset($data->pangkat->pangkat_nama) ? $data->pangkat->pangkat_nama : ''),
        'kategoripegawai' => $data->kategoripegawai,
        'kategoripegawaiasal' => $data->kategoripegawaiasal,
        'kelompokpegawai_nama' => (isset($data->kelompokpegawai->kelompokpegawai_nama) ? $data->kelompokpegawai->kelompokpegawai_nama : ''),
        'pendidikan_nama' => (isset($data->pendidikan->pendidikan_nama) ? $data->pendidikan->pendidikan_nama : ''),
        'jeniskelamin' => $data->jeniskelamin,
        'statusperkawinan' => $data->statusperkawinan,
        'alamat_pegawai' => $data->alamat_pegawai,
        'photopegawai' => (!is_null($data->photopegawai) ? $data->photopegawai : ''),
      );
      echo CJSON::encode($post);
      Yii::app()->end();
    }
  }
}
