<?php

class KodeRekeningController extends MyAuthController
{
  public function actionIndex()
  {
    if (isset($_POST['is_ajax'])) {
      if (isset($_POST['param'])) {
        call_user_func(array($this, $_POST['f']), $_POST['param']);
      } else {
        call_user_func(array($this, $_POST['f']));
      }
      Yii::app()->end();
    }

    $this->pageTitle = Yii::app()->name . " - Kode Akun";
    $rekeningSatu = new AKRekening1M;
    $rekeningDua = new AKRekening2M;
    $rekeningTiga = new AKRekening3M;
    $rekeningEmpat = new AKRekening4M;
    $rekeningLima = new AKRekening5M;
    $rekeningakuntansiV = new MasterakunrekeningV;
    $rekeningakuntansiV->aktif = true;
    // $rekeningakuntansiV->akun = 5;

    if (isset($_GET['MasterakunrekeningV'])) {
      $rekeningakuntansiV->attributes = $_GET['MasterakunrekeningV'];
      // $rekeningakuntansiV->akun = $_GET['MasterakunrekeningV']['akun'];
    }

    $this->render(
      'index',
      array(
        'rekeningSatu' => $rekeningSatu,
        'rekeningDua' => $rekeningDua,
        'rekeningTiga' => $rekeningTiga,
        'rekeningEmpat' => $rekeningEmpat,
        'rekeningLima' => $rekeningLima,
        'rekeningakuntansiV' => $rekeningakuntansiV
      )
    );
  }

