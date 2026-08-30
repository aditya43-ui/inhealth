<?php

class InfoPenjualanResepController extends MyAuthController
{
  private $suksesRetur = false;
  private $suksesReturBayar = false;

  public function actionIndex()
  {
    $modInfo = new FAInformasipenjualanapotikV('searchInfoJualResep');
    $modInfo->unsetAttributes();
    $modInfo->tgl_awal = date("d M Y") . ' 00:00:00';
    $modInfo->tgl_akhir = date("d M Y") . ' 23:59:59';
    if (isset($_GET['FAInformasipenjualanapotikV'])) {
      $format = new MyFormatter();
      $modInfo->attributes = $_GET['FAInformasipenjualanapotikV'];
      $modInfo->tgl_awal = $format->formatDateTimeForDb($_GET['FAInformasipenjualanapotikV']['tgl_awal']);
      $modInfo->tgl_akhir = $format->formatDateTimeForDb($_GET['FAInformasipenjualanapotikV']['tgl_akhir']);
    }

    $this->render('index', array('modInfo' => $modInfo));
  }

  public function actionLihatPenjualan($idReseptur)
  {
    $this->layout = 'iframe';

    $detailJuals = FAInformasipenjualanapotikV::model()->findAllByAttributes(array('reseptur_id' => $idReseptur));

    $this->render('lihatPenjualan', array('detailJuals' => $detailJuals));
  }

  public function actionBatalJualObat()
  {
    $idPenjualanResep = $_POST['idPenjualanResep'];
    $idObatAlkes = $_POST['idObatAlkes'];
    $idReseptur = $_POST['idReseptur'];

    $obatAlkesPasien = ObatalkespasienT::model()->findByAttributes(array('penjualanresep_id' => $idPenjualanResep, 'obatalkes_id' => $idObatAlkes));
    if (!empty($obatAlkesPasien)) {
      //-- insert stok --
      $stok = new StokobatalkesT;
      $stok->unsetIdTransaksi();
      $stok->obatalkes_id = $idObatAlkes;
      $stok->qtystok_in = $obatAlkesPasien->qty_oa;
      $stok->qtystok_out = 0;
      $stok->qtystok_current = $obatAlkesPasien->qty_oa;
      $stok->satuankecil_id = $obatAlkesPasien->satuankecil_id;
      $stok->sumberdana_id = $obatAlkesPasien->sumberdana_id;
      $stok->harganetto_oa = $obatAlkesPasien->harganetto_oa;
      $stok->hargajual_oa = $obatAlkesPasien->hargajual_oa;
      $stok->discount = $obatAlkesPasien->discount;
      $stok->tglstok_in = date('Y-m-d H:i:s');
      $stok->ruangan_id = Yii::app()->user->getState('ruangan_id');
      if ($stok->save()) {
        //-- update penjualan resep --
        $pembulatanHarga = Yii::app()->user->getState('pembulatanharga');
        $penjualan = PenjualanresepT::model()->findByPk($idPenjualanResep);
        $hargajual = $penjualan->totalhargajual - $stok->hargajual_oa;
        $harganetto = $penjualan->totharganetto - $stok->harganetto_oa;
        $pembulatan = $hargajual % $pembulatanHarga;
        $jmlpembulatan = $pembulatanHarga - $pembulatan;

        PenjualanresepT::model()->updateByPk($idPenjualanResep, array(
          'totalhargajual' => $hargajual,
          'totharganetto' => $harganetto,
          'pembulatanharga' => $jmlpembulatan
        ));

        //-- hapus obatalkespasien -- 
        ObatalkespasienT::model()->deleteByPk($obatAlkesPasien->obatalkespasien_id);
      } else {
        $returnVar['errorMessage'] = '<pre>' . print_r($stok->getErrors(), 1) . '</pre>';
      }

      $detailJuals = FAInformasipenjualanapotikV::model()->findAllByAttributes(array('reseptur_id' => $idReseptur));
      $tblPenjualan = $this->renderPartial('_tblPenjualan', array('detailJuals' => $detailJuals), true);
      $returnVar['sukses'] = 1;
      $returnVar['tblPenjualan'] = $tblPenjualan;
    } else {
      $returnVar['sukses'] = 0;
    }

    echo CJSON::encode($returnVar);
  }

