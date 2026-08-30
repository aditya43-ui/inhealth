<?php
class ReturResepPasienController extends MyAuthController
{
  public $path_view = "farmasiApotek.views.returResepPasien.";
  public $returdetailtersimpan = true; //looping
  public $stokobatalkestersimpan = true; //looping
  public $ubahoapasien = true; //looping
  /**
   * Membuat dan menyimpan data baru.
   * jika dari informasi menggunakan @params:
   * - $_GET['instalasi_id']
   * - $_GET['pendaftaran_id']
   * - $_GET['pasienadmisi_id'] (untuk RI saja)
   * layout frame=1 -> frameDialog
   */
  public function actionIndex($id = null)
  {
    if (isset($_GET['frame'])) {
      $this->layout = "//layouts/iframe";
    }
    $format = new MyFormatter();
    $model = new FAReturresepT;
    $model->tglretur = $format->formatDateTimeForUser(date("Y-m-d H:i:s"));
    $model->noreturresep = "-- Otomatis --";
    $model->pegretur_id = Yii::app()->user->getState('pegawai_id');
    $modKunjungan = new FAInformasipenjualanresepV; //di group berdasarkan pendaftaran_t
    $dataOas = array();
    if (!empty($id)) {
      $model = FAReturresepT::model()->findByPk($id);
    }
    $pendaftaran_id = (isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : (!empty($model->pendaftaran_id) ? $model->pendaftaran_id : null));
    if (!empty($pendaftaran_id)) {
      $loadKunjungan = FAInformasipenjualanresepV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      if (isset($loadKunjungan)) {
        $modKunjungan = $loadKunjungan;
        $modPendaftaran = PendaftaranT::model()->findByPk($modKunjungan->pendaftaran_id);
        $modKunjungan->tgl_pendaftaran = $modPendaftaran->tgl_pendaftaran;
        $modKunjungan->no_pendaftaran = $modPendaftaran->tgl_pendaftaran;
      }
    }

    if (isset($_POST['pendaftaran_id']) && isset($_POST['FAReturresepT']) && (isset($_POST['FAReturresepdetT']))) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $updateOAPasien = false;
        $modKunjungan->attributes = $_POST;
        $model->attributes = $_POST['FAReturresepT'];
        $model->pendaftaran_id = $_POST['pendaftaran_id'];
        $model->pasien_id = $_POST['pasien_id'];
        $model->pasienadmisi_id = $_POST['pasienadmisi_id'];
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->tglretur = $format->formatDateTimeForDb($model->tglretur);
        $model->noreturresep = MyGenerator::noReturResep();

        // var_dump($_POST); die;

        $model->tglretur = MyFormatter::formatDateTimeForDb($model->tglretur);
        // var_dump($model->attributes); die;

        if ($model->save()) {
          // var_dump($model->penjualanresep_id); die;
          FAPenjualanResepT::model()->updateByPk($model->penjualanresep_id, array(
            'returresep_id' => $model->returresep_id,
          ));

          foreach ($_POST['FAReturresepdetT'] as $i => $postDetail) {

            $this->ubahoapasien = true;

            $dataOas[$i] = FAObatalkesPasienT::model()->findByPk($postDetail['obatalkespasien_id']);
            if ($postDetail['pilihObat']) {
              $modDetails[$i] = new FAReturresepdetT;
              $modDetails[$i]->attributes = $postDetail;
              $modDetails[$i]->returresep_id = $model->returresep_id;

              if ($modDetails[$i]->save()) {
                $this->simpanStokObatAlkesIn($modDetails[$i]);
                $this->ubahoapasien = $this->ubahoapasien && FAObatalkesPasienT::model()->updateByPk($modDetails[$i]->obatalkespasien_id, array(
                  'returresepdet_id' => $modDetails[$i]->returresepdet_id,
                ));
                FAPenjualanResepT::model()->updateByPk($dataOas[$i]->penjualanresep_id, array(
                  'returresep_id' => $model->returresep_id,
                ));
                // $oaPasien->returresepdet_id = $modDetails[$i]->returresepdet_id;
                //var_dump($oaPasien->attributes); die;

                // $this->ubahoapasien = $oaPasien->update('returresepdet_id');
                // $oaPasien->qty_oa = $oaPasien->qty_oa - $modDetails[$i]->qty_retur;
                // if($oaPasien->update()){
                //        $this->ubahoapasien = FAPenjualanResepT::model()->updateByObatalkespasienT($oaPasien->penjualanresep_id);
                //}else{
                //        $this->ubahoapasien = true;
                //}
              } else {
                $this->returdetailtersimpan = false;
              }
            }
          }
        }

        // var_dump($this->ubahoapasien, $this->returdetailtersimpan, $this->stokobatalkestersimpan);
        // die;

        if ($this->ubahoapasien && $this->returdetailtersimpan && $this->stokobatalkestersimpan) {
          //Di set di form >> Yii::app()->user->setFlash('success', 'Data pembayaran berhasil disimpan !');
          $transaction->commit();
          $this->redirect(array('index', 'id' => $model->returresep_id, 'sukses' => 1));
        } else {
          Yii::app()->user->setFlash('error', 'Data pembayaran gagal disimpan !');
          $model->isNewRecord = true;
          //					echo "-".$this->ubahoapasien."<br>";
          //					echo "-".$this->returdetailtersimpan."<br>";
          //					echo "-".$this->stokobatalkestersimpan."<br>";
          //					exit;
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        Yii::app()->user->setFlash('error', "Data pembayaran gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $transaction->rollback();
      }
    }



    $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
    $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

    $this->render('index', array(
      'model' => $model,
      'modKunjungan' => $modKunjungan,
      'dataOas' => $dataOas,
    ));
  }

