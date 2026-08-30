<?php

class JurnalPenerimaanKasController extends MyAuthController
{
  protected $path_view = 'akuntansi.views.jurnalPenerimaanKas.';

  public $success = true;
  public $is_action = 'insert';
  public $pesan = 'succes';


  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Posting Jurnal Umum";
    $model = new AKJurnalrekeningT();
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    //        print_r(Yii::app()->controller->id);
    if (isset($_GET['AKJurnalrekeningT'])) {
      $model->attributes = $_GET['AKJurnalrekeningT'];
      $model->tgl_awal = $_GET['AKJurnalrekeningT']['tgl_awal'];
      $model->tgl_akhir = $_GET['AKJurnalrekeningT']['tgl_akhir'];
    }
    $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
    $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
    $this->render($this->path_view . 'index', array('model' => $model, 'path_view' => $this->path_view));
  }

  public function actionGetDaftarRekening()
  {
    if (Yii::app()->request->isAjaxRequest) {
      parse_str($_POST['data'], $data_parsing);

      $format = new MyFormatter();
      $model = new AKJurnaldetailT();
      $model->attributes = $data_parsing['AKJurnalrekeningT'];
      $model->is_posting = 1;
      $model->tgl_awal = $format->formatDateTimeForDb($data_parsing['AKJurnalrekeningT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($data_parsing['AKJurnalrekeningT']['tgl_akhir']);
      $model->jenisjurnal_id = array(Params::JENISJURNAL_ID_PENERIMAAN_KAS);
      $model->kodejurnal = $data_parsing['AKJurnalrekeningT']['kodejurnal'];
      $model->nobuktijurnal = $data_parsing['AKJurnalrekeningT']['nobuktijurnal'];
      $record = $model->searchWithJoinBaru();
      $record->pagination = false;
      $record->criteria->limit = -1;

      // var_dump($_POST, $data_parsing, $model->attributes); die;

      $result = array();
      $aa = array();
      
      foreach ($record->getData() as $key => $val) {
        $attributes = $val->attributes;
        
        $attributes['tglbuktijurnal'] = date("d-m-Y", strtotime($val->jurnalRekening->tglbuktijurnal));
        $attributes['tglbuktijurnalform'] = MyFormatter::formatDateTimeForuser($val->jurnalRekening->tglbuktijurnal);
        $attributes['nobuktijurnal'] = $val->jurnalRekening->nobuktijurnal;
        $attributes['kodejurnal'] = $val->jurnalRekening->kodejurnal;
        $attributes['urianjurnal'] = $val->jurnalRekening->urianjurnal;
        $attributes['tglreferensi'] = MyFormatter::formatDateTimeForUser($val->jurnalRekening->tglreferensi);
        $attributes['noreferensi'] = $val->jurnalRekening->noreferensi;
        $attributes['jurnaldetail_id'] = $val->jurnaldetail_id;

        //                $attributes['tglbuktijurnal'] = date("d-m-Y", strtotime($val->tglbuktijurnal));
        //                $attributes['tglbuktijurnalform'] = MyFormatter::formatDateTimeForuser($val->tglbuktijurnal);
        //				$attributes['nobuktijurnal'] = $val->nobuktijurnal;
        //                $attributes['kodejurnal'] = $val->kodejurnal;
        //				$attributes['tglreferensi'] = MyFormatter::formatDateTimeForUser($val->tglreferensi);
        //                $attributes['noreferensi'] = $val->noreferensi;
        ////                $attributes['urianjurnal'] = $val->jurnalRekening->urianjurnal;
        //                $attributes['urianjurnal'] = (!empty($val->uraiantransaksi)?$val->uraiantransaksi:$val->urianjurnal);

        $criteria = new CDbCriteria;
        // if (!empty($val->rekening1_id)) {
        //   $criteria->addCondition("rekening1_id = " . $val->rekening1_id);
        // }
        // if (!empty($val->rekening2_id)) {
        //   $criteria->addCondition("rekening2_id = " . $val->rekening2_id);
        // }
        // if (!empty($val->rekening3_id)) {
        //   $criteria->addCondition("rekening3_id = " . $val->rekening3_id);
        // }
        // if (!empty($val->rekening4_id)) {
        //   $criteria->addCondition("rekening4_id = " . $val->rekening4_id);
        // }
        if (!empty($val->rekening5_id)) {
          $criteria->addCondition("rekening5_id = " . $val->rekening5_id);
        }
        $rec_nama = Rekening5M::model()->find($criteria);
        // $rec_nama = AKRekeningakuntansiV::model()->find($criteria);

        if (!empty($rec_nama)) {
          $attributes['rekening5_id'] = $rec_nama->rekening5_id;
          $attributes['rekening4_id'] = null;
          $attributes['rekening3_id'] = null;
          $attributes['rekening2_id'] = null;
          $attributes['rekening1_id'] = null;

          $nama_rekening = $rec_nama->nmrekening5;
          $kode_rekening = $rec_nama->kdrekening5;
          $status_rekening = $rec_nama->rekening5_nb;
        } else {

          $attributes['rekening5_id'] = null;
          $attributes['rekening4_id'] = null;
          $attributes['rekening3_id'] = null;
          $attributes['rekening2_id'] = null;
          $attributes['rekening1_id'] = null;

          $nama_rekening = "-";
          $kode_rekening = "-";
          $status_rekening = "D";
        }
        $attributes['nama_rekening'] = $nama_rekening;
        $attributes['kode_rekening'] = $kode_rekening;
        $attributes['saldo_normal'] = ($status_rekening == "D" ? "Debit" : "Kredit");
        $attributes['saldodebit'] = number_format($attributes['saldodebit'], 2, ",", ".");
        $attributes['saldokredit'] = number_format($attributes['saldokredit'], 2, ",", ".");

        //                $result[] = $val->attributes;
        $attributes['cehkRek'] = 0;
        $result[] = $attributes;
      }

      foreach ($result as $data) {
        $aa[$data['kodejurnal']][] = $data;
      }
      $index = 0;
      $indexData = 0;
      $dp = [];
      foreach ($aa as $i => $itemd) {
        foreach ($itemd as $data) {

          $data['cehkRek'] = $index;
          $dp[] = array('cehkRek' => $index, 'kodejurnal' => $data['kodejurnal']);
        }
        $index++;
      }
      $cek = false;
      foreach ($result as $dataRs) {
        $cek = false;
        foreach ($dp as $dataDp) {
          if ($dataRs['kodejurnal'] == $dataDp['kodejurnal']) {
            $dataRs['cehkRek'] = $dataDp['cehkRek'];
            $cek = true;
            break;
          }
        }
        $result[$indexData] = $dataRs;
        $indexData++;
      }
      
      echo json_encode($result);
    }
    Yii::app()->end();
  }

  public function actionSimpanJurnalPosting()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      parse_str($_REQUEST['data'], $data_parsing);
      $transaction = Yii::app()->db->beginTransaction();

      try {
        // echo '<pre>';
        // print_r($data_parsing);
        // exit();
        $record = $this->validasiTabular($data_parsing['AKJurnalrekeningT']);
        if (count((array)$record) > 0) {
        //   if (Yii::app()->controller->id == 'jurnalPenerimaanKas') {
        //     $arrayJurnalSimpan = array();
        //     foreach ($record as $key => $val) {
        //       $arrayJurnalSimpan[$val['jurnalrekening_id']] = $val['jurnalrekening_id'];
        //     }

        //     if (count((array)$arrayJurnalSimpan) > 0) {
        //       $index = "";
        //       foreach ($arrayJurnalSimpan as $dataVal) {
        //         $jurnal = JurnalrekeningT::model()->findByPk($dataVal);
        //         $jurnaldets = JurnaldetailT::model()->findAllByAttributes(array('jurnalrekening_id' => $dataVal));

        //         if (count((array)$jurnaldets) > 0) {
        //           foreach ($jurnaldets as $dataDet) {
        //             //                                        $rek = RekeningakuntansiV::model()->findByAttributes(array(
        //             //                                            'rekening5_id'=>$dataDet->rekening5_id,
        //             //                                        ));
        //             //
        //             //                                        $parameter = array(
        //             //                                            'koreksi' => true,
        //             //                                            'rekening5_id' => $dataDet->rekening5_id,
        //             //                                            'saldodebit' => MyFormatter::formatNumberForDb($dataDet->saldodebit),
        //             //                                            'saldokredit' => MyFormatter::formatNumberForDb($dataDet->saldokredit)
        //             //                                        );
        //             //
        //             //                                        if (!empty($rek)) {
        //             //                                            $parameter['rekening1_id'] = $rek->rekening1_id;
        //             //                                            $parameter['rekening2_id'] = $rek->rekening2_id;
        //             //                                            $parameter['rekening3_id'] = $rek->rekening3_id;
        //             //                                            $parameter['rekening4_id'] = $rek->rekening4_id;
        //             //                                        }
        //             //
        //             //                                        AKJurnaldetailT::model()->updateByPk($val->jurnaldetail_id, $parameter);
        //             $model = new AKJurnalpostingT();
        //             $model->tgljurnalpost = $jurnal->tglbuktijurnal;
        //             $model->keterangan = $jurnal->urianjurnal;
        //             $model->create_time = date("Y-m-d H:i:s");
        //             $model->create_loginpemekai_id = Yii::app()->user->id;
        //             $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        //             $model->jurnaldetail_id = $dataDet->jurnaldetail_id;

        //             $criteria = new CDbCriteria();
        //             $criteria->addCondition("'" . $jurnal->tglbuktijurnal . "'::date between tglperiodeposting_awal::date and tglperiodeposting_akhir::date");
        //             $criteria->addCondition("periodeposting_aktif = true");
        //             $periode = PeriodepostingM::model()->find($criteria);

        //             if (empty($periode)) {
        //               $periode = PeriodepostingM::model()->find(array(
        //                 'condition' => 'periodeposting_aktif = true',
        //                 'order' => 'tglperiodeposting_awal asc',
        //               ));
        //             }

        //             $model->periodeposting_id = $periode->periodeposting_id;

        //             if ($model->validate()) {
        //               $model->save();
        //               $attributeJurnalDet = array('jurnalposting_id' => $model->jurnalposting_id,
        //                                     'rekening5_id'=>);
        //               $updateJurdet = JurnaldetailT::model()->updateByPk($dataDet->jurnaldetail_id, );
        //               //                                            $jurnaldet->jurnalposting_id = $model->jurnalposting_id;
        //               $this->success = $this->success && $updateJurdet;
        //             } else {
        //               $this->pesan = $model->getErrors();
        //               $this->success = false;
        //               break;
        //             }

        //             $index = $jurnal->jurnalrekening_id;
        //           }
        //         }
        //       }
        //     }
        //   } else {
            $index = "";

            foreach ($record as $key => $val) {
              $this->updateJurnalRekening($val);

              $jurnaldet = JurnaldetailT::model()->findByPk($val['jurnaldetail_id']);
              $jurnal = JurnalrekeningT::model()->findByPk($jurnaldet->jurnalrekening_id);

              $model = new AKJurnalpostingT();
              $model->tgljurnalpost = $jurnal->tglbuktijurnal;
              $model->keterangan = $val['urianjurnal'];
              $model->create_time = date("Y-m-d H:i:s");
              $model->create_loginpemekai_id = Yii::app()->user->id;
              $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
              $model->jurnaldetail_id = $val['jurnaldetail_id'];

              $criteria = new CDbCriteria();
              $criteria->addCondition("'" . $jurnal->tglbuktijurnal . "'::date between tglperiodeposting_awal::date and tglperiodeposting_akhir::date");
              $criteria->addCondition("periodeposting_aktif = true");
              $periode = PeriodepostingM::model()->find($criteria);

              if (empty($periode)) {
                $periode = PeriodepostingM::model()->find(array(
                  'condition' => 'periodeposting_aktif = true',
                  'order' => 'tglperiodeposting_awal asc',
                ));
              }

              $model->periodeposting_id = $periode->periodeposting_id;

              if ($model->validate()) {
                $model->save();
                $jurnaldet->jurnalposting_id = $model->jurnalposting_id;
                $this->success = $this->success && $jurnaldet->save();
              } else {
                $this->pesan = $model->getErrors();
                $this->success = false;
                break;
              }

              $index = $val['jurnalrekening_id'];
            }
        //   }
        }

        // var_dump($this->success); die;

        if ($this->success) {
          $transaction->commit();
        } else {
          $transaction->rollback();
          // $this->pesan = "Transaksi Gagal";
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $this->pesan = $exc->getMessage();
        $this->success = false;
      }

      $result = array(
        'action' => $this->is_action,
        'pesan' => $this->pesan,
        'status' => ($this->success == true) ? 'ok' : 'not',
      );
      echo json_encode($result);
    }
    Yii::app()->end();
  }


  private function updateJurnalRekening($val)
  {
    $rek = RekeningakuntansiV::model()->findByAttributes(array(
      'rekeninglast_id' => $val['rekening5_id'],
    ));

    $parameter = array(
      'koreksi' => true,
      'rekening5_id' => $val['rekening5_id'],
      // 'saldodebit' => str_replace(".", "", $val['saldodebit']),
      // 'saldokredit' => str_replace(".", "", $val['saldokredit'])
      'saldodebit' => MyFormatter::formatNumberForDb($val['saldodebit']),
      'saldokredit' => MyFormatter::formatNumberForDb($val['saldokredit'])
    );

    if (!empty($rek)) {
      $parameter['rekening1_id'] = $rek->rekening1_id;
      $parameter['rekening2_id'] = $rek->rekening2_id;
      $parameter['rekening3_id'] = $rek->rekening3_id;
      $parameter['rekening4_id'] = $rek->rekening4_id;
    }

    $update = AKJurnaldetailT::model()->updateByPk($val['jurnaldetail_id'], $parameter);

    // var_dump($update); die;

    return $update;
  }

  private function validasiTabular($params)
  {
    $result = array();
    $index = null;
    $i = 1;
    foreach ($params as $key => $val) {
      if ($val['is_checked'] == 1) {
        $result[] = $val;
      }
    }
    return $result;
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
