<?php

class DaftarPasienController extends MyAuthController
{
  public $defaultAction = 'pasienRJ';
  public $upTandabuktibayarT = false;
  public $delTandabuktibayarT = false;
  public $delTindakansudahbayarT = false;
  public $delOasudahbayarT = false;
  public $delPembayaranpelayananT = false;

  public function actionIndex()
  {
    $this->render('index');
  }

  public function actionPasienRD() {
    $format = new MyFormatter();
    $modRD = new BKInformasikasirrdpulangV;
    $modRD->tgl_awal = date("Y-m-d");
    $modRD->tgl_akhir = date('Y-m-d');
    $modRD->statusBayar = "BELUM LUNAS";

    if (isset($_GET['BKInformasikasirrdpulangV'])) {
        $modRD->attributes = $_GET['BKInformasikasirrdpulangV'];
        if (!empty($_GET['BKInformasikasirrdpulangV']['tgl_awal'])) {
            $modRD->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasikasirrdpulangV']['tgl_awal']);
        }
        if (!empty($_GET['BKInformasikasirrdpulangV']['tgl_awal'])) {
            $modRD->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasikasirrdpulangV']['tgl_akhir']);
        }
        // $modRD->statusBayar=$_GET['BKInformasikasirrdpulangV']['statusBayar'];
    }


    $this->render('pasienRD', array('modRD' => $modRD, 'format' => $format));
  }

  public function actionPasienRI() {
    $format = new MyFormatter();
    $modRI = new BKInformasikasirinappulangV;
    //$modRI->tgl_awal = date('Y-m-d');
    //$modRI->tgl_akhir = date('Y-m-d');
    $modRI->tgl_awal_admisi = date('Y-m-d', time() - (30 * 3600 * 24));
    $modRI->tgl_akhir_admisi = date('Y-m-d');
    $modRI->statusBayar = "BELUM LUNAS";
    $modRI->statusperiksa = Params::STATUSPERIKSA_SEDANG_DIRAWATINAP;

    if (isset($_GET['BKInformasikasirinappulangV'])) {
        $modRI->attributes = $_GET['BKInformasikasirinappulangV'];

        $modRI->tgl_awal_admisi = $format->formatDateTimeForDb($_GET['BKInformasikasirinappulangV']['tgl_awal_admisi']);
        $modRI->tgl_akhir_admisi = $format->formatDateTimeForDb($_GET['BKInformasikasirinappulangV']['tgl_akhir_admisi']);
        $modRI->rencana = $_GET['BKInformasikasirinappulangV']['rencana'];
        $modRI->pake_tanggal = $_GET['BKInformasikasirinappulangV']['pake_tanggal'];
        $modRI->kelastanggungan_id = $_GET['BKInformasikasirinappulangV']['kelastanggungan_id'];
        // $modRI->statusBayar=$_GET['BKInformasikasirinappulangV']['statusBayar'];
        $modRI->kamarruangan_id = $_GET['BKInformasikasirinappulangV']['kamarruangan_id'];
        //$modRI->ceklis = $_GET['BKInformasikasirinappulangV']['ceklis'];
        //if($modRI->ceklis==1){
        //    $modRI->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasikasirinappulangV']['tgl_akhir']);
        //    $modRI->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasikasirinappulangV']['tgl_awal']);
        //}
    }


    if (Yii::app()->request->isAjaxRequest) {
        echo $this->renderPartial('_tablePasienRI', array('modRI' => $modRI, 'format' => $format), true);
    } else {
        $this->render('pasienRI', array('modRI' => $modRI, 'format' => $format));
    }
}

  public function actionPasienRIMelarikanDiri()
  {
    $format = new MyFormatter();
    $modRI = new BKInfokunjunganRIV;
    $modRI->tgl_awal_admisi = date('Y-m-d', time() - (30 * 3600 * 24));
    $modRI->tgl_akhir_admisi = date('Y-m-d');

    if (isset($_GET['BKInfokunjunganRIV'])) {

      $modRI->attributes = $_GET['BKInfokunjunganRIV'];

      $modRI->pake_tanggal = $_GET['BKInfokunjunganRIV']['pake_tanggal'];
      $modRI->tgl_awal_admisi = $format->formatDateTimeForDb($_GET['BKInfokunjunganRIV']['tgl_awal_admisi']);
      $modRI->tgl_akhir_admisi = $format->formatDateTimeForDb($_GET['BKInfokunjunganRIV']['tgl_akhir_admisi']);
      $modRI->kelastanggungan_id = $_GET['BKInfokunjunganRIV']['kelastanggungan_id'];
      $modRI->kamarruangan_id = $_GET['BKInfokunjunganRIV']['kamarruangan_id'];
    }

    $this->render('pasienMelarikanDiri', array('modRI' => $modRI, 'format' => $format));
  }

  public function actionPasienRJ() {
    $format = new MyFormatter();
    $modRJ = new BKInformasikasirrawatjalanV;
    $modRJ->tgl_awal = date("Y-m-d");
    $modRJ->tgl_akhir = date('Y-m-d');
    $modRJ->statusBayar = "BELUM LUNAS";
    $modRJ->instalasi_id = Params::INSTALASI_ID_RJ;

    if (isset($_GET['BKInformasikasirrawatjalanV'])) {
        $modRJ->attributes = $_GET['BKInformasikasirrawatjalanV'];
        // $modRJ->statusBayar=$_GET['BKInformasikasirrawatjalanV']['statusBayar'];
        if (!empty($_GET['BKInformasikasirrawatjalanV']['tgl_awal'])) {
            $modRJ->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasikasirrawatjalanV']['tgl_awal']);
        }
        if (!empty($_GET['BKInformasikasirrawatjalanV']['tgl_awal'])) {
            $modRJ->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasikasirrawatjalanV']['tgl_akhir']);
        }
    }


    $this->render('pasienRJ', array('modRJ' => $modRJ, 'format' => $format));
  }

  public function actionPasienMCU()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Medical Checkup";
    $format = new MyFormatter();
    $modMCU = new BKInformasikasirmcuV;
    $modMCU->tgl_awal = date("Y-m-d");
    $modMCU->tgl_akhir = date('Y-m-d');
    $modMCU->statusBayar = "BELUM LUNAS";
    //                $modRJ->instalasi_id = Params::INSTALASI_ID_RJ;