  /**
   * form verifikasi sebelum submit
   * @param type $id
   */
  public function actionVerifikasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $this->layout = '//layouts/iframe';
      if (isset($_POST)) {
        $format = new MyFormatter();
        $modKunjungan = new FAInformasipenjualanresepV;
        $modKunjungan->attributes = $_POST;
        $model = new FAReturresepT;
        $model->attributes = $_POST['FAReturresepT'];
        $model->totalpenjualan = $_POST['total_oa'];
      }
      echo CJSON::encode(array(
        'content' => $this->renderPartial($this->path_view . 'verifikasi', array(
          'format' => $format,
          'modKunjungan' => $modKunjungan,
          'model' => $model,
        ), true)
      ));
      exit;
    }
  }

  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_pendaftaran
   * - no_rekam_medik
   * - nama_pasien
   */
  public function actionAutocompleteKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $penjualanresep_id = isset($_GET['penjualanresep_id']) ? $_GET['penjualanresep_id'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->group = "noresep,penjualanresep_id,pendaftaran_t.pendaftaran_id, pendaftaran_t.tgl_pendaftaran, pendaftaran_t.no_pendaftaran, t.pasien_id, t.no_rekam_medik, t.nama_pasien, t.jeniskelamin";
      $criteria->select = $criteria->group;
      $criteria->join = "JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id";
      $criteria->compare('LOWER(pendaftaran_t.no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(t.nama_pasien)', strtolower($nama_pasien), true);
      if (!empty($penjualanresep_id)) {
        $criteria->addCondition(" penjualanresep_id = " . $penjualanresep_id . " ");
      }
      $criteria->order = 'pendaftaran_t.no_pendaftaran, t.no_rekam_medik, t.nama_pasien';
      $criteria->limit = 5;
      $models = FAInformasipenjualanresepV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "") . " - (" . $model->noresep . ")";
        $returnVal[$i]['value'] = $model->no_pendaftaran;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * Mengurai data kunjungan berdasarkan:
   * - instalasi_id
   * - pendaftaran_id
   * - pasienadmisi_id
   * - no_pendaftaran
   * - no_rekam_medik
   * @throws CHttpException
   */
  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $penjualanresep_id = isset($_POST['penjualanresep_id']) ? $_POST['penjualanresep_id'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->group = "penjualanresep_id, pendaftaran_t.pendaftaran_id, pendaftaran_t.tgl_pendaftaran, pendaftaran_t.no_pendaftaran, t.pasien_id, t.no_rekam_medik, t.nama_pasien, t.jeniskelamin";
      $criteria->select = $criteria->group;
      $criteria->join = "JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = t.pendaftaran_id";
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition('pendaftaran_t.pendaftaran_id = ' . $pendaftaran_id);
      }
      if (!empty($penjualanresep_id)) {
        $criteria->addCondition('t.penjualanresep_id = ' . $penjualanresep_id);
      }
      $criteria->compare('LOWER(pendaftaran_t.no_pendaftaran)', strtolower(trim($no_pendaftaran)));
      $criteria->compare('LOWER(t.no_rekam_medik)', strtolower(trim($no_rekam_medik)));
      $model = FAInformasipenjualanresepV::model()->find($criteria);
      $pasien = PasienM::model()->findByPk($model->pasien_id);
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($pasien->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      $returnVal["no_pendaftaran"] = $model->no_pendaftaran;

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * menampilkan form rincian tagihan obat alkes
   */
  public function actionSetRincianObatalkes()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : 0);
      $penjualanresep_id = (isset($_POST['penjualanresep_id']) ? $_POST['penjualanresep_id'] : null);
      $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
      $form = '';
      $model = new FAReturresepT;
      $dataOas = array();
      if (!empty($pendaftaran_id)) {
        $criteria = new CdbCriteria();
        $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
        $criteria->addCondition("penjualanresep_id = " . $penjualanresep_id);
        //                $criteria->addCondition("oasudahbayar_id IS NULL");
        $criteria->addCondition("penjualanresep_id IS NOT NULL and oasudahbayar_id is not null");
        $criteria->order = "penjualanresep_id, obatalkespasien_id";
        $dataOas = FAObatalkesPasienT::model()->findAll($criteria);
      }
      $form = $this->renderPartial($this->path_view . '_formRincianObatalkes', array('model' => $model, 'dataOas' => $dataOas), true);
      $data['form'] = $form;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * simpan StokobatalkesT Jumlah Out
   * @param type $stokobatalkesasal_id
   * @param type $modDetails
   * @return \StokobatalkesT
   */
  protected function simpanStokObatAlkesIn($modDetails)
  {
    $format = new MyFormatter;
    $modStokOaNew = new StokobatalkesT;
    $modStokOa = StokobatalkesT::model()->findByAttributes(array('obatalkespasien_id' => $modDetails->obatalkespasien_id));
    if ($modStokOa) {
      $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
      $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
      $modStokOaNew->qtystok_in = $modDetails->qty_retur;
      $modStokOaNew->qtystok_out = 0;
      $modStokOaNew->returresepdet_id = $modDetails->returresepdet_id;
      $modStokOaNew->tglterima = date("Y-m-d H:i:s");
      $modStokOaNew->create_time = date('Y-m-d H:i:s');
      $modStokOaNew->update_time = date('Y-m-d H:i:s');
      $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
      $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
      $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;
      $modStokOaNew->ruangan_id = Yii::app()->user->ruangan_id;
      $modStokOaNew->stokoa_aktif = true;

      if ($modStokOaNew->validate()) {
        $modStokOaNew->save();
        if ($modStokOa->qtystok_out == $modStokOaNew->qtystok_in) { //jika penjualan diretur semua
          $modStokOa->stokoa_aktif = false;
          $modStokOa->save();
        }
      } else {
        $this->stokobatalkestersimpan &= false;
      }
    }
    return $modStokOaNew;
  }
  /**
   * actionPrintRincianReturOAPasien 
   * @params $instalasi_id = RJ / RD / RI
   * @params $pendaftaran_id
   * @params $pasienadmisi_id (RI saja)
   */
  public function actionPrintRincian($returresep_id)
  {
    $this->layout = '//layouts/printWindows';
    $judulLaporan = 'Retur Resep / Obat Alkes Pasien';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    $model = FAReturresepT::model()->findByPk($returresep_id);
    $modRincians = FAReturresepdetT::model()->findAllByAttributes(array('returresep_id' => $model->returresep_id));
    $this->render('printRincian', array('model' => $model, 'modRincians' => $modRincians, 'judulLaporan' => $judulLaporan));
  }
}
