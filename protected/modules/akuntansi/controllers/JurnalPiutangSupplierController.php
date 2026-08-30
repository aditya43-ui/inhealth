<?php

class JurnalPiutangSupplierController extends MyAuthController
{
  public $success = true; //true karena di looping

  public function actionIndex()
  {
    $model = new AKRincianfakturhutangsupplierV();
    $format = new MyFormatter();
    $model->tglAwal = date('d M Y');
    $model->tglAkhir = date('d M Y');
    $modJurnalRekening = new JurnalrekeningT;
    $modRekenings = array();
    if (isset($_POST['AKRincianfakturhutangsupplierV'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $noUrut = 1;
        foreach ($_POST['AKRincianfakturhutangsupplierV'] as $i => $post) {
          if (isset($post['pilihRekening'])) {
            $cekFaktur = FakturpembelianT::model()->findByPk($post['fakturpembelian_id']);
            if (isset($cekFaktur)) {
              if (empty($cekFaktur->jurnalrekening_id)) {
                $modJurnalRekening = $this->saveJurnalRekening($cekFaktur);
              } else {
                $modJurnalRekening = JurnalrekeningT::model()->findByPk($cekFaktur->jurnalrekening_id);
              }
              $modJurnalDetail = $this->saveJurnalDetail($modJurnalRekening, $post, $noUrut, true);
              $cekFaktur->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
              $cekFaktur->update();
              $noUrut++;
            }

            if ($modJurnalRekening && $modJurnalDetail && $cekFaktur) {
              $this->success = $this->success && true;
            } else {
              $this->success = false;
            }
            //kembalikan nilai jika gagal disimpan
            $modRekenings[$i] = new AKRincianfakturhutangsupplierV;
            $modRekenings[$i]->attributes = $post;
            $modRekenings[$i]->nmrekening5 = $post['nama_rekening'];
            $modSupplier = SupplierM::model()->findByPk($modRekenings[$i]->supplier_id);
            $modRekenings[$i]->supplier_nama = $modSupplier->supplier_nama;
            $modRekenings[$i]->supplier_kode = $modSupplier->supplier_kode;
          }
        }

        // var_dump($this->success); die;

        if ($this->success) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Posting Jurnal Berhasil");
          $this->refresh();
        } else {
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
      }
      Yii::app()->user->setFlash('error', "Data Gagal disimpan. Silakan pilih rekening dengan benar!");
    }

    $this->render('index', array('model' => $model, 'modRekenings' => $modRekenings));
  }

  /**
   * simpan jurnalrekening_t
   * @return \JurnalrekeningT
   */
  public function saveJurnalRekening($cekFaktur = null)
  {


    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->tglbuktijurnal = date('Y-m-d H:i:s');
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRekTanggal($modJurnalRekening->tglbuktijurnal, 'JH');
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = empty($cekFaktur) ? 0 : $cekFaktur->nofaktur;
    $modJurnalRekening->tglreferensi = date('Y-m-d H:i:s');
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = "";
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
    $modJurnalRekening->rekperiod_id = $modJurnalRekening->currentPeriod; //$modJurnalRekening->rekperiod_id = RekperiodM::model()->findByAttributes(array('isclosing'=>false))->rekperiod_id;
    $modJurnalRekening->create_time = date('Y-m-d H:i:s');
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');

    // var_dump($modJurnalRekening->attributes); die;

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
    } else {
      $modJurnalRekening['errorMsg'] = $modJurnalRekening->getErrors();
    }
    // var_dump($modJurnalRekening->attributes); die;
    return $modJurnalRekening;
  }
  /**
   * simpan jurnaldetail_t dan jurnalposting_t digunakan di:
   * - akuntansi/JurnalPiutangSupplier
   */
  public function saveJurnalDetail($modJurnalRekening, $post, $noUrut = 0, $isPosting = false)
  {
    $modJurnalPosting = null;

    $modJurnalDetail = new JurnaldetailT();
    $modJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
    $modJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    $modJurnalDetail->uraiantransaksi = $post['nama_rekening'];
    $modJurnalDetail->saldodebit = MyFormatter::formatRupiahForDB($post['saldodebit']);
    $modJurnalDetail->saldokredit = MyFormatter::formatRupiahForDB($post['saldokredit']);
    $modJurnalDetail->nourut = $noUrut;
    // $modJurnalDetail->rekening1_id = $post['rekening1_id'];
    // $modJurnalDetail->rekening2_id = $post['rekening2_id'];
    // $modJurnalDetail->rekening3_id = $post['rekening3_id'];
    // $modJurnalDetail->rekening4_id = $post['rekening4_id'];
    $modJurnalDetail->rekening5_id = $post['rekening5_id'];
    $modJurnalDetail->catatan = "";


    // var_dump($modJurnalDetail->attributes); die;

    if ($modJurnalDetail->validate()) {
      $modJurnalDetail->save();
    }

    if ($isPosting == true) {
      $criteria = new CDbCriteria();
      // $criteria->addCondition("DATE(tglperiodeposting_awal) <= '".date("Y-m-d")."' AND DATE(tglperiodeposting_akhir) >= '".date("Y-m-d")."'");
      $criteria->addCondition("'" . $modJurnalRekening->tglbuktijurnal . "'::date between tglperiodeposting_awal::date and tglperiodeposting_akhir::date");
      // $criteria->compare('rekperiode_id', $jurnal->rekperiod_id);
      $periode = PeriodepostingM::model()->find($criteria);

      $modJurnalPosting = new JurnalpostingT;
      $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
      $modJurnalPosting->keterangan = "Posting automatis";
      $modJurnalPosting->create_time = date('Y-m-d H:i:s');
      $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
      $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modJurnalPosting->jurnaldetail_id = $modJurnalDetail->jurnaldetail_id;
      if (!empty($periode)) $modJurnalPosting->periodeposting_id = $periode->periodeposting_id;

      // var_dump($modJurnalPosting->attributes); die;

      if ($modJurnalPosting->validate()) {
        $modJurnalPosting->save();
      }
    }


    return $modJurnalDetail;
  }

