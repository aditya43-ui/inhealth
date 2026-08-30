<?php

class BatalBayarSupplierController extends MyAuthController
{
  protected $successSave = true;
  public $path_view = 'billingKasir.views.batalBayarSupplier.';

  public function actionIndex()
  {

    Yii::import('application.modules.keuangan.models.KURekeningakuntansiV');
    Yii::import('application.modules.keuangan.models.KUPenerimaanUmumT');

    if (!empty($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }

    $modBatalBayar = new BKBatalBayarSupplierT;
    $biayaadmin = 0;
    $biayamaterai = 0;
    $supplier_nama = "";

    if (!empty($_GET['tandabuktikeluar_id'])) {
      $modBuktiKeluar = BKTandabuktikeluarT::model()->findByPk($_GET['tandabuktikeluar_id']);

      $modBayarSupplier = BKBayarkeSupplierT::model()->findByPk($modBuktiKeluar->bayarkesupplier_id);
      $biayaadmin = $modBuktiKeluar->biayaadministrasi;
      $biayamaterai = $modBuktiKeluar->biaya_materai;

      if (!empty($modBayarSupplier->fakturpembelian_id)) {
        $modFaktur = FakturpembelianT::model()->findByPk($modBayarSupplier->fakturpembelian_id);
      }

      if (!empty($modBayarSupplier->terimapersediaan_id)) {
        $modFaktur = TerimapersediaanT::model()->findByPk($modBayarSupplier->terimapersediaan_id);
      }

      if (!empty($modBayarSupplier->terimabahanmakan_id)) {
        $modFaktur = TerimabahanmakanT::model()->findByPk($modBayarSupplier->terimabahanmakan_id);
      }

      if (isset($modFaktur)) {
        $supplier = SupplierM::model()->findByPk($modFaktur->supplier_id);
      }



      $modBatalBayar->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;
      $modBatalBayar->bayarkesupplier_id = $modBayarSupplier->bayarkesupplier_id;
    } else {
      $modBuktiKeluar = new BKTandabuktikeluarT;
      $modBayarSupplier = new BKBayarkeSupplierT;
    }


    $modTandabukti = new TandabuktibayarT;
    $modTandabukti->nobuktibayar = "-- Otomatis --";
    $modTandabukti->carapembayaran = Params::CARAPEMBAYARAN_TUNAI;
    $modTandabukti->biayaadministrasi = $biayaadmin;
    $modTandabukti->biayamaterai = $biayamaterai;

    $modPenUmum = new KUPenerimaanUmumT;

    if (!empty($supplier)) {
      $modTandabukti->darinama_bkm = $supplier->supplier_nama;
      $modTandabukti->alamat_bkm = $supplier->supplier_alamat;
    }
    $modTandabukti->sebagaipembayaran_bkm = "BATAL BAYAR KE SUPPLIER " . $modTandabukti->darinama_bkm . " - "; //.$modBuktiKeluar->nokaskeluar;
    if (!empty($modFaktur)) {
      $modTandabukti->sebagaipembayaran_bkm .= $modFaktur->nofaktur;
    } else {
      $modTandabukti->sebagaipembayaran_bkm .= $modBuktiKeluar->nokaskeluar;
    }


    if (isset($_POST['BKBatalBayarSupplierT'])) {

      $modBuktiKeluar->attributes = $_POST['BKTandabuktikeluarT'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modBatalBayar = $this->saveBatalBayarSupplier($_POST['BKBatalBayarSupplierT']);

        $modTandaBukti = $this->saveTandaBukti($_POST['TandabuktibayarT']);
        $modPenUmum = $this->savePenerimaan($_POST['KUPenerimaanUmumT'], $modTandaBukti, $modBatalBayar);

        if (isset($_POST['RekeningakuntansiV'])) {

          $modJurnalRekening = $this->saveJurnalRekening($modPenUmum, $modBatalBayar, $modBayarSupplier, $modTandabukti);
          $modJurnalDetail = $this->saveJurnalDetail(
            $_POST['KUPenerimaanUmumT'],
            $modJurnalRekening,
            // $modJurnalPosting,
            $_POST['RekeningakuntansiV'],
            null
          );
        } else {
          if (!empty($modBatalBayar->batalbayarsupplier_id)) {
            //                        $res = Yii::app()->db
            //                            ->createCommand("select set_afterbatalbayarsupplier_fix(".$modBatalBayar->batalbayarsupplier_id.") as simpan")
            //                            ->queryRow();

            //                        if (!empty($res)) {
            //                            $this->successSave = $this->successSave && $res['simpan'];
            //                        }
            // var_dump($res);
          }
        }

        // var_dump($_POST);
        // var_dump($this->successSave); die;

        if ($this->successSave) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'modBuktiKeluar' => $modBuktiKeluar,
      'modBayarSupplier' => $modBayarSupplier,
      'modBatalBayar' => $modBatalBayar,
      'modTandabukti' => $modTandabukti,
      'modPenUmum' => $modPenUmum,
    ));
  }

  protected function saveBatalBayarSupplier($postBatalBayar)
  {
    $modBatalBayar = new BKBatalBayarSupplierT;
    $modBatalBayar->attributes = $postBatalBayar;
    $modBatalBayar->ruangan_id = Yii::app()->user->getState('ruangan_id');


    // var_dump($modBatalBayar->attributes); die;

    if ($modBatalBayar->validate()) {
      $this->successSave = $this->successSave && $modBatalBayar->save();
      BayarkesupplierT::model()->updateByPk($modBatalBayar->bayarkesupplier_id, array(
        'batalbayarsupplier_id' => $modBatalBayar->batalbayarsupplier_id,
      ));
    } else {
      $this->successSave = false;
    }

    return $modBatalBayar;
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

  public function actionInfoBayarSupplier()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->with = array('bayarsupplier');
      $criteria->compare('LOWER(nokaskeluar)', strtolower($_GET['term']), true);
      $criteria->addCondition('t.bayarkesupplier_id IS NOT NULL');
      $models = TandabuktikeluarT::model()->findAll($criteria);
      if (count((array)$models) > 0) {
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->nokaskeluar . ' - ' . $model->namapenerima;
          $returnVal[$i]['value'] = $model->nokaskeluar;
          $returnVal[$i]['tglbayarkesupplier'] = $model->bayarsupplier->tglbayarkesupplier;
          $returnVal[$i]['totaltagihan'] = $model->bayarsupplier->totaltagihan;
          $returnVal[$i]['jmldibayarkan'] = $model->bayarsupplier->jmldibayarkan;
        }
      } else {
        $returnVal = null;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Dupliasi fungsi dari keuangan.penerimaanUmum
   */
  protected function saveTandaBukti($postTandaBukti)
  {
    $format = new MyFormatter();
    $modTandaBukti = new TandabuktibayarT;
    $modTandaBukti->attributes = $postTandaBukti;
    $modTandaBukti->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modTandaBukti->nourutkasir = MyGenerator::noUrutKasir($modTandaBukti->ruangan_id);
    $modTandaBukti->nobuktibayar = MyGenerator::noBuktiBayar();
    $modTandaBukti->shift_id = Yii::app()->user->getState('shift_id');
    $modTandaBukti->tglbuktibayar = $format->formatDateTimeForDb($postTandaBukti['tglbuktibayar']);
    $modTandaBukti->create_time = date('Y-m-d H:i:s');
    $modTandaBukti->jmlpembulatan = 0;
    $modTandaBukti->create_loginpemakai_id = Yii::app()->user->id;
    $modTandaBukti->create_ruangan = Yii::app()->user->getState('ruangan_id');
    if ($modTandaBukti->validate()) {
      $modTandaBukti->save();
      $this->successSave = true;
    } else {
      $this->successSave = false;
      // var_dump($modTandaBukti->errors); die;
      throw new CDbException("Data tanda bukti bayar belum lengkap");
    }

    // var_dump($modTandaBukti->attributes);

    return $modTandaBukti;
  }

  protected function savePenerimaan($postPenerimaan, $modTandaBukti, $modBatalBayar)
  {

    // var_dump($modBatalBayar->attributes); die;

    $modPenUmum = new KUPenerimaanUmumT;
    $modPenUmum->attributes = $postPenerimaan;
    $modPenUmum->tglpenerimaan = $modTandaBukti->tglbuktibayar;
    $modPenUmum->nopenerimaan = MyGenerator::noPenerimaanUmum();
    $modPenUmum->volume = 1;
    $modPenUmum->satuanvol = 'KALI';
    $modPenUmum->hargasatuan = $modTandaBukti->jmlpembayaran;
    $modPenUmum->totalharga = $modPenUmum->volume * $modPenUmum->hargasatuan;
    $modPenUmum->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPenUmum->penjamin_id = Params::PENJAMIN_ID_UMUM;
    $modPenUmum->tandabuktibayar_id = $modTandaBukti->tandabuktibayar_id;
    $modPenUmum->batalbayarsupplier_id = $modBatalBayar->batalbayarsupplier_id;
    $modPenUmum->keterangan_penerimaan = $modTandaBukti->sebagaipembayaran_bkm;
    // var_dump($modPenUmum->attributes); die;

    if ($modPenUmum->validate()) {
      $modPenUmum->save();
      $this->successSave = true;
    } else {
      $this->successSave = false;
      // var_dump($modPenUmum->errors); die;
      throw new CDbException("Data penerimaan belum lengkap");
    }

    // var_dump($modPenUmum->attributes); die;

    return $modPenUmum;
  }

  protected function saveJurnalRekening($modPenUmum, $modBatalBayar, $modBayarSupplier, $modTandabukti)
  {

    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }
    $nofaktur = "";

    if (!empty($modBayarSupplier->fakturpembelian_id)) {
      $modFakturBeli = FakturpembelianT::model()->findByPk($modBayarSupplier->fakturpembelian_id);
      $nofaktur = $modFakturBeli->nofaktur;
    }

    if (!empty($modBayarSupplier->terimapersediaan_id)) {
      $modFakturBeli = TerimapersediaanT::model()->findByPk($modBayarSupplier->terimapersediaan_id);
      $nofaktur = $modFakturBeli->nofaktur;
    }

    if (!empty($modBayarSupplier->terimabahanmakan_id)) {
      $modFakturBeli = TerimabahanmakanT::model()->findByPk($modBayarSupplier->terimabahanmakan_id);
      $nofaktur = $modFakturBeli->nofaktur;
    }

    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->tglbuktijurnal = $modPenUmum->tglpenerimaan;
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRekTanggal($modPenUmum->tglpenerimaan, 'JTK');
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $modPenUmum->nopenerimaan;
    $modJurnalRekening->tglreferensi = $modPenUmum->tglpenerimaan;
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = $modTandabukti->sebagaipembayaran_bkm;
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENERIMAAN_KAS;
    $modJurnalRekening->rekperiod_id = $period;
    $modJurnalRekening->create_time = $modPenUmum->tglpenerimaan;
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modJurnalRekening->batalbayarsupplier_id = $modBatalBayar->batalbayarsupplier_id;

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->successSave = true;
    } else {
      $this->successSave = false;
      throw new CDbException("Data jurnal rekening belum lengkap");
    }
    return $modJurnalRekening;
  }


