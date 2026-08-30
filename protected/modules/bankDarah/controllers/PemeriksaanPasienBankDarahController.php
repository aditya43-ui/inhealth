<?php
Yii::import('bankDarah.controllers.PendaftaranBankDarahController');
class PemeriksaanPasienBankDarahController extends PendaftaranBankDarahController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "bankDarah.views.pemeriksaanPasienBankDarah.";
  public $path_view_pendaftaran = "bankDarah.views.pendaftaranBankDarah.";

  /**
   * Tambah / Ubah Pemeriksaan Laboratorium.
   */
  public function actionIndex($pasienmasukpenunjang_id = null)
  {
    $format = new MyFormatter();
    $modKunjungan = new BDPasienMasukPenunjangV;
    $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modPasienMasukPenunjang = new BDPasienmasukpenunjangT;
    $modPemeriksaanLab = new BDTarifpemeriksaanlabruanganV;
    $modHasilPemeriksaan = new BDHasilPemeriksaanLabT;
    $modHasilPemeriksaanPA = new BDHasilPemeriksaanPAT;
    $modTindakan = new BDTindakanPelayananT;
    $dataTindakans = array();
    $pasienmasukpenunjang_id = (isset($_POST['pasienmasukpenunjang_id']) ? $_POST['pasienmasukpenunjang_id'] : $pasienmasukpenunjang_id);
    if (!empty($pasienmasukpenunjang_id)) {
      $loadModKunjungan = $this->loadModPasienMasukPenunjang($pasienmasukpenunjang_id);
      if (isset($loadModKunjungan)) {
        $modKunjungan = $loadModKunjungan;
        $modPasienMasukPenunjang->attributes = $loadModKunjungan->attributes;
        $modPasienMasukPenunjang->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
        $modPasienMasukPenunjang->perawat_id = $modPasienMasukPenunjang->getPerawatId();

        if ($loadModKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK) {
          $loadHasilPemeriksaan = BDHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $loadModKunjungan->pasienmasukpenunjang_id));
          if (strtolower(trim($loadHasilPemeriksaan->statusperiksahasil)) == strtolower(Params::STATUSPERIKSAHASIL_SUDAH)) {
            Yii::app()->user->setFlash('warning', "Pasien dengan status sudah diperiksa tidak bisa merubah tindakan pemeriksaan !");
          } else {
            $modHasilPemeriksaan = $loadHasilPemeriksaan;
          }
        } else if ($loadModKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI) {
          //TIDAK ADA UPDATE BDHasilPemeriksaanPAT
        }
      }
    }

    if (isset($_POST['pasienmasukpenunjang_id'])) {
      $modPasienMasukPenunjang = BDPasienmasukpenunjangT::model()->findByPk($_POST['pasienmasukpenunjang_id']);
      $modPendaftaran = $modPasienMasukPenunjang->pendaftaran;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (isset($_POST['BDPasienmasukpenunjangT'])) {
          $modPasienMasukPenunjang->pegawai_id = $_POST['BDPasienmasukpenunjangT']['pegawai_id'];
          $modPasienMasukPenunjang->perawat_id = $_POST['BDPasienmasukpenunjangT']['perawat_id'];
          $modPasienMasukPenunjang->save();
        }

        if (isset($_POST['BDTindakanPelayananT'][0])) {
          if (count((array)$_POST['BDTindakanPelayananT'][0]) > 0) {
            foreach ($_POST['BDTindakanPelayananT'][0] as $ii => $tindakan) {
              if (!empty($tindakan['tindakanpelayanan_id'])) {
                $dataTindakans[$ii] = BDTindakanPelayananT::model()->findByPk($tindakan['tindakanpelayanan_id']);
                $dataTindakans[$ii]->jeniskasuspenyakit_id = $modPasienMasukPenunjang->jeniskasuspenyakit_id;
                $dataTindakans[$ii]->qty_tindakan = $tindakan['qty_tindakan'];
                $dataTindakans[$ii]->tarif_tindakan = ($tindakan['tarif_tindakan']);
                $dataTindakans[$ii]->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
                $dataTindakans[$ii]->cyto_tindakan = $tindakan['cyto_tindakan'];
                $dataTindakans[$ii]->tarifcyto_tindakan = $tindakan['tarif_cyto'];
                $dataTindakans[$ii]->update();
              } else {
                $dataTindakans[$ii] = $this->simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $tindakan);
                if ($_POST['ruangan_id'] == Params::RUANGAN_ID_LAB_KLINIK) {
                  if (isset($modHasilPemeriksaan->hasilpemeriksaanlab_id)) {
                    $this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$ii], $tindakan);
                  }
                } else if ($_POST['ruangan_id'] == Params::RUANGAN_ID_LAB_ANATOMI) {
                  $modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjang, $dataTindakans[$ii], $tindakan);
                }
              }
              $dataTindakans[$ii]->pemeriksaanlab_id = $tindakan['pemeriksaanlab_id'];
              $dataTindakans[$ii]->jenistarif_id = $tindakan['jenistarif_id'];
              $dataTindakans[$ii]->tarif_tindakan = $format->formatNumberForUser($tindakan['tarif_tindakan']);
            }
          }
        }

        if ($this->tindakanpelayanantersimpan && $this->komponentindakantersimpan && $this->hasilpemeriksaantersimpan) {
          $transaction->commit();
          $this->redirect(array('index', 'pasienmasukpenunjang_id' => $modKunjungan->pasienmasukpenunjang_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pemeriksaan bank darah gagal disimpan !");
          //                        echo "-".$this->tindakanpelayanantersimpan."<br>";
          //                        echo "-".$this->komponentindakantersimpan."<br>";
          //                        echo "-".$this->hasilpemeriksaantersimpan."<br>";
          //                        exit;
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pemeriksaan bank darah gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modKunjungan->tgl_pendaftaran = $format->formatDateTimeForUser($modKunjungan->tgl_pendaftaran);
    $modKunjungan->tanggal_lahir = $format->formatDateTimeForUser($modKunjungan->tanggal_lahir);

    $this->render('index', array(
      'modKunjungan' => $modKunjungan,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
      'modPemeriksaanLab' => $modPemeriksaanLab,
      'modTindakan' => $modTindakan,
      'dataTindakans' => $dataTindakans,
    ));
  }
  /**
   * @param type $pasienmasukpenunjang_id
   * @return BDPasienMasukPenunjangV
   */
  public function loadModPasienMasukPenunjang($pasienmasukpenunjang_id)
  {
    $criteria = new CDbCriteria;
    $criteria->addCondition("pasienmasukpenunjang_id = " . $pasienmasukpenunjang_id);
    $model = BDPasienMasukPenunjangV::model()->find($criteria);
    return $model;
  }

  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_masukpenunjang
   * - no_pendaftaran
   * - no_rekam_medik
   * - nama_pasien
   */
  public function actionAutocompleteKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : null;
      $no_masukpenunjang = isset($_GET['no_masukpenunjang']) ? $_GET['no_masukpenunjang'] : null;
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_masukpenunjang)', strtolower($no_masukpenunjang), true);
      $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->addCondition('ruangan_id = ' . $ruangan_id);
      $criteria->addCondition("DATE(tglmasukpenunjang) = '" . date("Y-m-d") . "'");
      $criteria->limit = 5;
      $models = BDPasienMasukPenunjangV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_pendaftaran . "-" . $model->no_masukpenunjang . '-' . $model->no_rekam_medik . '-' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Mengurai data kunjungan berdasarkan:
   * - pasienmasukpenunjang_id
   * @throws CHttpException
   */
  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $returnVal['pesan'] = "";
      $criteria = new CDbCriteria();
      $model = $this->loadModPasienMasukPenunjang($_POST['pasienmasukpenunjang_id']);
      if (isset($model)) {
        $loadHasilPemeriksaan = BDHasilPemeriksaanLabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id));
        if (isset($loadHasilPemeriksaan)) {
          if (strtolower(trim($loadHasilPemeriksaan->statusperiksahasil)) == strtolower(Params::STATUSPERIKSAHASIL_SUDAH)) {
            $returnVal['pesan'] = "Pasien dengan status sudah diperiksa tidak bisa merubah tindakan pemeriksaan !";
          }
        }
      }

      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      $returnVal["perawat_id"] = $model->getPerawatId();
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * set LKTindakanpelayananT yang sudah ada di database
   * @params pasienmasukpenunjang_id
   */
  public function actionSetTindakanPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $modTindakans = BDTindakanPelayananT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id']), 'karcis_id IS NULL');
      if (count((array)$modTindakans) > 0) {
        foreach ($modTindakans as $i => $modTindakan) {
          $modTindakan->pemeriksaanlab_id = isset(PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->pemeriksaanlab_id) ? PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->pemeriksaanlab_id : "";
          //                    $modTindakan->pemeriksaanlab_id = PemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id'=>$modTindakan->daftartindakan_id))->pemeriksaanlab_id;
          $modTindakan->jenistarif_id = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id' => $modTindakan->pendaftaran->penjamin_id))->jenistarif_id;
          $modTindakan->tarif_tindakan = $format->formatNumberForUser($modTindakan->tarif_tindakan);
          $modTindakan->tarif_satuan = $format->formatNumberForUser($modTindakan->tarif_satuan);
          $modTarifTindakan = BDTariftindakanM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id));
          $modTindakan->persencyto_tind = $modTarifTindakan->persencyto_tind;
          $rows .= $this->renderPartial($this->path_view_pendaftaran . "_rowTindakanPemeriksaan", array('i' => 0, 'modTindakan' => $modTindakan), true);
        }
      }

      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }
  /**
   * hapus LKTindakanpelayananT yang sudah ada di database
   * @params pasienmasukpenunjang_id
   * @params daftartindakan_id
   */
  public function actionHapusTindakanPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['pesan'] = "";
      $data['sukses'] = 0;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPasienMasukPenunjang = BDPasienmasukpenunjangT::model()->findByPk($_POST['pasienmasukpenunjang_id']);
        $modTindakan = BDTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id'], 'daftartindakan_id' => $_POST['daftartindakan_id']));
        $modTindakan->detailhasilpemeriksaanlab_id = null;
        $modTindakan->hasilpemeriksaanpa_id = null;
        $modTindakan->update();
        $hapusTindakanKomponen = TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $modTindakan->tindakanpelayanan_id));
        if ($modPasienMasukPenunjang->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK) {
          $hapusDetailHasilPemeriksaan = DetailhasilpemeriksaanlabT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $modTindakan->tindakanpelayanan_id));
        } else if ($modPasienMasukPenunjang->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI) {
          $hapusHasilPemeriksaanPA = HasilpemeriksaanpaT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $modTindakan->tindakanpelayanan_id));
        }
        $cekTindakan = TindakanpelayananT::model()->findByPk($modTindakan->tindakanpelayanan_id);
        if ($cekTindakan->tindakansudahbayar_id) {
          $hapusTindakan = false;
        } else {
          $hapusTindakan = TindakanpelayananT::model()->deleteByPk($modTindakan->tindakanpelayanan_id);
        }
        if ($hapusTindakanKomponen && $hapusTindakan) {
          $transaction->commit();
          $data['pesan'] = "Pemeriksaan berhasil dihapus!";
          $data['sukses'] = 1;
        } else {
          $transaction->rollback();
          if (!$hapusTindakanKomponen)
            $data['pesan'] = "Pemeriksaan komponen gagal dihapus!";
          if (!$hapusTindakan)
            $data['pesan'] = "Pemeriksaan gagal dihapus karena sudah dibayarkan!";
          $data['sukses'] = 0;
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['pesan'] = "Pemeriksaan gagal dihapus! :" . MyExceptionMessage::getMessage($exc, true);
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }
}
