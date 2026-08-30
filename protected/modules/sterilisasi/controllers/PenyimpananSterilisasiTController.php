<?php

class PenyimpananSterilisasiTController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'sterilisasi.views.penyimpananSterilisasiT.';
  public $penyimpanansterilisasitersimpan = false;
  public $penyimpanansterilisasidetailtersimpan = true;

  public function actionIndex($penyimpanansteril_id = null, $sterilisasi_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Penyimpanan Sterilisasi";
    $format = new MyFormatter();
    $modSterilisasi = new STSterilisasiT;
    $modSterilisasiDetail = new STSterilisasidetailT('searchSterilisasi');
    $modSterilisasiDetail->tgl_awal = date('Y-m-d H:i:s');
    $modSterilisasiDetail->tgl_akhir = date('Y-m-d H:i:s');
    $modSterilisasiDetail->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $modPenyimpananSterilisasi = new STPenyimpanansterilT;
    $modPenyimpananSterilisasi->penyimpanansteril_tgl = date('Y-m-d H:i:s');
    $modPenyimpananSterilisasi->penyimpanansteril_no = '-- Otomatis --';
    $modPenyimpananSterilisasiDetail = array();
    $modPenyimpananSterilisasiBahan = array();
    $instalasiTujuans = CHtml::listData(STInstalasiM::getInstalasiItems(), 'instalasi_id', 'instalasi_nama');
    $ruanganTujuans = CHtml::listData(STRuanganM::getRuanganByInstalasiST($modSterilisasiDetail->instalasi_id), 'ruangan_id', 'ruangan_nama');

    if (!empty($penyimpanansteril_id)) {
      $modPenyimpananSterilisasi = STPenyimpanansterilT::model()->findByPk($penyimpanansteril_id);
      $modPenyimpananSterilisasi->pegpenyimpanan_nama = !empty($modPenyimpananSterilisasi->pegpenyimpanan->NamaLengkap) ? $modPenyimpananSterilisasi->pegpenyimpanan->NamaLengkap : "";
      $modPenyimpananSterilisasi->pegmengetahui_nama = !empty($modPenyimpananSterilisasi->pegmengetahui->NamaLengkap) ? $modPenyimpananSterilisasi->pegmengetahui->NamaLengkap : "";
      $criteria = new CDbCriteria();
      $criteria->addCondition('penyimpanansteril_id = ' . $penyimpanansteril_id);
      $criteria->select = 'DISTINCT sterilisasi_t.*,penerimaansterilisasi_t.*,peralatansterilisasi_m.*,ruangan_m.*,instalasi_m.*';
      $criteria->join = 'JOIN sterilisasi_t ON sterilisasi_t.sterilisasi_id = t.sterilisasi_id'
        . ' JOIN sterilisasidetail_t ON sterilisasidetail_t.sterilisasi_id = sterilisasi_t.sterilisasi_id'
        . ' JOIN penerimaansterilisasi_t ON penerimaansterilisasi_t.penerimaansterilisasi_id = sterilisasidetail_t.penerimaansterilisasi_id'
        . ' JOIN peralatansterilisasi_m ON peralatansterilisasi_m.peralatansterilisasi_id = sterilisasidetail_t.peralatansterilisasi_id'
        . ' JOIN ruangan_m ON ruangan_m.ruangan_id=penerimaansterilisasi_t.ruangan_id'
        . ' JOIN instalasi_m ON instalasi_m.instalasi_id=ruangan_m.instalasi_id ';

      $modPenyimpananSterilisasiDetail = STPenyimpanansterildetT::model()->findAll($criteria);
    }

    if (!empty($sterilisasi_id)) {
      $criteria = new CDbCriteria();
      $criteria->select = 'penerimaansterilisasi_t.*,sterilisasi_t.*,t.*,peralatansterilisasi_m.*,ruangan_m.*,instalasi_m.*';
      $criteria->addCondition('sterilisasi_t.sterilisasi_id = ' . $sterilisasi_id);
      $criteria->join = 'JOIN sterilisasi_t ON sterilisasi_t.sterilisasi_id = t.sterilisasi_id'
        . ' LEFT JOIN penerimaansterilisasi_t ON penerimaansterilisasi_t.penerimaansterilisasi_id = t.penerimaansterilisasi_id'
        . ' LEFT JOIN peralatansterilisasi_m ON peralatansterilisasi_m.peralatansterilisasi_id = t.peralatansterilisasi_id'
        . ' LEFT JOIN ruangan_m ON ruangan_m.ruangan_id=penerimaansterilisasi_t.ruangan_id'
        . ' LEFT JOIN instalasi_m ON instalasi_m.instalasi_id=ruangan_m.instalasi_id '
        . ' left join penyimpanansterildet_t simpandet on simpandet.sterilisasidetail_id = t.sterilisasidetail_id';


      $criteria->addCondition("simpandet.sterilisasidetail_id is null");

      $modSterilisasi = STSterilisasidetailT::model()->findAll($criteria);
    }

    if (isset($_POST['STPenyimpanansterilT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPenyimpananSterilisasi->attributes = $_POST['STPenyimpanansterilT'];
        $modPenyimpananSterilisasi->penyimpanansteril_no = MyGenerator::noPenyimpananSteril();
        $modPenyimpananSterilisasi->penyimpanansteril_tgl = $format->formatDateTimeForDb($_POST['STPenyimpanansterilT']['penyimpanansteril_tgl']);
        $modPenyimpananSterilisasi->create_time = date('Y-m-d H:i:s');
        $modPenyimpananSterilisasi->create_loginpemakai_id = Yii::app()->user->id;
        $modPenyimpananSterilisasi->create_ruangan = Yii::app()->user->ruangan_id;

        if ($modPenyimpananSterilisasi->save()) {
          $this->penyimpanansterilisasitersimpan = true;
          if (isset($_POST['STPenyimpanansterildetT'])) {
            if (count((array)$_POST['STPenyimpanansterildetT']) > 0) {
              foreach ($_POST['STPenyimpanansterildetT'] as $i => $detail) {
                if ($detail['checklist'] == 1) {
                  $modPenyimpananSterilisasiDetail[$i] = $this->simpanPenyimpananSterilisasiDetail($modPenyimpananSterilisasi, $detail);
                }
              }
            }
          }
        } else {
          $this->penyimpanansterilisasitersimpan = false;
        }
        if ($this->penyimpanansterilisasitersimpan && $this->penyimpanansterilisasidetailtersimpan) {
          $transaction->commit();
          Yii::app()->user->setFlash("success", "Data Penyimpanan Sterilisasi " . $modPenyimpananSterilisasi->penyimpanansteril_no . " berhasil disimpan!");
          $modPenyimpananSterilisasi->isNewRecord = FALSE;
          $this->redirect(array('index', 'penyimpanansteril_id' => $modPenyimpananSterilisasi->penyimpanansteril_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Penyimpanan Sterilisasi gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Penyimpanan Sterilisasi gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'modSterilisasi' => $modSterilisasi,
      'modSterilisasiDetail' => $modSterilisasiDetail,
      'modPenyimpananSterilisasi' => $modPenyimpananSterilisasi,
      'modPenyimpananSterilisasiDetail' => $modPenyimpananSterilisasiDetail,
      'modPenyimpananSterilisasiBahan' => $modPenyimpananSterilisasiBahan,
      'instalasiTujuans' => $instalasiTujuans,
      'ruanganTujuans' => $ruanganTujuans,
    ));
  }

  /**
   * simpan STPenyimpanansterildetT
   * @param type $modPenyimpananSterilisasiDetail
   * @param type $detail
   * @return \STPenyimpanansterildetT
   */
  public function simpanPenyimpananSterilisasiDetail($modPenyimpananSterilisasi, $detail)
  {
    $format = new MyFormatter();
    $modPenyimpananSterilisasiDetail = new STPenyimpanansterildetT;
    $modPenyimpananSterilisasiDetail->attributes = $detail;
    $modPenyimpananSterilisasiDetail->penyimpanansteril_id = $modPenyimpananSterilisasi->penyimpanansteril_id;

    if ($modPenyimpananSterilisasiDetail->validate()) {
      $modPenyimpananSterilisasiDetail->save();
      $this->penyimpanansterilisasidetailtersimpan &= true;
    } else {
      $this->penyimpanansterilisasidetailtersimpan &= false;
    }
    return $modPenyimpananSterilisasiDetail;
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(STRuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionAutocompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = STPegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionPencarianPenerimaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      parse_str($_REQUEST['data'], $data_parsing);
      $form = "";
      $pesan = "";
      $modPenyimpananSterilisasidetail = '';
      $format = new MyFormatter();

      if (isset($data_parsing['STSterilisasidetailT'])) {
        $tgl_awal = isset($data_parsing['STSterilisasidetailT']['tgl_awal']) ? $format->formatDateTimeForDb($data_parsing['STSterilisasidetailT']['tgl_awal']) : null;
        $tgl_akhir = isset($data_parsing['STSterilisasidetailT']['tgl_akhir']) ? $format->formatDateTimeForDb($data_parsing['STSterilisasidetailT']['tgl_akhir']) : null;
        $sterilisasi_no = isset($data_parsing['STSterilisasidetailT']['sterilisasi_no']) ? $data_parsing['STSterilisasidetailT']['sterilisasi_no'] : "";
        $instalasi_id = isset($data_parsing['STSterilisasidetailT']['instalasi_id']) ? $data_parsing['STSterilisasidetailT']['instalasi_id'] : null;
        $ruangan_id = isset($data_parsing['STSterilisasidetailT']['ruangan_id']) ? $data_parsing['STSterilisasidetailT']['ruangan_id'] : null;

        $criteria = new CDbCriteria();
        $criteria->select = 'penerimaansterilisasi_t.*,sterilisasi_t.*,t.*,peralatansterilisasi_m.*,ruangan_m.*,instalasi_m.*';
        $criteria->addBetweenCondition('DATE(sterilisasi_t.sterilisasi_tgl)', $tgl_awal, $tgl_akhir, true);
        if (isset($sterilisasi_no)) {
          $criteria->compare('LOWER(sterilisasi_t.sterilisasi_no)', strtolower($sterilisasi_no), true);
        }
        if (!empty($ruangan_id)) {
          $ruangan_id = $ruangan_id;
        } else {
          $ruangan_id = Yii::app()->user->getState('ruangan_id');
        }
        $criteria->addCondition('penerimaansterilisasi_t.ruangan_id = ' . $ruangan_id);
        $criteria->join = 'JOIN sterilisasi_t ON sterilisasi_t.sterilisasi_id = t.sterilisasi_id'
          . ' LEFT JOIN penerimaansterilisasi_t ON penerimaansterilisasi_t.penerimaansterilisasi_id = t.penerimaansterilisasi_id'
          . ' LEFT JOIN peralatansterilisasi_m ON peralatansterilisasi_m.peralatansterilisasi_id = t.peralatansterilisasi_id'
          . ' LEFT JOIN ruangan_m ON ruangan_m.ruangan_id=penerimaansterilisasi_t.ruangan_id'
          . ' LEFT JOIN instalasi_m ON instalasi_m.instalasi_id=ruangan_m.instalasi_id ';

        //				RSSP-3086
        //				$criteria->addCondition("t.sterilisasi_id NOT IN (SELECT sterilisasi_id FROM penyimpanansterildet_t)");

        $modSterilisasi = STSterilisasidetailT::model()->findAll($criteria);
        if (count((array)$modSterilisasi) > 0) {
          foreach ($modSterilisasi as $i => $penerimaan) {
            $modPenyimpananSterilisasidetail = new STPenyimpanansterildetT;
            $peralatan = PeralatansterilisasiM::model()->findByPk($penerimaan->peralatansterilisasi_id);
            $modPenyimpananSterilisasidetail->sterilisasi_id = isset($penerimaan->sterilisasi_id) ? $penerimaan->sterilisasi_id : '';
            $modPenyimpananSterilisasidetail->instalasi_nama = isset($penerimaan->instalasi_nama) ? $penerimaan->instalasi_nama : '';
            $modPenyimpananSterilisasidetail->ruangan_nama = isset($penerimaan->ruangan_nama) ? $penerimaan->ruangan_nama : '';
            $modPenyimpananSterilisasidetail->peralatansterilisasi_id = isset($penerimaan->peralatansterilisasi_id) ? $penerimaan->peralatansterilisasi_id : '';
            $modPenyimpananSterilisasidetail->peralatansterilisasi_nama = isset($penerimaan->peralatansterilisasi_id) ? $peralatan->peralatansterilisasi_nama : '';
            $modPenyimpananSterilisasidetail->sterilisasi_no = isset($penerimaan->sterilisasi->sterilisasi_no) ? $penerimaan->sterilisasi->sterilisasi_no : '';
            $modPenyimpananSterilisasidetail->penyimpanansterildet_jml = isset($penerimaan->sterilisasidetail_jml) ? $penerimaan->sterilisasidetail_jml : '';
            $modPenyimpananSterilisasidetail->penyimpanansterildet_ket = isset($penerimaan->sterilisasidetail_ket) ? $penerimaan->sterilisasidetail_ket : '';
            $modPenyimpananSterilisasidetail->sterilisasidetail_id = isset($penerimaan->sterilisasidetail_id) ? $penerimaan->sterilisasidetail_id : '';
            $modPenyimpananSterilisasidetail->waktukadaluarsa = isset($penerimaan->waktukadaluarsa) ? $penerimaan->waktukadaluarsa : '';
            $modPenyimpananSterilisasidetail->checklist = 1;
            $form .= $this->renderPartial($this->path_view . '_rowPenerimaanSterilisasi', array('penerimaan' => $modPenyimpananSterilisasidetail), true);
          }
        } else {
          $pesan = "Data Sterilisasi tidak ada!";
        }
      }


      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  /**
   * untuk print data perawatan linen
   */
  public function actionPrint($penyimpanansteril_id, $caraprint = null)
  {
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    } else if ($caraprint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }
    $format = new MyFormatter;
    $modPenyimpananSterilisasi = STPenyimpanansterilT::model()->findByPk($penyimpanansteril_id);
    $criteria = new CDbCriteria();
    $criteria->addCondition('penyimpanansteril_id = ' . $penyimpanansteril_id);
    $modPenyimpananSterilisasiDetail = STPenyimpanansterildetT::model()->findAll($criteria);

    $judul_print = 'Penyimpanan Sterilisasi';

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPenyimpananSterilisasi' => $modPenyimpananSterilisasi,
      'modPenyimpananSterilisasiDetail' => $modPenyimpananSterilisasiDetail,
      'caraprint' => $caraprint
    ));
  }
}
