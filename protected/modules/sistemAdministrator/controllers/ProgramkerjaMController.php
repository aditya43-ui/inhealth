<?php

class ProgramkerjaMController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'sistemAdministrator.views.programkerjaM.';

  public function actionIndex()
  {
    $programKerja = new SAProgramkerjaM;
    $subProgramKerja = new SASubprogramkerjaM;
    $kegiatanProgram = new SAKegiatanprogramM;
    $subKegiatanProgram = new SASubkegiatanprogramM;
    $rekeningAnggaran = new SARekeninganggaranV;
    $rekeningAnggaran->subkegiatanprogram_aktif = true;
    $rekeningAnggaran->programkerja_aktif = true;
    $rekeningAnggaran->subprogramkerja_aktif = true;
    $rekeningAnggaran->kegiatanprogram_aktif = true;

    $this->render(
      $this->path_view . 'index',
      array(
        'programKerja' => $programKerja,
        'subProgramKerja' => $subProgramKerja,
        'kegiatanProgram' => $kegiatanProgram,
        'subKegiatanProgram' => $subKegiatanProgram,
        'rekeningAnggaran' => $rekeningAnggaran
      )
    );
  }

  public function actionGetInformasiProgramKerja()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = $_POST['id'];
      $model = SAProgramkerjaM::model()->findByPk($id);
      $data = $model->attributes;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetInformasiSubProgramKerja()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = $_POST['id'];
      $model = SASubprogramkerjaM::model()->findByPk($id);
      $modProgramKerjaM = SAProgramkerjaM::model()->findByPk($model->programkerja_id);
      $data = array();
      $data = $model->attributes;
      $data['programkerja_kode'] = $modProgramKerjaM->programkerja_kode;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetInformasiKegiatanProgram()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = $_POST['id'];
      $model = SAKegiatanprogramM::model()->findByPk($id);
      $modSubProgramKerjaM = SASubprogramkerjaM::model()->findByPk($model->subprogramkerja_id);
      $modProgramKerjaM = SAProgramkerjaM::model()->findByPk($modSubProgramKerjaM->programkerja_id);
      $data = array();
      $data = $model->attributes;
      $data['programkerja_kode'] = $modProgramKerjaM->programkerja_kode;
      $data['subprogramkerja_kode'] = $modSubProgramKerjaM->subprogramkerja_kode;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetInformasiSubKegiatanProgram()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = $_POST['id'];
      $model = SASubkegiatanprogramM::model()->findByPk($id);
      $modKegiatanProgramM = SAKegiatanprogramM::model()->findByPk($model->kegiatanprogram_id);
      $modSubProgramKerjaM = SASubprogramkerjaM::model()->findByPk($modKegiatanProgramM->subprogramkerja_id);
      $modProgramKerjaM = SAProgramkerjaM::model()->findByPk($modSubProgramKerjaM->programkerja_id);

      $rdebit = Rekening5M::model()->findByPk($model->rekeningdebit_id);
      $rkredit = Rekening5M::model()->findByPk($model->rekeningkredit_id);

      $data = array();
      $data = $model->attributes;
      $data['programkerja_kode'] = $modProgramKerjaM->programkerja_kode;
      $data['subprogramkerja_kode'] = $modSubProgramKerjaM->subprogramkerja_kode;
      $data['kegiatanprogram_kode'] = $modKegiatanProgramM->kegiatanprogram_kode;

      if (!empty($rdebit)) $data['rekeningdebit_nama'] = $rdebit->nmrekening5;
      if (!empty($rkredit)) $data['rekeningkredit_nama'] = $rkredit->nmrekening5;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionSimpanProgramKerja()
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
        // Program Kerja
        if (isset($data_parsing['SAProgramkerjaM'])) {
          $modelProgramKerja = new SAProgramkerjaM;
          if (strlen($data_parsing['SAProgramkerjaM']['programkerja_id']) > 0) {
            $attributes = array();
            foreach ($data_parsing['SAProgramkerjaM'] as $key => $val) {
              if ($key != 'programkerja_id') {
                $attributes[$key] = $val;
              }
            }
            $is_simpan = $modelProgramKerja->updateByPk($data_parsing['SAProgramkerjaM']['programkerja_id'], $attributes);
            $action = 'update';
          } else {
            $attributes = array(
              'programkerja_kode' => $data_parsing['SAProgramkerjaM']['programkerja_kode']
            );
            $is_exist = $modelProgramKerja->findByAttributes($attributes);


            if (!$is_exist) {
              $is_simpan = $this->simpanProgram($modelProgramKerja, $data_parsing['SAProgramkerjaM']);
              $row = Yii::app()->db->createCommand("SELECT * FROM programkerja_m ORDER BY programkerja_id DESC")->queryRow();
              $max_kode = (int) $row['programkerja_kode'];
              $max_kode = $max_kode + 1;
              $max_kode = ($max_kode < 10 ? "0" . $max_kode : $max_kode);
              $max_kode = isset($max_kode) ? $max_kode : 0;

              $id_parent = array(
                'programkerja_kode' => $max_kode
              );
            }
          }
        }
        // Sub Program Kerja
        if (isset($data_parsing['SASubprogramkerjaM'])) {
          $modelSubProgramKerja = new SASubprogramkerjaM;
          if (strlen($data_parsing['SASubprogramkerjaM']['subprogramkerja_id']) > 0) {
            $attributes = array();
            foreach ($data_parsing['SASubprogramkerjaM'] as $key => $val) {
              if ($key != 'subprogramkerja_id') {
                $attributes[$key] = $val;
              }
            }
            $is_simpan = $modelSubProgramKerja->updateByPk($data_parsing['SASubprogramkerjaM']['subprogramkerja_id'], $attributes);
            $action = 'update';
          } else {
            $attributes = array(
              'subprogramkerja_kode' => $data_parsing['SASubprogramkerjaM']['subprogramkerja_kode'],
              'programkerja_id' => $data_parsing['SASubprogramkerjaM']['programkerja_id']
            );
            $is_exist = $modelSubProgramKerja->findByAttributes($attributes);
            if (!$is_exist) {
              $is_simpan = $this->simpanSubProgram($modelSubProgramKerja, $data_parsing['SASubprogramkerjaM']);

              $params = array();
              foreach ($attributes as $key => $val) {
                if ($key != 'subprogramkerja_kode') {
                  $params[] = $key . " = " . $val;
                }
              }
              $sql = "SELECT * FROM subprogramkerja_m " . (count((array)$params) > 0 ? "WHERE " . implode($params, " AND ") : "") . " ORDER BY subprogramkerja_id DESC";
              $row = Yii::app()->db->createCommand($sql)->queryRow();
              $max_kode = (int) $row['subprogramkerja_kode'];
              $max_kode = $max_kode + 1;
              $max_kode = ($max_kode < 10 ? "0" . $max_kode : $max_kode);

              $id_parent = array(
                'programkerja_kode' => $data_parsing['SASubprogramkerjaM']['programkerja_kode'],
                'subprogramkerja_kode' => $max_kode
              );
            }
          }
        }
        // Kegiatan Program
        if (isset($data_parsing['SAKegiatanprogramM'])) {
          $model = new SAKegiatanprogramM;

          if (strlen($data_parsing['SAKegiatanprogramM']['kegiatanprogram_id']) > 0) {
            $attributes = array();
            foreach ($data_parsing['SAKegiatanprogramM'] as $key => $val) {
              if ($key != 'kegiatanprogram_id') {
                $attributes[$key] = $val;
              }
            }
            $is_simpan = $model->updateByPk($data_parsing['SAKegiatanprogramM']['kegiatanprogram_id'], $attributes);
            $action = 'update';
          } else {
            $attributes = array(
              'kegiatanprogram_kode' => $data_parsing['SAKegiatanprogramM']['kegiatanprogram_kode'],
              //                            'programkerja_id' => $data_parsing['SAKegiatanprogramM']['programkerja_id'],
              'subprogramkerja_id' => $data_parsing['SAKegiatanprogramM']['subprogramkerja_id']
            );
            $is_exist = $model->findByAttributes($attributes);
            if (!$is_exist) {
              $is_simpan = $this->simpanKegiatanProgram($model, $data_parsing['SAKegiatanprogramM']);

              $params = array();
              foreach ($attributes as $key => $val) {
                if ($key != 'kegiatanprogram_kode') {
                  $params[] = $key . " = " . $val;
                }
              }
              $sql = "SELECT * FROM kegiatanprogram_m " . (count((array)$params) > 0 ? "WHERE " . implode($params, " AND ") : "") . " ORDER BY kegiatanprogram_id DESC";
              $row = Yii::app()->db->createCommand($sql)->queryRow();

              $max_kode = (int) $row['kegiatanprogram_kode'];
              $max_kode = $max_kode + 1;
              $max_kode = ($max_kode < 10 ? "0" . $max_kode : $max_kode);

              $id_parent = array(
                'programkerja_kode' => $data_parsing['SAKegiatanprogramM']['programkerja_kode'],
                'subprogramkerja_kode' => $data_parsing['SAKegiatanprogramM']['subprogramkerja_kode'],
                'kegiatanprogram_kode' => $max_kode
              );
            }
          }
        }
        // Sub Kegiatan Program
        if (isset($data_parsing['SASubkegiatanprogramM'])) {
          $model = new SASubkegiatanprogramM;
          if (strlen($data_parsing['SASubkegiatanprogramM']['subkegiatanprogram_id']) > 0) {
            $attributes = array();
            foreach ($data_parsing['SASubkegiatanprogramM'] as $key => $val) {
              if ($key != 'subkegiatanprogram_id') {
                $attributes[$key] = $val;
              }
            }
            $is_simpan = $model->updateByPk($data_parsing['SASubkegiatanprogramM']['subkegiatanprogram_id'], $attributes);
            $action = 'update';
          } else {
            $attributes = array(
              'subkegiatanprogram_kode' => $data_parsing['SASubkegiatanprogramM']['subkegiatanprogram_kode'],
              'kegiatanprogram_id' => $data_parsing['SASubkegiatanprogramM']['kegiatanprogram_id']
            );
            $is_exist = $model->findByAttributes($attributes);
            if (!$is_exist) {
              $is_simpan = $this->simpanSubKegiatan($model, $data_parsing['SASubkegiatanprogramM']);
              $params = array();
              foreach ($attributes as $key => $val) {
                if ($key != 'subkegiatanprogram_kode') {
                  $params[] = $key . " = " . $val;
                }
              }
              $sql = "SELECT * FROM subkegiatanprogram_m " . (count((array)$params) > 0 ? "WHERE " . implode($params, " AND ") : "") . " ORDER BY subkegiatanprogram_id DESC";
              $row = Yii::app()->db->createCommand($sql)->queryRow();
              $max_kode = (int) $row['subkegiatanprogram_kode'];
              $max_kode = $max_kode + 1;
              $max_kode = ($max_kode < 10 ? "0" . $max_kode : $max_kode);
              $id_parent = array(
                'programkerja_kode' => $data_parsing['SASubkegiatanprogramM']['programkerja_kode'],
                'subprogramkerja_kode' => $data_parsing['SASubkegiatanprogramM']['subprogramkerja_kode'],
                'kegiatanprogram_kode' => $data_parsing['SASubkegiatanprogramM']['kegiatanprogram_kode'],
                'subkegiatanprogram_kode' => $max_kode
              );
            }
          }
        }

        if ($is_simpan) {
          $transaction->commit();
        } else {
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        $transaction->rollback();
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


  protected function simpanProgram($model, $params)
  {
    $maxRow = Yii::app()->db->createCommand("SELECT * FROM programkerja_m ORDER BY programkerja_nourut DESC")->queryRow();
    $maxRow = (int) $maxRow['programkerja_nourut'];
    $maxRow = $maxRow + 1;
    $model->attributes = $params;
    $model->programkerja_nourut = $maxRow;
    $model->create_time = date("Y-m-d");
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_ruangan = Yii::app()->user->ruangan_id;
    if ($model->validate()) {
      if ($model->save()) {
        return true;
      } else {
        return false;
      }
    } else {
      print_r($model->getErrors());
      return false;
    }
  }

  protected function simpanSubProgram($model, $params)
  {
    $maxRow = Yii::app()->db->createCommand("SELECT * FROM subprogramkerja_m ORDER BY subprogramkerja_nourut DESC")->queryRow();
    $maxRow = (int) $maxRow['subprogramkerja_nourut'];
    $maxRow = $maxRow + 1;
    $model->attributes = $params;
    $model->subprogramkerja_nourut = $maxRow;
    $model->create_time = date("Y-m-d");
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_ruangan = Yii::app()->user->ruangan_id;
    if ($model->validate()) {
      if ($model->save()) {
        return true;
      } else {
        return false;
      }
    } else {
      print_r($model->getErrors());
      return false;
    }
  }

  protected function simpanKegiatanProgram($model, $params)
  {
    $maxRow = Yii::app()->db->createCommand("SELECT * FROM kegiatanprogram_m ORDER BY kegiatanprogram_nourut DESC")->queryRow();
    $maxRow = (int) $maxRow['kegiatanprogram_nourut'];
    $maxRow = $maxRow + 1;
    $model->attributes = $params;
    $model->kegiatanprogram_nourut = $maxRow;
    $model->create_time = date("Y-m-d");
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_ruangan = Yii::app()->user->ruangan_id;
    if ($model->validate()) {
      if ($model->save()) {
        return true;
      } else {
        return false;
      }
    } else {
      print_r($model->getErrors());
      return false;
    }
  }


  protected function simpanSubKegiatan($model, $params)
  {
    $maxRow = Yii::app()->db->createCommand("SELECT * FROM subkegiatanprogram_m ORDER BY subkegiatanprogram_nourut DESC")->queryRow();
    $maxRow = (int) $maxRow['subkegiatanprogram_nourut'];
    $maxRow = $maxRow + 1;
    $model->attributes = $params;
    $model->subkegiatanprogram_nourut = $maxRow;
    $model->create_time = date("Y-m-d");
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_ruangan = Yii::app()->user->ruangan_id;
    if ($model->validate()) {
      if ($model->save()) {
        return true;
      } else {
        return false;
      }
    } else {
      print_r($model->getErrors());
      return false;
    }
  }

  public function actionGetTreeMenuAnggaran()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $criteria = new CDbCriteria;
      $programKerja = new ProgramkerjaM;
      $subProgramKerja = new ProgramkerjaM;
      $kegiatanProgram = new KegiatanprogramM;
      $subKegiatanProgram = new SubkegiatanprogramM;

      $params = array('programkerja_aktif' => true);
      $criteria->order = 'programkerja_id';
      $result = $programKerja->findAllByAttributes($params, $criteria);
      $parent_satu = '';
      foreach ($result as $val) {
        $params_dua = array(
          'subprogramkerja_aktif' => true,
          'programkerja_id' => $val->programkerja_id,
        );
        $criteria->order = 'subprogramkerja_id';
        $result_dua = $subProgramKerja->findAllByAttributes($params_dua, $criteria);
        $parent_dua = '';
        foreach ($result_dua as $val_dua) {
          $params_tiga = array(
            'kegiatanprogram_aktif' => true,
            'subprogramkerja_id' => $val_dua->subprogramkerja_id,
          );
          $criteria->order = 'kegiatanprogram_id';
          $result_tiga = $kegiatanProgram->findAllByAttributes($params_tiga, $criteria);
          $parent_tiga = '';
          foreach ($result_tiga as $val_tiga) {
            $params_empat = array(
              'subkegiatanprogram_aktif' => true,
              'kegiatanprogram_id' => $val_tiga->kegiatanprogram_id,
            );
            $criteria->order = 'subkegiatanprogram_id';
            $result_empat = $subKegiatanProgram->findAllByAttributes($params_empat, $criteria);
            $parent_empat = '';
            foreach ($result_empat as $val_empat) {
              $parent_empat .= "<li><span class='file'>" . $val_empat->subkegiatanprogram_nama . "<span style='float:right'><a value='" . $val_empat->subkegiatanprogram_id . "' href='#' onclick='editSubKegiatanProgram(this);return false;' rel='tooltip' data-original-title='Klik untuk edit sub kegiatan program'><i class='icon-pencil-brown'></i></a></span></span></li>";
            }

            $kode_kelompok_empat = $val->programkerja_kode . '_' . $val_dua->subprogramkerja_kode . '_' . $val_tiga->kegiatanprogram_kode;
            $id_kelompok_empat = $val_tiga->programkerja_id . '_' . $val_tiga->subprogramkerja_id . '_' . $val_tiga->kegiatanprogram_id;
            if (count((array)$result_empat) > 0) {
              $parent_tiga .= "<li><span class='folder'>" . $val_tiga->kegiatanprogram_nama . "<span style='float:right'><a max_kode='" . $val_empat->subkegiatanprogram_kode . "' id_pro='" . $id_kelompok_empat . "' kode_pro='" . $kode_kelompok_empat . "' href='#' onclick='tambahSubKegiatanProgram(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah sub kegiatan program'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='" . $val_tiga->kegiatanprogram_id . "' href='#' onclick='editKegiatanProgram(this);return false;' rel='tooltip' data-original-title='Klik untuk edit kegiatan program'><i class='icon-pencil-brown'></i></a></span></span><ul>" . $parent_empat . "</ul></li>";
            } else {
              $parent_tiga .= "<li class='expandable'><span class='folder'>" . $val_tiga->kegiatanprogram_nama . "<span style='float:right'><a max_kode='0' id_pro='" . $id_kelompok_empat . "' kode_pro='" . $kode_kelompok_empat . "' href='#' onclick='tambahSubKegiatanProgram(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah sub kegiatan program'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='" . $val_tiga->kegiatanprogram_id . "' href='#' onclick='editKegiatanProgram(this);return false;' rel='tooltip' data-original-title='Klik untuk edit kegiatan program'><i class='icon-pencil-brown'></i></a></span></span></li>";
            }
          }

          $kode_kelompok = $val->programkerja_kode . '_' . $val_dua->subprogramkerja_kode;
          $id_kelompok = $val_dua->programkerja_id . '_' . $val_dua->subprogramkerja_id;
          if (count((array)$result_tiga) > 0) {
            $parent_dua .= "<li id='" . $id_kelompok . "'><span class='folder'>" . $val_dua->subprogramkerja_nama . "<span style='float:right'><a max_kode='" . $val_tiga->kegiatanprogram_kode . "' id_pro='" . $id_kelompok . "' kode_pro='" . $kode_kelompok . "' href='#' onclick='tambahKegiatanProgram(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah kegiatan program'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='" . $val_dua->subprogramkerja_id . "' href='#' onclick='editSubProgramKerja(this);return false;' rel='tooltip' data-original-title='Klik untuk edit sub program kerja'><i class='icon-pencil-brown'></i></a></span></span><ul>" . $parent_tiga . "</ul></li>";
          } else {
            $parent_dua .= "<li id='" . $id_kelompok . "' class='expandable'><span class='folder'>" . $val_dua->subprogramkerja_nama . "<span style='float:right'><a max_kode='0' id_pro='" . $id_kelompok . "' kode_pro='" . $kode_kelompok . "' href='#' onclick='tambahKegiatanProgram(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah kegiatan program'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='" . $val_dua->subprogramkerja_id . "' href='#' onclick='editSubProgramKerja(this);return false;' rel='tooltip' data-original-title='Klik untuk edit sub program kerja'><i class='icon-pencil-brown'></i></a></span></span></li>";
          }
        }

        $value_kode = $val->programkerja_kode;
        $value_id = $val->programkerja_id;
        if (count((array)$result_dua) > 0) {
          $parent_satu .= "<li id='" . $value_id . "'><span class='folder'>" . $val->programkerja_nama . "<span style='float:right'><a max_kode='" . $val_dua->subprogramkerja_kode . "' id_pro='" . $value_id . "' kode_pro='" . $value_kode . "' href='#' onclick='tambahSubProgramKerja(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah sub program kerja'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='" . $val->programkerja_id . "' href='#' onclick='editProgramKerja(this);return false;' rel='tooltip' data-original-title='Klik untuk edit program kerja'><i class='icon-pencil-brown'></i></a></span></span><ul>" . $parent_dua . "</ul></li>";
        } else {
          $parent_satu .= "<li id='" . $value_id . "' class='expandable'><span class='folder'>" . $val->programkerja_nama . "<span style='float:right'><a max_kode='0' id_pro='" . $value_id . "' kode_pro='" . $value_kode . "' href='#' onclick='tambahSubProgramKerja(this);return false;' rel='tooltip' data-original-title='Klik untuk menambah sub program kerja'><i class='icon-plus-sign'></i></a></span><span style='float:right'><a value='" . $val->programkerja_id . "' href='#' onclick='editProgramKerja(this);return false;' rel='tooltip' data-original-title='Klik untuk edit program kerja'><i class='icon-pencil-brown'></i></a></span></span></li>";
        }
      }

      if (count((array)$result) > 0) {
        $text = '<span class="folder">Program Kerja<span style="float:right"><a max_kode = "' . $val->programkerja_kode . '" href="#" onclick="tambahProgramKerja(this);return false;" rel="tooltip" data-original-title="Klik untuk menambah program kerja"><i class="icon-plus-sign"></i></a></span></span>';
        $parent_satu = $text . '<ul>' . $parent_satu . '</ul>';
      }
      echo json_encode($parent_satu);
      Yii::app()->end();
    }
  }

  public function actionEditProgramKerja()
  {
    $this->layout = '//layouts/iframe';
    $programKerja = new SAProgramkerjaM;

    $id = $_GET['id'];
    $model = $programKerja->findByPk($id);

    $this->render(
      $this->path_view . '_formInputProgramKerja',
      array(
        'programKerja' => $model
      )
    );
  }

  public function actionEditSubProgramKerja()
  {
    $this->layout = '//layouts/iframe';
    $model_subprogramkerja = new SASubprogramkerjaM;

    $id = $_GET['id'];
    $model = $model_subprogramkerja->findByPk($id);

    $subProgramKerja = SAProgramkerjaM::model()->findByPk($model->programkerja_id);
    $model['programkerja_kode'] = $subProgramKerja->programkerja_kode;


    $this->render(
      $this->path_view . '_formInputSubProgramKerja',
      array(
        'subProgramKerja' => $model
      )
    );
  }

  public function actionEditKegiatanProgram()
  {
    $this->layout = '//layouts/iframe';
    $model_kegiatan_program = new SAKegiatanprogramM;

    $id = $_GET['id'];
    $model = $model_kegiatan_program->findByPk($id);

    $subProgramKerja = SASubprogramkerjaM::model()->findByPk($model->subprogramkerja_id);
    $programKerja = SAProgramkerjaM::model()->findByPk($subProgramKerja->programkerja_id);
    $model['programkerja_kode'] = $programKerja->programkerja_kode;
    $model['subprogramkerja_kode'] = $subProgramKerja->subprogramkerja_kode;

    $this->render(
      $this->path_view . '_formInputKegiatanProgram',
      array(
        'kegiatanProgram' => $model
      )
    );
  }

  public function actionEditSubKegiatanProgram()
  {
    $this->layout = '//layouts/iframe';
    $model_subkegiatanprogram = new SASubkegiatanprogramM;

    $id = $_GET['id'];
    $model = $model_subkegiatanprogram->findByPk($id);

    $kegiatanProgram = SAKegiatanprogramM::model()->findByPk($model->kegiatanprogram_id);
    $subProgramKerja = SASubprogramkerjaM::model()->findByPk($kegiatanProgram->subprogramkerja_id);
    $programKerja = SAProgramkerjaM::model()->findByPk($subProgramKerja->programkerja_id);
    $model['kegiatanprogram_kode'] = $kegiatanProgram->kegiatanprogram_kode;
    $model['subprogramkerja_kode'] = $subProgramKerja->subprogramkerja_kode;
    $model['programkerja_kode'] = $programKerja->programkerja_kode;

    $this->render(
      $this->path_view . '_formInputSubKegiatanProgram',
      array(
        'subKegiatanProgram' => $model
      )
    );
  }

  public function actionPrint()
  {
    $model = new SARekeninganggaranV;

    if (isset($_REQUEST['SARekeninganggaranV'])) {
      $model->attributes = $_REQUEST['SARekeninganggaranV'];
    }
    $judulLaporan = 'Data Anggaran';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
    }
  }
}
