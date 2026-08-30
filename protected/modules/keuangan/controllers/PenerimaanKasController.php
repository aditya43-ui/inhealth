<?php
class PenerimaanKasController extends MyAuthController
{
  protected $succesSave = true;
  protected $pesan = "succes";
  protected $is_action = "insert";

  public function actionIndex()
  {
    $modPenUmum = new KUPenerimaanUmumT;
    $modPenUmum->volume = 1;
    $modPenUmum->hargasatuan = 0;
    $modPenUmum->totalharga = 0;
    $modPenUmum->nopenerimaan = MyGenerator::noPenerimaanUmum();
    $modUraian[0] = new KUUraianpenumumT;
    $modUraian[0]->volume = 1;
    $modUraian[0]->hargasatuan = 0;
    $modUraian[0]->totalharga = 0;

    $modTandaBukti = new KUTandabuktibayarT;
    $modTandaBukti->jmlpembulatan = 0;
    $modTandaBukti->biayaadministrasi = 0;
    $modTandaBukti->biayamaterai = 0;
    $modTandaBukti->jmlpembayaran = $modPenUmum->totalharga;
    $modJurnalRekening = array();
    $modJurnalDetail = array();
    $modJUrnalPosting = array();
    if (isset($_POST['KUPenerimaanUmumT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modTandaBukti = $this->saveTandaBukti($_POST['KUTandabuktibayarT']);
        $modPenUmum = $this->savePenerimaan($_POST['KUPenerimaanUmumT'], $modTandaBukti);

        if ($modPenUmum->isuraintransaksi && isset($_POST['KUUraianpenumumT'])) {
          $modUraian = $this->saveUraian($_POST['KUUraianpenumumT'], $modPenUmum);
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

    $this->render(
      'index',
      array(
        'modPenUmum' => $modPenUmum,
        'modUraian' => $modUraian,
        'modTandaBukti' => $modTandaBukti,
        'modJurnalRekening' => $modJurnalRekening,
        'modJurnalDetail' => $modJurnalDetail,
        'modJurnalPosting' => $modJUrnalPosting,
        'modUraian' => $modUraian
      )
    );
  }

  public function actionSimpanPenerimaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPenUmum = new KUPenerimaanUmumT;
      $modTandaBukti = new KUTandabuktibayarT;
      $modJurnalPosting = null;
      parse_str($_REQUEST['data'], $data_parsing);
      $format = new MyFormatter();

      if (isset($data_parsing['KUPenerimaanUmumT'])) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $modTandaBukti = $this->saveTandaBukti($data_parsing['KUTandabuktibayarT']);

          $data_parsing['KUPenerimaanUmumT']['tglpenerimaan'] = $format->formatDateTimeForDb($data_parsing['KUPenerimaanUmumT']['tglpenerimaan']);

          $modPenUmum = $this->savePenerimaan($data_parsing['KUPenerimaanUmumT'], $modTandaBukti);
          if (isset($_POST['RekeningakuntansiV'])) {
            $modUraian = $this->saveUraian($data_parsing['KUPenerimaanUmumT'], $modPenUmum);
          }

          $modJurnalRekening = $this->saveJurnalRekening($modPenUmum, $data_parsing['KUPenerimaanUmumT']);
          $params = array(
            'modJurnalRekening' => $modJurnalRekening,
            'jenis_simpan' => $_REQUEST['jenis_simpan'],
            'RekeningakuntansiV' =>  isset($data_parsing['RekeningakuntansiV']) ? $data_parsing['RekeningakuntansiV'] : '',
          );
          //                            $insertDetailJurnal = $this->insertDetailJurnal($params);
          //                            $this->succesSave = $insertDetailJurnal;

          /* comment dibuka karena : RND-8473 */
          if ($_REQUEST['jenis_simpan'] == 'posting') {
            $modJurnalPosting = $this->saveJurnalPosting($modJurnalRekening);
          }

          $modJurnalDetail = $this->saveJurnalDetail(
            $data_parsing['KUPenerimaanUmumT'],
            $modJurnalRekening,
            $modJurnalPosting,
            $data_parsing['RekeningakuntansiV']
          );
          if ($this->succesSave) {

            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data berhasil disimpan");
            $this->pesan = array(
              'nopenerimaan' => MyGenerator::noPenerimaanUmum()
            );
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          }
        } catch (Exception $exc) {
          print_r($exc);
          $this->pesan = $exc;
          $this->succesSave = false;
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        }
      }

      $result = array(
        'action' => $this->is_action,
        'pesan' => $this->pesan,
        'status' => ($this->succesSave == true ? 'ok' : 'not'),
        'tandabuktibayar_id' => $modTandaBukti->tandabuktibayar_id,
      );

      echo json_encode($result);
      Yii::app()->end();
    }
  }

