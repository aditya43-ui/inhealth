<?php

class PemakaianAmbulanPasienRSController extends MyAuthController
{
  protected $obatalkespasientersimpan = true;
  protected $tindakanpelayanantersimpan = true;
  protected $successSavePemakaianBahan = true;
  protected $stokobatalkestersimpan = true;
  protected $pasienpenunjangtersimpan = true;
  public $path_view = 'ambulans.views.pemakaianAmbulanPasienRS.';

  public function actionIndex($pemakaian_id = '', $pendaftaran_id = '', $pemesanan_id = '')
  {
    $this->pageTitle = Yii::app()->name . " - Pemakaian Ambulans Pasien Rumah Sakit";
    $format = new MyFormatter();
    $modPasien = new PasienM;
    $modKunjungan = new AMInfokunjunganrjV;
    $modObatAlkesPasien = new AMObatalkesPasienT;
    $modPemakaian = new AMPemakaianambulansT;
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
      $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;

      if (!empty($pendaftaran_id)) {
        if (!empty($modPemakaian->ruangan_id)) {
          $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;
        } else {
          $instalasi = null;
        }
        $modKunjungan->pendaftaran_id = $pendaftaran_id;
        $modKunjungan->instalasi_id = $instalasi;
        //if(isset($_GET['instalasi_id'])){
        //    $modKunjungan->instalasi_id = $_GET['instalasi_id'];
        //}
        //            $modPemakaian = $this->setDataPemakaianFromPendaftaran($pendaftaran_id);
      }
    }


