<?php
Yii::import('bedahSentral.models.BSMasukPenunjangV');

class InformasiPasienKamarOperasiController extends MyAuthController
{
  public $path_view_pengambilanObat = 'pengambilanObatOK/';
  public $path_view_informasiPasienOperasi = 'farmasiApotek.views.informasiPasienKamarOperasi.informasiPasienOperasi.';
  public $gagalsimpan = ['status' => 1, 'pesan' => ''];
  public $penjualantersimpan = false;
  public $obatalkespasientersimpan = true; //looping
  public $stokobatalkestersimpan = true; //looping

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Operasi";
    $modPasienMasukPenunjang = new BSMasukPenunjangV('searchPasienOperasi');
    $format = new MyFormatter();
    $modPasienMasukPenunjang->tgl_awal = date('Y-m-d');
    $modPasienMasukPenunjang->tgl_akhir = date('Y-m-d');
    $modPasienMasukPenunjang->ruangan_id = Params::RUANGAN_ID_BEDAH;

    if(isset($_GET['BSMasukPenunjangV'])) {
      $modPasienMasukPenunjang->attributes = $_GET['BSMasukPenunjangV'];
      $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForDb($_GET['BSMasukPenunjangV']['tgl_awal']);
      $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForDb($_GET['BSMasukPenunjangV']['tgl_akhir']);
      $modPasienMasukPenunjang->nosep = $_GET['BSMasukPenunjangV']['nosep'];
      if(Yii::app()->request->isAjaxRequest) {
        if(isset($_GET['ajax']) && $_GET['ajax'] == 'tabelPasienOperasi') {
          $this->renderPartial('_table', ['modPasienMasukPenunjang' => $modPasienMasukPenunjang]);
          Yii::app()->end();
        }
      }
    }
    $this->render('index', [
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang
    ]);
  }

  function actionPengambilanObatOK($pendaftaran_id, $pasienmasukpenunjang_id, $resepturok_id = null) {
    $format = new MyFormatter();
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = $modPendaftaran->pasien;
    
    // cek apakah sudah ada reseptur yang di input tapi belum dijual
    $modReseptur = ResepturokT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'penjualanresep_id' => null]);

    // jika query diatas tidak ketemu maka buat reseptur baru
    if(empty($modReseptur)) {
      $modReseptur = new ResepturokT();
      // default data load awal
      $modReseptur->tglresep_ok = $format->formatDateTimeForUser( date('Y-m-d H:i:s'));
      $modReseptur->petugasfarmasi_id = Yii::app()->user->getState('pegawai_id');
      $modReseptur->nama_pasien = $modPasien->nama_pasien;
      $modReseptur->noresep_ok = MyGenerator::noResepOK();
    }

    $riwayatResep = [];
    // jika reseptur ditemukan maka ambil data detail untuk riwayat resep
    if(!empty($modReseptur)) {
      $riwayatResep = ResepturokdetT::model()->findAllByAttributes(['resepturok_id' => $modReseptur->resepturok_id]);
      $modReseptur->nama_pasien = $modPasien->nama_pasien;
    }

    $save = false;
    if(isset($_POST['ResepturokT']) && isset($_POST['ResepturokdetT'])) {
      try {
        $transaction = Yii::app()->db->beginTransaction();
        
        $modReseptur->attributes = $_POST['ResepturokT'];
        $modReseptur->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
        $modReseptur->pendaftaran_id = $pendaftaran_id;
        $modReseptur->tglresep_ok = $format->formatDateTimeForDb($modReseptur->tglresep_ok);
        if(!empty($modReseptur->resepturok_id)) {
          // hanya insert ke resepturokdet_t
          if(count($_POST['ResepturokdetT']) > 0) {
            foreach ($_POST['ResepturokdetT'] as $i => $val) {
               $modDetailResep = new ResepturokdetT();
               $modDetailResep->attributes = $val;
               $modDetailResep->resepturok_id = $modReseptur->resepturok_id;

               if($modDetailResep->save()) {
                  $save = true;
               } else {
                  $save = false;
               }
            }
          }
        } else {
          // keadaan jika resptur masih empty
          if($modReseptur->validate()) {
            if($modReseptur->save()) {
              if(count($_POST['ResepturokdetT']) > 0) {
                foreach ($_POST['ResepturokdetT'] as $i => $val) {
                   $modDetailResep = new ResepturokdetT();
                   $modDetailResep->attributes = $val;
                   $modDetailResep->resepturok_id = $modReseptur->resepturok_id;
  
                   if($modDetailResep->save()) {
                      $save = true;
                   } else {
                      $save = false;
                   }
                }
              }
            } else {
              Yii::app()->user->setFlash('error', 'Data gagal disimpan ! [save]');
            }
          } else {
            Yii::app()->user->setFlash('error', 'Data gagal disimpan ! [validate]');
          }
        }

        if($save) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data berhasil disimpan !');
          $this->redirect(['pengambilanObatOK', 'pendaftaran_id' => $modReseptur->pendaftaran_id, 'pasienmasukpenunjang_id' => $modReseptur->pasienmasukpenunjang_id]);
        } else {
          $transaction->rollback();
          $this->gagalsimpan['status'] = 0;
          $this->gagalsimpan['status'] = 'Data gagal simpan [1]';
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $this->gagalsimpan['status'] = 0;
        $this->gagalsimpan['pesan'] = 'Error : ' . $exc->getMessage();

      }
    }

    $modRiwayatPenjualanResep = new FAPenjualanResepT('searchRiwayatPenjualan');
    $modRiwayatPenjualanResep->pendaftaran_id = $pendaftaran_id;
    $modRiwayatPenjualanResep->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if(Yii::app()->request->isAjaxRequest) {
      if(isset($_GET['ajax']) && $_GET['ajax'] == 'reseppasien-grid') {
        $this->renderPartial($this->path_view_pengambilanObat . '_riwayatResepPasien', [
          'riwayatResep' => $riwayatResep,
          'modReseptur' => $modReseptur,
          'modPasien' => $modPasien
        ]);
        die;
      }

      if(isset($_GET['ajax']) && $_GET['ajax'] == 'obat-api-grid') {
        $this->renderPartial($this->path_view_pengambilanObat . '_dialogObat');
        Yii::app()->end();
      }
    }
    $this->render($this->path_view_pengambilanObat . 'index', [
        'modReseptur' => $modReseptur,
        'riwayatResep' => $riwayatResep,
        'modPasien' => $modPasien,
        'modRiwayatPenjualanResep' => $modRiwayatPenjualanResep
    ]);
  }

  function actionSetRowObat() {
    
      $obatalkes_id = $_POST['obatalkes_id'];
      $jumlah = $_POST['jumlah'];
      $keterangan = $_POST['keterangan'];
      $petugasfarmasi_id = $_POST['petugasfarmasi_id'];
      $tgl_resep = $_POST['tgl_resep'];
      $noresep = $_POST['noresep'];
      $nama_pasien = $_POST['nama_pasien'];
      $hargasatuanreseptur = $_POST['hargasatuanreseptur'];
      $sumberdana_id = $_POST['sumberdana_id'];
      $stfornas = $_POST['stfornas'];
      $paket_obat = $_POST['paket_obat'];


      $modPegawai = PegawaiM::model()->findByPk($petugasfarmasi_id);
      $modObat = ObatalkesM::model()->findByPk($obatalkes_id);

      $modDetailResep = new ResepturokdetT;
      $modDetailResep->obatalkes_id = $obatalkes_id;
      $modDetailResep->obatalkes_nama = $modObat->obatalkes_nama;
      $modDetailResep->jumlah = $jumlah;
      $modDetailResep->keterangan = $keterangan;
      $modDetailResep->petugasfarmasi_id = $petugasfarmasi_id;
      $modDetailResep->petugasfarmasi_nama = $modPegawai->namaLengkap;
      $modDetailResep->tglresep_ok = $tgl_resep;
      $modDetailResep->noresep_ok = $noresep;
      $modDetailResep->nama_pasien = $nama_pasien;
      $modDetailResep->hargasatuan_reseptur = $hargasatuanreseptur;
      $modDetailResep->sumberdana_id = $sumberdana_id;
      $modDetailResep->st_fornas = $stfornas;
      $modDetailResep->paket_obat = $paket_obat;

      $data['html'] = $this->renderPartial($this->path_view_pengambilanObat . '_row', [
        'modDetailResep' => $modDetailResep
      ], true);

      echo json_encode($data);
  }

  function actionValidasiSingle() {
    $resepturokdet_id = $_POST['resepturokdet_id'];
    $data['sukses'] = 0;

    $modPengambilanObat = ResepturokdetT::model()->findByPk($resepturokdet_id);
    if($modPengambilanObat->validasi == null || $modPengambilanObat->validasi == false) {
        $modPengambilanObat->validasi = true;
    } else {
        $modPengambilanObat->validasi = false;
    }
    if($modPengambilanObat->save()) {
        $data['sukses'] = 1;
        if($modPengambilanObat->validasi) {
          $data['validasi'] = 1;
        } else {
          $data['validasi'] = 0;
        }
    }
    
    echo json_encode($data);
  }

  function actionValidasiAll() {
    $resepturok_id = $_POST['resepturok_id'];
    $command = Yii::app()->db->createCommand("
        UPDATE resepturokdet_t
        SET validasi = CASE
            WHEN validasi = false OR validasi is null THEN true
            ELSE false
        END
        WHERE resepturok_id = '" . $resepturok_id . "'
    ");

    $update = $command->execute();
    if($update > 1) {
      // $riwayatResep = ResepturokdetT::model()->findAllByAttributes(['resepturok_id' => $resepturok_id]);
      // echo '<pre>';var_dump($riwayatResep);die;
      // $data['html'] = $this->renderPartial($this->path_view_pengambilanObat . '_rowRiwayat', ['riwayatResep' => $riwayatResep], true);
      $data['sukses'] = 1;
    } else {
      $data['sukses'] = 0;
    }

    echo json_encode($data);
  }

  function actionHapus() {
    $resepturokdet_id = $_POST['resepturokdet_id'];

    $modDetailResep = ResepturokdetT::model()->findByPk($resepturokdet_id);

    if($modDetailResep->validasi) {
      $data['sukses'] = 2;
      $data['pesan'] = 'Data Tidak Dapat Dihapus Karena Sudah Divalidasi';
    } else {
      if($modDetailResep->delete()) {
        $data['sukses'] = 1;
        $data['pesan'] = 'Data Berhasil Dihapus';
      } else {
        $data['sukses'] = 0;
        $data['pesan'] = 'Data gagal dihapus';
      }
    }

    echo json_encode($data);
  }

  function actionbuatPenjualanResepRS() {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $pasienmasukpenunjang_id = $_POST['pasienmasukpenunjang_id'];
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modReseptur = ResepturokT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'penjualanresep_id' => null]);

      $cekValidasi = ResepturokdetT::model()->findAllByAttributes(['resepturok_id' => $modReseptur->resepturok_id], 'validasi is false OR validasi is null');

      if(count($cekValidasi) > 0) {
        echo json_encode(['sukses' => 2, 'pesan' => 'Masih Ada Obat Yang belum di validasi']);
        Yii::app()->end(); 
      }


      $data['sukses'] = 0;
      $data['penjualanresep_id'] = '';
      $modDetails = [];
      if(!empty($modPendaftaran)) {
          $modDetailResep = ResepturokdetT::model()->findAllByAttributes(['resepturok_id' => $modReseptur->resepturok_id]);
          $penotalanharga['totharganetto'] = 0;
          $penotalanharga['totalhargajual'] = 0;
          foreach($modDetailResep as $key => $val){
              $jumlah = 0;
              if (strpos($val->jumlah, "/")) {
                $exJumlah = explode('/', $val->jumlah);
                if(isset($exJumlah[0]) && isset($exJumlah[1])) {
                  $jumlah = $exJumlah[0] / $exJumlah[1];
                } 
              } else if(strpos($val->jumlah, ",") || strpos($val->jumlah, ".")) {
                $jumlah = MyFormatter::formatNumberForDb($val->jumlah);
              } else {
                $jumlah = $val->jumlah;
              }
              $penotalanharga['totharganetto'] += $val->hargasatuan_reseptur;
              $penotalanharga['totalhargajual'] += ($val->hargasatuan_reseptur * $jumlah);
          }
          $transaction = Yii::app()->db->beginTransaction();

          try {

              $modPenjualan = $this->savePenjualanResepRS($modPendaftaran, $modReseptur, $penotalanharga);

              foreach($modDetailResep as $i => $val) {
                  $modDetails[$i] = new FAObatalkesPasienT;
                  $oa = ObatalkesM::model()->findByPk($val->obatalkes_id);
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
                  $modDetails[$i]->permintaan_oa = $val->jumlah;
                  $modDetails[$i]->obatalkes_id = $val->obatalkes_id;
                  $modDetails[$i]->sumberdana_id = $val->sumberdana_id;
                  $modDetails[$i]->st_fornas = $val->st_fornas;
                  $modDetails[$i]->hargasatuan_oa = $val->hargasatuan_reseptur;
                  $jumlah = 0;
                  if (strpos($val->jumlah, "/")) {
                    $exJumlah = explode('/', $val->jumlah);
                    if(isset($exJumlah[0]) && isset($exJumlah[1])) {
                      $jumlah = $exJumlah[0] / $exJumlah[1];
                    } 
                  } else if(strpos($val->jumlah, ",") || strpos($val->jumlah, ".")) {
                    $jumlah = MyFormatter::formatNumberForDb($val->jumlah);
                  } else {
                    $jumlah = $val->jumlah;
                  }
                  
                  $modDetails[$i]->hargajual_oa = $val->hargasatuan_reseptur * $jumlah;
                  
                  
                  $modDetails[$i]->create_time = date("Y-m-d H:i:s");
                  $modDetails[$i]->create_loginpemakai_id = Yii::app()->user->id;
                  $modDetails[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
                  $modDetails[$i]->kelaspelayanan_id = $modPenjualan->kelaspelayanan_id;
                  $modDetails[$i]->pasienadmisi_id = $modPenjualan->pasienadmisi_id;
                 
                  
                  $modDetails[$i]->qty_oa = $jumlah;
                  $modDetails[$i]->qty_jual = $jumlah;
                  $modDetails[$i]->kekuatan_oa = null;
                  $modDetails[$i]->jumlahppn = 0;
                  $modDetails[$i]->persenppnjual = $oa->ppn_persen;
        

                  $modDetails[$i]->total_embalase = 0;

                  if(!empty($modDetails[$i]->jumlahppn) && $modDetails[$i]->jumlahppn > 0){
                      $modDetails[$i]->pajak_id = 6; //pajak ppn
                  }

                  // var_dump($modDetails[$i]->attributes); die;

                  // var_dump($modDetails[$i]->validate(), $modDetails[$i]->getErrors());
                  if ($modDetails[$i]->validate()) {

                      $this->obatalkespasientersimpan &= $modDetails[$i]->save();
                  } else {
                      $this->obatalkespasientersimpan &= false;
                  }

              }
              if($this->obatalkespasientersimpan && $this->penjualantersimpan) {
                  $modTindakan = new TindakanpelayananT;
                  $modTindakan->attributes = $modPendaftaran->attributes;
                  $modTindakan->daftartindakan_id = 74;
                  $modTindakan->penjualanresep_id = $modPenjualan->penjualanresep_id;
                  $modTindakan->tarif_tindakan = $modPenjualan->totalhargajual;
                  $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
                  $modTindakan->create_time = date('Y-m-d H:i:s');
                  $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
                  $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');

                  $modTindakan->qty_tindakan = 1;
                  $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
                  $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
                  $modTindakan->discount_tindakan = 0;
                  $modTindakan->subsidiasuransi_tindakan = 0;
                  $modTindakan->subsidipemerintah_tindakan = 0;
                  $modTindakan->subsisidirumahsakit_tindakan = 0;
                  $modTindakan->iurbiaya_tindakan = 0;
                  $modTindakan->tarif_rsakomodasi = 0;
                  $modTindakan->tarif_medis = 0;
                  $modTindakan->tarif_paramedis = 0;
                  $modTindakan->tarif_bhp = 0;
                  $modTindakan->tarifcyto_tindakan = 0;


                  $modTindakan->satuantindakan = 'KALI'; 

                  $md_noawal = TindakanpelayananT::model()->find("pendaftaran_id = $modPendaftaran->pendaftaran_id AND nopelayanan IS NOT NULL order by nopelayanan DESC");

                  if(!empty($md_noawal)) {
                      $noawal = intval($md_noawal->nopelayanan) + 1;
                  } else {
                      $noawal = 1;
                  }
              
                  $modTindakan->nopelayanan = str_pad($noawal,3,"0",STR_PAD_LEFT);

                  $tindakantersimpan = $modTindakan->save();
                  if($tindakantersimpan) {
                      $modReseptur->penjualanresep_id = $modPenjualan->penjualanresep_id;
                      $modReseptur->save();
                      $transaction->commit();
                      $this->setAPIPenjualanResepOA($modPenjualan, $modDetails);
                      // cek apakah penjualan api berhasil apa tidak 
                      $cekPenjualan = PenjualanresepT::model()->findByPk($modPenjualan->penjualanresep_id);
                      // jika data terhapus atau empty berarti ada kegagalan saat pengiriman api
                      if(!empty($cekPenjualan)) {
                        $data['sukses'] = 1;
                        $data['penjualanresep_id'] = $modPenjualan->penjualanresep_id;
                      } else {
                        $data['sukses'] = 2;
                        $data['pesan'] = 'Gagal Dilakukan Penjualan';
                      }
                  }
              }
          } catch (Exception $exc) {
              var_dump($exc->getMessage()); die;
              $transaction->rollback();

          }
      }

      echo json_encode($data);
  }

  protected function savePenjualanResepRS($modPendaftaran, $modReseptur, $penotalanharga) {
      $format = new MyFormatter();
      $modPenjualan = new FAPenjualanResepT;
      $modPenjualan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $modPenjualan->penjamin_id = $modPendaftaran->penjamin_id;
      $modPenjualan->carabayar_id = $modPendaftaran->carabayar_id;
      $modPenjualan->antrianfarmasi_id = null;
      $modPenjualan->pegawai_id = $modReseptur->petugasfarmasi_id;
      $modPenjualan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
      $modPenjualan->pasien_id = $modPendaftaran->pasien_id;
      $modPasienAdmisi = PasienadmisiT::model()->findByAttributes(array("pendaftaran_id" => $modPendaftaran->pendaftaran_id, "pasien_id" => $modPendaftaran->pasien_id));
      $modPenjualan->pasienadmisi_id = (empty($modPasienAdmisi->pasienadmisi_id)) ? null : $modPasienAdmisi->pasienadmisi_id;
      $modPenjualan->tglpenjualan = date('Y-m-d H:i:s');
      $modPenjualan->tglresep = $modReseptur->tglresep_ok;
      $modPenjualan->ruanganasal_nama = Yii::app()->user->getState('ruangan_nama');
      $modPenjualan->instalasiasal_nama = Yii::app()->user->getState('instalasi_nama');
      $modPenjualan->reseptur_id = null;
      $modPenjualan->resepturok_id = $modReseptur->resepturok_id;

      $modPenjualan->statusobat = null;

      $modPenjualan->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modPenjualan->pembulatanharga = Yii::app()->user->getState('pembulatanharga');
      $modPenjualan->noresep = MyGenerator::noResep(Yii::app()->user->getState('instalasi_id'));
      $modPenjualan->subsidiasuransi = 0;
      $modPenjualan->subsidipemerintah = 0;
      $modPenjualan->subsidirs = 0;
      $modPenjualan->iurbiaya = 0;
      $modPenjualan->discount = 0;
      $modPenjualan->jasapelayanan_farmasi = null;
      $modPenjualan->create_time = date("Y-m-d H:i:s");
      $modPenjualan->create_loginpemakai_id = Yii::app()->user->id;
      $modPenjualan->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modPenjualan->jasapelayanan_farmasi = 0;
      $modPenjualan->jasaembalase = 0;
      $modPenjualan->totalkronis =  0;
      $modPenjualan->totalinacbg = 0;
      $modPenjualan->totharganetto = $penotalanharga['totharganetto'];
      $modPenjualan->totalhargajual = $penotalanharga['totalhargajual'];
      $modPenjualan->totaltarifservice = 0;
      $modPenjualan->biayaadministrasi = 0;
      $modPenjualan->biayakonseling = 0;
      $modPegawai = PegawaiM::model()->findByPk($modReseptur->petugasfarmasi_id);
     
      $modPenjualan->kodedokter_inventory = "-";
      

      $petugas = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
      if(!empty($petugas)) {
          $modPenjualan->kodepetugas_inv = $petugas->kodepetugas_inventory;
      }
      if(!empty($modPendaftaran->ruangan)) {
          $modPenjualan->jenislayanan_inv = $modPendaftaran->ruangan->kodeJL_inventory;
          $modPenjualan->tempatlayanan_inv = $modPendaftaran->ruangan->kodeTL_inventory;
      }
      // echo "<pre>"; var_dump($modPenjualan->validate(), $modPenjualan->save());die;

      if ($modPenjualan->validate()) {
          $modPenjualan->save();
          PendaftaranT::model()->updateByPk($modPenjualan->pendaftaran_id, array('pembayaranpelayanan_id' => null));
          
          $this->penjualantersimpan = true;
      } else {
          $this->penjualantersimpan = false;
      }

      return $modPenjualan;
  }

  function getBridgingHost() {
      $konfig = KonfigsystemK::model()->find();
      return $konfig->bridging_host;
  }

  public function setAPIPenjualanResepOA($penjualan, $detail) {

		$ok = true;
    $logApiFarmasi = new ApifarmasilogR();

		$api = new MyAPI;
		$ruangan = RuanganM::model()->findByPk($penjualan->ruangan_id);
		$kode = $ruangan->kodedepo_inventory.date('Ym');

		$jualAPI = InslogjualfarmasiInvV::model()->findByAttributes(array(
			'penjualanresep_id'=>$penjualan->penjualanresep_id
		));

		// echo "Kode Depo : ".$ruangan->kodedepo_inventory."<br/>";
		// echo "Kode Depo Layanan : ".$kode."<br/>";
		
		// var_dump($kode, $ruangan->attributes); die;
		
		$header = array(
			"Accept" => "application/json",
			"Content-type" => "application/json"
		);

    // mulai menjalankan api
  

		// get nomor Kode
    $bodyGetKode = CJSON::encode(array(
      'kode'=>$kode
    ));
    $urlGetKode = $this->getBridgingHost() . "/getkode";
		$res_kode = CJSON::decode($api->apiRequest($urlGetKode, "POST", $header, $bodyGetKode) ?? "{}");
      
    $log1 = $logApiFarmasi->logFarmasi($res_kode, $bodyGetKode, $penjualan, $urlGetKode); //simpan ke log


		// get Nomor Singkatan
    $bodyGetInitial = CJSON::encode(array(
      'kode'=>$ruangan->kodedepo_inventory,
    ));
    $urlGetInitial = $this->getBridgingHost() . "/getInisial";
		$res_inisial = CJSON::decode($api->apiRequest($urlGetInitial, "POST", $header, $bodyGetInitial) ?? "{}");

    $log2 = $logApiFarmasi->logFarmasi($res_inisial, $bodyGetInitial, $penjualan, $urlGetInitial); // simpan ke log


		$kode_cur = $res_kode['data']['recordset'][0]['Kode'] ?? null;
		if (!empty($kode_cur)) {
			// var_dump($kode_cur, $kode);
			$nomor = substr($kode_cur, strlen($kode));

			$penjualan->kodedepo_inv = $kode.str_pad((int)$nomor + 1, strlen($nomor), "0", STR_PAD_LEFT);
		} else {
			$penjualan->kodedepo_inv = $kode."000001";
		}
			
		// $penjualan->kodedepo_inv = $res_kode['data']['recordset'][0]['Kode'] ?? null;
		$penjualan->inisialjual_inv = $res_inisial['data']['recordset'][0]['Inisial'] ?? null;
		

    //=======================================================

		// get Nomor Jual
    $kodejual_head = $penjualan->inisialjual_inv.date('Ym');
    $bodyGetNoJUal = CJSON::encode(array(
      'NoJual'=>$kodejual_head
    ));
    $urlNoJual = $this->getBridgingHost() . "/getNoJual";

		$res_nojual = CJSON::decode($api->apiRequest($urlNoJual, "POST", $header, $bodyGetNoJUal) ?? "{}");

    $log3 = $logApiFarmasi->logFarmasi($res_nojual, $bodyGetNoJUal, $penjualan, $urlNoJual); // simpan ke log

		$nojual_cur = $res_nojual['data']['recordset'][0]['NoJual'] ?? null;
		if (!empty($nojual_cur)) {
			$nomor = substr($nojual_cur, strlen($kodejual_head));

			$penjualan->nojual_inv = $kodejual_head.str_pad((int)$nomor + 1, strlen($nomor), "0", STR_PAD_LEFT);
			// var_dump($penjualan->nojual_inv);
		} else {
			$penjualan->nojual_inv = $kodejual_head."000001";
		}

		// var_dump($kode, $res_kode, $penjualan->kodedepo_inv, 
		// $res_inisial, $res_nojual, $penjualan->nojual_inv); die;



		$ok = $ok && $penjualan->save(false, array('kodedepo_inv', 'inisialjual_inv', 'nojual_inv'));

		// var_dump($ok, $penjualan->kodedepo_inv, $penjualan->inisialjual_inv, $penjualan->nojual_inv); // die;
		// die;

		// Log Jual Resep	
		$penjualanAPI = InslogjualfarmasiInvV::model()->findByAttributes(array(
			'penjualanresep_id'=>$penjualan->penjualanresep_id
		));


		$petugas = empty($penjualanAPI->idpetugas) ? "PTG08120001" : $penjualanAPI->idpetugas;

		if (!empty($penjualanAPI)) {
      $penjualanAPI->nott = ($penjualanAPI->nott == '') ? " " : $penjualanAPI->nott;
			$penjualanAPI->kodedokter = ($penjualanAPI->kodedokter == '') ? " " : $penjualanAPI->kodedokter;
      $namapx = str_replace("'", '`', $penjualanAPI->namapx);
			$query = array(
				'NoRMPx'=>$penjualanAPI->normpx,
				'NamaPx'=>$namapx,
				'TglLahir'=>$penjualanAPI->tgllahir,
				'UmurPx'=>$penjualanAPI->umurpx,
				'KetUmur'=>$penjualanAPI->ketumur,
				'AlamatPx'=>$penjualanAPI->alamatpx,
				'NoTT'=>$penjualanAPI->nott ?? "",
				'NoBilling'=>$penjualanAPI->nobilling,
				'KodeDepo'=>$penjualanAPI->kodedepo,
				'KodeJamin'=>$penjualanAPI->kodejamin,
				'KodeDokter'=>$penjualanAPI->kodedokter,
				'KodeTL'=>$penjualanAPI->kodetl ?? " ",
				'IdPetugas'=>$petugas,
				'Kode'=>$penjualanAPI->kode,
				'NoJual'=>$penjualanAPI->nojual,
				'TglJual'=>$penjualanAPI->tgljual,
				'NoMinta'=>$penjualanAPI->nominta,
				'Aktif'=>$penjualanAPI->aktif,
				'StCetak'=>$penjualanAPI->stcetak,
				'StJual'=>$penjualanAPI->stjual,
				'TotJual'=>$penjualanAPI->totjual,
			);

			// var_dump($query, $penjualanAPI->attributes); die;
      $urlLogJual = $this->getBridgingHost() . "/TTLogJual";
			$res_logjual = CJSON::decode($api->apiRequest(
				$urlLogJual, 
				"POST", $header, CJSON::encode($query)) ?? "{}");

      
      $log4 = $logApiFarmasi->logFarmasi($res_logjual, $query, $penjualan, $urlLogJual, $penjualanAPI->nojual);

			// var_dump($kode, $res_kode, $res_inisial, $res_nojual, $res_logjual, $query); die;

			if (!empty($res_logjual) && !empty($res_logjual['status']['OK']) && $res_logjual['status']['OK'] == true) {
				// var_dump("MULAI SET DETAIL JUAL");

				$det = InslogjualdfarmasiInvV::model()->findAllByAttributes(array(
					'kodejual'=>$penjualan->nojual_inv,
					'kode'=>$penjualan->kodedepo_inv
				));

				// var_dump(count($det)); die;

				$cnt = 1;
				foreach ($det as $idx => $item) {

					// for ($k = 0; $k < 2; $k++) {

					// insert log detail obat alkes

					$kode_det = $penjualanAPI->kode.str_pad($cnt, 4, "0", STR_PAD_LEFT);
					$kode_jual = $penjualanAPI->kode;
					// var_dump($kode_det); die;

					$query_detail = array(
						'kodebarang'=>$item->kodebarang,
						'hpp'=>$item->hpp,
						'satuan'=>$item->satuan,
						'ststock'=>$item->ststock,
						'stracik'=>$item->stracik,
						'signa'=>$item->signa ?? " ",
						'frek'=>'', //$item->frek,
						'jfrek'=>'', //$item->jfrek ?? 1,
						'peng'=>0,
						'penf'=>0,
						'sp'=>0,
						'ss'=>0,
						'ssr'=>0,
						'sm'=>0,
						'jumlah'=>$item->jumlah,
						'harga'=>$item->harga,
						'hargaretur'=>$item->hargaretur,
						'kode'=>$kode_det,
						'kodejual'=>$kode_jual, //$penjualanAPI->nojual,
					);

					// var_dump($query_detail); die;

          $urlLogJualD = $this->getBridgingHost() . "/TTLogjualD";
					$res_logjual_detail = CJSON::decode($api->apiRequest(
						$urlLogJualD, 
						"POST", $header, CJSON::encode($query_detail)) ?? "{}");
          
          $logApiFarmasi->logFarmasi($res_logjual_detail, $query_detail, $penjualan, $urlLogJualD, $penjualanAPI->nojual);
					// var_dump($query_detail, $res_logjual_detail);

					if (!empty($res_logjual_detail['status']['OK']) && $res_logjual_detail['status']['OK'] == true) {
						// update stok

						$kodeDepo = $ruangan->kodedepo_inventory;
						$kodeBarang = $item->kodebarang;
						$periode = date('Ym');

						// $kodeDepo = "DEPO0808001";
						// $kodeBarang = "OBORAL3098";
						// $periode = "202305";


						$query_cek_stok = array(
							"jmlItem"=>$item->jumlah,
							"KodePeriode"=>$periode,
							"KodeDepo"=>$kodeDepo,
							"KodeBarang"=>$kodeBarang,
							"StStock"=>"$item->ststock",
						);
	
            $urlCekStok = $this->getBridgingHost() . "/cekstok";
						$res_cek_stok = CJSON::decode($api->apiRequest(
							$urlCekStok, 
							"POST", $header, CJSON::encode($query_cek_stok)) ?? "{}");

            $logApiFarmasi->logFarmasi($res_cek_stok, $query_cek_stok, $penjualan, $urlCekStok);
						// var_dump("https://ihdev-apisim.rssa.my.id/simgosfarmasirssa/cekstok", $query_cek_stok, $res_cek_stok);
	
							// TODO : Validasi ?
						if (
							!empty($res_cek_stok['status']['OK']) 
							&& $res_cek_stok['status']['OK'] == true
						) {
		
							$jml_stok = $res_cek_stok['data']['recordset'][0]['stok_akhir'] ?? 0;

							if ($jml_stok > 0) {
                $urlUpdateStok = $this->getBridgingHost() . "/updatestok";
								$res_update_stok = CJSON::decode($api->apiRequest(
									$urlUpdateStok, 
									"PUT", $header, CJSON::encode($query_cek_stok)) ?? "{}");
                  $logApiFarmasi->logFarmasi($res_update_stok, $query_cek_stok, $penjualan, $urlUpdateStok);
								// var_dump("https://ih-apisim.rssa.my.id/simgosfarmasirssa/updatestok", $query_cek_stok, $res_update_stok);
							}



						}

					}

					$cnt++;

					// }


				}

			}

				


			// var_dump($res_logjual, $query, $penjualanAPI->attributes);

		}

		// die;
		// load oa ruangan
		

		// var_dump($oa->attributes); die;
	}


  function actionDetailPenjualan() {
      $caraPrint = isset($_GET['caraPrint']) ? $_GET['caraPrint'] : null;
      $judulLaporan = 'Detail Penjualan';
      
      if(!empty($caraPrint)) {
          $this->layout = '//layouts/printWindows';
      } else {
          $this->layout = '//layouts/iframe';
      }
      $penjualanresep_id = $_GET['penjualanresep_id'];
      $modPenjualan = FAPenjualanResepT::model()->findByPk($penjualanresep_id);
      $modPendaftaran = PendaftaranT::model()->findByPk($modPenjualan->pendaftaran_id);
      $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
      $modTriage = NotriagePasienT::model()->findByAttributes(['pendaftaran_id' => $modPendaftaran->pendaftaran_id]);
      $modObatAlkes = FAObatalkesPasienT::model()->findAllByAttributes(array('penjualanresep_id' => $penjualanresep_id));

      $this->render($this->path_view_pengambilanObat . '_viewDetailPenjualan', [
          'modPendaftaran' => $modPendaftaran,
          'modPasien' => $modPasien,
          'modPenjualan' => $modPenjualan,
          'modObatAlkes' => $modObatAlkes,
          'caraPrint' => $caraPrint,
          'judulLaporan' => $judulLaporan,
          'modTriage' => $modTriage
      ]);
  }

  function actionUbah($resepturokdet_id) {
      $this->layout = '//layouts/iframe';
      
      $modResepturDetail = ResepturokdetT::model()->findByPk($resepturokdet_id);
      $modResepturDetail->noresep_ok = $modResepturDetail->reseptur->noresep_ok;
      $modResepturDetail->obatalkes_nama = $modResepturDetail->obatalkes->obatalkes_nama ??'';
      $is_save = false;
      if(isset($_POST['ResepturokdetT'])) {
          $modResepturDetail->jumlah = $_POST['ResepturokdetT']['jumlah'];
          $modResepturDetail->update_time = date('Y-m-d H:i:s');
          if($modResepturDetail->save()) {
              Yii::app()->user->setFlash('success', "Data Berhasil Diubah ");
              
          } else {
              Yii::app()->user->setFlash('error', "Data gagal diubah ");

          }
      }
      if(!empty($modResepturDetail)) {
          $this->render($this->path_view_pengambilanObat . '_ubah', [
              'modResepturDetail' => $modResepturDetail
          ]);
      } else {
          echo 'data tidak ditemukan';
      }
  }

  function actionUpdateTableRiwayat() {
    $modReseptur = ResepturokT::model()->findByAttributes(['pendaftaran_id' => $_POST['pendaftaran_id'], 'pasienmasukpenunjang_id' => $_POST['pasienmasukpenunjang_id'], 'penjualanresep_id' => null]);

    $data['html'] = '';
    if(!empty($modReseptur)) {
      $riwayatResep = ResepturokdetT::model()->findAllByAttributes(['resepturok_id' => $modReseptur->resepturok_id]);

      if(count($riwayatResep) > 0 ) {
        $data['html'] = $this->renderPartial($this->path_view_pengambilanObat . '_rowRiwayat', ['riwayatResep' => $riwayatResep], true);
      }
    }
    echo json_encode($data);
  }

  function actionPrintEtiketOK($resepturokdet_id, $caraPrint) {
        
		$this->layout = '//layouts/iframe';
		$format = new MyFormatter;

    $modDetailResep = ResepturokdetT::model()->findByPk($resepturokdet_id);
    $modObatAlkes = $modDetailResep->obatalkes;
    $modReseptur = $modDetailResep->reseptur;


		$judul_print = 'Penjualan Resep Rumah Sakit';


		$view = $this->path_view_pengambilanObat . "PrintEtiketV2";


		if ($caraPrint == "PRINT") {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = 'L'; //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF60('', array(40, 65));
			$formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/ETICKET.css');
			ob_clean();
			$mpdf->WriteHTML($formatkonten, 1);
			ob_clean();
			$mpdf->mirrorMargins = 0;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 0, 0, -3, 0, 0, 0);
			$mpdf->SetHTMLFooter('<span></span>');
			$mpdf->WriteHTML(
				$this->renderPartial($view, array(
					'format' => $format,
					'judul_print' => $judul_print,
					'modDetailResep' => $modDetailResep,
          'modObatAlkes' => $modObatAlkes,
          'modReseptur' => $modReseptur
				), true)
			);
			$mpdf->SetJS('this.print();');
			$mpdf->Output();
		}
	
    }

    function actionInformasiPasienOperasi() {
      $this->pageTitle = Yii::app()->name . " - Pasien Rujukan";
      $model = new PasienkirimkeunitlainV;
      $model->tgl_awal = date('Y-m-d', strtotime('-5 days'));
      $model->tgl_akhir = date('Y-m-d');
      $model->tgl_rencana_awal = date('Y-m-d', strtotime('-5 days'));
      $model->tgl_rencana_akhir = date('Y-m-d');
      // $model->ruangan_id = 12; //Yii::app()->user->getState('ruangan_id');
  
      if (isset($_GET['PasienkirimkeunitlainV'])) {
        $model->attributes = $_GET['PasienkirimkeunitlainV'];
        $model->statusperiksa = isset($_GET['PasienkirimkeunitlainV']['statusperiksa']) ? $_GET['PasienkirimkeunitlainV']['statusperiksa'] : null;
      }
  
      
      $dataProvider = $model->searchInformasiPasienOperasi();
      if(Yii::app()->request->isAjaxRequest) {
        if(isset($_GET['ajax']) && $_GET['ajax'] == 'pasienpenunjangrujukan-m-grid') {
          $module = $this->module->id;
          $this->renderPartial($this->path_view_informasiPasienOperasi . '_table', ['dataProvider' => $dataProvider, 'module' => $module]);
          Yii::app()->end();
        }
      }
      
      $this->render($this->path_view_informasiPasienOperasi . 'index', array('dataProvider' => $dataProvider, 'model' => $model));
    }
}
