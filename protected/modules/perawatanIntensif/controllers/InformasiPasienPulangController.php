<?php

class InformasiPasienPulangController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Pulang";
    $format = new MyFormatter();
    $modPasienYangPulang = new PIPasienygPulangriV;
    $modPasienYangPulang->tgl_awal = date('Y-m-d');
    $modPasienYangPulang->tgl_akhir = date('Y-m-d');
    $modPasienYangPulang->ceklis = TRUE;
    $modPasienYangPulang->is_nursestation = true;
    if (isset($_GET['PIPasienygPulangriV'])) {
      $modPasienYangPulang->attributes = $_GET['PIPasienygPulangriV'];
      $modPasienYangPulang->tgl_awal = $format->formatDateTimeForDb($_GET['PIPasienygPulangriV']['tgl_awal']);
      $modPasienYangPulang->tgl_akhir = $format->formatDateTimeForDb($_GET['PIPasienygPulangriV']['tgl_akhir']);
      $modPasienYangPulang->ceklis = $_GET['PIPasienygPulangriV']['ceklis'];
      $modPasienYangPulang->tgl_awal = $modPasienYangPulang->tgl_awal . " 00:00:00";
      $modPasienYangPulang->tgl_akhir = $modPasienYangPulang->tgl_akhir . " 23:59:59";
      $modPasienYangPulang->is_nursestation = $_REQUEST['PIPasienygPulangriV']['is_nursestation'];
    }
    $this->render('index', array('format' => $format, 'modPasienYangPulang' => $modPasienYangPulang));
  }

  public function actionBatalPulang($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';

    $modPendaftaran    = PIPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien         = PIPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $modPasienAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'tgladmisi DESC', 'limit' => 1));

    $modPasienPulang   = PasienpulangT::model()->findByAttributes(array('pasienadmisi_id' => $modPasienAdmisi->pasienadmisi_id));

    $modPasienBatalPulang  = new PasienbatalpulangT;
    $modPasienBatalPulang->create_time             = date('Y-m-d H:i:s');
    $modPasienBatalPulang->update_time             = date('Y-m-d H:i:s');
    $modPasienBatalPulang->namauser_otorisasi      = Yii::app()->user->name;;
    $modPasienBatalPulang->iduser_otorisasi        = Yii::app()->user->id;
    $modPasienBatalPulang->create_loginpemakai_id  = Yii::app()->user->id;
    $modPasienBatalPulang->update_loginpemakai_id  = Yii::app()->user->id;
    $modPasienBatalPulang->create_ruangan          = Yii::app()->user->getState('ruangan_id');
    $modPasienBatalPulang->pasienpulang_id         = $modPasienPulang->pasienpulang_id;

    $jenisPenyakit         = JeniskasuspenyakitM::model()->findByPk($modPendaftaran->jeniskasuspenyakit_id);
    $modPendaftaran->jeniskasuspenyakit_nama   = $jenisPenyakit->jeniskasuspenyakit_nama;
    //             digunakan untuk merefresh jika data berhasil di simpan
    $tersimpan = 'Tidak';

    if (!empty($_POST['PasienbatalpulangT'])) {
      $format = new MyFormatter();
      $modPasienBatalPulang->attributes = $_POST['PasienbatalpulangT'];
      $modPasienBatalPulang->tglpembatalan = $format->formatDateTimeForDb($modPasienBatalPulang->tglpembatalan);

      if ($modPasienBatalPulang->validate()) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
          if ($modPasienBatalPulang->save()) {
            $pasienpulang_id = $modPasienBatalPulang->pasienpulang_id;
            $pasienadmisi_id = $_POST['pasienadmisi_id'];
            $pasienPulang = PIPasienPulangT::model()->updateByPk($pasienpulang_id, array('pasienbatalpulang_id' => $modPasienBatalPulang->pasienbatalpulang_id));
            $pasienAdmisi = PIPasienAdmisiT::model()->updateByPk($pasienadmisi_id, array('pasienpulang_id' => null));
            if ($pasienAdmisi && $pasienPulang) {
              $transaction->commit();
              PIPendaftaranT::model()->updateByPk(
                $pendaftaran_id,
                array(
                  'statusperiksa' => Params::STATUSPERIKSA_SEDANG_DIRAWATINAP,
                  'pasienpulang_id' => null
                )
              );
              Yii::app()->user->setFlash('success', "Data berhasil disimpan");
              $tersimpan = 'Ya';
            } else {
              $transaction->rollback();
              Yii::app()->user->setFlash('error', "Data gagal disimpan");
            }
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan");
          }
        } catch (Exception $ex) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan", MyExceptionMessage::getMessage($exc, true));
        }
      }
    }

    $this->render('_formBatalPulang', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPasienBatalPulang' => $modPasienBatalPulang,
      'modPasienAdmisi' => $modPasienAdmisi,
      'tersimpan' => $tersimpan
    ));
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

  public function actionRincianTagihanPasienDetail($pendaftaran_id, $pasienadmisi_id = null)
  {
    $format = new MyFormatter();
    // $this->layout = '//layouts/printWindows';
    // if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    // }

    // untuk load data pasien
    $criteria = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
    }
    if (!empty($pasienadmisi_id)) {
      $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
    }
    $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI, Params::INSTALASI_ID_KECANTIKAN));
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
    /* RSSP-1085
            if(!empty($pasienadmisi_id)){
                    $criteriaTindakan->addCondition('pasienadmisi_id = '.$pasienadmisi_id);
            }*/
    $criteriaTindakan->order = 'instalasi_id, ruangan_id, tgl_tindakan';
    $modRincianTindakan = RinciantagihantindakanV::model()->findAll($criteriaTindakan);

    // untuk load data obat
    $criteriaObatAlkes = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteriaObatAlkes->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    }
    if (!empty($pasienadmisi_id)) {
      $criteriaObatAlkes->addCondition('pasienadmisi_id = ' . $pasienadmisi_id);
    }
    $criteriaObatAlkes->order = 'ruangan_id, penjualanresep_id, tglpelayanan';
    $modRincianObatAlkes = RinciantagihanobatalkesV::model()->findAll($criteriaObatAlkes);
    $criteria = new CDbCriteria();
        $criteria->addCondition('pendaftaran_id = '.$pendaftaran_id);
        $criteria->order = 'instalasi_id, ruangan_id, tgl_tindakan';

        $modRincians = RinciantagihanpasienV::model()->findAll($criteria);

    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

    $this->render('billingKasir.views.pembayaranTagihanPasien.printRincianBelumBayar', array(
      'format' => $format,
      'modInfo' => $modInfo,
      'modRincianTindakan' => $modRincianTindakan,
      'modRincianObatAlkes' => $modRincianObatAlkes,
      'modPendaftaran' => $modPendaftaran,
      'modRincians' => $modRincians,
      'is_total_instalasi' => TRUE,
    ));
  }

  public function actionRincianPembayaranPasienDetail($pendaftaran_id, $pembayaranpelayanan_id)
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
    $criteria->addInCondition('instalasi_id', array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI));
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
    $criteriaTindakan->order = 'instalasi_id, ruangan_id, tgl_tindakan';
    $modRincianTindakan = RincianbayartindakanV::model()->findAll($criteriaTindakan);

    // untuk load data obat
    $criteriaObatAlkes = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteriaObatAlkes->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    }
    if (!empty($pembayaranpelayanan_id)) {
      //                $criteriaObatAlkes->addCondition('pembayaranpelayanan_id = '.$pembayaranpelayanan_id);
    }
    $criteriaObatAlkes->addCondition('oasudahbayar_id is not null');
    $criteriaObatAlkes->order  = 'ruangan_id, penjualanresep_id, tglpelayanan';
    $modRincianObatAlkes = RincianbayarobatalkesV::model()->findAll($criteriaObatAlkes);


    // untuk load pembayaran pelayanan
    $modPembayaranPelayanan = PembayaranpelayananT::model()->findByPk($pembayaranpelayanan_id);
    // untuk load pemakaian uang muka
    $modPemakaianUangMuka = PemakaianuangmukaT::model()->findByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));
    // untuk load tanda bukti bayar
    $modTandaBuktiBayar = TandabuktibayarT::model()->findByAttributes(array('pembayaranpelayanan_id' => $pembayaranpelayanan_id));


    $this->render('billingKasir.views.pembayaranTagihanPasien.printRincianPembayaranPasienDetail', array(
      'format' => $format,
      'modInfo' => $modInfo,
      'modRincianTindakan' => $modRincianTindakan,
      'modRincianObatAlkes' => $modRincianObatAlkes,
      'modPembayaranPelayanan' => $modPembayaranPelayanan,
      'modPemakaianUangMuka' => $modPemakaianUangMuka,
      'modTandaBuktiBayar' => $modTandaBuktiBayar
    ));
  }
}