    if (!empty($pemakaian_id)) {
      $modPemakaian = $this->setDataPemakaianFromPemakaian($pemakaian_id);
      $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;
      $modPemakaian->paramedis1_nama = isset($modPemakaian->paramedis1_id) ? $modPemakaian->paramedis1->NamaLengkap : "";
      $modPemakaian->paramedis2_nama = isset($modPemakaian->paramedis2_id) ? $modPemakaian->paramedis2->NamaLengkap : "";
      $modPemakaian->supir_nama = isset($modPemakaian->supir_id) ? $modPemakaian->supir->NamaLengkap : "";
      $modPemakaian->pelaksana_nama = isset($modPemakaian->pelaksana_id) ? $modPemakaian->pelaksana->NamaLengkap : "";
      $modPemakaian->pendampingdokter_nama = isset($modPemakaian->dokterpendampingambulance_id) ? $modPemakaian->dokterpendamping->NamaLengkap : "";

      if (!empty($modPemakaian->ruangan_id)) {
        $instalasi = RuanganM::model()->findByPk($modPemakaian->ruangan_id)->instalasi_id;
      } else {
        $instalasi = null;
      }
      $modKunjungan->pendaftaran_id = $modPemakaian->pendaftaran_id;
      $modKunjungan->instalasi_id = $instalasi;
    }
    //        echo '===  ' . $instalasi;
    //        echo '==a=  ' . $modKunjungan->instalasi_id;
    //        exit();
    if (isset($_POST['AMPemakaianambulansT'])) {


      if (isset($_POST['tarif'])) {



        $transaction = Yii::app()->db->beginTransaction();
        try {
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
            $modPemakaian = new AMPemakaianambulansT;
            $modPemakaian->attributes = $_POST['AMPemakaianambulansT'];
            $modPemakaian->rt_rw = $_POST['AMPemakaianambulansT']['rt'] . '/' . $_POST['AMPemakaianambulansT']['rw'];
            $modPemakaian->tarifperkm = $tarif['tarifKM'][$i];
            $modPemakaian->jumlahkm = $tarif['jmlKM'][$i];
            $modPemakaian->biayatol = $tarif['biayatol'][$i];
            $modPemakaian->totaltarifambulans = $tarif['tarifAmbulans'][$i];
            $modPemakaian->daftartindakanId = $tarif['daftartindakanId'][$i];
            $modPemakaian->daftartindakan_id = $tarif['daftartindakanId'][$i];
            $modPemakaian->create_time = date('Y-m-d H:i:s');
            $modPemakaian->create_loginpemakai_id = Yii::app()->user->id;
            $modPemakaian->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modPemakaian->noidentitas = Yii::app()->user->getState('ruangan_id');
            $modPemakaian->dokterpendampingambulance_id = $_POST['AMPemakaianambulansT']['dokterpendampingambulance_id'];
            //                        $modPemakaian->alamattujuan = $tarif['alamat'][$i];
            $modPemakaian->alamattujuan = $_POST['AMPemakaianambulansT']['alamattujuan'];

            $modPemakaian->jenispelayanan_ambulans_id = $tarif['jenispelayanan_ambulans_id'][$i];
            $modPemakaian->ruteasal_ambulan = $tarif['ruteasal_ambulan'][$i];
            $modPemakaian->rutetujuan_ambulan = $tarif['rutetujuan_ambulan'][$i];
            $modPemakaian->durasipemakaian_ambulan = $tarif['durasipemakaian_ambulan'][$i];
            $modPemakaian->jenispelayanan_ambulans = $tarif['jenispelayanan_ambulans'][$i];
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


            if (isset($_POST['instalasi'])) {
              $instalasi = $_POST['instalasi'];
            } else if (isset($_POST['instalasi_id'])) {
              $instalasi = $_POST['instalasi_id'];
            }

            $format = new MyFormatter();
            $modPemakaian->tglpemakaianambulans = $format->formatDateTimeForDb($_POST['AMPemakaianambulansT']['tglpemakaianambulans']);
            $modPemakaian->tglkembaliambulans = $format->formatDateTimeForDb($_POST['AMPemakaianambulansT']['tglkembaliambulans']);

            //=== save pemakaian ambulans ===//
            if ($modPemakaian->validate()) {
              if ($modPemakaian->save()) {

                MobilambulansM::model()->updateByPk($modPemakaian->mobilambulans_id, array(
                  'isterpakai' => true,
                ));

                if (!empty($modPemakaian->pendaftaran_id)) {
                  $modPendaftaran = PendaftaranT::model()->findByPk($modPemakaian->pendaftaran_id);
                  $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                  $modPasienMasukPenunjang = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $modPemakaian); //RSSP-1456
                  $tindakanPel = $this->saveTindakanPelayanan($modPasien, $modPendaftaran, $modPemakaian, $modPasienMasukPenunjang);


                  if (!empty($modPemakaian->daftartindakanId) || !empty($modPemakaian->jenispelayanan_ambulans_id)) {
                    AMPemakaianambulansT::model()->updateByPk($modPemakaian->pemakaianambulans_id, array('tindakanpelayanan_id' => $tindakanPel->tindakanpelayanan_id, 'update_time' => date('Y-m-d H:i:s'), 'update_loginpemakai_id' => Yii::app()->user->id));
                  }
                }
                $save = true;
              }
              //                            $save = $save && $modPemakaian->save();

              if (!empty($pemesanan_id)) {
                AMPesanambulansT::model()->updateByPk($pemesanan_id, array('pemakaianambulans_id' => $modPemakaian->pemakaianambulans_id));
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

          //=== commit or rollback ===//
          //                    if($save && $this->successSavePemakaianBahan && $this->tindakanpelayanantersimpan){
          if ($save && $this->successSavePemakaianBahan && $this->tindakanpelayanantersimpan && $this->pasienpenunjangtersimpan) {

            // SMS GATEWAY
            $sms = new Sms();
            $smspasien = 1;
            foreach ($modSmsgateway as $i => $smsgateway) {
              $isiPesan = $smsgateway->templatesms;
              $attributes = $modPemakaian->getAttributes();
              foreach ($attributes as $attributes => $value) {
                $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
              }
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
            Yii::app()->user->setFlash('success', "Data Pasien Ambulans " . $modPendaftaran->pasien->nama_pasien . " Berhasil disimpan");
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

    $this->render($this->path_view . 'index', array(
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
      'is_api_gmap' => $is_api_gmap
    ));
  }

  protected function simpanObatAlkesPasien($modPendaftaran, $stokOa, $pemakaianBahan)
  {
    $modObatAlkesPasien = new AMObatalkesPasienT();
    $modObatAlkesPasien->attributes = $stokOa->attributes;
    $modObatAlkesPasien->tglpelayanan = date("Y-m-d H:i:s");
    $modObatAlkesPasien->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
    $modObatAlkesPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modObatAlkesPasien->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modObatAlkesPasien->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
    $modObatAlkesPasien->carabayar_id = $modPendaftaran->carabayar_id;
    $modObatAlkesPasien->penjamin_id = $modPendaftaran->penjamin_id;
    $modObatAlkesPasien->pegawai_id = $modPendaftaran->pegawai_id;
    $modObatAlkesPasien->shift_id = Yii::app()->user->getState('shift_id');
    $modObatAlkesPasien->pasien_id = $modPendaftaran->pasien_id;
    $modObatAlkesPasien->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
    $modObatAlkesPasien->tglpelayanan = date('Y-m-d H:i:s');
    $modObatAlkesPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modObatAlkesPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modObatAlkesPasien->create_time = date('Y-m-d H:i:s');
    $modObatAlkesPasien->qty_oa = $stokOa->qtystok_terpakai;
    $modObatAlkesPasien->qty_stok = $stokOa->qtystok;
    $modObatAlkesPasien->harganetto_oa = $stokOa->HPP;
    $modObatAlkesPasien->hargasatuan_oa = $stokOa->getHargaJualSatuan($modObatAlkesPasien->penjamin_id);
    $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->hargasatuan_oa * $modObatAlkesPasien->qty_oa;
    $modObatAlkesPasien->oa = Params::OBATALKESPASIEN_BMHP;
    foreach ($pemakaianBahan as $i => $postDetail) {
      if ($stokOa->obatalkes_id == $postDetail['obatalkes_id']) {
        $modObatAlkesPasien->sumberdana_id = $postDetail['sumberdana_id'];
        $modObatAlkesPasien->satuankecil_id = $postDetail['satuankecil_id'];
        $modObatAlkesPasien->qty_stok = $postDetail['qty_stok'];
        $modObatAlkesPasien->iurbiaya = $postDetail['subtotal'];
      }
    }
    if ($modObatAlkesPasien->save()) {
      $this->successSavePemakaianBahan &= true;
    } else {
      $this->successSavePemakaianBahan &= false;
    }
    return $modObatAlkesPasien;
  }

  /**
   * simpan StokobatalkesT Jumlah Out
   * @param type $stokobatalkesasal_id
   * @param type $modObatAlkesPasien
   * @return \StokobatalkesT
   */
  protected function simpanStokObatAlkesOut($stokobatalkesasal_id, $modObatAlkesPasien)
  {
    $format = new MyFormatter;
    $modStokOa = StokobatalkesT::model()->findByPk($stokobatalkesasal_id);
    $modStokOaNew = new StokobatalkesT;
    $modStokOaNew->attributes = $modStokOa->attributes; //duplicate
    $modStokOaNew->unsetIdTransaksi(); //new / autoincrement pk
    $modStokOaNew->qtystok_in = 0;
    $modStokOaNew->qtystok_out = $modObatAlkesPasien->qty_oa;
    $modStokOaNew->obatalkespasien_id = $modObatAlkesPasien->obatalkespasien_id;
    $modStokOaNew->stokobatalkesasal_id = $stokobatalkesasal_id;
    $modStokOaNew->tglstok_in = null;
    $modStokOaNew->tglstok_out = date('Y-m-d H:i:s');
    $modStokOaNew->create_time = date('Y-m-d H:i:s');
    $modStokOaNew->update_time = date('Y-m-d H:i:s');
    $modStokOaNew->create_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->update_loginpemakai_id = Yii::app()->user->id;
    $modStokOaNew->create_ruangan = Yii::app()->user->ruangan_id;

    if ($modStokOaNew->validateStok()) {
      $modStokOaNew->save();
      $modStokOaNew->setStokOaAktifBerdasarkanStok();
    } else {
      $this->stokobatalkestersimpan &= false;
    }
    return $modStokOaNew;
  }

  /**
   * Mengurai data kunjungan berdasarkan:
   * - instalasi_id
   * - pendaftaran_id
   * - pasienadmisi_id
   * - no_pendaftaran
   * - no_rekam_medik
   * @throws CHttpException
   */
  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();
      $is_set = false;
      $sudah_set = false;

      set_instalasi:
      $criteria = new CDbCriteria();


      if (!empty($pendaftaran_id)) {
        $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
      }
      if (!empty($pasienadmisi_id)) {
        $criteria->addCondition('pasienadmisi_id = ' . $pasienadmisi_id);
      }

      if ($is_set) {
        $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        if (!empty($pendaftaran)) {
          if (!empty($pendaftaran->pasienadmisi_id)) {
            $instalasi_id = Params::INSTALASI_ID_RI;
          } else {
            $instalasi_id = $pendaftaran->instalasi_id;
          }
        }

        $sudah_set  = true;
      }

      if (!empty($instalasi_id)) {
        $criteria->addCondition('instalasi_id = ' . $instalasi_id);
      }
      $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
      $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));
      //            $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      //            if(!empty($modPendaftaran)){
      //                $instalasi_id = $modPendaftaran->instalasi_id;
      //            }

      $cekPasienPulang = false;

      if ($instalasi_id == Params::INSTALASI_ID_RJ) {
        $model = AMInfokunjunganrjV::model()->find($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
        $model = AMInfoKunjunganRDV::model()->find($criteria);

        if (isset($model)) {
          $cekPasienPulang = true;
        }
        if ($cekPasienPulang == false) {
          $model = AMPasienpulangrddanriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        }
      } else if ($instalasi_id == Params::INSTALASI_ID_RI) {
        $model = AMPasienrawatinapV::model()->find($criteria);

        if (isset($model)) {
          $cekPasienPulang = true;
        }
        if ($cekPasienPulang == false) {
          $model = AMPasienpulangrddanriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        }
      } else if ($instalasi_id == Params::INSTALASI_ID_ICU) {
        $model = AMPasienrawatinapV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      } else if ($instalasi_id == Params::INSTALASI_ID_PERSALINAN) {
        $model = InfokunjunganpersalinanV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      } else if ($instalasi_id == Params::INSTALASI_ID_HD) {
        $model = InfokunjunganhdV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      } else if ($instalasi_id == Params::INSTALASI_ID_JZ) {
        $model = PasienmasukpenunjangV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      } else if (!$is_set) {
        $is_set = true;
        goto set_instalasi;
      }
      //            else{
      //                $model = AMPasienpulangrddanriV::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
      //            } RSPMC-257



      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_pendaftaran
   * - no_rekam_medik
   * - nama_pasien
   */
  public function actionAutocompleteKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $instalasi_id = isset($_GET['instalasi_id']) ? $_GET['instalasi_id'] : null;
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->limit = 5;
      if ($instalasi_id == Params::INSTALASI_ID_RJ) {
        $criteria->addCondition("DATE(tgl_pendaftaran) = '" . date("Y-m-d") . "'");
        $models = AMInfokunjunganrjV::model()->findAll($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
        $criteria->addCondition("DATE(tgl_pendaftaran) = '" . date("Y-m-d") . "'");
        $models = AMInfoKunjunganRDV::model()->findAll($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RI) {
        $criteria->addBetweenCondition("DATE(tglmasukkamar)", date("Y-m-d", strtotime("-31 days")), date("Y-m-d"));
        $models = AMPasienrawatinapV::model()->findAll($criteria);
      }
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
        $returnVal[$i]['value'] = $model->no_pendaftaran;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  protected function setDataPemakaianFromPendaftaran($pendaftaran_id)
  {
    $format = new MyFormatter();
    $modPemakaian = new AMPemakaianambulansT;
    $modPemakaian->tglpemakaianambulans = date('Y-m-d H:i:s');
    $modPendaftaran = PendaftaranT::model()->with('pasien')->findByPk($pendaftaran_id);
    $modPemakaian->pasien_id = (isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien_id : "");
    $modPemakaian->namapasien = (isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien->nama_pasien : "");
    $modPemakaian->nomobile = (isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien->no_mobile_pasien : "");
    $modPemakaian->notelepon = (isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien->no_telepon_pasien : "");
    $modPemakaian->norekammedis = (isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien->no_rekam_medik : "");
    $modPemakaian->noidentitas = (isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien->no_identitas_pasien : "");
    $modPemakaian->tempattujuan = '';
    $modPemakaian->alamattujuan = (isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien->alamat_pasien : "");
    $modPemakaian->kelurahan_nama = (isset($modPendaftaran->pasien->kelurahan->kelurahan_nama) ? $modPendaftaran->pasien->kelurahan->kelurahan_nama : "");
    $modPemakaian->rt_rw = (isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien->rt : "") . '/' . (isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien->rw : "");
    $modPemakaian->rt = (isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien->rt : "");
    $modPemakaian->rw = (isset($modPendaftaran->pasien_id) ? $modPendaftaran->pasien->rw : "");
    $modPemakaian->tglpemakaianambulans = $format->formatDateTimeForDb($modPemakaian->tglpemakaianambulans);
    $modPemakaian->pesanambulans_t = null;
    $modPemakaian->pendaftaran_id = $pendaftaran_id;
    $modPemakaian->ruangan_id = (isset($modPendaftaran->ruangan_id) ? $modPendaftaran->ruangan_id : "");

    return $modPemakaian;
  }

  protected function setDataPemakaianFromPemesanan($pemesanan_id)
  {
    $format = new MyFormatter();
    $modPemakaian = new AMPemakaianambulansT;
    $modPemesanan = AMPesanambulansT::model()->findByPk($pemesanan_id);
    $modPemakaian->tglpemakaianambulans = date('Y-m-d H:i:s');
    $modPasien = PasienM::model()->findByPk($modPemesanan->pasien_id);
    if (isset($modPasien)) {
      $noidentitas = $modPasien->no_identitas_pasien;
    } else {
      $noidentitas = null;
    }
    $modPemakaian->pasien_id = $modPemesanan->pasien_id;
    $modPemakaian->namapasien = $modPemesanan->namapasien;
    $modPemakaian->nomobile = $modPemesanan->nomobile;
    $modPemakaian->notelepon = $modPemesanan->notelepon;
    $modPemakaian->norekammedis = $modPemesanan->norekammedis;
    $modPemakaian->noidentitas = $noidentitas;
    $modPemakaian->tempattujuan = $modPemesanan->tempattujuan;
    $modPemakaian->alamattujuan = $modPemesanan->alamattujuan;
    $modPemakaian->kelurahan_nama = $modPemesanan->kelurahan_nama;
    $modPemakaian->rt_rw = $modPemesanan->rt_rw;

    $rt_rw = explode("/", $modPemakaian->rt_rw);

    $modPemakaian->rt = empty($rt_rw[0]) ? "" : $rt_rw[0];
    $modPemakaian->rw = empty($rt_rw[1]) ? "" : $rt_rw[1];
    $modPemakaian->tglpemakaianambulans = (isset($modPemesanan->tglpemakaianambulans) ? $modPemesanan->tglpemakaianambulans : $format->formatDateTimeForUser($modPemakaian->tglpemakaianambulans));
    $modPemakaian->pesanambulans_t = $pemesanan_id;
    $modPemakaian->pendaftaran_id = $modPemesanan->pendaftaran_id;
    $modPemakaian->ruangan_id = $modPemesanan->ruangan_id;

    return $modPemakaian;
  }

  protected function setDataPemakaianFromPemakaian($pemakaian_id)
  {
    $format = new MyFormatter();
    $modPemakaian = AMPemakaianambulansT::model()->findByPk($pemakaian_id);
    $modPemakaian->tglpemakaianambulans = date('Y-m-d H:i:s');
    $modPasien = PasienM::model()->findByPk($modPemakaian->pasien_id);
    if (isset($modPasien)) {
      $noidentitas = $modPasien->no_identitas_pasien;
    } else {
      $noidentitas = $modPemakaian->noidentitas;
    }
    $modPemakaian->pasien_id = $modPemakaian->pasien_id;
    $modPemakaian->namapasien = $modPemakaian->namapasien;
    $modPemakaian->nomobile = $modPemakaian->nomobile;
    $modPemakaian->notelepon = $modPemakaian->notelepon;
    $modPemakaian->norekammedis = $modPemakaian->norekammedis;
    $modPemakaian->noidentitas = $noidentitas;
    $modPemakaian->tempattujuan = $modPemakaian->tempattujuan;
    $modPemakaian->alamattujuan = $modPemakaian->alamattujuan;
    $modPemakaian->kelurahan_nama = $modPemakaian->kelurahan_nama;
    $modPemakaian->rt_rw = $modPemakaian->rt_rw;
    $modPemakaian->rt = substr($modPemakaian->rt_rw, 0, 2);
    $modPemakaian->rw = substr($modPemakaian->rt_rw, 2, 2);
    $modPemakaian->tglpemakaianambulans = (isset($modPemakaian->tglpemakaianambulans) ? $modPemakaian->tglpemakaianambulans : $format->formatDateTimeForUser($modPemakaian->tglpemakaianambulans));
    $modPemakaian->pendaftaran_id = $modPemakaian->pendaftaran_id;
    $modPemakaian->ruangan_id = $modPemakaian->ruangan_id;
    $modPemakaian->supir_nama = isset($modPemakaian->supir) ? $modPemakaian->supir->nama_pegawai : "";
    $modPemakaian->paramedis1_nama = isset($modPemakaian->paramedis1) ? $modPemakaian->paramedis1->nama_pegawai : "";
    $modPemakaian->paramedis2_nama = isset($modPemakaian->paramedis2) ? $modPemakaian->paramedis2->nama_pegawai : "";
    $modPemakaian->pelaksana_nama = isset($modPemakaian->pelaksana) ? $modPemakaian->pelaksana->nama_pegawai : "";
    $modPemakaian->mobilambulans_nama = isset($modPemakaian->mobil) ? $modPemakaian->mobil->jeniskendaraan : "";

    return $modPemakaian;
  }

  protected function saveTindakanPelayanan($modPasien, $modPendaftaran, $modPemakaian, $modPasienMasukPenunjang)
  {

    $modTindakan = new TindakanpelayananT;

    if (!empty($modPemakaian->daftartindakanId)) {
      $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
      $modTindakan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
      $modTindakan->pasien_id = $modPasien->pasien_id;

      $modTindakan->daftartindakan_id = $modPemakaian->daftartindakanId; //RSSP-1456
      $modTindakan->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id; //RSSP-1456
      $modTindakan->carabayar_id = $modPendaftaran->carabayar_id;
      $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $modTindakan->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
      $modTindakan->instalasi_id =  Yii::app()->user->getState('instalasi_id');
      $modTindakan->ruangan_id =  Yii::app()->user->getState('ruangan_id');
      $modTindakan->penjamin_id = $modPendaftaran->penjamin_id;
      $modTindakan->tgl_tindakan = $modPasienMasukPenunjang->tglmasukpenunjang;

      $modTindakan->tarif_tindakan = $modPemakaian->totaltarifambulans;
      $modTindakan->satuantindakan = 'Km';
      $modTindakan->qty_tindakan = 1;
      $modTindakan->tarif_satuan = $modPemakaian->totaltarifambulans;

      $modTindakan->cyto_tindakan = 0;
      $modTindakan->tarifcyto_tindakan = 0;
      $modTindakan->discount_tindakan = 0;
      $modTindakan->subsidiasuransi_tindakan = 0;
      $modTindakan->subsidipemerintah_tindakan = 0;
      $modTindakan->subsisidirumahsakit_tindakan = 0;
      $modTindakan->iurbiaya_tindakan = 0;
      $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
      $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modTindakan->create_time = date('Y-m-d H:i:s');

      $modTindakan->supir_id = $modPemakaian->supir_id;
      $modTindakan->perawat_id = $modPemakaian->paramedis1_id;
      $modTindakan->perawat2_id = $modPemakaian->paramedis2_id;

      if ($modTindakan->save()) {
        //update tindakankomponen_t karena ada triger tapi dicek dulu karena triger kadang dimatikan
        $modTindakankomponen = TindakankomponenT::model()->findByAttributes(array('tindakanpelayanan_id' => $modTindakan->tindakanpelayanan_id));

        // var_dump($modTindakankomponen); die;

        if (!empty($modTindakankomponen)) {
          TindakankomponenT::model()->updateByPk($modTindakankomponen->tindakankomponen_id, array('tarif_kompsatuan' => $modPemakaian->totaltarifambulans, 'tarif_tindakankomp' => $modPemakaian->totaltarifambulans, 'iurbiayakomp' => $modPemakaian->totaltarifambulans));
        }

        if (!empty($modPendaftaran->pasienadmisi_id)) {
          $updatePasienAdmisi = PasienadmisiT::model()->updateByPk($modPendaftaran->pasienadmisi_id, array('pembayaranpelayanan_id' => null));
        } else {
          $updatePendaftaran = PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('pembayaranpelayanan_id' => null));
        }

        $this->tindakanpelayanantersimpan &= true;
      } else {
        $this->tindakanpelayanantersimpan = false;
        //                    Yii::app()->user->setFlash('info','<pre>'.print_r($modTindakan->getErrors(),1).'</pre>');
      }
    }


    return $modTindakan;
  }

  public function actionDynamicRuangan()
  {
    $instalasi_id = (isset($_POST['instalasi']) ? $_POST['instalasi'] : null);
    $data = RuanganM::model()->findAll(
      'instalasi_id=:instalasi_id AND ruangan_aktif = TRUE order by ruangan_nama',
      array(':instalasi_id' => $instalasi_id)
    );

    $data = CHtml::listData($data, 'ruangan_id', 'ruangan_nama');

    if (empty($data)) {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Ruangan --'), true);
    } else {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Ruangan --'), true);
      foreach ($data as $value => $name) {
        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
    }
  }

  public function actionDynamicRuanganRs()
  {
    $instalasi_id = (isset($_POST['instalasi_pemakaianambulance']) ? $_POST['instalasi_pemakaianambulance'] : null);
    $data = RuanganM::model()->findAll(
      'instalasi_id=:instalasi_id AND ruangan_aktif = TRUE order by ruangan_nama',
      array(':instalasi_id' => $instalasi_id)
    );

    $data = CHtml::listData($data, 'ruangan_id', 'ruangan_nama');

    if (empty($data)) {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Ruangan --'), true);
    } else {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Ruangan --'), true);
      foreach ($data as $value => $name) {
        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
    }
  }
  /**
   * set LKTindakanpelayananT yang sudah ada di database
   * @params pasienmasukpenunjang_id
   */
  public function actionSetRiwayatObatAlkesPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? ((!empty($_POST['pendaftaran_id'])) ? $_POST['pendaftaran_id'] : null) : null);
      $loadOaPasiens = AMObatalkesPasienT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));
      if (count((array)$loadOaPasiens) > 0) {
        foreach ($loadOaPasiens as $i => $modObatAlkesPasien) {
          $modObatAlkesPasien->tglpelayanan = $format->formatDateTimeForUser($modObatAlkesPasien->tglpelayanan);
          $modObatAlkesPasien->hargajual_oa = $format->formatNumberForUser($modObatAlkesPasien->hargajual_oa);
          $modObatAlkesPasien->qty_oa = $format->formatNumberForUser($modObatAlkesPasien->qty_oa);
          $modObatAlkesPasien->iurbiaya = $format->formatNumberForUser($modObatAlkesPasien->iurbiaya);
          $rows .= $this->renderPartial($this->path_view . "_rowRiwayatObatAlkesPasien", array('modObatAlkesPasien' => $modObatAlkesPasien), true);
        }
      }
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }

  /**
   * set AMTindakanpelayananT yang sudah ada di database
   * @params pendaftaran_id
   */
  public function actionSetTindakanPelayanan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $rows = "";
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? ((!empty($_POST['pendaftaran_id'])) ? $_POST['pendaftaran_id'] : null) : null);
      $modTindakans = AMTindakanpelayananT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')), 'karcis_id IS NULL');
      if (count((array)$modTindakans) > 0) {
        foreach ($modTindakans as $i => $modTindakan) {
          $modTindakan->kepropinsi_nama = TarifAmbulansM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->kepropinsi_nama;
          $modTindakan->kekabupaten_nama = TarifAmbulansM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->kekabupaten_nama;
          $modTindakan->kekecamatan_nama = TarifAmbulansM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->kekecamatan_nama;
          $modTindakan->kekelurahan_nama = TarifAmbulansM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->kekelurahan_nama;
          $modTindakan->jmlkilometer = TarifAmbulansM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->jmlkilometer;
          $modTindakan->tarifperkm = TarifAmbulansM::model()->findByAttributes(array('daftartindakan_id' => $modTindakan->daftartindakan_id))->tarifperkm;
          $modTindakan->tarif_pelayanan = $modTindakan->jmlkilometer * $modTindakan->tarifperkm;
          $rows .= $this->renderPartial($this->path_view . "_rowTindakanPelayanan", array('i' => 0, 'modTindakan' => $modTindakan), true);
        }
      }
      echo CJSON::encode(array(
        'rows' => $rows
      ));
    }
    Yii::app()->end();
  }
  /**
   * @param type $pemakaianambulans_id
   */
  public function actionPrintStatusAmbulans($pemakaianambulans_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPemakaian = AMPemakaianambulansT::model()->findByPk($pemakaianambulans_id);
    $modPendaftaran = AMPendaftaranT::model()->findByPk($modPemakaian->pendaftaran_id);
    $modPasien = AMPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modTindakans = array();
    $criteria1 = new CdbCriteria();
    $criteria1->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    $criteria1->order = "pendaftaran_id DESC, pemakaianambulans_id DESC";
    $loadPemakaianAmbulans = AMPemakaianambulansT::model()->find($criteria1);
    if (isset($loadPemakaianAmbulans)) {
      $modPemakaian = $loadPemakaianAmbulans;
      $modTindakans = TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));
      $criteria_tot = new CdbCriteria();
      $criteria_tot->addCondition("karcis_id IS NULL");
      $criteria_tot->addCondition("pendaftaran_id = " . $modPendaftaran->pendaftaran_id);
      $criteria_tot->addCondition("ruangan_id = " . Yii::app()->user->getState('ruangan_id'));
      $daftartindakan = TindakanpelayananT::model()->findAll($criteria_tot);
    }

    $judul_print = 'Pemakaian Ambulance Pasien';
    $this->render($this->path_view . 'printStatusAmbulan', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPemakaian' => $modPemakaian,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modTindakans' => $modTindakans,
      'daftartindakan' => $daftartindakan,
    ));
  }

  /*
         * untuk print pemakaian bahp
         */
  public function actionPrintPemakaianBmhp($pemakaian_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPemakaian = AMPemakaianambulansT::model()->findByPk($pemakaian_id);
    $modPendaftaran = AMPendaftaranT::model()->findByPk($modPemakaian->pendaftaran_id);
    $modObatAlkesPasien = AMObatalkesPasienT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));
    $ruangan_id  = AMObatalkesPasienT::model()->find('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id . ' AND ruangan_id = ' . Yii::app()->user->getState('ruangan_id') . '');
    if (!empty($ruangan_id)) {
      $ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
    } else {
      $ruangan = RuanganM::model()->findByPk($modPendaftaran->ruangan_id);
    }
    $judul_print = 'Pemakaian BAHP ' . $ruangan->ruangan_nama;
    $this->render($this->path_view . 'printPemakaianBmhp', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPemakaian' => $modPemakaian,
      'modPendaftaran' => $modPendaftaran,
      'modObatAlkesPasien' => $modObatAlkesPasien,
    ));
  }


  public function actionAutocompleteNamaSupir()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $nama_supir = isset($_GET['supir_nama']) ? $_GET['supir_nama'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_supir), true);
      $criteria->compare('jabatan_id', Params::JABATAN_ID_DRIVER);
      $criteria->addCondition('ruangan_id=' . Params::RUANGAN_ID_AMBULANCE);
      $criteria->limit = 5;

      $models = SupirambulansV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->nama_pegawai;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }


  public function actionAutocompleteParamedis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $nama_paramedis = isset($_GET['paramedis_nama']) ? $_GET['paramedis_nama'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_paramedis), true);
      $criteria->limit = 5;
      $models = ParamedisV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->nama_pegawai;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompleteDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $nama_paramedis = isset($_GET['paramedis_nama']) ? $_GET['paramedis_nama'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_paramedis), true);
      $criteria->limit = 5;
      $models = DokterV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->nama_pegawai;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }


  public function actionAutocompleteKendaraan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $mobilambulans_kode = isset($_GET['nopolisi']) ? $_GET['nopolisi'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nopolisi)', strtolower($mobilambulans_kode), true);
      $criteria->limit = 5;
      $models = MobilambulansM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nopolisi;
        $returnVal[$i]['value'] = $model->mobilambulans_kode;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionSetFormPemakaianBahan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $obatalkes_id = (isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null);
      $daftartindakan_id = (isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : "");
      $jumlah = isset($_POST['jumlah']) ? $_POST['jumlah'] : 1;
      $ruangan_id = Yii::app()->user->getState('ruangna_id');
      $form = "";
      $pesan = "";
      $format = new MyFormatter();
      $modObatAlkesPasien = new AMObatalkesPasienT;
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modStokOAs = StokobatalkesT::getStokObatAlkesAktif($obatalkes_id, $jumlah, $ruangan_id);
      $modDaftartindakan = DaftartindakanM::model()->findByPk($daftartindakan_id);
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $persenjual = $this->persenJualRuangan();
      if (count((array)$modStokOAs) > 0) {
        foreach ($modStokOAs as $i => $stok) {
          $modObatAlkesPasien->sumberdana_id = (isset($stok->penerimaandetail->sumberdana_id) ? $stok->penerimaandetail->sumberdana_id : $stok->obatalkes->sumberdana_id);
          $modObatAlkesPasien->obatalkes_id = $stok->obatalkes_id;
          $modObatAlkesPasien->stokobatalkes_id = $stok->stokobatalkes_id;
          $modObatAlkesPasien->obatalkes_nama = $stok->obatalkes->obatalkes_nama;
          $modObatAlkesPasien->qty_oa = $stok->qtystok_terpakai;
          $modObatAlkesPasien->harganetto_oa = $stok->HPP;
          $modObatAlkesPasien->penjamin_id = isset($modPendaftaran->penjamin_id) ? $modPendaftaran->penjamin_id : null;
          $modObatAlkesPasien->hargasatuan_oa = $stok->getHargaJualSatuan($modObatAlkesPasien->penjamin_id);
          $modObatAlkesPasien->qty_stok = isset($stok->qtystok) ? $stok->qtystok : 0;
          $modObatAlkesPasien->hargajual_oa = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
          $modObatAlkesPasien->stokobatalkes_id = $stok->stokobatalkes_id;
          $modObatAlkesPasien->hargajual = floor(($persenjual + 100) / 100 * $modObatAlkesPasien->hargajual);
          $modObatAlkesPasien->biayaservice = 0;
          $modObatAlkesPasien->biayakonseling = 0;
          $modObatAlkesPasien->jasadokterresep = 0;
          $modObatAlkesPasien->biayakemasan = 0;
          $modObatAlkesPasien->biayaadministrasi = 0;
          $modObatAlkesPasien->tarifcyto = 0;
          $modObatAlkesPasien->discount = 0;
          $modObatAlkesPasien->subsidiasuransi = 0;
          $modObatAlkesPasien->subsidipemerintah = 0;
          $modObatAlkesPasien->subsidirs = 0;
          $modObatAlkesPasien->iurbiaya = $modObatAlkesPasien->qty_oa * $modObatAlkesPasien->hargasatuan_oa;
          $modObatAlkesPasien->satuankecil_id = $stok->satuankecil_id;
          $modObatAlkesPasien->satuankecil_nama = $stok->satuankecil->satuankecil_nama;

          $form .= $this->renderPartial($this->path_view . '_rowObatAlkesPasien', array(
            'modObatAlkesPasien' => $modObatAlkesPasien,
            'modPendaftaran' => $modPendaftaran
          ), true);
        }
      } else {
        $pesan = "Stok tidak mencukupi!";
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  public function actionSetSatuanObat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $obatalkes_id = isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null;
      $form = "";
      $pesan = "";
      $satuankecil_nama = "";
      $satuanterkecil_nama = "";
      $format = new MyFormatter();
      $modObatAlkes = ObatalkesM::model()->findByPk($obatalkes_id);

      if (!empty($modObatAlkes)) {
        $satuankecil_nama = isset($modObatAlkes->satuankecil_id) ? $modObatAlkes->satuankecil->satuankecil_nama : null;
        $satuanterkecil_nama = isset($modObatAlkes->satuankecil_id) ? $modObatAlkes->satuankecil->satuankecil_nama : null;
      } else {
        $pesan = "Obat tidak mencukupi!";
      }

      echo CJSON::encode(array(
        'form' => $form, 'pesan' => $pesan,
        'satuankecil' => $satuankecil_nama,
        'satuanterkecil' => $satuanterkecil_nama
      ));
      Yii::app()->end();
    }
  }

  protected function persenJualRuangan()
  {
    switch (Yii::app()->user->getState('instalasi_id')) {
      case Params::INSTALASI_ID_RI:
        $persen = Yii::app()->user->getState('ri_persjual');
        break;
      case Params::INSTALASI_ID_RJ:
        $persen = Yii::app()->user->getState('rj_persjual');
        break;
      case Params::INSTALASI_ID_RD:
        $persen = Yii::app()->user->getState('rd_persjual');
        break;
      default:
        $persen = 0;
        break;
    }

    return $persen;
  }

  public function actionAutocompleteObatAlkes()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $obatalkes_nama = isset($_GET['term']) ? $_GET['term'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(obatalkes_nama)', strtolower($obatalkes_nama), true);
      $criteria->limit = 5;
      $models = AMObatAlkesM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->obatalkes_kode . " - " . $model->obatalkes_nama;
        $returnVal[$i]['value'] = $model->obatalkes_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionSetTarifAmbulans()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $komponenunit_id = isset($_POST['komponenunit_id']) ? $_POST['komponenunit_id'] : null;
      $modKonfigTarifAmbulas = array();
      if (!empty($komponenunit_id)) {
        $modKonfigTarifAmbulas = KonfigtarifambulasK::model()->findByAttributes(array('komponenunit_id' => $komponenunit_id));
      }

      $pesan = "";
      $harga_bbm = 0;
      $daftartindakan_id = null;
      if (!empty($modKonfigTarifAmbulas)) {
        $modKonfigTarifAmbulas->attributes = $modKonfigTarifAmbulas;
        $harga_bbm = KonfigsystemK::model()->findByPk(1)->harga_bbm;
        if ($harga_bbm == null) {
          $harga_bbm = 0;
        }
        $daftartindakan_id = null;
        $daftartindakan = DaftartindakanM::model()->findByAttributes(array('komponenunit_id' => $modKonfigTarifAmbulas->komponenunit_id), array(
          'order' => 'daftartindakan_id asc'
        )); //ambil daftar tindakan RSSP-1456
        if (!empty($daftartindakan)) {
          $daftartindakan_id = $daftartindakan->daftartindakan_id;
        }
      } else {
        $pesan = "Komponen Tarif belum ada!";
      }

      echo CJSON::encode(array(
        'pesan' => $pesan,
        'modKonfigTarifAmbulas' => $modKonfigTarifAmbulas,
        'harga_bbm' => $harga_bbm,
        'daftartindakan_id' => $daftartindakan_id,
      ));
      Yii::app()->end();
    }
  }

  /**
   * Fungsi untuk menyimpan data ke model LBPasienmasukpenunjangT
   * @param type $modPendaftaran
   * @param type $modPasien
   * @return LBPasienmasukpenunjangT 
   */
  public function simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $modPemakaian)
  { //RSSP-1456
    $modPasienMasukPenunjang = new $modPasienMasukPenunjang;
    if ($modPendaftaran->pasienadmisi_id) {
      $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
      $modPasienMasukPenunjang->attributes = $modPasienAdmisi->attributes;
      $modPasienMasukPenunjang->ruanganasal_id = $modPasienAdmisi->ruangan_id;
    } else {
      $modPasienMasukPenunjang->attributes = $modPendaftaran->attributes;
      $modPasienMasukPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;
    }

    $modPasienMasukPenunjang->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
    $modPasienMasukPenunjang->statusperiksa = $modPendaftaran->statusperiksa;
    $modPasienMasukPenunjang->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modPasienMasukPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $instalasi_id = $modPasienMasukPenunjang->ruangan->instalasi_id;
    $kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
    $modPasienMasukPenunjang->tglmasukpenunjang = $modPemakaian->tglpemakaianambulans;
    $modPasienMasukPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($kode_instalasi, date('Y-m-d', strtotime($modPasienMasukPenunjang->tglmasukpenunjang)));
    $modPasienMasukPenunjang->no_urutperiksa = MyGenerator::noAntrianPenunjang($modPasienMasukPenunjang->ruangan_id);
    $modPasienMasukPenunjang->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modPasienMasukPenunjang->create_loginpemakai_id = Yii::app()->user->id;
    $modPasienMasukPenunjang->create_time = date('Y-m-d H:i:s');

    $modPasienMasukPenunjang->validate();
    echo CHtml::errorSummary($modPasienMasukPenunjang);
    if ($modPasienMasukPenunjang->validate()) {
      $modPasienMasukPenunjang->save();
      $this->pasienpenunjangtersimpan &= true;
    } else {
      $this->pasienpenunjangtersimpan &= false;
    }

    return $modPasienMasukPenunjang;
  }
}
