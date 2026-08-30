<?php
class PertukaranShiftController extends MyAuthController
{
  protected $path_view = 'kepegawaian.views.pertukaranShift.';
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $pertukaranjadwaltersimpan = true;
  public $pertukaranjadwaldetailtersimpan = true;

  public function actionIndex($id = null)
  {
    $format = new MyFormatter();
    $model = new KPPertukaranjadwalT();
    $model->tglpermohonanpertukaran = date('Y-m-d');
    $model->no_permohonanpertukaran = '-- Otomatis --';
    $modDetail = new KPPertukaranjadwaldetT();
    $modDetail->tglpertukaranjadwal = date('d/m/Y');

    if (!empty($id)) {
      $model = KPPertukaranjadwalT::model()->findByPk($id);
      $model->ygmengajukan1_nama = isset($model->ygmengajukan1->NamaLengkap) ?  $model->ygmengajukan1->NamaLengkap : "";
      $model->ygmengajukan2_nama = isset($model->ygmengajukan2->NamaLengkap) ?  $model->ygmengajukan2->NamaLengkap : "";
      $model->ygmenyetujui1_nama = isset($model->ygmenyetujui1->NamaLengkap) ?  $model->ygmenyetujui1->NamaLengkap : "";
      $model->ygmenyetujui2_nama = isset($model->ygmenyetujui2->NamaLengkap) ?  $model->ygmenyetujui2->NamaLengkap : "";
      $model->ygmengetahui_nama = isset($model->ygmengetahui->NamaLengkap) ?  $model->ygmengetahui->NamaLengkap : "";
    }
    if (isset($_POST['KPPertukaranjadwalT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model = $this->simpanPertukaranShift($model, $_POST['KPPertukaranjadwalT']);
        if (count((array)$_POST['KPPertukaranjadwaldetT'])) {
          foreach ($_POST['KPPertukaranjadwaldetT'] as $i => $details) {
            $modDetails[$i] = $this->simpanPertukaranDetail($_POST['KPPertukaranjadwaldetT'], $details, $model);
          }
        }

        //var_dump($this->pertukaranjadwaldetailtersimpan);die;

        if ($this->pertukaranjadwaltersimpan && $this->pertukaranjadwaldetailtersimpan) {
          Yii::app()->user->setFlash('success', "Data Berhasil Disimpan !");
          $transaction->commit();
          $this->redirect(array('index', 'id' => $model->pertukaranjadwal_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan (err1) !");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }
    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model,
      'modDetail' => $modDetail
    ));
  }

  /**
   * proses simpan data pertukaran jadwal pegawai
   * @param type $model
   * @param type $post
   * @return type
   */
  public function simpanPertukaranShift($model, $post)
  {
    $format = new MyFormatter();
    $model = new KPPertukaranjadwalT();
    $model->attributes = $post;
    $model->no_permohonanpertukaran = MyGenerator::noPertukaranJadwal();
    $model->tglpermohonanpertukaran = $format->formatDateTimeForDb($post['tglpermohonanpertukaran']);
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if ($model->validate()) {
      $model->save();
      $this->pertukaranjadwaltersimpan = true;
    } else {
      $this->pertukaranjadwaltersimpan = false;
    }

    return $model;
  }

  /**
   * simpan KPPertukaranjadwaldetT
   * @param type $model
   * @param type $postPertukaran
   * @return \KPPertukaranjadwaldetT
   */
  protected function simpanPertukaranDetail($postPenjadwalanDetail, $details, $postPertukaran)
  {
    $format = new MyFormatter;
    $modDetail = new KPPertukaranjadwaldetT();
    $modDetail->attributes = $details;
    $modDetail->pertukaranjadwal_id = $postPertukaran->pertukaranjadwal_id;
    $modDetail->tglpertukaranjadwal = $postPertukaran->tglpermohonanpertukaran;
    $modDetail->shift_id = $details['shift_id'];
    $modDetail->create_time = date('Y-m-d H:i:s');
    $modDetail->create_loginpemakai_id = Yii::app()->user->id;
    $modDetail->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modDetail->ruangan_id = Yii::app()->user->getState('ruangan_id');


    if ($modDetail->validate()) {
      $modDetail->save();
      //var_dump($modDetail->getErrors());die;
      $criteria = new CDbCriteria();
      $criteria->addCondition('penjadwalan_id = ' . $details['penjadwalan_id']);
      $criteria->addCondition('pegawai_id = ' . $details['pegawai_id']);
      $criteria->addCondition('shift_id = ' . $details['shiftasal_id']);

      $shift = ShiftM::model()->findByPk($details['shift_id']);

      $modPenjadwalanDetail = KPPenjadwalandetailT::model()->findByPk($details['penjadwalandetail_id']);
      $modPenjadwalanDetail->pertukaranjadwaldet_id = $modDetail->pertukaranjadwaldet_id;
      $modPenjadwalanDetail->jamkerjamasuk = $shift->shift_jamawal;
      $modPenjadwalanDetail->jamkerjapulang = $shift->shift_jamakhir;
      $modPenjadwalanDetail->shift_id = $details['shift_id'];
      //var_dump($details['penjadwalandetail_id'].' '.$details['shift_id'].' '.$shift->shift_jamakhir);die;
      $modPenjadwalanDetail->update();
      $modDetail->ruangan_id = $modPenjadwalanDetail->ruangan_id;
      $modDetail->update();
      $this->pertukaranjadwaldetailtersimpan = true;
    } else {
      $this->pertukaranjadwaldetailtersimpan = false;
    }
    return $modDetail;
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
      $models = CHtml::listData(KPRuanganM::getRuanganItems($instalasi_id), 'ruangan_id', 'ruangan_nama');

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
      $pegawai_id = isset($_GET['pegawai_id']) ? $_GET['pegawai_id'] : null;
      $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;

      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = KPPegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . " " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['nama_pegawai'] = $model->NamaLengkap;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * menampilkan data shift berdasarkan
   * @pegawai_id,@tgl_shift
   */
  public function actionGetDataShift()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $form = "";
      $pesan = "";
      $asal_shift = array();
      $tukar_shift = array();
      $dropdownShiftAsal = '';
      $dropdownShiftTukar = '';

      $format = new MyFormatter();
      $model = new KPPenjadwalanT;
      $modPenjadwalanDetail = new KPShiftM;
      $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
      $tglshift = isset($_POST['tglshift']) ? $_POST['tglshift'] : null;

      $modPegawai = KPPegawaiM::model()->findByPk($pegawai_id);
      //PROSES PENCARIAN DATA SHIFT
      $tgl = isset($tglshift) ? date("Y-m-d", strtotime($format->formatDateTimeForDb($tglshift))) : "";

      $criteria = new CDbCriteria();
      if (!empty($tgl)) {
        $criteria->addBetweenCondition('DATE(tgljadwalpegawai)', $tgl, $tgl);
      }
      if (!empty($pegawai_id)) {
        $criteria->addCondition('pegawai_id = ' . $pegawai_id);
      }
      $modDataShifts = KPPenjadwalandetailT::model()->findAll($criteria);
      $modDataShift = KPPenjadwalandetailT::model()->find($criteria);
      //END PENCARIAN

      if (count((array)$modDataShifts) > 0) {
        foreach ($modDataShifts as $i => $shift) {
          $asal_shift[] = $shift->shift_id;
        }
      } else {
        $pesan = 'Penjadwalan Pegawai Atas Nama : ' . $modPegawai->NamaLengkap . ' untuk tanggal <b>' . MyFormatter::formatDateTimeForUser($tgl) . '</b> belum disetting';
      }

      // asal shift awal
      $criteriaShift = new CDbCriteria();
      $criteriaShift->addInCondition('shift_id', $asal_shift);
      $modShiftAsal = KPShiftM::model()->findAll($criteriaShift);
      $modelsAsal = CHtml::listData($modShiftAsal, 'shift_id', 'ShiftJam');

      if (count((array)$modelsAsal) > 0) {
        if (count((array)$modelsAsal) > 1) {
          $dropdownShiftAsal .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }

        foreach ($modelsAsal as $value => $name) {
          $dropdownShiftAsal .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      } else {
        $dropdownShiftAsal .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      }
      // asal shift akhir

      // pertukaran shift awal
      $criShift = new CDbCriteria();
      $criShift->select = " t.shift_id ";
      $criShift->join = " JOIN shift_m s ON s.shift_id = t.shift_id ";
      $criShift->addCondition('t.pegawai_id = ' . $pegawai_id);
      $modShiftTukar = KPShiftpegawaiM::model()->findAll($criShift);
      $modelsTukar = CHtml::listData($modShiftTukar, 'shift_id', 'ShiftPegawaiJam');

      if (count((array)$modelsTukar) > 0) {
        if (count((array)$modelsTukar) > 1) {
          $dropdownShiftTukar .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }

        foreach ($modelsTukar as $value => $name) {
          $dropdownShiftTukar .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      } else {
        $dropdownShiftTukar .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      }
      // asal shift akhir

      //===
      $data['form'] = $form;
      $data['pesan'] = $pesan;
      $data['dropdownShiftAsal'] = $dropdownShiftAsal;
      $data['dropdownShiftTukar'] = $dropdownShiftTukar;
      $data['penjadwalandetail_id'] = !empty($modDataShift->penjadwalandetail_id) ? $modDataShift->penjadwalandetail_id : null;
      $data['penjadwalan_id'] = !empty($modDataShift->penjadwalan_id) ? $modDataShift->penjadwalan_id : null;
      echo json_encode($data);
    }
    Yii::app()->end();
  }

  /**
   * untuk print data pertukaran shift
   */
  public function actionPrint($pertukaranjadwal_id, $caraprint = null)
  {
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    } else if ($caraprint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }
    $format = new MyFormatter;
    $modPertukaranJadwal = KPPertukaranjadwalT::model()->findByPk($pertukaranjadwal_id);
    $modPertukaranJadwalDetail = KPPertukaranjadwaldetT::model()->findAllByAttributes(array('pertukaranjadwal_id' => $modPertukaranJadwal->pertukaranjadwal_id));

    $judul_print = 'Permohonan Pertukaran Dinas';

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPertukaranJadwal' => $modPertukaranJadwal,
      'modPertukaranJadwalDetail' => $modPertukaranJadwalDetail,
      'caraprint' => $caraprint
    ));
  }
}
