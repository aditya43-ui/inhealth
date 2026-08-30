<?php

class PengajuanPegawaiTController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'kepegawaian.views.pengajuanPegawaiT.';

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionIndex($id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Rencana Penerimaan Pegawai";
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new KPPengajuanPegawaiT;
    $model->tglpengajuan = date('d-m-Y');


    $pegawai_id = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));

    if (!empty($pegawai_id)) {
      $model->mengajukan_id = $pegawai_id->pegawai_id;
      $model->mengajukanNama = $pegawai_id->namaLengkap;
    }

    $modPengpegdet = new KPPengpegawaidetT;
    $modPengpegdets = null;
    $modPengpegdet->nourut = 1;
    $modPengpegdet->disetujui = false;

    $format = new MyFormatter();
    $bln = strtoupper($format->getMonthUser(date('M')));
    $thn = date('Y');
    $tgl = date('d');
    $model->nopengajuan_awal = 'KPP/' . $thn . '/' . $bln . '/' . $tgl . '/';

    if (!empty($id)) {
      $model = KPPengajuanPegawaiT::model()->findByPk($id);
      $yangmengajukan = KPPegawaiM::model()->findByPk($model->mengajukan_id);
      $yangmengetahui = KPPegawaiM::model()->findByPk($model->mengetahui_id);
      $yangmenyetujui = KPPegawaiM::model()->findByPk($model->menyetujui_id);
      //                    $model->namayangmengajukan = $yangmengajukan->gelardepan.' '.$yangmengajukan->nama_pegawai;
      //                    $model->namayangmengetahui = $yangyangmengajukan->gelardepan.' '.$yangmengetahui->nama_pegawai;
      $model->mengetahui = $yangmengajukan->gelardepan . ' ' . $yangmengetahui->nama_pegawai;
      $model->mengajukanNama = $yangmengajukan->gelardepan . ' ' . $yangmengajukan->nama_pegawai;
      $model->menyetujuiNama = $yangmenyetujui->namaLengkap;
      $nopengajuan = explode('/', $model->nopengajuan);

      $model->nopengajuan_awal = str_replace($nopengajuan[4], '', $model->nopengajuan);
      $model->nopengajuan = $nopengajuan[4];

      $modPengpegdets = KPPengpegawaidetT::model()->findAllByAttributes(array('pengajuanpegawai_t_id' => $model->pengajuanpegawai_t_id), array('order' => 'nourut'));
    }
    if (isset($_POST['KPPengajuanPegawaiT']) && empty($id)) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['KPPengajuanPegawaiT'];
        $model->create_time = date('Y-m-d');
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->tglpengajuan = $format->formatDateTimeForDb($model->tglpengajuan);
        $model->nopengajuan = $model->nopengajuan_awal . $model->nopengajuan;

        $modPengpegdets = $this->validasiTabular($_POST['KPPengpegawaidetT']);

        $jumlahDetailPengcal = count((array)$modPengpegdets);
        $jumlahDetail = 0;

        if ($model->save()) {
          $model->nopengajuan = $model->nopengajuan_awal . $model->nopengajuan;
          if ($jumlahDetailPengcal > 0) {
            foreach ($modPengpegdets as $key => $modDetail) {
              $modDetail->pengajuanpegawai_t_id = $model->pengajuanpegawai_t_id;
              if ($modDetail->save()) {
                $jumlahDetail++;
              }
            }
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
        if ($jumlahDetailPengcal == $jumlahDetail) {
          $judul = "Rencana Penerimaan Pegawai";
          $criteria = new CDbCriteria();
          $criteria->select = "SUM(jmlorang) as jumlah";
          $criteria->addCondition("pengajuanpegawai_t_id = '" . $model->pengajuanpegawai_t_id . "' ");
          $jml = KPPengpegawaidetT::model()->findAll($criteria);
          $total = 0;

          foreach ($jml as $jml) :
            $total = $jml->jumlah;
          endforeach;

          $model->total = $total;

          $isi = $model->mengajukan->namaLengkap . ' mengajukan Rencana Penerimaan Pegawai sebanyak ' . $model->total . ' orang';
          $ok = CustomFunction::broadcastNotif($judul, $isi, array(
            array('instalasi_id' => Params::INSTALASI_ID_KEPEGAWAIAN, 'ruangan_id' => Params::RUANGAN_ID_KEPEGAWAIAN, 'modul_id' => Params::MODUL_ID_KEPEGAWAIAN),
          ));
          $transaction->commit();


          Yii::app()->user->setFlash('success', "Data Pengajuan " . $model->nopengajuan_awal . " Berhasil Disimpan ");
          $this->redirect(array('index', 'id' => $model->pengajuanpegawai_t_id, 'sukses' => 1));
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('index', array(
      'model' => $model, 'modPengpegdet' => $modPengpegdet, 'modPengpegdets' => $modPengpegdets
    ));
  }

  private function validasiTabular($datas)
  {
    $modPengpegdets = null;
    if (count((array)$datas) > 0) {
      foreach ($datas as $key => $data) {
        $modPengpegdets[$key] = new KPPengpegawaidetT();
        $modPengpegdets[$key]->attributes = $data;
        $modPengpegdets[$key]->validate();
      }
    }
    return $modPengpegdets;
  }


  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = KPPengajuanPegawaiT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'pengcalkaryawan-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id 
   */


  public function actionPrint($pengajuanpegawai_id, $caraPrint)
  {
    $judulLaporan = 'Data Pengajuan Kepegawaian';
    $model = KPPengajuanPegawaiT::model()->findByPk($pengajuanpegawai_id);
    $yangmengajukan = KPPegawaiM::model()->findByPk($model->mengajukan_id);
    $yangmengetahui = KPPegawaiM::model()->findByPk($model->mengetahui_id);
    $model->mengetahui = $yangmengajukan->gelardepan . ' ' . $yangmengetahui->nama_pegawai;
    $model->mengajukanNama = $yangmengajukan->gelardepan . ' ' . $yangmengajukan->nama_pegawai;
    $modPengpegdets = KPPengpegawaidetT::model()->findAllByAttributes(array('pengajuanpegawai_t_id' => $model->pengajuanpegawai_t_id), array('order' => 'nourut'));

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'modPengpegdets' => $modPengpegdets,));
    }
  }

  public function actionInformasi()
  {
    $this->pageTitle = Yii::app()->name . " - Rencana Penerimaan Pegawai";
    $model = new KPInfopengajuanpegawaiV;
    $format = new MyFormatter;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['KPInfopengajuanpegawaiV'])) {
      $model->attributes = $_GET['KPInfopengajuanpegawaiV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KPInfopengajuanpegawaiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KPInfopengajuanpegawaiV']['tgl_akhir']);
    }

    $this->render('informasi', array(
      'model' => $model,
      'format' => $format,
    ));
  }

  public function actionApproveMenyetujui($pengajuanpegawai_id, $approve = false, $tolak = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = KPInfopengajuanpegawaiV::model()->findByAttributes(array('pengajuanpegawai_t_id' => $pengajuanpegawai_id));
    //		$modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    if ($approve) {
      $update = KPPengajuanPegawaiT::model()->updateByPk($pengajuanpegawai_id, array('tgl_menyetujui' => date("Y-m-d H:i:s")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('ApproveMenyetujui', 'pengajuanpegawai_id' => $pengajuanpegawai_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    //		if($tolak){
    //			$update = ADPembelianbarangT::model()->updateByPk($rencanakebfarmasi_id,array('statusrencana'=>"DITOLAK"));
    //			if($update){
    //				Yii::app()->user->setFlash('success',"Data berhasil disimpan");
    //				$this->redirect(array('menyetujui','rencanakebfarmasi_id'=>$rencanakebfarmasi_id,'sukses'=>1,'ditolak'=>1));
    //			}else{
    //				Yii::app()->user->setFlash('error',"Data Gagal Disimpan");
    //			}
    //		}
    $judulLaporan = 'Rencana Penerimaan Pegawai';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpengajuan);
    $this->render($this->path_view . '_menyetujui', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi
    ));
  }

  public function actionPrintApproveMenyetujui($pengajuanpegawai_id)
  {
    $format = new MyFormatter();
    $model = KPInfopengajuanpegawaiV::model()->findByAttributes(array('pengajuanpegawai_t_id' => $pengajuanpegawai_id));
    //		$modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    $judulLaporan = 'Rencana Penerimaan Pegawai';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpengajuan);
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMenyetujui', array('format' => $format, 'model' => $model, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionApproveMengetahui($pengajuanpegawai_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();

    $model = KPInfopengajuanpegawaiV::model()->findByAttributes(array('pengajuanpegawai_t_id' => $pengajuanpegawai_id));
    //                $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    if ($approve) {
      $update = KPPengajuanPegawaiT::model()->updateByPk($pengajuanpegawai_id, array('tgl_mengetahui' => date("Y-m-d H:i:s")));
      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('ApproveMengetahui', 'pengajuanpegawai_id' => $pengajuanpegawai_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'Rencana Penerimaan Pegawai';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpengajuan);
    $this->render($this->path_view . '_mengetahui', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi
    ));
  }

  public function actionPrintApproveMengetahui($pengajuanpegawai_id)
  {
    $format = new MyFormatter();

    $model = KPInfopengajuanpegawaiV::model()->findByAttributes(array('pengajuanpegawai_t_id' => $pengajuanpegawai_id));
    //                $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));

    $judulLaporan = 'Rencana Penerimaan Pegawai';
    $deskripsi = 'Tanggal ' . MyFormatter::formatDateTimeId($model->tglpengajuan);
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMengetahui', array('format' => $format, 'model' => $model, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMengetahui', array('format' => $format, 'model' => $model, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMengetahui', array('format' => $format, 'model' => $model, 'deskripsi' => $deskripsi, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
