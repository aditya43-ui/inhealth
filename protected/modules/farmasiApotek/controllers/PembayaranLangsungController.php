<?php

class PembayaranLangsungController extends MyAuthController
{
  public $successSaveTandabukti = true;
  public $successSaveBayarOA = true;

  public function actionIndex($idPenjualanResep = null)
  {
    $successSave = false;
    $tandaBukti = new TandabuktibayarT;
    $sudahBayar = false;

    if (isset($_POST['TandabuktibayarT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $tandaBukti = $this->saveTandabuktiBayar($_POST['TandabuktibayarT']);
        $this->savePembayaranPelayanan($tandaBukti, $_POST['pembayaranAlkes']);

        if ($this->successSaveTandabukti && $this->successSaveBayarOA) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $successSave = true;
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
          $successSave = false;
        }
        //echo "<pre>".print_r($_POST,1)."</pre>";exit;
      } catch (Exception $exc) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        //                    echo $exc->getTraceAsString();
        $transaction->rollback();
      }
    }

    if (isset($_GET['frame']) && !empty($_GET['idPenjualanResep'])) {
      $this->layout = 'iframe';
      $idPenjualanResep = $_GET['idPenjualanResep'];
      $modPenjualan = PenjualanresepT::model()->findByPk($idPenjualanResep);
      $modPegawai = PegawaikaryawanV::model()->findByAttributes(array('pegawai_id' => $modPenjualan->pasienpegawai_id));
      $modInstalasi = InstalasiM::model()->findByAttributes(array('instalasi_id' => $modPenjualan->pasieninstalasiunit_id));
      $criteriaoa = new CDbCriteria;
      if (!empty($idPenjualanResep)) {
        $criteria->addCondition("penjualanresep_id = " . $idPenjualanResep);
      }
      $criteriaoa->addCondition('oasudahbayar_id IS NULL');
      $modObatalkes = FAObatalkesPasienT::model()->with('daftartindakan')->findAll($criteriaoa);

      //$modPasien = (!empty($modObatalkes)) ? FAPasienM::model()->findByPk($modObatalkes[0]->pasien_id) : new FAPasienM;

      if (!empty($modObatalkes) && !$successSave) {
        $modPasien = FAPasienM::model()->findByPk($modObatalkes[0]->pasien_id);
      } else {
        $modPasien = new FAPasienM;
        if (!$successSave) {
          $sudahBayar = true;
          Yii::app()->user->setFlash('info', "Sudah dilakukan pembayaran");
        }
      }

      if ($tandaBukti->tandabuktibayar_id != null) {
        $modTandaBukti = $tandaBukti;
      } else if ($sudahBayar) {
        $idPenjualanResep = $_GET['idPenjualanResep'];
        $penjualanResep = PenjualanresepT::model()->findByPk($idPenjualanResep);
        $pembayaran = PembayaranpelayananT::model()->findByAttributes(array('pasien_id' => $penjualanResep->pasien_id));
        $modTandaBukti = TandabuktibayarT::model()->findByPk($pembayaran->tandabuktibayar_id);
        $criteriaoa = new CDbCriteria;
        if (!empty($idPenjualanResep)) {
          $criteria->addCondition("penjualanresep_id = " . $idPenjualanResep);
        }
        $criteriaoa->addCondition('oasudahbayar_id IS NOT NULL');
        $modObatalkes = FAObatalkesPasienT::model()->with('daftartindakan')->findAll($criteriaoa);
      } else {
        $modTandaBukti = new TandabuktibayarT;
        if (!empty($modPenjualan->pasienpegawai_id))
          $modTandaBukti->darinama_bkm = $modPegawai->nomorindukpegawai . ' - ' . $modPegawai->gelardepan . ' ' . $modPegawai->nama_pegawai . ', ' . $modPegawai->gelarbelakang_nama;
        else if (!empty($modPenjualan->pasieninstalasiunit_id))
          $modTandaBukti->darinama_bkm = $modInstalasi->instalasi_nama . ' - ' . $modInstalasi->instalasi_lokasi;
        else
          $modTandaBukti->darinama_bkm = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;
        $modTandaBukti->alamat_bkm = $modPasien->alamat_pasien;
      }
    } else {
      $modPasien = new FAPasienM;
      $modObatalkes[0] = new FAObatalkesPasienT;
      $modTandaBukti = new TandabuktibayarT;
    }