  /**
   * method retur penjualan resep yang sudah dibayar
   * digunakan di 
   * 1. farmasi Apotek -> informasi penjualan resep -> retur penjualan
   * @param integer $idPenjualanResep penjualanresep_id
   */
  public function actionReturPenjualan($idPenjualanResep = null, $id = null)
  {
    $this->layout = '//layouts/iframe';
    $modRetur = new FAReturresepT;
    $modRetur->tglretur = date('Y-m-d H:i:s');
    $modRetur->noreturresep = MyGenerator::noReturResep();

    if (isset($idPenjualanResep)) {
      $detailJuals = FAInformasipenjualanapotikV::model()->findAllByAttributes(array('penjualanresep_id' => $idPenjualanResep));
      $modPenjualanResep = PenjualanresepT::model()->find('penjualanresep_id=:penjualanresep and returresep_id is null', array(':penjualanresep' => $idPenjualanResep));
    }
    if (!empty($id)) {
      $modRetur = ReturresepT::model()->findByPk($id);
      $detailJuals = FAInformasipenjualanapotikV::model()->findAllByAttributes(array('penjualanresep_id' => $modRetur->penjualanresep_id));
      $modPenjualanResep = PenjualanresepT::model()->findByPk($modRetur->penjualanresep_id);
      if (!empty($modRetur)) {
        $modReturDetail = ReturresepdetT::model()->findAllByAttributes(array('returresep_id' => $id));
      }
    } else {
      if (!empty($modPenjualanResep)) {
        $obatpasiens = ObatalkespasienT::model()->findAll('penjualanresep_id =:penjualanresep and returresepdet_id is null', array(':penjualanresep' => $idPenjualanResep));
        $modRetur->attributes = $modPenjualanResep->attributes;
        if (count((array)$obatpasiens) > 0) {
          foreach ($obatpasiens as $key => $value) {
            $sql = 'select sum(qty_retur) as summary from returresepdet_t where obatalkespasien_id = ' . $value->obatalkespasien_id;
            $result = Yii::app()->db->createCommand($sql)->queryRow();
            //                            if ($result['summary'] < $value->qty_oa){
            $modReturDetail[$key] = new ReturresepdetT();
            $modReturDetail[$key]->attributes = $value->attributes;
            //                                $modReturDetail[$key]->qty_retur = $value->qty_oa - $result['summary'];
            $modReturDetail[$key]->qty_retur = $value->qty_oa;
            $modReturDetail[$key]->hargasatuan = $value->hargasatuan_oa;
            //                            }
          }
        }
      } else {
        echo '<script type="text/javascript">parent.location.href="' . Yii::app()->createUrl("farmasiApotek/InformasiPenjualanResep/Index", array("modul_id" => $_GET['modul_id'])) . '";</script>';
        Yii::app()->user->setFlash('success', "Data Penjualan Resep Tidak Ditemukan");
        exit();
      }
    }

    if (count((array)$detailJuals) < 1) {
      //                Yii::app()->user->setFlash('success',"Data Penjualan Resep Tidak Ditemukan");
      //                exit();
      $detailJuals[0] = new FAInformasipenjualanapotikV();
    }


    if (isset($_POST['FAReturresepT']) && empty($id)) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modRetur = $this->saveReturResep($modRetur, $_POST['FAReturresepT'], $_POST['ReturresepdetT']);
        $modReturDetail = $this->saveReturResepDetail($modRetur, $modReturDetail, $_POST['ReturresepdetT']);

        $returPembayaran = $this->saveReturPembayaran($modRetur, $modReturDetail);

        if ($this->suksesRetur && $this->suksesReturBayar) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        } else {
          $modRetur->isNewRecord = true;
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $modRetur->isNewRecord = true;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('returPenjualan', array(
      'detailJuals' => $detailJuals, 'modPenjualanResep' => $modPenjualanResep,
      'modRetur' => $modRetur, 'modDetailRetur' => $modReturDetail
    ));
  }

