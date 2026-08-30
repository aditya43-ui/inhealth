<?php

/**
 * @package application.modules.sterilisasi
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id> 
 */
class DekontaminasiTController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'sterilisasi.views.dekontaminasiT.';
  public $dekontaminasitersimpan = false;
  public $dekontaminasidetailtersimpan = true;
  public $dekontaminasibahantersimpan = true;

  /**
   * action utama dekontaminasi
   * @param type $dekontaminasi_id
   * @param type $penerimaansterilisasi_id
   */
  public function actionIndex($dekontaminasi_id = null, $penerimaansterilisasi_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Dekontaminasi";
    $format = new MyFormatter();

    $modPenerimaanSterilisasi = new STPenerimaansterilisasiT;
    $modPenerimaanSterilisasiDetail = new STPenerimaansterilisasidetT('searchPenerimaanSteriliasi');
    $modPenerimaanSterilisasiDetail->tgl_awal = date('Y-m-d');
    $modPenerimaanSterilisasiDetail->tgl_akhir = date('Y-m-d');
    $modPenerimaanSterilisasiDetail->instalasi_id = Yii::app()->user->getState('instalasi_id');

    if (!empty($penerimaansterilisasi_id)) {
      $modPenerimaanSterilisasi = STPenerimaansterilisasiT::model()->findByPk($penerimaansterilisasi_id);
      $modPenerimaanSterilisasiDetail->penerimaansterilisasi_no = $modPenerimaanSterilisasi->penerimaansterilisasi_no;
      $modPenerimaanSterilisasiDetail->tgl_awal = $modPenerimaanSterilisasi->penerimaansterilisasi_tgl;
      $modPenerimaanSterilisasiDetail->tgl_akhir = $modPenerimaanSterilisasi->penerimaansterilisasi_tgl;
      $modPenerimaanSterilisasiDetail->instalasi_id = $modPenerimaanSterilisasi->ruangan->instalasi_id;
      $modPenerimaanSterilisasiDetail->ruangan_id = $modPenerimaanSterilisasi->ruangan_id;

      //proses update kolom barang_id jika masih null
      $modDetailPenerimaan = STPenerimaansterilisasidetT::model()->findAllByAttributes(array('penerimaansterilisasi_id' => $penerimaansterilisasi_id, 'barang_id' => null));
      if (!empty($modDetailPenerimaan)) {
        foreach ($modDetailPenerimaan as $key => $val) {
          $mapBarang = MapbarangsterilisasiM::model()->findByAttributes(array('peralatansterilisasi_id' => $val->peralatansterilisasi_id));
          if (!empty($mapBarang)) {
            $barang_id = $mapBarang->barang_id;
          }
          $mapLinen = MaplinensterilisasiM::model()->findByAttributes(array('peralatansterilisasi_id' => $val->peralatansterilisasi_id));
          if (!empty($mapLinen)) {
            $barang_id = $mapLinen->linen_id;
          }
          $mapAlkes = MapalkessterilisasiM::model()->findByAttributes(array('peralatansterilisasi_id' => $val->peralatansterilisasi_id));
          if (!empty($mapAlkes)) {
            $barang_id = $mapAlkes->obatalkes_id;
          }
          STPenerimaansterilisasidetT::model()->updateByPk($val->penerimaansterilisasidet_id, array('barang_id' => $barang_id));
        }
      }
    }




    $modDekontaminasi = new STDekontaminasiT;
    $modDekontaminasi->dekontaminasi_tgl = date('Y-m-d H:i:s');
    $modDekontaminasi->dekontaminasi_no = '-- Otomatis --';
    $modDekontaminasiDetail = array();
    $modDekontaminasiBahan = array();
    $instalasiTujuans = CHtml::listData(STInstalasiM::getInstalasiItems(), 'instalasi_id', 'instalasi_nama');
    $ruanganTujuans = CHtml::listData(STRuanganM::getRuanganByInstalasi($modPenerimaanSterilisasiDetail->instalasi_id), 'ruangan_id', 'ruangan_nama');

    if (!empty($dekontaminasi_id)) {
      $modDekontaminasi = STDekontaminasiT::model()->findByPk($dekontaminasi_id);
      $modDekontaminasi->pegpetugas_nama = !empty($modDekontaminasi->pegpetugas->NamaLengkap) ? $modDekontaminasi->pegpetugas->NamaLengkap : "";
      $modDekontaminasi->pegmengetahui_nama = !empty($modDekontaminasi->pegmengetahui->NamaLengkap) ? $modDekontaminasi->pegmengetahui->NamaLengkap : "";
      $modDekontaminasiDetail = STDekontaminasidetailT::model()->findAllByAttributes(array('dekontaminasi_id' => $modDekontaminasi->dekontaminasi_id));
    }

    if (isset($_POST['STDekontaminasiT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modDekontaminasi->attributes = $_POST['STDekontaminasiT'];
        $modDekontaminasi->dekontaminasi_no = MyGenerator::noDekontaminasi();
        $modDekontaminasi->dekontaminasi_tgl = $format->formatDateTimeForDb($_POST['STDekontaminasiT']['dekontaminasi_tgl']);
        $modDekontaminasi->create_time = date('Y-m-d H:i:s');
        $modDekontaminasi->create_loginpemakai_id = Yii::app()->user->id;
        $modDekontaminasi->create_ruangan = Yii::app()->user->ruangan_id;


        //				$modDekontaminasi->validate(); 
        //echo CHtml::errorSummary($modDekontaminasi); exit();
        if ($modDekontaminasi->save()) {
          $this->dekontaminasitersimpan = true;
          if (isset($_POST['STDekontaminasidetailT'])) {

            if (count((array)$_POST['STDekontaminasidetailT']) > 0) {
              foreach ($_POST['STDekontaminasidetailT'] as $i => $detail) {
                if ($detail['checklist'] == 1) {
                  $modDekontaminasiDetail[$i] = $this->simpanDekontaminasiDetail($modDekontaminasi, $detail);
                }
              }
            }
          }
        } else {
          $this->dekontaminasitersimpan = false;
        }
        //                                echo $this->dekontaminasitersimpan.'<br>'. $this->dekontaminasidetailtersimpan."<br>". $this->dekontaminasibahantersimpan; exit();
        if ($this->dekontaminasitersimpan && $this->dekontaminasidetailtersimpan && $this->dekontaminasibahantersimpan) {
          $transaction->commit();
          Yii::app()->user->setFlash("success", "Data Dekontaminasi " . $modDekontaminasi->dekontaminasi_no . " berhasil disimpan!");
          $modDekontaminasi->isNewRecord = FALSE;
          $this->redirect(array('index', 'dekontaminasi_id' => $modDekontaminasi->dekontaminasi_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Dekontaminasi gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Dekontaminasi gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'modPenerimaanSterilisasi' => $modPenerimaanSterilisasi,
      'modPenerimaanSterilisasiDetail' => $modPenerimaanSterilisasiDetail,
      'modDekontaminasi' => $modDekontaminasi,
      'modDekontaminasiDetail' => $modDekontaminasiDetail,
      'modDekontaminasiBahan' => $modDekontaminasiBahan,
      'instalasiTujuans' => $instalasiTujuans,
      'ruanganTujuans' => $ruanganTujuans,
    ));
  }

  /**
   * simpan STDekontaminasidetailT
   * @param type $modDekontaminasiDetail
   * @param type $detail
   * @return \STDekontaminasidetailT
   */
  public function simpanDekontaminasiDetail($modDekontaminasi, $detail)
  {
    $format = new MyFormatter();
    $modDekontaminasiDetail = new STDekontaminasidetailT;
    $modDekontaminasiDetail->attributes = $detail;
    $modDekontaminasiDetail->dekontaminasi_id = $modDekontaminasi->dekontaminasi_id;

    $modPenerimaansterilisasidetT = PenerimaansterilisasidetT::model()->findByAttributes(array('penerimaansterilisasidet_id' => $detail['penerimaansterilisasidet_id']));
    $modPeralatansterilisasiM = PeralatansterilisasiM::model()->findByAttributes(array('peralatansterilisasi_id' => $modPenerimaansterilisasidetT->peralatansterilisasi_id));
    $barang_id = null;

    if (isset($modPeralatansterilisasiM->jenisperalatan)) {
      if ($modPeralatansterilisasiM->jenisperalatan == Params::JENIS_PERALATAN_LINEN) {
        $modLinenM = LinenM::model()->findByAttributes(array('linen_id' => $modPenerimaansterilisasidetT->barang_id));
        if (isset($modLinenM)) {
          $barang_id = $modLinenM->linen_id;
        } else {
          $map = MaplinensterilisasiM::model()->findByAttributes(array(
            'peralatansterilisasi_id' => $modPeralatansterilisasiM->peralatansterilisasi_id,
          ));

          if (!empty($map)) {
            $barang_id = $map->linen_id;
          }
        }
      } else if ($modPeralatansterilisasiM->jenisperalatan == Params::JENIS_PERALATAN_BARANG) {
        $modBarangM = BarangM::model()->findByAttributes(array('barang_id' => $modPenerimaansterilisasidetT->barang_id));
        if (isset($modBarangM)) {
          $barang_id = $modBarangM->barang_id;
        } else {
          $map = MapbarangsterilisasiM::model()->findByAttributes(array(
            'peralatansterilisasi_id' => $modPeralatansterilisasiM->peralatansterilisasi_id,
          ));

          if (!empty($map)) {
            $barang_id = $map->barang_id;
          }
        }
      } else if ($modPeralatansterilisasiM->jenisperalatan == Params::JENIS_PERALATAN_ALATMEDIS) {
        $modObatalkesM = ObatalkesM::model()->findByAttributes(array('obatalkes_id' => $modPenerimaansterilisasidetT->barang_id));
        if (isset($modObatalkesM)) {
          $barang_id = $modObatalkesM->obatalkes_id;
        } else {
          $map = MapalkessterilisasiM::model()->findByAttributes(array(
            'peralatansterilisasi_id' => $modPeralatansterilisasiM->peralatansterilisasi_id,
          ));

          if (!empty($map)) {
            $barang_id = $map->obatalkes_id;
          }
        }
      }
    }
    $modDekontaminasiDetail->barang_id = $barang_id;



    //	var_dump($modDekontaminasiDetail->peralatansterilisasi_id); die();			
    //        $modDekontaminasiDetail->validate(); 
    //echo CHtml::errorSummary($modDekontaminasiDetail); exit();



    if ($modDekontaminasiDetail->validate()) {
      $modDekontaminasiDetail->save();
      $modPenerimaanSterilisasi = STPenerimaansterilisasiT::model()->findByPk($detail['penerimaansterilisasi_id']);
      $modPenerimaanSterilisasi->isdekontaminasi = TRUE;
      $modPenerimaanSterilisasi->update();
      $modPenerimaanSterilisasiDetail = STPenerimaansterilisasidetT::model()->findByPk($detail['penerimaansterilisasidet_id']);
      // $modPenerimaanSterilisasiDetail->keadaanperalatan = 'BERSIH';
      $modPenerimaanSterilisasiDetail->update();
      if (isset($detail['bahansterilisasi_nama'])) {
        if (count((array)$detail['bahansterilisasi_nama']) > 0) {

          foreach ($detail['bahansterilisasi_nama'] as $j => $bahan) {
            $modDekontaminasiBahan[$j] = $this->simpanDekontaminasiBahan($modDekontaminasiDetail, $bahan, $detail);
          }
        }
      }
      $this->dekontaminasidetailtersimpan &= true;
    } else {
      $this->dekontaminasidetailtersimpan &= false;
    }
    return $modDekontaminasiDetail;
  }

  /**
   * simpan STDekontaminasibahanT
   * @param type $modDekontaminasiBahan
   * @param type $bahan
   * @return \STDekontaminasibahanT
   */
  public function simpanDekontaminasiBahan($modDekontaminasiDetail, $bahan, $detail)
  {
    $format = new MyFormatter();
    $criteria = new CDbCriteria();
    $criteria->addCondition("bahansterilisasi_nama ='" . $bahan . "'");
    $modBahanSterilisasi = STBahansterilisasiM::model()->find($criteria);


    $modDekontaminasiBahan = new STDekontaminasibahanT;
    $modDekontaminasiBahan->attributes = $bahan;
    $modDekontaminasiBahan->dekontaminasidetail_id = $modDekontaminasiDetail->dekontaminasidetail_id;
    $modDekontaminasiBahan->bahansterilisasi_id = $modBahanSterilisasi->bahansterilisasi_id;
    $modDekontaminasiBahan->jmlpemakaianbahan = $detail['dekontaminasidetail_jml'];
    $modDekontaminasiBahan->satuanpemakainbahan = $modBahanSterilisasi->bahansterilisasi_satuan;

    if ($modDekontaminasiBahan->validate()) {
      $modDekontaminasiBahan->save();
      $this->dekontaminasibahantersimpan &= true;
    } else {
      $this->dekontaminasibahantersimpan &= false;
    }
    return $modDekontaminasiBahan;
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
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompletePeralatan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(peralatansterilisasi_nama)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      $models = PeralatansterilisasiM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->peralatansterilisasi_nama;
        $returnVal[$i]['value'] = $model->peralatansterilisasi_id;
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
      $format = new MyFormatter();

      if (isset($data_parsing['STPenerimaansterilisasidetT'])) {
        $tgl_awal = $format->formatDateTimeForDb($data_parsing['STPenerimaansterilisasidetT']['tgl_awal']);
        $tgl_akhir = $format->formatDateTimeForDb($data_parsing['STPenerimaansterilisasidetT']['tgl_akhir']);
        $penerimaansterilisasi_no = $data_parsing['STPenerimaansterilisasidetT']['penerimaansterilisasi_no'];
        $peralatansterilisasi_id = $data_parsing['STPenerimaansterilisasidetT']['peralatansterilisasi_id'];
        $peralatansterilisasi_nama = $data_parsing['STPenerimaansterilisasidetT']['peralatansterilisasi_nama'];
        $instalasi_id = $data_parsing['STPenerimaansterilisasidetT']['instalasi_id'];
        $ruangan_id = $data_parsing['STPenerimaansterilisasidetT']['ruangan_id'];
      }
      $criteria = new CDbCriteria();
      $criteria->select = 'penerimaansterilisasi_t.*,t.*,peralatansterilisasi_m.*,ruangan_m.*,instalasi_m.*';
      $criteria->addBetweenCondition('DATE(penerimaansterilisasi_t.penerimaansterilisasi_tgl)', $tgl_awal, $tgl_akhir, true);
      if (!empty($penerimaansterilisasi_no)) {
        $criteria->compare('LOWER(penerimaansterilisasi_t.penerimaansterilisasi_no)', strtolower($penerimaansterilisasi_no), true);
      }
      if (!empty($peralatansterilisasi_id)) {
        $criteria->addCondition('t.peralatansterilisasi_id = ' . $peralatansterilisasi_id);
      }
      if (!empty($peralatansterilisasi_nama)) {
        $criteria->compare('LOWER(peralatansterilisasi_m.peralatansterilisasi_nama)', strtolower($peralatansterilisasi_nama), true);
      }
      if (!empty($instalasi_id)) {
        $criteria->addCondition('ruangan_m.instalasi_id = ' . $instalasi_id);
      }
      if (!empty($ruangan_id)) {
        $criteria->addCondition('ruangan_m.ruangan_id = ' . $ruangan_id);
      }
      $criteria->join = 'JOIN penerimaansterilisasi_t ON penerimaansterilisasi_t.penerimaansterilisasi_id = t.penerimaansterilisasi_id'
        . ' JOIN peralatansterilisasi_m ON peralatansterilisasi_m.peralatansterilisasi_id = t.peralatansterilisasi_id'
        . ' JOIN ruangan_m ON ruangan_m.ruangan_id=penerimaansterilisasi_t.ruangan_id '
        . ' JOIN instalasi_m ON instalasi_m.instalasi_id=ruangan_m.instalasi_id ';

      //			RSSP-3087
      $criteria->addCondition("t.penerimaansterilisasi_id NOT IN (SELECT penerimaansterilisasi_id FROM dekontaminasidetail_t)");
      //$criteria->addCondition("t.penerimaansterilisasidet_id NOT IN (SELECT penerimaansterilisasidet_id FROM dekontaminasidetail_t)");
      //$criteria->addCondition('penerimaansterilisasi_t.issterilisasi is not true');
      //$criteria->addCondition('penerimaansterilisasi_t.isdekontaminasi is not true');
      $modPenerimaanSterilisasi = STPenerimaansterilisasidetT::model()->findAll($criteria);
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modDekontaminasidetail = array();
      if (count((array)$modPenerimaanSterilisasi) > 0) {
        foreach ($modPenerimaanSterilisasi as $i => $penerimaan) {
          $modDekontaminasidetail = new STDekontaminasidetailT;
          $modDekontaminasidetail->penerimaansterilisasi_id = $penerimaan->penerimaansterilisasi_id;
          $modDekontaminasidetail->ruangan_id = $penerimaan->ruangan_id;
          $modDekontaminasidetail->ruangan_nama = $penerimaan->ruangan_nama;
          $modDekontaminasidetail->peralatansterilisasi_id = $penerimaan->peralatansterilisasi_id;
          //					$modDekontaminasidetail->barang_nama = $penerimaan->barang_nama;
          $modDekontaminasidetail->peralatansterilisasi_nama = (!empty($penerimaan->linen_id) ? $penerimaan->linen->namalinen : $penerimaan->peralatansterilisasi_nama);
          $modDekontaminasidetail->penerimaansterilisasi_tgl = $penerimaan->penerimaansterilisasi->penerimaansterilisasi_tgl;
          $modDekontaminasidetail->penerimaansterilisasi_no = $penerimaan->penerimaansterilisasi->penerimaansterilisasi_no;
          $modDekontaminasidetail->dekontaminasidetail_jml = $penerimaan->penerimaansterilisasidet_jml;
          $modDekontaminasidetail->dekontaminasidetail_ket = $penerimaan->penerimaansterilisasidet_ket;
          $modDekontaminasidetail->dekontaminasidetail_lama = '';
          $modDekontaminasidetail->checklist = 1;
          $modDekontaminasidetail->penerimaansterilisasidet_id = $penerimaan->penerimaansterilisasidet_id;
          $form .= $this->renderPartial($this->path_view . '_rowDetailDekontaminasi', array('penerimaan' => $modDekontaminasidetail), true);
        }
      } else {
        $pesan = "Data Penerimaan tidak ada!";
      }
      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  public function actionMasterBahanSterilisasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(bahansterilisasi_nama)', strtolower($_GET['tag']), true);
      $bahans = STBahansterilisasiM::model()->findAll($criteria);
      $data = array();
      foreach ($bahans as $i => $bahan) {
        $data[$i] = array(
          'key' => $bahan->bahansterilisasi_nama,
          'value' => $bahan->bahansterilisasi_nama
        );
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * untuk print data perawatan linen
   */
  public function actionPrint($dekontaminasi_id, $caraprint = null)
  {
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    } else if ($caraprint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }
    $format = new MyFormatter;
    $modDekontaminasi = STDekontaminasiT::model()->findByPk($dekontaminasi_id);
    $modDekontaminasiDetail = STDekontaminasidetailT::model()->findAllByAttributes(array('dekontaminasi_id' => $dekontaminasi_id));

    $judul_print = 'Dekontaminasi';

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modDekontaminasi' => $modDekontaminasi,
      'modDekontaminasiDetail' => $modDekontaminasiDetail,
      'caraprint' => $caraprint
    ));
  }
}
