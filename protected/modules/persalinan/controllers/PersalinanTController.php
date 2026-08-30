<?php

class PersalinanTController extends MyAuthController
{
  public $path_view = 'persalinan.views.persalinanT.';
  public $layout = '//layouts/column1';

  /**
   * Notes:
   * - Data Pemeriksaan dapat disubmit meskipun ketika input pada tab dalam keadaan 'kosong'
   * - Data Persalinan harus diisi agar bisa melakukan pemeriksaan Obstretikus
   * - Data Ginekologi dapat diinput walaupun data Persalinan/Obstretikus Kosong
   * 
   * @param type $id -> ID Pendaftaran
   */
  public function actionIndex($id)
  {
    $modPendaftaran = PSPendaftaranT::model()->findByPk($id);
    $modPasien = PSPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPemeriksaan = PemeriksaanfisikT::model()->findByAttributes(array(
      'pendaftaran_id' => $id,
      'create_ruangan' => Params::RUANGAN_ID_VK,
    ), array(
      'condition' => 'pasienadmisi_id is null',
      'order' => 'pemeriksaanfisik_id asc',
    ));

    $modPersalinan = PSPersalinanT::model()->with(array('pendaftaran', 'pegawai'))->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'pasien_id' => $modPasien->pasien_id));
    $modGinekologi = PSPemeriksaanginekologiT::model()->findByAttributes(array(
      'pendaftaran_id' => $id,
    ), array(
      'condition' => 'pasienadmisi_id is null'
    ));
    $modDetails = null;
    
    $format = new MyFormatter;

    $modKala = new PSPemeriksaankalaT();

    $modPartograf = PSPemeriksaanpartografT::model()->find(" pendaftaran_id = '" . $id . "' ");
    $modPartografObat = new PSPemeriksaanpartografobatT();
    $loadDataPartoDet = array();

    $modPartografLain = new PSPemeriksaanpartograflainT;

    $getPartoDet = array();
    $getPartoLain = array();

    if (empty($modPartograf)) {
      $modPartograf = new PSPemeriksaanpartografT;
      $modPartograf->tglperiksa = date('Y-m-d H:i:s');
      $modPartograf->tglmules = date('Y-m-d H:i:s');
      $modPartograf->gravida = 0;
      $modPartograf->para = 0;
      $modPartograf->abortus = 0;

      $modPartografDet = new PSPemeriksaanpartografdetT;
      $modPartografLain = new PSPemeriksaanpartograflainT;
    } else {
      $modPartografDet = PSPemeriksaanpartografdetT::model()->findAll(" pemeriksaanpartograf_id = '" . $modPartograf->pemeriksaanpartograf_id . "' ORDER BY pemeriksaan_ke ASC ");

      $modPartografLain = PSPemeriksaanpartograflainT::model()->findAll(" pemeriksaanpartograf_id = '" . $modPartograf->pemeriksaanpartograf_id . "' ORDER BY pemeriksaanpartograflain_id ASC ");

      if (!empty($modPartograf->perkiraanlahir_tgl)) {
        $modPartograf->perkiraanlahir_tgl = MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($modPartograf->perkiraanlahir_tgl)));
      }

      if (!empty($modPartografDet)) {
        $modPartograf->ada_detail = true;
        $getPartoDet = $modPartografDet;
        $modPartografDet = new PSPemeriksaanpartografdetT();


        foreach ($getPartoDet as $idx => $item) {
          $arr_oa = array();
          $oa = PemeriksaanpartografobatT::model()->findAllByAttributes(array(
            'pemeriksaanpartografdet_id' => $item->pemeriksaanpartografdet_id
          ));
          foreach ($oa as $item) {
            $arr_oa[$item->obatalkes_id] = $item->obatalkes_jumlah;
          }
          $getPartoDet[$idx]->qty_oa = CJSON::encode($arr_oa);
          $getPartoDet[$idx]->p7_suhu = str_replace(".", ",", $getPartoDet[$idx]->p7_suhu);
        }
      } else {
        $modPartografDet = new PSPemeriksaanpartografdetT();
      }

      if (!empty($modPartografLain)) {
        $getPartoLain = $modPartografLain;
        $modPartografLain = new PSPemeriksaanpartograflainT();
      } else {
        $modPartografLain = new PSPemeriksaanpartograflainT();
      }
    }

    $modBagianTubuh = new BagiantubuhM();
    $modGambarTubuh = new GambartubuhM();
    $modPemeriksaanGambar = array();

    //		if (empty($modPartograf)){
    //			$modPartograf = new PSPemeriksaanpartografT;
    //			$modPartograf->tglperiksa = date('Y-m-d H:i:s');
    //			$modPartograf->gravida = 0;
    //			$modPartograf->para = 0;
    //			$modPartograf->abortus = 0;
    //			
    //			$modPartografDet = new PSPemeriksaanpartografdetT;			
    //		}else{
    //			$modPartografDet = PSPemeriksaanpartografdetT::model()->findAll(" pemeriksaanpartograf_id = '".$modPartograf->pemeriksaanpartograf_id."' ORDER BY pemeriksaanpartografdet_id ASC ");
    //			
    //			if (count((array)$modPartografDet)>0){
    //				$modPartograf->ada_detail = true;								
    //								
    //				//foreach ($modPartografDet as $key1 => $detPar){
    //															
    //				//	$attributes = $detPar->attributeNames();
    //				//	foreach($attributes as $j=>$attribute) {
    //						$loadDataPartoDet = $modPartografDet;
    //				//	}					
    //					
    //				//}
    //				
    //				//var_dump($loadDataPartoDet);die;										
    //				
    //			}else{
    //				//$modPartografDet = new PSPemeriksaanpartografobatT();
    //				$modPartografDet = new PSPemeriksaanpartografdetT();
    //			}
    //												
    //		}

    if (count((array)$modPersalinan) > 0) {
      $model = PSPersalinanT::model()->with(array('pendaftaran', 'pegawai'))->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'pasien_id' => $modPasien->pasien_id));
      $model->tglmulaipersalinan = MyFormatter::formatDateTimeForUser($model->tglmulaipersalinan);
      if (!empty($model->tglselesaipersalinan)) $model->tglselesaipersalinan = MyFormatter::formatDateTimeForUser($model->tglselesaipersalinan);
      if (!empty($model->tglmelahirkan)) $model->tglmelahirkan = MyFormatter::formatDateTimeForUser($model->tglmelahirkan);
      if (isset($model->paritaske)) {
        if (is_numeric($model->paritaske)) {
          $model->paritaske = (isset($model->paritaske) ? ucwords(implode('', CustomFunction::getNomorUrutText($model->paritaske, $model->paritaske))) : "-");
        } else {
          $model->paritaske =  (isset($model->paritaske) ? $model->paritaske : '-'); //(isset($persalinan->paritaske) ? implode('',CustomFunction::getNomorUrutText($persalinan->paritaske,$persalinan->paritaske)) :"-"); 
        }
      }
    } else {
      $model = new PSPersalinanT;
      $model->tglmulaipersalinan = date('d M Y H:i:s');
      $model->tglmelahirkan = date('d M Y H:i:s');
      $model->tglabortus = date('d M Y H:i:s');
      $model->pegawai_id = $modPendaftaran->pegawai_id;
    }

    if (empty($modPemeriksaan)) {
      $modPemeriksaan = new PemeriksaanfisikT;
    } else {
      // if (!empty($modPemeriksaan->frek_auskultasi)) $modPemeriksaan->frek_auskultasi = explode(" - ", $modPemeriksaan->frek_auskultasi);
      if (!empty($modPemeriksaan->obs_periksadalam)) $modPemeriksaan->obs_periksadalam = MyFormatter::formatDateTimeForUser($modPemeriksaan->obs_periksadalam);
      if (!empty($modPemeriksaan->plasenta_lahir)) $modPemeriksaan->plasenta_lahir = MyFormatter::formatDateTimeForUser($modPemeriksaan->plasenta_lahir);

      $model->lokasi_persalinan = CJSON::decode($model->lokasi_persalinan);
      $model->rujuk_pendamping = CJSON::decode($model->rujuk_pendamping);
      $model->masalah_kehamilan = CJSON::decode($model->masalah_kehamilan);
    }



    if (empty($modGinekologi)) {

      $modGinekologi = PSPemeriksaanginekologiT::model()->findByAttributes(array(
        'pendaftaran_id' => $id, 'pasienadmisi_id' => $modPendaftaran->pasienadmisi_id
      ));

      if (empty($modGinekologi)) {
        $modGinekologi = new PSPemeriksaanginekologiT;
        $modRiwayatKehamilan = null;

        $modGinekologi->tglperiksaobgyn = date("d M Y H:i:s");
        $modGinekologi->gin_tglpertamahaid = date("d M Y");
      } else {
        $modGinekologi->tglperiksaobgyn = MyFormatter::formatDateTimeForUser($modGinekologi->tglperiksaobgyn);
        $modRiwayatKehamilan = PSRiwayatkehamilanT::model()->findAll(" pemeriksaanginekologi_id = '" . $modGinekologi->pemeriksaanginekologi_id . "' ");
        $modPemeriksaanGambar = PemeriksaangambarT::model()->findAllByAttributes(array('pemeriksaanginekologi_id' => $modGinekologi->pemeriksaanginekologi_id));

      }
    } else {
      $modRiwayatKehamilan = PSRiwayatkehamilanT::model()->findAll(" pemeriksaanginekologi_id = '" . $modGinekologi->pemeriksaanginekologi_id . "' ");
      $modGinekologi->tglperiksaobgyn = MyFormatter::formatDateTimeForUser($modGinekologi->tglperiksaobgyn);
      $modGinekologi->gin_tglpertamahaid = MyFormatter::formatDateTimeForUser($modGinekologi->gin_tglpertamahaid);
      $modPemeriksaanGambar = PemeriksaangambarT::model()->findAllByAttributes(array('pemeriksaanginekologi_id' => $modGinekologi->pemeriksaanginekologi_id));
      $modGinekologi->periksadalam_pemeriksa = $modGinekologi->periksadalam_pemeriksa;
      if(!empty($modGinekologi->periksadalam_pemeriksa)){
        $pegPeriksa = PegawaiM::model()->findByPk($modGinekologi->periksadalam_pemeriksa);
        $modGinekologi->periksadalam_pemeriksa_nama = (!empty($pegPeriksa)?$pegPeriksa->namaLengkap:null);
      }

    }

    //simpan pemeriksaan ginekologi dipisah, dikarenakan pemeriksaan dalam kandungan .... tidak harus bersamaan dengan persalinan_t dan pemeriksaanfisik_t

    //if ( (empty($_POST['PSPersalinanT']['paritaske'])) OR  (empty($_POST['PSPersalinanT']['jeniskegiatanpersalinan'])) ){
    //	$trans = Yii::app()->db->beginTransaction();
    //}                

    $cekKala = PSPemeriksaankalaT::model()->findByAttributes(array('pendaftaran_id' => $id));
    if (!empty($cekKala)) {
      $modKala = $cekKala;
      if ($modKala->kala_iii_is_laserasi_perineum_penjahitan == true && $modKala->kala_iii_laserasi_perineum_penjahitan_keterangan == 'tanpa anestesi') {
        $modKala->kala_iii_is_laserasi_perineum_penjahitan = 0;
      } else if ($modKala->kala_iii_is_laserasi_perineum_penjahitan == true && $modKala->kala_iii_laserasi_perineum_penjahitan_keterangan == 'dengan anestesi') {
        $modKala->kala_iii_is_laserasi_perineum_penjahitan = 1;
      }

      if(!empty($modKala->kala_1_petugaspemeriksa)){
        $pegKala1 = PegawaiM::model()->findByPk($modKala->kala_1_petugaspemeriksa);
        $modKala->kala_1_petugaspemeriksa_nama = (!empty($pegKala1)?$pegKala1->namaLengkap : null);
      }

      if(!empty($modKala->kala_2_petugaspemeriksa)){
        $pegKala2 = PegawaiM::model()->findByPk($modKala->kala_2_petugaspemeriksa);
        $modKala->kala_2_petugaspemeriksa_nama = (!empty($pegKala2)?$pegKala2->namaLengkap : null);
      }

      if(!empty($modKala->kala_3_petugaspemeriksa)){
        $pegKala3 = PegawaiM::model()->findByPk($modKala->kala_3_petugaspemeriksa);
        $modKala->kala_3_petugaspemeriksa_nama = (!empty($pegKala3)?$pegKala3->namaLengkap : null);
      } 
      
      if(!empty($modKala->kala_4_petugaspemeriksa)){
        $pegKala4 = PegawaiM::model()->findByPk($modKala->kala_4_petugaspemeriksa);
        $modKala->kala_4_petugaspemeriksa_nama = (!empty($pegKala4)?$pegKala4->namaLengkap : null);
      } 


      if(!empty($modKala->kala_1_ppds_id)){
        $pegKala1 = PpdsM::model()->findByPk($modKala->kala_1_ppds_id);
        $modKala->kala_1_ppds_nama = (!empty($pegKala1)?$pegKala1->ppds_nama : null);
      }

      if(!empty($modKala->kala_2_ppds_id)){
        $pegKala2 = PpdsM::model()->findByPk($modKala->kala_2_ppds_id);
        $modKala->kala_2_ppds_nama = (!empty($pegKala2)?$pegKala2->ppds_nama : null);
      }
      
      if(!empty($modKala->kala_3_ppds_id)){
        $pegKala3 = PpdsM::model()->findByPk($modKala->kala_3_ppds_id);
        $modKala->kala_3_ppds_nama = (!empty($pegKala3)?$pegKala3->ppds_nama : null);
      }

      if(!empty($modKala->kala_4_ppds_id)){
        $pegKala4 = PpdsM::model()->findByPk($modKala->kala_4_ppds_id);
        $modKala->kala_4_ppds_nama = (!empty($pegKala4)?$pegKala4->ppds_nama : null);
      }       
    }

    $ishere = isset($_POST['PSPemeriksaanginekologiT']) || isset($_POST['PSPersalinanT']) || isset($_POST['PSRiwayatkehamilanT']);

    $simpanGinekologi = true;
    $successRiwayatKehamilan = true;
    $simpanPersalinan = true;
    $simpanPemeriksaan = true;
    $simpanPartograf = true;
    $simpanPartografDet = true;
    $simpanPartografObat = true;
    $simpanPartografDetLain = true;
    $simpanKala = true;

    if ($ishere) {
      $trans = Yii::app()->db->beginTransaction();

      if (isset($_POST['PSPemeriksaanginekologiT'])) {

        if (!empty($_POST['PSPemeriksaanginekologiT']['pegawai_id'])) {

          //Pemeriksaan Ginekologi
          foreach ($_POST['PSPemeriksaanginekologiT'] as $key => $val) {
            $modGinekologi[$key] = $val;
          }


          if ($modGinekologi->isNewRecord) {
            $modGinekologi->tglperiksaobgyn = MyFormatter::formatDateTimeForDb($modGinekologi->tglperiksaobgyn);
            $modGinekologi->gin_tglpertamahaid = MyFormatter::formatDateTimeForDb($modGinekologi->gin_tglpertamahaid);
            $modGinekologi->pasien_id = $modPendaftaran->pasien_id;
            $modGinekologi->ppds_id = $modPendaftaran->ppds_id;
            $modGinekologi->ppds_id = $_POST['PSPemeriksaanginekologiT']['ppds_id'];
            $modGinekologi->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            if (!empty($modPendaftaran->pasienadmisi_id)) {
              $modGinekologi->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
            }
            $modGinekologi->create_time = date('Y-m-d H:i:s');
            $modGinekologi->create_loginpemakai_id = Yii::app()->user->id;
            $modGinekologi->create_ruangan = Yii::app()->user->getState('ruangan_id');
          } else {
            $modGinekologi->tglperiksaobgyn = MyFormatter::formatDateTimeForDb($modGinekologi->tglperiksaobgyn);
            $modGinekologi->gin_tglpertamahaid = MyFormatter::formatDateTimeForDb($modGinekologi->gin_tglpertamahaid);
            $modGinekologi->update_time = date('Y-m-d H:i:s');
            $modGinekologi->update_loginpemakai_id = Yii::app()->user->id;
          }
          $modGinekologi->gin_keluhan = isset($_POST['PSPemeriksaanginekologiT']['gin_keluhan']) ? ((count((array)$_POST['PSPemeriksaanginekologiT']['gin_keluhan']) > 0) ? implode(', ', $_POST['PSPemeriksaanginekologiT']['gin_keluhan']) : '') : '';
          //$successRiwayatKehamilan = false;
          if ($modGinekologi->save()) {


            $cekRiwayatkehamilan = PSRiwayatkehamilanT::model()->findAll(" pemeriksaanginekologi_id = '" . $modGinekologi->pemeriksaanginekologi_id . "' ");

            if (!empty($cekRiwayatkehamilan)) {
              $hapusRiwayatKehamilan = PSRiwayatkehamilanT::model()->deleteAll('pemeriksaanginekologi_id=' . $modGinekologi->pemeriksaanginekologi_id . '');
            }
            //Riwayat Kehamilan
            if (isset($_POST['PSRiwayatkehamilanT'])) {
              $cekRiwayatkehamilan = PSRiwayatkehamilanT::model()->findAll(" pemeriksaanginekologi_id = '" . $modGinekologi->pemeriksaanginekologi_id . "' ");

              //if ( count((array)$_POST['PSRiwayatkehamilanT']) != count((array)$cekRiwayatkehamilan) ){
              if (!empty($cekRiwayatkehamilan)) {
                $hapusRiwayatKehamilan = PSRiwayatkehamilanT::model()->deleteAll('pemeriksaanginekologi_id=' . $modGinekologi->pemeriksaanginekologi_id . '');
              }
              foreach ($_POST['PSRiwayatkehamilanT'] as $i => $item) {
                if (is_integer($i)) {
                  $modRiwayatKehamilan = new PSRiwayatkehamilanT;
                  if (isset($_POST['PSRiwayatkehamilanT'][$i])) {
                    $modRiwayatKehamilan->attributes = $_POST['PSRiwayatkehamilanT'][$i];
                    $modRiwayatKehamilan->pemeriksaanginekologi_id = $modGinekologi->pemeriksaanginekologi_id;

                    if ($modRiwayatKehamilan->save()) {
                      //var_dump($modRiwayatKehamilan);die;
                      $successRiwayatKehamilan = true;
                    } else {

                      $successRiwayatKehamilan = false;
                    }
                  }
                }
              }
            }

            $oriAssemen = PemeriksaangambarT::model()->findAllByAttributes(array('pemeriksaanginekologi_id' => $modGinekologi->pemeriksaanginekologi_id));
            $tersimpanPemeriksaanGambar = true;
            if(!empty($oriAssemen)){
                foreach($oriAssemen as $dataAssesmen){
                    $checkOri = 0;
                    if(!empty($_POST['PemeriksaangambarT'])){
                        foreach($_POST['PemeriksaangambarT'] as $dataPeriksa){
                            if(!empty($dataPeriksa['PemeriksaangambarT'])){
                                if($dataAssesmen->pemeriksaanginekologi_id == $dataPeriksa['pemeriksaanginekologi_id']){
                                    $checkOri = 1;
                                }
                            }
                        }
                    }

                    if($checkOri == 0){
                        $dataAssesmen->delete();
                    }
                }
            }

            if(!empty($_POST['PemeriksaangambarT'])){
                foreach($_POST['PemeriksaangambarT'] as $dataPeriksa){
                    if(!empty($dataPeriksa['PemeriksaangambarT'])){
                        $modAssemen = PemeriksaangambarT::model()->findByAttributes(array('pemeriksaanginekologi_id' => $dataPeriksa['pemeriksaanginekologi_id']));
                        if(empty($modAssemen)){
                            $modAssemen = new PemeriksaangambarT();
                        }
                    }else{
                        $modAssemen = new PemeriksaangambarT();
                    }
                    
                    $modAssemen->attributes = $dataPeriksa;
                    $modAssemen->pemeriksaangambar_id = (!empty($modAssemen->pemeriksaangambar_id)?$modAssemen->pemeriksaangambar_id:null);
                    $modAssemen->pemeriksaanginekologi_id = $modGinekologi->pemeriksaanginekologi_id;
                    $modAssemen->pendaftaran_id = $modGinekologi->pendaftaran_id;
                    $modAssemen->pasien_id = $modGinekologi->pasien_id;

                    $modAssemen->tglpemeriksaan = date('Y-m-d H:i:s');

                    if (!empty($modAssemen->pemeriksaangambar_id)) {
                        $modAssemen->update_time = date('Y-m-d H:i:s');
                        $modAssemen->update_loginpemakai_id = Yii::app()->user->getState("loginpemakai_id");
                    } else {
                        $modAssemen->create_time = date('Y-m-d H:i:s');
                        $modAssemen->create_loginpemakai_id = Yii::app()->user->getState("loginpemakai_id");
                    }
                    $modAssemen->create_ruangan = Yii::app()->user->getState("ruangan_id");

                    if(!$modAssemen->save()){
                        $tersimpanPemeriksaanGambar = false;
                    }
                }
            }
            
            if($tersimpanPemeriksaanGambar == false){
              $simpanGinekologi = false;
            }
          } else {
            $simpanGinekologi = false;
            //$trans->rollback();
            //Yii::app()->user->setFlash('error',"Data Pemeriksaan Ginekologi gagal disimpan ");
          }
        }
      }

      if (isset($_POST['PemeriksaanfisikT'])) {
        $modPemeriksaan->attributes = $_POST['PemeriksaanfisikT'];
        $modPemeriksaan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modPemeriksaan->pegawai_id = $modPendaftaran->pegawai_id;
        $modPemeriksaan->pasien_id = $modPendaftaran->pasien_id;
        $modPemeriksaan->plasenta_lahir = (empty($modPemeriksaan->plasenta_lahir) ? null : $format->formatDateTimeForDb($modPemeriksaan->plasenta_lahir));
        $modPemeriksaan->obs_periksadalam = (empty($modPemeriksaan->obs_periksadalam) ? null : $format->formatDateTimeForDb($modPemeriksaan->obs_periksadalam));
        $modPemeriksaan->obs_ppds_id = (empty($modPemeriksaan->obs_ppds_id) ? $modPemeriksaan->obs_ppds_id : "-");

        if(!empty($modPemeriksaan->pemeriksaanfisik_id)){
          $modPemeriksaan->update_loginpemakai_id = Yii::app()->user->id;
          $modPemeriksaan->update_time = date('Y-m-d H:i:s');
        }else{
          
          $modPemeriksaan->tglperiksafisik = date('Y-m-d H:i:s');
          $modPemeriksaan->create_loginpemakai_id = Yii::app()->user->id;
          $modPemeriksaan->create_time = date('Y-m-d H:i:s');
          $modPemeriksaan->create_ruangan = Yii::app()->user->getState('ruangan_id');
        }

        $arrfrek_auskultasi = array();
        $arrdenyutjantung_janin = array();

          if (isset($_POST['JaninObs']) && count($_POST['JaninObs']) > 0) {
              foreach ($_POST['JaninObs'] as $dataJaninObs) {
                $arrfrek_auskultasi[] = $dataJaninObs['frek_auskultasi'];
                $arrdenyutjantung_janin[] = $dataJaninObs['denyutjantung_janin'];
              }
          }
          if(!empty($arrfrek_auskultasi)){
            $modPemeriksaan->frek_auskultasi = json_encode($arrfrek_auskultasi);
          }

          if(!empty($arrdenyutjantung_janin)){
            $modPemeriksaan->denyutjantung_janin = json_encode($arrdenyutjantung_janin);
          }

          if ($modPemeriksaan->validate()) {
            $simpanPemeriksaan = $simpanPemeriksaan && $modPemeriksaan->save();
          }
      }


      if (isset($_POST['PSPersalinanT'])) {
        if ((!empty($_POST['PSPersalinanT']['paritaske']) && !empty($_POST['PSPersalinanT']['jeniskegiatanpersalinan']))) {
          
          // $trans = Yii::app()->db->beginTransaction();
          $model->attributes = $_POST['PSPersalinanT'];
          $model->pasien_id = $modPasien->pasien_id;
          //var_dump($model->bidan_id);die;
          if (empty($model->bidan_id)) {
            $model->bidan_id = null;
          }
          $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
          $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
          $model->tglselesaipersalinan = $format->formatDateTimeForDb($_POST['PSPersalinanT']['tglselesaipersalinan']);
          $model->tglmulaipersalinan = $format->formatDateTimeForDb($_POST['PSPersalinanT']['tglmulaipersalinan']);
          if (!empty($_POST['PSPersalinanT']['bidan2_id'])) {
            $model->bidan2_id = $_POST['PSPersalinanT']['bidan2_id'];
          }
          if (!empty($_POST['PSPersalinanT']['bidan3_id'])) {
            $model->bidan3_id = $_POST['PSPersalinanT']['bidan3_id'];
          }
          if (isset($_POST['PSPersalinanT']['tglabortus'])) {
            $model->tglabortus = $format->formatDateTimeForDb($_POST['PSPersalinanT']['tglabortus']);
          } else {
            unset($model->tglabortus);
          }
          $model->tglmelahirkan = $format->formatDateTimeForDb($_POST['PSPersalinanT']['tglmelahirkan']);

          $model->lokasi_persalinan = CJSON::encode($model->lokasi_persalinan);
          $model->rujuk_pendamping = CJSON::encode($model->rujuk_pendamping);
          $model->masalah_kehamilan = CJSON::encode($model->masalah_kehamilan);
          
          $modPenyuliKehamilan = array();

          if (isset($_POST['PenyulitKehamilan']) && !empty($_POST['PenyulitKehamilan'])) {
              foreach ($_POST['PenyulitKehamilan'] as $dataPenyulit) {
                  if (isset($dataPenyulit['ischeck']) && $dataPenyulit['ischeck'] == 1) {
                      $modPenyuliKehamilan[] = array('penyulit'=>$dataPenyulit['penyulit'],'keterangan'=>((isset($dataPenyulit['keterangan']) && !empty($dataPenyulit['keterangan']))? $dataPenyulit['keterangan']: ""));
                  }
              }
          }

          if(count($modPenyuliKehamilan) > 0){
            $model->penyulit_kehamilan_persalinan = json_encode($modPenyuliKehamilan);
          }

          $arrposisijanin = array();

          if (isset($_POST['JaninObs']) && count($_POST['JaninObs']) > 0) {
              foreach ($_POST['JaninObs'] as $dataJaninObs) {
                $arrposisijanin[] = $dataJaninObs['posisijanin'];
              }
          }
          if(!empty($arrposisijanin)){
            $model->posisijanin = json_encode($arrposisijanin);
          }

          if ($model->validate()) {
            if ($model->save()) {

              PendaftaranT::model()->updateByPk($model->pendaftaran_id, array(
                'persalinan_id' => $model->persalinan_id,
              ));

              /* karena tidak didalam persalinanT
              foreach ($_POST['PemeriksaanfisikT'] as $key => $val) {
                $modPemeriksaan[$key] = $val;
              }
            

              if ($modPemeriksaan->isNewRecord) {
                $modPemeriksaan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $modPemeriksaan->pegawai_id = $modPendaftaran->pegawai_id;
                $modPemeriksaan->pasien_id = $modPendaftaran->pasien_id;
                $modPemeriksaan->tglperiksafisik = date('Y-m-d H:i:s');
                $modPemeriksaan->create_loginpemakai_id = Yii::app()->user->id;
                $modPemeriksaan->create_time = date('Y-m-d H:i:s');
                $modPemeriksaan->plasenta_lahir = (empty($modPemeriksaan->plasenta_lahir) ? null : $format->formatDateTimeForDb($modPemeriksaan->plasenta_lahir));
                $modPemeriksaan->obs_periksadalam = (empty($modPemeriksaan->obs_periksadalam) ? null : $format->formatDateTimeForDb($modPemeriksaan->obs_periksadalam));
                $modPemeriksaan->create_ruangan = Yii::app()->user->getState('ruangan_id');
              } else {
                $modPemeriksaan->plasenta_lahir = (empty($modPemeriksaan->plasenta_lahir) ? null : $format->formatDateTimeForDb($modPemeriksaan->plasenta_lahir));
                $modPemeriksaan->obs_periksadalam = (empty($modPemeriksaan->obs_periksadalam) ? null : $format->formatDateTimeForDb($modPemeriksaan->obs_periksadalam));
              } */

              // if (!empty($modPemeriksaan->frek_auskultasi) && is_array($modPemeriksaan->frek_auskultasi)) {

              //   $modPemeriksaan->frek_auskultasi = implode(" - ", $modPemeriksaan->frek_auskultasi);
              // } else {
              //   $modPemeriksaan->frek_auskultasi = null;
              // }

              

                



              // var_dump($modPemeriksaan->attributes, $modPemeriksaan->validate(), $modPemeriksaan->errors); die;
              
              //                                                        
             
            }
          } else {
            $simpanPersalinan = false;
            //$trans->rollback();
            //Yii::app()->user->setFlash('error',"Data gagal disimpan ");
          }
        } else {
          // $simpanPersalinan = false;
          //$trans->rollback();
          //Yii::app()->user->setFlash('error',"Data gagal disimpan ");
        }
      }

      if (isset($_POST['PSPemeriksaankalaT'])) {
        $modKala->attributes = $_POST['PSPemeriksaankalaT'];
        if ($_POST['PSPemeriksaankalaT']['kala_iii_is_laserasi_perineum_penjahitan'] == '0') {
          $modKala->kala_iii_is_laserasi_perineum_penjahitan = true;
          $modKala->kala_iii_laserasi_perineum_penjahitan_keterangan = "tanpa anestesi";
        }
        if ($_POST['PSPemeriksaankalaT']['kala_iii_is_laserasi_perineum_penjahitan'] == '1') {
          $modKala->kala_iii_laserasi_perineum_penjahitan_keterangan = "dengan anestesi";
          $modKala->kala_iii_is_laserasi_perineum_penjahitan = true;
        }
        if ($_POST['PSPemeriksaankalaT']['kala_iii_is_laserasi_perineum_penjahitan'] == '2') {
          $modKala->kala_iii_is_laserasi_perineum_penjahitan = false;
        }

        $modKala->kala_ii_jmlpendarahan = (!empty($modKala->kala_ii_jmlpendarahan)? MyFormatter::formatNumberForDb($modKala->kala_ii_jmlpendarahan) : null);

        $modKala->persalinan_id = $model->persalinan_id;
        $modKala->pemeriksaanfisik_id = $modPemeriksaan->pemeriksaanfisik_id;
        $modKala->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modKala->pasien_id = $modPendaftaran->pasien_id;
        $modKala->ppds_id = $modPendaftaran->ppds_id;
        $modKala->kala_1_waktupemeriksaan = (empty($modKala->kala_1_waktupemeriksaan) ? null : $format->formatDateTimeForDb($modKala->kala_1_waktupemeriksaan));
        $modKala->kala_2_waktupemeriksaan = (empty($modKala->kala_2_waktupemeriksaan) ? null : $format->formatDateTimeForDb($modKala->kala_2_waktupemeriksaan));
        $modKala->kala_3_waktupemeriksaan = (empty($modKala->kala_3_waktupemeriksaan) ? null : $format->formatDateTimeForDb($modKala->kala_3_waktupemeriksaan));
        $modKala->kala_4_waktupemeriksaan = (empty($modKala->kala_4_waktupemeriksaan) ? null : $format->formatDateTimeForDb($modKala->kala_4_waktupemeriksaan));

        if (empty($modKala->pemeriksaankala_id)) {
          $modKala->tgl_pemeriksaan = date('Y-m-d H:i:s');
          $modKala->create_time = date('Y-m-d H:i:s');
          $modKala->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
          $modKala->create_ruangan = Yii::app()->user->getState('ruangan_id');
        } else {
          $modKala->update_time = date('Y-m-d H:i:s');
          $modKala->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        }

        if($modKala->save()){
          $simpanKala = true;
          PemantauankalaivT::model()->deleteAllByAttributes(array(
            'pemeriksaankala_id' => $modKala->pemeriksaankala_id
          ));
  
          if (isset($_POST['PemantauankalaivT'])) {
  
            // var_dump($_POST['PemantauankalaivT']); die;
            foreach ($_POST['PemantauankalaivT'] as $item2) {
              $det = new PemantauankalaivT();
              $det->attributes = $item2;
              $det->waktu = MyFormatter::formatDateTimeForDb($det->waktu);
              $det->suhu = MyFormatter::formatRupiahForDb($det->suhu);
              $det->pemeriksaankala_id = $modKala->pemeriksaankala_id;
  
              if ($det->validate()) {
                $simpanKala = $simpanKala && $det->save();
              } else {
                $simpanKala = false;
              }
  
              //                                                                     var_dump($item2, $det->errors, $det->attributes);
  
            }
  
            // var_dump($simpanKala, $_POST['PemantauankalaivT']);
          }

        }else{
          $simpanKala = false;
        }
        
      }


      //			die;
      if (isset($_POST['PSPemeriksaanpartografT'])) {

        if ($modPartograf->isNewRecord) {
          $modPartograf->attributes = $_POST['PSPemeriksaanpartografT'];
          $modPartograf->pendaftaran_id = $modPendaftaran->pendaftaran_id;
          $modPartograf->persalinan_id = !empty($model->persalinan_id) ? $model->persalinan_id : null;
          $modPartograf->tglperiksa = MyFormatter::formatDateTimeForDb($modPartograf->tglperiksa);
          $modPartograf->tglmules = MyFormatter::formatDateTimeForDb($modPartograf->tglmules);
          $modPartograf->tglketubanpecah = !empty($modPartograf->tglketubanpecah) ? MyFormatter::formatDateTimeForDb($modPartograf->tglmules) : null;
          $modPartograf->selaputketubanpecah_tgl = !empty($modPartograf->selaputketubanpecah_tgl) ? MyFormatter::formatDateTimeForDb($modPartograf->selaputketubanpecah_tgl) : null;
          $modPartograf->selaputketubanpecah_jam = !empty($modPartograf->selaputketubanpecah_jam) ? $modPartograf->selaputketubanpecah_jam : null;
          $modPartograf->perkiraanlahir_tgl = !empty($modPartograf->perkiraanlahir_tgl) ? MyFormatter::formatDateTimeForDb($modPartograf->perkiraanlahir_tgl) : null;
          $modPartograf->create_time = date('Y-m-d H:i:s');
          $modPartograf->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
          $modPartograf->create_ruangan = Yii::app()->user->getState('ruangan_id');
        } else {
          $modPartograf->attributes = $_POST['PSPemeriksaanpartografT'];
          $modPartograf->pendaftaran_id = $modPendaftaran->pendaftaran_id;
          $modPartograf->persalinan_id = !empty($model->persalinan_id) ? $model->persalinan_id : null;
          $modPartograf->tglperiksa = MyFormatter::formatDateTimeForDb($modPartograf->tglperiksa);
          $modPartograf->tglmules = MyFormatter::formatDateTimeForDb($modPartograf->tglmules);
          $modPartograf->tglketubanpecah = !empty($modPartograf->tglketubanpecah) ? MyFormatter::formatDateTimeForDb($modPartograf->tglmules) : null;
          $modPartograf->selaputketubanpecah_tgl = !empty($modPartograf->selaputketubanpecah_tgl) ? MyFormatter::formatDateTimeForDb($modPartograf->selaputketubanpecah_tgl) : null;
          $modPartograf->selaputketubanpecah_jam = !empty($modPartograf->selaputketubanpecah_jam) ? $modPartograf->selaputketubanpecah_jam : null;
          $modPartograf->perkiraanlahir_tgl = !empty($modPartograf->perkiraanlahir_tgl) ? MyFormatter::formatDateTimeForDb($modPartograf->perkiraanlahir_tgl) : null;
          $modPartograf->update_time = date("Y-m-d H:i:s");
          $modPartograf->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        }

        $simpanPartograf = $simpanPartograf && $modPartograf->save();

        if ($simpanPartograf) {

          if (isset($_POST['PSPemeriksaanpartografdetT'])) {

            foreach ($_POST['PSPemeriksaanpartografdetT'] as $i => $val) {

              if (!is_int($i)) {
                continue;
              }


              if (!empty($val['pemeriksaanpartografdet_id'])) {
                $modPartografDet = PSPemeriksaanpartografdetT::model()->findByPk($val['pemeriksaanpartografdet_id']);
                $modPartografDet->attributes = $val;
                if (empty($modPartografDet->p3_waktu)) {
                  $modPartografDet->p3_waktu = date('H:i:s');
                }
                if (empty($modPartografDet->waktucatat)) {
                  $modPartografDet->waktucatat = date('H:i:s');
                }
                $modPartografDet->p7_suhu = str_replace(',', '.', $modPartografDet->p7_suhu);
                $modPartografDet->p6_penyulit = $this->getPenyulit($modPartografDet->p6_penyulit);
                $modPartografDet->pemeriksaanpartograf_id = $modPartograf->pemeriksaanpartograf_id;
                $modPartografDet->update_time = date('Y-m-d H:i:s');
                $modPartografDet->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
              } else {
                $modPartografDet = new PSPemeriksaanpartografdetT;
                $modPartografDet->attributes = $val;
                if (empty($modPartografDet->p3_waktu)) {
                  $modPartografDet->p3_waktu = date('H:i:s');
                }
                $modPartografDet->p7_suhu = str_replace(',', '.', $modPartografDet->p7_suhu);
                $modPartografDet->p6_penyulit = $this->getPenyulit($modPartografDet->p6_penyulit);
                $modPartografDet->pemeriksaanpartograf_id = $modPartograf->pemeriksaanpartograf_id;
                $modPartografDet->create_time = date('Y-m-d H:i:s');
                $modPartografDet->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $modPartografDet->create_ruangan = Yii::app()->user->getState('ruangan_id');
              }

              $simpanPartografDet = $simpanPartografDet && $modPartografDet->save();

              PemeriksaanpartografobatT::model()->deleteAllByAttributes(array(
                'pemeriksaanpartografdet_id' => $modPartografDet->pemeriksaanpartografdet_id
              ));
              if (isset($val['qty_oa']) && !empty($val['qty_oa'])) {
                $arr_oa = CJSON::decode($val['qty_oa']);
                foreach ($arr_oa as $idx => $val) {
                  $det_oa = new PemeriksaanpartografobatT;
                  $det_oa->pemeriksaanpartografdet_id = $modPartografDet->pemeriksaanpartografdet_id;
                  $det_oa->obatalkes_id = $idx;
                  $det_oa->obatalkes_jumlah = $val;
                  $det_oa->save();
                }
              }
            }
          }


          if (isset($_POST['PSPemeriksaanpartograflainT'])) {
            foreach ($_POST['PSPemeriksaanpartograflainT'] as $i => $val) {

              if (!empty($val['pemeriksaanpartograflain_id'])) {
                $modPartografLain = PSPemeriksaanpartograflainT::model()->findByPk($val['pemeriksaanpartograflain_id']);
                $modPartografLain->attributes = $val;
                $modPartografLain->pemeriksaanpartograf_id = $modPartograf->pemeriksaanpartograf_id;
                $simpanPartografDetLain = $simpanPartografDetLain && $modPartografLain->save();
              } else {
                if (!empty($val['pendarahan'])) {
                  $modPartografLain = new PSPemeriksaanpartograflainT;
                  $modPartografLain->attributes = $val;
                  $modPartografLain->pemeriksaanpartograf_id = $modPartograf->pemeriksaanpartograf_id;
                  $simpanPartografDetLain = $simpanPartografDetLain && $modPartografLain->save();
                } else {
                  $simpanPartografDetLain = true;
                }
              }

              //                                                        $simpanPartografDetLain = $simpanPartografDetLain && $modPartografLain->save();                                
            }
          }


          if (isset($_POST['delete']['kontrol'])) {

            $iddel = array();
            foreach ($_POST['delete']['kontrol'] as $del) {
              if (!empty($del)) {
                PemeriksaanpartografobatT::model()->deleteAllByAttributes(array(
                  'pemeriksaanpartografdet_id' => $del,
                ));
                PemeriksaanpartografdetT::model()->deleteByPk($del);
              }
            }
          }

          if (isset($_POST['delete']['lainlain'])) {
            $iddel = array();
            foreach ($_POST['delete']['lainlain'] as $del) {
              if (!empty($del)) {
                $iddel[] = $del;
              }
            }

            $cri = new CDbCriteria();
            $cri->addInCondition("pemeriksaanpartograflain_id", $iddel);
            $hapus = PemeriksaanpartograflainT::model()->deleteAll($cri);
          }
        } else {
          //						var_dump($modPartograf->getErrors());die;
          $simpanPartograf = false;
        }
      }
      //var_dump(($_POST['PSPemeriksaanpartografdetT']));die;
      // var_dump($simpanGinekologi, $successRiwayatKehamilan, $simpanPersalinan, $simpanPemeriksaan, $simpanPartograf, $simpanPartografDet, $simpanPartografObat, $simpanPartografDetLain); die;
      // exit();
      if ($simpanGinekologi && $successRiwayatKehamilan && $simpanPersalinan && $simpanPemeriksaan && $simpanPartograf && $simpanPartografDet && $simpanPartografObat && $simpanPartografDetLain) {
        $trans->commit();
        Yii::app()->user->setFlash('success', "Data Berhasil disimpan ");
        $this->redirect(Yii::app()->createUrl($this->module->id . '/persalinanT/index&id=' . $id . '&sukses=1'));
      } else {
        if (!empty($modGinekologi->pemeriksaanginekologi_id)) {
          $modRiwayatKehamilan = PSRiwayatkehamilanT::model()->findAll(" pemeriksaanginekologi_id = '" . $modGinekologi->pemeriksaanginekologi_id . "' ");
          if (count((array)$modRiwayatKehamilan) < 1) {
            $modRiwayatKehamilan = new PSRiwayatkehamilanT;
          }
        } else {
          $modRiwayatKehamilan = new PSRiwayatkehamilanT;
        }

        Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        $trans->rollback();
      }

      //$simpanGinekologi = true;
      //$successRiwayatKehamilan = true;
      //$simpanPersalinan = true;
    }


    $this->render('index', array(
      'format' => $format, 'model' => $model,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPersalinan' => $modPersalinan,
      'modPemeriksaan' => $modPemeriksaan,
      'modGinekologi' => $modGinekologi,
      'modRiwayatKehamilan' => $modRiwayatKehamilan,
      'modPartograf' => $modPartograf,
      'modPartografObat' => $modPartografObat,
      'modPartografDet' => $modPartografDet,
      //'loadDataPartoDet'=>$loadDataPartoDet,                        
      'getPartoDet' => $getPartoDet,
      'getPartoLain' => $getPartoLain,
      'modPartografLain' => $modPartografLain,
      'modKala' => $modKala,
      'modPemeriksaanGambar'=>$modPemeriksaanGambar,
      'modBagianTubuh'=>$modBagianTubuh,
      'modGambarTubuh'=>$modGambarTubuh
    ));
  }

  public function actionRiwayatKehamilanKeluhan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(gin_keluhan)', strtolower($_GET['tag']), true);
      $criteria->order = "gin_keluhan ASC";
      $keluhans = PSPemeriksaanginekologiT::model()->findAll($criteria);
      $data = array();
      foreach ($keluhans as $i => $keluhan) {
        $data[$i] = array(
          'key' => $keluhan->gin_keluhan,
          'value' => $keluhan->gin_keluhan
        );
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  public function actionAddPartografDetail()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $td = isset($_POST['td']) ? $_POST['td'] : null;
      $tr = isset($_POST['tr']) ? $_POST['tr'] : null;
      $sukses = 0;

      $modPemeriksaanDet = new PSPemeriksaanpartografdetT;

      $modPemeriksaanDetObat = new PSPemeriksaanpartografobatT;

      if ($tr == 0) {
        $thead = "<tr><td><b><span style='color:#333 !important;' class='noperiksa'>P1</span></b></td></tr>";
        $tbody = "";
        $sukses = 1;
      } else {
        $thead = "<td><b><span style='color:#333 !important;' class='noperiksa'>P1</span></b></td>";
        $tbody['catatwaktu'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'catatwaktu', 'det' => $modPemeriksaanDet), true);
        $tbody['djj'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'djj', 'det' => $modPemeriksaanDet), true);
        $tbody['airketuban'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'airketuban', 'det' => $modPemeriksaanDet), true);
        $tbody['penyusupan'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'penyusupan', 'det' => $modPemeriksaanDet), true);
        $tbody['serviks'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'serviks', 'det' => $modPemeriksaanDet), true);
        $tbody['kepala'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'kepala', 'det' => $modPemeriksaanDet), true);
        $tbody['waktu'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'waktu', 'det' => $modPemeriksaanDet), true);
        $tbody['waktulabel'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'waktulabel', 'det' => $modPemeriksaanDet, 'tot' => round((($td - 1) / 2), 0, PHP_ROUND_HALF_DOWN), 'row' => $td), true);
        $tbody['kontraksijumlah'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'kontraksijumlah', 'det' => $modPemeriksaanDet), true);
        $tbody['kontraksidetik'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'kontraksidetik', 'det' => $modPemeriksaanDet), true);
        $tbody['oksilosin'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'oksilosin', 'det' => $modPemeriksaanDet), true);
        $tbody['tetes'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'tetes', 'det' => $modPemeriksaanDet), true);
        $tbody['suhu'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'suhu', 'det' => $modPemeriksaanDet), true);
        $tbody['obat'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'obat', 'det' => $modPemeriksaanDetObat), true);
        $tbody['tekanandarah'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'tekanandarah', 'det' => $modPemeriksaanDet), true);
        $tbody['nadi'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'nadi', 'det' => $modPemeriksaanDet), true);
        $tbody['penyulit'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'penyulit', 'det' => $modPemeriksaanDet), true);
        $tbody['urinprotein'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'urinprotein', 'det' => $modPemeriksaanDet), true);
        $tbody['urinasolon'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'urinasolon', 'det' => $modPemeriksaanDet), true);
        $tbody['urinvolume'] = $this->renderPartial($this->path_view . "partograf._detailPartograf", array('data' => 'urinvolume', 'det' => $modPemeriksaanDet), true);

        $sukses = 1;
      }

      echo json_encode(array(
        'thead' => $thead,
        'tbody' => $tbody,
        'td' => $td,
        'tr' => $tr,
        'sukses' => $sukses
      ));

      Yii::app()->end();
    }
  }

  public function getPenyulit($st)
  {
    $dt = '';

    if ($st == 'ada') {
      $dt = true;
    } elseif ($st == 'tidak') {
      $dt = false;
    }

    return $dt;
  }

  public function getRevertPenyulit($st)
  {
    $dt = '';

    if ($st == true) {
      $dt = 'ada';
    } elseif ($st == false) {
      $dt = 'tidak';
    }

    return $dt;
  }

  function actionTambahPartografLain()
  {
    if (Yii::app()->request->isAjaxRequest) {

      parse_str($_POST['lainlain'], $arr);

      $model = new PSPemeriksaanpartograflainT;
      $model->attributes = $arr['PSPemeriksaanpartograflainT'];
      $model->dokter_nama = $arr['PSPemeriksaanpartograflainT']['dokter_nama'];
      $model->perawat_nama = $arr['PSPemeriksaanpartograflainT']['perawat_nama'];
      $model->bidan_nama = $arr['PSPemeriksaanpartograflainT']['bidan_nama'];
      $model->pemeriksaanpartograflain_id = !empty($arr['PSPemeriksaanpartograflainT']['pemeriksaanpartograflain_id']) ? $arr['PSPemeriksaanpartograflainT']['pemeriksaanpartograflain_id'] : null;

      $tr = $this->renderPartial($this->path_view . "partograf/_rowTabelPartografLain", array('model' => $model, 'i' => 0), true);

      $data['sukses'] = 1;
      $data['tr'] = $tr;

      echo json_encode($data);

      Yii::app()->end();
    }
  }

  /**    
   * untuk mengenerate data pemeriksaan partograf kontrol dalam bentuk tabel    
   */
  function actionTambahPartografKontrol()
  {
    if (Yii::app()->request->isAjaxRequest) {


      parse_str($_POST['kontrol'], $arr);

      $model = new PSPemeriksaanpartografdetT;
      $model->attributes = $arr['PSPemeriksaanpartografdetT'];

      $model->pemeriksaanpartografdet_id = !empty($arr['PSPemeriksaanpartografdetT']['pemeriksaanpartografdet_id']) ? $arr['PSPemeriksaanpartografdetT']['pemeriksaanpartografdet_id'] : null;

      $arr_oa = array();

      if (isset($arr['qty'])) {
        foreach ($arr['qty'] as $id => $qty) {
          $arr_oa[$id] = $qty;
        }
      }

      $model->qty_oa = CJSON::encode($arr_oa);

      $tr = $this->renderPartial($this->path_view . "partograf/_rowTabelKontrol", array('model' => $model, 'i' => 0, 'arr_oa' => $arr_oa), true);

      $data['sukses'] = 1;
      $data['tr'] = $tr;

      echo json_encode($data);

      Yii::app()->end();
    }
  }

  /**    
   * action ini digunakan untuk mengenerate form partograf lain lain atau kontrol
   */
  function actionGenerateForm()
  {
    if (Yii::app()->request->isAjaxRequest) {

      parse_str($_POST['formdata'], $arr);

      $id = isset($_POST['id']) ? $_POST['id'] : null;
      $jenis = isset($_POST['jenis']) ? $_POST['jenis'] : null;
      $no = isset($_POST['no']) ? $_POST['no'] : null;

      if ($jenis == 'lainlain') {
        $new = new PSPemeriksaanpartograflainT;
        $new->attributes = $arr['PSPemeriksaanpartograflainT'][$no];
        $new->pemeriksaanpartograflain_id = $arr['PSPemeriksaanpartograflainT'][$no]['pemeriksaanpartograflain_id'];
      } elseif ($jenis == 'kontrol') {
        $new = new PSPemeriksaanpartografdetT;
        $new->attributes = $arr['PSPemeriksaanpartografdetT'][$no];
        $new->p7_suhu = str_replace(".", ",", $new->p7_suhu);
        $new->pemeriksaanpartografdet_id = $arr['PSPemeriksaanpartografdetT'][$no]['pemeriksaanpartografdet_id'];
        $new->qty_oa = $arr['PSPemeriksaanpartografdetT'][$no]['qty_oa'];
      }

      $new->nourutlain = $no;


      if ($jenis == 'lainlain') {
        $tr = $this->renderPartial($this->path_view . "partograf/_formLainLain", array('model' => $new, 'i' => 0, 'ubah' => 'ubah',), true);
      } elseif ($jenis == 'kontrol') {
        $arr_oa = empty($new->qty_oa) ? array() : CJSON::decode($new->qty_oa);
        $tr = $this->renderPartial($this->path_view . "partograf/_formKontrolPartograf", array('model' => $new, 'i' => 0, 'ubah' => 'ubah', 'arr_oa' => $arr_oa), true);
      }

      $data['sukses'] = 1;
      $data['html'] = $tr;

      echo json_encode($data);

      Yii::app()->end();
    }
  }

  // public function actionAutocompletePegawai()
  //   {
  //       if(Yii::app()->request->isAjaxRequest) {
  //           $returnVal = array();
  //           $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
  //           $criteria = new CDbCriteria();
  //           $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
	// 	    $criteria->addInCondition("kelompokpegawai_id ",array(Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN,Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN));

  //           $criteria->order = 'nama_pegawai';
  //           $criteria->limit = 5;
			
	// 		$models = PegawairuanganV::model()->findAll($criteria); //default
  //           foreach($models as $i=>$model)
  //           {
  //               $attributes = $model->attributeNames();
  //               foreach($attributes as $j=>$attribute) {
  //                   $returnVal[$i]["$attribute"] = $model->$attribute;
  //               }
  //               $returnVal[$i]['label'] = $model->NamaLengkap;
  //               $returnVal[$i]['value'] = $model->pegawai_id;
  //           }

  //           echo CJSON::encode($returnVal);
  //       }
  //       Yii::app()->end();
  //   }

  public function actionTambahBagianTubuh()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $form = '';
      if (!empty($_POST['bagiantubuh_id'])) {
        $modPemeriksaanGbr = new PemeriksaangambarT();
        $modPemeriksaanGbr->bagiantubuh_id = $_POST['bagiantubuh_id'];
        $modPemeriksaanGbr->namabagtubuh = $modPemeriksaanGbr->bagiantubuh->namabagtubuh;
        $modPemeriksaanGbr->keterangan_periksa_gbr = $_POST['keterangan'];
        $modPemeriksaanGbr->kordinat_tubuh_x = $_POST['pic_x'];
        $modPemeriksaanGbr->kordinat_tubuh_y = $_POST['pic_y'];
        $modPemeriksaanGbr->gambartubuh_id = $_POST['gambartubuh_id'];

        $modPemeriksaanGbr->look = isset($_POST['look']) ? $_POST['look'] : null;
        $modPemeriksaanGbr->feel = isset($_POST['feel']) ? $_POST['feel'] : null;
        $modPemeriksaanGbr->move = isset($_POST['move']) ? $_POST['move'] : null;
        $modPemeriksaanGbr->sensory = isset($_POST['sensory']) ? $_POST['sensory'] : null;
        $modPemeriksaanGbr->motorik = isset($_POST['motorik']) ? $_POST['motorik'] : null;

        $form = $this->renderPartial($this->path_view . 'ginekologi/_rowPemeriksaanAnggotaTubuh', array('modPemeriksaanGbr' => $modPemeriksaanGbr), true);
        $axis['x'] = $modPemeriksaanGbr->kordinat_tubuh_x;
        $axis['y'] = $modPemeriksaanGbr->kordinat_tubuh_y;
        echo CJSON::encode(array('pesan' => $pesan, 'form' => $form, 'axis' => $axis, 'bagiantubuh_id' => $modPemeriksaanGbr->bagiantubuh_id));
      } else {
        $pesan = 'Bagian tubuh tidak boleh kosong!';
        echo CJSON::encode(array('pesan' => $pesan));
      }
    }
    Yii::app()->end();
  }

  public function actionHapusBagianTubuh()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $ok = 0;
      $del = true;

      $ok = PemeriksaangambarT::model()->findByAttributes(
        array(
          'pemeriksaangambar_id' => $_POST['pemeriksaangambar_id'],
          'gambartubuh_id' => $_POST['gambartubuh_id'],
          'bagiantubuh_id' => $_POST['bagiantubuh_id'],
          'keterangan_periksa_gbr' => $_POST['keterangan_periksa_gbr'],
        )
      );

      if (!empty($ok)) {
        $del = $del && $ok->delete();
      }



      if ($del) {
        $pesan = 'Data Berhasil Dihapus dari database';
        $ok = 1;
        echo CJSON::encode(array('pesan' => $pesan, 'ok' => $ok));
      } else {
        $ok = 0;
        $pesan = "Bagian Tubuh gagal dihapus!";
        echo CJSON::encode(array('pesan' => $pesan, 'ok' => $ok));
      }
    }
    Yii::app()->end();
  }

  public function actionGetBagianTubuhId()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $data = array();
      $kordinat_x = $_POST['kordinat_x'];
      $kordinat_y = $_POST['kordinat_y'];
      $gambartubuh_id = $_POST['gambartubuh_id'];
      
      $cr = new CDbCriteria();
      $cr->addCondition("" . $kordinat_x . " between kordinat_x and kordinat_x2");
      $cr->addCondition("" . $kordinat_y . " between kordinat_y and kordinat_y2");
      $cr->compare('gambartubuh_id', $gambartubuh_id);
      $cr->order = ('bagiantubuh_urutan asc');

      $result = BagiantubuhM::model()->find($cr);
      if ($result) {
        $data['kakitangan'] = '';
        $tangan = stristr($result['namabagtubuh'], 'tangan');
        $lengan = stristr($result['namabagtubuh'], 'lengan');
        $paha = stristr($result['namabagtubuh'], 'paha');
        $lutut = stristr($result['namabagtubuh'], 'lutut');
        $betis = stristr($result['namabagtubuh'], 'betis');
        $kaki = stristr($result['namabagtubuh'], 'kaki');
        if (!empty($tangan) or !empty($lengan) or !empty($paha) or !empty($lutut) or !empty($betis) or !empty($kaki)) {
          $data['kakitangan'] = 'ok';
        }
        $data['pesan'] = '';
        $data['namabagtubuh'] = $result['namabagtubuh'];
        $data['bagiantubuh_id'] = $result['bagiantubuh_id'];
        echo json_encode($data);
      } else {
        $pesan = "Bagian tubuh belum disetting!";
        echo CJSON::encode(array('pesan' => $pesan));
      }
    }
    Yii::app()->end();
  }
}
