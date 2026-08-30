<?php

/**
 * Form karcis Pelayanan Pasien
 */
class KarcisController extends MyAuthController
{
  public $layout = "//layouts/iframe";

  public $karcistersimpan = false;
  public $komponentindakantersimpan = false;

  /**
   * Form Karcis Pelayanan Pasien
   * 
   * @param integer $pendaftaran_id
   * @param integer $pasienadmisi_id
   */
  public function actionIndex($pendaftaran_id, $pasienadmisi_id = null)
  {
    $format = new MyFormatter();
    $modTindakan = new BKTindakanPelayananT;
    $modPasienAdmisi = BKPasienadmisiT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id
    ));
    $modPendaftaran = BKPendaftaranT::model()->findByPk($pendaftaran_id);
    $kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $ruangan_id = $modPendaftaran->ruangan_id;
    $penjamin_id = $modPendaftaran->penjamin_id;
    if (!empty($modPasienAdmisi)) {
      // $modPasienAdmisi = BKPasienadmisiT::model()->findByPk($pasienadmisi_id);
      $kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
      $ruangan_id = $modPasienAdmisi->ruangan_id;
      $penjamin_id = $modPasienAdmisi->penjamin_id;
    } else {
      $modPasienAdmisi = new BKPasienadmisiT;
    }
    $dataTindakanKarcis = $this->loadTindakanKarcis($modPendaftaran, $modPasienAdmisi);
    $criteria = new CdbCriteria();
    $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
    $criteria->addCondition("ruangan_id = " . $ruangan_id);
    $criteria->addCondition("penjamin_id = " . $penjamin_id);

    $statuspasien = ($modPendaftaran->statuspasien == 'PENGUNJUNG LAMA') ? "pasienbaru_karcis is true" : "pasienbaru_karcis is false";

    $criteria->addCondition($statuspasien);
    
    //        $criteria->addCondition("pasienbaru_karcis = $is_pasienbaru");
    $modKarcisVs = KarcisV::model()->findAll($criteria);

    if (isset($_POST['BKTindakanPelayananT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $this->karcistersimpan = true;
        $this->komponentindakantersimpan = true;

        if (count((array)$_POST['BKTindakanPelayananT']) > 0) {
          foreach ($_POST['BKTindakanPelayananT'] as $i => $karcis) {
            if ($karcis['is_pilihtindakan']) {
              if ($dataTindakanKarcis) {
                if ($dataTindakanKarcis->karcis_id != $karcis['karcis_id']) {
                  $hapusKomponen = TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $dataTindakanKarcis->tindakanpelayanan_id));
                  $dataTindakanKarcis->delete();
                  $karcisBaru = $this->simpanKarcis($modTindakan, $modPendaftaran, $modPasienAdmisi, $karcis);
                }
              } else {
                $karcisBaru = $this->simpanKarcis($modTindakan, $modPendaftaran, $modPasienAdmisi, $karcis);
              }
              if (isset($karcisBaru)) {
                $dataTindakanKarcis = $karcisBaru;
                $modPendaftaran->karcis_id = $karcisBaru->karcis_id;
                $modPendaftaran->update();
              }
            }
          }
        }

        if ($this->karcistersimpan && $this->komponentindakantersimpan) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data karcis Pasien " . $modPendaftaran->pasien->nama_pasien . " berhasil disimpan !");
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data karcis gagal disimpan !");
          //                        echo "-".$this->karcistersimpan."<br>";
          //                        echo "-".$this->komponentindakantersimpan."<br>";
          //                        exit;
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data karcis gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }


    $this->render('index', array(
      'format' => $format,
      'modTindakan' => $modTindakan,
      'modPendaftaran' => $modPendaftaran,
      'modPasienAdmisi' => $modPasienAdmisi,
      'modKarcisVs' => $modKarcisVs,
      'dataTindakanKarcis' => $dataTindakanKarcis,
    ));
  }

  /**
   * Load tindakan karcis berdasarkan pasien kunjungan
   * 
   * @param  PendaftaranT         $modPendaftaran
   * @param  PasienadmisiT        $modPasienAdmisi
   * @return BKTindakanPelayananT load karcis
   */
  protected function loadTindakanKarcis($modPendaftaran, $modPasienAdmisi)
  {
    $criteria = new CdbCriteria();
    if (!empty($modPendaftaran->karcis_id)) {
      $criteria->addCondition("karcis_id = " . $modPendaftaran->karcis_id);
    }
    $criteria->addCondition("pendaftaran_id = " . $modPendaftaran->pendaftaran_id);
    $criteria->addCondition("tindakansudahbayar_id IS NULL");
    if (!empty($modPasienAdmisi->pasienadmisi_id))
      $criteria->addCondition("pasienadmisi_id = " . $modPasienAdmisi->pasienadmisi_id);

    $tindakanKarcis = BKTindakanPelayananT::model()->find($criteria);
    return $tindakanKarcis;
  }

  /**
   * proses simpan karcis
   * @param TindakanpelayananT $modTindakan
   * @param PendaftaranT       $modPendaftaran
   * @param PasienadmisiT      $modPasienAdmisi
   * @param mixed $post
   * @return type
   */
  public function simpanKarcis($modTindakan, $modPendaftaran, $modPasienAdmisi, $post)
  {
    $modTindakan = new $modTindakan;
    $modTindakan->attributes = $post;
    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    $modTindakan->instalasi_id = $modPendaftaran->instalasi_id;
    $modTindakan->ruangan_id = $modPendaftaran->ruangan_id;
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTindakan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->carabayar_id = $modPendaftaran->carabayar_id;
    $modTindakan->penjamin_id = $modPendaftaran->penjamin_id;
    $modTindakan->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
    $modTindakan->pasien_id = $modPendaftaran->pasien_id;
    $modTindakan->dokterpemeriksa1_id = $modPendaftaran->pegawai_id;
    $modTindakan->karcis_id = $post['karcis_id'];
    $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
    $modTindakan->qty_tindakan = 1;
    $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7250
    $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
    $modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_PENDAFTARAN;
    if (!empty($modPasienAdmisi->pasienadmisi_id)) { //jika admisi (rawat inap)

      $ruangan = RuanganM::model()->findByPk($modPasienAdmisi->ruangan_id);

      $modTindakan->pasienadmisi_id = $modPasienAdmisi->pasienadmisi_id;
      $modTindakan->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
      $modTindakan->carabayar_id = $modPasienAdmisi->carabayar_id;
      $modTindakan->penjamin_id = $modPasienAdmisi->penjamin_id;
      $modTindakan->dokterpemeriksa1_id = $modPasienAdmisi->pegawai_id;
      $modTindakan->instalasi_id = $ruangan->instalasi_id;
      $modTindakan->ruangan_id = $modPasienAdmisi->ruangan_id;
    }
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
    if (!empty($modTindakan->karcis_id)) {
      $modTindakan->tipepaket_id = $this->tipePaketKarcis($modPendaftaran, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
    }
    if ($modTindakan->save()) {
      $this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
      $this->karcistersimpan = true;
    } else {
      $this->karcistersimpan = false;
    }

    return $modTindakan;
  }

  /**
   * menentukan tipepaket_id
   * @param PendaftaranT $modPendaftaran
   * @param integer      $karcis_id
   * @param integer      $tindakan_id
   * @return integer
   */
  public function tipePaketKarcis($modPendaftaran, $karcis_id, $tindakan_id)
  {
    $criteria = new CDbCriteria;
    $criteria->with = array('tipepaket');
    if (!empty($tindakan_id)) {
      $criteria->addCondition("daftartindakan_id = " . $tindakan_id);
    }
    if (!empty($modPendaftaran->carabayar_id)) {
      $criteria->addCondition("tipepaket.carabayar_id = " . $modPendaftaran->carabayar_id);
    }
    if (!empty($modPendaftaran->penjamin_id)) {
      $criteria->addCondition("tipepaket.penjamin_id = " . $modPendaftaran->penjamin_id);
    }
    if (!empty($modPendaftaran->kelaspelayanan_id)) {
      $criteria->addCondition("tipepaket.kelaspelayanan_id = " . $modPendaftaran->kelaspelayanan_id);
    }
    $paket = PaketpelayananM::model()->find($criteria);
    $result = Params::TIPEPAKET_ID_NONPAKET;
    if (isset($paket)) $result = $paket->tipepaket_id;

    return $result;
  }
}