  public function actionSimpanRekening()
  {
    if (Yii::app()->request->isAjaxRequest) {
      parse_str($_REQUEST['data'], $data_parsing);
      $transaction = Yii::app()->db->beginTransaction();
      $criteria = new CDbCriteria;

      try {
        $is_simpan = false;
        $is_exist = false;
        $action = 'insert';
        $id_parent = '';

        if (isset($data_parsing['AKRekening1M'])) {
          $modelRekSatu = new AKRekening1M;
          if (strlen($data_parsing['AKRekening1M']['rekening1_id']) > 0) {
            $attributes = array();
            foreach ($data_parsing['AKRekening1M'] as $key => $val) {
              if ($key != 'rekening1_id') {
                $attributes[$key] = $val;
              }
            }

            $kel = KelrekeningM::model()->findByPk($data_parsing['AKRekening1M']["kelrekening_id"]);
            // $attributes["rekening1_nb"] = ;
            $attributes['kdrekening1'] = trim($attributes['kdrekening1']);
            $attributes['update_loginpemakai_id'] = Yii::app()->user->id;
            $attributes['update_time'] = date('Y-m-d H:i:s');
            //if (strlen($attributes['kdrekening1']) == Params::REKENING1_LEN) {
            //		$is_simpan = $modelRekSatu->updateByPk($data_parsing['AKRekening1M']['rekening1_id'], $attributes);
            //		$action = 'update';
            //} else {
            //		$action = 'kode';
            //	}
            $is_simpan = $modelRekSatu->updateByPk($data_parsing['AKRekening1M']['rekening1_id'], $attributes);
            $action = 'update';
          } else {
            $data_parsing['AKRekening1M']['kdrekening1'] = trim($data_parsing['AKRekening1M']['kdrekening1']);
            $attributes = array(
              'kdrekening1' => $data_parsing['AKRekening1M']['kdrekening1']
            );
            //if (strlen($attributes['kdrekening1']) == Params::REKENING1_LEN) {
            $is_exist = $modelRekSatu->findByAttributes($attributes);
            if (!$is_exist) {
              $kel = KelrekeningM::model()->findByPk($data_parsing['AKRekening1M']["kelrekening_id"]);
              // $modelRekSatu->rekening1_nb = $kel->saldonormal;
              $is_simpan = $this->simpanRekening($modelRekSatu, $data_parsing['AKRekening1M']);
              $row = Yii::app()->db->createCommand("SELECT * FROM rekening1_m ORDER BY rekening1_id DESC")->queryRow();
              $max_kode = (int) $row['kdrekening1'];
              $max_kode = $max_kode + 1;
              $max_kode = ($max_kode < 10 ? "0" . $max_kode : $max_kode);
              $max_kode = isset($max_kode) ? $max_kode : 0;

              //var_dump($max_kode);die;
              $id_parent = array(
                'kdrekening1' => $max_kode
              );
            }

            //} else {
            //	$action = 'kode';
            //}
          }
        }

        if (isset($data_parsing['AKRekening2M'])) {
          $model = new AKRekening2M;
          if (strlen($data_parsing['AKRekening2M']['rekening2_id']) > 0) {
            $attributes = array();
            foreach ($data_parsing['AKRekening2M'] as $key => $val) {
              if ($key != 'rekening2_id') {
                $attributes[$key] = $val;
              }
            }

            $attributes['kdrekening2'] = trim($attributes['kdrekening2']);
            $attributes['update_loginpemakai_id'] = Yii::app()->user->id;
            $attributes['update_time'] = date('Y-m-d H:i:s');
            //	if (strlen($attributes['kdrekening2']) == Params::REKENING2_LEN) {
            $is_simpan = $model->updateByPk($data_parsing['AKRekening2M']['rekening2_id'], $attributes);
            $action = 'update';
            //} else {
            //		$action = 'kode';
            //}
          } else {
            $data_parsing['AKRekening2M']['kdrekening2'] = trim($data_parsing['AKRekening2M']['kdrekening2']);
            $attributes = array(
              'kdrekening2' => $data_parsing['AKRekening2M']['kdrekening2'],
              'rekening1_id' => $data_parsing['AKRekening2M']['rekening1_id']
            );

            //if (strlen($attributes['kdrekening2']) == Params::REKENING2_LEN) {
            $is_exist = $model->findByAttributes($attributes);
            if (!$is_exist) {
              $is_simpan = $this->simpanRekening($model, $data_parsing['AKRekening2M']);

              $params = array();
              foreach ($attributes as $key => $val) {
                if ($key != 'kdrekening2') {
                  $params[] = $key . " = " . $val;
                }
              }
              $sql = "SELECT * FROM rekening2_m " . (count((array)$params) > 0 ? "WHERE " . implode($params, " AND ") : "") . " ORDER BY rekening2_id DESC";
              $row = Yii::app()->db->createCommand($sql)->queryRow();
              $max_kode = (int) $row['kdrekening2'];
              $max_kode = $max_kode + 1;
              $max_kode = ($max_kode < 10 ? "0" . $max_kode : $max_kode);

              $id_parent = array(
                'rekening1_id' => $data_parsing['AKRekening2M']['rekening1_id'],
                'kdrekening2' => $max_kode
              );
            }
            //} else {
            //		$action = 'kode';
            //}
          }
        }

        if (isset($data_parsing['AKRekening3M'])) {
          $model = new AKRekening3M;
          if (strlen($data_parsing['AKRekening3M']['rekening3_id']) > 0) {
            $attributes = array();
            foreach ($data_parsing['AKRekening3M'] as $key => $val) {
              if ($key != 'rekening3_id') {
                $attributes[$key] = $val;
              }
            }

            $attributes['kdrekening3'] = trim($attributes['kdrekening3']);
            $attributes['update_loginpemakai_id'] = Yii::app()->user->id;
            $attributes['update_time'] = date('Y-m-d H:i:s');
            //	if (strlen($attributes['kdrekening3']) == Params::REKENING3_LEN) {
            $is_simpan = $model->updateByPk($data_parsing['AKRekening3M']['rekening3_id'], $attributes);
            $action = 'update';
            //} else {
            //$action = 'kode';
            //}
          } else {
            $data_parsing['AKRekening3M']['kdrekening3'] = trim($data_parsing['AKRekening3M']['kdrekening3']);
            $attributes = array(
              'kdrekening3' => $data_parsing['AKRekening3M']['kdrekening3'],
              'rekening2_id' => $data_parsing['AKRekening3M']['rekening2_id']
            );

            //if (strlen($attributes['kdrekening3']) == Params::REKENING3_LEN) {
            $is_exist = $model->findByAttributes($attributes);
            if (!$is_exist) {
              $rek2 = Rekening2M::model()->findByPk($data_parsing['AKRekening3M']['rekening2_id']);
              $data_parsing['AKRekening3M']['rekening1_id'] = $rek2->rekening1_id;
              //									 var_dump($data_parsing); die;
              $is_simpan = $this->simpanRekening3M($model, $data_parsing['AKRekening3M']);
              $params = array();
              foreach ($attributes as $key => $val) {
                if ($key != 'kdrekening3') {
                  $params[] = $key . " = " . $val;
                }
              }
              $sql = "SELECT * FROM rekening3_m " . (count((array)$params) > 0 ? "WHERE " . implode($params, " AND ") : "") . " ORDER BY rekening3_id DESC";
              $row = Yii::app()->db->createCommand($sql)->queryRow();

              $max_kode = (int) $row['kdrekening3'];
              $max_kode = $max_kode + 1;
              $max_kode = ($max_kode < 10 ? "0" . $max_kode : $max_kode);

              $id_parent = array(
                'rekening2_id' => $data_parsing['AKRekening3M']['rekening2_id'],
                'kdrekening3' => $max_kode
              );
            }
            //} else {
            //		$action = 'kode';
            //}
          }
        }

        if (isset($data_parsing['AKRekening4M'])) {
          $model = new AKRekening4M;
          if (strlen($data_parsing['AKRekening4M']['rekening4_id']) > 0) {
            $attributes = array();
            foreach ($data_parsing['AKRekening4M'] as $key => $val) {
              if ($key != 'rekening4_id') {
                $attributes[$key] = $val;
              }
            }

            $attributes['kdrekening4'] = trim($attributes['kdrekening4']);
            $attributes['update_loginpemakai_id'] = Yii::app()->user->id;
            $attributes['update_time'] = date('Y-m-d H:i:s');
            //if (strlen($attributes['kdrekening4']) == Params::REKENING4_LEN) {
            $is_simpan = $model->updateByPk($data_parsing['AKRekening4M']['rekening4_id'], $attributes);
            $action = 'update';
            //} else {
            //	$action = 'kode';
            //	}
          } else {
            $data_parsing['AKRekening4M']['kdrekening4'] = trim($data_parsing['AKRekening4M']['kdrekening4']);
            $attributes = array(
              'kdrekening4' => $data_parsing['AKRekening4M']['kdrekening4'],
              'rekening3_id' => $data_parsing['AKRekening4M']['rekening3_id']
            );

            //if (strlen($attributes['kdrekening4']) == Params::REKENING4_LEN) {
            $is_exist = $model->findByAttributes($attributes);
            if (!$is_exist) {
              $is_simpan = $this->simpanRekening($model, $data_parsing['AKRekening4M']);
              $params = array();
              foreach ($attributes as $key => $val) {
                if ($key != 'kdrekening4') {
                  $params[] = $key . " = " . $val;
                }
              }
              // $sql = "SELECT * FROM rekening4_m " . (count((array)$params) > 0 ? "WHERE " . implode($params, " AND ") : "") . " ORDER BY rekening4_id DESC";
              // $row = Yii::app()->db->createCommand($sql)->queryRow();
              // $max_kode = (int) $row['kdrekening4'];
              // $max_kode = $max_kode + 1;
              // $max_kode = ($max_kode < 10 ? "0" . $max_kode : $max_kode);
              // $id_parent = array(
              //   // 'rekening3_id' => $data_parsing['AKRekening4M']['rekening3_id'],
              //   // 'kdrekening4' => $max_kode
              // );
            }
            //} else {
            //		$action = 'kode';
            //	}
          }
        }
        if (isset($data_parsing['AKRekening5M'])) {
          $model = new AKRekening5M;
          if (strlen($data_parsing['AKRekening5M']['rekening5_id']) > 0) {
            $attributes = array();
            foreach ($data_parsing['AKRekening5M'] as $key => $val) {
              if ($key != 'rekening5_id') {
                $attributes[$key] = $val;
              }
            }

            $attributes['kdrekening5'] = trim($attributes['kdrekening5']);
            //if (strlen($attributes['kdrekening5']) == Params::REKENING5_LEN) {
            $attributes['update_loginpemakai_id'] = Yii::app()->user->id;
            $attributes['update_time'] = date('Y-m-d H:i:s');
            $is_simpan = $model->updateByPk($data_parsing['AKRekening5M']['rekening5_id'], $attributes);
            $action = 'update';
            //} else {
            //		$action = 'kode';
            //}
          } else {
            $data_parsing['AKRekening5M']['kdrekening5'] = trim($data_parsing['AKRekening5M']['kdrekening5']);
            $attributes = array(
              'kdrekening5' => $data_parsing['AKRekening5M']['kdrekening5'],
              // 'rekening4_id' => $data_parsing['AKRekening5M']['rekening4_id']
            );
            //if (strlen($attributes['kdrekening5']) == Params::REKENING5_LEN) {
            $is_exist = $model->findByAttributes($attributes);
            if (!$is_exist) {
              // var_dump($data_parsing);
              // $rek4 = Rekening4M::model()->findByPk($data_parsing['AKRekening5M']['rekening4_id']);
              // $rek3 = Rekening3M::model()->findByPk($rek4->rekening3_id);
              // $rek2 = Rekening2M::model()->findByPk($rek3->rekening2_id);
              // $rek1 = Rekening1M::model()->findByPk($rek2->rekening1_id);

              // $data_parsing['AKRekening5M']['kelompokrek'] = $rek1->kelrekening_id;
              // $data_parsing['AKRekening5M']['rekening1_id'] = $rek2->rekening1_id;
              // $data_parsing['AKRekening5M']['rekening2_id'] = $rek3->rekening2_id;
              // $data_parsing['AKRekening5M']['rekening3_id'] = $rek4->rekening3_id;

              $data_parsing['AKRekening5M']['create_ruangan'] = Yii::app()->user->getState('ruangan_id');
              $data_parsing['AKRekening5M']['create_loginpemakai_id'] = Yii::app()->user->id;
              $data_parsing['AKRekening5M']['create_time'] = date('Y-m-d H:i:s');
              $is_simpan = $this->simpanRekening($model, $data_parsing['AKRekening5M']);

              $params = array();
              foreach ($attributes as $key => $val) {
                if ($key != 'kdrekening5') {
                  $params[] = $key . " = " . $val;
                }
              }
              $sql = "SELECT * FROM rekening5_m " . (count((array)$params) > 0 ? "WHERE " . implode($params, " AND ") : "") . " ORDER BY rekening5_id DESC";

              $row = Yii::app()->db->createCommand($sql)->queryRow();
              $max_kode = (int) $row['kdrekening5'];
              $max_kode = $max_kode + 1;
              $max_kode = ($max_kode < 10 ? "0" . $max_kode : $max_kode);
              $saldonormal = $row['rekening5_nb'];

              $id_parent = array(
                // 'rekening4_id' => $data_parsing['AKRekening5M']['rekening4_id'],
                'kdrekening5' => $max_kode,
                'saldonormal' => $saldonormal,
              );
            }
            //} else {
            //		$action = 'kode';
            //}
          }
        }

        if ($is_simpan) {
          Yii::app()->user->setFlash('success', 'Data berhasil disimpan');
          $transaction->commit();
        } else {
          Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        //  echo $exc; die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
      }

      $result = array(
        'id_parent' => $id_parent,
        'pesan' => ($is_exist == true ? 'exist' : $action),
        'status' => ($is_simpan == true ? 'ok' : 'not'),
      );

      echo json_encode($result);
      Yii::app()->end();
    }
  }

  protected function simpanRekening($model, $params)
  {
    $model->attributes = $params;
    //		echo json_encode($params);exit;
    if ($model->validate()) {
      if ($model->save()) {
        return true;
      } else {
        print_r($model->getErrors());
        return false;
      }
    } else {
      print_r($model->getErrors());
      return false;
    }
  }

  protected function simpanRekening3M($model, $params)
  {
    $model2 = new AKRekening3M;
    $model2->attributes = $params;
    if ($model2->validate()) {
      if ($model2->save()) {
        return true;
      } else {
        print_r($model2->getErrors());
        return false;
      }
    } else {
      print_r($model2->getErrors());
      return false;
    }
  }

  public function actionGetInformasiStruktur()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = $_POST['id'];
      $model = AKRekening1M::model()->findByPk($id);
      $data = $model->attributes;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetInformasiKelompok()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = $_POST['id'];
      $model = AKRekening2M::model()->findByPk($id);
      $modRekening1M = AKRekening1M::model()->findByPk($model->rekening1_id);
      $data = array();
      $data = $model->attributes;
      $data['kdrekening1'] = $modRekening1M->kdrekening1;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetInformasiJenis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = $_POST['id'];
      $model = AKRekening3M::model()->findByPk($id);
      $modRekening2M = AKRekening2M::model()->findByPk($model->rekening2_id);
      $data = array();
      $data = $model->attributes;
      $data['kdrekening2'] = $modRekening2M->kdrekening2;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetInformasiObyek()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = $_POST['id'];
      $model = AKRekening4M::model()->findByPk($id);
      $modRekening3M = AKRekening3M::model()->findByPk($model->rekening3_id);

      $data = array();
      $data = $model->attributes;

      $data['kdrekening3'] = $modRekening3M->kdrekening3;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetInformasiDetailObyek()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = $_POST['id'];
      $model = AKRekening5M::model()->findByPk($id);
      if (strtolower($model->keterangan) == 'null') {
        $model->keterangan = null;
      }
      $modRekening4M = AKRekening4M::model()->findByPk($model->rekening4_id);

      $data = array();
      $data = $model->attributes;

      $data['kdrekening4'] = $modRekening4M->kdrekening4;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionEditStrukturRekening()
  {
    $this->layout = '//layouts/iframe';
    $rekeningSatu = new AKRekening1M;

    $id = $_GET['id'];
    $model = $rekeningSatu->findByPk($id);

    $this->render(
      '__formInputRekeningSatu',
      array(
        'rekeningSatu' => $model
      )
    );
  }

  public function actionEditKelompokRekening()
  {
    $this->layout = '//layouts/iframe';
    $model_rekening = new AKRekening2M;

    $id = $_GET['id'];
    $model = $model_rekening->findByPk($id);

    $modRekening1M = AKRekening1M::model()->findByPk($model->rekening1_id);
    $model['rekening1_id'] = $modRekening1M->rekening1_id;


    $this->render(
      '__formInputRekeningDua',
      array(
        'rekeningDua' => $model
      )
    );
  }

  public function actionEditJenisRekening()
  {
    $this->layout = '//layouts/iframe';
    $model_rekening = new AKRekening3M;

    $id = $_GET['id'];
    $model = $model_rekening->findByPk($id);
    $modRekening2M = AKRekening2M::model()->findByPk($model->rekening2_id);
    $model['rekening2_id'] = $modRekening2M->rekening2_id;

    $this->render(
      '__formInputJenisRekening',
      array(
        'jenisRekening' => $model
      )
    );
  }

  public function actionEditObyekRekening()
  {
    $this->layout = '//layouts/iframe';
    $model_rekening = new AKRekening4M;

    $id = $_GET['id'];
    $model = $model_rekening->findByPk($id);

    $modRekening3M = AKRekening3M::model()->findByPk($model->rekening3_id);

    $model['rekening3_id'] = $modRekening3M->rekening3_id;

    $this->render(
      '__formInputObyekRekening',
      array(
        'model' => $model
      )
    );
  }

  public function actionEditRincianObyekRek()
  {
    $this->layout = '//layouts/iframe';
    $model_rekening = new AKRekening5M;
    $id = $_GET['id'];
    $model = $model_rekening->findByPk($id);

    $modRekening4M = AKRekening4M::model()->findByPk($model->rekening4_id);

    $model['rekening4_id'] = $modRekening4M->rekening4_id;

    $this->render(
      '__formInputObyekDetailRekening',
      array(
        'model' => $model
      )
    );
  }

  public function actionPrint()
  {
    $model = new MasterakunrekeningV;
    $model->aktif = true;
    //$model->akun = 5;

    if (isset($_REQUEST['MasterakunrekeningV'])) {
      $model->attributes = $_REQUEST['MasterakunrekeningV'];
    }
    $judulLaporan = 'Data Kode Rekening';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('PrintV2', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('PrintV2', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $footer = '
            <table width="100%">
            <tr>'
        . '<td style = "text-align:left;font-size:12px;"><i><b>{PAGENO}</b></i></td>'
        . '</tr>
             <tr>'
        . '<td style = "text-align:right;font-size:12px;"><i><b>Created At : ' . MyFormatter::formatDateTimeId(date('Y-m-d H:i:s')) . '</b></i></td>'
        . '<td style = "text-align:right;font-size:12px;"><i><b>Created By : ' . $this->pageTitle = Yii::app()->user->nama_pemakai . ' </b></i></td>'
        . '</tr>
            </table>';
      $mpdf->SetHtmlFooter($footer, 'E');
      $mpdf->SetHtmlFooter($footer, 'O');
      // $mpdf->mirrorMargins = 2;//
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 20, 5);
      $mpdf->WriteHTML($this->renderPartial('PrintV2', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
    } else if ($caraPrint == "CSV") {
      CSV::konversiTabel($this->renderPartial('PrintV2', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true), $judulLaporan . '-' . date('Y/m/d') . '.csv');
    }
  }

  function loadTree()
  {
    $rekeningSatu = new AKRekening1M;
    $rekeningDua = new AKRekening2M;
    $rekeningTiga = new AKRekening3M;
    $rekeningEmpat = new AKRekening4M;
    $rekeningLima = new AKRekening5M;
    $rekeningakuntansiV = new MasterakunrekeningV;

    echo $this->renderPartial('__treeAkun', array(
      'rekeningSatu' => $rekeningSatu,
      'rekeningDua' => $rekeningDua,
      'rekeningTiga' => $rekeningTiga,
      'rekeningEmpat' => $rekeningEmpat,
      'rekeningLima' => $rekeningLima,
    ), true);
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

  public function actionEksportCSV()
  {
    $this->layout = FALSE;
    $jenis = "export";
    $dt = array();
    $model = null;
    $tableName = "masterakunrekening_v";

    $table = Yii::app()->db->getSchema()->getTable($tableName);

    if (!empty($table->name)) {
      $sql = "select * from {$table->name} where akun = 5 and aktif = true";

      $model = Yii::app()->db->createCommand($sql)->queryAll();

      $sqlType = "SELECT
					a.attname as kolom ,
					pg_catalog.format_type(a.atttypid, a.atttypmod) as datatype
				FROM
					pg_catalog.pg_attribute a
				WHERE
					a.attnum > 0
					AND NOT a.attisdropped
					AND a.attrelid = (
						SELECT c.oid
						FROM pg_catalog.pg_class c
							LEFT JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace
						WHERE c.relname  = '" . $table->name . "'
							AND pg_catalog.pg_table_is_visible(c.oid)
					);";
      $sqlType = Yii::app()->db->createCommand($sqlType)->queryAll();

      foreach ($sqlType as $type) {
        $dt[$type['kolom']] = $type['datatype'];
      }
    }
    $judul = "Template CSV $tableName";
    $content = "";

    $kolom = $table->columns;
    $i = 0;

    foreach ($kolom as $counter => $column) {
      $content .= $column->name;
      $i++;
      if (count((array)$kolom) != $i) {
        $content .= ',';
      }
    }
    $content .= "\n";

    $kolom = $table->columns;

    $i = 0;
    foreach ($kolom as $counter => $column) {
      $content .= $dt[$column->name];
      $i++;
      if (count((array)$kolom) != $i) {
        $content .= ',';
      }
    }
    $content .= "\n";

    foreach ($model as $key => $value) {
      $i = 0;
      foreach ($kolom as $counter => $column) {
        $content .= $value[$column->name];
        $i++;
        if (count((array)$kolom) != $i) {
          $content .= ',';
        }
      }

      $content .= "\n";
    }

    Yii::app()->getRequest()->sendFile($judul . '-' . date("Y/m/d") . '.csv', $content, "text/csv", false);
    die;
  }
}
