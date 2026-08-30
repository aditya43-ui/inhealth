<?php

class PengajuanbahanmknController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'gizi.views.pengajuanbahanmkn.';
  public $path_views = 'gizi.views.';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render($this->path_view . 'view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionIndex($id = '', $rencana_id = null)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $this->pageTitle = Yii::app()->name . " - Permintaan Pembelian Bahan Makanan";
    $model = new GZPengajuanbahanmkn;
    $modDetailPengajuan = new PengajuanbahandetailT;

    $profil = ProfilrumahsakitM::model()->find();
    if (!empty($profil)) {
      $kelrh = (!empty($profil->kelurahan_id) ? $profil->kelurahan->kelurahan_nama : null);
      $kec = (!empty($profil->kecamatan_id) ? $profil->kecamatan->kecamatan_nama : null);
      $kab = (!empty($profil->kabupaten_id) ? $profil->kabupaten->kabupaten_nama : null);
      $prov = (!empty($profil->propinsi_id) ? $profil->propinsi->propinsi_nama : null);
      $alamatpengirim = $profil->alamatlokasi_rumahsakit . ", " . $kelrh . ", " . $kec . ", " . $kab . ", " . $prov . " " . $profil->kodepos;
      $model->alamatpengiriman = $alamatpengirim;
    }

    //		$model->alamatpengiriman = ProfilrumahsakitM::model()->find()->alamatlokasi_rumahsakit;
    $model->nopengajuan = "Otomatis";
    $model->tglpengajuanbahan = date('d M Y H:i:s');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $pegawai_id = LoginpemakaiK::model()->findByPk(Yii::app()->user->id);
    $model->idpegawai_mengajukan = $pegawai_id->pegawai_id;
    $model->idpegawai_mengajukan_nama = (!empty($pegawai_id)) ? $pegawai_id->pegawai->namaLengkap : null;
    $model->is_uangmukapembelian = false;
    $model->tglpermintaanuangmuka = date('d M Y H:i:s');

    $modSupplier = new SupplierM;

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

    if (!empty($rencana_id)) {
      $rencana = RenkebbahanmakananT::model()->findByPk($rencana_id);
      if (!empty($rencana)) {
        $model->renkebbahanmakanan_id = $rencana->renkebbahanmakanan_id;
        $model->renkebbahanmakanan_no = $rencana->renkebbahanmakanan_no;
        $model->renkebbahanmakanan_tgl = MyFormatter::formatDateTimeForUser($rencana->renkebbahanmakanan_tgl);
        $model->sumberdana_id = $rencana->sumberdana_id;
        $model->sumberdanabhn = (!empty($rencana->sumberdana_id) ? $rencana->sumberdana->sumberdana_nama : "");
      }
    }

    $konfig = ApprovalotorisasiM::model()->find();
    if (!empty($konfig)) {
      if ($model->sumberdana_id == Params::SUMBERDANA_ID_PT) {
        $model->idpegawai_mengetahui = $konfig->managerumumpt_id;
        $model->idpegawai_mengetahui_nama = (!empty($konfig->managerumumpt_id) ? $konfig->managerumumpt->namaLengkap : "");
        $model->idpegawai_mengetahui2 = $konfig->managerkeuanganpt_id;
        $model->idpegawai_mengetahui2_nama = (!empty($konfig->managerkeuanganpt_id) ? $konfig->managerkeuanganpt->namaLengkap : "");
        $model->idpegawai_menyetujui = $konfig->direkturpt_id;
        $model->idpegawai_menyetujui_nama = (!empty($konfig->direkturpt_id) ? $konfig->direkturpt->namaLengkap : "");
      } else {
        $model->idpegawai_mengetahui = $konfig->managerumum_id;
        $model->idpegawai_mengetahui_nama = (!empty($konfig->managerumum_id) ? $konfig->managerumum->namaLengkap : "");
        $model->idpegawai_mengetahui2 = $konfig->managerkeuangan_id;
        $model->idpegawai_mengetahui2_nama = (!empty($konfig->managerkeuangan_id) ? $konfig->managerkeuangan->namaLengkap : "");
        $model->idpegawai_menyetujui = $konfig->direkturrs_id;
        $model->idpegawai_menyetujui_nama = (!empty($konfig->direkturrs_id) ? $konfig->direkturrs->namaLengkap : "");
      }
    }



    if (!empty($id)) {
      $model = GZPengajuanbahanmkn::model()->findByPk($id);
      if (!empty($model->mengajukan))
        $model->idpegawai_mengajukan_nama = $model->mengajukan->nama_pegawai;
      if (!empty($model->mengetahui))
        $model->idpegawai_mengetahui_nama = $model->mengetahui->nama_pegawai;
      if (!empty($model->menyetujui))
        $model->idpegawai_menyetujui_nama = $model->menyetujui->nama_pegawai;
      if (!empty($model->mengetahui2))
        $model->idpegawai_mengetahui2_nama = $model->mengetahui2->nama_pegawai;
      if (!empty($model->renkebbahanmakanan_id)) {
        $rencana = RenkebbahanmakananT::model()->findByPk($model->renkebbahanmakanan_id);
        if (!empty($rencana)) {
          $model->renkebbahanmakanan_id = $rencana->renkebbahanmakanan_id;
          $model->renkebbahanmakanan_no = $rencana->renkebbahanmakanan_no;
          $model->renkebbahanmakanan_tgl = MyFormatter::formatDateTimeForUser($rencana->renkebbahanmakanan_tgl);
        }
      }

      if (!empty($model->tglpermintaanuangmuka)) {
        $model->is_uangmukapembelian = true;
      } else {
        $model->is_uangmukapembelian = false;
      }

      $modSupplier = SupplierM::model()->findByPk($model->supplier_id);
      $modDetails = PengajuanbahandetailT::model()->findAllByAttributes(array('pengajuanbahanmkn_id' => $model->pengajuanbahanmkn_id));

//      if (!empty($konfig)) {
//        $model->idpegawai_mengetahui = $konfig->managerumum_id;
//        $model->idpegawai_mengetahui_nama = $konfig->managerUmum->nama_pegawai;
//        $model->idpegawai_mengetahui2 = $konfig->managerkeuangan_id;
//        $model->idpegawai_mengetahui2_nama = $konfig->managerKeuangan->nama_pegawai;
//        $model->idpegawai_menyetujui = $konfig->direkturrs_id;
//        $model->idpegawai_menyetujui_nama = $konfig->direkturRS->nama_pegawai;
//      }
    }

    if (isset($_POST['GZPengajuanbahanmkn'])) {

      $model->attributes = $_POST['GZPengajuanbahanmkn'];
      if ($model->sumberdana_id == Params::SUMBERDANA_ID_PT) {
        $model->nopengajuan = MyGenerator::noPengajuanBahan("SHB");
      } else {
        $model->nopengajuan = MyGenerator::noPengajuanBahan();
      }
      if (!empty($_POST['GZPengajuanbahanmkn']['is_uangmukapembelian']) && $_POST['GZPengajuanbahanmkn']['is_uangmukapembelian'] == 1) {
        if (!empty($model->tglpermintaanuangmuka)) {
          $model->tglpermintaanuangmuka = MyFormatter::formatDateTimeForDb($model->tglpermintaanuangmuka);
        }
      } else {
        $model->tglpermintaanuangmuka = null;
      }

      if (isset($_GET['ubah'])) {
        $model->update_time = date('Y-m-d H:i:s');
        $model->update_loginpemakai_id = Yii::app()->user->id;
      } else {
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_time = date('Y-m-d H:i:s');
      }

      $model->tglpengajuanbahan = MyFormatter::formatDateTimeForDb($model->tglpengajuanbahan);
      $model->tglmintadikirim = MyFormatter::formatDateTimeForDb($model->tglmintadikirim);
      //			$model->totalharganetto = str_replace(".","", $model->totalharganetto);
      $model->tglmintadikirim  = $_POST['GZPengajuanbahanmkn']['tglmintadikirim'];

      // var_dump($_POST, $model->attributes); die;

      if ($model->validate()) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $success = true;

          if ($model->save()) {
            if (isset($_GET['ubah'])) {
              PengajuanbahandetailT::model()->deleteAllByAttributes(array('pengajuanbahanmkn_id' => $model->pengajuanbahanmkn_id));
            }
            foreach ($_POST['PengajuanbahandetailT'] as $i => $data) {
              // var_dump($data);
              if ($data['checkList']) {
                $modDetails = new PengajuanbahandetailT();
                $modDetails->attributes = $data;
                $modDetails->pengajuanbahanmkn_id = $model->pengajuanbahanmkn_id;
                $modDetails->nourutbahan = 1;
                $modDetails->qty_pengajuan = $data['qty_pengajuan'];

                if (!is_numeric($modDetails->jmlkemasan)) {
                  $modDetails->jmlkemasan = 0;
                }
                if (!is_numeric($modDetails->qty_pengajuan)) {
                  $modDetails->qty_pengajuan = 0;
                }

                // var_dump($modDetails->attributes);

                if ($modDetails->validate()) {
                  $modDetails->save();
                } else {
                  $success = false;
                }
              }
            }
          }

          $this->notifPermintaanPembelian($model);

          // var_dump($success); die;
          if ($success == true) {
            $smscp1 = 0;
            $smscp2 = 0;
            // SMS GATEWAY
            if (Yii::app()->user->getState('issmsgateway')) {
              $modSupplier = SupplierM::model()->findByPk($model->supplier_id);
              $sms = new Sms();
              $smscp1 = 1;
              $smscp2 = 1;
              /*
							foreach ($modSmsgateway as $i => $smsgateway) {
								$isiPesan = $smsgateway->templatesms;

								$attributes = $model->getAttributes();
								foreach($attributes as $attributes => $value){
									$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
								}
								$attributes = $modSupplier->getAttributes();
								foreach($attributes as $attributes => $value){
									$isiPesan = str_replace("{{".$attributes."}}",$value,$isiPesan);
								}
								$isiPesan = str_replace("{{hari}}",MyFormatter::getDayName($model->tglpengajuanbahan),$isiPesan);
								$isiPesan = str_replace("{{nama_rumahsakit}}",Yii::app()->user->getState('nama_rumahsakit'),$isiPesan);
								if($smsgateway->tujuansms == Params::TUJUANSMS_SUPPLIER && $smsgateway->statussms){
									if(!empty($modSupplier->supplier_cp_hp)){
										$sms->kirim($modSupplier->supplier_cp_hp,$isiPesan);
									}else{
										$smscp1 = 0;
										if(!empty($modSupplier->supplier_cp2_hp)){
											$sms->kirim($modSupplier->supplier_cp2_hp,$isiPesan);
										}else{
											$smscp2 = 0;
										}
									}

								}

							}
							 *
							 */
            }
            // END SMS GATEWAY

            $transaction->commit();
            Yii::app()->user->setFlash('success', ' Data ' . $model->nopengajuan . ' berhasil disimpan.');
            $this->redirect(array('index', 'id' => $model->pengajuanbahanmkn_id, 'sukses' => 1, 'smscp1' => $smscp1, 'smscp2' => $smscp2));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          }
        } catch (Exception $ex) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . $ex->getMessage());
        }
      } else {
        Yii::app()->user->setFlash('error', 'Data detail barang harus diisi.');
      }
    }
    if (empty($modDetails)) {
      $modDetails = null;
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model, 'modDetails' => $modDetails, 'modDetailPengajuan' => $modDetailPengajuan, 'modSupplier' => $modSupplier
    ));
  }


  public function notifPermintaanPembelian($model)
  {

    $pemesan = "-";
    $mengetahui = "-";
    $mengetahui_umum = "-";
    $menyetujui = "-";

    if (!empty($model->idpegawai_mengajukan)) {
      $peg = PegawaiM::model()->findByPk($model->idpegawai_mengajukan);
      if (!empty($peg)) {
        $pemesan = $peg->namaLengkap;
      }
    }
    if (!empty($model->idpegawai_mengetahui2)) {
      $peg = PegawaiM::model()->findByPk($model->idpegawai_mengetahui2);
      if (!empty($peg)) {
        $mengetahui = $peg->namaLengkap;
      }
    }
    if (!empty($model->idpegawai_mengetahui)) {
      $peg = PegawaiM::model()->findByPk($model->idpegawai_mengetahui);
      if (!empty($peg)) {
        $mengetahui_umum = $peg->namaLengkap;
      }
    }
    if (!empty($model->idpegawai_menyetujui)) {
      $peg = PegawaiM::model()->findByPk($model->idpegawai_menyetujui);
      if (!empty($peg)) {
        $menyetujui = $peg->namaLengkap;
      }
    }


    $judul = "Permintaan Pembelian Bahan Makanan";
    $isi = "Tgl. Pembelian : " . MyFormatter::formatDateTimeForUser($model->tglpengajuanbahan) . "<br/>";
    $isi .= "No. Pembelian : " . $model->nopengajuan . "<br/>";
    $isi .= "Mengajukan : " . $pemesan . "<br/>";
    $isi .= "Manajer Umum : " . $mengetahui_umum . "<br/>";
    $isi .= "Manajer Keuangan : " . $mengetahui . "<br/>";
    $isi .= "Direktur : " . $menyetujui . "<br/>";

    $ruangan_gudang = RuanganM::model()->findByPk(Params::RUANGAN_ID_LOGISTIK);
    $ruangan_keuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
    $ruangan_purchasing = RuanganM::model()->findByPk(Params::RUANGAN_ID_GUDANG_UMUM);
    $ruangan_gizi = RuanganM::model()->findByPk(Params::RUANGAN_ID_GIZI);


    $link_keuangan = $this->createUrl('/keuangan/PengajuanbahanmknKU/Informasi', array(
      'GZPengajuanbahanmkn[tgl_awal]' => date('Y-m-d', strtotime($model->tglpengajuanbahan)),
      'GZPengajuanbahanmkn[tgl_akhir]' => date('Y-m-d', strtotime($model->tglpengajuanbahan)),
      'GZPengajuanbahanmkn[nopengajuan]' => $model->nopengajuan,
    ));

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruangan_gudang->instalasi_id, 'ruangan_id' => $ruangan_gudang->ruangan_id, 'modul_id' => $ruangan_gudang->modul_id),
      array('instalasi_id' => $ruangan_keuangan->instalasi_id, 'ruangan_id' => $ruangan_keuangan->ruangan_id, 'modul_id' => $ruangan_keuangan->modul_id, 'link_proses' => $link_keuangan),
      array('instalasi_id' => $ruangan_purchasing->instalasi_id, 'ruangan_id' => $ruangan_purchasing->ruangan_id, 'modul_id' => $ruangan_purchasing->modul_id),
      array('instalasi_id' => $ruangan_gizi->instalasi_id, 'ruangan_id' => $ruangan_gizi->ruangan_id, 'modul_id' => $ruangan_gizi->modul_id),
    ));
  }



  //    public function notifMengetahuiUmumPermintaanPembelian($id) {
  //
  //        $model = GZPengajuanbahanmkn::model()->findByPk($id);
  //
  //        $pemesan = "-";
  //        $mengetahui = "-";
  //        $mengetahui_umum = "-";
  //        $menyetujui = "-";
  //
  //        if (!empty($model->idpegawai_mengajukan)) {
  //            $peg = PegawaiM::model()->findByPk($model->idpegawai_mengajukan);
  //            if (!empty($peg)) {
  //                $pemesan = $peg->namaLengkap;
  //            }
  //        }
  //        if (!empty($model->idpegawai_mengetahui2)) {
  //            $peg = PegawaiM::model()->findByPk($model->idpegawai_mengetahui2);
  //            if (!empty($peg)) {
  //                $mengetahui = $peg->namaLengkap;
  //            }
  //        }
  //        if (!empty($model->idpegawai_mengetahui)) {
  //            $peg = PegawaiM::model()->findByPk($model->idpegawai_mengetahui);
  //            if (!empty($peg)) {
  //                $mengetahui_umum = $peg->namaLengkap;
  //            }
  //        }
  //        if (!empty($model->idpegawai_menyetujui)) {
  //            $peg = PegawaiM::model()->findByPk($model->idpegawai_menyetujui);
  //            if (!empty($peg)) {
  //                $menyetujui = $peg->namaLengkap;
  //            }
  //        }
  //
  //
  //        $judul = "Approval Permintaan Pembelian Bahan Makanan - Manager Umum";
  //        $isi = "Tgl. Approval : ". MyFormatter::formatDateTimeForUser($model->tgl_mengetahui)."<br/>";
  //        $isi .= "No. Pembelian : ".$model->nopengajuan."<br/>";
  //        //$isi .= "Pemesan : ".$pemesan."<br/>";
  //        $isi .= "Manajer Umum : ".$mengetahui_umum."<br/>";
  //        //$isi .= "Manajer Keuangan : ".$mengetahui."<br/>";
  //        //$isi .= "Direktur : ".$menyetujui."<br/>";
  //
  //        $ruangan_gudang = RuanganM::model()->findByPk(Params::RUANGAN_ID_LOGISTIK);
  //        $ruangan_keuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
  //        $ruangan_purchasing = RuanganM::model()->findByPk(Params::RUANGAN_ID_GUDANG_UMUM);
  //        $ruangan_gizi = RuanganM::model()->findByPk(Params::RUANGAN_ID_GIZI);
  //
  //        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
  //            array('instalasi_id'=>$ruangan_gudang->instalasi_id, 'ruangan_id'=>$ruangan_gudang->ruangan_id, 'modul_id'=>$ruangan_gudang->modul_id),
  //            array('instalasi_id'=>$ruangan_keuangan->instalasi_id, 'ruangan_id'=>$ruangan_keuangan->ruangan_id, 'modul_id'=>$ruangan_keuangan->modul_id),
  //            array('instalasi_id'=>$ruangan_purchasing->instalasi_id, 'ruangan_id'=>$ruangan_purchasing->ruangan_id, 'modul_id'=>$ruangan_purchasing->modul_id),
  //            array('instalasi_id'=>$ruangan_gizi->instalasi_id, 'ruangan_id'=>$ruangan_gizi->ruangan_id, 'modul_id'=>$ruangan_gizi->modul_id),
  //        ));
  //    }
  //
  //    public function notifMengetahuiPermintaanPembelian($id) {
  //
  //        $model = GZPengajuanbahanmkn::model()->findByPk($id);
  //
  //        $pemesan = "-";
  //        $mengetahui = "-";
  //        $mengetahui_umum = "-";
  //        $menyetujui = "-";
  //
  //        if (!empty($model->idpegawai_mengajukan)) {
  //            $peg = PegawaiM::model()->findByPk($model->idpegawai_mengajukan);
  //            if (!empty($peg)) {
  //                $pemesan = $peg->namaLengkap;
  //            }
  //        }
  //        if (!empty($model->idpegawai_mengetahui2)) {
  //            $peg = PegawaiM::model()->findByPk($model->idpegawai_mengetahui2);
  //            if (!empty($peg)) {
  //                $mengetahui = $peg->namaLengkap;
  //            }
  //        }
  //        if (!empty($model->idpegawai_mengetahui)) {
  //            $peg = PegawaiM::model()->findByPk($model->idpegawai_mengetahui);
  //            if (!empty($peg)) {
  //                $mengetahui_umum = $peg->namaLengkap;
  //            }
  //        }
  //        if (!empty($model->idpegawai_menyetujui)) {
  //            $peg = PegawaiM::model()->findByPk($model->idpegawai_menyetujui);
  //            if (!empty($peg)) {
  //                $menyetujui = $peg->namaLengkap;
  //            }
  //        }
  //
  //
  //        $judul = "Approval Permintaan Pembelian Bahan Makanan - Manajer Keuangan";
  //        $isi = "Tgl. Approval : ". MyFormatter::formatDateTimeForUser($model->tgl_mengetahui2)."<br/>";
  //        $isi .= "No. Pembelian : ".$model->nopengajuan."<br/>";
  //        //$isi .= "Pemesan : ".$pemesan."<br/>";
  //        //$isi .= "Manajer Umum : ".$mengetahui_umum."<br/>";
  //        $isi .= "Manajer Keuangan : ".$mengetahui."<br/>";
  //        //$isi .= "Direktur : ".$menyetujui."<br/>";
  //
  //        $ruangan_gudang = RuanganM::model()->findByPk(Params::RUANGAN_ID_LOGISTIK);
  //        $ruangan_keuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
  //        $ruangan_purchasing = RuanganM::model()->findByPk(Params::RUANGAN_ID_GUDANG_UMUM);
  //        $ruangan_gizi = RuanganM::model()->findByPk(Params::RUANGAN_ID_GIZI);
  //
  //        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
  //            array('instalasi_id'=>$ruangan_gudang->instalasi_id, 'ruangan_id'=>$ruangan_gudang->ruangan_id, 'modul_id'=>$ruangan_gudang->modul_id),
  //            array('instalasi_id'=>$ruangan_keuangan->instalasi_id, 'ruangan_id'=>$ruangan_keuangan->ruangan_id, 'modul_id'=>$ruangan_keuangan->modul_id),
  //            array('instalasi_id'=>$ruangan_purchasing->instalasi_id, 'ruangan_id'=>$ruangan_purchasing->ruangan_id, 'modul_id'=>$ruangan_purchasing->modul_id),
  //            array('instalasi_id'=>$ruangan_gizi->instalasi_id, 'ruangan_id'=>$ruangan_gizi->ruangan_id, 'modul_id'=>$ruangan_gizi->modul_id),
  //        ));
  //    }
  //
  //    public function notifMenyetujuiPermintaanPembelian($id) {
  //
  //        $model = GZPengajuanbahanmkn::model()->findByPk($id);
  //
  //        $pemesan = "-";
  //        $mengetahui = "-";
  //        $mengetahui_umum = "-";
  //        $menyetujui = "-";
  //
  //        if (!empty($model->idpegawai_mengajukan)) {
  //            $peg = PegawaiM::model()->findByPk($model->idpegawai_mengajukan);
  //            if (!empty($peg)) {
  //                $pemesan = $peg->namaLengkap;
  //            }
  //        }
  //        if (!empty($model->idpegawai_mengetahui2)) {
  //            $peg = PegawaiM::model()->findByPk($model->idpegawai_mengetahui2);
  //            if (!empty($peg)) {
  //                $mengetahui = $peg->namaLengkap;
  //            }
  //        }
  //        if (!empty($model->idpegawai_mengetahui)) {
  //            $peg = PegawaiM::model()->findByPk($model->idpegawai_mengetahui);
  //            if (!empty($peg)) {
  //                $mengetahui_umum = $peg->namaLengkap;
  //            }
  //        }
  //        if (!empty($model->idpegawai_menyetujui)) {
  //            $peg = PegawaiM::model()->findByPk($model->idpegawai_menyetujui);
  //            if (!empty($peg)) {
  //                $menyetujui = $peg->namaLengkap;
  //            }
  //        }
  //
  //
  //        $judul = "Approval Permintaan Pembelian Bahan Makanan - Direktur";
  //        $isi = "Tgl. Approval : ". MyFormatter::formatDateTimeForUser($model->tgl_menyetujui)."<br/>";
  //        $isi .= "No. Pembelian : ".$model->nopengajuan."<br/>";
  //        //$isi .= "Pemesan : ".$pemesan."<br/>";
  //        //$isi .= "Manajer Umum : ".$mengetahui_umum."<br/>";
  //        //$isi .= "Manajer Keuangan : ".$mengetahui."<br/>";
  //        $isi .= "Direktur : ".$menyetujui."<br/>";
  //
  //        $ruangan_gudang = RuanganM::model()->findByPk(Params::RUANGAN_ID_LOGISTIK);
  //        $ruangan_keuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
  //        $ruangan_purchasing = RuanganM::model()->findByPk(Params::RUANGAN_ID_GUDANG_UMUM);
  //        $ruangan_gizi = RuanganM::model()->findByPk(Params::RUANGAN_ID_GIZI);
  //
  //        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
  //            array('instalasi_id'=>$ruangan_gudang->instalasi_id, 'ruangan_id'=>$ruangan_gudang->ruangan_id, 'modul_id'=>$ruangan_gudang->modul_id),
  //            array('instalasi_id'=>$ruangan_keuangan->instalasi_id, 'ruangan_id'=>$ruangan_keuangan->ruangan_id, 'modul_id'=>$ruangan_keuangan->modul_id),
  //            array('instalasi_id'=>$ruangan_purchasing->instalasi_id, 'ruangan_id'=>$ruangan_purchasing->ruangan_id, 'modul_id'=>$ruangan_purchasing->modul_id),
  //            array('instalasi_id'=>$ruangan_gizi->instalasi_id, 'ruangan_id'=>$ruangan_gizi->ruangan_id, 'modul_id'=>$ruangan_gizi->modul_id),
  //        ));
  //    }





  /**
   * untuk autocomplete menampilkan bahan makanan
   */
  public function actionAutocompleteBahanMakanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(namabahanmakanan)', strtolower($_GET['term']), true);
      $criteria->order = 'namabahanmakanan';
      $models = BahanmakananM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->jenisbahanmakanan . ' - ' . $model->namabahanmakanan . ' - ' . $model->jmlpersediaan;
        $returnVal[$i]['value'] = $model->bahanmakanan_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionGetBahanMakanan()
  {

    if (Yii::app()->request->isAjaxRequest) {

      $idBahan = $_POST['id'];
      $qty = $_POST['qty'];
      $ukuran = isset($_POST['ukuran']) ? $_POST['ukuran'] : null;
      $merk = isset($_POST['merk']) ? $_POST['merk'] : null;
      if (isset($_POST['satuanbahan'])) {
        $satuanbahan = $_POST['satuanbahan'];
      } else {
        $satuanbahan = null;
      }

      if (!is_numeric($qty)) {
        $qty = 0;
      }

      $model = BahanmakananM::model()->with('golbahanmakanan')->findByPk($idBahan);
      if ($satuanbahan != $model->satuanbahan) {
        $model->satuanbahan = $satuanbahan;
      }

      $modDetail = new PengajuanbahandetailT;
      $format = new MyFormatter();
      $subNetto = $format->formatNumberForPrint($qty * $model->harganettobahan);

      /*
			* Jika stok gizi di centang pada konfig sistem maka jumlah pada
			* data stok ditampilkan. Jika tidak maka hanya menampilkan data
			* jmlpersediaan pada master
			*/
      $stokgizi = Yii::app()->user->getState('krngistokgizi');

      if ($stokgizi) {
        $stok = StokbahanmakananT::model()->findAllByAttributes(array(
          'bahanmakanan_id' => $model->bahanmakanan_id,
        ));
        $tot = 0;
        foreach ($stok as $item) {
          $tot += $item->qty_current;
        }
        $model->jmlpersediaan = $tot;
      }

      $nourut = 1;
      //                  $tr ="<tr>
      //                          <td hidden>".CHtml::activeCheckBox($modDetail,'[i]checkList',array('class'=>'cekList','onclick'=>'hitungSemua();','checked'=>true)).
      //                                CHtml::activeHiddenField($modDetail,'[i]golbahanmakanan_id',array('value'=>$model->golbahanmakanan_id, 'class'=>'golbahanmakanan_id')).
      //                                CHtml::activeHiddenField($modDetail,'[i]bahanmakanan_id',array('value'=>$model->bahanmakanan_id, 'class'=>'bahanmakanan_id')).
      //                                CHtml::activeHiddenField($modDetail,'[i]jmlkemasan',array('value'=>$model->jmldlmkemasan, 'class'=>'jmldlmkemasan')).
      //                                //CHtml::activeHiddenField($modDetail,'[i]harganettobhn',array('value'=>$model->harganettobahan, 'class'=>'harganettobhn')).
      //                                CHtml::activeHiddenField($modDetail,'[i]ukuranbahan',array('value'=>$ukuran, 'class'=>'ukuranbahan')).
      //                                CHtml::activeHiddenField($modDetail,'[i]merkbahan',array('value'=>$merk, 'class'=>'merkbahan')).
      //                         "</td>
      //                          <td>".CHtml::TextField('noUrut','',array('class'=>'span1 noUrut','readonly'=>TRUE, 'style'=>'width:20px;'))."</td>
      //                          <td>".$model->golbahanmakanan->golbahanmakanan_nama."</td>
      //                          <td>".$model->jenisbahanmakanan."</td>
      //                          <td>".$model->kelbahanmakanan."</td>
      //                          <td>".$model->namabahanmakanan."</td>
      //                          <td style='text-align: right;'>".(empty($model->jmlpersediaan)?0:MyFormatter::formatNumberForPrint($model->jmlpersediaan))."</td>
      //                          <td>".CHtml::activeDropDownList($modDetail,'[i]satuanbahan', LookupM::getItems('satuanbahanmakanan'), array('class'=>'satuanbahan span1'))."</td>
      //
      //						  <td style='text-align: right;'>".CHtml::activeTextField($modDetail,'[i]harganettobhn',array('value'=>number_format($model->harganettobahan,0,"","."), 'class'=>'harganettobhn integer2', 'style'=>'width:100px', 'onblur'=>'hitungTotal();'))."</td>
      //                          <td style='text-align: right;'>".MyFormatter::formatNumberForPrint($model->hargajualbahan)."</td>
      //                          <td style='text-align: right;' hidden>".MyFormatter::formatNumberForPrint($model->discount)."</td>
      //                          <td>".MyFormatter::formatDateTimeForUser($model->tglkadaluarsabahan)."</td>
      //                          <td>".CHtml::activetextField($modDetail,'[i]qtypengajuan',array('value'=>number_format($qty,2,",","."),'class'=>'span1 float2 qty','onblur'=>'hitung(this);', 'style'=>'text-align: right;'))."</td>
      //                          <td>".CHtml::activetextField($modDetail,'[i]subNetto',array('value'=>$subNetto,'class'=>'span2 integer2 subNetto','readonly'=>true, 'style'=>'width:100px',))."</td>
      //                          <td>".CHtml::link("<span class='icon-remove'>&nbsp;</span>",'',array('href'=>'','onclick'=>'hapus(this);return false;','style'=>'text-decoration:none;', 'class'=>'cancel'))."</td>
      //                        </tr>";
      //                 $data['tr']=$tr;//<td style='text-align: right;'>".MyFormatter::formatNumberForPrint($model->harganettobahan)."</td>
      $data['tr'] = $this->renderPartial(
        $this->path_view . '_rowbahanmkn',
        array(
          'modDetail' => $modDetail,
          'model' => $model,
          'qty' => $qty,
          'subNetto' => $subNetto,
          'tambahDetail' => true,
        ),
        true
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }


  public function actionLoadRencanaKebutuhan()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $id = $_POST['id'];

    $pengajuan = RenkebbahanmakanandetT::model()->findAllByAttributes(array(
      'renkebbahanmakanan_id' => $id,
    ));

    $tr = "";
    foreach ($pengajuan as $item) {

      $idBahan = $item->bahanmakanan_id;
      $qty = $item->jmlpermintaandet;
      $ukuran = null;
      $merk = null;


      $model = BahanmakananM::model()->with('golbahanmakanan')->findByPk($idBahan);
      $model->harganettobahan = $item->harga_barangdet;

      //if ($satuanbahan != $item->satuanbahan){
      $model->satuanbahan = $item->satuanbahan;
      //}

      $modDetail = new PengajuanbahandetailT;
      $format = new MyFormatter();
      $subNetto = $format->formatNumberForPrint($qty * $model->harganettobahan);
      $modDetail->satuanbahan = $item->satuanbahan;
      $modDetail->persenppn = $item->persen_ppn;

      /*
                 *
                * Jika stok gizi di centang pada konfig sistem maka jumlah pada
                * data stok ditampilkan. Jika tidak maka hanya menampilkan data
                * jmlpersediaan pada master
                */
      $stokgizi = Yii::app()->user->getState('krngistokgizi');

      if ($stokgizi) {
        $stok = StokbahanmakananT::model()->findAllByAttributes(array(
          'bahanmakanan_id' => $model->bahanmakanan_id,
        ));
        $tot = 0;
        foreach ($stok as $item) {
          $tot += $item->qty_current;
        }
        $model->jmlpersediaan = $tot;
      }

      $nourut = 1;
      $tr .= $this->renderPartial(
        $this->path_view . '_rowbahanmkn',
        array(
          'modDetail' => $modDetail,
          'model' => $model,
          'qty' => $qty,
          'subNetto' => $subNetto,
          'tambahDetail' => true,
        ),
        true
      );
      //                $tr .="<tr>
      //                    <td hidden>".CHtml::activeCheckBox($modDetail,'[i]checkList',array('class'=>'cekList','onclick'=>'hitungSemua();','checked'=>true)).
      //                          CHtml::activeHiddenField($modDetail,'[i]golbahanmakanan_id',array('value'=>$model->golbahanmakanan_id, 'class'=>'golbahanmakanan_id')).
      //                          CHtml::activeHiddenField($modDetail,'[i]bahanmakanan_id',array('value'=>$model->bahanmakanan_id, 'class'=>'bahanmakanan_id')).
      //                          CHtml::activeHiddenField($modDetail,'[i]jmlkemasan',array('value'=>$model->jmldlmkemasan, 'class'=>'jmldlmkemasan')).
      //                          //CHtml::activeHiddenField($modDetail,'[i]harganettobhn',array('value'=>$model->harganettobahan, 'class'=>'harganettobhn')).
      //                          CHtml::activeHiddenField($modDetail,'[i]ukuranbahan',array('value'=>$ukuran, 'class'=>'ukuranbahan')).
      //                          CHtml::activeHiddenField($modDetail,'[i]merkbahan',array('value'=>$merk, 'class'=>'merkbahan')).
      //                   "</td>
      //                    <td>".CHtml::TextField('noUrut','',array('class'=>'span1 noUrut','readonly'=>TRUE, 'style'=>'width:20px;'))."</td>
      //                    <td>".$model->golbahanmakanan->golbahanmakanan_nama."</td>
      //                    <td>".$model->jenisbahanmakanan."</td>
      //                    <td>".$model->kelbahanmakanan."</td>
      //                    <td>".$model->namabahanmakanan."</td>
      //                    <td style='text-align: right;'>".(empty($model->jmlpersediaan)?0:MyFormatter::formatNumberForPrint($model->jmlpersediaan))."</td>
      //                    <td>".CHtml::activeDropDownList($modDetail,'[i]satuanbahan', LookupM::getItems('satuanbahanmakanan'), array('class'=>'satuanbahan span1'))."</td>
      //
      //                    <td style='text-align: right;'>".CHtml::activeTextField($modDetail,'[i]harganettobhn',array('value'=>number_format($model->harganettobahan,0,"","."), 'class'=>'harganettobhn integer2', 'style'=>'width:100px', 'onblur'=>'hitungTotal();'))."</td>
      //                    <td style='text-align: right;'>".MyFormatter::formatNumberForPrint($model->hargajualbahan)."</td>
      //                    <td style='text-align: right;' hidden>".MyFormatter::formatNumberForPrint($model->discount)."</td>
      //                    <td>".MyFormatter::formatDateTimeForUser($model->tglkadaluarsabahan)."</td>
      //                    <td>".CHtml::activetextField($modDetail,'[i]qtypengajuan',array('value'=>number_format($qty,2,",","."),'class'=>'span1 float2 qty','onblur'=>'hitung(this);', 'style'=>'text-align: right;'))."</td>
      //                    <td>".CHtml::activetextField($modDetail,'[i]subNetto',array('value'=>$subNetto,'class'=>'span2 integer2 subNetto','readonly'=>true, 'style'=>'width:100px',))."</td>
      //                    <td>".CHtml::link("<span class='icon-remove'>&nbsp;</span>",'',array('href'=>'','onclick'=>'hapus(this);return false;','style'=>'text-decoration:none;', 'class'=>'cancel'))."</td>
      //                </tr>";
    }
    $data['html'] = $tr;
    //            $data['html']=$tr;//<td style='text-align: right;'>".MyFormatter::formatNumberForPrint($model->harganettobahan)."</td>
    echo json_encode($data);
  }

  protected function validasiTabular($model, $data)
  {
    foreach ($data as $i => $row) {
      $modDetails[$i] = new PengajuanbahandetailT();
      $modDetails[$i]->attributes = $row;
      $modDetails[$i]->pengajuanbahanmkn_id = $model->pengajuanbahanmkn_id;
      $modDetails[$i]->golbahanmakanan_id = $row['golbahanmakanan_id'];
      $modDetails[$i]->bahanmakanan_id = $row['bahanmakanan_id'];
      $modDetails[$i]->nourutbahan = 1;
      $modDetails[$i]->ukuranbahan = $row['ukuranbahan'];
      $modDetails[$i]->merkbahan = $row['merkbahan'];
      $modDetails[$i]->jmlkemasan = $row['jmlkemasan'];
      if (!is_numeric($modDetails[$i]->jmlkemasan)) {
        $modDetails[$i]->jmlkemasan = 0;
      }
      if (!is_numeric($modDetails[$i]->qty_pengajuan)) {
        $modDetails[$i]->qty_pengajuan = 0;
      }
      $modDetails[$i]->qty_pengajuan = $row['qtypengajuan'];
      $modDetails[$i]->satuanbahan = $row['satuanbahan'];
      $modDetails[$i]->harganettobhn = $row['harganettobhn'];
      $modDetails[$i]->validate();
    }

    return $modDetails;
  }
  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['GZPengajuanbahanmkn'])) {
      $model->attributes = $_POST['GZPengajuanbahanmkn'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->pengajuanbahanmkn_id));
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Lists all models.
   */
  //	public function actionIndex()
  //	{
  //		$dataProvider=new CActiveDataProvider('GZPengajuanbahanmkn');
  //		$this->render('index',array(
  //			'dataProvider'=>$dataProvider,
  //		));
  //	}

  /**
   * Manages all models.
   */
  public function actionInformasi()
  {
    $this->pageTitle = Yii::app()->name . " - Permintaan Pembelian Bahan Makanan";
    //
    $model = new GZPengajuanbahanmkn('search');
    //		$model->unsetAttributes();  // clear any default values
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    // $model->tglmintadikirim = date('d M Y');
    if (isset($_GET['GZPengajuanbahanmkn'])) {
      $model->attributes = $_GET['GZPengajuanbahanmkn'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
      $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
      $model->tglmintadikirim = $format->formatDateTimeForDb($model->tglmintadikirim);
      $model->statuspermintaanuangmuka = (!empty($_GET['GZPengajuanbahanmkn']['statuspermintaanuangmuka'])?$_GET['GZPengajuanbahanmkn']['statuspermintaanuangmuka']:null);
    }

    $this->render($this->path_view . 'informasi', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = GZPengajuanbahanmkn::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'gzpengajuanbahanmkn-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id
   */
  public function actionRemoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
    //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint($pengajuanbahanmkn_id)
  {
    $modPengajuan = PengajuanbahanmknT::model()->findByPk($pengajuanbahanmkn_id);
    $modDetailPengajuan = PengajuanbahandetailT::model()->with('bahanmakanan', 'golbahanmakanan')->findAllByAttributes(array('pengajuanbahanmkn_id' => $modPengajuan->pengajuanbahanmkn_id), array('order' => 'nourutbahan'));
    $judulLaporan = 'PERMINTAAN PEMBELIAN BAHAN MAKANAN';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'print', array('modPengajuan' => $modPengajuan, 'modDetailPengajuan' => $modDetailPengajuan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    }
  }

  public function actionDetailPengajuan($id)
  {
    $this->layout = '//layouts/iframe';
    $judulLaporan = 'PERMINTAAN PEMBELIAN BAHAN MAKANAN';
    $modPengajuan = PengajuanbahanmknT::model()->findByPk($id);
    $modDetailPengajuan = PengajuanbahandetailT::model()->with('bahanmakanan', 'golbahanmakanan')->findAllByAttributes(array('pengajuanbahanmkn_id' => $modPengajuan->pengajuanbahanmkn_id), array('order' => 'nourutbahan'));
    $this->render($this->path_view . 'detailInformasi', array(
      'modPengajuan' => $modPengajuan,
      'modDetailPengajuan' => $modDetailPengajuan,
      'judulLaporan' => $judulLaporan,
    ));
  }

  public function actionDetailPrintPengajuan($id)
  {
    $judulLaporan = 'PERMINTAAN PEMBELIAN BAHAN MAKANAN';
    //$this->layout = '//layouts/iframe';
    $modPengajuan = PengajuanbahanmknT::model()->findByPk($id);
    $modDetailPengajuan = PengajuanbahandetailT::model()->with('bahanmakanan', 'golbahanmakanan')->findAllByAttributes(array('pengajuanbahanmkn_id' => $modPengajuan->pengajuanbahanmkn_id), array('order' => 'nourutbahan'));

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      //   var_dump($id);die;
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printDetailInformasi', array('modPengajuan' => $modPengajuan, 'modDetailPengajuan' => $modDetailPengajuan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    }
    else if($caraPrint=='EXCEL') {
        $this->layout='//layouts/printExcel';
        $this->render($this->path_view.'printDetailInformasi',array('modPengajuan'=>$modPengajuan,'modDetailPengajuan'=>$modDetailPengajuan,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
    }
    else if($_REQUEST['caraPrint']=='PDF') {
        $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
        $posisi = 'L';                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
        $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css'); 
        $mpdf->WriteHTML($formatkonten, 1);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->WriteHTML($this->renderPartial($this->path_view.'printDetailInformasi',array('modPengajuan'=>$modPengajuan,'modDetailPengajuan'=>$modDetailPengajuan,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
        $mpdf->Output($judulLaporan.'-'.date('Y/m/d').'.pdf','I');
    }  
  }

  public function actionPersetujuan()
  {
    $id = $_POST['id'];
    $no = $_POST['no'];
    $cek = $_POST['cek'];

    if ($cek == 'cek') {
      if (isset($_POST['id'])) {
        $update = PengajuanbahanmknT::model()->updateByPk($id, array('status_persetujuan' => true, 'idpegawai_menyetujui' => Yii::app()->user->getState('pegawai_id')));

        if ($update) {
          if (Yii::app()->request->isAjaxRequest) {
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'nopengajuan' => $no,
            ));
            exit;
          }
        }
      } else {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
          ));
          exit;
        }
      }
    } else {
      $cek = PengajuanbahanmknT::model()->findByPk($id);

      if ($cek->status_persetujuan == TRUE) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'sukses',
            'url' => $this->createAbsoluteUrl('Terimabahanmakan/index', array("idPengajuan" => $id))
          ));
          exit;
        }
      } else {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'cek_form',
            'no' => $no
          ));
          exit;
        }
      }
    }
  }

  public function actionApproveMengetahui($pengajuanbahanmkn_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPengajuan = PengajuanbahanmknT::model()->findByPk($pengajuanbahanmkn_id);
    $modDetailPengajuan = PengajuanbahandetailT::model()->with('bahanmakanan', 'golbahanmakanan')->findAllByAttributes(array('pengajuanbahanmkn_id' => $modPengajuan->pengajuanbahanmkn_id), array('order' => 'nourutbahan'));

    //                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    //                $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    if ($approve) {
      $update = PengajuanbahanmknT::model()->updateByPk($pengajuanbahanmkn_id, array('tgl_mengetahui' => date("Y-m-d H:i:s")));

      $this->notifMengetahuiUmumPermintaanPembelian($pengajuanbahanmkn_id);

      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('ApproveMengetahui', 'pengajuanbahanmkn_id' => $pengajuanbahanmkn_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    
    $judulLaporan = 'PERMINTAAN PEMBELIAN BAHAN MAKANAN';
    //		$deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId($model->tglpembelian);
    $this->render($this->path_view . '_mengetahui', array(
      'format' => $format,
      'modPengajuan' => $modPengajuan,
      'modDetailPengajuan' => $modDetailPengajuan,
      'judulLaporan' => $judulLaporan,
      //				'deskripsi'=>$deskripsi,
      //				'modDetailBeli'=>$modDetailBeli
    ));
  }

  public function actionPrintApproveMengetahui($pengajuanbahanmkn_id)
  {
    $format = new MyFormatter();
    $modPengajuan = PengajuanbahanmknT::model()->findByPk($pengajuanbahanmkn_id);
    $modDetailPengajuan = PengajuanbahandetailT::model()->with('bahanmakanan', 'golbahanmakanan')->findAllByAttributes(array('pengajuanbahanmkn_id' => $modPengajuan->pengajuanbahanmkn_id), array('order' => 'nourutbahan'));
    //                $model = ADPembelianbarangT::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));
    //                $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));

    $judulLaporan = 'PERMINTAAN PEMBELIAN BAHAN MAKANAN';
    //		$deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId($model->tglpembelian);
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMengetahui', array('format' => $format, 'modPengajuan' => $modPengajuan, 'modDetailPengajuan' => $modDetailPengajuan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMengetahui', array('format' => $format, 'modPengajuan' => $modPengajuan, 'modDetailPengajuan' => $modDetailPengajuan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMengetahui', array('format' => $format, 'modPengajuan' => $modPengajuan, 'modDetailPengajuan' => $modDetailPengajuan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }


  public function actionApproveMenyetujui($pengajuanbahanmkn_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPengajuan = PengajuanbahanmknT::model()->findByPk($pengajuanbahanmkn_id);
    $modDetailPengajuan = PengajuanbahandetailT::model()->with('bahanmakanan', 'golbahanmakanan')->findAllByAttributes(array('pengajuanbahanmkn_id' => $modPengajuan->pengajuanbahanmkn_id), array('order' => 'nourutbahan'));
    if ($approve) {
      $update = PengajuanbahanmknT::model()->updateByPk($pengajuanbahanmkn_id, array('status_persetujuan' => true, 'tgl_menyetujui' => date("Y-m-d H:i:s")));

      $this->notifMenyetujuiPermintaanPembelian($pengajuanbahanmkn_id);

      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('ApproveMenyetujui', 'pengajuanbahanmkn_id' => $pengajuanbahanmkn_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'PERMINTAAN PEMBELIAN BAHAN MAKANAN';
    $this->render($this->path_view . '_menyetujui', array(
      'format' => $format,
      'modPengajuan' => $modPengajuan,
      'modDetailPengajuan' => $modDetailPengajuan,
      'judulLaporan' => $judulLaporan,
    ));
  }

  public function actionPrintApproveMenyetujui($pengajuanbahanmkn_id)
  {
    $format = new MyFormatter();
    $modPengajuan = PengajuanbahanmknT::model()->findByPk($pengajuanbahanmkn_id);
    $modDetailPengajuan = PengajuanbahandetailT::model()->with('bahanmakanan', 'golbahanmakanan')->findAllByAttributes(array('pengajuanbahanmkn_id' => $modPengajuan->pengajuanbahanmkn_id), array('order' => 'nourutbahan'));
    $judulLaporan = 'PERMINTAAN PEMBELIAN BAHAN MAKANAN';
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMenyetujui', array('format' => $format, 'modPengajuan' => $modPengajuan, 'modDetailPengajuan' => $modDetailPengajuan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMenyetujui', array('format' => $format, 'modPengajuan' => $modPengajuan, 'modDetailPengajuan' => $modDetailPengajuan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMenyetujui', array('format' => $format, 'modPengajuan' => $modPengajuan, 'modDetailPengajuan' => $modDetailPengajuan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionApproveMengetahui2($pengajuanbahanmkn_id, $approve = false)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPengajuan = PengajuanbahanmknT::model()->findByPk($pengajuanbahanmkn_id);
    $modDetailPengajuan = PengajuanbahandetailT::model()->with('bahanmakanan', 'golbahanmakanan')->findAllByAttributes(array('pengajuanbahanmkn_id' => $modPengajuan->pengajuanbahanmkn_id), array('order' => 'nourutbahan'));
    if ($approve) {
      $update = PengajuanbahanmknT::model()->updateByPk($pengajuanbahanmkn_id, array('tgl_mengetahui2' => date("Y-m-d H:i:s")));

      $this->notifMengetahuiPermintaanPembelian($pengajuanbahanmkn_id);

      if ($update) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('ApproveMengetahui2', 'pengajuanbahanmkn_id' => $pengajuanbahanmkn_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan");
      }
    }
    $judulLaporan = 'PERMINTAAN PEMBELIAN BAHAN MAKANAN';
    $this->render($this->path_view . '_mengetahui2', array(
      'format' => $format,
      'modPengajuan' => $modPengajuan,
      'modDetailPengajuan' => $modDetailPengajuan,
      'judulLaporan' => $judulLaporan,
    ));
  }

  public function actionPrintApproveMengetahui2($pengajuanbahanmkn_id)
  {
    $format = new MyFormatter();
    $modPengajuan = PengajuanbahanmknT::model()->findByPk($pengajuanbahanmkn_id);
    $modDetailPengajuan = PengajuanbahandetailT::model()->with('bahanmakanan', 'golbahanmakanan')->findAllByAttributes(array('pengajuanbahanmkn_id' => $modPengajuan->pengajuanbahanmkn_id), array('order' => 'nourutbahan'));
    $judulLaporan = 'PERMINTAAN PEMBELIAN BAHAN MAKANAN';
    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printMengetahui2', array('format' => $format, 'modPengajuan' => $modPengajuan, 'modDetailPengajuan' => $modDetailPengajuan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printMengetahui2', array('format' => $format, 'modPengajuan' => $modPengajuan, 'modDetailPengajuan' => $modDetailPengajuan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printMengetahui2', array('format' => $format, 'modPengajuan' => $modPengajuan, 'modDetailPengajuan' => $modDetailPengajuan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionGetHariPengiriman()
  {


    if (Yii::app()->request->isAjaxRequest) {
      $tgl_kirim = MyFormatter::formatDateTimeForDb($_POST['tgl_kirim']);

      $hariPengiriman = MyFormatter::getDayName($tgl_kirim);
      echo CJSON::encode(array(
        'hariPengiriman' => $hariPengiriman,
      ));
      exit;
    }
  }

  public function actionBatalPermintaanPembelian()
  {
    $keterangan = "";

    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      $pesan = 'success';
      $status = 'ok';
      $ok = true;
      try {
        $pengajuanbahanmkn_id = $_POST['pengajuanbahanmkn_id'];
        $tglbatal = $_POST['tglbatal'];
        $keterangan_batal = $_POST['keterangan_batal'];
        //                            $pegawaipembatalan = $_POST['pegawaipembatalan'];

        $pengajuanbahanmkn = PengajuanbahanmknT::model()->findByPk($pengajuanbahanmkn_id);

        // simpan batal periksa penunjang
        $model = new BatalpermintaanpembelianT;
        //                            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->ruangan_id = $pengajuanbahanmkn->ruangan_id;
        $model->permintaanpembelian_id = $pengajuanbahanmkn->pengajuanbahanmkn_id;
        $model->tglbatalpermintaan = MyFormatter::formatDateTimeForDb($tglbatal);
        $model->alasanbatalpermintaan = $keterangan_batal;
        $modOtoritasi = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $model->user_name_otoritasi = $modOtoritasi->nama_pegawai;
        $model->user_id_otorisasi = $modOtoritasi->pegawai_id;
        $model->tglpermintaanpembelian = MyFormatter::formatDateTimeForDb($pengajuanbahanmkn->tglpengajuanbahan);
        $model->nopermintaan = $pengajuanbahanmkn->nopengajuan;
        $model->supplier_nama = (!empty($pengajuanbahanmkn->supplier_id) ? $pengajuanbahanmkn->supplier->supplier_nama : null);
        $model->pegawaipemesan = $pengajuanbahanmkn->mengajukan->namaLengkap;
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

        $deleteSukses = false;
        if ($model->validate()) {
          if ($model->save()) {
            $ok = true;
            $deleteSukses = PengajuanbahanmknT::model()->updateByPk($pengajuanbahanmkn->pengajuanbahanmkn_id, array('batalpermintaanpembelian_id' => $model->batalpermintaanpembelian_id));
          }
        } else $ok = false;

        if ($ok && $deleteSukses) {
          $transaction->commit();
          $this->notifPembatalanPermintaanpembelian($model->batalpermintaanpembelian_id);
          $pesan = 'success';
        } else {
          $transaction->rollback();
          $keterangan = "Permintaan Tidak Bisa dibatalkan";
          $pesan = 'exist';
        }
      } catch (Exception $ex) {
        print_r($ex);
        $status = 'not';
        $pesan = 'exist';
        $transaction->rollback();
      }

      $data['pesan'] = $pesan;
      $data['status'] = $status;
      $data['keterangan'] = $keterangan;

      echo json_encode($data);

      Yii::app()->end();
    }
  }

  public function cekPegawaiJabatan()
  {
    $approval = ApprovalotorisasiM::model()->find();
    if (empty($approval)) {
      return false;
    }

    $pegawai_id = Yii::app()->user->getState('pegawai_id');

    return in_array($pegawai_id, array(
      $approval->managerumum_id,
      $approval->managerkeuangan_id,
      $approval->direkturrs_id,
    ));


    //return in_array($peg->jabatan_id, );
  }

  public function notifPembatalanPermintaanpembelian($batalpermintaanpembelian_id)
  {

    $model = BatalpermintaanpembelianT::model()->findByPk($batalpermintaanpembelian_id);

    $pegawaiBatal = "-";

    if (!empty($model->user_id_otorisasi)) {
      $peg = PegawaiM::model()->findByPk($model->user_id_otorisasi);
      if (!empty($peg)) {
        $pegawaiBatal = $peg->namaLengkap;
      }
    }

    $judul = "Pembatalan Permintaan Pembelian Bahan Makanan";
    $isi = "Tgl. Pembatalan Permintaan Bahan Makanan : " . MyFormatter::formatDateTimeForUser($model->tglbatalpermintaan) . "<br/>";
    $isi .= "No. Permintaan Bahan Makanan : " . $model->nopermintaan . "<br/>";
    $isi .= "Pegawai Pembatalan Permintaan Bahan Makanan : " . $pegawaiBatal . "<br/>";

    $ruangan_gudang = RuanganM::model()->findByPk(Params::RUANGAN_ID_GIZI);
    $ruangan_keuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
    $ruangan_purchasing = RuanganM::model()->findByPk(Params::RUANGAN_ID_GUDANG_UMUM);

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruangan_gudang->instalasi_id, 'ruangan_id' => $ruangan_gudang->ruangan_id, 'modul_id' => $ruangan_gudang->modul_id),
      array('instalasi_id' => $ruangan_keuangan->instalasi_id, 'ruangan_id' => $ruangan_keuangan->ruangan_id, 'modul_id' => $ruangan_keuangan->modul_id),
      array('instalasi_id' => $ruangan_purchasing->instalasi_id, 'ruangan_id' => $ruangan_purchasing->ruangan_id, 'modul_id' => $ruangan_purchasing->modul_id),
    ));
  }


  public function notifMengetahuiUmumPermintaanPembelian($pembelianbarang_id)
  {

    $model = PengajuanbahanmknT::model()->findByPk($pembelianbarang_id);

    $mengetahui = "-";

    if (!empty($model->idpegawai_mengetahui)) {
      $peg = PegawaiM::model()->findByPk($model->idpegawai_mengetahui);
      if (!empty($peg)) {
        $mengetahui = $peg->namaLengkap;
      }
    }

    $judul = "Approval Permintaan Pembelian Bahan Makanan";
    $isi = "Tgl. Approval : " . MyFormatter::formatDateTimeForUser($model->tgl_mengetahui) . "<br/>";
    $isi .= "No. Permintaan : " . $model->nopengajuan . "<br/>";
    $isi .= "Manajer Umum : " . $mengetahui . "<br/>";

    $ruangan_gudang = RuanganM::model()->findByPk(Params::RUANGAN_ID_GIZI);
    $ruangan_keuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
    $ruangan_purchasing = RuanganM::model()->findByPk(Params::RUANGAN_ID_GUDANG_UMUM);

    $urlFull = "";
    $modul = null;

    if (!empty($ruangan_gudang->modul_id)) {
      $urlFull = "gizi/Pengajuanbahanmkn/Informasi";
    }

    if (!empty($ruangan_keuangan->modul_id)) {
      $modul = ModulK::model()->findByPk($ruangan_keuangan->modul_id);
      $urlFull = $modul->url_modul . "/Pengajuanbahanmkn" . $modul->modul_key . '/Informasi';
    }

    if (!empty($ruangan_purchasing->modul_id)) {
      $urlFull = "gizi/Pengajuanbahanmkn/Informasi";
    }

    if (isset($modul)) {
      $link = Yii::app()->createUrl($urlFull, array(
        'GZPengajuanbahanmkn[tgl_awal]' => MyFormatter::formatDateTimeForUser($model->tglpengajuanbahan),
        'GZPengajuanbahanmkn[tgl_akhir]' => MyFormatter::formatDateTimeForUser($model->tglpengajuanbahan),
        'GZPengajuanbahanmkn[nopengajuan]' => $model->nopengajuan,
      ));
    }

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruangan_gudang->instalasi_id, 'ruangan_id' => $ruangan_gudang->ruangan_id, 'modul_id' => $ruangan_gudang->modul_id, 'link_proses' => $link),
      array('instalasi_id' => $ruangan_keuangan->instalasi_id, 'ruangan_id' => $ruangan_keuangan->ruangan_id, 'modul_id' => $ruangan_keuangan->modul_id, 'link_proses' => $link),
      array('instalasi_id' => $ruangan_purchasing->instalasi_id, 'ruangan_id' => $ruangan_purchasing->ruangan_id, 'modul_id' => $ruangan_purchasing->modul_id, 'link_proses' => $link),
    ));
  }

  public function notifMengetahuiPermintaanPembelian($pembelianbarang_id)
  {

    $model = PengajuanbahanmknT::model()->findByPk($pembelianbarang_id);

    $mengetahui = "-";

    if (!empty($model->idpegawai_mengetahui2)) {
      $peg = PegawaiM::model()->findByPk($model->idpegawai_mengetahui2);
      if (!empty($peg)) {
        $mengetahui = $peg->namaLengkap;
      }
    }

    $judul = "Approval Permintaan Pembelian Bahan Makanan";
    $isi = "Tgl. Approval : " . MyFormatter::formatDateTimeForUser($model->tgl_mengetahui2) . "<br/>";
    $isi .= "No. Permintaan : " . $model->nopengajuan . "<br/>";
    $isi .= "Manajer Keuangan : " . $mengetahui . "<br/>";

    $ruangan_gudang = RuanganM::model()->findByPk(Params::RUANGAN_ID_GIZI);
    $ruangan_keuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
    $ruangan_purchasing = RuanganM::model()->findByPk(Params::RUANGAN_ID_GUDANG_UMUM);

    $urlFull = "";
    $modul = null;

    if (!empty($ruangan_gudang->modul_id)) {
      $urlFull = "gizi/Pengajuanbahanmkn/Informasi";
    }

    if (!empty($ruangan_keuangan->modul_id)) {
      $modul = ModulK::model()->findByPk($ruangan_keuangan->modul_id);
      $urlFull = $modul->url_modul . "/Pengajuanbahanmkn" . $modul->modul_key . '/Informasi';
    }

    if (!empty($ruangan_purchasing->modul_id)) {
      $urlFull = "gizi/Pengajuanbahanmkn/Informasi";
    }

    if (isset($modul)) {
      $link = Yii::app()->createUrl($urlFull, array(
        'GZPengajuanbahanmkn[tgl_awal]' => MyFormatter::formatDateTimeForUser($model->tglpengajuanbahan),
        'GZPengajuanbahanmkn[tgl_akhir]' => MyFormatter::formatDateTimeForUser($model->tglpengajuanbahan),
        'GZPengajuanbahanmkn[nopengajuan]' => $model->nopengajuan,
      ));
    }

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruangan_gudang->instalasi_id, 'ruangan_id' => $ruangan_gudang->ruangan_id, 'modul_id' => $ruangan_gudang->modul_id, 'link_proses' => $link),
      array('instalasi_id' => $ruangan_keuangan->instalasi_id, 'ruangan_id' => $ruangan_keuangan->ruangan_id, 'modul_id' => $ruangan_keuangan->modul_id, 'link_proses' => $link),
      array('instalasi_id' => $ruangan_purchasing->instalasi_id, 'ruangan_id' => $ruangan_purchasing->ruangan_id, 'modul_id' => $ruangan_purchasing->modul_id, 'link_proses' => $link),
    ));
  }

  public function notifMenyetujuiPermintaanPembelian($pembelianbarang_id)
  {

    $model = PengajuanbahanmknT::model()->findByPk($pembelianbarang_id);

    $mengetahui = "-";

    if (!empty($model->idpegawai_menyetujui)) {
      $peg = PegawaiM::model()->findByPk($model->idpegawai_menyetujui);
      if (!empty($peg)) {
        $mengetahui = $peg->namaLengkap;
      }
    }

    $judul = "Approval Permintaan Pembelian Bahan Makanan";
    $isi = "Tgl. Approval : " . MyFormatter::formatDateTimeForUser($model->tgl_menyetujui) . "<br/>";
    $isi .= "No. Permintaan : " . $model->nopengajuan . "<br/>";
    $isi .= "Direktur : " . $mengetahui . "<br/>";

    $ruangan_gudang = RuanganM::model()->findByPk(Params::RUANGAN_ID_GIZI);
    $ruangan_keuangan = RuanganM::model()->findByPk(Params::RUANGAN_ID_FINANCE);
    $ruangan_purchasing = RuanganM::model()->findByPk(Params::RUANGAN_ID_GUDANG_UMUM);

    $urlFull = "";
    $modul = null;

    if (!empty($ruangan_gudang->modul_id)) {
      $urlFull = "gizi/Pengajuanbahanmkn/Informasi";
    }

    if (!empty($ruangan_keuangan->modul_id)) {
      $modul = ModulK::model()->findByPk($ruangan_keuangan->modul_id);
      $urlFull = $modul->url_modul . "/Pengajuanbahanmkn" . $modul->modul_key . '/Informasi';
    }

    if (!empty($ruangan_purchasing->modul_id)) {
      $urlFull = "gizi/Pengajuanbahanmkn/Informasi";
    }

    if (isset($modul)) {
      $link = Yii::app()->createUrl($urlFull, array(
        'GZPengajuanbahanmkn[tgl_awal]' => MyFormatter::formatDateTimeForUser($model->tglpengajuanbahan),
        'GZPengajuanbahanmkn[tgl_akhir]' => MyFormatter::formatDateTimeForUser($model->tglpengajuanbahan),
        'GZPengajuanbahanmkn[nopengajuan]' => $model->nopengajuan,
      ));
    }

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $ruangan_gudang->instalasi_id, 'ruangan_id' => $ruangan_gudang->ruangan_id, 'modul_id' => $ruangan_gudang->modul_id, 'link_proses' => $link),
      array('instalasi_id' => $ruangan_keuangan->instalasi_id, 'ruangan_id' => $ruangan_keuangan->ruangan_id, 'modul_id' => $ruangan_keuangan->modul_id, 'link_proses' => $link),
      array('instalasi_id' => $ruangan_purchasing->instalasi_id, 'ruangan_id' => $ruangan_purchasing->ruangan_id, 'modul_id' => $ruangan_purchasing->modul_id, 'link_proses' => $link),
    ));

    if (!empty($model->tglpermintaanuangmuka)) {
      $judulUangMuka = "Permintaan Uang Muka Pembelian Bahan Makanan";
      $isiUangMuka = "Telah dilakukan approval untuk permintaan uang muka pembelian dengan rincian sebagai berikut: <br/><br/>";
      $isiUangMuka .= "Tgl. Permintaan Uang Muka Pembelian : " . MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($model->tglpermintaanuangmuka))) . "<br/>";
      $isiUangMuka .= "No. Permintaan Pembelian : " . $model->nopengajuan . "<br/>";
      $ok = CustomFunction::broadcastNotif($judulUangMuka, $isiUangMuka, array(
        array('instalasi_id' => $ruangan_keuangan->instalasi_id, 'ruangan_id' => $ruangan_keuangan->ruangan_id, 'modul_id' => $ruangan_keuangan->modul_id),
      ));
    }
  }
}
