<?php

class PengeluaranKasController extends MyAuthController
{
  protected $succesSave = true;
  protected $pesan = "succes";
  protected $is_action = "insert";

  public function actionIndex()
  {
    $modPengUmum = new KUPengeluaranumumT;
    $modPengUmum->volume = 1;
    $modPengUmum->hargasatuan = 0;
    $modPengUmum->totalharga = 0;
    $modPengUmum->nopengeluaran = MyGenerator::noPengeluaranUmum();
    $modUraian = array();
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

    $this->render('index', array(
      'modPengUmum' => $modPengUmum,
      'modUraian' => $modUraian,
      'modBuktiKeluar' => $modBuktiKeluar,
      'modJurnalRekening' => $modJurnalRekening,
      'modJurnalDetail' => $modJurnalDetail,
      'modJurnalPosting' => $modJurnalPosting
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

          $modJurnalRekening = $this->saveJurnalRekening($modPengUmum, $data_parsing['KUPengeluaranumumT']);

          $params = array(
            'modJurnalRekening' => $modJurnalRekening,
            'jenis_simpan' => $_REQUEST['jenis_simpan'],
            'RekeningakuntansiV' => $data_parsing['RekeningakuntansiV'],
          );
          //                        $insertDetailJurnal = $this->insertDetailJurnal($params);
          //                        $this->succesSave = $insertDetailJurnal;
          //						$modJurnalPosting = $this->saveJurnalPosting($modJurnalRekening);

          $modJurnalDetail = $this->saveJurnalDetail(
            $data_parsing['KUPengeluaranumumT'],
            $modJurnalRekening,
            //                            $modJurnalPosting,
            $data_parsing['RekeningakuntansiV']
          );

          /*
                        if($_REQUEST['jenis_simpan'] == 'posting')
                        {
                            $modJurnalPosting = $this->saveJurnalPosting($modJurnalRekening);
                        }
                        $modJurnalDetail = $this->saveJurnalDetail(
                            $data_parsing['KUPenerimaanUmumT'],
                            $modJurnalRekening,
                            $modJurnalPosting,
                            $data_parsing['RekeningakuntansiV']
                        );
                        */
          if ($this->succesSave) {
            $transaction->commit();
            $this->pesan = array(
              'nopengeluaran' => MyGenerator::noPengeluaranUmum(),
              'nokaskeluar' => MyGenerator::noKasKeluar()
            );
          } else {
            $transaction->rollback();
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
        'pesan' => $this->pesan,
        'status' => ($this->succesSave == true ? 'ok' : 'not'),
      );
      echo json_encode($result);
      Yii::app()->end();
    }
  }

  protected function saveTandaBuktiKeluar($postBuktiKeluar)
  {
    $modBuktiKeluar = new KUTandabuktikeluarT;
    $modBuktiKeluar->attributes = $postBuktiKeluar;
    $modBuktiKeluar->tahun = date('Y');
    $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
    $modBuktiKeluar->biayaadministrasi = 0;
    $modBuktiKeluar->jmlkaskeluar = 0;
    $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modBuktiKeluar->tahun = date('Y');
    $this->succesSave = false;
    if ($modBuktiKeluar->validate()) {
      $modBuktiKeluar->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modBuktiKeluar->getErrors();
    }

    return $modBuktiKeluar;
  }

  protected function savePengeluaranUmum($postPengeluaran, $modBuktiKeluar)
  {
    $modPengUmum = new KUPengeluaranumumT;
    $modPengUmum->attributes = $postPengeluaran;
    $modPengUmum->nopengeluaran = MyGenerator::noPengeluaranUmum();
    $modPengUmum->biayaadministrasi = $modBuktiKeluar->biayaadministrasi;
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

  protected function saveUraian($arrPostUraian, $modPengUmum)
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

  protected function saveJurnalRekening($modPenUmum, $postPenUmum)
  {
    $modJurnalRekening = new KUJurnalrekeningT;
    $modJurnalRekening->tglbuktijurnal = $modPenUmum->tglpengeluaran;
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = 0;
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
    $periodeID = Yii::app()->user->getState('periode_ids');
    $modJurnalRekening->rekperiod_id = $periodeID[0];
    $modJurnalRekening->create_time = $modPenUmum->tglpengeluaran;
    $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
    $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');


    if ($modJurnalRekening->validate()) {
      $modJurnalRekening->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modJurnalRekening->getErrors();
    }
    return $modJurnalRekening;
  }

  //  RND-8145 : jurnal posting sudah di triger di database
  //       protected function saveJurnalDetail($arrJurnal, $modJurnalRekening, $modJurnalPosting = null, $rekeningakuntansi)
  protected function saveJurnalDetail($arrJurnal, $modJurnalRekening, $rekeningakuntansi)
  {

    $valid = true;
    //   RND-8145   : jurnal posting sudah di triger di database
    //       $model[$i]->jurnalposting_id = ($modJurnalPosting == null ? null : $modJurnalPosting->jurnalposting_id);
    foreach ($rekeningakuntansi as $i => $data) {
      $model = new KUJurnaldetailT();
      $model->rekperiod_id = $modJurnalRekening->rekperiod_id;
      $model->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
      //                $model[$i]->uraiantransaksi = $arrJurnal['jenisKodeNama'];
      $model->uraiantransaksi = isset($data['nama_rekening']) ? $data['nama_rekening'] : "";
      $model->saldodebit = isset($data['saldodebit']) ? $data['saldodebit'] : 0;
      $model->saldokredit = isset($data['saldokredit']) ? $data['saldokredit'] : 0;
      $model->nourut = $i + 1;
      $model->rekening1_id = isset($data['struktur_id']) ? $data['struktur_id'] : null;
      $model->rekening2_id = isset($data['kelompok_id']) ? $data['kelompok_id'] : null;
      $model->rekening3_id = isset($data['jenis_id']) ? $data['jenis_id'] : null;
      $model->rekening4_id = isset($data['obyek_id']) ? $data['obyek_id'] : null;
      $model->rekening5_id = isset($data['rincianobyek_id']) ? $data['rincianobyek_id'] : null;
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

  /* 
     * ambil data rekening berdasarkan penerimaan Kas 
     * modul > akutansi > penerimaan_kas
     */
  public function actionGetDataRekeningByJnsPenerimaan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $jenispenerimaan_id = isset($_POST['jenispenerimaan_id']) ? $_POST['jenispenerimaan_id'] : null;
      $criteria = new CDbCriteria;
      //			dicomment RND-8517			
      //            $criteria->select = '*, jnspenerimaanrek_m.saldonormal';
      //            $criteria->join = '
      //                JOIN jnspenerimaanrek_m ON 
      //                    jnspenerimaanrek_m.rekening1_id = t.struktur_id AND
      //                    jnspenerimaanrek_m.rekening2_id = t.kelompok_id AND
      //                    jnspenerimaanrek_m.rekening3_id = t.jenis_id AND
      //                    jnspenerimaanrek_m.rekening4_id = t.obyek_id AND
      //                    jnspenerimaanrek_m.rekening5_id = t.rincianobyek_id                
      //            ';
      //            $criteria->condition = 'jnspenerimaanrek_m.jenispenerimaan_id = :jenispenerimaan_id';
      //            $criteria->params = array(':jenispenerimaan_id'=>$jenispenerimaan_id);
      //            $model = RekeningakuntansiV::model()->findAll($criteria);            
      if (!empty($jenispenerimaan_id)) {
        $criteria->addCondition('jenispenerimaan_id = ' . $jenispenerimaan_id);
      }
      $criteria->order = 'rekening5_nb ASC';
      $model = KUJenispenerimaanrekeningV::model()->findAll($criteria);
      echo CJSON::encode(
        $this->renderPartial('__formKodeRekening', array('model' => $model), true)
      );

      Yii::app()->end();
    }
  }

  /* 
     * ambil data rekening berdasarkan pengeluaran Kas 
     * modul > akutansi > pengeluaran_kas
     */
  public function actionGetDataRekeningByJnsPengeluaran()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $jenispengeluaran_id = isset($_POST['jenispengeluaran_id']) ? $_POST['jenispengeluaran_id'] : null;
      $criteria = new CDbCriteria;
      //			dicomment karena RND-8517			
      //            $criteria->select = '*, jnspengeluaranrek_m.saldonormal';
      //            $criteria->join = '
      //                JOIN jnspengeluaranrek_m ON 
      //                    jnspengeluaranrek_m.rekening1_id = t.struktur_id AND
      //                    jnspengeluaranrek_m.rekening2_id = t.kelompok_id AND
      //                    jnspengeluaranrek_m.rekening3_id = t.jenis_id AND
      //                    jnspengeluaranrek_m.rekening4_id = t.obyek_id AND
      //                    jnspengeluaranrek_m.rekening5_id = t.rincianobyek_id                
      //            ';
      //            $criteria->condition = 'jnspengeluaranrek_m.jenispengeluaran_id = :jenispengeluaran_id';
      //            $criteria->params = array(':jenispengeluaran_id'=>$jenispengeluaran_id);
      //            $model = RekeningakuntansiV::model()->findAll($criteria);            
      if (!empty($jenispengeluaran_id)) {
        $criteria->addCondition('jenispengeluaran_id =' . $jenispengeluaran_id);
      }
      $criteria->order = 'rekening5_nb ASC';
      $model = KUJenispengeluaranrekeningV::model()->findAll($criteria);
      echo CJSON::encode(
        $this->renderPartial('__formKodeRekening', array('model' => $model), true)
      );

      Yii::app()->end();
    }
  }

  public function actionAmbilDataRekening()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $rekening1_id = isset($_POST['rekening1_id']) ? $_POST['rekening1_id'] : null;
      $rekening2_id = isset($_POST['rekening2_id']) ? $_POST['rekening2_id'] : null;
      $rekening3_id = isset($_POST['rekening3_id']) ? $_POST['rekening3_id'] : null;
      $rekening4_id = isset($_POST['rekening4_id']) ? $_POST['rekening4_id'] : null;
      $rekening5_id = isset($_POST['rekening5_id']) ? $_POST['rekening5_id'] : null;
      $status      = isset($_POST['status']) ? $_POST['status'] : null;
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
      //			$criteria->select = '*';
      //			$criteria->condition = implode($data, ' AND ');
      //			$criteria->params = $params;

      if (!empty($rekening5_id)) {
        $criteria->addCondition("rekening5_id = " . $rekening5_id);
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
          $this->renderPartial('__formKodeRekening', array('model' => $model, 'status' => $status), true)
        );
      }
      Yii::app()->end();
    }
  }

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
}
