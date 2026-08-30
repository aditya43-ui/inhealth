<?php

Yii::import('farmasiApotek.controllers.PenjualanResepRSController');
Yii::import('farmasiApotek.views.penjualanResepRS.*');

class PenjualanBebasController extends PenjualanResepRSController
{
  public $defaultAction = 'index';
  public $path_view = 'farmasiApotek.views.penjualanResepRS.';
  public $path_view_bebas = 'farmasiApotek.views.penjualanBebas.';
  public $obatalkespasientersimpan = true; //looping
  public $stokobatalkestersimpan = true; //looping

  public function actionIndex($penjualanresep_id = null)
  {
    $sukses = false;
    $modPendaftaran = new FAPendaftaranT;
    $modPasien = new FAPasienM;
    $format = new MyFormatter();
    $modPasien->tanggal_lahir = date('Y-m-d');
    $modReseptur = new FAResepturT;
    $modAntrian = new FAAntrianFarmasiT;
    $modObatAlkesPasien = array();
    $instalasi_id = Yii::app()->user->getState('instalasi_id');
    $modReseptur->noresep = MyGenerator::noResep($instalasi_id);
    $modReseptur->noresep_depan = $modReseptur->noresep . '/';
    $modReseptur->tglreseptur = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modReseptur->tglreseptur, 'yyyy-MM-dd hh:mm:ss', 'medium', null));
    $modPenjualan = new FAPenjualanResepT;
    $modPenjualan->tglpenjualan = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenjualan->tglpenjualan, 'yyyy-MM-dd hh:mm:ss', 'medium', null));
    $modPenjualan->tglresep = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenjualan->tglresep, 'yyyy-MM-dd hh:mm:ss', 'medium', null));
    $modPenjualan->noresep = MyGenerator::noResep($instalasi_id);

    $modPenjualan->jenispenjualan = 'PENJUALAN BEBAS';
    $modPenjualan->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
    $modPenjualan->penjamin_id = Params::PENJAMIN_ID_UMUM;
    $modPenjualan->totharganetto = 0;
    $modPenjualan->totalhargajual = 0;
    $modPenjualan->totaltarifservice = 0;
    $modPenjualan->biayaadministrasi = 0;
    $modPenjualan->biayakonseling = 0;
    $modPenjualan->pembulatanharga = 0;
    $modPenjualan->jasadokterresep = 0;
    $modPenjualan->discount = 0;
    $modPenjualan->subsidiasuransi = 0;
    $modPenjualan->subsidipemerintah = 0;
    $modPenjualan->subsidirs = 0;
    $modPenjualan->iurbiaya = 0;

    $modObatAlkes = array();

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

    if (!empty($penjualanresep_id)) {
      $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
      $modObatAlkesPasien = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $modPenjualan->penjualanresep_id));
    }

    $modAntrian->tglambilantrian = date('Y-m-d H:i:s');
    $racikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_RACIKAN);
    $nonRacikan = RacikanM::model()->findByPk(Params::RACIKAN_ID_NONRACIKAN);
    $modRacikanDetail = RacikandetailM::model()->findAll(); //load semua data untuk perhitungan js & jquery
    $racikanDetail = array();
    foreach ($modRacikanDetail as $i => $mod) { //convert object to array
      $racikanDetail[$i]['racikandetail_id'] = $mod->racikandetail_id;
      $racikanDetail[$i]['racikan_id'] = $mod->racikan_id;
      $racikanDetail[$i]['qtymin'] = $mod->qtymin;
      $racikanDetail[$i]['qtymaks'] = $mod->qtymaks;
      $racikanDetail[$i]['tarifservice'] = $mod->tarifservice;
    }

    $transaction = Yii::app()->db->beginTransaction();
    if (isset($_POST['FAPenjualanResepT'])) {
      if ($_POST['FAPenjualanResepT']['is_pasien'] == 1) {
        if (isset($_POST['FAPasienM'])) {
          if (empty($_POST['FAPasienM']['pasien_id'])) {
            $modPasien = $this->simpanPasienApotek($modPasien, $_POST['FAPasienM']);
            $modPasien->attributes = $_POST['FAPasienM'];
            $modPasien->pasien_id = $modPasien->pasien_id;
            $modPasien->create_time = $format->formatDateTimeForDb($modPasien->create_time);
            $modPasien->tanggal_lahir = $format->formatDateTimeForDb($modPasien->tanggal_lahir);
            $modPasien->update_time = $format->formatDateTimeForDb($modPasien->update_time);
            $modPasien->create_loginpemakai_id = Yii::app()->user->id;
            $modPasien->update_loginpemakai_id = Yii::app()->user->id;
          } else {
            //						$modPasien = $this->simpanPasienApotek($modPasien, $_POST['FAPasienM']);
            $modPasien->attributes = $_POST['FAPasienM'];
            $modPasien->pasien_id = $_POST['FAPasienM']['pasien_id'];
            $modPasien->create_time = $format->formatDateTimeForDb($modPasien->create_time);
            $modPasien->tanggal_lahir = $format->formatDateTimeForDb($modPasien->tanggal_lahir);
            $modPasien->update_time = $format->formatDateTimeForDb($modPasien->update_time);
            $modPasien->create_loginpemakai_id = Yii::app()->user->id;
            $modPasien->update_loginpemakai_id = Yii::app()->user->id;
          }
        }
      } else {
        $modPasien = FAPasienM::model()->findByPk(Params::DEFAULT_PASIEN_APOTEK_UMUM);
      }
      $modPenjualan = $this->savePenjualanResep($modPasien, $_POST['FAPenjualanResepT']);
      if ($this->penjualantersimpan) {
        if (count((array)$_POST['FAObatalkesPasienT']) > 0) {
          //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jmlmutasi
          $detailGroups = array();
          foreach ($_POST['FAObatalkesPasienT'] as $i => $postDetail) {
            $modDetails[$i] = new FAObatalkesPasienT;
            $modDetails[$i]->attributes = $postDetail;
            $oa = ObatalkesM::model()->findByPk($modDetails[$i]->obatalkes_id);
            $modDetails[$i]->penjualanresep_id = $modPenjualan->penjualanresep_id;
            $modDetails[$i]->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
            $modDetails[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modDetails[$i]->shift_id = Yii::app()->user->getState('shift_id');
            $modDetails[$i]->pendaftaran_id = $modPenjualan->pendaftaran_id;
            $modDetails[$i]->pasien_id = $modPenjualan->pasien_id;
            $modDetails[$i]->carabayar_id = $modPenjualan->carabayar_id;
            $modDetails[$i]->penjamin_id = $modPenjualan->penjamin_id;
            $modDetails[$i]->pegawai_id = $modPenjualan->pegawai_id;
            $modDetails[$i]->tglpelayanan = date("Y-m-d H:i:s");
            $modDetails[$i]->r = "R/";
            $modDetails[$i]->satuankecil_id = $oa->satuankecil_id;
            $modDetails[$i]->permintaan_oa = MyFormatter::formatNumberForDb($modDetails[$i]->permintaan_oa);
            //$modDetails[$i]->qty_oa = $postDetail['qty_dilayani'];
            //$modDetails[$i]->hargajual_oa = $postDetail['hargajual_reseptur'];
            //$modDetails[$i]->harganetto_oa = $postDetail['harganetto_reseptur'];
            //$modDetails[$i]->hargasatuan_oa = $postDetail['hargasatuan_reseptur'];
            //$modDetails[$i]->signa_oa = $postDetail['signa_reseptur'];
            $modDetails[$i]->create_time = date("Y-m-d H:i:s");
            $modDetails[$i]->create_loginpemakai_id = Yii::app()->user->id;
            $modDetails[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modDetails[$i]->kelaspelayanan_id = $modPenjualan->kelaspelayanan_id;
            $modDetails[$i]->pasienadmisi_id = $modPenjualan->pasienadmisi_id;

            //var_dump($postDetail);
            //var_dump($modPenjualan->attributes);
            //var_dump($modDetails[$i]->attributes);
            //var_dump($modDetails[$i]->validate());
            //var_dump($modDetails[$i]->getErrors());
            //die;


            if (empty($modDetails[$i]->pegawai_id) || $modDetails[$i]->pegawai_id == 0) {
              $modDetails[$i]->pegawai_id = Yii::app()->user->getState('pegawai_id');
            }

            if ($modDetails[$i]->validate()) {
              $this->obatalkespasientersimpan &= $modDetails[$i]->save();
            } else {
              $this->obatalkespasientersimpan &= false;
            }

            $this->simpanStokObatAlkesOut2($modDetails[$i]);


            /*
						$modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
						$modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
						$obatalkes_id = $postDetail['obatalkes_id'];
						if (isset($detailGroups[$obatalkes_id])) {
							$detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
						} else {
							$detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
							$detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
						}
                                                 * 
                                                 */
          }
          //END GROUP
        }
        /*
				$obathabis = "";
				//PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
				foreach ($detailGroups AS $i => $detail) {
					$modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));

					if (count((array)$modStokOAs) > 0) {
						foreach ($modStokOAs AS $i => $stok) {
							$modDetails[$i] = $this->simpanObatAlkesPasien($modPasien, $modPenjualan, $stok, $_POST['FAObatalkesPasienT']);
							$this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
						}
					} else {
						$this->stokobatalkestersimpan &= false;
						$obathabis .= "<br>- " . ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
					}
				}
                                 * 
                                 */
        try {
          if ($this->obatalkespasientersimpan && $this->stokobatalkestersimpan) {

            // SMS GATEWAY
            $sms = new Sms();
            $smspasien = 1;
            foreach ($modSmsgateway as $i => $smsgateway) {
              $isiPesan = $smsgateway->templatesms;

              $attributes = $modPasien->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $attributes = $modPenjualan->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }

              $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modPenjualan->tglpenjualan), $isiPesan);

              if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                if (!empty($modPasien->no_mobile_pasien)) {
                  $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
                } else {
                  $smspasien = 0;
                }
              }
            }
            // END SMS GATEWAY

            $transaction->commit();
            $sukses = 1;
            $this->redirect(array('index', 'penjualanresep_id' => $modPenjualan->penjualanresep_id, 'sukses' => $sukses, 'smspasien' => $smspasien));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data detail penjualan resep gagal disimpan !");
            if (!$this->stokobatalkestersimpan) {
              Yii::app()->user->setFlash('error', "Data detail penjualan resep gagal disimpan ! Stok obat berikut tidak mencukupi !:" . $obathabis);
            }
          }
        } catch (Exception $e) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data penjualan resep gagal disimpan ! " . MyExceptionMessage::getMessage($e, true));
        }
      }
    }

    $this->render('index', array(
      'modReseptur' => $modReseptur,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPenjualan' => $modPenjualan,
      'modAntrian' => $modAntrian,
      'modObatAlkesPasien' => $modObatAlkesPasien,
      'racikan' => $racikan,
      'racikanDetail' => $racikanDetail,
      'nonRacikan' => $nonRacikan,
      'obatAlkes' => $modObatAlkes,
      'sukses' => $sukses,
    ));
  }

  /**
   * 
   * @param type $postsimpan / update pasien
   */
  public function simpanPasienApotek($modPasien, $post)
  {
    $format = new MyFormatter();
    if (isset($post['pasien_id'])) {
      if ($post['pasien_id']) {
        $loadPasien = FAPasienM::model()->findByPk($post['pasien_id']);
        if (isset($loadPasien)) {
          $modPasien = $loadPasien;
          $modPasien->attributes = $_POST['FAPasienM'];
          $modPasien->update_time = date("Y-m-d H:i:s");
          $modPasien->update_loginpemakai_id = Yii::app()->user->id;
          $modPasien->update();
        }
      }
    }
    $modPasien->attributes = $post;
    $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
    $modPasien->tanggal_lahir = $format->dateTimeForDb($modPasien->tanggal_lahir);
    $modPasien->no_rekam_medik = MyGenerator::noRekamMedik(Yii::app()->user->getState('mr_apotik'), 'TRUE');
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
    $modPasien->save();
    return $modPasien;
  }

  protected function savePenjualanResep($modPasien, $penjualanResep)
  {
    //		echo $modPasien->pasien_id;exit;
    $format = new MyFormatter();
    $modPenjualan = new FAPenjualanResepT;
    $modPenjualan->attributes = $penjualanResep;
    $modPenjualan->pendaftaran_id = null;
    $modPenjualan->penjamin_id = $penjualanResep['penjamin_id'];
    $modPenjualan->carabayar_id = $penjualanResep['carabayar_id'];
    $modPenjualan->antrianfarmasi_id = isset($penjualanResep['antrianfarmasi_id']) ? $penjualanResep['antrianfarmasi_id'] : null;
    $modPenjualan->pegawai_id = $penjualanResep['pegawai_id'];
    $modPenjualan->kelaspelayanan_id = null;
    $modPenjualan->pasien_id = $modPasien->pasien_id;
    $modPenjualan->pasienadmisi_id = null;
    $modPenjualan->tglpenjualan = $format->formatDateTimeForDb($_POST['FAPenjualanResepT']['tglpenjualan']);
    $modPenjualan->tglresep = date('Y-m-d H:i:s');
    $modPenjualan->ruanganasal_nama = 'Apotek Pelayanan 1';
    $modPenjualan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPenjualan->pembulatanharga = Yii::app()->user->getState('pembulatanharga');
    $modPenjualan->noresep = isset($_POST['FAPenjualanResepT']['noresep']) ? $_POST['FAPenjualanResepT']['noresep'] : $_POST['FAResepturT']['noresep'];
    $modPenjualan->subsidiasuransi = 0;
    $modPenjualan->subsidipemerintah = 0;
    $modPenjualan->subsidirs = 0;
    $modPenjualan->iurbiaya = 0;
    $modPenjualan->discount = 0;
    $modPenjualan->create_time = date("Y-m-d H:i:s");
    $modPenjualan->create_loginpemakai_id = Yii::app()->user->id;
    $modPenjualan->create_ruangan = Yii::app()->user->getState('ruangan_id');

    if ($modPenjualan->validate()) {
      $modPenjualan->save();
      $this->penjualantersimpan = true;
    } else {
      $this->penjualantersimpan = false;
      Yii::app()->user->setFlash('error', "Data Penjualan Resep Tidak valid");
    }

    return $modPenjualan;
  }

  /**
   * simpan ObatalkesPasienT Jumlah Out
   * @param type $modPenjualan
   * @param type $postObatAlkesPasien
   * @return \ObatalkesPasienT
   */
  protected function simpanObatAlkesPasien($modPasien, $modPenjualan, $stokOa, $postObatAlkesPasien)
  {
    $format = new MyFormatter;
    $modObatAlkes = new FAObatalkesPasienT;
    $modObatAlkes->attributes = $stokOa->attributes;
    $modObatAlkes->tglpelayanan = date("Y-m-d H:i:s");
    $modObatAlkes->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    $modObatAlkes->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modObatAlkes->carabayar_id = $modPenjualan->carabayar_id;
    $modObatAlkes->pegawai_id = Yii::app()->user->getState('pegawai_id');
    $modObatAlkes->shift_id = Yii::app()->user->getState('shift_id');
    $modObatAlkes->pendaftaran_id = null;
    $modObatAlkes->pasien_id = $modPasien->pasien_id;
    $modObatAlkes->penjamin_id = $modPenjualan->penjamin_id;
    $modObatAlkes->create_time = date("Y-m-d H:i:s");
    $modObatAlkes->create_loginpemakai_id = Yii::app()->user->id;
    $modObatAlkes->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modObatAlkes->penjualanresep_id = $modPenjualan->penjualanresep_id;
    $modObatAlkes->qty_oa = $stokOa->qtystok_terpakai;
    $modObatAlkes->jmlstok = $stokOa->qtystok;
    $modObatAlkes->harganetto_oa = $stokOa->HPP;
    $modObatAlkes->hargasatuan_oa = $stokOa->HargaJualSatuan;
    $modObatAlkes->hargajual_oa = $modObatAlkes->hargasatuan_oa * $modObatAlkes->qty_oa;
    foreach ($postObatAlkesPasien as $i => $postDetail) {
      if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
        $modObatAlkes->sumberdana_id = $postDetail['sumberdana_id'];
        $modObatAlkes->r = $postDetail['r'];
        $modObatAlkes->rke = $postDetail['rke'];
        $modObatAlkes->permintaan_oa = $postDetail['permintaan_oa'];
        $modObatAlkes->kekuatan_oa = $postDetail['kekuatan_oa'];
        $modObatAlkes->jmlkemasan_oa = $postDetail['jmlkemasan_oa'];
        //                $modObatAlkes->biayaservice = $postDetail['biayaservice'];
        //                $modObatAlkes->biayakonseling = $postDetail['biayakonseling'];
        //                $modObatAlkes->jasadokterresep = $postDetail['jasadokterresep'];
        //                $modObatAlkes->biayakemasan = $postDetail['biayakemasan'];
        //                $modObatAlkes->biayaadministrasi = $postDetail['biayaadministrasi'];
        //                $modObatAlkes->tarifcyto = $postDetail['tarifcyto'];
        //                $modObatAlkes->subsidiasuransi = $postDetail['subsidiasuransi'];
        //                $modObatAlkes->subsidipemerintah = $postDetail['subsidipemerintah'];
        //                $modObatAlkes->subsidirs = $postDetail['subsidirs'];
        //                $modObatAlkes->discount = $postDetail['discount'];
        $modObatAlkes->signa_oa = $postDetail['signa_oa'];
        $modObatAlkes->etiket = $postDetail['etiket'];
      }
      $modObatAlkes->iurbiaya = $modObatAlkes->hargajual_oa;
    }

    if ($modObatAlkes->save()) {
      $this->obatalkespasientersimpan &= true;
    } else {
      $this->obatalkespasientersimpan &= false;
    }
    return $modObatAlkes;
  }

  /**
   * set dropdown penjamin pasien dari carabayar_id
   * @param type $encode
   * @param type $namaModel
   */
  public function actionSetDropdownPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * untuk print data penjualan dokter
   */
  public function actionPrint($penjualanresep_id, $caraPrint = null)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
    $modPenjualanDetail = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $penjualanresep_id));

    $judul_print = 'Penjualan Bebas';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }

    $this->render($this->path_view . 'Print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPenjualan' => $modPenjualan,
      'modPenjualanDetail' => $modPenjualanDetail,
      'caraPrint' => $caraPrint
    ));
  }

  /**
   * Mengurai data pasien berdasarkan:
   * - pasien_id
   * - no_rekam_medik
   * @throws CHttpException
   */
  public function actionGetDataInfoPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      if (!empty($pasien_id)) {
        $criteria->addCondition("pasien_id = " . $pasien_id);
      }
      $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));
      $model = FAPasienM::model()->find($criteria);
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * action Pasien Lama Apotek digunakan untuk pendaftaran pasien apotek
   */
  public function actionAutocompletePasienApotek()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_rekam_medik)', 'AP' . strtolower($_GET['term']), true);
      $criteria->addCondition('ispasienluar = TRUE');
      $criteria->order = 'no_rekam_medik';
      $models = PasienM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien;
        $returnVal[$i]['value'] = $model->no_rekam_medik;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
