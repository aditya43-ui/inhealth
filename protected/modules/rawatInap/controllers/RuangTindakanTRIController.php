<?php
class RuangTindakanTRIController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  protected $path_view = 'rawatInap.views.ruanganTindakan.';

  public function actionIndex($pendaftaran_id, $idPasienKirimKeUnitLain = null, $idKonsulTindakan = null)
  {
    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPendaftaran = RIPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasienAdmisi = RIPasienAdmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
    $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findByPk($modPendaftaran->pegawai_id);
    $karcisTindakan = DaftartindakanM::model()->findAllByAttributes(array('daftartindakan_karcis' => true));

    $modKonsul = new RIRuangTindakan;
    
    $modelPendaftaran = new RIPendaftaranT;
    $modKonsul->pasien_id = $modPendaftaran->pasien_id;
    $modKonsul->pendaftaran_id = $pendaftaran_id;
    $modKonsul->pegawai_id = $modPendaftaran->pegawai_id;
    $modKonsul->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
    $modKonsul->asalpoliklinikorder_id = $ruangan_id;
   // $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;

    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id);

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
    
    if (isset($idPasienKirimKeUnitLain)) {
      $modKirimKeUnitLain = RIPasienKirimKeUnitLainT::model()->findByPk($idPasienKirimKeUnitLain);
      $modPasien = $modKirimKeUnitLain->pasien;
  
    } else {
      $modKirimKeUnitLain = new RIPasienKirimKeUnitLainT();
      $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai;
      
    }

    $modKonsulpoli =  RIKonsulPoliT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));

    if(!empty($modKonsulpoli)){

      $modKirimKeUnitLain->pegawai_id = $modKonsulpoli->pegawai;
 
    }else{

      $modKirimKeUnitLain->pegawai_id = $modPasienAdmisi->dokpenerima;
    }

    $modRiwayatKonsul = RuangTindakanT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));


  

    // var_dump($modKirimKeUnitLain);die;
    
    if (!empty($idKonsulTindakan)) {
      $modKonsulPoli = RIRuangTindakan::model()->findByPk($idKonsulTindakan);
    } else {
      $modKonsulPoli = new RIRuangTindakan();
      
    }

    if (isset($_POST['RIPasienKirimKeUnitLainT'])) {
      // echo '<pre>';
      // var_dump($_POST);die;
      $transaction = Yii::app()->db->beginTransaction();
      $ok = true;

      // echo '<pre>';
      // var_dump($_POST);die;
       if (isset($_POST['RIPasienKirimKeUnitLainT']['ruangan_id'])) {
    //   foreach($_POST['RIPasienKirimKeUnitLainT']['ruangan_id'] as $ruangantujuan_id) {

          // $modKirimKeUnitLain = new RIPasienKirimKeUnitLainT;
          
          $modRuangan = RuanganM::model()->findByPk($_POST['RIPasienKirimKeUnitLainT']['ruangan_id']);
          $modKirimKeUnitLain->attributes = $_POST['RIPasienKirimKeUnitLainT'];
          $modKirimKeUnitLain->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
          $modKirimKeUnitLain->instalasi_id = $modRuangan->instalasi_id;
          $modKirimKeUnitLain->ruangan_id = $_POST['RIPasienKirimKeUnitLainT']['ruangan_id'];
          $modKirimKeUnitLain->pegawai_id = $_POST['RIPasienKirimKeUnitLainT']['pegawai_id'];
          $modKirimKeUnitLain->ppds_id = $_POST['RIPasienKirimKeUnitLainT']['ppds_id'];
          $modKirimKeUnitLain->pasien_id = $modPendaftaran->pasien_id;
          $modKirimKeUnitLain->pendaftaran_id = $modPendaftaran->pendaftaran_id;
          $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($_POST['RIPasienKirimKeUnitLainT']['tgl_kirimpasien']);
          $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($_POST['RIPasienKirimKeUnitLainT']['ruangan_id']);
          $modKirimKeUnitLain->no_permintaan = MyGenerator::generateNomorPermintaan($_POST['RIPasienKirimKeUnitLainT']['ruangan_id']);
          $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
          $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
          $modKirimKeUnitLain->create_ruangan = Yii::app()->user->getState('ruangan_id');

          //       echo '<pre>';
          // var_dump($_POST,$modKirimKeUnitLain);die;
          //       var_dump($modKonsul->attributes, $_POST); die;

    
          if ($modKirimKeUnitLain->validate()) {
            if ($modKirimKeUnitLain->save()) {

              $ruanganAgarKeDaftarPasien = ['940', '75'];
              if(in_array($_POST['RIPasienKirimKeUnitLainT']['ruangan_id'], $ruanganAgarKeDaftarPasien)) {
                // echo 'kesini';die;

                $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByAttributes(['pasienkirimkeunitlain_id' => $modKirimKeUnitLain->pasienkirimkeunitlain_id]);

                if(empty($modPasienMasukPenunjang)) {
                  $modPasienMasukPenunjang = new PasienmasukpenunjangT();
                }
                $modPasienMasukPenunjang->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
                $modPasienMasukPenunjang->pasien_id = $modPendaftaran->pasien_id;
                $modPasienMasukPenunjang->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
                $modPasienMasukPenunjang->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
                $modPasienMasukPenunjang->ruangan_id = $_POST['RIPasienKirimKeUnitLainT']['ruangan_id'];
                $modPasienMasukPenunjang->tglmasukpenunjang = MyFormatter::formatDateTimeForDb($_POST['RIPasienKirimKeUnitLainT']['tgl_kirimpasien']);
                $modPasienMasukPenunjang->no_urutperiksa = MyGenerator::noAntrianPenunjang($_POST['RIPasienKirimKeUnitLainT']['ruangan_id']);
                $modPasienMasukPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($modRuangan->instalasi->instalasi_singkatan);
                $modPasienMasukPenunjang->kunjungan = $modPendaftaran->kunjungan;
                $modPasienMasukPenunjang->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
                $modPasienMasukPenunjang->ruanganasal_id = $modPendaftaran->ruangan_id;

                // echo '<pre>';
                // var_dump($modPasienMasukPenunjang);die;

                if($modPasienMasukPenunjang->validate()) {
                  if($modPasienMasukPenunjang->save()) {
                    $ok = true;
                  } else {
                    $ok = false;
                    // var_dump($modPasienMasukPenunjang->getErrors());die;
                  }
                } else {
                  $ok = false;
                  // var_dump($modPasienMasukPenunjang->getErrors());die;
                }
              }

              $ruanganKerujukanHemodialisa = ['79', '76', '77'];
              if(in_array($_POST['RIPasienKirimKeUnitLainT']['ruangan_id'], $ruanganKerujukanHemodialisa)) {
                $modKonsulPoli = new KonsulpoliT();
          
                $modKonsulPoli->ruangan_id = $_POST['RIPasienKirimKeUnitLainT']['ruangan_id'];
                $modKonsulPoli->pasien_id = $modPendaftaran->pasien_id;
                $modKonsulPoli->pegawai_id = $_POST['RIPasienKirimKeUnitLainT']['pegawai_id'];
                $modKonsulPoli->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $modKonsulPoli->tglkonsulpoli = MyFormatter::formatDateTimeForDb($_POST['RIPasienKirimKeUnitLainT']['tgl_kirimpasien']);
                $modKonsulPoli->asalpoliklinikkonsul_id = $modPendaftaran->ruangan_id;
                $modKonsulPoli->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
                $modKonsulPoli->catatan_dokter_konsul = $_POST['RIPasienKirimKeUnitLainT']['catatandokterpengirim'];
                $modKonsulPoli->no_antriankonsul = MyGenerator::noAntrianPPKonsul2($_POST['RIPasienKirimKeUnitLainT']['ruangan_id']);
                $modKonsulPoli->is_verifikasi_hd = false;
                if($modKonsulPoli->validate()) {
                  if($modKonsulPoli->save()) {
                    $ok = true;
                  } else {
                    $ok = false;
                    // var_dump($modPasienMasukPenunjang->getErrors());die;
                  }
                } else {
                  $ok = false;
                  // var_dump($modPasienMasukPenunjang->getErrors());die;
                }
              }

              // var_dump('hehe');die;
              
              $p = PendaftaranT::model()->findByPk($pendaftaran_id);
              $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);
    
              PendaftaranT::model()->updateByPk(
                $pendaftaran_id,
                array(
                  'pembayaranpelayanan_id' => null
                )
              );

    
              $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id);
              if(!empty($jenistarif)) {
                $jenistarif = $jenistarif->jenistarif_id ?? null;
              }
              if(!empty($jenistarif)) {
                $criteria = new CDbCriteria();
                $criteria->addCondition('t.komponentarif_id =' . Params::KOMPONENTARIF_ID_TOTAL);
                $criteria->addCondition('d.daftartindakan_konsul = true and d.daftartindakan_karcis = true');
                $criteria->join = "join daftartindakan_m d on t.daftartindakan_id = d.daftartindakan_id";
                $criteria->addCondition("kelaspelayanan_id = " . $modPendaftaran->kelaspelayanan_id);
                $criteria->addCondition("jenistarif_id = " . $jenistarif);
  
                $modTarif = RITariftindakanM::model()->find($criteria);
                if (!empty($modTarif)) {
                  $modTindakanPelayanan =  new RITindakanPelayananT;
                  $modTindakanPelayanan->ruangtindakan_id = $modKirimKeUnitLain->ruangan_id;
                  $modTindakanPelayanan->pasien_id = $modPendaftaran->pasien_id;
                  $modTindakanPelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                  $modTindakanPelayanan->kelaspelayanan_id = $modPendaftaran->kelaspelayanan_id;
                  $modTindakanPelayanan->shift_id     = $modPendaftaran->shift_id;
                  $modTindakanPelayanan->carabayar_id = $modPendaftaran->carabayar_id;
                  $modTindakanPelayanan->penjamin_id = $modPendaftaran->penjamin_id;
                  $modTindakanPelayanan->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
                  $modTindakanPelayanan->ruangan_id   = $modKirimKeUnitLain->ruangan_id;
                  $modTindakanPelayanan->instalasi_id = $modTindakanPelayanan->ruangan->instalasi_id;
                  $modTindakanPelayanan->cyto_tindakan = 0;
                  $modTindakanPelayanan->tarifcyto_tindakan = 0;
                  $modTindakanPelayanan->discount_tindakan = 0;
                  $modTindakanPelayanan->subsidiasuransi_tindakan = 0;
                  $modTindakanPelayanan->subsidipemerintah_tindakan = 0;
                  $modTindakanPelayanan->subsisidirumahsakit_tindakan = 0;
                  $modTindakanPelayanan->iurbiaya_tindakan = 0;
                  $modTindakanPelayanan->create_loginpemakai_id = Yii::app()->user->id;
                  $modTindakanPelayanan->create_ruangan = $modKirimKeUnitLain->ruangan_id;
                  $modTindakanPelayanan->create_time =  date('Y-m-d H:i:s');
                  $modTindakanPelayanan->satuantindakan = "Hari";
      
                  $modTindakanPelayanan->daftartindakan_id = $modTarif->daftartindakan_id;
                  $modTindakanPelayanan->tgl_tindakan = date('Y-m-d H:i:s');
      
                  $modTindakanPelayanan->tarif_satuan = (isset($modTarif->harga_tariftindakan) ? $modTarif->harga_tariftindakan : 0);
                  $modTindakanPelayanan->tarif_tindakan = $modTindakanPelayanan->qty_tindakan * $modTindakanPelayanan->tarif_satuan;
      
                  if ($modTindakanPelayanan->validate()) {
                    if ($modTindakanPelayanan->save()) {
                      $ok = true;
                      // $modTindakanPelayanan->saveTindakanKomponen2();
                    }
                  }
                }
              }

              /* ================================================ */
    
              /** AWAL
               * Notifikasi Antar Poliklinik, notifikasi ditampilkan ke polik tujuan
               * 
               * 
               */
    
              $judul = 'Pasien Ruangan Tindakan';

              $isi = 'Pasien ' . $modPasien->nama_pasien . ' dengan nomor rekam medik ' . $modPasien->no_rekam_medik . ' telah ditujukan ke ruangan ' . $modKirimKeUnitLain->ruangan->ruangan_nama . ' pada ' . $modKirimKeUnitLain->tgl_kirimpasien . ' dari ' . $modPendaftaran->ruangan->ruangan_nama;
    
              // $ruangan = RuanganM::model()->findByAttributes(array('ruangan_id'=>$modKirimKeUnitLain->ruangan_id));
              $ruangan2 = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);
              
    
    
              // $ok_notif = CustomFunction::broadcastNotif($judul, $isi, array(
              //   array('instalasi_id' => $ruangan->instalasi_id ?? "", 'ruangan_id' => $ruangan->ruangan_id, 'modul_id' => $ruangan->modul_id ?? ""),
              // ));


              $ok_notif2 = CustomFunction::broadcastNotif($judul, $isi, array(
                array('instalasi_id' => $ruangan2->instalasi_id, 'ruangan_id' => $ruangan2->ruangan_id, 'modul_id' => $ruangan2->modul_id),
              ));
    
    
            } else {
            //  var_dump($modKonsul->errors);
              $ok = false;
            }
          } else {
          //  var_dump($modKonsul->errors);
            $ok = false;
          }
          
       // }
        
        
      }

    //  var_dump($ok); die;

      if ($ok) {
        $transaction->commit();
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'idPasienKirimKeUnitLain' => $modKirimKeUnitLain->pasienkirimkeunitlain_id, 'sukses' => 1));
      } else {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }

    $modRiwayatPasienKeunitLain = PasienkirimkeunitlainT::model()->with('ruangan')->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), ['condition' => 'is_tindakan is true', 'order' => 'tgl_kirimpasien DESC']);

    $this->render($this->path_view . 'index', array(
      'modKirimKeUnitLain' => $modKirimKeUnitLain,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modKonsul' => $modKonsul,
      'karcisTindakan' => $karcisTindakan,
      'modRiwayatPasienKeunitLain' => $modRiwayatPasienKeunitLain,
      'modelPendaftaran' => $modelPendaftaran,
      'modKonsulPoli' => $modKonsulPoli, //added  - data ini digunakan untuk membuat notifikasi yang dikirim untuk ruangan asal
      'modJenisTarif' => $modJenisTarif,
      'modRiwayatKonsul' => $modRiwayatKonsul

    ));
  }


  public function actionAjaxDetailKonsul()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $konsulantarpoli_id = $_POST['idKonsulAntarTindakan'];
      $modKonsulPoli = RIRuangTindakan::model()->findByPk($konsulantarpoli_id);
      $modPendaftaran = RIPendaftaranT::model()->findByPk($modKonsulPoli->pendaftaran_id);
      $data['result'] = $this->renderPartial($this->path_view . '_viewRuangTindakan', array('modKonsul' => $modKonsulPoli, 'modPendaftaran' => $modPendaftaran), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * Detail hasil jawaban konsul poli dengan fungsi ajax
   */

  // public function actionIndex($pengperawatanlinen_id = null, $linkHalaman = null)
  // {
  //   $this->pageTitle = Yii::app()->name . " - Pengajuan Perawatan";
  //   $format = new MyFormatter;
  //   if (isset($pengperawatanlinen_id)) {
  //     $model = LAPengperawatanlinenT::model()->findByPk($pengperawatanlinen_id);
  //     $model->pegawaimengajukan_nama = isset($model->mengajukan_id) ? $model->pegawaiMengajukan->nama_pegawai : '';
  //     $model->pegawaimengetahui_nama = isset($model->mengetahui_id) ? $model->pegawai->nama_pegawai : '';
  //   } else {
  //     $model = new LAPengperawatanlinenT;
  //     $model->pengperawatanlinen_no = MyGenerator::noPengPerawatanLinen();
  //     $model->pengperawatanlinen_id =  Yii::app()->user->getState('pegawai_id');
  //     $model->pegawaimengajukan_nama = PegawaiM::model()->findByPk($model->pengperawatanlinen_id )->nama_pegawai;
  //   }   


  public function actionAjaxDetailKonsulHasil()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idKonsulAntarTindakan = $_POST['idKonsulAntarTindakan'];
      $modKonsulPoli = RIRuangTindakan::model()->findByPk($idKonsulAntarTindakan);
      $modMorbiditas = RIPasienMorbiditasT::model()->findAllByAttributes(array(
        'pendaftaran_id' => $modKonsulPoli->pendaftaran_id,
        'ruangan_id' => $modKonsulPoli->ruangan_id,
      ));
      if (!empty($modKonsulPoli->pegawaiordertindakan_id)) {
        $modKonsulPoli->nama_pegawai = PegawaiM::model()->findByPk($modKonsulPoli->pegawaiordertindakan_id)->nama_pegawai;
      }

      $data['result'] = $this->renderPartial($this->path_view . '_viewRuangTindakanHasil', array('modKonsul' => $modKonsulPoli, 'modMorbiditas' => $modMorbiditas), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionAjaxBatalKonsul()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $konsulantarpoli_id = (isset($_POST['idKonsulAntarTindakan']) ? $_POST['idKonsulAntarTindakan'] : null);
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);

      $tindakanpelayanan = RITindakanPelayananT::model()->findByAttributes(array('konsulpoli' => $konsulantarpoli_id));
      if (!empty($tindakanpelayanan)) {
        TindakankomponenT::model()->deleteAllByAttributes(array('tindakanpelayanan_id' => $tindakanpelayanan->tindakanpelayanan_id));
        RITindakanPelayananT::model()->deleteByPk($tindakanpelayanan->tindakanpelayanan_id);
      }

      RIRuangTindakan::model()->deleteByPk($konsulantarpoli_id);
      $modRiwayatKonsul = RIRuangTindakan::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

      $data['result'] = $this->renderPartial($this->path_view . '_listRuangTindakan', array('modRiwayatKonsul' => $modRiwayatKonsul), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * ajax untuk menampilkan tarif tindakan konsultasi poliklinik
   */
  public function actionAjaxSetTarif()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $penjamin_id = (isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : null);
      $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
      $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
      $ruangan = RuanganM::model()->findByPk($ruangan_id);
      $ruangan_nama = $ruangan->ruangan_nama;
      $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $penjamin_id)->jenistarif_id;

      $criteria = new CDbCriteria();
      $criteria->addCondition('t.komponentarif_id =' . Params::KOMPONENTARIF_ID_TOTAL);
      $criteria->addCondition('d.daftartindakan_konsul = true and d.daftartindakan_karcis = true');
      $criteria->join = "join daftartindakan_m d on t.daftartindakan_id = d.daftartindakan_id";



      if (!empty($kelaspelayanan_id)) {
        $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
      }
      if (!empty($jenistarif)) {
        $criteria->addCondition("jenistarif_id = " . $jenistarif);
      }
      // var_dump($criteria); die;
      $model = TariftindakanM::model()->findAll($criteria);

      $data['result'] = $this->renderPartial($this->path_view . '_listTarifRuangan', array('model' => $model, 'ruangan_nama' => $ruangan_nama), true);
      $data['dokter'] = $this->loadDokterRuangan($ruangan_id);


      echo json_encode($data);
      Yii::app()->end();
    }
  }

  protected function loadDokterRuangan($ruangan_id)
  {
    $dokter = DokterV::model()->findAllByAttributes(array(
      'pegawai_aktif' => true,
      'ruangan_id' => $ruangan_id,
    ));
    $dat = CHtml::listData($dokter, 'pegawai_id', 'namaLengkap');
    $str = count((array)$dat) > 1 ? '<option value="">-- Pilih --</option>' : '';
    foreach ($dat as $val => $item) {
      $str .= '<option value="' . $val . '">' . $item . '</option>';
    }

    return $str;
  }

  public function actionPrint()
  {
    $modKonsul = new RIRuangTindakan;
    $pendaftaran_id = (isset($_GET['id']) ? $_GET['id'] : null);
    $ruangtindakan_id = (isset($_GET['idKonsulTindakan']) ? $_GET['idKonsulTindakan'] : null);
    $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);

    //            $modKonsulPoli = RIKonsulPoliT::model()->findByPk($idKonsulAntarTindakan);
    $modRiwayatKonsul = RIRuangTindakan::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangtindakan_id' => $ruangtindakan_id));

    $judulLaporan = 'Permintaan Ruangan Tindakan';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionPrintRiwayat()
  {
    $modKonsul = new RIRuangTindakan;
    $pendaftaran_id = (isset($_GET['id']) ? $_GET['id'] : null);
    $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
    $modRiwayatKonsul = RIRuangTindakan::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $judulLaporan = 'Permintaan Ruangan Tindakan';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printRiwayat', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printRiwayat', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printRiwayat', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKonsul' => $modRiwayatKonsul, 'modKonsul' => $modKonsul, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  // Uncomment the following methods and override them if needed
  /*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
