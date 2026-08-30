<?php

class PengeluaranUmumController extends MyAuthController
{
  public $succesSave = true;
  public $pesan = "succes";
  public $is_action = "insert";
  public $path_view = 'keuangan.views.pengeluaranUmum.';
  public $path_view_info = 'keuangan.views.informasiPengeluaranUmum.';

  public function actionIndex($linkHalaman = null)
  {
    // var_dump(Yii::app()->user->getState('ruangan_id')); die;
    $this->pageTitle = Yii::app()->name . " - Pengeluaran Kas / Umum";
    $modPengUmum = new KUPengeluaranumumT;
    $modPengUmum->volume = 1;
    $modPengUmum->hargasatuan = 0;
    $modPengUmum->totalharga = 0;
    // $modPengUmum->persenppn = 10;
    $modPengUmum->persenppn = 0;
    $modPengUmum->nopengeluaran = MyGenerator::noPengeluaranUmum();
    $modUraian[0] = new KUUraiankeluarumumT;
    $modUraian[0]->volume = 1;
    $modUraian[0]->hargasatuan = 0;
    $modUraian[0]->totalharga = 0;
    $modBuktiKeluar = new KUTandabuktikeluarT;
    $modBuktiKeluar->tahun = date('Y');
    $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
    $modBuktiKeluar->biayaadministrasi = 0;
    $modBuktiKeluar->jmlkaskeluar = 0;

    $modJurnalRekening = new KUJurnalrekeningT;
    $modJurnalDetail = new KUJurnaldetailT;
    $modJurnalPosting = new KUJurnalpostingT;

    if (isset($_POST['KUPengeluaranumumT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modBuktiKeluar = $this->saveTandaBuktiKeluar($_POST['KUTandabuktikeluarT']);

        $modPengUmum = $this->savePengeluaranUmum($_POST['KUPengeluaranumumT'], $modBuktiKeluar);
        $this->updateTandaBuktiKeluar($modBuktiKeluar, $modPengUmum);

        if ($modPengUmum->isurainkeluarumum && isset($_POST['KUUraiankeluarumumT'])) {
          $modUraian = $this->saveUraian($_POST['KUUraiankeluarumumT'], $modPengUmum);
        }

        if ($this->succesSave) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Nomor Pengeluaran berhasil disimpan");
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(1395);

    $this->render($this->path_view . 'index', array(
      'modPengUmum' => $modPengUmum,
      'modUraian' => $modUraian,
      'modBuktiKeluar' => $modBuktiKeluar,
      'modJurnalRekening' => $modJurnalRekening,
      'modJurnalDetail' => $modJurnalDetail,
      'modJurnalPosting' => $modJurnalPosting,
      'linkHalaman' => $linkHalaman
    ));
  }

  protected function updateTandaBuktiKeluar($modBuktiKeluar, $modPengUmum)
  {
    KUTandabuktikeluarT::model()->updateByPk($modBuktiKeluar->tandabuktikeluar_id, array('pengeluaranumum_id' => $modPengUmum->pengeluaranumum_id));
  }

  public function actionSimpanPengeluaran()
  {
    if (Yii::app()->request->isAjaxRequest) {
      parse_str($_REQUEST['data'], $data_parsing);
      $modJurnalPosting = null;
      $format = new MyFormatter();

      if (isset($data_parsing['KUPengeluaranumumT'])) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $modBuktiKeluar = $this->saveTandaBuktiKeluar($data_parsing['KUTandabuktikeluarT']);
          $data_parsing['KUPengeluaranumumT']['tglpengeluaran'] = $format->formatDateTimeForDb($data_parsing['KUPengeluaranumumT']['tglpengeluaran']);
          $modPengUmum = $this->savePengeluaranUmum($data_parsing['KUPengeluaranumumT'], $modBuktiKeluar);
          if (isset($data_parsing['KUPengeluaranumumT']['isurainkeluarumum'])) {
            $modUraian = $this->saveUraian($data_parsing['KUUraiankeluarumumT'], $modPengUmum);
          }

          $modPengUmum->tandabuktikeluar_id = $modBuktiKeluar->tandabuktikeluar_id;
          $modPengUmum->update();
          $modBuktiKeluar->pengeluaranumum_id = $modPengUmum->pengeluaranumum_id;
          $modBuktiKeluar->update();

          //var_dump($modPengUmum->attributes);
          //var_dump($modBuktiKeluar->attributes); die;

          $modJurnalRekening = $this->saveJurnalRekening($modPengUmum, $data_parsing['KUPengeluaranumumT']);
          $params = array(
            'modJurnalRekening' => $modJurnalRekening,
            'jenis_simpan' => $_REQUEST['jenis_simpan'],
            'RekeningakuntansiV' => $data_parsing['RekeningakuntansiV'],
          );
          //                        $insertDetailJurnal = $this->insertDetailJurnal($params);
          //                        $this->succesSave = $insertDetailJurnal;

          $modJurnalDetail = $this->saveJurnalDetail(
            $data_parsing['KUPengeluaranumumT'],
            $modJurnalRekening,
            null,
            $data_parsing['RekeningakuntansiV']
          );

          /* dibuka comment karena RND-8514 */
          if ($_REQUEST['jenis_simpan'] == 'posting') {
            $res = Yii::app()->db
              ->createCommand("select ins_jurnalpostingotomatisbilling_fix_jurnal(" . $modJurnalRekening->jurnalrekening_id . ") as simpan")
              ->queryRow();

            if (!empty($res)) {
              $this->succesSave = $this->succesSave && $res['simpan'];
            }
          }


          $this->notifPengeluaranKas($modPengUmum, $modBuktiKeluar);
          
          if ($this->succesSave) {
            $transaction->commit();
            // Yii::app()->user->setFlash('success', "Data berhasil disimpan");
            $this->pesan = array(
              'nopengeluaran' => MyGenerator::noPengeluaranUmum(),
              'nokaskeluar' => MyGenerator::noKasKeluar()
            );
          } else {
            $transaction->rollback();
            // Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          }
        } catch (Exception $exc) {
          print_r($exc);
          $this->pesan = $exc;
          $this->succesSave = false;
          $transaction->rollback();
        }
      }
      $result = array(
        'action' => $this->is_action,
        'id' => empty($modPengUmum) ? "" : $modPengUmum->pengeluaranumum_id,
        'pesan' => $this->pesan,
        'status' => ($this->succesSave == true ? 'ok' : 'not'),
      );
      echo json_encode($result);
      Yii::app()->end();
    }
  }


  public function notifPengeluaranKas($model, $modBuktiKeluar)
  {

    //        print_r($model->attributes); die;
    //        print_r($modBuktiKeluar->attributes); die;

    $judul = "Pengeluaran Umum - " . $model->nopengeluaran;
    $jenis = JenispengeluaranM::model()->findByPk($model->jenispengeluaran_id);

    $isi = "Tgl. Pengeluaran : " . MyFormatter::formatDateTimeForUser($model->tglpengeluaran) . "<br/>";
    $isi .= "Jenis : " . $jenis->jenispengeluaran_nama . "<br/>";
    $isi .= "Nominal : " . MyFormatter::formatNumberForPrint($modBuktiKeluar->jmlkaskeluar) . "<br/>";

    $ruanganKeuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
    $ruanganAkuntansi = RuanganM::model()->findByPk(Params::RUANGAN_ID_AKUNTANSI);
    $ruanganKasir = RuanganM::model()->findByPk(Params::RUANGAN_ID_KASIR);

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruanganKeuangan->instalasi_id, 'ruangan_id' => $ruanganKeuangan->ruangan_id, 'modul_id' => $ruanganKeuangan->modul_id),
      array('instalasi_id' => $ruanganAkuntansi->instalasi_id, 'ruangan_id' => $ruanganAkuntansi->ruangan_id, 'modul_id' => $ruanganAkuntansi->modul_id),
      array('instalasi_id' => $ruanganKasir->instalasi_id, 'ruangan_id' => $ruanganKasir->ruangan_id, 'modul_id' => $ruanganKasir->modul_id),
    ));