  /**
   * method to save retur bayar pelayanan T
   * @param object $modRetur
   * @param object $modDetailRetur
   * @return \ReturbayarpelayananT 
   */
  protected function saveReturPembayaran($modRetur, $modDetailRetur)
  {
    $modReturBayar = new ReturbayarpelayananT();
    $modReturBayar->user_id_otorisasi = Yii::app()->user->id;
    $modReturBayar->user_nm_otorisasi = Yii::app()->user->name;
    $biayaAdministrasi = (isset($_POST['totBiayaAdministrasi'])) ? $_POST['totBiayaAdministrasi'] : 0;
    $modReturBayar->biayaadministrasi = $biayaAdministrasi;
    $modReturBayar->totaltindakanretur = 0;
    $modReturBayar->totaloaretur = $_POST['totalHargaReturOa'];
    $modReturBayar->totalbiayaretur = ($modReturBayar->totaloaretur - $modReturBayar->biayaadministrasi);
    $modReturBayar->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modReturBayar->noreturbayar = MyGenerator::noReturBayarPelayanan();
    $modReturBayar->tglreturpelayanan = date('Y-m-d H:i:s');
    $modReturBayar->keteranganretur = $modRetur->alasanretur;
    $modReturBayar->returresep_id = $modRetur->returresep_id;
    if ($modReturBayar->validate()) {
      $modReturBayar->save();
      $this->suksesReturBayar = true;
    }

    return $modReturBayar;
  }

