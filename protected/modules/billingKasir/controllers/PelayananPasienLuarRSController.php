
<?php

class PelayananPasienLuarRSController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'billingKasir.views.pelayananPasienLuarRS.';
  public $succesSave = true;
	public $pesan = '';
  public $pendaftarantersimpan = false;


  public function actionIndex($id = null, $pendaftaran_id = null)
  {
    $modPendaftaran = new BKPendaftaranT;
    $modPasien = new BKPasienM;
    $this->pageTitle = Yii::app()->name . " - Pelayanan Pasien Luar RS";
    $modKunjungan = new BKInfopasienpengunjungV;

    if (isset($_POST['TindakanpelayananT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      if(isset($_POST['BKPasienM'])){
        // var_dump($modPasien);die;
        $modPasien = $this->simpanPasienAps($modPasien, $_POST['BKPasienM']);
        
      }
      $modPendaftaran = $this->simpanPendaftaran($modPendaftaran,$modPasien);
      // var_dump($modPendaftaran);die;

      try {
        $countSimpan = 0;
        $konfig = KonfigsystemK::model()->find();

        $pasienadmisi_id = (!empty($_POST['pasienadmisi_id'])?$_POST['pasienadmisi_id']:null);
        $kodetindakan = MyGenerator::kodetindakanluarGen();

        foreach($_POST['TindakanpelayananT'] as $i => $dataTindakan){
          $modTindakan = new TindakanpelayananT();
          $modTindakan->attributes = $dataTindakan;
          $modTindakan->daftartindakan_id = (empty($modTindakan->daftartindakan_id)? $konfig->tindakanluarrs : $modTindakan->daftartindakan_id);
          $modTindakan->tgl_tindakan = (!empty($dataTindakan['tgl_tindakan'])? MyFormatter::formatDateTimeForDb($dataTindakan['tgl_tindakan']):null);
          $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
          $modTindakan->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
          $modTindakan->pasien_id = $modPendaftaran->pasien_id;
          $modTindakan->instalasi_id = $modPendaftaran->instalasi_id;
          $modTindakan->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
          $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
          $modTindakan->jeniskasuspenyakit_id = Params::JENIS_KASUSPENYAKIT_ID_UMUM;
          $modTindakan->ruangan_id = Yii::app()->user->getState('ruangan_id');
          $modTindakan->penjamin_id = Params::PENJAMIN_ID_UMUM;
          $modTindakan->pasienadmisi_id = $pasienadmisi_id;
          $modTindakan->cyto_tindakan = 0;
          $modTindakan->tarifcyto_tindakan = 0;
          $modTindakan->subsidiasuransi_tindakan = 0;
          $modTindakan->subsidipemerintah_tindakan = 0;
          $modTindakan->subsisidirumahsakit_tindakan = 0;
          $modTindakan->iurbiaya_tindakan = 0;
          $modTindakan->create_time = date('Y-m-d H:i:s');
          $modTindakan->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
          $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
          $modTindakan->tindakanluar_kode = $kodetindakan;

          $modTindakan->tarif_tindakan = $dataTindakan['tariftindakan'];
          $modTindakan->satuantindakan = "KALI";

          $modPasien = $this->simpanPasienAps($modPasien, $_POST);
          $modPendaftaran = $this->simpanPendaftaran($modPendaftaran,$modPasien);
          // var_dump($modPasien);die;
          // var_dump($modTindakan->save());die;
          if($modTindakan->save()){
            $countSimpan += 1;
            $tersimpankomp = true;
            
            if(!empty($_POST['TindakankomponenT'][$i])){
              foreach($_POST['TindakankomponenT'][$i] as $j => $dataKomponen){
                $modTindakanKomp = new TindakankomponenT();
                $modTindakanKomp->komponentarif_id = $dataKomponen['komponen_id'];
                $modTindakanKomp->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
                $modTindakanKomp->tarif_kompsatuan = $dataKomponen['tarif_kompsatuan'];
                $modTindakanKomp->tarif_tindakankomp = $dataKomponen['tarif_tindakankomp'];
                $modTindakanKomp->tarifcyto_tindakankomp = 0;
                $modTindakanKomp->subsidiasuransikomp = 0;
                $modTindakanKomp->subsidipemerintahkomp = 0;
                $modTindakanKomp->subsidirumahsakitkomp = 0;
                $modTindakanKomp->iurbiayakomp = $dataKomponen['tarif_tindakankomp'];
                $modTindakanKomp->discountkomptindakan = $dataKomponen['discountkomptindakan'];
                // var_dump($modTindakanKomp->save());die;
                if(!$modTindakanKomp->save()){
                  $tersimpankomp = false;
                }
              }
            }

            if($tersimpankomp == false){
              if($countSimpan > 0){
                $countSimpan -= 1;
              }
            }

            if(Yii::app()->user->getState('isjurnalotomatis') == true){
              $modJurnalRekening = $this->saveJurnalRekening($modTindakan);
              $nourut = 1;
              
              $rekpelayanan_d = PelayananrekM::model()->findByAttributes(array('ruangan_id'=>$modTindakan->ruangan_id,'daftartindakan_id'=>$modTindakan->daftartindakan_id, 'debitkredit'=>'D'));
              if($modTindakan->tarif_tindakan > 0 && !empty($rekpelayanan_d)){
                $this->saveJurnalDetail($modJurnalRekening, $rekpelayanan_d->rekening5_id, $modTindakan->tarif_tindakan ,'D',$nourut);
                $nourut = ($nourut + 1);
              }

              $rekcolumn_d = RekeningcolumnM::model()->findByAttributes(array('table_name'=>Params::REKENINGCOLUMN_TABLE_TINDAKANPELAYANANT, 'column_name'=>Params::REKENINGCOLUMN_COLUMN_DISCOUNTTINDAKAN,'debitkredit'=>'D'));
              if($modTindakan->discount_tindakan > 0 && !empty($rekcolumn_d)){
                $this->saveJurnalDetail($modJurnalRekening, $rekcolumn_d->rekening5_id, $modTindakan->discount_tindakan ,'D',$nourut);
                $nourut = ($nourut + 1);
              }

              $rekpelayanan_k = PelayananrekM::model()->findByAttributes(array('ruangan_id'=>$modTindakan->ruangan_id,'daftartindakan_id'=>$modTindakan->daftartindakan_id, 'debitkredit'=>'K'));
              $jmlQty = round(($modTindakan->qty_tindakan * $modTindakan->tarif_satuan),2);

              if($jmlQty > 0 && !empty($rekpelayanan_k)){
                $this->saveJurnalDetail($modJurnalRekening, $rekpelayanan_k->rekening5_id, $jmlQty ,'K',$nourut);
              }
            }
          }else{
            if($countSimpan > 0){
              $countSimpan -= 1;
            }
          }
        }
        // var_dump($modPasien);die;
        if($countSimpan == count((array)$_POST['TindakanpelayananT'])){
          $transaction->commit();
          // $sukses = 1;
          // var_dump($konfig->mr_pasienaps);die;
          // if ($modPasien->is_random) {
          //   $data = $modPasien->generateNoRMDanSimpan($konfig->mr_pasienaps,'TRUE');
          // }
         
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $this->redirect(array('index','sukses'=>1,'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'instalasi_id'=>$modPendaftaran->instalasi_id,'pasienadmisi_id'=>$pasienadmisi_id, 'kodetindakanluar'=>$kodetindakan));
        }else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $exc) {
        // var_dump($exc);die;
        var_dump($exc->getMessage()); die;
        $transaction->rollback(); 
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view.'index', array(
      'modKunjungan' => $modKunjungan,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
    ));
  }

  /**
  * proses simpan / ubah data pendaftaran
	* RND-5298
  * @return type
  */
  public function simpanPendaftaran($model,$modPasien){
    $format = new MyFormatter();
    // var_dump($model);die;
    $model->ruangan_id = Params::RUANGAN_ID_NURSESTATION;
    $model->pasien_id = $modPasien->pasien_id;
    $model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    $model->instalasi_id = (isset($model->ruangan_id) ? $model->ruangan->instalasi_id : null);
    $model->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
    $model->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
    $model->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
    $model->statuspasien = (empty($_POST['BKPasienM']['pasien_id']) ? Params::STATUSPASIEN_BARU : Params::STATUSPASIEN_LAMA);
    $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
    $model->shift_id = Yii::app()->user->getState('shift_id');
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_time = date("Y-m-d H:i:s");
    $model->statusmasuk = (!empty($model->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
    $model->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
    $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
    $model->penjamin_id = Params::PENJAMIN_ID_UMUM;
    $model->jeniskasuspenyakit_id = Params::JENIS_KASUSPENYAKIT_ID_UMUM;
    $model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id);
    if(Yii::app()->user->getState('tgltransaksimundur') && !empty($model->tgl_pendaftaran)){
      $model->tgl_pendaftaran = $format->formatDateTimeForDb($model->tgl_pendaftaran);
    }else{
      $model->tgl_pendaftaran = date("Y-m-d H:i:s");
    }
    $model->no_pendaftaran = MyGenerator::noPendaftaranPenjualanAPS($model->tgl_pendaftaran);
    // var_dump($model->no_pendaftaran);die;

    if($model->save()){
        $this->pendaftarantersimpan = true;
    }else{
        $this->pendaftarantersimpan = false;
    }
    return $model;
  }

   /**
    *
    * @param type $postsimpan / update pasien
    */
    public function simpanPasienAps($modPasien, $post){
      // var_dump($post);die;
      $konfig = KonfigsystemK::model()->find();
      $format = new MyFormatter();
      if(isset($post['pasien_id']) && !empty($post['pasien_id'])){
          if($post['pasien_id']){
              $loadPasien = BKPasienM::model()->findByPk($post['pasien_id']);
              if(isset($loadPasien)){
                  $modPasien = $loadPasien;
                  $modPasien->attributes = $post;
                  $modPasien->tanggal_lahir = MyFormatter::formatDateTimeForDb($modPasien->tanggal_lahir);
                  $modPasien->update_time = date("Y-m-d H:i:s");
                  $modPasien->update_loginpemakai_id = Yii::app()->user->id;
                  $modPasien->update();
              }
          }
      } else {

          $modPasien->attributes = $post;
          $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
          $modPasien->tanggal_lahir = $format->dateTimeForDb($modPasien->tanggal_lahir);
          // $modPasien->no_rekam_medik = $modPasien->generateNoRandom(); // MyGenerator::noRekamMedik(Yii::app()->user->getState('mr_apotik'),'TRUE');
          $modPasien->no_rekam_medik = MyGenerator::noRekamMedikAPS($konfig->mr_pasienaps);
          $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
          $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
          $modPasien->ispasienluar = true;
          $modPasien->profilrs_id = Yii::app()->user->getState('profilrs_id');
          $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
          $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
          $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
          $modPasien->agama = Params::DEFAULT_AGAMA;
          $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
          $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
          $modPasien->create_time = date("Y-m-d H:i:s");
          $modPasien->create_loginpemakai_id = Yii::app()->user->id;
          // var_dump($modPasien);die;
          $modPasien->save();
          
      }
      
      return $modPasien;
  }

  /**
     * Mengurai data pasien berdasarkan:
     * - pasien_id
     * - no_rekam_medik
     * @throws CHttpException
     */
    public function actionGetDataInfoPasien()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $format = new MyFormatter();
            $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
            $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
            $returnVal = array();
            $criteria = new CDbCriteria();
        if(!empty($pasien_id)){
          $criteria->addCondition("pasien_id = ".$pasien_id);
        }
            $criteria->compare('LOWER(no_rekam_medik)',strtolower(trim($no_rekam_medik)));
            $model = BKPasienM::model()->find($criteria);
            $attributes = $model->attributeNames();
            foreach($attributes as $j=>$attribute) {
                $returnVal["$attribute"] = $model->$attribute;
            }
            $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
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
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
      $criteria->limit = 5;
      $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI));
      $models = BKInfopasienpengunjungV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }

        $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
        $returnVal[$i]['value'] = $model->no_pendaftaran;
        $returnVal[$i]['pasienadmisi_id'] = isset($model->pasienadmisi_id) ? $model->pasienadmisi_id : '';
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * Mengurai data kunjungan berdasarkan:
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
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
      }
      if (!empty($pasienadmisi_id)) {
        $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
      }
      $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
      $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));
      $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI,Params::INSTALASI_ID_REHAB));
      $model = BKInfopasienpengunjungV::model()->find($criteria);

      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }


      $pendaftaran = PendaftaranT::model()->findByPk($model->pendaftaran_id);
      $asuransi = AsuransipasienM::model()->findByPk($pendaftaran->asuransipasien_id);

      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }


      $returnVal['kelastanggungan_id'] = null;
      $returnVal['kelastanggungan_nama'] = null;

      $returnVal['kelastanggungan_nilai'] = null;
      $returnVal['kelaspelayanan_nilai'] = Params::kelasPelayananNilai($model->kelaspelayanan_id);

      if (!empty($asuransi)) {
        $kelas = KelaspelayananM::model()->findByPk($asuransi->kelastanggunganasuransi_id);
        $returnVal['kelastanggungan_id'] = $kelas->kelaspelayanan_id;
        $returnVal['kelastanggungan_nama'] = $kelas->kelaspelayanan_nama;
        $returnVal['kelastanggungan_nilai'] = Params::kelasPelayananNilai($kelas->kelaspelayanan_id);
      }


      $returnVal['dokterpenerima'] = "";
      $returnVal['dpjp1'] = "";
      $returnVal['dpjp2'] = "";
      $returnVal['dpjp3'] = "";

      if (!empty($model->pasienadmisi_id)) { //replace dgn admisi
        $admisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);

        $returnVal["instalasi_id"] = $model->instalasiadmisi_id;
        $returnVal["ruangan_id"] = $model->ruanganadmisi_id;
        $returnVal["kelaspelayanan_id"] = $model->kelaspelayananadmisi_id;
        $returnVal["carabayar_id"] = $model->carabayaradmisi_id;
        $returnVal["penjamin_id"] = $model->penjaminadmisi_id;
        $returnVal["ruangan_nama"] = $model->ruanganadmisi_nama;
        $returnVal["kelaspelayanan_nama"] = $model->kelaspelayananadmisi_nama;
        $returnVal["carabayar_nama"] = $model->carabayaradmisi_nama;
        $returnVal["penjamin_nama"] = $model->penjaminadmisi_nama;

        if (!empty($admisi->dokterpenerima_id)) {
          $peg = PegawaiM::model()->findByPk($admisi->dokterpenerima_id);
          $returnVal['dokterpenerima'] = $peg->namaLengkap;
        }

        if (!empty($admisi->pegawai_id)) {
          $peg = PegawaiM::model()->findByPk($admisi->pegawai_id);
          $returnVal['dpjp1'] = $peg->namaLengkap;
        }

        if (!empty($admisi->dpjp2_id)) {
          $peg = PegawaiM::model()->findByPk($admisi->dpjp2_id);
          $returnVal['dpjp2'] = $peg->namaLengkap;
        }

        if (!empty($admisi->dpjp3_id)) {
          $peg = PegawaiM::model()->findByPk($admisi->dpjp3_id);
          $returnVal['dpjp3'] = $peg->namaLengkap;
        }
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  protected function saveJurnalRekening($model)
    {
        $period = Yii::app()->user->getState('periode_ids');
        if (is_array($period)) {
            $period = $period[0];
        }

        $format = new MyFormatter();
        $modJurnalRekening = new JurnalrekeningT;
        $modJurnalRekening->jenisjurnal_id = Params::JENISJURNAL_ID_PELAYANAN;
        $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tgl_tindakan);
        $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
        $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
        $modJurnalRekening->noreferensi = $model->pendaftaran->no_pendaftaran;
        $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tgl_tindakan);
        $modJurnalRekening->nobku = "";
        $modJurnalRekening->urianjurnal = $model->pendaftaran->no_pendaftaran .' - '.$model->pasien->nama_pasien .' - PIUTANG TINDAKAN '.$model->tindakanluar_nama;

        $periodeID = $period;
        $modJurnalRekening->rekperiod_id = $periodeID;
        $modJurnalRekening->create_time = date('Y-m-d H:i:s');
        $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
        $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $modJurnalRekening->tindakanpelayanan_id = $model->tindakanpelayanan_id;

        if($modJurnalRekening->validate()){
            if($modJurnalRekening->save()){
              TindakanpelayananT::model()->updateByPk($model->tindakanpelayanan_id, array('jurnalrekening_id'=>$modJurnalRekening->jurnalrekening_id));
              $this->succesSave = true;
            }
        } else {
            $this->succesSave = false;
            $this->pesan = $modJurnalRekening->getErrors();
        }
        return $modJurnalRekening;
    }

		public function saveJurnalDetail($modJurnalRekening, $rekening5_id, $nilaisaldo, $typeSaldo, $nourut){
        $valid = true;

        $modelJurnalDetail = new JurnaldetailT();
        $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
        $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
        $modelJurnalDetail->rekening5_id = $rekening5_id;
        $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;
        $modelJurnalDetail->nourut = $nourut;
				if($typeSaldo == 'K'){
						$modelJurnalDetail->saldokredit = $nilaisaldo;
						$modelJurnalDetail->saldodebit = 0;
				}else if($typeSaldo == 'D'){
						$modelJurnalDetail->saldodebit = $nilaisaldo;
						$modelJurnalDetail->saldokredit = 0;
				}

        if($modelJurnalDetail->validate()){
                $modelJurnalDetail->save();
            }else{
                $valid = false;
            }

        return $valid;
    }

    public function actionPrint($pendaftaran_id, $instalasi_id, $pasienadmisi_id=null, $kodetindakanluar=null)
    {
      // $modKunjungan = BKInfopasienpengunjungV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'instalasi_id'=>$instalasi_id));
      $totalkeseluruhan = 0;
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      // var_dump($modPasien);die;

      $modTindakans = TindakanpelayananT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'tindakanluar_kode'=>$kodetindakanluar));
      // var_dump($modTindakans);die;

      if(!empty($modTindakans)){
        foreach($modTindakans as $dataTindakan){
          $totalkeseluruhan += $dataTindakan->tarif_tindakan;
          // var_dump($totalkeseluruhan);die;
        }
      }
      $judul_print = "Pembayaran Luar Rumah Sakit";
      $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render($this->path_view . 'print', array(
          'caraPrint' => $caraPrint,
          // 'modKunjungan' => $modKunjungan,
          'totalkeseluruhan'=>$totalkeseluruhan,
          'modTindakans'=>$modTindakans,
          'modPendaftaran'=>$modPendaftaran,
          'modPasien' => $modPasien,
          'judul_print' =>$judul_print
        ));
      }
    }

     /**
     * set umur dari tanggal lahir (date)
     */
    public function actionSetUmur() {
      if (Yii::app()->getRequest()->getIsAjaxRequest()) {
          $data['umur'] = null;
          if (isset($_POST['tanggal_lahir']) && !empty($_POST['tanggal_lahir'])) {
              $data['umur'] = CustomFunction::hitungUmur($_POST['tanggal_lahir']);
          }
          echo json_encode($data);
          Yii::app()->end();
      }
  }

}