  protected function saveTandaBukti($postTandaBukti)
  {
    $format = new MyFormatter();
    $modTandaBukti = new KUTandabuktibayarT;
    $modTandaBukti->attributes = $postTandaBukti;
    $modTandaBukti->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modTandaBukti->nourutkasir = MyGenerator::noUrutKasir($modTandaBukti->ruangan_id);
    $modTandaBukti->nobuktibayar = MyGenerator::noBuktiBayar();
    $modTandaBukti->shift_id = Yii::app()->user->getState('shift_id');
    $modTandaBukti->tglbuktibayar = $format->formatDateTimeForDb($postTandaBukti['tglbuktibayar']);
    $modTandaBukti->create_time = date('Y-m-d H:i:s');
    $modTandaBukti->create_loginpemakai_id = Yii::app()->user->id;
    $modTandaBukti->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($modTandaBukti->validate()) {
      $modTandaBukti->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modTandaBukti->getErrors();
    }
    return $modTandaBukti;
  }

  protected function savePenerimaan($postPenerimaan, $modTandaBukti)
  {
    $modPenUmum = new KUPenerimaanUmumT;
    $modPenUmum->attributes = $postPenerimaan;
    $modPenUmum->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPenUmum->penjamin_id = Params::PENJAMIN_ID_UMUM;
    $modPenUmum->tandabuktibayar_id = $modTandaBukti->tandabuktibayar_id;

    if ($modPenUmum->validate()) {
      $modPenUmum->save();
      $this->succesSave = true;
    } else {
      $this->succesSave = false;
      $this->pesan = $modPenUmum->getErrors();
    }
    return $modPenUmum;
  }

  protected function saveUraian($arrPostUraian, $modPenUmum)
  {
    $valid = false;
    $modUraian = array();
    for ($i = 0; $i < count((array)$arrPostUraian); $i++) {
      if (strlen($arrPostUraian[$i]['uraiantransaksi']) > 0) {
        $modUraian[$i] = new KUUraianpenumumT;
        $modUraian[$i]->attributes = $arrPostUraian[$i];
        $modUraian[$i]->penerimaanumum_id = $modPenUmum->penerimaanumum_id;

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
    $modJurnalRekening->tglbuktijurnal = $modPenUmum->tglpenerimaan;
    $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
    $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
    $modJurnalRekening->noreferensi = 0;
    $modJurnalRekening->tglreferensi = $modPenUmum->tglpenerimaan;
    $modJurnalRekening->nobku = "";
    $modJurnalRekening->urianjurnal = $postPenUmum['jenisKodeNama'];
    $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PENERIMAAN_KAS;
    $modJurnalRekening->rekperiod_id = Yii::app()->user->getState('periode_ids');
    $modJurnalRekening->create_time = $modPenUmum->tglpenerimaan;
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

  protected function saveJurnalDetail($arrJurnal, $modJurnalRekening, $modJurnalPosting = null, $rekeningakuntansi)
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
      //			$model->rekening1_id = isset($data['rekening1_id']) ? $data['rekening1_id'] : null;
      //			$model->rekening2_id = isset($data['rekening2_id']) ? $data['rekening2_id'] : null;
      //			$model->rekening3_id = isset($data['rekening3_id']) ? $data['rekening3_id'] : null;
      //			$model->rekening4_id = isset($data['rekening4_id']) ? $data['rekening4_id'] : null;
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

  protected function updateJurnalDetail($modJurnalDetail, $modJurnalPosting)
  {
    KUJurnaldetailT::model()->updateByPk($modJurnalDetail->jurnaldetail_id, array(
      'jurnalposting_id' => $modJurnalPosting->jurnalposting_id
    ));
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

  public function actionGetDataRekeningByJnsPenerimaan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $jenispenerimaan_id = isset($_POST['jenispenerimaan_id']) ? $_POST['jenispenerimaan_id'] : null;
      $criteria = new CDbCriteria;
      //			dicomment karena RND-8517			
      //			$criteria->select = '*, jnspenerimaanrek_m.saldonormal';
      //			$criteria->join = '
      //				JOIN jnspenerimaanrek_m ON 
      //					jnspenerimaanrek_m.rekening1_id = t.struktur_id AND
      //					jnspenerimaanrek_m.rekening2_id = t.kelomopok_id AND
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
      $criteria->order = 'rekening5_id ASC';
      $model = KUJenispenerimaanrekeningV::model()->findAll($criteria);

      if ($model) {
        echo CJSON::encode(
          $this->renderPartial('__formKodeRekening', array('model' => $model), true)
        );
      }
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {
    $this->layout = '//layouts/printWindows';
    $modTandaBukti = TandabuktibayarT::model()->findByPk($_GET['id']);
    $modPenerimaanUmum = PenerimaanumumT::model()->findByAttributes(array('tandabuktibayar_id' => $_GET['id']));
    $this->render('print', array(
      'modPenerimaanUmum' => $modPenerimaanUmum,
      'modTandaBukti' => $modTandaBukti,

    ));
  }

  public function actionAutocompleteJenisPenerimaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(jenispenerimaan_nama)', strtolower($_GET['term']), true);
      //                $criteria->addCondition('LOWER(jenispenerimaan_kode) || \' - \' || LOWER(jenispenerimaan_nama) LIKE \'%'.strtolower($_GET['term']).'%\'');
      $criteria->addCondition("jenispenerimaan_id in(select jenispenerimaan_id from jnspenerimaanrek_m)");
      $models = JenispenerimaanM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->jenispenerimaan_kode . ' - ' . $model->jenispenerimaan_nama;
        $returnVal[$i]['value'] = $model->jenispenerimaan_kode . ' - ' . $model->jenispenerimaan_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
