<?php

class TerimabahanmakanController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

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
  public function actionIndex($idPengajuan = null, $id = null, $sukses = null)
  {
    $this->pageTitle = Yii::app()->name . " - Penerimaan Bahan Makanan";
    $model = new GZTerimabahanmakan;
    $modUangMuka = new UangmukabeliT();

    $model->nopenerimaanbahan = '-- Otomatis --';
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->tglterimabahan = date('d M Y H:i:s');
    $model->totaldiscount = 0;
    $model->biayapajak = 0;
    $model->biayapengiriman = 0;
    $model->biayatransportasi = 0;
    $model->totalharganetto = 0;

    $model->pegawai_id = Yii::app()->user->getState('pegawai_id');

    $modApprovalotorisasiM = ApprovalotorisasiM::model()->find();
    if (isset($modApprovalotorisasiM)) {
      $model->mengetahui_id = $modApprovalotorisasiM->kepalagizi_id;
      $model->mengetahui_nama = $modApprovalotorisasiM->kepalagizi->namaLengkap;
    }

    if (isset($idPengajuan)) {
      $modPengajuan = PengajuanbahanmknT::model()->find('pengajuanbahanmkn_id = ' . $idPengajuan . ' and terimabahanmakan_id is null');
      if (!empty($modPengajuan)) {
        $model->supplier_id = $modPengajuan->supplier_id;
        $modSupp = SupplierM::model()->findByPk($model->supplier_id);
        if (isset($modSupp)) {
          $model->supplier_nama = $modSupp->supplier_nama;
        }
        $model->pajak_id = $modPengajuan->pajak_id;
        $model->pajak_nama = (isset($modPengajuan->pajak) ? $modPengajuan->pajak->pajak_nama : "");

        $model->sumberdanabhn = $modPengajuan->sumberdanabhn;
        $model->pengajuanbahanmkn_id = $modPengajuan->pengajuanbahanmkn_id;
        $modDetailPengajuan = PengajuanbahandetailT::model()->with('golbahanmakanan')->findAllByAttributes(array('pengajuanbahanmkn_id' => $idPengajuan));

        $modUangMuka = UangmukabeliT::model()->findByAttributes(array('pengajuanbahanmkn_id' => $modPengajuan->pengajuanbahanmkn_id));

        if (isset($modUangMuka)) {
          $modUangMuka->tgluangmukabeli = MyFormatter::formatDateTimeForUser($modUangMuka->tgluangmukabeli);
        } else {
          $modUangMuka = new UangmukabeliT();
        }
      }
    }

    if (isset($id)) {
      $model = GZTerimabahanmakan::model()->findByPk($_GET['id']);
      $model->temp_no = $model->nopenerimaanbahan;
      if (!empty($model->mengetahui_id)) {
        $peg = PegawaiM::model()->findByPk($model->mengetahui_id);
        if (!empty($peg)) {
          $model->mengetahui_nama = $peg->namaLengkap;
        }
      }
      //            $modDetailPengajuan = PengajuanbahandetailT::model()->with('golbahanmakanan')->findAllByAttributes(array('pengajuanbahanmkn_id'=>$model->pengajuanbahanmkn_id));
    }

    $modPeg = PegawaiM::model()->findByPk($model->pegawai_id);

    if (isset($modPeg)) {
      $model->pegawai_nama = $modPeg->namaLengkap;
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

    if (isset($_POST['GZTerimabahanmakan'])) {
      $model->attributes = $_POST['GZTerimabahanmakan'];
      $model->nopenerimaanbahan = MyGenerator::noPenerimaanBahan();
      $model->tglterimabahan = MyFormatter::formatDateTimeForDb($_POST['GZTerimabahanmakan']['tglterimabahan']);
      $model->tglsurjalan = (!empty($_POST['GZTerimabahanmakan']['tglsurjalan']) ? MyFormatter::formatDateTimeForDb($_POST['GZTerimabahanmakan']['tglsurjalan']) : null);

      $transaction = Yii::app()->db->beginTransaction();
      $stokgizi = Yii::app()->user->getState('krngistokgizi');

      try {
        $success = true;
        if ($model->save()) {
          if (isset($modPengajuan->pengajuanbahanmkn_id)) {
            PengajuanbahanmknT::model()->updateByPk($model->pengajuanbahanmkn_id, array('terimabahanmakan_id' => $model->terimabahanmakan_id));
          }
          //var_dump($_POST['TerimabahandetailT']);
          $jumlah = count((array)$_POST['TerimabahandetailT']);
          $terimaDet = $_POST['TerimabahandetailT'];
          $u = 0;
          foreach ($terimaDet as $i => $bahanDetail) {
            // var_dump($bahanDetail); 
            //if ($_POST['checkList'] == 1) {
            $modDetail = new GZTerimabahandetailT();
            $modDetail->attributes = $bahanDetail;
            $modDetail->terimabahanmakan_id = $model->terimabahanmakan_id;
            $modDetail->golbahanmakanan_id = $bahanDetail['golbahanmakanan_id'];
            $modDetail->bahanmakanan_id = $bahanDetail['bahanmakanan_id'];
            $modDetail->nourutbahan = $u;
            $modDetail->ukuran_bahanterima = isset($bahanDetail['ukuran_bahanterima']) ? $bahanDetail['ukuran_bahanterima'] : null;
            $modDetail->merk_bahanterima = isset($bahanDetail['merk_bahanterima']) ? $bahanDetail['merk_bahanterima'] : null;
            $modDetail->jmlkemasan = $bahanDetail['jmlkemasan'];
            if (isset($modPengajuan->pengajuanbahanmkn_id)) {
              $modDetail->pengajuanbahandetail_id = $bahanDetail['pengajuanbahandetail_id'];
            }
            if (!is_numeric($modDetail->jmlkemasan)) {
              $modDetail->jmlkemasan = 0;
            }
            if (!is_numeric($bahanDetail['qty_terima'])) {
              $bahanDetail['qty_terima'] = 0;
            }
            $modDetail->qty_terima = $bahanDetail['qty_terima'];
            $modDetail->satuanbahan = $bahanDetail['satuanbahan'];
            $modDetail->hargajualbhn = $bahanDetail['hargajualbahan'];
            $modDetail->harganettobhn = $bahanDetail['harganettobahan'];

            $modDetail->tglkadaluarsabahan = MyFormatter::formatDateTimeForDb($bahanDetail['tglkadaluarsabahan']);
            //var_dump($bahanDetail);
            // var_dump($modDetail->attributes, $modDetail->validate(), $modDetail->errors);

            if ($modDetail->save()) {
              /* Ubah harga netto bahan makanan dan tanggal kedaluwarsa dengan data penerimaan */
              BahanmakananM::model()->updateByPk($modDetail->bahanmakanan_id, array(
                'harganettobahan' => $modDetail->harganettobhn,
                'tglkadaluarsabahan' => $modDetail->tglkadaluarsabahan,
              ));


              if ($stokgizi) {
                //	echo "kick";
                /* 
											 * Jika stok gizi dicentang di konfig sistem maka 
											 * akan ditambahkan stok-nya + penyesuaian jml persediaan 
											 * di master 
											 */
                $this->tambahStokBahanMakanan($modDetail);

                $tot = 0;
                $sto = StokbahanmakananT::model()->findAllByAttributes(array(
                  'bahanmakanan_id' => $modDetail->bahanmakanan_id,
                ));
                foreach ($sto as $item) {
                  $tot += $item->qty_current;
                }
                BahanmakananM::model()->updateByPk($modDetail->bahanmakanan_id, array(
                  'jmlpersediaan' => $tot,
                ));
              } else {
                /* Jika tidak maka hanya menambah jumlah persediaan yang ada di master bahan makanan */
                $bhn = BahanmakananM::model()->findByPk($modDetail->bahanmakanan_id);
                if (empty($bhn->jmlpersediaan)) $bhn->jmlpersediaan = 0;
                $bhn->jmlpersediaan += $modDetail->qty_terima;
                $bhn->save();
              }
              //	die;
              /* Update id terima bahan pada pengajuan bahan makanan */
              if (isset($modPengajuan->pengajuanbahanmkn_id)) {
                PengajuanbahandetailT::model()->updateByPk($modDetail->pengajuanbahandetail_id, array('terimabahandetail_id' => $modDetail->terimabahandetail_id));
              }
            } else {
              $success = false;
            }
            $u++;
            //}
          }
        } else {
          $success = false;
        }
        // var_dump($success); die;

        if ($success == TRUE) {

          //START NOTIFIKASI
          $judul = 'Penerimaan Bahan Makanan';

          $isi = (!empty($model->penerima->pegawai) ? $model->penerima->pegawai->namaLengkap : $model->nama_pemakai) . " sudah menerima bahan makanan dengan No Terima  " . $model->nopenerimaanbahan;

          $ruangan_gudang = RuanganM::model()->findByPk(Params::RUANGAN_ID_LOGISTIK);
          $ruangan_keuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
          $ruangan_purchasing = RuanganM::model()->findByPk(Params::RUANGAN_ID_GUDANG_UMUM);
          $ruangan_gizi = RuanganM::model()->findByPk(Params::RUANGAN_ID_GIZI);


          CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => $ruangan_gudang->instalasi_id, 'ruangan_id' => $ruangan_gudang->ruangan_id, 'modul_id' => $ruangan_gudang->modul_id),
            array('instalasi_id' => $ruangan_keuangan->instalasi_id, 'ruangan_id' => $ruangan_keuangan->ruangan_id, 'modul_id' => $ruangan_keuangan->modul_id),
            array('instalasi_id' => $ruangan_purchasing->instalasi_id, 'ruangan_id' => $ruangan_purchasing->ruangan_id, 'modul_id' => $ruangan_purchasing->modul_id),
            array('instalasi_id' => $ruangan_gizi->instalasi_id, 'ruangan_id' => $ruangan_gizi->ruangan_id, 'modul_id' => $ruangan_gizi->modul_id),
          ));
          //END NOTIFIKASI

          // SMS GATEWAY
          /*
                            $modSupplier = $model->supplier;
                            $sms = new Sms();
                            $smscp1 = 1;
                            $smscp2 = 1;
                            foreach ($modSmsgateway as $i => $smsgateway) {
                                $isiPesan = $smsgateway->templatesms;

                                $attributes = $model->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $attributes = $modSupplier->getAttributes();
                                foreach($attributes as $attributes => $value){
                                    $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                }
                                $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($model->tglterimabahan),$isiPesan);
                                $isiPesan = str_replace("{{nama_rumahsakit}}",Yii::app()->user->getState('nama_rumahsakit'),$isiPesan);
                                if($smsgateway->tujuansms == Params::TUJUANSMS_SUPPLIER && $smsgateway->statussms){
                                    if(!empty($modSupplier->supplier_cp_hp)){
                                        $sms->kirim($modSupplier->supplier_cp_hp,$isiPesan);
                                    }else{
                                        $smscp1 = 0;
                                        if(!empty($modSupplier->supplier_cp2_hp)){
                                            $sms->kirim($modSupplier->supplier_cp2_hp,$isiPesan);
                                        }else{
                                            $smscp2 = 0;
                                        }
                                    }
                                    
                                }
                                
                            }
                             * 
                             */
          // END SMS GATEWAY
          $transaction->commit();
          // $this->redirect(array('index', 'sukses'=>1, 'modul_id'=>Yii::app()->session['modul_id']));
          //$transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('index', 'id' => $model->terimabahanmakan_id, 'sukses' => 1));
          // $this->redirect(array('index', 'sukses'=>1, 'modul_id'=>Yii::app()->session->modul_id));
          //$this->refresh();
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $successSave = false;
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    if (empty($modDetailPengajuan)) {
      $modDetailPengajuan = null;
    }
    if (empty($modPengajuan)) {
      $modPengajuan = null;
    }
    $this->render('index', array(
      'model' => $model, 'modDetailPengajuan' => $modDetailPengajuan, 'modPengajuan' => $modPengajuan, 'modUangMuka' => $modUangMuka
    ));
  }

  public function actionGetBahanMakananDariPenerimaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      Yii::app()->clientScript->scriptMap['*.js'] = false;
      Yii::app()->clientScript->scriptMap['*.css'] = false;

      $idBahan = $_POST['id'];
      $qty = $_POST['qty'];
      //  $ukuran = $_POST['ukuran'];
      //  $merk = $_POST['merk'];
      $satuanbahan = $_POST['satuanbahan'];
      if (!is_numeric($qty)) {
        $qty = 0;
      }
      $model = BahanmakananM::model()->with('golbahanmakanan')->findByPk($idBahan);
      $modDetail = new TerimabahandetailT();
      $subNetto = $qty * $model->harganettobahan;

      //            $modDetail->satuanbahan[] = $satuanbahan;
      $tr = $this->renderPartial('_rowMakanan', array(
        'modDetail' => $modDetail,
        'model' => $model,
        'subNetto' => $subNetto,
        'qty' => $qty,
        //'ukuran'=>$ukuran,
        //'merk'=>$merk,
        'satuanbahan' => $satuanbahan,
      ), true, true);
      echo $tr;
      Yii::app()->end();
    }
  }

  protected function tambahStokBahanMakanan($detail)
  {

    $modStokBahan = new GZStokbahanmakananT();
    $modStokBahan->terimabahandetail_id = $detail->terimabahandetail_id;
    $modStokBahan->bahanmakanan_id = $detail->bahanmakanan_id;
    $modStokBahan->tgltransaksi = date('Y-m-d');
    $modStokBahan->qty_masuk = $detail->qty_terima;
    $modStokBahan->qty_current = $detail->qty_terima;
    $modStokBahan->qty_keluar = 0;
    $modStokBahan->save();

    $detail->stokbahanmakanan_id = $modStokBahan->stokbahanmakanan_id;
    $detail->save();
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


    if (isset($_POST['GZTerimabahanmakan'])) {
      $model->attributes = $_POST['GZTerimabahanmakan'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->terimabahanmakan_id));
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
  //	public function actionIndex()
  //	{
  //		$dataProvider=new CActiveDataProvider('GZTerimabahanmakan');
  //		$this->render('index',array(
  //			'dataProvider'=>$dataProvider,
  //		));
  //	}

  /**
   * Manages all models.
   */
  public function actionInformasi()
  {
    $this->pageTitle = Yii::app()->name . " - Penerimaan Bahan Makanan";
    //                
    $model = new GZTerimabahanmakan('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    //		$model->unsetAttributes();  // clear any default values
    if (isset($_GET['GZTerimabahanmakan'])) {
      $model->attributes = $_GET['GZTerimabahanmakan'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
      $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
    }

    $this->render('informasi', array(
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
    $model = GZTerimabahanmakan::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'gzterimabahanmakan-form') {
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
    $model = new GZTerimabahanmakan;
    $model->attributes = $_REQUEST['GZTerimabahanmakan'];
    $judulLaporan = 'Data GZTerimabahanmakan';
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
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  public function actionDetailPenerimaan($id, $print = 0)
  {

    $this->layout = '//layouts/iframe';
    if ($print == 1) {
      $this->layout = '//layouts/printWindows';
    }

    $modTerima = TerimabahanmakanT::model()->findByPk($id);
    $modDetailTerima = TerimabahandetailT::model()->with('bahanmakanan', 'golbahanmakanan')->findAllByAttributes(array('terimabahanmakan_id' => $modTerima->terimabahanmakan_id), array('order' => 'nourutbahan ASC'));

    $this->render('detailInformasi', array(
      'modTerima' => $modTerima,
      'modDetailTerima' => $modDetailTerima,
    ));
  }

  public function actionPrintDetailPenerimaan($id)
  {

    $judulLaporan = 'Penerimaan Bahan Makanan';

    $modTerima = TerimabahanmakanT::model()->findByPk($id);
    $modDetailTerima = TerimabahandetailT::model()->with('bahanmakanan', 'golbahanmakanan')->findAllByAttributes(array('terimabahanmakan_id' => $modTerima->terimabahanmakan_id), array('order' => 'nourutbahan ASC'));


    //if (isset($_GET['frame'])){
    //$this->layout='//layouts/iframe';
    // }

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      //   var_dump($id);die;
      $this->layout = '//layouts/printWindows';
      $this->render('printDetailInformasi', array('modTerima' => $modTerima, 'modDetailTerima' => $modDetailTerima, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    }
  }
}
