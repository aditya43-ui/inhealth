
<?php

class RinciantagihanpasienLabController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  public function actionIndex()
  {
    //                
    $model = new BKRinciantagihanpasienpenunjangV('search');
    $model->tgl_awal = date('Y-m-d H:i:s');
    $model->tgl_akhir = date('Y-m-d H:i:s');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['BKRinciantagihanpasienpenunjangV']))
      $model->attributes = $_GET['BKRinciantagihanpasienpenunjangV'];

    $this->render('billingKasir.views.rinciantagihanpasienLab.index', array(
      'model' => $model,
    ));
  }

  public function actionRincian($pembayaranpelayanan_id = null, $id)
  {
    $this->layout = '//layouts/iframe';
    $data['judulLaporan'] = 'Rincian Biaya Sementara';
    // $modPendaftaran = BKPendaftaranT::model()->findByPk($id);
    $criteria = new CDbCriteria();
    $criteria->order = 'ruangan_id';
    $criteria->addCondition('pendaftaran_id = ' . $id);
    if (empty($pembayaranpelayanan_id)) {
      $criteria->addCondition('tindakansudahbayar_id IS NULL'); //belum lunas rincianpemeriksaanlabrad_v RincianpemeriksaanlabradV
      $modRincian = BKRinciantagihanpasienpenunjangV::model()->findAll($criteria);
    } else {
      // $criteria->addCondition('tindakansudahbayar_id > 0'); //sudah lunas rinciantagihapasiensudahbayar_v
      $modRincian = RinciantagihapasiensudahbayarV::model()->findAll($criteria);
    }
    $modRincianTagihan = RinciantagihanpasienV::model()->find('pendaftaran_id = ' . $id . ' and tindakansudahbayar_id is null');
    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $lp = LoginpemakaiK::model()->findByPK(Yii::app()->user->id);
    $data['nama_pegawai'] = empty($lp->pegawai_id) ? "" : $lp->pegawai->nama_pegawai;

    $this->render(
      'billingKasir.views.rinciantagihanpasienLab.rincian',
      array(
        'modRincian' => $modRincian, 'data' => $data,
        'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modRincianTagihan' => $modRincianTagihan
      )
    );
  }

  public function actionRincianKasirLabPrint($id, $caraPrint)
  {
    if (!empty($id)) {
      $format = new MyFormatter();
      $this->layout = '//layouts/iframe';
      $data['judulPrint'] = 'Rincian Biaya Sementara';
      $data['judulLaporan'] = 'Rincian Biaya Sementara';
      $criteria = new CDbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $id);
      $criteria->addCondition('tindakansudahbayar_id IS NULL'); //belum lunas
      $criteria->order = 'ruangan_id';
      $modRincian = BKRinciantagihanpasienpenunjangV::model()->findAll($criteria);
      $modRincianTagihan = RinciantagihanpasienV::model()->find('pendaftaran_id = ' . $id . ' and tindakansudahbayar_id is null');
      $modPendaftaran = BKPendaftaranT::model()->findByPk($id);
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $lp = LoginpemakaiK::model()->findByPK(Yii::app()->user->id);
      $data['nama_pegawai'] = empty($lp->pegawai_id) ? "" : $lp->pegawai->nama_pegawai;
      $data['jenis_cetakan'] = 'kwitansi';

      if ($caraPrint == 'PDF') {
        $ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        //$mpdf->useOddEven = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        /*
                     * cara ambil margin
                     * tinggi_header * 72 / (72/25.4)
                     *  tinggi_header = inchi
                     */
        $header = 0.75 * 72 / (72 / 25.4);
        $mpdf->AddPage($posisi, '', '', '', '', 3, 8, $header, 5, 0, 0);
        $mpdf->WriteHTML(
          $this->renderPartial(
            'rincianPdf',
            array(
              'modPendaftaran' => $modPendaftaran,
              'modRincian' => $modRincian,
              'data' => $data,
              'format' => $format,
              'modRincianTagihan' => $modRincianTagihan,
              'modPendaftaran' => $modPendaftaran,
            ),
            true
          )
        );
        $mpdf->Output();
      } elseif ($caraPrint == 'EXCEL') {
        //                    echo $caraPrint;exit;
        $this->render(
          'rincianNew',
          array(
            'modPendaftaran' => $modPendaftaran,
            'modRincian' => $modRincian,
            'data' => $data,
            'format' => $format,
            'modRincianTagihan' => $modRincianTagihan,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'caraPrint' => $caraPrint,
          ),
          true
        );
      } else {
        $this->layout = '//layouts/printWindows';
        $this->render(
          'rincianNew',
          array(
            'modPendaftaran' => $modPendaftaran,
            'modRincian' => $modRincian,
            'data' => $data,
            'format' => $format,
            'modRincianTagihan' => $modRincianTagihan,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'caraPrint' => $caraPrint,
          )
        );
      }
    }
  }
  /**
   * actionRincianKasirSudahBayarPrint = cetak rincian yang sudah bayar / lunas
   * @param type $id
   * @param type $caraPrint
   */
  public function actionRincianKasirLabSudahBayarPrint($id, $caraPrint)
  {
    if (!empty($id)) {
      $format = new MyFormatter();
      $this->layout = '//layouts/iframe';
      $data['judulPrint'] = 'Rincian Biaya (Sudah Bayar / Lunas)';
      $criteria = new CDbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $id);
      $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
      $criteria->order = 'ruangan_id';
      $modRincian = RinciantagihapasiensudahbayarV::model()->findAll($criteria);

      $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
      $data['jenis_cetakan'] = 'kwitansi';

      if ($caraPrint == 'PDF') {
        $ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        //$mpdf->useOddEven = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        /*
                     * cara ambil margin
                     * tinggi_header * 72 / (72/25.4)
                     *  tinggi_header = inchi
                     */
        $header = 0.75 * 72 / (72 / 25.4);
        $mpdf->AddPage($posisi, '', '', '', '', 3, 8, $header, 5, 0, 0);
        $mpdf->WriteHTML(
          $this->renderPartial(
            'rincianPdf',
            array(
              'modRincian' => $modRincian,
              'data' => $data,
              'format' => $format,
            ),
            true
          )
        );
        $mpdf->Output();
      }
    }
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = BKRinciantagihanpasienV::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'rjrinciantagihanpasien-v-form') {
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
    $id = $_REQUEST['id'];
    $modPendaftaran = BKPendaftaranT::model()->findByPk($id);
    $modRincian = BKRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $id), array('order' => 'ruangan_id'));
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    $data['judulLaporan'] = 'Rincian Biaya Sementara';
    $caraPrint = $_REQUEST['caraPrint'];

    $uangmuka = BayaruangmukaT::model()->findAllByAttributes(
      array('pendaftaran_id' => $id)
    );
    $uang_cicilan = 0;
    foreach ($uangmuka as $val) {
      $uang_cicilan += $val->jumlahuangmuka;
    }
    $data['uang_cicilan'] = $uang_cicilan;

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('billingKasir.views.rinciantagihanpasienLab.rincianNew', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint));
      //$this->render('rincian',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('billingKasir.views.rinciantagihanpasienLab.rincianNew', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $style = '<style>.control-label{float:left; text-align: right; width:140px;font-size:12px; color:black;padding-right:10px;  }</style>';
      $mpdf->WriteHTML($style, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('billingKasir.views.rinciantagihanpasienLab.rincianNew', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