    //        print_r($model->attributes);
    //
    //        die;
  }


  public function actionAmbilDataRekening()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $rekening1_id = isset($_POST['rekening1_id']) ? $_POST['rekening1_id'] : null;
      $rekening2_id = isset($_POST['rekening2_id']) ? $_POST['rekening2_id'] : null;
      $rekening3_id = isset($_POST['rekening3_id']) ? $_POST['rekening3_id'] : null;
      $rekening4_id = isset($_POST['rekening4_id']) ? $_POST['rekening4_id'] : null;
      $rekening5_id = isset($_POST['rekening5_id']) ? $_POST['rekening5_id'] : null;
      $status = isset($_POST['status']) ? $_POST['status'] : null;
      $criteria = new CDbCriteria;

      //			dicomment karena : RND-8713
      //			$data = array();
      //			$params = array();
      //			foreach($_POST['id_rekening'] as $key=>$val)
      //			{
      //				if($key != 'status')
      //				{
      //					if(strlen(trim($val)) > 0)
      //					{
      //						$data[] = $key . ' = :' . $key;
      //						$params[(string) ':'.$key] = $val;
      //					}
      //				}
      //			}
      //
      //			$criteria = new CDbCriteria;
      //			$criteria->select = '*';
      //			$criteria->condition = implode($data, ' AND ');
      //			$criteria->params = $params;

      if (!empty($rekening5_id)) {
        $criteria->addCondition("rekeninglast_id = " . $rekening5_id);
      }
      if (!empty($rekening4_id)) {
        $criteria->addCondition("rekening4_id = " . $rekening4_id);
      }
      if (!empty($rekening3_id)) {
        $criteria->addCondition("rekening3_id = " . $rekening3_id);
      }
      if (!empty($rekening2_id)) {
        $criteria->addCondition("rekening2_id = " . $rekening2_id);
      }
      if (!empty($rekening1_id)) {
        $criteria->addCondition("rekening1_id = " . $rekening1_id);
      }

      $model = KURekeningakuntansiV::model()->findAll($criteria);
      if ($model) {
        echo CJSON::encode(
          $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'status' => $_POST['status']), true)
        );
      }
      Yii::app()->end();
    }
  }

  public function actionGetDataRekeningByJnsPenerimaan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $jenispenerimaan_id = isset($_POST['jenispenerimaan_id']) ? $_POST['jenispenerimaan_id'] : null;
      $criteria = new CDbCriteria;
      //			dicomment RND-8517
      //			$criteria->select = '*, jnspenerimaanrek_m.saldonormal';
      //			$criteria->join = '
      //				JOIN jnspenerimaanrek_m ON
      //					jnspenerimaanrek_m.rekening1_id = t.struktur_id AND
      //					jnspenerimaanrek_m.rekening2_id = t.kelompok_id AND
      //					jnspenerimaanrek_m.rekening3_id = t.jenis_id AND
      //					jnspenerimaanrek_m.rekening4_id = t.obyek_id AND
      //					jnspenerimaanrek_m.rekening5_id = t.rincianobyek_id
      //			';
      //			$criteria->condition = 'jnspenerimaanrek_m.jenispenerimaan_id = :jenispenerimaan_id';
      //			$criteria->params = array(':jenispenerimaan_id'=>$jenispenerimaan_id);
      //			$model = RekeningakuntansiV::model()->findAll($criteria);
      if (!empty($jenispenerimaan_id)) {
        $criteria->addCondition('jenispenerimaan_id = ' . $jenispenerimaan_id);
      }
      $criteria->order = 'saldonormal ASC';
      $model = KUJenispenerimaanrekeningV::model()->findAll($criteria);

      if ($model) {
        echo CJSON::encode(
          $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'dariDialog' => true), true)
        );
      }
      Yii::app()->end();
    }
  }

  public function actionGetDataRekeningByJnsPengeluaran()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $jenispengeluaran_id = isset($_POST['jenispengeluaran_id']) ? $_POST['jenispengeluaran_id'] : null;
      $is_kasbon = isset($_POST['is_kasbon']) ? $_POST['is_kasbon'] : null;
      $criteria = new CDbCriteria;

      if (!empty($jenispengeluaran_id)) {
        $criteria->addCondition('t.jenispengeluaran_id = ' . $jenispengeluaran_id);
      }
      $criteria->addCondition("t.debitkredit = 'D'");
      $criteria->join = "join jnspengeluaranrek_m j on j.jenispengeluaran_id = t.jenispengeluaran_id and t.rekening5_id = j.rekening5_id";
      $criteria->order = 'j.debitkredit ASC';
      $premodel = KUJenispengeluaranrekeningV::model()->findAll($criteria);


      $model = array();

      $detmodel = array(
        'D' => array(),
        'K' => array(),
      );

      foreach ($premodel as $item) {

        $detmodel[$item->debitkredit][] = $item;
      }

      if (empty($is_kasbon)) {
        $rekKolom = RekeningcolumnM::model()->findAllByAttributes(array(
          'table_name' => PengeluaranumumT::model()->tableName(),
        ), array(
          'order' => 'debitkredit, rekeningcolumn_id asc',
        ));
  
        $rekAdmin = RekeningcolumnM::model()->findAllByAttributes(array(
          'table_name' => TandabuktikeluarT::model()->tableName(),
          'column_name' => 'tandabukti_biayaadministrasi',
        ), array(
          'order' => 'debitkredit, rekeningcolumn_id asc',
        ));
      }

      foreach ($rekKolom as $item) {
        $sub = Rekening5M::model()->findByAttributes(array('rekening5_id' => $item->rekening5_id));
        $sub->rek_column = $item;

        $detmodel[$item->debitkredit][] = $sub;
      }

      foreach ($rekAdmin as $item) {
        $sub = Rekening5M::model()->findByAttributes(array('rekening5_id' => $item->rekening5_id));
        $sub->rek_column = $item;

        $detmodel[$item->debitkredit][] = $sub;
      }

      $model = array_merge($detmodel['D'], $detmodel['K']);
      // $model = $detmodel['K'];
      
      if ($model) {
        echo CJSON::encode(
          $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'dariDialog' => true), true)
        );
      }
      Yii::app()->end();
    }
  }

  public function saveTandaBuktiKeluar($postBuktiKeluar)
  {
    $format = new MyFormatter();
    $modBuktiKeluar = new KUTandabuktikeluarT;
    $modBuktiKeluar->attributes = $postBuktiKeluar;
    $modBuktiKeluar->tahun = date('Y');
    $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
    $modBuktiKeluar->biayaadministrasi = empty($modBuktiKeluar->biayaadministrasi) ? 0 : $modBuktiKeluar->biayaadministrasi;
    //$modBuktiKeluar->jmlkaskeluar = 0;
    $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');
    $modBuktiKeluar->namapenerima = $postBuktiKeluar['namapenerima'];
    $modBuktiKeluar->tglkaskeluar = $format->formatDateTimeForDb($postBuktiKeluar['tglkaskeluar']);
    $modBuktiKeluar->create_time = date('Y-m-d H:i:s');
    $modBuktiKeluar->create_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
    $modBuktiKeluar->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $this->succesSave = false;


    // print_r($modBuktiKeluar->attributes); die;

    if ($modBuktiKeluar->validate()) {
      $modBuktiKeluar->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modBuktiKeluar->getErrors();
    }

    return $modBuktiKeluar;
  }

  public function savePengeluaranUmum($postPengeluaran, $modBuktiKeluar)
  {
    $modPengUmum = new KUPengeluaranumumT;
    $modPengUmum->attributes = $postPengeluaran;
    $modPengUmum->nopengeluaran = MyGenerator::noPengeluaranUmum();
    $modPengUmum->biayaadministrasi = $modBuktiKeluar->biayaadministrasi;
    $modPengUmum->shift_id = Yii::app()->user->getState('shift_id');
    $modPengUmum->pegawai_id = Yii::app()->user->getState('pegawai_id');

    if (!empty($modPengUmum->jmlpph_21) && $modPengUmum->jmlpph_21 > 0) {
      $modPengUmum->pph21_id = 1; //pajak_m value pph 21
    }
    if (!empty($modPengUmum->jmlpph_22) && $modPengUmum->jmlpph_22 > 0) {
      $modPengUmum->pph22_id = 2; //pajak_m value pph 22
    }
    if (!empty($modPengUmum->jmlpph_23) && $modPengUmum->jmlpph_23 > 0) {
      $modPengUmum->pph23_id = 5; //pajak_m value pph 23
    }

    if ($modPengUmum->validate()) {
      $modPengUmum->save();
      $this->succesSave = true;
      $attributes = array(
        'pengeluaranumum_id' => $modPengUmum->pengeluaranumum_id
      );
      KUTandabuktikeluarT::model()->updateByPk($modBuktiKeluar->tandabuktikeluar_id, $attributes);
    } else {
      $this->succesSave = false;
      $this->pesan = $modPengUmum->getErrors();
    }

    return $modPengUmum;
  }

  public function saveUraian($arrPostUraian, $modPengUmum)
  {
    $valid = false;
    $modUraian = array();
    for ($i = 0; $i < count((array)$arrPostUraian); $i++) {
      if (strlen($arrPostUraian[$i]['uraiantransaksi']) > 0) {
        $modUraian[$i] = new KUUraiankeluarumumT;
        $modUraian[$i]->attributes = $arrPostUraian[$i];
        $modUraian[$i]->pengeluaranumum_id = $modPengUmum->pengeluaranumum_id;
        if ($modUraian[$i]->validate()) {
          $modUraian[$i]->save();
          $valid = true;
        } else {
          $this->pesan = $modUraian[$i]->getErrors();
        }
      }
    }
    $this->succesSave = $valid;
    return $modUraian;
  }

  public function saveJurnalRekening($modPenUmum, $postPenUmum)
  {

    $period = Yii::app()->user->getState('periode_ids');
    if (is_array($period)) {
      $period = $period[0];
    }

    $modJurnalRekening = new KUJurnalrekeningT;
    $modJurnalRekening->tglbuktijurnal = $modPenUmum->tglpengeluaran;
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRekTanggal($modPenUmum->tglpengeluaran, 'JKK');
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = $modPenUmum->nopengeluaran;
    $modJurnalRekening->tglreferensi = $modPenUmum->tglpengeluaran;
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = $postPenUmum['jenisKodeNama'];
    /*
          $attributes = array(
          'jenisjurnal_aktif' => true
          );
          $jenisjurnal_id = JenisjurnalM::model()->findByAttributes($attributes);
          $modJurnalRekening->jenisjurnal_id = $jenisjurnal_id->jenisjurnal_id;
         *
         */

    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENGELUARAN_KAS;
    $periodeID = $period;
    $modJurnalRekening->rekperiod_id = $periodeID;
    $modJurnalRekening->create_time = $modPenUmum->tglpengeluaran;
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;

      if (empty($modJurnalRekening->rekperiod_id)) {
        $this->pesan = "Periode Akuntansi Belum di-set";
      } else {
        $this->pesan = $modJurnalRekening->getErrors();
      }
    }
    return $modJurnalRekening;
  }

  public function saveJurnalDetail($arrJurnal, $modJurnalRekening, $modJurnalPosting = null, $rekeningakuntansi = null)
  {

    $valid = true;
    foreach ($rekeningakuntansi as $i => $data) {

      $model = new KUJurnaldetailT();
      $model->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
      $model->rekperiod_id = $modJurnalRekening->rekperiod_id;
      $model->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
      //                $model[$i]->uraiantransaksi = $arrJurnal['jenisKodeNama'];
      $model->uraiantransaksi = isset($data['nama_rekening']) ? $data['nama_rekening'] : "";
      $model->saldodebit = isset($data['saldodebit']) ? $data['saldodebit'] : 0;
      $model->saldokredit = isset($data['saldokredit']) ? $data['saldokredit'] : 0;
      $model->nourut = $i + 1;
      $model->rekening5_id = isset($data['rekening5_id']) ? $data['rekening5_id'] : null;
      $model->catatan = "";
      if ($model->validate()) {
        $model->save();
      } else {
        $this->pesan = $model->getErrors();
        $valid = false;
        break;
      }
    }

    $this->succesSave = $valid;
  }

  /*
      protected function saveJurnalDetail($arrJurnal, $modJurnalRekening, $modJurnalPosting = null)
      {
      $valid = true;
      for($i=0;$i<2;$i++)
      {
      $model[$i] = new KUJurnaldetailT();
      $model[$i]->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
      $model[$i]->rekperiod_id = $modJurnalRekening->rekperiod_id;
      $model[$i]->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
      $model[$i]->uraiantransaksi = $arrJurnal['jenisKodeNama'];
      $model[$i]->saldodebit = 0;
      $model[$i]->saldokredit = 0;
      $model[$i]->nourut = $i+1;
      if($i == 0)
      {
      $jenisPnrm = JnspengeluaranrekM::model()->findByAttributes(
      array(
      'jenispengeluaran_id'=>$arrJurnal['jenispengeluaran_id'],
      'saldonormal' => 'D'
      )
      );
      $model[$i]->saldodebit = $arrJurnal['totalharga'];
      }else{
      $jenisPnrm = JnspengeluaranrekM::model()->findByAttributes(
      array(
      'jenispengeluaran_id'=>$arrJurnal['jenispengeluaran_id'],
      'saldonormal' => 'K'
      )
      );
      $model[$i]->saldokredit = $arrJurnal['totalharga'];
      }
      $model[$i]->rekening1_id = $jenisPnrm['rekening1_id'];
      $model[$i]->rekening2_id = $jenisPnrm['rekening2_id'];
      $model[$i]->rekening3_id = $jenisPnrm['rekening3_id'];
      $model[$i]->rekening4_id = $jenisPnrm['rekening4_id'];
      $model[$i]->rekening5_id = $jenisPnrm['rekening5_id'];
      $model[$i]->catatan = "";
      if($model[$i]->validate())
      {
      $model[$i]->save();
      }else{
      $this->pesan = $model[$i]->getErrors();
      $valid = false;
      break;
      }
      }
      $this->succesSave = $valid;
      }
     */

  protected function saveJurnalPosting($arrJurnalPosting)
  {
    $modJurnalPosting = new KUJurnalpostingT;
    $modJurnalPosting->tgljurnalpost = date('Y-m-d H:i:s');
    $modJurnalPosting->keterangan = "Posting automatis";
    $modJurnalPosting->create_time = date('Y-m-d H:i:s');
    $modJurnalPosting->create_loginpemekai_id = Yii::app()->user->id;
    $modJurnalPosting->create_ruangan = Yii::app()->user->getState('ruangan_id');
    if ($modJurnalPosting->validate()) {
      $modJurnalPosting->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modJurnalPosting->getErrors();
    }
    return $modJurnalPosting;
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

  public function actionAutocompleteJenisPengeluaran()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(jenispengeluaran_nama)', strtolower($_GET['term']), true);
      $criteria->addCondition("jenispengeluaran_id IN(select jenispengeluaran_id from jnspengeluaranrek_m)");
      $models = JenispengeluaranM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->jenispengeluaran_nama;
        $returnVal[$i]['value'] = $model->jenispengeluaran_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionPrint($id)
  {
    $model = KUPengeluaranumumT::model()->findByPk($id);
    $modTandaBukti = KUTandabuktikeluarT::model()->findByPk($model->tandabuktikeluar_id);

    $modUraian = KUUraiankeluarumumT::model()->findAllByAttributes(array('pengeluaranumum_id' => $model->pengeluaranumum_id));

    $judulLaporan = 'Detail Pengeluaran Kas';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'detailPengeluaran', array('model' => $model, 'modTandaBukti' => $modTandaBukti, 'modUraian' => $modUraian, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'modTandaBukti' => $modTandaBukti, 'modUraian' => $modUraian, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');              // Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                                        // Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'detailPengeluaran', array('model' => $model, 'modTandaBukti' => $modTandaBukti, 'modUraian' => $modUraian, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      // $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'modTandaBukti' => $modTandaBukti, 'modUraian' => $modUraian, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
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

  public function actionGetDataRekeningByCaraPembayaran()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $carabayarkeluar = isset($_POST['carapembayaran']) ? $_POST['carapembayaran'] : null;
      $bankid = ((isset($_POST['bankid']) && !empty($_POST['bankid'])) ? $_POST['bankid'] : null);

      $criteria = new CDbCriteria;
      $criteria->select = "rekening5_m.rekening5_id, rekening5_m.kdrekening5, rekening5_m.nmrekening5, t.debitkredit";
      $criteria->join = "JOIN rekening5_m ON rekening5_m.rekening5_id = t.rekening5_id";

      if (!empty($bankid)) {
        $criteria->addCondition("t.bank_id = " . $bankid);
        $criteria->addCondition("t.debitkredit = 'K'");
      } else {
        if (!empty($carabayarkeluar)) {
          // $criteria->addCondition("t.carabayarkeluarrek_id = 3");
                                     $criteria->addCondition("t.carabayarkeluar = '" . trim($carabayarkeluar) . "'");
        }
      }
      $criteria->order = 't.debitkredit ASC';
      $criteria->limit = 1;

      if (!empty($bankid)) {
        $model = BankrekM::model()->findAll($criteria);
      } else {
        if (!empty($carabayarkeluar)) {
          $model = CarabayarkeluarrekM::model()->findAll($criteria);
        }
      }

      $html = "";
      if (count((array)$model) > 0) {
        foreach ($model as $dataRek) {
          $dataRek->debitkredit = 'K';
        }
        $html = $this->renderPartial($this->path_view . '__formKodeRekening', array('model' => $model, 'rekeningtype' => "trkreditcarabayar", 'dariDialog' => true), true);
      }

      echo CJSON::encode(
        $html
      );
      Yii::app()->end();
    }
  }

  public function actionSearchPegawaiMengetahui($term = "") {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $peg = new PegawairuanganV;
    $peg->unsetAttributes();
    $peg->nama_pegawai = $term;
    $peg->pegawai_aktif = true;
    $peg->ruangan_id = Yii::app()->user->getState('ruangan_id');

    $prov = $peg->search();
    $prov->sort->defaultOrder = 'nama_pegawai';

    $res = array();

    foreach ($prov->data as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->namaLengkap;
      $sub['value'] = $item->pegawai_id;

      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }
}
