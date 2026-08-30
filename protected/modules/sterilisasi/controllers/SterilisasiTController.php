<?php
class SterilisasiTController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'sterilisasi.views.sterilisasiT.';
  public $sterilisasitersimpan = false;
  public $sterilisasidetailtersimpan = true;
  public $sterilisasibahantersimpan = true;

  public function actionIndex($sterilisasi_id = null, $pembersihan_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Sterilisasi";
    $format = new MyFormatter();
    $modPenerimaanSterilisasi = new STPenerimaansterilisasiT;
    $modPenerimaanSterilisasiDetail = new STPenerimaansterilisasidetT('searchPenerimaanSteriliasi');

    $modPenerimaansterilisasiV = new STPenerimaansterilisasiV();
    $modPenerimaansterilisasiV->tgl_awal = date('Y-m-d H:i:s');
    $modPenerimaansterilisasiV->tgl_akhir = date('Y-m-d H:i:s');
    $modPenerimaansterilisasiV->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $modPenerimaansterilisasiV->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPenerimaansterilisasiV->pembersihan_id = $pembersihan_id;

    $modSterilisasi = new STSterilisasiT;
    $modSterilisasi->sterilisasi_tgl = date('Y-m-d H:i:s');
    $modSterilisasi->sterilisasi_no = '-- Otomatis --';
    $modSterilisasiDetail = array();
    $modSterilisasiBahan = array();
    $instalasiTujuans = CHtml::listData(STInstalasiM::getInstalasiItems(), 'instalasi_id', 'instalasi_nama');
    $ruanganTujuans = CHtml::listData(STRuanganM::getRuanganByInstalasi($modPenerimaansterilisasiV->instalasi_id), 'ruangan_id', 'ruangan_nama');


    if (!empty($sterilisasi_id)) {
      $modSterilisasi = STSterilisasiT::model()->findByPk($sterilisasi_id);
      $modSterilisasi->pegsterilisasi_nama = !empty($modSterilisasi->pegsterilisasi->NamaLengkap) ? $modSterilisasi->pegsterilisasi->NamaLengkap : "";
      $modSterilisasi->pegmengetahui_nama = !empty($modSterilisasi->pegmengetahui->NamaLengkap) ? $modSterilisasi->pegmengetahui->NamaLengkap : "";
      $modSterilisasiDetail = STSterilisasidetailT::model()->findAllByAttributes(array('sterilisasi_id' => $modSterilisasi->sterilisasi_id));
    }

    if (!empty($pembersihan_id)) {
      $modPembersihan = PembersihanT::model()->findByPk($pembersihan_id);
      if (!empty($modPembersihan->dekontaminasi_id)) {
        $modDekontaminsasiDet = DekontaminasidetailT::model()->findByAttributes(array('dekontaminasi_id' => $modPembersihan->dekontaminasi_id));
        if (!empty($modDekontaminsasiDet->penerimaansterilisasi_id)) {
          $modPenerimaan = PenerimaansterilisasiT::model()->findByPk($modDekontaminsasiDet->penerimaansterilisasi_id);
          $modPenerimaansterilisasiV->penerimaansterilisasi_no = $modPenerimaan->penerimaansterilisasi_no;
          $modPenerimaansterilisasiV->instalasi_id = $modPenerimaan->ruangan->instalasi_id;
          $modPenerimaansterilisasiV->ruangan_id = $modPenerimaan->ruangan_id;
          $ruanganTujuans = CHtml::listData(STRuanganM::getRuanganByInstalasi($modPenerimaansterilisasiV->instalasi_id), 'ruangan_id', 'ruangan_nama');
        }
      }
    }

    if (isset($_POST['STSterilisasiT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modSterilisasi->attributes = $_POST['STSterilisasiT'];
        $modSterilisasi->sterilisasi_no = MyGenerator::noSterilisasi();
        $modSterilisasi->sterilisasi_tgl = $format->formatDateTimeForDb($_POST['STSterilisasiT']['sterilisasi_tgl']);
        $modSterilisasi->create_time = date('Y-m-d H:i:s');
        $modSterilisasi->create_loginpemakai_id = Yii::app()->user->id;
        $modSterilisasi->create_ruangan = Yii::app()->user->ruangan_id;

        if ($modSterilisasi->save()) {
          $this->sterilisasitersimpan = true;
          if (isset($_POST['STSterilisasidetailT'])) {
            if (count((array)$_POST['STSterilisasidetailT']) > 0) {
              foreach ($_POST['STSterilisasidetailT'] as $i => $detail) {
                if ($detail['checklist'] == 1) {
                  $modSterilisasiDetail[$i] = $this->simpanSterilisasiDetail($modSterilisasi, $detail);
                }
              }
            }
          }
        } else {
          $this->sterilisasitersimpan = false;
        }

        if ($this->sterilisasitersimpan && $this->sterilisasidetailtersimpan && $this->sterilisasibahantersimpan) {
          $transaction->commit();
          $modSterilisasi->isNewRecord = FALSE;
          Yii::app()->user->setFlash('success', "Data " . $modSterilisasi->sterilisasi_no . " Berhasil Disimpan");
          $this->redirect(array('index', 'sterilisasi_id' => $modSterilisasi->sterilisasi_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Sterilisasi gagal disimpan !");
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Sterilisasi gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'modPenerimaanSterilisasi' => $modPenerimaanSterilisasi,
      'modPenerimaanSterilisasiDetail' => $modPenerimaanSterilisasiDetail,
      'modSterilisasi' => $modSterilisasi,
      'modSterilisasiDetail' => $modSterilisasiDetail,
      'modSterilisasiBahan' => $modSterilisasiBahan,
      'instalasiTujuans' => $instalasiTujuans,
      'ruanganTujuans' => $ruanganTujuans,
      'modPenerimaansterilisasiV' => $modPenerimaansterilisasiV,
    ));
  }

  /**
   * simpan STSterilisasidetailT
   * @param type $modSterilisasiDetail
   * @param type $detail
   * @return \STSterilisasidetailT
   */
  public function simpanSterilisasiDetail($modSterilisasi, $detail)
  {
    $format = new MyFormatter();
    $modSterilisasiDetail = new STSterilisasidetailT;
    $modSterilisasiDetail->attributes = $detail;
    $modSterilisasiDetail->sterilisasi_id = $modSterilisasi->sterilisasi_id;
    //$modSterilisasiDetail->barang_id = $detail['barang_id'];
    $modSterilisasiDetail->peralatansterilisasi_id = $detail['peralatansterilisasi_id'];
    $modSterilisasiDetail->waktukadaluarsa = $format->formatDateTimeForDb($detail['waktukadaluarsa']);

    if ($modSterilisasiDetail->validate()) {
      $modSterilisasiDetail->save();
      $modPenerimaanSterilisasi = STPenerimaansterilisasiT::model()->findByPk($detail['penerimaansterilisasi_id']);
      $modPenerimaanSterilisasi->issterilisasi = TRUE;
      $modPenerimaanSterilisasi->update();
      if (isset($detail['bahansterilisasi_nama'])) {
        if (count((array)$detail['bahansterilisasi_nama']) > 0) {
          foreach ($detail['bahansterilisasi_nama'] as $j => $bahan) {
            $modSterilisasiBahan[$j] = $this->simpanSterilisasiBahan($modSterilisasiDetail, $bahan, $detail);
          }
        }
      }
      $this->sterilisasidetailtersimpan &= true;
    } else {
      $this->sterilisasidetailtersimpan &= false;
    }
    return $modSterilisasiDetail;
  }

  /**
   * simpan STSterilisasibahanT
   * @param type $modSterilisasiBahan
   * @param type $bahan
   * @return \STSterilisasibahanT
   */
  public function simpanSterilisasiBahan($modSterilisasiDetail, $bahan, $detail)
  {
    $format = new MyFormatter();
    $criteria = new CDbCriteria();
    $criteria->addCondition("bahansterilisasi_nama ='" . $bahan . "'");
    $modBahanSterilisasi = STBahansterilisasiM::model()->find($criteria);

    $modSterilisasiBahan = new STSterilisasibahanT;
    $modSterilisasiBahan->attributes = $bahan;
    $modSterilisasiBahan->sterilisasidetail_id = $modSterilisasiDetail->sterilisasidetail_id;
    $modSterilisasiBahan->bahansterilisasi_id = $modBahanSterilisasi->bahansterilisasi_id;
    $modSterilisasiBahan->jmlbahanygdigunakan = $detail['sterilisasidetail_jml'];
    $modSterilisasiBahan->satuanbahan = $modBahanSterilisasi->bahansterilisasi_satuan;

    if ($modSterilisasiBahan->validate()) {
      $modSterilisasiBahan->save();
      $this->sterilisasibahantersimpan &= true;
    } else {
      $this->sterilisasibahantersimpan &= false;
    }
    return $modSterilisasiBahan;
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
      //$criteria->compare('LOWER(barang_nama)', strtolower($_GET['term']), true);
      $criteria->compare('LOWER(peralatansterilisasi_nama)', strtolower($_GET['term']), true);
      $criteria->limit = 5;
      //$models = STBarangM::model()->findAll($criteria);
      $models = PeralatansterilisasiM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        /*$returnVal[$i]['label'] = $model->barang_type."-".$model->barang_kode."-".$model->barang_nama;
                $returnVal[$i]['namaBrg'] = $model->barang_nama;
				$returnVal[$i]['value'] = $model->barang_id;*/
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
      if (!empty($barang_nama)) {
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
      $criteria->addCondition("t.penerimaansterilisasi_id NOT IN (SELECT penerimaansterilisasi_id FROM sterilisasidetail_t)");

      $modPenerimaanSterilisasi = STPenerimaansterilisasidetT::model()->findAll($criteria);
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modSterilisasidetail = array();
      if (count((array)$modPenerimaanSterilisasi) > 0) {
        foreach ($modPenerimaanSterilisasi as $i => $penerimaan) {
          $modSterilisasidetail = new STSterilisasidetailT;
          $modSterilisasidetail->penerimaansterilisasi_id = $penerimaan->penerimaansterilisasi_id;
          $modSterilisasidetail->ruangan_id = $penerimaan->ruangan_id;
          $modSterilisasidetail->ruangan_nama = $penerimaan->ruangan_nama;
          //$modSterilisasidetail->barang_id = $penerimaan->barang_id;
          //$modSterilisasidetail->barang_nama = $penerimaan->barang_nama;
          $modSterilisasidetail->penerimaansterilisasi_tgl = $penerimaan->penerimaansterilisasi->penerimaansterilisasi_tgl;
          $modSterilisasidetail->penerimaansterilisasi_no = $penerimaan->penerimaansterilisasi->penerimaansterilisasi_no;
          $modSterilisasidetail->sterilisasidetail_jml = $penerimaan->penerimaansterilisasidet_jml;
          $modSterilisasidetail->kemasanygdigunakan = $penerimaan->barang->barang_satuan;
          $modSterilisasidetail->waktukadaluarsa = '';
          $modSterilisasidetail->checklist = 1;
          $modSterilisasidetail->pengajuansterlilisasi_id = $penerimaan->pengajuansterlilisasi_id;
          $form .= $this->renderPartial($this->path_view . '_rowPenerimaanSterilisasi', array('penerimaan' => $modSterilisasidetail), true);
        }
      } else {
        $pesan = "Data Penerimaan tidak ada!";
      }
      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  public function actionPencarianPenerimaanView()
  {
    if (Yii::app()->request->isAjaxRequest) {
      parse_str($_REQUEST['data'], $data_parsing);
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      if (isset($data_parsing['STPenerimaansterilisasiV'])) {
        $tgl_awal = $format->formatDateTimeForDb($data_parsing['STPenerimaansterilisasiV']['tgl_awal']);
        $tgl_akhir = $format->formatDateTimeForDb($data_parsing['STPenerimaansterilisasiV']['tgl_akhir']);
        $penerimaansterilisasi_no = $data_parsing['STPenerimaansterilisasiV']['penerimaansterilisasi_no'];
        //$barang_id = $data_parsing['STPenerimaansterilisasiV']['barang_id'];
        $peralatansterilisasi_id = $data_parsing['STPenerimaansterilisasiV']['peralatansterilisasi_id'];
        //$barang_nama = $data_parsing['STPenerimaansterilisasiV']['barang_nama'];
        $instalasi_id = $data_parsing['STPenerimaansterilisasiV']['instalasi_id'];
        $ruangan_id = $data_parsing['STPenerimaansterilisasiV']['ruangan_id'];
        $pembersihan_id = $data_parsing['STPenerimaansterilisasiV']['pembersihan_id'];
      }
      $criteria = new CDbCriteria();
      if (!empty($pembersihan_id)) {
        $criteria->compare('b.pembersihan_id', $pembersihan_id);
      } else {
        $criteria->addBetweenCondition('DATE(t.penerimaansterilisasi_tgl)', $tgl_awal, $tgl_akhir, true);
      }
      if (!empty($penerimaansterilisasi_no)) {
        $criteria->compare('LOWER(t.penerimaansterilisasi_no)', strtolower($penerimaansterilisasi_no), true);
      }/*
			if(!empty($barang_id)){
				$criteria->addCondition('barang_id = '.$barang_id);
			}
			if(!empty($barang_nama)){
				$criteria->compare('LOWER(barang_nama)',strtolower($barang_nama),true);
			}*/
      if (!empty($peralatansterilisasi_id)) {
        $criteria->addCondition('t.peralatansterilisasi_id = ' . $peralatansterilisasi_id);
      }
      /*if(!empty($instalasi_id)){
				$criteria->addCondition('instalasi_id = '.$instalasi_id);
			}*/
      if (!empty($ruangan_id)) {
        $criteria->addCondition('t.ruangan_id = ' . $ruangan_id);
      }
      $criteria->addCondition("t.keadaanperalatan = 'BERSIH'");
      $criteria->addCondition("t.isdekontaminasi is true and sd.penerimaansterilisasi_id is null");
      $criteria->select = "t.*, d.dekontaminasi_id";
      //			$criteria->addCondition("penerimaansterilisasi_id NOT IN (SELECT penerimaansterilisasi_id FROM sterilisasidetail_t)");  //di coment karena kondisi tidak di perlukan
      $criteria->join = 'join dekontaminasidetail_t dd on dd.penerimaansterilisasidet_id = t.penerimaansterilisasidet_id '
        . 'join dekontaminasi_t d on d.dekontaminasi_id = dd.dekontaminasi_id '
        . 'join pembersihan_t b on b.dekontaminasi_id = d.dekontaminasi_id '
        . 'join (select count(inspeksiinstrumen_id) as inspeksi_total, pembersihan_id from inspeksiinstrumen_t group by pembersihan_id) i on i.pembersihan_id = b.pembersihan_id '
        . 'left join sterilisasidetail_t sd on sd.penerimaansterilisasi_id = t.penerimaansterilisasi_id';

      $modPenerimaanSterilisasi = STPenerimaansterilisasiV::model()->findAll($criteria);
      //$modPenerimaanSterilisasi = STPenerimaansterilisasiV::model()->findAll();
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modSterilisasidetail = array();
      if (count((array)$modPenerimaanSterilisasi) > 0) {
        foreach ($modPenerimaanSterilisasi as $i => $penerimaan) {
          //$modBrg = BarangM::model()->findByPk($penerimaan->barang_id);
          $modSterilisasidetail = new STSterilisasidetailT;
          $modSterilisasidetail->penerimaansterilisasi_id = $penerimaan->penerimaansterilisasi_id;
          $modSterilisasidetail->ruangan_id = $penerimaan->ruangan_id;
          $modSterilisasidetail->ruangan_nama = $penerimaan->ruangan_nama;
          $modSterilisasidetail->keadaanperalatan = $penerimaan->keadaanperalatan;
          $modSterilisasidetail->dekontaminasi_id = $penerimaan->dekontaminasi_id;
          //$modSterilisasidetail->barang_id = $penerimaan->barang_id;
          //$modSterilisasidetail->barang_nama = $penerimaan->barang_nama;
          //$modSterilisasidetail->barang_id = $penerimaan->peralatansterilisasi_id;
          $modSterilisasidetail->peralatansterilisasi_id = $penerimaan->peralatansterilisasi_id;
          $modSterilisasidetail->penerimaansterilisasi_tgl = $penerimaan->penerimaansterilisasi_tgl;
          $modSterilisasidetail->penerimaansterilisasi_no = $penerimaan->penerimaansterilisasi_no;
          $modSterilisasidetail->sterilisasidetail_jml = $penerimaan->penerimaansterilisasidet_jml;
          //$modSterilisasidetail->kemasanygdigunakan = $modBrg->barang_satuan;
          $modSterilisasidetail->waktukadaluarsa = '';
          $modSterilisasidetail->checklist = 1;
          $modSterilisasidetail->pengajuansterlilisasi_id = $penerimaan->pengajuansterlilisasi_id;
          $form .= $this->renderPartial($this->path_view . '_rowPenerimaanSterilisasi', array('penerimaan' => $modSterilisasidetail), true);
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
  public function actionPrint($sterilisasi_id, $caraprint = null)
  {
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    } else if ($caraprint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }
    $format = new MyFormatter;
    $modSterilisasi = STSterilisasiT::model()->findByPk($sterilisasi_id);
    $modSterilisasiDetail = STSterilisasidetailT::model()->findAllByAttributes(array('sterilisasi_id' => $sterilisasi_id));

    $judul_print = 'Sterilisasi';

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modSterilisasi' => $modSterilisasi,
      'modSterilisasiDetail' => $modSterilisasiDetail,
      'caraprint' => $caraprint
    ));
  }
}
