<?php
Yii::import('laboratorium.controllers.PemakaianBahanController');
class PemakaianBahanRJController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $path_view = "rawatJalan.views.pemakaianBahanRJ.";
  public $succesSave = true;
  public $pesan = "";
  public $obatalkespasientersimpan = true; //di looping
  public $stokobatalkestersimpan = true; //looping

  public function actionIndex($pendaftaran_id = null, $pasienadmisi_id = null, $linkHalaman = null)
  {
      if(empty($pendaftaran_id)){
        $pendaftaran_id = null;
      }
      if(empty($pasienadmisi_id)){
        $pasienadmisi_id = null;
      }

      $this->pageTitle = Yii::app()->name . " - Pemakaian Bahan";
      $format = new MyFormatter();
      $modKunjungan = new InfopasienpengunjungV;
      $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
      $modObatAlkesPasien = new ObatalkespasienT;
      $dataOas = array();

      if (!empty($pendaftaran_id)) {
        if(in_array(Yii::app()->user->getState('instalasi_id'), array(Params::INSTALASI_ID_LAB, Params::INSTALASI_ID_RAD, Params::INSTALASI_ID_IBS))){
          $modKunjungan = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id,'ruangan_id'=>Yii::app()->user->getState('ruangan_id')));
          $modKunjungan->pasienmasukpenunjang_id = $modKunjungan->pasienmasukpenunjang_id;
        }else{
          $modKunjungan = InfopasienpengunjungV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id,'ruangan_id'=>Yii::app()->user->getState('ruangan_id')));
        }
        

        if (!empty($modKunjungan->pasienadmisi_id)) { //replace dgn admisi
          $admisi = PasienadmisiT::model()->findByPk($modKunjungan->pasienadmisi_id);

          if(!empty($admisi)){
            $modKunjungan->instalasi_id = $admisi->ruangan->instalasi->instalasi_id;
            $modKunjungan->ruangan_id = $admisi->ruangan->ruangan_id;
            $modKunjungan->kelaspelayanan_id = $admisi->kelaspelayanan->kelaspelayanan_id;
            $modKunjungan->carabayar_id = $admisi->carabayar->carabayar_id;
            $modKunjungan->penjamin_id = $admisi->penjamin->penjamin_id;
            $modKunjungan->instalasi_nama = $admisi->ruangan->instalasi->instalasi_nama;
            $modKunjungan->ruangan_nama = $admisi->ruangan->ruangan_nama;
            $modKunjungan->kelaspelayanan_nama = $admisi->kelaspelayanan->kelaspelayanan_nama;
            $modKunjungan->carabayar_nama = $admisi->carabayar->carabayar_nama;
            $modKunjungan->penjamin_nama = $admisi->penjamin->penjamin_nama;
          }
        }
      }

      if(!empty($_POST['pendaftaran_id']) && !empty($_POST['Bmhp']) && !empty($_POST['Bmhpchild'])){
        $pendaftaran_id = $_POST['pendaftaran_id'];
        $pasienadmisi_id = (!empty($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null);
        $transaction = Yii::app()->db->beginTransaction();
        
        try {
          $modPendaftaran = PendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
          
          $modPendaftaran->carabayar_id = $_POST['carabayar_id'];
          $modPendaftaran->penjamin_id = $_POST['penjamin_id'];
          $modPendaftaran->pasienmasukpenunjang_id = (!empty($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null);
          $modPendaftaran->pasienadmisi_id = $pasienadmisi_id;
          $modPendaftaran->pasien_id = $_POST['pasien_id'];
          $modPendaftaran->kelaspelayanan_id = $_POST['kelaspelayanan_id'];
          
          foreach($_POST['Bmhp'] as $i => $bmhp){
            if(!empty($_POST['Bmhpchild'][$i])){
                foreach($_POST['Bmhpchild'][$i] as $j => $bmhpoa){
                    $modBmhp = $this->simpanBMHP($modPendaftaran,$bmhp, $bmhpoa);
                    $this->simpanStokObatAlkesOut2($modBmhp);
                }
            }
          }

          if ($this->obatalkespasientersimpan && $this->stokobatalkestersimpan) {
            $transaction->commit();
            $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id,'pasienadmisi_id'=> $pasienadmisi_id, 'sukses' => 1));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data pemakaian BMHP gagal disimpan !");
          }
        } catch (Exception $e) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pemakaian BMHP gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
        }
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(81);
      $this->render($this->path_view . 'index', array(
        'modKunjungan' => $modKunjungan,
        'modObatAlkesPasien' => $modObatAlkesPasien,
        'dataOas' => $dataOas,
        'linkHalaman' => $linkHalaman
      ));
  }

  public function actionInformasi($linkHalaman = null) {
    // if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(1236);
    // return PemakaianBahanController::actionInformasi($linkHalaman);
    $this->pageTitle = Yii::app()->name . " - Pemakaian Barang";
    $model = new RJObatalkesPasienT;
    $model->unsetAttributes();
    $format = new MyFormatter();
    //        $model->tglAwal = date('Y-m-d').' 00:00:00';
    //        $model->tglAkhir = date('Y-m-d').' 23:59:59';
    $model->tglAwal = date('Y-m-d');
    $model->tglAkhir = date('Y-m-d');
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
    if (isset($_GET['RJObatalkesPasienT'])) {
      $model->attributes = $_GET['RJObatalkesPasienT'];
      //            $model->tglAwal = MyFormatter::formatDateTimeForDb($_GET['LBObatalkespasienT']['tglAwal']).' 00:00:00';
      //            $model->tglAkhir = MyFormatter::formatDateTimeForDb($_GET['LBObatalkespasienT']['tglAkhir'].' 23:59:59');            
      $model->tglAwal = $format->formatDateTimeForDb($_GET['RJObatalkesPasienT']['tglAwal']);
      $model->tglAkhir = $format->formatDateTimeForDb($_GET['RJObatalkesPasienT']['tglAkhir']);
      $model->no_pendaftaran = $_GET['RJObatalkesPasienT']['no_pendaftaran'];
      $model->no_rekam_medik = $_GET['RJObatalkesPasienT']['no_rekam_medik'];
      $model->nama_pasien = $_GET['RJObatalkesPasienT']['nama_pasien'];
      $model->carabayar_id = $_GET['RJObatalkesPasienT']['carabayar_id'];
      $model->penjamin_id = $_GET['RJObatalkesPasienT']['penjamin_id'];

      $model->jenisobatalkes_id = $_GET['RJObatalkesPasienT']['jenisobatalkes_id'];
      $model->obatalkes_kategori = $_GET['RJObatalkesPasienT']['obatalkes_kategori'];
      $model->obatalkes_golongan = $_GET['RJObatalkesPasienT']['obatalkes_golongan'];
      $model->obatalkes_nama = $_GET['RJObatalkesPasienT']['obatalkes_nama'];
      $model->prefix_pendaftaran = isset($_GET['RJObatalkesPasienT']['prefix_pendaftaran']) ? $_GET['RJObatalkesPasienT']['prefix_pendaftaran'] : '';
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(1236);

    $this->render($this->path_view . 'informasi', array(
      'model' => $model,
      'linkHalaman' => $linkHalaman
    ));
}

  protected function simpanStokObatAlkesOut2($modObatAlkesPasien){
      $oa = ObatalkesM::model()->findByPk($modObatAlkesPasien->obatalkes_id);
      $modStokOaNew = new StokobatalkesT;
      $modStokOaNew->attributes = $oa->attributes;
      $modStokOaNew->attributes = $modObatAlkesPasien->attributes; //duplicate
      
      $modStokOaNew->qtystok_in = 0;
      $modStokOaNew->qtystok_out = $modObatAlkesPasien->qty_oa;
      $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
      
      $modStokOaNew->create_time = date('Y-m-d H:i:s');
      $modStokOaNew->update_time = $modStokOaNew->tglterima = date('Y-m-d H:i:s');
      $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
      $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
      $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

      $modStokOaNew->tglterima = $modObatAlkesPasien->tglpelayanan;
      $modStokOaNew->tglstok_out = $modObatAlkesPasien->tglpelayanan;

      if($modStokOaNew->validate()){ 
              $modStokOaNew->save();
      } else {
              $this->stokobatalkestersimpan &= false;
      }
      return $modStokOaNew;      
  }

  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;

      $returnVal = array();
      $returnVal['pesan'] = "";
      $criteria = new CDbCriteria();
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
      }
      if (!empty($pasienadmisi_id)) {
        $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
      }
      $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
      $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));
      $criteria->addCondition('instalasi_id = '.Yii::app()->user->getState('instalasi_id'));
      $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));

      if(in_array(Yii::app()->user->getState('instalasi_id'), array(Params::INSTALASI_ID_LAB, Params::INSTALASI_ID_RAD, Params::INSTALASI_ID_IBS))){
        $model = PasienmasukpenunjangV::model()->find($criteria);
        $returnVal["instalasi_id"] = $model->instalasiasal_id;
        $returnVal["ruangan_id"] = $model->ruanganasal_id;
        $returnVal["ruangan_nama"] = $model->ruanganasal_nama;
        $returnVal["instalasi_nama"] = $model->instalasiasal_nama;
      }else{
        $model = InfopasienpengunjungV::model()->find($criteria);
      }
      

      $loadHasilPemeriksaan = HasilpemeriksaanlabT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
      if (!empty($loadHasilPemeriksaan)) {
        if (strtolower(trim($loadHasilPemeriksaan->statusperiksahasil)) == strtolower(Params::STATUSPERIKSAHASIL_SUDAH)) {
          $returnVal['pesan'] = "Pasien dengan status sudah diperiksa tidak bisa menggunakan obat / alat kesehatan !";
        }
      }

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

      $returnVal['pasienmasukpenunjang_id'] = "";

      if(in_array(Yii::app()->user->getState('instalasi_id'), array(Params::INSTALASI_ID_LAB, Params::INSTALASI_ID_RAD, Params::INSTALASI_ID_IBS))){
        $modPasienpenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id,'pasienadmisi_id'=>$model->pasienadmisi_id,'ruangan_id'=>Yii::app()->user->getState('ruangan_id')));

        if(!empty($modPasienpenunjang)){
          $returnVal['pasienmasukpenunjang_id'] = $modPasienpenunjang->pasienmasukpenunjang_id;
        }
      }

      if (!empty($model->pasienadmisi_id)) { //replace dgn admisi
        $admisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);

        if(!empty($admisi)){
          $returnVal["instalasi_id"] = $admisi->ruangan->instalasi->instalasi_id;
          $returnVal["ruangan_id"] = $admisi->ruangan->ruangan_id;
          $returnVal["kelaspelayanan_id"] = $admisi->kelaspelayanan->kelaspelayanan_id;
          $returnVal["carabayar_id"] = $admisi->carabayar->carabayar_id;
          $returnVal["penjamin_id"] = $admisi->penjamin->penjamin_id;
          $returnVal["instalasi_nama"] = $admisi->ruangan->instalasi->instalasi_nama;
          $returnVal["ruangan_nama"] = $admisi->ruangan->ruangan_nama;
          $returnVal["kelaspelayanan_nama"] = $admisi->kelaspelayanan->kelaspelayanan_nama;
          $returnVal["carabayar_nama"] = $admisi->carabayar->carabayar_nama;
          $returnVal["penjamin_nama"] = $admisi->penjamin->penjamin_nama;

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

        
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionPrint($pendaftaran_id, $pasienadmisi_id = null)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    if(!empty($pasienadmisi_id)){
      $modAdmisi = PasienadmisiT::model()->findByAttributes(array('pasienadmisi_id'=>$pasienadmisi_id));

      if(!empty($modAdmisi)){
        $modPendaftaran->kelaspelayanan_nama = $modAdmisi->kelaspelayanan->kelaspelayanan_nama;
        $modPendaftaran->carabayar_nama = $modAdmisi->carabayar->carabayar_nama;
        $modPendaftaran->penjamin_nama = $modAdmisi->penjamin->penjamin_nama;
        $modPendaftaran->ruangan_nama = $modAdmisi->ruangan->ruangan_nama;
      }
    }else{
      $pasienadmisi_id = null;
    }
    $pasienmasukpenunjang_id = null;
    if(in_array(Yii::app()->user->getState('instalasi_id'), array(Params::INSTALASI_ID_LAB, Params::INSTALASI_ID_RAD, Params::INSTALASI_ID_IBS))){
      $modPasienpenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id,'ruangan_id'=>Yii::app()->user->getState('ruangan_id')));

      if(!empty($modPasienpenunjang)){
        $pasienmasukpenunjang_id =$modPasienpenunjang->pasienmasukpenunjang_id;
      }
    }

    $modObatAlkesPasien = ObatalkespasienT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id, 'ruangan_id'=>Yii::app()->user->getState('ruangan_id')));

    $modDetails = array();

        if(!empty($modObatAlkesPasien)){
            foreach($modObatAlkesPasien as $oap){
                $modTipepaket = TipepaketM::model()->findByPk($oap->tipepaket_id);
                $modAlkes = ObatalkesM::model()->findByPk($oap->obatalkes_id);

                $modDetails[$oap->tipepaket_id]['tipepaket_id'] = $oap->tipepaket_id;
                $modDetails[$oap->tipepaket_id]['tipepaket_nama'] = $modTipepaket->tipepaket_nama;
                $modDetails[$oap->tipepaket_id]['tglpelayanan'] = MyFormatter::formatDateTimeForUser($oap->tglpelayanan);
                $modDetails[$oap->tipepaket_id]['detail'][] = array(
                                                                'obatalkes_nama'=>$modAlkes->obatalkes_nama,
                                                                'jenisobatalkes_nama'=>$modAlkes->jenisobatalkes->jenisobatalkes_nama,
                                                                'hargasatuan_oa'=>$oap->hargasatuan_oa,
                                                                'qty'=>$oap->qty_oa,
                                                                'hargajual'=>$oap->hargajual_oa,
                                                                'satuankecil'=>(!empty($oap->satuankecil)?$oap->satuankecil->satuankecil_nama:"")
                                                            );
            }
        }


    $judul_print = 'RINCIAN PEMAKAIAN BAHAN PASIEN';

    $this->render($this->path_view . 'printPemakaianBahan', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPendaftaran' => $modPendaftaran,
      'modDetails' => $modDetails,
    ));
  }

  public function actionSetLoadBahanMedis(){
    if(Yii::app()->request->isAjaxRequest) { 
        $tipepaket_id = (!empty($_GET['tipepaket_id']) ? $_GET['tipepaket_id'] : null);
        $isbukanbebanpasien = (!empty($_GET['isbukanbebanpasien']) ? $_GET['isbukanbebanpasien'] : false);
        $obatalkes_id = (!empty($_GET['obatalkes_id']) ? $_GET['obatalkes_id'] : null);
        $qtypakaibahan = (!empty($_GET['qtypakaibahan']) ? MyFormatter::formatNumberForDb($_GET['qtypakaibahan']) : 1);
        $form = "";

        $modTipepaket = TipepaketM::model()->findByPk($tipepaket_id);
        $details = array();
        $stoktidakcukup = false;
        $namapesan = "";

        if($modTipepaket->isnonpaket == true){
            $modAlkes = ObatalkesM::model()->findByPk($obatalkes_id);
            $harga = (($isbukanbebanpasien == 1)? 0 : $modAlkes->hargajual);
            $details[$modTipepaket->tipepaket_id]['tipepaket_id'] = $modTipepaket->tipepaket_id;
            $details[$modTipepaket->tipepaket_id]['tipepaket_nama'] = $modTipepaket->tipepaket_nama;
            $details[$modTipepaket->tipepaket_id]['detail'][] = array(
                                                            'obatalkes_id'=>$modAlkes->obatalkes_id,
                                                            'obatalkes_nama'=>$modAlkes->obatalkes_nama,
                                                            'jenisobatalkes_nama'=>$modAlkes->jenisobatalkes->jenisobatalkes_nama,
                                                            'tglkadaluarsa'=>MyFormatter::formatDateTimeForUser($modAlkes->activedate),
                                                            'hargajual'=>$harga,
                                                            'qty'=>$qtypakaibahan,
                                                            'satuankecil'=>(!empty($modAlkes->satuankecil)?$modAlkes->satuankecil->satuankecil_nama:"")
                                                        );
            $jmlstok = StokobatalkesT::getJumlahStok($modAlkes->obatalkes_id, Yii::app()->user->getState("ruangan_id"));
            $namapesan = "Nama Bahan Medis '".$modAlkes->obatalkes_nama."'";                                            
            if($jmlstok < $qtypakaibahan){
                $stoktidakcukup = true;
            }                                      

        }else{
            $modBmhp = PaketbmhpM::model()->findAllByAttributes(array('tipepaket_id'=>$modTipepaket->tipepaket_id));
            $namapesan = "Tipe Paket '".$modTipepaket->tipepaket_nama."'";
            if(!empty($modBmhp)){
                $isstok = 0;
                foreach($modBmhp as $bmhp){
                    $jmlstok = StokobatalkesT::getJumlahStok($bmhp->obatalkes->obatalkes_id, Yii::app()->user->getState("ruangan_id"));

                    if($jmlstok < $bmhp->qtypemakaian){
                        $isstok += 1;
                    }else{
                        if($isstok > 0){
                            $isstok -= 1;
                        }
                    }
                    
                    $harga = (($isbukanbebanpasien == 1)? 0 : $bmhp->obatalkes->hargajual);
                    $details[$bmhp->tipepaket_id]['tipepaket_id'] = $bmhp->tipepaket_id;
                    $details[$bmhp->tipepaket_id]['tipepaket_nama'] = $bmhp->tipepaket->tipepaket_nama;
                    $details[$bmhp->tipepaket_id]['detail'][] = array(
                                                                    'obatalkes_id'=>$bmhp->obatalkes->obatalkes_id,
                                                                    'obatalkes_nama'=>$bmhp->obatalkes->obatalkes_nama,
                                                                    'jenisobatalkes_nama'=>$bmhp->obatalkes->jenisobatalkes->jenisobatalkes_nama,
                                                                    'tglkadaluarsa'=>MyFormatter::formatDateTimeForUser($bmhp->obatalkes->activedate),
                                                                    'hargajual'=>$harga,
                                                                    'qty'=>$bmhp->qtypemakaian,
                                                                    'satuankecil'=>(!empty($bmhp->obatalkes->satuankecil)?$bmhp->obatalkes->satuankecil->satuankecil_nama:"")
                                                                );

                    

                }

                if($isstok > 0){
                    $stoktidakcukup = true;
                }
            }
        }

        $pesan = "";
        if($stoktidakcukup == false){
            if(!empty($details)){
                foreach($details as $detail){
                    $form = $this->renderPartial($this->path_view.'_rowBmhp',array('detail'=>$detail),true);
                }
            }
        }else{
            $pesan = $namapesan." Stoknya Tidak Mencukupi !!";
        }

        $data['html']=$form;
        $data['pesan']=$pesan;
        echo json_encode($data);
        Yii::app()->end();
    }
}

  public function simpanBMHP($modPendaftaran ,$postParent,$postChild){        
      $oa = ObatalkesM::model()->findByPk($postChild['obatalkes_id']);
      $modOap = new ObatalkespasienT;
      $modOap->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $modOap->tipepaket_id = $postParent['tipepaket_id'];
      $modOap->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modOap->carabayar_id = $modPendaftaran->carabayar_id;
      $modOap->penjamin_id = $modPendaftaran->penjamin_id;
      $modOap->pegawai_id = $modPendaftaran->pegawai_id;
      $modOap->shift_id = Yii::app()->user->getState('shift_id');
      $modOap->pasienmasukpenunjang_id = $modPendaftaran->pasienmasukpenunjang_id;
      $modOap->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
      $modOap->pasien_id = $modPendaftaran->pasien_id;
      $modOap->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;

      $modOap->obatalkes_id = $postChild['obatalkes_id'];
      $modOap->satuankecil_id = $oa->satuankecil_id;
      $modOap->sumberdana_id = $oa->sumberdana_id;
      $modOap->tglpelayanan = MyFormatter::formatDateTimeForDB($postParent['tgl_pelayanan']);
      $modOap->qty_oa = $postChild['qty'];
      $modOap->hargasatuan_oa = $postChild['hargajual'];
      $modOap->harganetto_oa = $oa->harganetto;
      $modOap->hargajual_oa = $postChild['subtotal'];
      $modOap->oa = "BM";
      $modOap->create_loginpemakai_id = Yii::app()->user->id;
      $modOap->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modOap->create_time = date ('Y-m-d H:i:s');
    
    
  if($modOap->save()){
    $this->obatalkespasientersimpan &= true;
          $tersimpanjurnalDet = true;
        
          if(Yii::app()->user->getState('isjurnalotomatis') == true){
              $rek_jnspers = JnsobatalkesrekM::model()->findAllByAttributes(array('jenisobatalkes_id'=>$modOap->obatalkes->jenisobatalkes_id,'ispemakaianbhppasien'=>true,'ruangan_id'=>$modOap->ruangan_id),array('order'=>'debitkredit ASC'));
              
              if(!empty($rek_jnspers) && $modOap->hargajual_oa > 0){
                  $modJurnalPers = $this->saveJurnalRekeningBMHP($modOap,'persediaan');
                  $urutPers = 0;

                  if(!empty($rek_jnspers)){
                      foreach($rek_jnspers as $rekpers){
                          $urutPers += 1;
                          if($rekpers->debitkredit == 'D'){
                              $saldodebit = $modOap->hargajual_oa;
                              $saldikredit = 0;
                          }else{
                              $saldodebit = 0;
                              $saldikredit = $modOap->hargajual_oa;
                          }
                          $tersimpanjurnalDet = $this->saveJurnalDetailBMHP($modJurnalPers, $rekpers->rekening5_id, $saldodebit ,$saldikredit,$urutPers);
                      }
                  }
              }

              $rek_jnsstok = JnsobatalkesrekM::model()->findAllByAttributes(array('jenisobatalkes_id'=>$modOap->obatalkes->jenisobatalkes_id,'isstokberkurangoa'=>true,'ruangan_id'=>$modOap->ruangan_id),array('order'=>'debitkredit ASC'));

              if(!empty($rek_jnsstok) && (($modOap->harganetto_oa * $modOap->qty_oa) > 0)){
                  $modJurnalStok = $this->saveJurnalRekeningBMHP($modOap,'stok');
                  $urutStok = 0;

                  if(!empty($rek_jnsstok)){
                      foreach($rek_jnsstok as $rekstok){
                          $urutStok += 1;
                          if($rekstok->debitkredit == 'D'){
                              $saldodebit = ($modOap->harganetto_oa * $modOap->qty_oa);
                              $saldikredit = 0;
                          }else{
                              $saldodebit = 0;
                              $saldikredit = ($modOap->harganetto_oa * $modOap->qty_oa);
                          }
                          $tersimpanjurnalDet = $this->saveJurnalDetailBMHP($modJurnalStok, $rekstok->rekening5_id, $saldodebit, $saldikredit, $urutStok);
                      }
                  }
              }
          }

          if($this->succesSave == false && $tersimpanjurnalDet == false){
              $this->obatalkespasientersimpan &= false;
          }

    }else{
      $this->obatalkespasientersimpan &= false;
    }

    return $modOap;
  }

  protected function saveJurnalRekeningBMHP($model, $type)
  {
      $period = Yii::app()->user->getState('periode_ids');
      if (is_array($period)) {
          $period = $period[0];
      }
      $jenisjurnal =  Params::JENISJURNAL_ID_PERSEDIAAN;
      $urian = "PENGURANGAN STOK";

      if($type == 'persediaan'){
          $jenisjurnal =  Params::JENISJURNAL_ID_PELAYANAN;
          $urian = "PEMAKAIAN BAHAN PASIEN";
      }

      $format = new MyFormatter();
      $modJurnalRekening = new JurnalrekeningT;
      $modJurnalRekening->jenisjurnal_id = $jenisjurnal;
      $modJurnalRekening->tglbuktijurnal = $format->formatDateTimeForDB($model->tglpelayanan);
      $modJurnalRekening->nobuktijurnal = MyGenerator::noBuktiJurnalRek();
      $modJurnalRekening->kodejurnal = MyGenerator::kodeJurnalRek();
      $modJurnalRekening->noreferensi = $model->pendaftaran->no_pendaftaran;
      $modJurnalRekening->tglreferensi = $format->formatDateTimeForDB($model->tglpelayanan);
      $modJurnalRekening->nobku = "";
      $modJurnalRekening->urianjurnal = $model->pendaftaran->no_pendaftaran .' - '.$model->pendaftaran->pasien->nama_pasien .' - '. $urian .' '.$model->ruangan->ruangan_nama .' '.$model->obatalkes->obatalkes_nama;

      $periodeID = $period;
      $modJurnalRekening->rekperiod_id = $periodeID;
      $modJurnalRekening->create_time = date('Y-m-d H:i:s');
      $modJurnalRekening->create_loginpemakai_id = Yii::app()->user->id;
      $modJurnalRekening->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modJurnalRekening->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modJurnalRekening->obatalkespasien_id = $model->obatalkespasien_id;

      if($modJurnalRekening->validate()){
          if($modJurnalRekening->save()){
            ObatalkespasienT::model()->updateByPk($model->obatalkespasien_id, array('jurnalrekening_id'=>$modJurnalRekening->jurnalrekening_id));
            $this->succesSave = true;
          }
      } else {
          $this->succesSave = false;
      }
      return $modJurnalRekening;
  }

  public function saveJurnalDetailBMHP($modJurnalRekening, $rekening5_id, $saldodebit, $saldokredit, $nourut){
      $valid = true;

      $modelJurnalDetail = new JurnaldetailT();
      $modelJurnalDetail->rekperiod_id = $modJurnalRekening->rekperiod_id;
      $modelJurnalDetail->jurnalrekening_id = $modJurnalRekening->jurnalrekening_id;
      $modelJurnalDetail->rekening5_id = $rekening5_id;
      $modelJurnalDetail->uraiantransaksi = $modJurnalRekening->urianjurnal;
      $modelJurnalDetail->nourut = $nourut;
      $modelJurnalDetail->saldodebit = $saldodebit;
      $modelJurnalDetail->saldokredit = $saldokredit;

      if($modelJurnalDetail->validate()){
          $modelJurnalDetail->save();
      }else{
          $valid = false;
      }

      return $valid;
  }

  public function actionHapusRiwayatBMHP()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $tipepaket_id = (!empty($_POST['tipepaket_id'])? $_POST['tipepaket_id'] : null);
      $pendaftaran_id = (!empty($_POST['pendaftaran_id'])? $_POST['pendaftaran_id'] : null);
      $pasienadmisi_id = (!empty($_POST['pasienadmisi_id'])? $_POST['pasienadmisi_id'] : null);
      $ruangan_id = (!empty($_POST['ruangan_id'])? $_POST['ruangan_id'] : null);

      $pasienmasukpenunjang_id = null;
      if(in_array(Yii::app()->user->getState('instalasi_id'), array(Params::INSTALASI_ID_LAB, Params::INSTALASI_ID_RAD, Params::INSTALASI_ID_IBS))){
        $modPasienpenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id,'ruangan_id'=>$ruangan_id));

        if(!empty($modPasienpenunjang)){
          $pasienmasukpenunjang_id =$modPasienpenunjang->pasienmasukpenunjang_id;
        }
      }

      $modObatAlkesPasien = ObatalkespasienT::model()->findAllByAttributes(array('tipepaket_id' => $tipepaket_id,'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id, 'ruangan_id'=>$ruangan_id));


      $data['pesan'] = "";
      $data['sukses'] = 0;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $terdelete = true;
        if(!empty($modObatAlkesPasien)){
          foreach($modObatAlkesPasien as $dataOa){
            $loadObatAlkesPasien = ObatalkespasienT::model()->findByPk($dataOa->obatalkespasien_id);
            $kembalikanstok = $this->kembalikanStok($loadObatAlkesPasien);

            if ($kembalikanstok) {
              if (!$dataOa->delete()) {
                $terdelete = false;
              }
            }else{
              $terdelete = false;
            }
            
          }
        }

        
        if ($terdelete == true) {
          $transaction->commit();
          $data['pesan'] = "Pemakaian Bahan berhasil dihapus!";
          $data['sukses'] = 1;
        } else {
          $transaction->rollback();
          $data['pesan'] = "Pemakaian Bahan gagal dihapus!";
          $data['sukses'] = 0;
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['pesan'] = "Pemakaian Bahan gagal dihapus :" . MyExceptionMessage::getMessage($exc, true);
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  protected function kembalikanStok($modObatAlkesPasien)
  {
    StokobatalkesT::model()->deleteAllByAttributes(array(
      'obatalkespasien_id' => $modObatAlkesPasien->obatalkespasien_id,
    ));
    return true;
  }
}
