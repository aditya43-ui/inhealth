<?php

class DaftarPasienController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Daftar Pasien Pemulasaran Jenazah";
    $format = new MyFormatter();
    $model = new PJPasienmasukpenunjangV;
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date('Y-m-d');
    $model->ceklis = TRUE;
    if (isset($_GET['PJPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PJPasienmasukpenunjangV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJPasienmasukpenunjangV']['tgl_akhir']);
      $model->ceklis = $_GET['PJPasienmasukpenunjangV']['ceklis'];
    }

    if(Yii::app()->request->isAjaxRequest) {
      if(isset($_GET['ajax']) && $_GET['ajax'] == 'daftarPasien-grid') {
        $this->renderPartial('_table', ['model' => $model]);
        Yii::app()->end();
      }
    }

    $this->render('index', array('model' => $model, 'format' => $format));
  }

  public function actionBatalPenunjang($task = 'BatalPenunjang')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pesan = '';
      $status = '';
      $update_tindakan = false;
      $delete_tindakan = false;
      $delete_penunjang = false;

      $pasienmasukpenunjang_id = isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;

      $username = isset($_POST['nama_pemakai']) ? $_POST['nama_pemakai'] : null;
      $password = isset($_POST['kata_kunci']) ? $_POST['kata_kunci'] : null;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');

      $status_tindakan = false;
      $status_obat = false;
      $status_batal = true;
      $user = LoginpemakaiK::model()->findByAttributes(array(
        'nama_pemakai' => $username,
        'loginpemakai_aktif' => TRUE
      ));
      if ($user === null) {
        $pesan = "Login Pemakai Salah";
        $data['error'] = "Login Pemakai salah!";
        $data['cssError'] = 'username';
        $data['status'] = 'Gagal Login';
      } else {
        // cek password
        if (!$user->cekPassword3($password)) {
          $pesan = "Password Salah";
          $data['error'] = 'password salah!';
          $data['cssError'] = 'password';
          $data['status'] = 'Gagal Login';
        } else {
          $data['error'] = '';
          $cek = $this->checkAccess(array('loginpemakai_id' => $user->loginpemakai_id, 'action' => $task)); //dari MyAuthController
          if ($cek) {
            $data['status'] = 'success';
            $data['userid'] = $user->loginpemakai_id;
            $data['username'] = $user->nama_pemakai;

            $transaction = Yii::app()->db->beginTransaction();
            try {
              $criteria = new CDbCriteria();
              $criteria->addCondition('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
              $criteria->addCondition('tindakansudahbayar_id is not null');
              $modTindakanPelayanan = TindakanpelayananT::model()->find($criteria);

              $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
              $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

              if ($modPendaftaran->ruangan_id == $modPasienMasukPenunjang->ruangan_id) {
                $criteriaTindakan = new CDbCriteria();
                $criteriaTindakan->addCondition('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
                $criteriaTindakan->addCondition('tindakansudahbayar_id is not null');

                $modTindakanPelayanan = TindakanpelayananT::model()->find($criteriaTindakan);

                $criteriaObat = new CDbCriteria();
                $criteriaObat->addCondition('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
                $criteriaObat->addCondition('oasudahbayar_id is not null');
                $modObatalkesPasien = ObatalkespasienT::model()->find($criteriaObat);

                if ($modTindakanPelayanan) {
                  $status_tindakan = true;
                }

                if ($modObatalkesPasien) {
                  $status_obat = true;
                }

                if ($status_tindakan == true || $status_obat == true) {
                  $status_batal = false;
                  $pesan = "Pemeriksaan tidak bisa dibatalkan karena ada tindakan/obat yang sudah dibayarkan. Silakan hubungi Kasir!";
                } else {
                  $status_batal = true;
                }

                if ($status_batal == true) {
                  /*
									* cek data pendaftaran pasien masuk penunjang
									*/
                  $criteria = new CDbCriteria();
                  if (!empty($pasienmasukpenunjang_id)) {
                    $criteria->addCondition("pasienmasukpenunjang_id = " . $pasienmasukpenunjang_id);
                  }

                  $pasienMasukPenunjang = PasienmasukpenunjangT::model()->find($criteria);

                  $pesan = '';
                  $status = false;
                  $model = new PasienbatalperiksaR();
                  $model->pendaftaran_id = $pendaftaran_id;
                  $model->pasien_id = $modPendaftaran->pasien_id;
                  $model->tglbatal = isset($tglbatal) ? MyFormatter::formatDateTimeForDb($tglbatal) : date('Y-m-d');
                  $model->keterangan_batal = isset($keterangan_batal) ? $keterangan_batal : "Batal Pemulasaran Jenazah";
                  $model->create_ruangan = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                  $model->create_time = date('Y-m-d H:i:s');
                  $model->create_loginpemakai_id = Yii::app()->user->id;

                  if ($model->save()) {
                    $status = true;
                    //										$pesan = "Pemeriksaan pasien berhasil dibatalkan!";
                  } else {
                    $status = false;
                    //										$pesan = "Pemeriksaan gagal dibatalkan! ".CHtml::errorSummary($model);
                  }

                  $attributes = array(
                    'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
                    'update_time' => date('Y-m-d H:i:s'),
                    'update_loginpemakai_id' => Yii::app()->user->id
                  );
                  $pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);

                  if (!empty($pasienMasukPenunjang)) {
                    if ($pasienMasukPenunjang->pasienkirimkeunitlain_id == null) {
                      $attributes = array(
                        'pasienkirimkeunitlain_id' => $pasienMasukPenunjang->pasienkirimkeunitlain_id
                      );
                      $Perminataan_penunjang = PermintaankepenunjangT::model()->deleteAllByAttributes($attributes);
                    }

                    $attributes = array(
                      'statusperiksa' => Params::STATUSPERIKSA_BATAL_PERIKSA,
                      'update_time' => date('Y-m-d H:i:s'),
                      'update_loginpemakai_id' => Yii::app()->user->id
                    );
                    //										$penunjang = PasienmasukpenunjangT::model()->updateByPk($pasienMasukPenunjang->pasienmasukpenunjang_id, $attributes);
                    $penunjang = PasienmasukpenunjangT::model()->deleteByPk($pasienMasukPenunjang->pasienmasukpenunjang_id);
                    if (!$penunjang) {
                      $status = false;
                    }
                    /*
										* cek data tindakan_pelayanan
										*/
                    $attributes = array(
                      'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id,
                      'tindakansudahbayar_id' => null
                    );

                    $criteria2 = new CDbCriteria();
                    $criteria2->addCondition('pasienmasukpenunjang_id = ' . $pasienMasukPenunjang->pasienmasukpenunjang_id);
                    $criteria2->addCondition('tindakansudahbayar_id is null');
                    $tindakan = TindakanpelayananT::model()->findAll($criteria2);

                    if (count((array)$tindakan) > 0) {

                      foreach ($tindakan as $val => $key) {
                        $attributes = array(
                          'tindakanpelayanan_id' => $key->tindakanpelayanan_id
                        );
                        $hapus_komponen = TindakankomponenT::model()->deleteAllByAttributes($attributes);
                      }

                      $attributes = array(
                        'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id
                      );

                      $hapus_tindakan = TindakanPelayananT::model()->deleteAllByAttributes($attributes);
                      if (!$hapus_tindakan) {
                        $status = false;
                        $pesan = "exist";
                      }
                    }
                    //									   else{
                    //										   $status = true;
                    //									   }

                    $criteriaObat2 = new CDbCriteria();
                    $criteriaObat2->addCondition('pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);
                    $criteriaObat2->addCondition('oasudahbayar_id is null');
                    $modObatalkesPasien2 = ObatalkespasienT::model()->findAll($criteriaObat2);

                    if (count((array)$modObatalkesPasien2) > 0) {

                      foreach ($modObatalkesPasien2 as $val => $obat) {
                        $attributes = array(
                          'obatalkespasien_id' => $obat->obatalkespasien_id
                        );
                        $hapusobatalkes = ObatalkeskomponenT::model()->deleteAllByAttributes($attributes);
                      }

                      $hapus_obat = ObatalkespasienT::model()->deleteAllByAttributes($attributes);
                      if (!$hapus_obat) {
                        $status = false;
                        $pesan = "exist";
                      }
                    }
                    //										else{
                    //											$status = true;
                    //										}
                  }

                  if ($status == true) {
                    $pesan = "Pemeriksaan pasien berhasil dibatalkan!";
                    $transaction->commit();
                  } else {
                    $pesan = "Pemeriksaan gagal dibatalkan!";
                    $transaction->rollback();
                  }
                }
              } else {
                if (!empty($modTindakanPelayanan)) {
                  $pesan = "Pemeriksaan tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!";
                } else {
                  $update_tindakanpelayanan = TindakanpelayananT::model()->updateAll(array(
                    'detailhasilpemeriksaanlab_id' => null,
                    'hasilpemeriksaanrm_id' => null,
                    'hasilpemeriksaanrad_id' => null,
                    'hasilpemeriksaanpa_id' => null
                  ), 'pasienmasukpenunjang_id = ' . $pasienmasukpenunjang_id);

                  if ($update_tindakanpelayanan) {
                    $update_tindakan = true;
                    $status = true;
                  } else {
                    $update_tindakan = false;
                    $status = false;
                  }

                  $delete_tindakanpelayanan = TindakanpelayananT::model()->deleteAllByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
                  if ($delete_tindakanpelayanan) {
                    $delete_tindakan = true;
                    $status = true;
                  } else {
                    $delete_tindakan = false;
                    $status = false;
                  }

                  $delete_pasienmasukpenunjang = PasienmasukpenunjangT::model()->deleteByPk($pasienmasukpenunjang_id);
                  if ($delete_pasienmasukpenunjang) {
                    $delete_penunjang = true;
                    $status = true;
                  } else {
                    $delete_penunjang = false;
                    $status = false;
                  }

                  if ($status = true) {
                    $pesan = 'Pasien Penunjang berhasil di batalkan.';
                    $transaction->commit();
                  } else {
                    $pesan = "Pemeriksaan gagal dibatalkan.";
                    $transaction->rollback();
                  }
                }
              }
            } catch (Exception $ex) {
              $status = false;
              $pesan = "exist";
              $transaction->rollback();
            }
          } else {
            $data['status'] = 'Tidak memiliki akses untuk melakukan pembatalan!';
          }
        }
      }

      $data = array(
        'pesan' => $pesan,
        'status' => $status,
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionRincianTagihanPasien($pendaftaran_id, $pasienadmisi_id = null)
  {
    $format = new MyFormatter();
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    // untuk load data pasien
    $criteria = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
    }
    if (!empty($pasienadmisi_id)) {
      $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
    }
    //		$criteria->addInCondition('instalasi_id',array(Params::INSTALASI_ID_RJ,Params::INSTALASI_ID_RD,Params::INSTALASI_ID_RI,Params::INSTALASI_ID_KECANTIKAN));
    $modInfo = InfopasienpengunjungV::model()->find($criteria);
    if (!empty($modInfo->pasienadmisi_id)) { //replace dgn admisi
      $modInfo->instalasi_id = $modInfo->instalasiadmisi_id;
      $modInfo->ruangan_id = $modInfo->ruanganadmisi_id;
      $modInfo->kelaspelayanan_id = $modInfo->kelaspelayananadmisi_id;
      $modInfo->carabayar_id = $modInfo->carabayaradmisi_id;
      $modInfo->penjamin_id = $modInfo->penjaminadmisi_id;
      $modInfo->ruangan_nama = $modInfo->ruanganadmisi_nama;
      $modInfo->kelaspelayanan_nama = $modInfo->kelaspelayananadmisi_nama;
      $modInfo->carabayar_nama = $modInfo->carabayaradmisi_nama;
      $modInfo->penjamin_nama = $modInfo->penjaminadmisi_nama;
    }

    // untuk load data tindakan
    $criteriaTindakan = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteriaTindakan->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    }
    $criteriaTindakan->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id')); //RSSP-1378
    //                $criteriaTindakan->addCondition('instalasi_id = '.Yii::app()->user->getState('instalasi_id'));
    /* komen RSSP-726
		if(!empty($pasienadmisi_id)){
			$criteriaTindakan->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
		}*/
    $criteriaTindakan->group = 'pendaftaran_id, pasien_id, instalasi_id, ruangan_id, kelaspelayanan_id, tgl_tindakan, instalasi_nama, ruangan_nama, kelaspelayanan_nama';
    $criteriaTindakan->select = $criteriaTindakan->group . ', sum(tarif_tindakan) as tarif_tindakan, sum(tarif_medis) as tarif_medis, sum(tarif_bhp) as tarif_bhp, sum(tarif_paramedis) as tarif_paramedis, sum(tarifcyto_tindakan) as tarifcyto_tindakan';
    $criteriaTindakan->order = 'instalasi_id, ruangan_id, tgl_tindakan';
    $modRincianTindakan = RinciantagihantindakanV::model()->findAll($criteriaTindakan);

    // untuk load data obat
    $criteriaObatAlkes = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteriaObatAlkes->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    }
    $criteriaObatAlkes->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id')); //RSSP-1378
    /* komen RSSP-726
		if(!empty($pasienadmisi_id)){
			$criteriaObatAlkes->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
		}*/
    $criteriaObatAlkes->group = 'pendaftaran_id, ruangan_id, kelaspelayanan_id, penjualanresep_id, instalasi_nama, ruangan_nama, kelaspelayanan_nama, noresep, tglpelayanan, qty_oa';
    $criteriaObatAlkes->select = $criteriaObatAlkes->group . ', sum(hargajual_oa) as hargajual_oa, sum(harganetto_oa) as harganetto_oa, sum(hargasatuan_oa) as hargasatuan_oa';
    $criteriaObatAlkes->order  = 'ruangan_id, penjualanresep_id, tglpelayanan';
    $modRincianObatAlkes = RinciantagihanobatalkesV::model()->findAll($criteriaObatAlkes);

    $this->render('billingKasir.views.pembayaranTagihanPasien.printRincianTagihanPasien', array(
      'format' => $format,
      'modInfo' => $modInfo,
      'modRincianTindakan' => $modRincianTindakan,
      'modRincianObatAlkes' => $modRincianObatAlkes
    ));
  }

  public function actionRincianTagihanPasienDetail($pendaftaran_id, $pasienadmisi_id = null)
  {
    $format = new MyFormatter();
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }

    // untuk load data pasien
    $criteria = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
    }
    if (!empty($pasienadmisi_id)) {
      $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
    }
    //		$criteria->addInCondition('instalasi_id',array(Params::INSTALASI_ID_RJ,Params::INSTALASI_ID_RD,Params::INSTALASI_ID_RI,Params::INSTALASI_ID_KECANTIKAN));
    $modInfo = InfopasienpengunjungV::model()->find($criteria);
    if (!empty($modInfo->pasienadmisi_id)) { //replace dgn admisi
      $modInfo->instalasi_id = $modInfo->instalasiadmisi_id;
      $modInfo->ruangan_id = $modInfo->ruanganadmisi_id;
      $modInfo->kelaspelayanan_id = $modInfo->kelaspelayananadmisi_id;
      $modInfo->carabayar_id = $modInfo->carabayaradmisi_id;
      $modInfo->penjamin_id = $modInfo->penjaminadmisi_id;
      $modInfo->ruangan_nama = $modInfo->ruanganadmisi_nama;
      $modInfo->kelaspelayanan_nama = $modInfo->kelaspelayananadmisi_nama;
      $modInfo->carabayar_nama = $modInfo->carabayaradmisi_nama;
      $modInfo->penjamin_nama = $modInfo->penjaminadmisi_nama;
    }

    // untuk load data tindakan
    $criteriaTindakan = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteriaTindakan->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    }
    //		if(!empty($pasienadmisi_id)){
    //			$criteriaTindakan->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
    //		}
    $criteriaTindakan->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id')); //RSSP-1378
    //                $criteriaTindakan->addCondition('instalasi_id = '.Yii::app()->user->getState('instalasi_id'));
    $criteriaTindakan->order = 'instalasi_id, ruangan_id, tgl_tindakan';
    $modRincianTindakan = RinciantagihantindakanV::model()->findAll($criteriaTindakan);

    // untuk load data obat
    $criteriaObatAlkes = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteriaObatAlkes->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    }
    //		if(!empty($pasienadmisi_id)){
    //			$criteriaObatAlkes->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
    //		}
    $criteriaObatAlkes->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id')); //RSSP-1378
    $criteriaObatAlkes->order = 'ruangan_id, penjualanresep_id, tglpelayanan';
    $modRincianObatAlkes = RinciantagihanobatalkesV::model()->findAll($criteriaObatAlkes);

    $this->render('printRincianTagihanPasienDetail', array(
      'format' => $format,
      'modInfo' => $modInfo,
      'modRincianTindakan' => $modRincianTindakan,
      'modRincianObatAlkes' => $modRincianObatAlkes,
      'is_total_instalasi' => TRUE,
    ));
  }

  public function actionRincianPembayaranPasien($pendaftaran_id, $pembayaranpelayanan_id = null)
  {
    $format = new MyFormatter();
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }

    // untuk load data pasien
    $criteria = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
    }
    $modInfo = InfopasienpengunjungV::model()->find($criteria);
    if (!empty($modInfo->pasienadmisi_id)) { //replace dgn admisi
      $modInfo->instalasi_id = $modInfo->instalasiadmisi_id;
      $modInfo->ruangan_id = $modInfo->ruanganadmisi_id;
      $modInfo->kelaspelayanan_id = $modInfo->kelaspelayananadmisi_id;
      $modInfo->carabayar_id = $modInfo->carabayaradmisi_id;
      $modInfo->penjamin_id = $modInfo->penjaminadmisi_id;
      $modInfo->ruangan_nama = $modInfo->ruanganadmisi_nama;
      $modInfo->kelaspelayanan_nama = $modInfo->kelaspelayananadmisi_nama;
      $modInfo->carabayar_nama = $modInfo->carabayaradmisi_nama;
      $modInfo->penjamin_nama = $modInfo->penjaminadmisi_nama;
    }

    // untuk load data tindakan
    $criteriaTindakan = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteriaTindakan->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    }
    if (!empty($pembayaranpelayanan_id)) {
      $criteriaTindakan->addCondition('pembayaranpelayanan_id = ' . $pembayaranpelayanan_id);
    }
    $criteriaTindakan->addCondition('tindakansudahbayar_id is not null');
    $criteriaTindakan->group = 'pendaftaran_id, pasien_id, instalasi_id, ruangan_id, kelaspelayanan_id, tgl_tindakan, instalasi_nama, ruangan_nama, kelaspelayanan_nama';
    $criteriaTindakan->select = $criteriaTindakan->group . ', sum(tarif_satuan*qty_tindakan) as tarif_tindakan, sum(tarif_medis) as tarif_medis, sum(tarif_bhp) as tarif_bhp, sum(tarif_paramedis) as tarif_paramedis, sum(tarifcyto_tindakan) as tarifcyto_tindakan'; //RSSP-765
    $criteriaTindakan->order = 'instalasi_id, ruangan_id, tgl_tindakan';
    $modRincianTindakan = RincianbayartindakanV::model()->findAll($criteriaTindakan);

    // untuk load data obat
    $criteriaObatAlkes = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteriaObatAlkes->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    }
    if (!empty($pembayaranpelayanan_id)) {
      $criteriaObatAlkes->addCondition('pembayaranpelayanan_id = ' . $pembayaranpelayanan_id);
    }
    $criteriaObatAlkes->addCondition('oasudahbayar_id is not null');
    $criteriaObatAlkes->group = 'pendaftaran_id, ruangan_id, kelaspelayanan_id, penjualanresep_id, instalasi_nama, ruangan_nama, kelaspelayanan_nama, noresep, tglpelayanan, qty_oa';
    $criteriaObatAlkes->select = $criteriaObatAlkes->group . ', sum(hargajual_oa) as hargajual_oa, sum(harganetto_oa) as harganetto_oa, sum(hargasatuan_oa) as hargasatuan_oa';
    $criteriaObatAlkes->order  = 'ruangan_id, penjualanresep_id, tglpelayanan';
    $modRincianObatAlkes = RincianbayarobatalkesV::model()->findAll($criteriaObatAlkes);

    if (empty($pembayaranpelayanan_id)) {
      $modPembayaranPelayanan = new PembayaranpelayananT();
      $modPemakaianUangMuka = new PemakaianuangmukaT();
      $modTandaBuktiBayar = new TandabuktibayarT();
    } else {
      // untuk load pembayaran pelayanan
      $modPembayaranPelayanan = PembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
      // untuk load pemakaian uang muka
      $modPemakaianUangMuka = PemakaianuangmukaT::model()->findByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));
      // untuk load tanda bukti bayar
      $modTandaBuktiBayar = TandabuktibayarT::model()->findByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));
    }


    $this->render('billingKasir.views.pembayaranTagihanPasien.printRincianPembayaranPasien', array(
      'format' => $format,
      'modInfo' => $modInfo,
      'modRincianTindakan' => $modRincianTindakan,
      'modRincianObatAlkes' => $modRincianObatAlkes,
      'modPembayaranPelayanan' => $modPembayaranPelayanan,
      'modPemakaianUangMuka' => $modPemakaianUangMuka,
      'modTandaBuktiBayar' => $modTandaBuktiBayar
    ));
  }


  public function actionVerifikasiPJA() {
      if (!Yii::app()->request->isAjaxRequest) {
          Yii::app()->end();
      }

      
      $pendaftaran_id = $_POST['verifikasi']['pendaftaran_id'];
      $pasienpulang_id = $_POST['verifikasi']['pasienpulang_id'];
      $tgl = MyFormatter::formatDateTimeForDB($_POST['verifikasi']['tanggal_approvaltindaklanjut'] ?? date('Y-m-d H:i:s'));
      $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      try {

        /*
          // fungsi ini hanya untuk pasien yang baru tindak lanjut ke RI (belum sampai pasien admisi)
          if (!empty($pendaftaran->pasienadmisi_id)) {
              echo CJSON::encode(array(
                  'ok'=>1,
                  'msg'=>'Pasien sudah dilakukan admisi ke rawat inap.',
              ));
              Yii::app()->end();
          }
          */

          $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
              'pendaftaran_id'=>$pendaftaran_id,
              'ruangan_id'=>Params::RUANGAN_ID_FORENSIC,
          ), array(
              'condition'=>'isapprovaltindaklanjut = false or isapprovaltindaklanjut is null'
          ));
          $oa = ObatalkespasienT::model()->findAllByAttributes(array(
              'pendaftaran_id'=>$pendaftaran_id,
              'ruangan_id'=>Params::RUANGAN_ID_FORENSIC,
          ), array(
              'condition'=>'isapprovaltindaklanjut = false or isapprovaltindaklanjut is null'
          ));

          foreach ($tindakan as $item) {
              $item->userapprovaltindaklanjut_id = $_POST['verifikasi']['userapprovaltindaklanjut_id'];
              $item->tanggal_approvaltindaklanjut = $tgl;
              $item->isapprovaltindaklanjut = true;
              $item->ruangan_id_approvaltindaklanjut = Yii::app()->user->getState('ruangan_id');


              // $item->userpembatalanapprovaltl_id = null;
              // $item->tanggalbatal_approvaltl = null;
              $item->ispembatalanapprovaltl = false;
              
              $ok = $ok && $item->save(false, array(
                  'userapprovaltindaklanjut_id', 'tanggal_approvaltindaklanjut', 'isapprovaltindaklanjut',
                  // 'userpembatalanapprovaltl_id', 'tanggalbatal_approvaltl',
                  'ispembatalanapprovaltl', 'ruangan_id_approvaltindaklanjut'
              ));

              
          }

          foreach ($oa as $item) {
              $item->userapprovaltindaklanjut_id = $_POST['verifikasi']['userapprovaltindaklanjut_id'];
              $item->tanggal_approvaltindaklanjut = $tgl;
              $item->isapprovaltindaklanjut = true;
              $item->ruangan_id_approvaltindaklanjut = Yii::app()->user->getState('ruangan_id');
              
              // $item->userpembatalanapprovaltl_id = null;
              // $item->tanggalbatal_approvaltl = null;
              $item->ispembatalanapprovaltl = false;
              
              $ok = $ok && $item->save(false, array(
                  'userapprovaltindaklanjut_id', 'tanggal_approvaltindaklanjut', 'isapprovaltindaklanjut',
                  // 'userpembatalanapprovaltl_id', 'tanggalbatal_approvaltl',
                  'ispembatalanapprovaltl', 'ruangan_id_approvaltindaklanjut'
              ));

              
          }

          $pulang = PasienpulangT::model()->findByPk($pasienpulang_id);

          // var_dump($pulang->attributes); die;
          if (!empty($pulang)) {
            $pulang->userapprovaltindaklanjut_id = $_POST['verifikasi']['userapprovaltindaklanjut_id'];
            $pulang->keterangantidakmelakukantindakan = "";
            $pulang->tanggal_approvaltindaklanjut = $tgl;
            $pulang->isapprovaltindaklanjut = true;
            $pulang->ispembatalanapprovaltl = false;
    
            $ok = $ok && $pulang->save(false, array(
              'userapprovaltindaklanjut_id', 'tanggal_approvaltindaklanjut', 'isapprovaltindaklanjut',
              'keterangantidakmelakukantindakan',
              // 'userpembatalanapprovaltl_id', 'tanggalbatal_approvaltl',
              'ispembatalanapprovaltl'
            ));
          }


          $ok = $ok && $this->kirimNotifPJA($pendaftaran, $tgl, $_POST['verifikasi']['userapprovaltindaklanjut_id']);

          if ($ok) {
              $trans->commit();
              echo CJSON::encode(array(
                  'ok'=>1,
                  'msg'=>'Validasi PJA berhasil disimpan.',
              ));
              Yii::app()->end();
          } else {
              $trans->rollback();
              echo CJSON::encode(array(
                  'ok'=>0,
                  'msg'=>'Validasi PJA gagal disimpan.',
              ));
              Yii::app()->end();
          }
          
          // var_dump($_POST); die;


      } catch (CException $e) {
          $trans->rollback();
          echo CJSON::encode(array(
              'ok'=>0,
              'msg'=>'ERROR - '.$e->getMessage(),
          ));
          Yii::app()->end();
      }

      
  }

  public function actionBatalPJA() {
      if (!Yii::app()->request->isAjaxRequest) {
          Yii::app()->end();
      }

      $pendaftaran_id = $_POST['pendaftaran_id'];
      $pasienpulang_id = $_POST['pasienpulang_id'];
      $tgl = date('Y-m-d H:i:s');
      $peg_id = Yii::app()->user->getState('pegawai_id');
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;

      try {

          $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
              'pendaftaran_id'=>$pendaftaran_id,
              'ruangan_id_approvaltindaklanjut'=>Yii::app()->user->getState('ruangan_id'),
              'ruangan_id'=>Params::RUANGAN_ID_FORENSIC,
          ));
          $oa = ObatalkespasienT::model()->findAllByAttributes(array(
              'pendaftaran_id'=>$pendaftaran_id,
              'ruangan_id_approvaltindaklanjut'=>Yii::app()->user->getState('ruangan_id'),
              'ruangan_id'=>Params::RUANGAN_ID_FORENSIC,
          ));

          foreach ($tindakan as $item) {
              // $item->userapprovaltindaklanjut_id = null;
              // $item->tanggal_approvaltindaklanjut = null;
              $item->isapprovaltindaklanjut = false;

              $item->userpembatalanapprovaltl_id = $peg_id;
              $item->tanggalbatal_approvaltl = $tgl;
              $item->ispembatalanapprovaltl = true;
              $item->ruangan_id_approvaltindaklanjut = null;

              
              $ok = $ok && $item->save(true, array(
                  'userpembatalanapprovaltl_id', 'tanggalbatal_approvaltl', 'ispembatalanapprovaltl',
                  'isapprovaltindaklanjut', 'ruangan_id_approvaltindaklanjut'
              ));

              // var_dump($ok, $item->isapprovaltindaklanjut);
          }

          foreach ($oa as $item) {
              // $item->userapprovaltindaklanjut_id = null;
              // $item->tanggal_approvaltindaklanjut = null;
              $item->isapprovaltindaklanjut = false;


              $item->userpembatalanapprovaltl_id = $peg_id;
              $item->tanggalbatal_approvaltl = $tgl;
              $item->ispembatalanapprovaltl = true;
              $item->ruangan_id_approvaltindaklanjut = null;
              
              

              $ok = $ok && $item->save(false, array(
                  'userpembatalanapprovaltl_id', 'tanggalbatal_approvaltl', 'ispembatalanapprovaltl',
                  'isapprovaltindaklanjut', 'ruangan_id_approvaltindaklanjut'
              ));

              // var_dump($item->attributes);
          }


          $pulang = PasienpulangT::model()->findByPk($pasienpulang_id);

          if (!empty($pulang)) {
            $pulang->isapprovaltindaklanjut = false;

            $pulang->userpembatalanapprovaltl_id = $peg_id;
            $pulang->tanggalbatal_approvaltl = $tgl;
            $pulang->ispembatalanapprovaltl = true;

            
            $ok = $ok && $pulang->save(true, array(
                'userpembatalanapprovaltl_id', 'tanggalbatal_approvaltl', 'ispembatalanapprovaltl',
                'isapprovaltindaklanjut'
            ));
          }

          // var_dump($ok); die;

          if ($ok) {
              $trans->commit();
              echo CJSON::encode(array(
                  'ok'=>1,
                  'msg'=>'Validasi PJA berhasil dibatalkan.',
              ));
              Yii::app()->end();
          } else {
              $trans->rollback();
              echo CJSON::encode(array(
                  'ok'=>0,
                  'msg'=>'Validasi PJA gagal dibatalkan.',
              ));
              Yii::app()->end();
          }

      } catch (CException $e) {
          $trans->rollback();
          echo CJSON::encode(array(
              'ok'=>0,
              'msg'=>'ERROR - '.$e->getMessage(),
          ));
          Yii::app()->end();
      }

  }

  function kirimNotifPJA($pendaftaran, $tgl, $approval_id) {
      $msg = "Telah divalidasi PJA atas nama {{nama_pasien}} dengan {{no_rekam_medik}} pada {{tanggal_validasi}}";

      $msg = str_replace("{{nama_pasien}}", $pendaftaran->pasien->nama_pasien, $msg);
      $msg = str_replace("{{no_rekam_medik}}", $pendaftaran->pasien->no_rekam_medik, $msg);
      $msg = str_replace("{{tanggal_validasi}}", MyFormatter::formatDateTimeForUser($tgl), $msg);

      $ruangan_keuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_KEUANGAN);

      // var_dump($ruangan_keuangan->attributes); die;

      return CustomFunction::broadcastNotif("Validasi PJA", $msg, array(
          array('instalasi_id' => $ruangan_keuangan->instalasi_id, 'ruangan_id' => $ruangan_keuangan->ruangan_id, 'modul_id' =>$ruangan_keuangan->modul_id),
      ));

      // var_dump($msg); die;
  }


  public function actionVerifikasiPJANonTindakan() {
    if (!Yii::app()->request->isAjaxRequest) {
        Yii::app()->end();
    }

    
    $pendaftaran_id = $_POST['verifikasi']['pendaftaran_id'];
    $pasienpulang_id = $_POST['verifikasi']['pasienpulang_id'];
    $tgl = MyFormatter::formatDateTimeForDB($_POST['verifikasi']['tanggal_approvaltindaklanjut'] ?? date('Y-m-d H:i:s'));
    $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

    $trans = Yii::app()->db->beginTransaction();
    $ok = true;

    try {


        $pulang = PasienpulangT::model()->findByPk($pasienpulang_id);

        // var_dump($pulang->attributes); die;
        if (empty($pulang)) {
          $ok = false;
        } else {
          $pulang->userapprovaltindaklanjut_id = $_POST['verifikasi']['userapprovaltindaklanjut_id'];
          $pulang->keterangantidakmelakukantindakan = $_POST['verifikasi']['keterangantidakmelakukantindakan'];
          $pulang->tanggal_approvaltindaklanjut = $tgl;
          $pulang->isapprovaltindaklanjut = true;
          $pulang->ispembatalanapprovaltl = false;
  
          $ok = $ok && $pulang->save(false, array(
            'userapprovaltindaklanjut_id', 'tanggal_approvaltindaklanjut', 'isapprovaltindaklanjut',
            'keterangantidakmelakukantindakan',
            // 'userpembatalanapprovaltl_id', 'tanggalbatal_approvaltl',
            'ispembatalanapprovaltl'
          ));
        }


        // var_dump($ok, $pulang->attributes); die;
        

        // $ok = $ok && $this->kirimNotifPJA($pendaftaran, $tgl, $_POST['verifikasi']['userapprovaltindaklanjut_id']);

        if ($ok) {
            $trans->commit();
            echo CJSON::encode(array(
                'ok'=>1,
                'msg'=>'Validasi PJA berhasil disimpan.',
            ));
            Yii::app()->end();
        } else {
            $trans->rollback();
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Validasi PJA gagal disimpan.',
            ));
            Yii::app()->end();
        }
        
        // var_dump($_POST); die;


    } catch (CException $e) {
        $trans->rollback();
        echo CJSON::encode(array(
            'ok'=>0,
            'msg'=>'ERROR - '.$e->getMessage(),
        ));
        Yii::app()->end();
    }

    
  }

  public function actionBatalPJANonTindakan() {
    if (!Yii::app()->request->isAjaxRequest) {
        Yii::app()->end();
    }

    $pendaftaran_id = $_POST['pendaftaran_id'];
    $pasienpulang_id = $_POST['pasienpulang_id'];
    $tgl = date('Y-m-d H:i:s');
    $peg_id = Yii::app()->user->getState('pegawai_id');
    $trans = Yii::app()->db->beginTransaction();
    $ok = true;

    try {

        $pulang = PasienpulangT::model()->findByPk($pasienpulang_id);

        if (empty($pulang)) {
          $ok = false;
        } else {
          $pulang->isapprovaltindaklanjut = false;

          $pulang->userpembatalanapprovaltl_id = $peg_id;
          $pulang->tanggalbatal_approvaltl = $tgl;
          $pulang->ispembatalanapprovaltl = true;

          
          $ok = $ok && $pulang->save(true, array(
              'userpembatalanapprovaltl_id', 'tanggalbatal_approvaltl', 'ispembatalanapprovaltl',
              'isapprovaltindaklanjut'
          ));
        }

        

        // var_dump($ok); die;

        if ($ok) {
            $trans->commit();
            echo CJSON::encode(array(
                'ok'=>1,
                'msg'=>'Validasi PJA berhasil dibatalkan.',
            ));
            Yii::app()->end();
        } else {
            $trans->rollback();
            echo CJSON::encode(array(
                'ok'=>0,
                'msg'=>'Validasi PJA gagal dibatalkan.',
            ));
            Yii::app()->end();
        }

    } catch (CException $e) {
        $trans->rollback();
        echo CJSON::encode(array(
            'ok'=>0,
            'msg'=>'ERROR - '.$e->getMessage(),
        ));
        Yii::app()->end();
    }

  }


}
