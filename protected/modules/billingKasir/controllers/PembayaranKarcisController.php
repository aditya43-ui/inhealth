<?php

Yii::import("billingKasir.controllers.PembayaranTagihanPasienController");

class PembayaranKarcisController extends PembayaranTagihanPasienController
{
  //public $path_view = 'billingKasir.views.pembayaranKarcis.';
  public $path_view = 'billingKasir.views.pembayaranTagihanPasien.';

  public function actionIndex($view = null, $id = null)
  {
    $successSave = false;
    $tandaBukti = new TandabuktibayarT;

    if (isset($_POST['pembayaran'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $tandaBukti = $this->saveTandabuktiBayar($_POST['TandabuktibayarT']);
        $_POST['pembayaran'][0]['kasir'] = "bayar karcis";
        if (isset($_POST['pembayaranAlkes'])) {
          $this->savePembayaranPelayanan($tandaBukti, $_POST['pembayaran'], $_POST['pembayaranAlkes']);
        } else {
          $this->savePembayaranPelayanan($tandaBukti, $_POST['pembayaran']);
        }

        $transaction->commit();
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        if (isset($_GET['frame']) && !empty($_GET['pendaftaran_id'])) {
          $this->redirect(array(((isset($view)) ? $view : 'index'), 'id' => $tandaBukti->tandabuktibayar_id, 'frame' => $_GET['frame'], 'pendaftaran_id' => $_GET['pendaftaran_id']));
        }
        $successSave = true;
        //echo "<pre>".print_r($_POST,1)."</pre>";
      } catch (Exception $exc) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $transaction->rollback();
      }
    }
    if (isset($_GET['frame']) && !empty($_GET['pendaftaran_id'])) {
      $this->layout = 'iframe';
      $pendaftaran_id = $_GET['pendaftaran_id'];
      $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = BKPasienM::model()->findByPk($modPendaftaran->pasien_id);
      $criteria = new CDbCriteria;
      if (isset($_GET['pendaftaran_id'])) {
        if (!empty($_GET['pendaftaran_id'])) {
          $criteria->addCondition("pendaftaran_id = " . $_GET['pendaftaran_id']);
        }
      }
      $criteria->addCondition('t.karcis_id IS NOT NULL');
      $modTindakan = BKTindakanPelayananT::model()->with('daftartindakan', 'tipepaket')->findAll($criteria);
      $modTandaBukti = new TandabuktibayarT;
      $modTandaBukti->darinama_bkm = $modPasien->nama_pasien;
      $modTandaBukti->alamat_bkm = $modPasien->alamat_pasien;
    } else {
      $modPendaftaran = new BKPendaftaranT;
      $modPasien = new BKPasienM;
      $modTindakan[0] = new BKTindakanPelayananT;
      $modObatalkes[0] = new BKObatalkesPasienT;
      $modTandaBukti = new TandabuktibayarT;
    }

    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modTindakan' => $modTindakan,
      'modTandaBukti' => $modTandaBukti,
      'tandaBukti' => $tandaBukti,
      'id' => $id,
      'successSave' => $successSave
    ));
  }

  public function actionPrintRincianSudahBayar($idTandaBukti)
  {

    $this->layout = '//layouts/printWindows';
    $model = TandabuktibayarT::model()->findByPk($idTandaBukti);
    $modPembayaran = BKPembayaranpelayananT::model()->findByPk($model->pembayaranpelayanan_id);
    $modPendaftaran = BKPendaftaranT::model()->findByPk($modPembayaran->pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPemakaianuangmuka = BKPemakaianuangmukaT::model()->findByAttributes(array('pembayaranpelayanan_id' => $model->pembayaranpelayanan_id));
    $data['judulLaporan'] = 'RINCIAN BIAYA (' . $modPembayaran->statusbayar . ")";
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    $criteria = new CDbCriteria();
    $criteria->addCondition('pendaftaran_id = ' . $modPembayaran->pendaftaran_id);
    $criteria->addCondition('pembayaranpelayanan_id = ' . $model->pembayaranpelayanan_id);
    $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
    $criteria->order = 'ruangan_id';
    $modRincian = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
    $this->render('printRincianSudahBayar', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modPembayaran' => $modPembayaran, 'modPemakaianuangmuka' => $modPemakaianuangmuka, 'modRincian' => $modRincian, 'data' => $data));
  }

  protected function cekSubsidi($modTindakan)
  {
    $subsidi = array();
    $carabayar_id = isset($modTindakan->carabayar_id) ? $modTindakan->carabayar_id : null;
    $penjamin_id = isset($modTindakan->penjamin_id) ? $modTindakan->penjamin_id : null;
    $kelaspelayanan_id = isset($modTindakan->kelaspelayanan_id) ? $modTindakan->kelaspelayanan_id : null;
;
    if($carabayar_id && $penjamin_id && $kelaspelayanan_id){
      switch ($modTindakan->tipepaket_id) {
        case Params::TIPEPAKET_ID_NONPAKET:
          $sql = "SELECT * FROM tanggunganpenjamin_m
                              WHERE carabayar_id = " . $carabayar_id. "
                                AND penjamin_id = " . $penjamin_id. "
                                AND kelaspelayanan_id = " . $kelaspelayanan_id. "
                                AND tipenonpaket_id = " . $modTindakan->tipepaket_id . "
                                AND tanggunganpenjamin_aktif = TRUE ";
          $data = Yii::app()->db->createCommand($sql)->queryRow();
  
          $subsidi['asuransi'] = ($data['subsidiasuransitind'] != '') ? ($data['subsidiasuransitind'] / 100 * $modTindakan->tarif_tindakan) : 0;
          $subsidi['pemerintah'] = ($data['subsidipemerintahtind'] != '') ? ($data['subsidipemerintahtind'] / 100 * $modTindakan->tarif_tindakan) : 0;
          $subsidi['rumahsakit'] = ($data['subsidirumahsakittind'] != '') ? ($data['subsidirumahsakittind'] / 100 * $modTindakan->tarif_tindakan) : 0;
          $subsidi['iurbiaya'] = ($data['iurbiayatind'] != '') ? ($data['iurbiayatind'] / 100 * $modTindakan->tarif_tindakan) : 0;
          $subsidi['max'] = $data['makstanggpel'];
          break;
        case Params::TIPEPAKET_ID_LUARPAKET:
          $sql = "SELECT subsidiasuransi,subsidipemerintah,subsidirumahsakit,iurbiaya FROM paketpelayanan_m
                              JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = paketpelayanan_m.daftartindakan_id
                              JOIN kategoritindakan_m ON kategoritindakan_m.kategoritindakan_id = daftartindakan_m.kategoritindakan_id
                              JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = paketpelayanan_m.daftartindakan_id 
                                  AND komponentarif_id = " . Params::KOMPONENTARIF_ID_TOTAL . "
                              WHERE tariftindakan_m.kelaspelayanan_id = " . $modTindakan->kelaspelayanan_id . "
                                  AND ruangan_id = " . $modTindakan->create_ruangan . "
                                  AND daftartindakan_m.daftartindakan_id = " . $modTindakan->daftartindakan_id . "
                                  AND paketpelayanan_m.tipepaket_id = " . $modTindakan->tipepaket_id;
          $data = Yii::app()->db->createCommand($sql)->queryRow();
  
          $subsidi['asuransi'] = ($data['subsidiasuransi'] != '') ? $data['subsidiasuransi'] : 0;
          $subsidi['pemerintah'] = ($data['subsidipemerintah'] != '') ? $data['subsidipemerintah'] : 0;
          $subsidi['rumahsakit'] = ($data['subsidirumahsakit'] != '') ? $data['subsidirumahsakit'] : 0;
          $subsidi['iurbiaya'] = ($data['iurbiaya'] != '') ? $data['iurbiaya'] : 0;
          break;
        case null:
          $subsidi['asuransi'] = 0;
          $subsidi['pemerintah'] = 0;
          $subsidi['rumahsakit'] = 0;
          $subsidi['iurbiaya'] = 0;
          break;
        default:
          $sql = "SELECT subsidiasuransi,subsidipemerintah,subsidirumahsakit,iurbiaya FROM paketpelayanan_m
                              JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = paketpelayanan_m.daftartindakan_id
                              JOIN kategoritindakan_m ON kategoritindakan_m.kategoritindakan_id = daftartindakan_m.kategoritindakan_id
                              JOIN tariftindakan_m ON tariftindakan_m.daftartindakan_id = paketpelayanan_m.daftartindakan_id 
                                  AND komponentarif_id = " . Params::KOMPONENTARIF_ID_TOTAL . "
                              WHERE tariftindakan_m.kelaspelayanan_id = " . $modTindakan->kelaspelayanan_id . "
                                  AND ruangan_id = " . $modTindakan->create_ruangan . "
                                  AND daftartindakan_m.daftartindakan_id = " . $modTindakan->daftartindakan_id . "
                                  AND paketpelayanan_m.tipepaket_id = " . $modTindakan->tipepaket_id;
          $data = Yii::app()->db->createCommand($sql)->queryRow();
  
          $subsidi['asuransi'] = ($data['subsidiasuransi'] != '') ? $data['subsidiasuransi'] : 0;
          $subsidi['pemerintah'] = ($data['subsidipemerintah'] != '') ? $data['subsidipemerintah'] : 0;
          $subsidi['rumahsakit'] = ($data['subsidirumahsakit'] != '') ? $data['subsidirumahsakit'] : 0;
          $subsidi['iurbiaya'] = ($data['iurbiaya'] != '') ? $data['iurbiaya'] : 0;
          break;
      }
  
    }

    return $subsidi;
  }

  public function actionPrintRincianSudahBayarNew($idTandaBukti)
  {
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    $modRincians = null;
    $model = TandabuktibayarT::model()->findByPk($idTandaBukti);
    $modPembayaran = BKPembayaranpelayananT::model()->findByPk($model->pembayaranpelayanan_id);
    $criteria = new CDbCriteria();
    $criteria->addCondition('pendaftaran_id = ' . $modPembayaran->pendaftaran_id);
    $criteria->addCondition('pembayaranpelayanan_id = ' . $model->pembayaranpelayanan_id);
    $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
    $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';
    $modRincians = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
    $this->render($this->path_view . 'printRincianSudahBayar', array('modRincians' => $modRincians));
  }

  public function actionPrintDetailKasMasuk($idPembayaran, $caraPrint)
  {
    $caraPrint = null;
    $format = new MyFormatter;
    $criteria = new CDbCriteria();
    //            $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
    $criteria->addCondition('pembayaranpelayanan_id = ' . $idPembayaran);
    $criteria->addCondition('tindakansudahbayar_id IS NOT NULL'); //sudah lunas
    $criteria->order = 'ruangan_id';
    $detail = BKRinciantagihanpasiensudahbayarV::model()->findAll($criteria);
    $func = new CustomFunction;

    $no_bkm = '';
    $tgl_bkm = '';
    $pembayar = '';
    $total_bayar = '';
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
        'total_bayar' => $total_bayar,
        'total_bayar_huruf' => $format->formatNumberTerbilang($total_bayar),
        'pembayar' => $pembayar,
      ),
      'detail' => $rec,
      'footer' => 123,
    );
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render(
        'detailKasMasuk',
        array(
          'data' => $data,
          'caraPrint' => $caraPrint
        )
      );
    } else {
      $this->layout = '//layouts/iframe';
      $ukuranKertasPDF = 'RBK';                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      //                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 5, 5, 5, 5);
      $mpdf->WriteHTML(
        $this->render(
          'detailKasMasuk',
          array(
            'data' => $data,
            'caraPrint' => $caraPrint
          ),
          true
        )
      );
      $mpdf->Output();
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