  /**
   * actionGetRekeningPiutangSupplier digunakan di :
   * akuntansi/views/jurnalPiutangSupplier/_jsFunctions
   */
  public function actionGetRekeningPiutangSupplier()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $model = new AKRincianfakturhutangsupplierV;
      $format = new MyFormatter();
      if (isset($_POST['AKRincianfakturhutangsupplierV'])) {
        $model->attributes = $_POST['AKRincianfakturhutangsupplierV'];
        $model->tglAwal = $format->formatDateTimeForDB($_POST['AKRincianfakturhutangsupplierV']['tglAwal']);
        $model->tglAkhir = $format->formatDateTimeForDB($_POST['AKRincianfakturhutangsupplierV']['tglAkhir']);
      }
      $criteria = new CDbCriteria;
      $criteria = $model->criteriaFunction();
      $criteria->join = 'left join bayarkesupplier_t b on b.fakturpembelian_id = t.fakturpembelian_id';
      $criteria->addCondition('b.bayarkesupplier_id is not null');
      $criteria->addCondition('t.syaratbayar_id = ' . Params::SYARAT_CARABAYAR_KREDIT);
      $models = AKRincianfakturhutangsupplierV::model()->findAll($criteria);
      foreach ($models as $i => $model) { //untuk membedakan tindakan / obat di form jurnal
        $models[$i]['saldodebit'] = 0;
        $models[$i]['saldokredit'] = 0;
        if ($models[$i]['rekening5_nb'] == "D") {
          $models[$i]['saldodebit'] = $model->saldotransaksi;
        } else {
          $models[$i]['saldokredit'] = $model->saldotransaksi;
        }
      }
      if (count((array)$models) > 0) {
        echo CJSON::encode(
          $this->renderPartial('akuntansi.views.jurnalPiutangSupplier._rowRekening', array('modRekenings' => $models), true)
        );
      } else {
        echo "Data tidak ditemukan !";
      }
      Yii::app()->end();
    }
  }
}