    $this->render('index', array(
      'modPasien' => $modPasien,
      'modPenjualan' => $modPenjualan,
      'modObatalkes' => $modObatalkes,
      'modTandaBukti' => $modTandaBukti,
      'tandaBukti' => $tandaBukti,
      'successSave' => $successSave,
      'sudahBayar' => $sudahBayar
    ));
  }

  protected function savePembayaranPelayanan($tandaBukti, $postPembayaranOa)
  {
    //$pendaftaran_id = $_POST['FAPendaftaranT']['pendaftaran_id'];
    $pasien_id = $_POST['FAPasienM']['pasien_id'];
    $pembayaran = new PembayaranpelayananT;
    $pembayaran->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
    $pembayaran->penjamin_id = Params::PENJAMIN_ID_UMUM;
    $pembayaran->pasien_id = $pasien_id;
    //$pembayaran->pendaftaran_id = $pendaftaran_id;
    $pembayaran->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $pembayaran->tglpembayaran = $_POST['TandabuktibayarT']['tglbuktibayar'];
    $pembayaran->ruanganpelakhir_id = Yii::app()->user->getState('ruangan_id');
    $pembayaran->totalbiayaoa = $_POST['totalbayar_oa'];
    $pembayaran->totalbiayatindakan = 0;

    $totalsubsidiasuransi = (isset($_POST['totalsubsidiasuransi']) ? $_POST['totalsubsidiasuransi'] : 0);
    $totalsubsidiasuransi_oa = (isset($_POST['totalsubsidiasuransi_oa']) ? $_POST['totalsubsidiasuransi_oa'] : 0);
    $totalsubsidipemerintah = (isset($_POST['totalsubsidipemerintah']) ? $_POST['totalsubsidipemerintah'] : 0);
    $totalsubsidipemerintah_oa = (isset($_POST['totalsubsidipemerintah_oa']) ? $_POST['totalsubsidipemerintah_oa'] : 0);
    $totalsubsidirs = (isset($_POST['totalsubsidirs']) ? $_POST['totalsubsidirs'] : 0);
    $totalsubsidirs_oa = (isset($_POST['totalsubsidirs_oa']) ? $_POST['totalsubsidirs_oa'] : 0);

    $pembayaran->totalbiayapelayanan = $_POST['totalbayar_oa'];
    $pembayaran->totalsubsidiasuransi =  $totalsubsidiasuransi + $totalsubsidiasuransi_oa;
    $pembayaran->totalsubsidipemerintah = $totalsubsidipemerintah + $totalsubsidipemerintah_oa;
    $pembayaran->totalsubsidirs = $totalsubsidirs + $totalsubsidirs_oa;
    $pembayaran->totaliurbiaya = $_POST['totaliurbiaya_oa'];

    $pembayaran->totalbayartindakan = $tandaBukti->jmlpembayaran;
    $pembayaran->totaldiscount = 0;
    $pembayaran->totalpembebasan = 0;
    $pembayaran->totalsisatagihan = 0;
    $pembayaran->statusbayar = $this->cekStatusBayar($pembayaran->totalsisatagihan);
    $pembayaran->nopembayaran = MyGenerator::noPembayaran();
    $pembayaran->tandabuktibayar_id = $tandaBukti->tandabuktibayar_id;

    //$pembayaran->pembayaranpelayanan_id = $pembayaran->getOldPrimaryKey() + 1;
    if ($pembayaran->validate()) {
      //echo "savePembayaranPelayanan valid <br/>";
      //echo "<pre>".print_r($pembayaran->attributes,1)."</pre>";
      $pembayaran->save();
      TandabuktibayarT::model()->updateByPk($tandaBukti->tandabuktibayar_id, array('pembayaranpelayanan_id' => $pembayaran->pembayaranpelayanan_id));
      //$this->saveTindakanSudahBayar($pembayaran, $postPembayaran,$tandaBukti);
      if (!empty($postPembayaranOa))
        $this->saveOaSudahBayar($pembayaran, $postPembayaranOa, $tandaBukti);
      $this->successSaveTandabukti = true;
    } else {
      echo "savePembayaranPelayanan tidak valid";
      echo "<pre>" . print_r($pembayaran->errors, 1) . "</pre>";
      echo "<pre>" . print_r($pembayaran->attributes, 1) . "</pre>";
      $this->successSaveTandabukti = false;
    }
  }

  protected function saveTandabuktiBayar($postTandaBuktiBayar)
  {
    $modTandaBukti = new TandabuktibayarT;
    $modTandaBukti->attributes = $postTandaBuktiBayar;
    if ($modTandaBukti->carapembayaran == 'HUTANG') {
      $modTandaBukti->uangditerima = 0;
    }
    $modTandaBukti->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modTandaBukti->nourutkasir = MyGenerator::noUrutKasir($modTandaBukti->ruangan_id);
    $modTandaBukti->nobuktibayar = MyGenerator::noBuktiBayar();

    //$modTandaBukti->tandabuktibayar_id = $modTandaBukti->getOldPrimaryKey() + 1;
    if ($modTandaBukti->validate()) {
      //echo "saveTandabuktiBayar valid <br/>";
      //echo "<pre>".print_r($modTandaBukti->attributes,1)."</pre>";
      $modTandaBukti->save();
      $this->successSaveTandabukti = true;
    } else {
      echo "saveTandabuktiBayar tidak valid";
      echo "<pre>" . print_r($modTandaBukti->errors, 1) . "</pre>";
      echo "<pre>" . print_r($modTandaBukti->attributes, 1) . "</pre>";
      $this->successSaveTandabukti = false;
    }

    return $modTandaBukti;
  }

  protected function saveOaSudahBayar($modPembayaranPelayanan, $postPembayaranOa, $modTandaBukti)
  {
    foreach ($postPembayaranOa as $i => $item) {
      $subsidiasuransi = (isset($item['subsidiasuransi']) ? $item['subsidiasuransi'] : 0);
      $subsidipemerintah = (isset($item['subsidipemerintah']) ? $item['subsidipemerintah'] : 0);
      $subsidirs = (isset($item['subsidirs']) ? $item['subsidirs'] : 0);

      $model[$i] = new OasudahbayarT;
      $model[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model[$i]->obatalkespasien_id = $item['obatalkespasien_id'];
      $model[$i]->pembayaranpelayanan_id = $modPembayaranPelayanan->pembayaranpelayanan_id;
      $model[$i]->obatalkes_id = $item['obatalkes_id'];
      $model[$i]->qty_oa = $item['qty_oa'];
      $model[$i]->jmlsubsidi_asuransi = $subsidiasuransi;
      $model[$i]->jmlsubsidi_pemerintah = $subsidipemerintah;
      $model[$i]->jmlsubsidi_rs = $subsidirs;
      $model[$i]->jmliurbiaya = $item['iurbiaya'];
      $model[$i]->jmlbayar_oa = $item['sub_total'] / $_POST['totalbayar_oa'] * $modTandaBukti->jmlpembayaran;
      $model[$i]->jmlsisabayar_oa = $item['sub_total'] - $model[$i]->jmlbayar_oa;
      $model[$i]->hargasatuan = $item['hargasatuan'];

      //$model[$i]->oasudahbayar_id = $model[$i]->getOldPrimaryKey() + 1;
      if ($model[$i]->validate()) {
        //echo "saveOaSudahBayar valid <br/>";
        //echo "<pre>".print_r($model[$i]->attributes,1)."</pre>";
        $model[$i]->save();
        $this->updateObatAlkesPasienT($model[$i]);
        $this->successSaveBayarOA = $this->successSaveBayarOA && true;
      } else {
        echo "saveOaSudahBayar tidak valid";
        echo "<pre>" . print_r($model[$i]->errors, 1) . "</pre>";
        echo "<pre>" . print_r($model[$i]->attributes, 1) . "</pre>";
        $this->successSaveBayarOA = false;
      }
    }
  }

  protected function cekStatusBayar($sisaTagihan)
  {
    if ($sisaTagihan > 0) {
      return 'BELUM LUNAS';
    } else {
      return 'LUNAS';
    }
  }

  protected function updateObatAlkesPasienT($modOa)
  {
    ObatalkespasienT::model()->updateByPk($modOa->obatalkespasien_id, array(
      'subsidiasuransi' => $modOa->jmlsubsidi_asuransi,
      'subsidipemerintah' => $modOa->jmlsubsidi_pemerintah,
      'subsidirs' => $modOa->jmlsubsidi_rs,
      'iurbiaya' => $modOa->jmliurbiaya,
      'oasudahbayar_id' => $modOa->oasudahbayar_id
    ));
  }

  protected function cekSubsidiOa($modObatAlkesPasien)
  {
    $subsidi = array();
    if ($modObatAlkesPasien->carabayar_id != '') {
      $sql = "SELECT * FROM tanggunganpenjamin_m
                        WHERE carabayar_id = " . $modObatAlkesPasien->carabayar_id . "
                          AND penjamin_id = " . $modObatAlkesPasien->penjamin_id . "
                          AND kelaspelayanan_id = " . Params::KELASPELAYANAN_ID_TANPA_KELAS . "
                          AND tipenonpaket_id = " . $modObatAlkesPasien->tipepaket_id . "
                          AND tanggunganpenjamin_aktif = TRUE ";
      $data = Yii::app()->db->createCommand($sql)->queryRow();

      $subsidi['asuransi'] = ($data['subsidiasuransioa'] != '') ? $data['subsidiasuransioa'] : 0;
      $subsidi['pemerintah'] = ($data['subsidipemerintahoa'] != '') ? $data['subsidipemerintahoa'] : 0;
      $subsidi['rumahsakit'] = ($data['subsidirumahsakitoa'] != '') ? $data['subsidirumahsakitoa'] : 0;
    } else {
      $subsidi['asuransi'] = 0;
      $subsidi['pemerintah'] = 0;
      $subsidi['rumahsakit'] = 0;
    }

    return $subsidi;
  }
}