  public function actionPrintReturPenjualan($id)
  {
    $model = array();
    $details = array();
    $judulKwitansi = array();
    $modRetur = ReturresepT::model()->findByPk($id);
    $detail = ReturresepdetT::model()->findAll('returresep_id = ' . $modRetur->returresep_id);
    $detailRetur = ReturbayarpelayananT::model()->find('returresep_id = ' . $modRetur->returresep_id);
    $modPenjualanResep = PenjualanresepT::model()->findByPk($modRetur->penjualanresep_id);
    $modPendaftaran = PendaftaranT::model()->findByPk($modPenjualanResep->pendaftaran_id);
    //            if (count((array)$detail) > 0){
    //                $details = array();
    //                foreach ($detail as $key => $value) {
    //                    $obatalkes = ObatalkespasienT::model()->findByPk($value->obatalkespasien_id);
    //                    $details[0]['uraian'] = "Obatalkes";
    //                    $details[0]['harga'] += ($obatalkes->hargajual_oa + $obatalkes->biayaadministrasi + $obatalkes->biayakonseling + $obatalkes->biayaservice + $obatalkes->jasadokterresep);
    //                    $details[0]['diskon'] += ($obatalkes->hargasatuan_oa*$obatalkes->discount)/100;
    //                    $details[0]['qty'] = 1;
    //                }
    //            }
    $judulLaporan = 'Laporan Retur Penjualan Resep';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('view', array(
        'model' => $model, 'details' => $details, 'modRetur' => $modRetur, 'modPenjualanResep' => $modPenjualanResep,
        'modPendaftaran' => $modPendaftaran, 'judulKwitansi' => $judulKwitansi, 'caraPrint' => $caraPrint, 'detailRetur' => $detailRetur
      ));
    }
  }


  protected function saveReturResep($modRetur, $retur, $returdetail)
  {
    $modRetur->attributes = $retur;
    $modRetur->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modRetur->totalretur = $_POST['totalHargaRetur'];
    if ($modRetur->validate()) {
      if ($modRetur->save()) {
        $this->suksesRetur = true;
      }
    }
    return $modRetur;
  }

  protected function saveReturResepDetail($modRetur, $modReturDetail, $returdetail)
  {
    if (count((array)$returdetail) > 0) {
      foreach ($returdetail as $i => $detail) {
        if ($detail['qty_retur'] > 0) {
          $modReturDetail[$i]->returresep_id = $modRetur->returresep_id;
          $modReturDetail[$i]->obatalkespasien_id = $detail['obatalkespasien_id'];
          $modReturDetail[$i]->satuankecil_id = $detail['satuankecil_id'];
          $modReturDetail[$i]->qty_retur = $detail['qty_retur'];
          $modReturDetail[$i]->hargasatuan = (isset($detail['hargasatuan']) ? $detail['hargasatuan'] : 0);
          if ($modReturDetail[$i]->validate()) {
            $modReturDetail[$i]->save();
            //                          RETUR TIDAK BOLEH MENGEDIT TRANSAKSI PENJUALAN  <<< 
            $this->updateObatAlkesPasien($modReturDetail[$i]);
          }
        }
      }
    }

    return $modReturDetail;
  }
  /**
   * updateObatAlkesPasien untuk transaksi retur resep
   * @param type $modDetailRetur
   */
  protected function updateObatAlkesPasien($modDetailRetur)
  {
    $modObatAlkesPasien = ObatalkespasienT::model()->findByPk($modDetailRetur->obatalkespasien_id);
    $qtyBaru = $modObatAlkesPasien->qty_oa - $modDetailRetur->qty_retur;
    $hargaJualRetur = $modObatAlkesPasien->hargasatuan_oa * $modDetailRetur->qty_retur;
    $hargaJualBaru = $modObatAlkesPasien->hargajual_oa - $hargaJualRetur;
    ObatalkespasienT::model()->updateByPk(
      $modDetailRetur->obatalkespasien_id,
      array('qty_oa' => $qtyBaru)
    );
    //                        'hargajual_oa'=>$hargaJualBaru,
    //                        'returresepdet_id'=>$modDetailRetur->returresepdet_id
    $penjualanResep = PenjualanresepT::model()->findByPk($modObatAlkesPasien->penjualanresep_id);
    $totHargaJualBaru = $penjualanResep->totalhargajual - $hargaJualRetur;
    if ($qtyBaru == 0) {
      PenjualanresepT::model()->updateByPk($penjualanResep->penjualanresep_id, array(
        'returresep_id' => $modDetailRetur->returresep_id,
        'totalhargajual' => $totHargaJualBaru
      ));
      ObatalkespasienT::model()->updateByPk($modDetailRetur->obatalkespasien_id, array('returresepdet_id' => $modDetailRetur->returresepdet_id));
    } else {
      PenjualanresepT::model()->updateByPk($penjualanResep->penjualanresep_id, array('totalhargajual' => $totHargaJualBaru));
    }

    $this->kembalikanStok($modDetailRetur->qty_retur, $modObatAlkesPasien);
  }
  /**
   * kembalikanStok digunakan jika kondisinya perubahan transaksi penjualan dengan qty yang berkurang
   * @param type $qty
   * @param type $idobatAlkes
   */
  protected function kembalikanStok($qty, $modObatAlkesPasien)
  {
    $ruanganid = Yii::app()->user->getState('ruangan_id'); //Retur harus berdasarkan tempat penjualan
    $modStokObat = StokobatalkesT::model()->findAllByAttributes(array('obatalkes_id' => $modObatAlkesPasien->obatalkes_id, 'ruangan_id' => $ruanganid), array('order' => 'tglstok_in ASC'));
    //            $sql = "SELECT stokobatalkes_id,qtystok_in,qtystok_out,qtystok_current FROM stokobatalkes_t WHERE obatalkes_id = $idobatAlkes AND ruangan_id = $ruanganid  ORDER BY tglstok_in ASC";
    //            $stoks = Yii::app()->db->createCommand($sql)->queryAll();
    $selesai = false;
    foreach ($modStokObat as $i => $stokObat) {
      if (($qty <= $stokObat->qtystok_out) && ($qty > 0)) {
        $stokObat->qtystok_out = $stokObat->qtystok_out - $qty;
        $stokObat->qtystok_in = $stokObat->qtystok_in + $qty;
        $qty = 0;
      } else if (($qty > $stokObat->qtystok_out) && ($qty > 0)) {
        $selisih = $qty - $stokObat->qtystok_out;
        $stokObat->qtystok_in = $stokObat->qtystok_in + $stokObat->qtystok_out;
        $stokObat->qtystok_out = 0;
        $qty = $selisih;
      } else {
        break;
      }
      $stokObat->qtystok_current = $stokObat->qtystok_in - $stokObat->qtystok_out;
      $stokObat->save(); //update data perubahan
    }
  }

  public function actionCekLogin($task = 'Retur')
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
