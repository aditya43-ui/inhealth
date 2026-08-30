<?php

Yii::import('ambulans.controllers.PemakaianAmbulanPasienRSController');

/**
 * controller utama untuk menu pemakaian ambulans pasien luar
 * 
 * @package application.modules.ambulans
 * @subpackage contollers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author Tantowi J <tantowijaya@.com>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 */
class PemakaianAmbulanPasienLuarController extends PemakaianAmbulanPasienRSController
{
  /**
   * action utama untuk masuk ke menu transaksi pemakaian ambulans pasien luar
   * @param integer $pemakaian_id
   * @param integer $pendaftaran_id
   * @param integer $pemesanan_id
   */
  public function actionIndex($pemakaian_id = '', $pendaftaran_id = '', $pemesanan_id = '')
  {
    $this->pageTitle = Yii::app()->name . " - Pemakaian Ambulans Pasien Luar";
    $format = new MyFormatter();
    $modPasien = new PasienM;
    $modKunjungan = new AMInfokunjunganrjV;
    $modObatAlkesPasien = new AMObatalkesPasienT;
    $modPemakaian = new AMPemakaianambulansT;
    $modPendaftaran = new AMPendaftaranT;
    $modPasienMasukPenunjang = new PasienmasukpenunjangT;
    $modPemakaian->tglpemakaianambulans = date('Y-m-d H:i:s');
    $modInstalasi = InstalasiM::model()->findAllByAttributes(array('instalasi_aktif' => true), array('order' => 'instalasi_nama'));
    $instalasi = Yii::app()->user->getState('instalasi_id');
    $modPemakaian->ruangan_id = Yii::app()->user->getState('ruangan_id');

    $modPemakaian->isPendamping = true;
    $modPemakaian->isDokter = true;

    //        $instalasi = '';
    $tarif = array();
    $tarif['tarifAmbulans'][] = null;

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
    $is_api_gmap = Yii::app()->user->getState('is_api_gmap');
    if (!empty($pemesanan_id)) {
      $modPemakaian = $this->setDataPemakaianFromPemesanan($pemesanan_id);


      if (!empty($modPemakaian->ruangan_id)) {
        $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;
      } else {
        $instalasi = Yii::app()->user->getState('instalasi_id');
        $modPemakaian->ruangan_id = Yii::app()->user->getState('ruangan_id');
      }

      if (!empty($modPemakaian->pasien_id)) {
        $modPasien = AMPasienM::model()->findByPk($modPendaftaran->pasien_id);
        if (empty($modPasien)) {
          $modPasien = new PasienM;
        }
      } else {
        $modPasien->nama_pasien = $modPemakaian->namapasien;
      }

      if (!empty($modPasien->nama_pasien) || !empty($modPasien->pasien_id)) {
        $modPemakaian->is_pasien = true;
      }
    }

    if (!empty($pendaftaran_id)) {
      $modKunjungan->pendaftaran_id = $pendaftaran_id;
      if (isset($_GET['instalasi_id'])) {
        $modKunjungan->instalasi_id = $_GET['instalasi_id'];
      }
      $modPemakaian = $this->setDataPemakaianFromPendaftaran($pendaftaran_id);
      if (!empty($modPemakaian->ruangan_id)) {
        $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;
      } else {
        $instalasi = Yii::app()->user->getState('instalasi_id');
        $modPemakaian->ruangan_id = Yii::app()->user->getState('ruangan_id');
      }
      $modPendaftaran = AMPendaftaranT::model()->findByPk($pendaftaran_id);
      $modPasien = AMPasienM::model()->findByPk($modPendaftaran->pasien_id);
    }

    if (!empty($pemakaian_id)) {
      $modPemakaian = $this->setDataPemakaianFromPemakaian($pemakaian_id);
      $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;
      $modPemakaian->paramedis1_nama = isset($modPemakaian->paramedis1_id) ? $modPemakaian->paramedis1->NamaLengkap : "";
      $modPemakaian->paramedis2_nama = isset($modPemakaian->paramedis2_id) ? $modPemakaian->paramedis2->NamaLengkap : "";
      $modPemakaian->supir_nama = isset($modPemakaian->supir_id) ? $modPemakaian->supir->NamaLengkap : "";
      $modPemakaian->pelaksana_nama = isset($modPemakaian->pelaksana_id) ? $modPemakaian->pelaksana->NamaLengkap : "";
      $modPemakaian->pendampingdokter_nama = isset($modPemakaian->dokterpendampingambulance_id) ? $modPemakaian->dokterpendamping->NamaLengkap : "";
      $modPasien = AMPasienM::model()->findByPk($modPemakaian->pasien_id);

      $i = 0;
      $tarif['tarifAmbulans'][$i] = $modPemakaian->totaltarifambulans;
      $tarif['tarifKM'][$i] = $modPemakaian->tarifperkm;
      $tarif['jmlKM'][$i] = $modPemakaian->jumlahkm;
      $tarif['kelurahan'][$i] = $modPemakaian->kelurahan_nama;
      $tarif['kecamatan'][$i] = '';
      $tarif['kabupaten'][$i] = '';
      $tarif['propinsi'][$i] = '';
      $tarif['daftartindakanId'][$i] = $modPemakaian->daftartindakan_id;
      $tarif['alamat'][$i] = '';
      $tarif['layanan'][$i] = $modPemakaian->jenispelayanan_ambulans;
      $daftar = DaftartindakanM::model()->findByPk($modPemakaian->daftartindakan_id);
      $tarif['tindakan'][$i] = !empty($daftar) ? $daftar->daftartindakan_nama : '';

      $tarif['jenispelayanan_ambulans_id'][$i] = '';
      $tarif['ruteasal_ambulan'][$i] = $modPemakaian->ruteasal_ambulan;
      $tarif['rutetujuan_ambulan'][$i] = $modPemakaian->rutetujuan_ambulan;
      $tarif['durasipemakaian_ambulan'][$i] = $modPemakaian->durasipemakaian_ambulan;
      $tarif['jenispelayanan_ambulans'][$i] = $modPemakaian->jenispelayanan_ambulans;
      $tarif['jasasarana_ambulans'][$i] = $modPemakaian->jasasarana_ambulans;
      $tarif['harga_bbm'][$i] = $modPemakaian->harga_bbm;
      $tarif['bhp'][$i] = $modPemakaian->bhp;
      $tarif['jasapengemudi'][$i] = $modPemakaian->jasapengemudi;
      $tarif['jasapendamping'][$i] = $modPemakaian->jasapendamping;
      $tarif['jasadokter'][$i] = $modPemakaian->jasadokter;
    }

    if (isset($_POST['AMPemakaianambulansT'])) {


      if (isset($_POST['tarif'])) {

        $transaction = Yii::app()->db->beginTransaction();
        try {
          if ($_POST['AMPemakaianambulansT']['is_pasien']) {
            if (isset($_POST['PasienM'])) {
              $modPasien = $this->simpanPasienAmbulan($modPasien, $_POST['PasienM']);
            }
          } else {
            $modPasien = AMPasienM::model()->findByAttributes(array('no_rekam_medik' => Params::DEFAULT_PASIEN_AMBULAN_LUAR_RM));
          }

          $modPendaftaran = $this->simpanPendaftaran($modPendaftaran, $modPasien);


          foreach ($_POST['tarif']['tarifAmbulans'] as $i => $tarifAmbulans) {
            $tarif['tarifAmbulans'][$i] = $tarifAmbulans;
            $tarif['tarifKM'][$i] = isset($_POST['tarif']['tarifKM'][$i]) ? $_POST['tarif']['tarifKM'][$i] : 0;
            $tarif['jmlKM'][$i] = isset($_POST['tarif']['jmlKM'][$i]) ? $_POST['tarif']['jmlKM'][$i] : 0;
            $tarif['kelurahan'][$i] = isset($_POST['tarif']['kelurahan'][$i]) ? $_POST['tarif']['kelurahan'][$i] : "";
            $tarif['kecamatan'][$i] = isset($_POST['tarif']['kecamatan'][$i]) ? $_POST['tarif']['kecamatan'][$i] : "";
            $tarif['kabupaten'][$i] = isset($_POST['tarif']['kabupaten'][$i]) ? $_POST['tarif']['kabupaten'][$i] : "";
            $tarif['propinsi'][$i] = isset($_POST['tarif']['propinsi'][$i]) ? $_POST['tarif']['propinsi'][$i] : "";
            $tarif['daftartindakanId'][$i] = isset($_POST['tarif']['daftartindakanId'][$i]) ? $_POST['tarif']['daftartindakanId'][$i] : null;
            $tarif['alamat'][$i] = isset($_POST['tarif']['alamat'][$i]) ? $_POST['tarif']['alamat'][$i] : "";
            $tarif['layanan'][$i] = isset($_POST['tarif']['layanan'][$i]) ? $_POST['tarif']['layanan'][$i] : "";
            $tarif['tindakan'][$i] = isset($_POST['tarif']['tindakan'][$i]) ? $_POST['tarif']['tindakan'][$i] : "";

            $tarif['jenispelayanan_ambulans_id'][$i] = isset($_POST['tarif']['jenispelayanan_ambulans_id'][$i]) ? $_POST['tarif']['jenispelayanan_ambulans_id'][$i] : null;
            $tarif['ruteasal_ambulan'][$i] = isset($_POST['tarif']['ruteasal_ambulan'][$i]) ? $_POST['tarif']['ruteasal_ambulan'][$i] : "";
            $tarif['rutetujuan_ambulan'][$i] = isset($_POST['tarif']['rutetujuan_ambulan'][$i]) ? $_POST['tarif']['rutetujuan_ambulan'][$i] : "";
            $tarif['durasipemakaian_ambulan'][$i] = isset($_POST['tarif']['durasipemakaian_ambulan'][$i]) ? $_POST['tarif']['durasipemakaian_ambulan'][$i] : "";
            $tarif['jenispelayanan_ambulans'][$i] = isset($_POST['tarif']['jenispelayanan_ambulans'][$i]) ? $_POST['tarif']['jenispelayanan_ambulans'][$i] : "";
            $tarif['jasasarana_ambulans'][$i] = isset($_POST['tarif']['jasasarana_ambulans'][$i]) ? $_POST['tarif']['jasasarana_ambulans'][$i] : 0;

            $tarif['harga_bbm'][$i] = isset($_POST['tarif']['harga_bbm'][$i]) ? $_POST['tarif']['harga_bbm'][$i] : 0;
            $tarif['tarif_bbm'][$i] = isset($_POST['tarif']['tarif_bbm'][$i]) ? $_POST['tarif']['tarif_bbm'][$i] : 0;
            $tarif['hari_bbm'][$i] = isset($_POST['tarif']['tarif_bbm'][$i]) ? $_POST['tarif']['hari_bbm'][$i] : 0;

            $tarif['jasapendamping'][$i] = isset($_POST['tarif']['jasapendamping'][$i]) ? $_POST['tarif']['jasapendamping'][$i] : 0;
            $tarif['jasapendamping_satuan'][$i] = isset($_POST['tarif']['jasapendamping_satuan'][$i]) ? $_POST['tarif']['jasapendamping_satuan'][$i] : 0;
            $tarif['jasapendamping_qty'][$i] = isset($_POST['tarif']['jasapendamping_qty'][$i]) ? $_POST['tarif']['jasapendamping_qty'][$i] : 0;
            $tarif['jasapendamping_hari'][$i] = isset($_POST['tarif']['jasapendamping_hari'][$i]) ? $_POST['tarif']['jasapendamping_hari'][$i] : 0;

            $tarif['akomodasipendamping'][$i] = isset($_POST['tarif']['akomodasipendamping'][$i]) ? $_POST['tarif']['akomodasipendamping'][$i] : 0;
            $tarif['akomodasipendamping_satuan'][$i] = isset($_POST['tarif']['akomodasipendamping_satuan'][$i]) ? $_POST['tarif']['akomodasipendamping_satuan'][$i] : 0;
            $tarif['akomodasipendamping_qty'][$i] = isset($_POST['tarif']['akomodasipendamping_qty'][$i]) ? $_POST['tarif']['akomodasipendamping_qty'][$i] : 0;
            $tarif['akomodasipendamping_hari'][$i] = isset($_POST['tarif']['akomodasipendamping_hari'][$i]) ? $_POST['tarif']['akomodasipendamping_hari'][$i] : 0;

            $tarif['biayatol'][$i] = isset($_POST['tarif']['biayatol'][$i]) ? $_POST['tarif']['biayatol'][$i] : 0;
            $tarif['biaya_tol_satuan'][$i] = isset($_POST['tarif']['biaya_tol_satuan'][$i]) ? $_POST['tarif']['biaya_tol_satuan'][$i] : 0;
            $tarif['biaya_tol_qty'][$i] = isset($_POST['tarif']['biaya_tol_qty'][$i]) ? $_POST['tarif']['biaya_tol_qty'][$i] : 0;
            $tarif['biaya_tol_hari'][$i] = isset($_POST['tarif']['biaya_tol_hari'][$i]) ? $_POST['tarif']['biaya_tol_hari'][$i] : 0;

            $tarif['biayahotel'][$i] = isset($_POST['tarif']['biayahotel'][$i]) ? $_POST['tarif']['biayahotel'][$i] : 0;
            $tarif['biayahotel_satuan'][$i] = isset($_POST['tarif']['biayahotel_satuan'][$i]) ? $_POST['tarif']['biayahotel_satuan'][$i] : 0;
            $tarif['biayahotel_qty'][$i] = isset($_POST['tarif']['biayahotel_qty'][$i]) ? $_POST['tarif']['biayahotel_qty'][$i] : 0;
            $tarif['biayahotel_hari'][$i] = isset($_POST['tarif']['biayahotel_hari'][$i]) ? $_POST['tarif']['biayahotel_hari'][$i] : 0;

            $tarif['biayatiket'][$i] = isset($_POST['tarif']['biayatiket'][$i]) ? $_POST['tarif']['biayatiket'][$i] : 0;
            $tarif['biayatiket_satuan'][$i] = isset($_POST['tarif']['biayatiket_satuan'][$i]) ? $_POST['tarif']['biayatiket_satuan'][$i] : 0;
            $tarif['biayatiket_qty'][$i] = isset($_POST['tarif']['biayatiket_qty'][$i]) ? $_POST['tarif']['biayatiket_qty'][$i] : 0;
            $tarif['biayatiket_hari'][$i] = isset($_POST['tarif']['biayatiket_hari'][$i]) ? $_POST['tarif']['biayatiket_hari'][$i] : 0;

            $tarif['jasadokter'][$i] = isset($_POST['tarif']['jasadokter'][$i]) ? $_POST['tarif']['jasadokter'][$i] : 0;
            $tarif['jasadokter_satuan'][$i] = isset($_POST['tarif']['jasadokter_satuan'][$i]) ? $_POST['tarif']['jasadokter_satuan'][$i] : 0;
            $tarif['jasadokter_qty'][$i] = isset($_POST['tarif']['jasadokter_qty'][$i]) ? $_POST['tarif']['jasadokter_qty'][$i] : 0;
            $tarif['jasadokter_hari'][$i] = isset($_POST['tarif']['jasadokter_hari'][$i]) ? $_POST['tarif']['jasadokter_hari'][$i] : 0;

            $tarif['uangmakandokter'][$i] = isset($_POST['tarif']['uangmakandokter'][$i]) ? $_POST['tarif']['uangmakandokter'][$i] : 0;
            $tarif['uangmakandokter_satuan'][$i] = isset($_POST['tarif']['uangmakandokter_satuan'][$i]) ? $_POST['tarif']['uangmakandokter_satuan'][$i] : 0;
            $tarif['uangmakandokter_qty'][$i] = isset($_POST['tarif']['uangmakandokter_qty'][$i]) ? $_POST['tarif']['uangmakandokter_qty'][$i] : 0;
            $tarif['uangmakandokter_hari'][$i] = isset($_POST['tarif']['uangmakandokter_hari'][$i]) ? $_POST['tarif']['uangmakandokter_hari'][$i] : 0;

            $tarif['biayahoteldokter'][$i] = isset($_POST['tarif']['biayahoteldokter'][$i]) ? $_POST['tarif']['biayahoteldokter'][$i] : 0;
            $tarif['biayahoteldokter_satuan'][$i] = isset($_POST['tarif']['biayahoteldokter_satuan'][$i]) ? $_POST['tarif']['biayahoteldokter_satuan'][$i] : 0;
            $tarif['biayahoteldokter_qty'][$i] = isset($_POST['tarif']['biayahoteldokter_qty'][$i]) ? $_POST['tarif']['biayahoteldokter_qty'][$i] : 0;
            $tarif['biayahoteldokter_hari'][$i] = isset($_POST['tarif']['biayahoteldokter_hari'][$i]) ? $_POST['tarif']['biayahoteldokter_hari'][$i] : 0;

            $tarif['biayatiketdokter'][$i] = isset($_POST['tarif']['biayatiketdokter'][$i]) ? $_POST['tarif']['biayatiketdokter'][$i] : 0;
            $tarif['biayatiketdokter_satuan'][$i] = isset($_POST['tarif']['biayatiketdokter_satuan'][$i]) ? $_POST['tarif']['biayatiketdokter_satuan'][$i] : 0;
            $tarif['biayatiketdokter_qty'][$i] = isset($_POST['tarif']['biayatiketdokter_qty'][$i]) ? $_POST['tarif']['biayatiketdokter_qty'][$i] : 0;
            $tarif['biayatiketdokter_hari'][$i] = isset($_POST['tarif']['biayatiketdokter_hari'][$i]) ? $_POST['tarif']['biayatiketdokter_hari'][$i] : 0;

            $tarif['bhp'][$i] = isset($_POST['tarif']['bhp'][$i]) ? $_POST['tarif']['bhp'][$i] : 0;
            $tarif['jasapengemudi'][$i] = isset($_POST['tarif']['jasapengemudi'][$i]) ? $_POST['tarif']['jasapengemudi'][$i] : 0;


            //=== set attribute pemakaian ambulans ===//
            $save = true;
            //$modPemakaian = new AMPemakaianambulansT;
            $modPemakaian->attributes = $_POST['AMPemakaianambulansT'];
            $modPemakaian->pasien_id = $modPendaftaran->pasien_id;
            $modPemakaian->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modPemakaian->namapasien = $modPasien->nama_pasien;
            $modPemakaian->noidentitas = $modPasien->no_identitas_pasien;
            $modPemakaian->norekammedis = $modPasien->no_rekam_medik;
            $modPemakaian->pelaksana_id = empty($modPemakaian->pelaksana_id) ? null : $modPemakaian->pelaksana_id;
            $modPemakaian->paramedis1_id = empty($modPemakaian->paramedis1_id) ? null : $modPemakaian->paramedis1_id;
            $modPemakaian->paramedis2_id = empty($modPemakaian->paramedis2_id) ? null : $modPemakaian->paramedis2_id;
            $modPemakaian->rt_rw = $_POST['AMPemakaianambulansT']['rt'] . '/' . $_POST['AMPemakaianambulansT']['rw'];
            $modPemakaian->tarifperkm = $tarif['tarifKM'][$i];
            $modPemakaian->jumlahkm = $tarif['jmlKM'][$i];
            $modPemakaian->totaltarifambulans = $tarif['tarifAmbulans'][$i];
            $modPemakaian->daftartindakanId = $tarif['daftartindakanId'][$i];
            $modPemakaian->daftartindakan_id = $tarif['daftartindakanId'][$i];
            $modPemakaian->ispemakaian_luar = TRUE;
            if (empty($modPemakaian->pemakaianambulans_id)) {
              $modPemakaian->create_time = date('Y-m-d H:i:s');
              $modPemakaian->create_loginpemakai_id = Yii::app()->user->id;
              $modPemakaian->create_ruangan = Yii::app()->user->getState('ruangan_id');
            } else {
              $modPemakaian->update_time = date('Y-m-d H:i:s');
              $modPemakaian->update_loginpemakai_id = Yii::app()->user->id;
            }
            $modPemakaian->noidentitas = Yii::app()->user->getState('ruangan_id');

            $modPemakaian->jenispelayanan_ambulans_id = $tarif['jenispelayanan_ambulans_id'][$i];
            $modPemakaian->ruteasal_ambulan = $tarif['ruteasal_ambulan'][$i];
            $modPemakaian->rutetujuan_ambulan = $tarif['rutetujuan_ambulan'][$i];
            $modPemakaian->durasipemakaian_ambulan = $tarif['durasipemakaian_ambulan'][$i];
            //$modPemakaian->jenispelayanan_ambulans = $tarif['jenispelayanan_ambulans'][$i];
            $modPemakaian->jenispelayanan_ambulans = $tarif['layanan'][$i];
            $modPemakaian->jasasarana_ambulans = $tarif['jasasarana_ambulans'][$i];
            $modPemakaian->harga_bbm = $tarif['harga_bbm'][$i];
            $modPemakaian->bhp = $tarif['bhp'][$i];
            $modPemakaian->jasapengemudi = $tarif['jasapengemudi'][$i];



            $modPemakaian->harga_bbm_hargasatuan = $tarif['harga_bbm'][$i];
            $modPemakaian->tarif_hari = $tarif['hari_bbm'][$i];
            $modPemakaian->harga_bbm = $tarif['tarif_bbm'][$i];

            $modPemakaian->jasapendamping = $tarif['jasapendamping'][$i];
            $modPemakaian->jasapendamping_hargasatuan = $tarif['jasapendamping_satuan'][$i];
            $modPemakaian->jasapendamping_qty = $tarif['jasapendamping_qty'][$i];
            $modPemakaian->jasapendamping_hari = $tarif['jasapendamping_hari'][$i];

            $modPemakaian->akomodasipendamping = $tarif['akomodasipendamping'][$i];
            $modPemakaian->akomodasipendamping_hargasatuan = $tarif['akomodasipendamping_satuan'][$i];
            $modPemakaian->akomodasipendamping_qty = $tarif['akomodasipendamping_qty'][$i];
            $modPemakaian->akomodasipendamping_hari = $tarif['akomodasipendamping_hari'][$i];



            // ako lain2

            $modPemakaian->biayatol = $tarif['biayatol'][$i];
            $modPemakaian->biayatol_hargasatuan = $tarif['biaya_tol_satuan'][$i];
            $modPemakaian->biayatol_qty = $tarif['biaya_tol_qty'][$i];
            $modPemakaian->biayatol_hari = $tarif['biaya_tol_hari'][$i];

            $modPemakaian->biayahotel = $tarif['biayahotel'][$i];
            $modPemakaian->biayahotel_hargasatuan = $tarif['biayahotel_satuan'][$i];
            $modPemakaian->biayahotel_qty = $tarif['biayahotel_qty'][$i];
            $modPemakaian->biayahotel_hari = $tarif['biayahotel_hari'][$i];

            $modPemakaian->biayatiket = $tarif['biayatiket'][$i];
            $modPemakaian->biayatiket_hargasatuan = $tarif['biayatiket_satuan'][$i];
            $modPemakaian->biayatiket_qty = $tarif['biayatiket_qty'][$i];
            $modPemakaian->biayatiket_hari = $tarif['biayatiket_hari'][$i];


            // dokter
            $modPemakaian->jasadokter = $tarif['jasadokter'][$i];
            $modPemakaian->jasadokter_hargasatuan = $tarif['jasadokter_satuan'][$i];
            $modPemakaian->jasadokter_qty = $tarif['biayatiket_qty'][$i];
            $modPemakaian->jasadokter_hari = $tarif['jasadokter_hari'][$i];

            $modPemakaian->uangmakandokter = $tarif['uangmakandokter'][$i];
            $modPemakaian->uangmakandokter_hargasatuan = $tarif['uangmakandokter_satuan'][$i];
            $modPemakaian->uangmakandokter_qty = $tarif['uangmakandokter_qty'][$i];
            $modPemakaian->uangmakandokter_hari = $tarif['uangmakandokter_hari'][$i];

            $modPemakaian->biayahoteldokter = $tarif['biayahoteldokter'][$i];
            $modPemakaian->biayahoteldokter_hargasatuan = $tarif['biayahoteldokter_satuan'][$i];
            $modPemakaian->biayahoteldokter_qty = $tarif['biayahoteldokter_qty'][$i];
            $modPemakaian->biayahoteldokter_hari = $tarif['biayahoteldokter_hari'][$i];

            $modPemakaian->biayatiketdokter = $tarif['biayatiketdokter'][$i];
            $modPemakaian->biayatiketdokter_hargasatuan = $tarif['biayatiketdokter_satuan'][$i];
            $modPemakaian->biayatiketdokter_qty = $tarif['biayatiketdokter_qty'][$i];
            $modPemakaian->biayatiketdokter_hari = $tarif['biayatiketdokter_hari'][$i];


            $instalasi = $_POST['instalasi'];
            $format = new MyFormatter();
            if (!empty($_POST['AMPemakaianambulansT']['tglpemakaianambulans'])) {
              $modPemakaian->tglpemakaianambulans = $format->formatDateTimeForDb($_POST['AMPemakaianambulansT']['tglpemakaianambulans']);
            } else {
              //$modPemakaian->tglpemakaianambulans = $format->formatDateTimeForDb($_POST['AMPemakaianambulansT']['tglpemakaianambulans']);
            }
            $modPemakaian->tglkembaliambulans = $format->formatDateTimeForDb($_POST['AMPemakaianambulansT']['tglkembaliambulans']);
            //						$modPemakaian->alamattujuan = $tarif['alamat'][$i];
            $modPemakaian->alamattujuan = $_POST['AMPemakaianambulansT']['alamattujuan'];

            $modPemakaian->validate();
            echo CHtml::errorSummary($modPemakaian);
            //=== save pemakaian ambulans ===//
            if ($modPemakaian->validate()) {
              $save = $save && $modPemakaian->save();

              MobilambulansM::model()->updateByPk($modPemakaian->mobilambulans_id, array(
                'isterpakai' => true,
              ));

              if (!empty($pemesanan_id)) {
                AMPesanambulansT::model()->updateByPk($pemesanan_id, array('pemakaianambulans_id' => $modPemakaian->pemakaianambulans_id));
              }
              $modPendaftaran = PendaftaranT::model()->findByPk($modPemakaian->pendaftaran_id);
              $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
              $modPasienMasukPenunjang = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $modPemakaian); //RSSP-1456
              $tindakanPel = $this->saveTindakanPelayanan($modPasien, $modPendaftaran, $modPemakaian, $modPasienMasukPenunjang);


              if (!empty($modPemakaian->daftartindakanId) || !empty($modPemakaian->jenispelayanan_ambulans_id)) {
                AMPemakaianambulansT::model()->updateByPk($modPemakaian->pemakaianambulans_id, array('tindakanpelayanan_id' => $tindakanPel->tindakanpelayanan_id, 'update_time' => date('Y-m-d H:i:s'), 'update_loginpemakai_id' => Yii::app()->user->id));
              }
            } else {
              $save = false;
            }
          }
          //=== simpan pemakaian obat alkes ===//
          if (!empty($modPemakaian->pendaftaran_id)) {
            $modPendaftaran = PendaftaranT::model()->findByPk($modPemakaian->pendaftaran_id);
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
            if (isset($_POST['pemakaianBahan'])) {
              if (count((array)$_POST['pemakaianBahan']) > 0) {
                //PROSES GROUP DETAIL BERDASARKAN obatalkes_id & akumulasikan jumlah pesan
                $detailGroups = array();
                foreach ($_POST['pemakaianBahan'] as $i => $postDetail) {
                  $modDetails[$i] = new AMObatalkesPasienT();
                  $modDetails[$i]->attributes = $postDetail;
                  $modStok = StokobatalkesT::model()->findByPk($postDetail['stokobatalkes_id']);
                  $modDetails[$i]->stokobatalkes_id = $modStok->stokobatalkes_id;
                  $obatalkes_id = $postDetail['obatalkes_id'];
                  if (isset($detailGroups[$obatalkes_id])) {
                    $detailGroups[$obatalkes_id]['qty_oa'] += $postDetail['qty_oa'];
                  } else {
                    $detailGroups[$obatalkes_id]['obatalkes_id'] = $postDetail['obatalkes_id'];
                    $detailGroups[$obatalkes_id]['qty_oa'] = $postDetail['qty_oa'];
                  }
                }
                //END GROUP
              }

              $obathabis = "";
              //PROSES PENGURAIAN OBAT DAN JUMLAH MENJADI STOKOBATALKES_T (METODE ANTRIAN)
              foreach ($detailGroups as $i => $detail) {
                $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($detail['obatalkes_id'], $detail['qty_oa'], Yii::app()->user->getState('ruangan_id'));
                if (count((array)$modStokOAs) > 0) {
                  foreach ($modStokOAs as $i => $stok) {
                    $modDetails[$i] = $this->simpanObatAlkesPasien($modPendaftaran, $stok, $_POST['pemakaianBahan']);
                    $this->simpanStokObatAlkesOut($stok['stokobatalkes_id'], $modDetails[$i]);
                  }
                } else {
                  $this->stokobatalkestersimpan &= false;
                  $obathabis .= "<br>- " . ObatalkesM::model()->findByPk($detail['obatalkes_id'])->obatalkes_nama;
                }
              }
            }
          }

          // var_dump($save, $this->successSavePemakaianBahan, $this->tindakanpelayanantersimpan, $_POST); die; 

          //=== commit or rollback ===//
          if ($save && $this->successSavePemakaianBahan && $this->tindakanpelayanantersimpan) {
            // SMS GATEWAY
            $sms = new Sms();
            $smspasien = 1;
            foreach ($modSmsgateway as $i => $smsgateway) {
              $isiPesan = $smsgateway->templatesms;
              $attributes = $modPemakaian->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
              $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modPemakaian->tglpemakaianambulans), $isiPesan);
              $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);

              if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
                if (!empty($modPemakaian->nomobile)) {
                  $sms->kirim($modPemakaian->nomobile, $isiPesan);
                } else {
                  $smspasien = 0;
                }
              }
            }
            // END SMS GATEWAY
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data Pasien " . $modPendaftaran->pasien->nama_pasien . " Berhasil disimpan");
            $sukses = 1;
            $modPemakaian->isNewRecord = FALSE;
            $this->redirect(array('index', 'pemakaian_id' => $modPemakaian->pemakaianambulans_id, 'pendaftaran_id' => $modPemakaian->pendaftaran_id, 'sukses' => $sukses, 'smspasien' => $smspasien));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data Gagal disimpan");
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
        }
      } else {
        Yii::app()->user->setFlash('error', "Pilih terlebih dahulu tarif ambulans !");
      }
    }

    $modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
    $latitude = $modPropinsi->latitude;
    $longitude = $modPropinsi->longitude;

    $this->render('index', array(
      'modPemakaian' => $modPemakaian,
      'modPasien' => $modPasien,
      'modInstalasi' => $modInstalasi,
      'instalasi' => $instalasi,
      'tarif' => $tarif,
      'modKunjungan' => $modKunjungan,
      'format' => $format,
      'modObatAlkesPasien' => $modObatAlkesPasien,
      'latitude' => $latitude,
      'longitude' => $longitude,
      'is_api_gmap' => $is_api_gmap,
      'modPasien' => $modPasien
    ));
  }

  /**
   * Print status
   * @param integer $pemakaianambulans_id
   */
  public function actionPrintStatusAmbulans($pemakaianambulans_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPemakaian = AMPemakaianambulansT::model()->findByPk($pemakaianambulans_id);
    $judul_print = 'Pemakaian Ambulance Pasien Luar';
    $this->render('printStatusAmbulan', array(
      'format' => $format,
      'modPemakaian' => $modPemakaian,
      'judul_print' => $judul_print,
    ));
  }

  /**
   * set tanggal lahir dari umur (__ Thn __ Bln __ Hr)
   */
  public function actionSetTanggalLahir()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data['tanggal_lahir'] = date("d/m/Y", strtotime(CustomFunction::getTanggalUmur($_POST['umur'])));

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * set umur dari tanggal lahir (date)
   */
  public function actionSetUmur()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data['umur'] = null;
      if (isset($_POST['tanggal_lahir']) && !empty($_POST['tanggal_lahir'])) {
        $data['umur'] = CustomFunction::hitungUmur($_POST['tanggal_lahir']);
      }
      echo json_encode($data);
      Yii::app()->end();
    }
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
      $model = AMPasienM::model()->find($criteria);
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
   * action autocomplete pasien
   */
  public function actionAutocompletePasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
      $criteria->order = 'no_rekam_medik';
      $criteria->limit = 10;
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

  /**
   * Simpan/update data pasien
   * @param array $modPasien
   * @param array $post
   * @return \FAPasienM
   */
  public function simpanPasienAmbulan($modPasien, $post)
  {
    $format = new MyFormatter();
    if (!empty($post['pasien_id'])) {
      if ($post['pasien_id']) {
        $loadPasien = AMPasienM::model()->findByPk($post['pasien_id']);
        if (isset($loadPasien)) {
          $modPasien = $loadPasien;
          $modPasien->attributes = $_POST['PasienM'];
          $modPasien->tanggal_lahir = MyFormatter::formatDateTimeForDb($modPasien->tanggal_lahir);
          $modPasien->update_time = date("Y-m-d H:i:s");
          $modPasien->update_loginpemakai_id = Yii::app()->user->id;
          $modPasien->update();
        }
      }
    } else {
      $modPasien->attributes = $post;
      $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
      $modPasien->tanggal_lahir = $format->dateTimeForDb($modPasien->tanggal_lahir);
      $modPasien->no_rekam_medik = MyGenerator::noRekamMedik("AM", 'TRUE');
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
    }

    return $modPasien;
  }

  /**
   * Simpan pendaftaran pemakaian ambulan pasien luar
   * @param array $model
   * @param array $modPasien
   * @return \AMPendaftaranT
   */
  public function simpanPendaftaran($model, $modPasien)
  {
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->pasien_id = $modPasien->pasien_id;
    $model->jeniskasuspenyakit_id = Params::JENIS_KASUSPENYAKIT_ID_UMUM;
    $model->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
    $model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    $model->instalasi_id = (isset($model->ruangan_id) ? $model->ruangan->instalasi_id : null);
    $model->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);
    $model->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
    $model->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
    $model->pegawai_id = (!empty($_POST['AMPemakaianambulansT']['paramedis1_id']) ? $_POST['AMPemakaianambulansT']['paramedis1_id'] : null);
    $model->statuspasien = (empty($_POST['AMPasienM']['pasien_id']) ? Params::STATUSPASIEN_BARU : Params::STATUSPASIEN_LAMA);
    $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
    $model->shift_id = Yii::app()->user->getState('shift_id');
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_time = date("Y-m-d H:i:s");
    $model->statusmasuk = (!empty($model->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
    $model->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
    $model->penjamin_id = Params::PENJAMIN_ID_UMUM;
    $model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id);
    if (Yii::app()->user->getState('tgltransaksimundur') && !empty($model->tgl_pendaftaran)) {
      $model->tgl_pendaftaran = $format->formatDateTimeForDb($model->tgl_pendaftaran);
    } else {
      $model->tgl_pendaftaran = date("Y-m-d H:i:s");
    }
    $model->no_pendaftaran = MyGenerator::noPendaftaranPemakaianAmbulan($model->tgl_pendaftaran);
    $model->keterangan_pendaftaran = "Pemakaian Ambulans Pasien Luar";

    $model->save();

    return $model;
  }
}