  protected function saveJurnalDetail($arrJurnal, $modJurnalRekening, $rekeningakuntansi, $modJurnalPosting = null)
  {

    $valid = true;
    foreach ($rekeningakuntansi as $i => $data) {

      $model = new JurnaldetailT();
      // $model->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
      $model->rekperiod_id = $modJurnalRekening->rekperiod_id;
      $model->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
      $model->uraiantransaksi = $modJurnalRekening->urianjurnal;
      //			$model->uraiantransaksi = isset($data['nama_rekening']) ? $data['nama_rekening'] : "";
      $model->saldodebit = isset($data['saldodebit']) ? $data['saldodebit'] : 0;
      $model->saldokredit = isset($data['saldokredit']) ? $data['saldokredit'] : 0;
      $model->nourut = $i + 1;
      $model->rekening5_id = isset($data['rekening5_id']) ? $data['rekening5_id'] : null;
      $model->catatan = "";

      if ($model->validate()) {
        $model->save();
      } else {
        $valid = false;
        throw new CDbException("Data jurnal rekening detail belum lengkap");
        break;
      }

      // var_dump($model->attributes);
    }

    // die;

    $this->successSave = $valid;
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

  public function actionGetDataRekeningBatalSupplier()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $bayarkesupplier_id = isset($_POST['bayarkesupplier_id']) ? $_POST['bayarkesupplier_id'] : null;
      $tandabuktikeluar_id = isset($_POST['tandabuktikeluar_id']) ? $_POST['tandabuktikeluar_id'] : null;

      $carabayarkeluar = isset($_POST['carabayarkeluar']) ? $_POST['carabayarkeluar'] : null;
      $bankid = ((isset($_POST['bankid']) && !empty($_POST['bankid'])) ? $_POST['bankid'] : null);
      $uangditerima = isset($_POST['uangditerima']) ? $_POST['uangditerima'] : 0;
      $totaltagihan = isset($_POST['totaltagihan']) ? $_POST['totaltagihan'] : 0;
      $biayaadministrasi = isset($_POST['biayaadministrasi']) ? $_POST['biayaadministrasi'] : 0;


      $criteriaCaraByr = new CDbCriteria;
      $criteriaCaraByr->select = "rekening5_m.rekening5_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5,rekening4_m.rekening4_id, rekening4_m.kdrekening4, rekening4_m.nmrekening4,rekening3_m.rekening3_id, rekening3_m.kdrekening3, rekening3_m.nmrekening3,rekening2_m.rekening2_id, rekening2_m.kdrekening2, rekening2_m.nmrekening2,rekening1_m.rekening1_id, rekening1_m.kdrekening1, rekening1_m.nmrekening1, t.debitkredit";
      $criteriaCaraByr->join = "JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id "
        . "JOIN rekening4_m ON rekening4_m.rekening4_id = rekening5_m.rekening4_id "
        . "JOIN rekening3_m ON rekening3_m.rekening3_id = rekening4_m.rekening3_id "
        . "JOIN rekening2_m ON rekening2_m.rekening2_id = rekening3_m.rekening2_id "
        . "JOIN rekening1_m ON rekening1_m.rekening1_id = rekening2_m.rekening1_id";

      if (!empty($bankid)) {
        $criteriaCaraByr->addCondition("t.bank_id = " . $bankid);
        $criteriaCaraByr->addCondition("t.debitkredit = 'K'");
      } else {
        if (!empty($carabayarkeluar)) {
          $criteriaCaraByr->compare('LOWER(t.carapembayaran)', strtolower(trim($carabayarkeluar)), false);
          $criteriaCaraByr->addCondition("t.debitkredit = 'D'");
        }
      }
      $criteriaCaraByr->order = 't.debitkredit ASC';
      $criteriaCaraByr->limit = 1;

      if (!empty($bankid)) {
        $kredit_gaji = BankrekM::model()->find($criteriaCaraByr);
      } else {
        if (!empty($carabayarkeluar)) {
          $kredit_gaji = CarapembrekM::model()->find($criteriaCaraByr);
        }
      }
      $row_rekening = "";


      if (isset($kredit_gaji)) {
        $row_rekening .= $this->renderPartial($this->path_view . '__formKodeRekeningAkuntansiRow', array(
          'detail' => $kredit_gaji, 'saldo_debit' => MyFormatter::formatNumberForPrint($uangditerima), 'saldo_kredit' => 0, 'key' => 1,
        ), true);
      }

      $modJurnalRek = JurnalrekeningT::model()->findByAttributes(array('bayarkesupplier_id' => $bayarkesupplier_id, 'tandabuktikeluar_id' => $tandabuktikeluar_id));
      if (isset($modJurnalRek)) {
        $modJurnalDet = JurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id' => $modJurnalRek->jurnalrekening_id));

        if (count((array)$modJurnalDet) > 0) {
          foreach ($modJurnalDet as $dataJurDet) {
            if ($dataJurDet->nourut == 1) {
              $row_rekening .= $this->renderPartial($this->path_view . '__formKodeRekeningAkuntansiRow', array(
                'detail' => $dataJurDet, 'saldo_debit' => 0, 'saldo_kredit' => MyFormatter::formatNumberForPrint($totaltagihan), 'key' => 2,
              ), true);
            } else if ($dataJurDet->nourut == 2) {
              if ($biayaadministrasi > 0) {
                $row_rekening .= $this->renderPartial($this->path_view . '__formKodeRekeningAkuntansiRow', array(
                  'detail' => $dataJurDet, 'saldo_debit' => 0, 'saldo_kredit' => MyFormatter::formatNumberForPrint($biayaadministrasi), 'key' => 3,
                ), true);
              }
            }
          }
        }
      }

      echo CJSON::encode(
        $row_rekening
      );
      Yii::app()->end();
    }
  }

  public function actionGetMasterBank()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $bank_id = isset($_GET['bank_id']) ? $_GET['bank_id'] : null;

      $model = BankM::model()->findByPk($bank_id);
      $data = array();

      if (isset($model)) {
        $data['norekening'] = $model->norekening;
        $data['namabank'] = $model->namabank;
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }
}
