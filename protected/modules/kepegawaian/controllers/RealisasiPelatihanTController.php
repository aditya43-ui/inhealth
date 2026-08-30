<?php

class RealisasiPelatihanTController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $realisasiBaru = false;

  public function actionIndex($id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Realisasi Pelatihan";
    $format = new MyFormatter;
    $model = new KPRencanadiklatT;
    $modPegawaiDiklat = new KPPegawaidiklatT;
    $modBiaya = new KPRealisasibiayapelT();
    $modRealisasi = new KPRealisasidiklatT;
    $ok = true;


    if (!empty($id)) {
      $model = KPRencanadiklatT::model()->findByPk($id);
      $model->tglrencanadiklat = MyFormatter::formatDateTimeForUser($model->tglrencanadiklat);
      $biayaRencana = KPBiayapelatihanT::model()->findByAttributes(array(
        'rencanadiklat_id' => $id,
      ));

      $modBiaya->attributes = $biayaRencana->attributes;

      if ($model->jenisdiklat_id == Params::JENIS_DIKLAT_INTERNAL) {
        $modBiaya->internal_biayapemateri = MyFormatter::formatNumberForPrint($modBiaya->internal_biayapemateri);
        $modBiaya->internal_biayakonsumsi = MyFormatter::formatNumberForPrint($modBiaya->internal_biayakonsumsi);
        $modBiaya->internal_biayaalatperaga = MyFormatter::formatNumberForPrint($modBiaya->internal_biayaalatperaga);
        $modBiaya->internal_biayalainlain = MyFormatter::formatNumberForPrint($modBiaya->internal_biayalainlain);
      }

      // var_dump($modBiaya->attributes, $biayaRencana->attributes); die;


      $modRealisasi->attributes = $model->attributes;
      $modRealisasi->realisasi_tglawal = MyFormatter::formatDateTimeForUser($model->rencanadiklat_periode);
      $modRealisasi->realisasi_tglakhir = MyFormatter::formatDateTimeForUser($model->rencanadiklat_sampaidgn);
      $modRealisasi->namapelatihan = $model->namadiklat;
      $modRealisasi->tempat = $model->tempat_diklat;
      $modRealisasi->alamat = $model->alamat_diklat;


      $modJenis = JenisdiklatM::model()->findByPk($model->jenisdiklat_id);
      $modRealisasi->jenisdiklat_nama = $modJenis->jenisdiklat_nama;
      // var_dump($modRealisasi->attributes, $model->attributes); die;

    }

    if (isset($_POST['KPRealisasidiklatT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modRealisasi->attributes = $_POST['KPRealisasidiklatT'];
        $modRealisasi->norealisasi = MyGenerator::noRealisasiDiklat();
        $modRealisasi->realisasi_tglawal = MyFormatter::formatDateTimeForDb($modRealisasi->realisasi_tglawal);
        $modRealisasi->realisasi_tglakhir = MyFormatter::formatDateTimeForDb($modRealisasi->realisasi_tglakhir);
        $modRealisasi->tgl_ditetapkan = MyFormatter::formatDateTimeForDb($modRealisasi->tgl_ditetapkan);
        $modRealisasi->tglrealisasi = date('Y-m-d H:m:s');
        $modRealisasi->jumlah_peserta = count((array)$_POST['KPPegawaidiklatT']);
        $selisih = CustomFunction::getSelisihJam($modRealisasi->jam_mulai, $modRealisasi->jam_akhir);
        $modRealisasi->total_jam = $selisih['jam'];
        $modRealisasi->total_menit = $selisih['menit'];
        $modRealisasi->create_time = date("Y-m-d H:i:s");
        $modRealisasi->create_loginpemakai_id = Yii::app()->user->id;
        $modRealisasi->create_ruangan = Yii::app()->user->ruangan_id;

        $modRealisasi->durasijam_awal = (!empty($modRealisasi->durasijam_awal)? $modRealisasi->durasijam_awal : null);
        $modRealisasi->durasijam_akhir = (!empty($modRealisasi->durasijam_akhir)? $modRealisasi->durasijam_akhir : null);


        $model = KPRencanadiklatT::model()->findByPk($modRealisasi->rencanadiklat_id);
        $modRealisasi->mengetahui_id = $model->mengetahui_id;
        $modRealisasi->menyetujui_id = $model->menyetujui_id;
        $modRealisasi->pemberitugas_id = $model->pemberitugas_id;

        $modRealisasi->dokumentasikegiatan = CUploadedFile::getInstance($modRealisasi, 'dokumentasikegiatan');

        $dokumenUpload = $modRealisasi->dokumentasikegiatan;
        $locationDok = "";
        if(!empty($modRealisasi->dokumentasikegiatan)){
          $random = rand(000000, 999999);
          $modRealisasi->dokumentasikegiatan = $random . $modRealisasi->dokumentasikegiatan;
          $locationDok = Params::pathDokumenRealisasiPelatihanDirectory() . $modRealisasi->dokumentasikegiatan;
        }

        if($modRealisasi->save()){
          $model->status_rencana = Params::STATUS_RENCANA_DIKLAT_REALISASI;
          $ok = $ok && $model->save();

          if (!empty($locationDok)) {
            $dokumenUpload->saveAs($locationDok);
          }

          if (isset($_POST['KPPegawaidiklatT'])) {
            foreach ($_POST['KPPegawaidiklatT'] as $key => $det) {

              $diff = CustomFunction::hitungHari($modRealisasi->realisasi_tglakhir, $modRealisasi->realisasi_tglawal);

              $modPegawaiDiklat = new KPPegawaidiklatT;
              $modPegawaiDiklat->attributes = $_POST['KPPegawaidiklatT'][$key];
              $modPegawaiDiklat->rencanadiklat_id = $modRealisasi->rencanadiklat_id;
              $modPegawaiDiklat->realisasidiklat_id = $modRealisasi->realisasidiklat_id;
              $modPegawaiDiklat->jenisdiklat_id = $modRealisasi->jenisdiklat_id;
              $modPegawaiDiklat->create_time = date("Y-m-d H:i:s");
              $modPegawaiDiklat->create_loginpemakai_id = Yii::app()->user->id;
              $modPegawaiDiklat->create_ruangan = Yii::app()->user->ruangan_id;
              $modPegawaiDiklat->tglditetapkandiklat = $modRealisasi->tgl_ditetapkan;
              $modPegawaiDiklat->pejabatygmemdiklat = $modRealisasi->pejabatyangmendiklat;
              $modPegawaiDiklat->nomorkeputusandiklat = $modRealisasi->no_sk;
              $modPegawaiDiklat->pegawaidiklat_tempat = $modRealisasi->tempat;
              $modPegawaiDiklat->pegawaidiklat_nama = $_POST['KPPegawaidiklatT'][$key]['nama_pegawai'];
              $modPegawaiDiklat->pegawaidiklat_lamanya = $modRealisasi->total_jam . ' jam' . (($modRealisasi->total_menit == 0) ? '' : ' ' . $modRealisasi->total_menit . ' menit');
              //$modPegawaiDiklat->pegawaidiklat_tahun = $modRealisasi->realisasi_tglawal;
              // $ok = $ok && $modPegawaiDiklat->save();

              $modPegawaiDiklat->masaberlakusertifikat = (!empty($modPegawaiDiklat->masaberlakusertifikat) ? MyFormatter::formatDateTimeForDb($modPegawaiDiklat->masaberlakusertifikat) : null);
              $modPegawaiDiklat->sertifikat = CUploadedFile::getInstance($modPegawaiDiklat, '['.$key.']sertifikat');

              $sertifikatUpload = $modPegawaiDiklat->sertifikat;
              $locationSertifikat = "";
              if(!empty($modPegawaiDiklat->sertifikat)){
                $random_srt = rand(000000, 999999);
                $modPegawaiDiklat->sertifikat = $random_srt . $modPegawaiDiklat->sertifikat;
                $locationSertifikat = Params::pathDokumenRealisasiPelatihanDirectory() . $modPegawaiDiklat->sertifikat;
              }
              
              if($modPegawaiDiklat->save()){
                $ok  = true;
                if (!empty($locationSertifikat)) {
                  $sertifikatUpload->saveAs($locationSertifikat);
                }
              }else{
                $ok = false;
              }
              // var_dump($ok, $modPegawaiDiklat->attributes, $_POST['KPPegawaidiklatT'][$key]);

            }
          }

          if (isset($_POST['KPRealisasibiayapelT'])) {
            $modBiaya->attributes = $_POST['KPRealisasibiayapelT'];
            $modBiaya->realisasidiklat_id = $modRealisasi->realisasidiklat_id;
            $modBiaya->total_biaya = $modBiaya->getTotalSeluruh();

            $ok = $ok && $modBiaya->save();
            // var_dump($ok, $modBiaya->attributes, $modBiaya->total_biaya);
          }
        }

        // $ok = $ok && $modRealisasi->save();


        // var_dump($ok); 
        // die;

        if ($ok) {
          Yii::app()->user->setFlash('success', "Data " . $modRealisasi->norealisasi . " berhasil disimpan !");
          $transaction->commit();
          $this->redirect(array('index', 'realisasi_id' => $modRealisasi->realisasidiklat_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Update Data Realisasi Pelatihan gagal disimpan !");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Realisasi Pelatihan gagal disimpan ! " . MyExceptionMessage::getMessage($ex, true));
      }
    }
    $this->render('index', array(
      'model' => $model,
      'format' => $format,
      'modPegawaiDiklat' => $modPegawaiDiklat,
      'modBiaya' => $modBiaya,
      'modRealisasi' => $modRealisasi
    ));
  }

  public function actionAutocompleteNoRencanaDiklat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (!isset($_GET['term'])) {
        $_GET['term'] = null;
      }
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(norencanadiklat)', strtolower($_GET['term']), true);
      //$criteria->select ='norencanadiklat';
      //$criteria->group = 'norencanadiklat';
      $criteria->order = 'norencanadiklat';
      $criteria->limit = 5;
      $models = KPRencanadiklatT::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->norencanadiklat;
        $returnVal[$i]['value'] = $model->norencanadiklat;
        $returnVal[$i]['tglrencanadiklat'] = MyFormatter::formatDateTimeForUser($model->tglrencanadiklat);
        $returnVal[$i]['jenisdiklat_nama'] = $model->jenisdiklat->jenisdiklat_nama;

        $b = BiayapelatihanT::model()->findByAttributes(array('rencanadiklat_id' => $model->rencanadiklat_id));

        $returnVal[$i]['internal_biayapemateri'] = $b->internal_biayapemateri;
        $returnVal[$i]['internal_biayaalatperaga'] = $b->internal_biayaalatperaga;
        $returnVal[$i]['internal_biayakonsumsi'] = $b->internal_biayakonsumsi;
        $returnVal[$i]['internal_biayalainlain'] = $b->internal_biayalainlain;
        $returnVal[$i]['internal_keteranganlainlain'] = $b->internal_keteranganlainlain;
        $returnVal[$i]['biayapelatihan_id'] = $b->biayapelatihan_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionLoadFormRencanaPelatihan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $date = date("d");
      //$norencanadiklat = $_POST['norencanadiklat'];
      $id = $_POST['rencanadiklat_id'];

      $format = new MyFormatter();
      //$criteria=new CDbCriteria;
      //$criteria->join = "JOIN pegawai_m ON pegawai_m.pegawai_id = t.pegawai_id 
      //				   LEFT JOIN pegawaidiklat_t ON pegawaidiklat_t.rencanadiklat_id = t.rencanadiklat_id";
      //if(!empty($this->rencanadiklat_id)){
      //      $criteria->addCondition('t.rencanadiklat_id = '.$this->rencanadiklat_id);
      //}
      //$criteria->compare('LOWER(norencanadiklat)',strtolower($norencanadiklat),true);
      //$criteria->addCondition('pegawaidiklat_t.rencanadiklat_id IS NULL');
      //$modRencanaDiklat = KPRencanadiklatT::model()->findAll($criteria);

      $modRencanaDiklat = KPRencanadiklatT::model()->findByPk($id);

      $modPegawaiDiklat = new KPPegawaidiklatT;

      $modDetail = KPRencanadiklatdetT::model()->findAllByAttributes(array('rencanadiklat_id' => $id));

      echo CJSON::encode(
        array(
          'form' => $this->renderPartial(
            '_rowRealisasiPelatihanV2',
            array(
              'format' => $format,
              'modRencanaDiklat' => $modRencanaDiklat,
              'modPegawaiDiklat' => $modPegawaiDiklat,
              'modDetail' => $modDetail
            ),
            true
          )
        )
      );
      exit;
    }
  }

  public function actionPrint($id)
  {
    $details = array();
    $modPrograms = array();
    $format = new MyFormatter();

    $model = RealisasidiklatT::model()->findByPk($id);
    $modDetail = PegawaidiklatT::model()->findAllByAttributes(array(
      'realisasidiklat_id' => $id
    ));
    $modBiaya = RealisasibiayapelT::model()->findByAttributes(array(
      'realisasidiklat_id' => $id
    ));


    $judulLaporan = 'Realisasi Pelatihan Pegawai';
    $deskripsi = $model->norealisasi;
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array(
        'model' => $model,
        'modBiaya' => $modBiaya,
        'format' => $format,
        'modDetail' => $modDetail,
        'deskripsi' => $deskripsi,
        'judulLaporan' => $judulLaporan,
        'caraPrint' => $caraPrint
      ));
    }
  }

  public function actionAutocompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (!isset($_GET['term'])) {
        $_GET['term'] = null;
      }
      $returnVal = array();
      $criteria = new CDbCriteria();
      if (isset($_GET['pegawai_id'])) {
        if (!empty($_GET['pegawai_id'])) {
          $criteria->addCondition("pegawai_id = " . $_GET['pegawai_id']);
        }
      }
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
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
        if (!empty($model->jabatan_id)) {
          $returnVal[$i]['jabatan_nama'] = JabatanM::model()->findByPk($model->jabatan_id)->jabatan_nama;
        } else {
          $returnVal[$i]['jabatan_nama'] = '';
        }
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionDownloadSertifikat($pegawaidiklat_id) {
    $model = PegawaidiklatT::model()->findByAttributes(array('pegawaidiklat_id'=>$pegawaidiklat_id));
    
    $file = Params::pathDokumenRealisasiPelatihanDirectory().$model->sertifikat;
    
    if (file_exists($file)) {
  
        header('Content-Description: File Transfer');
        header('Content-Type: '.mime_content_type($file));
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }
  }
}
