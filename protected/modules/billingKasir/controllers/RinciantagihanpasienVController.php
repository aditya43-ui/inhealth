
<?php

class RinciantagihanpasienVController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'billingKasir.views.rinciantagihanpasienV.';

  public function actionIndex()
  {
    //                
    $model = new BKRinciantagihanpasienV('search');
    $model->tgl_awal = date('Y-m-d H:i:s');
    $model->tgl_akhir = date('Y-m-d H:i:s');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['BKRinciantagihanpasienV']))
      $model->attributes = $_GET['BKRinciantagihanpasienV'];

    $this->render('billingKasir.views.rinciantagihanpasienV.index', array(
      'model' => $model,
    ));
  }
  /**
   * actionRincian = menampilkan rincian yang belum lunas
   * @param type $id
   */
  public function actionRincian($id)
  {
    $this->layout = '//layouts/iframe';
    $data['judulLaporan'] = 'Rincian Biaya';
    $modPendaftaran = BKPendaftaranT::model()->findByPk($id);
    $criteria = new CDbCriteria();
    $criteria->addCondition('pendaftaran_id = ' . $id);
    $criteria->addCondition('tindakansudahbayar_id IS NULL'); //belum lunas
    $criteria->order = 'ruangan_id';
    $modRincian = BKRinciantagihanpasienV::model()->findAll($criteria);
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    $this->render('billingKasir.views.rinciantagihanpasienV.rincianNew', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data));
  }

  /**
   * actionRincian = menampilkan rincian yang sudah lunas /bayar
   * @param type $id
   */
  public function actionRincianSudahBayar($id = null, $idpembayaran = null)
  {
    $this->layout = '//layouts/iframe';
    $data['judulLaporan'] = 'Rincian Biaya (Sudah Bayar / Lunas)';
    $modPendaftaran = BKPendaftaranT::model()->findByPk($id);
    $criteria = new CDbCriteria();
    if (!empty($modPendaftaran)) {
      $modPendaftaran->pembayaranpelayanan_id = $idpembayaran;
    }
    if (!empty($id)) {
      $criteria->addCondition('pendaftaran_id = ' . $id);
    }
    $criteria->addCondition('pembayaranpelayanan_id = ' . $idpembayaran);
    $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
    $criteria->order = 'ruangan_id';
    //$modRincian = BKRinciantagihanpasienV::model()->findAll($criteria); 
    $modRincian = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    $this->render('billingKasir.views.rinciantagihanpasienV.rincianNew', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data));
  }

  public function actionRincianHutang($id, $idpembayaran, $caraPrint = null)
  {
    $this->layout = '//layouts/iframe';
    $data['judulLaporan'] = 'Rincian Biaya (Piutang)';
    $modPendaftaran = BKPendaftaranT::model()->findByPk($id);
    $modPembayaran = BKPembayaranpelayananT::model()->findByPk($idpembayaran);
    $modPenjamin = PenjaminpasienM::model()->findByAttributes(array('penjamin_id' => $modPembayaran->penjamin_id));
    $modCarabayar = CarabayarM::model()->findByAttributes(array('carabayar_id' => $modPembayaran->carabayar_id));
    $modBayarangsuranpelayanan = BayarangsuranpelayananT::model()->findByAttributes(array('pembayaranpelayanan_id' => $modPembayaran->pembayaranpelayanan_id));
    $modSuratketjaminan = SuratketjaminanT::model()->findByAttributes(array('pembayaranpelayanan_id' => $modPembayaran->pembayaranpelayanan_id));
    $modTandabuktibayar = TandabuktibayarT::model()->findByAttributes(array('pembayaranpelayanan_id' => $modPembayaran->pembayaranpelayanan_id));
    $criteria = new CDbCriteria();
    $criteria->addCondition('pendaftaran_id = ' . $id);
    $modRincian = BKRinciantagihanpasienberhutangV::model()->findAll($criteria);
    // $modRincian = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);//<<-untuk sementara
    if (!empty(Yii::app()->user->getState('pegawai_id'))) {
      $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    } else {
      $data['nama_pegawai'] = "";
    }

    if (!empty($caraPrint)) {

      if ($caraPrint == 'PDF') {
        $ukuranKertasPDF = 'A';                  //Ukuran Kertas Pdf
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
          $this->renderPartial('billingKasir.views.rinciantagihanpasienV.rincianHutangNew', array(
            'modPendaftaran' => $modPendaftaran,
            'modRincian' => $modRincian,
            'data' => $data,
            'modSuratketjaminan' => $modSuratketjaminan,
            'modTandabuktibayar' => $modTandabuktibayar,
            'modPembayaran' => $modPembayaran,
            'caraPrint' => $caraPrint,
          ))
        );
        $mpdf->Output();

        Yii::app()->end();
      } else if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render('billingKasir.views.rinciantagihanpasienV.rincianHutangNew', array(
          'modPendaftaran' => $modPendaftaran,
          'modRincian' => $modRincian,
          'data' => $data,
          'modSuratketjaminan' => $modSuratketjaminan,
          'modTandabuktibayar' => $modTandabuktibayar,
          'modPembayaran' => $modPembayaran,
          'caraPrint' => $caraPrint,
        ));

        Yii::app()->end();
      }
    }

    $this->render('billingKasir.views.rinciantagihanpasienV.rincianHutangNew', array(
      'modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data,
      'modSuratketjaminan' => $modSuratketjaminan, 'modTandabuktibayar' => $modTandabuktibayar, 'modPembayaran' => $modPembayaran
    ));
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

  public function actionRincianKasirBaruPrint($id, $caraPrint)
  {
    if (!empty($id)) {
      $format = new MyFormatter();
      $this->layout = '//layouts/iframe';
      $data['judulLaporan'] = 'Rincian Biaya ';
      $data['judulPrint'] = 'Rincian Biaya ';
      $criteria = new CDbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $id);
      $criteria->addCondition('tindakansudahbayar_id IS NULL'); //belum lunas
      $criteria->order = 'ruangan_id';
      $modRincian = BKRinciantagihanpasienV::model()->findAll($criteria);
      $modPendaftaran = PendaftaranT::model()->findByPk($id);

      $uangmuka = BayaruangmukaT::model()->findAllByAttributes(
        array('pendaftaran_id' => $id)
      );

      $uang_cicilan = 0;
      foreach ($uangmuka as $val) {
        $uang_cicilan += $val->jumlahuangmuka;
      }

      $data['uang_cicilan'] = $uang_cicilan;
      $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
      $data['jenis_cetakan'] = 'kwitansi';

      if ($caraPrint == 'EXCEL') {
        $this->layout = '//layouts/printExcel';
        $this->render('billingKasir.views.rinciantagihanpasienV.rincianNew', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data, 'format' => $format, 'caraPrint' => $caraPrint));
      } else
                if ($caraPrint == 'PDF') {
        $ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('c', $ukuranKertasPDF);
        //                    //$mpdf->useOddEven = 2;  
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $header_title = '
                        <div>&nbsp;</div>
                        <div style="margin-top:58px;font-family:tahoma;font-size: 8pt;">
                            <div style="margin-left:1px;width:100px;float:left">No. RM / Reg</div>
                            <div style="float:left">: ' . $modPendaftaran->pasien->no_rekam_medik . ' / ' . $modPendaftaran->no_pendaftaran . '</div>
                        </div>
                    ';
        /*
                    $header_title = '
                    <div>as</div>
                    <table width="100%" style="vertical-align: top; font-family:tahoma;font-size: 8pt;">
                    <tr>
                        <td colspan="2" width="50%" style="height:70px;"></td>
                    </tr>
                    <tr>
                    <td width="98" align="left">No. RM / Reg</td>
                    <td align="left">: 147250 / RD1312100008</td>
                    </tr>
                    </table>
                    ';
                     * 
                     */
        $mpdf->SetHTMLHeader($header_title);

        $footer = '
                    <table width="100%" style="vertical-align: top; font-family:tahoma;font-size: 8pt;"><tr>
                    <td width="50%"></td>
                    <td width="50%" align="right">{PAGENO} / {nb}</td>
                    </tr></table>
                    ';
        $mpdf->SetHTMLFooter($footer);

        /*
                     * cara ambil margin
                     * tinggi_header * 72 / (72/25.4)
                     *  tinggi_header = inchi
                     */
        $header = 0.75 * 72 / (72 / 25.4);
        $mpdf->AddPage($posisi, '', '', '', '', 5, 5, $header + 4, 8, 0, 0);
        $mpdf->WriteHTML(
          $this->renderPartial(
            $this->path_view . 'rincianBaruPdf',
            array(
              'modPendaftaran' => $modPendaftaran,
              'modRincian' => $modRincian,
              'data' => $data,
              'format' => $format,
            ),
            true
          )
        );

        $mpdf->Output($data['judulPrint'] . '-' . date('Y/m/d') . '.pdf', 'I');
        exit;
      }
    }
  }
  /**
   * actionRincianKasirSudahBayarPrint = cetak rincian yang sudah bayar / lunas
   * @param type $id
   * @param type $caraPrint
   */
  public function actionRincianKasirSudahBayarPrint($id, $idpembayaran, $caraPrint = null)
  {
    if (!empty($id)) {
      $format = new MyFormatter();
      $this->layout = '//layouts/iframe';
      $data['judulPrint'] = 'Rincian Biaya (Sudah Bayar / Lunas)';
      $judulLaporan = 'Rincian Biaya (Sudah Bayar / Lunas)';
      $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
      $criteria = new CDbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $id);
      $criteria->addCondition('pembayaranpelayanan_id = ' . $idpembayaran);
      $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
      $criteria->order = 'ruangan_id';
      // $modRincian = BKRinciantagihanpasienV::model()->findAll($criteria); 
      $modRincian = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
      $modPendaftaran = PendaftaranT::model()->findByPk($id);

      $uangmuka = BayaruangmukaT::model()->findAllByAttributes(
        array('pendaftaran_id' => $id)
      );

      $uang_cicilan = 0;
      foreach ($uangmuka as $val) {
        $uang_cicilan += $val->jumlahuangmuka;
      }

      $data['uang_cicilan'] = $uang_cicilan;
      $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
      $data['jenis_cetakan'] = 'kwitansi';

      if ($caraPrint == 'PDF') {
        $ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60(
          '',
          $ukuranKertasPDF, //format A4 Or
          11, //Font SIZE
          '', //default font family
          3, //15 margin_left
          3, //15 margin right
          5, //16 margin top
          10, // margin bottom
          0, // 9 margin header
          0, // 9 margin footer
          'P' // L - landscape, P - portrait
        );
        //$mpdf->useOddEven = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        /*
                     * cara ambil margin
                     * tinggi_header * 72 / (72/25.4)
                     *  tinggi_header = inchi
                     */
        //$header = 0.75 * 72 / (72/25.4);
        //$mpdf->AddPage($posisi,'','','','',3,8,$header,5,0,0);
        ///////
        $mpdf->WriteHTML(
          $this->renderPartial(
            'rincianBaruPdf',
            array(
              'modPendaftaran' => $modPendaftaran,
              'modRincian' => $modRincian,
              'data' => $data,
              'format' => $format,
              'judulLaporan' => $judulLaporan,
              'caraPrint' => $caraPrint
            ),
            true
          )
        );
        $mpdf->Output();
      } else if ($caraPrint == 'EXCEL') {
        $this->layout = '//layouts/printExcel';
        $this->render('billingKasir.views.rinciantagihanpasienV.rincianBaruExcel', array(
          'modPendaftaran' => $modPendaftaran,
          'modRincian' => $modRincian,
          'data' => $data,
          'format' => $format,
          'judulLaporan' => $judulLaporan,
          'caraPrint' => $caraPrint
        ));
      }
    }
  }

  public function actionRincianKasirBerhutangPrint($id, $caraPrint)
  {
    if (!empty($id)) {
      $format = new MyFormatter();
      $this->layout = '//layouts/iframe';
      $data['judulPrint'] = 'Rincian Biaya (Sudah Bayar / Lunas)';
      $criteria = new CDbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $id);
      $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
      $criteria->order = 'ruangan_id';
      // $modRincian = BKRinciantagihanpasienV::model()->findAll($criteria); 
      $modRincian = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
      $modPendaftaran = PendaftaranT::model()->findByPk($id);

      $criteria2 = new CDbCriteria();
      $criteria2->addCondition('pendaftaran_id = ' . $id);
      $pembulatan = BKRinciantagihanpasienberhutangV::model()->find($criteria2);

      $uangmuka = BayaruangmukaT::model()->findAllByAttributes(
        array('pendaftaran_id' => $id)
      );

      $uang_cicilan = 0;
      foreach ($uangmuka as $val) {
        $uang_cicilan += $val->jumlahuangmuka;
      }

      $data['uang_cicilan'] = $uang_cicilan;
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
            'rincianBaruPdf',
            array(
              'modPendaftaran' => $modPendaftaran,
              'modRincian' => $modRincian,
              'data' => $data,
              'format' => $format,
              'pembulatan' => $pembulatan
            ),
            true
          )
        );
        $mpdf->Output();
      }
    }
  }

  public function actionPrint()
  {
    $id = $_REQUEST['id'];
    $modPendaftaran = BKPendaftaranT::model()->findByPk($id);
    $modRincian = BKRinciantagihanpasienV::model()->findAllByAttributes(
      array(
        'pendaftaran_id' => $id
      ),
      array('order' => 'ruangan_id')
    );
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    $caraPrint = $_REQUEST['caraPrint'];

    $uangmuka = BayaruangmukaT::model()->findAllByAttributes(
      array('pendaftaran_id' => $id)
    );
    $uang_cicilan = 0;
    foreach ($uangmuka as $val) {
      $uang_cicilan += $val->jumlahuangmuka;
    }
    $data['uang_cicilan'] = $uang_cicilan;
    $data['jenis_cetakan'] = 'rincian_tagihan';

    //$tindakan_pelayanan = BKTindakanPelayananT::model()->findByPk();

    $judulPrint = "RINCIAN BIAYA";
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render(
        'application.views.print.kwitansiPembayaranRincianBaru',
        array(
          'modPendaftaran' => $modPendaftaran,
          'modRincian' => $modRincian,
          'data' => $data,
          'judulPrint' => $judulPrint
        )
      );
      //                $this->render('billingKasir.views.rinciantagihanpasienV.rincianNew', array('modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data, 'caraPrint'=>$caraPrint));
      //$this->render('rincian',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('billingKasir.views.rinciantagihanpasienV.rincianNew', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint));
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
      $mpdf->WriteHTML($this->renderPartial('billingKasir.views.rinciantagihanpasienV.rincianNew', array('modPendaftaran' => $modPendaftaran, 'modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  // ====================================================================    
  //                Rincian Belum Bayar Rawat Jalan   
  //=====================================================================      
  public function actionRincianBelumBayar($id)
  {
    $this->layout = '//layouts/iframe';
    $data['judulLaporan'] = 'Rincian Biaya Pelayanan';
    $criteria = new CDbCriteria();
    $criteria->addCondition('pendaftaran_id = ' . $id);
    $criteria->order = 'ruangantindakan_id';
    $modRincian = RincianbelumbayarrjV::model()->findAll($criteria);
    if (Yii::app()->controller->module->id == 'rawatDarurat') {
      $modRincian = RincianbelumbayarrdV::model()->findAll($criteria);
    }
    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    $this->render('billingKasir.views.rinciantagihanpasienV.rincianBelumBayar', array('modRincian' => $modRincian, 'data' => $data, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien));
  }

  public function actionRincianBelumBayarPrint($id, $caraPrint)
  {
    if (!empty($id)) {
      $format = new MyFormatter();
      $this->layout = '//layouts/iframe';
      $judulLaporan = '';
      $data['judulPrint'] = 'Rincian Biaya Pelayanan';
      $data['judul'] = 'Rincian Biaya Pelayanan RJ';
      $criteria = new CDbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $id);
      $criteria->order = 'ruangantindakan_id';
      $modRincian = RincianbelumbayarrjV::model()->findAll($criteria);
      if (Yii::app()->controller->module->id == 'rawatDarurat') {
        $modRincian = RincianbelumbayarrdV::model()->findAll($criteria);
      }
      $modPendaftaran = PendaftaranT::model()->findByPk($id);
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
      $data['jenis_cetakan'] = 'kwitansi';



      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render(
          'billingKasir.views.rinciantagihanpasienV.rincianBelumBayarPdf',
          array(
            'modRincian' => $modRincian,
            'data' => $data,
            'judulLaporan' => $judulLaporan,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien
          )
        );
      } else
            if ($caraPrint == 'EXCEL') {
        $this->layout = '//layouts/printExcel';
        $this->render('billingKasir.views.rinciantagihanpasienV.rincianBelumBayarPdf', array(
          'modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint, 'judulLaporan' => $judulLaporan,
          'modPendaftaran' => $modPendaftaran,
          'modPasien' => $modPasien
        ));
      } else
            if ($caraPrint == 'PDF') {
        $ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('c', $ukuranKertasPDF);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $footer = '
                <table width="100%" style="vertical-align: top; font-family:tahoma;font-size: 8pt;"><tr>
                <td width="50%"></td>
                <td width="50%" align="right">{PAGENO} / {nb}</td>
                </tr></table>
                ';
        $mpdf->SetHTMLFooter($footer);

        $header = 0.75 * 72 / (72 / 25.4);
        $mpdf->AddPage($posisi, '', '', '', '', 5, 5, $header + 4, 8, 0, 0);
        $mpdf->WriteHTML(
          $this->renderPartial(
            'billingKasir.views.rinciantagihanpasienV.rincianBelumBayarPdf',
            array(
              'modRincian' => $modRincian,
              'data' => $data,
              'format' => $format,
              'judulLaporan' => $judulLaporan,
              'modPendaftaran' => $modPendaftaran,
              'modPasien' => $modPasien
            ),
            true
          )
        );
        $mpdf->Output();
        exit;
      }
    }
  }

  //=====================================================================    
  //                Rincian Pasien Belum Bayar Rawat Darurat
  //=====================================================================      
  public function actionRincianBelumBayarRD($id)
  {
    $this->layout = '//layouts/iframe';
    $data['judulLaporan'] = 'Rincian Biaya Pelayanan';
    // $modPendaftaran = BKPendaftaranT::model()->findByPk($id);
    $criteria = new CDbCriteria();
    $criteria->addCondition('pendaftaran_id = ' . $id);
    $criteria->order = 'ruangantindakan_id';
    $modRincian = RincianbelumbayarrdV::model()->findAll($criteria);
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    $this->render('billingKasir.views.rinciantagihanpasienV.rincianBelumBayarRD', array('modRincian' => $modRincian, 'data' => $data));
  }

  public function actionRincianBelumBayarRDPrint($id, $caraPrint)
  {
    if (!empty($id)) {
      $format = new MyFormatter();
      $this->layout = '//layouts/iframe';
      $judulLaporan = '';
      $data['judulPrint'] = 'Rincian Biaya Pelayanan';
      $data['judul'] = 'Rincian Biaya Pelayanan RD';
      $criteria = new CDbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $id);
      $criteria->order = 'ruangantindakan_id';
      $modRincian = RincianbelumbayarrdV::model()->findAll($criteria);

      $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
      $data['jenis_cetakan'] = 'kwitansi';

      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render(
          'billingKasir.views.rinciantagihanpasienV.rincianBelumBayarRDPdf',
          array(
            'modRincian' => $modRincian,
            'data' => $data,
            'judulLaporan' => $judulLaporan
          )
        );
      } else
            if ($caraPrint == 'EXCEL') {
        $this->layout = '//layouts/printExcel';
        $this->render('billingKasir.views.rinciantagihanpasienV.rincianBelumBayarRDPdf', array('modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint, 'judulLaporan' => $judulLaporan));
      } else
            if ($caraPrint == 'PDF') {
        $ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('c', $ukuranKertasPDF);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $header_title = '
                    <div>&nbsp;</div>
                    <div style="margin-top:58px;font-family:tahoma;font-size: 8pt;">
                        <div style="margin-left:1px;width:100px;float:left">No. RM / Reg</div>
                        <div style="float:left">: ' . $modRincian->no_rekam_medik . ' / ' . $modRincian->no_pendaftaran . '</div>
                    </div>
                ';

        $footer = '
                <table width="100%" style="vertical-align: top; font-family:tahoma;font-size: 8pt;"><tr>
                <td width="50%"></td>
                <td width="50%" align="right">{PAGENO} / {nb}</td>
                </tr></table>
                ';
        $mpdf->SetHTMLFooter($footer);

        $header = 0.75 * 72 / (72 / 25.4);
        $mpdf->AddPage($posisi, '', '', '', '', 5, 5, $header + 4, 8, 0, 0);
        $mpdf->WriteHTML(
          $this->renderPartial(
            'rincianBelumBayarRDPdf',
            array(
              'modRincian' => $modRincian,
              'data' => $data,
              'format' => $format,
              'judulLaporan' => $judulLaporan
            ),
            true
          )
        );
        $mpdf->Output();
        exit;
      }
    }
  }

  //=====================================================================    
  //                Rincian Pasien Belum Bayar Rawat Inap
  //=====================================================================      
  public function actionRincianBelumBayarRI($id)
  {
    $this->layout = '//layouts/iframe';
    $data['judulLaporan'] = 'Rincian Biaya Pelayanan';
    // $modPendaftaran = BKPendaftaranT::model()->findByPk($id);
    $criteria = new CDbCriteria();
    $criteria->addCondition('pendaftaran_id = ' . $id);
    $criteria->order = 'ruangantindakan_id';
    $modRincian = RincianbelumbayarrawatinapV::model()->findAll($criteria);
    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    $this->render('billingKasir.views.rinciantagihanpasienV.rincianBelumBayarRI', array('modRincian' => $modRincian, 'data' => $data, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modPasienAdmisi' => $modPasienAdmisi));
  }

  public function actionRincianBelumBayarRIPrint($id, $caraPrint = null)
  {
    if (!empty($id)) {
      $format = new MyFormatter();
      $this->layout = '//layouts/iframe';
      $judulLaporan = '';
      $data['judulPrint'] = 'Rincian Biaya Pelayanan';
      $data['judul'] = 'Rincian Biaya Pelayanan Ranap';
      $criteria = new CDbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $id);
      $criteria->order = 'ruangantindakan_id';
      $modRincian = RincianbelumbayarrawatinapV::model()->findAll($criteria);
      $modPendaftaran = PendaftaranT::model()->findByPk($id);
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

      $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
      $data['jenis_cetakan'] = 'kwitansi';

      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render(
          'billingKasir.views.rinciantagihanpasienV.rincianBelumBayarRIPdf',
          array(
            'modRincian' => $modRincian,
            'data' => $data,
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modPasienAdmisi' => $modPasienAdmisi,
            'judulLaporan' => $judulLaporan
          )
        );
      } else
            if ($caraPrint == 'EXCEL') {
        $this->layout = '//layouts/printExcel';
        $this->render('billingKasir.views.rinciantagihanpasienV.rincianBelumBayarRIPdf', array('modRincian' => $modRincian, 'data' => $data, 'caraPrint' => $caraPrint, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modPasienAdmisi' => $modPasienAdmisi, 'judulLaporan' => $judulLaporan));
      } else
            if ($caraPrint == 'PDF') {
        $ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('c', $ukuranKertasPDF);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $header_title = '
                    <div>&nbsp;</div>
                    <div style="margin-top:58px;font-family:tahoma;font-size: 8pt;">
                        <div style="margin-left:1px;width:100px;float:left">No. RM / Reg</div>
                        <div style="float:left">: ' . $modRincian->no_rekam_medik . ' / ' . $modRincian->no_pendaftaran . '</div>
                    </div>
                ';

        $footer = '
                <table width="100%" style="vertical-align: top; font-family:tahoma;font-size: 8pt;"><tr>
                <td width="50%"></td>
                <td width="50%" align="right">{PAGENO} / {nb}</td>
                </tr></table>
                ';
        $mpdf->SetHTMLFooter($footer);

        $header = 0.75 * 72 / (72 / 25.4);
        $mpdf->AddPage($posisi, '', '', '', '', 5, 5, $header + 4, 8, 0, 0);
        $mpdf->WriteHTML(
          $this->renderPartial(
            'rincianBelumBayarRIPdf',
            array(
              'modRincian' => $modRincian,
              'data' => $data,
              'format' => $format,
              'modPendaftaran' => $modPendaftaran,
              'modPasien' => $modPasien,
              'modPasienAdmisi' => $modPasienAdmisi,
              'judulLaporan' => $judulLaporan
            ),
            true
          )
        );
        $mpdf->Output();
        exit;
      }
    }
  }
}
