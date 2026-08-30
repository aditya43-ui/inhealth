<?php

class DaftarPasienController extends MyAuthController
{
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $model = new RKInfokunjunganrjV('searchDaftarPasien');
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($_GET['RKInfokunjunganrjV'])) {
      $model->attributes = $_GET['RKInfokunjunganrjV'];
      $format = new MyFormatter();
      $model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['RKInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RKInfokunjunganrjV']['tgl_akhir']);
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }

    $this->render('index', array('model' => $model));
  }

  public function actionDetailHasilLab($id)
  {
    $this->layout = '//layouts/iframe';
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

  public function actionDetailTindakan($id)
  {
    $this->layout = '//layouts/iframe';
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

  public function actionDetailTerapi($id)
  {
    $this->layout = '//layouts/iframe';
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
    $this->layout = '//layouts/iframe';
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

  public function actionGetRiwayatPasien($id)
  {
    $this->layout = '//layouts/iframe';
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

  public function actionPrint($id)
  {
    //$this->layout='//layouts/iframe';

    $modPendaftaran = RKPendaftaranT::model()->with('carabayar', 'penjamin')->findByPk($id);
    $modHasilLab = HasilpemeriksaanlabT::model()->findByAttributes(array('pendaftaran_id' => $id));
    $modDetailHasilLab = DetailhasilpemeriksaanlabT::model()->with('pemeriksaanlab')->findAllByAttributes(array('hasilpemeriksaanlab_id' => $modHasilLab->hasilpemeriksaanlab_id));
    $modDetailHasil = new DetailhasilpemeriksaanlabT();
    $format = new MyFormatter;
    $modHasilLab->tglhasilpemeriksaanlab = $format->formatDateTimeId($modHasilLab->tglhasilpemeriksaanlab);

    $modPasien = PasienM::model()->findByPK($modPendaftaran->pasien_id);

    $judulLaporan = 'Laporan Data Hasil Pemeriksaan Lab';
    $caraPrint = $_REQUEST['caraPrint'];

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('/_periksaDataPasien/detailHasilLab', array(
        'modPendaftaran' => $modPendaftaran,
        'modHasilLab' => $modHasilLab,
        'modDetailHasilLab' => $modDetailHasilLab,
        'modDetailHasil' => $modDetailHasil,
        'modPasien' => $modPasien, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('/_periksaDataPasien/detailHasilLab', array(
        'modPendaftaran' => $modPendaftaran,
        'modHasilLab' => $modHasilLab,
        'modDetailHasilLab' => $modDetailHasilLab,
        'modDetailHasil' => $modDetailHasil,
        'modPasien' => $modPasien, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('/_periksaDataPasien/detailHasilLab', array(
        'modPendaftaran' => $modPendaftaran,
        'modHasilLab' => $modHasilLab,
        'modDetailHasilLab' => $modDetailHasilLab,
        'modDetailHasil' => $modDetailHasil,
        'modPasien' => $modPasien, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint
      ), true));
      $mpdf->Output();
    }
  }

  public function actionGetRiwayat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pasien_id = $_GET['pasien_id'];
      $page = $_GET['page'];
      if (empty($page)) {
        $page = 1;
      }
      //$modPendaftaran=RKPendaftaranT::model()->findByPk($pendaftaran_id);

      $modPasien = PasienM::model()->findByPk($pasien_id);
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('/_periksaDataPasien/_riwayatPasien', array('modPasien' => $modPasien, 'page' => $page), true)
      ));
      exit;
    }
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
}
