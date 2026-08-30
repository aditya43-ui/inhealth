<?php

class JurnalPiutangPasienController extends MyAuthController
{
  public $success = true; //true karena di looping

  public function actionIndex()
  {
    $model = new AKRincianpiutangrekeningpasienV();
    $format = new MyFormatter();
    $model->tglAwal = date('d M Y');
    $model->tglAkhir = date('d M Y');
    $modJurnalRekening = new JurnalrekeningT;
    $modRekenings = array();
    if (isset($_POST['AKRincianpiutangrekeningpasienV'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $noUrut = 1;

        // var_dump($_POST);

        foreach ($_POST['AKRincianpiutangrekeningpasienV'] as $i => $post) {
          if (isset($post['pilihRekening'])) {
            if (strtolower($post['tm']) == 'tm') {
              $cekTindakanObat = TindakanpelayananT::model()->findByPk($post['tindakanpelayanan_id']);
              if (isset($cekTindakanObat)) {
                if (empty($cekTindakanObat->jurnalrekening_id)) {
                  $modJurnalRekening = $this->saveJurnalRekening();
                } else {
                  $modJurnalRekening = JurnalrekeningT::model()->findByPk($cekTindakanObat->jurnalrekening_id);
                }
                $modJurnalDetail = $this->saveJurnalDetail($modJurnalRekening, $post, $noUrut, true);
                TindakanpelayananT::model()->updateByPk($cekTindakanObat->tindakanpelayanan_id, array(
                  'jurnalrekening_id' => $modJurnalRekening->jurnalrekening_id,
                ));

                //$cekTindakanObat->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
                //$cekTindakanObat->update();
                $noUrut++;
              }
            } else {
              $cekTindakanObat = ObatalkespasienT::model()->findByPk($post['tindakanpelayanan_id']);
              if (isset($cekTindakanObat)) {
                if (empty($cekTindakanObat->jurnalrekening_id)) {
                  $modJurnalRekening = $this->saveJurnalRekening();
                } else {
                  $modJurnalRekening = JurnalrekeningT::model()->findByPk($cekTindakanObat->jurnalrekening_id);
                }
                $modJurnalDetail = $this->saveJurnalDetail($modJurnalRekening, $post, $noUrut, true);
                ObatalkespasienT::model()->updateByPk($cekTindakanObat->obatalkespasien_id, array(
                  'jurnalrekening_id' => $modJurnalRekening->jurnalrekening_id,
                ));

                //$cekTindakanObat->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
                //$cekTindakanObat->update();
                $noUrut++;
              }
            }
            if ($modJurnalRekening && $modJurnalDetail && $cekTindakanObat) {
              $this->success = $this->success && true;
            } else {
              $this->success = false;
            }
            //kembalikan nilai jika gagal disimpan
            $modRekenings[$i] = new AKRincianpiutangrekeningpasienV;
            $modRekenings[$i]->attributes = $post;
            $modRekenings[$i]->nmrekening5 = $post['nama_rekening'];
            $modPasien = PasienM::model()->findByPk($modRekenings[$i]->pasien_id);
            $modRekenings[$i]->namadepan = $modPasien->namadepan;
            $modRekenings[$i]->nama_pasien = $modPasien->nama_pasien;
            $modRekenings[$i]->no_rekam_medik = $modPasien->no_rekam_medik;
            $modPendaftaran = PendaftaranT::model()->findByPk($modRekenings[$i]->pendaftaran_id);
            $modRekenings[$i]->no_pendaftaran = $modPendaftaran->no_pendaftaran;
            $modRekenings[$i]->carabayar_nama = $modPendaftaran->carabayar->carabayar_nama;
            $modRekenings[$i]->penjamin_nama = $modPendaftaran->penjamin->penjamin_nama;
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
        //var_dump($exc); die;

        //var_dump($this->success); die;
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
  public function saveJurnalRekening()
  {
    $modJurnalRekening = new JurnalrekeningT;
    $modJurnalRekening->tglbuktijurnal = date('Y-m-d H:i:s');
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRekTanggal($modJurnalRekening->tglbuktijurnal, 'JTK');
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = 0;
    $modJurnalRekening->tglreferensi = date('Y-m-d H:i:s');
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = "";
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENERIMAAN_KAS;
    $modJurnalRekening->rekperiod_id = RekperiodM::model()->findByAttributes(array('isclosing' => false))->rekperiod_id;
    $modJurnalRekening->create_time = date('Y-m-d H:i:s');
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
    } else {
      $modJurnalRekening['errorMsg'] = $modJurnalRekening->getErrors();
    }
    return $modJurnalRekening;
  }
  /**
   * simpan jurnaldetail_t dan jurnalposting_t digunakan di:
   * - akuntansi/JurnalPiutangPasien
   */
  public function saveJurnalDetail($modJurnalRekening, $post, $noUrut = 0, $isPosting = false)
  {
    $modJurnalPosting = null;
    if ($isPosting == true) {
      $modJurnalPosting = new JurnalpostingT;
      $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
      $modJurnalPosting->keterangan = "Posting automatis";
      $modJurnalPosting->create_time = date('Y-m-d H:i:s');
      $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
      $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
      if ($modJurnalPosting->validate()) {
        $modJurnalPosting->save();
      }
    }

    $modJurnalDetail = new JurnaldetailT();
    $modJurnalDetail->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
    $modJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
    $modJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
    $modJurnalDetail->uraiantransaksi = $post['nama_rekening'];
    $modJurnalDetail->saldodebit = $post['saldodebit'];
    $modJurnalDetail->saldokredit = $post['saldokredit'];
    $modJurnalDetail->nourut = $noUrut;
    //$modJurnalDetail->rekening1_id = $post['rekening1_id'];
    //$modJurnalDetail->rekening2_id = $post['rekening2_id'];
    //$modJurnalDetail->rekening3_id = $post['rekening3_id'];
    //$modJurnalDetail->rekening4_id = $post['rekening4_id'];
    $modJurnalDetail->rekening5_id = $post['rekening5_id'];
    $modJurnalDetail->catatan = "";
    if ($modJurnalDetail->validate()) {
      $modJurnalDetail->save();
    }
    return $modJurnalDetail;
  }

  public function actionGetRuanganDariInstalasi($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idInstalasi = $_POST["$namaModel"]['instalasi_id'];
      if (empty($idInstalasi)) {
        $ruangan = RuanganM::model()->findAll();
      } else {
        $ruangan = RuanganM::model()->findAll('instalasi_id=' . $idInstalasi . '');
      }
      $ruangan = CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama');
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      foreach ($ruangan as $value => $name) {
        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
    }
    Yii::app()->end();
  }

  /**
   * actionGetRekeningPiutangPasien digunakan di :
   * akuntansi/views/jurnalPiutangPasien/_jsFunctions
   */
  public function actionGetRekeningPiutangPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $model = new AKRincianpiutangrekeningpasienV;
      $format = new MyFormatter();
      if (isset($_POST['AKRincianpiutangrekeningpasienV'])) {
        $model->attributes = $_POST['AKRincianpiutangrekeningpasienV'];
        $model->tglAwal = $format->formatDateTimeForDB($_POST['AKRincianpiutangrekeningpasienV']['tglAwal']);
        $model->tglAkhir = $format->formatDateTimeForDB($_POST['AKRincianpiutangrekeningpasienV']['tglAkhir']);
      }
      $criteria = new CDbCriteria;
      $criteria = $model->criteriaFunction();
      $criteria->addCondition('rekening5_id is not null');
      $criteria->order = "tindakanpelayanan_id, rekening5_nb";
      $models = AKRincianpiutangrekeningpasienV::model()->findAll($criteria);


      // var_dump(count((array)$models)); die;

      foreach ($models as $i => $model) { //untuk membedakan tindakan / obat di form jurnal
        $models[$i]['saldodebit'] = 0;
        $models[$i]['saldokredit'] = 0;
        if ($models[$i]['rekening5_nb'] == "D") {
          $models[$i]['saldodebit'] = $model->saldotarif;
        } else {
          $models[$i]['saldokredit'] = $model->saldotarif;
        }
      }
      if (count((array)$models) > 0) {
        echo CJSON::encode(
          $this->renderPartial('akuntansi.views.jurnalPiutangPasien._rowRekening', array('modRekenings' => $models), true)
        );
      } else {
        echo null;
      }
      Yii::app()->end();
    }
  }
}
