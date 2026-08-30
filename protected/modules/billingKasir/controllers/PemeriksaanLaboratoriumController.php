<?php
class PemeriksaanLaboratoriumController extends MyAuthController
{
  public $layout = "//layouts/iframe";
  public $path_view = "billingKasir.views.pemeriksaanLaboratorium.";

  public $tindakanpelayanantersimpan = true; //dilooping / boleh tanpa ini
  public $komponentindakantersimpan = true; //di looping
  public $pasienpenunjangtersimpan = true; //dilooping
  public $hasilpemeriksaantersimpan = true; //dilooping

  /**
   * di copy dari laboratorium/PendaftaranLaboratoriumRujukanRS.
   */
  public function actionIndex($pendaftaran_id)
  {
    $format = new MyFormatter();
    $modPasienAdmisi = new BKPasienadmisiT;
    $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
    if (!empty($modPendaftaran->pasienadmisi_id)) {
      $modPasienAdmisi = BKPasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    }

    $modKunjungan = new BKPasienkirimkeunitlainV;
    $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modPemeriksaanLab = new BKTarifpemeriksaanlabruanganV;
    $modPasienMasukPenunjang = new BKPasienmasukpenunjangT;
    $modPasienMasukPenunjang->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modPasienMasukPenunjang->tglmasukpenunjang = date('Y-m-d H:i:s');
    $modTindakan = new BKTindakanPelayananT;
    $dataTindakans = array();
    $modRiwayatTindakans = new BKTindakanPelayananT;

    if (!empty($modPasienMasukPenunjang->pasienmasukpenunjang_id)) {
      $modPasienMasukPenunjang = BKPasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
      $loadModKunjungan = BKPasienmasukpenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
      if (isset($loadModKunjungan)) {
        $modKunjungan = $loadModKunjungan;
      }
    }

    if (isset($_POST['BKPasienmasukpenunjangT'])) {
      $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPasienMasukPenunjang = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $_POST['BKPasienmasukpenunjangT']);
        if ($_POST['BKPasienmasukpenunjangT']['ruangan_id'] == Params::RUANGAN_ID_LAB_KLINIK) {
          $modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($modPendaftaran->pasien, $modPasienMasukPenunjang);
        }
        if (isset($_POST['BKTindakanPelayananT'][0])) {
          if (count((array)$_POST['BKTindakanPelayananT'][0]) > 0) {
            foreach ($_POST['BKTindakanPelayananT'][0] as $ii => $tindakan) {
              if (!empty($tindakan['tindakanpelayanan_id'])) {
                $dataTindakans[$ii] = BKTindakanPelayananT::model()->findByPk($tindakan['tindakanpelayanan_id']);
              } else {
                $dataTindakans[$ii] = $this->simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $tindakan);
                if ($_POST['BKPasienmasukpenunjangT']['ruangan_id'] == Params::RUANGAN_ID_LAB_KLINIK) {
                  if (!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)) {
                    if (empty($tindakan['tindakanpelayanan_id'])) { //jika tindakan baru
                      $this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$ii], $tindakan);
                    }
                  }
                } else if ($_POST['BKPasienmasukpenunjangT']['ruangan_id'] == Params::RUANGAN_ID_LAB_ANATOMI) {
                  $modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
                }
              }
              $dataTindakans[$ii]->pemeriksaanlab_id = $tindakan['pemeriksaanlab_id'];
              $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
              $dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);
            }
          }
        }

        if (!empty($modHasilPemeriksaan)) {
          $sysmex = new Sysmex;
          $sysmex->kirim_tambah($modHasilPemeriksaan->hasilpemeriksaanlab_id, null, $_POST['BKPasienmasukpenunjangT']['dokterperujuk']);
        }

        if ($this->pasienpenunjangtersimpan && $this->tindakanpelayanantersimpan && $this->komponentindakantersimpan && $this->hasilpemeriksaantersimpan) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data pemeriksaan laboratorium Pasien " . $modPendaftaran->pasien->nama_pasien . " berhasil disimpan !");
          $this->redirect($this->createUrl('index', array('pendaftaran_id' => $pendaftaran_id, 'sukses' => 1)));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pemeriksaan laboratorium gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback(); var_dump($exc->getMessage()); die;
        Yii::app()->user->setFlash('error', "Data pemeriksaan laboratorium gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
    $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

    $this->render('index', array(
      'format' => $format,
      'modKunjungan' => $modKunjungan,
      'modPemeriksaanLab' => $modPemeriksaanLab,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modTindakan' => $modTindakan,
      'dataTindakans' => $dataTindakans,
      'modPendaftaran' => $modPendaftaran,
      'modPasienAdmisi' => $modPasienAdmisi,
      'modRiwayatTindakans' => $modRiwayatTindakans
    ));
  }

  /**
   * Fungsi untuk menyimpan data ke model BKPasienmasukpenunjangT
   * @param type $modPendaftaran
   * @param type $modPasien
   * @return BKPasienmasukpenunjangT 
   * di copy dari laboratorium/PendaftaranLaboratorium.
   */
  public function simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $post)
  {
    $modPasienMasukPenunjang = new $modPasienMasukPenunjang;
    $modPasienMasukPenunjang->attributes = $modPendaftaran->attributes;
    $modPasienMasukPenunjang->attributes = $post;
    $modPasienMasukPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $instalasi_id = $modPasienMasukPenunjang->ruangan->instalasi_id;
    $kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
    $modPasienMasukPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($kode_instalasi);
    $modPasienMasukPenunjang->tglmasukpenunjang = date("Y-m-d H:i:s");
    $modPasienMasukPenunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($modPasienMasukPenunjang->ruangan_id);
    $modPasienMasukPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;
    $modPasienMasukPenunjang->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modPasienMasukPenunjang->create_loginpemakai_id = Yii::app()->user->id;
    $modPasienMasukPenunjang->create_time = date('Y-m-d H:i:s');
    $modPasienMasukPenunjang->dokter_perujuk = $post['dokter_perujuk'];

    if ($modPasienMasukPenunjang->validate()) {
      $modPasienMasukPenunjang->save();
      $this->pasienpenunjangtersimpan &= true;
    } else {
      $this->pasienpenunjangtersimpan &= false;
    }

    return $modPasienMasukPenunjang;
  }

  /**
   * simpan BKHasilPemeriksaanLabT
   * di copy dari laboratorium/PendaftaranLaboratorium.
   */
  public function simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjang)
  {
    $modHasilPemeriksaan = new BKHasilPemeriksaanLabT;
    $modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
    $modHasilPemeriksaan->nohasilperiksalab = MyGenerator::noHasilPemeriksaanLK();
    $modHasilPemeriksaan->tglhasilpemeriksaanlab = $modPasienMasukPenunjang->tglmasukpenunjang;
    $modHasilPemeriksaan->hasil_kelompokumur = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    $modHasilPemeriksaan->hasil_jeniskelamin = $modPasien->jeniskelamin;
    $modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_BELUM;
    $modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;
    if ($modHasilPemeriksaan->validate()) {
      $modHasilPemeriksaan->save();
    } else {
      $this->hasilpemeriksaantersimpan &= false;
    }
    return $modHasilPemeriksaan;
  }

  /**
   * proses simpan BKTindakanPelayananT dan BKTindakanKomponenT
   * di copy dari laboratorium/PendaftaranLaboratorium.
   */
  public function simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $post)
  {
    $modTindakan = new BKTindakanPelayananT;

    $modTindakan->attributes = $modPendaftaran->attributes;
    $modTindakan->attributes = $modPasienMasukPenunjang->attributes;
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTindakan->attributes = $post;
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
    $modTindakan->karcis_id = (isset($post['karcis_id']) ? $post['karcis_id'] : null);
    if (!empty($modTindakan->karcis_id)) {
      $this->karcistersimpan = true;
      if (isset($post['harga_tariftindakan'])) { //jika dari form karcis
        if (!empty($post['harga_tariftindakan'])) {
          $modTindakan->tarif_satuan = $post['harga_tariftindakan'];
        }
      }
      $modTindakan->tipepaket_id = $this->tipePaketKarcis($modPendaftaran, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
    }
    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->dokterpemeriksa1_id = $modPasienMasukPenunjang->pegawai_id;
    $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
    $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
    $modTindakan->cyto_tindakan = 0;
    $modTindakan->tarifcyto_tindakan = 0;
    $modTindakan->discount_tindakan = 0;
    $modTindakan->subsidiasuransi_tindakan = 0;
    $modTindakan->subsidipemerintah_tindakan = 0;
    $modTindakan->subsisidirumahsakit_tindakan = 0;
    $modTindakan->iurbiaya_tindakan = 0;
    $modTindakan->tarif_rsakomodasi = 0;
    $modTindakan->tarif_medis = 0;
    $modTindakan->tarif_paramedis = 0;
    $modTindakan->tarif_bhp = 0;

    if ($modTindakan->validate()) {
      if ($modTindakan->save()) {
        $this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
      }
    } else {
      $this->tindakanpelayanantersimpan &= false;
    }

    return $modTindakan;
  }

  /**
   * simpan BKDetailHasilPemeriksaanLabT
   */
  public function simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $modTindakan, $post)
  {
    $modDetailHasilPemeriksaans = array();
    $criteria = new CDbCriteria();
    $date1 = new DateTime($modTindakan->pendaftaran->tgl_pendaftaran);
    $date2 = new DateTime($modTindakan->pasien->tanggal_lahir);
    $umurhari = $date2->diff($date1)->format("%a");
    $criteria = new CDbCriteria();
    $criteria->addCondition('pemeriksaanlab_id = ' . $post['pemeriksaanlab_id']);
    $criteria->addCondition("'" . $umurhari . "' BETWEEN hariminlab AND harimakslab");
    $criteria->compare('LOWER(nilairujukan_jeniskelamin)', strtolower($modHasilPemeriksaan->pasien->jeniskelamin), true);
    $criteria->order = 'pemeriksaanlabdet_nourut ASC';
    $modPemeriksaanLadDet = PemeriksaanlabdetV::model()->findAll($criteria);

    if (count((array)$modPemeriksaanLadDet) > 0) {
      foreach ($modPemeriksaanLadDet as $i => $pemeriksaanDet) {
        $modDetailHasilPemeriksaans[$i] = new BKDetailHasilPemeriksaanLabT;
        $modDetailHasilPemeriksaans[$i]->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
        $modDetailHasilPemeriksaans[$i]->pemeriksaanlabdet_id = $pemeriksaanDet->pemeriksaanlabdet_id;
        $modDetailHasilPemeriksaans[$i]->pemeriksaanlab_id = $pemeriksaanDet->pemeriksaanlab_id;
        $modDetailHasilPemeriksaans[$i]->hasilpemeriksaanlab_id = $modHasilPemeriksaan->hasilpemeriksaanlab_id;
        $modDetailHasilPemeriksaans[$i]->nilairujukan = $pemeriksaanDet->nilairujukan_nama;
        $modDetailHasilPemeriksaans[$i]->hasilpemeriksaan_satuan = $pemeriksaanDet->nilairujukan_satuan;
        $modDetailHasilPemeriksaans[$i]->hasilpemeriksaan_metode = $pemeriksaanDet->nilairujukan_metode;
        $modDetailHasilPemeriksaans[$i]->create_time = date("Y-m-d H:i:s");
        $modDetailHasilPemeriksaans[$i]->create_loginpemakai_id = Yii::app()->user->id;
        $modDetailHasilPemeriksaans[$i]->create_ruangan = $modHasilPemeriksaan->create_ruangan;
        if ($modDetailHasilPemeriksaans[$i]->validate()) {
          $modDetailHasilPemeriksaans[$i]->save();
        } else {
          $this->hasilpemeriksaantersimpan &= false;
        }
      }
    }
    return $modDetailHasilPemeriksaans;
  }

  /**
   * simpan BKHasilPemeriksaanPAT
   */
  public function simpanHasilPemeriksaanPA($modPasienMasukPenunjang, $modTindakan, $post)
  {
    $modHasilPemeriksaanPA = new BKHasilPemeriksaanPAT;
    $modHasilPemeriksaanPA->attributes = $modPasienMasukPenunjang->attributes;
    $modHasilPemeriksaanPA->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
    $modHasilPemeriksaanPA->pemeriksaanlab_id = $post['pemeriksaanlab_id'];
    $modHasilPemeriksaanPA->nosediaanpa = MyGenerator::noSediaanPA();
    $modHasilPemeriksaanPA->tglperiksapa = $modPasienMasukPenunjang->tglmasukpenunjang;
    $modHasilPemeriksaanPA->create_time = date("Y-m-d H:i:s");
    $modHasilPemeriksaanPA->create_loginpemakai_id = Yii::app()->user->id;
    $modHasilPemeriksaanPA->create_ruangan = $modPasienMasukPenunjang->ruangan_id;

    if ($modHasilPemeriksaanPA->validate()) {
      $modHasilPemeriksaanPA->save();
      $modTindakan->hasilpemeriksaanpa_id = $modHasilPemeriksaanPA->hasilpemeriksaanpa_id;
      $modTindakan->update();
    } else {
      $this->hasilpemeriksaantersimpan = false;
    }
  }

  /**
   * set checklist pemeriksaan lab
   */
  public function actionSetChecklistPemeriksaanLab()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $content = "";
      parse_str($_POST['data'], $post);
      $postPemeriksaan = $post['BKTarifpemeriksaanlabruanganV'];
      if (!empty($postPemeriksaan['ruangan_id']) && !empty($postPemeriksaan['kelaspelayanan_id']) && !empty($postPemeriksaan['penjamin_id'])) {
        $criteria = new CdbCriteria();
        $criteria->addCondition('ruangan_id = ' . $postPemeriksaan['ruangan_id']);
        $criteria->addCondition('kelaspelayanan_id = ' . $postPemeriksaan['kelaspelayanan_id']);
        $criteria->addCondition('penjamin_id = ' . $postPemeriksaan['penjamin_id']);
        $criteria->compare('LOWER(jenispemeriksaanlab_nama)', strtolower($postPemeriksaan['jenispemeriksaanlab_nama']), true);
        $criteria->compare('LOWER(pemeriksaanlab_nama)', strtolower($postPemeriksaan['pemeriksaanlab_nama']), true);
        $criteria->order = "jenispemeriksaanlab_urutan, pemeriksaanlab_urutan";
        $modPemeriksaanlabs = BKTarifpemeriksaanlabruanganV::model()->findAll($criteria);
        $content = $this->renderPartial('billingKasir.views.pemeriksaanLaboratorium._checklistPemeriksaanLab', array('modPemeriksaanlabs' => $modPemeriksaanlabs), true);
      }
      echo CJSON::encode(array(
        'content' => $content
      ));
      Yii::app()->end();
    }
  }

  /**
   * set dropdown dokter
   * di copy dari radiologi/pendaftaranRadiologiRujukanRS
   */
  public function actionSetDropdownDokter()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new BKPendaftaranT;
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($_POST['ruangan_id'])) {
        $data = $model->getDokterItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['listDokter'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * set dropdown jenis kasus penyakit
   * di copy dari radiologi/pendaftaranRadiologiRujukanRS
   */
  public function actionSetDropdownJeniskasuspenyakit()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new BKPendaftaranT;
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($_POST['ruangan_id'])) {
        $data = $model->getJenisKasusPenyakitItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['listKasuspenyakit'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * menghapus tindakanpelayanan (ajax)
   */
  public function actionHapusTindakanPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['pesan'] = "";
      $data['sukses'] = 0;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $loadTindakanPelayanan = TindakanpelayananT::model()->findByPk($_POST['tindakanpelayanan_id']);
        $hasil = HasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$loadTindakanPelayanan->pasienmasukpenunjang_id));
        $deleteTindakanKomponen = TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $_POST['tindakanpelayanan_id']));
        $deleteHasilPemeriksaan = DetailhasilpemeriksaanlabT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $_POST['tindakanpelayanan_id']));
        $deleteObatAlkes = ObatalkespasienT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $_POST['tindakanpelayanan_id']));
        if ($loadTindakanPelayanan->delete()) {

          
          if (!empty($hasil)) {
            $sysmex = new Sysmex;
            $total = TindakanpelayananT::model()->countByAttributes(array(
              'pasienmasukpenunjang_id'=>$hasil->pasienmasukpenunjang_id,
            ));

            if ($total == 0) {
              $sysmex->kirim_tambah($hasil->hasilpemeriksaanlab_id, Sysmex::ORDER_CONTROL_BATAL);
            } else {
              $sysmex->kirim_tambah($hasil->hasilpemeriksaanlab_id, Sysmex::ORDER_CONTROL_UPDATE_TRANSAKTI);
            }

          }

          $transaction->commit();
          $data['pesan'] = "Tindakan dan pemakaian bahan & alat medis berhasil dihapus!";
          $data['sukses'] = 1;
        } else {
          $transaction->rollback();
          $data['pesan'] = "Tindakan dan pemakaian bahan & alat medis gagal dihapus!";
          $data['sukses'] = 0;
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['pesan'] = "Tindakan dan pemakaian bahan & alat medis gagal dihapus! :" . $exc->getMessage();
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  public function actionAutocompleteDokter($term = null) {

    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $cr = new CDbCriteria;
    $cr->compare('lower(nama_pegawai)', strtolower($term), true);
    $cr->order = "nama_pegawai asc";
    $cr->group = $cr->select = "pegawai_id, nama_pegawai, gelardepan, gelarbelakang_nama";

    $model = DokterV::model()->findAll($cr);

    $res = array();

    foreach ($model as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->namaLengkap;
      $sub['value'] = $item->pegawai_id;
      
      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }
}
