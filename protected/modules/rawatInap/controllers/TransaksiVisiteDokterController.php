<?php

class TransaksiVisiteDokterController extends MyAuthController
{
  public $succesSave = false;

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Visite Dokter";
    $format = new MyFormatter();
    $model = new RIInfopasienmasukkamarV('searchRIVisiteDokter');
    $model->is_dokter = 0;
    // $model = new RIPasienrawatinapV;
    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $criteria = new CDbCriteria;
    $criteria->compare('modul_id', $modul_id);
    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
    if (isset($_POST['tujuansms'])) {
      $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
    }
    $modSmsgateway = SmsgatewayM::model()->findAll($criteria);


    if (isset($_POST['RITindakanPelayananT'])) {
      $jumlahPasien = count((array)$_POST['RITindakanPelayananT']);
      $jumlahCeklist = 0;
      $jumlahTersimpan = 0;
      //               echo '<pre>'.print_r($_POST['RITindakanPelayananT'],1).'</pre>';
      //               echo $jumlahPasien;exit;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        // var_dump($_POST); die;
        if ($jumlahPasien > 0) {
          foreach ($_POST['RITindakanPelayananT'] as $i => $detail) {
            if ($_POST['RITindakanPelayananT'][$i]['dipilih'] == 'Ya') { //Jika Diceklist   
              $modelTarifTindakan = TariftindakanM::model()->find(
                'daftartindakan_id = ' . $_POST['RITindakanPelayananT'][$i]['daftartindakan_id'] . ' AND kelaspelayanan_id =' . $_POST['RIInfopasienmasukkamarV'][$i]['kelaspelayanan_id'] . ''
              );
              $jumlahCeklist++;
              $modTindakans = new RITindakanPelayananT;
              $modTindakans->penjamin_id = $_POST['RITindakanPelayananT'][$i]['penjamin_id'];
              $modTindakans->pasienadmisi_id = $_POST['RITindakanPelayananT'][$i]['pasienadmisi_id'];
              $modTindakans->pasien_id = $_POST['RITindakanPelayananT'][$i]['pasien_id'];
              $modTindakans->kelaspelayanan_id = $_POST['RIInfopasienmasukkamarV'][$i]['kelaspelayanan_id'];
              $modTindakans->instalasi_id = Yii::app()->user->getState('instalasi_id');
              $modTindakans->pendaftaran_id = $_POST['RITindakanPelayananT'][$i]['pendaftaran_id'];
              $modTindakans->shift_id = Yii::app()->user->getState('shift_id');
              $modTindakans->daftartindakan_id = $_POST['RITindakanPelayananT'][$i]['daftartindakan_id'];
              $modTindakans->carabayar_id = $_POST['RITindakanPelayananT'][$i]['carabayar_id'];
              $modTindakans->jeniskasuspenyakit_id = $_POST['RITindakanPelayananT'][$i]['jeniskasuspenyakit_id'];
              $modTindakans->tgl_tindakan = $format->formatDateTimeForDb(trim($_POST['tanggalVisite']));
              //                            $modTindakans->dokterpemeriksa1_id = $_POST['RITindakanPelayananT']['pegawai_id'][$i];
              if ($modTindakans->daftartindakan_id == Params::DAFTARTINDAKAN_ID_VISITE_PERAWAT) {
                $modTindakans->perawat_id = $_POST['RIInfopasienmasukkamarV']['pegawai_id'];
              } else {
                $modTindakans->dokterpemeriksa1_id = $_POST['RIInfopasienmasukkamarV']['pegawai_id'];
              }
              $modTindakans->ruangan_id = Yii::app()->user->getState('ruangan_id');
              $modTindakans->tarif_tindakan = !empty($modelTarifTindakan->harga_tariftindakan) ? $modelTarifTindakan->harga_tariftindakan : 0;
              $modTindakans->satuantindakan = Params::SATUAN_TINDAKAN_VISITE; //'KALI';
              $modTindakans->qty_tindakan = 1;
              $modTindakans->cyto_tindakan = 0;
              $modTindakans->tarifcyto_tindakan = 0;
              $modTindakans->discount_tindakan = 0;
              $modTindakans->pembebasan_tindakan = 0;
              $modTindakans->subsidiasuransi_tindakan = 0;
              $modTindakans->subsidipemerintah_tindakan = 0;
              $modTindakans->subsisidirumahsakit_tindakan = 0;
              $modTindakans->iurbiaya_tindakan = 0;
              $modTindakans->tm = 'TM';
              $modTindakans->create_time = date('Y-m-d H:i:s');
              $modTindakans->create_loginpemakai_id = Yii::app()->user->id;
              $modTindakans->create_ruangan = Yii::app()->user->getState('ruangan_id');

              // var_dump($modTindakans->attributes); die;			
              if ($modTindakans->save()) {
                // SMS GATEWAY
                /*
                                $modPegawai = $modTindakans->dokter1;
                                $modPasien = $modTindakans->pasien;
                                $modRuangan = $modTindakans->ruangan;
                                $sms = new Sms();
                                foreach ($modSmsgateway as $i => $smsgateway){
                                    $isiPesan = $smsgateway->templatesms;

                                    $attributes = $modPasien->getAttributes();
                                    foreach($attributes as $attributes => $value){
                                        $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                    }
                                    $attributes = $modRuangan->getAttributes();
                                    foreach($attributes as $attributes => $value){
                                        $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                    }
                                    $attributes = $modTindakans->getAttributes();
                                    foreach($attributes as $attributes => $value){
                                        $isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
                                    }

                                    $isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($modTindakans->tgl_tindakan),$isiPesan);
                                    

            
                                    if($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms){
                                        if(!empty($modPasien->no_mobile_pasien)){
                                            $sms->kirim($modPasien->no_mobile_pasien,$isiPesan);
                                        }
                                    }elseif($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms){
                                        if(!empty($modPegawai->nomobile_pegawai)){
                                            $sms->kirim($modPegawai->nomobile_pegawai,$isiPesan);
                                        }
                                    }
                                }
                                // END SMS GATEWAY
                                 * 
                                 */
                $jumlahTersimpan++;
                $this->saveTindakanKomponen($modTindakans);
              }
              //var_dump($modTindakans->attributes);
            }
          }
          //die;
          if ($jumlahCeklist == $jumlahTersimpan) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data Berhasil disimpan ");
            $this->redirect(array('index', 'sukses' => 1));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan " . '<pre>' . print_r($modTindakans->getErrors(), 1) . '</pre>');
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    if (isset($_POST['RIInfopasienmasukkamarV'])) {
      $model->unsetAttributes();
      $model->attributes = $_POST['RIInfopasienmasukkamarV'];
      $model->no_rekam_medik = $_POST['RIInfopasienmasukkamarV']['no_rekam_medik'];
      $model->nama_pasien = $_POST['RIInfopasienmasukkamarV']['nama_pasien'];
      if ($_POST['RIInfopasienmasukkamarV']['is_dokter'] == 1) {
        $model->nama_pegawai = $_POST['RIInfopasienmasukkamarV']['nama_pegawai'];
      } else {
        $model->nama_pegawai = '';
      }
    }

    $this->render('index', array('model' => $model, 'format' => $format));
  }

  public function saveTindakanKomponen($modTindakans)
  {
    $tindakankomponentersimpan = true;

    $jenis = JenistarifpenjaminM::model()->findByAttributes(array(
      'penjamin_id' => $modTindakans->penjamin_id,
    ));
    $komponen = TariftindakanM::model()->findAllByAttributes(array(
      'kelaspelayanan_id' => $modTindakans->kelaspelayanan_id,
      'jenistarif_id' => $jenis->jenistarif_id,
      'daftartindakan_id' => $modTindakans->daftartindakan_id,
      'perdatarif_id' => 1,
    ), array(
      'condition' => 'komponentarif_id <> 6',
    ));

    //var_dump(count((array)$komponen));

    $total = 0;
    $satuan = 0;


    foreach ($komponen as $item) {
      // var_dump($item->attributes);
      $tarif = new TindakankomponenT();
      $tarif->tindakanpelayanan_id = $modTindakans->tindakanpelayanan_id;
      $tarif->komponentarif_id = $item->komponentarif_id;
      $tarif->tarif_kompsatuan = $item->harga_tariftindakan;
      $tarif->tarif_tindakankomp = $tarif->tarif_kompsatuan * $modTindakans->qty_tindakan;
      $tarif->tarifcyto_tindakankomp = 0;
      $tarif->subsidiasuransikomp = 0;
      $tarif->subsidipemerintahkomp = 0;
      $tarif->subsidirumahsakitkomp = 0;
      $tarif->iurbiayakomp = $tarif->tarif_tindakankomp;

      if ($tarif->save()) {
        $satuan += $tarif->tarif_kompsatuan;
        $total += $tarif->tarif_tindakankomp;
      } else {
        $tindakankomponentersimpan = false;
      }
    }

    $modTindakans->tarif_satuan = $satuan;
    $modTindakans->tarif_tindakan = $modTindakans->iurbiaya_tindakan = $total;

    return $tindakankomponentersimpan && $modTindakans->save();
  }

  //        public function saveTindakan()
  //        {
  //            $format = new MyFormatter();
  //            $post = $_POST['RITindakanPelayanan'];
  //            $valid=true; //echo $_POST['RJTindakanPelayananT'][0]['tipepaket_id'];exit;
  //            foreach($post as $i=>$item)
  //            {
  //                
  //                if(!empty($item)){
  //                    if($item['ceklist']=='1'){
  //                        $modTindakans[$i] = new RITindakanPelayananT;
  //                        $modTindakans[$i]->attributes=$item;
  //                        $modTindakans[$i]->penjamin_id = $item['penjamin_id'];
  //                        $modTindakans[$i]->pasienadmisi_id = $item['pasienadmisi_id'];
  //                        $modTindakans[$i]->pasien_id = $item['pasien_id'];
  //                        $modTindakans[$i]->kelaspelayanan_id = $item['kelaspelayanan_id'];
  //                        $modTindakans[$i]->instalasi_id = Yii::app()->user->getState('instalasi_id');
  //                        $modTindakans[$i]->pendaftaran_id = $item['pendaftaran_id'];
  //                        $modTindakans[$i]->shift_id = Yii::app()->user->getState('shift_id');
  //                        $modTindakans[$i]->daftartindakan_id = $items['daftartindakan_id'];
  //                        $modTindakans[$i]->carabayar_id = $item['carabayar_id'];
  //                        $modTindakans[$i]->jeniskasuspenyakit_id = $item['jeniskasuspenyakit_id'];
  //                        $modTindakans[$i]->tgl_tindakan = $format->formatDateTimeForDb(trim($_POST['tanggalVisite']));
  //                        $modTindakans[$i]->dokterpemeriksa1_id = $item['pegawai_id'];
  //                        $modTindakans[$i]->tarif_satuan = $modTindakans[$i]->getTarifSatuan(); //RND-7250
  //                        $modTindakans[$i]->tarif_tindakan = $modTindakans[$i]->tarif_satuan * $modTindakans[$i]->qty_tindakan;
  //                        if(!$modTindakans[$i]->cyto_tindakan){ //false
  //							$modTindakans[$i]->tarifcyto_tindakan = 0;
  //						}else{
  //							$modTindakans[$i]->tarifcyto_tindakan = $modTindakans[$i]->tarif_tindakan + ($modTindakans[$i]->tarif_tindakan * 10 / 100);
  //						}
  //                        $modTindakans[$i]->discount_tindakan = 0;
  //                        $modTindakans[$i]->subsidiasuransi_tindakan = 0;
  //                        $modTindakans[$i]->subsidipemerintah_tindakan = 0;
  //                        $modTindakans[$i]->subsisidirumahsakit_tindakan = 0;
  //                        $modTindakans[$i]->iurbiaya_tindakan = 0;
  //                        
  //                        $valid = $modTindakans[$i]->validate() && $valid;
  //                    }   
  //                }
  //            }
  //
  //            $transaction = Yii::app()->db->beginTransaction();
  //            try {
  //                if($valid){
  //                    foreach($modTindakans as $i=>$tindakan){
  //                        if($tindakan->save()){
  //	                        $statusSaveKomponen = $tindakan->saveTindakanKomponen();
  //						}
  //                    }
  //                    if($statusSaveKomponen) {
  //                        $transaction->commit();
  //                        $this->succesSave = true;
  //                        Yii::app()->user->setFlash('success',"Data Berhasil disimpan");
  //						$this->redirect(array('admin'));
  //                    } else {
  //                        $transaction->rollback();
  //                        Yii::app()->user->setFlash('error',"Data tidak valid  1");
  //                    }
  //                } else {
  //                    $transaction->rollback();
  //                    Yii::app()->user->setFlash('error',"Data tidak valid 2");
  //                }
  //            } catch (Exception $exc) {
  //                $transaction->rollback();
  //                Yii::app()->user->setFlash('error',"Data Gagal disimpan. ".MyExceptionMessage::getMessage($exc,true));
  //            }
  //            
  //            return $modTindakans;
  //        }


  public function actionGetTarifTindakan()
  {

    if (Yii::app()->request->isAjaxRequest) {
      $daftartindakan_id = $_POST['daftartindakan_id'];
      $kelaspelayanan_id = $_POST['kelaspelayanan_id'];

      $modelTarifTindakan = TariftindakanM::model()->find('daftartindakan_id = ' . $daftartindakan_id . ' AND kelaspelayanan_id =' . $kelaspelayanan_id . '');
      if (!empty($modelTarifTindakan)) {
        $data['status'] = 'Ada';
        //$data['tarif_tindakan'] = $modelTarifTindakan->harga_tariftindakan;
      } else {
        $data['status'] = 'Tidak';
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetDaftarTindakanVisite()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
      $criteria->compare('daftartindakan_visite', TRUE);
      $criteria->order = 'daftartindakan_nama';
      $criteria->limit = 10;
      $models = DaftartindakanM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->daftartindakan_id . '-' . $model->daftartindakan_nama;
        $returnVal[$i]['value'] = $model->daftartindakan_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionLoadFormVisiteDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';

      $pegawai_id  = $_POST['pegawai_id'];
      $no_rekam_medik = (isset($_POST['no_rekam_medik'])) ? $_POST['no_rekam_medik'] : null;
      $nama_pasien = (isset($_POST['no_rekam_medik'])) ? $_POST['nama_pasien'] : null;
      $jenis_visite = (isset($_POST['jenis_visite'])) ? $_POST['jenis_visite'] : null;
      $ruangan = Yii::app()->user->getState('ruangan_id');
      $kelaspelayananruangan = Yii::app()->user->getState('kelaspelayananruangan');
      $pilih = $_POST['pilih'] ? $_POST['pilih'] : null;
      $nama = "";

      $modTindakans = new RITindakanPelayananT;
      $criteria = new CDbCriteria;


      if ($pilih == 1) {
        $p = PegawaiM::model()->findByPk($pegawai_id);
        $nama = $p->nama_pegawai;
        $criteria->compare('lower(nama_pegawai)', strtolower($nama), true);
      }


      $criteria->addCondition('ruangan_id = ' . $ruangan);
      /*
            if(!empty($kelaspelayananruangan)){
                    $criteria->addInCondition("kelaspelayanan_id",$kelaspelayananruangan); 	
                    if (is_array($kelaspelayananruangan)){
                            $criteria->addInCondition("kelaspelayanan_id",$kelaspelayananruangan); 	
                    }else{
                            $criteria->addCondition("kelaspelayanan_id = ".$kelaspelayananruangan); 	
                    }
            }
             * 
             */

      $criteria->compare('lower(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('lower(nama_pasien)', strtolower($nama_pasien), true);
      $modInformasiVisite = RIInfopasienmasukkamarV::model()->findAll($criteria);
      if (count((array)$modInformasiVisite) == 0) {
        $pesan = 'Data Tidak Ada !';
      }



      echo CJSON::encode(
        array(
          'status' => 'create_form',
          'pesan' => $pesan,
          'form' => $this->renderPartial(
            '_rowVisiteDokter',
            array(
              //'format'=>$format,
              'modInformasiVisite' => $modInformasiVisite,
              'modTindakans' => $modTindakans,
              'pegawai_id' => $pegawai_id,
              'jenis_visite' => $jenis_visite
            ),
            true
          )
        )
      );
      exit;
    }
  }

  /**
   * 
   */
  public function actionCekDokter()
  {

    if (Yii::app()->request->isAjaxRequest) {
      $daftartindakan_id = $_POST['daftartindakan_id'];
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $pegawai_id = $_POST['pegawai_id'];
      $data['sukses']  = 1;

      $cekPen = RIInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      $cekTin = TindakanpelayananT::model()->find("pendaftaran_id = " . $pendaftaran_id . " AND daftartindakan_id = " . $daftartindakan_id . " AND date(tgl_tindakan) = '" . date('Y-m-d') . "' "); // AND dokterpemeriksa1_id = '.$pegawai_id.

      if (!empty($cekTin)) {
        //if ($cekTin->dokterpemeriksa1_id == $cekPen->pegawai_id){ //periksa dokter penanggung jawab                
        if ($cekTin->daftartindakan_id == Params::DAFTARTINDAKAN_ID_KONSUL_SPESIALIS) { //daftar tindakan untuk kunjungan spesialis (penanggung jawab)
          if (date('Y-m-d', strtotime($cekTin->tgl_tindakan)) == date('Y-m-d')) {
            $data['status'] = 'ada';
          } else {
            $data['status'] = 'tidak-';
          }
        } else {
          $data['status'] = 'tidak';
        }
      } else {
        $data['status'] = 'tidak';
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