    if (isset($_GET['BKInformasikasirmcuV'])) {
      $modMCU->attributes = $_GET['BKInformasikasirmcuV'];
      // $modRJ->statusBayar=$_GET['BKInformasikasirrawatjalanV']['statusBayar'];
      if (!empty($_GET['BKInformasikasirmcuV']['tgl_awal'])) {
        $modMCU->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasikasirmcuV']['tgl_awal']);
      }
      if (!empty($_GET['BKInformasikasirmcuV']['tgl_awal'])) {
        $modMCU->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasikasirmcuV']['tgl_akhir']);
      }
    }


    $this->render('pasienMCU', array('modMCU' => $modMCU, 'format' => $format));
  }

  public function actionPasienKarcis()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Karcis";
    $format = new MyFormatter();
    $model = new BKInfopasienkarcisV('searchPasienKarcis');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['BKInfopasienkarcisV'])) {
      $model->attributes = $_GET['BKInfopasienkarcisV'];
      $model->no_pendaftaran = $_GET['BKInfopasienkarcisV']['no_pendaftaran'];
      $model->no_rekam_medik = $_GET['BKInfopasienkarcisV']['no_rekam_medik'];
      $model->nama_pasien = $_GET['BKInfopasienkarcisV']['nama_pasien'];
      // $model->nama_bin = $_GET['BKInfopasienkarcisV']['nama_bin'];
      $model->statusperiksa = $_GET['BKInfopasienkarcisV']['statusperiksa'];
      if (!empty($_GET['BKInfopasienkarcisV']['tgl_awal'])) {
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKInfopasienkarcisV']['tgl_awal']);
      }
      if (!empty($_GET['BKInfopasienkarcisV']['tgl_awal'])) {
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInfopasienkarcisV']['tgl_akhir']);
      }
    }

    $this->render('pasienKarcis', array('model' => $model, 'format' => $format));
  }

  // RND-9745
  //	public function actionPasienDeposit()
  //	{
  //            $format = new MyFormatter();
  //            $model = new BKBayaruangmukaT('searchPasienDeposit');
  //            $model->tgl_awal = date('d M Y');
  //            $model->tgl_akhir = date('d M Y');
  //            if(isset($_GET['BKBayaruangmukaT'])){
  //                    $model->attributes = $_GET['BKBayaruangmukaT'];
  //                    $model->no_pendaftaran = $_GET['BKBayaruangmukaT']['no_pendaftaran'];
  //                    $model->no_rekam_medik = $_GET['BKBayaruangmukaT']['no_rekam_medik'];
  //                    $model->nama_pasien = $_GET['BKBayaruangmukaT']['nama_pasien'];
  //                    $model->nama_bin = $_GET['BKBayaruangmukaT']['nama_bin'];
  //                    if(!empty($_GET['BKBayaruangmukaT']['tgl_awal']))
  //                    {
  //                        $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKBayaruangmukaT']['tgl_awal']);
  //                    }
  //                    if(!empty($_GET['BKBayaruangmukaT']['tgl_awal']))
  //                    {
  //                        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKBayaruangmukaT']['tgl_akhir']);
  //                    }
  //                }
  //
  //            $this->render('pasienDeposit',array('model'=>$model,'format'=>$format));
  //	}

  /**
   * url to see all pasien that already pay
   * used in :
   * 1. Billing Kasir -> informasi pasien sudah bayar
   */
  public function actionPasienSudahBayar()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Sudah Bayar";
    $format = new MyFormatter();
    $model = new BKInformasipasiensudahbayarV('searchInformasi');

    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $model->tgl_bkm_awal = date('d M Y');
    $model->tgl_bkm_akhir = date('d M Y');
    //$model->ceklis=false;
    if (isset($_GET['BKInformasipasiensudahbayarV'])) {
      $model->attributes = $_GET['BKInformasipasiensudahbayarV'];
      //var_dump($model);die;
      //$model->ceklis = $_GET['BKInformasipasiensudahbayarV']['ceklis'];
      if (!empty($_GET['BKInformasipasiensudahbayarV']['tgl_awal'])) {
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasipasiensudahbayarV']['tgl_awal']);
      }
      if (!empty($_GET['BKInformasipasiensudahbayarV']['tgl_akhir'])) {
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasipasiensudahbayarV']['tgl_akhir']);
      }

      if (!empty($_GET['BKInformasipasiensudahbayarV']['tgl_bkm_awal'])) {
        $model->tgl_bkm_awal = $format->formatDateTimeForDb($_GET['BKInformasipasiensudahbayarV']['tgl_bkm_awal']);
      }
      if (!empty($_GET['BKInformasipasiensudahbayarV']['tgl_bkm_akhir'])) {
        $model->tgl_bkm_akhir = $format->formatDateTimeForDb($_GET['BKInformasipasiensudahbayarV']['tgl_bkm_akhir']);
      }

      $model->ruanganakhir_id = isset($_GET['BKInformasipasiensudahbayarV']['ruanganakhir_id']) ? $_GET['BKInformasipasiensudahbayarV']['ruanganakhir_id'] : null;
      $model->instalasiakhir_id = isset($_GET['BKInformasipasiensudahbayarV']['instalasiakhir_id']) ? $_GET['BKInformasipasiensudahbayarV']['instalasiakhir_id'] : null;
    }

    $this->render('pasienSudahBayar', array('model' => $model));
  }

  public function actionPasienBerhutang()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Piutang";
    $format = new MyFormatter();
    $model = new BKPembayaranpelayananT('searchPasienBerhutang');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    if (isset($_GET['BKPembayaranpelayananT'])) {
      $model->attributes = $_GET['BKPembayaranpelayananT'];
      $model->no_pendaftaran = $_GET['BKPembayaranpelayananT']['no_pendaftaran'];
      $model->no_rekam_medik = $_GET['BKPembayaranpelayananT']['no_rekam_medik'];
      $model->nama_pasien = $_GET['BKPembayaranpelayananT']['nama_pasien'];
      $model->nama_bin = $_GET['BKPembayaranpelayananT']['nama_bin'];
      if (!empty($_GET['BKPembayaranpelayananT']['tgl_awal'])) {
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKPembayaranpelayananT']['tgl_awal']);
      }
      if (!empty($_GET['BKPembayaranpelayananT']['tgl_awal'])) {
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKPembayaranpelayananT']['tgl_akhir']);
      }
    }

    $this->render('pasienBerhutang', array('model' => $model));
  }

  public function actioninformasiPenanggung($id)
  {
    $this->layout = '//layouts/iframe';
    $model = BKInformasikasirrawatjalanV::model()->findByAttributes(array('no_pendaftaran' => $id));
    $modPenanggungJawab = PenanggungjawabM::model()->findByPk($model->penanggungjawab_id);
    $this->render(
      'informasiPenanggung',
      array(
        'model' => $modPenanggungJawab
      )
    );
  }

  // Uncomment the following methods and override them if needed
  /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */

  //        public function actionDetailKasMasuk($idPembayaran)
  //        {
  //            $this->layout = '//layouts/iframe';
  //            $model = new BKPembayaranpelayananT();
  //            $model->pembayaranpelayanan_id = $idPembayaran;
  //            $detail = $model->detailPembayaran();
  //            $func = new CustomFunction;
  //
  //            $no_bkm = '';
  //            $tgl_bkm = '';
  //            $pembayar = '';
  //            $total_bayar = '';
  //            $total_bayar_huruf = '';
  //
  //            $rec = array();
  //            foreach($detail as $key=>$val)
  //            {
  //                $data = null;
  //                $data->tglpembayaran = date('d-m-Y', strtotime($val['tglpembayaran']));
  //                $data->keterangan = $val['daftartindakan_nama'];
  //                $data->jumlah = $val['qty_tindakan']*$val['tarif_tindakan'];
  //
  //                $total_bayar += $data->jumlah;
  //                $no_bkm = $val['nobuktibayar'];
  //                $tgl_bkm = date('d-m-Y', strtotime($val['tglbuktibayar']));
  //                $pembayar = $val['darinama_bkm'];
  //
  //                $rec[] = $data;
  //            }
  //
  //            $data = array(
  //                'header'=>array(
  //                    'no_bkm'=>$no_bkm,
  //                    'tgl_bkm'=>$tgl_bkm,
  //                    'total_bayar'=>$total_bayar,
  //                    'total_bayar_huruf'=>$func->terbilang($total_bayar),
  //                    'pembayar'=>$pembayar,
  //                ),
  //                'detail'=>$rec,
  //                'footer'=>123,
  //            );
  //            $action_url = Yii::app()->createAbsoluteUrl(
  //                Yii::app()->controller->module->id .'/'. Yii::app()->controller->id .'/print' . Yii::app()->controller->action->id,
  //                array(
  //                    'idPembayaran'=>$idPembayaran
  //                )
  //            );
  //
  //            $this->render('detailKasMasuk',
  //                array(
  //                    'data'=>$data,
  //                    'actionUrl'=>$action_url,
  //                )
  //            );
  //        }

  /**
   * module billingKasir/DaftarPasien/PasienSudahBayar&modul_id=19
   * icon     : BKM
   * date     : 06-May-2014
   * issue    : EHS-1126
   * desc     : error tampilan BKM : solusi : disamakan dengan aplikasi di JK
   * action   : actionDetailKasMasuk($idPembayaran)
   */
  public function actionDetailKasMasuk($idPembayaran)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $criteria = new CDbCriteria();
    //            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
    $criteria->addCondition('pembayaranpelayanan_id = ' . $idPembayaran);
    $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
    $criteria->order = 'ruangan_id';
    $detail = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
    $func = new CustomFunction;
    $caraPrint = null;

    $no_bkm = '';
    $tgl_bkm = '';
    $pembayar = '';
    $total_bayar = 0;
    $total_bayar_huruf = '';

    $rec = array();
    foreach ($detail as $key => $val) {
      $data[] = null;
      $data['tglpembayaran'] = date('d-m-Y', strtotime($format->formatDateTimeForDb($val->getTandaBukti("tglbuktibayar"))));
      $data['keterangan'] = $val->daftartindakan_nama;
      $data['jumlah'] = $val->SubTotal;

      $total_bayar += $data['jumlah'];
      $no_bkm = $val->getTandaBukti("nobuktibayar");
      $tgl_bkm = $val->getTandaBukti("tglbuktibayar");
      $pembayar = $val->getTandaBukti("darinama_bkm");

      $rec[] = $data;
    }
    $data = array(
      'header' => array(
        'no_bkm' => $no_bkm,
        'tgl_bkm' => $tgl_bkm,
        'total_bayar' => $format->formatUang($total_bayar, "Rp "),
        'total_bayar_huruf' => $format->formatNumberTerbilang($total_bayar),
        'pembayar' => $pembayar,
      ),
      'detail' => $rec,
      'footer' => 123,
    );
    $action_url = Yii::app()->createAbsoluteUrl(
      Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/print' . Yii::app()->controller->action->id,
      array(
        'idPembayaran' => $idPembayaran
      )
    );

    $this->render(
      'detailKasMasuk',
      array(
        'format' => $format,
        'data' => $data,
        'actionUrl' => $action_url,
        'caraPrint' => $caraPrint
      )
    );
  }

  /**
   * module billingKasir/DaftarPasien/PasienSudahBayar&modul_id=19
   * icon     : BKM
   * date     : 06-May-2014
   * issue    : EHS-1126
   * desc     : error tampilan BKM : solusi : disamakan dengan aplikasi di JK
   * action   : actionPrintDetailKasMasuk($idPembayaran, $caraPrint)
   */
  public function actionPrintDetailKasMasuk($idPembayaran, $caraPrint)
  {
    if (!isset($caraPrint)) {
      $caraPrint = null;
    }
    $format = new MyFormatter;
    $criteria = new CDbCriteria();
  //            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
    $criteria->addCondition('pembayaranpelayanan_id = ' . $idPembayaran);
    $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
    $criteria->order = 'ruangan_id';
    $detail = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
    $func = new CustomFunction;
    //$pembulatan = BKTandabuktibayarT::model()->findAll();

    $no_bkm = '';
    $tgl_bkm = '';
    $pembayar = '';
    $total_bayar = 0;
    $total_bayar_huruf = '';
    $pembulatan = 0;

    $rec = array();
    foreach ($detail as $key => $val) {
        $data[] = null;
        $data['tglpembayaran'] = MyFormatter::formatDateTimeForUser($format->formatDateTimeForDb($val->getTandaBukti("tglbuktibayar")));
        $data['keterangan'] = $val->daftartindakan_nama;
        $data['jumlah'] = $val->jmlsudahbayar;

        $total_bayar += $data['jumlah'];
        $no_bkm = $val->getTandaBukti("nobuktibayar");
        $tgl_bkm = $val->getTandaBukti("tglbuktibayar");
        $pembayar = $val->getTandaBukti("darinama_bkm");
        $pembulatan = $val->getTandaBukti("jmlpembulatan");

        $rec[] = $data;
    }
    $modPembayaran = PembayaranpelayananT::model()->findByAttributes(array(
        'pembayaranpelayanan_id'=>$idPembayaran,
    ));
    $tandabukti = TandabuktibayarT::model()->findByAttributes(array(
        'pembayaranpelayanan_id'=>$idPembayaran,
    ));
    $total_bayar = (($total_bayar + $tandabukti->biayaadministrasi + $tandabukti->biayamaterai - $modPembayaran->totaldiscount));
      $konfigPembulatan = Yii::app()->user->getState('pembulatanhargakasir');
      $jmlBulat = 0;
      if($konfigPembulatan > 0){
          $nilaibulat = ceil(($total_bayar)/$konfigPembulatan)*$konfigPembulatan;
          $jmlBulat = $nilaibulat - $total_bayar;

          if($konfigPembulatan == $jmlBulat){
            $jmlBulat = 0;
          }
      }
      $total_bayar = $total_bayar+$jmlBulat;

      $totalbayar = (($tandabukti->uangditerima + $tandabukti->bank_nominal) - $tandabukti->uangkembalian);
    $data = array(
        'header' => array(
            'pembulatan' => $pembulatan,
            'no_bkm' => $no_bkm,
            'tgl_bkm' => $tgl_bkm,
            'total_bayar' => "Rp. ".$format->formatNumberForPrint($totalbayar, 2),
            'total_bayar_huruf' => $format->formatNumberTerbilang($totalbayar,2),
            'pembayar' => $pembayar,
            'totalsubsidirs' => $modPembayaran->totalsubsidirs
        ),
        'detail' => $rec,
        'footer' => 123,
    );

    if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render('detailKasMasuk', array(
            'data' => $data,
            'caraPrint' => $caraPrint,
            'format' => $format
                )
        );
    } else {
        $this->layout = '//layouts/iframe';
        $ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        //$mpdf->useOddEven = 2;
  //                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        // $mpdf->WriteHTML($stylesheet, 1);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 5, 5, 5, 5);
        $mpdf->WriteHTML(

        $this->render('detailKasMasuk', array(
            'format' => $format,
            'data' => $data,
            'caraPrint' => $caraPrint
                ), true
        )

        );
        $mpdf->Output();
    }
  }

  public function actionCekLoginBatalBayar($task = 'BatalBayar')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $username = $_POST['username'];
      $password = $_POST['password'];
      $idRuangan = Yii::app()->user->getState('ruangan_id');

      $user = LoginpemakaiK::model()->findByAttributes(array(
        'nama_pemakai' => $username,
        'loginpemakai_aktif' => TRUE
      ));
      if ($user === null) {
        $data['error'] = "Login Pemakai salah!";
        $data['cssError'] = 'username';
        $data['status'] = 'Gagal Login';
      } else {
        // cek password
        if ($user->katakunci_pemakai !== $user->encrypt($password)) {
          $data['error'] = 'password salah!';
          $data['cssError'] = 'password';
          $data['status'] = 'Gagal Login';
        } else {
          // cek ruangan
          $ruangan_user = RuanganpemakaiK::model()->findByAttributes(array(
            'loginpemakai_id' => $user->loginpemakai_id,
            'ruangan_id' => $idRuangan
          ));
          if ($ruangan_user === null) {
            $data['error'] = 'ruangan salah!';
            $data['status'] = 'Gagal Login';
          } else {
            $data['error'] = '';
            $cek = $this->checkAccess(array('loginpemakai_id' => $user->loginpemakai_id)); //dari MyAuthController
            if ($cek) {
              $data['status'] = 'success';
              $data['userid'] = $user->loginpemakai_id;
              $data['username'] = $user->nama_pemakai;
            } else {
              $data['status'] = 'Anda tidak memiliki hak melakukan proses ini!';
            }
          }
        }
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionBatalBayar()
  {

    if (Yii::app()->request->isAjaxRequest) {
      $returnVal['hasil'] = '';
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $tandabuktibayar_id = (isset($_POST['tandabuktibayar_id']) ? $_POST['tandabuktibayar_id'] : null);
        $pembayaranpelayanan_id = (isset($_POST['pembayaranpelayanan_id']) ? $_POST['pembayaranpelayanan_id'] : null);
        $modTandaBuktiBayar = TandabuktibayarT::model()->findByPk($tandabuktibayar_id);

        $criteria = new CDbCriteria;
        if (!empty($tandabuktibayar_id)) {
          $criteria->addCondition('tandabuktibayar_id =' . $tandabuktibayar_id);
        }
        $modBayarAngsuranPelayananT = BayarangsuranpelayananT::model()->find($criteria);

        $barisBayar = isset($modBayarAngsuranPelayananT) ? count((array)$modBayarAngsuranPelayananT) : null;
        $closing = (isset($modTandaBuktiBayar->closingkasir_id) ? $modTandaBuktiBayar->closingkasir_id : null);

        $criteriaPasaienAdmisi = new CDbCriteria;
        if (!empty($pembayaranpelayanan_id)) {
          $criteriaPasaienAdmisi->addCondition('pembayaranpelayanan_id =' . $pembayaranpelayanan_id);
        }
        $modPasienAdmisi = PasienadmisiT::model()->find($criteriaPasaienAdmisi);
        $pasienadmisi_id = isset($modPasienAdmisi->pasienadmisi_id) ? $modPasienAdmisi->pasienadmisi_id : null;

        $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));

        $batalPembayaran = array();
        $dataDaftar = array();
        if (!empty($pembayaranpelayanan_id)) {
          $bayar_pelayanan = PembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
          $batalPembayaran = array(
            'nopembayaran' => $bayar_pelayanan->nopembayaran,
            'ruanganakhir' => $bayar_pelayanan->ruanganpelakhir_id,
          );

          //var_dump($bayar_pelayanan->pendaftaran_id);die;

          $dataDaftar = PendaftaranT::model()->findByPk($bayar_pelayanan->pendaftaran_id);

          //var_dump($dataDaftar->attributes);die;
        }

        $criteriaTindakanSudahBayar = new CDbCriteria;
        if (!empty($pembayaranpelayanan_id)) {
          $criteriaTindakanSudahBayar->addCondition('pembayaranpelayanan_id =' . $pembayaranpelayanan_id);
        }
        $modTindakanSudahBayar = TindakansudahbayarT::model()->findAll($criteriaTindakanSudahBayar);


        $criteriaOasudahbayarT = new CDbCriteria;
        if (!empty($pembayaranpelayanan_id)) {
          $criteriaOasudahbayarT->addCondition('pembayaranpelayanan_id =' . $pembayaranpelayanan_id);
        }
        $modOA = OasudahbayarT::model()->findAll($criteriaOasudahbayarT);

        if (!empty($closing)) {
          $returnVal['hasil'] = 'Pembayarang ini sudah diclose !';
        } elseif ($barisBayar > 0) {
          $returnVal['hasil'] = 'Pasien sudah melakukan angsuran !';
        } elseif (empty($closing) && $barisBayar == 0) {



          $bayar = PembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
          // pasien ri
          $pulang = PasienpulangT::model()->findByAttributes(array(
            'pendaftaran_id' => $bayar->pendaftaran_id,
          ), array(
            'condition' => "create_time > '" . $bayar->create_time . "'",
            'order' => 'pasienpulang_id asc',
          ));

          $checkpulangpasien = false;

          if (!empty($pulang)) {
            $checkpulangpasien = true;

            if (!empty($pulang->pasienbatalpulang_id)) {
              $checkpulangpasien = false;
            } else {
              $checkpulangpasien = true;
            }
          }

          if ($checkpulangpasien) {
            $label = "";
            if ($pulang->carakeluar_id == Params::CARAKELUAR_ID_RAWATINAP) {
              $label = "ke Rawat Inap Pasien ";
            } else {
              $label = "Pemulangan Pasien ";
            }

            if (!empty($pulang->pasienadmisi_id)) {
              $label = " Rawat Inap";
            } else {
              $daftar = PendaftaranT::model()->findByPk($bayar->pendaftaran_id);
              $instalasi = InstalasiM::model()->findByPk($daftar->instalasi_id);

              $label .= $instalasi->instalasi_nama;
            }

            $returnVal['hasil'] = 'Pasien sudah dilakukan tindak lanjut ' . $label . '. Mohon batalkan tindak lanjut terlebih dahulu.';
          } else {

            // pasien non-ri

            $deleteJenisPembayaranT = JenispembayaranT::model()->deleteAllByAttributes(array('tandabuktibayar_id' => $tandabuktibayar_id));
            $updateTandabuktibayarT = TandabuktibayarT::model()->updateByPk($tandabuktibayar_id, array('pembayaranpelayanan_id' => null));
            $deleteTandabuktibayarT = TandabuktibayarT::model()->deleteByPk($tandabuktibayar_id);

            // ----- hapus jurnal rekening
            $rek = JurnalrekeningT::model()->findByAttributes(array(
              'tandabuktibayar_id' => $tandabuktibayar_id,
            ));
            if (!empty($rek)) {
              JurnaldetailT::model()->deleteAllByAttributes(array(
                'jurnalrekening_id' => $rek->jurnalrekening_id,
              ));
              JurnalrekeningT::model()->deleteByPk($rek->jurnalrekening_id);
              // ----- end hapus jurnal rekening
            }

            if ($updateTandabuktibayarT) {
              $this->upTandabuktibayarT = true;
            }
            if ($deleteTandabuktibayarT) {
              $this->delTandabuktibayarT = true;
            }

            if (count((array)$modOA) > 0) {
              foreach ($modOA as $i => $modOASudahBayar) {
                $modObatalkespasien = ObatalkespasienT::model()->findByAttributes(array('oasudahbayar_id' => $modOASudahBayar->oasudahbayar_id));
                $idObatalkespasien = $modObatalkespasien->obatalkespasien_id;
                ObatalkespasienT::model()->updateByPk($idObatalkespasien, array('oasudahbayar_id' => null));
              }
              $deleteOasudahbayarT = OasudahbayarT::model()->deleteAllByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));
              if ($deleteOasudahbayarT) {
                $this->delOasudahbayarT = true;
              }
            } else {
              $this->delOasudahbayarT = true;
              $returnVal['hasil'] = 'Pasien belum bayar obat alkes !';
            }

            if (count((array)$modTindakanSudahBayar) > 0) {
              foreach ($modTindakanSudahBayar as $j => $modTindakans) {
                $modTindakanpelayanan = TindakanpelayananT::model()->findByAttributes(array('tindakansudahbayar_id' => $modTindakans->tindakansudahbayar_id));
                $idTindakanpelayanan = (isset($modTindakanpelayanan->tindakanpelayanan_id) ? $modTindakanpelayanan->tindakanpelayanan_id : null);
                $updateTindakanpelayananT = TindakanpelayananT::model()->updateByPk($idTindakanpelayanan, array('tindakansudahbayar_id' => null, 'subsidiasuransi_tindakan' => 0, 'subsidipemerintah_tindakan' => 0, 'subsisidirumahsakit_tindakan' => 0, 'iurbiaya_tindakan' => 0));
              }
              $deleteTindakansudahbayarT = TindakansudahbayarT::model()->deleteAllByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));
              if ($deleteTindakansudahbayarT) {
                $this->delTindakansudahbayarT = true;
              }
            } else {
              $this->delTindakansudahbayarT = true;
              $returnVal['hasil'] = 'Pasien belum bayar tindakan pelayanan !';
            }

            $criteriaPemakaianuangmukaT = new CDbCriteria;
            if (!empty($pembayaranpelayanan_id)) {
              $criteriaPemakaianuangmukaT->addCondition('pembayaranpelayanan_id =' . $pembayaranpelayanan_id);
            }
            $modPemakaianuangmukaT = PemakaianuangmukaT::model()->findAll($criteriaPemakaianuangmukaT);
            if (count((array)$modPemakaianuangmukaT) > 0) {
              foreach ($modPemakaianuangmukaT as $item) {
                $bayar_u = BayaruangmukaT::model()->findAllByAttributes(array(
                  'pemakaianuangmuka_id' => $item->pemakaianuangmuka_id,
                ));
                foreach ($bayar_u as $item_u) {
                  BayaruangmukaT::model()->updateByPk($item_u->bayaruangmuka_id, array(
                    "uangmukadipakai" => 0,
                  ));
                }
                $deletePemakaianuangmukaT = PemakaianuangmukaT::model()->deleteByPk($item->pemakaianuangmuka_id);
              }

              // $deletePemakaianuangmukaT = PemakaianuangmukaT::model()->deleteAllByAttributes(array('pembayaranpelayanan_id' => $modPemakaianuangmukaT->pembayaranpelayanan_id));
            } else {
              //    $returnVal['hasil'] = 'Pasien belum bayar uang muka !';
            }




            $criteriaPasienadmisiT = new CDbCriteria;
            if (!empty($pembayaranpelayanan_id)) {
              $criteriaPasienadmisiT->addCondition('pembayaranpelayanan_id =' . $pembayaranpelayanan_id);
            }
            $modPasienadmisiT = PasienadmisiT::model()->findAll($criteriaPasienadmisiT);
            if (count((array)$modPasienadmisiT) > 0) {
              $updatePasienadmisiT = PasienadmisiT::model()->updateByPk($pasienadmisi_id, array('pembayaranpelayanan_id' => null));
            } else {
              // di-komen dikarenakan tidak semua yang membayar itu ada pasien rawat inap
              //    $returnVal['hasil'] = 'Pasien belum bayar pelayanan sebagai pasien admisi !';
            }

            if (!empty($modPendaftaran)) {
              if ($modPendaftaran->instalasi_id == Params::INSTALASI_ID_RJ && empty($modPendaftaran->pasienamdisi_id) && empty($modPendaftaran->pasienpulang_id)) { //khusus untuk RJ saja Status periksa = sedang periksa
                PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('pembayaranpelayanan_id' => null, 'statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
              } else {
                PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('pembayaranpelayanan_id' => null));
              }
            }

            $deletePembayaranpelayananT = PembayaranpelayananT::model()->deleteAllByAttributes(array('tandabuktibayar_id' => $tandabuktibayar_id));
            if ($deletePembayaranpelayananT) {
              $this->delPembayaranpelayananT = true;

              if ($this->delPembayaranpelayananT == true) {
                $this->breadcastNotifBatalTagihanPasien($batalPembayaran, $dataDaftar);
              }
            }
          }
        }

        // var_dump($returnVal['hasil'], $this->upTandabuktibayarT && $this->delTandabuktibayarT && $this->delTindakansudahbayarT && $this->delPembayaranpelayananT); die;

        if ($this->upTandabuktibayarT && $this->delTandabuktibayarT && $this->delTindakansudahbayarT && $this->delOasudahbayarT && $this->delPembayaranpelayananT) {
          $transaction->commit();
          $returnVal['hasil'] = 'BERHASIL';
        } else {
          $transaction->rollback();
          if (empty($returnVal['hasil'])) {
            $returnVal['hasil'] = 'Gagal di batalkan !';
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $returnVal['hasil'] = 'Gagal di batalkan !' . $exc->getMessage();
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionCekStatusPasienRJ() {
    if (!Yii::app()->request->isAjaxRequest)
        Yii::app()->end();


    // $trans = Yii::app()->db->beginTransaction();

    $id = $_POST['id'];

    $reseptur_full = ResepturT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $id,
    ));

    $reseptur = ResepturT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $id,
            ), array(
        'condition' => 'penjualanresep_id is null',
    ));

    $model = BKInformasikasirrawatjalanV::model()->findByAttributes(array(
        'pendaftaran_id' => $id,
    ));


    // ambulans
    $ambulans = PesanambulansT::model()->find("pendaftaran_id = ".$id." and pemakaianambulans_id is null");

    $no_rm = $model->no_rekam_medik;
    $nama = $model->namadepan . $model->nama_pasien;
    $status = $model->statusperiksa;
    $ruangan = $model->ruangan_nama;

    $notif = array(
        'ok' => 1,
        'msg' => '',
    );
    /*
    if ($model->statusperiksa != Params::STATUSPERIKSA_SUDAH_DIPERIKSA) {
        if ($model->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
            $notif['ok'] = 1;
            $notif['msg'] = "Pasien ${nama} (${no_rm}) ${status}. Apakah Anda akan menyelesaikan sisa tagihan pasien ?";
        } else {
            $notif['ok'] = 0;
            $notif['msg'] = "Pasien ${nama} (${no_rm}) masih dalam status ${status}"
                    . " di ${ruangan}";
        }
    //} else if (count((array)$reseptur_full) == 0) {
    //    $notif['ok'] = 0;
    //    $notif['msg'] = "Pasien ${nama} belum dilakukan Transaksi Reseptur.";

    } else if (count((array)$reseptur) > 0) {
        $notif['ok'] = 0;
        $notif['msg'] = "Resep untuk Pasien ${nama} belum dilakukan verifikasi oleh Farmasi.";

        $this->breadcastNotifResepturPasien($model, $reseptur);
    } else if (!empty($ambulans)) {
        $notif['ok'] = 0;
        $notif['msg'] = "Pasien ${nama} belum dilakukan Pemakaian Ambulans";

    }
    // */

    echo CJSON::encode($notif);
  }

  public function actionCekStatusPasienMCU()
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();


    // $trans = Yii::app()->db->beginTransaction();

    $id = $_POST['id'];

    $reseptur_full = ResepturT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ));

    $reseptur = ResepturT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array(
      'condition' => 'penjualanresep_id is null',
    ));

    $model = BKInformasikasirmcuV::model()->findByAttributes(array(
      'pendaftaran_id' => $id,
    ));

    $no_rm = $model->no_rekam_medik;
    $nama = $model->namadepan . $model->nama_pasien;
    $status = $model->statusperiksa;
    $ruangan = $model->ruangan_nama;

    $notif = array(
      'ok' => 1,
      'msg' => '',
    );
    // /*
    if ($model->statusperiksa != Params::STATUSPERIKSA_SUDAH_DIPERIKSA) {
      if ($model->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
        $notif['ok'] = 1;
        $notif['msg'] = "Pasien ${nama} (${no_rm}) ${status}. Apakah Anda akan menyelesaikan sisa tagihan pasien ?";
      } else {
        $notif['ok'] = 0;
        $notif['msg'] = "Pasien ${nama} (${no_rm}) masih dalam status ${status}"
          . " di ${ruangan}";
      }
      /* } else if (count((array)$reseptur_full) == 0) {
            $notif['ok'] = 0;
            $notif['msg'] = "Pasien ${nama} belum dilakukan Transaksi Reseptur.";

            //$this->breadcastNotifResepturPasien($model, $reseptur);

        } else if (count((array)$reseptur) > 0) {
            $notif['ok'] = 0;
            $notif['msg'] = "Resep untuk Pasien ${nama} belum dilakukan verifikasi oleh Farmasi.";

            $this->breadcastNotifResepturPasien($model, $reseptur);
         * */
    }
    // *
    // *
    // */



    echo CJSON::encode($notif);
  }

  public function actionCekStatusPasienHD()
  {
    if (!Yii::app()->request->isAjaxRequest)
      Yii::app()->end();


    // $trans = Yii::app()->db->beginTransaction();

    $id = $_POST['id'];

    $reseptur_full = ResepturT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ));
    $reseptur = ResepturT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $id,
    ), array(
      'condition' => 'penjualanresep_id is null',
    ));

    $model = BKInformasikasirhdpulangV::model()->findByAttributes(array(
      'pendaftaran_id' => $id,
    ));

    $no_rm = $model->no_rekam_medik;
    $nama = $model->namadepan . $model->nama_pasien;
    $status = $model->statusperiksa;
    $ruangan = $model->ruangan_nama;

    $notif = array(
      'ok' => 1,
      'msg' => '',
    );
    // /*
    if ($model->statusperiksa != Params::STATUSPERIKSA_SUDAH_DIPERIKSA) {
      if ($model->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
        $notif['ok'] = 1;
        $notif['msg'] = "Pasien ${nama} (${no_rm}) ${status}. Apakah Anda akan menyelesaikan sisa tagihan pasien ?";
      } else {
        $notif['ok'] = 0;
        $notif['msg'] = "Pasien ${nama} (${no_rm}) masih dalam status ${status}"
          . " di ${ruangan}";
      }
    } else if (count((array)$reseptur_full) == 0) {
      $notif['ok'] = 0;
      $notif['msg'] = "Pasien ${nama} belum dilakukan Transaksi Reseptur.";

      //$this->breadcastNotifResepturPasien($model, $reseptur);
    } else if (count((array)$reseptur) > 0) {
      $notif['ok'] = 0;
      $notif['msg'] = "Resep untuk Pasien ${nama} belum dilakukan verifikasi oleh Farmasi.";

      $this->breadcastNotifResepturPasien($model, $reseptur);
    }
    // *
    // *
    // */



    echo CJSON::encode($notif);
  }

  public function actionCekStatusPasienRD() {
    if (!Yii::app()->request->isAjaxRequest)
        Yii::app()->end();

    $id = $_POST['id'];

    $reseptur_full = ResepturT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $id,
    ));
    $reseptur = ResepturT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $id,
            ), array(
        'condition' => 'penjualanresep_id is null',
    ));

    $model = BKInformasikasirrdpulangV::model()->findByAttributes(array(
        'pendaftaran_id' => $id,
    ));

    $no_rm = $model->no_rekam_medik;
    $nama = $model->namadepan . $model->nama_pasien;
    $status = $model->statusperiksa;
    $ruangan = $model->ruangan_nama;

    // ambulans
    $ambulans = PesanambulansT::model()->find("pendaftaran_id = ".$id." and pemakaianambulans_id is null");

    $notif = array(
        'ok' => 1,
        'msg' => '',
    );
    // /*
    if ($model->statusperiksa != Params::STATUSPERIKSA_SUDAH_DIPERIKSA) {
        if ($model->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
            $notif['ok'] = 9;
            $notif['msg'] = "Pasien ${nama} (${no_rm}) ${status}. Apakah Anda akan menyelesaikan sisa tagihan pasien ?";
        } else {
            $notif['ok'] = 0;
            $notif['msg'] = "Pasien ${nama} (${no_rm}) masih dalam status ${status}"
                    . " di ${ruangan}";
        }
    } /* else if (count((array)$reseptur_full) == 0) {
        $notif['ok'] = 0;
        $notif['msg'] = "Pasien ${nama} belum dilakukan Transaksi Reseptur.";

        //$this->breadcastNotifResepturPasien($model, $reseptur);
    } */ else if (count((array)$reseptur) > 0) {
        $notif['ok'] = 0;
        $notif['msg'] = "Resep untuk Pasien ${nama} belum dilakukan verifikasi oleh Farmasi.";

        $this->breadcastNotifResepturPasien($model, $reseptur);
    } else if (!empty($ambulans)) {
        $notif['ok'] = 0;
        $notif['msg'] = "Pasien ${nama} belum dilakukan Pemakaian Ambulans";
    }
    // *
    // */
    echo CJSON::encode($notif);
  }

  public function actionCekStatusPasienRI() {
    if (!Yii::app()->request->isAjaxRequest)
        Yii::app()->end();

    $id = $_POST['id'];

    $reseptur_full = ResepturT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $id,
    ));

    $reseptur = ResepturT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $id,
            ), array(
        'condition' => 'penjualanresep_id is null',
    ));

    $model = BKInformasikasirinappulangV::model()->findByAttributes(array(
        'pendaftaran_id' => $id,
    ));
    $admisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);

    $nama = $model->namadepan . $model->nama_pasien;
    $modRuangan = RuanganM::model()->findByPk($admisi->ruangan_id);
    $ruangan = $modRuangan->ruangan_nama;


    $no_rm = $model->no_rekam_medik;
    $nama = $model->namadepan . $model->nama_pasien;
    $status = $model->statusperiksa;
    $ruangan = $model->ruangan_nama;


    // ambulans
    $ambulans = PesanambulansT::model()->find("pendaftaran_id = ".$id." and pemakaianambulans_id is null");



    $notif = array(
        'ok' => 1,
        'msg' => '',
    );
    // /*
    if (empty($admisi->rencanapulang) && $model->carakeluar_id != Params::CARAKELUAR_ID_MENINGGAL) {
        $notif['ok'] = 0;
        $notif['msg'] = "Pasien ${nama} belum dilakukan Rencana Pulang pada "
                . "ruangan ${ruangan}";
    }
    // else if (count((array)$reseptur_full) == 0) {
    //     $notif['ok'] = 0;
    //     $notif['msg'] = "Pasien ${nama} belum dilakukan Transaksi Reseptur.";
    //
    //     //$this->breadcastNotifResepturPasien($model, $reseptur);
    // }
    else if (count((array)$reseptur) > 0) {
        $notif['ok'] = 0;
        $notif['msg'] = "Resep untuk Pasien ${nama} belum dilakukan verifikasi oleh Farmasi.";

        $this->breadcastNotifResepturPasien($model, $reseptur);
    }
    else if (!empty($ambulans)) {
        $notif['ok'] = 0;
        $notif['msg'] = "Pasien ${nama} belum dilakukan Pemakaian Ambulans";
    }

    // *
    // */
    echo CJSON::encode($notif);
  }

  /**
   *
   * @param mixed $model Data yang berhubungan dengan Pasien dan Pendaftaran.
   * @param ResepturT $reseptur Data ResepturT
   * @return boolean Status keberhasilan Broadcast reseptur ke farmasi
   */
  protected function breadcastNotifResepturPasien($model, $reseptur)
  {
    $judul = "Verifikasi Reseptur Rawat Inap";
    $msg = "Harap Reseptur dibawah ini di diselesaikan :<br/>";
    $noresep = array();
    foreach ($reseptur as $item) {
      $msg .= "- " . $item->noresep . '<br/>';
      $noresep[] = $item->noresep;
    }

    $link = $this->createUrl('/farmasiApotek/InformasiPasienResep/Index', array(
      'FAInformasiresepturV[tgl_awal]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
      'FAInformasiresepturV[tgl_akhir]' => date('Y-m-d'),
      'FAInformasiresepturV[no_pendaftaran]' => $model->no_pendaftaran,
      'FAInformasiresepturV[statusJual]' => 2,
    ));

    $cur = array(
      array('instalasi_id' => Params::INSTALASI_ID_FARMASI, 'ruangan_id' => Params::RUANGAN_ID_APOTEK_1, 'modul_id' => Params::MODUL_ID_APOTEK, 'link_proses' => $link),
    );

    // var_dump($modKunjungan->attributes); die;
    // var_dump($judul, $isi, $cur, $modKunjungan->attributes); die;

    return CustomFunction::broadcastNotif($judul, $msg, $cur);
  }

  /**
   *
   * @param mixed $model Data yang berhubungan dengan Pasien dan Pendaftaran.
   * @param ResepturT $reseptur Data ResepturT
   * @return boolean Status keberhasilan Broadcast reseptur ke keuangan
   */
  protected function breadcastNotifBatalTagihanPasien($data_bayar, $modPendaftaran)
  {
    $judul = "Pembatalan Tagihan Pasien";
    $msg = $data_bayar['nopembayaran'] . ' - ' . $modPendaftaran->no_pendaftaran . ' ' . $modPendaftaran->pasien->nama_pasien;

    $ru = RuanganM::model()->findAll(" ruangan_aktif = TRUE AND (instalasi_id = '" . Params::INSTALASI_ID_KEUANGAN . "' AND modul_id = '" . Params::MODUL_ID_KEUANGAN . "') OR ruangan_id = '" . $data_bayar['ruanganakhir'] . "' ");
    foreach ($ru as $r) {
      if (!empty($r->modul_id)) {
        $cur[] = array('instalasi_id' => $r->instalasi_id, 'ruangan_id' => $r->ruangan_id, 'modul_id' => $r->modul_id);
      }
    }
    //var_dump($cur);die;
    return CustomFunction::broadcastNotif($judul, $msg, $cur);
  }

  public function actionPasienHD()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Hemodialisa";
    $format = new MyFormatter();
    $modHD = new BKInformasikasirhdpulangV();
    $modHD->tgl_awal = date("Y-m-d");
    $modHD->tgl_akhir = date('Y-m-d');

    if (isset($_GET['BKInformasikasirhdpulangV'])) {
      $modHD->attributes = $_GET['BKInformasikasirhdpulangV'];
      if (!empty($_GET['BKInformasikasirhdpulangV']['tgl_awal'])) {
        $modHD->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasikasirhdpulangV']['tgl_awal']);
      }
      if (!empty($_GET['BKInformasikasirhdpulangV']['tgl_awal'])) {
        $modHD->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasikasirhdpulangV']['tgl_akhir']);
      }
    }

    $this->render('pasienHD', array('modHD' => $modHD, 'format' => $format));
  }

  public function actionUbahStatus() {
    if (!Yii::app()->request->isAjaxRequest) {
        Yii::app()->end();
    }

    $ok = 1;
    $msg = "Status periksa berhasil diubah";

    if (isset($_POST['id']) && isset($_POST['status'])) {
        PendaftaranT::model()->updateByPk($_POST['id'], array(
            'statusperiksa'=>$_POST['status'],
        ));
    }

    echo CJSON::encode(array(
        'ok'=>$ok, 'msg'=>$msg,
    ));
  }
}
